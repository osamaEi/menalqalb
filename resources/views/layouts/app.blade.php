<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" sizes="16x16" href="img/favicon.svg">

    <!-- SITE TITLE -->
    <title>||من القلب::Min Al Qalb||</title>
    <!-- Bootstrap min CSS -->
    <link href="{{ asset('front/Content/vendor/bootstrap.min.css')}}" rel="stylesheet">

    <!-- RTL CSS - Only load for Arabic -->
    @if(app()->getLocale() == 'ar')
    <link href="{{ asset('front/Content/vendor/bootstrap-rtl.min.css')}}" rel="stylesheet">
    <link href="{{ asset('front/Content/vendor/bootstrap-rtl/bootstrap-rtl.css')}}" rel="stylesheet">
    <link href="{{ asset('front/Content/vendor/bootstrap-rtl/custom-bootstrap-rtl.css')}}" rel="stylesheet">
    <link href="{{ asset('front/Content/custom-rtl.css')}}" rel="stylesheet">
    @endif

    <!-- Animate CSS -->
    <link href="{{ asset('front/Content/vendor/animate.css')}}" rel="stylesheet">
    <!-- Icofont CSS -->
    <link href="{{ asset('front/Content/vendor/icofont.css')}}" rel="stylesheet">
    <!-- Owl Carouse CSS -->
    <link href="{{ asset('front/Content/vendor/owl.carousel.css')}}" rel="stylesheet">
    <!-- Magnific Popup CSS -->
    <link href="{{ asset('front/Content/vendor/magnific-popup.css')}}" rel="stylesheet">
    <!-- Style CSS -->
    <link href="{{ asset('front/Content/style.css')}}" rel="stylesheet">
    <!-- Responsive CSS -->
    <link href="{{ asset('front/Content/responsive.css')}}" rel="stylesheet">
    <!-- custom CSS -->
    <link href="{{ asset('front/Content/custom.css')}}" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('front/Scripts/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="appconfig.html"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('front/Scripts/vendor/bootstrap.min.js')}}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('front/Scripts/vendor/owl.carousel.min.js')}}"></script>
    <!-- Jquery Counterup JS -->
    <script src="{{ asset('front/Scripts/vendor/jquery.counterup.min.js')}}"></script>
    <!-- Waypoints JS -->
    <script src="{{ asset('front/Scripts/vendor/waypoints.min.js')}}"></script>
    <!-- jquery.magnific-popup JS -->
    <script src="{{ asset('front/Scripts/vendor/jquery.magnific-popup.min.js')}}"></script>
    <!-- Parsley JS -->
    <script src="{{ asset('front/Scripts/vendor/parsley.min.js')}}"></script>
    <!-- Jquery Particleground JS -->
    <script src="{{ asset('front/Scripts/vendor/jquery.particleground.min.js')}}"></script>
    <!-- Custom JS -->
    <script src="{{ asset('front/Scripts/custom.js')}}"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <script type="text/javascript">
        $(document).ready(function () {
            @if(app()->getLocale() == 'ar')
            // For Arabic
            $('.nav.navbar-nav').removeClass('navbar-right');
            $('body').css('font-family', 'Cairo, Segoe UI');
            $('p').css('font-family', 'Cairo, Segoe UI');
            @else
            // For English
            $('.nav.navbar-nav').addClass('navbar-right');
            @endif
        });
    </script>
</head>

<style>
body {
  font-family: 'Cairo', sans-serif !important;
}
</style>

<body data-spy="scroll" data-offset="70" class="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    @yield('head')
    @yield('content')

    <!-- START FOOTER AREA -->
    <footer id="footer">
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <p>{{ __('Designed happily by 😉 CODER') }}</p>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <ul class="social-links">
                            <li>{{ __('Follow us') }}:</li>
                            <li><a href="#"><i class="icofont icofont-social-facebook"></i></a></li>
                            <li><a href="#"><i class="icofont icofont-social-instagram"></i></a></li>
                            <li><a href="#"><i class="icofont icofont-web"></i></a></li>
                        </ul>
                    </div>
                </div><!-- END ROW -->
            </div><!-- END CONTAINER -->
        </div><!-- END FOOTER BOTTOM -->
    </footer>
    <!-- END FOOTER AREA -->

</body>
</html>