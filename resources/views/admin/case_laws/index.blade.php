@extends('layouts.admin')

@section('title', 'Case Laws')

@section('styles')
<style>
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
    .case-detail-row {
        display: flex;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 13px;
    }
    .case-detail-label {
        width: 140px;
        color: var(--text-secondary);
        font-weight: 600;
        flex-shrink: 0;
    }
    .case-detail-value {
        color: #e2e8f0;
        flex: 1;
    }
    .case-snippet-box {
        background: #090d16;
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 10px;
        padding: 14px 16px;
        margin-top: 14px;
        font-size: 13.5px;
        line-height: 1.7;
        color: #cbd5e1;
        max-height: 200px;
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Case Laws & Judgments</h1>
        <p class="page-subtitle">Manage Supreme Court, Court of Appeal, High Court, and Circuit Court judgments.</p>
    </div>
    <div style="margin-right: 28px;">
        <a href="{{ route('admin.case-laws.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Record New Case
        </a>
    </div>
</div>

<!-- Tabs Navigation (Courts) -->
<div class="tabs-nav">
    <a href="{{ route('admin.case-laws.index', ['court' => 'all', 'category' => $category]) }}" class="tab-btn {{ $court === 'all' ? 'active' : '' }}">
        All Courts
    </a>
    @foreach($courtGroups as $k => $label)
        <a href="{{ route('admin.case-laws.index', ['court' => $k, 'category' => $category]) }}" class="tab-btn {{ $court === $k ? 'active' : '' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="card-table">
    <div class="table-header" style="flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <h2 class="table-title">
                {{ $court === 'all' ? 'All Courts' : ($courtGroups[$court] ?? $court) }} Listing
            </h2>

            <!-- Category Filter Dropdown -->
            @if(count($categories) > 0)
                <select id="caseCategorySelect" onchange="changeCategoryFilter(this.value)" class="form-control" style="width: 200px; padding: 6px 12px; font-size: 13px;">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <!-- Live Dynamic Search Form -->
        <div style="position: relative;">
            <input type="text" id="caseSearchInput" class="form-control" placeholder="Search by title, suit number, year..." value="{{ request('search') }}" style="width: 320px; padding: 8px 36px 8px 16px;">
            <span id="caseSearchSpinner" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); display: none; color: #60a5fa;">
                <i class="fa-solid fa-circle-notch fa-spin"></i>
            </span>
            <button type="button" id="caseClearSearchBtn" onclick="clearCaseSearch()" title="Clear Search" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-secondary); cursor: pointer; display: {{ request('search') ? 'block' : 'none' }}; font-size: 14px; padding: 2px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <table class="custom-table" id="casesTable">
        <thead>
            <tr>
                <th style="width: 80px;">Year</th>
                <th>Case Title & Details</th>
                <th style="width: 180px;">Actions</th>
            </tr>
        </thead>
        <tbody id="casesTableBody">
            @include('admin.case_laws._table_rows', ['cases' => $cases])
        </tbody>
    </table>

    <div id="casesPaginationContainer">
        @include('admin.case_laws._pagination', ['cases' => $cases, 'court' => $court, 'category' => $category])
    </div>
</div>

<!-- Preview Case Modal -->
<div id="modal-case-preview" class="custom-modal-backdrop" style="display: none;" onclick="if(event.target === this) closeCasePreviewModal()">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <div>
                <div style="display: flex; gap: 6px; margin-bottom: 4px; align-items: center;">
                    <span id="preview-case-court" class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;"></span>
                    <span id="preview-case-year" class="badge" style="background: rgba(59,130,246,0.2); color: #60a5fa; font-size: 11px; padding: 2px 8px;"></span>
                    <span id="preview-case-category" class="badge badge-secondary" style="background: rgba(255,255,255,0.06); color: var(--text-secondary); font-size: 11px; padding: 2px 8px;"></span>
                </div>
                <h3 id="preview-case-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #fff; line-height: 1.3;"></h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeCasePreviewModal()">&times;</button>
        </div>
        <div class="custom-modal-body">
            <div class="case-detail-row">
                <div class="case-detail-label">Suit / Ref Number</div>
                <div class="case-detail-value" id="preview-case-suit">N/A</div>
            </div>
            <div class="case-detail-row">
                <div class="case-detail-label">Coram (Judges)</div>
                <div class="case-detail-value" id="preview-case-coram">N/A</div>
            </div>
            <div class="case-detail-row">
                <div class="case-detail-label">Counsellors</div>
                <div class="case-detail-value" id="preview-case-counsel">N/A</div>
            </div>
            <div class="case-detail-row">
                <div class="case-detail-label">Judgment Date</div>
                <div class="case-detail-value" id="preview-case-date">N/A</div>
            </div>
            <div class="case-detail-row">
                <div class="case-detail-label">Judgment Type</div>
                <div class="case-detail-value" id="preview-case-type">Judgment</div>
            </div>

            <div style="margin-top: 16px;">
                <span style="font-size: 12.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary);">
                    <i class="fa-solid fa-scroll" style="color: #60a5fa;"></i> Judgment Snippet
                </span>
                <div id="preview-case-snippet" class="case-snippet-box"></div>
            </div>
        </div>
        <div class="custom-modal-footer">
            <a id="preview-case-reader-link" href="#" target="_blank" class="btn btn-primary" style="margin-right: auto;">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Open Reader View
            </a>
            <a id="preview-case-edit-link" href="#" class="btn btn-secondary">
                <i class="fa-solid fa-pen-to-square"></i> Edit Case
            </a>
            <button type="button" class="btn btn-secondary" onclick="closeCasePreviewModal()">Close</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const court = "{{ $court }}";
    let category = "{{ $category }}";
    let searchDebounceTimer = null;
    const searchInput = document.getElementById('caseSearchInput');
    const spinner = document.getElementById('caseSearchSpinner');
    const clearBtn = document.getElementById('caseClearSearchBtn');

    function fetchCases(query, pageUrl = null) {
        if (spinner) spinner.style.display = 'block';
        if (clearBtn) clearBtn.style.display = 'none';

        let targetUrl = pageUrl;
        if (!targetUrl) {
            targetUrl = `{{ route('admin.case-laws.index') }}?court=${encodeURIComponent(court)}&category=${encodeURIComponent(category)}&search=${encodeURIComponent(query)}`;
        }

        fetch(targetUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.html !== undefined) {
                document.getElementById('casesTableBody').innerHTML = data.html;
            }
            if (data.pagination !== undefined) {
                document.getElementById('casesPaginationContainer').innerHTML = data.pagination;
                bindCasePagination();
            }

            // Update browser URL
            const newUrl = new URL(window.location);
            if (query) newUrl.searchParams.set('search', query);
            else newUrl.searchParams.delete('search');
            window.history.replaceState({}, '', newUrl);
        })
        .catch(err => console.error(err))
        .finally(() => {
            if (spinner) spinner.style.display = 'none';
            if (searchInput && searchInput.value.trim().length > 0 && clearBtn) {
                clearBtn.style.display = 'block';
            }
        });
    }

    function bindCasePagination() {
        const links = document.querySelectorAll('#casesPaginationContainer .ajax-page-link');
        links.forEach(l => {
            l.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                if (url) fetchCases('', url);
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (val.length > 0) clearBtn.style.display = 'block';
            else clearBtn.style.display = 'none';

            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                fetchCases(val);
            }, 300);
        });
    }

    function clearCaseSearch() {
        if (searchInput) searchInput.value = '';
        if (clearBtn) clearBtn.style.display = 'none';
        fetchCases('');
        if (searchInput) searchInput.focus();
    }

    function changeCategoryFilter(newCategory) {
        category = newCategory;
        const currentSearch = searchInput ? searchInput.value.trim() : '';
        fetchCases(currentSearch);
    }

    document.addEventListener('DOMContentLoaded', bindCasePagination);

    // Case Preview modal
    function openCasePreviewModal(id) {
        const modal = document.getElementById('modal-case-preview');
        fetch(`{{ url('admin/case-laws') }}/${id}/preview`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('preview-case-title').textContent = data.title;
            document.getElementById('preview-case-court').textContent = (data.court || 'Court').replace(/-/g, ' ');
            document.getElementById('preview-case-year').textContent = data.year || 'N/A';
            document.getElementById('preview-case-category').textContent = data.category || 'General';
            document.getElementById('preview-case-suit').textContent = data.suit_number || 'N/A';
            document.getElementById('preview-case-coram').textContent = data.coram || 'N/A';
            document.getElementById('preview-case-counsel').textContent = data.counsellors || 'N/A';
            document.getElementById('preview-case-date').textContent = data.date || 'N/A';
            document.getElementById('preview-case-type').textContent = data.judgement_type || 'Judgment';
            document.getElementById('preview-case-snippet').textContent = data.snippet || 'No judgment content available.';
            document.getElementById('preview-case-reader-link').href = data.reader_url;
            document.getElementById('preview-case-edit-link').href = data.edit_url;
            modal.style.display = 'flex';
        });
    }

    function closeCasePreviewModal() {
        document.getElementById('modal-case-preview').style.display = 'none';
    }
</script>
@endsection
