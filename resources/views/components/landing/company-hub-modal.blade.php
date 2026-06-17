    <!-- Company Hub Modal Overlay (Dynamic Glassmorphism Interface) -->
    <div x-show="companyHubOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-100 flex items-center justify-center p-4 sm:p-6 md:p-10 bg-slate-950/80 backdrop-blur-md"
         style="display: none;"
         @keydown.escape.window="companyHubOpen = false">
         
        <div x-show="companyHubOpen"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             @click.away="companyHubOpen = false"
             class="bg-white/95 border border-slate-200/50 rounded-3xl shadow-2xl w-full max-w-5xl h-[85vh] sm:h-[80vh] flex flex-col md:flex-row overflow-hidden relative backdrop-blur-xl">
             
            <!-- Close Button -->
            <button @click="companyHubOpen = false" 
                    type="button"
                    class="absolute top-5 right-5 w-10 h-10 rounded-full bg-slate-50 hover:bg-slate-100 border border-slate-200 flex items-center justify-center hover:rotate-90 transition-all duration-300 cursor-pointer z-50 text-slate-500 hover:text-slate-800 shadow-sm"
                    aria-label="Close Modal">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Left Sidebar Navigation -->
            <div class="w-full md:w-64 bg-slate-50/70 border-b md:border-b-0 md:border-r border-slate-200/60 p-6 flex flex-col justify-between shrink-0">
                <div class="flex flex-col gap-6">
                    <div class="flex items-center gap-2 select-none">
                        <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold text-base shadow-sm">W</div>
                        <span class="text-base font-bold text-slate-800 font-display">Company Hub</span>
                    </div>
                    
                    <nav class="flex flex-row md:flex-col gap-1.5 overflow-x-auto md:overflow-x-visible pb-3 md:pb-0 select-none scrollbar-none">
                        <button @click="activeHubTab = 'about'" type="button"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer w-auto md:w-full text-left"
                                :class="activeHubTab === 'about' ? 'bg-white border border-slate-250 shadow-xs text-brand-600' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 border border-transparent'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>About Us</span>
                        </button>

                        <button @click="activeHubTab = 'careers'" type="button"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer w-auto md:w-full text-left"
                                :class="activeHubTab === 'careers' ? 'bg-white border border-slate-250 shadow-xs text-brand-600' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 border border-transparent'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Careers</span>
                        </button>

                        <button @click="activeHubTab = 'customers'" type="button"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer w-auto md:w-full text-left"
                                :class="activeHubTab === 'customers' ? 'bg-white border border-slate-250 shadow-xs text-brand-600' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 border border-transparent'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Customers</span>
                        </button>

                        <button @click="activeHubTab = 'press'" type="button"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer w-auto md:w-full text-left"
                                :class="activeHubTab === 'press' ? 'bg-white border border-slate-250 shadow-xs text-brand-600' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 border border-transparent'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span>Press & Contact</span>
                        </button>
                    </nav>
                </div>
                
                <div class="hidden md:flex flex-col gap-1 border-t border-slate-200/65 pt-4 text-[10px] text-slate-400 font-medium">
                    <span>WorkNest Corp HQ</span>
                    <span>Mumbai, MH, India</span>
                </div>
            </div>

            <!-- Right Content Area (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8 md:p-10 bg-white scrollbar-none">
                
                <!-- Tab 1: About Us -->
                <div x-show="activeHubTab === 'about'" 
                     x-transition:enter="transition ease-out duration-250" 
                     x-transition:enter-start="opacity-0 translate-y-3" 
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6">
                    <div>
                        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-1">Our Story</span>
                        <h3 class="text-2xl font-bold font-display text-slate-900 tracking-tight">Modernizing Workforce Operations</h3>
                        <p class="text-slate-650 text-sm leading-relaxed mt-3">
                            WorkNest was established in 2024 to simplify complex administrative, payroll, and attendance systems for startups and mid-sized enterprises. By leveraging state-of-the-art automation interfaces, we eliminate administrative overhead and manual calculations, freeing operations managers to focus on growth.
                        </p>
                    </div>

                    <!-- SaaS Metric Grid -->
                    <div class="grid grid-cols-3 gap-4 border-t border-b border-slate-100 py-6 my-2">
                        <div class="text-center">
                            <div class="text-2xl font-black text-brand-600 font-display">10M+</div>
                            <span class="text-[9.5px] uppercase font-bold text-slate-400 tracking-wider">Punch Cards Logged</span>
                        </div>
                        <div class="text-center border-l border-r border-slate-100">
                            <div class="text-2xl font-black text-brand-600 font-display">120+</div>
                            <span class="text-[9.5px] uppercase font-bold text-slate-400 tracking-wider">Client Companies</span>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-black text-brand-600 font-display">99.99%</div>
                            <span class="text-[9.5px] uppercase font-bold text-slate-400 tracking-wider">Server Uptime SLA</span>
                        </div>
                    </div>

                    <!-- Core Pillars -->
                    <div class="flex flex-col gap-4">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Our Core Pillars</span>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl border border-slate-150 bg-slate-50/50">
                                <span class="font-bold text-slate-800 text-xs block mb-1">Product Excellence</span>
                                <p class="text-[11px] text-slate-550 leading-relaxed">We design extremely interactive, responsive, and intuitive products that require zero staff training.</p>
                            </div>
                            <div class="p-4 rounded-xl border border-slate-150 bg-slate-50/50">
                                <span class="font-bold text-slate-800 text-xs block mb-1">Security-First Infrastructure</span>
                                <p class="text-[11px] text-slate-550 leading-relaxed">All check-in data, payslips, and compliance records are encrypted, backed up, and isolated securely.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Careers -->
                <div x-show="activeHubTab === 'careers'" 
                     x-transition:enter="transition ease-out duration-250" 
                     x-transition:enter-start="opacity-0 translate-y-3" 
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6"
                     style="display: none;"
                     x-data="{ 
                         applyOpen: false, 
                         applied: false, 
                         activeJob: '', 
                         jobForm: { name: '', email: '', phone: '', note: '' },
                         jobErrors: {},
                         submitJobForm() {
                             this.jobErrors = {};
                             let hasErrors = false;
                             
                             if (!this.jobForm.name) {
                                 this.jobErrors.name = 'Name is required';
                                 hasErrors = true;
                             } else if (!/^[A-Za-z\s]{2,50}$/.test(this.jobForm.name)) {
                                 this.jobErrors.name = 'Name must contain letters and spaces only';
                                 hasErrors = true;
                             }
                             
                             if (!this.jobForm.email) {
                                 this.jobErrors.email = 'Email is required';
                                 hasErrors = true;
                             } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.jobForm.email)) {
                                 this.jobErrors.email = 'Please enter a valid email address';
                                 hasErrors = true;
                             }
                             
                             if (!this.jobForm.phone) {
                                 this.jobErrors.phone = 'Phone number is required';
                                 hasErrors = true;
                             } else if (!/^\d{10}$/.test(this.jobForm.phone)) {
                                 this.jobErrors.phone = 'Phone number must be exactly 10 digits';
                                 hasErrors = true;
                             }
                             
                             if (!this.jobForm.note) {
                                 this.jobErrors.note = 'Introduction is required';
                                 hasErrors = true;
                             }
                             
                             if (hasErrors) return;
                             this.applied = true;
                         }
                     }">
                    
                    <div x-show="!applyOpen">
                        <div>
                            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-1">Join the Team</span>
                            <h3 class="text-2xl font-bold font-display text-slate-900 tracking-tight">Open Positions</h3>
                            <p class="text-slate-600 text-sm mt-1">We are always looking for smart, ambitious talent to build the future of HR operations.</p>
                        </div>

                        <!-- Jobs List -->
                        <div class="flex flex-col gap-3.5 mt-6">
                            
                            <!-- Job 1 -->
                            <div class="p-5 rounded-2xl border border-slate-200/80 bg-white hover:border-brand-200 hover:shadow-md transition-all duration-300 flex items-center justify-between gap-4">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800 text-sm">Senior Full-Stack Engineer</span>
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-extrabold">Remote</span>
                                    </div>
                                    <span class="text-xs text-slate-450 mt-1">Engineering • Full-time • Mumbai / Remote</span>
                                </div>
                                <button @click="applyOpen = true; activeJob = 'Senior Full-Stack Engineer'; applied = false" type="button"
                                        class="px-4 py-2 bg-slate-900 hover:bg-brand-600 text-white hover:scale-[1.02] active:scale-[0.98] transition-all text-xs font-bold rounded-xl cursor-pointer">
                                    Apply Now
                                </button>
                            </div>

                            <!-- Job 2 -->
                            <div class="p-5 rounded-2xl border border-slate-200/80 bg-white hover:border-brand-200 hover:shadow-md transition-all duration-300 flex items-center justify-between gap-4">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800 text-sm">Senior UX/UI Designer</span>
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-extrabold">Remote</span>
                                    </div>
                                    <span class="text-xs text-slate-450 mt-1">Design • Full-time • Remote</span>
                                </div>
                                <button @click="applyOpen = true; activeJob = 'Senior UX/UI Designer'; applied = false" type="button"
                                        class="px-4 py-2 bg-slate-900 hover:bg-brand-600 text-white hover:scale-[1.02] active:scale-[0.98] transition-all text-xs font-bold rounded-xl cursor-pointer">
                                    Apply Now
                                </button>
                            </div>

                            <!-- Job 3 -->
                            <div class="p-5 rounded-2xl border border-slate-200/80 bg-white hover:border-brand-200 hover:shadow-md transition-all duration-300 flex items-center justify-between gap-4">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800 text-sm">HR Operations Specialist</span>
                                        <span class="px-2 py-0.5 rounded-full bg-brand-50 text-brand-700 border border-brand-200 text-[9px] font-extrabold">Hybrid</span>
                                    </div>
                                    <span class="text-xs text-slate-450 mt-1">Operations • Full-time • Mumbai HQ</span>
                                </div>
                                <button @click="applyOpen = true; activeJob = 'HR Operations Specialist'; applied = false" type="button"
                                        class="px-4 py-2 bg-slate-900 hover:bg-brand-600 text-white hover:scale-[1.02] active:scale-[0.98] transition-all text-xs font-bold rounded-xl cursor-pointer">
                                    Apply Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Application Form Overlay -->
                    <div x-show="applyOpen" class="flex flex-col gap-5" style="display: none;">
                        <div class="flex items-center justify-between gap-4 border-b border-slate-100 pb-4">
                            <div>
                                <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block" x-text="'Apply for ' + activeJob"></span>
                                <h3 class="text-xl font-bold font-display text-slate-900 mt-0.5">Submit Application</h3>
                            </div>
                            <button @click="applyOpen = false" type="button" class="text-xs font-bold text-slate-400 hover:text-slate-700 cursor-pointer">
                                &larr; Back to Positions
                            </button>
                        </div>

                        <div x-show="!applied" class="flex flex-col gap-4">
                            <form @submit.prevent="submitJobForm()" class="space-y-4" novalidate>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Full Name</label>
                                    <input type="text" required x-model="jobForm.name" :class="jobErrors.name ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-4 py-2.5 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="e.g. Jane Doe">
                                    <span x-show="jobErrors.name" x-text="jobErrors.name" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email Address</label>
                                    <input type="email" required x-model="jobForm.email" :class="jobErrors.email ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-4 py-2.5 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="e.g. jane@company.com">
                                    <span x-show="jobErrors.email" x-text="jobErrors.email" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Phone Number</label>
                                    <input type="text" inputmode="numeric" maxlength="10" required x-model="jobForm.phone" @input="jobForm.phone = jobForm.phone.replace(/[^0-9]/g, '')" :class="jobErrors.phone ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-4 py-2.5 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="e.g. 9876543210">
                                    <span x-show="jobErrors.phone" x-text="jobErrors.phone" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Cover Note / Introduction</label>
                                    <textarea required rows="4" x-model="jobForm.note" :class="jobErrors.note ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-4 py-2.5 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="Briefly introduce yourself and why you'd like to join..."></textarea>
                                    <span x-show="jobErrors.note" x-text="jobErrors.note" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Upload Resume (PDF, DOCX)</label>
                                    <div class="w-full border border-dashed border-slate-300 rounded-xl p-4 bg-slate-50/30 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-slate-50/70 transition-colors">
                                        <svg class="w-6 h-6 text-slate-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span class="text-[10px] font-bold text-slate-655">Click to select resume file</span>
                                        <span class="text-[8.5px] text-slate-400 mt-0.5">Max size: 5MB</span>
                                    </div>
                                </div>
                                
                                <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-brand-600/10 active:scale-[0.98] transition-all cursor-pointer">
                                    Submit Cover & Application
                                </button>
                            </form>
                        </div>

                        <!-- Success State -->
                        <div x-show="applied" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="p-8 text-center bg-slate-50 border border-slate-200/60 rounded-2xl flex flex-col items-center justify-center"
                             style="display: none;">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-500 mb-4 shadow-sm">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Application Received!</h4>
                            <p class="text-xs text-slate-500 mt-2 max-w-sm leading-relaxed">
                                Thank you for applying. Our talent acquisition team will review your qualifications and reach out within 3 business days.
                            </p>
                            <button @click="applyOpen = false; applied = false" type="button" class="mt-6 px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl cursor-pointer">
                                Back to Open Roles
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Customers -->
                <div x-show="activeHubTab === 'customers'" 
                     x-transition:enter="transition ease-out duration-250" 
                     x-transition:enter-start="opacity-0 translate-y-3" 
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6"
                     style="display: none;">
                    <div>
                        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-1">Success & Validation</span>
                        <h3 class="text-2xl font-bold font-display text-slate-900 tracking-tight">Our Trust Metrics</h3>
                        <p class="text-slate-600 text-sm mt-1">We power employee management for scaling teams across multiple industries.</p>
                    </div>

                    <!-- NPS and retention stats grid -->
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="p-5 rounded-2xl border border-slate-200/80 bg-white shadow-xs">
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Net Promoter Score (NPS)</span>
                            <div class="text-3xl font-black text-brand-600 mt-1 font-display">74</div>
                            <p class="text-[11px] text-slate-500 mt-2 leading-relaxed">Ranked high in SaaS industry standards for user satisfaction and ease-of-use.</p>
                        </div>

                        <div class="p-5 rounded-2xl border border-slate-200/80 bg-white shadow-xs">
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Annual Customer Retention</span>
                            <div class="text-3xl font-black text-emerald-600 mt-1 font-display">99.2%</div>
                            <p class="text-[11px] text-slate-500 mt-2 leading-relaxed">Demonstrating consistent product quality, updates, and customer service.</p>
                        </div>
                    </div>

                    <!-- Customer Spotlight card -->
                    <div class="p-6 rounded-2xl border border-slate-150 bg-slate-50/50 relative overflow-hidden">
                        <span class="text-[10.5px] uppercase font-bold text-slate-400 tracking-wider">Customer Spotlight</span>
                        <p class="text-xs text-slate-700 italic leading-relaxed mt-3 relative z-10">
                            "WorkNest has allowed our administrative teams to automate timesheet validation and payroll cycles. Setting up regional taxes took less than an hour, and our staff satisfaction score went up immediately."
                        </p>
                        <div class="mt-4 flex items-center gap-3 relative z-10">
                            <div class="w-8.5 h-8.5 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs">RM</div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-800 leading-tight">Rachel Miller</span>
                                <span class="text-[9.5px] text-slate-400 font-bold">VP of Operations • Delta Core Group</span>
                            </div>
                        </div>
                            </div>
                        </div>

                    <!-- Tab 3: Press -->
                    <div x-show="activeHubTab === 'press'" 
                     x-transition:enter="transition ease-out duration-250" 
                     x-transition:enter-start="opacity-0 translate-y-3" 
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6"
                     style="display: none;"
                     x-data="{ 
                         contactSubmitted: false, 
                         contactForm: { name: '', email: '', phone: '', subject: '', message: '' },
                         contactErrors: {},
                         submitContact() {
                             this.contactErrors = {};
                             let hasErrors = false;
                             
                             if (!this.contactForm.name) {
                                 this.contactErrors.name = 'Name is required';
                                 hasErrors = true;
                             } else if (!/^[A-Za-z\s]{2,50}$/.test(this.contactForm.name)) {
                                 this.contactErrors.name = 'Please enter letters and spaces only';
                                 hasErrors = true;
                             }
                             
                             if (!this.contactForm.email) {
                                 this.contactErrors.email = 'Email is required';
                                 hasErrors = true;
                             } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.contactForm.email)) {
                                 this.contactErrors.email = 'Please enter a valid email address';
                                 hasErrors = true;
                             }
                             
                             if (!this.contactForm.phone) {
                                 this.contactErrors.phone = 'Phone number is required';
                                 hasErrors = true;
                             } else if (!/^\d{10}$/.test(this.contactForm.phone)) {
                                 this.contactErrors.phone = 'Must be exactly 10 digits';
                                 hasErrors = true;
                             }
                             
                             if (!this.contactForm.subject) {
                                 this.contactErrors.subject = 'Subject is required';
                                 hasErrors = true;
                             }
                             if (!this.contactForm.message) {
                                 this.contactErrors.message = 'Message is required';
                                 hasErrors = true;
                             }
                             
                             if (hasErrors) return;
                             this.contactSubmitted = true;
                         }
                     }">
                    
                    <div x-show="!contactSubmitted">
                        <div>
                            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest block mb-1">Get in Touch</span>
                            <h3 class="text-2xl font-bold font-display text-slate-900 tracking-tight">Press & Inquiries</h3>
                            <p class="text-slate-650 text-sm mt-1">Need a media kit, custom contract details, or support help? Submit an inquiry.</p>
                        </div>

                        <div class="grid sm:grid-cols-12 gap-6 items-start mt-6">
                            
                            <!-- Left: Contact Form -->
                            <form @submit.prevent="submitContact()" class="sm:col-span-7 space-y-4" novalidate>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Your Name</label>
                                        <input type="text" required x-model="contactForm.name" :class="contactErrors.name ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-3 py-2 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="Name">
                                        <span x-show="contactErrors.name" x-text="contactErrors.name" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email Address</label>
                                        <input type="email" required x-model="contactForm.email" :class="contactErrors.email ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-3 py-2 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="Email">
                                        <span x-show="contactErrors.email" x-text="contactErrors.email" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Phone Number</label>
                                        <input type="text" inputmode="numeric" maxlength="10" required x-model="contactForm.phone" @input="contactForm.phone = contactForm.phone.replace(/[^0-9]/g, '')" :class="contactErrors.phone ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-3 py-2 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="Phone">
                                        <span x-show="contactErrors.phone" x-text="contactErrors.phone" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Subject</label>
                                    <input type="text" required x-model="contactForm.subject" :class="contactErrors.subject ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-3 py-2 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="Subject">
                                    <span x-show="contactErrors.subject" x-text="contactErrors.subject" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Your Message</label>
                                    <textarea required rows="4" x-model="contactForm.message" :class="contactErrors.message ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full px-3 py-2 rounded-xl border bg-slate-50/50 text-xs focus:ring-2 focus:outline-hidden" placeholder="Type message..."></textarea>
                                    <span x-show="contactErrors.message" x-text="contactErrors.message" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>
                                <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md active:scale-[0.98] transition-all cursor-pointer">
                                    Send Inquiry Message
                                </button>
                            </form>

                            <!-- Right: Addresses & Links -->
                            <div class="sm:col-span-5 flex flex-col gap-4">
                                <div class="p-4 rounded-xl border border-slate-150 bg-slate-50/50">
                                    <span class="font-bold text-slate-800 text-xs block mb-1">Media Relations</span>
                                    <span class="text-[11px] text-slate-450 block">press@worknest.io</span>
                                    <span class="text-[11px] text-slate-450 block mt-0.5">media-hub@worknest.io</span>
                                </div>
                                <div class="p-4 rounded-xl border border-slate-150 bg-slate-50/50">
                                    <span class="font-bold text-slate-800 text-xs block mb-1">Media Kit Download</span>
                                    <p class="text-[10px] text-slate-500 leading-relaxed">Download logo packages, screenshot assets, and press release templates.</p>
                                    <a href="#" class="mt-3.5 inline-flex items-center gap-1.5 text-xs text-brand-600 hover:underline font-bold">
                                        Download Media Kit &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success State -->
                    <div x-show="contactSubmitted"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="p-10 text-center bg-slate-50 border border-slate-200/60 rounded-2xl flex flex-col items-center justify-center"
                         style="display: none;">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-500 mb-4 shadow-sm">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Inquiry Transmitted!</h4>
                        <p class="text-xs text-slate-500 mt-2 max-w-sm leading-relaxed">
                            Your message has been received by our media and operations desk. A communications representative will reply to your registered email address shortly.
                        </p>
                        <button @click="contactSubmitted = false" type="button" class="mt-6 px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl cursor-pointer">
                            Back to Form
                        </button>
                    </div>
                </div>

            </div> <!-- End Right Scrollable Content Pane -->
        </div> <!-- End Modal Card -->
    </div> <!-- End Company Hub Modal Overlay -->