@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Subscription Plan: {{ $subscription->type }}</h1>
        <p class="page-subtitle">Customize all card contents, pricing, duration text, badges, features, and buttons.</p>
    </div>
    <div style="display: flex; gap: 12px; align-items: center; margin-right: 32px;">
        <a href="/subscription" target="_blank" class="btn btn-secondary btn-action" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25);">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live Card
        </a>
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary btn-action">
            <i class="fa-solid fa-arrow-left"></i> Back to Plans
        </a>
    </div>
</div>

<div class="card-table" style="padding: 32px; max-width: 900px;">
    <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST" id="subscriptionForm">
        @csrf
        @method('PUT')

        <!-- Section 1: Core Plan Info -->
        <div style="margin-bottom: 28px;">
            <h3 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-tag" style="color: #60a5fa; font-size: 15px;"></i> Plan Identity & Pricing
            </h3>
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Plan Name <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="type" value="{{ old('type', $subscription->type) }}" required placeholder="e.g. Starter, Professional, Business" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    @error('type')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Currency
                    </label>
                    <input type="text" name="currency" value="{{ old('currency', $subscription->currency ?? 'GHS') }}" placeholder="GHS" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    @error('currency')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Price <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $subscription->price) }}" required placeholder="e.g. 60.00" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    @error('price')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 2: Duration & Download Limits -->
        <div style="margin-bottom: 28px; padding-top: 20px; border-top: 1px solid var(--border-color);">
            <h3 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-clock-rotate-left" style="color: #60a5fa; font-size: 15px;"></i> Duration & Download Allowance
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Duration (in Days) <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="number" min="1" name="duration" value="{{ old('duration', $subscription->duration) }}" required placeholder="e.g. 90 (3 months) or 365 (1 year)" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Number of days added to user's subscription expiry upon payment.</small>
                    @error('duration')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Duration Display Text (On Card)
                    </label>
                    <input type="text" name="duration_text" value="{{ old('duration_text', $subscription->duration_text ?? $subscription->display_duration) }}" placeholder="e.g. for 3 months, for 6 months, per year" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Subtext displayed right under the price amount on the card.</small>
                    @error('duration_text')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Download Quota (Documents) <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="number" min="0" name="no_downloads" value="{{ old('no_downloads', $subscription->no_downloads) }}" required placeholder="e.g. 50 or 20000 for unlimited" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Actual document download limit.</small>
                    @error('no_downloads')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: #60a5fa; margin-bottom: 8px;">
                        <i class="fa-solid fa-users"></i> Team Seats / Max Users <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="number" min="1" max="100" name="max_users" value="{{ old('max_users', $subscription->max_users ?? 1) }}" required placeholder="1 for Starter, 3 for Essential, 5 for Premium" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid rgba(59, 130, 246, 0.4); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Users sharing this subscription (1 = Solo, 3 = Essential, 5 = Premium).</small>
                    @error('max_users')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Highlight Box Callout Text
                    </label>
                    <input type="text" name="highlight_text" value="{{ old('highlight_text', $subscription->highlight_text ?? $subscription->display_highlight) }}" placeholder="e.g. Up to 50 document downloads" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Text inside the blue badge pill.</small>
                    @error('highlight_text')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 3: Feature Bullet Points Repeater -->
        <div style="margin-bottom: 28px; padding-top: 20px; border-top: 1px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-list-check" style="color: #10b981; font-size: 15px;"></i> Card Feature Bullet Points
                    </h3>
                    <p style="font-size: 13px; color: var(--text-secondary); margin: 0;">
                        Every bullet point displayed on this subscription card. Add, remove, or modify any feature.
                    </p>
                </div>
                <button type="button" onclick="addFeatureRow()" class="btn btn-secondary btn-action" style="font-size: 13px; padding: 7px 14px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">
                    <i class="fa-solid fa-plus"></i> Add Bullet Point
                </button>
            </div>

            <div id="featuresListContainer" style="display: flex; flex-direction: column; gap: 10px;">
                @php
                    $existingFeatures = old('features', $subscription->feature_list);
                    if (empty($existingFeatures)) {
                        $existingFeatures = [
                            'Free Access and Downloads to Constitution and Pre-4th Republic Laws',
                            'Download documents for the active period',
                            'High-Speed Official PDF Document Downloads',
                            'Search Filter & Section Bookmarking',
                            'Personal Document Notes & Annotations'
                        ];
                    }
                @endphp

                @foreach($existingFeatures as $index => $feature)
                    <div class="feature-item-row" style="display: flex; align-items: center; gap: 10px;">
                        <div style="color: #10b981; font-size: 16px; flex-shrink: 0; width: 24px; text-align: center;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <input type="text" name="features[]" value="{{ $feature }}" placeholder="Enter feature bullet point text" required style="flex: 1; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                        <button type="button" onclick="removeFeatureRow(this)" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 8px; width: 38px; height: 38px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;" title="Remove this bullet point">
                            <i class="fa-solid fa-trash-can" style="font-size: 13px;"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Section 4: Badge & Button Settings -->
        <div style="margin-bottom: 28px; padding-top: 20px; border-top: 1px solid var(--border-color);">
            <h3 style="font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-sliders" style="color: #60a5fa; font-size: 15px;"></i> Card Badge & Call-To-Action Button
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Floating Pill Tag / Badge (Optional)
                    </label>
                    <input type="text" name="badge" value="{{ old('badge', $subscription->badge) }}" placeholder="e.g. Most Popular, Best Value, Recommended" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Pill tag displayed at top center of the pricing card.</small>
                    @error('badge')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                        Button Label / Text
                    </label>
                    <input type="text" name="button_text" value="{{ old('button_text', $subscription->button_text ?? 'Subscribe Now') }}" placeholder="e.g. Subscribe Now, Get Started" style="width: 100%; padding: 11px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Text shown on the checkout action button.</small>
                    @error('button_text')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Toggles -->
            <div style="display: flex; gap: 32px; align-items: center; flex-wrap: wrap; padding: 16px 20px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); border-radius: 12px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: var(--text-primary);">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $subscription->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary-color); cursor: pointer;">
                    Active (Visible on Pricing Page)
                </label>

                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: var(--text-primary);">
                    <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $subscription->is_popular) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #3b82f6; cursor: pointer;">
                    Mark as "Most Popular" (Highlighted Theme)
                </label>

                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: #f87171;">
                    <input type="checkbox" name="is_button_disabled" value="1" {{ old('is_button_disabled', $subscription->is_button_disabled) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #ef4444; cursor: pointer;">
                    Disable "Subscribe Now" Button
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn btn-primary btn-action" style="padding: 12px 28px; font-size: 15px;">
                <i class="fa-solid fa-check"></i> Save & Update Plan
            </button>
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary btn-action" style="padding: 12px 24px; font-size: 15px;">Cancel</a>
        </div>
    </form>
</div>

<script>
function addFeatureRow(initialText = '') {
    const container = document.getElementById('featuresListContainer');
    const row = document.createElement('div');
    row.className = 'feature-item-row';
    row.style.cssText = 'display: flex; align-items: center; gap: 10px;';
    row.innerHTML = `
        <div style="color: #10b981; font-size: 16px; flex-shrink: 0; width: 24px; text-align: center;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <input type="text" name="features[]" value="${escapeHtml(initialText)}" placeholder="Enter feature bullet point text" required style="flex: 1; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
        <button type="button" onclick="removeFeatureRow(this)" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 8px; width: 38px; height: 38px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;" title="Remove this bullet point">
            <i class="fa-solid fa-trash-can" style="font-size: 13px;"></i>
        </button>
    `;
    container.appendChild(row);
    const input = row.querySelector('input');
    if (input) input.focus();
}

function removeFeatureRow(button) {
    const rows = document.querySelectorAll('.feature-item-row');
    if (rows.length <= 1) {
        alert('A subscription plan must have at least one feature bullet point.');
        return;
    }
    const row = button.closest('.feature-item-row');
    if (row) {
        row.remove();
    }
}

function escapeHtml(text) {
    var map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
</script>
@endsection
