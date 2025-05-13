@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Package Management') }}</h4>
                    <a href="{{ route('packages.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Package') }}
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
                                    <h4 class="mb-1 me-2">{{ $totalPackages }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Packages') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-gift-line ri-26px"></div>
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
                                    <h4 class="mb-1 me-1">{{ $activePackages }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Active Packages') }}</small>
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
                                    <h4 class="mb-1 me-1">{{ $inactivePackages }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Inactive Packages') }}</small>
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
        </div>
        
        <!-- Packages List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-3">{{ __('All Packages') }}</h5>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-packages table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Title (EN)') }}</th>
                            <th>{{ __('Title (AR)') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $package->id }}</td>
                            <td>{{ $package->title_en }}</td>
                            <td>{{ $package->title_ar }}</td>
                            <td>{{ $package->amount }}</td>
                            <td>${{ number_format($package->price, 2) }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                        {{ $package->is_active ? 'checked' : '' }}
                                        onchange="window.location.href='{{ route('packages.toggle.status', $package->id) }}'">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                  
                                        <a class="dropdown-item" href="{{ route('packages.edit', $package->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" 
                                                onclick="return confirm('{{ __('Are you sure you want to delete this package?') }}')">
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
                {{ $packages->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // Initialize DataTable
        var dataTable = $('.datatables-packages').DataTable({
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