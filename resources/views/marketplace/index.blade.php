@extends('layouts.forum_portal')

@section('title', 'Legal Marketplace - Legals Forum')

@section('content')
<div style="max-width: 1100px; margin: 0 auto; text-align: center; padding: 40px 16px;">

    <!-- Badge -->
    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 6px 16px; border-radius: 100px; font-size: 13px; font-weight: 700; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.5px;">
        <i class="fa-solid fa-store"></i> Legal Ecommerce Ecosystem • In Development
    </div>

    <h1 style="font-size: 2.8rem; font-weight: 900; font-family: var(--font-heading); color: #fff; margin-bottom: 16px; letter-spacing: -1px; line-height: 1.2;">
        Legals Forum <span style="background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Marketplace</span>
    </h1>

    <p style="color: var(--text-secondary); font-size: 17px; max-width: 720px; margin: 0 auto 48px auto; line-height: 1.6;">
        A specialized digital and physical marketplace built for Ghana’s legal fraternity. Buy, sell, and access verified precedents, legal literature, academic materials, and courtroom essentials.
    </p>

    <!-- Upcoming Categories Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; text-align: left; margin-bottom: 56px;">
        <!-- Card 1 -->
        <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 28px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 18px;">
                <i class="fa-solid fa-file-contract"></i>
            </div>
            <h3 style="font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 8px;">Precedent & Contract Templates</h3>
            <p style="color: var(--text-secondary); font-size: 13.5px; line-height: 1.5; margin: 0;">Vetted legal agreements, conveyancing drafts, commercial contracts, and litigation pleadings.</p>
        </div>

        <!-- Card 2 -->
        <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 28px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(245, 158, 11, 0.15); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 18px;">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <h3 style="font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 8px;">Law Books & Literature</h3>
            <p style="color: var(--text-secondary); font-size: 13.5px; line-height: 1.5; margin: 0;">Ghana Law Reports, legal treaties, constitutional treatises, and student study companions.</p>
        </div>

        <!-- Card 3 -->
        <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 28px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(139, 92, 246, 0.15); color: #a78bfa; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 18px;">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h3 style="font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 8px;">Student & Academic Materials</h3>
            <p style="color: var(--text-secondary); font-size: 13.5px; line-height: 1.5; margin: 0;">Bar exam study summaries, lecture notes, moot court aids, and past examination papers.</p>
        </div>

        <!-- Card 4 -->
        <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 28px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 18px;">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <h3 style="font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 8px;">Court Regalia & Tools</h3>
            <p style="color: var(--text-secondary); font-size: 13.5px; line-height: 1.5; margin: 0;">Barrister gowns, collarettes, court bibs, legal seals, and legal office productivity tools.</p>
        </div>
    </div>

    <!-- Back to Hub -->
    <a href="/" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.08); color: #fff; padding: 12px 28px; border-radius: 100px; font-weight: 600; font-size: 14px; text-decoration: none;">
        <i class="fa-solid fa-house"></i> Return to Homepage
    </a>

</div>
@endsection
