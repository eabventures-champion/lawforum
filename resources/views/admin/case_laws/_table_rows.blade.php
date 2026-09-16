@forelse($cases as $case)
    <tr>
        <td style="font-weight: 700; color: #fff; vertical-align: middle;">
            {{ $case->year ?: 'N/A' }}
        </td>
        <td style="vertical-align: middle;">
            <div style="font-weight: 600; color: #fff; font-size: 14px; margin-bottom: 6px; line-height: 1.4;">
                {{ $case->case_title }}
            </div>
            <div style="display: flex; gap: 6px; align-items: center; flex-wrap: wrap;">
                @if(!empty($case->date))
                    <span class="badge" style="background: rgba(249, 115, 22, 0.15); color: #fb923c; border: 1px solid rgba(249, 115, 22, 0.35); font-size: 11px; padding: 2px 8px; font-weight: 600;">
                        <i class="fa-regular fa-calendar-days" style="font-size: 10px; margin-right: 3px;"></i> {{ $case->date }}
                    </span>
                @endif
                @if(!empty($case->reference_number))
                    <span class="badge" style="background: rgba(255,255,255,0.06); color: #94a3b8; font-size: 11px; padding: 2px 8px;">
                        <i class="fa-solid fa-hashtag" style="font-size: 10px;"></i> {{ $case->reference_number }}
                    </span>
                @endif
                <span class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;">
                    {{ str_replace('-', ' ', $case->gh_law_judgment_group_name ?: 'Court') }}
                </span>
                @if(!empty($case->gh_law_judgment_category_name))
                    <span class="badge badge-secondary" style="background: rgba(59,130,246,0.15); color: #60a5fa; font-size: 11px; padding: 2px 8px;">
                        {{ $case->gh_law_judgment_category_name }}
                    </span>
                @endif
            </div>
        </td>
        <td style="vertical-align: middle;">
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" class="btn btn-secondary btn-action" title="Preview Case Law" onclick="openCasePreviewModal({{ $case->id }})" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #38bdf8; border-color: rgba(56, 189, 248, 0.35);">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <a href="{{ url('/judgement/plain/simple-preview/' . $case->id) }}" target="_blank" class="btn btn-secondary btn-action" title="Open Frontend Reader" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #60a5fa; border-color: rgba(59, 130, 246, 0.3);">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
                <a href="{{ route('admin.case-laws.edit', $case->id) }}" class="btn btn-secondary btn-action" title="Edit Case Law" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #cbd5e1;">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.case-laws.destroy', $case->id) }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('Are you sure you want to delete this case law?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-action" title="Delete Case Law" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="3" style="text-align: center; color: var(--text-secondary); padding: 32px;">
            <i class="fa-solid fa-folder-open" style="font-size: 24px; opacity: 0.4; display: block; margin-bottom: 8px;"></i>
            No case laws found matching your search.
        </td>
    </tr>
@endforelse
