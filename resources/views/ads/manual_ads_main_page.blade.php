@if(isset($sidebarAds['slot_2']))
    @php
        $ad = $sidebarAds['slot_2'];
    @endphp
    @if($ad->is_active && $ad->image_path)
        <div class="card mb-3">
            @if($ad->target_url)
                <a href="{{ $ad->target_url }}" target="_blank">
                    <img src="{{ $ad->image_url }}" class="card-img-top" alt="Advertisement">
                </a>
                @if($ad->button_text)
                    <a href="{{ $ad->target_url }}" class="btn btn-primary btn-lg btn-block" style="border-radius: 0 0 12px 12px;">
                        {!! nl2br(e($ad->button_text)) !!}
                    </a>
                @endif
            @else
                <img src="{{ $ad->image_url }}" class="card-img-top" alt="Advertisement">
            @endif
        </div>
    @else
        @if($ad->placeholder_type === 'news_feed')
            @include('ads.placeholder_news_feed', ['ad' => $ad])
        @else
            @include('ads.placeholder_advertise', ['ad' => $ad])
        @endif
    @endif
@endif