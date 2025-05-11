<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   /**
 * Handle an incoming authentication request.
 *
 * @param  \App\Http\Requests\Auth\LoginRequest  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    // Check if the user status is active
    $user = auth()->user();
    
    if ($user->status !== 'active') {
        // Log the user out if not active
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('app.login')
            ->withErrors(['email' => 'الحساب لديك غير فعال']);
    }
    
    $request->session()->regenerate();
    
    // Redirect based on user type
    switch ($user->user_type) {
        case 'privileged_user':
        case 'sales_point':
        case 'regular_user':
            return redirect()->route('app.home');
            
        case 'designer':
            return redirect()->route('dashboard.designer.index');
            
        case 'admin':
            return redirect()->route('dashboard.index');

        default:
            return redirect()->route('welcome');
    }
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
