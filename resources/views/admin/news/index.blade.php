@extends('layouts.admin')

@section('title', 'News & Articles')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 class="page-title">News & Articles</h1>
        <p class="page-subtitle">Manage legal news, articles, and blog updates.</p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="padding: 10px 20px; font-size: 13.5px; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-plus"></i>
            <span>Write New Article</span>
        </a>
    </div>
</div>

<div class="card-table" style="width: 100%; margin-bottom: 40px;">
    <!-- Header with Title, Actions & Search -->
    <div class="table-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding: 20px 24px;">
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <h2 class="table-title" style="margin-bottom: 0; font-size: 20px;">All News Articles</h2>
            <span style="background: rgba(59, 130, 246, 0.12); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25); font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fa-solid fa-newspaper" style="font-size: 11px;"></i> <span id="news-total-count">{{ number_format($news->total()) }}</span> Articles
            </span>

            <!-- Delete All Button -->
            <form action="{{ route('admin.news.destroy-all') }}" method="POST" id="delete-all-form" style="display: {{ $news->total() > 0 ? 'inline-block' : 'none' }}; margin: 0;" onsubmit="return confirm('⚠️ CAUTION: Are you sure you want to delete ALL news articles? This will permanently remove all articles and images.')">
                @csrf
                @method('DELETE')
                <button type="submit" id="delete-all-btn" class="btn btn-danger btn-action" style="height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 7px;">
                    <i class="fa-solid fa-trash-can"></i>
                    <span>Delete All (<span id="delete-all-count">{{ $news->total() }}</span>)</span>
                </button>
            </form>

            <!-- Bulk Delete Selected Button -->
            <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-action" style="display: none; height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 600; align-items: center; gap: 7px;" onclick="submitBulkDelete()">
                <i class="fa-solid fa-trash"></i>
                <span>Delete Selected (<span id="selected-count">0</span>)</span>
            </button>
        </div>
        
        <!-- Live Search Form -->
        <form id="news-search-form" action="{{ route('admin.news.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;" onsubmit="event.preventDefault(); fetchNews();">
            <div style="position: relative; width: 280px;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 13px; pointer-events: none;"></i>
                <input type="text" name="search" id="news-search-input" class="form-control" placeholder="Search news by title or content..." value="{{ request('search') }}" autocomplete="off" style="padding-left: 38px; padding-right: 32px; height: 38px; border-radius: 8px; font-size: 13px; width: 100%;">
                <span id="search-spinner" style="display: none; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--accent-color); font-size: 12px;">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </span>
            </div>
            <button type="submit" class="btn btn-primary btn-action" style="height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                <span>Search</span>
            </button>
            <button type="button" id="news-clear-search-btn" onclick="clearNewsSearch()" class="btn btn-secondary btn-action" style="display: {{ request('search') ? 'inline-flex' : 'none' }}; height: 38px; padding: 0 14px; border-radius: 8px; font-size: 13px; align-items: center; gap: 6px; color: var(--text-secondary); background: rgba(255,255,255,0.04); border: 1px solid var(--border-color);">
                <i class="fa-solid fa-rotate-left"></i> Clear
            </button>
        </form>
    </div>

    <!-- Table Container (Dynamically updated via Live Search) -->
    <div id="news-table-wrapper">
        @include('admin.news.table_data')
    </div>
</div>

<!-- Bulk Delete Form -->
<form id="bulk-delete-form" action="{{ route('admin.news.bulk-destroy') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@section('scripts')
<script>
    let activeAjax = null;
    let debounceTimer = null;

    function fetchNews(url = null) {
        const tableWrapper = document.getElementById('news-table-wrapper');
        const searchInput = document.getElementById('news-search-input');
        const spinner = document.getElementById('search-spinner');
        const clearBtn = document.getElementById('news-clear-search-btn');
        const bulkBtn = document.getElementById('bulk-delete-btn');
        const totalCountSpan = document.getElementById('news-total-count');
        const deleteAllForm = document.getElementById('delete-all-form');
        const deleteAllCountSpan = document.getElementById('delete-all-count');

        if (bulkBtn) bulkBtn.style.display = 'none';

        if (!url) {
            const query = searchInput ? searchInput.value.trim() : '';
            const params = new URLSearchParams();
            if (query) params.set('search', query);
            url = "{{ route('admin.news.index') }}" + (params.toString() ? '?' + params.toString() : '');
        }

        // Toggle clear button visibility
        if (clearBtn && searchInput) {
            clearBtn.style.display = searchInput.value.trim() ? 'inline-flex' : 'none';
        }

        if (spinner) spinner.style.display = 'block';
        if (tableWrapper) {
            tableWrapper.style.opacity = '0.5';
            tableWrapper.style.transition = 'opacity 0.15s ease-in-out';
        }

        if (activeAjax) {
            activeAjax.abort();
        }

        activeAjax = new AbortController();
        const signal = activeAjax.signal;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            signal: signal
        })
        .then(res => res.json())
        .then(data => {
            if (spinner) spinner.style.display = 'none';
            if (tableWrapper) {
                tableWrapper.innerHTML = data.html;
                tableWrapper.style.opacity = '1';
            }

            if (totalCountSpan && data.total !== undefined) {
                totalCountSpan.textContent = Number(data.total).toLocaleString();
            }

            if (deleteAllCountSpan && data.total !== undefined) {
                deleteAllCountSpan.textContent = Number(data.total).toLocaleString();
            }

            if (deleteAllForm) {
                deleteAllForm.style.display = data.total > 0 ? 'inline-block' : 'none';
            }

            window.history.pushState({}, '', url);
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                if (spinner) spinner.style.display = 'none';
                if (tableWrapper) tableWrapper.style.opacity = '1';
                console.error('Error in live search:', err);
            }
        });
    }

    function clearNewsSearch() {
        const searchInput = document.getElementById('news-search-input');
        if (searchInput) {
            searchInput.value = '';
            fetchNews();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('news-search-input');
        const tableWrapper = document.getElementById('news-table-wrapper');
        const bulkBtn = document.getElementById('bulk-delete-btn');
        const selectedCount = document.getElementById('selected-count');

        // Live search on input with 300ms debounce
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchNews();
                }, 300);
            });
        }

        function updateBulkState() {
            const checked = document.querySelectorAll('.news-checkbox:checked');
            if (checked.length > 0) {
                if (bulkBtn) bulkBtn.style.display = 'inline-flex';
                if (selectedCount) selectedCount.textContent = checked.length;
            } else {
                if (bulkBtn) bulkBtn.style.display = 'none';
            }
        }

        // Delegated event listener for checkboxes (works after dynamic AJAX reload)
        if (tableWrapper) {
            tableWrapper.addEventListener('change', function(e) {
                if (e.target && e.target.id === 'select-all-news') {
                    const checkboxes = document.querySelectorAll('.news-checkbox');
                    checkboxes.forEach(cb => cb.checked = e.target.checked);
                    updateBulkState();
                } else if (e.target && e.target.classList.contains('news-checkbox')) {
                    const selectAll = document.getElementById('select-all-news');
                    const checkboxes = document.querySelectorAll('.news-checkbox');
                    if (!e.target.checked && selectAll) {
                        selectAll.checked = false;
                    } else if (selectAll) {
                        selectAll.checked = document.querySelectorAll('.news-checkbox:checked').length === checkboxes.length;
                    }
                    updateBulkState();
                }
            });

            // Delegated click handler for pagination links
            tableWrapper.addEventListener('click', function(e) {
                const link = e.target.closest('.pagination-wrapper a');
                if (link) {
                    e.preventDefault();
                    fetchNews(link.getAttribute('href'));
                }
            });
        }
    });

    function submitBulkDelete() {
        const checked = document.querySelectorAll('.news-checkbox:checked');
        if (checked.length === 0) return;

        if (confirm(`Are you sure you want to delete ${checked.length} selected news article(s)? This cannot be undone.`)) {
            const ids = Array.from(checked).map(cb => cb.value);
            document.getElementById('bulk-delete-ids').value = JSON.stringify(ids);
            document.getElementById('bulk-delete-form').submit();
        }
    }
</script>
@endsection
