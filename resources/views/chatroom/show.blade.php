@extends('layouts.forum_portal')

@section('title', $room->title . ' - Legals Forum Community')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    <!-- Breadcrumb & Back -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
        <a href="{{ route('chatroom.category', $room->category) }}" 
           style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); font-size: 13.5px; font-weight: 600; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Back to {{ $categoryLabels[$room->category] ?? ucfirst($room->category) }}
        </a>

        <!-- Live Online Count Pill -->
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; padding: 6px 14px; border-radius: 100px; font-size: 12px; font-weight: 700;">
            <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block;"></span>
            <span id="liveOnlineCount">{{ $onlineCount }}</span> Online in {{ $categoryLabels[$room->category] ?? 'Room' }}
        </div>
    </div>

    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-lock"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-color); color: var(--success-color); padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($room->is_premium && !auth()->check())
        <!-- Locked Gate for Guest Users -->
        <div style="background: var(--card-bg); border: 1px solid rgba(245, 158, 11, 0.4); border-radius: 20px; padding: 48px 32px; text-align: center; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div style="width: 64px; height: 64px; border-radius: 20px; background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%); border: 1px solid rgba(245, 158, 11, 0.4); display: flex; align-items: center; justify-content: center; font-size: 28px; color: #f59e0b; margin: 0 auto 20px auto; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.25);">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); color: #f59e0b; padding: 4px 12px; border-radius: 100px; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                <i class="fa-solid fa-lock"></i> Premium Room Locked
            </div>
            <h2 style="font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 10px; font-family: var(--font-heading);">
                {{ $room->title }}
            </h2>
            <p style="color: var(--text-secondary); font-size: 14.5px; max-width: 520px; margin: 0 auto 26px auto; line-height: 1.6;">
                Guest users cannot access premium rooms. Sign in to your account or register to unlock access to exclusive legal discussions, case studies, and practitioner rooms.
            </p>
            <div style="display: inline-flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <button type="button" onclick="openLoginModal()" 
                        style="background: var(--accent-gradient); border: none; color: #fff; padding: 12px 24px; border-radius: 10px; font-size: 13.5px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px var(--accent-glow);">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In to Access
                </button>
                <a href="/get-started" 
                   style="background: rgba(255, 255, 255, 0.06); border: 1px solid var(--border-color); color: #fff; padding: 12px 22px; border-radius: 10px; font-size: 13.5px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-user-plus"></i> Create Free Account
                </a>
                <a href="{{ route('chatroom.category', $room->category) }}" 
                   style="background: transparent; border: 1px solid var(--border-color); color: var(--text-secondary); padding: 12px 20px; border-radius: 10px; font-size: 13.5px; font-weight: 600; text-decoration: none;">
                    Browse Free Topics
                </a>
            </div>
        </div>
    @else
    <!-- Main Original Post / Discussion Card -->
    <div style="background: var(--card-bg); border: 1px solid {{ $room->is_premium ? 'rgba(245, 158, 11, 0.45)' : 'var(--border-color)' }}; border-radius: 20px; padding: 32px; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; font-weight: 800; color: #fff; font-size: 16px;">
                    {{ strtoupper(substr($room->author_name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 700; color: #fff; font-size: 15px;">{{ $room->author_name }}</div>
                    <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-secondary);">
                        <span style="color: #60a5fa; font-weight: 600;">{{ $room->author_role }}</span>
                        <span>•</span>
                        <span>{{ $room->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            @if($room->is_premium)
                <span style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-crown"></i> Premium Forum Room
                </span>
            @endif
        </div>

        <h1 style="font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 16px; font-family: var(--font-heading); line-height: 1.3;">
            {{ $room->title }}
        </h1>

        <div style="color: #e2e8f0; font-size: 15px; line-height: 1.7; white-space: pre-line; border-top: 1px solid var(--border-color); padding-top: 18px;">
            {{ $room->description }}
        </div>
    </div>

    <!-- Thread Replies Section -->
    <div style="margin-bottom: 36px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-comments" style="color: #3b82f6;"></i>
                Discussion Feed (<span id="replyCount">{{ $messages->count() }}</span>)
            </h3>
            <small style="color: var(--text-muted); font-size: 12px;">Active community discourse</small>
        </div>

        <div id="messagesContainer" style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($messages as $msg)
                <div class="message-card" style="background: rgba(17, 24, 39, 0.6); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #fff; font-size: 13px;">
                                {{ strtoupper(substr($msg->author_name, 0, 1)) }}
                            </div>
                            <div>
                                <span style="font-weight: 700; color: #fff; font-size: 13.5px;">{{ $msg->author_name }}</span>
                                <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; margin-left: 6px;">
                                    {{ $msg->author_role }}
                                </span>
                            </div>
                        </div>
                        <span style="color: var(--text-muted); font-size: 12px;">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>

                    <div style="color: #cbd5e1; font-size: 14px; line-height: 1.6; padding-left: 42px;">
                        {{ $msg->message }}
                    </div>
                </div>
            @empty
                <div id="emptyRepliesPlaceholder" style="background: var(--card-bg); border: 1px dashed var(--border-color); border-radius: 16px; padding: 32px; text-align: center; color: var(--text-secondary);">
                    No responses yet. Start the conversation by sharing your thoughts below.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Reply Box / Participation Form -->
    <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 28px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
        <h4 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-reply" style="color: #3b82f6;"></i>
            Participate in this Thread
        </h4>

        @if($room->is_locked)
            <div style="padding: 16px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; color: #f87171; text-align: center; font-size: 14px;">
                <i class="fa-solid fa-lock mr-2"></i> This discussion is locked from further replies.
            </div>
        @else
            <form id="replyForm" action="{{ route('chatroom.postMessage', $room->id) }}" method="POST">
                @csrf

                @guest
                    <div style="margin-bottom: 16px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Your Name / Pseudonym (Guest Mode)</label>
                            <input type="text" name="guest_name" value="{{ session('guest_chat_name') ?? request()->cookie('guest_chat_name') }}" placeholder="e.g. Legal Scholar / Student" required
                                   style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 10px; padding: 10px 14px; color: #fff; font-size: 13.5px; outline: none;">
                        </div>
                        <div style="display: flex; align-items: flex-end;">
                            <a href="javascript:void(0)" onclick="openLoginModal()" style="font-size: 12.5px; color: #60a5fa; text-decoration: underline; margin-bottom: 10px;">
                                Have an account? Sign in for verified role badge
                            </a>
                        </div>
                    </div>
                @endguest

                <div style="margin-bottom: 16px;">
                    <textarea name="message" id="replyMessage" rows="3" required placeholder="Write your legal commentary, perspective, or query..." 
                              style="width: 100%; background: #070d19; border: 1px solid var(--border-color); border-radius: 12px; padding: 14px 16px; color: #fff; font-size: 14px; outline: none; resize: vertical; line-height: 1.5;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" id="submitReplyBtn"
                            style="background: var(--accent-gradient); border: none; color: #fff; padding: 11px 26px; border-radius: 100px; font-weight: 700; font-size: 13.5px; cursor: pointer; box-shadow: 0 4px 14px var(--accent-glow); display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-paper-plane"></i> Post Response
                    </button>
                </div>
            </form>
        @endif
    </div>
@endif

</div>

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
                    
                    const newMsgHtml = `
                        <div class="message-card" style="background: rgba(17, 24, 39, 0.6); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px 24px; animation: fadeIn 0.3s ease;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: rgba(59, 130, 246, 0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #60a5fa; font-size: 13px;">
                                        ${res.author.charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <span style="font-weight: 700; color: #fff; font-size: 13.5px;">${res.author}</span>
                                        <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; margin-left: 6px;">
                                            ${res.role}
                                        </span>
                                    </div>
                                </div>
                                <span style="color: var(--text-muted); font-size: 12px;">Just now</span>
                            </div>
                            <div style="color: #cbd5e1; font-size: 14px; line-height: 1.6; padding-left: 42px;">
                                ${$('#replyMessage').val()}
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
