@extends('layouts.admin')

@section('title', 'Edit Menu Item')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Menu Item</h1>
        <p class="page-subtitle">Modify the configuration, target link, custom content, or sorting order of the menu.</p>
    </div>
    <a href="{{ route('navigation-menus.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card-table" style="max-width: 900px; padding: 32px; border-radius: 20px;">
    <form action="{{ route('navigation-menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="title" class="form-label">Menu Title (Required)</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="e.g. Constitutional Court" value="{{ old('title', $menu->title) }}" required>
                @error('title') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="parent_id" class="form-label">Parent Menu / Dropdown Group (Optional)</label>
                <select id="parent_id" name="parent_id" class="form-control">
                    <option value="">-- None (Creates a top-level header menu) --</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->title }}
                        </option>
                    @endforeach
                </select>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Assign this link as a dropdown item under a parent menu.</small>
                @error('parent_id') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 16px;">
            <div class="form-group">
                <label for="link_type" class="form-label">Link Destination Type (Required)</label>
                <select id="link_type" name="link_type" class="form-control">
                    <option value="url" {{ old('link_type', $menu->custom_content ? 'content' : 'url') == 'url' ? 'selected' : '' }}>Direct Route / URL Link</option>
                    <option value="content" {{ old('link_type', $menu->custom_content ? 'content' : 'url') == 'content' ? 'selected' : '' }}>Custom Dynamic Page Content</option>
                </select>
                @error('link_type') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="order" class="form-label">Display Order (Required)</label>
                <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $menu->order) }}" required>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Sort order for menus (lowest shows first).</small>
                @error('order') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- URL field (toggled based on link type) -->
        <div class="form-group" id="url_group" style="margin-top: 16px;">
            <label for="url" class="form-label">Destination URL or Route Path (Required for URL Link)</label>
            <input type="text" id="url" name="url" class="form-control" placeholder="e.g. /constitution/Republic/Ghana/1, /judgement/Ghana" value="{{ old('url', $menu->url) }}">
            <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Enter a relative path (e.g. <code>/judgement/Ghana</code>) or a full external URL.</small>
            @error('url') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <!-- Custom Content textarea (toggled based on link type) -->
        <div class="form-group" id="content_group" style="margin-top: 16px; display: none;">
            <label for="custom_content" class="form-label">Custom Page Content (HTML allowed - Required for Custom Page)</label>
            <textarea id="custom_content" name="custom_content" class="form-control" style="min-height: 300px; font-family: monospace;" placeholder="<h1>Write page title or content here...</h1><p>This is a custom page body</p>">{{ old('custom_content', $menu->custom_content) }}</textarea>
            @error('custom_content') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <!-- Is Dropdown checkbox (only for parent menus) -->
        <div class="setting-switch-wrapper" id="dropdown_switch_group" style="margin-top: 24px;">
            <label class="switch">
                <input type="checkbox" id="is_dropdown" name="is_dropdown" value="1" {{ old('is_dropdown', $menu->is_dropdown) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <div>
                <span class="switch-label">Is Dropdown Parent</span>
                <small class="switch-desc">Check this to create an empty menu grouping that lists sub-menus under it.</small>
            </div>
        </div>

        <!-- Active/Publish toggle -->
        <div class="setting-switch-wrapper" style="margin-top: 16px;">
            <label class="switch">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
            <div>
                <span class="switch-label">Activate Link</span>
                <small class="switch-desc">Toggle whether this menu item is visible in the site headers.</small>
            </div>
        </div>

        <div style="margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 24px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
                <i class="fa-solid fa-floppy-disk"></i> Update Menu Item
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const parentSelect = document.getElementById('parent_id');
        const dropdownGroup = document.getElementById('dropdown_switch_group');
        const linkTypeSelect = document.getElementById('link_type');
        const urlGroup = document.getElementById('url_group');
        const contentGroup = document.getElementById('content_group');

        // Toggle dropdown switch visibility based on parent selection
        function toggleDropdownSwitch() {
            if (parentSelect.value !== "") {
                dropdownGroup.style.display = 'none';
                document.getElementById('is_dropdown').checked = false;
            } else {
                dropdownGroup.style.display = 'flex';
            }
        }

        // Toggle destination fields based on link type selected
        function toggleLinkTypeFields() {
            if (linkTypeSelect.value === 'url') {
                urlGroup.style.display = 'block';
                contentGroup.style.display = 'none';
            } else {
                urlGroup.style.display = 'none';
                contentGroup.style.display = 'block';
            }
        }

        parentSelect.addEventListener('change', toggleDropdownSwitch);
        linkTypeSelect.addEventListener('change', toggleLinkTypeFields);

        // Run on initial load
        toggleDropdownSwitch();
        toggleLinkTypeFields();
    });
</script>

<style>
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 12px 16px;
        background: rgba(17, 24, 39, 0.6);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: #fff;
        font-family: inherit;
        font-size: 14px;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    select.form-control option {
        background: var(--bg-secondary);
        color: #fff;
    }
</style>
@endsection
