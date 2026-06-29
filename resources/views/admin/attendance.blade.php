<x-app-layout>
    <!-- Background Accents for depth -->
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/50 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>
    <div class="fixed bottom-0 left-0 -z-10 w-[600px] h-[600px] bg-indigo-50/50 rounded-full blur-[100px] mix-blend-multiply pointer-events-none -translate-x-1/4 translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6">
        
        <!-- Welcome / Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Attendance & Time Portal</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium" id="currentDateHeader">Track work hours, manage employee attendance logs, and process corrections.</p>
            </div>
            <div class="flex gap-2.5">
                <button onclick="openCorrectionModal()" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    Correction Request
                </button>
                <button onclick="openExportModal()" class="px-4 py-2 bg-brand-600 rounded-lg text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export Log
                </button>
            </div>
        </div>

        <!-- Upper Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Interactive My Time Card -->
            <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute -top-16 -right-16 w-36 h-36 bg-brand-50 rounded-full blur-xl -z-10 group-hover:scale-110 transition-transform duration-500"></div>
                
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                        <div>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">My Time Card</h2>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Shift: 09:00 AM - 06:00 PM</p>
                        </div>
                        <span id="shiftIndicator" class="px-2.5 py-1 text-[10px] font-extrabold tracking-wider bg-slate-100 text-slate-600 rounded-full uppercase">Day Shift</span>
                    </div>

                    <!-- Status Display -->
                    <div class="flex flex-col items-center justify-center my-6 text-center">
                        <div id="stopwatch" class="text-4xl font-black text-slate-900 tracking-tight font-mono mb-2">00:00:00</div>
                        <div class="flex items-center gap-2">
                            <span id="statusIndicatorDot" class="w-2.5 h-2.5 bg-rose-500 rounded-full shadow-[0_0_8px_rgba(244,63,94,0.6)] animate-pulse"></span>
                            <span id="statusIndicatorText" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Not Clocked In</span>
                        </div>
                    </div>

                    <!-- Work Mode Selector -->
                    <div class="mb-4">
                        <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 text-center">Work Mode</span>
                        <div class="bg-slate-100 p-1 rounded-xl flex gap-1 border border-slate-200/40" id="workModeSelector">
                            <button onclick="setWorkMode('Office')" id="modeBtnOffice" class="flex-1 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer bg-white text-slate-900 shadow-xs border border-slate-200/50">Office</button>
                            <button onclick="setWorkMode('WFH')" id="modeBtnWFH" class="flex-1 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer text-slate-500 hover:text-slate-800">WFH</button>
                            <button onclick="setWorkMode('Field')" id="modeBtnField" class="flex-1 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer text-slate-500 hover:text-slate-800">Field Duty</button>
                        </div>
                    </div>

                    <!-- Field Duty Details Panel -->
                    <div id="fieldDutyPanel" class="hidden mb-4 bg-slate-50 border border-slate-200/60 p-3 rounded-xl transition-all duration-300">
                        <label class="block text-[9px] font-black uppercase tracking-wider text-slate-400 mb-1.5">Client / Site Name</label>
                        <input type="text" id="fieldSiteInput" oninput="updateFieldSiteName(this.value)" placeholder="Enter Visited Site/Client..." class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500" />
                        <div class="flex items-center justify-between mt-2.5 pt-2.5 border-t border-slate-200/50 text-[10px] font-bold text-slate-400">
                            <span>GPS Tag:</span>
                            <span class="text-brand-600 flex items-center gap-1 font-mono uppercase font-black">
                                <svg class="w-3.5 h-3.5 animate-bounce text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span id="gpsCoordinatesText">19.0760° N, 72.8777° E</span>
                            </span>
                        </div>
                    </div>

                    <!-- WFH Details Panel -->
                    <div id="wfhPanel" class="hidden mb-4 bg-slate-50 border border-slate-200/60 p-3 rounded-xl transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] font-bold text-slate-500 leading-normal">Remote clock-in active. Verification tied to registered home IP.</span>
                    </div>

                    <!-- Punch Actions -->
                    <div class="flex flex-col gap-3">
                        <button id="clockBtn" onclick="toggleClock()" class="w-full py-3.5 rounded-xl bg-linear-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-extrabold text-sm tracking-wide shadow-md transition-all active:scale-[0.98] cursor-pointer flex items-center justify-center gap-2">
                            <svg id="clockBtnIcon" class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span id="clockBtnText">Clock In</span>
                        </button>
                    </div>
                </div>

                <!-- Clock Metadata (Tech info) -->
                <div class="border-t border-slate-100 pt-4 mt-6 space-y-2">
                    <div class="flex justify-between text-[11px] font-medium text-slate-400">
                        <span>Work Location:</span>
                        <span class="text-slate-600 font-bold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            WN-Headquarters
                        </span>
                    </div>
                    <div class="flex justify-between text-[11px] font-medium text-slate-400">
                        <span>IP Address:</span>
                        <span class="text-slate-600 font-mono font-bold" id="currentIp">192.168.1.145</span>
                    </div>
                    <div id="activePunchDetails" class="hidden text-center text-[10px] font-bold text-brand-500 bg-brand-50/50 border border-brand-100 py-1.5 px-3 rounded-lg mt-2 transition-all">
                        Punch Time: <span id="punchTimeLog">--:--</span>
                    </div>
                </div>
            </div>

            <!-- Right: Today's Metrics (KPI Cards) -->
            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                <!-- Present Today -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-50 rounded-bl-full -z-10 group-hover:scale-105 transition-transform duration-300"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-emerald-100 text-emerald-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-black tracking-wider text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded-md uppercase">On Time</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold mb-1">Present Rate</p>
                        <div class="flex items-baseline gap-2">
                            <h3 id="statPresentCount" class="text-2xl font-black text-slate-900 tracking-tight">132</h3>
                            <span class="text-xs font-semibold text-slate-400">/ 148 Employees</span>
                        </div>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
                            <div id="statPresentProgress" class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: 89.2%;"></div>
                        </div>
                        <div class="flex items-center gap-2 mt-3 pt-2.5 border-t border-slate-100 text-[9px] font-black uppercase tracking-wider text-slate-400">
                            <span class="text-blue-600">Office: <span id="statOfficeCount" class="text-slate-700 font-bold">0</span></span>
                            <span class="text-slate-300">•</span>
                            <span class="text-purple-600">WFH: <span id="statWfhCount" class="text-slate-700 font-bold">0</span></span>
                            <span class="text-slate-300">•</span>
                            <span class="text-amber-600">Field: <span id="statFieldCount" class="text-slate-700 font-bold">0</span></span>
                        </div>
                    </div>
                </div>

                <!-- Late Arrivals -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-amber-50 rounded-bl-full -z-10 group-hover:scale-105 transition-transform duration-300"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-amber-100 text-amber-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-black tracking-wider text-amber-700 bg-amber-100 px-1.5 py-0.5 rounded-md uppercase">Late</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold mb-1">Late Arrivals</p>
                        <div class="flex items-baseline gap-2">
                            <h3 id="statLateCount" class="text-2xl font-black text-slate-900 tracking-tight">14</h3>
                            <span class="text-[10px] text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md font-bold">Target < 5%</span>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-3 font-semibold">Punches recorded after 09:15 AM</p>
                    </div>
                </div>

                <!-- On Break -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-bl-full -z-10 group-hover:scale-105 transition-transform duration-300"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-indigo-100 text-indigo-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-black tracking-wider text-indigo-700 bg-indigo-100 px-1.5 py-0.5 rounded-md uppercase">Break</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold mb-1">Currently on Break</p>
                        <div class="flex items-baseline gap-2">
                            <h3 id="statBreakCount" class="text-2xl font-black text-slate-900 tracking-tight">6</h3>
                            <span class="text-xs font-semibold text-slate-400">Employees</span>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-3 font-semibold">Self-reported active break periods</p>
                    </div>
                </div>

                <!-- Absent Today -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-rose-50 rounded-bl-full -z-10 group-hover:scale-105 transition-transform duration-300"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-rose-100 text-rose-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-[10px] font-black tracking-wider text-rose-700 bg-rose-100 px-1.5 py-0.5 rounded-md uppercase">Absent</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold mb-1">Absent Today</p>
                        <div class="flex items-baseline gap-2">
                            <h3 id="statAbsentCount" class="text-2xl font-black text-slate-900 tracking-tight">10</h3>
                            <span class="text-xs font-semibold text-slate-400">Unexcused</span>
                        </div>
                        <button onclick="triggerAbsenceReminder()" class="text-[10px] text-rose-600 hover:text-rose-700 font-bold mt-3 transition-colors flex items-center gap-1 cursor-pointer">
                            Send Alert Mail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lower Content Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Attendance logs (Left & Center columns - col-span-2) -->
            <div class="lg:col-span-2 flex flex-col gap-5">
                
                <!-- Filter & Search Bar -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                        <!-- Search -->
                        <div class="relative w-full md:max-w-md group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="attendanceSearch" oninput="applyFilters()" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="Search by name or Employee ID...">
                        </div>

                        <!-- Date Picker & Selection -->
                        <div class="flex items-center gap-2 w-full md:w-auto shrink-0">
                            <button onclick="changeLogDate(-1)" class="p-2 border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50 transition-colors cursor-pointer" aria-label="Previous Day">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <input type="date" id="attendanceLogDate" onchange="applyFilters()" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg focus:ring-brand-500 focus:border-brand-500 px-3 py-2 outline-none w-full md:w-40">
                            <button onclick="changeLogDate(1)" class="p-2 border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50 transition-colors cursor-pointer" aria-label="Next Day">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Sub Filters -->
                    <div class="flex flex-wrap items-center gap-3 pt-3 border-t border-slate-100">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Filters:</span>
                        <select id="attendanceFilterDept" onchange="applyFilters()" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg focus:ring-brand-500 focus:border-brand-500 px-3 py-1.5 outline-none cursor-pointer">
                            <option value="">All Departments</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Design">Design</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Sales">Sales</option>
                            <option value="Marketing">Marketing</option>
                        </select>
                        <select id="attendanceFilterStatus" onchange="applyFilters()" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg focus:ring-brand-500 focus:border-brand-500 px-3 py-1.5 outline-none cursor-pointer">
                            <option value="">All Statuses</option>
                            <option value="On Time">On Time (Present)</option>
                            <option value="Late">Late (Present)</option>
                            <option value="On Break">On Break</option>
                            <option value="Checked Out">Checked Out</option>
                            <option value="Absent">Absent</option>
                            <option value="On Leave">On Leave</option>
                        </select>
                        <select id="attendanceFilterMode" onchange="applyFilters()" class="bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-lg focus:ring-brand-500 focus:border-brand-500 px-3 py-1.5 outline-none cursor-pointer">
                            <option value="">All Work Modes</option>
                            <option value="Office">Office</option>
                            <option value="WFH">Work From Home (WFH)</option>
                            <option value="Field">Field Duty</option>
                        </select>
                        <button onclick="resetFilters()" class="text-xs text-brand-600 hover:text-brand-700 font-bold ml-auto transition-colors cursor-pointer">Clear All</button>
                    </div>
                </div>

                <!-- Table Card Panel -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto scrollbar-premium" style="min-height: 260px;">
                        <!-- Desktop Table -->
                        <table class="w-full text-left border-collapse min-w-[700px] hidden md:table">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                                    <th class="px-6 py-4">Employee</th>
                                    <th class="px-6 py-4">Department</th>
                                    <th class="px-6 py-4">Clock In</th>
                                    <th class="px-6 py-4">Clock Out</th>
                                    <th class="px-6 py-4">Work Hours</th>
                                    <th class="px-6 py-4">Mode</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceTableBody" class="divide-y divide-slate-100 text-sm">
                                <!-- Dynamic JS Rows -->
                            </tbody>
                        </table>

                        <!-- Mobile Cards (Fallback when md screen is triggered) -->
                        <div id="attendanceMobileBody" class="divide-y divide-slate-100 text-sm block md:hidden p-4 space-y-4">
                            <!-- Dynamic JS Cards -->
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="p-4 border-t border-slate-200 bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span id="attendancePaginationInfo" class="text-xs font-bold text-slate-500">Showing 1 to 5 of 15 entries</span>
                        <div id="attendancePaginationButtons" class="flex gap-1">
                            <!-- Dynamic Buttons -->
                        </div>
                    </div>
                </div>

            </div>

            <!-- Admin Panel: Time Correction Requests & Audit Log (Right Column - col-span-1) -->
            <div class="lg:col-span-1 flex flex-col gap-5">
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex flex-col h-full overflow-hidden">
                    
                    <!-- Tabs switcher header with sliding search -->
                    <div class="relative border-b border-slate-100 mb-4 shrink-0 overflow-hidden h-9">
                        <!-- Default state: Tabs and Secure Log / Search Icon -->
                        <div id="correctionsHeaderDefault" class="absolute inset-0 flex items-center justify-between transition-all duration-300 transform translate-x-0 opacity-100">
                            <div class="flex gap-4 h-full items-end">
                                <button id="tabCorrectionsPending" onclick="switchCorrectionsTab('pending')" class="text-xs font-black uppercase tracking-wider pb-2.5 border-b-2 border-brand-600 text-brand-600 transition-all cursor-pointer h-full">
                                    Pending <span id="pendingCorrectionBadge" class="ml-1 px-1.5 py-0.5 text-[9px] font-bold bg-brand-50 text-brand-600 rounded-md border border-brand-100/50">0</span>
                                </button>
                                <button id="tabCorrectionsHistory" onclick="switchCorrectionsTab('history')" class="text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-wider pb-2.5 border-b-2 border-transparent transition-all cursor-pointer h-full">
                                    Audit History
                                </button>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Secure Log
                                </div>
                                <button onclick="toggleCorrectionsSearch(true)" class="p-1 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-slate-600 transition-all cursor-pointer" title="Search Time Corrections">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Search state: sliding text input -->
                        <div id="correctionsHeaderSearch" class="absolute inset-0 flex items-center gap-2 transition-all duration-300 transform translate-x-full opacity-0 pointer-events-none">
                            <div class="relative w-full">
                                <span class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" id="correctionsSearchInput" oninput="applyCorrectionsSearch()" class="w-full pl-8 pr-7 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="Search by name or ID...">
                                <button id="clearSearchBtn" onclick="clearCorrectionsSearch()" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-450 hover:text-slate-655 hidden cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <button onclick="toggleCorrectionsSearch(false)" class="text-xs font-bold text-slate-500 hover:text-slate-700 cursor-pointer shrink-0">Cancel</button>
                        </div>
                    </div>

                    <!-- Tab 1 Container: Pending list -->
                    <div id="pendingCorrectionsContainer" class="space-y-3.5 overflow-y-auto scrollbar-premium flex-1 pr-1" style="max-height: 520px;">
                        <!-- Rendered dynamically by JavaScript -->
                    </div>

                    <!-- Tab 2 Container: History/Audit log -->
                    <div id="historyCorrectionsContainer" class="space-y-3.5 overflow-y-auto scrollbar-premium flex-1 pr-1 hidden" style="max-height: 520px;">
                        <!-- Rendered dynamically by JavaScript -->
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Vanilla JS Dropdown Logic -->
    <style>
        .action-dropdown-menu {
            display: block !important;
            opacity: 0 !important;
            transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1), transform 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            pointer-events: none !important;
            visibility: hidden !important;
        }
        .action-dropdown-menu:not(.dropup) {
            transform: scale(0.95) translateY(-8px) !important;
            transform-origin: top right !important;
        }
        .action-dropdown-menu.dropup {
            transform: scale(0.95) translateY(8px) !important;
            transform-origin: bottom right !important;
        }
        .action-dropdown-menu.show {
            opacity: 1 !important;
            transform: scale(1) translateY(0) !important;
            pointer-events: auto !important;
            visibility: visible !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let activeDropdown = null;

            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.action-dropdown-btn');
                const container = e.target.closest('.action-dropdown-container');

                if (btn && container) {
                    e.stopPropagation();
                    const menu = container.querySelector('.action-dropdown-menu');

                    if (activeDropdown && activeDropdown !== menu) {
                        activeDropdown.classList.remove('show');
                    }

                    if (menu) {
                        if (!menu.classList.contains('show')) {
                            // Check vertical space to see if it should open upwards
                            const rect = menu.getBoundingClientRect();
                            const windowHeight = window.innerHeight;
                            const spaceBelow = windowHeight - rect.top;
                            
                            if (spaceBelow < 200) {
                                menu.classList.add('dropup');
                            } else {
                                menu.classList.remove('dropup');
                            }
                            
                            menu.classList.add('show');
                            activeDropdown = menu;
                        } else {
                            menu.classList.remove('show');
                            activeDropdown = null;
                        }
                    }
                } else {
                    if (activeDropdown) {
                        activeDropdown.classList.remove('show');
                        activeDropdown = null;
                    }
                }
            });
        });
    </script>

    <!-- Modal: Request Time Correction -->
    <div id="correctionModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Premium Glass Backdrop -->
        <div id="correctionModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="closeCorrectionModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6 lg:p-8">
                <div id="correctionModalPanel" class="relative w-full max-w-lg transform bg-white rounded-3xl shadow-2xl border border-slate-100/80 text-left transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 my-8">
                    <!-- Header -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 shadow-sm border border-brand-100/50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Time Correction Request</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Submit manual hours or correct clock errors.</p>
                            </div>
                        </div>
                        <button onclick="closeCorrectionModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-xl transition-all border border-transparent hover:border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form id="correctionForm" onsubmit="submitCorrection(event)" class="m-0">
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Select Employee</label>
                                <select id="correctionEmployee" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                    <!-- Dynamic selection populated by JS -->
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Date</label>
                                <input type="date" id="correctionDate" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Check-In Time</label>
                                    <input type="time" id="correctionInTime" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Check-Out Time</label>
                                    <input type="time" id="correctionOutTime" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Reason for Correction</label>
                                <textarea id="correctionReason" rows="3" required placeholder="Describe the reason (e.g. Card machine failure, Offsite meeting, Forgot card)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="button" onclick="closeCorrectionModal()" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all shadow-sm cursor-pointer">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-brand-600 rounded-xl text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm cursor-pointer">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Timeline & Log Details -->
    <div id="detailsModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Premium Glass Backdrop -->
        <div id="detailsModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="closeDetailsModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6 lg:p-8">
                <div id="detailsModalPanel" class="relative w-full max-w-lg transform bg-white rounded-3xl shadow-2xl border border-slate-100/80 text-left transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 my-8">
                    <!-- Header -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-600 shadow-sm border border-slate-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight" id="detailsEmployeeName">Punch Timeline</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5" id="detailsEmployeeID">Employee logs and punch stages</p>
                            </div>
                        </div>
                        <button onclick="closeDetailsModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-xl transition-all border border-transparent hover:border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Content Body -->
                    <div class="p-6 space-y-6">
                        <!-- Summary Metadata Card -->
                        <div class="grid grid-cols-3 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-0.5">Check In</p>
                                <p class="text-xs font-black text-slate-800" id="detailsMetaCheckIn">--:--</p>
                            </div>
                            <div class="border-x border-slate-200">
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-0.5">Check Out</p>
                                <p class="text-xs font-black text-slate-800" id="detailsMetaCheckOut">--:--</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-0.5">Total Duration</p>
                                <p class="text-xs font-black text-slate-800" id="detailsMetaHours">--:--</p>
                            </div>
                        </div>

                        <!-- Timeline SVG Diagram -->
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Punch Logs Timeline</h4>
                            <div class="relative pl-6 space-y-6 border-l-2 border-slate-100 ml-3 py-1">
                                <!-- Node 1: Check In -->
                                <div class="relative">
                                    <span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white ring-4 ring-emerald-100"></span>
                                    <div class="flex justify-between items-baseline gap-2">
                                        <h5 class="text-xs font-black text-slate-800">Checked In</h5>
                                        <span class="text-[10px] font-bold text-slate-400" id="detailsTimeIn">--:--</span>
                                    </div>
                                    <p class="text-[11px] font-medium text-slate-500 mt-1">Logged from Desk IP (WN-Headquarters Hub)</p>
                                </div>

                                <!-- Node 2: Lunch Break Start -->
                                <div class="relative">
                                    <span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-indigo-400 border-4 border-white ring-4 ring-indigo-50"></span>
                                    <div class="flex justify-between items-baseline gap-2">
                                        <h5 class="text-xs font-black text-slate-800">Break Started</h5>
                                        <span class="text-[10px] font-bold text-slate-400" id="detailsTimeBreakStart">--:--</span>
                                    </div>
                                    <p class="text-[11px] font-medium text-slate-500 mt-1">Self-reported lunch break duration log</p>
                                </div>

                                <!-- Node 3: Lunch Break End -->
                                <div class="relative">
                                    <span class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-indigo-500 border-4 border-white ring-4 ring-indigo-50"></span>
                                    <div class="flex justify-between items-baseline gap-2">
                                        <h5 class="text-xs font-black text-slate-800">Break Completed</h5>
                                        <span class="text-[10px] font-bold text-slate-400" id="detailsTimeBreakEnd">--:--</span>
                                    </div>
                                    <p class="text-[11px] font-medium text-slate-500 mt-1">Returned to work station</p>
                                </div>

                                <!-- Node 4: Check Out -->
                                <div class="relative">
                                    <span id="detailsTimelineOutNode" class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-300 border-4 border-white ring-4 ring-slate-100"></span>
                                    <div class="flex justify-between items-baseline gap-2">
                                        <h5 class="text-xs font-black text-slate-800" id="detailsOutLabel">Checked Out</h5>
                                        <span class="text-[10px] font-bold text-slate-400" id="detailsTimeOut">--:--</span>
                                    </div>
                                    <p class="text-[11px] font-medium text-slate-500 mt-1" id="detailsOutDesc">Day log completed, system signed off</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-slate-50 px-6 py-4 flex justify-end rounded-b-3xl border-t border-slate-100">
                        <button onclick="closeDetailsModal()" class="px-5 py-2 bg-slate-900 rounded-xl text-sm font-bold text-white hover:bg-slate-800 transition-all shadow-sm cursor-pointer">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Export Configurations -->
    <div id="exportModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Premium Glass Backdrop -->
        <div id="exportModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="closeExportModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6 lg:p-8">
                <div id="exportModalPanel" class="relative w-full max-w-md transform bg-white rounded-3xl shadow-2xl border border-slate-100/80 text-left transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 my-8">
                    <!-- Header -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 shadow-sm border border-brand-100/50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Export Attendance Logs</h3>
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Select file format and details to export.</p>
                            </div>
                        </div>
                        <button onclick="closeExportModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-xl transition-all border border-transparent hover:border-slate-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form onsubmit="downloadLogReport(event)" class="m-0">
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">File Format</label>
                                <select id="exportFormat" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                    <option value="xlsx">Excel Document (.xlsx)</option>
                                    <option value="csv">CSV (Comma Separated Values)</option>
                                    <option value="json">JSON Structured Data</option>
                                    <option value="pdf">PDF Document (Print View)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Date Range</label>
                                <select id="exportRange" onchange="toggleCustomExportDates(this.value)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                    <option value="today">Today Only</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="week">Last 7 Days</option>
                                    <option value="month">Current Month</option>
                                    <option value="custom">Custom Date Range...</option>
                                </select>
                            </div>
                            <div id="customExportDates" class="grid grid-cols-2 gap-4 hidden">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Start Date</label>
                                    <input type="date" id="exportStartDate" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">End Date</label>
                                    <input type="date" id="exportEndDate" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 rounded-b-3xl border-t border-slate-100">
                            <button type="button" onclick="closeExportModal()" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all shadow-sm cursor-pointer">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-brand-600 rounded-xl text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm cursor-pointer">Export Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: View Time Correction Details / Approve or Reject -->
    <div id="correctionDetailViewModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Premium Glass Backdrop -->
        <div id="correctionDetailViewModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity duration-300 opacity-0" onclick="closeCorrectionDetailModal()"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6 lg:p-8">
                <div id="correctionDetailViewModalPanel" class="relative w-full max-w-md transform bg-white rounded-3xl shadow-2xl border border-slate-100/80 text-left transition-all duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 my-8">
                    <!-- Header -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center rounded-t-3xl">
                        <div class="flex items-center gap-3">
                            <img id="detailViewAvatar" src="" alt="" class="w-10 h-10 rounded-full object-cover border shadow-sm shrink-0">
                            <div>
                                <h3 id="detailViewName" class="text-sm font-black text-slate-900 tracking-tight">Employee Name</h3>
                                <p id="detailViewID" class="text-[10px] text-slate-500 font-bold font-mono uppercase mt-0.5">WN-0000</p>
                            </div>
                        </div>
                        <span id="detailViewStatusBadge" class="inline-flex items-center px-2 py-0.5 text-[9px] font-black rounded-md border uppercase">PENDING</span>
                    </div>

                    <!-- Body -->
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4 text-xs font-semibold text-slate-600">
                            <div>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Department</span>
                                <span id="detailViewDept" class="text-slate-800 font-bold">Engineering</span>
                            </div>
                            <div>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Correction Date</span>
                                <span id="detailViewDate" class="text-slate-800 font-bold">2026-06-20</span>
                            </div>
                        </div>

                        <!-- Time comparison block -->
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2.5">
                            <h4 class="text-[9px] font-bold text-slate-450 uppercase tracking-wider">Adjustment Request Details</h4>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-semibold">Check-In Time:</span>
                                <div class="flex items-center gap-1.5 font-bold">
                                    <span id="detailViewCurrentIn" class="line-through text-slate-400 text-[10px]">09:02 AM</span>
                                    <svg class="w-3 h-3 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    <span id="detailViewRequestedIn" class="text-brand-600 font-black">09:00 AM</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400 font-semibold">Check-Out Time:</span>
                                <div class="flex items-center gap-1.5 font-bold">
                                    <span id="detailViewCurrentOut" class="line-through text-slate-400 text-[10px]">06:02 PM</span>
                                    <svg class="w-3 h-3 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    <span id="detailViewRequestedOut" class="text-brand-600 font-black">06:00 PM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Reason block -->
                        <div>
                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Reason for Adjustment</span>
                            <div class="p-3 bg-slate-50 border border-slate-150 rounded-xl text-xs text-slate-650 font-medium italic">
                                "<span id="detailViewReason">Biometric reader failed</span>"
                            </div>
                        </div>

                        <!-- Audit metadata (History only) -->
                        <div id="detailViewAuditMetaBox" class="hidden text-[10px] text-slate-500 font-semibold bg-slate-100/50 p-3 rounded-xl border border-slate-150 space-y-1">
                            <div>Processed At: <span id="detailViewProcessedTime" class="text-slate-700 font-bold">--</span></div>
                            <div>Audited By: <span id="detailViewProcessedBy" class="text-slate-700 font-bold">--</span></div>
                        </div>
                    </div>

                    <!-- Footer: Dynamic Actions based on pending/history -->
                    <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3 rounded-b-3xl border-t border-slate-100">
                        <div id="detailViewPendingActions" class="flex gap-2 w-full">
                            <button id="detailViewRejectBtn" type="button" class="flex-1 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 font-extrabold text-xs rounded-xl transition-colors border border-rose-150 flex items-center justify-center gap-1 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Reject Request
                            </button>
                            <button id="detailViewApproveBtn" type="button" class="flex-1 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-extrabold text-xs rounded-xl transition-all border border-emerald-150 flex items-center justify-center gap-1 cursor-pointer">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Approve Request
                            </button>
                        </div>
                        <div id="detailViewHistoryActions" class="hidden w-full flex justify-end">
                            <button type="button" onclick="closeCorrectionDetailModal()" class="px-5 py-2 bg-slate-900 rounded-xl text-xs font-bold text-white hover:bg-slate-800 transition-all shadow-sm cursor-pointer">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Toast Notifications Container -->
    <div id="toastContainer" class="fixed top-5 right-5 z-[200] flex flex-col gap-3 pointer-events-none"></div>

    @push('scripts')
    <!-- SheetJS for client-side Excel exports -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js" defer></script>
    <script>
        // System wide mock employees dictionary
        const employeesData = [
            { key: 1, name: "Vikram Pal", id: "WN-0001", email: "vikram@worknest.com", dept: "Engineering", role: "Tech Lead", avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" },
            { key: 2, name: "Aisha Sharma", id: "WN-0002", email: "aisha@worknest.com", dept: "Design", role: "UI/UX Designer", avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" },
            { key: 3, name: "Rohan Mehta", id: "WN-0003", email: "rohan@worknest.com", dept: "Engineering", role: "Senior Frontend Dev", avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" },
            { key: 4, name: "Sneha Rao", id: "WN-0004", email: "sneha@worknest.com", dept: "Human Resources", role: "HR Specialist", avatar: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=100" },
            { key: 5, name: "Kabir Singh", id: "WN-0005", email: "kabir@worknest.com", dept: "Sales", role: "Account Executive", avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=100" },
            { key: 6, name: "Priya Patel", id: "WN-0006", email: "priya@worknest.com", dept: "Marketing", role: "Marketing Associate", avatar: "https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=100" },
            { key: 7, name: "Arjun Verma", id: "WN-0007", email: "arjun@worknest.com", dept: "Engineering", role: "QA Automation Lead", avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=100" },
            { key: 8, name: "Ananya Sen", id: "WN-0008", email: "ananya@worknest.com", dept: "Marketing", role: "Content Copywriter", avatar: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=100" }
        ];

        // Core Attendance Logs Dataset (dynamic client state)
        let attendanceLogs = [
            { id: 101, empKey: 1, date: "2026-06-21", inTime: "09:24 AM", outTime: "--:--", hours: "--", status: "Late", breakStart: "01:15 PM", breakEnd: "02:00 PM", workMode: "Office", locationDetails: "WN-Headquarters" },
            { id: 102, empKey: 2, date: "2026-06-21", inTime: "08:52 AM", outTime: "--:--", hours: "--", status: "On Time", breakStart: null, breakEnd: null, workMode: "WFH", locationDetails: "Home Office" },
            { id: 103, empKey: 4, date: "2026-06-21", inTime: "08:58 AM", outTime: "--:--", hours: "--", status: "On Time", breakStart: null, breakEnd: null, workMode: "Field", locationDetails: "Tata Consultancy Services - Client Site (19.0760° N, 72.8777° E)" },
            { id: 104, empKey: 5, date: "2026-06-21", inTime: "09:05 AM", outTime: "05:00 PM", hours: "7h 55m", status: "Checked Out", breakStart: "01:00 PM", breakEnd: "02:00 PM", workMode: "Office", locationDetails: "WN-Headquarters" },
            { id: 105, empKey: 7, date: "2026-06-21", inTime: "09:42 AM", outTime: "--:--", hours: "--", status: "Late", breakStart: null, breakEnd: null, workMode: "WFH", locationDetails: "Home Office" },
            { id: 106, empKey: 8, date: "2026-06-21", inTime: "08:45 AM", outTime: "--:--", hours: "--", status: "On Break", breakStart: "12:30 PM", breakEnd: null, workMode: "Office", locationDetails: "WN-Headquarters" },
            { id: 107, empKey: 3, date: "2026-06-21", inTime: "--", outTime: "--", hours: "--", status: "On Leave", breakStart: null, breakEnd: null, workMode: null, locationDetails: null },
            { id: 108, empKey: 6, date: "2026-06-21", inTime: "--", outTime: "--", hours: "--", status: "Absent", breakStart: null, breakEnd: null, workMode: null, locationDetails: null },
            
            // Historical entries for searching/filtering
            { id: 109, empKey: 1, date: "2026-06-20", inTime: "08:55 AM", outTime: "06:05 PM", hours: "9h 10m", status: "On Time", breakStart: "01:00 PM", breakEnd: "01:45 PM", workMode: "Office", locationDetails: "WN-Headquarters" },
            { id: 110, empKey: 2, date: "2026-06-20", inTime: "08:48 AM", outTime: "06:00 PM", hours: "9h 12m", status: "On Time", breakStart: "01:10 PM", breakEnd: "02:00 PM", workMode: "WFH", locationDetails: "Home Office" },
            { id: 111, empKey: 4, date: "2026-06-20", inTime: "09:01 AM", outTime: "06:00 PM", hours: "8h 59m", status: "On Time", breakStart: "01:00 PM", breakEnd: "01:50 PM", workMode: "Field", locationDetails: "DLF CyberCity Sales Visit (28.4595° N, 77.0266° E)" },
            { id: 112, empKey: 5, date: "2026-06-20", inTime: "09:02 AM", outTime: "06:02 PM", hours: "9h 00m", status: "On Time", breakStart: "01:15 PM", breakEnd: "02:00 PM", workMode: "Office", locationDetails: "WN-Headquarters" },
            { id: 113, empKey: 7, date: "2026-06-20", inTime: "09:35 AM", outTime: "06:10 PM", hours: "8h 35m", status: "Late", breakStart: "01:00 PM", breakEnd: "02:00 PM", workMode: "Office", locationDetails: "WN-Headquarters" }
        ];

        // Pending Admin Correction Requests
        let correctionRequests = [
            { id: 1, empKey: 5, date: "2026-06-20", currentIn: "09:02 AM", requestedIn: "09:00 AM", currentOut: "06:02 PM", requestedOut: "06:00 PM", reason: "Fingerprint reader failed to register on first attempt", submitTime: "Yesterday" },
            { id: 2, empKey: 2, date: "2026-06-19", currentIn: "09:12 AM", requestedIn: "08:48 AM", currentOut: "05:45 PM", requestedOut: "06:00 PM", reason: "Power failure in building, logged off manually earlier", submitTime: "2 days ago" }
        ];

        // Archived Time Correction Requests (Audit Trail Proof)
        let correctionHistory = [
            { id: 901, empKey: 4, date: "2026-06-18", currentIn: "09:22 AM", requestedIn: "08:58 AM", currentOut: "06:00 PM", requestedOut: "06:00 PM", reason: "Train delayed, worked on laptop during transit", submitTime: "3 days ago", status: "Approved", processedTime: "Yesterday, 11:30 AM", processedBy: "Alex Rivera (HR)" },
            { id: 902, empKey: 7, date: "2026-06-17", currentIn: "10:15 AM", requestedIn: "09:00 AM", currentOut: "06:12 PM", requestedOut: "06:00 PM", reason: "Client meeting went long", submitTime: "4 days ago", status: "Rejected", processedTime: "2 days ago, 04:15 PM", processedBy: "Alex Rivera (HR)" }
        ];

        // Client State Variables
        let filteredLogs = [];
        let currentPage = 1;
        const recordsPerPage = 5;

        // Work Mode State
        let selectedWorkMode = "Office"; // "Office", "WFH", "Field"
        let fieldSiteName = "";

        // Stopwatch State
        let stopwatchTimer = null;
        let elapsedSeconds = 0;
        let clockState = "out"; // "in" or "out"

        // Initialize Page
        document.addEventListener('DOMContentLoaded', () => {
            // Set Today's Date in picker and headers
            const todayStr = getTodayDateString();
            document.getElementById('attendanceLogDate').value = todayStr;
            
            // Format nice display date for header
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const todayFormatted = new Date().toLocaleDateString('en-US', options);
            document.getElementById('currentDateHeader').innerText = `Today is ${todayFormatted}. Track, filter, and export log details.`;

            // Load Clock State from localStorage
            initClockState();

            // Populate Employee Selector in Correction Modal
            populateEmployeeSelect();

            // Initial Filter Rendering
            applyFilters();

            // Render Correction Requests list
            renderCorrectionRequests();

            // Render Correction History list
            renderCorrectionHistory();
        });

        function getTodayDateString() {
            const d = new Date();
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // --- Work Mode Selection ---
        function setWorkMode(mode) {
            if (clockState === 'in') return;
            selectedWorkMode = mode;
            updateWorkModeSelectorsUI();
        }

        function updateFieldSiteName(val) {
            fieldSiteName = val.trim();
        }

        function updateWorkModeSelectorsUI() {
            const btnOffice = document.getElementById('modeBtnOffice');
            const btnWFH = document.getElementById('modeBtnWFH');
            const btnField = document.getElementById('modeBtnField');
            
            const fieldPanel = document.getElementById('fieldDutyPanel');
            const wfhPanel = document.getElementById('wfhPanel');

            // Reset classes
            [btnOffice, btnWFH, btnField].forEach(btn => {
                btn.className = "flex-1 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer text-slate-500 hover:text-slate-800";
            });

            // Set active class
            let activeBtn;
            if (selectedWorkMode === 'Office') {
                activeBtn = btnOffice;
                fieldPanel.classList.add('hidden');
                wfhPanel.classList.add('hidden');
            } else if (selectedWorkMode === 'WFH') {
                activeBtn = btnWFH;
                fieldPanel.classList.add('hidden');
                wfhPanel.classList.remove('hidden');
            } else if (selectedWorkMode === 'Field') {
                activeBtn = btnField;
                fieldPanel.classList.remove('hidden');
                wfhPanel.classList.add('hidden');
            }

            if (activeBtn) {
                activeBtn.className = "flex-1 py-2 text-[10px] font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer bg-white text-slate-900 shadow-xs border border-slate-200/50";
            }
        }

        // --- Clock-In / Clock-Out Logic ---
        function initClockState() {
            const savedState = localStorage.getItem('wn_clock_state');
            const savedStart = localStorage.getItem('wn_clock_start_time');
            const savedWorkModeStr = localStorage.getItem('wn_clock_work_mode');
            const savedSiteNameStr = localStorage.getItem('wn_clock_site_name');

            if (savedWorkModeStr) {
                selectedWorkMode = savedWorkModeStr;
                fieldSiteName = savedSiteNameStr || "";
                document.getElementById('fieldSiteInput').value = fieldSiteName;
                updateWorkModeSelectorsUI();
            }

            if (savedState === 'in' && savedStart) {
                clockState = 'in';
                const startTime = parseInt(savedStart, 10);
                const now = Date.now();
                elapsedSeconds = Math.floor((now - startTime) / 1000);

                // Update UI elements
                setClockInUI();
                startStopwatch();
            } else {
                setClockOutUI();
            }
        }

        function toggleClock() {
            if (clockState === 'out') {
                // Clocking In
                clockState = 'in';
                elapsedSeconds = 0;
                const startTime = Date.now();
                localStorage.setItem('wn_clock_state', 'in');
                localStorage.setItem('wn_clock_start_time', startTime.toString());
                localStorage.setItem('wn_clock_work_mode', selectedWorkMode);
                localStorage.setItem('wn_clock_site_name', fieldSiteName);

                // Set check-in time for feedback
                const timeString = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                localStorage.setItem('wn_clock_in_time_str', timeString);

                setClockInUI();
                startStopwatch();

                // Save dynamic check-in log to our local array for current user (Vikram Pal, key: 1)
                const todayStr = getTodayDateString();
                // Remove existing check-in today if any, to simulate fresh check-in
                attendanceLogs = attendanceLogs.filter(log => !(log.empKey === 1 && log.date === todayStr));
                
                attendanceLogs.unshift({
                    id: Date.now(),
                    empKey: 1,
                    date: todayStr,
                    inTime: timeString,
                    outTime: "--:--",
                    hours: "--",
                    status: isLate(new Date()) ? "Late" : "On Time",
                    breakStart: null,
                    breakEnd: null,
                    workMode: selectedWorkMode,
                    locationDetails: selectedWorkMode === 'Office' ? 'WN-Headquarters' : (selectedWorkMode === 'WFH' ? 'Home Office' : (fieldSiteName ? fieldSiteName : 'Field Duty') + ' (19.0760° N, 72.8777° E)')
                });

                applyFilters();
                updateOverviewStats();
                showToast("Success", `Clocked in successfully at ${timeString}!`, "success");
            } else {
                // Clocking Out
                clockState = 'out';
                clearInterval(stopwatchTimer);
                
                const clockInStr = localStorage.getItem('wn_clock_in_time_str') || "09:00 AM";
                const clockOutTime = new Date();
                const clockOutStr = clockOutTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                
                // Calculate work hours
                const workHoursStr = formatElapsedHours(elapsedSeconds);

                const savedWorkMode = localStorage.getItem('wn_clock_work_mode') || 'Office';
                const savedSiteName = localStorage.getItem('wn_clock_site_name') || '';

                localStorage.removeItem('wn_clock_state');
                localStorage.removeItem('wn_clock_start_time');
                localStorage.removeItem('wn_clock_in_time_str');
                localStorage.removeItem('wn_clock_work_mode');
                localStorage.removeItem('wn_clock_site_name');

                setClockOutUI();

                // Update employee log row in attendanceLogs array
                const todayStr = getTodayDateString();
                const userLog = attendanceLogs.find(log => log.empKey === 1 && log.date === todayStr);
                if (userLog) {
                    userLog.outTime = clockOutStr;
                    userLog.hours = workHoursStr;
                    userLog.status = "Checked Out";
                    userLog.workMode = savedWorkMode;
                    userLog.locationDetails = savedWorkMode === 'Office' ? 'WN-Headquarters' : (savedWorkMode === 'WFH' ? 'Home Office' : (savedSiteName ? savedSiteName : 'Field Duty') + ' (19.0760° N, 72.8777° E)');
                }

                applyFilters();
                updateOverviewStats();
                showToast("Info", `Clocked out at ${clockOutStr}. Logged ${workHoursStr} of work.`, "info");
            }
        }

        function isLate(checkInDate) {
            // Cutoff is 09:15 AM
            const hour = checkInDate.getHours();
            const minute = checkInDate.getMinutes();
            if (hour > 9) return true;
            if (hour === 9 && minute > 15) return true;
            return false;
        }

        function startStopwatch() {
            stopwatchTimer = setInterval(() => {
                elapsedSeconds++;
                document.getElementById('stopwatch').innerText = formatTimerValue(elapsedSeconds);
            }, 1000);
        }

        function formatTimerValue(totalSeconds) {
            const h = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const m = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const s = String(totalSeconds % 60).padStart(2, '0');
            return `${h}:${m}:${s}`;
        }

        function formatElapsedHours(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            if (hours > 0) {
                return `${hours}h ${minutes}m`;
            }
            return `${minutes}m`;
        }

        function setClockInUI() {
            const clockBtn = document.getElementById('clockBtn');
            const btnIcon = document.getElementById('clockBtnIcon');
            const btnText = document.getElementById('clockBtnText');
            const dot = document.getElementById('statusIndicatorDot');
            const statusText = document.getElementById('statusIndicatorText');
            const details = document.getElementById('activePunchDetails');
            const timeLog = document.getElementById('punchTimeLog');

            // Button styling -> Shift to Out style
            clockBtn.className = "w-full py-3.5 rounded-xl bg-linear-to-r from-rose-600 to-orange-600 hover:from-rose-700 hover:to-orange-700 text-white font-extrabold text-sm tracking-wide shadow-md transition-all active:scale-[0.98] cursor-pointer flex items-center justify-center gap-2";
            btnText.innerText = "Clock Out";
            btnIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>`;

            // Pulse ring and text
            dot.className = "w-2.5 h-2.5 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.6)] animate-pulse";
            statusText.innerText = "Active Work Session";
            statusText.className = "text-xs font-bold text-emerald-600 uppercase tracking-wider";

            // Disable Work Mode selector during session
            document.getElementById('workModeSelector').classList.add('opacity-50', 'pointer-events-none');
            document.getElementById('fieldSiteInput').setAttribute('disabled', 'true');

            // Show active check-in punch log details
            const logStr = localStorage.getItem('wn_clock_in_time_str') || "09:00 AM";
            timeLog.innerText = logStr;
            details.classList.remove('hidden');
        }

        function setClockOutUI() {
            const clockBtn = document.getElementById('clockBtn');
            const btnIcon = document.getElementById('clockBtnIcon');
            const btnText = document.getElementById('clockBtnText');
            const dot = document.getElementById('statusIndicatorDot');
            const statusText = document.getElementById('statusIndicatorText');
            const details = document.getElementById('activePunchDetails');

            document.getElementById('stopwatch').innerText = "00:00:00";

            // Button styling -> Reset to In style
            clockBtn.className = "w-full py-3.5 rounded-xl bg-linear-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-extrabold text-sm tracking-wide shadow-md transition-all active:scale-[0.98] cursor-pointer flex items-center justify-center gap-2";
            btnText.innerText = "Clock In";
            btnIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>`;

            // Reset status indicator
            dot.className = "w-2.5 h-2.5 bg-rose-500 rounded-full shadow-[0_0_8px_rgba(244,63,94,0.6)] animate-pulse";
            statusText.innerText = "Not Clocked In";
            statusText.className = "text-xs font-bold text-slate-500 uppercase tracking-wider";

            // Re-enable Work Mode selector
            document.getElementById('workModeSelector').classList.remove('opacity-50', 'pointer-events-none');
            document.getElementById('fieldSiteInput').removeAttribute('disabled');

            // Hide details
            details.classList.add('hidden');
        }

        // --- Data Dictionary Helper Actions ---
        function populateEmployeeSelect() {
            const selectEl = document.getElementById('correctionEmployee');
            if (!selectEl) return;
            selectEl.innerHTML = '';
            employeesData.forEach(emp => {
                const opt = document.createElement('option');
                opt.value = emp.key;
                opt.innerText = `${emp.name} (${emp.id}) - ${emp.role}`;
                selectEl.appendChild(opt);
            });
        }

        // --- Table Rendering, Filtering and Search ---
        function changeLogDate(days) {
            const dateInput = document.getElementById('attendanceLogDate');
            const currentVal = new Date(dateInput.value);
            if (isNaN(currentVal.getTime())) return;
            
            currentVal.setDate(currentVal.getDate() + days);
            
            const y = currentVal.getFullYear();
            const m = String(currentVal.getMonth() + 1).padStart(2, '0');
            const d = String(currentVal.getDate()).padStart(2, '0');
            
            dateInput.value = `${y}-${m}-${d}`;
            applyFilters();
        }

        function applyFilters() {
            const searchVal = document.getElementById('attendanceSearch').value.toLowerCase().trim();
            const dateVal = document.getElementById('attendanceLogDate').value;
            const deptVal = document.getElementById('attendanceFilterDept').value;
            const statusVal = document.getElementById('attendanceFilterStatus').value;
            const modeVal = document.getElementById('attendanceFilterMode').value;

            filteredLogs = attendanceLogs.filter(log => {
                const emp = employeesData.find(e => e.key === log.empKey);
                if (!emp) return false;

                // Match Date
                if (dateVal && log.date !== dateVal) return false;

                // Match Search (Name or ID)
                if (searchVal) {
                    const matchName = emp.name.toLowerCase().includes(searchVal);
                    const matchId = emp.id.toLowerCase().includes(searchVal);
                    if (!matchName && !matchId) return false;
                }

                // Match Department
                if (deptVal && emp.dept !== deptVal) return false;

                // Match Status
                if (statusVal) {
                    if (statusVal === 'On Time' && log.status !== 'On Time') return false;
                    if (statusVal === 'Late' && log.status !== 'Late') return false;
                    if (statusVal === 'On Break' && log.status !== 'On Break') return false;
                    if (statusVal === 'Checked Out' && log.status !== 'Checked Out') return false;
                    if (statusVal === 'Absent' && log.status !== 'Absent') return false;
                    if (statusVal === 'On Leave' && log.status !== 'On Leave') return false;
                }

                // Match Work Mode
                if (modeVal && log.workMode !== modeVal) return false;

                return true;
            });

            currentPage = 1;
            renderAttendanceList();
            updateOverviewStats();
        }

        function resetFilters() {
            document.getElementById('attendanceSearch').value = '';
            document.getElementById('attendanceLogDate').value = getTodayDateString();
            document.getElementById('attendanceFilterDept').value = '';
            document.getElementById('attendanceFilterStatus').value = '';
            document.getElementById('attendanceFilterMode').value = '';
            applyFilters();
        }

        function renderAttendanceList() {
            const tbody = document.getElementById('attendanceTableBody');
            const mobileBody = document.getElementById('attendanceMobileBody');
            
            tbody.innerHTML = '';
            mobileBody.innerHTML = '';

            const totalRecords = filteredLogs.length;
            
            if (totalRecords === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="px-6 py-12 text-center text-slate-400 font-medium">No attendance logs found matching the filter criteria.</td></tr>`;
                mobileBody.innerHTML = `<div class="py-8 text-center text-slate-400 font-medium">No attendance logs found.</div>`;
                document.getElementById('attendancePaginationInfo').innerText = "Showing 0 of 0 entries";
                renderPaginationControls(0);
                return;
            }

            // Slice data for pagination
            const startIndex = (currentPage - 1) * recordsPerPage;
            const endIndex = Math.min(startIndex + recordsPerPage, totalRecords);
            const paginatedItems = filteredLogs.slice(startIndex, endIndex);

            // Update Pagination Text
            document.getElementById('attendancePaginationInfo').innerText = `Showing ${startIndex + 1} to ${endIndex} of ${totalRecords} entries`;

            paginatedItems.forEach(log => {
                const emp = employeesData.find(e => e.key === log.empKey);
                if (!emp) return;

                // Render Desktop Row
                const row = document.createElement('tr');
                row.className = "hover:bg-slate-50/50 transition-colors group";
                row.innerHTML = `
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-3">
                            <img src="${emp.avatar}" alt="${emp.name}" class="w-9 h-9 rounded-full object-cover border border-slate-100 shadow-sm shrink-0">
                            <div>
                                <span class="block text-slate-900 font-bold tracking-tight">${emp.name}</span>
                                <span class="block text-[11px] text-slate-400 font-bold font-mono uppercase mt-0.5">${emp.id}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="text-slate-600 font-semibold">${emp.dept}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="font-bold ${log.status === 'Late' ? 'text-amber-600 bg-amber-50 px-2 py-1 rounded-lg border border-amber-100/50' : 'text-slate-700'}">${log.inTime}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="text-slate-700 font-semibold">${log.outTime}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="font-mono font-bold text-slate-700">${log.hours}</span>
                    </td>
                    <td class="px-6 py-3.5">
                        ${getWorkModeBadgeHtml(log.workMode, log.locationDetails)}
                    </td>
                    <td class="px-6 py-3.5">
                        ${getStatusBadgeHtml(log.status)}
                    </td>
                    <td class="px-6 py-3.5 text-right">
                        <div class="relative inline-block text-left action-dropdown-container">
                            <button type="button" class="action-dropdown-btn p-1.5 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-slate-600 border border-transparent hover:border-slate-200 transition-all cursor-pointer shadow-none">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z"/></svg>
                            </button>
                            <div class="action-dropdown-menu absolute right-0 mt-1.5 w-44 bg-white rounded-xl shadow-xl border border-slate-150 py-1.5 z-40" role="menu">
                                <a href="javascript:void(0)" onclick="openDetailsModal(${log.id})" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors" role="menuitem">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    View Log Details
                                </a>
                                <a href="javascript:void(0)" onclick="triggerSingleCorrection(${log.id})" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors" role="menuitem">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Adjust Time Logs
                                </a>
                                <div class="h-px bg-slate-100 my-1"></div>
                                <a href="javascript:void(0)" onclick="toggleSingleStatus(${log.id})" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors" role="menuitem">
                                    <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Toggle Presence
                                </a>
                            </div>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);

                // Render Mobile Card
                const card = document.createElement('div');
                card.className = "py-4 space-y-3";
                card.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <img src="${emp.avatar}" alt="${emp.name}" class="w-8.5 h-8.5 rounded-full object-cover border">
                            <div>
                                <h4 class="text-xs font-extrabold text-slate-900">${emp.name}</h4>
                                <p class="text-[10px] text-slate-400 font-bold font-mono">${emp.id} - ${emp.dept}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            ${getWorkModeBadgeHtml(log.workMode, log.locationDetails)}
                            ${getStatusBadgeHtml(log.status)}
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100 text-center text-slate-600 text-xs">
                        <div>
                            <span class="block text-[9px] text-slate-400 font-bold uppercase mb-0.5">In</span>
                            <span class="font-bold ${log.status === 'Late' ? 'text-amber-600' : 'text-slate-800'}">${log.inTime}</span>
                        </div>
                        <div class="border-x border-slate-200">
                            <span class="block text-[9px] text-slate-400 font-bold uppercase mb-0.5">Out</span>
                            <span class="font-bold text-slate-800">${log.outTime}</span>
                        </div>
                        <div>
                            <span class="block text-[9px] text-slate-400 font-bold uppercase mb-0.5">Hours</span>
                            <span class="font-bold font-mono text-slate-800">${log.hours}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-end pt-1">
                        <button onclick="openDetailsModal(${log.id})" class="px-3 py-1.5 border border-slate-200 rounded-lg text-[10px] font-extrabold text-slate-600 hover:bg-slate-50 transition-colors cursor-pointer">Timeline</button>
                        <button onclick="triggerSingleCorrection(${log.id})" class="px-3 py-1.5 border border-slate-200 rounded-lg text-[10px] font-extrabold text-slate-600 hover:bg-slate-50 transition-colors cursor-pointer">Adjust</button>
                    </div>
                `;
                mobileBody.appendChild(card);
            });

            // Render Pagination Buttons
            renderPaginationControls(totalRecords);
        }

        function getWorkModeBadgeHtml(mode, locationDetails) {
            if (!mode) return '<span class="text-slate-400 font-bold">-</span>';
            const locInfo = locationDetails ? locationDetails.replace(/"/g, '&quot;') : '';
            switch (mode) {
                case 'Office':
                    return `
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-black tracking-wider text-blue-700 bg-blue-50 rounded-full border border-blue-100 uppercase" title="Office Location: ${locInfo}">
                            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Office
                        </span>
                    `;
                case 'WFH':
                    return `
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-black tracking-wider text-purple-700 bg-purple-50 rounded-full border border-purple-100 uppercase" title="Remote WFH IP: 192.168.1.145">
                            <svg class="w-3 h-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            WFH
                        </span>
                    `;
                case 'Field':
                    return `
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-black tracking-wider text-amber-700 bg-amber-50 rounded-full border border-amber-100 uppercase cursor-help group/mode relative" title="Client Site: ${locInfo}">
                            <svg class="w-3 h-3 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Field
                            <!-- Premium Map/Info Popover on Hover -->
                            <span class="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-56 p-2 bg-slate-900 text-white text-[9px] font-medium leading-relaxed rounded-xl shadow-xl border border-slate-700 opacity-0 group-hover/mode:opacity-100 transition-opacity duration-200 z-50 normal-case">
                                <span class="block font-black text-brand-400 mb-0.5 uppercase tracking-wider">📍 Visit Details</span>
                                <span class="block text-slate-200">${locInfo}</span>
                            </span>
                        </span>
                    `;
                default:
                    return '<span class="text-slate-400 font-bold">-</span>';
            }
        }

        function getStatusBadgeHtml(status) {
            switch (status) {
                case 'On Time':
                    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-black tracking-wider text-emerald-700 bg-emerald-50 rounded-full border border-emerald-100 uppercase">On Time</span>`;
                case 'Late':
                    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-black tracking-wider text-amber-700 bg-amber-50 rounded-full border border-amber-100 uppercase">Late</span>`;
                case 'On Break':
                    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-black tracking-wider text-indigo-700 bg-indigo-50 rounded-full border border-indigo-100 uppercase">On Break</span>`;
                case 'Checked Out':
                    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-black tracking-wider text-slate-600 bg-slate-100 rounded-full border border-slate-200 uppercase">Checked Out</span>`;
                case 'On Leave':
                    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-black tracking-wider text-brand-700 bg-brand-50 rounded-full border border-brand-100 uppercase">On Leave</span>`;
                case 'Absent':
                default:
                    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[10px] font-black tracking-wider text-rose-700 bg-rose-50 rounded-full border border-rose-100 uppercase">Absent</span>`;
            }
        }

        function renderPaginationControls(totalRecords) {
            const pagesCount = Math.ceil(totalRecords / recordsPerPage) || 1;
            const container = document.getElementById('attendancePaginationButtons');
            container.innerHTML = '';

            // Previous Button
            const prevBtn = document.createElement('button');
            const isPrevDisabled = currentPage === 1 || totalRecords === 0;
            prevBtn.className = `flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-500 transition-all ${isPrevDisabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : 'hover:bg-slate-50 cursor-pointer text-slate-600'}`;
            prevBtn.innerHTML = `
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                <span>Previous</span>
            `;
            if (isPrevDisabled) prevBtn.setAttribute('disabled', 'true');
            prevBtn.onclick = () => { if (currentPage > 1) { currentPage--; renderAttendanceList(); } };
            container.appendChild(prevBtn);

            // Pages Numbers
            const displayPages = Math.max(1, pagesCount);
            for (let i = 1; i <= displayPages; i++) {
                const btn = document.createElement('button');
                const isActive = currentPage === i && totalRecords > 0;
                btn.className = `w-8 h-8 rounded-lg text-xs font-bold transition-all ${isActive ? 'bg-brand-600 text-white shadow-sm cursor-default' : 'border border-slate-200 text-slate-600 hover:bg-slate-50 cursor-pointer'} ${totalRecords === 0 ? 'opacity-40 cursor-not-allowed pointer-events-none' : ''}`;
                btn.innerText = i;
                if (totalRecords === 0) btn.setAttribute('disabled', 'true');
                btn.onclick = () => { if (!isActive) { currentPage = i; renderAttendanceList(); } };
                container.appendChild(btn);
            }

            // Next Button
            const nextBtn = document.createElement('button');
            const isNextDisabled = currentPage === pagesCount || totalRecords === 0;
            nextBtn.className = `flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-bold text-slate-500 transition-all ${isNextDisabled ? 'opacity-40 cursor-not-allowed pointer-events-none' : 'hover:bg-slate-50 cursor-pointer text-slate-600'}`;
            nextBtn.innerHTML = `
                <span>Next</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            `;
            if (isNextDisabled) nextBtn.setAttribute('disabled', 'true');
            nextBtn.onclick = () => { if (currentPage < pagesCount) { currentPage++; renderAttendanceList(); } };
            container.appendChild(nextBtn);
        }

        // --- Summary Stats Syncing ---
        function updateOverviewStats() {
            const todayStr = getTodayDateString();
            const logDateVal = document.getElementById('attendanceLogDate').value;
            
            // Stats should query current selected log date logs
            const targetedLogs = attendanceLogs.filter(log => log.date === logDateVal);
            
            const totalEmployees = 148; // Constant
            const presentLogs = targetedLogs.filter(log => log.status === 'On Time' || log.status === 'Late' || log.status === 'On Break' || log.status === 'Checked Out');
            const presentCount = presentLogs.length;
            const lateCount = targetedLogs.filter(log => log.status === 'Late').length;
            const breakCount = targetedLogs.filter(log => log.status === 'On Break').length;
            const absentCount = targetedLogs.filter(log => log.status === 'Absent').length;

            const officeCount = presentLogs.filter(log => log.workMode === 'Office').length;
            const wfhCount = presentLogs.filter(log => log.workMode === 'WFH').length;
            const fieldCount = presentLogs.filter(log => log.workMode === 'Field').length;

            // Update UI elements
            document.getElementById('statPresentCount').innerText = presentCount;
            document.getElementById('statLateCount').innerText = lateCount;
            document.getElementById('statBreakCount').innerText = breakCount;
            document.getElementById('statAbsentCount').innerText = absentCount;

            document.getElementById('statOfficeCount').innerText = officeCount;
            document.getElementById('statWfhCount').innerText = wfhCount;
            document.getElementById('statFieldCount').innerText = fieldCount;

            // Update Progress Bar
            const rate = ((presentCount / totalEmployees) * 100).toFixed(1);
            document.getElementById('statPresentProgress').style.width = `${rate}%`;
        }

        // --- Corrections Search, Tabs & Detailed Modal Popup ---
        let correctionsSearchQuery = "";

        function toggleCorrectionsSearch(show) {
            const defHeader = document.getElementById('correctionsHeaderDefault');
            const searchHeader = document.getElementById('correctionsHeaderSearch');
            const input = document.getElementById('correctionsSearchInput');

            if (show) {
                // Hide default, show search
                defHeader.classList.remove('translate-x-0', 'opacity-100');
                defHeader.classList.add('-translate-x-full', 'opacity-0', 'pointer-events-none');

                searchHeader.classList.remove('translate-x-full', 'opacity-0', 'pointer-events-none');
                searchHeader.classList.add('translate-x-0', 'opacity-100', 'pointer-events-auto');
                
                setTimeout(() => input.focus(), 150);
            } else {
                // Hide search, show default
                searchHeader.classList.remove('translate-x-0', 'opacity-100', 'pointer-events-auto');
                searchHeader.classList.add('translate-x-full', 'opacity-0', 'pointer-events-none');

                defHeader.classList.remove('-translate-x-full', 'opacity-0', 'pointer-events-none');
                defHeader.classList.add('translate-x-0', 'opacity-100');
                
                clearCorrectionsSearch();
            }
        }

        function applyCorrectionsSearch() {
            const input = document.getElementById('correctionsSearchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            correctionsSearchQuery = input.value.toLowerCase().trim();

            if (correctionsSearchQuery) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            renderCorrectionRequests();
            renderCorrectionHistory();
        }

        function clearCorrectionsSearch() {
            const input = document.getElementById('correctionsSearchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            input.value = "";
            correctionsSearchQuery = "";
            clearBtn.classList.add('hidden');
            renderCorrectionRequests();
            renderCorrectionHistory();
        }

        // Open detailed view modal for a pending or history request
        function openCorrectionDetailModal(id, type) {
            let req = null;
            if (type === 'pending') {
                req = correctionRequests.find(r => r.id === id);
            } else {
                req = correctionHistory.find(r => r.id === id);
            }

            if (!req) return;
            const emp = employeesData.find(e => e.key === req.empKey);
            if (!emp) return;

            // Load header values
            document.getElementById('detailViewAvatar').src = emp.avatar;
            document.getElementById('detailViewAvatar').alt = emp.name;
            document.getElementById('detailViewName').innerText = emp.name;
            document.getElementById('detailViewID').innerText = `${emp.id} | ${emp.role}`;
            document.getElementById('detailViewDept').innerText = emp.dept;
            document.getElementById('detailViewDate').innerText = req.date;

            // Load details comparison
            document.getElementById('detailViewCurrentIn').innerText = req.currentIn || "--:--";
            document.getElementById('detailViewRequestedIn').innerText = req.requestedIn;
            document.getElementById('detailViewCurrentOut').innerText = req.currentOut || "--:--";
            document.getElementById('detailViewRequestedOut').innerText = req.requestedOut;
            document.getElementById('detailViewReason').innerText = req.reason;

            // Set badge and action buttons based on type
            const badge = document.getElementById('detailViewStatusBadge');
            const pendingActions = document.getElementById('detailViewPendingActions');
            const historyActions = document.getElementById('detailViewHistoryActions');
            const auditMetaBox = document.getElementById('detailViewAuditMetaBox');

            if (type === 'pending') {
                badge.className = "inline-flex items-center px-2 py-0.5 text-[9px] font-black rounded-md border uppercase bg-brand-50 text-brand-600 border-brand-100";
                badge.innerText = "Pending";

                pendingActions.classList.remove('hidden');
                historyActions.classList.add('hidden');
                auditMetaBox.classList.add('hidden');

                // Dynamic click events for approve/reject inside modal
                document.getElementById('detailViewApproveBtn').onclick = () => {
                    approveRequest(req.id);
                    closeCorrectionDetailModal();
                };
                document.getElementById('detailViewRejectBtn').onclick = () => {
                    rejectRequest(req.id);
                    closeCorrectionDetailModal();
                };
            } else {
                const badgeClass = req.status === 'Approved'
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-100/55'
                    : 'bg-rose-50 text-rose-700 border-rose-100/55';
                badge.className = `inline-flex items-center px-2 py-0.5 text-[9px] font-black rounded-md border uppercase ${badgeClass}`;
                badge.innerText = req.status;

                pendingActions.classList.add('hidden');
                historyActions.classList.remove('hidden');
                auditMetaBox.classList.remove('hidden');

                document.getElementById('detailViewProcessedTime').innerText = req.processedTime;
                document.getElementById('detailViewProcessedBy').innerText = req.processedBy;
            }

            // Launch Modal
            const modal = document.getElementById('correctionDetailViewModal');
            const backdrop = document.getElementById('correctionDetailViewModalBackdrop');
            const panel = document.getElementById('correctionDetailViewModalPanel');

            modal.classList.remove('hidden');
            void modal.offsetWidth; // force redraw
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            document.body.classList.add('overflow-hidden');
        }

        function closeCorrectionDetailModal() {
            const modal = document.getElementById('correctionDetailViewModal');
            const backdrop = document.getElementById('correctionDetailViewModalBackdrop');
            const panel = document.getElementById('correctionDetailViewModalPanel');

            if (!modal) return;
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // --- Correction Requests approvals panel ---
        function renderCorrectionRequests() {
            const container = document.getElementById('pendingCorrectionsContainer');
            const badge = document.getElementById('pendingCorrectionBadge');
            
            // Filter by search query
            const filteredPending = correctionRequests.filter(req => {
                const emp = employeesData.find(e => e.key === req.empKey);
                if (!emp) return false;
                if (!correctionsSearchQuery) return true;
                return emp.name.toLowerCase().includes(correctionsSearchQuery) || emp.id.toLowerCase().includes(correctionsSearchQuery);
            });
            
            container.innerHTML = '';
            badge.innerText = `${correctionRequests.length}`;

            if (filteredPending.length === 0) {
                container.innerHTML = `
                    <div class="h-40 flex flex-col items-center justify-center text-center p-4">
                        <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-slate-300 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-500">${correctionsSearchQuery ? 'No results found' : 'All caught up!'}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 font-medium">${correctionsSearchQuery ? 'Try checking your search term.' : 'No pending time card corrections.'}</p>
                    </div>
                `;
                return;
            }

            filteredPending.forEach(req => {
                const emp = employeesData.find(e => e.key === req.empKey);
                if (!emp) return;

                const card = document.createElement('div');
                card.onclick = () => openCorrectionDetailModal(req.id, 'pending');
                card.className = "flex items-center justify-between p-3 bg-slate-50/70 hover:bg-slate-100/80 border border-slate-150 hover:border-brand-300 rounded-xl transition-all cursor-pointer group shadow-xs";
                card.innerHTML = `
                    <div class="flex items-center gap-2.5 min-w-0">
                        <img src="${emp.avatar}" alt="${emp.name}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm shrink-0">
                        <div class="min-w-0">
                            <span class="block text-xs font-extrabold text-slate-800 truncate group-hover:text-brand-600 transition-colors">${emp.name}</span>
                            <span class="block text-[9px] text-slate-400 font-bold font-mono uppercase mt-0.5">${emp.id}</span>
                        </div>
                    </div>
                    <div class="text-right shrink-0 flex flex-col items-end gap-1">
                        <span class="text-[9px] font-bold text-slate-400 font-mono">${req.date}</span>
                        <span class="inline-flex items-center px-1.5 py-0.5 text-[8px] font-black bg-brand-50 text-brand-600 border border-brand-100 rounded-md uppercase">Pending</span>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function switchCorrectionsTab(tab) {
            const tabPending = document.getElementById('tabCorrectionsPending');
            const tabHistory = document.getElementById('tabCorrectionsHistory');
            const containerPending = document.getElementById('pendingCorrectionsContainer');
            const containerHistory = document.getElementById('historyCorrectionsContainer');

            if (tab === 'pending') {
                tabPending.className = "text-xs font-black uppercase tracking-wider pb-2.5 border-b-2 border-brand-600 text-brand-600 transition-all cursor-pointer h-full";
                tabHistory.className = "text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-wider pb-2.5 border-b-2 border-transparent transition-all cursor-pointer h-full";
                containerPending.classList.remove('hidden');
                containerHistory.classList.add('hidden');
                renderCorrectionRequests();
            } else {
                tabHistory.className = "text-xs font-black uppercase tracking-wider pb-2.5 border-b-2 border-brand-600 text-brand-600 transition-all cursor-pointer h-full";
                tabPending.className = "text-xs font-bold text-slate-400 hover:text-slate-600 uppercase tracking-wider pb-2.5 border-b-2 border-transparent transition-all cursor-pointer h-full";
                containerHistory.classList.remove('hidden');
                containerPending.classList.add('hidden');
                renderCorrectionHistory();
            }
        }

        function renderCorrectionHistory() {
            const container = document.getElementById('historyCorrectionsContainer');
            if (!container) return;
            
            // Filter by search query
            const filteredHistory = correctionHistory.filter(item => {
                const emp = employeesData.find(e => e.key === item.empKey);
                if (!emp) return false;
                if (!correctionsSearchQuery) return true;
                return emp.name.toLowerCase().includes(correctionsSearchQuery) || emp.id.toLowerCase().includes(correctionsSearchQuery);
            });

            container.innerHTML = '';

            if (filteredHistory.length === 0) {
                container.innerHTML = `
                    <div class="h-40 flex flex-col items-center justify-center text-center p-4">
                        <div class="w-12 h-12 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-slate-300 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-500">${correctionsSearchQuery ? 'No results found' : 'History is empty'}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 font-medium">${correctionsSearchQuery ? 'Try checking your search term.' : 'No processed requests found.'}</p>
                    </div>
                `;
                return;
            }

            filteredHistory.forEach(item => {
                const emp = employeesData.find(e => e.key === item.empKey);
                if (!emp) return;

                const badgeClass = item.status === 'Approved' 
                    ? 'bg-emerald-50 text-emerald-700 border-emerald-100/55' 
                    : 'bg-rose-50 text-rose-700 border-rose-100/55';

                const card = document.createElement('div');
                card.onclick = () => openCorrectionDetailModal(item.id, 'history');
                card.className = "flex items-center justify-between p-3 bg-slate-50/40 hover:bg-slate-100/80 border border-slate-150 hover:border-brand-300 rounded-xl transition-all cursor-pointer group shadow-xs";
                card.innerHTML = `
                    <div class="flex items-center gap-2.5 min-w-0">
                        <img src="${emp.avatar}" alt="${emp.name}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm shrink-0">
                        <div class="min-w-0">
                            <span class="block text-xs font-extrabold text-slate-800 truncate group-hover:text-brand-600 transition-colors">${emp.name}</span>
                            <span class="block text-[9px] text-slate-400 font-bold font-mono uppercase mt-0.5">${emp.id}</span>
                        </div>
                    </div>
                    <div class="text-right shrink-0 flex flex-col items-end gap-1">
                        <span class="text-[9px] font-bold text-slate-400 font-mono">${item.date}</span>
                        <span class="inline-flex items-center px-1.5 py-0.5 text-[8px] font-black rounded-md border uppercase ${badgeClass}">${item.status}</span>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function approveRequest(reqId) {
            const req = correctionRequests.find(r => r.id === reqId);
            if (!req) return;

            // Update main attendanceLogs list item or add if not found
            let log = attendanceLogs.find(l => l.empKey === req.empKey && l.date === req.date);
            if (!log) {
                log = {
                    id: Date.now(),
                    empKey: req.empKey,
                    date: req.date,
                    breakStart: null,
                    breakEnd: null
                };
                attendanceLogs.unshift(log);
            }

            log.inTime = req.requestedIn;
            log.outTime = req.requestedOut;
            log.status = "On Time"; // Corrected punches default to On Time

            // Calculate duration
            log.hours = calculateWorkHours(req.requestedIn, req.requestedOut);

            // Log resolved state to history
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            
            correctionHistory.unshift({
                ...req,
                status: 'Approved',
                processedTime: `Today, ${timeStr}`,
                processedBy: 'Alex Rivera (HR)'
            });

            // Remove request
            correctionRequests = correctionRequests.filter(r => r.id !== reqId);

            applyFilters();
            renderCorrectionRequests();
            renderCorrectionHistory();
            
            const empName = employeesData.find(e => e.key === req.empKey)?.name || "Employee";
            showToast("Approved", `Approved correction request for ${empName}. Log updated.`, "success");
        }

        function rejectRequest(reqId) {
            const req = correctionRequests.find(r => r.id === reqId);
            if (!req) return;

            // Log rejected state to history
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            
            correctionHistory.unshift({
                ...req,
                status: 'Rejected',
                processedTime: `Today, ${timeStr}`,
                processedBy: 'Alex Rivera (HR)'
            });

            correctionRequests = correctionRequests.filter(r => r.id !== reqId);
            renderCorrectionRequests();
            renderCorrectionHistory();

            const empName = employeesData.find(e => e.key === req.empKey)?.name || "Employee";
            showToast("Rejected", `Correction request for ${empName} was rejected.`, "error");
        }

        function calculateWorkHours(inStr, outStr) {
            if (inStr === '--' || outStr === '--') return '--';
            try {
                // Parse inStr (e.g. 09:00 AM)
                const inParts = inStr.match(/(\d+):(\d+)\s*(AM|PM)/i);
                // Parse outStr (e.g. 06:00 PM)
                const outParts = outStr.match(/(\d+):(\d+)\s*(AM|PM)/i);
                if (!inParts || !outParts) return "8h 00m";

                let inHr = parseInt(inParts[1], 10);
                const inMin = parseInt(inParts[2], 10);
                const inAmPm = inParts[3].toUpperCase();

                let outHr = parseInt(outParts[1], 10);
                const outMin = parseInt(outParts[2], 10);
                const outAmPm = outParts[3].toUpperCase();

                if (inAmPm === "PM" && inHr < 12) inHr += 12;
                if (inAmPm === "AM" && inHr === 12) inHr = 0;

                if (outAmPm === "PM" && outHr < 12) outHr += 12;
                if (outAmPm === "AM" && outHr === 12) outHr = 0;

                const checkInVal = inHr * 60 + inMin;
                const checkOutVal = outHr * 60 + outMin;

                const diff = checkOutVal - checkInVal;
                if (diff <= 0) return "--";

                const hours = Math.floor(diff / 60);
                const minutes = diff % 60;
                
                // Subtract 1 hour standard break
                const netMinutes = Math.max(0, diff - 60);
                const netHours = Math.floor(netMinutes / 60);
                const netRest = netMinutes % 60;

                return `${netHours}h ${netRest}m`;
            } catch (err) {
                return "8h 00m";
            }
        }

        // --- Modals Triggers ---

        // Time Correction Request Submission
        function openCorrectionModal() {
            const modal = document.getElementById('correctionModal');
            const backdrop = document.getElementById('correctionModalBackdrop');
            const panel = document.getElementById('correctionModalPanel');

            document.getElementById('correctionForm').reset();
            document.getElementById('correctionDate').value = getTodayDateString();

            modal.classList.remove('hidden');
            void modal.offsetWidth; // force redraw
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            document.body.classList.add('overflow-hidden');
        }

        function closeCorrectionModal() {
            const modal = document.getElementById('correctionModal');
            const backdrop = document.getElementById('correctionModalBackdrop');
            const panel = document.getElementById('correctionModalPanel');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function submitCorrection(e) {
            e.preventDefault();
            const empKey = parseInt(document.getElementById('correctionEmployee').value, 10);
            const date = document.getElementById('correctionDate').value;
            const inTimeRaw = document.getElementById('correctionInTime').value;
            const outTimeRaw = document.getElementById('correctionOutTime').value;
            const reason = document.getElementById('correctionReason').value.trim();

            const formattedIn = formatTimeString(inTimeRaw);
            const formattedOut = formatTimeString(outTimeRaw);

            // Add new request to pending list
            const newRequest = {
                id: Date.now(),
                empKey,
                date,
                currentIn: "--:--",
                requestedIn: formattedIn,
                currentOut: "--:--",
                requestedOut: formattedOut,
                reason,
                submitTime: "Just now"
            };

            // Grab existing current check-in/out times from logs if available
            const existingLog = attendanceLogs.find(l => l.empKey === empKey && l.date === date);
            if (existingLog) {
                newRequest.currentIn = existingLog.inTime;
                newRequest.currentOut = existingLog.outTime;
            }

            correctionRequests.unshift(newRequest);
            renderCorrectionRequests();
            closeCorrectionModal();
            showToast("Submitted", "Time correction request logged for review.", "info");
        }

        function formatTimeString(time24) {
            if (!time24) return "--:--";
            const parts = time24.split(':');
            let hr = parseInt(parts[0], 10);
            const min = parts[1];
            const ampm = hr >= 12 ? 'PM' : 'AM';
            hr = hr % 12;
            hr = hr ? hr : 12; // 0 should be 12
            return `${String(hr).padStart(2, '0')}:${min} ${ampm}`;
        }

        // Timeline Details Modal
        function openDetailsModal(logId) {
            const log = attendanceLogs.find(l => l.id === logId);
            if (!log) return;
            const emp = employeesData.find(e => e.key === log.empKey);
            if (!emp) return;

            // Load header values
            document.getElementById('detailsEmployeeName').innerText = `${emp.name} (${emp.role})`;
            document.getElementById('detailsEmployeeID').innerText = `ID Reference: ${emp.id} | Dept: ${emp.dept}`;

            // Load metadata cards
            document.getElementById('detailsMetaCheckIn').innerText = log.inTime;
            document.getElementById('detailsMetaCheckOut').innerText = log.outTime;
            document.getElementById('detailsMetaHours').innerText = log.hours;

            // Load timeline details
            document.getElementById('detailsTimeIn').innerText = log.inTime;
            
            if (log.breakStart) {
                document.getElementById('detailsTimeBreakStart').innerText = log.breakStart;
                document.getElementById('detailsTimeBreakEnd').innerText = log.breakEnd || "Ongoing";
            } else {
                document.getElementById('detailsTimeBreakStart').innerText = "Not logged";
                document.getElementById('detailsTimeBreakEnd').innerText = "Not logged";
            }

            const outNode = document.getElementById('detailsTimelineOutNode');
            const outLabel = document.getElementById('detailsOutLabel');
            const outDesc = document.getElementById('detailsOutDesc');

            document.getElementById('detailsTimeOut').innerText = log.outTime;

            if (log.outTime === '--:--' || log.outTime === '--') {
                outNode.className = "absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-300 border-4 border-white ring-4 ring-slate-100";
                outLabel.innerText = "Shift In Progress";
                outDesc.innerText = "Currently logged in and active.";
            } else {
                outNode.className = "absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-800 border-4 border-white ring-4 ring-slate-200";
                outLabel.innerText = "Checked Out";
                outDesc.innerText = "Day log completed, system signed off.";
            }

            // Launch Modal
            const modal = document.getElementById('detailsModal');
            const backdrop = document.getElementById('detailsModalBackdrop');
            const panel = document.getElementById('detailsModalPanel');

            modal.classList.remove('hidden');
            void modal.offsetWidth; // force redraw
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            document.body.classList.add('overflow-hidden');
        }

        function closeDetailsModal() {
            const modal = document.getElementById('detailsModal');
            const backdrop = document.getElementById('detailsModalBackdrop');
            const panel = document.getElementById('detailsModalPanel');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Export Modal Configuration
        function openExportModal() {
            const modal = document.getElementById('exportModal');
            const backdrop = document.getElementById('exportModalBackdrop');
            const panel = document.getElementById('exportModalPanel');

            modal.classList.remove('hidden');
            void modal.offsetWidth;
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            document.body.classList.add('overflow-hidden');
        }

        function closeExportModal() {
            const modal = document.getElementById('exportModal');
            const backdrop = document.getElementById('exportModalBackdrop');
            const panel = document.getElementById('exportModalPanel');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:scale-95');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function toggleCustomExportDates(val) {
            const box = document.getElementById('customExportDates');
            const start = document.getElementById('exportStartDate');
            const end = document.getElementById('exportEndDate');
            if (val === 'custom') {
                box.classList.remove('hidden');
                start.required = true;
                end.required = true;
                start.value = getTodayDateString();
                end.value = getTodayDateString();
            } else {
                box.classList.add('hidden');
                start.required = false;
                end.required = false;
            }
        }

        // Single Row Quick Triggers
        function triggerSingleCorrection(logId) {
            const log = attendanceLogs.find(l => l.id === logId);
            if (!log) return;
            
            openCorrectionModal();
            document.getElementById('correctionEmployee').value = log.empKey;
            document.getElementById('correctionDate').value = log.date;
            
            // Try to prefill in/out
            if (log.inTime !== '--') {
                document.getElementById('correctionInTime').value = convert12hTo24h(log.inTime);
            }
            if (log.outTime !== '--:--' && log.outTime !== '--') {
                document.getElementById('correctionOutTime').value = convert12hTo24h(log.outTime);
            }
        }

        function convert12hTo24h(str12) {
            try {
                const parts = str12.match(/(\d+):(\d+)\s*(AM|PM)/i);
                if (!parts) return "09:00";
                let h = parseInt(parts[1], 10);
                const m = parts[2];
                const ap = parts[3].toUpperCase();
                if (ap === 'PM' && h < 12) h += 12;
                if (ap === 'AM' && h === 12) h = 0;
                return `${String(h).padStart(2, '0')}:${m}`;
            } catch (e) {
                return "09:00";
            }
        }

        function toggleSingleStatus(logId) {
            const log = attendanceLogs.find(l => l.id === logId);
            if (!log) return;
            const empName = employeesData.find(e => e.key === log.empKey)?.name || "Employee";

            if (log.status === "Absent") {
                log.status = "On Time";
                log.inTime = "09:00 AM";
                log.hours = "8h 00m";
                showToast("Presence Updated", `${empName} marked Present (On Time).`, "success");
            } else {
                log.status = "Absent";
                log.inTime = "--";
                log.outTime = "--";
                log.hours = "--";
                showToast("Presence Updated", `${empName} marked Absent.`, "info");
            }
            applyFilters();
        }

        function triggerAbsenceReminder() {
            showToast("Emails Dispatched", "Absence alert emails sent to 10 unexcused employees.", "info");
        }

        // --- Export File Downloads Engine ---
        function downloadLogReport(e) {
            e.preventDefault();
            const format = document.getElementById('exportFormat').value;
            const range = document.getElementById('exportRange').value;
            let reportData = [];

            // Filter data according to selected date range
            const today = new Date();
            let start = new Date();
            let end = new Date();

            if (range === 'today') {
                start = new Date(today);
                end = new Date(today);
            } else if (range === 'yesterday') {
                start.setDate(today.getDate() - 1);
                end.setDate(today.getDate() - 1);
            } else if (range === 'week') {
                start.setDate(today.getDate() - 7);
            } else if (range === 'month') {
                start = new Date(today.getFullYear(), today.getMonth(), 1);
            } else if (range === 'custom') {
                start = new Date(document.getElementById('exportStartDate').value);
                end = new Date(document.getElementById('exportEndDate').value);
            }

            // Convert boundaries to date strings
            const formatDateStr = (d) => {
                return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`;
            };

            const sStr = formatDateStr(start);
            const eStr = formatDateStr(end);

            // Filter log logs in boundary
            const exportLogs = attendanceLogs.filter(log => {
                return log.date >= sStr && log.date <= eStr;
            });

            // Sort logs: First by Employee Name (A-Z), then by Date (Ascending)
            exportLogs.sort((a, b) => {
                const empA = employeesData.find(e => e.key === a.empKey);
                const empB = employeesData.find(e => e.key === b.empKey);
                const nameA = empA ? empA.name.toLowerCase() : '';
                const nameB = empB ? empB.name.toLowerCase() : '';
                
                if (nameA !== nameB) {
                    return nameA.localeCompare(nameB);
                }
                return a.date.localeCompare(b.date);
            });

            // Format structured table format for file downloads
            exportLogs.forEach(log => {
                const emp = employeesData.find(e => e.key === log.empKey);
                if (!emp) return;
                reportData.push({
                    "Employee ID": emp.id,
                    "Employee Name": emp.name,
                    "Department": emp.dept,
                    "Role": emp.role,
                    "Date": log.date,
                    "Check-In": log.inTime,
                    "Check-Out": log.outTime,
                    "Work Hours": log.hours,
                    "Work Mode": log.workMode || "Office",
                    "Status": log.status
                });
            });

            const filename = `Attendance_Report_${sStr}_to_${eStr}`;

            if (format === 'xlsx') {
                // Check SheetJS library
                if (typeof XLSX === 'undefined') {
                    showToast("Error", "SheetJS library loading error. Please check internet connection.", "error");
                    return;
                }
                const worksheet = XLSX.utils.json_to_sheet(reportData);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Attendance Logs");
                
                // Styling headers inside SheetJS
                XLSX.writeFile(workbook, `${filename}.xlsx`);
                showToast("Success", "Excel report downloaded successfully.", "success");
            } else if (format === 'csv') {
                const csvContent = convertToCSV(reportData);
                downloadBlobFile(csvContent, 'text/csv;charset=utf-8;', `${filename}.csv`);
                showToast("Success", "CSV report downloaded successfully.", "success");
            } else if (format === 'json') {
                const jsonContent = JSON.stringify(reportData, null, 2);
                downloadBlobFile(jsonContent, 'application/json;charset=utf-8;', `${filename}.json`);
                showToast("Success", "JSON dataset downloaded successfully.", "success");
            } else if (format === 'pdf') {
                exportAttendanceToPDF(reportData, sStr, eStr);
                showToast("Success", "PDF printed layout generated.", "success");
            }

            closeExportModal();
        }

        function convertToCSV(objArray) {
            if (objArray.length === 0) return "";
            const array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
            let str = '';
            
            // Headers
            const headers = Object.keys(array[0]);
            str += headers.join(',') + '\r\n';

            // Rows
            for (let i = 0; i < array.length; i++) {
                let line = '';
                for (let index in array[i]) {
                    if (line != '') line += ',';
                    let val = array[i][index];
                    // Escape quotes and commas
                    if (typeof val === 'string') {
                        val = val.replace(/"/g, '""');
                        if (val.indexOf(',') >= 0 || val.indexOf('\n') >= 0) {
                            val = `"${val}"`;
                        }
                    }
                    line += val;
                }
                str += line + '\r\n';
            }
            return str;
        }

        function downloadBlobFile(content, mimeType, filename) {
            const blob = new Blob([content], { type: mimeType });
            const link = document.createElement("a");
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", filename);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        function exportAttendanceToPDF(data, sDate, eDate) {
            const printWindow = window.open('', '_blank', 'width=1000,height=800');
            if (!printWindow) return;

            let tableRows = '';
            data.forEach(row => {
                const modeVal = row["Work Mode"] || "Office";
                const modeClass = `badge-${modeVal.toLowerCase().replace(' ', '')}`;
                tableRows += `
                    <tr>
                        <td>${row["Employee ID"]}</td>
                        <td><strong>${row["Employee Name"]}</strong><br><small>${row["Role"]}</small></td>
                        <td>${row["Department"]}</td>
                        <td>${row["Date"]}</td>
                        <td>${row["Check-In"]}</td>
                        <td>${row["Check-Out"]}</td>
                        <td>${row["Work Hours"]}</td>
                        <td><span class="badge ${modeClass}">${modeVal}</span></td>
                        <td><span class="badge badge-${row["Status"].toLowerCase().replace(' ', '')}">${row["Status"]}</span></td>
                    </tr>
                `;
            });

            printWindow.document.write(`
                <html>
                <head>
                    <title>Attendance Summary Report</title>
                    <style>
                        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #1e293b; padding: 40px; line-height: 1.5; }
                        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; }
                        .title h1 { margin: 0; font-size: 24px; font-weight: 800; color: #0f172a; }
                        .title p { margin: 5px 0 0 0; font-size: 13px; color: #64748b; font-weight: 500; }
                        .meta { text-align: right; font-size: 12px; color: #64748b; font-weight: 600; }
                        table { width: 100%; border-collapse: collapse; text-align: left; margin-top: 20px; font-size: 12px; }
                        th { background: #f8fafc; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; padding: 12px 10px; }
                        td { padding: 12px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
                        tr:hover { background: #f8fafc; }
                        .badge { display: inline-block; padding: 3px 8px; font-size: 9px; font-weight: 800; border-radius: 9999px; text-transform: uppercase; border: 1px solid transparent; }
                        .badge-ontime { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
                        .badge-late { background: #fffbeb; color: #b45309; border-color: #fde68a; }
                        .badge-onbreak { background: #eef2ff; color: #4338ca; border-color: #c7d2fe; }
                        .badge-checkedout { background: #f1f5f9; color: #475569; border-color: #cbd5e1; }
                        .badge-onleave { background: #f0f9ff; color: #0369a1; border-color: #bae6fd; }
                        .badge-absent { background: #fff5f5; color: #c53030; border-color: #feb2b2; }
                        .badge-office { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
                        .badge-wfh { background: #faf5ff; color: #6b21a8; border-color: #e9d5ff; }
                        .badge-field { background: #fffbeb; color: #b45309; border-color: #fde68a; }
                        .footer { border-top: 1px solid #e2e8f0; padding-top: 15px; margin-top: 40px; text-align: center; font-size: 11px; color: #94a3b8; font-weight: 500; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <div class="title">
                            <h1>WorkNest Technologies Pvt. Ltd.</h1>
                            <p>Attendance Summary Log Report <span style="font-size: 11px; font-weight: 600; color: #94a3b8; margin-left: 5px;">(Generated via WorkNest EMS)</span></p>
                        </div>
                        <div class="meta">
                            <p>Date Range: ${sDate} to ${eDate}</p>
                            <p>Generated: ${new Date().toLocaleString()}</p>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Hours</th>
                                <th>Mode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableRows}
                        </tbody>
                    </table>

                    <div class="footer">
                        Generated via WorkNest Enterprise Management System &bull; Confidential Report Document
                    </div>
                    <script>
                        window.onload = function() {
                            window.print();
                            setTimeout(function() { window.close(); }, 500);
                        };
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }

        // --- Custom Animated Toast feedback system ---
        function showToast(title, message, type = "success") {
            const container = document.getElementById('toastContainer');
            
            const toast = document.createElement('div');
            toast.className = "flex items-center gap-3 bg-white border border-slate-150 p-4 rounded-2xl shadow-xl transition-all duration-300 transform translate-y-2 opacity-0 pointer-events-auto w-80";
            
            // Icon Selector
            let iconHtml = '';
            if (type === 'success') {
                iconHtml = `
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 shadow-sm border border-emerald-200/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                `;
            } else if (type === 'error') {
                iconHtml = `
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0 shadow-sm border border-rose-200/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                `;
            } else {
                iconHtml = `
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 shadow-sm border border-indigo-200/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                `;
            }

            toast.innerHTML = `
                ${iconHtml}
                <div class="flex-1">
                    <h4 class="text-xs font-extrabold text-slate-900">${title}</h4>
                    <p class="text-[10px] font-semibold text-slate-500 mt-0.5">${message}</p>
                </div>
                <button class="text-slate-400 hover:text-slate-600 p-1 rounded-lg shrink-0 cursor-pointer shadow-none" onclick="this.parentElement.remove()" aria-label="Close Toast">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;

            container.appendChild(toast);
            
            // Animate In
            void toast.offsetWidth;
            toast.classList.remove('translate-y-2', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            // Auto dismiss after 4.5 seconds
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4500);
        }
    </script>
    @endpush
</x-app-layout>
