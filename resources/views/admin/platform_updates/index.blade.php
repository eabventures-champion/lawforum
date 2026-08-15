@extends('layouts.admin')

@section('title', 'Platform Updates & Tours')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Platform Feature Updates & Walkthrough Tours</h1>
        <p class="page-subtitle">Publish new feature announcements, configure bespoke role targeting (Researchers, Lawyers, Students, or All), and manage interactive walkthrough tours.</p>
    </div>
    <a href="{{ route('admin.platform-updates.create') }}" class="btn btn-primary btn-action">
        <i class="fa-solid fa-plus"></i> Add New Update / Tour
    </a>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 12px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="card-table">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Title & Excerpt</th>
                <th style="width: 140px;">Audience Target</th>
                <th style="width: 130px;">Tour Status</th>
                <th style="width: 110px;">Active</th>
                <th style="width: 160px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($updates as $index => $update)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight: 700; color: #fff; font-size: 14px; margin-bottom: 3px;">
                            {{ $update->title }}
                        </div>
                        <div style="font-size: 12px; color: var(--text-secondary); line-height: 1.4; max-width: 480px;">
                            {{ Str::limit($update->summary, 90) }}
                        </div>
                    </td>
                    <td>
                        @if($update->target_role === 'all')
                            <span style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 700;">
                                <i class="fa-solid fa-users mr-1"></i> All Roles
                            </span>
                        @else
                            <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 700;">
                                <i class="fa-solid fa-user-tag mr-1"></i> {{ ucfirst($update->target_role) }}
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($update->tour_steps && count($update->tour_steps) > 0)
                            <span style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600;">
                                <i class="fa-solid fa-compass mr-1"></i> {{ count($update->tour_steps) }} Steps
                            </span>
                        @else
                            <span style="color: var(--text-muted); font-size: 12px;">No Tour</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" onclick="togglePlatformUpdateStatus({{ $update->id }}, this)" style="background: {{ $update->is_active ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)' }}; color: {{ $update->is_active ? '#10b981' : '#ef4444' }}; border: 1px solid {{ $update->is_active ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)' }}; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 700; cursor: pointer;">
                            {{ $update->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.platform-updates.edit', $update->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12.5px;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.platform-updates.destroy', $update->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feature update?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action" style="padding: 6px 12px; font-size: 12.5px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; cursor: pointer; font-weight: 600;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                        <i class="fa-solid fa-bullhorn" style="font-size: 28px; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                        No platform updates or feature tours found. Create one to notify users.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function togglePlatformUpdateStatus(id, btn) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    btn.disabled = true;
    btn.textContent = 'Updating...';

    fetch(`/admin/platform-updates/${id}/toggle-status`, {
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
        btn.disabled = false;
        if (data && data.success) {
            if (data.is_active) {
                btn.textContent = 'Active';
                btn.style.background = 'rgba(16, 185, 129, 0.15)';
                btn.style.borderColor = 'rgba(16, 185, 129, 0.3)';
                btn.style.color = '#10b981';
            } else {
                btn.textContent = 'Inactive';
                btn.style.background = 'rgba(239, 68, 68, 0.15)';
                btn.style.borderColor = 'rgba(239, 68, 68, 0.3)';
                btn.style.color = '#ef4444';
            }
        }
    })
    .catch(() => {
        btn.disabled = false;
        alert('Error updating status');
    });
}
</script>
@endsection
