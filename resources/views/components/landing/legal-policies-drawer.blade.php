    <!-- Legal Policies Slide-over Drawer Overlay -->
    <div x-show="legalDrawerOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-100 bg-slate-950/60 backdrop-blur-xs flex justify-end"
         style="display: none;"
         @keydown.escape.window="legalDrawerOpen = false">
         
        <!-- Slide-over Panel -->
        <div x-show="legalDrawerOpen"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             @click.away="legalDrawerOpen = false"
             class="w-full max-w-2xl bg-white/95 border-l border-slate-200/50 shadow-2xl h-full flex flex-col overflow-hidden relative backdrop-blur-xl">
             
            <!-- Drawer Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4 shrink-0 bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-650 flex items-center justify-center text-black font-bold text-base shadow-sm select-none">L</div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 font-display">Legal & Compliance Center</h3>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Platform Security & Policy Disclosures</span>
                    </div>
                </div>
                
                <button @click="legalDrawerOpen = false" type="button"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 cursor-pointer shadow-xs transition-colors"
                        aria-label="Close Drawer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Tabs -->
            <div class="px-6 py-3 border-b border-slate-100 bg-white shrink-0 select-none">
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none">
                    <button @click="activeLegalTab = 'privacy'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeLegalTab === 'privacy' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        Privacy Policy
                    </button>
                    <button @click="activeLegalTab = 'terms'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeLegalTab === 'terms' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        Terms of Service
                    </button>
                    <button @click="activeLegalTab = 'cookie'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeLegalTab === 'cookie' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        Cookie Policy
                    </button>
                    <button @click="activeLegalTab = 'dpa'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeLegalTab === 'dpa' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        Data Processing (DPA)
                    </button>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8 bg-white scrollbar-none">
                
                <!-- Tab 1: Privacy Policy -->
                <div x-show="activeLegalTab === 'privacy'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6">
                    <div>
                        <h4 class="text-lg font-bold text-slate-850 font-display">Privacy & Data Protection</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Learn how WorkNest securely handles your organization and employee data records.</p>
                    </div>

                    <div class="space-y-4 text-xs text-slate-600 leading-relaxed">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">1. Geolocation Tracking Boundaries</h5>
                            <p>Geolocation coordinates are captured strictly during check-in and check-out events to verify employee presence within the office radius boundary. We do not track location coordinates in the background or outside of active shift schedules.</p>
                        </div>
                        
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">2. Employee Information Isolation</h5>
                            <p>All sensitive information, including salary profiles, national ID registration numbers, and performance reviews, is stored in a dynamically isolated database segment. Individual tenant records are sealed off from cross-workspace exposure.</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">3. Third-Party Integrations</h5>
                            <p>Data payload triggers pushed to Slack webhooks, Zoom integration servers, or custom payroll API clients are filtered to send only required attributes. Complete employee profile details are never exposed to external webhooks without admin permissions.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Terms of Service -->
                <div x-show="activeLegalTab === 'terms'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6">
                    <div>
                        <h4 class="text-lg font-bold text-slate-850 font-display">Terms of Service</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Terms governing subscription licenses, module access, and platform fair-use policy.</p>
                    </div>

                    <div class="space-y-4 text-xs text-slate-600 leading-relaxed">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">1. Subscription License Grant</h5>
                            <p>WorkNest grants the subscribing organization a non-exclusive, non-transferable subscription license to deploy our employee management tools across their workforce. Access is limited to the active seats tier purchased.</p>
                        </div>
                        
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">2. Fair API & Sandbox Usage</h5>
                            <p>The Web Sandbox Playground and API endpoints are provided for testing purposes. Customers agree not to overload API endpoints or deploy automated scraping agents, which may result in temporary IP restrictions.</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">3. Billing, Cancellations & SLAs</h5>
                            <p>Billing is processed on a monthly/annual recurring cycle. Subscriptions can be canceled at any time from the account portal. WorkNest guarantees a 99.9% uptime SLA for core attendance and payroll triggers.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Cookie Policy -->
                <div x-show="activeLegalTab === 'cookie'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6">
                    <div>
                        <h4 class="text-lg font-bold text-slate-850 font-display">Cookie Policy</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Information on how we use cookies and tracking technologies to improve your experience.</p>
                    </div>

                    <div class="space-y-4 text-xs text-slate-600 leading-relaxed">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">1. Essential Operations Cookies</h5>
                            <p>WorkNest utilizes session cookies that are strictly necessary for core application functionalities. This includes authentication sessions, security token validation, and maintaining UI state across our dashboards.</p>
                        </div>
                        
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">2. Analytical Tracking</h5>
                            <p>With user consent, we deploy minimal tracking pixels to evaluate feature usage, page load metrics, and aggregated traffic patterns. This helps our engineering team optimize application performance.</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">3. Managing Preferences</h5>
                            <p>Administrators and employees have full control over non-essential tracking via their account settings. You can clear or block cookies directly from your browser, though this may disrupt portal access.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Data Processing Agreement -->
                <div x-show="activeLegalTab === 'dpa'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6">
                    <div>
                        <h4 class="text-lg font-bold text-slate-850 font-display">Data Processing Agreement (DPA)</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Terms governing the processing and protection of personal data under compliance laws.</p>
                    </div>

                    <div class="space-y-4 text-xs text-slate-600 leading-relaxed">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">1. Data Security & Sub-processors</h5>
                            <p>WorkNest commits to implementing robust technical measures (like AES-256 encryption) to protect personal data. We utilize authorized sub-processors (e.g., AWS, Stripe) who are bound by stringent confidentiality agreements.</p>
                        </div>
                        
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">2. Breach Notification Protocol</h5>
                            <p>In the unlikely event of a verified data breach, WorkNest will notify all affected Data Controllers within 48 hours. We maintain an actionable incident response plan to mitigate exposure immediately.</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/50">
                            <h5 class="font-bold text-slate-800 mb-1.5">3. Compliance & Audits</h5>
                            <p>Our DPA is compliant with global privacy frameworks including GDPR and CCPA. Customers have the right to request annual security audits or compliance attestations to verify our data handling procedures.</p>
                        </div>
                    </div>
                </div>

            </div> <!-- End Scrollable Content -->
        </div> <!-- End Slide-over Panel -->
    </div> <!-- End Legal Policies Slide-over Drawer Overlay -->