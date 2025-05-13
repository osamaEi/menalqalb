@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Requests') }} /</span> {{ __('Select Request Type') }}
        </h4>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mb-4">
                    <h2>{{ __('What would you like to request?') }}</h2>
                    <p class="text-muted">{{ __('Choose the type of item you want to create a request for') }}</p>
                </div>
                
                <div class="row g-4">
                    <!-- Lock Option -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm hover-shadow transition">
                            <div class="card-body text-center p-5">
                                <div class="mb-4">
                                    <div class="avatar avatar-xl mx-auto">
                                        <div class="avatar-initial bg-label-danger rounded-circle">
                                            <i class="ri-lock-2-line ri-36px"></i>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="mb-3">{{ __('Locks') }}</h4>
                                <p class="text-muted mb-4">{{ __('Request digital or physical locks for security purposes') }}</p>
                                <a href="{{ route('requests.create.lock') }}" class="btn btn-primary">
                                    <i class="ri-arrow-right-line me-1"></i> {{ __('Request Lock') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ready Card Option -->
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm hover-shadow transition">
                            <div class="card-body text-center p-5">
                                <div class="mb-4">
                                    <div class="avatar avatar-xl mx-auto">
                                        <div class="avatar-initial bg-label-info rounded-circle">
                                            <i class="ri-bank-card-2-line ri-36px"></i>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="mb-3">{{ __('Ready Cards') }}</h4>
                                <p class="text-muted mb-4">{{ __('Request pre-configured access cards for immediate use') }}</p>
                                <a href="{{ route('requests.create.ready-card') }}" class="btn btn-info">
                                    <i class="ri-arrow-right-line me-1"></i> {{ __('Request Card') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary">
                        <i class="ri-arrow-left-line me-1"></i> {{ __('Back to Requests') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .avatar-xl {
        width: 5rem;
        height: 5rem;
    }
    
    .avatar-xl .avatar-initial {
        width: 100%;
        height: 100%;
        font-size: 2rem;
    }
</style>
@endsection