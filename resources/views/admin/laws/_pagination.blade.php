@if($laws->hasPages())
    <div class="pagination-wrapper">
        <div style="color: var(--text-secondary); font-size: 14px;">
            Showing {{ $laws->firstItem() ?? 0 }} to {{ $laws->lastItem() ?? 0 }} of {{ $laws->total() }} items
        </div>
        <div style="display: flex; gap: 8px;">
            @if($laws->onFirstPage())
                <button class="btn btn-secondary btn-action" disabled>Previous</button>
            @else
                <a href="{{ $laws->previousPageUrl() }}" class="btn btn-secondary btn-action ajax-page-link">Previous</a>
            @endif

            @if($laws->hasMorePages())
                <a href="{{ $laws->nextPageUrl() }}" class="btn btn-secondary btn-action ajax-page-link">Next</a>
            @else
                <button class="btn btn-secondary btn-action" disabled>Next</button>
            @endif
        </div>
    </div>
@endif