<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $searchText = $searchText ?? request()->get('search_text', '');
        $actTitle = $allPre1992Article['pre_1992_act'] ?? $allPre1992Article['title'] ?? 'Legal Document';
        $sectionTitle = $allPre1992Article['section'] ?? 'Section Locked';
        $groupName = $allPre1992Article['pre_1992_group'] ?? 'Existing Laws';
    @endphp

    <title>{{ $sectionTitle }} — Locked Preview — Legals Forum</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(15, 23, 42, 0.78);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.16);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-light: #fbbf24;
            --gold-glow: rgba(245, 158, 11, 0.25);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font-ui: 'Outfit', 'Inter', -apple-system, sans-serif;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-ui);
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glow Blobs */
        .ambient-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.25;
            pointer-events: none;
            z-index: 0;
        }
        .blob-1 {
            width: 450px;
            height: 450px;
            background: #3b82f6;
            top: -80px;
            left: 50%;
            transform: translateX(-50%);
        }
        .blob-2 {
            width: 350px;
            height: 350px;
            background: #f59e0b;
            bottom: -50px;
            right: 10%;
        }

        /* Header Navigation */
        .gate-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(6, 10, 19, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 0 20px;
        }
        .gate-header-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            gap: 12px;
        }
        .gate-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #fff;
            flex-shrink: 0;
            transition: var(--transition);
        }
        .gate-logo:hover { opacity: 0.88; }
        .logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: #fff;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.35);
            flex-shrink: 0;
        }
        .logo-text {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.4px;
            white-space: nowrap;
        }
        .gate-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .btn-nav-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            text-decoration: none;
            transition: var(--transition);
            white-space: nowrap;
        }
        .btn-nav-back:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }
        .btn-nav-login {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--accent-gradient);
            border-radius: 10px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
            white-space: nowrap;
        }
        .btn-nav-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
        }

        /* Main Content Container */
        .gate-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px 16px 48px;
            position: relative;
            z-index: 1;
        }

        .gate-card {
            width: 100%;
            max-width: 740px;
            background: var(--card-bg);
            border: 1px solid rgba(245, 158, 11, 0.25);
            border-radius: 22px;
            padding: 38px 32px 34px;
            text-align: center;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 0 1px rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            animation: cardFadeUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .gate-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #f59e0b, #8b5cf6);
        }

        @keyframes cardFadeUp {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Floating Lock Icon */
        .lock-icon-wrap {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            background: radial-gradient(circle at 30% 30%, rgba(245, 158, 11, 0.25), rgba(245, 158, 11, 0.08));
            border: 1.5px solid rgba(245, 158, 11, 0.45);
            color: var(--gold-light);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
            box-shadow: 0 0 30px var(--gold-glow);
            animation: pulseGlow 3s infinite ease-in-out;
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px var(--gold-glow); transform: scale(1); }
            50% { box-shadow: 0 0 40px rgba(245, 158, 11, 0.4); transform: scale(1.03); }
        }

        /* Pill Badge */
        .gate-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.28);
            margin-bottom: 14px;
        }

        /* Section Title & Document Headings */
        .gate-title {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.4px;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .gate-act-meta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 18px;
            max-width: 100%;
            word-break: break-word;
        }
        .gate-act-meta i { color: var(--accent-light); flex-shrink: 0; }

        .gate-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 580px;
            margin: 0 auto 28px;
        }
        .gate-desc strong {
            color: #fff;
            font-weight: 600;
        }

        /* Role Upgrade Cards */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 28px;
            text-align: left;
        }

        .role-card {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 18px 16px 18px 16px;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            min-height: 130px;
        }
        .role-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.25);
            background: rgba(25, 35, 55, 0.85);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
        }

        .role-card.featured {
            border-color: rgba(245, 158, 11, 0.45);
            background: rgba(245, 158, 11, 0.06);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.1);
        }
        .role-card.featured:hover {
            border-color: rgba(245, 158, 11, 0.7);
            background: rgba(245, 158, 11, 0.12);
        }

        .role-featured-tag {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 8.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 2px 7px;
            border-radius: 6px;
            background: rgba(245, 158, 11, 0.25);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }

        .role-icon {
            position: absolute;
            bottom: 14px;
            right: 14px;
            width: 26px;
            height: 26px;
            min-width: 26px;
            max-width: 26px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11.5px;
            margin: 0;
            flex-shrink: 0;
            pointer-events: none;
        }
        .role-student .role-icon {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        .role-lawyer .role-icon {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }
        .role-researcher .role-icon {
            background: rgba(139, 92, 246, 0.18);
            color: #a78bfa;
            border: 1px solid rgba(139, 92, 246, 0.35);
        }

        .role-info { flex: 1; min-width: 0; }
        .role-name {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 3px;
            padding-right: 48px;
        }
        .role-subtitle {
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.4;
            margin-bottom: 14px;
            padding-right: 32px;
        }

        .role-btn-text {
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
            margin-top: auto;
        }
        .role-student .role-btn-text { color: #60a5fa; }
        .role-lawyer .role-btn-text { color: #fbbf24; }
        .role-researcher .role-btn-text { color: #c4b5fd; }
        .role-card:hover .role-btn-text i { transform: translateX(3px); }

        /* Secondary Footer Links */
        .gate-footer-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding-top: 18px;
            border-top: 1px solid var(--border-color);
        }
        .gate-back-link {
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
            cursor: pointer;
        }
        .gate-back-link:hover { color: #fff; }
        .gate-login-prompt {
            font-size: 13px;
            color: var(--text-muted);
        }
        .gate-login-prompt a {
            color: var(--accent-light);
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
        }
        .gate-login-prompt a:hover { text-decoration: underline; }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            html, body {
                overflow-x: hidden !important;
                width: 100% !important;
                max-width: 100vw !important;
            }

            .ambient-blob { display: none !important; }

            .gate-header { padding: 0 10px; }
            .gate-header-inner { height: 52px; gap: 6px; }
            .gate-logo { gap: 8px; }
            .logo-icon { width: 30px; height: 30px; font-size: 12px; border-radius: 8px; }
            .logo-text { font-size: 14px; }
            .gate-header-actions { gap: 6px; }
            .btn-nav-back { padding: 5px 8px; font-size: 11px; gap: 4px; border-radius: 8px; }
            .btn-nav-login { padding: 5px 10px; font-size: 11px; gap: 4px; border-radius: 8px; }

            .gate-main { padding: 16px 10px 32px; }
            .gate-card {
                padding: 22px 14px 18px;
                border-radius: 16px;
                max-width: 100% !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
            .lock-icon-wrap { width: 52px; height: 52px; font-size: 22px; border-radius: 14px; margin-bottom: 12px; }
            .gate-badge { font-size: 9px; padding: 3px 8px; margin-bottom: 8px; letter-spacing: 0.5px; }
            .gate-title { font-size: 16px; margin-bottom: 6px; line-height: 1.3; }
            .gate-act-meta { font-size: 11px; padding: 4px 8px; margin-bottom: 10px; border-radius: 8px; }
            .gate-desc { font-size: 12.5px; line-height: 1.5; margin-bottom: 16px; }

            /* Role cards on mobile */
            .roles-grid {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 20px;
            }
            .role-card {
                padding: 14px 14px;
                min-height: auto;
            }
            .role-name {
                font-size: 14px;
                margin-bottom: 3px;
                padding-right: 52px;
            }
            .role-subtitle {
                display: block;
                font-size: 11.5px;
                margin-bottom: 12px;
                line-height: 1.35;
                padding-right: 36px;
            }
            .role-btn-text {
                font-size: 12px;
            }
            .role-icon {
                bottom: 12px;
                right: 12px;
                width: 24px;
                height: 24px;
                min-width: 24px;
                max-width: 24px;
                font-size: 10.5px;
                border-radius: 6px;
            }
            .role-featured-tag {
                top: 8px;
                right: 8px;
                padding: 1px 6px;
                font-size: 8px;
            }

            .gate-footer-actions {
                flex-direction: column;
                gap: 8px;
                text-align: center;
                justify-content: center;
                padding-top: 14px;
            }
            .gate-back-link { font-size: 12px; }
            .gate-login-prompt { font-size: 12px; }
        }
    </style>
</head>
<body>

    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <!-- STICKY HEADER -->
    <header class="gate-header">
        <div class="gate-header-inner">
            <a href="/" class="gate-logo">
                <div class="logo-icon">
                    <i class="fa fa-balance-scale"></i>
                </div>
                <span class="logo-text">Legals Forum</span>
            </a>

            <div class="gate-header-actions">
                @if(!empty($searchText))
                    <a href="{{ url('main_home_search') }}?search_text={{ urlencode($searchText) }}" class="btn-nav-back">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Search</span>
                    </a>
                @else
                    <a href="/" class="btn-nav-back">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                @endif
                <a href="/login" class="btn-nav-login">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Log In</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN GATE HERO -->
    <main class="gate-main">
        <div class="gate-card">
            
            <div class="lock-icon-wrap">
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="gate-badge">
                <i class="fa-solid fa-crown"></i>
                <span>Guest Preview Limit Reached</span>
            </div>

            <h1 class="gate-title">
                {{ !empty($sectionTitle) ? $sectionTitle . ' is Locked' : 'Section Locked for Guest Users' }}
            </h1>

            <div class="gate-act-meta">
                <i class="fa-solid fa-file-shield"></i>
                <span>{{ $actTitle }}</span>
            </div>

            <p class="gate-desc">
                Guest access includes the first <strong>3 preview sections</strong> of every enactment. To unlock <strong>{{ $sectionTitle }}</strong> and explore the full legal library, create an account below.
            </p>

            <!-- ROLE SIGNUP CARDS -->
            <div class="roles-grid">
                <!-- Student -->
                <a href="/register?role=student" class="role-card role-student">
                    <div class="role-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="role-info">
                        <div class="role-name">Student Account</div>
                        <div class="role-subtitle">Academic research, course readings & case studies</div>
                    </div>
                    <div class="role-btn-text">
                        <span>Sign Up Free</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>

                <!-- Lawyer / Practitioner (Featured) -->
                <a href="/register?role=lawyer" class="role-card role-lawyer featured">
                    <span class="role-featured-tag">Popular</span>
                    <div class="role-icon">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div class="role-info">
                        <div class="role-name">Legal Practitioner</div>
                        <div class="role-subtitle">Full law library, judgment citations & advanced research</div>
                    </div>
                    <div class="role-btn-text">
                        <span>Join as Lawyer</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>

                <!-- Researcher -->
                <a href="/register?role=researcher" class="role-card role-researcher">
                    <div class="role-icon">
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                    <div class="role-info">
                        <div class="role-name">Researcher</div>
                        <div class="role-subtitle">Historical Acts, amendments & legal publications</div>
                    </div>
                    <div class="role-btn-text">
                        <span>Sign Up</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <!-- FOOTER NAVIGATION -->
            <div class="gate-footer-actions">
                @if(!empty($searchText))
                    <a href="{{ url('main_home_search') }}?search_text={{ urlencode($searchText) }}" class="gate-back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Return to Results for &ldquo;{{ $searchText }}&rdquo;</span>
                    </a>
                @else
                    <a href="/" class="gate-back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Return to Homepage</span>
                    </a>
                @endif

                <div class="gate-login-prompt">
                    Already have an account? <a href="/login">Log in here</a>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
