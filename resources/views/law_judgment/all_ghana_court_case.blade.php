<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>{{ucwords(strtolower($allGhanaLaw['case_title']))}}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/offcanvas/">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/app_update.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .mt-customised {
            margin-top: 15px !important;
            margin-bottom: 25px !important;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .navbar-custom{
        box-shadow: 0 1px 8px #e0e0e0;
      }
      .navbar{
          padding: .4rem 1rem;
      }
      .p-m{
        padding: .15rem!important;
      }
      .my-m {
        margin-bottom: .15rem!important;
      }
      .content_container {
        margin-top: .1rem!important;
        margin-bottom: .1rem!important;
        padding: .5rem!important
      }
      .pt_for_content{
        margin-bottom: .3rem!important;
      }
      .bg-header-color{
            background-color: #004353;
      }
      
      .header_only {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
        }
        .dimension_align{
            padding: 3px 1px 0.1px 1px;
            background: #f5f5f5;
            color: black;
            text-align: center;
            margin-bottom: 15px; 
            border: .1px solid #ddd;
        }
        .alignment{
          text-align: center;
          /* border: .1px solid #ddd; */
        }
        ::-webkit-scrollbar {
            width: 7px;
            }
            div::-webkit-scrollbar-button {
            display: block;
            width: 1px;
            height: 1px;
            }
            div::-webkit-scrollbar-button:decrement:start {
            background-color:lightblue;
            border:1px solid #eee;
            }
            div::-webkit-scrollbar-button:increment:start {
            background-color:lightblue;
            border:1px solid #eee;
            }
            div::-webkit-scrollbar-button:decrement:end {
            background-color:lightblue;
            border:1px solid #eee;
            }
            div::-webkit-scrollbar-button:increment:end {
            background-color:lightblue;
            border:1px solid #eee;;
            }
            ::-webkit-scrollbar-thumb {
            background: #888; 
            }
            ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
            border-radius: 10px;
            } 
            ::-webkit-scrollbar-thumb:hover {
            background: #555; 
            }
            .bg-header-color{
            background-color: #004353;
            }
            .back-to-top {
            position: sticky;
            bottom: 80px;
            left: 950px;
            }
            .nav-link {
            display: block;
            padding: .1rem .9rem;
            }
            .fixing_top{
            position: fixed;
            bottom: 10;
            right: 0;
            }
            
            body {
                height: 655px;
            }
            @media screen and (max-width: 1120px) {                 
                .fixing_top{
                position: relative;
              }                
            }
            /* https://www.youtube.com/watch?v=O9toDm97VQM */
    </style>
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/offcanvas.css') }}" rel="stylesheet">
    {{-- navbar-white bg-white --}}
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
  <body class="bg-light">
      
    <nav class="navbar navbar-custom navbar-expand-lg fixed-top navbar-light bg-white">
  {{-- <a class="navbar-brand mr-auto mr-lg-0" href="#">Legals Forum</a> --}}
  <a href="/" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none; padding-left: 1px; padding-top: 1px; padding-bottom: 1px; transition: transform 0.2s ease; vertical-align: middle;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 1.5em; margin: 0; line-height: 1;"></i>
                <span style="font-size: 1.5em; font-weight: 800; letter-spacing: 0.5px; background: linear-gradient(to right, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Inter', sans-serif; margin: 0; line-height: 1.3;">Legals Forum</span>
            </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

  <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav ml-auto">
      {{-- <li class="nav-item active">
        <a class="nav-link" href="#">Constitution <span class="sr-only">(current)</span></a>
      </li> --}}
      @foreach($headerMenus as $menu)
                   @if($menu->is_dropdown)
                       <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown{{ $menu->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $menu->title }}</a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $menu->id }}">
                             @foreach($menu->children as $child)
                                <a class="dropdown-item" href="{{ $child->custom_content ? route('dynamic.page', $child->slug) : $child->url }}">{{ $child->title }}</a>
                             @endforeach
                          </div>
                       </li>
                       &nbsp;&nbsp;
                   @else
                       <li class="nav-item">
                          <a class="nav-link text-dark" href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}">{{ $menu->title }}</a>
                       </li>
                       &nbsp;&nbsp;
                   @endif
                @endforeach
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      <div>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            &nbsp;<a class="btn btn-sm bg-header-color text-white" href="{{ route('login') }}">Login</a>&nbsp;

                @if (Route::has('register'))
                    <a class="btn btn-sm bg-header-color text-white" href="{{ route('register') }}">Sign Up</a>
                @endif
                
            @else
                <li class="nav-item dropdown">
                    <a style="color: blue;" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Hi, {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/accounts/profile/{{ Auth::user()->id }}"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z"/>
                            <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
                          </svg>&nbsp;&nbsp;Profile</a>
                        <a class="dropdown-item" href="/accounts/manage-password"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                            <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                          </svg>&nbsp;&nbsp;Manage Accounts </a>
                        <a class="dropdown-item" href="/accounts/downloads/{{ Auth::user()->id }}"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z"/>
                            <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z"/>
                            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z"/>
                          </svg>&nbsp;&nbsp;Downloads</a>
                        <a class="dropdown-item" href="/accounts/bookmarks/{{ Auth::user()->id }}"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bookmarks-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V4z"/>
                            <path d="M14 14l-1-.6V2a1 1 0 0 0-1-1H4.268A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v12z"/>
                          </svg>&nbsp;&nbsp;Bookmarks</a>
                        @if( Auth::user()->subscription_id == null)
                            <a class="dropdown-item" style="color: red;"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                              </svg>&nbsp;&nbsp;No Subscription</a>
                            @else
                                <a class="dropdown-item" href="/accounts/subscription/{{ Auth::user()->subscription_id }}"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                    <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                  </svg>&nbsp;&nbsp;My Subscription</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-power" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.578 4.437a5 5 0 1 0 4.922.044l.5-.866a6 6 0 1 1-5.908-.053l.486.875z"/>
                                <path fill-rule="evenodd" d="M7.5 8V1h1v7h-1z"/>
                              </svg>&nbsp;&nbsp;{{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
    </ul>
  </div>
</nav>

<div class="container-fluid mt-customised">
    <div class="row">
        <div class="col-md-9">
          

            <div class="d-flex p-m my-m">
                <div class="lh-100">
                    <form action="{{ url('cases_index_search') }}" method="GET" class="form-inline my-2 my-lg-0 justify-content-center">
                        {{ csrf_field() }}
                        <input style="width:300px;" class="form-control mr-sm-2" type="search" placeholder="Search any word in all Case Laws..." aria-label="Search" name="search_text">
                    </form>
                </div>
            </div>

            <div class="content_container bg-white rounded shadow-sm">
                <div class="pt_for_content">
                    <div class="nav-scroller bg-header-color rounded shadow-sm">
                        <nav class="nav nav-underline">
                            <a class="nav-link active text-white" href="/judgement/Ghana">Case Laws</a>
                            <a class="nav-link text-white" href="/judgement/1/Supreme-Court">Supreme Court</a>
                            <a class="nav-link text-white" href="/judgement/3/Court-of-Appeal">Court of Appeal</a>
                            <a class="nav-link text-white" href="/judgement/2/High-Court">High Court</a>
                        </nav>
                    </div>
                </div>
                {{-- For the filter --}}
                <div class="text-right mb-1">
                    <button id="print_options"  type="button" class="btn btn-outline-secondary btn-sm open">
                        <span class="glyphicon glyphicon-tasks"></span>Print Options&nbsp;
                    </button>
                
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#viewCases">
                      View {{$allGhanaLaw['gh_law_judgment_group_name']}} Cases
                    </button>
                    
                </div>

                {{-- Start of container content --}}
                <div class="judgement_display" style="height: auto;">
                    <div id="display_content">
                            <div class="header_only dimension_align">
                                <h6 class="font-weight-bold">{{ $allGhanaLaw['case_title'] }}</h6>
                            </div>
                            <div class="menu_options text-right" style="display: none;">
                                @if (Route::has('login'))
                                    @auth
                                            
                                            {{-- No Subscription --}}
                                            @if(auth()->user()->check_subscription == 0)
                                                @include('layouts.no_subscription')
                                                    
                                                {{-- Subscription has expired --}}
                                                @elseif(auth()->user()->subscription_expiry < today())
                                                @include('layouts.expired_subscription')
                                                    
                                                {{-- Subscription download limit reached --}}
                                                @elseif(auth()->user()->subscription_downloads <= auth()->user()->downloads_counts)
                                                @include('layouts.exceeded_downloads_subscription')
                                                    
                                                {{-- Download PDF and Others --}}
                                                @else
                                                    {{-- DOWNLOAD PDF --}}
                                                    <a class="case_download_link" href="javascript:;" rel="/judgement/1/case_law/pdf_view/{{ $allGhanaLaw['case_title'] }}/{{$allGhanaLaw['id']}}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                                                    
                                                    {{-- SAVE USER DOWNLOAD --}}
                                                    <a class="case_id d-none" href="javascript:;" rel="/acts-downloads/{{$allGhanaLaw['case_title']}}/{{ Auth::user()->name }}/{{ Auth::user()->id }}/{{$allGhanaLaw['gh_law_judgment_group_name']}}/{{$allGhanaLaw['id']}}/{{ Auth::user()->id }}{{$allGhanaLaw['case_title']}}"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>

                                                    {{-- PLAIN VIEW --}}
                                                    <a href="/judgement/plain/simple-preview/{{$allGhanaLaw['id']}}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp;
                                                    
                                                    {{-- PRINT --}}
                                                    <a href="/judgement/print/simple-preview/{{$allGhanaLaw['id']}}" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            
                                            @endif

                                        @else

                                        {{-- Create Account --}}
                                        <a href="" data-toggle="modal" data-target="#exampleModal"><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" style="width:1.5em;">&nbsp;PDF</a>&nbsp;&nbsp;||&nbsp;
                                        {{-- PLAIN --}}
                                        {{-- <a href="/judgement/plain_view/{{$allGhanaLaw['id']}}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp; --}}
                                        <a href="" data-toggle="modal" data-target="#exampleModal">Plain View</a>&nbsp;&nbsp;||&nbsp;

                                        <a href="" data-toggle="modal" data-target="#exampleModal"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><b>Kindly Log In or Sign Up to Create An Account</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <a class="btn btn-sm bg-header-color text-white" href="{{ route('login') }}">Login</a>
                                                    <a class="btn btn-sm bg-header-color text-white" href="{{ route('register') }}">Sign Up</a>
                                                </div>
                                            </div>
                                            </div>
                                        </div> 

                                        
                                    
                                    @endauth
                                @endif

                            </div>
                            

                        <div class="content">
                            <!-- Court Name -->
                            <center>
                                <ul class="mb-3">
                                    <li style="list-style: none;">
                                    <h5><b>{!! $allGhanaLaw['court_name'] !!}</b></h5>
                                    </li>
                                </ul>
                            </center>
                            
                            <!-- Case Title -->
                            <center>
                                <b>
                                    <h6 style="color:blue;"><b>{!! $allGhanaLaw['case_title_1'] !!}</b></h6>
                                    <label>vs.</label>
                                    <h6 style="color:blue;"><b>{!! $allGhanaLaw['case_title_2'] !!}</b></h6>
                                </b>
                            </center>
                            <br>

                            <div style="padding: 15px;">
                                <div class="row">
                                        <h6><b style="color:blue;">DATE:&nbsp;</b>
                                        <b style="color:black;">{{$allGhanaLaw['date']}}</b></h6>
                                </div>
                                <div class="row">
                                    <h6><b style="color:blue;">{{$allGhanaLaw['case_type_name']}}:&nbsp;</b>
                                    <b style="color:black;">{{$allGhanaLaw['reference_number']}}</b></h6>
                                </div>
                                
                                <div class="row">
                                    <h6><b style="color:blue;">JUDGES:&nbsp;</b>
                                    <b style="color:black;">{{$allGhanaLaw['coram']}}</b></h6>
                                </div>
                                
                                <div class="row">
                                    <h6><b style="color:blue;">LAWYERS:&nbsp;</b>
                                    <b style="color:black;">{!! $allGhanaLaw['counsellors'] !!}</b></h6>
                                </div>
                            </div>
                            
                              <h6 class="alignment"><b style="color:blue;">{{$allGhanaLaw['judgement_type']}}</b></h6>
                            
                            <hr>
                            
                            {{--Body--}}   
                            <p style="background-color: #FFFFFF;">{!! $allGhanaLaw['content'] !!}</p>
                            
                        </div>
                    </div> 

                    <!-- View Other cases -->
                    <div class="modal fade" id="viewCases" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>{{$allGhanaLaw['gh_law_judgment_group_name']}} Cases</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body text-left">
                              <table class="table table-striped table-condensed" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Case Laws Title</th>
                                        <th>Ref No.</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($allGhanaLaws as $allGhanaLaw)
                                    <tr>
                                        <td>
                                        <a href="/judgement/Ghana/{{ $allGhanaLaw->gh_law_judgment_group_name }}/{{ $allGhanaLaw->id}}"><li style="list-style: none;">{{ $allGhanaLaw->case_title }}</li></a>
                                        </td>
                                        <td>{{ $allGhanaLaw->reference_number }}</td>
                                        <td>{{ $allGhanaLaw->year }}</td>
                                    </tr>
                                @endforeach 
                                </tbody>
                            </table>
                            </div>
                            
                        </div>
                      </div>
                    </div>

                    <div id="display_view_all_section"></div>


                </div>
                


                {{-- End of content container --}}
        
            </div>
            {{-- <a id="back-to-top" href="#" class="btn btn-light back-to-top" role="button"><i class="fas fa-chevron-up"></i></a> --}}
            <a id="back-to-top" href="#" class="back-to-top">
              <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-up-circle-fill" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-10.646.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
              </svg>
            </a>
        </div>

        {{-- Reserved Sidebar for Adsense --}}
        <div class="col-md-3 fixing_top p-3 bg-white rounded shadow-sm">
        {{-- <div class="col-md-3 fixing_top p-3 bg-white rounded shadow-sm"> --}}
          @include('ads.content_adsense_vertical')
        </div>
        

    </div>
    
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script src="{{ asset('js/tooltipster.bundle.min.js') }}"></script>
<script src="{{ asset('js/print-preview.js') }}"></script>
<script src="{{ asset('js/offcanvas.js') }}"></script>

<script src="{{ asset('js/myscript.js') }}"></script>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function(){
        $('#datatable').DataTable();
    });
</script>

<script>
  $(document).ready(function(){
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
});
</script>

<script type="text/javascript">
  $(document).ready(function () {
      //Disable full page
      $('body').bind('cut copy paste', function (e) {
          e.preventDefault();
      });
      
      //Disable part of page
      $('#id').bind('cut copy paste', function (e) {
          e.preventDefault();
      });
  });
</script>


<script>
    $(".case_id").click(function(e){
        e.preventDefault();
        var case_id = $(this).attr("rel");
        console.log(case_id);

        $.ajax({
            url: case_id,
            type: "GET",
            success:function(response){
            if(response.success){
                  $("#bookmarked").notify(
                      response.message,
                { position:"left", className: "info", autoHideDelay: 900000}
                );
            }else{
                $("#bookmarked").notify(
               "Section to Download",
                { position:"left", className: "success", autoHideDelay: 10000}
                );
              }
            },
            error:function (){
                $("#bookmarked").notify(
               "Issue with database entry",
                { position:"left", className: "error" }
                );
            }
        });

    });
    
</script>

<script>
    $(".case_download_link").click(function(e){
        e.preventDefault();
        var case_download_link = $(this).attr("rel");
        $('.case_id').trigger("click");
       
        $.ajax({
            url: case_download_link,
            type: "GET",
        });
    });  
</script>

</body>
</html>
