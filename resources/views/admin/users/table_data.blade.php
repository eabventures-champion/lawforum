<table class="custom-table">
    <thead>
        <tr>
            <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-users" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;"></th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Subscription Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td style="text-align: center; vertical-align: middle;">
                    @if(!$user->isAdmin() && $user->id !== auth()->id())
                        <input type="checkbox" class="user-checkbox" value="{{ $user->id }}" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;">
                    @else
                        <i class="fa-solid fa-user-shield" title="Admin Account Protected" style="opacity: 0.6; color: #60a5fa;"></i>
                    @endif
                </td>
                <td>{{ $user->name }} {{ $user->lname }}</td>
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
                    @if($user->isAdmin())
                        <span class="badge badge-accent">Admin</span>
                    @elseif($user->user_type === 'student')
                        <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">
                            <i class="fa-solid fa-graduation-cap mr-1"></i> Student
                        </span>
                    @elseif($user->user_type === 'lawyer')
                        <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="fa-solid fa-gavel mr-1"></i> Lawyer
                        </span>
                    @elseif($user->user_type === 'researcher')
                        <span class="badge" style="background: rgba(139, 92, 246, 0.15); color: #c084fc; border: 1px solid rgba(139, 92, 246, 0.3);">
                            <i class="fa-solid fa-microscope mr-1"></i> Researcher
                        </span>
                    @else
                        <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25);">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i> Legacy (No Role)
                        </span>
                    @endif
                </td>
                <td>
                    @if($user->check_subscription && $user->subscription_expiry >= \Carbon\Carbon::today())
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <span class="badge badge-success" style="width: fit-content;">Active</span>
                            <small style="font-size: 11px; color: var(--text-secondary);">Expires: {{ \Carbon\Carbon::parse($user->subscription_expiry)->format('M d, Y') }}</small>
                        </div>
                    @else
                        <span class="badge badge-danger">Inactive</span>
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
        @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 32px;">No users found.</td>
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
