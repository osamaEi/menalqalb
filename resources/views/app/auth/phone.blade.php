@extends('app.index')

@section('content')
<h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">{{__('Join our family')}}</h1>
<p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
    {{__('Simple information separates you from enjoying our services')}}
<p class="font-bold mx-auto text-center">{{__('The second step')}}</p>
</p>
<p class="flex items-center justify-center text-center text-[14px] leading-[29px] 
    max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 relative">
    {{__('Enter a phone number registered with WhatsApp to receive the verification code')}}
</p>

<div class="row justify-content-center">
    <div class="col-12 col-lg-4 ">
        <div class="All_Button lang Devices">
            <div>
                <div class="rounded-lg p-8 w-full">
                    <form class="space-y-6" method="POST" action="{{ route('app.register.phone') }}">
                        @csrf
                        <!-- Phone Field -->
                        <label for="phone_number" class="localized" data-content="{{__('Phone number')}}"></label>
                        <div class="bg-[#F9F9F9] h-[55px] relative mt-0 rounded-[39px] border !border-[#000000]">
                            <div class="flex items-center mt-1">
                                <!-- Country Flag and Code -->
                                <div class="flex items-center p-0 max-w-[126px] max-h-[55px] !border-[#000000]">
                                    <!-- Country Selector Component -->
                                    <div class="country-selector relative">
                                        <!-- Current Selected Country Button -->
                                        <button type="button" class="!bg-transparent m-0 justify-between flex items-center !border-[#000000] space-x-2 p-2 rounded-full" id="countryButton">
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
                                                <input type="text" placeholder="{{__('Search for a country...')}}" class="w-full p-2 border border-gray-300 rounded-[9px] focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                                                    <span class="text-sm">{{__('United Arab Emirates')}}</span>
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
                                                    <span class="text-sm">{{__('Saudi Arabia')}}</span>
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
                                                    <span class="text-sm">{{__('Egypt')}}</span>
                                                    <span class="text-sm text-gray-500 mr-auto">+2</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="country_code" id="country_code" value="971">
                                </div>

                                <!-- Phone Input -->
                                <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                    class="text-center w-[100px] bg-[#F9F9F9] flex-grow px-0 text-lg focus:outline-none"
                                    placeholder="-- -- ---" required />

                                <!-- Phone Icon -->
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                        <path d="M17.45 23.25C16.32 23.25 15.13 22.98 13.9 22.46C12.7 21.95 11.49 21.25 10.31 20.4C9.14 19.54 8.01 18.58 6.94 17.53C5.88 16.46 4.92 15.33 4.07 14.17C3.21 12.97 2.52 11.77 2.03 10.61C1.51 9.37 1.25 8.17 1.25 7.04C1.25 6.26 1.39 5.52 1.66 4.83C1.94 4.12 2.39 3.46 3 2.89C3.77 2.13 4.65 1.75 5.59 1.75C5.98 1.75 6.38 1.84 6.72 2C7.11 2.18 7.44 2.45 7.68 2.81L10 6.08C10.21 6.37 10.37 6.65 10.48 6.93C10.61 7.23 10.68 7.53 10.68 7.82C10.68 8.2 10.57 8.57 10.36 8.92C10.21 9.19 9.98 9.48 9.69 9.77L9.01 10.48C9.02 10.51 9.03 10.53 9.04 10.55C9.16 10.76 9.4 11.12 9.86 11.66C10.35 12.22 10.81 12.73 11.27 13.2C11.86 13.78 12.35 14.24 12.81 14.62C13.38 15.1 13.75 15.34 13.97 15.45L13.95 15.5L14.68 14.78C14.99 14.47 15.29 14.24 15.58 14.09C16.13 13.75 16.83 13.69 17.53 13.98C17.79 14.09 18.07 14.24 18.37 14.45L21.69 16.81C22.06 17.06 22.33 17.38 22.49 17.76C22.64 18.14 22.71 18.49 22.71 18.84C22.71 19.32 22.6 19.8 22.39 20.25C22.18 20.7 21.92 21.09 21.59 21.45C21.02 22.08 20.4 22.53 19.68 22.82C18.99 23.1 18.24 23.25 17.45 23.25ZM5.59 3.25C5.04 3.25 4.53 3.49 4.04 3.97C3.58 4.4 3.26 4.87 3.06 5.38C2.85 5.9 2.75 6.45 2.75 7.04C2.75 7.97 2.97 8.98 3.41 10.02C3.86 11.08 4.49 12.18 5.29 13.28C6.09 14.38 7 15.45 8 16.46C9 17.45 10.08 18.37 11.19 19.18C12.27 19.97 13.38 20.61 14.48 21.07C16.19 21.8 17.79 21.97 19.11 21.42C19.62 21.21 20.07 20.89 20.48 20.43C20.71 20.18 20.89 19.91 21.04 19.59C21.16 19.34 21.22 19.08 21.22 18.82C21.22 18.66 21.19 18.5 21.11 18.32C21.08 18.26 21.02 18.15 20.83 18.02L17.51 15.66C17.31 15.52 17.13 15.42 16.96 15.35C16.74 15.26 16.65 15.17 16.31 15.38C16.11 15.48 15.93 15.63 15.73 15.83L14.97 16.58C14.58 16.96 13.98 17.05 13.52 16.88L13.25 16.76C12.84 16.54 12.36 16.2 11.83 15.75C11.35 15.34 10.83 14.86 10.2 14.24C9.71 13.74 9.22 13.21 8.71 12.62C8.24 12.07 7.9 11.6 7.69 11.21L7.57 10.91C7.51 10.68 7.49 10.55 7.49 10.41C7.49 10.05 7.62 9.73 7.87 9.48L8.62 8.7C8.82 8.5 8.97 8.31 9.07 8.14C9.15 8.01 9.18 7.9 9.18 7.8C9.18 7.72 9.15 7.6 9.1 7.48C9.03 7.32 8.92 7.14 8.78 6.95L6.46 3.67C6.36 3.53 6.24 3.43 6.09 3.36C5.93 3.29 5.76 3.25 5.59 3.25ZM13.95 15.51L13.79 16.19L14.06 15.49C14.01 15.48 13.97 15.49 13.95 15.51Z" fill="#4B4B4B" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('phone_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        @error('country_code')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="!m-0 !h-[55px] !w-[100%] mt-0 !font-[400] flex items-center justify-center 
                            !bg-[#B62326] text-white font-bold
                            !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                            focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                {{__('Continue')}}
                            </button>
                        </div>
                    </form>
                    <div class="!mt-5 ">
                        <a href="{{ route('app.login') }}" class="border-0 !font-[400] !pt-3 !text-[#4B4B4B]">{{__('Do you have an account?')}}
                            <span class="text-[#B62326] font-bold">{{__('Log in')}}</span>
                        </a>
                    </div>
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
</script>
@endsection