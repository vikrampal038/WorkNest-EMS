    <!-- 2. Hero Section -->
    <section class="relative min-h-dvh pt-40 sm:pt-44 lg:pt-48 pb-20 lg:pb-24 bg-grid-pattern overflow-hidden flex flex-col">
        
        <!-- Ambient Mesh Blur Highlights (Premium Lights Projection) -->
        <div class="absolute top-[-10%] left-[-10%] w-125 h-125 bg-brand-400/15 rounded-full blur-[120px] -z-10 animate-pulse-slow"></div>
        <div class="absolute bottom-[5%] right-[-5%] w-150 h-150 bg-indigo-400/15 rounded-full blur-[140px] -z-10 animate-pulse-slow" style="animation-delay: 3s;"></div>
        <div class="absolute top-[35%] left-[45%] w-75 h-75 bg-violet-400/10 rounded-full blur-[90px] -z-10 animate-pulse-slow" style="animation-delay: 1.5s;"></div>

        <!-- Glowing backdrop behind the main dashboard frame to give it depth -->
        <div class="absolute top-[40%] right-[5%] w-137.5 h-87.5 bg-linear-to-tr from-brand-500/10 to-indigo-500/10 rounded-full blur-[80px] -z-10 pointer-events-none hidden lg:block"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 xl:gap-16 items-center">
                
                <!-- Left Content: Value Proposition -->
                <div class="lg:col-span-6 flex flex-col text-center lg:text-left">
                    
                    <!-- Premium Glass Pill Badge -->
                    <div class="inline-flex items-center gap-2 self-center lg:self-start bg-white/70 border border-slate-200/80 backdrop-blur-md text-slate-800 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-[10px] sm:text-xs font-semibold tracking-wide mb-6 lg:mb-8 shadow-sm hover:border-brand-300 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 cursor-pointer group">
                        <span class="flex h-2 w-2 sm:h-2.5 sm:w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 sm:h-2.5 sm:w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="font-medium text-slate-600">New Release:</span>
                        <span class="font-semibold text-slate-850 group-hover:text-brand-650 flex items-center gap-1">
                            Automated Regional Tax Audits <span class="group-hover:translate-x-0.5 transition-transform duration-200">&rarr;</span>
                        </span>
                    </div>

                    <!-- Main Headline with Gradient Overlay -->
                    <h1 class="text-3xl sm:text-5xl lg:text-[54px] xl:text-[62px] font-extrabold font-display text-slate-900 tracking-tight leading-[1.1] sm:leading-[1.08] mb-4 sm:mb-6">
                        Smart Employee & <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-linear-to-r from-brand-600 via-brand-500 to-indigo-600 text-glow">Attendance Hub</span>
                    </h1>

                    <!-- Subtext -->
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl mx-auto lg:mx-0 mb-6 sm:mb-8">
                        WorkNest unifies company directory management, automated leaves tracking, geo-restricted clock-ins, and accurate payroll processing in one modern platform.
                    </p>

                    <!-- CTAs with premium micro-interactions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center mb-8 sm:mb-10 w-full sm:w-auto">
                        <button @click="authModalOpen = true; authTab = 'signup'" type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl bg-brand-600 text-white font-semibold shadow-xl shadow-brand-600/10 hover:bg-brand-700 hover:-translate-y-0.5 active:scale-[0.98] hover:shadow-2xl hover:shadow-brand-600/25 transition-all duration-300 group cursor-pointer">
                            Start 14-Day Free Trial
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button @click="sandboxModalOpen = true" type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl bg-white border border-slate-200/80 backdrop-blur-md text-slate-700 font-semibold shadow-xs hover:bg-slate-50/50 hover:border-slate-350 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 cursor-pointer">
                            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Explore Dashboard
                        </button>
                    </div>

                    <!-- Real User Trust Badge Grid -->
                    <div class="flex flex-col sm:flex-row items-center gap-5 justify-center lg:justify-start">
                        <!-- Avatars stack -->
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="HR Executive">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="VP Operations">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Founder & CEO">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=100" alt="VP HR">
                        </div>
                        <div class="text-slate-600 text-sm text-center lg:text-left">
                            <div class="flex items-center justify-center lg:justify-start gap-1 mb-0.5">
                                <div class="flex text-amber-500">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <span class="font-bold text-slate-800">4.9/5 Rating</span>
                            </div>
                            <span>Trusted by <span class="font-semibold text-slate-900">5,000+ teams</span> at fast-growing companies</span>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Interactive SaaS Dashboard Preview -->
                <div class="lg:col-span-6 relative mt-6 lg:mt-0 perspective-1000 w-full max-w-125 mx-auto lg:mr-0 lg:ml-auto"
                     x-data="{ 
                         activeTab: 'employees', 
                         cardTiltX: 0, 
                         cardTiltY: 0,
                         payrollGenerated: false,
                         payrollLoading: false,
                         generatePayroll() {
                             this.payrollLoading = true;
                             setTimeout(() => {
                                 this.payrollLoading = false;
                                 this.payrollGenerated = true;
                             }, 1200);
                         }
                     }"
                     @mousemove="const rect = $el.getBoundingClientRect(); const x = $event.clientX - rect.left - (rect.width/2); const y = $event.clientY - rect.top - (rect.height/2); cardTiltX = -(y / rect.height) * 8; cardTiltY = (x / rect.width) * 8;"
                     @mouseleave="cardTiltX = 0; cardTiltY = 0">
                    
                    <!-- Dashboard Shadow & Ambient Base Glow -->
                    <div class="absolute inset-0 bg-linear-to-tr from-brand-600/15 via-indigo-600/10 to-transparent rounded-4xl blur-2xl -z-10 pointer-events-none"></div>

                    <!-- Main Dashboard Frame Card (Futuristic Dark Theme) -->
                    <div class="relative bg-slate-950 border border-slate-800/80 shadow-2xl p-4 sm:p-5 overflow-hidden w-full transition-all duration-300 hover:shadow-[0_30px_80px_-15px_rgba(99,102,241,0.22)] rounded-3xl"
                         :style="'transform: rotateX(' + cardTiltX + 'deg) rotateY(' + cardTiltY + 'deg) scale3d(1.01, 1.01, 1.01);'">
                        
                        <!-- Header Mock Bar -->
                        <div class="flex items-center justify-between border-b border-slate-900 pb-3.5 mb-4 select-none">
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-rose-450 border border-rose-500/25"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-450 border border-amber-500/25"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-450 border border-emerald-500/25"></span>
                                <span class="text-[9px] font-bold text-slate-500 ml-4 font-mono bg-slate-900 border border-slate-800/40 px-2.5 py-1 rounded-md">worknest.io/dashboard</span>
                            </div>
                            
                            <!-- Search & Profile Header -->
                            <div class="flex items-center gap-3">
                                <div class="hidden sm:flex items-center gap-1.5 bg-slate-900 border border-slate-800/50 rounded-lg px-2 py-1 text-[9px] text-slate-500">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    <span>Search...</span>
                                </div>
                                <div class="w-6.5 h-6.5 rounded-full bg-linear-to-tr from-brand-500 to-indigo-500 text-white flex items-center justify-center font-bold text-[9px] shadow-sm">
                                    AD
                                </div>
                            </div>
                        </div>

                        <!-- Real Dashboard Layout Grid -->
                        <div class="grid grid-cols-12 gap-4">
                            
                            <!-- Sidebar with premium buttons -->
                            <div class="col-span-3 hidden sm:flex flex-col gap-2 border-r border-slate-900 pr-3.5 select-none">
                                <div class="px-2 py-1.5 rounded-lg text-slate-650 font-semibold text-[8px] uppercase tracking-widest mb-1.5">
                                    Main menu
                                </div>
                                
                                <!-- Employees Tab -->
                                <button @click="activeTab = 'employees'"
                                        type="button"
                                        class="p-2 rounded-xl text-left text-[11px] flex items-center gap-2 cursor-pointer transition-all duration-200"
                                        :class="activeTab === 'employees' ? 'bg-slate-900 text-brand-400 font-bold border border-slate-800' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    <span>Employees</span>
                                </button>
                                
                                <!-- Attendance Tab -->
                                <button @click="activeTab = 'attendance'"
                                        type="button"
                                        class="p-2 rounded-xl text-left text-[11px] flex items-center gap-2 cursor-pointer transition-all duration-200"
                                        :class="activeTab === 'attendance' ? 'bg-slate-900 text-brand-400 font-bold border border-slate-800' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Analytics</span>
                                </button>

                                <!-- Payroll Tab -->
                                <button @click="activeTab = 'payroll'"
                                        type="button"
                                        class="p-2 rounded-xl text-left text-[11px] flex items-center gap-2 cursor-pointer transition-all duration-200"
                                        :class="activeTab === 'payroll' ? 'bg-slate-900 text-brand-400 font-bold border border-slate-800' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Payroll</span>
                                </button>
                            </div>

                            <!-- Dashboard Content Panels -->
                            <div class="col-span-12 sm:col-span-9 flex flex-col gap-4 min-h-87.5">
                                
                                <!-- Tab Panel 1: Directory (Employees) -->
                                <div x-show="activeTab === 'employees'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="flex flex-col gap-3.5">
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Workspace Directory</span>
                                            <span class="text-sm font-extrabold text-white">Active Team Registry</span>
                                        </div>
                                        <span class="text-[9px] font-bold bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-lg text-slate-400 font-mono">248 Active</span>
                                    </div>

                                    <!-- Employee List Grid -->
                                    <div class="flex flex-col gap-2">
                                        
                                        <!-- Sarah Jenkins -->
                                        <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-900 bg-slate-900/50 hover:bg-slate-900 hover:border-brand-500 transition-all duration-200">
                                            <div class="flex items-center gap-3">
                                                <img class="w-8.5 h-8.5 rounded-lg object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Sarah Jenkins">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-200">Sarah Jenkins</span>
                                                    <span class="text-[9px] text-slate-500 font-medium">VP Operations &bull; Remote</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[8px] font-extrabold uppercase">Checked In</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            </div>
                                        </div>

                                        <!-- Marcus Chen -->
                                        <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-900 bg-slate-900/50 hover:bg-slate-900 hover:border-brand-500 transition-all duration-200">
                                            <div class="flex items-center gap-3">
                                                <img class="w-8.5 h-8.5 rounded-lg object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="Marcus Chen">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-200">Marcus Chen</span>
                                                    <span class="text-[9px] text-slate-500 font-medium">Lead Developer &bull; In Office</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[8px] font-extrabold uppercase">Checked In</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            </div>
                                        </div>

                                        <!-- Elena Rostova -->
                                        <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-900 bg-slate-900/50 hover:bg-slate-900 hover:border-brand-500 transition-all duration-200">
                                            <div class="flex items-center gap-3">
                                                <img class="w-8.5 h-8.5 rounded-lg object-cover border border-slate-800" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="Elena Rostova">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-200">Elena Rostova</span>
                                                    <span class="text-[9px] text-slate-500 font-medium">Product Designer &bull; Sick Leave</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-405 text-[8px] font-extrabold uppercase">On Leave</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-450 animate-pulse"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Panel 2: Analytics / Attendance -->
                                <div x-show="activeTab === 'attendance'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="flex flex-col gap-3.5"
                                     style="display: none;">
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Workspace Analytics</span>
                                            <span class="text-sm font-extrabold text-white">Daily Attendance metrics</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 text-[9px] font-extrabold border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            94.2% Present Today
                                        </div>
                                    </div>

                                    <!-- Unique Visual: Dark Mode SVG Area Chart with Gradients -->
                                    <div class="rounded-2xl border border-slate-900 bg-slate-950 p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[9px] font-bold text-slate-400">Weekly Attendance Rate</span>
                                            <span class="text-[9px] text-brand-400 font-bold font-mono">Avg: 96.5%</span>
                                        </div>
                                        
                                        <div class="relative w-full">
                                            <svg class="w-full h-24 overflow-visible" viewBox="0 0 300 80" preserveAspectRatio="none">
                                                <defs>
                                                    <linearGradient id="dark-chart-glow" x1="0" y1="0" x2="0" y2="1">
                                                        <stop offset="0%" stop-color="#6366f1" stop-opacity="0.3"></stop>
                                                        <stop offset="100%" stop-color="#6366f1" stop-opacity="0.0"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <!-- Filled Gradient Path -->
                                                <path d="M 0 65 Q 40 45 80 55 T 160 30 T 240 40 T 300 15 L 300 80 L 0 80 Z" fill="url(#dark-chart-glow)"></path>
                                                <!-- Stroke Line -->
                                                <path d="M 0 65 Q 40 45 80 55 T 160 30 T 240 40 T 300 15" stroke="#6366f1" stroke-width="2.5" stroke-linecap="round" fill="none"></path>
                                                <!-- Dots -->
                                                <circle cx="80" cy="55" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                                <circle cx="160" cy="30" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                                <circle cx="240" cy="40" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                                <circle cx="300" cy="15" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                            </svg>
                                            <div class="flex justify-between mt-1.5 font-mono text-[7.5px] font-bold text-slate-500">
                                                <span>Mon</span>
                                                <span>Tue</span>
                                                <span>Wed</span>
                                                <span>Thu</span>
                                                <span>Fri</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mini Stats Grid -->
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="p-2 rounded-xl bg-slate-900/40 border border-slate-900/60 flex flex-col gap-0.5">
                                            <span class="text-[8px] text-slate-500 font-bold uppercase font-mono">Late Clock-ins</span>
                                            <span class="text-xs font-extrabold text-rose-455">3 Employees</span>
                                        </div>
                                        <div class="p-2 rounded-xl bg-slate-900/40 border border-slate-900/60 flex flex-col gap-0.5">
                                            <span class="text-[8px] text-slate-500 font-bold uppercase font-mono">On Field Duty</span>
                                            <span class="text-xs font-extrabold text-brand-400">12 Employees</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Panel 3: Payroll -->
                                <div x-show="activeTab === 'payroll'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="flex flex-col gap-3.5"
                                     style="display: none;">
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Payroll Processing Hub</span>
                                            <span class="text-sm font-extrabold text-white">Salary Generation</span>
                                        </div>
                                        <span class="text-[9px] font-bold bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-lg text-slate-400 font-mono">Cycle: May 2026</span>
                                    </div>

                                    <div class="p-3.5 rounded-xl border border-slate-900 bg-slate-900/50 flex items-center justify-between shadow-2xs">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-semibold uppercase tracking-wider text-slate-500 font-mono">Total gross payroll</span>
                                            <span class="text-xl font-extrabold text-white tracking-tight mt-0.5">$142,500.00</span>
                                        </div>
                                        
                                        <!-- Action Simulation Button -->
                                        <div>
                                            <button @click="generatePayroll()" 
                                                    type="submit" 
                                                    class="inline-flex items-center gap-1.5 px-3 py-2.5 rounded-xl text-[10px] font-bold shadow-xs transition-all duration-300 active:scale-95 cursor-pointer border"
                                                    :class="payrollGenerated 
                                                        ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' 
                                                        : (payrollLoading ? 'bg-slate-900 text-slate-500 border-slate-800' : 'bg-brand-600 text-white border-brand-500/10 hover:bg-brand-700')">
                                                
                                                <!-- Loading Spinner -->
                                                <svg x-show="payrollLoading" class="animate-spin h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" style="display: none;">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>

                                                <!-- Checkmark / Slips icon -->
                                                <svg x-show="!payrollLoading" class="w-3.5 h-3.5" :class="payrollGenerated ? 'text-emerald-400' : 'text-white'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path x-show="!payrollGenerated" stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    <path x-show="payrollGenerated" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" style="display: none;" />
                                                </svg>

                                                <span x-text="payrollLoading ? 'Processing...' : (payrollGenerated ? 'Slips Emailed' : 'Run Payroll Cycle')"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Salary Breakdown Details -->
                                    <div class="flex flex-col gap-2 bg-slate-950 p-3 rounded-xl border border-slate-900">
                                        <div class="flex items-center justify-between text-[9px] text-slate-500 border-b border-slate-900/60 pb-1.5">
                                            <span>Base Salaries</span>
                                            <span class="font-mono text-slate-350 font-bold">$124,000.00</span>
                                        </div>
                                        <div class="flex items-center justify-between text-[9px] text-slate-500 border-b border-slate-900/60 pb-1.5">
                                            <span>Overtime Payouts</span>
                                            <span class="font-mono text-slate-350 font-bold">$12,800.50</span>
                                        </div>
                                        <div class="flex items-center justify-between text-[9px] text-slate-500 pb-0.5">
                                            <span>Taxes & Compliance</span>
                                            <span class="font-mono text-rose-405 font-bold">-$24,850.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card 1: Beautiful Employee Action Widget -->
                    <div class="absolute -bottom-4 sm:-bottom-5 lg:-bottom-6 left-2 sm:-left-3 lg:-left-8 w-60 p-4 bg-slate-900/95 backdrop-blur-md rounded-2xl border border-slate-800 shadow-2xl animate-float hover:scale-102 hover:border-brand-500 transition-all duration-300 pointer-events-none" style="animation-delay: 0.5s;">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img class="w-10 h-10 rounded-xl object-cover border border-slate-800" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Clock-in User">
                                <span class="absolute -bottom-1 -right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-emerald-500 border-2 border-slate-900">
                                    <span class="absolute h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[8px] text-slate-500 uppercase tracking-wider font-semibold">Realtime Clock-In</span>
                                <span class="text-xs font-bold text-slate-200">Sarah Jenkins</span>
                                <span class="text-[9px] text-emerald-400 font-semibold mt-0.5">Checked In @ 08:58 AM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card 2: Quick Payroll Approval Card -->
                    <div class="absolute -top-5 sm:-top-6 lg:-top-8 right-2 sm:-right-3 lg:-right-8 w-64 p-4 bg-slate-900/95 backdrop-blur-md rounded-2xl border border-slate-800 shadow-2xl animate-float hover:scale-102 hover:border-indigo-500 transition-all duration-300 pointer-events-none" style="animation-delay: 1.5s;">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[8px] font-bold uppercase tracking-wider text-slate-500 font-mono">Payroll Status</span>
                            <span class="px-2 py-0.5 text-[8px] font-bold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 flex items-center gap-1">
                                <svg class="w-2.5 h-2.5 text-emerald-450" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Approved
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-semibold text-slate-500">Gross Payroll Amount</span>
                                <span class="text-base font-extrabold text-slate-250 tracking-tight">$142,500.00</span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-brand-950 border border-brand-800 flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" /></svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>