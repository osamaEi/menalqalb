@extends('admin.index')

@section('styles')
<style>
.icon-grid {
    max-height: 200px;
    overflow-y: auto;
    padding: 10px 5px;
    border: 1px solid #eee;
    border-radius: 5px;
}

.icon-card {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.icon-card:hover {
    background-color: rgba(105, 108, 255, 0.08);
    border-color: rgba(105, 108, 255, 0.5);
}

.icon-card.selected {
    background-color: rgba(105, 108, 255, 0.15);
    border-color: rgba(105, 108, 255, 0.7);
}

.selected-icon-display {
    padding: 5px 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    border: 1px solid #e9ecef;
    font-size: 0.9rem;
}

/* Improve scrollbar appearance for icon grid */
.icon-grid::-webkit-scrollbar {
    width: 6px;
}

.icon-grid::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 3px;
}

.icon-grid::-webkit-scrollbar-thumb {
    background-color: #adb5bd;
    border-radius: 3px;
}

.icon-grid::-webkit-scrollbar-thumb:hover {
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
                
                <form action="{{ route('card_types.index') }}" method="GET">
                    <div class="d-flex justify-content-between align-items-center row gx-5 pt-4 gap-5 gap-md-0">
                        <div class="col-md-3 card_type">
                            <select id="card-type-filter" name="type" class="form-select">
                                <option value="">{{ __('Select Card Type') }}</option>
                                @foreach($typeOptions as $key => $label)
                                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                        {{ __($label) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 card_status">
                            <select id="status-filter" name="status" class="form-select">
                                <option value="">{{ __('Select Status') }}</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-input" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}">
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">{{ __('apply_filters') }}</button>
                            <a href="{{ route('card_types.index') }}" class="btn btn-outline-secondary ms-2">{{ __('reset_filters') }}</a>
                        </div>
                    </div>
                </form>
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
                {{ $cardTypes->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas to add new card type with fixed icon selection -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCardType" aria-labelledby="offcanvasAddCardTypeLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddCardTypeLabel" class="offcanvas-title">{{ __('Add Card Type') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" data-simplebar>
        <form class="add-new-card-type pt-0" method="POST" action="{{ route('card_types.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Card Type Icon Selection -->
            <div class="mb-4">
                <label class="form-label d-block">{{ __('Select Icon') }}</label>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label mb-0">{{ __('Selected Icon') }}</label>
                            <div class="selected-icon-display d-flex align-items-center">
                                <i class="{{ old('icon', 'ri-heart-line') }} ri-lg me-1" id="selected-icon-preview"></i>
                                <span id="selected-icon-name">{{ old('icon', 'ri-heart-line') }}</span>
                            </div>
                        </div>
                        <input type="hidden" name="icon" id="selected-icon" value="{{ old('icon', 'ri-heart-line') }}" required>
                        
                        <div class="icon-grid mb-3">
                            <div class="row g-2">
                                @foreach($iconOptions as $icon => $label)
                                <div class="col-3 text-center mb-2">
                                    <div class="icon-card cursor-pointer d-flex align-items-center justify-content-center" 
                                         data-icon="{{ $icon }}" 
                                         onclick="selectIcon('{{ $icon }}')">
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
            
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </form>
    </div>
</div>

<!-- Add this inline script to directly handle icon selection -->
<script>
    function selectIcon(iconClass) {
        // Update hidden input
        document.getElementById('selected-icon').value = iconClass;
        
        // Update preview
        document.getElementById('selected-icon-preview').className = iconClass + ' ri-lg me-1';
        document.getElementById('selected-icon-name').textContent = iconClass;
        
        // Update visual selection
        document.querySelectorAll('.icon-card').forEach(function(el) {
            el.classList.remove('selected', 'bg-light', 'border-primary');
        });
        
        // Find the clicked element and add selected class
        document.querySelector('.icon-card[data-icon="' + iconClass + '"]').classList.add('selected', 'bg-light', 'border-primary');
    }
    
    // Initialize selected icon when offcanvas opens
    document.addEventListener('DOMContentLoaded', function() {
        var offcanvasEl = document.getElementById('offcanvasAddCardType');
        if (offcanvasEl) {
            offcanvasEl.addEventListener('shown.bs.offcanvas', function() {
                setTimeout(function() {
                    var currentIcon = document.getElementById('selected-icon').value;
                    if (currentIcon) {
                        selectIcon(currentIcon);
                    } else {
                        // Default to first icon if nothing selected
                        var firstIcon = document.querySelector('.icon-card');
                        if (firstIcon) {
                            selectIcon(firstIcon.getAttribute('data-icon'));
                        }
                    }
                }, 300);
            });
        }
        
        // Initialize if there are validation errors
        @if($errors->any())
        setTimeout(function() {
            var currentIcon = document.getElementById('selected-icon').value;
            if (currentIcon) {
                selectIcon(currentIcon);
            }
        }, 500);
        @endif
    });
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function() {
  // Standalone JavaScript function to fix the icon selection
function fixIconSelection() {
    console.log("Initializing icon selection functionality");
    
    // Direct binding to each icon card
    $('.icon-card').off('click').on('click', function() {
        console.log("Icon clicked:", $(this).data('icon'));
        var selectedIcon = $(this).data('icon');
        
        // Update hidden input
        $('#selected-icon').val(selectedIcon);
        
        // Update preview
        $('#selected-icon-preview').attr('class', selectedIcon + ' ri-lg me-1');
        $('#selected-icon-name').text(selectedIcon);
        
        // Update visual selection
        $('.icon-card').removeClass('selected bg-light border-primary');
        $(this).addClass('selected bg-light border-primary');
        
        // Debug log
        console.log("Icon selection updated to:", selectedIcon);
    });
    
    // Initialize the selected icon (if coming back after validation error)
    var currentSelectedIcon = $('#selected-icon').val();
    console.log("Current selected icon:", currentSelectedIcon);
    
    if (currentSelectedIcon) {
        // Find and highlight the previously selected icon
        var $iconElement = $('.icon-card[data-icon="' + currentSelectedIcon + '"]');
        if ($iconElement.length) {
            console.log("Found existing selection, highlighting it");
            $iconElement.addClass('selected bg-light border-primary');
        } else {
            console.log("Could not find icon element for:", currentSelectedIcon);
        }
    } else {
        // If no icon is selected, select the first one
        console.log("No icon selected, selecting the first one");
        if ($('.icon-card').length) {
            var $firstIcon = $('.icon-card').first();
            var firstIconClass = $firstIcon.data('icon');
            
            $('#selected-icon').val(firstIconClass);
            $('#selected-icon-preview').attr('class', firstIconClass + ' ri-lg me-1');
            $('#selected-icon-name').text(firstIconClass);
            $firstIcon.addClass('selected bg-light border-primary');
            
            console.log("Selected first icon:", firstIconClass);
        }
    }
}

<script>



$(function() {
    console.log("Document ready");
    
    // Initial setup
    fixIconSelection();
    
    // Reinitialize when offcanvas is shown
    $('#offcanvasAddCardType').on('shown.bs.offcanvas', function() {
        console.log("Offcanvas shown, reinitializing icon selection");
        setTimeout(function() {
            fixIconSelection();
        }, 500);
    });
    
    // Show offcanvas and reinitialize if there are validation errors
    @if($errors->any())
        console.log("Validation errors detected, showing offcanvas");
        var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCardType'));
        offcanvas.show();
        
        setTimeout(function() {
            fixIconSelection();
        }, 800);
    @endif
    
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
    
    // Auto-hide alert messages after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').alert('close');
    }, 5000);
});
</script>
@endsection