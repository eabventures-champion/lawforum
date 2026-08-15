{{-- ====== REUSABLE BOOKMARK SYSTEM JAVASCRIPT ====== --}}
<style>
    .btn-bookmark-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #94a3b8;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        vertical-align: middle;
        font-size: 14px;
        position: relative;
        z-index: 10;
    }
    .btn-bookmark-toggle:hover {
        background: rgba(245, 158, 11, 0.15);
        border-color: rgba(245, 158, 11, 0.5);
        color: #f59e0b;
        transform: scale(1.08);
    }
    .btn-bookmark-toggle.is-bookmarked {
        background: rgba(245, 158, 11, 0.18) !important;
        border-color: #f59e0b !important;
        color: #f59e0b !important;
        box-shadow: 0 0 14px rgba(245, 158, 11, 0.3) !important;
    }
    .btn-bookmark-toggle.is-bookmarked i {
        font-weight: 900 !important; /* fa-solid */
        color: #f59e0b !important;
    }

    /* Toast Notification */
    .lf-bookmark-toast {
        position: fixed !important;
        bottom: 30px !important;
        right: 30px !important;
        background: #090e1a !important;
        color: #f8fafc !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        padding: 14px 20px !important;
        border-radius: 12px !important;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.7), 0 0 20px rgba(59, 130, 246, 0.15) !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        z-index: 2147483647 !important;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px) scale(0.95);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
        pointer-events: none;
    }
    .lf-bookmark-toast.show {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) scale(1) !important;
    }
    .lf-bookmark-toast.success { border-color: rgba(245, 158, 11, 0.4) !important; }
    .lf-bookmark-toast.success i { color: #f59e0b !important; font-size: 18px !important; }
    .lf-bookmark-toast.info { border-color: rgba(59, 130, 246, 0.4) !important; }
    .lf-bookmark-toast.info i { color: #60a5fa !important; font-size: 18px !important; }
    .lf-bookmark-toast.error { border-color: rgba(239, 68, 68, 0.4) !important; }
    .lf-bookmark-toast.error i { color: #ef4444 !important; font-size: 18px !important; }
</style>

<div id="lfBookmarkToast" class="lf-bookmark-toast">
    <i class="fa-solid fa-bookmark"></i>
    <span id="lfBookmarkToastMsg">Section bookmarked!</span>
</div>

<script>
(function() {
    window.showBookmarkToast = function(message, type) {
        // Forward to parent or top window if inside iframe
        if (window.parent && window.parent !== window && typeof window.parent.showBookmarkToast === 'function') {
            try {
                window.parent.showBookmarkToast(message, type);
                return;
            } catch(e) {}
        }
        if (window.top && window.top !== window && typeof window.top.showBookmarkToast === 'function') {
            try {
                window.top.showBookmarkToast(message, type);
                return;
            } catch(e) {}
        }

        var toast = document.getElementById('lfBookmarkToast');
        var msgEl = document.getElementById('lfBookmarkToastMsg');
        if (!toast || !msgEl) {
            if (typeof showToast === 'function') {
                showToast(message, type === 'success' ? 'success' : 'info');
            }
            return;
        }

        toast.className = 'lf-bookmark-toast ' + (type || 'success');
        msgEl.textContent = message;

        var icon = toast.querySelector('i');
        if (icon) {
            if (type === 'error') icon.className = 'fa-solid fa-circle-exclamation';
            else if (type === 'info') icon.className = 'fa-solid fa-circle-info';
            else icon.className = 'fa-solid fa-bookmark';
        }

        toast.classList.add('show');
        clearTimeout(window._lfBookmarkToastTimer);
        window._lfBookmarkToastTimer = setTimeout(function() {
            toast.classList.remove('show');
        }, 3200);
    };

    window.triggerGuestGateForBookmark = function() {
        if (window.top && window.top !== window && typeof window.top.openLoginModal === 'function') {
            window.top.openLoginModal();
            return;
        }
        if (window.parent && window.parent !== window && typeof window.parent.openLoginModal === 'function') {
            window.parent.openLoginModal();
            return;
        }
        if (typeof openLoginModal === 'function') {
            openLoginModal();
            return;
        }
        if (window.top && window.top !== window && typeof window.top.openSignUpOptionsModal === 'function') {
            window.top.openSignUpOptionsModal();
            return;
        }
        if (window.parent && window.parent !== window && typeof window.parent.openSignUpOptionsModal === 'function') {
            window.parent.openSignUpOptionsModal();
            return;
        }
        if (typeof openSignUpOptionsModal === 'function') {
            openSignUpOptionsModal();
            return;
        }
        window.location.href = '/login';
    };

    window.toggleBookmark = function(btnEl, options) {
        if (!btnEl) return;

        // Prevent duplicate simultaneous requests
        if (btnEl.getAttribute('data-busy') === '1') return;
        btnEl.setAttribute('data-busy', '1');

        @guest
            btnEl.removeAttribute('data-busy');
            triggerGuestGateForBookmark();
            return;
        @endguest

        var isAuth = {{ auth()->check() ? 'true' : 'false' }};
        if (!isAuth) {
            btnEl.removeAttribute('data-busy');
            triggerGuestGateForBookmark();
            return;
        }

        options = options || {};
        var actTitle = options.act_title || btnEl.getAttribute('data-act-title') || $('.current-doc-title span:last-child').text().trim() || document.title || 'Legal Document';
        var actSection = options.act_section || btnEl.getAttribute('data-act-section') || 'Section';
        var sectionId = options.section_id || btnEl.getAttribute('data-section-id') || 0;
        var actId = options.act_id || btnEl.getAttribute('data-act-id') || 0;
        var actGroup = options.act_group || btnEl.getAttribute('data-act-group') || 'General';
        var docType = options.document_type || btnEl.getAttribute('data-doc-type') || 'legislation';
        var pageUrl = options.page_url || btnEl.getAttribute('data-page-url') || (window.location.pathname + window.location.hash);

        var csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        var icon = btnEl.querySelector('i');
        if (icon) {
            icon.className = 'fa-solid fa-spinner fa-spin';
        }

        $.ajax({
            url: '/bookmarks/toggle',
            type: 'POST',
            timeout: 10000,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: {
                _token: csrfToken,
                act_title: actTitle,
                act_section: actSection,
                section_id: sectionId,
                act_id: actId,
                act_group: actGroup,
                document_type: docType,
                page_url: pageUrl
            },
            success: function(res) {
                btnEl.removeAttribute('data-busy');
                if (res && res.success) {
                    if (res.bookmarked) {
                        btnEl.classList.add('is-bookmarked');
                        if (icon) icon.className = 'fa-solid fa-bookmark';
                        showBookmarkToast(res.message || 'Section bookmarked successfully!', 'success');
                    } else {
                        btnEl.classList.remove('is-bookmarked');
                        if (icon) icon.className = 'fa-regular fa-bookmark';
                        showBookmarkToast(res.message || 'Bookmark removed.', 'info');
                    }

                    // Update sidebar bookmarks badge
                    if (typeof res.count !== 'undefined') {
                        updateSidebarBookmarksCount(res.count);
                    }
                } else if (res && res.guest) {
                    if (icon) icon.className = 'fa-regular fa-bookmark';
                    triggerGuestGateForBookmark();
                } else {
                    if (icon) icon.className = 'fa-regular fa-bookmark';
                    showBookmarkToast(res ? res.message : 'Action failed.', 'error');
                }
            },
            error: function(xhr) {
                btnEl.removeAttribute('data-busy');
                if (icon) icon.className = 'fa-regular fa-bookmark';
                if (xhr && xhr.status === 401) {
                    triggerGuestGateForBookmark();
                } else {
                    showBookmarkToast('Unable to update bookmark. Please try again.', 'error');
                }
            }
        });
    };

    window.updateSidebarBookmarksCount = function(newCount) {
        var updateBadgesInDoc = function(doc) {
            if (!doc) return;
            var badges = doc.querySelectorAll('.sidebar-menu a[href*="/accounts/bookmarks"] .menu-badge');
            badges.forEach(function(b) {
                if (newCount > 0) {
                    b.textContent = newCount;
                    b.style.display = 'inline-block';
                } else {
                    b.style.display = 'none';
                }
            });
        };

        updateBadgesInDoc(document);

        if (window.parent && window.parent !== window) {
            try {
                updateBadgesInDoc(window.parent.document);
            } catch(e) {}
        }
        if (window.top && window.top !== window) {
            try {
                updateBadgesInDoc(window.top.document);
            } catch(e) {}
        }
    };

    // Auto-check active bookmarks on load
    window.checkActiveBookmarks = function(options) {
        @guest return; @endguest

        options = options || {};
        var csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        $.ajax({
            url: '/bookmarks/check',
            type: 'GET',
            data: options,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res && res.bookmarked_section_ids) {
                    res.bookmarked_section_ids.forEach(function(sid) {
                        var btns = document.querySelectorAll('.btn-bookmark-toggle[data-section-id="' + sid + '"]');
                        btns.forEach(function(btn) {
                            btn.classList.add('is-bookmarked');
                            var icon = btn.querySelector('i');
                            if (icon) icon.className = 'fa-solid fa-bookmark';
                        });
                    });
                }
            }
        });
    };

    // Legacy handler shim for old .bookmarking anchors only
    $(document).on('click', '.bookmarking', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var el = this;

        @guest
            triggerGuestGateForBookmark();
            return;
        @endguest

        var title = $(el).data('act-title') || $(el).attr('data-act-title') || $('.current-doc-title span:last-child').text().trim() || $('h1, h2, h3').first().text().trim() || document.title;
        var section = $(el).data('act-section') || $(el).attr('data-act-section') || $(el).closest('.nav-links, .article-card, .judgement_display, .panel').find('.nav-title-text, h3, h4, h2, span').first().text().trim() || 'Section';
        var sid = $(el).data('section-id') || $(el).attr('data-section-id') || $(el).closest('[data-sid]').data('sid') || 0;
        var actId = $(el).data('act-id') || $(el).attr('data-act-id') || 0;
        var group = $(el).data('act-group') || $(el).attr('data-act-group') || 'General';
        var docType = $(el).data('doc-type') || $(el).attr('data-doc-type') || 'legislation';
        var pageUrl = $(el).data('page-url') || $(el).attr('data-page-url') || (window.location.pathname + window.location.hash);

        toggleBookmark(el, {
            act_title: title,
            act_section: section,
            section_id: sid,
            act_id: actId,
            act_group: group,
            document_type: docType,
            page_url: pageUrl
        });
    });
})();
</script>
