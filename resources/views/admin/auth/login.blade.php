<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administration Login | Legals Forum</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.05) 0%, rgba(59, 130, 246, 0.08) 70%, transparent 100%);
            --card-bg: rgba(13, 20, 38, 0.6);
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

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient background blobs */
        .ambient-blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 40vw;
            height: 40vw;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .ambient-blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.05) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            z-index: 10;
            position: relative;
        }

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            transition: var(--transition-smooth);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 16px;
        }

        .auth-logo-text {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #4b5563;
            font-size: 16px;
            transition: var(--transition-smooth);
        }

        .form-input {
            width: 100%;
            background: rgba(11, 15, 23, 0.6) !important;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 16px 14px 48px;
            color: var(--text-primary);
            font-size: 15px;
            transition: var(--transition-smooth);
            outline: none;
        }

        .form-input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .form-input:focus + .input-icon {
            color: var(--accent-color);
        }

        .toggle-password:hover {
            color: #ffffff !important;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-secondary);
            user-select: none;
        }

        .remember-me input {
            cursor: pointer;
            accent-color: var(--accent-color);
            width: 16px;
            height: 16px;
        }

        .submit-btn {
            width: 100%;
            background: var(--accent-gradient);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 12px var(--accent-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--accent-glow);
        }

        .submit-btn:active {
            transform: translateY(1px);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--danger-color);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
        }

        .auth-footer a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .auth-footer a:hover {
            color: var(--text-primary);
        }
    </style>
</head>
<body>

    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="auth-logo">
                    <i class="fa fa-balance-scale fa-lg" style="color: var(--accent-color);"></i>
                    <span class="auth-logo-text">Legals Forum</span>
                </a>
                <div class="auth-subtitle">Administration Portal</div>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Admin Email Address</label>
                    <div class="input-wrapper">
                        <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@admin.com">
                        <i class="fa-solid fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Security Password</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" class="form-input" name="password" required autocomplete="current-password" placeholder="••••••••" style="padding-right: 48px;">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('password', this)" title="Toggle password visibility"></i>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember session</span>
                    </label>
                </div>

                <button type="submit" class="submit-btn">
                    <span>Authenticate Admin</span>
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>

            <div class="auth-footer">
                <a href="/"><i class="fa-solid fa-arrow-left mr-1"></i> Return to Homepage</a>
            </div>
        </div>
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
