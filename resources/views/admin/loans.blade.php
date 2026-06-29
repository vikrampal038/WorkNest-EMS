<x-app-layout>
    <!-- Background Accents for depth -->
    <div class="fixed top-0 right-0 -z-10 w-200 h-200 bg-brand-50/50 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>
    <div class="fixed bottom-0 left-0 -z-10 w-150 h-150 bg-indigo-50/50 rounded-full blur-[100px] mix-blend-multiply pointer-events-none -translate-x-1/4 translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6" x-data="loansManager()">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Loans & Advances</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Manage employee salary advances, loans, and automated EMI deductions.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <button @click="openNewLoanModal()" class="px-4 py-2 bg-brand-600 rounded-xl text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Issue New Loan
                </button>
            </div>
        </div>

        <!-- KPI Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-brand-50 rounded-full blur-xl transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Total Active Loans</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight" x-text="formatCurrency(totalActiveLoans)"></h3>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full blur-xl transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-black tracking-wider text-slate-600 bg-slate-100 rounded-md">THIS MONTH</span>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Expected EMI Recovery</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight" x-text="formatCurrency(totalEMIRecovery)"></h3>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full blur-xl transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Pending Requests</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight" x-text="requests.filter(r => r.status === 'Pending').length"></h3>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full blur-xl transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Fully Paid (YTD)</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">12</h3>
                </div>
            </div>
        </div>

        <!-- Pending Requests Section -->
        <div x-show="requests.filter(r => r.status === 'Pending').length > 0" class="bg-white border border-rose-200 shadow-sm rounded-2xl overflow-hidden flex flex-col">
            <div class="bg-rose-50/50 px-6 py-4 border-b border-rose-100 flex items-center gap-2">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                </span>
                <h2 class="text-sm font-bold text-slate-900">Pending Employee Loan Requests</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-white">
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Employee</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Requested Amt</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Purpose</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Date</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="req in requests.filter(r => r.status === 'Pending')" :key="req.id">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden shrink-0">
                                            <img :src="req.avatar" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900" x-text="req.name"></p>
                                            <p class="text-[11px] font-medium text-slate-500" x-text="req.emp_id"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-sm font-black text-slate-900" x-text="formatCurrency(req.amount)"></p>
                                    <p class="text-[11px] text-slate-500">Sugg. EMI: <span x-text="formatCurrency(req.suggestedEmi)"></span></p>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-xs font-medium text-slate-700" x-text="req.purpose"></p>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-xs font-medium text-slate-700" x-text="req.date"></p>
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="rejectRequest(req.id)" class="px-3 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50 hover:text-rose-600 transition-colors">Reject</button>
                                        <button @click="openApproveModal(req)" class="px-3 py-1.5 bg-brand-600 text-white rounded-lg text-xs font-bold hover:bg-brand-700 transition-colors shadow-sm">Review & Approve</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Active Loans Data Grid -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden flex flex-col">
            <div class="border-b border-slate-100 bg-slate-50/50 p-4 flex flex-col sm:flex-row items-center gap-4 justify-between">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" x-model="searchQuery" placeholder="Search loans by name or ID..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all placeholder:text-slate-400">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="border-b border-slate-100 bg-white">
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Employee</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Principal Loan</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Monthly EMI</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase">Disbursed Via</th>
                            <th class="py-3 px-5 text-[10px] font-black tracking-widest text-slate-400 uppercase text-right">Outstanding Bal.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="loan in filteredLoans" :key="loan.id">
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-200 overflow-hidden shrink-0 relative">
                                            <img :src="loan.avatar" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900" x-text="loan.name"></p>
                                            <p class="text-[11px] font-medium text-slate-500" x-text="loan.emp_id"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-sm font-black text-slate-900" x-text="formatCurrency(loan.principal)"></p>
                                    <p class="text-[10px] font-medium text-slate-500" x-text="loan.date"></p>
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-rose-600" x-text="formatCurrency(loan.emi)"></span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase">/ Mo</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5">
                                    <template x-if="loan.method === 'Cash'">
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-wider rounded-md">Cash</span>
                                    </template>
                                    <template x-if="loan.method === 'Bank Transfer'">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-wider rounded-md">Bank</span>
                                    </template>
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <p class="text-sm font-black text-slate-900" x-text="formatCurrency(loan.outstanding)"></p>
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 mt-1.5 max-w-[100px] ml-auto overflow-hidden">
                                        <div class="bg-brand-500 h-1.5 rounded-full" :style="`width: ${((loan.principal - loan.outstanding) / loan.principal) * 100}%`"></div>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-400 mt-0.5 uppercase" x-text="Math.round(((loan.principal - loan.outstanding) / loan.principal) * 100) + '% Paid'"></p>
                                </td>
                            </tr>
                        </template>
                        
                        <tr x-show="filteredLoans.length === 0">
                            <td colspan="5" class="py-12 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 text-slate-400 mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-900">No active loans found</p>
                                <p class="text-xs text-slate-500 mt-1">Try adjusting your search query.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Issue / Approve Loan Modal -->
        <template x-teleport="body">
            <div x-show="loanModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" style="display: none;">
                <!-- Backdrop -->
                <div x-show="loanModalOpen" x-transition.opacity class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="loanModalOpen = false"></div>
                
                <div x-show="loanModalOpen" x-transition class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 flex flex-col max-h-full">
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center shrink-0">
                        <h3 class="text-lg font-bold text-slate-900" x-text="modalMode === 'approve' ? 'Approve Loan Request' : 'Issue New Advance'"></h3>
                        <button @click="loanModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl bg-slate-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="p-6 overflow-y-auto">
                        <div class="space-y-5">
                            
                            <!-- Employee Info Block -->
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-4">
                                <img :src="formData.avatar || 'https://ui-avatars.com/api/?name=Employee&background=random'" class="w-12 h-12 rounded-full object-cover shadow-sm bg-white border border-slate-200">
                                <div class="flex-1">
                                    <label class="block text-[10px] font-black text-slate-400 tracking-wider uppercase mb-1">Employee</label>
                                    <template x-if="modalMode === 'approve'">
                                        <p class="text-base font-bold text-slate-900" x-text="formData.name + ' (' + formData.emp_id + ')'"></p>
                                    </template>
                                    <template x-if="modalMode === 'new'">
                                        <select x-model="formData.emp_id" class="w-full bg-white border border-slate-200 rounded-lg text-sm px-3 py-2 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none">
                                            <option value="">Select Employee...</option>
                                            <option value="WN-0001">Sarah Jones (WN-0001)</option>
                                            <option value="WN-0002">Michael Chen (WN-0002)</option>
                                            <option value="WN-0003">Emma Watson (WN-0003)</option>
                                            <option value="WN-0004">David Smith (WN-0004)</option>
                                            <option value="WN-0005">Linda Taylor (WN-0005)</option>
                                        </select>
                                    </template>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 tracking-wider uppercase mb-2">Principal Amount</label>
                                    <div class="relative flex items-center bg-white border border-slate-200 rounded-xl focus-within:border-brand-500 focus-within:ring-4 focus-within:ring-brand-500/10 transition-all overflow-hidden shadow-sm">
                                        <div class="pl-4 pr-1 text-slate-400 font-black text-lg">$</div>
                                        <input type="number" x-model="formData.principal" class="w-full py-3 pr-4 bg-transparent border-none text-lg font-black text-slate-900 outline-none focus:ring-0">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 tracking-wider uppercase mb-2">Monthly EMI</label>
                                    <div class="relative flex items-center bg-rose-50/30 border border-rose-200 rounded-xl focus-within:border-rose-500 focus-within:ring-4 focus-within:ring-rose-500/10 transition-all overflow-hidden shadow-sm">
                                        <div class="pl-4 pr-1 text-rose-400 font-black text-lg">$</div>
                                        <input type="number" x-model="formData.emi" class="w-full py-3 pr-4 bg-transparent border-none text-lg font-black text-rose-600 outline-none focus:ring-0">
                                    </div>
                                    <p class="text-[10px] text-slate-500 mt-1.5 font-bold text-right" x-text="'Est. ' + Math.ceil(formData.principal / (formData.emi || 1)) + ' months'"></p>
                                </div>
                            </div>

                            <div x-show="modalMode === 'approve'" class="bg-amber-50/50 border border-amber-100 p-3 rounded-xl">
                                <label class="block text-[10px] font-black text-amber-600/70 tracking-wider uppercase mb-1">Stated Purpose</label>
                                <p class="text-sm font-medium text-amber-900" x-text="formData.purpose"></p>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 tracking-wider uppercase mb-2">Disbursement Method</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="formData.method" value="Cash" class="peer sr-only">
                                        <div class="p-3 border-2 border-slate-100 rounded-xl text-center peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-slate-50 transition-all">
                                            <div class="w-6 h-6 mx-auto mb-1 text-slate-400 peer-checked:text-brand-600">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <p class="text-xs font-bold text-slate-700 peer-checked:text-brand-700">Cash Handover</p>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="formData.method" value="Bank Transfer" class="peer sr-only">
                                        <div class="p-3 border-2 border-slate-100 rounded-xl text-center peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-slate-50 transition-all">
                                            <div class="w-6 h-6 mx-auto mb-1 text-slate-400 peer-checked:text-brand-600">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            </div>
                                            <p class="text-xs font-bold text-slate-700 peer-checked:text-brand-700">Bank Transfer</p>
                                        </div>
                                    </label>
                                </div>
                                <p x-show="formData.method === 'Cash'" class="text-[11px] text-amber-600 font-medium mt-2 bg-amber-50 p-2 rounded-lg border border-amber-100">
                                    <span class="font-bold">Note:</span> By selecting Cash, you confirm that physical cash has been handed over. The EMI will automatically deduct from their future payrolls.
                                </p>
                            </div>

                        </div>
                    </div>
                    
                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-end gap-3 shrink-0">
                        <button @click="loanModalOpen = false" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">Cancel</button>
                        <button @click="saveLoan()" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-bold hover:bg-brand-700 transition-colors shadow-sm" x-text="modalMode === 'approve' ? 'Approve & Create Loan' : 'Issue Loan'"></button>
                    </div>
                </div>
            </div>
        </template>

        <!-- Toast Notification -->
        <template x-teleport="body">
            <div x-show="showToast" x-transition.duration.300ms class="fixed bottom-6 right-6 z-[200]" style="display: none;">
                <div class="bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500/20 text-emerald-400 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Success</p>
                        <p class="text-xs text-slate-300" x-text="toastMessage"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('loansManager', () => ({
                searchQuery: '',
                loanModalOpen: false,
                modalMode: 'new', // 'new' or 'approve'
                showToast: false,
                toastMessage: '',
                
                formData: {
                    id: '',
                    emp_id: '',
                    name: '',
                    avatar: '',
                    principal: 0,
                    emi: 0,
                    method: 'Bank Transfer',
                    purpose: ''
                },

                // Dummy Pending Requests
                requests: [
                    { id: 'REQ-01', emp_id: 'WN-0012', name: 'James Wilson', avatar: 'https://i.pravatar.cc/150?u=12', amount: 5000, suggestedEmi: 1000, purpose: 'Medical Emergency', date: 'Jan 22, 2026', status: 'Pending' },
                    { id: 'REQ-02', emp_id: 'WN-0008', name: 'Sophia Martinez', avatar: 'https://i.pravatar.cc/150?u=8', amount: 2000, suggestedEmi: 500, purpose: 'Home Repair', date: 'Jan 23, 2026', status: 'Pending' }
                ],
                
                // Dummy Active Loans
                loans: [
                    { id: 'L-001', emp_id: 'WN-0002', name: 'Michael Chen', avatar: 'https://i.pravatar.cc/150?u=2', principal: 4000, emi: 400, outstanding: 2800, method: 'Bank Transfer', date: 'Oct 15, 2025' },
                    { id: 'L-002', emp_id: 'WN-0004', name: 'David Smith', avatar: 'https://i.pravatar.cc/150?u=4', principal: 2500, emi: 250, outstanding: 1500, method: 'Cash', date: 'Nov 02, 2025' },
                    { id: 'L-003', emp_id: 'WN-0009', name: 'Robert Johnson', avatar: 'https://i.pravatar.cc/150?u=9', principal: 10000, emi: 1000, outstanding: 9000, method: 'Bank Transfer', date: 'Dec 20, 2025' },
                ],
                
                get filteredLoans() {
                    return this.loans.filter(loan => {
                        return loan.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                               loan.emp_id.toLowerCase().includes(this.searchQuery.toLowerCase());
                    });
                },
                
                get totalActiveLoans() {
                    return this.loans.reduce((sum, loan) => sum + loan.outstanding, 0);
                },
                
                get totalEMIRecovery() {
                    return this.loans.reduce((sum, loan) => sum + loan.emi, 0);
                },
                
                formatCurrency(value) {
                    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);
                },

                openNewLoanModal() {
                    this.modalMode = 'new';
                    this.formData = { id: '', emp_id: '', name: '', avatar: '', principal: 0, emi: 0, method: 'Bank Transfer', purpose: '' };
                    this.loanModalOpen = true;
                },

                openApproveModal(req) {
                    this.modalMode = 'approve';
                    this.formData = {
                        id: req.id,
                        emp_id: req.emp_id,
                        name: req.name,
                        avatar: req.avatar,
                        principal: req.amount,
                        emi: req.suggestedEmi,
                        method: 'Bank Transfer',
                        purpose: req.purpose
                    };
                    this.loanModalOpen = true;
                },

                rejectRequest(id) {
                    this.requests = this.requests.filter(r => r.id !== id);
                    this.triggerToast("Loan request rejected and removed.");
                },

                saveLoan() {
                    // Logic to add to active loans
                    let empName = this.formData.name;
                    if(this.modalMode === 'new') {
                        // Quick mockup name based on ID
                        empName = "Employee " + this.formData.emp_id;
                    }

                    this.loans.unshift({
                        id: 'L-' + Math.floor(Math.random() * 1000),
                        emp_id: this.formData.emp_id,
                        name: empName,
                        avatar: this.formData.avatar || 'https://ui-avatars.com/api/?name=E&background=random',
                        principal: parseFloat(this.formData.principal),
                        emi: parseFloat(this.formData.emi),
                        outstanding: parseFloat(this.formData.principal),
                        method: this.formData.method,
                        date: 'Jan 23, 2026'
                    });

                    if(this.modalMode === 'approve') {
                        this.requests = this.requests.filter(r => r.id !== this.formData.id);
                        this.triggerToast("Request approved. Loan is now active.");
                    } else {
                        this.triggerToast("New advance successfully issued.");
                    }

                    this.loanModalOpen = false;
                },

                triggerToast(msg) {
                    this.toastMessage = msg;
                    this.showToast = true;
                    setTimeout(() => { this.showToast = false; }, 3000);
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
