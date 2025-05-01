@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Card Type Management') }}</h4>
                    <button
                        class="btn btn-primary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddCardType"
                        aria-controls="offcanvasAddCardType">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Card Type') }}
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
                                    <h4 class="mb-1 me-2">{{ $totalCardTypes }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Card Types') }}</small>
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
                                <p class="text-heading mb-1">{{ __('Active') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $activeCardTypes }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Active Card Types') }}</small>
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
                                    <h4 class="mb-1 me-1">{{ $inactiveCardTypes }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Inactive Card Types') }}</small>
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
                                <p class="text-heading mb-1">{{ __('Categories') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ count($typeOptions) }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Different Card Categories') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-info rounded-3">
                                    <div class="ri-bar-chart-horizontal-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
        
        <!-- Card Types List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('All Card Types') }}
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
                            data-bs-target="#offcanvasAddCardType"
                            aria-controls="offcanvasAddCardType">
                            <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <div class="col-md-4 card_type">
                        <select id="card-type-filter" class="form-select">
                            <option value="">{{ __('Select Card Type') }}</option>
                            @foreach($typeOptions as $key => $label)
                                <option value="{{ $key }}" {{ request()->segment(3) == 'type' && request()->segment(4) == $key ? 'selected' : '' }}>
                                    {{ __($label) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 card_status">
                        <select id="status-filter" class="form-select">
                            <option value="">{{ __('Select Status') }}</option>
                            <option value="active" {{ request()->segment(3) == 'status' && request()->segment(4) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ request()->segment(3) == 'status' && request()->segment(4) == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search-input" placeholder="{{ __('Search...') }}">
                            <button class="btn btn-outline-primary" type="button" id="search-button">
                                <i class="ri-search-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-card-types table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Icon') }}</th>
                            <th>{{ __('Photo') }}</th>
                            <th>{{ __('Name (EN)') }}</th>
                            <th>{{ __('Name (AR)') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cardTypes as $cardType)
                        <tr>
                            <td>{{ $cardType->id }}</td>
                            <td>
                                <div class="avatar me-2">
                                    <span class="avatar-initial bg-label-primary rounded-3">
                                        <i class="{{ $cardType->icon }} ri-lg"></i>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="avatar me-2">
                                    @if($cardType->photo)
                                        <img src="{{ asset('storage/' . $cardType->photo) }}" alt="{{ $cardType->name_en }}" class="rounded-3">
                                    @else
                                        <span class="avatar-initial rounded-3 bg-label-info">
                                            {{ strtoupper(substr($cardType->name_en, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('card_types.show', $cardType->id) }}" class="text-body fw-medium">
                                    {{ $cardType->name_en }}
                                </a>
                            </td>
                            <td class="text-end">{{ $cardType->name_ar }}</td>
                            <td>
                                <a href="{{ route('card_types.filter.type', $cardType->type) }}" class="badge bg-label-info">
                                    {{ __($typeOptions[$cardType->type] ?? $cardType->type) }}
                                </a>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                        {{ $cardType->is_active ? 'checked' : '' }}
                                        onchange="window.location.href='{{ route('card_types.toggle.status', $cardType->id) }}'">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('card_types.show', $cardType->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('card_types.edit', $cardType->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('card_types.destroy', $cardType->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{ __('Are you sure you want to delete this card type?') }}')">
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
                {{ $cardTypes->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas to add new card type -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCardType" aria-labelledby="offcanvasAddCardTypeLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddCardTypeLabel" class="offcanvas-title">{{ __('Add Card Type') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100" data-simplebar>
        <form class="add-new-card-type pt-0" method="POST" action="{{ route('card_types.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Card Type Icon Selection -->
            <div class="mb-4">
                <label class="form-label">{{ __('Select Icon') }}</label>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0">{{ __('Selected Icon') }}</label>
                            <span class="selected-icon-display d-flex align-items-center">
                                <i class="ri-heart-line ri-lg me-1" id="selected-icon-preview"></i>
                                <span id="selected-icon-name">ri-heart-line</span>
                            </span>
                        </div>
                        <input type="hidden" name="icon" id="selected-icon" value="ri-heart-line" required>
                        
                        <div class="icon-grid">
                            <div class="row g-2" style="max-height: 200px; overflow-y: auto;">
                                @foreach($iconOptions as $icon => $label)
                                <div class="col-2 text-center">
                                    <div class="card icon-card cursor-pointer p-2 text-center mb-0" data-icon="{{ $icon }}">
                                        <i class="{{ $icon }} ri-lg"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card Type Details -->
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" 
                        name="name_en" value="{{ old('name_en') }}" required placeholder="{{ __('English Name') }}">
                    <label for="name_en">{{ __('English Name') }}</label>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" 
                        name="name_ar" value="{{ old('name_ar') }}" required placeholder="{{ __('Arabic Name') }}" dir="rtl">
                    <label for="name_ar">{{ __('Arabic Name') }}</label>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">{{ __('Select Type') }}</option>
                        @foreach($typeOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                {{ __($label) }}
                            </option>
                        @endforeach
                    </select>
                    <label for="type">{{ __('Card Type') }}</label>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="photo" class="form-label">{{ __('Photo (Optional)') }}</label>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <img src="{{ asset('assets/img/default-card-type.png') }}" alt="preview" 
                                class="rounded-3 border" width="100" height="100" id="preview-photo">
                        </div>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                            id="photo" name="photo" accept="image/*">
                        <small class="form-text">{{ __('Recommended size: 400x400px') }}</small>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">{{ __('Submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('Cancel') }}</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function() {
        // Initialize DataTable
        var dataTable = $('.datatables-card-types').DataTable({
            ordering: true,
            paging: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                search: '',
                searchPlaceholder: "{{ __('Search...') }}",
            }
        });
        
        // Filter by Type
        $('#card-type-filter').on('change', function() {
            var type = $(this).val();
            if (type) {
                window.location.href = "{{ route('card_types.filter.type', '') }}/" + type;
            } else {
                window.location.href = "{{ route('card_types.index') }}";
            }
        });
        
        // Filter by Status
        $('#status-filter').on('change', function() {
            var status = $(this).val();
            if (status) {
                window.location.href = "{{ route('card_types.filter.status', '') }}/" + status;
            } else {
                window.location.href = "{{ route('card_types.index') }}";
            }
        });
        
        // Icon Selection
        $('.icon-card').on('click', function() {
            var selectedIcon = $(this).data('icon');
            $('#selected-icon').val(selectedIcon);
            $('#selected-icon-preview').attr('class', selectedIcon + ' ri-lg me-1');
            $('#selected-icon-name').text(selectedIcon);
            
            // Highlight selected icon card
            $('.icon-card').removeClass('bg-light border-primary');
            $(this).addClass('bg-light border-primary');
        });
        
        // Photo Preview
        $('#photo').on('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-photo').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
        
        // Create chart
        var ctx = document.getElementById('cardTypeChart').getContext('2d');
        var cardTypeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($typeOptions as $key => $label)
                        '{{ __($label) }}',
                    @endforeach
                ],
                datasets: [{
                    label: '{{ __("Number of Card Types") }}',
                    data: [
                        @foreach($typeOptions as $key => $label)
                            {{ $typeStats[$key] ?? 0 }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
        
        // Search functionality
        $('#search-button').on('click', function() {
            dataTable.search($('#search-input').val()).draw();
        });
        
        $('#search-input').on('keyup', function(e) {
            if (e.key === 'Enter') {
                dataTable.search(this.value).draw();
            }
        });
        
        // Show validation errors in offcanvas if any
        @if($errors->any())
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCardType'));
            offcanvas.show();
        @endif
    });
</script>
@endsection