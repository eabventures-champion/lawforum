@extends('layouts.admin')

@section('title', 'Laws & Acts')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laws & Acts</h1>
        <p class="page-subtitle">Manage legal codifications, preambles, and documents.</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ route('admin.laws.taxonomies') }}" class="btn btn-secondary" style="border-color: rgba(59, 130, 246, 0.3); color: #60a5fa;">
            <i class="fa-solid fa-tags"></i> Manage Groups & Categories
        </a>
        <a href="{{ route('admin.laws.create', ['type' => $type]) }}" class="btn btn-primary" style="margin-right: 28px;">
            <i class="fa-solid fa-plus"></i> Add New Law
        </a>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="tabs-nav">
    <a href="{{ route('admin.laws.index', ['type' => 'post1992']) }}" class="tab-btn {{ $type === 'post1992' ? 'active' : '' }}">
        New Laws
    </a>
    <a href="{{ route('admin.laws.index', ['type' => 'pre1992']) }}" class="tab-btn {{ $type === 'pre1992' ? 'active' : '' }}">
        Existing Laws
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
        
        <!-- Live Dynamic Search Form -->
        <form id="lawsSearchForm" action="{{ route('admin.laws.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center;" onsubmit="return false;">
            <input type="hidden" name="type" id="lawType" value="{{ $type }}">
            <div style="position: relative;">
                <input type="text" id="lawSearchInput" name="search" class="form-control" autocomplete="off" placeholder="Search by title, year, group, category..." value="{{ request('search') }}" style="width: 320px; padding: 8px 36px 8px 16px;">
                <span id="searchSpinner" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); display: none; color: #60a5fa; font-size: 13px;">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </span>
                <button type="button" id="clearSearchBtn" onclick="clearLiveSearch()" title="Clear Search" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-secondary); cursor: pointer; display: {{ request('search') ? 'block' : 'none' }}; font-size: 14px; padding: 2px;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <button type="button" class="btn btn-primary btn-action" onclick="triggerSearch()" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <table class="custom-table" id="lawsTable">
        <thead>
            <tr>
                <th style="width: 80px;">Year</th>
                <th>Title</th>
                @if($type === 'post1992')
                    <th style="width: 120px;">PDF File</th>
                @endif
                <th style="width: 180px;">Actions</th>
            </tr>
        </thead>
        <tbody id="lawsTableBody">
            @include('admin.laws._table_rows', ['laws' => $laws, 'type' => $type])
        </tbody>
    </table>

    <div id="paginationContainer">
        @include('admin.laws._pagination', ['laws' => $laws, 'type' => $type])
    </div>
</div>

<!-- Act Preview Modal -->
<div id="modal-act-preview" class="custom-modal-backdrop" style="display: none;" onclick="handleModalBackdropClick(event)">
    <div class="custom-modal-dialog preview-dialog" onclick="event.stopPropagation()">
        <div class="custom-modal-header">
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                    <span id="preview-act-year" class="badge" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; font-size: 11px; font-weight: 700; padding: 2px 8px;"></span>
                    <span id="preview-act-group" class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;"></span>
                    <span id="preview-act-category" class="badge badge-secondary" style="background: rgba(255,255,255,0.06); color: var(--text-secondary); font-size: 11px; padding: 2px 8px; display: none;"></span>
                </div>
                <h3 id="preview-act-title" style="margin: 0; font-size: 17px; font-weight: 700; color: #fff; line-height: 1.3;">
                    Loading Law Preview...
                </h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeActPreviewModal()" title="Close">&times;</button>
        </div>

        <div class="custom-modal-body preview-modal-body">
            <!-- Loading state -->
            <div id="preview-loading" style="text-align: center; padding: 48px 20px; color: var(--text-secondary);">
                <i class="fa-solid fa-circle-notch fa-spin" style="font-size: 28px; color: #3b82f6; margin-bottom: 12px; display: block;"></i>
                <span>Loading act details...</span>
            </div>

            <!-- Content state -->
            <div id="preview-content-container" style="display: none;">
                <!-- Metrics Bar -->
                <div class="preview-metrics-grid">
                    <div class="metric-box">
                        <div class="metric-val" id="preview-metric-parts">0</div>
                        <div class="metric-lbl"><i class="fa-solid fa-folder-tree"></i> Parts</div>
                    </div>
                    <div class="metric-box">
                        <div class="metric-val" id="preview-metric-sections">0</div>
                        <div class="metric-lbl"><i class="fa-solid fa-file-lines"></i> Sections</div>
                    </div>
                    <div class="metric-box">
                        <div class="metric-val" id="preview-metric-schedules">0</div>
                        <div class="metric-lbl"><i class="fa-solid fa-table-list"></i> Schedules</div>
                    </div>
                </div>

                <!-- Preamble Section -->
                <div class="preview-card-section">
                    <div class="preview-section-title">
                        <i class="fa-solid fa-scroll" style="color: #60a5fa;"></i> Preamble / Enactment
                    </div>
                    <div id="preview-act-preamble" class="preview-preamble-text">
                        No preamble recorded for this act.
                    </div>
                </div>

                <!-- Parts Breakdown Section -->
                <div class="preview-card-section" id="preview-parts-section">
                    <div class="preview-section-title">
                        <i class="fa-solid fa-list-check" style="color: #38bdf8;"></i> Parts & Structure Breakdown
                    </div>
                    <div id="preview-parts-list" class="preview-parts-wrap">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-modal-footer">
            <div style="margin-right: auto; display: flex; align-items: center; gap: 8px;">
                <a id="btn-preview-reader" href="#" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; font-size: 13px;">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Reader View
                </a>
                <a id="btn-preview-sections" href="#" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; font-size: 13px; color: #60a5fa; border-color: rgba(59, 130, 246, 0.3);">
                    <i class="fa-solid fa-layer-group"></i> Manage Sections
                </a>
            </div>
            <a id="btn-preview-edit" href="#" class="btn btn-secondary" style="padding: 7px 14px; font-size: 13px;">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>
            <button type="button" class="btn btn-secondary" onclick="closeActPreviewModal()" style="padding: 7px 14px; font-size: 13px;">Close</button>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Modal Backdrop & Dialog */
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
    .custom-modal-dialog.preview-dialog {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        width: 780px;
        max-width: 96vw;
        max-height: 88vh;
        max-height: calc(100vh - 48px);
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85);
        overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.97) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
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
    .custom-modal-body.preview-modal-body {
        padding: 22px 24px;
        overflow-y: auto !important;
        flex: 1 1 auto;
        min-height: 0;
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
        align-items: center;
        gap: 10px;
        padding: 14px 24px;
        border-top: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.02);
        flex-shrink: 0;
    }

    /* Preview Specific Styling */
    .preview-metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    .metric-box {
        background: #090d16;
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 10px;
        padding: 12px 16px;
        text-align: center;
    }
    .metric-val {
        font-size: 22px;
        font-weight: 700;
        color: #60a5fa;
        line-height: 1.2;
    }
    .metric-lbl {
        font-size: 11.5px;
        font-weight: 500;
        color: var(--text-secondary);
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .preview-card-section {
        background: #090d16;
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 16px;
    }
    .preview-card-section:last-child {
        margin-bottom: 0;
    }
    .preview-section-title {
        font-size: 13px;
        font-weight: 600;
        color: #e2e8f0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .preview-preamble-text,
    .preview-preamble-text * {
        color: #e2e8f0 !important;
    }
    .preview-preamble-text {
        font-size: 13.5px;
        line-height: 1.75;
        max-height: 220px;
        overflow-y: auto;
        padding-right: 8px;
    }
    .preview-preamble-text p {
        margin-bottom: 10px;
    }
    .preview-preamble-text p:last-child {
        margin-bottom: 0;
    }
    .preview-preamble-text::-webkit-scrollbar {
        width: 5px;
    }
    .preview-preamble-text::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 3px;
    }
    .preview-parts-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .part-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 12.5px;
        color: #e2e8f0;
    }
    .part-pill-count {
        background: rgba(59, 130, 246, 0.2);
        color: #60a5fa;
        font-size: 11px;
        font-weight: 700;
        border-radius: 9999px;
        padding: 1px 7px;
    }
</style>
@endsection

@section('scripts')
<script>
    let searchDebounceTimer = null;
    const searchInput = document.getElementById('lawSearchInput');
    const spinner = document.getElementById('searchSpinner');
    const clearBtn = document.getElementById('clearSearchBtn');
    const tableBody = document.getElementById('lawsTableBody');
    const paginationContainer = document.getElementById('paginationContainer');
    const lawType = document.getElementById('lawType').value;

    function fetchLaws(urlOrQuery, isUrl = false) {
        spinner.style.display = 'block';
        clearBtn.style.display = 'none';

        let targetUrl;
        if (isUrl) {
            targetUrl = urlOrQuery;
        } else {
            const query = encodeURIComponent(urlOrQuery);
            targetUrl = `{{ route('admin.laws.index') }}?type=${encodeURIComponent(lawType)}&search=${query}`;
        }

        fetch(targetUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.html !== undefined) {
                tableBody.innerHTML = data.html;
            }
            if (data.pagination !== undefined) {
                paginationContainer.innerHTML = data.pagination;
                bindPaginationLinks();
            }
            // Update browser URL without reloading
            const currentSearch = searchInput.value.trim();
            const newUrl = new URL(window.location);
            if (currentSearch) {
                newUrl.searchParams.set('search', currentSearch);
            } else {
                newUrl.searchParams.delete('search');
            }
            newUrl.searchParams.set('type', lawType);
            window.history.replaceState({}, '', newUrl);
        })
        .catch(err => {
            console.error('Error fetching search results:', err);
        })
        .finally(() => {
            spinner.style.display = 'none';
            if (searchInput.value.trim().length > 0) {
                clearBtn.style.display = 'block';
            }
        });
    }

    function triggerSearch() {
        if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
        fetchLaws(searchInput.value.trim());
    }

    function clearLiveSearch() {
        searchInput.value = '';
        clearBtn.style.display = 'none';
        fetchLaws('');
        searchInput.focus();
    }

    // Bind AJAX to pagination links
    function bindPaginationLinks() {
        if (!paginationContainer) return;
        const links = paginationContainer.querySelectorAll('.ajax-page-link');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if (url) {
                    fetchLaws(url, true);
                }
            });
        });
    }

    // Live dynamic typing listener with debounce
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (val.length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }

            if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                fetchLaws(val);
            }, 300); // 300ms debounce
        });

        // Search on Enter immediately
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                triggerSearch();
            }
        });
    }

    // Modal preview controls
    function openActPreviewModal(actId, actType) {
        const modal = document.getElementById('modal-act-preview');
        const loading = document.getElementById('preview-loading');
        const content = document.getElementById('preview-content-container');

        // Show modal and loading state
        modal.style.display = 'flex';
        loading.style.display = 'block';
        content.style.display = 'none';

        // Reset elements
        document.getElementById('preview-act-title').textContent = 'Loading Law Preview...';
        document.getElementById('preview-act-year').textContent = '';
        document.getElementById('preview-act-group').textContent = '';
        document.getElementById('preview-act-category').style.display = 'none';

        const previewUrl = `{{ url('admin/laws') }}/${actId}/preview/${encodeURIComponent(actType)}`;

        fetch(previewUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Failed to load law preview');
            return response.json();
        })
        .then(data => {
            document.getElementById('preview-act-title').textContent = data.title;
            document.getElementById('preview-act-year').textContent = data.year || 'N/A';
            document.getElementById('preview-act-group').textContent = data.group || 'General';

            const catBadge = document.getElementById('preview-act-category');
            if (data.category && data.category.trim() !== '') {
                catBadge.textContent = data.category;
                catBadge.style.display = 'inline-block';
            } else {
                catBadge.style.display = 'none';
            }

            // Metrics
            document.getElementById('preview-metric-parts').textContent = data.parts_count || 0;
            document.getElementById('preview-metric-sections').textContent = data.sections_count || 0;
            document.getElementById('preview-metric-schedules').textContent = data.schedules_count || 0;

            // Preamble
            const preambleEl = document.getElementById('preview-act-preamble');
            if (data.preamble && data.preamble.trim().length > 0) {
                preambleEl.innerHTML = data.preamble;
            } else {
                preambleEl.innerHTML = '<span style="color: var(--text-secondary); font-style: italic;">No preamble recorded for this act.</span>';
            }

            // Parts List
            const partsSection = document.getElementById('preview-parts-section');
            const partsList = document.getElementById('preview-parts-list');
            partsList.innerHTML = '';

            if (data.parts_summary && data.parts_summary.length > 0) {
                partsSection.style.display = 'block';
                data.parts_summary.forEach(p => {
                    const pill = document.createElement('div');
                    pill.className = 'part-pill';
                    pill.innerHTML = `<span>${p.name}</span><span class="part-pill-count">${p.count} ${p.count === 1 ? 'section' : 'sections'}</span>`;
                    partsList.appendChild(pill);
                });
            } else {
                partsList.innerHTML = '<span style="color: var(--text-secondary); font-size: 13px; font-style: italic;">No parts or sections recorded yet.</span>';
            }

            // Action Links
            const readerBtn = document.getElementById('btn-preview-reader');
            if (data.preview_url) {
                readerBtn.href = data.preview_url;
                readerBtn.style.display = 'inline-flex';
            } else {
                readerBtn.style.display = 'none';
            }

            const sectionsBtn = document.getElementById('btn-preview-sections');
            sectionsBtn.href = data.sections_url;

            const editBtn = document.getElementById('btn-preview-edit');
            editBtn.href = data.edit_url;

            // Switch to content state
            loading.style.display = 'none';
            content.style.display = 'block';
        })
        .catch(err => {
            console.error('Error opening preview:', err);
            loading.innerHTML = `
                <div style="color: #ef4444; font-size: 14px;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px; margin-bottom: 8px; display: block;"></i>
                    Failed to load preview details. Please try again.
                </div>
            `;
        });
    }

    function closeActPreviewModal() {
        const modal = document.getElementById('modal-act-preview');
        if (modal) modal.style.display = 'none';
    }

    function handleModalBackdropClick(e) {
        if (e.target.id === 'modal-act-preview') {
            closeActPreviewModal();
        }
    }

    // Close preview modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeActPreviewModal();
        }
    });

    // Initial binding for pagination
    document.addEventListener('DOMContentLoaded', function() {
        bindPaginationLinks();
    });
</script>
@endsection

