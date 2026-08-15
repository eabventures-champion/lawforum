<!-- Platform Updates & Feature Notification Dropdown Component -->
<div class="notification-dropdown-container" id="notificationDropdownContainer">
    <button class="header-icon-btn" id="notificationBellBtn" type="button" aria-expanded="false" title="Platform Updates & Alerts" onclick="toggleNotificationDropdown(event)">
        <i class="fa-regular fa-bell"></i>
        <span class="header-icon-badge" id="notificationUnreadDot" style="display: none;"></span>
    </button>

    <div class="notification-menu-dropdown" id="notificationMenuDropdown">
        <div class="notification-menu-header">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-bullhorn" style="color: #60a5fa; font-size: 14px;"></i>
                <span style="font-size: 14px; font-weight: 700; color: #fff;">Platform Updates</span>
                <span class="notification-count-pill" id="notificationCountBadge" style="display: none;">0 New</span>
            </div>
            <button type="button" class="btn-mark-all-read" onclick="markAllNotificationsAsRead(event)">
                Mark all read
            </button>
        </div>

        <div class="notification-menu-list" id="notificationItemsList">
            <div class="notification-loading-state">
                <i class="fa-solid fa-circle-notch fa-spin"></i>
                <span>Loading alerts...</span>
            </div>
        </div>

        <div class="notification-menu-footer">
            <button type="button" class="btn-start-full-tour" onclick="startFullTourFromMenu(event)">
                <i class="fa-solid fa-compass" style="color: #f59e0b;"></i>
                <span>Take Full Dashboard Tour</span>
            </button>
        </div>
    </div>
</div>

<style>
/* ── Notification Bell & Menu Dropdown Styling ────────────────────── */
.notification-dropdown-container {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.header-icon-badge {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 8px;
    height: 8px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid #0f172a;
    box-shadow: 0 0 8px rgba(239, 68, 68, 0.8);
    animation: pulseBadge 2s infinite ease-in-out;
}

@keyframes pulseBadge {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.8; }
}

.notification-menu-dropdown {
    position: absolute;
    top: calc(100% + 12px);
    right: 0;
    width: 360px;
    max-width: 90vw;
    background: #0b1120;
    background: linear-gradient(180deg, #0e1626 0%, #080d18 100%);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 16px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.85), 0 0 30px rgba(59, 130, 246, 0.12);
    z-index: 1050;
    display: none;
    overflow: hidden;
    animation: notifDropdownIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.notification-menu-dropdown.show {
    display: block;
}

@keyframes notifDropdownIn {
    from { opacity: 0; transform: translateY(-8px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.notification-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    background: rgba(255, 255, 255, 0.02);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.notification-count-pill {
    font-size: 10px;
    font-weight: 800;
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.35);
    padding: 2px 7px;
    border-radius: 20px;
}

.btn-mark-all-read {
    background: transparent;
    border: none;
    color: #94a3b8;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 6px;
    transition: all 0.15s ease;
}
.btn-mark-all-read:hover {
    color: #60a5fa;
    background: rgba(255, 255, 255, 0.05);
}

.notification-menu-list {
    max-height: 380px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
}

.notification-item {
    padding: 14px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: background 0.15s ease;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.notification-item:hover {
    background: rgba(255, 255, 255, 0.03);
}

.notification-item.unread {
    background: rgba(59, 130, 246, 0.04);
    border-left: 3px solid #3b82f6;
}

.notification-item-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.notif-badge {
    font-size: 9.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 2px 7px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.notif-badge-general {
    background: rgba(59, 130, 246, 0.15);
    color: #60a5fa;
    border: 1px solid rgba(59, 130, 246, 0.3);
}
.notif-badge-bespoke {
    background: rgba(245, 158, 11, 0.15);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.notif-time {
    font-size: 11px;
    color: var(--text-muted);
}

.notif-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #fff;
    line-height: 1.35;
    margin: 0;
}

.notif-summary {
    font-size: 12px;
    color: #94a3b8;
    line-height: 1.45;
    margin: 0;
}

.notif-actions-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 4px;
}

.btn-notif-tour {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(29, 78, 216, 0.15) 100%);
    border: 1px solid rgba(59, 130, 246, 0.4);
    color: #93c5fd;
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-notif-tour:hover {
    background: #3b82f6;
    color: #fff;
}

.btn-notif-read {
    background: transparent;
    border: none;
    color: #64748b;
    font-size: 11px;
    cursor: pointer;
    padding: 3px 6px;
}
.btn-notif-read:hover {
    color: #cbd5e1;
}

.notification-loading-state,
.notification-empty-state {
    padding: 32px 20px;
    text-align: center;
    color: #94a3b8;
    font-size: 13px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.notification-menu-footer {
    padding: 10px 16px;
    background: rgba(255, 255, 255, 0.02);
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.btn-start-full-tour {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 8px;
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.25);
    color: #fbbf24;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
}
.btn-start-full-tour:hover {
    background: rgba(245, 158, 11, 0.2);
    border-color: rgba(245, 158, 11, 0.4);
}

@media (max-width: 768px) {
    .notification-menu-dropdown {
        right: -50px !important;
        width: 320px !important;
    }
}
</style>

<script>
let cachedPlatformUpdates = [];

function toggleNotificationDropdown(e) {
    e.stopPropagation();
    const menu = document.getElementById('notificationMenuDropdown');
    
    // Close other dropdowns (user profile, etc.)
    const profileMenu = document.getElementById('profileDropdownMenu');
    if (profileMenu) profileMenu.classList.remove('show');

    if (menu) {
        menu.classList.toggle('show');
        if (menu.classList.contains('show')) {
            fetchAndRenderNotifications();
        }
    }
}

function updateNotificationBellBadge(unreadCount, updates) {
    const dot = document.getElementById('notificationUnreadDot');
    const badge = document.getElementById('notificationCountBadge');
    
    if (dot) {
        dot.style.display = unreadCount > 0 ? 'block' : 'none';
    }
    if (badge) {
        if (unreadCount > 0) {
            badge.style.display = 'inline-block';
            badge.textContent = `${unreadCount} New`;
        } else {
            badge.style.display = 'none';
        }
    }
}

function fetchAndRenderNotifications() {
    fetch('/accounts/platform-updates')
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                cachedPlatformUpdates = data.updates || [];
                updateNotificationBellBadge(data.unread_count, cachedPlatformUpdates);
                renderNotificationList(cachedPlatformUpdates);
            }
        })
        .catch(() => {
            const listEl = document.getElementById('notificationItemsList');
            if (listEl) {
                listEl.innerHTML = '<div class="notification-empty-state"><i class="fa-solid fa-triangle-exclamation"></i><span>Could not load notifications.</span></div>';
            }
        });
}

function renderNotificationList(updates) {
    const listEl = document.getElementById('notificationItemsList');
    if (!listEl) return;

    if (!updates || updates.length === 0) {
        listEl.innerHTML = `
            <div class="notification-empty-state">
                <i class="fa-solid fa-bell-slash" style="font-size: 24px; opacity: 0.5;"></i>
                <span>You are all caught up! No new feature alerts.</span>
            </div>
        `;
        return;
    }

    let html = '';
    updates.forEach(up => {
        const isBespoke = up.target_role !== 'all';
        const badgeClass = isBespoke ? 'notif-badge-bespoke' : 'notif-badge-general';
        const badgeLabel = up.badge_text || (isBespoke ? `Bespoke - ${up.target_role}` : 'General Update');
        const unreadClass = !up.is_read ? 'unread' : '';

        const hasTour = up.tour_steps && Array.isArray(up.tour_steps) && up.tour_steps.length > 0;

        html += `
            <div class="notification-item ${unreadClass}" id="notif-item-${up.id}">
                <div class="notification-item-top">
                    <span class="notif-badge ${badgeClass}">${badgeLabel}</span>
                    <span class="notif-time">${up.time_ago}</span>
                </div>
                <h4 class="notif-title">${up.title}</h4>
                <p class="notif-summary">${up.summary || ''}</p>
                <div class="notif-actions-row">
                    ${hasTour ? `
                        <button type="button" class="btn-notif-tour" onclick="triggerUpdateTour(${up.id})">
                            <i class="fa-solid fa-compass"></i>
                            <span>Take Feature Tour</span>
                        </button>
                    ` : ''}
                    ${!up.is_read ? `
                        <button type="button" class="btn-notif-read" onclick="markSingleNotificationRead(${up.id})">
                            Mark as read
                        </button>
                    ` : ''}
                </div>
            </div>
        `;
    });

    listEl.innerHTML = html;
}

function triggerUpdateTour(updateId) {
    const update = cachedPlatformUpdates.find(u => u.id === updateId);
    
    // Close notification dropdown
    const menu = document.getElementById('notificationMenuDropdown');
    if (menu) menu.classList.remove('show');

    // Mark as read
    markSingleNotificationRead(updateId);

    if (update && update.tour_steps && typeof window.startPlatformTour === 'function') {
        window.startPlatformTour(update.tour_steps, true);
    }
}

function markSingleNotificationRead(updateId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    fetch(`/accounts/platform-updates/${updateId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data && data.success) {
            const item = document.getElementById(`notif-item-${updateId}`);
            if (item) {
                item.classList.remove('unread');
                const readBtn = item.querySelector('.btn-notif-read');
                if (readBtn) readBtn.remove();
            }
            // Update cached
            const up = cachedPlatformUpdates.find(u => u.id === updateId);
            if (up) up.is_read = true;

            const unread = cachedPlatformUpdates.filter(u => !u.is_read).length;
            updateNotificationBellBadge(unread, cachedPlatformUpdates);
        }
    })
    .catch(() => {});
}

function markAllNotificationsAsRead(e) {
    e.stopPropagation();
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    fetch('/accounts/platform-updates/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data && data.success) {
            document.querySelectorAll('.notification-item').forEach(el => {
                el.classList.remove('unread');
                const btn = el.querySelector('.btn-notif-read');
                if (btn) btn.remove();
            });
            cachedPlatformUpdates.forEach(u => u.is_read = true);
            updateNotificationBellBadge(0, cachedPlatformUpdates);
        }
    })
    .catch(() => {});
}

function startFullTourFromMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('notificationMenuDropdown');
    if (menu) menu.classList.remove('show');

    if (typeof window.startPlatformTour === 'function') {
        window.startPlatformTour();
    }
}

// Global click outside to dismiss notification dropdown
document.addEventListener('click', function(e) {
    const container = document.getElementById('notificationDropdownContainer');
    const menu = document.getElementById('notificationMenuDropdown');
    if (menu && menu.classList.contains('show') && (!container || !container.contains(e.target))) {
        menu.classList.remove('show');
    }
});
</script>
