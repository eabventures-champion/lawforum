@extends('layouts.admin')

@section('title', 'Homepage Slider Settings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Homepage Slider Settings</h1>
        <p class="page-subtitle">Configure, publish/hide, or edit every single word of the homepage slides.</p>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-color); color: var(--success-color); padding: 16px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="card-table" style="max-width: 1000px; padding: 32px; border-radius: 20px;">
    <form action="{{ route('admin.homepage-settings.update') }}" method="POST">
        @csrf

        <!-- Tabs Navigation -->
        <div style="display: flex; gap: 8px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 32px;">
            <button type="button" class="tab-btn active" id="btn-slide_0" onclick="switchTab('slide_0')" style="background: transparent; border: none; color: var(--text-secondary); padding: 8px 16px; font-weight: 600; cursor: pointer; border-radius: 8px; transition: all 0.2s;">
                <i class="fa-solid fa-house" style="margin-right: 6px;"></i> Slide 0: Home Section
            </button>
            <button type="button" class="tab-btn" id="btn-slide_1" onclick="switchTab('slide_1')" style="background: transparent; border: none; color: var(--text-secondary); padding: 8px 16px; font-weight: 600; cursor: pointer; border-radius: 8px; transition: all 0.2s;">
                <i class="fa-solid fa-award" style="margin-right: 6px;"></i> Slide 1: Why Choose Us
            </button>
            <button type="button" class="tab-btn" id="btn-slide_2" onclick="switchTab('slide_2')" style="background: transparent; border: none; color: var(--text-secondary); padding: 8px 16px; font-weight: 600; cursor: pointer; border-radius: 8px; transition: all 0.2s;">
                <i class="fa-solid fa-graduation-cap" style="margin-right: 6px;"></i> Slide 2: Students Package
            </button>
        </div>

        <!-- Slide 0 Panel -->
        <div id="panel-slide_0" class="tab-panel">
            <h3 style="color: #fff; margin-bottom: 24px; font-size: 18px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-house" style="color: #3b82f6;"></i> Home / Hero Slide Settings
            </h3>
            
            @if(isset($settings['slide_0']))
                @foreach($settings['slide_0'] as $setting)
                    @if($setting->type === 'boolean')
                        <div class="setting-switch-wrapper">
                            <label class="switch">
                                <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" {{ $setting->value == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <div>
                                <span class="switch-label">{{ $setting->label }}</span>
                                <small class="switch-desc">Toggle whether this slide is visible on the homepage.</small>
                            </div>
                        </div>
                    @else
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="settings[{{ $setting->key }}]" class="form-label">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea id="settings[{{ $setting->key }}]" name="settings[{{ $setting->key }}]" class="form-control" style="min-height: 80px;">{{ $setting->value }}</textarea>
                            @else
                                <input type="text" id="settings[{{ $setting->key }}]" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- Slide 1 Panel -->
        <div id="panel-slide_1" class="tab-panel" style="display: none;">
            <h3 style="color: #fff; margin-bottom: 24px; font-size: 18px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-award" style="color: #3b82f6;"></i> Why Choose Us Slide Settings
            </h3>
            
            @if(isset($settings['slide_1']))
                @php
                    $newsKeys = ['slide_1_news_coming_soon', 'slide_1_news_badge', 'slide_1_news_btn_text', 'slide_1_card5_title', 'slide_1_card5_desc'];
                    $newsSettings = $settings['slide_1']->whereIn('key', $newsKeys)->keyBy('key');
                @endphp

                <!-- Dedicated Legal News Component & Coming Soon Box -->
                <div style="background: rgba(244, 63, 94, 0.05); border: 1px solid rgba(244, 63, 94, 0.25); border-radius: 16px; padding: 24px; margin-bottom: 32px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid rgba(244, 63, 94, 0.15); padding-bottom: 16px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(244, 63, 94, 0.15); color: #fb7185; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                            <div>
                                <h4 style="color: #fff; margin: 0; font-size: 16px; font-weight: 700;">Legal News & Coming Soon Settings</h4>
                                <p style="color: var(--text-secondary); margin: 2px 0 0; font-size: 12.5px;">Dynamically configure Legal News status, badges, and card text on Slide 1.</p>
                            </div>
                        </div>
                        @if(isset($newsSettings['slide_1_news_coming_soon']) && $newsSettings['slide_1_news_coming_soon']->value == '1')
                            <span style="background: rgba(244, 63, 94, 0.15); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.35); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
                                ● COMING SOON ACTIVE
                            </span>
                        @else
                            <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px;">
                                ● PUBLIC / LIVE
                            </span>
                        @endif
                    </div>

                    <!-- Coming Soon Switch -->
                    @if(isset($newsSettings['slide_1_news_coming_soon']))
                    <div class="setting-switch-wrapper" style="background: rgba(0, 0, 0, 0.2); border-color: rgba(244, 63, 94, 0.2);">
                        <label class="switch">
                            <input type="checkbox" name="settings[slide_1_news_coming_soon]" value="1" {{ $newsSettings['slide_1_news_coming_soon']->value == '1' ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                        <div>
                            <span class="switch-label">Coming Soon Mode for Legal News</span>
                            <small class="switch-desc">When enabled, the homepage card is disabled with a Coming Soon badge, and public navigation to news pages is blocked.</small>
                        </div>
                    </div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <!-- Badge Text -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="settings[slide_1_news_badge]" class="form-label" style="font-size: 13px;">Coming Soon Badge Text</label>
                            <input type="text" id="settings[slide_1_news_badge]" name="settings[slide_1_news_badge]" class="form-control" value="{{ $newsSettings['slide_1_news_badge']->value ?? 'COMING SOON' }}" placeholder="COMING SOON">
                            <small style="color: var(--text-muted); font-size: 11px;">Appears inside the glowing pill badge at the top right of the card.</small>
                        </div>

                        <!-- Action Button Text -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="settings[slide_1_news_btn_text]" class="form-label" style="font-size: 13px;">Coming Soon Action Text</label>
                            <input type="text" id="settings[slide_1_news_btn_text]" name="settings[slide_1_news_btn_text]" class="form-control" value="{{ $newsSettings['slide_1_news_btn_text']->value ?? 'Coming Soon' }}" placeholder="Coming Soon">
                            <small style="color: var(--text-muted); font-size: 11px;">Appears at the bottom next to the clock icon.</small>
                        </div>
                    </div>

                    <!-- Card Title -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="settings[slide_1_card5_title]" class="form-label" style="font-size: 13px;">Card Title</label>
                        <input type="text" id="settings[slide_1_card5_title]" name="settings[slide_1_card5_title]" class="form-control" value="{{ $newsSettings['slide_1_card5_title']->value ?? 'Legal News' }}">
                    </div>

                    <!-- Card Description -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="settings[slide_1_card5_desc]" class="form-label" style="font-size: 13px;">Card Description / Notice</label>
                        <textarea id="settings[slide_1_card5_desc]" name="settings[slide_1_card5_desc]" class="form-control" style="min-height: 70px;">{{ $newsSettings['slide_1_card5_desc']->value ?? 'Stay updated with relevant legal and business news content from Ghana, Africa, Asia, Europe, and America.' }}</textarea>
                    </div>
                </div>

                @foreach($settings['slide_1'] as $setting)
                    @if(in_array($setting->key, $newsKeys))
                        @continue
                    @endif
                    @if($setting->type === 'boolean')
                        <div class="setting-switch-wrapper">
                            <label class="switch">
                                <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" {{ $setting->value == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <div>
                                <span class="switch-label">{{ $setting->label }}</span>
                                <small class="switch-desc">
                                    @if($setting->key === 'slide_1_stats_published')
                                        Toggle whether the 4-box statistics counter card (Laws & Acts, Case Laws, Constitutions, Registered Users) is visible.
                                    @else
                                        Toggle whether this slide is visible on the homepage.
                                    @endif
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="settings[{{ $setting->key }}]" class="form-label">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea id="settings[{{ $setting->key }}]" name="settings[{{ $setting->key }}]" class="form-control" style="min-height: 80px;">{{ $setting->value }}</textarea>
                            @else
                                <input type="text" id="settings[{{ $setting->key }}]" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- Slide 2 Panel -->
        <div id="panel-slide_2" class="tab-panel" style="display: none;">
            <h3 style="color: #fff; margin-bottom: 24px; font-size: 18px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-graduation-cap" style="color: #3b82f6;"></i> Students Package Slide Settings
            </h3>
            
            @if(isset($settings['slide_2']))
                @foreach($settings['slide_2'] as $setting)
                    @if($setting->type === 'boolean')
                        <div class="setting-switch-wrapper">
                            <label class="switch">
                                <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" {{ $setting->value == '1' ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                            <div>
                                <span class="switch-label">{{ $setting->label }}</span>
                                <small class="switch-desc">Toggle whether this slide is visible on the homepage.</small>
                            </div>
                        </div>
                    @else
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="settings[{{ $setting->key }}]" class="form-label">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea id="settings[{{ $setting->key }}]" name="settings[{{ $setting->key }}]" class="form-control" style="min-height: 80px;">{{ $setting->value }}</textarea>
                            @else
                                <input type="text" id="settings[{{ $setting->key }}]" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div style="margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
                <i class="fa-solid fa-floppy-disk"></i> Save Slider Settings
            </button>
        </div>
    </form>
</div>

<style>
    /* Tab Buttons Style */
    .tab-btn.active {
        background: rgba(59, 130, 246, 0.1) !important;
        color: #fff !important;
        border: 1px solid rgba(59, 130, 246, 0.2) !important;
    }
    .tab-btn:hover {
        color: #fff !important;
    }

    /* Switch Style */
    .setting-switch-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        background: rgba(255, 255, 255, 0.02);
        padding: 16px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #374151;
        transition: .4s;
        border-radius: 24px;
    }
    .slider::before {
        content: "";
        position: absolute;
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    .switch input:checked + .slider {
        background-color: var(--primary-color, #3b82f6);
    }
    .switch input:checked + .slider::before {
        transform: translateX(20px);
    }
    .switch-label {
        font-weight: 600;
        display: block;
        color: #fff;
        font-size: 14px;
    }
    .switch-desc {
        color: var(--text-secondary);
        font-size: 12px;
    }
</style>

<script>
    function switchTab(slideId) {
        // Hide all panels
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.style.display = 'none';
        });
        
        // Remove active class from buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Show selected panel
        document.getElementById('panel-' + slideId).style.display = 'block';
        
        // Add active class to clicked button
        document.getElementById('btn-' + slideId).classList.add('active');
    }
</script>
@endsection
