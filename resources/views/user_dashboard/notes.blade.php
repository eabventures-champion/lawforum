@extends('layouts.user')

@section('title', 'My Notes')

@section('styles')
<style>
    .notes-filter-bar {
        display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;
    }
    .filter-select {
        background: rgba(255,255,255,0.04); border: 1px solid var(--border-color);
        color: var(--text-primary); padding: 8px 14px; border-radius: 8px;
        font-size: 13px; font-family: inherit; cursor: pointer;
    }
    .filter-select:focus { outline: none; border-color: #3b82f6; }
    .filter-select option { background: #0f172a; color: #fff; }
    .notes-search-input {
        flex: 1; min-width: 200px; background: rgba(255,255,255,0.04);
        border: 1px solid var(--border-color); color: var(--text-primary);
        padding: 8px 14px; border-radius: 8px; font-size: 13px; font-family: inherit;
    }
    .notes-search-input:focus { outline: none; border-color: #3b82f6; }
    .notes-search-input::placeholder { color: var(--text-muted); }

    .note-dashboard-card {
        background: rgba(255,255,255,0.02); border: 1px solid var(--border-color);
        border-radius: 12px; padding: 18px 20px; margin-bottom: 14px;
        transition: all 0.25s ease; border-left: 4px solid #f59e0b;
    }
    .note-dashboard-card:hover {
        border-color: rgba(255,255,255,0.12); background: rgba(255,255,255,0.04);
    }
    .note-dashboard-card[data-color="blue"] { border-left-color: #3b82f6; }
    .note-dashboard-card[data-color="green"] { border-left-color: #10b981; }
    .note-dashboard-card[data-color="pink"] { border-left-color: #ec4899; }
    .note-dashboard-card[data-color="purple"] { border-left-color: #8b5cf6; }

    .note-doc-title {
        color: #60a5fa; font-weight: 600; text-decoration: none;
        font-size: 14px; display: block; margin-bottom: 6px;
    }
    .note-doc-title:hover { color: #93c5fd; text-decoration: underline; }
    .note-doc-title i { margin-right: 6px; font-size: 12px; }

    .note-quote-block {
        background: rgba(245,158,11,0.06); border-left: 3px solid rgba(245,158,11,0.4);
        padding: 8px 14px; border-radius: 0 8px 8px 0; margin-bottom: 10px;
        font-size: 13px; color: var(--text-secondary); line-height: 1.6;
        font-style: italic;
    }
    .note-body { font-size: 14px; color: var(--text-primary); line-height: 1.7; margin-bottom: 10px; }
    .note-section-ref {
        font-size: 12px; color: var(--text-muted); margin-bottom: 8px;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .note-footer {
        display: flex; justify-content: space-between; align-items: center;
        border-top: 1px solid var(--border-color); padding-top: 10px; margin-top: 10px;
    }
    .note-date { font-size: 12px; color: var(--text-muted); }

    .note-edit-textarea {
        width: 100%; min-height: 80px; background: rgba(255,255,255,0.04);
        border: 1px solid #3b82f6; border-radius: 8px; padding: 10px 12px;
        color: var(--text-primary); font-size: 13px; font-family: inherit;
        resize: vertical; margin-bottom: 8px; display: none;
    }
    .note-edit-textarea:focus { outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
    .note-edit-actions { display: none; gap: 8px; }

    .btn-edit-note {
        background: rgba(255,255,255,0.04); border: 1px solid var(--border-color);
        color: var(--text-secondary); padding: 5px 12px; border-radius: 6px;
        font-size: 12px; cursor: pointer; transition: all 0.2s;
    }
    .btn-edit-note:hover { background: rgba(255,255,255,0.08); color: var(--text-primary); }
    .btn-save-edit {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8); border: none;
        color: #fff; padding: 5px 14px; border-radius: 6px;
        font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s;
    }
    .btn-save-edit:hover { transform: translateY(-1px); }

    .empty-notes-state {
        text-align: center; padding: 60px 20px; color: var(--text-secondary);
    }
    .empty-notes-state i { font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.3; }
    .empty-notes-state p { font-size: 15px; margin-bottom: 6px; }
    .empty-notes-state small { font-size: 13px; color: var(--text-muted); }

    .note-card-fade-out {
        opacity: 0; transform: translateX(30px);
        transition: all 0.3s ease;
    }
</style>
@endsection

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="card-title">My Notes <span style="background: #3b82f6; color: #fff; font-size: 13px; padding: 2px 10px; border-radius: 12px; font-weight: 700; vertical-align: middle; margin-left: 6px;">{{ count($notes) }}</span></h1>
            <p class="card-subtitle" style="margin-bottom: 0;">Your personal study notes from constitutions and legislation.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="notes-filter-bar">
        <select class="filter-select" id="filterDocType" onchange="filterNotes()">
            <option value="all">All Documents</option>
            <option value="constitution">Constitution</option>
            <option value="pre_1992">Pre-1992 Legislation</option>
            <option value="post_1992">Post-1992 Legislation</option>
        </select>
        <select class="filter-select" id="filterColor" onchange="filterNotes()">
            <option value="all">All Colors</option>
            <option value="yellow">🟡 Yellow</option>
            <option value="blue">🔵 Blue</option>
            <option value="green">🟢 Green</option>
            <option value="pink">🩷 Pink</option>
            <option value="purple">🟣 Purple</option>
        </select>
        <input type="text" class="notes-search-input" id="searchNotes" placeholder="Search notes..." oninput="filterNotes()">
    </div>

    <!-- Notes List -->
    <div id="notesListDashboard">
        @forelse($notes as $note)
            <div class="note-dashboard-card"
                 data-color="{{ $note->note_color }}"
                 data-type="{{ $note->document_type }}"
                 data-note-id="{{ $note->id }}"
                 id="noteCard{{ $note->id }}">

                <a href="{{ $note->page_url }}" class="note-doc-title" target="_blank">
                    <i class="fa-solid fa-file-lines"></i> {{ $note->document_title }}
                </a>

                @if($note->highlighted_text)
                    <div class="note-quote-block">
                        "{{ Str::limit($note->highlighted_text, 300) }}"
                    </div>
                @endif

                <div class="note-body" id="noteBody{{ $note->id }}">{{ $note->note_content }}</div>

                <textarea class="note-edit-textarea" id="noteEdit{{ $note->id }}">{{ $note->note_content }}</textarea>
                <div class="note-edit-actions" id="noteEditActions{{ $note->id }}">
                    <button class="btn-save-edit" onclick="saveEditNote({{ $note->id }})">
                        <i class="fa-solid fa-check"></i> Save
                    </button>
                    <button class="btn-edit-note" onclick="cancelEditNote({{ $note->id }})">Cancel</button>
                </div>

                @if($note->article_section)
                    <div class="note-section-ref">
                        <i class="fa-solid fa-bookmark" style="font-size: 10px;"></i>
                        {{ Str::limit($note->article_section, 60) }}
                    </div>
                @endif

                <div class="note-footer">
                    <span class="note-date">
                        <i class="fa-regular fa-clock" style="margin-right: 4px;"></i>
                        {{ $note->created_at->format('M j, Y \a\t g:i A') }}
                    </span>
                    <div style="display: flex; gap: 8px;">
                        <button class="btn-edit-note" onclick="startEditNote({{ $note->id }})">
                            <i class="fa-solid fa-pen" style="margin-right: 3px;"></i> Edit
                        </button>
                        <button class="btn-edit-note" style="color: #ef4444;" onclick="deleteNoteDashboard({{ $note->id }})">
                            <i class="fa-solid fa-trash-can" style="margin-right: 3px;"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-notes-state">
                <i class="fa-regular fa-note-sticky"></i>
                <p>No notes yet</p>
                <small>Start reading constitutions or legislation and take notes from the Reader Tools panel.</small>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Filter notes by type, color, and search text
    function filterNotes() {
        var docType = document.getElementById('filterDocType').value;
        var color = document.getElementById('filterColor').value;
        var search = document.getElementById('searchNotes').value.toLowerCase();

        document.querySelectorAll('.note-dashboard-card').forEach(function(card) {
            var matchType = (docType === 'all' || card.getAttribute('data-type') === docType);
            var matchColor = (color === 'all' || card.getAttribute('data-color') === color);
            var matchSearch = !search || card.textContent.toLowerCase().includes(search);

            card.style.display = (matchType && matchColor && matchSearch) ? 'block' : 'none';
        });
    }

    // Inline edit
    function startEditNote(id) {
        document.getElementById('noteBody' + id).style.display = 'none';
        document.getElementById('noteEdit' + id).style.display = 'block';
        document.getElementById('noteEditActions' + id).style.display = 'flex';
        document.getElementById('noteEdit' + id).focus();
    }

    function cancelEditNote(id) {
        document.getElementById('noteBody' + id).style.display = 'block';
        document.getElementById('noteEdit' + id).style.display = 'none';
        document.getElementById('noteEditActions' + id).style.display = 'none';
    }

    function saveEditNote(id) {
        var newContent = document.getElementById('noteEdit' + id).value.trim();
        if (!newContent) return;

        $.ajax({
            url: '/notes/' + id,
            type: 'PATCH',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { note_content: newContent },
            success: function(response) {
                if (response.success) {
                    document.getElementById('noteBody' + id).textContent = newContent;
                    cancelEditNote(id);
                }
            },
            error: function() { alert('Failed to update note.'); }
        });
    }

    // Delete note
    function deleteNoteDashboard(id) {
        if (!confirm('Are you sure you want to delete this note?')) return;

        $.ajax({
            url: '/notes/' + id,
            type: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                if (response.success) {
                    var card = document.getElementById('noteCard' + id);
                    card.classList.add('note-card-fade-out');
                    setTimeout(function() { card.remove(); }, 300);
                }
            },
            error: function() { alert('Failed to delete note.'); }
        });
    }
</script>
@endsection
