@extends('admin.index')

@section('styles')
<style>
.image-preview {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    max-height: 200px;
}

.preview-container {
    text-align: center;
    margin-bottom: 15px;
    min-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-selection {
    max-height: 300px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #eee;
    border-radius: 5px;
}

.card-checkbox {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #eee;
    border-radius: 5px;
    transition: all 0.2s;
}

.card-checkbox:hover {
    background-color: rgba(105, 108, 255, 0.08);
}

.card-checkbox.selected {
    background-color: rgba(105, 108, 255, 0.15);
    border-color: rgba(105, 108, 255, 0.5);
}

.card-avatar {
    width: 40px;
    height: 40px;
    border-radius: 5px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    margin-right: 10px;
}

.image-container {
    position: relative;
    display: inline-block;
    margin-bottom: 10px;
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
                    <h4 class="fw-bold py-3 mb-0">{{ __('Edit Ready Card') }}</h4>
                    <a href="{{ route('ready-cards.index') }}" class="btn btn-primary">
                        <i class="ri-arrow-left-line me-1"></i> {{ __('Back to Ready Cards') }}
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
                        <h5 class="card-title mb-0">{{ __('Ready Card Details') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ready-cards.update', $readyCard->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_id" class="form-label">{{ __('Customer') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                        <option value="">{{ __('Select Customer') }}</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $readyCard->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="card_count" class="form-label">{{ __('Card Count') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('card_count') is-invalid @enderror" id="card_count" 
                                        name="card_count" value="{{ old('card_count', $readyCard->card_count) }}" required min="1">
                                    @error('card_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="cost" class="form-label">{{ __('Cost') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" id="cost" 
                                        name="cost" value="{{ old('cost', $readyCard->cost) }}" required min="0">
                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label for="received_card_image" class="form-label">{{ __('Card Image') }}</label>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="preview-container" id="image-preview-container">
                                                @if($readyCard->received_card_image)
                                                    <div class="image-container">
                                                        <img src="{{ asset('storage/' . $readyCard->received_card_image) }}" class="image-preview" alt="Card Image">
                                                    </div>
                                                @else
                                                    <div class="text-center text-muted">
                                                        <i class="ri-image-line ri-3x mb-2"></i>
                                                        <p>{{ __('No image available') }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="file" class="form-control @error('received_card_image') is-invalid @enderror" 
                                                id="received_card_image" name="received_card_image" accept="image/*">
                                            <small class="form-text text-muted">{{ __('Upload a new image to replace the current one') }}</small>
                                            @error('received_card_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                             
                            </div>
                            
                            <div class="row">
                                <div class="col-12 text-end">
                                    <a href="{{ route('ready-cards.index') }}" class="btn btn-outline-secondary me-2">{{ __('Cancel') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Update Ready Card') }}</button>
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
    // Image Preview
    $('#received_card_image').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview-container').html('<div class="image-container"><img src="' + e.target.result + '" class="image-preview" alt="Card Preview"></div>');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    // Card selection functionality
    function updateSelectedCount() {
        const count = $('input[name="card_ids[]"]:checked').length;
        $('#selected-count').text(count);
        
        // Update the card count input to match selected cards
        if (count > 0) {
            $('#card_count').val(count);
        }
    }
    
    // Highlight selected cards
    $('input[name="card_ids[]"]').on('change', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.card-checkbox').addClass('selected');
        } else {
            $(this).closest('.card-checkbox').removeClass('selected');
        }
        updateSelectedCount();
    });
    
    // Initialize selected count and card highlighting
    $('input[name="card_ids[]"]:checked').closest('.card-checkbox').addClass('selected');
    updateSelectedCount();
    
    // Select all cards
    $('#select-all').on('click', function() {
        $('input[name="card_ids[]"]').prop('checked', true).trigger('change');
    });
    
    // Deselect all cards
    $('#deselect-all').on('click', function() {
        $('input[name="card_ids[]"]').prop('checked', false).trigger('change');
    });
    
    // Search cards
    $('#card-search').on('keyup', function() {
        const searchText = $(this).val().toLowerCase();
        $('.card-checkbox').each(function() {
            const cardText = $(this).text().toLowerCase();
            $(this).toggle(cardText.indexOf(searchText) > -1);
        });
    });
    
    // Auto-hide alert messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
});
</script>
@endsection