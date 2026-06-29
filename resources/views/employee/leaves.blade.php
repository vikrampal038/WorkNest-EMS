<x-app-layout>
    <!-- Background Accents -->
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/40 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6 max-w-4xl mx-auto">
        
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Leave Management</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">View your balances and apply for time off.</p>
            </div>
            <button onclick="openLeaveModal()" class="shrink-0 bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Apply for Leave
            </button>
        </div>

        <!-- Leave Balance Wallet -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 relative overflow-hidden group">
            <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-amber-50 rounded-full blur-xl -z-10 group-hover:scale-125 transition-transform duration-500"></div>
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div>
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Leave Balance Wallet</h2>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Valid till Dec 2026</p>
                </div>
                <button class="text-brand-600 hover:text-brand-700 transition-colors p-1.5 hover:bg-brand-50 rounded-lg" title="View Policy">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Casual Leave -->
                <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 flex flex-col items-center text-center relative hover:shadow-md transition-shadow">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                    </div>
                    <span class="text-2xl font-black text-slate-900">12</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">Casual Leave</span>
                    <span class="text-[9px] text-slate-400 mt-0.5">2 Used</span>
                </div>
                <!-- Sick Leave -->
                <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 flex flex-col items-center text-center relative hover:shadow-md transition-shadow">
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <span class="text-2xl font-black text-slate-900">08</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">Sick Leave</span>
                    <span class="text-[9px] text-slate-400 mt-0.5">0 Used</span>
                </div>
                <!-- Privilege Leave -->
                <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 flex flex-col items-center text-center relative hover:shadow-md transition-shadow">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <span class="text-2xl font-black text-slate-900">15</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">Privilege Leave</span>
                    <span class="text-[9px] text-slate-400 mt-0.5">Available</span>
                </div>
                <!-- Comp Off -->
                <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 flex flex-col items-center text-center relative hover:shadow-md transition-shadow opacity-60">
                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-2xl font-black text-slate-900">00</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 mt-1">Comp Off</span>
                    <span class="text-[9px] text-slate-400 mt-0.5">Earned</span>
                </div>
            </div>

            <!-- Recent Requests -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-3">Recent Requests</h3>
                <div class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Sick Leave</p>
                            <p class="text-[11px] text-slate-500">Tomorrow, 1 day</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-[10px] font-bold bg-amber-50 text-amber-600 rounded-md">Pending</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Leave Application Modal -->
    <div id="leaveModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 opacity-0 pointer-events-none transition-all duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeLeaveModal()"></div>
        
        <!-- Modal Content -->
        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-all duration-300" id="leaveModalContent">
            <!-- Decorative Header Background -->
            <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-br from-brand-50 to-indigo-50 opacity-50"></div>
            
            <div class="relative p-6 sm:p-8">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border border-slate-100 flex items-center justify-center mb-4 text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Apply for Leave</h3>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Submit your time-off request for HR approval.</p>
                    </div>
                    <button onclick="closeLeaveModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-2 hover:bg-slate-50 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Form -->
                <form id="leaveForm" class="space-y-5 relative z-10" onsubmit="submitLeave(event)">
                    
                    <!-- Leave Type Selection (Visual) -->
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-500 mb-3">Leave Type</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="leaveType" value="casual" class="peer sr-only" checked>
                                <div class="p-3 text-center rounded-xl border border-slate-200 bg-white peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:bg-slate-50 transition-all">
                                    <div class="text-[10px] font-black uppercase tracking-wider mb-1">Casual</div>
                                    <div class="text-xs font-medium text-slate-500 peer-checked:text-brand-600">12 Left</div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="leaveType" value="sick" class="peer sr-only">
                                <div class="p-3 text-center rounded-xl border border-slate-200 bg-white peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:bg-slate-50 transition-all">
                                    <div class="text-[10px] font-black uppercase tracking-wider mb-1">Sick</div>
                                    <div class="text-xs font-medium text-slate-500 peer-checked:text-brand-600">8 Left</div>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="leaveType" value="privilege" class="peer sr-only">
                                <div class="p-3 text-center rounded-xl border border-slate-200 bg-white peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:bg-slate-50 transition-all">
                                    <div class="text-[10px] font-black uppercase tracking-wider mb-1">Privilege</div>
                                    <div class="text-xs font-medium text-slate-500 peer-checked:text-brand-600">15 Left</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-wider text-slate-500 mb-2">From Date</label>
                            <input type="date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-wider text-slate-500 mb-2">To Date</label>
                            <input type="date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all" />
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="block text-[11px] font-black uppercase tracking-wider text-slate-500 mb-2">Reason</label>
                        <textarea required rows="3" placeholder="Briefly explain the reason for your leave..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:bg-white transition-all resize-none"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeLeaveModal()" class="flex-1 px-4 py-3 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors">Cancel</button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-brand-600 text-white rounded-xl text-sm font-bold hover:bg-brand-700 transition-colors shadow-sm">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Toast Notification System -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

    @push('scripts')
    <script>
        // --- Leave Modal Handling ---
        function openLeaveModal() {
            const modal = document.getElementById('leaveModal');
            const content = document.getElementById('leaveModalContent');
            
            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 50);
        }

        function closeLeaveModal() {
            const modal = document.getElementById('leaveModal');
            const content = document.getElementById('leaveModalContent');
            
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 200);
        }

        function submitLeave(e) {
            e.preventDefault();
            closeLeaveModal();
            
            // Show custom success toast after modal closes
            setTimeout(() => {
                showToast("Request Submitted", "Your leave application has been sent to HR for approval.", "success");
            }, 300);
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
