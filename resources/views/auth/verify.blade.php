<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Your Email | Legals Forum</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 60%);
            --card-bg: rgba(13, 20, 38, 0.45);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.3);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --success-color: #10b981;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        /* Ambient background blobs */
        .ambient-blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 40vw;
            height: 40vw;
            background: rgba(59, 130, 246, 0.08);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            animation: float 20s ease-in-out infinite alternate;
        }

        .ambient-blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 40vw;
            height: 40vw;
            background: rgba(236, 72, 153, 0.05);
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            animation: float 25s ease-in-out infinite alternate-reverse;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 50px) scale(1.1); }
        }

        /* Glassmorphism Auth Container */
        .auth-container {
            width: 100%;
            max-width: 460px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            z-index: 10;
            position: relative;
            text-align: center;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Icon Header */
        .verify-header {
            margin-bottom: 32px;
        }

        .verify-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.25);
            margin-bottom: 24px;
            color: var(--accent-color);
            font-size: 24px;
        }

        .verify-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
            margin-bottom: 12px;
        }

        .verify-description {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Success Alert */
        .success-alert {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            text-align: left;
        }

        .success-icon {
            color: var(--success-color);
            font-size: 18px;
            margin-top: 2px;
        }

        .success-message {
            font-size: 13.5px;
            color: #a7f3d0;
            font-weight: 500;
            line-height: 1.4;
        }

        /* Action Form & Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 24px var(--accent-glow);
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px var(--accent-glow);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .logout-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition-smooth);
        }

        .logout-link:hover {
            color: var(--danger-color);
            text-decoration: underline;
        }

        /* Modal Popup Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(4, 8, 20, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            background: rgba(13, 20, 38, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 40px;
            max-width: 440px;
            width: 90%;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
            transform: scale(0.9);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .modal-overlay.active .modal-card {
            transform: scale(1);
        }

        .modal-badge {
            width: 72px;
            height: 72px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--success-color);
            font-size: 32px;
            margin-bottom: 24px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 16px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .modal-title {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            text-align: center;
        }

        .modal-message {
            font-size: 14.5px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 28px;
            text-align: center;
        }

        .btn-modal-close {
            background: var(--accent-gradient);
            border: none;
            color: #fff;
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14.5px;
            cursor: pointer;
            box-shadow: 0 8px 20px var(--accent-glow);
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-modal-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px var(--accent-glow);
        }
    </style>
</head>
<body>

    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <div class="auth-container">
        <!-- Icon Header -->
        <div class="verify-header">
            <a href="/" style="text-decoration: none; color: inherit; display: inline-block; cursor: pointer;">
                <div class="verify-icon">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
            </a>
            <h1 class="verify-title">Verify Your Email</h1>
            <p class="verify-description">
                Before proceeding, please check your email inbox for a verification link to confirm your account.
            </p>
        </div>

        <!-- Verification Link Sent Banner -->
        @if (session('resent'))
            <div class="success-alert">
                <i class="fa-solid fa-circle-check success-icon"></i>
                <div class="success-message">
                    A fresh verification link has been sent to the email address you registered with.
                </div>
            </div>
        @endif

        <!-- Action Form -->
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn-submit">
                <span>Resend Verification Email</span>
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>

        <!-- Logout Link -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a href="#" class="logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket"></i> Sign Out
        </a>
    </div>

    @if (session('new_registration'))
        <div class="modal-overlay active" id="welcomeModal">
            <div class="modal-card">
                <div class="modal-badge">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <h2 class="modal-title">Account Created!</h2>
                <p class="modal-message">
                    Welcome to Legals Forum! Your account has been registered successfully. We have sent a verification email to your address. Please check your inbox and click the activation link to verify your account.
                </p>
                <button type="button" class="btn-modal-close" onclick="closeWelcomeModal()">
                    <span>Got It, Thanks</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
        <script>
            function closeWelcomeModal() {
                const modal = document.getElementById('welcomeModal');
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.remove();
                }, 400);
            }
        </script>
    @endif

</body>
</html>
