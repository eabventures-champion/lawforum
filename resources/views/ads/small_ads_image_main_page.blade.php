@if(isset($sidebarAds['slot_1']))
    @php
        $ad = $sidebarAds['slot_1'];
    @endphp
    @if($ad->is_active && $ad->image_path)
        <div style="margin-bottom: 20px;">
        @if($ad->target_url)
            <a href="{{ $ad->target_url }}" target="_blank">
                <img src="{{ $ad->image_url }}" class="card-img-top" alt="Advertisement">
            </a>
        @else
            <img src="{{ $ad->image_url }}" class="card-img-top" alt="Advertisement">
        @endif
        </div>
    @else
        @if($ad->placeholder_type === 'news_feed')
            <div style="margin-bottom: 20px;">
                @include('ads.placeholder_news_feed', ['ad' => $ad])
            </div>
        @else
            <div style="margin-bottom: 20px;">
                @include('ads.placeholder_advertise', ['ad' => $ad])
            </div>
        @endif
    @endif
@endif