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

    @if($room->is_premium && !auth()->check())
        <!-- Locked Gate for Guest Users -->
        <div class="thread-locked-gate">
            <div class="locked-gate-icon">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div class="locked-gate-tag">
                <i class="fa-solid fa-lock"></i> Premium Room Locked
            </div>
            <h2 class="locked-gate-title">
                {{ $room->title }}
            </h2>
            <p class="locked-gate-desc">
                Guest users cannot access premium rooms. Sign in to your account or register to unlock access to exclusive legal discussions, case studies, and practitioner rooms.
            </p>
            <div class="locked-gate-actions">
                <button type="button" onclick="openLoginModal()" class="locked-btn-primary">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In to Access
                </button>
                <a href="/get-started" class="locked-btn-secondary">
                    <i class="fa-solid fa-user-plus"></i> Create Free Account
                </a>
                <a href="{{ route('chatroom.category', $room->category) }}" class="locked-btn-outline">
                    Browse Free Topics
                </a>
            </div>
        </div>
    @else
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

            @if($room->is_locked && (!auth()->check() || !auth()->user()->isAdmin()))
                <div class="thread-locked-alert">
                    <i class="fa-solid fa-lock"></i>
                    <span>This discussion is locked from further replies.</span>
                </div>
            @else
                @if($room->is_locked)
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
</script>
@endpush
@endsection
