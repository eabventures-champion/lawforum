@extends('layouts.admin')

@section('title', 'Edit Researcher Type')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Researcher Type</h1>
        <p class="page-subtitle">Update the "{{ $researcherType->name }}" option.</p>
    </div>
    <a href="{{ route('admin.researcher-types.index') }}" class="btn btn-secondary btn-action">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
</div>

<div class="card-table" style="padding: 32px;">
    <form action="{{ route('admin.researcher-types.update', $researcherType->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">Type Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="name" value="{{ old('name', $researcherType->name) }}" required placeholder="e.g., Politician, Academic" style="width: 100%; max-width: 400px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
            @error('name')
                <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $researcherType->sort_order) }}" min="0" style="width: 100%; max-width: 150px; padding: 10px 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='var(--border-color)'">
            <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Lower numbers appear first in the dropdown.</small>
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: 600; color: var(--text-primary);">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $researcherType->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary-color); cursor: pointer;">
                Active
            </label>
            <small style="display: block; color: var(--text-secondary); margin-top: 4px; margin-left: 28px;">Only active types appear in the registration dropdown.</small>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary btn-action">
                <i class="fa-solid fa-check"></i> Update Type
            </button>
            <a href="{{ route('admin.researcher-types.index') }}" class="btn btn-secondary btn-action">Cancel</a>
        </div>
    </form>
</div>
@endsection
