const fs = require('fs');

const logPath = 'C:\\\\Users\\\\vikra\\\\.gemini\\\\antigravity-ide\\\\brain\\\\a15cf5f4-4216-4a66-8df6-937a8c0a805b\\\\.system_generated\\\\logs\\\\transcript_full.jsonl';
const fileContent = fs.readFileSync(logPath, 'utf8');

const lines = fileContent.split('\n');
let docsContent = null;

for (const line of lines) {
    if (!line.trim()) continue;
    try {
        const entry = JSON.parse(line);
        if (entry.type === 'PLANNER_RESPONSE' && entry.tool_calls) {
            for (const tc of entry.tool_calls) {
                if (tc.name === 'write_to_file') {
                    const args = tc.args || {};
                    const target = args.TargetFile || '';
                    if (target.includes('documents.blade.php') && !target.includes('employee')) {
                        docsContent = args.CodeContent;
                    }
                }
            }
        }
    } catch (e) {
        // ignore
    }
}

if (docsContent) {
    fs.writeFileSync('C:\\\\Users\\\\vikra\\\\OneDrive\\\\Desktop\\\\All Projects\\\\WorkNest-EMS\\\\resources\\\\views\\\\admin\\\\documents.blade.php', docsContent, 'utf8');
    console.log('Restored documents.blade.php');
} else {
    console.log('Could not find content in transcript');
}
