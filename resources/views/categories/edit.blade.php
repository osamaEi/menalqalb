@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Edit Category') }}</h4>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">
                        <i class="ri-arrow-left-line me-1"></i> {{ __('Back to Categories') }}
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-4">
                                <div class="col-md-2">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="avatar-upload mb-3">
                                            <div class="avatar-preview rounded" style="width: 150px; height: 150px;">
                                                <img id="imagePreview" class="w-100 h-100 rounded object-fit-cover" 
                                                    src="{{ $category->image ? asset('storage/'.$category->image) : asset('assets/img/default-category.png') }}" 
                                                    alt="{{ $category->name }}">
                                            </div>
                                        </div>
                                        <div class="btn btn-primary btn-sm position-relative overflow-hidden">
                                            <span>{{ __('Change Image') }}</span>
                                            <input type="file" name="image" id="imageUpload" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer">
                                        </div>
                                        @error('image')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control @error('name_ar') is-invalid @enderror" 
                                                    id="name_ar" name="name_ar" placeholder="{{ __('Arabic Name') }}" 
                                                    value="{{ old('name_ar', $category->name_ar) }}" required>
                                                <label for="name_ar">{{ __('Arabic Name') }} <span class="text-danger">*</span></label>
                                                @error('name_ar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control @error('name_en') is-invalid @enderror" 
                                                    id="name_en" name="name_en" placeholder="{{ __('English Name') }}" 
                                                    value="{{ old('name_en', $category->name_en) }}" required>
                                                <label for="name_en">{{ __('English Name') }} <span class="text-danger">*</span></label>
                                                @error('name_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" id="is_main" name="is_main" 
                                                    value="1" {{ old('is_main', $category->is_main) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_main">{{ __('Is Main Category?') }}</label>
                                            </div>
                                            
                                            <div id="parent-category-container" class="{{ old('is_main', $category->is_main) ? 'd-none' : '' }}">
                                                <div class="form-floating form-floating-outline">
                                                    <select class="form-select @error('parent_id') is-invalid @enderror" 
                                                        id="parent_id" name="parent_id">
                                                        <option value="">{{ __('Select Parent Category') }}</option>
                                                        @foreach($parentCategories as $parent)
                                                            <option value="{{ $parent->id }}" 
                                                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                                {{ $parent->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="parent_id">{{ __('Parent Category') }}</label>
                                                    @error('parent_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                    value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary me-2">
                                        {{ __('Cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i> {{ __('Update Category') }}
                                    </button>
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
        // Preview image before upload
        $("#imageUpload").on('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Show/hide parent category selector based on is_main status
        $("#is_main").on('change', function() {
            if ($(this).is(':checked')) {
                $("#parent-category-container").addClass('d-none');
                $("#parent_id").val(''); // Clear parent selection when switching to main
            } else {
                $("#parent-category-container").removeClass('d-none');
            }
        });
        
        // Initialize select2 if available
        if ($.fn.select2) {
            $('#parent_id').select2({
                placeholder: "{{ __('Select Parent Category') }}",
                allowClear: true
            });
        }
    });
</script>
@endsection