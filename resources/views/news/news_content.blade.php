@extends('extenders.news-main')

@section('title', $newsContent['title'])

@section('meta_description', Str::limit(strip_tags($newsContent['extract'] ?? $newsContent['content']), 160))

@section('assets')
<style>
    .article-page-layout {
        display: grid;
        grid-template-columns: 2.3fr 1fr;
        gap: 40px;
        margin-top: 10px;
    }

    .article-breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-muted);
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .article-breadcrumbs a:hover {
        color: var(--accent-light);
    }

    .article-header {
        margin-bottom: 28px;
    }

    .article-category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(244, 63, 94, 0.15);
        color: var(--rose-light);
        border: 1px solid rgba(244, 63, 94, 0.35);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 4px 12px;
        border-radius: 6px;
        margin-bottom: 14px;
    }

    .article-headline {
        font-size: clamp(24px, 3.2vw, 38px);
        font-weight: 800;
        line-height: 1.3;
        letter-spacing: -0.6px;
        color: #fff;
        margin-bottom: 18px;
    }

    .article-meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        font-size: 13px;
        color: var(--text-muted);
    }

    .meta-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .social-share-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .share-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .share-btn:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
        transform: translateY(-2px);
    }

    /* Featured Image */
    .article-featured-media {
        position: relative;
        width: 100%;
        max-height: 480px;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 32px;
        border: 1px solid var(--border-color);
        background: #090e1a;
    }

    .article-featured-img {
        width: 100%;
        height: 100%;
        max-height: 480px;
        object-fit: cover;
        display: block;
    }

    .article-img-fallback {
        height: 260px;
        width: 100%;
        background: radial-gradient(circle at 30% 30%, #1e293b 0%, #0f172a 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        color: var(--text-muted);
    }

    /* Article Content Prose */
    .article-prose {
        color: #cbd5e1;
        font-size: 16.5px;
        line-height: 1.8;
        letter-spacing: -0.1px;
    }

    .article-prose p {
        margin-bottom: 22px;
    }

    .article-prose h2, .article-prose h3 {
        color: #fff;
        font-weight: 700;
        margin: 32px 0 16px;
        line-height: 1.35;
    }

    .article-prose blockquote {
        border-left: 3px solid var(--rose);
        padding: 16px 20px;
        background: rgba(244, 63, 94, 0.05);
        border-radius: 0 10px 10px 0;
        margin: 28px 0;
        font-style: italic;
        color: #f1f5f9;
    }

    .article-bottom-actions {
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .btn-back-news {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: #fff;
        font-size: 13.5px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-back-news:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--border-hover);
        transform: translateX(-3px);
    }

    /* Related Stories */
    .related-stories-section {
        margin-top: 56px;
        padding-top: 36px;
        border-top: 1px solid var(--border-color);
    }

    .related-title {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .related-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s ease;
    }

    .related-card:hover {
        border-color: var(--border-hover);
        transform: translateY(-3px);
    }

    .related-thumb-box {
        width: 100%;
        height: 140px;
        overflow: hidden;
        background: #090e1a;
    }

    .related-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-card-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .related-card-title {
        font-size: 14.5px;
        font-weight: 700;
        color: #fff;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .related-card:hover .related-card-title {
        color: var(--accent-light);
    }

    /* Sidebar styles */
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

    .category-item a:hover {
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

    @media (max-width: 1024px) {
        .article-page-layout { grid-template-columns: 1fr; }
        .related-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 640px) {
        .related-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

@php
    $words = str_word_count(strip_tags($newsContent['content'] ?? $newsContent['extract']));
    $readTime = max(1, ceil($words / 200));
    $cleanCat = str_replace('-', ' ', $newsContent['news_category']);
    $articleUrl = url('/News/' . $newsContent['news_category'] . '/' . urlencode($newsContent['title']) . '/' . $newsContent['id']);
@endphp

<div class="article-page-layout">
    <!-- Main Article Body Column -->
    <article class="article-main-column">
        <!-- Breadcrumbs -->
        <nav class="article-breadcrumbs">
            <a href="/"><i class="fa-solid fa-house"></i> Home</a>
            <span>/</span>
            <a href="/News/Ghana-News/1">Newsroom</a>
            <span>/</span>
            <a href="/News/{{ $newsContent['news_category'] }}/1">{{ $cleanCat }}</a>
            <span>/</span>
            <span style="color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 280px;">{{ $newsContent['title'] }}</span>
        </nav>

        <!-- Article Header -->
        <header class="article-header">
            <span class="article-category-badge">
                <i class="fa-solid fa-tag"></i> {{ $cleanCat }}
            </span>
            <h1 class="article-headline">{{ $newsContent['title'] }}</h1>

            <div class="article-meta-row">
                <div class="meta-left">
                    <span><i class="fa-regular fa-user" style="margin-right: 4px; color: var(--accent-light);"></i> Legals Forum Correspondent</span>
                    <span>&bull;</span>
                    <span><i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> {{ isset($newsContent['created_at']) ? date('M d, Y', strtotime($newsContent['created_at'])) : 'Recent' }}</span>
                    <span>&bull;</span>
                    <span><i class="fa-regular fa-clock" style="margin-right: 4px;"></i> {{ $readTime }} min read</span>
                </div>

                <!-- Social Share Group -->
                <div class="social-share-group">
                    <span style="font-size: 11.5px; font-weight: 600; text-transform: uppercase;">Share:</span>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($newsContent['title']) }}&url={{ urlencode($articleUrl) }}" target="_blank" class="share-btn" title="Share on X (Twitter)">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($newsContent['title'] . ' ' . $articleUrl) }}" target="_blank" class="share-btn" title="Share on WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($articleUrl) }}" target="_blank" class="share-btn" title="Share on LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <button type="button" class="share-btn" onclick="copyArticleLink()" title="Copy link to clipboard">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Featured Media -->
        <div class="article-featured-media">
            @if(!empty($newsContent['image']))
                <img src="{{ url('storage/'.$newsContent['image']) }}" alt="{{ $newsContent['title'] }}" class="article-featured-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="article-img-fallback" style="display: none;">
                    <i class="fa-solid fa-scale-balanced" style="font-size: 54px; color: rgba(59, 130, 246, 0.4);"></i>
                    <span style="font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">{{ $cleanCat }}</span>
                </div>
            @else
                <div class="article-img-fallback">
                    <i class="fa-solid fa-scale-balanced" style="font-size: 54px; color: rgba(59, 130, 246, 0.4);"></i>
                    <span style="font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">{{ $cleanCat }}</span>
                </div>
            @endif
        </div>

        <!-- Article Prose Content -->
        <div class="article-prose">
            {!! $newsContent['content'] !!}
        </div>

        <!-- Bottom Actions -->
        <div class="article-bottom-actions">
            <a href="/News/{{ $newsContent['news_category'] }}/1" class="btn-back-news">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to {{ $cleanCat }}</span>
            </a>

            <div class="social-share-group">
                <span style="font-size: 12px; color: var(--text-muted);">Share this article:</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($newsContent['title']) }}&url={{ urlencode($articleUrl) }}" target="_blank" class="share-btn">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($newsContent['title'] . ' ' . $articleUrl) }}" target="_blank" class="share-btn">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($articleUrl) }}" target="_blank" class="share-btn">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
            </div>
        </div>

        <!-- Related Stories Section -->
        @if(isset($relatedNews) && count($relatedNews) > 0)
        <section class="related-stories-section">
            <h3 class="related-title">
                <i class="fa-solid fa-newspaper" style="color: var(--rose);"></i>
                <span>Related Stories in {{ $cleanCat }}</span>
            </h3>

            <div class="related-grid">
                @foreach($relatedNews as $related)
                <a href="/News/{{ $related->news_category }}/{{ $related->title }}/{{ $related->id }}" class="related-card">
                    <div class="related-thumb-box">
                        @if(!empty($related->image))
                            <img src="{{ url('storage/'.$related->image) }}" alt="{{ $related->title }}" class="related-thumb" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="card-img-fallback" style="display: none;">
                                <i class="fa-solid fa-scale-balanced" style="font-size: 24px; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        @else
                            <div class="card-img-fallback">
                                <i class="fa-solid fa-scale-balanced" style="font-size: 24px; color: rgba(255,255,255,0.2);"></i>
                            </div>
                        @endif
                    </div>
                    <div class="related-card-body">
                        <span style="font-size: 11px; color: var(--text-muted); margin-bottom: 6px;">
                            {{ $related->created_at ? $related->created_at->format('M d, Y') : 'Recent' }}
                        </span>
                        <h4 class="related-card-title">{{ $related->title }}</h4>
                        <span style="font-size: 12px; font-weight: 700; color: var(--accent-light); margin-top: auto;">
                            Read More &rarr;
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </article>

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
                    $isCurrent = (strtolower($newsContent['news_category']) == strtolower($cat->name));
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

        <!-- Trending Widget -->
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

        <!-- Legal Research Hub Quick Links -->
        <div class="sidebar-widget">
            <h3 class="widget-title">
                <i class="fa-solid fa-bookmark"></i>
                <span>Legal Research Hub</span>
            </h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="/constitution/Republic/Ghana/1" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: 10px; font-size: 13px; font-weight: 600; color: var(--text-secondary);">
                    <span><i class="fa-solid fa-landmark" style="color: #f59e0b; margin-right: 8px;"></i> 1992 Constitution</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 11px; opacity: 0.5;"></i>
                </a>
                <a href="/judgement/Ghana" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: 10px; font-size: 13px; font-weight: 600; color: var(--text-secondary);">
                    <span><i class="fa-solid fa-gavel" style="color: #10b981; margin-right: 8px;"></i> Court of Appeal & Supreme Court</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 11px; opacity: 0.5;"></i>
                </a>
                <a href="/new-laws" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: 10px; font-size: 13px; font-weight: 600; color: var(--text-secondary);">
                    <span><i class="fa-solid fa-scale-balanced" style="color: #3b82f6; margin-right: 8px;"></i> Consolidated Laws</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 11px; opacity: 0.5;"></i>
                </a>
            </div>
        </div>
    </aside>
</div>

@endsection

@section('scripts')
<script>
    function copyArticleLink() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Article link copied to clipboard!');
            });
        } else {
            var temp = document.createElement('input');
            document.body.appendChild(temp);
            temp.value = window.location.href;
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
            alert('Article link copied to clipboard!');
        }
    }
</script>
@endsection