@extends('admin.index')
@section('title', __('Create New Message'))
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #1cc88a;
        --danger-color: #e74a3b;
        --warning-color: #f6c23e;
        --info-color: #36b9cc;
        --dark-color: #5a5c69;
        --light-color: #f8f9fc;
        --shadow-color: rgba(0, 0, 0, 0.15);
        --transition-speed: 0.3s;
        --border-radius: 0.5rem;
    }
    
    body {
        background-color: #f8f9fc;
    }
    
    .page-header {
        position: relative;
        padding: 2rem 0;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, var(--primary-color), #224abe);
        color: white;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .page-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
    }
    
    /* Form Card */
    .form-card {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
        border: none;
        transition: all var(--transition-speed);
    }
    
    .form-card:hover {
        box-shadow: 0 8px 35px rgba(0, 0, 0, 0.1);
    }
    
    .form-card .card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }
    
    .form-card .card-body {
        padding: 2rem;
    }
    
    /* Form Sections */
    .form-section {
        background-color: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.03);
        transition: all var(--transition-speed);
    }
    
    .form-section:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        border-color: rgba(0,0,0,0);
    }
    
    .form-section.active {
        border-left: 4px solid var(--primary-color);
    }
    
    .section-title {
        display: flex;
        align-items: center;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        position: relative;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--info-color));
        border-radius: 5px;
        transition: width 0.3s ease;
    }
    
    .section-title i {
        margin-right: 10px;
        color: var(--primary-color);
    }
    
    .form-section:hover .section-title::after {
        width: 100px;
    }
    
    /* Form Controls */
    .form-control, .form-select {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(0,0,0,0.1);
        box-shadow: none !important;
        transition: all var(--transition-speed);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--dark-color);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .form-text {
        color: #6c757d;
        font-size: 0.85rem;
    }
    
    /* Steps navigation */
    .steps-nav {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 1;
    }
    
    .steps-nav::before {
        content: '';
        position: absolute;
        top: 1.5rem;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #e9ecef;
        z-index: -1;
    }
    
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 33.333%;
        position: relative;
    }
    
    .step-item::before {
        content: '';
        position: absolute;
        top: 1.5rem;
        left: 0;
        width: 0%;
        height: 2px;
        background-color: var(--secondary-color);
        z-index: 0;
        transition: width 0.5s ease;
    }
    
    .step-item.active::before, .step-item.completed::before {
        width: 100%;
    }
    
    .step-item:first-child::before {
        width: 50%;
        left: 50%;
    }
    
    .step-item:last-child::before {
        width: 50%;
    }
    
    .step-count {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: white;
        border: 2px solid #e9ecef;
        color: #6c757d;
        font-weight: 600;
        font-size: 1.25rem;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
        margin-bottom: 0.5rem;
    }
    
    .step-item.active .step-count {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 0 0 5px rgba(78, 115, 223, 0.25);
    }
    
    .step-item.completed .step-count {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        color: white;
    }
    
    .step-item.completed .step-count::after {
        content: '✓';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
    }
    
    .step-text {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .step-item.active .step-text {
        color: var(--primary-color);
    }
    
    .step-item.completed .step-text {
        color: var(--secondary-color);
    }
    
    .step-desc {
        color: #6c757d;
        font-size: 0.8rem;
        text-align: center;
        max-width: 150px;
        margin-top: 0.25rem;
        display: none;
    }
    
    .step-item.active .step-desc {
        display: block;
        animation: fadeIn 0.5s;
    }
    
    /* Card preview styles */
    .cards-wrapper {
        position: relative;
        padding-top: 1rem;
    }
    
    .cards-container {
        max-height: 500px;
        overflow-y: auto;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        background-color: #f8f9fc;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color) #f8f9fc;
        position: relative;
        transition: all var(--transition-speed);
    }
    
    .cards-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .cards-container::-webkit-scrollbar-track {
        background: #f8f9fc;
    }
    
    .cards-container::-webkit-scrollbar-thumb {
        background-color: var(--primary-color);
        border-radius: 20px;
    }
    
    .card-preview {
        cursor: pointer;
        transition: all var(--transition-speed);
        border: 2px solid transparent;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        overflow: hidden;
        position: relative;
        background-color: white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transform: translateY(0);
    }
    
    .card-preview:hover {
        transform: translateY(-7px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 2;
    }
    
    .card-preview.selected {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 5px rgba(28, 200, 138, 0.25), 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .card-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 0;
        background: linear-gradient(to right, var(--secondary-color), var(--info-color));
        transition: height 0.3s ease;
        z-index: 1;
    }
    
    .card-preview.selected::before {
        height: 5px;
    }
    
    .card-img-container {
        position: relative;
        overflow: hidden;
        padding-top: 56.25%; /* 16:9 aspect ratio */
    }
    
    .card-preview img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-speed);
    }
    
    .card-preview:hover img {
        transform: scale(1.05);
    }
    
    .card-title {
        padding: 1rem;
        font-weight: 600;
        color: var(--dark-color);
        text-align: center;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        border-top: 1px solid rgba(0,0,0,0.03);
        background-color: white;
        position: relative;
        z-index: 2;
    }
    
    /* Video type styling */
    .video-thumbnail {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .play-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transition: all var(--transition-speed);
        transform: scale(0.9);
    }
    
    .play-icon i {
        color: var(--primary-color);
        font-size: 1.5rem;
        margin-left: 5px;
    }
    
    .card-preview:hover .play-icon {
        transform: scale(1);
        background-color: white;
    }
    
    /* Animated image type styling */
    .card-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        background: rgba(54, 185, 204, 0.9);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all var(--transition-speed);
    }
    
    .badge-animated {
        background: linear-gradient(45deg, #6e45e2, #88d3ce);
    }
    
    .card-preview:hover .card-badge {
        transform: translateY(-3px);
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    
    /* Selection overlay styling */
    .selection-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(28, 200, 138, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity var(--transition-speed);
        z-index: 5;
    }
    
    .card-preview.selected .selection-overlay {
        opacity: 1;
    }
    
    .selection-icon {
        color: white;
        font-size: 3rem;
        transform: scale(0);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .card-preview.selected .selection-icon {
        transform: scale(1);
    }
    
    /* Card type filter tabs */
    .card-type-tabs {
        display: flex;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .card-type-tab {
        flex: 1;
        text-align: center;
        padding: 1rem;
        cursor: pointer;
        transition: all var(--transition-speed);
        font-weight: 600;
        color: var(--dark-color);
        border-bottom: 3px solid transparent;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .card-type-tab i {
        margin-right: 0.5rem;
        font-size: 1.25rem;
    }
    
    .card-type-tab:hover {
        background-color: rgba(0,0,0,0.01);
    }
    
    .card-type-tab.active {
        border-bottom-color: var(--primary-color);
        color: var(--primary-color);
        background-color: rgba(78, 115, 223, 0.05);
    }
    
    /* Loading states */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255,255,255,0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 100;
        backdrop-filter: blur(3px);
    }
    
    .loading-spinner {
        border: 4px solid rgba(0,0,0,0.1);
        border-top: 4px solid var(--primary-color);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
    }
    
    .loading-text {
        color: var(--dark-color);
        font-weight: 600;
    }
    
    /* Form validation and feedback */
    .is-invalid {
        border-color: var(--danger-color) !important;
    }
    
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--danger-color);
    }
    
    /* Button styles */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all var(--transition-speed);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .btn-success {
        background: linear-gradient(45deg, var(--secondary-color), #20d5aa);
        border: none;
    }
    
    .btn-success:hover {
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
        color: var(--dark-color);
    }
    
    .btn-secondary:hover {
        background-color: #e3e6f0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transform: translateY(-2px);
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    /* Animations */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Responsive adjustments */
    @media (max-width: 991px) {
        .page-header {
            padding: 1.5rem 0;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .section-title {
            font-size: 1.1rem;
        }
        
        .form-section {
            padding: 1.5rem;
        }
        
        .step-count {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1rem;
        }
        
        .step-text {
            font-size: 0.8rem;
        }
        
        .step-desc {
            display: none !important;
        }
    }
    
    @media (max-width: 767px) {
        .page-header {
            padding: 1rem 0;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .form-card .card-body {
            padding: 1rem;
        }
        
        .step-item {
            width: auto;
            flex: 1;
        }
        
        .step-count {
            width: 2rem;
            height: 2rem;
            font-size: 0.9rem;
        }
        
        .step-text {
            display: none;
        }
        
        .card-type-tab {
            padding: 0.75rem 0.5rem;
        }
        
        .card-type-tab i {
            margin-right: 0.25rem;
        }
    }
</style>
@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="page-header text-center mb-4">
        <div class="container position-relative">
            <h1 class="page-title animate__animated animate__fadeInDown">{{ __('Create New Message') }}</h1>
            <p class="page-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ __('Design and send beautiful messages to your recipients') }}</p>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-card">
                <div class="card-body">
                    <!-- Step Navigation -->
                    <div class="steps-nav">
                        <div class="step-item active" id="step1Item">
                            <div class="step-count">1</div>
                            <div class="step-text">{{ __('Message Details') }}</div>
                            <div class="step-desc">{{ __('Select category and card type') }}</div>
                        </div>
                        <div class="step-item" id="step2Item">
                            <div class="step-count">2</div>
                            <div class="step-text">{{ __('Select Card') }}</div>
                            <div class="step-desc">{{ __('Choose a card and compose your message') }}</div>
                        </div>
                        <div class="step-item" id="step3Item">
                            <div class="step-count">3</div>
                            <div class="step-text">{{ __('Recipient Info') }}</div>
                            <div class="step-desc">{{ __('Add recipient details and sending options') }}</div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('messages.store') }}" id="messageForm">
                        @csrf
                        
                        <!-- Step 1: Message Details Section -->
                        <div class="form-section active" id="step1">
                            <h6 class="section-title"><i class="fas fa-info-circle"></i> {{ __('Message Details') }}</h6>
                            
                            <div class="row mb-4">
                                <!-- Language Selection -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="recipient_language" class="form-label">{{ __('Recipient Language') }}</label>
                                        <select class="form-select @error('recipient_language') is-invalid @enderror" id="recipient_language" name="recipient_language" required>
                                            <option value="">{{ __('Select Language') }}</option>
                                            @foreach($languages as $code => $name)
                                                <option value="{{ $code }}" {{ old('recipient_language') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('recipient_language')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                          <!-- Enhanced Card Number Field with Validation -->
<div class="col-md-6">
    <div class="form-group mb-3">
        <label for="card_number" class="form-label">{{ __('Card Number') }}</label>
        <div class="input-group">
            <input type="text" class="form-control @error('card_number') is-invalid @enderror" 
                   id="card_number" name="card_number" value="{{ old('card_number') }}" 
                   placeholder="{{ __('Enter 4-digit identity number') }}" 
                   maxlength="4" pattern="[0-9]{4}" required>
            <button class="btn btn-outline-primary" type="button" id="verifyCardBtn">
                <i class="fas fa-check"></i> {{ __('Verify card') }}
            </button>
        </div>
        <div id="cardNumberFeedback" class="mt-2" style="display: none;"></div>
        @error('card_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<!-- Card Number Verification Status -->



                            </div>
                            
                            <div class="row mb-3">
                                <!-- Main Category -->
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="main_category_id" class="form-label">{{ __('Main Category') }}</label>
                                        <select class="form-select @error('main_category_id') is-invalid @enderror" id="main_category_id" name="main_category_id" required>
                                            <option value="">{{ __('Select Main Category') }}</option>
                                            @foreach($mainCategories as $category)
                                                <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('main_category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Sub Category -->
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="sub_category_id" class="form-label">{{ __('Sub Category') }}</label>
                                        <select class="form-select @error('sub_category_id') is-invalid @enderror" id="sub_category_id" name="sub_category_id" required>
                                            <option value="">{{ __('Select Sub Category') }}</option>
                                        </select>
                                        @error('sub_category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Dedication Type / Card Type -->
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="dedication_type_id" class="form-label">{{ __('Card Type') }}</label>
                                        <select class="form-select @error('dedication_type_id') is-invalid @enderror" id="dedication_type_id" name="dedication_type_id" required>
                                            <option value="">{{ __('Select Card Type') }}</option>
                                            @foreach($dedicationTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('dedication_type_id') == $type->id ? 'selected' : '' }}>{{ __($type->type) }}</option>
                                            @endforeach
                                        </select>
                                        @error('dedication_type_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <div></div>
                                <button type="button" class="btn btn-success next-step" data-step="2">
                                    {{ __('Next: Select Card') }} <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 2: Card Selection Section -->
                        <div class="form-section" id="step2" style="display: none;">
                            <h6 class="section-title"><i class="fas fa-images"></i> {{ __('Card Selection') }}</h6>
                            
                            <!-- Card Type Tabs (Optional visual enhancement) -->
                            <div class="card-type-tabs">
                                <div class="card-type-tab" data-type="1">
                                    <i class="fas fa-image"></i> {{ __('Images') }}
                                </div>
                                <div class="card-type-tab" data-type="2">
                                    <i class="fas fa-video"></i> {{ __('Videos') }}
                                </div>
                                <div class="card-type-tab" data-type="3">
                                    <i class="fas fa-film"></i> {{ __('Animated') }}
                                </div>
                            </div>
                            
                            <!-- Card Selection -->
                            <div class="form-group mb-4">
                                <label for="card_id" class="form-label">{{ __('Select Card') }}</label>
                                <div class="cards-wrapper">
                                    <div class="cards-container" id="cardsContainer">
                                        <!-- Cards will be loaded dynamically via AJAX -->
                                        <div class="col-12 text-center py-5">
                                            <div class="mb-3">
                                                <i class="fas fa-hand-point-up fa-3x text-muted"></i>
                                            </div>
                                            <p class="lead text-muted">{{ __('Please select both a sub category and card type first') }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Loading overlay, initially hidden -->
                                    <div class="loading-overlay" id="cardsLoading" style="display: none;">
                                        <div class="loading-spinner"></div>
                                        <div class="loading-text">{{ __('Loading cards...') }}</div>
                                    </div>
                                </div>
                                <input type="hidden" name="card_id" id="card_id" value="{{ old('card_id') }}" required>
                                @error('card_id')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            
                            <!-- Message Content -->
                            <div class="form-group mb-3">
                                <label for="message_content" class="form-label">{{ __('Message Content') }}</label>
                                <textarea class="form-control @error('message_content') is-invalid @enderror" id="message_content" name="message_content" rows="5" placeholder="{{ __('Compose your message here...') }}" required>{{ old('message_content') }}</textarea>
                                <div class="form-text text-end mt-1">
                                    <span id="charCount">0</span> {{ __('characters') }}
                                </div>
                                @error('message_content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary prev-step" data-step="1">
                                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Previous') }}
                                </button>
                                <button type="button" class="btn btn-success next-step" data-step="3">
                                    {{ __('Next: Recipient Info') }} <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 3: Recipient Info Section -->
                        <div class="form-section" id="step3" style="display: none;">
                            <h6 class="section-title"><i class="fas fa-user"></i> {{ __('Recipient Information') }}</h6>
                            
                            <div class="row mb-4">
                                <!-- Recipient Info -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="recipient_name" class="form-label">{{ __('Recipient Name') }}</label>
                                        <input type="text" class="form-control @error('recipient_name') is-invalid @enderror" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" placeholder="{{ __('Enter recipient name') }}" required>
                                        @error('recipient_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Lock Type -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="lock_type" class="form-label">{{ __('Lock Card') }}</label>
                                        <select class="form-select @error('lock_type') is-invalid @enderror" id="lock_type" name="lock_type" required>
                                            @foreach($lockTypes as $value => $label)
                                                <option value="{{ $value }}" {{ old('lock_type') == $value ? 'selected' : '' }}>{{ __($label) }}</option>
                                            @endforeach
                                        </select>
                                        @error('lock_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Recipient Phone (conditionally displayed) -->
                            <div class="form-group mb-4" id="recipientPhoneGroup" style="display: none;">
                                <label for="recipient_phone" class="form-label">{{ __('Recipient Phone') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control @error('recipient_phone') is-invalid @enderror" id="recipient_phone" name="recipient_phone" value="{{ old('recipient_phone') }}" placeholder="{{ __('Enter recipient phone number') }}">
                                </div>
                                <small class="form-text">{{ __('Required for locked cards. You will receive unlock code after saving.') }}</small>
                                @error('recipient_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <!-- Schedule -->
                            <div class="form-group mb-4" id="scheduleGroup" style="display: none;">
                                <label for="scheduled_at" class="form-label">{{ __('Schedule Sending Time') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control @error('scheduled_at') is-invalid @enderror" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}" placeholder="{{ __('Select date and time or leave empty to send immediately') }}">
                                </div>
                                @error('scheduled_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <!-- Manual Send Option -->
                            <div class="form-check mb-4" id="manuallySentGroup" style="display: none;">
                                <input class="form-check-input @error('manually_sent') is-invalid @enderror" type="checkbox" id="manually_sent" name="manually_sent" value="1" {{ old('manually_sent') ? 'checked' : '' }}>
                                <label class="form-check-label" for="manually_sent">
                                    {{ __('Send manually (you will need to press the send button when ready)') }}
                                </label>
                                @error('manually_sent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <!-- Preview Card (Optional) -->
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center">
                                    <i class="fas fa-eye mr-2"></i> {{ __('Message Preview') }}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div id="previewImage" class="text-center p-3 bg-light rounded">
                                                <img src="" alt="{{ __('Card Preview') }}" style="max-width: 100%; max-height: 200px; display: none;">
                                                <div class="text-muted pt-4 pb-4">
                                                    <i class="fas fa-image fa-3x mb-2"></i>
                                                    <p>{{ __('Card preview will appear here') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <strong>{{ __('Recipient:') }}</strong> <span id="previewRecipient">-</span>
                                            </div>
                                            <div class="mb-3">
                                                <strong>{{ __('Message:') }}</strong>
                                                <p id="previewMessage" class="text-muted">-</p>
                                            </div>
                                            <div>
                                                <strong>{{ __('Sending:') }}</strong> <span id="previewSending">{{ __('Immediately') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary prev-step" data-step="2">
                                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Previous') }}
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane mr-2"></i> {{ __('Send Message') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

// Card number validation
$(document).ready(function() {
    // Format input as 4 digits
    $('#card_number').on('input', function() {
        // Remove non-numeric characters
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        
        // Limit to 4 digits
        if ($(this).val().length > 4) {
            $(this).val($(this).val().substring(0, 4));
        }
    });
    
    // Verify button click handler
    $('#verifyCardBtn').on('click', function() {
        verifyCardNumber();
    });
    
    // Also verify when user presses enter in the input field
    $('#card_number').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            verifyCardNumber();
        }
    });
    
    // Card verification function
    function verifyCardNumber() {
        const cardNumber = $('#card_number').val();
        
        // Validate format first
        if (cardNumber.length !== 4 || !/^\d{4}$/.test(cardNumber)) {
            showCardStatus('error', 'Invalid card number format. Please enter 4 digits.');
            return;
        }
        
        // Show loading state
        $('#cardStatusLoading').show();
        $('#cardStatusContent').hide();
        
        // CSRF token
        const token = $('meta[name="csrf-token"]').attr('content');
        
        // Send AJAX request to verify card
        $.ajax({
            url: '/verify-card-number',
            type: 'POST',
            data: {
                card_number: cardNumber,
                _token: token
            },
            dataType: 'json',
            success: function(response) {
                $('#cardStatusLoading').hide();
                $('#cardStatusContent').show();
                
                if (response.valid) {
                    // Card is valid
                    showCardStatus('success', response.message, response.cardInfo);
                } else {
                    // Card is invalid
                    showCardStatus('error', response.message);
                }
            },
            error: function(xhr, status, error) {
                $('#cardStatusLoading').hide();
                $('#cardStatusContent').show();
                
                console.error('Error verifying card:', error);
                showCardStatus('error', 'Error verifying card. Please try again.');
            }
        });
    }
    
    // Function to display card status
    function showCardStatus(type, message, cardInfo = null) {
        $('#cardNumberFeedback').show();
        $('#cardStatusContent').empty();
        
        if (type === 'success') {
            // Valid card
            $('#card_number').removeClass('is-invalid').addClass('is-valid');
            $('#cardNumberFeedback').removeClass('text-danger').addClass('text-success')
                .html('<i class="fas fa-check-circle"></i> ' + message);
            
            // Show card details
            let cardDetailsHtml = `
                <div class="d-flex align-items-center text-success mb-2">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>${message}</strong>
                </div>
            `;
            
            if (cardInfo) {
                cardDetailsHtml += `
                    <div class="card-info">
                        <div class="mb-1"><strong>Card Pack:</strong> #${cardInfo.ready_card_id}</div>
                        <div class="mb-1"><strong>Sequence:</strong> ${cardInfo.sequence_number}</div>
                        <div><strong>Status:</strong> <span class="badge ${cardInfo.status === 'open' ? 'bg-success' : 'bg-danger'}">
                            ${cardInfo.status === 'open' ? 'Available' : 'Used'}
                        </span></div>
                    </div>
                `;
            }
            
            $('#cardStatusContent').html(cardDetailsHtml);
        } else {
            // Invalid card
            $('#card_number').removeClass('is-valid').addClass('is-invalid');
            $('#cardNumberFeedback').removeClass('text-success').addClass('text-danger')
                .html('<i class="fas fa-exclamation-circle"></i> ' + message);
            
            $('#cardStatusContent').html(`
                <div class="d-flex align-items-center text-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span>${message}</span>
                </div>
            `);
        }
    }
});

</script>
<script>
$(document).ready(function() {
    console.log('Document ready, initializing form...');
    
    // Initialize flatpickr for datetime picker
    flatpickr("#scheduled_at", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        time_24hr: true
    });
    
    // Step navigation
    $('.next-step').on('click', function() {
        var nextStep = $(this).data('step');
        var currentStep = nextStep - 1;
        var isValid = validateStep(currentStep);
        
        if (isValid) {
            // Hide current step, show next step
            $('#step' + currentStep).hide();
            $('#step' + nextStep).show();
            
            // Update step indicators
            $('#step' + currentStep + 'Item').removeClass('active').addClass('completed');
            $('#step' + nextStep + 'Item').addClass('active');
            
            // Scroll to top of form
            $('html, body').animate({
                scrollTop: $('.steps-nav').offset().top - 50
            }, 500);
        }
    });
    
    $('.prev-step').on('click', function() {
        var prevStep = $(this).data('step');
        var currentStep = parseInt(prevStep) + 1;
        
        // Hide current step, show previous step
        $('#step' + currentStep).hide();
        $('#step' + prevStep).show();
        
        // Update step indicators
        $('#step' + currentStep + 'Item').removeClass('active');
        $('#step' + prevStep + 'Item').addClass('active').removeClass('completed');
        
        // Scroll to top of form
        $('html, body').animate({
            scrollTop: $('.steps-nav').offset().top - 50
        }, 500);
    });
    
    // Step validation
    function validateStep(step) {
        var isValid = true;
        
        if (step === 1) {
            // Check if all fields in step 1 are filled
            if ($('#recipient_language').val() === '') {
                $('#recipient_language').addClass('is-invalid');
                isValid = false;
            } else {
                $('#recipient_language').removeClass('is-invalid');
            }
            
            if ($('#main_category_id').val() === '') {
                $('#main_category_id').addClass('is-invalid');
                isValid = false;
            } else {
                $('#main_category_id').removeClass('is-invalid');
            }
            
            if ($('#sub_category_id').val() === '') {
                $('#sub_category_id').addClass('is-invalid');
                isValid = false;
            } else {
                $('#sub_category_id').removeClass('is-invalid');
            }
            
            if ($('#dedication_type_id').val() === '') {
                $('#dedication_type_id').addClass('is-invalid');
                isValid = false;
            } else {
                $('#dedication_type_id').removeClass('is-invalid');
            }
            
            if ($('#card_number').val() === '') {
                $('#card_number').addClass('is-invalid');
                isValid = false;
            } else {
                $('#card_number').removeClass('is-invalid');
            }
        } else if (step === 2) {
            // Check if card is selected and message is entered
            if ($('#card_id').val() === '') {
                $('#cardsContainer').addClass('border border-danger');
                isValid = false;
                alert('Please select a card before proceeding.');
            } else {
                $('#cardsContainer').removeClass('border border-danger');
            }
            
            if ($('#message_content').val() === '') {
                $('#message_content').addClass('is-invalid');
                isValid = false;
            } else {
                $('#message_content').removeClass('is-invalid');
            }
        }
        
        return isValid;
    }
    
    // Find the elements we need to show/hide
    var recipientPhoneGroup = $('#recipientPhoneGroup');
    var scheduleGroup = $('#scheduleGroup');
    var manuallySentGroup = $('#manuallySentGroup');
    
    // Initial state handling for lock_type
    $('#lock_type').on('change', function() {
        var selectedValue = $(this).val();
        console.log('Lock type changed to:', selectedValue);
        
        if (selectedValue === 'no_lock') {
            recipientPhoneGroup.hide();
            scheduleGroup.hide();
            manuallySentGroup.hide();
            $('#recipient_phone').removeAttr('required');
            $('#previewSending').text('{{ __("Immediately") }}');
        } else {
            recipientPhoneGroup.show();
            scheduleGroup.show();
            manuallySentGroup.show();
            $('#recipient_phone').attr('required', 'required');
        }
    });
    
    // Check initial value on page load for lock_type
    var initialLockValue = $('#lock_type').val();
    if (initialLockValue !== 'no_lock') {
        recipientPhoneGroup.show();
        scheduleGroup.show();
        manuallySentGroup.show();
        $('#recipient_phone').attr('required', 'required');
    }
    
    // Card type tabs functionality
    $('.card-type-tab').on('click', function() {
        var typeId = $(this).data('type');
        
        // Update active tab
        $('.card-type-tab').removeClass('active');
        $(this).addClass('active');
        
        // Change the dedication type dropdown value
        $('#dedication_type_id').val(typeId).trigger('change');
    });
    
    // Update card type tab based on dedication type dropdown
    $('#dedication_type_id').on('change', function() {
        var typeId = $(this).val();
        if (typeId) {
            $('.card-type-tab').removeClass('active');
            $('.card-type-tab[data-type="' + typeId + '"]').addClass('active');
        }
    });
    
    // Character counter for message content
    $('#message_content').on('input', function() {
        var charCount = $(this).val().length;
        $('#charCount').text(charCount);
        
        // Update preview
        $('#previewMessage').text($(this).val() || '-');
    });
    
    // Update recipient name in preview
    $('#recipient_name').on('input', function() {
        $('#previewRecipient').text($(this).val() || '-');
    });
    
    // Update scheduled time in preview
    $('#scheduled_at').on('change', function() {
        if ($(this).val()) {
            $('#previewSending').text('{{ __("Scheduled for") }}: ' + $(this).val());
        } else {
            $('#previewSending').text('{{ __("Immediately") }}');
        }
    });
    
    // Main Category Change Event
    $('#main_category_id').on('change', function() {
        console.log('Main category changed to:', $(this).val());
        var mainCategoryId = $(this).val();
        var subCategorySelect = $('#sub_category_id');
        
        // Reset subcategory dropdown
        subCategorySelect.html('<option value="">{{ __("Select Sub Category") }}</option>');
        
        // Reset card container
        $('#cardsContainer').html('<div class="col-12 text-center py-5"><div class="mb-3"><i class="fas fa-hand-point-up fa-3x text-muted"></i></div><p class="lead text-muted">{{ __("Please select both a sub category and card type first") }}</p></div>');
        $('#card_id').val('');
        
        // Reset card preview
        $('#previewImage img').hide();
        $('#previewImage div').show();
        
        if (!mainCategoryId) {
            return;
        }
        
        // Show loading indicator
        subCategorySelect.html('<option value="">{{ __("Loading...") }}</option>');
        
        // Get CSRF token
        var token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: '/subcategories-for-main',
            type: 'GET',
            data: {
                main_category_id: mainCategoryId,
                _token: token
            },
            dataType: 'json',
            success: function(data) {
                console.log('Subcategories received:', data);
                
                // Reset dropdown first
                subCategorySelect.html('<option value="">{{ __("Select Sub Category") }}</option>');
                
                if (!data || data.length === 0) {
                    subCategorySelect.append('<option disabled>{{ __("No subcategories found") }}</option>');
                    return;
                }
                
                // Add subcategories to dropdown
                $.each(data, function(index, category) {
                    // Support both locale formats
                    var locale = $('html').attr('lang') || 'en';
                    var name = category.name_ar;
                    
                    subCategorySelect.append('<option value="' + category.id + '">' + name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                
                // Try direct AJAX call as a second attempt
                directAjaxCall(mainCategoryId, subCategorySelect);
            }
        });
    });
    
    // Fallback function for direct AJAX call
    function directAjaxCall(mainCategoryId, subCategorySelect) {
        // Try a different approach with a direct controller call
        $.getJSON('/custom-subcategories?main_id=' + mainCategoryId, function(data) {
            console.log('Fallback: Subcategories received:', data);
            
            // Reset dropdown first
            subCategorySelect.html('<option value="">{{ __("Select Sub Category") }}</option>');
            
            if (!data || data.length === 0) {
                subCategorySelect.append('<option disabled>{{ __("No subcategories found") }}</option>');
                return;
            }
            
            // Add subcategories to dropdown
            $.each(data, function(index, category) {
                var locale = $('html').attr('lang') || 'en';
                var name = locale === 'ar' ? category.name_ar : category.name_en;
                
                subCategorySelect.append('<option value="' + category.id + '">' + name + '</option>');
            });
        }).fail(function(jqxhr, textStatus, error) {
            console.error('Fallback call failed:', error);
            subCategorySelect.html('<option value="">{{ __("Error loading subcategories") }}</option>');
            alert('{{ __("Error loading subcategories. Please try again later or contact support.") }}');
        });
    }
    
    // Function to load cards - modified to include dedication_type_id
    function loadCards() {
        var subCategoryId = $('#sub_category_id').val();
        var dedicationTypeId = $('#dedication_type_id').val();
        var cardsContainer = $('#cardsContainer');
        
        // Reset card selection
        $('#card_id').val('');
        
        // Reset card preview
        $('#previewImage img').hide();
        $('#previewImage div').show();
        
        // Check if we have both required values
        if (!subCategoryId || !dedicationTypeId) {
            cardsContainer.html('<div class="col-12 text-center py-5"><div class="mb-3"><i class="fas fa-hand-point-up fa-3x text-muted"></i></div><p class="lead text-muted">{{ __("Please select both a sub category and card type first") }}</p></div>');
            return;
        }
        
        // Show loading indicator
        $('#cardsLoading').show();
        
        // Get CSRF token
        var token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: '/cards-for-subcategory',
            type: 'GET',
            data: {
                sub_category_id: subCategoryId,
                dedication_type_id: dedicationTypeId,
                _token: token
            },
            dataType: 'json',
            success: function(data) {
                console.log('Cards received:', data);
                
                // Create row for cards grid
                var cardsRow = $('<div class="row"></div>');
                cardsContainer.html('').append(cardsRow);
                
                if (!data || data.length === 0) {
                    cardsContainer.html(`
                        <div class="col-12 text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-search fa-3x text-muted"></i>
                            </div>
                            <p class="lead text-muted">{{ __("No cards found for this category and card type.") }}</p>
                        </div>
                    `);
                    $('#cardsLoading').hide();
                    return;
                }
                
                // Add cards to container
                $.each(data, function(index, card) {
                    var title = card.title;
                    var cardPreviewHtml;
                    
                    // Different preview based on card type
                    if (dedicationTypeId == 1) { // Image
                        cardPreviewHtml = `
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card-preview animate__animated animate__fadeIn" data-card-id="${card.id}" data-img-src="${card.file_path}">
                                    <div class="card-img-container">
                                        <img src="${card.file_path}" alt="${title}" class="card-img">
                                        <div class="selection-overlay">
                                            <i class="fas fa-check-circle selection-icon"></i>
                                        </div>
                                    </div>
                                    <div class="card-title">${title}</div>
                                </div>
                            </div>
                        `;
                    } else if (dedicationTypeId == 2) { // Video
                        cardPreviewHtml = `
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card-preview animate__animated animate__fadeIn" data-card-id="${card.id}" data-img-src="${card.file_path}">
                                    <div class="card-img-container">
                                        <img src="${card.file_path}" alt="${title}" class="card-img">
                                        <div class="video-thumbnail">
                                            <div class="play-icon">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                        <div class="selection-overlay">
                                            <i class="fas fa-check-circle selection-icon"></i>
                                        </div>
                                    </div>
                                    <div class="card-title">${title}</div>
                                </div>
                            </div>
                        `;
                    } else if (dedicationTypeId == 3) { // Animated image
                        cardPreviewHtml = `
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card-preview animate__animated animate__fadeIn" data-card-id="${card.id}" data-img-src="${card.file_path}">
                                    <div class="card-img-container">
                                        <img src="${card.file_path}" alt="${title}" class="card-img">
                                        <div class="card-badge badge-animated">
                                            <i class="fas fa-magic mr-1"></i> {{ __("Animated") }}
                                        </div>
                                        <div class="selection-overlay">
                                            <i class="fas fa-check-circle selection-icon"></i>
                                        </div>
                                    </div>
                                    <div class="card-title">${title}</div>
                                </div>
                            </div>
                        `;
                    }
                    
                    cardsRow.append(cardPreviewHtml);
                });
                
                // Hide loading indicator
                $('#cardsLoading').hide();
                
                // Add click event to card previews
                $('.card-preview').on('click', function() {
                    // Remove selected class from all cards
                    $('.card-preview').removeClass('selected');
                    
                    // Add selected class to clicked card
                    $(this).addClass('selected');
                    
                    // Set the card ID in the hidden input
                    $('#card_id').val($(this).data('card-id'));
                    
                    // Update preview image
                    var imgSrc = $(this).data('img-src');
                    $('#previewImage img').attr('src', imgSrc).show();
                    $('#previewImage div').hide();
                    
                    // Scroll to message input
                    setTimeout(function() {
                        $('#message_content').focus();
                    }, 300);
                });
                
                // Apply staggered animation delay to cards
                $('.card-preview').each(function(index) {
                    $(this).css('animation-delay', (index * 0.05) + 's');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading cards:', error);
                cardsContainer.html(`
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                        </div>
                        <p class="lead text-muted">{{ __("Error loading cards. Please try again.") }}</p>
                    </div>
                `);
                $('#cardsLoading').hide();
            }
        });
    }
    
    // Sub Category Change Event - trigger card loading
    $('#sub_category_id').on('change', function() {
        loadCards();
    });
    
    // Dedication Type Change Event - trigger card loading
    $('#dedication_type_id').on('change', function() {
        loadCards();
    });
    
    // Form submission validation
    $('#messageForm').on('submit', function(event) {
        // Check if a card is selected
        var cardId = $('#card_id').val();
        if (!cardId) {
            event.preventDefault();
            alert('{{ __("Please select a card.") }}');
            
            // Show the card selection step
            $('.step-item').removeClass('active').removeClass('completed');
            $('#step2Item').addClass('active');
            $('#step1Item').addClass('completed');
            
            // Hide all sections, show card selection section
            $('.form-section').hide();
            $('#step2').show();
            
            // Scroll to card container
            $('html, body').animate({
                scrollTop: $('#cardsContainer').offset().top - 100
            }, 500);
            
            return false;
        }
        
        // Check if recipient phone is provided for locked cards
        var lockType = $('#lock_type').val();
        var recipientPhone = $('#recipient_phone').val();
        
        if (lockType !== 'no_lock' && !recipientPhone) {
            event.preventDefault();
            alert('{{ __("Recipient phone is required for locked cards.") }}');
            
            // Show the recipient info step
            $('.step-item').removeClass('active').removeClass('completed');
            $('#step3Item').addClass('active');
            $('#step1Item, #step2Item').addClass('completed');
            
            // Hide all sections, show recipient info section
            $('.form-section').hide();
            $('#step3').show();
            
            // Highlight the phone field
            $('#recipient_phone').focus();
            return false;
        }
        
        // All validations passed, show loading state
        if ($(this).valid()) {
            // Disable submit button to prevent double submissions
            $(this).find('button[type="submit"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin mr-2"></i> {{ __("Sending...") }}');
        }
    });
    
    // Function to preview selected image
    function updateCardPreview(imgSrc) {
        if (imgSrc) {
            $('#previewImage img').attr('src', imgSrc).show();
            $('#previewImage div').hide();
        } else {
            $('#previewImage img').hide();
            $('#previewImage div').show();
        }
    }
    
    // Handle back button and refresh gracefully
    window.onbeforeunload = function() {
        // Optionally ask user to confirm leaving the page
        // return "Are you sure you want to leave this page? Your message data will be lost.";
    };
    
    // Initialize tooltips for better UX
    $('[data-toggle="tooltip"]').tooltip();
    
    // Ensure form fields use browser autocomplete
    $('#messageForm input').attr('autocomplete', 'on');
    
    // Enable card filtering by title (optional enhancement)
    $('#searchCards').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('.card-preview').each(function() {
            var title = $(this).find('.card-title').text().toLowerCase();
            
            if (title.indexOf(searchTerm) > -1) {
                $(this).parent().show();
            } else {
                $(this).parent().hide();
            }
        });
    });
    
    // Add keyboard navigation for card selection
    $(document).on('keydown', function(e) {
        if ($('#step2').is(':visible')) {
            // Arrow keys
            if (e.keyCode >= 37 && e.keyCode <= 40) {
                e.preventDefault();
                
                var $cards = $('.card-preview:visible');
                var currentIndex = $cards.index($('.card-preview.selected'));
                var newIndex;
                
                // Left arrow
                if (e.keyCode === 37) {
                    newIndex = currentIndex > 0 ? currentIndex - 1 : $cards.length - 1;
                }
                // Right arrow
                else if (e.keyCode === 39) {
                    newIndex = currentIndex < $cards.length - 1 ? currentIndex + 1 : 0;
                }
                // Up arrow
                else if (e.keyCode === 38) {
                    newIndex = currentIndex - 3 >= 0 ? currentIndex - 3 : currentIndex;
                }
                // Down arrow
                else if (e.keyCode === 40) {
                    newIndex = currentIndex + 3 < $cards.length ? currentIndex + 3 : currentIndex;
                }
                
                $cards.removeClass('selected');
                $($cards[newIndex]).addClass('selected');
                $('#card_id').val($($cards[newIndex]).data('card-id'));
                
                // Update preview
                updateCardPreview($($cards[newIndex]).data('img-src'));
                
                // Scroll to the selected card if needed
                var $selectedCard = $($cards[newIndex]);
                var containerTop = $('#cardsContainer').offset().top;
                var cardTop = $selectedCard.offset().top;
                var containerScrollTop = $('#cardsContainer').scrollTop();
                var containerHeight = $('#cardsContainer').height();
                
                if (cardTop < containerTop || cardTop > containerTop + containerHeight) {
                    $('#cardsContainer').animate({
                        scrollTop: containerScrollTop + (cardTop - containerTop)
                    }, 200);
                }
            }
            // Enter key selects current card and moves to message input
            else if (e.keyCode === 13 && $('.card-preview.selected').length) {
                e.preventDefault();
                $('#message_content').focus();
            }
        }
    });
    
    // Real-time validation on form fields
    $('input, select, textarea').on('input change blur', function() {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
        }
    });
    
    // Provide advanced animation effects for better UX
    $('.form-section').on('show', function() {
        $(this).addClass('animate__animated animate__fadeIn');
    });
    
    // Handle touch events for mobile devices
    let touchStartX = 0;
    let touchEndX = 0;
    
    $('#messageForm').on('touchstart', function(e) {
        touchStartX = e.originalEvent.touches[0].clientX;
    });
    
    $('#messageForm').on('touchend', function(e) {
        touchEndX = e.originalEvent.changedTouches[0].clientX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 100;
        const currentStep = $('.form-section:visible').attr('id').replace('step', '');
        
        // Swipe left
        if (touchEndX < touchStartX - swipeThreshold) {
            if (currentStep < 3) {
                $('.next-step[data-step="' + (parseInt(currentStep) + 1) + '"]').trigger('click');
            }
        }
        // Swipe right
        if (touchEndX > touchStartX + swipeThreshold) {
            if (currentStep > 1) {
                $('.prev-step[data-step="' + (parseInt(currentStep) - 1) + '"]').trigger('click');
            }
        }
    }
    
    console.log('Enhanced message form script fully loaded and initialized');
});
</script>
@endsection