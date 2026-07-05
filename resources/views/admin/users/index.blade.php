@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Users Management</h1>
        <p class="page-subtitle">Manage system users, privileges, and subscription statuses.</p>
    </div>
</div>

<div class="card-table">
    <div class="table-header" style="flex-wrap: wrap; gap: 16px;">
        <h2 class="table-title">System Users</h2>
        
        <!-- Search Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}" style="width: 260px; padding: 8px 16px;">
            <button type="submit" class="btn btn-primary btn-action" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-action" style="padding: 8px 16px;">Clear</a>
            @endif
        </form>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>Role</th>
                <th>Subscription Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }} {{ $user->lname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
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
                @if($users->onFirstPage())
                    <button class="btn btn-secondary btn-action" disabled>Previous</button>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="btn btn-secondary btn-action">Previous</a>
                @endif

                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="btn btn-secondary btn-action">Next</a>
                @else
                    <button class="btn btn-secondary btn-action" disabled>Next</button>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
