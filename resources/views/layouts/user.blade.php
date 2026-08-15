<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'User Portal') | Legals Forum</title>

    <!-- Theme Initialization to Prevent Flash of Unstyled Content -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.06) 0%, transparent 60%);
            --card-bg: rgba(13, 20, 38, 0.6);
            --card-hover: rgba(20, 30, 55, 0.8);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(59, 130, 246, 0.4);
            --accent-color: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.3);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --text-muted: #6b7280;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --sidebar-width: 260px;
            --sidebar-collapsed: 72px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            overflow-x: hidden;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar Navigation ─────────────────────────── */
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
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--accent-gradient);
            box-shadow: 0 6px 16px var(--accent-glow);
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            font-size: 17px;
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

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 14px 16px 24px 16px;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            flex-shrink: 0;
            background: rgba(8, 12, 28, 0.98);
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 14px 0 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: transparent;
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
        }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: var(--accent-color);
            flex-shrink: 0;
            transition: var(--transition-smooth);
        }

        .sidebar.collapsed .sidebar-avatar {
            width: 40px;
            height: 40px;
            font-size: 15px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(29, 78, 216, 0.15) 100%);
            border: 1.5px solid rgba(59, 130, 246, 0.4);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .sidebar.collapsed .sidebar-user-card:hover .sidebar-avatar {
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

        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .sidebar-user-role {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* ── Main Content Area ───────────────────────────── */
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

        .top-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
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
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition-smooth);
            position: relative;
            text-decoration: none;
        }

        .header-icon-btn:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.15);
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

        /* ── Header Quick Search Button ──────────────────── */
        .quick-search-header-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 14px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none !important;
            transition: var(--transition-smooth);
            margin-right: 4px;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
        }

        .quick-search-header-btn:hover {
            background: rgba(59, 130, 246, 0.24);
            border-color: rgba(59, 130, 246, 0.6);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.25);
        }

        .quick-search-header-btn i {
            font-size: 12px;
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
            z-index: 999;
            overflow: hidden;
        }

        .profile-menu-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .profile-dropdown-header {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(255, 255, 255, 0.02);
        }

        .profile-header-name {
            font-size: 14.5px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-header-email {
            font-size: 12px;
            color: #94a3b8;
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

        /* ── Dashboard / Inner Page Content ──────────────── */
        .dashboard-content {
            padding: 32px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Standardized Card & Form Styles ─────────────── */
        .content-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            transition: var(--transition-smooth);
        }

        .card-title {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
            letter-spacing: -0.4px;
        }

        .card-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        /* Tables */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .dashboard-table th {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-secondary);
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .dashboard-table td {
            padding: 16px 18px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        .dashboard-table tbody tr {
            transition: var(--transition-smooth);
        }

        .dashboard-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .dashboard-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-blue {
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.25);
        }

        .badge-green {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .badge-amber {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        /* Button styles */
        .btn-primary,
        .btn-action-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 28px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.3px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(37, 99, 235, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none !important;
            outline: none;
        }

        .btn-primary:hover,
        .btn-action-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #2563eb 100%);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.3);
            color: #ffffff !important;
        }

        .btn-primary:active,
        .btn-action-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.3);
        }

        .btn-primary i,
        .btn-action-primary i {
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .btn-primary:hover i,
        .btn-action-primary:hover i {
            transform: scale(1.15);
        }

        .btn-action-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .btn-action-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(59, 130, 246, 0.4);
            color: #60a5fa;
        }

        .btn-action-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #f87171;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .btn-action-danger:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-muted);
            font-size: 15px;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px 12px 46px;
            color: var(--text-primary);
            font-size: 14px;
            font-family: inherit;
            transition: var(--transition-smooth);
            outline: none;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        /* Alert Banners */
        .alert-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13.5px;
        }

        .alert-banner-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #34d399;
        }

        .alert-banner-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #f87171;
        }

        /* ── Light Theme Overrides ───────────────────────── */
        [data-theme="light"] {
            --bg-primary: #f4f6fb;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 60%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --border-color: rgba(0, 0, 0, 0.08);
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
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
            background: rgba(0, 0, 0, 0.02);
        }

        [data-theme="light"] .profile-header-name {
            color: #0f172a;
        }

        [data-theme="light"] .profile-header-email {
            color: #64748b;
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

        [data-theme="light"] .content-card {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        [data-theme="light"] .card-title {
            color: #0f172a;
        }

        [data-theme="light"] .dashboard-table th {
            background: #f8fafc;
            color: #64748b;
        }

        [data-theme="light"] .dashboard-table td {
            color: #0f172a;
        }

        [data-theme="light"] .dashboard-table tbody tr:hover {
            background: #f8fafc;
        }

        [data-theme="light"] .form-control {
            background: #f8fafc;
            border-color: rgba(0, 0, 0, 0.1);
            color: #0f172a;
        }

        [data-theme="light"] .form-control:focus {
            background: #ffffff;
            border-color: rgba(59, 130, 246, 0.6);
        }

        [data-theme="light"] .btn-action-secondary {
            background: #f1f5f9;
            border-color: rgba(0, 0, 0, 0.08);
            color: #0f172a;
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
                gap: 8px !important;
            }
            .quick-search-header-btn {
                padding: 7px 12px !important;
                flex: 1;
                max-width: 160px;
                justify-content: center;
                gap: 6px !important;
            }
            .quick-search-header-btn span {
                display: inline !important;
                font-size: 12px !important;
                white-space: nowrap;
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

    @yield('styles')
</head>
<body>
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
                <li class="menu-item {{ request()->is('home*') ? 'active' : '' }}">
                    <a href="/home">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-label">My Library</li>
                <li class="menu-item {{ (request()->is('accounts/bookmarks*') || request()->is('bookmarks*')) ? 'active' : '' }}">
                    <a href="/accounts/bookmarks/{{ auth()->user()->id }}">
                        <i class="fa-solid fa-bookmark"></i>
                        <span>Bookmarks</span>
                        @php
                            $sidebarBookmarksCount = \App\UserBookmark::where('user_id', auth()->id())->count();
                        @endphp
                        @if($sidebarBookmarksCount > 0)
                            <span class="menu-badge">{{ $sidebarBookmarksCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ (request()->is('accounts/notes*') || request()->is('notes*')) ? 'active' : '' }}">
                    <a href="/accounts/notes/{{ auth()->user()->id }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Notes</span>
                        @php
                            $sidebarNotesCount = \App\UserNote::where('user_id', auth()->id())->count();
                        @endphp
                        @if($sidebarNotesCount > 0)
                            <span class="menu-badge">{{ $sidebarNotesCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ (request()->is('accounts/downloads*') || request()->is('downloads*')) ? 'active' : '' }}">
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

                @if(auth()->user()->isAdmin())
                <li class="menu-label">Admin</li>
                <li class="menu-item {{ request()->is('admin*') ? 'active' : '' }}">
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
                        <div class="sidebar-logo-icon" style="width: 32px; height: 32px; font-size: 14px;">
                            <i class="fa fa-balance-scale"></i>
                        </div>
                        <span style="font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -0.3px;">Legals Forum</span>
                    </a>
                    <h1 class="top-header-title">@yield('title', 'Dashboard')</h1>
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

            <!-- Main Page Content -->
            <div class="dashboard-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Interactive Scripts -->
    <script>
        // Sidebar Toggle (Desktop)
        const sidebar = document.getElementById('dashboardSidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        if (sidebar && toggleBtn) {
            // Restore previous collapsed state (desktop only)
            if (window.innerWidth > 768 && localStorage.getItem('dashboard_sidebar_collapsed') === 'true') {
                sidebar.classList.add('collapsed');
            }

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('dashboard_sidebar_collapsed', sidebar.classList.contains('collapsed'));
            });
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

        // Close mobile sidebar on navigation click
        document.querySelectorAll('#dashboardSidebar .sidebar-menu a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeMobileSidebar();
                }
            });
        });

        // Profile Dropdown Toggle
        const profileBtn = document.getElementById('profileDropdownBtn');
        const profileMenu = document.getElementById('profileDropdownMenu');
        const profileContainer = document.getElementById('profileDropdownContainer');

        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = profileMenu.classList.contains('show');
                if (isOpen) {
                    profileMenu.classList.remove('show');
                    profileBtn.setAttribute('aria-expanded', 'false');
                    profileBtn.classList.remove('active');
                } else {
                    profileMenu.classList.add('show');
                    profileBtn.setAttribute('aria-expanded', 'true');
                    profileBtn.classList.add('active');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (profileContainer && !profileContainer.contains(e.target)) {
                    profileMenu.classList.remove('show');
                    profileBtn.setAttribute('aria-expanded', 'false');
                    profileBtn.classList.remove('active');
                }
            });

            // Close dropdown on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && profileMenu.classList.contains('show')) {
                    profileMenu.classList.remove('show');
                    profileBtn.setAttribute('aria-expanded', 'false');
                    profileBtn.classList.remove('active');
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

        // Intercept top header menu links to open in dashboard
        document.querySelectorAll('.top-header-nav a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;
                if (this.classList.contains('nav-sub-dropdown-trigger')) return;

                e.preventDefault();
                localStorage.setItem('dashboard_sidebar_collapsed', 'true');
                window.location.href = '/home?view=' + encodeURIComponent(href);
            });
        });
    </script>

    @include('partials._platform_tour_modal')
    @yield('scripts')
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
