{{-- User Dashboard Sidebar: Chatroom, Marketplace, Jobs --}}
@php
    $authUser = auth()->user();
@endphp

@if($authUser)
    @php
        $sidebarChatroomEnabled = \App\AdditionalMenuSetting::isEnabled('chatroom_enabled', true);
        $sidebarMarketplaceEnabled = \App\AdditionalMenuSetting::isEnabled('marketplace_enabled', true);
        $sidebarJobsEnabled = \App\AdditionalMenuSetting::isEnabled('jobs_enabled', true);
        $authUserRole = strtolower($authUser->user_type ?? '');
        $isResearcher = ($authUserRole === 'researcher' && !$authUser->isAdmin());
        $userHasFullAccess = $authUser->hasFullAccess();
        $isChatroomLocked = !$userHasFullAccess;

        $viewParam = request('view', '');
        $isChatroomActive = request()->is('chatroom*') || (is_string($viewParam) && str_starts_with($viewParam, '/chatroom'));

        $isHubActive = (request()->is('chatroom') && !request()->is('chatroom/*')) || $viewParam === '/chatroom';
        $isGeneralActive = request()->is('chatroom/general*') || (is_string($viewParam) && str_starts_with($viewParam, '/chatroom/general'));
        $isStudentActive = request()->is('chatroom/student*') || (is_string($viewParam) && str_starts_with($viewParam, '/chatroom/student'));
        $isLawyerActive = request()->is('chatroom/lawyer*') || (is_string($viewParam) && str_starts_with($viewParam, '/chatroom/lawyer'));
        $isResearcherActive = request()->is('chatroom/researcher*') || (is_string($viewParam) && str_starts_with($viewParam, '/chatroom/researcher'));
    @endphp

    @if($sidebarChatroomEnabled || $sidebarMarketplaceEnabled || $sidebarJobsEnabled)
        <li class="menu-label">Community & Services</li>

        {{-- 1. Chatroom with Subcategories --}}
        @if($sidebarChatroomEnabled)
            <li class="menu-item menu-item-has-submenu {{ $isChatroomActive ? 'open active' : '' }}" id="sidebarMenu_chatroom">
                <a href="javascript:void(0)" class="sidebar-submenu-toggle" onclick="toggleSidebarSubmenu('sidebarSubmenu_chatroom', this)">
                    <i class="fa-solid fa-comments" style="color: #60a5fa;"></i>
                    <span>Chatroom</span>
                    @if($isChatroomLocked)
                        <span class="menu-badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border-color: rgba(239, 68, 68, 0.4); font-size: 10px; padding: 2px 6px; margin-left: auto; margin-right: 6px;">
                            <i class="fa-solid fa-lock" style="font-size: 9px; width: auto; margin-right: 2px;"></i> Lock
                        </span>
                    @endif
                    <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="sidebar-submenu-list {{ $isChatroomActive ? 'show' : '' }}" id="sidebarSubmenu_chatroom">
                    @if($isChatroomLocked)
                        <li style="padding: 6px 14px;">
                            <a href="{{ url('/subscription') }}" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 6px; padding: 6px 10px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-lock" style="font-size: 10px;"></i>
                                <span>Subscribe to Unlock</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ $isChatroomLocked ? url('/subscription') : '/chatroom' }}" class="sidebar-submenu-link {{ $isHubActive ? 'active' : '' }}">
                            <span class="submenu-icon-wrap" style="color: #60a5fa;">
                                <i class="fa-solid fa-layer-group"></i>
                            </span>
                            <span>Chatroom Hub</span>
                            @if($isChatroomLocked)
                                <i class="fa-solid fa-lock" style="font-size: 9px; color: #f87171; margin-left: auto;"></i>
                            @elseif($isHubActive)
                                <span class="submenu-active-dot"></span>
                            @endif
                        </a>
                    </li>
                    @if(!$isResearcher && \App\AdditionalMenuSetting::isEnabled('chatroom_general_enabled', true))
                    <li>
                        <a href="{{ $isChatroomLocked ? url('/subscription') : '/chatroom/general' }}" class="sidebar-submenu-link {{ $isGeneralActive ? 'active' : '' }}">
                            <span class="submenu-icon-wrap" style="color: #3b82f6;">
                                <i class="fa-solid fa-comments"></i>
                            </span>
                            <span>General Room</span>
                            @if($isChatroomLocked)
                                <i class="fa-solid fa-lock" style="font-size: 9px; color: #f87171; margin-left: auto;"></i>
                            @elseif($isGeneralActive)
                                <span class="submenu-active-dot"></span>
                            @endif
                        </a>
                    </li>
                    @endif
                    @if(!$isResearcher && \App\AdditionalMenuSetting::isEnabled('chatroom_student_enabled', true))
                    <li>
                        <a href="{{ $isChatroomLocked ? url('/subscription') : '/chatroom/student' }}" class="sidebar-submenu-link {{ $isStudentActive ? 'active' : '' }}">
                            <span class="submenu-icon-wrap" style="color: #10b981;">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </span>
                            <span>Student Room</span>
                            @if($isChatroomLocked)
                                <i class="fa-solid fa-lock" style="font-size: 9px; color: #f87171; margin-left: auto;"></i>
                            @elseif($isStudentActive)
                                <span class="submenu-active-dot"></span>
                            @endif
                        </a>
                    </li>
                    @endif
                    @if(!$isResearcher && \App\AdditionalMenuSetting::isEnabled('chatroom_lawyer_enabled', true))
                    <li>
                        <a href="{{ $isChatroomLocked ? url('/subscription') : '/chatroom/lawyer' }}" class="sidebar-submenu-link {{ $isLawyerActive ? 'active' : '' }}">
                            <span class="submenu-icon-wrap" style="color: #f59e0b;">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </span>
                            <span>Lawyer Room</span>
                            @if($isChatroomLocked)
                                <i class="fa-solid fa-lock" style="font-size: 9px; color: #f87171; margin-left: auto;"></i>
                            @elseif($isLawyerActive)
                                <span class="submenu-active-dot"></span>
                            @endif
                        </a>
                    </li>
                    @endif
                    @if(\App\AdditionalMenuSetting::isEnabled('chatroom_researcher_enabled', true))
                    <li>
                        <a href="{{ $isChatroomLocked ? url('/subscription') : '/chatroom/researcher' }}" class="sidebar-submenu-link {{ $isResearcherActive ? 'active' : '' }}">
                            <span class="submenu-icon-wrap" style="color: #8b5cf6;">
                                <i class="fa-solid fa-microscope"></i>
                            </span>
                            <span>Researcher Room</span>
                            @if($isChatroomLocked)
                                <i class="fa-solid fa-lock" style="font-size: 9px; color: #f87171; margin-left: auto;"></i>
                            @elseif($isResearcherActive)
                                <span class="submenu-active-dot"></span>
                            @endif
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
        @endif

        {{-- 2. Marketplace --}}
        @if($sidebarMarketplaceEnabled)
            <li class="menu-item {{ (request()->is('marketplace*') || (is_string($viewParam) && str_starts_with($viewParam, '/marketplace'))) ? 'active' : '' }}">
                <a href="/marketplace">
                    <i class="fa-solid fa-store" style="color: #10b981;"></i>
                    <span>Marketplace</span>
                </a>
            </li>
        @endif

        {{-- 3. Jobs --}}
        @if($sidebarJobsEnabled)
            <li class="menu-item {{ (request()->is('jobs*') || (is_string($viewParam) && str_starts_with($viewParam, '/jobs'))) ? 'active' : '' }}">
                <a href="/jobs">
                    <i class="fa-solid fa-briefcase" style="color: #f59e0b;"></i>
                    <span>Jobs</span>
                </a>
            </li>
        @endif
    @endif
@endif
