@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 class="page-title">Welcome Back, {{ Auth::user()->name ?? 'Admin' }}</h1>
        <p class="page-subtitle">Here is what's happening on Lawsforum today.</p>
    </div>
    <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; padding: 10px 18px; border-radius: 12px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #cbd5e1; text-decoration: none; margin-right: 16px;">
        <i class="fa-solid fa-user-gear"></i>
        <span>Admin Profile</span>
    </a>
</div>

<!-- Stats Grid -->
<div class="grid-stats">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Users</span>
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
        </div>
        <div class="stat-value">{{ $totalUsers }}</div>
    </div>

    <div class="stat-card clickable-card" onclick="openSubscriptionsModal()" style="cursor: pointer; transition: transform 0.2s, border-color 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='rgba(59,130,246,0.3)';" onmouseout="this.style.transform='none'; this.style.borderColor='';" title="Click to view details">
        <div class="stat-header">
            <span class="stat-title">Active Subscriptions</span>
            <div class="stat-icon" style="color: var(--success-color);"><i class="fa-solid fa-circle-check"></i></div>
        </div>
        <div class="stat-value" style="display: flex; align-items: center; gap: 8px;">
            {{ $activeSubscriptions }}
            <span style="font-size: 11px; font-weight: 600; color: var(--success-color); background: rgba(16, 185, 129, 0.1); padding: 2px 8px; border-radius: 10px;">View Details</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">News Articles</span>
            <div class="stat-icon" style="color: #eab308;"><i class="fa-solid fa-newspaper"></i></div>
        </div>
        <div class="stat-value">{{ $totalNews }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Total Laws & Acts</span>
            <div class="stat-icon" style="color: #ec4899;"><i class="fa-solid fa-gavel"></i></div>
        </div>
        <div class="stat-value">{{ $totalLaws }}</div>
    </div>
</div>

<style>
    .recent-toggle-container {
        display: inline-flex;
        align-items: center;
        background: rgba(15, 23, 42, 0.7);
        padding: 4px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        gap: 4px;
    }
    .recent-tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 9px;
        font-size: 13.5px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        background: transparent;
        color: var(--text-secondary);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }
    .recent-tab-btn:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.05);
    }
    .recent-tab-btn.active {
        background: var(--accent-gradient);
        color: #fff;
        box-shadow: 0 4px 14px var(--accent-glow);
    }
    .recent-tab-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        padding: 0 7px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.1);
        color: #cbd5e1;
        transition: all 0.2s ease;
    }
    .recent-tab-btn.active .recent-tab-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }
    .recent-tab-panel {
        animation: fadeInTab 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    @keyframes fadeInTab {
        from {
            opacity: 0;
            transform: translateY(4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- Full-Width Recent Activities Section with Toggle -->
<div class="card-table" style="width: 100%; margin-bottom: 40px;">
    <!-- Toggle Header -->
    <div class="table-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding: 20px 24px;">
        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
            <!-- Segmented Switcher -->
            <div class="recent-toggle-container">
                <button type="button" id="tab-btn-signups" onclick="switchRecentTab('signups')" class="recent-tab-btn active">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Recent Signups</span>
                    <span class="recent-tab-badge">{{ count($recentUsers) }}</span>
                </button>
                <button type="button" id="tab-btn-news" onclick="switchRecentTab('news')" class="recent-tab-btn">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>Recent News</span>
                    <span class="recent-tab-badge">{{ count($recentNews) }}</span>
                </button>
            </div>

            <!-- Subtitle info -->
            <div style="font-size: 13px; color: var(--text-secondary);">
                <span id="tab-meta-signups"><i class="fa-solid fa-circle-info" style="margin-right: 4px; color: var(--accent-color);"></i> Latest registered members on Lawsforum</span>
                <span id="tab-meta-news" style="display: none;"><i class="fa-solid fa-circle-info" style="margin-right: 4px; color: #eab308;"></i> Latest published articles and legal updates</span>
            </div>
        </div>

        <!-- Dynamic View All Action Button -->
        <div>
            <a id="view-all-signups-btn" href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-action" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 8px;">
                <span>View All Users</span>
                <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
            </a>
            <a id="view-all-news-btn" href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-action" style="display: none; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 8px;">
                <span>View All News</span>
                <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
            </a>
        </div>
    </div>

    <!-- Panel 1: Recent Signups Table (Full Width) -->
    <div id="panel-recent-signups" class="recent-tab-panel" style="display: block;">
        <div style="overflow-x: auto; width: 100%;">
            <table class="custom-table" style="width: 100%; min-width: 750px;">
                <thead>
                    <tr>
                        <th style="padding-left: 24px;">User</th>
                        <th>Email & Contact</th>
                        <th>Subscription Status</th>
                        <th>Registered Date</th>
                        <th style="text-align: right; padding-right: 24px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                        <tr>
                            <td style="padding-left: 24px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.25); color: #60a5fa; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0;">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #fff; font-size: 14px;">{{ $user->name }} {{ $user->lname }}</div>
                                        <div style="margin-top: 4px;">
                                            <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; box-shadow: 0 0 6px rgba(16, 185, 129, 0.15); text-transform: uppercase; letter-spacing: 0.5px;">
                                                <i class="fa-solid fa-globe" style="margin-right: 4px; font-size: 9px;"></i> {{ $user->country ?? 'Ghana' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="color: #fff; font-weight: 500; font-size: 13.5px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-regular fa-envelope" style="color: var(--text-secondary); font-size: 12px;"></i>
                                    <span>{{ $user->email }}</span>
                                </div>
                                <div style="margin-top: 5px; color: var(--text-secondary); font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-phone" style="font-size: 11px;"></i>
                                    <span>{{ $user->phone ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($user->check_subscription && $user->subscription_expiry >= \Carbon\Carbon::today())
                                    <span class="badge badge-success" style="display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-circle-check" style="font-size: 10px;"></i> Active
                                    </span>
                                    <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">
                                        Expires {{ \Carbon\Carbon::parse($user->subscription_expiry)->format('M d, Y') }}
                                    </div>
                                @else
                                    <span class="badge badge-danger" style="display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-circle-xmark" style="font-size: 10px;"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="color: #e2e8f0; font-weight: 500; font-size: 13px;">
                                    {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                                </div>
                                <div style="color: var(--text-secondary); font-size: 11px; margin-top: 3px;">
                                    {{ $user->created_at ? $user->created_at->diffForHumans() : '' }}
                                </div>
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 14px; font-size: 12px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 40px 20px;">
                                <i class="fa-solid fa-users" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5; display: block;"></i>
                                No recent signups found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Panel 2: Recent News Table (Full Width) -->
    <div id="panel-recent-news" class="recent-tab-panel" style="display: none;">
        <div style="overflow-x: auto; width: 100%;">
            <table class="custom-table" style="width: 100%; min-width: 750px;">
                <thead>
                    <tr>
                        <th style="padding-left: 24px; width: 70px;">Thumbnail</th>
                        <th>Article Details</th>
                        <th>Category</th>
                        <th>Published Date</th>
                        <th style="text-align: right; padding-right: 24px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentNews as $article)
                        <tr>
                            <td style="padding-left: 24px;">
                                @if($article->image)
                                    <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : (Str::startsWith($article->image, 'storage/') ? asset($article->image) : asset('storage/' . $article->image)) }}" alt="Thumbnail" style="width: 52px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color); display: block;">
                                @else
                                    <div style="width: 52px; height: 38px; border-radius: 6px; background: rgba(255,255,255,0.04); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; font-size: 14px; color: var(--text-secondary);">
                                        <i class="fa-regular fa-newspaper"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #fff; font-size: 14px; line-height: 1.4; margin-bottom: 4px;">
                                    {{ $article->title }}
                                </div>
                                @if($article->extract)
                                    <div style="font-size: 12px; color: var(--text-secondary); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 650px;">
                                        {{ $article->extract }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-accent" style="white-space: nowrap;">
                                    {{ $article->news_category }}
                                </span>
                            </td>
                            <td>
                                <div style="color: #e2e8f0; font-weight: 500; font-size: 13px; white-space: nowrap;">
                                    {{ $article->created_at ? $article->created_at->format('M d, Y') : 'N/A' }}
                                </div>
                                <div style="color: var(--text-secondary); font-size: 11px; margin-top: 3px; white-space: nowrap;">
                                    {{ $article->created_at ? $article->created_at->diffForHumans() : '' }}
                                </div>
                            </td>
                            <td style="text-align: right; padding-right: 24px;">
                                <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 14px; font-size: 12px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 40px 20px;">
                                <i class="fa-solid fa-newspaper" style="font-size: 24px; margin-bottom: 8px; opacity: 0.5; display: block;"></i>
                                No news articles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Active Subscriptions Details Modal -->
<div id="subscriptions-modal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(8px); align-items: center; justify-content: center;">
    <div style="background: #111827; border: 1px solid var(--border-color); border-radius: 16px; width: 640px; max-width: 95%; max-height: 80vh; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); display: flex; flex-direction: column;">
        
        <!-- Modal Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-circle-check" style="color: var(--success-color);"></i> Active Subscribers Details
            </h3>
            <button type="button" onclick="closeSubscriptionsModal()" style="background: transparent; border: none; color: var(--text-secondary); cursor: pointer; font-size: 18px; line-height: 1;">&times;</button>
        </div>

        <!-- Modal Body -->
        <div style="flex: 1; overflow-y: auto; margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color); background: rgba(255,255,255,0.02);">
                        <th style="padding: 12px 16px; color: var(--text-secondary); font-size: 11px; font-weight: 600; text-transform: uppercase;">Name</th>
                        <th style="padding: 12px 16px; color: var(--text-secondary); font-size: 11px; font-weight: 600; text-transform: uppercase;">Email</th>
                        <th style="padding: 12px 16px; color: var(--text-secondary); font-size: 11px; font-weight: 600; text-transform: uppercase;">Country</th>
                        <th style="padding: 12px 16px; color: var(--text-secondary); font-size: 11px; font-weight: 600; text-transform: uppercase;">Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeSubscribers as $subscriber)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 12px 16px; color: #fff; font-size: 14px;">{{ $subscriber->name }} {{ $subscriber->lname }}</td>
                            <td style="padding: 12px 16px; color: var(--text-secondary); font-size: 13px;">{{ $subscriber->email }}</td>
                            <td style="padding: 12px 16px; color: var(--text-secondary); font-size: 13px;">{{ $subscriber->country ?? 'N/A' }}</td>
                            <td style="padding: 12px 16px; color: #10b981; font-size: 13px; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($subscriber->subscription_expiry)->format('Y-m-d') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 32px 16px; text-align: center; color: var(--text-secondary);">
                                No active subscribers found at this moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Footer -->
        <div style="display: flex; justify-content: flex-end;">
            <button type="button" class="btn btn-secondary btn-action" onclick="closeSubscriptionsModal()" style="height: 38px; padding: 0 16px; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

<script>
    // Tab switching functionality with local persistence
    function switchRecentTab(tab) {
        const panelSignups = document.getElementById('panel-recent-signups');
        const panelNews = document.getElementById('panel-recent-news');
        const tabSignups = document.getElementById('tab-btn-signups');
        const tabNews = document.getElementById('tab-btn-news');
        const metaSignups = document.getElementById('tab-meta-signups');
        const metaNews = document.getElementById('tab-meta-news');
        const viewAllSignups = document.getElementById('view-all-signups-btn');
        const viewAllNews = document.getElementById('view-all-news-btn');

        if (tab === 'signups') {
            panelSignups.style.display = 'block';
            panelNews.style.display = 'none';
            tabSignups.classList.add('active');
            tabNews.classList.remove('active');
            metaSignups.style.display = 'inline';
            metaNews.style.display = 'none';
            viewAllSignups.style.display = 'inline-flex';
            viewAllNews.style.display = 'none';
        } else {
            panelSignups.style.display = 'none';
            panelNews.style.display = 'block';
            tabNews.classList.add('active');
            tabSignups.classList.remove('active');
            metaSignups.style.display = 'none';
            metaNews.style.display = 'inline';
            viewAllSignups.style.display = 'none';
            viewAllNews.style.display = 'inline-flex';
        }

        try {
            localStorage.setItem('lawsforum_admin_recent_tab', tab);
        } catch (e) {}
    }

    document.addEventListener('DOMContentLoaded', function() {
        try {
            const savedTab = localStorage.getItem('lawsforum_admin_recent_tab');
            if (savedTab === 'news') {
                switchRecentTab('news');
            }
        } catch (e) {}
    });

    function openSubscriptionsModal() {
        document.getElementById('subscriptions-modal').style.display = 'flex';
    }

    function closeSubscriptionsModal() {
        document.getElementById('subscriptions-modal').style.display = 'none';
    }
</script>
@endsection
