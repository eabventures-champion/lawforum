@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Subscription Plans Management</h1>
        <p class="page-subtitle">Configure pricing tiers, document download allowances, features, and active packages visible on the user subscription page.</p>
    </div>
    <div style="display: flex; gap: 12px; align-items: center; margin-right: 32px;">
        <a href="/subscription" target="_blank" class="btn btn-secondary btn-action" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25);">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live Page
        </a>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary btn-action">
            <i class="fa-solid fa-plus"></i> Add New Plan
        </a>
    </div>
</div>

<!-- Subscribe Button Quick Control Panel -->
<div class="card-table" style="padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; background: rgba(13, 20, 38, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px;">
    <div style="display: flex; align-items: center; gap: 16px;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.25); display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 19px;">
            <i class="fa-solid fa-toggle-on"></i>
        </div>
        <div>
            <div style="font-size: 15px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px;">
                "Subscribe Now" Button Control
            </div>
            <div style="font-size: 13px; color: var(--text-secondary); margin-top: 2px;">
                Instantly disable or enable checkout for all subscription plans at once, or use the 1-click toggles in the table below.
            </div>
        </div>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <form action="{{ route('admin.subscriptions.toggle-all-buttons') }}" method="POST" style="margin: 0;">
            @csrf
            <input type="hidden" name="action" value="disable">
            <button type="submit" class="btn btn-action" style="padding: 8px 16px; font-size: 13px; font-weight: 600; background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="Disable checkout buttons for all subscription packages">
                <i class="fa-solid fa-lock"></i> Disable All Buttons
            </button>
        </form>

        <form action="{{ route('admin.subscriptions.toggle-all-buttons') }}" method="POST" style="margin: 0;">
            @csrf
            <input type="hidden" name="action" value="enable">
            <button type="submit" class="btn btn-action" style="padding: 8px 16px; font-size: 13px; font-weight: 600; background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="Enable checkout buttons for all subscription packages">
                <i class="fa-solid fa-lock-open"></i> Enable All Buttons
            </button>
        </form>
    </div>
</div>

<div class="card-table">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 45px;">#</th>
                <th style="min-width: 170px;">Plan Name & Badge</th>
                <th style="min-width: 120px;">Duration (Days)</th>
                <th style="min-width: 100px;">Downloads</th>
                <th style="width: 120px;">Plan Status</th>
                <th style="width: 150px;">Subscribe Button</th>
                <th style="width: 160px; text-align: right; padding-right: 24px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $index => $plan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <span style="font-weight: 700; font-size: 15px; color: #fff;">{{ $plan->type }}</span>
                                @if($plan->is_popular)
                                    <span style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.4); padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                        {{ $plan->badge ?: 'Most Popular' }}
                                    </span>
                                @elseif($plan->badge)
                                    <span style="background: rgba(245, 158, 11, 0.18); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                        {{ $plan->badge }}
                                    </span>
                                @endif
                            </div>
                            <div>
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.32); padding: 2.5px 9px; border-radius: 6px; font-size: 12px; font-weight: 700; letter-spacing: 0.2px;">
                                    <i class="fa-solid fa-tag" style="font-size: 10px; opacity: 0.85;"></i> GHS {{ number_format($plan->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: #cbd5e1;">{{ $plan->duration }} days</span>
                        <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">
                            @if($plan->duration >= 365)
                                ~{{ round($plan->duration / 365, 1) }} year
                            @elseif($plan->duration >= 30)
                                ~{{ round($plan->duration / 30, 1) }} months
                            @else
                                {{ $plan->duration }} days
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($plan->no_downloads >= 10000)
                            <span style="background: rgba(16, 185, 129, 0.12); color: #34d399; padding: 3px 9px; border-radius: 6px; font-size: 11.5px; font-weight: 700;">Unlimited</span>
                        @else
                            <span style="font-weight: 600; color: #f1f5f9;">{{ number_format($plan->no_downloads) }}</span>
                            <span style="font-size: 11px; color: var(--text-secondary);">docs</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.subscriptions.toggle', $plan->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Click to toggle plan visibility on pricing page">
                                @if($plan->is_active)
                                    <span style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span> Active
                                    </span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #ef4444;"></span> Inactive
                                    </span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.subscriptions.toggle-button', $plan->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Click to {{ $plan->is_button_disabled ? 'enable' : 'disable' }} Subscribe Now button for this plan">
                                @if(!$plan->is_button_disabled)
                                    <span style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-check" style="font-size: 10px;"></i> Enabled
                                    </span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-lock" style="font-size: 10px;"></i> Disabled
                                    </span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td style="text-align: right; padding-right: 24px;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('admin.subscriptions.edit', $plan->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 14px; font-size: 13px;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.subscriptions.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subscription plan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action" style="padding: 6px 14px; font-size: 13px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.2s;" title="Delete Plan">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 48px; color: var(--text-secondary);">
                        <i class="fa-solid fa-credit-card" style="font-size: 28px; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                        No subscription plans found. Click "Add New Plan" to create one.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
