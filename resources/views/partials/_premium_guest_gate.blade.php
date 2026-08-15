{{-- ====== PREMIUM GUEST UPGRADE MODAL & 10% SCROLL GATE ====== --}}
@guest
<style>
    .notes-section, #notesSection, .notes-section-header,
    #btnViewSplit, #v-pills-split-tab, .tabPanedHide_split_view,
    a[onclick*="selectViewMode('split')"], button[onclick*="selectViewMode('split')"],
    .dropdown-item[onclick*="selectViewMode('split')"],
    .sidebar-divider, .sidebar-view-modes-divider,
    .premium-details-card, .premium-filter-card {
        display: none !important;
    }

    .premium-gate-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 2147483647 !important;
        background: rgba(6, 10, 19, 0.88);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.4s ease;
    }

    .premium-gate-modal-backdrop.active {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
    }

    .premium-gate-modal {
        background: #0c1220;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        max-width: 500px;
        width: 100%;
        padding: 36px 32px;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.9), 0 0 50px rgba(59, 130, 246, 0.15);
        text-align: center;
        position: relative;
        transform: translateY(24px) scale(0.96);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        color: #f1f5f9;
        filter: none !important;
    }

    .premium-gate-modal-backdrop.active .premium-gate-modal {
        transform: translateY(0) scale(1);
    }

    .premium-gate-close {
        position: absolute;
        top: 18px;
        right: 18px;
        background: rgba(255, 255, 255, 0.08);
        border: none;
        color: #94a3b8;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
    }

    .premium-gate-close:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }

    .premium-gate-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
        border: 1px solid rgba(59, 130, 246, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        color: #60a5fa;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);
    }

    .premium-gate-title {
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 10px;
        letter-spacing: -0.3px;
    }

    .premium-gate-desc {
        font-size: 14px;
        color: #94a3b8;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .premium-gate-roles {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 16px;
    }

    .premium-role-btn {
        display: flex;
        align-items: center;
        padding: 14px 18px;
        border-radius: 14px;
        text-decoration: none !important;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.25s ease;
        border: 1px solid transparent;
    }

    .premium-role-btn.student {
        background: rgba(59, 130, 246, 0.12);
        color: #60a5fa;
        border-color: rgba(59, 130, 246, 0.3);
    }
    .premium-role-btn.student:hover {
        background: rgba(59, 130, 246, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25);
    }

    .premium-role-btn.lawyer {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.3);
    }
    .premium-role-btn.lawyer:hover {
        background: rgba(245, 158, 11, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.25);
    }

    .premium-role-btn.researcher {
        background: rgba(139, 92, 246, 0.12);
        color: #a78bfa;
        border-color: rgba(139, 92, 246, 0.3);
    }
    .premium-role-btn.researcher:hover {
        background: rgba(139, 92, 246, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.25);
    }

    .premium-role-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 16px;
    }
    .student .premium-role-icon { background: rgba(59, 130, 246, 0.25); }
    .lawyer .premium-role-icon { background: rgba(245, 158, 11, 0.25); }
    .researcher .premium-role-icon { background: rgba(139, 92, 246, 0.25); }

    .premium-role-arrow {
        margin-left: auto;
        font-size: 12px;
        opacity: 0.7;
    }

    .premium-escape-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px 18px;
        margin-top: 8px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        color: #94a3b8;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .premium-escape-btn:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.25);
    }

    .content-blurred-by-gate {
        filter: blur(10px) opacity(0.25) !important;
        pointer-events: none !important;
        user-select: none !important;
        transition: filter 0.5s ease-out, opacity 0.5s ease-out !important;
    }

    /* Floating Unlock Notes Feature Widget for Guests */
    .guest-floating-notes-pill {
        position: fixed;
        bottom: 30px;
        right: 24px;
        z-index: 9999;
        display: none;
        opacity: 0;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        background: rgba(15, 23, 42, 0.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(245, 158, 11, 0.45);
        border-radius: 50px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5), 0 0 15px rgba(245, 158, 11, 0.15);
        cursor: pointer;
        transition: opacity 0.3s ease, transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: guestPillFloat 3s infinite ease-in-out alternate;
    }

    @keyframes guestPillFloat {
        0% { transform: translateY(0); }
        100% { transform: translateY(-6px); }
    }

    .guest-floating-notes-pill:hover {
        transform: translateY(-4px) scale(1.03) !important;
        border-color: rgba(245, 158, 11, 0.8) !important;
        box-shadow: 0 16px 40px rgba(245, 158, 11, 0.3) !important;
    }

    .guest-pill-content {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .guest-pill-icon {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(245, 158, 11, 0.18);
        color: #f59e0b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .guest-pill-text {
        color: #fff;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .guest-pill-lock {
        color: #f59e0b;
        font-size: 11px;
    }

    .guest-pill-close {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #94a3b8;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        line-height: 1;
        cursor: pointer;
        margin-left: 4px;
        transition: all 0.2s ease;
    }

    .guest-pill-close:hover {
        color: #fff;
        background: rgba(239, 68, 68, 0.85);
    }
</style>

<div class="premium-gate-modal-backdrop" id="premiumGateModalBackdrop">
    <div class="premium-gate-modal">
        <button class="premium-gate-close" onclick="closePremiumGateModal()" id="premiumGateCloseBtn">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="premium-gate-icon">
            <i class="fa-solid fa-lock"></i>
        </div>

        <h3 class="premium-gate-title" id="premiumGateTitle">Create an Account of Your Choice</h3>
        
        <p class="premium-gate-desc" id="premiumGateDesc">
            Please select your preferred account type below to create an account and enjoy full access tailored to your legal needs.
        </p>

        <div class="premium-gate-roles">
            <a href="/register?role=student" class="premium-role-btn student">
                <span class="premium-role-icon"><i class="fa-solid fa-graduation-cap"></i></span>
                <span>Sign Up as a Student</span>
                <i class="fa-solid fa-chevron-right premium-role-arrow"></i>
            </a>

            <a href="/register?role=lawyer" class="premium-role-btn lawyer">
                <span class="premium-role-icon"><i class="fa-solid fa-gavel"></i></span>
                <span>Sign Up as a Lawyer</span>
                <i class="fa-solid fa-chevron-right premium-role-arrow"></i>
            </a>

            <a href="/register?role=researcher" class="premium-role-btn researcher">
                <span class="premium-role-icon"><i class="fa-solid fa-microscope"></i></span>
                <span>Sign Up as a Researcher</span>
                <i class="fa-solid fa-chevron-right premium-role-arrow"></i>
            </a>
        </div>

        <button class="premium-escape-btn" onclick="returnToStartOfContent()" id="premiumEscapeBtn">
            <i class="fa-solid fa-arrow-up"></i> Return to Start of Content
        </button>
    </div>
</div>



<script>
    (function() {
        if (window._premiumGuestGateScriptLoaded) {
            if (typeof window.resetGateForExpandedView === 'function') {
                window.resetGateForExpandedView();
            }
            return;
        }
        window._premiumGuestGateScriptLoaded = true;

        let scrollLocked = false;
        window._sectionClickModalOpen = false;
        let _userHasScrolledInExpandedView = false;

        window.hideGuestFloatingNotes = function() {
            try {
                sessionStorage.setItem('guestNotesPillDismissed', 'true');
            } catch(e) {}
            const pills = document.querySelectorAll('.guest-floating-notes-pill, #guestFloatingNotesWidget');
            pills.forEach(function(pill) {
                pill.setAttribute('data-dismissed-by-user', 'true');
                pill.style.opacity = '0';
                pill.style.transform = 'scale(0.8)';
                setTimeout(function() { pill.style.display = 'none'; }, 250);
            });
        };

        // Move modal backdrop & floating notes widget directly to <body> on DOM load
        function moveModalToBody() {
            const backdrops = document.querySelectorAll('#premiumGateModalBackdrop');
            if (backdrops.length > 1) {
                for (let i = 1; i < backdrops.length; i++) {
                    backdrops[i].remove();
                }
            }
            const backdrop = document.getElementById('premiumGateModalBackdrop');
            if (backdrop && backdrop.parentNode !== document.body) {
                document.body.appendChild(backdrop);
            }

            const pills = document.querySelectorAll('.guest-floating-notes-pill, #guestFloatingNotesWidget');
            pills.forEach(function(pill) {
                pill.remove();
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', moveModalToBody);
        } else {
            moveModalToBody();
        }

        if (typeof $ !== 'undefined') {
            $(document).ajaxComplete(function() {
                moveModalToBody();
            });
        }

        // Prevent wheel/touch scroll without hiding body scrollbar (zero layout shift)
        function preventScrollEvents(e) {
            if (scrollLocked) {
                e.preventDefault();
            }
        }
        window.addEventListener('wheel', preventScrollEvents, { passive: false });
        window.addEventListener('touchmove', preventScrollEvents, { passive: false });

        const path = window.location.pathname;
        const isConstitution = path.startsWith('/constitution');
        const isHomePage = path === '/';
        const isPublicPage = path.startsWith('/login') || path.startsWith('/register') || path.startsWith('/get-started');

        window.openPremiumGateModal = function(title, message, isScrollLock = false, isSectionClick = false) {
            moveModalToBody();
            const backdrop = document.getElementById('premiumGateModalBackdrop');
            const titleEl = document.getElementById('premiumGateTitle');
            const descEl = document.getElementById('premiumGateDesc');
            const closeBtn = document.getElementById('premiumGateCloseBtn');
            const escapeBtn = document.getElementById('premiumEscapeBtn');

            if (title) titleEl.textContent = title;
            if (message) descEl.textContent = message;

            if (isScrollLock) {
                if (closeBtn) closeBtn.style.display = 'none';
                if (escapeBtn) {
                    escapeBtn.style.display = 'inline-flex';
                    escapeBtn.innerHTML = '<i class="fa-solid fa-arrow-up"></i> Return to Start of Content';
                    escapeBtn.onclick = function() { window.returnToStartOfContent(); };
                }
            } else {
                if (closeBtn) closeBtn.style.display = 'flex';
                if (escapeBtn) {
                    escapeBtn.style.display = 'inline-flex';
                    escapeBtn.innerHTML = '<i class="fa-solid fa-arrow-left"></i> Already have an account? Sign In';
                    escapeBtn.onclick = function() {
                        window.closePremiumGateModal();
                        if (typeof window.openLoginModal === 'function') {
                            window.openLoginModal();
                        }
                    };
                }
            }

            // Track section-click modals so scroll gate and view-mode resets don't close them
            if (isSectionClick) {
                window._sectionClickModalOpen = true;
            }

            if (backdrop) backdrop.classList.add('active');
        };

        window.closePremiumGateModal = function() {
            const backdrop = document.getElementById('premiumGateModalBackdrop');
            if (backdrop) backdrop.classList.remove('active');
            window._sectionClickModalOpen = false;
        };

        window.openSignUpOptionsModal = function(title, message) {
            if (typeof window.closeLoginModal === 'function') {
                window.closeLoginModal();
            }
            const modalTitle = title || 'Create an Account of Your Choice';
            const modalDesc = message || 'Please select your preferred account type below to create an account and enjoy full access tailored to your legal needs.';
            window.openPremiumGateModal(modalTitle, modalDesc, false, true);
        };

        window.returnToStartOfContent = function() {
            scrollLocked = false;
            ignoreGateUntil = Date.now() + 1000; // 1-second grace period while scrolling to top

            window.closePremiumGateModal();

            // Unblur content smoothly
            const blurredElements = document.querySelectorAll('.content-blurred-by-gate');
            blurredElements.forEach(function(el) {
                el.classList.remove('content-blurred-by-gate');
            });

            // Reset progress text indicators to 0%
            const progressEl = document.getElementById('progressPercent');
            const progressFill = document.getElementById('progressFill');
            if (progressEl) progressEl.textContent = '0%';
            if (progressFill) progressFill.style.width = '0%';

            // Immediately scroll window & document bodies to top
            window.scrollTo(0, 0);
            if (document.documentElement) document.documentElement.scrollTop = 0;
            if (document.body) document.body.scrollTop = 0;

            // Scroll all workspace/reader/case containers to top
            const containers = document.querySelectorAll('.main-wrapper-scrollable, .workspace-body, .split-panel-body, #display_content, .reader-container, #display_view_all_section, .reader-content-pane, .judgement_display, #v-pills-messages');
            containers.forEach(function(el) {
                el.scrollTop = 0;
            });
        };

        // Section Click Gate for Existing Laws, New Laws, Case Laws & Search Results (Section 4+)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = link.getAttribute('href') || '';
            const isSectionLinkClass = link.matches('.pre_content_link, .content_link, .regulation_content_link, .constitutional_content_link, .executive_content_link, .amendments_content_link, .amended_regulation_content_link, .sinlge_amended_act_content_link, .sinlge_regulation_act_content_link');
            const isSectionUrl = href.includes('/content/') || href.includes('/content_section/') || href.includes('/content?');

            if (isSectionLinkClass || isSectionUrl) {
                // Check 1: data-section-index attribute (position-based)
                const indexAttr = link.getAttribute('data-section-index');
                let index = indexAttr ? parseInt(indexAttr, 10) : null;

                // Check 2: If no data-section-index, determine position among sibling section links
                if (index === null) {
                    const sectionLinkSelector = '.pre_content_link, .content_link, .regulation_content_link, .constitutional_content_link, .executive_content_link, .amendments_content_link, .amended_regulation_content_link, .sinlge_amended_act_content_link, .sinlge_regulation_act_content_link';
                    const container = link.closest('.sidebar-content, .panel-body, #leftSidebar, .toc-tree, .toc-list, nav, ul, ol') || link.parentElement;
                    if (container) {
                        const allSectionLinks = container.querySelectorAll(sectionLinkSelector);
                        for (let i = 0; i < allSectionLinks.length; i++) {
                            if (allSectionLinks[i] === link) {
                                index = i + 1; // 1-based position
                                break;
                            }
                        }
                    }
                }
                
                let isRestricted = false;

                if (index !== null && index > 3) {
                    isRestricted = true;
                }

                if (isRestricted) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    // Format full section title text
                    const sectionSpan = link.querySelector('span');
                    let sectionTitle = sectionSpan ? sectionSpan.innerText.trim() : linkText;
                    sectionTitle = sectionTitle.replace(/\s+/g, ' ');

                    // Clean up title if it contains pipes from search result subtitles
                    if (sectionTitle.includes('|')) {
                        const parts = sectionTitle.split('|');
                        sectionTitle = parts[parts.length - 1].trim();
                    }

                    openPremiumGateModal(
                        sectionTitle + ' is Locked for Guests',
                        'As a guest, you can access full content for the first 3 sections. Please sign up as a Student, Lawyer, or Researcher to view ' + sectionTitle + ' and all remaining sections.',
                        false,
                        true
                    );
                    return false;
                }
            }
        }, true);

        let ignoreGateUntil = 0;

        window.openNotesGateModal = function() {
            openPremiumGateModal(
                'Create an Account of Your Choice',
                'Please select your preferred account type below as a Student, Lawyer, or Researcher to save personal notes, annotations, and organize your legal research.',
                false,
                true
            );
        };

        function isExpandedViewActive() {
            const path = window.location.pathname;
            if (path.includes('/judgement') || path.includes('/case-law') || path.includes('/case_law') || path.includes('/cases')) {
                // Listing & category search pages (e.g. /judgement/Ghana, /judgement/all-countries) should NOT be restricted on scroll
                const segments = path.split('/').filter(Boolean);
                const lastSegment = segments[segments.length - 1] || '';
                const isNumericCaseId = /^\d+$/.test(lastSegment);

                if (!isNumericCaseId) {
                    return false;
                }
                return true;
            }
            if (path.includes('expanded') || path.includes('expanded-view') || path.includes('expanded_view')) {
                return true;
            }
            if (typeof window.currentViewMode !== 'undefined' && window.currentViewMode === 'expanded') {
                return true;
            }
            const expandedTab = document.getElementById('v-pills-messages-tab') || document.querySelector('a[href="#expandedTab"]');
            if (expandedTab && (expandedTab.classList.contains('active') || expandedTab.getAttribute('aria-selected') === 'true')) {
                return true;
            }
            const expandedPane = document.getElementById('v-pills-messages') || document.getElementById('expandedTab') || document.getElementById('acts_expanded_view');
            if (expandedPane && (expandedPane.classList.contains('active') || expandedPane.classList.contains('show'))) {
                return true;
            }
            return false;
        }

        function resetGateForExpandedView() {
            // Don't reset if a section-click restriction modal is currently open
            if (window._sectionClickModalOpen) return;

            scrollLocked = false;
            _userHasScrolledInExpandedView = false;
            ignoreGateUntil = Date.now() + 5000; // 5-second grace period while tab switches and renders

            // Unblur content
            const blurredElements = document.querySelectorAll('.content-blurred-by-gate');
            blurredElements.forEach(function(el) {
                el.classList.remove('content-blurred-by-gate');
            });
            window.closePremiumGateModal();

            // Reset progress text
            const progressEl = document.getElementById('progressPercent');
            const progressFill = document.getElementById('progressFill');
            if (progressEl) progressEl.textContent = '0%';
            if (progressFill) progressFill.style.width = '0%';

            // Immediately scroll all containers to top
            window.scrollTo(0, 0);
            const containers = document.querySelectorAll('.workspace-body, #v-pills-messages, #display_view_all_section, #display_content, .reader-container, .split-panel-body, .main-wrapper-scrollable, #expandedTab, #acts_expanded_view, #display_country_constitution');
            containers.forEach(function(el) {
                el.scrollTop = 0;
            });
        }
        window.resetGateForExpandedView = resetGateForExpandedView;

        // Track genuine user scroll to enable the reading progress gate
        // This prevents false-positive blur on initial expanded view load
        (function() {
            let scrollDebounce = null;
            function onUserScroll() {
                if (isExpandedViewActive() && !_userHasScrolledInExpandedView) {
                    // Only count as genuine scroll if past grace period
                    if (Date.now() >= ignoreGateUntil) {
                        if (scrollDebounce) clearTimeout(scrollDebounce);
                        scrollDebounce = setTimeout(function() {
                            _userHasScrolledInExpandedView = true;
                        }, 100);
                    }
                }
            }
            window.addEventListener('scroll', onUserScroll, true);
            window.addEventListener('touchmove', function() {
                if (isExpandedViewActive() && Date.now() >= ignoreGateUntil) {
                    _userHasScrolledInExpandedView = true;
                }
            }, true);
        })();

        // Reset scroll gate synchronously when user clicks Expanded View or switches tabs
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[onclick*="selectViewMode"], #v-pills-messages-tab, .toggle_expanded_view, .nav-tab-premium, .sidebar-view-btn, .dropdown-item, .bg-color-expanded, .expanded_link');
            if (btn) {
                resetGateForExpandedView();
                setTimeout(resetGateForExpandedView, 150);
                setTimeout(resetGateForExpandedView, 500);
                setTimeout(resetGateForExpandedView, 1200);
            }
        }, true);

        // Also listen to Bootstrap tab change events
        if (typeof $ !== 'undefined') {
            $(document).on('show.bs.tab shown.bs.tab', '#v-pills-messages-tab, a[href="#v-pills-messages"], a[href="#expandedTab"]', function() {
                resetGateForExpandedView();
                setTimeout(resetGateForExpandedView, 300);
                setTimeout(resetGateForExpandedView, 800);
            });
        }

        // Reading Progress Gate for Existing Laws, New Laws, Case Laws, and Constitution (50% Constitution, 20% Case Laws, 10% Expanded View)
        if (!isHomePage && !isPublicPage) {
            const checkReadingProgressGate = function() {
                // If in grace period, do not evaluate gate
                if (Date.now() < ignoreGateUntil) {
                    return;
                }

                // The reading progress gate applies to Expanded View & Case Laws pages
                if (!isExpandedViewActive()) {
                    if (scrollLocked && !window._sectionClickModalOpen) {
                        scrollLocked = false;
                        const blurredElements = document.querySelectorAll('.content-blurred-by-gate');
                        blurredElements.forEach(function(el) {
                            el.classList.remove('content-blurred-by-gate');
                        });
                        window.closePremiumGateModal();
                    }
                    return;
                }

                const pathSegments = path.split('/').filter(Boolean);
                const lastPathSegment = pathSegments[pathSegments.length - 1] || '';
                const isCaseLawPage = (path.includes('/judgement') || path.includes('/case-law') || path.includes('/case_law') || path.includes('/cases')) && /^\d+$/.test(lastPathSegment);
                
                let targetThreshold = 10;
                if (isConstitution) {
                    targetThreshold = 50;
                } else if (isCaseLawPage) {
                    targetThreshold = 20;
                }

                let currentProgress = 0;

                // Find active scroll container
                const scrollEl = document.querySelector('.main-wrapper-scrollable') || document.querySelector('.workspace-body') || document.querySelector('#display_view_all_section') || document.querySelector('.judgement_display') || document.querySelector('#expandedTab') || document.querySelector('#acts_expanded_view');

                let scrollTop = 0;
                let scrollHeight = 0;
                let clientHeight = 0;

                if (scrollEl && scrollEl.scrollHeight > scrollEl.clientHeight) {
                    scrollTop = scrollEl.scrollTop;
                    scrollHeight = scrollEl.scrollHeight;
                    clientHeight = scrollEl.clientHeight;
                } else {
                    scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
                    scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight || 0;
                    clientHeight = window.innerHeight || document.documentElement.clientHeight || 0;
                }

                const maxScroll = scrollHeight - clientHeight;
                if (maxScroll > 20) {
                    currentProgress = Math.round((scrollTop / maxScroll) * 100);
                }

                // Update reading progress bar text if present
                const progressEl = document.getElementById('progressPercent');
                const progressFill = document.getElementById('progressFill');
                if (progressEl) {
                    progressEl.textContent = currentProgress + '%';
                }
                if (progressFill) {
                    progressFill.style.width = currentProgress + '%';
                }

                // Automatically reset scrollLocked and unblur if user is under target threshold or at top of page
                // But never close a section-click restriction modal (only close scroll-gate modals)
                if ((currentProgress < targetThreshold || scrollTop <= 50) && !window._sectionClickModalOpen) {
                    scrollLocked = false;
                    const blurredElements = document.querySelectorAll('.content-blurred-by-gate');
                    blurredElements.forEach(function(el) {
                        el.classList.remove('content-blurred-by-gate');
                    });
                    window.closePremiumGateModal();
                }

                if (currentProgress >= targetThreshold && !scrollLocked && _userHasScrolledInExpandedView) {
                    scrollLocked = true;

                    // Apply blur to reading containers smoothly
                    const targetElements = document.querySelectorAll('.main-wrapper-scrollable, .container-fluid, .content-wrapper, main, .workspace-body, #display_view_all_section, .reader-container, .judgement_display, #display_country_constitution, #v-pills-messages, #expandedTab, #acts_expanded_view');
                    targetElements.forEach(function(target) {
                        target.classList.add('content-blurred-by-gate');
                    });

                    let modalTitle = 'Reading Limit Reached (10%)';
                    let modalDesc = 'You have reached 10% of this document. Sign up as a Student, Lawyer, or Researcher to continue reading full laws and case judgments.';

                    if (isConstitution) {
                        modalTitle = 'Reading Limit Reached (50%)';
                        modalDesc = 'You have reached 50% of the Constitution document in Expanded View. Sign up as a Student, Lawyer, or Researcher to continue reading full constitutional texts and legal documents.';
                    } else if (isCaseLawPage) {
                        modalTitle = 'Reading Limit Reached (20%)';
                        modalDesc = 'You have reached 20% of this case judgment. Sign up as a Student, Lawyer, or Researcher to continue reading full legal judgments and case laws.';
                    }

                    openPremiumGateModal(modalTitle, modalDesc, true);
                }
            };

            // Run check on fast interval (4x per second)
            setInterval(checkReadingProgressGate, 250);

            // Event listeners
            window.addEventListener('scroll', checkReadingProgressGate, true);
            window.addEventListener('touchmove', checkReadingProgressGate, true);
        }
    })();
</script>
@include('partials._login_modal')
@endguest

