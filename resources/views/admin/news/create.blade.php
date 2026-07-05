@extends('layouts.admin')

@section('title', 'Write News Article')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Write New News Article</h1>
        <p class="page-subtitle">Publish a new legal news article, commentary, or blog update.</p>
    </div>
    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card-table" style="max-width: 900px; padding: 32px;">
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">Article Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter a compelling title..." required>
            @error('title') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
            <div class="form-group">
                <label for="news_category" class="form-label">Category</label>
                <select id="news_category" name="news_category" class="form-control" required>
                    <option value="" disabled selected>Select category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ old('news_category') == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('news_category') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Feature Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                <small style="display: block; color: var(--text-secondary); margin-top: 4px;">Supported: JPG, PNG, GIF. Max: 2MB.</small>
                @error('image') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="extract" class="form-label">Summary / Extract</label>
            <textarea id="extract" name="extract" class="form-control" placeholder="Write a short summary (for listings and SEO)..." style="min-height: 80px;" required>{{ old('extract') }}</textarea>
            @error('extract') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="content" class="form-label">Full Article Content</label>
            <textarea id="content" name="content" class="form-control" placeholder="Write the main body of the article here..." required>{{ old('content') }}</textarea>
            @error('content') <small style="color: var(--danger-color);">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
            <i class="fa-solid fa-paper-plane"></i> Publish Article
        </button>
    </form>
</div>
@endsection
