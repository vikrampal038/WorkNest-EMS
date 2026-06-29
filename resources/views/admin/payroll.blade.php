<x-app-layout>
    <!-- Background Accents for depth -->
    <div class="fixed top-0 right-0 -z-10 w-200 h-200 bg-brand-50/50 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>
    <div class="fixed bottom-0 left-0 -z-10 w-150 h-150 bg-indigo-50/50 rounded-full blur-[100px] mix-blend-multiply pointer-events-none -translate-x-1/4 translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6" x-data="payrollManager()" x-init="initChart()">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Payroll & Salary</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Manage employee compensations, bonuses, and generate payslips.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <button @click="exportBankFormat()" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Bank Export
                </button>
                <button @click="openRunPayrollModal()" class="px-4 py-2 bg-brand-600 rounded-xl text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Run Payroll
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-black tracking-wider text-emerald-700 bg-emerald-100 rounded-md">+4.5%</span>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Est. Total Payroll</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight" x-text="formatCurrency(totalPayrollCost)"></h3>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full blur-xl transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-black tracking-wider text-slate-600 bg-slate-100 rounded-md" x-text="`OF ${employees.length}`"></span>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Employees Paid</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight" x-text="paidCount"></h3>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full blur-xl transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                    </div>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Total Deductions (Tax)</p>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight" x-text="formatCurrency(totalDeductions)"></h3>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-between group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full blur-xl transition-transform group-hover:scale-150"></div>
                <div class="relative z-10 flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-black tracking-wider text-amber-700 bg-amber-100 rounded-md">IN 3 DAYS</span>
                </div>
                <div class="relative z-10 mt-2">
                    <p class="text-xs text-slate-500 font-bold mb-1">Upcoming Payout</p>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Jan 30, 2026</h3>
                </div>
            </div>
        </div>

        <!-- Premium Insights & Trends Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- AI Anomalies Alert Box -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-rose-50 rounded-full blur-2xl pointer-events-none transition-transform group-hover:scale-125"></div>
                <div class="flex items-center gap-3 mb-4 relative z-10">
                    <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 tracking-tight">AI Insights & Alerts</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Real-Time Scan</p>
                    </div>
                </div>
                <div class="flex-1 flex flex-col gap-3 relative z-10">
                    <div class="p-3 bg-rose-50/50 border border-rose-100 rounded-xl hover:bg-rose-50 transition-colors">
                        <div class="flex items-start gap-2.5">
                            <span class="text-rose-500 text-sm mt-0.5">⚠️</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Abnormal Overtime Spike</h4>
                                <p class="text-[11px] text-slate-600 font-medium leading-relaxed mt-1">Engineering department's overtime payout is <span class="font-bold text-rose-600 bg-rose-100 px-1 rounded">+15% higher</span> than the 6-month average.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-50/50 border border-emerald-100 rounded-xl mt-auto hover:bg-emerald-50 transition-colors">
                        <div class="flex items-start gap-2.5">
                            <span class="text-emerald-500 text-sm mt-0.5">✨</span>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Tax Optimization Active</h4>
                                <p class="text-[11px] text-slate-600 font-medium leading-relaxed mt-1">System saved <span class="font-bold text-emerald-600 bg-emerald-100 px-1 rounded">$2,400</span> in compliance routing this month.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget vs Actual Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col relative">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <h3 class="text-base font-black text-slate-900 tracking-tight">Budget vs. Actual Payroll Burn</h3>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">6-Month Trailing Cash Expense vs HR Allocation</p>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-black tracking-wider text-brand-700 bg-brand-100 rounded-md uppercase shrink-0">On Track</span>
                </div>
                <!-- Chart Container -->
                <div id="budgetChart" class="w-full h-48 mt-auto -ml-2"></div>
            </div>
        </div>

        <!-- Main Data Grid Section -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden flex flex-col">
            <!-- Header & Controls -->
            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-72">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" x-model="searchQuery" class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="Search employee or ID...">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <select x-model="statusFilter" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 appearance-none pr-10 relative cursor-pointer shadow-sm">
                        <option value="all">All Statuses</option>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending</option>
                    </select>
                    
                    <select x-model="deptFilter" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 appearance-none pr-10 relative cursor-pointer shadow-sm">
                        <option value="all">All Departments</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Design">Design</option>
                        <option value="HR">HR</option>
                        <option value="Sales">Sales</option>
                    </select>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white border-b border-slate-200">
                            <th class="py-3.5 px-5 text-[11px] font-black text-slate-400 uppercase tracking-wider">Employee</th>
                            <th class="py-3.5 px-5 text-[11px] font-black text-slate-400 uppercase tracking-wider">Base Salary</th>
                            <th class="py-3.5 px-5 text-[11px] font-black text-slate-400 uppercase tracking-wider">Bonus / Allow.</th>
                            <th class="py-3.5 px-5 text-[11px] font-black text-slate-400 uppercase tracking-wider">Deductions</th>
                            <th class="py-3.5 px-5 text-[11px] font-black text-slate-400 uppercase tracking-wider">Net Pay</th>
                            <th class="py-3.5 px-5 text-[11px] font-black text-slate-400 uppercase tracking-wider text-center">Status</th>
                            <th class="py-3.5 px-5 text-[11px] font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="emp in filteredEmployees" :key="emp.id">
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-200 overflow-hidden shrink-0 relative">
                                            <img :src="emp.avatar" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5">
                                                <p class="text-sm font-bold text-slate-900" x-text="emp.name"></p>
                                                <div x-show="emp.attendanceScore === 100" class="flex items-center" title="100% Attendance">
                                                    <svg class="w-3.5 h-3.5 text-amber-500 drop-shadow-sm" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                </div>
                                            </div>
                                            <p class="text-[11px] font-medium text-slate-500" x-text="emp.id + ' • ' + emp.department"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-sm font-bold text-slate-700" x-text="formatCurrency(emp.base)"></p>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-sm font-bold text-emerald-600" x-text="'+ ' + formatCurrency(emp.bonus)"></p>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-sm font-bold text-rose-500" x-text="'- ' + formatCurrency(emp.deductions)"></p>
                                </td>
                                <td class="py-3.5 px-5">
                                    <p class="text-sm font-black text-slate-900" x-text="formatCurrency(emp.net)"></p>
                                </td>
                                <td class="py-3.5 px-5 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-black tracking-wider uppercase" 
                                          :class="emp.status === 'Paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'"
                                          x-text="emp.status"></span>
                                </td>
                                <td class="py-3.5 px-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button @click="openAdjustModal(emp)" class="p-1.5 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Adjust Deductions/Bonus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button @click="openPayslipModal(emp)" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="View Payslip">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredEmployees.length === 0">
                            <td colspan="7" class="py-8 text-center text-slate-500 text-sm font-medium">No records found matching your filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Footer -->
            <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500" x-text="`Showing ${filteredEmployees.length} entries`"></span>
                <div class="flex gap-1">
                    <button class="px-3 py-1 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-50 transition-colors disabled:opacity-50">Prev</button>
                    <button class="px-3 py-1 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-50 transition-colors disabled:opacity-50">Next</button>
                </div>
            </div>
        </div>

        <!-- Adjust Salary Modal -->
        <div x-show="adjustModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
            <div x-show="adjustModalOpen" @click="adjustModalOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            
            <div x-show="adjustModalOpen" x-transition class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 transform">
                <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                    <h3 class="text-lg font-bold text-slate-900">Adjust Salary & EMI</h3>
                    <button @click="adjustModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl bg-slate-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 space-y-4" x-data="{ localBonus: 0, localDed: 0 }" x-init="$watch('selectedEmp', val => { if(val) { localBonus = val.bonus; localDed = val.deductions; } })">
                    <div class="flex items-center justify-between mb-4 p-3 bg-slate-50 border border-slate-100 rounded-xl">
                        <div class="flex items-center gap-3">
                            <img :src="selectedEmp?.avatar" class="w-10 h-10 rounded-full bg-slate-200 object-cover">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <p class="text-sm font-bold text-slate-900" x-text="selectedEmp?.name"></p>
                                    <span x-show="selectedEmp?.attendanceScore === 100" class="text-[9px] font-black uppercase tracking-wider bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded flex items-center gap-0.5">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        Top Perf.
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 font-medium" x-text="selectedEmp?.id"></p>
                            </div>
                        </div>
                        
                        <!-- Auto-Bonus Action -->
                        <button x-show="selectedEmp?.attendanceScore === 100" @click="applyAutoBonus(); localBonus = selectedEmp.bonus;" class="px-2.5 py-1.5 bg-brand-600 text-white text-[10px] font-black uppercase tracking-wider rounded-lg shadow-sm hover:bg-brand-700 transition-all flex items-center gap-1" title="100% Attendance Bonus">
                            ✨ Auto-Bonus
                        </button>
                    </div>

                    <!-- EMI Tracker Action -->
                    <div x-show="selectedEmp?.activeEMI > 0" class="mb-4 p-3 bg-rose-50/50 border border-rose-100 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Active Advance Loan</p>
                            <p class="text-sm font-black text-slate-900 mt-0.5" x-text="'- ' + formatCurrency(selectedEmp?.activeEMI) + ' / month'"></p>
                        </div>
                        <button @click="localDed = selectedEmp?.activeEMI" class="px-3 py-1.5 bg-white border border-rose-200 text-rose-700 text-xs font-bold rounded-lg hover:bg-rose-50 transition-colors shadow-sm">
                            Apply EMI
                        </button>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Add Bonus / Allowances ($)</label>
                        <input type="number" x-model.number="localBonus" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 font-bold text-slate-900 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1.5">Deductions / Fines ($)</label>
                        <input type="number" x-model.number="localDed" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 font-bold text-slate-900 outline-none">
                    </div>
                    
                    <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                        <button @click="adjustModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl">Cancel</button>
                        <button @click="saveAdjustments(localBonus, localDed)" class="px-5 py-2 bg-brand-600 text-white text-sm font-bold rounded-xl hover:bg-brand-700 transition-colors">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payslip Modal (View PDF-like) -->
        <div x-show="payslipModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" style="display: none;">
            <div x-show="payslipModalOpen" @click="payslipModalOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            
            <div x-show="payslipModalOpen" x-transition class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 flex flex-col max-h-[90vh]">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 shrink-0">
                    <h3 class="text-base font-bold text-slate-900">Payslip Preview</h3>
                    <div class="flex items-center gap-2">
                        <button @click="printPayslip()" class="px-3 py-1.5 bg-white border border-slate-200 text-xs font-bold text-slate-700 rounded-lg hover:bg-slate-50 shadow-sm flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print PDF
                        </button>
                        <button @click="payslipModalOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 bg-white border border-slate-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-8 overflow-y-auto" id="printablePayslip">
                    <!-- Payslip Content -->
                    <div class="flex justify-between items-start border-b-2 border-slate-800 pb-6 mb-6">
                        <div>
                            <h2 class="text-3xl font-black tracking-tight text-slate-900">WorkNest.</h2>
                            <p class="text-sm text-slate-500 font-medium mt-1">123 Business Avenue, Suite 100<br>Tech District, CA 90210</p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-2xl font-bold text-slate-300 uppercase tracking-widest">Payslip</h3>
                            <p class="text-sm font-bold text-slate-800 mt-2">For Period: Jan 2026</p>
                            <p class="text-xs text-slate-500 font-medium mt-1" x-text="'Generated: ' + new Date().toLocaleDateString()"></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Employee Details</p>
                            <p class="text-base font-black text-slate-900" x-text="selectedEmp?.name"></p>
                            <p class="text-sm font-medium text-slate-600 mt-1" x-text="selectedEmp?.role"></p>
                            <p class="text-sm font-medium text-slate-600" x-text="'Dept: ' + selectedEmp?.department"></p>
                            <p class="text-sm font-medium text-slate-600" x-text="'ID: ' + selectedEmp?.id"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Payment Info</p>
                            <p class="text-sm font-medium text-slate-600">Bank: Chase Bank</p>
                            <p class="text-sm font-medium text-slate-600">A/C: **** **** 1234</p>
                            <span class="inline-block mt-2 px-3 py-1 text-xs font-black uppercase tracking-widest rounded-md" 
                                  :class="selectedEmp?.status === 'Paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'"
                                  x-text="selectedEmp?.status"></span>
                        </div>
                    </div>
                    
                    <table class="w-full text-left mb-8">
                        <thead>
                            <tr class="border-b border-slate-300">
                                <th class="py-2 text-xs font-black text-slate-500 uppercase tracking-wider">Earnings</th>
                                <th class="py-2 text-xs font-black text-slate-500 uppercase tracking-wider text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                            <tr>
                                <td class="py-3">Basic Salary</td>
                                <td class="py-3 text-right font-bold" x-text="formatCurrency(selectedEmp?.base || 0)"></td>
                            </tr>
                            <tr>
                                <td class="py-3">Bonuses & Allowances</td>
                                <td class="py-3 text-right font-bold text-emerald-600" x-text="formatCurrency(selectedEmp?.bonus || 0)"></td>
                            </tr>
                            <tr class="border-t border-slate-300 bg-slate-50/50">
                                <td class="py-3 font-bold text-slate-900">Gross Earnings</td>
                                <td class="py-3 text-right font-black text-slate-900" x-text="formatCurrency((selectedEmp?.base || 0) + (selectedEmp?.bonus || 0))"></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table class="w-full text-left mb-8">
                        <thead>
                            <tr class="border-b border-slate-300">
                                <th class="py-2 text-xs font-black text-slate-500 uppercase tracking-wider">Deductions</th>
                                <th class="py-2 text-xs font-black text-slate-500 uppercase tracking-wider text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                            <tr>
                                <td class="py-3">Tax & Contributions</td>
                                <td class="py-3 text-right font-bold text-rose-500" x-text="formatCurrency(selectedEmp?.deductions || 0)"></td>
                            </tr>
                            <tr class="border-t border-slate-300 bg-slate-50/50">
                                <td class="py-3 font-bold text-slate-900">Total Deductions</td>
                                <td class="py-3 text-right font-black text-slate-900" x-text="formatCurrency(selectedEmp?.deductions || 0)"></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="bg-slate-900 text-white p-6 rounded-2xl flex justify-between items-center mb-8">
                        <div>
                            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider">Net Pay</p>
                            <p class="text-3xl font-black tracking-tight mt-1" x-text="formatCurrency(selectedEmp?.net || 0)"></p>
                        </div>
                        <div class="text-right opacity-50">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>
                    </div>
                    
                    <p class="text-center text-xs font-medium text-slate-400">This is a system generated payslip and does not require a physical signature.</p>
                </div>
            </div>
        </div>

        <!-- Run Payroll Confirmation Modal -->
        <div x-show="runPayrollModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
            <div x-show="runPayrollModalOpen" @click="runPayrollModalOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            
            <div x-show="runPayrollModalOpen" x-transition class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden z-10 transform">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight mb-2">Process Payroll?</h3>
                    <p class="text-sm text-slate-500 font-medium">This action will process all pending salaries. In a production environment, this is where the system would connect to a payment gateway or banking API.</p>
                    
                    <div class="mt-4 p-4 bg-slate-50 rounded-2xl flex justify-between items-center text-left border border-slate-100">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase">Total to Pay</p>
                            <p class="text-lg font-black text-slate-900 mt-0.5" x-text="formatCurrency(totalToPay)"></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-500 uppercase">Employees</p>
                            <p class="text-lg font-black text-slate-900 mt-0.5" x-text="pendingCount"></p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex gap-3">
                    <button @click="runPayrollModalOpen = false" class="flex-1 py-2.5 px-4 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl hover:bg-slate-100 transition-colors">Cancel</button>
                    <button @click="confirmRunPayroll()" class="flex-1 py-2.5 px-4 bg-brand-600 text-white text-sm font-bold rounded-xl hover:bg-brand-700 transition-colors shadow-sm shadow-brand-500/30">Confirm & Run</button>
                </div>
            </div>
        </div>

        <!-- Success Toast Notification -->
        <div x-show="showToast" x-transition.opacity x-transition:enter.duration.300ms x-transition:leave.duration.500ms class="fixed bottom-6 right-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl shadow-xl flex items-start gap-3 z-[110] max-w-sm" style="display: none;">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <h4 class="text-sm font-bold">Payroll Processed Successfully</h4>
                <p class="text-xs font-medium text-emerald-600 mt-0.5">All pending salaries have been marked as paid.</p>
            </div>
            <button @click="showToast = false" class="text-emerald-400 hover:text-emerald-700 ml-auto shrink-0 mt-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

    </div>

    @push('scripts')
    <!-- Include ApexCharts for the Budget Graph -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('payrollManager', () => ({
                searchQuery: '',
                statusFilter: 'all',
                deptFilter: 'all',
                adjustModalOpen: false,
                payslipModalOpen: false,
                runPayrollModalOpen: false,
                showToast: false,
                selectedEmp: null,
                
                employees: [
                    { id: 'WN-0001', name: 'Sarah Jones', role: 'UX Designer', department: 'Design', base: 6500, bonus: 250, deductions: 450, avatar: 'https://i.pravatar.cc/150?u=1', status: 'Pending', attendanceScore: 92, activeEMI: 0 },
                    { id: 'WN-0002', name: 'Michael Chen', role: 'Senior Engineer', department: 'Engineering', base: 8200, bonus: 0, deductions: 680, avatar: 'https://i.pravatar.cc/150?u=2', status: 'Paid', attendanceScore: 95, activeEMI: 400 },
                    { id: 'WN-0003', name: 'Emma Watson', role: 'HR Manager', department: 'HR', base: 5800, bonus: 500, deductions: 320, avatar: 'https://i.pravatar.cc/150?u=3', status: 'Paid', attendanceScore: 98, activeEMI: 0 },
                    { id: 'WN-0004', name: 'David Smith', role: 'Sales Exec', department: 'Sales', base: 4500, bonus: 1200, deductions: 250, avatar: 'https://i.pravatar.cc/150?u=4', status: 'Pending', attendanceScore: 85, activeEMI: 250 },
                    { id: 'WN-0005', name: 'Linda Taylor', role: 'Frontend Dev', department: 'Engineering', base: 6000, bonus: 100, deductions: 400, avatar: 'https://i.pravatar.cc/150?u=5', status: 'Paid', attendanceScore: 100, activeEMI: 0 },
                ],
                
                init() {
                    // Calculate net initially
                    this.employees.forEach(emp => {
                        emp.net = emp.base + emp.bonus - emp.deductions;
                    });
                },

                initChart() {
                    const options = {
                        series: [{
                            name: 'Actual Payroll Expense',
                            data: [72000, 74000, 75500, 75000, 78000, 84250]
                        }, {
                            name: 'Allocated Budget',
                            data: [75000, 75000, 75000, 75000, 80000, 80000]
                        }],
                        chart: {
                            type: 'area',
                            height: 220,
                            toolbar: { show: false },
                            fontFamily: 'Inter, sans-serif'
                        },
                        colors: ['#6366f1', '#cbd5e1'],
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.0,
                                stops: [0, 100]
                            }
                        },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: [3, 2], dashArray: [0, 5] },
                        xaxis: {
                            categories: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: {
                                style: { colors: '#94a3b8', fontSize: '12px', fontWeight: 600 }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: (value) => "$" + (value / 1000) + "k",
                                style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 600 }
                            }
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4,
                            xaxis: { lines: { show: true } },
                            yaxis: { lines: { show: true } },
                            padding: { top: 0, right: 0, bottom: 0, left: 10 }
                        },
                        legend: { position: 'top', horizontalAlign: 'right', offsetY: -20 },
                        tooltip: {
                            y: { formatter: function (val) { return "$" + val.toLocaleString() } }
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#budgetChart"), options);
                    chart.render();
                },
                
                get filteredEmployees() {
                    return this.employees.filter(emp => {
                        const matchesSearch = emp.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                              emp.id.toLowerCase().includes(this.searchQuery.toLowerCase());
                        const matchesStatus = this.statusFilter === 'all' || emp.status === this.statusFilter;
                        const matchesDept = this.deptFilter === 'all' || emp.department === this.deptFilter;
                        
                        return matchesSearch && matchesStatus && matchesDept;
                    });
                },
                
                get pendingCount() {
                    return this.employees.filter(e => e.status === 'Pending').length;
                },
                
                get paidCount() {
                    return this.employees.filter(e => e.status === 'Paid').length;
                },
                
                get totalToPay() {
                    return this.employees.filter(e => e.status === 'Pending').reduce((sum, emp) => sum + emp.net, 0);
                },
                
                get totalPayrollCost() {
                    return this.employees.reduce((sum, emp) => sum + emp.net, 0);
                },
                
                get totalDeductions() {
                    return this.employees.reduce((sum, emp) => sum + emp.deductions, 0);
                },
                
                formatCurrency(value) {
                    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);
                },
                
                openAdjustModal(emp) {
                    this.selectedEmp = emp;
                    this.adjustModalOpen = true;
                },
                
                saveAdjustments(bonus, deductions) {
                    if (this.selectedEmp) {
                        this.selectedEmp.bonus = bonus;
                        this.selectedEmp.deductions = deductions;
                        this.selectedEmp.net = this.selectedEmp.base + bonus - deductions;
                    }
                    this.adjustModalOpen = false;
                },

                applyAutoBonus() {
                    if (this.selectedEmp) {
                        // Apply fixed $100 performance bonus
                        this.selectedEmp.bonus += 100;
                        this.selectedEmp.net = this.selectedEmp.base + this.selectedEmp.bonus - this.selectedEmp.deductions;
                    }
                },
                
                openPayslipModal(emp) {
                    this.selectedEmp = emp;
                    this.payslipModalOpen = true;
                },
                
                printPayslip() {
                    const printContents = document.getElementById('printablePayslip').innerHTML;
                    const printWindow = window.open('', '_blank', 'width=800,height=900');
                    printWindow.document.write(`
                        <html>
                        <head>
                            <title>Payslip - ${this.selectedEmp.name}</title>
                            <script src="https://cdn.tailwindcss.com"><\/script>
                            <style>body { -webkit-print-color-adjust: exact; print-color-adjust: exact; padding: 20px; }</style>
                        </head>
                        <body class="bg-white">
                            ${printContents}
                            <script>
                                window.onload = function() { window.print(); setTimeout(()=>window.close(), 500); }
                            <\/script>
                        </body>
                        </html>
                    `);
                    printWindow.document.close();
                },
                
                exportBankFormat() {
                    let csv = "Account Name,Bank Name,Account Number,Amount,Reference\n";
                    this.employees.forEach(emp => {
                        csv += `"${emp.name}","Chase Bank","123456789",${emp.net},"SALARY-JAN26"\n`;
                    });
                    
                    const blob = new Blob([csv], { type: 'text/csv' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.setAttribute('hidden', '');
                    a.setAttribute('href', url);
                    a.setAttribute('download', 'Bank_Export_Jan2026.csv');
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                },
                
                openRunPayrollModal() {
                    this.runPayrollModalOpen = true;
                },
                
                confirmRunPayroll() {
                    // This is where backend API call would happen
                    // For demo: Mark all as paid
                    this.employees.forEach(emp => emp.status = 'Paid');
                    this.runPayrollModalOpen = false;
                    
                    // Show success toast
                    this.showToast = true;
                    setTimeout(() => {
                        this.showToast = false;
                    }, 4000);
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
