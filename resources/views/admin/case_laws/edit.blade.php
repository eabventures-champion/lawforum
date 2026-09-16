@extends('layouts.admin')

@section('title', 'Edit Case Law')

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
        min-height: 280px !important;
    }
    .ql-editor { min-height: 280px !important; line-height: 1.7 !important; color: #f1f5f9 !important; }
    .ql-editor * { color: #f1f5f9 !important; }
    .ql-snow .ql-stroke { stroke: #94a3b8 !important; }
    .ql-snow .ql-fill { fill: #94a3b8 !important; }
    .ql-snow .ql-picker { color: #cbd5e1 !important; }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <a href="{{ route('admin.case-laws.index', ['court' => $case->gh_law_judgment_group_name]) }}" class="btn btn-secondary" style="margin-bottom: 10px; display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; padding: 6px 12px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Case Laws
        </a>
        <h1 class="page-title">Edit Case Law</h1>
        <p class="page-subtitle">Update judgment details, suit number, bench panel, or ruling text.</p>
    </div>
</div>

<div class="card-table" style="padding: 24px; max-width: 950px;">
    <form id="form-case-edit" action="{{ route('admin.case-laws.update', $case->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 18px;">
            <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Case Title</label>
            <input type="text" name="case_title" class="form-control" value="{{ $case->case_title }}" required style="width: 100%;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 18px;">
            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Court</label>
                <select name="court_group" class="form-control" required style="width: 100%;">
                    @foreach($courtGroups as $k => $label)
                        <option value="{{ $k }}" {{ $case->gh_law_judgment_group_name === $k ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Suit / Reference Number</label>
                <input type="text" name="reference_number" class="form-control" value="{{ $case->reference_number }}" style="width: 100%;">
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Legal Category</label>
                <input type="text" name="category_name" list="categories-list" class="form-control" value="{{ $case->gh_law_judgment_category_name }}" style="width: 100%;">
                <datalist id="categories-list">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 18px;">
            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Year</label>
                <input type="text" name="year" class="form-control" value="{{ $case->year }}" style="width: 100%;">
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Judgment Date</label>
                <input type="text" name="date" class="form-control" value="{{ $case->date }}" style="width: 100%;">
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Judgment Type</label>
                <input type="text" name="judgement_type" class="form-control" value="{{ $case->judgement_type ?: 'Judgment' }}" style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Coram (Presiding Judges)</label>
                <input type="text" name="coram" class="form-control" value="{{ $case->coram }}" style="width: 100%;">
            </div>

            <div class="form-group">
                <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Counsel / Counsellors</label>
                <input type="text" name="counsellors" class="form-control" value="{{ $case->counsellors }}" style="width: 100%;">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label" style="display: block; font-size: 13px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Full Judgment Text / Ruling</label>
            <div id="case-content-editor"></div>
            <textarea name="content" id="case-content-hidden" style="display: none;"></textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">
                <i class="fa-solid fa-floppy-disk"></i> Update Case Law
            </button>
            <a href="{{ route('admin.case-laws.index', ['court' => $case->gh_law_judgment_group_name]) }}" class="btn btn-secondary" style="padding: 10px 20px;">
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
        const quill = new Quill('#case-content-editor', {
            theme: 'snow',
            placeholder: 'Enter full court judgment, reasoning, and decision...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote'],
                    ['clean']
                ]
            }
        });
        quill.root.innerHTML = {!! json_encode($case->content ?? '') !!};

        document.getElementById('form-case-edit').addEventListener('submit', function() {
            document.getElementById('case-content-hidden').value = quill.root.innerHTML;
        });
    });
</script>
@endsection
