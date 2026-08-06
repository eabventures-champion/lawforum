{{-- Desktop Navigation Menu Links --}}
{{-- Renders the headerMenus with support for sub-dropdowns (3-level nesting) and active state --}}
@php
    $currentPath = trim(request()->path(), '/');
@endphp

@foreach($headerMenus as $menu)
    @php
        $menuUrl = $menu->custom_content ? route('dynamic.page', $menu->slug) : ($menu->url ?? '#');
        $menuPath = trim(parse_url($menuUrl, PHP_URL_PATH) ?? '', '/');
        
        $isMenuActive = false;
        
        // 1. Direct path comparison
        if (!empty($menuPath) && $menuPath !== '#' && $menuPath !== '/') {
            if ($currentPath === $menuPath || strpos($currentPath, $menuPath . '/') === 0) {
                $isMenuActive = true;
            }
        }
        
        // 2. Check dropdown children/grandchildren
        if (!$isMenuActive && $menu->is_dropdown && isset($menu->children)) {
            foreach ($menu->children as $child) {
                $childUrl = $child->custom_content ? route('dynamic.page', $child->slug) : ($child->url ?? '');
                $childPath = trim(parse_url($childUrl, PHP_URL_PATH) ?? '', '/');
                if (!empty($childPath) && $childPath !== '#' && $childPath !== '/') {
                    if ($currentPath === $childPath || strpos($currentPath, $childPath . '/') === 0) {
                        $isMenuActive = true;
                        break;
                    }
                }
                if (isset($child->children)) {
                    foreach ($child->children as $grandchild) {
                        $gcUrl = $grandchild->custom_content ? route('dynamic.page', $grandchild->slug) : ($grandchild->url ?? '');
                        $gcPath = trim(parse_url($gcUrl, PHP_URL_PATH) ?? '', '/');
                        if (!empty($gcPath) && $gcPath !== '#' && $gcPath !== '/') {
                            if ($currentPath === $gcPath || strpos($currentPath, $gcPath . '/') === 0) {
                                $isMenuActive = true;
                                break 2;
                            }
                        }
                    }
                }
            }
        }
        
        // 3. Section keyword fallbacks (Constitution, Case Laws, Existing Laws, New Laws)
        if (!$isMenuActive) {
            $titleLower = strtolower(trim($menu->title));
            if ($titleLower === 'constitution' && strpos($currentPath, 'constitution') === 0) {
                $isMenuActive = true;
            } elseif (($titleLower === 'case laws' || $titleLower === 'case-laws' || $titleLower === 'judgement') && strpos($currentPath, 'judgement') === 0) {
                $isMenuActive = true;
            } elseif (($titleLower === 'existing laws' || $titleLower === 'new laws' || $titleLower === 'legislation') && (strpos($currentPath, 'legislation') !== false || strpos($currentPath, 'acts') !== false)) {
                $isMenuActive = true;
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
