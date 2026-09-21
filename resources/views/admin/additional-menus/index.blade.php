@extends('layouts.admin')

@section('title', 'Additional Menus Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Additional Navigation Menus</h1>
        <p class="page-subtitle">Manage visibility and configuration for the special Additional Menus (Chatroom, Marketplace, Jobs) displayed next to the Constitution menu.</p>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-color); color: var(--success-color); padding: 16px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<form action="{{ route('admin.additional-menus.update') }}" method="POST">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
        <!-- Card 1: Top-Level Additional Menus -->
        <div class="card-table" style="padding: 24px; border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                <i class="fa-solid fa-layer-group" style="color: var(--primary-color); font-size: 18px;"></i>
                <h2 style="font-size: 17px; font-weight: 700; color: #fff; margin: 0;">Top-Level Menu Visibility</h2>
            </div>
            
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">
                These menus appear on the header navbar directly following the Constitution menu for guest and authenticated users.
            </p>

            <div style="display: flex; flex-direction: column; gap: 18px;">
                <!-- Chatroom Master Toggle -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #fff;">
                            <i class="fa-solid fa-comments" style="color: #3b82f6;"></i> Chatroom Menu
                        </span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Shows the Chatroom dropdown menu on the navbar.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="chatroom_enabled" value="1" {{ $settings['chatroom_enabled'] ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Marketplace Toggle -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #fff;">
                            <i class="fa-solid fa-store" style="color: #10b981;"></i> Marketplace Menu
                        </span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Shows the Legal Marketplace link on the navbar.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="marketplace_enabled" value="1" {{ $settings['marketplace_enabled'] ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Jobs Toggle -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #fff;">
                            <i class="fa-solid fa-briefcase" style="color: #f59e0b;"></i> Jobs Menu
                        </span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Shows the Legal Jobs Board link on the navbar.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="jobs_enabled" value="1" {{ $settings['jobs_enabled'] ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Researcher Nav Bar Visibility Toggle -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="display: flex; align-items: center; gap: 8px; font-weight: 600; color: #fff;">
                            <i class="fa-solid fa-microscope" style="color: #8b5cf6;"></i> Show on Nav Bar for Researchers
                        </span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Allow researcher accounts to see Chatroom, Marketplace, and Jobs on the top navbar (Off by default).</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="navbar_researcher_enabled" value="1" {{ !empty($settings['navbar_researcher_enabled']) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Card 2: Chatroom Subcategories -->
        <div class="card-table" style="padding: 24px; border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                <i class="fa-solid fa-list-check" style="color: #8b5cf6; font-size: 18px;"></i>
                <h2 style="font-size: 17px; font-weight: 700; color: #fff; margin: 0;">Chatroom Dropdown Categories</h2>
            </div>
            
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">
                Control which specific community rooms appear under the Chatroom dropdown menu.
            </p>

            <div style="display: flex; flex-direction: column; gap: 18px;">
                <!-- General Chatroom -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="font-weight: 600; color: #fff;">General Room</span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Open public legal discussion for all visitors.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="chatroom_general_enabled" value="1" {{ $settings['chatroom_general_enabled'] ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Student Chatroom -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="font-weight: 600; color: #fff;">Student Room</span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Tailored for law student academics and study rooms.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="chatroom_student_enabled" value="1" {{ $settings['chatroom_student_enabled'] ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Lawyer Chatroom -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="font-weight: 600; color: #fff;">Lawyer Room</span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Peer-to-peer discussion for practicing attorneys.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="chatroom_lawyer_enabled" value="1" {{ $settings['chatroom_lawyer_enabled'] ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <!-- Researcher Chatroom -->
                <div class="setting-switch-wrapper" style="display: flex; align-items: center; justify-content: space-between; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                    <div>
                        <span class="switch-label" style="font-weight: 600; color: #fff;">Researcher Room</span>
                        <small class="switch-desc" style="color: var(--text-secondary); font-size: 12px;">Legal research, case analysis, and judicial inquiries.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="chatroom_researcher_enabled" value="1" {{ $settings['chatroom_researcher_enabled'] ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 32px; display: flex; justify-content: flex-end;">
        <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 15px; font-weight: 600;">
            <i class="fa-solid fa-floppy-disk mr-2"></i> Save Menu Settings
        </button>
    </div>
</form>

<!-- Chatroom Discussions Moderation Table -->
<div class="card-table">
    <div class="table-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 class="table-title">Community Chatrooms & Threads</h2>
            <p style="color: var(--text-secondary); font-size: 13px; margin: 4px 0 0 0;">Manage created rooms, toggle premium status, pin priority discussions, or moderate topics.</p>
        </div>
        <a href="{{ route('chatroom.index') }}" target="_blank" class="btn btn-secondary" style="font-size: 13px;">
            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> View Live Chatroom
        </a>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>Title / Discussion</th>
                <th>Category</th>
                <th>Author</th>
                <th>Replies</th>
                <th>Status</th>
                <th style="width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($chatrooms as $room)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: #fff; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                            @if($room->is_pinned)
                                <span title="Pinned Topic" style="color: #f59e0b;"><i class="fa-solid fa-thumbtack"></i></span>
                            @endif
                            <a href="{{ route('chatroom.show', [$room->category, $room->slug]) }}" target="_blank" style="color: inherit; text-decoration: none;">
                                {{ $room->title }}
                            </a>
                        </div>
                        <small style="color: var(--text-secondary); font-size: 12px;">{{ Str::limit($room->description, 70) }}</small>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); padding: 4px 10px; border-radius: 100px; font-size: 12px; font-weight: 600;">
                            {{ $room->category_label }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size: 13.5px; font-weight: 700; color: #fff;">{{ $room->author_name }}</div>
                        @if(!$room->user_id && ($room->guest_email || $room->guest_contact))
                            <div style="margin-top: 5px; display: inline-flex; flex-direction: column; gap: 3px; background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.2); padding: 6px 10px; border-radius: 8px;">
                                <span style="color: #60a5fa; font-size: 10.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-user-tag"></i> Guest Contributor
                                </span>
                                @if($room->guest_email)
                                    <a href="mailto:{{ $room->guest_email }}" style="color: #cbd5e1; font-size: 11px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-envelope" style="color: #94a3b8; font-size: 10px;"></i> {{ $room->guest_email }}
                                    </a>
                                @endif
                                @if($room->guest_contact)
                                    <a href="tel:{{ $room->guest_contact }}" style="color: #10b981; font-size: 11px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-phone" style="font-size: 10px;"></i> {{ $room->guest_contact }}
                                    </a>
                                @endif
                            </div>
                        @else
                            <small style="color: var(--text-secondary); font-size: 11px;">{{ $room->author_role }}</small>
                        @endif
                    </td>
                    <td>
                        <span style="font-weight: 700; color: #fff;">{{ $room->messages_count }}</span>
                    </td>
                    <td>
                        @if($room->is_premium)
                            <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); padding: 4px 10px; border-radius: 100px; font-size: 11px; font-weight: 700;">
                                <i class="fa-solid fa-crown mr-1"></i> Premium
                            </span>
                        @else
                            <span class="badge" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 4px 10px; border-radius: 100px; font-size: 11px;">
                                Standard
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <!-- Toggle Pin -->
                            <form action="{{ route('admin.additional-menus.chatroom.pin', $room->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary" style="padding: 6px 10px; font-size: 11px;" title="{{ $room->is_pinned ? 'Unpin' : 'Pin' }}">
                                    <i class="fa-solid fa-thumbtack {{ $room->is_pinned ? 'text-warning' : '' }}"></i>
                                </button>
                            </form>

                            <!-- Toggle Premium -->
                            <form action="{{ route('admin.additional-menus.chatroom.premium', $room->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary" style="padding: 6px 10px; font-size: 11px;" title="Toggle Premium Status">
                                    <i class="fa-solid fa-crown {{ $room->is_premium ? 'text-warning' : '' }}"></i>
                                </button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('admin.additional-menus.chatroom.destroy', $room->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this chatroom?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 11px;" title="Delete Chatroom">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 32px; color: var(--text-secondary);">
                        No community chatrooms created yet. Students, lawyers, and researchers can create discussions from their dashboard.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($chatrooms->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--border-color);">
            {{ $chatrooms->links() }}
        </div>
    @endif
</div>
@endsection
