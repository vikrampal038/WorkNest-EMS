    <!-- 6. Interactive Dashboard Preview Section -->
    <section id="dashboard-preview" class="py-24 bg-site-bg-alt border-t border-b border-slate-200/60" 
             x-data="{ currentTab: 'admin' }"
             x-on:switch-demo-tab.window="currentTab = $event.detail.tab">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-brand-600 uppercase bg-brand-50 px-3 py-1.5 rounded-md">
                    Live Demo
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-4">
                    Experience the dashboard interfaces
                </h2>
                <p class="text-slate-600">
                    Explore real dashboard screens custom-built for respective roles inside the organization. Click the tabs below.
                </p>
            </div>

            <!-- Tab Selectors -->
            <div class="flex flex-wrap items-center justify-center gap-3 mb-12 gsap-fade-up">
                <button @click="currentTab = 'admin'" 
                        :class="currentTab === 'admin' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Admin Portal
                </button>

                <button @click="currentTab = 'employee'" 
                        :class="currentTab === 'employee' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Employee View
                </button>

                <button @click="currentTab = 'payroll'" 
                        :class="currentTab === 'payroll' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Payroll Hub
                </button>

                <button @click="currentTab = 'attendance'" 
                        :class="currentTab === 'attendance' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Attendance Analytics
                </button>

                <button @click="currentTab = 'leaves'" 
                        :class="currentTab === 'leaves' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Leave Approvals
                </button>
            </div>

            <!-- Mock Presentation Container -->
            <div class="gsap-fade-up bg-white rounded-3xl border border-slate-200/80 shadow-2xl p-6 sm:p-8 min-h-105 transition-all duration-300">
                
                <!-- Tab: Admin Portal -->
                <div x-show="currentTab === 'admin'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Administrative Center</h4>
                            <p class="text-sm text-slate-500">Unify departments, track live check-ins, and authorize pending leave requests.</p>
                        </div>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold text-white bg-brand-600 rounded-lg hover:bg-brand-700">
                            Launch Admin Dashboard &rarr;
                        </a>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-6">
                        <!-- Stat 1 -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Acme Workforce</span>
                            <div class="text-2xl font-bold text-slate-800 mt-1">2,482 Employees</div>
                            <div class="text-xs text-emerald-600 font-semibold mt-1">+14 onboarding this week</div>
                        </div>
                        <!-- Stat 2 -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Leave Requests</span>
                            <div class="text-2xl font-bold text-indigo-600 mt-1">8 Pending</div>
                            <div class="text-xs text-slate-500 font-semibold mt-1">Requires admin verification</div>
                        </div>
                        <!-- Stat 3 -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Global Payouts</span>
                            <div class="text-2xl font-bold text-slate-800 mt-1">$394,200.00</div>
                            <div class="text-xs text-slate-500 font-semibold mt-1">Next pay run: June 30</div>
                        </div>
                    </div>

                    <!-- Pending Approval List inside Mock -->
                    <div class="border border-slate-100 rounded-2xl overflow-hidden mt-2">
                        <div class="bg-slate-50 p-4 border-b border-slate-100 text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Pending Leaves Verification
                        </div>
                        <div class="divide-y divide-slate-100">
                            <div class="p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs shrink-0">JD</div>
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-slate-800 leading-tight">Jane Doe</span>
                                        <span class="text-[11px] text-slate-400 mt-0.5 leading-tight">Marketing Lead &bull; Medical Leave</span>
                                    </div>
                                </div>
                                <div class="flex gap-2 w-full sm:w-auto justify-end mt-1 sm:mt-0">
                                    <button class="px-3 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold rounded-md">Approve</button>
                                    <button class="px-3 py-1 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-xs font-bold rounded-md">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab: Leave Approvals -->
                <div x-show="currentTab === 'leaves'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Leave Approvals & Tracking</h4>
                            <p class="text-sm text-slate-500">Authorize time-off requests, track employee leave balances, and review sick leave accruals.</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-650 border border-slate-200">
                            3 Pending Approvals
                        </span>
                    </div>

                    <!-- Leaves Interactive List -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/20">
                        <div class="bg-slate-50 p-4 border-b border-slate-100 flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider">
                            <span>Pending Leave Requests Queue</span>
                            <span class="text-indigo-600">Admin Action Required</span>
                        </div>
                        <div class="divide-y divide-slate-100" x-data="{ 
                            requests: [
                                { id: 1, name: 'Jane Doe', role: 'Marketing Lead', type: 'Medical Leave', duration: '3 Days (June 8 - June 10)', avatar: 'JD', status: 'pending' },
                                { id: 2, name: 'Alex Rivera', role: 'UX Designer', type: 'Vacation Leave', duration: '5 Days (June 12 - June 16)', avatar: 'AR', status: 'pending' },
                                { id: 3, name: 'Elena Rostova', role: 'Product Designer', type: 'Sick Leave', duration: '2 Days (June 5 - June 6)', avatar: 'ER', status: 'pending' }
                            ]
                        }">
                            <template x-for="req in requests" :key="req.id">
                                <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors hover:bg-slate-50/50" x-show="req.status === 'pending'">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-brand-100 border border-brand-200/50 text-brand-700 font-bold flex items-center justify-center text-sm font-mono" x-text="req.avatar"></div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800 text-sm" x-text="req.name"></span>
                                                <span class="px-2 py-0.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-750 text-[9px] font-bold" x-text="req.type"></span>
                                            </div>
                                            <span class="text-xs text-slate-450 mt-0.5" x-text="req.role + ' • ' + req.duration"></span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2.5 self-end sm:self-center">
                                        <button @click="req.status = 'approved'" type="button" class="px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-250 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                            Approve
                                        </button>
                                        <button @click="req.status = 'rejected'" type="button" class="px-4 py-2 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-250 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <!-- Empty State when all requests are approved/rejected -->
                            <div class="p-8 text-center text-slate-450 flex flex-col items-center justify-center" x-show="requests.filter(r => r.status === 'pending').length === 0" style="display: none;">
                                <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-500 mb-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Queue Cleared</span>
                                <span class="text-[11px]">All pending leave requests have been successfully verified.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Employee View -->
                <div x-show="currentTab === 'employee'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Employee Portal</h4>
                            <p class="text-sm text-slate-500">Record check-in timings, apply for leaves, and inspect monthly payroll slips.</p>
                        </div>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 border border-slate-200">
                            Launch Employee Portal
                        </a>
                    </div>

                    <div class="grid sm:grid-cols-12 gap-8 items-center">
                        <div class="sm:col-span-5 flex flex-col gap-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Daily Punch Card</span>
                            
                            <!-- Clock-In Action inside Mock -->
                            <div class="p-6 rounded-2xl border border-slate-100 bg-slate-50 flex flex-col items-center justify-center text-center">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Current Session</span>
                                <span class="text-2xl font-bold text-slate-800 font-mono mb-4">08 Hrs : 12 Min</span>
                                <button class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-rose-500/10 transition-colors">
                                    Clock Out
                                </button>
                            </div>
                        </div>

                        <div class="sm:col-span-7 flex flex-col gap-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Available Accruals</span>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-xl border border-slate-100">
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold">Sick Leave Accrued</span>
                                    <div class="text-xl font-bold text-slate-800 mt-1">12.5 Days</div>
                                </div>
                                <div class="p-4 rounded-xl border border-slate-100">
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold">Vacation Leaves</span>
                                    <div class="text-xl font-bold text-slate-800 mt-1">18 Days</div>
                                </div>
                            </div>
                            <div class="p-4 rounded-xl bg-brand-50 border border-brand-100 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-brand-900">Need time off?</span>
                                    <span class="text-[11px] text-brand-700">Submit a leave ticket to your manager.</span>
                                </div>
                                <button class="px-3.5 py-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-lg transition-colors">
                                    Apply Leave
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Payroll Hub -->
                <div x-show="currentTab === 'payroll'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Automated Payroll Hub</h4>
                            <p class="text-sm text-slate-500">Auto-calculate deductions, compute regional taxes, and approve pay cycles in bulk.</p>
                        </div>
                        <button class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Run Payroll Cycle
                        </button>
                    </div>

                    <div class="border border-slate-100 rounded-2xl overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="p-4">Employee</th>
                                    <th class="p-4">Days Present</th>
                                    <th class="p-4">Base Payout</th>
                                    <th class="p-4">Tax Ded.</th>
                                    <th class="p-4">Net Salary</th>
                                    <th class="p-4">Slip</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                <tr>
                                    <td class="p-4 font-semibold text-slate-800">Jane Cooper</td>
                                    <td class="p-4 text-slate-600">22 / 22 Days</td>
                                    <td class="p-4 text-slate-600">$5,400.00</td>
                                    <td class="p-4 text-rose-600">-$420.00</td>
                                    <td class="p-4 font-bold text-slate-800">$4,980.00</td>
                                    <td class="p-4 text-brand-600 font-bold cursor-pointer hover:underline">Download</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-slate-800">Robert Fox</td>
                                    <td class="p-4 text-slate-600">20 / 22 Days</td>
                                    <td class="p-4 text-slate-600">$4,200.00</td>
                                    <td class="p-4 text-rose-600">-$310.00</td>
                                    <td class="p-4 font-bold text-slate-800">$3,890.00</td>
                                    <td class="p-4 text-brand-600 font-bold cursor-pointer hover:underline">Download</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Attendance Analytics -->
                <div x-show="currentTab === 'attendance'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Workforce Attendance Analytics</h4>
                            <p class="text-sm text-slate-500">Track punctual check-ins, record absenteeism averages, and monitor overtime charts.</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                            May 2026 Reporting
                        </span>
                    </div>

                    <!-- Mini chart widget inside analytics tab -->
                    <div class="grid sm:grid-cols-12 gap-8 items-center">
                        <div class="sm:col-span-4 p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Punctuality Score</span>
                            <div class="text-3xl font-bold text-emerald-600 mt-1">96.8%</div>
                            <p class="text-xs text-slate-500 mt-2 leading-relaxed">Punctuality rate has scaled by 1.2% in comparison to last week.</p>
                        </div>

                        <div class="sm:col-span-8 p-5 rounded-2xl border border-slate-100">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-700">Late Punch-ins By Department</span>
                                <span class="text-[10px] text-slate-400">This Month</span>
                            </div>
                            <div class="flex flex-col gap-3">
                                <div>
                                    <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                        <span>Engineering</span>
                                        <span class="font-semibold text-slate-800">4% late</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" style="width: 4%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                        <span>Sales Operations</span>
                                        <span class="font-semibold text-slate-800">12% late</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 rounded-full" style="width: 12%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                        <span>HR & Admin</span>
                                        <span class="font-semibold text-slate-800">2% late</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" style="width: 2%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- 7. Employee Workflow Timeline -->
    <section class="py-24 bg-site-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-3 py-1.5 rounded-md">
                    Workflow Process
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                    From registry setup to pay run execution
                </h2>
                <p class="text-slate-600">
                    A streamlined journey constructed to onboard employees, collect attendance logs, audit leaves, and issue payrolls.
                </p>
            </div>

            <!-- Timeline Steps -->
            <div class="relative timeline-wrapper">
                <!-- Center Line for Large Screens -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-slate-200/60 rounded-full hidden lg:block overflow-hidden">
                    <div class="timeline-progress-bar w-full h-0"></div>
                </div>

                <div class="space-y-16 lg:space-y-24">
                    
                    <!-- Step 1 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-right">
                            <span class="text-sm font-bold text-brand-600">Step 01</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Company Portal Registry</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                HR administrators sign up on WorkNest, enter corporate information, structure company departments, and configure customized shifts.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            1
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Dashboard Visual</span>
                            <div class="h-10 w-3/4 mx-auto bg-slate-200/50 rounded-md mt-2 flex items-center justify-center text-[10px] text-slate-400">acme.worknest.io</div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row-reverse items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-left">
                            <span class="text-sm font-bold text-brand-600">Step 02</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Invite and Onboard Personnel</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Upload a CSV containing staff rosters or transmit individualized registration invitations. Staff register and log in to activate their accounts.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            2
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Email Invitation Sent</span>
                            <div class="h-10 w-4/5 mx-auto bg-slate-200/50 rounded-md mt-2 flex items-center justify-center text-[10px] text-slate-400">Welcome to Acme Workspace</div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-right">
                            <span class="text-sm font-bold text-brand-600">Step 03</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Automated Attendance Tracking</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Employees record check-ins and check-outs daily via browser or mobile endpoints, creating precise timesheet records automatically.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            3
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Check-in Stamp</span>
                            <div class="h-10 w-2/3 mx-auto bg-emerald-50 rounded-md mt-2 flex items-center justify-center text-[10px] text-emerald-600 font-bold">Checked In: 09:00 AM</div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row-reverse items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-left">
                            <span class="text-sm font-bold text-brand-600">Step 04</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Audit Leaves & Requests</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Employees submit leave tickets. Managers inspect request contexts and approve or decline in real time, updating the central calendar.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            4
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Request Accrued</span>
                            <div class="h-10 w-3/4 mx-auto bg-indigo-50 rounded-md mt-2 flex items-center justify-center text-[10px] text-indigo-600 font-bold">Leave Approved (Jane Doe)</div>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-right">
                            <span class="text-sm font-bold text-brand-600">Step 05</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Execute Automated Pay Run</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                The system maps logs, counts absences, constructs tax profiles, computes allowances, processes salaries, and auto-issues PDF slips.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            5
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Payroll Cycle Complete</span>
                            <div class="h-10 w-4/5 mx-auto bg-emerald-50 rounded-md mt-2 flex items-center justify-center text-[10px] text-emerald-600 font-bold">Salary Slip Generated</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>