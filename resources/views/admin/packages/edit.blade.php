@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Packages') }} /</span> {{ __('Edit Package') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('Edit Package Details') }}</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('packages.update', $package->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="title_en" class="form-label">{{ __('Title (English)') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" 
                                        id="title_en" name="title_en" value="{{ old('title_en', $package->title_en) }}" required>
                                    @error('title_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="title_ar" class="form-label">{{ __('Title (Arabic)') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title_ar') is-invalid @enderror" 
                                        id="title_ar" name="title_ar" value="{{ old('title_ar', $package->title_ar) }}" required>
                                    @error('title_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="amount" class="form-label">{{ __('Amount') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                        id="amount" name="amount" value="{{ old('amount', $package->amount) }}" min="1" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="price" class="form-label">{{ __('Price') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                            id="price" name="price" value="{{ old('price', $package->price) }}" min="0" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                        {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">{{ __('Update Package') }}</button>
                                <a href="{{ route('packages.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection