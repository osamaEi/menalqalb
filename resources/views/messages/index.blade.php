@extends('admin.index')

@section('title', __('Message List'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('Messages') }}</h5>
                        <a href="{{ route('messages.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i>{{ __('Create New Message') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($messages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Recipient') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Card Number') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Lock Type') }}</th>
                                        <th>{{ __('Created') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                        <tr>
                                            <td>{{ $message->id }}</td>
                                            <td>
                                                <strong>{{ $message->recipient_name }}</strong>
                                                @if ($message->recipient_phone)
                                                    <br><small>{{ $message->recipient_phone }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($message->mainCategory)
                                                    {{ $message->mainCategory->name_ar }}
                                                    @if ($message->subCategory)
                                                        <br><small>{{ $message->subCategory->name_ar }}</small>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $message->card_number }}</td>
                                            <td>
                                                @if ($message->status === 'sent')
                                                    <span class="badge bg-success">{{ __('Sent') }}</span>
                                                @elseif ($message->status === 'pending')
                                                    <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                                @elseif ($message->status === 'failed')
                                                    <span class="badge bg-danger">{{ __('Failed') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($message->lock_type === 'no_lock')
                                                    <span class="badge bg-secondary">{{ __('No Lock') }}</span>
                                                @elseif ($message->lock_type === 'lock_without_heart')
                                                    <span class="badge bg-info">{{ __('Locked') }}</span>
                                                @elseif ($message->lock_type === 'lock_with_heart')
                                                    <span class="badge bg-danger">{{ __('Locked with Heart') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                           
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="mb-0">{{ __('No messages found.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection