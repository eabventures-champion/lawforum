<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Legals Forum Community')</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.65);
            --card-bg-hover: rgba(25, 35, 55, 0.8);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.16);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-glow: rgba(245, 158, 11, 0.2);
            --emerald: #10b981;
            --emerald-glow: rgba(16, 185, 129, 0.2);
            --rose: #f43f5e;
            --rose-glow: rgba(244, 63, 94, 0.2);
            --violet: #8b5cf6;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --font-heading: 'Outfit', sans-serif;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font);
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: all 0.25s ease;
        }

        /* Embedded inside dashboard workspace */
        body.is-embedded .nav-wrap,
        body.is-embedded #mainNav,
        html.is-embedded .nav-wrap,
        html.is-embedded #mainNav {
            display: none !important;
        }

        body.is-embedded .content-body,
        html.is-embedded .content-body {
            margin-top: 0 !important;
            padding: 24px 20px 40px !important;
            max-width: 100% !important;
        }

        body.is-embedded {
            background: transparent !important;
            background-color: transparent !important;
            min-height: auto !important;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
        }

        html.is-embedded::-webkit-scrollbar,
        body.is-embedded::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        html.is-embedded::-webkit-scrollbar-track,
        body.is-embedded::-webkit-scrollbar-track {
            background: transparent;
        }

        html.is-embedded::-webkit-scrollbar-thumb,
        body.is-embedded::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.18);
            border-radius: 4px;
        }

        html.is-embedded::-webkit-scrollbar-thumb:hover,
        body.is-embedded::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        /* Navigation - Matching Homepage Navbar Exactly */
        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 100001;
            background: rgba(6, 10, 19, 0.96) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            line-height: 1;
        }

        .nav-logo,
        .nav-logo:hover,
        .nav-logo:focus,
        .nav-logo:active,
        .nav-logo:visited {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none !important;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover,
        .nav-logo:focus,
        .nav-logo:active {
            transform: scale(1.03);
            text-decoration: none !important;
        }

        .nav-logo *,
        .nav-logo-text {
            text-decoration: none !important;
        }

        .nav-logo-text {
            display: inline-block;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: 'Inter', sans-serif !important;
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

        .nav-menu-links-premium {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-menu-links-premium a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none !important;
        }

        .nav-menu-links-premium a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Dropdown navbar styles for homepage & portal */
        .nav-link-dropdown {
            position: relative;
        }

        .nav-link-btn {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 8px 16px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            outline: none;
            text-decoration: none !important;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05) !important;
        }

        /* Active Navigation Menu Item (Matches Constitution master standard) */
        .nav-link-btn.active,
        .nav-link-dropdown.active > .nav-link-btn {
            color: #ffffff !important;
            background: rgba(59, 130, 246, 0.15) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
            font-weight: 600 !important;
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.2) !important;
        }

        .nav-link-btn.active:hover,
        .nav-link-dropdown.active > .nav-link-btn:hover {
            background: rgba(59, 130, 246, 0.22) !important;
            border-color: rgba(59, 130, 246, 0.45) !important;
            color: #ffffff !important;
        }

        .nav-link-btn.active i,
        .nav-link-dropdown.active > .nav-link-btn i {
            color: var(--accent-light, #60a5fa) !important;
        }

        .nav-dropdown-menu a.active {
            color: var(--accent-light, #60a5fa) !important;
            background: rgba(59, 130, 246, 0.12) !important;
            font-weight: 600 !important;
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            min-width: 220px;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px !important;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-secondary) !important;
            transition: all 0.2s ease;
            text-align: left;
            text-decoration: none !important;
            width: 100%;
            background: transparent !important;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.06) !important;
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            padding: 9px 22px;
            border-radius: 10px;
            border: 1px solid var(--border-hover);
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-signup {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #fff !important;
            padding: 9px 22px !important;
            border-radius: 10px !important;
            border: none !important;
            background: var(--accent-gradient, linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%)) !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px var(--accent-glow, rgba(59, 130, 246, 0.3)) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .btn-signup:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px var(--accent-glow, rgba(59, 130, 246, 0.45)) !important;
            color: #fff !important;
        }

        .mobile-nav-right {
            display: none;
        }
        .nav-mobile-toggle {
            background: none;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }

        /* Mobile drawer */
        .mobile-nav-panel {
            position: fixed;
            top: 0;
            right: -320px;
            width: 300px;
            height: 100%;
            background: #0c1220;
            border-left: 1px solid var(--border-color);
            z-index: 200000;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            overflow-y: auto;
            transition: right 0.3s ease;
        }
        .mobile-nav-panel.open {
            right: 0;
        }
        .mobile-nav-close {
            align-self: flex-end;
            background: none;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            margin-bottom: 16px;
        }

        .content-body {
            flex: 1;
            margin-top: 76px;
            padding: 40px 24px;
            max-width: 1320px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 991px) {
            .nav-menu-links-premium, .nav-auth {
                display: none;
            }
            .mobile-nav-right {
                display: flex;
                align-items: center;
                gap: 12px;
            }
        }
    </style>
    @include('partials._nav_subdropdown_styles')
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 22px; line-height: 1;"></i>
                <span class="nav-logo-text">Legals Forum</span>
            </a>

            <div class="nav-menu-links-premium">
                @include('partials._nav_desktop_menu')
            </div>

            <div class="nav-auth">
                @guest
                    <a href="/" class="btn-login">Why Choose Us</a>
                    @if(request()->cookie('guest_access'))
                        <a href="javascript:void(0)" onclick="openLoginModal()" class="btn-signup" style="cursor: pointer;">
                            <i class="fa-solid fa-user-secret" style="margin-right: 6px;"></i> Guest User
                        </a>
                    @else
                        <a href="/get-started" class="btn-signup">Sign Up Free</a>
                    @endif
                @else
                    <a href="/home" class="btn-login"><i class="fa-solid fa-house mr-1"></i> Dashboard</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn-login" style="color: #f43f5e;">
                        <i class="fa-solid fa-power-off mr-1"></i> Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                @endguest
            </div>

            <div class="mobile-nav-right">
                <button class="nav-mobile-toggle" onclick="document.getElementById('mobileNav').classList.add('open')">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Drawer -->
    <div class="mobile-nav-panel" id="mobileNav">
        <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open')">
            <i class="fa-solid fa-xmark"></i>
        </button>
        @include('partials._nav_mobile_menu')
        <div style="height: 16px;"></div>
        @guest
            <a href="/">Why Choose Us</a>
            @if(request()->cookie('guest_access'))
                <a href="javascript:void(0)" onclick="openLoginModal(); document.getElementById('mobileNav').classList.remove('open');" style="color: var(--text-secondary); cursor: pointer;"><i class="fa-solid fa-user-secret"></i> Guest User</a>
            @else
                <a href="/get-started" style="color: var(--accent-light);">Sign Up Free</a>
            @endif
        @else
            <a href="/home">Dashboard</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f43f5e;">Sign Out</a>
        @endguest
    </div>

    <!-- Main Content -->
    <main class="content-body">
        @yield('content')
    </main>

    @include('partials._login_modal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        if (window.self !== window.top || window.location.search.indexOf('embedded=1') !== -1) {
            document.documentElement.classList.add('is-embedded');
            if (document.body) document.body.classList.add('is-embedded');

            // Automatically preserve embedded=1 on internal links within iframe
            document.querySelectorAll('a[href^="/chatroom"], a[href^="/marketplace"], a[href^="/jobs"]').forEach(function(link) {
                var href = link.getAttribute('href');
                if (href && href.indexOf('embedded=1') === -1 && href !== '#' && !href.startsWith('javascript:')) {
                    var sep = href.indexOf('?') !== -1 ? '&' : '?';
                    link.setAttribute('href', href + sep + 'embedded=1');
                }
            });

            // Automatically preserve embedded=1 in forms
            document.querySelectorAll('form[action*="/chatroom"], form[action*="/marketplace"], form[action*="/jobs"]').forEach(function(form) {
                if (!form.querySelector('input[name="embedded"]')) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'embedded';
                    input.value = '1';
                    form.appendChild(input);
                }
            });
        }
    </script>
    @auth
    <script>
        // If an authenticated user directly opens or reloads chatroom/marketplace/jobs outside the dashboard,
        // seamlessly frame it inside the user's dashboard view
        if (window.self === window.top && window.location.search.indexOf('embedded=1') === -1) {
            window.location.replace('/home?view=' + encodeURIComponent(window.location.pathname + window.location.search));
        }
    </script>
    @endauth
    @stack('scripts')
</body>
</html>
