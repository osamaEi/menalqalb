@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Requests') }} /</span> {{ __('Request Details') }}
        </h4>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="mb-0">{{ __('Request #') }}{{ $request->id }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Status:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                <span class="badge bg-label-{{ $request->status_color }}">
                                    {{ $request->status_label }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Customer:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $request->name }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Email:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                <a href="mailto:{{ $request->email }}">{{ $request->email }}</a>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Phone:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $request->phone }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Address:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $request->address }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Quantity:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $request->quantity }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Total Price:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                ${{ number_format($request->total_price, 2) }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Total Points:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $request->total_points }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Created:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $request->created_at->format('Y-m-d H:i:s') }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>{{ __('Last Updated:') }}</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $request->updated_at->format('Y-m-d H:i:s') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="mb-0">{{ __('Item Details') }}</h5>
                    </div>
                    <div class="card-body text-center">
                        @if($request->locksWReadyCard->photo)
                            <img src="{{ asset('storage/' . $request->locksWReadyCard->photo) }}" 
                                alt="{{ $request->locksWReadyCard->name }}" 
                                class="img-fluid mb-3" style="max-width: 200px;">
                        @else
                            <div class="bg-light rounded p-4 mb-3">
                                <i class="ri-image-line ri-48px text-muted"></i>
                            </div>
                        @endif
                        
                        <h6 class="fw-medium">{{ $request->locksWReadyCard->name }}</h6>
                        <p class="text-muted mb-2">{{ $request->locksWReadyCard->description }}</p>
                        
                        <span class="badge bg-label-{{ $request->locksWReadyCard->type == 'lock' ? 'danger' : 'info' }} mb-3">
                            {{ $request->locksWReadyCard->type == 'lock' ? __('Lock') : __('Read Card') }}
                        </span>
                        
                        <div class="row text-start">
                            <div class="col-6">
                                <p class="mb-1"><strong>{{ __('Price:') }}</strong></p>
                                <p class="text-primary">${{ $request->locksWReadyCard->price }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><strong>{{ __('Points:') }}</strong></p>
                                <p class="text-primary">{{ $request->locksWReadyCard->points }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="mb-0">{{ __('Actions') }}</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('requests.edit', $request->id) }}" class="btn btn-primary w-100 mb-2">
                            <i class="ri-pencil-line me-1"></i> {{ __('Edit Request') }}
                        </a>
                        
                        @if($request->isPending())
                            <form action="{{ route('requests.approve', $request->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="ri-check-line me-1"></i> {{ __('Approve') }}
                                </button>
                            </form>
                            
                            <form action="{{ route('requests.reject', $request->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="ri-close-line me-1"></i> {{ __('Reject') }}
                                </button>
                            </form>
                        @endif
                        
                        @if($request->isApproved())
                            <form action="{{ route('requests.complete', $request->id) }}" method="POST" class="mb-2">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="ri-check-double-line me-1"></i> {{ __('Mark Complete') }}
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('requests.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="ri-arrow-left-line me-1"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection