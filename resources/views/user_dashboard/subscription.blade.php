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
        [data-theme="light"] .sub-trust-bar {
            background: #ffffff;
            border-color: rgba(0, 0, 0, 0.08);
        }
        [data-theme="light"] .trust-title {
            color: #0f172a;
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

    <!-- Dynamic Pricing Cards Grid -->
    <div class="pricing-grid">
        @foreach($subscriptions as $subscription)
            @php
                $isPopular = (bool) $subscription->is_popular;
                $hasBadge = !empty($subscription->badge);
                $badgeText = $hasBadge ? $subscription->badge : ($isPopular ? 'Most Popular' : null);
                
                // Human readable duration
                $durationDays = (int) $subscription->duration;
                $durationLabel = 'per ' . $durationDays . ' days';
                if ($durationDays >= 365) {
                    $durationLabel = 'per year';
                } elseif ($durationDays >= 180) {
                    $durationLabel = 'for 6 months';
                } elseif ($durationDays >= 90) {
                    $durationLabel = 'for 3 months';
                } elseif ($durationDays >= 30) {
                    $durationLabel = 'per month';
                }
            @endphp

            <div class="pricing-card {{ $isPopular ? 'is-popular' : '' }}">
                @if($badgeText)
                    <div class="popular-badge-wrapper">
                        <span class="popular-badge">
                            <i class="fa-solid fa-star"></i> {{ $badgeText }}
                        </span>
                    </div>
                @endif

                <div class="pricing-header">
                    <div class="plan-name">{{ $subscription->type }}</div>
                    
                    <div class="plan-price-wrap">
                        <span class="plan-currency">GHS</span>
                        <span class="plan-amount">{{ number_format($subscription->price, 0) }}</span>
                    </div>
                    <span class="plan-duration">{{ $durationLabel }}</span>
                </div>

                <!-- Highlight Box -->
                <div class="feature-highlight-box">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    <span>
                        @if($subscription->no_downloads >= 10000)
                            <strong>Unlimited</strong> document downloads
                        @else
                            Up to <strong>{{ number_format($subscription->no_downloads) }}</strong> document downloads
                        @endif
                    </span>
                </div>

                <!-- Feature Bullet Points -->
                <ul class="plan-features">
                    @if(!empty($subscription->general_notes))
                        <li>
                            <i class="fa-solid fa-circle-check icon-check"></i>
                            <span>{{ $subscription->general_notes }}</span>
                        </li>
                    @endif

                    @if(!empty($subscription->specific_notes))
                        <li>
                            <i class="fa-solid fa-circle-check icon-check"></i>
                            <span>{{ $subscription->specific_notes }}</span>
                        </li>
                    @endif

                    <li>
                        <i class="fa-solid fa-circle-check icon-check"></i>
                        <span>High-Speed Official PDF Document Downloads</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check icon-check"></i>
                        <span>Search Filter & Section Bookmarking</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check icon-check"></i>
                        <span>Personal Document Notes & Annotations</span>
                    </li>
                </ul>

                @if($subscription->is_button_disabled)
                    <button type="button" class="btn-purchase is-disabled" disabled title="Subscription checkout for this tier is temporarily paused by administration.">
                        <i class="fa-solid fa-lock" style="font-size: 13px; opacity: 0.7;"></i>
                        <span>Subscribe Now</span>
                    </button>
                @else
                    <button type="button" class="btn-purchase" onclick="makePayment({{ $subscription->id }}, {{ $subscription->price }}, '{{ addslashes($subscription->type) }}')">
                        <span>Subscribe Now</span>
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

</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function makePayment(subscriptionId, amount, planTitle) {
            var name = '{{ addslashes(Auth::user()->name . " " . Auth::user()->lname) }}';
            var email = '{{ Auth::user()->email }}';
            var phone = '{{ Auth::user()->phone ?? "" }}';

            FlutterwaveCheckout({
                public_key: "FLWPUBK-8f9fbb57646670b5149ef0af2fd24834-X",
                tx_ref: "lf-sub-" + Date.now() + "-" + Math.floor(Math.random() * 100000),
                amount: amount,
                currency: "GHS",
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
                            window.location.href = "/home";
                            alert('Congratulations! Your ' + planTitle + ' plan has been activated successfully.');
                        },
                        error: function(){
                            alert('Payment succeeded but we encountered an issue activating your plan. Please reach out to support.');
                        }
                    });
                },
                customizations: {
                    title: "Legals Forum Subscription",
                    description: "Payment for " + planTitle + " Subscription Plan",
                },
            });
        }
    </script>
@endsection
