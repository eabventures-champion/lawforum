@extends('layouts.user')

@section('title', 'My Notes')

@section('styles')
<style>
    .notes-filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 22px;
        flex-wrap: wrap;
        align-items: center;
    }
    .notes-search-input {
        flex: 1;
        min-width: 200px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 8px 14px;
        border-radius: 9px;
        font-size: 13px;
        font-family: inherit;
        transition: border-color 0.2s ease;
    }
    .notes-search-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .notes-search-input::placeholder {
        color: var(--text-muted);
    }

    .filter-select {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 8px 12px;
        border-radius: 9px;
        font-size: 13px;
        font-family: inherit;
        cursor: pointer;
    }
    .filter-select:focus {
        outline: none;
        border-color: #3b82f6;
    }
    .filter-select option {
        background: #0f172a;
        color: #fff;
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
        background: rgba(59, 130, 246, 0.18);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.35);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    }

    /* ====== NOTES CONTAINER ====== */
    #notesListDashboard {
        display: grid;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Common Card Styles */
    .note-dashboard-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border-left: 4px solid #f59e0b;
        box-sizing: border-box;
        position: relative;
    }

    .note-dashboard-card[data-color="blue"] { border-left-color: #3b82f6; }
    .note-dashboard-card[data-color="green"] { border-left-color: #10b981; }
    .note-dashboard-card[data-color="pink"] { border-left-color: #ec4899; }
    .note-dashboard-card[data-color="purple"] { border-left-color: #8b5cf6; }
    .note-dashboard-card[data-color="yellow"] { border-left-color: #f59e0b; }

    .note-type-badge {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 3px 8px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    .badge-constitution { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
    .badge-case-law { background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); }
    .badge-pre-1992 { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge-legislation { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }

    .note-date {
        font-size: 11.5px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .note-section-title {
        font-size: 14.5px;
        font-weight: 700;
        color: #fff;
        line-height: 1.35;
        cursor: pointer;
        transition: color 0.2s ease;
        word-break: break-word;
    }
    .note-section-title:hover {
        color: #60a5fa;
    }

    .note-doc-subtitle {
        font-size: 11.5px;
        color: #60a5fa;
        line-height: 1.35;
        cursor: pointer;
        opacity: 0.9;
    }

    .note-quote-box {
        background: rgba(245, 158, 11, 0.06);
        border-left: 3px solid rgba(245, 158, 11, 0.4);
        padding: 4px 8px;
        border-radius: 0 5px 5px 0;
        font-size: 11.5px;
        color: #fde68a;
        line-height: 1.4;
        font-style: italic;
        word-break: break-word;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .note-quote-box:hover {
        background: rgba(245, 158, 11, 0.12);
    }

    .note-text-content {
        font-size: 13px;
        color: #e2e8f0;
        line-height: 1.5;
        word-break: break-word;
        cursor: pointer;
    }

    .btn-view-note {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.25);
        color: #60a5fa;
        padding: 5px 10px;
        border-radius: 7px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-view-note:hover {
        background: #3b82f6;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-action-note {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 3px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 5px 8px;
        border-radius: 7px;
        font-size: 11.5px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-action-note:hover {
        background: rgba(255, 255, 255, 0.09);
        color: var(--text-primary);
        transform: translateY(-1px);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-icon-square {
        width: 28px;
        height: 28px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11.5px;
    }

    /* 1. CARDS / GRID VIEW */
    #notesListDashboard.view-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        align-items: stretch;
    }
    #notesListDashboard.view-grid .note-dashboard-card {
        padding: 16px 16px 14px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        min-width: 0;
        overflow: hidden;
    }
    #notesListDashboard.view-grid .note-dashboard-card:hover {
        border-color: rgba(255, 255, 255, 0.16);
        background: rgba(255, 255, 255, 0.04);
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4);
    }
    #notesListDashboard.view-grid .note-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        gap: 6px;
    }
    #notesListDashboard.view-grid .note-card-body {
        flex: 1 1 auto;
        margin-bottom: 12px;
        min-width: 0;
    }
    #notesListDashboard.view-grid .note-section-title {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 3px;
    }
    #notesListDashboard.view-grid .note-doc-subtitle {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 8px;
    }
    #notesListDashboard.view-grid .note-quote-box {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 8px;
    }
    #notesListDashboard.view-grid .note-text-content {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    #notesListDashboard.view-grid .note-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 6px;
        padding-top: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        min-width: 0;
    }
    #notesListDashboard.view-grid .note-linear-date {
        display: none;
    }

    /* 2. LINEAR / LIST VIEW (Organized Horizontal Row) */
    #notesListDashboard.view-linear {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    #notesListDashboard.view-linear .note-dashboard-card {
        padding: 12px 18px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    #notesListDashboard.view-linear .note-dashboard-card:hover {
        border-color: rgba(59, 130, 246, 0.4);
        background: rgba(255, 255, 255, 0.035);
        transform: translateX(2px);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.3);
    }
    #notesListDashboard.view-linear .note-card-main-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1 1 auto;
        min-width: 0;
    }
    #notesListDashboard.view-linear .note-card-top {
        margin-bottom: 0;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 3px;
        min-width: 110px;
    }
    #notesListDashboard.view-linear .note-card-top .note-date {
        display: flex;
        font-size: 11px;
        color: var(--text-muted);
        white-space: nowrap;
    }
    #notesListDashboard.view-linear .note-card-body {
        margin-bottom: 0;
        flex: 1 1 auto;
        min-width: 0;
    }
    #notesListDashboard.view-linear .note-linear-title-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 3px;
        flex-wrap: nowrap;
        overflow: hidden;
    }
    #notesListDashboard.view-linear .note-section-title {
        font-size: 14.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-shrink: 0;
        max-width: 320px;
    }
    #notesListDashboard.view-linear .note-doc-subtitle {
        font-size: 11.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0;
    }
    #notesListDashboard.view-linear .note-linear-desc-row {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow: hidden;
    }
    #notesListDashboard.view-linear .note-quote-box {
        display: inline-flex;
        align-items: center;
        margin-bottom: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 240px;
        flex-shrink: 0;
    }
    #notesListDashboard.view-linear .note-text-content {
        font-size: 12.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1 1 auto;
        color: #cbd5e1;
    }
    #notesListDashboard.view-linear .note-card-footer {
        border-top: none;
        padding-top: 0;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    #notesListDashboard.view-linear .note-linear-date {
        display: none;
    }

    /* Inline Quick Edit Box */
    .note-quick-edit-container {
        display: none;
        margin-top: 8px;
    }
    .note-quick-edit-textarea {
        width: 100%;
        min-height: 80px;
        background: rgba(15, 23, 42, 0.95);
        border: 1px solid #3b82f6;
        border-radius: 8px;
        padding: 8px 10px;
        color: #fff;
        font-size: 12.5px;
        font-family: inherit;
        resize: vertical;
        margin-bottom: 6px;
        box-sizing: border-box;
    }
    .note-quick-edit-textarea:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    .note-quick-edit-actions {
        display: flex;
        gap: 6px;
    }

    .btn-save-inline {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        color: #fff;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-cancel-inline {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--border-color);
        color: #94a3b8;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        cursor: pointer;
    }

    /* ====== MODAL STYLES ====== */
    .note-modal-backdrop {
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
    .note-modal-backdrop.active {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }
    .note-modal-card {
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
    .note-modal-backdrop.active .note-modal-card {
        transform: translateY(0) scale(1) !important;
    }
    .note-modal-header {
        padding: 22px 28px 18px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        gap: 16px !important;
        background: rgba(255, 255, 255, 0.02) !important;
    }
    .note-modal-close {
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
    .note-modal-close:hover {
        background: rgba(239, 68, 68, 0.2) !important;
        color: #f87171 !important;
        border-color: rgba(239, 68, 68, 0.4) !important;
        transform: rotate(90deg) !important;
    }
    .note-modal-body {
        padding: 24px 28px !important;
        overflow-y: auto !important;
        flex: 1 1 auto !important;
        font-size: 15.5px !important;
        line-height: 1.85 !important;
        color: #cbd5e1 !important;
    }
    .note-modal-footer {
        padding: 16px 28px !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        background: rgba(255, 255, 255, 0.02) !important;
        gap: 12px !important;
        flex-wrap: wrap !important;
    }

    /* Color picker radio chips */
    .color-picker-group {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 18px;
    }
    .color-chip-radio {
        display: none;
    }
    .color-chip-label {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        cursor: pointer;
        display: inline-block;
        border: 2px solid transparent;
        transition: transform 0.15s ease, border-color 0.15s ease;
    }
    .color-chip-radio:checked + .color-chip-label {
        transform: scale(1.2);
        border-color: #fff;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
    }

    /* Export Dropdown Menu */
    .notes-export-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        left: auto;
        background: #0f172a;
        background: linear-gradient(180deg, #111827 0%, #0b0f19 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        padding: 6px;
        min-width: 190px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.8), 0 0 20px rgba(59, 130, 246, 0.1);
        z-index: 100;
        display: none;
    }
    .notes-export-item {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 9px 12px;
        border-radius: 8px;
        color: #e2e8f0;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.15s ease;
        border: none;
        background: transparent;
        box-sizing: border-box;
        cursor: pointer;
    }
    .notes-export-item:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }

    /* Custom Filter Dropdowns (Unified with Export Menu) */
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
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.8), 0 0 20px rgba(59, 130, 246, 0.1);
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
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
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
    .color-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    /* Responsive Breakpoints */
    @media (max-width: 1060px) {
        #notesListDashboard.view-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 768px) {
        .notes-export-menu {
            left: 0 !important;
            right: auto !important;
        }
        .view-switcher-group {
            display: none !important;
        }
        #notesListDashboard.view-grid,
        #notesListDashboard.view-linear {
            grid-template-columns: 1fr !important;
            gap: 14px !important;
        }
        #notesListDashboard .note-dashboard-card {
            padding: 16px 16px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
        }
        #notesListDashboard .note-card-main-wrapper {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
            width: 100% !important;
        }
        #notesListDashboard .note-card-top {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            margin-bottom: 0 !important;
            min-width: 0 !important;
        }
        #notesListDashboard .note-card-top .note-date {
            display: flex !important;
        }
        #notesListDashboard .note-linear-date {
            display: none !important;
        }
        #notesListDashboard .note-card-body {
            margin-bottom: 0 !important;
            width: 100% !important;
        }
        #notesListDashboard .note-section-title {
            font-size: 14.5px !important;
            white-space: normal !important;
            line-height: 1.4 !important;
            -webkit-line-clamp: 2 !important;
        }
        #notesListDashboard .note-doc-subtitle {
            font-size: 12px !important;
            white-space: normal !important;
            -webkit-line-clamp: 2 !important;
        }
        #notesListDashboard .note-quote-box {
            white-space: normal !important;
            -webkit-line-clamp: 3 !important;
            margin-bottom: 6px !important;
        }
        #notesListDashboard .note-text-content {
            white-space: normal !important;
            -webkit-line-clamp: 4 !important;
        }
        #notesListDashboard .note-card-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
            padding-top: 10px !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }
        .notes-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .note-modal-header, .note-modal-body, .note-modal-footer {
            padding: 16px 18px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
        <div>
            <h1 class="card-title" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <i class="fa-solid fa-note-sticky" style="color: #3b82f6; font-size: 22px;"></i>
                <span>My Notes</span>
                <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); padding: 2px 9px; border-radius: 12px; font-size: 13px; font-weight: 700;">
                    <span id="notesCountBadge">{{ count($notes) }}</span>
                </span>
            </h1>
            <p class="card-subtitle" style="margin-bottom: 0;">Access and edit your personal study notes, legal highlights, and case commentary.</p>
        </div>
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            {{-- View Switcher (Cards vs Linear) --}}
            <div class="view-switcher-group">
                <button type="button" class="view-toggle-btn" id="btnViewGrid" onclick="switchNotesView('grid')" title="Cards / Grid View">
                    <i class="fa-solid fa-table-cells"></i>
                    <span>Cards</span>
                </button>
                <button type="button" class="view-toggle-btn active" id="btnViewLinear" onclick="switchNotesView('linear')" title="Linear / List View">
                    <i class="fa-solid fa-bars"></i>
                    <span>Linear</span>
                </button>
            </div>

            @if(count($notes) > 0)
            <div style="position: relative;" class="notes-export-dropdown">
                <button type="button" class="btn-action-note" id="btnExportAllNotes" onclick="toggleExportMenu(event)" style="padding: 6px 12px; font-weight: 600; color: #93c5fd; background: rgba(59, 130, 246, 0.12); border-color: rgba(59, 130, 246, 0.3);">
                    <i class="fa-solid fa-cloud-arrow-down mr-1"></i> Export All <i class="fa-solid fa-chevron-down" style="font-size: 9px; margin-left: 3px;"></i>
                </button>
                <div class="notes-export-menu" id="exportAllMenu">
                    <a href="{{ route('notes.download_all.pdf') }}" class="notes-export-item">
                        <i class="fa-solid fa-file-pdf" style="color: #ef4444; font-size: 14px;"></i>
                        <span>Download All (PDF)</span>
                    </a>
                    <a href="{{ route('notes.download_all.word') }}" class="notes-export-item">
                        <i class="fa-solid fa-file-word" style="color: #3b82f6; font-size: 14px;"></i>
                        <span>Download All (Word)</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Filter and Search Controls -->
    <div class="notes-filter-bar">
        <input type="text" class="notes-search-input" id="searchNotes" placeholder="Search by note, citation, or legal title..." oninput="filterNotes()">

        {{-- Custom Dropdown: Documents --}}
        <div class="custom-filter-dropdown" id="dropdownDocTypeContainer">
            <input type="hidden" id="filterDocType" value="all">
            <button type="button" class="custom-filter-trigger" onclick="toggleCustomFilterDropdown(event, 'dropdownDocTypeMenu')">
                <span id="labelDocType">All Documents</span>
                <i class="fa-solid fa-chevron-down custom-filter-chevron"></i>
            </button>
            <div class="custom-filter-menu" id="dropdownDocTypeMenu">
                <div class="custom-filter-option active" onclick="selectCustomFilter('filterDocType', 'all', 'All Documents', 'labelDocType', 'dropdownDocTypeMenu')">
                    <span>All Documents</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterDocType', 'constitution', 'Constitution', 'labelDocType', 'dropdownDocTypeMenu')">
                    <span>Constitution</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterDocType', 'legislation', 'Acts of Parliament', 'labelDocType', 'dropdownDocTypeMenu')">
                    <span>Acts of Parliament</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterDocType', 'pre_1992', 'Existing Laws', 'labelDocType', 'dropdownDocTypeMenu')">
                    <span>Existing Laws</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterDocType', 'case_law', 'Case Judgments', 'labelDocType', 'dropdownDocTypeMenu')">
                    <span>Case Judgments</span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
            </div>
        </div>

        {{-- Custom Dropdown: Colors --}}
        <div class="custom-filter-dropdown" id="dropdownColorContainer">
            <input type="hidden" id="filterColor" value="all">
            <button type="button" class="custom-filter-trigger" onclick="toggleCustomFilterDropdown(event, 'dropdownColorMenu')">
                <span id="labelColor">All Colors</span>
                <i class="fa-solid fa-chevron-down custom-filter-chevron"></i>
            </button>
            <div class="custom-filter-menu" id="dropdownColorMenu">
                <div class="custom-filter-option active" onclick="selectCustomFilter('filterColor', 'all', 'All Colors', 'labelColor', 'dropdownColorMenu')">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        <span class="color-dot" style="background: linear-gradient(135deg, #f59e0b, #3b82f6, #10b981, #ec4899, #8b5cf6);"></span>
                        All Colors
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterColor', 'yellow', '🟡 Yellow', 'labelColor', 'dropdownColorMenu')">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        <span class="color-dot" style="background: #f59e0b;"></span>
                        Yellow
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterColor', 'blue', '🔵 Blue', 'labelColor', 'dropdownColorMenu')">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        <span class="color-dot" style="background: #3b82f6;"></span>
                        Blue
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterColor', 'green', '🟢 Green', 'labelColor', 'dropdownColorMenu')">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        <span class="color-dot" style="background: #10b981;"></span>
                        Green
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterColor', 'pink', '🩷 Pink', 'labelColor', 'dropdownColorMenu')">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        <span class="color-dot" style="background: #ec4899;"></span>
                        Pink
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
                <div class="custom-filter-option" onclick="selectCustomFilter('filterColor', 'purple', '🟣 Purple', 'labelColor', 'dropdownColorMenu')">
                    <span style="display: inline-flex; align-items: center; gap: 8px;">
                        <span class="color-dot" style="background: #8b5cf6;"></span>
                        Purple
                    </span>
                    <i class="fa-solid fa-check check-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Container (Grid or Linear) -->
    <div id="notesListDashboard" class="view-linear">
        @forelse($notes as $note)
            @php
                $docIcon = 'fa-file-lines';
                $badgeClass = 'badge-legislation';
                $badgeText = 'Legislation';

                if ($note->document_type === 'constitution') {
                    $docIcon = 'fa-landmark';
                    $badgeClass = 'badge-constitution';
                    $badgeText = 'Constitution';
                } elseif (in_array($note->document_type, ['case_law', 'judgment', 'judgement'])) {
                    $docIcon = 'fa-gavel';
                    $badgeClass = 'badge-case-law';
                    $badgeText = 'Case Law';
                } elseif ($note->document_type === 'pre_1992') {
                    $docIcon = 'fa-scroll';
                    $badgeClass = 'badge-pre-1992';
                    $badgeText = 'Existing Law';
                }

                $mainTitle = $note->article_section ?: $note->document_title;
                $subTitle = ($note->article_section && $note->document_title) ? $note->document_title : '';
            @endphp
            <div class="note-dashboard-card"
                 data-color="{{ $note->note_color ?? 'yellow' }}"
                 data-type="{{ $note->document_type }}"
                 data-search="{{ strtolower($note->note_content . ' ' . $note->highlighted_text . ' ' . $note->article_section . ' ' . $note->document_title) }}"
                 id="noteCard{{ $note->id }}">

                <div class="note-card-main-wrapper">
                    <div class="note-card-top">
                        <span class="note-type-badge {{ $badgeClass }}">
                            <i class="fa-solid {{ $docIcon }}"></i>
                            <span>{{ $badgeText }}</span>
                        </span>
                        <span class="note-date" title="{{ $note->created_at ? $note->created_at->format('M j, Y \a\t g:i A') : '' }}">
                            <i class="fa-regular fa-clock"></i>
                            {{ $note->created_at ? $note->created_at->format('M j, Y') : '' }}
                        </span>
                    </div>

                    <div class="note-card-body">
                        <div class="note-linear-title-row">
                            <div class="note-section-title" onclick="openNotePreviewModal({{ $note->id }})" title="{{ $mainTitle }}">
                                {{ html_entity_decode($mainTitle, ENT_QUOTES, 'UTF-8') }}
                            </div>
                            @if($subTitle)
                                <div class="note-doc-subtitle" onclick="openNotePreviewModal({{ $note->id }})" title="{{ $subTitle }}">
                                    <i class="fa-regular fa-file-lines mr-1" style="opacity: 0.7;"></i>
                                    {{ html_entity_decode($subTitle, ENT_QUOTES, 'UTF-8') }}
                                </div>
                            @endif
                        </div>

                        <div class="note-linear-desc-row">
                            @if($note->highlighted_text)
                                <div class="note-quote-box" onclick="openNotePreviewModal({{ $note->id }})" title="Click to view full note">
                                    <i class="fa-solid fa-quote-left" style="opacity: 0.6; font-size: 9px; margin-right: 3px;"></i>
                                    "{{ html_entity_decode($note->highlighted_text, ENT_QUOTES, 'UTF-8') }}"
                                </div>
                            @endif

                            <div class="note-text-content" id="noteBody{{ $note->id }}" onclick="openNotePreviewModal({{ $note->id }})" title="Click to view full note">
                                {{ $note->note_content }}
                            </div>
                        </div>

                        {{-- Quick Inline Edit Box --}}
                        <div class="note-quick-edit-container" id="noteQuickEditContainer{{ $note->id }}">
                            <textarea class="note-quick-edit-textarea" id="noteQuickEditTextarea{{ $note->id }}">{{ $note->note_content }}</textarea>
                            <div class="note-quick-edit-actions">
                                <button type="button" class="btn-save-inline" onclick="saveQuickEditNote({{ $note->id }})">
                                    <i class="fa-solid fa-check mr-1"></i> Save
                                </button>
                                <button type="button" class="btn-cancel-inline" onclick="cancelQuickEditNote({{ $note->id }})">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="note-card-footer">
                    <span class="note-linear-date" title="{{ $note->created_at ? $note->created_at->format('M j, Y \a\t g:i A') : '' }}">
                        <i class="fa-regular fa-clock"></i>
                        {{ $note->created_at ? $note->created_at->format('M j, Y') : '' }}
                    </span>

                    <div style="display: flex; gap: 4px; align-items: center; min-width: 0;">
                        <button type="button" class="btn-view-note" onclick="openNotePreviewModal({{ $note->id }})" title="View Full Note">
                            <i class="fa-solid fa-book-open"></i> View
                        </button>
                        <button type="button" class="btn-action-note" onclick="openNoteEditModal({{ $note->id }})" title="Edit in Modal" style="color: #60a5fa; font-weight: 600;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <button type="button" class="btn-action-note btn-icon-square" onclick="startQuickEditNote({{ $note->id }})" title="Quick Inline Edit">
                            <i class="fa-solid fa-bolt"></i>
                        </button>
                    </div>

                    <div style="display: flex; gap: 4px; align-items: center;">
                        <a href="{{ route('notes.download.pdf', $note->id) }}" class="btn-action-note btn-icon-square" title="Download as PDF">
                            <i class="fa-solid fa-file-pdf" style="color: #f87171;"></i>
                        </a>
                        <a href="{{ route('notes.download.word', $note->id) }}" class="btn-action-note btn-icon-square" title="Download as Word (.doc)">
                            <i class="fa-solid fa-file-word" style="color: #60a5fa;"></i>
                        </a>
                        <button type="button" class="btn-action-note btn-icon-square" style="color: #ef4444;" onclick="deleteNoteDashboard({{ $note->id }})" title="Delete Note">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div id="noNotesInitial" style="grid-column: 1 / -1; text-align: center; color: var(--text-secondary); padding: 60px 20px; background: rgba(255,255,255,0.015); border: 1px dashed var(--border-color); border-radius: 16px;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.25); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fa-solid fa-note-sticky" style="font-size: 24px; color: #3b82f6;"></i>
                </div>
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 8px;">No Notes Saved Yet</h3>
                <p style="font-size: 13.5px; color: var(--text-secondary); max-width: 460px; margin: 0 auto 20px;">
                    You haven't added any study notes yet. Open the constitution, legislation, or case laws to annotate text and save notes here.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="/constitution/Republic/Ghana/1" class="btn-view-note" style="padding: 8px 18px;">
                        <i class="fa-solid fa-landmark"></i> Explore Constitution
                    </a>
                    <a href="/all-new-laws/acts-of-parliament" class="btn-view-note" style="padding: 8px 18px;">
                        <i class="fa-solid fa-scale-balanced"></i> Browse New Laws
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Filter Empty State -->
    <div id="filterEmptyNotesState" style="display: none; text-align: center; color: var(--text-secondary); padding: 50px 20px; background: rgba(255,255,255,0.015); border: 1px dashed var(--border-color); border-radius: 16px; margin-top: 10px;">
        <i class="fa-solid fa-magnifying-glass" style="font-size: 28px; color: var(--text-muted); margin-bottom: 12px;"></i>
        <h4 style="color: #fff; font-size: 16px; font-weight: 600; margin-bottom: 6px;">No Matching Notes</h4>
        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 16px;">No saved notes match your search and filter criteria.</p>
        <button type="button" class="btn-view-note" onclick="resetNoteFilters()">Reset Filters</button>
    </div>
</div>

{{-- ====== NOTE PREVIEW MODAL ====== --}}
<div id="notePreviewModalBackdrop" class="note-modal-backdrop" onclick="if(event.target === this) closeNoteModal()">
    <div class="note-modal-card">
        <div class="note-modal-header">
            <div style="flex: 1 1 auto;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                    <span id="noteModalBadge" class="note-type-badge badge-constitution">
                        <i id="noteModalBadgeIcon" class="fa-solid fa-landmark"></i>
                        <span id="noteModalBadgeText">Constitution</span>
                    </span>
                    <span id="noteModalDate" class="note-date">
                        <i class="fa-regular fa-clock"></i>
                        <span id="noteModalDateText"></span>
                    </span>
                </div>
                <h2 id="noteModalSectionTitle" style="color: #fff; font-size: 19px; font-weight: 800; margin: 0 0 6px; line-height: 1.35;">
                    Loading Note...
                </h2>
                <div style="color: #60a5fa; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-regular fa-file-lines" style="opacity: 0.8;"></i>
                    <span id="noteModalDocTitleText" style="font-weight: 500;"></span>
                </div>
            </div>
            <button type="button" class="note-modal-close" onclick="closeNoteModal()" title="Close Preview">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div id="noteModalBody" class="note-modal-body">
            <div id="noteModalLoader" style="text-align: center; padding: 50px 20px; color: var(--text-muted);">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 32px; color: #3b82f6; margin-bottom: 14px; display: block;"></i>
                <span>Loading note details...</span>
            </div>
            <div id="noteModalContentWrapper" style="display: none;">
                {{-- Highlight Quote Section --}}
                <div id="noteModalQuoteWrapper" style="margin-bottom: 20px; display: none;">
                    <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #f59e0b; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-quote-left"></i> Highlighted Excerpt
                    </div>
                    <div id="noteModalQuote" style="background: rgba(245, 158, 11, 0.08); border-left: 3px solid #f59e0b; padding: 14px 18px; border-radius: 0 10px 10px 0; color: #fde68a; font-style: italic; font-size: 14.5px; line-height: 1.6;"></div>
                </div>

                {{-- Personal Note Section --}}
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #60a5fa; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-pen-nib"></i> Personal Note
                    </div>
                    <div id="noteModalNoteText" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 16px 20px; border-radius: 12px; color: #f8fafc; font-size: 15.5px; line-height: 1.8; white-space: pre-wrap;"></div>
                </div>

                {{-- Legal Context Section (if present) --}}
                <div id="noteModalContextWrapper" style="display: none; margin-top: 24px; padding-top: 20px; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
                    <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-scale-balanced"></i> Full Section Text
                    </div>
                    <div id="noteModalContextHtml" style="color: #cbd5e1; font-size: 14.5px; line-height: 1.8; max-height: 240px; overflow-y: auto; background: rgba(0,0,0,0.2); padding: 14px 18px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.04);"></div>
                </div>
            </div>
        </div>

        <div class="note-modal-footer">
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" class="btn-action-note" onclick="openNoteEditModalFromActive()" style="padding: 7px 14px; background: rgba(59, 130, 246, 0.15); border-color: rgba(59, 130, 246, 0.35); color: #93c5fd; font-weight: 600;">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Note
                </button>
                <a id="noteModalPdfLink" href="#" class="btn-action-note" style="padding: 7px 12px; background: rgba(239, 68, 68, 0.12); border-color: rgba(239, 68, 68, 0.3); color: #f87171;">
                    <i class="fa-solid fa-file-pdf"></i>
                </a>
                <a id="noteModalWordLink" href="#" class="btn-action-note" style="padding: 7px 12px; background: rgba(59, 130, 246, 0.12); border-color: rgba(59, 130, 246, 0.3); color: #60a5fa;">
                    <i class="fa-solid fa-file-word"></i>
                </a>
                <button type="button" id="noteModalDeleteBtn" class="btn-action-note" onclick="deleteActiveModalNote()" style="padding: 7px 12px; background: rgba(239, 68, 68, 0.08); border-color: rgba(239, 68, 68, 0.2); color: #f87171;">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a id="noteModalFullReaderLink" href="#" target="_blank" class="btn-view-note" style="background: rgba(245, 158, 11, 0.15); border-color: rgba(245, 158, 11, 0.35); color: #f59e0b;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Open in Reader
                </a>
                <button type="button" class="btn-action-note" onclick="closeNoteModal()" style="padding: 7px 16px; background: rgba(255, 255, 255, 0.08); border-color: rgba(255, 255, 255, 0.15); color: #e2e8f0;">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ====== NOTE EDIT MODAL ====== --}}
<div id="noteEditModalBackdrop" class="note-modal-backdrop" onclick="if(event.target === this) closeNoteEditModal()">
    <div class="note-modal-card" style="max-width: 680px;">
        <div class="note-modal-header">
            <div>
                <h2 style="color: #fff; font-size: 19px; font-weight: 800; margin: 0 0 4px; line-height: 1.35; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-pen-to-square" style="color: #3b82f6;"></i>
                    Edit Study Note
                </h2>
                <div id="noteEditModalSubTitle" style="color: #60a5fa; font-size: 13px; font-weight: 500;"></div>
            </div>
            <button type="button" class="note-modal-close" onclick="closeNoteEditModal()" title="Close Edit">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="note-modal-body">
            {{-- Highlight Excerpt Preview in Edit Modal --}}
            <div id="noteEditModalQuoteWrapper" style="margin-bottom: 16px; display: none;">
                <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; color: #f59e0b; margin-bottom: 6px;">
                    <i class="fa-solid fa-quote-left mr-1"></i> Highlighted Excerpt
                </div>
                <div id="noteEditModalQuote" style="background: rgba(245, 158, 11, 0.08); border-left: 3px solid #f59e0b; padding: 10px 14px; border-radius: 0 8px 8px 0; color: #fde68a; font-style: italic; font-size: 13px; line-height: 1.5;"></div>
            </div>

            {{-- Color Picker Selector --}}
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin-bottom: 8px;">Note Accent Color</label>
                <div class="color-picker-group">
                    <label>
                        <input type="radio" name="note_edit_color" value="yellow" class="color-chip-radio" id="colorRadioYellow">
                        <span class="color-chip-label" style="background: #f59e0b;" title="Yellow"></span>
                    </label>
                    <label>
                        <input type="radio" name="note_edit_color" value="blue" class="color-chip-radio" id="colorRadioBlue">
                        <span class="color-chip-label" style="background: #3b82f6;" title="Blue"></span>
                    </label>
                    <label>
                        <input type="radio" name="note_edit_color" value="green" class="color-chip-radio" id="colorRadioGreen">
                        <span class="color-chip-label" style="background: #10b981;" title="Green"></span>
                    </label>
                    <label>
                        <input type="radio" name="note_edit_color" value="pink" class="color-chip-radio" id="colorRadioPink">
                        <span class="color-chip-label" style="background: #ec4899;" title="Pink"></span>
                    </label>
                    <label>
                        <input type="radio" name="note_edit_color" value="purple" class="color-chip-radio" id="colorRadioPurple">
                        <span class="color-chip-label" style="background: #8b5cf6;" title="Purple"></span>
                    </label>
                </div>
            </div>

            {{-- Note Content Editor --}}
            <div>
                <label for="noteEditModalTextarea" style="display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin-bottom: 8px;">Note Content</label>
                <textarea id="noteEditModalTextarea" style="width: 100%; min-height: 180px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 12px; padding: 14px 16px; color: #f8fafc; font-size: 14.5px; line-height: 1.7; font-family: inherit; resize: vertical; box-sizing: border-box;"></textarea>
            </div>
        </div>

        <div class="note-modal-footer">
            <button type="button" class="btn-action-note" onclick="closeNoteEditModal()" style="padding: 8px 18px; background: rgba(255, 255, 255, 0.06); border-color: rgba(255, 255, 255, 0.12); color: #cbd5e1;">
                Cancel
            </button>
            <button type="button" id="btnSaveModalNote" class="btn-save-inline" onclick="saveModalEditNote()" style="padding: 8px 22px; font-size: 13.5px; font-weight: 700;">
                <i class="fa-solid fa-floppy-disk mr-1"></i> Save Changes
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentActiveNoteId = null;
    let cachedNotesData = {};

    // ====== VIEW SWITCHER (CARDS vs LINEAR) ======
    function switchNotesView(view) {
        const container = document.getElementById('notesListDashboard');
        const gridBtn = document.getElementById('btnViewGrid');
        const linearBtn = document.getElementById('btnViewLinear');

        if (!container) return;

        if (view === 'linear') {
            container.classList.remove('view-grid');
            container.classList.add('view-linear');
            linearBtn?.classList.add('active');
            gridBtn?.classList.remove('active');
            localStorage.setItem('user_notes_view', 'linear');
        } else {
            container.classList.remove('view-linear');
            container.classList.add('view-grid');
            gridBtn?.classList.add('active');
            linearBtn?.classList.remove('active');
            localStorage.setItem('user_notes_view', 'grid');
        }
    }

    // Initialize user saved view (defaults to cards on mobile, linear on desktop)
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth <= 768) {
            switchNotesView('grid');
        } else {
            const savedView = localStorage.getItem('user_notes_view') || 'linear';
            switchNotesView(savedView);
        }
    });

    // ====== PREVIEW MODAL ======
    function openNotePreviewModal(noteId) {
        currentActiveNoteId = noteId;
        const backdrop = document.getElementById('notePreviewModalBackdrop');
        const loader = document.getElementById('noteModalLoader');
        const contentWrapper = document.getElementById('noteModalContentWrapper');
        const titleEl = document.getElementById('noteModalSectionTitle');
        const docTitleEl = document.getElementById('noteModalDocTitleText');
        const badgeEl = document.getElementById('noteModalBadge');
        const badgeText = document.getElementById('noteModalBadgeText');
        const badgeIcon = document.getElementById('noteModalBadgeIcon');
        const dateText = document.getElementById('noteModalDateText');
        const quoteWrapper = document.getElementById('noteModalQuoteWrapper');
        const quoteEl = document.getElementById('noteModalQuote');
        const noteTextEl = document.getElementById('noteModalNoteText');
        const contextWrapper = document.getElementById('noteModalContextWrapper');
        const contextHtmlEl = document.getElementById('noteModalContextHtml');
        const pdfLink = document.getElementById('noteModalPdfLink');
        const wordLink = document.getElementById('noteModalWordLink');
        const fullReaderLink = document.getElementById('noteModalFullReaderLink');

        if (backdrop && backdrop.parentNode !== document.body) {
            document.body.appendChild(backdrop);
        }

        titleEl.textContent = 'Loading Note...';
        docTitleEl.textContent = '';
        dateText.textContent = '';
        quoteWrapper.style.display = 'none';
        contextWrapper.style.display = 'none';
        loader.style.display = 'block';
        contentWrapper.style.display = 'none';
        backdrop.classList.add('active');

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('/notes/content/' + noteId, {
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
                cachedNotesData[noteId] = res;

                titleEl.textContent = res.article_section || res.document_title || 'Legal Note';
                docTitleEl.textContent = res.document_title || '';
                dateText.textContent = res.created_at || '';
                noteTextEl.textContent = res.note_content || '';

                if (res.highlighted_text && res.highlighted_text.trim()) {
                    quoteEl.textContent = '"' + res.highlighted_text + '"';
                    quoteWrapper.style.display = 'block';
                } else {
                    quoteWrapper.style.display = 'none';
                }

                if (res.section_html && res.section_html.trim()) {
                    contextHtmlEl.innerHTML = res.section_html;
                    contextWrapper.style.display = 'block';
                } else {
                    contextWrapper.style.display = 'none';
                }

                // Badge styling
                badgeEl.className = 'note-type-badge';
                if (res.document_type === 'constitution') {
                    badgeEl.classList.add('badge-constitution');
                    badgeIcon.className = 'fa-solid fa-landmark';
                    badgeText.textContent = 'Constitution';
                } else if (res.document_type === 'case_law' || res.document_type === 'judgment' || res.document_type === 'judgement') {
                    badgeEl.classList.add('badge-case-law');
                    badgeIcon.className = 'fa-solid fa-gavel';
                    badgeText.textContent = 'Case Law';
                } else if (res.document_type === 'pre_1992') {
                    badgeEl.classList.add('badge-pre-1992');
                    badgeIcon.className = 'fa-solid fa-scroll';
                    badgeText.textContent = 'Existing Law';
                } else {
                    badgeEl.classList.add('badge-legislation');
                    badgeIcon.className = 'fa-solid fa-scale-balanced';
                    badgeText.textContent = 'Legislation';
                }

                if (res.pdf_url) pdfLink.href = res.pdf_url;
                if (res.word_url) wordLink.href = res.word_url;
                if (res.page_url) {
                    fullReaderLink.href = res.page_url;
                    fullReaderLink.style.display = 'inline-flex';
                } else {
                    fullReaderLink.style.display = 'none';
                }
            } else {
                titleEl.textContent = 'Unable to Load Note';
                noteTextEl.textContent = res.message || 'An error occurred while fetching the note.';
            }
        })
        .catch(function(err) {
            loader.style.display = 'none';
            contentWrapper.style.display = 'block';
            titleEl.textContent = 'Error Loading Note';
            noteTextEl.textContent = 'Unable to connect to server (' + err.message + '). Please try again.';
        });
    }

    function closeNoteModal() {
        const backdrop = document.getElementById('notePreviewModalBackdrop');
        if (backdrop) {
            backdrop.classList.remove('active');
        }
    }

    // ====== EDIT MODAL ======
    function openNoteEditModal(noteId) {
        currentActiveNoteId = noteId;
        const editBackdrop = document.getElementById('noteEditModalBackdrop');
        const subtitleEl = document.getElementById('noteEditModalSubTitle');
        const quoteWrapper = document.getElementById('noteEditModalQuoteWrapper');
        const quoteEl = document.getElementById('noteEditModalQuote');
        const textarea = document.getElementById('noteEditModalTextarea');

        if (editBackdrop && editBackdrop.parentNode !== document.body) {
            document.body.appendChild(editBackdrop);
        }

        // Close preview modal if open
        closeNoteModal();

        // Check if data already cached
        if (cachedNotesData[noteId]) {
            populateEditModal(cachedNotesData[noteId]);
        } else {
            // Fetch note data
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            fetch('/notes/content/' + noteId, {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(res => {
                if (res && res.success) {
                    cachedNotesData[noteId] = res;
                    populateEditModal(res);
                }
            });
        }

        editBackdrop.classList.add('active');
        setTimeout(() => textarea.focus(), 150);

        function populateEditModal(data) {
            subtitleEl.textContent = (data.article_section ? data.article_section + ' — ' : '') + (data.document_title || '');
            textarea.value = data.note_content || '';

            if (data.highlighted_text && data.highlighted_text.trim()) {
                quoteEl.textContent = '"' + data.highlighted_text + '"';
                quoteWrapper.style.display = 'block';
            } else {
                quoteWrapper.style.display = 'none';
            }

            // Select color radio
            const color = data.note_color || 'yellow';
            const radio = document.querySelector('input[name="note_edit_color"][value="' + color + '"]');
            if (radio) radio.checked = true;
        }
    }

    function openNoteEditModalFromActive() {
        if (currentActiveNoteId) {
            openNoteEditModal(currentActiveNoteId);
        }
    }

    function closeNoteEditModal() {
        const editBackdrop = document.getElementById('noteEditModalBackdrop');
        if (editBackdrop) {
            editBackdrop.classList.remove('active');
        }
    }

    function saveModalEditNote() {
        if (!currentActiveNoteId) return;
        const noteId = currentActiveNoteId;
        const textarea = document.getElementById('noteEditModalTextarea');
        const saveBtn = document.getElementById('btnSaveModalNote');
        const newContent = textarea.value.trim();
        const selectedColor = document.querySelector('input[name="note_edit_color"]:checked')?.value || 'yellow';

        if (!newContent) {
            if (typeof showToast === 'function') showToast('Note content cannot be empty', 'error');
            return;
        }

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-1"></i> Saving...';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('/notes/' + noteId, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                note_content: newContent,
                note_color: selectedColor
            })
        })
        .then(res => res.json())
        .then(res => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk mr-1"></i> Save Changes';

            if (res && res.success) {
                // Update card text & color on dashboard
                const card = document.getElementById('noteCard' + noteId);
                const bodyEl = document.getElementById('noteBody' + noteId);
                const inlineTextarea = document.getElementById('noteQuickEditTextarea' + noteId);

                if (bodyEl) bodyEl.textContent = newContent;
                if (inlineTextarea) inlineTextarea.value = newContent;
                if (card) card.setAttribute('data-color', selectedColor);

                if (cachedNotesData[noteId]) {
                    cachedNotesData[noteId].note_content = newContent;
                    cachedNotesData[noteId].note_color = selectedColor;
                }

                closeNoteEditModal();
                if (typeof showToast === 'function') showToast('Note updated successfully!', 'success');
            } else {
                if (typeof showToast === 'function') showToast(res ? res.message : 'Failed to save note', 'error');
            }
        })
        .catch(err => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="fa-solid fa-floppy-disk mr-1"></i> Save Changes';
            if (typeof showToast === 'function') showToast('Error saving note', 'error');
        });
    }

    // ====== QUICK INLINE EDIT ======
    function startQuickEditNote(id) {
        const bodyEl = document.getElementById('noteBody' + id);
        const container = document.getElementById('noteQuickEditContainer' + id);
        const textarea = document.getElementById('noteQuickEditTextarea' + id);

        if (bodyEl) bodyEl.style.display = 'none';
        if (container) container.style.display = 'block';
        if (textarea) textarea.focus();
    }

    function cancelQuickEditNote(id) {
        const bodyEl = document.getElementById('noteBody' + id);
        const container = document.getElementById('noteQuickEditContainer' + id);

        if (bodyEl) bodyEl.style.display = '-webkit-box';
        if (container) container.style.display = 'none';
    }

    function saveQuickEditNote(id) {
        const textarea = document.getElementById('noteQuickEditTextarea' + id);
        const newContent = (textarea.value || '').trim();

        if (!newContent) {
            if (typeof showToast === 'function') showToast('Note content cannot be empty', 'error');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('/notes/' + id, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ note_content: newContent })
        })
        .then(res => res.json())
        .then(res => {
            if (res && res.success) {
                const bodyEl = document.getElementById('noteBody' + id);
                if (bodyEl) bodyEl.textContent = newContent;
                cancelQuickEditNote(id);

                if (cachedNotesData[id]) {
                    cachedNotesData[id].note_content = newContent;
                }
                if (typeof showToast === 'function') showToast('Note updated successfully!', 'success');
            } else {
                if (typeof showToast === 'function') showToast(res ? res.message : 'Failed to update note', 'error');
            }
        })
        .catch(() => {
            if (typeof showToast === 'function') showToast('Error updating note', 'error');
        });
    }

    // ====== DELETE NOTE ======
    function deleteActiveModalNote() {
        if (!currentActiveNoteId) return;
        const idToDelete = currentActiveNoteId;
        closeNoteModal();
        deleteNoteDashboard(idToDelete);
    }

    function deleteNoteDashboard(id) {
        if (!confirm('Are you sure you want to delete this note?')) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch('/notes/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res && res.success) {
                const card = document.getElementById('noteCard' + id);
                if (card) {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        card.remove();
                        filterNotes();

                        const remaining = document.querySelectorAll('.note-dashboard-card').length;
                        const badge = document.getElementById('notesCountBadge');
                        if (badge) badge.textContent = remaining;

                        if (remaining === 0) {
                            window.location.reload();
                        }
                    }, 300);
                }
                if (typeof showToast === 'function') showToast('Note deleted successfully', 'info');
            } else {
                if (typeof showToast === 'function') showToast(res ? res.message : 'Failed to delete note', 'error');
            }
        })
        .catch(() => {
            if (typeof showToast === 'function') showToast('Error deleting note', 'error');
        });
    }

    // ====== FILTER & SEARCH ======
    function filterNotes() {
        const searchVal = (document.getElementById('searchNotes').value || '').toLowerCase().trim();
        const docType = document.getElementById('filterDocType').value;
        const color = document.getElementById('filterColor').value;
        const cards = document.querySelectorAll('.note-dashboard-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardType = card.getAttribute('data-type');
            const cardColor = card.getAttribute('data-color');
            const cardSearch = card.getAttribute('data-search') || '';

            let matchType = false;
            if (docType === 'all') {
                matchType = true;
            } else if (docType === 'case_law') {
                matchType = (cardType === 'case_law' || cardType === 'judgment' || cardType === 'judgement');
            } else {
                matchType = (cardType === docType);
            }

            const matchColor = (color === 'all' || cardColor === color);
            const matchSearch = (!searchVal || cardSearch.indexOf(searchVal) !== -1);

            if (matchType && matchColor && matchSearch) {
                card.style.display = (document.getElementById('notesListDashboard').classList.contains('view-linear')) ? 'flex' : 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('filterEmptyNotesState');
        if (emptyState) {
            emptyState.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
        }
    }

    function resetNoteFilters() {
        document.getElementById('searchNotes').value = '';
        selectCustomFilter('filterDocType', 'all', 'All Documents', 'labelDocType', 'dropdownDocTypeMenu');
        selectCustomFilter('filterColor', 'all', 'All Colors', 'labelColor', 'dropdownColorMenu');
        filterNotes();
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
        // Close export menu
        const exportMenu = document.getElementById('exportAllMenu');
        if (exportMenu) exportMenu.style.display = 'none';

        if (menu) {
            menu.classList.toggle('show');
            container?.classList.toggle('open');
        }
    }

    function selectCustomFilter(hiddenInputId, val, labelText, labelSpanId, menuId) {
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
                // Fallback: match by onclick attribute or first child
                const matchingOpt = Array.from(menu.querySelectorAll('.custom-filter-option')).find(o => o.getAttribute('onclick')?.includes(`'${val}'`));
                if (matchingOpt) matchingOpt.classList.add('active');
            }
            menu.classList.remove('show');
            menu.closest('.custom-filter-dropdown')?.classList.remove('open');
        }

        filterNotes();
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNoteModal();
            closeNoteEditModal();
            document.querySelectorAll('.custom-filter-menu').forEach(m => m.classList.remove('show'));
            document.querySelectorAll('.custom-filter-dropdown').forEach(c => c.classList.remove('open'));
        }
    });

    // Toggle Export Menu
    function toggleExportMenu(e) {
        e.stopPropagation();
        // Close other custom dropdowns
        document.querySelectorAll('.custom-filter-menu').forEach(m => {
            m.classList.remove('show');
            m.closest('.custom-filter-dropdown')?.classList.remove('open');
        });
        const menu = document.getElementById('exportAllMenu');
        if (menu) menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const menu = document.getElementById('exportAllMenu');
        if (menu && menu.style.display === 'block') {
            const btn = document.getElementById('btnExportAllNotes');
            if (btn && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.style.display = 'none';
            }
        }
        if (!e.target.closest('.custom-filter-dropdown')) {
            document.querySelectorAll('.custom-filter-menu').forEach(m => m.classList.remove('show'));
            document.querySelectorAll('.custom-filter-dropdown').forEach(c => c.classList.remove('open'));
        }
    });
</script>
@endsection
