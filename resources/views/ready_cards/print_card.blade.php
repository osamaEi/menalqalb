<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Print Card') }} #{{ $item->identity_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .card-container {
            width: 320px;
            height: 200px;
            margin: 40px auto;
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
        @media print {
            body {
                background-color: white;
            }
            .card-container {
                box-shadow: none;
                margin: 0 auto;
                page-break-after: always;
            }
            .print-instructions {
                display: none;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrcode.js/lib/qrcode.min.js"></script>
</head>
<body>
    <div class="print-instructions" style="text-align: center; margin: 20px 0;">
        <p>{{ __('Print this card by pressing Ctrl+P or using the browser print option.') }}</p>
        <button onclick="window.print()">{{ __('Print Card') }}</button>
    </div>
    
    <div class="card-container">
        <div class="card-header">
            <h1 class="card-title">{{ __('Ready Card') }}</h1>
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
                    <span class="value">{{ $item->readyCard->customer->name }}</span>
                </p>
            </div>
            <div class="qr-code" id="qrcode"></div>
        </div>
        <div class="card-status {{ $item->status === 'open' ? 'status-open' : 'status-closed' }}">
            {{ $item->status === 'open' ? __('Open') : __('Closed') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new QRCode(document.getElementById('qrcode'), {
                text: "{{ $item->qr_code }}",
                width: 120,
                height: 120,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            
            // Auto print
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>