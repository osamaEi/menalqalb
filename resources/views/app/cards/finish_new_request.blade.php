@extends('app.index')

@section('content')
<div class="app white messagebox">


    <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative page-title text-center mt-4">إتمام الطلب</h1>

    <div class="overflow-y-auto max-h-[500px] px-4">
        <div class="card-details p-6 mb-6">
            <div class="flex flex-col space-y-6">
                <!-- Card Name -->
                <div class="flex justify-between items-center">
                    <p class="text-xl font-bold text-gray-800">{{ $locker->name_ar }}</p>
                    <p class="text-lg font-bold text-gray-700">: إسم البطاقة المختارة</p>
                </div>

                <!-- Divider -->
                <div class="border-b border-gray-200"></div>

                <!-- Amount -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <p class="text-xl font-bold text-gray-800 ml-2">{{ number_format($totalPrice, 2) }}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#17191C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6.5 11H18.5" stroke="#17191C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6.5 13H12.5H18.5" stroke="#17191C" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-gray-700">: المبلغ</p>
                </div>

                <!-- Divider -->
                <div class="border-b border-gray-200"></div>

                <!-- Desired Cards -->
                <div class="flex justify-between items-center">
                    <p class="text-xl font-bold text-gray-800">{{ $quantity }}</p>
                    <p class="text-lg font-bold text-gray-700">: عدد البطاقات المختارة</p>
                </div>
            </div>
        </div>

        <!-- Confirmation Button -->
        <form action="{{ route('min-alqalb.cards.purchase') }}" method="POST">
            @csrf
            <button type="submit" class="confirm-button w-[200px] mx-auto mt-[170px] h-14 rounded-full flex items-center justify-center text-center mb-4">
                <span class="text-white font-bold text-lg">تأكيد الدفع</span>
            </button>
        </form>

        <!-- Security Notice -->
        <div class="flex items-center justify-center text-center text-sm text-gray-500 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span>جميع المعاملات مشفرة وآمنة</span>
        </div>
    </div>

    <style>
        .card-details {
            background-color: #f8f8f8;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .confirm-button {
            background: linear-gradient(135deg, #B62326 0%, #8C1C1E 100%);
            transition: all 0.3s ease;
        }
        .confirm-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(182, 35, 38, 0.3);
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
</div>
@endsection