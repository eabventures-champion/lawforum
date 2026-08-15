@extends('layouts.admin')

@section('title', 'Edit Feature Update')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Feature Update</h1>
        <p class="page-subtitle">Update notification details, target audience, or walkthrough tour steps.</p>
    </div>
    <a href="{{ route('admin.platform-updates.index') }}" class="btn btn-secondary btn-action">
        <i class="fa-solid fa-arrow-left"></i> Back to Updates
    </a>
</div>

<div class="card" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; max-width: 800px;">
    <form action="{{ route('admin.platform-updates.update', $update->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Update Title *</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $update->title) }}" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Target Audience (Role) *</label>
                <select name="target_role" class="form-control" style="width: 100%; background: #0f172a; border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
                    <option value="all" {{ $update->target_role === 'all' ? 'selected' : '' }}>🌐 All Roles (General Update)</option>
                    <option value="researcher" {{ $update->target_role === 'researcher' ? 'selected' : '' }}>🔬 Researchers Only (Bespoke)</option>
                    <option value="lawyer" {{ $update->target_role === 'lawyer' ? 'selected' : '' }}>⚖️ Lawyers Only (Bespoke)</option>
                    <option value="student" {{ $update->target_role === 'student' ? 'selected' : '' }}>🎓 Students Only (Bespoke)</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Badge Text</label>
                <input type="text" name="badge_text" class="form-control" value="{{ old('badge_text', $update->badge_text) }}" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Short Summary (Teaser in Notification Dropdown) *</label>
            <textarea name="summary" rows="3" class="form-control" required style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px; font-family: inherit;">{{ old('summary', $update->summary) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Full Details / Article (Optional)</label>
            <textarea name="content" rows="4" class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px; font-family: inherit;">{{ old('content', $update->content) }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 4px;">Walkthrough Tour Steps (JSON Array - Optional)</label>
            <span style="font-size: 11.5px; color: var(--text-muted); display: block; margin-bottom: 8px;">Edit or define interactive step objects for this feature.</span>
            <textarea name="tour_steps_raw" rows="5" class="form-control" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #93c5fd; padding: 10px 14px; border-radius: 10px; font-family: monospace; font-size: 12.5px;">{{ old('tour_steps_raw', $update->tour_steps ? json_encode($update->tour_steps, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; color: #fff; font-size: 13.5px; font-weight: 600;">
                <input type="checkbox" name="is_active" value="1" {{ $update->is_active ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #3b82f6;">
                <span>Active (Visible to users)</span>
            </label>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary btn-action" style="padding: 10px 22px;">
                <i class="fa-solid fa-floppy-disk"></i> Update Changes
            </button>
            <a href="{{ route('admin.platform-updates.index') }}" class="btn btn-secondary btn-action" style="padding: 10px 18px;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
