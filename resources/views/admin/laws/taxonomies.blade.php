@extends('layouts.admin')

@section('title', 'Manage Groups & Categories')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manage Groups & Categories</h1>
        <p class="page-subtitle">Dynamically configure Post 1992 Groups and Categories used in New Laws.</p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ route('admin.laws.index', ['type' => 'post1992']) }}" class="btn btn-secondary" style="margin-right: 28px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Laws
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-exclamation"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if(isset($errors) && $errors->any())
    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px;">
        <div style="font-weight: 600; margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-triangle-exclamation"></i> Please correct the following errors:
        </div>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 24px; align-items: start;">
    
    <!-- Post 1992 Groups Card -->
    <div class="card-table">
        <div class="table-header" style="flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 class="table-title" style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-layer-group" style="color: #3b82f6;"></i> Post 1992 Groups
                    <span style="font-size: 12px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; padding: 2px 10px; border-radius: 12px; font-weight: 600;">
                        {{ $groups->count() }}
                    </span>
                </h2>
                <p style="margin: 4px 0 0 0; font-size: 13px; color: var(--text-secondary);">Groups such as ACTS OF PARLIAMENT, etc.</p>
            </div>
            <button type="button" class="btn btn-primary btn-action" onclick="openAddGroupModal()" style="padding: 8px 16px;">
                <i class="fa-solid fa-plus"></i> Add Group
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Group Name</th>
                        <th style="width: 110px; text-align: center;">Laws Linked</th>
                        <th style="width: 120px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $index => $group)
                        <tr>
                            <td style="color: var(--text-secondary); font-size: 13px;">{{ $index + 1 }}</td>
                            <td style="font-weight: 600; color: #fff;">
                                {{ $group->name }}
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-accent" style="font-size: 11px;">
                                    {{ $group->laws_count }} {{ Str::plural('law', $group->laws_count) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <button type="button" class="btn-action edit" title="Edit Group" onclick="openEditGroupModal({{ $group->id }}, '{{ addslashes($group->name) }}')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.laws.groups.destroy', $group->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this group? (Existing laws will retain the text, but the option will be removed from future selection)')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Delete Group">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 32px 16px;">
                                <i class="fa-regular fa-folder-open" style="font-size: 28px; margin-bottom: 8px; opacity: 0.5; display: block;"></i>
                                No Post 1992 Groups found. Click "+ Add Group" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Post Categories Card -->
    <div class="card-table">
        <div class="table-header" style="flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 class="table-title" style="display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-folder-tree" style="color: #10b981;"></i> Post Categories
                    <span style="font-size: 12px; background: rgba(16, 185, 129, 0.15); color: #34d399; padding: 2px 10px; border-radius: 12px; font-weight: 600;">
                        {{ $categories->count() }}
                    </span>
                </h2>
                <p style="margin: 4px 0 0 0; font-size: 13px; color: var(--text-secondary);">Sub-classifications such as TAXATION, CRIMINAL, etc.</p>
            </div>
            <button type="button" class="btn btn-primary btn-action" onclick="openAddCategoryModal()" style="padding: 8px 16px; background: #10b981; border-color: #10b981;">
                <i class="fa-solid fa-plus"></i> Add Category
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Category Name</th>
                        <th style="width: 110px; text-align: center;">Laws Linked</th>
                        <th style="width: 120px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                        <tr>
                            <td style="color: var(--text-secondary); font-size: 13px;">{{ $index + 1 }}</td>
                            <td style="font-weight: 600; color: #fff;">
                                {{ $category->name }}
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-accent" style="font-size: 11px;">
                                    {{ $category->laws_count }} {{ Str::plural('law', $category->laws_count) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <button type="button" class="btn-action edit" title="Edit Category" onclick="openEditCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.laws.categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category? (Existing laws will retain the text, but the option will be removed from future selection)')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Delete Category">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 32px 16px;">
                                <i class="fa-regular fa-folder-open" style="font-size: 28px; margin-bottom: 8px; opacity: 0.5; display: block;"></i>
                                No Post Categories found. Click "+ Add Category" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Add Group -->
<div id="modal-add-group" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h3 style="margin: 0; font-size: 18px; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-layer-group" style="color: #3b82f6;"></i> Add Post 1992 Group
            </h3>
            <button type="button" onclick="closeAddGroupModal()" class="modal-close-btn">&times;</button>
        </div>
        <form action="{{ route('admin.laws.groups.store') }}" method="POST">
            @csrf
            <div class="custom-modal-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="add-group-name">Group Name</label>
                    <input type="text" id="add-group-name" name="name" class="form-control" placeholder="e.g. ACTS OF PARLIAMENT" required>
                    <small style="color: var(--text-secondary); display: block; margin-top: 6px;">
                        This will appear in the "Post 1992 Group" dropdown when adding or editing laws.
                    </small>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddGroupModal()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Save Group</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Group -->
<div id="modal-edit-group" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h3 style="margin: 0; font-size: 18px; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: #3b82f6;"></i> Edit Post 1992 Group
            </h3>
            <button type="button" onclick="closeEditGroupModal()" class="modal-close-btn">&times;</button>
        </div>
        <form id="form-edit-group" method="POST">
            @csrf
            @method('PUT')
            <div class="custom-modal-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="edit-group-name">Group Name</label>
                    <input type="text" id="edit-group-name" name="name" class="form-control" required>
                    <small style="color: var(--text-secondary); display: block; margin-top: 6px;">
                        Updating this will also automatically update all laws currently assigned to this group name.
                    </small>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditGroupModal()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Update Group</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Add Category -->
<div id="modal-add-category" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h3 style="margin: 0; font-size: 18px; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-folder-tree" style="color: #10b981;"></i> Add Post Category
            </h3>
            <button type="button" onclick="closeAddCategoryModal()" class="modal-close-btn">&times;</button>
        </div>
        <form action="{{ route('admin.laws.categories.store') }}" method="POST">
            @csrf
            <div class="custom-modal-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="add-category-name">Category Name</label>
                    <input type="text" id="add-category-name" name="name" class="form-control" placeholder="e.g. TAXATION" required>
                    <small style="color: var(--text-secondary); display: block; margin-top: 6px;">
                        This will appear in the "Post Category" dropdown when adding or editing laws.
                    </small>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddCategoryModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #10b981; border-color: #10b981;">
                    <i class="fa-solid fa-check"></i> Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Category -->
<div id="modal-edit-category" class="custom-modal-backdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <h3 style="margin: 0; font-size: 18px; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-pen-to-square" style="color: #10b981;"></i> Edit Post Category
            </h3>
            <button type="button" onclick="closeEditCategoryModal()" class="modal-close-btn">&times;</button>
        </div>
        <form id="form-edit-category" method="POST">
            @csrf
            @method('PUT')
            <div class="custom-modal-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="edit-category-name">Category Name</label>
                    <input type="text" id="edit-category-name" name="name" class="form-control" required>
                    <small style="color: var(--text-secondary); display: block; margin-top: 6px;">
                        Updating this will also automatically update all laws currently assigned to this category name.
                    </small>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditCategoryModal()">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #10b981; border-color: #10b981;">
                    <i class="fa-solid fa-check"></i> Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.custom-modal-backdrop {
    position: fixed;
    inset: 0;
    z-index: 1050;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.custom-modal-dialog {
    background: #111827;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    width: 480px;
    max-width: 100%;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    overflow: hidden;
    animation: modalFadeIn 0.2s ease-out;
}
@keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.96) translateY(-10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.custom-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 24px;
    border-bottom: 1px solid var(--border-color);
}
.modal-close-btn {
    background: transparent;
    border: none;
    color: var(--text-secondary);
    font-size: 22px;
    line-height: 1;
    cursor: pointer;
    transition: color 0.15s;
}
.modal-close-btn:hover {
    color: #fff;
}
.custom-modal-body {
    padding: 24px;
}
.custom-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid var(--border-color);
    background: rgba(255, 255, 255, 0.02);
}
</style>

@endsection

@section('scripts')
<script>
    // Group Modals
    function openAddGroupModal() {
        const modal = document.getElementById('modal-add-group');
        document.getElementById('add-group-name').value = '';
        modal.style.display = 'flex';
        setTimeout(() => document.getElementById('add-group-name').focus(), 50);
    }
    function closeAddGroupModal() {
        document.getElementById('modal-add-group').style.display = 'none';
    }

    function openEditGroupModal(id, name) {
        const modal = document.getElementById('modal-edit-group');
        const form = document.getElementById('form-edit-group');
        form.action = "{{ url('admin/laws/groups') }}/" + id + "/update";
        document.getElementById('edit-group-name').value = name;
        modal.style.display = 'flex';
        setTimeout(() => document.getElementById('edit-group-name').focus(), 50);
    }
    function closeEditGroupModal() {
        document.getElementById('modal-edit-group').style.display = 'none';
    }

    // Category Modals
    function openAddCategoryModal() {
        const modal = document.getElementById('modal-add-category');
        document.getElementById('add-category-name').value = '';
        modal.style.display = 'flex';
        setTimeout(() => document.getElementById('add-category-name').focus(), 50);
    }
    function closeAddCategoryModal() {
        document.getElementById('modal-add-category').style.display = 'none';
    }

    function openEditCategoryModal(id, name) {
        const modal = document.getElementById('modal-edit-category');
        const form = document.getElementById('form-edit-category');
        form.action = "{{ url('admin/laws/categories') }}/" + id + "/update";
        document.getElementById('edit-category-name').value = name;
        modal.style.display = 'flex';
        setTimeout(() => document.getElementById('edit-category-name').focus(), 50);
    }
    function closeEditCategoryModal() {
        document.getElementById('modal-edit-category').style.display = 'none';
    }

    // Close modal on escape key or clicking backdrop
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddGroupModal();
            closeEditGroupModal();
            closeAddCategoryModal();
            closeEditCategoryModal();
        }
    });

    ['modal-add-group', 'modal-edit-group', 'modal-add-category', 'modal-edit-category'].forEach(id => {
        const modal = document.getElementById(id);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection
