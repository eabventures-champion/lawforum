import os
import re
import glob

directory = r'c:\laragon\www\Lawsforum\resources\views\pre_1992_legislation'
files = glob.glob(os.path.join(directory, 'new_displayed_*.blade.php'))

target_nav_pattern = re.compile(
    r'( +)<a class="vertical-nav-link\s*(active|)"\s*data-group="5".*?>.*?NLCD</a>\s*'
    r'<a class="vertical-nav-link\s*(active|)"\s*data-group="6".*?>.*?NRCD</a>\s*'
    r'<a class="vertical-nav-link\s*(active|)"\s*data-group="7".*?>.*?SMCD</a>\s*'
    r'<a class="vertical-nav-link\s*(active|)"\s*data-group="8".*?>.*?AFRCD</a>',
    re.DOTALL
)

css_pattern = re.compile(
    r'(\s*\.vertical-nav-link\.active\s*\{[\s\S]*?\})'
)

new_css = '''
        .sidebar-decree-group {
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            margin: 4px 0;
            padding: 4px 0;
        }
        .sidebar-group-header {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            padding: 8px 20px 4px;
            display: flex;
            align-items: center;
        }
        .decree-sub-link {
            padding-left: 36px !important;
            font-size: 12.5px !important;
        }'''

def replacement_nav(match):
    indent = match.group(1)
    nlc_active = match.group(2)
    nrc_active = match.group(3)
    smc_active = match.group(4)
    afrc_active = match.group(5)
    
    return f'''{indent}<div class="sidebar-decree-group">
{indent}    <div class="sidebar-group-header"><i class="fa-solid fa-folder mr-2" style="width: 16px; text-align: center; color: var(--gold);"></i> Decree</div>
{indent}    <a class="vertical-nav-link decree-sub-link {nlc_active}" data-group="5" data-label="NLC Decree" href="javascript:void(0)"><i class="fa-solid fa-building-columns mr-3" style="width: 16px; text-align: center;"></i> NLCD</a>
{indent}    <a class="vertical-nav-link decree-sub-link {nrc_active}" data-group="6" data-label="NRC Decree" href="javascript:void(0)"><i class="fa-solid fa-scroll mr-3" style="width: 16px; text-align: center;"></i> NRCD</a>
{indent}    <a class="vertical-nav-link decree-sub-link {smc_active}" data-group="7" data-label="SMC Decree" href="javascript:void(0)"><i class="fa-solid fa-file-contract mr-3" style="width: 16px; text-align: center;"></i> SMCD</a>
{indent}    <a class="vertical-nav-link decree-sub-link {afrc_active}" data-group="8" data-label="AFRC Decree" href="javascript:void(0)"><i class="fa-solid fa-signature mr-3" style="width: 16px; text-align: center;"></i> AFRCD</a>
{indent}</div>'''

updated_files = []

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    new_content = target_nav_pattern.sub(replacement_nav, content)
    
    if new_content != content:
        # replace double spaces that might have been added in class string
        new_content = new_content.replace('decree-sub-link  "', 'decree-sub-link "')
        
        # Add CSS
        if '.sidebar-decree-group {' not in new_content:
            new_content = css_pattern.sub(r'\g<1>' + new_css, new_content, count=1)
            
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        updated_files.append(os.path.basename(filepath))

print('Updated files:')
for file in updated_files:
    print(file)
