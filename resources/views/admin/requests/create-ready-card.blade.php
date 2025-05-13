@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Requests') }} /</span> {{ __('Request Ready Card') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header border-bottom bg-label-info">
                        <h5 class="mb-0">
                            <i class="ri-bank-card-2-line me-2"></i>{{ __('Ready Card Request Details') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('requests.store') }}">
                            @csrf
                            
                            <!-- Card Selection -->
                            <div class="mb-4">
                                <label class="form-label fs-5 fw-medium">{{ __('Available Ready Cards') }}</label>
                                <div class="row g-3">
                                    @foreach($readyCards as $card)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card border h-100 card-item">
                                                <input type="radio" 
                                                    name="locks_w_ready_card_id" 
                                                    id="card_{{ $card->id }}" 
                                                    value="{{ $card->id }}"
                                                    data-price="{{ $card->price }}"
                                                    data-points="{{ $card->points }}"
                                                    class="d-none card-radio"
                                                    {{ old('locks_w_ready_card_id') == $card->id ? 'checked' : '' }}
                                                    required>
                                                <label for="card_{{ $card->id }}" class="card-body cursor-pointer">
                                                    <div class="text-center">
                                                        @if($card->photo)
                                                            <img src="{{ asset('storage/' . $card->photo) }}" 
                                                                alt="{{ $card->name }}" 
                                                                class="img-fluid mb-3 rounded" 
                                                                style="max-height: 120px;">
                                                        @else
                                                            <div class="bg-label-info rounded p-3 d-inline-block mb-3">
                                                                <i class="ri-bank-card-2-line ri-48px text-info"></i>
                                                            </div>
                                                        @endif
                                                        <h6 class="mb-2">{{ $card->name }}</h6>
                                                        <p class="text-muted small mb-2">{{ Str::limit($card->description ?? '', 50) }}</p>
                                                        <div class="d-flex justify-content-around">
                                                            <span class="badge bg-label-primary">${{ $card->price }}</span>
                                                            <span class="badge bg-label-success">{{ $card->points }} pts</span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('locks_w_ready_card_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Customer Information -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
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
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">{{ __('Delivery Address') }} <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                            id="address" name="address" rows="3" 
                                            placeholder="{{ __('123 Main Street, Apartment 4B, New York, NY 10001') }}" 
                                            required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Order Summary -->
                            <div class="card border-info mb-4">
                                <div class="card-header bg-info bg-opacity-10">
                                    <h6 class="mb-0">{{ __('Order Summary') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mb-2">
                                                <strong>{{ __('Selected Card:') }}</strong>
                                                <span class="float-end" id="selected-card-name">-</span>
                                            </p>
                                            <p class="mb-0">
                                                <strong>{{ __('Quantity:') }}</strong>
                                                <span class="float-end" id="summary-quantity">1</span>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-2">
                                                <strong>{{ __('Unit Price:') }}</strong>
                                                <span class="float-end">$<span id="unit-price">0.00</span></span>
                                            </p>
                                            <p class="mb-0">
                                                <strong>{{ __('Unit Points:') }}</strong>
                                                <span class="float-end"><span id="unit-points">0</span> pts</span>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-2">
                                                <strong>{{ __('Total Price:') }}</strong>
                                                <span class="float-end text-info fs-5">$<span id="total-price">0.00</span></span>
                                            </p>
                                            <p class="mb-0">
                                                <strong>{{ __('Total Points:') }}</strong>
                                                <span class="float-end text-info fs-5"><span id="total-points">0</span> pts</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-info me-2">
                                    <i class="ri-save-line me-1"></i> {{ __('Submit Card Request') }}
                                </button>
                                <a href="{{ route('requests.create') }}" class="btn btn-outline-secondary">
                                    <i class="ri-arrow-left-line me-1"></i> {{ __('Back') }}
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
        const cardRadios = document.querySelectorAll('.card-radio');
        const quantityInput = document.getElementById('quantity');
        const selectedCardName = document.getElementById('selected-card-name');
        const unitPriceElement = document.getElementById('unit-price');
        const unitPointsElement = document.getElementById('unit-points');
        const summaryQuantityElement = document.getElementById('summary-quantity');
        const totalPriceElement = document.getElementById('total-price');
        const totalPointsElement = document.getElementById('total-points');
        
        function updateSummary() {
            const selectedRadio = document.querySelector('.card-radio:checked');
            const quantity = parseInt(quantityInput.value) || 1;
            
            if (selectedRadio) {
                const price = parseFloat(selectedRadio.dataset.price);
                const points = parseInt(selectedRadio.dataset.points);
                const cardName = selectedRadio.nextElementSibling.querySelector('h6').textContent;
                
                selectedCardName.textContent = cardName;
                unitPriceElement.textContent = price.toFixed(2);
                unitPointsElement.textContent = points;
                summaryQuantityElement.textContent = quantity;
                totalPriceElement.textContent = (price * quantity).toFixed(2);
                totalPointsElement.textContent = points * quantity;
            } else {
                selectedCardName.textContent = '-';
                unitPriceElement.textContent = '0.00';
                unitPointsElement.textContent = '0';
                totalPriceElement.textContent = '0.00';
                totalPointsElement.textContent = '0';
            }
        }
        
        cardRadios.forEach(radio => {
            radio.addEventListener('change', updateSummary);
        });
        
        quantityInput.addEventListener('input', updateSummary);
        
        // Initialize
        updateSummary();
    });
</script>

<style>
    .card-item {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .card-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .card-radio:checked + label .card {
        border-color: #0dcaf0 !important;
        background-color: #0dcaf010;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .bg-info.bg-opacity-10 {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
</style>
@endsection