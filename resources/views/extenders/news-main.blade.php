<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="@yield('meta_description', 'Legals Forum Newsroom — Ghana and International Legal, Judicial, and Commercial News')"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title') @yield('title') — {{ setting('site.title', 'Legals Forum') }} Newsroom @else Legal News & Insights — {{ setting('site.title', 'Legals Forum') }} @endif</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,600;0,6..72,700;1,6..72,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.7);
            --card-bg-hover: rgba(25, 35, 55, 0.85);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.16);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --rose: #f43f5e;
            --rose-light: #fb7185;
            --rose-glow: rgba(244, 63, 94, 0.25);
            --gold: #f59e0b;
            --emerald: #10b981;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-editorial: 'Newsreader', Georgia, serif;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        /* Top Notification / Ticker Strip */
        .top-ticker-strip {
            background: linear-gradient(90deg, #090e1a 0%, #111827 50%, #090e1a 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 7px 24px;
            font-size: 12.5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: relative;
            z-index: 101;
        }

        .ticker-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            overflow: hidden;
            flex: 1;
            min-width: 0;
        }

        .ticker-top-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .ticker-search-wrap {
            display: none;
            position: relative;
            flex: 1;
            min-width: 0;
            margin: 0 8px;
        }

        .ticker-search-input {
            width: 100%;
            height: 28px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 0 10px 0 28px;
            font-size: 11.5px;
            color: #fff;
            outline: none;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .ticker-search-input:focus {
            background: rgba(255, 255, 255, 0.09);
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .ticker-search-icon {
            position: absolute;
            left: 9px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 10.5px;
            pointer-events: none;
        }

        .ticker-badge {
            background: rgba(244, 63, 94, 0.15);
            color: var(--rose-light);
            border: 1px solid rgba(244, 63, 94, 0.35);
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 3px 9px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
            user-select: none;
        }

        .ticker-badge .pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--rose-light);
            animation: tickerPulse 1.8s infinite;
        }

        @keyframes tickerPulse {
            0% { opacity: 0.4; transform: scale(0.9); }
            50% { opacity: 1; transform: scale(1.3); }
            100% { opacity: 0.4; transform: scale(0.9); }
        }

        /* Dynamic Rotating Headline Container */
        .ticker-rotator-wrapper {
            position: relative;
            flex: 1;
            height: 24px;
            overflow: hidden;
            min-width: 0;
        }

        .ticker-rotator-item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            opacity: 0;
            transform: translateY(100%);
            transition: opacity 0.45s ease, transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
            pointer-events: none;
            white-space: nowrap;
            overflow: hidden;
        }

        .ticker-rotator-item.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .ticker-rotator-item.exit-up {
            opacity: 0;
            transform: translateY(-100%);
            pointer-events: none;
        }

        .ticker-rotator-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            font-size: 12.5px;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 100%;
            transition: color 0.2s ease;
        }

        .ticker-rotator-link:hover {
            color: #fff;
        }

        .ticker-rotator-link:hover .ticker-headline-text {
            color: #60a5fa;
            text-decoration: underline;
        }

        .ticker-cat-tag {
            background: rgba(255, 255, 255, 0.06);
            color: var(--accent-light);
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        .ticker-headline-text {
            color: #f1f5f9;
            font-weight: 600;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-variant: small-caps;
            letter-spacing: 0.35px;
            font-size: 13.5px;
        }

        .ticker-time-text {
            color: var(--text-muted);
            font-size: 11.5px;
            flex-shrink: 0;
            opacity: 0.75;
        }

        .ticker-rotator-nav {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
            margin-left: 6px;
        }

        .ticker-nav-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-muted);
            width: 20px;
            height: 20px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .ticker-nav-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .ticker-right-tools {
            display: flex;
            align-items: center;
            gap: 18px;
            color: var(--text-muted);
            font-size: 12px;
            flex-shrink: 0;
        }

        /* Two-Tier Premium Newsroom Header */
        .news-header-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 100;
            background: rgba(6, 10, 19, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }

        /* Top Brand Tier */
        .news-brand-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 12px 24px;
        }

        .news-brand-inner {
            max-width: 1320px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .brand-logo:hover {
            transform: scale(1.02);
        }

        .brand-icon {
            color: var(--accent-light);
            font-size: 22px;
        }

        .brand-text {
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -0.3px;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #93c5fd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .newsroom-tag {
            background: rgba(244, 63, 94, 0.12);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.25);
            font-size: 10.5px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 6px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        /* Bottom Category Navigation Bar */
        .news-subnav-row {
            padding: 8px 24px;
            background: rgba(12, 18, 32, 0.6);
        }

        .news-subnav-inner {
            max-width: 1320px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .news-categories-track {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 2px 0;
            flex: 1;
            min-width: 0;
        }

        .news-categories-track::-webkit-scrollbar {
            display: none;
        }

        .cat-nav-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid transparent;
            white-space: nowrap !important;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .cat-nav-pill:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .cat-nav-pill.active {
            color: #fff;
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.4);
            box-shadow: 0 0 16px rgba(244, 63, 94, 0.2);
        }

        .cat-count-badge {
            font-size: 11px;
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-muted);
            padding: 1px 7px;
            border-radius: 12px;
            font-weight: 700;
        }

        .cat-nav-pill.active .cat-count-badge {
            background: rgba(244, 63, 94, 0.3);
            color: #fecdd3;
        }

        .subnav-status-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .subnav-status-indicator .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 8px #10b981;
        }

        /* Search & Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .search-box-wrap {
            position: relative;
            width: 240px;
        }

        .search-box-input {
            width: 100%;
            height: 38px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0 12px 0 34px;
            font-size: 12.5px;
            color: #fff;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .search-box-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .search-box-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 12px;
            pointer-events: none;
        }

        .btn-platform {
            height: 38px;
            padding: 0 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            background: rgba(59, 130, 246, 0.12);
            color: var(--accent-light);
            border: 1px solid rgba(59, 130, 246, 0.25);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .btn-platform:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-1px);
        }

        .mobile-menu-btn {
            display: none;
            background: transparent;
            border: 1px solid var(--border-color);
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Mobile Nav Drawer */
        .mobile-nav-drawer {
            display: none;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 24px;
        }

        .mobile-nav-drawer.open {
            display: block;
        }

        .mobile-nav-drawer ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-nav-drawer a {
            display: block;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .mobile-nav-drawer a.active {
            background: rgba(244, 63, 94, 0.15);
            color: #fff;
        }

        /* Main Container */
        .news-main-body {
            flex: 1;
            max-width: 1320px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 24px 60px;
        }

        /* Footer */
        .news-footer {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            padding: 56px 24px 28px;
            margin-top: auto;
        }

        .footer-inner {
            max-width: 1320px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.2fr;
            gap: 40px;
            margin-bottom: 48px;
        }

        .footer-col h5 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #fff;
            margin-bottom: 18px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-col a {
            font-size: 13.5px;
            color: var(--text-secondary);
        }

        .footer-col a:hover {
            color: var(--accent-light);
            padding-left: 4px;
        }

        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: var(--text-muted);
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 1024px) {
            .news-nav { display: none; }
            .mobile-menu-btn { display: inline-flex; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
            .search-box-wrap { width: 170px; }
        }

        @media (max-width: 768px) {
            .top-ticker-strip {
                padding: 10px 14px 8px !important;
                display: block !important;
                width: 100% !important;
            }
            .ticker-inner {
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                justify-content: flex-start !important;
                width: 100% !important;
                gap: 8px !important;
                overflow: visible !important;
            }
            .ticker-top-row {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                gap: 8px !important;
                flex: none !important;
            }
            .ticker-badge {
                margin: 0 !important;
                flex-shrink: 0 !important;
            }
            .ticker-search-wrap {
                display: flex !important;
                flex: 1 !important;
                min-width: 0 !important;
                margin: 0 !important;
            }
            .ticker-top-row .mobile-menu-btn {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 4px 10px !important;
                height: 28px !important;
                font-size: 13px !important;
                border-radius: 6px !important;
                background: rgba(255, 255, 255, 0.06) !important;
                border: 1px solid var(--border-color) !important;
                color: #fff !important;
                cursor: pointer !important;
            }
            .ticker-rotator-wrapper {
                display: block !important;
                position: relative !important;
                flex: none !important;
                width: 100% !important;
                height: 26px !important;
                min-height: 26px !important;
                overflow: hidden !important;
            }
            .ticker-rotator-item {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .ticker-rotator-link {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 8px !important;
                width: 100% !important;
                max-width: 100% !important;
                text-align: center !important;
            }
            .ticker-cat-tag {
                display: inline-block !important;
                flex-shrink: 0 !important;
            }
            .ticker-headline-text {
                display: inline-block !important;
                text-align: center !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                white-space: nowrap !important;
            }
            .ticker-right-tools { display: none !important; }
            .ticker-time-text { display: none !important; }
            .ticker-rotator-nav { display: none !important; }
            .footer-grid { grid-template-columns: 1fr; }
            .search-box-wrap { display: none !important; }
            .btn-platform { display: none !important; }
            .header-actions { display: none !important; }
            .news-brand-row { 
                padding: 8px 14px !important; 
                width: 100% !important;
            }
            .news-brand-inner {
                gap: 0 !important;
                width: 100% !important;
                justify-content: flex-start !important;
            }
            .news-categories-track {
                width: 100% !important;
                flex: 1 1 100% !important;
                padding: 2px 0 !important;
            }
            .news-main-body { padding: 20px 14px 40px; }
        }
    </style>

    @yield('assets')
</head>
<body>

    <!-- Two-Tier Newsroom Header with Top Rotating Ticker -->
    <header class="news-header-wrapper">
        <!-- Top Breaking Ticker Strip (Static Badge + Animated Rotating Titles) -->
        @if(isset($breakingNews) && count($breakingNews) > 0)
        <div class="top-ticker-strip" id="topTickerStrip">
            <div class="ticker-inner">
                <div class="ticker-top-row">
                    <!-- Static BREAKING Badge -->
                    <span class="ticker-badge"><span class="pulse-dot"></span> Breaking</span>

                    <!-- Search Article Field in between Breaking and Hamburger -->
                    <form action="{{ url()->current() }}" method="GET" class="ticker-search-wrap">
                        <i class="fa-solid fa-magnifying-glass ticker-search-icon"></i>
                        <input type="text" name="search" class="ticker-search-input" placeholder="Search news articles..." value="{{ request('search') }}">
                    </form>

                    <!-- Mobile Hamburger Menu Button (on the same line as Breaking) -->
                    <button type="button" class="mobile-menu-btn" onclick="toggleMobileNewsNav()" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>

                <!-- Animated Rotating Headlines -->
                <div class="ticker-rotator-wrapper" id="tickerRotatorWrapper">
                    @foreach($breakingNews as $index => $item)
                    @php
                        $cleanItemCat = str_replace('-', ' ', $item->news_category);
                    @endphp
                    <div class="ticker-rotator-item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                        <a href="/News/{{ $item->news_category }}/{{ $item->title }}/{{ $item->id }}" class="ticker-rotator-link" title="{{ $item->title }}">
                            <span class="ticker-cat-tag">{{ $cleanItemCat }}</span>
                            <strong class="ticker-headline-text">{{ ucwords(strtolower($item->title)) }}</strong>
                            <span class="ticker-time-text">— {{ $item->created_at ? $item->created_at->diffForHumans() : 'Recent' }}</span>
                        </a>
                    </div>
                    @endforeach
                </div>

                @if(count($breakingNews) > 1)
                <div class="ticker-rotator-nav">
                    <button type="button" class="ticker-nav-btn" onclick="prevTickerStory()" title="Previous story" aria-label="Previous story">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="ticker-nav-btn" onclick="nextTickerStory()" title="Next story" aria-label="Next story">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
                @endif
            </div>

            <div class="ticker-right-tools">
                <span><i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> {{ date('l, M j, Y') }}</span>
                <span><i class="fa-solid fa-scale-balanced" style="margin-right: 4px; color: #3b82f6;"></i> Legal Intelligence</span>
            </div>
        </div>
        @endif
        <!-- Main Header: Category Navigation Tabs & Search/Platform -->
        <div class="news-brand-row">
            <div class="news-brand-inner">
                @if(isset($newsCategories))
                <div class="news-categories-track" id="newsCategoriesTrack">
                    @foreach($newsCategories as $cat)
                    @php
                        $cleanCatName = str_replace('-', ' ', $cat->name);
                        $isActiveCat = (isset($newscategory) && (
                            (is_array($newscategory) && (($newscategory['id'] ?? null) == $cat->id || strtolower(str_replace('-', ' ', $newscategory['name'] ?? '')) == strtolower($cleanCatName))) ||
                            (is_object($newscategory) && (($newscategory->id ?? null) == $cat->id || strtolower(str_replace('-', ' ', $newscategory->name ?? '')) == strtolower($cleanCatName)))
                        )) || (request()->segment(2) && (strtolower(str_replace('-', ' ', request()->segment(2))) == strtolower($cleanCatName) || request()->segment(3) == $cat->id));
                    @endphp
                    <a href="/News/{{ $cat->name }}/{{ $cat->id }}" class="cat-nav-pill {{ $isActiveCat ? 'active' : '' }}">
                        @if(str_contains(strtolower($cat->name), 'ghana'))
                            <i class="fa-solid fa-flag" style="font-size: 11px; opacity: 0.85;"></i>
                        @elseif(str_contains(strtolower($cat->name), 'africa'))
                            <i class="fa-solid fa-earth-africa" style="font-size: 11px; opacity: 0.85;"></i>
                        @elseif(str_contains(strtolower($cat->name), 'europe'))
                            <i class="fa-solid fa-earth-europe" style="font-size: 11px; opacity: 0.85;"></i>
                        @elseif(str_contains(strtolower($cat->name), 'america'))
                            <i class="fa-solid fa-earth-americas" style="font-size: 11px; opacity: 0.85;"></i>
                        @elseif(str_contains(strtolower($cat->name), 'asia'))
                            <i class="fa-solid fa-earth-asia" style="font-size: 11px; opacity: 0.85;"></i>
                        @else
                            <i class="fa-regular fa-newspaper" style="font-size: 11px; opacity: 0.85;"></i>
                        @endif
                        <span>{{ $cleanCatName }}</span>
                        @if(isset($cat->articles_count) && $cat->articles_count > 0)
                        <span class="cat-count-badge">{{ $cat->articles_count }}</span>
                        @endif
                    </a>
                    @endforeach
                </div>
                <script>
                    (function() {
                        function scrollToActiveCategory() {
                            var track = document.getElementById('newsCategoriesTrack');
                            if (!track) return;
                            var activePill = track.querySelector('.cat-nav-pill.active');
                            if (activePill) {
                                var targetScroll = activePill.offsetLeft - (track.clientWidth / 2) + (activePill.offsetWidth / 2);
                                track.scrollLeft = Math.max(0, targetScroll);
                            }
                        }
                        scrollToActiveCategory();
                        window.addEventListener('DOMContentLoaded', scrollToActiveCategory);
                        window.addEventListener('load', scrollToActiveCategory);
                        window.addEventListener('resize', scrollToActiveCategory);
                    })();
                </script>
                @endif

                <div class="header-actions">
                    <form action="{{ url()->current() }}" method="GET" class="search-box-wrap">
                        <i class="fa-solid fa-magnifying-glass search-box-icon"></i>
                        <input type="text" name="search" class="search-box-input" placeholder="Search news articles..." value="{{ request('search') }}">
                    </form>

                    <a href="/" class="btn-platform" title="Return to Platform Overview">
                        <i class="fa-solid fa-house"></i>
                        <span>Platform</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        @if(isset($newsCategories))
        <div class="mobile-nav-drawer" id="mobileNewsDrawer">
            <ul>
                <li>
                    <a href="/"><i class="fa-solid fa-house" style="margin-right: 6px; color: #60a5fa;"></i> Platform Home</a>
                </li>
                @foreach($newsCategories as $cat)
                @php
                    $cleanDrawerCatName = str_replace('-', ' ', $cat->name);
                    $isActiveDrawerCat = (isset($newscategory) && (
                        (is_array($newscategory) && (($newscategory['id'] ?? null) == $cat->id || strtolower(str_replace('-', ' ', $newscategory['name'] ?? '')) == strtolower($cleanDrawerCatName))) ||
                        (is_object($newscategory) && (($newscategory->id ?? null) == $cat->id || strtolower(str_replace('-', ' ', $newscategory->name ?? '')) == strtolower($cleanDrawerCatName)))
                    )) || (request()->segment(2) && (strtolower(str_replace('-', ' ', request()->segment(2))) == strtolower($cleanDrawerCatName) || request()->segment(3) == $cat->id));
                @endphp
                <li>
                    <a href="/News/{{ $cat->name }}/{{ $cat->id }}" class="{{ $isActiveDrawerCat ? 'active' : '' }}">
                        {{ $cleanDrawerCatName }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </header>

    <!-- Spacer to offset fixed header -->
    <div id="headerSpacer"></div>
    <script>
        (function() {
            var header = document.querySelector('.news-header-wrapper');
            var spacer = document.getElementById('headerSpacer');
            function setSpacerHeight() {
                if (header && spacer) {
                    spacer.style.height = header.offsetHeight + 'px';
                }
            }
            setSpacerHeight();
            window.addEventListener('resize', setSpacerHeight);
            window.addEventListener('load', setSpacerHeight);
        })();
    </script>

    <!-- Main Content Container -->
    <main class="news-main-body">
        @yield('content')
    </main>

    <!-- Newsroom Footer -->
    <footer class="news-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-col">
                    <a href="/" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; margin-bottom: 14px;">
                        <i class="fa fa-balance-scale" style="color: #3b82f6; font-size: 20px;"></i>
                        <span style="font-size: 19px; font-weight: 800; background: linear-gradient(to right, #60a5fa, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Legals Forum Newsroom</span>
                    </a>
                    <p style="color: var(--text-secondary); font-size: 13.5px; line-height: 1.7; max-width: 320px;">
                        Authoritative legal journalism, judicial reports, statutory analysis, and regulatory updates across Ghana, Africa, and global jurisdictions.
                    </p>
                </div>
                <div class="footer-col">
                    <h5>Categories</h5>
                    <ul>
                        @if(isset($newsCategories))
                            @foreach($newsCategories as $cat)
                            <li><a href="/News/{{ $cat->name }}/{{ $cat->id }}">{{ str_replace('-', ' ', $cat->name) }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/News/Ghana-News/1">Ghana News</a></li>
                            <li><a href="/News/Africa-News/2">Africa News</a></li>
                        @endif
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Legal Resources</h5>
                    <ul>
                        <li><a href="/constitution/Republic/Ghana/1">1992 Constitution</a></li>
                        <li><a href="/existing-laws">Existing Laws</a></li>
                        <li><a href="/new-laws">New Laws</a></li>
                        <li><a href="/judgement/Ghana">Supreme Court Case Law</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Account & Access</h5>
                    <ul>
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        <li><a href="/subscription">Subscription Plans</a></li>
                        <li><a href="{{ route('admin.login') }}" style="color: #60a5fa !important;">Admin Login</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ setting('site.title', 'Legals Forum') }}. All rights reserved.</p>
                <div style="display: flex; gap: 18px;">
                    <a href="/"><i class="fa-solid fa-house"></i> Home</a>
                    <a href="/judgement/Ghana"><i class="fa-solid fa-gavel"></i> Cases</a>
                    <a href="mailto:info@legalsforum.com"><i class="fa-solid fa-envelope"></i> Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleMobileNewsNav() {
            var d = document.getElementById('mobileNewsDrawer');
            if (d) {
                d.classList.toggle('open');
            }
        }

        // Automated Breaking News Headline Rotator (Static Badge + Animated Titles)
        (function() {
            var items = document.querySelectorAll('.ticker-rotator-item');
            if (!items || items.length <= 1) return;

            var currentIndex = 0;
            var rotateInterval = null;
            var isPaused = false;
            var duration = 4500; // 4.5 seconds per title

            function showItem(nextIndex, direction) {
                var current = items[currentIndex];
                var next = items[nextIndex];
                if (!current || !next) return;

                // Reset existing classes / styles
                items.forEach(function(item, i) {
                    if (i !== currentIndex && i !== nextIndex) {
                        item.classList.remove('active', 'exit-up');
                        item.style.transform = '';
                    }
                });

                // Exit current item
                current.classList.remove('active');
                if (direction === 'next') {
                    current.classList.add('exit-up');
                } else {
                    current.style.transform = 'translateY(100%)';
                }

                setTimeout(function() {
                    current.classList.remove('exit-up');
                    current.style.transform = '';
                }, 500);

                // Prepare and enter next item
                if (direction === 'prev') {
                    next.style.transform = 'translateY(-100%)';
                } else {
                    next.style.transform = 'translateY(100%)';
                }

                // Force reflow
                next.offsetHeight;

                next.classList.add('active');
                next.style.transform = 'translateY(0)';

                currentIndex = nextIndex;
            }

            window.nextTickerStory = function() {
                var next = (currentIndex + 1) % items.length;
                showItem(next, 'next');
            };

            window.prevTickerStory = function() {
                var prev = (currentIndex - 1 + items.length) % items.length;
                showItem(prev, 'prev');
            };

            function startRotator() {
                if (rotateInterval) clearInterval(rotateInterval);
                rotateInterval = setInterval(function() {
                    if (!isPaused) {
                        window.nextTickerStory();
                    }
                }, duration);
            }

            startRotator();

            // Pause on hover or touch so user can comfortably read and click headline
            var tickerStrip = document.getElementById('topTickerStrip');
            if (tickerStrip) {
                tickerStrip.addEventListener('mouseenter', function() {
                    isPaused = true;
                });
                tickerStrip.addEventListener('mouseleave', function() {
                    isPaused = false;
                });
                tickerStrip.addEventListener('touchstart', function() {
                    isPaused = true;
                }, { passive: true });
            }
        })();
    </script>

    @yield('scripts')

    <!-- Tawk.to Script -->
    <script type="text/javascript">
       var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
       (function(){
       var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
       s1.async=true;
       s1.src='https://embed.tawk.to/6a7df4c6bc79881d4b22fbbc/1jvu08a2a';
       s1.charset='UTF-8';
       s1.setAttribute('crossorigin','*');
       s0.parentNode.insertBefore(s1,s0);
       })();
    </script>
</body>
</html>
