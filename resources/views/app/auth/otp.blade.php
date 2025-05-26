@extends('app.index')

@section('content')
<h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">{{__('The login code has been sent')}}</h1>
<p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
    {{__('A 4-digit code has been sent to the application')}}
</p>
<p class="flex items-center justify-center text-center text-[14px] leading-[29px] 
    max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 relative">
    {{__('WhatsApp')}}
</p>
{{-- {{dd(session()->all())}}  --}}
<div class="row justify-content-center">
    <div class="col-12 col-lg-4 ">
        <div class="All_Button lang Devices">
            <div>
                <div class="rounded-lg px-0 pb-8 w-full">
                    <form class="space-y-6" method="POST" action="{{ route('app.register.otp') }}" id="otpForm">
                        @csrf
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('app.register.phone') }}" class="flex items-center justify-center !w-[68px] m-0 p-0 !text-[#B62326] !border-0 text-[16px] !font-[400]">
                                {{__('Change the number')}}
                            </a> 
                            <span class="text-[#C5C6FA]">|</span>
                            <p class="text-[#242424] font-bold">{{ session('whatsapp') }}</p>
                        </div>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        
                        <!-- Combined error message for OTP -->
                        @error('otp')
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ $message }}</span>
                            </div>
                        @enderror

                        <!-- Individual error messages for each OTP digit -->
                        @if($errors->has('otp0') || $errors->has('otp1') || $errors->has('otp2') || $errors->has('otp3'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{__('Please enter the complete verification code')}}</span>
                            </div>
                        @endif

                        <!-- Hidden field for combined OTP -->
                        <input type="hidden" name="otp" id="combinedOtp" value="">

                        <div>
                            <div class="flex justify-between items-center mb-8">
                                <input type="text" maxlength="1" name="otp0" placeholder="0"
                                    class="w-16 h-16 text-center text-2xl font-normal border !border-black rounded-full focus:border-blue-500 focus:outline-none mx-1 @error('otp0') border-red-500 @enderror"
                                    id="otp0" autofocus>
                                <input type="text" maxlength="1" name="otp1" placeholder="0"
                                    class="w-16 h-16 text-center text-2xl font-normal border !border-black rounded-full focus:border-blue-500 focus:outline-none mx-1 @error('otp1') border-red-500 @enderror"
                                    id="otp1">
                                <input type="text" maxlength="1" name="otp2" placeholder="0"
                                    class="w-16 h-16 text-center text-2xl font-normal border !border-black rounded-full focus:border-blue-500 focus:outline-none mx-1 @error('otp2') border-red-500 @enderror"
                                    id="otp2">
                                <input type="text" maxlength="1" name="otp3" placeholder="0"
                                    class="w-16 h-16 text-center text-2xl font-normal border !border-black rounded-full focus:border-blue-500 focus:outline-none mx-1 @error('otp3') border-red-500 @enderror"
                                    id="otp3">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center 
                            !bg-[#B62326] text-white font-bold
                            !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                            focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                {{__('Enter the password')}}
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-3">
                        <div>{{__('You can request the code again after')}}</div>
                        <div dir="ltr" class="text-xl font-normal" id="countdown">00 : 60</div>
                    </div>
                    
                    <form method="POST" action="{{ route('app.register.otp.resend') }}" class="mt-3">
                        @csrf
                        <button type="submit" id="resendBtn" disabled
                            class="text-[#5B186B] font-bold flex items-center justify-center mx-auto gap-2 opacity-50 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <path d="M16.5 9C16.5 13.14 13.14 16.5 9 16.5C4.86 16.5 2.3325 12.33 2.3325 12.33M2.3325 12.33H5.7225M2.3325 12.33V16.08M1.5 9C1.5 4.86 4.83 1.5 9 1.5C14.0025 1.5 16.5 5.67 16.5 5.67M16.5 5.67V1.92M16.5 5.67H13.17"
                                    stroke="#5B186B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{__('Resend')}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Get all input elements
    const inputs = [
        document.getElementById('otp0'),
        document.getElementById('otp1'),
        document.getElementById('otp2'),
        document.getElementById('otp3')
    ];

    // Function to update the combined OTP hidden field
    function updateCombinedOtp() {
        document.getElementById('combinedOtp').value = 
            inputs.map(input => input.value || '').join('');
    }

    // Add event listeners to each input
    inputs.forEach((input, index) => {
        // Handle input changes
        input.addEventListener('input', function (e) {
            // Allow only numbers
            if (!/^\d*$/.test(this.value)) {
                this.value = '';
                return;
            }

            // Update combined OTP value
            updateCombinedOtp();

            // Move to next input if a value is entered
            if (this.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        // Handle keydown events for backspace
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        // Update combined OTP on change events as well
        input.addEventListener('change', updateCombinedOtp);
    });

    // Handle paste event (only on the first input)
    inputs[0].addEventListener('paste', function (e) {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text');

        // Check if pasted content is numeric
        if (!/^\d+$/.test(pastedData)) return;

        // Distribute the pasted digits to the inputs
        const digits = pastedData.split('');
        inputs.forEach((input, idx) => {
            if (idx < digits.length) {
                input.value = digits[idx];
            }
        });

        // Update the combined OTP
        updateCombinedOtp();

        // Focus on the appropriate input
        const focusIndex = Math.min(digits.length, inputs.length - 1);
        inputs[focusIndex].focus();
    });

    // Form submission - ensure OTP is combined
    document.getElementById('otpForm').addEventListener('submit', function(e) {
        updateCombinedOtp();
        const combinedValue = document.getElementById('combinedOtp').value;
        
        // Validate that we have all 4 digits before submitting
        if (combinedValue.length !== 4) {
            e.preventDefault();
            alert('{{__('Please enter the 4-digit verification code')}}');
        }
    });

    // Countdown timer
    let secondsLeft = 60;
    const countdownDisplay = document.getElementById('countdown');
    const resendBtn = document.getElementById('resendBtn');

  
    function updateCountdown() {
        const minutes = Math.floor(secondsLeft / 60);
        const seconds = secondsLeft % 60;

        countdownDisplay.textContent = `${minutes.toString().padStart(2, '0')} : ${seconds.toString().padStart(2, '0')}`;

        if (secondsLeft <= 0) {
            clearInterval(countdownInterval);
            resendBtn.disabled = false;
            resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        secondsLeft--;
    }

    const countdownInterval = setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call

</script>
@endsection