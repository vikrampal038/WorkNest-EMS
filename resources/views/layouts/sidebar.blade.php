<style>
    /* Desktop Sidebar Collapsible Styles */
    #desktopSidebar {
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s ease;
    }
    #desktopSidebar.collapsed {
        width: 5.5rem; /* 88px */
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    
    /* Hide texts when collapsed */
    #desktopSidebar.collapsed .sidebar-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
        margin: 0;
        pointer-events: none;
        display: none;
    }
    
    /* Logo transitions */
    #desktopSidebar .full-logo {
        display: block;
        transition: opacity 0.2s ease;
    }
    #desktopSidebar.collapsed .full-logo {
        display: none;
    }
    #desktopSidebar .collapsed-logo {
        display: none;
    }
    #desktopSidebar.collapsed .collapsed-logo {
        display: flex;
    }

    /* Link item adjustments */
    #desktopSidebar.collapsed .nav-item {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
        width: 3rem; /* 48px */
        height: 3rem;
        margin-left: auto;
        margin-right: auto;
        gap: 0;
        border-radius: 0.75rem;
    }
    
    /* Branding section alignment */
    #desktopSidebar.collapsed .branding-container {
        justify-content: center;
        padding: 0;
    }
    
    /* Toggle button rotation */
    #desktopSidebar .toggle-arrow {
        transition: transform 0.3s ease;
    }
    #desktopSidebar.collapsed .toggle-arrow {
        transform: rotate(180deg);
    }
</style>

<!-- Desktop Sidebar -->
<aside id="desktopSidebar" class="relative hidden md:flex flex-col w-64 bg-white border-r border-slate-200 shadow-sm items-start py-6 px-4 h-screen sticky top-0 shrink-0 z-50">
    
    <!-- Floating Collapse Arrow Button (Desktop Only) -->
    <button onclick="toggleDesktopSidebar()" class="absolute -right-3 top-8 w-6 h-6 bg-white border border-slate-200 text-slate-500 hover:text-brand-600 rounded-full flex items-center justify-center shadow-md hover:bg-slate-50 hover:border-brand-300 transition-all cursor-pointer z-50" aria-label="Collapse Sidebar">
        <svg class="w-4 h-4 toggle-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <!-- Branding -->
    <div class="mb-6 px-2 w-full flex items-center justify-between branding-container">
        <!-- Main Platform Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center full-logo">
            <img src="{{ asset('Assets/WorkNest-EMS_Logo.png') }}" alt="WorkNest" class="h-10 w-auto object-contain drop-shadow-sm">
        </a>
        <!-- Collapsed Logo Mark -->
        <a href="{{ route('dashboard') }}" class="collapsed-logo w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-600 items-center justify-center text-white font-black text-sm shadow-sm border border-brand-500/20 shrink-0">
            WN
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 w-full flex flex-col gap-1.5 mt-2">
        @if(request()->is('admin/*') || request()->routeIs('admin.*'))
            <!-- ADMIN MENU OPTIONS -->
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="{{ request()->routeIs('admin.dashboard') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Dashboard</span>
            </a>

            <!-- Directory -->
            <a href="{{ route('admin.directory') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.directory') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.directory') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="{{ request()->routeIs('admin.directory') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Employee Directory</span>
            </a>

            <!-- Attendance / Time -->
            <a href="{{ route('admin.attendance') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.attendance') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.attendance') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="{{ request()->routeIs('admin.attendance') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Attendance & Time</span>
            </a>

            <!-- Payroll / Wallet -->
            <a href="{{ route('admin.payroll') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.payroll') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.payroll') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span class="{{ request()->routeIs('admin.payroll') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Payroll & Salary</span>
            </a>

            <!-- Loans & Advances -->
            <a href="{{ route('admin.loans') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.loans') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.loans') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="{{ request()->routeIs('admin.loans') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Loans & Advances</span>
            </a>

            <!-- Bulletin Board -->
            <a href="{{ route('admin.announcements') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.announcements') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.announcements') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
                <span class="{{ request()->routeIs('admin.announcements') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Bulletin Board</span>
            </a>

            <!-- Documents -->
            <a href="{{ route('admin.documents') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.documents') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.documents') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="{{ request()->routeIs('admin.documents') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Documents</span>
            </a>

            <!-- Employee KYC Documents -->
            <a href="{{ route('admin.employee_documents') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.employee_documents') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.employee_documents') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
                <span class="{{ request()->routeIs('admin.employee_documents') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Employee KYC</span>
            </a>
        @else
            <!-- EMPLOYEE MENU OPTIONS -->
            <!-- Dashboard Home -->
            <a href="{{ route('employee.portal') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.portal') || request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.portal') || request()->routeIs('dashboard') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="{{ request()->routeIs('employee.portal') || request()->routeIs('dashboard') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">My ESS Portal</span>
            </a>

            <!-- Attendance / Time -->
            <a href="{{ route('employee.attendance') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.attendance') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.attendance') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="{{ request()->routeIs('employee.attendance') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Attendance & Time</span>
            </a>

            <!-- Leave Requests -->
            <a href="{{ route('employee.leaves') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.leaves') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.leaves') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="{{ request()->routeIs('employee.leaves') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Leave Requests</span>
            </a>

            <!-- My Tasks -->
            <a href="{{ route('employee.tasks') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.tasks') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.tasks') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span class="{{ request()->routeIs('employee.tasks') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">My Tasks</span>
            </a>

            <!-- Documents & Payslips -->
            <a href="{{ route('employee.documents') }}" class="nav-item group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.documents') || request()->routeIs('employee.document.sign') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.documents') || request()->routeIs('employee.document.sign') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="{{ request()->routeIs('employee.documents') || request()->routeIs('employee.document.sign') ? 'font-bold' : 'font-medium' }} text-sm sidebar-text">Documents Vault</span>
            </a>
        @endif
    </nav>

    <!-- Bottom Settings / Profile -->
    <div class="mt-auto w-full flex flex-col gap-1.5 pt-4 border-t border-slate-100">
        <a href="#" class="nav-item w-full flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all border border-transparent">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-medium text-sm sidebar-text">Settings</span>
        </a>
    </div>
</aside>

<script>
    // Apply collapsible state immediately on parsing to prevent flash of expanded sidebar
    (function() {
        const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        if (isCollapsed) {
            document.getElementById('desktopSidebar').classList.add('collapsed');
        }
    })();
</script>

<!-- Mobile Sidebar Backdrop (Only visible on screens smaller than md) -->
<div id="sidebarBackdrop" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-50 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden hidden" onclick="toggleSidebar(false)"></div>

<!-- Mobile Sidebar Drawer Container (Only visible on screens smaller than md) -->
<aside id="mainSidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 shadow-xl flex flex-col py-6 px-4 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden">
    <!-- Branding with Close Button -->
    <div class="mb-6 px-2 w-full flex items-center justify-between">
        <!-- Main Platform Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center shrink-0">
            <img src="{{ asset('Assets/WorkNest-EMS_Logo.png') }}" alt="WorkNest" class="h-10 w-auto object-contain drop-shadow-sm">
        </a>
        <!-- Close button (Mobile Only) -->
        <button onclick="toggleSidebar(false)" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-50 border border-slate-100 md:hidden transition-all shadow-sm flex items-center justify-center shrink-0" aria-label="Close Sidebar">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Menu (Duplicate for Mobile) -->
    <nav class="flex-1 w-full flex flex-col gap-1.5 mt-2">
        @if(request()->is('admin/*') || request()->routeIs('admin.*'))
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="{{ request()->routeIs('admin.dashboard') ? 'font-bold' : 'font-medium' }} text-sm">Dashboard</span>
            </a>

            <!-- Directory -->
            <a href="{{ route('admin.directory') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.directory') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.directory') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="{{ request()->routeIs('admin.directory') ? 'font-bold' : 'font-medium' }} text-sm">Employee Directory</span>
            </a>

            <!-- Attendance / Time -->
            <a href="{{ route('admin.attendance') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.attendance') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.attendance') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="{{ request()->routeIs('admin.attendance') ? 'font-bold' : 'font-medium' }} text-sm">Attendance & Time</span>
            </a>

            <!-- Payroll / Wallet -->
            <a href="{{ route('admin.payroll') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.payroll') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.payroll') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span class="{{ request()->routeIs('admin.payroll') ? 'font-bold' : 'font-medium' }} text-sm">Payroll & Salary</span>
            </a>

            <!-- Loans & Advances -->
            <a href="{{ route('admin.loans') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.loans') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.loans') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="{{ request()->routeIs('admin.loans') ? 'font-bold' : 'font-medium' }} text-sm">Loans & Advances</span>
            </a>

            <!-- Bulletin Board -->
            <a href="{{ route('admin.announcements') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.announcements') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.announcements') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
                <span class="{{ request()->routeIs('admin.announcements') ? 'font-bold' : 'font-medium' }} text-sm">Bulletin Board</span>
            </a>

            <!-- Documents -->
            <a href="{{ route('admin.documents') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.documents') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('admin.documents') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="{{ request()->routeIs('admin.documents') ? 'font-bold' : 'font-medium' }} text-sm">Documents</span>
            </a>
        @else
            <!-- EMPLOYEE MENU OPTIONS -->
            <!-- Dashboard Home -->
            <a href="{{ route('employee.portal') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.portal') || request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.portal') || request()->routeIs('dashboard') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="{{ request()->routeIs('employee.portal') || request()->routeIs('dashboard') ? 'font-bold' : 'font-medium' }} text-sm">My ESS Portal</span>
            </a>

            <!-- Attendance / Time -->
            <a href="{{ route('employee.attendance') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.attendance') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.attendance') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="{{ request()->routeIs('employee.attendance') ? 'font-bold' : 'font-medium' }} text-sm">Attendance & Time</span>
            </a>

            <!-- Leave Requests -->
            <a href="{{ route('employee.leaves') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.leaves') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.leaves') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="{{ request()->routeIs('employee.leaves') ? 'font-bold' : 'font-medium' }} text-sm">Leave Requests</span>
            </a>

            <!-- My Tasks -->
            <a href="{{ route('employee.tasks') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.tasks') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.tasks') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <span class="{{ request()->routeIs('employee.tasks') ? 'font-bold' : 'font-medium' }} text-sm">My Tasks</span>
            </a>

            <!-- Documents & Payslips -->
            <a href="{{ route('employee.documents') }}" class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('employee.documents') || request()->routeIs('employee.document.sign') ? 'bg-brand-50 text-brand-700' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.documents') || request()->routeIs('employee.document.sign') ? 'text-brand-600' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="{{ request()->routeIs('employee.documents') || request()->routeIs('employee.document.sign') ? 'font-bold' : 'font-medium' }} text-sm">Documents Vault</span>
            </a>
        @endif

    <!-- Bottom Settings / Profile -->
    <div class="mt-auto w-full flex flex-col gap-1.5 pt-4 border-t border-slate-100">
        <a href="#" class="w-full flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-colors">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-medium text-sm">Settings</span>
        </a>
    </div>
</aside>

<!-- Dynamic Sidebar Toggle JavaScript -->
<script>
    function toggleSidebar(open) {
        const sidebar = document.getElementById('mainSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (!sidebar || !backdrop) return;
        
        if (open) {
            // Open mobile sidebar
            backdrop.classList.remove('hidden');
            // Trigger browser layout pass for opacity transition
            void backdrop.offsetWidth;
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100');
            document.body.classList.add('overflow-hidden');
        } else {
            // Close mobile sidebar
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    backdrop.classList.add('hidden');
                }
            }, 300);
        }
    }

    function toggleDesktopSidebar() {
        const sidebar = document.getElementById('desktopSidebar');
        if (!sidebar) return;
        
        const isCollapsed = sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebar-collapsed', isCollapsed ? 'true' : 'false');
    }
</script>
