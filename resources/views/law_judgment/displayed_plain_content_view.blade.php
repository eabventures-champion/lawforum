@extends('extenders.plain_extender')

@section('title', ($allGhanaLawPlainView['case_title'] ?? 'Case Law Preview') . ' - Legal Reader - Legals Forum')

@section('assets')
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style type="text/css">
    /* =========================================================
       PREMIUM LEGAL READER DESIGN SYSTEM (LAWSFORUM DARK LUXURY)
       ========================================================= */
    :root {
        --reader-bg: #060a13;
        --reader-card: rgba(12, 18, 32, 0.75);
        --reader-border: rgba(255, 255, 255, 0.08);
        --reader-border-focus: rgba(59, 130, 246, 0.4);
        --reader-text: #f1f5f9;
        --reader-text-muted: #94a3b8;
        --reader-body-font: 'Merriweather', Georgia, serif;
        --reader-ui-font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        --accent-blue: #3b82f6;
        --accent-blue-light: #60a5fa;
        --accent-glow: rgba(59, 130, 246, 0.25);
        --gold: #f59e0b;
        --gold-glow: rgba(245, 158, 11, 0.2);
    }

    html, body {
        background-color: var(--reader-bg) !important;
        color: var(--reader-text) !important;
        font-family: var(--reader-ui-font) !important;
        font-size: 14px;
        padding-top: 50px !important;
        min-height: 100vh !important;
        height: auto !important;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    /* Override any default plain extender body white background */
    .container-fluid {
        background-color: transparent !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Fixed top navbar styling to match dark theme */
    .navbar-default {
        background: rgba(6, 10, 19, 0.94) !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }
    .navbar-default .navbar-collapse {
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
    .navbar-default .navbar-nav > li > a {
        color: #94a3b8 !important;
        font-weight: 500;
        transition: color 0.2s;
    }
    .navbar-default .navbar-nav > li > a:hover,
    .navbar-default .navbar-nav > li > a:focus {
        color: #f1f5f9 !important;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #060a13;
    }
    ::-webkit-scrollbar-thumb {
        background: #1e293b;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #334155;
    }

    /* =========================================================
       PAGE WRAPPER & LAYOUT
       ========================================================= */
    .reader-page-wrapper {
        max-width: 1080px;
        margin: 20px auto 60px auto;
        padding: 0 20px;
    }

    /* Sticky Action & Navigation Bar */
    .reader-toolbar {
        position: sticky;
        top: 60px;
        z-index: 100;
        background: rgba(12, 18, 32, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--reader-border);
        border-radius: 14px;
        padding: 10px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .toolbar-left, .toolbar-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-reader-nav {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        text-decoration: none !important;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-reader-nav:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.15);
        transform: translateY(-1px);
    }
    .btn-reader-nav.primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #ffffff;
        border: none;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .btn-reader-nav.primary:hover {
        background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.45);
    }

    /* Font Size Control Group */
    .font-size-control {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        overflow: hidden;
    }
    .font-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .font-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
    }
    .font-btn:active {
        background: rgba(59, 130, 246, 0.2);
    }
    .font-indicator {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        padding: 0 8px;
        border-left: 1px solid rgba(255, 255, 255, 0.05);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        user-select: none;
    }

    /* =========================================================
       HERO CASE HEADER CARD
       ========================================================= */
    .case-header-card {
        background: linear-gradient(180deg, rgba(17, 24, 39, 0.85) 0%, rgba(12, 18, 32, 0.95) 100%);
        border: 1px solid var(--reader-border);
        border-radius: 16px;
        padding: 36px 32px 30px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.35);
    }
    .case-header-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6 0%, #f59e0b 50%, #8b5cf6 100%);
    }

    /* Court Emblem & Jurisdiction Header */
    .court-jurisdiction-wrap {
        text-align: center;
        margin-bottom: 24px;
        position: relative;
    }
    .court-seal-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #f59e0b;
        font-size: 22px;
        margin-bottom: 14px;
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.15);
    }
    .court-title-text {
        font-family: 'Cinzel', serif;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #e2e8f0;
        margin: 0 0 6px 0;
        line-height: 1.6;
    }
    .court-division-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 12px;
        background: rgba(59, 130, 246, 0.12);
        border: 1px solid rgba(59, 130, 246, 0.25);
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #60a5fa;
        margin-top: 6px;
    }

    /* Case Title & Parties Presentation */
    .case-title-box {
        text-align: center;
        padding: 24px 20px;
        background: rgba(15, 23, 42, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        margin: 20px 0 26px 0;
    }
    .party-title {
        font-family: 'Outfit', 'Inter', sans-serif;
        font-size: 21px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: -0.3px;
        margin: 0;
        line-height: 1.4;
    }
    .party-role {
        font-size: 13px;
        font-weight: 500;
        color: #94a3b8;
    }
    .vs-badge-divider {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 18px;
        margin: 10px 0;
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.3);
        border-radius: 20px;
        color: #f59e0b;
        font-family: 'Cinzel', serif;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    /* Metadata Badge Grid */
    .case-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
        margin-top: 20px;
    }
    .meta-chip {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 10px;
        padding: 12px 14px;
        transition: all 0.2s ease;
    }
    .meta-chip:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.12);
    }
    .meta-chip-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .meta-chip.date .meta-chip-icon {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }
    .meta-chip.suit .meta-chip-icon {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
    }
    .meta-chip.court .meta-chip-icon {
        background: rgba(139, 92, 246, 0.15);
        color: #a78bfa;
    }
    .meta-chip.cat .meta-chip-icon {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
    }
    .meta-chip-details {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .meta-chip-label {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 2px;
    }
    .meta-chip-value {
        font-size: 13.5px;
        font-weight: 600;
        color: #f1f5f9;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Bench & Counsel Section */
    .bench-counsel-card {
        margin-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 16px;
    }
    .bench-block {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 14px 16px;
    }
    .bench-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #60a5fa;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .bench-value {
        font-size: 13.5px;
        font-weight: 600;
        color: #e2e8f0;
        line-height: 1.6;
    }
    .bench-value br {
        content: "";
        margin: 4px 0;
        display: block;
    }

    /* =========================================================
       READING CANVAS & TYPOGRAPHY
       ========================================================= */
    .reader-body-card {
        background: rgba(12, 18, 32, 0.7);
        border: 1px solid var(--reader-border);
        border-radius: 16px;
        padding: 48px 56px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        position: relative;
    }

    .judgment-reading-canvas {
        font-family: var(--reader-body-font);
        font-size: 16px;
        line-height: 1.95;
        color: #cbd5e1;
        letter-spacing: 0.1px;
    }

    /* Override any hardcoded database colors or styles */
    .judgment-reading-canvas p,
    .judgment-reading-canvas span,
    .judgment-reading-canvas div,
    .judgment-reading-canvas table,
    .judgment-reading-canvas td,
    .judgment-reading-canvas th,
    .judgment-reading-canvas h1,
    .judgment-reading-canvas h2,
    .judgment-reading-canvas h3,
    .judgment-reading-canvas h4,
    .judgment-reading-canvas h5,
    .judgment-reading-canvas h6 {
        color: inherit !important;
        background: transparent !important;
    }

    .judgment-reading-canvas p {
        margin-bottom: 24px;
        text-align: justify;
    }

    .judgment-reading-canvas h1,
    .judgment-reading-canvas h2,
    .judgment-reading-canvas h3,
    .judgment-reading-canvas h4,
    .judgment-reading-canvas h5,
    .judgment-reading-canvas h6 {
        font-family: 'Outfit', var(--reader-ui-font);
        color: #ffffff !important;
        font-weight: 700;
        margin-top: 36px;
        margin-bottom: 16px;
        line-height: 1.4;
    }

    .judgment-reading-canvas blockquote {
        margin: 24px 0;
        padding: 16px 24px;
        border-left: 3px solid #3b82f6;
        background: rgba(59, 130, 246, 0.05);
        border-radius: 0 10px 10px 0;
        color: #e2e8f0;
        font-style: italic;
    }

    .judgment-reading-canvas table {
        width: 100% !important;
        margin: 24px 0;
        border-collapse: collapse;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .judgment-reading-canvas th,
    .judgment-reading-canvas td {
        padding: 12px 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 14px;
    }
    .judgment-reading-canvas th {
        background: rgba(255, 255, 255, 0.04) !important;
        font-weight: 700;
        color: #ffffff !important;
    }

    /* Paragraph Numbers formatting e.g. [1], [2] */
    .judgment-reading-canvas strong, 
    .judgment-reading-canvas b {
        color: #ffffff !important;
        font-weight: 700;
    }

    /* Reader Footer */
    .reader-footer {
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        color: #64748b;
        font-size: 12px;
    }

    /* Toast Notification for Citation Copy */
    .citation-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        background: #0f172a;
        border: 1px solid #10b981;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        color: #f1f5f9;
        padding: 12px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        font-weight: 600;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
    }
    .citation-toast.active {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    .citation-toast i {
        color: #10b981;
        font-size: 16px;
    }

    /* =========================================================
       PRINT STYLESHEET
       ========================================================= */
    @media print {
        body, html {
            background-color: #ffffff !important;
            color: #000000 !important;
            padding-top: 0 !important;
            font-size: 12pt !important;
        }
        .navbar, .reader-toolbar, .btn-reader-nav, .citation-toast {
            display: none !important;
        }
        .reader-page-wrapper {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .case-header-card, .reader-body-card {
            background: #ffffff !important;
            color: #000000 !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin-bottom: 20px !important;
        }
        .case-header-card::before {
            display: none !important;
        }
        .court-title-text, .party-title, .judgment-reading-canvas, .meta-chip-value, .bench-value {
            color: #000000 !important;
        }
        .meta-chip, .bench-block, .case-title-box {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            color: #000000 !important;
        }
        .court-seal-badge {
            border-color: #000000 !important;
            color: #000000 !important;
        }
        .judgment-reading-canvas {
            color: #111827 !important;
            font-size: 11pt !important;
            line-height: 1.6 !important;
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .case-header-card {
            padding: 24px 16px;
        }
        .reader-body-card {
            padding: 24px 18px;
        }
        .party-title {
            font-size: 18px;
        }
        .court-title-text {
            font-size: 13px;
        }
        .reader-toolbar {
            top: 50px;
            padding: 8px 12px;
        }
        .case-meta-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="reader-page-wrapper">

    <!-- Sticky Reading Toolbar -->
    <div class="reader-toolbar">
        <div class="toolbar-left">
            <a href="javascript:history.back()" class="btn-reader-nav" title="Return to Previous Page">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back</span>
            </a>
            <a href="/judgement/Ghana" class="btn-reader-nav" title="All Ghana Case Laws">
                <i class="fa-solid fa-scale-balanced"></i>
                <span class="hidden-xs">Case Laws</span>
            </a>
            @if(!empty($allGhanaLawPlainView['gh_law_judgment_group_name']))
                <span class="court-division-pill hidden-xs">
                    <i class="fa-solid fa-gavel"></i>
                    {{ str_replace('-', ' ', $allGhanaLawPlainView['gh_law_judgment_group_name']) }}
                </span>
            @endif
        </div>

        <div class="toolbar-right">
            <!-- Font Sizing Buttons -->
            <div class="font-size-control" title="Adjust Reading Text Size">
                <button type="button" class="font-btn" onclick="adjustFontSize(-1)" title="Smaller Text">A-</button>
                <span class="font-indicator" id="fontSizeIndicator">16px</span>
                <button type="button" class="font-btn" onclick="adjustFontSize(1)" title="Larger Text">A+</button>
            </div>

            <!-- Citation Copy Button -->
            <button type="button" class="btn-reader-nav" onclick="copyCitation()" title="Copy Case Citation">
                <i class="fa-regular fa-copy"></i>
                <span class="hidden-xs">Citation</span>
            </button>

            <!-- Print Page Button -->
            <button type="button" class="btn-reader-nav" onclick="window.print()" title="Print this Judgment">
                <i class="fa-solid fa-print"></i>
                <span class="hidden-xs">Print</span>
            </button>

            <!-- PDF Download Button -->
            @php
                $caseTitleForUrl = rawurlencode($allGhanaLawPlainView['case_title'] ?? 'judgment');
                $caseId = $allGhanaLawPlainView['id'] ?? 0;
            @endphp
            <a href="/judgement/1/case_law/pdf_view/{{ $caseTitleForUrl }}/{{ $caseId }}" class="btn-reader-nav primary" title="Download Official Judgment PDF" target="_blank">
                <i class="fa-solid fa-file-pdf"></i>
                <span>PDF</span>
            </a>
        </div>
    </div>

    <!-- Hero Case Header Card -->
    <div class="case-header-card">
        <!-- Court Jurisdiction & Seal -->
        <div class="court-jurisdiction-wrap">
            <div class="court-seal-badge">
                <i class="fa-solid fa-scale-unbalanced"></i>
            </div>
            <h1 class="court-title-text">{!! $allGhanaLawPlainView['court_name'] !!}</h1>
            @if(!empty($allGhanaLawPlainView['judgement_type']))
                <span class="court-division-pill">
                    <i class="fa-solid fa-certificate"></i> {{ $allGhanaLawPlainView['judgement_type'] }}
                </span>
            @endif
        </div>

        <!-- Case Title & Parties Presentation -->
        <div class="case-title-box">
            @if(!empty($allGhanaLawPlainView['case_title_1']) && !empty($allGhanaLawPlainView['case_title_2']))
                <h2 class="party-title">{!! $allGhanaLawPlainView['case_title_1'] !!}</h2>
                <div>
                    <span class="vs-badge-divider">vs.</span>
                </div>
                <h2 class="party-title">{!! $allGhanaLawPlainView['case_title_2'] !!}</h2>
            @else
                <h2 class="party-title">{{ $allGhanaLawPlainView['case_title'] ?? 'IN RE: CASE LAW' }}</h2>
            @endif
        </div>

        <!-- Metadata Chips Grid -->
        <div class="case-meta-grid">
            <!-- Date Chip -->
            <div class="meta-chip date">
                <div class="meta-chip-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div class="meta-chip-details">
                    <span class="meta-chip-label">Judgment Date</span>
                    <span class="meta-chip-value">{{ $allGhanaLawPlainView['date'] ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Suit Number / Reference Chip -->
            <div class="meta-chip suit">
                <div class="meta-chip-icon">
                    <i class="fa-solid fa-hashtag"></i>
                </div>
                <div class="meta-chip-details">
                    <span class="meta-chip-label">{{ $allGhanaLawPlainView['case_type_name'] ?? 'Suit / Case No.' }}</span>
                    <span class="meta-chip-value">{{ $allGhanaLawPlainView['reference_number'] ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Court Division -->
            <div class="meta-chip court">
                <div class="meta-chip-icon">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="meta-chip-details">
                    <span class="meta-chip-label">Jurisdiction</span>
                    <span class="meta-chip-value">{{ str_replace('-', ' ', $allGhanaLawPlainView['gh_law_judgment_group_name'] ?? 'Superior Court of Judicature') }}</span>
                </div>
            </div>

            <!-- Category Chip -->
            @if(!empty($allGhanaLawPlainView['gh_law_judgment_category_name']))
            <div class="meta-chip cat">
                <div class="meta-chip-icon">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="meta-chip-details">
                    <span class="meta-chip-label">Legal Category</span>
                    <span class="meta-chip-value">{{ $allGhanaLawPlainView['gh_law_judgment_category_name'] }}</span>
                </div>
            </div>
            @endif
        </div>

        <!-- Bench & Counsel Information -->
        @if(!empty($allGhanaLawPlainView['coram']) || !empty($allGhanaLawPlainView['counsellors']))
        <div class="bench-counsel-card">
            @if(!empty($allGhanaLawPlainView['coram']))
            <div class="bench-block">
                <div class="bench-label">
                    <i class="fa-solid fa-gavel"></i>
                    <span>Coram / Presiding Judge(s)</span>
                </div>
                <div class="bench-value">
                    {{ $allGhanaLawPlainView['coram'] }}
                </div>
            </div>
            @endif

            @if(!empty($allGhanaLawPlainView['counsellors']))
            <div class="bench-block">
                <div class="bench-label">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Legal Representation / Counsel</span>
                </div>
                <div class="bench-value">
                    {!! $allGhanaLawPlainView['counsellors'] !!}
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

    <!-- Reading Body Canvas -->
    <div class="reader-body-card">
        <div class="judgment-reading-canvas" id="judgmentCanvas">
            {!! $allGhanaLawPlainView['content'] !!}
        </div>

        <!-- Bottom Reader Footer -->
        <div class="reader-footer">
            <div>
                <i class="fa-solid fa-shield-halved text-primary mr-1"></i>
                Official Judgment Text &bull; Republic of Ghana Superior Court of Judicature
            </div>
            <div>
                <a href="#top" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" class="btn-reader-nav" style="font-size: 11px; padding: 4px 10px;">
                    <i class="fa-solid fa-arrow-up"></i> Top
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Citation Copied Notification Toast -->
<div class="citation-toast" id="citationToast">
    <i class="fa-solid fa-circle-check"></i>
    <span>Citation copied to clipboard!</span>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    // Font Sizing Utility
    let currentFontSize = 16;
    const minFontSize = 13;
    const maxFontSize = 24;

    function adjustFontSize(delta) {
        currentFontSize += delta;
        if (currentFontSize < minFontSize) currentFontSize = minFontSize;
        if (currentFontSize > maxFontSize) currentFontSize = maxFontSize;

        const canvas = document.getElementById('judgmentCanvas');
        if (canvas) {
            canvas.style.fontSize = currentFontSize + 'px';
        }
        const indicator = document.getElementById('fontSizeIndicator');
        if (indicator) {
            indicator.textContent = currentFontSize + 'px';
        }
    }

    // Citation Copy Utility
    function copyCitation() {
        const title = @json($allGhanaLawPlainView['case_title'] ?? '');
        const suitNo = @json($allGhanaLawPlainView['reference_number'] ?? '');
        const date = @json($allGhanaLawPlainView['date'] ?? '');
        const court = @json(strip_tags($allGhanaLawPlainView['court_name'] ?? ''));

        const citation = `${title} (${date}) [${suitNo}], ${court.replace(/\s+/g, ' ').trim()}`;

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(citation).then(showCitationToast).catch(() => fallbackCopy(citation));
        } else {
            fallbackCopy(citation);
        }
    }

    function fallbackCopy(text) {
        const temp = document.createElement('textarea');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        try {
            document.execCommand('copy');
            showCitationToast();
        } catch (e) {
            alert('Citation: ' + text);
        }
        document.body.removeChild(temp);
    }

    function showCitationToast() {
        const toast = document.getElementById('citationToast');
        if (toast) {
            toast.classList.add('active');
            setTimeout(() => {
                toast.classList.remove('active');
            }, 3000);
        }
    }
</script>
@endsection
