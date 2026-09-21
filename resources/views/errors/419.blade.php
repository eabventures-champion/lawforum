<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Page Expired | Legals Forum</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            --card-bg: rgba(13, 20, 38, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.35);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --warning-color: #f59e0b;
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
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Blobs */
        .ambient-blob-1 {
            position: absolute;
            top: -15%;
            left: -15%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
            pointer-events: none;
        }

        .ambient-blob-2 {
            position: absolute;
            bottom: -15%;
            right: -15%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
            pointer-events: none;
        }

        .error-card-container {
            width: 100%;
            max-width: 520px;
            position: relative;
            z-index: 1;
        }

        .error-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 42px 36px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Icon Badge */
        .error-icon-wrap {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px auto;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.2) 100%);
            border: 1px solid rgba(245, 158, 11, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--warning-color);
            font-size: 34px;
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.2);
            animation: pulse-glow 3s infinite alternate ease-in-out;
        }

        @keyframes pulse-glow {
            0% { box-shadow: 0 8px 20px rgba(245, 158, 11, 0.15); transform: scale(1); }
            100% { box-shadow: 0 14px 30px rgba(245, 158, 11, 0.35); transform: scale(1.03); }
        }

        /* Tag */
        .error-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 100px;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .error-title {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
            line-height: 1.25;
        }

        .error-desc {
            color: var(--text-secondary);
            font-size: 14.5px;
            line-height: 1.6;
            margin-bottom: 28px;
            padding: 0 8px;
        }

        /* Action Buttons */
        .error-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 6px 20px var(--accent-glow);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--accent-glow);
        }

        .btn-secondary-row {
            display: flex;
            gap: 10px;
        }

        .btn-secondary {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 18px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: #e2e8f0;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        /* Security Note */
        .security-note {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            font-size: 12px;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        @media (max-width: 480px) {
            .error-card {
                padding: 32px 20px;
                border-radius: 20px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-desc {
                font-size: 13.5px;
                padding: 0;
            }

            .btn-secondary-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <div class="error-card-container">
        <div class="error-card">
            <!-- Icon -->
            <div class="error-icon-wrap">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>

            <!-- Tag & Code -->
            <div class="error-tag">
                <i class="fa-solid fa-shield-halved"></i> 419 • Page Expired
            </div>

            <!-- Title & Explanation -->
            <h1 class="error-title">Your Session Timed Out</h1>
            <p class="error-desc">
                For your security, forms and pages expire after a period of inactivity. This protects your account and ensures form submissions are authentic.
            </p>

            <!-- Action Buttons -->
            <div class="error-actions">
                <button type="button" onclick="handleRetry()" class="btn-primary">
                    <i class="fa-solid fa-rotate-right"></i>
                    <span>Refresh & Try Again</span>
                </button>

                <div class="btn-secondary-row">
                    <a href="{{ route('login') }}" class="btn-secondary">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Sign In</span>
                    </a>
                    <a href="{{ url('/') }}" class="btn-secondary">
                        <i class="fa-solid fa-house"></i>
                        <span>Homepage</span>
                    </a>
                </div>
            </div>

            <!-- Security Note -->
            <div class="security-note">
                <i class="fa-solid fa-lock"></i>
                <span>Protected by Legals Forum CSRF Security</span>
            </div>
        </div>
    </div>

    <script>
        function handleRetry() {
            if (document.referrer && document.referrer !== window.location.href) {
                window.location.href = document.referrer;
            } else {
                window.location.reload();
            }
        }
    </script>
</body>
</html>
