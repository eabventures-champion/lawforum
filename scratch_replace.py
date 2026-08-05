import os
import re

dirs = [
    r"c:\laragon\www\Lawsforum\resources\views\post_1992_legislation",
    r"c:\laragon\www\Lawsforum\resources\views\layouts",
    r"c:\laragon\www\Lawsforum\resources\views\page"
]

files_to_check = []
for d in dirs:
    for root, _, files in os.walk(d):
        for f in files:
            if f.endswith('.blade.php'):
                files_to_check.append(os.path.join(root, f))

desk_pattern_alt = re.compile(r'^[ \t]*@foreach\(\$headerMenus.*?as.*?\$[a-zA-Z]+\).*?@if\(\$[a-zA-Z]+->is_dropdown\).*?<div class="nav-link-dropdown">.*?@endforeach\n?', re.MULTILINE | re.DOTALL)
mob_pattern = re.compile(r'^[ \t]*@foreach\(\$headerMenus.*?as.*?\$[a-zA-Z]+\)[ \t]*\n[ \t]*@if\(\$[a-zA-Z]+->is_dropdown\)[ \t]*\n[ \t]*@php.*?@endphp.*?@else.*?@endif[ \t]*\n[ \t]*@endforeach\n?', re.MULTILINE | re.DOTALL)

updated_files = []

for filepath in files_to_check:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    orig_content = content

    content = desk_pattern_alt.sub(lambda m: (' ' * (len(m.group(0)) - len(m.group(0).lstrip()))) + "@include('partials._nav_desktop_menu')\n", content)
    content = mob_pattern.sub(lambda m: (' ' * (len(m.group(0)) - len(m.group(0).lstrip()))) + "@include('partials._nav_mobile_menu')\n", content)
    
    if content != orig_content:
        head_match = re.search(r'</head>', content)
        if head_match:
            head_content = content[:head_match.start()]
            last_style_idx = head_content.rfind('</style>')
            if last_style_idx != -1:
                style_line_start = head_content.rfind('\n', 0, last_style_idx) + 1
                indent = head_content[style_line_start:last_style_idx]
                new_head = head_content[:last_style_idx] + '</style>\n' + indent + "@include('partials._nav_subdropdown_styles')"
                content = new_head + content[head_match.start():]
        
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        updated_files.append(filepath)

print("Updated:")
for f in updated_files:
    print(f)
