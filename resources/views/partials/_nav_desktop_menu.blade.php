{{-- Desktop Navigation Menu Links --}}
{{-- Renders the headerMenus with support for sub-dropdowns (3-level nesting) --}}
@foreach($headerMenus as $menu)
    @if($menu->is_dropdown)
        <div class="nav-link-dropdown">
            <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : ($menu->url ?? '#') }}" class="nav-link-btn" style="text-decoration:none !important;">{{ $menu->title }} <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></a>
            <div class="nav-dropdown-menu">
                @foreach($menu->children as $child)
                    @if($child->is_dropdown && $child->children->count() > 0)
                        {{-- Sub-dropdown item --}}
                        <div class="nav-sub-dropdown">
                            <a href="#" class="nav-sub-dropdown-trigger" onclick="event.preventDefault()">
                                {{ $child->title }}
                                <i class="fa-solid fa-chevron-right" style="font-size: 9px; margin-left: auto;"></i>
                            </a>
                            <div class="nav-sub-dropdown-menu">
                                @foreach($child->children as $grandchild)
                                    <a href="{{ $grandchild->custom_content ? route('dynamic.page', $grandchild->slug) : $grandchild->url }}">{{ $grandchild->title }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $child->custom_content ? route('dynamic.page', $child->slug) : $child->url }}">{{ $child->title }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <a href="{{ $menu->custom_content ? route('dynamic.page', $menu->slug) : $menu->url }}" class="nav-link-btn" style="text-decoration:none !important;">{{ $menu->title }}</a>
    @endif
@endforeach
