
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('app/img/logo.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('app/sass/style.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('sass/style-ar.css') }}" rel="stylesheet"> -->
    <title> MIN ALQALB ❤ من القلب </title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: "Cairo", sans-serif;
        }
        
        /* Additional styles for the card layout */
        .allDevice {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .allDevice li {
            margin-bottom: 20px;
        }
        
        .media-width {
            margin-top: -33px;
        }
        
        .card-item {
            position: relative;
            margin-bottom: 30px;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .points-badge {
            width: 50px;
            height: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3px;
            position: absolute;
            right: -5px;
            top: -4px; 
            background-color: #B62326;
            color: white;
            border-radius: 50%;
            font-size: 12px;
            line-height: 1;
            z-index: 10;
        }
        
        .card-title-bar {
            width: 100%;
            background-color: black;
            z-index: 999;
            position: relative;
            padding: 2px;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
        }
        
        .card-action-button {
            position: absolute;
            width: 124px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
            transform: rotate(90deg);
            z-index: 9;
        }
        
        .view-button {
            left: -38px;
            top: 38px;
            background-color: #B62326;
            color: white;
            border-bottom-left-radius: 15px;
        }
        
        .select-button {
            left: -38px;
            bottom: 28.55px;
            background-color: #000;
            color: white;
            border-bottom-right-radius: 15px;
        }
    </style>
</head>
<!-- <Transleat code Start> -->
<div id="rootElement" lang="en_US">
    <!-- <Transleat code End> -->


<img src="{{ asset('app/img/curve2.png') }}" class="w-[106px] absolute" alt="">

<div class="app white messagebox">
    <div class="header !mb-0">
        <a href="{{ route('app.home') }}">
            <img src="{{ asset('app/img/black.png') }}" alt="" class="img-fluid logo">
        </a>
    </div>
    <p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
        ارسال تهنئة جديدة
    </p>
    <img src="{{ asset('app/img/step3.png') }}" class="w-[303px] mx-auto" alt="">
    
    <div class="row justify-content-center overflow-y-auto h-[530px]">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <div>
                    <div class="rounded-lg px-0 w-full">
                        <!-- Display validation errors -->
                        @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul class="list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('app.messages.post.step3') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Private Message -->
                            <div class="!mt-1">
                                <label for="message_content" class="localized" data-content="الرسالة الخاصة"></label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[122px] relative rounded-[50px] mt-0 border !border-black">
                                <div class="overflow-hidden flex items-center">
                                    <textarea id="message_content" name="message_content" 
                                        class="relative left-[-2px] right-[-20px] w-[100px] bg-transparent h-[122px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="">{{ old('message_content', $sessionData['message_content'] ?? '') }}</textarea>
                                </div>
                            </div>
                            
                            <!-- Sender Name -->
                            <div class="!mt-1">
                                <label for="sender_name" class="localized" data-content="اسم المرسل"></label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input type="text" id="sender_name" name="sender_name"
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="الاسم" value="{{ old('sender_name', $sessionData['sender_name'] ?? auth()->user()->name ?? '') }}" />
                                </div>
                            </div>
                            
                            <!-- Sender Phone -->
                            <label for="sender_phone" class="!mt-1 localized sender-phone-label" data-content="رقم المرسل"></label>
                            <div class="bg-transparent !mt-1 h-[59px] relative rounded-[31px] border !border-black sender-phone-container">
                                <div class="flex items-center">
                                    <!-- Country Flag and Code -->
                                    <div class="flex items-center p-0 max-w-[126px] h-[59px]">
                                        <!-- Country Selector Component -->
                                        <div class="country-selector relative">
                                            <button type="button" class="!bg-[#F9F9F9] m-0 justify-between flex items-center space-x-2 p-2 rounded-md" id="senderCountryButton">
                                                <div class="flag-icon w-8 h-5 ml-2">
                                                    <svg viewBox="0 0 40 24" class="w-full h-full">
                                                        <rect width="40" height="8" fill="#00732f" />
                                                        <rect y="8" width="40" height="8" fill="#ffffff" />
                                                        <rect y="16" width="40" height="8" fill="#000000" />
                                                        <rect width="12" height="24" fill="#ff0000" />
                                                    </svg>
                                                </div>
                                                <span class="text-lg font-extrabold text-black" id="senderCountryCode">{{ old('sender_country_code', $sessionData['sender_country_code'] ?? '971') }}</span>
                                            </button>
                                            
                                            <!-- Hidden input for sender country code -->
                                            <input type="hidden" name="sender_country_code" id="sender_country_code_input" 
                                                value="{{ old('sender_country_code', $sessionData['sender_country_code'] ?? '971') }}">
                                            
                                            <!-- Country Dropdown (Hidden by Default) -->
                                            <div class="country-dropdown bg-white absolute z-[999999] mt-1 w-64 shadow-lg rounded-[9px] border border-gray-200 hidden" id="senderCountryDropdown">
                                                <!-- Search Box -->
                                                <div class="p-2 border-b border-gray-200">
                                                    <input type="text" id="senderCountrySearch" placeholder="ابحث عن دولة..." 
                                                        class="w-full p-2 border border-gray-300 rounded-[9px] focus:outline-none">
                                                </div>
                                                
                                                <!-- Countries List -->
                                                <div class="max-h-60 overflow-y-auto py-1 sender-country-list">
                                                    <!-- Countries will be dynamically added here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Phone Input -->
                                    <input type="tel" id="sender_phone" name="sender_phone" required 
                                        class="text-center w-[100px] bg-[#F9F9F9] flex-grow px-0 text-lg focus:outline-none"
                                        placeholder="-- -- ---" value="{{ old('sender_phone', $sessionData['sender_phone'] ?? auth()->user()->phone ?? '') }}" />
                                    
                                    <!-- Phone Icon -->
                                    <div class="px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-50 h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recipient Name -->
                            <div class="!mt-1">
                                <label for="recipient_name" class="localized" data-content="اسم المرسل له"></label>
                            </div>
                            <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                <div class="flex items-center">
                                    <input type="text" id="recipient_name" name="recipient_name" required
                                        class="relative right-[-20px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                        placeholder="الاسم" value="{{ old('recipient_name', $sessionData['recipient_name'] ?? '') }}" />
                                </div>
                            </div>
                            
                            <!-- Recipient Phone -->
                            <label for="recipient_phone" class="!mt-1 localized recipient-phone-label" data-content="رقم المرسل له"></label>
                            <div class="bg-transparent !mt-1 h-[59px] relative rounded-[31px] border !border-black recipient-phone-container">
                                <div class="flex items-center">
                                    <!-- Country Flag and Code -->
                                    <div class="flex items-center p-0 max-w-[126px] h-[59px]">
                                        <!-- Country Selector Component -->
                                        <div class="country-selector relative">
                                            <button type="button" class="!bg-[#F9F9F9] m-0 justify-between flex items-center space-x-2 p-2 rounded-md" id="recipientCountryButton">
                                                <div class="flag-icon w-8 h-5 ml-2">
                                                    <svg viewBox="0 0 40 24" class="w-full h-full">
                                                        <rect width="40" height="8" fill="#00732f" />
                                                        <rect y="8" width="40" height="8" fill="#ffffff" />
                                                        <rect y="16" width="40" height="8" fill="#000000" />
                                                        <rect width="12" height="24" fill="#ff0000" />
                                                    </svg>
                                                </div>
                                                <span class="text-lg font-extrabold text-black" id="recipientCountryCode">{{ old('recipient_country_code', $sessionData['recipient_country_code'] ?? '971') }}</span>
                                            </button>
                                            
                                            <!-- Hidden input for recipient country code -->
                                            <input type="hidden" name="recipient_country_code" id="recipient_country_code_input" 
                                                value="{{ old('recipient_country_code', $sessionData['recipient_country_code'] ?? '971') }}">
                                            
                                            <!-- Country Dropdown (Hidden by Default) -->
                                            <div class="country-dropdown bg-white absolute z-[999999] mt-1 w-64 shadow-lg rounded-[9px] border border-gray-200 hidden" id="recipientCountryDropdown">
                                                <!-- Search Box -->
                                                <div class="p-2 border-b border-gray-200">
                                                    <input type="text" id="recipientCountrySearch" placeholder="ابحث عن دولة..." 
                                                        class="w-full p-2 border border-gray-300 rounded-[9px] focus:outline-none">
                                                </div>
                                                
                                                <!-- Countries List -->
                                                <div class="max-h-60 overflow-y-auto py-1 recipient-country-list">
                                                    <!-- Countries will be dynamically added here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Phone Input -->
                                    <input type="tel" id="recipient_phone" name="recipient_phone" required
                                        class="text-center w-[100px] bg-[#F9F9F9] flex-grow px-0 text-lg focus:outline-none"
                                        placeholder="-- -- ---" value="{{ old('recipient_phone', $sessionData['recipient_phone'] ?? '') }}" />
                                    
                                    <!-- Phone Icon -->
                                    <div class="px-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-50 h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>

                                    

                                </div>
                            </div>
                            <!-- Scheduled Date Field -->
<div class="relative !mt-3 scheduled-date-container">
    <label for="scheduled_at" class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center scheduled-date-label">
        موعد الإرسال المجدول
    </label>
    <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-2 border !border-black">
        <div class="flex items-center">
            <input type="datetime-local" id="scheduled_at" name="scheduled_at"
                class="relative bg-transparent h-[57px] flex-grow text-center text-lg focus:outline-none"
                value="{{ old('scheduled_at', $sessionData['scheduled_at'] ?? '') }}" />
            <div class="px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>
</div>
                            <!-- Heart Lock Option -->
                            <div class="relative !mt-3">
                                <label for="lock_type" class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">
                                    اضافة قفل القلب
                                </label>
                                <select id="lock_type" name="lock_type" required
                                    class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none">
                                    <option value="">الرجاء الاختيار</option>
                                    <option value="lock_without_heart" {{ old('lock_type', $sessionData['lock_type'] ?? '') == 'lock_without_heart' ? 'selected' : '' }}>نعم بدون قفل القلب</option>
                                    <option value="lock_with_heart" {{ old('lock_type', $sessionData['lock_type'] ?? '') == 'lock_with_heart' ? 'selected' : '' }}>نعم بقفل القلب</option>
                                    <option value="no_lock" {{ old('lock_type', $sessionData['lock_type'] ?? '') == 'no_lock' ? 'selected' : '' }}>لا</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Navigation Buttons -->
                            <div class="grid grid-cols-2 gap-4 px-0 mb-6 !mt-5">
                                <a href="{{ route('app.messages.create.step2') }}" class="!m-0 !h-[55px] !text-[14px] !w-[100%] flex items-center justify-center text-[#B62326] border border-[#B62326] font-bold rounded-full hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-arrow-right ml-2"></i> السابق
                                </a>
                                <button type="submit" class="!m-0 !h-[55px] !text-[14px] !w-[100%] flex items-center justify-center !bg-[#B62326] text-white font-bold rounded-full hover:bg-[#a31f22] transition-colors">
                                    التالي <i class="fas fa-arrow-left mr-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Country data for dropdowns
        const countries = [
            { code: '971', name: 'الإمارات العربية المتحدة', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="8" fill="#00732f" /><rect y="8" width="40" height="8" fill="#ffffff" /><rect y="16" width="40" height="8" fill="#000000" /><rect width="12" height="24" fill="#ff0000" /></svg>' },
            { code: '966', name: 'المملكة العربية السعودية', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="24" fill="#006c35" /><g transform="translate(13, 8)"><path d="M0,0 H18 M0,4 H18 M9,0 V8" stroke="#fff" stroke-width="1" /><text x="9" y="6" font-size="4" text-anchor="middle" fill="#fff">لا إله إلا الله</text></g></svg>' },
            { code: '20', name: 'مصر', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="8" fill="#ce1126" /><rect y="8" width="40" height="8" fill="#ffffff" /><rect y="16" width="40" height="8" fill="#000000" /><g transform="translate(20, 12)" fill="#c09300"><circle r="3" /></g></svg>' },
            { code: '974', name: 'قطر', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="24" fill="#8d1b3d" /><path d="M 0,0 L 11,0 L 11,24 L 0,24 Z" fill="#ffffff" /><path d="M 0,0 L 11,0 L 11,24 L 0,24 L 9,12 Z" fill="#8d1b3d" /></svg>' },
            { code: '965', name: 'الكويت', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="8" fill="#007a3d" /><rect y="8" width="40" height="8" fill="#ffffff" /><rect y="16" width="40" height="8" fill="#ce1126" /><polygon points="0,0 0,24 13,16 13,8" fill="#000000" /></svg>' },
            { code: '973', name: 'البحرين', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="24" fill="#ce1126" /><path d="M 0,0 L 13,0 L 8,4 L 13,8 L 8,12 L 13,16 L 8,20 L 13,24 L 0,24 Z" fill="#ffffff" /></svg>' },
            { code: '968', name: 'عمان', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="8" fill="#ffffff" /><rect y="8" width="40" height="8" fill="#db161b" /><rect y="16" width="40" height="8" fill="#008000" /><rect width="12" height="24" fill="#db161b" /></svg>' },
            { code: '962', name: 'الأردن', flag: '<svg viewBox="0 0 40 24" class="w-full h-full"><rect width="40" height="8" fill="#000000" /><rect y="8" width="40" height="8" fill="#ffffff" /><rect y="16" width="40" height="8" fill="#007a3d" /><polygon points="0,0 0,24 20,12" fill="#ce1126" /><circle cx="7" cy="12" r="2" fill="#ffffff" /></svg>' }
        ];
        
        // Populate country lists
        const senderCountryList = document.querySelector('.sender-country-list');
        const recipientCountryList = document.querySelector('.recipient-country-list');
        
        // Function to populate country list
        function populateCountryList(listElement, countries) {
            listElement.innerHTML = '';
            countries.forEach(country => {
                const countryItemHtml = `
                    <div class="country-item flex items-center p-2 hover:bg-gray-100 cursor-pointer" data-code="${country.code}" data-flag='${country.flag}'>
                        <div class="flag-icon w-8 h-5 mr-3">${country.flag}</div>
                        <span class="text-sm">${country.name}</span>
                        <span class="text-sm text-gray-500 mr-auto">+${country.code}</span>
                    </div>
                `;
                
                listElement.innerHTML += countryItemHtml;
            });
        }
        
        // Populate both country lists
        populateCountryList(senderCountryList, countries);
        populateCountryList(recipientCountryList, countries);
        
        // Sender country dropdown toggle
        const senderCountryButton = document.getElementById('senderCountryButton');
        const senderCountryDropdown = document.getElementById('senderCountryDropdown');
        const senderCountryCode = document.getElementById('senderCountryCode');
        const senderCountryCodeInput = document.getElementById('sender_country_code_input');
        const senderCountrySearch = document.getElementById('senderCountrySearch');
        
        senderCountryButton.addEventListener('click', function() {
            senderCountryDropdown.classList.toggle('hidden');
            recipientCountryDropdown.classList.add('hidden'); // Close the other dropdown
        });
        
        // Recipient country dropdown toggle
        const recipientCountryButton = document.getElementById('recipientCountryButton');
        const recipientCountryDropdown = document.getElementById('recipientCountryDropdown');
        const recipientCountryCode = document.getElementById('recipientCountryCode');
        const recipientCountryCodeInput = document.getElementById('recipient_country_code_input');
        const recipientCountrySearch = document.getElementById('recipientCountrySearch');
        
        recipientCountryButton.addEventListener('click', function() {
            recipientCountryDropdown.classList.toggle('hidden');
            senderCountryDropdown.classList.add('hidden'); // Close the other dropdown
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!senderCountryButton.contains(event.target) && !senderCountryDropdown.contains(event.target)) {
                senderCountryDropdown.classList.add('hidden');
            }
            
            if (!recipientCountryButton.contains(event.target) && !recipientCountryDropdown.contains(event.target)) {
                recipientCountryDropdown.classList.add('hidden');
            }
        });
        
        // Search functionality for sender country
        if (senderCountrySearch) {
            senderCountrySearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredCountries = countries.filter(country => 
                    country.name.toLowerCase().includes(searchTerm) || 
                    country.code.includes(searchTerm)
                );
                populateCountryList(senderCountryList, filteredCountries);
                
                // Re-attach event listeners for filtered items
                document.querySelectorAll('.sender-country-list .country-item').forEach(item => {
                    attachSenderCountryClickEvent(item);
                });
            });
        }
        
        // Search functionality for recipient country
        if (recipientCountrySearch) {
            recipientCountrySearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredCountries = countries.filter(country => 
                    country.name.toLowerCase().includes(searchTerm) || 
                    country.code.includes(searchTerm)
                );
                populateCountryList(recipientCountryList, filteredCountries);
                
                // Re-attach event listeners for filtered items
                document.querySelectorAll('.recipient-country-list .country-item').forEach(item => {
                    attachRecipientCountryClickEvent(item);
                });
            });
        }
        
        // Function to attach click event to sender country items
        function attachSenderCountryClickEvent(item) {
            item.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                const flag = this.getAttribute('data-flag');
                
                senderCountryButton.querySelector('.flag-icon').innerHTML = flag;
                senderCountryCode.textContent = code;
                senderCountryCodeInput.value = code; // Update hidden input
                senderCountryDropdown.classList.add('hidden');
            });
        }
        
        // Function to attach click event to recipient country items
        function attachRecipientCountryClickEvent(item) {
            item.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                const flag = this.getAttribute('data-flag');
                
                recipientCountryButton.querySelector('.flag-icon').innerHTML = flag;
                recipientCountryCode.textContent = code;
                recipientCountryCodeInput.value = code; // Update hidden input
                recipientCountryDropdown.classList.add('hidden');
            });
        }
        
        // Country selection for sender
        document.querySelectorAll('.sender-country-list .country-item').forEach(item => {
            attachSenderCountryClickEvent(item);
        });
        
        // Country selection for recipient
        document.querySelectorAll('.recipient-country-list .country-item').forEach(item => {
            attachRecipientCountryClickEvent(item);
        });
        
        const lockTypeSelect = document.getElementById('lock_type');
const recipientPhoneContainer = document.querySelector('.recipient-phone-container');
const recipientPhoneLabel = document.querySelector('.recipient-phone-label');
const scheduledDateContainer = document.querySelector('.scheduled-date-container');
const scheduledDateLabel = document.querySelector('.scheduled-date-label');
        
lockTypeSelect.addEventListener('change', function() {
    if (this.value === 'no_lock') {
        // Hide recipient phone field
        recipientPhoneContainer.style.display = 'none';
        recipientPhoneLabel.style.display = 'none';
        document.getElementById('recipient_phone').removeAttribute('required');
        document.getElementById('recipient_country_code_input').removeAttribute('required');
        
        // Hide scheduled date field
        scheduledDateContainer.style.display = 'none';
        document.getElementById('scheduled_at').removeAttribute('required');
    } else {
        // Show recipient phone field
        recipientPhoneContainer.style.display = 'block';
        recipientPhoneLabel.style.display = 'block';
        document.getElementById('recipient_phone').setAttribute('required', 'required');
        document.getElementById('recipient_country_code_input').setAttribute('required', 'required');
        
        // Show scheduled date field
        scheduledDateContainer.style.display = 'block';
    }
});
        // Initialize recipient phone visibility based on initial lock type value
        if (lockTypeSelect.value === 'no_lock') {
    recipientPhoneContainer.style.display = 'none';
    recipientPhoneLabel.style.display = 'none';
    document.getElementById('recipient_phone').removeAttribute('required');
    document.getElementById('recipient_country_code_input').removeAttribute('required');
    
    scheduledDateContainer.style.display = 'none';
    document.getElementById('scheduled_at').removeAttribute('required');
}
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validate message content
            const messageContent = document.getElementById('message_content');
            if (!messageContent.value.trim()) {
                messageContent.classList.add('border-red-500');
                isValid = false;
            } else {
                messageContent.classList.remove('border-red-500');
            }
            
            // Validate sender name
            const senderName = document.getElementById('sender_name');
            if (!senderName.value.trim()) {
                senderName.parentElement.classList.add('border-red-500');
                isValid = false;
            } else {
                senderName.parentElement.classList.remove('border-red-500');
            }
            
            // Validate sender phone
            const senderPhone = document.getElementById('sender_phone');
            if (!senderPhone.value.trim()) {
                senderPhone.parentElement.parentElement.classList.add('border-red-500');
                isValid = false;
            } else {
                senderPhone.parentElement.parentElement.classList.remove('border-red-500');
            }
            
            // Validate recipient name
            const recipientName = document.getElementById('recipient_name');
            if (!recipientName.value.trim()) {
                recipientName.parentElement.classList.add('border-red-500');
                isValid = false;
            } else {
                recipientName.parentElement.classList.remove('border-red-500');
            }
            
            // Validate recipient phone if lock type is not 'no_lock'
            const lockType = document.getElementById('lock_type');
            if (lockType.value !== 'no_lock') {
                const recipientPhone = document.getElementById('recipient_phone');
                if (!recipientPhone.value.trim()) {
                    recipientPhone.parentElement.parentElement.classList.add('border-red-500');
                    isValid = false;
                } else {
                    recipientPhone.parentElement.parentElement.classList.remove('border-red-500');
                }
            }
            
            // Validate lock type
            if (!lockType.value) {
                lockType.classList.add('border-red-500');
                isValid = false;
            } else {
                lockType.classList.remove('border-red-500');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
            }
        });
    });
</script>
</body>
</div>

</html>