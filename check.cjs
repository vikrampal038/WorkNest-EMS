const fs = require('fs');
const content = fs.readFileSync('c:/Users/vikra/OneDrive/Desktop/All Projects/WorkNest-EMS/resources/views/pages/home.blade.php', 'utf8');

// The x-data is on line 10, ends around 442
const lines = content.split('\n');
const startLine = 9; // 0-indexed, line 10
let endLine = -1;
for (let i = startLine; i < lines.length; i++) {
    if (lines[i].includes('}" x-effect="')) {
        endLine = i;
        break;
    }
}

if (endLine !== -1) {
    let xDataStr = lines.slice(startLine, endLine + 1).join('\n');
    xDataStr = xDataStr.replace('" x-data="', '').replace('}" x-effect="', '}');
    try {
        new Function('return ' + xDataStr);
        console.log('Syntax OK!');
    } catch (e) {
        console.log('Syntax Error in x-data:', e);
    }
} else {
    console.log('Could not find the end of x-data');
}
