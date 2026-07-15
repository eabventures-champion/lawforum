@extends('layouts.admin')

@section('title', 'Edit Custom Slide Panel')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Custom Slide Panel</h1>
        <p class="page-subtitle">Configure the title, content layout, navigation icon, and button actions for this slide.</p>
    </div>
    <a href="{{ route('admin.homepage-custom-slides.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card-table" style="max-width: 900px; padding: 32px; border-radius: 20px;">
    <form action="{{ route('admin.homepage-custom-slides.update', $slide->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="title" class="form-label">Panel Title (Required)</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Premium Library" value="{{ old('title', $slide->title) }}" required>
                @error('title') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="subtitle" class="form-label">Subtitle Badge Text (Optional)</label>
                <input type="text" id="subtitle" name="subtitle" class="form-control" placeholder="e.g. Exclusive Features" value="{{ old('subtitle', $slide->subtitle) }}">
                @error('subtitle') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 16px;">
            <div class="form-group">
                <label for="icon" class="form-label">FontAwesome Icon Class (Required)</label>
                <input type="text" id="icon" name="icon" class="form-control" placeholder="e.g. fa-book-open, fa-balance-scale, fa-star" value="{{ old('icon', $slide->icon) }}" required>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Used for the vertical navigation sidebar dots.</small>
                @error('icon') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="order" class="form-label">Slide Display Order (Required)</label>
                <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $slide->order) }}" required>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Lower numbers show first (appended after the 3 default slides).</small>
                @error('order') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group" style="margin-top: 16px;">
            <label for="content" class="form-label">Slide Description / Content (Optional)</label>
            <textarea id="content" name="content" class="form-control" style="min-height: 120px;" placeholder="Write a short pitch or description about this section...">{{ old('content', $slide->content) }}</textarea>
            @error('content') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 16px;">
            <div class="form-group">
                <label for="btn_text" class="form-label">Button Call-To-Action Text (Optional)</label>
                <input type="text" id="btn_text" name="btn_text" class="form-control" placeholder="e.g. Get Instant Access" value="{{ old('btn_text', $slide->btn_text) }}">
                @error('btn_text') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="btn_link" class="form-label">Button Redirect URL / Link (Optional)</label>
                <input type="text" id="btn_link" name="btn_link" class="form-control" placeholder="e.g. /subscription, https://..." value="{{ old('btn_link', $slide->btn_link) }}">
                @error('btn_link') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="setting-switch-wrapper" style="margin-top: 24px;">
            <label class="switch">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $slide->is_published) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <div>
                <span class="switch-label">Publish Custom Panel</span>
                <small class="switch-desc">Toggle whether this slide panel is visible in the homepage slideshow slider.</small>
            </div>
        </div>

        <div class="setting-switch-wrapper" style="margin-top: 16px;">
            <label class="switch">
                <input type="checkbox" name="is_coming_soon" value="1" {{ old('is_coming_soon', $slide->is_coming_soon) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <div>
                <span class="switch-label">Mark as Coming Soon</span>
                <small class="switch-desc">Show a "Coming Soon" premium badge and locking treatment on this slide panel.</small>
            </div>
        </div>

        <div style="margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
                <i class="fa-solid fa-floppy-disk"></i> Save Panel Changes
            </button>
        </div>
    </form>
</div>

<style>
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
@endsection
