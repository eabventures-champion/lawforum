@extends('layouts.admin')

@section('title', 'Researcher Types')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Researcher Types</h1>
        <p class="page-subtitle">Manage the "I am a..." dropdown options for researcher registration.</p>
    </div>
    <a href="{{ route('admin.researcher-types.create') }}" class="btn btn-primary btn-action">
        <i class="fa-solid fa-plus"></i> Add New Type
    </a>
</div>

<div class="card-table">
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th>Name</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 100px;">Sort Order</th>
                <th style="width: 160px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($researcherTypes as $index => $type)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $type->name }}</td>
                    <td>
                        @if($type->is_active)
                            <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 600;">Active</span>
                        @else
                            <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 4px 12px; border-radius: 100px; font-size: 12px; font-weight: 600;">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $type->sort_order }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.researcher-types.edit', $type->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 14px; font-size: 13px;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.researcher-types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this type?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-action" style="padding: 6px 14px; font-size: 13px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.2s;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                        <i class="fa-solid fa-inbox" style="font-size: 24px; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                        No researcher types found. Add one to get started.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
