@extends('app.index')

@section('content')
<h1 class="text-[21px] font-[400] z-50 relative" style="font-family: cairo !important;">مرحبا بكم</h1>
<p class="text-center text-[14px] leading-[29px] font-[400] text-[#6B5E5E] z-50 mt-2 relative">لاستكمال
    إعداد التهنيئة
    يجب عليك تسجيل دخولك أولا ً</p>
<p class="text-center text-[14px] leading-[29px] font-[400] text-[#6B5E5E] z-50 mt-2 relative">
    تسجيل الدخول بواسطة بيانات الدخول
</p>

<div class="row justify-content-center">
    <div class="col-12 col-lg-4">
        <div class="All_Button lang Devices">
            <div>
                <div class="rounded-lg p-8 w-full">
                    @if(session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('status') }}</span>
                        </div>
                    @endif

                    <form class="space-y-6" method="POST" action="{{ route('app.login') }}">
                        @csrf
                        <!-- Phone Field -->
                        <div class="bg-[#F9F9F9] max-h-[47px] relative rounded-[9px] border border-gray-300">
                            <div class="flex items-center">
                                <!-- Country Flag and Code -->
                                <div class="flex items-center p-0 max-w-[126px] max-h-[55px] border-l border-gray-300">
                                    <!-- Flag Selection Component -->
                                    <div class="country-selector relative">
                                        <!-- Current Selected Country Button -->
                                        <button type="button" class="!bg-[#F9F9F9] m-0 justify-between flex items-center space-x-2 p-2 rounded-md" id="countryButton">
                                            <!-- UAE Flag -->
                                            <div class="flag-icon w-8 h-5 ml-2">
                                                <svg viewBox="0 0 40 24" class="w-full h-full">
                                                    <rect width="40" height="8" fill="#00732f" />
                                                    <rect y="8" width="40" height="8" fill="#ffffff" />
                                                    <rect y="16" width="40" height="8" fill="#000000" />
                                                    <rect width="12" height="24" fill="#ff0000" />
                                                </svg>
                                            </div>
                                            <span class="text-lg font-extrabold text-black">971</span>
                                        </button>

                                        <!-- Country Dropdown (Hidden by Default) -->
                                        <div class="country-dropdown bg-white absolute z-[999999] mt-1 w-64 shadow-lg rounded-[9px] border border-gray-200 hidden" id="countryDropdown">
                                            <!-- Search Box -->
                                            <div class="p-2 border-b border-gray-200">
                                                <input type="text" placeholder="ابحث عن دولة..." class="w-full p-2 border border-gray-300 rounded-[9px] focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <!-- Countries List -->
                                            <div class="max-h-60 overflow-y-auto py-1">
                                                <!-- UAE -->
                                                <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer" data-code="971">
                                                    <div class="flag-icon w-8 h-5 mr-3">
                                                        <svg viewBox="0 0 40 24" class="w-full h-full">
                                                            <rect width="40" height="8" fill="#00732f" />
                                                            <rect y="8" width="40" height="8" fill="#ffffff" />
                                                            <rect y="16" width="40" height="8" fill="#000000" />
                                                            <rect width="12" height="24" fill="#ff0000" />
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm">الإمارات العربية المتحدة</span>
                                                    <span class="text-sm text-gray-500 mr-auto">+971</span>
                                                </div>

                                                <!-- Saudi Arabia -->
                                                <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer" data-code="966">
                                                    <div class="flag-icon w-8 h-5 mr-3">
                                                        <svg viewBox="0 0 40 24" class="w-full h-full">
                                                            <rect width="40" height="24" fill="#006c35" />
                                                            <g transform="translate(13, 8)">
                                                                <path d="M0,0 H18 M0,4 H18 M9,0 V8" stroke="#fff" stroke-width="1" />
                                                                <text x="9" y="6" font-size="4" text-anchor="middle" fill="#fff">لا إله إلا الله</text>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm">المملكة العربية السعودية</span>
                                                    <span class="text-sm text-gray-500 mr-auto">+966</span>
                                                </div>

                                                <!-- Egypt -->
                                                <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer" data-code="2">
                                                    <div class="flag-icon w-8 h-5 mr-3">
                                                        <svg viewBox="0 0 40 24" class="w-full h-full">
                                                            <rect width="40" height="8" fill="#ce1126" />
                                                            <rect y="8" width="40" height="8" fill="#ffffff" />
                                                            <rect y="16" width="40" height="8" fill="#000000" />
                                                            <g transform="translate(20, 12)" fill="#c09300">
                                                                <circle r="3" />
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm">مصر</span>
                                                    <span class="text-sm text-gray-500 mr-auto">+20</span>
                                                </div>

                                                <!-- Add other countries as needed -->
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="country_code" id="country_code" value="971">
                                </div>

                                <!-- Phone Input -->
                                <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required
                                    class="text-center w-[100px] bg-[#F9F9F9] flex-grow px-0 text-lg focus:outline-none"
                                    placeholder="-- -- ---" />

                                <!-- Phone Icon -->
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="relative z-50 h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('whatsapp')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Password Field -->
                        <div class="bg-[#F9F9F9] max-h-[47px] relative rounded-[9px] border border-gray-300">
                            <div class="flex items-center">
                                <!-- Lock Icon -->
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <!-- Password Input -->
                                <input type="password" id="passwordInput" name="password" required
                                    class="w-[100px] bg-[#F9F9F9] h-[45px] flex-grow text-lg focus:outline-none text-center"
                                    placeholder="كلمة المرور" />
                                <!-- Show/Hide Password Icon -->
                                <div class="px-4">
                                    <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Forgot Password Link -->
                        <div class="text-center border-0 p-0 m-0 right-[20px] relative !text-right">
                            <a href="{{ route('app.forgot-password') }}" class="text-[12px] border-0 font-[400] p-0 !text-[#5b186bcc] text-lg text-purple-700 font-semibold">نسيت كلمة المرور</a>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <a href="{{ route('app.register') }}" class="mt-0 font-bold flex items-center justify-center bg-green-600 text-black border !border-black !w-[122px] !h-[35px] !rounded-full font-bold hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                تسجيل جديد
                            </a>

                            <button type="submit" class="mt-0 !font-[400] flex items-center justify-center !bg-[#B62326] text-white !w-[122px] !h-[35px] !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                تسجيل الدخول
                            </button>
                        </div>
                    </form>
                </div>

                <div class="footer">
                    <img src="{{ asset('img/message.png') }}" alt="" class="img-fluid message">
                </div>
                <div class="made">
                    <img src="{{ asset('img/omda logo.svg') }}" class="h-[129px] mx-auto d-block" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle dropdown visibility
    document.getElementById('countryButton').addEventListener('click', function () {
        const dropdown = document.getElementById('countryDropdown');
        dropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('countryDropdown');
        const button = document.getElementById('countryButton');

        if (!dropdown.contains(event.target) && !button.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Country selection functionality
    document.querySelectorAll('.country-item').forEach(item => {
        item.addEventListener('click', function () {
            const flagIcon = this.querySelector('.flag-icon').innerHTML;
            const countryCode = this.querySelector('.text-gray-500').textContent.replace('+', '');
            const countryCodeValue = this.getAttribute('data-code');
            
            // Update button with selected country
            const buttonFlagIcon = document.querySelector('#countryButton .flag-icon');
            const buttonCountryCode = document.querySelector('#countryButton span');
            const countryCodeInput = document.getElementById('country_code');

            buttonFlagIcon.innerHTML = flagIcon;
            buttonCountryCode.textContent = countryCodeValue;
            countryCodeInput.value = countryCodeValue;

            // Hide dropdown
            document.getElementById('countryDropdown').classList.add('hidden');
        });
    });

    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    let isPasswordVisible = false;

    togglePassword.addEventListener('click', () => {
        isPasswordVisible = !isPasswordVisible;
        if (isPasswordVisible) {
            passwordInput.type = 'text';
            togglePassword.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c5.185 0 9.448 4.014 9.95 9.048-.502 5.034-4.765 9.048-9.95 9.048S2.552 18.582 2.05 13.548C2.552 8.514 6.815 4.5 12 4.5zm0 3a4.5 4.5 0 100 9 4.5 4.5 0 000-9z" />
            `;
        } else {
            passwordInput.type = 'password';
            togglePassword.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        }
    });
</script>
@endsection