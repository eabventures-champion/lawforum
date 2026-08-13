{{-- Mobile Navigation Menu Links --}}
{{-- Renders the headerMenus for the mobile nav panel with active item support --}}
@if(auth()->check() || request()->cookie('guest_access'))
@php
    $currentPath = trim(request()->path(), '/');

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
    }
@endphp

@foreach($headerMenus as $menu)
    @php
        $titleLower = strtolower(trim($menu->title));
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
            } elseif ($activeSection === 'new_laws' && (strpos($titleLower, 'new') !== false || strpos($titleLower, 'post-1992') !== false || strpos($titleLower, 'post 1992') !== false)) {
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
    <a href="{{ $menuUrl }}" class="{{ $isMenuActive ? 'active' : '' }}">{{ $menu->title }}</a>
@endforeach
@endif
