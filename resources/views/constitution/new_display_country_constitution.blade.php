<!doctype html>
<html lang="en" style="background-color:#070a13;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ ucwords(strtolower($allCountriesConstitution['title'])) }} - Legals Forum</title>

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

        /* Search Highlighting */
        mark.search-highlight {
            background: rgba(234, 179, 8, 0.35) !important;
            color: #fff !important;
            border-radius: 4px !important;
            padding: 2px 4px !important;
            transition: all 0.2s ease !important;
        }

        mark.search-highlight.active-highlight {
            background: #eab308 !important;
            color: #0b0f17 !important;
            box-shadow: 0 0 10px rgba(234, 179, 8, 0.6) !important;
        }

        .sidebar-sticky-wrap {
            position: sticky;
            top: 75px;
            z-index: 10;
        }

        #word-search-card {
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            border-radius: 16px;
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

                /* Premium Continent Scroller */
        .nav-underline-premium {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding: 8px;
            background: rgba(148, 163, 184, 0.08) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.25) !important;
            border-radius: 12px;
            margin-bottom: 24px;
            flex-wrap: nowrap !important;
            position: sticky;
            top: 62px;
            z-index: 99;
        }

        .nav-link-premium {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: var(--text-secondary) !important;
            background: transparent !important;
            border: 1px solid transparent !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            display: inline-flex;
            align-items: center;
            text-decoration: none !important;
        }

        .nav-link-premium:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.04) !important;
        }

        .nav-link-premium.active {
            color: #fff !important;
            background: rgba(59, 130, 246, 0.18) !important;
            border-color: rgba(59, 130, 246, 0.35) !important;
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

        .premium-card.p-0 img.card-img-top,
        .premium-card.p-0 img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 16px;
        }

        .premium-card .card {
            background: transparent !important;
            border: none !important;
            margin-bottom: 0 !important;
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

        /* ============================================
           MODAL & TABLE CUSTOMIZATION
           ============================================ */
        .modal-content {
            background: #0f172a !important; /* Premium dark background */
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6) !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color) !important;
            padding: 20px 24px !important;
        }

        .modal-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: var(--text-primary) !important;
        }

        .modal-body {
            padding: 24px !important;
            background: #0b0f17 !important; /* Slightly darker inner body */
        }

        /* Customize the datatable inside modal */
        #viewCases table.table {
            background: transparent !important;
            color: var(--text-primary) !important;
            margin-bottom: 0 !important;
        }

        #viewCases table.table th {
            color: var(--gold) !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            font-weight: 700 !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 12px 16px !important;
        }

        #viewCases table.table td {
            padding: 12px 16px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
            color: var(--text-secondary) !important;
            vertical-align: middle !important;
        }

        #viewCases table.table tr:hover td {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.02) !important;
        }

        #viewCases table.table td a {
            color: #60a5fa !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
        }

        #viewCases table.table td a:hover {
            color: #3b82f6 !important;
            text-decoration: underline !important;
        }

        /* DataTables controls inside modal */
        #viewCases .dataTables_wrapper {
            color: var(--text-secondary) !important;
        }

        #viewCases .dataTables_length select,
        #viewCases .dataTables_filter input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            outline: none !important;
        }

        #viewCases .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 13px !important;
            padding-top: 16px !important;
        }

        #viewCases .dataTables_paginate {
            padding-top: 16px !important;
        }

        #viewCases .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            margin: 0 2px !important;
            transition: all 0.2s ease !important;
        }

        #viewCases .dataTables_paginate .paginate_button:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        #viewCases .dataTables_paginate .paginate_button.current,
        #viewCases .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
            background: rgba(59, 130, 246, 0.2) !important;
            border-color: rgba(59, 130, 246, 0.4) !important;
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
            right: calc(25% + 20px);
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

    <!-- ====== MAIN CONTAINER ====== -->
    <div class="main-container">
        <div class="row">
            <!-- Main Content: Reading Panel -->
            <div class="col-lg-9">
                <!-- Search bar across all laws -->
                <!-- Premium Continent Tabs Menu -->
                <div class="nav-underline-premium">
                    <a class="nav-link-premium {{ request()->is('constitution/all_countries') ? 'active' : '' }}" href="/constitution/all_countries"><i class="fa-solid fa-globe mr-2"></i> All Countries</a>
                    @foreach($headerMenus as $m)
                        @if($m->slug === 'constitution' || strtolower($m->title) === 'constitution')
                            @foreach($m->children as $child)
                                @if(stripos($child->title, 'Ghana') !== false)
                                    @continue
                                @endif
                                @php
                                    $iconClass = 'fa-book-open';
                                    if (stripos($child->title, 'Africa') !== false) $iconClass = 'fa-earth-africa';
                                    elseif (stripos($child->title, 'Asia') !== false) $iconClass = 'fa-earth-asia';
                                    elseif (stripos($child->title, 'Europe') !== false) $iconClass = 'fa-earth-europe';
                                    elseif (stripos($child->title, 'America') !== false) $iconClass = 'fa-earth-americas';

                                    // Match active tab based on the current constitution's continent
                                    $currentContinent = isset($allCountriesConstitution) ? $allCountriesConstitution['continent'] : '';
                                    $tabIsActive = false;
                                    if (stripos($child->title, 'Africa') !== false && stripos($currentContinent, 'Africa') !== false) {
                                        $tabIsActive = true;
                                    } elseif (stripos($child->title, 'Asia') !== false && stripos($currentContinent, 'Asia') !== false) {
                                        $tabIsActive = true;
                                    } elseif (stripos($child->title, 'Europe') !== false && stripos($currentContinent, 'Europe') !== false) {
                                        $tabIsActive = true;
                                    } elseif (stripos($child->title, 'North America') !== false && stripos($currentContinent, 'North') !== false) {
                                        $tabIsActive = true;
                                    } elseif (stripos($child->title, 'South America') !== false && stripos($currentContinent, 'South') !== false) {
                                        $tabIsActive = true;
                                    }
                                @endphp
                                <a class="nav-link-premium {{ $tabIsActive ? 'active' : '' }}" 
                                   href="{{ $child->custom_content ? route('dynamic.page', $child->slug) : $child->url }}">
                                    <i class="fa-solid {{ $iconClass }} mr-2"></i> {{ $child->title }}
                                </a>
                            @endforeach
                        @endif
                    @endforeach
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
                            <button type="button" class="btn btn-custom-outline" data-toggle="modal" data-target="#viewCases">
                                <i class="fa-solid fa-globe mr-1"></i> Select Country
                            </button>
                        </div>
                    </div>

                    <!-- Preamble & Document Text Body -->
                    <div class="judgement_display">
                        <div class="content" id="constitution-reading-content">  
                            <div class="mb-4">{!! $allCountriesConstitution['preamble'] !!}</div>
                            <div>{!! $allCountriesConstitution['content'] !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Search & Advertisements -->
            <div class="col-lg-3">
                <div class="sidebar-sticky-wrap">
                    <!-- Premium Word Finder Card -->
                    <div class="premium-card mb-4" id="word-search-card" style="padding: 20px;">
                        <div class="card-header-styled" style="margin-bottom: 15px; padding-bottom: 8px;">
                            <h5 style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-magnifying-glass text-primary"></i> Word Finder
                            </h5>
                        </div>
                        <div class="search-box-premium-wrap">
                            <div class="input-group" style="display: flex; width: 100%;">
                                <input type="text" id="document-search-input" class="form-control" placeholder="Find word..." style="
                                    background: rgba(11, 15, 23, 0.6);
                                    border: 1px solid var(--border-color);
                                    color: var(--text-primary);
                                    border-radius: 8px 0 0 8px;
                                    height: 38px;
                                    font-size: 13px;
                                    font-weight: 500;
                                    padding: 8px 12px;
                                    flex: 1;
                                    outline: none;
                                ">
                                <button type="button" id="search-clear-btn" title="Clear search" style="
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid var(--border-color);
                                    border-left: none;
                                    border-right: none;
                                    color: var(--text-muted);
                                    height: 38px;
                                    width: 30px;
                                    cursor: pointer;
                                    display: none;
                                    align-items: center;
                                    justify-content: center;
                                    outline: none;
                                    transition: color 0.2s ease;
                                "><i class="fa-solid fa-xmark" style="font-size: 12px;"></i></button>
                                <span id="document-search-count" style="
                                    background: rgba(11, 15, 23, 0.6);
                                    border-top: 1px solid var(--border-color);
                                    border-bottom: 1px solid var(--border-color);
                                    border-left: none;
                                    border-right: none;
                                    color: var(--text-secondary);
                                    font-size: 11px;
                                    font-weight: 700;
                                    height: 38px;
                                    display: flex;
                                    align-items: center;
                                    padding: 0 8px;
                                    white-space: nowrap;
                                    user-select: none;
                                ">0/0</span>
                                <button type="button" id="search-prev-btn" style="
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid var(--border-color);
                                    border-left: none;
                                    border-right: none;
                                    color: var(--text-secondary);
                                    height: 38px;
                                    width: 32px;
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    outline: none;
                                " disabled><i class="fa-solid fa-chevron-up" style="font-size: 11px;"></i></button>
                                <button type="button" id="search-next-btn" style="
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid var(--border-color);
                                    border-left: none;
                                    border-radius: 0 8px 8px 0;
                                    color: var(--text-secondary);
                                    height: 38px;
                                    width: 32px;
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    outline: none;
                                " disabled><i class="fa-solid fa-chevron-down" style="font-size: 11px;"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Advertisement Module -->
                    <div class="premium-card p-0" style="overflow: hidden;">
                        @include('ads.small_ads_image_main_page')
                    </div>
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

            // Premium document word search highlighting and navigation
            let currentIndex = -1;
            let highlights = [];
            let originalHTML = "";
            const contentArea = document.getElementById('constitution-reading-content');
            if (contentArea) {
                originalHTML = contentArea.innerHTML;
            }
            
            const searchInput = document.getElementById('document-search-input');
            const prevBtn = document.getElementById('search-prev-btn');
            const nextBtn = document.getElementById('search-next-btn');
            const clearBtn = document.getElementById('search-clear-btn');
            const countLabel = document.getElementById('document-search-count');
            
            if (searchInput && prevBtn && nextBtn && countLabel) {
                searchInput.addEventListener('input', function() {
                    performSearch(searchInput.value.trim());
                    // Show/hide clear button based on input content
                    if (clearBtn) {
                        clearBtn.style.display = searchInput.value.length > 0 ? 'flex' : 'none';
                    }
                });
                
                // Clear button: reset input, remove highlights, hide self
                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        performSearch('');
                        clearBtn.style.display = 'none';
                        searchInput.focus();
                    });
                }
                
                prevBtn.addEventListener('click', function() {
                    if (highlights.length > 0) {
                        currentIndex = (currentIndex - 1 + highlights.length) % highlights.length;
                        navigateToHighlight();
                    }
                });
                
                nextBtn.addEventListener('click', function() {
                    if (highlights.length > 0) {
                        currentIndex = (currentIndex + 1) % highlights.length;
                        navigateToHighlight();
                    }
                });
            }
            
            function performSearch(query) {
                if (!contentArea) return;
                
                // Clear previous highlights
                contentArea.innerHTML = originalHTML;
                currentIndex = -1;
                highlights = [];
                
                if (!query || query.length < 2) {
                    countLabel.textContent = "0/0";
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                    return;
                }
                
                highlightTextNodes(contentArea, query);
                highlights = contentArea.querySelectorAll('.search-highlight');
                
                if (highlights.length > 0) {
                    currentIndex = 0;
                    countLabel.textContent = `1/${highlights.length}`;
                    prevBtn.disabled = false;
                    nextBtn.disabled = false;
                    navigateToHighlight();
                } else {
                    countLabel.textContent = "0/0";
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                }
            }
            
            function highlightTextNodes(node, query) {
                if (node.nodeType === Node.TEXT_NODE) {
                    const text = node.nodeValue;
                    const regex = new RegExp('(' + escapeRegExp(query) + ')', 'gi');
                    if (regex.test(text)) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = text.replace(regex, '<mark class="search-highlight">$1</mark>');
                        while (tempDiv.firstChild) {
                            node.parentNode.insertBefore(tempDiv.firstChild, node);
                        }
                        node.parentNode.removeChild(node);
                    }
                } else if (node.nodeType === Node.ELEMENT_NODE && node.nodeName !== 'SCRIPT' && node.nodeName !== 'STYLE') {
                    const children = Array.from(node.childNodes);
                    for (const child of children) {
                        highlightTextNodes(child, query);
                    }
                }
            }
            
            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }
            
            function navigateToHighlight() {
                highlights.forEach(h => {
                    h.classList.remove('active-highlight');
                    h.style.background = 'rgba(234, 179, 8, 0.35)';
                    h.style.color = '#fff';
                });
                
                if (currentIndex >= 0 && currentIndex < highlights.length) {
                    const active = highlights[currentIndex];
                    active.classList.add('active-highlight');
                    active.style.background = '#eab308';
                    active.style.color = '#0b0f17';
                    
                    countLabel.textContent = `${currentIndex + 1}/${highlights.length}`;
                    
                    active.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        });
    </script>
  </body>
</html>
