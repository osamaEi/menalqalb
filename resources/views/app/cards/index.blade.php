@extends('app.index')

@section('content')
<div class="app white messagebox">
   
    <h1>{{__('Cards from the heart')}}</h1>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <div class="newMessage bg-black rounded-[15px] text-center my-2 w-[100%]">
                        <a href="{{ route('min-alqalb.cards.create') }}" class="text-white border-0">{{__('New request')}}</a>
                    </div>
                </div>

                <!-- Purchased Requests Table -->
                <div class="max-w-6xl mx-auto mt-6">
                    <div class="flex items-center justify-end mb-4 gap-3">
                        <select id="statusFilter" class="border border-gray-300 w-[100%] rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="all">{{__('All')}}</option>
                            <option value="available">{{__('Available')}}</option>
                            <option value="used">{{__('Used')}}</option>
                            <option value="canceled">{{__('Canceled')}}</option>
                        </select>
                        <span class="font-bold text-gray-700 min-w-[151px]">{{__('Filter by status:')}}</span>
                    </div>
                    <div class="overflow-x-auto bg-white rounded-lg shadow table-container">
                        <table id="dataTable" class="min-w-full divide-y divide-gray-200 sticky-header">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-right text-sm font-medium border-b">{{__('Status')}}</th>
                                    <th class="px-6 py-3 text-right text-sm font-medium border-b">{{__('Activation number')}}</th>
                                    <th class="px-6 py-3 text-right text-sm font-medium border-b">{{__('Number')}}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($ready_card_items as $item)
                                        <tr data-status="{{ $item->status }}" class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center">
                                                    <div class="w-6 h-6" title="{{ $item->status === 'open' ? __('Available') : ($item->status === 'closed' ? __('Used') : __('Canceled')) }}">
                                                        <img src="{{ asset($item->status === 'open' ? 'app/img/orange.png' : ($item->status === 'closed' ? 'app/img/green' : 'app/img/red.png')) }}" class="w-[30px]" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ $item->identity_number  }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ $item->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
    <ul class="Image_define" style="width: 438px;">
        <li>
            <img src="{{ asset('app/img/red.png') }}" alt="" class="img-fluid">
            <p for="txtReceived" class="localized" data-content="{{__('Canceled')}}"></p>
            <p for="txtReceived" class="localized" data-content="{{ $counts['canceled'] }}"></p>
        </li>
        <li>
            <img src="{{ asset('app/img/orange.png') }}" alt="" class="img-fluid">
            <p for="txtSent" class="localized" data-content="{{__('Used')}}"></p>
            <p for="txtSent" class="localized" data-content="{{ $counts['closed'] }}"></p>
        </li>
        <li>
            <img src="{{ asset('app/img/green.png') }}" alt="" class="img-fluid">
            <p for="txtRead" class="localized" data-content="{{__('Available')}}"></p>
            <p for="txtRead" class="localized" data-content="{{ $counts['open'] }}"></p>
        </li>
    </ul>
</div>
    <style>
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            position: relative;
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
        .header-logo {
            transition: transform 0.3s ease;
        }
        .header-logo:hover {
            transform: scale(1.05);
        }
        .page-title {
            position: relative;
        }
        .page-title::after {
            content: "";
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 60px;
            height: 4px;
            background-color: #B62326;
            border-radius: 2px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusFilter = document.getElementById('statusFilter');
            const tableRows = document.querySelectorAll('#dataTable tbody tr');

            statusFilter.addEventListener('change', filterTable);

            tableRows.forEach(row => {
                row.addEventListener('click', () => {
                    window.location.href = '{{ route("min-alqalb.cards.finish") }}';
                });
            });

            function filterTable() {
                const selectedStatus = statusFilter.value;
                tableRows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    if (selectedStatus === 'all' || selectedStatus === rowStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });

        setTimeout(() => {
            document.querySelectorAll('.notification').forEach(notification => notification.remove());
        }, 5000);
    </script>
</div>
@endsection