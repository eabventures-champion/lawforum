<!doctype html>
<html lang="en" style="background-color:#070a13;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ ucwords(strtolower($allGhanaLaw['case_title'])) }} - Legals Forum</title>

    <!-- Google Fonts & Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <style>
        :root {
            --bg-primary: #070a13;
            --bg-secondary: #0f172a;
            --card-bg: rgba(17, 24, 39, 0.55);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent: #2563eb;
            --accent-light: #60a5fa;
            --accent-glow: rgba(37, 99, 235, 0.15);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --gold: #f59e0b;
            --gold-light: #fbbf24;
        }

        /* Search Highlighting */
        mark.search-highlight {
            background: rgba(234, 179, 8, 0.35) !important;
            color: #fff !important;
            border-radius: 4px !important;
            padding: 2px 4px !important;
            transition: all 0.2s ease !important;
        }

        mark.search-highlight.active-highlight {
            background: #eab308 !important;
            color: #0b0f17 !important;
            box-shadow: 0 0 10px rgba(234, 179, 8, 0.6) !important;
        }

        .sidebar-sticky-wrap {
            position: sticky;
            top: 75px;
            z-index: 10;
        }

        #word-search-card {
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            border-radius: 16px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 50% 0%, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ====== PREMIUM NAVIGATION ====== */
        .nav-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(6, 10, 19, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            line-height: 1;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .nav-logo:hover {
            transform: scale(1.03);
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
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px;
            margin-top: 8px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .nav-dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .nav-dropdown-menu a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-auth {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none !important;
            padding: 8px 16px;
            transition: color 0.2s;
        }

        .btn-login:hover {
            color: var(--accent-light);
        }

        .btn-signup {
            font-size: 13.5px;
            font-weight: 600;
            color: #fff !important;
            background: var(--accent-gradient);
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }

        .btn-signup:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        }

        .nav-user-dropdown {
            position: relative;
        }

        .nav-user-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .nav-user-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .nav-dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 6px 0;
        }

        /* Premium Continent Scroller */
        .nav-underline-premium {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding: 8px;
            background: rgba(148, 163, 184, 0.08) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.25) !important;
            border-radius: 12px;
            margin-bottom: 24px;
            flex-wrap: nowrap !important;
            position: sticky;
            top: 62px;
            z-index: 99;
        }

        .nav-link-premium {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: var(--text-secondary) !important;
            background: transparent !important;
            border: 1px solid transparent !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            display: inline-flex;
            align-items: center;
            text-decoration: none !important;
            white-space: nowrap !important;
        }

        .nav-link-premium:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.04) !important;
        }

        .nav-link-premium.active {
            color: #fff !important;
            background: rgba(59, 130, 246, 0.18) !important;
            border-color: rgba(59, 130, 246, 0.35) !important;
        }

        /* ====== MAIN CONTENT & LAYOUT ====== */
        .main-container {
            max-width: 1400px;
            margin: 40px auto 80px;
            padding: 0 24px;
        }

        .premium-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }

        .premium-card.p-0 img.card-img-top,
        .premium-card.p-0 img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 16px;
        }

        .premium-card .card {
            background: transparent !important;
            border: none !important;
            margin-bottom: 0 !important;
        }

        .card-header-styled {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .card-header-styled h5 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ============================================
           MODAL & TABLE CUSTOMIZATION
           ============================================ */
        .modal-content {
            background: #0f172a !important; /* Premium dark background */
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6) !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color) !important;
            padding: 20px 24px !important;
        }

        .modal-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: var(--text-primary) !important;
        }

        .modal-body {
            padding: 24px !important;
            background: #0b0f17 !important; /* Slightly darker inner body */
        }

        /* Customize the datatable inside modal */
        #viewCases table.table {
            background: transparent !important;
            color: var(--text-primary) !important;
            margin-bottom: 0 !important;
        }

        #viewCases table.table th {
            color: var(--gold) !important;
            font-size: 11px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            font-weight: 700 !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 12px 16px !important;
        }

        #viewCases table.table td {
            padding: 12px 16px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
            color: var(--text-secondary) !important;
            vertical-align: middle !important;
        }

        #viewCases table.table tr:hover td {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.02) !important;
        }

        #viewCases table.table td a {
            color: #60a5fa !important;
            text-decoration: none !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
        }

        #viewCases table.table td a:hover {
            color: #3b82f6 !important;
            text-decoration: underline !important;
        }

        /* DataTables controls inside modal */
        #viewCases .dataTables_wrapper {
            color: var(--text-secondary) !important;
        }

        #viewCases .dataTables_length select,
        #viewCases .dataTables_filter input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            outline: none !important;
        }

        #viewCases .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 13px !important;
            padding-top: 16px !important;
        }

        #viewCases .dataTables_paginate {
            padding-top: 16px !important;
        }

        #viewCases .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            margin: 0 2px !important;
            transition: all 0.2s ease !important;
        }

        #viewCases .dataTables_paginate .paginate_button:hover {
            color: var(--text-primary) !important;
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        #viewCases .dataTables_paginate .paginate_button.current,
        #viewCases .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
            background: rgba(59, 130, 246, 0.2) !important;
            border-color: rgba(59, 130, 246, 0.4) !important;
        }

        /* ====== READABLE TYPOGRAPHY ====== */
        .reading-header-premium {
            margin-bottom: 24px;
        }

        .continent-badge {
            font-size: 11px;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 6px;
        }

        .reading-header-premium h2 {
            font-size: 24px;
            font-weight: 800;
            color: #fff;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .year-badge {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 10px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .judgement_display .content {
            font-size: 15px;
            line-height: 1.8;
            color: var(--text-primary);
        }

        /* Force database inline white HTML text to adapt to dark background */
        .judgement_display .content p,
        .judgement_display .content span,
        .judgement_display .content li,
        .judgement_display .content div,
        .judgement_display .content table,
        .judgement_display .content td,
        .judgement_display .content th,
        .judgement_display .content h1,
        .judgement_display .content h2,
        .judgement_display .content h3,
        .judgement_display .content h4,
        .judgement_display .content h5,
        .judgement_display .content h6 {
            background-color: transparent !important;
            background: transparent !important;
            color: var(--text-primary) !important;
            font-family: 'Inter', sans-serif !important;
        }

        .judgement_display .content p {
            margin-bottom: 20px;
        }

        /* ====== SEARCH BAR UTILITY ====== */
        .search-bar-wrap {
            margin-bottom: 24px;
        }

        .search-input-premium {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            padding: 12px 16px 12px 42px;
            font-size: 14px;
            outline: none;
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-input-premium:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px var(--accent-glow);
        }

        .search-bar-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
        }

        /* ====== ACTIONS BUTTONS ====== */
        .btn-custom-outline {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            font-weight: 500 !important;
            font-size: 13px !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
        }

        .btn-custom-outline:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        body.workspace-maximized .nav-wrap {
            display: none !important;
        }
        body.workspace-maximized .nav-underline-premium {
            top: 10px !important;
        }
        body.workspace-maximized .sidebar-sticky-wrap {
            top: 15px !important;
        }

        .back-to-top {
            position: fixed;
            bottom: 40px;
            right: calc(25% + 20px);
            background: var(--accent-gradient);
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: none;
            align-items: center;
            justify-content: center;
            color: #fff !important;
            box-shadow: 0 4px 16px var(--accent-glow);
            transition: all 0.2s ease;
            z-index: 99;
            text-decoration: none !important;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        /* ====== DATATABLES PREMIUM OVERRIDES ====== */
        .dataTables_wrapper {
            padding: 0;
            color: var(--text-secondary) !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: rgba(17, 24, 39, 0.6) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 8px !important;
            color: var(--text-primary) !important;
            padding: 6px 12px !important;
            outline: none !important;
            margin-left: 8px !important;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 2px var(--accent-glow) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            border-radius: 6px !important;
            border: 1px solid var(--border-color) !important;
            padding: 4px 10px !important;
            background: transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--accent-gradient) !important;
            color: #fff !important;
            border: none !important;
        }

        .table-premium {
            background: transparent !important;
            border-collapse: separate !important;
            border-spacing: 0 8px !important;
            width: 100% !important;
        }

        .table-premium th {
            color: var(--gold) !important;
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 12px 16px !important;
            font-weight: 700 !important;
        }

        .table-premium tr {
            background: rgba(255, 255, 255, 0.02) !important;
        }

        .table-premium td {
            border-top: 1px solid var(--border-color) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 14px 16px !important;
            color: var(--text-primary) !important;
        }

        .table-premium td a {
            color: var(--accent-light) !important;
            font-weight: 600 !important;
        }
        /* ============================================
           NOTES PANEL — RIGHT SIDEBAR
           ============================================ */
        .notes-section { margin-top: 16px; }
        .notes-section-header {
            font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--text-secondary);
            margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
        }
        .notes-section-header i { color: var(--accent-light); font-size: 12px; }
        .notes-count-badge {
            background: var(--accent); color: #fff; font-size: 10px;
            padding: 1px 7px; border-radius: 10px; font-weight: 700;
            letter-spacing: 0;
        }
        .note-textarea {
            width: 100%; min-height: 90px; max-height: 200px;
            background: rgba(255,255,255,0.03); border: 1px solid var(--border-color);
            border-radius: 10px; padding: 12px 14px; color: var(--text-primary);
            font-size: 13px; font-family: var(--font-primary); resize: vertical;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            line-height: 1.5;
        }
        .note-textarea:focus {
            outline: none; border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }
        .note-textarea::placeholder { color: var(--text-muted); font-size: 12px; }
        .note-color-picker { display: flex; gap: 8px; margin: 10px 0; align-items: center; }
        .note-color-picker label { font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-right: 4px; }
        .color-dot {
            width: 20px; height: 20px; border-radius: 50%; cursor: pointer;
            border: 2px solid transparent; transition: all 0.2s ease;
            position: relative;
        }
        .color-dot:hover { transform: scale(1.2); }
        .color-dot.active { border-color: #fff; box-shadow: 0 0 8px currentColor; }
        .color-dot[data-color="yellow"] { background: #f59e0b; }
        .color-dot[data-color="blue"] { background: #3b82f6; }
        .color-dot[data-color="green"] { background: #10b981; }
        .color-dot[data-color="pink"] { background: #ec4899; }
        .color-dot[data-color="purple"] { background: #8b5cf6; }

        .note-actions { display: flex; gap: 8px; margin-top: 8px; }
        .btn-save-note {
            flex: 1; background: var(--accent-gradient); color: #fff;
            border: none; padding: 9px 16px; border-radius: 8px;
            font-size: 12px; font-weight: 700; cursor: pointer;
            transition: all 0.2s ease; letter-spacing: 0.3px;
        }
        .btn-save-note:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59,130,246,0.3); }
        .btn-save-note:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
        .btn-clear-note {
            background: rgba(255,255,255,0.04); color: var(--text-secondary);
            border: 1px solid var(--border-color); padding: 9px 14px; border-radius: 8px;
            font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s ease;
        }
        .btn-clear-note:hover { background: rgba(255,255,255,0.08); color: var(--text-primary); }

        .highlighted-text-preview {
            background: rgba(245,158,11,0.08); border-left: 3px solid #f59e0b;
            padding: 8px 12px; border-radius: 0 8px 8px 0; margin-bottom: 10px;
            font-size: 12px; color: var(--text-secondary); line-height: 1.5;
            max-height: 80px; overflow-y: auto; font-style: italic;
        }
        .highlighted-text-preview .close-highlight {
            float: right; cursor: pointer; color: var(--text-muted); font-size: 14px;
            margin-left: 8px; transition: color 0.2s;
        }
        .highlighted-text-preview .close-highlight:hover { color: #ef4444; }

        /* Saved Notes List Layout */
        .notes-list { margin-top: 16px; display: flex; flex-direction: column; gap: 8px; }
        .notes-list-header {
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;
        }
        
        /* Notes search bar inside sidebar */
        .notes-search-wrap {
            position: relative;
            margin-bottom: 6px;
        }
        .notes-search-wrap i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: var(--text-muted);
        }
        .notes-search-sidebar {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 6px 10px 6px 26px;
            color: var(--text-primary);
            font-size: 11px;
            outline: none;
            transition: all 0.2s;
        }
        .notes-search-sidebar:focus {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Color filters tab bar inside sidebar */
        .notes-filter-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 6px;
            align-items: center;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        .notes-filter-tabs::-webkit-scrollbar {
            height: 2px;
        }
        .notes-filter-tag {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            transition: all 0.2s;
            white-space: nowrap;
        }
        .notes-filter-tag:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
        }
        .notes-filter-tag.active {
            background: rgba(59, 130, 246, 0.15);
            border-color: var(--accent);
            color: var(--accent-light);
        }

        /* Scrollable container viewport */
        .notes-container-scroll {
            max-height: 260px;
            overflow-y: auto;
            padding-right: 4px;
            margin-top: 4px;
        }
        .notes-container-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .notes-container-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 4px;
        }
        .notes-container-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }
        .notes-container-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Interactive Note Cards */
        .note-card {
            background: rgba(255,255,255,0.02); border: 1px solid var(--border-color);
            border-radius: 10px; padding: 12px 14px; position: relative;
            transition: all 0.25s ease; border-left: 3px solid #f59e0b;
            margin-bottom: 8px;
            animation: noteSlideIn 0.3s ease;
        }
        @keyframes noteSlideIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .note-card:hover { border-color: rgba(255,255,255,0.12); background: rgba(255,255,255,0.04); }
        .note-card[data-color="blue"] { border-left-color: #3b82f6; }
        .note-card[data-color="green"] { border-left-color: #10b981; }
        .note-card[data-color="pink"] { border-left-color: #ec4899; }
        .note-card[data-color="purple"] { border-left-color: #8b5cf6; }
        
        .note-card-quote {
            font-size: 11px; color: var(--text-muted); font-style: italic;
            border-left: 2px solid rgba(255,255,255,0.08); padding-left: 8px;
            margin-bottom: 6px; line-height: 1.4; max-height: 38px; overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .note-card-content {
            font-size: 12px; color: var(--text-primary); line-height: 1.4; margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
            transition: max-height 0.3s ease;
        }
        .note-card.expanded .note-card-content {
            display: block;
            overflow: visible;
            max-height: none;
        }
        .note-card.expanded .note-card-quote {
            max-height: none;
            overflow: visible;
        }
        .note-card-expand-indicator {
            display: block;
            text-align: center;
            font-size: 9px;
            color: var(--text-muted);
            margin-top: 2px;
            cursor: pointer;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .note-card-expand-indicator:hover {
            color: var(--text-secondary);
        }
        .note-card-meta {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 10px; color: var(--text-muted);
            border-top: 1px solid rgba(255, 255, 255, 0.03);
            padding-top: 6px;
            margin-top: 6px;
        }
        .note-card-delete {
            cursor: pointer; color: var(--text-muted); font-size: 13px;
            transition: color 0.2s; padding: 2px 4px;
        }
        .note-card-delete:hover { color: #ef4444; }

        /* Login Prompt for Notes */
        .notes-login-prompt {
            background: rgba(59,130,246,0.06); border: 1px solid rgba(59,130,246,0.15);
            border-radius: 10px; padding: 16px; text-align: center;
            margin-top: 12px; display: none;
        }
        .notes-login-prompt p { font-size: 12px; color: var(--text-secondary); margin-bottom: 10px; line-height: 1.5; }
        .notes-login-prompt .btn-login-prompt {
            display: inline-block; background: var(--accent-gradient); color: #fff;
            padding: 7px 18px; border-radius: 8px; font-size: 12px; font-weight: 700;
            text-decoration: none; transition: all 0.2s ease; margin: 0 4px;
        }
        .notes-login-prompt .btn-login-prompt:hover { transform: translateY(-1px); }
        .notes-login-prompt .btn-signup-prompt {
            display: inline-block; background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-color); color: var(--text-primary);
            padding: 7px 18px; border-radius: 8px; font-size: 12px; font-weight: 600;
            text-decoration: none; transition: all 0.2s ease; margin: 0 4px;
        }
        .notes-login-prompt .btn-signup-prompt:hover { background: rgba(255, 255, 255, 0.1); }

        /* Floating Text Selection Tooltip */
        .text-select-tooltip {
            position: absolute; z-index: 9999; display: none;
            background: #1e293b; border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; padding: 6px 8px; box-shadow: 0 8px 30px rgba(0,0,0,0.5);
            animation: tooltipPop 0.15s ease;
        }
        @keyframes tooltipPop {
            from { opacity: 0; transform: scale(0.92); }
            to { opacity: 1; transform: scale(1); }
        }
        .text-select-tooltip button {
            background: transparent; border: none; color: var(--text-secondary);
            padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 5px;
            transition: all 0.15s ease; white-space: nowrap;
        }
        .text-select-tooltip button:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .text-select-tooltip .tooltip-divider {
            display: inline-block; width: 1px; height: 20px;
            background: rgba(255,255,255,0.1); vertical-align: middle; margin: 0 2px;
        }

        /* Reading Progress */
        .reading-progress-wrap {
            padding: 12px 0; margin-bottom: 8px;
        }
        .reading-progress-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--text-muted);
            display: flex; justify-content: space-between; margin-bottom: 6px;
        }
        .reading-progress-label span { color: var(--accent-light); }
        .reading-progress-track {
            width: 100%; height: 4px; background: rgba(255, 255, 255, 0.06);
            border-radius: 4px; overflow: hidden;
        }
        .reading-progress-fill {
            height: 100%; width: 0%; border-radius: 4px;
            background: var(--accent-gradient); transition: width 0.2s ease;
        }

        /* Toast notification */
        .toast-notification {
            position: fixed; bottom: 30px; right: 30px; z-index: 99999;
            background: #1e293b; border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 14px 20px; display: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            animation: toastSlideIn 0.3s ease;
            max-width: 350px;
        }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .toast-notification.success { border-left: 3px solid #10b981; }
        .toast-notification.error { border-left: 3px solid #ef4444; }
        .toast-notification.info { border-left: 3px solid #3b82f6; }
        .toast-notification .toast-content {
            display: flex; align-items: center; gap: 10px;
        }
        .toast-notification .toast-icon { font-size: 16px; }
        .toast-notification.success .toast-icon { color: #10b981; }
        .toast-notification.error .toast-icon { color: #ef4444; }
        .toast-notification.info .toast-icon { color: #3b82f6; }
        .toast-notification .toast-text { font-size: 13px; color: var(--text-primary); font-weight: 500; }

        .sidebar-divider {
            height: 1px; background: var(--border-color);
            margin: 16px 0;
        }

        /* Styling matching .premium-card for the Notes Card */
        .notes-card-sidebar {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }

        /* Collapsible Columns & Sidebar Toggle Elements */
        .transition-width {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar-collapse-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px 8px;
            font-size: 13px;
            transition: color 0.2s, transform 0.2s;
            outline: none !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-collapse-btn:hover {
            color: var(--text-primary);
            transform: scale(1.1);
        }

        .floating-expand-btn {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 56px;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 999999;
            transition: all 0.2s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            outline: none !important;
        }
        .floating-expand-btn:hover {
            background: var(--accent-gradient);
            color: #fff;
            border-color: var(--accent-light);
        }
        #expand-left-btn {
            left: 0;
            border-radius: 0 8px 8px 0;
            border-left: none;
        }
        #expand-right-btn {
            right: 0;
            border-radius: 8px 0 0 8px;
            border-right: none;
        }
        .collapsed-sidebar {
            display: none !important;
        }

        .case-meta-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 24px;
        }
        .case-meta-item {
            font-size: 13px;
            margin-bottom: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .case-meta-label {
            color: var(--accent-light);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 12px;
        }
        .case-meta-val {
            color: var(--text-primary);
            font-weight: 500;
        }

        .action-links-wrap a {
            font-size: 13px;
            color: var(--accent-light);
            font-weight: 600;
            text-decoration: none;
            margin-right: 12px;
            transition: color 0.2s;
        }
        .action-links-wrap a:hover {
            color: var(--gold);
            text-decoration: underline;
        }

        /* Full screen mobile nav panel (Image 1 style) */
        .mobile-nav-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(6, 10, 19, 0.98);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            z-index: 999999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 16px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.4s;
        }

        .mobile-nav-panel.open {
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav-panel a {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-secondary);
            padding: 12px 24px;
            border-radius: 12px;
            line-height: 1.5;
            transform: translateY(24px);
            opacity: 0;
            transition: all 0.3s ease, transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
            text-decoration: none !important;
        }

        .mobile-nav-panel.open a {
            transform: translateY(0);
            opacity: 1;
        }

        .mobile-nav-panel.open a:nth-of-type(1) { transition-delay: 0.05s; }
        .mobile-nav-panel.open a:nth-of-type(2) { transition-delay: 0.1s; }
        .mobile-nav-panel.open a:nth-of-type(3) { transition-delay: 0.15s; }
        .mobile-nav-panel.open a:nth-of-type(4) { transition-delay: 0.2s; }
        .mobile-nav-panel.open a:nth-of-type(5) { transition-delay: 0.25s; }
        .mobile-nav-panel.open a:nth-of-type(6) { transition-delay: 0.3s; }
        .mobile-nav-panel.open a:nth-of-type(7) { transition-delay: 0.35s; }
        .mobile-nav-panel.open a:nth-of-type(8) { transition-delay: 0.4s; }
        .mobile-nav-panel.open a:nth-of-type(9) { transition-delay: 0.45s; }
        .mobile-nav-panel.open a:nth-of-type(10) { transition-delay: 0.5s; }

        .mobile-nav-panel a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px) scale(1.05);
        }

        .mobile-nav-close {
            position: absolute;
            top: 24px;
            right: 24px;
            background: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1 !important;
            color: var(--text-primary);
            font-size: 28px;
            cursor: pointer;
            opacity: 0;
            transform: rotate(-90deg) scale(0.5);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.25s;
            box-shadow: none !important;
            outline: none !important;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-nav-panel.open .mobile-nav-close {
            opacity: 1;
            transform: rotate(0) scale(1);
        }

        .nav-logo-text {
            display: inline-block;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: 'Inter', sans-serif !important;
            margin: 0;
            line-height: 1.3;
        }

        .nav-mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 22px;
            cursor: pointer;
            padding: 8px;
        }

        @media (max-width: 991px) {
            .nav-inner { padding: 14px 20px !important; }
            .nav-menu-links-premium { display: none !important; }
            .nav-mobile-toggle { display: block !important; }
            .nav-auth { display: none !important; }
        }

        @media (max-width: 768px) {
            .nav-logo i {
                font-size: 18px !important;
            }
            .nav-logo-text {
                font-size: 18px !important;
                letter-spacing: 0.2px !important;
            }
            .main-container {
                margin-top: 12px !important;
                padding: 0 12px !important;
            }
            .premium-card {
                padding: 16px !important;
                margin-top: 0 !important;
            }
            #btnMaximizeWorkspace {
                display: none !important;
            }
            .font-adjuster {
                display: none !important;
            }
        }
    </style>
  </head>
  <body>

    <!-- ====== PREMIUM NAVIGATION ====== -->
    <nav class="nav-wrap" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6; font-size: 22px; margin: 0; line-height: 1;"></i>
                <span class="nav-logo-text">Legals Forum</span>
            </a>

            <div class="nav-menu-links-premium">
                @foreach($headerMenus as $menu)
                    @if($menu->is_dropdown)
                        <div class="nav-link-dropdown">
                            <button class="nav-link-btn">{{ $menu->title }} <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></button>
                            <div class="nav-dropdown-menu">
                                @foreach($menu->children as $child)
                                    <a href="{{ $child->custom_content ? route('dynamic.page', $child->slug) : $child->url }}">{{ $child->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}" class="nav-link-btn" style="text-decoration:none !important;">{{ $menu->title }}</a>
                    @endif
                @endforeach
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
            <button class="nav-mobile-toggle" onclick="document.getElementById('mobileNav').classList.add('open')">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Mobile Nav Panel (Image 1 Standard) -->
    <div class="mobile-nav-panel" id="mobileNav">
        <button class="mobile-nav-close" onclick="document.getElementById('mobileNav').classList.remove('open')">
            <i class="fa-solid fa-xmark"></i>
        </button>
        @foreach($headerMenus as $menu)
            @if($menu->is_dropdown)
                @php
                    $url = '#';
                    if ($menu->children && count($menu->children) > 0) {
                        $firstChild = $menu->children->first();
                        $url = $firstChild->custom_content ? route('dynamic.page', $firstChild->slug) : $firstChild->url;
                    }
                @endphp
                <a href="{{ $url }}">{{ $menu->title }}</a>
            @else
                <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}">{{ $menu->title }}</a>
            @endif
        @endforeach
        <div style="height: 16px;"></div>
        @guest
            <a href="{{ route('login') }}">Log In</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" style="color: var(--accent-light);">Sign Up Free</a>
            @endif
        @else
            <a href="/home">Dashboard</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f43f5e;">Sign Out</a>
        @endguest
    </div>

    <!-- ====== MAIN CONTAINER ====== -->
    <div class="main-container">
        <div class="row">
            <!-- Left Sidebar: Notes & Reading Progress -->
            <div class="col-lg-3 transition-width" id="left-sidebar-col">
                <div class="sidebar-sticky-wrap">
                    <!-- My Notes Panel -->
                    <div class="notes-card-sidebar" style="margin-top: 0;">
                        <!-- Reading Progress -->
                        <div class="reading-progress-wrap">
                            <div class="reading-progress-label">
                                Reading Progress <span id="progressPercent">0%</span>
                            </div>
                            <div class="reading-progress-track">
                                <div class="reading-progress-fill" id="progressFill"></div>
                            </div>
                        </div>

                        <div class="sidebar-divider"></div>

                        <!-- Notes Section Header -->
                        <div class="notes-section-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <i class="fa-solid fa-pen-to-square"></i> MY NOTES
                                <span class="notes-count-badge" id="notesCountBadge">0</span>
                            </div>
                            <button type="button" class="sidebar-collapse-btn" onclick="toggleLeftSidebar()" title="Collapse Left Sidebar">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                        </div>

                        <!-- Highlighted text preview -->
                        <div class="highlighted-text-preview" id="highlightedTextPreview" style="display: none;">
                            <span class="close-highlight" onclick="clearHighlightPreview()">&times;</span>
                            <span id="highlightedTextContent"></span>
                        </div>

                        <!-- Note textarea -->
                        <textarea class="note-textarea" id="noteTextarea" placeholder="Write your note here... Select text in the document and click 'Add Note' to attach it."></textarea>

                        <!-- Color picker -->
                        <div class="note-color-picker">
                            <label>Label</label>
                            <div class="color-dot active" data-color="yellow" onclick="selectNoteColor(this)"></div>
                            <div class="color-dot" data-color="blue" onclick="selectNoteColor(this)"></div>
                            <div class="color-dot" data-color="green" onclick="selectNoteColor(this)"></div>
                            <div class="color-dot" data-color="pink" onclick="selectNoteColor(this)"></div>
                            <div class="color-dot" data-color="purple" onclick="selectNoteColor(this)"></div>
                        </div>

                        <!-- Action buttons -->
                        <div class="note-actions">
                            <button class="btn-save-note" id="btnSaveNote" onclick="saveNote()">
                                <i class="fa-solid fa-check mr-1"></i> Save Note
                            </button>
                            <button class="btn-clear-note" onclick="clearNoteForm()">Clear</button>
                        </div>

                        <!-- Login prompt (shown for guests on save attempt) -->
                        <div class="notes-login-prompt" id="notesLoginPrompt">
                            <p><i class="fa-solid fa-lock" style="margin-right:4px;"></i> Create an account to save your notes to your dashboard</p>
                            <a href="{{ route('login') }}" class="btn-login-prompt">Log In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-signup-prompt">Sign Up</a>
                            @endif
                        </div>

                        <div class="sidebar-divider"></div>

                        <!-- Saved notes list -->
                        <div class="notes-list" id="notesList">
                            <div class="notes-list-header">Saved Notes</div>

                            <!-- Search notes -->
                            <div class="notes-search-wrap">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" class="notes-search-sidebar" id="sidebarNotesSearch" placeholder="Search saved notes..." oninput="filterSidebarNotes()">
                            </div>

                            <!-- Filter by color -->
                            <div class="notes-filter-tabs">
                                <div class="notes-filter-tag active" data-filter="all" onclick="filterSidebarColor('all', this)">All</div>
                                <div class="notes-filter-tag" data-filter="yellow" onclick="filterSidebarColor('yellow', this)">Yellow</div>
                                <div class="notes-filter-tag" data-filter="blue" onclick="filterSidebarColor('blue', this)">Blue</div>
                                <div class="notes-filter-tag" data-filter="green" onclick="filterSidebarColor('green', this)">Green</div>
                                <div class="notes-filter-tag" data-filter="pink" onclick="filterSidebarColor('pink', this)">Pink</div>
                                <div class="notes-filter-tag" data-filter="purple" onclick="filterSidebarColor('purple', this)">Purple</div>
                            </div>

                            <!-- Scroll viewport -->
                            <div class="notes-container-scroll">
                                <div id="notesContainer">
                                    <!-- Notes loaded via AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Reading Panel -->
            <div class="col-lg-6 transition-width" id="middle-content-col">
                <!-- Premium Court Category Tabs Menu -->
                @php
                    $groupName = $allGhanaLaw['gh_law_judgment_group_name'] ?? '';
                @endphp
                <div class="nav-underline-premium">
                    <a class="nav-link-premium" href="/judgement/Ghana">
                        <i class="fa-solid fa-gavel mr-2"></i> Case Laws
                    </a>
                    <a class="nav-link-premium {{ strtolower($groupName) === 'supreme-court' ? 'active' : '' }}" href="/judgement/1/Supreme-Court">
                        <i class="fa-solid fa-landmark mr-2"></i> Supreme Court
                    </a>
                    <a class="nav-link-premium {{ strtolower($groupName) === 'court-of-appeal' ? 'active' : '' }}" href="/judgement/3/Court-of-Appeal">
                        <i class="fa-solid fa-scale-balanced mr-2"></i> Court of Appeal
                    </a>
                    <a class="nav-link-premium {{ strtolower($groupName) === 'high-court' ? 'active' : '' }}" href="/judgement/2/High-Court">
                        <i class="fa-solid fa-building-columns mr-2"></i> High Court
                    </a>
                </div>

                <div class="premium-card">
                    <!-- Action Headers -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div class="reading-header-premium">
                            <span class="continent-badge">{{ str_replace('-', ' ', strtoupper($allGhanaLaw['gh_law_judgment_group_name'])) }}</span>
                            <h2>{{ $allGhanaLaw['case_title'] }}</h2>
                            @if(!empty($allGhanaLaw['date']))
                                <span class="year-badge"><i class="fa-regular fa-calendar-check mr-1"></i> {{ $allGhanaLaw['date'] }}</span>
                            @endif
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-custom-outline" data-toggle="modal" data-target="#viewCases">
                                <i class="fa-solid fa-scale-balanced mr-1"></i> View {{ $allGhanaLaw['gh_law_judgment_group_name'] }} Cases
                            </button>
                            <button type="button" class="btn btn-custom-outline ml-2" id="btnMaximizeWorkspace" onclick="toggleMaximizeWorkspace()" title="Maximize View (Toggle Header)" style="margin-left: 10px;">
                                <i class="fa-solid fa-expand" id="maximizeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Preamble & Document Text Body -->
                    <div class="judgement_display">
                        <div class="content" id="constitution-reading-content">  
                            <!-- Court Name -->
                            <center class="mb-4">
                                <h5 style="color: var(--text-primary); font-weight: 800; letter-spacing: 0.5px;"><b>{!! $allGhanaLaw['court_name'] !!}</b></h5>
                            </center>
                            
                            <!-- Case Title Parties -->
                            <center class="mb-4">
                                <h6 style="color: var(--accent-light); font-size: 1.1rem; font-weight: 700;"><b>{!! $allGhanaLaw['case_title_1'] !!}</b></h6>
                                <label style="color: var(--gold); font-weight: 800; margin: 4px 0;">vs.</label>
                                <h6 style="color: var(--accent-light); font-size: 1.1rem; font-weight: 700;"><b>{!! $allGhanaLaw['case_title_2'] !!}</b></h6>
                            </center>

                            <!-- Case Metadata Box -->
                            <div class="case-meta-box">
                                <div class="case-meta-item">
                                    <span class="case-meta-label">DATE:</span>
                                    <span class="case-meta-val">{{ $allGhanaLaw['date'] }}</span>
                                </div>
                                <div class="case-meta-item">
                                    <span class="case-meta-label">{{ $allGhanaLaw['case_type_name'] }}:</span>
                                    <span class="case-meta-val">{{ $allGhanaLaw['reference_number'] }}</span>
                                </div>
                                <div class="case-meta-item">
                                    <span class="case-meta-label">JUDGES:</span>
                                    <span class="case-meta-val">{{ $allGhanaLaw['coram'] }}</span>
                                </div>
                                <div class="case-meta-item">
                                    <span class="case-meta-label">LAWYERS:</span>
                                    <span class="case-meta-val">{!! $allGhanaLaw['counsellors'] !!}</span>
                                </div>
                            </div>
                            
                            <center class="mb-4">
                                <h6 class="alignment" style="color: var(--accent-light); font-weight: 800; letter-spacing: 1px;"><b>{{ $allGhanaLaw['judgement_type'] }}</b></h6>
                            </center>
                            <hr style="border-color: var(--border-color); margin-bottom: 24px;">
                            
                            <!-- Main Judgement Content HTML -->
                            <div class="judgement-body-content">
                                {!! $allGhanaLaw['content'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Search & Advertisements -->
            <div class="col-lg-3 transition-width" id="right-sidebar-col">
                <div class="sidebar-sticky-wrap">
                    <!-- Premium Word Finder Card -->
                    <div class="premium-card mb-4" id="word-search-card" style="padding: 20px;">
                        <div class="card-header-styled" style="margin-bottom: 15px; padding-bottom: 8px; display: flex; justify-content: space-between; align-items: center;">
                            <h5 style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 8px;">
                                <i class="fa-solid fa-magnifying-glass text-primary"></i> Word Finder
                            </h5>
                            <button type="button" class="sidebar-collapse-btn" onclick="toggleRightSidebar()" title="Collapse Right Sidebar">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                        <div class="search-box-premium-wrap">
                            <div class="input-group" style="display: flex; width: 100%;">
                                <input type="text" id="document-search-input" class="form-control" placeholder="Find word..." style="
                                    background: rgba(11, 15, 23, 0.6);
                                    border: 1px solid var(--border-color);
                                    color: var(--text-primary);
                                    border-radius: 8px 0 0 8px;
                                    height: 38px;
                                    font-size: 13px;
                                    font-weight: 500;
                                    padding: 8px 12px;
                                    flex: 1;
                                    outline: none;
                                ">
                                <button type="button" id="search-clear-btn" title="Clear search" style="
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid var(--border-color);
                                    border-left: none;
                                    border-right: none;
                                    color: var(--text-muted);
                                    height: 38px;
                                    width: 30px;
                                    cursor: pointer;
                                    display: none;
                                    align-items: center;
                                    justify-content: center;
                                    outline: none;
                                    transition: color 0.2s ease;
                                "><i class="fa-solid fa-xmark" style="font-size: 12px;"></i></button>
                                <span id="document-search-count" style="
                                    background: rgba(11, 15, 23, 0.6);
                                    border-top: 1px solid var(--border-color);
                                    border-bottom: 1px solid var(--border-color);
                                    border-left: none;
                                    border-right: none;
                                    color: var(--text-secondary);
                                    font-size: 11px;
                                    font-weight: 700;
                                    height: 38px;
                                    display: flex;
                                    align-items: center;
                                    padding: 0 8px;
                                    white-space: nowrap;
                                    user-select: none;
                                ">0/0</span>
                                <button type="button" id="search-prev-btn" style="
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid var(--border-color);
                                    border-left: none;
                                    border-right: none;
                                    color: var(--text-secondary);
                                    height: 38px;
                                    width: 32px;
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    outline: none;
                                " disabled><i class="fa-solid fa-chevron-up" style="font-size: 11px;"></i></button>
                                <button type="button" id="search-next-btn" style="
                                    background: rgba(255, 255, 255, 0.05);
                                    border: 1px solid var(--border-color);
                                    border-left: none;
                                    border-radius: 0 8px 8px 0;
                                    color: var(--text-secondary);
                                    height: 38px;
                                    width: 32px;
                                    cursor: pointer;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    outline: none;
                                " disabled><i class="fa-solid fa-chevron-down" style="font-size: 11px;"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Advertisement Module -->
                    <div class="premium-card p-0" style="overflow: hidden;">
                        @include('ads.small_ads_image_main_page')
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Expand Buttons -->
        <button class="floating-expand-btn" id="expand-left-btn" onclick="toggleLeftSidebar()" title="Expand Left Sidebar">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        <button class="floating-expand-btn" id="expand-right-btn" onclick="toggleRightSidebar()" title="Expand Right Sidebar">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>

    <!-- Case Selector Modal -->
    <div class="modal fade" id="viewCases" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-gavel mr-2 text-primary"></i> Select Case in {{ $allGhanaLaw['gh_law_judgment_group_name'] }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:#fff;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <table class="table-premium table table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>Case Laws Title</th>
                                <th>Ref No.</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allGhanaLaws as $law)
                                <tr>
                                    <td>
                                        <a href="/judgement/Ghana/{{ $law->gh_law_judgment_group_name }}/{{ $law->id }}">
                                            {{ $law->case_title }}
                                        </a>
                                    </td>
                                    <td>{{ $law->reference_number }}</td>
                                    <td>{{ $law->year }}</td>
                                </tr>
                            @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top floating button -->
    <a id="back-to-top" href="#" class="back-to-top">
        <i class="fa-solid fa-arrow-up"></i>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    <script src="{{ asset('js/myscript.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function(){
            $('#datatable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "responsive": true
            });

            // back-to-top scroll animation
            $('#back-to-top').click(function (e) {
                e.preventDefault();
                $('body,html').animate({
                    scrollTop: 0
                }, 400);
            });

            // Disable copy paste on document body
            $('body').bind('cut copy paste', function (e) {
                e.preventDefault();
            });

            // Close user dropdown on click outside
            document.addEventListener('click', (e) => {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });

            // Premium document word search highlighting and navigation
            let currentIndex = -1;
            let highlights = [];
            let originalHTML = "";
            const contentArea = document.getElementById('constitution-reading-content');
            if (contentArea) {
                originalHTML = contentArea.innerHTML;
            }
            
            const searchInput = document.getElementById('document-search-input');
            const prevBtn = document.getElementById('search-prev-btn');
            const nextBtn = document.getElementById('search-next-btn');
            const clearBtn = document.getElementById('search-clear-btn');
            const countLabel = document.getElementById('document-search-count');
            
            if (searchInput && prevBtn && nextBtn && countLabel) {
                searchInput.addEventListener('input', function() {
                    performSearch(searchInput.value.trim());
                    if (clearBtn) {
                        clearBtn.style.display = searchInput.value.length > 0 ? 'flex' : 'none';
                    }
                });
                
                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        performSearch('');
                        clearBtn.style.display = 'none';
                        searchInput.focus();
                    });
                }
                
                prevBtn.addEventListener('click', function() {
                    if (highlights.length > 0) {
                        currentIndex = (currentIndex - 1 + highlights.length) % highlights.length;
                        navigateToHighlight();
                    }
                });
                
                nextBtn.addEventListener('click', function() {
                    if (highlights.length > 0) {
                        currentIndex = (currentIndex + 1) % highlights.length;
                        navigateToHighlight();
                    }
                });
            }
            
            function performSearch(query) {
                if (!contentArea) return;
                
                contentArea.innerHTML = originalHTML;
                currentIndex = -1;
                highlights = [];
                
                if (!query || query.length < 2) {
                    countLabel.textContent = "0/0";
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                    return;
                }
                
                const nodes = [];
                const walker = document.createTreeWalker(contentArea, NodeFilter.SHOW_TEXT, null, false);
                while (walker.nextNode()) {
                    nodes.push(walker.currentNode);
                }
                
                const regex = new RegExp('(' + escapeRegExp(query) + ')', 'gi');
                
                nodes.forEach(node => {
                    const text = node.nodeValue;
                    if (text && regex.test(text)) {
                        if (node.parentNode) {
                            const span = document.createElement('span');
                            span.innerHTML = text.replace(regex, '<mark class="search-highlight">$1</mark>');
                            node.parentNode.replaceChild(span, node);
                        }
                    }
                });
                
                highlights = contentArea.querySelectorAll('.search-highlight');
                
                if (highlights.length > 0) {
                    currentIndex = 0;
                    countLabel.textContent = `1/${highlights.length}`;
                    prevBtn.disabled = false;
                    nextBtn.disabled = false;
                    navigateToHighlight();
                } else {
                    countLabel.textContent = "0/0";
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                }
            }
            
            function escapeRegExp(string) {
                return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }
            
            function navigateToHighlight() {
                highlights.forEach(h => {
                    h.classList.remove('active-highlight');
                    h.style.background = 'rgba(234, 179, 8, 0.35)';
                    h.style.color = '#fff';
                });
                
                if (currentIndex >= 0 && currentIndex < highlights.length) {
                    const active = highlights[currentIndex];
                    active.classList.add('active-highlight');
                    active.style.background = '#eab308';
                    active.style.color = '#0b0f17';
                    
                    countLabel.textContent = `${currentIndex + 1}/${highlights.length}`;
                    
                    active.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }

            // Auto-fill Word Finder and scroll to matching term from URL parameter (e.g. ?search_text=criminal)
            const urlParams = new URLSearchParams(window.location.search);
            const initialSearchTerm = urlParams.get('search_text') || urlParams.get('search') || urlParams.get('query') || urlParams.get('highlight');
            if (initialSearchTerm && searchInput) {
                const cleanTerm = initialSearchTerm.trim();
                if (cleanTerm.length > 0) {
                    searchInput.value = cleanTerm;
                    if (clearBtn) {
                        clearBtn.style.display = 'flex';
                    }
                    setTimeout(function() {
                        performSearch(cleanTerm);
                    }, 300);
                }
            }
        });
    </script>

    <!-- Notes & Reader Tools JS -->
    <script>
    var selectedNoteColor = 'yellow';

    function selectNoteColor(el) {
        document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('active'));
        el.classList.add('active');
        selectedNoteColor = el.getAttribute('data-color');
    }

    function saveNote() {
        var noteContent = document.getElementById('noteTextarea').value.trim();
        if (!noteContent) { showToast('Please write a note first.', 'error'); return; }

        var highlightedText = '';
        var previewEl = document.getElementById('highlightedTextPreview');
        if (previewEl.style.display !== 'none') {
            highlightedText = document.getElementById('highlightedTextContent').textContent;
        }

        var documentTitle = '{{ $allGhanaLaw["case_title"] }}';
        var sectionText = '{{ $allGhanaLaw["gh_law_judgment_group_name"] }}';

        $.ajax({
            url: '/notes',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                document_type: 'judgement',
                document_id: '{{ $allGhanaLaw["id"] ?? 0 }}',
                document_title: documentTitle,
                highlighted_text: highlightedText,
                note_content: noteContent,
                note_color: selectedNoteColor,
                article_section: sectionText,
                page_url: window.location.href
            },
            success: function(response) {
                if (response.success) {
                    var container = document.getElementById('notesContainer');
                    var card = createNoteCardElement(response.note);
                    container.insertBefore(card, container.firstChild);
                    clearNoteForm();
                    updateNotesCount(1);
                    showToast('Note saved!', 'success');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    document.getElementById('notesLoginPrompt').style.display = 'block';
                } else {
                    showToast('Failed to save note.', 'error');
                }
            }
        });
    }

    $(document).ready(function() {
        @auth
        $.ajax({
            url: '/notes/document',
            type: 'GET',
            data: { page_url: window.location.pathname },
            success: function(response) {
                if (response.notes && response.notes.length > 0) {
                    var container = document.getElementById('notesContainer');
                    response.notes.forEach(function(note) {
                        var card = createNoteCardElement(note);
                        container.appendChild(card);
                    });
                    document.getElementById('notesCountBadge').textContent = response.notes.length;
                }
            }
        });
        @endauth

        window.addEventListener('scroll', function() {
            var scrollTop = window.scrollY || document.documentElement.scrollTop;
            var scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var progress = scrollHeight > 0 ? Math.round((scrollTop / scrollHeight) * 100) : 0;
            progress = Math.min(100, Math.max(0, progress));

            var progressFill = document.getElementById('progressFill');
            var progressPercent = document.getElementById('progressPercent');
            if (progressFill) progressFill.style.width = progress + '%';
            if (progressPercent) progressPercent.textContent = progress + '%';

            var backToTopBtn = document.getElementById('back-to-top');
            if (backToTopBtn) {
                if (scrollTop > 300) {
                    backToTopBtn.style.display = 'flex';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            }
        });
    });

    function createNoteCardElement(note) {
        var card = document.createElement('div');
        card.className = 'note-card';
        card.setAttribute('data-color', note.note_color);
        card.setAttribute('data-note-id', note.id);

        var html = '';
        if (note.highlighted_text) {
            html += '<div class="note-card-quote">"' + escapeHtml(note.highlighted_text) + '"</div>';
        }
        html += '<div class="note-card-content" onclick="toggleNoteCardExpand(this)">' + escapeHtml(note.note_content) + '</div>';

        var isLong = note.note_content.length > 70 || (note.highlighted_text && note.highlighted_text.length > 70);
        if (isLong) {
            html += '<div class="note-card-expand-indicator" onclick="toggleNoteCardExpand(this)">Read More</div>';
        }

        html += '<div class="note-card-meta">';
        html += '<span>' + (note.article_section ? escapeHtml(note.article_section.substring(0, 30)) : '') + ' · ' + note.created_at + '</span>';
        html += '<i class="fa-solid fa-trash-can note-card-delete" onclick="deleteNote(' + note.id + ', this)" title="Delete note"></i>';
        html += '</div>';
        card.innerHTML = html;
        return card;
    }

    function toggleNoteCardExpand(el) {
        var card = el.closest('.note-card');
        card.classList.toggle('expanded');
        var indicator = card.querySelector('.note-card-expand-indicator');
        if (indicator) {
            indicator.textContent = card.classList.contains('expanded') ? 'Read Less' : 'Read More';
        }
    }

    function deleteNote(noteId, el) {
        if (!confirm('Delete this note?')) return;
        $.ajax({
            url: '/notes/' + noteId,
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.success) {
                    var card = el.closest('.note-card');
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(20px)';
                    card.style.transition = 'all 0.3s ease';
                    setTimeout(function() { card.remove(); updateNotesCount(-1); applySidebarFilters(); }, 300);
                    showToast('Note deleted.', 'success');
                }
            },
            error: function() { showToast('Failed to delete note.', 'error'); }
        });
    }

    function updateNotesCount(delta) {
        var badge = document.getElementById('notesCountBadge');
        var count = parseInt(badge.textContent) + delta;
        badge.textContent = Math.max(0, count);
    }

    var activeSidebarColorFilter = 'all';
    function filterSidebarColor(color, el) {
        document.querySelectorAll('.notes-filter-tag').forEach(tag => tag.classList.remove('active'));
        el.classList.add('active');
        activeSidebarColorFilter = color;
        applySidebarFilters();
    }

    function filterSidebarNotes() { applySidebarFilters(); }

    function applySidebarFilters() {
        var searchVal = document.getElementById('sidebarNotesSearch').value.toLowerCase();
        var cards = document.querySelectorAll('#notesContainer .note-card');
        var visibleCount = 0;
        cards.forEach(function(card) {
            var colorMatch = (activeSidebarColorFilter === 'all' || card.getAttribute('data-color') === activeSidebarColorFilter);
            var searchMatch = !searchVal || card.textContent.toLowerCase().indexOf(searchVal) !== -1;
            card.style.display = (colorMatch && searchMatch) ? 'block' : 'none';
            if (colorMatch && searchMatch) visibleCount++;
        });
        var emptyMsg = document.getElementById('sidebarNotesEmptyFilter');
        if (visibleCount === 0 && cards.length > 0) {
            if (!emptyMsg) {
                emptyMsg = document.createElement('div');
                emptyMsg.id = 'sidebarNotesEmptyFilter';
                emptyMsg.style.cssText = 'text-align:center;padding:12px;color:var(--text-muted);font-size:11px;';
                emptyMsg.innerHTML = '<i class="fa-solid fa-filter-circle-xmark" style="font-size:16px;margin-bottom:6px;display:block;opacity:0.5;"></i>No matching notes';
                document.getElementById('notesContainer').appendChild(emptyMsg);
            }
        } else if (emptyMsg) { emptyMsg.remove(); }
    }

    var currentSelection = '';

    document.addEventListener('mouseup', function(e) {
        var tooltip = document.getElementById('textSelectTooltip');
        var readingPane = document.querySelector('.judgement_display');

        if (!readingPane || !readingPane.contains(e.target)) {
            if (tooltip && !tooltip.contains(e.target)) { tooltip.style.display = 'none'; }
            return;
        }

        setTimeout(function() {
            var sel = window.getSelection();
            var text = sel.toString().trim();
            if (text.length > 3) {
                currentSelection = text;
                var range = sel.getRangeAt(0);
                var rect = range.getBoundingClientRect();
                tooltip.style.top = (rect.top - 50 + window.scrollY) + 'px';
                tooltip.style.left = (rect.left + rect.width / 2 - 100) + 'px';
                tooltip.style.display = 'flex';
            } else {
                if (tooltip) tooltip.style.display = 'none';
            }
        }, 10);
    });

    function addNoteFromSelection() {
        if (!currentSelection) return;
        document.getElementById('highlightedTextContent').textContent = currentSelection.substring(0, 500);
        document.getElementById('highlightedTextPreview').style.display = 'block';
        document.getElementById('noteTextarea').focus();
        document.getElementById('textSelectTooltip').style.display = 'none';
        document.querySelector('.notes-card-sidebar').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function copySelection() {
        if (!currentSelection) return;
        navigator.clipboard.writeText(currentSelection);
        document.getElementById('textSelectTooltip').style.display = 'none';
        showToast('Text copied!', 'success');
    }

    function citeSelection() {
        if (!currentSelection) return;
        var documentTitle = '{{ $allGhanaLaw["case_title"] }}';
        var cite = currentSelection + '\n\n— ' + documentTitle + ' (Legals Forum)';
        navigator.clipboard.writeText(cite);
        document.getElementById('textSelectTooltip').style.display = 'none';
        showToast('Citation copied!', 'success');
    }

    function clearNoteForm() {
        document.getElementById('noteTextarea').value = '';
        clearHighlightPreview();
    }

    function clearHighlightPreview() {
        document.getElementById('highlightedTextPreview').style.display = 'none';
        document.getElementById('highlightedTextContent').textContent = '';
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showToast(message, type) {
        var toast = document.getElementById('toastNotification');
        var toastText = document.getElementById('toastText');
        var toastIcon = toast.querySelector('.toast-icon');
        toastText.textContent = message;
        toast.className = 'toast-notification ' + type;
        toastIcon.className = 'toast-icon fa-solid ' + (type === 'success' ? 'fa-circle-check' : type === 'error' ? 'fa-circle-xmark' : 'fa-circle-info');
        toast.style.display = 'block';
        setTimeout(function() { toast.style.display = 'none'; }, 3000);
    }

    var leftSidebarCollapsed = false;
    var rightSidebarCollapsed = false;

    function toggleLeftSidebar() {
        leftSidebarCollapsed = !leftSidebarCollapsed;
        var sidebar = document.getElementById('left-sidebar-col');
        var expandBtn = document.getElementById('expand-left-btn');
        
        if (leftSidebarCollapsed) {
            sidebar.classList.add('collapsed-sidebar');
            expandBtn.style.display = 'flex';
        } else {
            sidebar.classList.remove('collapsed-sidebar');
            expandBtn.style.display = 'none';
        }
        updateMiddleColumnWidth();
    }

    function toggleRightSidebar() {
        rightSidebarCollapsed = !rightSidebarCollapsed;
        var sidebar = document.getElementById('right-sidebar-col');
        var expandBtn = document.getElementById('expand-right-btn');
        
        if (rightSidebarCollapsed) {
            sidebar.classList.add('collapsed-sidebar');
            expandBtn.style.display = 'flex';
        } else {
            sidebar.classList.remove('collapsed-sidebar');
            expandBtn.style.display = 'none';
        }
        updateMiddleColumnWidth();
    }

    function updateMiddleColumnWidth() {
        var middleCol = document.getElementById('middle-content-col');
        middleCol.classList.remove('col-lg-6', 'col-lg-9', 'col-lg-12');
        
        var leftWidth = leftSidebarCollapsed ? 0 : 3;
        var rightWidth = rightSidebarCollapsed ? 0 : 3;
        var middleWidth = 12 - leftWidth - rightWidth;
        
        middleCol.classList.add('col-lg-' + middleWidth);
    }

    function toggleMaximizeWorkspace() {
        const body = document.body;
        body.classList.toggle('workspace-maximized');
        
        const btn = document.getElementById('btnMaximizeWorkspace');
        if (btn) {
            if (body.classList.contains('workspace-maximized')) {
                btn.innerHTML = `<i class="fa-solid fa-compress" id="maximizeIcon"></i>`;
                btn.classList.add('active');
            } else {
                btn.innerHTML = `<i class="fa-solid fa-expand" id="maximizeIcon"></i>`;
                btn.classList.remove('active');
            }
        }

        if (body.classList.contains('workspace-maximized')) {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen().catch(() => {});
            }
        } else {
            if (document.exitFullscreen && document.fullscreenElement) {
                document.exitFullscreen().catch(() => {});
            }
        }
    }

    document.addEventListener('fullscreenchange', () => {
        const body = document.body;
        const btn = document.getElementById('btnMaximizeWorkspace');
        if (!document.fullscreenElement) {
            body.classList.remove('workspace-maximized');
            if (btn) {
                btn.innerHTML = `<i class="fa-solid fa-expand" id="maximizeIcon"></i>`;
                btn.classList.remove('active');
            }
        }
    });
    </script>

    <!-- Floating Text Selection Tooltip -->
    <div class="text-select-tooltip" id="textSelectTooltip">
        <button onclick="addNoteFromSelection()"><i class="fa-solid fa-pen"></i> Note</button>
        <span class="tooltip-divider"></span>
        <button onclick="copySelection()"><i class="fa-regular fa-copy"></i> Copy</button>
        <span class="tooltip-divider"></span>
        <button onclick="citeSelection()"><i class="fa-solid fa-quote-left"></i> Cite</button>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notification" id="toastNotification">
        <div class="toast-content">
            <i class="toast-icon fa-solid fa-circle-check"></i>
            <span class="toast-text" id="toastText"></span>
        </div>
    </div>
  </body>
</html>
