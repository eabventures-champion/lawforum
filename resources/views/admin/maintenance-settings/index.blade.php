@extends('layouts.admin')

@section('title', 'Maintenance Mode')

@section('styles')
<style>
    /* ── Status Banner ───────────────────────────────────── */
    .maintenance-status-banner {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px 28px;
        border-radius: 14px;
        margin-bottom: 28px;
        border: 1px solid;
        transition: all 0.3s ease;
    }
    .maintenance-status-banner.is-active {
        background: rgba(239, 68, 68, 0.08);
        border-color: rgba(239, 68, 68, 0.25);
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.10), 0 0 60px rgba(239, 68, 68, 0.05);
    }
    .maintenance-status-banner.is-inactive {
        background: rgba(16, 185, 129, 0.08);
        border-color: rgba(16, 185, 129, 0.25);
        box-shadow: 0 0 30px rgba(16, 185, 129, 0.08);
    }
    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .status-dot.active {
        background: var(--danger-color);
        box-shadow: 0 0 8px var(--danger-color);
        animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .status-dot.inactive {
        background: var(--success-color);
        box-shadow: 0 0 6px rgba(16, 185, 129, 0.4);
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; box-shadow: 0 0 8px var(--danger-color); }
        50%      { opacity: 0.4; box-shadow: 0 0 20px var(--danger-color); }
    }
    .status-text {
        font-size: 15px;
        font-weight: 600;
    }
    .status-badge {
        margin-left: auto;
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }
    .status-badge.active {
        background: rgba(239, 68, 68, 0.15);
        color: var(--danger-color);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .status-badge.inactive {
        background: rgba(16, 185, 129, 0.15);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    /* ── Master Toggle Card ──────────────────────────────── */
    .master-toggle-card {
        background: var(--card-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 28px;
    }
    .master-toggle-inner {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .master-toggle-inner .switch {
        transform: scale(1.25);
        transform-origin: center;
    }
    .master-toggle-info {
        flex: 1;
    }
    .master-toggle-title {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }
    .master-toggle-desc {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    /* ── Section Cards ───────────────────────────────────── */
    .settings-card {
        background: var(--card-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 28px;
    }
    .settings-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }
    .settings-card-header i {
        color: var(--accent-color);
        font-size: 16px;
    }
    .settings-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #fff;
    }

    /* ── Dialogue Repeater ───────────────────────────────── */
    .dialogue-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        animation: fadeSlideIn 0.25s ease;
    }
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .dialogue-row .form-control {
        flex: 1;
    }
    .dialogue-row-number {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: var(--accent-color);
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .btn-remove-row {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid rgba(239, 68, 68, 0.2);
        background: rgba(239, 68, 68, 0.08);
        color: var(--danger-color);
        cursor: pointer;
        font-size: 13px;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .btn-remove-row:hover {
        background: var(--danger-color);
        color: #fff;
        box-shadow: 0 4px 12px var(--danger-glow);
    }
    .btn-add-message {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: 1px dashed rgba(59, 130, 246, 0.3);
        background: rgba(59, 130, 246, 0.06);
        color: var(--accent-color);
        transition: all 0.2s ease;
    }
    .btn-add-message:hover {
        background: rgba(59, 130, 246, 0.12);
        border-color: rgba(59, 130, 246, 0.5);
    }

    /* ── Validation Errors ───────────────────────────────── */
    .validation-error {
        color: var(--danger-color);
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ── Save Footer ─────────────────────────────────────── */
    .save-footer {
        border-top: 1px solid var(--border-color);
        padding-top: 24px;
        margin-top: 8px;
    }

    /* ── Switch toggle (inline for this page) ────────────── */
    .setting-switch-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.02);
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }
    .switch input { opacity: 0; width: 0; height: 0; }
    .switch .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #374151;
        transition: .4s;
        border-radius: 24px;
    }
    .switch .slider::before {
        content: "";
        position: absolute;
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    .switch input:checked + .slider {
        background-color: var(--accent-color);
    }
    .switch input:checked + .slider::before {
        transform: translateX(20px);
    }
</style>
@endsection

@section('content')
@php
    $isEnabled = old('maintenance_enabled', $settings['maintenance_enabled']->value) == '1';
    $dialogueMessages = old('dialogue_messages', json_decode($settings['maintenance_dialogue_messages']->value, true) ?? []);
@endphp

{{-- ── Page Header ────────────────────────────────────────── --}}
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fa-solid fa-shield-halved" style="color: var(--accent-color); margin-right: 4px;"></i>
            Maintenance Mode
        </h1>
        <p class="page-subtitle">Control site access, set a passcode for bypass, and configure the maintenance page content.</p>
    </div>
</div>

{{-- ── Status Banner ──────────────────────────────────────── --}}
<div class="maintenance-status-banner {{ $isEnabled ? 'is-active' : 'is-inactive' }}">
    <span class="status-dot {{ $isEnabled ? 'active' : 'inactive' }}"></span>
    <span class="status-text">
        @if($isEnabled)
            Maintenance mode is <strong>currently active</strong> — visitors see the maintenance page.
        @else
            Site is <strong>live and accessible</strong> — maintenance mode is off.
        @endif
    </span>
    <span class="status-badge {{ $isEnabled ? 'active' : 'inactive' }}">
        {{ $isEnabled ? 'Active' : 'Inactive' }}
    </span>
</div>

<form action="{{ route('admin.maintenance-settings.update') }}" method="POST">
    @csrf

    {{-- ── Master Toggle ──────────────────────────────────── --}}
    <div class="master-toggle-card">
        <div class="master-toggle-inner">
            <label class="switch">
                <input type="hidden" name="maintenance_enabled" value="0">
                <input type="checkbox"
                       name="maintenance_enabled"
                       value="1"
                       {{ $isEnabled ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <div class="master-toggle-info">
                <div class="master-toggle-title">Enable Maintenance Mode</div>
                <div class="master-toggle-desc">
                    <i class="fa-solid fa-triangle-exclamation" style="color: var(--danger-color); margin-right: 2px;"></i>
                    When enabled, all visitors will be redirected to the maintenance page. Only users with the correct passcode can bypass it.
                </div>
            </div>
        </div>
        @error('maintenance_enabled')
            <div class="validation-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
        @enderror
    </div>

    {{-- ── Configuration Card ─────────────────────────────── --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <i class="fa-solid fa-gear"></i>
            <span class="settings-card-title">Page Configuration</span>
        </div>

        {{-- Passcode --}}
        <div class="form-group">
            <label for="maintenance_passcode" class="form-label">
                <i class="fa-solid fa-key" style="margin-right: 4px;"></i> Bypass Passcode
            </label>
            <input type="text"
                   id="maintenance_passcode"
                   name="maintenance_passcode"
                   class="form-control"
                   value="{{ old('maintenance_passcode', $settings['maintenance_passcode']->value) }}"
                   placeholder="Enter a passcode for authorized access">
            @error('maintenance_passcode')
                <div class="validation-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
            @enderror
        </div>

        {{-- Title --}}
        <div class="form-group">
            <label for="maintenance_title" class="form-label">
                <i class="fa-solid fa-heading" style="margin-right: 4px;"></i> Page Title
            </label>
            <input type="text"
                   id="maintenance_title"
                   name="maintenance_title"
                   class="form-control"
                   value="{{ old('maintenance_title', $settings['maintenance_title']->value) }}"
                   placeholder="e.g. We'll Be Right Back">
            @error('maintenance_title')
                <div class="validation-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
            @enderror
        </div>

        {{-- Subtitle --}}
        <div class="form-group" style="margin-bottom: 0;">
            <label for="maintenance_subtitle" class="form-label">
                <i class="fa-solid fa-align-left" style="margin-right: 4px;"></i> Page Subtitle
            </label>
            <textarea id="maintenance_subtitle"
                      name="maintenance_subtitle"
                      class="form-control"
                      style="min-height: 90px;"
                      placeholder="A short message explaining the downtime">{{ old('maintenance_subtitle', $settings['maintenance_subtitle']->value) }}</textarea>
            @error('maintenance_subtitle')
                <div class="validation-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- ── Dialogue Messages Card ─────────────────────────── --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <i class="fa-solid fa-comments"></i>
            <span class="settings-card-title">Dialogue Messages</span>
            <span class="badge badge-accent" style="margin-left: auto; font-size: 11px;" id="msg-count-badge">
                {{ count($dialogueMessages) }} {{ Str::plural('message', count($dialogueMessages)) }}
            </span>
        </div>

        <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px; line-height: 1.6;">
            These messages appear sequentially on the maintenance page as a typing-style dialogue. Add, remove, or reorder them below.
        </p>

        <div id="dialogue-messages-container">
            @forelse($dialogueMessages as $index => $msg)
                <div class="dialogue-row">
                    <span class="dialogue-row-number">{{ $index + 1 }}</span>
                    <input type="text"
                           name="dialogue_messages[]"
                           class="form-control"
                           value="{{ is_array($msg) ? ($msg['text'] ?? '') : $msg }}"
                           placeholder="Enter dialogue message">
                    <button type="button" class="btn-remove-row" title="Remove message" onclick="removeDialogueRow(this)">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @empty
                <div class="dialogue-row">
                    <span class="dialogue-row-number">1</span>
                    <input type="text"
                           name="dialogue_messages[]"
                           class="form-control"
                           placeholder="Enter dialogue message">
                    <button type="button" class="btn-remove-row" title="Remove message" onclick="removeDialogueRow(this)">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endforelse
        </div>

        @error('dialogue_messages')
            <div class="validation-error" style="margin-bottom: 12px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
        @enderror
        @error('dialogue_messages.*')
            <div class="validation-error" style="margin-bottom: 12px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
        @enderror

        <button type="button" class="btn-add-message" onclick="addDialogueRow()">
            <i class="fa-solid fa-plus"></i> Add Message
        </button>
    </div>

    {{-- ── Save Button ────────────────────────────────────── --}}
    <div class="save-footer">
        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
            <i class="fa-solid fa-floppy-disk"></i> Save Maintenance Settings
        </button>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function addDialogueRow() {
        const container = document.getElementById('dialogue-messages-container');
        const rows = container.querySelectorAll('.dialogue-row');
        const nextNum = rows.length + 1;

        const row = document.createElement('div');
        row.className = 'dialogue-row';
        row.innerHTML = `
            <span class="dialogue-row-number">${nextNum}</span>
            <input type="text"
                   name="dialogue_messages[]"
                   class="form-control"
                   placeholder="Enter dialogue message">
            <button type="button" class="btn-remove-row" title="Remove message" onclick="removeDialogueRow(this)">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;

        container.appendChild(row);
        row.querySelector('input').focus();
        updateRowNumbers();
    }

    function removeDialogueRow(btn) {
        const container = document.getElementById('dialogue-messages-container');
        const rows = container.querySelectorAll('.dialogue-row');

        // Prevent removing the last row
        if (rows.length <= 1) {
            rows[0].querySelector('input').value = '';
            rows[0].querySelector('input').focus();
            return;
        }

        btn.closest('.dialogue-row').remove();
        updateRowNumbers();
    }

    function updateRowNumbers() {
        const container = document.getElementById('dialogue-messages-container');
        const rows = container.querySelectorAll('.dialogue-row');
        rows.forEach(function(row, idx) {
            row.querySelector('.dialogue-row-number').textContent = idx + 1;
        });

        // Update the badge count
        const badge = document.getElementById('msg-count-badge');
        if (badge) {
            const count = rows.length;
            badge.textContent = count + (count === 1 ? ' message' : ' messages');
        }
    }
</script>
@endsection
