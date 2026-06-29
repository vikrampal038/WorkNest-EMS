<x-app-layout>
    <!-- Background Accents for depth -->
    <div class="fixed top-0 right-0 -z-10 w-200 h-200 bg-brand-50/50 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6">
        
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Employee Directory</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Manage and view all your team members across the organization.</p>
            </div>
            <div class="flex gap-2.5">
                <button onclick="exportToExcel()" class="px-4 py-2 bg-white border border-slate-200/60 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export
                </button>
                <button onclick="openModal('add')" class="px-4 py-2 bg-brand-600 rounded-lg text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Employee
                </button>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search -->
            <div class="relative w-full md:max-w-md group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="searchQuery" class="w-full pl-10 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="Search by name, role, or email...">
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select id="filterDepartment" class="flex-1 md:flex-none bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg focus:ring-brand-500 focus:border-brand-500 px-3 py-2 outline-none">
                    <option value="">All Departments</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Design">Design</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="Sales">Sales</option>
                    <option value="Marketing">Marketing</option>
                </select>
                <select id="filterStatus" class="flex-1 md:flex-none bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg focus:ring-brand-500 focus:border-brand-500 px-3 py-2 outline-none">
                    <option value="">All Statuses</option>
                    <option value="Active">Active</option>
                    <option value="On Leave">On Leave</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
            <div class="overflow-x-auto" style="min-height: 260px;">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                            <th class="px-6 py-4">Employee</th>
                            <th class="px-6 py-4">Role & Dept</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Join Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody" class="divide-y divide-slate-100 text-sm">
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-200 bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
                <span id="paginationInfo" class="text-sm font-semibold text-slate-500">Showing 1 to 5 of 15 entries</span>
                <div id="paginationButtons" class="flex gap-1">
                    <!-- Dynamic Buttons -->
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
            /* Default dropdown (downward) */
            .action-dropdown-menu:not(.dropup) {
                transform: scale(0.95) translateY(-8px) !important;
                transform-origin: top right !important;
            }
            /* Dropup (upward) */
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
        <!-- Dynamic Popup Modal (Add/Edit/View) -->
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
                                    <h3 class="text-lg font-bold text-slate-900 tracking-tight" id="modalTitle">Employee Profile</h3>
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Add or update employee profile data and settings.</p>
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
                                            <span id="modalEmployeeId" class="text-sm font-black text-slate-700 mt-0.5 block">0011</span>
                                        </div>
                                        <!-- System Reference -->
                                        <div class="bg-slate-50 border border-slate-200/50 rounded-xl px-4 py-2 text-center min-w-35 shadow-sm">
                                            <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest">System Ref</span>
                                            <span id="modalSystemRef" class="text-xs font-bold text-slate-600 mt-0.5 tracking-wider block">EMP-2026-0011</span>
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
                                </div> <!-- Close employeeFormContent -->

                                <!-- Leave Management Content (Hidden by default) -->
                                <div id="leaveManagementContent" class="hidden space-y-6">
                                    <!-- Leave Balance Cards -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- Card 1: Annual Leave -->
                                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Annual Leave</span>
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-md">Paid</span>
                                            </div>
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="text-2xl font-black text-slate-900" id="annualLeaveBalance">12</span>
                                                <span class="text-xs font-medium text-slate-400">/ <span id="annualLeaveTotal">18</span> days left</span>
                                            </div>
                                            <!-- Progress bar -->
                                            <div class="w-full bg-slate-100 h-2 rounded-full mt-4 overflow-hidden">
                                                <div id="annualLeaveBar" class="bg-emerald-500 h-full rounded-full" style="width: 66%;"></div>
                                            </div>
                                        </div>

                                        <!-- Card 2: Sick Leave -->
                                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sick Leave</span>
                                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[10px] font-bold rounded-md">Medical</span>
                                            </div>
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="text-2xl font-black text-slate-900" id="sickLeaveBalance">5</span>
                                                <span class="text-xs font-medium text-slate-400">/ <span id="sickLeaveTotal">8</span> days left</span>
                                            </div>
                                            <!-- Progress bar -->
                                            <div class="w-full bg-slate-100 h-2 rounded-full mt-4 overflow-hidden">
                                                <div id="sickLeaveBar" class="bg-rose-500 h-full rounded-full" style="width: 62.5%;"></div>
                                            </div>
                                        </div>

                                        <!-- Card 3: Casual Leave -->
                                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Casual Leave</span>
                                                <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-md">Personal</span>
                                            </div>
                                            <div class="flex items-baseline gap-1.5">
                                                <span class="text-2xl font-black text-slate-900" id="casualLeaveBalance">3</span>
                                                <span class="text-xs font-medium text-slate-400">/ <span id="casualLeaveTotal">5</span> days left</span>
                                            </div>
                                            <!-- Progress bar -->
                                            <div class="w-full bg-slate-100 h-2 rounded-full mt-4 overflow-hidden">
                                                <div id="casualLeaveBar" class="bg-blue-500 h-full rounded-full" style="width: 60%;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Split Layout: History (Left) and Request Form (Right) -->
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                        <!-- Recent Leave History (Take 2 Columns) -->
                                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm space-y-4 lg:col-span-2">
                                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Recent Leave History</h4>
                                                <span class="text-xs text-slate-400 font-semibold" id="leaveHistoryCount">2 requests found</span>
                                            </div>
                                            
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-left border-collapse text-xs">
                                                    <thead>
                                                        <tr class="text-[10px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                                                            <th class="py-2.5">Leave Type</th>
                                                            <th class="py-2.5">Dates & Duration</th>
                                                            <th class="py-2.5">Reason</th>
                                                            <th class="py-2.5 text-right">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-50 font-medium text-slate-700" id="leaveHistoryRows">
                                                        <tr>
                                                            <td class="py-3 font-bold text-slate-900">Annual Leave</td>
                                                            <td class="py-3">Oct 12 - Oct 15, 2026 (3 days)</td>
                                                            <td class="py-3 text-slate-500">Family function</td>
                                                            <td class="py-3 text-right">
                                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md">Approved</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="py-3 font-bold text-slate-900">Sick Leave</td>
                                                            <td class="py-3">Nov 04 - Nov 05, 2026 (1 day)</td>
                                                            <td class="py-3 text-slate-500">Fever & Medical rest</td>
                                                            <td class="py-3 text-right">
                                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md">Approved</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Log Leave Action Form (Take 1 Column) -->
                                        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm space-y-4">
                                            <div class="pb-3 border-b border-slate-100">
                                                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Apply / Log Leave</h4>
                                            </div>
                                            
                                            <div class="space-y-3">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Leave Type</label>
                                                    <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 outline-none focus:bg-white focus:border-brand-500 transition-all">
                                                        <option>Annual Leave</option>
                                                        <option>Sick Leave</option>
                                                        <option>Casual Leave</option>
                                                        <option>Unpaid Leave</option>
                                                    </select>
                                                </div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Start Date</label>
                                                        <input type="date" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 outline-none focus:bg-white focus:border-brand-500 transition-all">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">End Date</label>
                                                        <input type="date" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 outline-none focus:bg-white focus:border-brand-500 transition-all">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Reason</label>
                                                    <textarea rows="2" placeholder="Brief explanation..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 placeholder:text-slate-400 outline-none focus:bg-white focus:border-brand-500 transition-all resize-none"></textarea>
                                                </div>
                                                <button type="button" onclick="closeModal()" class="w-full py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition-all mt-1">
                                                    Record Request
                                                </button>
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
<!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div id="deleteModalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" onclick="closeDeleteModal()"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
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
                        <div class="bg-slate-50 px-4 py-3 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:px-6 rounded-b-2xl">
                            <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-lg shadow-sm hover:bg-slate-50 transition-colors">Cancel</button>
                            <button type="button" class="w-full sm:w-auto px-5 py-2.5 bg-rose-600 border border-transparent text-sm font-bold text-white rounded-lg shadow-sm hover:bg-rose-700 transition-colors flex items-center justify-center gap-2" onclick="confirmDelete()">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal JS Logic -->
        <script>
            
            let currentPage = 1;
            const itemsPerPage = 5;

            let currentSearch = "";
            let currentDept = "";
            let currentStatus = "";

            let currentModalType = "";
            let currentEmployeeIndex = null;
            let employeeToDelete = null;

            const employeesData = {
                1: {
                    empId: "WN-0001",
                    sysRef: "EMP-2026-0001",
                    firstName: "Sarah",
                    lastName: "Jones",
                    email: "sarah.j@worknest.com",
                    phone: "+1 (555) 019-2834",
                    dob: "1995-04-12",
                    gender: "Female",
                    address: "742 Evergreen Terrace, Springfield, OR 97477",
                    department: "Engineering",
                    role: "Senior Developer",
                    type: "Full-Time",
                    joinDate: "2024-01-15",
                    emergency: "Robert Jones - +1 (555) 019-2835",
                    avatar: "https://i.pravatar.cc/150?u=1",
                    status: "Active",
                    leaves: {
                        annual: { balance: 12, total: 18 },
                        sick: { balance: 5, total: 8 },
                        casual: { balance: 3, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Oct 12 - Oct 15, 2026 (3 days)", reason: "Family function", status: "Approved" },
                            { type: "Sick Leave", dates: "Nov 04 - Nov 05, 2026 (1 day)", reason: "Fever & Medical rest", status: "Approved" }
                        ]
                    }
                },
                2: {
                    empId: "WN-0002",
                    sysRef: "EMP-2026-0002",
                    firstName: "Mike",
                    lastName: "Chen",
                    email: "mike.c@worknest.com",
                    phone: "+1 (555) 023-4567",
                    dob: "1993-08-22",
                    gender: "Male",
                    address: "123 Bamboo Lane, San Francisco, CA 94107",
                    department: "Design",
                    role: "UI/UX Designer",
                    type: "Full-Time",
                    joinDate: "2024-03-22",
                    emergency: "May Chen - +1 (555) 023-4568",
                    avatar: "https://i.pravatar.cc/150?u=2",
                    status: "Active",
                    leaves: {
                        annual: { balance: 10, total: 18 },
                        sick: { balance: 6, total: 8 },
                        casual: { balance: 2, total: 5 },
                        history: [
                            { type: "Casual Leave", dates: "Feb 10 - Feb 11, 2026 (1 day)", reason: "Personal work", status: "Approved" },
                            { type: "Annual Leave", dates: "May 15 - May 20, 2026 (5 days)", reason: "Vacation", status: "Approved" }
                        ]
                    }
                },
                3: {
                    empId: "WN-0003",
                    sysRef: "EMP-2026-0003",
                    firstName: "Emily",
                    lastName: "Davis",
                    email: "emily.d@worknest.com",
                    phone: "+1 (555) 034-5678",
                    dob: "1989-11-05",
                    gender: "Female",
                    address: "456 Maple Avenue, Seattle, WA 98101",
                    department: "Human Resources",
                    role: "HR Manager",
                    type: "Full-Time",
                    joinDate: "2022-03-08",
                    emergency: "John Davis - +1 (555) 034-5679",
                    avatar: "https://i.pravatar.cc/150?u=3",
                    status: "On Leave",
                    leaves: {
                        annual: { balance: 15, total: 18 },
                        sick: { balance: 7, total: 8 },
                        casual: { balance: 4, total: 5 },
                        history: [
                            { type: "Sick Leave", dates: "Jan 12 - Jan 13, 2026 (1 day)", reason: "Dental appointment", status: "Approved" }
                        ]
                    }
                },
                4: {
                    empId: "WN-0004",
                    sysRef: "EMP-2026-0004",
                    firstName: "John",
                    lastName: "Miller",
                    email: "john.m@worknest.com",
                    phone: "+1 (555) 045-6789",
                    dob: "1985-06-20",
                    gender: "Male",
                    address: "789 Oak Boulevard, Chicago, IL 60601",
                    department: "Sales",
                    role: "Sales Representative",
                    type: "Contract",
                    joinDate: "2021-06-20",
                    emergency: "Sarah Miller - +1 (555) 045-6780",
                    avatar: "https://i.pravatar.cc/150?u=5",
                    status: "Active",
                    leaves: {
                        annual: { balance: 8, total: 18 },
                        sick: { balance: 4, total: 8 },
                        casual: { balance: 1, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Mar 01 - Mar 10, 2026 (9 days)", reason: "Annual holiday", status: "Approved" },
                            { type: "Casual Leave", dates: "Apr 20 - Apr 22, 2026 (2 days)", reason: "Urgent personal matter", status: "Approved" }
                        ]
                    }
                },
                5: {
                    empId: "WN-0005",
                    sysRef: "EMP-2026-0005",
                    firstName: "Lisa",
                    lastName: "Wong",
                    email: "lisa.w@worknest.com",
                    phone: "+1 (555) 056-7890",
                    dob: "1997-09-15",
                    gender: "Female",
                    address: "101 Pine Drive, Boston, MA 02108",
                    department: "Marketing",
                    role: "Marketing Lead",
                    type: "Full-Time",
                    joinDate: "2025-09-15",
                    emergency: "Albert Wong - +1 (555) 056-7891",
                    avatar: "https://i.pravatar.cc/150?u=12",
                    status: "Inactive",
                    leaves: {
                        annual: { balance: 14, total: 18 },
                        sick: { balance: 8, total: 8 },
                        casual: { balance: 3, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Dec 20 - Dec 24, 2026 (4 days)", reason: "Christmas holiday", status: "Approved" }
                        ]
                    }
                },
                6: {
                    empId: "WN-0006",
                    sysRef: "EMP-2026-0006",
                    firstName: "David",
                    lastName: "Miller",
                    email: "david.m@worknest.com",
                    phone: "+1 (555) 067-8901",
                    dob: "1992-02-18",
                    gender: "Male",
                    address: "222 Elm Street, Austin, TX 78701",
                    department: "Engineering",
                    role: "Backend Developer",
                    type: "Full-Time",
                    joinDate: "2023-05-10",
                    emergency: "Jane Miller - +1 (555) 067-8902",
                    avatar: "https://i.pravatar.cc/150?u=6",
                    status: "Active",
                    leaves: {
                        annual: { balance: 11, total: 18 },
                        sick: { balance: 6, total: 8 },
                        casual: { balance: 4, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Jul 05 - Jul 10, 2026 (5 days)", reason: "Summer break", status: "Approved" }
                        ]
                    }
                },
                7: {
                    empId: "WN-0007",
                    sysRef: "EMP-2026-0007",
                    firstName: "Jessica",
                    lastName: "Taylor",
                    email: "jessica.t@worknest.com",
                    phone: "+1 (555) 078-9012",
                    dob: "1996-07-30",
                    gender: "Female",
                    address: "333 Birch Road, Portland, OR 97201",
                    department: "Design",
                    role: "Illustrator",
                    type: "Part-Time",
                    joinDate: "2024-06-15",
                    emergency: "Mark Taylor - +1 (555) 078-9013",
                    avatar: "https://i.pravatar.cc/150?u=7",
                    status: "Active",
                    leaves: {
                        annual: { balance: 16, total: 18 },
                        sick: { balance: 8, total: 8 },
                        casual: { balance: 5, total: 5 },
                        history: []
                    }
                },
                8: {
                    empId: "WN-0008",
                    sysRef: "EMP-2026-0008",
                    firstName: "James",
                    lastName: "Wilson",
                    email: "james.w@worknest.com",
                    phone: "+1 (555) 089-0123",
                    dob: "1988-12-12",
                    gender: "Male",
                    address: "444 Cedar Lane, Atlanta, GA 30303",
                    department: "Sales",
                    role: "Account Executive",
                    type: "Full-Time",
                    joinDate: "2025-01-20",
                    emergency: "Helen Wilson - +1 (555) 089-0124",
                    avatar: "https://i.pravatar.cc/150?u=8",
                    status: "Active",
                    leaves: {
                        annual: { balance: 18, total: 18 },
                        sick: { balance: 7, total: 8 },
                        casual: { balance: 3, total: 5 },
                        history: [
                            { type: "Sick Leave", dates: "Mar 12 - Mar 13, 2026 (1 day)", reason: "Cold", status: "Approved" }
                        ]
                    }
                },
                9: {
                    empId: "WN-0009",
                    sysRef: "EMP-2026-0009",
                    firstName: "Anna",
                    lastName: "Martinez",
                    email: "anna.m@worknest.com",
                    phone: "+1 (555) 090-1234",
                    dob: "1994-10-25",
                    gender: "Female",
                    address: "555 Walnut Street, Miami, FL 33101",
                    department: "Engineering",
                    role: "QA Engineer",
                    type: "Full-Time",
                    joinDate: "2024-08-11",
                    emergency: "Luis Martinez - +1 (555) 090-1235",
                    avatar: "https://i.pravatar.cc/150?u=9",
                    status: "Active",
                    leaves: {
                        annual: { balance: 15, total: 18 },
                        sick: { balance: 8, total: 8 },
                        casual: { balance: 4, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Nov 23 - Nov 26, 2026 (3 days)", reason: "Thanksgiving", status: "Approved" }
                        ]
                    }
                },
                10: {
                    empId: "WN-0010",
                    sysRef: "EMP-2026-0010",
                    firstName: "Robert",
                    lastName: "Anderson",
                    email: "robert.a@worknest.com",
                    phone: "+1 (555) 101-2345",
                    dob: "1991-03-05",
                    gender: "Male",
                    address: "666 Ash Way, Denver, CO 80202",
                    department: "Human Resources",
                    role: "Recruiter",
                    type: "Full-Time",
                    joinDate: "2023-11-01",
                    emergency: "Mary Anderson - +1 (555) 101-2346",
                    avatar: "https://i.pravatar.cc/150?u=10",
                    status: "Active",
                    leaves: {
                        annual: { balance: 10, total: 18 },
                        sick: { balance: 5, total: 8 },
                        casual: { balance: 2, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Apr 05 - Apr 12, 2026 (7 days)", reason: "Spring trip", status: "Approved" },
                            { type: "Casual Leave", dates: "Jun 18 - Jun 20, 2026 (2 days)", reason: "Personal relocation", status: "Approved" }
                        ]
                    }
                },
                11: {
                    empId: "WN-0011",
                    sysRef: "EMP-2026-0011",
                    firstName: "Mary",
                    lastName: "Thomas",
                    email: "mary.t@worknest.com",
                    phone: "+1 (555) 112-3456",
                    dob: "1987-05-14",
                    gender: "Female",
                    address: "777 Redwood Court, Phoenix, AZ 85001",
                    department: "Marketing",
                    role: "SEO Specialist",
                    type: "Contract",
                    joinDate: "2025-02-14",
                    emergency: "David Thomas - +1 (555) 112-3457",
                    avatar: "https://i.pravatar.cc/150?u=11",
                    status: "Active",
                    leaves: {
                        annual: { balance: 12, total: 18 },
                        sick: { balance: 8, total: 8 },
                        casual: { balance: 4, total: 5 },
                        history: []
                    }
                },
                12: {
                    empId: "WN-0012",
                    sysRef: "EMP-2026-0012",
                    firstName: "William",
                    lastName: "Jackson",
                    email: "william.j@worknest.com",
                    phone: "+1 (555) 123-4567",
                    dob: "1986-09-18",
                    gender: "Male",
                    address: "888 Cypress Drive, Houston, TX 77002",
                    department: "Engineering",
                    role: "DevOps Engineer",
                    type: "Full-Time",
                    joinDate: "2022-09-18",
                    emergency: "Sarah Jackson - +1 (555) 123-4568",
                    avatar: "https://i.pravatar.cc/150?u=13",
                    status: "Active",
                    leaves: {
                        annual: { balance: 9, total: 18 },
                        sick: { balance: 4, total: 8 },
                        casual: { balance: 1, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Jan 02 - Jan 10, 2026 (8 days)", reason: "New Year trip", status: "Approved" }
                        ]
                    }
                },
                13: {
                    empId: "WN-0013",
                    sysRef: "EMP-2026-0013",
                    firstName: "Patricia",
                    lastName: "White",
                    email: "patricia.w@worknest.com",
                    phone: "+1 (555) 134-5678",
                    dob: "1999-11-20",
                    gender: "Female",
                    address: "999 Magnolia Lane, Nashville, TN 37201",
                    department: "Design",
                    role: "Product Designer",
                    type: "Internship",
                    joinDate: "2026-03-01",
                    emergency: "Thomas White - +1 (555) 134-5679",
                    avatar: "https://i.pravatar.cc/150?u=14",
                    status: "Active",
                    leaves: {
                        annual: { balance: 18, total: 18 },
                        sick: { balance: 8, total: 8 },
                        casual: { balance: 5, total: 5 },
                        history: []
                    }
                },
                14: {
                    empId: "WN-0014",
                    sysRef: "EMP-2026-0014",
                    firstName: "Richard",
                    lastName: "Harris",
                    email: "richard.h@worknest.com",
                    phone: "+1 (555) 145-6789",
                    dob: "1980-04-15",
                    gender: "Male",
                    address: "124 Chestnut Street, Philadelphia, PA 19107",
                    department: "Sales",
                    role: "Regional Manager",
                    type: "Full-Time",
                    joinDate: "2020-04-15",
                    emergency: "Elizabeth Harris - +1 (555) 145-6780",
                    avatar: "https://i.pravatar.cc/150?u=15",
                    status: "Active",
                    leaves: {
                        annual: { balance: 5, total: 18 },
                        sick: { balance: 3, total: 8 },
                        casual: { balance: 0, total: 5 },
                        history: [
                            { type: "Annual Leave", dates: "Feb 01 - Feb 14, 2026 (13 days)", reason: "Family event", status: "Approved" }
                        ]
                    }
                },
                15: {
                    empId: "WN-0015",
                    sysRef: "EMP-2026-0015",
                    firstName: "Linda",
                    lastName: "Martin",
                    email: "linda.m@worknest.com",
                    phone: "+1 (555) 156-7890",
                    dob: "1998-10-10",
                    gender: "Female",
                    address: "235 Sycamore Lane, Charlotte, NC 28202",
                    department: "Marketing",
                    role: "Content Creator",
                    type: "Part-Time",
                    joinDate: "2025-10-10",
                    emergency: "Kevin Martin - +1 (555) 156-7891",
                    avatar: "https://i.pravatar.cc/150?u=16",
                    status: "Active",
                    leaves: {
                        annual: { balance: 14, total: 18 },
                        sick: { balance: 8, total: 8 },
                        casual: { balance: 3, total: 5 },
                        history: []
                    }
                }
            };

            function updateBodyScroll() {
                const dynamicModal = document.getElementById('dynamicModal');
                const deleteModal = document.getElementById('deleteModal');
                
                const isDynamicOpen = dynamicModal && !dynamicModal.classList.contains('hidden');
                const isDeleteOpen = deleteModal && !deleteModal.classList.contains('hidden');
                
                if (isDynamicOpen || isDeleteOpen) {
                    document.body.classList.add('overflow-hidden');
                } else {
                    document.body.classList.remove('overflow-hidden');
                }
            }

            function openDeleteModal(index) {
                employeeToDelete = index;
                const modal = document.getElementById('deleteModal');
                const backdrop = document.getElementById('deleteModalBackdrop');
                const panel = document.getElementById('deleteModalPanel');

                modal.classList.remove('hidden');
                updateBodyScroll();
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
                    updateBodyScroll();
                }, 300);
            }

            function confirmDelete() {
                if (employeeToDelete !== null && employeesData[employeeToDelete]) {
                    delete employeesData[employeeToDelete];
                    employeeToDelete = null;
                }
                closeDeleteModal();
                
                const filtered = getFilteredEmployees();
                const totalPages = Math.max(1, Math.ceil(filtered.length / itemsPerPage));
                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }
                renderTable();
            }

            function openModal(type, index = null) {
                currentModalType = type;
                currentEmployeeIndex = index;

                const modal = document.getElementById('dynamicModal');
                const backdrop = document.getElementById('modalBackdrop');
                const panel = document.getElementById('modalPanel');
                const title = document.getElementById('modalTitle');
                const desc = modal.querySelector('p.text-xs.text-slate-500');

                // Toggle sections
                const formContent = document.getElementById('employeeFormContent');
                const leavesContent = document.getElementById('leaveManagementContent');
                const avatarUploadBadge = document.getElementById('avatarUploadBadge');
                
                const cancelBtn = document.getElementById('modalCancelBtn');
                const submitBtn = document.getElementById('modalSubmitBtn');
                const reqText = document.getElementById('modalRequiredFieldsText');

                const formFields = formContent.querySelectorAll('input, select, textarea');

                // Reset default state
                formContent.classList.remove('hidden');
                leavesContent.classList.add('hidden');
                if (avatarUploadBadge) avatarUploadBadge.classList.remove('hidden');
                if (reqText) reqText.classList.remove('hidden');
                if (submitBtn) submitBtn.classList.remove('hidden');
                if (cancelBtn) {
                    cancelBtn.textContent = 'Cancel';
                    cancelBtn.className = "w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all";
                }

                // Enable fields
                formFields.forEach(field => {
                    field.disabled = false;
                    field.classList.remove('bg-slate-100/30', 'border-slate-100/80', 'text-slate-600', 'cursor-default', 'select-none');
                    field.classList.add('bg-slate-50/50', 'border-slate-200', 'text-slate-900');
                });

                // Populate data if index is provided
                if (index !== null && employeesData[index]) {
                    const emp = employeesData[index];
                    document.getElementById('empFirstName').value = emp.firstName || '';
                    document.getElementById('empLastName').value = emp.lastName || '';
                    document.getElementById('empEmail').value = emp.email || '';
                    document.getElementById('empPhone').value = emp.phone || '';
                    document.getElementById('empDOB').value = emp.dob || '';
                    document.getElementById('empGender').value = emp.gender || '';
                    document.getElementById('empAddress').value = emp.address || '';
                    document.getElementById('empDepartment').value = emp.department || '';
                    document.getElementById('empRole').value = emp.role || '';
                    document.getElementById('empType').value = emp.type || 'Full-Time';
                    document.getElementById('empJoinDate').value = emp.joinDate || '';
                    document.getElementById('empEmergency').value = emp.emergency || '';

                    document.getElementById('modalEmployeeId').textContent = emp.empId;
                    document.getElementById('modalSystemRef').textContent = emp.sysRef;

                    // Set Avatar
                    const avatarImg = document.getElementById('modalAvatarImg');
                    const avatarPl = document.getElementById('modalAvatarPlaceholder');
                    if (emp.avatar) {
                        avatarImg.src = emp.avatar;
                        avatarImg.classList.remove('hidden');
                        avatarPl.classList.add('hidden');
                    } else {
                        avatarImg.classList.add('hidden');
                        avatarPl.classList.remove('hidden');
                    }

                    // Populate Leaves
                    if (emp.leaves) {
                        document.getElementById('annualLeaveBalance').textContent = emp.leaves.annual.balance;
                        document.getElementById('annualLeaveTotal').textContent = emp.leaves.annual.total;
                        document.getElementById('annualLeaveBar').style.width = ((emp.leaves.annual.balance / emp.leaves.annual.total) * 100) + '%';

                        document.getElementById('sickLeaveBalance').textContent = emp.leaves.sick.balance;
                        document.getElementById('sickLeaveTotal').textContent = emp.leaves.sick.total;
                        document.getElementById('sickLeaveBar').style.width = ((emp.leaves.sick.balance / emp.leaves.sick.total) * 100) + '%';

                        document.getElementById('casualLeaveBalance').textContent = emp.leaves.casual.balance;
                        document.getElementById('casualLeaveTotal').textContent = emp.leaves.casual.total;
                        document.getElementById('casualLeaveBar').style.width = ((emp.leaves.casual.balance / emp.leaves.casual.total) * 100) + '%';

                        // Populate history count
                        document.getElementById('leaveHistoryCount').textContent = emp.leaves.history.length + ' requests found';

                        // Populate history rows
                        const leaveHistoryRows = document.getElementById('leaveHistoryRows');
                        let rowsHtml = '';
                        emp.leaves.history.forEach(item => {
                            rowsHtml += `
                                <tr>
                                    <td class="py-3 font-bold text-slate-900">${item.type}</td>
                                    <td class="py-3">${item.dates}</td>
                                    <td class="py-3 text-slate-500">${item.reason}</td>
                                    <td class="py-3 text-right">
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md">${item.status}</span>
                                    </td>
                                </tr>
                            `;
                        });
                        leaveHistoryRows.innerHTML = rowsHtml;
                    }
                } else {
                    // It is 'add' mode, reset form
                    document.getElementById('employeeForm').reset();
                    
                    const keys = Object.keys(employeesData).map(Number);
                    const nextKey = keys.length > 0 ? Math.max(...keys) + 1 : 1;
                    const nextId = String(nextKey).padStart(4, '0');
                    document.getElementById('modalEmployeeId').textContent = nextId;
                    document.getElementById('modalSystemRef').textContent = 'EMP-2026-' + nextId;

                    document.getElementById('modalAvatarImg').classList.add('hidden');
                    document.getElementById('modalAvatarPlaceholder').classList.remove('hidden');

                    // Reset leave displays
                    document.getElementById('annualLeaveBalance').textContent = '18';
                    document.getElementById('annualLeaveTotal').textContent = '18';
                    document.getElementById('annualLeaveBar').style.width = '100%';

                    document.getElementById('sickLeaveBalance').textContent = '8';
                    document.getElementById('sickLeaveTotal').textContent = '8';
                    document.getElementById('sickLeaveBar').style.width = '100%';

                    document.getElementById('casualLeaveBalance').textContent = '5';
                    document.getElementById('casualLeaveTotal').textContent = '5';
                    document.getElementById('casualLeaveBar').style.width = '100%';

                    document.getElementById('leaveHistoryCount').textContent = '0 requests found';
                    document.getElementById('leaveHistoryRows').innerHTML = '';
                }

                if (type === 'add') {
                    title.textContent = 'Add New Employee';
                    desc.textContent = 'Add a new employee to the directory system.';
                    if (submitBtn) {
                        submitBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Save Profile`;
                    }
                } else if (type === 'view') {
                    title.textContent = 'Employee Profile';
                    desc.textContent = 'Detailed profile and records of the employee.';
                    
                    formFields.forEach(field => {
                        field.disabled = true;
                        field.classList.remove('bg-slate-50/50', 'border-slate-200', 'text-slate-900');
                        field.classList.add('bg-slate-100/30', 'border-slate-100/80', 'text-slate-600', 'cursor-default', 'select-none');
                    });
                    
                    if (avatarUploadBadge) avatarUploadBadge.classList.add('hidden');
                    if (reqText) reqText.classList.add('hidden');
                    if (submitBtn) submitBtn.classList.add('hidden');
                    if (cancelBtn) {
                        cancelBtn.textContent = 'Close';
                        cancelBtn.className = "w-full sm:w-auto px-6 py-2.5 bg-brand-600 text-sm font-bold text-white rounded-xl shadow-sm hover:bg-brand-700 transition-all flex items-center justify-center";
                    }
                } else if (type === 'edit') {
                    title.textContent = 'Edit Employee Details';
                    desc.textContent = 'Update employee details and system credentials.';
                    if (submitBtn) {
                        submitBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Save Changes`;
                    }
                } else if (type === 'leaves') {
                    title.textContent = 'Manage Leaves';
                    desc.textContent = 'Log, approve, and track employee leave requests.';
                    
                    formContent.classList.add('hidden');
                    leavesContent.classList.remove('hidden');
                    if (reqText) reqText.classList.add('hidden');
                    if (submitBtn) submitBtn.classList.add('hidden');
                    if (cancelBtn) {
                        cancelBtn.textContent = 'Close';
                        cancelBtn.className = "w-full sm:w-auto px-6 py-2.5 bg-brand-600 text-sm font-bold text-white rounded-xl shadow-sm hover:bg-brand-700 transition-all flex items-center justify-center";
                    }
                }

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
                const phone = document.getElementById('empPhone').value.trim();
                const dob = document.getElementById('empDOB').value;
                const gender = document.getElementById('empGender').value;
                const address = document.getElementById('empAddress').value.trim();
                const department = document.getElementById('empDepartment').value;
                const role = document.getElementById('empRole').value.trim();
                const type = document.getElementById('empType').value;
                const joinDate = document.getElementById('empJoinDate').value;
                const emergency = document.getElementById('empEmergency').value.trim();

                if (!firstName || !lastName || !email || !department || !role || !type) {
                    alert('Please fill out all required fields.');
                    return;
                }

                if (currentModalType === 'add') {
                    const keys = Object.keys(employeesData).map(Number);
                    const nextKey = keys.length > 0 ? Math.max(...keys) + 1 : 1;
                    const nextId = 'WN-' + String(nextKey).padStart(4, '0');

                    employeesData[nextKey] = {
                        empId: nextId,
                        sysRef: `EMP-2026-${String(nextKey).padStart(4, '0')}`,
                        firstName,
                        lastName,
                        email,
                        phone,
                        dob,
                        gender,
                        address,
                        department,
                        role,
                        type,
                        joinDate: joinDate || new Date().toISOString().split('T')[0],
                        emergency,
                        avatar: `https://i.pravatar.cc/150?u=${nextKey}`,
                        status: 'Active',
                        leaves: {
                            annual: { balance: 18, total: 18 },
                            sick: { balance: 8, total: 8 },
                            casual: { balance: 5, total: 5 },
                            history: []
                        }
                    };

                    showToast('Success', `${firstName} ${lastName} added successfully.`, 'success');
                } else {
                    const emp = employeesData[currentEmployeeIndex];
                    if (emp) {
                        emp.firstName = firstName;
                        emp.lastName = lastName;
                        emp.email = email;
                        emp.phone = phone;
                        emp.dob = dob;
                        emp.gender = gender;
                        emp.address = address;
                        emp.department = department;
                        emp.role = role;
                        emp.type = type;
                        if (joinDate) emp.joinDate = joinDate;
                        emp.emergency = emergency;

                        showToast('Success', `${firstName} ${lastName} updated successfully.`, 'success');
                    }
                }

                closeModal();
                renderTable();
            }

            function getFilteredEmployees() {
                const list = [];
                for (const key in employeesData) {
                    if (employeesData.hasOwnProperty(key)) {
                        const emp = employeesData[key];
                        
                        // Search matches first name, last name, email, role, or ID
                        const name = `${emp.firstName} ${emp.lastName}`.toLowerCase();
                        const email = (emp.email || "").toLowerCase();
                        const role = (emp.role || "").toLowerCase();
                        const id = (emp.empId || "").toLowerCase();
                        const matchesSearch = !currentSearch ||
                            name.includes(currentSearch) ||
                            email.includes(currentSearch) ||
                            role.includes(currentSearch) ||
                            id.includes(currentSearch);

                        const matchesDept = !currentDept || emp.department === currentDept;
                        const matchesStatus = !currentStatus || emp.status === currentStatus;

                        if (matchesSearch && matchesDept && matchesStatus) {
                            list.push({ key: Number(key), ...emp });
                        }
                    }
                }
                return list.sort((a, b) => {
                    const numA = Number((a.empId || '').replace(/[^\d]/g, '')) || 0;
                    const numB = Number((b.empId || '').replace(/[^\d]/g, '')) || 0;
                    return numA - numB;
                });
            }

            function renderTable() {
                const filtered = getFilteredEmployees();
                const tableBody = document.getElementById('employeeTableBody');
                if (!tableBody) return;

                const totalItems = filtered.length;
                const totalPages = Math.max(1, Math.ceil(totalItems / itemsPerPage));

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }
                if (currentPage < 1) {
                    currentPage = 1;
                }

                const startIdx = (currentPage - 1) * itemsPerPage;
                const endIdx = startIdx + itemsPerPage;
                const pageItems = filtered.slice(startIdx, endIdx);

                let rowsHtml = "";
                if (pageItems.length === 0) {
                    rowsHtml = `
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-center text-slate-400 mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-700">No employees found</h3>
                                    <p class="text-xs text-slate-400 mt-1 max-w-[280px]">Try adjusting your search query or filters to find what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    pageItems.forEach((emp, index) => {
                        const isLastRows = index >= 3;
                        const dropupClass = isLastRows ? 'dropup' : '';

                        rowsHtml += `
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <img src="${emp.avatar || 'https://i.pravatar.cc/150?u=' + emp.key}" alt="" class="w-10 h-10 rounded-full object-cover border border-slate-100 shadow-xs">
                                        <div>
                                            <span class="block font-bold text-slate-850 text-slate-900">${emp.firstName} ${emp.lastName}</span>
                                            <span class="block text-xs text-slate-400 font-medium">${emp.email}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <span class="block font-semibold text-slate-700">${emp.role}</span>
                                        <span class="block text-xs text-slate-400 font-medium">${emp.department}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold ${
                                        emp.status === 'Active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100/50' :
                                        emp.status === 'On Leave' ? 'bg-amber-50 text-amber-700 border border-amber-100/50' :
                                        'bg-slate-50 text-slate-600 border border-slate-200/50'
                                    }">
                                        <span class="w-1.5 h-1.5 rounded-full ${
                                            emp.status === 'Active' ? 'bg-emerald-500' :
                                            emp.status === 'On Leave' ? 'bg-amber-500' :
                                            'bg-slate-400'
                                        }"></span>
                                        ${emp.status || 'Active'}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-500 font-semibold">
                                    ${emp.joinDate}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-slate-500 font-medium">
                                    <div class="relative inline-block text-left action-dropdown-container">
                                        <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-slate-600 transition-colors action-dropdown-btn" id="action-btn-${emp.key}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                            </svg>
                                        </button>
                                        <div class="absolute right-0 mt-1 w-44 bg-white border border-slate-200/80 rounded-xl shadow-xl z-50 action-dropdown-menu transition-all ${dropupClass}" role="menu" aria-orientation="vertical" aria-labelledby="action-btn-${emp.key}">
                                            <div class="py-1 text-left">
                                                <a href="javascript:void(0)" onclick="openModal('view', ${emp.key})" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors" role="menuitem">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    View Details
                                                </a>
                                                <a href="javascript:void(0)" onclick="openModal('edit', ${emp.key})" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors" role="menuitem">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    Edit Details
                                                </a>
                                                <a href="javascript:void(0)" onclick="openModal('leaves', ${emp.key})" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors" role="menuitem">
                                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    Manage Leaves
                                                </a>
                                                <div class="h-px bg-slate-100 my-1"></div>
                                                <a href="javascript:void(0)" onclick="openDeleteModal(${emp.key})" class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-colors" role="menuitem">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Delete Employee
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                tableBody.innerHTML = rowsHtml;

                // Update pagination info
                const infoSpan = document.getElementById('paginationInfo');
                if (infoSpan) {
                    const start = totalItems === 0 ? 0 : startIdx + 1;
                    const end = Math.min(endIdx, totalItems);
                    infoSpan.textContent = `Showing ${start} to ${end} of ${totalItems} entries`;
                }

                // Render pagination buttons
                const buttonsDiv = document.getElementById('paginationButtons');
                if (buttonsDiv) {
                    let buttonsHtml = "";
                    
                    // Previous Button
                    if (currentPage === 1) {
                        buttonsHtml += `<button disabled class="px-3 py-1.5 text-sm font-bold text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">Previous</button>`;
                    } else {
                        buttonsHtml += `<button onclick="setPage(${currentPage - 1})" class="px-3 py-1.5 text-sm font-bold text-slate-700 hover:bg-slate-50 border border-slate-200 rounded-lg transition-colors">Previous</button>`;
                    }
                    
                    // Page Numbers
                    for (let p = 1; p <= totalPages; p++) {
                        if (p === currentPage) {
                            buttonsHtml += `<button class="px-3 py-1.5 text-sm font-bold text-white bg-brand-600 border border-brand-600 rounded-lg shadow-sm">${p}</button>`;
                        } else {
                            buttonsHtml += `<button onclick="setPage(${p})" class="px-3 py-1.5 text-sm font-bold text-slate-700 hover:bg-slate-50 border border-slate-200 rounded-lg transition-colors">${p}</button>`;
                        }
                    }
                    
                    // Next Button
                    if (currentPage === totalPages) {
                        buttonsHtml += `<button disabled class="px-3 py-1.5 text-sm font-bold text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">Next</button>`;
                    } else {
                        buttonsHtml += `<button onclick="setPage(${currentPage + 1})" class="px-3 py-1.5 text-sm font-bold text-slate-700 hover:bg-slate-50 border border-slate-200 rounded-lg transition-colors">Next</button>`;
                    }
                    
                    buttonsDiv.innerHTML = buttonsHtml;
                }
            }

            function setPage(page) {
                currentPage = page;
                renderTable();
            }

            document.addEventListener('DOMContentLoaded', () => {
                // Render initial table
                renderTable();

                // Bind filters
                const searchInput = document.getElementById('searchQuery');
                const deptSelect = document.getElementById('filterDepartment');
                const statusSelect = document.getElementById('filterStatus');

                if (searchInput) {
                    searchInput.addEventListener('input', (e) => {
                        currentSearch = e.target.value.trim().toLowerCase();
                        currentPage = 1;
                        renderTable();
                    });
                }

                if (deptSelect) {
                    deptSelect.addEventListener('change', (e) => {
                        currentDept = e.target.value;
                        currentPage = 1;
                        renderTable();
                    });
                }

                if (statusSelect) {
                    statusSelect.addEventListener('change', (e) => {
                        currentStatus = e.target.value;
                        currentPage = 1;
                        renderTable();
                    });
                }
            });

            function exportToExcel() {
                const dataToExport = [];
                for (const key in employeesData) {
                    if (employeesData.hasOwnProperty(key)) {
                        const emp = employeesData[key];
                        dataToExport.push({
                            "Employee ID": emp.empId,
                            "System Reference": emp.sysRef,
                            "First Name": emp.firstName,
                            "Last Name": emp.lastName,
                            "Email": emp.email,
                            "Phone": emp.phone,
                            "Date of Birth": emp.dob,
                            "Gender": emp.gender,
                            "Department": emp.department,
                            "Role": emp.role,
                            "Employment Type": emp.type,
                            "Join Date": emp.joinDate,
                            "Emergency Contact": emp.emergency,
                            "Address": emp.address,
                            "Annual Leave Balance": emp.leaves?.annual?.balance || 0,
                            "Annual Leave Total": emp.leaves?.annual?.total || 0,
                            "Sick Leave Balance": emp.leaves?.sick?.balance || 0,
                            "Sick Leave Total": emp.leaves?.sick?.total || 0,
                            "Casual Leave Balance": emp.leaves?.casual?.balance || 0,
                            "Casual Leave Total": emp.leaves?.casual?.total || 0
                        });
                    }
                }
                
                if (typeof XLSX === 'undefined') {
                    const script = document.createElement('script');
                    script.src = "https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js";
                    script.onload = () => {
                        generateExcel(dataToExport);
                    };
                    document.head.appendChild(script);
                } else {
                    generateExcel(dataToExport);
                }
            }

            function generateExcel(data) {
                const ws = XLSX.utils.json_to_sheet(data);
                const colWidths = [
                    { wch: 12 }, { wch: 18 }, { wch: 15 }, { wch: 15 }, { wch: 25 },
                    { wch: 18 }, { wch: 15 }, { wch: 10 }, { wch: 18 }, { wch: 20 },
                    { wch: 15 }, { wch: 15 }, { wch: 30 }, { wch: 45 }, { wch: 20 },
                    { wch: 18 }, { wch: 18 }, { wch: 16 }, { wch: 20 }, { wch: 18 }
                ];
                ws['!cols'] = colWidths;

                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Employee Directory");
                XLSX.writeFile(wb, "WorkNest_Employee_Directory.xlsx");
            }
        </script>
    </div>
</x-app-layout>

