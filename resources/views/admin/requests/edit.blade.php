@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Requests') }} /</span> {{ __('Edit Request') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('Edit Request Details') }}</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('requests.update', $request->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Item Selection -->
                            <div class="mb-4">
                                <label for="locks_w_ready_card_id" class="form-label">{{ __('Item') }}</label>
                                <select class="form-select @error('locks_w_ready_card_id') is-invalid @enderror" 
                                    id="locks_w_ready_card_id" name="locks_w_ready_card_id" required>
                                    <option value="">{{ __('Select Item') }}</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" 
                                            {{ old('locks_w_ready_card_id', $request->locks_w_ready_card_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} - ${{ $item->price }} ({{ $item->points }} {{ __('points') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('locks_w_ready_card_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Customer Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">{{ __('Customer Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name', $request->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email', $request->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" value="{{ old('phone', $request->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                        id="quantity" name="quantity" value="{{ old('quantity', $request->quantity) }}" 
                                        min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                    id="address" name="address" rows="3" required>{{ old('address', $request->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Status and Totals -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                        <option value="pending" {{ old('status', $request->status) == 'pending' ? 'selected' : '' }}>
                                            {{ __('Pending') }}
                                        </option>
                                        <option value="processing" {{ old('status', $request->status) == 'processing' ? 'selected' : '' }}>
                                            {{ __('Processing') }}
                                        </option>
                                        <option value="approved" {{ old('status', $request->status) == 'approved' ? 'selected' : '' }}>
                                            {{ __('Approved') }}
                                        </option>
                                        <option value="rejected" {{ old('status', $request->status) == 'rejected' ? 'selected' : '' }}>
                                            {{ __('Rejected') }}
                                        </option>
                                        <option value="completed" {{ old('status', $request->status) == 'completed' ? 'selected' : '' }}>
                                            {{ __('Completed') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('Total Price') }}</label>
                                    <div class="form-control-plaintext">
                                        <strong id="total-price">${{ number_format($request->total_price, 2) }}</strong>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('Total Points') }}</label>
                                    <div class="form-control-plaintext">
                                        <strong id="total-points">{{ $request->total_points }} {{ __('points') }}</strong>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Current Item Info -->
                            @if($request->locksWReadyCard)
                                <div class="alert alert-info mb-4">
                                    <h6 class="alert-heading">{{ __('Current Item Information') }}</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if($request->locksWReadyCard->photo)
                                                <img src="{{ asset('storage/' . $request->locksWReadyCard->photo) }}" 
                                                    alt="{{ $request->locksWReadyCard->name }}" 
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            @else
                                                <div class="bg-light rounded p-3 text-center">
                                                    <i class="ri-image-line ri-48px text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <p class="mb-1"><strong>{{ __('Name:') }}</strong> {{ $request->locksWReadyCard->name }}</p>
                                            <p class="mb-1"><strong>{{ __('Type:') }}</strong> 
                                                <span class="badge bg-label-{{ $request->locksWReadyCard->type == 'lock' ? 'danger' : 'info' }}">
                                                    {{ $request->locksWReadyCard->type == 'lock' ? __('Lock') : __('Read Card') }}
                                                </span>
                                            </p>
                                            <p class="mb-1"><strong>{{ __('Price:') }}</strong> ${{ $request->locksWReadyCard->price }}</p>
                                            <p class="mb-0"><strong>{{ __('Points:') }}</strong> {{ $request->locksWReadyCard->points }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">{{ __('Update Request') }}</button>
                                <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update totals when quantity or item changes
    document.addEventListener('DOMContentLoaded', function() {
        const itemSelect = document.getElementById('locks_w_ready_card_id');
        const quantityInput = document.getElementById('quantity');
        const totalPriceElement = document.getElementById('total-price');
        const totalPointsElement = document.getElementById('total-points');
        
        // Store item data
        const items = @json($items);
        
        function updateTotals() {
            const selectedItemId = itemSelect.value;
            const quantity = parseInt(quantityInput.value) || 0;
            
            if (selectedItemId) {
                const item = items.find(i => i.id == selectedItemId);
                if (item) {
                    const totalPrice = (item.price * quantity).toFixed(2);
                    const totalPoints = item.points * quantity;
                    
                    totalPriceElement.textContent = '$' + totalPrice;
                    totalPointsElement.textContent = totalPoints + ' {{ __("points") }}';
                }
            }
        }
        
        itemSelect.addEventListener('change', updateTotals);
        quantityInput.addEventListener('input', updateTotals);
    });
</script>
@endsection