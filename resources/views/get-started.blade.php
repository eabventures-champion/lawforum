<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Get Started | Legals Forum</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-primary: #060a13;
            --accent: #3b82f6;
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --guest-color: #10b981;
            --student-color: #3b82f6;
            --lawyer-color: #f59e0b;
            --researcher-color: #8b5cf6;
            --surface: rgba(255, 255, 255, 0.03);
            --surface-border: rgba(255, 255, 255, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 2rem;
        }

        /* Ambient Background Blobs */
        .ambient-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            z-index: -1;
            opacity: 0.4;
            animation: float 20s infinite ease-in-out alternate;
        }
        
        .blob-1 {
            width: 40vw;
            height: 40vw;
            background: rgba(59, 130, 246, 0.2);
            top: -10%;
            left: -10%;
        }

        .blob-2 {
            width: 35vw;
            height: 35vw;
            background: rgba(139, 92, 246, 0.2);
            bottom: -10%;
            right: -10%;
            animation-delay: -10s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(5%, 5%) scale(1.1); }
        }

        .container {
            max-width: 900px;
            width: 100%;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            text-decoration: none;
        }

        .brand-icon {
            font-size: 2rem;
            color: var(--accent);
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-text {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: white;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            width: 100%;
            margin-bottom: 2.5rem;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--surface-border);
            border-radius: 1.25rem;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-align: left;
        }

        /* Forms in cards need to act like blocks */
        .card-form {
            display: block;
            width: 100%;
        }

        .card-form button.card {
            background: var(--surface);
            font-family: inherit;
            font-size: inherit;
        }
        
        .card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1.25rem;
            padding: 2px;
            background: linear-gradient(135deg, var(--card-color), transparent 60%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover::before {
            opacity: 0.5;
        }

        .icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
            background: rgba(255, 255, 255, 0.05);
            color: var(--card-color);
            transition: all 0.3s ease;
        }

        .card:hover .icon-wrapper {
            background: var(--card-color);
            color: #fff;
            box-shadow: 0 8px 24px var(--card-shadow);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
        }
        
        .card-title i.fa-arrow-right {
            margin-left: auto;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
            font-size: 1rem;
            color: var(--card-color);
        }

        .card:hover .card-title i.fa-arrow-right {
            opacity: 1;
            transform: translateX(0);
        }

        .card-desc {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .guest-card {
            --card-color: var(--guest-color);
            --card-shadow: rgba(16, 185, 129, 0.3);
        }

        .student-card {
            --card-color: var(--student-color);
            --card-shadow: rgba(59, 130, 246, 0.3);
        }

        .lawyer-card {
            --card-color: var(--lawyer-color);
            --card-shadow: rgba(245, 158, 11, 0.3);
        }

        .researcher-card {
            --card-color: var(--researcher-color);
            --card-shadow: rgba(139, 92, 246, 0.3);
        }

        .footer-link {
            color: var(--text-secondary);
            font-size: 0.95rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.25rem;
        }

        .footer-link a:hover {
            color: #60a5fa;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
            .header h1 {
                font-size: 1.35rem;
            }
            .card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <div class="container">
        
        <a href="/" class="brand">
            <i class="fa-solid fa-scale-balanced brand-icon"></i>
            <span class="brand-text">Legals Forum</span>
        </a>

        <div class="header">
            <h1>Choose How You'd Like to Get Started</h1>
            <p>Select your access level to begin exploring the premier legal research platform.</p>
        </div>

        <div class="options-grid">
            
            <!-- Guest Card -->
            <form action="/set-guest-access" method="POST" class="card-form">
                @csrf
                <button type="submit" class="card guest-card">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-user-secret"></i>
                    </div>
                    <div class="card-title">
                        Continue as Guest
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                    <div class="card-desc">
                        Browse the platform with limited access. No account needed.
                    </div>
                </button>
            </form>

            <!-- Student Card -->
            <a href="/register?role=student" class="card student-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="card-title">
                    Sign Up as a Student
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
                <div class="card-desc">
                    Access student discounts and tailored legal resources for your studies.
                </div>
            </a>

            <!-- Lawyer Card -->
            <a href="/register?role=lawyer" class="card lawyer-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-gavel"></i>
                </div>
                <div class="card-title">
                    Sign Up as a Lawyer
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
                <div class="card-desc">
                    Full professional access to case laws, legislation, and legal tools.
                </div>
            </a>

            <!-- Researcher Card -->
            <a href="/register?role=researcher" class="card researcher-card">
                <div class="icon-wrapper">
                    <i class="fa-solid fa-microscope"></i>
                </div>
                <div class="card-title">
                    Sign Up as a Researcher
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
                <div class="card-desc">
                    Deep access to legal databases, cross-references, and research tools.
                </div>
            </a>

        </div>

        <div class="footer-link">
            Already have an account? <a href="{{ route('login') }}">Log in here</a>
        </div>

    </div>

@include('partials._premium_guest_gate')
</body>
</html>
