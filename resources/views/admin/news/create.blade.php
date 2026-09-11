@extends('layouts.admin')

@section('title', 'Write News Article')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">
<style>
    select.form-control, #news_category {
        color-scheme: dark;
        background-color: #121824 !important;
        color: #f3f4f6 !important;
    }
    #news_category option {
        background-color: #121824 !important;
        color: #f3f4f6 !important;
    }
    #news_category option:disabled {
        color: #6b7280 !important;
    }

    /* Dark Theme for Quill Editor */
    .ql-toolbar.ql-snow {
        background: #121824 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important;
        padding: 10px 14px !important;
    }
    .ql-container.ql-snow {
        background: #090d16 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-top: none !important;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        color: #e2e8f0 !important;
        font-size: 15px !important;
        font-family: inherit !important;
        min-height: 300px !important;
    }
    .ql-editor {
        min-height: 300px !important;
        line-height: 1.75 !important;
        color: #cbd5e1 !important;
        font-size: 15px !important;
    }
    .ql-editor.ql-blank::before {
        color: #64748b !important;
        font-style: normal !important;
        font-size: 14.5px !important;
    }
    .ql-snow .ql-stroke {
        stroke: #94a3b8 !important;
    }
    .ql-snow .ql-fill {
        fill: #94a3b8 !important;
    }
    .ql-snow .ql-picker {
        color: #cbd5e1 !important;
    }
    .ql-snow .ql-picker-label {
        border: 1px solid transparent !important;
        border-radius: 4px !important;
    }
    .ql-snow .ql-picker-label:hover {
        color: #60a5fa !important;
    }
    .ql-snow .ql-picker-label:hover .ql-stroke {
        stroke: #60a5fa !important;
    }
    .ql-snow .ql-picker.ql-expanded .ql-picker-label {
        border-color: rgba(59, 130, 246, 0.4) !important;
        color: #60a5fa !important;
    }
    .ql-snow .ql-picker.ql-expanded .ql-picker-options {
        background-color: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6) !important;
        border-radius: 8px !important;
        padding: 6px !important;
        z-index: 100 !important;
    }
    .ql-snow .ql-picker-item {
        color: #cbd5e1 !important;
        border-radius: 4px !important;
        padding: 4px 8px !important;
    }
    .ql-snow .ql-picker-item:hover, .ql-snow .ql-picker-item.ql-selected {
        color: #60a5fa !important;
        background: rgba(59, 130, 246, 0.15) !important;
    }
    .ql-snow.ql-toolbar button:hover,
    .ql-snow.ql-toolbar button.ql-active {
        background: rgba(59, 130, 246, 0.15) !important;
        border-radius: 4px !important;
    }
    .ql-snow.ql-toolbar button:hover .ql-stroke,
    .ql-snow.ql-toolbar button.ql-active .ql-stroke {
        stroke: #60a5fa !important;
    }
    .ql-snow.ql-toolbar button:hover .ql-fill,
    .ql-snow.ql-toolbar button.ql-active .ql-fill {
        fill: #60a5fa !important;
    }
    .ql-snow .ql-tooltip {
        background-color: #1e293b !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #e2e8f0 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6) !important;
        border-radius: 8px !important;
        padding: 10px 14px !important;
    }
    .ql-snow .ql-tooltip input[type=text] {
        background: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
        border-radius: 6px !important;
        padding: 6px 10px !important;
    }
    .ql-snow .ql-tooltip a.ql-action::after {
        border-right: 1px solid rgba(255, 255, 255, 0.15) !important;
    }
    .ql-snow a {
        color: #60a5fa !important;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Write New News Article</h1>
        <p class="page-subtitle">Publish a new legal news article, commentary, or blog update.</p>
    </div>
    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary" style="margin-right: 28px;">
        <i class="fa-solid fa-arrow-left"></i> Back to List
    </a>
</div>

<div class="card-table" style="max-width: 900px; padding: 32px;">
    <form id="news-article-form" action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
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
            <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                <span>Full Article Content</span>
                <span style="font-size: 11.5px; color: var(--text-muted); font-weight: normal;">Rich formatting, headings, lists & links enabled</span>
            </label>
            
            <!-- Hidden textarea for form submission -->
            <textarea id="content" name="content" style="display: none;">{{ old('content') }}</textarea>
            
            <!-- Quill WYSIWYG Editor Container -->
            <div id="quill-editor" style="background: #090d16;">{!! old('content') !!}</div>
            @error('content') <small style="color: var(--danger-color); display: block; margin-top: 6px;">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
            <i class="fa-solid fa-paper-plane"></i> Publish Article
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toolbarOptions = [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['blockquote', 'code-block'],
            [{ 'align': [] }],
            ['link', 'image'],
            ['clean']
        ];

        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Write the main body of the article here with rich text formatting...',
            modules: {
                toolbar: toolbarOptions
            }
        });

        // Add helpful tooltips on hover to all toolbar tools
        function addQuillTooltips() {
            const tooltips = {
                '.ql-header': 'Heading Style (H1, H2, H3, Normal)',
                '.ql-header .ql-picker-label': 'Heading Style (H1, H2, H3, Normal)',
                '.ql-bold': 'Bold (Ctrl+B)',
                '.ql-italic': 'Italic (Ctrl+I)',
                '.ql-underline': 'Underline (Ctrl+U)',
                '.ql-strike': 'Strikethrough',
                '.ql-color': 'Text Color',
                '.ql-color .ql-picker-label': 'Text Color',
                '.ql-background': 'Highlight Background Color',
                '.ql-background .ql-picker-label': 'Highlight Background Color',
                '.ql-list[value="ordered"]': 'Numbered List',
                '.ql-list[value="bullet"]': 'Bulleted List',
                '.ql-blockquote': 'Blockquote',
                '.ql-code-block': 'Code Block',
                '.ql-align': 'Text Alignment',
                '.ql-align .ql-picker-label': 'Text Alignment',
                '.ql-link': 'Insert Link (Ctrl+K)',
                '.ql-image': 'Insert Image',
                '.ql-clean': 'Clear Formatting (Remove all formatting from selected text)'
            };

            for (const [selector, title] of Object.entries(tooltips)) {
                document.querySelectorAll('.ql-toolbar ' + selector).forEach(el => {
                    el.setAttribute('title', title);
                });
            }
        }
        addQuillTooltips();

        const form = document.getElementById('news-article-form');
        const contentTextarea = document.getElementById('content');

        // Sync content changes
        quill.on('text-change', function() {
            const isBlank = quill.getText().trim().length === 0;
            contentTextarea.value = isBlank ? '' : quill.root.innerHTML;
        });

        // Form submit validation and final sync
        form.addEventListener('submit', function(e) {
            const isBlank = quill.getText().trim().length === 0;
            if (isBlank) {
                e.preventDefault();
                alert('Please enter the full article content.');
                quill.focus();
                return false;
            }
            contentTextarea.value = quill.root.innerHTML;
        });
    });
</script>
@endsection
