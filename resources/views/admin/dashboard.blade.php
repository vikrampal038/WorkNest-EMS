<x-app-layout>
    <!-- Background Accents for depth -->
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/50 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>
    <div class="fixed bottom-0 left-0 -z-10 w-[600px] h-[600px] bg-emerald-50/50 rounded-full blur-[100px] mix-blend-multiply pointer-events-none -translate-x-1/4 translate-y-1/4"></div>

    <div class="flex flex-col gap-5 pb-6">
        
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Dashboard Overview</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Here's what's happening at WorkNest today.</p>
            </div>
            <div class="flex gap-2.5">
                <button onclick="openReportModal()" class="px-4 py-1.5 bg-white border border-slate-200/60 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm">
                    Generate Report
                </button>
                <button onclick="openModal('add')" class="px-4 py-1.5 bg-brand-600 rounded-lg text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm">
                    + Add Employee
                </button>
            </div>
        </div>

        <!-- KPI Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1 -->
            <div class="group relative bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-2 relative z-10">
                    <div class="p-2.5 bg-brand-100 text-brand-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="px-2 py-0.5 text-[11px] font-black tracking-wider text-emerald-700 bg-emerald-100 rounded-md">+8.2%</span>
                </div>
                <div class="relative z-10">
                    <p class="text-xs text-slate-500 font-bold mb-0.5">Total Employees</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">148</h3>
                        <div id="spark1" class="w-20 -mb-2"></div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="group relative bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -z-10 transition-transform group-hover:scale-110"></div>
                <div class="flex justify-between items-start mb-2 relative z-10">
                    <div class="p-2.5 bg-emerald-100 text-emerald-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="px-2 py-0.5 text-[11px] font-black tracking-wider text-emerald-700 bg-emerald-100 rounded-md">+2.1%</span>
                </div>
                <div class="relative z-10">
                    <p class="text-xs text-slate-500 font-bold mb-0.5">Avg. Attendance</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">94.5%</h3>
                        <div id="spark2" class="w-20 -mb-2"></div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="group relative bg-brand-900 rounded-2xl p-5 shadow-md hover:-translate-y-0.5 transition-all duration-300 overflow-hidden text-white border border-brand-800 flex flex-col justify-between">
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-brand-500/30 rounded-full blur-xl"></div>
                <div class="flex justify-between items-start mb-2 relative z-10">
                    <div class="p-2.5 bg-white/10 text-white rounded-xl backdrop-blur-sm border border-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="px-2 py-0.5 text-[11px] font-black tracking-wider text-white bg-white/20 rounded-md">JAN 15</span>
                </div>
                <div class="relative z-10">
                    <p class="text-xs text-brand-100 font-bold mb-0.5 relative z-10">Upcoming Payroll</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-2xl font-black tracking-tight relative z-10">$68,450<span class="text-base text-brand-300">.00</span></h3>
                        <div id="spark3" class="w-20 -mb-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            
            <!-- Left: Chart & Complex Widget -->
            <div class="lg:col-span-2 flex flex-col gap-5">
                <!-- Important Action / Status Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Progress Card -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="p-2.5 bg-amber-100 text-amber-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="px-2 py-0.5 text-[11px] font-black tracking-wider text-amber-700 bg-amber-100 rounded-md">IN PROGRESS</span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold mb-1.5">Payroll Processing</p>
                            <!-- Custom Progress Bar -->
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-500 w-[65%] rounded-full relative">
                                    <div class="absolute top-0 right-0 bottom-0 w-8 bg-gradient-to-r from-transparent to-white/30"></div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-1.5">
                                <span class="text-[10px] font-bold text-slate-400">Step 3 of 5</span>
                                <span class="text-xs font-black text-slate-900">65%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notice & Broadcast Card -->
                    <div onclick="openAnnouncementModal()" class="bg-indigo-50/50 rounded-2xl p-5 border border-indigo-100 shadow-sm flex flex-col justify-between group cursor-pointer hover:-translate-y-0.5 hover:bg-indigo-50/80 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-24 h-24 bg-indigo-500/5 rounded-full blur-lg"></div>
                        
                        <div class="flex justify-between items-start mb-3">
                            <div class="p-2.5 bg-indigo-100 text-indigo-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            </div>
                            <span id="announcementBadge" class="px-2 py-0.5 text-[11px] font-black tracking-wider text-indigo-700 bg-indigo-100 rounded-md">ANNOUNCEMENT</span>
                        </div>
                        
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold mb-1" id="announcementDate">Today, 10:15 AM</p>
                            <h3 class="text-sm font-black text-slate-900 line-clamp-1 group-hover:text-indigo-600 transition-colors" id="announcementTitle">Town Hall meeting scheduled for Friday</h3>
                            <p class="text-xs text-slate-500 font-medium line-clamp-2 mt-1" id="announcementDesc">All team members are requested to join us in the main hall at 4:00 PM for the quarterly company updates and Q&A session.</p>
                        </div>
                    </div>
                </div>

                <!-- Attendance Trend Chart -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="flex items-center justify-between mb-2 relative z-10">
                        <div>
                            <h2 class="text-base font-black text-slate-900 tracking-tight">Attendance Trend</h2>
                            <p class="text-[11px] font-bold text-slate-500">Last 7 days performance</p>
                        </div>
                        <select class="bg-slate-50 border border-slate-200 text-slate-700 text-[11px] font-bold rounded-lg focus:ring-brand-500 focus:border-brand-500 px-2 py-1 outline-none">
                            <option>This Week</option>
                            <option>Last Week</option>
                            <option>This Month</option>
                        </select>
                    </div>
                    <div id="attendanceChart" class="w-full h-[240px] relative z-10 -ml-2"></div>
                </div>

                <!-- Secondary Analytics Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Department Headcount -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div>
                                <h2 class="text-base font-black text-slate-900 tracking-tight">Department Headcount</h2>
                                <p class="text-[11px] font-bold text-slate-500">Distribution of workforce</p>
                            </div>
                        </div>
                        <div id="departmentChart" class="w-full h-[220px] relative z-10"></div>
                    </div>
                    
                    <!-- Leave Utilization -->
                    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4 relative z-10">
                            <div>
                                <h2 class="text-base font-black text-slate-900 tracking-tight">Leave Utilization</h2>
                                <p class="text-[11px] font-bold text-slate-500">Monthly leave breakdown</p>
                            </div>
                        </div>
                        <div id="leaveChart" class="w-full h-[220px] relative z-10"></div>
                    </div>
                </div>
            </div>

            <!-- Right: Live Feed / Lists -->
            <div class="lg:col-span-1 flex flex-col gap-5">
                
                <!-- Employee Status Directory -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col h-full overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-black text-slate-900 tracking-tight">Live Status</h2>
                        <button class="text-[11px] font-bold text-brand-600 hover:text-brand-700">View All</button>
                    </div>

                    <div id="liveStatusContainer" class="space-y-1 overflow-y-auto overflow-x-hidden flex-1 pr-1 w-full" style="max-height: calc(100% - 2rem);">
                        <!-- Rendered dynamically by JavaScript -->
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Premium Toast Container -->
    <div id="toastContainer" class="fixed top-5 right-5 z-[200] flex flex-col gap-3 pointer-events-none"></div>

    <!-- Generate Report Modal -->
    <div id="reportModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Premium Glass Backdrop -->
        <div id="reportModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="closeReportModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6 lg:p-8">
                <div id="reportModalPanel" class="relative w-full max-w-lg transform bg-white rounded-3xl shadow-2xl border border-slate-100/80 text-left transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 my-8">
                    <!-- Header -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100/50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Generate Report</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Select filters and download reports.</p>
                            </div>
                        </div>
                        <button onclick="closeReportModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-xl transition-all border border-transparent hover:border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form id="reportForm" onsubmit="downloadReport(event)" class="m-0">
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Report Type</label>
                                <select id="reportType" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer pr-10">
                                    <option value="employees">Employee Directory Report</option>
                                    <option value="attendance">Attendance Summary Report</option>
                                    <option value="leaves">Leave Utilization Report</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Format</label>
                                    <select id="reportFormat" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                        <option value="xlsx">Excel (.xlsx)</option>
                                        <option value="csv">CSV (.csv)</option>
                                        <option value="pdf">PDF Document (.pdf)</option>
                                        <option value="json">JSON Format (.json)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Period</label>
                                    <select id="reportPeriod" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                        <option value="current">Current Month</option>
                                        <option value="previous">Previous Month</option>
                                        <option value="ytd">Year to Date</option>
                                        <option value="custom">Custom Calendar (Select Dates)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Custom Date Range Picker Container -->
                            <div id="customDateRangeContainer" class="hidden grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-slate-100 transition-all duration-300">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Start Date</label>
                                    <input type="date" id="reportStartDate" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">End Date</label>
                                    <input type="date" id="reportEndDate" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="bg-slate-50/50 px-6 py-4 flex items-center justify-end gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="button" onclick="closeReportModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-brand-600 border border-transparent text-sm font-bold text-white rounded-xl shadow-sm hover:bg-brand-700 hover:shadow-md transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Export & Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Announcement Modal -->
    <div id="announcementModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Premium Glass Backdrop -->
        <div id="announcementModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="closeAnnouncementModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6 lg:p-8">
                <div id="announcementModalPanel" class="relative w-full max-w-lg transform bg-white rounded-3xl shadow-2xl border border-slate-100/80 text-left transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 my-8">
                    <!-- Header -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100/50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Create Announcement</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Broadcast an update to all organization employees.</p>
                            </div>
                        </div>
                        <button onclick="closeAnnouncementModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-xl transition-all border border-transparent hover:border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form id="announcementForm" onsubmit="postAnnouncement(event)" class="m-0">
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Announcement Title <span class="text-rose-500">*</span></label>
                                <input type="text" id="annTitle" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. Town Hall Meeting Scheduled">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Category</label>
                                <select id="annCategory" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                    <option value="general">General Notice</option>
                                    <option value="hr">HR Update</option>
                                    <option value="event">Company Event</option>
                                    <option value="alert">Alert / Emergency</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Description / Content <span class="text-rose-500">*</span></label>
                                <textarea id="annDesc" required rows="4" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400 resize-none" placeholder="Provide detailed announcement details..."></textarea>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="bg-slate-50/50 px-6 py-4 flex items-center justify-end gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="button" onclick="closeAnnouncementModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-brand-600 border border-transparent text-sm font-bold text-white rounded-xl shadow-sm hover:bg-brand-700 hover:shadow-md transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                Broadcast Notice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Popup Modal (Add Employee) -->
    <div id="dynamicModal" class="fixed inset-0 z-100 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Premium Glass Backdrop -->
        <div id="modalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="closeModal()"></div>

        <!-- Scrollable container wrapper -->
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <!-- Centering wrapper -->
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 md:p-8 text-center">
                <!-- Modal panel -->
                <div id="modalPanel" class="relative w-full max-w-6xl transform bg-white rounded-3xl shadow-2xl border border-slate-100/80 text-left transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 my-8">
                    
                    <!-- Header Section -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 shadow-sm border border-brand-100/50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight" id="modalTitle">Add New Employee</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Add a new employee to the organization directory.</p>
                            </div>
                        </div>
                        <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-xl transition-all border border-transparent hover:border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form wrapping the entire body & footer -->
                    <form id="employeeForm" onsubmit="saveEmployee(event)" class="m-0">
                        
                        <!-- Body Section (Internally scrollable, styled visual scrollbar) -->
                        <div class="max-h-[63vh] overflow-y-auto scrollbar-premium bg-slate-50/40 py-6 pl-6 pr-4 sm:py-8 sm:pl-8 sm:pr-6 space-y-6 border-b border-slate-100" style="max-height: 63vh; overflow-y: auto;">
                            <div id="employeeFormContent" class="space-y-6">
                            
                            <!-- Profile Summary Card (Top Banner) -->
                            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
                                <!-- Photo Upload area -->
                                <div class="flex items-center gap-4 w-full md:w-auto">
                                    <div class="relative group shrink-0">
                                        <!-- Avatar Ring -->
                                        <div class="w-20 h-20 rounded-full p-0.5 bg-linear-to-tr from-brand-500 to-indigo-500 shadow-sm">
                                            <div class="w-full h-full rounded-full bg-slate-50 flex items-center justify-center overflow-hidden border-2 border-white">
                                                <img id="modalAvatarImg" src="" class="w-full h-full object-cover hidden">
                                                <svg id="modalAvatarPlaceholder" class="w-10 h-10 text-slate-300 group-hover:text-brand-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <!-- Camera badge -->
                                        <label id="avatarUploadBadge" class="absolute -bottom-1 -right-1 w-7 h-7 bg-white hover:bg-brand-50 rounded-full shadow-md border border-slate-200 flex items-center justify-center text-slate-500 hover:text-brand-600 transition-all cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <input type="file" class="hidden">
                                        </label>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">Profile Photo</h4>
                                        <p class="text-xs text-slate-400 mt-0.5">JPEG, PNG formats up to 5MB.</p>
                                    </div>
                                </div>

                                <!-- Auto System Reference and ID Tags -->
                                <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                                    <!-- Employee ID -->
                                    <div class="bg-slate-50 border border-slate-200/50 rounded-xl px-4 py-2 text-center min-w-25 shadow-sm">
                                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Employee ID</span>
                                        <span id="modalEmployeeId" class="text-sm font-black text-slate-700 mt-0.5 block">0149</span>
                                    </div>
                                    <!-- System Reference -->
                                    <div class="bg-slate-50 border border-slate-200/50 rounded-xl px-4 py-2 text-center min-w-35 shadow-sm">
                                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">System Ref</span>
                                        <span id="modalSystemRef" class="text-xs font-bold text-slate-600 mt-0.5 tracking-wider block">EMP-2026-0149</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Two-Column Form Layout -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                
                                <!-- Personal & Contact Details Card -->
                                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-4">
                                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                                        <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center text-brand-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Personal Profile</h4>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">First Name <span class="text-rose-500">*</span></label>
                                            <input type="text" id="empFirstName" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. Sarah">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Last Name <span class="text-rose-500">*</span></label>
                                            <input type="text" id="empLastName" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. Jones">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                                            <input type="email" id="empEmail" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="sarah.jones@company.com">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Phone Number</label>
                                            <input type="tel" id="empPhone" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="+1 (555) 000-0000">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Date of Birth</label>
                                            <input type="date" id="empDOB" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Gender</label>
                                            <div class="relative">
                                                <select id="empGender" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer pr-10">
                                                    <option value="" disabled selected>Select Gender</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                    <option>Other</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Current Address</label>
                                        <textarea id="empAddress" rows="2" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400 resize-none" placeholder="Street Address, City, State, ZIP Code"></textarea>
                                    </div>
                                </div>

                                <!-- Work & Employment Details Card -->
                                <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-4">
                                    <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Employment Details</h4>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Department <span class="text-rose-500">*</span></label>
                                            <div class="relative">
                                                <select id="empDepartment" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer pr-10">
                                                    <option value="" disabled selected>Select Department</option>
                                                    <option>Engineering</option>
                                                    <option>Design</option>
                                                    <option>Human Resources</option>
                                                    <option>Sales</option>
                                                    <option>Marketing</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Role / Position <span class="text-rose-500">*</span></label>
                                            <input type="text" id="empRole" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. Senior Developer">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Employment Type <span class="text-rose-500">*</span></label>
                                            <div class="relative">
                                                <select id="empType" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer pr-10">
                                                    <option>Full-Time</option>
                                                    <option>Part-Time</option>
                                                    <option>Contract</option>
                                                    <option>Internship</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Joining Date</label>
                                            <input type="date" id="empJoinDate" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Emergency Contact</label>
                                        <input type="text" id="empEmergency" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. Jane Doe - +1 (555) 123-4567">
                                    </div>
                                </div>

                            </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-slate-50/50 px-6 py-4 flex items-center justify-between rounded-b-3xl border-t border-slate-100">
                            <p id="modalRequiredFieldsText" class="text-xs text-slate-400 font-semibold hidden sm:block"><span class="text-rose-500">*</span> Required fields</p>
                            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                                <button id="modalCancelBtn" type="button" onclick="closeModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all">
                                    Cancel
                                </button>
                                <button id="modalSubmitBtn" type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-brand-600 border border-transparent text-sm font-bold text-white rounded-xl shadow-sm hover:bg-brand-700 hover:shadow-md transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js" defer></script>

    <!-- ApexCharts Configuration -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Mock Live Status Employees
        let liveStatusEmployees = [
            { name: "Sarah Jones", role: "Developer", status: "Active", time: "09:00 AM", avatar: "https://i.pravatar.cc/150?u=1", badge: "" },
            { name: "Mike Chen", role: "Designer", status: "On Leave", time: "", avatar: "https://i.pravatar.cc/150?u=2", badge: "On Leave" },
            { name: "Emily Davis", role: "HR Manager", status: "Active", time: "08:45 AM", avatar: "https://i.pravatar.cc/150?u=3", badge: "" },
            { name: "John Miller", role: "Sales", status: "Offline", time: "Offline", avatar: "https://i.pravatar.cc/150?u=5", badge: "" },
            { name: "Lisa Wong", role: "Marketing", status: "Active", time: "09:15 AM", avatar: "https://i.pravatar.cc/150?u=12", badge: "" },
            { name: "David Smith", role: "Support", status: "In Call", time: "", avatar: "https://i.pravatar.cc/150?u=14", badge: "In Call" },
            { name: "Ana Garcia", role: "Developer", status: "Offline", time: "Offline", avatar: "https://i.pravatar.cc/150?u=18", badge: "" },
            { name: "Tom Wilson", role: "Product", status: "Active", time: "09:30 AM", avatar: "https://i.pravatar.cc/150?u=22", badge: "" }
        ];

        // Mock Employees Data for Report Generation
        const reportEmployeesData = [
            { empId: "WN-0001", name: "Sarah Jones", email: "sarah.j@worknest.com", department: "Engineering", role: "Senior Developer", type: "Full-Time", joinDate: "2024-01-15", status: "Active" },
            { empId: "WN-0002", name: "Mike Chen", email: "mike.c@worknest.com", department: "Design", role: "UI/UX Designer", type: "Full-Time", joinDate: "2024-03-22", status: "Active" },
            { empId: "WN-0003", name: "Emily Davis", email: "emily.d@worknest.com", department: "Human Resources", role: "HR Manager", type: "Full-Time", joinDate: "2022-03-08", status: "On Leave" },
            { empId: "WN-0004", name: "John Miller", email: "john.m@worknest.com", department: "Sales", role: "Sales Representative", type: "Contract", joinDate: "2021-06-20", status: "Active" },
            { empId: "WN-0005", name: "Lisa Wong", email: "lisa.w@worknest.com", department: "Marketing", role: "Marketing Lead", type: "Full-Time", joinDate: "2025-09-15", status: "Inactive" },
            { empId: "WN-0006", name: "David Miller", email: "david.m@worknest.com", department: "Engineering", role: "Backend Developer", type: "Full-Time", joinDate: "2023-05-10", status: "Active" },
            { empId: "WN-0007", name: "Jessica Taylor", email: "jessica.t@worknest.com", department: "Design", role: "Illustrator", type: "Part-Time", joinDate: "2024-06-15", status: "Active" },
            { empId: "WN-0008", name: "James Wilson", email: "james.w@worknest.com", department: "Sales", role: "Account Executive", type: "Full-Time", joinDate: "2025-01-20", status: "Active" },
            { empId: "WN-0009", name: "Anna Martinez", email: "anna.m@worknest.com", department: "Engineering", role: "QA Engineer", type: "Full-Time", joinDate: "2024-08-11", status: "Active" },
            { empId: "WN-0010", name: "Robert Anderson", email: "robert.a@worknest.com", department: "Human Resources", role: "Recruiter", type: "Full-Time", joinDate: "2023-11-01", status: "Active" },
            { empId: "WN-0011", name: "Mary Thomas", email: "mary.t@worknest.com", department: "Marketing", role: "SEO Specialist", type: "Contract", joinDate: "2025-02-14", status: "Active" },
            { empId: "WN-0012", name: "William Jackson", email: "william.j@worknest.com", department: "Engineering", role: "DevOps Engineer", type: "Full-Time", joinDate: "2022-09-18", status: "Active" },
            { empId: "WN-0013", name: "Patricia White", email: "patricia.w@worknest.com", department: "Design", role: "Product Designer", type: "Internship", joinDate: "2026-03-01", status: "Active" },
            { empId: "WN-0014", name: "Richard Harris", email: "richard.h@worknest.com", department: "Sales", role: "Regional Manager", type: "Full-Time", joinDate: "2020-04-15", status: "Active" },
            { empId: "WN-0015", name: "Linda Martin", email: "linda.m@worknest.com", department: "Marketing", role: "Content Creator", type: "Part-Time", joinDate: "2025-10-10", status: "Active" }
        ];

        const attendanceMockData = [
            { Date: "2026-06-15", "Employee ID": "WN-0001", Name: "Sarah Jones", Status: "Present", "Check In": "09:00 AM", "Check Out": "06:00 PM" },
            { Date: "2026-06-15", "Employee ID": "WN-0002", Name: "Mike Chen", Status: "Present", "Check In": "09:05 AM", "Check Out": "06:10 PM" },
            { Date: "2026-06-15", "Employee ID": "WN-0003", Name: "Emily Davis", Status: "On Leave", "Check In": "-", "Check Out": "-" },
            { Date: "2026-06-15", "Employee ID": "WN-0004", Name: "John Miller", Status: "Present", "Check In": "08:50 AM", "Check Out": "05:55 PM" },
            { Date: "2026-06-16", "Employee ID": "WN-0001", Name: "Sarah Jones", Status: "Present", "Check In": "08:55 AM", "Check Out": "06:05 PM" },
            { Date: "2026-06-16", "Employee ID": "WN-0002", Name: "Mike Chen", Status: "Present", "Check In": "09:00 AM", "Check Out": "06:00 PM" },
            { Date: "2026-06-16", "Employee ID": "WN-0003", Name: "Emily Davis", Status: "On Leave", "Check In": "-", "Check Out": "-" },
            { Date: "2026-06-16", "Employee ID": "WN-0004", Name: "John Miller", Status: "Present", "Check In": "08:55 AM", "Check Out": "05:50 PM" }
        ];

        const leaveMockData = [
            { "Employee ID": "WN-0001", Name: "Sarah Jones", "Annual Leaves Used": 6, "Sick Leaves Used": 3, "Casual Leaves Used": 2, "Total Balance": 20 },
            { "Employee ID": "WN-0002", Name: "Mike Chen", "Annual Leaves Used": 8, "Sick Leaves Used": 2, "Casual Leaves Used": 3, "Total Balance": 18 },
            { "Employee ID": "WN-0003", Name: "Emily Davis", "Annual Leaves Used": 3, "Sick Leaves Used": 1, "Casual Leaves Used": 1, "Total Balance": 26 },
            { "Employee ID": "WN-0004", Name: "John Miller", "Annual Leaves Used": 10, "Sick Leaves Used": 4, "Casual Leaves Used": 4, "Total Balance": 13 }
        ];

        let currentModalType = "";
        let currentEmployeeIndex = null;

        function updateBodyScroll() {
            const dynamicModal = document.getElementById('dynamicModal');
            const reportModal = document.getElementById('reportModal');
            const announcementModal = document.getElementById('announcementModal');
            
            const isDynamicOpen = dynamicModal && !dynamicModal.classList.contains('hidden');
            const isReportOpen = reportModal && !reportModal.classList.contains('hidden');
            const isAnnouncementOpen = announcementModal && !announcementModal.classList.contains('hidden');
            
            if (isDynamicOpen || isReportOpen || isAnnouncementOpen) {
                document.body.classList.add('overflow-hidden');
            } else {
                document.body.classList.remove('overflow-hidden');
            }
        }

        function openAnnouncementModal() {
            const modal = document.getElementById('announcementModal');
            const backdrop = document.getElementById('announcementModalBackdrop');
            const panel = document.getElementById('announcementModalPanel');

            modal.classList.remove('hidden');
            updateBodyScroll();

            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');

                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            });
        }

        function closeAnnouncementModal() {
            const modal = document.getElementById('announcementModal');
            const backdrop = document.getElementById('announcementModalBackdrop');
            const panel = document.getElementById('announcementModalPanel');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');

            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                updateBodyScroll();
            }, 300);
        }

        function postAnnouncement(event) {
            event.preventDefault();

            const title = document.getElementById('annTitle').value.trim();
            const category = document.getElementById('annCategory').value;
            const desc = document.getElementById('annDesc').value.trim();

            if (!title || !desc) {
                showToast('Please fill out all required fields.', 'error');
                return;
            }

            const titleEl = document.getElementById('announcementTitle');
            const descEl = document.getElementById('announcementDesc');
            const dateEl = document.getElementById('announcementDate');
            const badgeEl = document.getElementById('announcementBadge');

            if (titleEl) titleEl.textContent = title;
            if (descEl) descEl.textContent = desc;
            if (dateEl) dateEl.textContent = 'Today, ' + new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            if (badgeEl) {
                badgeEl.textContent = category.toUpperCase();
                badgeEl.className = "px-2 py-0.5 text-[11px] font-black tracking-wider rounded-md";
                if (category === 'hr') {
                    badgeEl.classList.add('text-emerald-700', 'bg-emerald-100');
                } else if (category === 'event') {
                    badgeEl.classList.add('text-blue-700', 'bg-blue-100');
                } else if (category === 'alert') {
                    badgeEl.classList.add('text-rose-700', 'bg-rose-100');
                } else {
                    badgeEl.classList.add('text-indigo-700', 'bg-indigo-100');
                }
            }

            closeAnnouncementModal();
            showToast('Announcement posted successfully!', 'success');
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `flex items-center gap-3 px-4 py-3 bg-white border border-slate-100 shadow-xl rounded-2xl pointer-events-auto transition-all duration-350 translate-x-12 opacity-0 max-w-sm`;
            
            let iconHtml = "";
            if (type === 'success') {
                iconHtml = `
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                `;
            } else {
                iconHtml = `
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                `;
            }

            toast.innerHTML = `
                ${iconHtml}
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-800">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-655 p-1.5 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-12', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            });

            setTimeout(() => {
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-12', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 350);
            }, 4000);
        }

        function renderLiveStatus() {
            const container = document.getElementById('liveStatusContainer');
            if (!container) return;
            
            let html = "";
            liveStatusEmployees.forEach(emp => {
                let statusColor = "bg-slate-300";
                if (emp.status === "Active") statusColor = "bg-emerald-500";
                else if (emp.status === "On Leave") statusColor = "bg-amber-500";
                else if (emp.status === "In Call") statusColor = "bg-brand-500 animate-pulse";
                
                let rightHtml = "";
                if (emp.badge) {
                    if (emp.badge === "On Leave") {
                        rightHtml = `<span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-black tracking-wider uppercase rounded-md">On Leave</span>`;
                    } else if (emp.badge === "In Call") {
                        rightHtml = `<span class="px-2 py-0.5 bg-brand-100 text-brand-700 text-[10px] font-black tracking-wider uppercase rounded-md">In Call</span>`;
                    }
                } else {
                    rightHtml = `<span class="text-[11px] font-bold text-slate-400">${emp.time || 'Offline'}</span>`;
                }
                
                const grayscaleClass = emp.status === "Offline" ? "grayscale" : "";
                
                html += `
                    <div class="group flex items-center justify-between p-2 hover:bg-slate-50 rounded-lg transition-colors cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img src="${emp.avatar}" class="w-9 h-9 rounded-full object-cover border border-slate-200 group-hover:scale-105 transition-transform ${grayscaleClass}">
                                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 ${statusColor} border border-white rounded-full"></div>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">${emp.name}</p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">${emp.role}</p>
                            </div>
                        </div>
                        ${rightHtml}
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function openModal(type) {
            currentModalType = type;
            const modal = document.getElementById('dynamicModal');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            const title = document.getElementById('modalTitle');
            const desc = modal.querySelector('p.text-xs.text-slate-500');

            const formContent = document.getElementById('employeeFormContent');
            const cancelBtn = document.getElementById('modalCancelBtn');
            const submitBtn = document.getElementById('modalSubmitBtn');
            const reqText = document.getElementById('modalRequiredFieldsText');

            const formFields = formContent.querySelectorAll('input, select, textarea');

            formContent.classList.remove('hidden');
            if (reqText) reqText.classList.remove('hidden');
            if (submitBtn) {
                submitBtn.classList.remove('hidden');
                submitBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Save Profile`;
            }
            if (cancelBtn) {
                cancelBtn.textContent = 'Cancel';
                cancelBtn.className = "w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all";
            }

            formFields.forEach(field => {
                field.disabled = false;
                field.classList.remove('bg-slate-100/30', 'border-slate-100/80', 'text-slate-600', 'cursor-default', 'select-none');
                field.classList.add('bg-slate-50/50', 'border-slate-200', 'text-slate-900');
            });

            document.getElementById('employeeForm').reset();
            
            const nextId = String(liveStatusEmployees.length + 1).padStart(4, '0');
            document.getElementById('modalEmployeeId').textContent = nextId;
            document.getElementById('modalSystemRef').textContent = 'EMP-2026-' + nextId;

            document.getElementById('modalAvatarPlaceholder').classList.remove('hidden');

            modal.classList.remove('hidden');
            updateBodyScroll();

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

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');

            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                updateBodyScroll();
            }, 300);
        }

        function saveEmployee(event) {
            event.preventDefault();

            const firstName = document.getElementById('empFirstName').value.trim();
            const lastName = document.getElementById('empLastName').value.trim();
            const email = document.getElementById('empEmail').value.trim();
            const department = document.getElementById('empDepartment').value;
            const role = document.getElementById('empRole').value.trim();
            const type = document.getElementById('empType').value;

            if (!firstName || !lastName || !email || !department || !role || !type) {
                showToast('Please fill out all required fields.', 'error');
                return;
            }

            const nextKey = liveStatusEmployees.length + 1;
            const newEmp = {
                name: `${firstName} ${lastName}`,
                role: role,
                status: "Active",
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                avatar: `https://i.pravatar.cc/150?u=${nextKey}`,
                badge: ""
            };
            
            liveStatusEmployees.unshift(newEmp);
            renderLiveStatus();
            
            closeModal();
            showToast('Employee added successfully!', 'success');
        }

        function openReportModal() {
            const modal = document.getElementById('reportModal');
            const backdrop = document.getElementById('reportModalBackdrop');
            const panel = document.getElementById('reportModalPanel');

            modal.classList.remove('hidden');
            updateBodyScroll();

            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');

                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            });
        }

        function closeReportModal() {
            const modal = document.getElementById('reportModal');
            const backdrop = document.getElementById('reportModalBackdrop');
            const panel = document.getElementById('reportModalPanel');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');

            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                updateBodyScroll();
            }, 300);
        }

        function convertToCSV(objArray) {
            const array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
            let str = '';
            const headers = Object.keys(array[0]);
            str += headers.join(',') + '\r\n';

            for (let i = 0; i < array.length; i++) {
                let line = '';
                for (let index in array[i]) {
                    if (line != '') line += ',';
                    let val = String(array[i][index]);
                    if (val.includes(',') || val.includes('"') || val.includes('\n')) {
                        val = '"' + val.replace(/"/g, '""') + '"';
                    }
                    line += val;
                }
                str += line + '\r\n';
            }
            return str;
        }

        function exportToPDF(data, title, periodText) {
            const printWindow = window.open('', '_blank');
            let tableRows = '';
            
            // Get table headers
            const headers = Object.keys(data[0]);
            
            // Generate header row
            let headerHtml = '<tr>';
            headers.forEach(h => {
                headerHtml += `<th style="padding: 10px; border-bottom: 2px solid #cbd5e1; text-align: left; font-size: 11px; text-transform: uppercase; color: #475569;">${h}</th>`;
            });
            headerHtml += '</tr>';
            
            // Generate table rows
            data.forEach(row => {
                tableRows += '<tr>';
                headers.forEach(h => {
                    tableRows += `<td style="padding: 10px; border-bottom: 1px solid #f1f5f9; font-size: 12px; color: #334155;">${row[h]}</td>`;
                });
                tableRows += '</tr>';
            });
            
            const htmlContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${title}</title>
                    <style>
                        body { font-family: 'Inter', system-ui, sans-serif; padding: 40px; color: #1e293b; }
                        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; }
                        .title { font-size: 24px; font-weight: 800; color: #0f172a; margin: 0; }
                        .subtitle { font-size: 13px; color: #64748b; margin-top: 5px; font-weight: 500; }
                        .meta { text-align: right; font-size: 12px; color: #64748b; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        tr:nth-child(even) { background-color: #f8fafc; }
                        .footer { margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 15px; font-size: 11px; color: #94a3b8; display: flex; justify-content: space-between; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <div>
                            <div class="title">${title}</div>
                            <div class="subtitle">Generated Report for ${periodText}</div>
                        </div>
                        <div class="meta">
                            <div><strong>Date:</strong> ${new Date().toLocaleDateString()}</div>
                            <div><strong>Source:</strong> WorkNest EMS</div>
                        </div>
                    </div>
                    <table>
                        <thead>${headerHtml}</thead>
                        <tbody>${tableRows}</tbody>
                    </table>
                    <div class="footer">
                        <span>WorkNest Employee Management System Confidential</span>
                        <span>Page 1 of 1</span>
                    </div>
                    <script>
                        window.onload = function() {
                            window.print();
                            setTimeout(() => window.close(), 500);
                        }
                    <\/script>
                </body>
                </html>
            `;
            
            printWindow.document.write(htmlContent);
            printWindow.document.close();
        }

        function downloadReport(event) {
            event.preventDefault();

            const type = document.getElementById('reportType').value;
            const format = document.getElementById('reportFormat').value;
            const period = document.getElementById('reportPeriod').value;

            let periodText = period;
            if (period === 'custom') {
                const start = document.getElementById('reportStartDate').value;
                const end = document.getElementById('reportEndDate').value;
                if (!start || !end) {
                    showToast('Please select start and end dates.', 'error');
                    return;
                }
                periodText = `${start}_to_${end}`;
            }

            let data = [];
            let filename = "";

            if (type === 'employees') {
                const allEmployeesForReport = [...reportEmployeesData];
                liveStatusEmployees.forEach(liveEmp => {
                    const isOriginal = reportEmployeesData.some(orig => orig.name === liveEmp.name);
                    if (!isOriginal) {
                        allEmployeesForReport.unshift({
                            empId: 'WN-' + String(allEmployeesForReport.length + 1).padStart(4, '0'),
                            name: liveEmp.name,
                            email: liveEmp.name.toLowerCase().replace(' ', '.') + '@worknest.com',
                            department: "Engineering",
                            role: liveEmp.role,
                            type: "Full-Time",
                            joinDate: new Date().toISOString().split('T')[0],
                            status: "Active"
                        });
                    }
                });

                data = allEmployeesForReport.map(emp => ({
                    "Employee ID": emp.empId,
                    "Name": emp.name,
                    "Email": emp.email,
                    "Department": emp.department,
                    "Role": emp.role,
                    "Employment Type": emp.type,
                    "Join Date": emp.joinDate,
                    "Status": emp.status
                }));
                filename = `WorkNest_Employee_Directory_Report_${periodText}`;
            } else if (type === 'attendance') {
                data = attendanceMockData;
                filename = `WorkNest_Attendance_Summary_Report_${periodText}`;
            } else if (type === 'leaves') {
                data = leaveMockData;
                filename = `WorkNest_Leave_Utilization_Report_${periodText}`;
            }

            let displayPeriodText = period === 'custom' 
                ? `Custom Range (${document.getElementById('reportStartDate').value} to ${document.getElementById('reportEndDate').value})` 
                : (period === 'current' ? 'Current Month' : period === 'previous' ? 'Previous Month' : 'Year to Date');
            
            let displayTitle = type === 'employees' 
                ? 'Employee Directory Report' 
                : (type === 'attendance' ? 'Attendance Summary Report' : 'Leave Utilization Report');

            if (format === 'csv') {
                const csvContent = convertToCSV(data);
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", `${filename}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else if (format === 'json') {
                const jsonString = JSON.stringify(data, null, 2);
                const blob = new Blob([jsonString], { type: 'application/json;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", `${filename}.json`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else if (format === 'pdf') {
                exportToPDF(data, displayTitle, displayPeriodText);
            } else {
                if (typeof XLSX === 'undefined') {
                    showToast('Export library loading. Please try again in a moment.', 'error');
                    return;
                }
                const ws = XLSX.utils.json_to_sheet(data);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Report");
                XLSX.writeFile(wb, `${filename}.xlsx`);
            }

            closeReportModal();
            showToast('Report generated successfully!', 'success');
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Render Live Status Initial Items
            renderLiveStatus();

            // Bind Report Period change listener to show/hide custom date pickers
            const periodSelect = document.getElementById('reportPeriod');
            if (periodSelect) {
                periodSelect.addEventListener('change', function() {
                    const container = document.getElementById('customDateRangeContainer');
                    const startInput = document.getElementById('reportStartDate');
                    const endInput = document.getElementById('reportEndDate');
                    if (this.value === 'custom') {
                        container.classList.remove('hidden');
                        startInput.required = true;
                        endInput.required = true;
                    } else {
                        container.classList.add('hidden');
                        startInput.required = false;
                        endInput.required = false;
                    }
                });
            }

            // ApexCharts Setup
            var options = {
                series: [{
                    name: 'Attendance',
                    data: [82, 87, 45, 94, 90, 88, 92]
                }],
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Instrument Sans, sans-serif',
                    zoom: { enabled: false }
                },
                colors: ['#0284c7'], // Brand 600
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 4
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    labels: { 
                        style: { colors: '#64748b', fontSize: '12px', fontWeight: 700 }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    crosshairs: {
                        stroke: { color: '#e2e8f0', width: 2, dashArray: 4 }
                    }
                },
                yaxis: { 
                    labels: {
                        formatter: function (val) { return val + "%" },
                        style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 700 }
                    }
                },
                grid: { 
                    borderColor: '#f1f5f9', 
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } }
                },
                markers: {
                    size: 0,
                    colors: ['#fff'],
                    strokeColors: '#0284c7',
                    strokeWidth: 3,
                    hover: { size: 7 }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: function (val) { return val + "% Present" } },
                    style: { fontSize: '13px' }
                }
            };

            var chart = new ApexCharts(document.querySelector("#attendanceChart"), options);
            chart.render();

            // Department Headcount Donut Chart
            var deptOptions = {
                series: [45, 32, 28, 15, 28],
                chart: { type: 'donut', height: 240, fontFamily: 'Instrument Sans, sans-serif' },
                labels: ['Engineering', 'Sales', 'Support', 'HR', 'Design'],
                colors: ['#0284c7', '#38bdf8', '#818cf8', '#f472b6', '#34d399'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: { fontSize: '12px', fontWeight: 600, color: '#64748b' },
                                value: { fontSize: '24px', fontWeight: 900, color: '#0f172a' },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                legend: { show: false },
                tooltip: { theme: 'light', style: { fontSize: '13px' } }
            };
            var deptChart = new ApexCharts(document.querySelector("#departmentChart"), deptOptions);
            deptChart.render();

            // Leave Utilization Bar Chart
            var leaveOptions = {
                series: [{ name: 'Leaves Taken', data: [12, 18, 15, 22, 14, 25] }],
                chart: { type: 'bar', height: 220, toolbar: { show: false }, fontFamily: 'Instrument Sans, sans-serif' },
                colors: ['#818cf8'],
                plotOptions: {
                    bar: { borderRadius: 4, columnWidth: '45%', distributed: true }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    labels: { style: { colors: '#64748b', fontSize: '11px', fontWeight: 600 } },
                    axisBorder: { show: false }, axisTicks: { show: false }
                },
                yaxis: {
                    labels: { style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 600 } }
                },
                grid: {
                    borderColor: '#f1f5f9', strokeDashArray: 4,
                    yaxis: { lines: { show: true } }, xaxis: { lines: { show: false } }
                },
                legend: { show: false },
                tooltip: { theme: 'light', style: { fontSize: '13px' } }
            };
            var leaveChart = new ApexCharts(document.querySelector("#leaveChart"), leaveOptions);
            leaveChart.render();

            // Sparkline 1
            var spark1 = new ApexCharts(document.querySelector("#spark1"), {
                series: [{ data: [12, 14, 22, 47, 42, 60, 68] }],
                chart: { type: 'line', width: '100%', height: 40, sparkline: { enabled: true } },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#0ea5e9'],
                tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: function () { return '' } } }, marker: { show: false } }
            });
            spark1.render();

            // Sparkline 2
            var spark2 = new ApexCharts(document.querySelector("#spark2"), {
                series: [{ data: [47, 45, 74, 14, 56, 74, 94] }],
                chart: { type: 'line', width: '100%', height: 40, sparkline: { enabled: true } },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#10b981'],
                tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: function () { return '' } } }, marker: { show: false } }
            });
            spark2.render();

            // Sparkline 3
            var spark3 = new ApexCharts(document.querySelector("#spark3"), {
                series: [{ data: [42, 35, 29, 64, 45, 59, 68] }],
                chart: { type: 'line', width: '100%', height: 40, sparkline: { enabled: true } },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#cbd5e1'],
                tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: function () { return '' } } }, marker: { show: false } }
            });
            spark3.render();
        });
    </script>
    @endpush
</x-app-layout>
