@if ($cases->hasPages())
    <div class="pagination-wrapper" style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: 12px;">
        <div style="font-size: 13px; color: var(--text-secondary);">
            Showing {{ $cases->firstItem() }} to {{ $cases->lastItem() }} of {{ $cases->total() }} cases
        </div>
        <div style="display: flex; gap: 6px;">
            @if ($cases->onFirstPage())
                <span class="btn btn-secondary" style="padding: 4px 10px; font-size: 12px; opacity: 0.5; cursor: not-allowed;">Previous</span>
            @else
                <a href="{{ $cases->appends(['court' => $court, 'category' => $category, 'search' => request('search')])->previousPageUrl() }}" class="btn btn-secondary ajax-page-link" style="padding: 4px 10px; font-size: 12px;">Previous</a>
            @endif

            @foreach ($cases->getUrlRange(max(1, $cases->currentPage() - 2), min($cases->lastPage(), $cases->currentPage() + 2)) as $page => $url)
                @if ($page == $cases->currentPage())
                    <span class="btn btn-primary" style="padding: 4px 10px; font-size: 12px;">{{ $page }}</span>
                @else
                    <a href="{{ $cases->appends(['court' => $court, 'category' => $category, 'search' => request('search')])->url($page) }}" class="btn btn-secondary ajax-page-link" style="padding: 4px 10px; font-size: 12px;">{{ $page }}</a>
                @endif
            @endforeach

            @if ($cases->hasMorePages())
                <a href="{{ $cases->appends(['court' => $court, 'category' => $category, 'search' => request('search')])->nextPageUrl() }}" class="btn btn-secondary ajax-page-link" style="padding: 4px 10px; font-size: 12px;">Next</a>
            @else
                <span class="btn btn-secondary" style="padding: 4px 10px; font-size: 12px; opacity: 0.5; cursor: not-allowed;">Next</span>
            @endif
        </div>
    </div>
@endif
