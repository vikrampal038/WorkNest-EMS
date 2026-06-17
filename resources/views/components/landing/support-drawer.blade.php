    <!-- 14. Custom Support & Enterprise Inquiry Sliding Drawer -->
    <div x-show="supportDrawerOpen" 
         class="fixed inset-0 z-50 overflow-hidden" 
         style="display: none;"
         x-description="Custom support inquiry sliding panel" 
         role="dialog" 
         aria-modal="true">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Background overlay -->
            <div x-show="supportDrawerOpen" 
                 x-transition:enter="ease-in-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in-out duration-300" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 @click="if (!supportLoading) supportDrawerOpen = false"
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" 
                 aria-hidden="true"></div>

            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <!-- Sliding panel -->
                <div x-show="supportDrawerOpen" 
                     x-transition:enter="transform transition ease-in-out duration-300 sm:duration-400" 
                     x-transition:enter-start="translate-x-full" 
                     x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transform transition ease-in-out duration-300 sm:duration-400" 
                     x-transition:leave-start="translate-x-0" 
                     x-transition:leave-end="translate-x-full" 
                     class="w-screen max-w-md bg-white shadow-2xl flex flex-col justify-between border-l border-slate-200">
                    
                    <div class="flex-1 h-0 overflow-y-auto p-6 sm:p-8 flex flex-col gap-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-brand-600 uppercase tracking-widest bg-brand-50 px-2 py-0.5 rounded w-max">Enterprise Support</span>
                                <h3 class="text-base font-extrabold text-slate-900 font-display mt-1">Configure Custom Contract</h3>
                            </div>
                            <button @click="supportDrawerOpen = false" :disabled="supportLoading" type="button" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg border border-transparent hover:border-slate-200 transition-all cursor-pointer">
                                <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Form / Loader / Success States Container -->
                        <div class="flex-1 flex flex-col justify-center">
                            
                            <!-- Case 1: Form entry -->
                            <div x-show="!supportLoading && !supportSubmitted" class="space-y-5">
                                <p class="text-xs text-slate-500 leading-relaxed">Fill out your organizational profile and shift limits. An operations officer will compile your custom tax/compliance contract.</p>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Full Name</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            </div>
                                            <input x-model="supportForm.name" type="text" placeholder="e.g. Elena Rostova" :class="supportErrors.name ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500'" class="w-full pl-12! pr-3.5 py-2.5 rounded-xl border focus:ring-1 text-xs font-semibold text-slate-800 bg-slate-50/50 outline-none transition-all shadow-sm">
                                        </div>
                                        <span x-show="supportErrors.name" x-text="supportErrors.name" class="text-[10px] text-red-500 font-semibold mt-1 block"></span>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Work Email</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            </div>
                                            <input x-model="supportForm.email" type="email" placeholder="e.g. elena@worknest.io" :class="supportErrors.email ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500'" class="w-full pl-12! pr-3.5 py-2.5 rounded-xl border focus:ring-1 text-xs font-semibold text-slate-800 bg-slate-50/50 outline-none transition-all shadow-sm">
                                        </div>
                                        <span x-show="supportErrors.email" x-text="supportErrors.email" class="text-[10px] text-red-500 font-semibold mt-1 block"></span>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Phone Number</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            </div>
                                            <input x-model="supportForm.phone" type="text" inputmode="numeric" maxlength="10" @input="supportForm.phone = supportForm.phone.replace(/[^0-9]/g, '')" placeholder="e.g. 9876543210" :class="supportErrors.phone ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500'" class="w-full pl-12! pr-3.5 py-2.5 rounded-xl border focus:ring-1 text-xs font-semibold text-slate-800 bg-slate-50/50 outline-none transition-all shadow-sm">
                                        </div>
                                        <span x-show="supportErrors.phone" x-text="supportErrors.phone" class="text-[10px] text-red-500 font-semibold mt-1 block"></span>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Inquiry Topic</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg>
                                            </div>
                                            <select x-model="supportForm.queryType" class="w-full pl-12! pr-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-brand-500 focus:ring-1 focus:ring-brand-500 text-xs font-semibold text-slate-800 bg-slate-50/50 outline-none transition-all shadow-sm appearance-none">
                                                <option value="enterprise">Custom Enterprise Pricing Scale</option>
                                                <option value="integration">Technical System Integrations (API)</option>
                                                <option value="compliance">Regional Compliance & Tax Audits</option>
                                                <option value="other">General Operations Question</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-[10.5px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Contract Requirements</label>
                                        <div class="relative">
                                            <div class="absolute top-3 left-0 pl-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            </div>
                                            <textarea x-model="supportForm.message" rows="4" placeholder="Detail your team size, custom geo-attendance coordinates, or required software triggers..." :class="supportErrors.message ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500'" class="w-full pl-12! pr-3.5 py-2.5 rounded-xl border focus:ring-1 text-xs font-semibold text-slate-800 bg-slate-50/50 outline-none transition-all resize-none shadow-sm"></textarea>
                                        </div>
                                        <span x-show="supportErrors.message" x-text="supportErrors.message" class="text-[10px] text-red-500 font-semibold mt-1 block"></span>
                                    </div>
                                </div>
                                
                                <button @click="submitSupportForm()" type="button" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors flex items-center justify-center gap-2 cursor-pointer shadow-md">
                                    <span>Submit Request to Operations</span>
                                </button>
                            </div>

                            <!-- Case 2: Stepped Loader -->
                            <div x-show="supportLoading" style="display: none;" class="flex flex-col items-center justify-center text-center p-8">
                                <div class="w-12 h-12 border-3 border-brand-100 border-t-brand-600 rounded-full animate-spin mb-4"></div>
                                <h4 class="text-xs font-bold text-slate-800">Processing Inquiry Ticket</h4>
                                <p class="text-[10.5px] text-slate-500 mt-1 max-w-xs" x-text="supportStepText"></p>
                            </div>

                            <!-- Case 3: Success State -->
                            <div x-show="supportSubmitted" style="display: none;" class="flex flex-col items-center justify-center text-center p-6 bg-emerald-50/50 border border-emerald-250 rounded-2xl animate-fadeIn">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3 shadow-sm">
                                    <span class="font-bold text-lg">✓</span>
                                </div>
                                <h4 class="text-sm font-extrabold text-slate-900">Custom Ticket Generated!</h4>
                                <p class="text-xs text-slate-555 mt-1.5 max-w-xs leading-relaxed">Your support request has been compiled. A representative has been assigned and will contact you at <span class="font-bold text-slate-800" x-text="supportForm.email"></span> in under 1 hour.</p>
                                <button @click="supportSubmitted = false; supportDrawerOpen = false; supportForm = { name: '', email: '', queryType: 'enterprise', message: '' }" type="button" class="mt-6 px-4 py-2 bg-slate-900 text-white font-bold text-[10.5px] rounded-xl hover:bg-slate-800 cursor-pointer shadow-sm transition-all">
                                    Close Panel
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>