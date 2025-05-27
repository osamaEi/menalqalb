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


    
    <body class>
        <div class="app white messagebox">
            <div class="header">
                <a href="{{ route('app.messages.create.step1') }}" class="icondoor"><i class="fas fa-arrow-alt-circle-left"></i></a>
                <a href="{{ route('app.home') }}"><img src="{{ asset('app/img/black.png') }}" alt class="img-fluid logo"></a>
            </div>
            <img src="{{ asset('app/img/back2.png') }}" alt class="img-fluid bk">
    
            <div class="row justify-content-center">
                <div>
                    <img class="w-[97%] mx-auto !flex items-center justify-center px-2" src="{{ asset('app/img/step2.png') }}" alt>
                    <div class="gap-2 text-center justify-center items-center px-3 flex flex-column">
                        <div>
                            <h3 for="txtMessage Box" class="font-bold block text-[#B62326] text-[17px] localized" data-content="{{ __('select_greeting_card') }}">
                                {{ __('select_greeting_card') }}
                            </h3>
                        </div>
                        
                        <!-- Filter options for card categories -->
                        <div class="flex justify-between items-center gap-3 px-2">
                            <p class="name flex items-center justify-center gap-2">
                                {{ $step1Data ? App\Models\Category::find($step1Data['main_category_id'])->name ?? __('main_category') : __('main_category') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12.3701 8.87988H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.37988 8.87988L7.12988 9.62988L9.37988 7.37988" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.3701 15.8799H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.37988 15.8799L7.12988 16.6299L9.37988 14.3799" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                            <p class="name flex items-center justify-center gap-2">
                                {{ $step1Data ? App\Models\Category::find($step1Data['sub_category_id'])->name_ar ?? __('sub_category') : __('sub_category') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12.3701 8.87988H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.37988 8.87988L7.12988 9.62988L9.37988 7.37988" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12.3701 15.8799H17.6201" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.37988 15.8799L7.12988 16.6299L9.37988 14.3799" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center gap-3 px-2">
                            <p class="text-black name flex items-center justify-center gap-2 w-[149px]">
                                {{ $step1Data && $step1Data['recipient_language'] == 'ar' ? __('arabic') : __('english') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="black">
                                    <path d="M12 22.75C6.07 22.75 1.25 17.93 1.25 12C1.25 6.07 6.07 1.25 12 1.25C17.93 1.25 22.75 6.07 22.75 12C22.75 17.93 17.93 22.75 12 22.75ZM12 2.75C6.9 2.75 2.75 6.9 2.75 12C2.75 17.1 6.9 21.25 12 21.25C17.1 21.25 21.25 17.1 21.25 12C21.25 6.9 17.1 2.75 12 2.75Z" fill="black" />
                                    <path d="M8.99999 21.75H7.99999C7.58999 21.75 7.24999 21.41 7.24999 21C7.24999 20.59 7.56999 20.26 7.97999 20.25C6.40999 14.89 6.40999 9.11 7.97999 3.75C7.56999 3.74 7.24999 3.41 7.24999 3C7.24999 2.59 7.58999 2.25 7.99999 2.25H8.99999C9.23999 2.25 9.46999 2.37 9.60999 2.56C9.74999 2.76 9.78999 3.01 9.70999 3.24C7.82999 8.89 7.82999 15.11 9.70999 20.77C9.78999 21 9.74999 21.25 9.60999 21.45C9.46999 21.63 9.23999 21.75 8.99999 21.75Z" fill="black" />
                                    <path d="M15 21.7502C14.92 21.7502 14.84 21.7402 14.76 21.7102C14.37 21.5802 14.15 21.1502 14.29 20.7602C16.17 15.1102 16.17 8.89018 14.29 3.23018C14.16 2.84018 14.37 2.41018 14.76 2.28018C15.16 2.15018 15.58 2.36018 15.71 2.75018C17.7 8.71018 17.7 15.2702 15.71 21.2202C15.61 21.5502 15.31 21.7502 15 21.7502Z" fill="black" />
                                    <path d="M12 17.1998C9.21 17.1998 6.43 16.8098 3.75 16.0198C3.74 16.4198 3.41 16.7498 3 16.7498C2.59 16.7498 2.25 16.4098 2.25 15.9998V14.9998C2.25 14.7598 2.37 14.5298 2.56 14.3898C2.76 14.2498 3.01 14.2098 3.24 14.2898C8.89 16.1698 15.12 16.1698 20.77 14.2898C21 14.2098 21.25 14.2498 21.45 14.3898C21.65 14.5298 21.76 14.7598 21.76 14.9998V15.9998C21.76 16.4098 21.42 16.7498 21.01 16.7498C20.6 16.7498 20.27 16.4298 20.26 16.0198C17.57 16.8098 14.79 17.1998 12 17.1998Z" fill="black" />
                                    <path d="M21 9.74986C20.92 9.74986 20.84 9.73986 20.76 9.70986C15.11 7.82986 8.88003 7.82986 3.23003 9.70986C2.83003 9.83986 2.41003 9.62986 2.28003 9.23986C2.16003 8.83986 2.37003 8.41986 2.76003 8.28986C8.72003 6.29986 15.28 6.29986 21.23 8.28986C21.62 8.41986 21.84 8.84986 21.7 9.23986C21.61 9.54986 21.31 9.74986 21 9.74986Z" fill="black" />
                                </svg>
                            </p>
                            <p class="text-black name flex items-center justify-center gap-2 w-[149px]">
                                {{ $step1Data ? App\Models\CardType::find($step1Data['dedication_type_id'])->type ?? __('dedication_type') : __('dedication_type') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
                                    <path d="M22 9V15C22 15.22 22 15.44 21.98 15.65C21.16 14.64 19.91 14 18.5 14C17.44 14 16.46 14.37 15.69 14.99C14.65 15.81 14 17.08 14 18.5C14 19.34 14.24 20.14 14.65 20.82C14.92 21.27 15.26 21.66 15.66 21.98C15.45 22 15.23 22 15 22H9C4 22 2 20 2 15V9C2 4 4 2 9 2H15C20 2 22 4 22 9Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin "round" />
                                    <path d="M2.51953 7.11035H21.4795" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8.51953 2.11035V6.97034" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15.4795 2.11035V6.52039" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M23 18.5C23 19.34 22.76 20.14 22.35 20.82C22.11 21.22 21.81 21.58 21.46 21.88C20.67 22.58 19.64 23 18.5 23C17.43 23 16.44 22.62 15.67 21.98H15.66C15.26 21.66 14.92 21.27 14.65 20.82C14.24 20.14 14 19.34 14 18.5C14 17.08 14.65 15.81 15.69 14.99C16.46 14.37 17.44 14 18.5 14C19.91 14 21.16 14.64 21.98 15.65C22.62 16.42 23 17.42 23 18.5Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.75 18.4996L17.86 19.6096L20.26 17.3896" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                        </div>
                    </div>
                    @php
                        $sessionData = session()->all();
                    @endphp
                    <!-- Start Form for Card Selection -->
                    <form method="POST" action="{{ route('app.messages.post.step2') }}" id="cardSelectionForm">
                        @csrf
                        <input type="hidden" id="card_id" name="card_id" value="{{ old('card_id', $sessionData['card_id'] ?? '') }}">
                        
                        <div>
                            <div class="col-12 col-lg-4">
                                <div class="All_Button lang Devices">
                                    <div>
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
    
                                        <!-- Card Grid -->
                                        <ul class="allDevice">
                                            @if(count($cards) > 0)
                                                @foreach($cards as $card)
                                                    <li class="relative card-item" data-id="{{ $card->id }}">
                                                        <!-- Points Badge -->
                                                        <div class="points-badge">
                                                            20
                                                            <br />
                                                            {{ __('points') }}
                                                        </div>
                                                        
                                                        <div class="flex flex-row-reverse w-[100%]">
                                                            <div class="w-[100%]">
                                                                @if($sessionData['message_step1']['dedication_type_id'] == 2)
                                                                    <video class="object-fill w-full h-auto" controls>
                                                                        <source src="{{ asset('storage/'. $card->file_path) }}" type="video/mp4">
                                                                        {{ __('video_not_supported') }}
                                                                    </video>
                                                                @else
                                                                    <img src="{{ asset('storage/'. $card->file_path) }}" alt="{{ $card->title }}" class="object-fill">
                                                                @endif
                                                                <div class="card-title-bar">
                                                                    <p class="name !text-white flex items-center justify-center pr-2 gap-2">
                                                                        {{ $card->title }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="items-center justify-center flex flex-col" style="border-top-left-radius: 0px !important; border-top-right-radius: 0px !important;" class="flex justify-between items-center !gap-0 mb-[7px] h-[48px] rounded-[15px] relative bottom-[-17px]">
                                                                <!-- View Button -->
                                                                <p class="card-action-button view-button">
                                                                    <a href="#" class="view-card-btn flex items-center justify-center gap-1 border-0 text-white" data-id="{{ $card->id }}">
                                                                        {{ __('view') }}
                                                                        <svg class="min-w-[24px] min-h-[24px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                            <path d="M11.75 22.5C5.83 22.5 1 17.68 1 11.75C1 5.82 5.83 1 11.75 1C17.67 1 22.5 5.82 22.5 11.75C22.5 17.68 17.68 22.5 11.75 22.5ZM11.75 2.5C6.65 2.5 2.5 6.65 2.5 11.75C2.5 16.85 6.65 21 11.75 21C16.85 21 21 16.85 21 11.75C21 6.65 16.85 2.5 11.75 2.5Z" fill="white" />
                                                                            <path d="M10.56 16.99C10.12 16.99 9.69999 16.88 9.32999 16.67C8.46999 16.17 7.98999 15.19 7.98999 13.91V10.56C7.98999 9.27999 8.45999 8.29999 9.31999 7.79999C10.18 7.29999 11.27 7.37999 12.38 8.01999L15.28 9.68999C16.39 10.33 17 11.23 17 12.23C17 13.22 16.39 14.13 15.28 14.77L12.38 16.44C11.76 16.81 11.13 16.99 10.56 16.99ZM10.56 8.96999C10.38 8.96999 10.21 9.00999 10.08 9.08999C9.69999 9.30999 9.48999 9.83999 9.48999 10.56V13.91C9.48999 14.62 9.69999 15.16 10.08 15.37C10.45 15.59 11.02 15.5 11.64 15.15L14.54 13.48C15.16 13.12 15.51 12.67 15.51 12.24C15.51 11.81 15.15 11.36 14.54 11L11.64 9.32999C11.24 9.08999 10.87 8.96999 10.56 8.96999Z" fill="white" />
                                                                        </svg>
                                                                    </a>
                                                                </p>
                                                                <!-- Select Button -->
                                                                <p class="card-action-button select-button">
                                                                    <a href="#" class="select-card-btn flex items-center justify-center gap-2 text-white border-0" data-id="{{ $card->id }}" data-img="{{ $card->file_path }}">
                                                                        {{ __('select') }}
                                                                        <svg class="min-w-[24px] min-h-[24px] z-[999999999999] relative" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
                                                                            <path d="M16 22.75H3C2.04 22.75 1.25 21.96 1.25 21V8C1.25 3.58 3.58 1.25 8 1.25H16C20.42 1.25 22.75 3.58 22.75 8V16C22.75 20.42 20.42 22.75 16 22.75ZM8 2.75C4.42 2.75 2.75 4.42 2.75 8V21C2.75 21.14 2.86 21.25 3 21.25H16C19.58 21.25 21.25 19.58 21.25 16V8C21.25 4.42 19.58 2.75 16 2.75H8Z" fill="white" />
                                                                            <path d="M15.5 12.75H8.5C8.09 12.75 7.75 12.41 7.75 12C7.75 11.59 8.09 11.25 8.5 11.25H15.5C15.91 11.25 16.25 11.59 16.25 12C16.25 12.41 15.91 12.75 15.5 12.75Z" fill="white" />
                                                                            <path d="M12 16.25C11.59 16.25 11.25 15.91 11.25 15.5V8.5C11.25 8.09 11.59 7.75 12 7.75C12.41 7.75 12.75 8.09 12.75 8.5V15.5C12.75 15.91 12.41 16.25 12 16.25Z" fill="white" />
                                                                        </svg>
                                                                    </a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="text-center py-5">
                                                    <p>{{ __('no_cards_found') }}</p>
                                                </li>
                                            @endif
                                        </ul>
                                        
                                        <div class="flex justify-center">
                                            <button type="submit" class="!m-0 !h-[55px] !text-[14px] !w-[100%] mt-0 !font-[500] flex items-center justify-center !bg-[#B62326] text-white font-bold !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                                {{ __('next') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all necessary elements
                const cardItems = document.querySelectorAll('.card-item');
                const selectButtons = document.querySelectorAll('.select-card-btn');
                const cardIdInput = document.getElementById('card_id');
                const cardSelectionForm = document.getElementById('cardSelectionForm');
                
                // Handle select button clicks
                selectButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Get the card ID from the data attribute
                        const cardId = this.getAttribute('data-id');
                        
                        // Set the card ID in the hidden input
                        cardIdInput.value = cardId;
                        
                        // Remove selection visual from all cards
                        cardItems.forEach(item => {
                            item.classList.remove('selected');
                            item.style.outline = 'none';
                        });
                        
                        // Add selection visual to the clicked card
                        const selectedCard = document.querySelector(`.card-item[data-id="${cardId}"]`);
                        selectedCard.classList.add('selected');
                        selectedCard.style.outline = '3px solid #B62326';
                        selectedCard.style.outlineOffset = '2px';
                        
                        // Optional: Automatically submit the form
                        // cardSelectionForm.submit();
                        
                        // Scroll the Next button into view
                        document.querySelector('button[type="submit"]').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                });
                
                // View card modal functionality
                const viewButtons = document.querySelectorAll('.view-card-btn');
                
                viewButtons.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const cardId = this.getAttribute('data-id');
                        const card = document.querySelector(`.card-item[data-id="${cardId}"]`);
                        const cardImage = card.querySelector('img').src;
                        const cardTitle = card.querySelector('.name').textContent.trim();
                        
                        // Create or show modal with card details
                        showCardModal(cardImage, cardTitle);
                    });
                });
                
                // Function to show card preview modal
                function showCardModal(imageSrc, title) {
                    // Check if modal already exists
                    let modal = document.getElementById('cardPreviewModal');
                    
                    if (!modal) {
                        // Create modal if it doesn't exist
                        modal = document.createElement('div');
                        modal.id = 'cardPreviewModal';
                        modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
                        modal.innerHTML = `
                            <div class="bg-white rounded-lg max-w-md w-full p-4 relative">
                                <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times"></i>
                                </button>
                                
                                <h3 class="text-xl font-bold text-[#4B4B4B] text-center mb-4">معاينة البطاقة</h3>
                                
                                <div class="flex justify-center mb-4">
                                    <img id="previewCardImage" src="" class="max-h-80 rounded-lg shadow" alt="معاينة البطاقة">
                                </div>
                                
                                <div class="mt-4 text-center">
                                    <p id="previewCardTitle" class="font-medium text-lg"></p>
                                </div>
                                
                                <button id="closeModalBtn2" class="w-full h-12 bg-[#B62326] text-white font-bold rounded-full mt-4">
                                    إغلاق
                                </button>
                            </div>
                        `;
                        document.body.appendChild(modal);
                        
                        // Add close button event listeners
                        document.getElementById('closeModalBtn').addEventListener('click', () => {
                            modal.style.display = 'none';
                        });
                        
                        document.getElementById('closeModalBtn2').addEventListener('click', () => {
                            modal.style.display = 'none';
                        });
                        
                        // Close on outside click
                        modal.addEventListener('click', function(e) {
                            if (e.target === modal) {
                                modal.style.display = 'none';
                            }
                        });
                    }
                    
                    // Update modal content and show it
                    document.getElementById('previewCardImage').src = imageSrc;
                    document.getElementById('previewCardTitle').textContent = title;
                    modal.style.display = 'flex';
                }
                
                // Show selection on page load if card ID is already set
                if (cardIdInput.value) {
                    const savedCardId = cardIdInput.value;
                    const savedCard = document.querySelector(`.card-item[data-id="${savedCardId}"]`);
                    if (savedCard) {
                        savedCard.classList.add('selected');
                        savedCard.style.outline = '3px solid #B62326';
                        savedCard.style.outlineOffset = '2px';
                    }
                }
                
                // Form validation
                cardSelectionForm.addEventListener('submit', function(e) {
                    if (!cardIdInput.value) {
                        e.preventDefault();
                        alert('الرجاء اختيار بطاقة قبل المتابعة');
                    }
                });
            });
            </script>
    </body>
</div>

</html>