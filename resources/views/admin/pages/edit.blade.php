@extends('admin.index')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2 mb-4">{{ __('Edit Page') }}</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title_ar" class="form-label">{{ __('Title (Arabic)') }}</label>
                    <input type="text" name="title_ar" id="title_ar" value="{{ old('title_ar', $page->title_ar) }}"
                           class="form-control @error('title_ar') is-invalid @enderror">
                    @error('title_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title_en" class="form-label">{{ __('Title (English)') }}</label>
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $page->title_en) }}"
                           class="form-control @error('title_en') is-invalid @enderror">
                    @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description_ar" class="form-label">{{ __('Description (Arabic)') }}</label>
                    <textarea name="description_ar" id="description_ar" class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar', $page->description_ar) }}</textarea>
                    @error('description_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description_en" class="form-label">{{ __('Description (English)') }}</label>
                    <textarea name="description_en" id="description_en" class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en', $page->description_en) }}</textarea>
                    @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">{{ __('Slug') }}</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}"
                           class="form-control @error('slug') is-invalid @enderror">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}
                           class="form-check-input">
                    <label for="is_active" class="form-check-label">{{ __('Is Active') }}</label>
                    @error('is_active')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">{{ __('Update Page') }}</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description_ar, #description_en',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
            height: 400,
            menubar: false,
        });
    </script>
</div>
@endsection