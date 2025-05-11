@extends('app.index')

@section('content')
<div class="app white messagebox pb-[25px] !overflow-auto">
    <div class="header !mb-0">
        <a href="{{ route('app.greetings.index') }}" class="z-50 !p-2 !absolute left-0 !mt-2 icondoor">
            <i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
        </a>
        <a href="{{ route('home') }}"><img src="{{ asset('img/black.png') }}" alt="" class="img-fluid logo"></a>
    </div>
    <p class="text-center text-[16px] mb-2 leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
        لوحة تحكم البطاقات الخاصة
    </p>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 mx-4">
        {{ session('success') }}
    </div>
    @endif

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
        <p class="{{ $message->status == 'sent' ? 'text-[#0FA64B]' : 'text-[#B62326]' }} text-[16px] px-3">
            {{ $message->status == 'sent' ? 'مؤكد' : 'غير مؤكد' }}
        </p>
    </div>
    
    <div class="flex items-center justify-between !bg-transparent p-3 text-center rounded-[13px] mx-2 relative">
        <a href="{{ route('app.messages.show-response', $message->id) }}" class="h-[48px] w-[48%] bg-[#B62326] text-[#FFF] p-2 text-[12px] text-center flex items-center justify-center gap-1"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            عرض الرد
        </a>
        <a href="{{ route('app.greetings.show-card', $message->id) }}" class="h-[48px] w-[48%] bg-[#000] text-[#FFF] p-2 text-[12px] text-center flex items-center justify-center gap-1"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            عرض البطاقة
        </a>
    </div>
    
    <div class="flex items-center justify-between !bg-transparent px-3 text-center rounded-[13px] mx-2 relative">
        <a href="{{ route('app.greetings.scheduled-time', $message->id) }}" class="h-[48px] w-[48%] bg-[#000] text-[#FFF] p-2 text-[12px] text-center flex items-center justify-center gap-1"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            وقت ارسال التهنئة
            <br />
            {{ $message->scheduled_at ? $message->scheduled_at->format('d/m/Y H:i:s') : 'غير محدد' }}
        </a>
        <a href="{{ route('app.greetings.private-message', $message->id) }}" class="h-[48px] w-[48%] bg-[#B62326] text-[#FFF] p-2 text-[12px] text-center flex items-center justify-center gap-1"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            الرسالة الخاصة
        </a>
    </div>
    
    <div class="flex items-center justify-between !bg-transparent p-3 text-center rounded-[13px] mx-2 relative">
        @if($message->status != 'sent' && (!$message->scheduled_at || $message->scheduled_at->isPast()))
        <form action="{{ route('app.greetings.send', $message->id) }}" method="POST" class="w-[48%]">
            @csrf
            <button type="submit" class="invitation-button w-full h-[48px] bg-[#B62326] text-[#FFF] p-2 text-[12px] text-center flex items-center justify-center gap-1"
                style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
                ارسال رسالة التهنئة
            </button>
        </form>
        @else
        <a href="#" class="invitation-button w-[48%] h-[48px] bg-[#B62326] text-[#FFF] p-2 text-[12px] text-center flex items-center justify-center gap-1 opacity-50 cursor-not-allowed"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            {{ $message->status == 'sent' ? 'تم الإرسال' : 'بإنتظار وقت الإرسال' }}
        </a>
        @endif
        
        <a href="{{ route('app.greetings.edit', $message->id) }}" class="h-[48px] w-[48%] bg-[#000] text-[#FFF] p-2 text-[12px] text-center flex items-center justify-center gap-1"
            style="border-top-right-radius: 13px; border-bottom-left-radius: 13px;">
            تعديل بيانات البطاقة
        </a>
    </div>
</div>

<!-- Confirmation Popup -->
<div class="overlay" id="popupOverlay" style="display: {{ session('success') ? 'flex' : 'none' }};">
    <div class="popup {{ session('success') ? 'active' : '' }}" id="confirmationPopup">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" fill="#4CAF50" />
            </svg>
        </div>
        <h3>تم التأكيد</h3>
        <p>{{ session('success') ?? 'تم إرسال التهنئة بنجاح!' }}</p>
        <button class="close-button" id="closePopup">إغلاق</button>
    </div>
</div>

<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 100;
    }
    
    .popup {
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        text-align: center;
        max-width: 320px;
        width: 80%;
        position: relative;
        transform: scale(0.8);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .popup.active {
        transform: scale(1);
        opacity: 1;
    }
    
    .popup h3 {
        color: #B62326;
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 18px;
    }
    
    .popup p {
        color: #333;
        margin-bottom: 25px;
        font-size: 14px;
    }
    
    .close-button {
        background-color: #B62326;
        color: white;
        border: none;
        padding: 8px 30px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .close-button:hover {
        background-color: #9a1c1f;
    }
    
    .success-icon {
        width: 60px;
        height: 60px;
        background-color: #f0f8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }
    
    .success-icon svg {
        width: 30px;
        height: 30px;
        fill: #4CAF50;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popupOverlay = document.getElementById('popupOverlay');
        const confirmationPopup = document.getElementById('confirmationPopup');
        const closePopup = document.getElementById('closePopup');
        
        if (closePopup) {
            closePopup.addEventListener('click', function () {
                confirmationPopup.classList.remove('active');
                setTimeout(() => {
                    popupOverlay.style.display = 'none';
                }, 300);
            });
        }
        
        if (popupOverlay) {
            popupOverlay.addEventListener('click', function (e) {
                if (e.target === popupOverlay) {
                    confirmationPopup.classList.remove('active');
                    setTimeout(() => {
                        popupOverlay.style.display = 'none';
                    }, 300);
                }
            });
        }
    });
</script>
@endsection