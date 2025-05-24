@extends('admin.index')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2 mb-4">{{ __('Create New Page') }}</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" method="POST" id="pageForm">
                @csrf
                <div class="mb-3">
                    <label for="title_ar" class="form-label">{{ __('Title (Arabic)') }}</label>
                    <input type="text" name="title_ar" id="title_ar" value="{{ old('title_ar') }}"
                           class="form-control @error('title_ar') is-invalid @enderror">
                    @error('title_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title_en" class="form-label">{{ __('Title (English)') }}</label>
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}"
                           class="form-control @error('title_en') is-invalid @enderror">
                    @error('title_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Description (Arabic)') }}</label>
                    <!-- Hidden input to store the HTML content -->
                    <input type="hidden" name="description_ar" id="description_ar_input" value="{{ old('description_ar') }}">
                    <!-- Editor container -->
                    <div id="description_ar_editor" class="form-control @error('description_ar') is-invalid @enderror" style="height: 300px;">
                        {!! old('description_ar') !!}
                    </div>
                    @error('description_ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Description (English)') }}</label>
                    <!-- Hidden input to store the HTML content -->
                    <input type="hidden" name="description_en" id="description_en_input" value="{{ old('description_en') }}">
                    <!-- Editor container -->
                    <div id="description_en_editor" class="form-control @error('description_en') is-invalid @enderror" style="height: 300px;">
                        {!! old('description_en') !!}
                    </div>
                    @error('description_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">{{ __('Slug') }}</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           class="form-control @error('slug') is-invalid @enderror">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                           class="form-check-input">
                    <label for="is_active" class="form-check-label">{{ __('Is Active') }}</label>
                    @error('is_active')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">{{ __('Create Page') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Quill stylesheet -->
<link href="../../assets/vendor/libs/quill/typography.css" rel="stylesheet" />
<link href="../../assets/vendor/libs/quill/katex.css" rel="stylesheet" />
<link href="../../assets/vendor/libs/quill/editor.css" rel="stylesheet" />

<!-- Include Quill library -->
<script src="../../assets/vendor/libs/quill/katex.js"></script>
<script src="../../assets/vendor/libs/quill/quill.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Arabic editor
    const arabicEditor = new Quill('#description_ar_editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'اكتب المحتوى العربي هنا...'
    });

    // Initialize English editor
    const englishEditor = new Quill('#description_en_editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Write English content here...'
    });

    // Set initial content if there's old input
    @if(old('description_ar'))
        arabicEditor.root.innerHTML = `{!! old('description_ar') !!}`;
    @endif
    
    @if(old('description_en'))
        englishEditor.root.innerHTML = `{!! old('description_en') !!}`;
    @endif

    // Update hidden inputs before form submission
    document.getElementById('pageForm').onsubmit = function() {
        document.getElementById('description_ar_input').value = arabicEditor.root.innerHTML;
        document.getElementById('description_en_input').value = englishEditor.root.innerHTML;
        return true;
    };

    // Auto-generate slug from English title
    document.getElementById('title_en').addEventListener('keyup', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value) { // Only auto-generate if slug is empty
            const slug = this.value
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            slugInput.value = slug;
        }
    });
});
</script>
@endsection