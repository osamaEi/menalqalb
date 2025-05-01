@extends('layouts.app')
@section('head')
{{-- {{ Session::get('locale') }} --}}
   <!-- START NAVBAR -->
  
             @include('layouts.nav')
   
    <!-- END NAVBAR -->

@endsection
@section('content')

<!-- START HOMEPAGE SLIDER -->
<div id="home" class="hompage-slides-wrapper gradient-bg angle-slides-wrapper-bg">
    <div class="homepage-slides">
        <div class="single-slider-item">
            <div class="slide-item-table">
                <div class="slide-item-tablecell">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8 col-md-8">
                                <h1>{{ __('An electronic card that acts as a bridge for communication from the heart') }}</h1>
                                
                            </div><!-- END COL -->

                            <div class="col-sm-4 col-md-4">
                                <div class="welcome-phone">
                                    <img src="{{url('/site')}}/images/img_home_banner.png" alt="{{ __('App mockup Image') }}">
                                </div>
                            </div><!-- END COL -->
                        </div><!-- END ROW -->
                    </div><!-- END CONTAINER -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END HOMEPAGE SLIDER -->
<!-- START APP ABOUT SECTION -->
<section id="about" class="app-about-section angle-sp">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title angle-section-title">
                    <h2>{{ __('From the Heart Cards Features') }}</h2>
                    <h4 class="about_section_subtitle">{{ __('We strive for excellence by serving users of our innovations, so we have encrypted the gift cards with a specific time and limited number of views chosen by the card creator, after which it is completely erased from the databases') }}</h4>
                </div>
            </div><!-- END COL -->
        </div><!-- END ROW -->

        <div class="row">
            <div class="col-md-7">
                <div class="app-about-text">
                    <p>{{ __('We are on a mission to make the site a bridge that delivers messages from the heart and spreads happiness') }}</p>
                    <p>
                        {{ __('Through our services, we seek to satisfy the customer and make them confident in our services and completely satisfied') }}
                    </p>

                    <ul>
                        <li style="font-family:'Segoe UI'"><i class="icofont icofont-verification-check"></i>{{ __('Creativity') }}</li>
                        <li style="font-family:'Segoe UI'"><i class="icofont icofont-verification-check"></i>{{ __('Information Protection') }}</li>
                        <li style="font-family:'Segoe UI'"><i class="icofont icofont-verification-check"></i>{{ __('Satisfied Customer') }}</li>
                    </ul>

                    <a href="#app-download" class="default-button">
                        <center>
                            <i class="icofont icofont-download-alt"></i>
                            {{ __('Apply to become a sales outlet for cards') }}<br />
                            <span style="font-size:8pt;color:black;">{{ __('Be distinctive') }}</span>
                        </center>
                    </a>
                </div>
            </div><!-- END COL -->

            <div class="col-md-5">
                <div class="text-center">
                    <img src="{{url('/site')}}/images/new.png" alt="{{ __('App Mockup') }}">
                </div>
            </div><!-- END COL -->
        </div><!-- END ROW -->
    </div><!-- END CONTAINER -->
</section>
<!-- END APP ABOUT SECTION -->
<!-- START HOW IT WORKS SECTION -->
<section id="how-it-works" class="how-it-works angle-gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>{{ __('How the Card Works') }}</h2>
                    <p>{{ __('Simple and easy ways accessible to everyone, just simple steps that enable you to prepare a distinctive card') }}</p>
                </div>
            </div><!-- END COL -->
        </div><!-- END ROW -->

        <div class="row">
            <div class="col-md-6">
                <div class="hiw-feature-content">
                    <div class="single-hiw-feature">
                        <i class="icofont icofont-card"></i>
                        <h4>{{ __('Purchase the card from one of the sales outlets') }}</h4>
                        <p>{{ __('Browse the Where to Find the Card section to know the card sales outlets') }}</p>
                    </div>

                    <div class="single-hiw-feature">
                        <i class="icofont icofont-qr-code"></i>
                        <h4>{{ __('Read the code on the card and then enter the activation code') }}</h4>
                        <p>{{ __('Each purchased card has an activation code at the sales outlet') }}</p>
                    </div>

                    <div class="single-hiw-feature">
                        <i class="icofont icofont-music-notes"></i>
                        <h4>{{ __('Choose the occasion to determine the type of card and then choose your card') }}</h4>
                        <p>
                            {{ __('Hundreds of types and forms are available to suit everyone\'s taste') }}
                        </p>
                    </div>

                    <div class="single-hiw-feature">
                        <i class="icofont icofont-multimedia"></i>
                        <h4>{{ __('You can ask the recipient to send their feeling upon receiving the card and you can also inquire about the status of the card') }}</h4>
                        <p>
                            {{ __('Cards are encrypted and sent, and they are canceled and deleted after viewing. The recipient can keep a copy of the card as a video or image on their phone.') }}
                        </p>
                    </div>
                </div>
            </div><!-- END COL -->


        </div><!-- END ROW -->
    </div><!-- END CONTAINER -->
</section>
<!-- END HOW IT WORKS SECTION -->
<!-- START sayer Now SECTION -->
<section id="about" class="app-about-section angle-sp pt100">
    <div class="container">

        <div class="row">
            <div class="col-md-7">
                <div class="app-about-text third_section_text">
                    <img src="{{url('/site')}}/images/logo.png" class="app-about_logo" />
                    <h3>{{ __('Why We Chose the Name') }}</h3>
                    <p>
                        {{ __('At Coder company, we wanted the recipient to receive a gift with a card that increases happiness, and there\'s nothing better than the phrase "From the Heart," so we adopted the name to be the launch of our system and our creativity in providing the electronic card service') }}
                    </p>
                </div>
            </div><!-- END COL -->

            <div class="col-md-5">
                <div class="text-center">
                    <img src="{{url('/site')}}/images/img_section1.png" alt="" class="now_section_img">
                </div>
            </div><!-- END COL -->
        </div><!-- END ROW -->
    </div><!-- END CONTAINER -->
</section>


<!-- END sayer Now SECTION -->
<!-- START APP DOWNLOAD SECTION -->
<section id="app-download" class="app-download-section angle-download-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>{{ __('What You Want to Be') }}</h2>
                    <h4>{{ __('Simple ways to order the card or apply to be a sales outlet') }}</h4>
                    
                </div>
            </div><!-- END COL -->
        </div><!-- END ROW -->

        <div class="row">
            <div class="col-md-12">
                <div class="app-download-content">
                    <!-- START APP STORE -->
                    <a href="#" class="download-btn">
                        <i class="icofont icofont-pay"></i>
                        <span>
                            {{ __('Apply to become') }}
                            <span class="large-text">{{ __('New Sales Outlet') }}</span>
                        </span>
                    </a>
                    <!-- END APP STORE -->
                    <!-- START PLAY STORE -->
                    <a href="#" class="download-btn">
                        <i class="icofont icofont-money-bag"></i>
                        <span>
                            {{ __('Purchase and Order') }}
                            <span class="large-text">{{ __('New Cards') }}</span>
                        </span>
                    </a>
                    <!-- END PLAY STORE -->
                </div>
            </div><!-- END COL -->
        </div><!-- END ROW -->
    </div><!-- END CONTAINER -->
</section>
<!-- END APP DOWNLOAD SECTION -->
<!-- START BLOG SECTION -->
<section id="blog" class="blog-section angle-sp">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2>{{ __('Distinctive and Creative Idea') }}</h2>
                    <p>{{ __('From Coder') }}</p>
                </div>
            </div><!-- END COL -->
        </div><!-- END ROW -->

    </div><!-- END CONTAINER -->
</section>
<!-- END BLOG SECTION -->

@endsection