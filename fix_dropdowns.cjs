const fs = require('fs');
const file = 'resources/views/admin/directory.blade.php';
let content = fs.readFileSync(file, 'utf8');

// Replace all links inside action-dropdown-menu that don't have onclick with openModal
content = content.replace(/<a href="#" (class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-600 rounded-lg transition-colors")>/g, '<a href="javascript:void(0)" onclick="openModal(\'details\')" $1>');

// Make sure delete doesn't have href="#" either
content = content.replace(/<a href="#" (class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition-colors")>/g, '<a href="javascript:void(0)" onclick="openModal(\'details\')" $1>');

// Fix modal alignment
content = content.replace(/items-end justify-center p-4 text-center sm:items-center sm:p-0/, 'items-center justify-center p-4 text-center sm:p-0');
content = content.replace(/sm:my-8 sm:w-full sm:max-w-xl/, 'sm:my-8 sm:w-full sm:max-w-xl mx-auto');

fs.writeFileSync(file, content);
console.log('Fixed dropdowns and modal layout');
