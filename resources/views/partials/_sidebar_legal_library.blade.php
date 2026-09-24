{{-- Reusable Sidebar Legal Library Navigation with Smooth Mobile/Desktop Accordion --}}
@if(isset($headerMenus) && $headerMenus->count() > 0)
    @php
        $sidebarHasAccess = auth()->check() ? auth()->user()->hasFullAccess() : false;
    @endphp
    <li class="menu-label sidebar-legal-library-item">Legal Library</li>

    @foreach($headerMenus as $menuIndex => $menu)
        @php
            $titleLower = strtolower(trim($menu->title));
            $isConstitution = ($titleLower === 'constitution' || $menu->slug === 'constitution' || strpos($titleLower, 'constitution') !== false);
            $isMenuLocked = auth()->check() && !$sidebarHasAccess && !$isConstitution;

            $menuIcon = 'fa-book-bookmark';
            if ($isConstitution) {
                $menuIcon = 'fa-landmark';
            } elseif (strpos($titleLower, 'existing') !== false || strpos($titleLower, 'pre-1992') !== false || strpos($titleLower, 'pre 1992') !== false) {
                $menuIcon = 'fa-scroll';
            } elseif (strpos($titleLower, 'new') !== false || strpos($titleLower, 'post-1992') !== false || strpos($titleLower, 'post 1992') !== false) {
                $menuIcon = 'fa-scale-balanced';
            } elseif (strpos($titleLower, 'case') !== false || strpos($titleLower, 'judgement') !== false || strpos($titleLower, 'report') !== false) {
                $menuIcon = 'fa-gavel';
            } elseif (strpos($titleLower, 'news') !== false) {
                $menuIcon = 'fa-newspaper';
            }

            $hasChildren = $menu->is_dropdown && $menu->children && $menu->children->count() > 0;
            $menuUrl = $isMenuLocked ? url('/subscription') : ($menu->custom_content ? route('dynamic.page', $menu->slug) : ($menu->url ?? '#'));
        @endphp

        @if($hasChildren)
            <li class="menu-item menu-item-has-submenu sidebar-legal-library-item" id="sidebarMenu_{{ $menu->id }}">
                <a href="javascript:void(0)" class="sidebar-submenu-toggle" onclick="toggleSidebarSubmenu('sidebarSubmenu_{{ $menu->id }}', this)">
                    <i class="fa-solid {{ $menuIcon }}"></i>
                    <span>{{ $menu->title }}</span>
                    @if($isMenuLocked)
                        <span class="menu-badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border-color: rgba(239, 68, 68, 0.4); font-size: 10px; padding: 2px 6px; margin-left: auto; margin-right: 6px;">
                            <i class="fa-solid fa-lock" style="font-size: 9px; width: auto; margin-right: 2px;"></i> Lock
                        </span>
                    @endif
                    <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="sidebar-submenu-list" id="sidebarSubmenu_{{ $menu->id }}">
                    @if($isMenuLocked)
                        <li style="padding: 6px 14px;">
                            <a href="{{ url('/subscription') }}" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 6px; padding: 6px 10px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-lock" style="font-size: 10px;"></i>
                                <span>Subscribe to Unlock</span>
                            </a>
                        </li>
                    @endif
                    @foreach($menu->children as $child)
                        @php
                            $childUrl = $isMenuLocked ? url('/subscription') : ($child->custom_content ? route('dynamic.page', $child->slug) : ($child->url ?? '#'));
                            $hasGrandChildren = $child->is_dropdown && $child->children && $child->children->count() > 0;
                        @endphp
                        @if($hasGrandChildren)
                            <li class="sidebar-submenu-heading">{{ $child->title }}</li>
                            @foreach($child->children as $grandchild)
                                @php
                                    $gcUrl = $isMenuLocked ? url('/subscription') : ($grandchild->custom_content ? route('dynamic.page', $grandchild->slug) : ($grandchild->url ?? '#'));
                                @endphp
                                <li>
                                    <a href="{{ $gcUrl }}" class="sidebar-submenu-link" style="padding-left: 28px;">
                                        <i class="fa-solid fa-circle-dot" style="font-size: 6px; opacity: 0.6; margin-right: 6px;"></i>
                                        <span>{{ $grandchild->title }}</span>
                                        @if($isMenuLocked)
                                            <i class="fa-solid fa-lock" style="font-size: 8px; color: #f87171; margin-left: auto;"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li>
                                <a href="{{ $childUrl }}" class="sidebar-submenu-link">
                                    <i class="fa-solid fa-angle-right" style="font-size: 10px; opacity: 0.6; margin-right: 6px;"></i>
                                    <span>{{ $child->title }}</span>
                                    @if($isMenuLocked)
                                        <i class="fa-solid fa-lock" style="font-size: 8px; color: #f87171; margin-left: auto;"></i>
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @else
            <li class="menu-item sidebar-legal-library-item">
                @if($isMenuLocked)
                    <a href="{{ url('/subscription') }}" title="Subscribe to unlock {{ $menu->title }}" style="opacity: 0.85;">
                        <i class="fa-solid {{ $menuIcon }}" style="{{ strpos($titleLower, 'news') !== false ? 'color: #f97316;' : '' }}"></i>
                        <span>{{ $menu->title }}</span>
                        <span class="menu-badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border-color: rgba(239, 68, 68, 0.4); font-size: 10px; padding: 2px 6px; margin-left: auto;">
                            <i class="fa-solid fa-lock" style="font-size: 9px; width: auto; margin-right: 2px;"></i> Lock
                        </span>
                    </a>
                @else
                    <a href="{{ $menuUrl }}" style="{{ strpos($titleLower, 'news') !== false ? 'color: #f97316;' : '' }}">
                        <i class="fa-solid {{ $menuIcon }}" style="{{ strpos($titleLower, 'news') !== false ? 'color: #f97316;' : '' }}"></i>
                        <span>{{ $menu->title }}</span>
                    </a>
                @endif
            </li>
        @endif
    @endforeach
@endif
