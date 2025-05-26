@extends('admin.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Locker Details') }}</h1>
        <div>
            <a href="{{ route('admin.lockers.edit', $locker->id) }}" class="btn btn-warning">{{ __('Edit') }}</a>
            <form action="{{ route('admin.lockers.destroy', $locker->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($locker->photo)
                        <img src="{{ asset('storage/' . $locker->photo) }}" alt="{{ __('Photo') }}" class="img-fluid">
                    @else
                        <div class="text-center py-4 bg-light">{{ __('No photo available') }}</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ __('Locker') }} #{{ $locker->id }}</h3>
                    <p><strong>{{ __('User') }}:</strong> {{ $locker->user->name }}</p>
                    <p><strong>{{ __('Quantity') }}:</strong> {{ $locker->quantity }}</p>
                    <p><strong>{{ __('Price') }}:</strong> ${{ number_format($locker->price, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <h3>{{ __('Locker Items') }}</h3>
    <div class="row">
        @foreach($locker->items as $item)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ __('Locker') }} #{{ $item->number_locker }}</h5>
                        <p class="card-text">{{ __('Status') }} .{{__($item->status)}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection