<!doctype html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>{{ucwords(strtolower($allPre1992Act['title']))}}</title>

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
            /* position: -webkit-sticky;
            position: sticky;
            top: 0; */
        }
        .nav-links{
        /* background-color: #f5f5f5; */
        /* border: .1px solid #ddd; */
        border-radius: .25rem;
        display: block;
        padding: .1rem .9rem;
        }
        .dimension_align{
            padding: 3px 1px 0.1px 1px;
            /* background: #f5f5f5; */
            color: black;
            text-align: center;
            margin-top: 25px;
            margin-bottom: 15px; 
            /* border: .1px solid #ddd; */
        }
        .alignment{
          text-align: center;
          border: .1px solid #ddd;
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
            .back-to-top {
            position: sticky;
            bottom: 80px;
            left: 850px;
            }
            .back-to-top-expanded {
            position: sticky;
            bottom: 80px;
            left: 1070px;
            }
            .nav-link {
            display: block;
            padding: .1rem .9rem;
            }
            ul{
              margin-bottom: .5rem;
            }
            hr{
              margin-top: .1rem;
              margin-bottom: .7rem;
            }
            .sidebar {
            position: -webkit-sticky;
            position: sticky;
            top: 0%;
            }
            .btn-outlined{
              color: white;
              background-color: #004353;
            }
            .fixing_top{
            position: fixed;
            bottom: 10;
            right: 0;
            }
            body {
                height: 655px;
            }

            .btn-customised{
            font-weight: 550;
            padding: .175rem .75rem;
            line-height: 1.3;
            font-size: .8rem;
            }
            
            /* Mobile adjustments of the sticky and table of content */
            @media screen and (max-width: 600px) {
                .mobile-adjust-1 {
                  padding-right: 2px !important;
                  padding-left: 2px !important;
                }
                .mobile-adjust-2 {
                  padding-left: 43px;
                }
                .mobile-adjust-3 {
                  padding-left: 25px;
                }
            }
            /* hide on mobile the filer for related acts at the table of content */
            /* hide on mobile the filer for select sections at the content view */
            @media screen and (max-width: 1120px) {               
              .mobile-filter-hide {
                  display: none;
                }   
              .fixing_top{
                position: relative;
              }               
            }
            /* hide on desktop when it's 1160 and above */
            @media screen and (min-width: 1119px) {
                .hide-on-desktop {
                  display: none;
                }
            }
            
            /* https://www.youtube.com/watch?v=O9toDm97VQM */
    
        /* ============================================
           PREMIUM FIXED NAVIGATION BAR (SHARED)
           ============================================ */
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.65);
            --card-bg-hover: rgba(25, 35, 55, 0.8);
            --border-color: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-glow: rgba(245, 158, 11, 0.2);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .nav-wrap,
        .nav-wrap *,
        .nav-menu-links-premium,
        .nav-menu-links-premium *,
        .nav-link-btn,
        .nav-link-btn *,
        .nav-dropdown-menu,
        .nav-dropdown-menu a {
            font-family: var(--font) !important;
        }

        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            z-index: 1000;
            background: rgba(6, 10, 19, 0.88) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color) !important;
            padding: 0 !important;
        }

        .nav-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
        }

        .nav-logo img {
            height: 38px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .nav-menu-links-premium {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link-dropdown {
            position: relative;
        }

        .nav-link-btn {
            font-size: 14px !important;
            font-weight: 500 !important;
            color: var(--text-secondary) !important;
            padding: 8px 14px !important;
            border-radius: 8px !important;
            background: transparent !important;
            border: none !important;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-btn:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .nav-link-btn i {
            font-size: 10px !important;
            color: var(--text-muted) !important;
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: rgba(17, 24, 39, 0.95) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            padding: 8px !important;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a {
            display: flex !important;
            align-items: center;
            gap: 10px;
            padding: 10px 14px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            color: var(--text-secondary) !important;
            transition: all 0.2s ease;
            text-align: left;
            text-decoration: none !important;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.06) !important;
        }

        .nav-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 6px 0;
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: var(--text-primary) !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-hover) !important;
            background: transparent !important;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none !important;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .btn-signup {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #fff !important;
            padding: 8px 18px !important;
            border-radius: 8px !important;
            border: none !important;
            background: var(--accent-gradient) !important;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px var(--accent-glow) !important;
            text-decoration: none !important;
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px var(--accent-glow) !important;
        }

        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px !important;
            border-radius: 8px !important;
            border: 1px solid var(--border-color) !important;
            background: var(--card-bg) !important;
            color: var(--text-primary) !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-user-btn:hover {
            background: var(--card-bg-hover) !important;
            border-color: var(--border-hover) !important;
        }

        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a.logout-link {
            color: #f43f5e !important;
        }

        .nav-dropdown-menu a.logout-link:hover {
            background: rgba(244, 63, 94, 0.1) !important;
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
      
        <!-- ====== PREMIUM NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none; padding-left: 0px; padding-top: 5px; padding-bottom: 5px; transition: transform 0.2s ease; vertical-align: middle;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 22px; margin: 0; line-height: 1;"></i>
                <span style="font-size: 22px; font-weight: 800; letter-spacing: 0.5px; background: linear-gradient(to right, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Inter', sans-serif; margin: 0; line-height: 1.3;">Legals Forum</span>
            </a>

            <div class="nav-menu-links-premium">
                @foreach($headerMenus as $menu)
                    @if($menu->is_dropdown)
                        <div class="nav-link-dropdown">
                            <button class="nav-link-btn">{{ $menu->title }} <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></button>
                            <div class="nav-dropdown-menu">
                                @foreach($menu->children as $child)
                                    <a href="{{ $child->custom_content ? route('dynamic.page', $child->slug) : $child->url }}">{{ $child->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}" class="nav-link-btn" style="text-decoration:none !important;">{{ $menu->title }}</a>
                    @endif
                @endforeach
            </div>

            <div class="nav-auth">
                @guest
                    <a href="{{ route('login') }}" class="btn-login">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                    @endif
                @else
                    <div class="nav-user-dropdown" id="userDropdown">
                        <button class="nav-user-btn" onclick="document.getElementById('userDropdown').classList.toggle('active')">
                            <i class="fa-solid fa-circle-user"></i>
                            {{ Auth::user()->name }}
                            <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 2px;"></i>
                        </button>
                        <div class="nav-dropdown-menu dropdown-menu-right" style="right: 0; left: auto;">
                            <a href="/home"><i class="fa-solid fa-house"></i> Dashboard</a>
                            <a href="/accounts/profile/{{ Auth::user()->id }}"><i class="fa-solid fa-user"></i> Profile</a>
                            <a href="/accounts/manage-password"><i class="fa-solid fa-gear"></i> Settings</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="/accounts/downloads/{{ Auth::user()->id }}"><i class="fa-solid fa-download"></i> Downloads</a>
                            <a href="/accounts/bookmarks/{{ Auth::user()->id }}"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
                            <a href="/subscription"><i class="fa-solid fa-credit-card"></i> Subscription</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="logout-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-power-off"></i> Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
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
                <div class="pt_for_content">
                    <div class="nav-scroller bg-header-color rounded shadow-sm">
                        <nav class="nav nav-underline">
                            <a class="nav-link active text-white" href="/pre-1992-legislation">All Pre 4th Republic Laws</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/1/First Republic">1st Republic Laws</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/2/Second Republic">2nd Republic Laws</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/3/Third Republic">3rd Republic Laws</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/5/NLC Decree">NLCD</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/6/NRC Decree">NRCD</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/7/SMC Decree">SMCD</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/8/AFRC Decree">AFRCD</a>
                            <a class="nav-link text-white" href="/pre_1992_legislation/4/PNDC Law">PNDC</a>
                        </nav>
                    </div>
                </div>
                {{-- Start of container content --}}
                <div class="" style="height: auto;">
                      <div class="header_only dimension_align">
                          <h5 class="font-weight-bold">{{ $allPre1992Act['title'] }}</h5>
                      </div>
                      {{-- {{$allPost1992Act['post_group']}} --}}
                    <div class="row">
                      <div class="col-2">
                        <div class="sidebar">
                          <button type="button" class="btn btn-outlined btn-sm mb-2 mobile-adjust-1 btn-customised" data-toggle="modal" data-target="#viewActs">Find an Act</button>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                              <a data-scroll-to="body"
                              data-scroll-focus="body"
                              data-scroll-speed="400"
                              data-scroll-offset="-60" class="nav-links tabPaned_table_of_table_color active mb-1 mobile-adjust-1 btn-customised" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Table of Contents</a>
                              <a data-scroll-to="body"
                              data-scroll-focus="body"
                              data-scroll-speed="400"
                              data-scroll-offset="-60" class="nav-links tabPanedHide_acts_content mb-1 mobile-adjust-1 btn-customised" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Content</a>
                              <a data-scroll-to="body"
                              data-scroll-focus="body"
                              data-scroll-speed="400"
                              data-scroll-offset="-60" class="nav-links tabPanedHide_expanded_view mb-1 mobile-adjust-1 btn-customised" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Expanded View</a>
                              <a data-scroll-to="body"
                              data-scroll-focus="body"
                              data-scroll-speed="400"
                              data-scroll-offset="-60" class="nav-links tabPanedHide_amendments mb-1 mobile-adjust-1 btn-customised" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Amendments</a>
                              <a data-scroll-to="body"
                              data-scroll-focus="body"
                              data-scroll-speed="400"
                              data-scroll-offset="-60" class="nav-links tabPanedHide_amendments_table mb-1 mobile-adjust-1 btn-customised" id="v-pills-amendments-tab" data-toggle="pill" href="#v-pills-amendments" role="tab" aria-controls="v-pills-amendments" aria-selected="false">Table of Contents (Amendments)</a>
                              <a data-scroll-to="body"
                              data-scroll-focus="body"
                              data-scroll-speed="400"
                              data-scroll-offset="-60" class="nav-links tabPanedHide_amendments_content mb-1 mobile-adjust-1 btn-customised" id="v-pills-amendments-content-tab" data-toggle="pill" href="#v-pills-amendments-content" role="tab" aria-controls="v-pills-amendments-content" aria-selected="false">Contents (Amendments)</a>
                              
                              <a class="nav-links tabPanedHide_regulations mb-1" id="v-pills-regulations-tab" data-toggle="pill" href="#v-pills-regulations" role="tab" aria-controls="v-pills-regulations" aria-selected="false">Regulations</a>
                              <a class="nav-links tabPanedHide_regulations_table mb-1" id="v-pills-regulations-table-of-content-tab" data-toggle="pill" href="#v-pills-regulations-table-of-content" role="tab" aria-controls="v-pills-regulations-table-of-content" aria-selected="false">Table of Contents (Regulations)</a>
                              <a class="nav-links tabPanedHide_regulations_content mb-1" id="v-pills-regulations-content-tab" data-toggle="pill" href="#v-pills-regulations-content" role="tab" aria-controls="v-pills-regulations-content" aria-selected="false">Contents (Regulations)</a>
                            </div>
                        </div>
                      </div>

                      <div class="col-10 mobile-adjust-2">
                        <div class="tab-content" id="v-pills-tabContent">

                          {{-- table of content --}}
                          <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                              <div class="col-md-9">
                                
                                  <a class="pre_preamble_content_link" href="/pre_1992_legislation/preamble/{{ $allPre1992Act['id'] }}">
                                    
                                  @if($allPre1992Act['preamble'] != null)
                                      <span style="color: blue;" class="preamble_hide">Introductory Text</span><hr>
                                      @else
                                          @section('scripts')
                                              <script>
                                              $( ".preamble_hide" ).hide();
                                              </script>
                                          @endsection
                                  @endif

                                </a>
                                      <div class="accordion-content">
                                          @include('pre_1992_legislation.new_pre_displayed_parts_sections')
                                      </div>

                                      <center>
                                        <div class="hide-on-desktop mt-3 flex">
                                        
                                          <a class="btn btn-outline-dark btn-sm expanded_link toggle_expanded_view btn-customised" href="/pre_1992_legislation/1/{{$allPre1992Act['pre_1992_group']}}/{{$allPre1992Act['title']}}/expanded-view/{{ $allPre1992Act['id'] }}" role="button">Expanded View</a>
                                          
                                          @if (Route::has('login'))
                                            @auth
                                                  {{-- No Subscription --}}
                                                  @if(auth()->user()->check_subscription == 0)
                                                    <a class="btn btn-outline-dark btn-sm" href="" data-toggle="modal" data-target="#myModalplainSubscribe">Plain View</a>
                                                    {{-- Subscription has expired --}}
                                                    @elseif(auth()->user()->subscription_expiry < today())
                                                    <a class="btn btn-outline-dark btn-sm" href="" data-toggle="modal" data-target="#myModalplainExpiry">Plain View</a>                                          
                                                    {{-- Subscription download limit reached --}}
                                                    @elseif(auth()->user()->subscription_downloads <= auth()->user()->downloads_counts)
                                                    <a class="btn btn-outline-dark btn-sm" href="" data-toggle="modal" data-target="#maximumDownloadReachedplain">Plain View</a>
                                                
                                                    @else
                                                    {{-- View Plain View --}}
                                                      {{-- <a class="btn btn-outline-dark btn-sm btn-customised" href="/post_1992_legislation/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/plain_view/{{ $allPost1992Act['id'] }}" target="_blank">Plain View</a> --}}
                                                  @endif
                                                @else
                                              {{-- Create Account --}}
                                              <a class="btn btn-outline-dark btn-sm btn-customised" href="" data-toggle="modal" data-target="#myModalplainAccount">Plain View</a>
                                            @endauth
                                          @endif                                        
                                        </div>
                                      </center>
                                      
                                      @include('layouts.plain_view_no_subscription')
                                      @include('layouts.plain_view_subscription_expiry')
                                      @include('layouts.plain_view_downloaded_exceeded')
                                      @include('layouts.plain_create_account')

                              </div>
                              @include('pre_1992_legislation.new_pre_container_main_act_page')
                            </div>
                            {{-- <a id="back-to-top" href="#" class="back-to-top">
                              <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-up-circle-fill" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-10.646.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
                              </svg>
                            </a> --}}
                          </div>
                          {{-- end of table of content --}}

                          {{-- remove table-wrapper-scroll-display --}}
                          {{-- Contents --}}
                          <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">

                              <div class="col-md-9" style="height: auto">
                                <div id="display_content"></div>
                                <div id="display_view_all_section"></div>
                                  
                                {{--Select Sections, Previous and Next button on Content --}}
                                <center>
                                  <div class="hide-on-desktop mt-3 flex">
                                    <div class="dropdown mb-3">
                                      <a class="btn btn-outline-dark dropdown-toggle btn-customised" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span>Select Sections</span>
                                      </a>
                                      <div class="dropdown-menu scroll-view btn-customised" aria-labelledby="dropdownMenuLink-3">
                                        @foreach($allPre1992Articles as $allPre1992Article)
                                            <a data-scroll-to="body"
                                            data-scroll-focus="body"
                                            data-scroll-speed="400"
                                            data-scroll-offset="-60" class="pre_view_all_section_link_with_prev_next dropdown-item" sid="{{$allPre1992Article->id}}" href="/pre_1992_legislation/content/{{ $allPre1992Article->id }}">{{$allPre1992Article->section }}
                                            </a>
                                        @endforeach              
                                      </div>
                                    </div>

                                  <div class="mb-2 preamble_hide_pre_next"> 
                                    <button a data-scroll-to="body"
                                    data-scroll-focus="body"
                                    data-scroll-speed="400"
                                    data-scroll-offset="-60" type="button" class="btn btn-outline-dark btn-sm previous_content_pre_act btn-customised">
                                    &laquo;&nbsp;Previous
                                    </button>

                                    <button a data-scroll-to="body"
                                    data-scroll-focus="body"
                                    data-scroll-speed="400"
                                    data-scroll-offset="-60" type="button" class="btn btn-outline-dark btn-sm next_content_pre_act btn-customised">
                                    Next&nbsp;&raquo;
                                    </button>
                                  </div>

                                  </div>
                                </center>

                              </div>
                              @include('pre_1992_legislation.new_pre_container_details_main_act_page')

                            </div> 
                            {{-- <a id="back-to-top-content" href="#" class="back-to-top">
                              <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-up-circle-fill" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-10.646.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
                              </svg>
                            </a>         --}}
                          </div>
                          {{-- end of content --}}

                          {{-- expanded --}}
                          <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                              <div class="col-md-12" style="height: auto;">
                                <div id="acts_expanded_view"></div> 
                              </div>
                            </div>
                            {{-- <a id="back-to-top-expanded" href="#" class="back-to-top-expanded">
                              <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-up-circle-fill" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-10.646.354a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.207V11a.5.5 0 0 1-1 0V6.207L5.354 8.354z"/>
                              </svg>
                            </a>                           --}}
                          </div>
                          {{-- end of expanded --}}

                        </div>
                        {{-- end of v-pills-tab-content --}}

                      </div>
                      {{-- end of col-10 --}}

                    </div>
                    {{-- end of main row --}}
              
                </div>
                {{-- end of container content --}}

                <!-- View Other cases -->
                <div class="modal fade" id="viewActs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><b>Select Pre-4th Republic Laws</b></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                          </div>
                          <div class="modal-body text-left">
                            <table class="table table-striped table-condensed" id="datatable">
                              <thead>
                                  <tr>
                                    <th>All Pre-1992 Legislation</th>
                                    <th>Year</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($allPre1992Acts as $allPre1992Act)
                                    <tr>
                                        <td>
                                            <a href="/pre_1992_legislation/{{$allPre1992Act->pre_1992_group}}/{{ $allPre1992Act->title }}/{{ $allPre1992Act->id}}"><li style="list-style: none;">{{ $allPre1992Act->title }}</li></a>
                                        </td> 
                                        <td>{{ $allPre1992Act->year }}</td>
                                    </tr>
                                @endforeach  
                              </tbody>
                          </table>
                          </div>
                          
                      </div>
                    </div>
                  </div>
        
            </div>
        </div>

        {{-- For ads --}}
        <div class="col-md-3 fixing_top p-3 bg-white rounded shadow-sm">
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
		$('#back-to-top, #back-to-top-content, #back-to-top-expanded').click(function () {
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

</body>
</html>
