<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Search results for {{ $query }} — Legals Forum Legal Research Platform">
    <title>Search Results — Legals Forum</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174662621-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-174662621-1');
    </script>

    <style>
        /* ============================================
           CSS VARIABLES & RESET
           ============================================ */
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.45);
            --card-bg-solid: #0f172a;
            --card-bg-hover: rgba(25, 35, 55, 0.65);
            --border-color: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.2);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-glow: rgba(245, 158, 11, 0.15);
            --emerald: #10b981;
            --emerald-glow: rgba(16, 185, 129, 0.15);
            --violet: #8b5cf6;
            --violet-glow: rgba(139, 92, 246, 0.15);
            --cyan: #06b6d4;
            --cyan-glow: rgba(6, 182, 212, 0.15);
            --rose: #f43f5e;
            --rose-glow: rgba(244, 63, 94, 0.15);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --header-height: 72px;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }

        /* Highlight keywords in yellow/gold capsule */
        mark.search-highlight {
            background: rgba(245, 158, 11, 0.18);
            color: #f59e0b;
            padding: 2px 5px;
            border-radius: 4px;
            font-weight: 600;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        /* Highlight keywords in act titles in green capsule */
        mark.title-highlight {
            background: rgba(16, 185, 129, 0.18);
            color: #10b981;
            padding: 2px 5px;
            border-radius: 4px;
            font-weight: 600;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        /* ============================================
           CUSTOM SCROLLBAR
           ============================================ */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.35); }

        /* ============================================
           AMBIENT BACKGROUND
           ============================================ */
        .ambient-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(140px);
            z-index: 0;
            pointer-events: none;
        }
        .ambient-blob-1 {
            top: -15%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: rgba(59, 130, 246, 0.06);
        }
        .ambient-blob-2 {
            bottom: -20%;
            right: -10%;
            width: 45vw;
            height: 45vw;
            background: rgba(139, 92, 246, 0.04);
        }

        /* ============================================
           STICKY HEADER
           ============================================ */
        .search-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: var(--header-height);
            background: rgba(6, 10, 19, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-inner {
            width: 100%;
            max-width: 1400px;
            padding: 0 28px;
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            transition: var(--transition);
        }
        .brand-link:hover { opacity: 0.85; }

        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: #fff;
            box-shadow: 0 4px 15px var(--accent-glow);
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .header-search-form {
            flex: 1;
            max-width: 600px;
        }

        .search-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input-wrap .search-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 14px;
            pointer-events: none;
        }

        .search-input-wrap input {
            width: 100%;
            padding: 10px 18px 10px 42px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: var(--font);
            font-size: 14px;
            outline: none;
            transition: var(--transition);
        }

        .search-input-wrap input::placeholder { color: var(--text-muted); }

        .search-input-wrap input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background: rgba(255, 255, 255, 0.08);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .user-greeting {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .btn-header-login {
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            transition: var(--transition);
            white-space: nowrap;
        }
        .btn-header-login:hover {
            border-color: var(--accent);
            color: var(--accent-light);
        }

        .btn-header-signup {
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--accent-gradient);
            border-radius: 10px;
            transition: var(--transition);
            white-space: nowrap;
            box-shadow: 0 4px 12px var(--accent-glow);
        }
        .btn-header-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--accent-glow);
        }

        /* ============================================
           SEARCH SUMMARY STRIP
           ============================================ */
        .search-summary {
            margin-top: var(--header-height);
            padding: 32px 28px 28px;
            background: linear-gradient(180deg, rgba(59, 130, 246, 0.06) 0%, transparent 100%);
            border-bottom: 1px solid var(--border-color);
            position: relative;
            z-index: 1;
        }

        .summary-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .summary-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            box-shadow: 0 8px 25px var(--accent-glow);
            flex-shrink: 0;
        }

        .summary-text h1 {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .summary-text p {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .result-count {
            color: var(--accent-light);
            font-weight: 700;
        }

        .search-query {
            color: var(--gold);
            font-weight: 600;
        }

        /* ============================================
           MAIN LAYOUT (Grid)
           ============================================ */
        .search-main {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 36px;
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 28px 80px;
            position: relative;
            z-index: 1;
            min-height: 60vh;
        }

        /* ============================================
           FILTER SIDEBAR
           ============================================ */
        .filter-sidebar {
            position: sticky;
            top: calc(var(--header-height) + 24px);
            align-self: start;
            max-height: calc(100vh - var(--header-height) - 48px);
            overflow-y: auto;
            padding-right: 6px;
        }

        /* Custom Scrollbar for independent sidebar scroll */
        .filter-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .filter-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .filter-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .filter-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .filter-panel {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 24px;
        }

        .filter-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .filter-title i {
            color: var(--accent);
            font-size: 14px;
        }

        .filter-subtitle {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-summary {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .filter-summary .hl-red { color: var(--rose); font-weight: 700; }
        .filter-summary .hl-query { color: var(--gold); font-weight: 600; }

        .filter-divider {
            height: 1px;
            background: var(--border-color);
            margin-bottom: 16px;
            margin-top: 4px;
        }

        .filter-option {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
            margin-bottom: 4px;
            user-select: none;
        }

        .filter-option:hover {
            background: rgba(59, 130, 246, 0.05);
            border-color: rgba(59, 130, 246, 0.1);
        }

        .filter-option.active {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.25);
        }

        .filter-option.disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        .filter-radio-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid var(--text-muted);
            margin-right: 12px;
            flex-shrink: 0;
            transition: var(--transition);
            position: relative;
        }

        .filter-option.active .filter-radio-dot {
            border-color: var(--accent);
        }

        .filter-option.active .filter-radio-dot::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
        }

        .filter-label {
            flex: 1;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            transition: var(--transition);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .filter-option.active .filter-label {
            color: var(--text-primary);
            font-weight: 600;
        }

        .filter-count {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            transition: var(--transition);
        }

        .filter-option.active .filter-count {
            background: var(--accent-glow);
            color: var(--accent-light);
        }

        /* ============================================
           RESULTS CONTAINER
           ============================================ */
        .results-container {
            min-width: 0;
        }

        /* ============================================
           RESULT CARDS
           ============================================ */
        .result-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px 28px;
            margin-bottom: 16px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            animation: fadeSlideUp 0.35s ease both;
        }

        .result-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.03) 0%, transparent 60%);
            opacity: 0;
            transition: var(--transition);
            pointer-events: none;
        }

        .result-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        }

        .result-card:hover::before { opacity: 1; }

        .result-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        /* Category Badges */
        .result-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-acts {
            background: rgba(59, 130, 246, 0.12);
            color: var(--accent-light);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        .badge-cases {
            background: rgba(139, 92, 246, 0.12);
            color: var(--violet);
            border: 1px solid rgba(139, 92, 246, 0.2);
        }
        .badge-constitution {
            background: rgba(16, 185, 129, 0.12);
            color: var(--emerald);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .badge-pre4th {
            background: rgba(6, 182, 212, 0.12);
            color: var(--cyan);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }
        .badge-countries {
            background: rgba(244, 63, 94, 0.12);
            color: var(--rose);
            border: 1px solid rgba(244, 63, 94, 0.2);
        }

        .result-year-badge {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.05);
            padding: 3px 8px;
            border-radius: 6px;
        }

        .result-act-title {
            font-size: 16px;
            font-weight: 750;
            color: #fff;
            line-height: 1.4;
            margin-bottom: 6px;
        }

        .result-section-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 14px;
            line-height: 1.4;
        }

        .result-section-title a {
            color: var(--accent-light);
            transition: var(--transition);
        }
        .result-section-title a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        .result-content {
            font-size: 14px;
            line-height: 1.75;
            color: var(--text-secondary);
        }

        /* ============================================
           SKELETON LOADERS
           ============================================ */
        .skeleton-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px 28px;
            margin-bottom: 16px;
        }
        .skeleton-line {
            height: 12px;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 12px;
            border-radius: 4px;
            animation: pulse 1.5s infinite ease-in-out;
        }
        .skeleton-title { height: 18px; width: 45%; }
        .skeleton-subtitle { height: 14px; width: 25%; margin-bottom: 22px; }
        .skeleton-text { height: 12px; }
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 0.25; }
            100% { opacity: 0.6; }
        }

        /* ============================================
           NO RESULTS STATE
           ============================================ */
        .no-results {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 60px 40px;
            text-align: center;
            animation: fadeSlideUp 0.35s ease both;
        }

        .no-results-icon {
            font-size: 48px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .no-results h3 {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .no-results p {
            font-size: 14px;
            color: var(--text-secondary);
            max-width: 440px;
            margin: 0 auto 24px;
            line-height: 1.5;
        }

        /* Suggested Queries Welcome State */
        .suggested-queries {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            align-items: center;
            margin-top: 24px;
        }

        .suggest-label {
            font-size: 13px;
            color: var(--text-muted);
            margin-right: 4px;
        }

        .suggest-pill {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 13px;
            padding: 6px 14px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.25s ease;
            font-weight: 500;
        }

        .suggest-pill:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--border-hover);
            color: #fff;
            transform: translateY(-1px);
        }

        /* ============================================
           PAGINATION
           ============================================ */
        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 40px;
            animation: fadeIn 0.5s ease both;
        }

        .page-btn {
            min-width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            user-select: none;
            padding: 0 10px;
        }

        .page-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--border-hover);
            color: #fff;
        }

        .page-btn.active {
            background: var(--accent-gradient);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .page-btn.disabled {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ============================================
           BACK TO TOP BUTTON
           ============================================ */
        .back-to-top-btn {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--accent-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 8px 25px var(--accent-glow);
            transition: var(--transition);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
        }

        .back-to-top-btn.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px var(--accent-glow);
        }

        /* ============================================
           ANIMATIONS
           ============================================ */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .search-main {
                grid-template-columns: 1fr;
                gap: 28px;
                padding: 20px 16px 80px;
            }

            .filter-sidebar {
                position: relative;
                top: 0;
                max-height: none;
                overflow-y: visible;
                padding-right: 0;
            }

            .filter-panel {
                border-radius: 14px;
            }

            .search-summary { padding: 24px 16px 20px; }

            .summary-icon {
                width: 44px;
                height: 44px;
                font-size: 17px;
                border-radius: 12px;
            }

            .summary-text h1 { font-size: 18px; }
        }

        @media (max-width: 640px) {
            .header-inner { padding: 0 16px; gap: 12px; }
            .brand-name { display: none; }
            .btn-header-login { display: none; }
            .search-main { gap: 20px; }
            .result-card { padding: 18px 20px; border-radius: 14px; }
        }
    </style>
</head>
<body>

    <!-- Ambient Background Blobs -->
    <div class="ambient-blob ambient-blob-1"></div>
    <div class="ambient-blob ambient-blob-2"></div>

    <!-- ============================================
         STICKY HEADER
         ============================================ -->
    <header class="search-header" id="searchHeader">
        <div class="header-inner">
            <a href="/" class="brand-link">
                <div class="brand-icon">
                    <i class="fa fa-balance-scale"></i>
                </div>
                <span class="brand-name">Legals Forum</span>
            </a>

            <div class="header-search-form">
                <div class="search-input-wrap">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="main-search-input" value="{{ $query }}" placeholder="Search any law or case in Ghana...">
                </div>
            </div>

            <div class="header-actions">
                @guest
                    <a href="{{ route('login') }}" class="btn-header-login">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-header-signup">Sign Up Free</a>
                    @endif
                @else
                    <span class="user-greeting">Hi, {{ Auth::user()->name }}</span>
                    <a href="#" class="btn-header-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>
        </div>
    </header>

    <!-- ============================================
         SEARCH SUMMARY STRIP
         ============================================ -->
    <section class="search-summary">
        <div class="summary-inner">
            <div class="summary-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="summary-text">
                <h1>Search Results</h1>
                <p id="search-stats-container">
                    @if(!empty($query))
                        <span class="result-count">{{ number_format($all_total_count) }}</span> results found for
                        &ldquo;<span class="search-query">{{ $query }}</span>&rdquo;
                    @else
                        Enter a keyword above to start searching.
                    @endif
                </p>
            </div>
        </div>
    </section>

    <!-- ============================================
         MAIN CONTENT (Sidebar + Results)
         ============================================ -->
    <main class="search-main">

        <!-- FILTER SIDEBAR -->
        <aside class="filter-sidebar">
            <div class="filter-panel">
                <h3 class="filter-title">
                    <i class="fa-solid fa-filter"></i> Categories
                </h3>
                <div class="filter-divider"></div>

                <div class="filter-options-grid" id="category-facet-container">
                    <!-- All -->
                    <div class="filter-option active" data-category="All" id="filter-all">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">All Results</span>
                        <span class="filter-count" id="count-all">{{ $all_total_count }}</span>
                    </div>

                    <!-- Constitution (Ghana) -->
                    <div class="filter-option {{ $total_constitution_articles_count == 0 ? 'disabled' : '' }}" data-category="Constitution_Ghana" id="filter-consti-ghana">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">Constitution (Ghana)</span>
                        <span class="filter-count" id="count-consti-ghana">{{ $total_constitution_articles_count }}</span>
                    </div>

                    <!-- 4th Republic Laws -->
                    <div class="filter-option {{ $posts_total_count == 0 ? 'disabled' : '' }}" data-category="4th_Republic" id="filter-4th-rep">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">4th Republic Laws</span>
                        <span class="filter-count" id="count-4th-rep">{{ $posts_total_count }}</span>
                    </div>

                    <!-- Case Laws -->
                    <div class="filter-option {{ $cases_total_count == 0 ? 'disabled' : '' }}" data-category="Case_Laws" id="filter-cases">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">Case Laws</span>
                        <span class="filter-count" id="count-cases">{{ $cases_total_count }}</span>
                    </div>

                    <!-- Pre 4th Republic Laws -->
                    <div class="filter-option {{ $pre_total_count == 0 ? 'disabled' : '' }}" data-category="Pre_4th_Republic" id="filter-pre4th">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">Pre 4th Republic Laws</span>
                        <span class="filter-count" id="count-pre4th">{{ $pre_total_count }}</span>
                    </div>

                    <!-- Constitution (Others) -->
                    <div class="filter-option {{ $total_constitution_countries == 0 ? 'disabled' : '' }}" data-category="Constitution_Others" id="filter-consti-others">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">Other Constitutions</span>
                        <span class="filter-count" id="count-consti-others">{{ $total_constitution_countries }}</span>
                    </div>
                </div>

                <!-- Dynamic Subcategories Panel -->
                <div id="subcategory-panel" style="display: none; margin-top: 24px;">
                    <h3 class="filter-title">
                        <i class="fa-solid fa-folder-tree"></i> Document Types
                    </h3>
                    <div class="filter-divider"></div>
                    <div class="filter-options-grid" id="subcategory-facet-container"></div>
                </div>

                <!-- Dynamic Year Panel -->
                <div id="year-panel" style="display: none; margin-top: 24px;">
                    <h3 class="filter-title">
                        <i class="fa-solid fa-calendar-days"></i> Filter by Year
                    </h3>
                    <div class="filter-divider"></div>
                    <div class="filter-options-grid" id="year-facet-container" style="max-height: 220px; overflow-y: auto; padding-right: 4px;"></div>
                </div>

            </div>
        </aside>

        <!-- RESULTS AREA -->
        <section class="results-container">
            <div id="search-results-feed">
                <!-- Result cards rendered here -->
            </div>
            
            <div id="search-pagination" class="pagination-container">
                <!-- Pagination buttons rendered here -->
            </div>
        </section>

    </main>

    <!-- ============================================
         BACK TO TOP BUTTON
         ============================================ -->
    <a id="back-to-top" href="#" class="back-to-top-btn" title="Back to top">
        <i class="fa-solid fa-arrow-up"></i>
    </a>

    <!-- ============================================
         SCRIPTS
         ============================================ -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            // Back to top
            $(window).scroll(function(){
                if ($(this).scrollTop() > 300) {
                    $('#back-to-top').addClass('visible');
                } else {
                    $('#back-to-top').removeClass('visible');
                }
            });

            $('#back-to-top').click(function(e){
                e.preventDefault();
                $('body,html').animate({ scrollTop: 0 }, 400);
            });
            
            // Prevent copy-paste on search results
            $('body').bind('cut copy paste', function (e) {
                e.preventDefault();
            });
        });
    </script>

    <!-- SPA SEARCH ENGINE LOGIC -->
    <script>
        // Search State
        const state = {
            query: "{{ $query }}",
            category: "All",
            subcategory: "All",
            year: "All",
            page: 1,
            per_page: 15
        };

        // DOM elements
        const elements = {
            searchInput: document.getElementById('main-search-input'),
            resultsFeed: document.getElementById('search-results-feed'),
            pagination: document.getElementById('search-pagination'),
            statsContainer: document.getElementById('search-stats-container'),
            categoryContainer: document.getElementById('category-facet-container'),
            subcategoryPanel: document.getElementById('subcategory-panel'),
            subcategoryContainer: document.getElementById('subcategory-facet-container'),
            yearPanel: document.getElementById('year-panel'),
            yearContainer: document.getElementById('year-facet-container')
        };

        // Trigger search programmatically (e.g. from suggestion pills)
        window.triggerSearch = function(term) {
            elements.searchInput.value = term;
            state.query = term;
            state.page = 1;
            state.subcategory = 'All';
            state.year = 'All';
            performSearch();
        };

        // Render Skeletons during loads
        function renderSkeletons() {
            elements.resultsFeed.innerHTML = Array(3).fill(0).map(() => `
                <div class="skeleton-card">
                    <div class="skeleton-line skeleton-title"></div>
                    <div class="skeleton-line skeleton-subtitle"></div>
                    <div class="skeleton-line skeleton-text" style="width: 95%;"></div>
                    <div class="skeleton-line skeleton-text" style="width: 85%;"></div>
                    <div class="skeleton-line skeleton-text" style="width: 60%;"></div>
                </div>
            `).join('');
            elements.pagination.innerHTML = '';
        }

        // Mapping badge properties based on category
        function getBadgeClass(cat) {
            switch(cat) {
                case '4th_republic': return 'acts';
                case 'case_laws': return 'cases';
                case 'constitution_ghana': return 'constitution';
                case 'pre_4th_republic': return 'pre4th';
                case 'constitution_others': return 'countries';
                default: return 'acts';
            }
        }

        function getBadgeIcon(cat) {
            switch(cat) {
                case '4th_republic': return 'fa-solid fa-gavel';
                case 'case_laws': return 'fa fa-balance-scale';
                case 'constitution_ghana': return 'fa-solid fa-book-open';
                case 'pre_4th_republic': return 'fa-solid fa-landmark';
                case 'constitution_others': return 'fa-solid fa-globe';
                default: return 'fa-solid fa-file-contract';
            }
        }

        // Helper to highlight title matches in green
        function highlightTitle(text, query) {
            if (!query || !text) return text;
            const cleanWord = query.trim();
            if (!cleanWord) return text;
            
            const escapedWord = cleanWord.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            const regexPattern = escapedWord.replace(/(\\-| )/g, '[ \\-]');
            const regex = new RegExp(`(${regexPattern})`, 'gi');
            
            return text.replace(regex, '<mark class="title-highlight">$1</mark>');
        }

        // Render individual result card
        function renderCard(item) {
            const highlightParam = state.query ? `?search_text=${encodeURIComponent(state.query)}` : '';
            const finalLink = item.link + highlightParam;
            
            // Highlight search word in act title & subtitle in green
            const highlightedParentTitle = highlightTitle(item.parent_title, state.query);
            const highlightedSubtitle = highlightTitle(item.subtitle, state.query);
            
            return `
                <div class="result-card">
                    <div class="result-card-header">
                        <span class="result-type-badge badge-${getBadgeClass(item.category)}">
                            <i class="${getBadgeIcon(item.category)}"></i> ${item.type}
                        </span>
                        ${item.year ? `<span class="result-year-badge">${item.year}</span>` : ''}
                    </div>
                    <div class="result-act-title">${highlightedParentTitle}</div>
                    <div class="result-section-title">
                        <a href="${finalLink}" target="_blank">${highlightedSubtitle}</a>
                    </div>
                    <div class="result-content">
                        ${item.snippet}
                    </div>
                </div>
            `;
        }

        // Render dynamic pagination controls
        function renderPagination(page, totalPages) {
            if (totalPages <= 1) {
                elements.pagination.innerHTML = '';
                return;
            }

            let html = `
                <button class="page-btn ${page === 1 ? 'disabled' : ''}" data-page="${page - 1}">
                    <i class="fa-solid fa-chevron-left"></i> Prev
                </button>
            `;

            const rangeLimit = 2; // Show active page plus rangeLimit pages on each side
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= page - rangeLimit && i <= page + rangeLimit)) {
                    html += `
                        <button class="page-btn ${page === i ? 'active' : ''}" data-page="${i}">
                            ${i}
                        </button>
                    `;
                } else if (i === page - rangeLimit - 1 || i === page + rangeLimit + 1) {
                    html += `<span style="color: var(--text-muted); padding: 0 4px;">...</span>`;
                }
            }

            html += `
                <button class="page-btn ${page === totalPages ? 'disabled' : ''}" data-page="${page + 1}">
                    Next <i class="fa-solid fa-chevron-right"></i>
                </button>
            `;

            elements.pagination.innerHTML = html;
        }

        let activeAbortController = null;

        // Perform AJAX search and update UI
        async function performSearch() {
            // Abort any active in-flight fetch request
            if (activeAbortController) {
                activeAbortController.abort();
                activeAbortController = null;
            }

            if (!state.query) {
                // 1. Reset results feed to clean Suggestion/Welcome landing card
                elements.resultsFeed.innerHTML = `
                    <div class="no-results search-welcome">
                        <div class="no-results-icon" style="color: var(--accent);"><i class="fa fa-balance-scale"></i></div>
                        <h3>Discover Laws & Cases in Ghana</h3>
                        <p>Search through the Constitution, Acts of Parliament, Case Judgments, and Regulations. Enter a keyword above to start your research.</p>
                        
                        <div class="suggested-queries">
                            <span class="suggest-label"><i class="fa-solid fa-lightbulb" style="color: var(--gold); margin-right: 4px;"></i> Try searching:</span>
                            <button class="suggest-pill" onclick="triggerSearch('constitution')">Constitution</button>
                            <button class="suggest-pill" onclick="triggerSearch('money laundering')">Money Laundering</button>
                            <button class="suggest-pill" onclick="triggerSearch('criminal')">Criminal</button>
                            <button class="suggest-pill" onclick="triggerSearch('tax')">Taxation</button>
                        </div>
                    </div>
                `;
                
                // 2. Reset other display components
                elements.statsContainer.innerHTML = 'Enter a keyword above to start searching.';
                elements.pagination.innerHTML = '';
                elements.subcategoryPanel.style.display = 'none';
                elements.yearPanel.style.display = 'none';
                
                // 3. Reset URL in the address bar to base search URL without query parameters
                const baseUrl = `${window.location.origin}/main_home_search`;
                history.pushState(null, '', baseUrl);
                
                // 4. Reset sidebar category counts to 0 and re-enable all categories
                const zeroCounts = {
                    All: 0,
                    Constitution_Ghana: 0,
                    Constitution_Others: 0,
                    Pre_4th_Republic: 0,
                    '4th_Republic': 0,
                    Case_Laws: 0
                };
                updateCategoryCounts(zeroCounts);
                
                return;
            }

            renderSkeletons();

            // Build url search params
            const params = new URLSearchParams({
                search_text: state.query,
                category: state.category,
                subcategory: state.subcategory,
                year: state.year,
                page: state.page,
                per_page: state.per_page
            });

            const url = `${window.location.origin}/main_home_search?${params.toString()}`;

            // Sync query parameters into browser url bar without reloading
            history.pushState(null, '', url);

            // Capture state parameters to prevent out-of-order responses (race conditions)
            const currentQuery = state.query;
            const currentCategory = state.category;
            const currentSubcategory = state.subcategory;
            const currentYear = state.year;
            const currentPage = state.page;

            try {
                // Initialize AbortController for the fetch request
                activeAbortController = new AbortController();
                const signal = activeAbortController.signal;

                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    signal: signal
                });
                
                if (!response.ok) throw new Error('Search failed');
                const data = await response.json();

                // Clear active controller reference
                activeAbortController = null;

                // If state changed while request was in flight, discard this response
                if (state.query !== currentQuery ||
                    state.category !== currentCategory ||
                    state.subcategory !== currentSubcategory ||
                    state.year !== currentYear ||
                    state.page !== currentPage) {
                    return;
                }

                // 1. Update stats
                elements.statsContainer.innerHTML = `
                    <span class="result-count">${data.total.toLocaleString()}</span> results found for 
                    &ldquo;<span class="search-query">${escapeHtml(data.query)}</span>&rdquo; 
                    <span style="color: var(--text-muted); font-size: 12px; margin-left: 6px;">(took ${data.time_ms}ms)</span>
                `;

                // 2. Render cards
                if (data.results.length === 0) {
                    elements.resultsFeed.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon"><i class="fa-solid fa-circle-question"></i></div>
                            <h3>No Results Found</h3>
                            <p>We couldn't find matches for "${escapeHtml(data.query)}" with the current filters. Try refining your spelling or clearing filters.</p>
                        </div>
                    `;
                } else {
                    elements.resultsFeed.innerHTML = data.results.map(renderCard).join('');
                }

                // 3. Render pagination
                renderPagination(data.page, data.total_pages);

                // 4. Update sidebar category counts
                updateCategoryCounts(data.facets.categories);

                // 5. Render subcategories if selected category is not 'All'
                renderSubcategories(data.facets.subcategories);

                // 6. Render year facets
                renderYears(data.facets.years);

            } catch (error) {
                if (error.name === 'AbortError') {
                    // Ignore aborted request errors
                    return;
                }
                console.error(error);
                elements.resultsFeed.innerHTML = `
                    <div class="no-results">
                        <div class="no-results-icon" style="color: var(--rose);"><i class="fa-solid fa-circle-exclamation"></i></div>
                        <h3>Search Error</h3>
                        <p>There was a problem querying the database. Please try again.</p>
                    </div>
                `;
            }
        }

        // Helper to escape HTML tags safely in strings
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Update counts on main category options in sidebar
        function updateCategoryCounts(categories) {
            document.getElementById('count-all').innerText = (categories.All || 0).toLocaleString();
            document.getElementById('count-consti-ghana').innerText = (categories.Constitution_Ghana || 0).toLocaleString();
            document.getElementById('count-4th-rep').innerText = (categories['4th_Republic'] || 0).toLocaleString();
            document.getElementById('count-cases').innerText = (categories.Case_Laws || 0).toLocaleString();
            document.getElementById('count-pre4th').innerText = (categories.Pre_4th_Republic || 0).toLocaleString();
            document.getElementById('count-consti-others').innerText = (categories.Constitution_Others || 0).toLocaleString();

            // Disable filters with 0 counts
            elements.categoryContainer.querySelectorAll('.filter-option').forEach(option => {
                const cat = option.dataset.category;
                const count = categories[cat] || 0;
                
                if (cat !== 'All' && count === 0) {
                    option.classList.add('disabled');
                    if (state.category === cat) {
                        // Switch active back to All if currently disabled
                        setActiveCategory('All');
                    }
                } else {
                    option.classList.remove('disabled');
                }
            });
        }

        // Helper to set active category class
        function setActiveCategory(cat) {
            state.category = cat;
            elements.categoryContainer.querySelectorAll('.filter-option').forEach(opt => {
                if (opt.dataset.category === cat) {
                    opt.classList.add('active');
                } else {
                    opt.classList.remove('active');
                }
            });
        }

        // Render subcategory list dynamically
        function renderSubcategories(subcategories) {
            if (state.category === 'All' || Object.keys(subcategories).length === 0) {
                elements.subcategoryPanel.style.display = 'none';
                return;
            }

            elements.subcategoryPanel.style.display = 'block';

            let html = `
                <div class="filter-option filter-option-sub ${state.subcategory === 'All' ? 'active' : ''}" data-value="All">
                    <span class="filter-radio-dot"></span>
                    <span class="filter-label">All Types</span>
                </div>
            `;

            for (const [sub, count] of Object.entries(subcategories)) {
                if (count > 0) {
                    html += `
                        <div class="filter-option filter-option-sub ${state.subcategory === sub ? 'active' : ''}" data-value="${sub}">
                            <span class="filter-radio-dot"></span>
                            <span class="filter-label" title="${sub}">${sub}</span>
                            <span class="filter-count">${count.toLocaleString()}</span>
                        </div>
                    `;
                }
            }

            elements.subcategoryContainer.innerHTML = html;
        }

        // Render year list dynamically
        function renderYears(years) {
            if (!years || Object.keys(years).length === 0) {
                elements.yearPanel.style.display = 'none';
                return;
            }

            elements.yearPanel.style.display = 'block';

            let html = `
                <div class="filter-option filter-option-year ${state.year === 'All' ? 'active' : ''}" data-value="All">
                    <span class="filter-radio-dot"></span>
                    <span class="filter-label">All Years</span>
                </div>
            `;

            for (const [year, count] of Object.entries(years)) {
                html += `
                    <div class="filter-option filter-option-year ${state.year === year ? 'active' : ''}" data-value="${year}">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">${year}</span>
                        <span class="filter-count">${count.toLocaleString()}</span>
                    </div>
                `;
            }

            elements.yearContainer.innerHTML = html;
        }

        // --- EVENT LISTENERS ---

        // As-you-type search input debounced (with min query length guard)
        let debounceTimer;
        elements.searchInput.addEventListener('input', (e) => {
            clearTimeout(debounceTimer);
            const val = e.target.value.trim();
            
            // If cleared, reset search immediately
            if (val === '') {
                state.query = '';
                state.page = 1;
                state.subcategory = 'All';
                state.year = 'All';
                performSearch();
                return;
            }
            
            // Only auto-search if query is at least 3 characters
            if (val.length >= 3) {
                debounceTimer = setTimeout(() => {
                    state.query = val;
                    state.page = 1; // reset page
                    state.subcategory = 'All'; // reset sub filters
                    state.year = 'All';
                    performSearch();
                }, 450);
            }
        });

        // Immediate search on Enter keypress
        elements.searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                clearTimeout(debounceTimer);
                const val = e.target.value.trim();
                state.query = val;
                state.page = 1;
                state.subcategory = 'All';
                state.year = 'All';
                performSearch();
            }
        });

        // Clicking category filters in sidebar
        elements.categoryContainer.addEventListener('click', (e) => {
            const option = e.target.closest('.filter-option');
            if (option && !option.classList.contains('disabled')) {
                setActiveCategory(option.dataset.category);
                state.subcategory = 'All';
                state.year = 'All';
                state.page = 1;
                performSearch();
            }
        });

        // Clicking subcategory filters (delegated)
        elements.subcategoryContainer.addEventListener('click', (e) => {
            const option = e.target.closest('.filter-option-sub');
            if (option) {
                state.subcategory = option.dataset.value;
                state.page = 1;
                performSearch();
            }
        });

        // Clicking year filters (delegated)
        elements.yearContainer.addEventListener('click', (e) => {
            const option = e.target.closest('.filter-option-year');
            if (option) {
                state.year = option.dataset.value;
                state.page = 1;
                performSearch();
            }
        });

        // Pagination buttons (delegated)
        elements.pagination.addEventListener('click', (e) => {
            const btn = e.target.closest('.page-btn');
            if (btn && !btn.classList.contains('disabled') && !btn.classList.contains('active')) {
                state.page = parseInt(btn.dataset.page, 10);
                performSearch();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Initialize state on page load from URL parameters if present
        function initFromUrl() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('search_text')) state.query = params.get('search_text').trim();
            if (params.has('category')) {
                state.category = params.get('category');
                setActiveCategory(state.category);
            }
            if (params.has('subcategory')) state.subcategory = params.get('subcategory');
            if (params.has('year')) state.year = params.get('year');
            if (params.has('page')) state.page = parseInt(params.get('page'), 10) || 1;

            elements.searchInput.value = state.query;
            performSearch();
        }

        // Load initially
        window.addEventListener('popstate', initFromUrl);
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFromUrl);
        } else {
            initFromUrl();
        }
    </script>

</body>
</html>