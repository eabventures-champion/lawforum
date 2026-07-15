<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $menu->title }} on Legals Forum.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $menu->title }} — Legals Forum</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.65);
            --border-color: rgba(255, 255, 255, 0.06);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --font: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font);
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            padding-top: 90px;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Fixed Navigation */
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
            max-width: 1400px;
            height: 100%;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-menu-links-premium {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none !important;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Dropdown menus */
        .nav-link-dropdown {
            position: relative;
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            text-decoration: none !important;
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
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none !important;
            transition: color 0.2s;
        }

        .btn-login:hover {
            color: var(--text-primary);
        }

        .btn-signup {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff !important;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none !important;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        /* User Profile Dropdown */
        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            padding: 6px 14px;
            border-radius: 20px;
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .nav-user-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .nav-user-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Page Main Layout */
        .main-container {
            max-width: 900px;
            width: 100%;
            margin: 40px auto;
            padding: 0 24px;
            flex-grow: 1;
        }

        .content-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .page-title {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 24px;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-body-content {
            font-size: 16px;
            line-height: 1.8;
            color: #cbd5e1;
        }

        .page-body-content p {
            margin-bottom: 20px;
        }

        .page-body-content h1, 
        .page-body-content h2, 
        .page-body-content h3 {
            color: #fff;
            margin-top: 32px;
            margin-bottom: 16px;
            font-weight: 700;
        }

        .page-body-content a {
            color: var(--accent-light);
            text-decoration: underline;
        }

        .page-body-content a:hover {
            color: #93c5fd;
        }

        /* Footer styling */
        footer {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding: 30px 24px;
            text-align: center;
            background: rgba(6, 10, 19, 0.5);
        }

        footer p {
            color: var(--text-secondary);
            font-size: 14px;
            margin: 0;
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
                @foreach($headerMenus as $menuItem)
                    @if($menuItem->is_dropdown)
                        <div class="nav-link-dropdown">
                            <button class="nav-link-btn">{{ $menuItem->title }} <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></button>
                            <div class="nav-dropdown-menu">
                                @foreach($menuItem->children as $child)
                                    <a href="{{ $child->custom_content ? route('dynamic.page', $child->slug) : $child->url }}">{{ $child->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menuItem->custom_content ? route('dynamic.page', $menuItem->slug) : $menuItem->url }}" class="nav-link-btn">{{ $menuItem->title }}</a>
                    @endif
                @endforeach
            </div>

            <div class="nav-auth">
                @guest
                    <a href="{{ route('login') }}" class="btn-login">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-signup">Sign Up Free</a>
                    @endif
                @else
                    <div class="nav-user-dropdown">
                        <button class="nav-user-btn">
                            <i class="fa-solid fa-user-circle"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>
                        </button>
                        <div class="nav-dropdown-menu dropdown-menu-right" style="right: 0; left: auto;">
                            <a href="{{ route('home') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
                            <a href="/subscription"><i class="fa-solid fa-credit-card"></i> Subscriptions</a>
                            <div class="nav-dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form-dynamic" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form-dynamic').submit();" style="color: #ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- ====== MAIN CONTENT ====== -->
    <main class="main-container">
        <div class="content-card">
            <h1 class="page-title">{{ $menu->title }}</h1>
            <div class="page-body-content">
                {!! $menu->custom_content !!}
            </div>
        </div>
    </main>

    <!-- ====== FOOTER ====== -->
    <footer>
        <p>&copy; 2026 Legals Forum. All rights reserved.</p>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
