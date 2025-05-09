<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAppController extends Controller
{
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

        // Format the phone number if needed (Add country code if not present)
        $whatsapp = $credentials['whatsapp'];
        if (!empty($request->country_code) && strpos($whatsapp, $request->country_code) !== 0) {
            $whatsapp = $request->country_code . $whatsapp;
        }

        // Attempt to login
        if (Auth::attempt(['whatsapp' => $whatsapp, 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            
            // Redirect to the intended page or home
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
        ]);

        // Format the phone number if needed
        $whatsapp = $request->whatsapp;
        if (!empty($request->country_code) && strpos($whatsapp, $request->country_code) !== 0) {
            $whatsapp = $request->country_code . $whatsapp;
        }

        // Check if user exists
        $user = User::where('whatsapp', $whatsapp)->first();
        
        if (!$user) {
            return back()->withErrors([
                'whatsapp' => 'لم يتم العثور على حساب مرتبط بهذا الرقم.',
            ])->withInput();
        }

        // Here you would typically:
        // 1. Generate a reset token
        // 2. Send OTP via WhatsApp
        // 3. Store token in password_resets table
        
        // For now, we'll just redirect to a success page
        return redirect()->route('app.login')->with('status', 'تم إرسال رمز استعادة كلمة المرور إلى رقم الواتساب الخاص بك.');
    }
}