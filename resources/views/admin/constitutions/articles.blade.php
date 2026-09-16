@extends('layouts.admin')

@section('title', 'Manage Articles - ' . $act->title)

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow {
        background: #121824 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important;
        padding: 8px 12px !important;
    }
    .ql-container.ql-snow {
        background: #090d16 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-top: none !important;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
        color: #e2e8f0 !important;
        font-size: 14px !important;
        min-height: 180px !important;
        max-height: 280px !important;
        overflow-y: auto !important;
    }
    .ql-editor { min-height: 180px !important; line-height: 1.7 !important; color: #f1f5f9 !important; }
    .ql-editor * { color: #f1f5f9 !important; }
    .ql-snow .ql-stroke { stroke: #94a3b8 !important; }
    .ql-snow .ql-fill { fill: #94a3b8 !important; }
    .ql-snow .ql-picker { color: #cbd5e1 !important; }

    /* Chapter Card */
    .chapter-card {
        background: #111827;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
    }
    .chapter-header {
        padding: 16px 20px;
        background: rgba(255, 255, 255, 0.02);
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        user-select: none;
        border-bottom: 1px solid transparent;
        transition: background 0.15s;
    }
    .chapter-header:hover {
        background: rgba(255, 255, 255, 0.04);
    }
    .chapter-header.open {
        border-bottom-color: rgba(255, 255, 255, 0.06);
    }
    .chapter-body {
        display: none;
    }
    .chapter-card.is-open > .chapter-body {
        display: block;
    }
    .article-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        transition: background 0.15s;
        gap: 16px;
    }
    .article-item-row:last-child {
        border-bottom: none;
    }
    .article-item-row:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    /* Modal Backdrop */
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
        width: 760px;
        max-width: 96vw;
        max-height: 88vh;
        max-height: calc(100vh - 48px);
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85);
        overflow: hidden;
        animation: modalFadeIn 0.2s ease-out;
    }
    .custom-modal-dialog form {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        min-height: 0;
        overflow: hidden;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.97) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
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
        padding: 20px 24px;
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
</style>
@endsection

@section('content')
<div class="page-header" style="padding-left: 20px;">
    <div>
        <a href="{{ route('admin.constitutions.index', ['tab' => $target]) }}" class="btn btn-secondary" style="margin-bottom: 10px; display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; padding: 6px 12px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Constitutions
        </a>
        <h1 class="page-title">{{ $act->title }}</h1>
        <p class="page-subtitle">Manage individual chapters, sections, articles, and display priority.</p>
    </div>
    <div style="margin-right: 28px;">
        <button type="button" class="btn btn-primary" onclick="openAddArticleModal()">
            <i class="fa-solid fa-plus"></i> Add New Article
        </button>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="card-table" style="padding: 16px 20px; margin-bottom: 20px;">
    <form method="GET" action="{{ route('admin.constitutions.articles', $target) }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <input type="text" name="search" class="form-control" placeholder="Search by section, chapter, text..." value="{{ $search }}" style="width: 280px;">
        <select name="chapter" class="form-control" style="width: 240px;">
            <option value="">All Chapters</option>
            @foreach($distinctChapters as $chap)
                <option value="{{ $chap }}" {{ $chapterFilter === $chap ? 'selected' : '' }}>{{ $chap }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
            <i class="fa-solid fa-magnifying-glass"></i> Filter
        </button>
        @if(!empty($search) || !empty($chapterFilter))
            <a href="{{ route('admin.constitutions.articles', $target) }}" class="btn btn-secondary" style="padding: 8px 16px;">
                <i class="fa-solid fa-xmark"></i> Clear
            </a>
        @endif
    </form>
</div>

<!-- Chapters & Articles List -->
@forelse($groupedChapters as $chapName => $articles)
    <div class="chapter-card {{ count($groupedChapters) === 1 ? 'is-open' : '' }}" id="chapter-card-{{ Str::slug($chapName) }}">
        <div class="chapter-header {{ count($groupedChapters) === 1 ? 'open' : '' }}" onclick="toggleChapter('{{ Str::slug($chapName) }}')">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-chevron-down chapter-toggle-icon" id="icon-{{ Str::slug($chapName) }}" style="color: var(--text-secondary); font-size: 12px; transition: transform 0.2s; {{ count($groupedChapters) === 1 ? 'transform: rotate(180deg);' : '' }}"></i>
                <h3 style="margin: 0; font-size: 15px; font-weight: 600; color: #fff;">{{ $chapName }}</h3>
                <span class="badge" style="background: rgba(59,130,246,0.15); color: #60a5fa; font-size: 11px; padding: 2px 8px;">
                    {{ count($articles) }} {{ count($articles) === 1 ? 'article' : 'articles' }}
                </span>
            </div>
            <div>
                <button type="button" class="btn btn-secondary" onclick="event.stopPropagation(); openAddArticleModal('{{ addslashes($chapName) }}')" style="padding: 4px 10px; font-size: 12px;">
                    <i class="fa-solid fa-plus"></i> Add in Chapter
                </button>
            </div>
        </div>

        <div class="chapter-body" id="body-{{ Str::slug($chapName) }}" style="{{ count($groupedChapters) === 1 ? 'display: block;' : '' }}">
            @foreach($articles as $art)
                <div class="article-item-row">
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <span class="badge" style="background: rgba(255,255,255,0.06); color: #60a5fa; font-size: 11px; padding: 2px 7px;">
                                Priority: {{ $art->priority ?: 0 }}
                            </span>
                            <span style="font-size: 14px; font-weight: 600; color: #fff;">
                                {{ $art->section }}
                            </span>
                        </div>
                        <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.5; max-height: 40px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Str::limit(strip_tags($art->articles), 130) }}
                        </div>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center; flex-shrink: 0;">
                        <button type="button" class="btn btn-secondary btn-action" title="Edit Article" onclick='openEditArticleModal(@json($art))' style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #cbd5e1;">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.constitutions.articles.destroy', ['target' => $target, 'articleId' => $art->id]) }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('Delete this article?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-action" title="Delete Article" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@empty
    <div style="text-align: center; color: var(--text-secondary); padding: 48px; background: #111827; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
        <i class="fa-solid fa-folder-open" style="font-size: 32px; opacity: 0.4; margin-bottom: 12px; display: block;"></i>
        No articles found matching your criteria.
    </div>
@endforelse

<!-- Add / Edit Article Modal -->
<div id="modal-article" class="custom-modal-backdrop" style="display: none;" onclick="if(event.target === this) closeArticleModal()">
    <div class="custom-modal-dialog">
        <form id="form-article" action="" method="POST">
            @csrf
            <input type="hidden" name="_method" id="article-method" value="POST">
            <div class="custom-modal-header">
                <h3 id="article-modal-title" style="margin: 0; font-size: 16px; font-weight: 700; color: #fff;">Add New Article</h3>
                <button type="button" class="modal-close-btn" onclick="closeArticleModal()">&times;</button>
            </div>
            <div class="custom-modal-body">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px; margin-bottom: 14px;">
                    <div>
                        <label class="form-label" style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Chapter / Group</label>
                        <input type="text" name="chapter" id="article-chapter-input" list="chapter-suggestions" class="form-control" placeholder="e.g. Chapter 1 - The Constitution" required style="width: 100%;">
                        <datalist id="chapter-suggestions">
                            @foreach($distinctChapters as $chap)
                                <option value="{{ $chap }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div>
                        <label class="form-label" style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Priority / Sort Order</label>
                        <input type="number" name="priority" id="article-priority-input" class="form-control" value="0" style="width: 100%;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Section / Heading</label>
                    <input type="text" name="section" id="article-section-input" class="form-control" placeholder="e.g. Article 1. Supremacy of the Constitution." required style="width: 100%;">
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-secondary); margin-bottom: 6px;">Article Content</label>
                    <div id="article-quill-editor"></div>
                    <textarea name="articles" id="article-content-hidden" style="display: none;"></textarea>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeArticleModal()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Save Article</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>
<script>
    let articleQuill = null;

    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('article-quill-editor');
        if (container) {
            articleQuill = new Quill(container, {
                theme: 'snow',
                placeholder: 'Enter constitutional article content...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });

            document.getElementById('form-article').addEventListener('submit', function() {
                document.getElementById('article-content-hidden').value = articleQuill.root.innerHTML;
            });
        }
    });

    function toggleChapter(slug) {
        const card = document.getElementById('chapter-card-' + slug);
        const body = document.getElementById('body-' + slug);
        const icon = document.getElementById('icon-' + slug);

        if (card.classList.contains('is-open')) {
            card.classList.remove('is-open');
            body.style.display = 'none';
            icon.style.transform = 'rotate(0deg)';
        } else {
            card.classList.add('is-open');
            body.style.display = 'block';
            icon.style.transform = 'rotate(180deg)';
        }
    }

    function openAddArticleModal(prefilledChapter = '') {
        const modal = document.getElementById('modal-article');
        const form = document.getElementById('form-article');
        form.action = "{{ route('admin.constitutions.articles.store', $target) }}";
        document.getElementById('article-method').value = 'POST';
        document.getElementById('article-modal-title').textContent = 'Add New Article';
        document.getElementById('article-chapter-input').value = prefilledChapter;
        document.getElementById('article-section-input').value = '';
        document.getElementById('article-priority-input').value = '0';
        if (articleQuill) articleQuill.root.innerHTML = '';
        modal.style.display = 'flex';
    }

    function openEditArticleModal(art) {
        const modal = document.getElementById('modal-article');
        const form = document.getElementById('form-article');
        form.action = `{{ url('admin/constitutions/articles') }}/{{ $target }}/${art.id}/update`;
        document.getElementById('article-method').value = 'PUT';
        document.getElementById('article-modal-title').textContent = 'Edit Article';
        document.getElementById('article-chapter-input').value = art.chapter || '';
        document.getElementById('article-section-input').value = art.section || '';
        document.getElementById('article-priority-input').value = art.priority || 0;
        if (articleQuill) articleQuill.root.innerHTML = art.articles || '';
        modal.style.display = 'flex';
    }

    function closeArticleModal() {
        document.getElementById('modal-article').style.display = 'none';
    }
</script>
@endsection
