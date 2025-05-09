@extends('app.index')

@section('content')
<h1 class="text-[24px] text-[#242424] font-[900] z-50 relative">مبروك! تم إنشاء حسابك بنجاح</h1>
<p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
    يمكنك الآن تسجيل الدخول واستخدام جميع مميزات تطبيقنا
</p>

<div class="row justify-content-center">
    <div class="col-12 col-lg-4">
        <div class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            
            <div class="mt-8">
                <a href="{{ route('app.login') }}" class="!m-0 !h-[55px] !text-[14px] !w-[75%] mx-auto mt-0 !font-[500] flex items-center justify-center 
                !bg-[#B62326] text-white font-bold
                !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                    تسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</div>
@endsection