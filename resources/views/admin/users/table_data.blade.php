<table class="custom-table">
    <thead>
        <tr>
            <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-users" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;"></th>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Role</th>
            <th>Subscription Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td style="text-align: center; vertical-align: middle;">
                    @if($user->id !== auth()->id())
                        <input type="checkbox" class="user-checkbox" value="{{ $user->id }}" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;">
                    @else
                        <i class="fa-solid fa-user-shield" title="Current Admin" style="opacity: 0.5;"></i>
                    @endif
                </td>
                <td>{{ $user->name }} {{ $user->lname }}</td>
                <td>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <span style="font-weight: 500;">{{ $user->email }}</span>
                        @if($user->phone && $user->phone !== 'N/A')
                            <span class="badge" style="width: fit-content; font-size: 11px; padding: 2px 8px; background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid var(--border-color); border-radius: 4px;">
                                <i class="fa-solid fa-phone" style="font-size: 9px; margin-right: 4px; opacity: 0.7;"></i>{{ $user->phone }}
                            </span>
                        @endif
                    </div>
                </td>
                <td>{{ $user->country ?? 'N/A' }}</td>
                <td>
                    @if($user->isAdmin())
                        <span class="badge badge-accent">Admin</span>
                    @else
                        <span class="badge badge-secondary" style="background: rgba(255,255,255,0.05); color: var(--text-secondary);">User</span>
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
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12px;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-action" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 32px;">No users found.</td>
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
