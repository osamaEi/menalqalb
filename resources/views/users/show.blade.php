@extends('admin.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>User Details</h2>
                    <div>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">ID:</div>
                        <div class="col-md-8">{{ $user->id }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Name:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8">
                            {{ $user->email }}
                            @if($user->email_verified)
                                <span class="badge badge-success ml-2">Verified</span>
                            @else
                                <span class="badge badge-secondary ml-2">Not Verified</span>
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Country:</div>
                        <div class="col-md-8">
                            @if($user->country)
                                {{ $user->country->name }}
                            @else
                                Not specified
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">WhatsApp:</div>
                        <div class="col-md-8">
                            {{ $user->whatsapp ?? 'Not provided' }}
                            @if($user->whatsapp)
                                @if($user->whatsapp_verified)
                                    <span class="badge badge-success ml-2">Verified</span>
                                @else
                                    <span class="badge badge-secondary ml-2">Not Verified</span>
                                @endif
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">User Type:</div>
                        <div class="col-md-8">
                            <span class="badge badge-{{ 
                                $user->user_type === 'admin' ? 'danger' : 
                                ($user->user_type === 'designer' ? 'info' : 
                                ($user->user_type === 'sales_point' ? 'warning' : 'primary')) 
                            }}">
                                {{ str_replace('_', ' ', ucfirst($user->user_type)) }}
                            </span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge badge-{{ 
                                $user->status === 'active' ? 'success' : 
                                ($user->status === 'inactive' ? 'secondary' : 
                                ($user->status === 'blocked' ? 'warning' : 'danger')) 
                            }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Created:</div>
                        <div class="col-md-8">{{ $user->created_at->format('F d, Y h:i A') }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4 font-weight-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('F d, Y h:i A') }}</div>
                    </div>

                    @if($user->cards->count() > 0 || $user->readyCards->count() > 0)
                        <hr>
                        
                        <div class="mt-4">
                            <h4>Related Data</h4>
                            
                            @if($user->cards->count() > 0)
                                <div class="mt-3">
                                    <h5>Cards Created ({{ $user->cards->count() }})</h5>
                                    <ul class="list-group">
                                        @foreach($user->cards->take(5) as $card)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $card->title ?? 'Card #' . $card->id }}
                                                <a href="{{ route('cards.show', $card->id) }}" class="btn btn-sm btn-info">View</a>
                                            </li>
                                        @endforeach
                                        
                                        @if($user->cards->count() > 5)
                                            <li class="list-group-item text-center">
                                                <a href="{{ route('cards.index', ['designer_id' => $user->id]) }}">View all {{ $user->cards->count() }} cards</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            
                            @if($user->readyCards->count() > 0)
                                <div class="mt-3">
                                    <h5>Ready Cards Ordered ({{ $user->readyCards->count() }})</h5>
                                    <ul class="list-group">
                                        @foreach($user->readyCards->take(5) as $readyCard)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $readyCard->title ?? 'Ready Card #' . $readyCard->id }}
                                                <a href="{{ route('ready-cards.show', $readyCard->id) }}" class="btn btn-sm btn-info">View</a>
                                            </li>
                                        @endforeach
                                        
                                        @if($user->readyCards->count() > 5)
                                            <li class="list-group-item text-center">
                                                <a href="{{ route('ready-cards.index', ['customer_id' => $user->id]) }}">View all {{ $user->readyCards->count() }} ready cards</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection