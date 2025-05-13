@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Request Management') }}</h4>
                    <a href="{{ route('requests.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Request') }}
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
                                    <h4 class="mb-1 me-2">{{ $totalRequests }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Requests') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-file-list-3-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Pending') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $pendingRequests }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Awaiting Review') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded-3">
                                    <div class="ri-time-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Approved') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $approvedRequests }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Ready to Process') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <div class="ri-checkbox-circle-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Completed') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $completedRequests }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Fulfilled Orders') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <div class="ri-check-double-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Requests List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('All Requests') }}
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
                
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <form action="{{ route('requests.index') }}" method="GET" class="row gx-5 gap-5 gap-md-0 w-100">
                        <div class="col-md-4 request_status">
                            <select id="status-filter" name="status" class="form-select">
                                <option value="">{{ __('Select Status') }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('Processing') }}</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 item_filter">
                            <select id="item-filter" name="item_id" class="form-select">
                                <option value="">{{ __('Select Item') }}</option>
                                @foreach(\App\Models\LocksWReadyCard::all() as $item)
                                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-filter-line me-1"></i> {{ __('Apply Filters') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-requests table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Item') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Contact') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        @if($request->locksWReadyCard->photo)
                                            <img src="{{ asset('storage/' . $request->locksWReadyCard->photo) }}" 
                                                alt="{{ $request->locksWReadyCard->name }}" class="rounded-3">
                                        @else
                                            <span class="avatar-initial rounded-3 bg-label-primary">
                                                {{ strtoupper(substr($request->locksWReadyCard->name_en, 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="fw-medium">{{ $request->locksWReadyCard->name }}</span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $request->locksWReadyCard->type == 'lock' ? __('Lock') : __('Read Card') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $request->name }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($request->address, 30) }}</small>
                            </td>
                            <td>
                                <a href="mailto:{{ $request->email }}">{{ $request->email }}</a>
                                <br>
                                <small>{{ $request->phone }}</small>
                            </td>
                            <td>{{ $request->quantity }}</td>
                            <td>
                                <strong>${{ number_format($request->total_price, 2) }}</strong>
                                <br>
                                <small class="text-muted">{{ $request->total_points }} {{ __('points') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-label-{{ $request->status_color }}">
                                    {{ $request->status_label }}
                                </span>
                            </td>
                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('requests.show', $request->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('requests.edit', $request->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        
                                        @if($request->isPending())
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('requests.approve', $request->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="ri-check-line text-success me-2"></i>{{ __('Approve') }}
                                                </button>
                                            </form>
                                            <form action="{{ route('requests.reject', $request->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="ri-close-line text-danger me-2"></i>{{ __('Reject') }}
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($request->isApproved())
                                            <form action="{{ route('requests.complete', $request->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="ri-check-double-line text-success me-2"></i>{{ __('Mark Complete') }}
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('requests.destroy', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" 
                                                onclick="return confirm('{{ __('Are you sure you want to delete this request?') }}')">
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
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // Initialize DataTable
        var dataTable = $('.datatables-requests').DataTable({
            ordering: true,
            paging: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                search: '',
                searchPlaceholder: "{{ __('Search...') }}",
            }
        });
    });
</script>
@endsection