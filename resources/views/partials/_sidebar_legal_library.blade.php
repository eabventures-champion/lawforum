{{-- Reusable Sidebar Legal Library Navigation with Smooth Mobile/Desktop Accordion --}}
@if(isset($headerMenus) && $headerMenus->count() > 0)
    <li class="menu-label sidebar-legal-library-item">Legal Library</li>

    @foreach($headerMenus as $menuIndex => $menu)
        @php
            $titleLower = strtolower(trim($menu->title));
            $menuIcon = 'fa-book-bookmark';
            if (strpos($titleLower, 'constitution') !== false) {
                $menuIcon = 'fa-landmark';
            } elseif (strpos($titleLower, 'existing') !== false || strpos($titleLower, 'pre-1992') !== false || strpos($titleLower, 'pre 1992') !== false) {
                $menuIcon = 'fa-scroll';
            } elseif (strpos($titleLower, 'new') !== false || strpos($titleLower, 'post-1992') !== false || strpos($titleLower, 'post 1992') !== false) {
                $menuIcon = 'fa-scale-balanced';
            } elseif (strpos($titleLower, 'case') !== false || strpos($titleLower, 'judgement') !== false || strpos($titleLower, 'report') !== false) {
                $menuIcon = 'fa-gavel';
            }

            $hasChildren = $menu->is_dropdown && $menu->children && $menu->children->count() > 0;
            $menuUrl = $menu->custom_content ? route('dynamic.page', $menu->slug) : ($menu->url ?? '#');
        @endphp

        @if($hasChildren)
            <li class="menu-item menu-item-has-submenu sidebar-legal-library-item" id="sidebarMenu_{{ $menu->id }}">
                <a href="javascript:void(0)" class="sidebar-submenu-toggle" onclick="toggleSidebarSubmenu('sidebarSubmenu_{{ $menu->id }}', this)">
                    <i class="fa-solid {{ $menuIcon }}"></i>
                    <span>{{ $menu->title }}</span>
                    <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                </a>
                <ul class="sidebar-submenu-list" id="sidebarSubmenu_{{ $menu->id }}">
                    @foreach($menu->children as $child)
                        @php
                            $childUrl = $child->custom_content ? route('dynamic.page', $child->slug) : ($child->url ?? '#');
                            $hasGrandChildren = $child->is_dropdown && $child->children && $child->children->count() > 0;
                        @endphp
                        @if($hasGrandChildren)
                            <li class="sidebar-submenu-heading">{{ $child->title }}</li>
                            @foreach($child->children as $grandchild)
                                @php
                                    $gcUrl = $grandchild->custom_content ? route('dynamic.page', $grandchild->slug) : ($grandchild->url ?? '#');
                                @endphp
                                <li>
                                    <a href="{{ $gcUrl }}" class="sidebar-submenu-link" style="padding-left: 28px;">
                                        <i class="fa-solid fa-circle-dot" style="font-size: 6px; opacity: 0.6; margin-right: 6px;"></i>
                                        <span>{{ $grandchild->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li>
                                <a href="{{ $childUrl }}" class="sidebar-submenu-link">
                                    <i class="fa-solid fa-angle-right" style="font-size: 10px; opacity: 0.6; margin-right: 6px;"></i>
                                    <span>{{ $child->title }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @else
            <li class="menu-item sidebar-legal-library-item">
                <a href="{{ $menuUrl }}">
                    <i class="fa-solid {{ $menuIcon }}"></i>
                    <span>{{ $menu->title }}</span>
                </a>
            </li>
        @endif
    @endforeach
@endif
