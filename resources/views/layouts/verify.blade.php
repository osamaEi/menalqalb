<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ url('/verify') }}/sass/style.css" rel="stylesheet">
    <!-- <link href="sass/style-ar.css" rel="stylesheet"> -->
   <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title> MIN ALQALB ❤ من القلب </title>
    @yield("header")
</head>

<!-- <Transleat code Start> -->


<div id="rootElement" lang="en">
	
<!-- <Transleat code End> -->

<body class="">
    <div class="app white messagebox" id="app">
        <div class="header">
            @yield("arror_return")
          <a href="{{ url('/') }}"><img src="{{ url('/verify') }}/img/black.png" alt="" class="img-fluid logo"></a>
            <img src="{{ url('/verify') }}/img/curve.png" alt="" class="img-fluid curve">
            <img src="{{ url('/verify') }}/img/curve2.png" alt="" class="img-fluid curveRight">
        </div>
        <img src="{{ url('/verify') }}/img/back2.png" alt="" class="img-fluid bk">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-4 ">
                    @yield('content')
            </div>
        </div>
    </div>
        <script src="{{ url('/verify') }}/sass/components/js/jquery-3.3.1.slim.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
        <script src="{{ url('/verify') }}/sass/components/js/popper.min.js"></script>
        <script src="{{ url('/verify') }}/sass/components/js/select2.full.js"></script>
        <script src="{{ url('/verify') }}/sass/components/js/select.js"></script>
        <script src="{{ url('/verify') }}/sass/components/js/bootstrap.min.js"></script>
        <script src="{{ url('/verify') }}/sass/components/js/script.js"></script>
        <script>
            $(document).ready(function () {
                $("select.js-select2").select2({theme: 'classic'});

            });
        </script>
</body>
@yield("footer")
</html>