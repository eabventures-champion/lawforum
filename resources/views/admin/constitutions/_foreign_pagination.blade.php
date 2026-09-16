@if ($constitutions->hasPages())
    <div class="pagination-wrapper" style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: 12px;">
        <div style="font-size: 13px; color: var(--text-secondary);">
            Showing {{ $constitutions->firstItem() }} to {{ $constitutions->lastItem() }} of {{ $constitutions->total() }} constitutions
        </div>
        <div style="display: flex; gap: 6px;">
            @if ($constitutions->onFirstPage())
                <span class="btn btn-secondary" style="padding: 4px 10px; font-size: 12px; opacity: 0.5; cursor: not-allowed;">Previous</span>
            @else
                <a href="{{ $constitutions->appends(['tab' => 'foreign', 'continent' => $continent, 'search' => request('search')])->previousPageUrl() }}" class="btn btn-secondary ajax-page-link" style="padding: 4px 10px; font-size: 12px;">Previous</a>
            @endif

            @foreach ($constitutions->getUrlRange(max(1, $constitutions->currentPage() - 2), min($constitutions->lastPage(), $constitutions->currentPage() + 2)) as $page => $url)
                @if ($page == $constitutions->currentPage())
                    <span class="btn btn-primary" style="padding: 4px 10px; font-size: 12px;">{{ $page }}</span>
                @else
                    <a href="{{ $constitutions->appends(['tab' => 'foreign', 'continent' => $continent, 'search' => request('search')])->url($page) }}" class="btn btn-secondary ajax-page-link" style="padding: 4px 10px; font-size: 12px;">{{ $page }}</a>
                @endif
            @endforeach

            @if ($constitutions->hasMorePages())
                <a href="{{ $constitutions->appends(['tab' => 'foreign', 'continent' => $continent, 'search' => request('search')])->nextPageUrl() }}" class="btn btn-secondary ajax-page-link" style="padding: 4px 10px; font-size: 12px;">Next</a>
            @else
                <span class="btn btn-secondary" style="padding: 4px 10px; font-size: 12px; opacity: 0.5; cursor: not-allowed;">Next</span>
            @endif
        </div>
    </div>
@endif
