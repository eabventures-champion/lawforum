@extends('layouts.admin')

@section('title', 'Custom Slide Panels')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Custom Slide Panels</h1>
        <p class="page-subtitle">Dynamically add and organize additional horizontal sliding viewport panels for the homepage.</p>
    </div>
    <a href="{{ route('admin.homepage-custom-slides.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Create Custom Panel
    </a>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success-color); color: var(--success-color); padding: 16px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="card-table">
    <div class="table-header">
        <h2 class="table-title">All Dynamic Custom Panels</h2>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 80px;">Icon</th>
                <th>Title</th>
                <th>Subtitle Badge</th>
                <th>Order</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customSlides as $slide)
                <tr>
                    <td>
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--primary-color); border: 1px solid rgba(59, 130, 246, 0.2);">
                            <i class="fa-solid {{ $slide->icon ?: 'fa-circle-dot' }}"></i>
                        </div>
                    </td>
                    <td style="font-weight: 600; color: #fff;">{{ $slide->title }}</td>
                    <td>
                        @if($slide->subtitle)
                            <span class="badge badge-accent">{{ $slide->subtitle }}</span>
                        @else
                            <span style="color: var(--text-secondary); font-size: 12px;">None</span>
                        @endif
                    </td>
                    <td>{{ $slide->order }}</td>
                    <td>
                        @if($slide->is_published)
                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color); border: 1px solid rgba(16, 185, 129, 0.2);">Published</span>
                        @else
                            <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color); border: 1px solid rgba(239, 68, 68, 0.2);">Hidden</span>
                        @endif

                        @if($slide->is_coming_soon)
                            <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); margin-left: 4px;">Coming Soon</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.homepage-custom-slides.edit', $slide->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.homepage-custom-slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this custom panel?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-action" style="padding: 6px 12px; font-size: 12px;">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 40px;">No custom slide panels created yet. Click "Create Custom Panel" to add your first dynamic slide!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
