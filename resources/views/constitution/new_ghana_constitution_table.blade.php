<!doctype html>
<html lang="en">
  <head>
    <script data-ad-client="ca-pub-4293461101625028" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Read and search the Constitution of the Republic of Ghana 1992 on LawsGhana.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ucwords(strtolower($ghana_act['title']))}} — LawsGhana</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('logo/favicon/site.webmanifest') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ============================================
           THEME & CSS VARIABLES
           ============================================ */
        :root {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.65);
            --card-bg-hover: rgba(25, 35, 55, 0.8);
            --border-color: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.12);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-glow: rgba(245, 158, 11, 0.2);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            font-family: var(--font);
            background-color: var(--bg-primary);
            color: var(--text-primary);
            height: 100vh;
            min-height: 100vh;
            overflow: hidden;
            padding-top: 70px; /* offset for fixed navbar */
        }

        /* ============================================
           PREMIUM FIXED NAVIGATION BAR
           ============================================ */
        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            z-index: 1000;
            background: rgba(6, 10, 19, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }

        .nav-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo img {
            height: 38px;
            width: auto;
            transition: transform 0.3s ease;
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
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 8px 14px;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link-btn i {
            font-size: 10px;
            color: var(--text-muted);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            text-align: left;
            text-decoration: none !important;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 6px 0;
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            padding: 8px 18px;
            border-radius: 8px;
            border: 1px solid var(--border-hover);
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .btn-signup {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            padding: 8px 18px;
            border-radius: 8px;
            border: none;
            background: var(--accent-gradient);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px var(--accent-glow);
        }

        /* User dropdown */
        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-user-btn:hover {
            background: var(--card-bg-hover);
        }

        .nav-user-btn i {
            color: var(--accent-light);
        }

        .nav-user-dropdown:hover .nav-dropdown-menu,
        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu a.logout-link {
            color: #f43f5e;
        }

        .nav-dropdown-menu a.logout-link:hover {
            background: rgba(244, 63, 94, 0.1);
        }

        /* ============================================
           THREE PANEL WORKSPACE LAYOUT
           ============================================ */
        .workspace-wrapper {
            display: flex;
            height: calc(100vh - 70px);
            width: 100vw;
            position: fixed;
            top: 70px;
            left: 0;
            overflow: hidden;
            background: var(--bg-primary);
        }

        .workspace-sidebar {
            width: 300px;
            min-width: 300px;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 10;
        }

        .right-sidebar {
            width: 320px;
            min-width: 320px;
            border-right: none;
            border-left: 1px solid var(--border-color);
        }

        .workspace-sidebar.collapsed {
            width: 0 !important;
            min-width: 0 !important;
            overflow: hidden;
            border: none !important;
        }

        .sidebar-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-header h6 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-primary);
            margin: 0;
        }

        .toggle-sidebar-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .toggle-sidebar-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-search {
            padding: 12px 20px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .sidebar-search i {
            position: absolute;
            left: 32px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
        }

        .sidebar-search input {
            width: 100%;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            padding: 8px 12px 8px 34px;
            font-size: 13px;
            outline: none;
            transition: all 0.3s ease;
        }

        .sidebar-search input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        /* Restore buttons when sidebar is collapsed */
        .sidebar-restore-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 48px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            transition: all 0.2s ease;
            outline: none;
        }

        .left-restore {
            left: 0;
            border-left: none;
            border-radius: 0 8px 8px 0;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }

        .right-restore {
            right: 0;
            border-right: none;
            border-radius: 8px 0 0 8px;
            box-shadow: -4px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar-restore-btn:hover {
            color: var(--text-primary);
            background: var(--card-bg-hover);
        }

        /* Center reading workspace */
        .workspace-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            background: var(--bg-primary);
            overflow: hidden;
            position: relative;
            border-right: none;
        }

        .reading-toolbar {
            height: 56px;
            min-height: 56px;
            border-bottom: 1px solid var(--border-color);
            background: rgba(12, 18, 32, 0.4);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-wrap: nowrap !important;
        }

        .nav-tabs-premium {
            display: flex;
            gap: 4px;
            border: none !important;
            flex-wrap: nowrap !important;
        }

        .nav-tab-premium {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: var(--text-secondary) !important;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid var(--border-color) !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            white-space: nowrap !important;
            gap: 8px !important;
        }

        .nav-tab-premium:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .nav-tab-premium.active {
            color: #fff !important;
            background: var(--accent-gradient) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 4px 12px var(--accent-glow) !important;
        }

        /* Premium Split View Layout */
        .split-view-container {
            display: flex;
            width: 100%;
            height: calc(100vh - 150px);
            gap: 16px;
            padding: 16px;
            background: var(--bg-primary);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .split-view-container.split-direction-horizontal {
            flex-direction: row;
        }

        .split-view-container.split-direction-vertical {
            flex-direction: column;
        }

        .split-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: rgba(30, 41, 59, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.25s ease;
            position: relative;
            cursor: pointer;
        }

        .split-panel.active {
            background: rgba(30, 41, 59, 0.45);
            border: 2px solid var(--accent);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.15);
        }

        .split-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: rgba(15, 23, 42, 0.6);
            border-bottom: 1px solid var(--border-color);
        }

        .panel-badge {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.05);
            padding: 2px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .split-panel.active .panel-badge {
            color: var(--gold);
            background: rgba(212, 175, 55, 0.15);
        }

        .loaded-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .split-panel-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.6;
        }

        .split-panel-body .highlight-match {
            background: rgba(212, 175, 55, 0.3) !important;
            color: #fff !important;
            border-bottom: 2px solid var(--gold);
            border-radius: 2px;
        }

        .split-panel-body .active-match {
            background: var(--gold) !important;
            color: #000 !important;
        }
        
        /* Layout direction switcher in toolbar */
        .split-layout-controls {
            display: flex;
            align-items: center;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2px;
            gap: 2px;
        }
        
        .split-layout-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        
        .split-layout-btn.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .split-layout-btn:hover:not(.active) {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .tab-hidden-initially {
            display: none !important;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .font-adjuster {
            display: flex;
            align-items: center;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2px;
        }

        .font-adjuster button {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .font-adjuster button:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .font-adjuster span {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
            padding: 0 10px;
            user-select: none;
        }

        .toolbar-icon-btn {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .toolbar-icon-btn:hover {
            color: var(--text-primary);
            border-color: var(--border-hover);
            background: rgba(255, 255, 255, 0.05);
        }

        .workspace-body {
            flex: 1;
            overflow-y: auto;
            padding: 32px 40px;
        }

        /* Reading view containers */
        .reader-container, .expanded-container {
            max-width: 820px;
            margin: 0 auto;
        }

        .preamble-card {
            background: rgba(245, 158, 11, 0.05);
            border: 1px solid rgba(245, 158, 11, 0.15);
            border-radius: 12px;
            padding: 16px 24px;
            text-align: center;
            margin-bottom: 24px;
        }

        .toc-welcome {
            text-align: center;
            max-width: 500px;
            margin: 80px auto 0;
            color: var(--text-secondary);
        }

        .toc-welcome h5 {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .toc-welcome p {
            font-size: 14px;
            line-height: 1.6;
        }

        /* ============================================
           COLLAPSIBLE CHAPTER ACCORDION TREE (Left Pane)
           ============================================ */
        .btn-outlined {
            background: rgba(245, 158, 11, 0.1) !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            color: var(--gold) !important;
            font-weight: 700 !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
            width: 100%;
            font-size: 12px !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px var(--gold-glow);
        }

        .btn-outlined:hover {
            background: rgba(245, 158, 11, 0.2) !important;
            border-color: var(--gold) !important;
            box-shadow: 0 6px 18px var(--gold-glow);
            transform: translateY(-1px);
        }

        .panel-group .panel {
            background: transparent !important;
            border: none !important;
            margin-bottom: 8px !important;
        }

        .panel-heading {
            background: rgba(17, 24, 39, 0.35) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
            transition: all 0.3s ease;
        }

        .panel-heading:hover {
            border-color: var(--border-hover) !important;
            background: rgba(17, 24, 39, 0.5) !important;
        }

        .panel-heading a {
            color: var(--text-primary) !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            text-decoration: none !important;
        }

        .panel-heading a.collapsed {
            color: var(--text-secondary) !important;
        }

        .panel-heading a::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 10px;
            color: var(--text-muted);
            transition: transform 0.3s ease;
        }

        .panel-heading a:not(.collapsed)::after {
            transform: rotate(180deg);
            color: var(--accent-light);
        }

        .panel-body {
            padding: 8px 0 8px 16px !important;
            border-top: none !important;
        }

        .panel-body ul {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .panel-body li {
            margin: 4px 0 !important;
            position: relative;
        }

        .panel-body li::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 13px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--text-muted);
        }

        .panel-body a.constitution_content_link {
            display: block !important;
            padding: 6px 10px !important;
            color: wheat !important;
            border-radius: 6px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
        }

        .panel-body a.constitution_content_link:hover {
            background: rgba(59, 130, 246, 0.08) !important;
            color: var(--accent-light) !important;
            padding-left: 14px !important;
        }

        .constitution_preamble_link {
            display: inline-block;
            font-size: 14px;
            font-weight: 700;
            color: var(--accent-light) !important;
            text-decoration: none !important;
        }

        /* ============================================
           SIDEBAR MODULER STRUCTURING (Right Pane)
           ============================================ */
        .workspace-sidebar .mobile-filter-hide {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .workspace-sidebar .sidebar {
            width: 100% !important;
            max-width: 100% !important;
            position: static !important;
            padding: 0 !important;
        }

        .workspace-sidebar .card {
            width: 100% !important;
            max-width: 100% !important;
            background: rgba(17, 24, 39, 0.45) !important;
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            color: var(--text-primary) !important;
            margin-bottom: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .workspace-sidebar .card-header {
            background: rgba(255, 255, 255, 0.02) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            font-weight: 700 !important;
            font-size: 12px !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 16px !important;
        }

        .workspace-sidebar .card-body {
            padding: 16px !important;
        }

        .dropdown-toggle.btn-outline-dark {
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.03) !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            width: 100% !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }

        .dropdown-toggle.btn-outline-dark:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: var(--border-hover) !important;
        }

        .dropdown-menu {
            background: rgba(17, 24, 39, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.5) !important;
            padding: 6px !important;
        }

        .dropdown-item {
            color: var(--text-secondary) !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            border-radius: 6px !important;
            padding: 8px 14px !important;
            transition: all 0.2s ease !important;
        }

        .dropdown-item:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .scroll-view {
            max-height: 280px !important;
            overflow-y: auto !important;
        }

        /* ============================================
           DYNAMICAL INNER ARTICLE OVERRIDES
           ============================================ */
        #display_content, #acts_expanded_view {
            color: var(--text-primary) !important;
            transition: font-size 0.25s ease;
        }

        #display_content .nav-links, #acts_expanded_view .nav-links {
            background: rgba(59, 130, 246, 0.08) !important;
            border: 1px solid rgba(59, 130, 246, 0.15) !important;
            color: var(--accent-light) !important;
            border-radius: 8px !important;
            padding: 12px 18px !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            margin-bottom: 20px !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.05);
            display: block;
            position: static !important;
        }

        #display_content .content, #acts_expanded_view .content {
            font-size: 1em !important;
            line-height: 1.8 !important;
            color: var(--text-primary) !important;
            padding: 10px 0 !important;
        }

        #display_content .content p, #acts_expanded_view .content p {
            margin-bottom: 20px !important;
        }

        #display_content .content u, #acts_expanded_view .content u {
            color: var(--gold) !important;
            text-decoration: none !important;
            border-bottom: 1px dashed var(--gold);
            padding-bottom: 2px;
        }

        #display_content a#print_options, #acts_expanded_view a#print_options {
            color: var(--accent-light) !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            text-decoration: none !important;
        }

        #display_content .menu_options, #acts_expanded_view .menu_options {
            background: rgba(17, 24, 39, 0.85) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            padding: 12px 18px !important;
            margin-top: 10px !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
        }

        #display_content .menu_options a, #acts_expanded_view .menu_options a {
            color: var(--text-secondary) !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            text-decoration: none !important;
        }

        #display_content .menu_options a:hover, #acts_expanded_view .menu_options a:hover {
            color: var(--text-primary) !important;
        }

        .previous_content_constitution_act, .next_content_constitution_act {
            border-color: var(--border-color) !important;
            color: var(--text-secondary) !important;
            background: rgba(255, 255, 255, 0.02) !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
        }

        .previous_content_constitution_act:hover, .next_content_constitution_act:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-hover) !important;
        }

        /* Continent / Sub-navigation */
        .continent-nav-wrap {
            max-width: 1440px;
            margin: 0 auto;
            padding: 16px 24px 0 24px;
        }

        /* ============================================
           MODAL & TABLE CUSTOMIZATION
           ============================================ */
        .modal-content {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6) !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color) !important;
        }

        .modal-header .close {
            color: var(--text-primary) !important;
            text-shadow: none !important;
            opacity: 0.8;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        #datatable {
            color: var(--text-secondary) !important;
        }

        #datatable th {
            border-bottom: 2px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            text-transform: uppercase;
        }

        #datatable td {
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-secondary) !important;
            font-size: 14px !important;
        }

        #datatable tr:hover td {
            background: rgba(255, 255, 255, 0.02) !important;
            color: var(--text-primary) !important;
        }

        #datatable td a {
            color: var(--accent-light) !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }

        #datatable td a:hover {
            text-decoration: underline !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            font-size: 13px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: rgba(17, 24, 39, 0.7) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            background: rgba(17, 24, 39, 0.7) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 4px 8px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            border-radius: 6px !important;
            border: 1px solid var(--border-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--accent-gradient) !important;
            color: #fff !important;
            border: none !important;
        }

        /* ============================================
           SCROLLBARS & UTILITIES
           ============================================ */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .bg-light {
            background-color: var(--bg-primary) !important;
        }

        /* Keyword content search styling */
        .content-search-box {
            position: relative;
            display: flex;
            align-items: center;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0 12px;
            height: 36px;
            width: 250px;
            transition: all 0.3s ease;
        }

        .content-search-box:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
            width: 320px;
        }

        .content-search-box i {
            color: var(--text-muted);
            font-size: 13px;
        }

        .content-search-box input {
            background: transparent;
            border: none;
            color: var(--text-primary);
            padding: 0 8px;
            font-size: 13px;
            outline: none;
            width: 100%;
        }

        .search-matches-count {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
            white-space: nowrap;
            margin-right: 8px;
            background: rgba(255, 255, 255, 0.05);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .search-navigation-arrows {
            display: flex;
            gap: 2px;
            border-left: 1px solid var(--border-color);
            padding-left: 8px;
        }

        .search-navigation-arrows button {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s ease;
            outline: none;
        }

        .search-navigation-arrows button:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.08);
        }

        mark.highlight-match {
            background-color: rgba(245, 158, 11, 0.35) !important;
            color: #fff !important;
            border-radius: 2px;
            padding: 0 2px;
            box-shadow: 0 0 4px rgba(245, 158, 11, 0.4);
            transition: all 0.2s ease;
        }

        mark.highlight-match.active-match {
            background-color: var(--accent) !important;
            box-shadow: 0 0 10px var(--accent-glow) !important;
            outline: 2px solid var(--accent-light);
        }

        /* Article Select Modal Styling */
        .modal-search-bar {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .modal-search-bar i {
            position: absolute;
            left: 38px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
        }

        .modal-search-bar input {
            width: 100%;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-primary);
            padding: 12px 16px 12px 42px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .modal-search-bar input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .articles-grid-layout {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 8px;
        }

        @media (max-width: 768px) {
            .articles-grid-layout {
                grid-template-columns: 1fr;
            }
        }

        .article-modal-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .article-modal-card:hover {
            background: rgba(59, 130, 246, 0.08);
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        .article-modal-card a {
            display: block;
            padding: 14px 16px;
            text-decoration: none !important;
        }

        .article-card-header {
            margin-bottom: 6px;
        }

        .chapter-badge {
            font-size: 10px;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .article-card-body h6 {
            color: var(--text-primary);
            font-size: 13px;
            font-weight: 600;
            margin: 0;
            line-height: 1.4;
        }

        /* ============================================
           PREMIUM AUDIO PLAYER BANNER
           ============================================ */
        .audio-player-banner {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 8px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            z-index: 5;
            transition: all 0.3s ease;
        }

        @media (max-width: 1024px) {
            .audio-player-banner {
                flex-direction: column;
                align-items: stretch;
                padding: 12px;
                gap: 12px;
            }
        }

        .audio-controls-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .audio-player-btn {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none !important;
        }

        .audio-player-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--border-hover);
            transform: scale(1.05);
        }

        .audio-player-btn.play-btn {
            background: var(--accent-gradient);
            border: none;
            box-shadow: 0 4px 10px var(--accent-glow);
        }

        .audio-player-btn.play-btn:hover {
            box-shadow: 0 6px 16px var(--accent-glow);
        }

        .audio-status-wrap {
            display: flex;
            flex-direction: column;
            margin-left: 6px;
        }

        .audio-status-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            line-height: 1.2;
        }

        .audio-playing-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--gold);
            margin-top: 1px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .audio-controls-center {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .audio-mode-selector {
            display: flex;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2px;
        }

        .mode-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            outline: none !important;
        }

        .mode-btn:hover {
            color: var(--text-primary);
        }

        .mode-btn.active {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-primary);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }

        .audio-selection-count {
            font-size: 11px;
            font-weight: 700;
            background: rgba(59, 130, 246, 0.15);
            color: var(--accent-light);
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 2px 8px;
            border-radius: 12px;
            text-transform: uppercase;
        }

        .audio-controls-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        @media (max-width: 1024px) {
            .audio-controls-right {
                justify-content: space-between;
            }
        }

        .audio-setting-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 4px 10px;
        }

        .audio-select-dropdown {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 12px;
            font-weight: 500;
            outline: none;
            cursor: pointer;
            max-width: 140px;
        }

        .audio-select-dropdown option {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .audio-rate-slider {
            width: 70px;
            height: 4px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .audio-rate-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-primary);
            min-width: 24px;
        }

        /* Checkbox styling inside TOC/Modal */
        .article-audio-checkbox {
            accent-color: var(--gold);
            cursor: pointer;
            width: 14px;
            height: 14px;
            margin-right: 8px;
            flex-shrink: 0;
            position: relative;
            top: 1px;
        }
        
        .article-modal-card {
            position: relative;
        }
        
        .article-modal-card-checkbox {
            position: absolute;
            top: 14px;
            right: 14px;
            accent-color: var(--gold);
            cursor: pointer;
            z-index: 5;
            width: 16px;
            height: 16px;
        }

        .panel-body a.constitution_content_link.active-playing-audio {
            background: rgba(245, 158, 11, 0.12) !important;
            color: var(--gold) !important;
            border-left: 3px solid var(--gold) !important;
            padding-left: 12px !important;
        }

        .tts-sentence {
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .tts-sentence.active-sentence {
            background-color: rgba(245, 158, 11, 0.22) !important;
            color: #fff !important;
            border-radius: 4px;
            padding: 0 4px;
            box-shadow: 0 0 6px rgba(245, 158, 11, 0.15);
        }
    </style>
  </head>
  <body class="bg-light">

    <!-- ====== PREMIUM NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <img src="{{ asset('logo/lawsghlog.png') }}" alt="LawsGhana">
            </a>

            <div class="nav-menu-links-premium">
                <!-- Constitution Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">Constitution <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/constitution/Republic/Ghana/1">Ghana</a>
                        <a href="/constitution/all-countries/1/Africa">Africa</a>
                        <a href="/constitution/all-countries/2/Asia">Asia</a>
                        <a href="/constitution/all-countries/3/Europe">Europe</a>
                        <a href="/constitution/all-countries/4/North-America">North America</a>
                        <a href="/constitution/all-countries/5/South-America">South America</a>
                    </div>
                </div>

                <!-- Pre-4th Republic Laws Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">Pre-4th Republic Laws <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/pre_1992_legislation/1/First Republic">1st Republic</a>
                        <a href="/pre_1992_legislation/2/Second Republic">2nd Republic</a>
                        <a href="/pre_1992_legislation/3/Third Republic">3rd Republic</a>
                        <a href="/pre_1992_legislation/5/NLC Decree">NLC Decree</a>
                        <a href="/pre_1992_legislation/6/NRC Decree">NRC Decree</a>
                        <a href="/pre_1992_legislation/7/SMC Decree">SMC Decree</a>
                        <a href="/pre_1992_legislation/8/AFRC Decree">AFRC Decree</a>
                        <a href="/pre_1992_legislation/4/PNDC Law">PNDC Law</a>
                    </div>
                </div>

                <!-- 4th Republic Laws Dropdown -->
                <div class="nav-link-dropdown">
                    <button class="nav-link-btn">4th Republic Laws <i class="fa-solid fa-chevron-down"></i></button>
                    <div class="nav-dropdown-menu">
                        <a href="/post-1992-legislation/1/Acts of Parliament">Acts of Parliament</a>
                        <a href="/post-1992-legislation/only-regulations">Legislative Instruments</a>
                        <a href="/post-1992-legislation/Constitutional-Intruments">Constitutional Instruments</a>
                        <a href="/post-1992-legislation/Executive-Intruments">Executive Instruments</a>
                        <a href="/post-1992-legislation/only-amendments">Amendments</a>
                    </div>
                </div>

                <a href="/judgement/Ghana" class="nav-link-btn" style="text-decoration:none !important;">Case Laws</a>
                <a href="/News/Ghana-News/1" class="nav-link-btn" style="text-decoration:none !important;">News</a>
            </div>

            <div class="nav-auth">
                @guest
                    <a href="{{ route('login') }}" class="btn-login">Log In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                    @endif
                @else
                    <div class="nav-user-dropdown" id="userDropdown">
                        <button class="nav-user-btn" onclick="document.getElementById('userDropdown').classList.toggle('active')">
                            <i class="fa-solid fa-circle-user"></i>
                            {{ Auth::user()->name }}
                            <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 2px;"></i>
                        </button>
                        <div class="nav-dropdown-menu dropdown-menu-right" style="right: 0; left: auto;">
                            <a href="/home"><i class="fa-solid fa-house"></i> Dashboard</a>
                            <a href="/accounts/profile/{{ Auth::user()->id }}"><i class="fa-solid fa-user"></i> Profile</a>
                            <a href="/accounts/manage-password"><i class="fa-solid fa-gear"></i> Settings</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="/accounts/downloads/{{ Auth::user()->id }}"><i class="fa-solid fa-download"></i> Downloads</a>
                            <a href="/accounts/bookmarks/{{ Auth::user()->id }}"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
                            <a href="/subscription"><i class="fa-solid fa-credit-card"></i> Subscription</a>
                            <div class="nav-dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="logout-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-power-off"></i> Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Continent/Sub-Navigation header -->
    <div class="continent-nav-wrap">
        <div class="nav-scroller bg-header-color rounded shadow-sm">
            <nav class="nav nav-underline">
                <a class="nav-link active text-white" href="/constitution/all_countries">All Countries</a>
                <a class="nav-link active text-white" href="/constitution/Republic/Ghana/1">Ghana</a>
                <a class="nav-link text-white" href="/constitution/all-countries/1/Africa">Africa</a>
                <a class="nav-link text-white" href="/constitution/all-countries/2/Asia">Asia</a>
                <a class="nav-link text-white" href="/constitution/all-countries/3/Europe">Europe</a>
                <a class="nav-link text-white" href="/constitution/all-countries/4/North-America">North America</a>
                <a class="nav-link text-white" href="/constitution/all-countries/5/South-America">South America</a>
            </nav>
        </div>
    </div>

    <!-- ====== THREE PANEL SPLIT WORKSPACE ====== -->
    <div class="workspace-wrapper">
        <!-- Left Panel: Table of Contents -->
        <aside class="workspace-sidebar left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h6>Table of Contents</h6>
                <button class="toggle-sidebar-btn" onclick="toggleSidebar('left')" title="Collapse TOC">
                    <i class="fa-solid fa-angle-left"></i>
                </button>
            </div>
            <div class="sidebar-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="tocSearch" placeholder="Filter by chapter or article...">
            </div>
            <div class="sidebar-content">
                <button type="button" class="btn btn-outlined btn-sm mb-3 btn-customised" data-toggle="modal" data-target="#viewActs">
                    <i class="fa-solid fa-globe mr-1"></i> Constitution List
                </button>
                <div class="accordion-content">
                    @include('constitution.new_chapters_articles')
                </div>
            </div>
        </aside>

        <!-- Left restore tab -->
        <button class="sidebar-restore-btn left-restore" id="leftRestoreBtn" onclick="toggleSidebar('left')" title="Expand TOC">
            <i class="fa-solid fa-angle-right"></i>
        </button>

        <!-- Center Panel: Active Reading Pane -->
        <main class="workspace-main">
            <div class="reading-toolbar">
                <div class="toolbar-left">
                    <div id="tabs" class="nav nav-tabs-premium" role="tablist">
                        <a class="nav-tab-premium tabPanedHide_acts_content active tab-hidden-initially" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                            <i class="fa-solid fa-book-open"></i> Reader
                        </a>
                        <a class="nav-tab-premium tabPanedHide_expanded_view tab-hidden-initially" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                            <i class="fa-solid fa-expand"></i> Expanded View
                        </a>
                        <a class="nav-tab-premium tabPanedHide_split_view tab-hidden-initially" id="v-pills-split-tab" data-toggle="pill" href="#v-pills-split" role="tab" aria-controls="v-pills-split" aria-selected="false">
                            <i class="fa-solid fa-columns"></i> Split View
                        </a>
                    </div>
                </div>

                <!-- Toolbar Center: Keyword Search Box -->
                <div class="toolbar-center">
                    <div class="content-search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="keywordSearch" placeholder="Find in document...">
                        <span class="search-matches-count" id="searchMatchCount" style="display:none;"></span>
                        <div class="search-navigation-arrows" id="searchNavArrows" style="display:none;">
                            <button id="searchPrevBtn" onclick="navigateMatches('prev')" title="Previous match"><i class="fa-solid fa-chevron-up"></i></button>
                            <button id="searchNextBtn" onclick="navigateMatches('next')" title="Next match"><i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                    </div>
                </div>

                <div class="toolbar-right">
                    <!-- Split layout direction controls -->
                    <div class="split-layout-controls" id="splitLayoutControls" style="display: none; margin-right: 8px;">
                        <button class="split-layout-btn active" id="btnSplitHorizontal" onclick="setSplitDirection('horizontal')" title="Split Horizontally (Side-by-Side)">
                            <i class="fa-solid fa-columns"></i> Side-by-Side
                        </button>
                        <button class="split-layout-btn" id="btnSplitVertical" onclick="setSplitDirection('vertical')" title="Split Vertically (Stacked)">
                            <i class="fa-solid fa-window-maximize" style="transform: rotate(90deg); font-size: 10px;"></i> Stacked
                        </button>
                    </div>

                    <!-- Font adjuster -->
                    <div class="font-adjuster">
                        <button onclick="changeFontSize('decrease')" title="Decrease text size"><i class="fa-solid fa-minus"></i></button>
                        <span>Aa</span>
                        <button onclick="changeFontSize('increase')" title="Increase text size"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    
                    <!-- Article Navigation (Previous / Next) -->
                    <div id="toolbarArticleNav" class="font-adjuster ml-2 mr-2" style="background: rgba(17, 24, 39, 0.6); border: 1px solid var(--border-color); border-radius: 8px; padding: 2px; display: none; gap: 2px;">
                        <a href="#" class="toolbar-icon-btn previous_content_constitution_act" title="Previous Article" style="background: transparent; border: none; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; text-decoration: none !important; border-radius: 6px; padding: 0;">
                            <i class="fa-solid fa-chevron-left" style="font-size: 11px;"></i>
                        </a>
                        <a href="#" class="toolbar-icon-btn next_content_constitution_act" title="Next Article" style="background: transparent; border: none; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; text-decoration: none !important; border-radius: 6px; padding: 0;">
                            <i class="fa-solid fa-chevron-right" style="font-size: 11px;"></i>
                        </a>
                    </div>

                    <!-- Toggle right sidebar -->
                    <button class="toolbar-icon-btn" onclick="toggleSidebar('right')" title="Toggle Info Panel">
                        <i class="fa-solid fa-sliders"></i>
                    </button>
                </div>
            </div>

            <!-- Premium Audio Player Banner -->
            <div class="audio-player-banner" id="audioPlayerBanner" style="display: none;">
                <div class="audio-controls-left">
                    <button id="audioPlayBtn" class="audio-player-btn play-btn" onclick="handleAudioPlay()" title="Play Speech">
                        <i class="fa-solid fa-play"></i>
                    </button>
                    <button id="audioPauseBtn" class="audio-player-btn play-btn" onclick="handleAudioPause()" title="Pause Speech" style="display:none; background: var(--accent-gradient);">
                        <i class="fa-solid fa-pause"></i>
                    </button>
                    <button id="audioStopBtn" class="audio-player-btn stop-btn" onclick="handleAudioStop()" title="Stop Speech">
                        <i class="fa-solid fa-stop"></i>
                    </button>
                    <div class="audio-status-wrap">
                        <span class="audio-status-label" id="audioStatusLabel">Audio Reader Off</span>
                        <span class="audio-playing-title" id="audioPlayingTitle" style="display:none;"></span>
                    </div>
                </div>

                <div class="audio-controls-center">
                    <div class="audio-mode-selector">
                        <button class="mode-btn active" id="modeBtnCurrent" onclick="setAudioMode('current')" title="Read only the active article shown in the reader">Current Article</button>
                        <button class="mode-btn" id="modeBtnSelected" onclick="setAudioMode('selected')" title="Read articles selected using checkboxes">Selected Articles</button>
                        <button class="mode-btn" id="modeBtnAll" onclick="setAudioMode('all')" title="Read the entire constitution sequentially">Read All</button>
                    </div>
                    <span class="audio-selection-count" id="audioSelectionCount" style="display:none;">0 selected</span>
                </div>

                <div class="audio-controls-right">
                    <div class="audio-setting-item">
                        <i class="fa-solid fa-volume-high text-muted"></i>
                        <select id="audioVoiceSelect" class="audio-select-dropdown" onchange="VoicePlayer.stop()"></select>
                    </div>
                    <div class="audio-setting-item">
                        <i class="fa-solid fa-gauge-high text-muted"></i>
                        <input type="range" id="audioRateRange" class="audio-rate-slider" min="0.5" max="2.0" step="0.1" value="1.0" onchange="updateRateLabel(this.value)">
                        <span class="audio-rate-label" id="audioRateLabel">1.0x</span>
                    </div>
                </div>
            </div>

            <div class="workspace-body">
                <div class="tab-content" id="v-pills-tabContent">
                    {{-- Reader Pane (Combines Welcome Screen & Loaded Articles) --}}
                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="reader-container">
                            <div id="display_content">
                                <div class="preamble-card">
                                    <a class="constitution_preamble_link" href="/constitution/Republic/constitution_preamble/{{ $ghana_act['id'] }}">
                                        <i class="fa-solid fa-scroll mr-2 text-warning"></i> Read Constitution Preamble / Introductory Text
                                    </a>
                                </div>
                                <div class="toc-welcome">
                                    <i class="fa-solid fa-arrow-left fa-3x mb-3 text-muted" style="display:block;"></i>
                                    <h5>{{ $ghana_act['title'] }}</h5>
                                    <p>Select a chapter from the collapsible tree on the left panel to browse articles and read the content.</p>
                                </div>
                            </div>
                            <div id="display_view_all_section"></div>
                        </div>

                        @include('layouts.plain_view_no_subscription')
                        @include('layouts.plain_view_subscription_expiry')
                        @include('layouts.plain_view_downloaded_exceeded')
                        @include('layouts.plain_create_account')
                    </div>

                    {{-- Expanded Pane --}}
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="expanded-container">
                            <div id="acts_expanded_view">
                                <div class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-spinner fa-spin fa-2x mb-3" style="opacity: 0.3;"></i>
                                    <p>Loading full expanded constitution view...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Split View Pane --}}
                    <div class="tab-pane fade" id="v-pills-split" role="tabpanel" aria-labelledby="v-pills-split-tab">
                        <div class="split-view-container split-direction-horizontal" id="splitViewContainer">
                            <!-- Panel A -->
                            <div class="split-panel active" id="splitPanelA" onclick="focusSplitPanel('A')">
                                <div class="split-panel-header">
                                    <span class="panel-badge" id="badgePanelA">Panel A (Active)</span>
                                    <span class="loaded-title" id="titlePanelA">No Article Loaded</span>
                                </div>
                                <div class="split-panel-body" id="bodyPanelA">
                                    <div class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-book-open fa-2x mb-3" style="opacity: 0.3;"></i>
                                        <p>Make sure this panel is active (highlighted border) and select any article from the left Table of Contents to compare.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Panel B -->
                            <div class="split-panel" id="splitPanelB" onclick="focusSplitPanel('B')">
                                <div class="split-panel-header">
                                    <span class="panel-badge" id="badgePanelB">Panel B</span>
                                    <span class="loaded-title" id="titlePanelB">No Article Loaded</span>
                                </div>
                                <div class="split-panel-body" id="bodyPanelB">
                                    <div class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-book-open fa-2x mb-3" style="opacity: 0.3;"></i>
                                        <p>Make sure this panel is active (highlighted border) and select any article from the left Table of Contents to compare.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Panel: Filters & Context -->
        <aside class="workspace-sidebar right-sidebar" id="rightSidebar">
            <div class="sidebar-header">
                <button class="toggle-sidebar-btn" onclick="toggleSidebar('right')" title="Collapse Info Panel">
                    <i class="fa-solid fa-angle-right"></i>
                </button>
                <h6>Reader Tools</h6>
            </div>
            <div class="sidebar-content">
                <div id="rightSidebarContent">
                    <div class="toc-sidebar-module">
                        @include('constitution.new_container_plain')
                    </div>
                    <div class="content-sidebar-module" style="display:none;">
                        @include('constitution.new_container_details_constitution')
                    </div>
                </div>
            </div>
        </aside>

        <!-- Right restore tab -->
        <button class="sidebar-restore-btn right-restore" id="rightRestoreBtn" onclick="toggleSidebar('right')" title="Expand Info Panel">
            <i class="fa-solid fa-angle-left"></i>
        </button>
    </div>

    <!-- Country Selector Modal -->
    <div class="modal fade" id="viewActs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-globe mr-2"></i> Select Constitution</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:#fff;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" id="datatable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Name of Country</th>
                                <th>Constitution Title</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allCountriesConstitutions as $allCountriesConstitution)
                                <tr>
                                    <td>{{ $allCountriesConstitution->country }}</td>
                                    <td>
                                        <a href="/constitution/1/{{ $allCountriesConstitution->continent }}/{{ $allCountriesConstitution->country }}/{{ $allCountriesConstitution->id}}">{{ $allCountriesConstitution->title }}</a>
                                    </td>
                                    <td>{{ $allCountriesConstitution->year }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Select Articles Modal -->
    <div class="modal fade" id="selectArticlesModal" tabindex="-1" aria-labelledby="articlesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="articlesModalLabel"><i class="fa-solid fa-book-open mr-2 text-primary"></i> Select Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:#fff;">&times;</span>
                    </button>
                </div>
                <div class="modal-search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="articleFilterInput" placeholder="Filter articles by keyword or section name...">
                </div>
                <div class="modal-body">
                    <div class="articles-grid-layout" id="modalArticlesGrid">
                        @foreach($constitutionContents as $constitutionContent)
                            <div class="article-modal-card" data-section="{{ strtolower($constitutionContent->section) }}">
                                <input type="checkbox" class="article-modal-card-checkbox" data-sid="{{ $constitutionContent->id }}">
                                <a data-scroll-to="body"
                                   data-scroll-focus="body"
                                   data-scroll-speed="400"
                                   data-scroll-offset="-60" 
                                   class="constitution_view_all_section_link_with_prev_next constitution_content_link" 
                                   sid="{{$constitutionContent->id}}" 
                                   href="/constitution/Republic/constitution_content/{{ $constitutionContent->id }}" 
                                   data-dismiss="modal">
                                    <div class="article-card-header">
                                        <span class="chapter-badge">{{ ($constitutionContent->chapter == '') ? 'Sections' : $constitutionContent->chapter }}</span>
                                    </div>
                                    <div class="article-card-body">
                                        <h6>{{ $constitutionContent->section }}</h6>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="{{ asset('js/tooltipster.bundle.min.js') }}"></script>
    <script src="{{ asset('js/print-preview.js') }}"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    <script src="{{ asset('js/myscript.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script>
        // Datatables activation
        $(document).ready(function(){
            $('#datatable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });
        });

        // Close user dropdown on click outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Copy/paste protection
        $(document).ready(function () {
            $('body').bind('cut copy paste', function (e) {
                e.preventDefault();
            });
        });

        /* ============================================
           WORKSPACE CONTROL SCRIPTS
           ============================================ */
        
        // Sidebar Toggle Handler
        function toggleSidebar(side) {
            const sidebar = document.getElementById(side + 'Sidebar');
            const restoreBtn = document.getElementById(side + 'RestoreBtn');
            
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                restoreBtn.style.display = 'none';
            } else {
                sidebar.classList.add('collapsed');
                restoreBtn.style.display = 'flex';
            }
        }

        // Font Size adjusters
        let currentSizeLevel = 1.0; 
        function changeFontSize(action) {
            const reader = document.getElementById('display_content');
            const expanded = document.getElementById('acts_expanded_view');
            
            if (action === 'increase') {
                if (currentSizeLevel < 1.4) currentSizeLevel += 0.1;
            } else {
                if (currentSizeLevel > 0.8) currentSizeLevel -= 0.1;
            }
            
            if (reader) reader.style.fontSize = currentSizeLevel + 'rem';
            if (expanded) expanded.style.fontSize = currentSizeLevel + 'rem';
        }

        function setSidebarState(side, collapsed) {
            const sidebar = document.getElementById(side + 'Sidebar');
            const restoreBtn = document.getElementById(side + 'RestoreBtn');
            if (!sidebar) return;
            
            if (collapsed) {
                sidebar.classList.add('collapsed');
                if (restoreBtn) restoreBtn.style.display = 'flex';
            } else {
                sidebar.classList.remove('collapsed');
                if (restoreBtn) restoreBtn.style.display = 'none';
            }
        }

        // Toggle expanded view tab programmatically from button clicks
        $(document).on('click', '.toggle_expanded_view, .expanded_link', function(e) {
            e.preventDefault();
            $('#v-pills-messages-tab').trigger('click');
        });

        // Dynamic Right sidebar module switcher and auto sidebar toggle based on Active Tab
        $('#tabs a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            const targetId = $(e.target).attr('href');
            
            // Clear current search state on tab switch to prevent highlight corruption
            $('#keywordSearch').val('');
            if (originalArticleHTML) {
                const c = document.getElementById('display_content');
                if (c) c.innerHTML = originalArticleHTML;
            }
            if (originalExpandedHTML) {
                const c = document.getElementById('acts_expanded_view');
                if (c) c.innerHTML = originalExpandedHTML;
            }
            originalArticleHTML = '';
            originalExpandedHTML = '';
            searchMatches = [];
            currentMatchIndex = -1;
            updateSearchUI();
            
            if (targetId === '#v-pills-profile') {
                // Restore sidebars to normal view
                setSidebarState('left', false);
                setSidebarState('right', false);
                
                if ($('#display_content').find('.toc-welcome').length > 0) {
                    $('.toc-sidebar-module').show();
                    $('.content-sidebar-module').hide();
                } else {
                    $('.toc-sidebar-module').hide();
                    $('.content-sidebar-module').show();
                }
            } else {
                // Expanded View Tab: collapse both sidebars for widescreen presentation
                setSidebarState('left', true);
                setSidebarState('right', true);
                
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').hide();
            }
        });

        // Toggle modules on left sidebar link clicks
        $(document).on('click', '.constitution_content_link, .constitution_preamble_link', function() {
            $('.toc-sidebar-module').hide();
            $('.content-sidebar-module').show();
        });

        // Realtime Table of Contents Search Filter
        $('#tocSearch').on('input', function() {
            const query = $(this).val().toLowerCase();
            
            if (!query) {
                $('.panel-group .panel').show();
                $('.panel-body li').show();
                return;
            }
            
            $('.panel-group .panel').each(function() {
                const chapter = $(this);
                const chapterTitle = chapter.find('.panel-heading').text().toLowerCase();
                let matches = false;
                
                chapter.find('.panel-body li').each(function() {
                    const article = $(this);
                    const articleText = article.text().toLowerCase();
                    
                    if (articleText.includes(query)) {
                        article.show();
                        matches = true;
                    } else {
                        article.hide();
                    }
                });
                
                if (chapterTitle.includes(query) || matches) {
                    chapter.show();
                    chapter.find('.collapse').addClass('show');
                } else {
                    chapter.hide();
                }
            });
        });

        /* ============================================
           KEYWORD IN-DOCUMENT SEARCH & HIGHLIGHTS
           ============================================ */
        let searchMatches = [];
        let currentMatchIndex = -1;
        let originalArticleHTML = '';
        let originalExpandedHTML = '';

        $('#keywordSearch').on('input', function() {
            const query = $(this).val().trim();
            highlightKeyword(query);
        });

        // Trigger search on Enter keypress
        $('#keywordSearch').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                navigateMatches('next');
            }
        });

        function highlightKeyword(query) {
            const isExpanded = $('#v-pills-messages-tab').hasClass('active');
            const container = isExpanded ? document.getElementById('acts_expanded_view') : document.getElementById('display_content');
            if (!container) return;

            // Save original loaded HTML to clear previous search matches safely
            if (isExpanded) {
                if (originalExpandedHTML) {
                    container.innerHTML = originalExpandedHTML;
                } else {
                    originalExpandedHTML = container.innerHTML;
                }
            } else {
                if (originalArticleHTML) {
                    container.innerHTML = originalArticleHTML;
                } else {
                    originalArticleHTML = container.innerHTML;
                }
            }

            searchMatches = [];
            currentMatchIndex = -1;
            updateSearchUI();

            if (!query || query.length < 2) return;

            // Select all child text nodes under target container
            const nodes = [];
            const walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, null, false);
            while (walker.nextNode()) {
                nodes.push(walker.currentNode);
            }

            const regex = new RegExp('(' + escapeRegExp(query) + ')', 'gi');

            nodes.forEach(node => {
                const text = node.nodeValue;
                if (regex.test(text)) {
                    const span = document.createElement('span');
                    span.innerHTML = text.replace(regex, '<mark class="highlight-match">$1</mark>');
                    node.parentNode.replaceChild(span, node);
                }
            });

            // Find all newly inserted highlighted tags
            searchMatches = container.querySelectorAll('mark.highlight-match');

            if (searchMatches.length > 0) {
                currentMatchIndex = 0;
                searchMatches[currentMatchIndex].classList.add('active-match');
                searchMatches[currentMatchIndex].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            updateSearchUI();
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function navigateMatches(direction) {
            if (searchMatches.length === 0) return;

            if (currentMatchIndex >= 0 && currentMatchIndex < searchMatches.length) {
                searchMatches[currentMatchIndex].classList.remove('active-match');
            }

            if (direction === 'next') {
                currentMatchIndex = (currentMatchIndex + 1) % searchMatches.length;
            } else {
                currentMatchIndex = (currentMatchIndex - 1 + searchMatches.length) % searchMatches.length;
            }

            searchMatches[currentMatchIndex].classList.add('active-match');
            searchMatches[currentMatchIndex].scrollIntoView({ behavior: 'smooth', block: 'center' });
            updateSearchUI();
        }

        function updateSearchUI() {
            const countEl = document.getElementById('searchMatchCount');
            const navEl = document.getElementById('searchNavArrows');

            if (searchMatches.length > 0) {
                countEl.textContent = (currentMatchIndex + 1) + ' / ' + searchMatches.length;
                countEl.style.display = 'block';
                navEl.style.display = 'flex';
            } else {
                countEl.style.display = 'none';
                navEl.style.display = 'none';
            }
        }

        // Reset search states when a new article is loaded via AJAX
        $(document).on('click', '.constitution_content_link, .constitution_preamble_link', function() {
            $('#keywordSearch').val('');
            originalArticleHTML = '';
            originalExpandedHTML = '';
            searchMatches = [];
            currentMatchIndex = -1;
            updateSearchUI();
        });

        // Realtime Articles Filter in Modal
        $('#articleFilterInput').on('input', function() {
            const query = $(this).val().toLowerCase().trim();
            
            $('.article-modal-card').each(function() {
                const card = $(this);
                const sectionText = card.data('section');
                
                if (!query || sectionText.includes(query)) {
                    card.show();
                } else {
                    card.hide();
                }
            });
        });

        // Clear filter input when modal is closed
        $('#selectArticlesModal').on('hidden.bs.modal', function () {
            $('#articleFilterInput').val('').trigger('input');
        });

        /* ============================================
           PREMIUM WEB SPEECH SYNTHESIS CONTROLLER
           ============================================ */
        
        @php
            $mappedArticles = $constitutionContents->map(function($article) {
                return [
                    'id' => $article->id,
                    'section' => $article->section,
                    'articles' => strip_tags($article->articles),
                    'chapter' => $article->chapter
                ];
            });
        @endphp
        const allArticlesData = @json($mappedArticles);
        const preambleText = @json(strip_tags($ghana_act['preamble']));
        const ghanaActId = "{{ $ghana_act['id'] }}";

        let voices = [];
        function populateVoiceList() {
            if (typeof speechSynthesis === 'undefined') return;
            voices = speechSynthesis.getVoices();
            const voiceSelect = document.getElementById('audioVoiceSelect');
            if (!voiceSelect) return;
            
            const currentSelection = voiceSelect.value;
            voiceSelect.innerHTML = '';
            
            voices.forEach((voice, i) => {
                const option = document.createElement('option');
                option.textContent = `${voice.name} (${voice.lang})`;
                option.value = i;
                if (voice.lang.includes('en') || voice.default) {
                    option.selected = true;
                }
                voiceSelect.appendChild(option);
            });
            
            if (currentSelection && voiceSelect.querySelector(`option[value="${currentSelection}"]`)) {
                voiceSelect.value = currentSelection;
            }
        }

        populateVoiceList();
        if (speechSynthesis.onvoiceschanged !== undefined) {
            speechSynthesis.onvoiceschanged = populateVoiceList;
        }

        const VoicePlayer = {
            queue: [],
            currentIndex: 0,
            isPlaying: false,
            isPaused: false,
            utterance: null,
            sentenceQueue: [],
            currentSentenceIndex: 0,
            
            play(items) {
                this.stop();
                this.queue = items;
                this.currentIndex = 0;
                this.isPlaying = true;
                this.isPaused = false;
                this.playNextArticle();
            },
            
            playNextArticle() {
                if (this.currentIndex >= this.queue.length) {
                    this.stop();
                    updatePlayerUI('stopped');
                    return;
                }
                
                const item = this.queue[this.currentIndex];
                
                if (item.id) {
                    highlightPlayingArticle(item.id);
                }
                
                // If it is an article and it's not the currently loaded one, load it programmatically
                if (item.id && String(gsid) !== String(item.id)) {
                    loadArticleProgrammatically(item.id, () => {
                        this.startReadingArticle(item);
                    });
                } else {
                    this.startReadingArticle(item);
                }
            },
            
            startReadingArticle(item) {
                // Wrap and get all sentences from the reader content
                const sentences = prepareSentencesForHighlighting();
                
                this.sentenceQueue = sentences;
                this.currentSentenceIndex = 0;
                
                if (this.sentenceQueue.length === 0) {
                    // Fallback if no text could be parsed
                    this.sentenceQueue = [{ el: null, text: item.text }];
                }
                
                this.speakCurrentSentence();
            },
            
            speakCurrentSentence() {
                if (!this.isPlaying) return;
                if (this.isPaused) return;
                
                if (this.currentSentenceIndex >= this.sentenceQueue.length) {
                    // Finished reading all sentences of this article, proceed to next article
                    this.currentIndex++;
                    this.playNextArticle();
                    return;
                }
                
                const sentenceItem = this.sentenceQueue[this.currentSentenceIndex];
                
                // Highlight current sentence
                clearSentenceHighlights();
                if (sentenceItem.el) {
                    sentenceItem.el.classList.add('active-sentence');
                    sentenceItem.el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                updatePlayerUI('playing', this.queue[this.currentIndex].title);
                
                this.utterance = new SpeechSynthesisUtterance(sentenceItem.text);
                
                // Set voice
                const voiceSelect = document.getElementById('audioVoiceSelect');
                if (voiceSelect && voices[voiceSelect.value]) {
                    this.utterance.voice = voices[voiceSelect.value];
                }
                
                // Set rate
                const rateRange = document.getElementById('audioRateRange');
                if (rateRange) {
                    this.utterance.rate = parseFloat(rateRange.value);
                }
                
                this.utterance.onend = () => {
                    if (sentenceItem.el) {
                        sentenceItem.el.classList.remove('active-sentence');
                    }
                    if (this.isPlaying && !this.isPaused) {
                        this.currentSentenceIndex++;
                        this.speakCurrentSentence();
                    }
                };
                
                this.utterance.onerror = (e) => {
                    console.error("Speech error", e);
                    if (sentenceItem.el) {
                        sentenceItem.el.classList.remove('active-sentence');
                    }
                    if (e.error !== 'interrupted') {
                        this.currentSentenceIndex++;
                        this.speakCurrentSentence();
                    }
                };
                
                window.speechSynthesis.speak(this.utterance);
            },
            
            pause() {
                if (this.isPlaying && !this.isPaused) {
                    window.speechSynthesis.pause();
                    this.isPaused = true;
                    updatePlayerUI('paused');
                }
            },
            
            resume() {
                if (this.isPlaying && this.isPaused) {
                    if (window.speechSynthesis.paused) {
                        window.speechSynthesis.resume();
                    } else {
                        this.speakCurrentSentence();
                    }
                    this.isPaused = false;
                    updatePlayerUI('playing', this.queue[this.currentIndex] ? this.queue[this.currentIndex].title : '');
                }
            },
            
            stop() {
                this.isPlaying = false;
                this.isPaused = false;
                window.speechSynthesis.cancel();
                if (this.utterance) {
                    this.utterance.onend = null;
                    this.utterance.onerror = null;
                }
                this.utterance = null;
                clearSentenceHighlights();
                clearActiveArticleHighlight();
                updatePlayerUI('stopped');
            }
        };

        function prepareSentencesForHighlighting() {
            const contentEl = $('#display_content .content');
            if (!contentEl.length) return [];
            
            if (contentEl.find('.tts-sentence').length) {
                const list = [];
                contentEl.find('.tts-sentence').each(function() {
                    list.push({
                        el: this,
                        text: $(this).text().trim()
                    });
                });
                return list;
            }
            
            const textNodes = [];
            const walker = document.createTreeWalker(contentEl[0], NodeFilter.SHOW_TEXT, null, false);
            while (walker.nextNode()) {
                const parent = walker.currentNode.parentNode;
                if (parent && parent.tagName !== 'SCRIPT' && parent.tagName !== 'STYLE') {
                    textNodes.push(walker.currentNode);
                }
            }
            
            const sentences = [];
            let sentenceIndex = 0;
            
            textNodes.forEach(node => {
                const val = node.nodeValue;
                if (!val || !val.trim()) return;
                
                const parts = val.split(/(?<=[.!?])\s+/);
                const spanContainer = document.createElement('span');
                
                parts.forEach(part => {
                    if (!part.trim()) return;
                    const span = document.createElement('span');
                    span.className = 'tts-sentence';
                    span.setAttribute('data-index', sentenceIndex++);
                    span.textContent = part + ' ';
                    spanContainer.appendChild(span);
                    
                    sentences.push({
                        el: span,
                        text: part.trim()
                    });
                });
                
                if (node.parentNode) {
                    node.parentNode.replaceChild(spanContainer, node);
                }
            });
            
            return sentences;
        }

        function clearSentenceHighlights() {
            $('.tts-sentence').removeClass('active-sentence');
        }

        function loadArticleProgrammatically(sid, callback) {
            const linkEl = $(`.panel-body a.constitution_content_link[sid="${sid}"]`);
            if (linkEl.length) {
                const observer = new MutationObserver((mutations, obs) => {
                    obs.disconnect();
                    setTimeout(callback, 250);
                });
                
                const displayEl = document.getElementById('display_content');
                if (displayEl) {
                    observer.observe(displayEl, { childList: true, subtree: true });
                }
                
                linkEl.trigger('click');
            } else {
                callback();
            }
        }

        let activeAudioMode = 'current';

        function setAudioMode(mode) {
            activeAudioMode = mode;
            $('.audio-mode-selector .mode-btn').removeClass('active');
            $(`#modeBtn${mode.charAt(0).toUpperCase() + mode.slice(1)}`).addClass('active');
            
            if (VoicePlayer.isPlaying) {
                VoicePlayer.stop();
            }
        }

        function handleAudioPlay() {
            if (VoicePlayer.isPaused) {
                VoicePlayer.resume();
                return;
            }
            
            let playlist = [];
            
            if (activeAudioMode === 'current') {
                const readerContent = document.getElementById('display_content');
                if (readerContent && readerContent.querySelector('.toc-welcome')) {
                    alert("Please select an article from the left panel first.");
                    return;
                }
                
                const titleText = $('#display_content .nav-links').text().trim();
                const articleBody = $('#display_content .content').text().trim();
                playlist.push({
                    id: typeof gsid !== 'undefined' ? gsid : null,
                    title: titleText || 'Current Article',
                    text: (titleText ? titleText + ". " : "") + articleBody
                });
            } else if (activeAudioMode === 'selected') {
                const selectedSids = [];
                $('.article-audio-checkbox:checked').each(function() {
                    selectedSids.push(String($(this).attr('data-sid')));
                });
                
                if (selectedSids.length === 0) {
                    alert("Please select articles using the checkboxes first.");
                    return;
                }
                
                allArticlesData.forEach(item => {
                    if (selectedSids.includes(String(item.id))) {
                        playlist.push({
                            id: item.id,
                            title: item.section,
                            text: item.section + ". " + item.articles
                        });
                    }
                });
            } else if (activeAudioMode === 'all') {
                if (preambleText) {
                    playlist.push({
                        title: 'Introductory Text',
                        text: 'Introductory Text. ' + preambleText
                    });
                }
                allArticlesData.forEach(item => {
                    playlist.push({
                        id: item.id,
                        title: item.section,
                        text: item.section + ". " + item.articles
                    });
                });
            }
            
            if (playlist.length > 0) {
                VoicePlayer.play(playlist);
            }
        }

        function handleAudioPause() {
            VoicePlayer.pause();
        }

        // Expose function globally so inline onclick events work
        window.handleAudioPlay = handleAudioPlay;
        window.handleAudioPause = handleAudioPause;
        window.handleAudioStop = function() {
            VoicePlayer.stop();
        };
        window.setAudioMode = setAudioMode;
        window.updateRateLabel = updateRateLabel;

        function updateRateLabel(value) {
            const label = document.getElementById('audioRateLabel');
            if (label) label.textContent = parseFloat(value).toFixed(1) + 'x';
            
            if (VoicePlayer.isPlaying && !VoicePlayer.isPaused) {
                const currIdx = VoicePlayer.currentIndex;
                const queue = VoicePlayer.queue;
                VoicePlayer.stop();
                VoicePlayer.queue = queue;
                VoicePlayer.currentIndex = currIdx;
                VoicePlayer.isPlaying = true;
                VoicePlayer.speakCurrent();
            }
        }

        function updatePlayerUI(state, activeTitle = '') {
            const playBtn = document.getElementById('audioPlayBtn');
            const pauseBtn = document.getElementById('audioPauseBtn');
            const statusLabel = document.getElementById('audioStatusLabel');
            const titleEl = document.getElementById('audioPlayingTitle');
            
            if (state === 'playing') {
                if (playBtn) playBtn.style.display = 'none';
                if (pauseBtn) pauseBtn.style.display = 'flex';
                if (statusLabel) statusLabel.textContent = 'Now Reading';
                if (titleEl) {
                    if (activeTitle) {
                        titleEl.textContent = activeTitle;
                        titleEl.style.display = 'block';
                    }
                }
            } else if (state === 'paused') {
                if (playBtn) playBtn.style.display = 'flex';
                if (pauseBtn) pauseBtn.style.display = 'none';
                if (statusLabel) statusLabel.textContent = 'Paused';
            } else {
                if (playBtn) playBtn.style.display = 'flex';
                if (pauseBtn) pauseBtn.style.display = 'none';
                if (statusLabel) statusLabel.textContent = 'Audio Reader Off';
                if (titleEl) {
                    titleEl.style.display = 'none';
                    titleEl.textContent = '';
                }
            }
        }

        function highlightPlayingArticle(sid) {
            $('.panel-body a.constitution_content_link').removeClass('active-playing-audio');
            $(`.panel-body a.constitution_content_link[sid="${sid}"]`).addClass('active-playing-audio');
        }
        
        function clearActiveArticleHighlight() {
            $('.panel-body a.constitution_content_link').removeClass('active-playing-audio');
        }

        // Checkbox synchronization
        $(document).on('change', '.article-audio-checkbox, .article-modal-card-checkbox', function() {
            const sid = $(this).attr('data-sid') || $(this).data('sid');
            const checked = $(this).prop('checked');
            
            $(`.article-audio-checkbox[data-sid="${sid}"], .article-modal-card-checkbox[data-sid="${sid}"]`).prop('checked', checked);
            
            updateSelectedCount();
        });

        function updateSelectedCount() {
            const selectedCount = $('.article-audio-checkbox:checked').length;
            const countEl = document.getElementById('audioSelectionCount');
            if (countEl) {
                if (selectedCount > 0) {
                    countEl.textContent = selectedCount + ' selected';
                    countEl.style.display = 'inline-block';
                } else {
                    countEl.style.display = 'none';
                }
            }
        }

        // Show toolbar article navigation arrows and audio player banner when an article is loaded
        $(document).on('click', '.constitution_content_link, .constitution_preamble_link, .previous_content_constitution_act, .next_content_constitution_act', function(e) {
            $('.tab-hidden-initially').removeClass('tab-hidden-initially');
            $('#toolbarArticleNav').css('display', 'flex');
            $('#audioPlayerBanner').css('display', 'flex');
            
            // Stop voice reader if user manually clicks a link (real user click)
            if (e.originalEvent && VoicePlayer.isPlaying) {
                VoicePlayer.stop();
            }
        });

        // Show audio banner if user checks any article checkbox
        $(document).on('change', '.article-audio-checkbox, .article-modal-card-checkbox', function() {
            $('#audioPlayerBanner').css('display', 'flex');
        });

        // Show audio banner if user clicks on mode selection buttons
        $(document).on('click', '.audio-mode-selector .mode-btn', function() {
            $('#audioPlayerBanner').css('display', 'flex');
        });

        // Split comparative view state and actions
        let activeSplitPanel = 'A';
        
        function focusSplitPanel(panel) {
            activeSplitPanel = panel;
            $('.split-panel').removeClass('active');
            $(`#splitPanel${panel}`).addClass('active');
            
            if (panel === 'A') {
                $('#badgePanelA').text('Panel A (Active)');
                $('#badgePanelB').text('Panel B');
            } else {
                $('#badgePanelA').text('Panel A');
                $('#badgePanelB').text('Panel B (Active)');
            }
        }
        
        function setSplitDirection(dir) {
            const container = document.getElementById('splitViewContainer');
            if (!container) return;
            
            $('.split-layout-btn').removeClass('active');
            
            if (dir === 'horizontal') {
                container.classList.remove('split-direction-vertical');
                container.classList.add('split-direction-horizontal');
                $('#btnSplitHorizontal').addClass('active');
            } else {
                container.classList.remove('split-direction-horizontal');
                container.classList.add('split-direction-vertical');
                $('#btnSplitVertical').addClass('active');
            }
        }
        
        window.triggerSplitView = function(direction) {
            // Reveal tab bar if hidden
            $('.tab-hidden-initially').removeClass('tab-hidden-initially');
            
            // First show split view tab
            $('#v-pills-split-tab').trigger('click');
            
            // Set direction
            setSplitDirection(direction);
        };

        window.focusSplitPanel = focusSplitPanel;
        window.setSplitDirection = setSplitDirection;

        // Intercept article TOC link clicks when Split View is active
        $(document).on('click', '.constitution_content_link, .constitution_preamble_link', function(e) {
            if ($('#v-pills-split-tab').hasClass('active')) {
                // Intercept and prevent normal single-pane behavior
                e.preventDefault();
                e.stopImmediatePropagation();
                
                const link = $(this).attr('href');
                const titleText = $(this).text().trim();
                const targetPanel = activeSplitPanel;
                
                $(`#bodyPanel${targetPanel}`).html(`
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-spinner fa-spin fa-2x mb-3" style="opacity: 0.3;"></i>
                        <p>Loading article content...</p>
                    </div>
                `);
                
                $(`#titlePanel${targetPanel}`).text(titleText);
                
                $.get(link, function(response) {
                    $(`#bodyPanel${targetPanel}`).html(response);
                    
                    // Style links inside the loaded panel to be clean
                    $(`#bodyPanel${targetPanel} a`).css('color', 'var(--gold)');
                });
            }
        });

        // Cancel voice synthesis when navigating away
        window.addEventListener('beforeunload', () => {
            window.speechSynthesis.cancel();
        });
    </script>
  </body>
</html>
