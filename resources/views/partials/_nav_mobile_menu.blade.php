{{-- Mobile Navigation Menu Links --}}
{{-- Renders the headerMenus for the mobile nav panel with sub-dropdown support --}}
@if(auth()->check() || request()->cookie('guest_access'))
@foreach($headerMenus as $menu)
    @if($menu->is_dropdown)
        @php
            $url = '#';
            if ($menu->children && count($menu->children) > 0) {
                $firstChild = $menu->children->first();
                if ($firstChild->is_dropdown && $firstChild->children->count() > 0) {
                    $firstGrandchild = $firstChild->children->first();
                    $url = $firstGrandchild->custom_content ? route('dynamic.page', $firstGrandchild->slug) : $firstGrandchild->url;
                } else {
                    $url = $firstChild->custom_content ? route('dynamic.page', $firstChild->slug) : $firstChild->url;
                }
            }
        @endphp
        <a href="{{ $url }}">{{ $menu->title }}</a>
    @else
        <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}">{{ $menu->title }}</a>
    @endif
@endforeach
@endif
