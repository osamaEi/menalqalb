@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold py-3 mb-0">
                        <span class="text-muted fw-light">{{ __('Cards') }} /</span> {{ __('Card Details') }}
                    </h4>
                    <div>
                        <a href="{{ route('cards.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="ri-arrow-left-line me-1"></i> {{ __('Back to List') }}
                            <a href="{{ route('cards.edit', $card->id) }}" class="btn btn-primary">
                                <i class="ri-pencil-line me-1"></i> {{ __('Edit Card') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Card Preview -->
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('Card Preview') }}</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="position-relative mb-4">
                                @if($card->is_image)
                                    <img src="{{ asset('storage/' . $card->file_path) }}" 
                                        alt="{{ $card->title }}" 
                                        class="img-fluid rounded-3 shadow"
                                        style="max-height: 400px; width: auto;">
                                @elseif($card->is_video)
                                    <video controls class="img-fluid rounded-3 shadow" style="max-height: 400px; width: auto;">
                                        <source src="{{ asset('storage/' . $card->file_path) }}" type="{{ $card->mime_type }}">
                                        {{ __('Your browser does not support the video tag.') }}
                                    </video>
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light rounded-3 shadow" 
                                        style="height: 300px; width: 100%;">
                                        <div class="text-center">
                                            <i class="ri-file-line ri-5x text-primary mb-3"></i>
                                            <h5>{{ __('Preview not available') }}</h5>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-{{ $card->is_active ? 'success' : 'danger' }}">
                                        {{ $card->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a href="{{ asset('storage/' . $card->file_path) }}" class="btn btn-primary" download="{{ $card->title }}">
                                    <i class="ri-download-line me-1"></i> {{ __('Download') }}
                                </a>
                                
                                @if($card->is_image || $card->is_video)
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#fullscreenPreviewModal">
                                        <i class="ri-fullscreen-line me-1"></i> {{ __('Fullscreen') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Usage Statistics Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('Usage Statistics') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">{{ __('Views') }}</h6>
                                    <small class="text-muted">{{ __('Total views') }}</small>
                                </div>
                                <h4>{{ $card->view_count ?? 0 }}</h4>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">{{ __('Downloads') }}</h6>
                                    <small class="text-muted">{{ __('Total downloads') }}</small>
                                </div>
                                <h4>{{ $card->download_count ?? 0 }}</h4>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">{{ __('Shares') }}</h6>
                                    <small class="text-muted">{{ __('Social shares') }}</small>
                                </div>
                                <h4>{{ $card->share_count ?? 0 }}</h4>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-0">{{ __('Usage') }}</h6>
                                    <small class="text-muted">{{ __('Used in messages') }}</small>
                                </div>
                                <h4>{{ $card->usage_count ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card Details -->
                <div class="col-xl-8 col-lg-7 col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('Card Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('Title') }}</h6>
                                    <p>{{ $card->title }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('Language') }}</h6>
                                    <p>
                                        <span class="badge bg-label-secondary">
                                            {{ $languages[$card->language] ?? $card->language }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('Card Type') }}</h6>
                                    <p>
                                        <span class="badge bg-label-{{ 
                                            $card->cardType && $card->cardType->type === 'image' ? 'primary' : 
                                            ($card->cardType && $card->cardType->type === 'video' ? 'danger' : 
                                            ($card->cardType && $card->cardType->type === 'animated_image' ? 'success' : 'info')) 
                                        }}">
                                            <i class="{{ 
                                                $card->cardType && $card->cardType->type === 'image' ? 'ri-image-line' : 
                                                ($card->cardType && $card->cardType->type === 'video' ? 'ri-video-line' : 
                                                ($card->cardType && $card->cardType->type === 'animated_image' ? 'ri-gif-line' : 'ri-file-line')) 
                                            }} me-1"></i>
                                            {{ $card->cardType ? $card->cardType->name : 'N/A' }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('Designer') }}</h6>
                                    <p>{{ $card->user ? $card->user->name : 'N/A' }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('Categories') }}</h6>
                                    <p>
                                        <span class="badge bg-label-primary me-1">
                                            {{ $card->mainCategory ? $card->mainCategory->name : 'N/A' }}
                                        </span>
                                        @if($card->subCategory)
                                            <span class="badge bg-label-info">
                                                {{ $card->subCategory->name }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('File Information') }}</h6>
                                    <p>
                                        <small class="d-block text-muted">{{ __('Format') }}: {{ $card->mime_type ?? 'N/A' }}</small>
                                        <small class="d-block text-muted">{{ __('Size') }}: {{ isset($card->file_size) ? number_format($card->file_size / 1024, 2) . ' KB' : 'N/A' }}</small>
                                        <small class="d-block text-muted">{{ __('Dimensions') }}: {{ $card->width ? $card->width . 'x' . $card->height : 'N/A' }}</small>
                                    </p>
                                </div>
                                
                                <div class="col-12">
                                    <hr>
                                </div>
                                
                              
                                
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-semibold">{{ __('Selling Price') }}</h6>
                                    <p>{{ number_format($card->selling_price ?? 0, 2) }}</p>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <h6 class="fw-semibold">{{ __('Profit Margin') }}</h6>
                                    <p class="mb-0 {{ ($card->profit_margin ?? 0) > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $card->profit_margin ?? 0 }}%
                                    </p>
                                </div>
                                
                                <div class="col-12">
                                    <hr>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('Created At') }}</h6>
                                    <p>{{ $card->created_at ? $card->created_at->format('F d, Y \a\t h:i A') : 'N/A' }}</p>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <h6 class="fw-semibold">{{ __('Last Updated') }}</h6>
                                    <p>{{ $card->updated_at ? $card->updated_at->format('F d, Y \a\t h:i A') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fullscreen Preview Modal -->
    <div class="modal fade" id="fullscreenPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $card->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center bg-body">
                    @if($card->is_image)
                        <img src="{{ asset('storage/' . $card->file_path) }}" alt="{{ $card->title }}" class="img-fluid">
                    @elseif($card->is_video)
                        <video controls class="img-fluid" style="max-height: 90vh;">
                            <source src="{{ asset('storage/' . $card->file_path) }}" type="{{ $card->mime_type }}">
                            {{ __('Your browser does not support the video tag.') }}
                        </video>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection