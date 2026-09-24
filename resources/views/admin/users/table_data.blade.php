<table class="custom-table">
    <thead>
        <tr>
            <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-users" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;"></th>
            <th>Name</th>
            <th>Email</th>
            <th>Subscription Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            @php
                $isTeamOwner = $user->isTeamOwner();
                $isTeamMember = $user->isTeamMember();
                $teamOwner = $isTeamMember ? $user->getTeamOwner() : null;
                $acceptedMembers = $isTeamOwner ? $user->teamMembers->where('status', 'accepted') : collect();
                $hasCollaborators = $isTeamOwner && $acceptedMembers->count() > 0;
            @endphp
            <tr class="{{ $isTeamMember ? 'is-collaborator-row' : '' }}">
                <td style="text-align: center; vertical-align: middle;">
                    @if(!$user->isAdmin() && $user->id !== auth()->id())
                        <input type="checkbox" class="user-checkbox" value="{{ $user->id }}" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;">
                    @else
                        <i class="fa-solid fa-user-shield" title="Admin Account Protected" style="opacity: 0.6; color: #60a5fa;"></i>
                    @endif
                </td>
                <td>
                    <div style="font-weight: 600; color: #fff; font-size: 14px; margin-bottom: 4px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                        <span>{{ $user->name }} {{ $user->lname }}</span>

                        @if($isTeamOwner)
                            <span class="badge" style="font-size: 10.5px; padding: 2px 7px; border-radius: 4px; background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); display: inline-flex; align-items: center; gap: 4px; font-weight: 600;" title="Primary Subscriber / Team Account Holder">
                                <i class="fa-solid fa-crown" style="font-size: 9.5px;"></i> Account Holder
                            </span>
                            @if($hasCollaborators)
                                <button type="button" class="btn-toggle-team-drawer" onclick="toggleTeamDrawer({{ $user->id }})" title="Toggle collaborators list under {{ $user->name }}" style="background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 10.5px; font-weight: 600; padding: 2px 8px; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-users" style="font-size: 9.5px;"></i>
                                    <span>{{ $acceptedMembers->count() }} Collaborator{{ $acceptedMembers->count() === 1 ? '' : 's' }}</span>
                                    <i class="fa-solid fa-chevron-down" id="chevron-drawer-{{ $user->id }}" style="font-size: 8.5px; transition: transform 0.2s;"></i>
                                </button>
                            @endif
                        @elseif($isTeamMember && $teamOwner)
                            <span class="badge" style="font-size: 10.5px; padding: 2px 7px; border-radius: 4px; background: rgba(56, 189, 248, 0.12); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); display: inline-flex; align-items: center; gap: 4px; font-weight: 600;" title="Collaborator on {{ $teamOwner->name }}'s Team Subscription">
                                <i class="fa-solid fa-user-group" style="font-size: 9.5px;"></i> Collaborator
                            </span>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        @if($user->isAdmin())
                            <span class="badge badge-accent" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-shield-halved" style="font-size: 10px;"></i> Admin
                            </span>
                        @elseif($user->user_type === 'student')
                            <span class="badge" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-graduation-cap" style="font-size: 10px;"></i> Student
                            </span>
                        @elseif($user->user_type === 'lawyer')
                            <span class="badge" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-gavel" style="font-size: 10px;"></i> Lawyer
                            </span>
                        @elseif($user->user_type === 'researcher')
                            <span class="badge" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; background: rgba(139, 92, 246, 0.15); color: #c084fc; border: 1px solid rgba(139, 92, 246, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-microscope" style="font-size: 10px;"></i> Researcher
                            </span>
                        @else
                            <span class="badge" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-triangle-exclamation" style="font-size: 10px;"></i> Legacy (No Role)
                            </span>
                        @endif

                        @php
                            $demo = $user->getDemoDurationInfo();
                        @endphp
                        @if($demo)
                            @if($demo['is_active'])
                                <span class="badge" title="Demo Active: {{ $demo['days_done'] }} of {{ $demo['total_days'] }} days completed ({{ $demo['remaining'] }} day(s) remaining){{ $demo['extended'] ? ' [Extension Granted]' : '' }}" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                                    <i class="fa-regular fa-clock" style="font-size: 10px;"></i> Demo: {{ $demo['days_done'] }}/{{ $demo['total_days'] }} days
                                </span>
                            @elseif($demo['is_expired'])
                                <span class="badge" title="Demo Expired: Completed {{ $demo['days_done'] }} of {{ $demo['total_days'] }} total days{{ $demo['extended'] ? ' (including extension)' : '' }}" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                                    <i class="fa-solid fa-hourglass-end" style="font-size: 10px;"></i> Demo: {{ $demo['days_done'] }}/{{ $demo['total_days'] }} days (Expired)
                                </span>
                            @else
                                <span class="badge" title="Demo not started (Total allowance: {{ $demo['total_days'] }} days)" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; background: rgba(148, 163, 184, 0.1); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.2); display: inline-flex; align-items: center; gap: 4px; font-weight: 500;">
                                    <i class="fa-regular fa-clock" style="font-size: 10px;"></i> Demo: 0/{{ $demo['total_days'] }} days
                                </span>
                            @endif
                        @endif
                    </div>

                    @if($isTeamMember && $teamOwner)
                        <div class="collaborator-hierarchy-tag">
                            <i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>
                            <span>Under Account Holder: <a href="{{ route('admin.users.index', ['search' => $teamOwner->email]) }}" title="Filter and view {{ $teamOwner->name }} ({{ $teamOwner->email }})">{{ $teamOwner->name }} {{ $teamOwner->lname }}</a></span>
                        </div>
                    @endif
                </td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 6px;">
                        <span style="font-weight: 500;">{{ $user->email }}</span>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                            @if($user->phone && $user->phone !== 'N/A')
                                <span class="badge" style="width: fit-content; font-size: 11px; padding: 2px 8px; background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--border-color); border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-phone" style="font-size: 9px; opacity: 0.7;"></i>{{ $user->phone }}
                                </span>
                            @endif
                            <span class="badge" style="width: fit-content; font-size: 11px; padding: 2px 8px; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-globe" style="font-size: 9px;"></i>{{ $user->country ?? 'Ghana' }}
                            </span>
                            @if($user->hasVerifiedEmail())
                                <span style="font-size: 11px; color: #34d399; display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                                    <i class="fa-solid fa-circle-check"></i> Confirmed
                                </span>
                            @else
                                <span style="font-size: 11px; color: #fbbf24; display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                                    <i class="fa-solid fa-clock"></i> Unconfirmed (Guest)
                                </span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    @php
                        $subPlan = $user->getSubscriptionPlan();
                        $planName = $subPlan ? $subPlan->type : null;
                        $isActive = ($user->check_subscription && $user->subscription_expiry >= \Carbon\Carbon::today()) || $user->hasActiveSubscription();
                        
                        // Plan badge styling
                        $planBadgeStyle = 'background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);';
                        $crownColor = '#60a5fa';
                        if ($planName) {
                            $lowerPlan = strtolower($planName);
                            if (strpos($lowerPlan, 'starter') !== false) {
                                $planBadgeStyle = 'background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);';
                                $crownColor = '#10b981';
                            } elseif (strpos($lowerPlan, 'essential') !== false) {
                                $planBadgeStyle = 'background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35);';
                                $crownColor = '#38bdf8';
                            } elseif (strpos($lowerPlan, 'premium') !== false) {
                                $planBadgeStyle = 'background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35);';
                                $crownColor = '#c084fc';
                            } elseif (strpos($lowerPlan, 'unlimited') !== false) {
                                $planBadgeStyle = 'background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35);';
                                $crownColor = '#fbbf24';
                            }
                        }
                    @endphp

                    @if($isActive)
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                <span class="badge badge-success" style="width: fit-content;">Active</span>
                                @if($planName)
                                    <span class="badge" style="font-size: 11px; padding: 2px 8px; border-radius: 4px; {{ $planBadgeStyle }} display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
                                        <i class="fa-solid fa-crown" style="font-size: 10px; color: {{ $crownColor }};"></i> {{ $planName }}
                                    </span>
                                @endif
                            </div>

                            @if($isTeamMember && $teamOwner)
                                <div style="font-size: 11px; color: var(--text-secondary); line-height: 1.35; margin-top: 2px;">
                                    <div style="color: #38bdf8; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-user-group" style="font-size: 9.5px;"></i> Team Seat (via {{ $teamOwner->name }})
                                    </div>
                                    @if($teamOwner->subscription_expiry)
                                        <div style="color: #64748b;">Expires: {{ \Carbon\Carbon::parse($teamOwner->subscription_expiry)->format('M d, Y') }}</div>
                                    @endif
                                </div>
                            @elseif($isTeamOwner)
                                @php
                                    $maxSeats = $subPlan ? (int) $subPlan->max_users : 1;
                                    $usedSeats = $acceptedMembers->count() + 1;
                                @endphp
                                <div style="font-size: 11px; color: var(--text-secondary); line-height: 1.35; margin-top: 2px;">
                                    <div style="color: #fbbf24; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-crown" style="font-size: 9.5px;"></i> Primary Account ({{ $usedSeats }}/{{ $maxSeats }} Seats)
                                    </div>
                                    @if($user->subscription_expiry)
                                        <div style="color: #64748b;">Expires: {{ \Carbon\Carbon::parse($user->subscription_expiry)->format('M d, Y') }}</div>
                                    @endif
                                </div>
                            @else
                                @if($user->subscription_expiry)
                                    <small style="font-size: 11px; color: var(--text-secondary);">Expires: {{ \Carbon\Carbon::parse($user->subscription_expiry)->format('M d, Y') }}</small>
                                @endif
                            @endif
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                <span class="badge badge-danger">Inactive</span>
                                @if($planName)
                                    <span class="badge" title="Past Plan: {{ $planName }}" style="font-size: 11px; padding: 2px 7px; border-radius: 4px; background: rgba(255, 255, 255, 0.05); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.1); display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fa-solid fa-crown" style="font-size: 9px; opacity: 0.6;"></i> {{ $planName }}
                                    </span>
                                @endif
                            </div>
                            @if($user->subscription_expiry)
                                <small style="font-size: 11px; color: #94a3b8;">Expired: {{ \Carbon\Carbon::parse($user->subscription_expiry)->format('M d, Y') }}</small>
                            @endif
                        </div>
                    @endif
                </td>
                <td>
                    <div class="user-action-dropdown">
                        <button type="button" class="btn-action-dropdown-toggle" onclick="toggleUserActionDropdown(this, event)">
                            <span>Actions</span>
                            <i class="fa-solid fa-chevron-down toggle-icon"></i>
                        </button>
                        <div class="user-action-dropdown-menu">
                            @if(!$user->isAdmin() && $user->id !== auth()->id())
                                <form action="{{ route('admin.users.impersonate', $user->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="action-dropdown-item impersonate-item">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        <span>Impersonate</span>
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="action-dropdown-item edit-item">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>

                            @if(!$user->isAdmin() && $user->id !== auth()->id())
                                <div class="action-dropdown-divider"></div>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-dropdown-item delete-item">
                                        <i class="fa-solid fa-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            @if($isTeamOwner && $hasCollaborators)
                <tr id="team-drawer-{{ $user->id }}" class="team-drawer-row" style="display: none; background: rgba(15, 23, 42, 0.85);">
                    <td colspan="5" style="padding: 12px 20px 16px 52px; border-top: 1px dashed rgba(245, 158, 11, 0.25); border-bottom: 2px solid rgba(245, 158, 11, 0.3);">
                        <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); border-left: 3px solid #fbbf24; border-radius: 8px; padding: 12px 16px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px;">
                                <span style="font-size: 12px; font-weight: 700; color: #fbbf24; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-users-viewfinder"></i> Collaborators Under {{ $user->name }} {{ $user->lname }} ({{ $acceptedMembers->count() }})
                                </span>
                                @php
                                    $maxSeats = $subPlan ? (int) $subPlan->max_users : 1;
                                    $usedSeats = $acceptedMembers->count() + 1;
                                @endphp
                                <span style="font-size: 11.5px; color: #94a3b8;">
                                    Account Plan: <strong style="color: #fff;">{{ $planName ?? 'Team' }}</strong> ({{ $usedSeats }} of {{ $maxSeats }} seats utilized)
                                </span>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 10px;">
                                @foreach($acceptedMembers as $tm)
                                    @php
                                        $memberUser = $tm->member;
                                    @endphp
                                    @if($memberUser)
                                        <div style="background: rgba(18, 24, 38, 0.95); border: 1px solid rgba(56, 189, 248, 0.25); border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                                            <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                                                <div style="width: 34px; height: 34px; border-radius: 50%; background: rgba(56, 189, 248, 0.15); color: #38bdf8; font-weight: 700; font-size: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(56, 189, 248, 0.35);">
                                                    {{ strtoupper(substr($memberUser->name, 0, 1) . substr($memberUser->lname, 0, 1)) }}
                                                </div>
                                                <div style="min-width: 0;">
                                                    <div style="font-size: 13.5px; font-weight: 600; color: #f1f5f9; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $memberUser->name }} {{ $memberUser->lname }}
                                                    </div>
                                                    <div style="font-size: 11.5px; color: #94a3b8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $memberUser->email }}
                                                    </div>
                                                    @if($memberUser->phone && $memberUser->phone !== 'N/A')
                                                        <div style="font-size: 11px; color: #64748b; margin-top: 1px;">
                                                            <i class="fa-solid fa-phone" style="font-size: 9.5px;"></i> {{ $memberUser->phone }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                                <a href="{{ route('admin.users.edit', $memberUser->id) }}" class="btn btn-secondary btn-action" style="padding: 4px 9px; font-size: 11.5px; height: 28px; border-radius: 6px;" title="Edit Collaborator">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('admin.users.impersonate', $memberUser->id) }}" method="POST" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary btn-action" style="padding: 4px 9px; font-size: 11.5px; height: 28px; border-radius: 6px; color: #60a5fa;" title="Impersonate Collaborator">
                                                        <i class="fa-solid fa-right-to-bracket"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 32px;">No users found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($users->hasPages())
    <div class="pagination-wrapper">
        <div style="color: var(--text-secondary); font-size: 14px;">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
        </div>
        <div style="display: flex; gap: 8px;">
            <!-- First Page -->
            @if($users->onFirstPage())
                <button class="btn btn-secondary btn-action" disabled>First</button>
            @else
                <a href="{{ $users->url(1) }}" class="btn btn-secondary btn-action">First</a>
            @endif

            <!-- Previous Page -->
            @if($users->onFirstPage())
                <button class="btn btn-secondary btn-action" disabled>Previous</button>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="btn btn-secondary btn-action">Previous</a>
            @endif

            <!-- Next Page -->
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="btn btn-secondary btn-action">Next</a>
            @else
                <button class="btn btn-secondary btn-action" disabled>Next</button>
            @endif

            <!-- Last Page -->
            @if($users->hasMorePages())
                <a href="{{ $users->url($users->lastPage()) }}" class="btn btn-secondary btn-action">Last</a>
            @else
                <button class="btn btn-secondary btn-action" disabled>Last</button>
            @endif
        </div>
    </div>
@endif
