@extends('app.index')

@section('content')
<div class="app white messagebox pb-[25px] !overflow-auto">
    <div class="header !mb-0">
        <a href="{{ route('app.messages.show', $message->id) }}" class="z-50 !p-2 !absolute left-0 !mt-2 icondoor">
            <i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
        </a>
        <a href="{{ route('home') }}"><img src="{{ asset('img/black.png') }}" alt="" class="img-fluid logo"></a>
    </div>
    <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative text-center">تعديل بيانات البطاقة</h1>
    <p class="text-center text-[14px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-2 relative">
        يمكنك تعديل تفاصيل بطاقة التهنئة هنا
    </p>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 mx-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center overflow-y-auto h-[100%]">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <form method="POST" action="{{ route('app.messages.update', $message->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Card Information (Read-only) -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <h3 class="font-bold text-lg mb-2">معلومات البطاقة</h3>
                        <div class="flex justify-between mb-2">
                            <span>التصنيف الرئيسي:</span>
                            <span>{{ $message->mainCategory ? $message->mainCategory->name : 'غير محدد' }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>التصنيف الفرعي:</span>
                            <span>{{ $message->subCategory ? $message->subCategory->name : 'غير محدد' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>نوع البطاقة:</span>
                            <span>{{ $message->card && $message->card->type ? $message->card->type : 'صورة' }}</span>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="!mt-3">
                        <label for="message_content" class="block text-lg font-medium text-[#4B4B4B]">الرسالة</label>
                        <textarea id="message_content" name="message_content" rows="4" 
                            class="bg-[#F9F9F9] w-full rounded-[15px] mt-1 p-3 border !border-gray-300 text-right"
                            placeholder="اكتب رسالتك هنا">{{ old('message_content', $message->message_content) }}</textarea>
                    </div>

                    <!-- Recipient Name -->
                    <div class="!mt-3">
                        <label for="recipient_name" class="block text-lg font-medium text-[#4B4B4B]">اسم المستلم</label>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-1 border !border-gray-300">
                            <div class="flex items-center">
                                <input value="{{ old('recipient_name', $message->recipient_name) }}" type="text" 
                                    id="recipient_name" name="recipient_name"
                                    class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                    placeholder="اسم المستلم" />
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.1596 11.62C12.1296 11.62 12.1096 11.62 12.0796 11.62C12.0296 11.61 11.9596 11.61 11.8996 11.62C8.99957 11.53 6.80957 9.25 6.80957 6.44C6.80957 3.58 9.13957 1.25 11.9996 1.25C14.8596 1.25 17.1896 3.58 17.1896 6.44C17.1796 9.25 14.9796 11.53 12.1896 11.62C12.1796 11.62 12.1696 11.62 12.1596 11.62ZM11.9996 2.75C9.96957 2.75 8.30957 4.41 8.30957 6.44C8.30957 8.44 9.86957 10.05 11.8596 10.12C11.9096 10.11 12.0496 10.11 12.1796 10.12C14.1396 10.03 15.6796 8.42 15.6896 6.44C15.6896 4.41 14.0296 2.75 11.9996 2.75Z" fill="#4B4B4B" />
                                        <path d="M12.1696 22.55C10.2096 22.55 8.23961 22.05 6.74961 21.05C5.35961 20.13 4.59961 18.87 4.59961 17.5C4.59961 16.13 5.35961 14.86 6.74961 13.93C9.74961 11.94 14.6096 11.94 17.5896 13.93C18.9696 14.85 19.7396 16.11 19.7396 17.48C19.7396 18.85 18.9796 20.12 17.5896 21.05C16.0896 22.05 14.1296 22.55 12.1696 22.55ZM7.57961 15.19C6.61961 15.83 6.09961 16.65 6.09961 17.51C6.09961 18.36 6.62961 19.18 7.57961 19.81C10.0696 21.48 14.2696 21.48 16.7596 19.81C17.7196 19.17 18.2396 18.35 18.2396 17.49C18.2396 16.64 17.7096 15.82 16.7596 15.19C14.2696 13.53 10.0696 13.53 7.57961 15.19Z" fill="#4B4B4B" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lock Type -->
                    <div class="!mt-3">
                        <label for="lock_type" class="block text-lg font-medium text-[#4B4B4B]">نوع القفل</label>
                        <select id="lock_type" name="lock_type" 
                            class="bg-[#F9F9F9] text-center block appearance-none w-full rounded-[35px] py-3 px-4 mt-1 text-lg border !border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="no_lock" {{ old('lock_type', $message->lock_type) == 'no_lock' ? 'selected' : '' }}>لا</option>
                            <option value="lock_without_heart" {{ old('lock_type', $message->lock_type) == 'lock_without_heart' ? 'selected' : '' }}>نعم بدون قفل قلب</option>
                            <option value="lock_with_heart" {{ old('lock_type', $message->lock_type) == 'lock_with_heart' ? 'selected' : '' }}>نعم مع قفل قلب</option>
                        </select>
                    </div>

                    <!-- Recipient Phone (Conditional) -->
                    <div id="recipient_phone_container" class="!mt-3 {{ old('lock_type', $message->lock_type) == 'no_lock' ? 'hidden' : '' }}">
                        <label for="recipient_phone" class="block text-lg font-medium text-[#4B4B4B]">رقم هاتف المستلم</label>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-1 border !border-gray-300">
                            <div class="flex items-center">
                                <input value="{{ old('recipient_phone', $message->recipient_phone) }}" type="text" 
                                    id="recipient_phone" name="recipient_phone"
                                    class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                    placeholder="5xxxxxxxx" />
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unlock Code (Conditional) -->
                    <div id="unlock_code_container" class="!mt-3 {{ old('lock_type', $message->lock_type) == 'no_lock' ? 'hidden' : '' }}">
                        <label for="unlock_code" class="block text-lg font-medium text-[#4B4B4B]">رمز فتح القفل</label>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-1 border !border-gray-300">
                            <div class="flex items-center">
                                <input value="{{ old('unlock_code', $message->unlock_code) }}" type="text" 
                                    id="unlock_code" name="unlock_code"
                                    class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                    placeholder="رمز فتح القفل" />
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">اترك هذا الحقل فارغًا إذا كنت لا ترغب في تغيير رمز فتح القفل</p>
                    </div>

                    <!-- Scheduled Time -->
                    <div class="!mt-3">
                        <label for="scheduled_at" class="block text-lg font-medium text-[#4B4B4B]">موعد الإرسال</label>
                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-1 border !border-gray-300">
                            <div class="flex items-center">
                                <input value="{{ old('scheduled_at', $message->scheduled_at ? $message->scheduled_at->format('Y-m-d\TH:i') : '') }}" 
                                    type="datetime-local" id="scheduled_at" name="scheduled_at"
                                    class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center" />
                                <div class="px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-6 !font-[500] flex items-center justify-center 
                                !bg-[#B62326] text-white font-bold
                                !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                                focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lockTypeSelect = document.getElementById('lock_type');
        const recipientPhoneContainer = document.getElementById('recipient_phone_container');
        const unlockCodeContainer = document.getElementById('unlock_code_container');
        
        // Function to toggle visibility of conditional fields
        function toggleConditionalFields() {
            if (lockTypeSelect.value === 'no_lock') {
                recipientPhoneContainer.classList.add('hidden');
                unlockCodeContainer.classList.add('hidden');
            } else {
                recipientPhoneContainer.classList.remove('hidden');
                unlockCodeContainer.classList.remove('hidden');
            }
        }
        
        // Set initial state
        toggleConditionalFields();
        
        // Add change event listener
        lockTypeSelect.addEventListener('change', toggleConditionalFields);
    });
</script>
@endsection