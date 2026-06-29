<x-app-layout>
    <!-- Background Accents -->
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/40 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6 max-w-4xl mx-auto">
        
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Documents Vault</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Access your payslips, policies, and sign required documents.</p>
            </div>
            <button onclick="showToast('Info', 'Payslips will be available after payroll processing.', 'info')" class="shrink-0 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-4 py-2 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Latest Payslip
            </button>
        </div>

        <!-- Salary & Documents Vault -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 relative overflow-hidden group">
            <div class="absolute -bottom-16 -right-16 w-32 h-32 bg-purple-50 rounded-full blur-xl -z-10 group-hover:scale-125 transition-transform duration-500"></div>

            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div>
                    <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Salary & Documents Vault</h2>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Payslips, Tax Forms & Company Policies</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Latest Payslip -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">May 2026 Payslip</h4>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-500 mt-0.5">Credited on 31st May</p>
                        </div>
                    </div>
                    <button onclick="downloadPayslip('May 2026 Payslip')" class="p-2 text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </button>
                </div>

                <!-- Form 16 / Tax -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Form 16 (FY 25-26)</h4>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-500 mt-0.5">Available Now</p>
                        </div>
                    </div>
                    <button onclick="downloadPayslip('Form 16 (FY 25-26)')" class="p-2 text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Assigned Documents to Sign -->
            @if(isset($documents) && $documents->count() > 0)
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider mb-3">Action Required / Policies</h3>
                <div class="space-y-3 mb-4">
                    @foreach($documents as $doc)
                        <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-slate-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $doc->name }}</h4>
                                    <p class="text-[10px] font-bold uppercase tracking-wider {{ $doc->status === 'Signed' ? 'text-emerald-500' : 'text-amber-500' }} mt-0.5">
                                        {{ $doc->status }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                @if($doc->status !== 'Signed')
                                    <a href="{{ route('employee.document.sign', $doc->id) }}" class="px-3 py-1.5 bg-brand-600 hover:bg-brand-700 text-white rounded-lg text-xs font-bold shadow-xs transition-colors flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Sign Now
                                    </a>
                                @else
                                    <button onclick="downloadPayslip('{{ $doc->name }}')" class="p-1.5 hover:bg-white border border-transparent hover:border-slate-200 rounded-lg text-slate-500 hover:text-brand-600 transition-colors" title="Download Signed Copy">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Floating Toast Notification System -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

    @push('scripts')
    <script>
        function downloadPayslip(fileName) {
            showToast("Download Started", `Preparing ${fileName} for download...`, "success");
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
