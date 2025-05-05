@extends('admin.index')

@section('title', __('Create New Message'))

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .form-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .section-title {
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        color: #333;
        font-weight: bold;
    }
    
    .card-preview {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
    }
    
    .card-preview:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .card-preview.selected {
        border-color: #4caf50;
    }
    
    .card-preview img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .card-title {
        padding: 10px;
        text-align: center;
        background-color: #f8f9fa;
        border-top: 1px solid #eee;
    }
    
    .cards-container {
        max-height: 400px;
        overflow-y: auto;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }
    
    /* Steps navigation */
    .steps-nav {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    
    .step-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }
    
    .step-item:not(:first-child):before {
        content: "";
        position: absolute;
        width: 100%;
        height: 3px;
        background-color: #e0e0e0;
        top: 15px;
        left: -50%;
        z-index: 0;
    }
    
    .step-item.completed:before {
        background-color: #4caf50;
    }
    
    .step-count {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: #e0e0e0;
        color: #333;
        font-weight: bold;
        position: relative;
        z-index: 1;
    }
    
    .step-item.active .step-count,
    .step-item.completed .step-count {
        background-color: #4caf50;
        color: white;
    }
    
    .step-text {
        margin-top: 5px;
        font-size: 12px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Send New Message') }}</h5>
                </div>
                <div class="card-body">
                    <!-- Steps Navigation -->
                    <div class="steps-nav">
                        <div class="step-item active" id="step1">
                            <div class="step-count">1</div>
                            <div class="step-text">{{ __('Recipient Language') }}</div>
                        </div>
                        <div class="step-item" id="step2">
                            <div class="step-count">2</div>
                            <div class="step-text">{{ __('Main Category') }}</div>
                        </div>
                        <div class="step-item" id="step3">
                            <div class="step-count">3</div>
                            <div class="step-text">{{ __('Sub Category') }}</div>
                        </div>
                        <div class="step-item" id="step4">
                            <div class="step-count">4</div>
                            <div class="step-text">{{ __('Dedication Type') }}</div>
                        </div>
                        <div class="step-item" id="step5">
                            <div class="step-count">5</div>
                            <div class="step-text">{{ __('Card Number') }}</div>
                        </div>
                        <div class="step-item" id="step6">
                            <div class="step-count">6</div>
                            <div class="step-text">{{ __('Select Card') }}</div>
                        </div>
                        <div class="step-item" id="step7">
                            <div class="step-count">7</div>
                            <div class="step-text">{{ __('Message') }}</div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('messages.store') }}" id="messageForm">
                        @csrf
                        
                        <!-- Form Sections -->
                        <div class="form-section" id="section1">
                            <h6 class="section-title">{{ __('1. Select Recipient Language') }}</h6>
                            <div class="form-group mb-3">
                                <label for="recipient_language">{{ __('Language') }}</label>
                                <select class="form-control @error('recipient_language') is-invalid @enderror" id="recipient_language" name="recipient_language" required>
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
                            <button type="button" class="btn btn-primary next-section">{{ __('Next') }}</button>
                        </div>
                        
                        <div class="form-section d-none" id="section2">
                            <h6 class="section-title">{{ __('2. Select Main Category') }}</h6>
                            <div class="form-group mb-3">
                                <label for="main_category_id">{{ __('Main Category') }}</label>
                                <select class="form-control @error('main_category_id') is-invalid @enderror" id="main_category_id" name="main_category_id" required>
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
                            <button type="button" class="btn btn-secondary prev-section">{{ __('Previous') }}</button>
                            <button type="button" class="btn btn-primary next-section">{{ __('Next') }}</button>
                        </div>
                        
                        <div class="form-section d-none" id="section3">
                            <h6 class="section-title">{{ __('3. Select Sub Category') }}</h6>
                            <div class="form-group mb-3">
                                <label for="sub_category_id">{{ __('Sub Category') }}</label>
                                <select class="form-control @error('sub_category_id') is-invalid @enderror" id="sub_category_id" name="sub_category_id" required>
                                    <option value="">{{ __('Select Sub Category') }}</option>
                                </select>
                                @error('sub_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-secondary prev-section">{{ __('Previous') }}</button>
                            <button type="button" class="btn btn-primary next-section">{{ __('Next') }}</button>
                        </div>
                        
                        <div class="form-section d-none" id="section4">
                            <h6 class="section-title">{{ __('4. Select Dedication Type') }}</h6>
                            <div class="form-group mb-3">
                                <label for="dedication_type_id">{{ __('Dedication Type') }}</label>
                                <select class="form-control @error('dedication_type_id') is-invalid @enderror" id="dedication_type_id" name="dedication_type_id" required>
                                    <option value="">{{ __('Select Dedication Type') }}</option>
                                    @foreach($dedicationTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('dedication_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('dedication_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-secondary prev-section">{{ __('Previous') }}</button>
                            <button type="button" class="btn btn-primary next-section">{{ __('Next') }}</button>
                        </div>
                        
                        <div class="form-section d-none" id="section5">
                            <h6 class="section-title">{{ __('5. Enter Card Number') }}</h6>
                            <div class="form-group mb-3">
                                <label for="card_number">{{ __('Card Number') }}</label>
                                <input type="text" class="form-control @error('card_number') is-invalid @enderror" id="card_number" name="card_number" value="{{ old('card_number') }}" required>
                                @error('card_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-secondary prev-section">{{ __('Previous') }}</button>
                            <button type="button" class="btn btn-primary next-section">{{ __('Next') }}</button>
                        </div>
                        
                        <div class="form-section d-none" id="section6">
                            <h6 class="section-title">{{ __('6. Select Card') }}</h6>
                            <div class="form-group mb-3">
                                <div class="cards-container">
                                    <div class="row" id="cardsContainer">
                                        <!-- Cards will be loaded dynamically via AJAX -->
                                        <div class="col-12 text-center py-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">{{ __('Loading...') }}</span>
                                            </div>
                                            <p class="mt-2">{{ __('Loading cards...') }}</p>
                                        </div>
                                    </div>
                                </div><input type="hidden" name="card_id" id="card_id" value="{{ old('card_id') }}" required>
                                @error('card_id')
                                    <div class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-secondary prev-section">{{ __('Previous') }}</button>
                            <button type="button" class="btn btn-primary next-section">{{ __('Next') }}</button>
                        </div>
                        
                        <div class="form-section d-none" id="section7">
                            <h6 class="section-title">{{ __('7. Message Details') }}</h6>
                            
                            <div class="form-group mb-3">
                                <label for="message_content">{{ __('Message Content') }}</label>
                                <textarea class="form-control @error('message_content') is-invalid @enderror" id="message_content" name="message_content" rows="4" required>{{ old('message_content') }}</textarea>
                                @error('message_content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <!-- For sales outlet, show sender fields -->
                            @if($isSalesOutlet)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="sender_name">{{ __('Sender Name') }}</label>
                                        <input type="text" class="form-control @error('sender_name') is-invalid @enderror" id="sender_name" name="sender_name" value="{{ old('sender_name') }}" required>
                                        @error('sender_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="sender_phone">{{ __('Sender Phone') }}</label>
                                        <input type="text" class="form-control @error('sender_phone') is-invalid @enderror" id="sender_phone" name="sender_phone" value="{{ old('sender_phone') }}" required>
                                        @error('sender_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="form-group mb-3">
                                <label for="recipient_name">{{ __('Recipient Name') }}</label>
                                <input type="text" class="form-control @error('recipient_name') is-invalid @enderror" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" required>
                                @error('recipient_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="lock_type">{{ __('Lock Card') }}</label>
                                <select class="form-control @error('lock_type') is-invalid @enderror" id="lock_type" name="lock_type" required>
                                    @foreach($lockTypes as $value => $label)
                                        <option value="{{ $value }}" {{ old('lock_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('lock_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3" id="recipientPhoneGroup" style="display: none;">
                                <label for="recipient_phone">{{ __('Recipient Phone') }}</label>
                                <input type="text" class="form-control @error('recipient_phone') is-invalid @enderror" id="recipient_phone" name="recipient_phone" value="{{ old('recipient_phone') }}">
                                <small class="form-text text-muted">{{ __('Required for locked cards. You will receive unlock code after saving.') }}</small>
                                @error('recipient_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="scheduled_at">{{ __('Schedule Sending Time') }}</label>
                                <input type="text" class="form-control @error('scheduled_at') is-invalid @enderror" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}" placeholder="{{ __('Select date and time or leave empty to send immediately') }}">
                                @error('scheduled_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-check mb-3">
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
                            
                            <button type="button" class="btn btn-secondary prev-section">{{ __('Previous') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('Send Message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for datetime picker
        flatpickr("#scheduled_at", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            time_24hr: true
        });
        
        // Handle navigation between form sections
        const sections = document.querySelectorAll('.form-section');
        const nextButtons = document.querySelectorAll('.next-section');
        const prevButtons = document.querySelectorAll('.prev-section');
        const stepItems = document.querySelectorAll('.step-item');
        
        let currentSection = 0;
        
        // Show first section by default
        sections[currentSection].classList.remove('d-none');
        
        // Next button click handler
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Validate current section
                if (!validateSection(currentSection)) {
                    return false;
                }
                
                // Hide current section
                sections[currentSection].classList.add('d-none');
                
                // Mark current step as completed
                stepItems[currentSection].classList.add('completed');
                
                // Show next section
                currentSection++;
                sections[currentSection].classList.remove('d-none');
                
                // Update steps
                updateSteps();
            });
        });
        
        // Previous button click handler
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Hide current section
                sections[currentSection].classList.add('d-none');
                
                // Show previous section
                currentSection--;
                sections[currentSection].classList.remove('d-none');
                
                // Update steps
                updateSteps();
            });
        });
        
        // Update steps display
        function updateSteps() {
            stepItems.forEach((item, index) => {
                if (index === currentSection) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
                
                if (index < currentSection) {
                    item.classList.add('completed');
                }
            });
        }
        
        // Validate section inputs
        function validateSection(sectionIndex) {
            const section = sections[sectionIndex];
            const inputs = section.querySelectorAll('input, select, textarea');
            let isValid = true;
            
            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            return isValid;
        }
        
        // Load subcategories when main category changes
        document.getElementById('main_category_id').addEventListener('change', function() {
            const mainCategoryId = this.value;
            
            if (!mainCategoryId) {
                return;
            }
            
            fetch(`{{ route('messages.get-subcategories') }}?main_category_id=${mainCategoryId}`)
                .then(response => response.json())
                .then(data => {
                    const subCategorySelect = document.getElementById('sub_category_id');
                    subCategorySelect.innerHTML = '<option value="">{{ __('Select Sub Category') }}</option>';
                    
                    data.forEach(category => {
                        const locale = '{{ app()->getLocale() }}';
                        const name = locale === 'ar' ? category.name_ar : category.name_en;
                        
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = name;
                        subCategorySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error loading subcategories:', error));
        });
        
        // Load cards when subcategory changes
        document.getElementById('sub_category_id').addEventListener('change', function() {
            const subCategoryId = this.value;
            
            if (!subCategoryId) {
                return;
            }
            
            const cardsContainer = document.getElementById('cardsContainer');
            cardsContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                    </div>
                    <p class="mt-2">{{ __('Loading cards...') }}</p>
                </div>
            `;
            
            fetch(`{{ route('messages.get-cards') }}?sub_category_id=${subCategoryId}`)
                .then(response => response.json())
                .then(data => {
                    cardsContainer.innerHTML = '';
                    
                    if (data.length === 0) {
                        cardsContainer.innerHTML = `
                            <div class="col-12 text-center py-5">
                                <p>{{ __('No cards found for this category.') }}</p>
                            </div>
                        `;
                        return;
                    }
                    
                    data.forEach(card => {
                        const locale = '{{ app()->getLocale() }}';
                        const title = locale === 'ar' ? card.title_ar : card.title_en;
                        
                        const cardElement = document.createElement('div');
                        cardElement.className = 'col-md-4 col-sm-6 mb-3';
                        cardElement.innerHTML = `
                            <div class="card-preview" data-card-id="${card.id}">
                                <img src="${card.image_url}" alt="${title}" class="card-img">
                                <div class="card-title">${title}</div>
                            </div>
                        `;
                        cardsContainer.appendChild(cardElement);
                    });
                    
                    // Add click event to card previews
                    document.querySelectorAll('.card-preview').forEach(card => {
                        card.addEventListener('click', function() {
                            document.querySelectorAll('.card-preview').forEach(c => {
                                c.classList.remove('selected');
                            });
                            
                            this.classList.add('selected');
                            document.getElementById('card_id').value = this.getAttribute('data-card-id');
                        });
                    });
                })
                .catch(error => console.error('Error loading cards:', error));
        });
        
        // Toggle recipient phone field based on lock type
        document.getElementById('lock_type').addEventListener('change', function() {
            const lockType = this.value;
            const recipientPhoneGroup = document.getElementById('recipientPhoneGroup');
            
            if (lockType === 'no_lock') {
                recipientPhoneGroup.style.display = 'none';
                document.getElementById('recipient_phone').removeAttribute('required');
            } else {
                recipientPhoneGroup.style.display = 'block';
                document.getElementById('recipient_phone').setAttribute('required', 'required');
            }
        });
        
        // Initialize lock type toggle
        const lockType = document.getElementById('lock_type').value;
        if (lockType !== 'no_lock') {
            document.getElementById('recipientPhoneGroup').style.display = 'block';
            document.getElementById('recipient_phone').setAttribute('required', 'required');
        }
        
        // Form submission validation
        document.getElementById('messageForm').addEventListener('submit', function(event) {
            // Check if a card is selected
            const cardId = document.getElementById('card_id').value;
            if (!cardId) {
                event.preventDefault();
                alert('{{ __('Please select a card.') }}');
                return false;
            }
            
            // Check if recipient phone is provided for locked cards
            const lockType = document.getElementById('lock_type').value;
            const recipientPhone = document.getElementById('recipient_phone').value;
            
            if (lockType !== 'no_lock' && !recipientPhone) {
                event.preventDefault();
                alert('{{ __('Recipient phone is required for locked cards.') }}');
                return false;
            }
        });
    });
</script>
@endsection