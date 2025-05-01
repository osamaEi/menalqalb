@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">{{ __('Category Management') }}</h4>
                    <button
                        class="btn btn-primary"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAddCategory"
                        aria-controls="offcanvasAddCategory">
                        <i class="ri-add-line me-1"></i> {{ __('Add New Category') }}
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
                                    <h4 class="mb-1 me-2">{{ $totalCategories }}</h4>
                                </div>
                                <small class="mb-0">{{ __('All Categories') }}</small>
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
                                <p class="text-heading mb-1">{{ __('Main') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $mainCategories }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Main Categories') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-danger rounded-3">
                                    <div class="ri-folder-line ri-26px"></div>
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
                                <p class="text-heading mb-1">{{ __('Sub') }}</p>
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-1 me-1">{{ $subcategories }}</h4>
                                </div>
                                <small class="mb-0">{{ __('Subcategories') }}</small>
                            </div>
                            <div class="avatar">
                                <div class="avatar-initial bg-label-success rounded-3">
                                    <div class="ri-folder-5-line ri-26px"></div>
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
                                    <h4 class="mb-1 me-1">{{ $activeCategories }}/{{ $inactiveCategories }}</h4>
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
        
        <!-- Categories List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="card-title mb-3 mb-md-0">
                        {{ isset($filter) ? $filter : __('All Categories') }}
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
                            data-bs-target="#offcanvasAddCategory"
                            aria-controls="offcanvasAddCategory">
                            <i class="ri-add-line"></i>
                        </button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                    <div class="col-md-4 category_type">
                        <select id="category-type-filter" class="form-select">
                            <option value="">{{ __('Select Type') }}</option>
                            <option value="main" {{ request()->segment(3) == 'type' && request()->segment(4) == 'main' ? 'selected' : '' }}>{{ __('Main Categories') }}</option>
                            <option value="sub" {{ request()->segment(3) == 'type' && request()->segment(4) == 'sub' ? 'selected' : '' }}>{{ __('Subcategories') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 parent_category">
                        <select id="parent-filter" class="form-select">
                            <option value="">{{ __('Select Parent Category') }}</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ request()->segment(3) == 'parent' && request()->segment(4) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 category_status">
                        <select id="status-filter" class="form-select">
                            <option value="">{{ __('Select Status') }}</option>
                            <option value="active" {{ request()->segment(3) == 'status' && request()->segment(4) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ request()->segment(3) == 'status' && request()->segment(4) == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-categories table">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Name (EN)') }}</th>
                            <th>{{ __('Name (AR)') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Parent') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <div class="avatar me-2">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name_en }}" class="rounded-3">
                                    @else
                                        <span class="avatar-initial rounded-3 bg-label-{{ $category->is_main ? 'danger' : 'info' }}">
                                            {{ strtoupper(substr($category->name_en, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('categories.show', $category->id) }}" class="text-body fw-medium">
                                    {{ $category->name_en }}
                                </a>
                            </td>
                            <td class="text-end">{{ $category->name_ar }}</td>
                            <td>
                                <span class="badge bg-label-{{ $category->is_main ? 'danger' : 'info' }}">
                                    {{ $category->is_main ? __('Main') : __('Sub') }}
                                </span>
                            </td>
                            <td>
                                @if($category->parent)
                                    <a href="{{ route('categories.filter.parent', $category->parent_id) }}">
                                        {{ $category->parent->name }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('None') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                        {{ $category->is_active ? 'checked' : '' }}
                                        onchange="window.location.href='{{ route('categories.toggle.status', $category->id) }}'">
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                        <i class="ri-more-fill"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('categories.show', $category->id) }}">
                                            <i class="ri-eye-line text-primary me-2"></i>{{ __('View') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('categories.edit', $category->id) }}">
                                            <i class="ri-pencil-line text-primary me-2"></i>{{ __('Edit') }}
                                        </a>
                                        @if($category->is_main && $subcategories > 0)
                                            <a class="dropdown-item" href="{{ route('categories.filter.parent', $category->id) }}">
                                                <i class="ri-folder-open-line text-info me-2"></i>{{ __('View Subcategories') }}
                                            </a>
                                        @endif
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas to add new category -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCategory" aria-labelledby="offcanvasAddCategoryLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddCategoryLabel" class="offcanvas-title">{{ __('Add Category') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100" data-simplebar>
        <form class="add-new-category pt-0" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <div class="d-inline-block position-relative">
                        <img src="{{ asset('assets/img/default-category.png') }}" alt="category" class="rounded-3 border" width="100" height="100" id="preview-image">
                        <label for="upload" class="btn btn-sm btn-icon btn-primary position-absolute bottom-0 end-0">
                            <i class="ri-upload-line"></i>
                        </label>
                        <input type="file" id="upload" name="image" class="d-none" onchange="document.getElementById('preview-image').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                </div>
                @error('image')
                    <div class="text-danger text-center small">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" 
                        placeholder="{{ __('Electronics') }}" name="name_en" value="{{ old('name_en') }}" required />
                    <label for="name_en">{{ __('Name (English)') }}</label>
                    @error('name_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" 
                        placeholder="{{ __('إلكترونيات') }}" name="name_ar" value="{{ old('name_ar') }}" required />
                    <label for="name_ar">{{ __('Name (Arabic)') }}</label>
                    @error('name_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="is_main" name="is_main" value="1" 
                        {{ old('is_main') ? 'checked' : '' }} onchange="toggleParentSelect(this.checked)">
                    <label class="form-check-label" for="is_main">{{ __('Main Category') }}</label>
                </div>
                <small class="text-muted">{{ __('Main categories appear at the top level of navigation') }}</small>
            </div>
            
            <div class="mb-3" id="parent-category-container">
                <div class="form-floating form-floating-outline">
                    <select id="parent_id" name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">{{ __('Select Parent Category') }}</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <label for="parent_id">{{ __('Parent Category') }}</label>
                    @error('parent_id')
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
        var dataTable = $('.datatables-categories').DataTable({
            ordering: true,
            paging: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                search: '',
                searchPlaceholder: "{{ __('Search...') }}",
            }
        });
        
        // Filter by Category Type
        $('#category-type-filter').on('change', function() {
            var type = $(this).val();
            if (type) {
                window.location.href = "{{ route('categories.filter.type', '') }}/" + type;
            } else {
                window.location.href = "{{ route('categories.index') }}";
            }
        });
        
        // Filter by Status
        $('#status-filter').on('change', function() {
            var status = $(this).val();
            if (status) {
                window.location.href = "{{ route('categories.filter.status', '') }}/" + status;
            } else {
                window.location.href = "{{ route('categories.index') }}";
            }
        });

        // Filter by Parent Category
        $('#parent-filter').on('change', function() {
            var parentId = $(this).val();
            if (parentId) {
                window.location.href = "{{ route('categories.filter.parent', '') }}/" + parentId;
            } else {
                window.location.href = "{{ route('categories.index') }}";
            }
        });
        
        // Initialize main category toggle
        toggleParentSelect(document.getElementById('is_main').checked);
        
        // Show validation errors in offcanvas if any
        @if($errors->any())
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCategory'));
            offcanvas.show();
        @endif
    });
    
    // Function to toggle parent category select based on main category status
    function toggleParentSelect(isMain) {
        var parentContainer = document.getElementById('parent-category-container');
        var parentSelect = document.getElementById('parent_id');
        
        if (isMain) {
            parentContainer.style.display = 'none';
            parentSelect.value = '';
            parentSelect.required = false;
        } else {
            parentContainer.style.display = 'block';
            parentSelect.required = true;
        }
    }
</script>
@endsection