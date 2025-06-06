@extends('app.home2')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-4 ">
        <div class="All_Button lang Devices">
            <div>
                <div class="rounded-lg px-0 pb-8 w-full">
                    <div>
                        <img src="{{ asset('app/img/logos.png') }}" class="h-[289px] mx-auto" alt="" style="  margin-top: 39px;">
                    </div>
                

                    @if(auth()->user()->email_verified == 1)

                    <p class="text-center text-[24px] leading-[29px] max-w-[327px] my-2 mx-auto font-[900] text-[#242424] z-50 relative">
                        {{ __('it_means_a_lot_ar') }}
                    </p>
                
                    
                    <p class="text-center mb-2 text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 relative">
                        {{ __('it_means_a_lot_en') }}
                    </p>
                
                    <a href="{{ route('app.messages.create.step1') }}" class="!m-0 !mb-4 !h-[55px] !text-[14px] !w-[100%] !mt-[30px] !font-[500] flex items-center justify-center 
                        !bg-[#B62326] text-white font-bold !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                        focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                        {{ __('new_greeting') }}
                    </a>
                
                    <a href="{{ route('app.dashboard') }}" class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center 
                        !bg-[#B62326] text-white font-bold !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                        focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                        {{ __('dashboard') }}
                    </a>
                    @else 

                    <a  class="!m-0 !mb-4 !h-[55px] !text-[14px] !w-[100%] !mt-[30px] !font-[500] flex items-center justify-center 
                    !bg-[#B62326] text-white font-bold !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                    focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                    {{ __('you have to verify this email check you email') }}
                </a>
            

                    
                @endif
                    <form method="POST" action="{{ route('app.logout') }}">
                        @csrf
                        <button type="submit" class="!m-0 !h-[55px] !text-[14px] !w-[100%] !border-[#000] !mt-5 !font-[500] flex items-center justify-center 
                            !bg-[#000] text-white font-bold !rounded-full font-bold hover:bg-[#000]-700 transition-colors 
                            focus:outline-none focus:ring-2 focus:ring-[#000]-500 focus:ring-offset-2">
                            {{ __('logout') }}
                        </button>
                    </form>
                </div>
                
            </div>
            <div class="made">
                <img src="{{ asset('app/img/omda logo.svg') }}" class="h-[129px] mx-auto d-block" alt="">
            </div>
        </div>
    </div>
</div>
@endsection
