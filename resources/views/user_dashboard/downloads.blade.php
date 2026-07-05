@extends('layouts.user')

@section('title', 'My Downloads')

@section('styles')
<style>
    .sub-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 28px;
    }
    .sub-tab-btn {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13.5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-smooth);
    }
    .sub-tab-btn:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }
    .sub-tab-btn.active {
        background: var(--accent-color);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 12px var(--accent-glow);
    }
</style>
@endsection

@section('content')
<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 class="card-title">My Downloads</h1>
            <p class="card-subtitle" style="margin-bottom: 0;">Access and manage your downloaded sections and full Acts.</p>
        </div>
    </div>

    <!-- Toggle sub-tabs -->
    <div class="sub-tabs">
        <button class="sub-tab-btn active" id="btn-sections" onclick="switchTab('sections')">
            <i class="fa-solid fa-file-lines"></i>
            <span>Downloaded Sections</span>
            <span style="font-size: 11px; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px;">{{ $user_total_section_downloads }}</span>
        </button>
        <button class="sub-tab-btn" id="btn-acts" onclick="switchTab('acts')">
            <i class="fa-solid fa-file-pdf"></i>
            <span>Full Acts</span>
            <span style="font-size: 11px; background: rgba(255,255,255,0.1); padding: 2px 6px; border-radius: 4px;">{{ $user_total_full_downloads }}</span>
        </button>
    </div>

    @if(session('success'))
        <div class="alert-banner alert-banner-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Downloaded Sections Table -->
    <div class="table-responsive" id="table-sections">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Section Document</th>
                    <th>Date Added</th>
                    <th style="width: 260px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order_by_sections as $order_by_section)
                    <tr>
                        <td>
                            @include('all_user_downloads.section_act_link')
                        </td>
                        <td style="color: var(--text-secondary); font-size: 13.5px;">
                            {{ date("F j, Y", strtotime($order_by_section->created_at)) }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                @include('all_user_downloads.section_act_download_link_icon')    
                                @include('all_user_downloads.section_act_link_icon')
                                <form action="/downloads/{{ $order_by_section->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this download?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-danger" style="padding: 6px 12px; font-size: 12.5px;">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-secondary); padding: 40px 0;">
                            <i class="fa-solid fa-file-lines" style="font-size: 28px; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No section downloads found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Full Acts Table -->
    <div class="table-responsive" id="table-acts" style="display: none;">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Act Document</th>
                    <th>Date Added</th>
                    <th style="width: 260px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order_by_acts as $order_by_act)
                    <tr>
                        <td>
                            @include('all_user_downloads.full_act_link')
                        </td>
                        <td style="color: var(--text-secondary); font-size: 13.5px;">
                            {{ date("F j, Y", strtotime($order_by_act->created_at)) }}
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                @include('all_user_downloads.full_act_download_link_icon')
                                @include('all_user_downloads.full_act_link_icon')
                                <form action="/downloads/{{ $order_by_act->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Act from downloads?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-danger" style="padding: 6px 12px; font-size: 12.5px;">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-secondary); padding: 40px 0;">
                            <i class="fa-solid fa-file-pdf" style="font-size: 28px; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No full Acts downloaded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchTab(type) {
        const sectionsBtn = document.getElementById('btn-sections');
        const actsBtn = document.getElementById('btn-acts');
        const sectionsTable = document.getElementById('table-sections');
        const actsTable = document.getElementById('table-acts');

        if (type === 'sections') {
            sectionsBtn.classList.add('active');
            actsBtn.classList.remove('active');
            sectionsTable.style.display = 'block';
            actsTable.style.display = 'none';
        } else {
            actsBtn.classList.add('active');
            sectionsBtn.classList.remove('active');
            actsTable.style.display = 'block';
            sectionsTable.style.display = 'none';
        }
    }
</script>
@endsection