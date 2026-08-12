{{-- Shared mobile nav-auth links for all pages --}}
@guest
    <a href="/">Why Choose Us</a>
    @if(request()->cookie('guest_access'))
        <a href="/get-started" style="color: #10b981;"><i class="fa-solid fa-user-secret" style="margin-right: 6px;"></i> Guest User</a>
    @else
        <a href="/get-started" style="color: var(--accent-light);">Sign Up Free</a>
    @endif
@else
    @php
        $uType = Auth::user()->user_type;
        $roleLabel = 'Dashboard';
        $roleIcon = 'fa-circle-user';
        if ($uType === 'student') { $roleLabel = 'Student Portal'; $roleIcon = 'fa-graduation-cap'; }
        elseif ($uType === 'lawyer') { $roleLabel = 'Lawyer Portal'; $roleIcon = 'fa-gavel'; }
        elseif ($uType === 'researcher') { $roleLabel = 'Researcher Portal'; $roleIcon = 'fa-microscope'; }
    @endphp
    <a href="/home"><i class="fa-solid {{ $roleIcon }}" style="margin-right: 6px;"></i> {{ $roleLabel }}</a>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #f43f5e;"><i class="fa-solid fa-power-off" style="margin-right: 6px;"></i> Sign Out</a>
@endguest
