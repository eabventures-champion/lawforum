@extends('layouts.admin')

@section('title', 'Laws & Acts')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laws & Acts</h1>
        <p class="page-subtitle">Manage legal codifications, preambles, and documents.</p>
    </div>
    <a href="{{ route('admin.laws.create', ['type' => $type]) }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Add New Law
    </a>
</div>

<!-- Tabs Navigation -->
<div class="tabs-nav">
    <a href="{{ route('admin.laws.index', ['type' => 'post1992']) }}" class="tab-btn {{ $type === 'post1992' ? 'active' : '' }}">
        Post-1992 Legislation
    </a>
    <a href="{{ route('admin.laws.index', ['type' => 'pre1992']) }}" class="tab-btn {{ $type === 'pre1992' ? 'active' : '' }}">
        Pre-1992 Legislation
    </a>
    <a href="{{ route('admin.laws.index', ['type' => 'constitutional']) }}" class="tab-btn {{ $type === 'constitutional' ? 'active' : '' }}">
        Constitutional Acts
    </a>
    <a href="{{ route('admin.laws.index', ['type' => 'executive']) }}" class="tab-btn {{ $type === 'executive' ? 'active' : '' }}">
        Executive Acts
    </a>
</div>

<div class="card-table">
    <div class="table-header" style="flex-wrap: wrap; gap: 16px;">
        <h2 class="table-title" style="text-transform: capitalize;">
            {{ str_replace('_', ' ', $type) }} Listing
        </h2>
        
        <!-- Search Form -->
        <form action="{{ route('admin.laws.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="text" name="search" class="form-control" placeholder="Search laws..." value="{{ request('search') }}" style="width: 260px; padding: 8px 16px;">
            <button type="submit" class="btn btn-primary btn-action" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.laws.index', ['type' => $type]) }}" class="btn btn-secondary btn-action" style="padding: 8px 16px;">Clear</a>
            @endif
        </form>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 80px;">Year</th>
                <th>Title</th>
                <th>Group / Category</th>
                @if($type === 'post1992')
                    <th>PDF File</th>
                @endif
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laws as $law)
                <tr>
                    <td style="font-weight: 700; color: #fff;">{{ $law->year }}</td>
                    <td style="font-weight: 500; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $law->title }}
                    </td>
                    <td>
                        @if($type === 'post1992')
                            <span class="badge badge-accent">{{ $law->post_group }}</span>
                            <span class="badge badge-secondary" style="background: rgba(255,255,255,0.05); color: var(--text-secondary);">{{ $law->post_category }}</span>
                        @elseif($type === 'pre1992')
                            <span class="badge badge-accent">{{ $law->pre_1992_group }}</span>
                        @elseif($type === 'constitutional')
                            <span class="badge badge-accent">{{ $law->constitutional_group }}</span>
                        @elseif($type === 'executive')
                            <span class="badge badge-accent">{{ $law->executive_group }}</span>
                        @endif
                    </td>
                    @if($type === 'post1992')
                        <td>
                            @if($law->upload_pdf)
                                <a href="{{ url('storage/' . $law->upload_pdf) }}" target="_blank" style="color: #60a5fa; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                                    <i class="fa-solid fa-file-pdf"></i> View PDF
                                </a>
                            @else
                                <span style="color: var(--text-secondary); font-size: 13px;">No PDF</span>
                            @endif
                        </td>
                    @endif
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.laws.edit', ['id' => $law->id, 'type' => $type]) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.laws.destroy', ['id' => $law->id, 'type' => $type]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this law?')">
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
                    <td colspan="{{ $type === 'post1992' ? 5 : 4 }}" style="text-align: center; color: var(--text-secondary); padding: 32px;">No laws found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($laws->hasPages())
        <div class="pagination-wrapper">
            <div style="color: var(--text-secondary); font-size: 14px;">
                Showing {{ $laws->firstItem() }} to {{ $laws->lastItem() }} of {{ $laws->total() }} items
            </div>
            <div style="display: flex; gap: 8px;">
                @if($laws->onFirstPage())
                    <button class="btn btn-secondary btn-action" disabled>Previous</button>
                @else
                    <a href="{{ $laws->previousPageUrl() }}" class="btn btn-secondary btn-action">Previous</a>
                @endif

                @if($laws->hasMorePages())
                    <a href="{{ $laws->nextPageUrl() }}" class="btn btn-secondary btn-action">Next</a>
                @else
                    <button class="btn btn-secondary btn-action" disabled>Next</button>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
