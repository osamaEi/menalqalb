@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Locks & Ready Cards Management') }}</h4>
                    <button
                        class="btn btn-primary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddItem"
                        aria-controls="offcanvasAddItem">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Item') }}
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
                                    <h4 class="mb-1 me-2">{{ $totalItems }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Items') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded-3">
                                    <div class="ri-layout-grid-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Locks') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $lockItems }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Lock Items') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-danger rounded-3">
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
                                <p class="text-heading mb-1">{{ __('Read Cards') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $readCardItems }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Read Card Items') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <div class="ri-bank-card-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Active/Inactive') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $activeItems }}/{{ $inactiveItems }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Status Distribution') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-warning rounded-3">
                                    <div class="ri-toggle-line ri-26px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Items List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('All Items') }}
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
                            data-bs-target="#offcanvasAddItem"
                            aria-controls="offcanvasAddItem">
                            <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <form action="{{ route('locks_w_ready_cards.index') }}" method="GET" class="row gx-5 gap-5 gap-md-0 w-100">
                        <div class="col-md-4 item_type">
                            <select id="item-type-filter" name="type" class="form-select">
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="lock" {{ request('type') == 'lock' ? 'selected' : '' }}>{{ __('Locks') }}</option>
                                <option value="read_card" {{ request('type') == 'read_card' ? 'selected' : '' }}>{{ __('Read Cards') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4 item_status">
                            <select id="status-filter" name="status" class="form-select">
                                <option value="">{{ __('Select Status') }}</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
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
                <table class="datatables-items table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Photo') }}</th>
                            <th>{{ __('Name (EN)') }}</th>
                            <th>{{ __('Name (AR)') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Points') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <div class="avatar me-2">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name_en }}" class="rounded-3">
                                    @else
                                        <span class="avatar-initial rounded-3 bg-label-{{ $item->type == 'lock' ? 'danger' : 'info' }}">
                                            {{ strtoupper(substr($item->name_en, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('locks_w_ready_cards.show', $item->id) }}" class="text-body fw-medium">
                                    {{ $item->name_en }}
                                </a>
                            </td>
                            <td>{{ $item->name_ar }}</td>
                            <td>
                                <span class="badge bg-label-{{ $item->type == 'lock' ? 'danger' : 'info' }}">
                                    {{ $item->type == 'lock' ? __('Lock') : __('Read Card') }}
                                </span>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->points }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                        {{ $item->is_active ? 'checked' : '' }}
                                        onchange="window.location.href='{{ route('locks_w_ready_cards.toggle.status', $item->id) }}'">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('locks_w_ready_cards.show', $item->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('locks_w_ready_cards.edit', $item->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('locks_w_ready_cards.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{ __('Are you sure you want to delete this item?') }}')">
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
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas to add new item -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddItem" aria-labelledby="offcanvasAddItemLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddItemLabel" class="offcanvas-title">{{ __('Add Item') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100" data-simplebar>
        <form class="add-new-item pt-0" method="POST" action="{{ route('locks_w_ready_cards.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="d-inline-block position-relative">
                        <img src="{{ asset('assets/img/default-product.png') }}" alt="item" class="rounded-3 border" width="100" height="100" id="preview-image">
                        <label for="upload" class="btn btn-sm btn-icon btn-primary position-absolute bottom-0 end-0">
                            <i class="ri-upload-line"></i>
                        </label>
                        <input type="file" id="upload" name="photo" class="d-none" onchange="document.getElementById('preview-image').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                </div>
                @error('photo')
                    <div class="text-danger text-center small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" 
                        placeholder="{{ __('Digital Lock') }}" name="name_en" value="{{ old('name_en') }}" required />
                    <label for="name_en">{{ __('Name (English)') }}</label>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" 
                        placeholder="{{ __('قفل رقمي') }}" name="name_ar" value="{{ old('name_ar') }}" required />
                    <label for="name_ar">{{ __('Name (Arabic)') }}</label>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <textarea class="form-control @error('desc_en') is-invalid @enderror" id="desc_en" 
                        placeholder="{{ __('Description in English') }}" name="desc_en">{{ old('desc_en') }}</textarea>
                    <label for="desc_en">{{ __('Description (English)') }}</label>
                    @error('desc_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <textarea class="form-control @error('desc_ar') is-invalid @enderror" id="desc_ar" 
                        placeholder="{{ __('الوصف بالعربية') }}" name="desc_ar">{{ old('desc_ar') }}</textarea>
                    <label for="desc_ar">{{ __('Description (Arabic)') }}</label>
                    @error('desc_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">{{ __('Select Type') }}</option>
                        <option value="lock" {{ old('type') == 'lock' ? 'selected' : '' }}>{{ __('Lock') }}</option>
                        <option value="read_card" {{ old('type') == 'read_card' ? 'selected' : '' }}>{{ __('Read Card') }}</option>
                    </select>
                    <label for="type">{{ __('Type') }}</label>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" 
                        placeholder="0.00" name="price" value="{{ old('price') }}" required />
                    <label for="price">{{ __('Price') }}</label>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="number" class="form-control @error('points') is-invalid @enderror" id="points" 
                        placeholder="0" name="points" value="{{ old('points', 0) }}" required />
                    <label for="points">{{ __('Points') }}</label>
                    @error('points')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                        {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary me-sm-3 me-1">{{ __('Submit') }}</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('Cancel') }}</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // Initialize DataTable
        var dataTable = $('.datatables-items').DataTable({
            ordering: true,
            paging: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                search: '',
                searchPlaceholder: "{{ __('Search...') }}",
            }
        });
        
        // Filter by Item Type
        $('#item-type-filter').on('change', function() {
            var type = $(this).val();
            if (type) {
                window.location.href = "{{ route('locks_w_ready_cards.filter.type', '') }}/" + type;
            } else {
                window.location.href = "{{ route('locks_w_ready_cards.index') }}";
            }
        });
        
        // Filter by Status
        $('#status-filter').on('change', function() {
            var status = $(this).val();
            if (status) {
                window.location.href = "{{ route('locks_w_ready_cards.filter.status', '') }}/" + status;
            } else {
                window.location.href = "{{ route('locks_w_ready_cards.index') }}";
            }
        });
        
        // Show validation errors in offcanvas if any
        @if($errors->any())
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddItem'));
            offcanvas.show();
        @endif
    });
</script>
@endsection