@if(isset($sidebarAds['slot_2']))
    <div class="card mb-3">
        @if($sidebarAds['slot_2']->target_url)
            <a href="{{ $sidebarAds['slot_2']->target_url }}" target="_blank">
                <img src="{{ $sidebarAds['slot_2']->image_url }}" class="card-img-top" alt="Advertisement">
            </a>
            @if($sidebarAds['slot_2']->button_text)
                <a href="{{ $sidebarAds['slot_2']->target_url }}" class="btn btn-primary btn-lg btn-block" style="border-radius: 0 0 12px 12px;">
                    {!! nl2br(e($sidebarAds['slot_2']->button_text)) !!}
                </a>
            @endif
        @else
            <img src="{{ $sidebarAds['slot_2']->image_url }}" class="card-img-top" alt="Advertisement">
        @endif
    </div>
@endif