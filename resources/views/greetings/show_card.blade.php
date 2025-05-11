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
        <p class="relative font-bold text-[#242424]">
            {{ $message->mainCategory ? $message->mainCategory->name : 'غير محدد' }}
        </p>
        
        @if($message->card && $message->card->image_path)
        <img src="{{ asset('storage/' . $message->card->file_path) }}" class="h-[450px] w-[100%] rounded-[15px] mt-[20px]" alt="صورة البطاقة">
        @else
        <img src="{{ asset('app/img/show-card.png') }}" class="h-[450px] w-[100%] rounded-[15px] mt-[20px]" alt="صورة البطاقة افتراضية">
        @endif
    </div>
</div>
@endsection