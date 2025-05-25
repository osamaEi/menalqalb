@extends('app.index')

@section('content')
<h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">{{__('Password')}}</h1>
<p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
    {{__('Enter the new password')}}
</p>

<div class="row justify-content-center">
    <div class="col-12 col-lg-4 ">
        <div class="All_Button lang Devices">
            <div>
                <div class="rounded-lg px-0 pb-8 w-full">
                    <form class="space-y-6" method="POST" action="{{ route('app.register.password') }}">
                        @csrf
                        
                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Password Field -->
                        <div class="!mt-10">
                            <label for="password" class="localized" data-content="{{__('Password')}}"></label>
                        </div>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                            <div class="flex items-center">
                                <!-- Lock Icon -->
                                <div class="px-4">
                                    <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg"
                                        class="cursor-pointer h-6 w-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </div>

                                <!-- Password Input -->
                                <input type="password" id="password" name="password"
                                    class="w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                    placeholder="************" required />
                                    
                                <!-- Lock Icon -->
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                        viewBox="0 0 24 25" fill="none">
                                        <path
                                            d="M18 11.25C17.59 11.25 17.25 10.91 17.25 10.5V8.5C17.25 5.35 16.36 3.25 12 3.25C7.64 3.25 6.75 5.35 6.75 8.5V10.5C6.75 10.91 6.41 11.25 6 11.25C5.59 11.25 5.25 10.91 5.25 10.5V8.5C5.25 5.6 5.95 1.75 12 1.75C18.05 1.75 18.75 5.6 18.75 8.5V10.5C18.75 10.91 18.41 11.25 18 11.25Z"
                                            fill="#4B4B4B" />
                                        <path
                                            d="M17 23.25H7C2.59 23.25 1.25 21.91 1.25 17.5V15.5C1.25 11.09 2.59 9.75 7 9.75H17C21.41 9.75 22.75 11.09 22.75 15.5V17.5C22.75 21.91 21.41 23.25 17 23.25ZM7 11.25C3.42 11.25 2.75 11.93 2.75 15.5V17.5C2.75 21.07 3.42 21.75 7 21.75H17C20.58 21.75 21.25 21.07 21.25 17.5V15.5C21.25 11.93 20.58 11.25 17 11.25H7Z"
                                            fill="#4B4B4B" />
                                        <path
                                            d="M8 17.4999C7.87 17.4999 7.74 17.4699 7.62 17.4199C7.49 17.3699 7.39001 17.2999 7.29001 17.2099C7.11001 17.0199 7 16.7699 7 16.4999C7 16.3699 7.02999 16.2399 7.07999 16.1199C7.12999 15.9899 7.20001 15.8899 7.29001 15.7899C7.39001 15.6999 7.49 15.6299 7.62 15.5799C7.98 15.4199 8.42999 15.5099 8.70999 15.7899C8.79999 15.8899 8.87001 15.9999 8.92001 16.1199C8.97001 16.2399 9 16.3699 9 16.4999C9 16.7599 8.88999 17.0199 8.70999 17.2099C8.51999 17.3899 8.26 17.4999 8 17.4999Z"
                                            fill="#4B4B4B" />
                                        <path
                                            d="M12 17.4999C11.74 17.4999 11.48 17.3899 11.29 17.2099C11.11 17.0199 11 16.7699 11 16.4999C11 16.3699 11.02 16.2399 11.08 16.1199C11.13 15.9999 11.2 15.8899 11.29 15.7899C11.52 15.5599 11.87 15.4499 12.19 15.5199C12.26 15.5299 12.32 15.5499 12.38 15.5799C12.44 15.5999 12.5 15.6299 12.56 15.6699C12.61 15.6999 12.66 15.7499 12.71 15.7899C12.8 15.8899 12.87 15.9999 12.92 16.1199C12.97 16.2399 13 16.3699 13 16.4999C13 16.7699 12.89 17.0199 12.71 17.2099C12.66 17.2499 12.61 17.2899 12.56 17.3299C12.5 17.3699 12.44 17.3999 12.38 17.4199C12.32 17.4499 12.26 17.4699 12.19 17.4799C12.13 17.4899 12.06 17.4999 12 17.4999Z"
                                            fill="#4B4B4B" />
                                        <path
                                            d="M16 17.4999C15.73 17.4999 15.48 17.3899 15.29 17.2099C15.2 17.1099 15.13 16.9999 15.08 16.8799C15.03 16.7599 15 16.6299 15 16.4999C15 16.2399 15.11 15.9799 15.29 15.7899C15.34 15.7499 15.39 15.7099 15.44 15.6699C15.5 15.6299 15.56 15.5999 15.62 15.5799C15.68 15.5499 15.74 15.5299 15.8 15.5199C16.13 15.4499 16.47 15.5599 16.71 15.7899C16.89 15.9799 17 16.2299 17 16.4999C17 16.6299 16.97 16.7599 16.92 16.8799C16.87 17.0099 16.8 17.1099 16.71 17.2099C16.52 17.3899 16.26 17.4999 16 17.4999Z"
                                            fill="#4B4B4B" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center 
                            !bg-[#B62326] text-white font-bold
                            !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                            focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                {{__('Save')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility for password field
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
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
    
    // Toggle password visibility for confirm password field
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    let isConfirmPasswordVisible = false;

    toggleConfirmPassword.addEventListener('click', () => {
        isConfirmPasswordVisible = !isConfirmPasswordVisible;
        if (isConfirmPasswordVisible) {
            confirmPasswordInput.type = 'text';
            toggleConfirmPassword.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5c5.185 0 9.448 4.014 9.95 9.048-.502 5.034-4.765 9.048-9.95 9.048S2.552 18.582 2.05 13.548C2.552 8.514 6.815 4.5 12 4.5zm0 3a4.5 4.5 0 100 9 4.5 4.5 0 000-9z" />
            `;
        } else {
            confirmPasswordInput.type = 'password';
            toggleConfirmPassword.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        }
    });
</script>
@endsection