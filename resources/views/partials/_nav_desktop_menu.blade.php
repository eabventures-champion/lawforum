{{-- Desktop Navigation Menu Links --}}
{{-- Renders the headerMenus with support for sub-dropdowns (3-level nesting) and exclusive section active state --}}
@if(auth()->check() || request()->cookie('guest_access'))
@php
    $currentPath = trim(request()->path(), '/');
    $isGuest = !auth()->check();
    $isDashboard = (isset($inDashboardHeader) && $inDashboardHeader) || request()->is('home*') || request()->is('accounts/*') || request()->is('subscription*');
    $userHasFullAccess = auth()->check() ? auth()->user()->hasFullAccess() : false;

    // 1. Identify primary section from current URL route
    $activeSection = '';
    if (strpos($currentPath, 'constitution') === 0) {
        $activeSection = 'constitution';
    } elseif (strpos($currentPath, 'judgement') === 0 || strpos($currentPath, 'case') === 0) {
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

        // For logged-in users who do not have full access (no subscription & no active demo), lock non-Constitution menus
        $isMenuLocked = auth()->check() && !$userHasFullAccess && !$isConstitution;

        $menuUrl = $isMenuLocked ? url('/subscription') : ($menu->custom_content ? route('dynamic.page', $menu->slug) : ($menu->url ?? '#'));
        $menuPath = trim(parse_url($menuUrl, PHP_URL_PATH) ?? '', '/');
        
        $isMenuActive = false;

        if ($activeSection !== '') {
            // High-priority section matching: exclusively activates ONE top menu
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
            // Fallback path matching for custom pages or homepage
            if (!empty($menuPath) && $menuPath !== '#' && $menuPath !== '/') {
                if ($currentPath === $menuPath || strpos($currentPath, $menuPath . '/') === 0) {
                    $isMenuActive = true;
                }
            }
        }
    @endphp

    @if($menu->is_dropdown)
        <div class="nav-link-dropdown {{ $isMenuActive ? 'active' : '' }}">
            <a href="{{ $menuUrl }}" class="nav-link-btn {{ $isMenuActive ? 'active' : '' }}" style="text-decoration:none !important;" @if($isMenuLocked) data-locked="true" title="Subscribe to unlock {{ $menu->title }}" @endif>
                {{ $menu->title }}
                @if($isMenuLocked)
                    <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 4px; color: #f87171;"></i>
                @endif
                <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>
            </a>
            <div class="nav-dropdown-menu">
                @if($isMenuLocked)
                    <a href="{{ url('/subscription') }}" data-locked="true" style="background: rgba(239, 68, 68, 0.12); color: #f87171; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 6px; padding: 7px 10px; margin: 4px 6px; font-size: 11.5px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-lock" style="font-size: 10px;"></i> Subscribe to Unlock {{ $menu->title }}
                    </a>
                @endif
                @foreach($menu->children as $child)
                    @php
                        $childUrl = $isMenuLocked ? url('/subscription') : ($child->custom_content ? route('dynamic.page', $child->slug) : ($child->url ?? '#'));
                        $childPath = trim(parse_url($childUrl, PHP_URL_PATH) ?? '', '/');
                        $isChildActive = !$isMenuLocked && !empty($childPath) && $childPath !== '#' && ($currentPath === $childPath || strpos($currentPath, $childPath . '/') === 0);
                    @endphp
                    @if($child->is_dropdown && $child->children->count() > 0)
                        {{-- Sub-dropdown item --}}
                        <div class="nav-sub-dropdown {{ $isChildActive ? 'active' : '' }}">
                            <a href="{{ $isMenuLocked ? url('/subscription') : '#' }}" class="nav-sub-dropdown-trigger {{ $isChildActive ? 'active' : '' }}" @if(!$isMenuLocked) onclick="event.preventDefault()" @else data-locked="true" @endif>
                                <span>{{ $child->title }}</span>
                                @if($isMenuLocked)
                                    <i class="fa-solid fa-lock" style="font-size: 9px; margin-left: 6px; color: #f87171; opacity: 0.85;"></i>
                                @endif
                                <i class="fa-solid fa-chevron-right" style="font-size: 9px; margin-left: auto;"></i>
                            </a>
                            <div class="nav-sub-dropdown-menu">
                                @foreach($child->children as $grandchild)
                                    @php
                                        $gcUrl = $isMenuLocked ? url('/subscription') : ($grandchild->custom_content ? route('dynamic.page', $grandchild->slug) : ($grandchild->url ?? '#'));
                                        $gcPath = trim(parse_url($gcUrl, PHP_URL_PATH) ?? '', '/');
                                        $isGcActive = !$isMenuLocked && !empty($gcPath) && $gcPath !== '#' && ($currentPath === $gcPath || strpos($currentPath, $gcPath . '/') === 0);
                                    @endphp
                                    <a href="{{ $gcUrl }}" class="{{ $isGcActive ? 'active' : '' }}" @if($isMenuLocked) data-locked="true" @endif>
                                        {{ $grandchild->title }}
                                        @if($isMenuLocked)
                                            <i class="fa-solid fa-lock" style="font-size: 8px; margin-left: auto; color: #f87171; opacity: 0.8;"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $childUrl }}" class="{{ $isChildActive ? 'active' : '' }}" @if($isMenuLocked) data-locked="true" @endif>
                            {{ $child->title }}
                            @if($isMenuLocked)
                                <i class="fa-solid fa-lock" style="font-size: 9px; margin-left: auto; color: #f87171; opacity: 0.8;"></i>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @elseif($titleLower === 'news' || strpos($titleLower, 'news') !== false)
        <a href="{{ $isMenuLocked ? url('/subscription') : ((!empty($menuUrl) && $menuUrl !== '#') ? $menuUrl : '/News/Ghana-News/1') }}" class="nav-link-btn nav-link-news {{ $isMenuActive ? 'active' : '' }}" style="color: #f97316 !important; font-weight: 700; text-decoration: none !important;" @if($isMenuLocked) data-locked="true" title="Subscribe to unlock News & Articles" @endif>
            {{ $menu->title }}
            @if($isMenuLocked)
                <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 4px; color: #f87171;"></i>
            @endif
        </a>
    @else
        <a href="{{ $menuUrl }}" class="nav-link-btn {{ $isMenuActive ? 'active' : '' }}" style="text-decoration:none !important;" @if($isMenuLocked) data-locked="true" title="Subscribe to unlock {{ $menu->title }}" @endif>
            {{ $menu->title }}
            @if($isMenuLocked)
                <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 4px; color: #f87171;"></i>
            @endif
        </a>
    @endif

    @php
        $isAdmin = auth()->check() && (
            (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())
            || (auth()->user()->role_id == 1)
            || (strtolower(auth()->user()->user_type ?? '') === 'admin')
        );
        $isResearcher = auth()->check() && !$isAdmin && (strtolower(auth()->user()->user_type ?? '') === 'researcher');
        $navbarResearcherAllowed = \App\AdditionalMenuSetting::isEnabled('navbar_researcher_enabled', false);
        $canShowAdditionalMenus = !$isAdmin && (!$isResearcher || $navbarResearcherAllowed);
    @endphp

    @if($isConstitution && !$isDashboard && $canShowAdditionalMenus)
        {{-- Additional Menus Managed at Admin (Chatroom, Marketplace, Jobs) --}}
        @php
            $chatroomEnabled = \App\AdditionalMenuSetting::isEnabled('chatroom_enabled', true);
            $marketplaceEnabled = \App\AdditionalMenuSetting::isEnabled('marketplace_enabled', true);
            $jobsEnabled = \App\AdditionalMenuSetting::isEnabled('jobs_enabled', true);
            
            $isChatroomActive = ($activeSection === 'chatroom') || (strpos($currentPath, 'chatroom') === 0);
            $isMarketplaceActive = ($activeSection === 'marketplace') || (strpos($currentPath, 'marketplace') === 0);
            $isJobsActive = ($activeSection === 'jobs') || (strpos($currentPath, 'jobs') === 0);
        @endphp

        @if($chatroomEnabled)
            @php
                $isChatroomLocked = auth()->check() && !$userHasFullAccess;
            @endphp
            <div class="nav-link-dropdown {{ $isChatroomActive ? 'active' : '' }}">
                <a href="{{ $isChatroomLocked ? url('/subscription') : '/chatroom' }}" class="nav-link-btn {{ $isChatroomActive ? 'active' : '' }}" style="text-decoration:none !important;" @if($isChatroomLocked) data-locked="true" title="Subscribe to unlock Chatroom" @endif>
                    Chatroom
                    @if($isChatroomLocked)
                        <i class="fa-solid fa-lock" style="font-size: 10px; margin-left: 4px; color: #f87171;"></i>
                    @else
                        <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>
                    @endif
                </a>
                <div class="nav-dropdown-menu">
                    @if($isChatroomLocked)
                        <a href="{{ url('/subscription') }}" data-locked="true" style="background: rgba(239, 68, 68, 0.12); color: #f87171; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 6px; padding: 7px 10px; margin: 4px 6px; font-size: 11.5px; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-lock" style="font-size: 10px;"></i> Subscribe to Unlock Chatrooms
                        </a>
                    @else
                        @if(\App\AdditionalMenuSetting::isEnabled('chatroom_general_enabled', true))
                            <a href="/chatroom/general" class="{{ ($currentPath === 'chatroom/general' || $currentPath === 'chatroom' || strpos($currentPath, 'chatroom/general/') === 0) ? 'active' : '' }}">
                                <i class="fa-solid fa-comments" style="color: #3b82f6; width: 16px;"></i> General Room
                            </a>
                        @endif
                        @if(\App\AdditionalMenuSetting::isEnabled('chatroom_student_enabled', true))
                            <a href="/chatroom/student" class="{{ ($currentPath === 'chatroom/student' || strpos($currentPath, 'chatroom/student/') === 0) ? 'active' : '' }}">
                                <i class="fa-solid fa-graduation-cap" style="color: #10b981; width: 16px;"></i> Student Room
                            </a>
                        @endif
                        @if(\App\AdditionalMenuSetting::isEnabled('chatroom_lawyer_enabled', true))
                            <a href="/chatroom/lawyer" class="{{ ($currentPath === 'chatroom/lawyer' || strpos($currentPath, 'chatroom/lawyer/') === 0) ? 'active' : '' }}">
                                <i class="fa-solid fa-scale-balanced" style="color: #f59e0b; width: 16px;"></i> Lawyer Room
                            </a>
                        @endif
                        @if(\App\AdditionalMenuSetting::isEnabled('chatroom_researcher_enabled', true))
                            <a href="/chatroom/researcher" class="{{ ($currentPath === 'chatroom/researcher' || strpos($currentPath, 'chatroom/researcher/') === 0) ? 'active' : '' }}">
                                <i class="fa-solid fa-microscope" style="color: #8b5cf6; width: 16px;"></i> Researcher Room
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        @if($marketplaceEnabled)
            <a href="/marketplace" class="nav-link-btn {{ $isMarketplaceActive ? 'active' : '' }}" style="text-decoration:none !important;">
                Marketplace
            </a>
        @endif

        @if($jobsEnabled)
            <a href="/jobs" class="nav-link-btn {{ $isJobsActive ? 'active' : '' }}" style="text-decoration:none !important;">
                Jobs
            </a>
        @endif
    @endif
@endforeach
@endif
