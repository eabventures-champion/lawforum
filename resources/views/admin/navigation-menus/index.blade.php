@extends('layouts.admin')

@section('title', 'Header Navigation Menus')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Header Navigation Menus</h1>
        <p class="page-subtitle">Configure, disable, edit, reorder, or hide menu links in the header navbar.</p>
    </div>
    <a href="{{ route('navigation-menus.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Create Menu Item
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
        <h2 class="table-title">All Navigation Menus & Submenus</h2>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 250px;">Menu Title</th>
                <th>Link / Target</th>
                <th style="width: 100px;">Order</th>
                <th style="width: 150px;">Type</th>
                <th style="width: 120px;">Status</th>
                <th style="width: 200px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
                <!-- Parent Row -->
                <tr style="background: rgba(255, 255, 255, 0.02);">
                    <td style="font-weight: 700; color: #fff; font-size: 15px;">
                        @if($menu->is_dropdown)
                            <i class="fa-solid fa-folder-open" style="color: var(--primary-color); margin-right: 8px;"></i>
                        @else
                            <i class="fa-solid fa-link" style="color: var(--text-secondary); margin-right: 8px;"></i>
                        @endif
                        {{ $menu->title }}
                    </td>
                    <td>
                        @if($menu->is_dropdown)
                            <span style="color: var(--text-secondary); font-size: 13px;">Dropdown Menu Parent</span>
                        @elseif($menu->custom_content)
                            <code style="color: var(--accent-light);">/page/{{ $menu->slug }}</code>
                        @else
                            <code style="color: var(--text-secondary);">{{ $menu->url }}</code>
                        @endif
                    </td>
                    <td>{{ $menu->order }}</td>
                    <td>
                        @if($menu->is_dropdown)
                            <span class="badge badge-accent">Dropdown Parent</span>
                        @elseif($menu->custom_content)
                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color); border: 1px solid rgba(16, 185, 129, 0.2);">Custom Page</span>
                        @else
                            <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: var(--primary-color); border: 1px solid rgba(59, 130, 246, 0.2);">Direct URL</span>
                        @endif
                    </td>
                    <td>
                        @if($menu->is_active)
                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color); border: 1px solid rgba(16, 185, 129, 0.2);">Active</span>
                        @else
                            <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color); border: 1px solid rgba(239, 68, 68, 0.2);">Hidden</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('navigation-menus.edit', $menu->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('navigation-menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this menu item? Deleting a parent dropdown menu will delete all its child links!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-action" style="padding: 6px 12px; font-size: 12px;">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Child Rows -->
                @if($menu->is_dropdown && $menu->children->count() > 0)
                    @foreach($menu->children as $child)
                        <tr>
                            <td style="padding-left: 40px; color: var(--text-secondary); font-size: 14px;">
                                <i class="fa-solid fa-arrow-turn-up" style="transform: rotate(90deg); margin-right: 8px; color: var(--border-hover); font-size: 11px;"></i>
                                <i class="fa-solid fa-link" style="color: var(--text-muted); font-size: 12px; margin-right: 4px;"></i>
                                {{ $child->title }}
                            </td>
                            <td>
                                @if($child->custom_content)
                                    <code style="color: var(--accent-light);">/page/{{ $child->slug }}</code>
                                @else
                                    <code style="color: var(--text-secondary);">{{ $child->url }}</code>
                                @endif
                            </td>
                            <td>{{ $child->order }}</td>
                            <td>
                                @if($child->custom_content)
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color); border: 1px solid rgba(16, 185, 129, 0.2);">Custom Page</span>
                                @else
                                    <span class="badge" style="background: rgba(59, 130, 246, 0.1); color: var(--primary-color); border: 1px solid rgba(59, 130, 246, 0.2);">Direct URL</span>
                                @endif
                            </td>
                            <td>
                                @if($child->is_active)
                                    <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color); border: 1px solid rgba(16, 185, 129, 0.2);">Active</span>
                                @else
                                    <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color); border: 1px solid rgba(239, 68, 68, 0.2);">Hidden</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('navigation-menus.edit', $child->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12px;">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('navigation-menus.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this link?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action" style="padding: 6px 12px; font-size: 12px;">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 40px;">No navigation menus created yet. Click "Create Menu Item" to get started!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
