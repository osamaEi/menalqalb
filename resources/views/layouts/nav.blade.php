<nav class="navbar navbar-default navbar-white navbar-fixed-top top-menu">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">تبديل الملاحه</span>
                    <span class="icon-bar top-bar"></span>
                    <span class="icon-bar middle-bar"></span>
                    <span class="icon-bar bottom-bar"></span>
                </button>
                <a class="navbar-brand sayer_logo_color" href="{{ url('/') }}"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ url('/features') }}">{{ __('Our Card Features') }}</a></li>
                    <li><a href="{{ url('/where') }}">{{ __('Where to Find the Card') }}</a></li>
                    <li><a href="{{ url('/feeling') }}">{{ __('Learn About Card Recipients\' Feelings') }}</a></li>
                    <li><a href="{{ url('/contact') }}">{{ __('Contact Us') }}</a></li>
                    @if (Route::has('login'))
                        @auth
                        <li><a href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a></li>
                        @else
                        <li><a href="{{ url('/login') }}">{{ __('Login') }}</a></li>
                        @endif
                    @endauth
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            @if(app()->getLocale() == 'ar')
                                <span style="font-size: 18px; margin-right: 5px;">🇦🇪</span> {{ __('Arabic') }}
                            @else
                                <span style="font-size: 18px; margin-right: 5px;">🇺🇸</span> {{ __('English') }}
                            @endif
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('language.switch', 'ar') }}">
                                    <span style="font-size: 18px; margin-right: 5px;">🇦🇪</span> {{ __('Arabic') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('language.switch', 'en') }}">
                                    <span style="font-size: 18px; margin-right: 5px;">🇺🇸</span> {{ __('English') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="no_border vision-logo">
                        <a href="javascript:void(0)">
                            <img src="{{url('/site')}}/images/arab.png" />
                        </a>
                    </li>
                </ul>
            </div>
        </div><!-- END CONTAINER -->
    </nav>