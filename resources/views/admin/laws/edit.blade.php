@extends('layouts.admin')

@section('title', 'Edit Law')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title" style="text-transform: capitalize;">Edit {{ str_replace('_', ' ', $type) }}</h1>
        <p class="page-subtitle">Update legal codifications, groups, or upload a new PDF.</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; margin-right: 28px;">
        <a href="{{ route('admin.laws.sections', ['id' => $law->id, 'type' => $type]) }}" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); border-color: #3b82f6;">
            <i class="fa-solid fa-layer-group"></i> Manage Sections & Schedules ({{ $sectionsCount ?? 0 }})
        </a>
        <a href="{{ route('admin.laws.index', ['type' => $type]) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="card-table" style="max-width: 800px; padding: 32px;">
    <!-- Sections & Schedules Quick Banner -->
    <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <div style="font-weight: 700; color: #fff; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-layer-group" style="color: #60a5fa;"></i> Parts, Sections & Schedules
            </div>
            <div style="font-size: 13px; color: var(--text-secondary); margin-top: 2px;">
                This law currently has <strong>{{ $sectionsCount ?? 0 }}</strong> individual sections and schedules with text/content uploaded.
            </div>
        </div>
        <a href="{{ route('admin.laws.sections', ['id' => $law->id, 'type' => $type]) }}" class="btn btn-primary btn-action" style="padding: 8px 18px; font-size: 13px; gap: 8px;">
            <span>Manage Contents</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <form action="{{ route('admin.laws.update', ['id' => $law->id, 'type' => $type]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">Law Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $law->title) }}" required>
            @error('title') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="year" class="form-label">Year</label>
                <input type="text" id="year" name="year" class="form-control" value="{{ old('year', $law->year) }}" required>
                @error('year') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <!-- Group / Category Fields based on type -->
            @if($type === 'post1992')
                <div class="form-group">
                    <label for="post_group" class="form-label">Post 1992 Group</label>
                    <select id="post_group" name="post_group" class="form-control" required>
                        <option value="" disabled>Select Group...</option>
                        @foreach($postGroups as $group)
                            <option value="{{ $group->name }}" {{ old('post_group', $law->post_group) == $group->name ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                        @if(!empty($law->post_group) && !$postGroups->contains('name', $law->post_group))
                            <option value="{{ $law->post_group }}" selected>{{ $law->post_group }}</option>
                        @endif
                    </select>
                    @error('post_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @elseif($type === 'pre1992')
                <div class="form-group">
                    <label for="pre_1992_group" class="form-label">Existing Laws Group</label>
                    <input type="text" id="pre_1992_group" name="pre_1992_group" class="form-control" value="{{ old('pre_1992_group', $law->pre_1992_group) }}" required>
                    @error('pre_1992_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @elseif($type === 'constitutional')
                <div class="form-group">
                    <label for="constitutional_group" class="form-label">Constitutional Group</label>
                    <input type="text" id="constitutional_group" name="constitutional_group" class="form-control" value="{{ old('constitutional_group', $law->constitutional_group) }}" required>
                    @error('constitutional_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @elseif($type === 'executive')
                <div class="form-group">
                    <label for="executive_group" class="form-label">Executive Group</label>
                    <input type="text" id="executive_group" name="executive_group" class="form-control" value="{{ old('executive_group', $law->executive_group) }}" required>
                    @error('executive_group') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            @endif
        </div>

        @if($type === 'post1992')
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div class="form-group">
                    <label for="post_category" class="form-label">Post Category</label>
                    <select id="post_category" name="post_category" class="form-control" required>
                        <option value="" disabled>Select Category...</option>
                        @foreach($postCategories as $category)
                            <option value="{{ $category->name }}" {{ old('post_category', $law->post_category) == $category->name ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        @if(!empty($law->post_category) && !$postCategories->contains('name', $law->post_category))
                            <option value="{{ $law->post_category }}" selected>{{ $law->post_category }}</option>
                        @endif
                    </select>
                    @error('post_category') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="upload_pdf" class="form-label">Upload Law PDF</label>
                    <div style="display: flex; gap: 12px; align-items: center;">
                        @php
                            $editPdfVal = trim($law->upload_pdf ?? '');
                            $hasEditPdf = !empty($editPdfVal) && $editPdfVal !== '[]' && $editPdfVal !== 'null' && $editPdfVal !== '[""]';
                            if ($hasEditPdf && Str::startsWith($editPdfVal, '[')) {
                                $decodedEdit = json_decode($editPdfVal, true);
                                $hasEditPdf = !empty($decodedEdit) && !empty($decodedEdit[0]['download_link'] ?? $decodedEdit[0]);
                                $editPdfPath = $decodedEdit[0]['download_link'] ?? ($decodedEdit[0] ?? null);
                            } else {
                                $editPdfPath = $editPdfVal;
                            }
                        @endphp
                        @if($hasEditPdf && $editPdfPath)
                            <a href="{{ url('storage/' . ltrim($editPdfPath, '/')) }}" target="_blank" style="color: #60a5fa; text-decoration: none; font-size: 13px;">
                                <i class="fa-solid fa-file-pdf"></i> View Current PDF
                            </a>
                        @endif
                        <input type="file" id="upload_pdf" name="upload_pdf" class="form-control" accept="application/pdf">
                    </div>
                    <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Leave blank to keep the current PDF.</small>
                    @error('upload_pdf') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
                </div>
            </div>
        @endif

        <div class="form-group">
            <label for="preamble" class="form-label">Preamble</label>
            <textarea id="preamble" name="preamble" class="form-control" style="min-height: 140px;">{{ old('preamble', $law->preamble) }}</textarea>
            @error('preamble') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
            <i class="fa-solid fa-floppy-disk"></i> Save Law Changes
        </button>
    </form>
</div>
@endsection
