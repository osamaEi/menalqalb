@extends('app.index')

@section('content')
<div class="app white messagebox">
    <h1 class="">أقفال من القلب</h1>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">
            <div class="All_Button lang Devices">
                <!-- Buttons -->
                <div class="flex items-center justify-between">
                    <!-- Add any buttons here if needed -->
                </div>

                <!-- Purchased Requests Cards -->
                <div class="max-w-6xl mx-auto mt-6">
                    <div class="flex items-center justify-end mb-4 gap-3">
                        <select id="statusFilter" class="border border-gray-300 w-[100%] rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="all">الكل</option>
                            <option value="available">متوفرة</option>
                            <option value="used">مستخدمة</option>
                            <option value="canceled">ملغية</option>
                        </select>
                        <span class="font-bold text-gray-700 min-w-[151px]">: تصفية حسب الحالة</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($locks as $request)
                            <div data-status="{{ $request->status == 'pending' ? 'available' : $request->status }}" class="bg-white rounded-lg shadow p-6 flex flex-col items-center hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('min-alqalb.lockers.finish') }}'">
                                @if ($request->photo)
                                    <img src="{{ asset('storage/' . $request->photo) }}" alt="Lock Image" class="w-24 h-24 object-cover rounded-full mb-4">
                                @else
                                    <img src="{{ asset($request->status == 'used' ? 'img/grean-l.png' : 'img/red-l.png') }}" alt="Status Icon" class="w-[30px] mb-4">
                                @endif
                                <h3 class="text-lg font-bold text-gray-800">{{ $request->name_ar ?? 'قفل' }}</h3>
                                <p class="text-sm text-gray-600">{{ $request->desc_ar ?? 'بدون وصف' }}</p>
                                <div class="mt-4 text-right w-full">
                                  
                                
                               
                                    @if ($request->price)
                                        <p class="text-sm font-medium text-gray-700">
                                            <span class="font-bold">السعر:</span> {{ $request->price }} ريال
                                        </p>
                                    @endif
                                
                            </div>
                        @endforeach
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

    <style>
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
        .header-logo {
            transition: transform 0.3s ease;
        }
        .header-logo:hover {
            transform: scale(1.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusFilter = document.getElementById('statusFilter');
            const cards = document.querySelectorAll('.grid > div');

            statusFilter.addEventListener('change', filterCards);

            function filterCards() {
                const selectedStatus = statusFilter.value;
                cards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    if (selectedStatus === 'all' || selectedStatus === cardStatus) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
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