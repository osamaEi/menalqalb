@extends('admin.index')

@section('styles')
<style>
.image-preview {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.2s;
}

.image-preview:hover {
    transform: scale(1.05);
}

/* Improve scrollbar appearance */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background-color: #adb5bd;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #6c757d;
}

/* Make sure the offcanvas form scrolls properly on smaller screens */
.offcanvas-body[data-simplebar] {
    max-height: calc(100vh - 60px);
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
                    <h4 class="fw-bold py-3 mb-0">{{ __('Lock Management') }}</h4>
                    <button
                        class="btn btn-primary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddLock"
                        aria-controls="offcanvasAddLock">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Lock') }}
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
                                    <h4 class="mb-1 me-2">{{ $totalLocks }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Locks') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-lock-line ri-26px"></div>
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
                                    <h4 class="mb-1 me-1">{{ $activeLocks }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Active Locks') }}</small>
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
                                    <h4 class="mb-1 me-1">{{ $inactiveLocks }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Inactive Locks') }}</small>
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
                                <p class="text-heading mb-1">{{ __('In Stock') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $inStockLocks }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Available Locks') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <div class="ri-stack-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Locks List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('All Locks') }}
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
                            data-bs-target="#offcanvasAddLock"
                            aria-controls="offcanvasAddLock">
                            <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
                
                <form action="{{ route('locks.index') }}" method="GET">
                    <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                        <div class="col-md-3">
                            <select id="supplier-filter" name="supplier" class="form-select">
                                <option value="">{{ __('Select Supplier') }}</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier }}" {{ request('supplier') == $supplier ? 'selected' : '' }}>
                                        {{ $supplier }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="status-filter" name="status" class="form-select">
                                <option value="">{{ __('Select Status') }}</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="stock-filter" name="stock" class="form-select">
                                <option value="">{{ __('Select Stock Status') }}</option>
                                <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>{{ __('In Stock') }}</option>
                                <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>{{ __('Out of Stock') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-input" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}">
                                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('locks.index') }}" class="btn btn-outline-secondary">{{ __('Reset Filters') }}</a>
                    </div>
                </form>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-locks table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Supplier') }}</th>
                            <th>{{ __('Cost') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locks as $lock)
                        <tr>
                            <td>{{ $lock->id }}</td>
                            <td>
                                <div class="avatar me-2">
                                    @if($lock->image)
                                        <img src="{{ asset('storage/' . $lock->image) }}" alt="Lock Image" class="rounded-3">
                                    @else
                                        <span class="avatar-initial rounded-3 bg-label-info">
                                            <i class="ri-lock-line"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('locks.filter.supplier', $lock->supplier) }}" class="text-body fw-medium">
                                    {{ $lock->supplier }}
                                </a>
                            </td>
                            <td>{{ number_format($lock->cost, 2) }}</td>
                            <td>
                                <span class="badge bg-label-{{ $lock->quantity > 0 ? 'success' : 'danger' }}">
                                    {{ $lock->quantity }}
                                </span>
                                <button type="button" class="btn btn-sm btn-icon" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#adjustQuantityModal"
                                    data-lock-id="{{ $lock->id }}"
                                    data-lock-supplier="{{ $lock->supplier }}"
                                    data-lock-quantity="{{ $lock->quantity }}">
                                    <i class="ri-edit-line text-primary"></i>
                                </button>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                        {{ $lock->is_active ? 'checked' : '' }}
                                        onchange="window.location.href='{{ route('locks.toggle.status', $lock->id) }}'">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('locks.show', $lock->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('locks.edit', $lock->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('locks.destroy', $lock->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{ __('Are you sure you want to delete this lock?') }}')">
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
                {{ $locks->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas to add new lock -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddLock" aria-labelledby="offcanvasAddLockLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddLockLabel" class="offcanvas-title">{{ __('Add Lock') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" data-simplebar>
        <form class="add-new-lock pt-0" method="POST" action="{{ route('locks.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('supplier') is-invalid @enderror" id="supplier" 
                        name="supplier" value="{{ old('supplier') }}" required placeholder="{{ __('Supplier') }}">
                    <label for="supplier">{{ __('Supplier') }}</label>
                    @error('supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" id="cost" 
                        name="cost" value="{{ old('cost') }}" required placeholder="{{ __('Cost') }}">
                    <label for="cost">{{ __('Cost') }}</label>
                    @error('cost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
        
            <div class="mb-3">
                <label for="notes" class="form-label">{{ __('Notes') }}</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" 
                    name="notes" rows="3" placeholder="{{ __('Enter notes about this lock...') }}">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
        
            
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </form>
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
    // Image Preview for Lock
    $('#image').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    // Image Preview for Invoice
    $('#invoice_image').on('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-invoice-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    // Initialize DataTable
    var dataTable = $('.datatables-locks').DataTable({
        ordering: true,
        paging: false,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: {
            search: '',
            searchPlaceholder: "{{ __('Search...') }}",
        }
    });
    
    // Handle quantity adjustment modal
    $('#adjustQuantityModal').on('show.bs.modal', function (event) {
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