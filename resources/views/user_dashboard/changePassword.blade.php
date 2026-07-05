@extends('layouts.user')

@section('title', 'Change Password')

@section('content')
<div class="content-card">
    <h1 class="card-title">Security & Password</h1>
    <p class="card-subtitle">Ensure your account remains secure by updating your password credentials regularly.</p>

    <!-- Alert Banners -->
    @if(session('success'))
        <div class="alert-banner alert-banner-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-banner alert-banner-danger">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div style="display: flex; flex-direction: column; gap: 4px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('change.password') }}">
        @csrf

        <div style="max-width: 600px;">
            <!-- Current Password -->
            <div class="form-group">
                <label for="current_password" class="form-label">Current Password</label>
                <div class="input-wrapper">
                    <input id="current_password" type="password" class="form-control" name="current_password" placeholder="••••••••" required style="padding-right: 48px;">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('current_password', this)"></i>
                </div>
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label for="new_password" class="form-label">New Password</label>
                <div class="input-wrapper">
                    <input id="new_password" type="password" class="form-control" name="new_password" placeholder="••••••••" required style="padding-right: 48px;">
                    <i class="fa-solid fa-key input-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('new_password', this)"></i>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div class="form-group">
                <label for="new_confirm_password" class="form-label">Confirm New Password</label>
                <div class="input-wrapper">
                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" placeholder="••••••••" required style="padding-right: 48px;">
                    <i class="fa-solid fa-circle-check input-icon"></i>
                    <i class="fa-solid fa-eye toggle-password" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--text-secondary); transition: var(--transition-smooth);" onclick="togglePasswordVisibility('new_confirm_password', this)"></i>
                </div>
            </div>

            <div style="margin-top: 10px;">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-key"></i>
                    <span>Update Security Password</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(fieldId, icon) {
        const passwordField = document.getElementById(fieldId);
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection