//-------------------------------------------------------------------------------------------------------------------------
// Intercept XMLHttpRequest to prevent page flickering on readyState changes
(function() {
    let proto = XMLHttpRequest.prototype;
    let descriptor = Object.getOwnPropertyDescriptor(proto, 'onreadystatechange');
    if (!descriptor && window.XMLHttpRequestEventTarget) {
        proto = window.XMLHttpRequestEventTarget.prototype;
        descriptor = Object.getOwnPropertyDescriptor(proto, 'onreadystatechange');
    }
    if (descriptor && descriptor.set) {
        const originalSet = descriptor.set;
        Object.defineProperty(proto, 'onreadystatechange', {
            set: function(callback) {
                const xhr = this;
                originalSet.call(xhr, function(e) {
                    if (xhr.readyState === 4) {
                        callback.call(xhr, e);
                    }
                });
            },
            configurable: true,
            enumerable: true
        });
    }
})();

//-------------------------------------------------------------------------------------------------------------------------
// Universal fix: Hide standalone page elements (nav, breadcrumbs, back-to-top, Tawk.to)
// when full-page content views are loaded into the reader's #display_content panel.
// This covers all document types: Constitution, Existing Laws, New Laws, Amendments, etc.
(function() {
    var style = document.createElement('style');
    style.textContent = '' +
        /* ---- Hide standalone navigation & chrome ---- */
        '#display_content .content-nav,' +
        '#display_content .content-breadcrumb,' +
        '#display_content .content-back-search,' +
        '#display_content .back-to-top-btn,' +
        '#display_content .gate-header,' +
        '#display_content .ambient-blob,' +
        '.split-panel-body .content-nav,' +
        '.split-panel-body .content-breadcrumb,' +
        '.split-panel-body .content-back-search,' +
        '.split-panel-body .back-to-top-btn,' +
        '.split-panel-body .gate-header,' +
        '.split-panel-body .ambient-blob' +
        '{ display: none !important; }' +

        /* ---- Standalone body reset ---- */
        '#display_content body.standalone-view,' +
        '#display_content > body.standalone-view' +
        '{ background: transparent !important; padding: 0 !important; margin: 0 !important; min-height: auto !important; }' +

        /* ---- Content header wrap (contains metadata card) ---- */
        '#display_content .content-header-wrap,' +
        '.split-panel-body .content-header-wrap' +
        '{ animation: none !important; padding: 0 !important; margin: 0 !important; }' +

        /* ---- Metadata header: clean flex row for reader view ---- */
        '#display_content .content-meta-header,' +
        '.split-panel-body .content-meta-header' +
        '{ display: flex !important; align-items: center !important; justify-content: space-between !important; background: transparent !important; border: none !important; border-bottom: 1px solid rgba(255,255,255,0.08) !important; border-radius: 0 !important; padding: 8px 0 16px 0 !important; margin-bottom: 24px !important; position: relative !important; overflow: visible !important; gap: 16px !important; }' +

        /* ---- Remove accent bar ---- */
        '#display_content .content-meta-header::before,' +
        '.split-panel-body .content-meta-header::before' +
        '{ display: none !important; }' +

        /* ---- Hide Act Title and Badges in Reader View ---- */
        '#display_content .content-meta-badges,' +
        '.split-panel-body .content-meta-badges,' +
        '#display_content .content-act-title,' +
        '.split-panel-body .content-act-title' +
        '{ display: none !important; }' +

        /* ---- Section title ---- */
        '#display_content .content-section-title,' +
        '.split-panel-body .content-section-title' +
        '{ font-family: "Outfit","Inter",-apple-system,sans-serif !important; font-size: 15px !important; font-weight: 700 !important; color: #60a5fa !important; display: inline-flex !important; align-items: center !important; gap: 10px !important; margin: 0 !important; }' +

        '#display_content .content-section-title i,' +
        '.split-panel-body .content-section-title i' +
        '{ color: #f59e0b !important; font-size: 14px !important; }' +

        /* ---- Actions bar: inline on right side ---- */
        '#display_content .content-actions-bar,' +
        '.split-panel-body .content-actions-bar' +
        '{ display: inline-flex !important; align-items: center !important; gap: 8px !important; margin: 0 !important; padding: 0 !important; border: none !important; }' +

        /* Hide Print and Copy buttons inside reader */
        '#display_content .content-actions-bar .content-action-btn:not(.btn-bookmark-toggle),' +
        '.split-panel-body .content-actions-bar .content-action-btn:not(.btn-bookmark-toggle)' +
        '{ display: none !important; }' +

        /* Bookmark button — refined icon-only button on right side of section title */
        '#display_content .content-actions-bar .btn-bookmark-toggle, #display_content .reader-bookmark-btn,' +
        '.split-panel-body .content-actions-bar .btn-bookmark-toggle, .split-panel-body .reader-bookmark-btn' +
        '{ display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 36px !important; height: 36px !important; min-width: 36px !important; max-width: 36px !important; padding: 0 !important; border-radius: 10px !important; background: rgba(255,255,255,0.04) !important; border: 1px solid rgba(255,255,255,0.12) !important; color: #f59e0b !important; cursor: pointer !important; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important; box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important; transform: none !important; }' +

        '#display_content .content-actions-bar .btn-bookmark-toggle span, #display_content .reader-bookmark-btn span,' +
        '.split-panel-body .content-actions-bar .btn-bookmark-toggle span, .split-panel-body .reader-bookmark-btn span' +
        '{ display: none !important; }' +

        '#display_content .content-actions-bar .btn-bookmark-toggle i, #display_content .reader-bookmark-btn i,' +
        '.split-panel-body .content-actions-bar .btn-bookmark-toggle i, .split-panel-body .reader-bookmark-btn i' +
        '{ font-size: 15px !important; color: #f59e0b !important; transition: transform 0.2s ease !important; margin: 0 !important; }' +

        '#display_content .content-actions-bar .btn-bookmark-toggle:hover, #display_content .reader-bookmark-btn:hover,' +
        '.split-panel-body .content-actions-bar .btn-bookmark-toggle:hover, .split-panel-body .reader-bookmark-btn:hover' +
        '{ background: rgba(245,158,11,0.15) !important; border-color: rgba(245,158,11,0.5) !important; color: #fbbf24 !important; transform: translateY(-1px) scale(1.05) !important; box-shadow: 0 4px 14px rgba(245,158,11,0.25) !important; }' +

        '#display_content .content-actions-bar .btn-bookmark-toggle:hover i, #display_content .reader-bookmark-btn:hover i,' +
        '.split-panel-body .content-actions-bar .btn-bookmark-toggle:hover i, .split-panel-body .reader-bookmark-btn:hover i' +
        '{ transform: scale(1.15) !important; color: #fbbf24 !important; }' +

        '#display_content .content-actions-bar .btn-bookmark-toggle.is-bookmarked, #display_content .reader-bookmark-btn.is-bookmarked,' +
        '.split-panel-body .content-actions-bar .btn-bookmark-toggle.is-bookmarked, .split-panel-body .reader-bookmark-btn.is-bookmarked' +
        '{ background: rgba(245,158,11,0.2) !important; border-color: #f59e0b !important; color: #fbbf24 !important; box-shadow: 0 0 16px rgba(245,158,11,0.3) !important; }' +

        '#display_content .content-actions-bar .btn-bookmark-toggle.is-bookmarked i, #display_content .reader-bookmark-btn.is-bookmarked i,' +
        '.split-panel-body .content-actions-bar .btn-bookmark-toggle.is-bookmarked i, .split-panel-body .reader-bookmark-btn.is-bookmarked i' +
        '{ color: #f59e0b !important; }' +

        /* =========================================================
           PREMIUM GUEST LIMIT REACHED / LOCKED SECTION STYLING
           ========================================================= */
        '#display_content .gate-card, #display_content .gate-card-partial,' +
        '.split-panel-body .gate-card, .split-panel-body .gate-card-partial' +
        '{ width: 100% !important; max-width: 720px !important; margin: 30px auto !important; background: rgba(15, 23, 42, 0.85) !important; border: 1px solid rgba(245, 158, 11, 0.3) !important; border-radius: 22px !important; padding: 36px 28px 30px !important; text-align: center !important; box-shadow: 0 25px 70px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.05) !important; backdrop-filter: blur(24px) !important; -webkit-backdrop-filter: blur(24px) !important; position: relative !important; overflow: hidden !important; }' +

        '#display_content .gate-card::before, #display_content .gate-card-partial::before,' +
        '.split-panel-body .gate-card::before, .split-panel-body .gate-card-partial::before' +
        '{ content: "" !important; position: absolute !important; top: 0 !important; left: 0 !important; right: 0 !important; height: 3px !important; background: linear-gradient(90deg, #3b82f6, #f59e0b, #8b5cf6) !important; }' +

        '#display_content .lock-icon-wrap, #display_content .lock-icon-wrap-partial,' +
        '.split-panel-body .lock-icon-wrap, .split-panel-body .lock-icon-wrap-partial' +
        '{ width: 64px !important; height: 64px !important; border-radius: 18px !important; background: radial-gradient(circle at 30% 30%, rgba(245, 158, 11, 0.25), rgba(245, 158, 11, 0.08)) !important; border: 1.5px solid rgba(245, 158, 11, 0.45) !important; color: #fbbf24 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-size: 26px !important; margin-bottom: 16px !important; box-shadow: 0 0 30px rgba(245, 158, 11, 0.25) !important; }' +

        '#display_content .gate-badge, #display_content .gate-badge-partial,' +
        '.split-panel-body .gate-badge, .split-panel-body .gate-badge-partial' +
        '{ display: inline-flex !important; align-items: center !important; gap: 6px !important; padding: 4px 12px !important; border-radius: 20px !important; font-size: 11px !important; font-weight: 700 !important; text-transform: uppercase !important; letter-spacing: 0.7px !important; background: rgba(245, 158, 11, 0.12) !important; color: #fbbf24 !important; border: 1px solid rgba(245, 158, 11, 0.28) !important; margin-bottom: 14px !important; }' +

        '#display_content .gate-title, #display_content .gate-title-partial,' +
        '.split-panel-body .gate-title, .split-panel-body .gate-title-partial' +
        '{ font-family: "Outfit","Inter",-apple-system,sans-serif !important; font-size: 22px !important; font-weight: 800 !important; color: #ffffff !important; letter-spacing: -0.4px !important; margin-bottom: 10px !important; line-height: 1.35 !important; }' +

        '#display_content .gate-act-meta, #display_content .gate-act-meta-partial,' +
        '.split-panel-body .gate-act-meta, .split-panel-body .gate-act-meta-partial' +
        '{ display: inline-flex !important; align-items: center !important; gap: 8px !important; padding: 6px 14px !important; background: rgba(255, 255, 255, 0.04) !important; border: 1px solid rgba(255, 255, 255, 0.08) !important; border-radius: 10px !important; font-size: 13px !important; font-weight: 500 !important; color: #cbd5e1 !important; margin-bottom: 16px !important; max-width: 100% !important; word-break: break-word !important; }' +

        '#display_content .gate-act-meta i, #display_content .gate-act-meta-partial i,' +
        '.split-panel-body .gate-act-meta i, .split-panel-body .gate-act-meta-partial i' +
        '{ color: #60a5fa !important; flex-shrink: 0 !important; }' +

        '#display_content .gate-desc, #display_content .gate-desc-partial,' +
        '.split-panel-body .gate-desc, .split-panel-body .gate-desc-partial' +
        '{ font-size: 14px !important; color: #94a3b8 !important; line-height: 1.6 !important; max-width: 580px !important; margin: 0 auto 24px !important; }' +

        '#display_content .gate-desc strong, #display_content .gate-desc-partial strong,' +
        '.split-panel-body .gate-desc strong, .split-panel-body .gate-desc-partial strong' +
        '{ color: #ffffff !important; font-weight: 600 !important; }' +

        '#display_content .roles-grid, #display_content .roles-grid-partial,' +
        '.split-panel-body .roles-grid, .split-panel-body .roles-grid-partial' +
        '{ display: grid !important; grid-template-columns: repeat(3, 1fr) !important; gap: 14px !important; margin-bottom: 24px !important; text-align: left !important; }' +

        '#display_content .role-card, #display_content .role-card-partial,' +
        '.split-panel-body .role-card, .split-panel-body .role-card-partial' +
        '{ background: rgba(17, 24, 39, 0.6) !important; border: 1px solid rgba(255, 255, 255, 0.08) !important; border-radius: 16px !important; padding: 18px 16px 18px 16px !important; text-decoration: none !important; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important; display: flex !important; flex-direction: column !important; position: relative !important; overflow: hidden !important; color: inherit !important; min-height: 130px !important; }' +

        '#display_content .role-card:hover, #display_content .role-card-partial:hover,' +
        '.split-panel-body .role-card:hover, .split-panel-body .role-card-partial:hover' +
        '{ transform: translateY(-2px) !important; border-color: rgba(255, 255, 255, 0.25) !important; background: rgba(25, 35, 55, 0.85) !important; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35) !important; }' +

        '#display_content .role-card.featured, #display_content .role-card.role-lawyer,' +
        '#display_content .role-card-partial.featured-partial, #display_content .role-card-partial.role-lawyer-partial,' +
        '.split-panel-body .role-card.featured, .split-panel-body .role-card.role-lawyer' +
        '{ border-color: rgba(245, 158, 11, 0.45) !important; background: rgba(245, 158, 11, 0.06) !important; box-shadow: 0 8px 25px rgba(245, 158, 11, 0.1) !important; }' +

        /* Reduced-size Icon at Bottom-Right of Card */
        '#display_content .role-icon, #display_content .role-icon-partial,' +
        '.split-panel-body .role-icon, .split-panel-body .role-icon-partial' +
        '{ position: absolute !important; bottom: 14px !important; right: 14px !important; width: 26px !important; height: 26px !important; min-width: 26px !important; max-width: 26px !important; border-radius: 7px !important; display: flex !important; align-items: center !important; justify-content: center !important; font-size: 11.5px !important; margin: 0 !important; flex-shrink: 0 !important; pointer-events: none !important; }' +

        '#display_content .role-student .role-icon, #display_content .role-student-partial .role-icon-partial,' +
        '.split-panel-body .role-student .role-icon' +
        '{ background: rgba(59, 130, 246, 0.15) !important; color: #60a5fa !important; border: 1px solid rgba(59, 130, 246, 0.3) !important; }' +

        '#display_content .role-lawyer .role-icon, #display_content .role-lawyer-partial .role-icon-partial,' +
        '.split-panel-body .role-lawyer .role-icon' +
        '{ background: rgba(245, 158, 11, 0.2) !important; color: #f59e0b !important; border: 1px solid rgba(245, 158, 11, 0.4) !important; }' +

        '#display_content .role-researcher .role-icon, #display_content .role-researcher-partial .role-icon-partial,' +
        '.split-panel-body .role-researcher .role-icon' +
        '{ background: rgba(139, 92, 246, 0.18) !important; color: #a78bfa !important; border: 1px solid rgba(139, 92, 246, 0.35) !important; }' +

        '#display_content .role-name, #display_content .role-name-partial,' +
        '.split-panel-body .role-name, .split-panel-body .role-name-partial' +
        '{ font-size: 14px !important; font-weight: 700 !important; color: #ffffff !important; margin-bottom: 3px !important; padding-right: 48px !important; }' +

        '#display_content .role-subtitle, #display_content .role-subtitle-partial,' +
        '.split-panel-body .role-subtitle, .split-panel-body .role-subtitle-partial' +
        '{ font-size: 11.5px !important; color: #94a3b8 !important; line-height: 1.4 !important; margin-bottom: 14px !important; padding-right: 32px !important; }' +

        '#display_content .role-btn-text, #display_content .role-btn-text-partial,' +
        '.split-panel-body .role-btn-text, .split-panel-body .role-btn-text-partial' +
        '{ font-size: 12px !important; font-weight: 700 !important; display: inline-flex !important; align-items: center !important; gap: 5px !important; transition: all 0.25s ease !important; margin-top: auto !important; }' +

        '#display_content .role-student .role-btn-text, #display_content .role-student-partial .role-btn-text-partial' +
        '{ color: #60a5fa !important; }' +
        '#display_content .role-lawyer .role-btn-text, #display_content .role-lawyer-partial .role-btn-text-partial' +
        '{ color: #fbbf24 !important; }' +
        '#display_content .role-researcher .role-btn-text, #display_content .role-researcher-partial .role-btn-text-partial' +
        '{ color: #c4b5fd !important; }' +

        '#display_content .role-featured-tag, #display_content .role-featured-tag-partial,' +
        '.split-panel-body .role-featured-tag, .split-panel-body .role-featured-tag-partial' +
        '{ position: absolute !important; top: 10px !important; right: 10px !important; font-size: 8.5px !important; font-weight: 800 !important; text-transform: uppercase !important; letter-spacing: 0.6px !important; padding: 2px 7px !important; border-radius: 6px !important; background: rgba(245, 158, 11, 0.25) !important; color: #fbbf24 !important; border: 1px solid rgba(245, 158, 11, 0.4) !important; }' +

        '#display_content .gate-footer-actions, #display_content .gate-footer-partial,' +
        '.split-panel-body .gate-footer-actions, .split-panel-body .gate-footer-partial' +
        '{ display: flex !important; align-items: center !important; justify-content: center !important; gap: 16px !important; flex-wrap: wrap !important; padding-top: 16px !important; border-top: 1px solid rgba(255, 255, 255, 0.08) !important; }' +

        '#display_content .gate-login-prompt, #display_content .gate-login-prompt-partial,' +
        '.split-panel-body .gate-login-prompt, .split-panel-body .gate-login-prompt-partial' +
        '{ font-size: 13px !important; color: #64748b !important; }' +

        '#display_content .gate-login-prompt a, #display_content .gate-login-prompt-partial a,' +
        '.split-panel-body .gate-login-prompt a, .split-panel-body .gate-login-prompt-partial a' +
        '{ color: #60a5fa !important; text-decoration: none !important; font-weight: 600 !important; margin-left: 4px !important; }' +

        /* Mobile & Tablet responsive layout for role cards */
        '@media (max-width: 768px) {' +
            '#display_content .roles-grid, #display_content .roles-grid-partial, .split-panel-body .roles-grid, .split-panel-body .roles-grid-partial { grid-template-columns: 1fr !important; gap: 10px !important; }' +
            '#display_content .gate-card, #display_content .gate-card-partial, .split-panel-body .gate-card, .split-panel-body .gate-card-partial { padding: 20px 14px !important; margin: 10px auto 20px !important; border-radius: 16px !important; }' +
            '#display_content .gate-title, #display_content .gate-title-partial, .split-panel-body .gate-title, .split-panel-body .gate-title-partial { font-size: 18px !important; }' +
            '#display_content .gate-desc, #display_content .gate-desc-partial, .split-panel-body .gate-desc, .split-panel-body .gate-desc-partial { font-size: 12.5px !important; margin-bottom: 18px !important; }' +
            '#display_content .role-card, #display_content .role-card-partial, .split-panel-body .role-card, .split-panel-body .role-card-partial { padding: 14px 14px 14px 14px !important; min-height: auto !important; }' +
            '#display_content .role-name, #display_content .role-name-partial, .split-panel-body .role-name, .split-panel-body .role-name-partial { font-size: 14px !important; margin-bottom: 3px !important; padding-right: 52px !important; }' +
            '#display_content .role-subtitle, #display_content .role-subtitle-partial, .split-panel-body .role-subtitle, .split-panel-body .role-subtitle-partial { font-size: 11.5px !important; margin-bottom: 12px !important; line-height: 1.35 !important; padding-right: 36px !important; }' +
            '#display_content .role-btn-text, #display_content .role-btn-text-partial, .split-panel-body .role-btn-text, .split-panel-body .role-btn-text-partial { font-size: 12px !important; }' +
            '#display_content .role-icon, #display_content .role-icon-partial, .split-panel-body .role-icon, .split-panel-body .role-icon-partial { bottom: 12px !important; right: 12px !important; width: 24px !important; height: 24px !important; min-width: 24px !important; max-width: 24px !important; font-size: 10.5px !important; border-radius: 6px !important; }' +
            '#display_content .role-featured-tag, #display_content .role-featured-tag-partial, .split-panel-body .role-featured-tag, .split-panel-body .role-featured-tag-partial { top: 8px !important; right: 8px !important; padding: 1px 6px !important; font-size: 8px !important; }' +
        '}';

    document.head.appendChild(style);

    // Also strip full HTML document wrapper when injected into #display_content
    // by observing DOM changes and extracting only the <body> content
    function stripStandaloneFromContainer(container) {
        if (!container) return;
        // If the response was a full HTML page, the browser parses it and keeps only
        // the body content. But <style>, <link>, and <nav> elements survive.
        // Remove standalone-only elements that shouldn't appear in the reader panel.
        var removeSelectors = [
            'nav.content-nav',
            '.content-breadcrumb',
            '.content-back-search',
            '.back-to-top-btn',
            'header.gate-header',
            '.ambient-blob',
            'link[href*="fonts.googleapis"]',
            'link[href*="font-awesome"]',
            'link[href*="tooltipster"]'
        ];
        removeSelectors.forEach(function(sel) {
            var els = container.querySelectorAll(sel);
            for (var i = 0; i < els.length; i++) {
                els[i].parentNode.removeChild(els[i]);
            }
        });

        // Remove standalone <style> blocks that define standalone-view selectors
        // These leak CSS that conflicts with the reader's dark theme
        var styleEls = container.querySelectorAll('style');
        for (var i = 0; i < styleEls.length; i++) {
            var text = styleEls[i].textContent || '';
            if (text.indexOf('.content-nav') !== -1 ||
                text.indexOf('.standalone-view') !== -1) {
                styleEls[i].parentNode.removeChild(styleEls[i]);
            }
        }

        // Remove duplicate script loaders (jQuery, Bootstrap) that leak from standalone pages
        var scriptEls = container.querySelectorAll('script');
        for (var j = 0; j < scriptEls.length; j++) {
            var src = scriptEls[j].src || '';
            var txt = scriptEls[j].textContent || '';
            if (src.indexOf('jquery') !== -1 ||
                src.indexOf('bootstrap') !== -1 ||
                src.indexOf('tawk.to') !== -1 ||
                txt.indexOf('typeof jQuery') !== -1 ||
                txt.indexOf('$.fn.modal') !== -1 ||
                txt.indexOf('Tawk_API') !== -1) {
                scriptEls[j].parentNode.removeChild(scriptEls[j]);
            }
        }

        // Ensure bookmark button in reader view is strictly icon-only
        var bookmarkBtns = container.querySelectorAll('.btn-bookmark-toggle, .reader-bookmark-btn');
        for (var k = 0; k < bookmarkBtns.length; k++) {
            var btn = bookmarkBtns[k];
            var childNodes = Array.prototype.slice.call(btn.childNodes);
            for (var m = 0; m < childNodes.length; m++) {
                var node = childNodes[m];
                if (node.nodeType === 3 /* TEXT_NODE */ || (node.nodeType === 1 && node.tagName === 'SPAN')) {
                    btn.removeChild(node);
                }
            }
        }
    }

    // Set up MutationObserver on #display_content once it exists
    function observeDisplayContent() {
        var el = document.getElementById('display_content');
        if (!el) return;
        var observer = new MutationObserver(function(mutations) {
            for (var i = 0; i < mutations.length; i++) {
                if (mutations[i].addedNodes.length > 0) {
                    stripStandaloneFromContainer(el);
                    break;
                }
            }
        });
        observer.observe(el, { childList: true });
    }

    // Also observe split panel bodies
    function observeSplitPanels() {
        var panels = document.querySelectorAll('.split-panel-body');
        panels.forEach(function(panel) {
            var observer = new MutationObserver(function(mutations) {
                for (var i = 0; i < mutations.length; i++) {
                    if (mutations[i].addedNodes.length > 0) {
                        stripStandaloneFromContainer(panel);
                        break;
                    }
                }
            });
            observer.observe(panel, { childList: true });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            observeDisplayContent();
            observeSplitPanels();
        });
    } else {
        observeDisplayContent();
        observeSplitPanels();
    }

    // Expose for manual use if needed
    window.stripStandaloneFromContainer = stripStandaloneFromContainer;
    window.observeDisplayContent = observeDisplayContent;
})();

window.resetReaderScroll = function(panel) {
    if (panel) {
        var pBody = document.getElementById('bodyPanel' + panel);
        if (pBody) pBody.scrollTop = 0;
        var sPanel = document.querySelector('#splitPanel' + panel + ' .split-panel-body');
        if (sPanel) sPanel.scrollTop = 0;
    }
    var scrollTargets = [
        document.querySelector('.workspace-body'),
        document.getElementById('display_content'),
        document.querySelector('.reader-container'),
        document.getElementById('v-pills-profile'),
        document.querySelector('.expanded-container'),
        document.querySelector('.main-content-area'),
        document.querySelector('.split-panel-body')
    ];
    scrollTargets.forEach(function(el) {
        if (el) {
            el.scrollTop = 0;
        }
    });
    if (window.jQuery) {
        window.jQuery('.workspace-body, .reader-container, #display_content, .split-panel-body, html, body').scrollTop(0);
    } else {
        window.scrollTo(0, 0);
    }
    if (typeof updateReadingProgress === 'function') {
        updateReadingProgress();
    }
};

$(document).on('click', '.previous_content_act, .next_content_act, .previous_constitutional_acts, .next_constitutional_acts, .previous_executive_acts, .next_executive_acts, .plain_previous_content_act, .plain_next_content_act, .displayed_previous_next, .previous_content_pre_act, .next_content_pre_act, .previous_content_constitution_act, .next_content_constitution_act, .previous_content_constitution_amended_act, .next_content_constitution_amended_act, .previous_content_regulation, .next_content_regulation, .previous_content_amendments, .next_content_amendments, .constitution_content_link, .pre_content_link, .content_link, .amendments_content_link, .regulation_content_link, .constitution_amended_content_link, .amended_regulation_content_link, .constitution_preamble_link, .pre_preamble_content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link', function() {
    if (typeof resetReaderScroll === 'function') {
        resetReaderScroll();
    }
});

// TOGGLE DISPLAY BETWEEN REGULATION PREAMBLE AND REGULATION CONTENT
$(document).ready(function(){
        
    var gsid = 0; 
    var psid = 0, nsid = 0;

    $(".open").on("click", function() {
        $(".popup-overlay").addClass("active");
      });

    $(".close").on("click", function() {
        $(".popup-overlay").removeClass("active");
    });

  $('.previous_next_hidden_show').hide();
  $('.tabPanedHide_amendments').hide();
  $('.tabPanedHide_amendments_table').hide();
  $('.tabPanedHide_amendments_content').hide();
  $('.tabPanedHide_regulations').hide();
  $('.tabPanedHide_regulations_table').hide();
  $('.tabPanedHide_regulations_content').hide();
  $('.tabPanedHide_acts_content').hide();
  $('.tabPanedHide_expanded_view').hide();


  //-------------------------New changing background colors
  // Default table of content color
  $('.tabPaned_table_of_table_color').css("background-color","#f5f5f5");
  $('.tabPaned_table_of_table_color').css("border",".1px solid #ddd");
  $('.tabPaned_table_of_table_color').css("color","blue");

  //click table of content tab
  $(".tabPaned_table_of_table_color").click(function(){
    $('.tabPaned_table_of_table_color').css("background-color","#f5f5f5");
    $('.tabPaned_table_of_table_color').css("border",".1px solid #ddd");
    $('.tabPaned_table_of_table_color').css("color","blue");
    //color change on other tabs
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click section link
  $(".content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link, .pre_content_link, .pre_preamble_content_link, .constitution_preamble_link, .regulation_content_link, .amendments_content_link, .tabPanedHide_acts_content, .preamble_link").click(function(){
    $('.tabPanedHide_acts_content').css("background-color","#f5f5f5");
    $('.tabPanedHide_acts_content').css("border",".1px solid #ddd");
    $('.tabPanedHide_acts_content').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click expanded link
  $(".expanded_link, .tabPanedHide_expanded_view").click(function(){
    $('.tabPanedHide_expanded_view').css("background-color","#f5f5f5");
    $('.tabPanedHide_expanded_view').css("border",".1px solid #ddd");
    $('.tabPanedHide_expanded_view').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click all amendments link from related Acts
  $(".all_amendments_link, .tabPanedHide_amendments").click(function(){
    $('.tabPanedHide_amendments').css("background-color","#f5f5f5");
    $('.tabPanedHide_amendments').css("border",".1px solid #ddd");
    $('.tabPanedHide_amendments').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click all amendments link from related Acts
  $(".amended_link, .amended_for_regulation_link, .tabPanedHide_amendments_table").click(function(){
    $('.tabPanedHide_amendments_table').css("background-color","#f5f5f5");
    $('.tabPanedHide_amendments_table').css("border",".1px solid #ddd");
    $('.tabPanedHide_amendments_table').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click amended section link to move to it's content display
  $(".sinlge_amended_act_content_link, .single_amendments_to_regulation_link, .tabPanedHide_amendments_content").click(function(){
    $('.tabPanedHide_amendments_content').css("background-color","#f5f5f5");
    $('.tabPanedHide_amendments_content').css("border",".1px solid #ddd");
    $('.tabPanedHide_amendments_content').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
  });
















  //For the table of content tab color on document ready
  $('.tabPaned_color_table_of_table').css("background-color","#f5f5f5");
  $('.tabPaned_color_table_of_table').css("border-color","#ddd");
  $('.tabPaned_color_table_of_table').css("color","black");

  //Click to change color for Table of Content
  $(".tabPaned_color_table_of_table").click(function(){
    $('.tabPaned_color_table_of_table').css("background-color","#f5f5f5");
    $('.tabPaned_color_table_of_table').css("color","black");
    //changes in the contents
    $('.bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-table, .bg-color-regulations-contents').css("background-color","white");
    $('.bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-table, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-table, .bg-color-regulations-contents').css({"color" : "black"});
  });

  //Click to change color for Content
  $(".constitution_amended_content_link, .constitution_content_link, .pre_content_link, .pre_preamble_content_link, .constitution_preamble_link, .content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link, .amendments_content_link, .regulation_content_link, .amended_regulation_content_link, .tabPanedHide_acts_content, .preamble_link").click(function(){
    $('.bg-color-content').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-content').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table').css("color","black");
  });

   //Click to change color for Expanded View
   $(".expanded_link, .tabPanedHide_expanded_view").click(function(){
    $('.bg-color-expanded').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-expanded').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-contents').css("color","black");
  });

  //Click to change color for Amendments
  $(".all_amendments_link, .tabPanedHide_amendments").click(function(){
    $('.bg-color-amendments').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-amendments').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table, .bg-color-amendments-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table, .bg-color-amendments-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table, .bg-color-amendments-contents').css("color","black");
  });

  //Click to change color for Amendments Table of Contents
  $(".tabPanedHide_amendments_table").click(function(){
    $('.bg-color-amendments-table').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-amendments-table').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-contents').css("color","black");
  });

  //Click to change color for Amended Contents
  $(".tabPanedHide_amendments_content").click(function(){
    $('.bg-color-amendments-contents').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-amendments-contents').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-table').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-table').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-table').css("color","black");
  });

  //Click to change color for Regulation
  $(".all_regulations_link, .tabPanedHide_regulations").click(function(){
    $('.bg-color-regulations').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-regulations').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table, .bg-color-regulations-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table, .bg-color-regulations-contents').css("color","black");
  });

  //Click to change color for Regulation table of contents
  $(".tabPanedHide_regulations_table").click(function(){
    $('.bg-color-regulations-table').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-regulations-table').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-contents').css("color","black");
  });

  //Click to change color for Regulations Contents
  $(".tabPanedHide_regulations_content").click(function(){
    $('.bg-color-regulations-contents').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-regulations-contents').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-table').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-table').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-table').css("color","black");
  });


  // To toggle print and view options scoped to the clicked button's panel with click-outside auto-close support
  $(document).on('click', '#print_options', function(e){
      e.preventDefault();
      e.stopPropagation();
      const dropdown = $(this).siblings('.menu_options');
      dropdown.slideToggle(200);
      $('.menu_options').not(dropdown).slideUp(150);
  });

  $(document).on('click', function(e) {
      if (!$(e.target).closest('#print_options, .menu_options').length) {
          $('.menu_options').slideUp(150);
      }
  });

    //TOGGLE ALL AMENDMENTS AND REGULATION UNDER AN ACT
    //For all amendments
    function all_amendments_link_toggle() {
            $('.tabPanedHide_regulations').hide();
            $('.tabPanedHide_regulations_table').hide();
            $('.tabPanedHide_regulations_content').hide();
            $('.tabPanedHide_amendments_table').hide();
            $('.tabPanedHide_amendments_content').hide();
            $('.tabPanedHide_amendments').show();
            $('#tabs a[href="#all_amendmentsTab"]').tab('show');
    }

    $(document).on('click','.all_amendments_link', function(e){
        e.preventDefault();
        all_amendments_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) { 
            $("#v-pills-settings-tab").trigger("click");
            $("#all_amendments").html(this.responseText); 
            $("#amend_datatable").DataTable();
        }
    xhr.send();
    });
   

    //For all regulations
   $('#all_regulations_link_toggle').click(function (e) {
    e.preventDefault();
        $('#tabs a[href="#all_regulationsTab"]').tab('show');
        $('.tabPanedHide_amendments').hide();
        $('.tabPanedHide_amendments_table').hide();
        $('.tabPanedHide_amendments_content').hide();
        $('.tabPanedHide_regulations').show();
    });
    
   $('.all_regulations_link').click(function(e){
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    var link = $(this).attr("href");
    xhr.open("GET", link, true);
    xhr.onreadystatechange = function receiveUpdate(e) {
        $("#all_regulations").html(this.responseText);
        $("#regulated_datatable").DataTable();  
    }
    xhr.send();
    });



    //TOGGLE FUNCTION FOR AMENDMENT AND REGULATION
    //For a particular amendment...Toggle to table of content
   function amended_act_toggle() {
        $('#tabs a[href="#amended_table_of_Content_Tab"]').tab('show');
        $('.tabPanedHide_amendments_table').show();
   }
   function act_content_link_toggle()
    {
    $('#tabs a[href="#contentTab"]').tab('show');
    $('.tabPanedHide_acts_content').show();
    }  
    
    // For a particular amendment .....toggle to content
   function amended_act_toggle_content() {
    $('#tabs a[href="#amendmentcontentTab"]').tab('show');
    $('.tabPanedHide_amendments_content').show();
    }

    //for regulation
   function regulation_act_toggle() {
    $('#tabs a[href="#regulated_table_of_Content_Tab"]').tab('show');
    $('.tabPanedHide_regulations_table').show();

    }

   function regulation_act_toggle_content() {
    $('#tabs a[href="#regulatedcontentTab"]').tab('show');
    $('.tabPanedHide_regulations_content').show();
    }


    //for amendments under act
   $(document).on('click','.amended_link', function(e){
        e.preventDefault();
        amended_act_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) { 
            // $("#single_preamble_amended_content").html(""); 
            // $("#single_amended_content").html("");
            // $("#single_view_all_sections_amend").html("");
            // $("#single_container_details_amend").hide();

            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments').css("background-color","white");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments').css("border-color","#ddd");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments').css("color","black");

            // $('.bg-color-amendments-table').css({"backgroundColor" : "#f5f5f5"});
            // $('.bg-color-amendments-table').css({"color" : "black"});
            // $("#v-pills-amendments-content-tab").tab('hide')
            $("#v-pills-amendments-tab").trigger("click");
            $("#amended_table_of_content").html(this.responseText);
        }
    xhr.send();
    });
    
     //for amendments under regulation
   $(document).on('click','.amended_for_regulation_link', function(e){
        e.preventDefault();
        amended_act_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) { 
            // $("#single_preamble_amended_content_for_regulation").html(""); 
            // $("#single_amended_content_for_regulation").html("");
            // $("#single_view_all_sections_amend_for_regulation").html("");
            // $("#single_container_details_amends_under_regulation").hide();
            $("#v-pills-amendments-tab").trigger("click");
            $("#amended_table_of_content").html(this.responseText);
        }
    xhr.send();
    });

    //regulations
    $(document).on('click','.regulated_link', function(e){
        e.preventDefault();
        regulation_act_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html(""); 
            $("#single_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $("#single_container_details_regulation").hide();

            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations').css("background-color","white");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations').css("border-color","#ddd");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations').css("color","black");

            $('.bg-color-regulations-table').css({"backgroundColor" : "#f5f5f5"});
            $('.bg-color-regulations-table').css({"color" : "black"});

            $("#regulated_table_of_content").html(this.responseText);
        }
    xhr.send();
    });

    //for preamble amendment under act
    $(document).on('click','.single_preamble_amended_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {

            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments, .bg-color-amendments-table').css("background-color","white");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments, .bg-color-amendments-table').css("border-color","#ddd");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments, .bg-color-amendments-table').css("color","black");
            
            $('.bg-color-amendments-contents').css({"backgroundColor" : "#f5f5f5"});
            $('.bg-color-amendments-contents').css({"color" : "black"});

            $("#single_preamble_amended_content").html(this.responseText); 
            $("#single_amended_content").html("");
            $("#single_view_all_sections_amend").html("");
            $(".single_container_details_link_amend").trigger("click");
            $(".show li").hide();
        }
        xhr.send();
    });
    
    //for preamble amendment under regulation
    $(document).on('click','.single_preamble_amended_regulation_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html(this.responseText); 
            $("#single_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html("");
            $(".single_container_details_link_amend_regulation").trigger("click");
            $(".show li").hide();
        }
        xhr.send();
    });

    $(document).on('click','.single_preamble_regulation_link', function(e){
        e.preventDefault();
        regulation_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html(this.responseText); 
            $("#single_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $('.single_container_details_link_regulation').trigger("click");
            $(".show li").hide();
        }
        xhr.send();
    });

    //show the hidden for amendments under an act
    $(document).on('click','.single_container_details_link_amend', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_container_details_amend").html(this.responseText);
            $("#single_container_details_amend").show();
            $(".show li").hide();
        }
        xhr.send();
    });
    
     //show the hidden for amendments under an regulation
    $(document).on('click','.single_container_details_link_amend_regulation', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_container_details_amends_under_regulation").html(this.responseText);
            $("#single_container_details_amends_under_regulation").show();
            $(".show li").hide();
        }
        xhr.send();
    });

    $(document).on('click','.single_container_details_link_regulation', function(e){
        e.preventDefault();
        regulation_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_container_details_regulation").html(this.responseText);
            $("#single_container_details_regulation").show(); 
            $(".show li").hide();
        }
        xhr.send();
    });

    //-----------------------------------------------------end
    //GENERAL CONTENT LINK
    // General content click to show on content tab
    $('.content_link_toggle').click(function (e) {
        e.preventDefault();
         $('#tabs a[href="#contentTab"]').tab('show');
    });
    
    $('.view_all_section_link').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });
    
    
    //IMPORTANT FOR THE PREVIOUS AND NEXT--------------------THE STARTING OF THE PREVIOUS AND NEXT-----------------------------
    
    // VIEW ALL SECTIONS FOR THE VARIOUS GROUPS
    
    // General View all section links for post
    $('.view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        setPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");       
        }
        xhr.send();
    });

    // General View all section links for constitutional
    $('.constitutional_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        constitutionalSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });

    // General View all section links for executive
    $('.executive_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        executiveSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });
    
    // General View all section links for pre
    $('.pre_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        preSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");    
        }
        xhr.send();
    });
    
    // General View all section links for constitution
    $('.constitution_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        constitutionSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText); 
            $(".preamble_hide_pre_next").css("display", "block");  
        }
        xhr.send();
    });
    
    // General View all section links for constitution amended
    $('.constitution_amended_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        constitutionAmendedSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });
    
    // General View all section links for regulation
    $('.regulation_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        regulationSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");   
        }
        xhr.send();
    });
    
    // General View all section links for amendments
    $('.amendments_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        amendmentsSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");   
        }
        xhr.send();
    });
    
    //View all single amendments links for amendments under an act
    $(document).on('click','.single_view_all_amendments_section_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        var psid = $(this).attr("sid");
        amendsUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content").html("");
            $("#single_amended_content").html("");
            $("#single_view_all_sections_amend").html(this.responseText);
            $(".show li").show();
        }
        xhr.send();
    });
    
    //View all single amendments links for amendments under an regulation
    $(document).on('click','.single_view_all_amendments_under_regulation_section_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        var psid = $(this).attr("sid");
        amendsUnderRegulationsetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html("");
            $("#single_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html(this.responseText);
            $(".show li").show();
        }
        xhr.send();
    });
    
    //View all single regulation links for regulation under an act
    $(document).on('click','.single_view_all_regulation_section_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        var psid = $(this).attr("sid");
        regulationUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html("");
            $("#single_regulation_content").html("");
            $("#single_view_all_sections_regulation").html(this.responseText);
            $(".show li").show();
        }
        xhr.send();
    });
    //-----------------------------------------------------------------------------------------------------------------
    
    // PREVIOUS AND NEXT BUTTON FOR ACTS
    
    //previous for post act
    $(document).on('click','.previous_content_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        setPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //previous for constitutional instruments
    $(document).on('click','.previous_constitutional_acts', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionalSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //previous for executive instruments
    $(document).on('click','.previous_executive_acts', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        executiveSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    $(document).on('click','.plain_previous_content_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        setPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $(".plain_content_display").html("");
            $(".next_previous_content_display").html(this.responseText);
        }
        xhr.send();
    });

    
    // $(document).on('click','.checking_link', function(e){ 
    //      alert( $(this).attr("href") );
    // });

    $(document).on('click','.displayed_previous_next', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        var psid = $(this).attr("sid");
        setPrevNext(psid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $(".plain_content_display").html("");
            $(".hide_sections").hide();
            $('.previous_next_hidden_show').show();
            $(".next_previous_content_display").html(this.responseText);
        }
        xhr.send();
    });

    

     //previous for pre act
    $(document).on('click','.previous_content_pre_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        preSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                $("#display_preamble").html("");
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
            }
        }
        xhr.send();
    });
    
    //previous for constitution act
    $(document).on('click','.previous_content_constitution_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for constitution amended act
    $(document).on('click','.previous_content_constitution_amended_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionAmendedSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //previous for regulation
    $(document).on('click','.previous_content_regulation', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for amendments
    $(document).on('click','.previous_content_amendments', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendmentsSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for amendments UNDER act
    $(document).on('click','.previous_amended_under_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content").html("");
            $("#single_view_all_sections_amend").html("");
            $("#single_amended_content").html(this.responseText);
        }
        xhr.send();
    });
    
     //previous for amendments UNDER regulation
    $(document).on('click','.previous_amendment_under_regulation', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderRegulationsetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html("");
            $("#single_amended_content_for_regulation").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for regulations UNDER act
    $(document).on('click','.previous_regulation_under_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $("#single_regulation_content").html(this.responseText);
        }
        xhr.send();
    });
    //-------------------------------------------END OF PREVIOUS BUTTON---------------------------------
    //next for post act
    $(document).on('click','.next_content_act', function(e){
         e.preventDefault();
        var ids = $('#act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        setPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //next for constitutional instruments
    $(document).on('click','.next_constitutional_acts', function(e){
        e.preventDefault();
    //    var ids = $('#constitutional_act_contents').val();
       var xhr = new XMLHttpRequest();
       var link = $(this).attr("href");
       constitutionalSetPrevNext(nsid);

       xhr.open("GET", link, true);
       xhr.onreadystatechange = function receiveUpdate(e) {
           $("#display_preamble").html("");
           $("#display_view_all_section").html("");
           $("#display_content").html(this.responseText);
       }
       xhr.send();
   });

    //next for executive instruments
    $(document).on('click','.next_executive_acts', function(e){
        e.preventDefault();
        // var ids = $('#executive_act_contents').val();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        executiveSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    $(document).on('click','.plain_next_content_act', function(e){
        e.preventDefault();
       var ids = $('#act_contplain_next_content_actents').val();

       var xhr = new XMLHttpRequest();
       var link = $(this).attr("href");
       setPrevNext(nsid);

       xhr.open("GET", link, true);
       xhr.onreadystatechange = function receiveUpdate(e) {
           $(".plain_content_display").html("");
           $(".next_previous_content_display").html(this.responseText);
       }
       xhr.send();
   });
    
     //next for pre act
    $(document).on('click','.next_content_pre_act', function(e){
         e.preventDefault();
        var ids = $('#pre_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        preSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                $("#display_preamble").html("");
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
            }
        }
        xhr.send();
    });
    
    
    //next for constitution act
    $(document).on('click','.next_content_constitution_act', function(e){
         e.preventDefault();
        var ids = $('#constitution_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for constitution amended act
    $(document).on('click','.next_content_constitution_amended_act', function(e){
         e.preventDefault();
        var ids = $('#constitution_amended_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionAmendedSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
     //next for regulation
    $(document).on('click','.next_content_regulation', function(e){
         e.preventDefault();
        var ids = $('#regulation_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for amendments
    $(document).on('click','.next_content_amendments', function(e){
         e.preventDefault();
        var ids = $('#amendments_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendmentsSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for amendments UNDER act
    $(document).on('click','.next_amended_under_act', function(e){
         e.preventDefault();
        var ids = $('#amends_under_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderActSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content").html("");
            $("#single_view_all_sections_amend").html("");
            $("#single_amended_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for amendments UNDER regulations
    $(document).on('click','.next_amendment_under_regulation', function(e){
         e.preventDefault();
        var ids = $('#amends_under_regulations_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderRegulationsetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html("");
            $("#single_amended_content_for_regulation").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for regulations UNDER act
    $(document).on('click','.next_regulation_under_act', function(e){
         e.preventDefault();
        var ids = $('#regulation_under_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationUnderActSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $("#single_regulation_content").html(this.responseText);
        }
        xhr.send();
    });
    
    
    // END OF PREVIOUS AND NEXT BUTTON for act--------end of the clicking
    
    //-------------------------------------------THE PROCESS FOR THE PREVIOUS AND NEXT---------------------------------------

    //BUILDING THE FUNCTION FOR THE PREVIOUS AND NEXT

    // BUILDING THE PREVIOUS AND NEXT--------the process for the post act
    function setPrevNext(gsid1){
        var sid = gsid1;       
        var ids = $('#act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
    
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/content/'+aay[previous];
        var nLink = '/new-laws/content/'+aay[next];

        $('.previous_content_act').attr('href', pLink);
        $('.next_content_act').attr('href', nLink);

        // for the plain view

        // var p_Link = '/new-laws/plain-content/'+aay[previous];
        // var n_Link = '/new-laws/plain-content/'+aay[next];

        // var p_Link = '/new-laws/plain-content/'+aay[previous];
        // var n_Link = '/new-laws/plain-content/'+aay[next];
        
        // $('.plain_previous_content_act').attr('href', p_Link);
        // $('.plain_next_content_act').attr('href', n_Link);

    }

    // BUILDING THE PREVIOUS AND NEXT--------the process for the pre act
    function constitutionalSetPrevNext(gsid11){
        var sid = gsid11;       
        var ids = $('#constitutional_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/constitutional-acts/content/'+aay[previous];
        var nLink = '/new-laws/constitutional-acts/content/'+aay[next];
        
        $('.previous_constitutional_acts').attr('href', pLink);
        $('.next_constitutional_acts').attr('href', nLink);

    }

     // BUILDING THE PREVIOUS AND NEXT--------the process for the pre act
     function executiveSetPrevNext(gsid12){
        var sid = gsid12;       
        var ids = $('#executive_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/executive-acts/content/'+aay[previous];
        var nLink = '/new-laws/executive-acts/content/'+aay[next];
        
        $('.previous_executive_acts').attr('href', pLink);
        $('.next_executive_acts').attr('href', nLink);

    }
    
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the pre act
    function preSetPrevNext(gsid2){
        var sid = gsid2;       
        var ids = $('#pre_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/existing-laws/content/'+aay[previous];
        var nLink = '/existing-laws/content/'+aay[next];
        
        $('.previous_content_pre_act').attr('href', pLink);
        $('.next_content_pre_act').attr('href', nLink);

        if (typeof window.highlightActiveTOCItem === 'function') {
            window.highlightActiveTOCItem(gsid2);
        } else if (typeof updateActiveTOCHighlight === 'function') {
            updateActiveTOCHighlight(gsid2);
        }
    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the constitution act
    function constitutionSetPrevNext(gsid3){
        var sid = gsid3;       
        var ids = $('#constitution_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/constitution/Republic/constitution_content/'+aay[previous];
        var nLink = '/constitution/Republic/constitution_content/'+aay[next];
        
        $('.previous_content_constitution_act').attr('href', pLink);
        $('.next_content_constitution_act').attr('href', nLink);

        if (typeof window.highlightActiveConstitutionTOCItem === 'function') {
            window.highlightActiveConstitutionTOCItem(gsid3);
        }
    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the constitution amended act
    function constitutionAmendedSetPrevNext(gsid4){
        var sid = gsid4;       
        var ids = $('#constitution_amended_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/constitution_amended/Republic/constitution_content/'+aay[previous];
        var nLink = '/constitution_amended/Republic/constitution_content/'+aay[next];
        
        $('.previous_content_constitution_amended_act').attr('href', pLink);
        $('.next_content_constitution_amended_act').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the regulation
    function regulationSetPrevNext(gsid5){
        var sid = gsid5;       
        var ids = $('#regulation_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/regulation_act/content/'+aay[previous];
        var nLink = '/new-laws/regulation_act/content/'+aay[next];
        
        $('.previous_content_regulation').attr('href', pLink);
        $('.next_content_regulation').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the amendments
    function amendmentsSetPrevNext(gsid6){
        var sid = gsid6;       
        var ids = $('#amendments_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/amended_acts/content/'+aay[previous];
        var nLink = '/new-laws/amended_acts/content/'+aay[next];
        
        $('.previous_content_amendments').attr('href', pLink);
        $('.next_content_amendments').attr('href', nLink);
    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the amendments UNDER an act
    function amendsUnderActSetPrevNext(gsid7){
        var sid = gsid7;       
        var ids = $('#amends_under_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/amended_act_content/'+aay[previous];
        var nLink = '/new-laws/amended_act_content/'+aay[next];
        
        $('.previous_amended_under_act').attr('href', pLink);
        $('.next_amended_under_act').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the amendments UNDER an regulation
    function amendsUnderRegulationsetPrevNext(gsid8){
        var sid = gsid8;       
        var ids = $('#amends_under_regulations_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/amended_act_regulation_content/'+aay[previous];
        var nLink = '/new-laws/amended_act_regulation_content/'+aay[next];
        
        $('.previous_amendment_under_regulation').attr('href', pLink);
        $('.next_amendment_under_regulation').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the regulation UNDER an act
    function regulationUnderActSetPrevNext(gsid9){
        var sid = gsid9;       
        var ids = $('#regulation_under_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/new-laws/regulations_content/'+aay[previous];
        var nLink = '/new-laws/regulations_content/'+aay[next];
        
        $('.previous_regulation_under_act').attr('href', pLink);
        $('.next_regulation_under_act').attr('href', nLink);

    }
    
    //---------------------------------------PREVIOUS AND NEXT FOR THE PARTS AND SECTION-----------------------------------
    
    //FOR POST
    $(document).on('click','.content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        //set previous and next function
        gsid = $(this).attr("sid"); 
        setPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");
        }
        xhr.send();
    });

    //FOR Constitutional Instruments
    $(document).on('click','.constitutional_content_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionalSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //FOR Executive Instruments
    $(document).on('click','.executive_content_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        executiveSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION
    //FOR PRE
    $(document).on('click','.pre_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href"); 

        //set previous and next function
        gsid = $(this).attr("sid"); 
        preSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                $("#v-pills-profile-tab").trigger("click");
                $(".preamble_hide_pre_next").css("display", "block"); 
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
                if (typeof window.highlightActiveTOCItem === 'function') {
                    window.highlightActiveTOCItem(gsid);
                } else if (typeof updateActiveTOCHighlight === 'function') {
                    updateActiveTOCHighlight(gsid);
                }
            }
        }
        xhr.send();
    });

    $(document).on('click','.pre_preamble_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        preSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                // $("#display_preamble").html("");
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                $("#v-pills-profile-tab").trigger("click");
                $(".preamble_hide_pre_next").css("display", "none");            
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
            }
        }
        xhr.send();
    });

    $(document).on('click','.post_preamble_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        setPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });

    $(document).on('click','.amendments_preamble_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendmentsSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });

    $(document).on('click','.regulation_preamble_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        regulationSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });
    
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR CONSTITUTION
    $(document).on('click','.constitution_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block"); 
        }
        xhr.send();
    });

    $(document).on('click','.constitution_preamble_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDED CONSTITUTION
    $(document).on('click','.constitution_amended_content_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionAmendedSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR REGULATIONS
    $(document).on('click','.regulation_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        //set previous and next function
        gsid = $(this).attr("sid"); 
        regulationSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDMENTS
    $(document).on('click','.amendments_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendmentsSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDMENTS UNDER AN ACT
    $(document).on('click','.sinlge_amended_act_content_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendsUnderActSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {

            // $("#single_preamble_amended_content").html("");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table').css("background-color","white");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table').css("border-color","#ddd");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table').css("color","black");
            
            // $('.bg-color-amendments-contents').css({"backgroundColor" : "#f5f5f5"});
            // $('.bg-color-amendments-contents').css({"color" : "black"});
            // $('.single_container_details_link_amend').trigger("click");
            $("#single_amended_content").html(this.responseText);
            $("#single_view_all_sections_amend").html("");
            $("#v-pills-amendments-content-tab").trigger("click");
            $(".show li").show();
            
        }
        xhr.send();
    }); 
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDMENTS UNDER AN REGULATION
    $(document).on('click','.single_amendments_to_regulation_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendsUnderRegulationsetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#single_preamble_amended_content_for_regulation").html(""); 
            // $('.single_container_details_link_amend_regulation').trigger("click");
            $("#single_amended_content").html(this.responseText);
            $("#single_view_all_sections_amend").html("");
            $("#v-pills-amendments-content-tab").trigger("click");
            $(".show li").show();
            
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR REGULATIONS UNDER AN ACT
    $(document).on('click','.sinlge_regulation_act_content_link', function(e){
        e.preventDefault();
        regulation_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        //set previous and next function
        gsid = $(this).attr("sid"); 
        regulationUnderActSetPrevNext(gsid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html(""); 

            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table').css("background-color","white");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table').css("border-color","#ddd");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table').css("color","black");

            $('.bg-color-regulations-contents').css({"backgroundColor" : "#f5f5f5"});
            $('.bg-color-regulations-contents').css({"color" : "black"});

            $("#single_regulation_content").html(this.responseText);
            $("#single_view_all_sections_regulation").html("");
            $('.single_container_details_link_regulation').trigger("click");
            $(".show li").show();
        }
        xhr.send();
    }); 
    
    //-----------------------------------------------------------------------------------------------------end of the process for act 







    // DISPLAY PREAMBLE AND CONTENT IN TAB
    //Acts preamble
    // $('.act_preamble_link').click(function(e){
    //     e.preventDefault();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#act_content").html("");
    //         $("#view_acts_section").html("");
    //         $("#act_preamble").html(this.responseText);  

    //         $("#display_content").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_preamble").html(this.responseText);
    //     }
    //     xhr.send();
    // });

    //EXPANDED VIEW
    $('.expanded_link').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#v-pills-messages-tab").trigger("click");
            $("#acts_expanded_view").html(this.responseText);
        }
        xhr.send();
    });
    
    //New
    $('#expanded_link_toggle_all_pre1992_preview_1').click(function (e) {
        e.preventDefault();
        $('#tabs a[href="#expandedTab"]').tab('show');
        $('.tabPanedHide_expanded_view').show();
    });
    $('#expanded_link_toggle_all_pre1992_preview_2').click(function (e) {
        e.preventDefault();
        $('#tabs a[href="#expandedTab"]').tab('show');
        $('.tabPanedHide_expanded_view').show();
    });

    $('.toggle_expanded_view').click(function (e) {
        e.preventDefault();
        $('#tabs a[href="#expandedTab"]').tab('show');
        $('.tabPanedHide_expanded_view').show();
    });



    //GENERAL PREAMBLE LINK
    // General Preamble link: Click and go to Display Preamble at Content
    $('.preamble_link').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //---------------------------------------IMPORTANT FOR THE PREVIOUS AND NEXT-----------THE BEGINNING----FROM THE PARTS AND SECTIONS
    //GENERAL CONTENT LINK
    // General content link: Click and go to Display section at Content for post 
    // $('.content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText); 
    //     }
    //     xhr.send();
    // });

    $('.constitutional_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });

    $('.executive_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });
    
    // General content link: Click and go to Display section at Content for pre
    // $('.pre_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
    //         $(".preamble_hide_pre_next").css("display", "block");            
    //     }
    //     xhr.send();
    // });

    // General content link: Click and go to Display section at Content for pre
    // $('.pre_preamble_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
    //         $(".preamble_hide_pre_next").css("display", "none");            
    //     }
    //     xhr.send();
    // });
    
    // General content link: Click and go to Display section at Content for constitution
    // $('.constitution_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
            
    //     }
    //     xhr.send();
    // });
    
    // General content link: Click and go to Display section at Content for amended constitution
    $('.constitution_amended_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });
    
    // General content link: Click and go to Display section at Content for regulation
    // $('.regulation_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
            
    //     }
    //     xhr.send();
    // });
    
    // General content link: Click and go to Display section at Content for amendments
    // $('.amendments_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
            
    //     }
    //     xhr.send();
    // });

    // General content link: Click and go to Display section at Content for amendments on regulation
    $('.amended_regulation_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });
    
    //GENERAL PREVIOUS AND NEXT SHOW/HIDE
    // hide next and previous for General preamble and content
    $(".preamble_link").click(function(){
        $(".show li").hide();
    });
    $(".content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link, .pre_content_link,.pre_preamble_content_link, .constitution_preamble_link, .constitution_content_link,.constitution_amended_content_link,.amendments_content_link, .amended_regulation_content_link,.regulation_content_link, .view_all_section_link").click(function(){
        $(".show li").show();
    });
    //----------------------------------------------------IMPORTANT FOR THE PREVIOUS AND NEXT----------THE END

    //click to scroll to top
    $("[data-scroll-to]").click(function() {
      var $this = $(this),
      $toElement      = $this.attr('data-scroll-to'),
      $focusElement   = $this.attr('data-scroll-focus'),
      $offset         = $this.attr('data-scroll-offset') * 1 || 0,
      $speed          = $this.attr('data-scroll-speed') * 1 || 500;

      $('html, body').animate({
        scrollTop: $($toElement).offset().top + $offset
      }, $speed);
  
      if ($focusElement) $($focusElement).focus();
    });

     // FILTERING CONSTITUTION----------------------------------------------------
    /* For all Constitution */
    $('#all_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_constitution_filter_year").val();
        var country     = $(".all_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/filter/'+year+'/'+country;
    });

    /* For all Africa Countries */
    $('#africa_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".africa_constitution_filter_year").val();
        var country     = $(".africa_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/1/africa/filter/'+year+'/'+country;
    });

    /* For all Asia Countries */
    $('#asia_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".asia_constitution_filter_year").val();
        var country     = $(".asia_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/2/asia/filter/'+year+'/'+country;
    });

    /* For all Europe Countries */
    $('#europe_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".europe_constitution_filter_year").val();
        var country     = $(".europe_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/3/europe/filter/'+year+'/'+country;
    });

    /* For all North America Countries */
    $('#north_america_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".north_america_constitution_filter_year").val();
        var country     = $(".north_america_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/4/north_america/filter/'+year+'/'+country;
    });

    /* For all North America Countries */
    $('#south_america_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".south_america_constitution_filter_year").val();
        var country     = $(".south_america_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/5/south_america/filter/'+year+'/'+country;
    });

    // FILTERING POST-1992 LEGISLATION----------------------------------------------------
    /* For All New Laws */
    $('#all_post_1992_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_post_1992_legislation_filter_year").val();
        var category     = $(".all_post_1992_legislation_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/new-laws/filter/'+year+'/'+category;
    });

    /* For Acts of Parliament */
    $('#acts_of_parliament_filter').click(function(e){
        e.preventDefault();
        var year        = $(".acts_of_parliament_filter_year").val();
        var category     = $(".acts_of_parliment_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/new-laws/1/filter/'+year+'/'+category;
    });

    /* For Legislative Instruments */
    $('#legislative_instrument_filter').click(function(e){
        e.preventDefault();
        var year        = $(".legislative_instrument_filter_year").val();
        var category     = $(".legislative_instrument_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/new-laws/2/filter/'+year+'/'+category;
    });

    /* For Amendments */
    $('#amendments_filter').click(function(e){
        e.preventDefault();
        var year        = $(".amendments_filter_year").val();
        var category     = $(".amendments_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/new-laws/3/filter/'+year+'/'+category;
    });

    // FILTERING PRE-1992 LEGISLATION----------------------------------------------------
    /* For Existing Laws */
    $('#all_pre_1992_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_pre_1992_legislation_filter_year").val();
        var category     = $(".all_pre_1992_legislation_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/filter/'+year+'/'+category;
    });

    /* For all first republic*/
    $('#first_republic_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".first_republic_filter_year").val();
        var category     = $(".first_republic_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/1/filter/'+year+'/'+category;
    });

    /* For all second republic*/
    $('#second_republic_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".second_republic_filter_year").val();
        var category     = $(".second_republic_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/2/filter/'+year+'/'+category;
    });

    /* For all third republic*/
    $('#third_republic_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".third_republic_filter_year").val();
        var category     = $(".third_republic_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/3/filter/'+year+'/'+category;
    });

    /* PNDC Law*/
    $('#pndc_law_filter').click(function(e){
        e.preventDefault();
        var year        = $(".pndc_law_filter_year").val();
        var category     = $(".pndc_law_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/4/filter/'+year+'/'+category;
    });

    /* NLC Decree*/
    $('#nlc_decree_filter').click(function(e){
        e.preventDefault();
        var year        = $(".nlc_decree_filter_year").val();
        var category     = $(".nlc_decree_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/5/filter/'+year+'/'+category;
    });

    /* NRC Decree*/
    $('#nrc_decree_filter').click(function(e){
        e.preventDefault();
        var year        = $(".nrc_decree_filter_year").val();
        var category     = $(".nrc_decree_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/6/filter/'+year+'/'+category;
    });

    /* SMC Decree*/
    $('#smc_decree_filter').click(function(e){
        e.preventDefault();
        var year        = $(".smc_decree_filter_year").val();
        var category     = $(".smc_decree_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/existing-laws/7/filter/'+year+'/'+category;
    });

    // FILTERING LAW JUDGMENTS-----------------------------------------------------------
    /* For all Foreign Law Judgments */
    $('#all_foreign_judgment_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_judgment_filter_year").val();
        var country    = $(".all_judgment_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/judgement/Foreign/filter/'+year+'/'+country;
    });

    /* For Africa Court */
    $('#africa_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".africa_court_filter_year").val();
        var country     = $(".africa_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/1/africa-court/filter/'+year+'/'+country;
    });

    /* For Asia Court */
    $('#asia_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".asia_court_filter_year").val();
        var country     = $(".asia_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/2/asia-court/filter/'+year+'/'+country;
    });

    /* For Europe Court */
    $('#europe_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".europe_court_filter_year").val();
        var country     = $(".europe_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/3/europe-court/filter/'+year+'/'+country;
    });

    /* For North America */
    $('#north_america_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".north_america_court_filter_year").val();
        var country     = $(".north_america_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/4/north-america-court/filter/'+year+'/'+country;
    });

    /* For South America */
    $('#south_america_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".south_america_court_filter_year").val();
        var country     = $(".south_america_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/5/south-america-court/filter/'+year+'/'+country;
    });


    /* For all Ghana Law Judgments */
    $('#all_ghana_judgment_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_judgment_filter_year").val();
        var category    = $(".all_judgment_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }        
        window.location.href = '/judgement/Ghana/filter/'+year+'/'+category;
    });

    /* For Supreme Court */
    $('#supreme_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".supreme_court_filter_year").val();
        var category    = $(".supreme_court_filter_category").val();
        
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/1/supreme-court/filter/'+year+'/'+category;
    });

    /* For High Court */
    $('#high_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".high_court_filter_year").val();
        var category    = $(".high_court_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/2/high-court/filter/'+year+'/'+category;
    });
    /* Court of Appeal */
    $('#court_of_appeal_filter').click(function(e){
        e.preventDefault();
        var year        = $(".court_of_appeal_filter_year").val();
        var category    = $(".court_of_appeal_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/3/court-of-appeal/filter/'+year+'/'+category;
    });
    /*Circuit Court*/
    $('#circuit_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".circuit_court_filter_year").val();
        var category    = $(".circuit_court_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/4/circuit-court/filter/'+year+'/'+category;
    });
    /*District Court*/
    $('#district_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".district_court_filter_year").val();
        var category    = $(".district_court_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/5/district-court/filter/'+year+'/'+category;
    });
    //------------------------------------------------------------------------------------------------------
    
    /* For Supreme Court 
    $('#acts_of_parliament_filter').click(function(e){
        e.preventDefault();
        var year        = $(".acts_of_parliament_filter_year").val();
        var id=1;
        var category    = $(".act_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/new-laws/acts_of_parliament/'+id+'/'+year+'/'+category;
    });
    */
    //------------------------------------------------------------------------------------------------------
    /* For the amendment */
    $('#amendment_filter').click(function(e){
        e.preventDefault();
        var year = $(".amendment_filter_year").val();
        var category = $(".amendment_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
       window.location.href = '/new-laws/amendments/'+year+'/'+category;
    }); 
});

// FILTERING FOR LAW JUDGEMENTS
    /* For all law judgements */
    // $('#all_judgement').click(function(e){
    //     e.preventDefault();
    //     var year = $(".judgement_filter_year").val();
    //     var category = $(".judgement_filter_category").val();
    //     if(year === ""){
    //         year = 0;
    //     }
    //     if(category === ""){
    //          category = 0;
    //     }
    //     window.location.href = '/judgement/Ghana/filter/'+year+'/'+category;
    // });

// PAGINATION FOR THE ACCORDION
/* pagination plugin */
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            numbersPerPage: 1,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = $('.pagination');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    var curr = 0;
    pager.data("curr",curr);
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
  
    if (settings.numbersPerPage>1) {
       $('.page_link').hide();
       $('.page_link').slice(pager.data("curr"), settings.numbersPerPage).show();
    }
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
      pager.children().eq(0).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }
        
        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
       
        if (settings.numbersPerPage>1) {
               $('.page_link').hide();
               $('.page_link').slice(page, settings.numbersPerPage+page).show();
        }
      
          pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};

/* end plugin */
$(document).ready(function(){ 
  $('#accordion').pageMe({pagerSelector:'#myPager',childSelector:'.panel',showPrevNext:true,hidePageNumbers:false,perPage:45});   
});

function newFunction() {
    return '.panel-collapse';
}

// Global delegated handler for bookmark button clicks
$(document).on('click', '.btn-bookmark-toggle, .reader-bookmark-btn', function(e) {
    if (typeof window.toggleBookmark === 'function') {
        // toggleBookmark handles guest vs auth check internally
        return;
    }
    // Fallback if toggleBookmark not yet loaded
    if (typeof window.openPremiumGateModal === 'function') {
        e.preventDefault();
        window.openPremiumGateModal('Sign In to Bookmark', 'Create a free account or log in to bookmark sections and organize your legal research.');
    } else if (typeof window.openLoginModal === 'function') {
        e.preventDefault();
        window.openLoginModal();
    }
});


