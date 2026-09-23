@extends('layouts.forum_portal')

@section('title', $room->title . ' - Legals Forum Community')

@section('content')
<div class="thread-page-container">

    <!-- Top Navigation & Live Presence Bar -->
    <div class="thread-nav-bar">
        <a href="{{ route('chatroom.category', $room->category) }}" class="thread-back-link">
            <i class="fa-solid fa-arrow-left"></i>
            <span class="back-text-full">Back to {{ $categoryLabels[$room->category] ?? ucfirst($room->category) }}</span>
            <span class="back-text-short">Back</span>
        </a>

        <!-- Live Online Count Pill -->
        <div class="thread-presence-pill">
            <span class="pulse-indicator">
                <span class="pulse-ping"></span>
                <span class="pulse-dot"></span>
            </span>
            <span id="liveOnlineCount">{{ $onlineCount }}</span>
            <span class="presence-text-full">Online in {{ $categoryLabels[$room->category] ?? 'Room' }}</span>
            <span class="presence-text-short">Online</span>
        </div>
    </div>

    @if(session('error'))
        <div class="thread-alert alert-error">
            <i class="fa-solid fa-lock"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="thread-alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($room->is_premium && !$isUnlocked && !$isCreator && !$isAdmin)
        <!-- Security Pass Gate for Non-Unlocked Visitors -->
        <div class="thread-locked-gate">
            <div class="locked-gate-icon">
                <i class="fa-solid fa-key"></i>
            </div>
            <div class="locked-gate-tag" style="background: rgba(245, 158, 11, 0.15); border-color: rgba(245, 158, 11, 0.35); color: #f59e0b;">
                <i class="fa-solid fa-shield-halved"></i> Premium Room • Security Pass Protected
            </div>
            <h2 class="locked-gate-title">
                {{ $room->title }}
            </h2>
            <div style="font-size: 13px; color: #94a3b8; margin-bottom: 16px;">
                Discussion initiated by <strong style="color: #fff;">{{ $room->author_name }}</strong> 
                <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; font-size: 11px; padding: 2px 7px; border-radius: 4px; font-weight: 600; margin-left: 4px;">{{ $room->author_role }}</span>
                @if($room->expires_at)
                    • <span style="color: #fbbf24;"><i class="fa-solid fa-clock-rotate-left"></i> Valid until {{ $room->expires_at->format('M d, Y') }}</span>
                @endif
            </div>

            @if($room->description)
                <p class="locked-gate-desc" style="font-style: italic; background: rgba(0,0,0,0.25); border-left: 3px solid #f59e0b; padding: 10px 14px; border-radius: 6px; text-align: left; max-width: 580px; margin: 0 auto 24px auto;">
                    "{{ Str::limit($room->description, 220) }}"
                </p>
            @endif

            <!-- Section 1: Enter Security Pass -->
            <div style="background: rgba(15, 23, 42, 0.85); border: 1px solid rgba(245, 158, 11, 0.35); border-radius: 16px; padding: 22px; max-width: 480px; margin: 0 auto 24px auto; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <div style="font-size: 13.5px; font-weight: 700; color: #fff; margin-bottom: 4px; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="fa-solid fa-lock" style="color: #f59e0b;"></i> Enter Security Pass to Unlock & Join
                </div>
                <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 14px;">
                    If the author has provided you with the security pass code, enter it below to participate.
                </p>

                <form action="{{ route('chatroom.unlockPass', $room->id) }}" method="POST" style="display: flex; gap: 8px;">
                    @csrf
                    <input type="text" name="security_code" required placeholder="e.g. SEC-XXXXXX" 
                           style="flex: 1; background: #070d19; border: 1px solid rgba(245, 158, 11, 0.4); border-radius: 10px; padding: 10px 14px; color: #fbbf24; font-family: monospace; font-size: 14px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; outline: none;">
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border: none; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; white-space: nowrap; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);">
                        <i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Unlock & Join
                    </button>
                </form>
            </div>

            <!-- Section 2: Demand / Request Pass from Researcher -->
            <div style="max-width: 540px; margin: 0 auto; padding-top: 14px; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
                <div style="font-size: 12.5px; font-weight: 700; color: #cbd5e1; margin-bottom: 12px;">
                    Don't have the pass code? Request access from {{ $room->author_name }}:
                </div>

                <div class="locked-gate-actions">
                    @if($room->whats_app_request_url)
                        <a href="{{ $room->whats_app_request_url }}" target="_blank" 
                           style="background: #15803d; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(21, 128, 61, 0.3); transition: transform 0.2s;"
                           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i> Request via WhatsApp
                        </a>
                    @endif

                    <button type="button" onclick="document.getElementById('requestPassModal').style.display='flex'" 
                            style="background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.4); color: #60a5fa; padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;"
                            onmouseover="this.style.background='rgba(59, 130, 246, 0.25)'" onmouseout="this.style.background='rgba(59, 130, 246, 0.15)'">
                        <i class="fa-solid fa-envelope"></i> Request via Email / Platform
                    </button>

                    <a href="{{ route('chatroom.category', $room->category) }}" 
                       style="background: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); text-decoration: none; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                        Browse Other Topics
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Creator / Admin VIP Control Banner -->
        @if($isCreator || $isAdmin)
            <div style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(15, 23, 42, 0.95) 100%); border: 1px solid rgba(245, 158, 11, 0.4); border-radius: 16px; padding: 16px 20px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(245, 158, 11, 0.2); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                        <div>
                            <div style="font-size: 14px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px;">
                                <span>Researcher Creator Panel</span>
                                <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; font-size: 11px; padding: 2px 8px; border-radius: 6px; font-weight: 700;">VIP Discussion</span>
                            </div>
                            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 2px;">
                                @if($room->isExpired())
                                    <span style="color: #ef4444;"><i class="fa-solid fa-lock"></i> 1-Month Duration Concluded (Expired on {{ $room->expires_at->format('M d, Y') }}) — Content Preserved for You</span>
                                @elseif($room->expires_at)
                                    <span style="color: #34d399;"><i class="fa-solid fa-clock"></i> Active • {{ $room->daysRemaining() }} days left of 1-month validity</span>
                                @else
                                    <span style="color: #34d399;"><i class="fa-solid fa-circle-check"></i> Active</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Security Pass Display & Share Controls -->
                    @if($room->security_code)
                        <div style="display: flex; align-items: center; gap: 8px; background: rgba(0,0,0,0.4); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 10px; padding: 6px 12px;">
                            <span style="font-size: 11.5px; color: var(--text-secondary);">Security Pass:</span>
                            <code id="creatorPassCode" style="color: #fbbf24; font-size: 14px; font-weight: 800; letter-spacing: 1px;">{{ $room->security_code }}</code>
                            <button type="button" onclick="copySecurityPass('{{ $room->security_code }}')" 
                                    style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                <i class="fa-regular fa-copy"></i> Copy
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Creator Action Tools -->
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; padding-top: 10px; border-top: 1px dashed rgba(245, 158, 11, 0.2);">
                    <div style="font-size: 12px; color: #cbd5e1; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-share-nodes" style="color: #f59e0b;"></i>
                        <span>Share Pass with Participants:</span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px;">
                        @php
                            $shareMsg = "Join my premium legal discussion \"" . $room->title . "\" on Legals Forum. Use security pass: " . $room->security_code . " at: " . route('chatroom.show', [$room->category, $room->slug]);
                            $waShareUrl = "https://wa.me/?text=" . rawurlencode($shareMsg);
                            $emailShareUrl = "mailto:?subject=" . rawurlencode("Invitation to Premium Discussion: " . $room->title) . "&body=" . rawurlencode($shareMsg);
                        @endphp
                        <a href="{{ $waShareUrl }}" target="_blank" 
                           style="background: #15803d; color: #fff; text-decoration: none; padding: 5px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa-brands fa-whatsapp"></i> Share on WhatsApp
                        </a>
                        <a href="{{ $emailShareUrl }}" 
                           style="background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.4); color: #93c5fd; text-decoration: none; padding: 5px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-envelope"></i> Share via Email
                        </a>
                    </div>
                </div>

                <!-- Incoming Pending Pass Requests (if any) -->
                @if(isset($pendingRequests) && $pendingRequests->isNotEmpty())
                    <div style="margin-top: 14px; background: rgba(0,0,0,0.3); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 10px; padding: 12px;">
                        <div style="font-size: 12.5px; font-weight: 700; color: #fbbf24; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-inbox"></i> Incoming Pass Requests ({{ $pendingRequests->count() }})
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($pendingRequests as $pReq)
                                <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid var(--border-color); border-radius: 8px; padding: 10px 12px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px;">
                                    <div>
                                        <div style="font-size: 13px; font-weight: 700; color: #fff;">
                                            {{ $pReq->requester_name }}
                                            <span style="font-weight: 400; color: var(--text-secondary); font-size: 12px;">({{ $pReq->requester_email }})</span>
                                            @if($pReq->requester_phone)
                                                <span style="color: #34d399; font-size: 11.5px; margin-left: 6px;"><i class="fa-brands fa-whatsapp"></i> {{ $pReq->requester_phone }}</span>
                                            @endif
                                        </div>
                                        @if($pReq->note)
                                            <div style="font-size: 11.5px; color: #94a3b8; margin-top: 2px;">"{{ $pReq->note }}"</div>
                                        @endif
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <form action="{{ route('chatroom.approveRequest', [$room->id, $pReq->id]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 600; cursor: pointer;">
                                                <i class="fa-solid fa-check mr-1"></i> Approve & Email Code
                                            </button>
                                        </form>
                                        @if($pReq->requester_phone)
                                            @php
                                                $reqCleanPhone = preg_replace('/[^0-9]/', '', $pReq->requester_phone);
                                                if (strlen($reqCleanPhone) === 10 && strpos($reqCleanPhone, '0') === 0) {
                                                    $reqCleanPhone = '233' . substr($reqCleanPhone, 1);
                                                }
                                                $reqWaText = "Hello " . $pReq->requester_name . ", here is your security pass for \"" . $room->title . "\": " . $room->security_code;
                                                $reqWaUrl = "https://wa.me/" . $reqCleanPhone . "?text=" . rawurlencode($reqWaText);
                                            @endphp
                                            <a href="{{ $reqWaUrl }}" target="_blank" style="background: #15803d; color: #fff; text-decoration: none; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 600;">
                                                <i class="fa-brands fa-whatsapp"></i> Send via WhatsApp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Expiration Alert if Room Ended 1-Month Validity -->
        @if($room->isExpired())
            <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; color: #fca5a5;">
                <i class="fa-solid fa-clock-rotate-left" style="font-size: 20px; color: #ef4444; flex-shrink: 0;"></i>
                <div style="font-size: 13px; line-height: 1.45;">
                    @if($isCreator || $isAdmin)
                        <strong style="color: #fff;">1-Month Validity Concluded:</strong> This premium discussion thread reached its 30-day active period on {{ $room->expires_at->format('M d, Y') }}. Public replies are locked, but as the researcher/creator you maintain permanent access to view all content and messages.
                    @else
                        <strong style="color: #fff;">Discussion Concluded:</strong> This premium discussion reached its 1-month validity period on {{ $room->expires_at->format('M d, Y') }} and is now locked for new replies.
                    @endif
                </div>
            </div>
        @endif
        <!-- Main Original Post / Discussion Card -->
        <div class="thread-hero-card {{ $room->is_premium ? 'is-premium' : '' }}">
            <div class="thread-hero-header">
                <div class="thread-hero-author">
                    <div class="thread-hero-avatar">
                        {{ strtoupper(mb_substr($room->author_name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="thread-hero-author-info">
                        <div class="hero-author-name">{{ $room->author_name }}</div>
                        <div class="hero-author-meta">
                            <span class="hero-author-role">{{ $room->author_role }}</span>
                            <span class="meta-dot">•</span>
                            <span class="hero-time"><i class="fa-regular fa-clock"></i> {{ $room->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                @if($room->is_premium)
                    <span class="thread-premium-chip">
                        <i class="fa-solid fa-crown"></i> Premium Room
                    </span>
                @endif

                @if(auth()->check() && auth()->user()->isAdmin())
                    <div style="display: flex; align-items: center; gap: 8px; margin-left: auto;">
                        <form action="{{ route('admin.additional-menus.chatroom.pin', $room->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" title="{{ $room->is_pinned ? 'Unpin Discussion' : 'Pin Discussion' }}" style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); color: #f59e0b; padding: 5px 10px; border-radius: 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-thumbtack"></i> <span>{{ $room->is_pinned ? 'Pinned' : 'Pin' }}</span>
                            </button>
                        </form>
                        <form action="{{ route('admin.additional-menus.chatroom.lock', $room->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" title="{{ $room->is_locked ? 'Unlock Discussion' : 'Lock Discussion' }}" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 5px 10px; border-radius: 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid {{ $room->is_locked ? 'fa-lock' : 'fa-lock-open' }}"></i> <span>{{ $room->is_locked ? 'Locked' : 'Lock' }}</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <h1 class="thread-hero-title">
                {{ $room->title }}
            </h1>

            @if($room->description)
                <div class="thread-hero-body">
                    {{ $room->description }}
                </div>
            @endif
        </div>

        <!-- Thread Replies Section -->
        <div class="thread-feed-section">
            <div class="thread-feed-header">
                <h3 class="thread-feed-title">
                    <i class="fa-solid fa-comments"></i>
                    <span>Discussion Feed (<span id="replyCount">{{ $messages->count() }}</span>)</span>
                </h3>
                <span class="thread-feed-subtitle">Active community discourse</span>
            </div>

            <div id="messagesContainer" class="thread-messages-list">
                @forelse($messages as $msg)
                    <div class="message-card">
                        <div class="message-header">
                            <div class="message-author-group">
                                <div class="message-avatar">
                                    {{ strtoupper(mb_substr($msg->author_name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="message-author-info">
                                    <span class="message-author-name">{{ $msg->author_name }}</span>
                                    <span class="message-role-tag {{ $msg->author_role === 'Admin' ? 'role-admin' : '' }}">{{ $msg->author_role }}</span>
                                </div>
                            </div>
                            <span class="message-time">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="message-body">
                            {{ $msg->message }}
                        </div>
                    </div>
                @empty
                    <div id="emptyRepliesPlaceholder" class="empty-replies-box">
                        <i class="fa-regular fa-comment-dots empty-icon"></i>
                        <p>No responses yet. Start the conversation by sharing your thoughts below.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Reply Box / Participation Form -->
        <div class="thread-reply-card">
            <h4 class="thread-reply-title">
                <i class="fa-solid fa-reply"></i>
                <span>Participate in this Thread</span>
            </h4>

            @if(($room->is_locked || $room->isExpired()) && (!auth()->check() || (!auth()->user()->isAdmin() && (empty($room->user_id) || $room->user_id !== auth()->id()))))
                <div class="thread-locked-alert">
                    <i class="fa-solid fa-lock"></i>
                    <span>
                        @if($room->isExpired())
                            This premium discussion concluded after its 1-month validity period on {{ $room->expires_at->format('M d, Y') }} and is closed for new replies.
                        @else
                            This discussion is locked from further replies.
                        @endif
                    </span>
                </div>
            @else
                @if($room->isExpired() && ($isCreator || $isAdmin))
                    <div class="thread-locked-alert" style="background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24; margin-bottom: 16px;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>This thread reached its 1-month duration limit, but as the <strong>Researcher / Author</strong> you retain continuous access to post and archive responses.</span>
                    </div>
                @elseif($room->is_locked)
                    <div class="thread-locked-alert" style="background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24; margin-bottom: 16px;">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>This thread is locked for regular members, but as an <strong>Administrator</strong> you can post official responses.</span>
                    </div>
                @endif
                <form id="replyForm" action="{{ route('chatroom.postMessage', $room->id) }}" method="POST">
                    @csrf

                    @guest
                        <div class="guest-info-grid">
                            <div class="guest-input-wrap">
                                <label class="guest-input-label">Your Name / Pseudonym (Guest Mode)</label>
                                <input type="text" name="guest_name" value="{{ session('guest_chat_name') ?? request()->cookie('guest_chat_name') }}" placeholder="e.g. Legal Scholar / Student" required class="reply-guest-input">
                            </div>
                            <div class="guest-login-prompt">
                                <a href="javascript:void(0)" onclick="openLoginModal()" class="login-prompt-link">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <span>Have an account? Sign in for verified badge</span>
                                </a>
                            </div>
                        </div>
                    @endguest

                    <div class="reply-textarea-wrap">
                        <textarea name="message" id="replyMessage" rows="3" required placeholder="Write your legal commentary, perspective, or query..." class="reply-textarea"></textarea>
                    </div>

                    <div class="reply-submit-row">
                        <button type="submit" id="submitReplyBtn" class="reply-submit-btn">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Post Response</span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @endif

</div>

<!-- Modal for In-App Security Pass Request -->
<div id="requestPassModal" 
     onclick="if(event.target === this) this.style.display='none'"
     style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 300000; align-items: center; justify-content: center; padding: 20px 16px; backdrop-filter: blur(8px);">
    <div style="background: #0f172a; border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 18px; width: 100%; max-width: 500px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.6); animation: modalSlideUp 0.25s ease;">
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(245, 158, 11, 0.2); color: #f59e0b; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-key"></i>
                </div>
                <h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #fff;">Request Security Pass</h3>
            </div>
            <button type="button" onclick="document.getElementById('requestPassModal').style.display='none'" 
                    style="background: transparent; border: none; color: var(--text-secondary); cursor: pointer; font-size: 18px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('chatroom.requestPass', $room->id) }}" method="POST" style="padding: 20px;">
            @csrf
            <p style="font-size: 12.5px; color: var(--text-secondary); margin-bottom: 16px; line-height: 1.45;">
                Send a request to <strong>{{ $room->author_name }}</strong> to demand the access pass for <em>"{{ $room->title }}"</em>.
            </p>

            <div style="margin-bottom: 12px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: #e2e8f0; margin-bottom: 4px;">Your Full Name *</label>
                <input type="text" name="requester_name" required value="{{ auth()->check() ? auth()->user()->name : (session('guest_chat_name') ?? request()->cookie('guest_chat_name')) }}" placeholder="e.g. Ama Mensah" 
                       style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 9px 12px; color: #fff; font-size: 13px; outline: none;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #e2e8f0; margin-bottom: 4px;">Your Email *</label>
                    <input type="email" name="requester_email" required value="{{ auth()->check() ? auth()->user()->email : (session('guest_chat_email') ?? request()->cookie('guest_chat_email')) }}" placeholder="name@example.com" 
                           style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 9px 12px; color: #fff; font-size: 13px; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #e2e8f0; margin-bottom: 4px;">WhatsApp / Phone</label>
                    <input type="tel" name="requester_phone" value="{{ auth()->check() ? auth()->user()->phone : (session('guest_chat_contact') ?? request()->cookie('guest_chat_contact')) }}" placeholder="e.g. 0501234567" 
                           style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 9px 12px; color: #fff; font-size: 13px; outline: none;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: #e2e8f0; margin-bottom: 4px;">Note to Researcher (Optional)</label>
                <textarea name="note" rows="2" placeholder="Briefly mention your interest or background in this topic..." 
                          style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 12px; color: #fff; font-size: 12.5px; outline: none; resize: vertical;"></textarea>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                @if($room->email_request_url)
                    <a href="{{ $room->email_request_url }}" style="font-size: 11.5px; color: #60a5fa; text-decoration: underline;">
                        Or open in email client
                    </a>
                @else
                    <span></span>
                @endif
                <div style="display: flex; gap: 8px;">
                    <button type="button" onclick="document.getElementById('requestPassModal').style.display='none'" 
                            style="background: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); padding: 7px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" 
                            style="background: #2563eb; color: #fff; border: none; padding: 7px 18px; border-radius: 8px; font-size: 12.5px; font-weight: 700; cursor: pointer;">
                        Send Request
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* =========================================================
       Chatroom Show / Discussion View Styles
       ========================================================= */
    .thread-page-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 4px;
        box-sizing: border-box;
    }

    /* Navigation Bar */
    .thread-nav-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 20px;
    }

    .thread-back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary, #94a3b8);
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .thread-back-link:hover {
        color: #60a5fa;
    }

    .back-text-short {
        display: none;
    }

    /* Presence Pill */
    .thread-presence-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.25);
        color: #10b981;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .presence-text-short {
        display: none;
    }

    .pulse-indicator {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 8px;
        height: 8px;
    }

    .pulse-ping {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #10b981;
        opacity: 0.75;
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .pulse-dot {
        position: relative;
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
    }

    /* Alerts */
    .thread-alert {
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.35);
        color: #fca5a5;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #6ee7b7;
    }

    /* Locked Gate */
    .thread-locked-gate {
        background: var(--card-bg, #0b1329);
        border: 1px solid rgba(245, 158, 11, 0.4);
        border-radius: 20px;
        padding: 48px 32px;
        text-align: center;
        margin-bottom: 32px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .locked-gate-icon {
        width: 64px;
        height: 64px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%);
        border: 1px solid rgba(245, 158, 11, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #f59e0b;
        margin: 0 auto 20px auto;
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.25);
    }

    .locked-gate-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #f59e0b;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .locked-gate-title {
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 10px;
        font-family: var(--font-heading);
    }

    .locked-gate-desc {
        color: var(--text-secondary, #94a3b8);
        font-size: 14.5px;
        max-width: 520px;
        margin: 0 auto 26px auto;
        line-height: 1.6;
    }

    .locked-gate-actions {
        display: inline-flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .locked-btn-primary {
        background: var(--accent-gradient, linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%));
        border: none;
        color: #fff;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px var(--accent-glow, rgba(59, 130, 246, 0.35));
    }

    .locked-btn-secondary {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.1));
        color: #fff;
        padding: 12px 22px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .locked-btn-outline {
        background: transparent;
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.1));
        color: var(--text-secondary, #94a3b8);
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
    }

    /* Main Discussion Hero Card */
    .thread-hero-card {
        background: linear-gradient(135deg, rgba(17, 24, 39, 0.95) 0%, rgba(11, 19, 41, 0.98) 100%);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08));
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .thread-hero-card.is-premium {
        border-color: rgba(245, 158, 11, 0.45);
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.08);
    }

    .thread-hero-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 16px;
    }

    .thread-hero-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .thread-hero-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #fff;
        font-size: 16px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        flex-shrink: 0;
    }

    .hero-author-name {
        font-weight: 700;
        color: #fff;
        font-size: 15px;
        line-height: 1.2;
        margin-bottom: 3px;
    }

    .hero-author-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-secondary, #94a3b8);
    }

    .hero-author-role {
        color: #60a5fa;
        font-weight: 600;
    }

    .meta-dot {
        color: rgba(255, 255, 255, 0.3);
    }

    .hero-time {
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .thread-premium-chip {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%);
        border: 1px solid rgba(245, 158, 11, 0.5);
        color: #f59e0b;
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .thread-hero-title {
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        margin: 0 0 16px 0;
        font-family: var(--font-heading);
        line-height: 1.35;
        letter-spacing: -0.3px;
    }

    .thread-hero-body {
        color: #e2e8f0;
        font-size: 15px;
        line-height: 1.7;
        white-space: pre-line;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 18px;
    }

    /* Discussion Feed Section */
    .thread-feed-section {
        margin-bottom: 32px;
    }

    .thread-feed-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .thread-feed-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .thread-feed-title i {
        color: #3b82f6;
    }

    .thread-feed-subtitle {
        color: var(--text-muted, #64748b);
        font-size: 12.5px;
    }

    .thread-messages-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    /* Individual Message Card */
    .message-card {
        background: rgba(17, 24, 39, 0.65);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08));
        border-radius: 16px;
        padding: 18px 22px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        transition: border-color 0.2s ease;
    }

    .message-card:hover {
        border-color: rgba(59, 130, 246, 0.35);
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .message-author-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(59, 130, 246, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #60a5fa;
        font-size: 13px;
        flex-shrink: 0;
    }

    .message-author-info {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .message-author-name {
        font-weight: 700;
        color: #fff;
        font-size: 13.5px;
    }

    .message-role-tag {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
    }

    .message-role-tag.role-admin {
        background: rgba(239, 68, 68, 0.18) !important;
        color: #f87171 !important;
        border: 1px solid rgba(239, 68, 68, 0.35) !important;
        letter-spacing: 0.3px;
    }

    .message-time {
        color: var(--text-muted, #64748b);
        font-size: 12px;
        white-space: nowrap;
    }

    .message-body {
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.6;
        padding-left: 42px;
        word-break: break-word;
    }

    .empty-replies-box {
        background: var(--card-bg, #0b1329);
        border: 1px dashed var(--border-color, rgba(255, 255, 255, 0.1));
        border-radius: 16px;
        padding: 36px 20px;
        text-align: center;
        color: var(--text-secondary, #94a3b8);
        font-size: 13.5px;
    }

    .empty-icon {
        font-size: 28px;
        color: #3b82f6;
        margin-bottom: 10px;
        display: block;
        opacity: 0.8;
    }

    /* Reply Form Card */
    .thread-reply-card {
        background: var(--card-bg, #0b1329);
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.08));
        border-radius: 20px;
        padding: 26px 28px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    .thread-reply-title {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .thread-reply-title i {
        color: #3b82f6;
    }

    .thread-locked-alert {
        padding: 16px;
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        color: #f87171;
        text-align: center;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .guest-info-grid {
        margin-bottom: 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        align-items: flex-end;
    }

    .guest-input-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary, #94a3b8);
        margin-bottom: 6px;
    }

    .reply-guest-input {
        width: 100%;
        background: #070d19;
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.12));
        border-radius: 10px;
        padding: 10px 14px;
        color: #fff;
        font-size: 13.5px;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s ease;
    }

    .reply-guest-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .login-prompt-link {
        font-size: 12.5px;
        color: #60a5fa;
        text-decoration: underline;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
    }

    .login-prompt-link:hover {
        color: #93c5fd;
    }

    .reply-textarea-wrap {
        margin-bottom: 16px;
    }

    .reply-textarea {
        width: 100%;
        background: #070d19;
        border: 1px solid var(--border-color, rgba(255, 255, 255, 0.12));
        border-radius: 12px;
        padding: 14px 16px;
        color: #fff;
        font-size: 14px;
        outline: none;
        resize: vertical;
        line-height: 1.5;
        box-sizing: border-box;
        transition: border-color 0.2s ease;
        min-height: 90px;
    }

    .reply-textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .reply-submit-row {
        display: flex;
        justify-content: flex-end;
    }

    .reply-submit-btn {
        background: var(--accent-gradient, linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%));
        border: none;
        color: #fff;
        padding: 11px 26px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 13.5px;
        cursor: pointer;
        box-shadow: 0 4px 14px var(--accent-glow, rgba(59, 130, 246, 0.35));
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .reply-submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px var(--accent-glow, rgba(59, 130, 246, 0.5));
    }

    /* =========================================================
       Mobile Overrides (max-width: 768px)
       Strictly at the bottom for responsive priority
       ========================================================= */
    @media (max-width: 768px) {
        .thread-page-container {
            padding: 0 2px;
        }

        /* Top Nav Bar Mobile */
        .thread-nav-bar {
            margin-bottom: 14px !important;
            gap: 8px !important;
        }

        .back-text-full {
            display: none !important;
        }

        .back-text-short {
            display: inline !important;
        }

        .thread-back-link {
            font-size: 12.5px !important;
            padding: 6px 12px !important;
            border-radius: 8px !important;
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .thread-presence-pill {
            padding: 5px 10px !important;
            font-size: 11px !important;
            gap: 5px !important;
        }

        .presence-text-full {
            display: none !important;
        }

        .presence-text-short {
            display: inline !important;
        }

        /* Main Hero Card Mobile */
        .thread-hero-card {
            padding: 16px 14px !important;
            border-radius: 16px !important;
            margin-bottom: 18px !important;
        }

        .thread-hero-header {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 10px !important;
            margin-bottom: 12px !important;
        }

        .thread-hero-avatar {
            width: 36px !important;
            height: 36px !important;
            font-size: 14px !important;
        }

        .hero-author-name {
            font-size: 14px !important;
        }

        .hero-author-meta {
            font-size: 11.5px !important;
            gap: 5px !important;
        }

        .thread-premium-chip {
            align-self: flex-start !important;
            font-size: 10.5px !important;
            padding: 3px 9px !important;
        }

        .thread-hero-title {
            font-size: 17px !important;
            font-weight: 700 !important;
            margin: 0 0 10px 0 !important;
            line-height: 1.35 !important;
        }

        .thread-hero-body {
            font-size: 13.5px !important;
            line-height: 1.55 !important;
            padding-top: 12px !important;
        }

        /* Feed Header Mobile */
        .thread-feed-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 3px !important;
            margin-bottom: 12px !important;
        }

        .thread-feed-title {
            font-size: 15.5px !important;
        }

        .thread-feed-subtitle {
            font-size: 11.5px !important;
            padding-left: 23px !important;
        }

        /* Message Cards Mobile */
        .message-card {
            padding: 14px 12px !important;
            border-radius: 14px !important;
        }

        .message-header {
            margin-bottom: 8px !important;
        }

        .message-avatar {
            width: 28px !important;
            height: 28px !important;
            font-size: 11.5px !important;
        }

        .message-author-name {
            font-size: 13px !important;
        }

        .message-time {
            font-size: 11px !important;
        }

        .message-body {
            padding-left: 0 !important;
            margin-top: 6px !important;
            font-size: 13px !important;
            line-height: 1.5 !important;
        }

        /* Reply Card Mobile */
        .thread-reply-card {
            padding: 16px 14px !important;
            border-radius: 16px !important;
        }

        .thread-reply-title {
            font-size: 14.5px !important;
            margin-bottom: 12px !important;
        }

        .guest-info-grid {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
            margin-bottom: 12px !important;
        }

        .reply-guest-input {
            height: 40px !important;
            font-size: 13px !important;
            padding: 0 12px !important;
        }

        .login-prompt-link {
            font-size: 11.5px !important;
            margin-bottom: 4px !important;
        }

        .reply-textarea {
            font-size: 13.5px !important;
            padding: 10px 12px !important;
            min-height: 80px !important;
        }

        .reply-submit-row {
            width: 100% !important;
        }

        .reply-submit-btn {
            width: 100% !important;
            height: 42px !important;
            justify-content: center !important;
            border-radius: 10px !important;
            font-size: 13.5px !important;
        }

        /* Locked Gate Mobile */
        .thread-locked-gate {
            padding: 28px 16px !important;
            border-radius: 16px !important;
        }

        .locked-gate-icon {
            width: 50px !important;
            height: 50px !important;
            font-size: 22px !important;
            margin-bottom: 14px !important;
        }

        .locked-gate-title {
            font-size: 18px !important;
        }

        .locked-gate-desc {
            font-size: 13px !important;
            margin-bottom: 18px !important;
        }

        .locked-gate-actions {
            flex-direction: column !important;
            width: 100% !important;
            gap: 8px !important;
        }

        .locked-btn-primary, .locked-btn-secondary, .locked-btn-outline {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
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

@push('scripts')
<script>
    // AJAX Reply Submission
    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        const $btn = $('#submitReplyBtn');
        const originalText = $btn.html();
        $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Posting...').prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                $btn.html(originalText).prop('disabled', false);
                if (res && res.success) {
                    $('#emptyRepliesPlaceholder').remove();
                    
                    const authorInitial = (res.author || 'U').charAt(0).toUpperCase();
                    const newMsgHtml = `
                        <div class="message-card" style="animation: fadeIn 0.3s ease;">
                            <div class="message-header">
                                <div class="message-author-group">
                                    <div class="message-avatar">
                                        ${authorInitial}
                                    </div>
                                    <div class="message-author-info">
                                        <span class="message-author-name">${$('<div>').text(res.author).html()}</span>
                                        <span class="message-role-tag ${res.role === 'Admin' ? 'role-admin' : ''}">${$('<div>').text(res.role).html()}</span>
                                    </div>
                                </div>
                                <span class="message-time">Just now</span>
                            </div>
                            <div class="message-body">
                                ${$('<div>').text($('#replyMessage').val()).html()}
                            </div>
                        </div>
                    `;

                    $('#messagesContainer').append(newMsgHtml);
                    $('#replyMessage').val('');
                    
                    const countEl = $('#replyCount');
                    countEl.text(parseInt(countEl.text() || 0) + 1);
                }
            },
            error: function() {
                $btn.html(originalText).prop('disabled', false);
                alert('An error occurred while posting your reply. Please try again.');
            }
        });
    });

    // Realtime Presence Heartbeat
    setInterval(function() {
        $.ajax({
            url: "{{ route('chatroom.heartbeat', $room->category) }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res && res.onlineCount) {
                    $('#liveOnlineCount').text(res.onlineCount);
                }
            }
        });
    }, 25000);

    // Copy Security Pass
    window.copySecurityPass = function(code) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(code).then(() => {
                alert('Security Pass copied to clipboard: ' + code);
            }).catch(() => {
                fallbackCopy(code);
            });
        } else {
            fallbackCopy(code);
        }
    };

    function fallbackCopy(code) {
        const temp = document.createElement('textarea');
        temp.value = code;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        alert('Security Pass copied to clipboard: ' + code);
    }
</script>
@endpush
@endsection
