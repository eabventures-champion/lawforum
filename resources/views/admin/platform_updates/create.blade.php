@extends('layouts.admin')

@section('title', 'Add Platform Feature Update')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Feature Update / Tour</h1>
        <p class="page-subtitle">Publish a platform announcement with optional bespoke audience targeting and interactive walkthrough steps.</p>
    </div>
    <a href="{{ route('admin.platform-updates.index') }}" class="btn btn-secondary btn-action">
        <i class="fa-solid fa-arrow-left"></i> Back to Updates
    </a>
</div>

<div class="card" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; max-width: 800px;">
    <form action="{{ route('admin.platform-updates.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Update Title *</label>
            <input type="text" name="title" class="form-control" placeholder="e.g., Interactive Split-Screen Reader" required value="{{ old('title') }}" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Target Audience (Role) *</label>
                <select name="target_role" class="form-control" style="width: 100%; background: #0f172a; border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
                    <option value="all">🌐 All Roles (General Update)</option>
                    <option value="researcher">🔬 Researchers Only (Bespoke)</option>
                    <option value="lawyer">⚖️ Lawyers Only (Bespoke)</option>
                    <option value="student">🎓 Students Only (Bespoke)</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Badge Text (Optional)</label>
                <input type="text" name="badge_text" class="form-control" placeholder="e.g. New Feature / Bespoke - Researcher" value="{{ old('badge_text') }}" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Short Summary (Teaser in Notification Dropdown) *</label>
            <textarea name="summary" rows="3" class="form-control" placeholder="Brief summary of what changed or what new feature is available..." required style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px; font-family: inherit;">{{ old('summary') }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 6px;">Full Details / Article (Optional)</label>
            <textarea name="content" rows="4" class="form-control" placeholder="Detailed release notes or instructions..." style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #fff; padding: 10px 14px; border-radius: 10px; font-family: inherit;">{{ old('content') }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 700; color: #cbd5e1; margin-bottom: 4px;">Walkthrough Tour Steps (JSON Array - Optional)</label>
            <span style="font-size: 11.5px; color: var(--text-muted); display: block; margin-bottom: 8px;">If provided, users can click "Take Feature Tour" in their notification popup to step through this walkthrough.</span>
            <textarea name="tour_steps_raw" rows="4" class="form-control" placeholder='[{"title":"Split Screen","description":"Compare two legal texts side by side","icon":"fa-columns"}]' style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-color); color: #93c5fd; padding: 10px 14px; border-radius: 10px; font-family: monospace; font-size: 12.5px;">{{ old('tour_steps_raw') }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; color: #fff; font-size: 13.5px; font-weight: 600;">
                <input type="checkbox" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #3b82f6;">
                <span>Publish Immediately (Active)</span>
            </label>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary btn-action" style="padding: 10px 22px;">
                <i class="fa-solid fa-cloud-arrow-up"></i> Save & Publish Update
            </button>
            <a href="{{ route('admin.platform-updates.index') }}" class="btn btn-secondary btn-action" style="padding: 10px 18px;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
