<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css">    
</head>

<body>

    {{-- For the bookmark --}}
    <div class="header_only" style="border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03); border-radius: 8px; display: flex; justify-content: space-between; align-items: center; padding: 10px 16px; margin-bottom: 12px;">
        <span style="font-weight: 700; font-size: 15px; color: #60a5fa;">{{ $allPost1992Article['section'] }}</span>
        @php
            $isBookmarked = false;
            if (auth()->check()) {
                $isBookmarked = \App\UserBookmark::where('user_id', auth()->id())
                    ->where(function($q) use ($allPost1992Article) {
                        $q->where('section_id', $allPost1992Article['id'])
                          ->orWhere('user_section', auth()->id() . '_legislation_' . $allPost1992Article['act_id'] . '_' . $allPost1992Article['id']);
                    })->exists();
            }
        @endphp
        <button type="button" 
                class="btn-bookmark-toggle {{ $isBookmarked ? 'is-bookmarked' : '' }}" 
                data-act-title="{{ $allPost1992Article['post_act'] }}" 
                data-act-section="{{ $allPost1992Article['section'] }}" 
                data-section-id="{{ $allPost1992Article['id'] }}" 
                data-act-id="{{ $allPost1992Article['act_id'] }}" 
                data-act-group="{{ $allPost1992Article['act_group'] ?? 'Acts of Parliament' }}" 
                data-doc-type="legislation" 
                data-page-url="/new-laws/table-of-content/{{ $allPost1992Article['act_group'] }}/{{ $allPost1992Article['post_act'] }}/{{ $allPost1992Article['act_id'] }}"
                title="{{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark this section' }}"
                onclick="toggleBookmark(this)">
            <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
        </button>
    </div>

    <div style="margin-bottom: 12px;">
        <div class="menu_options" style="display: flex; gap: 12px; justify-content: flex-end; align-items: center;">
            @if (Route::has('login'))
                @auth
                    <a class="download_link" href="javascript:;" rel="/new-laws/pdf-section-content/{{$allPost1992Article['post_act']}}/{{ $allPost1992Article['id'] }}" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><img alt="PDF" src="{{ asset('/logo/pdf.png') }}" style="width:1.3em; vertical-align: middle;">&nbsp;PDF</a>
                    <a href="/new-laws/print_section_content/{{ $allPost1992Article['id'] }}" target="_blank" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><i class="fa-solid fa-print"></i>&nbsp;Print</a>
                @else
                    <a href="javascript:;" onclick="openLoginModal()" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><img alt="PDF" src="{{ asset('/logo/pdf.png') }}" style="width:1.3em; vertical-align: middle;">&nbsp;PDF</a>
                    <a href="javascript:;" onclick="openLoginModal()" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><i class="fa-solid fa-print"></i>&nbsp;Print</a>
                @endauth
            @endif
        </div>
    </div>

    <div class="content">            
        <p>{!! $allPost1992Article['content'] !!}</p>
    </div>

@include('partials._bookmark_script')
@include('partials._premium_guest_gate')
</body>
</html>
