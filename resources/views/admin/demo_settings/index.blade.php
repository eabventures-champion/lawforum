@extends('layouts.admin')

@section('title', 'Demo & Choose Plan Settings')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="page-title" style="display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-sliders" style="color: var(--primary-color); font-size: 24px;"></i>
            Demo & Choose Plan Settings
        </h1>
        <p class="page-subtitle">Configure the free demo trial periods and dynamically customize every text on the registration Choose Plan page.</p>
    </div>
    <div>
        <a href="/register/choose-plan" target="_blank" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 10px; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.3); color: #60a5fa; text-decoration: none; font-size: 13.5px; font-weight: 600; transition: all 0.2s ease;">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Preview Choose Plan Page
        </a>
    </div>
</div>

<form action="{{ route('admin.demo-settings.update') }}" method="POST">
    @csrf

    {{-- SECTION 1: TRIAL PERIOD DURATIONS --}}
    <div class="card-table" style="padding: 28px; margin-bottom: 28px; border-radius: 16px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                <i class="fa-solid fa-clock-rotate-left" style="font-size: 16px;"></i>
            </div>
            <div>
                <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0;">Trial Period Durations</h3>
                <p style="color: var(--text-secondary); font-size: 12.5px; margin: 2px 0 0;">Sets the duration used to compute user access limits in the database and dynamic placeholders.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 24px;">
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-calendar-days" style="color: var(--primary-color); margin-right: 6px;"></i>
                    Demo Duration (days)
                </label>
                <input type="number" id="demo_duration_days" name="demo_duration_days" value="{{ old('demo_duration_days', $demo_duration_days) }}" required min="1" style="width: 100%; max-width: 220px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 6px;">
                    Full platform access after registration. Default: <span id="defaultDemoDurationText" style="color: #60a5fa; font-weight: 600;">{{ old('demo_duration_days', $demo_duration_days) }} {{ (int)old('demo_duration_days', $demo_duration_days) === 1 ? 'day' : 'days' }}</span>.
                </small>
                @error('demo_duration_days')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    <i class="fa-solid fa-clock-rotate-left" style="color: #f59e0b; margin-right: 6px;"></i>
                    Extension Duration (days)
                </label>
                <input type="number" id="demo_extension_days" name="demo_extension_days" value="{{ old('demo_extension_days', $demo_extension_days) }}" required min="1" style="width: 100%; max-width: 220px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 6px;">
                    Grace extension period when main demo expires. Default: <span id="defaultDemoExtensionText" style="color: #f59e0b; font-weight: 600;">{{ old('demo_extension_days', $demo_extension_days) }} {{ (int)old('demo_extension_days', $demo_extension_days) === 1 ? 'day' : 'days' }}</span>.
                </small>
                @error('demo_extension_days')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Info Box -->
        <div style="background: rgba(59, 130, 246, 0.06); border: 1px solid rgba(59, 130, 246, 0.18); border-radius: 12px; padding: 16px 20px;">
            <div style="display: flex; gap: 12px; align-items: flex-start;">
                <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-top: 3px; font-size: 16px;"></i>
                <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                    <strong style="color: var(--text-primary);">Automatic Text Sync:</strong><br>
                    You can use <code style="background: rgba(0,0,0,0.3); color: #60a5fa; padding: 2px 6px; border-radius: 4px; font-weight: 600;">{days}</code> and <code style="background: rgba(0,0,0,0.3); color: #f59e0b; padding: 2px 6px; border-radius: 4px; font-weight: 600;">{extension_days}</code> in any subtitle or bullet point below. They will automatically render as <strong id="howItWorksDuration" style="color: #60a5fa;">{{ old('demo_duration_days', $demo_duration_days) }} {{ (int)old('demo_duration_days', $demo_duration_days) === 1 ? 'day' : 'days' }}</strong> and <strong id="howItWorksExtension" style="color: #f59e0b;">{{ old('demo_extension_days', $demo_extension_days) }}-day extension</strong>.
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: CHOOSE PLAN PAGE HEADER --}}
    <div class="card-table" style="padding: 28px; margin-bottom: 28px; border-radius: 16px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(139, 92, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #a78bfa;">
                <i class="fa-solid fa-heading" style="font-size: 16px;"></i>
            </div>
            <div>
                <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0;">Page Header & Branding</h3>
                <p style="color: var(--text-secondary); font-size: 12.5px; margin: 2px 0 0;">The main welcome heading and tagline shown at the top of <code>/register/choose-plan</code>.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Main Header Title
                </label>
                <input type="text" name="choose_plan_header_title" value="{{ old('choose_plan_header_title', $choose_plan_header_title) }}" required style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <em>Welcome to Legals Forum!</em></small>
            </div>

            <div>
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Header Subtitle / Tagline
                </label>
                <input type="text" name="choose_plan_header_subtitle" value="{{ old('choose_plan_header_subtitle', $choose_plan_header_subtitle) }}" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <em>Choose how you'd like to get started</em></small>
            </div>
        </div>
    </div>

    {{-- SECTION 3: PLAN CARDS EDITOR --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 24px; margin-bottom: 32px;">
        {{-- DEMO PLAN CARD --}}
        <div class="card-table" style="padding: 28px; border-radius: 16px; border-top: 4px solid #3b82f6;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); display: flex; align-items: center; justify-content: center; color: #60a5fa;">
                    <i class="fa-solid fa-rocket" style="font-size: 16px;"></i>
                </div>
                <div>
                    <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0;">Card 1: Demo Plan</h3>
                    <p style="color: var(--text-secondary); font-size: 12.5px; margin: 2px 0 0;">Customizes the free demo onboarding card.</p>
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Card Title
                </label>
                <input type="text" name="choose_plan_demo_title" value="{{ old('choose_plan_demo_title', $choose_plan_demo_title) }}" required style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <em>Start Free Demo</em></small>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Card Subtitle
                </label>
                <input type="text" name="choose_plan_demo_subtitle" value="{{ old('choose_plan_demo_subtitle', $choose_plan_demo_subtitle) }}" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Use <code style="color: #60a5fa;">{days}</code> to auto-insert the Demo Duration. E.g.: <em>Full access for {days}</em></small>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Card Icon (FontAwesome class)
                </label>
                <input type="text" name="choose_plan_demo_icon" value="{{ old('choose_plan_demo_icon', $choose_plan_demo_icon) }}" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <code>fa-solid fa-rocket</code></small>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Feature Bullet Points (One per line)
                </label>
                <textarea name="choose_plan_demo_features" rows="5" style="width: 100%; padding: 12px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 13.5px; line-height: 1.6; outline: none; resize: vertical;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">{{ old('choose_plan_demo_features', $choose_plan_demo_features) }}</textarea>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Enter each bullet feature on a new line. You can use <code style="color: #f59e0b;">{extension_days}</code>.</small>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Submit Button Text
                </label>
                <input type="text" name="choose_plan_demo_button_text" value="{{ old('choose_plan_demo_button_text', $choose_plan_demo_button_text) }}" required style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <em>Continue with Demo</em></small>
            </div>
        </div>

        {{-- SUBSCRIBE PLAN CARD --}}
        <div class="card-table" style="padding: 28px; border-radius: 16px; border-top: 4px solid #f59e0b;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 14px;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; color: #f59e0b;">
                    <i class="fa-solid fa-crown" style="font-size: 16px;"></i>
                </div>
                <div>
                    <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin: 0;">Card 2: Subscribe Plan</h3>
                    <p style="color: var(--text-secondary); font-size: 12.5px; margin: 2px 0 0;">Customizes the subscription offering card.</p>
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Card Title
                </label>
                <input type="text" name="choose_plan_subscribe_title" value="{{ old('choose_plan_subscribe_title', $choose_plan_subscribe_title) }}" required style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <em>Subscribe Now</em></small>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Card Subtitle
                </label>
                <input type="text" name="choose_plan_subscribe_subtitle" value="{{ old('choose_plan_subscribe_subtitle', $choose_plan_subscribe_subtitle) }}" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <em>Unlimited premium access</em></small>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Card Icon (FontAwesome class)
                </label>
                <input type="text" name="choose_plan_subscribe_icon" value="{{ old('choose_plan_subscribe_icon', $choose_plan_subscribe_icon) }}" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Default: <code>fa-solid fa-crown</code></small>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                    Feature Bullet Points (One per line)
                </label>
                <textarea name="choose_plan_subscribe_features" rows="5" style="width: 100%; padding: 12px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 13.5px; line-height: 1.6; outline: none; resize: vertical;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">{{ old('choose_plan_subscribe_features', $choose_plan_subscribe_features) }}</textarea>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Enter each bullet feature on a new line.</small>
            </div>

            <div style="margin-bottom: 18px; padding: 16px; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); border-radius: 10px;">
                <label style="display: block; font-size: 13.5px; font-weight: 600; color: var(--text-primary); margin-bottom: 10px;">
                    Button Behavior & Action
                </label>
                <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 12px; flex-wrap: wrap;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-primary); font-size: 13.5px; cursor: pointer;">
                        <input type="radio" name="choose_plan_subscribe_button_action" value="coming_soon" {{ old('choose_plan_subscribe_button_action', $choose_plan_subscribe_button_action) === 'coming_soon' ? 'checked' : '' }} onchange="toggleSubscribeUrlField(this.value)">
                        <span>Coming Soon (Disabled with Tooltip)</span>
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-primary); font-size: 13.5px; cursor: pointer;">
                        <input type="radio" name="choose_plan_subscribe_button_action" value="link" {{ old('choose_plan_subscribe_button_action', $choose_plan_subscribe_button_action) === 'link' ? 'checked' : '' }} onchange="toggleSubscribeUrlField(this.value)">
                        <span>Active Link (Clickable)</span>
                    </label>
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                        Button Label
                    </label>
                    <input type="text" name="choose_plan_subscribe_button_text" value="{{ old('choose_plan_subscribe_button_text', $choose_plan_subscribe_button_text) }}" required style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                </div>

                <div id="wrapperSubscribeTooltip" style="{{ old('choose_plan_subscribe_button_action', $choose_plan_subscribe_button_action) === 'link' ? 'display: none;' : '' }} margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                        Hover Tooltip Text
                    </label>
                    <input type="text" name="choose_plan_subscribe_button_tooltip" value="{{ old('choose_plan_subscribe_button_tooltip', $choose_plan_subscribe_button_tooltip) }}" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                </div>

                <div id="wrapperSubscribeUrl" style="{{ old('choose_plan_subscribe_button_action', $choose_plan_subscribe_button_action) === 'link' ? '' : 'display: none;' }}">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">
                        Target URL Link
                    </label>
                    <input type="text" name="choose_plan_subscribe_button_url" value="{{ old('choose_plan_subscribe_button_url', $choose_plan_subscribe_button_url) }}" style="width: 100%; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none;">
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">E.g. <code>/subscription</code></small>
                </div>
            </div>
        </div>
    </div>

    {{-- SUBMIT BUTTON --}}
    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
        <button type="submit" class="btn btn-primary btn-action" style="padding: 12px 28px; font-size: 15px; font-weight: 700; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-floppy-disk"></i> Save All Settings
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const durationInput = document.getElementById('demo_duration_days');
    const extensionInput = document.getElementById('demo_extension_days');
    const defaultDurationText = document.getElementById('defaultDemoDurationText');
    const defaultExtensionText = document.getElementById('defaultDemoExtensionText');
    const howItWorksDuration = document.getElementById('howItWorksDuration');
    const howItWorksExtension = document.getElementById('howItWorksExtension');

    function updateDuration(val) {
        const num = parseInt(val, 10);
        const text = isNaN(num) || num < 1 ? '0 days' : (num === 1 ? '1 day' : num + ' days');
        if (defaultDurationText) defaultDurationText.textContent = text;
        if (howItWorksDuration) howItWorksDuration.textContent = text;
    }

    function updateExtension(val) {
        const num = parseInt(val, 10);
        const text = isNaN(num) || num < 1 ? '0 days' : (num === 1 ? '1 day' : num + ' days');
        const extText = isNaN(num) || num < 1 ? '0-day extension' : num + '-day extension';
        if (defaultExtensionText) defaultExtensionText.textContent = text;
        if (howItWorksExtension) howItWorksExtension.textContent = extText;
    }

    if (durationInput) {
        durationInput.addEventListener('input', function() { updateDuration(this.value); });
        durationInput.addEventListener('change', function() { updateDuration(this.value); });
    }

    if (extensionInput) {
        extensionInput.addEventListener('input', function() { updateExtension(this.value); });
        extensionInput.addEventListener('change', function() { updateExtension(this.value); });
    }
});

function toggleSubscribeUrlField(action) {
    const tooltipWrapper = document.getElementById('wrapperSubscribeTooltip');
    const urlWrapper = document.getElementById('wrapperSubscribeUrl');
    if (action === 'link') {
        if (tooltipWrapper) tooltipWrapper.style.display = 'none';
        if (urlWrapper) urlWrapper.style.display = 'block';
    } else {
        if (tooltipWrapper) tooltipWrapper.style.display = 'block';
        if (urlWrapper) urlWrapper.style.display = 'none';
    }
}
</script>
@endsection
