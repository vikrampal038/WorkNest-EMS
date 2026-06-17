const fs = require('fs');
const path = require('path');

const homePath = path.join(__dirname, 'resources', 'views', 'pages', 'home.blade.php');
let lines = fs.readFileSync(homePath, 'utf8').split('\n');

const componentsDir = path.join(__dirname, 'resources', 'views', 'components', 'landing');

const targets = [
    { start: '<!-- 12. Final CTA Banner -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- Component: footer -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'cta-banner' },
    
    { start: '<!-- 11. FAQ Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- Component: cta-banner -->') || l.includes('<!-- 12. Final CTA Banner -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'faq-section' },

    { start: '<!-- 10. Testimonials Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 11. FAQ Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'testimonials-section' },

    { start: '<!-- 9. Pricing Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 10. Testimonials Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'pricing-section' },

    { start: '<!-- 8.5 Compliance & Security Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 9. Pricing Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'compliance-section' },

    { start: '<!-- 8. Integrations Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 8.5 Compliance & Security Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'integrations-section' },

    { start: '<!-- 7. Employee Mobile App (Option 1) -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 8. Integrations Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'mobile-app-section' },

    { start: '<!-- 6. Interactive Dashboard Preview Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 7. Employee Mobile App (Option 1) -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'dashboard-preview-section' },

    { start: '<!-- 5. Why WorkNest Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 6. Interactive Dashboard Preview Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'why-worknest-section' },

    { start: '<!-- 4. Core Features Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 5. Why WorkNest Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'features-section' },

    { start: '<!-- 3. Trusted Companies Section', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 4. Core Features Section -->'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'trusted-companies-section' },

    { start: '<!-- 2. Hero Section -->', endMarkerFunc: (startIdx) => {
        let next = lines.findIndex((l, i) => i > startIdx && l.includes('<!-- 3. Trusted Companies Section'));
        if (next === -1) return -1;
        let endIdx = next - 1;
        while(endIdx > startIdx && lines[endIdx].trim() === '') endIdx--;
        return endIdx;
    }, name: 'hero-section' },

];

for (const target of targets) {
    let startIdx = lines.findIndex(l => l.includes(target.start));
    if (startIdx === -1) {
        console.log(`Start not found: ${target.name}`);
        continue;
    }
    
    let endIdx = -1;
    if (target.end) {
        for(let i=startIdx; i<lines.length; i++) {
            if(lines[i].includes(target.end)) {
                endIdx = i;
                break;
            }
        }
    } else if (target.endMarkerFunc) {
        endIdx = target.endMarkerFunc(startIdx);
    }
    
    if (endIdx === -1) {
        console.log(`End not found: ${target.name}`);
        continue;
    }
    
    const extracted = lines.slice(startIdx, endIdx + 1).join('\n');
    fs.writeFileSync(path.join(componentsDir, `${target.name}.blade.php`), extracted);
    
    const replacement = [`    <!-- Component: ${target.name} -->`, `    <x-landing.${target.name} />`];
    lines.splice(startIdx, endIdx - startIdx + 1, ...replacement);
    console.log(`Extracted: ${target.name} (Lines ${startIdx+1} to ${endIdx+1})`);
}

fs.writeFileSync(homePath, lines.join('\n'));
console.log('Saved home.blade.php');
