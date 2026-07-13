@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Users Management</h1>
        <p class="page-subtitle">Manage system users, privileges, and subscription statuses.</p>
    </div>
</div>

<div class="card-table">
    <div class="table-header" style="flex-wrap: wrap; gap: 16px; align-items: center; border-bottom: none !important;">
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <h2 class="table-title" style="margin-bottom: 0;">System Users</h2>

            <!-- Continents Preview Button -->
            <a href="{{ route('admin.users.continents-preview') }}" class="btn btn-primary btn-action" style="padding: 8px 16px; gap: 6px; text-decoration: none; display: inline-flex; align-items: center; height: 38px; font-weight: 500; font-size: 14px;">
                <i class="fa-solid fa-earth-americas"></i> Continents Preview
            </a>

            <!-- Export CSV Button -->
            <button type="button" id="export-csv-btn" class="btn btn-secondary btn-action" style="padding: 8px 16px; gap: 6px; display: inline-flex; align-items: center; height: 38px; font-weight: 500; font-size: 14px; background-color: rgba(255,255,255,0.05); color: #fff; border: 1px solid var(--border-color); cursor: pointer;" onclick="openExportModal()">
                <i class="fa-solid fa-file-csv" style="color: #10b981; font-size: 16px;"></i> Export CSV
            </button>
            
            <!-- Bulk Action Button -->
            <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-action" style="display: none; padding: 8px 16px; gap: 6px;" onclick="submitBulkDelete()">
                <i class="fa-solid fa-trash-can"></i> Delete Selected (<span id="selected-count">0</span>)
            </button>
        </div>
        
        <!-- Search and Filter Form -->
        <form id="filter-form" action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
            @if(request('filter'))
                <input type="hidden" name="filter" id="active-filter-param" value="{{ request('filter') }}">
            @endif

            <!-- Country Dropdown -->
            <select name="country" id="country-filter" class="form-control" style="width: 220px; padding: 8px 16px; height: 38px; border-radius: 8px; background-color: #181f29; color: #f3f4f6; border: 1px solid var(--border-color); cursor: pointer;">
                <option value="" style="background-color: #181f29; color: #f3f4f6;">All Countries</option>
                @foreach($countries as $continent => $list)
                    <optgroup label="{{ $continent }}" style="background-color: #181f29; color: #3b82f6; font-weight: 600;">
                        @foreach($list as $name => $count)
                            <option value="{{ $name }}" {{ request('country') === $name ? 'selected' : '' }} style="background-color: #181f29; color: #f3f4f6;">{{ $name }} ({{ $count }})</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            <input type="text" name="search" id="search-input" class="form-control" placeholder="Search by name, email or contact..." value="{{ request('search') }}" style="width: 260px; padding: 8px 16px; height: 38px;">
            <button type="submit" class="btn btn-primary btn-action" style="padding: 8px 16px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            @if(request('search') || request('country'))
                <a href="{{ route('admin.users.index', request('filter') ? ['filter' => request('filter')] : []) }}" class="btn btn-secondary btn-action" style="padding: 8px 16px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; height: 38px;">Clear</a>
            @endif
        </form>
    </div>

    <!-- Filter Tabs -->
    <div class="tabs-nav" style="display: flex; gap: 8px; margin: 0 24px 20px 24px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; flex-wrap: wrap;">
        <a href="{{ route('admin.users.index', array_merge(request()->except(['page']), ['filter' => ''])) }}" class="tab-btn filter-tab {{ !request('filter') ? 'active' : '' }}" data-filter="" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            All Users <span id="tab-count-all" style="font-size: 11px; opacity: 0.7; background: rgba(255,255,255,0.08); padding: 2px 6px; border-radius: 10px; font-weight: 500;">{{ $totalAll }}</span>
        </a>
        <a href="{{ route('admin.users.index', array_merge(request()->except(['page']), ['filter' => 'with_phone'])) }}" class="tab-btn filter-tab {{ request('filter') === 'with_phone' ? 'active' : '' }}" data-filter="with_phone" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            With Phone Number <span id="tab-count-phone" style="font-size: 11px; opacity: 0.7; background: rgba(255,255,255,0.08); padding: 2px 6px; border-radius: 10px; font-weight: 500;">{{ $totalWithPhone }}</span>
        </a>
        <a href="{{ route('admin.users.index', array_merge(request()->except(['page']), ['filter' => 'email_only'])) }}" class="tab-btn filter-tab {{ request('filter') === 'email_only' ? 'active' : '' }}" data-filter="email_only" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            Email Only <span id="tab-count-email" style="font-size: 11px; opacity: 0.7; background: rgba(255,255,255,0.08); padding: 2px 6px; border-radius: 10px; font-weight: 500;">{{ $totalEmailOnly }}</span>
        </a>
        <a href="{{ route('admin.users.index', array_merge(request()->except(['page']), ['filter' => 'Ghana'])) }}" class="tab-btn filter-tab {{ request('filter') === 'Ghana' ? 'active' : '' }}" data-filter="Ghana" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            Ghana <span id="tab-count-ghana" style="font-size: 11px; opacity: 0.7; background: rgba(255,255,255,0.08); padding: 2px 6px; border-radius: 10px; font-weight: 500;">{{ $totalGhana }}</span>
        </a>
        @foreach($continentCounts as $continent => $count)
            <a href="{{ route('admin.users.index', array_merge(request()->except(['page']), ['filter' => $continent])) }}" class="tab-btn filter-tab {{ request('filter') === $continent ? 'active' : '' }}" data-filter="{{ $continent }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                {{ $continent }} <span id="tab-count-{{ strtolower(str_replace(' ', '-', $continent)) }}" style="font-size: 11px; opacity: 0.7; background: rgba(255,255,255,0.08); padding: 2px 6px; border-radius: 10px; font-weight: 500;">{{ $count }}</span>
            </a>
        @endforeach
    </div>

    <!-- Table Data Wrapper -->
    <div id="table-data-wrapper">
        @include('admin.users.table_data')
    </div>
</div>

<!-- Bulk Delete Form -->
<form id="bulk-delete-form" action="{{ route('admin.users.bulk-destroy') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="ids" id="bulk-delete-ids">
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filter-form');
        const countryFilter = document.getElementById('country-filter');
        const searchInput = document.getElementById('search-input');
        const tableWrapper = document.getElementById('table-data-wrapper');
        const tabs = document.querySelectorAll('.filter-tab');
        
        // Dynamic counts spans
        const countAll = document.getElementById('tab-count-all');
        const countPhone = document.getElementById('tab-count-phone');
        const countEmail = document.getElementById('tab-count-email');

        // Checkbox variables (delegated)
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const selectedCountSpan = document.getElementById('selected-count');

        function updateBulkDeleteBtnState() {
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            if (checkedCount > 0) {
                bulkDeleteBtn.style.display = 'inline-flex';
                selectedCountSpan.textContent = checkedCount;
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }

        // Delegate checkbox actions since table content updates dynamically
        tableWrapper.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'select-all-users') {
                const checkboxes = document.querySelectorAll('.user-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = e.target.checked;
                });
                updateBulkDeleteBtnState();
            } else if (e.target && e.target.classList.contains('user-checkbox')) {
                const selectAll = document.getElementById('select-all-users');
                const checkboxes = document.querySelectorAll('.user-checkbox');
                if (!e.target.checked) {
                    if (selectAll) selectAll.checked = false;
                } else {
                    const allChecked = document.querySelectorAll('.user-checkbox:checked').length === checkboxes.length;
                    if (selectAll) selectAll.checked = allChecked;
                }
                updateBulkDeleteBtnState();
            }
        });

        // Function to fetch and update users list dynamically
        let currentFilter = "{{ request('filter', '') }}";
        let activeAjax = null;

        function fetchUsers(url = null) {
            // Hide bulk delete button on reload
            bulkDeleteBtn.style.display = 'none';

            // Build request URL
            if (!url) {
                const params = new URLSearchParams(new FormData(filterForm));
                if (currentFilter) {
                    params.set('filter', currentFilter);
                } else {
                    params.delete('filter');
                }
                url = "{{ route('admin.users.index') }}?" + params.toString();
            }

            // Show simple loading state (opacity fade)
            tableWrapper.style.opacity = '0.5';
            tableWrapper.style.transition = 'opacity 0.15s ease-in-out';

            if (activeAjax) {
                activeAjax.abort();
            }

            activeAjax = new AbortController();
            const signal = activeAjax.signal;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: signal
            })
            .then(res => res.json())
            .then(data => {
                tableWrapper.innerHTML = data.html;
                tableWrapper.style.opacity = '1';

                // Update tab counts
                if (countAll) countAll.textContent = data.totalAll;
                if (countPhone) countPhone.textContent = data.totalWithPhone;
                if (countEmail) countEmail.textContent = data.totalEmailOnly;
                
                const countGhana = document.getElementById('tab-count-ghana');
                if (countGhana) countGhana.textContent = data.totalGhana;

                // Update continent tab counts dynamically
                if (data.continentCounts) {
                    Object.entries(data.continentCounts).forEach(([continent, count]) => {
                        const id = `tab-count-${continent.toLowerCase().replace(/\s+/g, '-')}`;
                        const badge = document.getElementById(id);
                        if (badge) {
                            badge.textContent = count;
                        }
                    });
                }

                // Rebuild country dropdown options dynamically based on search context
                if (countryFilter) {
                    const currentValue = countryFilter.value;
                    countryFilter.innerHTML = '<option value="" style="background-color: #181f29; color: #f3f4f6;">All Countries</option>';
                    Object.entries(data.countries).forEach(([continent, list]) => {
                        const optgroup = document.createElement('optgroup');
                        optgroup.label = continent;
                        optgroup.style.backgroundColor = '#181f29';
                        optgroup.style.color = '#3b82f6';
                        optgroup.style.fontWeight = '600';

                        Object.entries(list).forEach(([name, count]) => {
                            const option = document.createElement('option');
                            option.value = name;
                            option.textContent = `${name} (${count})`;
                            option.style.backgroundColor = '#181f29';
                            option.style.color = '#f3f4f6';
                            if (name === currentValue) {
                                option.selected = true;
                            }
                            optgroup.appendChild(option);
                        });
                        countryFilter.appendChild(optgroup);
                    });
                }

                // Update browser address bar (optional but highly premium)
                window.history.pushState({}, '', url);
            })
            .catch(err => {
                if (err.name !== 'AbortError') {
                    tableWrapper.style.opacity = '1';
                    console.error('Error fetching filtered users:', err);
                }
            });
        }

        // Country selection change handler
        if (countryFilter) {
            countryFilter.addEventListener('change', function() {
                fetchUsers();
            });
        }

        // Search input keyup debounce handler
        let debounceTimer;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchUsers();
                }, 300);
            });
        }

        // Prevent standard form submission to keep search inputs active without page reload
        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                fetchUsers();
            });
        }

        // Tab click handler
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Toggle active class
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Update filter value
                currentFilter = tab.getAttribute('data-filter');
                
                // Update hidden parameter if it exists
                const hiddenFilter = document.getElementById('active-filter-param');
                if (hiddenFilter) {
                    hiddenFilter.value = currentFilter;
                }

                fetchUsers();
            });
        });

        // Pagination link click handler (delegated to container)
        tableWrapper.addEventListener('click', function(e) {
            const link = e.target.closest('.pagination-wrapper a');
            if (link) {
                e.preventDefault();
                fetchUsers(link.getAttribute('href'));
            }
        });
    });

    function submitBulkDelete() {
        const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
        const ids = Array.from(checkedCheckboxes).map(cb => cb.value);
        if (ids.length === 0) return;

        if (confirm(`Are you sure you want to delete the ${ids.length} selected user(s)?`)) {
            document.getElementById('bulk-delete-ids').value = JSON.stringify(ids);
            document.getElementById('bulk-delete-form').submit();
        }
    }

    function openExportModal() {
        document.getElementById('export-modal').style.display = 'flex';
    }

    function closeExportModal() {
        document.getElementById('export-modal').style.display = 'none';
    }
</script>

<!-- Export Modal -->
<div id="export-modal" style="display: none; position: fixed; inset: 0; z-index: 1000; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(8px); align-items: center; justify-content: center;">
    <div style="background: #111827; border: 1px solid var(--border-color); border-radius: 16px; width: 440px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-file-csv" style="color: #10b981;"></i> Export Users to CSV
            </h3>
            <button type="button" onclick="closeExportModal()" style="background: transparent; border: none; color: var(--text-secondary); cursor: pointer; font-size: 18px; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('admin.users.export') }}" method="GET" onsubmit="closeExportModal()">
            <!-- Segment Option -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 11px; font-weight: 600; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">1. Select Data Segment</label>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 14px; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="segment" value="all" checked style="cursor: pointer; width: 16px; height: 16px;"> All Users
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 14px; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="segment" value="with_phone" style="cursor: pointer; width: 16px; height: 16px;"> With Phone Number only
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 14px; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="segment" value="email_only" style="cursor: pointer; width: 16px; height: 16px;"> Email Only
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 14px; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="segment" value="ghana_all" style="cursor: pointer; width: 16px; height: 16px;"> Ghana Only (All)
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 14px; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="segment" value="ghana_phone" style="cursor: pointer; width: 16px; height: 16px;"> Ghana Only (With Phone Number)
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 14px; cursor: pointer; margin-bottom: 0;">
                        <input type="radio" name="segment" value="ghana_email" style="cursor: pointer; width: 16px; height: 16px;"> Ghana Only (Email Only)
                    </label>
                </div>
            </div>

            <!-- Columns Option -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 11px; font-weight: 600; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">2. Columns to Include</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 13px; cursor: pointer; margin-bottom: 0;">
                        <input type="checkbox" name="columns[]" value="name" checked style="cursor: pointer; width: 15px; height: 15px;"> Full Name
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 13px; cursor: pointer; margin-bottom: 0;">
                        <input type="checkbox" name="columns[]" value="email" checked style="cursor: pointer; width: 15px; height: 15px;"> Email
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 13px; cursor: pointer; margin-bottom: 0;">
                        <input type="checkbox" name="columns[]" value="phone" checked style="cursor: pointer; width: 15px; height: 15px;"> Phone
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 13px; cursor: pointer; margin-bottom: 0;">
                        <input type="checkbox" name="columns[]" value="country" checked style="cursor: pointer; width: 15px; height: 15px;"> Country
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 13px; cursor: pointer; margin-bottom: 0;">
                        <input type="checkbox" name="columns[]" value="subscription_status" checked style="cursor: pointer; width: 15px; height: 15px;"> Subs Status
                    </label>
                    <label style="display: inline-flex; align-items: center; gap: 8px; color: #fff; font-size: 13px; cursor: pointer; margin-bottom: 0;">
                        <input type="checkbox" name="columns[]" value="created_at" checked style="cursor: pointer; width: 15px; height: 15px;"> Reg Date
                    </label>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="btn btn-secondary btn-action" onclick="closeExportModal()" style="height: 38px; padding: 0 16px;">Cancel</button>
                <button type="submit" class="btn btn-action" style="height: 38px; padding: 0 16px; background-color: #10b981; color: #fff; border: none; font-weight: 500; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                    <i class="fa-solid fa-download"></i> Download CSV
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
