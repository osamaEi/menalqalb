
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



<img src="{{ asset('app/img/curve2.png') }}" class="z-50 w-[106px] absolute" alt="">

<div class="app white messagebox">
    <div class="header !mb-0">
        <a href="{{ route('app.home') }}">
            <img src="{{ asset('app/img/black.png') }}" alt="" class="img-fluid logo">
        </a>
    </div>
    <p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
        {{__('new_congratulation')}}
    </p>
    
    <img src="{{ asset('app/img/step4.png') }}" class="w-[303px] mx-auto" alt="">
    
    <a href="{{ route('app.messages.create.step3') }}" class="z-50 !p-2 !absolute left-5 top-5 icondoor">
        <i class="fas fa-arrow-alt-circle-left text-[#4B4B4B] text-[19px] pl-3 w-[65px]"></i>
    </a>
    
    <!-- Points Display -->
    <div class="bg-[#B62326] rounded-[12px] w-[330px] h-[48px] mx-auto flex items-center justify-between px-3 mt-3 mb-5">
        <span class="text-[#FFF] text-[15px]">{{__('point')}}</span>
        <span class="text-[#FFF] text-[32px]">{{ number_format(Auth::user()->points ?? 20000) }}</span>
        <span class="text-[#FFF] text-[15px]">{{__('available_points')}}</span>
    </div>
    
    <div class="row justify-content-center overflow-y-auto">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <div>
                    <!-- Display validation errors -->
                    @if($errors->any())
                        <div class="alert alert-danger mt-3 mx-3">
                            <ul class="list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    
                    <!-- Session messages -->
                    @if(session('error'))
                        <div class="alert alert-danger mt-3 mx-3">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="rounded-lg px-0 pb-8 w-full">
                        <p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
                            {{__('confirm_data_before_card')}}
                        </p>
                        
                        <!-- Message Content Preview -->
                        <p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
                            {{__('private_message')}}
                        </p>
                        <p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#B62326] z-50 mt-0 relative">
                            {{ $step3Data['message_content'] }}
                        </p>
                        
                        <!-- Details Grid - Top Row -->
                        <div class="flex items-center justify-between my-3 mb-2 px-3">
                            <div class="w-[113px]">
                                <p>{{__('main_category')}}</p>
                                <p class="text-[#B62326]">{{ $mainCategory->name ?? __('undefined') }}</p>
                            </div>
                            <div class="w-[113px]">
                                <p>{{__('message_language')}}</p>
                                <p class="text-[#B62326]">{{ $languages[$step1Data['recipient_language']] ?? __('undefined') }}</p>
                            </div>
                        </div>
                        
                        <!-- Details Grid - Second Row -->
                        <div class="flex items-center justify-between my-3 mb-2 px-3">
                            <div class="w-[113px]">
                                <p>{{__('sub_category')}}</p>
                                <p class="text-[#B62326]">{{ $subCategory->name ?? __('undefined') }}</p>
                            </div>
                            <div class="w-[113px]">
                                <p>{{__('heart_lock')}}</p>
                                <p class="text-[#B62326]">{{ $lockTypes[$step3Data['lock_type']] ?? __('undefined') }}</p>
                            </div>
                        </div>
                        
                        <!-- Details Grid - Third Row -->
                        <div class="flex items-center justify-between my-3 mb-2 px-3">
                            <div class="w-[113px]">
                                <p>{{__('lock_code')}}</p>
                                <p class="text-[#B62326]">{{ $step1Data['card_number'] ?? __('undefined') }}</p>
                            </div>
                            <div class="w-[113px]">
                                <p>{{__('dedication_type')}}</p>
                                <p class="text-[#B62326]">{{ $dedicationType->type ?? __('undefined') }}</p>
                            </div>
                        </div>
                        
                        <!-- Details Grid - Fourth Row -->
                        <div class="flex items-center justify-between my-3 mb-2 px-3">
                            <div class="w-[113px]">
                                <p>{{__('recipient')}}</p>
                                <p class="text-[#B62326]">{{ $step3Data['recipient_name'] ?? __('undefined') }}</p>
                            </div>
                            
                            @if(isset($step3Data['lock_type']) && $step3Data['lock_type'] !== 'no_lock')
                            <div class="w-[113px]">
                                <p>{{__('phone_number')}}</p>
                                <p class="text-[#B62326]">{{ $step3Data['recipient_phone'] }}</p>
                            </div>
                            @else
                            <div class="w-[113px]">
                                <p>{{__('sender')}}</p>
                                <p class="text-[#B62326]">{{ $step3Data['sender_name'] ?? Auth::user()->name }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Cost Details -->
                        <div class="flex items-center justify-between my-3 mb-2 px-3">
                            <div class="w-full">
                                <p class="text-center">{{__('sending_cost')}}</p>
                                <p class="text-center text-[#B62326] font-bold">200 {{__('point')}}</p>
                            </div>
                        </div>
    
                        <!-- Action Buttons -->
                        <form method="POST" action="{{ route('app.store') }}" class="px-3">
                            @csrf
                            
                            <!-- Preview Card Button -->
                            <a href="#" id="previewCardBtn" class="!mb-5 !m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center border-0 !bg-[#000] text-white font-bold !rounded-full hover:bg-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                                <i class="fas fa-eye ml-2"></i> {{__('preview_card')}}
                            </a>
                            
                            <!-- Submit Button -->
                            <button type="submit" class="!mb-4 !m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center !bg-[#B62326] text-white font-bold !rounded-full hover:bg-[#a31f22] transition-colors focus:outline-none focus:ring-2 focus:ring-[#B62326] focus:ring-offset-2">
                                {{__('confirm_input')}} <i class="fas fa-check mr-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Preview Modal -->
    <div id="cardPreviewModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg max-w-md w-full p-4 relative">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-700 hover:text-gray-900">
                <i class="fas fa-times"></i>
            </button>
            
            <h3 class="text-xl font-bold text-[#4B4B4B] text-center mb-4">{{__('card_preview')}}</h3>
            
            <div class="flex justify-center mb-4">
                <img src="{{ asset('storage/'. $card->file_path) ?? asset('img/card-placeholder.png') }}" class="max-h-80 rounded-lg shadow" alt="{{ $card->title ?? __('selected_card') }}">
            </div>
            
            <div class="bg-[#F9F9F9] p-4 rounded-lg mb-4">
                <p class="text-[#B62326] leading-relaxed">{{ $step3Data['message_content'] }}</p>
            </div>
            
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-gray-600">{{__('from')}}</p>
                    <p class="font-medium">{{ $step3Data['sender_name'] ?? Auth::user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">{{__('to')}}</p>
                    <p class="font-medium">{{ $step3Data['recipient_name'] ?? __('undefined') }}</p>
                </div>
            </div>
            
            <button id="closeModalBtn2" class="w-full h-12 bg-[#B62326] text-white font-bold rounded-full mt-4">
                {{__('close')}}
            </button>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Card preview modal
    const previewCardBtn = document.getElementById('previewCardBtn');
    const cardPreviewModal = document.getElementById('cardPreviewModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const closeModalBtn2 = document.getElementById('closeModalBtn2');
    
    previewCardBtn.addEventListener('click', function(e) {
        e.preventDefault();
        cardPreviewModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    });
    
    function closeModal() {
        cardPreviewModal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }
    
    closeModalBtn.addEventListener('click', closeModal);
    closeModalBtn2.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    cardPreviewModal.addEventListener('click', function(e) {
        if (e.target === cardPreviewModal) {
            closeModal();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !cardPreviewModal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
</body>
</div>

</html>