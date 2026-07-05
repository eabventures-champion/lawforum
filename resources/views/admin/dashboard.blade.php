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

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-title">Active Subscriptions</span>
            <div class="stat-icon" style="color: var(--success-color);"><i class="fa-solid fa-circle-check"></i></div>
        </div>
        <div class="stat-value">{{ $activeSubscriptions }}</div>
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
                        <td>{{ $user->name }} {{ $user->lname }}</td>
                        <td>{{ $user->email }}</td>
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
@endsection
