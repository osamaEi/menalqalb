@extends('admin.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Settings') }}</h5>
                    <a href="{{ route('admin.settings.create') }}" class="btn btn-primary">{{ __('Add New Setting') }}</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($settings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="25%">{{ __('Key') }}</th>
                                        <th width="40%">{{ __('Value') }}</th>
                                        <th width="15%">{{ __('Type') }}</th>
                                        <th width="20%">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($settings as $setting)
                                        <tr>
                                            <td>{{ $setting->key }}</td>
                                            <td>
                                                @if($setting->type === 'text')
                                                    {{ $setting->value }}
                                                @else
                                                    @if($setting->value)
                                                        <img src="{{ asset('storage/'.$setting->value) }}" class="img-thumbnail" style="max-height: 100px;">
                                                    @else
                                                        {{ __('No image') }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($setting->type) }}</td>
                                            <td>
                                                <a href="{{ route('admin.settings.edit', $setting->id) }}" class="btn btn-sm btn-primary">{{ __('Edit') }}</a>
                                                <form action="{{ route('admin.settings.destroy', $setting->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this setting?') }}')">{{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('No settings found.') }} <a href="{{ route('admin.settings.create') }}">{{ __('Create your first setting') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection