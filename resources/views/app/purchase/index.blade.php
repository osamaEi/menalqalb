@extends('app.index')

@section('content')
       

       <!-- Balance and Title -->
<p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-4 relative">
    {{ __('recharge_balance') }}
</p>
<p class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#5B186B] z-50 mt-2 relative">
    {{ __('available_balance', ['points' => number_format(auth()->user()->credits_package ?? 0)]) }}
</p>

<!-- Packages -->
<div class="px-3 mt-6">
    <div class="rounded flex mb-2 text-[16px] font-[400] items-center justify-between p-2 bg-[#f7ecd9]">
        <p class="ml-[96px]">{{ __('points_count') }}</p>
        <p>{{ __('price') }}</p>
    </div>
    <form id="packageForm" action="" method="POST">
        @csrf
        <input type="hidden" name="package_id" id="selected_package" value="">
        <div class="grid grid-cols-1 gap-3">
            @foreach($packages as $index => $package)
                <div class="package-card rounded flex text-[16px] font-[400] items-center justify-between p-2 {{ $index % 2 == 0 ? 'bg-[#B6232630]' : 'bg-[#E0D4E37A]' }}"
                     onclick="selectPackage(this, {{ $package->id }})">
                    <div>
                        <input id="radio-{{ $package->id }}" name="package" type="radio" class="w-[23px] h-[23px]">
                    </div>
                    <p class="flex flex-row-reverse gap-1">
                        <span>{{ number_format($package->amount) }}</span>
                        <span>{{ __('points') }}</span>
                    </p>
                    <p class="flex flex-row-reverse gap-1">
                        <span>{{ number_format($package->price) }}</span>
                        <span>
                            <!-- SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#17191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.5 11H18.5" stroke="#17191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.5 13H18.5" stroke="#17191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </p>
                </div>
            @endforeach
        </div>
    </form>
</div>

<!-- Purchase Button -->
<div class="items-center justify-center flex mt-6">
    <button onclick="submitForm()" class="btn-primary text-center text-white p-2 rounded-[13px] w-[141px]">
        {{ __('recharge') }}
    </button>
</div>

        <!-- Success/Error/Info Messages -->
        @if(session('success'))
            <div class="notification fixed bottom-0 left-0 right-0 bg-green-500 text-white p-4 text-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="notification fixed bottom-0 left-0 right-0 bg-red-500 text-white p-4 text-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="notification fixed bottom-0 left-0 right-0 bg-blue-500 text-white p-4 text-center">
                <i class="fas fa-info-circle mr-2"></i>
                {{ session('info') }}
            </div>
        @endif
    </div>

    <script>
        let selectedPackageId = null;

        function selectPackage(element, packageId) {
            // Remove selection from all packages
            document.querySelectorAll('.package-card').forEach(card => {
                card.classList.remove('selected');
                card.querySelector('input[type="radio"]').checked = false;
            });

            // Add selection to clicked package
            element.classList.add('selected');
            element.querySelector('input[type="radio"]').checked = true;
            selectedPackageId = packageId;
            document.getElementById('selected_package').value = packageId;

            // Update form action with package ID
            const form = document.getElementById('packageForm');
            form.action = `/packages/purchase/${packageId}`;
        }

        function submitForm() {
            if (!selectedPackageId) {
                showAlert('الرجاء اختيار باقة نقاط');
                return;
            }
            document.getElementById('packageForm').submit();
        }

        function showAlert(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed bottom-0 left-0 right-0 bg-yellow-500 text-white p-4 text-center';
            alertDiv.innerHTML = `<i class="fas fa-exclamation-triangle mr-2"></i>${message}`;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Auto-hide notifications after 5 seconds
        setTimeout(() => {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => notification.remove());
        }, 5000);
    </script>
@endsection