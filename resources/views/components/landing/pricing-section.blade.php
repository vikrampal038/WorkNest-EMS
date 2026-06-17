    <!-- 9. Pricing Section -->
    <section id="pricing" class="py-24 bg-site-bg" x-data="{ billingCycle: 'monthly' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-10 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-3 py-1.5 rounded-md">
                    SaaS Pricing Plans
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                    Clear pricing for companies of any scale
                </h2>
                <p class="text-slate-600">
                    Get started today. All plans include a 14-day free trial. No credit card required.
                </p>
            </div>

            <!-- Billing Toggle Switcher -->
            <div class="gsap-fade-up flex flex-wrap items-center justify-center gap-3 sm:gap-4 mb-16 select-none">
                <span class="text-xs sm:text-sm font-semibold" :class="billingCycle === 'monthly' ? 'text-slate-900' : 'text-slate-400'">Monthly Billing</span>
                <button @click="billingCycle = billingCycle === 'monthly' ? 'annual' : 'monthly'" 
                        type="button" 
                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-hidden"
                        :class="billingCycle === 'annual' ? 'bg-emerald-500' : 'bg-slate-200'">
                    <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-xs ring-0 transition duration-200 ease-in-out"
                          :class="billingCycle === 'annual' ? 'translate-x-5' : 'translate-x-0'"></span>
                </button>
                <span class="text-xs sm:text-sm font-semibold flex items-center gap-1.5" :class="billingCycle === 'annual' ? 'text-slate-900' : 'text-slate-400'">
                    Annual Billing
                    <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-250 whitespace-nowrap">Save 20%</span>
                </span>
            </div>

            <!-- Pricing Grid -->
            <div class="grid lg:grid-cols-3 gap-8 items-stretch gsap-stagger-container">
                
                <!-- Plan 1: Starter -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-slate-350 flex flex-col justify-between hover:shadow-xl transition-all duration-300">
                    <div>
                        <div class="mb-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Starter Plan</span>
                            <div class="flex items-baseline gap-1 mt-2">
                                <span class="text-4xl font-bold text-slate-900 font-display transition-all duration-200" x-text="billingCycle === 'monthly' ? '$29' : '$23'">$29</span>
                                <span class="text-slate-500 text-sm" x-text="billingCycle === 'monthly' ? '/ Month' : '/ Month (Billed Annually)'">/ Month</span>
                            </div>
                            <p class="text-slate-500 text-xs mt-2">Ideal for small growing startups.</p>
                        </div>
                        <hr class="border-slate-200 my-6">
                        <ul class="space-y-4 text-sm text-slate-600 mb-8">
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>Up to 15 Employees</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>Basic Attendance Clock-In</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>Leave Approvals Flow</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>PDF Salary Slip Downloads</span>
                            </li>
                        </ul>
                    </div>
                    <button @click="authModalOpen = true; authTab = 'signup'" type="button" class="w-full py-3.5 bg-white border border-slate-300 text-slate-700 font-bold text-sm text-center rounded-xl hover:bg-slate-50 transition-colors cursor-pointer">
                        Get Started
                    </button>
                </div>

                <!-- Plan 2: Professional (Highlighted!) -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-3xl bg-brand-900 text-white shadow-2xl shadow-brand-900/10 border-2 border-brand-500 flex flex-col justify-between relative hover:-translate-y-1 transition-transform duration-300">
                    
                    <span class="absolute -top-3.5 left-1/2 transform -translate-x-1/2 px-3 py-1 rounded-full bg-brand-500 text-white text-[10px] font-bold uppercase tracking-wider shadow">
                        Most Popular
                    </span>

                    <div>
                        <div class="mb-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-brand-300">Professional</span>
                            <div class="flex items-baseline gap-1 mt-2">
                                <span class="text-4xl font-bold text-white font-display transition-all duration-200" x-text="billingCycle === 'monthly' ? '$79' : '$63'">$79</span>
                                <span class="text-brand-300 text-sm" x-text="billingCycle === 'monthly' ? '/ Month' : '/ Month (Billed Annually)'">/ Month</span>
                            </div>
                            <p class="text-brand-200 text-xs mt-2">Best for small businesses and scaling offices.</p>
                        </div>
                        <hr class="border-brand-800 my-6">
                        <ul class="space-y-4 text-sm text-brand-200 mb-8">
                            <li class="flex items-center gap-3">
                                <span class="text-white font-bold">✓</span>
                                <span>Up to 100 Employees</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-white font-bold">✓</span>
                                <span>Advanced Geo-Fenced Clock-In</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-white font-bold">✓</span>
                                <span>Automated Payroll Core</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-white font-bold">✓</span>
                                <span>Slack & Google Calendar APIs</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-white font-bold">✓</span>
                                <span>Comprehensive Analytics Hub</span>
                            </li>
                        </ul>
                    </div>
                    <button @click="authModalOpen = true; authTab = 'signup'" type="button" class="w-full py-3.5 bg-brand-500 hover:bg-brand-600 text-white font-bold text-sm text-center rounded-xl shadow-lg transition-colors cursor-pointer">
                        Start 14-Day Trial
                    </button>
                </div>

                <!-- Plan 3: Enterprise -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200/70 hover:border-slate-350 flex flex-col justify-between hover:shadow-xl transition-all duration-300">
                    <div>
                        <div class="mb-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Enterprise</span>
                            <div class="flex items-baseline gap-1 mt-2">
                                <span class="text-4xl font-bold text-slate-900 font-display transition-all duration-200" x-text="billingCycle === 'monthly' ? '$199' : '$159'">$199</span>
                                <span class="text-slate-500 text-sm" x-text="billingCycle === 'monthly' ? '/ Month' : '/ Month (Billed Annually)'">/ Month</span>
                            </div>
                            <p class="text-slate-500 text-xs mt-2">Configured for larger enterprises and corporations.</p>
                        </div>
                        <hr class="border-slate-200 my-6">
                        <ul class="space-y-4 text-sm text-slate-600 mb-8">
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>Unlimited Employees</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>Dedicated Support Agent</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>Granular Role Permissions</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="text-brand-600 font-bold">✓</span>
                                <span>Custom Integration Endpoints</span>
                            </li>
                        </ul>
                    </div>
                    <button @click="supportDrawerOpen = true" type="button" class="w-full py-3.5 bg-white border border-slate-300 text-slate-700 font-bold text-sm text-center rounded-xl hover:bg-slate-50 transition-colors cursor-pointer">
                        Contact Sales
                    </button>
                </div>

            </div>

        </div>
    </section>