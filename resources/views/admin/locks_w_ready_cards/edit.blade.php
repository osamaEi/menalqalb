@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Locks & Ready Cards') }} /</span> {{ __('Edit Item') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('Edit Item Details') }}</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('locks_w_ready_cards.update', $locksWReadyCard->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name_en" class="form-label">{{ __('Name (English)') }}</label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror" 
                                        id="name_en" name="name_en" value="{{ old('name_en', $locksWReadyCard->name_en) }}" required>
                                    @error('name_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="name_ar" class="form-label">{{ __('Name (Arabic)') }}</label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror" 
                                        id="name_ar" name="name_ar" value="{{ old('name_ar', $locksWReadyCard->name_ar) }}" required>
                                    @error('name_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="desc_en" class="form-label">{{ __('Description (English)') }}</label>
                                    <textarea class="form-control @error('desc_en') is-invalid @enderror" 
                                        id="desc_en" name="desc_en" rows="3">{{ old('desc_en', $locksWReadyCard->desc_en) }}</textarea>
                                    @error('desc_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="desc_ar" class="form-label">{{ __('Description (Arabic)') }}</label>
                                    <textarea class="form-control @error('desc_ar') is-invalid @enderror" 
                                        id="desc_ar" name="desc_ar" rows="3">{{ old('desc_ar', $locksWReadyCard->desc_ar) }}</textarea>
                                    @error('desc_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="type" class="form-label">{{ __('Type') }}</label>
                                    <select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="lock" {{ old('type', $locksWReadyCard->type) == 'lock' ? 'selected' : '' }}>{{ __('Lock') }}</option>
                                        <option value="read_card" {{ old('type', $locksWReadyCard->type) == 'read_card' ? 'selected' : '' }}>{{ __('Read Card') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="price" class="form-label">{{ __('Price') }}</label>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                        id="price" name="price" value="{{ old('price', $locksWReadyCard->price) }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="points" class="form-label">{{ __('Points') }}</label>
                                    <input type="number" class="form-control @error('points') is-invalid @enderror" 
                                        id="points" name="points" value="{{ old('points', $locksWReadyCard->points) }}" required>
                                    @error('points')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="photo" class="form-label">{{ __('Photo') }}</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                        id="photo" name="photo" accept="image/*">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($locksWReadyCard->photo)
                                        <div class="mt-2">
                                            <p>{{ __('Current photo:') }}</p>
                                            <img src="{{ asset('storage/' . $locksWReadyCard->photo) }}" 
                                                alt="{{ $locksWReadyCard->name_en }}" 
                                                class="img-thumbnail" 
                                                style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" 
                                            name="is_active" value="1" 
                                            {{ old('is_active', $locksWReadyCard->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">{{ __('Update') }}</button>
                                <a href="{{ route('locks_w_ready_cards.index') }}" class="btn btn-outline-secondary">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection