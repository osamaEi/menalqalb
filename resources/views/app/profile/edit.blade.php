@extends('app.index')

@section('content')

  
    <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">الملف الشخصي</h1>
    <p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
        {{ auth()->user()->user_type == 'sales_point' ? 'منفذ بيع' : 'مستخدم' }}
    </p>

    <div class="row justify-content-center overflow-y-auto h-[100%]">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <div class="rounded-lg px-0 pb-8 w-full">
                        <form method="POST" action="{{ route('app.profile.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Name Field -->
                            <div class="!mt-1">
                                <label for="name" class="localized" data-content="الاسم">الاسم</label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input value="{{ old('name', auth()->user()->name) }}" type="text" id="name" name="name"
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="الاسم" />
                                    <div class="px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M12.1596 11.62C12.1296 11.62 12.1096 11.62 12.0796 11.62C12.0296 11.61 11.9596 11.61 11.8996 11.62C8.99957 11.53 6.80957 9.25 6.80957 6.44C6.80957 3.58 9.13957 1.25 11.9996 1.25C14.8596 1.25 17.1896 3.58 17.1896 6.44C17.1796 9.25 14.9796 11.53 12.1896 11.62C12.1796 11.62 12.1696 11.62 12.1596 11.62ZM11.9996 2.75C9.96957 2.75 8.30957 4.41 8.30957 6.44C8.30957 8.44 9.86957 10.05 11.8596 10.12C11.9096 10.11 12.0496 10.11 12.1796 10.12C14.1396 10.03 15.6796 8.42 15.6896 6.44C15.6896 4.41 14.0296 2.75 11.9996 2.75Z"
                                                fill="#4B4B4B" />
                                            <path
                                                d="M12.1696 22.55C10.2096 22.55 8.23961 22.05 6.74961 21.05C5.35961 20.13 4.59961 18.87 4.59961 17.5C4.59961 16.13 5.35961 14.86 6.74961 13.93C9.74961 11.94 14.6096 11.94 17.5896 13.93C18.9696 14.85 19.7396 16.11 19.7396 17.48C19.7396 18.85 18.9796 20.12 17.5896 21.05C16.0896 22.05 14.1296 22.55 12.1696 22.55ZM7.57961 15.19C6.61961 15.83 6.09961 16.65 6.09961 17.51C6.09961 18.36 6.62961 19.18 7.57961 19.81C10.0696 21.48 14.2696 21.48 16.7596 19.81C17.7196 19.17 18.2396 18.35 18.2396 17.49C18.2396 16.64 17.7096 15.82 16.7596 15.19C14.2696 13.53 10.0696 13.53 7.57961 15.19Z"
                                                fill="#4B4B4B" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <!-- Email Field -->
                            <div class="!mt-3">
                                <label for="email" class="localized" data-content="البريد الإلكتروني">البريد الإلكتروني</label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input value="{{ old('email', auth()->user()->email) }}" type="email" id="email" name="email"
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="name@domain.com" />
                                </div>
                            </div>
                            @error('email')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <!-- Phone Field -->
                            <label for="whatsapp" class="!mt-3 localized" data-content="رقم الهاتف">رقم الهاتف</label>
                            <div class="bg-transparent !mt-1 h-[59px] relative rounded-[31px] border !border-black">
                                <div class="flex items-center">
                                    <!-- Country Flag and Code -->
                                    <div class="flex items-center p-0 max-w-[126px] h-[59px]">
                                        <!-- Country Selector Component -->
                                        <div class="country-selector relative">
                                            <!-- Current Selected Country Button -->
                                            <button type="button"
                                                class="!bg-[#F9F9F9] m-0 justify-between flex items-center space-x-2 p-2 rounded-md"
                                                id="countryButton">
                                                <!-- UAE Flag (Default) -->
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
                                            <div class="country-dropdown bg-white absolute z-[999999] mt-1 w-64 shadow-lg rounded-[9px] border border-gray-200 hidden"
                                                id="countryDropdown">
                                                <!-- Countries List (Simplified for this example) -->
                                                <div class="max-h-60 overflow-y-auto py-1">
                                                    <!-- UAE -->
                                                    <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer"
                                                         data-code="971">
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
                                                    <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer"
                                                         data-code="966">
                                                        <div class="flag-icon w-8 h-5 mr-3">
                                                            <svg viewBox="0 0 40 24" class="w-full h-full">
                                                                <rect width="40" height="24" fill="#006c35" />
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm">المملكة العربية السعودية</span>
                                                        <span class="text-sm text-gray-500 mr-auto">+966</span>
                                                    </div>

                                                    <!-- Egypt -->
                                                    <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer"
                                                         data-code="20">
                                                        <div class="flag-icon w-8 h-5 mr-3">
                                                            <svg viewBox="0 0 40 24" class="w-full h-full">
                                                                <rect width="40" height="8" fill="#ce1126" />
                                                                <rect y="8" width="40" height="8" fill="#ffffff" />
                                                                <rect y="16" width="40" height="8" fill="#000000" />
                                                            </svg>
                                                        </div>
                                                        <span class="text-sm">مصر</span>
                                                        <span class="text-sm text-gray-500 mr-auto">+20</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Phone Input -->
                                    <input type="hidden" name="country_code" id="country_code" value="971">
                                    <input required type="tel" name="whatsapp" id="whatsapp"
                                        value="{{ old('whatsapp', auth()->user()->whatsapp) }}"
                                        class="text-center w-[100px] bg-[#F9F9F9] flex-grow px-0 text-lg focus:outline-none"
                                        placeholder="-- -- ---" />

                                    <!-- Phone Icon -->
                                    <div class="px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="relative z-50 h-6 w-6 text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('whatsapp')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <!-- Country -->
                            <div class="relative !mt-3">
                                <label for="country_id"
                                    class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">الدولة</label>
                                <select id="country_id" name="country_id"
                                    class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" 
                                            {{ old('country_id', auth()->user()->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </div>
                            </div>
                            @error('country_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <!-- User Type -->
                            {{-- <div class="relative !mt-3">
                                <label for="user_type"
                                    class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">نوع
                                    الحساب</label>
                                <select id="user_type" name="user_type" 
                                    class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="user" {{ old('user_type', auth()->user()->user_type) == 'user' ? 'selected' : '' }}>مستخدم</option>
                                    <option value="sales_point" {{ old('user_type', auth()->user()->user_type) == 'sales_point' ? 'selected' : '' }}>منفذ بيع</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </div>
                            </div> --}}
                            @error('user_type')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <!-- Business Name Field (Conditionally displayed) -->
                            <div id="businessNameField" class="!mt-3" style="{{ old('user_type', auth()->user()->user_type) == 'sales_point' ? 'display: block;' : 'display: none;' }}">
                                <label for="company_name" class="localized" data-content="الاسم التجاري">الاسم التجاري</label>
                                <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                    <div class="flex items-center">
                                        <input type="text" id="company_name" name="company_name"
                                            value="{{ old('company_name', auth()->user()->company_name) }}"
                                            class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                            placeholder="الاسم التجاري" />
                                        <div class="px-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M12.1596 11.62C12.1296 11.62 12.1096 11.62 12.0796 11.62C12.0296 11.61 11.9596 11.61 11.8996 11.62C8.99957 11.53 6.80957 9.25 6.80957 6.44C6.80957 3.58 9.13957 1.25 11.9996 1.25C14.8596 1.25 17.1896 3.58 17.1896 6.44C17.1796 9.25 14.9796 11.53 12.1896 11.62C12.1796 11.62 12.1696 11.62 12.1596 11.62ZM11.9996 2.75C9.96957 2.75 8.30957 4.41 8.30957 6.44C8.30957 8.44 9.86957 10.05 11.8596 10.12C11.9096 10.11 12.0496 10.11 12.1796 10.12C14.1396 10.03 15.6796 8.42 15.6896 6.44C15.6896 4.41 14.0296 2.75 11.9996 2.75Z"
                                                    fill="#4B4B4B" />
                                                <path
                                                    d="M12.1696 22.55C10.2096 22.55 8.23961 22.05 6.74961 21.05C5.35961 20.13 4.59961 18.87 4.59961 17.5C4.59961 16.13 5.35961 14.86 6.74961 13.93C9.74961 11.94 14.6096 11.94 17.5896 13.93C18.9696 14.85 19.7396 16.11 19.7396 17.48C19.7396 18.85 18.9796 20.12 17.5896 21.05C16.0896 22.05 14.1296 22.55 12.1696 22.55ZM7.57961 15.19C6.61961 15.83 6.09961 16.65 6.09961 17.51C6.09961 18.36 6.62961 19.18 7.57961 19.81C10.0696 21.48 14.2696 21.48 16.7596 19.81C17.7196 19.17 18.2396 18.35 18.2396 17.49C18.2396 16.64 17.7096 15.82 16.7596 15.19C14.2696 13.53 10.0696 13.53 7.57961 15.19Z"
                                                    fill="#4B4B4B" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                @error('company_name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center 
                                            !bg-[#B62326] text-white font-bold
                                            !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                                            focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                    تحديث الحساب
                                </button>
                            </div>
                        </form>
                        
                        <!-- Password Change Link -->
                        <a href="{{ route('app.profile.change-password') }}" class="block text-center border-0 !font-[400] !pt-3 !text-[#4B4B4B]">
                            تغيير كلمة المرور
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Country dropdown functionality
        const countryButton = document.getElementById('countryButton');
        const countryDropdown = document.getElementById('countryDropdown');
        const countryItems = document.querySelectorAll('.country-item');
        const countryCodeInput = document.getElementById('country_code');

        // Toggle dropdown visibility
        countryButton.addEventListener('click', function() {
            countryDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!countryDropdown.contains(event.target) && !countryButton.contains(event.target)) {
                countryDropdown.classList.add('hidden');
            }
        });

        // Country selection functionality
        countryItems.forEach(item => {
            item.addEventListener('click', function() {
                const flagIcon = this.querySelector('.flag-icon').innerHTML;
                const countryCode = this.querySelector('.text-gray-500').textContent;
                const codeValue = this.dataset.code;

                // Update button with selected country
                const buttonFlagIcon = document.querySelector('#countryButton .flag-icon');
                const buttonCountryCode = document.querySelector('#countryButton span');

                buttonFlagIcon.innerHTML = flagIcon;
                buttonCountryCode.textContent = countryCode.replace('+', '');
                countryCodeInput.value = codeValue;

                // Hide dropdown
                countryDropdown.classList.add('hidden');
            });
        });

        // Company name field visibility toggle
        const userTypeSelect = document.getElementById('user_type');
        const businessNameField = document.getElementById('businessNameField');

        userTypeSelect.addEventListener('change', function() {
            if (this.value === 'sales_point') {
                businessNameField.style.display = 'block';
            } else {
                businessNameField.style.display = 'none';
            }
        });
    });
</script>
@endsection