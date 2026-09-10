@extends('layouts.admin')

@section('title', 'News & Articles')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 class="page-title">News & Articles</h1>
        <p class="page-subtitle">Manage legal news, articles, and blog updates.</p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 13.5px; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-plus"></i>
            <span>Write New Article</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-color); color: var(--success-color); padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@php
    $isNewsComingSoon = homepage_setting('slide_1_news_coming_soon', '1') == '1';
    $countdownTarget = homepage_setting('slide_1_news_countdown_target', '');
    $formattedCountdownTarget = null;
    $diffCountdownTarget = null;
    $inputCountdownTarget = '';
    if (!empty($countdownTarget)) {
        try {
            $parsedDate = \Carbon\Carbon::parse($countdownTarget);
            $formattedCountdownTarget = $parsedDate->format('M j, Y g:i A');
            $diffCountdownTarget = $parsedDate->diffForHumans();
            $inputCountdownTarget = $parsedDate->format('Y-m-d\TH:i');
        } catch (\Exception $e) {
            $formattedCountdownTarget = null;
        }
    }
@endphp

<!-- Legal News Dynamic Coming Soon Control Card -->
<div style="background: {{ $isNewsComingSoon ? 'rgba(244, 63, 94, 0.06)' : 'rgba(16, 185, 129, 0.06)' }}; border: 1px solid {{ $isNewsComingSoon ? 'rgba(244, 63, 94, 0.3)' : 'rgba(16, 185, 129, 0.3)' }}; border-radius: 14px; padding: 18px 24px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 14px;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: {{ $isNewsComingSoon ? 'rgba(244, 63, 94, 0.15)' : 'rgba(16, 185, 129, 0.15)' }}; color: {{ $isNewsComingSoon ? '#fb7185' : '#34d399' }}; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fa-solid {{ $isNewsComingSoon ? 'fa-clock' : 'fa-globe' }}"></i>
        </div>
        <div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span style="font-size: 15px; font-weight: 700; color: #fff;">Legal News Public Status:</span>
                @if($isNewsComingSoon)
                    <span style="background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.35); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #fb7185; display: inline-block;"></span> COMING SOON MODE (ACTIVE)
                    </span>
                @else
                    <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #34d399; display: inline-block;"></span> LIVE & PUBLIC
                    </span>
                @endif
            </div>
            <p style="color: var(--text-secondary); font-size: 12.5px; margin: 4px 0 0;">
                @if($isNewsComingSoon)
                    Homepage card is currently disabled with a Coming Soon badge, and public navigation to news content is blocked.
                @else
                    Legal News is fully live: visitors can click through from the homepage and browse all published news articles.
                @endif
            </p>
        </div>
    </div>
    <form action="{{ route('admin.news.toggle-coming-soon') }}" method="POST" style="margin: 0;">
        @csrf
        <button type="submit" class="btn" style="height: 38px; padding: 0 18px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s; {{ $isNewsComingSoon ? 'background: #10b981; color: #fff; border: 1px solid #10b981;' : 'background: rgba(244, 63, 94, 0.18); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.4);' }}">
            <i class="fa-solid {{ $isNewsComingSoon ? 'fa-globe' : 'fa-lock' }}"></i>
            <span>{{ $isNewsComingSoon ? 'Switch to Live Mode' : 'Switch to Coming Soon' }}</span>
        </button>
    </form>
</div>

<!-- Coming Soon Countdown Timer Settings Card -->
<div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 14px; padding: 20px 24px; margin-bottom: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 16px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-stopwatch"></i>
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span style="font-size: 15px; font-weight: 700; color: #fff;">Coming Soon Launch Countdown Timer:</span>
                    @if($formattedCountdownTarget)
                        <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-calendar-check"></i> {{ $formattedCountdownTarget }} ({{ $diffCountdownTarget }})
                        </span>
                    @else
                        <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.35); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-clock-rotate-left"></i> Default Rolling (+28 Days)
                        </span>
                    @endif
                </div>
                <p style="color: var(--text-secondary); font-size: 12.5px; margin: 4px 0 0;">
                    Controls the live Days / Hours / Minutes / Seconds countdown clock shown to visitors on the Coming Soon page.
                </p>
            </div>
        </div>

        <!-- Quick Reset to Default Form -->
        <form action="{{ route('admin.news.update-countdown') }}" method="POST" style="margin: 0;">
            @csrf
            <input type="hidden" name="action" value="reset_default">
            <button type="submit" class="btn" style="height: 36px; padding: 0 14px; border-radius: 8px; font-size: 12px; font-weight: 600; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.15); color: var(--text-secondary); display: inline-flex; align-items: center; gap: 6px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.borderColor='rgba(255,255,255,0.3)';" onmouseout="this.style.color='var(--text-secondary)'; this.style.borderColor='rgba(255,255,255,0.15)';">
                <i class="fa-solid fa-rotate-left"></i>
                <span>Reset to Default (+28 Days)</span>
            </button>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; align-items: center; background: rgba(0, 0, 0, 0.2); padding: 14px 18px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.05);">
        <!-- Quick Presets -->
        <div>
            <span style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 8px;">
                <i class="fa-solid fa-bolt" style="color: #f59e0b; margin-right: 4px;"></i> Quick Reset Presets:
            </span>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                @foreach([7 => '7 Days', 14 => '14 Days', 21 => '21 Days', 30 => '30 Days', 60 => '60 Days'] as $days => $label)
                <form action="{{ route('admin.news.update-countdown') }}" method="POST" style="margin: 0; display: inline-block;">
                    @csrf
                    <input type="hidden" name="preset_days" value="{{ $days }}">
                    <button type="submit" style="background: rgba(59, 130, 246, 0.12); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 6px; padding: 6px 12px; font-size: 11.5px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#3b82f6'; this.style.color='#fff';" onmouseout="this.style.background='rgba(59, 130, 246, 0.12)'; this.style.color='#93c5fd';">
                        +{{ $label }}
                    </button>
                </form>
                @endforeach
            </div>
        </div>

        <!-- Custom Date & Time Picker -->
        <form action="{{ route('admin.news.update-countdown') }}" method="POST" style="margin: 0; display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
            @csrf
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                    <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i> Pick Exact Target Date & Time:
                </label>
                <input type="datetime-local" name="countdown_target" value="{{ $inputCountdownTarget }}" required min="{{ now()->format('Y-m-d\TH:i') }}" style="width: 100%; height: 36px; background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 6px; padding: 0 10px; color: #fff; font-size: 12.5px; font-family: inherit; outline: none;">
            </div>
            <button type="submit" class="btn btn-primary" style="height: 36px; padding: 0 16px; border-radius: 6px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; white-space: nowrap;">
                <i class="fa-solid fa-check"></i>
                <span>Set Date</span>
            </button>
        </form>
    </div>
</div>

<!-- Newsroom Navigation Tabs Dynamic Controls -->
@if(isset($categories) && count($categories) > 0)
<div class="card-table" style="width: 100%; margin-bottom: 28px; padding: 22px 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <h2 style="font-size: 17px; font-weight: 700; color: #fff; margin: 0;">Newsroom Navigation Tabs</h2>
                <p style="font-size: 12.5px; color: var(--text-secondary); margin: 2px 0 0;">
                    Dynamically enable or disable category tabs in the public newsroom header and mobile navigation. Disabled tabs are hidden from visitors.
                </p>
            </div>
        </div>
        <div style="font-size: 12px; color: var(--text-muted);">
            <i class="fa-solid fa-circle-info" style="color: #60a5fa; margin-right: 4px;"></i> Click any button to toggle tab visibility instantly
        </div>
    </div>

    <!-- Category Pills Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
        @foreach($categories as $cat)
        @php
            $isEnabled = (bool)$cat->is_enabled;
            $cleanName = str_replace('-', ' ', $cat->name);
        @endphp
        <div id="cat-card-{{ $cat->id }}" style="background: {{ $isEnabled ? 'rgba(255, 255, 255, 0.03)' : 'rgba(255, 255, 255, 0.01)' }}; border: 1px solid {{ $isEnabled ? 'rgba(59, 130, 246, 0.3)' : 'rgba(255, 255, 255, 0.08)' }}; border-radius: 12px; padding: 16px 18px; display: flex; flex-direction: column; justify-content: space-between; gap: 14px; transition: all 0.25s ease;">
            <!-- Top Row: Icon, Category Name, Article Count, and Status Badge -->
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                    <div id="cat-icon-{{ $cat->id }}" style="width: 38px; height: 38px; border-radius: 10px; background: {{ $isEnabled ? 'rgba(59, 130, 246, 0.15)' : 'rgba(255, 255, 255, 0.05)' }}; color: {{ $isEnabled ? '#60a5fa' : 'var(--text-muted)' }}; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                        @if(str_contains(strtolower($cat->name), 'ghana'))
                            <i class="fa-solid fa-flag"></i>
                        @elseif(str_contains(strtolower($cat->name), 'africa'))
                            <i class="fa-solid fa-earth-africa"></i>
                        @elseif(str_contains(strtolower($cat->name), 'europe'))
                            <i class="fa-solid fa-earth-europe"></i>
                        @elseif(str_contains(strtolower($cat->name), 'america'))
                            <i class="fa-solid fa-earth-americas"></i>
                        @elseif(str_contains(strtolower($cat->name), 'asia'))
                            <i class="fa-solid fa-earth-asia"></i>
                        @else
                            <i class="fa-regular fa-newspaper"></i>
                        @endif
                    </div>
                    <div style="min-width: 0;">
                        <div id="cat-name-{{ $cat->id }}" style="font-size: 15px; font-weight: 700; color: {{ $isEnabled ? '#fff' : 'var(--text-muted)' }}; white-space: nowrap; line-height: 1.2;">
                            {{ $cleanName }}
                        </div>
                        <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px; display: flex; align-items: center; gap: 5px; white-space: nowrap;">
                            <i class="fa-regular fa-newspaper" style="font-size: 10.5px; opacity: 0.7;"></i>
                            <span>{{ $cat->articles_count ?? 0 }} articles</span>
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <span id="cat-badge-{{ $cat->id }}" style="font-size: 10px; font-weight: 700; padding: 3px 9px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; flex-shrink: 0; white-space: nowrap; {{ $isEnabled ? 'background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);' : 'background: rgba(100, 116, 139, 0.15); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3);' }}">
                    {{ $isEnabled ? 'Visible' : 'Hidden' }}
                </span>
            </div>

            <!-- Bottom Row: Header Tab status indicator & Toggle Action Button -->
            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 12px; border-top: 1px solid rgba(255, 255, 255, 0.05); gap: 10px;">
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted); white-space: nowrap;">
                    <span id="cat-dot-{{ $cat->id }}" style="width: 7px; height: 7px; border-radius: 50%; background: {{ $isEnabled ? '#34d399' : '#94a3b8' }}; display: inline-block;"></span>
                    <span>Header Tab</span>
                </div>
                <form action="{{ route('admin.news.categories.toggle', $cat->id) }}" method="POST" class="cat-toggle-form" data-id="{{ $cat->id }}" style="margin: 0;">
                    @csrf
                    <button type="submit" id="cat-toggle-btn-{{ $cat->id }}" class="btn" style="height: 30px; padding: 0 12px; border-radius: 6px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; transition: all 0.2s; white-space: nowrap; {{ $isEnabled ? 'background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.35);' : 'background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);' }}">
                        <i class="fa-solid {{ $isEnabled ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                        <span>{{ $isEnabled ? 'Disable Tab' : 'Enable Tab' }}</span>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Audience & Subscribers Management Card -->
@php
    $subscriberList = $launchInvitations ?? collect();
    $digestCount = $subscriberList->where('source', 'digest')->count();
    $launchCount = $subscriberList->where('source', 'launch')->count();
    $allEmailsString = $subscriberList->pluck('email')->implode(', ');
@endphp
<div class="card-table" style="width: 100%; margin-bottom: 28px; padding: 22px 24px; border: 1px solid rgba(59, 130, 246, 0.25); background: rgba(15, 23, 42, 0.65); border-radius: 14px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 18px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                <i class="fa-solid fa-users-viewfinder"></i>
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <h2 style="font-size: 17px; font-weight: 700; color: #fff; margin: 0;">Subscribers & Audience Lists</h2>
                    @if($subscriberList->count() > 0)
                        <span style="background: rgba(59, 130, 246, 0.15); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.35); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-envelope"></i> {{ $subscriberList->count() }} Total {{ Str::plural('Subscriber', $subscriberList->count()) }}
                        </span>
                        <span style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-newspaper"></i> {{ $digestCount }} Digest
                        </span>
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-rocket"></i> {{ $launchCount }} Launch VIP
                        </span>
                    @else
                        <span style="background: rgba(148, 163, 184, 0.12); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.25); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            0 Subscribers
                        </span>
                    @endif
                </div>
                <p style="font-size: 12.5px; color: var(--text-secondary); margin: 3px 0 0;">
                    All audiences collected from the <strong>Legal Intelligence Digest</strong> weekly newsletter widget and the <strong>Coming Soon</strong> Launch Day invitation form.
                </p>
            </div>
        </div>

        @if($subscriberList->count() > 0)
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Copy All Button -->
            <button type="button" onclick="copyAllSubscriberEmails()" id="btnCopyAllEmails" class="btn btn-secondary btn-action" style="height: 36px; padding: 0 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; background: rgba(59, 130, 246, 0.12); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3);">
                <i class="fa-regular fa-copy"></i>
                <span id="btnCopyText">Copy Filtered Emails</span>
            </button>

            <!-- Mailto Button -->
            <a id="btnSendEmail" href="mailto:?bcc={{ rawurlencode($allEmailsString) }}&subject={{ rawurlencode('Legals Forum Update & Intelligence') }}" class="btn btn-primary btn-action" style="height: 36px; padding: 0 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Send Email</span>
            </a>
        </div>
        @endif
    </div>

    @if($subscriberList->count() > 0)
        <!-- Audience Filter Pills -->
        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-bottom: 16px;">
            <span style="font-size: 12px; font-weight: 600; color: var(--text-muted); margin-right: 4px;">Filter Audience:</span>
            <button type="button" onclick="filterSubscriberList('all')" id="sub-filter-all" class="sub-filter-btn" style="background: #3b82f6; color: #fff; border: 1px solid #3b82f6; border-radius: 20px; padding: 4px 14px; font-size: 11.5px; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                All ({{ $subscriberList->count() }})
            </button>
            <button type="button" onclick="filterSubscriberList('digest')" id="sub-filter-digest" class="sub-filter-btn" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 20px; padding: 4px 14px; font-size: 11.5px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                <i class="fa-solid fa-newspaper" style="margin-right: 4px;"></i> Legal Intelligence Digest ({{ $digestCount }})
            </button>
            <button type="button" onclick="filterSubscriberList('launch')" id="sub-filter-launch" class="sub-filter-btn" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 20px; padding: 4px 14px; font-size: 11.5px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                <i class="fa-solid fa-rocket" style="margin-right: 4px;"></i> Launch Day VIP ({{ $launchCount }})
            </button>
        </div>

        <div style="overflow-x: auto; width: 100%; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.06);">
            <table class="custom-table" style="width: 100%; margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">#</th>
                        <th style="min-width: 260px;">Subscriber Email</th>
                        <th style="width: 200px;">Registered Date</th>
                        <th style="width: 140px;">IP Address</th>
                        <th style="width: 110px;">Status</th>
                        <th style="width: 100px; text-align: right; padding-right: 20px;">Action</th>
                    </tr>
                </thead>
                <tbody id="subscriber-table-body">
                    @foreach($subscriberList as $index => $invitation)
                        <tr class="subscriber-row" data-source="{{ $invitation->source ?? 'launch' }}" data-email="{{ $invitation->email }}">
                            <td style="text-align: center; color: var(--text-muted); font-size: 12.5px;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: {{ ($invitation->source === 'digest') ? 'rgba(168, 85, 247, 0.18)' : 'rgba(16, 185, 129, 0.18)' }}; color: {{ ($invitation->source === 'digest') ? '#c084fc' : '#34d399' }}; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; text-transform: uppercase; flex-shrink: 0;">
                                        {{ substr($invitation->email, 0, 2) }}
                                    </div>
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <a href="mailto:{{ $invitation->email }}" style="font-weight: 600; color: #fff; font-size: 13.5px; text-decoration: none;" onmouseover="this.style.color='#60a5fa'" onmouseout="this.style.color='#fff'">
                                                {{ $invitation->email }}
                                            </a>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ $invitation->email }}'); this.innerHTML='<i class=\'fa-solid fa-check\'></i>'; setTimeout(() => this.innerHTML='<i class=\'fa-regular fa-copy\'></i>', 1200);" title="Copy email" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 2px 4px; font-size: 11px;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-muted)'">
                                                <i class="fa-regular fa-copy"></i>
                                            </button>
                                        </div>
                                        <div style="margin-top: 4px;">
                                            @if($invitation->source === 'digest')
                                                <span style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                                    <i class="fa-solid fa-newspaper" style="font-size: 10px;"></i> Legal Intelligence Digest
                                                </span>
                                            @else
                                                <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                                    <i class="fa-solid fa-rocket" style="font-size: 10px;"></i> Launch Day VIP
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="color: #e2e8f0; font-weight: 500; font-size: 12.5px; white-space: nowrap;">
                                    {{ $invitation->created_at ? $invitation->created_at->format('M d, Y h:i A') : 'N/A' }}
                                </div>
                                <div style="color: var(--text-secondary); font-size: 11px; margin-top: 2px; white-space: nowrap;">
                                    {{ $invitation->created_at ? $invitation->created_at->diffForHumans() : '' }}
                                </div>
                            </td>
                            <td>
                                <span style="font-family: monospace; font-size: 11.5px; color: var(--text-secondary); background: rgba(255, 255, 255, 0.04); padding: 2px 8px; border-radius: 4px; border: 1px solid rgba(255, 255, 255, 0.06);">
                                    {{ $invitation->ip_address ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i> Active
                                </span>
                            </td>
                            <td style="text-align: right; padding-right: 20px;">
                                <form action="{{ route('admin.news.launch-invitations.destroy', $invitation->id) }}" method="POST" style="margin: 0; display: inline-block;" onsubmit="return confirm('Remove {{ $invitation->email }} from {{ $invitation->source === "digest" ? "Legal Intelligence Digest" : "VIP Launch list" }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-action" style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;" title="Remove subscriber">
                                        <i class="fa-regular fa-trash-can"></i>
                                        <span>Remove</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 36px 16px; background: rgba(0, 0, 0, 0.15); border-radius: 8px; border: 1px dashed rgba(255, 255, 255, 0.1);">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255, 255, 255, 0.05); color: var(--text-muted); display: inline-flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 12px;">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <h4 style="font-size: 14.5px; font-weight: 600; color: #fff; margin-bottom: 6px;">No Subscribers Recorded Yet</h4>
            <p style="font-size: 12.5px; color: var(--text-secondary); max-width: 480px; margin: 0 auto;">
                When visitors subscribe to the <strong>Legal Intelligence Digest</strong> or register on the <strong>Coming Soon</strong> Launch Day card, their emails and registration details will appear here automatically.
            </p>
        </div>
    @endif
</div>

<div class="card-table" style="width: 100%; margin-bottom: 40px;">
    <!-- Header with Title, Actions & Search -->
    <div class="table-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding: 20px 24px;">
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <h2 class="table-title" style="margin-bottom: 0; font-size: 20px;">All News Articles</h2>
            <span style="background: rgba(59, 130, 246, 0.12); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25); font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-newspaper" style="font-size: 11px;"></i> <span id="news-total-count">{{ number_format($news->total()) }}</span> Articles
            </span>

            <!-- Delete All Button -->
            <form action="{{ route('admin.news.destroy-all') }}" method="POST" id="delete-all-form" style="display: {{ $news->total() > 0 ? 'inline-block' : 'none' }}; margin: 0;" onsubmit="return confirm('⚠️ CAUTION: Are you sure you want to delete ALL news articles? This will permanently remove all articles and images.')">
                @csrf
                @method('DELETE')
                <button type="submit" id="delete-all-btn" class="btn btn-danger btn-action" style="height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 7px;">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Delete All (<span id="delete-all-count">{{ $news->total() }}</span>)</span>
                </button>
            </form>

            <!-- Bulk Delete Selected Button -->
            <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-action" style="display: none; height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 600; align-items: center; gap: 7px;" onclick="submitBulkDelete()">
                <i class="fa-solid fa-trash"></i>
                <span>Delete Selected (<span id="selected-count">0</span>)</span>
            </button>
        </div>
        
        <!-- Live Search Form -->
        <form id="news-search-form" action="{{ route('admin.news.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;" onsubmit="event.preventDefault(); fetchNews();">
            <div style="position: relative; width: 280px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 13px; pointer-events: none;"></i>
                <input type="text" name="search" id="news-search-input" class="form-control" placeholder="Search news by title or content..." value="{{ request('search') }}" autocomplete="off" style="padding-left: 38px; padding-right: 32px; height: 38px; border-radius: 8px; font-size: 13px; width: 100%;">
                <span id="search-spinner" style="display: none; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--accent-color); font-size: 12px;">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </span>
            </div>
            <button type="submit" class="btn btn-primary btn-action" style="height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                <span>Search</span>
            </button>
            <button type="button" id="news-clear-search-btn" onclick="clearNewsSearch()" class="btn btn-secondary btn-action" style="display: {{ request('search') ? 'inline-flex' : 'none' }}; height: 38px; padding: 0 14px; border-radius: 8px; font-size: 13px; align-items: center; gap: 6px; color: var(--text-secondary); background: rgba(255,255,255,0.04); border: 1px solid var(--border-color);">
                <i class="fa-solid fa-rotate-left"></i> Clear
            </button>
        </form>
    </div>

    <!-- Table Container (Dynamically updated via Live Search) -->
    <div id="news-table-wrapper">
        @include('admin.news.table_data')
    </div>
</div>

<!-- Bulk Delete Form -->
<form id="bulk-delete-form" action="{{ route('admin.news.bulk-destroy') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@section('scripts')
<script>
    let activeAjax = null;
    let debounceTimer = null;

    function fetchNews(url = null) {
        const tableWrapper = document.getElementById('news-table-wrapper');
        const searchInput = document.getElementById('news-search-input');
        const spinner = document.getElementById('search-spinner');
        const clearBtn = document.getElementById('news-clear-search-btn');
        const bulkBtn = document.getElementById('bulk-delete-btn');
        const totalCountSpan = document.getElementById('news-total-count');
        const deleteAllForm = document.getElementById('delete-all-form');
        const deleteAllCountSpan = document.getElementById('delete-all-count');

        if (bulkBtn) bulkBtn.style.display = 'none';

        if (!url) {
            const query = searchInput ? searchInput.value.trim() : '';
            const params = new URLSearchParams();
            if (query) params.set('search', query);
            url = "{{ route('admin.news.index') }}" + (params.toString() ? '?' + params.toString() : '');
        }

        // Toggle clear button visibility
        if (clearBtn && searchInput) {
            clearBtn.style.display = searchInput.value.trim() ? 'inline-flex' : 'none';
        }

        if (spinner) spinner.style.display = 'block';
        if (tableWrapper) {
            tableWrapper.style.opacity = '0.5';
            tableWrapper.style.transition = 'opacity 0.15s ease-in-out';
        }

        if (activeAjax) {
            activeAjax.abort();
        }

        activeAjax = new AbortController();
        const signal = activeAjax.signal;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            signal: signal
        })
        .then(res => res.json())
        .then(data => {
            if (spinner) spinner.style.display = 'none';
            if (tableWrapper) {
                tableWrapper.innerHTML = data.html;
                tableWrapper.style.opacity = '1';
            }

            if (totalCountSpan && data.total !== undefined) {
                totalCountSpan.textContent = Number(data.total).toLocaleString();
            }

            if (deleteAllCountSpan && data.total !== undefined) {
                deleteAllCountSpan.textContent = Number(data.total).toLocaleString();
            }

            if (deleteAllForm) {
                deleteAllForm.style.display = data.total > 0 ? 'inline-block' : 'none';
            }

            window.history.pushState({}, '', url);
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                if (spinner) spinner.style.display = 'none';
                if (tableWrapper) tableWrapper.style.opacity = '1';
                console.error('Error in live search:', err);
            }
        });
    }

    function clearNewsSearch() {
        const searchInput = document.getElementById('news-search-input');
        if (searchInput) {
            searchInput.value = '';
            fetchNews();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('news-search-input');
        const tableWrapper = document.getElementById('news-table-wrapper');
        const bulkBtn = document.getElementById('bulk-delete-btn');
        const selectedCount = document.getElementById('selected-count');

        // Live search on input with 300ms debounce
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchNews();
                }, 300);
            });
        }

        function updateBulkState() {
            const checked = document.querySelectorAll('.news-checkbox:checked');
            if (checked.length > 0) {
                if (bulkBtn) bulkBtn.style.display = 'inline-flex';
                if (selectedCount) selectedCount.textContent = checked.length;
            } else {
                if (bulkBtn) bulkBtn.style.display = 'none';
            }
        }

        // Delegated event listener for checkboxes (works after dynamic AJAX reload)
        if (tableWrapper) {
            tableWrapper.addEventListener('change', function(e) {
                if (e.target && e.target.id === 'select-all-news') {
                    const checkboxes = document.querySelectorAll('.news-checkbox');
                    checkboxes.forEach(cb => cb.checked = e.target.checked);
                    updateBulkState();
                } else if (e.target && e.target.classList.contains('news-checkbox')) {
                    const selectAll = document.getElementById('select-all-news');
                    const checkboxes = document.querySelectorAll('.news-checkbox');
                    if (!e.target.checked && selectAll) {
                        selectAll.checked = false;
                    } else if (selectAll) {
                        selectAll.checked = document.querySelectorAll('.news-checkbox:checked').length === checkboxes.length;
                    }
                    updateBulkState();
                }
            });

            // Delegated click handler for pagination links
            tableWrapper.addEventListener('click', function(e) {
                const link = e.target.closest('.pagination-wrapper a');
                if (link) {
                    e.preventDefault();
                    fetchNews(link.getAttribute('href'));
                }
            });
        }

        // Category Tab AJAX Toggle Handler
        document.querySelectorAll('.cat-toggle-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const catId = this.dataset.id;
                const btn = document.getElementById('cat-toggle-btn-' + catId);
                const card = document.getElementById('cat-card-' + catId);
                const badge = document.getElementById('cat-badge-' + catId);
                const icon = document.getElementById('cat-icon-' + catId);
                const name = document.getElementById('cat-name-' + catId);
                const dot = document.getElementById('cat-dot-' + catId);
                const origHtml = btn.innerHTML;

                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Updating...';

                const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                    ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                    : form.querySelector('input[name="_token"]').value;

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    if (data.success) {
                        const isEnabled = data.is_enabled;
                        if (dot) dot.style.background = isEnabled ? '#34d399' : '#94a3b8';
                        if (isEnabled) {
                            card.style.background = 'rgba(255, 255, 255, 0.03)';
                            card.style.borderColor = 'rgba(59, 130, 246, 0.3)';
                            badge.style.background = 'rgba(16, 185, 129, 0.15)';
                            badge.style.color = '#34d399';
                            badge.style.border = '1px solid rgba(16, 185, 129, 0.3)';
                            badge.textContent = 'Visible';

                            icon.style.background = 'rgba(59, 130, 246, 0.15)';
                            icon.style.color = '#60a5fa';
                            name.style.color = '#fff';

                            btn.style.background = 'rgba(244, 63, 94, 0.15)';
                            btn.style.color = '#fb7185';
                            btn.style.border = '1px solid rgba(244, 63, 94, 0.35)';
                            btn.innerHTML = '<i class="fa-solid fa-eye-slash"></i> <span>Disable Tab</span>';
                        } else {
                            card.style.background = 'rgba(255, 255, 255, 0.01)';
                            card.style.borderColor = 'rgba(255, 255, 255, 0.08)';
                            badge.style.background = 'rgba(100, 116, 139, 0.15)';
                            badge.style.color = '#94a3b8';
                            badge.style.border = '1px solid rgba(100, 116, 139, 0.3)';
                            badge.textContent = 'Hidden';

                            icon.style.background = 'rgba(255, 255, 255, 0.05)';
                            icon.style.color = 'var(--text-muted)';
                            name.style.color = 'var(--text-muted)';

                            btn.style.background = 'rgba(16, 185, 129, 0.15)';
                            btn.style.color = '#34d399';
                            btn.style.border = '1px solid rgba(16, 185, 129, 0.35)';
                            btn.innerHTML = '<i class="fa-solid fa-eye"></i> <span>Enable Tab</span>';
                        }
                    } else {
                        btn.innerHTML = origHtml;
                        alert('Failed to update category status.');
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = origHtml;
                    console.error('Error toggling category status:', err);
                    alert('Error updating category status.');
                });
            });
        });
    });

    function submitBulkDelete() {
        const checked = document.querySelectorAll('.news-checkbox:checked');
        if (checked.length === 0) return;

        if (confirm(`Are you sure you want to delete ${checked.length} selected news article(s)? This cannot be undone.`)) {
            const ids = Array.from(checked).map(cb => cb.value);
            document.getElementById('bulk-delete-ids').value = JSON.stringify(ids);
            document.getElementById('bulk-delete-form').submit();
        }
    }

    let activeSubFilter = 'all';

    function filterSubscriberList(source) {
        activeSubFilter = source;
        const rows = document.querySelectorAll('.subscriber-row');
        const filterBtns = document.querySelectorAll('.sub-filter-btn');

        filterBtns.forEach(btn => {
            btn.style.background = 'rgba(255, 255, 255, 0.05)';
            btn.style.color = 'var(--text-secondary)';
            btn.style.borderColor = 'rgba(255, 255, 255, 0.12)';
        });

        const activeBtn = document.getElementById('sub-filter-' + source);
        if (activeBtn) {
            activeBtn.style.background = '#3b82f6';
            activeBtn.style.color = '#fff';
            activeBtn.style.borderColor = '#3b82f6';
        }

        const visibleEmails = [];
        rows.forEach(row => {
            const rowSource = row.getAttribute('data-source');
            if (source === 'all' || rowSource === source) {
                row.style.display = '';
                visibleEmails.push(row.getAttribute('data-email'));
            } else {
                row.style.display = 'none';
            }
        });

        // Update send email link
        const sendEmailBtn = document.getElementById('btnSendEmail');
        if (sendEmailBtn) {
            const bccStr = encodeURIComponent(visibleEmails.join(', '));
            const subjectStr = encodeURIComponent(source === 'digest' ? 'Legal Intelligence Digest Update' : (source === 'launch' ? 'VIP Launch Invitation — Legals Forum EcoSystem' : 'Legals Forum Update & Intelligence'));
            sendEmailBtn.href = `mailto:?bcc=${bccStr}&subject=${subjectStr}`;
        }
    }

    function copyAllSubscriberEmails() {
        const rows = document.querySelectorAll('.subscriber-row');
        const emails = [];
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const em = row.getAttribute('data-email');
                if (em) emails.push(em);
            }
        });

        if (emails.length === 0) return;

        navigator.clipboard.writeText(emails.join(', ')).then(() => {
            const btnText = document.getElementById('btnCopyText');
            if (btnText) {
                const orig = btnText.textContent;
                btnText.textContent = `Copied ${emails.length} Email(s)!`;
                setTimeout(() => { btnText.textContent = orig; }, 2200);
            }
        });
    }
</script>
@endsection
