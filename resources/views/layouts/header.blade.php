<header class="h-16 w-full flex items-center justify-between px-4 md:px-6 shrink-0 bg-white border-b border-slate-200 z-40 sticky top-0">
    <!-- Left: Hamburger Button + Client Workspace Indicator -->
    <div class="flex items-center gap-3">
        <!-- Hamburger Menu Button (Mobile/Tablet Only) -->
        <button onclick="toggleSidebar(true)" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-50 border border-slate-200/80 md:hidden transition-all shadow-sm flex items-center justify-center shrink-0" aria-label="Toggle Sidebar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Client Workspace Indicator -->
        <div class="flex items-center gap-2.5 cursor-pointer group">
            <!-- Client Logo Placeholder -->
            <div class="w-9 h-9 md:w-10 md:h-10 rounded-lg bg-slate-50 border border-slate-200 shadow-sm flex items-center justify-center shrink-0 overflow-hidden text-brand-600 font-bold text-sm md:text-base group-hover:border-brand-300 transition-colors">
                AC
            </div>
            <div class="flex flex-col overflow-hidden">
                <span class="text-sm md:text-base font-bold text-slate-800 truncate leading-tight group-hover:text-brand-600 transition-colors">Acme Corp</span>
                <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold truncate hidden sm:block">Active Workspace</span>
            </div>
            <!-- Selector Icon -->
            <svg class="w-3.5 h-3.5 text-slate-400 ml-0.5 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <!-- Right: Search, Date, Notifications, Profile -->
    <div class="flex items-center gap-4">
        <!-- Search Bar -->
        <div class="relative hidden lg:block w-96 group">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none transition-transform group-focus-within:scale-110">
                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" class="w-full pl-10 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="Search employees, documents...">
        </div>

        <div class="flex items-center gap-2">
            <!-- Notification Bell -->
            <button class="relative p-2 text-slate-500 hover:text-brand-600 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 border-2 border-white rounded-full animate-pulse"></span>
            </button>

            <!-- Date Selector -->
            <button class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-lg transition-all group">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-xs font-semibold text-slate-600 group-hover:text-slate-900 transition-colors">Oct 24, 2026</span>
            </button>
        </div>

        <div class="w-px h-6 bg-slate-200 hidden sm:block"></div>

        <!-- User Profile Avatar -->
        <div class="flex items-center gap-2.5 cursor-pointer group">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-slate-800 leading-none group-hover:text-brand-600 transition-colors">Alex Rivera</p>
                <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-0.5">Admin</p>
            </div>
            <div class="relative">
                <img src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="Profile" class="w-9 h-9 rounded-full border border-slate-200 object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></div>
            </div>
        </div>
    </div>
</header>
