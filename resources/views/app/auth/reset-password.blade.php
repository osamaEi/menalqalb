@extends('app.index')
@section('content')
        <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">إعادة تعيين كلمة المرور</h1>
        <p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
            أدخل كلمة المرور الجديدة الخاصة بك
        </p>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4">
                <div class="All_Button lang Devices">
                    <div class="rounded-lg p-8 w-full">
                        @if (session('error'))
                            <div class="text-red-500 text-center mb-4">{{ session('error') }}</div>
                        @endif
                        <form class="space-y-6" method="POST" action="{{ route('app.forgot-password.reset.store') }}">
                            @csrf
                            <div class="bg-[#F9F9F9] h-[55px] relative mt-0 rounded-[39px] border !border-[#000000]">
                                <input type="password" name="password" id="passwordInput" class="w-full h-full text-center bg-transparent px-4 text-lg focus:outline-none" placeholder="كلمة المرور" required>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4B4B4B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <div class="bg-[#F9F9F9] h-[55px] relative mt-0 rounded-[39px] border !border-[#000000]">
                                <input type="password" name="password_confirmation" class="w-full h-full text-center bg-transparent px-4 text-lg focus:outline-none" placeholder="تأكيد كلمة المرور" required>
                            </div>
                            @error('password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <div class="flex justify-center">
                                <button type="submit" class="!m-0 !h-[55px] !w-[100%] mt-0 !font-[400] flex items-center justify-center !bg-[#B62326] text-white font-bold !rounded-full hover:bg-[#B62326]-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                    إعادة تعيين
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            let isPasswordVisible = false;
            togglePassword.addEventListener('click', () => {
                isPasswordVisible = !isPasswordVisible;
                if (isPasswordVisible) {
                    passwordInput.type = 'text';
                    togglePassword.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c5.185 0 9.448 4.014 9.95 9.048-.502 5.034-4.765 9.048-9.95 9.048S2.552 18.582 2.05 13.548C2.552 8.514 6.815 4.5 12 4.5zm0 3a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                    `;
                } else {
                    passwordInput.type = 'password';
                    togglePassword.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    `;
                }
            });
        </script>
    </body>
@endsection