    <!-- 12. Final CTA Banner -->
    <section class="py-20 bg-site-bg-alt">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="gsap-fade-up relative rounded-3xl bg-brand-900 overflow-hidden shadow-2xl p-12 sm:p-16 flex flex-col items-center justify-center text-center">
                <!-- Radial Glow SVG inside Card -->
                <div class="absolute inset-0 bg-radial-glow opacity-30 pointer-events-none"></div>

                <span class="relative text-brand-300 text-xs font-bold uppercase tracking-widest mb-4">
                    Ready to modernize?
                </span>

                <h2 class="relative text-3xl sm:text-5xl font-bold font-display text-white tracking-tight leading-tight max-w-2xl mb-6">
                    Transform your workplace culture today.
                </h2>

                <p class="relative text-brand-200 text-base max-w-lg mb-10 leading-relaxed">
                    Unify employee directories, automate timesheet calculations, audit leave balances, and run direct-deposit payroll.
                </p>

                <div class="relative flex flex-col sm:flex-row gap-4 w-full justify-center">
                    <button @click="authModalOpen = true; authTab = 'signup'" type="button" class="px-8 py-4 bg-white text-brand-900 font-bold rounded-2xl hover:bg-slate-100 hover:scale-[1.01] transition-all text-sm cursor-pointer">
                        Start Free Trial
                    </button>
                    <button @click="supportDrawerOpen = true" type="button" class="px-8 py-4 bg-brand-800 text-white border border-brand-700 font-bold rounded-2xl hover:bg-brand-700 hover:scale-[1.01] transition-all text-sm cursor-pointer">
                        Talk to Sales
                    </button>
                </div>
                
                <span class="relative text-brand-300 text-xs mt-6">
                    No setup fees • Cancel anytime • 14-day trial evaluation
                </span>
            </div>
        </div>
    </section>