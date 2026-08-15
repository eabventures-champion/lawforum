<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css">

    <style>
        /* ============================================
           VARIABLE DEFINITIONS (Matching Parent Theme)
           ============================================ */
        .premium-article-container, .premium-modal, body.standalone-view {
            --bg-primary: #060a13;
            --bg-secondary: #0c1220;
            --bg-tertiary: #111827;
            --card-bg: rgba(17, 24, 39, 0.55);
            --card-bg-hover: rgba(25, 35, 55, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-hover: rgba(255, 255, 255, 0.15);
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --gold: #f59e0b;
            --gold-glow: rgba(245, 158, 11, 0.15);
            --emerald: #10b981;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --font-ui: 'Outfit', 'Inter', -apple-system, sans-serif;
            --font-legal: 'Lora', 'Georgia', serif;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Prevent style bleed to parent page if injected, but style body if standalone */
        body.standalone-view {
            font-family: var(--font-ui) !important;
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Container Layout */
        .premium-article-container {
            font-family: var(--font-ui) !important;
            color: var(--text-primary) !important;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px 80px;
            animation: fadeIn 0.4s ease both;
        }

        #display_content .premium-article-container .nav-links,
        #display_plain_content .premium-article-container .nav-links,
        #display_expanded_view .premium-article-container .nav-links {
            display: flex !important;
            justify-content: flex-start !important;
            padding: 10px 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 24px;
        }

        .premium-article-container .nav-links span {
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: var(--accent-light);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(8px);
        }

        .premium-article-container .nav-links span i.fa-balance-scale {
            color: var(--gold);
        }

        /* Article Card */
        .article-card {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Legal Content Typography */
        .content {
            font-family: var(--font-legal) !important;
            font-size: 17px;
            line-height: 1.85;
            color: var(--text-primary);
            letter-spacing: -0.01em;
            word-spacing: 0.02em;
        }

        .content p {
            margin-bottom: 1.5em;
            color: #e2e8f0;
        }

        .content h1, .content h2, .content h3, .content h4 {
            font-family: var(--font-ui) !important;
            font-weight: 700;
            color: #fff;
            margin-top: 1.8em;
            margin-bottom: 0.8em;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .content h2 { font-size: 22px; color: var(--accent-light); }
        .content h3 { font-size: 18px; color: #cbd5e1; }
        .content h4 { font-size: 16px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .premium-article-container {
                padding: 0 12px 40px;
            }
            .content {
                font-size: 15px;
            }
        }

        /* Highlight keywords in yellow/gold capsule */
        mark.search-highlight {
            background: rgba(245, 158, 11, 0.18);
            color: #f59e0b;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid rgba(245, 158, 11, 0.3);
            display: inline-block;
        }
    </style>
    @include('partials._nav_subdropdown_styles')
</head>

<body class="standalone-view">
    <div class="premium-article-container" data-sid="{{ $allPre1992Article['id'] }}">
        <div class="nav-links">
            <span style="display: inline-flex; align-items: center; gap: 10px;">
                <i class="fa fa-balance-scale"></i>
                <span class="nav-title-text">{{ $allPre1992Article['section'] }}</span>
                
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
                        class="btn-bookmark-toggle {{ $isBookmarked ? 'is-bookmarked' : '' }}" 
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
            </span>
        </div>

        <!-- Article Content -->
        <div class="article-card">
            <div class="content">
                {!! $allPre1992Article['content'] !!}
            </div>
        </div>
    </div>

    @include('partials._bookmark_script')

    <!-- Scripts dynamically loaded only when missing -->
    <script>
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
        }
    </script>
    <script>
        if (typeof $.fn.modal === 'undefined') {
            document.write('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"><\/script>');
        }
    </script>

    <!-- Highlight keyword from search query parameter -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchText = urlParams.get('search_text');
            if (searchText) {
                highlightWord(searchText);
            }
        });

        function highlightWord(word) {
            if (!word) return;
            const contentContainer = document.querySelector('.content');
            if (!contentContainer) return;
            
            const cleanWord = word.trim();
            if (!cleanWord) return;
            
            const escapedWord = cleanWord.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            const regexPattern = escapedWord.replace(/(\\-| )/g, '[ \\-]');
            const regex = new RegExp(`(${regexPattern})`, 'gi');
            
            const walk = document.createTreeWalker(contentContainer, NodeFilter.SHOW_TEXT, null, false);
            let node;
            const textNodes = [];
            
            while (node = walk.nextNode()) {
                textNodes.push(node);
            }
            
            textNodes.forEach(textNode => {
                const parent = textNode.parentNode;
                if (parent) {
                    const tagName = parent.tagName.toUpperCase();
                    if (tagName !== 'SCRIPT' && 
                        tagName !== 'STYLE' && 
                        tagName !== 'NOSCRIPT' && 
                        tagName !== 'IFRAME' && 
                        tagName !== 'TEXTAREA' && 
                        tagName !== 'MARK' &&
                        !parent.classList.contains('search-highlight')) {
                        
                        const text = textNode.nodeValue;
                        const newHTML = text.replace(regex, '<mark class="search-highlight">$1</mark>');
                        
                        if (newHTML !== text) {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = newHTML;
                            
                            while (tempDiv.firstChild) {
                                parent.insertBefore(tempDiv.firstChild, textNode);
                            }
                            parent.removeChild(textNode);
                        }
                    }
                }
            });

            setTimeout(function() {
                const firstHighlight = contentContainer.querySelector('.search-highlight');
                if (firstHighlight) {
                    firstHighlight.classList.add('active-highlight');
                    firstHighlight.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });
                    const scrollContainer = document.querySelector('.main-wrapper-scrollable');
                    if (scrollContainer && scrollContainer.scrollHeight > scrollContainer.clientHeight) {
                        const containerRect = scrollContainer.getBoundingClientRect();
                        const activeRect = firstHighlight.getBoundingClientRect();
                        const targetTop = scrollContainer.scrollTop + (activeRect.top - containerRect.top) - (containerRect.height / 2);
                        scrollContainer.scrollTo({
                            top: Math.max(0, targetTop),
                            behavior: 'smooth'
                        });
                    }
                }
            }, 50);
        }
    </script>
@include('partials._premium_guest_gate')

<!--Start of Tawk.to Script-->
<script type="text/javascript">
   var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
   (function(){
   var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
   s1.async=true;
   s1.src='https://embed.tawk.to/6a7df4c6bc79881d4b22fbbc/1jvu08a2a';
   s1.charset='UTF-8';
   s1.setAttribute('crossorigin','*');
   s0.parentNode.insertBefore(s1,s0);
   })();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
