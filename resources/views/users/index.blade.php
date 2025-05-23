@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('User Management') }}</h4>
                    <button
                        class="btn btn-primary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddUser"
                        aria-controls="offcanvasAddUser">
                        <i class="ri-user-add-line me-1"></i> {{ __('Add New User') }}
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
                                <p class="text-heading mb-1">{{ __('Session') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-2">{{ $totalUsers }}</h4>
                                    <p class="text-success mb-1">(+29%)</p>
                                </div>
                                <small class="mb-0">{{ __('Total Users') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-group-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Paid Users') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $privilegedUsers }}</h4>
                                    <p class="text-success mb-1">(+18%)</p>
                                </div>
                                <small class="mb-0">{{ __('Last week analytics') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-danger rounded-3">
                                    <div class="ri-user-add-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Active Users') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $activeUsers }}</h4>
                                    <p class="text-danger mb-1">(-14%)</p>
                                </div>
                                <small class="mb-0">{{ __('Last week analytics') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <div class="ri-user-follow-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Pending Users') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $inactiveUsers }}</h4>
                                    <p class="text-success mb-1">(+42%)</p>
                                </div>
                                <small class="mb-0">{{ __('Last week analytics') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded-3">
                                    <div class="ri-user-search-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('All Users') }}
                    </h5>
                    
                    <div class="d-flex align-items-center">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show me-3 mb-0 py-2" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <button
                            class="btn btn-primary btn-sm d-block d-md-none"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasAddUser"
                            aria-controls="offcanvasAddUser">
                            <i class="ri-user-add-line"></i>
                        </button>
                    </div>
                </div>
                
                <form action="{{ route('users.index') }}" method="GET">
                    <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                        <div class="col-md-3 user_role">
                            <select id="user-type-filter" name="user_type" class="form-select">
                                <option value="">{{ __('Select Role') }}</option>
                                <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                                <option value="privileged_user" {{ request('user_type') == 'privileged_user' ? 'selected' : '' }}>{{ __('Privileged User') }}</option>
                                <option value="regular_user" {{ request('user_type') == 'regular_user' ? 'selected' : '' }}>{{ __('Regular User') }}</option>
                                <option value="designer" {{ request('user_type') == 'designer' ? 'selected' : '' }}>{{ __('Designer') }}</option>
                                <option value="sales_point" {{ request('user_type') == 'sales_point' ? 'selected' : '' }}>{{ __('Sales Point') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 user_plan">
                            <select id="country-filter" name="country_id" class="form-select">
                                <option value="">{{ __('Select Country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name ?? $country->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 user_status">
                            <select id="status-filter" name="status" class="form-select">
                                <option value="">{{ __('Select Status') }}</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>{{ __('Blocked') }}</option>
                                <option value="deleted" {{ request('status') == 'deleted' ? 'selected' : '' }}>{{ __('Deleted') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">{{ __('Apply Filters') }}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">{{ __('Reset') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th>{{ __('Country') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Verification') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle bg-label-{{ 
                                                $user->user_type === 'admin' ? 'danger' : 
                                                ($user->user_type === 'designer' ? 'info' : 
                                                ($user->user_type === 'sales_point' ? 'warning' : 'primary')) 
                                            }}">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('users.show', $user->id) }}" class="text-body text-truncate">
                                            <span class="fw-medium">{{ $user->name }}</span>
                                        </a>
                                        <small class="text-muted">{{ $user->whatsapp ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="text-truncate d-flex align-items-center">
                                    <span class="badge badge-center rounded-pill bg-label-{{ 
                                        $user->user_type === 'admin' ? 'danger' : 
                                        ($user->user_type === 'designer' ? 'info' : 
                                        ($user->user_type === 'sales_point' ? 'warning' : 'primary')) 
                                    }} w-px-30 h-px-30 me-2">
                                        <i class="ri-user-{{ 
                                            $user->user_type === 'admin' ? 'settings' : 
                                            ($user->user_type === 'designer' ? 'star' : 
                                            ($user->user_type === 'sales_point' ? 'heart' : 'follow')) 
                                        }}-line ri-sm"></i>
                                    </span>
                                    {{ __(str_replace('_', ' ', ucfirst($user->user_type))) }}
                                </span>
                            </td>
                            <td>
                                {{ $user->country->name ?? $user->country->name_en ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="badge bg-label-{{ 
                                    $user->status === 'active' ? 'success' : 
                                    ($user->status === 'inactive' ? 'secondary' : 
                                    ($user->status === 'blocked' ? 'warning' : 'danger')) 
                                }}">{{ __(ucfirst($user->status)) }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    @if($user->email_verified)
                                        <span class="badge bg-label-success mb-1">{{ __('Email') }} ✓</span>
                                    @else
                                        <span class="badge bg-label-secondary mb-1">{{ __('Email') }} ✗</span>
                                    @endif
                                    
                                    @if($user->whatsapp_verified)
                                        <span class="badge bg-label-success">{{ __('WhatsApp') }} ✓</span>
                                    @else
                                        <span class="badge bg-label-secondary">{{ __('WhatsApp') }} ✗</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('users.show', $user->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        @if($user->deleted_at)
                                            <a class="dropdown-item" href="{{ route('users.restore', $user->id) }}">
                                                <i class="ri-restart-line text-success me-2"></i>{{ __('Restore') }}
                                            </a>
                                        @else
                                            @if($user->status === 'active')
                                                <a class="dropdown-item" href="{{ route('users.toggle.status', $user->id) }}">
                                                    <i class="ri-user-unfollow-line text-secondary me-2"></i>{{ __('Deactivate') }}
                                                </a>
                                            @else
                                                <a class="dropdown-item" href="{{ route('users.toggle.status', $user->id) }}">
                                                    <i class="ri-user-follow-line text-success me-2"></i>{{ __('Activate') }}
                                                </a>
                                            @endif
                                            @if($user->status !== 'blocked')
                                                <a class="dropdown-item" href="{{ route('users.block', $user->id) }}">
                                                    <i class="ri-shield-user-line text-warning me-2"></i>{{ __('Block') }}
                                                </a>
                                            @endif
                                            <a class="dropdown-item delete-record" href="javascript:void(0);" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $user->id }}">
                                                <i class="ri-delete-bin-line text-danger me-2"></i>{{ __('Delete') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3 mb-5">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas to add new user -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">{{ __('Add User') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100" data-simplebar>
        <form class="add-new-user pt-0" method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="add-user-fullname" 
                        placeholder="{{ __('John Doe') }}" name="name" value="{{ old('name') }}" required />
                    <label for="add-user-fullname">{{ __('Full Name') }}</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="email" id="add-user-email" class="form-control @error('email') is-invalid @enderror" 
                        placeholder="{{ __('john.doe@example.com') }}" name="email" value="{{ old('email') }}" required />
                    <label for="add-user-email">{{ __('Email') }}</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="password" id="add-user-password" class="form-control @error('password') is-invalid @enderror" 
                        placeholder="{{ __('Password') }}" name="password" required />
                    <label for="add-user-password">{{ __('Password') }}</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="password" id="add-user-password-confirmation" class="form-control" 
                        placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required />
                    <label for="add-user-password-confirmation">{{ __('Confirm Password') }}</label>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="add-user-whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" 
                        placeholder="+1 (609) 988-44-11" name="whatsapp" value="{{ old('whatsapp') }}" />
                    <label for="add-user-whatsapp">{{ __('WhatsApp') }}</label>
                    @error('whatsapp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="country_id" name="country_id" class="select2 form-select @error('country_id') is-invalid @enderror" required>
                        <option value="">{{ __('Select') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name ?? $country->name_en }}
                            </option>
                        @endforeach
                    </select>
                    <label for="country_id">{{ __('Country') }}</label>
                    @error('country_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="user_type" name="user_type" class="form-select @error('user_type') is-invalid @enderror" required>
                        <option value="">{{ __('Select Role') }}</option>
                        <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                        <option value="privileged_user" {{ old('user_type') == 'privileged_user' ? 'selected' : '' }}>{{ __('Privileged User') }}</option>
                        <option value="regular_user" {{ old('user_type') == 'regular_user' ? 'selected' : '' }}>{{ __('Regular User') }}</option>
                        <option value="designer" {{ old('user_type') == 'designer' ? 'selected' : '' }}>{{ __('Designer') }}</option>
                        <option value="sales_point" {{ old('user_type') == 'sales_point' ? 'selected' : '' }}>{{ __('Sales Point') }}</option>
                    </select>
                    <label for="user_type">{{ __('User Role') }}</label>
                    @error('user_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Company Name Field (initially hidden) -->
            <div class="mb-3" id="company_name_container" style="display: {{ old('user_type') == 'sales_point' ? 'block' : 'none' }};">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="company_name" name="company_name" 
                        class="form-control @error('company_name') is-invalid @enderror" 
                        placeholder="{{ __('Company Name') }}" value="{{ old('company_name') }}"
                        {{ old('user_type') == 'sales_point' ? 'required' : '' }} />
                    <label for="company_name">{{ __('Company Name') }}</label>
                    @error('company_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>{{ __('Blocked') }}</option>
                    </select>
                    <label for="status">{{ __('Status') }}</label>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }}>
                    <label class="form-check-label" for="email_verified">{{ __('Email Verified') }}</label>
                </div>
            </div>
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="whatsapp_verified" name="whatsapp_verified" value="1" {{ old('whatsapp_verified') ? 'checked' : '' }}>
                    <label class="form-check-label" for="whatsapp_verified">{{ __('WhatsApp Verified') }}</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{ __('Submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('Cancel') }}</button>
        </form>
    </div>
</div>

<!-- JavaScript to handle dynamic company name field -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get references to the elements
    const userTypeSelect = document.getElementById('user_type');
    const companyNameContainer = document.getElementById('company_name_container');
    const companyNameInput = document.getElementById('company_name');
    
    // Add event listener to the user_type select element
    userTypeSelect.addEventListener('change', function() {
        if (this.value === 'sales_point') {
            // Show the company name field and make it required
            companyNameContainer.style.display = 'block';
            companyNameInput.setAttribute('required', 'required');
        } else {
            // Hide the company name field and make it not required
            companyNameContainer.style.display = 'none';
            companyNameInput.removeAttribute('required');
        }
    });
});
</script>

<script>
$(function() {
    // Initialize DataTable with proper configuration
    var dataTable = $('.datatables-users').DataTable({
        ordering: true,
        paging: false,
        searching: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: {
            search: '',
            searchPlaceholder: jsLang('Search...')
        }
    });
    
    // Function to extract and preserve current filter parameters from URL
    function getCurrentParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const params = {};
        
        // Check for existing filter parameters
        for(const [key, value] of urlParams.entries()) {
            params[key] = value;
        }
        
        return params;
    }
    
    // Function to build URL with filters
    function buildFilterUrl(filterType, filterValue) {
        // Base routes for each filter type
        const routes = {
            'user_type': routeUsersFilterType,  // Should be something like '/users/type/'
            'status': routeUsersFilterStatus,   // Should be something like '/users/status/'
            'country_id': routeUsersFilterCountry  // Should be something like '/users/country/'
        };
        
        // If we have a value and a proper route, build the URL with the segment
        if (filterValue && routes[filterType]) {
            return routes[filterType] + '/' + filterValue;
        } else {
            // Return to index if no filter is selected
            return routeUsers;
        }
    }
    
    // User Type Filter
    $('#user-type-filter').on('change', function() {
        const userType = $(this).val();
        window.location.href = buildFilterUrl('user_type', userType);
    });
    
    // Status Filter
    $('#status-filter').on('change', function() {
        const status = $(this).val();
        window.location.href = buildFilterUrl('status', status);
    });
    
    // Country Filter
    $('#country-filter').on('change', function() {
        const countryId = $(this).val();
        window.location.href = buildFilterUrl('country_id', countryId);
    });
    
    // Handle reset all filters
    $('.reset-filters').on('click', function(e) {
        e.preventDefault();
        window.location.href = routeUsers;
    });
    
    // Set filters from URL parameters on page load
    function setFiltersFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Set user type filter if in URL
        if (urlParams.has('user_type')) {
            $('#user-type-filter').val(urlParams.get('user_type'));
        }
        
        // Set status filter if in URL
        if (urlParams.has('status')) {
            $('#status-filter').val(urlParams.get('status'));
        }
        
        // Set country filter if in URL
        if (urlParams.has('country_id')) {
            $('#country-filter').val(urlParams.get('country_id'));
        }
    }
    
    // Initialize filters on page load
    setFiltersFromUrl();
    
    // Initialize select2 for dropdown filters if available
    if (typeof $.fn.select2 !== 'undefined') {
        $('.select2').select2({
            placeholder: jsLang('Select an option'),
            allowClear: true
        });
    }
    
    // Delete confirmation
    $('.delete-record').on('click', function() {
        var id = $(this).data('id');
        $('#deleteForm').attr('action', routeUsersDelete.replace(':id', id));
    });
    
    // Initialize select2 for offcanvas form
    if (typeof $.fn.select2 !== 'undefined') {
        $('#offcanvasAddUser .select2').select2({
            dropdownParent: $('#offcanvasAddUser'),
            placeholder: jsLang('Select an option'),
            allowClear: true
        });
    }
    
    // Show validation errors in offcanvas if any
    if ($('#offcanvasAddUser').data('has-errors')) {
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddUser'));
        offcanvas.show();
    }
    
    // Auto-hide alert messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
});
</script>
@endsection