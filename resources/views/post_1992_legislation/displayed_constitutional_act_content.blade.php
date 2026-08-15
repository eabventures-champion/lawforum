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
        <span style="font-weight: 700; font-size: 15px; color: #60a5fa;">{{ $allConstitutionalAct['section'] }}</span>
        @php
            $isBookmarked = false;
            if (auth()->check()) {
                $isBookmarked = \App\UserBookmark::where('user_id', auth()->id())
                    ->where(function($q) use ($allConstitutionalAct) {
                        $q->where('section_id', $allConstitutionalAct['id'])
                          ->orWhere('user_section', auth()->id() . '_legislation_' . $allConstitutionalAct['consti_act_id'] . '_' . $allConstitutionalAct['id']);
                    })->exists();
            }
        @endphp
        <button type="button" 
                class="btn-bookmark-toggle {{ $isBookmarked ? 'is-bookmarked' : '' }}" 
                data-act-title="{{ $allConstitutionalAct['constitutional_act'] }}" 
                data-act-section="{{ $allConstitutionalAct['section'] }}" 
                data-section-id="{{ $allConstitutionalAct['id'] }}" 
                data-act-id="{{ $allConstitutionalAct['consti_act_id'] }}" 
                data-act-group="{{ $allConstitutionalAct['consti_group'] ?? 'Constitutional Acts' }}" 
                data-doc-type="legislation" 
                data-page-url="/new-laws/constitutional-acts-table-of-content/{{ $allConstitutionalAct['consti_group'] }}/{{ $allConstitutionalAct['constitutional_act'] }}/{{ $allConstitutionalAct['consti_act_id'] }}"
                title="{{ $isBookmarked ? 'Remove Bookmark' : 'Bookmark this section' }}"
                onclick="toggleBookmark(this)">
            <i class="{{ $isBookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
        </button>
    </div>

    <div style="margin-bottom: 12px;">
        <div class="menu_options" style="display: flex; gap: 12px; justify-content: flex-end; align-items: center;">
            @if (Route::has('login'))
                @auth
                    <a class="download_link" href="javascript:;" rel="/new-laws/constitutional-acts/pdf-section-content/{{$allConstitutionalAct['constitutional_act']}}/{{ $allConstitutionalAct['id'] }}" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><img alt="PDF" src="{{ asset('/logo/pdf.png') }}" style="width:1.3em; vertical-align: middle;">&nbsp;PDF</a>
                    <a href="/new-laws/constitutional-acts/print_section_content/{{ $allConstitutionalAct['id'] }}" target="_blank" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><i class="fa-solid fa-print"></i>&nbsp;Print</a>
                @else
                    <a href="javascript:;" onclick="openLoginModal()" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><img alt="PDF" src="{{ asset('/logo/pdf.png') }}" style="width:1.3em; vertical-align: middle;">&nbsp;PDF</a>
                    <a href="javascript:;" onclick="openLoginModal()" style="color: #60a5fa; text-decoration: none; font-size: 13px;"><i class="fa-solid fa-print"></i>&nbsp;Print</a>
                @endauth
            @endif
        </div>
    </div>

    <div class="content">            
        <p>{!! $allConstitutionalAct['content'] !!}</p>
    </div>

@include('partials._bookmark_script')
@include('partials._premium_guest_gate')
</body>
</html>
