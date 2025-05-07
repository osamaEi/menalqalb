@extends('admin.index')

@section('content')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Card Management') }}</h4>
                    <button
                        class="btn btn-primary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddCard"
                        aria-controls="offcanvasAddCard">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Card') }}
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row g-6 mb-6">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="me-1">
                                <p class="text-heading mb-1">{{ __('Total') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-2">{{ $totalCards }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Cards') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-file-list-3-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="me-1">
                                <p class="text-heading mb-1">{{ __('Active') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $activeCards }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Active Cards') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <div class="ri-check-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="me-1">
                                <p class="text-heading mb-1">{{ __('Inactive') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $inactiveCards }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Inactive Cards') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-danger rounded-3">
                                    <div class="ri-close-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="me-1">
                                <p class="text-heading mb-1">{{ __('Types') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $cardsByType->count() }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Card Types') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <div class="ri-shape-2-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Cards Distribution and Most Used Cards -->
    
        
        <!-- Cards List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('Recent Cards') }}
                    </h5>
                    
                    <div class="d-flex align-items-center">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show me-3 mb-0 py-2" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show me-3 mb-0 py-2" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <button
                            class="btn btn-primary btn-sm d-block d-md-none"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasAddCard"
                            aria-controls="offcanvasAddCard">
                            <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <form action="{{ route('cards.index') }}" method="GET" class="row gx-5 gap-5 gap-md-0 w-100">
                        <!-- Hidden field to indicate form submission -->
                        <input type="hidden" name="_filter" value="1">
                        
                        <div class="col-md-4">
                            <div class="d-flex gap-3">
                                <select id="card-type-filter" name="card_type" class="form-select">
                                    <option value="">{{ __('Card Type') }}</option>
                                    @foreach($cardTypes as $type)
                                        <option value="{{ $type->id }}" {{ request('card_type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->type }}

                                        </option>
                                    @endforeach
                                </select>
                                
                                <select id="language-filter" name="language" class="form-select">
                                    <option value="">{{ __('Language') }}</option>
                                    @foreach($languages as $code => $name)
                                        <option value="{{ $code }}" {{ request('language') == $code ? 'selected' : '' }}>
                                            {{ __($name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="d-flex gap-3">
                                <select id="category-filter" name="category" class="form-select">
                                    <option value="">{{ __('Category') }}</option>
                                    @foreach($mainCategories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <select id="designer-filter" name="designer" class="form-select">
                                    <option value="">{{ __('Designer') }}</option>
                                    @foreach($designers as $designer)
                                        <option value="{{ $designer->id }}" {{ request('designer') == $designer->id ? 'selected' : '' }}>
                                            {{ $designer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="d-flex gap-3">
                                <select id="status-filter" name="status" class="form-select">
                                    <option value="">{{ __('Status') }}</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                                
                                <div class="input-group">
            
                                    <button class="btn btn-primary" type="submit">
                                        <i class="ri-filter-line me-1"></i> {{ __('Filter') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-cards table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Preview') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Language') }}</th>
                            <th>{{ __('Creator') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Pricing') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentCards as $card)
                        <tr>
                            <td>{{ $card->id }}</td>
                            <td>
                                <div class="avatar me-2">
                                    @if($card->is_image)
                                        <img src="{{ asset('storage/' . $card->file_path) }}" alt="{{ $card->title }}" class="rounded-3">
                                    @elseif($card->is_video)
                                        <span class="avatar-initial rounded-3 bg-label-danger">
                                            <i class="ri-video-line ri-lg"></i>
                                        </span>
                                    @else
                                        <span class="avatar-initial rounded-3 bg-label-info">
                                            <i class="ri-file-line ri-lg"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('cards.show', $card->id) }}" class="text-body fw-medium">
                                    {{ $card->title }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('cards.filter.type', $card->card_type_id) }}" class="badge bg-label-{{ 
                                    $card->cardType && $card->cardType->type === 'image' ? 'primary' : 
                                    ($card->cardType && $card->cardType->type === 'video' ? 'danger' : 
                                    ($card->cardType && $card->cardType->type === 'animated_image' ? 'success' : 'info')) 
                                }}">
                                    <i class="{{ 
                                        $card->cardType && $card->cardType->type === 'image' ? 'ri-image-line' : 
                                        ($card->cardType && $card->cardType->type === 'video' ? 'ri-video-line' : 
                                        ($card->cardType && $card->cardType->type === 'animated_image' ? 'ri-gif-line' : 'ri-file-line')) 
                                    }} me-1"></i>
                                    {{ $card->cardType ? $card->cardType->name : 'N/A' }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('cards.filter.main-category', $card->main_category_id) }}" class="mb-1">
                                        {{ $card->mainCategory ? $card->mainCategory->name : 'N/A' }}
                                    </a>
                                    @if($card->subCategory)
                                        <small>
                                            <a href="{{ route('cards.filter.sub-category', $card->sub_category_id) }}" class="text-muted">
                                                {{ $card->subCategory->name }}
                                            </a>
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('cards.filter.language', $card->language) }}" class="badge bg-label-secondary">
                                    {{ $languages[$card->language] ?? $card->language }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('cards.filter.designer', $card->user_id) }}">
                                    {{ $card->user ? $card->user->name : 'N/A' }}
                                </a>
                            </td>
                            <td>{{$card->created_at}}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span>{{ number_format($card->selling_price, 2) }}</span>
                                    <small class="text-{{ $card->profit_margin > 0 ? 'success' : 'danger' }}">
                                        {{ $card->profit_margin }}%
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                        {{ $card->is_active ? 'checked' : '' }}
                                        onchange="window.location.href='{{ route('cards.toggle.status', $card->id) }}'">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('cards.show', $card->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('cards.edit', $card->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('cards.destroy', $card->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{ __('Are you sure you want to delete this card?') }}')">
                                                <i class="ri-delete-bin-line text-danger me-2"></i>{{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 mb-5">
                {{ $recentCards->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas to add new card -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCard" aria-labelledby="offcanvasAddCardLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddCardLabel" class="offcanvas-title">{{ __('Add New Card') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100" data-simplebar>
        <form class="add-new-card pt-0" method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Card Details -->
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" 
                        name="title" value="{{ old('title') }}" required placeholder="{{ __('Card Title') }}">
                    <label for="title">{{ __('Card Title') }}</label>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="language" name="language" class="form-select @error('language') is-invalid @enderror" required>
                        <option value="">{{ __('Select Language') }}</option>
                        @foreach($languages as $code => $name)
                            <option value="{{ $code }}" {{ old('language') == $code ? 'selected' : '' }}>
                                {{ __($name) }}
                            </option>
                        @endforeach
                    </select>
                    <label for="language">{{ __('Language') }}</label>
                    @error('language')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="card_type_id" name="card_type_id" class="form-select @error('card_type_id') is-invalid @enderror" required>
                        <option value="">{{ __('Select Card Type') }}</option>
                        @foreach($cardTypes as $type)
                            <option value="{{ $type->id }}" {{ old('card_type_id') == $type->id ? 'selected' : '' }}
                                data-type="{{ $type->type }}">
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
                    <label for="card_type_id">{{ __('Card Type') }}</label>
                    @error('card_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <small class="text-muted type-hint mt-1"></small>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="main_category_id" name="main_category_id" class="form-select @error('main_category_id') is-invalid @enderror" required>
                        <option value="">{{ __('Select Main Category') }}</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <label for="main_category_id">{{ __('Main Category') }}</label>
                    @error('main_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="sub_category_id" name="sub_category_id" class="form-select @error('sub_category_id') is-invalid @enderror">
                        <option value="">{{ __('Select Subcategory') }}</option>
                        <!-- Subcategories will be loaded dynamically via JavaScript -->
                    </select>
                    <label for="sub_category_id">{{ __('Subcategory (Optional)') }}</label>
                    @error('sub_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="row">
                    {{-- <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control @error('cost_price') is-invalid @enderror" id="cost_price" 
                                name="cost_price" value="{{ old('cost_price', '0.00') }}" required step="0.01" min="0">
                            <label for="cost_price">{{ __('Cost Price') }}</label>
                            @error('cost_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" 
                                name="selling_price" value="{{ old('selling_price', '0.00') }}" required step="0.01" min="0">
                            <label for="selling_price">{{ __('Selling Price') }}</label>
                            @error('selling_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted">{{ __('Profit Margin') }}: <span id="profit-margin">0%</span></small>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="file" class="form-label">{{ __('Card File') }}</label>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <div id="preview-container" class="text-center">
                                <div class="avatar avatar-xl">
                                    <span class="avatar-initial rounded-3 bg-label-primary">
                                        <i class="ri-file-upload-line ri-2x"></i>
                                    </span>
                                </div>
                                <p class="mt-2">{{ __('No file selected') }}</p>
                            </div>
                        </div>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                            id="file" name="file" required>
                        <small class="form-text file-hint">{{ __('Supported formats depend on the card type.') }}</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{ __('Submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('Cancel') }}</button>
        </form>
    </div>
</div>


<script>

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get references to the form elements
    const mainCategorySelect = document.getElementById('main_category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    const cardTypeSelect = document.getElementById('card_type_id');
    const typeHint = document.querySelector('.type-hint');
    const fileInput = document.getElementById('file');
    const fileHint = document.querySelector('.file-hint');
    const previewContainer = document.getElementById('preview-container');
    const costPriceInput = document.getElementById('cost_price');
    const sellingPriceInput = document.getElementById('selling_price');
    const profitMarginSpan = document.getElementById('profit-margin');

    // Add event listener for main category changes
    if (mainCategorySelect) {
        mainCategorySelect.addEventListener('change', function() {
            loadSubCategories(this.value);
        });
        
        // Load subcategories for initial value if one is set
        if (mainCategorySelect.value) {
            loadSubCategories(mainCategorySelect.value);
        }
    }
    
    // Add event listener for card type changes
    if (cardTypeSelect) {
        cardTypeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const cardType = selectedOption.getAttribute('data-type');
            
            // Update type hint
            if (typeHint) {
                updateCardTypeHint(cardType);
            }
            
            // Update file hint
            if (fileHint) {
                updateFileHint(cardType);
            }
        });
        
        // Set initial hint if a card type is selected
        if (cardTypeSelect.value) {
            const selectedOption = cardTypeSelect.options[cardTypeSelect.selectedIndex];
            const cardType = selectedOption.getAttribute('data-type');
            
            if (typeHint) {
                updateCardTypeHint(cardType);
            }
            
            if (fileHint) {
                updateFileHint(cardType);
            }
        }
    }
    
    // File preview
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            displayFilePreview(this);
        });
    }
    
    // Price calculation for profit margin
    if (sellingPriceInput && profitMarginSpan) {
        sellingPriceInput.addEventListener('input', calculateProfitMargin);
        
        // If cost price is available, also listen to it
        if (costPriceInput) {
            costPriceInput.addEventListener('input', calculateProfitMargin);
        }
        
        // Initial calculation
        calculateProfitMargin();
    }
    
    // Function to load subcategories
    function loadSubCategories(mainCategoryId) {
        if (!mainCategoryId) {
            // If no main category is selected, clear and disable subcategory select
            clearSubCategories();
            return;
        }
        
        // Fetch subcategories via AJAX
        fetch(`/subcategories-for-main?main_category_id=${mainCategoryId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                populateSubCategories(data);
            })
            .catch(error => {
                console.error('Error fetching subcategories:', error);
                clearSubCategories();
            });
    }
    
    // Function to clear subcategory select
    function clearSubCategories() {
        if (subCategorySelect) {
            subCategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            // Keep the disabled attribute as it's optional
        }
    }
    
    // Function to populate subcategory select
    function populateSubCategories(subcategories) {
        if (!subCategorySelect) return;
        
        // Clear existing options first
        clearSubCategories();
        
        // Get the old selected value from a hidden input if available
        const oldSubCategoryValue = document.querySelector('input[name="old_sub_category_id"]')?.value;
        
        // Add new options
        subcategories.forEach(subcategory => {
            const option = document.createElement('option');
            option.value = subcategory.id;
            
            // Use the appropriate language name based on the site's locale
            // This is a simplification - you might want to use the app's current locale
            option.textContent = subcategory.name_ar || subcategory.name_en;
            
            // Select if it matches the old value
            if (oldSubCategoryValue && subcategory.id == oldSubCategoryValue) {
                option.selected = true;
            }
            
            subCategorySelect.appendChild(option);
        });
    }
    
    // Function to update card type hint
    function updateCardTypeHint(cardType) {
        if (!typeHint) return;
        
        // Set hint based on card type
        switch(cardType) {
            case 'Image':
                typeHint.textContent = 'Static images such as photos or graphics.';
                break;
            case 'Video':
                typeHint.textContent = 'Video content in various formats.';
                break;
            case 'Audio':
                typeHint.textContent = 'Audio files like music or sounds.';
                break;
            case 'Text':
                typeHint.textContent = 'Text-based content or documents.';
                break;
            default:
                typeHint.textContent = '';
        }
    }
    
    // Function to update file hint
    function updateFileHint(cardType) {
        if (!fileHint) return;
        
        // Set hint based on card type
        switch(cardType) {
            case 'Image':
                fileHint.textContent = 'Supported formats: JPG, PNG, GIF (Max: 5MB)';
                break;
            case 'Video':
                fileHint.textContent = 'Supported formats: MP4, MOV, AVI (Max: 50MB)';
                break;
            case 'Audio':
                fileHint.textContent = 'Supported formats: MP3, WAV, OGG (Max: 10MB)';
                break;
            case 'Text':
                fileHint.textContent = 'Supported formats: PDF, DOCX, TXT (Max: 10MB)';
                break;
            default:
                fileHint.textContent = 'Supported formats depend on the card type.';
        }
    }
    
    // Function to display file preview
    function displayFilePreview(input) {
        if (!previewContainer) return;
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileType = file.type.split('/')[0]; // Get the main type (image, video, etc.)
            
            // Clear previous preview
            previewContainer.innerHTML = '';
            
            if (fileType === 'image') {
                // Create image preview
                const img = document.createElement('img');
                img.className = 'img-fluid rounded-3';
                img.style.maxHeight = '150px';
                img.style.objectFit = 'contain';
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
                
                previewContainer.appendChild(img);
            } else {
                // For non-image files, show an icon
                const avatar = document.createElement('div');
                avatar.className = 'avatar avatar-xl';
                
                const span = document.createElement('span');
                span.className = 'avatar-initial rounded-3';
                
                let icon = '';
                let bgClass = '';
                
                switch(fileType) {
                    case 'video':
                        icon = 'ri-video-line';
                        bgClass = 'bg-label-danger';
                        break;
                    case 'audio':
                        icon = 'ri-music-line';
                        bgClass = 'bg-label-warning';
                        break;
                    case 'application':
                        if (file.type.includes('pdf')) {
                            icon = 'ri-file-pdf-line';
                            bgClass = 'bg-label-danger';
                        } else {
                            icon = 'ri-file-text-line';
                            bgClass = 'bg-label-info';
                        }
                        break;
                    default:
                        icon = 'ri-file-line';
                        bgClass = 'bg-label-secondary';
                }
                
                span.className += ' ' + bgClass;
                
                const i = document.createElement('i');
                i.className = icon + ' ri-2x';
                
                span.appendChild(i);
                avatar.appendChild(span);
                
                const p = document.createElement('p');
                p.className = 'mt-2';
                p.textContent = file.name;
                
                previewContainer.appendChild(avatar);
                previewContainer.appendChild(p);
            }
        } else {
            // No file selected, show default
            previewContainer.innerHTML = `
                <div class="avatar avatar-xl">
                    <span class="avatar-initial rounded-3 bg-label-primary">
                        <i class="ri-file-upload-line ri-2x"></i>
                    </span>
                </div>
                <p class="mt-2">No file selected</p>
            `;
        }
    }
    
    // Function to calculate profit margin
    function calculateProfitMargin() {
        if (!profitMarginSpan) return;
        
        const costPrice = parseFloat(costPriceInput?.value || 0);
        const sellingPrice = parseFloat(sellingPriceInput?.value || 0);
        
        if (sellingPrice <= 0) {
            profitMarginSpan.textContent = '0%';
            return;
        }
        
        if (costPrice <= 0) {
            profitMarginSpan.textContent = '100%';
            return;
        }
        
        const margin = ((sellingPrice - costPrice) / sellingPrice) * 100;
        profitMarginSpan.textContent = margin.toFixed(2) + '%';
    }
});

</script>

@endsection