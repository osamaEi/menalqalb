@extends('admin.index')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1>Edit Country: {{ $country->name_en }}</h1>
            <a href="{{ route('countries.index') }}" class="btn btn-secondary">Back to List</a>
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
            <form action="{{ route('countries.update', $country) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name_ar">Name (Arabic)</label>
                    <input type="text" name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar', $country->name_ar) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="name_en">Name (English)</label>
                    <input type="text" name="name_en" id="name_en" class="form-control" value="{{ old('name_en', $country->name_en) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="code">Country Code</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $country->code) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="flag">Flag Image</label>
                    @if($country->flag)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $country->flag) }}" alt="{{ $country->name_en }}" width="100">
                        </div>
                    @endif
                    <input type="file" name="flag" id="flag" class="form-control-file">
                    <small class="form-text text-muted">Leave empty to keep the current flag</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Country</button>
            </form>
        </div>
    </div>
</div>
@endsection