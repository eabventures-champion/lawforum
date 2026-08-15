<!-- Platform Onboarding & Feature Walkthrough Tour Modal -->
<div id="platformTourModalBackdrop" class="tour-modal-backdrop" style="display: none;">
    <div class="tour-modal-card">
        <!-- Close / Dismiss button -->
        <button type="button" class="tour-modal-close-btn" onclick="closePlatformTour()" title="Close Tour">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Step Indicator Header -->
        <div class="tour-header-bar">
            <div class="tour-badge-pill" id="tourStepBadge">
                <i class="fa-solid fa-compass" style="color: #60a5fa;"></i>
                <span id="tourStepCounter">Step 1 of 6</span>
            </div>
            <div class="tour-progress-dots" id="tourProgressDots">
                <!-- Injected dynamically -->
            </div>
        </div>

        <!-- Main Slide Content -->
        <div class="tour-content-body">
            <div class="tour-icon-halo" id="tourIconContainer">
                <i class="fa-solid fa-wand-magic-sparkles" id="tourMainIcon"></i>
            </div>
            
            <h2 class="tour-title" id="tourStepTitle">Welcome to Legals Forum</h2>
            <p class="tour-description" id="tourStepDescription">Your unified legal workspace for Constitution, Acts of Parliament, Existing Decrees, and Case Judgments.</p>

            <div class="tour-feature-highlight" id="tourFeatureHighlight">
                <div class="tour-highlight-badge">
                    <i class="fa-solid fa-bolt-lightning" style="color: #f59e0b;"></i>
                    <span id="tourHighlightTitle">Key Capability</span>
                </div>
                <div class="tour-highlight-text" id="tourHighlightText">
                    Fast search and intuitive legal navigation across 100+ enactments.
                </div>
            </div>
        </div>

        <!-- Navigation Action Footer -->
        <div class="tour-footer-bar">
            <button type="button" class="tour-btn tour-btn-skip" id="tourBtnSkip" onclick="skipPlatformTour()">
                Skip Tour
            </button>
            <div class="tour-footer-actions">
                <button type="button" class="tour-btn tour-btn-secondary" id="tourBtnPrev" onclick="prevTourStep()" style="display: none;">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back</span>
                </button>
                <button type="button" class="tour-btn tour-btn-primary" id="tourBtnNext" onclick="nextTourStep()">
                    <span>Next</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@php
    $tourSettings = \App\OnboardingTourSetting::getSettings();
    $welcomePromptDesc = str_replace(':name', '<strong>' . e(auth()->user()->name ?? 'User') . '</strong>', e($tourSettings->welcome_description));
@endphp

<!-- Welcome Prompt for First-Time Users -->
<div id="firstTimeWelcomeBackdrop" class="tour-modal-backdrop" style="display: none;">
    <div class="tour-modal-card welcome-prompt-card">
        <div class="tour-icon-halo" style="background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, rgba(29, 78, 216, 0.05) 70%); border-color: rgba(59, 130, 246, 0.4);">
            <i class="fa-solid fa-scale-balanced" style="color: #60a5fa; font-size: 32px;"></i>
        </div>

        <h2 class="tour-title" id="welcomeModalTitle" style="margin-top: 14px;">{{ $tourSettings->welcome_title }}</h2>
        <p class="tour-description" id="welcomeModalDesc" style="max-width: 420px; margin: 0 auto 20px;">
            {!! $welcomePromptDesc !!}
        </p>

        <div style="display: flex; gap: 12px; justify-content: center; width: 100%; flex-wrap: wrap;">
            <button type="button" class="tour-btn tour-btn-secondary" id="welcomeModalBtnSecondary" onclick="dismissFirstTimePrompt(true)" style="padding: 10px 18px;">
                {{ $tourSettings->welcome_btn_secondary }}
            </button>
            <button type="button" class="tour-btn tour-btn-primary" id="welcomeModalBtnPrimary" onclick="startOnboardingTourFromPrompt()" style="padding: 10px 24px;">
                <i class="fa-solid fa-compass mr-1"></i>
                <span>{{ $tourSettings->welcome_btn_primary }}</span>
            </button>
        </div>
    </div>
</div>

<style>
/* ── Platform Tour Styles ─────────────────────────────────────────── */
.tour-modal-backdrop {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 2147483640 !important;
    background: rgba(4, 8, 20, 0.88) !important;
    backdrop-filter: blur(14px) !important;
    -webkit-backdrop-filter: blur(14px) !important;
    display: none !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 20px !important;
    box-sizing: border-box !important;
}

.tour-modal-backdrop.show {
    display: flex !important;
    animation: tourFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes tourFadeIn {
    from { opacity: 0; transform: scale(0.97); }
    to { opacity: 1; transform: scale(1); }
}

.tour-modal-card {
    background: #0f172a !important;
    background: linear-gradient(180deg, #111827 0%, #0b0f19 100%) !important;
    border: 1px solid rgba(255, 255, 255, 0.12) !important;
    border-radius: 20px !important;
    max-width: 520px !important;
    width: 100% !important;
    padding: 28px !important;
    box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.95), 0 0 40px rgba(59, 130, 246, 0.15) !important;
    position: relative !important;
    box-sizing: border-box !important;
    color: #f8fafc !important;
    text-align: center;
}

.welcome-prompt-card {
    padding: 34px 28px !important;
}

.tour-modal-close-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 13px;
}
.tour-modal-close-btn:hover {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border-color: rgba(239, 68, 68, 0.4);
    transform: rotate(90deg);
}

.tour-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.tour-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(59, 130, 246, 0.12);
    border: 1px solid rgba(59, 130, 246, 0.3);
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    color: #93c5fd;
}

.tour-progress-dots {
    display: flex;
    align-items: center;
    gap: 6px;
}

.tour-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    transition: all 0.25s ease;
}

.tour-dot.active {
    width: 22px;
    border-radius: 10px;
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
}

.tour-icon-halo {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    margin: 0 auto 16px auto;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, rgba(29, 78, 216, 0.03) 70%);
    border: 1.5px solid rgba(59, 130, 246, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #60a5fa;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
}

.tour-title {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 8px;
    letter-spacing: -0.3px;
}

.tour-description {
    font-size: 13.5px;
    color: #94a3b8;
    line-height: 1.6;
    margin-bottom: 20px;
}

.tour-feature-highlight {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 12px;
    padding: 12px 16px;
    text-align: left;
    margin-bottom: 24px;
}

.tour-highlight-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #fbbf24;
    margin-bottom: 4px;
}

.tour-highlight-text {
    font-size: 12.5px;
    color: #cbd5e1;
    line-height: 1.5;
}

.tour-footer-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.tour-footer-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: auto;
}

.tour-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: inherit;
    border: none;
    box-sizing: border-box;
}

.tour-btn-skip {
    background: transparent;
    color: #64748b;
    padding: 8px 10px;
}
.tour-btn-skip:hover {
    color: #94a3b8;
}

.tour-btn-secondary {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #cbd5e1;
}
.tour-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.tour-btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: #fff;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);
}
.tour-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(59, 130, 246, 0.45);
}

@media (max-width: 576px) {
    .tour-modal-card {
        padding: 22px 18px !important;
        border-radius: 16px !important;
    }
    .tour-title {
        font-size: 18px !important;
    }
    .tour-description {
        font-size: 12.5px !important;
    }
}
</style>

<script>
(function() {
    // ── Default 6-Step Onboarding Walkthrough ──
    const defaultTourSteps = [
        {
            badge: 'Step 1 of 6',
            title: 'Welcome & Dashboard',
            description: 'Your central hub for legal research. Access the top quick search, switch between Dark & Light themes, and manage your account with ease.',
            icon: 'fa-gauge-high',
            highlightTitle: 'Quick Search & Theme',
            highlightText: 'Use the top navigation bar anytime to quickly search legal statutes or toggle day/night reading themes.'
        },
        {
            badge: 'Step 2 of 6',
            title: 'Explore Legal Library',
            description: 'Browse the 1992 Constitution, modern Acts of Parliament, historic pre-1992 decrees, and high court judgments with complete index filters.',
            icon: 'fa-landmark',
            highlightTitle: 'Four Core Categories',
            highlightText: 'Instantly toggle between Constitution, Acts, Decrees, and Law Reports from the main portal navigation.'
        },
        {
            badge: 'Step 3 of 6',
            title: 'Smart Reading & Split-Screen',
            description: 'Read legal sections in expanded view, play crisp AI audio recitations, or compare statutes side-by-side using horizontal and vertical split views.',
            icon: 'fa-book-open-reader',
            highlightTitle: 'Expanded & Split-Screen Modes',
            highlightText: 'Click the View Mode selector in any statute to split your screen and read two legal articles simultaneously.'
        },
        {
            badge: 'Step 4 of 6',
            title: 'Save & Organize Bookmarks',
            description: 'Bookmark any section with a single tap. Group your bookmarks by category, search by title, and preview full texts inside your dashboard without losing your place.',
            icon: 'fa-bookmark',
            highlightTitle: 'One-Click Quick Preview',
            highlightText: 'In My Bookmarks, click "View Section" on any saved card to pop open an instant reading modal.'
        },
        {
            badge: 'Step 5 of 6',
            title: 'Highlight Text & Study Notes',
            description: 'Highlight statutory text with 5 distinct colors (Yellow, Blue, Green, Pink, Purple). Write study commentary, edit in real time, and export all notes to PDF & Word.',
            icon: 'fa-pen-to-square',
            highlightTitle: '5-Color Annotations & Export',
            highlightText: 'Select any text inside the reader to highlight and save directly to My Notes with bulk PDF export.'
        },
        {
            badge: 'Step 6 of 6',
            title: 'Subscription & Updates',
            description: 'Stay ahead with the new Notifications Bell for platform alerts and feature tours. Check the Subscription menu in the sidebar for upcoming premium upgrades.',
            icon: 'fa-circle-check',
            highlightTitle: 'You Are All Set!',
            highlightText: 'You can restart this tour anytime from your user menu in the sidebar footer or top navbar.'
        }
    ];

    let activeTourSteps = defaultTourSteps;
    let currentTourIndex = 0;
    let isCustomTour = false;

    window.startPlatformTour = function(customSteps = null, isFeatureUpdate = false) {
        // Dismiss first time welcome prompt if open
        const promptEl = document.getElementById('firstTimeWelcomeBackdrop');
        if (promptEl) {
            promptEl.classList.remove('show');
            promptEl.style.display = 'none';
        }

        if (customSteps && Array.isArray(customSteps) && customSteps.length > 0) {
            activeTourSteps = customSteps.map((step, idx) => ({
                badge: `Feature Tour - Step ${idx + 1} of ${customSteps.length}`,
                title: step.title || 'Feature Walkthrough',
                description: step.description || '',
                icon: step.icon || 'fa-sparkles',
                highlightTitle: step.highlight_title || 'Feature Tip',
                highlightText: step.highlight_text || step.description || ''
            }));
            isCustomTour = isFeatureUpdate;
        } else {
            activeTourSteps = defaultTourSteps;
            isCustomTour = false;
        }

        currentTourIndex = 0;
        renderTourStep();

        const backdrop = document.getElementById('platformTourModalBackdrop');
        if (backdrop) {
            backdrop.classList.add('show');
            backdrop.style.display = 'flex';
        }
    };

    window.startOnboardingTourFromPrompt = function() {
        dismissFirstTimePrompt(false);
        window.startPlatformTour();
    };

    window.dismissFirstTimePrompt = function(markComplete = true) {
        const promptEl = document.getElementById('firstTimeWelcomeBackdrop');
        if (promptEl) {
            promptEl.classList.remove('show');
            promptEl.style.display = 'none';
        }

        if (markComplete) {
            markOnboardingTourCompleteInBackend();
        }
    };

    function renderTourStep() {
        const step = activeTourSteps[currentTourIndex];
        if (!step) return;

        const total = activeTourSteps.length;

        // Badge & Counter
        const badgeEl = document.getElementById('tourStepBadge');
        const counterEl = document.getElementById('tourStepCounter');
        if (counterEl) counterEl.textContent = step.badge || `Step ${currentTourIndex + 1} of ${total}`;

        // Title & Description
        const titleEl = document.getElementById('tourStepTitle');
        const descEl = document.getElementById('tourStepDescription');
        if (titleEl) titleEl.textContent = step.title;
        if (descEl) descEl.textContent = step.description;

        // Icon
        const iconEl = document.getElementById('tourMainIcon');
        if (iconEl) {
            iconEl.className = 'fa-solid ' + (step.icon || 'fa-compass');
        }

        // Highlight box
        const hlTitleEl = document.getElementById('tourHighlightTitle');
        const hlTextEl = document.getElementById('tourHighlightText');
        if (hlTitleEl) hlTitleEl.textContent = step.highlightTitle || 'Feature Highlight';
        if (hlTextEl) hlTextEl.textContent = step.highlightText || step.description;

        // Progress Dots
        const dotsContainer = document.getElementById('tourProgressDots');
        if (dotsContainer) {
            dotsContainer.innerHTML = '';
            for (let i = 0; i < total; i++) {
                const dot = document.createElement('div');
                dot.className = 'tour-dot' + (i === currentTourIndex ? ' active' : '');
                dotsContainer.appendChild(dot);
            }
        }

        // Navigation Buttons
        const prevBtn = document.getElementById('tourBtnPrev');
        const nextBtn = document.getElementById('tourBtnNext');
        const skipBtn = document.getElementById('tourBtnSkip');

        if (prevBtn) {
            prevBtn.style.display = currentTourIndex > 0 ? 'inline-flex' : 'none';
        }

        if (nextBtn) {
            if (currentTourIndex === total - 1) {
                nextBtn.innerHTML = '<span>Finish Tour</span> <i class="fa-solid fa-check"></i>';
                nextBtn.classList.remove('tour-btn-primary');
                nextBtn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
            } else {
                nextBtn.innerHTML = '<span>Next</span> <i class="fa-solid fa-arrow-right"></i>';
                nextBtn.style.background = '';
                nextBtn.classList.add('tour-btn-primary');
            }
        }
    }

    window.nextTourStep = function() {
        if (currentTourIndex < activeTourSteps.length - 1) {
            currentTourIndex++;
            renderTourStep();
        } else {
            closePlatformTour();
            if (!isCustomTour) {
                markOnboardingTourCompleteInBackend();
            }
        }
    };

    window.prevTourStep = function() {
        if (currentTourIndex > 0) {
            currentTourIndex--;
            renderTourStep();
        }
    };

    window.closePlatformTour = function() {
        const backdrop = document.getElementById('platformTourModalBackdrop');
        if (backdrop) {
            backdrop.classList.remove('show');
            backdrop.style.display = 'none';
        }
    };

    window.skipPlatformTour = function() {
        closePlatformTour();
        if (!isCustomTour) {
            markOnboardingTourCompleteInBackend();
        }
    };

    function markOnboardingTourCompleteInBackend() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        fetch('/accounts/onboarding-tour/complete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).catch(() => {});
        localStorage.setItem('lawsforum_tour_completed', '1');
    }

    // Auto check if new user should be prompted on first login
    document.addEventListener('DOMContentLoaded', function() {
        const isCompletedLocal = localStorage.getItem('lawsforum_tour_completed');
        
        // Fetch user status and tour content from backend
        fetch('/accounts/platform-updates')
            .then(res => res.json())
            .then(data => {
                if (data && data.success) {
                    // Dynamically load admin configured steps
                    if (data.onboarding_tour_steps && Array.isArray(data.onboarding_tour_steps) && data.onboarding_tour_steps.length > 0) {
                        defaultTourSteps = data.onboarding_tour_steps;
                        activeTourSteps = defaultTourSteps;
                    }

                    // Dynamically update welcome prompt if returned
                    if (data.onboarding_tour_settings) {
                        const set = data.onboarding_tour_settings;
                        const wTitle = document.getElementById('welcomeModalTitle');
                        const wDesc = document.getElementById('welcomeModalDesc');
                        const wBtnPri = document.getElementById('welcomeModalBtnPrimary');
                        const wBtnSec = document.getElementById('welcomeModalBtnSecondary');
                        if (wTitle && set.welcome_title) wTitle.textContent = set.welcome_title;
                        if (wDesc && set.welcome_description) wDesc.innerHTML = set.welcome_description;
                        if (wBtnPri && set.welcome_btn_primary) wBtnPri.querySelector('span').textContent = set.welcome_btn_primary;
                        if (wBtnSec && set.welcome_btn_secondary) wBtnSec.textContent = set.welcome_btn_secondary;
                    }

                    // Update notification bell count in navbar
                    if (typeof updateNotificationBellBadge === 'function') {
                        updateNotificationBellBadge(data.unread_count, data.updates);
                    }

                    // Prompt first time user if not completed and auto prompt enabled
                    const autoPromptEnabled = !data.onboarding_tour_settings || data.onboarding_tour_settings.auto_prompt_new_users;
                    if (autoPromptEnabled && !data.has_completed_onboarding_tour && !isCompletedLocal) {
                        const promptEl = document.getElementById('firstTimeWelcomeBackdrop');
                        if (promptEl) {
                            setTimeout(() => {
                                promptEl.classList.add('show');
                                promptEl.style.display = 'flex';
                            }, 800);
                        }
                    }
                }
            })
            .catch(() => {});
    });
})();
</script>
