<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // If not authenticated at all, return 404
        if (!Auth::check()) {
            abort(404);
        }
        
        // If authenticated but not admin, also return 404
        if (Auth::user()->user_type !== 'admin') {
            return response()->view('errors.404', [], 404);
        
        }
        
        return $next($request);
    }
}