<!doctype html>
<html lang="en" style="background-color:#070a13;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Explore pre-1992 legislation laws on Legals Forum.">
    <title>Third Republic - Legals Forum</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    
    <style>
        /* ============================================
           THEME & CSS VARIABLES
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

        body {
            font-family: var(--font);
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            padding-top: 90px;
            padding-bottom: 40px;
        }

        /* ============================================
           PREMIUM FIXED NAVIGATION BAR
           ============================================ */
        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            z-index: 1000;
            background: rgba(6, 10, 19, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }
        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            line-height: 1;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none !important;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover {
            transform: scale(1.03);
        }

        .nav-logo-text {
            display: inline-block;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: 'Inter', sans-serif;
            margin: 0;
            line-height: 1.3;
        }

        .nav-mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 22px;
            cursor: pointer;
            padding: 8px;
        }

        .mobile-nav-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(6, 10, 19, 0.98);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            z-index: 999999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.4s;
        }

        .mobile-nav-panel.open {
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav-panel a {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-secondary);
            padding: 12px 24px;
            border-radius: 12px;
            line-height: 1.5;
            transform: translateY(24px);
            opacity: 0;
            transition: all 0.3s ease, transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
            text-decoration: none !important;
        }

        .mobile-nav-panel.open a {
            transform: translateY(0);
            opacity: 1;
        }

        .mobile-nav-panel.open a:nth-of-type(1) { transition-delay: 0.05s; }
        .mobile-nav-panel.open a:nth-of-type(2) { transition-delay: 0.1s; }
        .mobile-nav-panel.open a:nth-of-type(3) { transition-delay: 0.15s; }
        .mobile-nav-panel.open a:nth-of-type(4) { transition-delay: 0.2s; }
        .mobile-nav-panel.open a:nth-of-type(5) { transition-delay: 0.25s; }
        .mobile-nav-panel.open a:nth-of-type(6) { transition-delay: 0.3s; }
        .mobile-nav-panel.open a:nth-of-type(7) { transition-delay: 0.35s; }
        .mobile-nav-panel.open a:nth-of-type(8) { transition-delay: 0.4s; }
        .mobile-nav-panel.open a:nth-of-type(9) { transition-delay: 0.45s; }
        .mobile-nav-panel.open a:nth-of-type(10) { transition-delay: 0.5s; }

        .mobile-nav-panel a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px) scale(1.05);
        }

        .mobile-nav-close {
            position: absolute;
            top: 24px;
            right: 24px;
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
            color: var(--text-primary);
            font-size: 28px;
            cursor: pointer;
            opacity: 0;
            transform: rotate(-90deg) scale(0.5);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.25s;
        }

        .mobile-nav-panel.open .mobile-nav-close {
            opacity: 1;
            transform: rotate(0) scale(1);
        }

        @media (max-width: 991px) {
            .nav-inner { padding: 14px 20px !important; }
            .nav-menu-links-premium { display: none !important; }
            .nav-mobile-toggle { display: block !important; }
            .nav-auth { display: none !important; }
        }

        @media (max-width: 768px) {
            .nav-logo-text {
                font-size: 18px !important;
                letter-spacing: 0.2px !important;
            }
        }
        .nav-menu-links-premium {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .nav-link-dropdown { position: relative; }
        .nav-link-btn {
            font-size: 14px; font-weight: 500; color: var(--text-secondary);
            padding: 8px 14px; border-radius: 8px; background: transparent;
            border: none; cursor: pointer; transition: all 0.3s ease;
            display: flex; align-items: center; gap: 6px;
        }
        .nav-link-btn:hover { color: var(--text-primary); background: rgba(255,255,255,0.05); }
        .nav-link-btn i { font-size: 10px; color: var(--text-muted); }
        .nav-dropdown-menu {
            position: absolute; top: calc(100% + 8px); left: 0; min-width: 220px;
            background: rgba(17,24,39,0.95); backdrop-filter: blur(20px);
            border: 1px solid var(--border-color); border-radius: 12px; padding: 8px;
            opacity: 0; visibility: hidden; transform: translateY(-10px);
            transition: all 0.3s ease; z-index: 100; box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .nav-link-dropdown:hover .nav-dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-dropdown-menu a {
            display: flex; align-items: center; gap: 10px; padding: 10px 14px;
            border-radius: 8px; font-size: 14px; color: var(--text-secondary);
            transition: all 0.2s ease; text-decoration: none !important;
        }
        .nav-dropdown-menu a:hover { color: var(--text-primary); background: rgba(255,255,255,0.06); }
        .nav-dropdown-divider { height: 1px; background: var(--border-color); margin: 6px 0; }
        .nav-auth { display: flex; align-items: center; gap: 12px; }
        .btn-login {
            font-size: 13px; font-weight: 600; color: var(--text-primary);
            padding: 8px 18px; border-radius: 8px; border: 1px solid var(--border-hover);
            background: transparent; cursor: pointer; transition: all 0.3s ease;
        }
        .btn-login:hover { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.2); }
        .btn-signup {
            font-size: 13px; font-weight: 600; color: #fff; padding: 8px 18px;
            border-radius: 8px; border: none; background: var(--accent-gradient);
            cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px var(--accent-glow);
        }
        .btn-signup:hover { transform: translateY(-1px); box-shadow: 0 6px 18px var(--accent-glow); }
        .nav-user-dropdown { position: relative; }
        .nav-user-btn {
            display: flex; align-items: center; gap: 8px; padding: 8px 14px;
            border-radius: 8px; border: 1px solid var(--border-color);
            background: var(--card-bg); color: var(--text-primary); font-size: 14px;
            font-weight: 500; cursor: pointer; transition: all 0.3s ease;
        }
        .nav-user-btn:hover { background: var(--card-bg-hover); border-color: var(--border-hover); }
        .nav-user-dropdown.active .nav-dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
        .nav-dropdown-menu a.logout-link { color: #f43f5e; }
        .nav-dropdown-menu a.logout-link:hover { background: rgba(244,63,94,0.1); }

        /* ============================================
           WORKSPACE COMPONENTS & CARDS
           ============================================ */
        .premium-card {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            padding: 24px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
            margin-bottom: 24px;
        }
        .premium-sidebar-card {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            padding: 20px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important;
            margin-bottom: 24px;
        }

        /* Vertical Tabs Navigation */
        .vertical-nav-group { display: flex; flex-direction: column; }
        .vertical-nav-link {
            font-size: 13px !important; font-weight: 500 !important;
            color: var(--text-secondary) !important; padding: 12px 20px !important;
            border-left: 3px solid transparent !important; transition: all 0.25s ease !important;
            text-decoration: none !important; display: flex !important; align-items: center;
            cursor: pointer;
        }
        .vertical-nav-link:hover {
            color: var(--text-primary) !important;
            background: rgba(255,255,255,0.03) !important;
            border-left-color: rgba(255,255,255,0.1) !important;
        }
        .vertical-nav-link.active {
            color: #fff !important;
            background: rgba(59,130,246,0.08) !important;
            border-left-color: var(--accent) !important;
            font-weight: 600 !important;
        }

        /* Loading spinner overlay */
        .table-loading-overlay {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(6,10,19,0.7); display: flex; align-items: center;
            justify-content: center; z-index: 10; border-radius: 16px;
            backdrop-filter: blur(4px); opacity: 0; visibility: hidden;
            transition: all 0.2s ease;
        }
        .table-loading-overlay.show { opacity: 1; visibility: visible; }
        .spinner-dot {
            width: 10px; height: 10px; border-radius: 50%; margin: 0 4px;
            animation: dotPulse 1.2s ease-in-out infinite;
        }
        .spinner-dot:nth-child(1) { background: var(--accent); animation-delay: 0s; }
        .spinner-dot:nth-child(2) { background: #8b5cf6; animation-delay: 0.15s; }
        .spinner-dot:nth-child(3) { background: var(--accent-light); animation-delay: 0.3s; }
        @keyframes dotPulse {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1); opacity: 1; }
        }

        /* ============================================
           PREMIUM DATATABLE OVERRIDES
           ============================================ */
        #datatable {
            background-color: #0c1220 !important;
            color: var(--text-secondary) !important;
            border-collapse: collapse !important;
        }
        #datatable th {
            background-color: #0c1220 !important;
            border-bottom: 2px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            font-weight: 700 !important; font-size: 12px !important;
            text-transform: uppercase; letter-spacing: 0.5px; padding: 14px 16px !important;
        }
        #datatable td {
            background-color: #0c1220 !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: rgba(255,255,255,0.8) !important;
            font-size: 14px !important; padding: 14px 16px !important;
        }
        #datatable tbody tr:hover,
        #datatable tbody tr:hover td,
        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover,
        .table-hover tbody tr:hover,
        .table-hover tbody tr:hover td {
            background-color: rgba(255,255,255,0.05) !important;
            background: rgba(255,255,255,0.05) !important;
            color: #fff !important;
        }
        #datatable td a {
            color: var(--accent-light) !important; font-weight: 600 !important;
            text-decoration: none !important;
        }
        #datatable td a:hover { color: var(--gold) !important; text-decoration: underline !important; }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important; font-size: 13px !important; margin-bottom: 15px;
        }
        .dataTables_wrapper .dataTables_filter input {
            background: rgba(17,24,39,0.7) !important; border: 1px solid var(--border-color) !important;
            border-radius: 8px !important; color: var(--text-primary) !important;
            padding: 6px 12px !important; font-size: 13px !important; outline: none !important; margin-left: 8px;
        }
        .dataTables_wrapper .dataTables_length select {
            background: rgba(17,24,39,0.7) !important; border: 1px solid var(--border-color) !important;
            border-radius: 8px !important; color: var(--text-primary) !important;
            padding: 4px 8px !important; outline: none !important; margin: 0 4px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important; border-radius: 6px !important;
            border: 1px solid var(--border-color) !important; padding: 4px 10px !important;
            margin: 0 2px !important; cursor: pointer !important; background: transparent !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(255,255,255,0.05) !important; color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--accent-gradient) !important; color: #fff !important;
            border: 1px solid var(--accent) !important; box-shadow: 0 4px 12px var(--accent-glow) !important;
        }

        /* Form Controls */
        .premium-input {
            background: rgba(17,24,39,0.6) !important; border: 1px solid var(--border-color) !important;
            color: #fff !important; border-radius: 8px !important; padding: 8px 12px !important;
            font-size: 13px !important; outline: none !important; transition: all 0.3s ease;
        }
        .premium-input:focus { border-color: var(--accent) !important; box-shadow: 0 0 0 2px var(--accent-glow) !important; }
        .premium-select {
            background: rgba(17,24,39,0.8) !important; border: 1px solid var(--border-color) !important;
            color: #fff !important; border-radius: 8px !important; padding: 6px 12px !important;
            font-size: 13px !important; outline: none !important; width: 100%;
        }
        .premium-select option { background-color: #0c1220; color: #fff; }

        /* Scrollbars */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--border-hover); }
    </style>
  </head>
  <body>
      
    <!-- ====== PREMIUM NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 22px;"></i>
                <span class="nav-logo-text">Legals Forum</span>
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
            <button class="nav-mobile-toggle" onclick="document.getElementById('mobileNav').classList.add('open')" title="Toggle Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Nav Panel -->
    <div class="mobile-nav-panel" id="mobileNav">
        <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open')">
            <i class="fa-solid fa-xmark"></i>
        </button>
        @foreach($headerMenus as $menu)
            @if($menu->is_dropdown)
                @php
                    $url = '#';
                    if ($menu->children && count($menu->children) > 0) {
                        $firstChild = $menu->children->first();
                        $url = $firstChild->custom_content ? route('dynamic.page', $firstChild->slug) : $firstChild->url;
                    }
                @endphp
                <a href="{{ $url }}">{{ $menu->title }}</a>
            @else
                <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}">{{ $menu->title }}</a>
            @endif
        @endforeach
        <div style="height: 16px;"></div>
        @guest
            <a href="{{ route('login') }}">Log In</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" style="color: var(--accent-light);">Sign Up Free</a>
            @endif
        @else
            <a href="/home">Dashboard</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f43f5e;">Sign Out</a>
        @endguest
    </div>

    <!-- ====== 3-COLUMN PORTAL AREA ====== -->
    <div class="container-fluid px-md-4 mt-4">
        <div class="row">
            
            <!-- Left Column: Vertical Menu -->
            <div class="col-lg-3 col-md-4">
                <div class="premium-sidebar-card p-0" style="overflow: hidden; position: sticky; top: 90px;">
                    <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-color);">
                        <h5 style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-folder-open text-primary"></i> Pre-4th Republic
                        </h5>
                    </div>
                    <div class="vertical-nav-group" id="sidebarNav">
                        <a class="vertical-nav-link " data-group="all" data-label="All Pre-1992 Legislation" href="javascript:void(0)"><i class="fa-solid fa-landmark mr-3" style="width: 16px; text-align: center;"></i> All Laws</a>
                        <a class="vertical-nav-link " data-group="1" data-label="First Republic Legislation" href="javascript:void(0)"><i class="fa-solid fa-gavel mr-3" style="width: 16px; text-align: center;"></i> 1st Republic</a>
                        <a class="vertical-nav-link " data-group="2" data-label="Second Republic Legislation" href="javascript:void(0)"><i class="fa-solid fa-scale-balanced mr-3" style="width: 16px; text-align: center;"></i> 2nd Republic</a>
                        <a class="vertical-nav-link active" data-group="3" data-label="Third Republic Legislation" href="javascript:void(0)"><i class="fa-solid fa-shield-halved mr-3" style="width: 16px; text-align: center;"></i> 3rd Republic</a>
                        <a class="vertical-nav-link " data-group="5" data-label="NLC Decree" href="javascript:void(0)"><i class="fa-solid fa-building-columns mr-3" style="width: 16px; text-align: center;"></i> NLCD</a>
                        <a class="vertical-nav-link " data-group="6" data-label="NRC Decree" href="javascript:void(0)"><i class="fa-solid fa-scroll mr-3" style="width: 16px; text-align: center;"></i> NRCD</a>
                        <a class="vertical-nav-link " data-group="7" data-label="SMC Decree" href="javascript:void(0)"><i class="fa-solid fa-file-contract mr-3" style="width: 16px; text-align: center;"></i> SMCD</a>
                        <a class="vertical-nav-link " data-group="8" data-label="AFRC Decree" href="javascript:void(0)"><i class="fa-solid fa-signature mr-3" style="width: 16px; text-align: center;"></i> AFRCD</a>
                        <a class="vertical-nav-link " data-group="4" data-label="PNDC Laws" href="javascript:void(0)"><i class="fa-solid fa-book mr-3" style="width: 16px; text-align: center;"></i> PNDC</a>
                    </div>
                </div>
            </div>
            
            <!-- Middle Column: Table -->
            <div class="col-lg-6 col-md-8">
                <div class="premium-card" style="position: relative;">
                    <!-- Loading overlay -->
                    <div class="table-loading-overlay" id="tableLoader">
                        <div style="display: flex; align-items: center;">
                            <div class="spinner-dot"></div>
                            <div class="spinner-dot"></div>
                            <div class="spinner-dot"></div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th id="thColumnName">Third Republic Legislation</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($thirdRepublicActs as $thirdRepublicAct)
                                <tr>
                                    <td>
                                        <a href="/pre_1992_legislation/{{ $thirdRepublicAct->pre_1992_group }}/{{ $thirdRepublicAct->title }}/{{ $thirdRepublicAct->id }}">{{ $thirdRepublicAct->title }}</a>
                                    </td> 
                                    <td>{{ $thirdRepublicAct->year }}</td>  
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Filter & Ads -->
            <div class="col-lg-3 col-md-12 mt-md-4 mt-lg-0">
                @include('ads.small_ads_image_main_page')
                @include('ads.adsense_vertical')
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/slim.js') }}"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
    <script src="{{ asset('js/bootstrap_update.min.js') }}"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    
    <!-- DataTables JS (use full jQuery for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    
    <script>
        $(document).ready(function(){
            // Initialize DataTable with 5 entries pageLength default and option
            var table = $('#datatable').DataTable({
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "ordering": true,
                "responsive": true
            });

            // AJAX tab switching
            $('#sidebarNav').on('click', '.vertical-nav-link', function(e) {
                e.preventDefault();
                var $link = $(this);
                var group = $link.data('group');
                var label = $link.data('label');

                // If already active, do nothing
                if ($link.hasClass('active')) return;

                // Update active state
                $('#sidebarNav .vertical-nav-link').removeClass('active');
                $link.addClass('active');

                // Show loading overlay
                $('#tableLoader').addClass('show');

                // Update table header
                $('#thColumnName').text(label);

                // Fetch data via AJAX
                $.ajax({
                    url: '/pre_1992_legislation/ajax-data',
                    data: { group: group },
                    dataType: 'json',
                    success: function(response) {
                        // Clear existing data and add new rows
                        table.clear();
                        if (response.data && response.data.length > 0) {
                            response.data.forEach(function(item) {
                                table.row.add([
                                    '<a href="' + item.url + '">' + item.title + '</a>',
                                    item.year
                                ]);
                            });
                        }
                        table.draw();

                        // Update browser URL without reload
                        var urlMap = {
                            'all': '/pre-1992-legislation',
                            '1': '/pre_1992_legislation/1/First Republic',
                            '2': '/pre_1992_legislation/2/Second Republic',
                            '3': '/pre_1992_legislation/3/Third Republic',
                            '4': '/pre_1992_legislation/4/PNDC Law',
                            '5': '/pre_1992_legislation/5/NLC Decree',
                            '6': '/pre_1992_legislation/6/NRC Decree',
                            '7': '/pre_1992_legislation/7/SMC Decree',
                            '8': '/pre_1992_legislation/8/AFRC Decree'
                        };
                        if (urlMap[group]) {
                            history.pushState({ group: group }, '', urlMap[group]);
                        }

                        // Hide loading overlay
                        $('#tableLoader').removeClass('show');
                    },
                    error: function() {
                        $('#tableLoader').removeClass('show');
                        alert('Failed to load data. Please try again.');
                    }
                });
            });

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.group) {
                    var link = $('#sidebarNav .vertical-nav-link[data-group="' + e.state.group + '"]');
                    if (link.length) {
                        link.trigger('click');
                    }
                }
            });

            // Close user dropdown on click outside
            document.addEventListener('click', function(e) {
                var dropdown = document.getElementById('userDropdown');
                if (dropdown && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
    </script>
  </body>
</html>
