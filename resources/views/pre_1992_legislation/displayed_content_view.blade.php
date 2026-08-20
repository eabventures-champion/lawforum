<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $searchText = $searchText ?? request()->get('search_text', '');
        $actTitle = $allPre1992Article['pre_1992_act'] ?? 'Legal Document';
        $sectionTitle = $allPre1992Article['section'] ?? '';
        $actYear = '';
        if (preg_match('/\b(1[89]\d{2}|20[0-2]\d)\b/', $actTitle, $yearMatch)) {
            $actYear = $yearMatch[1];
        }
    @endphp

    <title>{{ $sectionTitle ? $sectionTitle . ' — ' : '' }}{{ $actTitle }} — Legals Forum</title>
    <meta name="description" content="{{ $sectionTitle }} — {{ $actTitle }} — Ghana Legal Research Platform">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css">

    <style>
        /* ============================================
           VARIABLE DEFINITIONS
           ============================================ */
        .premium-article-container, .premium-modal, body.standalone-view {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.55);
            --card-bg-hover: rgba(25, 35, 55, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.15);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-glow: rgba(245, 158, 11, 0.15);
            --emerald: #10b981;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font-ui: 'Outfit', 'Inter', -apple-system, sans-serif;
            --font-legal: 'Lora', 'Georgia', serif;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.standalone-view {
            font-family: var(--font-ui) !important;
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* ============================================
           NAVIGATION BAR (standalone only)
           ============================================ */
        .content-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(6, 10, 19, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 0 24px;
        }

        .content-nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            gap: 16px;
        }

        .content-nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none !important;
            flex-shrink: 0;
        }

        .content-nav-logo img {
            width: 32px;
            height: 32px;
        }

        .content-nav-logo-text {
            font-size: 18px;
            font-weight: 800;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: 'Inter', sans-serif;
        }

        .content-nav-search {
            flex: 1;
            max-width: 420px;
            position: relative;
        }

        .content-nav-search-input {
            width: 100%;
            padding: 9px 16px 9px 38px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            font-size: 14px;
            font-family: var(--font-ui);
            outline: none;
            transition: var(--transition);
        }

        .content-nav-search-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .content-nav-search-input::placeholder {
            color: var(--text-muted);
        }

        .content-nav-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
            pointer-events: none;
        }

        .content-nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .content-nav-btn {
            font-size: 13px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none !important;
            transition: var(--transition);
            font-family: var(--font-ui);
        }

        .content-nav-btn-outline {
            color: var(--text-secondary);
            background: transparent;
            border: 1px solid var(--border-hover);
        }

        .content-nav-btn-outline:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .content-nav-btn-primary {
            color: #fff;
            background: var(--accent-gradient);
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .content-nav-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--accent-glow);
        }

        /* ============================================
           BREADCRUMB & HEADER
           ============================================ */
        .content-header-wrap {
            max-width: 900px;
            margin: 0 auto;
            padding: 28px 20px 0;
        }

        .content-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .content-breadcrumb a {
            color: var(--accent-light);
            text-decoration: none !important;
            font-weight: 500;
            transition: var(--transition);
        }

        .content-breadcrumb a:hover {
            color: #93c5fd;
            text-decoration: underline !important;
        }

        .content-breadcrumb .breadcrumb-sep {
            color: var(--text-muted);
            font-size: 11px;
        }

        .content-breadcrumb .breadcrumb-current {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .content-meta-header {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px 32px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }

        .content-meta-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-gradient);
        }

        .content-meta-badges {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .content-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .content-badge-category {
            background: rgba(245, 158, 11, 0.12);
            color: var(--gold);
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .content-badge-year {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-light);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .content-act-title {
            font-family: var(--font-ui);
            font-size: 22px;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.3;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .content-section-title {
            font-family: var(--font-ui);
            font-size: 15px;
            font-weight: 600;
            color: var(--accent-light);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .content-section-title i {
            color: var(--gold);
            font-size: 14px;
        }

        /* ============================================
           ACTION TOOLBAR
           ============================================ */
        .content-actions-bar {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            margin-top: 20px !important;
            padding-top: 18px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            flex-wrap: wrap !important;
        }

        .content-actions-bar .content-action-btn,
        .content-actions-bar button.btn-bookmark-toggle,
        .content-actions-bar button.content-action-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            width: auto !important;
            min-width: 90px !important;
            max-width: unset !important;
            height: 38px !important;
            padding: 0 16px !important;
            border-radius: 10px !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #cbd5e1 !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-family: var(--font-ui) !important;
            text-decoration: none !important;
            white-space: nowrap !important;
            margin: 0 !important;
            transform: none !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
        }

        .content-actions-bar .content-action-btn:hover,
        .content-actions-bar button.btn-bookmark-toggle:hover,
        .content-actions-bar button.content-action-btn:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }

        .content-actions-bar .content-action-btn.is-bookmarked,
        .content-actions-bar button.btn-bookmark-toggle.is-bookmarked {
            background: rgba(245, 158, 11, 0.15) !important;
            border-color: rgba(245, 158, 11, 0.45) !important;
            color: #f59e0b !important;
        }

        .content-actions-bar .content-action-btn.is-bookmarked:hover,
        .content-actions-bar button.btn-bookmark-toggle.is-bookmarked:hover {
            background: rgba(245, 158, 11, 0.22) !important;
        }

        .content-actions-bar .content-action-btn i {
            font-size: 13px !important;
            color: inherit !important;
        }

        /* ============================================
           BACK TO SEARCH BUTTON
           ============================================ */
        .content-back-search {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: var(--accent-light);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            transition: var(--transition);
            margin-bottom: 20px;
            cursor: pointer;
        }

        .content-back-search:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
            transform: translateX(-3px);
        }

        /* ============================================
           ARTICLE CONTAINER
           ============================================ */
        .premium-article-container {
            font-family: var(--font-ui) !important;
            color: var(--text-primary) !important;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px 80px;
            animation: fadeIn 0.4s ease both;
        }

        #display_content .premium-article-container .nav-links,
        #display_plain_content .premium-article-container .nav-links,
        #display_expanded_view .premium-article-container .nav-links {
            display: flex !important;
            justify-content: flex-start !important;
            padding: 10px 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 24px;
        }

        .premium-article-container .nav-links span {
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: var(--accent-light);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(8px);
        }

        .premium-article-container .nav-links span i.fa-balance-scale {
            color: var(--gold);
        }

        /* Article Card */
        .article-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 36px 40px;
            margin: 0;
            position: relative;
        }

        .article-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20px;
            bottom: 20px;
            width: 3px;
            background: var(--accent-gradient);
            border-radius: 4px;
        }

        /* Legal Content Typography */
        .content {
            font-family: var(--font-legal) !important;
            font-size: 17px;
            line-height: 1.85;
            color: var(--text-primary);
            letter-spacing: -0.01em;
            word-spacing: 0.02em;
        }

        .content p {
            margin-bottom: 1.5em;
            color: #e2e8f0;
        }

        .content h1, .content h2, .content h3, .content h4 {
            font-family: var(--font-ui) !important;
            font-weight: 700;
            color: #fff;
            margin-top: 1.8em;
            margin-bottom: 0.8em;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .content h2 { font-size: 22px; color: var(--accent-light); }
        .content h3 { font-size: 18px; color: #cbd5e1; }
        .content h4 { font-size: 16px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; }

        /* ============================================
           ANIMATIONS
           ============================================ */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 768px) {
            html, body {
                overflow-x: hidden !important;
                width: 100% !important;
                max-width: 100vw !important;
            }
            .content-nav { padding: 0 12px !important; }
            .content-nav-search { display: none !important; }
            .content-nav-inner { height: 52px !important; gap: 8px !important; }
            .content-nav-logo { gap: 6px !important; }
            .content-nav-logo-text { font-size: 15px !important; }
            .content-nav-logo img { width: 26px !important; height: 26px !important; }
            .content-nav-actions { gap: 6px !important; }
            .content-nav-btn { padding: 6px 10px !important; font-size: 11.5px !important; }
            
            .content-header-wrap { padding: 16px 12px 0 !important; width: 100% !important; box-sizing: border-box !important; }
            .content-back-search { font-size: 12px !important; padding: 6px 12px !important; margin-bottom: 14px !important; }
            .content-breadcrumb { font-size: 12px !important; word-break: break-word !important; margin-bottom: 16px !important; }
            .content-meta-header { padding: 16px 14px !important; border-radius: 12px !important; width: 100% !important; box-sizing: border-box !important; margin-bottom: 20px !important; }
            .content-meta-badges { margin-bottom: 12px !important; gap: 6px !important; }
            .content-badge { font-size: 10px !important; padding: 3px 8px !important; }
            .content-act-title { font-size: 16px !important; word-break: break-word !important; margin-bottom: 8px !important; line-height: 1.35 !important; }
            .content-section-title { font-size: 13.5px !important; word-break: break-word !important; }
            
            .content-actions-bar {
                flex-wrap: wrap !important;
                gap: 8px !important;
                margin-top: 14px !important;
                padding-top: 14px !important;
                justify-content: flex-start !important;
            }
            .content-actions-bar .content-action-btn,
            .content-actions-bar button.btn-bookmark-toggle,
            .content-actions-bar button.content-action-btn {
                min-width: 70px !important;
                height: 34px !important;
                padding: 0 10px !important;
                font-size: 11.5px !important;
                gap: 6px !important;
            }

            .premium-article-container { padding: 0 12px 40px !important; width: 100% !important; box-sizing: border-box !important; }
            .article-card { padding: 18px 14px !important; border-radius: 12px !important; width: 100% !important; box-sizing: border-box !important; word-break: break-word !important; }
            .content { font-size: 14.5px !important; word-break: break-word !important; line-height: 1.75 !important; }
        }

        @media (max-width: 480px) {
            .content-nav-actions { gap: 4px !important; }
            .content-nav-btn { padding: 5px 8px !important; font-size: 11px !important; }
            .content-breadcrumb { font-size: 11.5px !important; }
        }

        /* ============================================
           HIGHLIGHT KEYWORDS
           ============================================ */
        mark.search-highlight {
            background: rgba(245, 158, 11, 0.18);
            color: #f59e0b;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid rgba(245, 158, 11, 0.3);
            display: inline-block;
        }

        mark.search-highlight.active-highlight {
            background: rgba(245, 158, 11, 0.3);
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.25);
        }

        /* ============================================
           BACK TO TOP
           ============================================ */
        .back-to-top-btn {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 16px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            z-index: 50;
            backdrop-filter: blur(12px);
        }

        .back-to-top-btn.visible { display: flex; }
        .back-to-top-btn:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: var(--accent);
            color: var(--accent-light);
            transform: translateY(-2px);
        }
    </style>
    @include('partials._nav_subdropdown_styles')
</head>

<body class="standalone-view">
    <!-- ====== NAVIGATION BAR (standalone only) ====== -->
    <nav class="content-nav">
        <div class="content-nav-inner">
            <a href="/" class="content-nav-logo">
                <img src="{{ asset('logo/favicon/favicon-32x32.png') }}" alt="Legals Forum">
                <span class="content-nav-logo-text">Legals Forum</span>
            </a>

            <form action="{{ url('main_home_search') }}" method="GET" class="content-nav-search">
                <i class="fa-solid fa-magnifying-glass content-nav-search-icon"></i>
                <input type="text" name="search_text" class="content-nav-search-input" placeholder="Search laws, cases, documents..." value="{{ $searchText }}">
            </form>

            <div class="content-nav-actions">
                @guest
                    <a href="/" class="content-nav-btn content-nav-btn-outline">
                        <i class="fa-solid fa-house"></i> Home
                    </a>
                    @if(request()->cookie('guest_access'))
                        <span class="content-nav-btn content-nav-btn-outline" style="cursor: default;">
                            <i class="fa-solid fa-user-secret"></i> Guest
                        </span>
                    @else
                        <a href="/get-started" class="content-nav-btn content-nav-btn-primary">Sign Up</a>
                    @endif
                @else
                    <a href="/home" class="content-nav-btn content-nav-btn-outline">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                    <a href="/" class="content-nav-btn content-nav-btn-outline">
                        {{ auth()->user()->name }}
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- ====== BREADCRUMB & METADATA HEADER ====== -->
    <div class="content-header-wrap" style="animation: fadeInUp 0.5s ease both;">
        <!-- Back to search link -->
        @if(!empty($searchText))
            <a href="{{ url('main_home_search') }}?search_text={{ urlencode($searchText) }}"
               class="content-back-search"
               onclick="if (window.opener && !window.opener.closed) { try { window.opener.focus(); window.close(); return false; } catch(e){} }">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Search Results
            </a>
        @endif

        <!-- Breadcrumb -->
        <nav class="content-breadcrumb">
            <a href="/"><i class="fa-solid fa-house" style="font-size: 12px;"></i> Home</a>
            <span class="breadcrumb-sep"><i class="fa-solid fa-chevron-right"></i></span>
            @if(!empty($searchText))
                <a href="{{ url('main_home_search') }}?search_text={{ urlencode($searchText) }}">Search Results</a>
                <span class="breadcrumb-sep"><i class="fa-solid fa-chevron-right"></i></span>
            @endif
            <a href="javascript:void(0)">Existing Laws</a>
            <span class="breadcrumb-sep"><i class="fa-solid fa-chevron-right"></i></span>
            <span class="breadcrumb-current" title="{{ $actTitle }}">{{ Str::limit($actTitle, 60) }}</span>
        </nav>

        <!-- Metadata Card -->
        <div class="content-meta-header">
            <div class="content-meta-badges">
                <span class="content-badge content-badge-category">
                    <i class="fa-solid fa-landmark"></i> Existing Laws
                </span>
                @if($actYear)
                    <span class="content-badge content-badge-year">
                        <i class="fa-regular fa-calendar"></i> {{ $actYear }}
                    </span>
                @endif
            </div>

            <h1 class="content-act-title">{{ $actTitle }}</h1>

            @if($sectionTitle)
                <div class="content-section-title">
                    <i class="fa-solid fa-balance-scale"></i>
                    <span>{{ $sectionTitle }}</span>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="content-actions-bar">
                @php
                    $isBookmarked = false;
                    $preAct = \App\Pre1992LegislationAct::where('title', $allPre1992Article['pre_1992_act'])->first();
                    $preGroup = $preAct ? $preAct->pre_1992_group : ($allPre1992Article['act_group'] ?? 'Existing Laws');
                    $preActId = $preAct ? $preAct->id : ($allPre1992Article['act_id'] ?? 1);
                    $prePageUrl = "/existing-laws/" . rawurlencode($preGroup) . "/" . rawurlencode($allPre1992Article['pre_1992_act']) . "/" . $preActId . "#section-" . $allPre1992Article['id'];

                    if (auth()->check()) {
                        $isBookmarked = \App\UserBookmark::where('user_id', auth()->id())
                            ->where(function($q) use ($allPre1992Article, $preActId) {
                                $q->where('section_id', $allPre1992Article['id'])
                                  ->orWhere('user_section', auth()->id() . '_pre_1992_' . $preActId . '_' . $allPre1992Article['id'])
                                  ->orWhere('user_section', auth()->id() . '_pre_1992_' . $allPre1992Article['act_id'] . '_' . $allPre1992Article['id']);
                            })->exists();
                    }
                @endphp

                <button type="button"
                        class="content-action-btn btn-bookmark-toggle {{ $isBookmarked ? 'is-bookmarked' : '' }}"
                        data-act-title="{{ $allPre1992Article['pre_1992_act'] }}"
                        data-act-section="{{ $allPre1992Article['section'] }}"
                        data-section-id="{{ $allPre1992Article['id'] }}"
                        data-act-id="{{ $preActId }}"
                        data-act-group="{{ $preGroup }}"
                        data-doc-type="pre_1992"
                        data-page-url="{{ $prePageUrl }}"
                        title="{{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark this section' }}"
                        onclick="toggleBookmark(this)">
                    <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                </button>

                <button type="button" class="content-action-btn" onclick="window.print()">
                    <i class="fa-solid fa-print"></i> Print
                </button>

                <button type="button" class="content-action-btn" id="copyContentBtn" onclick="copyLegalContent()">
                    <i class="fa-regular fa-copy"></i> Copy
                </button>
            </div>
        </div>
    </div>

    <!-- ====== ARTICLE CONTENT ====== -->
    <div class="premium-article-container" data-sid="{{ $allPre1992Article['id'] }}" style="animation: fadeInUp 0.5s ease 0.1s both;">
        <div class="article-card">
            <div class="content">
                {!! $allPre1992Article['content'] !!}
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <button class="back-to-top-btn" id="backToTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    @include('partials._bookmark_script')

    <!-- Scripts dynamically loaded only when missing -->
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
        }
    </script>
    <script>
        if (typeof $.fn.modal === 'undefined') {
            document.write('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"><\/script>');
        }
    </script>

    <script>
        // Back to top button
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTopBtn');
            if (btn) {
                btn.classList.toggle('visible', window.scrollY > 300);
            }
        });

        // Copy content
        function copyLegalContent() {
            const contentEl = document.querySelector('.article-card .content');
            if (!contentEl) return;

            const text = contentEl.innerText || contentEl.textContent;
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById('copyContentBtn');
                if (btn) {
                    const original = btn.innerHTML;
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
                    btn.style.color = 'var(--emerald)';
                    btn.style.borderColor = 'rgba(16, 185, 129, 0.3)';
                    setTimeout(() => {
                        btn.innerHTML = original;
                        btn.style.color = '';
                        btn.style.borderColor = '';
                    }, 2000);
                }
            }).catch(() => {
                // Fallback for older browsers
                const range = document.createRange();
                range.selectNodeContents(contentEl);
                const sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
                document.execCommand('copy');
                sel.removeAllRanges();
            });
        }
    </script>

    <!-- Highlight keyword from search query parameter -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchText = urlParams.get('search_text');
            if (searchText) {
                highlightWord(searchText);
            }
        });

        function highlightWord(word) {
            if (!word) return;
            const contentContainer = document.querySelector('.content');
            if (!contentContainer) return;
            
            const cleanWord = word.trim();
            if (!cleanWord) return;
            
            const escapedWord = cleanWord.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            const regexPattern = escapedWord.replace(/(\\-| )/g, '[ \\-]');
            const regex = new RegExp(`(${regexPattern})`, 'gi');
            
            const walk = document.createTreeWalker(contentContainer, NodeFilter.SHOW_TEXT, null, false);
            let node;
            const textNodes = [];
            
            while (node = walk.nextNode()) {
                textNodes.push(node);
            }
            
            textNodes.forEach(textNode => {
                const parent = textNode.parentNode;
                if (parent) {
                    const tagName = parent.tagName.toUpperCase();
                    if (tagName !== 'SCRIPT' && 
                        tagName !== 'STYLE' && 
                        tagName !== 'NOSCRIPT' && 
                        tagName !== 'IFRAME' && 
                        tagName !== 'TEXTAREA' && 
                        tagName !== 'MARK' &&
                        !parent.classList.contains('search-highlight')) {
                        
                        const text = textNode.nodeValue;
                        const newHTML = text.replace(regex, '<mark class="search-highlight">$1</mark>');
                        
                        if (newHTML !== text) {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = newHTML;
                            
                            while (tempDiv.firstChild) {
                                parent.insertBefore(tempDiv.firstChild, textNode);
                            }
                            parent.removeChild(textNode);
                        }
                    }
                }
            });

            setTimeout(function() {
                const firstHighlight = contentContainer.querySelector('.search-highlight');
                if (firstHighlight) {
                    firstHighlight.classList.add('active-highlight');
                    firstHighlight.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });
                    const scrollContainer = document.querySelector('.main-wrapper-scrollable');
                    if (scrollContainer && scrollContainer.scrollHeight > scrollContainer.clientHeight) {
                        const containerRect = scrollContainer.getBoundingClientRect();
                        const activeRect = firstHighlight.getBoundingClientRect();
                        const targetTop = scrollContainer.scrollTop + (activeRect.top - containerRect.top) - (containerRect.height / 2);
                        scrollContainer.scrollTo({
                            top: Math.max(0, targetTop),
                            behavior: 'smooth'
                        });
                    }
                }
            }, 50);
        }
    </script>

@include('partials._premium_guest_gate')

<!--Start of Tawk.to Script-->
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
<!--End of Tawk.to Script-->
</body>
</html>
