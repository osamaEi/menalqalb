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
        html {
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

<div id="rootElement" lang="en_US">
    <img src="{{ asset('app/img/curve2.png')}}" class="z-50 w-[106px] absolute" alt="">

<a href="{{ route('app.home')}}" class="z-[9999999999999] !p-2 !absolute left-0 !mt-2 icondoor">
<i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
</a>

    <body class="">
        <div class="app white messagebox">
            <div class="header">

                <a href="#"><img src="{{ asset('app/img/black.png') }}" alt="" class="img-fluid logo"></a>
            </div>
            
            @yield('content')
            
        </div>
    </body>
</div>
</html>