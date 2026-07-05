@extends('layouts.admin')

@section('title', 'News & Articles')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">News & Articles</h1>
        <p class="page-subtitle">Manage legal news, articles, and blog updates.</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Write New Article
    </a>
</div>

<div class="card-table">
    <div class="table-header" style="flex-wrap: wrap; gap: 16px;">
        <h2 class="table-title">All News Articles</h2>
        
        <!-- Search Form -->
        <form action="{{ route('admin.news.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" class="form-control" placeholder="Search news..." value="{{ request('search') }}" style="width: 260px; padding: 8px 16px;">
            <button type="submit" class="btn btn-primary btn-action" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-action" style="padding: 8px 16px;">Clear</a>
            @endif
        </form>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 80px;">Thumbnail</th>
                <th>Title</th>
                <th>Category</th>
                <th>Extract</th>
                <th>Published Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $article)
                <tr>
                    <td>
                        @if($article->image)
                            <img src="{{ url('storage/' . $article->image) }}" alt="Image" style="width: 48px; height: 32px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                        @else
                            <div style="width: 48px; height: 32px; border-radius: 4px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 10px; color: var(--text-secondary);">No img</div>
                        @endif
                    </td>
                    <td style="font-weight: 600; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $article->title }}
                    </td>
                    <td><span class="badge badge-accent">{{ $article->news_category }}</span></td>
                    <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--text-secondary);">
                        {{ $article->extract }}
                    </td>
                    <td>{{ $article->created_at ? $article->created_at->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; font-size: 12px;">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-action" style="padding: 6px 12px; font-size: 12px;">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 32px;">No news articles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($news->hasPages())
        <div class="pagination-wrapper">
            <div style="color: var(--text-secondary); font-size: 14px;">
                Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }} articles
            </div>
            <div style="display: flex; gap: 8px;">
                @if($news->onFirstPage())
                    <button class="btn btn-secondary btn-action" disabled>Previous</button>
                @else
                    <a href="{{ $news->previousPageUrl() }}" class="btn btn-secondary btn-action">Previous</a>
                @endif

                @if($news->hasMorePages())
                    <a href="{{ $news->nextPageUrl() }}" class="btn btn-secondary btn-action">Next</a>
                @else
                    <button class="btn btn-secondary btn-action" disabled>Next</button>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
