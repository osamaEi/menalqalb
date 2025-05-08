@extends('admin.index')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1>{{__('Countries')}}</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('countries.create') }}" class="btn btn-primary">{{ __('Add New Country')}}</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name (Arabic)')}}</th>
                        <th>{{ __('Name (English)')}}</th>
                        <th>{{ __('Code')}}</th>
                        <th>{{ __('Flag')}}</th>
                        <th>{{ __('Created At')}}</th>
                        <th>{{ __('Updated At')}}</th>
                        <th>{{ __('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $country)
                        <tr>
                            <td>{{ $country->id }}</td>
                            <td>{{ $country->name_ar }}</td>
                            <td>{{ $country->name_en }}</td>
                            <td>{{ $country->code }}</td>
                            <td>
                                @if($country->flag)
                                    <img src="{{ asset('storage/' . $country->flag) }}" alt="{{ $country->name_en }}" width="50">
                                @else
                                {{ __('No Flag')}}
                                @endif
                            </td>
                            <td>{{ $country->created_at ?? 'N/A' }}</td>
                            <td>{{ $country->updated_at ?? 'N/A' }}</td>
                            <td>
                                    <a href="{{ route('countries.edit', $country) }}" class="btn btn-sm btn-info">{{__('Edit')}}</a>
                                    <form action="{{ route('countries.destroy', $country) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this country?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete')}}</button>
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection