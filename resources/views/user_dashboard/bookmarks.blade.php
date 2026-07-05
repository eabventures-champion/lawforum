@extends('layouts.user')

@section('title', 'My Bookmarks')

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="card-title">My Bookmarks</h1>
            <p class="card-subtitle" style="margin-bottom: 0;">Access all your saved legislation clauses, decrees, and articles.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-banner alert-banner-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="table-responsive">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Article / Act</th>
                    <th>Category Group</th>
                    <th>Date Added</th>
                    <th style="width: 220px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order_by_dates as $bookmark)
                    @php
                        // Determine the correct route link
                        $url = '#';
                        if ($bookmark->act_group == 'Judiciary') {
                            $url = "/post-1992-legislation/constitutional-acts-table-of-content/{$bookmark->act_group}/{$bookmark->act_title}/{$bookmark->act_id}";
                        } elseif ($bookmark->act_group == 'Acts of Parliament') {
                            $url = "/post-1992-legislation/table-of-content/{$bookmark->act_group}/{$bookmark->act_title}/{$bookmark->act_id}";
                        } elseif ($bookmark->act_group == 'Legislative Instruments') {
                            $url = "/post_1992_legislation/regulation_acts_table_of_content/{$bookmark->act_group}/{$bookmark->act_title}/{$bookmark->act_id}";
                        } elseif (in_array($bookmark->act_group, ['First Republic', 'Second Republic', 'Third Republic', 'NLC Decree', 'NRC Decree', 'SMC Decree', 'AFRC Decree'])) {
                            $url = "/pre_1992_legislation/{$bookmark->act_group}/{$bookmark->act_title}/{$bookmark->act_id}";
                        } else {
                            $url = "/post-1992-legislation/executive-acts-table-of-content/{$bookmark->act_group}/{$bookmark->act_title}/{$bookmark->act_id}";
                        }
                    @endphp
                    <tr>
                        <td>
                            <a href="{{ $url }}" target="_blank" style="color: #60a5fa; font-weight: 600; text-decoration: none; display: block; margin-bottom: 4px;">
                                {{ $bookmark->act_section }}
                            </a>
                            <span style="font-size: 13px; color: var(--text-secondary); display: block; max-width: 480px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $bookmark->act_title }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-blue">{{ $bookmark->act_group }}</span>
                        </td>
                        <td style="color: var(--text-secondary); font-size: 13.5px;">
                            {{ date("F j, Y", strtotime($bookmark->created_at)) }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                <a href="{{ $url }}" target="_blank" class="btn-nav btn-nav-secondary" style="padding: 6px 12px; font-size: 12.5px;">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                                <form action="/bookmarks/{{ $bookmark->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this bookmark?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-danger" style="padding: 6px 12px; font-size: 12.5px;">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 40px 0;">
                            <i class="fa-solid fa-bookmark" style="font-size: 28px; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            You don't have any bookmarks saved yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection