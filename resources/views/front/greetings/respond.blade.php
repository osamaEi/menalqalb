<!DOCTYPE html>
<html lang="ar" dir="rtl">

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

        /* تنسيق حقل الكتابة */
        .message-input {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 15px;
            padding: 10px 15px;
            min-height: 100px;
            margin-bottom: 15px;
            font-size: 16px;
            resize: none;
            direction: rtl;
            text-align: right;
        }

        .message-input:focus {
            outline: none;
            border-color: #B62326;
        }

        /* تنسيق زر الإرسال */
        .send-button {
            background-color: #B62326 !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
            font-size: 16px !important;
            font-weight: bold !important;
            cursor: pointer !important;
            display: block !important;
            margin: 0 auto !important;
            width: 200px !important;
            text-align: center !important;
        }

        /* تنسيق النافذة المنبثقة */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999999999999999999999;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            max-width: 90%;
            width: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.3s;
            direction: rtl;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #999;
        }

        .popup-icon {
            color: #B62326;
            font-size: 48px;
            margin-bottom: 15px;
        }

        .popup-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .popup-message {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
        }

        .popup-button {
            background-color: #B62326;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="app white messagebox">
        <div class="header">
            <a href="{{ route('greetings.front.show', $cardItem->unique_identifier) }}" class="icondoor"><i class="fas fa-arrow-alt-circle-left"></i></a>
            <a href="index.html"><img src="{{ asset('message_front/img/black.png') }}" alt="" class="img-fluid logo"></a>
            <img src="{{ asset('message_front/img/curve.png') }}" alt="" class="img-fluid curve">
            <img src="{{ asset('message_front/img/curve2.png') }}" alt="" class="img-fluid curveRight">
        </div>
        <img src="{{ asset('message_front/img/back2.png') }}" alt="" class="img-fluid bk">

        <div class="row justify-content-center overflow-y-auto">
            <div class="col-12 col-lg-4">
                <div class="All_Button lang Devices">
                    <div>
                        <div class="rounded-lg px-0 pb-8 w-full">
                            <!-- حقل الكتابة الجديد -->
                            <form action="{{ route('message.respond.store', $cardItem->unique_identifier) }}" method="POST">
                                @csrf
                                <div class="max-w-[327px] mx-auto mt-6 z-50 relative">
                                    <label class="block text-center text-[16px] font-[600] text-[#4B4B4B] mb-2">
                                        اكتب بماذا تريد الرد على
                                    </label>
                                    <label class="block text-center text-[16px] font-[600] text-[#B62326] mb-2">
                                        {{ $message->sender_name }}
                                    </label>
                                    <textarea id="messageField" name="response" class="min-h-[300px] message-input"
                                        placeholder="اكتب رسالتك...">{{ old('response') }}</textarea>
                                    
                                    @if ($errors->has('response'))
                                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('response') }}</p>
                                    @endif
                                </div>

                                <!-- زر الإرسال الجديد -->
                                <div class="max-w-[327px] mx-auto mt-4 z-[9999999999] relative">
                                    <button type="submit" id="sendButton" class="send-button">
                                        إرسال الرسالة
                                    </button>
                                </div>
                            </form>

                            <!-- زر الرجوع -->
                            <div class="">
                                <a href="{{ route('greetings.front.show', $cardItem->unique_identifier) }}" type="submit"
                                    class="!absolute !bottom-0 !w-[91.8%] !mb-5 !m-0 !h-[55px] !text-[14px] mt-10 !font-[500] flex items-center justify-center border-0 !bg-[#000] text-white font-bold !rounded-full font-bold hover:bg-[#000]-700 transition-colors focus:outline-none focus:ring-2 focus:ring-[#000]-500 focus:ring-offset-2">
                                    الرجوع
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- رسالة تأكيد الإرسال (النافذة المنبثقة) -->
        @if(session('success'))
        <div class="popup-overlay" id="confirmationPopup" style="display: flex;">
            <div class="popup-content">
                <span class="popup-close" onclick="closePopup()">&times;</span>
                <div class="popup-icon">✓</div>
                <div class="popup-title">تم ارسال رسالتك إلي {{ $message->sender_name }}</div>
                <button class="popup-button" onclick="closePopup()">موافق</button>
            </div>
        </div>
        @endif
    </div>

    <!-- JavaScript -->
    <script>
        // إغلاق النافذة المنبثقة
        function closePopup() {
            document.getElementById('confirmationPopup').style.display = 'none';
            window.location.href = "{{ route('greetings.front.show', $cardItem->unique_identifier) }}";
        }

        // إغلاق النافذة المنبثقة عند النقر خارجها
        document.getElementById('confirmationPopup')?.addEventListener('click', function (event) {
            if (event.target === this) {
                closePopup();
            }
        });
    </script>
</body>

</html>