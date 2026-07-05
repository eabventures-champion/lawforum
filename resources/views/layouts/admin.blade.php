<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | Lawsforum</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-scale-balanced fa-lg" style="color: #3b82f6;"></i>
            <div class="sidebar-logo">Lawsforum Admin</div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item {{ Request::is('admin') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Users Management</span>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/news*') ? 'active' : '' }}">
                <a href="{{ route('admin.news.index') }}">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>News & Articles</span>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/laws*') ? 'active' : '' }}">
                <a href="{{ route('admin.laws.index') }}">
                    <i class="fa-solid fa-book-bookmark"></i>
                    <span>Laws & Acts</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Flash Message Container -->
        @if(session('success'))
            <div class="stat-card" style="border-left: 4px solid var(--success-color); margin-bottom: 24px; padding: 16px 24px; flex-direction: row; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-circle-check" style="color: var(--success-color); font-size: 20px;"></i>
                    <span style="font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="stat-card" style="border-left: 4px solid var(--danger-color); margin-bottom: 24px; padding: 16px 24px; flex-direction: row; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-triangle-exclamation" style="color: var(--danger-color); font-size: 20px;"></i>
                    <span style="font-size: 14px; font-weight: 500;">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
