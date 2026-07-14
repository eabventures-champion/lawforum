@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Welcome Back, Admin</h1>
        <p class="page-subtitle">Here is what's happening on Lawsforum today.</p>
    </div>
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

<!-- Recent Sections -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 32px;">
    <!-- Recent Signups -->
    <div class="card-table">
        <div class="table-header">
            <h2 class="table-title">Recent Signups</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-action">View All</a>
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subscribed</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                    <tr>
                        <td>
                            <div style="font-weight: 600; color: #fff;">{{ $user->name }} {{ $user->lname }}</div>
                            <div style="margin-top: 4px;">
                                <span style="display: inline-flex; align-items: center; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; box-shadow: 0 0 6px rgba(16, 185, 129, 0.15); text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fa-solid fa-globe" style="margin-right: 4px; font-size: 9px;"></i> {{ $user->country ?? 'Ghana' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div style="color: #fff; font-weight: 500;">{{ $user->email }}</div>
                            <div style="margin-top: 4px; color: var(--text-secondary); font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-phone" style="font-size: 10px;"></i> {{ $user->phone ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            @if($user->check_subscription && $user->subscription_expiry >= \Carbon\Carbon::today())
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-secondary);">No recent users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Recent News -->
    <div class="card-table">
        <div class="table-header">
            <h2 class="table-title">Recent News</h2>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-action">View All</a>
        </div>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentNews as $article)
                    <tr>
                        <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $article->title }}
                        </td>
                        <td><span class="badge badge-accent">{{ $article->news_category }}</span></td>
                        <td>{{ $article->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-secondary);">No news articles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
    function openSubscriptionsModal() {
        document.getElementById('subscriptions-modal').style.display = 'flex';
    }

    function closeSubscriptionsModal() {
        document.getElementById('subscriptions-modal').style.display = 'none';
    }
</script>
@endsection
