{{-- Master Navigation Header CSS Styles (Standardized based on Constitution view) --}}
<style>
    /* ============================================
       PREMIUM FIXED NAVIGATION BAR (MASTER STANDARD)
       ============================================ */
    /* Font-family isolation to prevent font changes from loaded articles */
    .nav-wrap,
    .nav-wrap *,
    .nav-menu-links-premium,
    .nav-menu-links-premium *,
    .nav-link-btn,
    .nav-link-btn *,
    .nav-dropdown-menu,
    .nav-dropdown-menu a,
    .continent-nav-wrap,
    .continent-nav-wrap * {
        font-family: var(--font, 'Inter', -apple-system, BlinkMacSystemFont, sans-serif) !important;
    }
    .nav-wrap i.fa,
    .nav-wrap i.fa-solid,
    .nav-wrap i.fa-regular {
        font-family: 'Font Awesome 6 Free' !important;
        font-weight: 900 !important;
    }

    body.has-scrollable-wrapper {
        height: 100vh !important;
        min-height: 100vh !important;
        overflow: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .main-wrapper-scrollable {
        position: fixed !important;
        top: 70px !important;
        left: 0 !important;
        width: 100% !important;
        height: calc(100vh - 70px) !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    .nav-wrap {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 70px !important;
        z-index: 1000;
        background: rgba(6, 10, 19, 0.88) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border-color, rgba(255, 255, 255, 0.08)) !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box !important;
    }

    .nav-inner {
        max-width: 1280px !important;
        margin: 0 auto !important;
        padding: 0 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        line-height: 1 !important;
        height: 70px !important;
        box-sizing: border-box !important;
    }

    .workspace-wrapper {
        top: 70px !important;
        height: calc(100vh - 70px) !important;
    }

    .nav-logo,
    .nav-logo:hover,
    .nav-logo:focus,
    .nav-logo:active,
    .nav-logo:visited {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        text-decoration: none !important;
        transition: transform 0.3s ease;
    }

    .nav-logo:hover,
    .nav-logo:focus,
    .nav-logo:active {
        transform: scale(1.03);
        text-decoration: none !important;
    }

    .nav-logo *,
    .nav-logo-text {
        text-decoration: none !important;
    }

    .nav-logo img {
        height: 38px !important;
        width: auto !important;
        transition: transform 0.3s ease;
    }

    .nav-logo i {
        font-size: 22px !important;
        color: #3b82f6 !important;
        margin: 0 !important;
        line-height: 1 !important;
    }

    .nav-logo-text {
        display: inline-block !important;
        font-size: 22px !important;
        font-weight: 800 !important;
        letter-spacing: 0.5px !important;
        background: linear-gradient(to right, #3b82f6, #60a5fa) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        font-family: 'Inter', sans-serif !important;
        margin: 0 !important;
        line-height: 1.3 !important;
    }

    .nav-menu-links-premium {
        display: flex !important;
        align-items: center !important;
        gap: 4px !important;
    }

    .nav-link-dropdown {
        position: relative !important;
    }

    .nav-link-btn {
        font-size: 14px !important;
        font-weight: 500 !important;
        color: var(--text-secondary, #94a3b8) !important;
        padding: 8px 14px !important;
        border-radius: 8px !important;
        background: transparent !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        text-decoration: none !important;
    }

    .nav-link-btn:hover {
        color: var(--text-primary, #f8fafc) !important;
        background: rgba(255, 255, 255, 0.05) !important;
    }

    .nav-link-btn.active,
    .nav-link-dropdown.active > .nav-link-btn {
        color: #ffffff !important;
        background: rgba(59, 130, 246, 0.15) !important;
        border: 1px solid rgba(59, 130, 246, 0.3) !important;
        font-weight: 600 !important;
        box-shadow: 0 0 12px rgba(59, 130, 246, 0.2) !important;
    }

    .nav-link-btn.active i,
    .nav-link-dropdown.active > .nav-link-btn i {
        color: var(--accent-light, #60a5fa) !important;
    }

    .nav-dropdown-menu a.active {
        color: var(--accent-light, #60a5fa) !important;
        background: rgba(59, 130, 246, 0.12) !important;
        font-weight: 600 !important;
    }

    .nav-link-btn i {
        font-size: 10px !important;
        color: var(--text-muted, #64748b) !important;
    }

    .nav-dropdown-menu {
        position: absolute !important;
        top: calc(100% + 8px) !important;
        left: 0 !important;
        min-width: 220px !important;
        background: rgba(17, 24, 39, 0.95) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08)) !important;
        border-radius: 12px !important;
        padding: 8px !important;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease !important;
        z-index: 100 !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5) !important;
    }

    .nav-link-dropdown:hover .nav-dropdown-menu {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }

    .nav-dropdown-menu a {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        padding: 10px 14px !important;
        border-radius: 8px !important;
        font-size: 14px !important;
        color: var(--text-secondary, #94a3b8) !important;
        transition: all 0.2s ease !important;
        text-align: left !important;
        text-decoration: none !important;
    }

    .nav-dropdown-menu a:hover {
        color: var(--text-primary, #f8fafc) !important;
        background: rgba(255, 255, 255, 0.06) !important;
    }

    .nav-dropdown-divider {
        height: 1px !important;
        background: var(--border-color, rgba(255, 255, 255, 0.08)) !important;
        margin: 6px 0 !important;
    }

    .nav-auth {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }

    .btn-login {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: var(--text-primary, #f8fafc) !important;
        padding: 8px 18px !important;
        border-radius: 8px !important;
        border: 1px solid var(--border-hover, rgba(255, 255, 255, 0.15)) !important;
        background: transparent !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .btn-login:hover {
        background: rgba(255, 255, 255, 0.06) !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
        color: var(--text-primary, #f8fafc) !important;
        text-decoration: none !important;
    }

    .btn-signup {
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #fff !important;
        padding: 8px 18px !important;
        border-radius: 8px !important;
        border: none !important;
        background: var(--accent-gradient, linear-gradient(135deg, #3b82f6, #2563eb)) !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px var(--accent-glow, rgba(59, 130, 246, 0.3)) !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .btn-signup:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 18px var(--accent-glow, rgba(59, 130, 246, 0.3)) !important;
        color: #fff !important;
        text-decoration: none !important;
    }

    .nav-user-dropdown {
        position: relative !important;
    }

    .nav-user-btn {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        padding: 8px 14px !important;
        border-radius: 8px !important;
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08)) !important;
        background: var(--card-bg, rgba(15, 23, 42, 0.6)) !important;
        color: var(--text-primary, #f8fafc) !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
    }

    .nav-user-btn:hover {
        background: var(--card-bg-hover, rgba(30, 41, 59, 0.8)) !important;
    }

    .nav-user-btn i {
        color: var(--accent-light, #60a5fa) !important;
    }

    .nav-user-dropdown:hover .nav-dropdown-menu,
    .nav-user-dropdown.active .nav-dropdown-menu {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
    }

    .nav-dropdown-menu a.logout-link {
        color: #f43f5e !important;
    }

    .nav-dropdown-menu a.logout-link:hover {
        background: rgba(244, 63, 94, 0.1) !important;
    }

    .nav-mobile-toggle {
        display: none;
        background: none !important;
        border: none !important;
        color: var(--text-primary, #f8fafc) !important;
        font-size: 22px !important;
        cursor: pointer !important;
        padding: 8px !important;
    }

    .mobile-nav-panel {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background: rgba(6, 10, 19, 0.98) !important;
        backdrop-filter: blur(25px) !important;
        -webkit-backdrop-filter: blur(25px) !important;
        z-index: 999999 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 16px !important;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.4s;
    }

    .mobile-nav-panel.open {
        opacity: 1 !important;
        visibility: visible !important;
    }

    .mobile-nav-panel a {
        font-size: 22px !important;
        font-weight: 600 !important;
        color: var(--text-secondary, #94a3b8) !important;
        padding: 12px 24px !important;
        border-radius: 12px !important;
        line-height: 1.5 !important;
        transform: translateY(24px);
        opacity: 0;
        transition: all 0.3s ease, transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
        text-decoration: none !important;
    }

    .mobile-nav-panel.open a {
        transform: translateY(0) !important;
        opacity: 1 !important;
    }

    .mobile-nav-close {
        position: absolute !important;
        top: 24px !important;
        right: 24px !important;
        background: none !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 1 !important;
        color: var(--text-primary, #f8fafc) !important;
        font-size: 28px !important;
        cursor: pointer !important;
        opacity: 0;
        transform: rotate(-90deg) scale(0.5);
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.25s;
        box-shadow: none !important;
        outline: none !important;
        width: 28px !important;
        height: 28px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .mobile-nav-panel.open .mobile-nav-close {
        opacity: 1 !important;
        transform: rotate(0) scale(1) !important;
    }

    @media (max-width: 991px) {
        .nav-inner { padding: 0 20px !important; }
        .nav-menu-links-premium { display: none !important; }
        .nav-mobile-toggle { display: block !important; }
        .nav-auth { display: none !important; }
        .nav-underline-premium { top: 70px !important; }
    }

    @media (max-width: 768px) {
        .nav-logo i {
            font-size: 18px !important;
        }
        .nav-logo-text {
            font-size: 18px !important;
            letter-spacing: 0.2px !important;
        }
    }
</style>
