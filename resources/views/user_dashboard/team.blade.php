@extends('layouts.user')

@section('title', 'Team Workspace & Collaboration')

@section('styles')
<style>
    .team-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px 0 40px;
    }

    .team-hero-header {
        margin-bottom: 32px;
    }

    .team-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 100px;
        background: rgba(59, 130, 246, 0.12);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #60a5fa;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 14px;
    }

    .team-title {
        font-size: 30px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .team-subtitle {
        font-size: 14.5px;
        color: #94a3b8;
        max-width: 650px;
        line-height: 1.6;
        margin: 0;
    }

    /* Cards */
    .team-card {
        background: rgba(13, 20, 38, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        padding: 26px 30px;
        margin-bottom: 26px;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .team-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
        flex-wrap: wrap;
        gap: 14px;
    }

    .team-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    /* Progress bar */
    .seats-meter-wrap {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .progress-bar-bg {
        width: 100%;
        max-width: 320px;
        height: 10px;
        border-radius: 100px;
        background: rgba(255, 255, 255, 0.08);
        overflow: hidden;
        position: relative;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 100px;
        background: linear-gradient(90deg, #3b82f6 0%, #60a5fa 100%);
        transition: width 0.4s ease;
    }

    /* Table */
    .member-table {
        width: 100%;
        border-collapse: collapse;
    }

    .member-table th {
        text-align: left;
        padding: 12px 18px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .member-table td {
        padding: 16px 18px;
        font-size: 14px;
        color: #cbd5e1;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        vertical-align: middle;
    }

    .avatar-badge {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: #fff;
        flex-shrink: 0;
    }

    .btn-team-action {
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-team-danger {
        background: rgba(239, 68, 68, 0.12);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.28);
    }
    .btn-team-danger:hover {
        background: rgba(239, 68, 68, 0.22);
        color: #fca5a5;
    }

    .btn-team-secondary {
        background: rgba(59, 130, 246, 0.12);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.28);
    }
    .btn-team-secondary:hover {
        background: rgba(59, 130, 246, 0.22);
    }

    /* Icon-only Action Buttons */
    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13.5px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        padding: 0;
        background: transparent;
        text-decoration: none;
    }
    .btn-action-icon.btn-action-grant {
        background: rgba(59, 130, 246, 0.12);
        color: #60a5fa;
        border-color: rgba(59, 130, 246, 0.3);
    }
    .btn-action-icon.btn-action-grant:hover {
        background: rgba(59, 130, 246, 0.25);
        color: #93c5fd;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }
    .btn-action-icon.btn-action-revoke {
        background: rgba(245, 158, 11, 0.12);
        color: #fbbf24;
        border-color: rgba(245, 158, 11, 0.3);
    }
    .btn-action-icon.btn-action-revoke:hover {
        background: rgba(245, 158, 11, 0.25);
        color: #fde68a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
    }
    .btn-action-icon.btn-action-danger {
        background: rgba(239, 68, 68, 0.12);
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.28);
    }
    .btn-action-icon.btn-action-danger:hover {
        background: rgba(239, 68, 68, 0.25);
        color: #fca5a5;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }
</style>
@endsection

@section('content')
<div class="team-container">

    <!-- Flash Messages -->
    @if(session('status'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #34d399; font-size: 14px; font-weight: 600;">
            <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #fca5a5; font-size: 14px; font-weight: 600;">
            <i class="fa-solid fa-circle-exclamation" style="font-size: 18px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Hero Header -->
    <div class="team-hero-header">
        <div class="team-pill-badge">
            <i class="fa-solid fa-users"></i> Team Research Collaboration
        </div>
        <h1 class="team-title">Collaborative Workspace</h1>
        <p class="team-subtitle">
            Share legal research, bookmark acts and case laws, and collaborate on annotated document notes in real time with your team.
        </p>
    </div>

    @if(!$hasTeam)
        <!-- No Multi-Seat Team Active - Upgrade / Feature Showcase -->
        <div class="team-card" style="text-align: center; padding: 50px 30px; border-color: rgba(59, 130, 246, 0.25);">
            <div style="width: 72px; height: 72px; border-radius: 20px; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.3); display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 32px; margin: 0 auto 24px;">
                <i class="fa-solid fa-people-group"></i>
            </div>
            <h2 style="font-size: 24px; font-weight: 800; color: #fff; margin-bottom: 12px;">
                Unlock Multi-User Team Collaboration
            </h2>
            <p style="font-size: 15px; color: #94a3b8; max-width: 620px; margin: 0 auto 36px; line-height: 1.6;">
                Your current account is configured for solo access. Upgrade to <strong>Essential (3 Users)</strong> or <strong>Premium (5 Users)</strong> to invite researchers to share your subscription, collaborate on law bookmarks, and share document notes.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; max-width: 750px; margin: 0 auto 36px; text-align: left;">
                <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; padding: 22px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 18px; font-weight: 700; color: #fff;">Essential Plan</span>
                        <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">3 Users</span>
                    </div>
                    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 16px;">
                        Share your account with 2 other researchers. Unified library for team bookmarks and annotated document notes.
                    </p>
                    <a href="/subscription" class="btn-team-action btn-team-secondary" style="width: 100%; justify-content: center;">
                        View Essential Plan
                    </a>
                </div>

                <div style="background: rgba(59, 130, 246, 0.06); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 14px; padding: 22px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 18px; font-weight: 700; color: #fff;">Premium Plan</span>
                        <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">5 Users</span>
                    </div>
                    <p style="font-size: 13px; color: #94a3b8; margin-bottom: 16px;">
                        Up to 5 simultaneous researchers. Full collaborative suite, team document downloads, and priority support.
                    </p>
                    <a href="/subscription" class="btn-team-action btn-team-secondary" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #fff;">
                        View Premium Plan
                    </a>
                </div>
            </div>

            <a href="/subscription" style="display: inline-flex; align-items: center; gap: 8px; color: #60a5fa; font-size: 14.5px; font-weight: 700; text-decoration: none;">
                <span>Explore all subscription tiers</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    @else
        <!-- Active Team Workspace -->
        
        <!-- Seats & Status Banner -->
        <div class="team-card">
            <div class="seats-meter-wrap">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <span style="font-size: 18px; font-weight: 800; color: #fff;">
                            {{ $subscription->type ?? 'Team' }} Workspace
                        </span>
                        @if($isOwner)
                            <span style="background: rgba(59, 130, 246, 0.18); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                <i class="fa-solid fa-crown" style="font-size: 10px;"></i> Primary Owner
                            </span>
                        @else
                            <span style="background: rgba(16, 185, 129, 0.18); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                <i class="fa-solid fa-user-check" style="font-size: 10px;"></i> Collaborator
                            </span>
                        @endif
                    </div>
                    <div style="font-size: 13.5px; color: #94a3b8;">
                        @if($isOwner)
                            You manage this subscription. You can invite up to {{ $maxUsers - 1 }} additional team members.
                        @else
                            Managed by <strong>{{ $owner->name }} {{ $owner->lname }}</strong> ({{ $owner->email }}).
                        @endif
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px; min-width: 260px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700;">
                        <span style="color: #cbd5e1;">Seats Utilized</span>
                        <span style="color: #60a5fa;">{{ $usedSeats }} of {{ $maxUsers }} Seats</span>
                    </div>
                    @php
                        $percent = min(100, round(($usedSeats / max(1, $maxUsers)) * 100));
                    @endphp
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $percent }}%;"></div>
                    </div>
                    <div style="font-size: 11.5px; color: var(--text-secondary); text-align: right;">
                        @if($availableSeats > 0)
                            <span style="color: #34d399;"><i class="fa-solid fa-check"></i> {{ $availableSeats }} {{ $availableSeats === 1 ? 'seat' : 'seats' }} available</span>
                        @else
                            <span style="color: #fbbf24;"><i class="fa-solid fa-lock"></i> All seats occupied</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($isOwner && $availableSeats > 0)
                <!-- Invite Form -->
                <div style="background: rgba(59, 130, 246, 0.04); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 14px; padding: 22px; margin-top: 20px;">
                    <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin: 0 0 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-paper-plane" style="color: #60a5fa;"></i> Invite New Team Member
                    </h4>
                    <p style="font-size: 13px; color: #94a3b8; margin: 0 0 16px;">
                        Enter their email address. If they have an existing account, they will be instantly linked; otherwise, an invitation email with a secure join link will be dispatched.
                    </p>
                    <form action="{{ route('team.invite') }}" method="POST" style="display: flex; gap: 12px; flex-wrap: wrap;">
                        @csrf
                        <div style="flex: 1; min-width: 260px;">
                            <input type="email" name="email" required placeholder="colleague@example.com" style="width: 100%; padding: 11px 16px; background: rgba(13, 20, 38, 0.9); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; color: #fff; font-size: 14px; outline: none;">
                        </div>
                        <button type="submit" class="btn-team-action" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #fff; padding: 11px 22px; font-size: 14px;">
                            <i class="fa-solid fa-user-plus"></i> Send Invitation
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Team Members List -->
        <div class="team-card">
            <div class="team-card-header">
                <h3 class="team-card-title">
                    <i class="fa-solid fa-users-gear" style="color: #60a5fa;"></i> Team Members & Collaborators
                </h3>
                <span style="font-size: 12.5px; color: #94a3b8;">
                    {{ 1 + $acceptedMembers->count() }} Active Users &bull; {{ $pendingInvites->count() }} Pending
                </span>
            </div>

            <div style="overflow-x: auto;">
                <table class="member-table">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;">Researcher</th>
                            <th style="white-space: nowrap;">Workspace Role</th>
                            <th>Status</th>
                            @if($isOwner)
                                <th style="text-align: right; white-space: nowrap; width: 100px;">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Primary Owner Row -->
                        <tr>
                            <td style="white-space: nowrap;">
                                <div>
                                    <div style="font-weight: 700; color: #fff; font-size: 14.5px;">{{ $owner->name }} {{ $owner->lname }}</div>
                                    <div style="font-size: 12.5px; color: #94a3b8; margin-top: 2px;">{{ $owner->email }}</div>
                                </div>
                            </td>
                            <td style="white-space: nowrap;">
                                <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-crown" style="font-size: 10px;"></i> Team Owner
                                </span>
                            </td>
                            <td style="white-space: nowrap;">
                                <span style="color: #34d399; font-weight: 600; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981;"></span> Primary Subscriber
                                </span>
                            </td>
                            @if($isOwner)
                                <td style="text-align: right; color: #64748b; font-size: 13px;">-</td>
                            @endif
                        </tr>

                        <!-- Accepted Collaborators -->
                        @foreach($acceptedMembers as $member)
                            @php
                                $mUser = $member->member;
                                $name = $mUser ? trim($mUser->name . ' ' . $mUser->lname) : 'Team Member';
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;">
                                    <div>
                                        <div style="font-weight: 700; color: #fff; font-size: 14.5px;">{{ $name }}</div>
                                        <div style="font-size: 12.5px; color: #94a3b8; margin-top: 2px;">{{ $member->email }}</div>
                                    </div>
                                </td>
                                <td style="white-space: nowrap;">
                                    <div style="display: flex; flex-direction: column; gap: 5px; align-items: flex-start;">
                                        <span style="background: rgba(16, 185, 129, 0.14); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 700;">
                                            Collaborator
                                        </span>
                                        @if($member->can_manage_billing)
                                            <span style="background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.25); font-size: 10.5px; padding: 2px 7px; border-radius: 5px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;" title="This collaborator has permission to purchase/modify subscriptions">
                                                <i class="fa-solid fa-credit-card"></i> Billing Permitted
                                            </span>
                                        @else
                                            <span style="background: rgba(148, 163, 184, 0.1); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); font-size: 10.5px; padding: 2px 7px; border-radius: 5px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;" title="This collaborator cannot purchase subscriptions without Account Holder approval">
                                                <i class="fa-solid fa-lock"></i> Billing Restricted
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 8px;">
                                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                            <span style="color: #34d399; font-weight: 600; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px;">
                                                <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981;"></span> Active
                                            </span>
                                            @if($isOwner && $member->billing_request_status === 'pending' && $member->requestedPlan)
                                                <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                                    <i class="fa-solid fa-bell"></i> Requested: {{ $member->requestedPlan->type }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($isOwner && $member->billing_request_status === 'pending' && $member->requestedPlan)
                                            <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); border-left: 3px solid #fbbf24; border-radius: 6px; padding: 8px 12px; max-width: 320px;">
                                                @if($member->billing_request_note)
                                                    <div style="font-size: 11px; color: #cbd5e1; font-style: italic; line-height: 1.4; margin-bottom: 8px;">
                                                        "{{ $member->billing_request_note }}"
                                                    </div>
                                                @endif
                                                <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                                                    <form action="{{ route('team.member.respond_billing_request', $member->id) }}" method="POST" style="display: inline; margin: 0;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="grant_and_approve">
                                                        <button type="submit" class="btn-team-action" style="padding: 3px 8px; font-size: 10.5px; background: rgba(16, 185, 129, 0.18); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 6px;" title="Grant billing permission and approve upgrade">
                                                            <i class="fa-solid fa-check"></i> Grant Permission
                                                        </button>
                                                    </form>
                                                    <a href="/subscription" class="btn-team-action" style="padding: 3px 8px; font-size: 10.5px; background: rgba(59, 130, 246, 0.18); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); border-radius: 6px; text-decoration: none;" title="Upgrade workspace subscription">
                                                        Upgrade Plan
                                                    </a>
                                                    <form action="{{ route('team.member.respond_billing_request', $member->id) }}" method="POST" style="display: inline; margin: 0;">
                                                        @csrf
                                                        <input type="hidden" name="action" value="dismiss">
                                                        <button type="submit" class="btn-team-action" style="padding: 3px 8px; font-size: 10.5px; background: rgba(255, 255, 255, 0.05); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 6px;" title="Dismiss request">
                                                            Dismiss
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                @if($isOwner)
                                    <td style="text-align: right; white-space: nowrap;">
                                        <div style="display: flex; gap: 8px; align-items: center; justify-content: flex-end;">
                                            <form action="{{ route('team.member.toggle_billing', $member->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn-action-icon {{ $member->can_manage_billing ? 'btn-action-revoke' : 'btn-action-grant' }}" title="{{ $member->can_manage_billing ? 'Revoke Billing Permission' : 'Grant Billing Permission' }}">
                                                    <i class="fa-solid {{ $member->can_manage_billing ? 'fa-lock' : 'fa-key' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('team.member.remove', $member->id) }}" method="POST" onsubmit="return confirm('Remove {{ $member->email }} from the team? They will lose access to shared notes and platform features.')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-icon btn-action-danger" title="Remove {{ $name }} from team">
                                                    <i class="fa-solid fa-user-minus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        <!-- Pending Invites -->
                        @foreach($pendingInvites as $invite)
                            <tr style="opacity: 0.85;">
                                <td style="white-space: nowrap;">
                                    <div>
                                        <div style="font-weight: 600; color: #cbd5e1; font-size: 14px;">Pending Invite</div>
                                        <div style="font-size: 12.5px; color: #94a3b8; margin-top: 2px;">{{ $invite->email }}</div>
                                    </div>
                                </td>
                                <td style="white-space: nowrap;">
                                    <span style="background: rgba(245, 158, 11, 0.14); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 3px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 700;">
                                        Invitee
                                    </span>
                                </td>
                                <td>
                                    <span style="color: #fbbf24; font-weight: 600; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-clock" style="font-size: 10px;"></i> Awaiting Acceptance
                                    </span>
                                </td>
                                @if($isOwner)
                                    <td style="text-align: right; white-space: nowrap;">
                                        <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                            <form action="{{ route('team.invite.resend', $invite->id) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="btn-action-icon btn-action-grant" title="Resend invitation email to {{ $invite->email }}">
                                                    <i class="fa-solid fa-rotate-right"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('team.member.remove', $invite->id) }}" method="POST" onsubmit="return confirm('Cancel invitation for {{ $invite->email }}?')" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action-icon btn-action-danger" title="Cancel invitation for {{ $invite->email }}">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shared Team Research Activity Log -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
            <!-- Recent Shared Notes -->
            <div class="team-card">
                <div class="team-card-header">
                    <h3 class="team-card-title">
                        <i class="fa-solid fa-pen-to-square" style="color: #60a5fa;"></i> Recent Team Notes
                    </h3>
                    <a href="/accounts/notes/{{ auth()->id() }}" style="font-size: 12.5px; color: #60a5fa; text-decoration: none; font-weight: 600;">
                        View All Notes &rarr;
                    </a>
                </div>

                @if($recentNotes->isEmpty())
                    <p style="font-size: 13.5px; color: #94a3b8; margin: 0; text-align: center; padding: 24px 0;">
                        No team notes created yet. When any team member annotates laws, they will appear here.
                    </p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($recentNotes as $n)
                            @php
                                $author = $n->user ? trim($n->user->name . ' ' . $n->user->lname) : 'Researcher';
                                $isMe = $n->user_id === auth()->id();
                            @endphp
                            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 14px 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                                    <span style="font-size: 12px; font-weight: 700; color: {{ $isMe ? '#60a5fa' : '#34d399' }};">
                                        {{ $isMe ? 'You' : $author }}
                                    </span>
                                    <span style="font-size: 11px; color: #64748b;">{{ $n->created_at->diffForHumans() }}</span>
                                </div>
                                <div style="font-size: 13px; font-weight: 600; color: #fff; margin-bottom: 4px;">
                                    {{ $n->document_title }} &bull; {{ $n->article_section }}
                                </div>
                                <div style="font-size: 12.5px; color: #cbd5e1; line-height: 1.5;">
                                    "{{ Str::limit($n->note_content, 110) }}"
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Shared Bookmarks -->
            <div class="team-card">
                <div class="team-card-header">
                    <h3 class="team-card-title">
                        <i class="fa-solid fa-bookmark" style="color: #10b981;"></i> Recent Team Bookmarks
                    </h3>
                    <a href="/accounts/bookmarks/{{ auth()->id() }}" style="font-size: 12.5px; color: #10b981; text-decoration: none; font-weight: 600;">
                        View All Bookmarks &rarr;
                    </a>
                </div>

                @if($recentBookmarks->isEmpty())
                    <p style="font-size: 13.5px; color: #94a3b8; margin: 0; text-align: center; padding: 24px 0;">
                        No team bookmarks saved yet. Bookmarks saved by team members sync here automatically.
                    </p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($recentBookmarks as $b)
                            @php
                                $bAuthor = $b->user ? trim($b->user->name . ' ' . $b->user->lname) : 'Researcher';
                                $isMe = $b->user_id === auth()->id();
                            @endphp
                            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 14px 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 6px;">
                                    <span style="font-size: 12px; font-weight: 700; color: {{ $isMe ? '#60a5fa' : '#34d399' }};">
                                        {{ $isMe ? 'You' : $bAuthor }}
                                    </span>
                                    <span style="font-size: 11px; color: #64748b;">{{ $b->created_at->diffForHumans() }}</span>
                                </div>
                                <div style="font-size: 13.5px; font-weight: 700; color: #fff; margin-bottom: 2px;">
                                    {{ $b->act_title }}
                                </div>
                                <div style="font-size: 12px; color: #94a3b8;">
                                    Section: {{ $b->act_section }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    @endif

</div>
@endsection
