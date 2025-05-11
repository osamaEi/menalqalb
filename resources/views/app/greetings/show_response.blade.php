@extends('app.index')

@section('content')
<div class="app white messagebox pb-[25px] !overflow-auto">
    <div class="header !mb-0">
        <a href="{{ route('app.greetings.show', $message->id) }}" class="z-50 !p-2 !absolute left-0 !mt-2 icondoor">
            <i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
        </a>
    </div>
    <p class="text-center text-[16px] mb-2 leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
        لوحة تحكم البطاقات الخاصة
    </p>
    
    <div class="flex flex-col items-end justify-end !bg-transparent p-3 text-center shadow-lg mt-0 rounded-[13px] mx-2 relative">
        <div class="flex flex-row justify-end">
            <p class="relative font-bold text-[#242424]">
                {{ $message->mainCategory ? $message->mainCategory->name : 'غير محدد' }}
            </p>
            <p class="bg-[#B62326] text-[#FFF] p-2 relative right-[-16px] top-[-20px]"
                style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
                {{ $message->scheduled_at ? $message->scheduled_at->format('d/m/Y') : 'غير محدد' }}
            </p>
        </div>
        <div>
            <p>اللغة : {{ $message->recipient_language ?? 'غير محدد' }}</p>
        </div>
        <div class="w-full flex items-center justify-between gap-2">
            <p>قفل القلب : {{ $message->lock_type == 'lock_with_heart' ? 'نعم' : 'لا' }}</p>
            <p>النوع : {{ $message->card && $message->card->type ? $message->card->type : 'صورة' }}</p>
        </div>
        <div class="w-full flex items-center justify-between gap-2">
            <p>رمز القفل : {{ $message->masked_unlock_code ?? 'غير محدد' }}</p>
            <p>قفل البطاقة : {{ $message->lock_type != 'no_lock' ? 'نعم' : 'لا' }}</p>
        </div>
        <div class="w-100 h-[1px] my-3 bg-[#C5C5C5]"></div>
        <p class="text-[#0FA64B] text-[16px] px-3">
            {{ $message->status == 'sent' ? 'مؤكد' : 'غير مؤكد' }}
        </p>
    </div>
    
    <div class="flex items-center flex-col justify-between !bg-transparent p-3 text-center rounded-[13px] mx-2 relative">
        <p class="mt-5 text-[#B62326] mx-auto text-[16px] leading-[26px]">
            {{ $message->response ?? 'لم يتم استلام رد حتى الآن' }}
        </p>
        <p class="py-2 text-black mx-auto text-[16px] leading-[26px]">وقت الارسال</p>
        <p class="text-black mx-auto text-[16px] leading-[26px]">
            {{ $message->scheduled_at ? $message->scheduled_at->format('d/m/Y H:i:s') : 'غير محدد' }}
        </p>
    </div>
</div>
@endsection