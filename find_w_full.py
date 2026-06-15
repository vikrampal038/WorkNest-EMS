import json
with open('svg_dump.json', 'r', encoding='utf-8') as f:
    svgs = json.load(f)

for svg in svgs:
    if 'w-full' in svg['tag'] or 'h-full' in svg['tag']:
        print(f"Line {svg['line']}: {svg['tag']}")
