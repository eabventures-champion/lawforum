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
            <i class="fa fa-balance-scale fa-lg" style="color: #3b82f6;"></i>
            <div class="sidebar-logo">Lawsforum Admin</div>
            <button id="toggle-sidebar" class="sidebar-toggle-btn" title="Toggle Sidebar">
                <i class="fa-solid fa-angles-left"></i>
            </button>
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
            <li class="menu-item {{ Request::is('admin/notifications*') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.index') }}" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-bell"></i>
                        <span>Notifications</span>
                    </div>
                    @php
                        $unreadNotificationsCount = \App\AdminNotification::whereNull('read_at')->count();
                    @endphp
                    @if($unreadNotificationsCount > 0)
                        <span style="background-color: #ef4444; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; line-height: 1;">{{ $unreadNotificationsCount }}</span>
                    @endif
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
            <li class="menu-item {{ Request::is('admin/homepage-settings*') ? 'active' : '' }}">
                <a href="{{ route('admin.homepage-settings.index') }}">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Homepage Settings</span>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/homepage-custom-slides*') ? 'active' : '' }}">
                <a href="{{ route('admin.homepage-custom-slides.index') }}">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Custom Slide Panels</span>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/navigation-menus*') ? 'active' : '' }}">
                <a href="{{ route('navigation-menus.index') }}">
                    <i class="fa-solid fa-bars"></i>
                    <span>Header Menus</span>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/sidebar-ads*') ? 'active' : '' }}">
                <a href="{{ route('admin.sidebar-ads.index') }}">
                    <i class="fa-solid fa-rectangle-ad"></i>
                    <span>Sidebar Ads</span>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/maintenance-settings*') ? 'active' : '' }}">
                <a href="{{ route('admin.maintenance-settings.index') }}">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Maintenance Mode</span>
                    @if(maintenance_setting('maintenance_enabled', false))
                        <span style="width: 8px; height: 8px; background: #ef4444; border-radius: 50%; display: inline-block; margin-left: 6px; animation: pulse 2s infinite;"></span>
                    @endif
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
        @if(session('success') || session('error'))
            @php
                $isSuccess = session('success');
                $message = $isSuccess ? session('success') : session('error');
                $accentColor = $isSuccess ? 'var(--success-color)' : 'var(--danger-color)';
                $iconClass = $isSuccess ? 'fa-solid fa-circle-check' : 'fa-solid fa-triangle-exclamation';
                $alertId = $isSuccess ? 'flash-success' : 'flash-error';
            @endphp
            <div id="{{ $alertId }}" class="flash-alert" style="
                background: rgba(18, 24, 36, 0.95);
                border: 1px solid {{ $isSuccess ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' }};
                border-left: 4px solid {{ $accentColor }};
                border-radius: 12px;
                padding: 16px 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: 32px;
                margin-bottom: 24px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                animation: slideInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                transition: all 0.5s ease;
                position: relative;
                overflow: hidden;
            ">
                <!-- Premium Progress Bar indicating 10s timeout -->
                <div style="
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    height: 3px;
                    width: 100%;
                    background: {{ $accentColor }};
                    opacity: 0.7;
                    transform-origin: left;
                    animation: shrinkProgress 10s linear forwards;
                "></div>

                <div style="display: flex; align-items: center; gap: 12px; z-index: 1;">
                    <i class="{{ $iconClass }}" style="color: {{ $accentColor }}; font-size: 20px;"></i>
                    <span style="font-size: 14px; font-weight: 600; color: #f1f5f9;">{{ $message }}</span>
                </div>
                <button type="button" onclick="dismissFlashAlert('{{ $alertId }}')" style="
                    background: transparent;
                    border: none;
                    color: var(--text-secondary);
                    font-size: 18px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 4px;
                    border-radius: 6px;
                    transition: var(--transition-smooth);
                    outline: none;
                    z-index: 1;
                " onmouseover="this.style.color='#f3f4f6'; this.style.background='rgba(255,255,255,0.05)';" onmouseout="this.style.color='var(--text-secondary)'; this.style.background='transparent';">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Inline script to prevent layout shift/flicker -->
    <script>
        (function() {
            if (localStorage.getItem('admin_sidebar_collapsed') === 'true') {
                document.querySelector('.sidebar').classList.add('collapsed');
                document.querySelector('.main-content').classList.add('collapsed-sidebar');
            }
        })();
    </script>

    <!-- Sidebar Toggle Event Listener -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleIcon = toggleBtn ? toggleBtn.querySelector('i') : null;

            if (toggleBtn && sidebar && mainContent) {
                // Initialize toggle button icon based on active state
                if (sidebar.classList.contains('collapsed') && toggleIcon) {
                    toggleIcon.classList.replace('fa-angles-left', 'fa-angles-right');
                }

                toggleBtn.addEventListener('click', function() {
                    const collapsed = sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed-sidebar', collapsed);
                    
                    if (toggleIcon) {
                        if (collapsed) {
                            toggleIcon.classList.replace('fa-angles-left', 'fa-angles-right');
                        } else {
                            toggleIcon.classList.replace('fa-angles-right', 'fa-angles-left');
                        }
                    }
                    localStorage.setItem('admin_sidebar_collapsed', collapsed);
                });
            }
        });
    </script>

    <!-- Flash Alert Auto-Dismiss Script -->
    <script>
        function dismissFlashAlert(id) {
            const alertEl = document.getElementById(id);
            if (alertEl) {
                alertEl.style.transform = 'translateY(-20px)';
                alertEl.style.opacity = '0';
                setTimeout(() => {
                    alertEl.remove();
                }, 500);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('flash-success');
            const errorAlert = document.getElementById('flash-error');
            
            if (successAlert) {
                setTimeout(() => {
                    dismissFlashAlert('flash-success');
                }, 10000);
            }
            if (errorAlert) {
                setTimeout(() => {
                    dismissFlashAlert('flash-error');
                }, 10000);
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
