<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="{{asset('app/img/logo.png')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('app/sass/style.css')}}" rel="stylesheet">
    <!-- <link href="sass/style-ar.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title> MIN ALQALB ❤ من القلب </title>
    <style>
        body,
        html {
            font-family: 'Cairo' !important;
        }

        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
        }

        .flag-icon {
            width: 40px;
            height: 24px;
            background-size: cover;
        }
    </style>
</head>

<div id="rootElement" lang="en">
                <img src="{{asset('app/img/curve2.png')}}" class="z-50 w-[106px] absolute" alt="">

    <a href="{{ route('app.home')}}" class="z-50 !p-2 !absolute left-0 !mt-2 icondoor">
            <i class="fas fa-arrow-alt-circle-left text-white text-[19px] pl-3 w-[65px]"></i>
    </a>

    <body class="">

        <div class="app white messagebox">
            <div class="header mb-0">
                <a href="#"><img src="{{asset('app/img/black.png')}}" alt="" class="img-fluid logo"></a>
            </div>
            <!-- <img src="img/back2.png" alt="" class="img-fluid bk"> -->
            <p
                class="text-center text-[16px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B] z-50 mt-0 relative">
                ارسال تهنئة جديدة
            </p>
            <img src="{{asset('app/img/step5.png')}}" class="w-[303px] mx-auto" alt="">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4 ">
                    <div class="All_Button lang Devices">
                        <div>
                            <div class="rounded-lg  px-0 pb-8 w-full">
                                <img src="{{asset('app/img/success.svg')}}" class="mx-auto" alt="">
                                <h1 class="text-[24px] text-[#242424] font-[900] z-50 relative my-4">تهانيا!</h1>
                                <p class="text-center !pb-0 text-[18px] leading-[29px] max-w-[327px] mx-auto font-[400] text-[#4B4B4B]
                                    z-50 mt-4 relative">
                                    تم اعداد التهنئة </p>
                                <p class="text-center text-[18px] leading-[29px] max-w-[327px] mb-4 mx-auto font-[400] text-[#4B4B4B]
                                                                    z-50 relative">
                                    تم خصم 200 نقطة رسوم لبطاقة التهنة </p>

                                <a href="#" type="submit"
                                    class="!m-0 !h-[55px] !text-[18px] !w-[100%] mt-0 !mb-3 !font-[500] flex items-center justify-center 
                                                                            !bg-[#000] border-0 text-white font-bold
                                                                            !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                                                                            focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                    لوحة التحكم
                                </a>
                                <a href="{{ route('app.home')}}" type="submit"
                                    class="!m-0 !h-[55px] !text-[18px] !w-[100%] mt-0 !font-[500] flex items-center justify-center 
                                                                                                            !bg-[#B62326] text-white font-bold
                                                                                                            !rounded-full font-bold hover:bg-[#B62326]-700 transition-colors 
                                                                                                            focus:outline-none focus:ring-2 focus:ring-[#B62326]-500 focus:ring-offset-2">
                                    الرئيسية
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>