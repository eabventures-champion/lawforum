@guest
{{-- ====== REUSABLE LOGIN MODAL COMPONENT ====== --}}
<style>
    .login-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 2147483646;
        background: rgba(4, 8, 20, 0.85);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.35s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.35s ease;
        box-sizing: border-box;
    }

    .login-modal-backdrop.active {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    .login-modal-card {
        background: #0c1322;
        background: linear-gradient(180deg, #0f182c 0%, #090e1a 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 24px;
        max-width: 440px;
        width: 100%;
        padding: 38px 34px;
        box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.9), 0 0 50px rgba(59, 130, 246, 0.18);
        position: relative;
        transform: translateY(20px) scale(0.96);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        color: #f3f4f6;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        box-sizing: border-box;
    }

    .login-modal-backdrop.active .login-modal-card {
        transform: translateY(0) scale(1);
    }

    .login-modal-close {
        position: absolute;
        top: 18px;
        right: 18px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: #94a3b8;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 15px;
        padding: 0;
    }

    .login-modal-close:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.4);
        transform: rotate(90deg);
    }

    .login-modal-header {
        text-align: center;
        margin-bottom: 26px;
    }

    .login-modal-logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.35);
        margin-bottom: 16px;
        color: #fff;
        font-size: 22px;
    }

    .login-modal-title {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.4px;
        color: #ffffff;
        margin: 0 0 6px 0;
        line-height: 1.2;
    }

    .login-modal-subtitle {
        font-size: 13.5px;
        color: #94a3b8;
        margin: 0;
        line-height: 1.4;
    }

    /* Alerts */
    .login-modal-error {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #fca5a5;
        font-size: 13px;
        line-height: 1.4;
        animation: modalShake 0.4s ease;
    }

    .login-modal-error-icon {
        color: #ef4444;
        font-size: 16px;
        margin-top: 1px;
        flex-shrink: 0;
    }

    .login-modal-success {
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #6ee7b7;
        font-size: 13px;
    }

    @keyframes modalShake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-6px); }
        40%, 80% { transform: translateX(6px); }
    }

    /* Form Elements */
    .login-form-group {
        margin-bottom: 18px;
        text-align: left;
    }

    .login-label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .login-form-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .login-label-row .login-form-label {
        margin-bottom: 0;
    }

    .login-forgot-link {
        color: #60a5fa;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .login-forgot-link:hover {
        color: #93c5fd;
        text-decoration: underline;
    }

    .login-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .login-input-icon {
        position: absolute;
        left: 15px;
        color: #64748b;
        font-size: 15px;
        pointer-events: none;
        transition: color 0.2s ease;
    }

    .login-form-control {
        width: 100%;
        height: 48px;
        padding: 12px 16px 12px 44px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #ffffff;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        transition: all 0.25s ease;
    }

    .login-form-control:focus {
        border-color: #3b82f6;
        background: rgba(255, 255, 255, 0.07);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
    }

    .login-form-control:focus ~ .login-input-icon,
    .login-input-wrapper:focus-within .login-input-icon {
        color: #3b82f6;
    }

    .login-password-toggle {
        position: absolute;
        right: 14px;
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: color 0.2s ease;
    }

    .login-password-toggle:hover {
        color: #cbd5e1;
    }

    .login-options-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .login-remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: #94a3b8;
        font-size: 13px;
        user-select: none;
    }

    .login-remember-checkbox {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.05);
        cursor: pointer;
        accent-color: #3b82f6;
    }

    .login-btn-submit {
        width: 100%;
        height: 48px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        border-radius: 12px;
        color: #ffffff;
        font-size: 14.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-sizing: border-box;
    }

    .login-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(59, 130, 246, 0.45);
        filter: brightness(1.08);
    }

    .login-btn-submit:active {
        transform: translateY(0);
    }

    .login-btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }

    .login-modal-footer {
        text-align: center;
        margin-top: 22px;
        font-size: 13.5px;
        color: #94a3b8;
    }

    .login-signup-link {
        color: #60a5fa;
        font-weight: 600;
        text-decoration: none;
        margin-left: 4px;
        transition: color 0.2s ease;
    }

    .login-signup-link:hover {
        color: #93c5fd;
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .login-modal-card {
            padding: 30px 20px;
            border-radius: 20px;
        }
        .login-modal-title {
            font-size: 20px;
        }
    }
</style>

<!-- Login Modal Overlay -->
<div class="login-modal-backdrop" id="loginModalBackdrop" onclick="if(event.target === this) closeLoginModal();">
    <div class="login-modal-card" role="dialog" aria-modal="true" aria-labelledby="loginModalTitle">
        <!-- Close Button -->
        <button type="button" class="login-modal-close" onclick="closeLoginModal()" aria-label="Close modal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Brand Header -->
        <div class="login-modal-header">
            <div class="login-modal-logo">
                <i class="fa fa-balance-scale"></i>
            </div>
            <h2 class="login-modal-title" id="loginModalTitle">Welcome Back</h2>
            <p class="login-modal-subtitle">Sign in to access your Legals Forum account</p>
        </div>

        <!-- Dynamic Error Alert -->
        <div class="login-modal-error" id="loginModalError" style="display: none;">
            <i class="fa-solid fa-circle-exclamation login-modal-error-icon"></i>
            <span id="loginModalErrorMessage"></span>
        </div>

        <!-- Dynamic Success Alert -->
        <div class="login-modal-success" id="loginModalSuccess" style="display: none;">
            <i class="fa-solid fa-circle-check"></i>
            <span>Login successful! Refreshing...</span>
        </div>

        <!-- Login Form -->
        <form id="ajaxLoginForm" method="POST" action="{{ route('login') }}" onsubmit="handleAjaxLogin(event)">
            @csrf

            <!-- Email Address -->
            <div class="login-form-group">
                <label for="modalEmail" class="login-form-label">E-Mail Address</label>
                <div class="login-input-wrapper">
                    <i class="fa-solid fa-envelope login-input-icon"></i>
                    <input id="modalEmail" type="email" class="login-form-control" name="email" placeholder="name@example.com" required autocomplete="email">
                </div>
            </div>

            <!-- Password -->
            <div class="login-form-group">
                <div class="login-label-row">
                    <label for="modalPassword" class="login-form-label">Password</label>
                    @if (Route::has('password.request'))
                        <a class="login-forgot-link" href="{{ route('password.request') }}">
                            Forgot?
                        </a>
                    @endif
                </div>
                <div class="login-input-wrapper">
                    <i class="fa-solid fa-lock login-input-icon"></i>
                    <input id="modalPassword" type="password" class="login-form-control" name="password" placeholder="••••••••" required autocomplete="current-password" style="padding-right: 44px;">
                    <button type="button" class="login-password-toggle" onclick="toggleModalPassword()" aria-label="Toggle password visibility">
                        <i class="fa-solid fa-eye" id="modalPasswordToggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="login-options-row">
                <label class="login-remember-me" for="modalRemember">
                    <input class="login-remember-checkbox" type="checkbox" name="remember" id="modalRemember">
                    <span>Remember Me</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="login-btn-submit" id="loginSubmitBtn">
                <span id="loginBtnText">Sign In</span>
                <i class="fa-solid fa-arrow-right" id="loginBtnIcon"></i>
                <i class="fa-solid fa-circle-notch fa-spin" id="loginBtnSpinner" style="display: none;"></i>
            </button>
        </form>

        <div class="login-modal-footer">
            <span>Don't have an account?</span>
            <a href="javascript:void(0)" onclick="openSignUpOptionsModal()" class="login-signup-link" style="cursor: pointer;">Sign Up Free</a>
        </div>
    </div>
</div>

<script>
    function ensureLoginModalInBody() {
        try {
            const backdrops = document.querySelectorAll('#loginModalBackdrop');
            if (backdrops.length > 1) {
                for (let i = 1; i < backdrops.length; i++) {
                    backdrops[i].remove();
                }
            }
            const backdrop = document.getElementById('loginModalBackdrop');
            if (backdrop && backdrop.parentNode !== document.body) {
                document.body.appendChild(backdrop);
            }
        } catch(e) {}
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ensureLoginModalInBody);
    } else {
        ensureLoginModalInBody();
    }

    if (typeof $ !== 'undefined') {
        $(document).ajaxComplete(function() {
            ensureLoginModalInBody();
        });
    }

    // Global Login Modal Controller
    window.openLoginModal = function() {
        if (window.top && window.top !== window && typeof window.top.openLoginModal === 'function') {
            window.top.openLoginModal();
            return;
        }
        if (window.parent && window.parent !== window && typeof window.parent.openLoginModal === 'function') {
            window.parent.openLoginModal();
            return;
        }

        ensureLoginModalInBody();

        const backdrop = document.getElementById('loginModalBackdrop');
        if (backdrop) {
            if (backdrop.parentNode !== document.body) {
                document.body.appendChild(backdrop);
            }
            backdrop.classList.add('active');
            // Clear prior errors
            const errEl = document.getElementById('loginModalError');
            if (errEl) errEl.style.display = 'none';
            const succEl = document.getElementById('loginModalSuccess');
            if (succEl) succEl.style.display = 'none';
            
            // Close mobile navigation drawer if open
            const mobileNav = document.getElementById('mobileNav');
            if (mobileNav) mobileNav.classList.remove('open');

            // Focus email input smoothly
            setTimeout(function() {
                const emailInput = document.getElementById('modalEmail');
                if (emailInput) emailInput.focus();
            }, 150);
        }
    };

    window.closeLoginModal = function() {
        if (window.top && window.top !== window && typeof window.top.closeLoginModal === 'function') {
            window.top.closeLoginModal();
        }
        if (window.parent && window.parent !== window && typeof window.parent.closeLoginModal === 'function') {
            window.parent.closeLoginModal();
        }
        const backdrop = document.getElementById('loginModalBackdrop');
        if (backdrop) {
            backdrop.classList.remove('active');
        }
    };

    window.openSignUpOptionsModal = function(title, message) {
        if (window.top && window.top !== window && typeof window.top.openSignUpOptionsModal === 'function') {
            window.top.openSignUpOptionsModal(title, message);
            return;
        }
        if (window.parent && window.parent !== window && typeof window.parent.openSignUpOptionsModal === 'function') {
            window.parent.openSignUpOptionsModal(title, message);
            return;
        }

        window.closeLoginModal();
        const modalTitle = title || 'Create an Account of Your Choice';
        const modalDesc = message || 'Please select your preferred account type below to create an account and enjoy full access tailored to your legal needs.';
        if (typeof window.openPremiumGateModal === 'function') {
            window.openPremiumGateModal(modalTitle, modalDesc, false, true);
        } else {
            window.location.href = '/get-started';
        }
    };

    window.toggleModalPassword = function() {
        const passwordInput = document.getElementById('modalPassword');
        const icon = document.getElementById('modalPasswordToggleIcon');
        if (!passwordInput || !icon) return;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    };

    window.handleAjaxLogin = function(e) {
        e.preventDefault();
        const form = document.getElementById('ajaxLoginForm');
        const submitBtn = document.getElementById('loginSubmitBtn');
        const btnText = document.getElementById('loginBtnText');
        const btnIcon = document.getElementById('loginBtnIcon');
        const btnSpinner = document.getElementById('loginBtnSpinner');
        const errorBox = document.getElementById('loginModalError');
        const errorMsg = document.getElementById('loginModalErrorMessage');
        const successBox = document.getElementById('loginModalSuccess');

        if (!form) return;

        // Reset states
        if (errorBox) errorBox.style.display = 'none';
        if (successBox) successBox.style.display = 'none';

        // Set Loading state
        if (submitBtn) submitBtn.disabled = true;
        if (btnText) btnText.textContent = 'Signing in...';
        if (btnIcon) btnIcon.style.display = 'none';
        if (btnSpinner) btnSpinner.style.display = 'inline-block';

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': formData.get('_token') || ''
            }
        })
        .then(async function(response) {
            if (response.ok || response.status === 200 || response.status === 204 || response.redirected) {
                if (successBox) successBox.style.display = 'flex';
                if (btnText) btnText.textContent = 'Success!';
                if (btnSpinner) btnSpinner.style.display = 'none';
                if (btnIcon) {
                    btnIcon.className = 'fa-solid fa-check';
                    btnIcon.style.display = 'inline-block';
                }
                
                // Reload current page or redirect to /
                setTimeout(function() {
                    window.location.reload();
                }, 700);
            } else if (response.status === 422) {
                const data = await response.json();
                let message = 'The provided credentials do not match our records.';
                if (data && data.errors) {
                    const firstKey = Object.keys(data.errors)[0];
                    if (firstKey && data.errors[firstKey] && data.errors[firstKey][0]) {
                        message = data.errors[firstKey][0];
                    }
                } else if (data && data.message) {
                    message = data.message;
                }
                showLoginError(message);
            } else if (response.status === 419) {
                showLoginError('Session expired. Page is reloading...');
                setTimeout(function() { window.location.reload(); }, 1200);
            } else {
                showLoginError('An unexpected error occurred. Please try again.');
            }
        })
        .catch(function(err) {
            console.error('Login error:', err);
            // Fallback: Submit form natively
            form.submit();
        })
        .finally(function() {
            if (submitBtn && (!successBox || successBox.style.display === 'none')) {
                submitBtn.disabled = false;
                if (btnText) btnText.textContent = 'Sign In';
                if (btnIcon) {
                    btnIcon.className = 'fa-solid fa-arrow-right';
                    btnIcon.style.display = 'inline-block';
                }
                if (btnSpinner) btnSpinner.style.display = 'none';
            }
        });

        function showLoginError(msg) {
            if (errorMsg) errorMsg.textContent = msg;
            if (errorBox) errorBox.style.display = 'flex';
            if (submitBtn) {
                submitBtn.disabled = false;
                if (btnText) btnText.textContent = 'Sign In';
                if (btnIcon) {
                    btnIcon.className = 'fa-solid fa-arrow-right';
                    btnIcon.style.display = 'inline-block';
                }
                if (btnSpinner) btnSpinner.style.display = 'none';
            }
        }
    };

    // Close on Escape key press
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            closeLoginModal();
        }
    });

    // Global click listener to intercept any link/button containing "Guest User"
    document.addEventListener('click', function(e) {
        const guestTarget = e.target.closest('a, button, .mobile-user-role-badge, .btn-signup');
        if (guestTarget && guestTarget.textContent && guestTarget.textContent.toLowerCase().includes('guest user')) {
            e.preventDefault();
            e.stopPropagation();
            window.openLoginModal();
        }
    }, true);
</script>
@endguest
