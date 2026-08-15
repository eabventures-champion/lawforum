@extends('layouts.user')

@section('title', 'My Bookmarks')

@section('styles')
<style>
    .bookmarks-filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
        align-items: center;
    }
    .bookmarks-search-input {
        flex: 1;
        min-width: 220px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: inherit;
        transition: border-color 0.2s ease;
    }
    .bookmarks-search-input:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
    }
    .bookmarks-search-input::placeholder {
        color: var(--text-muted);
    }

    .filter-select {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: inherit;
        cursor: pointer;
    }
    /* Custom Filter Dropdowns */
    .custom-filter-dropdown {
        position: relative;
        min-width: 170px;
    }
    .custom-filter-trigger {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s ease;
        box-sizing: border-box;
        text-align: left;
    }
    .custom-filter-trigger:hover {
        background: rgba(255, 255, 255, 0.07);
        border-color: rgba(255, 255, 255, 0.2);
    }
    .custom-filter-chevron {
        font-size: 10px;
        color: var(--text-muted);
        transition: transform 0.2s ease;
    }
    .custom-filter-dropdown.open .custom-filter-chevron {
        transform: rotate(180deg);
    }
    .custom-filter-menu {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        min-width: 100%;
        width: max-content;
        max-width: 280px;
        background: #0f172a;
        background: linear-gradient(180deg, #111827 0%, #0b0f19 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.8), 0 0 20px rgba(245, 158, 11, 0.1);
        z-index: 150;
        display: none;
        box-sizing: border-box;
    }
    .custom-filter-menu.show {
        display: block;
    }
    .custom-filter-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        width: 100%;
        padding: 8px 12px;
        border-radius: 8px;
        color: #cbd5e1;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
        box-sizing: border-box;
        user-select: none;
    }
    .custom-filter-option:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }
    .custom-filter-option.active {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        font-weight: 600;
    }
    .custom-filter-option .check-icon {
        font-size: 11px;
        opacity: 0;
        transition: opacity 0.15s ease;
    }
    .custom-filter-option.active .check-icon {
        opacity: 1;
    }

    @media (max-width: 768px) {
        .custom-filter-dropdown {
            width: 100% !important;
            min-width: 0 !important;
        }
        .custom-filter-menu {
            width: 100% !important;
            max-width: 100% !important;
        }
    }

    /* ====== VIEW SWITCHER (CARDS vs LINEAR) ====== */
    .view-switcher-group {
        display: inline-flex;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        padding: 3px;
        border-radius: 9px;
        gap: 3px;
    }
    .view-toggle-btn {
        background: transparent;
        border: none;
        color: var(--text-secondary);
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .view-toggle-btn:hover {
        color: var(--text-primary);
        background: rgba(255, 255, 255, 0.04);
    }
    .view-toggle-btn.active {
        background: rgba(245, 158, 11, 0.18);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.35);
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
    }

    /* ====== BOOKMARKS CONTAINER ====== */
    #bookmarksListDashboard {
        display: grid;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Common Card Styles */
    .bookmark-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 4px solid #f59e0b;
        box-sizing: border-box;
        position: relative;
    }
    .bookmark-card[data-type="constitution"] { border-left-color: #3b82f6; }
    .bookmark-card[data-type="case_law"] { border-left-color: #10b981; }
    .bookmark-card[data-type="pre_1992"] { border-left-color: #f97316; }
    .bookmark-card[data-type="legislation"] { border-left-color: #8b5cf6; }

    .bookmark-type-badge {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 3.5px 9px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    .badge-constitution { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
    .badge-case-law { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-pre-1992 { background: rgba(249, 115, 22, 0.15); color: #fb923c; border: 1px solid rgba(249, 115, 22, 0.3); }
    .badge-legislation { background: rgba(139, 92, 246, 0.15); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.3); }

    .bookmark-date {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .bookmark-section-title {
        font-size: 14.5px;
        font-weight: 700;
        color: #fff;
        line-height: 1.4;
        cursor: pointer;
        transition: color 0.2s ease;
        word-break: break-word;
    }
    .bookmark-section-title:hover {
        color: #f59e0b;
    }

    .bookmark-doc-title {
        font-size: 12px;
        color: var(--text-secondary);
        line-height: 1.4;
        cursor: pointer;
        opacity: 0.9;
    }

    .btn-view-bookmark {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.25);
        color: #60a5fa;
        padding: 6px 13px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-view-bookmark:hover {
        background: #3b82f6;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-delete-bookmark {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #f87171;
        padding: 6px 11px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-delete-bookmark:hover {
        background: #ef4444;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* 1. CARDS / GRID VIEW */
    #bookmarksListDashboard.view-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        align-items: stretch;
    }
    #bookmarksListDashboard.view-grid .bookmark-card {
        padding: 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        min-width: 0;
    }
    #bookmarksListDashboard.view-grid .bookmark-card:hover {
        border-color: rgba(255, 255, 255, 0.16);
        background: rgba(255, 255, 255, 0.04);
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.4);
    }
    #bookmarksListDashboard.view-grid .bookmark-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        gap: 8px;
    }
    #bookmarksListDashboard.view-grid .bookmark-card-body {
        flex: 1 1 auto;
        margin-bottom: 14px;
        min-width: 0;
    }
    #bookmarksListDashboard.view-grid .bookmark-section-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 6px;
    }
    #bookmarksListDashboard.view-grid .bookmark-doc-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #bookmarksListDashboard.view-grid .bookmark-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding-top: 12px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }
    #bookmarksListDashboard.view-grid .bookmark-linear-date {
        display: none;
    }

    /* 2. LINEAR / LIST VIEW (Refined Table-Row Style) */
    #bookmarksListDashboard.view-linear {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    #bookmarksListDashboard.view-linear .bookmark-card {
        padding: 12px 18px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    #bookmarksListDashboard.view-linear .bookmark-card:hover {
        border-color: rgba(245, 158, 11, 0.4);
        background: rgba(255, 255, 255, 0.035);
        transform: translateX(2px);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.3);
    }
    #bookmarksListDashboard.view-linear .bookmark-card-main-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1 1 auto;
        min-width: 0;
    }
    #bookmarksListDashboard.view-linear .bookmark-card-top {
        margin-bottom: 0;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 3px;
        min-width: 110px;
    }
    #bookmarksListDashboard.view-linear .bookmark-card-top .bookmark-date {
        display: flex;
        font-size: 11px;
        color: var(--text-muted);
        white-space: nowrap;
    }
    #bookmarksListDashboard.view-linear .bookmark-card-body {
        margin-bottom: 0;
        flex: 1 1 auto;
        min-width: 0;
    }
    #bookmarksListDashboard.view-linear .bookmark-section-title {
        font-size: 14.5px;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #bookmarksListDashboard.view-linear .bookmark-doc-title {
        font-size: 11.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #bookmarksListDashboard.view-linear .bookmark-card-footer {
        border-top: none;
        padding-top: 0;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    #bookmarksListDashboard.view-linear .bookmark-linear-date {
        display: none;
    }

    .btn-save-inline {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        color: #fff;
        padding: 6px 16px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-save-inline:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
    }

    /* Color picker radio chips */
    .color-chip-radio {
        display: none;
    }
    .color-chip-label {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        cursor: pointer;
        display: inline-block;
        border: 2px solid transparent;
        transition: transform 0.15s ease, border-color 0.15s ease;
    }
    .color-chip-radio:checked + .color-chip-label {
        transform: scale(1.25);
        border-color: #fff;
        box-shadow: 0 0 8px rgba(255, 255, 255, 0.4);
    }

    /* ====== PREVIEW MODAL STYLES ====== */
    .bm-modal-backdrop {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: 2147483640 !important;
        background: rgba(4, 8, 20, 0.88) !important;
        backdrop-filter: blur(14px) !important;
        -webkit-backdrop-filter: blur(14px) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 24px !important;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s ease !important;
        box-sizing: border-box !important;
    }
    .bm-modal-backdrop.active {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }
    .bm-modal-card {
        background: #0b1120 !important;
        background: linear-gradient(180deg, #0e1626 0%, #080d18 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 20px !important;
        max-width: 840px !important;
        width: 100% !important;
        max-height: 90vh !important;
        display: flex !important;
        flex-direction: column !important;
        box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.95), 0 0 50px rgba(59, 130, 246, 0.15) !important;
        position: relative !important;
        transform: translateY(24px) scale(0.96) !important;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
        color: #f3f4f6 !important;
        box-sizing: border-box !important;
        overflow: hidden !important;
    }
    .bm-modal-backdrop.active .bm-modal-card {
        transform: translateY(0) scale(1) !important;
    }
    .bm-modal-header {
        padding: 22px 28px 18px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        gap: 16px !important;
        background: rgba(255, 255, 255, 0.02) !important;
    }
    .bm-modal-close {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #94a3b8 !important;
        width: 34px !important;
        height: 34px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        font-size: 15px !important;
        padding: 0 !important;
        flex-shrink: 0 !important;
    }
    .bm-modal-close:hover {
        background: rgba(239, 68, 68, 0.2) !important;
        color: #f87171 !important;
        border-color: rgba(239, 68, 68, 0.4) !important;
        transform: rotate(90deg) !important;
    }
    .bm-modal-body {
        padding: 24px 28px !important;
        overflow-y: auto !important;
        flex: 1 1 auto !important;
        font-size: 15.5px !important;
        line-height: 1.85 !important;
        color: #cbd5e1 !important;
    }
    .bm-modal-body p {
        margin-bottom: 14px !important;
    }
    .bm-modal-body .nav-links {
        display: none !important;
    }
    .bm-modal-footer {
        padding: 16px 28px !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        background: rgba(255, 255, 255, 0.02) !important;
        gap: 12px !important;
        flex-wrap: wrap !important;
    }

    /* Responsive Grid */
    @media (max-width: 1100px) {
        #bookmarksListDashboard.view-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 768px) {
        .view-switcher-group {
            display: none !important;
        }
        #bookmarksListDashboard.view-grid,
        #bookmarksListDashboard.view-linear {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
        }
        #bookmarksListDashboard .bookmark-card {
            padding: 16px 16px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }
        #bookmarksListDashboard .bookmark-card-main-wrapper {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
            width: 100% !important;
        }
        #bookmarksListDashboard .bookmark-card-top {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            margin-bottom: 0 !important;
            min-width: 0 !important;
        }
        #bookmarksListDashboard .bookmark-card-top .bookmark-date {
            display: flex !important;
        }
        #bookmarksListDashboard .bookmark-linear-date {
            display: none !important;
        }
        #bookmarksListDashboard .bookmark-card-body {
            margin-bottom: 0 !important;
            width: 100% !important;
        }
        #bookmarksListDashboard .bookmark-section-title {
            font-size: 14.5px !important;
            white-space: normal !important;
            line-height: 1.4 !important;
        }
        #bookmarksListDashboard .bookmark-doc-title {
            font-size: 12px !important;
            white-space: normal !important;
        }
        #bookmarksListDashboard .bookmark-card-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
            padding-top: 10px !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }
        .bookmarks-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .bm-modal-header, .bm-modal-body, .bm-modal-footer {
            padding: 16px 18px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="card-title" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <i class="fa-solid fa-bookmark" style="color: #f59e0b; font-size: 22px;"></i>
                <span>My Bookmarks</span>
                <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); padding: 2px 9px; border-radius: 12px; font-size: 13px; font-weight: 700;">
                    <span id="bookmarksCountDisplay">{{ count($bookmarks) }}</span>
                </span>
            </h1>
            <p class="card-subtitle" style="margin-bottom: 0;">Quickly access and manage your saved sections across Constitution, Existing Laws, New Laws, and Case Judgments.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            {{-- View Switcher (Cards vs Linear) --}}
            <div class="view-switcher-group">
                <button type="button" class="view-toggle-btn" id="btnBmViewGrid" onclick="switchBookmarksView('grid')" title="Cards / Grid View">
                    <i class="fa-solid fa-table-cells"></i>
                    <span>Cards</span>
                </button>
                <button type="button" class="view-toggle-btn active" id="btnBmViewLinear" onclick="switchBookmarksView('linear')" title="Linear / List View">
                    <i class="fa-solid fa-bars"></i>
                    <span>Linear</span>
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-banner alert-banner-success" style="margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filter and Search Controls --}}
    <div class="bookmarks-filter-bar">
        <input type="text" id="bookmarkSearchInput" class="bookmarks-search-input" placeholder="Search by section, act title, or keyword..." onkeyup="filterBookmarks()">
        
        {{-- Custom Dropdown: Categories --}}
        <div class="custom-filter-dropdown" id="dropdownBmCategoryContainer">
            <input type="hidden" id="bookmarkCategoryFilter" value="all">
            <button type="button" class="custom-filter-trigger" onclick="toggleCustomFilterDropdown(event, 'dropdownBmCategoryMenu')">
                <span id="labelBmCategory">All Categories</span>
                <i class="fa-solid fa-chevron-down custom-filter-chevron"></i>
            </button>
            <div class="custom-filter-menu" id="dropdownBmCategoryMenu">
                <div class="custom-filter-option active" onclick="selectCustomFilter('bookmarkCategoryFilter', 'all', 'All Categories', 'labelBmCategory', 'dropdownBmCategoryMenu')">
                    <span>All Categories</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('bookmarkCategoryFilter', 'constitution', 'Constitution', 'labelBmCategory', 'dropdownBmCategoryMenu')">
                    <span>Constitution</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('bookmarkCategoryFilter', 'legislation', 'Acts of Parliament', 'labelBmCategory', 'dropdownBmCategoryMenu')">
                    <span>Acts of Parliament</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('bookmarkCategoryFilter', 'pre_1992', 'Existing Laws', 'labelBmCategory', 'dropdownBmCategoryMenu')">
                    <span>Existing Laws</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('bookmarkCategoryFilter', 'case_law', 'Case Judgments', 'labelBmCategory', 'dropdownBmCategoryMenu')">
                    <span>Case Judgments</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Bookmarks Container (Grid or Linear) --}}
    <div id="bookmarksListDashboard" class="view-linear">
        @forelse($bookmarks as $bookmark)
            @php
                // Resolve direct URL
                $url = $bookmark->page_url;
                $docType = $bookmark->document_type;

                if (empty($docType)) {
                    if (stripos($bookmark->act_group, 'Constitution') !== false) {
                        $docType = 'constitution';
                    } elseif (stripos($bookmark->act_group, 'Case') !== false || stripos($bookmark->act_group, 'Court') !== false) {
                        $docType = 'case_law';
                    } elseif (in_array($bookmark->act_group, ['First Republic', 'Second Republic', 'Third Republic', 'NLC Decree', 'NRC Decree', 'SMC Decree', 'AFRC Decree']) || stripos($bookmark->act_group, 'Republic') !== false || stripos($bookmark->act_group, 'Decree') !== false) {
                        $docType = 'pre_1992';
                    } else {
                        $docType = 'legislation';
                    }
                }

                // Badge styling
                $badgeClass = 'badge-legislation';
                $badgeIcon = 'fa-solid fa-scale-balanced';
                $typeLabel = $bookmark->act_group ?: 'Legislation';

                if ($docType === 'constitution') {
                    $badgeClass = 'badge-constitution';
                    $badgeIcon = 'fa-solid fa-landmark';
                    $typeLabel = 'Constitution';
                } elseif ($docType === 'case_law') {
                    $badgeClass = 'badge-case-law';
                    $badgeIcon = 'fa-solid fa-gavel';
                    $typeLabel = 'Case Law';
                } elseif ($docType === 'pre_1992') {
                    $badgeClass = 'badge-pre-1992';
                    $badgeIcon = 'fa-solid fa-scroll';
                    $typeLabel = $bookmark->act_group ?: 'Existing Law';
                }
            @endphp
            <div class="bookmark-card" id="bookmark-card-{{ $bookmark->id }}" data-type="{{ $docType }}" data-search="{{ strtolower($bookmark->act_section . ' ' . $bookmark->act_title . ' ' . $bookmark->act_group) }}">
                <div class="bookmark-card-main-wrapper">
                    <div class="bookmark-card-top">
                        <span class="bookmark-type-badge {{ $badgeClass }}">
                            <i class="{{ $badgeIcon }}"></i>
                            <span>{{ $typeLabel }}</span>
                        </span>
                        <span class="bookmark-date" title="Bookmarked on {{ $bookmark->created_at }}">
                            <i class="fa-regular fa-clock"></i>
                            {{ date("M j, Y", strtotime($bookmark->created_at)) }}
                        </span>
                    </div>

                    <div class="bookmark-card-body">
                        <div class="bookmark-section-title" onclick="openBookmarkPreviewModal({{ $bookmark->id }})" title="Click to view section">
                            {{ $bookmark->act_section }}
                        </div>
                        <div class="bookmark-doc-title" title="{{ $bookmark->act_title }}">
                            <i class="fa-regular fa-file-lines mr-1" style="opacity: 0.6;"></i>
                            {{ $bookmark->act_title }}
                        </div>
                    </div>
                </div>

                <div class="bookmark-card-footer">
                    <span class="bookmark-linear-date" title="Bookmarked on {{ $bookmark->created_at }}">
                        <i class="fa-regular fa-clock"></i>
                        {{ date("M j, Y", strtotime($bookmark->created_at)) }}
                    </span>
                    <button type="button" class="btn-view-bookmark" onclick="openBookmarkPreviewModal({{ $bookmark->id }})">
                        <i class="fa-solid fa-book-open"></i> View Section
                    </button>
                    <button type="button" class="btn-delete-bookmark" onclick="deleteBookmarkDashboard({{ $bookmark->id }})">
                        <i class="fa-solid fa-trash-can"></i> Remove
                    </button>
                </div>
            </div>
        @empty
            <div id="noBookmarksInitial" style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary); padding: 60px 20px; background: rgba(255,255,255,0.015); border: 1px dashed var(--border-color); border-radius: 16px;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-bookmark" style="font-size: 24px; color: #f59e0b;"></i>
                </div>
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 8px;">No Bookmarks Saved Yet</h3>
                <p style="font-size: 13.5px; color: var(--text-secondary); max-width: 460px; margin: 0 auto 20px;">
                    You haven't bookmarked any sections yet. Click the bookmark icon next to any clause or article while browsing to save it here for quick access.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="/constitution/Republic/Ghana/1" class="btn-view-bookmark" style="padding: 8px 18px;">
                        <i class="fa-solid fa-landmark"></i> Explore Constitution
                    </a>
                    <a href="/all-new-laws/acts-of-parliament" class="btn-view-bookmark" style="padding: 8px 18px;">
                        <i class="fa-solid fa-scale-balanced"></i> Browse New Laws
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Filter Empty State --}}
    <div id="filterEmptyState" style="display: none; text-align: center; color: var(--text-secondary); padding: 50px 20px; background: rgba(255,255,255,0.015); border: 1px dashed var(--border-color); border-radius: 16px; margin-top: 10px;">
        <i class="fa-solid fa-magnifying-glass" style="font-size: 28px; color: var(--text-muted); margin-bottom: 12px;"></i>
        <h4 style="color: #fff; font-size: 16px; font-weight: 600; margin-bottom: 6px;">No Matching Bookmarks</h4>
        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 16px;">No saved bookmarks match your search and filter criteria.</p>
        <button type="button" class="btn-view-bookmark" onclick="resetBookmarkFilters()">Reset Filters</button>
    </div>
</div>

{{-- ====== BOOKMARK SECTION PREVIEW MODAL ====== --}}
<div id="bmPreviewModalBackdrop" class="bm-modal-backdrop" onclick="if(event.target === this) closeBookmarkModal()">
    <div class="bm-modal-card">
        <div class="bm-modal-header">
            <div style="flex: 1 1 auto;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                    <span id="bmModalBadge" class="bookmark-type-badge badge-constitution">
                        <i id="bmModalBadgeIcon" class="fa-solid fa-landmark"></i>
                        <span id="bmModalBadgeText">Constitution</span>
                    </span>
                    <span id="bmModalDate" class="bookmark-date">
                        <i class="fa-regular fa-clock"></i>
                        <span id="bmModalDateText"></span>
                    </span>
                </div>
                <h2 id="bmModalSectionTitle" style="color: #fff; font-size: 19px; font-weight: 800; margin: 0 0 6px; line-height: 1.35;">
                    Loading Section...
                </h2>
                <div style="color: #60a5fa; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-regular fa-file-lines" style="opacity: 0.8;"></i>
                    <span id="bmModalDocTitleText" style="font-weight: 500;"></span>
                </div>
            </div>
            <button type="button" class="bm-modal-close" onclick="closeBookmarkModal()" title="Close Preview">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div id="bmModalBody" class="bm-modal-body">
            <div id="bmModalLoader" style="text-align: center; padding: 50px 20px; color: var(--text-muted);">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 32px; color: #f59e0b; margin-bottom: 14px; display: block;"></i>
                <span>Loading legal content...</span>
            </div>
            <div id="bmModalContentWrapper" style="display: none;"></div>

            {{-- Embedded Note Taking Panel --}}
            <div id="bmNoteDrawer" style="display: none; background: rgba(15, 23, 42, 0.96); border: 1px solid rgba(59, 130, 246, 0.35); border-radius: 14px; padding: 18px; margin-top: 20px; box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <div style="font-size: 14px; font-weight: 700; color: #93c5fd; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-pen-to-square" style="color: #3b82f6;"></i> Add Note to this Section
                    </div>
                    <button type="button" onclick="closeBmNoteDrawer()" style="background: rgba(255,255,255,0.06); border: 1px solid var(--border-color); color: #94a3b8; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 12px;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                {{-- Selected Highlight Excerpt Preview --}}
                <div id="bmNoteExcerptBox" style="display: none; background: rgba(245, 158, 11, 0.08); border-left: 3px solid #f59e0b; padding: 8px 12px; border-radius: 0 8px 8px 0; margin-bottom: 12px; font-size: 12.5px; color: #fde68a; font-style: italic;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                        <div>
                            <i class="fa-solid fa-quote-left mr-1" style="font-size: 10px;"></i>
                            <span id="bmNoteExcerptText"></span>
                        </div>
                        <button type="button" onclick="clearBmNoteExcerpt()" style="background: none; border: none; color: #f87171; font-size: 13px; cursor: pointer;" title="Clear excerpt">&times;</button>
                    </div>
                </div>

                {{-- Color accent selector --}}
                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 12px;">
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Accent Color:</span>
                    <label>
                        <input type="radio" name="bm_note_color" value="yellow" checked class="color-chip-radio">
                        <span class="color-chip-label" style="background: #f59e0b;" title="Yellow"></span>
                    </label>
                    <label>
                        <input type="radio" name="bm_note_color" value="blue" class="color-chip-radio">
                        <span class="color-chip-label" style="background: #3b82f6;" title="Blue"></span>
                    </label>
                    <label>
                        <input type="radio" name="bm_note_color" value="green" class="color-chip-radio">
                        <span class="color-chip-label" style="background: #10b981;" title="Green"></span>
                    </label>
                    <label>
                        <input type="radio" name="bm_note_color" value="pink" class="color-chip-radio">
                        <span class="color-chip-label" style="background: #ec4899;" title="Pink"></span>
                    </label>
                    <label>
                        <input type="radio" name="bm_note_color" value="purple" class="color-chip-radio">
                        <span class="color-chip-label" style="background: #8b5cf6;" title="Purple"></span>
                    </label>
                </div>

                {{-- Note Textarea --}}
                <textarea id="bmNoteInput" placeholder="Write your legal observations, analysis, or personal study notes on this section..." style="width: 100%; min-height: 100px; background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; padding: 12px 14px; color: #fff; font-size: 14px; line-height: 1.6; font-family: inherit; resize: vertical; box-sizing: border-box;"></textarea>

                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 12px;">
                    <button type="button" class="btn-delete-bookmark" onclick="closeBmNoteDrawer()" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.12); color: #cbd5e1;">
                        Cancel
                    </button>
                    <button type="button" id="btnSaveBmNote" class="btn-save-inline" onclick="saveBmNote()">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Save Note
                    </button>
                </div>
            </div>
        </div>

        <div class="bm-modal-footer">
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" id="btnBmToggleNote" class="btn-view-bookmark" onclick="toggleBmNoteDrawer()" style="background: rgba(59, 130, 246, 0.15); border-color: rgba(59, 130, 246, 0.35); color: #60a5fa; font-weight: 600;">
                    <i class="fa-solid fa-pen-to-square"></i> Add Note
                </button>
                <button type="button" id="bmModalDeleteBtn" class="btn-delete-bookmark" onclick="deleteActiveModalBookmark()">
                    <i class="fa-solid fa-trash-can"></i> Remove Bookmark
                </button>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a id="bmModalFullReaderLink" href="#" target="_blank" class="btn-view-bookmark" style="background: rgba(245, 158, 11, 0.15); border-color: rgba(245, 158, 11, 0.35); color: #f59e0b;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Full Reader
                </a>
                <button type="button" class="btn-view-bookmark" onclick="closeBookmarkModal()" style="background: rgba(255, 255, 255, 0.08); border-color: rgba(255, 255, 255, 0.15); color: #e2e8f0;">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('partials._bookmark_script')

<script>
let currentActiveBookmarkId = null;
let currentActiveBookmarkData = null;
let currentSelectedExcerpt = '';

// ====== VIEW SWITCHER (CARDS vs LINEAR) ======
function switchBookmarksView(view) {
    const container = document.getElementById('bookmarksListDashboard');
    const gridBtn = document.getElementById('btnBmViewGrid');
    const linearBtn = document.getElementById('btnBmViewLinear');

    if (!container) return;

    if (view === 'linear') {
        container.classList.remove('view-grid');
        container.classList.add('view-linear');
        linearBtn?.classList.add('active');
        gridBtn?.classList.remove('active');
        localStorage.setItem('user_bookmarks_view', 'linear');
    } else {
        container.classList.remove('view-linear');
        container.classList.add('view-grid');
        gridBtn?.classList.add('active');
        linearBtn?.classList.remove('active');
        localStorage.setItem('user_bookmarks_view', 'grid');
    }
}

// Initialize saved view (defaults to cards on mobile, linear on desktop)
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 768) {
        switchBookmarksView('grid');
    } else {
        const savedView = localStorage.getItem('user_bookmarks_view') || 'linear';
        switchBookmarksView(savedView);
    }
});

function openBookmarkPreviewModal(bookmarkId) {
    currentActiveBookmarkId = bookmarkId;
    const backdrop = document.getElementById('bmPreviewModalBackdrop');
    const loader = document.getElementById('bmModalLoader');
    const contentWrapper = document.getElementById('bmModalContentWrapper');
    const titleEl = document.getElementById('bmModalSectionTitle');
    const docTitleEl = document.getElementById('bmModalDocTitleText');
    const badgeText = document.getElementById('bmModalBadgeText');
    const badgeIcon = document.getElementById('bmModalBadgeIcon');
    const badgeEl = document.getElementById('bmModalBadge');
    const dateText = document.getElementById('bmModalDateText');
    const fullReaderLink = document.getElementById('bmModalFullReaderLink');
    const noteDrawer = document.getElementById('bmNoteDrawer');

    // Ensure modal element is direct child of body so it is full-screen
    if (backdrop && backdrop.parentNode !== document.body) {
        document.body.appendChild(backdrop);
    }

    // Reset view
    titleEl.textContent = 'Loading section...';
    docTitleEl.textContent = '';
    loader.style.display = 'block';
    contentWrapper.style.display = 'none';
    contentWrapper.innerHTML = '';
    if (noteDrawer) noteDrawer.style.display = 'none';
    clearBmNoteExcerpt();
    backdrop.classList.add('active');

    // Native fetch request
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    fetch('/bookmarks/content/' + bookmarkId, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function(res) {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(function(res) {
        loader.style.display = 'none';
        contentWrapper.style.display = 'block';

        if (res && res.success) {
            currentActiveBookmarkData = res;

            titleEl.textContent = res.section_title || 'Section';
            docTitleEl.textContent = res.document_title || '';
            dateText.textContent = res.created_at || '';
            contentWrapper.innerHTML = res.content_html || '<p>No content available.</p>';

            // Badge styling
            badgeEl.className = 'bookmark-type-badge';
            if (res.document_type === 'constitution') {
                badgeEl.classList.add('badge-constitution');
                badgeIcon.className = 'fa-solid fa-landmark';
                badgeText.textContent = 'Constitution';
            } else if (res.document_type === 'case_law') {
                badgeEl.classList.add('badge-case-law');
                badgeIcon.className = 'fa-solid fa-gavel';
                badgeText.textContent = 'Case Law';
            } else if (res.document_type === 'pre_1992') {
                badgeEl.classList.add('badge-pre-1992');
                badgeIcon.className = 'fa-solid fa-scroll';
                badgeText.textContent = res.act_group || 'Existing Law';
            } else {
                badgeEl.classList.add('badge-legislation');
                badgeIcon.className = 'fa-solid fa-scale-balanced';
                badgeText.textContent = res.act_group || 'Legislation';
            }

            // Full reader link
            if (res.page_url) {
                fullReaderLink.href = res.page_url;
                fullReaderLink.style.display = 'inline-flex';
            } else {
                fullReaderLink.style.display = 'none';
            }
        } else {
            titleEl.textContent = 'Unable to Load Section';
            contentWrapper.innerHTML = '<p style="color: #ef4444;">' + (res ? res.message : 'An error occurred while loading content.') + '</p>';
        }
    })
    .catch(function(err) {
        loader.style.display = 'none';
        contentWrapper.style.display = 'block';
        titleEl.textContent = 'Error Loading Content';
        contentWrapper.innerHTML = '<p style="color: #ef4444;">Unable to connect to server (' + err.message + '). Please try again.</p>';
    });
}

function closeBookmarkModal() {
    const backdrop = document.getElementById('bmPreviewModalBackdrop');
    if (backdrop) {
        backdrop.classList.remove('active');
    }
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBookmarkModal();
    }
});

function deleteActiveModalBookmark() {
    if (!currentActiveBookmarkId) return;
    const idToDelete = currentActiveBookmarkId;
    closeBookmarkModal();
    deleteBookmarkDashboard(idToDelete);
}

// ====== NOTE TAKING FROM BOOKMARK MODAL ======
function toggleBmNoteDrawer() {
    const drawer = document.getElementById('bmNoteDrawer');
    const input = document.getElementById('bmNoteInput');
    if (!drawer) return;

    if (drawer.style.display === 'none' || !drawer.style.display) {
        // Capture any selected text in the modal
        const selected = window.getSelection().toString().trim();
        if (selected) {
            setBmNoteExcerpt(selected);
        }

        drawer.style.display = 'block';
        drawer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        setTimeout(() => input?.focus(), 150);
    } else {
        drawer.style.display = 'none';
    }
}

function closeBmNoteDrawer() {
    const drawer = document.getElementById('bmNoteDrawer');
    if (drawer) drawer.style.display = 'none';
}

function setBmNoteExcerpt(text) {
    currentSelectedExcerpt = text;
    const box = document.getElementById('bmNoteExcerptBox');
    const textEl = document.getElementById('bmNoteExcerptText');
    if (box && textEl) {
        textEl.textContent = text;
        box.style.display = 'block';
    }
}

function clearBmNoteExcerpt() {
    currentSelectedExcerpt = '';
    const box = document.getElementById('bmNoteExcerptBox');
    const textEl = document.getElementById('bmNoteExcerptText');
    if (box && textEl) {
        textEl.textContent = '';
        box.style.display = 'none';
    }
}

// Listen to text selection in the modal body
document.addEventListener('selectionchange', function() {
    const modalBody = document.getElementById('bmModalBody');
    if (!modalBody) return;
    const sel = window.getSelection().toString().trim();
    if (sel && modalBody.contains(window.getSelection().anchorNode)) {
        currentSelectedExcerpt = sel;
    }
});

function saveBmNote() {
    if (!currentActiveBookmarkData) return;

    const input = document.getElementById('bmNoteInput');
    const noteContent = (input?.value || '').trim();
    const color = document.querySelector('input[name="bm_note_color"]:checked')?.value || 'yellow';
    const saveBtn = document.getElementById('btnSaveBmNote');

    if (!noteContent) {
        if (typeof showBookmarkToast === 'function') {
            showBookmarkToast('Note content cannot be empty.', 'error');
        } else {
            alert('Please enter your note content.');
        }
        return;
    }

    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Saving...';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const payload = {
        document_type: currentActiveBookmarkData.document_type || 'legislation',
        document_id: currentActiveBookmarkData.section_id || (currentActiveBookmarkData.act_id || 0),
        document_title: currentActiveBookmarkData.document_title || '',
        article_section: currentActiveBookmarkData.section_title || '',
        page_url: currentActiveBookmarkData.page_url || window.location.href,
        note_content: noteContent,
        note_color: color,
        highlighted_text: currentSelectedExcerpt || ''
    };

    fetch('/notes/save', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(res => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk mr-1"></i> Save Note';

        if (res && res.success) {
            // Reset fields & close drawer
            input.value = '';
            clearBmNoteExcerpt();
            closeBmNoteDrawer();

            // Update sidebar notes count badge if available
            const notesNavBadge = document.querySelector('.sidebar-menu .menu-item a[href*="/accounts/notes"] .menu-badge');
            if (notesNavBadge) {
                let count = parseInt(notesNavBadge.textContent) || 0;
                notesNavBadge.textContent = count + 1;
            }

            if (typeof showBookmarkToast === 'function') {
                showBookmarkToast('Note added and saved to your Notes!', 'success');
            } else {
                alert('Note saved successfully!');
            }
        } else {
            if (typeof showBookmarkToast === 'function') {
                showBookmarkToast(res ? res.message : 'Failed to save note.', 'error');
            }
        }
    })
    .catch(err => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk mr-1"></i> Save Note';
        if (typeof showBookmarkToast === 'function') {
            showBookmarkToast('Error connecting to server to save note.', 'error');
        }
    });
}

function filterBookmarks() {
    var searchVal = (document.getElementById('bookmarkSearchInput').value || '').toLowerCase().trim();
    var catVal = document.getElementById('bookmarkCategoryFilter').value;
    var cards = document.querySelectorAll('.bookmark-card');
    var visibleCount = 0;

    cards.forEach(function(card) {
        var cardType = card.getAttribute('data-type');
        var cardSearch = card.getAttribute('data-search') || '';

        var matchesCategory = (catVal === 'all' || cardType === catVal);
        var matchesSearch = (!searchVal || cardSearch.indexOf(searchVal) !== -1);

        if (matchesCategory && matchesSearch) {
            card.style.display = (document.getElementById('bookmarksListDashboard').classList.contains('view-linear')) ? 'flex' : 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    var emptyState = document.getElementById('filterEmptyState');
    if (emptyState) {
        if (visibleCount === 0 && cards.length > 0) {
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
        }
    }
}

function resetBookmarkFilters() {
    document.getElementById('bookmarkSearchInput').value = '';
    selectCustomFilter('bookmarkCategoryFilter', 'all', 'All Categories', 'labelBmCategory', 'dropdownBmCategoryMenu', filterBookmarks);
    filterBookmarks();
}

// ====== CUSTOM DROPDOWN CONTROLS ======
function toggleCustomFilterDropdown(e, menuId) {
    e.stopPropagation();
    const menu = document.getElementById(menuId);
    const container = menu?.closest('.custom-filter-dropdown');
    
    // Close other custom dropdowns
    document.querySelectorAll('.custom-filter-menu').forEach(m => {
        if (m.id !== menuId) {
            m.classList.remove('show');
            m.closest('.custom-filter-dropdown')?.classList.remove('open');
        }
    });

    if (menu) {
        menu.classList.toggle('show');
        container?.classList.toggle('open');
    }
}

function selectCustomFilter(hiddenInputId, val, labelText, labelSpanId, menuId, callback) {
    const input = document.getElementById(hiddenInputId);
    if (input) input.value = val;

    const label = document.getElementById(labelSpanId);
    if (label) label.innerHTML = labelText;

    const menu = document.getElementById(menuId);
    if (menu) {
        menu.querySelectorAll('.custom-filter-option').forEach(opt => opt.classList.remove('active'));
        if (window.event && window.event.currentTarget && window.event.currentTarget.classList.contains('custom-filter-option')) {
            window.event.currentTarget.classList.add('active');
        } else {
            const matchingOpt = Array.from(menu.querySelectorAll('.custom-filter-option')).find(o => o.getAttribute('onclick')?.includes(`'${val}'`));
            if (matchingOpt) matchingOpt.classList.add('active');
        }
        menu.classList.remove('show');
        menu.closest('.custom-filter-dropdown')?.classList.remove('open');
    }

    if (typeof callback === 'function') {
        callback();
    } else if (typeof filterBookmarks === 'function') {
        filterBookmarks();
    }
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-filter-dropdown')) {
        document.querySelectorAll('.custom-filter-menu').forEach(m => m.classList.remove('show'));
        document.querySelectorAll('.custom-filter-dropdown').forEach(c => c.classList.remove('open'));
    }
});

function deleteBookmarkDashboard(id) {
    if (!confirm('Are you sure you want to remove this bookmark?')) return;

    var card = document.getElementById('bookmark-card-' + id);
    var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    fetch('/bookmarks/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function(res) { return res.json(); })
    .then(function(res) {
        if (res && res.success) {
            if (card) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(function() {
                    card.remove();
                    filterBookmarks();

                    // Check if list is empty
                    var remainingCards = document.querySelectorAll('.bookmark-card');
                    var countEl = document.getElementById('bookmarksCountDisplay');
                    if (countEl) countEl.textContent = remainingCards.length;

                    if (remainingCards.length === 0) {
                        window.location.reload();
                    }
                }, 300);
            }

            if (typeof res.count !== 'undefined' && typeof updateSidebarBookmarksCount === 'function') {
                updateSidebarBookmarksCount(res.count);
            }
            if (typeof showBookmarkToast === 'function') {
                showBookmarkToast('Bookmark removed successfully.', 'info');
            }
        } else {
            if (typeof showBookmarkToast === 'function') {
                showBookmarkToast(res ? res.message : 'Failed to delete bookmark.', 'error');
            }
        }
    })
    .catch(function() {
        if (typeof showBookmarkToast === 'function') {
            showBookmarkToast('An error occurred while deleting bookmark.', 'error');
        }
    });
}
</script>
@endsection