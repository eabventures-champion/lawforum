@extends('layouts.admin')

@section('title', 'Admin Profile Management')

@section('styles')
<style>
    .profile-page-header {
        margin-bottom: 28px;
    }
    .profile-page-title {
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 6px;
    }
    .profile-page-title i {
        color: #3b82f6;
    }
    .profile-page-desc {
        font-size: 14px;
        color: #94a3b8;
    }

    .profile-grid-container {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 24px;
        align-items: start;
    }

    .profile-card {
        background: rgba(18, 24, 38, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        position: relative;
    }

    .profile-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 22px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .profile-card-header-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .profile-card-header-icon.security {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
    }
    .profile-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
    }
    .profile-card-subtitle {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    /* Left Overview Card */
    .admin-avatar-section {
        text-align: center;
        padding-bottom: 24px;
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .admin-avatar-wrap {
        width: 88px;
        height: 88px;
        border-radius: 24px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 32px;
        color: #fff;
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.35);
        border: 2px solid rgba(255, 255, 255, 0.2);
        position: relative;
    }
    .admin-avatar-status {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #10b981;
        border: 3px solid #0f172a;
    }
    .admin-display-name {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 4px;
    }
    .admin-display-email {
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 14px;
        word-break: break-all;
    }
    .admin-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.35);
        color: #60a5fa;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .meta-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .meta-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
    }
    .meta-label {
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .meta-value {
        color: #e2e8f0;
        font-weight: 600;
    }

    /* Form Styles */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 18px;
    }
    .form-group-full {
        margin-bottom: 18px;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #cbd5e1;
        margin-bottom: 8px;
    }
    .input-icon-wrap {
        position: relative;
    }
    .input-icon-wrap i.field-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 14px;
    }
    .input-icon-wrap input,
    .input-icon-wrap select {
        width: 100%;
        padding: 12px 14px 12px 40px;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #fff;
        font-size: 14px;
        transition: all 0.25s ease;
        outline: none;
    }
    .input-icon-wrap select {
        appearance: none;
        cursor: pointer;
    }
    .input-icon-wrap input:focus,
    .input-icon-wrap select:focus {
        border-color: #3b82f6;
        background: rgba(15, 23, 42, 0.9);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18);
    }
    .input-icon-wrap .toggle-eye {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        cursor: pointer;
        font-size: 14px;
        transition: color 0.2s ease;
    }
    .input-icon-wrap .toggle-eye:hover {
        color: #fff;
    }

    .form-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
    }
    .form-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.45);
    }
    .form-btn-submit.security-btn {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.3);
    }
    .form-btn-submit.security-btn:hover {
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.45);
    }

    .input-error-msg {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    @media (max-width: 960px) {
        .profile-grid-container {
            grid-template-columns: 1fr;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-content-inner" style="padding: 28px 32px; max-width: 1300px; margin: 0 auto;">
    
    <!-- Page Header -->
    <div class="profile-page-header">
        <h1 class="profile-page-title">
            <i class="fa-solid fa-user-gear"></i>
            <span>Admin Profile Management</span>
        </h1>
        <p class="profile-page-desc">Manage your personal administrator details, contact info, and security credentials.</p>
    </div>

    <div class="profile-grid-container">
        
        <!-- LEFT COLUMN: Profile Overview Card -->
        <div class="profile-card">
            <div class="admin-avatar-section">
                <div class="admin-avatar-wrap">
                    <i class="fa-solid fa-user-shield"></i>
                    <div class="admin-avatar-status" title="Active Session"></div>
                </div>
                <h2 class="admin-display-name">{{ $admin->name }} {{ $admin->lname }}</h2>
                <div class="admin-display-email">{{ $admin->email }}</div>
                <div class="admin-role-badge">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Super Administrator</span>
                </div>
            </div>

            <div class="meta-list">
                <div class="meta-item">
                    <span class="meta-label"><i class="fa-solid fa-id-badge"></i> Account ID</span>
                    <span class="meta-value">#{{ $admin->id }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label"><i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Status</span>
                    <span class="meta-value" style="color: #10b981;">Active</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label"><i class="fa-solid fa-earth-africa"></i> Country</span>
                    <span class="meta-value">{{ $admin->country ?? 'Ghana' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label"><i class="fa-solid fa-phone"></i> Phone</span>
                    <span class="meta-value">{{ $admin->phone ?? 'Not set' }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label"><i class="fa-solid fa-calendar-check"></i> Registered</span>
                    <span class="meta-value">{{ $admin->created_at ? $admin->created_at->format('M d, Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Forms (Personal Info & Security) -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- CARD 1: Personal Details -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-card-header-icon">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div>
                        <div class="profile-card-title">Personal Information</div>
                        <div class="profile-card-subtitle">Update your personal and contact details</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <!-- First Name -->
                        <div>
                            <label class="form-label" for="name">First Name <span style="color: #ef4444;">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fa-solid fa-user field-icon"></i>
                                <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required placeholder="First name">
                            </div>
                            @error('name')
                                <div class="input-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label class="form-label" for="lname">Last Name</label>
                            <div class="input-icon-wrap">
                                <i class="fa-solid fa-user-tag field-icon"></i>
                                <input type="text" id="lname" name="lname" value="{{ old('lname', $admin->lname) }}" placeholder="Last name">
                            </div>
                            @error('lname')
                                <div class="input-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- Email -->
                        <div>
                            <label class="form-label" for="email">Admin Email Address <span style="color: #ef4444;">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fa-solid fa-envelope field-icon"></i>
                                <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required placeholder="admin@admin.com">
                            </div>
                            @error('email')
                                <div class="input-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="form-label" for="phone">Phone Number</label>
                            <div class="input-icon-wrap">
                                <i class="fa-solid fa-phone field-icon"></i>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}" placeholder="e.g. 0240000000">
                            </div>
                            @error('phone')
                                <div class="input-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Country -->
                    <div class="form-group-full">
                        <label class="form-label" for="country">Country</label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-globe field-icon"></i>
                            <select id="country" name="country">
                                <option value="Ghana" {{ old('country', $admin->country) == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                <option value="United States of America" {{ old('country', $admin->country) == 'United States of America' ? 'selected' : '' }}>United States of America</option>
                                <option value="United Kingdom" {{ old('country', $admin->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="Nigeria" {{ old('country', $admin->country) == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                <option value="Canada" {{ old('country', $admin->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                                <option value="South Africa" {{ old('country', $admin->country) == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                <option value="Kenya" {{ old('country', $admin->country) == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                <option value="Australia" {{ old('country', $admin->country) == 'Australia' ? 'selected' : '' }}>Australia</option>
                                <option value="Germany" {{ old('country', $admin->country) == 'Germany' ? 'selected' : '' }}>Germany</option>
                                <option value="France" {{ old('country', $admin->country) == 'France' ? 'selected' : '' }}>France</option>
                            </select>
                        </div>
                        @error('country')
                            <div class="input-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div style="text-align: right; margin-top: 24px;">
                        <button type="submit" class="form-btn-submit">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Save Profile Changes</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- CARD 2: Security & Password -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-card-header-icon security">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="profile-card-title">Security & Password</div>
                        <div class="profile-card-subtitle">Ensure your administrator account uses a strong, secure password</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.profile.password') }}">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="form-group-full">
                        <label class="form-label" for="current_password">Current Password <span style="color: #ef4444;">*</span></label>
                        <div class="input-icon-wrap">
                            <i class="fa-solid fa-lock field-icon"></i>
                            <input type="password" id="current_password" name="current_password" required placeholder="Enter current password">
                            <i class="fa-solid fa-eye toggle-eye" onclick="togglePass('current_password', this)"></i>
                        </div>
                        @error('current_password')
                            <div class="input-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <!-- New Password -->
                        <div>
                            <label class="form-label" for="password">New Password <span style="color: #ef4444;">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fa-solid fa-key field-icon"></i>
                                <input type="password" id="password" name="password" required placeholder="Minimum 6 characters">
                                <i class="fa-solid fa-eye toggle-eye" onclick="togglePass('password', this)"></i>
                            </div>
                            @error('password')
                                <div class="input-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label class="form-label" for="password_confirmation">Confirm New Password <span style="color: #ef4444;">*</span></label>
                            <div class="input-icon-wrap">
                                <i class="fa-solid fa-circle-check field-icon"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Re-enter new password">
                                <i class="fa-solid fa-eye toggle-eye" onclick="togglePass('password_confirmation', this)"></i>
                            </div>
                        </div>
                    </div>

                    <div style="text-align: right; margin-top: 24px;">
                        <button type="submit" class="form-btn-submit security-btn">
                            <i class="fa-solid fa-lock"></i>
                            <span>Update Security Password</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>

<script>
    function togglePass(fieldId, icon) {
        const input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
