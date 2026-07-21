@extends('layouts.admin')

@section('title', 'Edit Sidebar Ad - ' . $ad->title)

@section('styles')
<style>
    .form-card {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 32px;
    }
    .form-control-premium {
        background: #070a13 !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f1f5f9 !important;
        border-radius: 8px !important;
        padding: 10px 14px !important;
        height: auto !important;
        transition: all 0.2s ease !important;
    }
    .form-control-premium:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
    }
    .current-image-preview {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        background: #070a13;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 10px;
        margin-top: 8px;
    }
    .checkbox-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }
    .checkbox-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #334155;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #10b981;
    }
    input:checked + .slider:before {
        transform: translateX(24px);
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <div class="mb-2">
            <a href="{{ route('admin.sidebar-ads.index') }}" class="text-primary text-decoration-none" style="font-weight: 600; font-size: 14px;">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Advertisement Slots
            </a>
        </div>
        <h1 class="page-title">Edit Settings: {{ $ad->title }}</h1>
    </div>
</div>

<div class="container-fluid px-0">

    @if ($errors->any())
        <div class="alert alert-danger border-0 mb-4" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.sidebar-ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <!-- Title Input -->
                    <div class="form-group mb-4">
                        <label class="text-muted mb-2" style="font-weight: 600; font-size: 13px;">Display Title / Label</label>
                        <input type="text" name="title" value="{{ old('title', $ad->title) }}" class="form-control form-control-premium" required>
                    </div>

                    <!-- Destination Link -->
                    <div class="form-group mb-4">
                        <label class="text-muted mb-2" style="font-weight: 600; font-size: 13px;">
                            Click Target Link URL (Optional)
                        </label>
                        <input type="text" name="target_url" value="{{ old('target_url', $ad->target_url) }}" class="form-control form-control-premium" placeholder="e.g. tel:0503539237 or https://example.com">
                        <small class="form-text text-muted mt-1">If left blank, clicking on the advertisement image will do nothing.</small>
                    </div>

                    <!-- CTA Button Content (Slot 2 only) -->
                    @if($ad->slot_name === 'slot_2')
                        <div class="form-group mb-4">
                            <label class="text-muted mb-2" style="font-weight: 600; font-size: 13px;">
                                Button CTA Text / Label
                            </label>
                            <textarea name="button_text" class="form-control form-control-premium" rows="2" placeholder="e.g. Call Us now">{{ old('button_text', $ad->button_text) }}</textarea>
                            <small class="form-text text-muted mt-1">This text is placed on the CTA button underneath the image for Slot 2.</small>
                        </div>
                    @endif

                    <!-- Fallback Placeholder Configuration -->
                    <div class="form-group mb-4">
                        <label class="text-muted mb-2" style="font-weight: 600; font-size: 13px;">
                            Fallback Placeholder (When status is hidden / no image uploaded)
                        </label>
                        <select name="placeholder_type" class="form-control form-control-premium" required>
                            <option value="advertise" {{ old('placeholder_type', $ad->placeholder_type) === 'advertise' ? 'selected' : '' }}>
                                Option 1: "Advertise Product" Call-to-Action Banner
                            </option>
                            <option value="news_feed" {{ old('placeholder_type', $ad->placeholder_type) === 'news_feed' ? 'selected' : '' }}>
                                Option 2: "Daily News & Blogs Feed" Interactive Slider
                            </option>
                        </select>
                        <small class="form-text text-muted mt-1">Select the presentation mode of the placeholder when this ad slot is hidden or has no image.</small>
                    </div>

                    <!-- Toggle Visibility -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <div class="mr-3">
                            <label class="checkbox-switch">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $ad->is_active) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div>
                            <span class="text-white d-block" style="font-weight: 600; font-size: 14px;">Active Status</span>
                            <span class="text-muted" style="font-size: 12px;">Toggle whether this advertisement panel is displayed in the sidebar.</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Image Upload -->
                    <div class="form-group mb-4">
                        <label class="text-muted mb-2" style="font-weight: 600; font-size: 13px;">Upload Ad Image</label>
                        <input type="file" name="image" class="form-control-file text-muted" accept="image/*">
                        
                        <div class="mt-4">
                            <span class="text-muted d-block" style="font-weight: 600; font-size: 12px; margin-bottom: 6px;">Current Image Preview</span>
                            @if($ad->image_path)
                                <img src="{{ $ad->image_url }}" alt="Current Image" class="current-image-preview">
                            @else
                                <div class="text-muted p-4 border border-dark rounded text-center" style="background: #070a13;">
                                    <i class="fa-regular fa-image" style="font-size: 24px;"></i>
                                    <span class="d-block mt-2">No image configured</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-dark d-flex justify-content-end gap-2">
                <a href="{{ route('admin.sidebar-ads.index') }}" class="btn btn-secondary px-4 mr-2" style="border-radius: 8px; font-weight: 600; background: #334155; border: none;">Cancel</a>
                <button type="submit" class="btn btn-success px-4" style="border-radius: 8px; font-weight: 600; background: #10b981; border: none;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
