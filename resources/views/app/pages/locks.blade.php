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

        body ,h1{
            font-family: 'Cairo', sans-serif;
        }

        .flag-icon { 
            width: 40px;
            height: 24px;
            background-size: cover;
        }
    </style>
</head>

<div id="rootElement" lang="en_US">
    <img src="{{ asset('app/img/curve2.png')}}" class="z-50 w-[106px] absolute" alt="">

<a href="{{ route('app.prices')}}" class="z-[9999999999999] !p-2 !absolute left-0 !mt-2 icondoor">
<i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
</a>

    <body class="">
        <div class="app white messagebox">
            <div class="header">

                <a href="#"><img src="{{ asset('app/img/black.png') }}" alt="" class="img-fluid logo"></a>
            </div>
       
<div class="app white messagebox">
   
    <h1 class="">{{ __('Locks from the Heart') }}</h1>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <div class="flex items-center justify-between">
                    <!-- Add any buttons here if needed -->
                </div>

                <div class="max-w-6xl mx-auto mt-6">
                   
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($locks as $request)
                            <div data-status="{{ $request->status == 'pending' ? 'available' : $request->status }}" class="bg-white rounded-lg shadow p-6 flex flex-col items-center hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('min-alqalb.lockers.finish') }}'">
                                @if ($request->photo)
                                    <img src="{{ asset('storage/' . $request->photo) }}" alt="{{ __('Lock Image') }}" class="w-24 h-24 object-cover rounded-full mb-4">
                                @else
                                    <img src="{{ asset($request->status == 'used' ? 'img/grean-l.png' : 'img/red-l.png') }}" alt="{{ __('Status Icon') }}" class="w-[30px] mb-4">
                                @endif
                                <h3 class="text-lg font-bold text-gray-800">{{ $request->name_ar ?? __('Lock') }}</h3>
                                <p class="text-sm text-gray-600">{{ $request->desc_ar ?? __('No Description') }}</p>
                                <div class="mt-4 text-right w-full">
                                    @if ($request->price)
                                        <p class="text-sm font-medium text-gray-700">
                                            <span class="font-bold">{{ __('Price') }}:</span> {{ $request->price }} {{ __('AED') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Success/Error/Info Messages -->
    @if(session('success'))
        <div class="notification fixed bottom-0 left-0 right-0 bg-green-500 text-white p-4 text-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="notification fixed bottom-0 left-0 right-0 bg-red-500 text-white p-4 text-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif
    @if(session('info'))
        <div class="notification fixed bottom-0 left-0 right-0 bg-blue-500 text-white p-4 text-center">
            <i class="fas fa-info-circle mr-2"></i>
            {{ session('info') }}
        </div>
    @endif

    <style>
        .page-title {
            position: relative;
        }
        .page-title::after {
            content: "";
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 60px;
            height: 4px;
            background-color: #B62326;
            border-radius: 2px;
        }
        .header-logo {
            transition: transform 0.3s ease;
        }
        .header-logo:hover {
            transform: scale(1.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusFilter = document.getElementById('statusFilter');
            const cards = document.querySelectorAll('.grid > div');

            statusFilter.addEventListener('change', filterCards);

            function filterCards() {
                const selectedStatus = statusFilter.value;
                cards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    if (selectedStatus === 'all' || selectedStatus === cardStatus) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        });

        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(notification => notification.remove());
        }, 5000);
    </script>
</div>
</html>