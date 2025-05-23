<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('app/img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap" rel="stylesheet">
    <title>الفواتير</title>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
            position: relative;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .sticky-header thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #de162b;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .sticky-header {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
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
            background-color: #2563EB;
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
    </style>
</head>

<body class="bg-gray-100">
    <div class="app white messagebox relative min-h-screen">
        <div class="header relative">
            <a href="{{ url('/dashboard') }}" class="icondoor absolute right-4 top-4 text-2xl text-gray-700">
                <i class="fas fa-arrow-alt-circle-left"></i>
            </a>
            <a href="{{ url('/') }}" class="flex justify-center">
                <img src="{{ asset('app/img/black.png') }}" alt="Logo" class="img-fluid logo w-32">
            </a>
            <img src="{{ asset('app/img/curve2.png') }}" alt="Curve" class="img-fluid curveRight absolute right-0 top-0 w-1/3">
        </div>
        <img src="{{ asset('app/img/back2.png') }}" alt="Background" class="img-fluid bk absolute inset-0 w-full h-full object-cover opacity-10">

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

            <div class="table-container scroll-container">
                <table class="sticky-header text-right w-full">
                    <thead>
                        <tr>
                            <th class="border border-gray-200 px-4 py-3">رقم الفاتورة</th>
                            <th class="border border-gray-200 px-4 py-3">التاريخ</th>
                            <th class="border border-gray-200 px-4 py-3">الموضوع</th>
                            <th class="border border-gray-200 px-4 py-3">المبلغ</th>
                            <th class="border border-gray-200 px-4 py-3">الحالة</th>
                            <th class="border border-gray-200 px-4 py-3">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTableBody">
                        @foreach($bills as $bill)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="border border-gray-200 px-4 py-3">{{ $bill['id'] }}</td>
                            <td class="border border-gray-200 px-4 py-3">{{ $bill['date'] }}</td>
                            <td class="border border-gray-200 px-4 py-3">{{ $bill['subject'] }}</td>
                            <td class="border border-gray-200 px-4 py-3">
                                <div class="amount-with-icon">
                                    {{ $bill['amount'] }}
                                    <span class="text-sm">{{ strtoupper($bill['currency']) }}</span>
                                </div>
                            </td>
                            <td class="border border-gray-200 px-4 py-3 min-w-[151px]">
                                <span class="px-3 py-1 rounded-full text-white text-sm status-{{ str_replace(' ', '-', $bill['status']) }}">
                                    {{ $bill['status'] }}
                                </span>
                            </td>
                            <td class="border border-gray-200 px-4 py-3 min-w-[156px]">
                                    <!-- Debug output -->
                                    <div class="hidden">
                                        Bill ID: {{ $bill['id'] }}<br>
                                        Action: {{ $bill['action'] }}<br>
                                        Status: {{ $bill['status'] }}<br>
                                        Route: {{ route('app.bills.pdf', $bill['id']) }}
                                    </div>
                                    
                                    <a href="{{ route('app.bills.pdf', $bill['id']) }}" 
                                       class="px-3 py-1 rounded text-white text-sm {{ $bill['action_class'] }}">
                                        {{ $bill['action'] }}
                                    </a>
                           
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('statusFilter').addEventListener('change', function () {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('#invoiceTableBody tr');
            
            rows.forEach(row => {
                const statusCell = row.querySelector('td:nth-child(5) span');
                if (selectedStatus === 'الكل' || statusCell.textContent === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>