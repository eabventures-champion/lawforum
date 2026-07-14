@extends('layouts.admin')

@section('title', 'Notifications Center')

@section('content')
<div style="padding: 24px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: #fff; margin: 0 0 4px 0;">Notifications & Feedback</h1>
            <p style="color: var(--text-secondary); margin: 0; font-size: 14px;">Track new user signups and reply to complaints and suggestions.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            @if($unreadAlerts > 0)
                <button onclick="markAllAsRead()" class="btn btn-secondary btn-action" style="padding: 8px 16px; gap: 6px; display: inline-flex; align-items: center; height: 38px; font-size: 14px; background-color: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2); color: #3b82f6; cursor: pointer;">
                    <i class="fa-solid fa-envelope-open"></i> Mark All Read
                </button>
            @endif
            @if($totalAlerts > 0)
                <button onclick="clearAllNotifications()" class="btn btn-danger btn-action" style="padding: 8px 16px; gap: 6px; display: inline-flex; align-items: center; height: 38px; font-size: 14px; cursor: pointer;">
                    <i class="fa-solid fa-trash-can"></i> Clear All History
                </button>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 32px;">
        <div class="stat-card" style="padding: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="color: var(--text-secondary); font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Total Alerts</div>
                    <div style="font-size: 24px; font-weight: 700; color: #fff;">{{ $totalAlerts }}</div>
                </div>
                <div style="background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px;">
                    <i class="fa-solid fa-bell" style="font-size: 20px; color: var(--text-secondary);"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" style="padding: 20px; border-left: 3px solid #ef4444;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="color: #ef4444; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Unread Alerts</div>
                    <div id="stats-unread-count" style="font-size: 24px; font-weight: 700; color: #fff;">{{ $unreadAlerts }}</div>
                </div>
                <div style="background: rgba(239, 68, 68, 0.1); padding: 12px; border-radius: 12px;">
                    <i class="fa-solid fa-circle-exclamation" style="font-size: 20px; color: #ef4444;"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" style="padding: 20px; border-left: 3px solid #10b981;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="color: #10b981; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">User Signups</div>
                    <div style="font-size: 24px; font-weight: 700; color: #fff;">{{ $totalSignups }}</div>
                </div>
                <div style="background: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 12px;">
                    <i class="fa-solid fa-user-plus" style="font-size: 20px; color: #10b981;"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" style="padding: 20px; border-left: 3px solid #eab308;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="color: #eab308; font-size: 13px; font-weight: 600; text-transform: uppercase; margin-bottom: 6px;">Complaints</div>
                    <div style="font-size: 24px; font-weight: 700; color: #fff;">{{ $totalComplaints }}</div>
                </div>
                <div style="background: rgba(234, 179, 8, 0.1); padding: 12px; border-radius: 12px;">
                    <i class="fa-solid fa-message" style="font-size: 20px; color: #eab308;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div style="background: #111827; border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);">
        <!-- Filter Tabs -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.notifications.index', ['filter' => 'all']) }}" class="tab-btn {{ $filter === 'all' ? 'active' : '' }}" style="text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; padding: 6px 12px; border-radius: 8px;">All Alerts</a>
                <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}" class="tab-btn {{ $filter === 'unread' ? 'active' : '' }}" style="text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; padding: 6px 12px; border-radius: 8px; gap: 6px;">
                    Unread Only 
                    @if($unreadAlerts > 0)
                        <span style="background: #ef4444; color: #fff; font-size: 11px; font-weight: 700; padding: 1px 6px; border-radius: 8px;">{{ $unreadAlerts }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Table Listing -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color); background: rgba(255,255,255,0.02);">
                        <th style="padding: 16px 24px; color: var(--text-secondary); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                        <th style="padding: 16px 24px; color: var(--text-secondary); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Sender Details</th>
                        <th style="padding: 16px 24px; color: var(--text-secondary); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Subject / Summary</th>
                        <th style="padding: 16px 24px; color: var(--text-secondary); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Date</th>
                        <th style="padding: 16px 24px; color: var(--text-secondary); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        @php
                            $isUnread = is_null($notification->read_at);
                            $data = $notification->data;
                        @endphp
                        <tr id="notification-row-{{ $notification->id }}" style="border-bottom: 1px solid var(--border-color); transition: background 0.2s; @if($isUnread) background-color: rgba(59, 130, 246, 0.03); font-weight: 500; @endif" class="notification-item-row">
                            <!-- Type Column -->
                            <td style="padding: 16px 24px;">
                                @if($notification->type === 'signup')
                                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                        <i class="fa-solid fa-user-plus"></i> User Signup
                                    </span>
                                @else
                                    @php
                                        $cType = $data['type'] ?? 'complaint';
                                    @endphp
                                    @if($cType === 'complaint')
                                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Complaint
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; background: rgba(234, 179, 8, 0.1); color: #eab308;">
                                            <i class="fa-solid fa-lightbulb"></i> Suggestion
                                        </span>
                                    @endif
                                @endif
                            </td>

                            <!-- Sender Column -->
                            <td style="padding: 16px 24px;">
                                <div style="color: #fff; font-size: 14px;">{{ $data['name'] ?? 'Guest Submitter' }}</div>
                                <div style="color: var(--text-secondary); font-size: 12px;">{{ $data['email'] ?? 'N/A' }}</div>
                            </td>

                            <!-- Summary Column -->
                            <td style="padding: 16px 24px;">
                                @if($notification->type === 'signup')
                                    <span style="color: var(--text-secondary); font-size: 13px;">New signup from <strong>{{ $data['country'] ?? 'Unknown' }}</strong></span>
                                @else
                                    <div style="color: #fff; font-size: 13px; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $data['subject'] ?? 'No Subject' }}
                                    </div>
                                    <div style="color: var(--text-secondary); font-size: 12px; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $data['message'] ?? 'No Message' }}
                                    </div>
                                @endif
                            </td>

                            <!-- Date Column -->
                            <td style="padding: 16px 24px; color: var(--text-secondary); font-size: 13px;">
                                {{ $notification->created_at->diffForHumans() }}
                            </td>

                            <!-- Actions Column -->
                            <td style="padding: 16px 24px; text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                    @if($isUnread)
                                        <button onclick="markSingleAsRead({{ $notification->id }}, this)" class="btn btn-secondary btn-action" title="Mark as read" style="padding: 6px 10px; background-color: rgba(255,255,255,0.03); border: 1px solid var(--border-color); color: var(--text-secondary); height: 32px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    @endif

                                    <button onclick="openNotificationDetails({{ json_encode($notification) }})" class="btn btn-primary btn-action" style="padding: 6px 12px; height: 32px; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                                        <i class="fa-solid fa-magnifying-glass"></i> View
                                    </button>

                                    <button onclick="deleteSingleNotification({{ $notification->id }}, this)" class="btn btn-danger btn-action" title="Delete" style="padding: 6px 10px; height: 32px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 48px 24px; text-align: center; color: var(--text-secondary);">
                                <div style="margin-bottom: 12px;"><i class="fa-solid fa-bell-slash" style="font-size: 32px; opacity: 0.5;"></i></div>
                                <span>No notifications found in this list.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid var(--border-color);">
                {!! $notifications->links() !!}
            </div>
        @endif
    </div>
</div>

<!-- Details & Reply Modal -->
<div id="details-modal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(8px); align-items: center; justify-content: center;">
    <div style="background: #111827; border: 1px solid var(--border-color); border-radius: 16px; width: 620px; max-width: 95%; max-height: 90vh; overflow-y: auto; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); display: flex; flex-direction: column;">
        
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
            <h3 id="modal-title" style="margin: 0; font-size: 18px; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 8px;">
                <!-- Filled by JS -->
            </h3>
            <button type="button" onclick="closeDetailsModal()" style="background: transparent; border: none; color: var(--text-secondary); cursor: pointer; font-size: 18px; line-height: 1;">&times;</button>
        </div>

        <!-- Modal Body Content -->
        <div style="flex: 1; overflow-y: auto;">
            <!-- Alert Details -->
            <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <div style="color: var(--text-secondary); font-size: 12px; margin-bottom: 2px;">Submitter Name</div>
                        <div id="modal-sender-name" style="color: #fff; font-size: 14px; font-weight: 500;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-secondary); font-size: 12px; margin-bottom: 2px;">Email Address</div>
                        <div id="modal-sender-email" style="color: #fff; font-size: 14px; font-weight: 500;"></div>
                    </div>
                </div>
                <div id="modal-signup-extra" style="display: none; grid-template-columns: 1fr 1fr; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 12px;">
                    <div>
                        <div style="color: var(--text-secondary); font-size: 12px; margin-bottom: 2px;">Registered User ID</div>
                        <div id="modal-user-id" style="color: #fff; font-size: 14px;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-secondary); font-size: 12px; margin-bottom: 2px;">Country Location</div>
                        <div id="modal-user-country" style="color: #fff; font-size: 14px;"></div>
                    </div>
                </div>
                <div id="modal-complaint-extra" style="display: none; border-top: 1px solid var(--border-color); padding-top: 12px;">
                    <div style="margin-bottom: 12px;">
                        <div style="color: var(--text-secondary); font-size: 12px; margin-bottom: 2px;">Subject</div>
                        <div id="modal-complaint-subject" style="color: #fff; font-size: 14px; font-weight: 600;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-secondary); font-size: 12px; margin-bottom: 4px;">Original Submission Text</div>
                        <div id="modal-complaint-text" style="color: var(--text-secondary); font-size: 13px; line-height: 1.5; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.03); white-space: pre-wrap;"></div>
                    </div>
                </div>
            </div>

            <!-- Historical Replies List -->
            <div id="modal-replies-section" style="display: none; margin-bottom: 24px;">
                <h4 style="margin: 0 0 12px 0; color: #fff; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-history" style="color: #3b82f6;"></i> Response Logs
                </h4>
                <div id="modal-replies-list" style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Filled by JS -->
                </div>
            </div>

            <!-- Reply Form Section -->
            <div id="modal-reply-form-section" style="display: none; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <h4 style="margin: 0 0 12px 0; color: #fff; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-reply" style="color: #10b981;"></i> Reply to User Submitter
                </h4>
                <form id="reply-form" onsubmit="submitAdminReply(event)">
                    @csrf
                    <input type="hidden" id="reply-complaint-id" name="complaint_id">
                    <div style="margin-bottom: 16px;">
                        <textarea id="reply-message" name="message" required placeholder="Type your reply message here... The submitter will receive this reply directly as a clean HTML email response." style="width: 100%; height: 120px; background: #1f2937; border: 1px solid var(--border-color); border-radius: 8px; padding: 12px; color: #fff; font-size: 13px; font-family: inherit; resize: vertical; outline: none;"></textarea>
                    </div>
                    <div style="display: flex; justify-content: flex-end; gap: 12px;">
                        <button type="button" class="btn btn-secondary btn-action" onclick="closeDetailsModal()" style="height: 38px; padding: 0 16px;">Cancel</button>
                        <button type="submit" id="reply-submit-btn" class="btn btn-action" style="height: 38px; padding: 0 16px; background-color: #10b981; color: #fff; border: none; font-weight: 500; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                            <i class="fa-solid fa-paper-plane"></i> Send Reply Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeNotificationId = null;

    function openNotificationDetails(notification) {
        activeNotificationId = notification.id;
        
        const modal = document.getElementById('details-modal');
        const title = document.getElementById('modal-title');
        const sName = document.getElementById('modal-sender-name');
        const sEmail = document.getElementById('modal-sender-email');
        const signupExtra = document.getElementById('modal-signup-extra');
        const complaintExtra = document.getElementById('modal-complaint-extra');
        const repliesSection = document.getElementById('modal-replies-section');
        const repliesList = document.getElementById('modal-replies-list');
        const replyFormSection = document.getElementById('modal-reply-form-section');
        const replyComplaintId = document.getElementById('reply-complaint-id');
        const replyMessage = document.getElementById('reply-message');

        // Reset elements
        signupExtra.style.display = 'none';
        complaintExtra.style.display = 'none';
        repliesSection.style.display = 'none';
        replyFormSection.style.display = 'none';
        replyMessage.value = '';

        sName.textContent = notification.data.name || 'Guest Submitter';
        sEmail.textContent = notification.data.email || 'N/A';

        if (notification.type === 'signup') {
            title.innerHTML = `<i class="fa-solid fa-user-plus" style="color: #10b981;"></i> User Registration Alert`;
            document.getElementById('modal-user-id').textContent = '#' + notification.data.user_id;
            document.getElementById('modal-user-country').textContent = notification.data.country || 'Unknown';
            signupExtra.style.display = 'grid';
        } else {
            const cType = notification.data.type || 'complaint';
            const icon = cType === 'complaint' ? 'triangle-exclamation' : 'lightbulb';
            const color = cType === 'complaint' ? '#ef4444' : '#eab308';
            title.innerHTML = `<i class="fa-solid fa-${icon}" style="color: ${color};"></i> ${cType.charAt(0).toUpperCase() + cType.slice(1)} Details`;
            
            document.getElementById('modal-complaint-subject').textContent = notification.data.subject || 'No Subject';
            document.getElementById('modal-complaint-text').textContent = notification.data.message || 'No Message';
            complaintExtra.style.display = 'block';

            // Setup reply structures
            replyComplaintId.value = notification.data.complaint_id;
            replyFormSection.style.display = 'block';

            // Display historical replies if any
            repliesList.innerHTML = '';
            if (notification.replies && notification.replies.length > 0) {
                notification.replies.forEach(rep => {
                    const rDiv = document.createElement('div');
                    rDiv.style.background = 'rgba(59, 130, 246, 0.05)';
                    rDiv.style.border = '1px solid rgba(59, 130, 246, 0.15)';
                    rDiv.style.borderRadius = '8px';
                    rDiv.style.padding = '12px';
                    
                    const timeSpan = new Date(rep.created_at).toLocaleString();
                    rDiv.innerHTML = `
                        <div style="display: flex; justify-content: space-between; font-size: 11px; color: #60a5fa; margin-bottom: 6px; font-weight: 600;">
                            <span>ADMINISTRATOR REPLY</span>
                            <span>${timeSpan}</span>
                        </div>
                        <div style="font-size: 13px; color: #fff; line-height: 1.4; white-space: pre-wrap;">${rep.message}</div>
                    `;
                    repliesList.appendChild(rDiv);
                });
                repliesSection.style.display = 'block';
            }
        }

        modal.style.display = 'flex';

        // Auto mark as read on view if unread
        const row = document.getElementById(`notification-row-${notification.id}`);
        if (row && row.style.fontWeight === '500') {
            markSingleAsReadSilently(notification.id);
        }
    }

    function closeDetailsModal() {
        document.getElementById('details-modal').style.display = 'none';
        activeNotificationId = null;
    }

    function markSingleAsRead(id, button) {
        fetch(`/admin/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Dim down unread row style
                const row = document.getElementById(`notification-row-${id}`);
                if (row) {
                    row.style.backgroundColor = '';
                    row.style.fontWeight = '';
                }
                if (button) button.remove();
                
                // Decrement unread counts in headers/sidebars
                decrementUnreadCounts();
            }
        })
        .catch(err => console.error('Error marking notification read:', err));
    }

    function markSingleAsReadSilently(id) {
        fetch(`/admin/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`notification-row-${id}`);
                if (row) {
                    row.style.backgroundColor = '';
                    row.style.fontWeight = '';
                }
                const btn = row ? row.querySelector('[title="Mark as read"]') : null;
                if (btn) btn.remove();
                decrementUnreadCounts();
            }
        });
    }

    function markAllAsRead() {
        if (!confirm('Are you sure you want to mark all notifications as read?')) return;

        fetch('/admin/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }

    function deleteSingleNotification(id, button) {
        if (!confirm('Are you sure you want to delete this notification from history?')) return;

        fetch(`/admin/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`notification-row-${id}`);
                if (row) row.remove();
                window.location.reload();
            }
        });
    }

    function clearAllNotifications() {
        if (!confirm('CAUTION: This will permanently wipe all signup alerts, messages, and replies history from logs! Are you sure?')) return;

        fetch('/admin/notifications', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }

    function submitAdminReply(event) {
        event.preventDefault();
        
        const complaintId = document.getElementById('reply-complaint-id').value;
        const msgText = document.getElementById('reply-message').value;
        const submitBtn = document.getElementById('reply-submit-btn');

        if (!msgText.trim()) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Sending Reply...`;

        fetch(`/admin/complaints/${complaintId}/reply`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ message: msgText })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Email reply sent successfully to user submitter!');
                closeDetailsModal();
                window.location.reload();
            } else {
                alert('Could not dispatch email. Response logged locally.');
                window.location.reload();
            }
        })
        .catch(err => {
            console.error('Error sending reply:', err);
            alert('Response logged. Email connection could not be established.');
            window.location.reload();
        });
    }

    function decrementUnreadCounts() {
        const statsUnread = document.getElementById('stats-unread-count');
        const badge = document.querySelector('.sidebar-menu span[style*="background-color: #ef4444"]');
        
        if (statsUnread) {
            let count = parseInt(statsUnread.textContent);
            if (count > 0) {
                statsUnread.textContent = count - 1;
            }
        }
        if (badge) {
            let count = parseInt(badge.textContent);
            if (count > 1) {
                badge.textContent = count - 1;
            } else {
                badge.remove();
            }
        }
    }
</script>
@endsection
