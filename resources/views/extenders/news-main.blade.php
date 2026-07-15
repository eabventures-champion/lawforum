<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="@yield('meta_description')"/>
        
        <title> 
            @hasSection('title')
                @yield('title')
            @else
                {{ setting('site.title') }}
            @endif
        </title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

        <link href="https://fonts.googleapis.com/css?family=B612+Mono|Cabin:400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/css-news/icomoon-style.css') }}">
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="{{ asset('css/css-news/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-news/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-news/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-news/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-news/jquery.fancybox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-news/bootstrap-datepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-news/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-news/aos.css') }}">
        <link href="{{ asset('css/css-news/jquery.mb.YTPlayer.min.css') }}" media="all" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/css-news/news-style.css') }}">

        @yield('assets') 

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174662621-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-174662621-1');
        </script>
        
    </head>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5e398d16298c395d1ce62ab4/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

        <div class="site-wrap">

            <div class="site-mobile-menu site-navbar-target">
                <div class="site-mobile-menu-header">
                    <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                    </div>
                </div>
                <div class="site-mobile-menu-body"></div>
            </div> 

            <div class="header-top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6 d-flex">
                            <a href="#" class="ml-auto d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black">
                                <span class="icon-menu h3"></span>
                            </a>
                        </div>
                       
                        <div class="col-6 d-block d-lg-none text-right"></div>
                        
                    </div>
                </div>
                
    
                <div class="site-navbar py-2 js-sticky-header site-navbar-target d-none pl-0 d-lg-block" role="banner">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <div class="mr-auto">
                                <nav class="site-navigation position-relative text-right" role="navigation">
                                    <ul class="site-menu main-menu js-clone-nav mr-auto d-none pl-0 d-lg-block">
                                        <span >
                                            <a href="/" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none; padding-left: 50px; padding-top: 5px; padding-bottom: 5px; transition: transform 0.2s ease; vertical-align: middle;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 1.6em; margin: 0; line-height: 1;"></i>
                <span style="font-size: 1.6em; font-weight: 800; letter-spacing: 0.5px; background: linear-gradient(to right, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Inter', sans-serif; margin: 0; line-height: 1.3;">Legals Forum</span>
            </a>
                                        </span>
                                        <!-- <li class="invisible">
                                            <a href="/Asia-News" class="nav-link text-left">Asia News</a>
                                        </li> -->
                                        @foreach($newsCategories as $newsCategory)
                                        <li class="active">
                                            <a href="/News/{{$newsCategory->name}}/{{$newsCategory->id}}" class="nav-link text-left">{{ $newsCategory->name }}</li></a>
                                        </li>
                                        @endforeach 
                                    </ul> 
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of news header -->  
            </div> 
            <!-- End of top header -->
            <!-- <div class="container-fluid"> -->
                @yield('content')
            <!-- </div> -->

            <!-- Newsletter Subcribe -->
            <div class="site-section-bottom subscribe bg-light">
                <div class="container">
                    <form action="#" class="row align-items-center">
                    <div class="col-md-5 mr-auto">
                        <h2>Newsletter Subcribe</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis aspernatur ut at quae omnis pariatur obcaecati possimus nisi ea iste!</p>
                    </div>
                    <div class="col-md-6 ml-auto">
                        <div class="d-flex">
                        <input type="email" class="form-control" placeholder="Enter your email">
                        <button type="submit" class="btn btn-secondary" ><span class="icon-paper-plane"></span></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- end of site site-wrap -->

        <!-- Footer -->
        <!-- <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright">
                            <p>
                                Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0.
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                All rights reserved 
                                | This template is made with
                                <i class="icon-heart text-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
                                Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- loader -->
        <div id="loader" class="show fullscreen">
            <svg class="circular" width="48px" height="48px">
                <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
                <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#ff5e15"/>
            </svg>
        </div>

        <!--scripts-->
        <script src="{{ asset('js/js-news/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery-migrate-3.0.1.min.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery-ui.js') }}"></script>
        <script src="{{ asset('js/js-news/popper.min.js') }}"></script>
        <script src="{{ asset('js/js-news/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/js-news/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery.stellar.min.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery.countdown.min.js') }}"></script>
        <script src="{{ asset('js/js-news/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery.easing.1.3.js') }}"></script>
        <script src="{{ asset('js/js-news/aos.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery.fancybox.min.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery.sticky.js') }}"></script>
        <script src="{{ asset('js/js-news/jquery.mb.YTPlayer.min.js') }}"></script> 
        <script src="{{ asset('js/js-news/main.js') }}"></script>

        
        @yield('scripts')

    </body>
</html>
