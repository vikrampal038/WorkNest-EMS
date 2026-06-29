const fs = require('fs');
const file = 'resources/views/admin/directory.blade.php';
let content = fs.readFileSync(file, 'utf8');

// Change Delete link to openDeleteModal
content = content.replace(/onclick="openModal\('details'\)" (class="flex items-center gap-2.5 px-3 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition-colors")/g, 'onclick="openDeleteModal()" $1');

// Add delete modal before scripts if not there
if (!content.includes('id="deleteModal"')) {
    const deleteModalCode = `
        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 z-100 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div id="deleteModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" onclick="closeDeleteModal()"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    <div id="deleteModalPanel" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 sm:w-full sm:max-w-md mx-auto">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-lg font-bold leading-6 text-slate-900" id="modal-title">Delete Employee</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-500">Are you sure you want to delete this employee? All of their data will be permanently removed. This action cannot be undone.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-4 py-3 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:px-6">
                            <button type="button" onclick="closeDeleteModal()" class="inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:w-auto transition-colors">Cancel</button>
                            <button type="button" class="inline-flex w-full justify-center rounded-lg bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
`;
    content = content.replace('<!-- Script for Modal -->', deleteModalCode + '\n        <!-- Script for Modal -->');
}

// Add closeDeleteModal and openDeleteModal JS
if (!content.includes('function openDeleteModal')) {
    const jsAdd = `
            function openDeleteModal() {
                const modal = document.getElementById('deleteModal');
                const backdrop = document.getElementById('deleteModalBackdrop');
                const panel = document.getElementById('deleteModalPanel');

                modal.classList.remove('hidden');
                // trigger reflow
                void modal.offsetWidth;

                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');

                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                const backdrop = document.getElementById('deleteModalBackdrop');
                const panel = document.getElementById('deleteModalPanel');

                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');

                panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
                panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
`;
    content = content.replace('function openModal(type)', jsAdd + '\n            function openModal(type)');
}

fs.writeFileSync(file, content);
console.log('Fixed delete modal');
