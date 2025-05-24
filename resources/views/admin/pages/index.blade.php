@extends('admin.index')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2 mb-4">{{ __('Manage Pages') }}</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">{{ __('Create New Page') }}</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>{{ __('Title (English)') }}</th>
                            <th>{{ __('Title (Arabic)') }}</th>
                            <th>{{ __('Slug') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pages as $page)
                            <tr>
                                <td>{{ $page->title_en }}</td>
                                <td>{{ $page->title_ar }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    <span class="badge {{ $page->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $page->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-primary">{{ __('Edit') }}</a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure you want to delete this page?') }}')">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No pages found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection