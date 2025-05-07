@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">
                        <span class="text-muted fw-light">{{ __('Cards') }} /</span> {{ __('Edit Card') }}
                    </h4>
                    <div>
                        <a href="{{ route('cards.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="ri-arrow-left-line me-1"></i> {{ __('Back to List') }}
                        </a>
                        <a href="{{ route('cards.show', $card->id) }}" class="btn btn-outline-primary">
                            <i class="ri-eye-line me-1"></i> {{ __('View Card') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-8 col-lg-7 order-lg-1 order-2">
                <!-- Edit Card Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Edit Card Information') }}</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible mb-4" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form action="{{ route('cards.update', $card->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Card Title -->
                            <div class="mb-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" 
                                        name="title" value="{{ old('title', $card->title) }}" required placeholder="{{ __('Card Title') }}">
                                    <label for="title">{{ __('Card Title') }}</label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Language -->
                            <div class="mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select id="language" name="language" class="form-select @error('language') is-invalid @enderror" required>
                                        <option value="">{{ __('Select Language') }}</option>
                                        @foreach($languages as $code => $name)
                                            <option value="{{ $code }}" {{ old('language', $card->language) == $code ? 'selected' : '' }}>
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
                            
                            <!-- Card Type (Read-only as changing type is not recommended) -->
                            <div class="mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select id="card_type_id" name="card_type_id" class="form-select @error('card_type_id') is-invalid @enderror" required disabled>
                                        <option value="">{{ __('Select Card Type') }}</option>
                                        @foreach($cardTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('card_type_id', $card->card_type_id) == $type->id ? 'selected' : '' }}
                                                data-type="{{ $type->type }}">
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="card_type_id" value="{{ $card->card_type_id }}">
                                    <label for="card_type_id">{{ __('Card Type') }}</label>
                                    <small class="form-text text-muted">{{ __('Card type cannot be changed after creation') }}</small>
                                    @error('card_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Categories -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="main_category_id" name="main_category_id" class="form-select @error('main_category_id') is-invalid @enderror" required>
                                            <option value="">{{ __('Select Main Category') }}</option>
                                            @foreach($mainCategories as $category)
                                                <option value="{{ $category->id }}" {{ old('main_category_id', $card->main_category_id) == $category->id ? 'selected' : '' }}>
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
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="sub_category_id" name="sub_category_id" class="form-select @error('sub_category_id') is-invalid @enderror">
                                            <option value="">{{ __('Select Subcategory') }}</option>
                                            @if(isset($subcategories) && $subcategories->count() > 0)
                                                @foreach($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}" {{ old('sub_category_id', $card->sub_category_id) == $subcategory->id ? 'selected' : '' }}>
                                                        {{ $subcategory->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label for="sub_category_id">{{ __('Subcategory (Optional)') }}</label>
                                        @error('sub_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pricing -->
                            <div class="row mb-3">
                                
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" 
                                            name="selling_price" value="{{ old('selling_price', $card->selling_price) }}" required step="0.01" min="0">
                                        <label for="selling_price">{{ __('Selling Price') }}</label>
                                        @error('selling_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="text-center w-100">
                                        <span class="fw-medium">{{ __('Profit Margin') }}:</span>
                                        <span id="profit-margin" class="ms-2">
                                            {{ $card->profit_margin ?? 0 }}%
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- File Upload Section -->
                            <div class="mb-4">
                                <label class="form-label">{{ __('Card File') }}</label>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-center mb-3">
                                            @if($card->is_image)
                                                <img src="{{ asset('storage/' . $card->file_path) }}" 
                                                    alt="{{ $card->title }}" 
                                                    class="img-fluid rounded-3"
                                                    style="max-height: 150px; width: auto;" id="preview-image">
                                            @elseif($card->is_video)
                                                <video controls class="img-fluid rounded-3" style="max-height: 150px; width: auto;" id="preview-video">
                                                    <source src="{{ asset('storage/' . $card->file_path) }}" type="{{ $card->mime_type }}">
                                                    {{ __('Your browser does not support the video tag.') }}
                                                </video>
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-light rounded-3" 
                                                    style="height: 150px; width: 100%;" id="preview-container">
                                                    <div class="text-center">
                                                        <i class="ri-file-line ri-4x text-primary mb-2"></i>
                                                        <h6>{{ __('Current file') }}</h6>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="file_action" id="file_action_keep" value="keep" checked>
                                                <label class="form-check-label" for="file_action_keep">{{ __('Keep current file') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="file_action" id="file_action_replace" value="replace">
                                                <label class="form-check-label" for="file_action_replace">{{ __('Replace file') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="file_action" id="file_action_remove" value="remove" {{ $card->file_path ? '' : 'disabled' }}>
                                                <label class="form-check-label" for="file_action_remove">{{ __('Remove file') }}</label>
                                            </div>
                                        </div>
                                        
                                        <div id="file-upload-container" class="mt-3 d-none">
                                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                                id="file" name="file">
                                            <small class="form-text text-muted mt-2">
                                                {{ __('Supported formats depend on the card type.') }}
                                                @if($card->cardType)
                                                    @if($card->cardType->type === 'image')
                                                        {{ __('Supported formats: JPG, PNG, GIF, BMP, SVG, WebP') }}
                                                    @elseif($card->cardType->type === 'video')
                                                        {{ __('Supported formats: MP4, MOV, AVI, WebM') }}
                                                    @elseif($card->cardType->type === 'animated_image')
                                                        {{ __('Supported formats: GIF, Animated WebP') }}
                                                    @endif
                                                @endif
                                                <br>
                                                {{ __('Maximum file size:') }} 10MB
                                            </small>
                                            @error('file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                        {{ old('is_active', $card->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                            
                            <!-- Form Buttons -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="ri-save-line me-1"></i> {{ __('Update Card') }}
                                </button>
                                <a href="{{ route('cards.show', $card->id) }}" class="btn btn-outline-secondary">
                                    <i class="ri-close-line me-1"></i> {{ __('Cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-5 order-lg-2 order-1 mb-4">
                <!-- Card Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Card Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('Card ID') }}</span>
                                <span class="badge bg-label-primary">{{ $card->id }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('Card Type') }}</span>
                                <span class="badge bg-label-info">{{ $card->cardType->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('Status') }}</span>
                                <span class="badge bg-label-{{ $card->is_active ? 'success' : 'danger' }}">
                                    {{ $card->is_active ? __('Active') : __('Inactive') }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('Created') }}</span>
                                <span>{{ $card->created_at ? $card->created_at->format('M d, Y') : 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('Last Updated') }}</span>
                                <span>{{ $card->updated_at ? $card->updated_at->format('M d, Y') : 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- File Information Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('File Information') }}</h5>
                    </div>
                    <div class="card-body">
                        @if($card->file_path)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ __('Format') }}</span>
                                    <span>{{ $card->mime_type ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ __('Size') }}</span>
                                    <span>{{ isset($card->file_size) ? number_format($card->file_size / 1024, 2) . ' KB' : 'N/A' }}</span>
                                </li>
                                @if($card->width && $card->height)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ __('Dimensions') }}</span>
                                    <span>{{ $card->width }}x{{ $card->height }}</span>
                                </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ __('File Path') }}</span>
                                    <span class="text-truncate" style="max-width: 150px;" title="{{ $card->file_path }}">
                                        {{ $card->file_path }}
                                    </span>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $card->file_path) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="ri-download-line me-1"></i> {{ __('Download File') }}
                                </a>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="ri-file-forbid-line ri-3x text-muted mb-2"></i>
                                <p class="mb-0">{{ __('No file attached to this card') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle file upload container visibility
        const fileActionRadios = document.querySelectorAll('input[name="file_action"]');
        const fileUploadContainer = document.getElementById('file-upload-container');
        
        fileActionRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'replace') {
                    fileUploadContainer.classList.remove('d-none');
                } else {
                    fileUploadContainer.classList.add('d-none');
                }
            });
        });
        
        // Calculate profit margin
        function calculateProfitMargin() {
            const costPrice = parseFloat(document.getElementById('cost_price').value) || 0;
            const sellingPrice = parseFloat(document.getElementById('selling_price').value) || 0;
            const profitMarginElement = document.getElementById('profit-margin');
            
            if (costPrice === 0) {
                profitMarginElement.textContent = '100%';
                profitMarginElement.className = 'ms-2 text-success';
                return;
            }
            
            const profitMargin = ((sellingPrice - costPrice) / costPrice) * 100;
            profitMarginElement.textContent = profitMargin.toFixed(2) + '%';
            
            // Change color based on margin
            if (profitMargin < 0) {
                profitMarginElement.className = 'ms-2 text-danger';
            } else {
                profitMarginElement.className = 'ms-2 text-success';
            }
        }
        
        document.getElementById('cost_price').addEventListener('input', calculateProfitMargin);
        document.getElementById('selling_price').addEventListener('input', calculateProfitMargin);
        
        // File preview functionality
        const fileInput = document.getElementById('file');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const fileType = file.type.split('/')[0]; // Get the first part of the MIME type
                        
                        // Remove any existing previews
                        document.querySelectorAll('#preview-image, #preview-video').forEach(el => el.remove());
                        
                        if (fileType === 'image') {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = file.name;
                            img.className = 'img-fluid rounded-3';
                            img.style.maxHeight = '150px';
                            img.id = 'preview-image';
                            
                            const container = document.querySelector('.d-flex.align-items-center.justify-content-center.mb-3');
                            container.innerHTML = '';
                            container.appendChild(img);
                        } else if (fileType === 'video') {
                            const video = document.createElement('video');
                            video.controls = true;
                            video.className = 'img-fluid rounded-3';
                            video.style.maxHeight = '150px';
                            video.id = 'preview-video';
                            
                            const source = document.createElement('source');
                            source.src = e.target.result;
                            source.type = file.type;
                            
                            video.appendChild(source);
                            
                            const container = document.querySelector('.d-flex.align-items-center.justify-content-center.mb-3');
                            container.innerHTML = '';
                            container.appendChild(video);
                        } else {
                            // For other file types, show a generic icon
                            const container = document.querySelector('.d-flex.align-items-center.justify-content-center.mb-3');
                            container.innerHTML = `
                                <div class="text-center" id="preview-container">
                                    <i class="ri-file-line ri-4x text-primary mb-2"></i>
                                    <h6>${file.name}</h6>
                                    <small class="text-muted">${(file.size / 1024).toFixed(2)} KB</small>
                                </div>
                            `;
                        }
                    }
                    
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Load subcategories when main category changes
        const mainCategorySelect = document.getElementById('main_category_id');
        const subCategorySelect = document.getElementById('sub_category_id');
        
        if (mainCategorySelect && subCategorySelect) {
            mainCategorySelect.addEventListener('change', function() {
                const mainCategoryId = this.value;
                
                if (mainCategoryId) {
                    // Clear current options
                    subCategorySelect.innerHTML = '<option value="">{{ __("Select Subcategory") }}</option>';
                    
                    // Fetch subcategories via AJAX
                    fetch(`/get-subcategories/${mainCategoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                data.forEach(subcategory => {
                                    const option = document.createElement('option');
                                    option.value = subcategory.id;
                                    option.textContent = subcategory.name;
                                    subCategorySelect.appendChild(option);
                                });
                            }
                        })
                        .catch(error => console.error('Error loading subcategories:', error));
                } else {
                    subCategorySelect.innerHTML = '<option value="">{{ __("Select Subcategory") }}</option>';
                }
            });
        }
        
        // Initialize profit margin calculation
        calculateProfitMargin();
    });
</script>
@endsection