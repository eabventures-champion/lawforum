{{-- Mobile Sidebar Drawer CSS & JS --}}
<style>
    /* Floating toggle button on left edge for mobile */
    .mobile-sidebar-toggle-btn {
        position: fixed;
        left: 0;
        top: 40%;
        z-index: 1040;
        width: 34px;
        height: 48px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-left: none;
        border-radius: 0 12px 12px 0;
        color: #ffffff;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 4px 0 16px rgba(0, 0, 0, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .mobile-sidebar-toggle-btn:hover {
        width: 40px;
        color: #f59e0b;
    }
    
    .mobile-sidebar-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 1045;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    .mobile-sidebar-backdrop.active {
        opacity: 1;
        visibility: visible;
    }

    @media (max-width: 991.98px) {
        .mobile-sidebar-toggle-btn {
            display: flex;
        }

        .mobile-sidebar-drawer {
            position: fixed !important;
            top: 0 !important;
            left: -320px !important;
            width: 300px !important;
            max-width: 85vw !important;
            height: 100vh !important;
            z-index: 1050 !important;
            background: #0c1220 !important;
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.7) !important;
            transition: left 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
            overflow-y: auto !important;
            padding: 20px 15px !important;
            margin: 0 !important;
        }
        .mobile-sidebar-drawer.active {
            left: 0 !important;
        }

        .mobile-sidebar-drawer .premium-sidebar-card {
            position: static !important;
            box-shadow: none !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 14px !important;
            background: #111827 !important;
        }

        .mobile-sidebar-close-header {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px 14px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .mobile-sidebar-close-header span {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .mobile-sidebar-close-btn {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 18px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }
        .mobile-sidebar-close-btn:hover {
            color: #ef4444;
        }
    }

    @media (min-width: 992px) {
        .mobile-sidebar-close-header {
            display: none !important;
        }
    }
</style>

<script>
    function toggleMobileSidebarCard() {
        const drawer = document.getElementById('leftSidebarCol');
        const backdrop = document.getElementById('mobileSidebarBackdrop');
        const btnIcon = document.getElementById('mobileSidebarToggleIcon');
        if (!drawer) return;

        const isActive = drawer.classList.toggle('active');
        if (backdrop) backdrop.classList.toggle('active', isActive);
        if (btnIcon) {
            btnIcon.className = isActive ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right';
        }
    }

    function closeMobileSidebarCard() {
        const drawer = document.getElementById('leftSidebarCol');
        const backdrop = document.getElementById('mobileSidebarBackdrop');
        const btnIcon = document.getElementById('mobileSidebarToggleIcon');
        if (drawer) drawer.classList.remove('active');
        if (backdrop) backdrop.classList.remove('active');
        if (btnIcon) btnIcon.className = 'fa-solid fa-chevron-right';
    }
</script>
