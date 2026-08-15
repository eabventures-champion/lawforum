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
        <span style="font-weight: 700; font-size: 15px; color: #60a5fa;">{{ $regulationAct['section'] }}</span>
        @php
            $isBookmarked = false;
            if (auth()->check()) {
                $isBookmarked = \App\UserBookmark::where('user_id', auth()->id())
                    ->where(function($q) use ($regulationAct) {
                        $q->where('section_id', $regulationAct['id'])
                          ->orWhere('user_section', auth()->id() . '_legislation_' . $regulationAct['act_id'] . '_' . $regulationAct['id']);
                    })->exists();
            }
        @endphp
        <button type="button" 
                class="btn-bookmark-toggle {{ $isBookmarked ? 'is-bookmarked' : '' }}" 
                data-act-title="{{ $regulationAct['regulation_title'] }}" 
                data-act-section="{{ $regulationAct['section'] }}" 
                data-section-id="{{ $regulationAct['id'] }}" 
                data-act-id="{{ $regulationAct['act_id'] }}" 
                data-act-group="{{ $regulationAct['act_group'] ?? 'Legislative Instruments' }}" 
                data-doc-type="legislation" 
                data-page-url="/new-laws/regulation_acts_table_of_content/{{ $regulationAct['act_group'] }}/{{ $regulationAct['regulation_title'] }}/{{ $regulationAct['act_id'] }}"
                title="{{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark this section' }}"
                onclick="toggleBookmark(this)">
            <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
        </button>
    </div>

    <div style="margin-bottom: 12px;">
        <div class="menu_options" style="display: flex; gap: 12px; justify-content: flex-end; align-items: center;">
            @if (Route::has('login'))
                @auth
                    <a class="download_link" href="javascript:;" rel="/new-laws/regulation-acts/pdf-section-content/{{$regulationAct['regulation_title']}}/{{ $regulationAct['id'] }}" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><img alt="PDF" src="{{ asset('/logo/pdf.png') }}" style="width:1.3em; vertical-align: middle;">&nbsp;PDF</a>
                    <a href="/new-laws/regulation-acts/print_section_content/{{ $regulationAct['id'] }}" target="_blank" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><i class="fa-solid fa-print"></i>&nbsp;Print</a>
                @else
                    <a href="javascript:;" onclick="openLoginModal()" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><img alt="PDF" src="{{ asset('/logo/pdf.png') }}" style="width:1.3em; vertical-align: middle;">&nbsp;PDF</a>
                    <a href="javascript:;" onclick="openLoginModal()" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><i class="fa-solid fa-print"></i>&nbsp;Print</a>
                @endauth
            @endif
        </div>
    </div>

    <div class="content">            
        <p>{!! $regulationAct['content'] !!}</p>
    </div>

@include('partials._bookmark_script')
@include('partials._premium_guest_gate')
</body>
</html>
