@extends('admin.index')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Available Packages') }}</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <p class="mb-4">{{ __('You currently have :credits credits', ['credits' => Auth::user()->credits]) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        @forelse($packages as $package)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <h5 class="mb-0">{{ $package->title }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="mb-3"> AED {{ number_format($package->price, 2) }}</h3>
                        <p class="mb-4">{{ $package->amount }} {{ __('Credits') }}</p>
                        
                        <form action="{{ route('purchase.purchase', $package->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ __('Purchase Now') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-8">
                <div class="alert alert-info">
                    {{ __('No packages are currently available.') }}
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection