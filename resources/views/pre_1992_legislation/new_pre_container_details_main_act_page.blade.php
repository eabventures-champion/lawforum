<style>
    /* Premium details card styling */
    .premium-details-card {
        background: rgba(30, 41, 59, 0.45);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        transition: border-color 0.3s ease;
        position: relative !important;
        z-index: 100 !important;
    }
    
    .premium-details-card:hover {
        border-color: rgba(255, 255, 255, 0.12);
    }
    
    .details-header-title {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--text-secondary);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .details-header-title i {
        color: var(--gold);
        font-size: 12px;
    }
    
    /* Premium Action Buttons */
    .btn-action-premium {
        width: 100%;
        background: rgba(255, 255, 255, 0.02) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        padding: 10px 16px !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
        cursor: pointer;
    }
    
    .btn-action-premium:hover {
        background: rgba(255, 255, 255, 0.06) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
    }

    .dropdown-menu-premium {
        background: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 8px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6) !important;
        padding: 6px !important;
        z-index: 1050 !important;
    }

    .premium-ad-card {
        position: relative !important;
        z-index: 1 !important;
    }
</style>

<div class="premium-details-card">
    <div class="details-header-title">
        <i class="fa-solid fa-sliders"></i> Reader Actions
    </div>
    
    <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
        <!-- Unified View Options Dropdown Trigger -->
        <div class="dropdown" style="width: 100%;">
            <button class="btn-action-premium dropdown-toggle" type="button" id="sidebarViewOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;">
                <i class="fa-solid fa-images"></i> View Options
            </button>
            <div class="dropdown-menu dropdown-menu-premium" aria-labelledby="sidebarViewOptions" style="width: 100%;">
                <a class="dropdown-item dropdown-item-premium expanded_link toggle_expanded_view" href="/pre_1992_legislation/1/{{$allPre1992Act['pre_1992_group']}}/{{$allPre1992Act['title']}}/expanded-view/{{ $allPre1992Act['id'] }}" onclick="selectViewMode('expanded'); event.stopImmediatePropagation(); return false;">
                    <i class="fa-solid fa-expand"></i> Expanded View
                </a>
                <a class="dropdown-item dropdown-item-premium" href="#" onclick="triggerSplitView('horizontal')">
                    <i class="fa-solid fa-columns"></i> Horizontal Split
                </a>
                <a class="dropdown-item dropdown-item-premium" href="#" onclick="triggerSplitView('vertical')">
                    <i class="fa-solid fa-window-maximize" style="transform: rotate(90deg); font-size: 10px;"></i> Vertical Split
                </a>
            </div>
        </div>
    </div>
</div>

<div class="premium-ad-card">
    @include('ads.small_ads_image_main_page')
</div>