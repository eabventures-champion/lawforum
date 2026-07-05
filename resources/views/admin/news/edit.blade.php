@extends('layouts.admin')

@section('title', 'Edit News Article')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit News Article</h1>
        <p class="page-subtitle">Update article text, settings, or replace feature image.</p>
    </div>
    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card-table" style="max-width: 900px; padding: 32px;">
    <form action="{{ route('admin.news.update', $newsArticle->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">Article Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $newsArticle->title) }}" required>
            @error('title') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="news_category" class="form-label">Category</label>
                <select id="news_category" name="news_category" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ old('news_category', $newsArticle->news_category) == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('news_category') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Feature Image</label>
                <div style="display: flex; gap: 12px; align-items: center;">
                    @if($newsArticle->image)
                        <img src="{{ url('storage/' . $newsArticle->image) }}" alt="Current Image" style="width: 64px; height: 48px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-color);">
                    @endif
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Leave blank to keep the current image. Max: 2MB.</small>
                @error('image') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="extract" class="form-label">Summary / Extract</label>
            <textarea id="extract" name="extract" class="form-control" style="min-height: 80px;" required>{{ old('extract', $newsArticle->extract) }}</textarea>
            @error('extract') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="content" class="form-label">Full Article Content</label>
            <textarea id="content" name="content" class="form-control" required>{{ old('content', $newsArticle->content) }}</textarea>
            @error('content') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
            <i class="fa-solid fa-floppy-disk"></i> Save Article Changes
        </button>
    </form>
</div>
@endsection
