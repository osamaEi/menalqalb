@props(['name' => 'phone', 'label' => 'Phone Number', 'placeholder' => 'Enter phone number', 'value' => '', 'required' => false, 'helpText' => null])
@php
$countries = \App\Models\Country::all();
@endphp
<div {{ $attributes->merge(['class' => 'form-group mb-4']) }}>
    <label for="{{ $name }}" class="form-label">{{ __($label) }}</label>
    <div class="input-group">
        <select name="{{ $name }}_country_code" id="{{ $name }}_country_code" class="form-select country-code-select" style="max-width: 120px; flex: 0 0 120px;">
            @foreach($countries as $country)
                <option value="+{{ $country->code }}" {{ Str::startsWith($value, '+' . $country->code) ? 'selected' : '' }}>
                    +{{ $country->code }}
                </option>
            @endforeach
        </select>
        <input
            type="text"
            class="form-control @error($name) is-invalid @enderror"
            id="{{ $name }}_number"
            name="{{ $name }}_number"
            value="{{ Str::startsWith($value, '+') ? preg_replace('/^\+\d+/', '', $value) : $value }}"
            placeholder="{{ __($placeholder) }}"
            {{ $required ? 'required' : '' }}
        >
        <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}">
    </div>
   
    @if($helpText)
        <small class="form-text text-muted">{{ __($helpText) }}</small>
    @endif
   
    @error($name)
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find all phone input components
            document.querySelectorAll('[id$="_country_code"]').forEach(function(select) {
                const baseId = select.id.replace('_country_code', '');
                const numberInput = document.getElementById(baseId + '_number');
                const hiddenInput = document.getElementById(baseId);
               
                // Function to combine values
                const updatePhoneValue = function() {
                    const countryCode = select.value; // Already includes "+"
                    const number = numberInput.value.replace(/^0+/, ''); // Remove leading zeros
                    hiddenInput.value = countryCode + number;
                };
               
                // Add event listeners
                select.addEventListener('change', updatePhoneValue);
                numberInput.addEventListener('input', updatePhoneValue);
               
                // Initialize on page load
                updatePhoneValue();
            });
        });
    </script>
    @endpush
@endonce