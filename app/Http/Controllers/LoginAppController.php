<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginAppController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('app.auth.login');
    } 

    /**
     * Handle the login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'whatsapp' => 'required',
            'password' => 'required',
        ]);

        // Format the phone number if needed
        $whatsapp = $credentials['whatsapp'];
        if (!empty($request->country_code) && strpos($whatsapp, $request->country_code) !== 0) {
            $whatsapp = $request->country_code . $whatsapp;
        }

        // Attempt to login
        if (Auth::attempt(['whatsapp' => $whatsapp, 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('app/home');
        }

        // Authentication failed
        return back()->withErrors([
            'whatsapp' => 'بيانات الدخول غير صحيحة.',
        ])->withInput($request->only('whatsapp'));
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('app.login');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('app.auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required',
            'country_code' => 'required',
        ]);

        // Format the phone number
        $whatsapp = $request->country_code . $request->whatsapp;

        // Check if user exists
        $user = User::where('whatsapp', $whatsapp)->first();
        
        if (!$user) {
            return back()->withErrors([
                'whatsapp' => 'لم يتم العثور على حساب مرتبط بهذا الرقم.',
            ])->withInput();
        }

        // Generate a 4-digit OTP
        $otp = rand(1000, 9999);
        Session::put('password_reset_otp', $otp);
        Session::put('password_reset_whatsapp', $whatsapp);
        Session::put('otp_generated_at', now());

        // Send OTP via WhatsApp
        $response = $this->whatsAppService->sendOtpTemplate($whatsapp, $otp);

        if (!isset($response['success']) || !$response['success']) {
            return back()->withErrors(['whatsapp' => 'فشل إرسال رمز التحقق. حاول مرة أخرى.']);
        }

        return redirect()->route('app.forgot-password.otp');
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        if (!Session::has('password_reset_whatsapp') || !Session::has('password_reset_otp')) {
            return redirect()->route('app.forgot-password');
        }

        $phone = Session::get('password_reset_whatsapp');
        return view('app.auth.forgot-password-otp', ['phone' => $phone]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required',
        ]);

        $submittedOtp = trim($validated['otp']); // Trim any whitespace
        $storedOtp = Session::get('password_reset_otp');
        $otpGeneratedAt = Session::get('otp_generated_at');

        // Log for debugging
        Log::debug('OTP Verification', [
            'submitted_otp' => $submittedOtp,
            'stored_otp' => $storedOtp,
            'submitted_otp_type' => gettype($submittedOtp),
            'stored_otp_type' => gettype($storedOtp),
        ]);

        // Check if OTP has expired (5 minutes)
        if (now()->diffInMinutes($otpGeneratedAt) > 5) {
            return back()->withErrors(['otp' => 'انتهت صلاحية رمز التحقق. الرجاء طلب رمز جديد.']);
        }

        // Check if the OTP matches
        if ((int)$submittedOtp !== (int)$storedOtp) {
            return back()->withErrors(['otp' => 'رمز التحقق غير صحيح. حاول مرة أخرى.']);
        }

        // Mark as verified
        Session::put('whatsapp_verified', true);
        return redirect()->route('app.forgot-password.reset');
    }

    /**
     * Show password reset form
     */
    public function showResetPasswordForm()
    {
        if (!Session::has('password_reset_whatsapp') || !Session::has('whatsapp_verified') || !Session::get('whatsapp_verified')) {
            return redirect()->route('app.forgot-password');
        }

        return view('app.auth.reset-password');
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $whatsapp = Session::get('password_reset_whatsapp');
        $user = User::where('whatsapp', $whatsapp)->first();

        if (!$user) {
            return redirect()->route('app.forgot-password')->withErrors(['whatsapp' => 'لم يتم العثور على حساب مرتبط بهذا الرقم.']);
        }

        // Update password
        $user->password = Hash::make($validated['password']);
        $user->save();

        // Clear session
        Session::forget(['password_reset_otp', 'password_reset_whatsapp', 'otp_generated_at', 'whatsapp_verified']);

        return redirect()->route('app.login')->with('status', 'تم إعادة تعيين كلمة المرور بنجاح. يمكنك الآن تسجيل الدخول.');
    }

    /**
     * Resend OTP
     */
    public function resendOtp()
    {
        if (!Session::has('password_reset_whatsapp')) {
            return redirect()->route('app.forgot-password');
        }

        $whatsapp = Session::get('password_reset_whatsapp');
        $otp = rand(1000, 9999);
        Session::put('password_reset_otp', $otp);
        Session::put('otp_generated_at', now());

        $response = $this->whatsAppService->sendOtpTemplate($whatsapp, $otp);

        if (!isset($response['success']) || !$response['success']) {
            return back()->withErrors(['message' => 'فشل إرسال رمز التحقق. حاول مرة أخرى.']);
        }

        return back()->with('success', 'تم إرسال رمز تحقق جديد بنجاح!');
    }
}