@if(isset($sidebarAds['slot_1']))
    @if($sidebarAds['slot_1']->target_url)
        <a href="{{ $sidebarAds['slot_1']->target_url }}" target="_blank">
            <img src="{{ $sidebarAds['slot_1']->image_url }}" class="card-img-top" alt="Advertisement">
        </a>
    @else
        <img src="{{ $sidebarAds['slot_1']->image_url }}" class="card-img-top" alt="Advertisement">
    @endif
@endif