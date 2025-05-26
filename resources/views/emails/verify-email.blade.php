<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Verify Your Email') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }
        .btn-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-xl mx-auto my-10">
        <!-- Header with Logo -->
        <div class="gradient-bg py-6 px-6 rounded-t-lg text-center">
            <img src="{{ url('front/images/logo.png') }}" class="mx-auto h-12" alt="{{ __('Logo') }}">
        </div>
        
        <!-- Email Content -->
        <div class="bg-white shadow-lg rounded-b-lg overflow-hidden border border-gray-200">
            <div class="px-8 py-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ __('Welcome aboard') }}, {{ $user->name }}!</h2>
                <p class="text-gray-600 mb-6">{{ __('Thank you for registering with us. To complete your registration, please verify your email address by clicking the button below:') }}</p>
                
                <div class="text-center my-8">
                    <a href="{{ $verificationUrl }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg btn-hover text-lg">
                        {{ __('Verify Email Address') }}
                    </a>
                </div>
                
                <p class="text-gray-500 text-sm mb-6">{{ __('This verification link will expire in 24 hours.') }}</p>
                
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <p class="text-gray-500 text-sm">{{ __('If you did not create an account, no further action is required.') }}</p>
                    <p class="text-gray-500 text-sm mt-2">{{ __('If you\'re having trouble clicking the button, copy and paste the URL below into your web browser:') }}</p>
                    <p class="text-blue-500 text-sm break-all mt-2">{{ $verificationUrl }}</p>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center text-gray-500 text-xs mt-6">
            <p>{{ __('©') }} {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            <p class="mt-1">{{ __('If you have any questions, contact us at support@example.com') }}</p>
        </div>
    </div>
</body>
</html>