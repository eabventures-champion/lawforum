@if(isset($sidebarAds['slot_1']))
    @php
        $ad = $sidebarAds['slot_1'];
    @endphp
    @if($ad->is_active && $ad->image_path)
        @if($ad->target_url)
            <a href="{{ $ad->target_url }}" target="_blank">
                <img src="{{ $ad->image_url }}" class="card-img-top" alt="Advertisement">
            </a>
        @else
            <img src="{{ $ad->image_url }}" class="card-img-top" alt="Advertisement">
        @endif
    @else
        @if($ad->placeholder_type === 'news_feed')
            @include('ads.placeholder_news_feed', ['ad' => $ad])
        @else
            @include('ads.placeholder_advertise', ['ad' => $ad])
        @endif
    @endif
@endif