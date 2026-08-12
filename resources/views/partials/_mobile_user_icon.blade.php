{{-- Mobile User Role Status Icon Badge --}}
@php
    $roleIcon = 'fa-user-secret';
    $roleBg = 'rgba(16, 185, 129, 0.15)';
    $roleColor = '#10b981';
    $roleBorder = 'rgba(16, 185, 129, 0.3)';
    $roleTitle = 'Guest User';
    $roleLink = '/get-started';

    if (Auth::check()) {
        $userType = Auth::user()->user_type;
        $roleLink = '/home';
        if ($userType === 'student') {
            $roleIcon = 'fa-graduation-cap';
            $roleBg = 'rgba(59, 130, 246, 0.15)';
            $roleColor = '#60a5fa';
            $roleBorder = 'rgba(59, 130, 246, 0.3)';
            $roleTitle = 'Student User';
        } elseif ($userType === 'lawyer') {
            $roleIcon = 'fa-gavel';
            $roleBg = 'rgba(245, 158, 11, 0.15)';
            $roleColor = '#f59e0b';
            $roleBorder = 'rgba(245, 158, 11, 0.3)';
            $roleTitle = 'Lawyer User';
        } elseif ($userType === 'researcher') {
            $roleIcon = 'fa-microscope';
            $roleBg = 'rgba(139, 92, 246, 0.15)';
            $roleColor = '#a78bfa';
            $roleBorder = 'rgba(139, 92, 246, 0.3)';
            $roleTitle = 'Researcher User';
        } else {
            $roleIcon = 'fa-circle-user';
            $roleBg = 'rgba(59, 130, 246, 0.15)';
            $roleColor = '#60a5fa';
            $roleBorder = 'rgba(59, 130, 246, 0.3)';
            $roleTitle = Auth::user()->name;
        }
    }
@endphp

<a href="{{ $roleLink }}" class="mobile-user-role-badge" title="{{ $roleTitle }}" style="background: {{ $roleBg }}; color: {{ $roleColor }}; border: 1px solid {{ $roleBorder }};">
    <i class="fa-solid {{ $roleIcon }}"></i>
</a>
