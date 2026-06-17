    <!-- 10. Live Sandbox Playground Modal Overlay -->
    <div x-show="sandboxModalOpen" 
         class="fixed inset-0 z-100 flex items-center justify-center p-4 sm:p-6 md:p-8 lg:p-12"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="sandboxModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sandboxModalOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs"></div>

        <!-- Dashboard Frame -->
        <div x-show="sandboxModalOpen"
             x-transition:enter="transition ease-out duration-305"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative w-full max-w-5xl h-[80vh] sm:h-[85vh] bg-white border border-slate-200/50 shadow-2xl rounded-3xl overflow-hidden flex flex-col z-10">
            
            <!-- Window Topbar -->
            <div class="bg-slate-50 px-5 py-4 border-b border-slate-200/60 flex items-center justify-between gap-4 select-none">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-rose-400 border border-rose-500/10"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-400 border border-amber-500/10"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-400 border border-emerald-500/10"></span>
                    <span class="text-[10px] font-bold text-slate-400 ml-4 font-mono bg-white border border-slate-200 px-2.5 py-0.5 rounded-md">worknest.io/sandbox/playground</span>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-200 text-indigo-750 text-[9px] font-bold">
                        Interactive Live Sandbox
                    </span>
                    <button @click="sandboxModalOpen = false" type="button" class="text-slate-400 hover:text-slate-650 p-1.5 rounded-lg hover:bg-slate-200/50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Main Split Panels -->
            <div class="flex flex-col md:flex-row flex-1 overflow-hidden">
                
                <!-- Sidebar tabs list -->
                <div class="w-full md:w-56 border-b md:border-b-0 md:border-r border-slate-200/60 bg-slate-50/50 p-3 sm:p-4 flex flex-row md:flex-col gap-1.5 overflow-x-auto md:overflow-y-auto md:overflow-x-visible select-none shrink-0 scrollbar-none">
                    <span class="px-2.5 py-2 text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 hidden md:block">Modules</span>
                    
                    <!-- Employees Tab -->
                    <button @click="sandboxTab = 'employees'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'employees' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="truncate">Staff Directory</span>
                    </button>

                    <!-- Attendance Tab -->
                    <button @click="sandboxTab = 'attendance'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'attendance' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">Geo-Attendance</span>
                    </button>

                    <!-- Payroll Tab -->
                    <button @click="sandboxTab = 'payroll'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'payroll' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">Payroll Hub</span>
                    </button>

                    <!-- Leaves Tab -->
                    <button @click="sandboxTab = 'leaves'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'leaves' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="truncate flex items-center justify-between gap-2 w-full">
                            <span>Leaves Manager</span>
                            <span x-show="sandboxLeavesCount > 0" class="text-[9px] font-extrabold px-1.5 py-0.5 rounded-full" :class="sandboxTab === 'leaves' ? 'bg-white text-brand-650' : 'bg-rose-500 text-white'" x-text="sandboxLeavesCount"></span>
                        </span>
                    </button>

                    <!-- Salary Slips Tab -->
                    <button @click="sandboxTab = 'slips'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'slips' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="truncate">Salary Slips</span>
                    </button>

                    <!-- Role Permissions Tab -->
                    <button @click="sandboxTab = 'permissions'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'permissions' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="truncate">Access Controls</span>
                    </button>
                </div>

                <!-- Content Panel -->
                <div class="flex-1 p-5 sm:p-6 overflow-y-auto bg-white">
                    
                    <!-- Tab 1: Staff Directory -->
                    <div x-show="sandboxTab === 'employees'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="flex flex-col gap-6">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="text-base font-extrabold text-slate-850">Acme Staff Registry</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Manage user profiles and roles in your current company branch.</p>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 font-mono bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl self-start sm:self-center" x-text="sandboxEmployees.length + ' Employees Registered'"></span>
                        </div>

                        <!-- Add Employee Form Panel -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50">
                            <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider mb-3 block">Add Sandbox Staff Member</span>
                            <form @submit.prevent="addSandboxEmployee()" class="grid grid-cols-1 sm:grid-cols-12 gap-3.5 items-end">
                                <div class="sm:col-span-5">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Employee Name</label>
                                    <input type="text" required x-model="sandboxNewEmp.name" class="w-full px-3 py-2 rounded-xl border border-slate-250 bg-white text-xs focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:outline-hidden" placeholder="e.g. John Doe">
                                </div>
                                <div class="sm:col-span-4">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Role / Position</label>
                                    <input type="text" required x-model="sandboxNewEmp.role" class="w-full px-3 py-2 rounded-xl border border-slate-250 bg-white text-xs focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:outline-hidden" placeholder="e.g. Project Lead">
                                </div>
                                <div class="sm:col-span-3">
                                    <button type="submit" class="w-full py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-800 transition-all cursor-pointer">
                                        Add Member
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Employees Cards Grid -->
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <template x-for="emp in sandboxEmployees">
                                <div class="p-4 rounded-2xl border border-slate-200 hover:border-slate-300 hover:shadow-xs transition-all duration-300 flex items-center gap-3.5">
                                    <img :src="emp.avatar" class="w-10 h-10 rounded-full border border-slate-200 object-cover">
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-xs font-bold text-slate-850 truncate" x-text="emp.name"></h5>
                                        <p class="text-[10px] text-slate-450 mt-0.5 truncate" x-text="emp.role"></p>
                                    </div>
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-full shrink-0"
                                          :class="emp.status === 'Checked In' ? 'bg-emerald-50 text-emerald-700 border border-emerald-250' : emp.status === 'Checked Out' ? 'bg-slate-50 text-slate-650 border border-slate-200' : 'bg-amber-50 text-amber-700 border border-amber-250'"
                                          x-text="emp.status"></span>
                                </div>
                            </template>
                        </div>

                    </div>

                    <!-- Tab 2: Geo-Attendance -->
                    <div x-show="sandboxTab === 'attendance'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Web Sandbox Clock-In Terminal</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Test geofenced clocking triggers in real-time right from your browser.</p>
                        </div>

                        <!-- Control Center Grid -->
                        <div class="grid sm:grid-cols-12 gap-6">
                            
                            <!-- Left: Clock Action -->
                            <div class="sm:col-span-5 p-5 rounded-2xl border border-slate-200/80 bg-slate-50/50 flex flex-col items-center justify-center text-center gap-4">
                                <div class="w-12 h-12 rounded-full border flex items-center justify-center text-lg"
                                     :class="sandboxAttendanceState === 'checked-in' ? 'bg-emerald-50 border-emerald-200 text-emerald-600' : 'bg-slate-100 border-slate-250 text-slate-500'">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11V5a3 3 0 00-6 0v6c0 1.68.57 3.21 1.52 4.43M12 11c0-3.517 1.009-6.799 2.753-9.571m3.44 2.04l-.054.09A13.916 13.916 0 0015 11v6c0 1.68-.57 3.21-1.52 4.43M12 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                
                                <div>
                                    <span class="text-[9.5px] uppercase font-black text-slate-400 tracking-wider">Terminal Status</span>
                                    <h5 class="text-sm font-bold text-slate-850 mt-0.5" 
                                        x-text="sandboxAttendanceState === 'checked-in' ? 'Successfully Clocked In' : sandboxAttendanceState === 'loading' ? 'Verifying location...' : 'Clocked Out'"></h5>
                                </div>

                                <button @click="toggleSandboxClock()" type="button" 
                                        class="w-full py-3 text-xs font-bold rounded-xl transition-all cursor-pointer inline-flex items-center justify-center gap-2"
                                        :class="sandboxAttendanceState === 'checked-in' ? 'bg-rose-600 hover:bg-rose-700 text-white shadow-md shadow-rose-500/10' : sandboxAttendanceState === 'loading' ? 'bg-slate-300 text-slate-500 cursor-not-allowed' : 'bg-brand-600 hover:bg-brand-700 text-white shadow-md shadow-brand-500/10'"
                                        :disabled="sandboxAttendanceState === 'loading'">
                                    <span class="w-3.5 h-3.5 rounded-full border-2 border-white/20 border-t-white animate-spin" x-show="sandboxAttendanceState === 'loading'"></span>
                                    <span x-text="sandboxAttendanceState === 'checked-in' ? 'Clock Out Now' : sandboxAttendanceState === 'loading' ? 'Locating...' : 'Geo-Clock In Now'"></span>
                                </button>
                            </div>

                            <!-- Right: Terminal Logs -->
                            <div class="sm:col-span-7 flex flex-col gap-3">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Attendance Activity Log</span>
                                <div class="border border-slate-200 rounded-2xl bg-slate-950 p-4.5 font-mono text-[11px] text-slate-350 h-44 overflow-y-auto flex flex-col gap-2.5">
                                    <template x-for="log in sandboxCheckInLogs">
                                        <div class="flex gap-2">
                                            <span class="text-slate-500" x-text="'[' + log.time + ']'"></span>
                                            <span class="text-indigo-300" x-text="log.event"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 3: Payroll Hub -->
                    <div x-show="sandboxTab === 'payroll'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="text-base font-extrabold text-slate-850">Automated Payroll Hub</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Calculate shifts, tax brackets, and trigger pay disbursements.</p>
                            </div>
                            <button @click="runSandboxPayroll()" type="button" 
                                    class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all cursor-pointer inline-flex items-center justify-center gap-2"
                                    :disabled="sandboxPayrollLoading">
                                <span class="w-3.5 h-3.5 rounded-full border-2 border-white/20 border-t-white animate-spin" x-show="sandboxPayrollLoading"></span>
                                <span x-text="sandboxPayrollLoading ? 'Simulating Audit...' : sandboxPayrollGenerated ? 'Recalculate Payroll' : 'Calculate Monthly Payroll'"></span>
                            </button>
                        </div>

                        <!-- Main Screen State: Empty / loading / complete -->
                        <div>
                            <!-- Placeholder Initial State -->
                            <div x-show="!sandboxPayrollLoading && !sandboxPayrollGenerated" class="p-10 border border-dashed border-slate-250 rounded-2xl flex flex-col items-center justify-center text-center">
                                <svg class="w-8 h-8 text-slate-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h5 class="text-xs font-bold text-slate-800">Payroll Calculation Required</h5>
                                <p class="text-[11px] text-slate-500 mt-1 max-w-xs">Run the calculator above to trigger shift audit checks and compile branch payouts.</p>
                            </div>

                            <!-- Loading State -->
                            <div x-show="sandboxPayrollLoading" class="p-10 border border-slate-200 rounded-2xl flex flex-col items-center justify-center text-center bg-slate-50/50">
                                <div class="w-7 h-7 rounded-full border-2 border-brand-600 border-t-transparent animate-spin mb-4"></div>
                                <h5 class="text-xs font-bold text-slate-800">Compiling regional tax tables</h5>
                                <p class="text-[11px] text-slate-500 mt-1">Checking employee locations against legal local allowances...</p>
                            </div>

                            <!-- Generated Table state -->
                            <div x-show="sandboxPayrollGenerated" class="border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between text-xs font-bold text-slate-800">
                                    <span>Compiled Pay Register — Active Period</span>
                                    <span class="text-emerald-600 font-extrabold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disbursed
                                    </span>
                                </div>
                                
                                <div class="divide-y divide-slate-100 bg-white">
                                    <div class="px-4 py-3 flex items-center justify-between gap-4 text-xs">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-brand-100 flex items-center justify-center text-[9px] font-bold text-brand-700">SJ</div>
                                            <span class="font-bold text-slate-800">Sarah Jenkins</span>
                                        </div>
                                        <div class="flex items-center gap-6 font-mono text-[11px]">
                                            <span class="text-slate-450">160h logged</span>
                                            <span class="font-bold text-slate-800">$9,400.00</span>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 flex items-center justify-between gap-4 text-xs">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-[9px] font-bold text-indigo-700">MC</div>
                                            <span class="font-bold text-slate-800">Marcus Chen</span>
                                        </div>
                                        <div class="flex items-center gap-6 font-mono text-[11px]">
                                            <span class="text-slate-450">168h logged</span>
                                            <span class="font-bold text-slate-800">$8,960.00</span>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 flex items-center justify-between gap-4 text-xs">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-violet-100 flex items-center justify-center text-[9px] font-bold text-violet-700">ER</div>
                                            <span class="font-bold text-slate-800">Elena Rostova</span>
                                        </div>
                                        <div class="flex items-center gap-6 font-mono text-[11px]">
                                            <span class="text-slate-450">152h logged</span>
                                            <span class="font-bold text-slate-800">$6,840.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 4: Leaves Manager -->
                    <div x-show="sandboxTab === 'leaves'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Leaves & Time-Off Approvals</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Review, approve, or reject employee leave and PTO requests.</p>
                        </div>

                        <!-- Requests Manager screen -->
                        <div>
                            <!-- Case A: Pending requests -->
                            <div x-show="!sandboxLeavesApproved" class="flex flex-col gap-3.5">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pending Time-Off Actions</span>
                                <div class="p-5 border border-slate-200 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-slate-350 transition-all duration-300">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-full bg-brand-100 border border-brand-200 flex items-center justify-center font-bold text-xs text-brand-700 shrink-0">
                                            SJ
                                        </div>
                                        <div>
                                            <h5 class="text-xs font-bold text-slate-850">Sarah Jenkins • VP Operations</h5>
                                            <p class="text-[10px] font-bold text-brand-600 mt-0.5">Annual PTO Request (5 Business Days)</p>
                                            <p class="text-[10.5px] text-slate-500 mt-1 max-w-md leading-relaxed">
                                                "Requesting annual leave for family travel. Marcus Chen will oversee my active tasks while I am out of office."
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-row sm:flex-col gap-2 shrink-0">
                                        <button @click="sandboxLeavesApproved = true; sandboxLeavesCount = 0" type="button" class="px-4 py-2 bg-emerald-650 hover:bg-emerald-700 text-slate-700 text-xs font-bold rounded-xl cursor-pointer shadow-md shadow-emerald-500/10 transition-all text-center">
                                            Approve Leave
                                        </button>
                                        <button @click="sandboxLeavesApproved = true; sandboxLeavesCount = 0" type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl cursor-pointer transition-all text-center">
                                            Reject Leave
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Case B: Empty / all requests approved -->
                            <div x-show="sandboxLeavesApproved" class="p-10 border border-dashed border-slate-250 rounded-2xl flex flex-col items-center justify-center text-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-250 flex items-center justify-center text-emerald-500 mb-3 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h5 class="text-xs font-bold text-slate-800">All Requests Settled</h5>
                                <p class="text-[11px] text-slate-500 mt-1 max-w-xs">No pending leave requests require action at this time.</p>
                                <button @click="sandboxLeavesApproved = false; sandboxLeavesCount = 1" type="button" class="mt-4 px-3 py-1.5 bg-slate-900 text-white font-bold text-[10.5px] rounded-lg cursor-pointer">
                                    Reset Requests
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 5: Salary Slips -->
                    <div x-show="sandboxTab === 'slips'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Digital Salary Slips</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Select a team member to generate, inspect, and sign digital salary slips.</p>
                        </div>

                        <!-- Selector & Preview Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <!-- Left panel: Employee selection list -->
                            <div class="md:col-span-5 flex flex-col gap-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Select Employee</span>
                                <div class="flex flex-col gap-2">
                                    <template x-for="emp in sandboxEmployees">
                                        <button @click="sandboxSelectedEmpForSlip = emp.name; sandboxSlipSuccess = false" 
                                                type="button" 
                                                class="p-3 text-left border rounded-2xl flex items-center justify-between transition-all duration-200 cursor-pointer"
                                                :class="sandboxSelectedEmpForSlip === emp.name ? 'border-brand-500 bg-brand-50/30' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                            <div class="flex items-center gap-2.5">
                                                <img :src="emp.avatar" class="w-8 h-8 rounded-full border border-slate-200 object-cover">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-850" x-text="emp.name"></span>
                                                    <span class="text-[10px] text-slate-450 mt-0.5" x-text="emp.role"></span>
                                                </div>
                                            </div>
                                            <svg x-show="sandboxSelectedEmpForSlip === emp.name" class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Right panel: Interactive glass payslip preview -->
                            <div class="md:col-span-7 flex flex-col gap-3">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Active Slip Preview</span>
                                <div class="border border-slate-200 rounded-2xl bg-slate-50/50 p-5 flex flex-col justify-between min-h-64 relative overflow-hidden">
                                    
                                    <!-- Payslip Branding & Header -->
                                    <div class="flex items-start justify-between border-b border-slate-200/80 pb-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-slate-800 tracking-tight">WORKNEST CORP.</span>
                                            <span class="text-[9px] text-slate-450 font-mono mt-0.5">PAY PERIOD: MAY 2026</span>
                                        </div>
                                        <span class="px-2.5 py-1 text-[8.5px] font-bold rounded-lg uppercase tracking-wider"
                                              :class="sandboxSlipSuccess ? 'bg-emerald-50 text-emerald-700 border border-emerald-250 animate-bounce' : 'bg-slate-100 text-slate-600 border border-slate-200/60'">
                                            <span x-text="sandboxSlipSuccess ? 'Signed & Disbursed' : 'Draft / Unsigned'"></span>
                                        </span>
                                    </div>

                                    <!-- Employee details & breakdown -->
                                    <div class="py-4 flex flex-col gap-3.5">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500">Employee Name:</span>
                                            <span class="font-bold text-slate-850" x-text="sandboxSelectedEmpForSlip"></span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500">Hourly logs:</span>
                                            <span class="font-bold text-slate-850 font-mono" x-text="sandboxSelectedEmpForSlip === 'Sarah Jenkins' ? '160 hours' : sandboxSelectedEmpForSlip === 'Marcus Chen' ? '168 hours' : '152 hours'"></span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs border-t border-dashed border-slate-200 pt-3">
                                            <span class="font-bold text-slate-700">Gross Payout:</span>
                                            <span class="font-extrabold text-slate-900 font-mono" x-text="sandboxSelectedEmpForSlip === 'Sarah Jenkins' ? '$9,400.00' : sandboxSelectedEmpForSlip === 'Marcus Chen' ? '$8,960.00' : '$6,840.00'"></span>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="border-t border-slate-200/80 pt-4 flex items-center justify-end">
                                        <button @click="generateSandboxSlip()" 
                                                type="button" 
                                                class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl cursor-pointer transition-all duration-300 inline-flex items-center gap-2"
                                                :disabled="sandboxSlipGenerating">
                                            <span class="w-3.5 h-3.5 rounded-full border-2 border-white/20 border-t-white animate-spin" x-show="sandboxSlipGenerating"></span>
                                            <svg x-show="!sandboxSlipGenerating && !sandboxSlipSuccess" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span x-text="sandboxSlipGenerating ? 'Signing & compiling...' : sandboxSlipSuccess ? 'Disbursed Successfully' : 'Generate & Sign Payslip'"></span>
                                        </button>
                                    </div>
                                    
                                    <!-- Toast overlay inside panel -->
                                    <div x-show="sandboxSlipSuccess" 
                                         style="display: none;"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-2"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="absolute bottom-4 left-4 right-4 bg-emerald-950 text-emerald-300 text-[10.5px] font-bold py-2.5 px-4 rounded-xl shadow-lg border border-emerald-800 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span>PDF Payslip compiled and signed. Sent to employee workspace.</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 6: Role Permissions -->
                    <div x-show="sandboxTab === 'permissions'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Role Permissions & Governance</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Toggle access rights for different system profiles in this mock organization.</p>
                        </div>

                        <!-- Main Governance Center -->
                        <div class="flex flex-col gap-6">
                            
                            <!-- Role Switcher pills -->
                            <div class="flex border-b border-slate-200 pb-1 gap-4 select-none">
                                <button @click="sandboxSelectedRole = 'admin'" 
                                        type="button" 
                                        class="pb-3 text-xs font-bold relative transition-colors cursor-pointer"
                                        :class="sandboxSelectedRole === 'admin' ? 'text-brand-600' : 'text-slate-500 hover:text-slate-800'">
                                    <span>Administrator</span>
                                    <span x-show="sandboxSelectedRole === 'admin'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-600 rounded-full"></span>
                                </button>
                                <button @click="sandboxSelectedRole = 'manager'" 
                                        type="button" 
                                        class="pb-3 text-xs font-bold relative transition-colors cursor-pointer"
                                        :class="sandboxSelectedRole === 'manager' ? 'text-brand-600' : 'text-slate-500 hover:text-slate-800'">
                                    <span>Manager</span>
                                    <span x-show="sandboxSelectedRole === 'manager'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-600 rounded-full"></span>
                                </button>
                                <button @click="sandboxSelectedRole = 'employee'" 
                                        type="button" 
                                        class="pb-3 text-xs font-bold relative transition-colors cursor-pointer"
                                        :class="sandboxSelectedRole === 'employee' ? 'text-brand-600' : 'text-slate-500 hover:text-slate-800'">
                                    <span>General Employee</span>
                                    <span x-show="sandboxSelectedRole === 'employee'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-600 rounded-full"></span>
                                </button>
                            </div>

                            <!-- Permissions List with Switch Toggles -->
                            <div class="divide-y divide-slate-100 bg-slate-50/30 rounded-2xl border border-slate-200 overflow-hidden">
                                
                                <!-- Permission 1: Payroll calculations -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Access Payroll Calculation Modules</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Allows running payout cycles, auditing tax sheets, and downloading salary register.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'payroll')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].payroll ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].payroll ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                                <!-- Permission 2: Shift log overrides -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Override & Edit Attendance Logs</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Enables overriding employee check-in times, location warnings, and manually writing shift records.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'shifts')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].shifts ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].shifts ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                                <!-- Permission 3: Approve/Reject Leaves -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Approve/Reject Time-off Requests</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Authorizes deciding PTO allocations, medical leave status, and general off-duty sheets.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'leaves')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].leaves ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].leaves ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                                <!-- Permission 4: Configure system settings -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Modify System Configurations</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Enables modifying integration settings, workspace database isolation rules, and metadata structures.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'system')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].system ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].system ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                            </div>

                            <!-- Save indicator alert -->
                            <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-[11px] text-slate-650 flex items-center gap-2.5 font-medium">
                                <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Access rules update instantly in the sandbox playground. Changes are not persisted to database.</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>