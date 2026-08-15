<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title ?? 'Personal Study Notes - Legals Forum' }}</title>
    <style>
        @page {
            margin: 35px 40px 40px 40px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 13px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }
        .brand-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0 0 4px 0;
        }
        .meta-line {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        .note-card {
            border: 1px solid #e2e8f0;
            border-left: 5px solid #2563eb;
            background-color: #f8fafc;
            border-radius: 6px;
            padding: 16px 18px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .note-card.yellow { border-left-color: #f59e0b; }
        .note-card.blue { border-left-color: #3b82f6; }
        .note-card.green { border-left-color: #10b981; }
        .note-card.pink { border-left-color: #ec4899; }
        .note-card.purple { border-left-color: #8b5cf6; }

        .doc-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            margin: 0 0 6px 0;
        }
        .badge {
            display: inline-block;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            background: #e0e7ff;
            color: #3730a3;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .badge.constitution { background: #fef3c7; color: #92400e; }
        .badge.case_law { background: #f3e8ff; color: #6b21a8; }
        .badge.pre_1992 { background: #d1fae5; color: #065f46; }
        .badge.post_1992 { background: #dbeafe; color: #1e40af; }

        .quote-box {
            background-color: #ffffff;
            border-left: 3px solid #f59e0b;
            border: 1px solid #f1f5f9;
            border-left-width: 3px;
            border-left-color: #cbd5e1;
            padding: 10px 14px;
            margin: 8px 0 12px 0;
            font-style: italic;
            color: #475569;
            font-size: 12px;
            border-radius: 4px;
        }
        .note-content {
            font-size: 13px;
            color: #0f172a;
            margin: 8px 0;
            white-space: pre-wrap;
            line-height: 1.7;
        }
        .section-ref {
            font-size: 11px;
            color: #64748b;
            margin-top: 6px;
        }
        .footer-line {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
        }
        .doc-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="brand-title">Legals Forum &mdash; Personal Study Notes</h1>
        <p class="meta-line">
            <strong>User:</strong> {{ $user->name ?? 'User' }} &bull; 
            <strong>Export Date:</strong> {{ date('F j, Y, g:i A') }} &bull; 
            <strong>Total Notes:</strong> {{ count($notes) }}
        </p>
    </div>

    @foreach($notes as $note)
        @php
            $typeClass = $note->document_type;
            if (in_array($typeClass, ['judgment', 'judgement'])) $typeClass = 'case_law';
            $typeLabel = ucwords(str_replace('_', ' ', $typeClass));
            $colorClass = $note->note_color ?? 'blue';
        @endphp
        <div class="note-card {{ $colorClass }}">
            <span class="badge {{ $typeClass }}">{{ $typeLabel }}</span>
            <h2 class="doc-title">{{ html_entity_decode($note->document_title, ENT_QUOTES, 'UTF-8') }}</h2>

            @if($note->highlighted_text)
                <div class="quote-box">
                    &ldquo;{{ html_entity_decode($note->highlighted_text, ENT_QUOTES, 'UTF-8') }}&rdquo;
                </div>
            @endif

            <div class="note-content">
                <strong>Note:</strong><br>
                {{ $note->note_content }}
            </div>

            @if($note->article_section)
                <div class="section-ref">
                    <strong>Reference:</strong> {{ html_entity_decode($note->article_section, ENT_QUOTES, 'UTF-8') }}
                </div>
            @endif

            <div class="footer-line">
                <span>Created: {{ $note->created_at->format('M j, Y \a\t g:i A') }}</span>
                @if($note->page_url)
                    &bull; <span>URL: {{ url($note->page_url) }}</span>
                @endif
            </div>
        </div>
    @endforeach

    <div class="doc-footer">
        Generated by Legals Forum &bull; All Rights Reserved &copy; {{ date('Y') }}
    </div>
</body>
</html>
