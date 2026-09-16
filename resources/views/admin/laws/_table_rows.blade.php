@forelse($laws as $law)
    <tr>
        <td style="font-weight: 700; color: #fff; vertical-align: middle;">{{ $law->year }}</td>
        <td style="vertical-align: middle;">
            <div style="font-weight: 600; color: #fff; font-size: 14px; margin-bottom: 6px; line-height: 1.4;">
                {{ $law->title }}
            </div>
            <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                @if($type === 'post1992')
                    @if(!empty($law->post_group))
                        <span class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;">{{ $law->post_group }}</span>
                    @endif
                    @if(!empty($law->post_category))
                        <span class="badge badge-secondary" style="background: rgba(255,255,255,0.06); color: var(--text-secondary); font-size: 11px; padding: 2px 8px;">{{ $law->post_category }}</span>
                    @endif
                @elseif($type === 'pre1992' && !empty($law->pre_1992_group))
                    <span class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;">{{ $law->pre_1992_group }}</span>
                @elseif($type === 'constitutional' && !empty($law->constitutional_group))
                    <span class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;">{{ $law->constitutional_group }}</span>
                @elseif($type === 'executive' && !empty($law->executive_group))
                    <span class="badge badge-accent" style="font-size: 11px; padding: 2px 8px;">{{ $law->executive_group }}</span>
                @endif
            </div>
        </td>
        @if($type === 'post1992')
            <td style="vertical-align: middle;">
                @php
                    $pdfVal = trim($law->upload_pdf ?? '');
                    $hasPdf = !empty($pdfVal) && $pdfVal !== '[]' && $pdfVal !== 'null' && $pdfVal !== '[""]';
                    if ($hasPdf && Str::startsWith($pdfVal, '[')) {
                        $decoded = json_decode($pdfVal, true);
                        $hasPdf = !empty($decoded) && !empty($decoded[0]['download_link'] ?? $decoded[0]);
                        $pdfPath = $decoded[0]['download_link'] ?? ($decoded[0] ?? null);
                    } else {
                        $pdfPath = $pdfVal;
                    }
                @endphp
                @if($hasPdf && $pdfPath)
                    <a href="{{ url('storage/' . ltrim($pdfPath, '/')) }}" target="_blank" style="color: #60a5fa; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; font-size: 13px;">
                        <i class="fa-solid fa-file-pdf"></i> View PDF
                    </a>
                @else
                    <span style="color: var(--text-secondary); font-size: 13px;">No PDF</span>
                @endif
            </td>
        @endif
        <td style="vertical-align: middle;">
            <div style="display: flex; gap: 8px; align-items: center;">
                <button type="button" class="btn btn-secondary btn-action" title="Preview Act & Structure" onclick="openActPreviewModal({{ $law->id }}, '{{ $type }}')" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #38bdf8; border-color: rgba(56, 189, 248, 0.35);">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <a href="{{ route('admin.laws.sections', ['id' => $law->id, 'type' => $type]) }}" class="btn btn-secondary btn-action" title="Manage Parts, Sections & Schedules" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #60a5fa; border-color: rgba(59, 130, 246, 0.3);">
                    <i class="fa-solid fa-layer-group"></i>
                </a>
                <a href="{{ route('admin.laws.edit', ['id' => $law->id, 'type' => $type]) }}" class="btn btn-secondary btn-action" title="Edit Law" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #cbd5e1;">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <form action="{{ route('admin.laws.destroy', ['id' => $law->id, 'type' => $type]) }}" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('Are you sure you want to delete this law?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-action" title="Delete Law" style="width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="{{ $type === 'post1992' ? 4 : 3 }}" style="text-align: center; color: var(--text-secondary); padding: 32px;">
            <i class="fa-solid fa-folder-open" style="font-size: 24px; opacity: 0.4; display: block; margin-bottom: 8px;"></i>
            No laws found matching your search.
        </td>
    </tr>
@endforelse