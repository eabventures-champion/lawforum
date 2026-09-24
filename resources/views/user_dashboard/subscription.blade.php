@extends('layouts.user')

@section('title', 'Subscription Plans')

@section('styles')
    <script src=https://checkout.flutterwave.com/v3.js></script>
    <style>
        .subscription-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 10px 0 40px;
        }

        /* ── Header Banner ── */
        .sub-header-hero {
            text-align: center;
            margin-bottom: 48px;
            position: relative;
        }

        .sub-pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 100px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .sub-pill-badge i {
            font-size: 13px;
        }

        .sub-hero-title {
            font-size: 34px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.6px;
            line-height: 1.25;
            margin-bottom: 12px;
        }

        .sub-hero-title span {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #93c5fd 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sub-hero-desc {
            font-size: 15px;
            color: #94a3b8;
            max-width: 640px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ── Current Active Plan Notice (If user has one) ── */
        .current-plan-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(6, 78, 59, 0.15) 100%);
            border: 1px solid rgba(16, 185, 129, 0.35);
            border-radius: 16px;
            padding: 20px 28px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .current-plan-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .current-plan-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #34d399;
            font-size: 22px;
            flex-shrink: 0;
        }

        .current-plan-info h4 {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .current-plan-info p {
            font-size: 13px;
            color: #cbd5e1;
            margin: 0;
        }

        /* ── Pricing Grid ── */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            align-items: stretch;
            margin-bottom: 48px;
        }

        /* ── Pricing Card ── */
        .pricing-card {
            background: rgba(13, 20, 38, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 32px 26px;
            display: flex;
            flex-direction: column;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .pricing-card:hover {
            transform: translateY(-6px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 24px rgba(59, 130, 246, 0.15);
        }

        /* Highlighted / Popular Card */
        .pricing-card.is-popular {
            background: linear-gradient(180deg, rgba(20, 32, 64, 0.85) 0%, rgba(13, 20, 38, 0.95) 100%);
            border: 2px solid #3b82f6;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.6), 0 0 32px rgba(59, 130, 246, 0.25);
            transform: scale(1.02);
        }

        .pricing-card.is-popular:hover {
            transform: scale(1.02) translateY(-6px);
            border-color: #60a5fa;
            box-shadow: 0 24px 50px rgba(0, 0, 0, 0.65), 0 0 40px rgba(59, 130, 246, 0.35);
        }

        /* Popular Floating Badge */
        .popular-badge-wrapper {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            z-index: 10;
        }

        .popular-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 5px 16px;
            border-radius: 100px;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .popular-badge i {
            color: #fbbf24;
        }

        /* Card Header */
        .pricing-header {
            margin-bottom: 24px;
            padding-bottom: 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-align: left;
        }

        .plan-tag-custom {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 10px;
            border-radius: 6px;
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
            margin-bottom: 12px;
        }

        .plan-name {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.3px;
            margin-bottom: 12px;
        }

        .plan-price-wrap {
            display: flex;
            align-items: baseline;
            gap: 4px;
            margin-bottom: 6px;
        }

        .plan-currency {
            font-size: 18px;
            font-weight: 700;
            color: #60a5fa;
        }

        .plan-amount {
            font-size: 38px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -1px;
            line-height: 1;
        }

        .plan-duration {
            font-size: 12.5px;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Card Features List */
        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0 0 32px 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .plan-features li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13.5px;
            color: #cbd5e1;
            line-height: 1.5;
        }

        .plan-features li i.icon-check {
            color: #10b981;
            font-size: 15px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .plan-features li strong {
            color: #ffffff;
        }

        /* Highlights pill inside card */
        .feature-highlight-box {
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12.5px;
            color: #93c5fd;
            font-weight: 600;
        }

        .feature-highlight-box i {
            font-size: 15px;
            color: #60a5fa;
            flex-shrink: 0;
        }

        /* CTA Subscribe Button */
        .btn-purchase {
            width: 100%;
            padding: 14px 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.2px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            outline: none;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn-purchase:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .pricing-card.is-popular .btn-purchase {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 6px 22px rgba(59, 130, 246, 0.4);
        }

        .pricing-card.is-popular .btn-purchase:hover {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #2563eb 100%);
            box-shadow: 0 8px 28px rgba(59, 130, 246, 0.55);
            border-color: rgba(255, 255, 255, 0.35);
        }

        .btn-purchase.is-disabled,
        .btn-purchase:disabled {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #64748b !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: none !important;
            opacity: 0.6 !important;
            pointer-events: none !important;
        }

        /* ── Current Active Plan Card & Button Styling ── */
        .pricing-card.is-current {
            border-color: rgba(16, 185, 129, 0.5) !important;
            background: linear-gradient(180deg, rgba(16, 185, 129, 0.06) 0%, rgba(13, 20, 38, 0.65) 100%) !important;
            box-shadow: 0 10px 32px rgba(16, 185, 129, 0.15) !important;
        }

        .popular-badge.badge-current-plan {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
            border-color: rgba(16, 185, 129, 0.5) !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4) !important;
            color: #ffffff !important;
        }

        .btn-purchase.is-current-plan,
        .btn-purchase.is-current-plan:disabled {
            background: rgba(16, 185, 129, 0.15) !important;
            border: 1px solid rgba(16, 185, 129, 0.45) !important;
            color: #34d399 !important;
            cursor: default !important;
            opacity: 1 !important;
            pointer-events: none !important;
            box-shadow: none !important;
            transform: none !important;
            font-weight: 700 !important;
        }

        .btn-purchase.btn-upgrade {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: 1px solid rgba(59, 130, 246, 0.4);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        .btn-purchase.btn-upgrade:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
            transform: translateY(-2px);
        }

        .btn-purchase.btn-downgrade {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #cbd5e1;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        }

        .btn-purchase.btn-downgrade:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.35);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        /* ── Collaborator Billing Governance Styles ── */
        .btn-purchase.btn-request-plan {
            background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
            border: 1px solid rgba(167, 139, 250, 0.4);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.35);
        }

        .btn-purchase.btn-request-plan:hover {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.5);
            transform: translateY(-2px);
        }

        .btn-purchase.btn-pending-request {
            background: rgba(245, 158, 11, 0.15) !important;
            border: 1px solid rgba(245, 158, 11, 0.45) !important;
            color: #fbbf24 !important;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.2) !important;
        }

        .btn-purchase.btn-pending-request:hover {
            background: rgba(245, 158, 11, 0.25) !important;
            border-color: rgba(245, 158, 11, 0.6) !important;
            color: #fef3c7 !important;
            transform: translateY(-2px);
        }

        .collaborator-billing-banner {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.12) 0%, rgba(37, 99, 235, 0.1) 100%);
            border: 1px solid rgba(139, 92, 246, 0.35);
            border-radius: 16px;
            padding: 18px 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        }

        .collab-banner-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .collab-banner-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(139, 92, 246, 0.2);
            border: 1px solid rgba(139, 92, 246, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a78bfa;
            font-size: 20px;
            flex-shrink: 0;
        }

        .collab-banner-text h4 {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 3px 0;
        }

        .collab-banner-text p {
            font-size: 13px;
            color: #cbd5e1;
            margin: 0;
            line-height: 1.45;
        }

        /* ── Plan Request Modal ── */
        .plan-req-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(8, 12, 24, 0.82);
            backdrop-filter: blur(6px);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .plan-req-modal {
            background: #0f172a;
            border: 1px solid rgba(139, 92, 246, 0.35);
            border-radius: 20px;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.65), 0 0 30px rgba(124, 58, 237, 0.15);
            overflow: hidden;
            animation: modalSlideIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalSlideIn {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .plan-req-modal-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .plan-req-modal-header h3 {
            font-size: 17px;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .plan-req-close-btn {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .plan-req-close-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.4);
        }

        .plan-req-modal-body {
            padding: 22px 24px;
        }

        .plan-req-plan-summary {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .plan-req-chip {
            padding: 5px 12px;
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
            font-size: 11.5px;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
            display: inline-block;
        }

        .plan-req-chip:hover {
            background: rgba(124, 58, 237, 0.2);
            border-color: rgba(139, 92, 246, 0.5);
            color: #e9d5ff;
        }

        .plan-req-textarea {
            width: 100%;
            background: rgba(13, 20, 38, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            color: #ffffff;
            padding: 12px 14px;
            font-size: 13.5px;
            outline: none;
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .plan-req-textarea:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
        }

        .plan-req-modal-footer {
            padding: 16px 24px 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        /* ── Trust & Security Footer Section ── */
        .sub-trust-bar {
            background: rgba(13, 20, 38, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 28px 36px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 36px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .trust-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 18px;
            flex-shrink: 0;
        }

        .trust-title {
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .trust-sub {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.4;
        }

        /* ── Light Mode Adjustments ── */
        [data-theme="light"] .pricing-card {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        [data-theme="light"] .pricing-card.is-popular {
            background: #f8fafc;
            border-color: #2563eb;
            box-shadow: 0 16px 40px rgba(37, 99, 235, 0.12);
        }
        [data-theme="light"] .plan-name {
            color: #0f172a;
        }
        [data-theme="light"] .plan-amount {
            color: #0f172a;
        }
        [data-theme="light"] .sub-hero-title {
            color: #0f172a;
        }
        [data-theme="light"] .plan-features li {
            color: #475569;
        }
        [data-theme="light"] .plan-features li strong {
            color: #0f172a;
        }
        [data-theme="light"] .btn-purchase {
            background: #f1f5f9;
            border-color: rgba(0, 0, 0, 0.1);
            color: #0f172a;
        }
        [data-theme="light"] .btn-purchase:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        [data-theme="light"] .pricing-card.is-current {
            background: #f0fdf4 !important;
            border-color: #86efac !important;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1) !important;
        }
        [data-theme="light"] .btn-purchase.is-current-plan,
        [data-theme="light"] .btn-purchase.is-current-plan:disabled {
            background: #dcfce7 !important;
            border-color: #86efac !important;
            color: #047857 !important;
        }
        [data-theme="light"] .sub-trust-bar {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.08);
        }
        [data-theme="light"] .trust-title {
            color: #0f172a;
        }
        [data-theme="light"] .collaborator-billing-banner {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        [data-theme="light"] .collab-banner-text h4 {
            color: #0f172a;
        }
        [data-theme="light"] .collab-banner-text p {
            color: #475569;
        }
        [data-theme="light"] .plan-req-modal {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.12);
        }
        [data-theme="light"] .plan-req-modal-header h3 {
            color: #0f172a;
        }
        [data-theme="light"] .plan-req-plan-summary {
            background: #f8fafc;
            border-color: #e2e8f0;
        }
        [data-theme="light"] .plan-req-textarea {
            background: #ffffff;
            border-color: #cbd5e1;
            color: #0f172a;
        }
        [data-theme="light"] .plan-req-chip {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #334155;
        }

        @media (max-width: 768px) {
            .sub-hero-title {
                font-size: 26px;
            }
            .pricing-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .pricing-card.is-popular {
                transform: none;
            }
            .pricing-card.is-popular:hover {
                transform: translateY(-4px);
            }
            .sub-trust-bar {
                grid-template-columns: 1fr;
                padding: 20px;
            }
        }
    </style>
@endsection

@section('content')
<div class="subscription-container">

    <!-- Flash Alert Notice -->
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #fca5a5; font-size: 14px; font-weight: 600;">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 18px; color: #ef4444;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if(session('status'))
        <div style="background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.4); border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #93c5fd; font-size: 14px; font-weight: 600;">
            <i class="fa-solid fa-circle-info" style="font-size: 18px; color: #3b82f6;"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <!-- Hero Header -->
    @php
        $subUser = auth()->user();
        $subCanSwitchToDemo = $subUser && !$subUser->hasActiveSubscription() && !$subUser->demo_used && !$subUser->is_demo_mode;
        $subDemoDays = (int) \App\DemoSetting::get('demo_duration_days', 60);
    @endphp

    @if($subCanSwitchToDemo)
        <div style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.14), rgba(29, 78, 216, 0.08)); border: 1px solid rgba(59, 130, 246, 0.35); border-radius: 16px; padding: 18px 24px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 20px rgba(37, 99, 235, 0.15);">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.4); display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 19px; flex-shrink: 0;">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <div>
                    <h4 style="font-size: 15px; font-weight: 700; color: #ffffff; margin: 0 0 3px;">
                        Not ready to subscribe yet? You have a {{ $subDemoDays }}-Day Free Demo available!
                    </h4>
                    <p style="font-size: 13px; color: #cbd5e1; margin: 0;">
                        You chose payment earlier, but you can switch your account to the free demo package anytime to enjoy full platform access for {{ $subDemoDays }} days.
                    </p>
                </div>
            </div>
            <a href="{{ route('register.choose-plan') }}" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #ffffff; font-size: 13px; font-weight: 700; padding: 10px 20px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4); transition: transform 0.2s ease;">
                <i class="fa-solid fa-rocket" style="font-size: 12px;"></i>
                <span>Switch to Demo Package</span>
            </a>
        </div>
    @endif

    <div class="sub-header-hero">
        <div class="sub-pill-badge">
            <i class="fa-solid fa-gem"></i> Premium Access Plans
        </div>
        <h1 class="sub-hero-title">
            Unlock Full <span>Legal Research</span> Power
        </h1>
        <p class="sub-hero-desc">
            Gain immediate, complete access to our extensive database of 4th Republic Laws, Supreme Court judgments, official preambles, and PDF downloads.
        </p>
    </div>

    <!-- Active Subscription Alert (If User Is Already Subscribed) -->
    @if(auth()->user()->check_subscription && auth()->user()->subscription_expiry && \Carbon\Carbon::parse(auth()->user()->subscription_expiry)->isFuture())
        @php
            $currentPlan = \App\Subscription::find(auth()->user()->subscription_id);
            $expiryDate = \Carbon\Carbon::parse(auth()->user()->subscription_expiry);
            $daysLeft = (int) ceil(now()->diffInDays($expiryDate, false));
        @endphp
        <div class="current-plan-card">
            <div class="current-plan-left">
                <div class="current-plan-icon">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div class="current-plan-info">
                    <h4>Active Subscription: {{ $currentPlan->type ?? 'Premium Member' }}</h4>
                    <p>
                        Valid until <strong>{{ $expiryDate->format('M d, Y') }}</strong> ({{ $daysLeft }} {{ $daysLeft === 1 ? 'day' : 'days' }} remaining) &bull;
                        Downloads: <strong>{{ auth()->user()->downloads_counts ?? 0 }} / {{ auth()->user()->subscription_downloads ?? 'Unlimited' }} used</strong>
                    </p>
                </div>
            </div>
            <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); padding: 6px 14px; border-radius: 100px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-circle-check"></i> Plan Active
            </span>
        </div>
    @endif

    @php
        $currentUser = auth()->user();
        $isCollaborator = $currentUser && $currentUser->isTeamMember();
        $membership = $isCollaborator ? $currentUser->teamMembership : null;
        $teamOwner = $isCollaborator ? $currentUser->getTeamOwner() : null;
        $teamOwnerName = $teamOwner ? trim($teamOwner->name . ' ' . $teamOwner->lname) : 'Account Holder';
        $canManageBilling = $currentUser ? $currentUser->canManageTeamBilling() : true;
        $pendingRequestedPlanId = ($membership && $membership->billing_request_status === 'pending') ? (int)$membership->billing_request_plan_id : null;
        $pendingRequestedPlan = $pendingRequestedPlanId ? \App\Subscription::find($pendingRequestedPlanId) : null;
    @endphp

    @if($isCollaborator)
        @if($canManageBilling)
            <div class="collaborator-billing-banner" style="border-color: rgba(16, 185, 129, 0.4); background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(6, 78, 59, 0.15) 100%);">
                <div class="collab-banner-info">
                    <div class="collab-banner-icon" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4); color: #34d399;">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <div class="collab-banner-text">
                        <h4>Billing Authorized &bull; {{ $teamOwnerName }}'s Workspace</h4>
                        <p>You have been granted billing permission by the Account Holder. You can upgrade, downgrade, or renew the workspace subscription directly.</p>
                    </div>
                </div>
                <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); padding: 6px 14px; border-radius: 100px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-shield-check"></i> Billing Permitted
                </span>
            </div>
        @else
            <div class="collaborator-billing-banner">
                <div class="collab-banner-info">
                    <div class="collab-banner-icon">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="collab-banner-text">
                        <h4>Collaborator Access &bull; {{ $teamOwnerName }}'s Workspace</h4>
                        <p>
                            Direct plan upgrades are managed by the primary Account Holder (<strong>{{ $teamOwnerName }}</strong>). Need more team seats or higher limits? You can submit a 1-click plan change request below.
                        </p>
                        @if($pendingRequestedPlan)
                            <div style="margin-top: 6px; font-size: 12px; color: #fbbf24; display: flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-hourglass-half"></i>
                                <span>Pending Request: <strong>{{ $pendingRequestedPlan->type }} Plan</strong> (sent {{ \Carbon\Carbon::parse($membership->billing_requested_at)->diffForHumans() }})</span>
                            </div>
                        @endif
                    </div>
                </div>
                <span style="background: rgba(124, 58, 237, 0.2); color: #c084fc; border: 1px solid rgba(139, 92, 246, 0.4); padding: 6px 14px; border-radius: 100px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-lock"></i> Approval Required
                </span>
            </div>
        @endif
    @endif

    <!-- Dynamic Pricing Cards Grid -->
    <div class="pricing-grid">
        @php
            $userHasActiveSub = false;
            $userCurrentSubId = 0;
            $currentPlan = null;

            if ($currentUser) {
                if ($currentUser->check_subscription && $currentUser->subscription_expiry && \Carbon\Carbon::parse($currentUser->subscription_expiry)->isFuture()) {
                    $userHasActiveSub = true;
                    $userCurrentSubId = (int) $currentUser->subscription_id;
                    $currentPlan = \App\Subscription::find($userCurrentSubId);
                } elseif ($currentUser->teamMembership && $currentUser->teamMembership->owner && $currentUser->teamMembership->owner->hasActiveSubscription()) {
                    $userHasActiveSub = true;
                    $userCurrentSubId = (int) $currentUser->teamMembership->owner->subscription_id;
                    $currentPlan = \App\Subscription::find($userCurrentSubId);
                }
            }

            $tierRanks = [
                'starter' => 1,
                'essential' => 2,
                'premium' => 3,
                'unlimited' => 4,
            ];
        @endphp

        @foreach($subscriptions as $subscription)
            @php
                $isCurrentPlan = $userHasActiveSub && ($userCurrentSubId === (int)$subscription->id);
                $isPopular = (bool) $subscription->is_popular;
                $hasBadge = !empty($subscription->badge);
                $badgeText = $hasBadge ? $subscription->badge : ($isPopular ? 'Most Popular' : null);
                $currency = $subscription->currency ?? 'GHS';
                $durationLabel = $subscription->display_duration;
                $highlightText = $subscription->display_highlight;

                $isDowngrade = false;
                $isUpgrade = false;

                if ($isCurrentPlan) {
                    $btnText = 'Current Active Plan';
                } elseif ($userHasActiveSub && $currentPlan) {
                    $subKey = strtolower(trim($subscription->type));
                    $curKey = strtolower(trim($currentPlan->type));

                    if (isset($tierRanks[$subKey]) && isset($tierRanks[$curKey])) {
                        $isLower = $tierRanks[$subKey] < $tierRanks[$curKey];
                    } else {
                        if ((float)$subscription->price != (float)$currentPlan->price) {
                            $isLower = (float)$subscription->price < (float)$currentPlan->price;
                        } elseif ((int)$subscription->max_users != (int)$currentPlan->max_users) {
                            $isLower = (int)$subscription->max_users < (int)$currentPlan->max_users;
                        } else {
                            $isLower = (int)$subscription->duration < (int)$currentPlan->duration;
                        }
                    }

                    if ($isLower) {
                        $isDowngrade = true;
                        $btnText = 'Downgrade to ' . $subscription->type;
                    } else {
                        $isUpgrade = true;
                        $btnText = 'Upgrade to ' . $subscription->type;
                    }
                } else {
                    $btnText = $subscription->display_button_text;
                }

                $features = $subscription->feature_list;
            @endphp

            <div class="pricing-card {{ $isCurrentPlan ? 'is-current' : ($isPopular ? 'is-popular' : '') }}">
                @if($isCurrentPlan)
                    <div class="popular-badge-wrapper">
                        <span class="popular-badge badge-current-plan">
                            <i class="fa-solid fa-circle-check"></i> Current Active Plan
                        </span>
                    </div>
                @elseif($badgeText)
                    <div class="popular-badge-wrapper">
                        <span class="popular-badge">
                            <i class="fa-solid fa-star"></i> {{ $badgeText }}
                        </span>
                    </div>
                @endif

                <div class="pricing-header">
                    <div class="plan-name">{{ $subscription->type }}</div>
                    <div style="margin-top: 6px; margin-bottom: 6px;">
                        @if((int)($subscription->max_users ?: 1) === 1)
                            <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(148, 163, 184, 0.12); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.25); padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600;">
                                <i class="fa-solid fa-user" style="font-size: 10px;"></i> Strictly 1 User Account
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(59, 130, 246, 0.15); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.35); padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 700;">
                                <i class="fa-solid fa-users" style="font-size: 10px; color: #60a5fa;"></i> {{ $subscription->max_users }} Team Users & Collaboration
                            </span>
                        @endif
                    </div>
                    
                    <div class="plan-price-wrap">
                        <span class="plan-currency">{{ $currency }}</span>
                        <span class="plan-amount">{{ number_format($subscription->price, 0) }}</span>
                    </div>
                    <span class="plan-duration">{{ $durationLabel }}</span>
                </div>

                <!-- Highlight Box -->
                <div class="feature-highlight-box">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    <span>{{ $highlightText }}</span>
                </div>

                <!-- Feature Bullet Points -->
                <ul class="plan-features">
                    @foreach($features as $feature)
                        <li>
                            <i class="fa-solid fa-circle-check icon-check"></i>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                @if($isCurrentPlan)
                    <button type="button" class="btn-purchase is-current-plan" disabled title="This plan is currently active on your account.">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Current Active Plan</span>
                    </button>
                @elseif($subscription->is_button_disabled)
                    <button type="button" class="btn-purchase is-disabled" disabled title="Subscription checkout for this tier is temporarily paused by administration.">
                        <i class="fa-solid fa-lock" style="font-size: 13px; opacity: 0.7;"></i>
                        <span>{{ $btnText }}</span>
                    </button>
                @elseif($isCollaborator && !$canManageBilling)
                    @if($pendingRequestedPlanId === (int)$subscription->id)
                        <button type="button" class="btn-purchase btn-pending-request" onclick="openRequestPlanModal({{ $subscription->id }}, '{{ addslashes($subscription->type) }}', '{{ number_format($subscription->price, 0) }}', '{{ addslashes($currency) }}', '{{ addslashes($durationLabel) }}', true, '{{ addslashes($membership->billing_request_note ?? '') }}')" title="Your upgrade request for this plan is currently under review by {{ $teamOwnerName }}">
                            <i class="fa-solid fa-hourglass-half"></i>
                            <span>Request Pending Approval</span>
                        </button>
                    @else
                        <button type="button" class="btn-purchase btn-request-plan" onclick="openRequestPlanModal({{ $subscription->id }}, '{{ addslashes($subscription->type) }}', '{{ number_format($subscription->price, 0) }}', '{{ addslashes($currency) }}', '{{ addslashes($durationLabel) }}', false, '')" title="Send a formal plan change request to {{ $teamOwnerName }}">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Request {{ $isDowngrade ? 'Change' : 'Upgrade' }}</span>
                        </button>
                    @endif
                @else
                    <button type="button" class="btn-purchase {{ $isUpgrade ? 'btn-upgrade' : ($isDowngrade ? 'btn-downgrade' : ($userHasActiveSub ? 'btn-upgrade' : '')) }}" onclick="makePayment({{ $subscription->id }}, {{ $subscription->price }}, '{{ addslashes($subscription->type) }}', '{{ addslashes($currency) }}')">
                        <span>{{ $btnText }}</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Trust / Assurance Row -->
    <div class="sub-trust-bar">
        <div class="trust-item">
            <div class="trust-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <div class="trust-title">Secure Checkout</div>
                <div class="trust-sub">256-bit encrypted Flutterwave gateway</div>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div>
                <div class="trust-title">Instant Activation</div>
                <div class="trust-sub">Full access granted immediately upon payment</div>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">
                <i class="fa-solid fa-mobile-screen"></i>
            </div>
            <div>
                <div class="trust-title">Mobile Money & Cards</div>
                <div class="trust-sub">Pay via MTN MoMo, Telecel Cash, or Visa / Mastercard</div>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-icon">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <div class="trust-title">Dedicated Support</div>
                <div class="trust-sub">Direct legal assistance for subscribers</div>
            </div>
        </div>
    </div>

    <!-- Plan Request Modal (Collaborators) -->
    <div id="requestPlanModalBackdrop" class="plan-req-modal-backdrop">
        <div class="plan-req-modal">
            <div class="plan-req-modal-header">
                <h3>
                    <i class="fa-solid fa-paper-plane" style="color: #a78bfa;"></i>
                    <span>Request Subscription Upgrade</span>
                </h3>
                <button type="button" class="plan-req-close-btn" onclick="closeRequestPlanModal()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="plan-req-modal-body">
                <div class="plan-req-plan-summary">
                    <div>
                        <div style="font-size: 16px; font-weight: 800; color: #ffffff;" id="reqModalPlanName">Plan Name</div>
                        <div style="font-size: 12px; color: #94a3b8;" id="reqModalDuration">Duration</div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 18px; font-weight: 800; color: #60a5fa;" id="reqModalPrice">GHS 0</div>
                        <span style="font-size: 11px; background: rgba(59, 130, 246, 0.15); color: #93c5fd; padding: 2px 7px; border-radius: 4px; font-weight: 600;">Workspace Tier</span>
                    </div>
                </div>

                <div id="reqModalPendingNotice" style="display: none; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.35); border-radius: 10px; padding: 10px 14px; margin-bottom: 16px; font-size: 12.5px; color: #fde68a;">
                    <i class="fa-solid fa-clock-rotate-left" style="color: #fbbf24; margin-right: 6px;"></i>
                    You currently have an active request for this plan awaiting Account Holder review. Submitting below will update your request note.
                </div>

                <div style="background: rgba(139, 92, 246, 0.08); border: 1px solid rgba(139, 92, 246, 0.22); border-radius: 10px; padding: 12px 14px; margin-bottom: 16px; font-size: 12.5px; color: #cbd5e1; line-height: 1.5;">
                    <i class="fa-solid fa-shield-halved" style="color: #a78bfa; margin-right: 6px;"></i>
                    This request will notify your Account Holder (<strong>{{ $teamOwnerName }}</strong>). They can grant you billing access or complete the upgrade directly from their Team Workspace dashboard.
                </div>

                <label style="display: block; font-size: 13px; font-weight: 700; color: #ffffff; margin-bottom: 8px;">
                    Reason or Note for {{ $teamOwnerName }} <span style="font-weight: 400; color: #94a3b8;">(optional)</span>:
                </label>

                <!-- Quick reason chips -->
                <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px;">
                    <span class="plan-req-chip" onclick="setQuickChip('Need more team seats for our researchers.')">+ Team seats</span>
                    <span class="plan-req-chip" onclick="setQuickChip('Need higher download limits for upcoming court trials.')">+ Download limits</span>
                    <span class="plan-req-chip" onclick="setQuickChip('Annual renewal for continuous research access.')">+ Annual renewal</span>
                </div>

                <textarea id="reqModalNote" class="plan-req-textarea" placeholder="e.g., Hi {{ $teamOwnerName }}, we need to upgrade so our new trial associates can access supreme court judgments..."></textarea>

                <div id="reqModalFeedback" style="display: none; margin-top: 10px; font-size: 13px; font-weight: 600;"></div>
            </div>
            <div class="plan-req-modal-footer">
                <button type="button" class="plan-req-close-btn" style="width: auto; padding: 8px 16px; font-size: 13px; font-weight: 600; border-radius: 10px;" onclick="closeRequestPlanModal()">
                    Cancel
                </button>
                <button type="button" id="reqModalSubmitBtn" onclick="submitPlanRequest()" style="background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%); border: 1px solid rgba(167, 139, 250, 0.4); color: #fff; padding: 9px 20px; font-size: 13.5px; font-weight: 700; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.35);">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span id="reqModalSubmitBtnText">Send Request</span>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function makePayment(subscriptionId, amount, planTitle, currency) {
            currency = currency || "GHS";
            var name = '{{ addslashes(Auth::user()->name . " " . Auth::user()->lname) }}';
            var email = '{{ Auth::user()->email }}';
            var phone = '{{ Auth::user()->phone ?? "" }}';

            FlutterwaveCheckout({
                public_key: "{{ \App\PaymentSetting::getPublicKey() ?: config('services.flutterwave.public_key', 'FLWPUBK-8f9fbb57646670b5149ef0af2fd24834-X') }}",
                tx_ref: "lf-sub-" + Date.now() + "-" + Math.floor(Math.random() * 100000),
                amount: amount,
                currency: currency,
                payment_options: "card,mobilemoney,ussd",
                meta: {
                    consumer_id: "{{ Auth::user()->id }}",
                    subscription_id: subscriptionId,
                    plan: planTitle
                },
                customer: {
                    email: email,
                    phone_number: phone,
                    name: name,
                },
                callback: function (data) {
                    console.log("Payment successful callback:", data);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Activate the user subscription in the backend
                    $.ajax({
                        url: "/process/" + subscriptionId,
                        type: 'GET',
                        success: function(response){
                            alert('Congratulations! Your ' + planTitle + ' plan has been activated successfully.');
                            window.location.href = "/home";
                        },
                        error: function(xhr){
                            var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Payment succeeded but we encountered an issue activating your plan. Please reach out to support.';
                            alert(msg);
                            window.location.reload();
                        }
                    });
                },
                customizations: {
                    title: "Legals Forum Subscription",
                    description: "Payment for " + planTitle + " Subscription Plan",
                },
            });
        }

        let currentPlanIdForRequest = null;

        function openRequestPlanModal(planId, planName, planPrice, currency, duration, isPending, currentNote) {
            currentPlanIdForRequest = planId;
            $('#reqModalPlanName').text(planName + ' Plan');
            $('#reqModalPrice').text(currency + ' ' + planPrice);
            $('#reqModalDuration').text('Billing Cycle: ' + duration);
            $('#reqModalNote').val(currentNote || '');
            
            if (isPending) {
                $('#reqModalPendingNotice').show();
                $('#reqModalSubmitBtnText').text('Update Request Note');
            } else {
                $('#reqModalPendingNotice').hide();
                $('#reqModalSubmitBtnText').text('Send Request to {{ addslashes($teamOwnerName ?? "Account Holder") }}');
            }
            
            $('#reqModalFeedback').hide().text('');
            $('#requestPlanModalBackdrop').css('display', 'flex').hide().fadeIn(180);
        }

        function closeRequestPlanModal() {
            $('#requestPlanModalBackdrop').fadeOut(120);
        }

        function setQuickChip(text) {
            var cur = $('#reqModalNote').val().trim();
            if (cur.length > 0) {
                $('#reqModalNote').val(cur + ' ' + text);
            } else {
                $('#reqModalNote').val(text);
            }
            $('#reqModalNote').focus();
        }

        function submitPlanRequest() {
            if (!currentPlanIdForRequest) return;
            
            var note = $('#reqModalNote').val().trim();
            var btn = $('#reqModalSubmitBtn');
            var originalHtml = btn.html();
            
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Submitting...');
            $('#reqModalFeedback').hide();

            $.ajax({
                url: "{{ route('team.billing.request') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    plan_id: currentPlanIdForRequest,
                    note: note
                },
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    if (response.success) {
                        alert(response.message || 'Request successfully sent to your Account Holder!');
                        closeRequestPlanModal();
                        window.location.reload();
                    } else {
                        $('#reqModalFeedback').css('color', '#ef4444').text(response.message || 'Failed to submit request.').fadeIn();
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html(originalHtml);
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'An error occurred while submitting your request.';
                    $('#reqModalFeedback').css('color', '#ef4444').text(msg).fadeIn();
                }
            });
        }

        $(document).on('click', '#requestPlanModalBackdrop', function(e) {
            if (e.target === this) {
                closeRequestPlanModal();
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRequestPlanModal();
            }
        });
    </script>
@endsection
