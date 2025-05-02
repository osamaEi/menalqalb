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

<script>
$(function() {
    // Initialize DataTable
    var dataTable = $('.datatables-ready-cards').DataTable({
        ordering: true,
        paging: false,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: {
            search: '',
            searchPlaceholder: "{{ __('Search...') }}",
        }
    });
    
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
});
</script>
@endsection