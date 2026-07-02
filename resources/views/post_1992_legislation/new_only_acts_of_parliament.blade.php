<!doctype html>
<html lang="en">
   <head>
      <script data-ad-client="ca-pub-4293461101625028" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
      <meta name="generator" content="Jekyll v4.1.1">
      <title>Acts of Parliament</title>
      <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/offcanvas/">
      <!-- Bootstrap core CSS -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      {{-- 
      <link href="{{ asset('css/app_update.css') }}" rel="stylesheet">
      --}}
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
      <!-- Favicons -->
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
      <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">
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
         .pt_for_content_container{
         margin-bottom: 1rem!important;
         }
         .bg-header-color{
         background-color: #004353;
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
         .nav-link {
         display: block;
         padding: .1rem .9rem;
         }
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
         {{-- <a class="navbar-brand mr-auto mr-lg-0" href="#">Laws Ghana</a> --}}
         <a href="/" class="">
         <img src="{{ asset('/logo/lawsghlog.png') }}" class="img-responsive" style="width:12em; padding-top: 1px; padding-bottom:1px;padding-left:1px;"> 
         </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
               {{-- 
               <li class="nav-item active">
                  <a class="nav-link" href="#">Constitution <span class="sr-only">(current)</span></a>
               </li>
               --}}
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Constitution</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="/constitution/Republic/Ghana/1">Ghana</a>
                     <a class="dropdown-item" href="/constitution/all-countries/1/Africa">Africa</a>
                     <a class="dropdown-item" href="/constitution/all-countries/2/Asia">Asia</a>
                     <a class="dropdown-item" href="/constitution/all-countries/3/Europe">Europe</a>
                     <a class="dropdown-item" href="/constitution/all-countries/4/North-America">North America</a>
                     <a class="dropdown-item" href="/constitution/all-countries/5/South-America">South America</a>
                  </div>
               </li>
               &nbsp;&nbsp;
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pre-4th Republic Laws</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="/pre_1992_legislation/1/First Republic">1st Republic</a>
                     <a class="dropdown-item" href="/pre_1992_legislation/2/Second Republic">2nd Republic</a>
                     <a class="dropdown-item" href="/pre_1992_legislation/3/Third Republic">3rd Republic</a>
                     <a class="dropdown-item" href="/pre_1992_legislation/5/NLC Decree">NLC Decree</a>
                     <a class="dropdown-item" href="/pre_1992_legislation/6/NRC Decree">NRC Decree</a>
                     <a class="dropdown-item" href="/pre_1992_legislation/7/SMC Decree">SMC Decree</a>
                     <a class="dropdown-item" href="/pre_1992_legislation/8/AFRC Decree">AFRC Decree</a>
                     <a class="dropdown-item" href="/pre_1992_legislation/4/PNDC Law">PNDC Law</a>
                  </div>
               </li>
               &nbsp;&nbsp;
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-dark" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">4th Republic Laws</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                     <a class="dropdown-item" href="/post-1992-legislation/1/Acts of Parliament">Acts of Parliament</a>
                     <a class="dropdown-item" href="/post-1992-legislation/only-regulations">Legislative Instruments</a>
                     <a class="dropdown-item" href="/post-1992-legislation/Constitutional-Intruments">Constitutional Instruments</a>
                     <a class="dropdown-item" href="/post-1992-legislation/Executive-Intruments">Executive Instruments</a>
                     <a class="dropdown-item" href="/post-1992-legislation/only-amendments">Amendments</a>
                  </div>
               </li>
               &nbsp;&nbsp;
               <li class="nav-item">
                  <a class="nav-link text-dark" href="/judgement/Ghana">Case Laws</a>
               </li>
               &nbsp;&nbsp;
               <li class="nav-item">
                  <a class="nav-link text-dark" href="/News/Ghana-News/1">News</a>
               </li>
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
                           <a class="dropdown-item" href="/accounts/profile/{{ Auth::user()->id }}">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z"/>
                                 <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                 <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
                              </svg>
                              &nbsp;&nbsp;Profile
                           </a>
                           <a class="dropdown-item" href="/accounts/manage-password">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-gear" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                                 <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                              </svg>
                              &nbsp;&nbsp;Manage Accounts 
                           </a>
                           <a class="dropdown-item" href="/accounts/downloads/{{ Auth::user()->id }}">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z"/>
                                 <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z"/>
                                 <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z"/>
                              </svg>
                              &nbsp;&nbsp;Downloads
                           </a>
                           <a class="dropdown-item" href="/accounts/bookmarks/{{ Auth::user()->id }}">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bookmarks-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12l-5-3-5 3V4z"/>
                                 <path d="M14 14l-1-.6V2a1 1 0 0 0-1-1H4.268A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v12z"/>
                              </svg>
                              &nbsp;&nbsp;Bookmarks
                           </a>
                           @if( Auth::user()->subscription_id == null)
                           <a class="dropdown-item" style="color: red;">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-dash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" d="M6 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                 <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                              </svg>
                              &nbsp;&nbsp;No Subscription
                           </a>
                           @else
                           <a class="dropdown-item" href="/accounts/subscription/{{ Auth::user()->subscription_id }}">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                 <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                              </svg>
                              &nbsp;&nbsp;My Subscription
                           </a>
                           @endif
                           <a class="dropdown-item" href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-power" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" d="M5.578 4.437a5 5 0 1 0 4.922.044l.5-.866a6 6 0 1 1-5.908-.053l.486.875z"/>
                                 <path fill-rule="evenodd" d="M7.5 8V1h1v7h-1z"/>
                              </svg>
                              &nbsp;&nbsp;{{ __('Logout') }}
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
                     <form action="{{ url('post_index_search') }}" method="GET" class="form-inline my-2 my-lg-0 justify-content-center">
                        {{ csrf_field() }}
                        <input style="width:300px;" class="form-control mr-sm-2" type="search" placeholder="Search any word in all Laws..." aria-label="Search" name="search_text">
                     </form>
                  </div>
               </div>
               <div class="content_container bg-white rounded shadow-sm">
                  <div class="pt_for_content_container">
                     <div class="nav-scroller bg-header-color rounded shadow-sm">
                        <nav class="nav nav-underline">
                           <a class="nav-link active text-white" href="/post-1992-legislation">All 4th Republic Laws</a>
                           <a class="nav-link text-white" href="/post-1992-legislation/1/Acts of Parliament">Acts of Parliament</a>
                           <a class="nav-link text-white" href="/post-1992-legislation/only-regulations">Legislative Instruments</a>
                           <a class="nav-link text-white" href="/post-1992-legislation/Constitutional-Intruments">Constitutional Instruments</a>
                           <a class="nav-link text-white" href="/post-1992-legislation/Executive-Intruments">Executive Instruments</a>
                           <a class="nav-link text-white" href="/post-1992-legislation/only-amendments">Amendments</a>
                           {{-- 
                           <form action="{{ url('cases_index_search') }}" method="GET" class="form-inline my-2 my-lg-0 justify-content-center">
                              {{ csrf_field() }}
                              <input style="width: 200px;" class="form-control mr-sm-2" type="search" placeholder="Search any word in all Case Laws" aria-label="Search" name="search_text">
                           </form>
                           --}}
                        </nav>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-9">
                        <div class="list-group">
                           <table class="table table-striped table-condensed" id="datatable">
                              <thead>
                                 <tr>
                                    <th>All Acts of Parliament</th>
                                    <th>Year</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($actsOfParliaments as $actsOfParliaments)
                                 <tr>
                                    <td>
                                       <a href="/post-1992-legislation/table-of-content/{{$actsOfParliaments->post_group}}/{{ $actsOfParliaments->title }}/{{ $actsOfParliaments->id}}">
                                          <li style="list-style: none;">{{ $actsOfParliaments->title }}</li>
                                       </a>
                                    </td>
                                    <td>{{ $actsOfParliaments->year }}</td>
                                 </tr>
                                 @endforeach 
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <div class="col-md-3" style="padding-top: 2.5em;">
                        <div class="panel panel-default mb-3">
                           <div class="panel-heading">
                              <center>
                                 <p class="panel-title">Filter</p>
                              </center>
                           </div>
                           <div class="panel-body">
                              <center>
                                 <select class="form-control browser-default custom-select all_judgment_filter_category" style="width: 149px;">
                                    <option selected value="">Select Category</option>
                                    @foreach($actsOfParliamentCategories as $actsOfParliamentCategory)
                                    @endforeach	
                                 </select>
                              </center>
                              <br>
                              <form action="{{ url('acts_of_parliament_index_search') }}" method="GET">
                                 {{ csrf_field() }}
                                 <input style="padding: 15px;" class="form-control" name="search_text" type="text" placeholder="Acts of Parliament search" aria-label="Search">
                              </form>
                           </div>
                        </div>
                        <div class="card mt-3">
                           @include('ads.small_ads_image_content')                        
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            {{-- 
            <div class="col-md-3 content_container p-3 bg-white rounded shadow-sm"></div>
            --}}
            <div class="col-md-3 content_container">
               @include('ads.adsense_vertical')
            </div>
         </div>
      </div>
      {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
      <script src="{{ asset('js/slim.js') }}"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
      {{-- <script src="/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script> --}}
      <script src="{{ asset('js/bootstrap_update.min.js') }}"></script>
      <script src="{{ asset('js/offcanvas.js') }}"></script>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
      <script>
         $(document).ready(function(){
             $('#datatable').DataTable();
         });
      </script>
   </body>
</html>