@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Card Types') }} /</span> {{ __('View Card Type') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Card Type Details') }}</span>
                        <span class="badge bg-label-{{ $cardType->is_active ? 'success' : 'danger' }}">
                            {{ $cardType->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </h5>
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Card Type Preview -->
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="card shadow-none bg-light">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-3">
                                            @if($cardType->photo)
                                                <img src="{{ asset('storage/' . $cardType->photo) }}" alt="{{ $cardType->name }}" 
                                                    class="rounded-3 img-fluid" style="max-height: 200px">
                                            @else
                                                <div class="avatar avatar-xl bg-label-primary">
                                                    <i class="{{ $cardType->icon }} ri-5x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <h4 class="mb-1">{{ $cardType->name_en }}</h4>
                                        <h5 class="mb-2 text-muted" dir="rtl">{{ $cardType->name_ar }}</h5>
                                        <span class="badge bg-label-info mb-2">
                                            {{ __($typeOptions[$cardType->type] ?? $cardType->type) }}
                                        </span>
                                        <div class="d-flex justify-content-center mt-3 gap-2">
                                            <a href="{{ route('card_types.edit', $cardType->id) }}" class="btn btn-primary">
                                                <i class="ri-pencil-line me-1"></i> {{ __('Edit') }}
                                            </a>
                                            <form action="{{ route('card_types.destroy', $cardType->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('{{ __('Are you sure you want to delete this card type?') }}')">
                                                    <i class="ri-delete-bin-line me-1"></i> {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Type Information -->
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">{{ __('Information') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('ID') }}</label>
                                                <p>{{ $cardType->id }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('Status') }}</label>
                                                <p>
                                                    <span class="badge bg-label-{{ $cardType->is_active ? 'success' : 'danger' }}">
                                                        {{ $cardType->is_active ? __('Active') : __('Inactive') }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('English Name') }}</label>
                                                <p>{{ $cardType->name_en }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('Arabic Name') }}</label>
                                                <p dir="rtl">{{ $cardType->name_ar }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('Type') }}</label>
                                                <p>{{ __($typeOptions[$cardType->type] ?? $cardType->type) }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('Icon') }}</label>
                                                <p class="d-flex align-items-center">
                                                    <i class="{{ $cardType->icon }} ri-lg me-2"></i>
                                                    <code>{{ $cardType->icon }}</code>
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('Created At') }}</label>
                                                <p>{{ $cardType->created_at->format('F d, Y h:i A') }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">{{ __('Updated At') }}</label>
                                                <p>{{ $cardType->updated_at->format('F d, Y h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">{{ __('Actions') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex flex-wrap gap-2">
                                                    <a href="{{ route('card_types.index') }}" class="btn btn-outline-secondary">
                                                        <i class="ri-arrow-left-line me-1"></i> {{ __('Back to List') }}
                                                    </a>
                                                    <a href="{{ route('card_types.edit', $cardType->id) }}" class="btn btn-primary">
                                                        <i class="ri-pencil-line me-1"></i> {{ __('Edit') }}
                                                    </a>
                                                    <a href="{{ route('card_types.toggle.status', $cardType->id) }}" class="btn btn-{{ $cardType->is_active ? 'warning' : 'success' }}">
                                                        <i class="ri-toggle-line me-1"></i> 
                                                        {{ $cardType->is_active ? __('Deactivate') : __('Activate') }}
                                                    </a>
                                                    <form action="{{ route('card_types.destroy', $cardType->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" 
                                                            onclick="return confirm('{{ __('Are you sure you want to delete this card type?') }}')">
                                                            <i class="ri-delete-bin-line me-1"></i> {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection