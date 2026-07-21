@extends('layouts.admin')

@section('title', 'Sidebar Ads')

@section('styles')
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -12px;
        margin-left: -12px;
    }
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 12px;
        padding-left: 12px;
    }
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    .ad-card {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }
    .ad-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        border-color: rgba(59, 130, 246, 0.3);
    }
    .ad-card-header {
        background: rgba(255, 255, 255, 0.02);
        padding: 18px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ad-card-body {
        padding: 24px;
    }
    .ad-preview-container {
        width: 100%;
        max-height: 250px;
        background: #070a13;
        border-radius: 12px;
        border: 1px dashed rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .ad-preview-image {
        max-width: 100%;
        max-height: 240px;
        object-fit: contain;
    }
    .ad-meta-item {
        margin-bottom: 12px;
    }
    .ad-meta-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .ad-meta-value {
        font-size: 14px;
        color: #f1f5f9;
        font-weight: 500;
        word-break: break-all;
    }
    .status-badge {
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .status-badge.active {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .status-badge.inactive {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fa-solid fa-rectangle-ad" style="color: var(--accent-color); margin-right: 8px;"></i>
            Sidebar Advertisement Slots
        </h1>
        <p class="page-subtitle">Manage the advertisement banners displayed in the right pane column.</p>
    </div>
</div>

<div class="container-fluid px-0">

    <div class="row">
        @foreach($ads as $ad)
            <div class="col-md-6">
                <div class="ad-card">
                    <div class="ad-card-header">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-rectangle-ad mr-2 text-primary" style="font-size: 18px;"></i>
                            <span class="text-white" style="font-weight: 700; font-size: 16px;">{{ $ad->title }}</span>
                        </div>
                        <div>
                            @if($ad->is_active)
                                <span class="status-badge active">Visible</span>
                            @else
                                <span class="status-badge inactive">Hidden</span>
                            @endif
                        </div>
                    </div>
                    <div class="ad-card-body">
                        <div class="ad-preview-container">
                            @if($ad->image_path)
                                <img src="{{ $ad->image_url }}" alt="Ad Preview" class="ad-preview-image">
                            @else
                                <span class="text-muted"><i class="fa-regular fa-image mr-1"></i> No image configured</span>
                            @endif
                        </div>

                        <div class="ad-meta-item">
                            <div class="ad-meta-label">Slot Identifier</div>
                            <div class="ad-meta-value"><code style="background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 4px; color: #a5b4fc;">{{ $ad->slot_name }}</code></div>
                        </div>

                        <div class="ad-meta-item">
                            <div class="ad-meta-label">Fallback Placeholder Type</div>
                            <div class="ad-meta-value">
                                @if($ad->placeholder_type === 'news_feed')
                                    <span class="text-info" style="font-weight: 600;"><i class="fa-solid fa-square-rss mr-1"></i> Daily News & Blogs Feed Slider</span>
                                @else
                                    <span class="text-warning" style="font-weight: 600;"><i class="fa-solid fa-rectangle-ad mr-1"></i> Advertise Product CTA Banner</span>
                                @endif
                            </div>
                        </div>

                        <div class="ad-meta-item">
                            <div class="ad-meta-label">Target Destination URL</div>
                            <div class="ad-meta-value">
                                @if($ad->target_url)
                                    <a href="{{ $ad->target_url }}" target="_blank" style="color: #60a5fa; text-decoration: none;">{{ $ad->target_url }}</a>
                                @else
                                    <span class="text-muted">None (Clicking does nothing)</span>
                                @endif
                            </div>
                        </div>

                        @if($ad->slot_name === 'slot_2')
                            <div class="ad-meta-item">
                                <div class="ad-meta-label">CTA Button Label</div>
                                <div class="ad-meta-value">
                                    @if($ad->button_text)
                                        <span style="font-style: italic; color: #cbd5e1;">"{{ $ad->button_text }}"</span>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 pt-3 border-top border-dark d-flex justify-content-end">
                            <a href="{{ route('admin.sidebar-ads.edit', $ad->id) }}" class="btn btn-primary px-4" style="border-radius: 8px; font-weight: 600;">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
