@extends('admin.index')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1>{{__('Add New Country')}}</h1>
            <a href="{{ route('countries.index') }}" class="btn btn-secondary">{{__('Back to List')}}</a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('countries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="name_ar">{{__('Name (Arabic)')}}</label>
                    <input type="text" name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="name_en">{{__('Name (English)')}}</label>
                    <input type="text" name="name_en" id="name_en" class="form-control" value="{{ old('name_en') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="code">{{__('Country Code')}}</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="flag">{{__('Flag Image')}}</label>
                    <input type="file" name="flag" id="flag" class="form-control-file">
                </div>
                
                <button type="submit" class="btn btn-primary">{{__('Save Country')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection