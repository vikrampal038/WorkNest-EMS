    <!-- 11. FAQ Section -->
    <section id="faq" class="py-24 bg-site-bg" 
             x-data="{ 
                 activeFaq: null, 
                 activeCategory: 'all',
                 faqs: [
                     {
                         id: 1,
                         category: 'general',
                         question: 'Is there a limit to the number of employees we can manage?',
                         answer: 'No. The Starter plan accommodates up to 15 personnel, Professional fits up to 100, and our Enterprise tier provides unlimited slots to align with scaling corporate teams.'
                     },
                     {
                         id: 2,
                         category: 'attendance',
                         question: 'How does the geo-fenced attendance clock-in mechanism work?',
                         answer: 'HR administrators can restrict daily clock-in inputs to specific geographical coordinates or IP ranges. When staff submit clock-ins, the browser validates coordinate ranges to prevent proxy attendance records.'
                     },
                     {
                         id: 3,
                         category: 'payroll',
                         question: 'Can we run payroll for international remote teams?',
                         answer: 'Yes. You can customize base currency profiles, designate specific tax deduction rates per employee profile, and compute distinct wages depending on local contracts.'
                     },
                     {
                         id: 4,
                         category: 'security',
                         question: 'How secure is our company and employee data on WorkNest?',
                         answer: 'We leverage bank-grade encryption protocols, double-hashed password databases, complete CSRF request token validation, and isolate tenant company databases strictly to verify zero leakage.'
                     }
                 ],
                 // Helper to filter FAQs
                 shouldShow(faq) {
                     return this.activeCategory === 'all' || faq.category === this.activeCategory;
                 },
                 demoBookingSubmitted: false,
                 demoBookingLoading: false,
                 selectedDemoDay: 'Mon',
                 selectedDemoTime: '10:00 AM',
                 demoBookingEmail: '',
                 demoBookingError: '',
                 submitDemoBooking() {
                     this.demoBookingError = '';
                     if (!this.demoBookingEmail) {
                         this.demoBookingError = 'Email is required';
                         return;
                     }
                     if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.demoBookingEmail)) {
                         this.demoBookingError = 'Please enter a valid email address';
                         return;
                     }
                     this.demoBookingLoading = true;
                     setTimeout(() => {
                         this.demoBookingLoading = false;
                         this.demoBookingSubmitted = true;
                     }, 1500);
                 }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid lg:grid-cols-12 gap-12 sm:gap-16 items-start">
                
                <!-- Left Column: FAQ Sticky Category Selector Board -->
                <div class="gsap-fade-up lg:col-span-4 lg:sticky lg:top-28 flex flex-col gap-8">
                    <div>
                        <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-3 py-1.5 rounded-md">
                            Answers & Help
                        </span>
                        <h2 class="text-3xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-4">
                            Frequently Asked Questions
                        </h2>
                        <p class="text-slate-650 text-sm leading-relaxed">
                            Have query questions about shifts, compliance audits, configurations, and pricing plans? Select categories to filter.
                        </p>
                    </div>

                    <!-- Category filter tags list -->
                    <div class="flex flex-col gap-2.5 select-none">
                        <button @click="activeCategory = 'all'; activeFaq = null" type="button"
                                class="flex items-center justify-between px-4 py-3 rounded-xl border font-bold text-xs transition-all duration-200 cursor-pointer"
                                :class="activeCategory === 'all' 
                                    ? 'bg-slate-900 border-slate-900 text-white' 
                                    : 'bg-slate-50 border-slate-200/60 text-slate-700 hover:bg-slate-100'">
                            <span>All FAQ Questions</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-200 text-slate-800 font-extrabold" 
                                  :class="activeCategory === 'all' ? 'bg-slate-800 text-white' : ''">4</span>
                        </button>

                        <button @click="activeCategory = 'attendance'; activeFaq = null" type="button"
                                class="flex items-center justify-between px-4 py-3 rounded-xl border font-bold text-xs transition-all duration-200 cursor-pointer"
                                :class="activeCategory === 'attendance' 
                                    ? 'bg-brand-900 border-brand-900 text-white' 
                                    : 'bg-slate-50 border-slate-200/60 text-slate-700 hover:bg-slate-100'">
                            <span>Clock-In & Attendance</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-200 text-slate-800 font-extrabold"
                                  :class="activeCategory === 'attendance' ? 'bg-brand-850 text-white' : ''">1</span>
                        </button>

                        <button @click="activeCategory = 'payroll'; activeFaq = null" type="button"
                                class="flex items-center justify-between px-4 py-3 rounded-xl border font-bold text-xs transition-all duration-200 cursor-pointer"
                                :class="activeCategory === 'payroll' 
                                    ? 'bg-brand-900 border-brand-900 text-white' 
                                    : 'bg-slate-50 border-slate-200/60 text-slate-700 hover:bg-slate-100'">
                            <span>Payroll & Taxes</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-200 text-slate-800 font-extrabold"
                                  :class="activeCategory === 'payroll' ? 'bg-brand-850 text-white' : ''">1</span>
                        </button>

                        <button @click="activeCategory = 'security'; activeFaq = null" type="button"
                                class="flex items-center justify-between px-4 py-3 rounded-xl border font-bold text-xs transition-all duration-200 cursor-pointer"
                                :class="activeCategory === 'security' 
                                    ? 'bg-brand-900 border-brand-900 text-white' 
                                    : 'bg-slate-50 border-slate-200/60 text-slate-700 hover:bg-slate-100'">
                            <span>Security & Databases</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-200 text-slate-800 font-extrabold"
                                  :class="activeCategory === 'security' ? 'bg-brand-850 text-white' : ''">1</span>
                        </button>
                    </div>

                    <!-- Glowing Side CTA Helper Box -->
                    <div class="relative bg-slate-900 rounded-2xl border border-slate-800 p-6 text-white overflow-hidden shadow-lg select-none hidden lg:block">
                        <div class="absolute inset-0 bg-radial-glow opacity-25"></div>
                        <span class="relative text-[10px] font-bold text-brand-300 uppercase tracking-widest block mb-2">Have other concerns?</span>
                        <h4 class="relative text-sm font-bold font-display text-white mb-2">Need a custom contract or pricing scale?</h4>
                        <p class="relative text-[11px] text-slate-400 mb-5 leading-relaxed">Reach out directly to our operations team to custom configure your shifts, geo-coordinates, and audit permissions.</p>
                        <button @click="supportDrawerOpen = true" type="button" class="relative inline-flex w-full items-center justify-center py-2.5 rounded-lg bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 transition-colors cursor-pointer">
                            Contact Operations Support
                        </button>
                    </div>
                </div>

                <!-- Right Column: Accordions list with dynamic category filter -->
                <div class="lg:col-span-8 space-y-4 gsap-stagger-container">
                    <template x-for="faq in faqs" :key="faq.id">
                        <div x-show="shouldShow(faq)"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-3"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="gsap-stagger-item border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/20 backdrop-blur-xs transition-colors"
                             :class="activeFaq === faq.id ? 'bg-white border-brand-200 shadow-md' : 'hover:border-slate-350 hover:bg-white/40'">
                            
                            <button @click="activeFaq === faq.id ? activeFaq = null : activeFaq = faq.id" 
                                    class="w-full p-6 text-left font-bold text-slate-850 font-display flex items-center justify-between transition-colors cursor-pointer select-none">
                                <span class="text-sm sm:text-base pr-4" x-text="faq.question"></span>
                                <!-- Circular Indicator -->
                                <div class="w-7 h-7 rounded-full flex items-center justify-center transition-all duration-300"
                                     :class="activeFaq === faq.id ? 'bg-brand-50 text-brand-600' : 'bg-slate-100 text-slate-400'">
                                    <svg class="w-4 h-4 transform transition-transform duration-300" :class="activeFaq === faq.id ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>

                            <div x-show="activeFaq === faq.id"
                                 x-transition:enter="transition-all ease-out duration-250"
                                 x-transition:enter-start="opacity-0 max-h-0 overflow-hidden"
                                 x-transition:enter-end="opacity-100 max-h-48 overflow-hidden"
                                 x-transition:leave="transition-all ease-in duration-200"
                                 x-transition:leave-start="opacity-100 max-h-48 overflow-hidden"
                                 x-transition:leave-end="opacity-0 max-h-0 overflow-hidden">
                                <div class="p-6 pt-0 border-t border-slate-100/80 text-slate-650 text-sm leading-relaxed bg-white/70"
                                     x-text="faq.answer"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Interactive Demo Scheduler & System Status Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 pt-8 border-t border-slate-150 gsap-stagger-container">
                        <!-- Left Widget: Book a Demo Calendar -->
                        <div class="gsap-stagger-item bg-slate-50/60 rounded-2xl border border-slate-200/70 p-5 relative overflow-hidden shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-bold text-brand-600 uppercase tracking-wider bg-brand-50 px-2.5 py-1 rounded">Interactive Booking</span>
                                    <span class="text-xs text-slate-400 font-semibold">15 Min Call</span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800 font-display mb-1">Schedule Live Sandbox Tour</h4>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Select a day and slot to walk through customized geo-fencing, payroll rules, and direct deposits with our specialist.</p>
                            </div>
                            
                            <div x-show="!demoBookingSubmitted">
                                <!-- Day selector -->
                                <div class="grid grid-cols-5 gap-1.5 mb-3 text-center">
                                    <template x-for="day in ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']">
                                        <button @click="selectedDemoDay = day" type="button" 
                                                class="py-1.5 rounded-lg text-[10px] font-bold border transition-colors cursor-pointer"
                                                :class="selectedDemoDay === day ? 'bg-slate-900 border-slate-900 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                                            <span x-text="day"></span>
                                        </button>
                                    </template>
                                </div>
                                
                                <!-- Time slot selector -->
                                <div class="grid grid-cols-3 gap-1.5 mb-4 text-center">
                                    <template x-for="time in ['10:00 AM', '2:00 PM', '4:30 PM']">
                                        <button @click="selectedDemoTime = time" type="button"
                                                class="py-1.5 rounded-lg text-[9px] font-bold border transition-colors cursor-pointer"
                                                :class="selectedDemoTime === time ? 'bg-brand-600 border-brand-600 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                                            <span x-text="time"></span>
                                        </button>
                                    </template>
                                </div>

                                <div class="mb-4">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="email" required x-model="demoBookingEmail" :class="demoBookingError ? 'border-rose-500 focus:ring-rose-500/20 focus:border-rose-500' : 'border-slate-200 focus:ring-brand-500/20 focus:border-brand-500'" class="w-full pl-12! pr-3 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all" placeholder="Enter work email">
                                    </div>
                                    <span x-show="demoBookingError" x-text="demoBookingError" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>

                                <button @click="submitDemoBooking()" type="button" class="w-full py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-colors flex items-center justify-center gap-2 cursor-pointer">
                                    <template x-if="demoBookingLoading">
                                        <div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    </template>
                                    <span x-text="demoBookingLoading ? 'Securing slot...' : 'Confirm Walkthrough Slot'"></span>
                                </button>
                            </div>
                            
                            <!-- Success State -->
                            <div x-show="demoBookingSubmitted" style="display: none;" class="bg-emerald-50/70 border border-emerald-250 rounded-xl p-4 text-center flex flex-col items-center justify-center h-44 animate-fadeIn">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2">
                                    <span class="font-bold text-sm">✓</span>
                                </div>
                                <h5 class="text-xs font-bold text-emerald-800">Walkthrough Confirmed!</h5>
                                <p class="text-[10px] text-emerald-600 mt-1 max-w-xs">Calendar invitation has been dispatched to your email for <span class="font-bold" x-text="selectedDemoDay + ' at ' + selectedDemoTime"></span>.</p>
                            </div>
                        </div>

                        <!-- Right Widget: Uptime & API Status Board -->
                        <div class="gsap-stagger-item bg-slate-50/60 rounded-2xl border border-slate-200/70 p-5 relative overflow-hidden shadow-sm flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-2.5 py-1 rounded">Operations Center</span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span class="text-[10px] font-bold text-emerald-600 uppercase">Live Uptime</span>
                                    </div>
                                </div>
                                <h4 class="text-sm font-bold text-slate-800 font-display mb-1">API & Integration Center</h4>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Connect WorkNest core triggers directly to Slack webhooks, Zoom meetings, and custom employee record payloads.</p>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 rounded-xl bg-white border border-slate-200/50">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-extrabold text-slate-700">API Status</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-500">v1.4.2 (Stable)</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-2 rounded-xl bg-white border border-slate-200/50">
                                    <span class="text-xs font-extrabold text-slate-700">Daily Uptime</span>
                                    <span class="text-[10px] font-bold text-emerald-600">99.98% Operational</span>
                                </div>
                                
                                <button @click="sandboxModalOpen = true; sandboxTab = 'permissions'" type="button" class="w-full py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-750 font-bold text-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <span>Browse Sandbox API Tools</span>
                                    <span class="text-brand-500">→</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>