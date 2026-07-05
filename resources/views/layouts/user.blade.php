<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | LawsGhana</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom User CSS -->
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    
    @yield('styles')
</head>
<body>

    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <!-- Header Navigation Wrapper -->
    <div class="header-sticky-wrapper" id="stickyHeader">
        <header class="dashboard-header">
            <a href="/" class="brand-link">
                <div class="brand-logo">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <span class="brand-title">LawsGhana</span>
            </a>
            
            <div class="header-actions">
                <a href="/home" class="btn-nav btn-nav-secondary">
                    <i class="fa-solid fa-house"></i>
                    <span>Portal Hub</span>
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="btn-nav btn-nav-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Sign Out</span>
                </a>
            </div>
        </header>
    </div>

    <!-- Tab Bar -->
    <nav class="user-tabs-bar">
        <a href="/accounts/profile/{{ auth()->user()->id }}" class="tab-link {{ request()->is('accounts/profile*') ? 'active' : '' }}">
            <i class="fa-solid fa-user-gear"></i> Profile
        </a>
        <a href="/accounts/manage-password" class="tab-link {{ request()->is('accounts/manage-password*') ? 'active' : '' }}">
            <i class="fa-solid fa-key"></i> Security
        </a>
        <a href="/accounts/bookmarks/{{ auth()->user()->id }}" class="tab-link {{ request()->is('accounts/bookmarks*') ? 'active' : '' }}">
            <i class="fa-solid fa-bookmark"></i> Bookmarks
        </a>
        <a href="/accounts/downloads/{{ auth()->user()->id }}" class="tab-link {{ request()->is('accounts/downloads*') ? 'active' : '' }}">
            <i class="fa-solid fa-cloud-arrow-down"></i> Downloads
        </a>
        <a href="/subscription" class="tab-link {{ request()->is('subscription*') ? 'active' : '' }}">
            <i class="fa-solid fa-star"></i> Subscription Plan
        </a>
    </nav>

    <!-- Main Content Area -->
    <main class="main-wrapper">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
