@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Card Types') }} /</span> {{ __('Edit Card Type') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Edit Card Type') }}: {{ $cardType->name_en }}</span>
                        <span class="badge bg-label-{{ $cardType->is_active ? 'success' : 'danger' }}">
                            {{ $cardType->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </h5>
                    
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible mb-4" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('card_types.update', $cardType->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <h5 class="card-header">{{ __('Basic Information') }}</h5>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="name_en" class="form-label">{{ __('English Name') }}</label>
                                                <input type="text" class="form-control @error('name_en') is-invalid @enderror" 
                                                    id="name_en" name="name_en" value="{{ old('name_en', $cardType->name_en) }}" required>
                                                @error('name_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="name_ar" class="form-label">{{ __('Arabic Name') }}</label>
                                                <input type="text" class="form-control @error('name_ar') is-invalid @enderror" 
                                                    id="name_ar" name="name_ar" value="{{ old('name_ar', $cardType->name_ar) }}" 
                                                    required dir="rtl">
                                                @error('name_ar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="type" class="form-label">{{ __('Card Type') }}</label>
                                                <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                                                    <option value="">{{ __('Select Type') }}</option>
                                                    @foreach($typeOptions as $key => $label)
                                                        <option value="{{ $key }}" {{ old('type', $cardType->type) == $key ? 'selected' : '' }}>
                                                            {{ __($label) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                                        {{ old('is_active', $cardType->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Visual Elements -->
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <h5 class="card-header">{{ __('Visual Elements') }}</h5>
                                        <div class="card-body">
                                            <!-- Icon Selection -->
                                            <div class="mb-4">
                                                <label class="form-label">{{ __('Icon') }}</label>
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <label class="form-label mb-0">{{ __('Selected Icon') }}</label>
                                                            <span class="selected-icon-display d-flex align-items-center">
                                                                <i class="{{ $cardType->icon }} ri-lg me-1" id="selected-icon-preview"></i>
                                                                <span id="selected-icon-name">{{ $cardType->icon }}</span>
                                                            </span>
                                                        </div>
                                                        <input type="hidden" name="icon" id="selected-icon" value="{{ old('icon', $cardType->icon) }}" required>
                                                        
                                                        <div class="icon-grid">
                                                            <div class="row g-2" style="max-height: 200px; overflow-y: auto;">
                                                                @foreach($iconOptions as $icon => $label)
                                                                <div class="col-2 text-center">
                                                                    <div class="card icon-card cursor-pointer p-2 text-center mb-0 {{ $icon === $cardType->icon ? 'bg-light border-primary' : '' }}" 
                                                                        data-icon="{{ $icon }}">
                                                                        <i class="{{ $icon }} ri-lg"></i>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Photo Upload -->
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">{{ __('Photo') }}</label>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-center mb-3">
                                                            @if($cardType->photo)
                                                                <img src="{{ asset('storage/' . $cardType->photo) }}" alt="{{ $cardType->name_en }}" 
                                                                    class="rounded-3 border" width="100" height="100" id="preview-photo">
                                                            @else
                                                                <img src="{{ asset('assets/img/default-card-type.png') }}" alt="preview" 
                                                                    class="rounded-3 border" width="100" height="100" id="preview-photo">
                                                            @endif
                                                        </div>
                                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                                            id="photo" name="photo" accept="image/*">
                                                        <small class="form-text">{{ __('Leave empty to keep current image. Recommended size: 400x400px') }}</small>
                                                        @error('photo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <div>
                                        <a href="{{ route('card_types.index') }}" class="btn btn-outline-secondary me-1">
                                            <i class="ri-arrow-left-line me-1"></i> {{ __('Back to List') }}
                                        </a>
                                        <a href="{{ route('card_types.show', $cardType->id) }}" class="btn btn-outline-primary">
                                            <i class="ri-eye-line me-1"></i> {{ __('View Details') }}
                                        </a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i> {{ __('Update Card Type') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Icon Selection
        $('.icon-card').on('click', function() {
            var selectedIcon = $(this).data('icon');
            $('#selected-icon').val(selectedIcon);
            $('#selected-icon-preview').attr('class', selectedIcon + ' ri-lg me-1');
            $('#selected-icon-name').text(selectedIcon);
            
            // Highlight selected icon card
            $('.icon-card').removeClass('bg-light border-primary');
            $(this).addClass('bg-light border-primary');
        });
        
        // Photo Preview
        $('#photo').on('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-photo').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    });
</script>
@endsection