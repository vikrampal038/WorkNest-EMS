const fs = require('fs');
let content = fs.readFileSync('resources/views/admin/directory.blade.php', 'utf8');

// Replace container
content = content.replace(/<div class="relative inline-block text-left" x-data="\{ open: false \}" @click\.outside="open = false">/g, '<div class="relative inline-block text-left action-dropdown-container">');

// Replace button
content = content.replace(/<button @click="open = !open" class="p-2 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">/g, '<button class="p-2 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors action-dropdown-btn">');

// Replace dropdown menu block
content = content.replace(/<div x-show="open"[\s\S]*?style="display: none;">/g, '<div class="absolute right-8 top-0 mt-1 w-48 rounded-xl border border-slate-200/60 bg-white/90 backdrop-blur-xl shadow-lg z-50 overflow-hidden action-dropdown-menu hidden opacity-0 scale-95 transition-all duration-150 origin-top-right">');

// Add the JS logic at the very end right before </x-app-layout>
if (!content.includes('action-dropdown-btn')) {
    console.error("Replacement failed!");
    process.exit(1);
}

const jsLogic = `
        <!-- Vanilla JS Dropdown Logic -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const containers = document.querySelectorAll('.action-dropdown-container');
                let activeDropdown = null;

                containers.forEach(container => {
                    const btn = container.querySelector('.action-dropdown-btn');
                    const menu = container.querySelector('.action-dropdown-menu');

                    if (btn && menu) {
                        btn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            
                            // Close other active dropdowns
                            if (activeDropdown && activeDropdown !== menu) {
                                activeDropdown.classList.add('hidden', 'opacity-0', 'scale-95');
                                activeDropdown.classList.remove('opacity-100', 'scale-100');
                            }

                            if (menu.classList.contains('hidden')) {
                                // Open
                                menu.classList.remove('hidden');
                                // small delay to allow display:block to apply before animating opacity
                                requestAnimationFrame(() => {
                                    menu.classList.remove('opacity-0', 'scale-95');
                                    menu.classList.add('opacity-100', 'scale-100');
                                });
                                activeDropdown = menu;
                            } else {
                                // Close
                                menu.classList.remove('opacity-100', 'scale-100');
                                menu.classList.add('opacity-0', 'scale-95');
                                setTimeout(() => {
                                    menu.classList.add('hidden');
                                }, 150); // wait for transition
                                activeDropdown = null;
                            }
                        });
                    }
                });

                // Close on outside click
                document.addEventListener('click', () => {
                    if (activeDropdown) {
                        activeDropdown.classList.remove('opacity-100', 'scale-100');
                        activeDropdown.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            activeDropdown.classList.add('hidden');
                        }, 150);
                        activeDropdown = null;
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
`;

content = content.replace(/    <\/div>\s*<\/x-app-layout>/g, jsLogic);

fs.writeFileSync('resources/views/admin/directory.blade.php', content);
console.log("Successfully replaced Alpine JS with Vanilla JS dropdowns.");
