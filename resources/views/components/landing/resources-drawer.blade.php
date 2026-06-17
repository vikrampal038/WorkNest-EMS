    <!-- Resources Slide-over Drawer Overlay (Control Panel Slider) -->
    <div x-show="resourcesDrawerOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-100 bg-slate-950/60 backdrop-blur-xs flex justify-end"
         style="display: none;"
         @keydown.escape.window="resourcesDrawerOpen = false">
         
        <!-- Slide-over Panel -->
        <div x-show="resourcesDrawerOpen"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             @click.away="resourcesDrawerOpen = false"
             class="w-full max-w-2xl bg-white/95 border-l border-slate-200/50 shadow-2xl h-full flex flex-col overflow-hidden relative backdrop-blur-xl">
             
            <!-- Drawer Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between gap-4 shrink-0 bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-650 flex items-center justify-center text-black font-bold text-base shadow-sm select-none">R</div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 font-display">Resources & DevHub</h3>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Operational & Dev Guides</span>
                    </div>
                </div>
                
                <button @click="resourcesDrawerOpen = false" type="button"
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
                    <button @click="activeResourcesTab = 'support'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeResourcesTab === 'support' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        Support Center
                    </button>
                    <button @click="activeResourcesTab = 'api'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeResourcesTab === 'api' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        API Docs
                    </button>
                    <button @click="activeResourcesTab = 'guides'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeResourcesTab === 'guides' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        HR Guides
                    </button>
                    <button @click="activeResourcesTab = 'security'" type="button"
                            class="px-4 py-2 rounded-lg font-bold text-xs transition-all duration-200 shrink-0 cursor-pointer"
                            :class="activeResourcesTab === 'security' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-800'">
                        SaaS Security
                    </button>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-8 bg-white scrollbar-none">
                       <div x-show="activeResourcesTab === 'support'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;">
                      <div class="flex flex-col gap-6"
                           x-data="{ 
                               ticketSubmitted: false, 
                               ticket: { name: '', email: '', phone: '', category: 'technical', severity: 'medium', desc: '' },
                               ticketErrors: {},
                               submitTicket() {
                              this.ticketErrors = {};
                              let hasErrors = false;
                              
                              if (!this.ticket.name) {
                                  this.ticketErrors.name = 'Name is required';
                                  hasErrors = true;
                              } else if (!/^[A-Za-z\s]{2,50}$/.test(this.ticket.name)) {
                                  this.ticketErrors.name = 'Please enter letters and spaces only';
                                  hasErrors = true;
                              }
                              
                              if (!this.ticket.email) {
                                  this.ticketErrors.email = 'Email is required';
                                  hasErrors = true;
                              } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.ticket.email)) {
                                  this.ticketErrors.email = 'Please enter a valid email address';
                                  hasErrors = true;
                              }
                              
                              if (!this.ticket.phone) {
                                  this.ticketErrors.phone = 'Phone number is required';
                                  hasErrors = true;
                              } else if (!/^\d{10}$/.test(this.ticket.phone)) {
                                  this.ticketErrors.phone = 'Must be exactly 10 digits';
                                  hasErrors = true;
                              }
                              
                              if (!this.ticket.desc) {
                                  this.ticketErrors.desc = 'Description is required';
                                  hasErrors = true;
                              }
                              
                              if (hasErrors) return;
                              this.ticketSubmitted = true;
                          }
                      }">
                     
                    <div x-show="!ticketSubmitted" class="flex flex-col gap-6">
                        <div>
                            <h4 class="text-lg font-bold text-slate-850 font-display">Customer Operations Support</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Search resources or register a live support ticket with our engineering desk.</p>
                        </div>

                        <!-- FAQ Help Search Bar mock -->
                        <div class="relative">
                            <input type="text" class="w-full pl-12! pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:outline-hidden" placeholder="Search support articles, logs, tutorials...">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <!-- Support Ticket Form -->
                        <div class="p-5 rounded-2xl border border-slate-200/80 bg-white">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-4">Register Support Ticket</span>
                            
                            <form @submit.prevent="submitTicket()" class="space-y-4" novalidate>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1">Full Name</label>
                                        <input type="text" required x-model="ticket.name" :class="ticketErrors.name ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-3 py-2.5 rounded-xl border text-xs focus:ring-2 focus:outline-hidden" placeholder="Your Name">
                                        <span x-show="ticketErrors.name" x-text="ticketErrors.name" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                    </div>
                                    <div>
                                        <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email Address</label>
                                        <input type="email" required x-model="ticket.email" :class="ticketErrors.email ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-3 py-2.5 rounded-xl border text-xs focus:ring-2 focus:outline-hidden" placeholder="Email">
                                        <span x-show="ticketErrors.email" x-text="ticketErrors.email" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                    </div>
                                    <div>
                                        <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1">Phone Number</label>
                                        <input type="text" inputmode="numeric" maxlength="10" required x-model="ticket.phone" @input="ticket.phone = ticket.phone.replace(/[^0-9]/g, '')" :class="ticketErrors.phone ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-3 py-2.5 rounded-xl border text-xs focus:ring-2 focus:outline-hidden" placeholder="Phone">
                                        <span x-show="ticketErrors.phone" x-text="ticketErrors.phone" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1">Category</label>
                                        <select x-model="ticket.category" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:outline-hidden bg-white">
                                            <option value="technical">Technical Glitch</option>
                                            <option value="billing">Billing & Pricing</option>
                                            <option value="account">Account Access</option>
                                            <option value="integration">API & Integrations</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1">Severity Level</label>
                                        <select x-model="ticket.severity" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:outline-hidden bg-white">
                                            <option value="low">Low (General Query)</option>
                                            <option value="medium">Medium (Impedes Work)</option>
                                            <option value="high">High (Production Block)</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1">Describe Issue</label>
                                    <textarea required rows="4" x-model="ticket.desc" :class="ticketErrors.desc ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-3 py-2.5 rounded-xl border text-xs focus:ring-2 focus:outline-hidden" placeholder="Include error logs, browser version, and description of expected outcomes..."></textarea>
                                    <span x-show="ticketErrors.desc" x-text="ticketErrors.desc" class="text-[9px] text-rose-500 font-semibold mt-1 block"></span>
                                </div>
                                <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-xs transition-colors cursor-pointer">
                                    File Operations Ticket
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Ticket success state -->
                    <div x-show="ticketSubmitted"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="p-8 text-center bg-slate-50 border border-slate-200/60 rounded-2xl flex flex-col items-center justify-center"
                         style="display: none;">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-250 flex items-center justify-center text-emerald-500 mb-4 shadow-sm">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Ticket Successfully Filed!</h4>
                        <p class="text-xs text-slate-500 mt-2 max-w-sm leading-relaxed">
                            Your support ticket has been registered in our central desk. A technical lead will verify details and reach out within 2 hours.
                        </p>
                        <button @click="ticketSubmitted = false" type="button" class="mt-6 px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl cursor-pointer">
                            Back to Support Desk
                        </button>
                    </div>
                </div>
            </div>

                <div x-show="activeResourcesTab === 'api'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;">
                    <div class="flex flex-col gap-6"
                         x-data="{ 
                             apiLang: 'curl',
                             copied: false,
                             codes: {
                            curl: `curl -X GET https://api.worknest.io/v1/employees \\
  -H 'Authorization: Bearer WN_SEC_KEY_8f23' \\
  -H 'Content-Type: application/json'`,
                            js: `fetch('https://api.worknest.io/v1/employees', {
  headers: {
    'Authorization': 'Bearer WN_SEC_KEY_8f23',
    'Content-Type': 'application/json'
  }
})
.then(res => res.json())
.then(data => console.log(data));`,
                            php: `$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.worknest.io/v1/employees');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Authorization: Bearer WN_SEC_KEY_8f23',
  'Content-Type: application/json'
]);
$res = curl_exec($ch);
curl_close($ch);`
                        },
                        triggerCopy() {
                            navigator.clipboard.writeText(this.codes[this.apiLang]);
                            this.copied = true;
                            setTimeout(() => { this.copied = false; }, 2000);
                        }
                    }">
                    <div>
                        <h4 class="text-lg font-bold text-slate-850 font-display">Developer API Reference</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Integrate WorkNest databases directly with your internal dashboards and HR tooling.</p>
                    </div>

                    <!-- Endpoints list -->
                    <div class="flex flex-col gap-2.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Authentication Key</span>
                        <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-center justify-between gap-4 text-xs">
                            <span class="font-mono text-slate-500 select-all">WN_SEC_KEY_8f23••••••••••••••••</span>
                            <span class="px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-200 text-indigo-750 text-[9px] font-bold">Active</span>
                        </div>
                    </div>

                    <!-- Interactive Code Console -->
                    <div class="rounded-2xl border border-slate-800 bg-slate-900 text-white overflow-hidden shadow-lg">
                        <!-- Code Console Header -->
                        <div class="bg-slate-950 px-4 py-3 border-b border-slate-800 flex items-center justify-between gap-4 select-none">
                            <div class="flex items-center gap-1.5">
                                <button @click="apiLang = 'curl'" type="button" class="text-[10px] font-bold px-2 py-1 rounded-md transition-colors" :class="apiLang === 'curl' ? 'bg-slate-800 text-white' : 'text-slate-500 hover:text-slate-350'">cURL</button>
                                <button @click="apiLang = 'js'" type="button" class="text-[10px] font-bold px-2 py-1 rounded-md transition-colors" :class="apiLang === 'js' ? 'bg-slate-800 text-white' : 'text-slate-500 hover:text-slate-350'">JavaScript</button>
                                <button @click="apiLang = 'php'" type="button" class="text-[10px] font-bold px-2 py-1 rounded-md transition-colors" :class="apiLang === 'php' ? 'bg-slate-800 text-white' : 'text-slate-500 hover:text-slate-350'">PHP</button>
                            </div>
                            
                            <button @click="triggerCopy" type="button" class="inline-flex items-center gap-1 text-[9.5px] font-bold text-slate-450 hover:text-white cursor-pointer transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 00-2 2v12" />
                                </svg>
                                <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                            </button>
                        </div>
                        
                        <!-- Code view pane -->
                        <div class="p-5 overflow-x-auto font-mono text-xs text-indigo-300 leading-relaxed">
                            <pre><code x-text="codes[apiLang]"></code></pre>
                        </div>
                    </div>

                    <!-- API Response Preview -->
                    <div class="flex flex-col gap-2.5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Expected JSON Response (200 OK)</span>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 font-mono text-[10.5px] text-slate-650 overflow-x-auto leading-relaxed">
                            <pre><code>{
  "status": "success",
  "data": [
    {
      "id": "emp_019",
      "name": "Jane Cooper",
      "department": "Operations",
      "email": "jane.c@acme.io",
      "joined_date": "2024-03-12"
    }
  ]
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

                <div x-show="activeResourcesTab === 'guides'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display: none;">
                    <div class="flex flex-col gap-6"
                         x-data="{ 
                             downloads: { compliance: 342, attendance: 201, payroll: 512 },
                         triggerDownload(type) {
                             this.downloads[type]++;
                         }
                     }">
                    <div>
                        <h4 class="text-lg font-bold text-slate-850 font-display">Operational Guides & Checklists</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Free operational kits and manuals compiled by seasoned HR managers.</p>
                    </div>

                    <div class="flex flex-col gap-4">
                        
                        <!-- Guide 1 -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-white hover:border-brand-200 hover:shadow-xs transition-all duration-300 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-650 font-black text-sm">PDF</div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 text-xs">2026 SaaS Compliance Audit Blueprint</span>
                                    <span class="text-[10px] text-slate-450 mt-0.5" x-text="downloads.compliance + ' downloads • File size: 2.4 MB'"></span>
                                </div>
                            </div>
                            <button @click="triggerDownload('compliance')" type="button" class="px-3.5 py-2 bg-slate-50 border border-slate-250 text-slate-700 hover:bg-slate-100 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                Download
                            </button>
                        </div>

                        <!-- Guide 2 -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-white hover:border-brand-200 hover:shadow-xs transition-all duration-300 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-650 font-black text-sm">PDF</div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 text-xs">Hybrid Shift Management & Scheduling Guide</span>
                                    <span class="text-[10px] text-slate-450 mt-0.5" x-text="downloads.attendance + ' downloads • File size: 1.8 MB'"></span>
                                </div>
                            </div>
                            <button @click="triggerDownload('attendance')" type="button" class="px-3.5 py-2 bg-slate-50 border border-slate-250 text-slate-700 hover:bg-slate-100 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                Download
                            </button>
                        </div>

                        <!-- Guide 3 -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-white hover:border-brand-200 hover:shadow-xs transition-all duration-300 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-650 font-black text-sm">PDF</div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 text-xs">Manual Payroll to Automated Core Migration Guide</span>
                                    <span class="text-[10px] text-slate-450 mt-0.5" x-text="downloads.payroll + ' downloads • File size: 3.1 MB'"></span>
                                </div>
                            </div>
                            <button @click="triggerDownload('payroll')" type="button" class="px-3.5 py-2 bg-slate-50 border border-slate-250 text-slate-700 hover:bg-slate-100 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                Download
                            </button>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Tab 4: SaaS Security -->
                <div x-show="activeResourcesTab === 'security'"
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col gap-6"
                     style="display: none;">
                    <div>
                        <h4 class="text-lg font-bold text-slate-850 font-display">Security-First Compliance</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Our hosting systems and database servers are locked under bank-grade security protocols.</p>
                    </div>

                    <!-- Security highlights checklist -->
                    <div class="flex flex-col gap-3.5">
                        
                        <div class="p-4 rounded-xl border border-slate-150 bg-slate-50/50 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-6.5 h-6.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">✓</div>
                                <span class="font-bold text-slate-800 text-xs">SOC-2 Type II Certified Hostings</span>
                            </div>
                            <a href="#" class="text-[10.5px] text-indigo-600 font-bold hover:underline">Download Audit Report</a>
                        </div>

                        <div class="p-4 rounded-xl border border-slate-150 bg-slate-50/50 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-6.5 h-6.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">✓</div>
                                <span class="font-bold text-slate-800 text-xs">GDPR Database Audited & Compliant</span>
                            </div>
                            <a href="#" class="text-[10.5px] text-indigo-600 font-bold hover:underline">Read Privacy Rules</a>
                        </div>

                        <div class="p-4 rounded-xl border border-slate-150 bg-slate-50/50 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold">✓</div>
                                <span class="font-bold text-slate-800 text-xs">AES-256 Rest and TLS-1.3 Transit Encryption</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-bold font-display">Enforced</span>
                        </div>
                    </div>
                </div>

            </div> <!-- End Scrollable Content -->
        </div> <!-- End Slide-over Panel -->
    </div> <!-- End Resources Slide-over Drawer Overlay -->