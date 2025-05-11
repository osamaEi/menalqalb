@extends('app.index')

@section('content')
<div class="app white messagebox pb-[25px] !overflow-auto">
    <div class="header !mb-0">
        <a href="{{ route('app.messages.show', $message->id) }}" class="z-50 !p-2 !absolute left-0 !mt-2 icondoor">
            <i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
        </a>
    </div>
    <p class="text-center text-[16px] mb-2 leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
        الرسالة الخاصة
    </p>
    
    <div class="flex flex-col items-center justify-center !bg-transparent p-5 text-center mt-5 rounded-[13px] mx-2 relative">
        <div class="bg-white rounded-lg p-6 shadow-md w-full">
            <h2 class="text-xl font-bold text-[#B62326] mb-4">رسالتك الخاصة</h2>
            <div class="p-4 bg-gray-50 rounded-lg text-right">
                <p class="text-gray-800 text-lg">
                    {{ $message->message_content ?? 'لا توجد رسالة خاصة' }}
                </p>
            </div>
            
            <div class="mt-6">
                <h3 class="font-bold mb-2 text-[#242424]">تفاصيل إضافية</h3>
                <div class="flex justify-between border-b pb-2 mb-2">
                    <span>المرسل:</span>
                    <span>{{ $message->sender_name }}</span>
                </div>
                <div class="flex justify-between border-b pb-2 mb-2">
                    <span>المستقبل:</span>
                    <span>{{ $message->recipient_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span>المناسبة:</span>
                    <span>{{ $message->subCategory ? $message->subCategory->name : 'غير محدد' }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex items-center justify-center !bg-transparent p-3 text-center rounded-[13px] mx-2 mt-4">
        <a href="{{ route('app.greetings.show', $message->id) }}" class="h-[48px] w-[50%] bg-[#B62326] text-[#FFF] p-2 text-[14px] text-center flex items-center justify-center gap-1"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            العودة إلى تفاصيل البطاقة
        </a>
    </div>
</div>
@endsection