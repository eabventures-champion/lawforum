<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <meta name="description" content="The HUB of all laws, and legislation, and amendments. This website is managed by a an elite of professionals."/>

        <title> 
            @hasSection('title')
                @yield('title') - {{ setting('site.title') }}
            @else
                {{ setting('site.title') }}
            @endif
        </title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('assets')
        @yield('scripts_first')
        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> --}}
        
        {{-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> --}}
        
        <!-- Latest compiled and minified CSS -->
        {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">         --}}
        <!-- Optional theme -->
        {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> --}}

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-size: 13px;
                height: 100vh;
                
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .top-left {
                position: absolute;
                left: 550px;
                top: 10px;
            }

            .top-left-enquiry {
                position: absolute;
                left: 950px;
                top: 15px;
            }


            .content {
                text-align: center;
            }

            .title {
                font-size: 60px;
                font-weight: 600;
            }

            .links > a {
                color: white;
                padding: 0 30px;
                font-size: 15px;
                font-weight: 800;
                /* letter-spacing: .2rem; */
                text-decoration: none;
                line-height: 2em;
                
                /* text-transform: uppercase; */
            }

            .m-b-md {
                margin-bottom: 30px;
                margin-top: 200px;
            }

            .bg1{
                background-image: url(home_background/parliament.jpg);
                -webkit-background-size: cover;
                background-size: cover;
                background-position: center;
                opacity: 0.5;
            }
            
            .bg2{
                background-image: url(home_background/hall.jpg);
                -webkit-background-size: cover;
                background-size: cover;
                background-position: center;
                opacity: 0.5;
            }

            .bg3{
                background-image: url(home_background/text_book.jpeg);
                -webkit-background-size: cover;
                background-size: cover;
                background-position: center;
                opacity: 0.5;
            }

            .bg4{
                background-image: url(home_background/scholar.jpg);
                -webkit-background-size: cover;
                background-size: cover;
                background-position: center;
                opacity: 0.5;
            }

            .carousel-caption{
                right: 20%;
                left: 20%;
                padding-bottom: 5%;
            }

            .carousel_button{
                padding-top: 420px;
            }

            .carousel-fade .carousel-inner .item{
                opacity: 0;
                transition-property: opacity;
                height: 72.5vh;
            }

            .carousel-fade .carousel-inner .active{
                opacity: 1;
            }
            .carousel-caption h1{
                font-size: 50px;
                font-family: Poppins;
            }
            .carousel-caption p{
                font-size: 25px;
                font-family: Poppins;
            }
            #target{
                font-size: 20px;
            }
            @media all and (transform-3d), (-webkit-transform-3d){
                .carousel-fade .carousel-inner > .item.next,
                .carousel-fade .carousel-inner > .item.active.right{
                    opacity: 0;
                    -webkit-transform: translate3d(0,0,0);
                    -moz-transform: translate3d(0,0,0);
                    -ms-transform: translate3d(0,0,0);
                    -o-transform: translate3d(0,0,0);
                    transform: translate3d(0,0,0);
                }

                .carousel-fade .carousel-inner > .item.prev,
                .carousel-fade .carousel-inner > .item.active.left{
                    opacity: 0;
                    -webkit-transform: translate3d(0,0,0);
                    -moz-transform: translate3d(0,0,0);
                    -ms-transform: translate3d(0,0,0);
                    -o-transform: translate3d(0,0,0);
                    transform: translate3d(0,0,0);
                }

                .carousel-fade .carousel-inner > .item.next.left,
                .carousel-fade .carousel-inner > .item.prev.right,
                .carousel-fade .carousel-inner > .item.active{
                    opacity: 1;
                    -webkit-transform: translate3d(0,0,0);
                    -moz-transform: translate3d(0,0,0);
                    -ms-transform: translate3d(0,0,0);
                    -o-transform: translate3d(0,0,0);
                    transform: translate3d(0,0,0);
                }
                .btn-space {
                    margin-right: 70px;
                }
                .btn-width{
                    width: 14%;
                    
                }

                .intro-section{
                    padding: 0px 0px;
                }

                .gray{
                    background-color: #f2f4f8;
                }

                .intro-column{
                    display: flex;
                }

                .intro-column .intro-block{
                    flex: 1;
                    text-align: center;
                    border-right: 2px solid #dadada;
                    padding: 1px 1px;
                }

                .intro-column .intro-block:last-child {
                    border-right: 0px solid #dadada;
                }

                /* .intro-block-first{
                    border-left: 1px solid #dadada;
                } */

                .intro-block h4{
                    color: #005aaa;
                }
            }
            .btn-primarys{
                color:#fff;
                background-color:#3490dc;
                border-color:#3490dc;
            }
            .btn-primarys:hover{
                color:#fff;
                background-color:#227dc7;
                border-color:#2176bd;
            }
        </style>

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
    <body>
        
        <div class="container-fluid">
            <a href="/" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none; padding-left: 50px; padding-top: 5px; padding-bottom: 5px; transition: transform 0.2s ease; vertical-align: middle;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 1.5em; margin: 0; line-height: 1;"></i>
                <span style="font-size: 1.5em; font-weight: 800; letter-spacing: 0.5px; background: linear-gradient(to right, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Inter', sans-serif; margin: 0; line-height: 1.3;">Legals Forum</span>
            </a>
        </div>
        
        <!-- <div class="container flex-center position-ref full-height"> -->
        <div class="container">
            
            <p class="top-left">It's a new experience,&nbsp;<span style="color:red;" id="target"><b>clould-based platform...</b></span></p>
            {{-- <p class="top-left-enquiry">For further enquires, kindly contact <span style="color:red;"><b>0209534818</b></span></p> --}}
            
            @if (Route::has('login'))
                <div class="top-right links">
                    
                    @auth
                        <a style="color: blue;" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Hi, {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <div class="profile-usermenu">
                                <ul class="nav">
                                    <li>
                                        <a href="/accounts/profile/{{ Auth::user()->id }}">
                                        <i class="glyphicon glyphicon-user"></i>
                                        Profile </a>
                                    </li>
                                    <li>
                                        <a href="/accounts/manage-password">
                                        <i class="glyphicon glyphicon-cog"></i>
                                        Manage Accounts </a>
                                    </li>
                                    <li>
                                        <a href="/accounts/bookmarks/{{ Auth::user()->id }}">
                                        <i class="glyphicon glyphicon-bookmark"></i>
                                        Bookmarks </a>
                                    </li>
                                    <li>
                                        <a href="/accounts/downloads/{{ Auth::user()->id }}">
                                        <i class="glyphicon glyphicon-cloud-download"></i>
                                        Downloads </a>
                                    </li>

                                    @if( Auth::user()->subscription_id == null)

                                        <li class="hidden">
                                            <a href="/accounts/subscription/{{ Auth::user()->subscription_id }}">
                                            <i class="glyphicon glyphicon-credit-card"></i>
                                            My Subscription </a>
                                        </li>

                                        @else
                                            <li>
                                                <a href="/accounts/subscription/{{ Auth::user()->subscription_id }}">
                                                <i class="glyphicon glyphicon-credit-card"></i>
                                                My Subscription</a>
                                            </li>
                                    @endif        

                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                         <i class="glyphicon glyphicon-off"></i>
                                         {{ __('Logout') }}
                                        </a>
 
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>      
                        </div>

                        @else
                            <a class="btn btn-sm btn-primarys" href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a class="btn btn-sm btn-primarys" href="{{ route('register') }}">Register</a>
                            @endif
                    @endauth
                </div>
            @endif
        </div>

        {{-- <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" id="app">
                @include('flash-message')
                @yield('content')
            </div>
            <div class="col-md-4"></div>
        </div> --}}
        

        {{-- <div class="container content m-b-md"> --}}

            <div id="mycarousel" class="carousel slide carousel-fade" data-ride="carousel">
                
              
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">

                  <div class="item active bg1">
                    <div class="carousel-caption">

                      <h1><b>Efficient Legal Research</b></h1>
                      <p>Fast and accurate insight into laws and cases in Ghana</p><br><br>
                    
                        <form action="{{ url('main_home_search') }}" method="GET">
                            {{ csrf_field() }}
                            <div class="input-group" style="border: 1px solid black; box-shadow: .1px .1px .1px black;">         
                                    <input style="font-size:14pt;height:50px;" type="text" class="form-control" name="search_text" placeholder="Search any law or case in Ghana">
                                    <span class="input-group-btn">
                                        <button style="font-size:14pt;height:50px;" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                            </div>
                        </form>
                        <br>
                    </div>
                  </div>

                  <div class="item bg2">
                    <div class="carousel-caption">
                        <h1><b>Flexible Access to Resources</b></h1>
                        <p>Multiple search and filter for need-based research</p><br><br>

                        <form action="{{ url('main_home_search') }}" method="GET">
                            {{ csrf_field() }}
                            <div class="input-group" style="border: 1px solid black; box-shadow: 1px 1px 1px black;">         
                                    {{-- <input type="text" class="form-control" name="search_text" placeholder="Search any law or case in Ghana""> --}}
                                    <input style="font-size:14pt;height:50px;" type="text" class="form-control" name="search_text" placeholder="Search any law or case in Ghana"">
                                    <span class="input-group-btn">
                                        <button style="font-size:14pt;height:50px;" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                            </div>
                        </form>
                        <br>
                    </div>
                  </div>

                  <div class="item bg3">
                    <div class="carousel-caption">
                        <h1><b>Convenient & Cost Effective</b></h1>
                        <p>Access thousands of Cases and laws for free</p><br><br>

                        <form action="{{ url('main_home_search') }}" method="GET">
                            {{ csrf_field() }}
                            <div class="input-group" style="border: 1px solid black; box-shadow: 1px 1px 1px black;">         
                                    {{-- <input type="text" class="form-control" name="search_text" placeholder="Search any law or case in Ghana""> --}}
                                    <input style="font-size:14pt;height:50px;" type="text" class="form-control" name="search_text" placeholder="Search any law or case in Ghana"">
                                    <span class="input-group-btn">
                                        <button style="font-size:14pt;height:50px;" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                            </div>
                        </form>
                        <br>
                    </div>
                  </div>

                  <div class="item bg4">
                    <div class="carousel-caption">
                        <h1><b>Precise Search Navigation</b></h1>
                        <p>Access thousands of Cases and laws for free</p><br><br>

                        <form action="{{ url('main_home_search') }}" method="GET">
                            {{ csrf_field() }}
                            <div class="input-group" style="border: 1px solid black; box-shadow: 1px 1px 1px black;">         
                                    <input style="font-size:14pt;height:50px;" type="text" class="form-control" name="search_text" placeholder="Search any law or case in Ghana"">
                                    <span class="input-group-btn">
                                        <button style="font-size:14pt;height:50px;" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                    </span>
                            </div>
                        </form>
                        <br>
                    </div>
                  </div>
                </div>
              </div>

              <section class="intro-section gray">
                <div class="container-fluid">
                    <div class="intro-column" style="margin-top:10px;">
                        <a href="/constitution/Republic/Ghana/1" style="text-decoration: none;">
                            <div class="intro-block">
                                <h4><b><u>CONSTITUTION</u></b></h4>
                                <p><b>Access constitution of Ghana along with constitution of over 100 countries in Africa, Asia, America and Europe</b></p>
                                <div class="icon">
                                    <a href="#efficiency-section">
                                        {{-- <img src="/Content/newtheme/img/dk-grey-icon-short-circle-arrow-dsk.png" class="img-fluid" alt=""> --}}
                                    </a>
                                </div>
                            </div>
                        </a>
                        <a href="/pre-1992-legislation" style="text-decoration: none;">
                            <div class="intro-block">
                                <h4><b><u>OLD LAWS</u></b></h4>
                                <p><b>Access over 200 Ghanaian laws and enactments before the Fourth Republic</b></p>
                                <div class="icon">
                                    <a href="#efficiency-section">
                                        {{-- <img src="/Content/newtheme/img/dk-grey-icon-short-circle-arrow-dsk.png" class="img-fluid" alt=""> --}}
                                    </a>
                                </div>
                            </div>
                        </a>
                        <a href="/post-1992-legislation" style="text-decoration: none;">
                            <div class="intro-block">
                                <h4><b><u>NEW LAWS</u></b></h4>
                                <p><b>Access over 200 consolidated laws of Ghana including Acts, Regulations and Amendments in the Fourth Republic</b></p>
                                <div class="icon">
                                    <a href="#efficiency-section">
                                        {{-- <img src="/Content/newtheme/img/dk-grey-icon-short-circle-arrow-dsk.png" class="img-fluid" alt=""> --}}
                                    </a>
                                </div>
                            </div>
                        </a>
                        <a href="/judgement/Ghana" style="text-decoration: none;">
                            <div class="intro-block">
                                <h4><b><u>CASE LAWS</u></b></h4>
                                <p><b>Access  several decided cases in Ghana including Supreme Court, High Court and Court of Appeal cases.</b></p>
                                <div class="icon">
                                    <a href="#efficiency-section">
                                        {{-- <img src="/Content/newtheme/img/dk-grey-icon-short-circle-arrow-dsk.png" class="img-fluid" alt=""> --}}
                                    </a>
                                </div>
                            </div>
                        </a>
                        <a href="/News/Ghana-News/1" target="_blank" style="text-decoration: none;">
                            <div class="intro-block">
                                <h4><b><u>NEWS</u></b></h4>
                                <p><b>Access relevant legal and business news content in Ghana, Africa, Asia, Europe and America</b></p>
                                <div class="icon">
                                    <a href="#efficiency-section">
                                        {{-- <img src="/Content/newtheme/img/dk-grey-icon-short-circle-arrow-dsk.png" class="img-fluid" alt=""> --}}
                                    </a>
                                </div>
                            </div>
                        </a>    
                    </div>
                </div>
              </section>
                
        {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
        {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}
        
        <script src="{{ asset('js/jquery-3.0.0.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>

        <script>
            $(document).ready(function () {
                $("#target").effect( "shake", {times:3}, 10000 );
            });
            $(function(){
                $("#mycarousel").carousel({
                    interval: 3800
                });
            });         
        </script>
        
    </body>
</html>
