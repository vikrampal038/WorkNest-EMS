import json
import os

log_path = r'C:\Users\vikra\.gemini\antigravity-ide\brain\a15cf5f4-4216-4a66-8df6-937a8c0a805b\.system_generated\logs\transcript_full.jsonl'
docs_content = None

with open(log_path, 'r', encoding='utf-8') as f:
    for line in f:
        try:
            entry = json.loads(line)
            
            if entry.get('type') == 'PLANNER_RESPONSE' and 'tool_calls' in entry:
                for tc in entry['tool_calls']:
                    if tc.get('name') in ['write_to_file']:
                        args = tc.get('args', {})
                        code = args.get('CodeContent', '')
                        if '<div x-data="documentsManager()"' in code:
                            docs_content = code
        except Exception as e:
            pass

if docs_content:
    with open(r'C:\Users\vikra\OneDrive\Desktop\All Projects\WorkNest-EMS\resources\views\admin\documents.blade.php', 'w', encoding='utf-8') as out:
        out.write(docs_content)
    print('Restored documents.blade.php from write_to_file')
else:
    print('Still not found in write_to_file')
