<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Legals Forum</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-primary: #040814;
            --bg-glow: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.08) 0%, transparent 60%);
            --card-bg: rgba(13, 20, 38, 0.45);
            --border-color: rgba(255, 255, 255, 0.08);
            --accent-color: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.25);
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            background-image: var(--bg-glow);
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
            padding: 100px 20px 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-x: hidden;
        }

        /* Ambient background blobs */
        .ambient-blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: rgba(59, 130, 246, 0.05);
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            pointer-events: none;
        }

        .ambient-blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 50vw;
            height: 50vw;
            background: rgba(236, 72, 153, 0.03);
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            pointer-events: none;
        }

        /* Sticky Header wrapper */
        .header-sticky-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(4, 8, 20, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            z-index: 9999;
            display: flex;
            justify-content: center;
            padding: 16px 20px;
        }

        /* Header Navigation bar */
        .dashboard-header {
            width: 100%;
            max-width: 1100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--accent-gradient);
            box-shadow: 0 8px 20px var(--accent-glow);
            font-size: 18px;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--danger-color);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition-smooth);
        }

        .btn-logout:hover {
            background: var(--danger-color);
            color: #fff;
            transform: translateY(-1px);
        }

        /* Main Container layout */
        .dashboard-container {
            width: 100%;
            max-width: 1100px;
            z-index: 10;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* User Profile Summary Card */
        .profile-hero {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .avatar-circle {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: var(--accent-color);
            font-weight: 700;
        }

        .user-meta-name {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .user-meta-email {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .subscription-badge {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            padding: 8px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--success-color);
        }

        .subscription-badge.inactive {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: var(--danger-color);
        }

        /* Action Grid */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
        }

        /* Portal Action Card */
        .portal-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 28px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }

        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, transparent 100%);
            opacity: 0;
            transition: var(--transition-smooth);
        }

        .portal-card:hover {
            transform: translateY(-6px);
            border-color: var(--accent-color);
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
        }

        .portal-card:hover::before {
            opacity: 1;
        }

        .portal-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--accent-color);
            transition: var(--transition-smooth);
        }

        .portal-card:hover .portal-icon-wrapper {
            background: var(--accent-gradient);
            color: #fff;
            box-shadow: 0 6px 15px var(--accent-glow);
            border-color: transparent;
        }

        .portal-title {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
        }

        .portal-desc {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Specific card configurations */
        .portal-card.admin-card {
            border-color: rgba(245, 158, 11, 0.2);
        }

        .portal-card.admin-card:hover {
            border-color: #f59e0b;
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.15);
        }

        .portal-card.admin-card .portal-icon-wrapper {
            color: #f59e0b;
        }

        .portal-card.admin-card:hover .portal-icon-wrapper {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #fff;
            box-shadow: 0 6px 15px rgba(245, 158, 11, 0.25);
        }
    </style>
</head>
<body>

    <div class="ambient-blob-1"></div>
    <div class="ambient-blob-2"></div>

    <!-- Header Navigation Wrapper -->
    <div class="header-sticky-wrapper" id="stickyHeader">
        <header class="dashboard-header">
            <a href="/" class="brand-link">
                <div class="brand-logo">
                    <i class="fa fa-balance-scale"></i>
                </div>
                <span class="brand-title">Legals Forum</span>
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Sign Out</span>
            </a>
        </header>
    </div>

    <!-- Main Dashboard Body -->
    <main class="dashboard-container">
        
        <!-- Profile Banner -->
        <div class="profile-hero">
            <div class="user-info">
                <div class="avatar-circle">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="user-meta-name">Welcome back, {{ auth()->user()->name }} {{ auth()->user()->lname }}!</h2>
                    <p class="user-meta-email">{{ auth()->user()->email }}</p>
                </div>
            </div>
            
            <!-- Subscription Check -->
            @if(auth()->user()->check_subscription && auth()->user()->subscription_expiry && \Carbon\Carbon::parse(auth()->user()->subscription_expiry)->isFuture())
                <div class="subscription-badge">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Premium Member (Expires {{ \Carbon\Carbon::parse(auth()->user()->subscription_expiry)->format('M d, Y') }})</span>
                </div>
            @else
                <div class="subscription-badge inactive">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Free Plan (No active subscription)</span>
                </div>
            @endif
        </div>

        <!-- Quick Access Portal Grid -->
        <div class="actions-grid">
            <!-- Laws Catalog -->
            <a href="/" class="portal-card">
                <div class="portal-icon-wrapper">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <h3 class="portal-title">Laws Catalog</h3>
                <p class="portal-desc">Search legal documents, preambles, and download official law PDFs.</p>
            </a>

            <!-- Admin Control Panel (Administrators Only) -->
            @if(auth()->user()->isAdmin())
                <a href="/admin" class="portal-card admin-card">
                    <div class="portal-icon-wrapper">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="portal-title">Admin Dashboard</h3>
                    <p class="portal-desc">Manage law databases, news articles, categories, and system user profiles.</p>
                </a>
            @endif

            <!-- My Bookmarks -->
            <a href="/accounts/bookmarks/{{ auth()->user()->id }}" class="portal-card">
                <div class="portal-icon-wrapper">
                    <i class="fa-solid fa-bookmark"></i>
                </div>
                <h3 class="portal-title">My Bookmarks</h3>
                <p class="portal-desc">View your compiled list of saved law sections and referenced articles.</p>
            </a>

            <!-- My Notes -->
            <a href="/accounts/notes/{{ auth()->user()->id }}" class="portal-card">
                <div class="portal-icon-wrapper">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <h3 class="portal-title">My Notes</h3>
                <p class="portal-desc">Access, organize, and edit your personal study notes and text highlights.</p>
            </a>

            <!-- My Downloads -->
            <a href="/accounts/downloads/{{ auth()->user()->id }}" class="portal-card">
                <div class="portal-icon-wrapper">
                    <i class="fa-solid fa-cloud-arrow-down"></i>
                </div>
                <h3 class="portal-title">My Downloads</h3>
                <p class="portal-desc">Access your history of downloaded Acts, PDF documents, and downloads remaining.</p>
            </a>

            <!-- Subscription Packages -->
            <a href="/subscription" class="portal-card">
                <div class="portal-icon-wrapper">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <h3 class="portal-title">Subscription Status</h3>
                <p class="portal-desc">Upgrade, configure, or renew your subscription packages to unlock PDF downloads.</p>
            </a>

            <!-- Account Settings -->
            <a href="/accounts/profile/{{ auth()->user()->id }}" class="portal-card">
                <div class="portal-icon-wrapper">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <h3 class="portal-title">Profile Settings</h3>
                <p class="portal-desc">Update your personal contact details, country region, and billing profile details.</p>
            </a>

            <!-- Manage Password -->
            <a href="/accounts/manage-password" class="portal-card">
                <div class="portal-icon-wrapper">
                    <i class="fa-solid fa-key"></i>
                </div>
                <h3 class="portal-title">Security & Password</h3>
                <p class="portal-desc">Ensure account security by updating and resetting your login password credentials.</p>
            </a>
        </div>

    </main>

</body>
</html>
