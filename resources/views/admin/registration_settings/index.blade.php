@extends('layouts.admin')

@section('title', 'Registration Settings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Registration Gates</h1>
        <p class="page-subtitle">Control which sign-up roles are open for new registrations. Disabled roles show a "Coming Soon" badge on the get-started page.</p>
    </div>
</div>

<div class="card-table" style="padding: 32px;">
    <form action="{{ route('admin.registration-settings.update') }}" method="POST">
        @csrf

        {{-- Student Registration Toggle --}}
        <div style="margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; max-width: 520px; padding: 20px 24px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 14px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-graduation-cap" style="color: #3b82f6; font-size: 18px;"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--text-primary);">Student Registration</div>
                    <div style="font-size: 13px; color: var(--text-secondary); margin-top: 2px;">Allow new users to sign up as students</div>
                </div>
            </div>
            <label style="position: relative; display: inline-block; width: 52px; height: 28px; cursor: pointer;">
                <input type="checkbox" name="student_registration_enabled" value="1" {{ $student_registration_enabled === '1' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $student_registration_enabled === '1' ? '#10b981' : '#374151' }}; transition: 0.3s; border-radius: 28px;" onclick="
                    const cb = this.previousElementSibling;
                    setTimeout(() => {
                        this.style.backgroundColor = cb.checked ? '#10b981' : '#374151';
                        const dot = this.querySelector('span');
                        dot.style.transform = cb.checked ? 'translateX(24px)' : 'translateX(0)';
                    }, 10);
                ">
                    <span style="position: absolute; content: ''; height: 22px; width: 22px; left: 3px; bottom: 3px; background-color: white; transition: 0.3s; border-radius: 50%; transform: {{ $student_registration_enabled === '1' ? 'translateX(24px)' : 'translateX(0)' }};"></span>
                </span>
            </label>
        </div>

        {{-- Lawyer Registration Toggle --}}
        <div style="margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; max-width: 520px; padding: 20px 24px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 14px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-gavel" style="color: #f59e0b; font-size: 18px;"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--text-primary);">Lawyer Registration</div>
                    <div style="font-size: 13px; color: var(--text-secondary); margin-top: 2px;">Allow new users to sign up as lawyers</div>
                </div>
            </div>
            <label style="position: relative; display: inline-block; width: 52px; height: 28px; cursor: pointer;">
                <input type="checkbox" name="lawyer_registration_enabled" value="1" {{ $lawyer_registration_enabled === '1' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $lawyer_registration_enabled === '1' ? '#10b981' : '#374151' }}; transition: 0.3s; border-radius: 28px;" onclick="
                    const cb = this.previousElementSibling;
                    setTimeout(() => {
                        this.style.backgroundColor = cb.checked ? '#10b981' : '#374151';
                        const dot = this.querySelector('span');
                        dot.style.transform = cb.checked ? 'translateX(24px)' : 'translateX(0)';
                    }, 10);
                ">
                    <span style="position: absolute; content: ''; height: 22px; width: 22px; left: 3px; bottom: 3px; background-color: white; transition: 0.3s; border-radius: 50%; transform: {{ $lawyer_registration_enabled === '1' ? 'translateX(24px)' : 'translateX(0)' }};"></span>
                </span>
            </label>
        </div>

        {{-- Researcher Registration Toggle --}}
        <div style="margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; max-width: 520px; padding: 20px 24px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 14px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(139, 92, 246, 0.1); display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-microscope" style="color: #8b5cf6; font-size: 18px;"></i>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--text-primary);">Researcher Registration</div>
                    <div style="font-size: 13px; color: var(--text-secondary); margin-top: 2px;">Allow new users to sign up as researchers</div>
                </div>
            </div>
            <label style="position: relative; display: inline-block; width: 52px; height: 28px; cursor: pointer;">
                <input type="checkbox" name="researcher_registration_enabled" value="1" {{ $researcher_registration_enabled === '1' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $researcher_registration_enabled === '1' ? '#10b981' : '#374151' }}; transition: 0.3s; border-radius: 28px;" onclick="
                    const cb = this.previousElementSibling;
                    setTimeout(() => {
                        this.style.backgroundColor = cb.checked ? '#10b981' : '#374151';
                        const dot = this.querySelector('span');
                        dot.style.transform = cb.checked ? 'translateX(24px)' : 'translateX(0)';
                    }, 10);
                ">
                    <span style="position: absolute; content: ''; height: 22px; width: 22px; left: 3px; bottom: 3px; background-color: white; transition: 0.3s; border-radius: 50%; transform: {{ $researcher_registration_enabled === '1' ? 'translateX(24px)' : 'translateX(0)' }};"></span>
                </span>
            </label>
        </div>

        <!-- Info Box -->
        <div style="background: rgba(59, 130, 246, 0.06); border: 1px solid rgba(59, 130, 246, 0.15); border-radius: 12px; padding: 18px 20px; margin-bottom: 28px; max-width: 520px;">
            <div style="display: flex; gap: 12px; align-items: flex-start;">
                <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-top: 2px;"></i>
                <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                    <strong style="color: var(--text-primary);">How it works:</strong><br>
                    When a registration role is <strong style="color: #ef4444;">disabled</strong>, the sign-up card on the get-started page displays a <strong style="color: var(--text-primary);">"Coming Soon"</strong> badge and visitors cannot access the registration form for that role.<br><br>
                    When <strong style="color: #10b981;">enabled</strong>, the card functions normally and visitors can register.
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-action">
            <i class="fa-solid fa-check"></i> Save Settings
        </button>
    </form>
</div>
@endsection
