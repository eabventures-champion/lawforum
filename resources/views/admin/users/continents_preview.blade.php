@extends('layouts.admin')

@section('title', 'Continents & Country Preview')

@section('content')
<div class="page-header" style="flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 class="page-title">Continents & Country Preview</h1>
        <p class="page-subtitle">Grouped overview of users by continent and country for cleaning up inconsistent email records.</p>
    </div>
    <div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-action" style="padding: 8px 16px; gap: 6px; text-decoration: none; display: inline-flex; align-items: center; height: 38px;">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div class="stat-card" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; display: flex; align-items: center; gap: 20px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 20px;">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <div style="font-size: 14px; color: var(--text-secondary); font-weight: 500;">Total Users</div>
            <div style="font-size: 24px; font-weight: 700; color: #fff; margin-top: 4px;">{{ number_format($totalUsersCount) }}</div>
        </div>
    </div>
    
    <div class="stat-card" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; display: flex; align-items: center; gap: 20px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(239, 68, 68, 0.1); display: flex; align-items: center; justify-content: center; color: #ef4444; font-size: 20px;">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div>
            <div style="font-size: 14px; color: var(--text-secondary); font-weight: 500;">Flagged Emails</div>
            <div style="font-size: 24px; font-weight: 700; color: #ef4444; margin-top: 4px;">{{ number_format($totalFlaggedCount) }}</div>
        </div>
    </div>

    <div class="stat-card" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; display: flex; align-items: center; gap: 20px;">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 20px;">
            <i class="fa-solid fa-earth-africa"></i>
        </div>
        <div>
            <div style="font-size: 14px; color: var(--text-secondary); font-weight: 500;">Grouped Continents</div>
            <div style="font-size: 24px; font-weight: 700; color: #fff; margin-top: 4px;">{{ count($groupedData) }}</div>
        </div>
    </div>
</div>

<!-- Main Control Panel -->
<div class="card-table" style="padding: 24px; margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
        <!-- Continent Tabs -->
        <div class="tabs-nav" style="display: flex; gap: 8px; border-bottom: none; padding-bottom: 0; margin-bottom: 0; flex-wrap: wrap;">
            <button class="tab-btn active continent-tab" data-continent="all" style="padding: 8px 16px;">All Continents</button>
            @foreach(array_keys($groupedData) as $continent)
                <button class="tab-btn continent-tab" data-continent="{{ str_replace(' ', '-', $continent) }}" style="padding: 8px 16px;">{{ $continent }}</button>
            @endforeach
        </div>

        <!-- Filters Form -->
        <form action="{{ route('admin.users.continents-preview') }}" method="GET" style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
            <!-- Flagged Toggle -->
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-primary); font-size: 14px; font-weight: 500;">
                <input type="checkbox" name="flagged_only" value="1" onchange="this.form.submit()" {{ $showFlaggedOnly ? 'checked' : '' }} style="width: 16px; height: 16px; cursor: pointer;">
                Show Flagged Emails Only
            </label>

            <!-- Search input -->
            <div style="display: flex; gap: 8px;">
                <input type="text" name="search" class="form-control" placeholder="Search name or email..." value="{{ request('search') }}" style="width: 240px; padding: 6px 12px; height: 36px; font-size: 14px;">
                <button type="submit" class="btn btn-primary btn-action" style="padding: 6px 12px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.users.continents-preview', ['flagged_only' => $showFlaggedOnly ? '1' : '0']) }}" class="btn btn-secondary btn-action" style="padding: 6px 12px; height: 36px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Continents Content -->
    @forelse($groupedData as $continent => $countriesList)
        <div class="continent-section" id="section-{{ str_replace(' ', '-', $continent) }}" style="margin-bottom: 32px;">
            <h3 style="font-size: 16px; font-weight: 700; color: #3b82f6; border-bottom: 1px solid var(--border-color); padding-bottom: 8px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $continent }}</h3>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($countriesList as $countryName => $data)
                    <!-- Country Accordion -->
                    <div class="country-card" style="border: 1px solid var(--border-color); border-radius: 12px; background: rgba(255, 255, 255, 0.01); overflow: hidden;">
                        <!-- Country Header (Accordion Trigger) -->
                        <div class="country-header" onclick="toggleAccordion(this)" style="padding: 16px 24px; background: rgba(255,255,255,0.02); display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: background 0.2s;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fa-solid fa-chevron-right accordion-arrow" style="font-size: 12px; transition: transform 0.2s; color: var(--text-secondary);"></i>
                                <span style="font-size: 15px; font-weight: 600; color: #fff;">{{ $countryName }}</span>
                                <span style="font-size: 11px; font-weight: 500; background: rgba(59, 130, 246, 0.1); color: #3b82f6; padding: 2px 8px; border-radius: 10px;">
                                    {{ count($data['users']) }} matching
                                </span>
                                <span style="font-size: 11px; font-weight: 500; background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); padding: 2px 8px; border-radius: 10px;">
                                    {{ number_format($data['total_count']) }} total
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;" onclick="event.stopPropagation();">
                                <!-- Bulk Action for this country -->
                                <button type="button" class="btn btn-danger btn-action bulk-delete-country-btn" style="padding: 4px 12px; font-size: 11px; display: none;" onclick="deleteSelectedInCountry('{{ addslashes($countryName) }}')">
                                    Delete Selected
                                </button>
                                <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-secondary); margin-bottom: 0; cursor: pointer;">
                                    <input type="checkbox" class="select-all-country" onchange="toggleSelectAllCountry(this, '{{ addslashes($countryName) }}')" style="cursor: pointer;"> Select All
                                </label>
                            </div>
                        </div>

                        <!-- Country Body (Accordion Content) -->
                        <div class="country-body" style="display: none; border-top: 1px solid var(--border-color); background: rgba(0,0,0,0.15);">
                            <table class="custom-table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 40px; text-align: center;"></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Registered</th>
                                        <th style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['users'] as $user)
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($user->id !== auth()->id())
                                                    <input type="checkbox" class="user-checkbox-country" data-country="{{ $countryName }}" value="{{ $user->id }}" onchange="updateCountryBulkBtnState('{{ addslashes($countryName) }}')" style="width: 15px; height: 15px; cursor: pointer;">
                                                @else
                                                    <i class="fa-solid fa-user-shield" title="Current Admin" style="opacity: 0.5;"></i>
                                                @endif
                                            </td>
                                            <td>{{ $user->name }} {{ $user->lname }}</td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <span style="font-weight: 500;">{{ $user->email }}</span>
                                                    @if($user->is_invalid_email)
                                                        <span class="badge badge-danger" style="font-size: 10px; padding: 2px 6px; border-radius: 4px;">{{ $user->flag_reason }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $user->phone ?: 'N/A' }}</td>
                                            <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-action" style="padding: 4px 8px; font-size: 11px;">
                                                            <i class="fa-solid fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span style="font-size: 11px; color: var(--text-secondary); font-style: italic;">Protected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div style="text-align: center; color: var(--text-secondary); padding: 48px;">
            <i class="fa-solid fa-circle-check" style="font-size: 40px; color: #10b981; margin-bottom: 16px;"></i>
            <h3 style="font-size: 16px; color: #fff; font-weight: 600;">No flagged users found!</h3>
            <p style="font-size: 14px; margin-top: 4px;">All email addresses are syntactically valid and non-dummy.</p>
        </div>
    @endforelse
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
    // Toggle accordion collapse/expand
    function toggleAccordion(header) {
        const body = header.nextElementSibling;
        const arrow = header.querySelector('.accordion-arrow');
        
        if (body.style.display === 'none') {
            body.style.display = 'block';
            arrow.style.transform = 'rotate(90deg)';
            header.style.background = 'rgba(255,255,255,0.05)';
        } else {
            body.style.display = 'none';
            arrow.style.transform = 'rotate(0deg)';
            header.style.background = 'rgba(255,255,255,0.02)';
        }
    }

    // Toggle Select All checkboxes within a country
    function toggleSelectAllCountry(selectAllCheckbox, countryName) {
        const selector = `.user-checkbox-country[data-country="${CSS.escape(countryName)}"]`;
        const checkboxes = document.querySelectorAll(selector);
        checkboxes.forEach(cb => {
            cb.checked = selectAllCheckbox.checked;
        });
        updateCountryBulkBtnState(countryName);
    }

    // Update state of the country-specific bulk delete button
    function updateCountryBulkBtnState(countryName) {
        const checkboxes = document.querySelectorAll(`.user-checkbox-country[data-country="${CSS.escape(countryName)}"]`);
        const checkedCount = document.querySelectorAll(`.user-checkbox-country[data-country="${CSS.escape(countryName)}"]:checked`).length;
        
        // Find header containing the select all label
        const header = Array.from(document.querySelectorAll('.country-header')).find(h => {
            return h.querySelector('span').textContent.trim() === countryName;
        });

        if (header) {
            const bulkBtn = header.querySelector('.bulk-delete-country-btn');
            const selectAllCheckbox = header.querySelector('.select-all-country');
            
            if (bulkBtn) {
                if (checkedCount > 0) {
                    bulkBtn.style.display = 'inline-flex';
                    bulkBtn.textContent = `Delete Selected (${checkedCount})`;
                } else {
                    bulkBtn.style.display = 'none';
                }
            }
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = checkedCount === checkboxes.length;
            }
        }
    }

    // Delete selected users in a country
    function deleteSelectedInCountry(countryName) {
        const checkedCheckboxes = document.querySelectorAll(`.user-checkbox-country[data-country="${CSS.escape(countryName)}"]:checked`);
        const ids = Array.from(checkedCheckboxes).map(cb => cb.value);
        if (ids.length === 0) return;

        if (confirm(`Are you sure you want to delete the ${ids.length} selected user(s) in ${countryName}?`)) {
            document.getElementById('bulk-delete-ids').value = JSON.stringify(ids);
            document.getElementById('bulk-delete-form').submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.continent-tab');
        const sections = document.querySelectorAll('.continent-section');

        // Continent Tab Click Handler
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const continent = tab.getAttribute('data-continent');
                
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                if (continent === 'all') {
                    sections.forEach(s => s.style.display = 'block');
                } else {
                    sections.forEach(s => {
                        if (s.id === `section-${continent}`) {
                            s.style.display = 'block';
                        } else {
                            s.style.display = 'none';
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
