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

/* QR code styling */
.qrcode {
    display: inline-block;
    margin: 0 auto;
}
.qrcode-container {
    width: 85px;
    height: 85px;
    margin: 0 auto;
    padding: 2px;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qrcode-container img {
    max-width: 100%;
    max-height: 100%;
}
/* Modal max height */
.modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

/* Status badges */
.badge-open {
    background-color: #2ecc71 !important;
}

.badge-closed {
    background-color: #6c757d !important;
}
</style>

<!-- Add Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Ready Card Management') }}</h4>
                    <a href="{{ route('ready-cards.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Ready Card') }}
                    </a>
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
                                    <h4 class="mb-1 me-2">{{ $totalReadyCards }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Ready Cards') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-credit-card-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Total Cards') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $totalCardCount }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Cards Issued') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <div class="ri-stack-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Total Cost') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ number_format($totalCost, 2) }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Cost of Ready Cards') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <div class="ri-money-dollar-circle-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Customers') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $uniqueCustomers }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Unique Customers') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded-3">
                                    <div class="ri-user-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ready Cards List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('All Ready Cards') }}
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
                    </div>
                </div>
                
                <form action="{{ route('ready-cards.index') }}" method="GET">
                    <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                        <div class="col-md-3">
                            <select id="customer-filter" name="customer_id" class="form-select">
                                <option value="">{{ __('Select Customer') }}</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="sort-filter" name="sort" class="form-select">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                                <option value="cost_high" {{ request('sort') == 'cost_high' ? 'selected' : '' }}>{{ __('Highest Cost') }}</option>
                                <option value="cost_low" {{ request('sort') == 'cost_low' ? 'selected' : '' }}>{{ __('Lowest Cost') }}</option>
                                <option value="card_count_high" {{ request('sort') == 'card_count_high' ? 'selected' : '' }}>{{ __('Most Cards') }}</option>
                                <option value="card_count_low" {{ request('sort') == 'card_count_low' ? 'selected' : '' }}>{{ __('Least Cards') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-input" name="search" value="{{ request('search') }}" placeholder="{{ __('Search customer...') }}">
                                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('ready-cards.index') }}" class="btn btn-outline-secondary w-100">{{ __('Reset Filters') }}</a>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center row gx-5 pt-3">
                        <div class="col-md-4">
                            <label for="date-from" class="form-label">{{ __('Date From') }}</label>
                            <input type="date" class="form-control" id="date-from" name="date_from" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="date-to" class="form-label">{{ __('Date To') }}</label>
                            <input type="date" class="form-control" id="date-to" name="date_to" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">{{ __('Apply Filters') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-ready-cards table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Card Count') }}</th>
                            <th>{{ __('Cost') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($readyCards as $readyCard)
                        <tr>
                            <td>{{ $readyCard->id }}</td>
                            <td>
                                <a href="{{ route('ready_cards.filter.customer', $readyCard->customer_id) }}" class="text-body fw-medium">
                                    {{ $readyCard->customer->name }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-label-info">
                                    {{ $readyCard->card_count }}
                                </span>
                            </td>
                            <td>{{ number_format($readyCard->cost, 2) }}</td>
                            <td>
                                <div class="avatar me-2">
                                    @if($readyCard->received_card_image)
                                        <img src="{{ asset('storage/' . $readyCard->received_card_image) }}" alt="Card Image" class="rounded-3">
                                    @else
                                        <span class="avatar-initial rounded-3 bg-label-primary">
                                            <i class="ri-image-line"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $readyCard->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- Changed to use onclick handler for direct response -->
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="showCardItems({{ $readyCard->id }})">
                                            <i class="ri-bank-card-2-line text-primary me-2"></i>{{ __('View Cards') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('ready-cards.show', $readyCard->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('ready-cards.edit', $readyCard->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('ready-cards.destroy', $readyCard->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{ __('Are you sure you want to delete this ready card?') }}')">
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
                {{ $readyCards->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Card Items Modal -->
<div class="modal fade" id="cardItemsModal" tabindex="-1" aria-labelledby="cardItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardItemsModalLabel">{{ __('Card Items') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search-card-items" placeholder="{{ __('Search card items...') }}">
                            <button class="btn btn-outline-primary" type="button" id="filter-card-items">{{ __('Search') }}</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select id="status-filter" class="form-select">
                            <option value="all">{{ __('All Statuses') }}</option>
                            <option value="open">{{ __('Open') }}</option>
                            <option value="closed">{{ __('Closed') }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="card-items-table">
                        <thead>
                            <tr>
                                <th>{{ __('Sequence #') }}</th>
                                <th>{{ __('Identity #') }}</th>
                                <th>{{ __('QR Code') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody id="card-items-body">
                            <!-- Card items will be loaded dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" id="print-all-cards">{{ __('Print All Cards') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Toastr and QR Code JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode.js/lib/qrcode.min.js"></script>

<script>
// Initialize bootstrap components
document.addEventListener('DOMContentLoaded', function() {
    // Configure Toastr
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };
    }
    
    // Set up DataTable if exists
    if ($.fn.DataTable) {
        $('.datatables-ready-cards').DataTable({
            ordering: true,
            paging: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                search: '',
                searchPlaceholder: "{{ __('Search...') }}",
            }
        });
    }
    
    // Auto-hide alert messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
    
    // Auto-submit form when customer filter changes
    $('#customer-filter').on('change', function() {
        if (this.value) {
            window.location.href = "{{ route('ready_cards.filter.customer', '') }}/" + this.value;
        }
    });
    
    // Auto-submit form when sort filter changes
    $('#sort-filter').on('change', function() {
        $(this).closest('form').submit();
    });
    
    // Add event listeners for the modal
    document.getElementById('filter-card-items').addEventListener('click', function() {
        applyFilters();
    });
    
    document.getElementById('search-card-items').addEventListener('keyup', function(e) {
        if (e.keyCode === 13) {
            applyFilters();
        }
    });
    
    document.getElementById('status-filter').addEventListener('change', function() {
        applyFilters();
    });
    
    document.getElementById('print-all-cards').addEventListener('click', function() {
        var titleText = document.getElementById('cardItemsModalLabel').textContent;
        var readyCardId = titleText.split('#')[1].trim();
        window.open("{{ route('ready-cards.print-all', '') }}/" + readyCardId, '_blank');
    });
});

// Function to show card items - called directly from the View Cards button
function showCardItems(readyCardId) {
    console.log('showCardItems function called with ID:', readyCardId);
    
    // Update modal title
    document.getElementById('cardItemsModalLabel').textContent = '{{ __('Card Items for Ready Card #') }}' + readyCardId;
    
    // Show loading indicator
    document.getElementById('card-items-body').innerHTML = 
        '<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>{{ __('Loading card items...') }}</td></tr>';
    
    // Show the modal - using vanilla JS for reliability
    var myModal = new bootstrap.Modal(document.getElementById('cardItemsModal'));
    myModal.show();
    
    // Fetch card items data
    fetch('/ready-cards/' + readyCardId + '/items')
        .then(function(response) {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(function(data) {
            console.log('Data received:', data);
            processCardItemsData(data);
        })
        .catch(function(error) {
            console.error('Error loading card items:', error);
            document.getElementById('card-items-body').innerHTML = 
                '<tr><td colspan="5" class="text-center text-danger">{{ __('Failed to load card items') }}</td></tr>';
            
            if (typeof toastr !== 'undefined') {
                toastr.error('{{ __('Failed to load card items') }}');
            }
        });
}

// Process the card items data and update the modal
// Process the card items data and update the modal
function processCardItemsData(data) {
    var items = data.items;
    var html = '';
    
    if (items && items.length > 0) {
        items.forEach(function(item) {
            var statusBadge = item.status === 'open' ? 
                '<span class="badge bg-success">{{ __('Open') }}</span>' : 
                '<span class="badge bg-secondary">{{ __('Closed') }}</span>';
                
            html += '<tr data-id="' + item.id + '" data-status="' + item.status + '">';
            html += '<td>' + item.sequence_number + '</td>';
            html += '<td>' + item.identity_number + '</td>';
            // Create a unique container ID for each QR code
            html += '<td class="text-center"><div id="qrcode-container-' + item.id + '" class="qrcode-container"></div></td>';
            html += '<td>' + statusBadge + '</td>';
            html += '<td class="text-center">';
            html += '<button type="button" class="btn btn-sm btn-outline-primary toggle-status" data-id="' + item.id + '" data-status="' + item.status + '" onclick="toggleCardStatus(this)">';
            html += item.status === 'open' ? '{{ __('Close') }}' : '{{ __('Open') }}';
            html += '</button> ';
            html += '<button type="button" class="btn btn-sm btn-outline-secondary print-card" data-id="' + item.id + '" onclick="printCard(' + item.id + ')">';
            html += '<i class="ri-printer-line me-1"></i>{{ __('Print') }}';
            html += '</button>';
            html += '</td>';
            html += '</tr>';
        });
        
        document.getElementById('card-items-body').innerHTML = html;
        
        // Generate QR codes after the HTML has been added to the DOM
        setTimeout(function() {
            items.forEach(function(item) {
                try {
                    var qrContainer = document.getElementById('qrcode-container-' + item.id);
                    if (qrContainer) {
                        // Clear any previous content
                        qrContainer.innerHTML = '';
                        
                        // Create new QR code
                        new QRCode(qrContainer, {
                            text: item.qr_code,
                            width: 80,
                            height: 80,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    } else {
                        console.error('QR container not found for item ' + item.id);
                    }
                } catch (e) {
                    console.error('Error generating QR code for item ' + item.id, e);
                }
            });
        }, 100); // Small delay to ensure DOM is updated
    } else {
        document.getElementById('card-items-body').innerHTML = 
            '<tr><td colspan="5" class="text-center">{{ __('No card items found') }}</td></tr>';
    }
    
    // Apply filters after loading
    applyFilters();

    
    // Add event listeners for toggle buttons
    var toggleButtons = document.querySelectorAll('.toggle-status');
    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            toggleCardStatus(this);
        });
    });
    
    // Add event listeners for print buttons
    var printButtons = document.querySelectorAll('.print-card');
    printButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            printCard(this.getAttribute('data-id'));
        });
    });
}

// Toggle card status
function toggleCardStatus(buttonElement) {
    var id = buttonElement.getAttribute('data-id');
    var currentStatus = buttonElement.getAttribute('data-status');
    var newStatus = currentStatus === 'open' ? 'closed' : 'open';
    
    console.log('Toggling status for card item:', id, 'from', currentStatus, 'to', newStatus);
    
    // Create form data
    var formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('status', newStatus);
    
    // Send the request
    fetch('/ready-card-items/' + id + '/toggle-status', {
        method: 'POST',
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        console.log('Status update response:', data);
        
        if (data.success) {
            // Update button text and data attributes
            buttonElement.textContent = newStatus === 'open' ? '{{ __('Close') }}' : '{{ __('Open') }}';
            buttonElement.setAttribute('data-status', newStatus);
            
            // Update row data attribute
            var row = buttonElement.closest('tr');
            row.setAttribute('data-status', newStatus);
            
            // Update status badge
            var statusCell = row.cells[3]; // The 4th cell (index 3) contains the status
            var statusBadge = newStatus === 'open' ? 
                '<span class="badge bg-success">{{ __('Open') }}</span>' : 
                '<span class="badge bg-secondary">{{ __('Closed') }}</span>';
            statusCell.innerHTML = statusBadge;
            
            // Show success message
            if (typeof toastr !== 'undefined') {
                toastr.success('{{ __('Card status updated successfully') }}');
            }
            
            // Reapply filters
            applyFilters();
        } else {
            console.error('Failed to update status');
            if (typeof toastr !== 'undefined') {
                toastr.error('{{ __('Failed to update card status') }}');
            }
        }
    })
    .catch(function(error) {
        console.error('Error updating status:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('{{ __('Failed to update card status') }}');
        }
    });
}

// Print a single card
function printCard(id) {
    window.open('/ready-card-items/' + id + '/print', '_blank');
}

// Apply filters to the card items table
function applyFilters() {
    var statusFilter = document.getElementById('status-filter').value;
    var searchTerm = document.getElementById('search-card-items').value.toLowerCase();
    
    var rows = document.querySelectorAll('#card-items-body tr');
    
    rows.forEach(function(row) {
        var status = row.getAttribute('data-status');
        var visible = true;
        
        // Apply status filter
        if (statusFilter !== 'all' && status !== statusFilter) {
            visible = false;
        }
        
        // Apply search filter
        if (searchTerm !== '') {
            var rowText = row.textContent.toLowerCase();
            if (rowText.indexOf(searchTerm) === -1) {
                visible = false;
            }
        }
        
        // Show or hide row
        row.style.display = visible ? '' : 'none';
    });
}
</script>
@endsection