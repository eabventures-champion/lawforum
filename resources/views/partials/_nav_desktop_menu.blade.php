{{-- Desktop Navigation Menu Links --}}
{{-- Renders the headerMenus with support for sub-dropdowns (3-level nesting) and exclusive section active state --}}
@php
    $currentPath = trim(request()->path(), '/');

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
    }
@endphp

@foreach($headerMenus as $menu)
    @php
        $titleLower = strtolower(trim($menu->title));
        $menuUrl = $menu->custom_content ? route('dynamic.page', $menu->slug) : ($menu->url ?? '#');
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
            } elseif ($activeSection === 'new_laws' && (strpos($titleLower, 'new') !== false || strpos($titleLower, 'post-1992') !== false || strpos($titleLower, 'post 1992') !== false)) {
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
            <a href="{{ $menuUrl }}" class="nav-link-btn {{ $isMenuActive ? 'active' : '' }}" style="text-decoration:none !important;">
                {{ $menu->title }} <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>
            </a>
            <div class="nav-dropdown-menu">
                @foreach($menu->children as $child)
                    @php
                        $childUrl = $child->custom_content ? route('dynamic.page', $child->slug) : ($child->url ?? '#');
                        $childPath = trim(parse_url($childUrl, PHP_URL_PATH) ?? '', '/');
                        $isChildActive = !empty($childPath) && $childPath !== '#' && ($currentPath === $childPath || strpos($currentPath, $childPath . '/') === 0);
                    @endphp
                    @if($child->is_dropdown && $child->children->count() > 0)
                        {{-- Sub-dropdown item --}}
                        <div class="nav-sub-dropdown {{ $isChildActive ? 'active' : '' }}">
                            <a href="#" class="nav-sub-dropdown-trigger {{ $isChildActive ? 'active' : '' }}" onclick="event.preventDefault()">
                                {{ $child->title }}
                                <i class="fa-solid fa-chevron-right" style="font-size: 9px; margin-left: auto;"></i>
                            </a>
                            <div class="nav-sub-dropdown-menu">
                                @foreach($child->children as $grandchild)
                                    @php
                                        $gcUrl = $grandchild->custom_content ? route('dynamic.page', $grandchild->slug) : ($grandchild->url ?? '#');
                                        $gcPath = trim(parse_url($gcUrl, PHP_URL_PATH) ?? '', '/');
                                        $isGcActive = !empty($gcPath) && $gcPath !== '#' && ($currentPath === $gcPath || strpos($currentPath, $gcPath . '/') === 0);
                                    @endphp
                                    <a href="{{ $gcUrl }}" class="{{ $isGcActive ? 'active' : '' }}">{{ $grandchild->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $childUrl }}" class="{{ $isChildActive ? 'active' : '' }}">{{ $child->title }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ $menuUrl }}" class="nav-link-btn {{ $isMenuActive ? 'active' : '' }}" style="text-decoration:none !important;">{{ $menu->title }}</a>
    @endif
@endforeach
