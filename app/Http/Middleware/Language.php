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
        $allowedLocales = ['ar', 'en'];

        if ($request->hasHeader('Accept-Language')) {
            $acceptedLanguages = explode(',', $request->header('Accept-Language'));
            $preferred = strtolower(substr($acceptedLanguages[0], 0, 2));

            $locale = in_array($preferred, $allowedLocales) ? $preferred : 'ar';
        } else {
            $locale = 'ar';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
