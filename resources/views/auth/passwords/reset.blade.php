<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Set New Password | LawsGhana</title>
    
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
            --danger-color: #ef4444;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        html, body {
            overflow: hidden;
            height: 100vh;
        }

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
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
            max-width: 440px;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            z-index: 10;
            position: relative;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logo Area */
        .brand-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: var(--accent-gradient);
            box-shadow: 0 8px 24px var(--accent-glow);
            margin-bottom: 20px;
            color: #fff;
            font-size: 24px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
            margin-bottom: 6px;
        }

        .brand-tagline {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Form Group Styles */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            transition: var(--transition-smooth);
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 15px;
            outline: none;
            transition: var(--transition-smooth);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px var(--accent-glow);
            background: rgba(255, 255, 255, 0.06);
        }

        .form-control:focus + .input-icon {
            color: var(--accent-color);
        }

        /* Submit Button */
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
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px var(--accent-glow);
        }

        /* Error States */
        .error-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .error-icon {
            color: var(--danger-color);
            font-size: 18px;
            margin-top: 2px;
        }

        .error-message {
            font-size: 13px;
            color: #fca5a5;
            font-weight: 500;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <div class="auth-container">
        <!-- Logo Area -->
        <div class="brand-header">
            <a href="/" style="text-decoration: none; color: inherit; display: inline-block; cursor: pointer;">
                <div class="brand-logo">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
            </a>
            <h1 class="brand-name">Set New Password</h1>
            <p class="brand-tagline">Enter your new password below to update your account</p>
        </div>

        <!-- Error Alerts -->
        @if ($errors->any())
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation error-icon"></i>
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Reset Form -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">E-Mail Address</label>
                <div class="input-wrapper">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">New Password</label>
                <div class="input-wrapper">
                    <input id="password" type="password" class="form-control" name="password" placeholder="••••••••" required autocomplete="new-password" style="padding-right: 48px;">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('password', this)"></i>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password-confirm" class="form-label">Confirm New Password</label>
                <div class="input-wrapper">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" style="padding-right: 48px;">
                    <i class="fa-solid fa-circle-check input-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('password-confirm', this)"></i>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                <span>Update Password</span>
                <i class="fa-solid fa-rotate"></i>
            </button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(fieldId, icon) {
            const passwordField = document.getElementById(fieldId);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
