    <!-- 9. Unified Auth Modal Overlay (Sign In / Sign Up) -->
    <div x-show="authModalOpen" 
         class="fixed inset-0 z-100 flex items-center justify-center p-4 overflow-y-auto"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="authModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="authModalOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs"></div>

        <!-- Glass Container -->
        <div x-show="authModalOpen"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 scale-95 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-8"
             class="relative w-full max-w-5xl h-[85vh] md:h-155 bg-white shadow-2xl shadow-brand-900/20 rounded-4xl z-10 flex flex-col md:flex-row overflow-hidden border border-slate-200/60 p-2 sm:p-3 mx-4"
             @click.stop>
             
             <!-- Close Button (Mobile & Desktop) -->
             <button @click="authModalOpen = false" type="button" class="absolute top-5 right-5 text-slate-400 hover:text-slate-800 bg-white/50 hover:bg-slate-200/50 p-2 rounded-full transition-all z-50 cursor-pointer backdrop-blur-md border border-transparent hover:border-slate-200">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                 </svg>
             </button>

             <!-- Left Form Area -->
             <div class="w-full md:w-1/2 bg-white rounded-3xl shadow-[0_0_40px_rgba(0,0,0,0.02)] border border-slate-100 p-4 sm:p-6 lg:p-8 relative z-20 flex flex-col justify-center h-full overflow-hidden min-h-0">
                 
                 <div class="flex items-center gap-2 mb-4 justify-center">
                     <div class="w-8 h-8 bg-brand-600 rounded-xl flex items-center justify-center text-white font-bold font-display text-lg shadow-md shadow-brand-500/30">W</div>
                     <span class="text-xl font-black font-display tracking-tight text-slate-900">WorkNest</span>
                 </div>

                 <!-- State 1: Auth Forms (Not Loading/Submitted) -->
                 <div x-show="!authLoading && !authSubmitted" class="relative z-10 w-full max-w-sm mx-auto">
                     
                     <!-- Tab Switcher -->
                     <div class="flex p-1 mb-5 bg-slate-100 rounded-xl relative">
                         <!-- Sliding background indicator -->
                         <div class="absolute inset-y-1 w-[calc(50%-0.25rem)] bg-white rounded-lg shadow-sm border border-slate-200/50 transition-all duration-300 ease-out"
                              :class="authTab === 'signin' ? 'left-1' : 'translate-x-full left-1'"></div>
                         
                         <button @click="authTab = 'signin'" type="button" class="flex-1 relative z-10 py-2 text-xs font-bold rounded-lg transition-colors cursor-pointer" :class="authTab === 'signin' ? 'text-slate-900' : 'text-slate-500 hover:text-slate-700'">Sign In</button>
                         <button @click="authTab = 'signup'" type="button" class="flex-1 relative z-10 py-2 text-xs font-bold rounded-lg transition-colors cursor-pointer" :class="authTab === 'signup' ? 'text-slate-900' : 'text-slate-500 hover:text-slate-700'">Create Account</button>
                     </div>

                     <!-- Sign In Form -->
                     <div x-show="authTab === 'signin'" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                         <div class="text-center mb-4">
                             <h3 class="text-2xl font-bold font-display text-slate-900 tracking-tight">Welcome Back</h3>
                             <p class="text-xs text-slate-500 mt-1">Sign in to your admin workspace.</p>
                         </div>

                         <!-- Social SSO (SaaS grade) -->
                         <div class="flex flex-col gap-3 mb-4">
                             <button type="button" class="w-full flex items-center justify-center gap-3 px-4 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition-all text-xs font-bold text-slate-700 shadow-sm cursor-pointer group">
                                 <svg class="w-4 h-4 group-hover:scale-110 transition-transform" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                 Continue with Google
                             </button>
                         </div>

                         <div class="relative flex items-center mb-4">
                             <div class="grow border-t border-slate-200"></div>
                             <span class="shrink-0 px-4 text-[10px] uppercase font-bold text-slate-400">Or sign in with email</span>
                             <div class="grow border-t border-slate-200"></div>
                         </div>

                         <form @submit.prevent="submitSignIn()" class="space-y-4" novalidate>
                              <div>
                                  <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Work Email</label>
                                  <input type="email" required x-model="signInForm.email" :class="signInErrors.email ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-4 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="you@company.com">
                                  <span x-show="signInErrors.email" x-text="signInErrors.email ? signInErrors.email[0] : ''" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                              </div>

                              <div>
                                  <div class="flex items-center justify-between mb-1.5">
                                      <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Password</label>
                                      <a href="#" @click.prevent="authTab = 'forgot'" class="text-[10px] font-bold text-brand-600 hover:text-brand-700">Forgot password?</a>
                                  </div>
                                  <div class="relative">
                                      <input :type="showSignInPassword ? 'text' : 'password'" required x-model="signInForm.password" :class="signInErrors.password ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full pl-4 pr-10 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="Enter password">
                                      <button type="button" @click="showSignInPassword = !showSignInPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-655 cursor-pointer">
                                          <!-- Eye icon -->
                                          <svg x-show="!showSignInPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                          </svg>
                                          <!-- Eye-slash icon -->
                                          <svg x-show="showSignInPassword" style="display: none;" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.076m5.856-2.278A9.879 9.879 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-7-7l3-3m-6-2a3 3 0 00-3 3m0 0l-3 3" />
                                          </svg>
                                      </button>
                                  </div>
                                  <span x-show="signInErrors.password" x-text="signInErrors.password ? signInErrors.password[0] : ''" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                              </div>

                              <!-- Captcha Security Check -->
                              <div>
                                  <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 font-display">Security Verification</label>
                                  <div class="flex items-center gap-3">
                                      <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-2 flex items-center justify-center select-none font-mono font-black text-slate-705 tracking-wider shadow-inner text-xs skew-x-3 rotate-1">
                                          <span x-text="captchaNum1"></span>
                                          <span class="mx-1.5" x-text="captchaOperator"></span>
                                          <span x-text="captchaNum2"></span>
                                          <span class="ml-1.5">= ?</span>
                                      </div>
                                      <button type="button" @click="generateCaptcha()" class="p-2 border border-slate-200 hover:bg-slate-50 rounded-xl text-slate-400 hover:text-slate-600 transition-colors cursor-pointer" title="Refresh Captcha">
                                          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89" />
                                          </svg>
                                      </button>
                                      <input type="text" inputmode="numeric" required x-model="captchaInput" :class="captchaError ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="grow px-3 py-2 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="Answer">
                                  </div>
                                  <span x-show="captchaError" x-text="captchaError" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                              </div>

                              <div class="pt-2">
                                  <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-all cursor-pointer shadow-md hover:shadow-xl hover:-translate-y-0.5">
                                      Sign In
                                  </button>
                              </div>
                          </form>
                     </div>

                     <!-- Sign Up Form -->
                     <div x-show="authTab === 'signup'" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                          <div class="text-center mb-4">
                              <h3 class="text-2xl font-bold font-display text-slate-900 tracking-tight">Create Account</h3>
                              <p class="text-xs text-slate-500 mt-1">Start your 14-day free trial.</p>
                          </div>
                          
                          <form @submit.prevent="submitSignUp()" class="space-y-4" novalidate>
                              <div class="grid grid-cols-2 gap-4">
                                  <div>
                                      <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Full Name</label>
                                      <input type="text" required x-model="signUpForm.name" @input="signUpForm.name = signUpForm.name.replace(/[^a-zA-Z\s]/g, '')" :class="signUpErrors.name ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-4 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="John Doe">
                                      <span x-show="signUpErrors.name" x-text="signUpErrors.name ? signUpErrors.name[0] : ''" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                                  </div>
                                  <div>
                                      <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Company</label>
                                      <input type="text" required x-model="signUpForm.company" :class="signUpErrors.company ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-4 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="Acme Inc">
                                      <span x-show="signUpErrors.company" x-text="signUpErrors.company ? signUpErrors.company[0] : ''" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                                  </div>
                              </div>

                              <div>
                                  <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Work Email</label>
                                  <input type="email" required x-model="signUpForm.email" :class="signUpErrors.email ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-4 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="you@company.com">
                                  <span x-show="signUpErrors.email" x-text="signUpErrors.email ? signUpErrors.email[0] : ''" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                              </div>

                              <div>
                                  <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Phone Number</label>
                                  <input type="text" inputmode="numeric" maxlength="10" required x-model="signUpForm.phone" @input="signUpForm.phone = signUpForm.phone.replace(/[^0-9]/g, '')" :class="signUpErrors.phone ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-4 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="10-digit number">
                                  <span x-show="signUpErrors.phone" x-text="signUpErrors.phone ? signUpErrors.phone[0] : ''" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                              </div>

                              <div>
                                  <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Password</label>
                                  <div class="relative">
                                      <input :type="showSignUpPassword ? 'text' : 'password'" required x-model="signUpForm.password" :class="signUpErrors.password ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full pl-4 pr-10 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="Min. 8 characters">
                                      <button type="button" @click="showSignUpPassword = !showSignUpPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-655 cursor-pointer">
                                          <!-- Eye icon -->
                                          <svg x-show="!showSignUpPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                          </svg>
                                          <!-- Eye-slash icon -->
                                          <svg x-show="showSignUpPassword" style="display: none;" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.076m5.856-2.278A9.879 9.879 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-7-7l3-3m-6-2a3 3 0 00-3 3m0 0l-3 3" />
                                          </svg>
                                      </button>
                                  </div>
                                  <span x-show="signUpErrors.password" x-text="signUpErrors.password ? signUpErrors.password[0] : ''" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                              </div>

                              <div class="pt-2">
                                  <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 shadow-md shadow-brand-500/20 hover:shadow-xl hover:shadow-brand-500/30 hover:-translate-y-0.5 transition-all cursor-pointer">
                                      Activate Free Trial
                                  </button>
                              </div>
                          </form>
                         
                         <p class="text-[10px] text-slate-400 text-center mt-5">
                             By continuing, you agree to our <a href="#" class="font-bold hover:text-brand-600">Terms</a> & <a href="#" class="font-bold hover:text-brand-600">Privacy Policy</a>.
                         </p>
                     </div>
                 </div>

                  <!-- Forgot Password Form -->
                  <div x-show="authTab === 'forgot'" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;" class="relative z-10 w-full max-w-sm mx-auto">
                      <div class="text-center mb-4">
                          <h3 class="text-2xl font-bold font-display text-slate-900 tracking-tight">Reset Password</h3>
                          <p class="text-xs text-slate-500 mt-1">Enter your email and we'll send a password recovery link.</p>
                      </div>

                      <div x-show="!forgotSubmitted && !forgotLoading">
                          <form @submit.prevent="submitForgotPassword()" class="space-y-4" novalidate>
                              <div>
                                  <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Work Email</label>
                                  <input type="email" required x-model="forgotEmail" :class="forgotErrors.email ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20'" class="w-full px-4 py-2.5 rounded-xl border bg-white text-xs focus:ring-2 focus:outline-hidden transition-all shadow-sm" placeholder="you@company.com">
                                  <span x-show="forgotErrors.email" x-text="forgotErrors.email" class="text-[10px] text-rose-500 font-semibold mt-1 block"></span>
                              </div>

                              <div class="pt-2 flex flex-col gap-3">
                                  <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-all cursor-pointer shadow-md hover:shadow-xl hover:-translate-y-0.5">
                                      Send Recovery Link
                                  </button>
                                  <button type="button" @click="authTab = 'signin'" class="text-[11px] font-bold text-slate-500 hover:text-slate-700 text-center py-1 cursor-pointer">
                                      Back to Sign In
                                  </button>
                              </div>
                          </form>
                      </div>

                      <div x-show="forgotSubmitted && !forgotLoading" class="text-center py-4">
                          <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-250 flex items-center justify-center text-emerald-500 mx-auto mb-4 shadow-sm">
                              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                          </div>
                          <h4 class="text-sm font-bold text-slate-855">Recovery Link Dispatched!</h4>
                          <p class="text-xs text-slate-500 mt-2 max-w-xs mx-auto leading-relaxed">We have transmitted a secure reset token link to <span class="font-bold text-slate-700" x-text="forgotEmail"></span>. Please check your inbox.</p>
                          <button @click="forgotSubmitted = false; forgotEmail = ''; authTab = 'signin'" class="mt-6 px-4 py-2 bg-slate-950 text-white text-[10px] font-bold rounded-xl hover:bg-slate-800 cursor-pointer shadow-sm">
                              Back to Sign In
                          </button>
                      </div>
                  </div>

                  <!-- State 6: Forgot Password Loading -->
                  <div x-show="forgotLoading && authTab === 'forgot'" class="py-12 flex flex-col items-center justify-center text-center w-full">
                      <div class="relative w-16 h-16 mb-8 flex items-center justify-center">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400/30 opacity-75"></span>
                          <span class="animate-pulse absolute inline-flex h-12 w-12 rounded-full bg-brand-500/20"></span>
                          <div class="relative w-8 h-8 rounded-full border-2 border-brand-600 border-t-transparent animate-spin"></div>
                      </div>
                      <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Processing Reset Request</h4>
                      <p x-text="forgotStepText" class="text-xs text-slate-500 mt-2 font-mono h-8 flex items-center justify-center leading-relaxed"></p>
                  </div>

                 <!-- State 2: Sign In Loading -->
                 <div x-show="authLoading && authTab === 'signin'" class="py-12 flex flex-col items-center justify-center text-center">
                     <div class="relative w-16 h-16 mb-8 flex items-center justify-center">
                         <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400/30 opacity-75"></span>
                         <span class="animate-pulse absolute inline-flex h-12 w-12 rounded-full bg-brand-500/20"></span>
                         <div class="relative w-8 h-8 rounded-full border-2 border-brand-600 border-t-transparent animate-spin"></div>
                     </div>
                     <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Authenticating Session</h4>
                     <p x-text="authStepText" class="text-xs text-slate-500 mt-2 font-mono h-8 flex items-center justify-center leading-relaxed"></p>
                 </div>

                 <!-- State 3: Sign In Success -->
                 <div x-show="authSubmitted && authTab === 'signin'" class="py-8 text-center flex flex-col items-center justify-center">
                     <div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-500 mb-5 shadow-sm">
                         <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                     </div>
                     <h3 class="text-xl font-bold font-display text-slate-900 tracking-tight">Welcome back!</h3>
                     <p class="text-xs text-slate-500 mt-2 max-w-xs leading-relaxed">Authentication successful. Redirecting to your dashboard.</p>
                     <div class="mt-6 flex items-center gap-2 text-[10.5px] font-bold text-brand-600 font-mono">
                         <span>Redirecting now</span>
                         <span class="flex gap-0.5">
                             <span class="animate-bounce">.</span>
                             <span class="animate-bounce" style="animation-delay: 0.2s;">.</span>
                             <span class="animate-bounce" style="animation-delay: 0.4s;">.</span>
                         </span>
                     </div>
                 </div>

                 <!-- State 4: Sign Up Loading -->
                 <div x-show="authLoading && authTab === 'signup'" class="py-12 flex flex-col items-center justify-center text-center">
                     <div class="relative w-16 h-16 mb-8 flex items-center justify-center">
                         <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400/30 opacity-75"></span>
                         <span class="animate-pulse absolute inline-flex h-12 w-12 rounded-full bg-brand-500/20"></span>
                         <div class="relative w-8 h-8 rounded-full border-2 border-brand-600 border-t-transparent animate-spin"></div>
                     </div>
                     <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Setting up workspace</h4>
                     <p x-text="authStepText" class="text-xs text-slate-500 mt-2 font-mono h-8 flex items-center justify-center leading-relaxed"></p>
                 </div>

                 <!-- State 5: Sign Up Success -->
                 <div x-show="authSubmitted && authTab === 'signup'" class="py-8 text-center flex flex-col items-center justify-center">
                     <div class="w-14 h-14 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-500 mb-5 shadow-sm">
                         <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                     </div>
                     <h3 class="text-xl font-bold font-display text-slate-900 tracking-tight">Workspace is ready!</h3>
                     <p class="text-xs text-slate-500 mt-2 max-w-xs leading-relaxed">Account successfully created. We are redirecting you to your admin dashboard.</p>
                     <div class="mt-6 flex items-center gap-2 text-[10.5px] font-bold text-brand-600 font-mono">
                         <span>Redirecting now</span>
                         <span class="flex gap-0.5">
                             <span class="animate-bounce">.</span>
                             <span class="animate-bounce" style="animation-delay: 0.2s;">.</span>
                             <span class="animate-bounce" style="animation-delay: 0.4s;">.</span>
                         </span>
                     </div>
                 </div>
             </div>

             <!-- Right Visual Area (High-Fidelity Dashboard visual) -->
             <div class="hidden md:flex w-full md:w-1/2 flex-col items-center justify-start pt-12 pb-0 px-8 relative overflow-hidden bg-white border-l border-slate-100 rounded-r-4xl h-full">
                 
                 <!-- Glows -->
                 <div class="absolute top-0 right-0 w-96 h-96 bg-brand-400/10 rounded-full blur-[80px] -z-10 pointer-events-none"></div>
                 <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-400/10 rounded-full blur-[60px] -z-10 pointer-events-none"></div>

                 <!-- Text Header -->
                 <div class="text-center z-10 relative shrink-0">
                     <h2 class="text-3xl lg:text-4xl font-black font-display text-slate-900 tracking-tight leading-tight">
                         Your Complete<br>HR Command Center.
                     </h2>
                     <p class="text-slate-500 mt-3 max-w-sm mx-auto text-xs font-medium leading-relaxed">
                         Scale your team gracefully with automated payrolls, smart attendance tracking, and actionable analytics.
                     </p>
                 </div>

                 <!-- 3D HR Manager Illustration (Generated unique asset) -->
                 <div class="relative w-full max-w-sm z-10 flex-1 mt-4 flex flex-col justify-center items-center">
                     <img src="{{ asset('assets/auth_hero_3d_model.png') }}" class="w-full h-auto object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-700 mix-blend-darken" style="-webkit-mask-image: linear-gradient(to bottom, black 85%, transparent 100%); mask-image: linear-gradient(to bottom, black 85%, transparent 100%);" alt="WorkNest HR Manager">
                     
                     <!-- Floating Badge -->
                     <div class="absolute -left-4 top-14 bg-brand-600 p-2.5 rounded-lg shadow-lg border border-brand-500 z-20 hover:-translate-y-1 transition-transform transform -rotate-6">
                         <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                     </div>
                 </div>
             </div>

        </div>
    </div>


    <!-- Legal Policies -->