@extends('app.index')

@section('content')
        <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">{{__('Verify the WhatsApp code')}}</h1>
        <p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
            {{__('Enter the 4-digit verification code we sent to your WhatsApp number')}} {{ $phone }}
        </p>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4">
                <div class="All_Button lang Devices">
                    <div class="rounded-lg p-8 w-full">
                        @if (session('success'))
                            <div class="text-green-500 text-center mb-4">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            Additional Debugging
                            <div class="text-red-500 text-center mb-4">{{ session('error') }}</div>
                        @endif
                        <form class="space-y-6" method="POST" action="{{ route('app.forgot-password.verify') }}">
                            @csrf
                            <div class="flex justify-center">
                                <input type="text" name="otp" maxlength="4" class="w-48 h-12 text-center text-lg border border-gray-300 rounded-[9px] focus:outline-none focus:ring-2 focus:ring-blue-500" inputmode="numeric" pattern="[0-9]{4}" required>
                            </div>
                            @error('otp')
                                <span class="text-red-500 text-sm text-center block">{{ $message }}</span>
                            @enderror
                            <div class="flex justify-center">
                                <button type="submit" class="!m-0 !h-[55px] !w-[100%] mt-0 !font-[400] flex items-center justify-center !bg-[#B62326] text-white font-bold !rounded-full hover:bg-[#B62326]-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                    {{__('Verify')}}
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-5">
                            <form method="POST" action="{{ route('app.forgot-password.resend') }}" class="inline">
                                @csrf
                                <button type="submit" class="!text-[#B62326] !border-0 text-[16px] !font-[400]">{{__('Resend the code')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection