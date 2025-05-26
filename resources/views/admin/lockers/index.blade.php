@extends('admin.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Lockers') }}</h1>
        <a href="{{ route('admin.lockers.create') }}" class="btn btn-primary">{{ __('Add New Locker') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('User') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Photo') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lockers as $locker)
                <tr>
                    <td>{{ $locker->id }}</td>
                    <td>{{ $locker->user->name }}</td>
                    <td>{{ $locker->quantity }}</td>
                    <td>${{ number_format($locker->price, 2) }}</td>
                    <td>
                        @if($locker->photo)
                            <img src="{{ asset('storage/' . $locker->photo) }}" alt="{{ __('Photo') }}" width="50">
                        @else
                            {{ __('No photo') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.lockers.show', $locker->id) }}" class="btn btn-info btn-sm">{{ __('View') }}</a>
                        <a href="{{ route('admin.lockers.edit', $locker->id) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                        <form action="{{ route('admin.lockers.destroy', $locker->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection