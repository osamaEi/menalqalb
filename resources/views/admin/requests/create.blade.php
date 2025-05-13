@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Requests') }} /</span> {{ __('Create New Request') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('New Request Details') }}</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('requests.store') }}">
                            @csrf
                            
                            <!-- Item Selection -->
                            <div class="mb-4">
                                <label for="locks_w_ready_card_id" class="form-label">{{ __('Select Item') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('locks_w_ready_card_id') is-invalid @enderror" 
                                    id="locks_w_ready_card_id" name="locks_w_ready_card_id" required>
                                    <option value="">{{ __('Choose an item...') }}</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" 
                                            data-price="{{ $item->price }}"
                                            data-points="{{ $item->points }}"
                                            data-type="{{ $item->type }}"
                                            data-image="{{ $item->photo ? asset('storage/' . $item->photo) : '' }}"
                                            {{ old('locks_w_ready_card_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} - ${{ $item->price }} ({{ $item->points }} {{ __('points') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('locks_w_ready_card_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Selected Item Preview -->
                            <div id="item-preview" class="alert alert-light mb-4" style="display: none;">
                                <h6 class="alert-heading">{{ __('Selected Item') }}</h6>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img id="item-image" src="" alt="" class="img-thumbnail" style="max-width: 100px; display: none;">
                                        <div id="item-placeholder" class="bg-secondary rounded p-3 text-center" style="display: none;">
                                            <i class="ri-image-line ri-48px text-white"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="mb-1"><strong>{{ __('Name:') }}</strong> <span id="item-name"></span></p>
                                        <p class="mb-1"><strong>{{ __('Type:') }}</strong> 
                                            <span id="item-type-badge" class="badge"></span>
                                        </p>
                                        <p class="mb-1"><strong>{{ __('Unit Price:') }}</strong> $<span id="item-price"></span></p>
                                        <p class="mb-0"><strong>{{ __('Unit Points:') }}</strong> <span id="item-points"></span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <h6 class="mb-3">{{ __('Customer Information') }}</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name') }}" 
                                        placeholder="{{ __('John Doe') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email') }}" 
                                        placeholder="{{ __('john@example.com') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" value="{{ old('phone') }}" 
                                        placeholder="{{ __('+1234567890') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label">{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                        id="quantity" name="quantity" value="{{ old('quantity', 1) }}" 
                                        min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="address" class="form-label">{{ __('Delivery Address') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                    id="address" name="address" rows="3" 
                                    placeholder="{{ __('123 Main Street, Apartment 4B, New York, NY 10001') }}" 
                                    required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Order Summary -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">{{ __('Order Summary') }}</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <strong>{{ __('Subtotal:') }}</strong>
                                                <span class="float-end">$<span id="subtotal">0.00</span></span>
                                            </p>
                                            <p class="mb-2">
                                                <strong>{{ __('Quantity:') }}</strong>
                                                <span class="float-end" id="summary-quantity">1</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <strong>{{ __('Total Price:') }}</strong>
                                                <span class="float-end text-primary fs-5">$<span id="total-price">0.00</span></span>
                                            </p>
                                            <p class="mb-0">
                                                <strong>{{ __('Total Points:') }}</strong>
                                                <span class="float-end text-primary fs-5"><span id="total-points">0</span> {{ __('points') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Notes Section (Optional) -->
                            <div class="mb-4">
                                <label for="notes" class="form-label">{{ __('Additional Notes') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                                <textarea class="form-control" id="notes" name="notes" rows="2" 
                                    placeholder="{{ __('Any special instructions or notes...') }}">{{ old('notes') }}</textarea>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="ri-save-line me-1"></i> {{ __('Create Request') }}
                                </button>
                                <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary">
                                    <i class="ri-close-line me-1"></i> {{ __('Cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemSelect = document.getElementById('locks_w_ready_card_id');
        const quantityInput = document.getElementById('quantity');
        const itemPreview = document.getElementById('item-preview');
        const itemImage = document.getElementById('item-image');
        const itemPlaceholder = document.getElementById('item-placeholder');
        const itemName = document.getElementById('item-name');
        const itemTypeBadge = document.getElementById('item-type-badge');
        const itemPrice = document.getElementById('item-price');
        const itemPoints = document.getElementById('item-points');
        const subtotalElement = document.getElementById('subtotal');
        const summaryQuantityElement = document.getElementById('summary-quantity');
        const totalPriceElement = document.getElementById('total-price');
        const totalPointsElement = document.getElementById('total-points');
        
        function updateItemPreview() {
            const selectedOption = itemSelect.options[itemSelect.selectedIndex];
            
            if (itemSelect.value) {
                // Show preview
                itemPreview.style.display = 'block';
                
                // Update item details
                const itemText = selectedOption.text.split(' - ')[0];
                itemName.textContent = itemText;
                
                const price = parseFloat(selectedOption.dataset.price);
                const points = parseInt(selectedOption.dataset.points);
                const type = selectedOption.dataset.type;
                const image = selectedOption.dataset.image;
                
                itemPrice.textContent = price.toFixed(2);
                itemPoints.textContent = points;
                
                // Update type badge
                if (type === 'lock') {
                    itemTypeBadge.className = 'badge bg-label-danger';
                    itemTypeBadge.textContent = '{{ __("Lock") }}';
                } else {
                    itemTypeBadge.className = 'badge bg-label-info';
                    itemTypeBadge.textContent = '{{ __("Read Card") }}';
                }
                
                // Update image
                if (image) {
                    itemImage.src = image;
                    itemImage.style.display = 'block';
                    itemPlaceholder.style.display = 'none';
                } else {
                    itemImage.style.display = 'none';
                    itemPlaceholder.style.display = 'block';
                }
                
                // Update totals
                updateTotals(price, points);
            } else {
                // Hide preview
                itemPreview.style.display = 'none';
                updateTotals(0, 0);
            }
        }
        
        function updateTotals(price = null, points = null) {
            const quantity = parseInt(quantityInput.value) || 1;
            
            if (price === null || points === null) {
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                if (itemSelect.value && selectedOption) {
                    price = parseFloat(selectedOption.dataset.price);
                    points = parseInt(selectedOption.dataset.points);
                } else {
                    price = 0;
                    points = 0;
                }
            }
            
            const subtotal = price;
            const totalPrice = (price * quantity);
            const totalPoints = points * quantity;
            
            subtotalElement.textContent = subtotal.toFixed(2);
            summaryQuantityElement.textContent = quantity;
            totalPriceElement.textContent = totalPrice.toFixed(2);
            totalPointsElement.textContent = totalPoints;
        }
        
        // Event listeners
        itemSelect.addEventListener('change', updateItemPreview);
        quantityInput.addEventListener('input', function() {
            updateTotals();
        });
        
        // Initialize on page load
        updateItemPreview();
    });
</script>

<style>
    #item-preview {
        border-left: 4px solid #007bff;
    }
    
    .form-label span.text-danger {
        font-size: 0.9em;
    }
    
    .card.bg-light {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef;
    }
</style>
@endsection