@extends('app.index')

@section('content')
<h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">إنضم لعائلتنا</h1>
<p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
    معلومات بسيطة تفصلك عن الاستمتاع بخدماتنا
<p class="font-bold mx-auto text-center">الخطوة الأولى</p>
</p>

<div class="row justify-content-center overflow-y-auto h-[100%]">
    <div class="col-12 col-lg-4 ">
        <div class="All_Button lang Devices">
            <div>
                <div class="rounded-lg px-0 pb-8 w-full">
                    <form class="space-y-6" method="POST" action="{{ route('app.register') }}">
                        @csrf
                        
                        <!-- Name Field -->
                        <div class="!mt-1">
                            <label for="name" class="localized" data-content="الاسم"></label>
                        </div>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                            <div class="flex items-center">
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                    class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                    placeholder="الاسم" required />
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
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Email Field -->
                        <div class="!mt-3">
                            <label for="email" class="localized" data-content="البريد الإلكتروني"></label>
                        </div>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                            <div class="flex items-center">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                    placeholder="name@domain.com" required />
                            </div>
                        </div>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Country -->
                        <div class="relative !mt-3">
                            <label for="country_id"
                                class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">الدولة</label>
                            <select id="country_id" name="country_id"
                                class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">اختر الدولة</option>
                                <option value="مصر" {{ old('country_id') == 'مصر' ? 'selected' : '' }}>مصر</option>
                                <option value="المملكة العربية السعودية" {{ old('country_id') == 'المملكة العربية السعودية' ? 'selected' : '' }}>المملكة العربية السعودية</option>
                                <option value="الإمارات العربية المتحدة" {{ old('country_id') == 'الإمارات العربية المتحدة' ? 'selected' : '' }}>الإمارات العربية المتحدة</option>
                                <option value="المغرب" {{ old('country_id') == 'المغرب' ? 'selected' : '' }}>المغرب</option>
                                <option value="الجزائر" {{ old('country_id') == 'الجزائر' ? 'selected' : '' }}>الجزائر</option>
                                <option value="لبنان" {{ old('country_id') == 'لبنان' ? 'selected' : '' }}>لبنان</option>
                                <option value="الأردن" {{ old('country_id') == 'الأردن' ? 'selected' : '' }}>الأردن</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </div>
                        @error('country_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <div class="relative !mt-3">
                            <label for="user_type"
                                class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">نوع الحساب</label>
                            <select id="user_type" name="user_type" 
                                class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">اختر النوع</option>
                                <option value="privileged_user" {{ old('user_type') == 'privileged_user' ? 'selected' : '' }}>مستخدم مميز</option>
                                <option value="sales_point" {{ old('user_type') == 'sales_point' ? 'selected' : '' }}>منفذ بيع</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </div>
                        </div>
                        @error('user_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <div id="companyNameField" class="!mt-1" style="{{ old('user_type') == 'sales_point' ? 'display: block;' : 'display: none;' }}">
                            <label for="company_name" class="localized" data-content="الاسم التجاري"></label>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="الاسم التجاري" />
                                    <div class="px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.1596 11.62C12.1296 11.62 12.1096 11.62 12.0796 11.62C12.0296 11.61 11.9596 11.61 11.8996 11.62C8.99957 11.53 6.80957 9.25 6.80957 6.44C6.80957 3.58 9.13957 1.25 11.9996 1.25C14.8596 1.25 17.1896 3.58 17.1896 6.44C17.1796 9.25 14.9796 11.53 12.1896 11.62C12.1796 11.62 12.1696 11.62 12.1596 11.62ZM11.9996 2.75C9.96957 2.75 8.30957 4.41 8.30957 6.44C8.30957 8.44 9.86957 10.05 11.8596 10.12C11.9096 10.11 12.0496 10.11 12.1796 10.12C14.1396 10.03 15.6796 8.42 15.6896 6.44C15.6896 4.41 14.0296 2.75 11.9996 2.75Z" fill="#4B4B4B" />
                                            <path d="M12.1696 22.55C10.2096 22.55 8.23961 22.05 6.74961 21.05C5.35961 20.13 4.59961 18.87 4.59961 17.5C4.59961 16.13 5.35961 14.86 6.74961 13.93C9.74961 11.94 14.6096 11.94 17.5896 13.93C18.9696 14.85 19.7396 16.11 19.7396 17.48C19.7396 18.85 18.9796 20.12 17.5896 21.05C16.0896 22.05 14.1296 22.55 12.1696 22.55ZM7.57961 15.19C6.61961 15.83 6.09961 16.65 6.09961 17.51C6.09961 18.36 6.62961 19.18 7.57961 19.81C10.0696 21.48 14.2696 21.48 16.7596 19.81C17.7196 19.17 18.2396 18.35 18.2396 17.49C18.2396 16.64 17.7096 15.82 16.7596 15.19C14.2696 13.53 10.0696 13.53 7.57961 15.19Z" fill="#4B4B4B" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('company_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center 
                            !bg-[#B62326] text-white font-bold
                            !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                            focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                التالي
                            </button>
                        </div>
                    </form>
                    <a href="{{ route('login') }}" class="border-0 !font-[400] !pt-3 !text-[#4B4B4B]"> لديك حساب ؟ 
                        <span class="text-[#B62326] font-bold">تسجيل دخول</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const dropdown = document.getElementById('user_type');
    const companyNameField = document.getElementById('companyNameField');

    dropdown.addEventListener('change', function () {
        if (this.value === 'sales_point') {
            companyNameField.style.display = 'block';
        } else {
            companyNameField.style.display = 'none';
        }
    });
</script>
@endsection