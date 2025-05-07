<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{ asset('message_front/img/logo.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('message_front/sass/style.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title> MIN ALQALB ❤ </title>
    <style>
        body {
            font-family: "Cairo", sans-serif;
        }

        .app {
            position: relative;
            min-height: 100vh;
            background-color: white;
            overflow: hidden;
        }

        .header {
            position: relative;
            height: 150px;
            background: linear-gradient(135deg, #f0f0f0, #ffffff);
        }

        .message-card {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
            border-radius: 20px;
            background: linear-gradient(to bottom right, #ffffff, #f9f9f9);
            border: 1px solid #eaeaea;
        }

        .message-text {
            line-height: 1.8;
        }

        .decorative-element-1 {
            position: absolute;
            top: 50px;
            right: 20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(45deg, #f5f5f5, #e0e0e0);
            opacity: 0.7;
            z-index: 0;
        }

        .decorative-element-2 {
            position: absolute;
            bottom: 80px;
            left: 30px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(45deg, #f5f5f5, #e0e0e0);
            opacity: 0.5;
            z-index: 0;
        }

        .graduation-cap {
            font-size: 2.5rem;
            color: #4B4B4B;
            margin-bottom: 1rem;
        }

        .lock-code {
            font-family: 'Cairo', sans-serif;
            letter-spacing: 3px;
            font-weight: 700;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="">
    <div class="app white messagebox">
        <div class="header">
            <a href="{{ route('greetings.front.show', $cardItem->unique_identifier) }}" class="icondoor">
                <i class="fas fa-arrow-alt-circle-left"></i>
            </a>
            <a href="index.html"><img src="{{ asset('message_front/img/black.png') }}" alt="" class="img-fluid logo"></a>
            <img src="{{ asset('message_front/img/curve.png') }}" alt="" class="img-fluid curve">
            <img src="{{ asset('message_front/img/curve2.png') }}" alt="" class="img-fluid curveRight">
        </div>
        <img src="{{ asset('message_front/img/back2.png') }}" alt="" class="img-fluid bk">

        <div class="row justify-content-center overflow-y-auto">
            <div class="col-12 col-lg-4 ">
                <div class="All_Button lang Devices">
                    <div>
                        <div class="message-card p-8 mb-12">
                            <!-- Sender Name -->
                            <div class="flex items-center justify-between mb-6 pb-3 border-b border-gray-100">
                                <div class="text-sm text-gray-500">المرسل</div>
                                <div class="text-lg font-semibold text-gray-800">{{ $message->sender_name }}</div>
                            </div>

                            <!-- Congratulatory Message -->
                            <div class="mb-8">
                                <div class="text-sm text-gray-500 mb-2">رسالة التهنئة</div>
                                <p class="message-text text-lg font-medium text-gray-700 leading-relaxed">
                                    {{ $message->message_content }}
                                </p>
                            </div>

                            <!-- Lock Code - Only show for lock_with_heart type -->
                            @if($message->lock_type == 'lock_with_heart')
                            <div class="pt-4 border-t border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">رمز القفل</div>
                                    <div class="lock-code text-xl font-bold text-gray-800">
                                        {{ implode(' ', str_split($message->lock_number)) }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="rounded-lg px-0 pb-8 w-full">
                            <!-- Submit Button -->
                            <div class="">
                                <a href="{{ route('greetings.front.show', $cardItem->unique_identifier) }}" type="submit"
                                    class="!absolute !bottom-0 !w-[91.8%] !mb-5 !m-0 !h-[55px] !text-[14px] mt-10 !font-[500] flex items-center justify-center border-0
                                    !bg-[#000] text-white font-bold !rounded-full font-bold hover:bg-[#000]-700 transition-colors 
                                    focus:outline-none focus:ring-2 focus:ring-[#000]-500 focus:ring-offset-2">
                                    الرجوع
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>