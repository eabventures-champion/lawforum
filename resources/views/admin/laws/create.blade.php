@extends('layouts.admin')

@section('title', 'Add New Law')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title" style="text-transform: capitalize;">Add New {{ str_replace('_', ' ', $type) }}</h1>
        <p class="page-subtitle">Add a new legislation entry to the database.</p>
    </div>
    <a href="{{ route('admin.laws.index', ['type' => $type]) }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card-table" style="max-width: 800px; padding: 32px;">
    <form action="{{ route('admin.laws.store', ['type' => $type]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">Law Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter the full law title..." required>
            @error('title') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="year" class="form-label">Year</label>
                <input type="text" id="year" name="year" class="form-control" value="{{ old('year') }}" placeholder="e.g. 1992" max="4" required>
                @error('year') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <!-- Group / Category Fields based on type -->
            @if($type === 'post1992')
                <div class="form-group">
                    <label for="post_group" class="form-label">Post 1992 Group</label>
                    <input type="text" id="post_group" name="post_group" class="form-control" value="{{ old('post_group') }}" placeholder="e.g. ACTS OF PARLIAMENT" required>
                    @error('post_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @elseif($type === 'pre1992')
                <div class="form-group">
                    <label for="pre_1992_group" class="form-label">Pre 1992 Group</label>
                    <input type="text" id="pre_1992_group" name="pre_1992_group" class="form-control" value="{{ old('pre_1992_group') }}" placeholder="e.g. DECREES" required>
                    @error('pre_1992_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @elseif($type === 'constitutional')
                <div class="form-group">
                    <label for="constitutional_group" class="form-label">Constitutional Group</label>
                    <input type="text" id="constitutional_group" name="constitutional_group" class="form-control" value="{{ old('constitutional_group') }}" placeholder="e.g. CONSTITUTIONAL INSTRUMENTS" required>
                    @error('constitutional_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @elseif($type === 'executive')
                <div class="form-group">
                    <label for="executive_group" class="form-label">Executive Group</label>
                    <input type="text" id="executive_group" name="executive_group" class="form-control" value="{{ old('executive_group') }}" placeholder="e.g. EXECUTIVE INSTRUMENTS" required>
                    @error('executive_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @endif
        </div>

        @if($type === 'post1992')
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label for="post_category" class="form-label">Post Category</label>
                    <input type="text" id="post_category" name="post_category" class="form-control" value="{{ old('post_category') }}" placeholder="e.g. Finance" required>
                    @error('post_category') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="upload_pdf" class="form-label">Upload Law PDF</label>
                    <input type="file" id="upload_pdf" name="upload_pdf" class="form-control" accept="application/pdf">
                    @error('upload_pdf') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            </div>
        @endif

        <div class="form-group">
            <label for="preamble" class="form-label">Preamble</label>
            <textarea id="preamble" name="preamble" class="form-control" placeholder="Write law preamble here..." style="min-height: 140px;">{{ old('preamble') }}</textarea>
            @error('preamble') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
            <i class="fa-solid fa-folder-plus"></i> Save Law Entry
        </button>
    </form>
</div>
@endsection
