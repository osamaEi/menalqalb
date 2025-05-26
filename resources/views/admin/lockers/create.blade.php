@extends('admin.index')

@section('content')
    <h1>{{ __('Create New Locker') }}</h1>

    <form action="{{ route('admin.lockers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">{{ __('User') }}</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">{{ __('Select User') }}</option>
                @foreach($requests as $request)
                    <option value="{{ $request->user->id }}">{{ $request->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required min="1">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">{{ __('Price') }}</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required min="0">
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">{{ __('Photo') }}</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Create Locker') }}</button>
        <a href="{{ route('admin.lockers.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
@endsection