@extends('admin.index')

@section('styles')
<style>
.lock-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.image-modal {
    max-width: 90%;
    max-height: 90vh;
}

.info-label {
    font-weight: 500;
    color: #566a7f;
}

.status-badge {
    font-size: 0.85rem;
    padding: 0.35rem 0.5rem;
}

.transaction-item {
    padding: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.transaction-item:last-child {
    border-bottom: none;
}

.lock-details-card {
    height: 100%;
}

.history-card {
    height: 100%;
    max-height: 400px;
    overflow-y: auto;
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
                    <h4 class="fw-bold py-3 mb-0">{{ __('Lock Details') }}</h4>
                    <div>
                        <a href="{{ route('locks.edit', $lock->id) }}" class="btn btn-primary me-2">
                            <i class="ri-pencil-line me-1"></i> {{ __('Edit') }}
                        </a>
                        <a href="{{ route('locks.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line me-1"></i> {{ __('Back to Locks') }}
                        </a>
                    </div>
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
            <!-- Lock Images -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Lock Images') }}</h5>
                    </div>
                    <div class="card-body text-center">
                        @if($lock->image)
                            <div class="mb-4">
                                <img 
                                    src="{{ asset('storage/' . $lock->image) }}" 
                                    alt="{{ $lock->supplier }}" 
                                    class="lock-image cursor-pointer mb-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#imageModal"
                                    data-bs-img="{{ asset('storage/' . $lock->image) }}"
                                    data-bs-title="{{ __('Lock Image') }}"
                                    style="max-height: 200px;">
                                <p class="text-muted mb-0">{{ __('Lock Image') }}</p>
                            </div>
                        @else
                            <div class="mb-4">
                                <div class="alert alert-light border text-center mb-0">
                                    <i class="ri-image-line ri-3x mb-2"></i>
                                    <p>{{ __('No lock image available') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($lock->invoice_image)
                            <div class="mb-2">
                                <img 
                                    src="{{ asset('storage/' . $lock->invoice_image) }}" 
                                    alt="{{ __('Invoice') }}" 
                                    class="lock-image cursor-pointer mb-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#imageModal"
                                    data-bs-img="{{ asset('storage/' . $lock->invoice_image) }}"
                                    data-bs-title="{{ __('Invoice Image') }}"
                                    style="max-height: 200px;">
                                <p class="text-muted mb-0">{{ __('Invoice Image') }}</p>
                            </div>
                        @else
                            <div>
                                <div class="alert alert-light border text-center mb-0">
                                    <i class="ri-file-list-3-line ri-3x mb-2"></i>
                                    <p>{{ __('No invoice image available') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Lock Details -->
            <div class="col-md-4 mb-4">
                <div class="card lock-details-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Lock Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('ID') }}:</span>
                            <span class="badge bg-label-primary">#{{ $lock->id }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Supplier') }}:</span>
                            <h5 class="mb-0">{{ $lock->supplier }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Cost') }}:</span>
                            <h5 class="mb-0">{{ number_format($lock->cost, 2) }}</h5>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Quantity') }}:</span>
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 me-2">{{ $lock->quantity }}</h5>
                                <span class="badge bg-label-{{ $lock->quantity > 0 ? 'success' : 'danger' }}">
                                    {{ $lock->quantity > 0 ? __('In Stock') : __('Out of Stock') }}
                                </span>
                                <button type="button" class="btn btn-sm btn-icon ms-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#adjustQuantityModal"
                                    data-lock-id="{{ $lock->id }}"
                                    data-lock-supplier="{{ $lock->supplier }}"
                                    data-lock-quantity="{{ $lock->quantity }}">
                                    <i class="ri-edit-line text-primary"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Status') }}:</span>
                            <span class="badge status-badge bg-label-{{ $lock->is_active ? 'success' : 'danger' }}">
                                {{ $lock->is_active ? __('Active') : __('Inactive') }}
                            </span>
                            <form action="{{ route('locks.toggle.status', $lock->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-icon">
                                    <i class="ri-refresh-line text-primary"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="mb-3">
                            <span class="info-label d-block mb-1">{{ __('Created At') }}:</span>
                            <span>{{ $lock->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        
                        <div>
                            <span class="info-label d-block mb-1">{{ __('Last Updated') }}:</span>
                            <span>{{ $lock->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Lock Notes & History -->
            <div class="col-md-4 mb-4">
                <div class="card lock-details-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Notes & History') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <span class="info-label d-block mb-2">{{ __('Notes') }}:</span>
                            @if($lock->notes)
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($lock->notes)) !!}
                                </div>
                            @else
                                <p class="text-muted">{{ __('No notes available for this lock.') }}</p>
                            @endif
                        </div>
                        
                        <div>
                            <span class="info-label d-block mb-2">{{ __('Invoice Items') }}:</span>
                            @if($lock->invoiceItems->count() > 0)
                                <div class="history-card p-0">
                                    @foreach($lock->invoiceItems as $item)
                                        <div class="transaction-item">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong>{{ __('Invoice') }} #{{ $item->invoice_id }}</strong>
                                                <span class="badge bg-label-info">{{ $item->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>{{ __('Quantity') }}: {{ $item->quantity }}</span>
                                                <span>{{ __('Price') }}: {{ number_format($item->unit_price, 2) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">{{ __('No invoice history available for this lock.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 text-end">
                <form action="{{ route('locks.destroy', $lock->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this lock?') }}')">
                        <i class="ri-delete-bin-line me-1"></i> {{ __('Delete Lock') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">{{ __('Image Preview') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" class="image-modal" alt="Image Preview">
            </div>
        </div>
    </div>
</div>

<!-- Modal for adjusting quantity -->
<div class="modal fade" id="adjustQuantityModal" tabindex="-1" aria-labelledby="adjustQuantityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustQuantityModalLabel">{{ __('Adjust Lock Quantity') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="adjustQuantityForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="lock-supplier" class="form-label">{{ __('Supplier') }}</label>
                        <input type="text" class="form-control" id="lock-supplier" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="current-quantity" class="form-label">{{ __('Current Quantity') }}</label>
                        <input type="number" class="form-control" id="current-quantity" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="adjustment" class="form-label">{{ __('Adjustment') }}</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-danger" id="decrease-btn">-</button>
                            <input type="number" class="form-control text-center" id="adjustment" name="adjustment" required>
                            <button type="button" class="btn btn-outline-success" id="increase-btn">+</button>
                        </div>
                        <small class="form-text text-muted">{{ __('Use positive numbers to add inventory, negative to remove.') }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="adjustment-notes" class="form-label">{{ __('Notes (Optional)') }}</label>
                        <textarea class="form-control" id="adjustment-notes" name="notes" rows="3" placeholder="{{ __('Enter reason for adjustment...') }}"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="saveAdjustment">{{ __('Save Changes') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    // Initialize image modal
    $('#imageModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var imgSrc = button.data('bs-img');
        var title = button.data('bs-title');
        
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find('#modalImage').attr('src', imgSrc);
    });
    
    // Handle quantity adjustment modal
    $('#adjustQuantityModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var lockId = button.data('lock-id');
        var lockSupplier = button.data('lock-supplier');
        var lockQuantity = button.data('lock-quantity');
        
        var modal = $(this);
        modal.find('#lock-supplier').val(lockSupplier);
        modal.find('#current-quantity').val(lockQuantity);
        modal.find('#adjustment').val(0);
        
        // Update the form action
        var formAction = "{{ route('locks.adjust.quantity', ['lock' => ':lockId']) }}";
        formAction = formAction.replace(':lockId', lockId);
        modal.find('#adjustQuantityForm').attr('action', formAction);
    });
    
    // Increment and decrement buttons for quantity adjustment
    $('#increase-btn').on('click', function() {
        var value = parseInt($('#adjustment').val()) || 0;
        $('#adjustment').val(value + 1);
    });
    
    $('#decrease-btn').on('click', function() {
        var value = parseInt($('#adjustment').val()) || 0;
        $('#adjustment').val(value - 1);
    });
    
    // Submit the form when Save Changes is clicked
    $('#saveAdjustment').on('click', function() {
        // Validate that adjustment is not zero
        var adjustment = parseInt($('#adjustment').val()) || 0;
        if (adjustment === 0) {
            alert("{{ __('Adjustment cannot be zero.') }}");
            return;
        }
        
        // Validate that we don't try to remove more than current quantity
        var currentQuantity = parseInt($('#current-quantity').val()) || 0;
        if (adjustment < 0 && Math.abs(adjustment) > currentQuantity) {
            alert("{{ __('Cannot remove more than current quantity.') }}");
            return;
        }
        
        $('#adjustQuantityForm').submit();
    });
    
    // Auto-hide alert messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
});
</script>
@endsection