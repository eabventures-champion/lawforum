@extends('extenders.news-main')

@section('title', ucwords(str_replace('-', ' ', $newscategory['name'])))

@section('meta_description', 'Latest legal, statutory, and judicial news in ' . str_replace('-', ' ', $newscategory['name']) . ' from Legals Forum.')

@section('assets')
<style>
    /* Category Page Header */
    .cat-hero-header {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 16px;
    }

    .cat-breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-muted);
        margin-bottom: 10px;
    }

    .cat-breadcrumbs a:hover {
        color: var(--accent-light);
    }

    .cat-page-title {
        font-size: clamp(26px, 3.5vw, 36px);
        font-weight: 800;
        letter-spacing: -0.8px;
        color: #fff;
        line-height: 1.2;
    }

    .cat-page-desc {
        color: var(--text-secondary);
        font-size: 14.5px;
        margin-top: 6px;
        max-width: 680px;
    }

    /* Hero Showcase Grid */
    .news-showcase-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 28px;
        margin-bottom: 48px;
    }

    /* Lead Story Card */
    .lead-story-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        position: relative;
    }

    .lead-story-card:hover {
        border-color: var(--border-hover);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .lead-media-wrap {
        position: relative;
        width: 100%;
        height: 320px;
        overflow: hidden;
        background: #090e1a;
    }

    .lead-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .lead-story-card:hover .lead-thumb {
        transform: scale(1.04);
    }

    .lead-category-pill {
        position: absolute;
        top: 18px;
        left: 18px;
        background: rgba(6, 10, 19, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(244, 63, 94, 0.4);
        color: var(--rose-light);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 5px 12px;
        border-radius: 6px;
        z-index: 2;
    }

    .lead-content {
        padding: 28px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .lead-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px 12px;
        font-size: 12.5px;
        color: var(--text-muted);
        margin-bottom: 14px;
    }

    .lead-meta-left {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
    }

    .lead-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .lead-meta-sep {
        color: rgba(255, 255, 255, 0.25);
        font-size: 9px;
        user-select: none;
    }

    .lead-meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        color: var(--rose-light);
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        background: rgba(244, 63, 94, 0.12);
        border: 1px solid rgba(244, 63, 94, 0.3);
        padding: 2px 8px;
        border-radius: 6px;
    }

    .lead-title {
        font-size: clamp(20px, 2.2vw, 26px);
        font-weight: 800;
        line-height: 1.35;
        letter-spacing: -0.5px;
        color: #fff;
        margin-bottom: 14px;
        transition: color 0.2s ease;
    }

    .lead-story-card:hover .lead-title {
        color: var(--accent-light);
    }

    .lead-excerpt {
        color: var(--text-secondary);
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 24px;
        flex: 1;
    }

    .lead-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--accent-light);
        transition: gap 0.2s ease;
    }

    .lead-story-card:hover .lead-cta {
        gap: 12px;
    }

    /* Side Highlights Column */
    .highlights-column {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .highlights-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    .highlights-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .highlight-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 16px;
        display: flex;
        gap: 16px;
        transition: all 0.25s ease;
        position: relative;
    }

    .highlight-card:hover {
        border-color: var(--border-hover);
        background: var(--card-bg-hover);
        transform: translateY(-2px);
    }

    .highlight-rank {
        font-size: 20px;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.15);
        line-height: 1;
        width: 24px;
        flex-shrink: 0;
    }

    .highlight-card:hover .highlight-rank {
        color: var(--rose-light);
    }

    .highlight-thumb-box {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        background: #0d1525;
        position: relative;
    }

    .highlight-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .highlight-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .highlight-meta {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .highlight-title {
        font-size: 14px;
        font-weight: 700;
        line-height: 1.4;
        color: var(--text-primary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }

    .highlight-card:hover .highlight-title {
        color: var(--accent-light);
    }

    /* Fallback image boxes */
    .card-img-fallback {
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 30% 30%, #1e293b 0%, #0f172a 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
    }

    .card-img-fallback .fallback-icon {
        font-size: 32px;
        color: rgba(59, 130, 246, 0.4);
    }

    .card-img-fallback .fallback-cat {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    /* Main Two-Column Layout */
    .news-content-layout {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 36px;
    }

    .feed-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-color);
        flex-wrap: wrap;
        gap: 12px;
    }

    .feed-header-title-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .feed-section-header h2 {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        margin: 0;
        line-height: 1.3;
    }

    .feed-title-icon {
        color: var(--rose);
        font-size: 16px;
        flex-shrink: 0;
    }

    .feed-count-badge {
        font-size: 12.5px;
        color: var(--text-muted);
        white-space: nowrap;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* News Grid Feed */
    .news-grid-feed {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .news-feed-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    .news-feed-card:hover {
        border-color: var(--border-hover);
        transform: translateY(-4px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.35);
    }

    .card-image-link {
        position: relative;
        width: 100%;
        height: 190px;
        display: block;
        overflow: hidden;
        background: #090e1a;
    }

    .feed-card-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .news-feed-card:hover .feed-card-thumb {
        transform: scale(1.05);
    }

    .card-badge-pill {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(6, 10, 19, 0.85);
        backdrop-filter: blur(6px);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.12);
        font-size: 10.5px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 4px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .card-body-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-meta-line {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 10px;
    }

    .card-headline {
        font-size: 16.5px;
        font-weight: 700;
        line-height: 1.45;
        margin-bottom: 10px;
        color: #fff;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-headline a:hover {
        color: var(--accent-light);
    }

    .card-excerpt {
        font-size: 13.5px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 18px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer-cta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px solid var(--border-color);
    }

    .read-more-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--accent-light);
        transition: gap 0.2s ease;
    }

    .read-more-link:hover {
        gap: 10px;
        color: #fff;
    }

    /* Sidebar Styles */
    .news-sidebar {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .sidebar-widget {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        padding: 24px;
    }

    .widget-title {
        font-size: 15px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .widget-title i {
        color: var(--accent-light);
    }

    .category-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .category-item a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-secondary);
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .category-item a:hover, .category-item.active a {
        background: rgba(244, 63, 94, 0.1);
        border-color: rgba(244, 63, 94, 0.25);
        color: #fff;
    }

    .cat-item-badge {
        font-size: 11px;
        background: rgba(255, 255, 255, 0.06);
        color: var(--text-muted);
        padding: 2px 8px;
        border-radius: 12px;
    }

    .category-item.active .cat-item-badge {
        background: rgba(244, 63, 94, 0.25);
        color: #fecdd3;
    }

    /* Trending List in Sidebar */
    .trending-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .trending-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .trending-num {
        font-size: 18px;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.15);
        line-height: 1.2;
        width: 20px;
    }

    .trending-title {
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
        color: var(--text-primary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .trending-title:hover {
        color: var(--accent-light);
    }

    .trending-time {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* Newsletter Card */
    .newsletter-widget {
        background: linear-gradient(145deg, rgba(30, 58, 138, 0.25) 0%, rgba(15, 23, 42, 0.6) 100%);
        border-color: rgba(59, 130, 246, 0.3);
    }

    .nl-input {
        width: 100%;
        height: 40px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0 12px;
        font-size: 13px;
        color: #fff;
        margin-bottom: 10px;
        outline: none;
        font-family: inherit;
    }

    .nl-input:focus {
        border-color: var(--accent);
    }

    .nl-btn {
        width: 100%;
        height: 40px;
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.2s ease;
    }

    .nl-btn:hover {
        background: #2563eb;
    }

    /* Quick Links in Sidebar */
    .resource-pills {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .resource-pill {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        transition: all 0.2s ease;
    }

    .resource-pill:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
        color: #fff;
        transform: translateX(3px);
    }

    /* Pagination */
    .news-pagination-wrapper {
        margin-top: 36px;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .news-pagination-wrapper .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0;
        margin: 0;
    }

    .news-pagination-wrapper .page-item .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-secondary);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .news-pagination-wrapper .page-item.active .page-link {
        background: var(--rose);
        border-color: var(--rose);
        color: #fff;
        box-shadow: 0 0 16px var(--rose-glow);
    }

    .news-pagination-wrapper .page-item.disabled .page-link {
        opacity: 0.35;
        cursor: not-allowed;
        background: rgba(255, 255, 255, 0.02);
        border-color: rgba(255, 255, 255, 0.05);
        color: var(--text-muted);
    }

    .news-pagination-wrapper .page-item a.page-link:hover {
        border-color: var(--border-hover);
        color: #fff;
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-1px);
    }

    .news-pagination-wrapper svg {
        width: 14px !important;
        height: 14px !important;
        max-width: 14px !important;
        max-height: 14px !important;
    }

    /* Empty state */
    .news-empty-state {
        text-align: center;
        padding: 60px 24px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
    }

    .empty-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: var(--text-muted);
        margin-bottom: 16px;
    }

    @media (max-width: 1024px) {
        .news-showcase-grid { grid-template-columns: 1fr; }
        .news-content-layout { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .news-grid-feed { grid-template-columns: 1fr; }
        .lead-media-wrap { height: 210px; }
        .lead-content { padding: 18px 16px; }
        .lead-meta {
            gap: 6px 10px;
            font-size: 11.5px;
            margin-bottom: 12px;
        }
        .lead-meta-left {
            gap: 6px;
        }
        .lead-meta-badge {
            font-size: 10.5px;
            padding: 2px 7px;
        }
        .highlight-card { padding: 12px; gap: 12px; }
        .highlight-thumb-box { width: 70px; height: 70px; }
        .sidebar-widget { padding: 18px 14px; }
        .cat-hero-header { margin-bottom: 20px; padding-bottom: 16px; }
        .feed-section-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
            margin-bottom: 18px !important;
            padding-bottom: 12px !important;
        }
        .feed-header-title-group {
            width: 100% !important;
            align-items: flex-start !important;
            gap: 8px !important;
        }
        .feed-title-icon {
            margin-top: 2px !important;
            font-size: 14px !important;
        }
        .feed-section-header h2 {
            font-size: 16px !important;
            line-height: 1.35 !important;
        }
        .feed-count-badge {
            font-size: 11px !important;
            padding: 2px 9px !important;
        }
    }
</style>
@endsection

@section('content')

    <!-- Category Title & Intro Banner -->
    <div class="cat-hero-header">
        <div>
            <div class="cat-breadcrumbs">
                <a href="/"><i class="fa-solid fa-house"></i> Home</a>
                <span>/</span>
                <a href="/News/Ghana-News/1">Newsroom</a>
                <span>/</span>
                <span style="color: var(--text-primary);">{{ str_replace('-', ' ', $newscategory['name']) }}</span>
            </div>
            <h1 class="cat-page-title">{{ str_replace('-', ' ', $newscategory['name']) }}</h1>
            <p class="cat-page-desc">
                Accredited legal reporting, judicial pronouncements, parliamentary updates, and business regulations in {{ str_replace('-News', '', str_replace('-', ' ', $newscategory['name'])) }}.
            </p>
        </div>

        @if(!empty($search))
        <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); padding: 8px 16px; border-radius: 8px; font-size: 13px; color: var(--accent-light); display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>Results for: <strong>"{{ $search }}"</strong></span>
            <a href="{{ url()->current() }}" style="color: #fff; margin-left: 8px;"><i class="fa-solid fa-xmark"></i></a>
        </div>
        @endif
    </div>

    <!-- Featured Showcase Section (Only if not in search mode and lead story exists) -->
    @if(empty($search) && isset($leadStory) && $leadStory)
    <section class="news-showcase-grid">
        <!-- Lead Story -->
        @php
            $leadWords = str_word_count(strip_tags($leadStory->content ?? $leadStory->extract));
            $leadReadTime = max(1, ceil($leadWords / 200));
            $leadCleanCategory = str_replace('-', ' ', $leadStory->news_category);
        @endphp
        <div class="lead-story-card">
            <div class="lead-media-wrap">
                <span class="lead-category-pill">{{ $leadCleanCategory }}</span>
                @if(!empty($leadStory->image))
                    <img src="{{ url('storage/'.$leadStory->image) }}" alt="{{ $leadStory->title }}" class="lead-thumb" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="card-img-fallback" style="display: none;">
                        <i class="fa-solid fa-scale-balanced fallback-icon" style="font-size: 48px;"></i>
                        <span class="fallback-cat">{{ $leadCleanCategory }}</span>
                    </div>
                @else
                    <div class="card-img-fallback">
                        <i class="fa-solid fa-scale-balanced fallback-icon" style="font-size: 48px;"></i>
                        <span class="fallback-cat">{{ $leadCleanCategory }}</span>
                    </div>
                @endif
            </div>

            <div class="lead-content">
                <div class="lead-meta">
                    <div class="lead-meta-left">
                        <span class="lead-meta-item"><i class="fa-regular fa-calendar"></i> {{ $leadStory->created_at ? $leadStory->created_at->format('M d, Y') : 'Recent' }}</span>
                        <span class="lead-meta-sep">&bull;</span>
                        <span class="lead-meta-item"><i class="fa-regular fa-clock"></i> {{ $leadReadTime }} min read</span>
                    </div>
                    <span class="lead-meta-badge"><i class="fa-solid fa-fire"></i> Featured Analysis</span>
                </div>

                <h2 class="lead-title">
                    <a href="/News/{{ $leadStory->news_category }}/{{ $leadStory->title }}/{{ $leadStory->id }}">
                        {{ $leadStory->title }}
                    </a>
                </h2>

                <p class="lead-excerpt">
                    {{ Str::limit(strip_tags($leadStory->extract ?: $leadStory->content), 220, '...') }}
                </p>

                <a href="/News/{{ $leadStory->news_category }}/{{ $leadStory->title }}/{{ $leadStory->id }}" class="lead-cta">
                    <span>Read Full Story</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Side Highlights Stack -->
        <div class="highlights-column">
            <div class="highlights-header">
                <h3><i class="fa-solid fa-bolt" style="color: #f59e0b;"></i> Top Highlights</h3>
                <span style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Editor's Pick</span>
            </div>

            @if(isset($topHighlights) && count($topHighlights) > 0)
                @foreach($topHighlights as $idx => $highlight)
                @php
                    $hlCleanCat = str_replace('-', ' ', $highlight->news_category);
                @endphp
                <a href="/News/{{ $highlight->news_category }}/{{ $highlight->title }}/{{ $highlight->id }}" class="highlight-card">
                    <span class="highlight-rank">0{{ $idx + 2 }}</span>
                    <div class="highlight-thumb-box">
                        @if(!empty($highlight->image))
                            <img src="{{ url('storage/'.$highlight->image) }}" alt="{{ $highlight->title }}" class="highlight-thumb" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="card-img-fallback" style="display: none; padding: 4px;">
                                <i class="fa-solid fa-newspaper" style="font-size: 16px; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        @else
                            <div class="card-img-fallback" style="padding: 4px;">
                                <i class="fa-solid fa-newspaper" style="font-size: 16px; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        @endif
                    </div>
                    <div class="highlight-info">
                        <div class="highlight-meta">
                            <span>{{ $hlCleanCat }}</span>
                            <span>&bull;</span>
                            <span>{{ $highlight->created_at ? $highlight->created_at->diffForHumans() : 'Recent' }}</span>
                        </div>
                        <h4 class="highlight-title">{{ $highlight->title }}</h4>
                    </div>
                </a>
                @endforeach
            @endif
        </div>
    </section>
    @endif

    <!-- Main Two-Column News Feed & Sidebar -->
    <div class="news-content-layout">
        <!-- Main Feed Column -->
        <section class="news-feed-column">
            <div class="feed-section-header">
                <div class="feed-header-title-group">
                    <i class="fa-solid fa-newspaper feed-title-icon"></i>
                    <h2>{{ empty($search) ? 'Latest Stories in ' . str_replace('-', ' ', $newscategory['name']) : 'Search Results' }}</h2>
                </div>
                <span class="feed-count-badge">Showing {{ $newsSelectors->total() }} articles</span>
            </div>

            <!-- AJAX Container -->
            <div id="table_data">
                @include('news.displayed_all_ghana_news')
            </div>
        </section>

        <!-- Sidebar Column -->
        <aside class="news-sidebar">
            <!-- Categories Widget -->
            @if(isset($newsCategories))
            <div class="sidebar-widget">
                <h3 class="widget-title">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Jurisdiction Categories</span>
                </h3>
                <ul class="category-list">
                    @foreach($newsCategories as $cat)
                    @php
                        $isCurrent = isset($newscategory) && ($newscategory['id'] == $cat->id || strtolower($newscategory['name']) == strtolower($cat->name));
                    @endphp
                    <li class="category-item {{ $isCurrent ? 'active' : '' }}">
                        <a href="/News/{{ $cat->name }}/{{ $cat->id }}">
                            <span><i class="fa-regular fa-folder" style="margin-right: 8px; opacity: 0.6;"></i> {{ str_replace('-', ' ', $cat->name) }}</span>
                            @if(isset($cat->articles_count))
                            <span class="cat-item-badge">{{ $cat->articles_count }}</span>
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Trending / Most Read Widget -->
            @if(isset($trendingNews) && count($trendingNews) > 0)
            <div class="sidebar-widget">
                <h3 class="widget-title">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>Trending Legal News</span>
                </h3>
                <ul class="trending-list">
                    @foreach($trendingNews as $tIdx => $tStory)
                    <li class="trending-item">
                        <span class="trending-num">{{ $tIdx + 1 }}</span>
                        <div>
                            <a href="/News/{{ $tStory->news_category }}/{{ $tStory->title }}/{{ $tStory->id }}" class="trending-title">
                                {{ $tStory->title }}
                            </a>
                            <div class="trending-time">
                                <i class="fa-regular fa-clock"></i> {{ $tStory->created_at ? $tStory->created_at->diffForHumans() : 'Recent' }}
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Newsletter Digest Widget -->
            <div class="sidebar-widget newsletter-widget">
                <h3 class="widget-title" style="border-color: rgba(59, 130, 246, 0.2);">
                    <i class="fa-solid fa-envelope-open-text" style="color: #60a5fa;"></i>
                    <span>Legal Intelligence Digest</span>
                </h3>
                <p style="color: var(--text-secondary); font-size: 13px; line-height: 1.6; margin-bottom: 16px;">
                    Receive curated briefings on key legislative developments, court rulings, and regulatory shifts weekly.
                </p>
                <form id="digestForm" onsubmit="handleDigestSubmit(event)">
                    <input type="email" id="digestEmail" class="nl-input" placeholder="Enter your email address..." required autocomplete="email">
                    <button type="submit" id="btnDigestSubmit" class="nl-btn">
                        <span>Subscribe Now</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                    <div id="digestToast" style="display: none; margin-top: 12px; padding: 10px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; line-height: 1.4;"></div>
                </form>
            </div>

            <!-- Platform Resources Quick Links -->
            <div class="sidebar-widget">
                <h3 class="widget-title">
                    <i class="fa-solid fa-bookmark"></i>
                    <span>Legal Research Hub</span>
                </h3>
                <div class="resource-pills">
                    <a href="/constitution/Republic/Ghana/1" class="resource-pill">
                        <span><i class="fa-solid fa-landmark" style="color: #f59e0b; margin-right: 8px;"></i> 1992 Constitution</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 11px; opacity: 0.5;"></i>
                    </a>
                    <a href="/new-laws" class="resource-pill">
                        <span><i class="fa-solid fa-scale-balanced" style="color: #3b82f6; margin-right: 8px;"></i> Acts of Parliament</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 11px; opacity: 0.5;"></i>
                    </a>
                    <a href="/judgement/Ghana" class="resource-pill">
                        <span><i class="fa-solid fa-gavel" style="color: #10b981; margin-right: 8px;"></i> Supreme Court Decisions</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 11px; opacity: 0.5;"></i>
                    </a>
                    <a href="/existing-laws" class="resource-pill">
                        <span><i class="fa-solid fa-scroll" style="color: #8b5cf6; margin-right: 8px;"></i> Consolidated Decrees</span>
                        <i class="fa-solid fa-chevron-right" style="font-size: 11px; opacity: 0.5;"></i>
                    </a>
                </div>
            </div>
        </aside>
    </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click', '#table_data .pagination a', function(event){
            event.preventDefault();
            var url = $(this).attr('href');
            var page = 1;
            if (url.indexOf('page=') !== -1) {
                page = url.split('page=')[1].split('&')[0];
            }
            fetch_data(page);
        });

        function fetch_data(page){
            var search = "{{ request('search', '') }}";
            var categoryName = "{{ $newscategory['name'] }}";
            var fetchUrl = "/News/Next/" + categoryName + "/fetch_data?page=" + page;
            if (search) {
                fetchUrl += "&search=" + encodeURIComponent(search);
            }

            $('#table_data').css('opacity', '0.5');

            $.ajax({
                url: fetchUrl,
                success: function(data){
                    $('#table_data').html(data);
                    $('#table_data').css('opacity', '1');
                    $('html, body').animate({
                        scrollTop: $("#table_data").offset().top - 120
                    }, 400);
                },
                error: function(){
                    $('#table_data').css('opacity', '1');
                    alert('Could not load articles. Please refresh the page.');
                }
            });
        }
    });

    function handleDigestSubmit(e) {
        e.preventDefault();
        var emailInput = document.getElementById('digestEmail');
        var btn = document.getElementById('btnDigestSubmit');
        var toast = document.getElementById('digestToast');

        if (!emailInput) return;
        var email = emailInput.value.trim();

        // Client-side email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[a-zA-Z0-9]{2,}$/;
        if (!email || !emailRegex.test(email)) {
            if (toast) {
                toast.style.display = 'block';
                toast.style.background = 'rgba(244, 63, 94, 0.15)';
                toast.style.border = '1px solid rgba(244, 63, 94, 0.35)';
                toast.style.color = '#fb7185';
                toast.innerHTML = '<i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> <span>Please enter a valid email address (e.g. name@domain.com).</span>';
            }
            emailInput.focus();
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> <span>Subscribing...</span>';

        fetch("{{ route('news.subscribe-digest') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '',
                "Accept": "application/json"
            },
            body: JSON.stringify({ email: email })
        })
        .then(function(res) {
            return res.json().then(function(data) {
                if (!res.ok) {
                    throw new Error(data.message || (data.errors && data.errors.email ? data.errors.email[0] : 'Subscription failed. Please check your email.'));
                }
                return data;
            });
        })
        .then(function(data) {
            btn.disabled = true;
            btn.style.background = '#10b981';
            btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Subscribed!</span>';
            if (toast) {
                toast.style.display = 'block';
                toast.style.background = 'rgba(16, 185, 129, 0.15)';
                toast.style.border = '1px solid rgba(16, 185, 129, 0.35)';
                toast.style.color = '#34d399';
                toast.innerHTML = '<i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> <span>' + (data.message || 'Thank you for subscribing to Legals Forum Legal Intelligence Digest!') + '</span>';
            }
            emailInput.disabled = true;
        })
        .catch(function(err) {
            btn.disabled = false;
            btn.innerHTML = '<span>Subscribe Now</span> <i class="fa-solid fa-paper-plane"></i>';
            if (toast) {
                toast.style.display = 'block';
                toast.style.background = 'rgba(244, 63, 94, 0.15)';
                toast.style.border = '1px solid rgba(244, 63, 94, 0.35)';
                toast.style.color = '#fb7185';
                toast.innerHTML = '<i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> <span>' + (err.message || 'An error occurred. Please try again.') + '</span>';
            }
        });
    }
</script>
@endsection