<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('message_front/img/logo.png')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('message_front/sass/style.css')}}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title> MIN ALQALB ❤ </title>
    <style>
        body {
            font-family: "Cairo", sans-serif;
        }
        
        /* Countdown styles */
        .countdown-container {
            background-color: #f9f9f9;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin: 20px auto;
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            direction: rtl;
        }

        .countdown-title {
            color: #B62326;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .countdown-date {
            font-size: 16px;
            color: #4B4B4B;
            margin-bottom: 20px;
        }

        .countdown-remaining {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .countdown-box {
            background-color: #B62326;
            color: white;
            border-radius: 8px;
            padding: 8px;
            min-width: 60px;
            text-align: center;
        }

        .countdown-value {
            font-size: 20px;
            font-weight: bold;
        }

        .countdown-label {
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<div id="rootElement" lang="en">

<body class="">
    @if($message->lock_type == 'lock_with_heart')
    <!-- Lock with heart view -->
    <div class="app">
        <div class="app formheartpage contactPage">
            <div class="header">
                <img src="{{ asset('message_front/img/black.png') }}" alt="" class="img-fluid logo">
                <img src="{{ asset('message_front/img/top.png') }}" alt="" class="img-fluid top">
                <img src="{{ asset('message_front/img/curve2.png') }}" alt="" class="img-fluid curveRight">
            </div>
            <img src="{{ asset('message_front/img/back2.png') }}" alt="" class="img-fluid bk">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4">
                    <div class="All_Button lang contact">
                        <h3 for="txtSetting" class="localized" data-content="ادخل رقم رمز القفل المرسل لك بالواتساب"></h3>
                        <div class="col-12 col-lg-4 ">
                            <div class="All_Button lang sign Login">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <img src="{{ asset('message_front/img/input.png') }}" alt="" class="img-fluid">
                                        <input type="text" name="code[]" placeholder="🖤" maxlength="1" required>
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ asset('message_front/img/input.png') }}" alt="" class="img-fluid">
                                        <input type="text" name="code[]" placeholder="🖤" maxlength="1" required>
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ asset('message_front/img/input.png') }}" alt="" class="img-fluid">
                                        <input type="text" name="code[]" placeholder="🖤" maxlength="1" required>
                                    </div>
                                    <div class="form-group">
                                        <img src="{{ asset('message_front/img/input.png') }}" alt="" class="img-fluid">
                                        <input type="text" name="code[]" placeholder="🖤" maxlength="1" required>
                                    </div>
                                    <button type="submit" class="border-0 flex items-center justify-center mx-auto text-[18px] !mt-0 w-100 z-[999999] !bg-black text-white p-2 rounded-[15px] hover:bg-white hover:text-black">تنفيذ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="app white messagebox">
            <div class="header">
                <a href="mailbox.html" class="icondoor"><i class="fas fa-arrow-alt-circle-left"></i></a>
                <a href="index.html"><img src="{{ asset('message_front/img/black.png')}}" alt="" class="img-fluid logo"></a>
                <img src="{{ asset('message_front/img/curve.png')}}" alt="" class="img-fluid curve">
                <img src="{{ asset('message_front/img/curve2.png')}}" alt="" class="img-fluid curveRight">
            </div>
            <img src="{{ asset('message_front/img/back2.png')}}" alt="" class="img-fluid bk">

            <div class="row justify-content-center overflow-y-auto">
                <div class="col-12 col-lg-4 ">
                    <div class="All_Button lang Devices w-[100%] h-[100%]">
                        <div class="w-[100%] h-[93%]">
                            <div class="rounded-lg w-[100%] h-[100%] px-0 pb-8 w-full">
                                <!-- Check scheduled time for lock_without_heart type -->
                                @if($message->lock_type == 'lock_without_heart' && isset($message->scheduled_at) && $message->scheduled_at > now())
                                    <!-- Show countdown timer -->
                                    <div class="countdown-container">
                                        <div class="countdown-date">
                                            تاريخ ووقت عرض التهنئة
                                            <br />
                                            <span id="eventDate">{{ $message->scheduled_at->format('d/m/Y h:i a') }}</span>
                                        </div>
                                        <div class="countdown-remaining">
                                            باقي عن العرض
                                        </div>
                                        <div class="countdown-timer flex items-center justify-between flex-col">
                                            <div class="gap-2 flex items-center justify-between">
                                                <div class="countdown-box">
                                                    <div id="years" class="countdown-value">00</div>
                                                    <div class="countdown-label">سنة</div>
                                                </div>
                                                <div class="countdown-box">
                                                    <div id="months" class="countdown-value">00</div>
                                                    <div class="countdown-label">شهر</div>
                                                </div>
                                                <div class="countdown-box">
                                                    <div id="days" class="countdown-value">00</div>
                                                    <div class="countdown-label">يوم</div>
                                                </div>
                                            </div>

                                            <div class="gap-2 flex items-center justify-between">
                                                <div class="countdown-box">
                                                    <div id="hours" class="countdown-value">00</div>
                                                    <div class="countdown-label">ساعة</div>
                                                </div>
                                                <div class="countdown-box">
                                                    <div id="minutes" class="countdown-value">00</div>
                                                    <div class="countdown-label">دقيقة</div>
                                                </div>
                                                <div class="countdown-box">
                                                    <div id="seconds" class="countdown-value">00</div>
                                                    <div class="countdown-label">ثانية</div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="font-bold mt-4">
                                            المرسل
                                            <br />
                                            {{ $message->sender_name ?? 'من القلب' }}
                                        </p>
                                    </div>
                                @else
                                    <!-- Show actual content -->
                                    @if($message->dedication_type_id == 1)
                                        <img class="w-full mx-auto pb-4" src="{{ asset('storage/' . $card->file_path) }}" alt="Greeting card">
                                    @elseif($message->dedication_type_id == 3)
                                        <video class="w-full mx-auto pb-4" controls>
                                            <source src="{{ asset('storage/' . $card->file_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @elseif($message->dedication_type_id == 2)
                                        <img class="w-full mx-auto pb-4" src="{{ asset('storage/' . $card->file_path) }}" alt="Animated greeting card">
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="Image_define">
                <li>
                    <img src="{{ asset('message_front/img/green.png')}}" alt="" style="visibility: hidden;" class="img-fluid">
                    <a href="https://minalqalb.ae/">
                        <p for="txtReceived" class="!text-[16px] relative bottom-[11px] localized" data-content="موقع من القلب"></p>
                    </a>
                </li>
                <li>
                    <img src="{{ asset('message_front/img/red.png')}}" alt="" style="visibility: hidden;" class="img-fluid">
                    <a href="congrats_step2.html">
                        <p for="txtSent" class="!text-[16px] relative bottom-[11px] localized" data-content="الرد على التهنئة"></p>
                    </a>
                </li>
                <li>
                    <img src="{{ asset('message_front/img/orange.png')}}" alt="" style="visibility: hidden;" class="img-fluid">
                    <a href="congrats_step1.html">
                        <p for="txtRead" class="!text-[16px] relative bottom-[11px] localized" data-content="التهنئة "></p>
                    </a>
                </li>
            </ul>
        </div>
    @endif

    <!-- JavaScript for countdown -->
    <script>
        // Set the target date from the message scheduled_at (for lock_without_heart only)
        @if($message->lock_type == 'lock_without_heart' && isset($message->scheduled_at) && $message->scheduled_at > now())
            const targetDate = new Date('{{ $message->scheduled_at->format('Y-m-d\TH:i:s') }}');

            // Update countdown every second
            function updateCountdown() {
                const currentDate = new Date();
                const difference = targetDate - currentDate;

                // Calculate remaining time
                const years = Math.floor(difference / (1000 * 60 * 60 * 24 * 30 * 12));
                const months = Math.floor((difference % (1000 * 60 * 60 * 24 * 30 * 12)) / (1000 * 60 * 60 * 24 * 30));
                const days = Math.floor((difference % (1000 * 60 * 60 * 24 * 30)) / (1000 * 60 * 60 * 24));
                const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                // Update display
                document.getElementById('years').innerHTML = years.toString().padStart(2, '0');
                document.getElementById('months').innerHTML = months.toString().padStart(2, '0');
                document.getElementById('days').innerHTML = days.toString().padStart(2, '0');
                document.getElementById('hours').innerHTML = hours.toString().padStart(2, '0');
                document.getElementById('minutes').innerHTML = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').innerHTML = seconds.toString().padStart(2, '0');

                // If countdown is over
                if (difference < 0) {
                    clearInterval(interval);
                    document.getElementById('years').innerHTML = '00';
                    document.getElementById('months').innerHTML = '00';
                    document.getElementById('days').innerHTML = '00';
                    document.getElementById('hours').innerHTML = '00';
                    document.getElementById('minutes').innerHTML = '00';
                    document.getElementById('seconds').innerHTML = '00';
                    
                    // Reload page to show content
                    location.reload();
                }
            }

            // Update countdown immediately
            updateCountdown();

            // Update countdown every second
            const interval = setInterval(updateCountdown, 1000);
        @endif

        // Auto-focus the first input field for the lock with heart code
        @if($message->lock_type == 'lock_with_heart')
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('input[name="code[]"]');
                
                // Focus first input
                if (inputs.length > 0) {
                    inputs[0].focus();
                }
                
                // Auto-focus next input when typing
                inputs.forEach((input, index) => {
                    input.addEventListener('input', function() {
                        if (input.value.length === 1 && index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    });
                    
                    // Allow backspace to go to previous input
                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                            inputs[index - 1].focus();
                        }
                    });
                });
            });
        @endif
    </script>
</body>

</html>