<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('app/img/logo.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('app/sass/style.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('app/sass/style-ar.css') }}" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title> MIN ALQALB ❤ من القلب </title>
    <style>
        body,
        html {
            font-family: 'Cairo' !important;
            height: 100%;
            overflow-y: auto !important;
        }

        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
        }

        .flag-icon {
            width: 40px;
            height: 24px;
            background-size: cover;
        }
        
        .app.messagebox {
            position: relative;
            min-height: 100vh;
            overflow-y: auto !important;
            padding-bottom: 2rem;
        }
        
        .header {
            margin-bottom: 0;
        }
        
        .localized[data-content]::before {
            content: attr(data-content);
            display: block;
            text-align: center;
            font-size: 1.125rem;
            font-weight: 500;
            color: #4B4B4B;
        }
        
        .space-y-6 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(1.5rem * var(--tw-space-y-reverse));
        }
        
        .icondoor {
            position: absolute;
            left: 20px;
            top: 20px;
            font-size: 24px;
            color: #000;
            z-index: 100;
        }
        
        .img-fluid {
            max-width: 100%;
            height: auto;
        }
        
        .logo {
            max-height: 80px;
            margin: 0 auto;
            display: block;
        }
        
        .curveRight {
            position: absolute;
            right: 0;
            top: 0;
            z-index: -1;
            max-width: 120px;
        }
    </style>
</head>

<div id="rootElement" lang="en">
    <div class="app white messagebox">
        <div class="header">
            <a href="{{ route('app.home') }}" class="icondoor"><i class="fas fa-arrow-alt-circle-left"></i></a>
            <a href="{{ route('app.home') }}"><img src="{{ asset('app/img/black.png') }}" alt="" class="img-fluid logo" style="width:247px;"></a>
            <img src="{{ asset('app/img/curve2.png') }}" alt="" class="img-fluid curveRight">
        </div>

        <body class="">
            <div class="app white messagebox">
                <p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
                    ارسال تهنئة جديدة
                </p>
                <img src="{{ asset('app/img/step1.png') }}" class="w-[303px] mx-auto" alt="">
                <div class="bg-[#B62326] rounded-[12px] w-[330px] h-[48px] mx-auto flex items-center justify-between px-3 mt-3">
                    <span class="text-[#FFF] text-[15px]">نقطة</span>
                    <span class="text-[#FFF] text-[32px]">{{ number_format(Auth::user()->points ?? 20000) }}</span>
                    <span class="text-[#FFF] text-[15px]">النقاط المتوفر</span>
                </div>
                <!-- <img src="img/back2.png" alt="" class="img-fluid bk"> -->
                <div class="row justify-content-center overflow-y-auto h-[100%]">
                    <div class="col-12 col-lg-4">
                        <div class="All_Button lang Devices">
                            <div>
                                <div class="rounded-lg px-0 pb-8 w-full">
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

                                    <!-- Session messages -->
                                    @if(session('error'))
                                        <div class="alert alert-danger mt-3">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    @if(session('success'))
                                        <div class="alert alert-success mt-3">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('app.messages.post.step1') }}" class="space-y-6">
                                        @csrf
                                        
                                        <!-- Language Selection -->
                                        <div class="relative !mt-3">
                                            <label for="recipient_language" class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">لغة
                                                التهنئة</label>
                                            <select id="recipient_language" name="recipient_language" 
                                                class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                <option value="">اختر اللغة</option>
                                                @foreach($languages as $code => $name)
                                                    <option value="{{ $code }}" {{ (old('recipient_language', $sessionData['recipient_language'] ?? '') == $code) ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Main Category -->
                                        <div class="relative !mt-3">
                                            <label for="main_category_id" class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">التصنيفات
                                                الرئيسي</label>
                                            <select id="main_category_id" name="main_category_id" 
                                                class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                <option value="">اختر التصنيف الرئيسي</option>
                                                @foreach($mainCategories as $category)
                                                    <option value="{{ $category->id }}" {{ (old('main_category_id', $sessionData['main_category_id'] ?? '') == $category->id) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Sub Category -->
                                        <div class="relative !mt-3">
                                            <label for="sub_category_id" class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">
                                                اختر التصنيف الفرعي</label>
                                            <select id="sub_category_id" name="sub_category_id" 
                                                class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                <option value="">اختر التصنيف الفرعي</option>
                                                <!-- Will be populated via JavaScript -->
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Dedication Type -->
                                        <div class="relative !mt-3">
                                            <label for="dedication_type_id" class="block text-lg font-medium text-[#4B4B4B] bg-transparent text-center">
                                                اختر نوع الاهداء</label>
                                            <select id="dedication_type_id" name="dedication_type_id" 
                                                class="text-[#4B4B4B] bg-transparent text-center block appearance-none w-[99%] border !border-[#4B4B4B] rounded-full py-3 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                <option value="">اختر نوع الاهداء</option>
                                                @foreach($dedicationTypes as $type)
                                                    <option value="{{ $type->id }}" {{ (old('dedication_type_id', $sessionData['dedication_type_id'] ?? '') == $type->id) ? 'selected' : '' }}>
                                                        {{ __($type->type) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-4 text-gray-700 top-8">
                                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Card Number Field -->
                                        <div class="!mt-1">
                                            <label for="card_number" class="localized" data-content="رقم البطاقة"></label>
                                        </div>
                                        <div class="bg-[#F9F9F9] max-h-[59px] relative rounded-[35px] mt-0 border !border-black">
                                            <div class="flex items-center">
                                                <input type="text" id="card_number" name="card_number" 
                                                    value="{{ old('card_number', $sessionData['card_number'] ?? '') }}"
                                                    maxlength="4" pattern="[0-9]{4}"
                                                    class="relative right-[29px] w-[100px] bg-transparent h-[57px] flex-grow text-lg focus:outline-none text-center"
                                                    placeholder="0000" required 
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                                <div class="px-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V12H20V18ZM20 8H4V6H20V8Z"
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
                                                التالي
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Card number validation - only allow 4 digits
    const cardNumberInput = document.getElementById('card_number');
    cardNumberInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }
    });
    
    // Load subcategories when main category changes
    const mainCategorySelect = document.getElementById('main_category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    
    // Function to load subcategories
    function loadSubcategories(mainCategoryId, selectedSubcategoryId = null) {
        if (!mainCategoryId) {
            subCategorySelect.innerHTML = '<option value="">اختر التصنيف الفرعي</option>';
            return;
        }
        
        // Show loading
        subCategorySelect.innerHTML = '<option value="">جارٍ التحميل...</option>';
        
        fetch(`/app/subcategories/${mainCategoryId}`)
            .then(response => response.json())
            .then(data => {
                subCategorySelect.innerHTML = '<option value="">اختر التصنيف الفرعي</option>';
                
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name_ar;
                    
                    // If there was a previously selected subcategory, select it
                    if (selectedSubcategoryId && selectedSubcategoryId == category.id) {
                        option.selected = true;
                    }
                    
                    subCategorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading subcategories:', error);
                subCategorySelect.innerHTML = '<option value="">حدث خطأ في تحميل التصنيفات</option>';
            });
    }
    
    // Load subcategories on change
    mainCategorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });
    
    // Initial load of subcategories if main category is already selected
    if (mainCategorySelect.value) {
        const initialSubCategoryId = '{{ old("sub_category_id", $sessionData["sub_category_id"] ?? "") }}';
        loadSubcategories(mainCategorySelect.value, initialSubCategoryId);
    }
});
</script>

</html>