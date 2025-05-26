<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Language
{


public function handle(Request $request, Closure $next): Response
{
    if (session()->has('locale')) {
        $locale = session('locale');
    } elseif ($request->hasHeader('Accept-Language')) {
        $acceptedLanguages = explode(',', $request->header('Accept-Language'));
        $locale = strtolower(substr($acceptedLanguages[0], 0, 2));
    } else {
        $locale = config('app.locale', 'en');
    }

    App::setLocale($locale);

    return $next($request);
}

}