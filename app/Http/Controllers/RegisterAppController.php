<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;


class RegisterAppController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    } 

    /**
     * Step 1: Show the initial registration form
     */
    public function showRegistrationForm()
    {
        return view('app.auth.register');
    }

    /**
     * Step 1: Handle the initial registration form submission
     */
    public function submitRegistrationForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'country_id' => 'required|string|max:255',
            'user_type' => 'required|string|in:regular_user,privileged_user,sales_point',
            'company_name' => 'nullable|required_if:user_type,sales_point|string|max:255',
        ]);

        // Store the registration data in the session
        Session::put('registration_data', $validated);

        // Redirect to the phone verification step
        return redirect()->route('app.register.phone');
    }

    /**
     * Step 2: Show the phone number form
     */
    public function showPhoneForm()
    {
        // Check if we have registration data
        if (!Session::has('registration_data')) {
            return redirect()->route('app.register');
        }

        return view('app.auth.phone');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();
    
        if (!$user) {
            return redirect()->route('app.login')->with('error', 'Invalid or expired verification link.');
        }
    
        $user->email_verified = true;
        $user->email_verification_token = null;
        $user->save();
    
        return redirect()->route('app.login')->with('success', 'Email verified successfully. You can now log in.');
    }
    
    /**
     * Step 2: Handle the phone number form submission
     */
    public function submitPhoneForm(Request $request)
    {
        $validated = $request->validate([
            'country_code' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        // Format the phone number with the country code
        $fullPhoneNumber = $validated['country_code'] . $validated['phone_number'];
        
        // Store the phone number in the session
        Session::put('whatsapp', $fullPhoneNumber);

        // Generate a 4-digit OTP
        $otp = rand(1000, 9999);
        Session::put('otp', $otp);
        Session::put('otp_generated_at', now());

        // Send the OTP via WhatsApp
        $response = $this->sendOtpViaWhatsApp($fullPhoneNumber, $otp);

        // Check if the WhatsApp message was sent successfully
        if (!isset($response['success']) || !$response['success']) {
            return back()->withErrors(['phone_number' => 'Failed to send OTP. Please try again.']);
        }

        // Redirect to the OTP verification page
        return redirect()->route('app.register.otp');
    }

    /**
     * Step 3: Show the OTP verification form
     */
    public function showOtpForm()
    {
        // Check if we have registration data and phone number
        if (!Session::has('registration_data') || !Session::has('whatsapp') || !Session::has('otp')) {
            return redirect()->route('app.register');
        }

        $phone = Session::get('whatsapp');
        
        return view('app.auth.otp', ['phone' => $phone]);
    }

    /**
     * Step 3: Handle the OTP verification form submission
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => 'required',
        ]);
    
        $submittedOtp = trim($validated['otp']);
        $storedOtp = trim(Session::get('otp'));
        $otpGeneratedAt = Session::get('otp_generated_at');
    
        if (!$storedOtp || !$otpGeneratedAt) {
            return back()->withErrors(['otp' => 'حدث خطأ. يرجى طلب رمز جديد.']);
        }
    
        // Check if OTP has expired
        if (now()->diffInMinutes($otpGeneratedAt) > 5) {
            return back()->withErrors(['otp' => 'انتهت صلاحية رمز التحقق. الرجاء طلب رمز جديد.']);
        }
    
        // Check if the OTP matches
        if ((int)$submittedOtp !== (int)$storedOtp) {
            return back()->withErrors(['otp' => 'رمز التحقق غير صحيح. حاول مرة أخرى.']);
        }
    
        // Mark as verified
        Session::put('whatsapp_verified', true);
        return redirect()->route('app.register.password');
    }
    
/**
 * Verify OTP for password reset
 */
public function verifyForgotPasswordOtp(Request $request)
{
    $validated = $request->validate([
        'otp' => 'required|numeric',
    ]);

    $submittedOtp = trim($validated['otp']);
    $storedOtp = trim(Session::get('password_reset_otp'));
    $otpGeneratedAt = Session::get('otp_generated_at_reset');

    if (!$storedOtp || !$otpGeneratedAt) {
        return back()->withErrors(['otp' => 'حدث خطأ. يرجى طلب رمز جديد.']);
    }

    // Check if OTP expired (5 minutes)
    if (now()->diffInMinutes($otpGeneratedAt) > 5) {
        return back()->withErrors(['otp' => 'انتهت صلاحية رمز التحقق. الرجاء طلب رمز جديد.']);
    }

    // Match OTP
    if ((int)$submittedOtp !== (int)$storedOtp) {
        return back()->withErrors(['otp' => 'رمز التحقق غير صحيح. حاول مرة أخرى.']);
    }

    // Mark phone as verified for password reset
    Session::put('forgot_password_verified', true);

    return redirect()->route('app.forgot-password.reset'); // Route to the password reset form
}

    /**
     * Step 4: Show the password form
     */
    public function showPasswordForm()
    {
        // Check if we have verified the phone
        if (!Session::has('registration_data') || !Session::has('whatsapp_verified') || !Session::get('whatsapp_verified')) {
            return redirect()->route('register');
        }

        return view('app.auth.password');
    }

    /**
     * Step 4: Handle the password form submission and complete registration
     */

    public function completeRegistration(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8',
        ]);
    
        $registrationData = Session::get('registration_data');
        $whatsapp = Session::get('whatsapp');
    
        // Generate a unique email verification token
        $token = Str::random(64);
    
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'whatsapp' => $whatsapp,
            'country_id' => $registrationData['country_id'],
            'user_type' => $registrationData['user_type'],
            'company_name' => $registrationData['company_name'] ?? null,
            'password' => Hash::make($validated['password']),
            'whatsapp_verified' => true,
            'email_verified' => false,
            'status' => 'inactive',
            'email_verification_token' => $token,
            'unique_id' => $this->generateUniqueId(), // Add this line
        ]);
    
        // Send custom verification email
       // Mail::to($user->email)->send(new VerifyEmail($user));
    
        Session::forget(['registration_data', 'whatsapp', 'otp', 'otp_generated_at', 'whatsapp_verified']);
    
        return redirect()->route('app.register.complete')->with('status', 'Check your email to verify your account.');
    }

    private function generateUniqueId()
{
    do {
        $uniqueId = 'U' . strtoupper(Str::random(8)); // e.g., UABC123XY
    } while (User::where('unique_id', $uniqueId)->exists());

    return $uniqueId;
}


    /**
     * Step 5: Show registration complete page
     */
    public function showCompletePage()
    {
        return view('app.auth.completion');
    }

    /**
     * Resend OTP via WhatsApp
     */
    public function resendOtp()
    {
        // Check if we have phone number
        if (!Session::has('whatsapp')) {
            return redirect()->route('app.register');
        }

        $whatsapp = Session::get('whatsapp');
        
        // Generate a new 4-digit OTP
        $otp = rand(1000, 9999);
        Session::put('otp', $otp);
        Session::put('otp_generated_at', now());

        // Send the OTP via WhatsApp
        $response = $this->sendOtpViaWhatsApp($whatsapp, $otp);

        // Check if the WhatsApp message was sent successfully
        if (!isset($response['success']) || !$response['success']) {
            return back()->withErrors(['message' => 'Failed to send OTP. Please try again.']);
        }

        return back()->with('success', 'New OTP sent successfully!');
    }

    /**
     * Helper method to send OTP via WhatsApp
     */
    private function sendOtpViaWhatsApp($phoneNumber, $otp)
    {
        // Use the WhatsApp service to send the OTP
        return $this->whatsAppService->sendOtpTemplate($phoneNumber, $otp);
    }
}