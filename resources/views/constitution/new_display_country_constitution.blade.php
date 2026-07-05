<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ ucwords(strtolower($allCountriesConstitution['title'])) }} - LawsGhana</title>

    <!-- Google Fonts & Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #070a13;
            --bg-secondary: #0f172a;
            --card-bg: rgba(17, 24, 39, 0.55);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent: #2563eb;
            --accent-light: #60a5fa;
            --accent-glow: rgba(37, 99, 235, 0.15);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --gold: #f59e0b;
            --gold-light: #fbbf24;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 50% 0%, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ====== PREMIUM NAVIGATION ====== */
        .nav-wrap {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(7, 10, 19, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .nav-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
        }

        .nav-logo img {
            height: 38px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover img {
            transform: scale(1.03);
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
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 8px 14px;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            margin-top: 8px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none !important;
            padding: 8px 16px;
            transition: color 0.2s;
        }

        .btn-login:hover {
            color: var(--accent-light);
        }

        .btn-signup {
            font-size: 13.5px;
            font-weight: 600;
            color: #fff !important;
            background: var(--accent-gradient);
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        }

        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 6px 0;
        }

        /* Continent / Sub-navigation header */
        .continent-nav-wrap {
            background: rgba(15, 23, 42, 0.4);
            border-bottom: 1px solid var(--border-color);
            padding: 8px 0;
        }

        .continent-nav-wrap .nav-underline {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            gap: 8px;
            overflow-x: auto;
        }

        .continent-nav-wrap .nav-underline::-webkit-scrollbar {
            display: none;
        }

        .continent-nav-wrap .nav-link {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .continent-nav-wrap .nav-link:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.03);
        }

        .continent-nav-wrap .nav-link.active {
            color: #fff !important;
            background: rgba(59, 130, 246, 0.15) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
        }

        /* ====== MAIN CONTENT & LAYOUT ====== */
        .main-container {
            max-width: 1400px;
            margin: 40px auto 80px;
            padding: 0 24px;
        }

        .premium-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }

        .card-header-styled {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .card-header-styled h5 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ====== READABLE TYPOGRAPHY ====== */
        .reading-header-premium {
            margin-bottom: 24px;
        }

        .continent-badge {
            font-size: 11px;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 6px;
        }

        .reading-header-premium h2 {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .year-badge {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 10px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .judgement_display .content {
            font-size: 16px;
            line-height: 1.8;
            color: var(--text-primary);
        }

        /* Force database inline white HTML text to adapt to dark background */
        .judgement_display .content p,
        .judgement_display .content span,
        .judgement_display .content li,
        .judgement_display .content div,
        .judgement_display .content table,
        .judgement_display .content td,
        .judgement_display .content th,
        .judgement_display .content h1,
        .judgement_display .content h2,
        .judgement_display .content h3,
        .judgement_display .content h4,
        .judgement_display .content h5,
        .judgement_display .content h6 {
            background-color: transparent !important;
            background: transparent !important;
            color: var(--text-primary) !important;
            font-family: 'Inter', sans-serif !important;
        }

        .judgement_display .content p {
            margin-bottom: 24px;
        }

        /* ====== SEARCH BAR UTILITY ====== */
        .search-bar-wrap {
            margin-bottom: 24px;
        }

        .search-input-premium {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            padding: 12px 16px 12px 42px;
            font-size: 14px;
            outline: none;
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-input-premium:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .search-bar-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
        }

        /* ====== ACTIONS BUTTONS ====== */
        .btn-custom-outline {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            font-weight: 500 !important;
            font-size: 13px !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
        }

        .btn-custom-outline:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .back-to-top {
            position: fixed;
            bottom: 40px;
            right: 40px;
            background: var(--accent-gradient);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff !important;
            box-shadow: 0 4px 16px var(--accent-glow);
            transition: all 0.2s ease;
            z-index: 99;
            text-decoration: none !important;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        /* ====== DATATABLES PREMIUM OVERRIDES ====== */
        .dataTables_wrapper {
            padding: 0;
            color: var(--text-secondary) !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: rgba(17, 24, 39, 0.6) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 6px 12px !important;
            outline: none !important;
            margin-left: 8px !important;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 2px var(--accent-glow) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            border-radius: 6px !important;
            border: 1px solid var(--border-color) !important;
            padding: 4px 10px !important;
            background: transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--accent-gradient) !important;
            color: #fff !important;
            border: none !important;
        }

        .table-premium {
            background: transparent !important;
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
            width: 100% !important;
        }

        .table-premium th {
            color: var(--gold) !important;
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 12px 16px !important;
            font-weight: 700 !important;
        }

        .table-premium tr {
            background: rgba(255, 255, 255, 0.02) !important;
        }

        .table-premium td {
            border-top: 1px solid var(--border-color) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 14px 16px !important;
            color: var(--text-primary) !important;
        }

        .table-premium td a {
            color: var(--accent-light) !important;
            font-weight: 600 !important;
        }
    </style>
  </head>
  <body>

    <!-- ====== PREMIUM NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <img src="{{ asset('logo/lawsghlog.png') }}" alt="LawsGhana">
            </a>

            <div class="nav-menu-links-premium">
                <!-- Constitution Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">Constitution <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/constitution/Republic/Ghana/1">Ghana</a>
                        <a href="/constitution/all-countries/1/Africa">Africa</a>
                        <a href="/constitution/all-countries/2/Asia">Asia</a>
                        <a href="/constitution/all-countries/3/Europe">Europe</a>
                        <a href="/constitution/all-countries/4/North-America">North America</a>
                        <a href="/constitution/all-countries/5/South-America">South America</a>
                    </div>
                </div>

                <!-- Pre-4th Republic Laws Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">Pre-4th Republic Laws <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/pre_1992_legislation/1/First Republic">1st Republic</a>
                        <a href="/pre_1992_legislation/2/Second Republic">2nd Republic</a>
                        <a href="/pre_1992_legislation/3/Third Republic">3rd Republic</a>
                        <a href="/pre_1992_legislation/5/NLC Decree">NLC Decree</a>
                        <a href="/pre_1992_legislation/6/NRC Decree">NRC Decree</a>
                        <a href="/pre_1992_legislation/7/SMC Decree">SMC Decree</a>
                        <a href="/pre_1992_legislation/8/AFRC Decree">AFRC Decree</a>
                        <a href="/pre_1992_legislation/4/PNDC Law">PNDC Law</a>
                    </div>
                </div>

                <!-- 4th Republic Laws Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">4th Republic Laws <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/post-1992-legislation/1/Acts of Parliament">Acts of Parliament</a>
                        <a href="/post-1992-legislation/only-regulations">Legislative Instruments</a>
                        <a href="/post-1992-legislation/Constitutional-Intruments">Constitutional Instruments</a>
                        <a href="/post-1992-legislation/Executive-Intruments">Executive Instruments</a>
                        <a href="/post-1992-legislation/only-amendments">Amendments</a>
                    </div>
                </div>

                <a href="/judgement/Ghana" class="nav-link-btn" style="text-decoration:none !important;">Case Laws</a>
                <a href="/News/Ghana-News/1" class="nav-link-btn" style="text-decoration:none !important;">News</a>
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

    <!-- Continent/Sub-Navigation header -->
    <div class="continent-nav-wrap">
        <div class="nav-scroller">
            <nav class="nav nav-underline">
                <a class="nav-link" href="/constitution/all_countries">All Countries</a>
                <a class="nav-link" href="/constitution/Republic/Ghana/1">Ghana</a>
                <a class="nav-link @if($allCountriesConstitution['continent'] == 'Africa') active @endif" href="/constitution/all-countries/1/Africa">Africa</a>
                <a class="nav-link @if($allCountriesConstitution['continent'] == 'Asia') active @endif" href="/constitution/all-countries/2/Asia">Asia</a>
                <a class="nav-link @if($allCountriesConstitution['continent'] == 'Europe') active @endif" href="/constitution/all-countries/3/Europe">Europe</a>
                <a class="nav-link @if($allCountriesConstitution['continent'] == 'North America') active @endif" href="/constitution/all-countries/4/North-America">North America</a>
                <a class="nav-link @if($allCountriesConstitution['continent'] == 'South America') active @endif" href="/constitution/all-countries/5/South-America">South America</a>
            </nav>
        </div>
    </div>

    <!-- ====== MAIN CONTAINER ====== -->
    <div class="main-container">
        <div class="row">
            <!-- Main Content: Reading Panel -->
            <div class="col-lg-9">
                <!-- Search bar across all laws -->
                <div class="search-bar-wrap position-relative">
                    <form action="{{ url('all_constitution_index_search') }}" method="GET">
                        {{ csrf_field() }}
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="search-input-premium" type="search" placeholder="Search keyword in all laws database..." name="search_text">
                    </form>
                </div>

                <div class="premium-card">
                    <!-- Action Headers -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div class="reading-header-premium">
                            <span class="continent-badge">{{ $allCountriesConstitution['continent'] }}</span>
                            <h2>{{ $allCountriesConstitution['country'] }} Constitution</h2>
                            <span class="year-badge">{{ $allCountriesConstitution['year'] }} Edition</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button id="print_options" type="button" class="btn btn-custom-outline open">
                                <i class="fa-solid fa-print mr-1"></i> Print Options
                            </button>
                            <button type="button" class="btn btn-custom-outline" data-toggle="modal" data-target="#viewCases">
                                <i class="fa-solid fa-globe mr-1"></i> Select Country
                            </button>
                        </div>
                    </div>

                    <!-- Print Menu Options (If Auth and Subscribed) -->
                    <div class="menu_options text-right mb-4" style="display: none; background: rgba(255,255,255,0.02); padding: 12px; border-radius: 8px; border: 1px solid var(--border-color);">
                        @if (Route::has('login'))
                            @auth
                                @if(auth()->user()->check_subscription == 0)
                                    @include('layouts.no_subscription')
                                @elseif(auth()->user()->subscription_expiry < today())
                                    @include('layouts.expired_subscription')
                                @elseif(auth()->user()->subscription_downloads <= auth()->user()->downloads_counts)
                                    @include('layouts.exceeded_downloads_subscription')
                                @else
                                    <!-- Options placeholder -->
                                @endif
                            @else
                                <a href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-accent"><i class="fa-solid fa-file-pdf"></i> Download PDF</a>
                                <a href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-custom-outline">Plain View</a>
                                <a href="" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-custom-outline"><i class="fa-solid fa-print"></i> Print</a>

                                <!-- Sign-In Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Log In Required</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" style="color:#fff;">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <p class="text-secondary mb-4">Please log in or register a premium account to view, print, or download PDF versions of constitutions.</p>
                                                <div class="d-flex justify-content-center gap-3">
                                                    <a class="btn btn-accent" href="{{ route('login') }}">Log In</a>
                                                    <a class="btn btn-custom-outline" href="{{ route('register') }}">Sign Up</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            @endauth
                        @endif
                    </div>

                    <!-- Preamble & Document Text Body -->
                    <div class="judgement_display">
                        <div class="content">  
                            <div class="mb-4">{!! $allCountriesConstitution['preamble'] !!}</div>
                            <div>{!! $allCountriesConstitution['content'] !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Advertisements -->
            <div class="col-lg-3">
                <div class="premium-card text-center p-3">
                    @include('ads.content_adsense_vertical')
                </div>
            </div>
        </div>
    </div>

    <!-- Country Selector Modal -->
    <div class="modal fade" id="viewCases" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-globe mr-2 text-primary"></i> Select Country in {{ $allCountriesConstitution['continent'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:#fff;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <table class="table-premium table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>Name of Country</th>
                                <th>Constitution Title</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allCountriesConstitutions as $allCountriesCont)
                                <tr>
                                    <td>{{ $allCountriesCont->country }}</td>
                                    <td>
                                        <a href="/constitution/1/{{ $allCountriesCont->continent }}/{{ $allCountriesCont->country }}/{{ $allCountriesCont->id }}">
                                            {{ $allCountriesCont->title }}
                                        </a>
                                    </td>
                                    <td>{{ $allCountriesCont->year }}</td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top floating button -->
    <a id="back-to-top" href="#" class="back-to-top">
        <i class="fa-solid fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    <script src="{{ asset('js/myscript.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function(){
            $('#datatable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });

            // back-to-top scroll animation
            $('#back-to-top').click(function (e) {
                e.preventDefault();
                $('body,html').animate({
                    scrollTop: 0
                }, 400);
            });

            // Disable copy paste on document body
            $('body').bind('cut copy paste', function (e) {
                e.preventDefault();
            });

            // Close user dropdown on click outside
            document.addEventListener('click', (e) => {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
    </script>
  </body>
</html>
