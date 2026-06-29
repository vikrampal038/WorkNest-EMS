<x-app-layout>
    <!-- Background Accents -->
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/40 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6 max-w-4xl mx-auto">
        
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">My Tasks</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Track your assigned work and update progress.</p>
            </div>
            <button class="shrink-0 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                New Personal Task
            </button>
        </div>

        <!-- Task Board -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 relative overflow-hidden group">
            <!-- Decorative blur -->
            <div class="absolute -top-16 -right-16 w-32 h-32 bg-blue-50 rounded-full blur-xl -z-10 group-hover:scale-125 transition-transform duration-500"></div>

            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div>
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">My Task Board</h2>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Prioritized for this week</p>
                </div>
                <div class="flex gap-2">
                    <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold uppercase">4 Pending</span>
                </div>
            </div>

            <!-- Task List -->
            <div class="space-y-3" id="taskListContainer">
                
                <!-- Task 1 (High Priority) -->
                <div class="group/task flex items-start gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-brand-200 hover:shadow-md transition-all cursor-pointer">
                    <!-- Checkbox -->
                    <div class="mt-0.5">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="peer sr-only" onchange="toggleTask(this)">
                            <div class="w-5 h-5 rounded border-2 border-slate-300 peer-checked:border-brand-500 peer-checked:bg-brand-500 flex items-center justify-center transition-colors">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </label>
                    </div>
                    <!-- Content -->
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-sm font-bold text-slate-900 group-hover/task:text-brand-600 transition-colors">Complete Q3 Performance Self-Review</h4>
                            <span class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded text-[9px] font-black uppercase tracking-wider border border-rose-100">High</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium line-clamp-1 mb-2">Fill out the self-evaluation form in the HR portal before the manager 1-on-1.</p>
                        <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400">
                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Due Today</span>
                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg> HR Dept</span>
                        </div>
                    </div>
                </div>

                <!-- Task 2 (Medium) -->
                <div class="group/task flex items-start gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-white hover:border-brand-200 hover:shadow-md transition-all cursor-pointer">
                    <div class="mt-0.5">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="peer sr-only" onchange="toggleTask(this)">
                            <div class="w-5 h-5 rounded border-2 border-slate-300 peer-checked:border-brand-500 peer-checked:bg-brand-500 flex items-center justify-center transition-colors">
                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </label>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-sm font-bold text-slate-900 group-hover/task:text-brand-600 transition-colors">Submit Weekly Expense Report</h4>
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded text-[9px] font-black uppercase tracking-wider border border-amber-100">Medium</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium line-clamp-1 mb-2">Upload client lunch receipts and travel tickets for reimbursement.</p>
                        <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400">
                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Friday</span>
                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg> Finance</span>
                        </div>
                    </div>
                </div>
                
                <!-- Task 3 (Completed Example) -->
                <div class="group/task flex items-start gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50/50 opacity-60 transition-all cursor-pointer">
                    <div class="mt-0.5">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" class="peer sr-only" checked disabled>
                            <div class="w-5 h-5 rounded border-2 border-emerald-500 bg-emerald-500 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </label>
                    </div>
                    <div class="flex-1 line-through decoration-slate-300">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="text-sm font-bold text-slate-600">Complete POSH Compliance Training</h4>
                        </div>
                        <p class="text-xs text-slate-400 font-medium line-clamp-1 mb-2">Mandatory annual training module.</p>
                        <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400">
                            <span class="flex items-center gap-1 text-emerald-600">Done</span>
                        </div>
                    </div>
                </div>

            </div>
            
            <button class="w-full mt-4 py-2 border-2 border-dashed border-slate-200 rounded-xl text-xs font-bold text-slate-500 hover:text-brand-600 hover:border-brand-200 hover:bg-brand-50 transition-all uppercase tracking-wider">
                Load More Tasks
            </button>
        </div>
    </div>

    <!-- Floating Toast Notification System -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

    @push('scripts')
    <script>
        // --- Task System ---
        function toggleTask(checkbox) {
            const taskCard = checkbox.closest('.group\\/task');
            if(checkbox.checked) {
                // Animate to completed state
                taskCard.classList.add('opacity-60', 'bg-slate-50/50');
                taskCard.classList.remove('hover:bg-white', 'hover:border-brand-200', 'hover:shadow-md');
                
                const title = taskCard.querySelector('h4');
                const p = taskCard.querySelector('p');
                title.classList.add('line-through', 'text-slate-600');
                title.classList.remove('text-slate-900', 'group-hover/task:text-brand-600');
                p.classList.add('line-through');

                showToast("Task Completed", "Great job! Keep up the momentum.", "success");
            } else {
                // Revert
                taskCard.classList.remove('opacity-60', 'bg-slate-50/50');
                taskCard.classList.add('hover:bg-white', 'hover:border-brand-200', 'hover:shadow-md');
                
                const title = taskCard.querySelector('h4');
                const p = taskCard.querySelector('p');
                title.classList.remove('line-through', 'text-slate-600');
                title.classList.add('text-slate-900', 'group-hover/task:text-brand-600');
                p.classList.remove('line-through');
            }
        }

        // --- Toast System ---
        function showToast(title, message, type = "success") {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = "flex items-start gap-3 w-80 p-4 bg-white border border-slate-200 rounded-xl shadow-lg pointer-events-auto transform translate-y-4 opacity-0 transition-all duration-300";

            let iconHtml = "";
            if (type === "success") {
                iconHtml = `<div class="w-5 h-5 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>`;
            } else if (type === "info") {
                iconHtml = `<div class="w-5 h-5 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>`;
            }

            toast.innerHTML = `
                ${iconHtml}
                <div class="flex-1">
                    <h5 class="text-xs font-black text-slate-800">${title}</h5>
                    <p class="text-[11px] text-slate-500 mt-0.5 leading-normal">${message}</p>
                </div>
            `;

            container.appendChild(toast);

            // Animate In
            setTimeout(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Animate Out & Remove
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
    </script>
    @endpush
</x-app-layout>
