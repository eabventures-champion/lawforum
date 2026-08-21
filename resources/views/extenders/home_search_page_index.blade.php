<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
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

        html {
            scroll-behavior: smooth;
            overflow-x: clip;
            width: 100%;
            max-width: 100%;
        }

        body {
            font-family: var(--font);
            background: var(--bg-primary);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            overflow-x: clip;
            width: 100%;
            max-width: 100%;
            position: relative;
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
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            height: var(--header-height);
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 0 0 auto;
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
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            white-space: nowrap;
        }

        .header-search-form {
            flex: 1 1 auto;
            max-width: 580px;
            margin: 0 auto;
            position: relative;
            min-width: 0;
        }

        .search-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
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
            height: 42px;
            padding: 10px 18px 10px 42px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: var(--font);
            font-size: 16px;
            outline: none;
            transition: var(--transition);
        }

        .search-input-wrap input::placeholder { color: var(--text-muted); }

        .search-input-wrap input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background: rgba(255, 255, 255, 0.08);
        }

        @keyframes searchShake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-8px); }
            40%, 80% { transform: translateX(8px); }
        }
        .search-input-wrap.error-shake {
            animation: searchShake 0.4s ease-in-out !important;
            border-color: #ef4444 !important;
            box-shadow: 0 0 16px rgba(239, 68, 68, 0.4) !important;
        }
        .search-empty-prompt-toast {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: rgba(239, 68, 68, 0.95);
            color: #ffffff;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.25s ease;
        }

        /* Search History Dropdown */
        .srp-search-history {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: #0b1324 !important;
            border: 1px solid rgba(59, 130, 246, 0.4);
            border-radius: 14px;
            padding: 8px;
            z-index: 10000;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.95), 0 0 0 1px rgba(255, 255, 255, 0.08);
            max-height: 360px;
            overflow-y: auto;
            animation: fadeIn 0.2s ease;
        }
        .srp-search-history.visible { display: block; }
        .srp-sh-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 10px 4px; font-size: 11px;
        }
        .srp-sh-header-title {
            font-weight: 700; color: var(--text-muted); text-transform: uppercase;
            letter-spacing: 0.7px; display: flex; align-items: center; gap: 5px;
        }
        .srp-sh-clear {
            font-size: 11px; font-weight: 600; color: var(--rose);
            background: none; border: none; cursor: pointer; padding: 3px 6px;
            border-radius: 4px; transition: var(--transition); font-family: var(--font);
        }
        .srp-sh-clear:hover { background: rgba(244, 63, 94, 0.12); }
        .srp-sh-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: 8px; cursor: pointer; transition: var(--transition);
        }
        .srp-sh-item:hover { background: rgba(255, 255, 255, 0.06); }
        .srp-sh-item-icon {
            width: 28px; height: 28px; border-radius: 6px;
            background: rgba(59, 130, 246, 0.08); display: flex;
            align-items: center; justify-content: center;
            color: var(--accent-light); font-size: 12px; flex-shrink: 0;
        }
        .srp-sh-item-text { flex: 1; min-width: 0; }
        .srp-sh-item-query {
            font-size: 13px; font-weight: 500; color: var(--text-primary);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .srp-sh-item-time { font-size: 10px; color: var(--text-muted); }
        .srp-sh-item-del {
            width: 24px; height: 24px; border-radius: 4px;
            background: none; border: none; color: var(--text-muted);
            font-size: 11px; cursor: pointer; display: flex;
            align-items: center; justify-content: center;
            opacity: 0; transition: var(--transition); flex-shrink: 0;
        }
        .srp-sh-item:hover .srp-sh-item-del { opacity: 1; }
        .srp-sh-item-del:hover { background: rgba(244, 63, 94, 0.12); color: var(--rose); }

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

        .btn-header-signup, .btn-guest-user {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #fff !important;
            background: var(--accent-gradient);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            transition: var(--transition);
            white-space: nowrap;
            cursor: pointer;
            text-decoration: none !important;
            box-shadow: 0 4px 14px var(--accent-glow);
            font-family: var(--font);
        }
        .btn-header-signup:hover, .btn-guest-user:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--accent-glow);
            color: #fff !important;
            border-color: rgba(255, 255, 255, 0.28);
        }
        .btn-guest-user i {
            font-size: 14px;
            color: #fff;
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

        .search-time {
            color: var(--text-muted);
            font-size: 12px;
            margin-left: 6px;
            display: inline-block;
            white-space: nowrap;
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

        .mobile-filter-header {
            display: none;
        }

        .filter-panel-collapsible {
            display: block;
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
            
            /* Prevent horizontal overflow */
            max-width: 100% !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }

        .result-card * {
            max-width: 100%;
            word-wrap: break-word !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
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
                display: block !important;
                padding: 20px 16px 80px;
            }

            .filter-sidebar {
                position: -webkit-sticky !important;
                position: sticky !important;
                top: var(--header-height) !important;
                align-self: start !important;
                max-height: calc(100vh - var(--header-height) - 10px) !important;
                overflow-y: visible !important;
                padding-right: 0 !important;
                margin-bottom: 14px !important;
                z-index: 500 !important;
            }

            .filter-panel {
                border-radius: 14px;
                padding: 14px 12px;
                background: rgba(12, 18, 32, 0.95) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border: 1px solid var(--border-color) !important;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.45) !important;
            }

            .mobile-filter-header {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                cursor: pointer;
                user-select: none;
                padding: 4px 6px;
            }

            .desktop-only-title,
            .desktop-only-divider {
                display: none !important;
            }

            .filter-panel-collapsible {
                transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, visibility 0.3s ease;
                max-height: 1200px;
                opacity: 1;
                visibility: visible;
                overflow: visible;
                margin-top: 12px;
            }

            .filter-panel-collapsible.collapsed {
                max-height: 0 !important;
                opacity: 0 !important;
                visibility: hidden !important;
                overflow: hidden !important;
                margin-top: 0 !important;
            }

            .filter-divider {
                display: none !important;
            }

            .filter-title {
                font-size: 13px !important;
                margin-bottom: 8px !important;
            }

            #subcategory-panel, #year-panel {
                margin-top: 12px !important;
            }

            /* Years Dropdown styling on mobile */
            #year-facet-container {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-radius: 12px !important;
                background: rgba(13, 17, 28, 0.7) !important;
                backdrop-filter: blur(10px) !important;
                -webkit-backdrop-filter: blur(10px) !important;
                padding: 4px !important;
                position: relative !important;
                transition: all 0.3s ease !important;
                max-height: none !important;
                overflow-y: visible !important;
            }

            /* Dropdown collapse state: hide inactive options */
            #year-facet-container:not(.expanded) .filter-option-year:not(.active) {
                display: none !important;
            }

            /* Style active option in collapsed state to act as a trigger */
            #year-facet-container:not(.expanded) .filter-option-year.active {
                width: 100% !important;
                background: transparent !important;
                border-color: transparent !important;
                display: flex !important;
                align-items: center !important;
                padding: 10px 14px !important;
            }

            /* Dropdown arrows */
            #year-facet-container:not(.expanded) .filter-option-year.active::after {
                content: "\f078" !important;
                font-family: "Font Awesome 6 Free" !important;
                font-weight: 900 !important;
                margin-left: auto !important;
                color: var(--text-secondary) !important;
                font-size: 13px !important;
            }

            #year-facet-container.expanded .filter-option-year.active::after {
                content: "\f077" !important;
                font-family: "Font Awesome 6 Free" !important;
                font-weight: 900 !important;
                margin-left: auto !important;
                color: var(--text-secondary) !important;
                font-size: 13px !important;
            }

            /* Expanded states */
            #year-facet-container.expanded {
                border-color: rgba(59, 130, 246, 0.3) !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
            }

            #year-facet-container.expanded .filter-option-year {
                display: flex !important;
                width: 100% !important;
                border-radius: 8px !important;
                border: 1px solid transparent !important;
                background: transparent !important;
                margin-bottom: 2px !important;
                padding: 10px 14px !important;
            }

            #year-facet-container.expanded .filter-option-year:hover {
                background: rgba(255, 255, 255, 0.05) !important;
            }

            #year-facet-container.expanded .filter-option-year.active {
                background: rgba(59, 130, 246, 0.1) !important;
                border-color: rgba(59, 130, 246, 0.2) !important;
            }

            #year-facet-container.expanded .filter-option-year.active .filter-label {
                color: var(--accent) !important;
                font-weight: 600 !important;
            }

            #year-facet-container.expanded .filter-option-year.active .filter-count {
                background: rgba(59, 130, 246, 0.15) !important;
                color: var(--accent) !important;
            }

            /* Subcategories Dropdown styling on mobile */
            #subcategory-facet-container {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-radius: 12px !important;
                background: rgba(13, 17, 28, 0.7) !important;
                backdrop-filter: blur(10px) !important;
                -webkit-backdrop-filter: blur(10px) !important;
                padding: 4px !important;
                position: relative !important;
                transition: all 0.3s ease !important;
            }

            /* Dropdown collapse state: hide inactive options */
            #subcategory-facet-container:not(.expanded) .filter-option-sub:not(.active) {
                display: none !important;
            }

            /* Style active option in collapsed state to act as a trigger */
            #subcategory-facet-container:not(.expanded) .filter-option-sub.active {
                width: 100% !important;
                background: transparent !important;
                border-color: transparent !important;
                display: flex !important;
                align-items: center !important;
                padding: 10px 14px !important;
            }

            /* Dropdown arrows */
            #subcategory-facet-container:not(.expanded) .filter-option-sub.active::after {
                content: "\f078" !important;
                font-family: "Font Awesome 6 Free" !important;
                font-weight: 900 !important;
                margin-left: auto !important;
                color: var(--text-secondary) !important;
                font-size: 13px !important;
            }

            #subcategory-facet-container.expanded .filter-option-sub.active::after {
                content: "\f077" !important;
                font-family: "Font Awesome 6 Free" !important;
                font-weight: 900 !important;
                margin-left: auto !important;
                color: var(--text-secondary) !important;
                font-size: 13px !important;
            }

            /* Expanded states */
            #subcategory-facet-container.expanded {
                border-color: rgba(59, 130, 246, 0.3) !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
            }

            #subcategory-facet-container.expanded .filter-option-sub {
                display: flex !important;
                width: 100% !important;
                border-radius: 8px !important;
                border: 1px solid transparent !important;
                background: transparent !important;
                margin-bottom: 2px !important;
                padding: 10px 14px !important;
            }

            #subcategory-facet-container.expanded .filter-option-sub:hover {
                background: rgba(255, 255, 255, 0.05) !important;
            }

            #subcategory-facet-container.expanded .filter-option-sub.active {
                background: rgba(59, 130, 246, 0.1) !important;
                border-color: rgba(59, 130, 246, 0.2) !important;
            }

            #subcategory-facet-container.expanded .filter-option-sub.active .filter-label {
                color: var(--accent) !important;
                font-weight: 600 !important;
            }

            #subcategory-facet-container.expanded .filter-option-sub.active .filter-count {
                background: rgba(59, 130, 246, 0.15) !important;
                color: var(--accent) !important;
            }

            /* Categories Dropdown styling on mobile */
            #category-facet-container {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-radius: 12px !important;
                background: rgba(13, 17, 28, 0.7) !important;
                backdrop-filter: blur(10px) !important;
                -webkit-backdrop-filter: blur(10px) !important;
                padding: 4px !important;
                position: relative !important;
                transition: all 0.3s ease !important;
            }

            /* Dropdown collapse state: hide inactive options */
            #category-facet-container:not(.expanded) .filter-option:not(.active) {
                display: none !important;
            }

            /* Style active option in collapsed state to act as a trigger */
            #category-facet-container:not(.expanded) .filter-option.active {
                width: 100% !important;
                background: transparent !important;
                border-color: transparent !important;
                display: flex !important;
                align-items: center !important;
                padding: 10px 14px !important;
            }

            /* Dropdown arrows */
            #category-facet-container:not(.expanded) .filter-option.active::after {
                content: "\f078" !important;
                font-family: "Font Awesome 6 Free" !important;
                font-weight: 900 !important;
                margin-left: auto !important;
                color: var(--text-secondary) !important;
                font-size: 13px !important;
            }

            #category-facet-container.expanded .filter-option.active::after {
                content: "\f077" !important;
                font-family: "Font Awesome 6 Free" !important;
                font-weight: 900 !important;
                margin-left: auto !important;
                color: var(--text-secondary) !important;
                font-size: 13px !important;
            }

            /* Expanded states */
            #category-facet-container.expanded {
                border-color: rgba(59, 130, 246, 0.3) !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
            }

            #category-facet-container.expanded .filter-option {
                display: flex !important;
                width: 100% !important;
                border-radius: 8px !important;
                border: 1px solid transparent !important;
                background: transparent !important;
                margin-bottom: 2px !important;
                padding: 10px 14px !important;
            }

            #category-facet-container.expanded .filter-option:hover {
                background: rgba(255, 255, 255, 0.05) !important;
            }

            #category-facet-container.expanded .filter-option.active {
                background: rgba(59, 130, 246, 0.1) !important;
                border-color: rgba(59, 130, 246, 0.2) !important;
            }

            #category-facet-container.expanded .filter-option.active .filter-label {
                color: var(--accent) !important;
                font-weight: 600 !important;
            }

            #category-facet-container.expanded .filter-option.active .filter-count {
                background: rgba(59, 130, 246, 0.15) !important;
                color: var(--accent) !important;
            }

            .filter-option {
                flex: 0 0 auto !important;
                margin-bottom: 0 !important;
                padding: 8px 14px !important;
                border-radius: 20px !important;
                display: inline-flex !important;
                align-items: center !important;
                background: rgba(255, 255, 255, 0.03) !important;
                border: 1px solid var(--border-color) !important;
            }

            .filter-option:hover {
                background: rgba(255, 255, 255, 0.05) !important;
            }

            .filter-option.active {
                background: var(--accent-gradient) !important;
                border-color: transparent !important;
            }

            .filter-option.active .filter-label {
                color: #fff !important;
                font-weight: 600 !important;
            }

            .filter-option.active .filter-count {
                background: rgba(255, 255, 255, 0.2) !important;
                color: #fff !important;
            }

            .filter-radio-dot {
                display: none !important;
            }

            .filter-label {
                overflow: visible !important;
                text-overflow: clip !important;
                white-space: nowrap !important;
                font-size: 12px !important;
            }

            .filter-count {
                margin-left: 6px !important;
                font-size: 11px !important;
                padding: 2px 6px !important;
            }

            .search-summary { padding: 24px 16px 20px; }

            .summary-icon {
                width: 44px;
                height: 44px;
                font-size: 17px;
                border-radius: 12px;
            }

            .summary-text h1 { font-size: 18px; }

            .search-time {
                display: block !important;
                margin-left: 0 !important;
                margin-top: 4px !important;
            }
        }

        @media (max-width: 768px) {
            .header-inner {
                padding: 0 10px;
                gap: 8px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                box-sizing: border-box;
            }

            .brand-name {
                display: none !important;
            }

            .brand-link {
                flex: 0 0 38px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .header-search-form {
                flex: 1 1 0 !important;
                max-width: none !important;
                margin: 0 !important;
                min-width: 0 !important;
            }

            .search-input-wrap {
                width: 100% !important;
            }

            .search-input-wrap input {
                height: 38px !important;
                padding: 8px 12px 8px 34px !important;
                font-size: 16px !important; /* Prevents mobile browser auto-zoom on input focus */
                border-radius: 10px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            input, select, textarea {
                font-size: 16px !important; /* Global mobile safety to prevent iOS zoom */
            }

            .search-input-wrap .search-icon {
                left: 11px !important;
                font-size: 12px !important;
            }

            .header-actions {
                flex: 0 0 38px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .btn-guest-user {
                padding: 0 !important;
                width: 38px !important;
                height: 38px !important;
                min-width: 38px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 10px !important;
                flex-shrink: 0 !important;
            }

            .btn-guest-user span {
                display: none !important;
            }

            .btn-guest-user i {
                font-size: 15px !important;
                margin: 0 !important;
            }

            /* Responsive Search History Dropdown */
            .srp-search-history {
                position: fixed !important;
                top: calc(var(--header-height) + 6px) !important;
                left: 10px !important;
                right: 10px !important;
                width: auto !important;
                max-width: calc(100vw - 20px) !important;
                box-sizing: border-box !important;
                max-height: 65vh !important;
                border-radius: 14px !important;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.9) !important;
                z-index: 100000 !important;
            }

            .search-summary {
                margin-top: var(--header-height) !important;
                padding: 16px 14px 12px !important;
            }

            .summary-inner {
                gap: 12px !important;
            }

            .summary-icon {
                width: 38px !important;
                height: 38px !important;
                font-size: 15px !important;
                border-radius: 10px !important;
            }

            .summary-text h1 {
                font-size: 16px !important;
                margin-bottom: 2px !important;
            }

            .summary-text p {
                font-size: 12.5px !important;
            }

            .search-main {
                display: block !important;
                padding: 14px 12px 60px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            .filter-sidebar {
                position: -webkit-sticky !important;
                position: sticky !important;
                top: var(--header-height) !important;
                max-height: calc(100vh - var(--header-height) - 10px) !important;
                margin-bottom: 14px !important;
                padding: 0 !important;
                width: 100% !important;
                z-index: 500 !important;
            }

            .filter-panel {
                padding: 10px 12px !important;
                border-radius: 14px !important;
                background: rgba(12, 18, 32, 0.95) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border: 1px solid var(--border-color) !important;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.45) !important;
            }

            .results-container {
                width: 100% !important;
            }

            .result-card {
                padding: 14px 14px !important;
                border-radius: 14px !important;
                margin-bottom: 12px !important;
                width: 100% !important;
                box-sizing: border-box !important;
                word-break: break-word !important;
            }

            .result-card h2, .result-card .result-title {
                font-size: 15px !important;
                line-height: 1.35 !important;
                word-break: break-word !important;
            }

            .result-card .result-subtitle {
                font-size: 13px !important;
                line-height: 1.35 !important;
                word-break: break-word !important;
            }

            .result-card .result-snippet {
                font-size: 12.5px !important;
                line-height: 1.5 !important;
            }

            /* Mobile Pagination */
            .pagination-container {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 5px !important;
                margin-top: 24px !important;
                padding: 0 4px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            .page-btn {
                min-width: 34px !important;
                height: 34px !important;
                padding: 0 8px !important;
                font-size: 12px !important;
                border-radius: 8px !important;
            }

            /* Hide the Prev/Next text labels, keep only arrows on very small screens */
            .page-btn .pagination-label {
                display: none !important;
            }
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
                <div class="search-input-wrap" id="header-search-wrap">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="main-search-input" value="{{ $query }}" placeholder="Search any law or case in Ghana...">
                </div>
                <div class="search-empty-prompt-toast" id="header-search-prompt" style="display:none;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Search query cannot be empty. Please enter a keyword to search.</span>
                </div>
                <div class="srp-search-history" id="srpSearchHistory"></div>
            </div>

            <div class="header-actions">
                @guest
                    @if(request()->cookie('guest_access'))
                        <button type="button" onclick="openLoginModal()" class="btn-guest-user" title="Guest User - Click to login or register">
                            <i class="fa-solid fa-user-secret"></i>
                            <span>Guest User</span>
                        </button>
                    @else
                        <a href="/get-started" class="btn-guest-user" title="Sign Up Free">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Sign Up Free</span>
                        </a>
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
                <!-- Mobile Toggle Header -->
                <div class="mobile-filter-header" onclick="toggleFilterPanel()">
                    <span>
                        <i class="fa-solid fa-sliders"></i> Search Filters
                    </span>
                    <span id="mobile-filter-toggle-icon" style="transition: transform 0.25s ease; display: inline-block;">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>

                <div class="filter-panel-collapsible collapsed" id="filterPanelCollapsible">
                    <h3 class="filter-title desktop-only-title">
                        <i class="fa-solid fa-filter"></i> Categories
                    </h3>
                    <div class="filter-divider desktop-only-divider"></div>

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

                    <!-- New Laws -->
                    <div class="filter-option {{ $posts_total_count == 0 ? 'disabled' : '' }}" data-category="4th_Republic" id="filter-4th-rep">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">New Laws</span>
                        <span class="filter-count" id="count-4th-rep">{{ $posts_total_count }}</span>
                    </div>

                    <!-- Case Laws -->
                    <div class="filter-option {{ $cases_total_count == 0 ? 'disabled' : '' }}" data-category="Case_Laws" id="filter-cases">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">Case Laws</span>
                        <span class="filter-count" id="count-cases">{{ $cases_total_count }}</span>
                    </div>

                    <!-- Existing Laws -->
                    <div class="filter-option {{ $pre_total_count == 0 ? 'disabled' : '' }}" data-category="Pre_4th_Republic" id="filter-pre4th">
                        <span class="filter-radio-dot"></span>
                        <span class="filter-label">Existing Laws</span>
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
                </div> <!-- /filter-panel-collapsible -->
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

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

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
            if (!query || !text) return text || '';
            const cleanWord = decodeURIComponent(query).replace(/[\+_]/g, ' ').trim();
            if (!cleanWord) return text;
            
            try {
                const words = cleanWord.split(/[\s\-+]+/).filter(w => w.length > 0);
                if (words.length === 0) return text;
                const escapedWords = words.map(w => w.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'));
                const pattern = escapedWords.join('[ \\-]+');
                const regex = new RegExp(`(${pattern})`, 'gi');
                return String(text).replace(regex, '<mark class="title-highlight">$1</mark>');
            } catch(e) {
                return text;
            }
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

            // Use fewer page buttons on mobile
            const isMobile = window.innerWidth <= 768;
            const rangeLimit = isMobile ? 1 : 2;

            let html = `
                <button class="page-btn ${page === 1 ? 'disabled' : ''}" data-page="${page - 1}">
                    <i class="fa-solid fa-chevron-left"></i><span class="pagination-label">&nbsp;Prev</span>
                </button>
            `;

            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= page - rangeLimit && i <= page + rangeLimit)) {
                    html += `
                        <button class="page-btn ${page === i ? 'active' : ''}" data-page="${i}">
                            ${i}
                        </button>
                    `;
                } else if (i === page - rangeLimit - 1 || i === page + rangeLimit + 1) {
                    html += `<span style="color: var(--text-muted); padding: 0 2px; font-size: 12px;">…</span>`;
                }
            }

            html += `
                <button class="page-btn ${page === totalPages ? 'disabled' : ''}" data-page="${page + 1}">
                    <span class="pagination-label">Next&nbsp;</span><i class="fa-solid fa-chevron-right"></i>
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
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    signal: signal
                });
                
                if (!response.ok) throw new Error('Search request failed (' + response.status + ' ' + response.statusText + ')');
                const data = await response.json();

                // Record search into history dropdown safely
                try {
                    if (currentQuery && currentQuery.trim().length >= 2 && typeof window.recordSearchQuery === 'function') {
                        window.recordSearchQuery(currentQuery.trim());
                    }
                } catch(recErr) {}

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
                if (elements.statsContainer) {
                    elements.statsContainer.innerHTML = `
                        <span class="result-count">${(data.total || 0).toLocaleString()}</span> results found for 
                        &ldquo;<span class="search-query">${escapeHtml(data.query || currentQuery)}</span>&rdquo; 
                        <span class="search-time">(took ${data.time_ms || 0}ms)</span>
                    `;
                }

                // 2. Render cards
                if (!data.results || data.results.length === 0) {
                    elements.resultsFeed.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon"><i class="fa-solid fa-circle-question"></i></div>
                            <h3>No Results Found</h3>
                            <p>We couldn't find matches for "${escapeHtml(data.query || currentQuery)}" with the current filters. Try refining your spelling or clearing filters.</p>
                        </div>
                    `;
                } else {
                    elements.resultsFeed.innerHTML = data.results.map(renderCard).join('');
                }

                // 3. Render pagination
                try { renderPagination(data.page || 1, data.total_pages || 1); } catch(e) {}

                // 4. Update sidebar category counts
                try { updateCategoryCounts((data.facets && data.facets.categories) ? data.facets.categories : {}); } catch(e) {}

                // 5. Render subcategories if selected category is not 'All'
                try { renderSubcategories((data.facets && data.facets.subcategories) ? data.facets.subcategories : {}); } catch(e) {}

                // 6. Render year facets
                try { renderYears((data.facets && data.facets.years) ? data.facets.years : {}); } catch(e) {}

            } catch (error) {
                if (error.name === 'AbortError') {
                    // Ignore aborted request errors
                    return;
                }
                console.error('Search Error:', error);
                elements.resultsFeed.innerHTML = `
                    <div class="no-results">
                        <div class="no-results-icon" style="color: var(--rose);"><i class="fa-solid fa-circle-exclamation"></i></div>
                        <h3>Search Error</h3>
                        <p>${escapeHtml(error.message || 'There was a problem querying the database. Please try again.')}</p>
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
            const cats = categories || {};
            const elAll = document.getElementById('count-all');
            const elConsti = document.getElementById('count-consti-ghana');
            const el4th = document.getElementById('count-4th-rep');
            const elCases = document.getElementById('count-cases');
            const elPre = document.getElementById('count-pre4th');
            const elOthers = document.getElementById('count-consti-others');

            if (elAll) elAll.innerText = (cats.All || 0).toLocaleString();
            if (elConsti) elConsti.innerText = (cats.Constitution_Ghana || 0).toLocaleString();
            if (el4th) el4th.innerText = (cats['4th_Republic'] || 0).toLocaleString();
            if (elCases) elCases.innerText = (cats.Case_Laws || 0).toLocaleString();
            if (elPre) elPre.innerText = (cats.Pre_4th_Republic || 0).toLocaleString();
            if (elOthers) elOthers.innerText = (cats.Constitution_Others || 0).toLocaleString();

            // Disable filters with 0 counts
            if (elements.categoryContainer) {
                elements.categoryContainer.querySelectorAll('.filter-option').forEach(option => {
                    const cat = option.dataset.category;
                    const count = cats[cat] || 0;
                    
                    if (cat !== 'All' && count === 0) {
                        option.classList.add('disabled');
                        if (state.category === cat) {
                            setActiveCategory('All');
                        }
                    } else {
                        option.classList.remove('disabled');
                    }
                });
            }
        }

        // Helper to set active category class
        function setActiveCategory(cat) {
            state.category = cat;
            if (elements.categoryContainer) {
                elements.categoryContainer.querySelectorAll('.filter-option').forEach(opt => {
                    if (opt.dataset.category === cat) {
                        opt.classList.add('active');
                    } else {
                        opt.classList.remove('active');
                    }
                });
            }
        }

        // Render subcategory list dynamically
        function renderSubcategories(subcategories) {
            const subs = subcategories || {};
            if (state.category === 'All' || Object.keys(subs).length === 0) {
                if (elements.subcategoryPanel) elements.subcategoryPanel.style.display = 'none';
                return;
            }

            if (elements.subcategoryPanel) elements.subcategoryPanel.style.display = 'block';

            let html = `
                <div class="filter-option filter-option-sub ${state.subcategory === 'All' ? 'active' : ''}" data-value="All">
                    <span class="filter-radio-dot"></span>
                    <span class="filter-label">All Types</span>
                </div>
            `;

            for (const [sub, count] of Object.entries(subs)) {
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

            if (elements.subcategoryContainer) elements.subcategoryContainer.innerHTML = html;
        }

        // Render year list dynamically
        function renderYears(years) {
            const yrs = years || {};
            if (!years || Object.keys(yrs).length === 0) {
                if (elements.yearPanel) elements.yearPanel.style.display = 'none';
                return;
            }

            if (elements.yearPanel) elements.yearPanel.style.display = 'block';

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

        function showEmptySearchPrompt() {
            const wrap = document.getElementById('header-search-wrap');
            const prompt = document.getElementById('header-search-prompt');
            if (wrap) {
                wrap.classList.remove('error-shake');
                void wrap.offsetWidth;
                wrap.classList.add('error-shake');
                setTimeout(() => wrap.classList.remove('error-shake'), 800);
            }
            if (prompt) {
                prompt.style.display = 'flex';
                setTimeout(() => {
                    if (prompt) prompt.style.display = 'none';
                }, 4000);
            }
            if (elements.searchInput) elements.searchInput.focus();
        }

        // Immediate search on Enter keypress
        elements.searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                clearTimeout(debounceTimer);
                const val = e.target.value.trim();
                if (!val) {
                    e.preventDefault();
                    showEmptySearchPrompt();
                    return;
                }
                const prompt = document.getElementById('header-search-prompt');
                if (prompt) prompt.style.display = 'none';
                state.query = val;
                state.page = 1;
                state.subcategory = 'All';
                state.year = 'All';
                performSearch();
            }
        });

        elements.searchInput.addEventListener('input', (e) => {
            const prompt = document.getElementById('header-search-prompt');
            if (prompt && e.target.value.trim()) {
                prompt.style.display = 'none';
            }
        });

        // Clicking category filters in sidebar
        elements.categoryContainer.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                const option = e.target.closest('.filter-option');
                if (option && !option.classList.contains('disabled')) {
                    if (!elements.categoryContainer.classList.contains('expanded')) {
                        // Open dropdown
                        elements.categoryContainer.classList.add('expanded');
                        e.stopPropagation();
                        return;
                    } else {
                        // Close dropdown on selection
                        elements.categoryContainer.classList.remove('expanded');
                    }
                }
            }

            const option = e.target.closest('.filter-option');
            if (option && !option.classList.contains('disabled')) {
                setActiveCategory(option.dataset.category);
                state.subcategory = 'All';
                state.year = 'All';
                state.page = 1;
                performSearch();
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (elements.categoryContainer && !elements.categoryContainer.contains(e.target)) {
                elements.categoryContainer.classList.remove('expanded');
            }
        });

        // Clicking subcategory filters (delegated)
        elements.subcategoryContainer.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                const option = e.target.closest('.filter-option-sub');
                if (option) {
                    if (!elements.subcategoryContainer.classList.contains('expanded')) {
                        // Open dropdown
                        elements.subcategoryContainer.classList.add('expanded');
                        e.stopPropagation();
                        return;
                    } else {
                        // Close dropdown on selection
                        elements.subcategoryContainer.classList.remove('expanded');
                    }
                }
            }

            const option = e.target.closest('.filter-option-sub');
            if (option) {
                state.subcategory = option.dataset.value;
                state.page = 1;
                performSearch();
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (elements.subcategoryContainer && !elements.subcategoryContainer.contains(e.target)) {
                elements.subcategoryContainer.classList.remove('expanded');
            }
        });

        // Clicking year filters (delegated)
        elements.yearContainer.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                const option = e.target.closest('.filter-option-year');
                if (option) {
                    if (!elements.yearContainer.classList.contains('expanded')) {
                        // Open dropdown
                        elements.yearContainer.classList.add('expanded');
                        e.stopPropagation();
                        return;
                    } else {
                        // Close dropdown on selection
                        elements.yearContainer.classList.remove('expanded');
                    }
                }
            }

            const option = e.target.closest('.filter-option-year');
            if (option) {
                state.year = option.dataset.value;
                state.page = 1;
                performSearch();
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (elements.yearContainer && !elements.yearContainer.contains(e.target)) {
                elements.yearContainer.classList.remove('expanded');
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

        // Preloaded server-rendered initial data
        window.initialSearchData = {!! isset($initialSearchData) ? json_encode($initialSearchData) : 'null' !!};

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

            if (elements.searchInput) elements.searchInput.value = state.query;

            // Instant Preload: If initial search data was bundled on page load, render immediately without an extra network request
            if (window.initialSearchData && window.initialSearchData.results && window.initialSearchData.query === state.query && state.category === 'All' && state.subcategory === 'All' && state.year === 'All' && state.page === 1) {
                const data = window.initialSearchData;
                window.initialSearchData = null; // Clear so subsequent filter clicks use AJAX

                // 1. Update stats
                if (elements.statsContainer) {
                    elements.statsContainer.innerHTML = `
                        <span class="result-count">${(data.total || 0).toLocaleString()}</span> results found for 
                        &ldquo;<span class="search-query">${escapeHtml(data.query || state.query)}</span>&rdquo; 
                        <span class="search-time">(took ${data.time_ms || 0}ms)</span>
                    `;
                }

                // 2. Render cards
                if (!data.results || data.results.length === 0) {
                    elements.resultsFeed.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon"><i class="fa-solid fa-circle-question"></i></div>
                            <h3>No Results Found</h3>
                            <p>We couldn't find matches for "${escapeHtml(data.query || state.query)}" with the current filters.</p>
                        </div>
                    `;
                } else {
                    elements.resultsFeed.innerHTML = data.results.map(renderCard).join('');
                }

                // 3. Render pagination, facets, counts
                try { renderPagination(data.page || 1, data.total_pages || 1); } catch(e) {}
                try { updateCategoryCounts((data.facets && data.facets.categories) ? data.facets.categories : {}); } catch(e) {}
                try { renderSubcategories((data.facets && data.facets.subcategories) ? data.facets.subcategories : {}); } catch(e) {}
                try { renderYears((data.facets && data.facets.years) ? data.facets.years : {}); } catch(e) {}

                // Record search into history dropdown safely
                try {
                    if (state.query && state.query.trim().length >= 2 && typeof window.recordSearchQuery === 'function') {
                        window.recordSearchQuery(state.query.trim());
                    }
                } catch(e) {}

                return;
            }

            performSearch();
        }

        // Toggle collapse/expand of mobile filter panel content
        window.toggleFilterPanel = function() {
            const content = document.getElementById('filterPanelCollapsible');
            const icon = document.getElementById('mobile-filter-toggle-icon');
            if (content && icon) {
                const isCollapsed = content.classList.toggle('collapsed');
                if (isCollapsed) {
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(-180deg)';
                }
            }
        };

        // Load initially
        window.addEventListener('popstate', initFromUrl);
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFromUrl);
        } else {
            initFromUrl();
        }

        // ============================================
        // SEARCH HISTORY DROPDOWN (Search Results Page)
        // ============================================
        (function() {
            const srpHistoryEl = document.getElementById('srpSearchHistory');
            const srpSearchInput = document.getElementById('main-search-input');
            if (!srpHistoryEl || !srpSearchInput) return;

            @php
                $srpPopularTags = array_values(array_filter(array_map('trim', explode(',', homepage_setting('slide_0_popular_tags', 'tax, finance, land, rent')))));
            @endphp
            const popularTerms = {!! json_encode($srpPopularTags) !!};

            function getLocal() {
                try { return JSON.parse(localStorage.getItem('lawsforum_recent_searches') || '[]'); } catch(e) { return []; }
            }

            function saveLocal(q) {
                if (!q || !q.trim()) return;
                try {
                    let list = getLocal().filter(i => i.search_text.toLowerCase() !== q.trim().toLowerCase());
                    list.unshift({ id: 'loc_' + Date.now(), search_text: q.trim(), searched_at: 'Just now' });
                    localStorage.setItem('lawsforum_recent_searches', JSON.stringify(list.slice(0, 10)));
                } catch(e) {}
            }

            function renderSH(data) {
                let h = '';

                if (data && data.length > 0) {
                    h += '<div class="srp-sh-header">';
                    h += '<span class="srp-sh-header-title"><i class="fa-solid fa-clock-rotate-left" style="color:#60a5fa;"></i> Recent Searches</span>';
                    h += '<button type="button" class="srp-sh-clear" id="srpShClear">Clear All</button></div>';

                    data.forEach(item => {
                        const eq = item.search_text.replace(/"/g, '&quot;').replace(/</g, '&lt;');
                        h += '<div class="srp-sh-item" data-q="' + eq + '" data-id="' + item.id + '">';
                        h += '<div class="srp-sh-item-icon"><i class="fa-solid fa-magnifying-glass"></i></div>';
                        h += '<div class="srp-sh-item-text"><div class="srp-sh-item-query">' + eq + '</div>';
                        h += '<div class="srp-sh-item-time">' + (item.searched_at || 'Recently') + '</div></div>';
                        h += '<button type="button" class="srp-sh-item-del" data-del-id="' + item.id + '"><i class="fa-solid fa-xmark"></i></button>';
                        h += '</div>';
                    });
                }

                h += '<div class="srp-sh-header" style="margin-top:' + (data && data.length > 0 ? '8px' : '0') + ';">';
                h += '<span class="srp-sh-header-title"><i class="fa-solid fa-fire" style="color:#f59e0b;"></i> Popular Suggestions</span></div>';
                h += '<div style="display:flex; flex-wrap:wrap; gap:6px; padding:6px 4px;">';
                popularTerms.forEach(t => {
                    const eq = t.replace(/"/g, '&quot;').replace(/</g, '&lt;');
                    h += '<span class="srp-sh-item" data-q="' + eq + '" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); padding:5px 12px; border-radius:16px; font-size:12px;">';
                    h += '<i class="fa-solid fa-arrow-trend-up" style="color:#60a5fa; margin-right:4px; font-size:10px;"></i> ' + eq;
                    h += '</span>';
                });
                h += '</div>';

                srpHistoryEl.innerHTML = h;
                srpHistoryEl.classList.add('visible');

                // Item click → search
                srpHistoryEl.querySelectorAll('.srp-sh-item').forEach(el => {
                    el.addEventListener('click', (e) => {
                        if (e.target.closest('.srp-sh-item-del')) return;
                        const q = el.getAttribute('data-q');
                        if (q) {
                            srpSearchInput.value = q;
                            saveLocal(q);
                            srpHistoryEl.classList.remove('visible');
                            state.query = q;
                            state.page = 1;
                            state.subcategory = 'All';
                            state.year = 'All';
                            performSearch();
                        }
                    });
                });

                // Delete item
                srpHistoryEl.querySelectorAll('.srp-sh-item-del').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const id = btn.getAttribute('data-del-id');
                        const row = btn.closest('.srp-sh-item');
                        if (row) { row.style.opacity = '0'; row.style.transition = 'opacity 0.2s'; }

                        try {
                            let localData = getLocal().filter(i => String(i.id) !== String(id));
                            localStorage.setItem('lawsforum_recent_searches', JSON.stringify(localData));
                        } catch(e) {}

                        if (!String(id).startsWith('loc_')) {
                            fetch('/search-history/' + id, {
                                method: 'DELETE',
                                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
                            }).catch(() => {});
                        }

                        setTimeout(() => {
                            if (row) row.remove();
                            if (!srpHistoryEl.querySelector('.srp-sh-item')) renderSH([]);
                            shCache = null;
                        }, 200);
                    });
                });

                // Clear all
                const clearBtn = document.getElementById('srpShClear');
                if (clearBtn) {
                    clearBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        try { localStorage.removeItem('lawsforum_recent_searches'); } catch(e) {}
                        fetch('/search-history', {
                            method: 'DELETE',
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
                        }).catch(() => {});
                        shCache = null;
                        renderSH([]);
                    });
                }
            }

            function fetchSH() {
                const local = getLocal();
                if (local && local.length > 0) renderSH(local); else renderSH([]);

                if (shFetching) return;
                shFetching = true;
                fetch('/search-history?limit=8', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(d => {
                    shFetching = false;
                    if (d.success && d.data && d.data.length > 0) {
                        shCache = d.data;
                        try { localStorage.setItem('lawsforum_recent_searches', JSON.stringify(d.data)); } catch(e) {}
                        renderSH(d.data);
                    }
                })
                .catch(() => { shFetching = false; });
            }

            function showIfReady() {
                const local = getLocal();
                if (local && local.length > 0) {
                    renderSH(local);
                } else if (shCache && shCache.length > 0) {
                    renderSH(shCache);
                } else {
                    fetchSH();
                }
            }

            // Expose globally so performSearch can record every search immediately
            window.recordSearchQuery = function(query) {
                if (!query || !query.trim() || query.trim().length < 2) return;
                saveLocal(query.trim());
                shCache = null;
                // Re-fetch in background to sync server IDs
                if (shFetching) return;
                shFetching = true;
                fetch('/search-history?limit=8', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(d => {
                    shFetching = false;
                    if (d.success && d.data && d.data.length > 0) {
                        shCache = d.data;
                        try { localStorage.setItem('lawsforum_recent_searches', JSON.stringify(d.data)); } catch(e) {}
                    }
                })
                .catch(() => { shFetching = false; });
            };

            // Seed initial query if present
            const initQ = @json($query);
            if (initQ && initQ.trim().length >= 2) {
                saveLocal(initQ.trim());
            }

            srpSearchInput.addEventListener('focus', () => { showIfReady(); });
            srpSearchInput.addEventListener('click', () => { showIfReady(); });

            srpSearchInput.addEventListener('input', () => {
                if (srpSearchInput.value.trim().length > 0) {
                    srpHistoryEl.classList.remove('visible');
                } else {
                    showIfReady();
                }
            });

            document.addEventListener('click', (e) => {
                if (srpHistoryEl.classList.contains('visible')) {
                    if (!srpHistoryEl.contains(e.target) && e.target !== srpSearchInput) {
                        srpHistoryEl.classList.remove('visible');
                    }
                }
            });
        })();
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