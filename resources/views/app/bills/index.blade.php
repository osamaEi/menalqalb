
@extends('app.index')
@section('content')
<style>
    body {
        font-family: 'Cairo', sans-serif;
    }

    .cards-container {
        max-height: 500px;
        overflow-y: auto;
        position: relative;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1rem;
    }

    .status-paid {
        background-color: #059669;
    }

    .status-cancelled {
        background-color: #DC2626;
    }

    .status-pending {
        background-color: #D97706;
    }

    .action-pay {
        background-color: #bd1e19;
    }

    .action-download {
        background-color: #4B5563;
    }

    .amount-with-icon {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 5px;
    }

    .scroll-container::-webkit-scrollbar {
        width: 8px;
    }

    .scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .scroll-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .invoice-card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .invoice-card:nth-child(even) {
        background-color: #f9fafb;
    }
</style>
        <div class="container mx-auto px-4 py-8 z-10 relative">
            <h1 class="text-3xl font-bold text-center mb-8">الفواتير</h1>

            <div class="mb-6 flex justify-end items-center w-full">
                <div class="flex items-center w-full max-w-xs">
                    <select id="statusFilter" class="p-2 w-full border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}">{{ $status }}</option>
                        @endforeach
                    </select>
                    <label for="statusFilter" class="min-w-[124px] font-medium mr-2">تصفية حسب الحالة</label>
                </div>
            </div>

            <div class="cards-container scroll-container">
                @foreach($bills as $bill)
                <div class="invoice-card" data-status="{{ $bill['status'] }}">
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between">
                            <span class="font-medium">رقم الفاتورة:</span>
                            <span>{{ $bill['id'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">التاريخ:</span>
                            <span>{{ $bill['date'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">الموضوع:</span>
                            <span>{{ $bill['subject'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">المبلغ:</span>
                            <div class="amount-with-icon">
                                {{ $bill['amount'] }}
                                <span class="text-sm">{{ strtoupper($bill['currency']) }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">الحالة:</span>
                            <span class="px-3 py-1 rounded-full text-white text-sm status-{{ str_replace(' ', '-', $bill['status']) }}">
                                {{ $bill['status'] }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">الإجراء:</span>
                            <!-- Debug output -->
                            <div class="hidden">
                                Bill ID: {{ $bill['id'] }}<br>
                                Action: {{ $bill['action'] }}<br>
                                Status: {{ $bill['status'] }}<br>
                                Route: {{ route('app.bills.pdf', $bill['id']) }}
                            </div>
                            <a href="{{ route('app.bills.pdf', $bill['id']) }}"
                               class="px-3 py-1 rounded text-white text-sm {{ $bill['action_class'] }}">
                               تحميل
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.getElementById('statusFilter').addEventListener('change', function () {
            const selectedStatus = this.value;
            const cards = document.querySelectorAll('.invoice-card');
            
            cards.forEach(card => {
                const status = card.getAttribute('data-status');
                if (selectedStatus === 'الكل' || status === selectedStatus) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection