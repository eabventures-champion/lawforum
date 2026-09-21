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
<div style="max-width: 1200px; margin: 0 auto;">

    <!-- Top Banner / Hero -->
    <div style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.7) 0%, rgba(15, 23, 42, 0.9) 100%); border: 1px solid var(--border-color); border-radius: 24px; padding: 36px 40px; margin-bottom: 32px; position: relative; overflow: hidden;">
        <div style="position: absolute; right: -20px; top: -20px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%); pointer-events: none;"></div>

        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 20px; position: relative; z-index: 2;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.25); color: #60a5fa; padding: 6px 14px; border-radius: 100px; font-size: 12px; font-weight: 700; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                    @if($isHub)
                        <i class="fa-solid fa-layer-group"></i>
                        Chatroom Hub (All Categories)
                    @else
                        <i class="fa-solid {{ $categoryIcons[$category] ?? 'fa-comments' }}"></i>
                        {{ $currentCategoryLabel }}
                    @endif
                </div>
                <h1 style="font-size: 2.2rem; font-weight: 800; font-family: var(--font-heading); color: #fff; margin-bottom: 8px; letter-spacing: -0.5px;">
                    @if($isHub)
                        Legal Community Forum & Chatrooms
                    @else
                        {{ $currentCategoryLabel }}
                    @endif
                </h1>
                <p style="color: var(--text-secondary); font-size: 15px; max-width: 650px; line-height: 1.6; margin: 0;">
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

            <!-- Live Online Users Presence Card -->
            <div style="background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 16px; padding: 18px 24px; display: flex; align-items: center; gap: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                <div style="position: relative; width: 14px; height: 14px;">
                    <span style="display: block; width: 100%; height: 100%; background: #10b981; border-radius: 50%;"></span>
                    <span style="position: absolute; inset: -4px; border: 2px solid #10b981; border-radius: 50%; opacity: 0.75; animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;"></span>
                </div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: #fff; line-height: 1;" id="liveOnlineCount">
                        {{ $onlineCount }}
                    </div>
                    <small style="color: #10b981; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
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
    <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 28px;">
        <a href="{{ route('chatroom.index') }}" 
           style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 100px; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                  {{ $isHub ? 'background: #3b82f6; color: #fff; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);' : 'background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border: 1px solid var(--border-color);' }}">
            <i class="fa-solid fa-layer-group"></i>
            Chatroom Hub (All Rooms)
        </a>
        @foreach($categoryLabels as $catKey => $catLabel)
            @php
                $isActiveCat = (!$isHub && $category === $catKey);
            @endphp
            <a href="{{ route('chatroom.category', $catKey) }}" 
               style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 100px; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: all 0.2s;
                      {{ $isActiveCat ? 'background: #3b82f6; color: #fff; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4);' : 'background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); border: 1px solid var(--border-color);' }}">
                <i class="fa-solid {{ $categoryIcons[$catKey] ?? 'fa-comments' }}"></i>
                {{ $catLabel }}
            </a>
        @endforeach
    </div>

    <!-- Actions & Filter Bar -->
    <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 16px 20px; margin-bottom: 24px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px;">
        <!-- Tabs -->
        <div style="display: flex; gap: 8px;">
            <a href="{{ $allTabUrl }}" 
               style="padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; {{ $tab === 'all' ? 'background: rgba(255,255,255,0.1); color: #fff;' : 'color: var(--text-secondary);' }}">
                All Topics
            </a>
            @guest
                <a href="javascript:void(0)" onclick="openPremiumLockModal('Premium Rooms Restricted', 'Guest users cannot access premium rooms. Please sign in or register to explore premium discussions.')" 
                   style="padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; color: var(--text-secondary); display: inline-flex; align-items: center; gap: 6px;"
                   title="Sign in required for premium rooms">
                    <i class="fa-solid fa-crown" style="color: #f59e0b;"></i> Premium Rooms
                    <i class="fa-solid fa-lock" style="font-size: 10px; opacity: 0.7; color: #f59e0b;"></i>
                </a>
            @else
                <a href="{{ $premiumTabUrl }}" 
                   style="padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; {{ $tab === 'premium' ? 'background: rgba(245, 158, 11, 0.15); color: #f59e0b;' : 'color: var(--text-secondary);' }}">
                    <i class="fa-solid fa-crown mr-1"></i> Premium Rooms
                </a>
            @endguest
            <a href="{{ $trendingTabUrl }}" 
               style="padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; {{ $tab === 'trending' ? 'background: rgba(239, 68, 68, 0.15); color: #f87171;' : 'color: var(--text-secondary);' }}">
                <i class="fa-solid fa-fire mr-1"></i> Trending
            </a>
        </div>

        <!-- Search & New Topic Button -->
        <div style="display: flex; align-items: center; gap: 12px; flex: 1; max-width: 500px; justify-content: flex-end;">
            <form action="{{ $currentRoute }}" method="GET" style="position: relative; width: 100%; max-width: 280px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 12px;"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search discussions..." 
                       style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 100px; padding: 8px 14px 8px 32px; color: #fff; font-size: 13px; outline: none;">
            </form>

            @if($canStartDiscussion)
                <button onclick="document.getElementById('createChatroomModal').style.display='flex'" 
                        style="background: var(--accent-gradient); border: none; color: #fff; padding: 9px 18px; border-radius: 100px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; box-shadow: 0 4px 12px var(--accent-glow);">
                    <i class="fa-solid fa-plus"></i> Start Discussion
                </button>
            @endif
        </div>
    </div>

    <!-- Discussions List -->
    <div style="display: flex; flex-direction: column; gap: 14px;">
        @forelse($chatrooms as $room)
            @php
                $isLockedForGuest = ($room->is_premium && !auth()->check());
                $catColor = $categoryColors[$room->category] ?? ['color' => '#60a5fa', 'bg' => 'rgba(59, 130, 246, 0.12)', 'border' => 'rgba(59, 130, 246, 0.3)'];
            @endphp
            <div style="background: var(--card-bg); border: 1px solid {{ $room->is_premium ? 'rgba(245, 158, 11, 0.35)' : 'var(--border-color)' }}; border-radius: 16px; padding: 22px 24px; transition: all 0.2s; position: relative;"
                 onmouseover="this.style.borderColor='{{ $room->is_premium ? 'rgba(245, 158, 11, 0.7)' : 'rgba(59, 130, 246, 0.5)' }}'; this.style.transform='translateY(-2px)'"
                 onmouseout="this.style.borderColor='{{ $room->is_premium ? 'rgba(245, 158, 11, 0.35)' : 'var(--border-color)' }}'; this.style.transform='translateY(0)'">
                
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 14px; margin-bottom: 12px;">
                    <div style="flex: 1; min-width: 280px;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                            @if($room->is_pinned)
                                <span style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-thumbtack"></i> Pinned
                                </span>
                            @endif

                            {{-- Room Category Badge --}}
                            <a href="{{ route('chatroom.category', $room->category) }}" 
                               title="View discussions in {{ $categoryLabels[$room->category] ?? ucfirst($room->category) }}"
                               style="background: {{ $catColor['bg'] }}; color: {{ $catColor['color'] }}; border: 1px solid {{ $catColor['border'] }}; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; transition: opacity 0.2s;"
                               onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                <i class="fa-solid {{ $categoryIcons[$room->category] ?? 'fa-comments' }}"></i>
                                {{ $categoryLabels[$room->category] ?? ucfirst($room->category) }}
                            </a>

                            @if($room->is_premium)
                                <span style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%); border: 1px solid rgba(245, 158, 11, 0.4); color: #f59e0b; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-crown"></i> Premium Room
                                    @if($isLockedForGuest)
                                        <i class="fa-solid fa-lock ml-1" style="font-size: 10px;"></i>
                                    @endif
                                </span>
                            @endif
                            <span style="color: var(--text-secondary); font-size: 12px;">
                                Started by <strong style="color: #fff;">{{ $room->author_name }}</strong> 
                                ({{ $room->author_role }})
                            </span>
                            <span style="color: var(--text-muted); font-size: 11px;">• {{ $room->created_at->diffForHumans() }}</span>
                        </div>

                        <h3 style="font-size: 17px; font-weight: 700; margin-bottom: 6px;">
                            @if($isLockedForGuest)
                                <a href="javascript:void(0)" 
                                   onclick="openPremiumLockModal('{{ addslashes($room->title) }}', 'This is a premium discussion room. Guest users cannot access premium rooms. Please sign in or register to view and join this discussion.')" 
                                   style="color: #fff; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                    <span>{{ $room->title }}</span>
                                    <i class="fa-solid fa-lock" style="font-size: 12px; color: #f59e0b;" title="Locked for Guests"></i>
                                </a>
                            @else
                                <a href="{{ route('chatroom.show', [$room->category, $room->slug]) }}" style="color: #fff; text-decoration: none;">
                                    {{ $room->title }}
                                </a>
                            @endif
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 13.5px; line-height: 1.5; margin: 0;">
                            {{ Str::limit($room->description, 140) }}
                        </p>
                    </div>

                    <!-- Right Stats & Join Button -->
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="display: flex; gap: 14px; text-align: center;">
                            <div style="background: rgba(255,255,255,0.03); padding: 8px 12px; border-radius: 8px;">
                                <div style="font-size: 15px; font-weight: 700; color: #fff;">{{ $room->replies_count }}</div>
                                <small style="font-size: 10px; color: var(--text-muted); text-transform: uppercase;">Replies</small>
                            </div>
                            <div style="background: rgba(255,255,255,0.03); padding: 8px 12px; border-radius: 8px;">
                                <div style="font-size: 15px; font-weight: 700; color: #fff;">{{ $room->views_count }}</div>
                                <small style="font-size: 10px; color: var(--text-muted); text-transform: uppercase;">Views</small>
                            </div>
                        </div>

                        @if($isLockedForGuest)
                            <button type="button" 
                                    onclick="openPremiumLockModal('{{ addslashes($room->title) }}', 'This is a premium discussion room. Guest users cannot access premium rooms. Please sign in or register to view and join this discussion.')"
                                    style="background: rgba(245, 158, 11, 0.12); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.35); padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; white-space: nowrap; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;"
                                    onmouseover="this.style.background='rgba(245, 158, 11, 0.22)'; this.style.borderColor='rgba(245, 158, 11, 0.6)'"
                                    onmouseout="this.style.background='rgba(245, 158, 11, 0.12)'; this.style.borderColor='rgba(245, 158, 11, 0.35)'">
                                <i class="fa-solid fa-lock"></i> Locked Room
                            </button>
                        @else
                            <a href="{{ route('chatroom.show', [$room->category, $room->slug]) }}" 
                               style="background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25); padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; text-decoration: none; white-space: nowrap; transition: all 0.2s;"
                               onmouseover="this.style.background='#3b82f6'; this.style.color='#fff'"
                               onmouseout="this.style.background='rgba(59, 130, 246, 0.1)'; this.style.color='#60a5fa'">
                                Join Thread <i class="fa-solid fa-arrow-right ml-1"></i>
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

</div>

@if($canStartDiscussion)
    @include('chatroom.create_modal')
@endif

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
        $.ajax({
            url: "{{ route('chatroom.heartbeat', $category) }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res && res.onlineCount) {
                    $('#liveOnlineCount').text(res.onlineCount);
                }
            }
        });
    }, 25000);
</script>
@endpush

@push('styles')
<style>
    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>
@endpush
@endsection
