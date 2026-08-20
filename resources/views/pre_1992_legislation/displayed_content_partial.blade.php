{{-- 
    Partial view for section content loaded via AJAX in the reader view.
    Contains only the metadata header + article content — NO doctype, html, head, nav, breadcrumbs.
    Used when Pre1992Controller detects an AJAX request.
--}}

@php
    $searchText = $searchText ?? request()->get('search_text', '');
    $actTitle = $allPre1992Article['pre_1992_act'] ?? 'Legal Document';
    $sectionTitle = $allPre1992Article['section'] ?? '';
    $actYear = '';
    if (preg_match('/\b(1[89]\d{2}|20[0-2]\d)\b/', $actTitle, $yearMatch)) {
        $actYear = $yearMatch[1];
    }
@endphp

<style>
    .reader-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0 16px 0;
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        gap: 16px;
    }

    .reader-section-title {
        font-family: 'Outfit', 'Inter', -apple-system, sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #60a5fa;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        line-height: 1.4;
    }

    .reader-section-title i {
        color: #f59e0b;
        font-size: 15px;
    }

    .reader-bookmark-btn,
    .btn-bookmark-toggle {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 36px !important;
        height: 36px !important;
        min-width: 36px !important;
        padding: 0 !important;
        border-radius: 10px !important;
        background: rgba(255, 255, 255, 0.04) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f59e0b !important;
        cursor: pointer !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        text-decoration: none !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
    }

    .reader-bookmark-btn i,
    .btn-bookmark-toggle i {
        font-size: 15px !important;
        color: #f59e0b !important;
        transition: transform 0.2s ease !important;
    }

    .reader-bookmark-btn:hover,
    .btn-bookmark-toggle:hover {
        background: rgba(245, 158, 11, 0.15) !important;
        border-color: rgba(245, 158, 11, 0.5) !important;
        color: #fbbf24 !important;
        transform: translateY(-1px) scale(1.05) !important;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.25) !important;
    }

    .reader-bookmark-btn:hover i,
    .btn-bookmark-toggle:hover i {
        transform: scale(1.15) !important;
        color: #fbbf24 !important;
    }

    .reader-bookmark-btn.is-bookmarked,
    .btn-bookmark-toggle.is-bookmarked {
        background: rgba(245, 158, 11, 0.2) !important;
        border-color: #f59e0b !important;
        color: #fbbf24 !important;
        box-shadow: 0 0 16px rgba(245, 158, 11, 0.3) !important;
    }

    .reader-bookmark-btn.is-bookmarked i,
    .btn-bookmark-toggle.is-bookmarked i {
        color: #f59e0b !important;
    }

    .premium-article-container {
        font-family: 'Outfit', 'Inter', -apple-system, sans-serif !important;
        color: #f1f5f9 !important;
        max-width: 900px;
        margin: 0 auto;
        padding: 0 0 80px;
    }

    .article-card {
        background: transparent;
        border: none;
        border-radius: 0;
        padding: 0;
        margin: 0;
        position: relative;
    }
</style>

{{-- Section Header --}}
<div class="reader-section-header">
    <div class="reader-section-title">
        <i class="fa-solid fa-balance-scale"></i>
        <span>{{ $sectionTitle }}</span>
    </div>

    @php
        $isBookmarked = false;
        $preAct = \App\Pre1992LegislationAct::where('title', $allPre1992Article['pre_1992_act'])->first();
        $preGroup = $preAct ? $preAct->pre_1992_group : ($allPre1992Article['act_group'] ?? 'Existing Laws');
        $preActId = $preAct ? $preAct->id : ($allPre1992Article['act_id'] ?? 1);
        $prePageUrl = "/existing-laws/" . rawurlencode($preGroup) . "/" . rawurlencode($allPre1992Article['pre_1992_act']) . "/" . $preActId . "#section-" . $allPre1992Article['id'];

        if (auth()->check()) {
            $isBookmarked = \App\UserBookmark::where('user_id', auth()->id())
                ->where(function($q) use ($allPre1992Article, $preActId) {
                    $q->where('section_id', $allPre1992Article['id'])
                      ->orWhere('user_section', auth()->id() . '_pre_1992_' . $preActId . '_' . $allPre1992Article['id'])
                      ->orWhere('user_section', auth()->id() . '_pre_1992_' . $allPre1992Article['act_id'] . '_' . $allPre1992Article['id']);
                })->exists();
        }
    @endphp

    <button type="button"
            class="reader-bookmark-btn btn-bookmark-toggle {{ $isBookmarked ? 'is-bookmarked' : '' }}"
            data-act-title="{{ $allPre1992Article['pre_1992_act'] }}"
            data-act-section="{{ $allPre1992Article['section'] }}"
            data-section-id="{{ $allPre1992Article['id'] }}"
            data-act-id="{{ $preActId }}"
            data-act-group="{{ $preGroup }}"
            data-doc-type="pre_1992"
            data-page-url="{{ $prePageUrl }}"
            title="{{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark this section' }}"
            onclick="toggleBookmark(this)">
        <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
    </button>
</div>

{{-- Article Content --}}
<div class="premium-article-container" data-sid="{{ $allPre1992Article['id'] }}">
    <div class="article-card">
        <div class="content">
            {!! $allPre1992Article['content'] !!}
        </div>
    </div>
</div>

<script>
    // Copy content function for reader partial
    function copyLegalContent() {
        var contentEl = document.querySelector('#display_content .article-card .content');
        if (!contentEl) contentEl = document.querySelector('.article-card .content');
        if (!contentEl) return;

        var text = contentEl.innerText || contentEl.textContent;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function() {
                var btn = document.getElementById('copyContentBtn');
                if (btn) {
                    var original = btn.innerHTML;
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
                    btn.style.color = '#10b981';
                    btn.style.borderColor = 'rgba(16, 185, 129, 0.3)';
                    setTimeout(function() {
                        btn.innerHTML = original;
                        btn.style.color = '';
                        btn.style.borderColor = '';
                    }, 2000);
                }
            });
        } else {
            var range = document.createRange();
            range.selectNodeContents(contentEl);
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
            document.execCommand('copy');
            sel.removeAllRanges();
        }
    }
</script>
