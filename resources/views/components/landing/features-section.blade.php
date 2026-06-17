    <!-- 4. Core Features Section -->
    <section id="features" class="py-24 bg-site-bg-alt">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-brand-600 uppercase bg-brand-50 px-3 py-1.5 rounded-md">
                    Centralized Modules
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                    Everything you need to govern modern work
                </h2>
                <p class="text-slate-600">
                    A suite of professional tools engineered to streamline payroll calculations, track clock-ins, regulate leave approvals, and unify company directories.
                </p>
            </div>

            <!-- Features Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 gsap-stagger-container">
                
                <!-- Highlight Feature 1: Attendance Tracking with radar mapping visual -->
                <div class="gsap-stagger-item md:col-span-2 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/80 shadow-xs hover:border-brand-200 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-950 font-display mb-3">Smart Geo-Attendance</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Construct custom geofence coordinates and restrict check-ins to authorized workplace parameters. Complete IP masking checks verify zero proxy attendance submissions.
                        </p>
                        <button @click="sandboxModalOpen = true; sandboxTab = 'attendance'" type="button" class="text-xs font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Configure parameters &rarr;
                        </button>
                    </div>
                    
                    <!-- Visual Radar Mock -->
                    <div class="w-full md:w-56 h-44 rounded-2xl bg-slate-50 border border-slate-200/50 p-4 flex flex-col justify-between relative overflow-hidden select-none">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-400 uppercase font-mono">GPS Verification</span>
                            <span class="px-2 py-0.5 text-[8px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 animate-pulse">Active bounds</span>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-30">
                            <div class="w-24 h-24 rounded-full border border-brand-500 animate-ping"></div>
                            <div class="w-16 h-16 rounded-full border border-brand-300"></div>
                            <div class="w-8 h-8 rounded-full border border-brand-200"></div>
                        </div>
                        <div class="flex items-center gap-2.5 bg-white p-2.5 rounded-xl border border-slate-150 shadow-xs z-10">
                            <div class="w-7 h-7 rounded-lg bg-brand-50 border border-brand-100 flex items-center justify-center text-[10px] font-bold text-brand-700">W</div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-slate-800">Acme HQ (Primary)</span>
                                <span class="text-[8px] text-slate-400 font-mono">Lat: 34.0522, Lng: -118.2437</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Highlight Feature 2: Automated Payroll with Compliances visual -->
                <div class="gsap-stagger-item md:col-span-2 p-6 sm:p-8 rounded-3xl bg-slate-950 text-white shadow-2xl shadow-slate-950/15 hover:-translate-y-1 hover:shadow-2xl hover:shadow-brand-950/25 transition-all duration-300 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
                    <div class="absolute top-[-20%] right-[-10%] w-72 h-72 bg-brand-500/10 rounded-full blur-[80px] -z-10 pointer-events-none"></div>
                    <div class="flex-1 z-10">
                        <div class="w-12 h-12 rounded-xl bg-brand-650 flex items-center justify-center mb-6 text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold font-display mb-3 text-white">Automated Pay Run Engine</h3>
                        <p class="text-slate-300 text-sm leading-relaxed mb-6">
                            Auto-calculate deductions, compute local tax regulations, synchronize approved leave cycles, and generate bulk pay runs with bank-deposit files.
                        </p>
                        <button @click="sandboxModalOpen = true; sandboxTab = 'payroll'" type="button" class="text-xs font-bold text-brand-300 flex items-center gap-2 cursor-pointer hover:text-brand-200 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-450 animate-pulse"></span>
                            Launch Pay Run Simulator &rarr;
                        </button>
                    </div>
                    
                    <!-- Visual Calculator Mock -->
                    <div class="w-full md:w-56 h-44 rounded-2xl bg-white/5 border border-white/10 p-4 flex flex-col justify-between select-none z-10 backdrop-blur-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-[8px] font-bold text-slate-400 uppercase font-mono">Tax Audit Score</span>
                            <span class="text-[9px] font-extrabold text-emerald-400 font-mono">100% Compliant</span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between text-[9px] text-slate-300">
                                <span>Federal Tax</span>
                                <span class="font-bold font-mono">$12,450.00</span>
                            </div>
                            <div class="flex items-center justify-between text-[9px] text-slate-300">
                                <span>Regional Tax</span>
                                <span class="font-bold font-mono">$4,820.00</span>
                            </div>
                            <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-400 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="text-[10px] font-bold text-white bg-brand-600/80 px-2.5 py-1.5 rounded-lg border border-brand-500 text-center">
                            Calculations Verified
                        </div>
                    </div>
                </div>

                <!-- Regular Feature 3: Directory -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Staff Directory</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Centralize secure contracts, personal details, roles, and profiles for your entire team.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'employees'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore directory &rarr;
                    </button>
                </div>

                <!-- Regular Feature 4: Leaves -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Leave Approvals</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Customize leave type parameters, track holidays, and authorize leave submissions in one click.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'leaves'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore leaves &rarr;
                    </button>
                </div>

                <!-- Regular Feature 5: Salary Slips -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Digital Salary Slips</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Create secure PDF payroll payslips that workers can directly access and download.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'slips'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore slips &rarr;
                    </button>
                </div>

                <!-- Regular Feature 6: Roles -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Role Permissions</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Establish granular permission levels for Admins, Managers, and general Employees.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'permissions'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore controls &rarr;
                    </button>
                </div>

            </div>

        </div>
    </section>