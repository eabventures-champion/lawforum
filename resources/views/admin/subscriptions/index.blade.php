@extends('layouts.admin')

@section('title', 'Subscription Plans')

@section('styles')
<style>
    .sub-table th {
        padding: 14px 14px !important;
        font-size: 12px !important;
        letter-spacing: 0.4px !important;
        white-space: nowrap !important;
    }
    .sub-table td {
        padding: 14px 14px !important;
        font-size: 13.5px !important;
        vertical-align: middle !important;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Subscription Plans Management</h1>
        <p class="page-subtitle">Configure pricing tiers, document download allowances, duration text, badges, features, and active packages visible on the user subscription page.</p>
    </div>
    <div style="display: flex; gap: 12px; align-items: center; margin-right: 32px; flex-wrap: wrap;">
        <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-secondary btn-action" style="background: rgba(245, 158, 11, 0.1); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);">
            <i class="fa-solid fa-key"></i> Payment Gateway Keys
        </a>
        <a href="/subscription" target="_blank" class="btn btn-secondary btn-action" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25);">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Live Page
        </a>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary btn-action">
            <i class="fa-solid fa-plus"></i> Add New Plan
        </a>
    </div>
</div>

<!-- Subscribe Button Quick Control Panel -->
<div class="card-table" style="padding: 18px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; background: rgba(13, 20, 38, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px;">
    <div style="display: flex; align-items: center; gap: 16px;">
        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.25); display: flex; align-items: center; justify-content: center; color: #60a5fa; font-size: 18px;">
            <i class="fa-solid fa-toggle-on"></i>
        </div>
        <div>
            <div style="font-size: 15px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px;">
                "Subscribe Now" Button Control
            </div>
            <div style="font-size: 13px; color: var(--text-secondary); margin-top: 2px;">
                Instantly disable or enable checkout for all subscription plans at once, or use individual toggles in the table below.
            </div>
        </div>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <form action="{{ route('admin.subscriptions.toggle-all-buttons') }}" method="POST" style="margin: 0;">
            @csrf
            <input type="hidden" name="action" value="disable">
            <button type="submit" class="btn btn-action" style="padding: 7px 14px; font-size: 13px; font-weight: 600; background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="Disable checkout buttons for all subscription packages">
                <i class="fa-solid fa-lock"></i> Disable All Buttons
            </button>
        </form>

        <form action="{{ route('admin.subscriptions.toggle-all-buttons') }}" method="POST" style="margin: 0;">
            @csrf
            <input type="hidden" name="action" value="enable">
            <button type="submit" class="btn btn-action" style="padding: 7px 14px; font-size: 13px; font-weight: 600; background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;" title="Enable checkout buttons for all subscription packages">
                <i class="fa-solid fa-lock-open"></i> Enable All Buttons
            </button>
        </form>
    </div>
</div>

<div class="card-table" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
    <table class="custom-table sub-table" style="width: 100%; min-width: 900px;">
        <thead>
            <tr>
                <th style="width: 40px; text-align: center;">#</th>
                <th style="min-width: 160px;">Plan & Price</th>
                <th style="min-width: 120px;">Duration</th>
                <th style="min-width: 150px;">Downloads & Highlight</th>
                <th style="min-width: 90px; text-align: center;">Features</th>
                <th style="min-width: 95px; text-align: center;">Status</th>
                <th style="min-width: 100px; text-align: center;">Button</th>
                <th style="min-width: 140px; text-align: right; padding-right: 20px !important;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $index => $plan)
                <tr>
                    <td style="text-align: center; color: var(--text-secondary); font-weight: 600;">
                        {{ $index + 1 }}
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                <a href="{{ route('admin.subscriptions.edit', $plan->id) }}" style="font-weight: 700; font-size: 15px; color: #fff; text-decoration: none;" onmouseover="this.style.color='#60a5fa'" onmouseout="this.style.color='#fff'" title="Click to edit {{ $plan->type }}">
                                    {{ $plan->type }}
                                </a>
                                @if($plan->is_popular)
                                    <span style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.4); padding: 1.5px 7px; border-radius: 5px; font-size: 10.5px; font-weight: 700;">
                                        {{ $plan->badge ?: 'Most Popular' }}
                                    </span>
                                @elseif($plan->badge)
                                    <span style="background: rgba(245, 158, 11, 0.18); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.35); padding: 1.5px 7px; border-radius: 5px; font-size: 10.5px; font-weight: 700;">
                                        {{ $plan->badge }}
                                    </span>
                                @endif
                            </div>
                            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 2px 8px; border-radius: 6px; font-size: 11.5px; font-weight: 700;">
                                    <i class="fa-solid fa-tag" style="font-size: 9.5px; opacity: 0.85;"></i> {{ $plan->currency ?? 'GHS' }} {{ number_format($plan->price, 2) }}
                                </span>
                                <span style="display: inline-flex; align-items: center; gap: 4px; background: rgba(59, 130, 246, 0.12); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.25); padding: 2px 7px; border-radius: 5px; font-size: 10.5px; font-weight: 600;" title="Allowed team seats">
                                    <i class="fa-solid fa-users" style="font-size: 9px;"></i> {{ $plan->display_seats }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #cbd5e1;">{{ $plan->duration }} days</div>
                        <div style="font-size: 12px; color: #60a5fa; margin-top: 2px; font-weight: 600;">
                            {{ $plan->display_duration }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 13px; font-weight: 600; color: #f1f5f9;">
                            @if($plan->no_downloads >= 10000)
                                <span style="background: rgba(16, 185, 129, 0.12); color: #34d399; padding: 2px 7px; border-radius: 5px; font-size: 11px; font-weight: 700;">Unlimited</span>
                            @else
                                {{ number_format($plan->no_downloads) }} downloads
                            @endif
                        </div>
                        <div style="font-size: 11.5px; color: var(--text-secondary); margin-top: 2px; max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $plan->display_highlight }}">
                            <i class="fa-solid fa-file-arrow-down" style="font-size: 10px; color: #60a5fa;"></i> {{ $plan->display_highlight }}
                        </div>
                    </td>
                    <td style="text-align: center;">
                        @php
                            $featureCount = count($plan->feature_list);
                        @endphp
                        <a href="{{ route('admin.subscriptions.edit', $plan->id) }}" style="display: inline-flex; align-items: center; gap: 5px; background: rgba(59, 130, 246, 0.12); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.25); padding: 3px 8px; border-radius: 6px; font-size: 11.5px; font-weight: 600; text-decoration: none;" title="Click to edit {{ $featureCount }} bullet points">
                            <i class="fa-solid fa-list-check" style="font-size: 10.5px;"></i> {{ $featureCount }} bullets
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.subscriptions.toggle', $plan->id) }}" method="POST" style="display: inline-block; margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Click to toggle plan visibility on pricing page">
                                @if($plan->is_active)
                                    <span style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 3.5px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span> Active
                                    </span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); padding: 3.5px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #ef4444;"></span> Inactive
                                    </span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.subscriptions.toggle-button', $plan->id) }}" method="POST" style="display: inline-block; margin: 0;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; padding: 0;" title="Click to {{ $plan->is_button_disabled ? 'enable' : 'disable' }} Subscribe Now button for this plan">
                                @if(!$plan->is_button_disabled)
                                    <span style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 3.5px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-check" style="font-size: 9.5px;"></i> Enabled
                                    </span>
                                @else
                                    <span style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 3.5px 10px; border-radius: 100px; font-size: 11.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-lock" style="font-size: 9.5px;"></i> Disabled
                                    </span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td style="text-align: right; padding-right: 20px !important; white-space: nowrap;">
                        <div style="display: inline-flex; gap: 8px; justify-content: flex-end; align-items: center;">
                            <a href="{{ route('admin.subscriptions.edit', $plan->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12.5px; display: inline-flex; align-items: center; gap: 5px; font-weight: 600;" title="Edit all card contents">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.subscriptions.destroy', $plan->id) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Are you sure you want to delete this subscription plan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action" style="padding: 6px 10px; font-size: 12.5px; background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 8px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;" title="Delete Plan">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 48px; color: var(--text-secondary);">
                        <i class="fa-solid fa-credit-card" style="font-size: 28px; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                        No subscription plans found. Click "Add New Plan" to create one.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
