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
</style>

<div class="premium-gate-modal-backdrop" id="premiumGateModalBackdrop">
    <div class="premium-gate-modal">
        <button class="premium-gate-close" onclick="closePremiumGateModal()" id="premiumGateCloseBtn">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="premium-gate-icon">
            <i class="fa-solid fa-lock"></i>
        </div>

        <h3 class="premium-gate-title" id="premiumGateTitle">Unlock Full Legal Access</h3>
        
        <p class="premium-gate-desc" id="premiumGateDesc">
            As a guest, access is limited. Please sign up to view section 4+ and read the full content of laws and case laws.
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
        let scrollLocked = false;

        // Move modal backdrop directly to <body> on DOM load
        function moveModalToBody() {
            const backdrop = document.getElementById('premiumGateModalBackdrop');
            if (backdrop && backdrop.parentNode !== document.body) {
                document.body.appendChild(backdrop);
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', moveModalToBody);
        } else {
            moveModalToBody();
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

        window.openPremiumGateModal = function(title, message, isScrollLock = false) {
            moveModalToBody();
            const backdrop = document.getElementById('premiumGateModalBackdrop');
            const titleEl = document.getElementById('premiumGateTitle');
            const descEl = document.getElementById('premiumGateDesc');
            const closeBtn = document.getElementById('premiumGateCloseBtn');

            if (title) titleEl.textContent = title;
            if (message) descEl.textContent = message;

            if (isScrollLock && closeBtn) {
                closeBtn.style.display = 'none';
            } else if (closeBtn) {
                closeBtn.style.display = 'flex';
            }

            if (backdrop) backdrop.classList.add('active');
        };

        window.closePremiumGateModal = function() {
            const backdrop = document.getElementById('premiumGateModalBackdrop');
            if (backdrop) backdrop.classList.remove('active');
        };

        window.returnToStartOfContent = function() {
            window.closePremiumGateModal();

            // Unblur content smoothly
            const blurredElements = document.querySelectorAll('.content-blurred-by-gate');
            blurredElements.forEach(function(el) {
                el.classList.remove('content-blurred-by-gate');
            });

            // Immediately scroll window to top
            window.scrollTo(0, 0);

            // Scroll all workspace/reader containers to top
            const containers = document.querySelectorAll('.workspace-body, .split-panel-body, #display_content, .reader-container, #display_view_all_section, .reader-content-pane, [style*="overflow"]');
            containers.forEach(function(el) {
                el.scrollTop = 0;
            });

            // Reset progress text indicators if present
            const progressEl = document.getElementById('progressPercent');
            const progressFill = document.getElementById('progressFill');
            if (progressEl) progressEl.textContent = '0%';
            if (progressFill) progressFill.style.width = '0%';

            // Unlock gate so scrolling down to 10% AGAIN will trigger the modal AGAIN
            setTimeout(function() {
                scrollLocked = false;
            }, 300);
        };

        // Section Click Gate for Existing Laws, New Laws, Case Laws & Search Results (Section 4+)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = link.getAttribute('href') || '';
            const isSectionLinkClass = link.matches('.pre_content_link, .content_link, .regulation_content_link, .constitutional_content_link, .executive_content_link, .amendments_content_link, .amended_regulation_content_link, .sinlge_amended_act_content_link, .sinlge_regulation_act_content_link');
            const isSectionUrl = href.includes('/content/') || href.includes('/content_section/') || href.includes('/content?');

            if (isSectionLinkClass || isSectionUrl) {
                // Check 1: data-section-index attribute
                const indexAttr = link.getAttribute('data-section-index');
                let index = indexAttr ? parseInt(indexAttr, 10) : null;

                // Check 2: Parse section/regulation/article number from link text
                const linkText = (link.innerText || link.textContent || '').trim();
                const sectionNumMatch = linkText.match(/(?:Section|Regulation|Article)\s*(\d+)/i);
                
                let isRestricted = false;

                if (index !== null && index > 3) {
                    isRestricted = true;
                } else if (sectionNumMatch && parseInt(sectionNumMatch[1], 10) > 3) {
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
                        'As a guest, you can access full content for the first 3 sections. Please sign up as a Student, Lawyer, or Researcher to view ' + sectionTitle + ' and all remaining sections.'
                    );
                    return false;
                }
            }
        }, true);

        let ignoreGateUntil = 0;

        function isExpandedViewActive() {
            const path = window.location.pathname;
            if (path.includes('expanded') || path.includes('expanded-view') || path.includes('expanded_view')) {
                return true;
            }
            if (typeof window.currentViewMode !== 'undefined' && window.currentViewMode === 'expanded') {
                return true;
            }
            const expandedTab = document.getElementById('v-pills-messages-tab');
            if (expandedTab && (expandedTab.classList.contains('active') || expandedTab.getAttribute('aria-selected') === 'true')) {
                return true;
            }
            const expandedPane = document.getElementById('v-pills-messages');
            if (expandedPane && (expandedPane.classList.contains('active') || expandedPane.classList.contains('show'))) {
                return true;
            }
            return false;
        }

        function resetGateForExpandedView() {
            scrollLocked = false;
            ignoreGateUntil = Date.now() + 1000; // 1-second grace period while tab switches

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
            const containers = document.querySelectorAll('.workspace-body, #v-pills-messages, #display_view_all_section, #display_content, .reader-container, .split-panel-body');
            containers.forEach(function(el) {
                el.scrollTop = 0;
            });
        }

        // Reset scroll gate synchronously when user clicks Expanded View or switches tabs
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[onclick*="selectViewMode"], #v-pills-messages-tab, .toggle_expanded_view, .nav-tab-premium, .sidebar-view-btn, .dropdown-item');
            if (btn) {
                resetGateForExpandedView();
                setTimeout(resetGateForExpandedView, 150);
                setTimeout(resetGateForExpandedView, 400);
            }
        }, true);

        // Also listen to Bootstrap tab change events
        if (typeof $ !== 'undefined') {
            $(document).on('show.bs.tab shown.bs.tab', '#v-pills-messages-tab, a[href="#v-pills-messages"]', function() {
                resetGateForExpandedView();
            });
        }

        // 10% Reading Progress Gate for Existing Laws, New Laws, and Case Laws (Expanded View Only)
        if (!isConstitution && !isHomePage && !isPublicPage) {
            const checkReadingProgressGate = function() {
                // If in grace period, do not evaluate gate
                if (Date.now() < ignoreGateUntil) {
                    return;
                }

                // The 10% reading progress gate is ONLY applicable in Expanded View!
                if (!isExpandedViewActive()) {
                    if (scrollLocked) {
                        scrollLocked = false;
                        const blurredElements = document.querySelectorAll('.content-blurred-by-gate');
                        blurredElements.forEach(function(el) {
                            el.classList.remove('content-blurred-by-gate');
                        });
                        window.closePremiumGateModal();
                    }
                    return;
                }

                let currentProgress = 0;

                // Find active scroll container in Expanded View (.workspace-body or window)
                const scrollEl = document.querySelector('.workspace-body') || document.querySelector('.main-wrapper-scrollable') || document.querySelector('#display_view_all_section');

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
                if (progressEl && isExpandedViewActive()) {
                    progressEl.textContent = currentProgress + '%';
                }
                if (progressFill && isExpandedViewActive()) {
                    progressFill.style.width = currentProgress + '%';
                }

                // Automatically reset scrollLocked if user is at < 10%
                if (currentProgress < 10) {
                    scrollLocked = false;
                }

                if (currentProgress >= 10 && !scrollLocked) {
                    scrollLocked = true;

                    // Apply blur to reading containers smoothly
                    const targetElements = document.querySelectorAll('.main-wrapper-scrollable, .container-fluid, .content-wrapper, main, .workspace-body, #display_view_all_section, .reader-container');
                    targetElements.forEach(function(target) {
                        target.classList.add('content-blurred-by-gate');
                    });

                    openPremiumGateModal(
                        'Reading Limit Reached (10%)',
                        'You have reached 10% of this document. Sign up as a Student, Lawyer, or Researcher to continue reading full laws and case judgments.',
                        true
                    );
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
@endguest
