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

        .nav-logo img {
            height: 42px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover img {
            transform: scale(1.05);
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

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
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

        .nav-user-dropdown:hover .nav-dropdown-menu,
        .nav-user-dropdown.active .nav-dropdown-menu {
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
            margin-top: -40px;
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

            .hero { padding: 120px 20px 80px; }

            .search-container {
                flex-direction: column;
                padding: 12px;
                gap: 8px;
            }
            .search-icon { display: none; }
            .search-container input { padding: 12px; text-align: center; }
            .search-btn { width: 100%; padding: 14px; }

            .stats-bar {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }
            .stat-item:nth-child(2)::after { display: none; }

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
        }

        /* Mobile nav panel */
        .mobile-nav-panel {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(6, 10, 19, 0.97);
            backdrop-filter: blur(20px);
            z-index: 9999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .mobile-nav-panel.open {
            display: flex;
        }

        .mobile-nav-panel a {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-secondary);
            padding: 12px 24px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .mobile-nav-panel a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .mobile-nav-close {
            position: absolute;
            top: 20px;
            right: 24px;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 28px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- ====== NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <img src="{{ asset('logo/lawsghlog.png') }}" alt="LawsGhana">
            </a>

            <div class="nav-menu-links-premium">
                <a href="/constitution/Republic/Ghana/1">Constitution</a>
                <a href="/pre-1992-legislation">Pre-1992 Laws</a>
                <a href="/post-1992-legislation">Post-1992 Laws</a>
                <a href="/judgement/Ghana">Case Laws</a>
                <a href="/News/Ghana-News/1">News</a>
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
        <a href="/constitution/Republic/Ghana/1">Constitution</a>
        <a href="/pre-1992-legislation">Pre-1992 Laws</a>
        <a href="/post-1992-legislation">Post-1992 Laws</a>
        <a href="/judgement/Ghana">Case Laws</a>
        <a href="/News/Ghana-News/1">News</a>
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

    <!-- ====== HERO SECTION ====== -->
    <section class="hero">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <i class="fa-solid fa-bolt"></i>
                Cloud-Based Legal Research Platform
            </div>

            <h1 class="hero-title">
                Ghana's Premier<br>
                <span class="gradient-text">Legal Research</span> Platform
            </h1>

            <p class="hero-subtitle">
                Access thousands of laws, cases, constitutional instruments, and legal
                news — all in one powerful, searchable platform built for legal professionals.
            </p>

            <div class="hero-search">
                <form action="{{ url('main_home_search') }}" method="GET">
                    {{ csrf_field() }}
                    <div class="search-container">
                        <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search_text" placeholder="Search any law, case, or legal document..." autocomplete="off">
                        <button type="submit" class="search-btn">Search</button>
                    </div>
                </form>
            </div>

            <p class="search-hint">
                Popular: <span>Criminal Offences Act</span> <span>1992 Constitution</span> <span>Land Act</span> <span>Court of Appeal</span>
            </p>
        </div>
    </section>

    <!-- ====== STATS BAR ====== -->
    <section class="stats-section">
        <div class="stats-bar reveal">
            <div class="stat-item">
                <div class="stat-number blue" data-target="10000">0</div>
                <div class="stat-label">Laws & Acts</div>
            </div>
            <div class="stat-item">
                <div class="stat-number gold" data-target="5000">0</div>
                <div class="stat-label">Case Laws</div>
            </div>
            <div class="stat-item">
                <div class="stat-number emerald" data-target="100">0</div>
                <div class="stat-label">Constitutions</div>
            </div>
            <div class="stat-item">
                <div class="stat-number violet" data-target="50000">0</div>
                <div class="stat-label">Registered Users</div>
            </div>
        </div>
    </section>

    <!-- ====== CATEGORIES ====== -->
    <section class="categories">
        <div class="section-header reveal">
            <div class="section-label"><i class="fa-solid fa-compass"></i> Explore</div>
            <h2 class="section-title">Browse Legal Resources</h2>
            <p class="section-subtitle">Navigate Ghana's most comprehensive collection of legislation, case law, and constitutional instruments.</p>
        </div>

        <div class="categories-grid">
            <a href="/constitution/Republic/Ghana/1" class="category-card card-constitution reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-landmark-dome"></i></div>
                <h3 class="card-title">Constitution</h3>
                <p class="card-description">Access the Constitution of Ghana along with constitutions of over 100 countries across Africa, Asia, the Americas, and Europe.</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="/pre-1992-legislation" class="category-card card-old-laws reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-scroll"></i></div>
                <h3 class="card-title">Pre-1992 Laws</h3>
                <p class="card-description">Access over 200 Ghanaian laws and enactments passed before the Fourth Republic, covering historical legislation and ordinances.</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="/post-1992-legislation" class="category-card card-new-laws reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-scale-balanced"></i></div>
                <h3 class="card-title">Post-1992 Laws</h3>
                <p class="card-description">Access over 200 consolidated laws of Ghana including Acts, Regulations, and Amendments enacted in the Fourth Republic.</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>

        <div class="categories-bottom">
            <a href="/judgement/Ghana" class="category-card card-case-laws reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-gavel"></i></div>
                <h3 class="card-title">Case Laws</h3>
                <p class="card-description">Access decided cases in Ghana including Supreme Court, High Court, and Court of Appeal rulings and judgments.</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="/News/Ghana-News/1" class="category-card card-news reveal">
                <div class="card-icon-wrap"><i class="fa-solid fa-newspaper"></i></div>
                <h3 class="card-title">Legal News</h3>
                <p class="card-description">Stay updated with relevant legal and business news content from Ghana, Africa, Asia, Europe, and America.</p>
                <span class="card-arrow">Explore <i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>
    </section>

    <!-- ====== FEATURES ====== -->
    <section class="features">
        <div class="section-header reveal">
            <div class="section-label"><i class="fa-solid fa-sparkles"></i> Why LawsGhana</div>
            <h2 class="section-title">Built for Legal Professionals</h2>
            <p class="section-subtitle">Powerful tools designed to make your legal research faster, smarter, and more efficient.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                <h3 class="feature-title">Precise Search</h3>
                <p class="feature-desc">Find exactly what you need with our advanced multi-filter search engine. Navigate thousands of documents in seconds.</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fa-solid fa-database"></i></div>
                <h3 class="feature-title">Comprehensive Database</h3>
                <p class="feature-desc">Access one of the largest collections of Ghanaian legislation, from pre-independence ordinances to the latest Acts of Parliament.</p>
            </div>
            <div class="feature-card reveal">
                <div class="feature-icon"><i class="fa-solid fa-bolt-lightning"></i></div>
                <h3 class="feature-title">Instant Access</h3>
                <p class="feature-desc">Cloud-based platform available 24/7 from any device. Download, bookmark, and organize your research effortlessly.</p>
            </div>
        </div>
    </section>

    <!-- ====== STUDENTS SECTION ====== -->
    <section class="students-section">
        <div class="students-inner">
            <div class="students-text reveal">
                <div class="students-badge">
                    <i class="fa-solid fa-graduation-cap"></i>
                    For Law Students
                </div>
                <h2 class="students-title">
                    Empowering the <span class="highlight">Next Generation</span> of Legal Minds
                </h2>
                <p class="students-desc">
                    Whether you're preparing for exams, writing a thesis, or building practical research skills — LawsGhana gives you the same tools used by practising lawyers, at your fingertips.
                </p>

                <ul class="student-benefits">
                    <li class="student-benefit">
                        <div class="benefit-icon gold"><i class="fa-solid fa-book-open-reader"></i></div>
                        <div class="benefit-text">
                            <h4>Exam &amp; Thesis Preparation</h4>
                            <p>Quickly find statutes, case citations, and constitutional provisions to strengthen your academic work.</p>
                        </div>
                    </li>
                    <li class="student-benefit">
                        <div class="benefit-icon blue"><i class="fa-solid fa-wallet"></i></div>
                        <div class="benefit-text">
                            <h4>Affordable Access</h4>
                            <p>Student-friendly subscription plans so cost never stands between you and quality legal research.</p>
                        </div>
                    </li>
                    <li class="student-benefit">
                        <div class="benefit-icon emerald"><i class="fa-solid fa-laptop-code"></i></div>
                        <div class="benefit-text">
                            <h4>Research Anywhere, Anytime</h4>
                            <p>Access from your phone, tablet, or laptop — in the library, at home, or on campus. No heavy textbooks needed.</p>
                        </div>
                    </li>
                    <li class="student-benefit">
                        <div class="benefit-icon violet"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="benefit-text">
                            <h4>Career-Ready Skills</h4>
                            <p>Build the digital legal research skills that top law firms and chambers expect from modern graduates.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="students-showcase reveal">
                <div class="student-quote-card">
                    <div class="quote-icon">&ldquo;</div>
                    <p class="quote-text">LawsGhana made my final year research so much easier. I could find cases and statutes in minutes instead of spending hours in the library. It's an essential tool for every law student in Ghana.</p>
                    <div class="quote-author">
                        <div class="quote-avatar">AK</div>
                        <div>
                            <div class="quote-name">Ama K.</div>
                            <div class="quote-role">LLB Graduate, University of Ghana</div>
                        </div>
                    </div>
                </div>

                <div class="student-stats-grid">
                    <div class="student-stat-card">
                        <div class="student-stat-number s-gold">15K+</div>
                        <div class="student-stat-label">Student Users</div>
                    </div>
                    <div class="student-stat-card">
                        <div class="student-stat-number s-blue">12</div>
                        <div class="student-stat-label">Universities</div>
                    </div>
                    <div class="student-stat-card">
                        <div class="student-stat-number s-emerald">24/7</div>
                        <div class="student-stat-label">Always Available</div>
                    </div>
                    <div class="student-stat-card">
                        <div class="student-stat-number s-violet">Free</div>
                        <div class="student-stat-label">To Get Started</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CTA SECTION ====== -->
    @guest
    <section class="cta-section">
        <div class="cta-box reveal">
            <h2 class="cta-title">Start Your Legal Research Today</h2>
            <p class="cta-subtitle">Join thousands of legal professionals, students, and researchers who trust LawsGhana for accurate and efficient legal research.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="cta-btn-primary">
                    <i class="fa-solid fa-user-plus"></i> Create Free Account
                </a>
                <a href="{{ route('login') }}" class="cta-btn-secondary">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In
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
                    <img src="{{ asset('logo/lawsghlog.png') }}" alt="LawsGhana">
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
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <a href="mailto:info@lawsghana.com"><i class="fa-solid fa-envelope" style="width: 16px;"></i> info@lawsghana.com</a>
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

    <!-- ====== SCRIPTS ====== -->
    <script>
        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Scroll reveal animation
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
        function animateCounters() {
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

        // Trigger counter animation when stats section is visible
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        const statsBar = document.querySelector('.stats-bar');
        if (statsBar) statsObserver.observe(statsBar);
    </script>

</body>
</html>
