{{-- Mobile Navigation Menu Links --}}
{{-- Renders the headerMenus for the mobile nav panel with active item support --}}
@if(auth()->check() || request()->cookie('guest_access'))
@php
    $currentPath = trim(request()->path(), '/');
    $isGuest = !auth()->check();
    $isDashboard = (isset($inDashboardHeader) && $inDashboardHeader) || request()->is('home*') || request()->is('accounts/*') || request()->is('subscription*');

    // Identify primary section from current URL route
    $activeSection = '';
    if (strpos($currentPath, 'constitution') === 0) {
        $activeSection = 'constitution';
    } elseif (strpos($currentPath, 'judgement') === 0 || strpos($currentPath, 'case') === 0 || strpos($currentPath, 'ghana-case-laws') === 0) {
        $activeSection = 'case_laws';
    } elseif (strpos($currentPath, 'existing-laws') === 0 || strpos($currentPath, 'pre_1992') === 0 || strpos($currentPath, 'pre-1992') === 0) {
        $activeSection = 'existing_laws';
    } elseif (strpos($currentPath, 'post_1992') === 0 || strpos($currentPath, 'post-1992') === 0 || strpos($currentPath, 'new-laws') === 0) {
        $activeSection = 'new_laws';
    } elseif (strpos($currentPath, 'news') === 0 || strpos($currentPath, 'News') === 0) {
        $activeSection = 'news';
    } elseif (strpos($currentPath, 'chatroom') === 0) {
        $activeSection = 'chatroom';
    } elseif (strpos($currentPath, 'marketplace') === 0) {
        $activeSection = 'marketplace';
    } elseif (strpos($currentPath, 'jobs') === 0) {
        $activeSection = 'jobs';
    }
@endphp

@foreach($headerMenus as $menu)
    @php
        $titleLower = strtolower(trim($menu->title));
        $isConstitution = ($titleLower === 'constitution' || $menu->slug === 'constitution' || strpos($titleLower, 'constitution') !== false);

        // For guest users, by default only Constitution is active to show in the nav; all others are hidden
        if ($isGuest && !$isConstitution) {
            continue;
        }

        $menuUrl = '#';
        if ($menu->is_dropdown) {
            if ($menu->children && count($menu->children) > 0) {
                $firstChild = $menu->children->first();
                if ($firstChild->is_dropdown && $firstChild->children->count() > 0) {
                    $firstGrandchild = $firstChild->children->first();
                    $menuUrl = $firstGrandchild->custom_content ? route('dynamic.page', $firstGrandchild->slug) : $firstGrandchild->url;
                } else {
                    $menuUrl = $firstChild->custom_content ? route('dynamic.page', $firstChild->slug) : $firstChild->url;
                }
            }
        } else {
            $menuUrl = $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url;
        }

        $menuPath = trim(parse_url($menuUrl, PHP_URL_PATH) ?? '', '/');
        $isMenuActive = false;

        if ($activeSection !== '') {
            if ($activeSection === 'constitution' && $titleLower === 'constitution') {
                $isMenuActive = true;
            } elseif ($activeSection === 'case_laws' && ($titleLower === 'case laws' || $titleLower === 'case-laws' || $titleLower === 'judgement')) {
                $isMenuActive = true;
            } elseif ($activeSection === 'existing_laws' && (strpos($titleLower, 'existing') !== false || strpos($titleLower, 'pre-1992') !== false || strpos($titleLower, 'pre 1992') !== false)) {
                $isMenuActive = true;
            } elseif ($activeSection === 'new_laws' && strpos($titleLower, 'news') === false && (strpos($titleLower, 'new') !== false || strpos($titleLower, 'post-1992') !== false || strpos($titleLower, 'post 1992') !== false)) {
                $isMenuActive = true;
            } elseif ($activeSection === 'news' && ($titleLower === 'news' || strpos($titleLower, 'news') !== false)) {
                $isMenuActive = true;
            }
        } else {
            if (!empty($menuPath) && $menuPath !== '#' && $menuPath !== '/') {
                if ($currentPath === $menuPath || strpos($currentPath, $menuPath . '/') === 0) {
                    $isMenuActive = true;
                }
            }
        }
    @endphp
    @if($menu->is_dropdown && $menu->children && $menu->children->count() > 0)
        <div class="mobile-nav-group mobile-nav-dropdown-wrap" id="mobileGroup_menu_{{ $menu->id }}">
            <a href="javascript:void(0)" 
               class="mobile-nav-card-link mobile-nav-dropdown-toggle {{ $isMenuActive ? 'active' : '' }}" 
               onclick="toggleMobileNavFocus('mobileGroup_menu_{{ $menu->id }}', this)">
                <span class="mobile-menu-label-wrap">
                    <span>{{ $menu->title }}</span>
                    <i class="fa-solid fa-chevron-down mobile-submenu-arrow"></i>
                </span>
            </a>

            <div class="mobile-submenu-list" id="mobileSubmenu_menu_{{ $menu->id }}" style="display: none;">
                @foreach($menu->children as $child)
                    @php
                        $childUrl = $child->custom_content ? route('dynamic.page', $child->slug) : ($child->url ?? '#');
                        $childPath = trim(parse_url($childUrl, PHP_URL_PATH) ?? '', '/');
                        $isChildActive = !empty($childPath) && $childPath !== '#' && ($currentPath === $childPath || strpos($currentPath, $childPath . '/') === 0);

                        $childTitle = trim($child->title);
                        $iconClass = 'fa-circle-dot';
                        $iconColor = '#94a3b8';
                        if ($isConstitution) {
                            if (stripos($childTitle, 'Ghana') !== false) {
                                $iconClass = 'fa-star';
                                $iconColor = '#f59e0b';
                            } elseif (stripos($childTitle, 'Africa') !== false) {
                                $iconClass = 'fa-earth-africa';
                                $iconColor = '#10b981';
                            } elseif (stripos($childTitle, 'Asia') !== false) {
                                $iconClass = 'fa-earth-asia';
                                $iconColor = '#f97316';
                            } elseif (stripos($childTitle, 'Europe') !== false) {
                                $iconClass = 'fa-earth-europe';
                                $iconColor = '#3b82f6';
                            } elseif (stripos($childTitle, 'North America') !== false || stripos($childTitle, 'North-America') !== false) {
                                $iconClass = 'fa-earth-americas';
                                $iconColor = '#06b6d4';
                            } elseif (stripos($childTitle, 'South America') !== false || stripos($childTitle, 'South-America') !== false) {
                                $iconClass = 'fa-earth-americas';
                                $iconColor = '#8b5cf6';
                            }
                        } else {
                            if (stripos($childTitle, 'Republic') !== false) {
                                $iconClass = 'fa-landmark';
                                $iconColor = '#f59e0b';
                            } elseif (stripos($childTitle, 'Law') !== false || stripos($childTitle, 'Act') !== false) {
                                $iconClass = 'fa-scale-balanced';
                                $iconColor = '#3b82f6';
                            } elseif (stripos($childTitle, 'Decree') !== false) {
                                $iconClass = 'fa-scroll';
                                $iconColor = '#10b981';
                            } elseif (stripos($childTitle, 'Instrument') !== false) {
                                $iconClass = 'fa-file-shield';
                                $iconColor = '#8b5cf6';
                            } elseif (stripos($childTitle, 'Amendment') !== false) {
                                $iconClass = 'fa-pen-to-square';
                                $iconColor = '#06b6d4';
                            }
                        }
                    @endphp
                    @if($child->is_dropdown && $child->children && $child->children->count() > 0)
                        @foreach($child->children as $grandchild)
                            @php
                                $gcUrl = $grandchild->custom_content ? route('dynamic.page', $grandchild->slug) : ($grandchild->url ?? '#');
                                $gcPath = trim(parse_url($gcUrl, PHP_URL_PATH) ?? '', '/');
                                $isGcActive = !empty($gcPath) && $gcPath !== '#' && ($currentPath === $gcPath || strpos($currentPath, $gcPath . '/') === 0);
                            @endphp
                            <a href="{{ $gcUrl }}" class="mobile-submenu-item {{ $isGcActive ? 'active' : '' }}">
                                <i class="fa-solid fa-scroll" style="color: #10b981; width: 16px;"></i>
                                <span>{{ $grandchild->title }}</span>
                            </a>
                        @endforeach
                    @else
                        <a href="{{ $childUrl }}" class="mobile-submenu-item {{ $isChildActive ? 'active' : '' }}">
                            <i class="fa-solid {{ $iconClass }}" style="color: {{ $iconColor }}; width: 16px;"></i>
                            <span>{{ $child->title }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @elseif($titleLower === 'news' || strpos($titleLower, 'news') !== false)
        <div class="mobile-nav-group" id="mobileGroup_menu_{{ $menu->id }}">
            <a href="{{ (!empty($menuUrl) && $menuUrl !== '#') ? $menuUrl : '/News/Ghana-News/1' }}" class="mobile-nav-card-link {{ $isMenuActive ? 'active' : '' }}" style="color: #f97316 !important; font-weight: 700;">
                <span class="mobile-menu-label-wrap">
                    <span>{{ $menu->title }}</span>
                </span>
            </a>
        </div>
    @else
        <div class="mobile-nav-group" id="mobileGroup_menu_{{ $menu->id }}">
            <a href="{{ $menuUrl }}" class="mobile-nav-card-link {{ $isMenuActive ? 'active' : '' }}">
                <span class="mobile-menu-label-wrap">
                    <span>{{ $menu->title }}</span>
                </span>
            </a>
        </div>
    @endif

    @php
        $isResearcherMob = auth()->check() && !auth()->user()->isAdmin() && (strtolower(auth()->user()->user_type ?? '') === 'researcher');
        $navbarResearcherAllowedMob = \App\AdditionalMenuSetting::isEnabled('navbar_researcher_enabled', false);
        $canShowAdditionalMenusMob = !$isResearcherMob || $navbarResearcherAllowedMob;
    @endphp

    @if($isConstitution && !$isDashboard && $canShowAdditionalMenusMob)
        {{-- Additional Menus in Mobile Drawer (Chatroom, Marketplace, Jobs) --}}
        @php
            $chatroomEnabledMob = \App\AdditionalMenuSetting::isEnabled('chatroom_enabled', true);
            $marketplaceEnabledMob = \App\AdditionalMenuSetting::isEnabled('marketplace_enabled', true);
            $jobsEnabledMob = \App\AdditionalMenuSetting::isEnabled('jobs_enabled', true);
            
            $isChatroomActiveMob = ($activeSection === 'chatroom') || (strpos($currentPath, 'chatroom') === 0);
            $isMarketplaceActiveMob = ($activeSection === 'marketplace') || (strpos($currentPath, 'marketplace') === 0);
            $isJobsActiveMob = ($activeSection === 'jobs') || (strpos($currentPath, 'jobs') === 0);
        @endphp

        @if($chatroomEnabledMob)
            <div class="mobile-nav-group mobile-nav-dropdown-wrap" id="mobileGroup_chatroom">
                <a href="javascript:void(0)" 
                   class="mobile-nav-card-link mobile-nav-dropdown-toggle {{ $isChatroomActiveMob ? 'active' : '' }}" 
                   onclick="toggleMobileNavFocus('mobileGroup_chatroom', this)">
                    <i class="fa-solid fa-comments mobile-menu-icon" style="color: #3b82f6;"></i>
                    <span class="mobile-menu-label-wrap">
                        <span>Chatroom</span>
                        <i class="fa-solid fa-chevron-down mobile-submenu-arrow"></i>
                    </span>
                </a>

                <div class="mobile-submenu-list" id="mobileChatroomSubmenu" style="display: none;">
                    <a href="/chatroom" class="mobile-submenu-item {{ (request()->is('chatroom') && !request()->is('chatroom/*')) ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group" style="color: #60a5fa; width: 16px;"></i>
                        <span>Chatroom Hub</span>
                    </a>
                    @if(\App\AdditionalMenuSetting::isEnabled('chatroom_general_enabled', true))
                        <a href="/chatroom/general" class="mobile-submenu-item {{ ($currentPath === 'chatroom/general' || strpos($currentPath, 'chatroom/general/') === 0) ? 'active' : '' }}">
                            <i class="fa-solid fa-comments" style="color: #3b82f6; width: 16px;"></i>
                            <span>General</span>
                        </a>
                    @endif
                    @if(\App\AdditionalMenuSetting::isEnabled('chatroom_student_enabled', true))
                        <a href="/chatroom/student" class="mobile-submenu-item {{ ($currentPath === 'chatroom/student' || strpos($currentPath, 'chatroom/student/') === 0) ? 'active' : '' }}">
                            <i class="fa-solid fa-graduation-cap" style="color: #10b981; width: 16px;"></i>
                            <span>Student</span>
                        </a>
                    @endif
                    @if(\App\AdditionalMenuSetting::isEnabled('chatroom_lawyer_enabled', true))
                        <a href="/chatroom/lawyer" class="mobile-submenu-item {{ ($currentPath === 'chatroom/lawyer' || strpos($currentPath, 'chatroom/lawyer/') === 0) ? 'active' : '' }}">
                            <i class="fa-solid fa-scale-balanced" style="color: #f59e0b; width: 16px;"></i>
                            <span>Lawyer</span>
                        </a>
                    @endif
                    @if(\App\AdditionalMenuSetting::isEnabled('chatroom_researcher_enabled', true))
                        <a href="/chatroom/researcher" class="mobile-submenu-item {{ ($currentPath === 'chatroom/researcher' || strpos($currentPath, 'chatroom/researcher/') === 0) ? 'active' : '' }}">
                            <i class="fa-solid fa-microscope" style="color: #8b5cf6; width: 16px;"></i>
                            <span>Researcher</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if($marketplaceEnabledMob)
            <div class="mobile-nav-group" id="mobileGroup_marketplace">
                <a href="/marketplace" class="mobile-nav-card-link {{ $isMarketplaceActiveMob ? 'active' : '' }}">
                    <i class="fa-solid fa-store mobile-menu-icon" style="color: #10b981;"></i>
                    <span class="mobile-menu-label-wrap">
                        <span>Marketplace</span>
                    </span>
                </a>
            </div>
        @endif

        @if($jobsEnabledMob)
            <div class="mobile-nav-group" id="mobileGroup_jobs">
                <a href="/jobs" class="mobile-nav-card-link {{ $isJobsActiveMob ? 'active' : '' }}">
                    <i class="fa-solid fa-briefcase mobile-menu-icon" style="color: #f59e0b;"></i>
                    <span class="mobile-menu-label-wrap">
                        <span>Jobs</span>
                    </span>
                </a>
            </div>
        @endif
    @endif
@endforeach
@endif

<style>
    .mobile-nav-panel {
        transition: padding 0.3s ease !important;
    }

    .mobile-nav-panel .mobile-nav-group {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
        text-align: center !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .mobile-nav-panel a.mobile-nav-card-link {
        display: inline-flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        margin: 0 auto !important;
        padding: 14px 28px !important;
        border-radius: 16px !important;
        width: auto !important;
        min-width: 160px !important;
        max-width: 220px !important;
        box-sizing: border-box !important;
        line-height: 1.2 !important;
        cursor: pointer !important;
        text-decoration: none !important;
    }

    .mobile-nav-panel #mobileGroup_menu_1 a.mobile-nav-card-link {
        flex-direction: row !important;
        gap: 8px !important;
        padding: 12px 28px !important;
    }

    .mobile-nav-panel a.mobile-nav-card-link .mobile-menu-icon {
        font-size: 20px !important;
        width: auto !important;
        height: auto !important;
        text-align: center !important;
        margin: 0 0 6px 0 !important;
        display: block !important;
        line-height: 1 !important;
    }

    .mobile-nav-panel a.mobile-nav-card-link .mobile-menu-label-wrap {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        font-size: 20px !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
    }

    .mobile-nav-panel a.mobile-nav-card-link.active {
        width: auto !important;
        min-width: 160px !important;
        max-width: 220px !important;
        padding: 14px 28px !important;
        box-sizing: border-box !important;
    }

    .mobile-nav-panel.mobile-focus-mode {
        justify-content: center !important;
        align-items: center !important;
        padding-top: 40px !important;
        padding-bottom: 40px !important;
    }

    .mobile-nav-panel.mobile-focus-mode .mobile-nav-group.focused-active {
        margin: auto 0 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
    }

    .mobile-nav-panel .mobile-submenu-list {
        display: none;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        width: 100%;
        margin-top: 6px;
        margin-bottom: 6px;
        animation: fadeInSubmenu 0.25s ease forwards;
    }

    .mobile-nav-panel .mobile-submenu-list a,
    .mobile-submenu-list a.mobile-submenu-item {
        font-size: 15px !important;
        font-weight: 500 !important;
        color: var(--text-secondary, #94a3b8) !important;
        padding: 9px 20px !important;
        border-radius: 10px !important;
        line-height: 1.4 !important;
        background: rgba(255, 255, 255, 0.04) !important;
        border: 1px solid rgba(255, 255, 255, 0.06) !important;
        transform: none !important;
        opacity: 1 !important;
        transition: all 0.2s ease !important;
        width: auto !important;
        min-width: 190px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 10px !important;
        margin: 2px 0 !important;
        text-decoration: none !important;
    }

    .mobile-nav-panel .mobile-submenu-list a:hover,
    .mobile-submenu-list a.mobile-submenu-item:hover {
        color: var(--text-primary, #f8fafc) !important;
        background: rgba(255, 255, 255, 0.09) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }

    .mobile-nav-panel .mobile-submenu-list a.active,
    .mobile-submenu-list a.mobile-submenu-item.active {
        color: #ffffff !important;
        background: rgba(59, 130, 246, 0.2) !important;
        border: 1px solid rgba(59, 130, 246, 0.4) !important;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.2) !important;
        font-weight: 600 !important;
    }

    .mobile-submenu-arrow {
        display: inline-block !important;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        font-size: 12px !important;
    }

    @keyframes fadeInSubmenu {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    (function() {
        function getMobilePanel(el) {
            if (el) {
                var panel = el.closest('.mobile-nav-panel');
                if (panel) return panel;
            }
            return document.getElementById('mobileNav') || document.querySelector('.mobile-nav-panel');
        }

        window.resetMobileNavFocus = function(panel) {
            var panels = panel ? [panel] : document.querySelectorAll('.mobile-nav-panel');
            panels.forEach(function(p) {
                p.classList.remove('mobile-focus-mode');
                
                // Restore any hidden children with proper display
                Array.from(p.children).forEach(function(child) {
                    if (child.hasAttribute('data-focus-hidden')) {
                        child.removeAttribute('data-focus-hidden');
                        if (child.classList.contains('mobile-nav-group')) {
                            child.style.display = 'flex';
                        } else {
                            child.style.display = '';
                        }
                    }
                });

                // Close all submenus
                var submenus = p.querySelectorAll('.mobile-submenu-list');
                submenus.forEach(function(sub) {
                    sub.style.display = 'none';
                    sub.classList.remove('open');
                });

                // Reset all chevrons
                var arrows = p.querySelectorAll('.mobile-submenu-arrow');
                arrows.forEach(function(arr) {
                    arr.style.transform = 'rotate(0deg)';
                });

                // Reset toggle states
                var toggles = p.querySelectorAll('.mobile-nav-dropdown-toggle');
                toggles.forEach(function(tog) {
                    tog.classList.remove('submenu-open');
                });

                // Remove focused class on groups
                var focusedGroups = p.querySelectorAll('.focused-active');
                focusedGroups.forEach(function(grp) {
                    grp.classList.remove('focused-active');
                });
            });
        };

        window.toggleMobileNavFocus = function(groupId, triggerEl) {
            var groupEl = document.getElementById(groupId);
            if (!groupEl) return;
            var panel = getMobilePanel(groupEl);
            if (!panel) return;

            var isCurrentlyActive = groupEl.classList.contains('focused-active');

            if (isCurrentlyActive) {
                // Already focused -> user clicked again -> collapse and restore all menus!
                window.resetMobileNavFocus(panel);
            } else {
                // Reset any other open focus first
                window.resetMobileNavFocus(panel);

                // Activate focus mode on panel
                panel.classList.add('mobile-focus-mode');
                groupEl.classList.add('focused-active');
                groupEl.style.display = 'flex';

                // Hide all other direct children of panel except close button and groupEl
                Array.from(panel.children).forEach(function(child) {
                    if (child === groupEl) return;
                    if (child.classList.contains('mobile-nav-close')) return;
                    if (child.tagName === 'SCRIPT' || child.tagName === 'STYLE') return;

                    child.setAttribute('data-focus-hidden', 'true');
                    child.style.display = 'none';
                });

                // Show this group's submenu
                var submenu = groupEl.querySelector('.mobile-submenu-list');
                if (submenu) {
                    submenu.style.display = 'flex';
                    submenu.classList.add('open');
                }

                // Rotate chevron
                var arrow = triggerEl ? triggerEl.querySelector('.mobile-submenu-arrow') : groupEl.querySelector('.mobile-submenu-arrow');
                if (arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                }
                if (triggerEl) {
                    triggerEl.classList.add('submenu-open');
                }
            }
        };

        // Backward compatibility
        window.toggleMobileSubmenu = function(submenuId, triggerEl) {
            var submenu = document.getElementById(submenuId);
            if (!submenu) return;
            var group = submenu.closest('.mobile-nav-group');
            if (group && group.id) {
                window.toggleMobileNavFocus(group.id, triggerEl);
            } else {
                var isOpen = submenu.style.display === 'flex' || submenu.classList.contains('open');
                submenu.style.display = isOpen ? 'none' : 'flex';
                var arrow = triggerEl ? triggerEl.querySelector('.mobile-submenu-arrow') : null;
                if (arrow) arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        };

        // Close button click handler - always ensures panel closes cleanly
        document.addEventListener('click', function(e) {
            var closeBtn = e.target.closest('.mobile-nav-close');
            if (closeBtn) {
                var p = closeBtn.closest('.mobile-nav-panel') || document.getElementById('mobileNav');
                if (p) {
                    p.classList.remove('open');
                    window.resetMobileNavFocus(p);
                }
            }
            var openToggle = e.target.closest('.nav-mobile-toggle') || e.target.closest('.mobile-menu-toggle');
            if (openToggle) {
                var p = document.getElementById('mobileNav');
                if (p) {
                    window.resetMobileNavFocus(p);
                }
            }
        }, true);
    })();
</script>

