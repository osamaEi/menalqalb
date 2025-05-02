@extends('admin.index')

@section('content')
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">{{ __('Users') }} /</span> {{ __('Edit User') }}
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('User Details') }}</h5>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- Basic User Information -->
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <h5 class="card-header">{{ __('Basic Information') }}</h5>
                                        <div class="card-body">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                    id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="{{ __('John Doe') }}" 
                                                    required autocomplete="name" autofocus />
                                                <label for="name">{{ __('Full Name') }}</label>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                    id="email" name="email" value="{{ old('email', $user->email) }}" 
                                                    placeholder="{{ __('john.doe@example.com') }}" required autocomplete="email" />
                                                <label for="email">{{ __('Email Address') }}</label>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                    id="password" name="password" placeholder="{{ __('Password') }}" 
                                                    autocomplete="new-password" />
                                                <label for="password">{{ __('Password') }} ({{ __('Leave blank to keep current') }})</label>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="password" class="form-control" id="password-confirm" 
                                                    name="password_confirmation" placeholder="{{ __('Confirm Password') }}" 
                                                    autocomplete="new-password" />
                                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                            </div>
                                            
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" 
                                                    id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" 
                                                    placeholder="+1 (xxx) xxx-xxxx" autocomplete="tel" />
                                                <label for="whatsapp">{{ __('WhatsApp') }}</label>
                                                @error('whatsapp')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- User Settings -->
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <h5 class="card-header">{{ __('User Settings') }}</h5>
                                        <div class="card-body">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select id="country_id" class="select2 form-select @error('country_id') is-invalid @enderror" 
                                                    name="country_id" required>
                                                    <option value="">{{ __('Select a country') }}</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                                                            {{ $country->name_en }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="country_id">{{ __('Country') }}</label>
                                                @error('country_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select id="user_type" class="form-select @error('user_type') is-invalid @enderror" 
                                                    name="user_type" required>
                                                    <option value="">{{ __('Select user type') }}</option>
                                                    @foreach($userTypes as $type)
                                                        <option value="{{ $type }}" {{ old('user_type', $user->user_type) == $type ? 'selected' : '' }}>
                                                            {{ __(str_replace('_', ' ', ucfirst($type))) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="user_type">{{ __('User Type') }}</label>
                                                @error('user_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select id="status" class="form-select @error('status') is-invalid @enderror" 
                                                    name="status" required>
                                                    <option value="">{{ __('Select status') }}</option>
                                                    @foreach($statuses as $status)
                                                        <option value="{{ $status }}" {{ old('status', $user->status) == $status ? 'selected' : '' }}>
                                                            {{ __(ucfirst($status)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="status">{{ __('Status') }}</label>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" 
                                                            id="email_verified" name="email_verified" value="1" 
                                                            {{ old('email_verified', $user->email_verified_at ? true : false) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="email_verified">
                                                            {{ __('Email Verified') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" 
                                                            id="whatsapp_verified" name="whatsapp_verified" value="1" 
                                                            {{ old('whatsapp_verified', $user->whatsapp_verified_at ? true : false) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="whatsapp_verified">
                                                            {{ __('WhatsApp Verified') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                        <i class="ri-arrow-left-line me-1"></i> {{ __('Back to List') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line me-1"></i> {{ __('Update User') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize select2 if available
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({
                placeholder: "{{ __('Select an option') }}",
                allowClear: true
            });
        }
    });
</script>
@endsection