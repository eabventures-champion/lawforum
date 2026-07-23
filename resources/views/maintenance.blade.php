<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance | {{ config('app.name', 'Legals Forum') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-deep: #050810;
            --bg-primary: #0b0f1a;
            --accent: #3b82f6;
            --accent-purple: #8b5cf6;
            --accent-glow: rgba(59, 130, 246, 0.3);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: rgba(255, 255, 255, 0.06);
            --glass: rgba(15, 23, 42, 0.6);
            --glass-border: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---- Animated Background ---- */
        .bg-canvas {
            position: fixed; inset: 0; z-index: 0; overflow: hidden;
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: orbFloat 20s ease-in-out infinite alternate;
        }
        .bg-orb:nth-child(1) {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.4), transparent 70%);
            top: -10%; left: -5%;
            animation-duration: 25s;
        }
        .bg-orb:nth-child(2) {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,0.35), transparent 70%);
            bottom: -10%; right: -5%;
            animation-duration: 30s; animation-delay: -5s;
        }
        .bg-orb:nth-child(3) {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(6,182,212,0.3), transparent 70%);
            top: 50%; left: 50%; transform: translate(-50%, -50%);
            animation-duration: 22s; animation-delay: -10s;
        }
        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(40px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 40px) scale(0.95); }
            100% { transform: translate(30px, -20px) scale(1.05); }
        }

        /* ---- Grid Pattern ---- */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.015) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        }

        /* ---- Floating Particles ---- */
        .particles {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
        }
        .particle {
            position: absolute;
            width: 3px; height: 3px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.5);
            animation: particleFloat linear infinite;
        }
        @keyframes particleFloat {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }

        /* ---- Main Container ---- */
        .maintenance-container {
            position: relative; z-index: 10;
            width: 100%; max-width: 960px;
            padding: 32px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        /* ---- Left: Info Panel ---- */
        .info-panel {
            animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .status-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 16px; border-radius: 24px;
            font-size: 11px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #f87171;
            margin-bottom: 24px;
        }
        .status-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #ef4444;
            animation: statusPulse 2s ease-in-out infinite;
        }
        @keyframes statusPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.5); }
            50% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        }

        .info-panel h1 {
            font-size: 36px; font-weight: 800; line-height: 1.2;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #f1f5f9 0%, #94a3b8 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .info-panel p {
            font-size: 15px; line-height: 1.8; color: var(--text-secondary);
            margin-bottom: 32px;
        }

        .gear-animation {
            display: flex; gap: 12px; align-items: center; margin-bottom: 32px;
        }
        .gear {
            font-size: 24px; color: var(--accent); opacity: 0.6;
            animation: gearSpin 4s linear infinite;
        }
        .gear:nth-child(2) { animation-direction: reverse; animation-duration: 3s; font-size: 18px; }
        .gear:nth-child(3) { animation-duration: 5s; font-size: 20px; }
        @keyframes gearSpin {
            to { transform: rotate(360deg); }
        }

        /* ---- Right: Chat + Passcode Panel ---- */
        .interactive-panel {
            animation: slideInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* ---- Chat Box ---- */
        .chat-box {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }
        .chat-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 12px;
        }
        .chat-avatar {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent-purple));
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: #fff;
        }
        .chat-header-text h4 {
            font-size: 13px; font-weight: 700; color: var(--text-primary);
        }
        .chat-header-text span {
            font-size: 11px; color: #10b981; font-weight: 500;
        }
        .chat-online-dot {
            width: 6px; height: 6px; border-radius: 50%; background: #10b981;
            display: inline-block; margin-right: 4px;
            animation: statusPulse 2s ease-in-out infinite;
        }

        .chat-messages {
            padding: 20px;
            height: 240px;
            overflow-y: auto;
            display: flex; flex-direction: column; gap: 12px;
        }
        .chat-messages::-webkit-scrollbar { width: 4px; }
        .chat-messages::-webkit-scrollbar-track { background: transparent; }
        .chat-messages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .chat-bubble {
            max-width: 85%;
            padding: 10px 16px;
            border-radius: 16px 16px 16px 4px;
            font-size: 13px; line-height: 1.6;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.12);
            color: var(--text-primary);
            opacity: 0; transform: translateY(10px);
            animation: bubbleIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes bubbleIn {
            to { opacity: 1; transform: translateY(0); }
        }

        .typing-indicator {
            display: flex; gap: 4px; padding: 10px 16px;
            background: rgba(59, 130, 246, 0.05);
            border: 1px solid rgba(59, 130, 246, 0.08);
            border-radius: 16px 16px 16px 4px;
            max-width: 70px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .typing-indicator.visible { opacity: 1; }
        .typing-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--accent); opacity: 0.4;
            animation: typingBounce 1.4s ease-in-out infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typingBounce {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
            30% { transform: translateY(-6px); opacity: 1; }
        }

        /* ---- Passcode Card ---- */
        .passcode-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            padding: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        .passcode-card h3 {
            font-size: 14px; font-weight: 700; color: var(--text-primary);
            margin-bottom: 4px;
        }
        .passcode-card .card-desc {
            font-size: 12px; color: var(--text-secondary); margin-bottom: 16px;
        }

        .passcode-input-group {
            display: flex; gap: 8px;
        }
        .passcode-input-wrapper {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
        }
        .passcode-input-wrapper .passcode-input {
            width: 100%;
            padding-right: 42px;
        }
        .toggle-password-btn {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 14px;
            padding: 4px 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
            outline: none !important;
        }
        .toggle-password-btn:hover {
            color: var(--text-primary);
        }
        .passcode-input {
            flex: 1; padding: 12px 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif; font-size: 14px;
            transition: all 0.3s;
            outline: none;
        }
        .passcode-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        .passcode-input::placeholder { color: rgba(255,255,255,0.2); }

        .unlock-btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--accent), var(--accent-purple));
            border: none; border-radius: 12px;
            color: #fff; font-family: 'Inter', sans-serif;
            font-size: 14px; font-weight: 600;
            cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.3s;
            white-space: nowrap;
        }
        .unlock-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        }
        .unlock-btn:active { transform: translateY(0); }

        .error-msg {
            margin-top: 12px; padding: 8px 14px;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.15);
            border-radius: 10px;
            font-size: 12px; color: #f87171;
            display: flex; align-items: center; gap: 8px;
            animation: shakeIn 0.4s ease;
        }
        @keyframes shakeIn {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-8px); }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }

        /* ---- Stats Panel ---- */
        .maint-stats {
            display: flex;
            gap: 24px;
            align-items: center;
        }
        .maint-stat-item {
            text-align: center;
        }
        .maint-stat-value {
            font-size: 28px;
            font-weight: 800;
        }
        .maint-stat-label {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 4px;
        }
        .maint-stats-divider {
            width: 1px;
            height: 40px;
            background: var(--border);
        }

        /* ---- Footer ---- */
        .maint-footer {
            position: fixed; bottom: 24px; left: 0; right: 0;
            text-align: center; z-index: 10;
            font-size: 12px; color: var(--text-secondary);
            opacity: 0.6;
        }

        /* ---- Responsive ---- */
        @media (max-width: 768px) {
            body {
                overflow-y: auto;
                overflow-x: hidden;
                height: auto;
                min-height: 100vh;
                padding: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
            }
            .maintenance-container {
                grid-template-columns: 1fr;
                gap: 28px;
                padding: 32px 20px 24px 20px;
                max-width: 100%;
                width: 100%;
                margin: 0 auto;
            }
            /* Center all info panel content */
            .info-panel {
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .info-panel h1 {
                font-size: 26px;
                word-break: break-word;
            }
            .info-panel p {
                font-size: 14px;
                line-height: 1.7;
                margin-bottom: 24px;
                max-width: 340px;
            }
            .gear-animation {
                margin-bottom: 20px;
                justify-content: center;
            }
            .gear {
                font-size: 20px !important;
            }
            .gear:nth-child(2) { font-size: 15px !important; }
            .gear:nth-child(3) { font-size: 17px !important; }
            .status-badge {
                font-size: 10px;
                padding: 5px 12px;
                margin-bottom: 16px;
            }
            .maint-stats {
                gap: 0;
                justify-content: center;
                width: 100%;
            }
            .maint-stat-item {
                flex: 1;
            }
            .maint-stats-divider {
                display: none;
            }
            .maint-stat-value {
                font-size: 22px;
            }
            .maint-stat-label {
                font-size: 10px;
            }
            /* Interactive panel full-width */
            .interactive-panel {
                width: 100%;
            }
            .chat-box {
                border-radius: 16px;
                margin-bottom: 16px;
            }
            .chat-messages {
                height: 180px;
                padding: 16px;
            }
            .chat-bubble {
                font-size: 12px;
                padding: 8px 14px;
            }
            .chat-header {
                padding: 12px 16px;
            }
            .chat-avatar {
                width: 32px; height: 32px;
                font-size: 14px;
            }
            .chat-header-text h4 {
                font-size: 12px;
            }
            .passcode-card {
                border-radius: 14px;
                padding: 20px 16px;
            }
            .passcode-card h3 {
                font-size: 13px;
            }
            .passcode-card .card-desc {
                font-size: 11px;
                margin-bottom: 12px;
            }
            .passcode-input-group {
                flex-direction: column;
                gap: 10px;
            }
            .passcode-input-wrapper {
                width: 100%;
            }
            .passcode-input {
                width: 100%;
                padding: 12px 14px;
                font-size: 14px;
            }
            .unlock-btn {
                width: 100%;
                justify-content: center;
                padding: 12px 20px;
                font-size: 14px;
            }
            /* Footer flows naturally below content */
            .maint-footer {
                position: relative;
                bottom: auto;
                left: auto;
                right: auto;
                width: 100%;
                text-align: center;
                padding: 24px 16px 32px 16px;
                opacity: 0.5;
            }
            /* Tame background orbs on mobile */
            .bg-orb:nth-child(1) { width: 280px; height: 280px; }
            .bg-orb:nth-child(2) { width: 220px; height: 220px; }
            .bg-orb:nth-child(3) { width: 160px; height: 160px; }
        }

        @media (max-width: 380px) {
            .maintenance-container {
                padding: 24px 14px 20px 14px;
            }
            .info-panel h1 {
                font-size: 22px;
            }
            .info-panel p {
                font-size: 13px;
            }
            .maint-stat-value {
                font-size: 18px;
            }
            .chat-messages {
                height: 150px;
            }
        }

        /* ---- Unlock Success Animation ---- */
        .unlock-success-overlay {
            position: fixed; inset: 0; z-index: 999;
            background: rgba(5, 8, 16, 0.9);
            display: flex; align-items: center; justify-content: center;
            flex-direction: column; gap: 16px;
            opacity: 0; pointer-events: none;
            transition: opacity 0.5s;
        }
        .unlock-success-overlay.active {
            opacity: 1; pointer-events: auto;
        }
        .unlock-icon-ring {
            width: 80px; height: 80px; border-radius: 50%;
            border: 3px solid var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; color: var(--accent);
            animation: ringPop 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes ringPop {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .unlock-success-text {
            font-size: 18px; font-weight: 700; color: var(--text-primary);
            animation: fadeInUp 0.5s 0.3s both;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Animated Background -->
    <div class="bg-canvas">
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
    </div>
    <div class="bg-grid"></div>

    <!-- Floating Particles -->
    <div class="particles" id="particles"></div>

    <!-- Main Content -->
    <div class="maintenance-container">
        <!-- Left: Info -->
        <div class="info-panel">
            <div class="status-badge">
                <span class="status-dot"></span>
                Under Maintenance
            </div>

            <div class="gear-animation">
                <i class="fa-solid fa-gear gear"></i>
                <i class="fa-solid fa-gear gear"></i>
                <i class="fa-solid fa-gear gear"></i>
            </div>

            <h1>{{ $title }}</h1>
            <p>{{ $subtitle }}</p>

            <div class="maint-stats">
                <div class="maint-stat-item">
                    <div class="maint-stat-value" style="color: var(--accent);" id="counterUptime">99.9</div>
                    <div class="maint-stat-label">Uptime %</div>
                </div>
                <div class="maint-stats-divider"></div>
                <div class="maint-stat-item">
                    <div class="maint-stat-value" style="color: var(--accent-purple);" id="counterSecurity">256</div>
                    <div class="maint-stat-label">Bit Encryption</div>
                </div>
                <div class="maint-stats-divider"></div>
                <div class="maint-stat-item">
                    <div class="maint-stat-value" style="color: #10b981;">24/7</div>
                    <div class="maint-stat-label">Support</div>
                </div>
            </div>
        </div>

        <!-- Right: Interactive Panel -->
        <div class="interactive-panel">
            <!-- Chat Dialogue -->
            <div class="chat-box">
                <div class="chat-header">
                    <div class="chat-avatar">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div class="chat-header-text">
                        <h4>System Assistant</h4>
                        <span><span class="chat-online-dot"></span> Online</span>
                    </div>
                </div>
                <div class="chat-messages" id="chatMessages">
                    <div class="typing-indicator" id="typingIndicator">
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                        <span class="typing-dot"></span>
                    </div>
                </div>
            </div>

            <!-- Passcode Card -->
            <div class="passcode-card">
                <h3><i class="fa-solid fa-key" style="color: var(--accent); margin-right: 8px;"></i>Authorized Access</h3>
                <p class="card-desc">Enter your access passcode to bypass maintenance and view the site.</p>

                <form method="POST" action="{{ route('maintenance.verify') }}" id="passcodeForm">
                    @csrf
                    <div class="passcode-input-group">
                        <div class="passcode-input-wrapper">
                            <input type="password" name="passcode" id="passcodeInput" class="passcode-input" placeholder="Enter passcode..." autocomplete="off" autofocus required>
                            <button type="button" class="toggle-password-btn" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="Toggle passcode visibility">
                                <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        <button type="submit" class="unlock-btn">
                            <i class="fa-solid fa-lock-open"></i> Unlock
                        </button>
                    </div>

                    @error('passcode')
                        <div class="error-msg">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </form>
            </div>
        </div>
    </div>

    <!-- Unlock Success Overlay -->
    <div class="unlock-success-overlay" id="successOverlay">
        <div class="unlock-icon-ring">
            <i class="fa-solid fa-check"></i>
        </div>
        <div class="unlock-success-text">Access Granted</div>
    </div>

    <!-- Footer -->
    <div class="maint-footer">
        &copy; {{ date('Y') }} {{ config('app.name', 'Legals Forum') }}. All rights reserved.
    </div>

    <script>
        // ---- Generate Particles ----
        (function() {
            const container = document.getElementById('particles');
            const count = 40;
            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = (8 + Math.random() * 12) + 's';
                p.style.animationDelay = (Math.random() * 10) + 's';
                p.style.width = p.style.height = (2 + Math.random() * 3) + 'px';
                p.style.background = `rgba(${59 + Math.random() * 80}, ${130 + Math.random() * 50}, ${246}, ${0.3 + Math.random() * 0.4})`;
                container.appendChild(p);
            }
        })();

        // ---- Chat Dialogue Animation ----
        (function() {
            const messages = @json($dialogueMessages);
            const chatContainer = document.getElementById('chatMessages');
            const typingIndicator = document.getElementById('typingIndicator');
            let index = 0;

            function showTyping() {
                typingIndicator.classList.add('visible');
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            function hideTyping() {
                typingIndicator.classList.remove('visible');
            }

            function addMessage(text) {
                hideTyping();
                const bubble = document.createElement('div');
                bubble.className = 'chat-bubble';
                bubble.textContent = text;
                chatContainer.insertBefore(bubble, typingIndicator);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            function playNextMessage() {
                if (index >= messages.length) {
                    // Loop after a pause
                    setTimeout(() => {
                        // Clear all bubbles and restart
                        const bubbles = chatContainer.querySelectorAll('.chat-bubble');
                        bubbles.forEach(b => b.remove());
                        index = 0;
                        playNextMessage();
                    }, 8000);
                    return;
                }

                showTyping();
                const delay = 1200 + Math.random() * 1000; // Simulate typing time
                setTimeout(() => {
                    addMessage(messages[index].text);
                    index++;
                    setTimeout(playNextMessage, 800);
                }, delay);
            }

            // Start after a brief initial delay
            setTimeout(playNextMessage, 1000);
        })();

        // ---- Form Submission with Success Animation ----
        document.getElementById('passcodeForm').addEventListener('submit', function(e) {
            // Only show animation if no errors — we let the form submit naturally
            // The server will redirect on success, so we just add a subtle loading state
            const btn = this.querySelector('.unlock-btn');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Verifying...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
        });

        // ---- Toggle Password Visibility ----
        function togglePasswordVisibility() {
            const input = document.getElementById('passcodeInput');
            const icon = document.getElementById('togglePasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
