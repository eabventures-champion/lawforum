@extends('layouts.admin')

@section('title', 'The Constitution')

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
        min-height: 180px !important;
        max-height: 280px !important;
        overflow-y: auto !important;
    }
    .ql-editor {
        min-height: 180px !important;
        line-height: 1.7 !important;
        color: #f1f5f9 !important;
    }
    .ql-editor * { color: #f1f5f9 !important; }
    .ql-snow .ql-stroke { stroke: #94a3b8 !important; }
    .ql-snow .ql-fill { fill: #94a3b8 !important; }
    .ql-snow .ql-picker { color: #cbd5e1 !important; }

    /* Modal Backdrop */
    .custom-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 1050;
        background: rgba(0, 0, 0, 0.78);
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
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85);
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
        background: rgba(255, 255, 255, 0.02);
        flex-shrink: 0;
    }
    .modal-close-btn {
        background: transparent;
        border: none;
        color: var(--text-secondary);
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        transition: color 0.15s;
        padding: 4px;
    }
    .modal-close-btn:hover { color: #fff; }
    .custom-modal-body {
        padding: 22px 24px;
        overflow-y: auto !important;
        flex: 1 1 auto;
        min-height: 0;
    }
    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        padding: 14px 24px;
        border-top: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.02);
        flex-shrink: 0;
    }

    /* Summary cards */
    .summary-card {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .summary-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }
    .summary-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }
    .preamble-box {
        background: #090d16;
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 20px;
    }
    .preamble-box * {
        color: #e2e8f0 !important;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">The Constitution</h1>
        <p class="page-subtitle">Manage the 1992 Ghana Constitution, amendments, and regional/country constitutions.</p>
    </div>
    @if($tab === 'foreign')
        <div style="margin-right: 28px;">
            <a href="{{ route('admin.constitutions.foreign.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add Country Constitution
            </a>
        </div>
    @endif
</div>

<!-- Tabs Navigation -->
<div class="tabs-nav">
    <a href="{{ route('admin.constitutions.index', ['tab' => 'ghana']) }}" class="tab-btn {{ $tab === 'ghana' ? 'active' : '' }}">
        <i class="fa-solid fa-landmark"></i> Ghana 1992 Constitution
    </a>
    <a href="{{ route('admin.constitutions.index', ['tab' => 'amended']) }}" class="tab-btn {{ $tab === 'amended' ? 'active' : '' }}">
        <i class="fa-solid fa-file-pen"></i> Constitution Amendments
    </a>
    <a href="{{ route('admin.constitutions.index', ['tab' => 'foreign']) }}" class="tab-btn {{ $tab === 'foreign' ? 'active' : '' }}">
        <i class="fa-solid fa-globe"></i> Foreign / All Countries
    </a>
</div>

{{-- TAB 1: GHANA 1992 CONSTITUTION --}}
@if($tab === 'ghana')
    <div class="summary-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
            <div>
                <div class="summary-title">{{ $ghanaAct->title }}</div>
                <div class="summary-badges">
                    <span class="badge badge-accent" style="font-size: 12px; padding: 4px 10px;">Primary Constitution</span>
                    <span class="badge badge-secondary" style="font-size: 12px; padding: 4px 10px; background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                        <i class="fa-solid fa-file-lines"></i> {{ $ghanaArticlesCount }} Total Articles
                    </span>
                    <span class="badge badge-secondary" style="font-size: 12px; padding: 4px 10px; background: rgba(255, 255, 255, 0.06); color: #cbd5e1;">
                        <i class="fa-solid fa-layer-group"></i> {{ $ghanaChaptersCount }} Chapters
                    </span>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ url('/constitution/Republic/Ghana/' . $ghanaAct->id) }}" target="_blank" class="btn btn-secondary" style="color: #38bdf8; border-color: rgba(56, 189, 248, 0.35);">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Reader View
                </a>
                <a href="{{ route('admin.constitutions.articles', 'ghana') }}" class="btn btn-primary">
                    <i class="fa-solid fa-layer-group"></i> Manage Articles & Chapters
                </a>
            </div>
        </div>

        <div style="margin-top: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary);">
                    <i class="fa-solid fa-scroll" style="color: #60a5fa;"></i> Preamble
                </span>
                <button type="button" class="btn btn-secondary" onclick="openEditActModal('ghana')" style="padding: 4px 10px; font-size: 12px;">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Title & Preamble
                </button>
            </div>
            <div class="preamble-box">
                @if(!empty($ghanaAct->preamble))
                    {!! $ghanaAct->preamble !!}
                @else
                    <span style="color: var(--text-secondary); font-style: italic;">No preamble recorded for Ghana Constitution.</span>
                @endif
            </div>
        </div>
    </div>

{{-- TAB 2: CONSTITUTION AMENDMENTS --}}
@elseif($tab === 'amended')
    <div class="summary-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
            <div>
                <div class="summary-title">{{ $amendedAct->title }}</div>
                <div class="summary-badges">
                    <span class="badge badge-accent" style="font-size: 12px; padding: 4px 10px; background: rgba(234, 179, 8, 0.15); color: #facc15; border-color: rgba(234, 179, 8, 0.3);">Constitutional Amendments</span>
                    <span class="badge badge-secondary" style="font-size: 12px; padding: 4px 10px; background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                        <i class="fa-solid fa-file-lines"></i> {{ $amendedArticlesCount }} Amended Provisions
                    </span>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ url('/constitution_amended/Republic/Ghana/' . $amendedAct->id) }}" target="_blank" class="btn btn-secondary" style="color: #38bdf8; border-color: rgba(56, 189, 248, 0.35);">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Reader View
                </a>
                <a href="{{ route('admin.constitutions.articles', 'amended') }}" class="btn btn-primary">
                    <i class="fa-solid fa-layer-group"></i> Manage Amended Articles
                </a>
            </div>
        </div>

        <div style="margin-top: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary);">
                    <i class="fa-solid fa-scroll" style="color: #facc15;"></i> Amendments Preamble
                </span>
                <button type="button" class="btn btn-secondary" onclick="openEditActModal('amended')" style="padding: 4px 10px; font-size: 12px;">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Title & Preamble
                </button>
            </div>
            <div class="preamble-box">
                @if(!empty($amendedAct->preamble))
                    {!! $amendedAct->preamble !!}
                @else
                    <span style="color: var(--text-secondary); font-style: italic;">No preamble recorded for amended constitution.</span>
                @endif
            </div>
        </div>
    </div>

{{-- TAB 3: FOREIGN / ALL COUNTRIES CONSTITUTIONS --}}
@elseif($tab === 'foreign')
    <div class="card-table">
        <div class="table-header" style="flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <h2 class="table-title">Country Constitutions</h2>
                <!-- Continent Filter Pills -->
                <div style="display: flex; gap: 6px; margin-left: 10px;">
                    <a href="{{ route('admin.constitutions.index', ['tab' => 'foreign', 'continent' => 'all']) }}" class="btn btn-secondary" style="padding: 4px 10px; font-size: 12px; {{ $continent === 'all' ? 'background: rgba(59,130,246,0.25); color: #60a5fa; border-color: #3b82f6;' : '' }}">All</a>
                    @foreach($continents as $c)
                        <a href="{{ route('admin.constitutions.index', ['tab' => 'foreign', 'continent' => $c]) }}" class="btn btn-secondary" style="padding: 4px 10px; font-size: 12px; {{ $continent === $c ? 'background: rgba(59,130,246,0.25); color: #60a5fa; border-color: #3b82f6;' : '' }}">
                            {{ $c }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Search Form -->
            <div style="position: relative;">
                <input type="text" id="foreignSearchInput" class="form-control" placeholder="Search by country, title, year..." value="{{ request('search') }}" style="width: 280px; padding: 8px 36px 8px 16px;">
                <span id="foreignSpinner" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); display: none; color: #60a5fa;">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </span>
            </div>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 140px;">Continent</th>
                    <th style="width: 180px;">Country</th>
                    <th>Constitution Title</th>
                    <th style="width: 100px;">Year</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody id="foreignTableBody">
                @include('admin.constitutions._foreign_rows', ['constitutions' => $foreignConstitutions])
            </tbody>
        </table>

        <div id="foreignPaginationContainer">
            @include('admin.constitutions._foreign_pagination', ['constitutions' => $foreignConstitutions, 'continent' => $continent])
        </div>
    </div>
@endif

<!-- Edit Ghana / Amended Act Modal -->
<div id="modal-edit-act" class="custom-modal-backdrop" style="display: none;" onclick="if(event.target === this) closeEditActModal()">
    <div class="custom-modal-dialog">
        <form id="form-edit-act" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="custom-modal-header">
                <h3 id="edit-act-modal-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #fff;">Edit Constitution Details</h3>
                <button type="button" class="modal-close-btn" onclick="closeEditActModal()">&times;</button>
            </div>
            <div class="custom-modal-body">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label" style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Constitution Title</label>
                    <input type="text" name="title" id="edit-act-title-input" class="form-control" required style="width: 100%;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Preamble Text</label>
                    <div id="edit-act-quill-editor"></div>
                    <textarea name="preamble" id="edit-act-preamble-hidden" style="display: none;"></textarea>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditActModal()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Preview Foreign Constitution Modal -->
<div id="modal-foreign-preview" class="custom-modal-backdrop" style="display: none;" onclick="if(event.target === this) closeForeignPreviewModal()">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <div>
                <div style="display: flex; gap: 6px; margin-bottom: 4px;">
                    <span id="foreign-preview-continent" class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;"></span>
                    <span id="foreign-preview-year" class="badge" style="background: rgba(59,130,246,0.2); color: #60a5fa; font-size: 11px; padding: 2px 8px;"></span>
                </div>
                <h3 id="foreign-preview-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #fff;"></h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeForeignPreviewModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div style="font-size: 13px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 8px;">
                <i class="fa-solid fa-scroll" style="color: #60a5fa;"></i> Preamble
            </div>
            <div id="foreign-preview-preamble" class="preamble-box" style="margin-bottom: 0;"></div>
        </div>
        <div class="custom-modal-footer">
            <a id="foreign-preview-reader-link" href="#" target="_blank" class="btn btn-primary" style="margin-right: auto;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Reader View
            </a>
            <a id="foreign-preview-edit-link" href="#" class="btn btn-secondary">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <button type="button" class="btn btn-secondary" onclick="closeForeignPreviewModal()">Close</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
    let actQuill = null;

    document.addEventListener('DOMContentLoaded', function() {
        const editorContainer = document.getElementById('edit-act-quill-editor');
        if (editorContainer) {
            actQuill = new Quill(editorContainer, {
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

            document.getElementById('form-edit-act').addEventListener('submit', function() {
                document.getElementById('edit-act-preamble-hidden').value = actQuill.root.innerHTML;
            });
        }
    });

    function openEditActModal(target) {
        const modal = document.getElementById('modal-edit-act');
        const form = document.getElementById('form-edit-act');
        const titleInput = document.getElementById('edit-act-title-input');
        const modalTitle = document.getElementById('edit-act-modal-title');

        if (target === 'amended') {
            form.action = "{{ route('admin.constitutions.act.update', 'amended') }}";
            modalTitle.textContent = "Edit Amended Constitution";
            titleInput.value = {!! json_encode($amendedAct->title ?? '') !!};
            if (actQuill) actQuill.root.innerHTML = {!! json_encode($amendedAct->preamble ?? '') !!};
        } else {
            form.action = "{{ route('admin.constitutions.act.update', 'ghana') }}";
            modalTitle.textContent = "Edit Ghana 1992 Constitution";
            titleInput.value = {!! json_encode($ghanaAct->title ?? '') !!};
            if (actQuill) actQuill.root.innerHTML = {!! json_encode($ghanaAct->preamble ?? '') !!};
        }

        modal.style.display = 'flex';
    }

    function closeEditActModal() {
        document.getElementById('modal-edit-act').style.display = 'none';
    }

    // Foreign search
    const foreignSearch = document.getElementById('foreignSearchInput');
    let foreignSearchTimer = null;

    if (foreignSearch) {
        foreignSearch.addEventListener('input', function() {
            clearTimeout(foreignSearchTimer);
            foreignSearchTimer = setTimeout(() => {
                fetchForeignConstitutions(this.value.trim());
            }, 300);
        });
    }

    function fetchForeignConstitutions(searchQuery, pageUrl = null) {
        const spinner = document.getElementById('foreignSpinner');
        if (spinner) spinner.style.display = 'block';

        const continent = "{{ $continent }}";
        let targetUrl = pageUrl;
        if (!targetUrl) {
            targetUrl = `{{ route('admin.constitutions.index') }}?tab=foreign&continent=${encodeURIComponent(continent)}&search=${encodeURIComponent(searchQuery)}`;
        }

        fetch(targetUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.html !== undefined) {
                document.getElementById('foreignTableBody').innerHTML = data.html;
            }
            if (data.pagination !== undefined) {
                document.getElementById('foreignPaginationContainer').innerHTML = data.pagination;
                bindForeignPagination();
            }
        })
        .catch(err => console.error(err))
        .finally(() => {
            if (spinner) spinner.style.display = 'none';
        });
    }

    function bindForeignPagination() {
        const links = document.querySelectorAll('#foreignPaginationContainer .ajax-page-link');
        links.forEach(l => {
            l.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if (url) fetchForeignConstitutions('', url);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', bindForeignPagination);

    // Foreign preview modal
    function openForeignPreviewModal(id) {
        const modal = document.getElementById('modal-foreign-preview');
        fetch(`{{ url('admin/constitutions/foreign') }}/${id}/preview`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('foreign-preview-title').textContent = data.country + ' - ' + data.title;
            document.getElementById('foreign-preview-continent').textContent = data.continent;
            document.getElementById('foreign-preview-year').textContent = data.year || 'N/A';
            document.getElementById('foreign-preview-preamble').innerHTML = data.preamble ? data.preamble : '<span style="color: var(--text-secondary); font-style: italic;">No preamble recorded.</span>';
            document.getElementById('foreign-preview-reader-link').href = data.reader_url;
            document.getElementById('foreign-preview-edit-link').href = data.edit_url;
            modal.style.display = 'flex';
        });
    }

    function closeForeignPreviewModal() {
        document.getElementById('modal-foreign-preview').style.display = 'none';
    }
</script>
@endsection
