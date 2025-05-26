@extends('admin.index')

@section('content')
    <h1>{{ __('Edit Locker') }}</h1>

    <form action="{{ route('admin.lockers.update', $locker->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">{{ __('User') }}</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">{{ __('Select User') }}</option>
                @foreach($requests as $request)
                    <option value="{{ $request->user->id }}" {{ $locker->user_id == $request->user->id ? 'selected' : '' }}>{{ $request->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $locker->quantity }}" required min="1">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">{{ __('Price') }}</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $locker->price }}" required min="0">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">{{ __('Photo') }}</label>
            <input type="file" class="form-control" id="photo" name="photo">
            @if($locker->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $locker->photo) }}" alt="{{ __('Current photo') }}" width="100">
                    <p class="text-muted">{{ __('Current photo') }}</p>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update Locker') }}</button>
        <a href="{{ route('admin.lockers.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
@endsection