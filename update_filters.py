import os
import re

directory = r'c:\laragon\www\Lawsforum\resources\views\pre_1992_legislation'
files_to_modify = [
    'displayed_afrc_decree_view.blade.php',
    'displayed_all_acts_view.blade.php',
    'displayed_first_republic_acts_view.blade.php',
    'displayed_nlc_decree_view.blade.php',
    'displayed_nrc_decree_view.blade.php',
    'displayed_pndc_law_view.blade.php',
    'displayed_second_republic_acts_view.blade.php',
    'displayed_smc_decree_view.blade.php',
    'displayed_third_republic_acts_view.blade.php',
    'new_displayed_afrc_decree_view.blade.php',
    'new_displayed_all_acts_view.blade.php',
    'new_displayed_first_republic_acts_view.blade.php',
    'new_displayed_nlc_decree_view.blade.php',
    'new_displayed_nrc_decree_view.blade.php',
    'new_displayed_pndc_law_view.blade.php',
    'new_displayed_second_republic_acts_view.blade.php',
    'new_displayed_smc_decree_view.blade.php',
    'new_displayed_third_republic_acts_view.blade.php'
]

pattern = re.compile(r'^[ \t]*<div class="premium-sidebar-card">[ \t\n]*<h5[^>]*>[ \t\n]*<i class="fa-solid fa-filter text-primary"></i> Filter[ \t\n]*</h5>.*?</div>\n', re.DOTALL | re.MULTILINE)

updated_files = []

for filename in files_to_modify:
    filepath = os.path.join(directory, filename)
    if os.path.exists(filepath):
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        new_content, count = pattern.subn('', content, count=1)
        if count > 0:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            updated_files.append(filename)

print('Updated files:')
for f in updated_files:
    print(f)
