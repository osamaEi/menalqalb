@extends('app.index')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-4 ">
        <div class="All_Button lang Devices">
            <div>
                <div class="rounded-lg px-0 pb-8 w-full">
                    <div>
                    </div>

                    
                    <p class="text-center text-[24px] leading-[29px] max-w-[327px] my-2 mx-auto font-[900] text-[#242424] z-50 relative">
                       {{__('Prices')}}
                    </p>


                    <p class="text-center mb-2 text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 relative">
                    </p>
                    
                    <a href="{{ route('app.balances') }}" class="!m-0 !mb-[30px] !h-[55px] !text-[14px] !w-[100%] !font-[500] flex items-center justify-center 
                    !bg-[#B62326] text-white font-bold !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                    focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                 {{__('Prices For credits')}}
                </a>
                
                <a href="{{ route('app.cards') }}" class="!m-0 !mb-[30px] !h-[55px] !text-[14px] !w-[100%] !font-[500] flex items-center justify-center 
                    !bg-[#B62326] text-white font-bold !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                    focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                   {{__('Card prices')}}
                </a>

                <a href="{{ route('app.locks') }}" class="!m-0 !h-[55px] !text-[14px] !w-[100%] !font-[500] flex items-center justify-center 
                !bg-[#B62326] text-white font-bold !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                {{__('Locks prices')}}
            </a>
             
                </div>
            </div>
            <div class="made">
                <img src="{{ asset('app/img/omda logo.svg') }}" class="h-[129px] mx-auto d-block" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-styles')
<style>
    #rootElement, body {
        background-color: #ffffff !important;
    }
</style>
@endsection