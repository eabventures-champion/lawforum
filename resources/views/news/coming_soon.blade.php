<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="Legals Forum EcoSystem & Newsroom — Real-time legal intelligence, judicial pronouncements, and statutory insights. Coming Soon.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Legals Forum EcoSystem — Coming Soon</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">

    <!-- Google Fonts & FontAwesome 6 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
            --purple: #8b5cf6;
            --emerald: #10b981;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
            position: relative;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        /* Ambient Glow Backgrounds */
        .ambient-glow-top {
            position: fixed;
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            width: min(700px, 100vw);
            height: 380px;
            background: radial-gradient(ellipse, rgba(59, 130, 246, 0.16) 0%, rgba(139, 92, 246, 0.08) 50%, transparent 75%);
            pointer-events: none;
            z-index: 0;
            filter: blur(40px);
        }

        .ambient-glow-bottom {
            position: fixed;
            bottom: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(244, 63, 94, 0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
            filter: blur(50px);
        }

        /* Subtle Geometric Background Grid */
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
            z-index: 0;
        }

        /* ============================================
           TOP NAVIGATION BAR (Mobile-First Architecture)
           ============================================ */
        .cs-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(6, 10, 19, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }

        .cs-nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .cs-brand-group {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            min-width: 0;
        }

        .cs-brand {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .cs-brand i {
            color: #3b82f6;
            font-size: 20px;
            flex-shrink: 0;
        }

        .cs-brand-text {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            white-space: nowrap !important;
        }

        .cs-badge-tag {
            background: rgba(244, 63, 94, 0.12);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.3);
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 5px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .cs-nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .nav-pill-btn {
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .nav-pill-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--border-hover);
        }

        .nav-mobile-toggle {
            display: none;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        /* Mobile Drawer Panel */
        .cs-mobile-drawer {
            display: none;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 20px;
        }

        .cs-mobile-drawer.open {
            display: block;
        }

        .drawer-links {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .drawer-link {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.02);
        }

        .drawer-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        /* ============================================
           MAIN HERO & BODY
           ============================================ */
        .cs-main {
            position: relative;
            z-index: 1;
            flex: 1;
            max-width: 1140px;
            width: 100%;
            margin: 0 auto;
            padding: 48px 20px 70px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 50px;
            overflow-x: hidden;
        }

        /* Hero */
        .cs-hero {
            text-align: center;
            max-width: 760px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 18px;
        }

        .cs-badge-status {
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: var(--accent-light);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 5px 14px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 0 16px rgba(59, 130, 246, 0.15);
        }

        .cs-badge-status .pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #3b82f6;
            box-shadow: 0 0 8px #60a5fa;
            animation: pulseGlow 1.8s infinite;
        }

        @keyframes pulseGlow {
            0% { opacity: 0.4; transform: scale(0.9); }
            50% { opacity: 1; transform: scale(1.3); }
            100% { opacity: 0.4; transform: scale(0.9); }
        }

        .cs-hero-title {
            font-size: clamp(26px, 5.2vw, 52px);
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -0.8px;
            color: #ffffff;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .cs-hero-title .title-gradient {
            background: linear-gradient(135deg, #60a5fa 0%, #a855f7 50%, #fb7185 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .cs-hero-desc {
            font-size: clamp(14px, 1.8vw, 17px);
            color: var(--text-secondary);
            max-width: 600px;
            line-height: 1.6;
            padding: 0 4px;
        }

        .cs-hero-desc strong {
            color: #fff;
            font-weight: 600;
        }

        /* Countdown Grid (Compact & 100% Responsive) */
        .countdown-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            width: 100%;
            max-width: 440px;
            margin: 6px auto 0;
        }

        .countdown-card {
            background: rgba(17, 24, 39, 0.65);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 6px;
            text-align: center;
            backdrop-filter: blur(12px);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, border-color 0.2s;
        }

        .countdown-card:hover {
            border-color: rgba(96, 165, 250, 0.4);
            transform: translateY(-2px);
        }

        .countdown-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #a855f7);
            opacity: 0.8;
        }

        .countdown-val {
            font-size: clamp(20px, 4vw, 28px);
            font-weight: 800;
            color: #fff;
            line-height: 1;
            font-feature-settings: "tnum";
            font-variant-numeric: tabular-nums;
        }

        .countdown-lbl {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        /* Progress Bar */
        .progress-box {
            width: 100%;
            max-width: 520px;
            background: rgba(17, 24, 39, 0.5);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 16px 20px;
            backdrop-filter: blur(12px);
            margin: 0 auto;
        }

        .progress-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 9px;
            font-size: 12.5px;
        }

        .progress-title {
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .progress-pct {
            font-weight: 800;
            color: #60a5fa;
            font-size: 13px;
        }

        .progress-track {
            width: 100%;
            height: 7px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 86%;
            background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 50%, #f43f5e 100%);
            border-radius: 999px;
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.5);
        }

        .progress-milestones {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 11px;
            color: var(--text-muted);
            flex-wrap: wrap;
            gap: 6px;
        }

        .progress-milestones span.done {
            color: #34d399;
            font-weight: 600;
        }

        .progress-milestones span.active {
            color: #60a5fa;
            font-weight: 700;
        }

        /* ============================================
           4 ECOSYSTEM PILLARS
           ============================================ */
        .ecosystem-section {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section-header {
            text-align: center;
        }

        .section-tag {
            color: var(--rose-light);
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .section-heading {
            font-size: clamp(20px, 3.5vw, 26px);
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.4px;
        }

        .pillars-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            width: 100%;
        }

        .pillar-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 22px 18px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            backdrop-filter: blur(14px);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
            min-width: 0;
        }

        .pillar-card:hover {
            transform: translateY(-3px);
            border-color: var(--border-hover);
            background: var(--card-bg-hover);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
        }

        .pillar-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            background: var(--icon-bg, rgba(59, 130, 246, 0.12));
            color: var(--icon-color, #60a5fa);
            border: 1px solid var(--icon-border, rgba(59, 130, 246, 0.25));
            flex-shrink: 0;
        }

        .pillar-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pillar-pill {
            align-self: flex-start;
            font-size: 9.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            padding: 2px 7px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
        }

        .pillar-title {
            font-size: 16px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.2px;
        }

        .pillar-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .pillar-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 600;
            color: var(--card-accent, #60a5fa);
        }

        /* ============================================
           VIP EARLY ACCESS INVITATION CARD
           ============================================ */
        .early-access-card {
            background: linear-gradient(145deg, rgba(30, 58, 138, 0.25) 0%, rgba(15, 23, 42, 0.6) 100%);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 20px;
            padding: 36px 24px;
            text-align: center;
            max-width: 680px;
            width: 100%;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
            margin: 0 auto;
        }

        .early-access-title {
            font-size: clamp(20px, 3vw, 26px);
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .early-access-desc {
            font-size: 13.5px;
            color: var(--text-secondary);
            max-width: 480px;
            margin: 0 auto 22px;
            line-height: 1.55;
        }

        .early-access-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 440px;
            margin: 0 auto;
            width: 100%;
        }

        .cs-input {
            width: 100%;
            height: 40px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0 12px;
            color: #fff;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s ease;
            font-family: inherit;
        }

        .cs-input:focus {
            border-color: var(--accent);
        }

        .cs-btn-submit {
            width: 100%;
            height: 40px;
            padding: 0 16px;
            border-radius: 8px;
            background: var(--accent);
            color: #fff;
            border: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s ease;
        }

        .cs-btn-submit:hover {
            background: #2563eb;
        }

        .notification-toast {
            display: none;
            margin-top: 14px;
            padding: 9px 14px;
            border-radius: 8px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #34d399;
            font-size: 12.5px;
            font-weight: 600;
        }

        .quick-nav-pills {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .quick-nav-pill {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }

        .quick-nav-pill:hover {
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.06);
        }

        /* Footer */
        .cs-footer {
            border-top: 1px solid var(--border-color);
            padding: 24px 20px;
            background: rgba(6, 10, 19, 0.95);
            margin-top: auto;
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .cs-footer-inner {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 12.5px;
            color: var(--text-muted);
        }

        .cs-footer-links {
            display: flex;
            gap: 16px;
        }

        .cs-footer-links a {
            color: var(--text-secondary);
        }

        .cs-footer-links a:hover {
            color: #fff;
        }

        /* ============================================
           RESPONSIVE MEDIA QUERIES (DevTools 400px Friendly)
           ============================================ */
        @media (max-width: 991px) {
            .pillars-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .cs-nav-inner {
                padding: 12px 16px !important;
            }

            .cs-brand i {
                font-size: 18px !important;
            }

            .cs-brand-text {
                font-size: 17px !important;
                letter-spacing: 0.2px !important;
            }

            .cs-badge-tag {
                display: none !important; /* Hide secondary tag on mobile to save space */
            }

            .nav-pill-btn.desktop-only {
                display: none !important;
            }

            .nav-mobile-toggle {
                display: inline-flex !important;
            }

            .cs-main {
                padding: 32px 16px 50px !important;
                gap: 36px !important;
            }

            .countdown-container {
                grid-template-columns: repeat(4, 1fr) !important;
                gap: 6px !important;
                max-width: 360px !important;
            }

            .countdown-card {
                padding: 10px 4px !important;
            }

            .countdown-val {
                font-size: 20px !important;
            }

            .countdown-lbl {
                font-size: 9px !important;
            }

            .progress-milestones {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 6px !important;
                text-align: left !important;
            }

            .pillars-grid {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            .early-access-card {
                padding: 24px 16px !important;
            }

            .early-access-form {
                display: flex !important;
                flex-direction: column !important;
                gap: 10px !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 auto !important;
            }

            .cs-input {
                width: 100% !important;
                height: 40px !important;
                background: rgba(0, 0, 0, 0.3) !important;
                border: 1px solid var(--border-color) !important;
                border-radius: 8px !important;
                padding: 0 12px !important;
                font-size: 13px !important;
                color: #fff !important;
                outline: none !important;
                text-align: left !important;
                box-sizing: border-box !important;
                font-family: inherit !important;
            }

            .cs-input:focus {
                border-color: var(--accent) !important;
            }

            .cs-input::placeholder {
                text-align: left !important;
                color: var(--text-muted) !important;
                font-size: 13px !important;
            }

            .cs-btn-submit {
                width: 100% !important;
                height: 40px !important;
                padding: 0 14px !important;
                font-size: 13px !important;
                font-weight: 700 !important;
                border-radius: 8px !important;
                border: none !important;
                background: var(--accent) !important;
                color: #fff !important;
                cursor: pointer !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 8px !important;
                transition: background 0.2s ease !important;
            }

            .cs-btn-submit:hover {
                background: #2563eb !important;
            }

            .cs-footer-inner {
                flex-direction: column !important;
                text-align: center !important;
                gap: 10px !important;
            }
        }

        @media (max-width: 480px) {
            .countdown-container {
                gap: 5px !important;
            }
            .countdown-val {
                font-size: 18px !important;
            }
            .quick-nav-pills {
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 6px !important;
                width: 100% !important;
            }
            .quick-nav-pill {
                justify-content: center !important;
                font-size: 11px !important;
                padding: 6px 8px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glow Lights -->
    <div class="ambient-glow-top"></div>
    <div class="ambient-glow-bottom"></div>
    <div class="grid-overlay"></div>

    <!-- Navigation Bar (Matches Platform Layout) -->
    <header class="cs-nav">
        <div class="cs-nav-inner">
            <div class="cs-brand-group">
                <a href="/" class="cs-brand" title="Back to Legals Forum Home">
                    <i class="fa fa-balance-scale"></i>
                    <span class="cs-brand-text">Legals Forum</span>
                </a>
                <span class="cs-badge-tag">EcoSystem</span>
            </div>

            <div class="cs-nav-actions">
                <a href="/judgement/Ghana" class="nav-pill-btn desktop-only" title="Explore Case Laws">
                    <i class="fa-solid fa-gavel" style="color: #60a5fa;"></i>
                    <span>Case Laws</span>
                </a>
                <a href="/" class="nav-pill-btn desktop-only" title="Platform Home">
                    <i class="fa-solid fa-house"></i>
                    <span>Home</span>
                </a>
                <button type="button" class="nav-mobile-toggle" onclick="toggleComingSoonMenu()" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div class="cs-mobile-drawer" id="csMobileDrawer">
            <div class="drawer-links">
                <a href="/" class="drawer-link"><i class="fa-solid fa-house" style="color: #60a5fa;"></i> Platform Home</a>
                <a href="/judgement/Ghana" class="drawer-link"><i class="fa-solid fa-gavel" style="color: #60a5fa;"></i> Case Laws</a>
                <a href="/constitution/Republic/Ghana/1" class="drawer-link"><i class="fa-solid fa-landmark" style="color: #fb7185;"></i> 1992 Constitution</a>
                <a href="/existing-laws" class="drawer-link"><i class="fa-solid fa-scroll" style="color: #34d399;"></i> Existing Laws</a>
                <a href="/new-laws" class="drawer-link"><i class="fa-solid fa-scale-balanced" style="color: #c084fc;"></i> New Laws</a>
                <a href="mailto:info@legalsforum.com" class="drawer-link"><i class="fa-solid fa-envelope" style="color: #f59e0b;"></i> Contact Support</a>
            </div>
        </div>
    </header>

    <!-- Spacer to offset fixed header -->
    <div id="csHeaderSpacer"></div>
    <script>
        (function() {
            var header = document.querySelector('.cs-nav');
            var spacer = document.getElementById('csHeaderSpacer');
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
    <main class="cs-main">

        <!-- Hero Section -->
        <section class="cs-hero">
            <div class="cs-badge-status">
                <span class="pulse-dot"></span>
                <span>In Active Development • Phase 2 Launch</span>
            </div>

            <h1 class="cs-hero-title">
                The Legal Intelligence<br>
                <span class="title-gradient">EcoSystem & Newsroom</span>
            </h1>

            <p class="cs-hero-desc">
                We are crafting an interconnected legal research suite, real-time judicial intelligence reporting, and curated knowledge platforms for <strong>lawyers, students, and legal scholars</strong> across Ghana and the international community.
            </p>

            <!-- Live Countdown Timer (4 Columns on all devices) -->
            <div class="countdown-container">
                <div class="countdown-card">
                    <div class="countdown-val" id="cntDays">28</div>
                    <div class="countdown-lbl">Days</div>
                </div>
                <div class="countdown-card">
                    <div class="countdown-val" id="cntHours">14</div>
                    <div class="countdown-lbl">Hours</div>
                </div>
                <div class="countdown-card">
                    <div class="countdown-val" id="cntMinutes">32</div>
                    <div class="countdown-lbl">Mins</div>
                </div>
                <div class="countdown-card">
                    <div class="countdown-val" id="cntSeconds">45</div>
                    <div class="countdown-lbl">Secs</div>
                </div>
            </div>

            <!-- Progress Meter -->
            <div class="progress-box">
                <div class="progress-header">
                    <span class="progress-title">
                        <i class="fa-solid fa-sliders" style="color: #3b82f6;"></i>
                        System Readiness
                    </span>
                    <span class="progress-pct">86% Ready</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill"></div>
                </div>
                <div class="progress-milestones">
                    <span class="done"><i class="fa-solid fa-circle-check"></i> Core Engine</span>
                    <span class="done"><i class="fa-solid fa-circle-check"></i> News Feeds</span>
                    <span class="active"><i class="fa-solid fa-spinner fa-spin"></i> Judicial Linking</span>
                    <span><i class="fa-regular fa-circle"></i> Public Rollout</span>
                </div>
            </div>
        </section>

        <!-- 4 EcoSystem Pillars -->
        <section class="ecosystem-section">
            <div class="section-header">
                <div class="section-tag">Connecting Minds Beyond</div>
                <h2 class="section-heading">Four Pillars of the EcoSystem</h2>
            </div>

            <div class="pillars-grid">
                <!-- Pillar 1: Newsroom -->
                <div class="pillar-card" style="--card-accent: #f43f5e; --icon-bg: rgba(244, 63, 94, 0.12); --icon-color: #fb7185; --icon-border: rgba(244, 63, 94, 0.3);">
                    <div class="pillar-icon-box">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <div class="pillar-meta">
                        <span class="pillar-pill">Editorial Intelligence</span>
                        <h3 class="pillar-title">Legal Newsroom</h3>
                        <p class="pillar-desc">
                            Real-time reporting on Supreme Court pronouncements, commercial rulings, statutory enactments, and legal developments across Ghana and 4 continents.
                        </p>
                    </div>
                    <div class="pillar-footer">
                        <span>Curated Legal Coverage</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Pillar 2: Students Hub -->
                <div class="pillar-card" style="--card-accent: #3b82f6; --icon-bg: rgba(59, 130, 246, 0.12); --icon-color: #60a5fa; --icon-border: rgba(59, 130, 246, 0.3);">
                    <div class="pillar-icon-box">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="pillar-meta">
                        <span class="pillar-pill">Academic Hub</span>
                        <h3 class="pillar-title">Students Suite</h3>
                        <p class="pillar-desc">
                            High-yield case summaries, constitutional breakdown modules, legal exam revision decks, and essential study companions built specifically for law candidates.
                        </p>
                    </div>
                    <div class="pillar-footer">
                        <span>Academic Excellence</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Pillar 3: Lawyers Practice -->
                <div class="pillar-card" style="--card-accent: #10b981; --icon-bg: rgba(16, 185, 129, 0.12); --icon-color: #34d399; --icon-border: rgba(16, 185, 129, 0.3);">
                    <div class="pillar-icon-box">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div class="pillar-meta">
                        <span class="pillar-pill">Practice Tools</span>
                        <h3 class="pillar-title">Lawyers & Firms</h3>
                        <p class="pillar-desc">
                            Unmatched case law precedent archives, citation cross-referencing, judicial research tools, and fast drafting companion tools for practicing attorneys.
                        </p>
                    </div>
                    <div class="pillar-footer">
                        <span>Professional Tools</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Pillar 4: Contact & Community -->
                <div class="pillar-card" style="--card-accent: #a855f7; --icon-bg: rgba(168, 85, 247, 0.12); --icon-color: #c084fc; --icon-border: rgba(168, 85, 247, 0.3);">
                    <div class="pillar-icon-box">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div class="pillar-meta">
                        <span class="pillar-pill">Collaboration</span>
                        <h3 class="pillar-title">Community & Contact</h3>
                        <p class="pillar-desc">
                            Collaborative discussions, editorial submissions, early partner integration, and continuous legal education forums uniting the legal fraternity.
                        </p>
                    </div>
                    <div class="pillar-footer">
                        <span>Direct Channel</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- VIP Early Access / Notification Card -->
        <section class="early-access-card">
            <h3 class="early-access-title">Receive an Invitation on Launch Day</h3>
            <p class="early-access-desc">
                Be the first to access the Legal Newsroom and new EcoSystem tools as soon as public enrollment opens. Strictly legal releases.
            </p>

            <form id="notifyForm" class="early-access-form" onsubmit="handleNotifySubmit(event)">
                <input type="email" id="subscriberEmail" class="cs-input" placeholder="Enter your email address..." required autocomplete="email">
                <button type="submit" id="btnNotify" class="cs-btn-submit">
                    <span>Notify Me</span>
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>

            <div id="notifyToast" class="notification-toast">
                <i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i>
                <span>Thank you! We have reserved your priority invitation for launch.</span>
            </div>

            <!-- Quick Navigation to Live Platform Sections -->
            <div class="quick-nav-pills">
                <a href="/judgement/Ghana" class="quick-nav-pill"><i class="fa-solid fa-gavel" style="color: #60a5fa;"></i> Case Laws</a>
                <a href="/constitution/Republic/Ghana/1" class="quick-nav-pill"><i class="fa-solid fa-landmark" style="color: #fb7185;"></i> Constitution</a>
                <a href="/existing-laws" class="quick-nav-pill"><i class="fa-solid fa-scroll" style="color: #34d399;"></i> Existing Laws</a>
                <a href="/new-laws" class="quick-nav-pill"><i class="fa-solid fa-scale-balanced" style="color: #c084fc;"></i> New Laws</a>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="cs-footer">
        <div class="cs-footer-inner">
            <p>&copy; {{ date('Y') }} {{ setting('site.title', 'Legals Forum') }}. Connecting minds beyond.</p>
            <div class="cs-footer-links">
                <a href="/"><i class="fa-solid fa-house" style="margin-right: 4px;"></i> Home</a>
                <a href="/judgement/Ghana"><i class="fa-solid fa-gavel" style="margin-right: 4px;"></i> Cases</a>
                <a href="mailto:info@legalsforum.com"><i class="fa-solid fa-envelope" style="margin-right: 4px;"></i> Contact</a>
            </div>
        </div>
    </footer>

    @php
        $savedCountdownTarget = homepage_setting('slide_1_news_countdown_target', '');
        $isoCountdownTarget = '';
        if (!empty($savedCountdownTarget)) {
            try {
                $isoCountdownTarget = \Carbon\Carbon::parse($savedCountdownTarget)->toIso8601String();
            } catch (\Exception $e) {
                $isoCountdownTarget = '';
            }
        }
    @endphp

    <!-- Countdown & Notification Script -->
    <script>
        // Toggle mobile drawer
        function toggleComingSoonMenu() {
            var drawer = document.getElementById('csMobileDrawer');
            if (drawer) {
                drawer.classList.toggle('open');
            }
        }

        // Live Countdown Timer
        (function() {
            var targetIso = "{{ $isoCountdownTarget }}";
            var target = targetIso ? new Date(targetIso) : null;
            if (!target || isNaN(target.getTime())) {
                target = new Date();
                target.setDate(target.getDate() + 28);
                target.setHours(target.getHours() + 14);
            }

            function updateCountdown() {
                var now = new Date().getTime();
                var distance = target - now;

                if (distance < 0) {
                    distance = 0;
                }

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                var dEl = document.getElementById('cntDays');
                var hEl = document.getElementById('cntHours');
                var mEl = document.getElementById('cntMinutes');
                var sEl = document.getElementById('cntSeconds');

                if (dEl) dEl.textContent = String(days).padStart(2, '0');
                if (hEl) hEl.textContent = String(hours).padStart(2, '0');
                if (mEl) mEl.textContent = String(minutes).padStart(2, '0');
                if (sEl) sEl.textContent = String(seconds).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        })();

        // Handle Early Access Form
        function handleNotifySubmit(e) {
            e.preventDefault();
            var emailInput = document.getElementById('subscriberEmail');
            var btn = document.getElementById('btnNotify');
            var toast = document.getElementById('notifyToast');

            if (!emailInput || !emailInput.value.trim()) return;

            var email = emailInput.value.trim();
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> <span>Reserving...</span>';

            fetch("{{ route('news.launch-invitation') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}',
                    "Accept": "application/json"
                },
                body: JSON.stringify({ email: email })
            })
            .then(function(res) {
                return res.json().then(function(data) {
                    if (!res.ok) {
                        throw new Error(data.message || (data.errors && data.errors.email ? data.errors.email[0] : 'Failed to submit'));
                    }
                    return data;
                });
            })
            .then(function(data) {
                btn.disabled = true;
                btn.style.background = '#10b981';
                btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Reserved!</span>';
                if (toast) {
                    toast.style.display = 'block';
                    toast.style.background = 'rgba(16, 185, 129, 0.15)';
                    toast.style.borderColor = 'rgba(16, 185, 129, 0.35)';
                    toast.style.color = '#34d399';
                    toast.innerHTML = '<i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> <span>' + (data.message || 'Thank you! We have reserved your priority invitation for launch.') + '</span>';
                }
                emailInput.disabled = true;
            })
            .catch(function(err) {
                btn.disabled = false;
                btn.innerHTML = '<span>Notify Me</span> <i class="fa-solid fa-paper-plane"></i>';
                if (toast) {
                    toast.style.display = 'block';
                    toast.style.background = 'rgba(244, 63, 94, 0.15)';
                    toast.style.borderColor = 'rgba(244, 63, 94, 0.35)';
                    toast.style.color = '#fb7185';
                    toast.innerHTML = '<i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> <span>' + (err.message || 'An error occurred. Please try again.') + '</span>';
                }
            });
        }
    </script>

    @include('partials._premium_guest_gate')

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