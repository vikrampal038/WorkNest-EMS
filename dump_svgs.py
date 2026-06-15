import re
import json

with open(r'c:\Users\vikra\OneDrive\Desktop\All Projects\WorkNest-EMS\resources\views\pages\home.blade.php', 'r', encoding='utf-8') as f:
    text = f.read()

svgs = []
for m in re.finditer(r'<svg[^>]*>', text):
    tag = m.group(0)
    line_num = text.count('\n', 0, m.start()) + 1
    
    # Try to find the closing tag
    end_idx = text.find('</svg>', m.end())
    if end_idx != -1:
        full_svg = text[m.start():end_idx + 6]
    else:
        full_svg = tag
        
    svgs.append({
        'line': line_num,
        'tag': tag,
        'full': full_svg
    })

with open('svg_dump.json', 'w', encoding='utf-8') as f:
    json.dump(svgs, f, indent=2)
