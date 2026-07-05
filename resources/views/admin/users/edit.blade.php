@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit User: {{ $user->name }} {{ $user->lname }}</h1>
        <p class="page-subtitle">Update user profile information, role, and subscription status.</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card-table" style="max-width: 800px; padding: 32px;">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="name" class="form-label">First Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" id="lname" name="lname" class="form-control" value="{{ old('lname', $user->lname) }}" required>
                @error('lname') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                @error('phone') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="country" class="form-label">Country</label>
                <input type="text" id="country" name="country" class="form-control" value="{{ old('country', $user->country) }}">
                @error('country') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 24px; margin-bottom: 24px;">
            <div class="form-group">
                <label for="role_id" class="form-label">Role</label>
                <select id="role_id" name="role_id" class="form-control">
                    <option value="2" {{ old('role_id', $user->role_id) != 1 ? 'selected' : '' }}>Regular User</option>
                    <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('role_id') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Subscription Section -->
        <div style="border-top: 1px solid var(--border-color); padding-top: 24px; margin-top: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #fff;">Subscription Settings</h3>
            
            <div class="form-group" style="display: flex; align-items: center; gap: 12px;">
                <input type="checkbox" id="check_subscription" name="check_subscription" value="1" {{ old('check_subscription', $user->check_subscription) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                <label for="check_subscription" class="form-label" style="margin-bottom: 0; cursor: pointer; color: var(--text-primary);">Enable Active Subscription</label>
            </div>

            <div class="form-group">
                <label for="subscription_expiry" class="form-label">Subscription Expiration Date</label>
                <input type="date" id="subscription_expiry" name="subscription_expiry" class="form-control" value="{{ old('subscription_expiry', $user->subscription_expiry ? \Carbon\Carbon::parse($user->subscription_expiry)->format('Y-m-d') : '') }}">
                @error('subscription_expiry') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
            <i class="fa-solid fa-floppy-disk"></i> Save User Changes
        </button>
    </form>
</div>
@endsection
