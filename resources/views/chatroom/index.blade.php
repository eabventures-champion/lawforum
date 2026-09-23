@extends('layouts.forum_portal')

@php
    $isHub = ($category === 'all');
    $currentCategoryLabel = $isHub ? 'Chatroom Hub' : ($categoryLabels[$category] ?? ucfirst($category));
    $canStartDiscussion = false;
    if ($category === 'all' || $category === 'general') {
        $canStartDiscussion = true;
    } elseif (auth()->check()) {
        $userRole = strtolower(auth()->user()->user_type ?? '');
        if (auth()->user()->isAdmin() || $userRole === $category) {
            $canStartDiscussion = true;
        }
    }

    $currentRoute = $isHub ? route('chatroom.index') : route('chatroom.category', $category);
    $allTabUrl = $isHub ? route('chatroom.index', ['tab' => 'all']) : route('chatroom.category', [$category, 'tab' => 'all']);
    $premiumTabUrl = $isHub ? route('chatroom.index', ['tab' => 'premium']) : route('chatroom.category', [$category, 'tab' => 'premium']);
    $trendingTabUrl = $isHub ? route('chatroom.index', ['tab' => 'trending']) : route('chatroom.category', [$category, 'tab' => 'trending']);
@endphp

@section('title', $currentCategoryLabel . ' - Legals Forum Community')

@section('content')
<div id="chatroomMainWrapper" data-current-category="{{ $category }}" style="max-width: 1200px; margin: 0 auto; transition: opacity 0.15s ease;">

    <!-- Top Banner / Hero -->
    <div class="chatroom-hero-banner">
        <div class="chatroom-hero-glow"></div>

        <div class="chatroom-hero-inner">
            <div class="chatroom-hero-text">
                <div class="chatroom-hero-top-row">
                    <div class="chatroom-hero-badge">
                        @if($isHub)
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Chatroom Hub</span>
                        @else
                            <i class="fa-solid {{ $categoryIcons[$category] ?? 'fa-comments' }}"></i>
                            <span>{{ $currentCategoryLabel }}</span>
                        @endif
                    </div>

                    <!-- Compact live online pill for mobile header row -->
                    <div class="chatroom-mobile-live-pill">
                        <span class="live-pulse-dot">
                            <span class="dot-base"></span>
                            <span class="dot-ping"></span>
                        </span>
                        <span class="live-pill-count"><span id="liveOnlineCountMobile">{{ $onlineCount }}</span> Online</span>
                    </div>
                </div>

                <h1 class="chatroom-hero-title">
                    @if($isHub)
                        Legal Community Forum & Chatrooms
                    @else
                        {{ $currentCategoryLabel }}
                    @endif
                </h1>

                <p class="chatroom-hero-desc">
                    @if($isHub)
                        Explore legal discourse, collaborative research, case analyses, and study discussions aggregated across all forum rooms.
                    @elseif($category === 'student')
                        Discussions tailored for law students, exam preparations, coursework questions, and academic legal research.
                    @elseif($category === 'lawyer')
                        Dedicated practitioner forum for counsel, legal advocates, bar members, and litigation strategy exchanges.
                    @elseif($category === 'researcher')
                        In-depth judicial research, statutory critique, legislative policy discourse, and comparative law.
                    @else
                        Participate in thread-based legal discourse, collaborative research, case analyses, and study discussions across Ghana and global jurisdictions.
                    @endif
                </p>
            </div>

            <!-- Live Online Users Presence Card (Desktop) -->
            <div class="chatroom-desktop-presence-card">
                <div class="live-pulse-dot" style="width: 14px; height: 14px;">
                    <span class="dot-base"></span>
                    <span class="dot-ping"></span>
                </div>
                <div>
                    <div class="desktop-presence-num" id="liveOnlineCount">
                        {{ $onlineCount }}
                    </div>
                    <small class="desktop-presence-label">
                        {{ $isHub ? 'Online across all rooms' : 'Online in this room' }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Notifications -->
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; padding: 14px 20px; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(239, 68, 68, 0.2); color: #f87171; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <span style="font-size: 14px; font-weight: 500;">{{ session('error') }}</span>
            </div>
            @guest
                <button onclick="openPremiumLockModal('Premium Access Required', '{{ addslashes(session('error')) }}')" 
                        style="background: #ef4444; color: #fff; border: none; padding: 8px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; cursor: pointer; white-space: nowrap; transition: background 0.2s;">
                    Sign In / Register
                </button>
            @endguest
        </div>
    @endif

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); color: #6ee7b7; padding: 14px 20px; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
            <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(16, 185, 129, 0.2); color: #34d399; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <span style="font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Category Selector Navigation -->
    <div class="chatroom-category-nav">
        <a href="{{ route('chatroom.index') }}" 
           class="chatroom-cat-tab {{ $isHub ? 'active' : '' }}">
            <i class="fa-solid fa-layer-group cat-tab-icon" style="{{ $isHub ? '' : 'color: #60a5fa;' }}"></i>
            <span>Chatroom Hub<span class="hub-subtext"> (All Rooms)</span></span>
        </a>
        @foreach($categoryLabels as $catKey => $catLabel)
            @php
                $isActiveCat = (!$isHub && $category === $catKey);
                $catColorInfo = $categoryColors[$catKey] ?? ['color' => '#60a5fa'];
            @endphp
            <a href="{{ route('chatroom.category', $catKey) }}" 
               class="chatroom-cat-tab {{ $isActiveCat ? 'active' : '' }}">
                <i class="fa-solid {{ $categoryIcons[$catKey] ?? 'fa-comments' }} cat-tab-icon" 
                   style="{{ $isActiveCat ? '' : 'color: ' . $catColorInfo['color'] . ';' }}"></i>
                <span>{{ $catLabel }}</span>
            </a>
        @endforeach
    </div>

    <!-- Actions & Filter Bar -->
    <div class="chatroom-action-bar">
        <!-- Topic Filter Tabs -->
        <div class="chatroom-topic-tabs">
            <a href="{{ $allTabUrl }}" 
               class="chatroom-filter-tab {{ $tab === 'all' ? 'active' : '' }}">
                <span>All Topics</span>
            </a>
            @guest
                <a href="javascript:void(0)" onclick="openPremiumLockModal('Premium Rooms Restricted', 'Guest users cannot access premium rooms. Please sign in or register to explore premium discussions.')" 
                   class="chatroom-filter-tab"
                   title="Sign in required for premium rooms">
                    <i class="fa-solid fa-crown" style="color: #f59e0b;"></i>
                    <span>Premium</span>
                    <i class="fa-solid fa-lock" style="font-size: 10px; opacity: 0.7; color: #f59e0b;"></i>
                </a>
            @else
                <a href="{{ $premiumTabUrl }}" 
                   class="chatroom-filter-tab {{ $tab === 'premium' ? 'active' : '' }}">
                    <i class="fa-solid fa-crown mr-1"></i>
                    <span>Premium</span>
                </a>
            @endguest
            <a href="{{ $trendingTabUrl }}" 
               class="chatroom-filter-tab {{ $tab === 'trending' ? 'active' : '' }}">
                <i class="fa-solid fa-fire mr-1"></i>
                <span>Trending</span>
            </a>
        </div>

        <!-- Search Bar & Start Discussion Button -->
        <div class="chatroom-action-controls">
            <form action="{{ $currentRoute }}" method="GET" class="chatroom-search-form">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search discussions..." class="chatroom-search-input">
                @if(request('q'))
                    <a href="{{ $currentRoute }}" class="search-clear-btn" title="Clear search"><i class="fa-solid fa-xmark"></i></a>
                @endif
            </form>

            @if($canStartDiscussion)
                <button onclick="document.getElementById('createChatroomModal').style.display='flex'" class="chatroom-new-btn">
                    <i class="fa-solid fa-plus"></i>
                    <span>Start Discussion</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Discussions List -->
    <div class="chatroom-discussions-list">
        @forelse($chatrooms as $room)
            @php
                $catColor = $categoryColors[$room->category] ?? ['color' => '#60a5fa', 'bg' => 'rgba(59, 130, 246, 0.12)', 'border' => 'rgba(59, 130, 246, 0.3)'];
                $threadUrl = route('chatroom.show', [$room->category, $room->slug]);
                $authorInitial = strtoupper(mb_substr($room->author_name ?? 'U', 0, 1));
            @endphp
            <div class="chatroom-thread-card {{ $room->is_premium ? 'is-premium' : '' }}">
                <div class="thread-main-col">
                    <!-- Top Badges & Time Row -->
                    <div class="thread-badges-row">
                        <div class="thread-badges-left">
                            @if($room->is_pinned)
                                <span class="thread-chip chip-pinned">
                                    <i class="fa-solid fa-thumbtack"></i> Pinned
                                </span>
                            @endif

                            {{-- Room Category Badge --}}
                            <a href="{{ route('chatroom.category', $room->category) }}" 
                               class="thread-chip chip-cat"
                               title="View discussions in {{ $categoryLabels[$room->category] ?? ucfirst($room->category) }}"
                               style="background: {{ $catColor['bg'] }}; color: {{ $catColor['color'] }}; border: 1px solid {{ $catColor['border'] }};">
                                <i class="fa-solid {{ $categoryIcons[$room->category] ?? 'fa-comments' }}"></i>
                                <span>{{ $categoryLabels[$room->category] ?? ucfirst($room->category) }}</span>
                            </a>

                            @if($room->is_premium)
                                <span class="thread-chip chip-premium">
                                    <i class="fa-solid fa-crown"></i> Premium
                                </span>

                                @if($room->security_code)
                                    <span class="thread-chip" style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #fbbf24; font-size: 11px;">
                                        <i class="fa-solid fa-key"></i> Security Pass
                                    </span>
                                @endif

                                @if($room->isExpired())
                                    <span class="thread-chip" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #f87171; font-size: 11px;">
                                        <i class="fa-solid fa-lock"></i> 1-Month Ended
                                    </span>
                                @elseif($room->expires_at)
                                    <span class="thread-chip" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.25); color: #93c5fd; font-size: 11px;">
                                        <i class="fa-regular fa-clock"></i> {{ $room->daysRemaining() }}d left
                                    </span>
                                @endif
                            @endif
                        </div>

                        <span class="thread-time-badge" title="{{ $room->created_at->format('M d, Y H:i') }}">
                            <i class="fa-regular fa-clock"></i> {{ $room->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="thread-title">
                        <a href="{{ $threadUrl }}" class="thread-title-link">
                            <span>{{ $room->title }}</span>
                            @if($room->is_premium && !$room->isUnlockedBy(auth()->user(), session()->getId()))
                                <i class="fa-solid fa-lock lock-icon" style="color: #f59e0b; margin-left: 6px; font-size: 12px;" title="Security Pass Required"></i>
                            @endif
                        </a>
                    </h3>

                    <!-- Excerpt Description -->
                    @if($room->description)
                        <p class="thread-desc">
                            {{ Str::limit($room->description, 135) }}
                        </p>
                    @endif

                    <!-- Author Meta Row -->
                    <div class="thread-author-row">
                        <div class="thread-author-avatar">
                            {{ $authorInitial }}
                        </div>
                        <span class="author-label">Started by</span>
                        <strong class="author-name">{{ $room->author_name }}</strong>
                        @if($room->author_role)
                            <span class="author-role-badge">{{ $room->author_role }}</span>
                        @endif
                    </div>
                </div>

                <!-- Right / Footer Stats & Join Button -->
                <div class="thread-side-col">
                    <div class="thread-stats-group">
                        <div class="thread-stat-box" title="{{ $room->replies_count }} {{ Str::plural('reply', $room->replies_count) }}">
                            <i class="fa-regular fa-comment-dots stat-icon"></i>
                            <span class="stat-value">{{ $room->replies_count }}</span>
                            <span class="stat-unit">{{ Str::plural('reply', $room->replies_count) }}</span>
                        </div>
                        <div class="thread-stat-box" title="{{ $room->views_count }} {{ Str::plural('view', $room->views_count) }}">
                            <i class="fa-regular fa-eye stat-icon"></i>
                            <span class="stat-value">{{ $room->views_count }}</span>
                            <span class="stat-unit">{{ Str::plural('view', $room->views_count) }}</span>
                        </div>
                    </div>

                    <div class="thread-action-wrap">
                        @if($room->is_premium && !$room->isUnlockedBy(auth()->user(), session()->getId()))
                            <a href="{{ $threadUrl }}" class="thread-action-btn btn-locked" style="background: rgba(245, 158, 11, 0.15); border-color: rgba(245, 158, 11, 0.4); color: #fbbf24;" title="Enter Security Pass to Join">
                                <i class="fa-solid fa-key"></i>
                                <span>Security Pass</span>
                            </a>
                        @else
                            <a href="{{ $threadUrl }}" class="thread-action-btn btn-join">
                                <span>Join Thread</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div style="background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: 16px; padding: 48px 24px; text-align: center;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 22px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px;">No discussions yet in {{ $isHub ? 'the Chatroom Hub' : ($categoryLabels[$category] ?? 'this room') }}</h3>
                <p style="color: var(--text-secondary); font-size: 14px; max-width: 450px; margin: 0 auto 20px auto;">
                    @if($canStartDiscussion)
                        Be the first to start a legal discussion thread in {{ $isHub ? 'the community forum' : ($categoryLabels[$category] ?? 'this room') }}!
                    @else
                        Discussions in this room are reserved for verified {{ $categoryLabels[$category] ?? 'Room' }} members.
                    @endif
                </p>
                @if($canStartDiscussion)
                    <button onclick="document.getElementById('createChatroomModal').style.display='flex'" 
                            style="background: var(--accent-gradient); border: none; color: #fff; padding: 10px 22px; border-radius: 100px; font-size: 13px; font-weight: 700; cursor: pointer;">
                        <i class="fa-solid fa-plus mr-1"></i> Start First Discussion
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($chatrooms->hasPages())
        <div style="margin-top: 32px; display: flex; justify-content: center;">
            {{ $chatrooms->links() }}
        </div>
    @endif

    <!-- Create Discussion Modal (Rendered when user has permission) -->
    <div id="chatroomModalWrapper">
        @if($canStartDiscussion)
            @include('chatroom.create_modal')
        @endif
    </div>

</div>

<!-- Premium Room Guest Lock Modal -->
<div id="premiumLockModal" 
     onclick="if(event.target === this) closePremiumLockModal()"
     style="display: none; position: fixed; inset: 0; background: rgba(4, 8, 20, 0.88); z-index: 250000; align-items: center; justify-content: center; padding: 20px 16px; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
    
    <div style="background: #0c1322; background: linear-gradient(180deg, #0f182c 0%, #090e1a 100%); border: 1px solid rgba(245, 158, 11, 0.35); border-radius: 24px; width: 100%; max-width: 480px; padding: 36px 32px; box-shadow: 0 25px 60px -12px rgba(0,0,0,0.9), 0 0 50px rgba(245, 158, 11, 0.15); text-align: center; position: relative; animation: modalSlideUp 0.3s ease;">
        
        <button type="button" onclick="closePremiumLockModal()" 
                style="position: absolute; top: 18px; right: 18px; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.05); color: #94a3b8; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; font-size: 15px;"
                onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'; this.style.color='#f87171'"
                onmouseout="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.color='#94a3b8'">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="width: 64px; height: 64px; border-radius: 20px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%); border: 1px solid rgba(245, 158, 11, 0.4); display: flex; align-items: center; justify-content: center; font-size: 28px; color: #f59e0b; margin: 0 auto 20px auto; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.25);">
            <i class="fa-solid fa-crown"></i>
        </div>

        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #f59e0b; padding: 4px 12px; border-radius: 100px; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
            <i class="fa-solid fa-lock"></i> Premium Room Locked
        </div>

        <h3 id="premiumLockModalTitle" style="font-size: 21px; font-weight: 700; color: #fff; margin-bottom: 10px; font-family: var(--font-heading); line-height: 1.3;">
            Premium Discussion Room
        </h3>

        <p id="premiumLockModalDesc" style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 26px;">
            Guest users cannot access premium rooms. Sign in to your account or register to unlock access to exclusive legal discussions, case studies, and practitioner rooms.
        </p>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <button type="button" onclick="closePremiumLockModal(); openLoginModal();" 
                    style="width: 100%; background: var(--accent-gradient); border: none; color: #fff; padding: 13px 20px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 16px var(--accent-glow);">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In to Access
            </button>

            <a href="/get-started" 
               style="width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border-color); color: #fff; padding: 12px 20px; border-radius: 12px; font-size: 13.5px; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s;"
               onmouseover="this.style.background='rgba(255, 255, 255, 0.12)'"
               onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'">
                <i class="fa-solid fa-user-plus"></i> Create Free Account
            </a>
        </div>

        <div style="margin-top: 18px;">
            <button type="button" onclick="closePremiumLockModal()" 
                    style="background: none; border: none; color: var(--text-muted); font-size: 12.5px; cursor: pointer; text-decoration: underline;">
                Continue browsing general topics
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openPremiumLockModal(title, desc) {
        if (title) {
            $('#premiumLockModalTitle').text(title);
        }
        if (desc) {
            $('#premiumLockModalDesc').text(desc);
        }
        $('#premiumLockModal').css('display', 'flex');
    }

    function closePremiumLockModal() {
        $('#premiumLockModal').hide();
    }

    // Realtime Presence Heartbeat every 25 seconds
    setInterval(function() {
        var wrapper = document.getElementById('chatroomMainWrapper');
        var cat = (wrapper && wrapper.getAttribute('data-current-category')) ? wrapper.getAttribute('data-current-category') : 'all';
        $.ajax({
            url: "/chatroom/heartbeat/" + cat,
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res && res.onlineCount) {
                    $('#liveOnlineCount, #liveOnlineCountMobile').text(res.onlineCount);
                }
            }
        });
    }, 25000);

    // Auto-scroll active category tab into view on mobile
    function scrollActiveCategoryTabIntoView() {
        var activeTab = document.querySelector('.chatroom-cat-tab.active');
        if (activeTab && window.innerWidth <= 768) {
            activeTab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    }

    $(document).ready(function() {
        scrollActiveCategoryTabIntoView();
    });

    // SPA-style smooth navigation for chatrooms without page reload
    var isChatroomLoading = false;

    function loadChatroomUrl(url, pushHistory) {
        if (isChatroomLoading) return;
        var wrapper = document.getElementById('chatroomMainWrapper');
        if (!wrapper) return;

        isChatroomLoading = true;
        wrapper.style.opacity = '0.5';
        wrapper.style.pointerEvents = 'none';

        fetch(url)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.text();
            })
            .then(function(htmlText) {
                var parser = new DOMParser();
                var doc = parser.parseFromString(htmlText, 'text/html');

                var newWrapper = doc.getElementById('chatroomMainWrapper');
                if (newWrapper) {
                    wrapper.innerHTML = newWrapper.innerHTML;
                    var newCat = newWrapper.getAttribute('data-current-category') || 'all';
                    wrapper.setAttribute('data-current-category', newCat);
                    document.title = doc.title;

                    if (pushHistory) {
                        window.history.pushState({ chatroomUrl: url }, '', url);
                    }

                    // Auto-scroll active category tab into view on mobile
                    scrollActiveCategoryTabIntoView();
                } else {
                    window.location.href = url;
                }
            })
            .catch(function(err) {
                console.warn('Chatroom AJAX navigation fallback:', err);
                window.location.href = url;
            })
            .finally(function() {
                isChatroomLoading = false;
                if (wrapper) {
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = '';
                }
            });
    }

    // Intercept clicks on category tabs, filter tabs, and pagination links
    document.addEventListener('click', function(e) {
        // 1. Category tabs (Chatroom Hub, General Room, Student Room, Lawyer Room, Researcher Room)
        var catTab = e.target.closest('.chatroom-cat-tab');
        if (catTab) {
            var href = catTab.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('javascript:')) {
                e.preventDefault();
                loadChatroomUrl(href, true);
                return;
            }
        }

        // 2. Filter tabs (All Topics, Trending, Premium Rooms)
        var filterTab = e.target.closest('.chatroom-filter-tab');
        if (filterTab) {
            var href = filterTab.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('javascript:')) {
                e.preventDefault();
                loadChatroomUrl(href, true);
                return;
            }
        }

        // 3. Pagination links inside chatroom
        var pageLink = e.target.closest('#chatroomMainWrapper .pagination a');
        if (pageLink) {
            var href = pageLink.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('javascript:')) {
                e.preventDefault();
                loadChatroomUrl(href, true);
                return;
            }
        }
    });

    // Intercept search form submission
    document.addEventListener('submit', function(e) {
        var searchForm = e.target.closest('.chatroom-search-form');
        if (searchForm) {
            e.preventDefault();
            var action = searchForm.getAttribute('action') || window.location.pathname;
            var params = new URLSearchParams(new FormData(searchForm)).toString();
            var fullUrl = action + (params ? '?' + params : '');
            loadChatroomUrl(fullUrl, true);
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        if (location.pathname.indexOf('/chatroom') !== -1) {
            loadChatroomUrl(location.href, false);
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Category Selector Navigation Tabs */
    .chatroom-category-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 24px;
    }

    .chatroom-cat-tab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 100px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-secondary, #94a3b8);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.1));
    }

    .chatroom-cat-tab:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.18);
        transform: translateY(-1px);
    }

    .chatroom-cat-tab.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
    }

    .cat-tab-icon {
        font-size: 13px;
        transition: transform 0.2s ease;
    }

    .chatroom-cat-tab:hover .cat-tab-icon {
        transform: scale(1.1);
    }

    .chatroom-hero-banner {
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.75) 0%, rgba(15, 23, 42, 0.95) 100%);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.1));
        border-radius: 24px;
        padding: 32px 36px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .chatroom-hero-glow {
        position: absolute;
        right: -20px;
        top: -20px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.18) 0%, transparent 70%);
        pointer-events: none;
    }

    .chatroom-hero-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: relative;
        z-index: 2;
    }

    .chatroom-hero-text {
        flex: 1;
        min-width: 0;
    }

    .chatroom-hero-top-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .chatroom-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(59, 130, 246, 0.12);
        border: 1px solid rgba(59, 130, 246, 0.28);
        color: #60a5fa;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .chatroom-mobile-live-pill {
        display: none;
        align-items: center;
        gap: 6px;
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #34d399;
        padding: 5px 11px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .live-pulse-dot {
        position: relative;
        width: 9px;
        height: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .dot-base {
        display: block;
        width: 100%;
        height: 100%;
        background: #10b981;
        border-radius: 50%;
    }

    .dot-ping {
        position: absolute;
        inset: -3px;
        border: 2px solid #10b981;
        border-radius: 50%;
        opacity: 0.75;
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .chatroom-hero-title {
        font-size: 2.1rem;
        font-weight: 800;
        font-family: var(--font-heading);
        color: #fff;
        margin: 0 0 10px 0;
        letter-spacing: -0.5px;
        line-height: 1.25;
    }

    .chatroom-hero-desc {
        color: var(--text-secondary, #94a3b8);
        font-size: 15px;
        max-width: 650px;
        line-height: 1.6;
        margin: 0;
    }

    .chatroom-desktop-presence-card {
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 16px;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        flex-shrink: 0;
    }

    .desktop-presence-num {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }

    .desktop-presence-label {
        color: #10b981;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-top: 4px;
    }

    /* =========================================================
       Actions & Filter Bar (Desktop Base)
       ========================================================= */
    .chatroom-action-bar {
        background: var(--card-bg, #0b1329);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08));
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 22px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .chatroom-topic-tabs {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chatroom-filter-tab {
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        color: var(--text-secondary, #94a3b8);
        background: transparent;
        border: 1px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .chatroom-filter-tab:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.06);
    }

    .chatroom-filter-tab.active {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #fff !important;
        border: 1px solid rgba(255, 255, 255, 0.16) !important;
    }

    .chatroom-action-controls {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        max-width: 520px;
        justify-content: flex-end;
    }

    .chatroom-search-form {
        position: relative;
        width: 100%;
        max-width: 290px;
    }

    .chatroom-search-form .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted, #64748b);
        font-size: 13px;
        pointer-events: none;
    }

    .chatroom-search-input {
        width: 100%;
        background: #070d19;
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.12));
        border-radius: 100px;
        padding: 9px 34px 9px 38px;
        color: #fff;
        font-size: 13px;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .chatroom-search-input:focus {
        border-color: #3b82f6;
        background: #091122;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .search-clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 12px;
        text-decoration: none;
        padding: 2px 4px;
    }

    .search-clear-btn:hover {
        color: #fff;
    }

    .chatroom-new-btn {
        background: var(--accent-gradient, linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%));
        border: none;
        color: #fff;
        padding: 9px 18px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        box-shadow: 0 4px 12px var(--accent-glow, rgba(59, 130, 246, 0.35));
        transition: all 0.2s ease;
    }

    .chatroom-new-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px var(--accent-glow, rgba(59, 130, 246, 0.5));
    }

    /* =========================================================
       Discussions List & Thread Card (Desktop Base)
       ========================================================= */
    .chatroom-discussions-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .chatroom-thread-card {
        background: var(--card-bg, #0b1329);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08));
        border-radius: 16px;
        padding: 20px 24px;
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .chatroom-thread-card.is-premium {
        border-color: rgba(245, 158, 11, 0.35);
    }

    .chatroom-thread-card:hover {
        border-color: rgba(59, 130, 246, 0.5);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .chatroom-thread-card.is-premium:hover {
        border-color: rgba(245, 158, 11, 0.7);
    }

    .thread-main-col {
        flex: 1;
        min-width: 280px;
    }

    .thread-badges-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
    }

    .thread-badges-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .thread-chip {
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        line-height: 1.2;
    }

    .chip-pinned {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .chip-cat {
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .chip-cat:hover {
        opacity: 0.85;
    }

    .chip-premium {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%);
        border: 1px solid rgba(245, 158, 11, 0.4);
        color: #f59e0b;
    }

    .thread-time-badge {
        color: var(--text-muted, #64748b);
        font-size: 11.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .thread-author-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        font-size: 12px;
        color: var(--text-secondary, #94a3b8);
    }

    .thread-author-avatar {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        color: #ffffff;
        font-size: 10.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
    }

    .author-label {
        color: var(--text-muted, #64748b);
        font-size: 11.5px;
    }

    .thread-author-row .author-name {
        color: #f1f5f9;
        font-weight: 600;
    }

    .author-role-badge {
        font-size: 10.5px;
        padding: 1px 7px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.06);
        color: #94a3b8;
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-weight: 500;
        display: inline-block;
    }

    .thread-title {
        font-size: 17.5px;
        font-weight: 700;
        margin: 0 0 6px 0;
        line-height: 1.35;
    }

    .thread-title-link {
        color: #fff;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .thread-title-link:hover {
        color: #60a5fa;
    }

    .thread-title-link .lock-icon {
        color: #f59e0b;
        font-size: 12px;
        margin-left: 6px;
    }

    .thread-desc {
        color: var(--text-secondary, #94a3b8);
        font-size: 13.5px;
        line-height: 1.55;
        margin: 0;
    }

    .thread-side-col {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-shrink: 0;
    }

    .thread-stats-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .thread-stat-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 6px 10px;
        border-radius: 8px;
        text-align: center;
        min-width: 48px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .thread-stat-box .stat-icon {
        display: none;
    }

    .thread-stat-box .stat-value {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        line-height: 1.1;
    }

    .thread-stat-box .stat-unit {
        font-size: 10px;
        color: var(--text-muted, #64748b);
        text-transform: uppercase;
        margin-top: 2px;
    }

    .thread-action-wrap {
        display: flex;
        align-items: center;
    }

    .thread-action-btn {
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .thread-action-btn.btn-join {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.25);
    }

    .thread-action-btn.btn-join:hover {
        background: #3b82f6;
        color: #fff;
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);
    }

    .thread-action-btn.btn-locked {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.35);
    }

    .thread-action-btn.btn-locked:hover {
        background: rgba(245, 158, 11, 0.22);
        border-color: rgba(245, 158, 11, 0.6);
    }

    /* =========================================================
       Mobile Overrides (max-width: 768px)
       Placed at the very bottom so mobile styles properly take effect
       ========================================================= */
    @media (max-width: 768px) {
        /* Mobile Category Tabs */
        .chatroom-category-nav {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 8px;
            margin-bottom: 16px;
            padding: 2px 2px 8px 2px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .chatroom-category-nav::-webkit-scrollbar {
            display: none;
        }

        .chatroom-cat-tab {
            padding: 7px 13px;
            font-size: 12px;
            gap: 6px;
            white-space: nowrap;
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 100px;
        }

        .chatroom-cat-tab.active {
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.35);
        }

        .hub-subtext {
            display: none;
        }

        .cat-tab-icon {
            font-size: 11.5px;
        }

        /* Mobile Hero Banner */
        .chatroom-hero-banner {
            padding: 18px 16px;
            border-radius: 16px;
            margin-bottom: 18px;
            background: linear-gradient(135deg, rgba(23, 33, 54, 0.95) 0%, rgba(13, 20, 36, 0.98) 100%);
            border: 1px solid rgba(59, 130, 246, 0.22);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
        }

        .chatroom-hero-inner {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }

        .chatroom-hero-top-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
            flex-wrap: nowrap;
        }

        .chatroom-hero-badge {
            font-size: 11px;
            padding: 4px 10px;
            gap: 6px;
            letter-spacing: 0.3px;
        }

        .chatroom-mobile-live-pill {
            display: inline-flex;
            margin-left: auto;
            font-size: 11px;
            padding: 4px 9px;
            white-space: nowrap;
        }

        .chatroom-desktop-presence-card {
            display: none !important;
        }

        .chatroom-hero-title {
            font-size: 1.35rem;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
            color: #ffffff;
        }

        .chatroom-hero-desc {
            font-size: 13px;
            line-height: 1.5;
            color: rgba(203, 213, 225, 0.88);
        }

        /* Actions & Filter Card Mobile Redesign */
        .chatroom-action-bar {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 14px 12px !important;
            gap: 12px !important;
            border-radius: 14px !important;
            margin-bottom: 16px !important;
            box-sizing: border-box !important;
            width: 100% !important;
        }

        .chatroom-topic-tabs {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 6px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .chatroom-filter-tab {
            justify-content: center !important;
            text-align: center !important;
            gap: 4px !important;
            padding: 8px 4px !important;
            font-size: 11.5px !important;
            border-radius: 8px !important;
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            box-sizing: border-box !important;
        }

        .chatroom-filter-tab span {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .chatroom-action-controls {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .chatroom-search-form {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .chatroom-search-input {
            width: 100% !important;
            height: 42px !important;
            padding: 0 34px 0 38px !important;
            font-size: 13.5px !important;
            border-radius: 12px !important;
            background: #080f1d !important;
            border: 1px solid rgba(255, 255, 255, 0.14) !important;
            box-sizing: border-box !important;
        }

        .chatroom-search-input:focus {
            background: #0c162a !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
        }

        .chatroom-new-btn {
            width: 100% !important;
            height: 40px !important;
            justify-content: center !important;
            border-radius: 12px !important;
            font-size: 13.5px !important;
            box-sizing: border-box !important;
        }

        /* Discussion Thread Card Mobile Redesign */
        .chatroom-thread-card {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 15px 14px !important;
            gap: 10px !important;
            border-radius: 16px !important;
            box-sizing: border-box !important;
            width: 100% !important;
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.85) 0%, rgba(10, 16, 32, 0.95) 100%) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25) !important;
        }

        .chatroom-thread-card.is-premium {
            border-color: rgba(245, 158, 11, 0.38) !important;
            box-shadow: 0 4px 18px rgba(245, 158, 11, 0.08) !important;
        }

        .thread-main-col {
            min-width: 0 !important;
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 6px !important;
        }

        .thread-badges-row {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 8px !important;
            margin-bottom: 2px !important;
            width: 100% !important;
        }

        .thread-badges-left {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            flex-wrap: wrap !important;
        }

        .thread-chip {
            font-size: 10.5px !important;
            padding: 3px 8px !important;
            border-radius: 6px !important;
            font-weight: 600 !important;
        }

        .thread-time-badge {
            font-size: 11px !important;
            color: #64748b !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
        }

        .thread-title {
            font-size: 15px !important;
            font-weight: 700 !important;
            margin: 2px 0 0 0 !important;
            line-height: 1.35 !important;
            letter-spacing: -0.2px !important;
        }

        .thread-title-link {
            color: #f8fafc !important;
        }

        .thread-title-link .lock-icon {
            font-size: 11px !important;
            margin-left: 4px !important;
            color: #f59e0b !important;
        }

        .thread-desc {
            font-size: 12.5px !important;
            line-height: 1.45 !important;
            color: #94a3b8 !important;
            margin: 0 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        .thread-author-row {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin-top: 4px !important;
            padding-top: 4px !important;
            flex-wrap: wrap !important;
        }

        .thread-author-avatar {
            width: 20px !important;
            height: 20px !important;
            font-size: 10px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%) !important;
            color: #fff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-weight: 700 !important;
            flex-shrink: 0 !important;
        }

        .author-label {
            font-size: 11px !important;
            color: #64748b !important;
        }

        .thread-author-row .author-name {
            font-size: 12px !important;
            color: #e2e8f0 !important;
            font-weight: 600 !important;
        }

        .author-role-badge {
            font-size: 10px !important;
            padding: 1px 6px !important;
            border-radius: 4px !important;
            background: rgba(255, 255, 255, 0.05) !important;
            color: #94a3b8 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        /* Footer: Stats & Button on single clean line */
        .thread-side-col {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            border-top: 1px solid rgba(255, 255, 255, 0.07) !important;
            padding-top: 10px !important;
            margin-top: 4px !important;
            box-sizing: border-box !important;
        }

        .thread-stats-group {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }

        .thread-stat-box {
            display: inline-flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 4px !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            min-width: auto !important;
        }

        .thread-stat-box .stat-icon {
            display: inline-block !important;
            font-size: 12px !important;
            color: #60a5fa !important;
        }

        .thread-stat-box .stat-value {
            font-size: 12px !important;
            font-weight: 700 !important;
            color: #e2e8f0 !important;
            line-height: 1 !important;
        }

        .thread-stat-box .stat-unit {
            font-size: 11px !important;
            color: #64748b !important;
            text-transform: lowercase !important;
            margin: 0 !important;
        }

        .thread-action-wrap {
            margin: 0 !important;
        }

        .thread-action-btn {
            padding: 6px 13px !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
            height: auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
        }
    }

    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>
@endpush
@endsection
