@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Subscription Plan: {{ $subscription->type }}</h1>
        <p class="page-subtitle">Update pricing tier parameters, download allowances, and marketing notes.</p>
    </div>
    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary btn-action" style="margin-right: 32px;">
        <i class="fa-solid fa-arrow-left"></i> Back to Plans
    </a>
</div>

<div class="card-table" style="padding: 32px; max-width: 800px;">
    <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Plan Name <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="type" value="{{ old('type', $subscription->type) }}" required placeholder="e.g. Starter, Professional, Enterprise" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                @error('type')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Price in GHS <span style="color: #ef4444;">*</span>
                </label>
                <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $subscription->price) }}" required placeholder="e.g. 100.00" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                @error('price')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Duration (in Days) <span style="color: #ef4444;">*</span>
                </label>
                <input type="number" min="1" name="duration" value="{{ old('duration', $subscription->duration) }}" required placeholder="e.g. 90 (3 months) or 365 (1 year)" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Number of days this package remains valid after payment.</small>
                @error('duration')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Download Limit (No. of Documents) <span style="color: #ef4444;">*</span>
                </label>
                <input type="number" min="0" name="no_downloads" value="{{ old('no_downloads', $subscription->no_downloads) }}" required placeholder="e.g. 50 or 20000 for unlimited" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Enter a large number (e.g. 20000) for unlimited downloads.</small>
                @error('no_downloads')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                Badge / Tag (Optional)
            </label>
            <input type="text" name="badge" value="{{ old('badge', $subscription->badge) }}" placeholder="e.g. Best Value, Recommended, Most Popular" style="width: 100%; max-width: 400px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
            <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Pill tag displayed on top of the pricing card.</small>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                General Access Notes (Feature Point 1)
            </label>
            <textarea name="general_notes" rows="2" placeholder="e.g. Free Access and Downloads to Constitution and Pre-4th Republic Laws" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; font-family: inherit;">{{ old('general_notes', $subscription->general_notes) }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                Specific Feature Notes (Feature Point 2)
            </label>
            <textarea name="specific_notes" rows="2" placeholder="e.g. Download 100 documents (4th Republic Laws and Cases) for 3 months" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; font-family: inherit;">{{ old('specific_notes', $subscription->specific_notes) }}</textarea>
        </div>

        <div style="display: flex; gap: 32px; align-items: center; flex-wrap: wrap; margin-bottom: 32px; padding-top: 12px; border-top: 1px solid var(--border-color);">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: var(--text-primary);">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $subscription->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary-color); cursor: pointer;">
                Active (Visible on Pricing Page)
            </label>

            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: var(--text-primary);">
                <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $subscription->is_popular) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary-color); cursor: pointer;">
                Mark as Most Popular (Highlighted Plan)
            </label>

            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: #f87171;">
                <input type="checkbox" name="is_button_disabled" value="1" {{ old('is_button_disabled', $subscription->is_button_disabled) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #ef4444; cursor: pointer;">
                Disable "Subscribe Now" Button
            </label>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary btn-action">
                <i class="fa-solid fa-check"></i> Update Plan
            </button>
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary btn-action">Cancel</a>
        </div>
    </form>
</div>
@endsection
