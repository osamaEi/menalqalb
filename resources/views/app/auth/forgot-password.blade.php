@extends('app.index')
@section('content')
    <div class="app messagebox">
 
        <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">نسيت كلمة المرور؟</h1>
        <p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
            لا تقلق، أدخل رقم هاتفك المسجل لدينا وسنرسل لك رمز مكون من 4 أرقام عبر تطبيق الواتساب
        </p>
        <div class="flex items-center justify-center text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
                <!-- WhatsApp SVG (same as provided) -->
                <g clip-path="url(#clip0_1412_6957)">
                    <g filter="url(#filter0_f_1412_6957)">
                        <path d="M10.5817 26.8144L11.0154 27.0708C12.8369 28.1498 14.9254 28.7206 17.0553 28.7215H17.0597C23.6004 28.7215 28.9235 23.4098 28.9262 16.8812C28.9274 13.7175 27.6942 10.7425 25.4538 8.50459C24.3549 7.40091 23.0476 6.52574 21.6076 5.92974C20.1675 5.33373 18.6233 5.02873 17.0644 5.03239C10.5186 5.03239 5.19536 10.3435 5.19303 16.8717C5.18981 19.1009 5.81876 21.2855 7.00717 23.1729L7.28951 23.6207L6.0905 27.9896L10.5817 26.8144ZM2.66248 31.3743L4.68812 23.9926C3.43885 21.8323 2.78162 19.3816 2.7824 16.8708C2.78569 9.01608 9.19 2.62598 17.0599 2.62598C20.879 2.62791 24.4636 4.11127 27.1595 6.80393C29.8553 9.49659 31.3386 13.0757 31.3373 16.8822C31.3338 24.7363 24.9285 31.1275 17.0597 31.1275H17.0535C14.6642 31.1266 12.3165 30.5283 10.2311 29.3934L2.66248 31.3743Z" fill="white"/>
                    </g>
                    <path d="M2.51599 31.2278L4.54164 23.8461C3.29022 21.6806 2.63289 19.2241 2.63591 16.7243C2.63921 8.8696 9.04351 2.47949 16.9134 2.47949C20.7325 2.48143 24.3171 3.96478 27.013 6.65744C29.7088 9.35011 31.1921 12.9292 31.1908 16.7357C31.1873 24.5898 24.782 30.9811 16.9132 30.9811H16.907C14.5177 30.9801 12.17 30.3818 10.0846 29.2469L2.51599 31.2278Z" fill="white"/>
                    <path d="M16.9178 4.88578C10.372 4.88578 5.04873 10.1969 5.0464 16.7251C5.04318 18.9543 5.67212 21.1389 6.86054 23.0263L7.14287 23.4743L5.94386 27.8432L10.4353 26.6678L10.8689 26.9242C12.6905 28.0032 14.779 28.5738 16.9088 28.5749H16.9133C23.454 28.5749 28.7773 23.2632 28.7798 16.7346C28.7847 15.1785 28.4804 13.637 27.8843 12.1991C27.2883 10.7612 26.4124 9.45567 25.3073 8.35798C24.2084 7.25428 22.9011 6.37909 21.461 5.78309C20.021 5.18708 18.4767 4.88209 16.9178 4.88578Z" fill="url(#paint0_linear_1412_6957)"/>
                    <path d="M16.9175 5.38574H16.9185C18.2249 5.38266 19.5211 5.60566 20.7485 6.04395L21.27 6.24512C22.4767 6.74457 23.5859 7.44891 24.5493 8.3252L24.9526 8.71094L24.9546 8.71289C25.8805 9.63268 26.6385 10.7048 27.1958 11.8809L27.4224 12.3906C27.9217 13.5951 28.2076 14.8755 28.2681 16.1748L28.2798 16.7334V16.7344C28.2774 22.9859 23.1789 28.075 16.9136 28.0752H16.9087L16.5269 28.0684C14.7462 28.0079 13.0069 27.5322 11.4536 26.6816L11.1235 26.4941L10.6899 26.2373L10.5103 26.1309L10.3091 26.1846L6.65479 27.1396L7.62549 23.6064L7.68311 23.3945L7.56592 23.208L7.28369 22.7598C6.14565 20.9523 5.5433 18.8602 5.54639 16.7256L5.56104 16.1426C5.85823 10.354 10.527 5.69491 16.3335 5.40039L16.9175 5.38574Z" stroke="black" stroke-opacity="0.5"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.3449 10.7689C13.0775 10.1761 12.7962 10.1641 12.5422 10.1538L11.8583 10.1455C11.6204 10.1455 11.2339 10.2346 10.9071 10.591C10.5804 10.9473 9.65845 11.8086 9.65845 13.5604C9.65845 15.3122 10.9368 17.0049 11.115 17.2427C11.2931 17.4806 13.5828 21.19 17.209 22.6172C20.2223 23.8033 20.8355 23.5674 21.4898 23.5081C22.1442 23.4488 23.6005 22.6468 23.8976 21.8154C24.1946 20.9839 24.1948 20.2716 24.1058 20.1227C24.0167 19.9737 23.7788 19.8852 23.4218 19.707C23.0647 19.5289 21.3111 18.6676 20.9841 18.5487C20.6572 18.4298 20.4195 18.3707 20.1814 18.727C19.9433 19.0834 19.2604 19.885 19.0522 20.1227C18.844 20.3603 18.6362 20.3901 18.2791 20.2121C17.9221 20.0342 16.7733 19.658 15.4104 18.4451C14.3499 17.5013 13.6341 16.3357 13.4257 15.9796C13.2173 15.6234 13.4035 15.4305 13.5825 15.2531C13.7425 15.0935 13.9391 14.8373 14.1178 14.6295C14.2965 14.4217 14.3553 14.2731 14.4741 14.0359C14.5928 13.7986 14.5337 13.5902 14.4444 13.4122C14.3551 13.2342 13.662 11.4731 13.3449 10.7689Z" fill="white"/>
                </g>
                <defs>
                    <filter id="filter0_f_1412_6957" x="-4.39952" y="-4.43602" width="42.7988" height="42.872" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                        <feGaussianBlur stdDeviation="3.531" result="effect1_foregroundBlur_1412_6957"/>
                    </filter>
                    <linearGradient id="paint0_linear_1412_6957" x1="16.6715" y1="6.30735" x2="16.7914" y2="26.5512" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#57D163"/>
                        <stop offset="1" stop-color="#23B33A"/>
                    </linearGradient>
                    <clipPath id="clip0_1412_6957">
                        <rect width="34" height="34" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-4">
                <div class="All_Button lang Devices">
                    <div class="rounded-lg p-8 w-full">
                        @if (session('error'))
                            <div class="text-red-500 text-center mb-4">{{ session('error') }}</div>
                        @endif
                        <form class="space-y-6" method="POST" action="{{ route('app.forgot-password') }}">
                            @csrf
                            <!-- Phone Field -->
                            <div class="bg-[#F9F9F9] h-[55px] relative mt-0 rounded-[39px] border !border-[#000000]">
                                <div class="flex items-center mt-1">
                                    <!-- Country Selector -->
                                    <div class="country-selector relative">
                                        <button type="button" class="!bg-transparent m-0 justify-between flex items-center !border-[#000000] space-x-2 p-2 rounded-full" id="countryButton">
                                            <div class="flag-icon w-8 h-5 ml-2">
                                                <svg viewBox="0 0 40 24" class="w-full h-full">
                                                    <rect width="40" height="8" fill="#00732f"/>
                                                    <rect y="8" width="40" height="8" fill="#ffffff"/>
                                                    <rect y="16" width="40" height="8" fill="#000000"/>
                                                    <rect width="12" height="24" fill="#ff0000"/>
                                                </svg>
                                            </div>
                                            <span class="text-lg font-extrabold text-black">+971</span>
                                        </button>
                                        <input type="hidden" name="country_code" id="countryCode" value="+971">
                                        <div class="country-dropdown bg-white absolute z-[999999] mt-1 w-64 shadow-lg rounded-[9px] border border-gray-200 hidden" id="countryDropdown">
                                            <div class="p-2 border-b border-gray-200">
                                                <input type="text" placeholder="ابحث عن دولة..." class="w-full p-2 border border-gray-300 rounded-[9px] focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div class="max-h-60 overflow-y-auto py-1">
                                                <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer" data-code="+971">
                                                    <div class="flag-icon w-8 h-5 mr-3">
                                                        <svg viewBox="0 0 40 24" class="w-full h-full">
                                                            <rect width="40" height="8" fill="#00732f"/>
                                                            <rect y="8" width="40" height="8" fill="#ffffff"/>
                                                            <rect y="16" width="40" height="8" fill="#000000"/>
                                                            <rect width="12" height="24" fill="#ff0000"/>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm">الإمارات العربية المتحدة</span>
                                                    <span class="text-sm text-gray-500 mr-auto">+971</span>
                                                </div>
                                                <!-- Other countries (same as provided) -->
                                                <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer" data-code="+966">
                                                    <div class="flag-icon w-8 h-5 mr-3">
                                                        <svg viewBox="0 0 40 24" class="w-full h-full">
                                                            <rect width="40" height="24" fill="#006c35"/>
                                                            <g transform="translate(13, 8)">
                                                                <path d="M0,0 H18 M0,4 H18 M9,0 V8" stroke="#fff" stroke-width="1"/>
                                                                <text x="9" y="6" font-size="4" text-anchor="middle" fill="#fff">لا إله إلا الله</text>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm">المملكة العربية السعودية</span>
                                                    <span class="text-sm text-gray-500 mr-auto">+966</span>
                                                </div>
                                                <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer" data-code="2">
                                                    <div class="flag-icon w-8 h-5 mr-3">
                                                        <svg viewBox="0 0 40 24" class="w-full h-full">
                                                            <rect width="40" height="8" fill="#ce1126"/>
                                                            <rect y="8" width="40" height="8" fill="#ffffff"/>
                                                            <rect y="16" width="40" height="8" fill="#000000"/>
                                                            <g transform="translate(20, 12)" fill="#c09300">
                                                                <circle r="3"/>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <span class="text-sm">مصر</span>
                                                    <span class="text-sm text-gray-500 mr-auto">+20</span>
                                                </div>                                            </div>
                                        </div>
                                    </div>
                                    <input type="tel" name="whatsapp" class="text-center w-[100px] bg-[#F9F9F9] flex-grow px-0 text-lg focus:outline-none" placeholder="-- -- ---" required/>
                                    <div class="px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                            <!-- Phone SVG (same as provided) -->
                                            <path d="M17.45 23.25C16.32 23.25 15.13 22.98 13.9 22.46C12.7 21.95 11.49 21.25 10.31 20.4C9.14 19.54 8.01 18.58 6.94 17.53C5.88 16.46 4.92 15.33 4.07 14.17C3.21 12.97 2.52 11.77 2.03 10.61C1.51 9.37 1.25 8.17 1.25 7.04C1.25 6.26 1.39 5.52 1.66 4.83C1.94 4.12 2.39 3.46 3 2.89C3.77 2.13 4.65 1.75 5.59 1.75C5.98 1.75 6.38 1.84 6.72 2C7.11 2.18 7.44 2.45 7.68 2.81L10 6.08C10.21 6.37 10.37 6.65 10.48 6.93C10.61 7.23 10.68 7.53 10.68 7.82C10.68 8.2 10.57 8.57 10.36 8.92C10.21 9.19 9.98 9.48 9.69 9.77L9.01 10.48C9.02 10.51 9.03 10.53 9.04 10.55C9.16 10.76 9.4 11.12 9.86 11.66C10.35 12.22 10.81 12.73 11.27 13.2C11.86 13.78 12.35 14.24 12.81 14.62C13.38 15.1 13.75 15.34 13.97 15.45L13.95 15.5L14.68 14.78C14.99 14.47 15.29 14.24 15.58 14.09C16.13 13.75 16.83 13.69 17.53 13.98C17.79 14.09 18.07 14.24 18.37 14.45L21.69 16.81C22.06 17.06 22.33 17.38 22.49 17.76C22.64 18.14 22.71 18.49 22.71 18.84C22.71 19.32 22.6 19.8 22.39 20.25C22.18 20.7 21.92 21.09 21.59 21.45C21.02 22.08 20.4 22.53 19.68 22.82C18.99 23.1 18.24 23.25 17.45 23.25ZM5.59 3.25C5.04 3.25 4.53 3.49 4.04 3.97C3.58 4.4 3.26 4.87 3.06 5.38C2.85 5.9 2.75 6.45 2.75 7.04C2.75 7.97 2.97 8.98 3.41 10.02C3.86 11.08 4.49 12.18 5.29 13.28C6.09 14.38 7 15.45 8 16.46C9 17.45 10.08 18.37 11.19 19.18C12.27 19.97 13.38 20.61 14.48 21.07C16.19 21.8 17.79 21.97 19.11 21.42C19.62 21.21 20.07 20.89 20.48 20.43C20.71 20.18 20.89 19.91 21.04 19.59C21.16 19.34 21.22 19.08 21.22 18.82C21.22 18.66 21.19 18.5 21.11 18.32C21.08 18.26 21.02 18.15 20.83 18.02L17.51 15.66C17.31 15.52 17.13 15.42 16.96 15.35C16.74 15.26 16.65 15.17 16.31 15.38C16.11 15.48 15.93 15.63 15.73 15.83L14.97 16.58C14.58 16.96 13.98 17.05 13.52 16.88L13.25 16.76C12.84 16.54 12.36 16.2 11.83 15.75C11.35 15.34 10.83 14.86 10.2 14.24C9.71 13.74 9.22 13.21 8.71 12.62C8.24 12.07 7.9 11.6 7.69 11.21L7.57 10.91C7.51 10.68 7.49 10.55 7.49 10.41C7.49 10.05 7.62 9.73 7.87 9.48L8.62 8.7C8.82 8.5 8.97 8.31 9.07 8.14C9.15 8.01 9.18 7.9 9.18 7.8C9.18 7.72 9.15 7.6 9.1 7.48C9.03 7.32 8.92 7.14 8.78 6.95L6.46 3.67C6.36 3.53 6.24 3.43 6.09 3.36C5.93 3.29 5.76 3.25 5.59 3.25ZM13.95 15.51L13.79 16.19L14.06 15.49C14.01 15.48 13.97 15.49 13.95 15.51Z" fill="#4B4B4B"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('whatsapp')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <!-- Submit Button -->
                            <div class="flex justify-center">
                                <button type="submit" class="!m-0 !h-[55px] !w-[100%] mt-0 !font-[400] flex items-center justify-center !bg-[#B62326] text-white font-bold !rounded-full hover:bg-[#B62326]-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                    استمرار
                                </button>
                            </div>
                        </form>
                        <div class="!mt-5 text-center">
                            <a href="{{ route('app.login') }}" class="!text-[#B62326] !border-0 text-[16px] !font-[400]">لدي حساب</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('countryButton').addEventListener('click', function () {
                const dropdown = document.getElementById('countryDropdown');
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                const dropdown = document.getElementById('countryDropdown');
                const button = document.getElementById('countryButton');
                if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            document.querySelectorAll('.country-item').forEach(item => {
                item.addEventListener('click', function () {
                    const flagIcon = this.querySelector('.flag-icon').innerHTML;
                    const countryCode = this.getAttribute('data-code');
                    const buttonFlagIcon = document.querySelector('#countryButton .flag-icon');
                    const buttonCountryCode = document.querySelector('#countryButton span');
                    const countryCodeInput = document.getElementById('countryCode');
                    buttonFlagIcon.innerHTML = flagIcon;
                    buttonCountryCode.textContent = countryCode;
                    countryCodeInput.value = countryCode;
                    document.getElementById('countryDropdown').classList.add('hidden');
                });
            });
        </script>
    </body>
@endsection