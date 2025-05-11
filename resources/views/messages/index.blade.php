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
                                        <th>{{ __('Password') }}</th>
                                        <th> </th>
                                        <th>{{ __('Response') }}</th>
                                        <th>{{ __('Created') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                        <th>{{ __('Resend') }}</th>
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
                                                    <span class="badge bg-danger">{{ __('Heart') }} {{$message->lock_number}}</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($message->lock_type === 'lock_with_heart' ||  $message->lock_type === 'lock_without_heart')
                                                    {{ $message->message_lock}}
                                                @endif
                                            </td>

                                            <td>
                                                <td>
                                                    @if ($message->response)
                                                        <span class="badge bg-success">{{ __('Responded') }}</span>
                                                        @if($message->response_at)
                                                            <br><small>{{ is_object($message->response_at) ? $message->response_at->format('Y-m-d H:i') : $message->response_at }}</small>
                                                        @endif
                                                        <br>
                                                        <button type="button" class="btn btn-sm btn-outline-info mt-1" data-bs-toggle="modal" data-bs-target="#responseModal{{ $message->id }}">
                                                            {{ __('View Response') }}
                                                        </button>
                                                        
                                                        <!-- Response Modal -->
                                                        <div class="modal fade" id="responseModal{{ $message->id }}" tabindex="-1" aria-labelledby="responseModalLabel{{ $message->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="responseModalLabel{{ $message->id }}">{{ __('Response from') }} {{ $message->recipient_name }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>{{ $message->response }}</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="badge bg-secondary">{{ __('No Response') }}</span>
                                                    @endif
                                                </td>

                                            </td>

                                            <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <a href="{{ $message->readycardItem ? route('greetings.front.show', $message->readycardItem->unique_identifier) : '#' }}">
                                                    {{ __('View Card') }}
                                                </a>        
                                                
                                      
                                            </td>

                                            <td>          
                                                @if($message->recipient_phone)
                                                <form action="{{ route('messages.resend', $message) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success ms-1" 
                                                        onclick="return confirm('{{ __('Are you sure you want to resend this message?') }}')">
                                                        <i class="fas fa-paper-plane me-1"></i>{{ __('Resend') }}
                                                    </button>
                                                </form>
                                            @endif</td>
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