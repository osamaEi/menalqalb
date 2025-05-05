<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Print All Cards') }} - {{ __('Ready Card') }} #{{ $readyCard->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .print-header {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .print-title {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin: 0;
            margin-bottom: 10px;
        }
        .print-subtitle {
            font-size: 16px;
            color: #6c757d;
            margin: 0;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .card-container {
            width: 320px;
            height: 200px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        .card-header {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #343a40;
            margin: 0;
        }
        .card-id {
            font-size: 14px;
            color: #6c757d;
        }
        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-info {
            flex: 1;
        }
        .card-info p {
            margin: 5px 0;
            color: #495057;
        }
        .card-info .label {
            font-size: 12px;
            color: #6c757d;
        }
        .card-info .value {
            font-weight: bold;
            font-size: 16px;
        }
        .qr-code {
            width: 120px;
            height: 120px;
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-status {
            position: absolute;
            bottom: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-open {
            background-color: #d4edda;
            color: #155724;
        }
        .status-closed {
            background-color: #e2e3e5;
            color: #383d41;
        }
        .print-instructions {
            text-align: center;
            margin: 20px 0;
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .print-button {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .print-button:hover {
            background-color: #0a58ca;
        }
        @media print {
            body {
                background-color: white;
            }
            .print-instructions {
                display: none;
            }
            .print-header {
                box-shadow: none;
                padding: 10px;
                margin-bottom: 10px;
            }
            .cards-container {
                padding: 0;
            }
            .card-container {
                box-shadow: none;
                page-break-inside: avoid;
                margin: 10px;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrcode.js/lib/qrcode.min.js"></script>
</head>
<body>
    <div class="print-header">
        <h1 class="print-title">{{ __('Ready Card') }} #{{ $readyCard->id }}</h1>
        <p class="print-subtitle">{{ __('Customer') }}: {{ $readyCard->customer->name }} - {{ __('Total Cards') }}: {{ $items->count() }}</p>
    </div>
    
    <div class="print-instructions">
        <p>{{ __('Print all cards by pressing Ctrl+P or using the browser print option.') }}</p>
        <button class="print-button" onclick="window.print()">{{ __('Print All Cards') }}</button>
    </div>
    
    <div class="cards-container">
        @foreach($items as $item)
        <div class="card-container">
            <div class="card-header">
                <h2 class="card-title">{{ __('Ready Card') }}</h2>
                <span class="card-id">#{{ $item->identity_number }}</span>
            </div>
            <div class="card-body">
                <div class="card-info">
                    <p>
                        <span class="label">{{ __('Sequence Number') }}:</span><br>
                        <span class="value">{{ $item->sequence_number }}</span>
                    </p>
                    <p>
                        <span class="label">{{ __('Identity Number') }}:</span><br>
                        <span class="value">{{ $item->identity_number }}</span>
                    </p>
                    <p>
                        <span class="label">{{ __('Customer') }}:</span><br>
                        <span class="value">{{ $readyCard->customer->name }}</span>
                    </p>
                </div>
                <div class="qr-code qrcode-{{ $item->id }}"></div>
            </div>
            <div class="card-status {{ $item->status === 'open' ? 'status-open' : 'status-closed' }}">
                {{ $item->status === 'open' ? __('Open') : __('Closed') }}
            </div>
        </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Generate QR codes for all cards
            @foreach($items as $item)
            new QRCode(document.querySelector('.qrcode-{{ $item->id }}'), {
                text: "{{ $item->qr_code }}",
                width: 120,
                height: 120,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            @endforeach
            
            // Auto print after all QR codes are generated
            setTimeout(function() {
                window.print();
            }, 1000);
        });
    </script>
</body>
</html>