{{-- Shared nav-auth buttons for all pages --}}
@guest
    <a href="/" class="btn-login">Why Choose Us</a>
    @if(request()->cookie('guest_access'))
        <a href="javascript:void(0)" onclick="openLoginModal()" class="btn-signup" style="background: rgba(255,255,255,0.08); box-shadow: none; cursor: pointer;">
            <i class="fa-solid fa-user-secret" style="margin-right: 4px;"></i> Guest User
        </a>
    @else
        <a href="/get-started" class="btn-signup">Sign Up Free</a>
    @endif
@else
    <div class="nav-user-dropdown" id="userDropdown">
        <button class="nav-user-btn" onclick="document.getElementById('userDropdown').classList.toggle('active')">
            <i class="fa-solid fa-circle-user"></i>
            {{ Auth::user()->name }}
            <i class="fa-solid fa-chevron-down" style="font-size: 10px; margin-left: 2px;"></i>
        </button>
        <div class="nav-dropdown-menu dropdown-menu-right" style="right: 0; left: auto;">
            <a href="/home"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="/accounts/profile/{{ Auth::user()->id }}"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="/accounts/manage-password"><i class="fa-solid fa-gear"></i> Settings</a>
            <div class="nav-dropdown-divider"></div>
            <a href="/accounts/downloads/{{ Auth::user()->id }}"><i class="fa-solid fa-download"></i> Downloads</a>
            <a href="/accounts/bookmarks/{{ Auth::user()->id }}"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
            <a href="/subscription"><i class="fa-solid fa-credit-card"></i> Subscription</a>
            <div class="nav-dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="logout-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-power-off"></i> Sign Out
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@endguest
