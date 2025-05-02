@extends('admin.index')

@section('styles')
<style>
.image-container {
    position: relative;
    display: inline-block;
    margin-bottom: 10px;
}

.image-preview {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    max-height: 200px;
}

.image-remove-btn {
    position: absolute;
    top: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.8);
    color: #dc3545;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.image-remove-btn:hover {
    background-color: #dc3545;
    color: white;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Edit Lock') }}</h4>
                    <a href="{{ route('locks.index') }}" class="btn btn-primary">
                        <i class="ri-arrow-left-line me-1"></i> {{ __('Back to Locks') }}
                    </a>
                </div>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Edit Lock Details') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('locks.update', $lock->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control @error('supplier') is-invalid @enderror" id="supplier" 
                                            name="supplier" value="{{ old('supplier', $lock->supplier) }}" required placeholder="{{ __('Supplier') }}">
                                        <label for="supplier">{{ __('Supplier') }}</label>
                                        @error('supplier')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" id="cost" 
                                            name="cost" value="{{ old('cost', $lock->cost) }}" required placeholder="{{ __('Cost') }}">
                                        <label for="cost">{{ __('Cost') }}</label>
                                        @error('cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" 
                                            name="quantity" value="{{ old('quantity', $lock->quantity) }}" required placeholder="{{ __('Quantity') }}">
                                        <label for="quantity">{{ __('Quantity') }}</label>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                            {{ old('is_active', $lock->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                    </div>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" 
                                        name="notes" rows="3" placeholder="{{ __('Enter notes about this lock...') }}">{{ old('notes', $lock->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="image" class="form-label">{{ __('Lock Image') }}</label>
                                    <div class="card mb-2">
                                        <div class="card-body text-center">
                                            @if($lock->image)
                                                <div class="image-container">
                                                    <img src="{{ asset('storage/' . $lock->image) }}" class="image-preview mb-2" alt="Lock Image">
                                                </div>
                                            @else
                                                <div class="text-muted mb-2">{{ __('No image uploaded') }}</div>
                                            @endif
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                                id="image" name="image" accept="image/*">
                                            <small class="form-text text-muted">{{ __('Upload a new image to replace the current one') }}</small>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="invoice_image" class="form-label">{{ __('Invoice Image') }}</label>
                                    <div class="card mb-2">
                                        <div class="card-body text-center">
                                            @if($lock->invoice_image)
                                                <div class="image-container">
                                                    <img src="{{ asset('storage/' . $lock->invoice_image) }}" class="image-preview mb-2" alt="Invoice Image">
                                                </div>
                                            @else
                                                <div class="text-muted mb-2">{{ __('No invoice image uploaded') }}</div>
                                            @endif
                                            <input type="file" class="form-control @error('invoice_image') is-invalid @enderror" 
                                                id="invoice_image" name="invoice_image" accept="image/*">
                                            <small class="form-text text-muted">{{ __('Upload a new invoice image to replace the current one') }}</small>
                                            @error('invoice_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="{{ route('locks.index') }}" class="btn btn-outline-secondary me-2">{{ __('Cancel') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Update Lock') }}</button>
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
    // Image Preview for Lock
    $('#image').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = $('<img class="image-preview mb-2" alt="Lock Image">').attr('src', e.target.result);
                var container = $('<div class="image-container"></div>').append(img);
                
                $('.image-container').first().replaceWith(container);
                if ($('.image-container').length === 0) {
                    $('.text-muted').first().replaceWith(container);
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    // Image Preview for Invoice
    $('#invoice_image').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = $('<img class="image-preview mb-2" alt="Invoice Image">').attr('src', e.target.result);
                var container = $('<div class="image-container"></div>').append(img);
                
                if ($('.image-container').length > 1) {
                    $('.image-container').eq(1).replaceWith(container);
                } else if ($('.image-container').length === 1) {
                    $('.text-muted').eq(1).replaceWith(container);
                } else {
                    $('.text-muted').eq(1).replaceWith(container);
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    // Auto-hide alert messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
});
</script>
@endsection