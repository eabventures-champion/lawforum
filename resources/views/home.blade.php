<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Legals Forum</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    
    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.08) 0%, transparent 60%);
            --card-bg: rgba(13, 20, 38, 0.45);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --success-color: #10b981;
            --danger-color: #ef4444;
            --sidebar-width: 260px;
            --sidebar-collapsed: 72px;
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
            position: relative;
            overflow-x: hidden;
        }

        /* ── Layout: Sidebar + Content ────────────────── */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            max-height: 100vh;
            background: rgba(8, 12, 28, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
            overflow: visible !important;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 18px;
            border-bottom: 1px solid var(--border-color);
            min-height: 78px;
            box-sizing: border-box;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 18px 0;
            justify-content: center;
        }

        .sidebar-brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .sidebar.collapsed .sidebar-brand-link {
            display: none !important;
        }

        .sidebar-logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--accent-gradient);
            box-shadow: 0 6px 18px var(--accent-glow);
            font-size: 18px;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.4px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .sidebar-logo-text {
            opacity: 0;
            width: 0;
        }

        .sidebar-toggle {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: var(--transition-smooth);
            flex-shrink: 0;
        }

        .sidebar-toggle:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.15);
        }

        .sidebar.collapsed .sidebar-toggle {
            margin: 0 auto;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--accent-gradient);
            border: none;
            color: #fff;
            box-shadow: 0 6px 16px var(--accent-glow);
        }

        .sidebar.collapsed .sidebar-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px var(--accent-glow);
        }

        .sidebar.collapsed .sidebar-toggle i {
            transform: rotate(180deg);
        }

        /* Sidebar Menu - Vertical Only Scroll */
        .sidebar-menu {
            list-style: none;
            padding: 16px 12px;
            flex: 1 1 auto;
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(59, 130, 246, 0.3) transparent;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.5);
        }

        .sidebar-menu .menu-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
            padding: 20px 12px 8px;
            white-space: nowrap;
        }

        .sidebar.collapsed .menu-label {
            opacity: 0;
            height: 0;
            padding: 0;
        }

        .sidebar-menu .menu-item {
            margin-bottom: 5px;
        }

        .sidebar-menu .menu-item:last-child {
            margin-bottom: 0;
        }

        .sidebar-menu .menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition-smooth);
            white-space: nowrap;
        }

        .sidebar-menu .menu-item a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-menu .menu-item a:hover {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-primary);
        }

        .sidebar-menu .menu-item.active a {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-color);
            font-weight: 600;
        }

        .sidebar-menu .menu-item a .menu-badge {
            margin-left: auto;
            background: rgba(59, 130, 246, 0.18);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            line-height: 1.2;
            transition: var(--transition-smooth);
            display: inline-block;
        }

        .sidebar-menu .menu-item.active a .menu-badge {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.35);
        }

        .sidebar.collapsed .sidebar-menu {
            padding: 16px 8px;
        }

        .sidebar.collapsed .sidebar-menu .menu-item a {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .sidebar-menu .menu-item a span {
            display: none !important;
        }

        /* ── Sidebar Submenu Accordion ────────────── */
        .sidebar-submenu-toggle {
            position: relative;
            cursor: pointer;
        }
        .sidebar-submenu-toggle .submenu-arrow {
            margin-left: auto;
            font-size: 10px;
            color: var(--text-muted);
            transition: transform 0.25s ease;
        }
        .menu-item-has-submenu.open .sidebar-submenu-toggle .submenu-arrow {
            transform: rotate(180deg);
            color: #60a5fa;
        }
        .sidebar-submenu-list {
            display: none;
            list-style: none;
            padding: 4px 0 6px 0;
            margin: 4px 0 6px 14px;
            border-left: 2px solid rgba(59, 130, 246, 0.25);
        }
        .sidebar-submenu-list.show {
            display: block;
            animation: fadeInSubmenu 0.25s ease;
        }
        @keyframes fadeInSubmenu {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .sidebar-submenu-heading {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #60a5fa;
            padding: 6px 12px 2px;
            opacity: 0.85;
        }
        .sidebar-submenu-link {
            display: flex;
            align-items: center;
            padding: 6px 12px !important;
            font-size: 12px !important;
            color: var(--text-secondary) !important;
            border-radius: 6px !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
        }
        .sidebar-submenu-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.06) !important;
            padding-left: 15px !important;
        }
        .sidebar.collapsed .sidebar-submenu-list,
        .sidebar.collapsed .submenu-arrow {
            display: none !important;
        }

        /* ── Sidebar Legal Library: Show only on mobile screens (<= 768px) ── */
        @media (min-width: 769px) {
            .sidebar-legal-library-item {
                display: none !important;
            }
        }
        @media (max-width: 768px) {
            .sidebar-legal-library-item {
                display: block !important;
            }
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 14px 16px 24px 16px;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            flex-shrink: 0;
            background: rgba(8, 12, 28, 0.98);
            position: relative;
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 14px 0 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: transparent;
            overflow: visible !important;
            position: relative;
        }

        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            transition: var(--transition-smooth);
            cursor: pointer;
            user-select: none;
            position: relative;
        }

        .sidebar-user-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .sidebar.collapsed .sidebar-user-card {
            width: 44px;
            height: 44px;
            padding: 0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            border: none;
            background: transparent;
            box-shadow: none;
            overflow: visible !important;
        }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--accent-color);
            flex-shrink: 0;
            transition: var(--transition-smooth);
            line-height: 1;
            text-align: center;
        }

        .sidebar.collapsed .sidebar-avatar {
            width: 40px;
            height: 40px;
            font-size: 15px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(29, 78, 216, 0.15) 100%);
            border: 1.5px solid rgba(59, 130, 246, 0.4);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .sidebar.collapsed .sidebar-user-card:hover .sidebar-avatar,
        .sidebar.collapsed .sidebar-user-card.active .sidebar-avatar {
            border-color: #60a5fa;
            transform: scale(1.06);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
        }

        .sidebar-user-info {
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s;
        }

        .sidebar.collapsed .sidebar-user-info {
            display: none !important;
        }

        .sidebar.collapsed .sidebar-user-chevron {
            display: none !important;
        }

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .sidebar-user-role {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* ── Main Content ───────────────────────────────── */
        .main-content-area {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .sidebar.collapsed ~ .main-content-area {
            margin-left: var(--sidebar-collapsed);
        }

        /* Top Header Bar */
        .top-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            min-height: 78px;
            border-bottom: 1px solid var(--border-color);
            background: rgba(4, 8, 20, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .top-header-title {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
            white-space: nowrap;
        }

        /* Top Header Navigation Menus */
        .top-header-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            margin: 0 16px;
            flex-wrap: wrap;
        }

        .nav-menu-links-premium {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link-dropdown {
            position: relative;
        }

        .nav-link-btn {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 8px 14px;
            border-radius: 10px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link-btn.active,
        .nav-link-dropdown.active > .nav-link-btn {
            color: #ffffff;
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            font-weight: 600;
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.2);
        }

        .nav-link-btn.active i,
        .nav-link-dropdown.active > .nav-link-btn i {
            color: #60a5fa;
        }

        .nav-link-btn i {
            font-size: 10px;
            color: var(--text-secondary);
            transition: transform 0.2s ease;
        }

        .nav-link-dropdown:hover > .nav-link-btn i {
            transform: rotate(180deg);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: rgba(13, 20, 38, 0.97);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(0.98);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .nav-link-dropdown:hover > .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            color: #d1d5db;
            transition: var(--transition-smooth);
            text-align: left;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .nav-dropdown-menu a:hover {
            color: #ffffff;
            background: rgba(59, 130, 246, 0.12);
        }

        .nav-dropdown-menu a.active {
            color: #60a5fa;
            background: rgba(59, 130, 246, 0.15);
            font-weight: 600;
        }

        .nav-sub-dropdown {
            position: relative;
        }

        .nav-sub-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            color: #d1d5db;
            transition: var(--transition-smooth);
            text-align: left;
            text-decoration: none !important;
            cursor: pointer;
            white-space: nowrap;
        }

        .nav-sub-dropdown-trigger:hover {
            color: #ffffff;
            background: rgba(59, 130, 246, 0.12);
        }

        .nav-sub-dropdown-menu {
            position: absolute;
            top: 0;
            left: calc(100% + 4px);
            min-width: 200px;
            background: rgba(13, 20, 38, 0.97);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateX(-8px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1010;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .nav-sub-dropdown:hover > .nav-sub-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }

        .nav-sub-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            color: #d1d5db;
            transition: var(--transition-smooth);
            text-align: left;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .nav-sub-dropdown-menu a:hover {
            color: #ffffff;
            background: rgba(59, 130, 246, 0.12);
        }

        .top-header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        /* Header Icon Buttons */
        .header-icon-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 18px;
            cursor: pointer;
            transition: var(--transition-smooth);
            position: relative;
            text-decoration: none;
        }

        .header-icon-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .header-icon-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #3b82f6;
            box-shadow: 0 0 6px #3b82f6;
        }

        /* Profile Dropdown Container */
        .profile-dropdown-container {
            position: relative;
        }

        .header-avatar-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: 2px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 14px var(--accent-glow);
            transition: var(--transition-smooth);
            outline: none;
        }

        .header-avatar-btn:hover,
        .header-avatar-btn.active {
            transform: scale(1.05);
            border-color: rgba(59, 130, 246, 0.8);
            box-shadow: 0 6px 20px var(--accent-glow);
        }

        /* Profile Floating Dropdown */
        .profile-menu-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 270px;
            background: rgba(13, 20, 38, 0.96);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.05);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(0.97);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            overflow: hidden;
        }

        .profile-menu-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .profile-dropdown-header {
            padding: 16px 18px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .profile-header-name {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-header-email {
            font-size: 12.5px;
            color: var(--text-secondary);
            margin-top: 3px;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-role-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            border-radius: 100px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #34d399;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .profile-role-pill .pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
            flex-shrink: 0;
        }

        .profile-dropdown-list {
            list-style: none;
            padding: 8px;
            margin: 0;
        }

        .profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: var(--transition-smooth);
            cursor: pointer;
        }

        .profile-dropdown-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
            color: #9ca3af;
            transition: var(--transition-smooth);
            flex-shrink: 0;
        }

        .profile-dropdown-item:hover {
            background: rgba(59, 130, 246, 0.12);
            color: #ffffff;
        }

        .profile-dropdown-item:hover i {
            color: #60a5fa;
        }

        .profile-dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
            margin: 4px 8px;
        }

        .profile-dropdown-item.item-logout {
            color: #f87171;
        }

        .profile-dropdown-item.item-logout i {
            color: #f87171;
        }

        .profile-dropdown-item.item-logout:hover {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        .profile-dropdown-item.item-logout:hover i {
            color: #ef4444;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 32px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Welcome & Account Unified Row Card ───────────── */
        .welcome-account-card {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.82) 0%, rgba(10, 15, 29, 0.92) 100%);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 1px solid rgba(96, 165, 250, 0.35);
            border-radius: 22px;
            padding: 24px 30px;
            margin-bottom: 28px;
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.35), 0 0 25px rgba(59, 130, 246, 0.08);
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
            position: relative;
            overflow: hidden;
        }

        .welcome-account-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(96, 165, 250, 0.6) 20%, rgba(245, 158, 11, 0.4) 80%, transparent 100%);
        }

        .welcome-info-main {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        .avatar-circle {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25) 0%, rgba(29, 78, 216, 0.15) 100%);
            border: 2px solid rgba(96, 165, 250, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #93c5fd;
            font-weight: 800;
            box-shadow: 0 4px 18px rgba(59, 130, 246, 0.25);
            flex-shrink: 0;
        }

        .welcome-text h2 {
            font-size: 21px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 4px;
            letter-spacing: -0.3px;
            line-height: 1.25;
        }

        .welcome-text p {
            font-size: 14.5px;
            font-weight: 500;
            color: #94a3b8;
        }

        .welcome-meta-row {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-left: auto;
        }

        .welcome-meta-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 6px;
        }

        .welcome-meta-item .meta-label {
            font-size: 11px;
            font-weight: 750;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            color: #94a3b8;
            text-align: center;
        }

        .welcome-meta-item .meta-value {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 15px;
            font-weight: 650;
            color: var(--text-primary);
        }

        .welcome-meta-divider {
            width: 1px;
            height: 42px;
            background: rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        @media (max-width: 991px) {
            .welcome-account-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .welcome-meta-row {
                margin-left: 0;
                width: 100%;
                justify-content: flex-start;
                gap: 16px;
            }
            .welcome-meta-divider {
                display: none;
            }
        }

        .subscription-badge {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            padding: 8px 16px;
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--success-color);
        }

        .subscription-badge.inactive {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: var(--danger-color);
        }

        /* ── Become a Publisher Feature ─────────────────── */
        .btn-become-publisher {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
            padding: 5px 14px;
            border-radius: 100px;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.18) 0%, rgba(217, 119, 6, 0.12) 100%);
            border: 1px solid rgba(245, 158, 11, 0.4);
            color: #fbbf24;
            font-size: 12.5px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all 0.25s ease;
            box-shadow: 0 2px 10px rgba(245, 158, 11, 0.15);
            width: fit-content;
            cursor: pointer;
        }

        .btn-become-publisher:hover {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.3) 0%, rgba(217, 119, 6, 0.22) 100%);
            border-color: rgba(245, 158, 11, 0.7);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
        }

        .badge-publisher-pill {
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 100px;
            background: rgba(245, 158, 11, 0.3);
            color: #fbbf24;
            letter-spacing: 0.5px;
        }

        .publisher-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.25s ease;
        }

        .publisher-modal-overlay.show {
            display: flex;
        }

        .publisher-modal-card {
            background: var(--bg-secondary);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 20px;
            max-width: 520px;
            width: 100%;
            padding: 30px;
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(245, 158, 11, 0.1);
        }

        .publisher-modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            background: rgba(255, 255, 255, 0.06);
            border: none;
            color: var(--text-secondary);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .publisher-modal-close:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .publisher-feature-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 20px 0;
        }

        .publisher-feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            color: var(--text-secondary);
        }

        .publisher-feature-item i {
            color: #10b981;
            font-size: 14px;
        }

        .btn-publisher-submit {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
        }

        .btn-publisher-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.45);
        }

        [data-theme="light"] .btn-become-publisher {
            background: rgba(245, 158, 11, 0.12);
            border-color: rgba(245, 158, 11, 0.4);
            color: #d97706;
        }

        [data-theme="light"] .publisher-modal-card {
            background: #ffffff;
            border-color: rgba(245, 158, 11, 0.3);
        }

        .demo-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 24px;
        }

        .demo-info-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .demo-info-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-secondary);
        }

        .demo-info-value {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 13.5px;
            font-weight: 650;
        }

        .type-badge.researcher { background: rgba(139,92,246,0.14); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.3); }
        .type-badge.student { background: rgba(59,130,246,0.14); color: #93c5fd; border: 1px solid rgba(59,130,246,0.3); }
        .type-badge.lawyer { background: rgba(245,158,11,0.14); color: #fde68a; border: 1px solid rgba(245,158,11,0.3); }
        .type-badge.profession-badge { background: rgba(16,185,129,0.14); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }

        .demo-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 13px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 650;
        }

        .demo-status-badge.active { background: rgba(16,185,129,0.14); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }
        .demo-status-badge.extension { background: rgba(245,158,11,0.14); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }
        .demo-status-badge.expired { background: rgba(239,68,68,0.14); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }

        .countdown-ring {
            position: relative;
            width: 72px;
            height: 72px;
            flex-shrink: 0;
        }

        .countdown-ring svg { transform: rotate(-90deg); width: 72px; height: 72px; }
        .countdown-ring .ring-bg { fill: none; stroke: rgba(255,255,255,0.06); stroke-width: 4; }
        .countdown-ring .ring-progress { fill: none; stroke-width: 4; stroke-linecap: round; transition: stroke-dashoffset 1s ease; }
        .countdown-ring .ring-text { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .countdown-ring .ring-days { font-size: 20px; font-weight: 800; line-height: 1; }
        .countdown-ring .ring-label { font-size: 9px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary); margin-top: 2px; }

        .demo-warning-banner {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-top: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .demo-warning-banner.extension-warn { background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2); color: #fbbf24; }
        .demo-warning-banner.expired-warn { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }

        /* ── In-Dashboard Page Viewer ────────────────────── */
        .dashboard-viewer-container {
            display: flex;
            flex-direction: column;
            gap: 14px;
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
        }

        .dashboard-viewer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 10px 18px;
            gap: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-viewer-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .btn-viewer-back:hover {
            background: rgba(59, 130, 246, 0.22);
            color: #fff;
            transform: translateX(-2px);
        }

        .viewer-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .viewer-actions-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-viewer-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
            font-size: 13px;
        }

        .btn-viewer-icon:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.15);
        }

        .viewer-frame-wrapper {
            position: relative;
            width: 100%;
            height: calc(100vh - 180px);
            min-height: 560px;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            background: var(--bg-primary);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.35);
        }

        .dashboard-viewer-frame {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
            background: transparent;
        }

        .viewer-loader {
            position: absolute;
            inset: 0;
            background: rgba(4, 8, 20, 0.88);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: #60a5fa;
            font-size: 14px;
            font-weight: 500;
            z-index: 10;
            transition: opacity 0.3s ease;
        }

        .viewer-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .viewer-loader i {
            font-size: 32px;
        }

        /* ── Header Quick Search Button ──────────────────── */
        .quick-search-header-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.14);
            border: 1px solid rgba(59, 130, 246, 0.35);
            color: #93c5fd;
            font-size: 13.5px;
            font-weight: 650;
            text-decoration: none !important;
            transition: var(--transition-smooth);
            margin-right: 4px;
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.12);
        }

        .quick-search-header-btn:hover {
            background: rgba(59, 130, 246, 0.28);
            border-color: rgba(59, 130, 246, 0.7);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        }

        .quick-search-header-btn i {
            font-size: 14px;
        }

        [data-theme="light"] .quick-search-header-btn {
            background: rgba(37, 99, 235, 0.08);
            border-color: rgba(37, 99, 235, 0.25);
            color: #2563eb;
        }

        [data-theme="light"] .quick-search-header-btn:hover {
            background: rgba(37, 99, 235, 0.15);
            border-color: #2563eb;
            color: #1d4ed8;
        }

        /* ── Quick Access Grid ───────────────────────────── */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }

        .portal-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }

        .portal-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent-color);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.12);
        }

        .portal-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--accent-color);
            transition: var(--transition-smooth);
        }

        .portal-card:hover .portal-icon-wrapper {
            background: var(--accent-gradient);
            color: #fff;
            box-shadow: 0 6px 15px var(--accent-glow);
            border-color: transparent;
        }

        .portal-title { font-size: 16px; font-weight: 700; color: #fff; }
        .portal-desc { font-size: 13px; color: var(--text-secondary); line-height: 1.5; }

        .portal-card.admin-card { border-color: rgba(245,158,11,0.2); }
        .portal-card.admin-card:hover { border-color: #f59e0b; box-shadow: 0 10px 25px rgba(245,158,11,0.12); }
        .portal-card.admin-card .portal-icon-wrapper { color: #f59e0b; }
        /* ── Light Theme Variables & Overrides ─────────── */
        [data-theme="light"] {
            --bg-primary: #f4f6fb;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 60%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --border-color: rgba(0, 0, 0, 0.08);
            --text-primary: #0f172a;
            --text-secondary: #64748b;
        }

        [data-theme="light"] body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        [data-theme="light"] .sidebar {
            background: rgba(255, 255, 255, 0.96);
            border-right: 1px solid var(--border-color);
        }

        [data-theme="light"] .sidebar-header {
            border-bottom: 1px solid var(--border-color);
        }

        [data-theme="light"] .sidebar-logo-text {
            color: #0f172a;
        }

        [data-theme="light"] .sidebar-toggle {
            border-color: var(--border-color);
            color: #64748b;
        }

        [data-theme="light"] .sidebar-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #0f172a;
        }

        [data-theme="light"] .sidebar-menu .menu-label {
            color: #94a3b8;
        }

        [data-theme="light"] .sidebar-menu .menu-item a {
            color: #64748b;
        }

        [data-theme="light"] .sidebar-menu .menu-item a:hover {
            background: rgba(0, 0, 0, 0.04);
            color: #0f172a;
        }

        [data-theme="light"] .sidebar-menu .menu-item.active a {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-color);
        }

        [data-theme="light"] .sidebar-footer {
            background: rgba(255, 255, 255, 0.98);
            border-top: 1px solid var(--border-color);
        }

        [data-theme="light"] .sidebar-user-card {
            background: #f8fafc;
            border-color: rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        [data-theme="light"] .sidebar-user-card:hover {
            background: #f1f5f9;
            border-color: rgba(59, 130, 246, 0.3);
        }

        [data-theme="light"] .top-header {
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid var(--border-color);
        }

        [data-theme="light"] .top-header-title {
            color: #0f172a;
        }

        [data-theme="light"] .header-icon-btn {
            background: #f1f5f9;
            border-color: rgba(0, 0, 0, 0.08);
            color: #64748b;
        }

        [data-theme="light"] .header-icon-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        [data-theme="light"] .profile-menu-dropdown {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .profile-dropdown-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        [data-theme="light"] .profile-header-name {
            color: #0f172a;
        }

        [data-theme="light"] .profile-dropdown-item {
            color: #475569;
        }

        [data-theme="light"] .profile-dropdown-item:hover {
            background: rgba(59, 130, 246, 0.08);
            color: #0f172a;
        }

        [data-theme="light"] .profile-dropdown-divider {
            background: rgba(0, 0, 0, 0.06);
        }

        [data-theme="light"] .dashboard-viewer-bar {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        }

        [data-theme="light"] .btn-viewer-icon {
            background: #f1f5f9;
            border-color: rgba(0, 0, 0, 0.08);
            color: #64748b;
        }

        [data-theme="light"] .viewer-frame-wrapper {
            background: #f8fafc;
            border-color: rgba(0, 0, 0, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .viewer-loader {
            background: rgba(255, 255, 255, 0.9);
            color: #2563eb;
        }

        [data-theme="light"] .welcome-account-card {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        [data-theme="light"] .welcome-card-divider {
            background: rgba(0, 0, 0, 0.06);
        }

        [data-theme="light"] .avatar-circle {
            background: #f1f5f9;
            border-color: rgba(59, 130, 246, 0.2);
        }

        [data-theme="light"] .welcome-text h2 {
            color: #0f172a;
        }

        [data-theme="light"] .portal-card {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        [data-theme="light"] .portal-card:hover {
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
            border-color: var(--accent-color);
        }

        [data-theme="light"] .portal-title {
            color: #0f172a;
        }

        [data-theme="light"] .portal-icon-wrapper {
            background: #f1f5f9;
            border-color: rgba(0, 0, 0, 0.06);
        }

        [data-theme="light"] .countdown-ring .ring-bg {
            stroke: rgba(0, 0, 0, 0.06);
        }

        [data-theme="light"] .nav-link-btn {
            color: #64748b;
        }

        [data-theme="light"] .nav-link-btn:hover {
            color: #0f172a;
            background: rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .nav-link-btn.active,
        [data-theme="light"] .nav-link-dropdown.active > .nav-link-btn {
            color: #1d4ed8;
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
        }

        [data-theme="light"] .nav-dropdown-menu,
        [data-theme="light"] .nav-sub-dropdown-menu {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(0, 0, 0, 0.1);
            box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .nav-dropdown-menu a,
        [data-theme="light"] .nav-sub-dropdown-trigger,
        [data-theme="light"] .nav-sub-dropdown-menu a {
            color: #475569;
        }

        [data-theme="light"] .nav-dropdown-menu a:hover,
        [data-theme="light"] .nav-sub-dropdown-trigger:hover,
        [data-theme="light"] .nav-sub-dropdown-menu a:hover {
            color: #0f172a;
            background: rgba(59, 130, 246, 0.08);
        }

        [data-theme="light"] .nav-dropdown-menu a.active,
        [data-theme="light"] .nav-sub-dropdown-menu a.active {
            color: #1d4ed8;
            background: rgba(59, 130, 246, 0.1);
        }

        /* ── Mobile Sidebar Drawer & Backdrop ────────── */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 199;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-backdrop.active {
            display: block;
            opacity: 1;
        }

        .mobile-sidebar-close {
            display: none;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            margin-left: auto;
            transition: all 0.2s ease;
        }
        .mobile-sidebar-close:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.4);
        }

        .mobile-menu-toggle {
            display: none;
        }
        .mobile-brand-header {
            display: none;
        }

        /* ── Responsive ──────────────────────────────────── */
        @media (max-width: 1100px) {
            .top-header-nav {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
            }
            .mobile-brand-header {
                display: flex !important;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                color: inherit;
                flex-shrink: 0;
            }
            .mobile-brand-header span {
                display: none !important;
            }
            .top-header-title {
                display: none;
            }
            .top-header-nav {
                display: none !important;
            }
            .top-header {
                padding: 10px 14px !important;
                gap: 10px !important;
            }
            .top-header-actions {
                flex: 1;
                justify-content: flex-end;
                gap: 10px !important;
            }
            .quick-search-header-btn {
                padding: 8px 14px !important;
                flex: 1;
                max-width: 165px;
                justify-content: center;
                gap: 7px !important;
                border-radius: 10px !important;
            }
            .quick-search-header-btn span {
                display: inline !important;
                font-size: 13px !important;
                font-weight: 700 !important;
                white-space: nowrap;
            }
            .quick-search-header-btn i {
                font-size: 13.5px !important;
            }
            .header-icon-btn {
                width: 42px !important;
                height: 42px !important;
                font-size: 18px !important;
                border-radius: 11px !important;
            }
            .mobile-menu-toggle i {
                font-size: 18px !important;
            }
            #notificationBellBtn i {
                font-size: 18px !important;
            }
            .main-content-area {
                margin-left: 0 !important;
                width: 100% !important;
                min-width: 0 !important;
            }
            .sidebar {
                width: 280px !important;
                position: fixed !important;
                top: 0 !important;
                left: -290px !important;
                bottom: 0 !important;
                height: 100vh !important;
                z-index: 200 !important;
                transform: none !important;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.3s !important;
                box-shadow: none;
                visibility: hidden;
            }
            .sidebar.mobile-open {
                left: 0 !important;
                transform: none !important;
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.8) !important;
                visibility: visible;
            }
            .sidebar .sidebar-toggle {
                display: none !important;
            }
            .mobile-sidebar-close {
                display: inline-flex !important;
            }
            .sidebar.collapsed {
                width: 280px !important;
            }
            .sidebar .sidebar-brand-link {
                display: flex !important;
            }
            .sidebar .sidebar-logo-text {
                display: block !important;
                opacity: 1 !important;
                width: auto !important;
            }
            .sidebar .menu-label {
                display: block !important;
                opacity: 1 !important;
                width: auto !important;
            }
            .sidebar .sidebar-menu .menu-item a {
                justify-content: flex-start !important;
                padding: 10px 14px !important;
            }
            .sidebar .sidebar-menu .menu-item a span {
                display: inline !important;
                opacity: 1 !important;
                width: auto !important;
            }
            .sidebar .sidebar-user-info {
                display: block !important;
            }
            .dashboard-content {
                padding: 14px 10px !important;
            }
            .welcome-account-card {
                width: 100% !important;
                padding: 20px 16px !important;
                border-radius: 18px !important;
                gap: 16px !important;
                margin-bottom: 18px !important;
                background: linear-gradient(145deg, rgba(17, 24, 39, 0.92) 0%, rgba(11, 17, 33, 0.98) 100%) !important;
                border: 1px solid rgba(255, 255, 255, 0.12) !important;
                border-top: 1px solid rgba(96, 165, 250, 0.4) !important;
                box-shadow: 0 12px 36px rgba(0, 0, 0, 0.5), 0 0 20px rgba(59, 130, 246, 0.08) !important;
            }
            .welcome-info-main {
                width: 100% !important;
                gap: 14px !important;
                padding-bottom: 16px !important;
                margin-bottom: 2px !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            }
            .avatar-circle {
                width: 52px !important;
                height: 52px !important;
                font-size: 20px !important;
                border-width: 2px !important;
            }
            .welcome-text h2 {
                font-size: 18px !important;
                font-weight: 800 !important;
                margin-bottom: 3px !important;
                line-height: 1.3 !important;
            }
            .welcome-text p {
                font-size: 13.5px !important;
                margin-bottom: 6px !important;
                color: #94a3b8 !important;
            }
            .btn-become-publisher {
                padding: 5px 12px !important;
                font-size: 12px !important;
                margin-top: 6px !important;
                margin-bottom: 2px !important;
            }
            .badge-publisher-pill {
                font-size: 9.5px !important;
            }
            .welcome-meta-row {
                width: 100% !important;
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                align-items: center !important;
                justify-items: center !important;
                gap: 14px !important;
                margin-left: 0 !important;
                padding-top: 6px !important;
            }
            .welcome-meta-divider {
                display: none !important;
            }
            .welcome-meta-item {
                min-width: 0 !important;
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                gap: 5px !important;
            }
            .welcome-meta-item .meta-label {
                font-size: 10px !important;
                letter-spacing: 0.6px !important;
                white-space: nowrap !important;
                text-transform: uppercase !important;
                color: #94a3b8 !important;
                font-weight: 750 !important;
                text-align: center !important;
            }
            .welcome-meta-item .meta-value {
                font-size: 13.5px !important;
                font-weight: 650 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                justify-content: center !important;
                width: 100% !important;
                gap: 5px !important;
            }
            .type-badge {
                padding: 4px 10px !important;
                font-size: 12px !important;
                font-weight: 650 !important;
                gap: 4px !important;
            }
            .type-badge i {
                font-size: 11px !important;
            }
            .profile-dropdown-container {
                display: none !important;
            }
            .sidebar-user-card {
                cursor: pointer;
            }
        }

        /* ── Sidebar User Dropdown (Popover Menu) ────── */
        .sidebar-user-card {
            cursor: pointer;
            user-select: none;
            transition: all 0.2s ease;
        }
        .sidebar-user-card:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar-user-dropdown {
            display: none;
            background: #0f172a;
            background: linear-gradient(180deg, #111827 0%, #0b0f19 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.8), 0 0 20px rgba(59, 130, 246, 0.1);
        }
        .sidebar-user-dropdown.show {
            display: block;
        }
        .sidebar.collapsed .sidebar-user-dropdown {
            position: absolute !important;
            left: calc(100% + 14px) !important;
            bottom: 8px !important;
            width: 270px !important;
            z-index: 1000 !important;
            margin-bottom: 0 !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.85), 0 0 25px rgba(59, 130, 246, 0.15) !important;
            animation: flyoutIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        @keyframes flyoutIn {
            from { opacity: 0; transform: translateX(-8px) scale(0.97); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }
        [data-theme="light"] .sidebar-user-dropdown {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.1);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15), 0 0 20px rgba(59, 130, 246, 0.08);
        }
        [data-theme="light"] .sidebar-user-link-item:hover {
            background: rgba(0, 0, 0, 0.05);
            color: #0f172a;
        }
        .sidebar-user-card.active .sidebar-user-chevron {
            transform: rotate(180deg);
        }
        .sidebar-user-link-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        .sidebar-user-link-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
        }
        .sidebar-user-link-item i {
            font-size: 14px;
            width: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    @php
        $user = auth()->user();
        $userType = $user->user_type;
        $isDemo = $user->is_demo_mode;
        $demoStarted = $user->demo_started_at;
        $demoUsed = $user->demo_used;
        $demoDays = (int) \App\DemoSetting::get('demo_duration_days', 60);
        $extensionDays = (int) \App\DemoSetting::get('demo_extension_days', 15);
        $totalDemoDays = $demoDays + ($user->demo_extended ? $extensionDays : 0);
        $remaining = $user->demoRemainingDays();
        $demoActive = $user->isDemoActive();
        $extensionActive = $user->isDemoExtensionActive();
        $demoExpired = $demoUsed && !$isDemo && !$demoActive;
        $hasSubscription = $user->check_subscription && $user->subscription_expiry && \Carbon\Carbon::parse($user->subscription_expiry)->isFuture();
        $researcherTypeLabel = $user->researcher_type === 'Other' ? $user->researcher_type_other : $user->researcher_type;

        if ($isDemo && $demoStarted) {
            $elapsed = max(0, $totalDemoDays - $remaining);
            $progressPct = $totalDemoDays > 0 ? min(100, ($elapsed / $totalDemoDays) * 100) : 100;
        } else {
            $progressPct = 100;
        }
        $circumference = 2 * 3.14159 * 28;
        $dashOffset = $circumference - ($progressPct / 100) * $circumference;
    @endphp

    @include('partials._impersonation_banner')

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeMobileSidebar()"></div>

    <div class="app-layout">
        <!-- ── Sidebar ── -->
        <aside class="sidebar" id="dashboardSidebar">
            <div class="sidebar-header">
                <a href="/" class="sidebar-brand-link">
                    <div class="sidebar-logo-icon" title="Legals Forum">
                        <i class="fa fa-balance-scale"></i>
                    </div>
                    <span class="sidebar-logo-text">Legals Forum</span>
                </a>
                <button class="sidebar-toggle" id="toggleSidebar" title="Collapse / Expand Sidebar" type="button">
                    <i class="fa-solid fa-angles-left"></i>
                </button>
                <button class="mobile-sidebar-close" id="closeMobileSidebar" onclick="closeMobileSidebar()" type="button" title="Close Menu">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-label">Main</li>
                <li class="menu-item active">
                    <a href="/home">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-label">My Library</li>
                <li class="menu-item">
                    <a href="/accounts/bookmarks/{{ auth()->user()->id }}">
                        <i class="fa-solid fa-bookmark"></i>
                        <span>Bookmarks</span>
                        @php
                            $homeBookmarksCount = \App\UserBookmark::where('user_id', auth()->id())->count();
                        @endphp
                        @if($homeBookmarksCount > 0)
                            <span class="menu-badge">{{ $homeBookmarksCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/accounts/notes/{{ auth()->user()->id }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Notes</span>
                        @php
                            $homeNotesCount = \App\UserNote::where('user_id', auth()->id())->count();
                        @endphp
                        @if($homeNotesCount > 0)
                            <span class="menu-badge">{{ $homeNotesCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="menu-item">
                    <a href="/accounts/downloads/{{ auth()->user()->id }}">
                        <i class="fa-solid fa-cloud-arrow-down"></i>
                        <span>Downloads</span>
                    </a>
                </li>
                <li class="menu-item {{ (request()->is('subscription*') || request()->is('accounts/subscription*')) ? 'active' : '' }}">
                    <a href="/subscription">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Subscription</span>
                        <span class="menu-badge" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 10px; margin-left: auto;">Coming Soon</span>
                    </a>
                </li>

                {{-- Legal Library Category Menus (Constitution, Existing Laws, New Laws, Case Laws) --}}
                @include('partials._sidebar_legal_library')

                @if(auth()->user()->isAdmin())
                <li class="menu-label">Admin</li>
                <li class="menu-item">
                    <a href="/admin" style="color: #f59e0b;">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Admin Panel</span>
                    </a>
                </li>
                @endif
            </ul>

            <div class="sidebar-footer">
                <!-- Expandable User Menu inside Sidebar (Mobile & Desktop) -->
                <div class="sidebar-user-dropdown" id="sidebarUserDropdown">
                    <div class="sidebar-user-dropdown-header">
                        <div class="profile-header-name" style="font-size: 13.5px; font-weight: 700; color: #fff; margin-bottom: 2px;">{{ auth()->user()->name }} {{ auth()->user()->lname }}</div>
                        <div class="profile-header-email" style="font-size: 11.5px; color: var(--text-secondary); margin-bottom: 6px;">{{ auth()->user()->email }}</div>
                        <div class="profile-role-pill" style="display: inline-flex; align-items: center; gap: 5px; font-size: 10.5px; padding: 2px 8px; border-radius: 20px; background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                            <span class="pill-dot" style="width: 5px; height: 5px; border-radius: 50%; background: #10b981;"></span>
                            @if(auth()->user()->isAdmin())
                                Super Admin
                            @elseif(auth()->user()->user_type)
                                {{ ucfirst(auth()->user()->user_type) }}
                            @else
                                Member
                            @endif
                        </div>
                    </div>
                    <ul class="sidebar-user-links" style="list-style: none; padding: 8px 0 0; margin: 0;">
                        <li>
                            <a href="/accounts/profile/{{ auth()->user()->id }}" class="sidebar-user-link-item">
                                <i class="fa-regular fa-circle-user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        @if($isDemo && $demoStarted)
                        <li class="sidebar-validity-item" style="padding: 10px 12px; margin: 6px 0 8px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 10px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                <div style="display: flex; align-items: center; gap: 9px;">
                                    <div class="countdown-ring" style="width: 32px; height: 32px; flex-shrink: 0;">
                                        <svg viewBox="0 0 64 64" style="width: 32px; height: 32px;">
                                            <circle class="ring-bg" cx="32" cy="32" r="28"></circle>
                                            <circle class="ring-progress" cx="32" cy="32" r="28"
                                                stroke="{{ $extensionActive ? '#f59e0b' : '#3b82f6' }}"
                                                stroke-dasharray="{{ 2 * 3.14159 * 28 }}"
                                                stroke-dashoffset="{{ (2 * 3.14159 * 28) - ($progressPct / 100) * (2 * 3.14159 * 28) }}"></circle>
                                        </svg>
                                        <div class="ring-text">
                                            <span class="ring-days" style="font-size: 10.5px; color: {{ $extensionActive ? '#fbbf24' : '#60a5fa' }};">{{ $remaining }}</span>
                                            <span class="ring-label" style="font-size: 6px;">{{ $remaining === 1 ? 'DAY' : 'DAYS' }}</span>
                                        </div>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 1px;">
                                        <span style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8;">Trial Validity</span>
                                        <!-- <span style="font-size: 11.5px; font-weight: 600; color: #fff;">{{ $remaining }} {{ $remaining === 1 ? 'day' : 'days' }} left</span> -->
                                    </div>
                                </div>
                                <span class="demo-status-badge {{ $extensionActive ? 'extension' : ($demoActive ? 'active' : 'expired') }}" style="font-size: 10px; padding: 2px 7px; white-space: nowrap;">
                                    <i class="fa-solid {{ $extensionActive ? 'fa-clock' : ($demoActive ? 'fa-circle-play' : 'fa-circle-xmark') }}"></i>
                                    {{ $extensionActive ? 'Extension' : ($demoActive ? 'Active' : 'Expired') }}
                                </span>
                            </div>
                        </li>
                        @endif
                        <li>
                            <a href="javascript:void(0)" class="sidebar-user-link-item" onclick="startPlatformTour()">
                                <i class="fa-solid fa-compass" style="color: #60a5fa;"></i>
                                <span>Take Dashboard Tour</span>
                            </a>
                        </li>
                        <li>
                            <a href="/accounts/manage-password" class="sidebar-user-link-item">
                                <i class="fa-solid fa-gear"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="sidebar-user-link-item" onclick="toggleAppTheme()">
                                <i class="fa-regular fa-moon theme-toggle-icon"></i>
                                <span class="theme-toggle-label">Theme Mode</span>
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                        <li>
                            <a href="/admin" class="sidebar-user-link-item" style="color: #fbbf24;">
                                <i class="fa-solid fa-shield-halved" style="color: #f59e0b;"></i>
                                <span>Admin Panel</span>
                            </a>
                        </li>
                        @endif
                        <div style="height: 1px; background: rgba(255,255,255,0.08); margin: 6px 0;"></div>
                        <li>
                            <a href="#" class="sidebar-user-link-item item-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f87171;">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="sidebar-user-card" id="sidebarUserCard" onclick="toggleSidebarUserMenu(event)">
                    <div class="sidebar-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="sidebar-user-info">
                        <div class="sidebar-user-name">{{ auth()->user()->name }} {{ auth()->user()->lname }}</div>
                        <div class="sidebar-user-role">{{ ucfirst(auth()->user()->user_type ?? 'Member') }}</div>
                    </div>
                    <i class="fa-solid fa-chevron-up sidebar-user-chevron" style="margin-left: auto; font-size: 11px; color: var(--text-muted); transition: transform 0.2s ease;"></i>
                </div>
            </div>
        </aside>

        <!-- ── Main Content ── -->
        <div class="main-content-area">
            <!-- Top Header -->
            <div class="top-header">
                <div class="top-header-left">
                    <a href="/home" class="mobile-brand-header">
                        <div class="sidebar-logo-icon" style="width: 38px; height: 38px; font-size: 17px;">
                            <i class="fa fa-balance-scale"></i>
                        </div>
                        <span style="font-size: 17px; font-weight: 800; color: #fff; letter-spacing: -0.3px;">Legals Forum</span>
                    </a>
                    <h1 class="top-header-title">Dashboard</h1>
                </div>

                <!-- Navigation Menus in Dashboard Header -->
                <nav class="nav-menu-links-premium top-header-nav" aria-label="Portal Navigation">
                    @include('partials._nav_desktop_menu')
                </nav>
                
                <div class="top-header-actions">
                    <!-- Quick Search Button -->
                    <a href="/?quick_search=1" class="quick-search-header-btn" title="Quick Legal Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Quick Search</span>
                    </a>

                    <!-- Notifications Dropdown (Platform Updates & Feature Alerts) -->
                    @include('partials._notification_dropdown')

                    <!-- Mobile Hamburger Menu Button -->
                    <button class="header-icon-btn mobile-menu-toggle" id="mobileMenuToggle" onclick="openMobileSidebar()" title="Open Navigation Menu" type="button">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Profile Management Dropdown -->
                    @php
                        $uName = auth()->user()->name ?? '';
                        $uLname = auth()->user()->lname ?? '';
                        $initials = '';
                        if (!empty($uName)) {
                            $initials .= strtoupper(substr($uName, 0, 1));
                        }
                        if (!empty($uLname)) {
                            $initials .= strtoupper(substr($uLname, 0, 1));
                        }
                        if (empty($initials)) {
                            $initials = 'U';
                        }
                    @endphp

                    <div class="profile-dropdown-container" id="profileDropdownContainer">
                        <button class="header-avatar-btn" id="profileDropdownBtn" type="button" aria-expanded="false" title="{{ auth()->user()->name }} {{ auth()->user()->lname }}">
                            {{ $initials }}
                        </button>

                        <div class="profile-menu-dropdown" id="profileDropdownMenu">
                            <div class="profile-dropdown-header">
                                <div class="profile-header-name">{{ auth()->user()->name }} {{ auth()->user()->lname }}</div>
                                <div class="profile-header-email">{{ auth()->user()->email }}</div>
                                <div class="profile-role-pill">
                                    <span class="pill-dot"></span>
                                    @if(auth()->user()->isAdmin())
                                        Super Admin
                                    @elseif(auth()->user()->user_type)
                                        {{ ucfirst(auth()->user()->user_type) }}
                                    @else
                                        Member
                                    @endif
                                </div>
                            </div>

                            <ul class="profile-dropdown-list">
                                <li>
                                    <a href="/accounts/profile/{{ auth()->user()->id }}" class="profile-dropdown-item">
                                        <i class="fa-regular fa-circle-user"></i>
                                        <span>My Profile</span>
                                    </a>
                                </li>
                                @if($isDemo && $demoStarted)
                                <li style="padding: 10px 14px; margin: 4px 6px 8px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 10px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                        <div style="display: flex; align-items: center; gap: 9px;">
                                            <div class="countdown-ring" style="width: 32px; height: 32px; flex-shrink: 0;">
                                                <svg viewBox="0 0 64 64" style="width: 32px; height: 32px;">
                                                    <circle class="ring-bg" cx="32" cy="32" r="28"></circle>
                                                    <circle class="ring-progress" cx="32" cy="32" r="28"
                                                        stroke="{{ $extensionActive ? '#f59e0b' : '#3b82f6' }}"
                                                        stroke-dasharray="{{ 2 * 3.14159 * 28 }}"
                                                        stroke-dashoffset="{{ (2 * 3.14159 * 28) - ($progressPct / 100) * (2 * 3.14159 * 28) }}"></circle>
                                                </svg>
                                                <div class="ring-text">
                                                    <span class="ring-days" style="font-size: 10.5px; color: {{ $extensionActive ? '#fbbf24' : '#60a5fa' }};">{{ $remaining }}</span>
                                                    <span class="ring-label" style="font-size: 6px;">{{ $remaining === 1 ? 'DAY' : 'DAYS' }}</span>
                                                </div>
                                            </div>
                                            <div style="display: flex; flex-direction: column; gap: 1px;">
                                                <span style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8;">Trial Validity</span>
                                                <!-- <span style="font-size: 11.5px; font-weight: 600; color: #fff;">{{ $remaining }} {{ $remaining === 1 ? 'day' : 'days' }} left</span> -->
                                            </div>
                                        </div>
                                        <span class="demo-status-badge {{ $extensionActive ? 'extension' : ($demoActive ? 'active' : 'expired') }}" style="font-size: 10px; padding: 2px 7px; white-space: nowrap;">
                                            <i class="fa-solid {{ $extensionActive ? 'fa-clock' : ($demoActive ? 'fa-circle-play' : 'fa-circle-xmark') }}"></i>
                                            {{ $extensionActive ? 'Extension' : ($demoActive ? 'Active' : 'Expired') }}
                                        </span>
                                    </div>
                                </li>
                                @endif
                                <li>
                                    <a href="javascript:void(0)" class="profile-dropdown-item" onclick="startPlatformTour()">
                                        <i class="fa-solid fa-compass" style="color: #60a5fa;"></i>
                                        <span>Take Dashboard Tour</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/accounts/manage-password" class="profile-dropdown-item">
                                        <i class="fa-solid fa-gear"></i>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="profile-dropdown-item" onclick="toggleAppTheme()">
                                        <i class="fa-regular fa-moon theme-toggle-icon"></i>
                                        <span class="theme-toggle-label">Theme Mode</span>
                                    </a>
                                </li>
                                @if(auth()->user()->isAdmin())
                                <li>
                                    <a href="/admin" class="profile-dropdown-item" style="color: #fbbf24;">
                                        <i class="fa-solid fa-shield-halved" style="color: #f59e0b;"></i>
                                        <span>Admin Panel</span>
                                    </a>
                                </li>
                                @endif
                                <div class="profile-dropdown-divider"></div>
                                <li>
                                    <a href="#" class="profile-dropdown-item item-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        <span>Sign Out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">

                <!-- Container for Dashboard Cards & Overview -->
                <div id="dashboardCardsContainer" class="dashboard-cards-container">
                    <!-- Unified Welcome & Account Single-Row Card -->
                    <div class="welcome-account-card">
                        <!-- Left: Avatar & Welcome Info -->
                        <div class="welcome-info-main">
                            <div class="avatar-circle">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="welcome-text">
                                <h2>Welcome back, {{ auth()->user()->name }} {{ auth()->user()->lname }}!</h2>
                                <p style="margin-bottom: 2px;">{{ auth()->user()->email }}</p>
                                <button type="button" class="btn-become-publisher" id="openPublisherModalBtn">
                                    <i class="fa-solid fa-feather-pointed"></i>
                                    <span>Become a Publisher</span>
                                    <span class="badge-publisher-pill">PRO</span>
                                </button>
                            </div>
                        </div>

                        <!-- Right: Meta Row (Account Type, Profession) -->
                        <div class="welcome-meta-row">
                            @if($userType)
                            <div class="welcome-meta-item">
                                <span class="meta-label">Account Type</span>
                                <div class="meta-value">
                                    <span class="type-badge {{ $userType }}">
                                        @if($userType === 'researcher')
                                            <i class="fa-solid fa-microscope"></i>
                                        @elseif($userType === 'student')
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        @elseif($userType === 'lawyer')
                                            <i class="fa-solid fa-scale-balanced"></i>
                                        @endif
                                        {{ ucfirst($userType) }}
                                    </span>
                                </div>
                            </div>
                            @endif

                            @if($userType === 'researcher' && $researcherTypeLabel)
                            <div class="welcome-meta-divider"></div>
                            <div class="welcome-meta-item">
                                <span class="meta-label">Profession</span>
                                <div class="meta-value">
                                    <span class="type-badge profession-badge">
                                        <i class="fa-solid fa-briefcase"></i>
                                        {{ $researcherTypeLabel }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($extensionActive)
                            <div class="demo-warning-banner extension-warn" style="width: 100%; margin-top: 12px;">
                                <i class="fa-solid fa-triangle-exclamation" style="font-size: 18px;"></i>
                                <span>Your main demo period has ended. You have <strong>{{ $remaining }} day{{ $remaining !== 1 ? 's' : '' }}</strong> left in your extension. Subscribe to keep full access.</span>
                            </div>
                        @elseif($demoUsed && !$isDemo)
                            <div class="demo-warning-banner expired-warn" style="width: 100%; margin-top: 12px;">
                                <i class="fa-solid fa-lock" style="font-size: 18px;"></i>
                                <span>Your demo period has expired. Subscribe to regain full access to all platform features.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- In-Dashboard Page Viewer Workspace -->
                <div id="dashboardViewerContainer" class="dashboard-viewer-container" style="display: none;">
                    <div class="dashboard-viewer-bar">
                        <button type="button" class="btn-viewer-back" id="closeViewerBtn">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Dashboard Hub</span>
                        </button>
                        <div class="viewer-title-wrap">
                            <i class="fa-solid fa-book-open" style="color: #60a5fa;"></i>
                            <span id="viewerPageTitle">Legal Records</span>
                        </div>
                        <div class="viewer-actions-wrap">
                            <button type="button" class="btn-viewer-icon" id="reloadViewerBtn" title="Reload View">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                            <a href="#" id="openNewTabBtn" target="_blank" class="btn-viewer-icon" title="Open in New Tab">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>

                    <div class="viewer-frame-wrapper">
                        <iframe id="dashboardViewerFrame" class="dashboard-viewer-frame" src="about:blank" frameborder="0"></iframe>
                        <div id="viewerLoadingSpinner" class="viewer-loader">
                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                            <span>Loading page into dashboard...</span>
                        </div>
                </div>

                <!-- Publisher Modal -->
                <div class="publisher-modal-overlay" id="publisherModalOverlay">
                    <div class="publisher-modal-card">
                        <button type="button" class="publisher-modal-close" id="closePublisherModalBtn">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                            <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: center; font-size: 20px; color: #fbbf24;">
                                <i class="fa-solid fa-feather-pointed"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 18px; font-weight: 700; margin: 0; color: var(--text-primary);">Become a Publisher</h3>
                                <p style="font-size: 12.5px; color: var(--text-secondary); margin: 2px 0 0 0;">Share legal articles, commentary & case insights</p>
                            </div>
                        </div>

                        <p style="font-size: 13.5px; line-height: 1.6; color: var(--text-secondary);">
                            Join our prestigious network of legal authors, academics, and jurists. Publish your commentaries, legislative analyses, and case summaries to thousands of active legal researchers.
                        </p>

                        <div class="publisher-feature-list">
                            <div class="publisher-feature-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span><strong>Verified Author Badge</strong> attached to your profile and publications</span>
                            </div>
                            <div class="publisher-feature-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span><strong>Direct Reach</strong> to legal professionals, law faculties, and researchers</span>
                            </div>
                            <div class="publisher-feature-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span><strong>Editorial Support</strong> & peer-reviewed publishing pipeline</span>
                            </div>
                        </div>

                        <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 12px; padding: 14px; margin-bottom: 20px;">
                            <div style="font-size: 12px; color: #fbbf24; font-weight: 600; margin-bottom: 4px;">APPLICATION DETAILS</div>
                            <div style="font-size: 13px; color: var(--text-primary);">Applying as: <strong>{{ auth()->user()->name }} {{ auth()->user()->lname }}</strong> ({{ auth()->user()->email }})</div>
                        </div>

                        <button type="button" class="btn-publisher-submit" onclick="alert('Thank you! Your publisher application has been submitted. Our editorial team will contact you shortly at {{ auth()->user()->email }}.'); document.getElementById('publisherModalOverlay').classList.remove('show');">
                            <i class="fa-solid fa-paper-plane mr-1"></i> Submit Publisher Application
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle (Desktop)
        const sidebar = document.getElementById('dashboardSidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                // Save preference
                localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
            });
        }

        // Restore sidebar state (desktop only)
        if (window.innerWidth > 768 && localStorage.getItem('sidebar_collapsed') === '1') {
            sidebar.classList.add('collapsed');
        }

        // Mobile Sidebar Drawer functions
        function openMobileSidebar() {
            const sb = document.getElementById('dashboardSidebar');
            const bd = document.getElementById('sidebarBackdrop');
            if (sb) sb.classList.add('mobile-open');
            if (bd) bd.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileSidebar() {
            const sb = document.getElementById('dashboardSidebar');
            const bd = document.getElementById('sidebarBackdrop');
            if (sb) sb.classList.remove('mobile-open');
            if (bd) bd.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Sidebar User Card Popover Menu Toggle
        function toggleSidebarUserMenu(e) {
            if (e) e.stopPropagation();
            const userMenu = document.getElementById('sidebarUserDropdown');
            const userCard = document.getElementById('sidebarUserCard');
            if (userMenu) {
                userMenu.classList.toggle('show');
                userCard?.classList.toggle('active');
            }
        }

        // Close sidebar user menu when clicking outside
        document.addEventListener('click', function(e) {
            const userMenu = document.getElementById('sidebarUserDropdown');
            const userCard = document.getElementById('sidebarUserCard');
            if (userMenu && userMenu.classList.contains('show')) {
                if (!userMenu.contains(e.target) && (!userCard || !userCard.contains(e.target))) {
                    userMenu.classList.remove('show');
                    userCard?.classList.remove('active');
                }
            }
        });

        // Submenu Accordion Toggle for Legal Library
        window.toggleSidebarSubmenu = function(submenuId, triggerEl) {
            const submenu = document.getElementById(submenuId);
            const parentItem = triggerEl.closest('.menu-item-has-submenu');
            if (!submenu || !parentItem) return;

            const isOpen = submenu.classList.contains('show');
            if (isOpen) {
                submenu.classList.remove('show');
                parentItem.classList.remove('open');
            } else {
                // Close other open submenus for accordion behavior
                document.querySelectorAll('.sidebar-submenu-list.show').forEach(function(list) {
                    if (list.id !== submenuId) {
                        list.classList.remove('show');
                        list.closest('.menu-item-has-submenu')?.classList.remove('open');
                    }
                });
                submenu.classList.add('show');
                parentItem.classList.add('open');
            }
        };

        // Close mobile sidebar on navigation click (except submenu toggles)
        document.querySelectorAll('#dashboardSidebar .sidebar-menu a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (link.classList.contains('sidebar-submenu-toggle')) {
                    return;
                }
                if (window.innerWidth <= 768) {
                    closeMobileSidebar();
                }
            });
        });

        // Profile Dropdown Toggle
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdownMenu = document.getElementById('profileDropdownMenu');

        if (profileDropdownBtn && profileDropdownMenu) {
            profileDropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = profileDropdownMenu.classList.contains('show');
                profileDropdownMenu.classList.toggle('show');
                profileDropdownBtn.classList.toggle('active');
                profileDropdownBtn.setAttribute('aria-expanded', !isOpen);
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                    profileDropdownMenu.classList.remove('show');
                    profileDropdownBtn.classList.remove('active');
                    profileDropdownBtn.setAttribute('aria-expanded', 'false');
                }
            });

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    profileDropdownMenu.classList.remove('show');
                    profileDropdownBtn.classList.remove('active');
                    profileDropdownBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }

        // Theme Switcher (Dark / Light Mode)
        function toggleAppTheme() {
            const current = document.documentElement.getAttribute('data-theme') || 'dark';
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateThemeIcons(next);
        }

        function updateThemeIcons(theme) {
            document.querySelectorAll('.theme-toggle-icon').forEach(icon => {
                if (theme === 'light') {
                    icon.className = 'fa-solid fa-sun theme-toggle-icon';
                    icon.style.color = '#f59e0b';
                } else {
                    icon.className = 'fa-regular fa-moon theme-toggle-icon';
                    icon.style.color = '';
                }
            });
            document.querySelectorAll('.theme-toggle-label').forEach(label => {
                label.textContent = theme === 'light' ? 'Light Theme' : 'Dark Theme';
            });
        }

        // Initialize Theme on Load
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        updateThemeIcons(currentTheme);

        // ── In-Dashboard Page Viewer Workspace ─────────────
        const cardsContainer = document.getElementById('dashboardCardsContainer');
        const viewerContainer = document.getElementById('dashboardViewerContainer');
        const viewerFrame = document.getElementById('dashboardViewerFrame');
        const viewerSpinner = document.getElementById('viewerLoadingSpinner');
        const viewerTitle = document.getElementById('viewerPageTitle');
        const closeViewerBtn = document.getElementById('closeViewerBtn');
        const reloadViewerBtn = document.getElementById('reloadViewerBtn');
        const openNewTabBtn = document.getElementById('openNewTabBtn');

        function openInDashboard(url, title) {
            if (!url || url === '#' || url.startsWith('javascript:')) return;

            // Automatically collapse sidebar to accommodate full page
            if (sidebar && !sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('collapsed');
                localStorage.setItem('sidebar_collapsed', '1');
            }

            if (viewerTitle && title) {
                viewerTitle.textContent = title;
            }

            if (openNewTabBtn) {
                openNewTabBtn.href = url;
            }

            // Show viewer, hide cards
            if (cardsContainer) cardsContainer.style.display = 'none';
            if (viewerContainer) viewerContainer.style.display = 'flex';
            if (viewerSpinner) viewerSpinner.classList.remove('hidden');

            // Format URL with embedded parameter if needed
            let frameUrl = url;
            const separator = frameUrl.indexOf('?') !== -1 ? '&' : '?';
            if (frameUrl.indexOf('embedded=1') === -1) {
                frameUrl += separator + 'embedded=1';
            }

            // Update iframe src
            if (viewerFrame.src !== frameUrl) {
                viewerFrame.src = frameUrl;
            } else {
                if (viewerSpinner) viewerSpinner.classList.add('hidden');
            }

            // Update browser history URL
            try {
                const newUrl = '/home?view=' + encodeURIComponent(url);
                window.history.pushState({ view: url, title: title }, '', newUrl);
            } catch (e) {}

            // Scroll to top of content
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function closeDashboardViewer() {
            if (viewerContainer) viewerContainer.style.display = 'none';
            if (cardsContainer) cardsContainer.style.display = 'block';
            if (viewerFrame) viewerFrame.src = 'about:blank';
            try {
                window.history.pushState({}, '', '/home');
            } catch (e) {}
        }

        if (viewerFrame && viewerSpinner) {
            viewerFrame.addEventListener('load', function() {
                viewerSpinner.classList.add('hidden');
                try {
                    // Inject embedded class into iframe document if accessible
                    const iframeDoc = viewerFrame.contentDocument || viewerFrame.contentWindow.document;
                    if (iframeDoc) {
                        iframeDoc.documentElement.classList.add('is-embedded');
                        if (iframeDoc.body) iframeDoc.body.classList.add('is-embedded');
                        const nav = iframeDoc.getElementById('mainNav');
                        if (nav) nav.style.display = 'none';
                        const wrap = iframeDoc.querySelector('.main-wrapper-scrollable') || iframeDoc.querySelector('.workspace-wrapper');
                        if (wrap) {
                            wrap.style.top = '0px';
                            wrap.style.height = '100vh';
                        }
                    }
                } catch(e) {}
            });
        }

        if (closeViewerBtn) {
            closeViewerBtn.addEventListener('click', closeDashboardViewer);
        }

        if (reloadViewerBtn && viewerFrame) {
            reloadViewerBtn.addEventListener('click', function() {
                if (viewerSpinner) viewerSpinner.classList.remove('hidden');
                viewerFrame.contentWindow.location.reload();
            });
        }

        // Intercept top header menu links (Constitution, Existing Laws, New Laws, Case Laws, etc.)
        document.querySelectorAll('.top-header-nav a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;
                
                // Allow Quick Search to navigate directly to homepage
                if (this.classList.contains('quick-search-btn')) return;

                // If it's a dropdown trigger without an active page link, let dropdown open
                if (this.classList.contains('nav-sub-dropdown-trigger')) return;

                e.preventDefault();
                const linkTitle = this.textContent.trim();
                openInDashboard(href, linkTitle);
            });
        });

        // Intercept "Laws Catalog" links
        document.querySelectorAll('.portal-card[href="/"], .sidebar-menu a[href="/"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                openInDashboard('/', 'Laws Catalog');
            });
        });

        // Publisher Modal Toggle
        const openPublisherModalBtn = document.getElementById('openPublisherModalBtn');
        const publisherModalOverlay = document.getElementById('publisherModalOverlay');
        const closePublisherModalBtn = document.getElementById('closePublisherModalBtn');

        if (openPublisherModalBtn && publisherModalOverlay) {
            openPublisherModalBtn.addEventListener('click', function() {
                publisherModalOverlay.classList.add('show');
            });

            if (closePublisherModalBtn) {
                closePublisherModalBtn.addEventListener('click', function() {
                    publisherModalOverlay.classList.remove('show');
                });
            }

            publisherModalOverlay.addEventListener('click', function(e) {
                if (e.target === publisherModalOverlay) {
                    publisherModalOverlay.classList.remove('show');
                }
            });
        }

        // Handle initial load with ?view= query parameter or back/forward navigation
        window.addEventListener('popstate', function(e) {
            const urlParams = new URLSearchParams(window.location.search);
            const viewParam = urlParams.get('view');
            if (viewParam) {
                openInDashboard(viewParam, 'Legal Records');
            } else {
                closeDashboardViewer();
            }
        });

        const initialView = new URLSearchParams(window.location.search).get('view');
        if (initialView) {
            openInDashboard(initialView, 'Legal Records');
        }
    </script>

@include('partials._platform_tour_modal')
@include('partials._bookmark_script')
@include('partials._premium_guest_gate')

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
