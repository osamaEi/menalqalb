<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice #') }}{{ $bill->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Cairo', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #de162b;
        }
        
        .logo {
            height: 80px;
        }
        
        .invoice-title {
            color: #de162b;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .info-box {
            flex: 1;
        }
        
        .info-title {
            font-weight: 700;
            color: #555;
            margin-bottom: 5px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .table th {
            background-color: #de162b;
            color: white;
            padding: 12px;
            text-align: right;
        }
        
        .table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .total-row {
            font-weight: 700;
            background-color: #f0f0f0 !important;
        }
        
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
        }
        
        .status-paid {
            background-color: #059669;
            color: white;
        }
        
        .status-pending {
            background-color: #D97706;
            color: white;
        }
        
        .status-cancelled {
            background-color: #DC2626;
            color: white;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .watermark {
            position: fixed;
            bottom: 50%;
            right: 50%;
            transform: translate(50%, 50%) rotate(-30deg);
            opacity: 0.1;
            font-size: 80px;
            color: #de162b;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1 class="invoice-title">{{ __('Invoice #') }}{{ $bill->id }}</h1>
                <p>{{ __('Invoice date:') }} {{ $date }}</p>
            </div>
            <img src="{{ url('front/images/logo.png') }}" class="logo" alt="{{ __('Logo') }}">
        </div>
        
        <div class="invoice-info">
            <div class="info-box">
                <div class="info-title">{{ __('Client information') }}</div>
                <p>{{ $bill->user->name }}</p>
                <p>{{ $bill->user->email }}</p>
                @if($bill->user->phone)
                    <p>{{ $bill->user->phone }}</p>
                @endif
            </div>
            
            <div class="info-box">
                <div class="info-title">{{ __('Invoice status') }}</div>
                <span class="status status-{{ str_replace(' ', '-', $status) }}">{{ $status }}</span>
                
                @if($bill->payment)
                    <div style="margin-top: 15px;">
                        <div class="info-title">{{ __('Payment method') }}</div>
                        <p>{{ $bill->payment->method }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Quantity') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $subject }}</td>
                    <td>{{ $bill->quantity }}</td>
                    <td>{{ number_format($bill->amount / $bill->quantity, 2) }} {{ strtoupper($bill->currency) }}</td>
                    <td>{{ number_format($bill->amount, 2) }} {{ strtoupper($bill->currency) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" style="text-align: left;">{{ __('Grand total') }}</td>
                    <td>{{ number_format($bill->amount, 2) }} {{ strtoupper($bill->currency) }}</td>
                </tr>
            </tbody>
        </table>
        
        <div class="footer">
            <p>{{ __('Thank you for using our services') }}</p>
            <p>{{ __('For any inquiries, please contact technical support') }}</p>
            <p>Min AlQalb © {{ date('Y') }}</p>
        </div>
        
        <div class="watermark">Min AlQalb</div>
    </div>
    <div style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="
            background-color: #de162b;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        ">
            {{ __('Print Invoice') }}
        </button>
    </div>
    
</body>
</html>