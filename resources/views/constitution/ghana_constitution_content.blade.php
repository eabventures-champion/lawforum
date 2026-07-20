<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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

        /* Header / Nav-links Styling */
        #display_content .premium-article-container .nav-links,
        #acts_expanded_view .premium-article-container .nav-links,
        .premium-article-container .nav-links {
            background: rgba(12, 18, 32, 0.8) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 16px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 16px !important;
            padding: 16px 24px !important;
            position: relative !important;
            z-index: 1000 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
            margin-bottom: 32px !important;
            color: #fff !important;
        }

        .premium-article-container .nav-links span {
            font-family: var(--font-ui) !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #fff !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            letter-spacing: -0.2px !important;
            flex: 1 !important;
            min-width: 0 !important;
        }

        .premium-article-container .nav-links span i {
            color: var(--accent-light) !important;
            font-size: 18px !important;
            flex-shrink: 0 !important;
        }

        .premium-article-container .nav-links .nav-title-text {
            white-space: normal !important;
            word-break: break-word !important;
            line-height: 1.4 !important;
        }

        /* Bookmark Button inside Nav-links */
        .bookmarking {
            color: var(--text-muted);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            margin-left: 8px;
        }

        .bookmarking:hover {
            color: var(--gold);
            background: rgba(245, 158, 11, 0.1);
            transform: scale(1.05);
            text-decoration: none;
        }

        .bookmarking i {
            font-size: 16px;
        }

        /* Actions Button & Menu Container */
        .premium-article-container .actions-container {
            position: relative !important;
            display: inline-flex !important;
            align-items: center !important;
            flex-shrink: 0 !important;
            z-index: 1010 !important;
        }

        #display_content .premium-article-container #print_options,
        #acts_expanded_view .premium-article-container #print_options,
        .premium-article-container #print_options {
            background: var(--accent-gradient) !important;
            border: none !important;
            color: #ffffff !important;
            font-family: var(--font-ui) !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 8px 18px !important;
            border-radius: 30px !important;
            cursor: pointer !important;
            transition: var(--transition) !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            box-shadow: 0 4px 12px var(--accent-glow) !important;
            text-decoration: none !important;
        }

        #display_content .premium-article-container #print_options *,
        #acts_expanded_view .premium-article-container #print_options *,
        .premium-article-container #print_options * {
            color: #ffffff !important;
        }

        #display_content .premium-article-container #print_options:hover,
        #acts_expanded_view .premium-article-container #print_options:hover,
        .premium-article-container #print_options:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4) !important;
            filter: brightness(1.1) !important;
        }

        .premium-article-container .menu_options {
            position: absolute !important;
            top: calc(100% + 8px) !important;
            right: 0 !important;
            background: #0f172a !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            width: 200px !important;
            padding: 8px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.45) !important;
            backdrop-filter: blur(20px) !important;
            z-index: 1020 !important;
            display: none;
            gap: 4px;
        }

        #display_content .premium-article-container .menu_options a,
        #acts_expanded_view .premium-article-container .menu_options a,
        .premium-article-container .menu_options a {
            font-family: var(--font-ui) !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #ffffff !important;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            text-decoration: none !important;
            transition: var(--transition) !important;
        }

        .menu_options a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            text-decoration: none;
        }

        .menu_options a i {
            font-size: 14px;
            width: 18px;
            text-align: center;
        }

        .menu_options a .text-red { color: #f43f5e; }
        .menu_options a .text-blue { color: #3b82f6; }

        /* Article content Card */
        .article-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 40px 48px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .article-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-gradient);
        }

        .article-card:hover {
            border-color: var(--border-hover);
        }

        /* Content / Legal text styling */
        .content {
            font-family: var(--font-legal);
            font-size: 17px;
            line-height: 1.85;
            color: #e2e8f0;
        }

        /* Indentation and alignment of Legal clauses */
        .content p {
            margin-bottom: 22px;
            text-align: justify;
        }

        /* If there are lists or tables, make sure they are styled */
        .content ul, .content ol {
            margin-left: 24px;
            margin-bottom: 24px;
        }

        .content li {
            margin-bottom: 12px;
        }

        /* Premium Modal Styling */
        .premium-modal {
            background: #0f172a !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 20px !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5) !important;
            overflow: hidden;
        }

        .premium-modal .modal-header {
            border-bottom: 1px solid var(--border-color) !important;
            padding: 20px 24px !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .premium-modal .modal-title {
            font-family: var(--font-ui) !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .premium-modal .modal-title i {
            color: var(--gold);
        }

        .premium-modal .close-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 18px;
            cursor: pointer;
            transition: var(--transition);
        }

        .premium-modal .close-btn:hover {
            color: #fff;
        }

        .premium-modal .modal-body {
            padding: 28px 24px !important;
            background: #090d16 !important;
        }

        .premium-modal .modal-desc {
            font-family: var(--font-ui);
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .premium-modal .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .premium-modal .btn-auth {
            font-family: var(--font-ui);
            font-size: 13px;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 30px;
            text-decoration: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .premium-modal .btn-login {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            color: #fff;
        }

        .premium-modal .btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--border-hover);
        }

        .premium-modal .btn-signup {
            background: var(--accent-gradient);
            color: #fff;
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .premium-modal .btn-signup:hover {
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
            filter: brightness(1.1);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .premium-article-container {
                padding: 0 12px 40px;
            }
            .article-card {
                padding: 30px 24px;
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
            font-weight: 650;
            border: 1px solid rgba(245, 158, 11, 0.3);
            display: inline-block;
        }
    </style>
</head>

<body class="standalone-view">
    <div class="premium-article-container" data-sid="{{ $constitutionContent['id'] }}">
        {{-- For the bookmark --}}
        <div class="nav-links">
            <span>
                <i class="fa fa-balance-scale"></i>
                <span class="nav-title-text">{{ $constitutionContent['section'] }}</span>
                
                @if (Route::has('login'))
                    @auth                        
                        <a class="bookmarking" href="javascript:;" rel="/bookmarks/{{$constitutionContent['chapter']}}/{{$constitutionContent['id']}}">
                            <i title="Bookmark this section" id="bookmarked" class="tooltips fa-regular fa-bookmark"></i>
                        </a>
                    @endauth
                @endif
            </span>
            

        </div>

        <!-- Article Content -->
        <div class="article-card">
            <div class="content">
                {!! $constitutionContent['articles'] !!}
            </div>
        </div>
    </div>

    <!-- Scripts dynamically loaded only when missing (Prevents AJAX duplicates) -->
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

    <script>
        $(".section_id").click(function(e){
            e.preventDefault();
            var section_id = $(this).attr("rel");
            console.log(section_id);

            $.ajax({
                url: section_id,
                type: "GET",
                success:function(response){
                if(response.success){
                      $("#bookmarked").notify(
                          response.message,
                    { position:"left", className: "info", autoHideDelay: 900000}
                    );
                }else{
                    $("#bookmarked").notify(
                   "Section to Download",
                    { position:"left", className: "success", autoHideDelay: 10000}
                    );
                  }
                },
                error:function (){
                    $("#bookmarked").notify(
                   "Issue with database entry",
                    { position:"left", className: "error" }
                    );
                }
            });
        });
    </script>

    <script>
        $(".download_link").click(function(e){
            e.preventDefault();
            var download_link = $(this).attr("rel");
            $('.section_id').trigger("click");
           
            $.ajax({
                url: download_link,
                type: "GET",
            });
        });  
    </script>

    <script>
        if (typeof $.fn.tooltipster !== 'undefined') {
            $('.tooltips').tooltipster({
                theme: 'tooltipster-borderless'
            });
        }
    </script>

    <script>
        $('.bookmarking').click(function(e){
            e.preventDefault();
            var targetUrl = $(this).attr('rel');
            $.ajax({
                url: targetUrl,
                type: "GET",
                success:function(response){
                if(response.success){
                      $("#bookmarked").notify(
                          response.message,
                    { position:"left", className: "info" }
                    );
                }else{
                    $("#bookmarked").notify(
                   "Section bookmarked",
                    { position:"left", className: "success" }
                    );
                  }
                },
                error:function (){
                    $("#bookmarked").notify(
                   "Issue with database entry",
                    { position:"left", className: "error" }
                    );
                }
            });
        });
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
            
            // Clean/trim and escape word
            const cleanWord = word.trim();
            if (!cleanWord) return;
            
            const escapedWord = cleanWord.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            // Treat spaces and hyphens interchangeably
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
        }
    </script>
</body>
</html>
