@extends('app.index')

@section('content')
<div class="app white messagebox">
   
    <h1 >البطاقات الخاصة</h1>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <!-- Buttons -->
                <div class="flex items-center justify-between">
          
                </div>

                <!-- Purchased Requests Table -->
                <div class="max-w-6xl mx-auto mt-6">
             
                    @foreach ($cards as $item)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Photo section covering top of card -->
        @if ($item->photo)
            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name_ar }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <span class="text-gray-500">بدون صورة</span>
            </div>
        @endif
        
        <!-- Content section -->
        <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $item->name_ar }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ $item->desc_ar }}</p>
            <div class="flex justify-between items-center">
                <p class="text-sm font-medium text-gray-700">
                    <span class="font-bold"></span> {{ $item->price }} درهم
                </p>

                <p class="text-sm font-medium text-gray-700">
                    <span class="font-bold"></span>الكمية {{ $item->points }} 
                </p>
            </div>
        </div>
    </div>
@endforeach
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