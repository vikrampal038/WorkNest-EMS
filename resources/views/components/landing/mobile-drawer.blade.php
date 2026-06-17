        <!-- Mobile & Tablet Drawer -->
        <div class="lg:hidden px-4 sm:px-6 mt-0 relative z-40" 
             x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             @click.away="mobileMenuOpen = false" 
             style="display: none;">
            <div class="px-4 py-5 space-y-1 bg-white/95 backdrop-blur-xl border border-slate-200/80 shadow-2xl rounded-2xl">
                <a href="#features" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">Features</a>
                <a href="#why-us" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">Solutions</a>
                <a href="#dashboard-preview" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">Dashboard</a>
                <a href="#integrations" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">Integrations</a>
                <a href="#pricing" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">Pricing</a>
                <a href="#faq" @click="mobileMenuOpen = false" class="block px-4 py-3 rounded-xl text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">FAQ</a>
                <div class="pt-5 mt-2 border-t border-slate-100 flex flex-col gap-3 px-2">
                    <button @click="authModalOpen = true; authTab = 'signin'; mobileMenuOpen = false" type="button" class="w-full flex justify-center px-4 py-3.5 text-center text-[11px] sm:text-xs font-bold uppercase tracking-widest text-white bg-brand-600 rounded-xl shadow-md shadow-brand-500/20 hover:bg-brand-700 active:scale-[0.98] transition-all cursor-pointer">
                        Portal Access
                    </button>
                </div>
            </div>
        </div>
    </header>