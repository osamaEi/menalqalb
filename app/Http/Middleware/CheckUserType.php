<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$types
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('app.login');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user's type is in the allowed types
        if (in_array($user->user_type, $types)) {
            return $next($request);
        }

        // If user type is not allowed, redirect based on their type
        switch ($user->user_type) {
            case 'privileged_user':
            case 'sales_point':
            case 'regular_user':
                return redirect()->route('app.home')
                    ->with('error', 'You do not have permission to access this area.');

            case 'designer':
                return redirect()->route('dashboard.designer.index')
                    ->with('error', 'You do not have permission to access this area.');

            case 'admin':
            default:
                return redirect()->route('dashboard.index')
                    ->with('error', 'You do not have permission to access this area.');
        }
    }
}