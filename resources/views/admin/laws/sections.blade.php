@extends('layouts.admin')

@section('title', 'Sections & Schedules - ' . $act->title)

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
<style>
    /* Dark Theme for Quill Editor */
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
        font-family: inherit !important;
        min-height: 150px !important;
        max-height: 260px !important;
        overflow-y: auto !important;
    }
    .ql-editor {
        min-height: 150px !important;
        line-height: 1.7 !important;
        color: #f1f5f9 !important;
        font-size: 14px !important;
    }
    .ql-editor * {
        color: inherit !important;
    }
    .ql-editor p,
    .ql-editor span,
    .ql-editor div,
    .ql-editor li,
    .ql-editor strong,
    .ql-editor em,
    .ql-editor b,
    .ql-editor i {
        color: #f1f5f9 !important;
    }
    #preview-body,
    #preview-body * {
        color: #f1f5f9 !important;
    }
    .ql-editor.ql-blank::before {
        color: #64748b !important;
        font-style: normal !important;
        font-size: 13.5px !important;
    }
    .ql-snow .ql-stroke { stroke: #94a3b8 !important; }
    .ql-snow .ql-fill { fill: #94a3b8 !important; }
    .ql-snow .ql-picker { color: #cbd5e1 !important; }
    .ql-snow .ql-picker-label { border: 1px solid transparent !important; border-radius: 4px !important; }
    .ql-snow .ql-picker-label:hover { color: #60a5fa !important; }
    .ql-snow .ql-picker-label:hover .ql-stroke { stroke: #60a5fa !important; }
    .ql-snow .ql-picker.ql-expanded .ql-picker-label { border-color: rgba(59, 130, 246, 0.4) !important; color: #60a5fa !important; }
    .ql-snow .ql-picker.ql-expanded .ql-picker-options {
        background-color: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6) !important;
        border-radius: 8px !important;
        padding: 6px !important;
        z-index: 100 !important;
    }
    .ql-snow .ql-picker-item { color: #94a3b8 !important; }
    .ql-snow .ql-picker-item:hover { color: #fff !important; background-color: rgba(59, 130, 246, 0.2) !important; border-radius: 4px !important; }

    /* Part Group Card styling */
    .part-card {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .part-card:hover {
        border-color: rgba(255, 255, 255, 0.16);
    }
    .part-header {
        padding: 16px 20px;
        background: rgba(255, 255, 255, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        user-select: none;
        border-bottom: 1px solid transparent;
        transition: background 0.15s;
    }
    .part-header:hover {
        background: rgba(255, 255, 255, 0.04);
    }
    .part-header.open {
        border-bottom-color: rgba(255, 255, 255, 0.06);
    }
    .part-body {
        display: none;
    }
    .part-card.is-open > .part-body {
        display: block;
    }
    .part-title {
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    .part-toggle-icon {
        color: var(--text-secondary);
        transition: transform 0.2s;
        font-size: 13px;
    }
    .part-header.open .part-toggle-icon {
        transform: rotate(180deg);
    }

    /* Section item row */
    .section-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        transition: background 0.15s;
        gap: 16px;
    }
    .section-item-row:last-child {
        border-bottom: none;
    }
    .section-item-row:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    /* Modal Backdrop */
    .custom-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .custom-modal-dialog {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        width: 760px;
        max-width: 96vw;
        max-height: 88vh;
        max-height: calc(100vh - 48px);
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }
    .custom-modal-dialog form {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        min-height: 0;
        overflow: hidden;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.97) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-color);
        flex-shrink: 0;
    }
    .modal-close-btn {
        background: transparent;
        border: none;
        color: var(--text-secondary);
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        transition: color 0.15s;
    }
    .modal-close-btn:hover { color: #fff; }
    .custom-modal-body {
        padding: 20px 24px;
        overflow-y: auto !important;
        flex: 1 1 auto;
        min-height: 0;
    }
    .custom-modal-body .form-group {
        margin-bottom: 14px;
    }
    .custom-modal-body .form-group:last-child {
        margin-bottom: 0;
    }
    .custom-modal-body::-webkit-scrollbar {
        width: 6px;
    }
    .custom-modal-body::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 4px;
    }
    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 14px 24px;
        border-top: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.02);
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')
<div class="page-header" style="flex-wrap: wrap; gap: 16px;">
    <div>
        <div style="font-size: 12px; font-weight: 700; color: #60a5fa; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-book-bookmark"></i> {{ strtoupper(str_replace('_', ' ', $type)) }} &bull; YEAR {{ $act->year }}
        </div>
        <h1 class="page-title" style="font-size: 22px; margin-bottom: 6px; line-height: 1.3;">
            {{ $act->title }}
        </h1>
        <p class="page-subtitle" style="margin: 0;">
            Manage and upload the individual Parts, Sections, and Schedules containing the legal articles.
        </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; margin-right: 28px;">
        <a href="{{ route('admin.laws.edit', ['id' => $act->id, 'type' => $type]) }}" class="btn btn-secondary">
            <i class="fa-solid fa-pen-to-square"></i> Edit Law Details
        </a>
        <a href="{{ route('admin.laws.index', ['type' => $type]) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Laws
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px;">
        <div style="font-weight: 600; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-triangle-exclamation"></i> Please fix the errors below:
        </div>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Stats & Action Bar -->
<div class="card-table" style="padding: 18px 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <!-- Badges / Summary -->
    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <span style="font-size: 13px; color: var(--text-secondary);">
            Total: <strong style="color: #fff;">{{ $allArticles->count() }}</strong> items
        </span>
        <span style="height: 16px; width: 1px; background: var(--border-color);"></span>
        <span class="badge-accent" style="font-size: 12px; background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
            <i class="fa-solid fa-layer-group"></i> {{ count($groupedParts) }} Parts
        </span>
        <span class="badge-accent" style="font-size: 12px; background: rgba(16, 185, 129, 0.15); color: #34d399;">
            <i class="fa-solid fa-file-lines"></i> {{ collect($groupedParts)->flatten(1)->count() + count($generalSections) }} Sections
        </span>
        <span class="badge-accent" style="font-size: 12px; background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
            <i class="fa-solid fa-table-list"></i> {{ count($schedules) }} Schedules
        </span>
    </div>

    <!-- Actions & Filter -->
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <div style="position: relative;">
            <input type="text" id="filterInput" class="form-control" placeholder="Quick filter sections..." style="width: 220px; padding-left: 32px; height: 38px; font-size: 13px;" onkeyup="filterSections()">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 11px; top: 12px; color: var(--text-secondary); font-size: 12px;"></i>
        </div>
        <div style="display: flex; align-items: center; gap: 6px;">
            <button type="button" class="btn btn-secondary" onclick="toggleAllParts(true)" title="Expand All Parts" style="height: 38px; font-size: 12.5px; padding: 0 12px; gap: 6px;">
                <i class="fa-solid fa-angles-down"></i> Expand All
            </button>
            <button type="button" class="btn btn-secondary" onclick="toggleAllParts(false)" title="Collapse All Parts" style="height: 38px; font-size: 12.5px; padding: 0 12px; gap: 6px;">
                <i class="fa-solid fa-angles-up"></i> Collapse All
            </button>
        </div>
        <button type="button" class="btn btn-primary" onclick="openAddSectionModal()" style="height: 38px; font-size: 13px;">
            <i class="fa-solid fa-plus"></i> Add Section
        </button>
        <button type="button" class="btn btn-primary" onclick="openAddScheduleModal()" style="height: 38px; font-size: 13px; background: #f59e0b; border-color: #f59e0b; color: #000;">
            <i class="fa-solid fa-table-list"></i> Add Schedule
        </button>
    </div>
</div>

<!-- ============================================
     SECTIONS GROUPED BY PART
     ============================================ -->
@if(count($groupedParts) === 0 && count($schedules) === 0 && count($generalSections) === 0)
    <div class="card-table" style="text-align: center; padding: 60px 24px;">
        <i class="fa-regular fa-folder-open" style="font-size: 48px; color: var(--text-secondary); opacity: 0.4; margin-bottom: 16px; display: block;"></i>
        <h3 style="color: #fff; margin-bottom: 8px;">No Sections or Schedules Added Yet</h3>
        <p style="color: var(--text-secondary); max-width: 500px; margin: 0 auto 20px; font-size: 14px;">
            Start building the contents of this law by adding sections under specific Parts or adding Schedules.
        </p>
        <div style="display: flex; justify-content: center; gap: 12px;">
            <button type="button" class="btn btn-primary" onclick="openAddSectionModal()">
                <i class="fa-solid fa-plus"></i> Add First Section
            </button>
            <button type="button" class="btn btn-primary" onclick="openAddScheduleModal()" style="background: #f59e0b; border-color: #f59e0b; color: #000;">
                <i class="fa-solid fa-table-list"></i> Add Schedule
            </button>
        </div>
    </div>
@endif

<!-- Parts Accordions -->
@foreach($groupedParts as $partName => $sections)
    <div class="part-card part-container-block">
        <div class="part-header" onclick="togglePartCard(this)">
            <div class="part-title">
                <i class="fa-solid fa-layer-group" style="color: #3b82f6; font-size: 14px;"></i>
                <span class="part-name-text">{{ $partName }}</span>
                <span style="font-size: 11px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; padding: 2px 8px; border-radius: 10px; font-weight: 600;">
                    {{ count($sections) }} {{ Str::plural('section', count($sections)) }}
                </span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <button type="button" class="btn btn-secondary btn-action" title="Add Section to this Part" onclick="event.stopPropagation(); openAddSectionModal('{{ addslashes($partName) }}')" style="padding: 4px 10px; font-size: 12px; gap: 6px;">
                    <i class="fa-solid fa-plus"></i> Add to this Part
                </button>
                <i class="fa-solid fa-chevron-down part-toggle-icon"></i>
            </div>
        </div>

        <div class="part-body">
            @foreach($sections as $sec)
                <div class="section-item-row" data-search="{{ strtolower($sec->section . ' ' . $partName) }}" data-part="{{ $partName }}" data-priority="{{ $sec->priority ?? 0 }}">
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                            <span style="font-size: 11px; background: rgba(59, 130, 246, 0.12); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25); padding: 2px 8px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-arrow-down-1-9" style="font-size: 10px;"></i> Priority / Order: {{ $sec->priority ?? 0 }}
                            </span>
                            <span style="font-weight: 600; color: #fff; font-size: 14px;">
                                {{ $sec->section }}
                            </span>
                        </div>
                        <div style="color: var(--text-secondary); font-size: 12.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 700px;">
                            {{ Str::limit(strip_tags($sec->content), 120) }}
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                        <button type="button" class="btn-action" title="Preview Full Content" onclick="openPreviewModal('{{ addslashes($sec->section) }}', '{{ addslashes($partName) }}', {{ json_encode($sec->content) }}, {{ $sec->priority ?? 0 }})" style="color: #60a5fa; border-color: rgba(59, 130, 246, 0.3);">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn-action edit" title="Edit Section" onclick="openEditSectionModal({{ $sec->id }}, '{{ addslashes($partName) }}', '{{ addslashes($sec->section) }}', {{ $sec->priority ?? 0 }}, {{ json_encode($sec->content) }}, false)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.laws.sections.destroy', ['id' => $act->id, 'sectionId' => $sec->id, 'type' => $type]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this section?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" title="Delete Section">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<!-- Schedules Block -->
@if(count($schedules) > 0)
    <div class="part-card part-container-block" style="border-color: rgba(245, 158, 11, 0.3);">
        <div class="part-header" onclick="togglePartCard(this)" style="background: rgba(245, 158, 11, 0.05);">
            <div class="part-title">
                <i class="fa-solid fa-table-list" style="color: #f59e0b; font-size: 14px;"></i>
                <span class="part-name-text">SCHEDULES</span>
                <span style="font-size: 11px; background: rgba(245, 158, 11, 0.15); color: #fbbf24; padding: 2px 8px; border-radius: 10px; font-weight: 600;">
                    {{ count($schedules) }} {{ Str::plural('schedule', count($schedules)) }}
                </span>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <button type="button" class="btn btn-secondary btn-action" title="Add Another Schedule" onclick="event.stopPropagation(); openAddScheduleModal()" style="padding: 4px 10px; font-size: 12px; gap: 6px; border-color: rgba(245, 158, 11, 0.4); color: #fbbf24;">
                    <i class="fa-solid fa-plus"></i> Add Schedule
                </button>
                <i class="fa-solid fa-chevron-down part-toggle-icon"></i>
            </div>
        </div>

        <div class="part-body">
            @foreach($schedules as $sch)
                <div class="section-item-row" data-search="{{ strtolower($sch->section . ' schedule schedules') }}" data-part="SCHEDULE" data-priority="{{ $sch->priority ?? 0 }}">
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                            <span style="font-size: 11px; background: rgba(245, 158, 11, 0.12); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.25); padding: 2px 8px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-arrow-down-1-9" style="font-size: 10px;"></i> Priority / Order: {{ $sch->priority ?? 0 }}
                            </span>
                            <span style="font-weight: 600; color: #fbbf24; font-size: 14px;">
                                {{ $sch->section }}
                            </span>
                        </div>
                        <div style="color: var(--text-secondary); font-size: 12.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 700px;">
                            {{ Str::limit(strip_tags($sch->content), 120) }}
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                        <button type="button" class="btn-action" title="Preview Full Schedule Content" onclick="openPreviewModal('{{ addslashes($sch->section) }}', 'SCHEDULE', {{ json_encode($sch->content) }}, {{ $sch->priority ?? 0 }})" style="color: #fbbf24; border-color: rgba(245, 158, 11, 0.3);">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn-action edit" title="Edit Schedule" onclick="openEditSectionModal({{ $sch->id }}, 'SCHEDULE', '{{ addslashes($sch->section) }}', {{ $sch->priority ?? 0 }}, {{ json_encode($sch->content) }}, true)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.laws.sections.destroy', ['id' => $act->id, 'sectionId' => $sch->id, 'type' => $type]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" title="Delete Schedule">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- General / Standalone Sections Block (if any without Part) -->
@if(count($generalSections) > 0)
    <div class="part-card part-container-block">
        <div class="part-header" onclick="togglePartCard(this)">
            <div class="part-title">
                <i class="fa-solid fa-file-lines" style="color: #94a3b8; font-size: 14px;"></i>
                <span class="part-name-text">General Sections (No Part Assigned)</span>
                <span style="font-size: 11px; background: rgba(255, 255, 255, 0.1); color: var(--text-secondary); padding: 2px 8px; border-radius: 10px; font-weight: 600;">
                    {{ count($generalSections) }}
                </span>
            </div>
            <i class="fa-solid fa-chevron-down part-toggle-icon"></i>
        </div>

        <div class="part-body">
            @foreach($generalSections as $gSec)
                <div class="section-item-row" data-search="{{ strtolower($gSec->section) }}" data-part="" data-priority="{{ $gSec->priority ?? 0 }}">
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                            <span style="font-size: 11px; background: rgba(148, 163, 184, 0.12); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.25); padding: 2px 8px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-arrow-down-1-9" style="font-size: 10px;"></i> Priority / Order: {{ $gSec->priority ?? 0 }}
                            </span>
                            <span style="font-weight: 600; color: #fff; font-size: 14px;">
                                {{ $gSec->section }}
                            </span>
                        </div>
                        <div style="color: var(--text-secondary); font-size: 12.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 700px;">
                            {{ Str::limit(strip_tags($gSec->content), 120) }}
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                        <button type="button" class="btn-action" title="Preview Full Content" onclick="openPreviewModal('{{ addslashes($gSec->section) }}', '', {{ json_encode($gSec->content) }}, {{ $gSec->priority ?? 0 }})" style="color: #60a5fa; border-color: rgba(59, 130, 246, 0.3);">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn-action edit" title="Edit Section" onclick="openEditSectionModal({{ $gSec->id }}, '', '{{ addslashes($gSec->section) }}', {{ $gSec->priority ?? 0 }}, {{ json_encode($gSec->content) }}, false)">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.laws.sections.destroy', ['id' => $act->id, 'sectionId' => $gSec->id, 'type' => $type]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this section?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete" title="Delete Section">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- ============================================
     MODALS
     ============================================ -->

<!-- Modal: Add Section -->
<div id="modal-add-section" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h3 style="margin: 0; font-size: 17px; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-plus" style="color: #3b82f6;"></i> Add New Section
            </h3>
            <button type="button" onclick="closeAddSectionModal()" class="modal-close-btn">&times;</button>
        </div>
        <form action="{{ route('admin.laws.sections.store', ['id' => $act->id, 'type' => $type]) }}" method="POST" onsubmit="return submitAddSectionForm()">
            @csrf
            <input type="hidden" name="is_schedule" value="0">
            <div class="custom-modal-body">
                <!-- Part Selection -->
                <div class="form-group">
                    <label class="form-label" for="add-part-select">Belongs to Part</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <select id="add-part-select" class="form-control" onchange="handlePartSelectChange(this)">
                                <option value="">Select Existing Part...</option>
                                @foreach($distinctParts as $dp)
                                    <option value="{{ $dp }}">{{ $dp }}</option>
                                @endforeach
                                <option value="__NEW__">+ Enter New Part Name...</option>
                            </select>
                        </div>
                        <div>
                            <input type="text" id="add-part-custom" name="part" class="form-control" placeholder="e.g. Part 1 – Preliminary Provisions">
                        </div>
                    </div>
                    <small style="color: var(--text-secondary); display: block; margin-top: 4px;">
                        Choose an existing part from this law or type a new one. Leave blank for standalone sections.
                    </small>
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="add-section-title">Section Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="add-section-title" name="section" class="form-control" placeholder="e.g. Section 1 - Application of this Act" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="add-section-priority">Priority / Order</label>
                        <input type="number" id="add-section-priority" name="priority" class="form-control" value="0" placeholder="0">
                    </div>
                </div>

                <!-- Quill Content Editor -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Section Content / Clauses <span style="color: #ef4444;">*</span></label>
                    <textarea id="add-section-content" name="content" style="display: none;"></textarea>
                    <div id="quill-add-section-editor"></div>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddSectionModal()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Save Section</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Schedule -->
<div id="modal-add-schedule" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h3 style="margin: 0; font-size: 17px; color: #fbbf24; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-table-list" style="color: #f59e0b;"></i> Add Schedule
            </h3>
            <button type="button" onclick="closeAddScheduleModal()" class="modal-close-btn">&times;</button>
        </div>
        <form action="{{ route('admin.laws.sections.store', ['id' => $act->id, 'type' => $type]) }}" method="POST" onsubmit="return submitAddScheduleForm()">
            @csrf
            <input type="hidden" name="is_schedule" value="1">
            <input type="hidden" name="part" value="SCHEDULE">
            <div class="custom-modal-body">
                <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 8px; padding: 10px 14px; margin-bottom: 16px; font-size: 13px; color: #fbbf24;">
                    <i class="fa-solid fa-info-circle"></i> This item will automatically be classified under <strong>SCHEDULE</strong> in the law's table of contents.
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="add-schedule-title">Schedule Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="add-schedule-title" name="section" class="form-control" placeholder="e.g. First Schedule" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="add-schedule-priority">Priority / Order</label>
                        <input type="number" id="add-schedule-priority" name="priority" class="form-control" value="0" placeholder="0">
                    </div>
                </div>

                <!-- Quill Schedule Content Editor -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Schedule Content / Provisions <span style="color: #ef4444;">*</span></label>
                    <textarea id="add-schedule-content" name="content" style="display: none;"></textarea>
                    <div id="quill-add-schedule-editor"></div>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddScheduleModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #f59e0b; border-color: #f59e0b; color: #000;">
                    <i class="fa-solid fa-check"></i> Save Schedule
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Section / Schedule -->
<div id="modal-edit-section" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h3 id="edit-modal-heading" style="margin: 0; font-size: 17px; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: #3b82f6;"></i> Edit Section
            </h3>
            <button type="button" onclick="closeEditSectionModal()" class="modal-close-btn">&times;</button>
        </div>
        <form id="form-edit-section" method="POST" onsubmit="return submitEditSectionForm()">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-is-schedule" name="is_schedule" value="0">
            <div class="custom-modal-body">
                <!-- Part Selection (shown only for regular sections) -->
                <div class="form-group" id="edit-part-group">
                    <label class="form-label" for="edit-part">Part Name</label>
                    <input type="text" id="edit-part" name="part" class="form-control" placeholder="e.g. Part 1 – Preliminary Provisions">
                    <small style="color: var(--text-secondary); display: block; margin-top: 4px;">
                        Update the Part grouping if needed.
                    </small>
                </div>

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="edit-section-title">Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="edit-section-title" name="section" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit-section-priority">Priority / Order</label>
                        <input type="number" id="edit-section-priority" name="priority" class="form-control">
                    </div>
                </div>

                <!-- Quill Content Editor -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Content / Body <span style="color: #ef4444;">*</span></label>
                    <textarea id="edit-section-content" name="content" style="display: none;"></textarea>
                    <div id="quill-edit-section-editor"></div>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditSectionModal()">Cancel</button>
                <button type="submit" id="edit-submit-btn" class="btn btn-primary"><i class="fa-solid fa-check"></i> Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Content Preview -->
<div id="modal-preview" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog" style="width: 820px;">
        <div class="custom-modal-header">
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <span id="preview-part-badge" style="font-size: 11px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; padding: 2px 8px; border-radius: 6px; font-weight: 600; text-transform: uppercase;"></span>
                    <span id="preview-priority-badge" style="font-size: 11px; background: rgba(255, 255, 255, 0.08); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.15); padding: 2px 8px; border-radius: 6px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                        <i class="fa-solid fa-arrow-down-1-9" style="font-size: 10px;"></i> <span id="preview-priority-text">Priority / Order: 0</span>
                    </span>
                </div>
                <h3 id="preview-title" style="margin: 0; font-size: 17px; color: #fff;"></h3>
            </div>
            <button type="button" onclick="closePreviewModal()" class="modal-close-btn">&times;</button>
        </div>
        <div class="custom-modal-body" style="background: #090d16;">
            <div id="preview-body" style="color: #cbd5e1; line-height: 1.8; font-size: 14.5px;"></div>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closePreviewModal()">Close Preview</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
    const toolbarConfig = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['blockquote', 'code-block'],
        [{ 'align': [] }],
        ['clean']
    ];

    let quillAddSection = null;
    let quillAddSchedule = null;
    let quillEditSection = null;

    document.addEventListener('DOMContentLoaded', function() {
        quillAddSection = new Quill('#quill-add-section-editor', {
            theme: 'snow',
            placeholder: 'Write or paste the full content of this section...',
            modules: { toolbar: toolbarConfig }
        });

        quillAddSchedule = new Quill('#quill-add-schedule-editor', {
            theme: 'snow',
            placeholder: 'Write or paste the schedule content/table...',
            modules: { toolbar: toolbarConfig }
        });

        quillEditSection = new Quill('#quill-edit-section-editor', {
            theme: 'snow',
            placeholder: 'Edit the content...',
            modules: { toolbar: toolbarConfig }
        });
    });

    // Part card accordion collapse toggle
    function togglePartCard(header) {
        const card = header.closest('.part-card');
        const isOpen = header.classList.toggle('open');
        if (card) {
            card.classList.toggle('is-open', isOpen);
        }
        const body = header.nextElementSibling;
        if (body) {
            body.style.display = isOpen ? 'block' : 'none';
        }
    }

    // Expand or Collapse All Parts
    function toggleAllParts(expand) {
        document.querySelectorAll('.part-container-block').forEach(card => {
            const header = card.querySelector('.part-header');
            const body = card.querySelector('.part-body');
            if (header && body) {
                if (expand) {
                    header.classList.add('open');
                    card.classList.add('is-open');
                    body.style.display = 'block';
                } else {
                    header.classList.remove('open');
                    card.classList.remove('is-open');
                    body.style.display = 'none';
                }
            }
        });
    }

    // Quick filter across sections and parts
    function filterSections() {
        const query = document.getElementById('filterInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.section-item-row');
        const partContainers = document.querySelectorAll('.part-container-block');

        rows.forEach(row => {
            const text = row.getAttribute('data-search') || '';
            row.style.display = (query === '' || text.includes(query)) ? 'flex' : 'none';
        });

        // If searching, auto-expand containers with matching rows; otherwise respect user state
        partContainers.forEach(container => {
            const header = container.querySelector('.part-header');
            const body = container.querySelector('.part-body');
            if (query === '') {
                container.style.display = 'block';
                if (header && body && !header.classList.contains('open')) {
                    body.style.display = 'none';
                }
            } else {
                const visibleChildRows = container.querySelectorAll('.section-item-row[style*="display: flex"]');
                if (visibleChildRows.length > 0) {
                    container.style.display = 'block';
                    if (header && body) {
                        header.classList.add('open');
                        container.classList.add('is-open');
                        body.style.display = 'block';
                    }
                } else {
                    container.style.display = 'none';
                }
            }
        });
    }

    // Helper: calculate highest priority for a given part or schedule
    function getNextPriority(partName = '') {
        let maxPriority = 0;
        document.querySelectorAll('.section-item-row').forEach(row => {
            const rowPart = row.getAttribute('data-part') || '';
            const rowPriority = parseInt(row.getAttribute('data-priority'), 10) || 0;
            if (partName === '' || rowPart.toLowerCase() === partName.toLowerCase()) {
                if (rowPriority > maxPriority) {
                    maxPriority = rowPriority;
                }
            }
        });
        return maxPriority + 1;
    }

    // Part dropdown vs custom text input handler
    function handlePartSelectChange(select) {
        const customInput = document.getElementById('add-part-custom');
        if (select.value === '__NEW__') {
            customInput.value = '';
            customInput.focus();
        } else if (select.value !== '') {
            customInput.value = select.value;
            document.getElementById('add-section-priority').value = getNextPriority(select.value);
        }
    }

    // Add Section Modal
    function openAddSectionModal(prefilledPart = '') {
        document.getElementById('modal-add-section').style.display = 'flex';
        document.getElementById('add-section-title').value = '';
        document.getElementById('add-part-custom').value = prefilledPart;
        
        const select = document.getElementById('add-part-select');
        select.value = prefilledPart || '';

        // Auto-calculate next sequential priority for this part
        const nextPri = getNextPriority(prefilledPart);
        document.getElementById('add-section-priority').value = nextPri;
        
        if (quillAddSection) {
            quillAddSection.root.innerHTML = '';
        }
    }
    function closeAddSectionModal() {
        document.getElementById('modal-add-section').style.display = 'none';
    }
    function submitAddSectionForm() {
        const html = quillAddSection.root.innerHTML;
        if (quillAddSection.getText().trim() === '') {
            alert('Please provide content for this section.');
            return false;
        }
        document.getElementById('add-section-content').value = html;
        return true;
    }

    // Add Schedule Modal
    function openAddScheduleModal() {
        document.getElementById('modal-add-schedule').style.display = 'flex';
        document.getElementById('add-schedule-title').value = '';
        
        // Auto-calculate next sequential priority for schedules
        const nextPri = getNextPriority('SCHEDULE');
        document.getElementById('add-schedule-priority').value = nextPri;

        if (quillAddSchedule) {
            quillAddSchedule.root.innerHTML = '';
        }
    }
    function closeAddScheduleModal() {
        document.getElementById('modal-add-schedule').style.display = 'none';
    }
    function submitAddScheduleForm() {
        const html = quillAddSchedule.root.innerHTML;
        if (quillAddSchedule.getText().trim() === '') {
            alert('Please provide content for this schedule.');
            return false;
        }
        document.getElementById('add-schedule-content').value = html;
        return true;
    }

    // Edit Section Modal
    function openEditSectionModal(id, part, title, priority, content, isSchedule) {
        const modal = document.getElementById('modal-edit-section');
        const form = document.getElementById('form-edit-section');
        form.action = "{{ url('admin/laws/' . $act->id . '/sections') }}/" + id + "/{{ $type }}/update";

        document.getElementById('edit-is-schedule').value = isSchedule ? '1' : '0';
        document.getElementById('edit-part').value = part;
        document.getElementById('edit-section-title').value = title;
        document.getElementById('edit-section-priority').value = priority;

        const heading = document.getElementById('edit-modal-heading');
        const partGroup = document.getElementById('edit-part-group');
        const submitBtn = document.getElementById('edit-submit-btn');

        if (isSchedule) {
            heading.innerHTML = '<i class="fa-solid fa-table-list" style="color: #f59e0b;"></i> Edit Schedule';
            partGroup.style.display = 'none';
            submitBtn.style.background = '#f59e0b';
            submitBtn.style.borderColor = '#f59e0b';
            submitBtn.style.color = '#000';
        } else {
            heading.innerHTML = '<i class="fa-solid fa-pen-to-square" style="color: #3b82f6;"></i> Edit Section';
            partGroup.style.display = 'block';
            submitBtn.style.background = '';
            submitBtn.style.borderColor = '';
            submitBtn.style.color = '';
        }

        if (quillEditSection) {
            quillEditSection.root.innerHTML = content || '';
        }

        modal.style.display = 'flex';
    }
    function closeEditSectionModal() {
        document.getElementById('modal-edit-section').style.display = 'none';
    }
    function submitEditSectionForm() {
        const html = quillEditSection.root.innerHTML;
        if (quillEditSection.getText().trim() === '') {
            alert('Content cannot be empty.');
            return false;
        }
        document.getElementById('edit-section-content').value = html;
        return true;
    }

    // Content Preview Modal
    function openPreviewModal(title, part, content, priority = 0) {
        const modal = document.getElementById('modal-preview');
        document.getElementById('preview-title').textContent = title;
        document.getElementById('preview-part-badge').textContent = part || 'General Section';
        document.getElementById('preview-priority-text').textContent = 'Priority / Order: ' + priority;
        document.getElementById('preview-body').innerHTML = content || '<p style="color: var(--text-secondary);">No content recorded.</p>';
        modal.style.display = 'flex';
    }
    function closePreviewModal() {
        document.getElementById('modal-preview').style.display = 'none';
    }

    // Modal closing triggers
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddSectionModal();
            closeAddScheduleModal();
            closeEditSectionModal();
            closePreviewModal();
        }
    });

    ['modal-add-section', 'modal-add-schedule', 'modal-edit-section', 'modal-preview'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection
