@extends('layouts.admin')

@section('title', 'Demo Settings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Demo Mode Settings</h1>
        <p class="page-subtitle">Configure the free demo trial periods for new user registrations.</p>
    </div>
</div>

<div class="card-table" style="padding: 32px;">
    <form action="{{ route('admin.demo-settings.update') }}" method="POST">
        @csrf

        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                <i class="fa-solid fa-calendar-days" style="color: var(--primary-color); margin-right: 6px;"></i>
                Demo Duration (days)
            </label>
            <input type="number" name="demo_duration_days" value="{{ old('demo_duration_days', $demo_duration_days) }}" required min="1" style="width: 100%; max-width: 200px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
            <small style="display: block; color: var(--text-secondary); margin-top: 6px;">The number of days a user can access the full platform in demo mode after registration. Default: 60 days.</small>
            @error('demo_duration_days')
                <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                <i class="fa-solid fa-clock-rotate-left" style="color: #f59e0b; margin-right: 6px;"></i>
                Extension Duration (days)
            </label>
            <input type="number" name="demo_extension_days" value="{{ old('demo_extension_days', $demo_extension_days) }}" required min="1" style="width: 100%; max-width: 200px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
            <small style="display: block; color: var(--text-secondary); margin-top: 6px;">After the main demo period expires, users get this many additional days with a subscription reminder. Default: 15 days.</small>
            @error('demo_extension_days')
                <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <!-- Info Box -->
        <div style="background: rgba(59, 130, 246, 0.06); border: 1px solid rgba(59, 130, 246, 0.15); border-radius: 12px; padding: 18px 20px; margin-bottom: 28px; max-width: 520px;">
            <div style="display: flex; gap: 12px; align-items: flex-start;">
                <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-top: 2px;"></i>
                <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                    <strong style="color: var(--text-primary);">How it works:</strong><br>
                    After registration, users choose "Demo Mode" and get <strong style="color: var(--text-primary);">{{ $demo_duration_days }} days</strong> of full access.
                    When the demo expires, they automatically receive a <strong style="color: var(--text-primary);">{{ $demo_extension_days }}-day extension</strong> with a subscription reminder.
                    After the extension expires, the user is downgraded to guest access and cannot re-enter demo mode.
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-action">
            <i class="fa-solid fa-check"></i> Save Settings
        </button>
    </form>
</div>
@endsection
