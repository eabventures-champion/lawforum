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
                @foreach($settings['slide_1'] as $setting)
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
