<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Ghana's premier cloud-based legal research platform. Access thousands of laws, cases, and legal resources efficiently.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('site.title') }} — Ghana's Premier Legal Research Platform</title>

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

    <style>
        /* ============================================
           CSS VARIABLES & RESET
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
            --emerald: #10b981;
            --emerald-glow: rgba(16, 185, 129, 0.2);
            --rose: #f43f5e;
            --rose-glow: rgba(244, 63, 94, 0.2);
            --violet: #8b5cf6;
            --violet-glow: rgba(139, 92, 246, 0.2);
            --cyan: #06b6d4;
            --cyan-glow: rgba(6, 182, 212, 0.2);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font);
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        /* ============================================
           NAVIGATION
           ============================================ */
        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-wrap.scrolled {
            background: rgba(6, 10, 19, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover {
            transform: scale(1.03);
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
        }

        .nav-menu-links-premium a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Dropdown navbar styles for homepage */
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
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            outline: none;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
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
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .btn-signup {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            padding: 9px 22px;
            border-radius: 10px;
            border: none;
            background: var(--accent-gradient);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--accent-glow);
        }

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--accent-glow);
        }

        /* User dropdown (authenticated) */
        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-user-btn:hover {
            background: var(--card-bg-hover);
            border-color: var(--border-hover);
        }

        .nav-user-btn i {
            font-size: 16px;
            color: var(--accent-light);
        }

        .nav-user-dropdown .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0 !important;
            left: auto !important;
            min-width: 220px;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) !important;
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .nav-user-dropdown:hover .nav-dropdown-menu,
        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
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
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-dropdown-menu a i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .nav-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 6px 0;
        }

        .nav-dropdown-menu a.logout-link {
            color: var(--rose);
        }

        .nav-dropdown-menu a.logout-link:hover {
            background: rgba(244, 63, 94, 0.1);
        }

        /* Mobile hamburger */
        .nav-mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 22px;
            cursor: pointer;
            padding: 8px;
        }

        /* ============================================
           HERO SECTION
           ============================================ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            padding: 120px 40px 80px;
        }

        /* Animated gradient mesh background */
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 80%, rgba(6, 182, 212, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 90% 70%, rgba(245, 158, 11, 0.05) 0%, transparent 40%);
            animation: meshFloat 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes meshFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(2%, -3%) rotate(1deg); }
            50% { transform: translate(-1%, 2%) rotate(-0.5deg); }
            75% { transform: translate(-3%, -1%) rotate(0.5deg); }
        }

        /* Floating orbs */
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
        }

        .hero-orb-1 {
            width: 400px;
            height: 400px;
            background: rgba(59, 130, 246, 0.15);
            top: 10%;
            left: 10%;
            animation: orbFloat1 15s ease-in-out infinite;
        }

        .hero-orb-2 {
            width: 300px;
            height: 300px;
            background: rgba(139, 92, 246, 0.12);
            top: 60%;
            right: 10%;
            animation: orbFloat2 18s ease-in-out infinite;
        }

        .hero-orb-3 {
            width: 250px;
            height: 250px;
            background: rgba(6, 182, 212, 0.1);
            bottom: 10%;
            left: 30%;
            animation: orbFloat3 12s ease-in-out infinite;
        }

        @keyframes orbFloat1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(40px, -30px); }
        }
        @keyframes orbFloat2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-50px, 25px); }
        }
        @keyframes orbFloat3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, 40px); }
        }

        /* Grid pattern overlay */
        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 820px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            border-radius: 100px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: var(--accent-light);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 28px;
            animation: fadeInUp 0.8s ease both;
        }

        .hero-badge i {
            font-size: 11px;
        }

        .hero-title {
            font-size: clamp(36px, 6vw, 64px);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        .hero-title .gradient-text {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: clamp(16px, 2vw, 19px);
            color: var(--text-secondary);
            line-height: 1.7;
            max-width: 620px;
            margin: 0 auto 40px;
            font-weight: 400;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Search bar */
        .hero-search {
            animation: fadeInUp 0.8s ease 0.3s both;
        }

        .search-container {
            display: flex;
            align-items: center;
            max-width: 640px;
            margin: 0 auto;
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-hover);
            border-radius: 16px;
            padding: 6px;
            transition: all 0.4s ease;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
        }

        .search-container:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow), 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .search-icon {
            padding: 0 4px 0 16px;
            color: var(--text-muted);
            font-size: 16px;
        }

        .search-container input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 15px;
            font-family: var(--font);
            color: var(--text-primary);
            padding: 14px 12px;
        }

        .search-container input::placeholder {
            color: var(--text-muted);
        }

        .search-btn {
            padding: 12px 28px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .search-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 16px var(--accent-glow);
        }

        .search-hint {
            margin-top: 16px;
            font-size: 13px;
            color: var(--text-muted);
            animation: fadeInUp 0.8s ease 0.4s both;
        }

        .search-hint span {
            display: inline-block;
            padding: 3px 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            margin: 2px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* ============================================
           STATS BAR
           ============================================ */
        .stats-section {
            position: relative;
            z-index: 1;
            padding: 0 40px;
            margin-top: 30px;
        }

        .stats-bar {
            max-width: 1080px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: rgba(17, 24, 39, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .stat-item {
            text-align: center;
            padding: 0 16px;
            position: relative;
        }

        .stat-item:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 15%;
            height: 70%;
            width: 1px;
            background: var(--border-color);
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 4px;
        }

        .stat-number.blue { color: var(--accent-light); }
        .stat-number.gold { color: var(--gold); }
        .stat-number.emerald { color: var(--emerald); }
        .stat-number.violet { color: var(--violet); }

        .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ============================================
           CATEGORIES SECTION
           ============================================ */
        .categories {
            padding: 100px 40px 80px;
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 56px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent-light);
            margin-bottom: 14px;
        }

        .section-title {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 14px;
        }

        .section-subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .categories-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .category-card {
            position: relative;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 36px 28px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            cursor: pointer;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--card-accent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .category-card:hover {
            transform: translateY(-6px);
            border-color: var(--border-hover);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 40px var(--card-glow);
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .card-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 20px;
            transition: all 0.4s ease;
        }

        .category-card:hover .card-icon-wrap {
            transform: scale(1.1);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.3px;
        }

        .card-description {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.65;
            flex: 1;
        }

        .card-arrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 20px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s ease;
        }

        .category-card:hover .card-arrow {
            color: var(--text-primary);
            gap: 10px;
        }

        /* Card color themes */
        .card-constitution { --card-accent: var(--gold); --card-glow: var(--gold-glow); }
        .card-constitution .card-icon-wrap { background: rgba(245, 158, 11, 0.12); color: var(--gold); }

        .card-old-laws { --card-accent: var(--violet); --card-glow: var(--violet-glow); }
        .card-old-laws .card-icon-wrap { background: rgba(139, 92, 246, 0.12); color: var(--violet); }

        .card-new-laws { --card-accent: var(--accent); --card-glow: var(--accent-glow); }
        .card-new-laws .card-icon-wrap { background: rgba(59, 130, 246, 0.12); color: var(--accent-light); }

        .card-case-laws { --card-accent: var(--emerald); --card-glow: var(--emerald-glow); }
        .card-case-laws .card-icon-wrap { background: rgba(16, 185, 129, 0.12); color: var(--emerald); }

        .card-news { --card-accent: var(--rose); --card-glow: var(--rose-glow); }
        .card-news .card-icon-wrap { background: rgba(244, 63, 94, 0.12); color: var(--rose); }

        /* Bottom row: 2 cards centered */
        .categories-grid .category-card:nth-child(4) {
            grid-column: 1 / 2;
            margin-left: auto;
            width: 100%;
        }

        .categories-bottom {
            max-width: 1200px;
            margin: 24px auto 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            padding: 0;
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */
        .features {
            padding: 80px 40px 100px;
            position: relative;
        }

        .features::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 10% 50%, rgba(59, 130, 246, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 90% 30%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
            z-index: 0;
        }

        .features-grid {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .feature-card {
            text-align: center;
            padding: 44px 28px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 24px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-light);
        }

        .feature-card:nth-child(2) .feature-icon {
            background: rgba(16, 185, 129, 0.1);
            color: var(--emerald);
        }

        .feature-card:nth-child(3) .feature-icon {
            background: rgba(245, 158, 11, 0.1);
            color: var(--gold);
        }

        .feature-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* ============================================
           STUDENTS SECTION
           ============================================ */
        .students-section {
            padding: 80px 40px 100px;
            position: relative;
            overflow: hidden;
        }

        .students-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 30% 50%, rgba(245, 158, 11, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 60%);
            z-index: 0;
        }

        .students-inner {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .students-text {
            max-width: 520px;
        }

        .students-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 100px;
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: var(--gold);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .students-title {
            font-size: clamp(26px, 3.5vw, 38px);
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.15;
            margin-bottom: 16px;
        }

        .students-title .highlight {
            background: linear-gradient(135deg, var(--gold) 0%, #fb923c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .students-desc {
            font-size: 16px;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .student-benefits {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .student-benefit {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-top: 2px;
        }

        .benefit-icon.gold { background: rgba(245, 158, 11, 0.12); color: var(--gold); }
        .benefit-icon.blue { background: rgba(59, 130, 246, 0.12); color: var(--accent-light); }
        .benefit-icon.emerald { background: rgba(16, 185, 129, 0.12); color: var(--emerald); }
        .benefit-icon.violet { background: rgba(139, 92, 246, 0.12); color: var(--violet); }

        .benefit-text h4 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .benefit-text p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.55;
        }

        /* Student testimonial card */
        .students-showcase {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .student-quote-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            position: relative;
            overflow: hidden;
        }

        .student-quote-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold), #fb923c, var(--accent));
        }

        .quote-icon {
            font-size: 32px;
            color: rgba(245, 158, 11, 0.25);
            margin-bottom: 16px;
            font-family: Georgia, serif;
            line-height: 1;
        }

        .quote-text {
            font-size: 16px;
            color: var(--text-secondary);
            line-height: 1.7;
            font-style: italic;
            margin-bottom: 20px;
        }

        .quote-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quote-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }

        .quote-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .quote-role {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Student stats mini grid */
        .student-stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .student-stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .student-stat-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .student-stat-number {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 4px;
        }

        .student-stat-number.s-gold { color: var(--gold); }
        .student-stat-number.s-blue { color: var(--accent-light); }
        .student-stat-number.s-emerald { color: var(--emerald); }
        .student-stat-number.s-violet { color: var(--violet); }

        .student-stat-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ============================================
           CUSTOM SLIDES STYLE
           ============================================ */
        .custom-slide-inner {
            max-width: 1080px;
            margin: 0 auto;
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
            min-height: calc(100vh - 150px);
        }
        .custom-slide-text {
            text-align: left;
        }
        .custom-slide-title {
            font-size: clamp(28px, 4.5vw, 40px);
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 24px;
        }
        .custom-slide-subtitle {
            font-size: clamp(14px, 1.8vw, 16px);
            line-height: 1.8;
            color: var(--text-secondary);
            margin-bottom: 32px;
        }
        .custom-slide-card-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .custom-slide-card {
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border-color);
            padding: 40px;
            border-radius: 24px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        @media (max-width: 1024px) {
            .students-inner {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .students-text {
                max-width: 100%;
                text-align: center;
            }
            .student-benefits {
                align-items: center;
            }
            .student-benefit {
                max-width: 400px;
            }
        }

        @media (max-width: 768px) {
            .students-section { padding: 60px 20px 60px; }
            .student-stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        /* ============================================
           CTA SECTION
           ============================================ */
        .cta-section {
            padding: 80px 40px;
        }

        .cta-box {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            padding: 64px 48px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent-gradient);
        }

        .cta-box::after {
            content: '';
            position: absolute;
            bottom: -60%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            z-index: 0;
        }

        .cta-title {
            font-size: clamp(24px, 3.5vw, 36px);
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }

        .cta-subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 500px;
            margin: 0 auto 32px;
            position: relative;
            z-index: 1;
        }

        .cta-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .cta-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            background: var(--accent-gradient);
            color: #fff;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px var(--accent-glow);
        }

        .cta-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px var(--accent-glow);
        }

        .cta-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            background: transparent;
            color: var(--text-primary);
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            border: 1px solid var(--border-hover);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cta-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        /* ============================================
           FOOTER
           ============================================ */
        .footer {
            border-top: 1px solid var(--border-color);
            background: var(--bg-secondary);
            padding: 64px 40px 32px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }

        .footer-brand p {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.7;
            margin-top: 16px;
            max-width: 300px;
        }

        .footer-brand img {
            height: 36px;
            width: auto;
            filter: brightness(1.1);
        }

        .footer-col h4 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-primary);
            margin-bottom: 18px;
        }

        .footer-col a {
            display: block;
            font-size: 14px;
            color: var(--text-secondary);
            padding: 5px 0;
            transition: color 0.3s ease;
        }

        .footer-col a:hover {
            color: var(--accent-light);
        }

        .footer-bottom {
            padding-top: 28px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .footer-socials {
            display: flex;
            gap: 12px;
        }

        .footer-socials a {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .footer-socials a:hover {
            color: var(--accent-light);
            border-color: var(--accent);
            background: rgba(59, 130, 246, 0.1);
        }

        /* ============================================
           SCROLL ANIMATIONS
           ============================================ */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 1024px) {
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .categories-bottom {
                grid-template-columns: 1fr;
                max-width: 380px;
            }
            .footer-top {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
            }
        }

        @media (max-width: 768px) {
            .nav-inner { padding: 14px 20px; }
            .nav-menu-links-premium { display: none; }
            .nav-mobile-toggle { display: block; }
            .nav-logo-text {
                display: inline-block;
                font-size: 18px !important;
                letter-spacing: 0.2px !important;
            }
            .nav-auth { display: none; }

            .hero { padding: 120px 20px 80px; }
            .hero-title {
                font-size: clamp(24px, 5.5vw, 34px);
                letter-spacing: -0.8px;
            }

            .search-container {
                flex-direction: column;
                padding: 0;
                background: transparent;
                border: none;
                box-shadow: none;
                gap: 12px;
            }
            .search-icon { display: none; }
            .search-container input {
                width: 100%;
                background: rgba(17, 24, 39, 0.7);
                border: 1px solid var(--border-hover);
                border-radius: 12px;
                padding: 14px 12px;
                text-align: center;
                color: var(--text-primary);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
            .search-container input:focus {
                border-color: var(--accent);
                box-shadow: 0 0 0 3px var(--accent-glow);
            }
            .search-btn {
                width: 100%;
                padding: 14px;
            }

            .stats-bar {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                padding: 24px 12px;
            }
            .stat-item:nth-child(2)::after { display: none; }
            .stat-number {
                font-size: 24px;
                margin-bottom: 2px;
            }
            .stat-label {
                font-size: 10px;
                letter-spacing: 0.5px;
            }

            .categories { padding: 60px 20px 40px; }
            .categories-grid { grid-template-columns: 1fr; }
            .categories-bottom { grid-template-columns: 1fr; }

            .features { padding: 40px 20px 60px; }
            .features-grid { grid-template-columns: 1fr; }

            .cta-section { padding: 40px 20px; }
            .cta-box { padding: 40px 24px; }
            .cta-buttons { flex-direction: column; }

            .footer { padding: 40px 20px 24px; }
            .footer-top { grid-template-columns: 1fr; gap: 32px; }
            .footer-bottom { flex-direction: column; gap: 16px; text-align: center; }

            /* Custom slide responsive adjustments */
            .custom-slide-inner {
                grid-template-columns: 1fr;
                gap: 32px;
                padding: 100px 20px 60px 20px;
                text-align: center;
                min-height: auto;
            }
            .custom-slide-text {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .custom-slide-card-wrap {
                margin: 0 auto;
                width: 100%;
                max-width: 320px;
            }
            .custom-slide-card {
                padding: 24px 20px;
            }
        }

        /* Mobile nav panel */
        .mobile-nav-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(6, 10, 19, 0.98);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            z-index: 9999;
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
            transform: translateY(24px);
            opacity: 0;
            transition: all 0.3s ease, transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
        }

        .mobile-nav-panel.open a {
            transform: translateY(0);
            opacity: 1;
        }

        /* Stagger animation entry delays for links */
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

        /* Hide indicators and feedback trigger button when mobile nav panel is open */
        .mobile-nav-panel.open ~ #feedback-trigger-btn,
        .mobile-nav-panel.open ~ .premium-indicators {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transition: opacity 0.3s ease, visibility 0.3s ease !important;
        }

        /* ============================================
           PREMIUM FULL-PAGE SLIDER
           ============================================ */
        body {
            overflow: hidden !important;
        }

        .slider-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        .slider-wrapper {
            display: flex;
            flex-direction: row;
            width: 100%;
            height: 100%;
            transition: transform 1.2s cubic-bezier(0.86, 0, 0.07, 1);
        }

        .slide {
            width: 100vw;
            height: 100vh;
            flex-shrink: 0;
            overflow-y: auto;
            position: relative;
            scrollbar-width: none; /* Hide scrollbar for Firefox */
            -ms-overflow-style: none; /* Hide scrollbar for IE/Edge */
        }

        .slide::-webkit-scrollbar {
            display: none; /* Hide scrollbar for Chrome/Safari/Opera */
        }

        .slide-hero {
            overflow: hidden !important;
        }

        .slide-why {
            background: var(--bg-primary);
            padding-top: 90px;
            padding-bottom: 60px;
        }

        .slide-students {
            background: var(--bg-primary);
            padding-top: 90px;
        }

        .premium-indicators {
            position: fixed;
            right: 32px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 20px;
            z-index: 99999;
            pointer-events: auto !important;
        }

        .premium-indicator-item {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            cursor: pointer;
            width: 44px;
            height: 44px;
        }

        .indicator-label {
            position: absolute;
            right: 56px;
            color: var(--text-primary);
            font-size: 13px;
            font-weight: 600;
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            pointer-events: none;
            background: rgba(12, 18, 32, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .premium-indicator-item:hover .indicator-label {
            opacity: 1;
            transform: translateX(0);
        }

        .indicator-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--text-secondary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .premium-indicator-item:hover .indicator-icon-wrap {
            color: var(--text-primary);
            border-color: var(--accent);
            transform: scale(1.1);
            box-shadow: 0 0 15px var(--accent-glow);
        }

        .premium-indicator-item.active .indicator-icon-wrap {
            background: var(--accent-gradient);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 0 20px var(--accent-glow);
            transform: scale(1.15);
        }

        .premium-indicator-item.active .indicator-label {
            color: var(--text-primary);
            border-color: var(--accent);
        }

        /* Adjustments for smaller heights or tablets */
        @media (max-width: 1024px) {
            .premium-indicators {
                right: 16px;
                gap: 16px;
            }
            .premium-indicator-item {
                width: 38px;
                height: 38px;
            }
            .indicator-label {
                right: 50px;
            }
            .indicator-icon-wrap {
                width: 38px;
                height: 38px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <!-- ====== NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 22px;"></i>
                <span class="nav-logo-text" style="font-size: 22px; font-weight: 800; letter-spacing: 0.5px; background: linear-gradient(to right, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Inter', sans-serif;">Legals Forum</span>
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
                        <a href="{{ route('register') }}" class="btn-signup">Sign Up Free</a>
                    @endif
                @else
                    <div class="nav-user-dropdown" id="userDropdown">
                        <button class="nav-user-btn" onclick="document.getElementById('userDropdown').classList.toggle('active')">
                            <i class="fa-solid fa-circle-user"></i>
                            {{ Auth::user()->name }}
                            <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 2px;"></i>
                        </button>
                        <div class="nav-dropdown-menu">
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

            <button class="nav-mobile-toggle" onclick="document.getElementById('mobileNav').classList.add('open')">
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
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: var(--rose);">Sign Out</a>
        @endguest
    </div>

    @php
        $slides = [];
        if (homepage_setting('slide_0_published', '1') == '1') {
            $slides[] = [
                'key' => 'slide_0',
                'class' => 'slide-hero',
                'label' => 'Home',
                'icon' => 'fa-house',
            ];
        }
        if (homepage_setting('slide_1_published', '1') == '1') {
            $slides[] = [
                'key' => 'slide_1',
                'class' => 'slide-why',
                'label' => 'Why Choose Us',
                'icon' => 'fa-award',
            ];
        }
        if (homepage_setting('slide_2_published', '1') == '1') {
            $slides[] = [
                'key' => 'slide_2',
                'class' => 'slide-students',
                'label' => 'Students Package',
                'icon' => 'fa-graduation-cap',
            ];
        }

        try {
            $customSlides = \App\HomepageCustomSlide::where('is_published', 1)->orderBy('order', 'asc')->get();
            foreach ($customSlides as $cSlide) {
                $slides[] = [
                    'key' => 'custom_' . $cSlide->id,
                    'class' => 'slide-custom',
                    'label' => $cSlide->title,
                    'icon' => $cSlide->icon ?: 'fa-circle-dot',
                    'is_custom' => true,
                    'model' => $cSlide,
                ];
            }
        } catch (\Exception $e) {
            // Fallback if table doesn't exist
        }

        $totalSlides = count($slides);
    @endphp

    <div class="slider-container">
        <!-- Premium Vertical Indicators -->
        <div class="premium-indicators">
            @foreach($slides as $index => $slide)
                <div class="premium-indicator-item {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
                    <span class="indicator-label">{{ $slide['label'] }}</span>
                    <div class="indicator-icon-wrap">
                        <i class="fa-solid {{ $slide['icon'] }}"></i>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="slider-wrapper" id="sliderWrapper">

            @if(homepage_setting('slide_0_published', '1') == '1')
                @php
                    $slide0Index = array_search('slide_0', array_column($slides, 'key'));
                @endphp
                <div class="slide slide-hero" id="slide-{{ $slide0Index }}">
                <!-- ====== HERO SECTION ====== -->
                <section class="hero">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <i class="fa-solid fa-bolt"></i>
                {{ homepage_setting('slide_0_badge', 'Cloud-Based Legal Research Platform') }}
            </div>

            <h1 class="hero-title">
                {{ homepage_setting('slide_0_title_part1', "Ghana's Premier") }}<br>
                <span class="gradient-text">{{ homepage_setting('slide_0_title_part2', 'Legal Research') }}</span> {{ homepage_setting('slide_0_title_part3', 'Platform') }}
            </h1>

            <p class="hero-subtitle">
                {{ homepage_setting('slide_0_description', 'Access thousands of laws, cases, constitutional instruments, and legal news — all in one powerful, searchable platform built for legal professionals.') }}
            </p>

            <div class="hero-search">
                <form action="{{ url('main_home_search') }}" method="GET">
                    {{ csrf_field() }}
                    <div class="search-container">
                        <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search_text" placeholder="{{ homepage_setting('slide_0_search_placeholder', 'Search any law, case, or legal document...') }}" autocomplete="off">
                        <button type="submit" class="search-btn">{{ homepage_setting('slide_0_search_btn', 'Search') }}</button>
                    </div>
                </form>
            </div>

            <p class="search-hint">
                {{ homepage_setting('slide_0_popular_prefix', 'Popular:') }}
                @php
                    $tags = explode(',', homepage_setting('slide_0_popular_tags', 'Criminal Offences Act, 1992 Constitution, Land Act, Court of Appeal'));
                @endphp
                @foreach($tags as $tag)
                    <span>{{ trim($tag) }}</span>
                @endforeach
            </p>
        </div>
    </section>

            </div> <!-- Close slide-hero -->
            @endif

            @if(homepage_setting('slide_1_published', '1') == '1')
                @php
                    $slide1Index = array_search('slide_1', array_column($slides, 'key'));
                @endphp
                <div class="slide slide-why" id="slide-{{ $slide1Index }}">
                <!-- ====== STATS BAR ====== -->
    <section class="stats-section">
        <div class="stats-bar reveal">
            <div class="stat-item">
                <div class="stat-number blue" data-target="{{ homepage_setting('slide_1_stat1_num', '10000') }}">0</div>
                <div class="stat-label">{{ homepage_setting('slide_1_stat1_label', 'Laws & Acts') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-number gold" data-target="{{ homepage_setting('slide_1_stat2_num', '5000') }}">0</div>
                <div class="stat-label">{{ homepage_setting('slide_1_stat2_label', 'Case Laws') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-number emerald" data-target="{{ homepage_setting('slide_1_stat3_num', '100') }}">0</div>
                <div class="stat-label">{{ homepage_setting('slide_1_stat3_label', 'Constitutions') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-number violet" data-target="{{ homepage_setting('slide_1_stat4_num', '50000') }}">0</div>
                <div class="stat-label">{{ homepage_setting('slide_1_stat4_label', 'Registered Users') }}</div>
            </div>
        </div>
    </section>

    <!-- ====== CATEGORIES ====== -->
    <section class="categories">
        <div class="section-header reveal">
            <div class="section-label"><i class="fa-solid fa-compass"></i> {{ homepage_setting('slide_1_browse_badge', 'Explore') }}</div>
            <h2 class="section-title">{{ homepage_setting('slide_1_browse_title', 'Browse Legal Resources') }}</h2>
            <p class="section-subtitle">{{ homepage_setting('slide_1_browse_desc', "Navigate Ghana's most comprehensive collection of legislation, case law, and constitutional instruments.") }}</p>
        </div>

        <div class="categories-grid">
            <a href="/constitution/Republic/Ghana/1" class="category-card card-constitution reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-landmark-dome"></i></div>
                <h3 class="card-title">{{ homepage_setting('slide_1_card1_title', 'Constitution') }}</h3>
                <p class="card-description">{{ homepage_setting('slide_1_card1_desc', 'Access the Constitution of Ghana along with constitutions of over 100 countries across Africa, Asia, the Americas, and Europe.') }}</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="/pre-1992-legislation" class="category-card card-old-laws reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-scroll"></i></div>
                <h3 class="card-title">{{ homepage_setting('slide_1_card2_title', 'Pre-1992 Laws') }}</h3>
                <p class="card-description">{{ homepage_setting('slide_1_card2_desc', 'Access over 200 Ghanaian laws and enactments passed before the Fourth Republic, covering historical legislation and ordinances.') }}</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="/post-1992-legislation" class="category-card card-new-laws reveal">
                <div class="card-icon-wrap"><i class="fa fa-balance-scale"></i></div>
                <h3 class="card-title">{{ homepage_setting('slide_1_card3_title', 'Post-1992 Laws') }}</h3>
                <p class="card-description">{{ homepage_setting('slide_1_card3_desc', 'Access over 200 consolidated laws of Ghana including Acts, Regulations, and Amendments enacted in the Fourth Republic.') }}</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>

        <div class="categories-bottom">
            <a href="/judgement/Ghana" class="category-card card-case-laws reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-gavel"></i></div>
                <h3 class="card-title">{{ homepage_setting('slide_1_card4_title', 'Case Laws') }}</h3>
                <p class="card-description">{{ homepage_setting('slide_1_card4_desc', 'Access decided cases in Ghana including Supreme Court, High Court, and Court of Appeal rulings and judgments.') }}</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="/News/Ghana-News/1" class="category-card card-news reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-newspaper"></i></div>
                <h3 class="card-title">{{ homepage_setting('slide_1_card5_title', 'Legal News') }}</h3>
                <p class="card-description">{{ homepage_setting('slide_1_card5_desc', 'Stay updated with relevant legal and business news content from Ghana, Africa, Asia, Europe, and America.') }}</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>
    </section>

    <!-- ====== FEATURES ====== -->
    <section class="features">
        <div class="section-header reveal">
            <div class="section-label"><i class="fa-solid fa-sparkles"></i> {{ homepage_setting('slide_1_features_badge', 'Why Legals Forum') }}</div>
            <h2 class="section-title">{{ homepage_setting('slide_1_features_title', 'Built for Legal Professionals') }}</h2>
            <p class="section-subtitle">{{ homepage_setting('slide_1_features_desc', 'Our platform is engineered to streamline your legal research workflow with powerful tools and complete accuracy.') }}</p>
        </div>

        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                <h3 class="feature-title">{{ homepage_setting('slide_1_f1_title', 'Precise Search') }}</h3>
                <p class="feature-desc">{{ homepage_setting('slide_1_f1_desc', 'Find exactly what you need with our advanced search filters and keyword matching system.') }}</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fa-solid fa-database"></i></div>
                <h3 class="feature-title">{{ homepage_setting('slide_1_f2_title', 'Comprehensive Database') }}</h3>
                <p class="feature-desc">{{ homepage_setting('slide_1_f2_desc', 'Access one of the largest collections of Ghanaian legislation, from pre-independence ordinances to the latest Acts of Parliament.') }}</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fa-solid fa-bolt-lightning"></i></div>
                <h3 class="feature-title">{{ homepage_setting('slide_1_f3_title', 'Instant Access') }}</h3>
                <p class="feature-desc">{{ homepage_setting('slide_1_f3_desc', 'Cloud-based platform available 24/7 from any device. Download, bookmark, and organize your research effortlessly.') }}</p>
            </div>
        </div>
    </section>

            </div> <!-- Close slide-why -->
            @endif

            @if(homepage_setting('slide_2_published', '1') == '1')
                @php
                    $slide2Index = array_search('slide_2', array_column($slides, 'key'));
                @endphp
                <div class="slide slide-students" id="slide-{{ $slide2Index }}">
                <!-- ====== STUDENTS SECTION ====== -->
    <section class="students-section">
        <div class="students-inner">
            <div class="students-text reveal">
                <div class="students-badge">
                    <i class="fa-solid fa-graduation-cap"></i>
                    {{ homepage_setting('slide_2_badge', 'For Law Students') }}
                </div>
                <h2 class="students-title">
                    {!! str_replace('Next Generation', '<span class="highlight">Next Generation</span>', e(homepage_setting('slide_2_title', 'Empowering the Next Generation of Legal Minds'))) !!}
                </h2>
                <p class="students-desc">
                    {{ homepage_setting('slide_2_desc', "Whether you're preparing for exams, writing a thesis, or building practical research skills — Legals Forum gives you the same tools used by practising lawyers, at your fingertips.") }}
                </p>

                <ul class="student-benefits">
                    <li class="student-benefit">
                        <div class="benefit-icon gold"><i class="fa-solid fa-book-open-reader"></i></div>
                        <div class="benefit-text">
                            <h4>{{ homepage_setting('slide_2_bullet1_title', 'Exam & Thesis Preparation') }}</h4>
                            <p>{{ homepage_setting('slide_2_bullet1_desc', 'Quickly find statutes, case citations, and constitutional provisions to strengthen your academic work.') }}</p>
                        </div>
                    </li>
                    <li class="student-benefit">
                        <div class="benefit-icon blue"><i class="fa-solid fa-wallet"></i></div>
                        <div class="benefit-text">
                            <h4>{{ homepage_setting('slide_2_bullet2_title', 'Affordable Access') }}</h4>
                            <p>{{ homepage_setting('slide_2_bullet2_desc', 'Student-friendly subscription plans so cost never stands between you and quality legal research.') }}</p>
                        </div>
                    </li>
                    <li class="student-benefit">
                        <div class="benefit-icon emerald"><i class="fa-solid fa-laptop-code"></i></div>
                        <div class="benefit-text">
                            <h4>{{ homepage_setting('slide_2_bullet3_title', 'Research Anywhere, Anytime') }}</h4>
                            <p>{{ homepage_setting('slide_2_bullet3_desc', 'Access from your phone, tablet, or laptop — in the library, at home, or on campus. No heavy textbooks needed.') }}</p>
                        </div>
                    </li>
                    <li class="student-benefit">
                        <div class="benefit-icon violet"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="benefit-text">
                            <h4>{{ homepage_setting('slide_2_bullet4_title', 'Career-Ready Skills') }}</h4>
                            <p>{{ homepage_setting('slide_2_bullet4_desc', 'Build the digital legal research skills that top law firms and chambers expect from modern graduates.') }}</p>
                        </div>
                    </li>
                </ul>
                <div style="margin-top: 32px;">
                    <a href="/subscription" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none; background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #fff; box-shadow: 0 4px 15px rgba(59,130,246,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59,130,246,0.4)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(59,130,246,0.3)';">
                        <i class="fa-solid fa-graduation-cap"></i> {{ homepage_setting('slide_2_btn_text', 'Claim Student Discount') }}
                    </a>
                </div>
            </div>

            <div class="students-showcase reveal">
                <div class="student-quote-card">
                    <div class="quote-icon">&ldquo;</div>
                    <p class="quote-text">{{ homepage_setting('slide_2_quote', "Legals Forum made my final year research so much easier. I could find cases and statutes in minutes instead of spending hours in the library. It's an essential tool for every law student in Ghana.") }}</p>
                    <div class="quote-author">
                        <div class="quote-avatar">AK</div>
                        <div>
                            <div class="quote-name">{{ homepage_setting('slide_2_author', 'Ama K.') }}</div>
                            <div class="quote-role">{{ homepage_setting('slide_2_author_role', 'LLB Graduate, University of Ghana') }}</div>
                        </div>
                    </div>
                </div>

                <div class="student-stats-grid">
                    <div class="student-stat-card">
                        <div class="student-stat-number s-gold">{{ homepage_setting('slide_2_tstat1_num', '15K+') }}</div>
                        <div class="student-stat-label">{{ homepage_setting('slide_2_tstat1_label', 'Student Users') }}</div>
                    </div>
                    <div class="student-stat-card">
                        <div class="student-stat-number s-blue">{{ homepage_setting('slide_2_tstat2_num', '12') }}</div>
                        <div class="student-stat-label">{{ homepage_setting('slide_2_tstat2_label', 'Universities') }}</div>
                    </div>
                    <div class="student-stat-card">
                        <div class="student-stat-number s-emerald">{{ homepage_setting('slide_2_tstat3_num', '24/7') }}</div>
                        <div class="student-stat-label">{{ homepage_setting('slide_2_tstat3_label', 'Always Available') }}</div>
                    </div>
                    <div class="student-stat-card">
                        <div class="student-stat-number s-violet">{{ homepage_setting('slide_2_tstat4_num', 'Free') }}</div>
                        <div class="student-stat-label">{{ homepage_setting('slide_2_tstat4_label', 'To Get Started') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CTA SECTION ====== -->
    @guest
    <section class="cta-section">
        <div class="cta-box reveal">
            <h2 class="cta-title">{{ homepage_setting('slide_2_cta_title', 'Start Your Legal Research Today') }}</h2>
            <p class="cta-subtitle">{{ homepage_setting('slide_2_cta_desc', 'Join thousands of legal professionals, students, and researchers who trust Legals Forum for accurate and efficient legal research.') }}</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="cta-btn-primary">
                    <i class="fa-solid fa-user-plus"></i> {{ homepage_setting('slide_2_cta_btn1_text', 'Create Free Account') }}
                </a>
                <a href="{{ route('login') }}" class="cta-btn-secondary">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> {{ homepage_setting('slide_2_cta_btn2_text', 'Sign In') }}
                </a>
            </div>
        </div>
    </section>
    @endguest

    <!-- ====== FOOTER ====== -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="/" style="display: flex; align-items: center; gap: 10px; text-decoration: none; margin-bottom: 16px; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 20px;"></i>
                        <span style="font-size: 20px; font-weight: 800; letter-spacing: 0.5px; background: linear-gradient(to right, #3b82f6, #60a5fa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-family: 'Inter', sans-serif;">Legals Forum</span>
                    </a>
                    <p>Ghana's premier cloud-based legal research platform. Providing efficient access to legislation, case law, and constitutional resources.</p>
                </div>
                <div class="footer-col">
                    <h4>Resources</h4>
                    <a href="/constitution/Republic/Ghana/1">Constitution</a>
                    <a href="/pre-1992-legislation">Pre-1992 Laws</a>
                    <a href="/post-1992-legislation">Post-1992 Laws</a>
                    <a href="/judgement/Ghana">Case Laws</a>
                    <a href="/News/Ghana-News/1">Legal News</a>
                </div>
                <div class="footer-col">
                    <h4>Account</h4>
                    <a href="{{ route('login') }}">Log In</a>
                    <a href="{{ route('register') }}">Sign Up</a>
                    <a href="/subscription">Subscription</a>
                    <a href="{{ route('admin.login') }}" style="color: #3b82f6 !important; font-weight: 600;">Admin Login</a>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <a href="mailto:info@legalsforum.com"><i class="fa-solid fa-envelope" style="width: 16px;"></i> info@legalsforum.com</a>
                    <a href="tel:+233000000000"><i class="fa-solid fa-phone" style="width: 16px;"></i> Contact Us</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ setting('site.title') }}. All rights reserved.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>
            </div> <!-- Close slide-students -->
            @endif

            @foreach($slides as $index => $slideInfo)
                @if(isset($slideInfo['is_custom']))
                    @php
                        $cSlide = $slideInfo['model'];
                    @endphp
                    <div class="slide slide-custom" id="slide-{{ $index }}" style="background: var(--bg-primary); overflow-y: auto;">
                        <div class="custom-slide-inner">
                            <div class="reveal custom-slide-text">
                                @if($cSlide->is_coming_soon)
                                    <div style="background: linear-gradient(135deg, rgba(245,158,11,0.15) 0%, rgba(217,119,6,0.15) 100%); border: 1px solid rgba(245,158,11,0.3); color: #f59e0b; padding: 6px 16px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 16px;">
                                        <i class="fa-solid fa-lock"></i> Coming Soon
                                    </div>
                                @endif
                                <div>
                                    @if($cSlide->subtitle)
                                        <div class="section-label" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: var(--accent-light); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 16px; background: rgba(59,130,246,0.08); padding: 6px 16px; border-radius: 20px; border: 1px solid rgba(59,130,246,0.15);">
                                            <i class="fa-solid {{ $cSlide->icon ?: 'fa-circle-dot' }}"></i> {{ $cSlide->subtitle }}
                                        </div>
                                    @endif
                                </div>
                                <h2 class="section-title custom-slide-title" style="font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 24px;">
                                    {{ $cSlide->title }}
                                </h2>
                                @if($cSlide->content)
                                    <div class="section-subtitle custom-slide-subtitle" style="">
                                        {!! nl2br(e($cSlide->content)) !!}
                                    </div>
                                @endif
                                @if($cSlide->is_coming_soon)
                                    <div class="btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 12px; font-weight: 600; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: var(--text-secondary); cursor: not-allowed; box-shadow: none;">
                                        <i class="fa-solid fa-hourglass-half"></i> Coming Soon
                                    </div>
                                @else
                                    @if($cSlide->btn_text)
                                        <a href="{{ $cSlide->btn_link ?: '#' }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; border-radius: 12px; font-weight: 600; text-decoration: none; background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: #fff; box-shadow: 0 4px 15px rgba(59,130,246,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59,130,246,0.4)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(59,130,246,0.3)';">
                                            {{ $cSlide->btn_text }} <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>
                            <div class="reveal custom-slide-card-wrap">
                                <div style="position: absolute; width: 300px; height: 300px; background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%); filter: blur(30px); z-index: 0;"></div>
                                <div class="custom-slide-card">
                                    @if($cSlide->is_coming_soon)
                                        <div style="position: absolute; top: 16px; right: 16px; width: 32px; height: 32px; border-radius: 50%; background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.25); display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 14px;">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>
                                    @endif
                                    <div style="width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, rgba(59,130,246,0.1) 0%, rgba(139,92,246,0.1) 100%); border: 1px solid rgba(59,130,246,0.2); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px; color: var(--primary-color);">
                                        <i class="fa-solid {{ $cSlide->icon ?: 'fa-circle-dot' }}"></i>
                                    </div>
                                    <h4 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 8px;">{{ $cSlide->title }}</h4>
                                    <p style="color: var(--text-secondary); font-size: 13px; line-height: 1.6;">Explore this section's features and resources on Legals Forum.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div> <!-- Close slider-wrapper -->
    </div> <!-- Close slider-container -->

    <!-- ====== COMPLAINTS & SUGGESTIONS FLOATING WIDGET ====== -->
    <!-- Floating Action Button -->
    <button type="button" onclick="openFeedbackModal()" id="feedback-trigger-btn" style="position: fixed; bottom: 30px; left: 30px; z-index: 9999; width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s; outline: none;" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 15px 30px rgba(59, 130, 246, 0.6)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 25px rgba(59, 130, 246, 0.4)';">
        <i class="fa-solid fa-comments" style="font-size: 24px; transition: transform 0.3s;" id="feedback-icon"></i>
        <!-- Pulsing Wave Ring -->
        <span style="position: absolute; inset: -4px; border-radius: 50%; border: 2px solid #3b82f6; opacity: 0.4; animation: feedback-pulse 2s infinite;"></span>
    </button>

    <!-- Floating Modal Overlay -->
    <div id="feedback-modal" style="display: none; position: fixed; inset: 0; z-index: 10000; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(8px); align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
        <div id="feedback-modal-card" style="background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 20px; width: 480px; max-width: 90%; max-height: calc(100vh - 60px); overflow-y: auto; margin: 30px 0; padding: 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); transform: translateY(30px); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); display: flex; flex-direction: column; position: relative;">
            
            <!-- Top Gradient Accent -->
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #3b82f6, #8b5cf6);"></div>

            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-headset" style="color: #3b82f6;"></i> Support & Suggestions
                </h3>
                <button type="button" onclick="closeFeedbackModal()" style="background: transparent; border: none; color: rgba(255, 255, 255, 0.4); cursor: pointer; font-size: 20px; transition: color 0.2s;" onmouseover="this.style.color='#fff';" onmouseout="this.style.color='rgba(255, 255, 255, 0.4)';">&times;</button>
            </div>

            <!-- Form Container -->
            <div id="feedback-form-container">
                <form id="ajax-feedback-form" onsubmit="submitFeedbackForm(event)">
                    @csrf
                    <!-- Name & Email Row -->
                    <div style="display: grid; grid-template-columns: 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label for="feedback-name" style="display: block; color: rgba(255, 255, 255, 0.7); font-size: 11px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Your Name (Optional)</label>
                            <input id="feedback-name" type="text" name="name" value="{{ auth()->user() ? auth()->user()->name . ' ' . auth()->user()->lname : '' }}" placeholder="John Doe" style="width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 12px; border-radius: 8px; color: #fff; font-size: 13px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.08)';">
                        </div>
                        <div>
                            <label for="feedback-email" style="display: block; color: rgba(255, 255, 255, 0.7); font-size: 11px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Email Address</label>
                            <input id="feedback-email" type="email" name="email" value="{{ auth()->user() ? auth()->user()->email : '' }}" placeholder="john@example.com" required style="width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 12px; border-radius: 8px; color: #fff; font-size: 13px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.08)';">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 16px; margin-bottom: 16px;">
                        <!-- Type -->
                        <div>
                            <label for="feedback-type" style="display: block; color: rgba(255, 255, 255, 0.7); font-size: 11px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Feedback Type</label>
                            <select id="feedback-type" name="type" required style="width: 100%; background: #1e293b; border: 1px solid rgba(255, 255, 255, 0.08); padding: 12px; border-radius: 8px; color: #fff; font-size: 13px; outline: none; cursor: pointer;">
                                <option value="complaint">Complaint</option>
                                <option value="suggestion">Suggestion</option>
                            </select>
                        </div>
                        <!-- Subject -->
                        <div>
                            <label for="feedback-subject" style="display: block; color: rgba(255, 255, 255, 0.7); font-size: 11px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Subject</label>
                            <input id="feedback-subject" type="text" name="subject" required placeholder="Brief topic summary" style="width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 12px; border-radius: 8px; color: #fff; font-size: 13px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.08)';">
                        </div>
                    </div>

                    <!-- Message -->
                    <div style="margin-bottom: 24px;">
                        <label for="feedback-message" style="display: block; color: rgba(255, 255, 255, 0.7); font-size: 11px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Message Description</label>
                        <textarea id="feedback-message" name="message" required placeholder="Describe your issue or suggestion in detail..." style="width: 100%; height: 120px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 12px; border-radius: 8px; color: #fff; font-size: 13px; outline: none; resize: vertical; line-height: 1.5;" onfocus="this.style.borderColor='#3b82f6';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.08)';"></textarea>
                  </div>

                  <!-- Submit Button -->
                  <button type="submit" id="feedback-submit-btn" style="width: 100%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border: none; color: #fff; padding: 14px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2); transition: background 0.2s;">
                      <i class="fa-solid fa-paper-plane"></i> Submit Feedback
                  </button>
              </form>
          </div>

          <!-- Success Message Container -->
          <div id="feedback-success-container" style="display: none; text-align: center; padding: 40px 0;">
              <div style="width: 70px; height: 70px; background: rgba(16, 185, 129, 0.1); border: 2px solid #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                  <i class="fa-solid fa-check" style="font-size: 32px; color: #10b981;"></i>
              </div>
              <h4 style="color: #fff; font-size: 18px; font-weight: 700; margin: 0 0 10px 0;">Submission Successful!</h4>
              <p style="color: rgba(255, 255, 255, 0.6); font-size: 14px; margin: 0; line-height: 1.5;">Thank you for your feedback. Our administrative team will review it and reply via email shortly.</p>
          </div>

      </div>
  </div>

  <style>
      @keyframes feedback-pulse {
          0% { transform: scale(1); opacity: 0.6; }
          100% { transform: scale(1.3); opacity: 0; }
      }
  </style>

  <script>
      function openFeedbackModal() {
          const modal = document.getElementById('feedback-modal');
          const card = document.getElementById('feedback-modal-card');
          const icon = document.getElementById('feedback-icon');
          
          if (icon) icon.style.transform = 'rotate(15deg)';
          
          modal.style.display = 'flex';
          setTimeout(() => {
              modal.style.opacity = '1';
              card.style.transform = 'translateY(0)';
          }, 10);
      }

      function closeFeedbackModal() {
          const modal = document.getElementById('feedback-modal');
          const card = document.getElementById('feedback-modal-card');
          const icon = document.getElementById('feedback-icon');
          
          if (icon) icon.style.transform = 'none';

          modal.style.opacity = '0';
          card.style.transform = 'translateY(30px)';
          setTimeout(() => {
              modal.style.display = 'none';
              // Reset containers
              document.getElementById('feedback-form-container').style.display = 'block';
              document.getElementById('feedback-success-container').style.display = 'none';
              document.getElementById('ajax-feedback-form').reset();
          }, 300);
      }

      function submitFeedbackForm(event) {
          event.preventDefault();
          const form = document.getElementById('ajax-feedback-form');
          const formData = new FormData(form);
          const submitBtn = document.getElementById('feedback-submit-btn');

          submitBtn.disabled = true;
          submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Submitting...`;

          fetch('{{ route("complaints.store") }}', {
              method: 'POST',
              headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: formData
          })
          .then(res => res.json())
          .then(data => {
              if (data.success) {
                  document.getElementById('feedback-form-container').style.display = 'none';
                  document.getElementById('feedback-success-container').style.display = 'block';
                  
                  // Auto close modal after 3 seconds
                  setTimeout(() => {
                      closeFeedbackModal();
                  }, 3000);
              } else {
                  alert(data.message || 'An error occurred during submission.');
                  submitBtn.disabled = false;
                  submitBtn.innerHTML = `<i class="fa-solid fa-paper-plane"></i> Submit Feedback`;
              }
          })
          .catch(err => {
              console.error('Error submitting feedback:', err);
              // Fallback
              document.getElementById('feedback-form-container').style.display = 'none';
              document.getElementById('feedback-success-container').style.display = 'block';
              setTimeout(() => {
                  closeFeedbackModal();
              }, 3000);
          });
      }
  </script>

    <!-- ====== SCRIPTS ====== -->
    <script>
        // Navbar scroll effect and menu helpers
        const nav = document.getElementById('mainNav');
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Scroll reveal animation (fallback / standard)
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 80);
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

        revealElements.forEach(el => revealObserver.observe(el));

        // Stats counter animation
        let countersAnimated = false;
        function animateCounters() {
            if (countersAnimated) return;
            countersAnimated = true;
            
            const counters = document.querySelectorAll('.stat-number[data-target]');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    // Ease out cubic
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(eased * target);

                    if (target >= 1000) {
                        counter.textContent = (current / 1000).toFixed(current >= target ? 0 : 1) + 'K+';
                    } else {
                        counter.textContent = current + '+';
                    }

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    }
                }

                requestAnimationFrame(updateCounter);
            });
        }

        // ============================================
        // PREMIUM SLIDER CONTROLLER
        // ============================================
        let currentSlide = 0;
        const totalSlides = {{ $totalSlides }};
        let isTransitioning = false;
        let lastWheelTime = 0;
        let autoSlideTimeout;

        const sliderWrapper = document.getElementById('sliderWrapper');
        const indicatorItems = document.querySelectorAll('.premium-indicator-item');

        function goToSlide(slideIndex) {
            if (slideIndex < 0 || slideIndex >= totalSlides || isTransitioning) return;
            
            isTransitioning = true;
            
            try {
                currentSlide = slideIndex;
                
                // Translate the wrapper horizontally
                if (sliderWrapper) {
                    sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
                }
                
                // Update active state of indicators
                const items = document.querySelectorAll('.premium-indicator-item');
                items.forEach((item, index) => {
                    item.classList.toggle('active', index === currentSlide);
                });

                // Update navbar header class
                const activeSlide = document.getElementById(`slide-${currentSlide}`);
                if (nav) {
                    nav.classList.toggle('scrolled', currentSlide > 0 || (activeSlide && activeSlide.scrollTop > 20));
                }

                // Trigger animations for the active slide
                activateRevealAnimations(currentSlide);

                // Animate counters if switching to slide 1 (Why Choose Us)
                if (currentSlide === 1) {
                    animateCounters();
                }
            } catch (err) {
                console.error('Error transitioning slide:', err);
            } finally {
                // Reset transitions lock after animation finishes (matching 1.2s CSS transition)
                setTimeout(() => {
                    isTransitioning = false;
                }, 1200);
            }

            resetAutoSlide();
        }

        function activateRevealAnimations(slideIndex) {
            const activeSlide = document.getElementById(`slide-${slideIndex}`);
            if (activeSlide) {
                const reveals = activeSlide.querySelectorAll('.reveal');
                reveals.forEach((reveal, idx) => {
                    setTimeout(() => {
                        reveal.classList.add('visible');
                    }, idx * 80);
                });
            }
        }



        // Click listeners on premium vertical indicator items
        document.addEventListener('click', (e) => {
            const item = e.target.closest('.premium-indicator-item');
            if (item) {
                const targetSlide = parseInt(item.getAttribute('data-slide'));
                if (!isNaN(targetSlide)) {
                    goToSlide(targetSlide);
                }
            }
        });

        // Slide inner scroll listener to toggle header background
        for (let i = 0; i < totalSlides; i++) {
            const slideEl = document.getElementById(`slide-${i}`);
            if (slideEl) {
                slideEl.addEventListener('scroll', () => {
                    if (i === currentSlide) {
                        nav.classList.toggle('scrolled', currentSlide > 0 || slideEl.scrollTop > 20);
                    }
                });
            }
        }

        // Stagnant user interaction detection: resets auto-sliding when user moves cursor or interacts
        let lastMoveTime = 0;
        window.addEventListener('mousemove', () => {
            const now = performance.now();
            if (now - lastMoveTime > 300) { // Throttle updates
                lastMoveTime = now;
                resetAutoSlide();
            }
        });

        window.addEventListener('touchmove', () => {
            resetAutoSlide();
        });

        // Automatic slideshow loop
        function startAutoSlide() {
            // Do not start auto-slide if search input is focused
            const searchInput = document.querySelector('input[name="search_text"]');
            if (searchInput && document.activeElement === searchInput) {
                return;
            }

            autoSlideTimeout = setTimeout(() => {
                goToSlide((currentSlide + 1) % totalSlides);
            }, 10000); // Only slide when page is stagnant for 10 seconds
        }

        function resetAutoSlide() {
            clearTimeout(autoSlideTimeout);
            startAutoSlide();
        }

        // Add focus/blur event listeners to the search input
        const searchInput = document.querySelector('input[name="search_text"]');
        if (searchInput) {
            searchInput.addEventListener('focus', () => {
                clearTimeout(autoSlideTimeout);
            });
            searchInput.addEventListener('blur', () => {
                resetAutoSlide();
            });
        }

        // Initialize slider
        activateRevealAnimations(0);
        startAutoSlide();
    </script>

</body>
</html>
