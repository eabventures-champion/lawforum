@forelse($constitutions as $c)
    <tr>
        <td style="font-weight: 700; color: #fff; vertical-align: middle;">
            <span class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;">{{ $c->continent }}</span>
        </td>
        <td style="vertical-align: middle; font-weight: 600; color: #60a5fa;">
            {{ $c->country }}
        </td>
        <td style="vertical-align: middle;">
            <div style="font-weight: 600; color: #fff; font-size: 14px; line-height: 1.4;">
                {{ $c->title }}
            </div>
        </td>
        <td style="vertical-align: middle; color: var(--text-secondary); font-weight: 500;">
            {{ $c->year ?: 'N/A' }}
        </td>
        <td style="vertical-align: middle;">
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" class="btn btn-secondary btn-action" title="Preview Constitution" onclick="openForeignPreviewModal({{ $c->id }})" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #38bdf8; border-color: rgba(56, 189, 248, 0.35);">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <a href="{{ url('/constitution/continent/' . rawurlencode($c->continent) . '/' . rawurlencode($c->country) . '/' . $c->id) }}" target="_blank" class="btn btn-secondary btn-action" title="Open Frontend Reader" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #60a5fa; border-color: rgba(59, 130, 246, 0.3);">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
                <a href="{{ route('admin.constitutions.foreign.edit', $c->id) }}" class="btn btn-secondary btn-action" title="Edit Constitution" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #cbd5e1;">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.constitutions.foreign.destroy', $c->id) }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('Are you sure you want to delete this constitution?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-action" title="Delete Constitution" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 32px;">
            <i class="fa-solid fa-folder-open" style="font-size: 24px; opacity: 0.4; display: block; margin-bottom: 8px;"></i>
            No foreign constitutions found.
        </td>
    </tr>
@endforelse
