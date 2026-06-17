    <!-- 8. Integrations Section -->
    <section id="integrations" class="py-24 bg-site-bg-alt border-t border-b border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-16 items-center">
                
                <!-- Left Details -->
                <div class="gsap-fade-up lg:col-span-5 flex flex-col text-center lg:text-left">
                    <span class="text-xs font-bold tracking-widest text-brand-600 uppercase bg-brand-50 px-3 py-1.5 rounded-md self-center lg:self-start">
                        Modern Integrations
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                        Work with your favorite tools
                    </h2>
                    <p class="text-slate-600 mb-8 leading-relaxed">
                        WorkNest connects with leading tools to sync employee statuses, post check-in updates, schedule video interviews, and record meetings.
                    </p>

                    <!-- Features bullets -->
                    <ul class="flex flex-col gap-3 text-slate-700 text-sm font-semibold max-w-md mx-auto lg:mx-0">
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">✓</div>
                            <span>Auto-notify check-in events to designated Slack channels</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">✓</div>
                            <span>Link leave dates automatically with Google Calendar</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">✓</div>
                            <span>Configure automated emails for payslips via Gmail</span>
                        </li>
                    </ul>
                </div>

                <!-- Right Cards Grid: Orbital Integration Web -->
                <div class="gsap-stagger-container lg:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-6 relative p-2 sm:p-4">
                    
                    <!-- SVG Connection Lines utilizing percentage bounds for perfect alignment -->
                    <svg class="absolute inset-0 w-full h-full pointer-events-none hidden sm:block text-slate-300/60" fill="none">
                        <line x1="50%" y1="50%" x2="16.6%" y2="16.6%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                        <line x1="50%" y1="50%" x2="50%" y2="16.6%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                        <line x1="50%" y1="50%" x2="83.3%" y2="16.6%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                        <line x1="50%" y1="50%" x2="16.6%" y2="50%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                        <line x1="50%" y1="50%" x2="83.3%" y2="50%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                        <line x1="50%" y1="50%" x2="16.6%" y2="83.3%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                        <line x1="50%" y1="50%" x2="50%" y2="83.3%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                        <line x1="50%" y1="50%" x2="83.3%" y2="83.3%" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4,4" />
                    </svg>

                    <!-- Slack Card -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-[#4A154B]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5.042 15.165a2.528 2.528 0 0 1-2.52 2.523 2.528 2.528 0 0 1-2.522-2.523 2.528 2.528 0 0 1 2.522-2.52h2.52v2.52zm1.261 0a2.528 2.528 0 0 1 2.52-2.52h5.043a2.528 2.528 0 0 1 2.522 2.52v5.042a2.528 2.528 0 0 1-2.522 2.52H8.824a2.528 2.528 0 0 1-2.52-2.52v-5.042z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">Slack</span>
                        <span class="text-[9px] text-emerald-600 font-extrabold mt-1.5 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Live Notify</span>
                    </div>

                    <!-- Outlook Card -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-[#0078D4]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">Outlook</span>
                        <span class="text-[9px] text-emerald-600 font-extrabold mt-1.5 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Sync Active</span>
                    </div>

                    <!-- Google Calendar -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-[#4285F4]" fill="currentColor" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" />
                                <text x="6" y="16" font-family="Arial" font-size="12" font-weight="bold" fill="white">G</text>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">Google Cal</span>
                        <span class="text-[9px] text-emerald-600 font-extrabold mt-1.5 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Connected</span>
                    </div>

                    <!-- Zoom Card -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-[#2D8CFF]" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <polygon points="8,10 12,12 8,14" fill="white" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">Zoom Meetings</span>
                        <span class="text-[9px] text-emerald-600 font-extrabold mt-1.5 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Connected</span>
                    </div>

                    <!-- CENTRAL HUB CODE -->
                    <div class="gsap-stagger-item col-span-1 flex flex-col items-center justify-center p-6 bg-brand-900 rounded-2xl border border-brand-700 shadow-xl text-white select-none z-10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-radial-glow opacity-30 animate-pulse-slow"></div>
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-brand-600 font-black text-xl shadow-md group-hover:scale-105 transition-transform duration-300">W</div>
                        <span class="text-[11px] font-extrabold mt-3 font-display tracking-tight text-white">WorkNest Sync</span>
                        <span class="text-[7.5px] text-brand-300 uppercase tracking-widest mt-1 font-bold">Gateway hub</span>
                    </div>

                    <!-- MS Teams -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-[#464EB8]" fill="currentColor" viewBox="0 0 24 24">
                                <text x="5" y="17" font-family="Arial" font-size="14" font-weight="bold">T</text>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">MS Teams</span>
                        <span class="text-[9px] text-slate-500 font-bold mt-1.5 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200/60">Add-on</span>
                    </div>

                    <!-- Gmail Card -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-[#EA4335]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                                <polygon points="2,6 12,13 22,6" fill="none" stroke="white" stroke-width="2" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">Gmail Alerts</span>
                        <span class="text-[9px] text-emerald-600 font-extrabold mt-1.5 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">Sync Active</span>
                    </div>

                    <!-- GitHub Card -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-slate-800" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482C19.138 20.197 22 16.44 22 12.017 22 6.484 17.522 2 12 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">GitHub Org</span>
                        <span class="text-[9px] text-slate-500 font-bold mt-1.5 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200/60">Add-on</span>
                    </div>

                    <!-- Figma Card -->
                    <div class="gsap-stagger-item p-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col items-center justify-center text-center hover:-translate-y-1 hover:shadow-md transition-all duration-300 z-10 group/item">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4 group-hover/item:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-slate-800" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2a4 4 0 00-4 4v4a4 4 0 004 4 4 4 0 004-4V6a4 4 0 00-4-4zm0 12a4 4 0 00-4 4v4a4 4 0 008 0v-4a4 4 0 00-4-4z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800 font-display">Figma</span>
                        <span class="text-[9px] text-slate-500 font-bold mt-1.5 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200/60">Add-on</span>
                    </div>

                </div>

            </div>
        </div>
    </section>