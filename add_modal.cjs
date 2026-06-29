const fs = require('fs');
let content = fs.readFileSync('resources/views/admin/directory.blade.php', 'utf8');

// Update all href="#" inside dropdowns to trigger modal
content = content.replace(/href="#"/g, 'href="javascript:void(0)" onclick="openModal(\\'details\\')"');

// Update Add Employee button to trigger modal
content = content.replace(
    '<button class="px-4 py-2 bg-brand-600 rounded-lg text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm flex items-center gap-2">',
    '<button onclick="openModal(\\'add\\')" class="px-4 py-2 bg-brand-600 rounded-lg text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm flex items-center gap-2">'
);

// Define modal HTML and JS logic
const modalHTML = `
        <!-- Dynamic Popup Modal (Add/Edit/View) -->
        <div id="dynamicModal" class="fixed inset-0 z-100 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on modal state. -->
            <div id="modalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" onclick="closeModal()"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal panel, show/hide based on modal state. -->
                    <div id="modalPanel" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 sm:w-full sm:max-w-xl">
                        
                        <!-- Modal Header -->
                        <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight" id="modalTitle">Employee Details</h3>
                            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Modal Body (Form) -->
                        <div class="bg-white px-6 py-6">
                            <form id="employeeForm" class="space-y-5">
                                <div class="flex items-center gap-5 pb-5 border-b border-slate-100">
                                    <div class="relative group cursor-pointer">
                                        <div class="w-20 h-20 rounded-full bg-slate-100 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden group-hover:border-brand-500 transition-colors">
                                            <svg class="w-8 h-8 text-slate-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-white rounded-full shadow-sm border border-slate-200 flex items-center justify-center text-slate-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900">Profile Photo</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">PNG, JPG up to 5MB</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">First Name</label>
                                        <input type="text" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="e.g. John">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Last Name</label>
                                        <input type="text" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="e.g. Doe">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Address</label>
                                        <input type="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="john.doe@worknest.com">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Department</label>
                                        <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white appearance-none">
                                            <option>Engineering</option>
                                            <option>Design</option>
                                            <option>Human Resources</option>
                                            <option>Sales</option>
                                            <option>Marketing</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Role/Position</label>
                                        <input type="text" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="e.g. Senior Developer">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 border-t border-slate-100 rounded-b-2xl">
                            <button type="button" onclick="closeModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-lg shadow-sm hover:bg-slate-50 transition-colors">
                                Cancel
                            </button>
                            <button type="button" onclick="closeModal()" class="w-full sm:w-auto px-5 py-2.5 bg-brand-600 border border-transparent text-sm font-bold text-white rounded-lg shadow-sm hover:bg-brand-700 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal JS Logic -->
        <script>
            function openModal(type) {
                const modal = document.getElementById('dynamicModal');
                const backdrop = document.getElementById('modalBackdrop');
                const panel = document.getElementById('modalPanel');
                const title = document.getElementById('modalTitle');

                if (type === 'add') {
                    title.textContent = 'Add New Employee';
                } else if (type === 'details') {
                    title.textContent = 'Employee Details';
                }

                // Show container
                modal.classList.remove('hidden');

                // Animate in
                requestAnimationFrame(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');

                    panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                    panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
                });
            }

            function closeModal() {
                const modal = document.getElementById('dynamicModal');
                const backdrop = document.getElementById('modalBackdrop');
                const panel = document.getElementById('modalPanel');

                // Animate out
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');

                panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
                panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

                // Hide container after transition
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300); // 300ms matches standard tailwind transition duration
            }
        </script>
`;

// Insert modal code before the closing app layout tag
content = content.replace('    </div>\n</x-app-layout>', modalHTML + '\n    </div>\n</x-app-layout>');

fs.writeFileSync('resources/views/admin/directory.blade.php', content);
console.log("Successfully added Modal UI and updated trigger buttons.");
