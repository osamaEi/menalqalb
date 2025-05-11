@extends('admin.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Create New Setting') }}</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="key" class="form-label">{{ __('Key') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="key" name="key" value="{{ old('key') }}" required>
                            <small class="text-muted">{{ __('Unique identifier for this setting (no spaces, use underscores)') }}</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Type') }} <span class="text-danger">*</span></label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                                <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>{{ __('Image') }}</option>
                            </select>
                        </div>
                        
                        <div id="text-value" class="mb-3" style="{{ old('type') == 'image' ? 'display: none;' : '' }}">
                            <label for="value" class="form-label">{{ __('Value') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="value" name="value" rows="3">{{ old('value') }}</textarea>
                        </div>
                        
                        <div id="image-value" class="mb-3" style="{{ old('type') == 'image' || old('type') == null ? 'display: none;' : '' }}">
                            <label for="image" class="form-label">{{ __('Image') }} <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('Create Setting') }}</button>
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const textValue = document.getElementById('text-value');
        const imageValue = document.getElementById('image-value');
        
        // Function to toggle value fields based on type
        function toggleValueFields() {
            if (typeSelect.value === 'text') {
                textValue.style.display = 'block';
                imageValue.style.display = 'none';
            } else {
                textValue.style.display = 'none';
                imageValue.style.display = 'block';
            }
        }
        
        // Initial setup
        toggleValueFields();
        
        // Add change event listener
        typeSelect.addEventListener('change', toggleValueFields);
    });
</script>
@endsection