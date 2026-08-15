<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/tooltipster.bundle.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/tooltipster-sideTip-borderless.min.css') }}" type="text/css"> 
    <style>
        .nav-links {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
            margin-bottom: 14px;
        }
        .nav-links span {
            font-weight: 700;
            font-size: 15px;
            color: #60a5fa;
        }
    </style>   
    @include('partials._nav_subdropdown_styles')
</head>

<body>
    <div class="nav-links">
        <span><i class="fa-solid fa-scale-balanced mr-2"></i> Preamble & Introductory Text</span>
        @php
            $isBookmarked = false;
            if (auth()->check()) {
                $isBookmarked = \App\UserBookmark::where('user_id', auth()->id())
                    ->where(function($q) use ($ghana_act) {
                        $q->where('section_id', 0)
                          ->orWhere('user_section', auth()->id() . '_constitution_' . ($ghana_act['id'] ?? 1) . '_preamble');
                    })->exists();
            }
        @endphp
        <button type="button" 
                class="btn-bookmark-toggle {{ $isBookmarked ? 'is-bookmarked' : '' }}" 
                data-act-title="The Constitution of the Republic of Ghana 1992" 
                data-act-section="Preamble" 
                data-section-id="0" 
                data-act-id="{{ $ghana_act['id'] ?? 1 }}" 
                data-act-group="Constitution" 
                data-doc-type="constitution" 
                data-page-url="/constitution/Republic/Ghana/1"
                title="{{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark this section' }}"
                onclick="toggleBookmark(this)">
            <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
        </button>
    </div>

    <div class="content">	
        <p>{!! $ghana_act['preamble'] !!}</p>  
    </div>

@include('partials._bookmark_script')
@include('partials._premium_guest_gate')
</body>
</html>
