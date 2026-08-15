<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Choose Plan | Legals Forum</title>
    
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
            --card-bg: rgba(13, 20, 38, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.3);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        html {
            overflow-x: hidden;
            overflow-y: auto;
        }

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 60px 20px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
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
            filter: blur(80px);
            z-index: 0;
            animation: float 20s ease-in-out infinite alternate;
            will-change: transform;
            transform: translate3d(0, 0, 0);
        }

        .ambient-blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 40vw;
            height: 40vw;
            background: rgba(236, 72, 153, 0.05);
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: float 25s ease-in-out infinite alternate-reverse;
            will-change: transform;
            transform: translate3d(0, 0, 0);
        }

        @keyframes float {
            0% { transform: translate3d(0, 0, 0) scale(1); }
            100% { transform: translate3d(50px, 50px, 0) scale(1.1); }
        }

        /* Glassmorphism Auth Container */
        .auth-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
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
            margin-bottom: 48px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: var(--accent-gradient);
            box-shadow: 0 8px 24px var(--accent-glow);
            margin-bottom: 16px;
            color: #fff;
            font-size: 22px;
        }

        .brand-name {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #fff;
            margin-bottom: 6px;
        }

        .brand-tagline {
            font-size: 15px;
            color: var(--text-secondary);
        }

        /* Plans Grid */
        .plans-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 768px) {
            .plans-grid {
                grid-template-columns: 1fr;
            }
        }

        .plan-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .plan-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.04);
        }
        
        .plan-card.demo:hover {
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
        }
        
        .plan-card.subscribe:hover {
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.1);
        }

        .plan-icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .plan-card.demo .plan-icon-wrapper {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .plan-card.subscribe .plan-icon-wrapper {
            background: rgba(245, 158, 11, 0.1);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .plan-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .plan-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .feature-list {
            list-style: none;
            margin-bottom: 32px;
            flex-grow: 1;
        }

        .feature-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .feature-list li i {
            color: var(--accent-color);
            margin-top: 3px;
            font-size: 12px;
        }
        
        .plan-card.subscribe .feature-list li i {
            color: #fbbf24;
        }

        /* Buttons */
        .btn {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            border: none;
        }

        .btn-primary {
            background: var(--accent-gradient);
            color: #fff;
            box-shadow: 0 8px 24px var(--accent-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px var(--accent-glow);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: not-allowed;
            position: relative;
        }
        
        .btn-outline:hover .tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: #1f2937;
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-smooth);
            margin-bottom: 10px;
            pointer-events: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: #1f2937 transparent transparent transparent;
        }

    </style>
</head>
<body>

    <div style="position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 0;">
        <div class="ambient-blob-1"></div>
        <div class="ambient-blob-2"></div>
    </div>

    <div class="auth-container">
        <!-- Logo Area -->
        <div class="brand-header">
            <a href="/" style="text-decoration: none; color: inherit; display: inline-block; cursor: pointer;">
                <div class="brand-logo">
                    <i class="fa fa-balance-scale"></i>
                </div>
            </a>
            <h1 class="brand-name">Welcome to Legals Forum!</h1>
            <p class="brand-tagline">Choose how you'd like to get started</p>
        </div>

        <div class="plans-grid">
            <!-- Demo Plan -->
            <div class="plan-card demo">
                <div class="plan-icon-wrapper">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h3 class="plan-title">Start Free Demo</h3>
                <p class="plan-subtitle">Full access for 60 days</p>
                
                <ul class="feature-list">
                    <li><i class="fa-solid fa-check"></i> <span>Access all sections & content</span></li>
                    <li><i class="fa-solid fa-check"></i> <span>Download legal books</span></li>
                    <li><i class="fa-solid fa-check"></i> <span>Search case laws</span></li>
                    <li><i class="fa-solid fa-check"></i> <span>15-day extension available</span></li>
                </ul>

                <form method="POST" action="/register/activate-demo">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        Continue with Demo
                    </button>
                </form>
            </div>

            <!-- Subscribe Plan -->
            <div class="plan-card subscribe">
                <div class="plan-icon-wrapper">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <h3 class="plan-title">Subscribe Now</h3>
                <p class="plan-subtitle">Unlimited premium access</p>
                
                <ul class="feature-list">
                    <li><i class="fa-solid fa-check"></i> <span>Everything in Demo</span></li>
                    <li><i class="fa-solid fa-check"></i> <span>No time restrictions</span></li>
                    <li><i class="fa-solid fa-check"></i> <span>Priority support</span></li>
                    <li><i class="fa-solid fa-check"></i> <span>Early access to new features</span></li>
                </ul>

                <button type="button" class="btn btn-outline" disabled>
                    Coming Soon
                    <div class="tooltip">Subscription plans coming soon</div>
                </button>
            </div>
        </div>
    </div>

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
