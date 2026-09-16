@extends('layouts.admin')

@section('title', 'Edit Country Constitution - ' . $constitution->country)

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow {
        background: #121824 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important;
        padding: 8px 12px !important;
    }
    .ql-container.ql-snow {
        background: #090d16 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-top: none !important;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        color: #e2e8f0 !important;
        font-size: 14px !important;
        min-height: 240px !important;
    }
    .ql-editor { min-height: 240px !important; line-height: 1.7 !important; color: #f1f5f9 !important; }
    .ql-editor * { color: #f1f5f9 !important; }
    .ql-snow .ql-stroke { stroke: #94a3b8 !important; }
    .ql-snow .ql-fill { fill: #94a3b8 !important; }
    .ql-snow .ql-picker { color: #cbd5e1 !important; }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('admin.constitutions.index', ['tab' => 'foreign']) }}" class="btn btn-secondary" style="margin-bottom: 10px; display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; padding: 6px 12px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Foreign Constitutions
        </a>
        <h1 class="page-title">Edit {{ $constitution->country }} Constitution</h1>
        <p class="page-subtitle">Update preamble, details, and constitutional articles.</p>
    </div>
</div>

<div class="card-table" style="padding: 24px; max-width: 900px;">
    <form id="form-foreign-edit" action="{{ route('admin.constitutions.foreign.update', $constitution->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Continent</label>
                <select name="continent" class="form-control" required style="width: 100%;">
                    @foreach($continents as $con)
                        <option value="{{ $con }}" {{ $constitution->continent === $con ? 'selected' : '' }}>{{ $con }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Country Name</label>
                <input type="text" name="country" class="form-control" value="{{ $constitution->country }}" required style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px; margin-bottom: 18px;">
            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Constitution Title</label>
                <input type="text" name="title" class="form-control" value="{{ $constitution->title }}" required style="width: 100%;">
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Year</label>
                <input type="text" name="year" class="form-control" value="{{ $constitution->year }}" style="width: 100%;">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Preamble</label>
            <div id="preamble-editor"></div>
            <textarea name="preamble" id="preamble-hidden" style="display: none;"></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Full Constitution Content / Articles</label>
            <div id="content-editor"></div>
            <textarea name="content" id="content-hidden" style="display: none;"></textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                <i class="fa-solid fa-floppy-disk"></i> Update Constitution
            </button>
            <a href="{{ route('admin.constitutions.index', ['tab' => 'foreign']) }}" class="btn btn-secondary" style="padding: 10px 20px;">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preambleQuill = new Quill('#preamble-editor', {
            theme: 'snow',
            placeholder: 'Enter constitution preamble...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });
        preambleQuill.root.innerHTML = {!! json_encode($constitution->preamble ?? '') !!};

        const contentQuill = new Quill('#content-editor', {
            theme: 'snow',
            placeholder: 'Enter constitution text, chapters, and articles...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['clean']
                ]
            }
        });
        contentQuill.root.innerHTML = {!! json_encode($constitution->content ?? '') !!};

        document.getElementById('form-foreign-edit').addEventListener('submit', function() {
            document.getElementById('preamble-hidden').value = preambleQuill.root.innerHTML;
            document.getElementById('content-hidden').value = contentQuill.root.innerHTML;
        });
    });
</script>
@endsection
