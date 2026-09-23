<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Two-Factor Authentication | Legals Forum Admin</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(239, 68, 68, 0.05) 0%, rgba(59, 130, 246, 0.08) 70%, transparent 100%);
            --card-bg: rgba(13, 20, 38, 0.7);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.35);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --danger-color: #ef4444;
            --success-color: #10b981;
            --transition-smooth: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
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

        .ambient-blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.09) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .ambient-blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.07) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .auth-container {
            width: 100%;
            max-width: 460px;
            z-index: 10;
            position: relative;
        }

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 38px 32px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.55);
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }

        /* Top decorative gradient */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #10b981);
        }

        .shield-badge {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, rgba(59, 130, 246, 0.03) 100%);
            border: 1px solid rgba(59, 130, 246, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px auto;
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.25);
            position: relative;
        }

        .shield-badge i {
            font-size: 28px;
            color: #60a5fa;
            filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.5));
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-title {
            font-size: 21px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .auth-desc {
            color: var(--text-secondary);
            font-size: 13.5px;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .masked-email-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 20px;
            font-size: 12px;
            color: #93c5fd;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .otp-inputs-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 24px 0 20px 0;
        }

        .otp-box {
            width: 52px;
            height: 60px;
            background: rgba(11, 15, 23, 0.7);
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            color: #ffffff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            outline: none;
            transition: var(--transition-smooth);
            caret-color: var(--accent-color);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .otp-box:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), inset 0 2px 4px rgba(0, 0, 0, 0.3);
            background: rgba(17, 24, 39, 0.9);
            transform: translateY(-2px);
        }

        .otp-box.filled {
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(30, 41, 59, 0.5);
        }

        .otp-divider {
            color: #4b5563;
            font-size: 18px;
            font-weight: 700;
            user-select: none;
        }

        .otp-box.has-error {
            border-color: var(--danger-color) !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2) !important;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-8px); }
            40%, 80% { transform: translateX(8px); }
        }

        .shake-animation {
            animation: shake 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
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
            box-shadow: 0 4px 14px var(--accent-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .submit-btn:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 6px 22px var(--accent-glow);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .timer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 18px 0;
            font-size: 12.5px;
            color: var(--text-secondary);
        }

        .timer-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #fbbf24;
            font-weight: 600;
        }

        .resend-btn {
            background: none;
            border: none;
            color: var(--accent-color);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            padding: 0;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .resend-btn:hover:not(:disabled) {
            color: #60a5fa;
            text-decoration: underline;
        }

        .resend-btn:disabled {
            color: #4b5563;
            cursor: not-allowed;
            text-decoration: none;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: var(--danger-color);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: var(--success-color);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.4;
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
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .auth-footer a:hover {
            color: var(--text-primary);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-card {
                padding: 28px 20px;
            }
            .otp-box {
                width: 44px;
                height: 52px;
                font-size: 20px;
            }
            .otp-inputs-container {
                gap: 6px;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <div class="auth-container">
        <div class="auth-card" id="authCard">
            
            <!-- Shield Badge -->
            <div class="shield-badge">
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <!-- Header -->
            <div class="auth-header">
                <h1 class="auth-title">Two-Factor Authentication</h1>
                <p class="auth-desc">Enter the 6-digit administrative security code sent to your email address:</p>
                <div class="masked-email-pill">
                    <i class="fa-solid fa-envelope"></i>
                    <span>{{ $maskedEmail }}</span>
                </div>
            </div>

            <!-- Status / Error Messages -->
            <div id="dynamic-alert-container">
                @if (session('success'))
                    <div class="alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif
            </div>

            <!-- 2FA Form -->
            <form id="otp-form" method="POST" action="{{ route('admin.login.2fa.verify') }}" onsubmit="submitOtpForm(event)">
                @csrf
                <input type="hidden" name="code" id="full-otp-input">

                <!-- 6 Digit Input Boxes -->
                <div class="otp-inputs-container" id="otp-boxes-group">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" id="pin-1" data-index="1" autofocus autocomplete="off">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" id="pin-2" data-index="2" autocomplete="off">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" id="pin-3" data-index="3" autocomplete="off">
                    <span class="otp-divider">&bull;</span>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" id="pin-4" data-index="4" autocomplete="off">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" id="pin-5" data-index="5" autocomplete="off">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" id="pin-6" data-index="6" autocomplete="off">
                </div>

                <!-- Timer & Resend Row -->
                <div class="timer-row">
                    <div class="timer-badge">
                        <i class="fa-regular fa-clock"></i>
                        <span>Expires: <strong id="countdown-timer">10:00</strong></span>
                    </div>
                    <div>
                        <button type="button" class="resend-btn" id="resend-btn" onclick="resendSecurityCode()" disabled>
                            <i class="fa-solid fa-rotate-right"></i>
                            <span id="resend-label">Resend in 60s</span>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" id="verify-submit-btn">
                    <span>Verify & Enter Dashboard</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            @if(app()->environment('local') && session('admin_2fa_dev_code'))
                <div style="margin-top: 20px; padding: 8px 12px; background: rgba(59, 130, 246, 0.08); border: 1px dashed rgba(59, 130, 246, 0.25); border-radius: 8px; font-size: 11px; color: #93c5fd; text-align: center;">
                    <i class="fa-solid fa-code"></i> Dev Mode OTP: <strong style="color: #60a5fa; letter-spacing: 2px;">{{ session('admin_2fa_dev_code') }}</strong>
                </div>
            @endif

            <!-- Footer: Return to Login -->
            <div class="auth-footer">
                <a href="{{ route('admin.login.cancel') }}">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Cancel and return to login</span>
                </a>
            </div>

        </div>
    </div>

    <script>
        const otpInputs = Array.from(document.querySelectorAll('.otp-box'));
        const fullOtpInput = document.getElementById('full-otp-input');
        const submitBtn = document.getElementById('verify-submit-btn');
        const authCard = document.getElementById('authCard');
        const alertContainer = document.getElementById('dynamic-alert-container');

        // Focus first box
        if (otpInputs[0]) {
            otpInputs[0].focus();
        }

        // Handle OTP input interactions
        otpInputs.forEach((input, index) => {
            // Typing input
            input.addEventListener('input', (e) => {
                const val = e.target.value.replace(/\D/g, '');
                e.target.value = val ? val[0] : '';

                if (val) {
                    input.classList.add('filled');
                    input.classList.remove('has-error');
                    // Move to next input if exists
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                        otpInputs[index + 1].select();
                    }
                } else {
                    input.classList.remove('filled');
                }

                syncFullCode();
            });

            // Keydown navigation (Backspace & Arrow keys)
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (!input.value && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        otpInputs[index - 1].classList.remove('filled');
                    }
                } else if (e.key === 'ArrowLeft' && index > 0) {
                    otpInputs[index - 1].focus();
                    otpInputs[index - 1].select();
                } else if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                    otpInputs[index + 1].select();
                }
            });

            // Paste event support (copies full 6 digits)
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                const cleanDigits = pasteData.replace(/\D/g, '').slice(0, 6);

                if (cleanDigits) {
                    cleanDigits.split('').forEach((char, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = char;
                            otpInputs[i].classList.add('filled');
                            otpInputs[i].classList.remove('has-error');
                        }
                    });

                    syncFullCode();

                    // If full 6 digits entered, auto-submit
                    if (cleanDigits.length === 6) {
                        otpInputs[5].focus();
                        submitOtpForm();
                    } else if (otpInputs[cleanDigits.length]) {
                        otpInputs[cleanDigits.length].focus();
                    }
                }
            });
        });

        function syncFullCode() {
            const code = otpInputs.map(input => input.value).join('');
            fullOtpInput.value = code;
            return code;
        }

        // Handle AJAX form submission for instant high-end feedback
        function submitOtpForm(event) {
            if (event) event.preventDefault();
            const code = syncFullCode();

            if (code.length < 6) {
                showErrorAlert('Please enter the complete 6-digit security code.');
                triggerShake();
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Authenticating...`;

            fetch("{{ route('admin.login.2fa.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(({ status, body }) => {
                if (status === 200 && body.success) {
                    submitBtn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                    submitBtn.innerHTML = `<i class="fa-solid fa-check"></i> Verified! Redirecting...`;
                    window.location.href = body.redirect || "{{ route('admin.dashboard') }}";
                } else {
                    showErrorAlert(body.message || 'The security code you entered is invalid or expired.');
                    triggerShake();
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = `<span>Verify & Enter Dashboard</span> <i class="fa-solid fa-arrow-right"></i>`;
                    // Highlight boxes red and clear
                    otpInputs.forEach(box => {
                        box.classList.add('has-error');
                        box.value = '';
                        box.classList.remove('filled');
                    });
                    otpInputs[0].focus();
                }
            })
            .catch(err => {
                console.error('2FA error:', err);
                // Fallback to standard form submission if fetch failed
                document.getElementById('otp-form').submit();
            });
        }

        function triggerShake() {
            authCard.classList.remove('shake-animation');
            void authCard.offsetWidth; // Reflow
            authCard.classList.add('shake-animation');
        }

        function showErrorAlert(msg) {
            alertContainer.innerHTML = `
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>${msg}</span>
                </div>
            `;
        }

        function showSuccessAlert(msg) {
            alertContainer.innerHTML = `
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>${msg}</span>
                </div>
            `;
        }

        // Live 10-minute expiry countdown timer
        let expirySeconds = {{ $remainingExpirySeconds ?? 600 }};
        const countdownTimerEl = document.getElementById('countdown-timer');

        function updateCountdown() {
            if (expirySeconds <= 0) {
                countdownTimerEl.textContent = 'Expired';
                countdownTimerEl.style.color = '#ef4444';
                showErrorAlert('Your security code has expired. Please request a new code.');
                return;
            }
            const mins = Math.floor(expirySeconds / 60);
            const secs = expirySeconds % 60;
            countdownTimerEl.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            expirySeconds--;
            setTimeout(updateCountdown, 1000);
        }
        updateCountdown();

        // 60-second Resend cooldown
        let resendCooldown = {{ $resendCooldownRemaining ?? 60 }};
        const resendBtn = document.getElementById('resend-btn');
        const resendLabel = document.getElementById('resend-label');

        function updateResendCooldown() {
            if (resendCooldown <= 0) {
                resendBtn.disabled = false;
                resendLabel.textContent = 'Resend Code';
                return;
            }
            resendBtn.disabled = true;
            resendLabel.textContent = `Resend in ${resendCooldown}s`;
            resendCooldown--;
            setTimeout(updateResendCooldown, 1000);
        }
        updateResendCooldown();

        // Resend Security Code via AJAX
        function resendSecurityCode() {
            resendBtn.disabled = true;
            resendLabel.textContent = 'Sending...';

            fetch("{{ route('admin.login.2fa.resend') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showSuccessAlert(data.message || 'A new security code has been sent to your email.');
                    // Reset expiry and resend timers
                    expirySeconds = 600;
                    resendCooldown = 60;
                    updateResendCooldown();
                    // Clear inputs
                    otpInputs.forEach(box => {
                        box.value = '';
                        box.classList.remove('filled', 'has-error');
                    });
                    otpInputs[0].focus();
                } else {
                    showErrorAlert(data.message || 'Could not resend security code. Please wait a moment.');
                    resendCooldown = data.cooldown || 30;
                    updateResendCooldown();
                }
            })
            .catch(err => {
                console.error('Resend error:', err);
                showErrorAlert('Connection error. Please try again.');
                resendCooldown = 15;
                updateResendCooldown();
            });
        }
    </script>
</body>
</html>
