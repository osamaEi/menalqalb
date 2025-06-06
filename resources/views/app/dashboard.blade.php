<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('app/img/logo.png')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="sass/style.css" rel="stylesheet">
    <!-- <link href="sass/style-ar.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title> MIN ALQALB ❤ من القلب </title>
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
</head>

<div id="rootElement" lang="en">
    <img src="{{ asset('app/img/curve2.png')}}" class="z-50 w-[106px] absolute" alt="">

    <a href="{{ route('app.home')}}" class="z-50 !p-2 !absolute left-0 !mt-2 icondoor">
        <i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
    </a>

    <body class="">
        <div class="app white messagebox pb-[25px] !overflow-auto">
            <div class="header !mb-0">
                <a href="index.html"><img src="{{ asset('app/img/black.png')}}" alt="" class="img-fluid logo"></a>
            </div>
            <p
                class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
                {{__('Control Panel')}}
            </p>

            <div
                class="flex items-center justify-between !bg-transparent p-3 text-center shadow-lg mt-0 rounded-[13px] mx-2 relative">

                <div>
                    <p class="relative font-bold text-[#B62326]">{{__('Special Cards')}}</p>
                    <p class="font-bold text-[#4B4B4B]">

                     @php
$totalItemsCount = \App\Models\ReadyCardItem::whereHas('readyCard', function($query) {
    $query->where('customer_id', auth()->user()->id);
})->count();                         
                     @endphp

{{$totalItemsCount}}
                        
                    </p>
                    <p class="relative mt-1 font-bold text-[#B62326]">
                        {{__('Account Type')}}
                    </p>
                    <p class="font-bold text-[#4B4B4B]">
                        {{ __(auth()->user()->user_type)}}
                    </p>
                </div>
                <div class="h-[90px] w-[1px] bg-[#C5C5C5]"></div>
                <div>
                    <p class="relative font-bold text-[#B62326]">{{__('Greetings Count')}}</p>
                    <p class="font-bold text-[#4B4B4B]">

                        @php
                            $messagesCount = \App\Models\Message::where('user_id',auth()->user()->id)->count();
                        @endphp
                      {{ $messagesCount}}
                    </p>
                    <p class="relative mt-1 font-bold text-[#B62326]">
                        {{__('Registration Date')}}
                    </p>
                    <p class="font-bold text-[#4B4B4B]">
                        {{auth()->user()->created_at->toDateString();}}
                    </p>
                </div>
                <div class="h-[90px] w-[1px] bg-[#C5C5C5]"></div>

                <div>
                    <p class="bg-[#B62326] text-[#FFF] p-2 relative right-[-16px] top-[-20px]"
                        style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">{{__('Dashboard')}}</p>
                    <p class="relative top-[-6px] font-bold text-[#B62326]">
                        {{__('Membership Number')}}
                    </p>
                    <p class="font-bold text-[#4B4B4B]">{{auth()->user()->unique_id}}</p>
                </div>
            </div>
            <div
                class="flex items-center justify-between !bg-transparent p-3 text-center shadow-lg rounded-[13px] mx-2 relative">
                <a href="{{ route('app.profile.edit')}}" class="bg-[#000] text-[#FFF] p-2"
                    style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
                    {{__('Edit Profile')}}
                </a>
                {{auth()->user()->name}}
            </div>

            <div
                class="bg-[#B62326] rounded-[12px] w-[330px] h-[48px] mx-auto flex items-center justify-between px-3 mt-3">
                <span class="text-[#FFF] text-[15px]">{{__('Point')}}</span>
                <span class="text-[#FFF] text-[32px]">{{auth()->user()->credits_package}}</span>
                <span class="text-[#FFF] text-[15px]">{{__('Available Points')}}</span>
            </div>
            <div class="flex flex-col items-center justify-between p-3 m-0 text-center mx-2 relative">
                <div class="flex gap-3 justify-between items-center h-[30px]">
                    <div>
                        <a href="{{ route('app.profile.delete-confirmation') }}"
                            class="bg-[#000] text-[#FFF] p-2 rounded-[13px] w-[141px] mx-auto mt-0">
                            {{__('Delete Account')}}
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('packages.index')}}" class="bg-[#000] text-[#FFF] p-2 rounded-[13px] w-[141px] mx-auto mt-0">
                            {{__('Recharge Balance')}}
                        </a>
                    </div>
                </div>
                <a href="#" class="text-[#B62326] mx-auto mt-3">
                    {{__('Total Greetings Count')}} {{$messagesCount}}
                </a>
            </div>

            <div class="justify-center !mx-auto flex gap-3">
                <div style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;"
                    class="w-[162px] h-[80px] bg-[#B62326] flex flex-col text-white text-center items-between justify-between py-2">
                    <p>
                        <a href="{{ route('min-alqalb.cards.index')}}">
                            {{__('Special Cards')}}
                        </a>
                    </p>

                    @php
                    $read_cards = \App\Models\ReadyCard::where('customer_id', Auth::id())->get();
    
                    // Fetch ReadyCardItem records related to the user's ReadyCards
                    $ready_card_items = \App\Models\ReadyCardItem::whereIn('ready_card_id', $read_cards->pluck('id'))->get();

                    @endphp
                    
                    <p>{{$ready_card_items->count() }}</p>
                </div>
                <div style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;"
                    class="w-[162px] h-[80px] bg-[#B62326] flex flex-col text-white text-center items-between justify-between py-2">
                    <p>
                        <a href="{{ route('app.greetings.index')}}">
                            {{__('Sent Greetings')}}
                        </a>
                    </p>
                    <p>
                        {{ $messagesCount}}
                    </p>
                </div>
            </div>
            <div class="justify-center !mx-auto mt-3 flex gap-3">
                <div style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;"
                    class="w-[162px] h-[80px] bg-[#B62326] flex flex-col text-white text-center items-between justify-between py-2">
                    <p>
                        <a href="{{ route('app.bills.index')}}">
                            {{__('Bills')}}
                        </a>
                    </p>
                    @php
                    $user = auth()->user()->load('bills');
                    @endphp


<p>{{ $user->bills->count() }}</p>

</div>
                <div style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;"
                    class="w-[162px] h-[80px] bg-[#B62326] flex flex-col text-white text-center items-between justify-between py-2">
                    <p>
                        <a href="{{ route('min-alqalb.lockers.index')}}">
                            {{__('Locks')}}
                        </a>
                    </p>
                    <p>123</p>
                </div>
            </div>

            <div class="made">
                <img src="{{ asset('app/img/omda logo.svg')}}" class="h-[129px] mt-5 mx-auto d-block" alt="">
            </div>
        </div>
    </body>

</html>