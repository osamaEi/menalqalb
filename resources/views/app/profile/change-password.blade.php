@extends('app.index')

@section('content')
<div class="app white messagebox">
    
    <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">تغيير كلمة المرور</h1>
    <p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
        يرجى إدخال كلمة المرور الحالية وكلمة المرور الجديدة
    </p>

    <div class="row justify-content-center overflow-y-auto h-[100%]">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <div class="rounded-lg px-0 pb-8 w-full">
                        <form method="POST" action="{{ route('app.profile.update-password') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div class="!mt-1">
                                <label for="current_password">كلمة المرور الحالية</label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input type="password" id="current_password" name="current_password"
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="كلمة المرور الحالية" />
                                    <div class="px-4 password-toggle cursor-pointer" data-target="current_password">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="eye-icon">
                                            <path d="M12 5C5.636 5 2 12 2 12C2 12 5.636 19 12 19C18.364 19 22 12 22 12C22 12 18.364 5 12 5Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 15C13.657 15 15 13.657 15 12C15 10.343 13.657 9 12 9C10.343 9 9 10.343 9 12C9 13.657 10.343 15 12 15Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('current_password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <!-- New Password -->
                            <div class="!mt-3">
                                <label for="password">كلمة المرور الجديدة</label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input type="password" id="password" name="password"
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="كلمة المرور الجديدة" />
                                    <div class="px-4 password-toggle cursor-pointer" data-target="password">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="eye-icon">
                                            <path d="M12 5C5.636 5 2 12 2 12C2 12 5.636 19 12 19C18.364 19 22 12 22 12C22 12 18.364 5 12 5Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 15C13.657 15 15 13.657 15 12C15 10.343 13.657 9 12 9C10.343 9 9 10.343 9 12C9 13.657 10.343 15 12 15Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <!-- Confirm Password -->
                            <div class="!mt-3">
                                <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="تأكيد كلمة المرور الجديدة" />
                                    <div class="px-4 password-toggle cursor-pointer" data-target="password_confirmation">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="eye-icon">
                                            <path d="M12 5C5.636 5 2 12 2 12C2 12 5.636 19 12 19C18.364 19 22 12 22 12C22 12 18.364 5 12 5Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 15C13.657 15 15 13.657 15 12C15 10.343 13.657 9 12 9C10.343 9 9 10.343 9 12C9 13.657 10.343 15 12 15Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-6 !font-[500] flex items-center justify-center 
                                        !bg-[#B62326] text-white font-bold
                                        !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                                        focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                    تغيير كلمة المرور
                                </button>
                            </div>
                        </form>
                        
                        <!-- Back to Profile Link -->
                        <a href="{{ route('app.profile.edit') }}" class="block text-center border-0 !font-[400] !pt-3 !text-[#4B4B4B]">
                            العودة إلى الملف الشخصي
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle visibility functionality
        const toggleButtons = document.querySelectorAll('.password-toggle');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 5C5.636 5 2 12 2 12C2 12 5.636 19 12 19C18.364 19 22 12 22 12C22 12 18.364 5 12 5Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 15C13.657 15 15 13.657 15 12C15 10.343 13.657 9 12 9C10.343 9 9 10.343 9 12C9 13.657 10.343 15 12 15Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="4" y1="4" x2="20" y2="20" stroke="#4B4B4B" stroke-width="1.5"/>
                    </svg>`;
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="eye-icon">
                        <path d="M12 5C5.636 5 2 12 2 12C2 12 5.636 19 12 19C18.364 19 22 12 22 12C22 12 18.364 5 12 5Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 15C13.657 15 15 13.657 15 12C15 10.343 13.657 9 12 9C10.343 9 9 10.343 9 12C9 13.657 10.343 15 12 15Z" stroke="#4B4B4B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>`;
                }
            });
        });
    });
</script>
@endsection