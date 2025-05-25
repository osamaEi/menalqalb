@extends('app.index')
@section('content')
<div class="container mx-auto px-4 py-8 z-10 relative font-['Cairo']">
    <!-- Header -->
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-900">{{ __('Invoices') }}</h1>

    <!-- Filters and Search -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <!-- Search Bar -->
        <div class="flex items-center w-full max-w-md">
            <input type="text" id="searchInput" placeholder="{{ __('Search by invoice number or subject...') }}"
                   class="w-full p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span class="inline-flex items-center px-3 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
        </div>
        <!-- Status Filter -->
        <div class="flex items-center w-full max-w-xs">
            <select id="statusFilter" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="{{ __('All') }}">{{ __('All') }}</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
            <label for="statusFilter" class="min-w-[124px] font-medium mr-2">{{ __('Filter by status') }}</label>
        </div>
    </div>

    <!-- Invoices Container -->
    <div class="cards-container bg-white rounded-lg shadow-sm p-4 max-h-[500px] overflow-y-auto scroll-smooth">
        <div id="invoicesList">
            @forelse($bills as $bill)
                <div class="invoice-card bg-white rounded-lg shadow-sm p-6 mb-4 hover:shadow-md transition-shadow duration-200" data-status="{{ $bill['status'] }}" data-id="{{ $bill['id'] }}" data-subject="{{ $bill['subject'] }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">{{ __('Invoice number:') }}</span>
                            <span class="text-gray-900">{{ $bill['id'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">{{ __('Date:') }}</span>
                            <span class="text-gray-900">{{ $bill['date'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">{{ __('Subject:') }}</span>
                            <span class="text-gray-900">{{ $bill['subject'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">{{ __('Amount:') }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-900">{{ $bill['amount'] }}</span>
                                <span class="text-sm text-gray-500">{{ strtoupper($bill['currency']) }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">{{ __('Status:') }}</span>
                            <span class="px-3 py-1 rounded-full text-white text-sm status-{{ str_replace(' ', '-', $bill['status']) }}">
                                {{ $bill['status'] }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">{{ __('Action:') }}</span>
                            <a href="{{ route('app.bills.pdf', $bill['id']) }}"
                               class="px-3 py-1 rounded text-white text-sm {{ $bill['action_class'] }} hover:opacity-90 transition-opacity">
                               {{ __('Download') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-4">{{ __('No invoices found') }}</div>
            @endforelse
        </div>
        <!-- Loading State -->
        <div id="loading" class="hidden text-center text-gray-500 py-4">{{ __('Loading...') }}</div>
    </div>

    <!-- Pagination -->
    @if ($bills->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $bills->links('pagination::tailwind') }}
        </div>
    @endif
</div>

<script>
    // Debounce function to limit search frequency
    function debounce(func, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Filter and search logic
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchInput');
    const invoicesList = document.getElementById('invoicesList');
    const loading = document.getElementById('loading');

    function filterInvoices() {
        const selectedStatus = statusFilter.value;
        const searchQuery = searchInput.value.toLowerCase();
        const cards = invoicesList.querySelectorAll('.invoice-card');

        // Show loading state
        loading.classList.remove('hidden');
        invoicesList.classList.add('opacity-50');

        setTimeout(() => {
            let visibleCount = 0;
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                const id = card.getAttribute('data-id');
                const subject = card.getAttribute('data-subject').toLowerCase();
                const matchesStatus = selectedStatus === '{{ __('All') }}' || status === selectedStatus;
                const matchesSearch = id.includes(searchQuery) || subject.includes(searchQuery);

                if (matchesStatus && matchesSearch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show "No invoices found" if no results
            const noResults = invoicesList.querySelector('.text-center.text-gray-500');
            if (visibleCount === 0 && !noResults) {
                invoicesList.innerHTML = `<div class="text-center text-gray-500 py-4">{{ __('No invoices found') }}</div>`;
            } else if (visibleCount > 0 && noResults) {
                // Repopulate invoices if needed (client-side only)
                invoicesList.innerHTML = Array.from(cards).map(card => card.outerHTML).join('');
            }

            // Hide loading state
            loading.classList.add('hidden');
            invoicesList.classList.remove('opacity-50');
        }, 300); // Simulate loading delay
    }

    // Event listeners
    statusFilter.addEventListener('change', filterInvoices);
    searchInput.addEventListener('input', debounce(filterInvoices, 300));
</script>
@endsection