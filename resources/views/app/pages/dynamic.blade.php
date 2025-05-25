<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ url('app/img/black.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('app/sass/style.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>MIN ALQALB ❤ من القلب</title>
    <style>
        body,
        html ,h1{
            font-family: 'Cairo' !important;
        }

        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
        }

        .flag-icon { 
            width: 40px;
            height: 24px;
            background-size: cover;
        }
    </style>
    @yield('extra-styles')
</head>


    <body class="">
        <div class="app white messagebox">
            <div class="header">

                <a href="#"><img src="{{ asset('app/img/black.png') }}" alt="" class="img-fluid logo"></a>
            </div>
        <div class="app white messagebox">
<div class="app white messagebox">
    <div class="row justify-content-center">
        <div class="container mx-auto px-4 py-8">
            <!-- Page Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $title }}</h1>
                    <h2 class="text-xl text-gray-600">
                        {{ App::getLocale() === 'ar' ? $page->subtitle_ar : $page->subtitle_en }}
                    </h2>
            </div>

            <!-- Page Content -->
            <div class="prose max-w-none mx-auto">
                {!!  App::getLocale() === 'ar' ? $page->description_ar : $page->description_en !!}
            </div>

            <!-- Last Updated (optional) -->
            @isset($page->updated_at)
                <div class="mt-8 pt-4 border-t border-gray-200 text-sm text-gray-500">
                    {{ __('Last updated') }}: {{ $page->updated_at->format('F j, Y') }}
                </div>
            @endisset
        </div>
    </div>
</div>
        </div>
    </body>
</html>