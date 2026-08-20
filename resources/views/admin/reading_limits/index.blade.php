@extends('layouts.admin')

@section('title', 'Reading Limits & Gates')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Guest Reading Limits & Scroll Gates</h1>
        <p class="page-subtitle">Configure the reading progress percentages and preview section limits for guest visitors.</p>
    </div>
</div>

<div class="card-table" style="padding: 32px; max-width: 800px;">
    <form action="{{ route('admin.reading-limits.update') }}" method="POST">
        @csrf

        {{-- Master Toggle --}}
        <div style="margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--border-color);">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px;">
                <div>
                    <label style="font-size: 15px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; display: block;">
                        <i class="fa-solid fa-shield-halved" style="color: var(--primary-color); margin-right: 8px;"></i>
                        Enable Guest Reading Limits & Gates
                    </label>
                    <small style="color: var(--text-secondary); font-size: 13px;">When enabled, guests are restricted by the configured scroll percentages and preview limits below. If disabled, guests have unrestricted reading access.</small>
                </div>
                <label style="position: relative; display: inline-block; width: 52px; height: 28px; flex-shrink: 0; cursor: pointer;">
                    <input type="checkbox" name="reading_limit_enabled" value="1" {{ $reading_limit_enabled == '1' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;" id="limitToggle">
                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $reading_limit_enabled == '1' ? '#3b82f6' : '#334155' }}; transition: .3s; border-radius: 28px;" id="limitToggleSlider">
                        <span style="position: absolute; content: ''; height: 20px; width: 20px; left: {{ $reading_limit_enabled == '1' ? '28px' : '4px' }}; bottom: 4px; background-color: white; transition: .3s; border-radius: 50%;" id="limitToggleKnob"></span>
                    </span>
                </label>
            </div>
        </div>

        {{-- General Laws Limit --}}
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                <i class="fa-solid fa-landmark" style="color: #60a5fa; margin-right: 6px;"></i>
                General Laws Scroll Limit (%)
            </label>
            <div style="display: flex; align-items: center; gap: 8px;">
                <input type="number" name="default_scroll_percentage" value="{{ old('default_scroll_percentage', $default_scroll_percentage) }}" required min="1" max="100" style="width: 120px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <span style="color: var(--text-secondary); font-size: 14px; font-weight: 600;">%</span>
            </div>
            <small style="display: block; color: var(--text-secondary); margin-top: 6px;">Scroll percentage limit for Existing Laws (Pre-1992), New Laws (Post-1992), Regulations, and Executive/Constitutional Instruments in Expanded View. Default: 10%.</small>
            @error('default_scroll_percentage')
                <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Constitution Limit --}}
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                <i class="fa-solid fa-scale-balanced" style="color: #f59e0b; margin-right: 6px;"></i>
                Constitution Scroll Limit (%)
            </label>
            <div style="display: flex; align-items: center; gap: 8px;">
                <input type="number" name="constitution_scroll_percentage" value="{{ old('constitution_scroll_percentage', $constitution_scroll_percentage) }}" required min="1" max="100" style="width: 120px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <span style="color: var(--text-secondary); font-size: 14px; font-weight: 600;">%</span>
            </div>
            <small style="display: block; color: var(--text-secondary); margin-top: 6px;">Scroll percentage threshold before the reading limit gate triggers when viewing Constitution documents in Expanded View. Default: 50%.</small>
            @error('constitution_scroll_percentage')
                <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Case Law / Judgments Limit --}}
        <div style="margin-bottom: 28px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                <i class="fa-solid fa-gavel" style="color: #a78bfa; margin-right: 6px;"></i>
                Case Law & Judgments Scroll Limit (%)
            </label>
            <div style="display: flex; align-items: center; gap: 8px;">
                <input type="number" name="case_law_scroll_percentage" value="{{ old('case_law_scroll_percentage', $case_law_scroll_percentage) }}" required min="1" max="100" style="width: 120px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <span style="color: var(--text-secondary); font-size: 14px; font-weight: 600;">%</span>
            </div>
            <small style="display: block; color: var(--text-secondary); margin-top: 6px;">Scroll percentage limit for Supreme Court, Court of Appeal, and High Court judgments. Default: 20%.</small>
            @error('case_law_scroll_percentage')
                <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        {{-- Free Preview Sections Limit --}}
        <div style="margin-bottom: 32px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                <i class="fa-solid fa-list-ol" style="color: #10b981; margin-right: 6px;"></i>
                Free Preview Sections Count (Table of Contents)
            </label>
            <div style="display: flex; align-items: center; gap: 8px;">
                <input type="number" name="free_preview_sections_count" value="{{ old('free_preview_sections_count', $free_preview_sections_count) }}" required min="0" max="100" style="width: 120px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
                <span style="color: var(--text-secondary); font-size: 14px; font-weight: 600;">sections</span>
            </div>
            <small style="display: block; color: var(--text-secondary); margin-top: 6px;">Number of free preview sections a guest can read in the Table of Contents sidebar before subsequent sections are locked. Default: 3 sections.</small>
            @error('free_preview_sections_count')
                <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <!-- How It Works Card -->
        <div style="background: rgba(59, 130, 246, 0.06); border: 1px solid rgba(59, 130, 246, 0.15); border-radius: 12px; padding: 20px 22px; margin-bottom: 28px;">
            <div style="display: flex; gap: 14px; align-items: flex-start;">
                <i class="fa-solid fa-circle-info" style="color: #3b82f6; margin-top: 3px; font-size: 16px;"></i>
                <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                    <strong style="color: var(--text-primary); font-size: 13.5px;">Gate Execution Overview:</strong><br>
                    <ul style="margin: 8px 0 0 0; padding-left: 18px;">
                        <li><strong>Expanded View (Full Document):</strong> As guests scroll down the full text, reaching the configured percentage will smoothly blur the text and display the <em>"Reading Limit Reached (X%)"</em> upgrade modal.</li>
                        <li><strong>Reader View (Section by Section):</strong> Guests can read the first <strong>{{ $free_preview_sections_count }}</strong> sections of any enactment. Clicking section {{ $free_preview_sections_count + 1 }} or higher displays the locked preview card inviting them to create an account.</li>
                    </ul>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-action" style="padding: 10px 24px; font-weight: 600; font-size: 14px;">
            <i class="fa-solid fa-check"></i> Save Reading Limit Settings
        </button>
    </form>
</div>

<script>
    document.getElementById('limitToggle').addEventListener('change', function() {
        var slider = document.getElementById('limitToggleSlider');
        var knob = document.getElementById('limitToggleKnob');
        if (this.checked) {
            slider.style.backgroundColor = '#3b82f6';
            knob.style.left = '28px';
        } else {
            slider.style.backgroundColor = '#334155';
            knob.style.left = '4px';
        }
    });
</script>
@endsection
