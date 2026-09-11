<div style="overflow-x: auto; width: 100%;">
    <table class="custom-table" style="width: 100%; min-width: 880px;">
        <thead>
            <tr>
                <th style="width: 40px; text-align: center; padding-left: 20px;">
                    <input type="checkbox" id="select-all-news" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;">
                </th>
                <th style="width: 110px;">Thumbnail</th>
                <th>Article Details</th>
                <th style="width: 150px;">Published Date</th>
                <th style="width: 150px; text-align: right; padding-right: 24px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $article)
                <tr>
                    <td style="text-align: center; vertical-align: middle; padding-left: 20px;">
                        <input type="checkbox" class="news-checkbox" value="{{ $article->id }}" style="width: 16px; height: 16px; cursor: pointer; vertical-align: middle;">
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 7px;">
                            <div onclick="openNewsPreview({{ $article->id }})" style="width: 54px; height: 38px; border-radius: 6px; overflow: hidden; position: relative; background: rgba(255,255,255,0.04); border: 1px solid var(--border-color); display: flex; align-items: center; justify-content: center; flex-shrink: 0; cursor: pointer; transition: transform 0.15s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" title="Click to preview article">
                                @if($article->image)
                                    <img src="{{ Str::startsWith($article->image, 'http') ? $article->image : (Str::startsWith($article->image, 'storage/') ? asset($article->image) : asset('storage/' . $article->image)) }}" 
                                         alt="Thumbnail" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                         style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                @endif
                                <div style="{{ $article->image ? 'display: none;' : 'display: flex;' }} width: 100%; height: 100%; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 14px;">
                                    <i class="fa-regular fa-newspaper"></i>
                                </div>
                            </div>
                            <span class="badge badge-accent" style="white-space: nowrap; font-size: 10.5px; padding: 2px 7px; border-radius: 4px; line-height: 1.2;">
                                {{ $article->news_category }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div onclick="openNewsPreview({{ $article->id }})" style="cursor: pointer;" title="Click to preview article">
                            <div style="font-weight: 600; color: #fff; font-size: 14px; line-height: 1.4; margin-bottom: 4px; transition: color 0.2s;" onmouseover="this.style.color='#60a5fa';" onmouseout="this.style.color='#fff';">
                                {{ $article->title }}
                            </div>
                            @if($article->extract)
                                <div style="font-size: 12px; color: var(--text-secondary); line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 620px;">
                                    {{ $article->extract }}
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="color: #e2e8f0; font-weight: 500; font-size: 13px; white-space: nowrap;">
                            {{ $article->created_at ? $article->created_at->format('M d, Y') : 'N/A' }}
                        </div>
                        <div style="color: var(--text-secondary); font-size: 11px; margin-top: 2px; white-space: nowrap;">
                            {{ $article->created_at ? $article->created_at->diffForHumans() : '' }}
                        </div>
                    </td>
                    <td style="text-align: right; padding-right: 24px;">
                        <div style="display: inline-flex; gap: 8px; align-items: center; justify-content: flex-end;">
                            <button type="button" onclick="openNewsPreview({{ $article->id }})" class="btn btn-action" style="width: 34px; height: 34px; padding: 0; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#3b82f6'; this.style.color='#fff';" onmouseout="this.style.background='rgba(59, 130, 246, 0.15)'; this.style.color='#60a5fa';" title="Preview Article">
                                <i class="fa-solid fa-eye" style="font-size: 13px;"></i>
                            </button>
                            <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-secondary btn-action" style="width: 34px; height: 34px; padding: 0; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;" title="Edit Article">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')" style="margin: 0; display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-action" style="width: 34px; height: 34px; padding: 0; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;" title="Delete Article">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 40px 20px;">
                        <i class="fa-solid fa-newspaper" style="font-size: 28px; opacity: 0.4; display: block; margin-bottom: 8px;"></i>
                        No news articles found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($news->hasPages())
    <div class="pagination-wrapper" style="padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: 12px;">
        <div style="color: var(--text-secondary); font-size: 13px;">
            Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }} articles
        </div>
        <div style="display: flex; gap: 8px;">
            @if($news->onFirstPage())
                <button class="btn btn-secondary btn-action" disabled style="opacity: 0.5; cursor: not-allowed;">Previous</button>
            @else
                <a href="{{ $news->previousPageUrl() }}" class="btn btn-secondary btn-action">Previous</a>
            @endif

            @if($news->hasMorePages())
                <a href="{{ $news->nextPageUrl() }}" class="btn btn-secondary btn-action">Next</a>
            @else
                <button class="btn btn-secondary btn-action" disabled style="opacity: 0.5; cursor: not-allowed;">Next</button>
            @endif
        </div>
    </div>
@endif
