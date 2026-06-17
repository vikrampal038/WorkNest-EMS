@extends('layouts.landing')

@section('content')
<div @scroll.window="
    let currentScroll = window.pageYOffset;
    if (currentScroll > lastScroll) scrollDirection = 'down';
    else if (currentScroll < lastScroll) scrollDirection = 'up';
    lastScroll = currentScroll;
    showScrollTop = (currentScroll > 800);
" x-data="{ 
    showScrollTop: false,
    lastScroll: 0,
    scrollDirection: 'down',
    mobileMenuOpen: false,
    companyHubOpen: false,
    activeHubTab: 'about',
    resourcesDrawerOpen: false,
    activeResourcesTab: 'support',

    // Legal Drawer States
    legalDrawerOpen: false,
    activeLegalTab: 'privacy',

    // Global Toast Notification State
    toast: { show: false, type: 'success', message: '', description: '' },
    showToast(type, message, description = '') {
        this.toast.type = type;
        this.toast.message = message;
        this.toast.description = description;
        this.toast.show = true;
        setTimeout(() => {
            this.toast.show = false;
        }, 5000);
    },

    // Unified Auth Modal States
    authModalOpen: false,
    authTab: 'signin', // 'signin' or 'signup' or 'forgot'
    authLoading: false,
    authSubmitted: false,
    authStepText: 'Verifying credentials...',
    signInForm: { email: '', password: '' },
    signInErrors: {},
    signUpForm: { name: '', email: '', phone: '', password: '', company: '' },
    signUpErrors: {},

    // Show/Hide Password states
    showSignInPassword: false,
    showSignUpPassword: false,

    // Forgot Password Flow States
    forgotEmail: '',
    forgotErrors: {},
    forgotLoading: false,
    forgotSubmitted: false,
    forgotStepText: 'Searching user database...',

    // Security Captcha States
    captchaNum1: 0,
    captchaNum2: 0,
    captchaOperator: '+',
    captchaAnswer: 0,
    captchaInput: '',
    captchaError: '',
    
    generateCaptcha() {
        const operators = ['+', '-'];
        this.captchaNum1 = Math.floor(Math.random() * 10) + 5; // 5 to 14
        this.captchaNum2 = Math.floor(Math.random() * 10) + 1; // 1 to 10
        this.captchaOperator = operators[Math.floor(Math.random() * operators.length)];
        if (this.captchaOperator === '+') {
            this.captchaAnswer = this.captchaNum1 + this.captchaNum2;
        } else {
            this.captchaAnswer = this.captchaNum1 - this.captchaNum2;
        }
        this.captchaInput = '';
        this.captchaError = '';
    },

    // Sandbox Modal States
    sandboxModalOpen: false,
    sandboxTab: 'employees',
    sandboxAttendanceState: 'checked-out',
    sandboxCheckInTime: '',
    sandboxCheckInLogs: [
        { time: '09:12 AM', event: 'Sarah Jenkins checked in via geo-fencing' },
        { time: '09:30 AM', event: 'Marcus Chen checked in from Mumbai Office' }
    ],
    sandboxPayrollGenerated: false,
    sandboxPayrollLoading: false,
    sandboxLeavesCount: 1,
    sandboxLeavesApproved: false,
    sandboxEmployees: [
        { name: 'Sarah Jenkins', role: 'VP Operations', type: 'Remote', status: 'Checked In', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100' },
        { name: 'Marcus Chen', role: 'Lead Developer', type: 'In Office', status: 'Checked In', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100' },
        { name: 'Elena Rostova', role: 'Product Designer', type: 'Sick Leave', status: 'Sick Leave', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100' }
    ],
    sandboxNewEmp: { name: '', role: '', type: 'Remote' },

    submitSignUp() {
        this.signUpErrors = {};
        let hasErrors = false;

        // Name Validation
        if (!this.signUpForm.name) {
            this.signUpErrors.name = ['Name is required'];
            hasErrors = true;
        } else if (!/^[A-Za-z\s]{2,50}$/.test(this.signUpForm.name)) {
            this.signUpErrors.name = ['Name must contain letters and spaces only (min 2 chars)'];
            hasErrors = true;
        }

        // Email Validation
        if (!this.signUpForm.email) {
            this.signUpErrors.email = ['Email is required'];
            hasErrors = true;
        } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.signUpForm.email)) {
            this.signUpErrors.email = ['Please enter a valid email address'];
            hasErrors = true;
        }

        // Phone Validation
        if (!this.signUpForm.phone) {
            this.signUpErrors.phone = ['Phone number is required'];
            hasErrors = true;
        } else if (!/^\d{10}$/.test(this.signUpForm.phone)) {
            this.signUpErrors.phone = ['Phone number must be exactly 10 digits'];
            hasErrors = true;
        }

        // Company Validation
        if (!this.signUpForm.company) {
            this.signUpErrors.company = ['Company is required'];
            hasErrors = true;
        }

        // Password Validation
        if (!this.signUpForm.password) {
            this.signUpErrors.password = ['Password is required'];
            hasErrors = true;
        } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(this.signUpForm.password)) {
            this.signUpErrors.password = ['Password must be at least 8 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character'];
            hasErrors = true;
        }

        if (hasErrors) return;

        this.authLoading = true;
        this.authStepText = 'Initializing trial workspace...';
        
        setTimeout(() => { this.authStepText = 'Provisioning secure database isolation...'; }, 600);
        setTimeout(() => { this.authStepText = 'Configuring default regional tax profiles...'; }, 1200);
        
        setTimeout(() => {
            fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                },
                body: JSON.stringify({
                    name: this.signUpForm.name,
                    email: this.signUpForm.email,
                    password: this.signUpForm.password,
                    password_confirmation: this.signUpForm.password,
                    company: this.signUpForm.company,
                    phone: this.signUpForm.phone
                })
            })
            .then(async res => {
                if (res.ok) {
                    this.authLoading = false;
                    this.authSubmitted = true;
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 2000);
                } else if (res.status === 422) {
                    this.authLoading = false;
                    const data = await res.json();
                    this.signUpErrors = data.errors || {};
                    this.showToast('error', 'Validation Failed', 'Please check the form for errors.');
                } else {
                    this.authLoading = false;
                    this.showToast('error', 'Registration Failed', 'An error occurred during registration.');
                }
            })
            .catch(err => {
                this.authLoading = false;
                this.showToast('error', 'Connection Error', 'Failed to connect to the server.');
            });
        }, 1800);
    },

    addSandboxEmployee() {
        if (!this.sandboxNewEmp.name || !this.sandboxNewEmp.role) return;
        if (!/^[A-Za-z\s]{2,50}$/.test(this.sandboxNewEmp.name)) {
            alert('Please enter a valid employee name (only letters and spaces).');
            return;
        }
        this.sandboxEmployees.push({
            name: this.sandboxNewEmp.name,
            role: this.sandboxNewEmp.role,
            type: this.sandboxNewEmp.type,
            status: 'Checked Out',
            avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=100'
        });
        this.sandboxNewEmp = { name: '', role: '', type: 'Remote' };
    },

    toggleSandboxClock() {
        if (this.sandboxAttendanceState === 'checked-out') {
            this.sandboxAttendanceState = 'loading';
            setTimeout(() => {
                this.sandboxAttendanceState = 'checked-in';
                const now = new Date();
                this.sandboxCheckInTime = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                this.sandboxCheckInLogs.unshift({
                    time: this.sandboxCheckInTime,
                    event: 'You checked in from Web Sandbox Playground'
                });
            }, 800);
        } else if (this.sandboxAttendanceState === 'checked-in') {
            this.sandboxAttendanceState = 'loading';
            setTimeout(() => {
                this.sandboxAttendanceState = 'checked-out';
                const now = new Date();
                const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                this.sandboxCheckInLogs.unshift({
                    time: timeStr,
                    event: 'You checked out from Web Sandbox Playground'
                });
            }, 800);
        }
    },

    runSandboxPayroll() {
        this.sandboxPayrollLoading = true;
        setTimeout(() => {
            this.sandboxPayrollLoading = false;
            this.sandboxPayrollGenerated = true;
        }, 1500);
    },

    sandboxSelectedEmpForSlip: 'Sarah Jenkins',
    sandboxSlipGenerating: false,
    sandboxSlipSuccess: false,
    sandboxSelectedRole: 'admin',
    sandboxPermissions: {
        admin: { payroll: true, shifts: true, leaves: true, system: true },
        manager: { payroll: true, shifts: true, leaves: true, system: false },
        employee: { payroll: false, shifts: false, leaves: false, system: false }
    },

    generateSandboxSlip() {
        this.sandboxSlipGenerating = true;
        this.sandboxSlipSuccess = false;
        setTimeout(() => {
            this.sandboxSlipGenerating = false;
            this.sandboxSlipSuccess = true;
            setTimeout(() => {
                this.sandboxSlipSuccess = false;
            }, 3000);
        }, 1500);
    },

    toggleSandboxPermission(role, perm) {
        this.sandboxPermissions[role][perm] = !this.sandboxPermissions[role][perm];
    },

    // Custom Support Drawer States
    supportDrawerOpen: false,
    supportForm: { name: '', email: '', phone: '', queryType: 'enterprise', message: '' },
    supportLoading: false,
    supportSubmitted: false,
    supportStepText: 'Registering support inquiry...',
    supportErrors: {},

    // Demo Scheduler States
    selectedDemoDay: 'Mon',
    selectedDemoTime: '10:00 AM',
    demoBookingLoading: false,
    demoBookingSubmitted: false,
    demoBookingEmail: '',

    submitSupportForm() {
        this.supportErrors = {};
        let hasErrors = false;

        if (!this.supportForm.name) {
            this.supportErrors.name = 'Name is required';
            hasErrors = true;
        } else if (!/^[A-Za-z\s]{2,50}$/.test(this.supportForm.name)) {
            this.supportErrors.name = 'Name must contain letters and spaces only';
            hasErrors = true;
        }

        if (!this.supportForm.email) {
            this.supportErrors.email = 'Email is required';
            hasErrors = true;
        } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.supportForm.email)) {
            this.supportErrors.email = 'Please enter a valid email address';
            hasErrors = true;
        }

        if (!this.supportForm.phone) {
            this.supportErrors.phone = 'Phone number is required';
            hasErrors = true;
        } else if (!/^\d{10}$/.test(this.supportForm.phone)) {
            this.supportErrors.phone = 'Phone number must be exactly 10 digits';
            hasErrors = true;
        }

        if (!this.supportForm.message) {
            this.supportErrors.message = 'Requirements description is required';
            hasErrors = true;
        }

        if (hasErrors) return;

        this.supportLoading = true;
        this.supportStepText = 'Registering support inquiry...';
        
        setTimeout(() => { this.supportStepText = 'Analyzing system integration needs...'; }, 800);
        setTimeout(() => { this.supportStepText = 'Generating custom pricing quote...'; }, 1600);
        
        setTimeout(() => {
            this.supportLoading = false;
            this.supportSubmitted = true;
        }, 2400);
    },

    submitDemoBooking() {
        if (!this.demoBookingEmail || !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.demoBookingEmail)) {
            alert('Please enter a valid email address.');
            return;
        }
        this.demoBookingLoading = true;
        setTimeout(() => {
            this.demoBookingLoading = false;
            this.demoBookingSubmitted = true;
        }, 1200);
    },

    submitSignIn() {
        this.signInErrors = {};
        this.captchaError = '';
        let hasErrors = false;

        // Email Validation
        if (!this.signInForm.email) {
            this.signInErrors.email = ['Email is required'];
            hasErrors = true;
        } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.signInForm.email)) {
            this.signInErrors.email = ['Please enter a valid email address'];
            hasErrors = true;
        }

        // Password Validation
        if (!this.signInForm.password) {
            this.signInErrors.password = ['Password is required'];
            hasErrors = true;
        }

        // Captcha Validation
        if (!this.captchaInput) {
            this.captchaError = 'Security captcha is required';
            hasErrors = true;
        } else if (parseInt(this.captchaInput) !== this.captchaAnswer) {
            this.captchaError = 'Incorrect captcha answer. Please solve the puzzle.';
            this.generateCaptcha();
            hasErrors = true;
        }

        if (hasErrors) return;

        this.authLoading = true;
        this.authStepText = 'Verifying credentials...';
        
        setTimeout(() => { this.authStepText = 'Establishing secure session...'; }, 600);
        setTimeout(() => { this.authStepText = 'Redirecting to workspace...'; }, 1200);
        
        setTimeout(() => {
            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                },
                body: JSON.stringify({
                    email: this.signInForm.email,
                    password: this.signInForm.password,
                    remember: true
                })
            })
            .then(async res => {
                if (res.ok) {
                    this.authLoading = false;
                    this.authSubmitted = true;
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 2000);
                } else if (res.status === 422) {
                    this.authLoading = false;
                    const data = await res.json();
                    this.signInErrors = data.errors || {};
                    this.showToast('error', 'Validation Failed', 'Please check the form for errors.');
                } else {
                    this.authLoading = false;
                    this.showToast('error', 'Authentication Failed', 'Invalid credentials or server error.');
                }
            })
            .catch(err => {
                this.authLoading = false;
                this.showToast('error', 'Connection Error', 'Failed to connect to the server.');
            });
        }, 1800);
    },

    submitForgotPassword() {
        this.forgotErrors = {};
        
        if (!this.forgotEmail) {
            this.forgotErrors.email = 'Email address is required';
            return;
        } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.forgotEmail)) {
            this.forgotErrors.email = 'Please enter a valid email address';
            return;
        }
        
        this.forgotLoading = true;
        this.forgotStepText = 'Searching user database...';
        
        setTimeout(() => { this.forgotStepText = 'Generating secure reset token...'; }, 800);
        setTimeout(() => { this.forgotStepText = 'Transmitting email link...'; }, 1600);
        
        setTimeout(() => {
            this.forgotLoading = false;
            this.forgotSubmitted = true;
            this.showToast('success', 'Recovery Link Sent', 'Please check your email inbox.');
        }, 2400);
    }
}" x-effect="
    document.body.style.overflow = (resourcesDrawerOpen || companyHubOpen || authModalOpen || sandboxModalOpen || supportDrawerOpen || legalDrawerOpen) ? 'hidden' : '';
    if (authModalOpen && authTab === 'signin' && !captchaAnswer) { generateCaptcha(); }
">

    <!-- 1. Floating Glassmorphic Navbar -->
    <header class="fixed top-0 left-0 right-0 z-50 w-full transition-all duration-300"
            x-data="{ scrolled: false }"
            x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
            :class="scrolled ? 'pt-2 lg:pt-3' : 'pt-4 lg:pt-6'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="rounded-2xl border transition-all duration-300 flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3.5 sm:py-4 backdrop-blur-md"
                 :class="scrolled 
                     ? 'bg-white/95 shadow-lg shadow-slate-200/50 border-slate-200/80' 
                     : 'bg-white/80 border-slate-200/50 shadow-sm shadow-slate-200/20'">
                
                <!-- Logo Image -->
                <a href="/" class="flex items-center group">
                    <img src="{{ asset('assets/WorkNest-EMS_Logo.png') }}" 
                         alt="WorkNest Logo" 
                         class="h-9 sm:h-10 lg:h-12 w-auto hover:scale-[1.02] transition-transform duration-300">
                </a>

                <!-- Desktop Nav Links (Laptop & Desktop) -->
                <nav class="hidden lg:flex items-center gap-6 xl:gap-8">
                    <a href="#features" class="text-[11px] font-bold uppercase tracking-widest text-slate-600 hover:text-brand-600 transition-colors">Features</a>
                    <a href="#why-us" class="text-[11px] font-bold uppercase tracking-widest text-slate-600 hover:text-brand-600 transition-colors">Solutions</a>
                    <a href="#dashboard-preview" class="text-[11px] font-bold uppercase tracking-widest text-slate-600 hover:text-brand-600 transition-colors">Dashboard</a>
                    <a href="#integrations" class="text-[11px] font-bold uppercase tracking-widest text-slate-600 hover:text-brand-600 transition-colors">Integrations</a>
                    <a href="#pricing" class="text-[11px] font-bold uppercase tracking-widest text-slate-600 hover:text-brand-600 transition-colors">Pricing</a>
                    <a href="#faq" class="text-[11px] font-bold uppercase tracking-widest text-slate-600 hover:text-brand-600 transition-colors">FAQ</a>
                </nav>

                <!-- Desktop CTAs -->
                <div class="hidden lg:flex items-center">
                    <button @click="authModalOpen = true; authTab = 'signin'" type="button" 
                       class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 shadow-md shadow-brand-500/10 hover:shadow-lg hover:shadow-brand-500/20 active:scale-[0.98] transition-all duration-300 cursor-pointer">
                        Portal Access
                    </button>
                </div>

                <!-- Hamburger Button (Mobile & Tablet) -->
                <div class="flex lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="p-1 text-slate-600 hover:text-brand-600 focus:outline-none transition-colors" aria-label="Toggle Menu">
                        <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" x-show="!mobileMenuOpen" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" x-show="mobileMenuOpen" style="display: none;" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

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


    <!-- 2. Hero Section -->
    <section class="relative min-h-dvh pt-40 sm:pt-44 lg:pt-48 pb-20 lg:pb-24 bg-grid-pattern overflow-hidden flex flex-col">
        
        <!-- Ambient Mesh Blur Highlights (Premium Lights Projection) -->
        <div class="absolute top-[-10%] left-[-10%] w-125 h-125 bg-brand-400/15 rounded-full blur-[120px] -z-10 animate-pulse-slow"></div>
        <div class="absolute bottom-[5%] right-[-5%] w-150 h-150 bg-indigo-400/15 rounded-full blur-[140px] -z-10 animate-pulse-slow" style="animation-delay: 3s;"></div>
        <div class="absolute top-[35%] left-[45%] w-75 h-75 bg-violet-400/10 rounded-full blur-[90px] -z-10 animate-pulse-slow" style="animation-delay: 1.5s;"></div>

        <!-- Glowing backdrop behind the main dashboard frame to give it depth -->
        <div class="absolute top-[40%] right-[5%] w-137.5 h-87.5 bg-linear-to-tr from-brand-500/10 to-indigo-500/10 rounded-full blur-[80px] -z-10 pointer-events-none hidden lg:block"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 xl:gap-16 items-center">
                
                <!-- Left Content: Value Proposition -->
                <div class="lg:col-span-6 flex flex-col text-center lg:text-left">
                    
                    <!-- Premium Glass Pill Badge -->
                    <div class="inline-flex items-center gap-2 self-center lg:self-start bg-white/70 border border-slate-200/80 backdrop-blur-md text-slate-800 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-[10px] sm:text-xs font-semibold tracking-wide mb-6 lg:mb-8 shadow-sm hover:border-brand-300 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 cursor-pointer group">
                        <span class="flex h-2 w-2 sm:h-2.5 sm:w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 sm:h-2.5 sm:w-2.5 bg-emerald-500"></span>
                        </span>
                        <span class="font-medium text-slate-600">New Release:</span>
                        <span class="font-semibold text-slate-850 group-hover:text-brand-650 flex items-center gap-1">
                            Automated Regional Tax Audits <span class="group-hover:translate-x-0.5 transition-transform duration-200">&rarr;</span>
                        </span>
                    </div>

                    <!-- Main Headline with Gradient Overlay -->
                    <h1 class="text-3xl sm:text-5xl lg:text-[54px] xl:text-[62px] font-extrabold font-display text-slate-900 tracking-tight leading-[1.1] sm:leading-[1.08] mb-4 sm:mb-6">
                        Smart Employee & <br class="hidden sm:inline">
                        <span class="text-transparent bg-clip-text bg-linear-to-r from-brand-600 via-brand-500 to-indigo-600 text-glow">Attendance Hub</span>
                    </h1>

                    <!-- Subtext -->
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl mx-auto lg:mx-0 mb-6 sm:mb-8">
                        WorkNest unifies company directory management, automated leaves tracking, geo-restricted clock-ins, and accurate payroll processing in one modern platform.
                    </p>

                    <!-- CTAs with premium micro-interactions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center mb-8 sm:mb-10 w-full sm:w-auto">
                        <button @click="authModalOpen = true; authTab = 'signup'" type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl bg-brand-600 text-white font-semibold shadow-xl shadow-brand-600/10 hover:bg-brand-700 hover:-translate-y-0.5 active:scale-[0.98] hover:shadow-2xl hover:shadow-brand-600/25 transition-all duration-300 group cursor-pointer">
                            Start 14-Day Free Trial
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button @click="sandboxModalOpen = true" type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 rounded-xl bg-white border border-slate-200/80 backdrop-blur-md text-slate-700 font-semibold shadow-xs hover:bg-slate-50/50 hover:border-slate-350 hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 cursor-pointer">
                            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Explore Dashboard
                        </button>
                    </div>

                    <!-- Real User Trust Badge Grid -->
                    <div class="flex flex-col sm:flex-row items-center gap-5 justify-center lg:justify-start">
                        <!-- Avatars stack -->
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="HR Executive">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="VP Operations">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Founder & CEO">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=100" alt="VP HR">
                        </div>
                        <div class="text-slate-600 text-sm text-center lg:text-left">
                            <div class="flex items-center justify-center lg:justify-start gap-1 mb-0.5">
                                <div class="flex text-amber-500">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <span class="font-bold text-slate-800">4.9/5 Rating</span>
                            </div>
                            <span>Trusted by <span class="font-semibold text-slate-900">5,000+ teams</span> at fast-growing companies</span>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Interactive SaaS Dashboard Preview -->
                <div class="lg:col-span-6 relative mt-6 lg:mt-0 perspective-1000 w-full max-w-125 mx-auto lg:mr-0 lg:ml-auto"
                     x-data="{ 
                         activeTab: 'employees', 
                         cardTiltX: 0, 
                         cardTiltY: 0,
                         payrollGenerated: false,
                         payrollLoading: false,
                         generatePayroll() {
                             this.payrollLoading = true;
                             setTimeout(() => {
                                 this.payrollLoading = false;
                                 this.payrollGenerated = true;
                             }, 1200);
                         }
                     }"
                     @mousemove="const rect = $el.getBoundingClientRect(); const x = $event.clientX - rect.left - (rect.width/2); const y = $event.clientY - rect.top - (rect.height/2); cardTiltX = -(y / rect.height) * 8; cardTiltY = (x / rect.width) * 8;"
                     @mouseleave="cardTiltX = 0; cardTiltY = 0">
                    
                    <!-- Dashboard Shadow & Ambient Base Glow -->
                    <div class="absolute inset-0 bg-linear-to-tr from-brand-600/15 via-indigo-600/10 to-transparent rounded-4xl blur-2xl -z-10 pointer-events-none"></div>

                    <!-- Main Dashboard Frame Card (Futuristic Dark Theme) -->
                    <div class="relative bg-slate-950 border border-slate-800/80 shadow-2xl p-4 sm:p-5 overflow-hidden w-full transition-all duration-300 hover:shadow-[0_30px_80px_-15px_rgba(99,102,241,0.22)] rounded-3xl"
                         :style="'transform: rotateX(' + cardTiltX + 'deg) rotateY(' + cardTiltY + 'deg) scale3d(1.01, 1.01, 1.01);'">
                        
                        <!-- Header Mock Bar -->
                        <div class="flex items-center justify-between border-b border-slate-900 pb-3.5 mb-4 select-none">
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-rose-450 border border-rose-500/25"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-450 border border-amber-500/25"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-450 border border-emerald-500/25"></span>
                                <span class="text-[9px] font-bold text-slate-500 ml-4 font-mono bg-slate-900 border border-slate-800/40 px-2.5 py-1 rounded-md">worknest.io/dashboard</span>
                            </div>
                            
                            <!-- Search & Profile Header -->
                            <div class="flex items-center gap-3">
                                <div class="hidden sm:flex items-center gap-1.5 bg-slate-900 border border-slate-800/50 rounded-lg px-2 py-1 text-[9px] text-slate-500">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    <span>Search...</span>
                                </div>
                                <div class="w-6.5 h-6.5 rounded-full bg-linear-to-tr from-brand-500 to-indigo-500 text-white flex items-center justify-center font-bold text-[9px] shadow-sm">
                                    AD
                                </div>
                            </div>
                        </div>

                        <!-- Real Dashboard Layout Grid -->
                        <div class="grid grid-cols-12 gap-4">
                            
                            <!-- Sidebar with premium buttons -->
                            <div class="col-span-3 hidden sm:flex flex-col gap-2 border-r border-slate-900 pr-3.5 select-none">
                                <div class="px-2 py-1.5 rounded-lg text-slate-650 font-semibold text-[8px] uppercase tracking-widest mb-1.5">
                                    Main menu
                                </div>
                                
                                <!-- Employees Tab -->
                                <button @click="activeTab = 'employees'"
                                        type="button"
                                        class="p-2 rounded-xl text-left text-[11px] flex items-center gap-2 cursor-pointer transition-all duration-200"
                                        :class="activeTab === 'employees' ? 'bg-slate-900 text-brand-400 font-bold border border-slate-800' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    <span>Employees</span>
                                </button>
                                
                                <!-- Attendance Tab -->
                                <button @click="activeTab = 'attendance'"
                                        type="button"
                                        class="p-2 rounded-xl text-left text-[11px] flex items-center gap-2 cursor-pointer transition-all duration-200"
                                        :class="activeTab === 'attendance' ? 'bg-slate-900 text-brand-400 font-bold border border-slate-800' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Analytics</span>
                                </button>

                                <!-- Payroll Tab -->
                                <button @click="activeTab = 'payroll'"
                                        type="button"
                                        class="p-2 rounded-xl text-left text-[11px] flex items-center gap-2 cursor-pointer transition-all duration-200"
                                        :class="activeTab === 'payroll' ? 'bg-slate-900 text-brand-400 font-bold border border-slate-800' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Payroll</span>
                                </button>
                            </div>

                            <!-- Dashboard Content Panels -->
                            <div class="col-span-12 sm:col-span-9 flex flex-col gap-4 min-h-87.5">
                                
                                <!-- Tab Panel 1: Directory (Employees) -->
                                <div x-show="activeTab === 'employees'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="flex flex-col gap-3.5">
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Workspace Directory</span>
                                            <span class="text-sm font-extrabold text-white">Active Team Registry</span>
                                        </div>
                                        <span class="text-[9px] font-bold bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-lg text-slate-400 font-mono">248 Active</span>
                                    </div>

                                    <!-- Employee List Grid -->
                                    <div class="flex flex-col gap-2">
                                        
                                        <!-- Sarah Jenkins -->
                                        <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-900 bg-slate-900/50 hover:bg-slate-900 hover:border-brand-500 transition-all duration-200">
                                            <div class="flex items-center gap-3">
                                                <img class="w-8.5 h-8.5 rounded-lg object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Sarah Jenkins">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-200">Sarah Jenkins</span>
                                                    <span class="text-[9px] text-slate-500 font-medium">VP Operations &bull; Remote</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[8px] font-extrabold uppercase">Checked In</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            </div>
                                        </div>

                                        <!-- Marcus Chen -->
                                        <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-900 bg-slate-900/50 hover:bg-slate-900 hover:border-brand-500 transition-all duration-200">
                                            <div class="flex items-center gap-3">
                                                <img class="w-8.5 h-8.5 rounded-lg object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=100" alt="Marcus Chen">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-200">Marcus Chen</span>
                                                    <span class="text-[9px] text-slate-500 font-medium">Lead Developer &bull; In Office</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[8px] font-extrabold uppercase">Checked In</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            </div>
                                        </div>

                                        <!-- Elena Rostova -->
                                        <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-900 bg-slate-900/50 hover:bg-slate-900 hover:border-brand-500 transition-all duration-200">
                                            <div class="flex items-center gap-3">
                                                <img class="w-8.5 h-8.5 rounded-lg object-cover border border-slate-800" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=100" alt="Elena Rostova">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-200">Elena Rostova</span>
                                                    <span class="text-[9px] text-slate-500 font-medium">Product Designer &bull; Sick Leave</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-405 text-[8px] font-extrabold uppercase">On Leave</span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-450 animate-pulse"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Panel 2: Analytics / Attendance -->
                                <div x-show="activeTab === 'attendance'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="flex flex-col gap-3.5"
                                     style="display: none;">
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Workspace Analytics</span>
                                            <span class="text-sm font-extrabold text-white">Daily Attendance metrics</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 text-[9px] font-extrabold border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            94.2% Present Today
                                        </div>
                                    </div>

                                    <!-- Unique Visual: Dark Mode SVG Area Chart with Gradients -->
                                    <div class="rounded-2xl border border-slate-900 bg-slate-950 p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-[9px] font-bold text-slate-400">Weekly Attendance Rate</span>
                                            <span class="text-[9px] text-brand-400 font-bold font-mono">Avg: 96.5%</span>
                                        </div>
                                        
                                        <div class="relative w-full">
                                            <svg class="w-full h-24 overflow-visible" viewBox="0 0 300 80" preserveAspectRatio="none">
                                                <defs>
                                                    <linearGradient id="dark-chart-glow" x1="0" y1="0" x2="0" y2="1">
                                                        <stop offset="0%" stop-color="#6366f1" stop-opacity="0.3"></stop>
                                                        <stop offset="100%" stop-color="#6366f1" stop-opacity="0.0"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <!-- Filled Gradient Path -->
                                                <path d="M 0 65 Q 40 45 80 55 T 160 30 T 240 40 T 300 15 L 300 80 L 0 80 Z" fill="url(#dark-chart-glow)"></path>
                                                <!-- Stroke Line -->
                                                <path d="M 0 65 Q 40 45 80 55 T 160 30 T 240 40 T 300 15" stroke="#6366f1" stroke-width="2.5" stroke-linecap="round" fill="none"></path>
                                                <!-- Dots -->
                                                <circle cx="80" cy="55" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                                <circle cx="160" cy="30" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                                <circle cx="240" cy="40" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                                <circle cx="300" cy="15" r="3.5" fill="#020617" stroke="#6366f1" stroke-width="1.8"></circle>
                                            </svg>
                                            <div class="flex justify-between mt-1.5 font-mono text-[7.5px] font-bold text-slate-500">
                                                <span>Mon</span>
                                                <span>Tue</span>
                                                <span>Wed</span>
                                                <span>Thu</span>
                                                <span>Fri</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mini Stats Grid -->
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="p-2 rounded-xl bg-slate-900/40 border border-slate-900/60 flex flex-col gap-0.5">
                                            <span class="text-[8px] text-slate-500 font-bold uppercase font-mono">Late Clock-ins</span>
                                            <span class="text-xs font-extrabold text-rose-455">3 Employees</span>
                                        </div>
                                        <div class="p-2 rounded-xl bg-slate-900/40 border border-slate-900/60 flex flex-col gap-0.5">
                                            <span class="text-[8px] text-slate-500 font-bold uppercase font-mono">On Field Duty</span>
                                            <span class="text-xs font-extrabold text-brand-400">12 Employees</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab Panel 3: Payroll -->
                                <div x-show="activeTab === 'payroll'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="flex flex-col gap-3.5"
                                     style="display: none;">
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Payroll Processing Hub</span>
                                            <span class="text-sm font-extrabold text-white">Salary Generation</span>
                                        </div>
                                        <span class="text-[9px] font-bold bg-slate-900 border border-slate-800 px-2.5 py-1 rounded-lg text-slate-400 font-mono">Cycle: May 2026</span>
                                    </div>

                                    <div class="p-3.5 rounded-xl border border-slate-900 bg-slate-900/50 flex items-center justify-between shadow-2xs">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-semibold uppercase tracking-wider text-slate-500 font-mono">Total gross payroll</span>
                                            <span class="text-xl font-extrabold text-white tracking-tight mt-0.5">$142,500.00</span>
                                        </div>
                                        
                                        <!-- Action Simulation Button -->
                                        <div>
                                            <button @click="generatePayroll()" 
                                                    type="submit" 
                                                    class="inline-flex items-center gap-1.5 px-3 py-2.5 rounded-xl text-[10px] font-bold shadow-xs transition-all duration-300 active:scale-95 cursor-pointer border"
                                                    :class="payrollGenerated 
                                                        ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' 
                                                        : (payrollLoading ? 'bg-slate-900 text-slate-500 border-slate-800' : 'bg-brand-600 text-white border-brand-500/10 hover:bg-brand-700')">
                                                
                                                <!-- Loading Spinner -->
                                                <svg x-show="payrollLoading" class="animate-spin h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" style="display: none;">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>

                                                <!-- Checkmark / Slips icon -->
                                                <svg x-show="!payrollLoading" class="w-3.5 h-3.5" :class="payrollGenerated ? 'text-emerald-400' : 'text-white'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path x-show="!payrollGenerated" stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    <path x-show="payrollGenerated" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" style="display: none;" />
                                                </svg>

                                                <span x-text="payrollLoading ? 'Processing...' : (payrollGenerated ? 'Slips Emailed' : 'Run Payroll Cycle')"></span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Salary Breakdown Details -->
                                    <div class="flex flex-col gap-2 bg-slate-950 p-3 rounded-xl border border-slate-900">
                                        <div class="flex items-center justify-between text-[9px] text-slate-500 border-b border-slate-900/60 pb-1.5">
                                            <span>Base Salaries</span>
                                            <span class="font-mono text-slate-350 font-bold">$124,000.00</span>
                                        </div>
                                        <div class="flex items-center justify-between text-[9px] text-slate-500 border-b border-slate-900/60 pb-1.5">
                                            <span>Overtime Payouts</span>
                                            <span class="font-mono text-slate-350 font-bold">$12,800.50</span>
                                        </div>
                                        <div class="flex items-center justify-between text-[9px] text-slate-500 pb-0.5">
                                            <span>Taxes & Compliance</span>
                                            <span class="font-mono text-rose-405 font-bold">-$24,850.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card 1: Beautiful Employee Action Widget -->
                    <div class="absolute -bottom-4 sm:-bottom-5 lg:-bottom-6 left-2 sm:-left-3 lg:-left-8 w-60 p-4 bg-slate-900/95 backdrop-blur-md rounded-2xl border border-slate-800 shadow-2xl animate-float hover:scale-102 hover:border-brand-500 transition-all duration-300 pointer-events-none" style="animation-delay: 0.5s;">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img class="w-10 h-10 rounded-xl object-cover border border-slate-800" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Clock-in User">
                                <span class="absolute -bottom-1 -right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-emerald-500 border-2 border-slate-900">
                                    <span class="absolute h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[8px] text-slate-500 uppercase tracking-wider font-semibold">Realtime Clock-In</span>
                                <span class="text-xs font-bold text-slate-200">Sarah Jenkins</span>
                                <span class="text-[9px] text-emerald-400 font-semibold mt-0.5">Checked In @ 08:58 AM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card 2: Quick Payroll Approval Card -->
                    <div class="absolute -top-5 sm:-top-6 lg:-top-8 right-2 sm:-right-3 lg:-right-8 w-64 p-4 bg-slate-900/95 backdrop-blur-md rounded-2xl border border-slate-800 shadow-2xl animate-float hover:scale-102 hover:border-indigo-500 transition-all duration-300 pointer-events-none" style="animation-delay: 1.5s;">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[8px] font-bold uppercase tracking-wider text-slate-500 font-mono">Payroll Status</span>
                            <span class="px-2 py-0.5 text-[8px] font-bold rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 flex items-center gap-1">
                                <svg class="w-2.5 h-2.5 text-emerald-450" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Approved
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-semibold text-slate-500">Gross Payroll Amount</span>
                                <span class="text-base font-extrabold text-slate-250 tracking-tight">$142,500.00</span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-brand-950 border border-brand-800 flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" /></svg>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- 3. Trusted Companies Section (Infinite GSAP Carousel) -->
    <section class="py-12 border-y border-slate-200/70 bg-white/40 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <p class="text-center text-xs font-bold uppercase tracking-widest text-slate-400 mb-8">
                Empowering teams at modern companies
            </p>
            
            <!-- Marquee Mask Overlay for Left & Right Fade Effects -->
            <div class="absolute inset-y-0 left-0 w-20 bg-linear-to-r from-slate-50 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-20 bg-linear-to-l from-slate-50 to-transparent z-10 pointer-events-none"></div>

            <!-- Marquee Wrapper -->
            <div class="logo-marquee-wrapper w-full overflow-hidden">
                <div class="logo-marquee-inner flex whitespace-nowrap min-w-full items-center" style="width: max-content;">
                    
                    <!-- Logo Group 1 -->
                    <div class="logo-group">
                        <!-- Figma Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <path d="M12 4a4 4 0 014 4v4a4 4 0 01-4 4 4 4 0 01-4-4V8a4 4 0 014-4z" />
                                <path d="M12 16a4 4 0 014 4v4a4 4 0 01-8 0v-4a4 4 0 014-4z" />
                                <path d="M20 8a4 4 0 11-8 0 4 4 0 018 0z" />
                                <path d="M20 20a4 4 0 11-8 0 4 4 0 018 0z" />
                                <path d="M12 28a4 4 0 01-4-4v-4h4v4a4 4 0 01-4 4z" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Figma</text>
                            </svg>
                        </span>
                        <!-- Slack Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <circle cx="10" cy="10" r="3" />
                                <circle cx="20" cy="10" r="3" />
                                <circle cx="10" cy="20" r="3" />
                                <circle cx="20" cy="20" r="3" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Slack</text>
                            </svg>
                        </span>
                        <!-- Stripe Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">stripe</text>
                            </svg>
                        </span>
                        <!-- Microsoft Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-6 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <rect x="2" y="5" width="9" height="9" />
                                <rect x="13" y="5" width="9" height="9" />
                                <rect x="2" y="16" width="9" height="9" />
                                <rect x="13" y="16" width="9" height="9" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Microsoft</text>
                            </svg>
                        </span>
                        <!-- Google Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">Google</text>
                            </svg>
                        </span>
                        <!-- Linear Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <polygon points="10,6 22,15 10,24" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Linear</text>
                            </svg>
                        </span>
                        <!-- Spotify Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <circle cx="12" cy="15" r="9" fill="none" stroke="currentColor" stroke-width="2.2" />
                                <path d="M7 11.5c2.5-.8 5.5-.8 8 .2M8 15c2.2-.6 4.8-.6 7 .2M9 18.5c1.8-.4 3.8-.4 5.5.2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Spotify</text>
                            </svg>
                        </span>
                        <!-- Airbnb Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <path d="M16 16c-1.5-2-3-4-3-6a3 3 0 116 0c0 2-1.5 4-3 6z" fill="none" stroke="currentColor" stroke-width="2.2" />
                                <path d="M10 20c0-3.5 3-6.5 6-6.5s6 3 6 6.5" fill="none" stroke="currentColor" stroke-width="2.2" />
                                <text x="34" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Airbnb</text>
                            </svg>
                        </span>
                        <!-- Zoom Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">zoom</text>
                            </svg>
                        </span>
                        <!-- Amazon Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">amazon</text>
                            </svg>
                        </span>
                        <!-- Vercel Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <polygon points="12,4 22,22 2,22" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Vercel</text>
                            </svg>
                        </span>
                    </div>

                    <!-- Logo Group 2 (Identical Duplicate) -->
                    <div class="logo-group">
                        <!-- Figma Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <path d="M12 4a4 4 0 014 4v4a4 4 0 01-4 4 4 4 0 01-4-4V8a4 4 0 014-4z" />
                                <path d="M12 16a4 4 0 014 4v4a4 4 0 01-8 0v-4a4 4 0 014-4z" />
                                <path d="M20 8a4 4 0 11-8 0 4 4 0 018 0z" />
                                <path d="M20 20a4 4 0 11-8 0 4 4 0 018 0z" />
                                <path d="M12 28a4 4 0 01-4-4v-4h4v4a4 4 0 01-4 4z" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Figma</text>
                            </svg>
                        </span>
                        <!-- Slack Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <circle cx="10" cy="10" r="3" />
                                <circle cx="20" cy="10" r="3" />
                                <circle cx="10" cy="20" r="3" />
                                <circle cx="20" cy="20" r="3" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Slack</text>
                            </svg>
                        </span>
                        <!-- Stripe Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">stripe</text>
                            </svg>
                        </span>
                        <!-- Microsoft Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-6 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <rect x="2" y="5" width="9" height="9" />
                                <rect x="13" y="5" width="9" height="9" />
                                <rect x="2" y="16" width="9" height="9" />
                                <rect x="13" y="16" width="9" height="9" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Microsoft</text>
                            </svg>
                        </span>
                        <!-- Google Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">Google</text>
                            </svg>
                        </span>
                        <!-- Linear Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <polygon points="10,6 22,15 10,24" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Linear</text>
                            </svg>
                        </span>
                        <!-- Spotify Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <circle cx="12" cy="15" r="9" fill="none" stroke="currentColor" stroke-width="2.2" />
                                <path d="M7 11.5c2.5-.8 5.5-.8 8 .2M8 15c2.2-.6 4.8-.6 7 .2M9 18.5c1.8-.4 3.8-.4 5.5.2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Spotify</text>
                            </svg>
                        </span>
                        <!-- Airbnb Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <path d="M16 16c-1.5-2-3-4-3-6a3 3 0 116 0c0 2-1.5 4-3 6z" fill="none" stroke="currentColor" stroke-width="2.2" />
                                <path d="M10 20c0-3.5 3-6.5 6-6.5s6 3 6 6.5" fill="none" stroke="currentColor" stroke-width="2.2" />
                                <text x="34" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Airbnb</text>
                            </svg>
                        </span>
                        <!-- Zoom Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">zoom</text>
                            </svg>
                        </span>
                        <!-- Amazon Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <text x="15" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="22">amazon</text>
                            </svg>
                        </span>
                        <!-- Vercel Logo -->
                        <span class="logo-item gap-2 text-slate-500">
                            <svg class="h-7 w-auto" viewBox="0 0 100 30" fill="currentColor">
                                <polygon points="12,4 22,22 2,22" />
                                <text x="32" y="22" font-family="Plus Jakarta Sans" font-weight="800" font-size="20">Vercel</text>
                            </svg>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </section>



    <!-- 4. Core Features Section -->
    <section id="features" class="py-24 bg-site-bg-alt">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-brand-600 uppercase bg-brand-50 px-3 py-1.5 rounded-md">
                    Centralized Modules
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                    Everything you need to govern modern work
                </h2>
                <p class="text-slate-600">
                    A suite of professional tools engineered to streamline payroll calculations, track clock-ins, regulate leave approvals, and unify company directories.
                </p>
            </div>

            <!-- Features Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 gsap-stagger-container">
                
                <!-- Highlight Feature 1: Attendance Tracking with radar mapping visual -->
                <div class="gsap-stagger-item md:col-span-2 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/80 shadow-xs hover:border-brand-200 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex-1">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-950 font-display mb-3">Smart Geo-Attendance</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Construct custom geofence coordinates and restrict check-ins to authorized workplace parameters. Complete IP masking checks verify zero proxy attendance submissions.
                        </p>
                        <button @click="sandboxModalOpen = true; sandboxTab = 'attendance'" type="button" class="text-xs font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Configure parameters &rarr;
                        </button>
                    </div>
                    
                    <!-- Visual Radar Mock -->
                    <div class="w-full md:w-56 h-44 rounded-2xl bg-slate-50 border border-slate-200/50 p-4 flex flex-col justify-between relative overflow-hidden select-none">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-400 uppercase font-mono">GPS Verification</span>
                            <span class="px-2 py-0.5 text-[8px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 animate-pulse">Active bounds</span>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-30">
                            <div class="w-24 h-24 rounded-full border border-brand-500 animate-ping"></div>
                            <div class="w-16 h-16 rounded-full border border-brand-300"></div>
                            <div class="w-8 h-8 rounded-full border border-brand-200"></div>
                        </div>
                        <div class="flex items-center gap-2.5 bg-white p-2.5 rounded-xl border border-slate-150 shadow-xs z-10">
                            <div class="w-7 h-7 rounded-lg bg-brand-50 border border-brand-100 flex items-center justify-center text-[10px] font-bold text-brand-700">W</div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-slate-800">Acme HQ (Primary)</span>
                                <span class="text-[8px] text-slate-400 font-mono">Lat: 34.0522, Lng: -118.2437</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Highlight Feature 2: Automated Payroll with Compliances visual -->
                <div class="gsap-stagger-item md:col-span-2 p-6 sm:p-8 rounded-3xl bg-slate-950 text-white shadow-2xl shadow-slate-950/15 hover:-translate-y-1 hover:shadow-2xl hover:shadow-brand-950/25 transition-all duration-300 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
                    <div class="absolute top-[-20%] right-[-10%] w-72 h-72 bg-brand-500/10 rounded-full blur-[80px] -z-10 pointer-events-none"></div>
                    <div class="flex-1 z-10">
                        <div class="w-12 h-12 rounded-xl bg-brand-650 flex items-center justify-center mb-6 text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold font-display mb-3 text-white">Automated Pay Run Engine</h3>
                        <p class="text-slate-300 text-sm leading-relaxed mb-6">
                            Auto-calculate deductions, compute local tax regulations, synchronize approved leave cycles, and generate bulk pay runs with bank-deposit files.
                        </p>
                        <button @click="sandboxModalOpen = true; sandboxTab = 'payroll'" type="button" class="text-xs font-bold text-brand-300 flex items-center gap-2 cursor-pointer hover:text-brand-200 transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-450 animate-pulse"></span>
                            Launch Pay Run Simulator &rarr;
                        </button>
                    </div>
                    
                    <!-- Visual Calculator Mock -->
                    <div class="w-full md:w-56 h-44 rounded-2xl bg-white/5 border border-white/10 p-4 flex flex-col justify-between select-none z-10 backdrop-blur-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-[8px] font-bold text-slate-400 uppercase font-mono">Tax Audit Score</span>
                            <span class="text-[9px] font-extrabold text-emerald-400 font-mono">100% Compliant</span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between text-[9px] text-slate-300">
                                <span>Federal Tax</span>
                                <span class="font-bold font-mono">$12,450.00</span>
                            </div>
                            <div class="flex items-center justify-between text-[9px] text-slate-300">
                                <span>Regional Tax</span>
                                <span class="font-bold font-mono">$4,820.00</span>
                            </div>
                            <div class="w-full h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-400 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="text-[10px] font-bold text-white bg-brand-600/80 px-2.5 py-1.5 rounded-lg border border-brand-500 text-center">
                            Calculations Verified
                        </div>
                    </div>
                </div>

                <!-- Regular Feature 3: Directory -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Staff Directory</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Centralize secure contracts, personal details, roles, and profiles for your entire team.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'employees'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore directory &rarr;
                    </button>
                </div>

                <!-- Regular Feature 4: Leaves -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Leave Approvals</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Customize leave type parameters, track holidays, and authorize leave submissions in one click.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'leaves'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore leaves &rarr;
                    </button>
                </div>

                <!-- Regular Feature 5: Salary Slips -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Digital Salary Slips</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Create secure PDF payroll payslips that workers can directly access and download.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'slips'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore slips &rarr;
                    </button>
                </div>

                <!-- Regular Feature 6: Roles -->
                <div class="gsap-stagger-item p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-slate-350 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center mb-6 text-brand-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-955 font-display mb-2">Role Permissions</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6">
                            Establish granular permission levels for Admins, Managers, and general Employees.
                        </p>
                    </div>
                    <button @click="sandboxModalOpen = true; sandboxTab = 'permissions'" type="button" class="text-[11px] font-bold text-brand-600 flex items-center gap-2 cursor-pointer hover:text-brand-700 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Explore controls &rarr;
                    </button>
                </div>

            </div>

        </div>
    </section>


    <!-- 5. Why WorkNest Section -->
    <section id="why-us" class="py-24 bg-site-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-3 py-1.5 rounded-md">
                    Product Advantages
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                    Engineered to streamline business logistics
                </h2>
                <p class="text-slate-600">
                    Why startups and small businesses leave spreadsheets behind to run their workforce operations on WorkNest.
                </p>
            </div>

            <!-- Perks Grid -->
            <div class="grid md:grid-cols-3 gap-8 gsap-stagger-container">
                
                <!-- Fast Onboarding -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mb-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display mb-2">Fast Onboarding</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Configure your company register, department structures, and import workers via CSV in under 5 minutes.
                    </p>
                </div>

                <!-- Secure Platform -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center mb-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display mb-2">Secure Platform</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        We leverage bank-grade database hashing, complete CSRF protections, and strict GDPR privacy controls.
                    </p>
                </div>

                <!-- Smart Automation -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center mb-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display mb-2">Smart Automation</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        System automatically cross-references active clock-in hours and approved leaves to configure monthly payroll.
                    </p>
                </div>

                <!-- Multi-Company Support -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center mb-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display mb-2">Multi-Company Registry</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Hold multiple company portals under a single admin credential. Toggle structures in one click.
                    </p>
                </div>

                <!-- Real-Time Updates -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center mb-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display mb-2">Real-Time Sync</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Instantly capture worker punch-ins, clock-outs, leave submissions, and manager approvals.
                    </p>
                </div>

                <!-- Responsive Dashboards -->
                <div class="gsap-stagger-item p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-slate-200 hover:shadow-xl transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center mb-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-display mb-2">Responsive Dashboards</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Perfect visual hierarchy across web, mobile viewports, and tablets. Manage staff on the go.
                    </p>
                </div>

            </div>

        </div>
    </section>


    <!-- 6. Interactive Dashboard Preview Section -->
    <section id="dashboard-preview" class="py-24 bg-site-bg-alt border-t border-b border-slate-200/60" 
             x-data="{ currentTab: 'admin' }"
             x-on:switch-demo-tab.window="currentTab = $event.detail.tab">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-brand-600 uppercase bg-brand-50 px-3 py-1.5 rounded-md">
                    Live Demo
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-4">
                    Experience the dashboard interfaces
                </h2>
                <p class="text-slate-600">
                    Explore real dashboard screens custom-built for respective roles inside the organization. Click the tabs below.
                </p>
            </div>

            <!-- Tab Selectors -->
            <div class="flex flex-wrap items-center justify-center gap-3 mb-12 gsap-fade-up">
                <button @click="currentTab = 'admin'" 
                        :class="currentTab === 'admin' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Admin Portal
                </button>

                <button @click="currentTab = 'employee'" 
                        :class="currentTab === 'employee' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Employee View
                </button>

                <button @click="currentTab = 'payroll'" 
                        :class="currentTab === 'payroll' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Payroll Hub
                </button>

                <button @click="currentTab = 'attendance'" 
                        :class="currentTab === 'attendance' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Attendance Analytics
                </button>

                <button @click="currentTab = 'leaves'" 
                        :class="currentTab === 'leaves' ? 'bg-brand-900 text-white shadow-lg shadow-brand-950/20' : 'bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-100 border border-slate-200'"
                        class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Leave Approvals
                </button>
            </div>

            <!-- Mock Presentation Container -->
            <div class="gsap-fade-up bg-white rounded-3xl border border-slate-200/80 shadow-2xl p-6 sm:p-8 min-h-105 transition-all duration-300">
                
                <!-- Tab: Admin Portal -->
                <div x-show="currentTab === 'admin'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Administrative Center</h4>
                            <p class="text-sm text-slate-500">Unify departments, track live check-ins, and authorize pending leave requests.</p>
                        </div>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold text-white bg-brand-600 rounded-lg hover:bg-brand-700">
                            Launch Admin Dashboard &rarr;
                        </a>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-6">
                        <!-- Stat 1 -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Acme Workforce</span>
                            <div class="text-2xl font-bold text-slate-800 mt-1">2,482 Employees</div>
                            <div class="text-xs text-emerald-600 font-semibold mt-1">+14 onboarding this week</div>
                        </div>
                        <!-- Stat 2 -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Leave Requests</span>
                            <div class="text-2xl font-bold text-indigo-600 mt-1">8 Pending</div>
                            <div class="text-xs text-slate-500 font-semibold mt-1">Requires admin verification</div>
                        </div>
                        <!-- Stat 3 -->
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Global Payouts</span>
                            <div class="text-2xl font-bold text-slate-800 mt-1">$394,200.00</div>
                            <div class="text-xs text-slate-500 font-semibold mt-1">Next pay run: June 30</div>
                        </div>
                    </div>

                    <!-- Pending Approval List inside Mock -->
                    <div class="border border-slate-100 rounded-2xl overflow-hidden mt-2">
                        <div class="bg-slate-50 p-4 border-b border-slate-100 text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Pending Leaves Verification
                        </div>
                        <div class="divide-y divide-slate-100">
                            <div class="p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 font-bold flex items-center justify-center text-xs shrink-0">JD</div>
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-slate-800 leading-tight">Jane Doe</span>
                                        <span class="text-[11px] text-slate-400 mt-0.5 leading-tight">Marketing Lead &bull; Medical Leave</span>
                                    </div>
                                </div>
                                <div class="flex gap-2 w-full sm:w-auto justify-end mt-1 sm:mt-0">
                                    <button class="px-3 py-1 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold rounded-md">Approve</button>
                                    <button class="px-3 py-1 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-xs font-bold rounded-md">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab: Leave Approvals -->
                <div x-show="currentTab === 'leaves'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Leave Approvals & Tracking</h4>
                            <p class="text-sm text-slate-500">Authorize time-off requests, track employee leave balances, and review sick leave accruals.</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-650 border border-slate-200">
                            3 Pending Approvals
                        </span>
                    </div>

                    <!-- Leaves Interactive List -->
                    <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/20">
                        <div class="bg-slate-50 p-4 border-b border-slate-100 flex items-center justify-between text-xs font-bold text-slate-700 uppercase tracking-wider">
                            <span>Pending Leave Requests Queue</span>
                            <span class="text-indigo-600">Admin Action Required</span>
                        </div>
                        <div class="divide-y divide-slate-100" x-data="{ 
                            requests: [
                                { id: 1, name: 'Jane Doe', role: 'Marketing Lead', type: 'Medical Leave', duration: '3 Days (June 8 - June 10)', avatar: 'JD', status: 'pending' },
                                { id: 2, name: 'Alex Rivera', role: 'UX Designer', type: 'Vacation Leave', duration: '5 Days (June 12 - June 16)', avatar: 'AR', status: 'pending' },
                                { id: 3, name: 'Elena Rostova', role: 'Product Designer', type: 'Sick Leave', duration: '2 Days (June 5 - June 6)', avatar: 'ER', status: 'pending' }
                            ]
                        }">
                            <template x-for="req in requests" :key="req.id">
                                <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors hover:bg-slate-50/50" x-show="req.status === 'pending'">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-brand-100 border border-brand-200/50 text-brand-700 font-bold flex items-center justify-center text-sm font-mono" x-text="req.avatar"></div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-800 text-sm" x-text="req.name"></span>
                                                <span class="px-2 py-0.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-750 text-[9px] font-bold" x-text="req.type"></span>
                                            </div>
                                            <span class="text-xs text-slate-450 mt-0.5" x-text="req.role + ' • ' + req.duration"></span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2.5 self-end sm:self-center">
                                        <button @click="req.status = 'approved'" type="button" class="px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-250 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                            Approve
                                        </button>
                                        <button @click="req.status = 'rejected'" type="button" class="px-4 py-2 bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-250 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <!-- Empty State when all requests are approved/rejected -->
                            <div class="p-8 text-center text-slate-450 flex flex-col items-center justify-center" x-show="requests.filter(r => r.status === 'pending').length === 0" style="display: none;">
                                <div class="w-12 h-12 rounded-full bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-500 mb-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Queue Cleared</span>
                                <span class="text-[11px]">All pending leave requests have been successfully verified.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Employee View -->
                <div x-show="currentTab === 'employee'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Employee Portal</h4>
                            <p class="text-sm text-slate-500">Record check-in timings, apply for leaves, and inspect monthly payroll slips.</p>
                        </div>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 border border-slate-200">
                            Launch Employee Portal
                        </a>
                    </div>

                    <div class="grid sm:grid-cols-12 gap-8 items-center">
                        <div class="sm:col-span-5 flex flex-col gap-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Daily Punch Card</span>
                            
                            <!-- Clock-In Action inside Mock -->
                            <div class="p-6 rounded-2xl border border-slate-100 bg-slate-50 flex flex-col items-center justify-center text-center">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Current Session</span>
                                <span class="text-2xl font-bold text-slate-800 font-mono mb-4">08 Hrs : 12 Min</span>
                                <button class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-rose-500/10 transition-colors">
                                    Clock Out
                                </button>
                            </div>
                        </div>

                        <div class="sm:col-span-7 flex flex-col gap-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Available Accruals</span>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-xl border border-slate-100">
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold">Sick Leave Accrued</span>
                                    <div class="text-xl font-bold text-slate-800 mt-1">12.5 Days</div>
                                </div>
                                <div class="p-4 rounded-xl border border-slate-100">
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold">Vacation Leaves</span>
                                    <div class="text-xl font-bold text-slate-800 mt-1">18 Days</div>
                                </div>
                            </div>
                            <div class="p-4 rounded-xl bg-brand-50 border border-brand-100 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-brand-900">Need time off?</span>
                                    <span class="text-[11px] text-brand-700">Submit a leave ticket to your manager.</span>
                                </div>
                                <button class="px-3.5 py-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-lg transition-colors">
                                    Apply Leave
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Payroll Hub -->
                <div x-show="currentTab === 'payroll'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Automated Payroll Hub</h4>
                            <p class="text-sm text-slate-500">Auto-calculate deductions, compute regional taxes, and approve pay cycles in bulk.</p>
                        </div>
                        <button class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Run Payroll Cycle
                        </button>
                    </div>

                    <div class="border border-slate-100 rounded-2xl overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="p-4">Employee</th>
                                    <th class="p-4">Days Present</th>
                                    <th class="p-4">Base Payout</th>
                                    <th class="p-4">Tax Ded.</th>
                                    <th class="p-4">Net Salary</th>
                                    <th class="p-4">Slip</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                <tr>
                                    <td class="p-4 font-semibold text-slate-800">Jane Cooper</td>
                                    <td class="p-4 text-slate-600">22 / 22 Days</td>
                                    <td class="p-4 text-slate-600">$5,400.00</td>
                                    <td class="p-4 text-rose-600">-$420.00</td>
                                    <td class="p-4 font-bold text-slate-800">$4,980.00</td>
                                    <td class="p-4 text-brand-600 font-bold cursor-pointer hover:underline">Download</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-semibold text-slate-800">Robert Fox</td>
                                    <td class="p-4 text-slate-600">20 / 22 Days</td>
                                    <td class="p-4 text-slate-600">$4,200.00</td>
                                    <td class="p-4 text-rose-600">-$310.00</td>
                                    <td class="p-4 font-bold text-slate-800">$3,890.00</td>
                                    <td class="p-4 text-brand-600 font-bold cursor-pointer hover:underline">Download</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab: Attendance Analytics -->
                <div x-show="currentTab === 'attendance'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="flex flex-col gap-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 font-display">Workforce Attendance Analytics</h4>
                            <p class="text-sm text-slate-500">Track punctual check-ins, record absenteeism averages, and monitor overtime charts.</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                            May 2026 Reporting
                        </span>
                    </div>

                    <!-- Mini chart widget inside analytics tab -->
                    <div class="grid sm:grid-cols-12 gap-8 items-center">
                        <div class="sm:col-span-4 p-5 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Punctuality Score</span>
                            <div class="text-3xl font-bold text-emerald-600 mt-1">96.8%</div>
                            <p class="text-xs text-slate-500 mt-2 leading-relaxed">Punctuality rate has scaled by 1.2% in comparison to last week.</p>
                        </div>

                        <div class="sm:col-span-8 p-5 rounded-2xl border border-slate-100">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold text-slate-700">Late Punch-ins By Department</span>
                                <span class="text-[10px] text-slate-400">This Month</span>
                            </div>
                            <div class="flex flex-col gap-3">
                                <div>
                                    <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                        <span>Engineering</span>
                                        <span class="font-semibold text-slate-800">4% late</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" style="width: 4%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                        <span>Sales Operations</span>
                                        <span class="font-semibold text-slate-800">12% late</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 rounded-full" style="width: 12%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center justify-between text-xs text-slate-600 mb-1">
                                        <span>HR & Admin</span>
                                        <span class="font-semibold text-slate-800">2% late</span>
                                    </div>
                                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full" style="width: 2%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- 7. Employee Workflow Timeline -->
    <section class="py-24 bg-site-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-20 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-3 py-1.5 rounded-md">
                    Workflow Process
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                    From registry setup to pay run execution
                </h2>
                <p class="text-slate-600">
                    A streamlined journey constructed to onboard employees, collect attendance logs, audit leaves, and issue payrolls.
                </p>
            </div>

            <!-- Timeline Steps -->
            <div class="relative timeline-wrapper">
                <!-- Center Line for Large Screens -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-slate-200/60 rounded-full hidden lg:block overflow-hidden">
                    <div class="timeline-progress-bar w-full h-0"></div>
                </div>

                <div class="space-y-16 lg:space-y-24">
                    
                    <!-- Step 1 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-right">
                            <span class="text-sm font-bold text-brand-600">Step 01</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Company Portal Registry</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                HR administrators sign up on WorkNest, enter corporate information, structure company departments, and configure customized shifts.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            1
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Dashboard Visual</span>
                            <div class="h-10 w-3/4 mx-auto bg-slate-200/50 rounded-md mt-2 flex items-center justify-center text-[10px] text-slate-400">acme.worknest.io</div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row-reverse items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-left">
                            <span class="text-sm font-bold text-brand-600">Step 02</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Invite and Onboard Personnel</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Upload a CSV containing staff rosters or transmit individualized registration invitations. Staff register and log in to activate their accounts.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            2
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Email Invitation Sent</span>
                            <div class="h-10 w-4/5 mx-auto bg-slate-200/50 rounded-md mt-2 flex items-center justify-center text-[10px] text-slate-400">Welcome to Acme Workspace</div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-right">
                            <span class="text-sm font-bold text-brand-600">Step 03</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Automated Attendance Tracking</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Employees record check-ins and check-outs daily via browser or mobile endpoints, creating precise timesheet records automatically.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            3
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Check-in Stamp</span>
                            <div class="h-10 w-2/3 mx-auto bg-emerald-50 rounded-md mt-2 flex items-center justify-center text-[10px] text-emerald-600 font-bold">Checked In: 09:00 AM</div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row-reverse items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-left">
                            <span class="text-sm font-bold text-brand-600">Step 04</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Audit Leaves & Requests</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Employees submit leave tickets. Managers inspect request contexts and approve or decline in real time, updating the central calendar.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            4
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Request Accrued</span>
                            <div class="h-10 w-3/4 mx-auto bg-indigo-50 rounded-md mt-2 flex items-center justify-center text-[10px] text-indigo-600 font-bold">Leave Approved (Jane Doe)</div>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="gsap-fade-up relative flex flex-col lg:flex-row items-center justify-between gap-8">
                        <div class="lg:w-2/5 text-center lg:text-right">
                            <span class="text-sm font-bold text-brand-600">Step 05</span>
                            <h3 class="text-xl font-bold text-slate-900 font-display mt-1 mb-2">Execute Automated Pay Run</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                The system maps logs, counts absences, constructs tax profiles, computes allowances, processes salaries, and auto-issues PDF slips.
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-brand-600 text-white flex items-center justify-center z-10 font-bold border-4 border-slate-50 shadow-lg">
                            5
                        </div>
                        <div class="lg:w-2/5 hidden lg:block bg-slate-50 rounded-2xl p-6 border border-slate-100 text-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Payroll Cycle Complete</span>
                            <div class="h-10 w-4/5 mx-auto bg-emerald-50 rounded-md mt-2 flex items-center justify-center text-[10px] text-emerald-600 font-bold">Salary Slip Generated</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>


    <!-- 7. Employee Mobile App (Option 1) -->
    <section id="mobile-app" class="py-24 bg-white border-t border-slate-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <!-- Text Content -->
                <div class="lg:w-1/2 text-center lg:text-left gsap-fade-up">
                    <span class="text-xs font-bold tracking-widest text-brand-600 uppercase bg-brand-50 px-3 py-1.5 rounded-md">
                        Work From Anywhere
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                        Manage work on the go with our Mobile App
                    </h2>
                    <p class="text-slate-600 mb-8 leading-relaxed text-lg">
                        Let employees clock in/out via Geo-fenced mobile tracking, request leaves, and view payslips right from their pockets. Keep your entire workforce connected no matter where they are.
                    </p>
                    <ul class="flex flex-col gap-4 text-slate-700 text-sm font-semibold max-w-md mx-auto lg:mx-0">
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg></div>
                            <span>Geo-fenced mobile clock-in and clock-out</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 002 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7v-5z"/></svg></div>
                            <span>One-tap leave requests and instant approvals</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg></div>
                            <span>Instant notifications for upcoming payroll</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Visual / App Showcase -->
                <div class="lg:w-1/2 w-full gsap-fade-up relative flex justify-center">
                    <!-- Glow -->
                    <div class="absolute inset-0 bg-brand-400/10 rounded-full blur-[100px] -z-10"></div>
                    
                    <!-- Mobile App Mockup -->
                    <div class="relative w-[320px] h-[640px] bg-slate-900 rounded-[48px] border-[10px] border-slate-800 shadow-2xl overflow-hidden group">
                        <!-- Top Notch -->
                        <div class="absolute top-0 inset-x-0 h-6 bg-slate-800 rounded-b-2xl w-[120px] mx-auto z-20"></div>
                        
                        <!-- Screen Content -->
                        <div class="absolute inset-0 bg-slate-50 flex flex-col pt-10">
                            <!-- App Header -->
                            <div class="px-6 pb-6 border-b border-slate-200/80 bg-white">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm">JD</div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-base leading-tight">Jane Doe</h4>
                                            <p class="text-[11px] text-slate-500 leading-tight mt-0.5">Marketing Lead</p>
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                </div>
                                <span class="inline-block bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-[10px] font-bold border border-emerald-100 uppercase tracking-wide">Status: Active</span>
                            </div>
                            
                            <!-- App Body -->
                            <div class="p-6 flex-1 overflow-y-auto no-scrollbar space-y-4">
                                <!-- Cards -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform cursor-pointer">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Leave Balance</span>
                                        <div class="text-2xl font-display font-bold text-slate-800">14<span class="text-xs text-slate-400 font-normal ml-1">days</span></div>
                                    </div>
                                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform cursor-pointer">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Next Payout</span>
                                        <div class="text-2xl font-display font-bold text-slate-800">$3.2k</div>
                                    </div>
                                </div>
                                
                                <!-- Recent Activity -->
                                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mt-4">
                                    <h5 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Recent Requests</h5>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center pb-3 border-b border-slate-50">
                                            <div>
                                                <div class="text-sm font-bold text-slate-700">Sick Leave</div>
                                                <div class="text-[10px] text-slate-400">June 5 - June 6</div>
                                            </div>
                                            <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">Pending</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <div class="text-sm font-bold text-slate-700">Expense Claim</div>
                                                <div class="text-[10px] text-slate-400">Travel to HQ</div>
                                            </div>
                                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">Approved</span>
                                        </div>
                                    </div>
                                </div>

                                <button class="mt-4 w-full py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-brand-500/30 transition-colors">
                                    Download Payslip
                                </button>
                            </div>
                            
                            <!-- Bottom Nav Bar -->
                            <div class="h-16 bg-white border-t border-slate-200/80 flex items-center justify-around px-4 rounded-b-3xl">
                                <div class="flex flex-col items-center text-brand-600">
                                    <svg class="w-5 h-5 mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                    <span class="text-[9px] font-bold">Home</span>
                                </div>
                                <div class="flex flex-col items-center text-slate-400">
                                    <svg class="w-5 h-5 mb-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                    <span class="text-[9px] font-bold">Leaves</span>
                                </div>
                                <div class="flex flex-col items-center text-slate-400">
                                    <svg class="w-5 h-5 mb-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    <span class="text-[9px] font-bold">Profile</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7.5 Employee Self-Service (ESS) Portal (Option 3) -->
    <section id="ess-portal" class="py-24 bg-slate-50 border-t border-slate-200/50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row-reverse items-center gap-16">
                <!-- Text Content -->
                <div class="lg:w-5/12 text-center lg:text-left gsap-fade-up">
                    <span class="text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-3 py-1.5 rounded-md border border-indigo-100">
                        Zero HR Overhead
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-5">
                        Empower your team with a Self-Service Web Portal
                    </h2>
                    <p class="text-slate-600 mb-6 leading-relaxed text-lg">
                        Give your staff the autonomy to download their own tax forms, check holiday balances, update bank details, and submit expense claims instantly from their desktops.
                    </p>
                    <a href="javascript:void(0)" 
                       onclick="window.dispatchEvent(new CustomEvent('switch-demo-tab', { detail: { tab: 'employee' } }))"
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors">
                        Explore ESS Features
                    </a>
                </div>
                
                <!-- Visual / Web Showcase -->
                <div class="lg:w-7/12 w-full gsap-fade-up relative">
                    <!-- Glow -->
                    <div class="absolute inset-0 bg-indigo-400/20 rounded-full blur-[120px] -z-10"></div>
                    
                    <!-- Desktop Browser Mockup -->
                    <div class="w-full bg-white border border-slate-200/80 rounded-2xl shadow-2xl relative overflow-hidden group">
                        <!-- Browser Header -->
                        <div class="h-10 bg-slate-100 border-b border-slate-200/80 flex items-center px-4 gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                            <div class="mx-auto bg-white border border-slate-200 rounded-md h-6 w-1/2 max-w-[200px] flex items-center justify-center text-[10px] text-slate-400 font-mono">worknest.app/my-portal</div>
                        </div>
                        
                        <!-- Dashboard UI -->
                        <div class="p-6 grid grid-cols-12 gap-6">
                            <!-- Sidebar -->
                            <div class="col-span-3 space-y-2 hidden sm:block border-r border-slate-100 pr-4">
                                <div class="p-2 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                    Overview
                                </div>
                                <div class="p-2 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-700 text-xs font-bold flex items-center gap-2 cursor-pointer transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    Document Vault
                                </div>
                                <div class="p-2 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-700 text-xs font-bold flex items-center gap-2 cursor-pointer transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Tax Forms (W-2)
                                </div>
                                <div class="p-2 rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-700 text-xs font-bold flex items-center gap-2 cursor-pointer transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Profile Settings
                                </div>
                            </div>
                            
                            <!-- Main Content -->
                            <div class="col-span-12 sm:col-span-9">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-slate-800">My Document Vault</h3>
                                    <button class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold rounded-lg shadow-sm transition-colors">Upload Document</button>
                                </div>
                                
                                <div class="space-y-3">
                                    <!-- Doc 1 -->
                                    <div class="p-4 border border-slate-100 bg-slate-50 hover:bg-white transition-colors rounded-xl flex items-center justify-between group cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-800">2023_W2_Form.pdf</div>
                                                <div class="text-[10px] text-slate-500">Added Jan 15, 2024 • 1.2 MB</div>
                                            </div>
                                        </div>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg></button>
                                        </div>
                                    </div>
                                    
                                    <!-- Doc 2 -->
                                    <div class="p-4 border border-slate-100 bg-slate-50 hover:bg-white transition-colors rounded-xl flex items-center justify-between group cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-800">Employment_Contract.pdf</div>
                                                <div class="text-[10px] text-slate-500">Added Sep 01, 2023 • 2.4 MB</div>
                                            </div>
                                        </div>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <!-- 8.5 Compliance & Security Section -->
    <section id="security" class="py-20 bg-slate-900 text-white overflow-hidden relative border-t border-slate-800">
        <!-- Glows -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500/20 rounded-full blur-[120px] -z-10"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center gsap-fade-up">
            <span class="text-xs font-bold tracking-widest text-emerald-400 uppercase bg-emerald-400/10 px-3 py-1.5 rounded-md border border-emerald-400/20 mb-6 inline-block">
                Enterprise-Grade Security
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold font-display tracking-tight mb-4">
                Your workforce data is in safe hands
            </h2>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg mb-12">
                We employ bank-level encryption, rigorous access controls, and regular external audits to ensure your HR records are completely protected and globally compliant.
            </p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto gsap-stagger-container">
                <!-- Badges -->
                <div class="gsap-stagger-item bg-slate-800/50 backdrop-blur-sm border border-slate-700 p-6 rounded-2xl flex flex-col items-center hover:bg-slate-800 hover:-translate-y-1 transition-all">
                    <svg class="w-10 h-10 text-emerald-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span class="font-bold text-sm">SOC 2 Type II</span>
                    <span class="text-[10px] text-slate-400 mt-1">Certified</span>
                </div>
                <div class="gsap-stagger-item bg-slate-800/50 backdrop-blur-sm border border-slate-700 p-6 rounded-2xl flex flex-col items-center hover:bg-slate-800 hover:-translate-y-1 transition-all">
                    <svg class="w-10 h-10 text-blue-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span class="font-bold text-sm">GDPR Ready</span>
                    <span class="text-[10px] text-slate-400 mt-1">EU Compliant</span>
                </div>
                <div class="gsap-stagger-item bg-slate-800/50 backdrop-blur-sm border border-slate-700 p-6 rounded-2xl flex flex-col items-center hover:bg-slate-800 hover:-translate-y-1 transition-all">
                    <svg class="w-10 h-10 text-brand-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span class="font-bold text-sm">ISO 27001</span>
                    <span class="text-[10px] text-slate-400 mt-1">Data Standard</span>
                </div>
                <div class="gsap-stagger-item bg-slate-800/50 backdrop-blur-sm border border-slate-700 p-6 rounded-2xl flex flex-col items-center hover:bg-slate-800 hover:-translate-y-1 transition-all">
                    <svg class="w-10 h-10 text-purple-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <span class="font-bold text-sm">256-bit AES</span>
                    <span class="text-[10px] text-slate-400 mt-1">Encryption</span>
                </div>
            </div>
        </div>
    </section>

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


    <!-- 10. Testimonials Section -->
    <section class="py-24 bg-site-bg-alt border-t border-slate-200/60 overflow-hidden"
             x-data="{ 
                 activeCompany: 'apex',
                 companies: {
                     apex: {
                         quote: 'WorkNest totally overhauled our HR logistics. Running monthly payroll cycles for 80+ employees now requires a single click. The attendance punch card is incredibly reliable.',
                         name: 'Sarah Jenkins',
                         role: 'HR Director',
                         company: 'Apex Tech',
                         avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=120',
                         metrics: [
                             { label: 'Payroll speed', value: '95% faster' },
                             { label: 'Time saved monthly', value: '140+ hrs' }
                         ]
                     },
                     bytelabs: {
                         quote: 'As a remote-first startup founder, monitoring check-in records across timezones was a constant hassle. WorkNest simplified everything. The Slack integrations keep our team in sync.',
                         name: 'Marcus Vance',
                         role: 'Founder',
                         company: 'ByteLabs Studio',
                         avatar: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=120',
                         metrics: [
                             { label: 'Tracking uptime', value: '99.9%' },
                             { label: 'Syncing latency', value: 'Instant' }
                         ]
                     },
                     zenith: {
                         quote: 'The automated leave accrual scheduler and PDF payslip download portal are huge timesavers. Our employees love having a dashboard where they can track their personal data.',
                         name: 'Leila Rahman',
                         role: 'Operations Lead',
                         company: 'Zenith Co.',
                         avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=120',
                         metrics: [
                             { label: 'Leave approval', value: '< 5 min' },
                             { label: 'Satisfaction index', value: '4.8 / 5.0' }
                         ]
                     },
                     cloudnet: {
                         quote: 'Migrating our core employee directories to WorkNest took less than an afternoon. The developer-friendly API and custom webhooks made integration with our internal systems incredibly simple.',
                         name: 'David Kim',
                         role: 'VP of Engineering',
                         company: 'CloudNet Systems',
                         avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=120',
                         metrics: [
                             { label: 'Integration time', value: '< 2 hours' },
                             { label: 'Sync reliability', value: '99.99%' }
                         ]
                     },
                     novahr: {
                         quote: 'Managing salary dispersion, tax compliance, and automated slips for our global workforce was a major challenge. WorkNest resolved all regulatory differences instantly.',
                         name: 'Elena Rostova',
                         role: 'HR Operations VP',
                         company: 'Nova HR Solutions',
                         avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=120',
                         metrics: [
                             { label: 'Tax audits passed', value: '100%' },
                             { label: 'Overhead reduced', value: '85%' }
                         ]
                     },
                     alphascale: {
                         quote: 'Geofencing check-ins and real-time attendance tracking sheets solved our scheduling discrepancies. Our on-site managers have seen a significant productivity boost.',
                         name: 'Marcus Chen',
                         role: 'Chief Operating Officer',
                         company: 'AlphaScale Partners',
                         avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=120',
                         metrics: [
                             { label: 'Geo-compliance', value: '99.8%' },
                             { label: 'Dispatch speed', value: '3.5x faster' }
                         ]
                     }
                 }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16 gsap-fade-up">
                <span class="text-xs font-bold tracking-widest text-indigo-650 uppercase bg-indigo-50 px-3 py-1.5 rounded-md">
                    Case Studies & Success
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-display text-slate-900 tracking-tight mt-4 mb-4">
                    Proven results with real teams
                </h2>
                <p class="text-slate-600 text-sm">
                    Read the actual metrics and satisfaction details reported by operations managers.
                </p>
            </div>

            <!-- Dashboard Panel Container -->
            <div class="gsap-fade-up bg-white rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden grid lg:grid-cols-12 hover:shadow-2xl transition-shadow duration-300">
                
                <!-- Left: Sidebar Tabs (Company List) -->
                <div class="lg:col-span-4 bg-slate-50/50 border-b lg:border-b-0 lg:border-r border-slate-200/85 p-6 sm:p-8 flex flex-col lg:max-h-120">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 block shrink-0">Select Company</span>
                    
                    <!-- Scrollable Tabs Wrapper -->
                    <div class="flex flex-row lg:flex-col gap-3 overflow-x-auto lg:overflow-x-hidden lg:overflow-y-auto pb-3 lg:pb-0 scrollbar-none lg:scrollbar-premium lg:pr-1 shrink-0 lg:shrink-0 lg:h-[264px]">
                        <template x-for="(data, id) in companies" :key="id">
                            <button @click="activeCompany = id" 
                                    type="button"
                                    class="w-72 sm:w-80 lg:w-full shrink-0 text-left p-4 lg:p-5 rounded-2xl border transition-all duration-300 flex items-center gap-4 cursor-pointer"
                                    :class="activeCompany === id 
                                        ? 'bg-white border-brand-200 shadow-md translate-y-0 lg:translate-x-1' 
                                        : 'bg-transparent border-transparent hover:bg-white/60 hover:border-slate-200/50'">
                                <!-- Avatar mini -->
                                <img class="w-10 h-10 rounded-xl object-cover border border-slate-200/60 shrink-0" :src="data.avatar" :alt="data.name">
                                <div class="flex flex-col min-w-0">
                                    <span class="text-sm font-bold text-slate-800 truncate" x-text="data.company"></span>
                                    <span class="text-xs text-slate-400 font-semibold truncate" x-text="data.name"></span>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Right: Active Testimonial Spotlight Board -->
                <div class="lg:col-span-8 p-8 sm:p-12 relative flex flex-col justify-between overflow-hidden min-h-95">
                    <!-- Background ambient overlay -->
                    <div class="absolute top-[-20%] right-[-20%] w-72 h-72 bg-brand-400/5 rounded-full blur-[80px] -z-10 pointer-events-none"></div>

                    <!-- Testimonial content -->
                    <div class="flex flex-col gap-6">
                        <!-- Quote icon SVG -->
                        <svg class="w-10 h-10 text-brand-200" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>

                        <!-- Dynamically replaced Quote Text -->
                        <p class="text-lg sm:text-xl font-medium text-slate-700 leading-relaxed font-display" 
                           x-text="companies[activeCompany].quote"></p>
                    </div>

                    <!-- Bottom: Leader Meta and Metric Statistics -->
                    <div class="border-t border-slate-100 pt-8 mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <img class="w-12 h-12 rounded-full object-cover border-2 border-brand-500/20 shadow-sm" 
                                 :src="companies[activeCompany].avatar" :alt="companies[activeCompany].name">
                            <div class="flex flex-col">
                                <span class="text-sm font-extrabold text-slate-900" x-text="companies[activeCompany].name"></span>
                                <span class="text-xs text-slate-500 font-semibold" x-text="companies[activeCompany].role + ' • ' + companies[activeCompany].company"></span>
                            </div>
                        </div>

                        <!-- Metrics counter showcase -->
                        <div class="flex items-center gap-8 border-l border-slate-100 pl-0 sm:pl-8">
                            <template x-for="(metric, idx) in companies[activeCompany].metrics" :key="idx">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-black text-brand-600 font-display tracking-tight" x-text="metric.value"></span>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider" x-text="metric.label"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


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


    <!-- 13. Footer Section -->
    <footer class="bg-slate-900 border-t border-slate-800 py-12 md:py-16 lg:py-20 text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-y-10 sm:gap-y-12 gap-x-8 mb-10 md:mb-16 gsap-fade-up">
                
                <!-- Brand & Creator Profile Column -->
                <div class="col-span-1 sm:col-span-2 lg:col-span-2 flex flex-col gap-6">
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-8.5 h-8.5 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-brand-500/25">
                            W
                        </div>
                        <span class="text-xl font-bold text-white font-display">WorkNest.</span>
                    </a>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-xs">
                        WorkNest is a cloud-based employee management SaaS system. Effortlessly manage registers, check-ins, payrolls, and compliance.
                    </p>
                    
                    <!-- Creator Profile Spotlight Card -->
                    <div class="p-4 rounded-2xl bg-slate-800/40 border border-slate-800/80 backdrop-blur-xs flex flex-col gap-3.5 max-w-xs mt-2 shadow-inner">
                        <div class="flex items-center gap-3">
                            <div class="w-9.5 h-9.5 rounded-xl bg-brand-600 flex items-center justify-center text-white text-sm font-bold font-mono">
                                VP
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-white leading-tight">Vikram Pal</span>
                                <span class="text-[9.5px] text-slate-400 font-bold tracking-wide">Lead Developer Credits</span>
                            </div>
                        </div>
                        
                        <!-- Social & Work Profiles Row -->
                        <div class="flex items-center gap-3.5 text-slate-400 border-t border-slate-800/60 pt-3">
                            <!-- GitHub -->
                            <a href="https://github.com/vikrampal038" target="_blank" class="hover:text-white hover:scale-110 transition-all duration-200" title="GitHub Profile">
                                <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482C19.138 20.197 22 16.44 22 12.017 22 6.484 17.522 2 12 2z" /></svg>
                            </a>
                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/in/vikrampal038/" target="_blank" class="hover:text-white hover:scale-110 transition-all duration-200" title="LinkedIn Profile">
                                <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <!-- Instagram -->
                            <a href="https://www.instagram.com/vikrampal.dev/" target="_blank" class="hover:text-white hover:scale-110 transition-all duration-200" title="Instagram Profile">
                                <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051C.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                            </a>
                            <div class="h-4 w-px bg-slate-700"></div>
                            <!-- Portfolio -->
                            <a href="https://www.vikrampal.in/" target="_blank" class="hover:text-brand-400 hover:scale-105 transition-all duration-200 text-[10.5px] font-extrabold flex items-center gap-1.5" title="Portfolio Website">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                Portfolio
                            </a>
                            <!-- Resume -->
                            <a href="https://drive.google.com/file/d/1GciIKMk3kG0ivUI_xgQpayxf5_FpWMEI/view?usp=sharing" target="_blank" class="hover:text-brand-400 hover:scale-105 transition-all duration-200 text-[10.5px] font-extrabold flex items-center gap-1.5" title="Download Resume">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Resume
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Column 1: Modules -->
                <div class="flex flex-col gap-3.5 sm:gap-3">
                    <span class="text-xs font-bold text-white uppercase tracking-wider mb-1">Modules</span>
                    <a href="javascript:void(0)" @click="$dispatch('switch-demo-tab', { tab: 'employee' })" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Employee Directory</a>
                    <a href="javascript:void(0)" @click="$dispatch('switch-demo-tab', { tab: 'attendance' })" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Attendance Tracker</a>
                    <a href="javascript:void(0)" @click="$dispatch('switch-demo-tab', { tab: 'leaves' })" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Leave Approvals</a>
                    <a href="javascript:void(0)" @click="$dispatch('switch-demo-tab', { tab: 'payroll' })" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Payroll Core</a>
                </div>

                <!-- Column 2: Company -->
                <div class="flex flex-col gap-3.5 sm:gap-3">
                    <span class="text-xs font-bold text-white uppercase tracking-wider mb-1">Company</span>
                    <a href="javascript:void(0)" @click="companyHubOpen = true; activeHubTab = 'about'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">About Us</a>
                    <a href="javascript:void(0)" @click="companyHubOpen = true; activeHubTab = 'careers'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Careers</a>
                    <a href="javascript:void(0)" @click="companyHubOpen = true; activeHubTab = 'customers'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Customers</a>
                    <a href="javascript:void(0)" @click="companyHubOpen = true; activeHubTab = 'press'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Contact Press</a>
                </div>

                <!-- Column 3: Resources -->
                <div class="flex flex-col gap-3.5 sm:gap-3">
                    <span class="text-xs font-bold text-white uppercase tracking-wider mb-1">Resources</span>
                    <a href="javascript:void(0)" @click="resourcesDrawerOpen = true; activeResourcesTab = 'support'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">Support Center</a>
                    <a href="javascript:void(0)" @click="resourcesDrawerOpen = true; activeResourcesTab = 'api'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">API Docs</a>
                    <a href="javascript:void(0)" @click="resourcesDrawerOpen = true; activeResourcesTab = 'guides'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">HR Guides</a>
                    <a href="javascript:void(0)" @click="resourcesDrawerOpen = true; activeResourcesTab = 'security'" class="text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200">SaaS Security</a>
                </div>

                <!-- Column 4: Legal -->
                <div class="flex flex-col gap-3.5 sm:gap-3 text-left">
                    <span class="text-xs font-bold text-white uppercase tracking-wider mb-1">Legal</span>
                    <button @click="legalDrawerOpen = true; activeLegalTab = 'privacy'" type="button" class="text-left text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200 cursor-pointer">Privacy Policy</button>
                    <button @click="legalDrawerOpen = true; activeLegalTab = 'terms'" type="button" class="text-left text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200 cursor-pointer">Terms of Service</button>
                    <button @click="legalDrawerOpen = true; activeLegalTab = 'cookie'" type="button" class="text-left text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200 cursor-pointer">Cookie Policy</button>
                    <button @click="legalDrawerOpen = true; activeLegalTab = 'dpa'" type="button" class="text-left text-sm sm:text-xs text-slate-400 hover:text-white transition-colors duration-200 cursor-pointer">Data Processing (DPA)</button>
                </div>

            </div>

            <hr class="border-slate-800/80 my-8 sm:my-10">

            <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-5 text-center md:text-left text-xs text-slate-500">
                <span class="font-medium">© 2026 WorkNest EMS Corp. All rights reserved.</span>
                <span class="font-medium">Designed & Developed by <a href="https://www.vikrampal.in/" target="_blank" class="text-slate-400 hover:text-white transition-colors font-bold tracking-wide">Vikram Pal</a></span>
            </div>
        </div>
    </footer>

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
             class="relative w-full max-w-5xl h-[85vh] md:h-[620px] bg-white shadow-2xl shadow-brand-900/20 rounded-[32px] z-10 flex flex-col md:flex-row overflow-hidden border border-slate-200/60 p-2 sm:p-3 mx-4"
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


    <!-- 10. Live Sandbox Playground Modal Overlay -->
    <div x-show="sandboxModalOpen" 
         class="fixed inset-0 z-100 flex items-center justify-center p-4 sm:p-6 md:p-8 lg:p-12"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="sandboxModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sandboxModalOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs"></div>

        <!-- Dashboard Frame -->
        <div x-show="sandboxModalOpen"
             x-transition:enter="transition ease-out duration-305"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative w-full max-w-5xl h-[80vh] sm:h-[85vh] bg-white border border-slate-200/50 shadow-2xl rounded-3xl overflow-hidden flex flex-col z-10">
            
            <!-- Window Topbar -->
            <div class="bg-slate-50 px-5 py-4 border-b border-slate-200/60 flex items-center justify-between gap-4 select-none">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-rose-400 border border-rose-500/10"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-400 border border-amber-500/10"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-400 border border-emerald-500/10"></span>
                    <span class="text-[10px] font-bold text-slate-400 ml-4 font-mono bg-white border border-slate-200 px-2.5 py-0.5 rounded-md">worknest.io/sandbox/playground</span>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-indigo-50 border border-indigo-200 text-indigo-750 text-[9px] font-bold">
                        Interactive Live Sandbox
                    </span>
                    <button @click="sandboxModalOpen = false" type="button" class="text-slate-400 hover:text-slate-650 p-1.5 rounded-lg hover:bg-slate-200/50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Main Split Panels -->
            <div class="flex flex-col md:flex-row flex-1 overflow-hidden">
                
                <!-- Sidebar tabs list -->
                <div class="w-full md:w-56 border-b md:border-b-0 md:border-r border-slate-200/60 bg-slate-50/50 p-3 sm:p-4 flex flex-row md:flex-col gap-1.5 overflow-x-auto md:overflow-y-auto md:overflow-x-visible select-none shrink-0 scrollbar-none">
                    <span class="px-2.5 py-2 text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1 hidden md:block">Modules</span>
                    
                    <!-- Employees Tab -->
                    <button @click="sandboxTab = 'employees'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'employees' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="truncate">Staff Directory</span>
                    </button>

                    <!-- Attendance Tab -->
                    <button @click="sandboxTab = 'attendance'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'attendance' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">Geo-Attendance</span>
                    </button>

                    <!-- Payroll Tab -->
                    <button @click="sandboxTab = 'payroll'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'payroll' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="truncate">Payroll Hub</span>
                    </button>

                    <!-- Leaves Tab -->
                    <button @click="sandboxTab = 'leaves'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'leaves' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="truncate flex items-center justify-between gap-2 w-full">
                            <span>Leaves Manager</span>
                            <span x-show="sandboxLeavesCount > 0" class="text-[9px] font-extrabold px-1.5 py-0.5 rounded-full" :class="sandboxTab === 'leaves' ? 'bg-white text-brand-650' : 'bg-rose-500 text-white'" x-text="sandboxLeavesCount"></span>
                        </span>
                    </button>

                    <!-- Salary Slips Tab -->
                    <button @click="sandboxTab = 'slips'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'slips' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="truncate">Salary Slips</span>
                    </button>

                    <!-- Role Permissions Tab -->
                    <button @click="sandboxTab = 'permissions'" type="button" 
                            class="w-auto md:w-full shrink-0 p-2.5 rounded-xl text-left text-xs flex items-center gap-2.5 transition-all duration-200 cursor-pointer"
                            :class="sandboxTab === 'permissions' ? 'bg-brand-600 text-white font-bold shadow-md shadow-brand-500/10' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 font-medium'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="truncate">Access Controls</span>
                    </button>
                </div>

                <!-- Content Panel -->
                <div class="flex-1 p-5 sm:p-6 overflow-y-auto bg-white">
                    
                    <!-- Tab 1: Staff Directory -->
                    <div x-show="sandboxTab === 'employees'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="flex flex-col gap-6">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="text-base font-extrabold text-slate-850">Acme Staff Registry</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Manage user profiles and roles in your current company branch.</p>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 font-mono bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl self-start sm:self-center" x-text="sandboxEmployees.length + ' Employees Registered'"></span>
                        </div>

                        <!-- Add Employee Form Panel -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/50">
                            <span class="text-[9.5px] font-bold text-slate-400 uppercase tracking-wider mb-3 block">Add Sandbox Staff Member</span>
                            <form @submit.prevent="addSandboxEmployee()" class="grid grid-cols-1 sm:grid-cols-12 gap-3.5 items-end">
                                <div class="sm:col-span-5">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Employee Name</label>
                                    <input type="text" required x-model="sandboxNewEmp.name" class="w-full px-3 py-2 rounded-xl border border-slate-250 bg-white text-xs focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:outline-hidden" placeholder="e.g. John Doe">
                                </div>
                                <div class="sm:col-span-4">
                                    <label class="block text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Role / Position</label>
                                    <input type="text" required x-model="sandboxNewEmp.role" class="w-full px-3 py-2 rounded-xl border border-slate-250 bg-white text-xs focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 focus:outline-hidden" placeholder="e.g. Project Lead">
                                </div>
                                <div class="sm:col-span-3">
                                    <button type="submit" class="w-full py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-800 transition-all cursor-pointer">
                                        Add Member
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Employees Cards Grid -->
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <template x-for="emp in sandboxEmployees">
                                <div class="p-4 rounded-2xl border border-slate-200 hover:border-slate-300 hover:shadow-xs transition-all duration-300 flex items-center gap-3.5">
                                    <img :src="emp.avatar" class="w-10 h-10 rounded-full border border-slate-200 object-cover">
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-xs font-bold text-slate-850 truncate" x-text="emp.name"></h5>
                                        <p class="text-[10px] text-slate-450 mt-0.5 truncate" x-text="emp.role"></p>
                                    </div>
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-full shrink-0"
                                          :class="emp.status === 'Checked In' ? 'bg-emerald-50 text-emerald-700 border border-emerald-250' : emp.status === 'Checked Out' ? 'bg-slate-50 text-slate-650 border border-slate-200' : 'bg-amber-50 text-amber-700 border border-amber-250'"
                                          x-text="emp.status"></span>
                                </div>
                            </template>
                        </div>

                    </div>

                    <!-- Tab 2: Geo-Attendance -->
                    <div x-show="sandboxTab === 'attendance'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Web Sandbox Clock-In Terminal</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Test geofenced clocking triggers in real-time right from your browser.</p>
                        </div>

                        <!-- Control Center Grid -->
                        <div class="grid sm:grid-cols-12 gap-6">
                            
                            <!-- Left: Clock Action -->
                            <div class="sm:col-span-5 p-5 rounded-2xl border border-slate-200/80 bg-slate-50/50 flex flex-col items-center justify-center text-center gap-4">
                                <div class="w-12 h-12 rounded-full border flex items-center justify-center text-lg"
                                     :class="sandboxAttendanceState === 'checked-in' ? 'bg-emerald-50 border-emerald-200 text-emerald-600' : 'bg-slate-100 border-slate-250 text-slate-500'">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 11V5a3 3 0 00-6 0v6c0 1.68.57 3.21 1.52 4.43M12 11c0-3.517 1.009-6.799 2.753-9.571m3.44 2.04l-.054.09A13.916 13.916 0 0015 11v6c0 1.68-.57 3.21-1.52 4.43M12 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                
                                <div>
                                    <span class="text-[9.5px] uppercase font-black text-slate-400 tracking-wider">Terminal Status</span>
                                    <h5 class="text-sm font-bold text-slate-850 mt-0.5" 
                                        x-text="sandboxAttendanceState === 'checked-in' ? 'Successfully Clocked In' : sandboxAttendanceState === 'loading' ? 'Verifying location...' : 'Clocked Out'"></h5>
                                </div>

                                <button @click="toggleSandboxClock()" type="button" 
                                        class="w-full py-3 text-xs font-bold rounded-xl transition-all cursor-pointer inline-flex items-center justify-center gap-2"
                                        :class="sandboxAttendanceState === 'checked-in' ? 'bg-rose-600 hover:bg-rose-700 text-white shadow-md shadow-rose-500/10' : sandboxAttendanceState === 'loading' ? 'bg-slate-300 text-slate-500 cursor-not-allowed' : 'bg-brand-600 hover:bg-brand-700 text-white shadow-md shadow-brand-500/10'"
                                        :disabled="sandboxAttendanceState === 'loading'">
                                    <span class="w-3.5 h-3.5 rounded-full border-2 border-white/20 border-t-white animate-spin" x-show="sandboxAttendanceState === 'loading'"></span>
                                    <span x-text="sandboxAttendanceState === 'checked-in' ? 'Clock Out Now' : sandboxAttendanceState === 'loading' ? 'Locating...' : 'Geo-Clock In Now'"></span>
                                </button>
                            </div>

                            <!-- Right: Terminal Logs -->
                            <div class="sm:col-span-7 flex flex-col gap-3">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Attendance Activity Log</span>
                                <div class="border border-slate-200 rounded-2xl bg-slate-950 p-4.5 font-mono text-[11px] text-slate-350 h-44 overflow-y-auto flex flex-col gap-2.5">
                                    <template x-for="log in sandboxCheckInLogs">
                                        <div class="flex gap-2">
                                            <span class="text-slate-500" x-text="'[' + log.time + ']'"></span>
                                            <span class="text-indigo-300" x-text="log.event"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 3: Payroll Hub -->
                    <div x-show="sandboxTab === 'payroll'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="text-base font-extrabold text-slate-850">Automated Payroll Hub</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Calculate shifts, tax brackets, and trigger pay disbursements.</p>
                            </div>
                            <button @click="runSandboxPayroll()" type="button" 
                                    class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all cursor-pointer inline-flex items-center justify-center gap-2"
                                    :disabled="sandboxPayrollLoading">
                                <span class="w-3.5 h-3.5 rounded-full border-2 border-white/20 border-t-white animate-spin" x-show="sandboxPayrollLoading"></span>
                                <span x-text="sandboxPayrollLoading ? 'Simulating Audit...' : sandboxPayrollGenerated ? 'Recalculate Payroll' : 'Calculate Monthly Payroll'"></span>
                            </button>
                        </div>

                        <!-- Main Screen State: Empty / loading / complete -->
                        <div>
                            <!-- Placeholder Initial State -->
                            <div x-show="!sandboxPayrollLoading && !sandboxPayrollGenerated" class="p-10 border border-dashed border-slate-250 rounded-2xl flex flex-col items-center justify-center text-center">
                                <svg class="w-8 h-8 text-slate-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h5 class="text-xs font-bold text-slate-800">Payroll Calculation Required</h5>
                                <p class="text-[11px] text-slate-500 mt-1 max-w-xs">Run the calculator above to trigger shift audit checks and compile branch payouts.</p>
                            </div>

                            <!-- Loading State -->
                            <div x-show="sandboxPayrollLoading" class="p-10 border border-slate-200 rounded-2xl flex flex-col items-center justify-center text-center bg-slate-50/50">
                                <div class="w-7 h-7 rounded-full border-2 border-brand-600 border-t-transparent animate-spin mb-4"></div>
                                <h5 class="text-xs font-bold text-slate-800">Compiling regional tax tables</h5>
                                <p class="text-[11px] text-slate-500 mt-1">Checking employee locations against legal local allowances...</p>
                            </div>

                            <!-- Generated Table state -->
                            <div x-show="sandboxPayrollGenerated" class="border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between text-xs font-bold text-slate-800">
                                    <span>Compiled Pay Register — Active Period</span>
                                    <span class="text-emerald-600 font-extrabold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disbursed
                                    </span>
                                </div>
                                
                                <div class="divide-y divide-slate-100 bg-white">
                                    <div class="px-4 py-3 flex items-center justify-between gap-4 text-xs">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-brand-100 flex items-center justify-center text-[9px] font-bold text-brand-700">SJ</div>
                                            <span class="font-bold text-slate-800">Sarah Jenkins</span>
                                        </div>
                                        <div class="flex items-center gap-6 font-mono text-[11px]">
                                            <span class="text-slate-450">160h logged</span>
                                            <span class="font-bold text-slate-800">$9,400.00</span>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 flex items-center justify-between gap-4 text-xs">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-[9px] font-bold text-indigo-700">MC</div>
                                            <span class="font-bold text-slate-800">Marcus Chen</span>
                                        </div>
                                        <div class="flex items-center gap-6 font-mono text-[11px]">
                                            <span class="text-slate-450">168h logged</span>
                                            <span class="font-bold text-slate-800">$8,960.00</span>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 flex items-center justify-between gap-4 text-xs">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-violet-100 flex items-center justify-center text-[9px] font-bold text-violet-700">ER</div>
                                            <span class="font-bold text-slate-800">Elena Rostova</span>
                                        </div>
                                        <div class="flex items-center gap-6 font-mono text-[11px]">
                                            <span class="text-slate-450">152h logged</span>
                                            <span class="font-bold text-slate-800">$6,840.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 4: Leaves Manager -->
                    <div x-show="sandboxTab === 'leaves'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Leaves & Time-Off Approvals</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Review, approve, or reject employee leave and PTO requests.</p>
                        </div>

                        <!-- Requests Manager screen -->
                        <div>
                            <!-- Case A: Pending requests -->
                            <div x-show="!sandboxLeavesApproved" class="flex flex-col gap-3.5">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pending Time-Off Actions</span>
                                <div class="p-5 border border-slate-200 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-slate-350 transition-all duration-300">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-full bg-brand-100 border border-brand-200 flex items-center justify-center font-bold text-xs text-brand-700 shrink-0">
                                            SJ
                                        </div>
                                        <div>
                                            <h5 class="text-xs font-bold text-slate-850">Sarah Jenkins • VP Operations</h5>
                                            <p class="text-[10px] font-bold text-brand-600 mt-0.5">Annual PTO Request (5 Business Days)</p>
                                            <p class="text-[10.5px] text-slate-500 mt-1 max-w-md leading-relaxed">
                                                "Requesting annual leave for family travel. Marcus Chen will oversee my active tasks while I am out of office."
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-row sm:flex-col gap-2 shrink-0">
                                        <button @click="sandboxLeavesApproved = true; sandboxLeavesCount = 0" type="button" class="px-4 py-2 bg-emerald-650 hover:bg-emerald-700 text-slate-700 text-xs font-bold rounded-xl cursor-pointer shadow-md shadow-emerald-500/10 transition-all text-center">
                                            Approve Leave
                                        </button>
                                        <button @click="sandboxLeavesApproved = true; sandboxLeavesCount = 0" type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl cursor-pointer transition-all text-center">
                                            Reject Leave
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Case B: Empty / all requests approved -->
                            <div x-show="sandboxLeavesApproved" class="p-10 border border-dashed border-slate-250 rounded-2xl flex flex-col items-center justify-center text-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-50 border border-emerald-250 flex items-center justify-center text-emerald-500 mb-3 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h5 class="text-xs font-bold text-slate-800">All Requests Settled</h5>
                                <p class="text-[11px] text-slate-500 mt-1 max-w-xs">No pending leave requests require action at this time.</p>
                                <button @click="sandboxLeavesApproved = false; sandboxLeavesCount = 1" type="button" class="mt-4 px-3 py-1.5 bg-slate-900 text-white font-bold text-[10.5px] rounded-lg cursor-pointer">
                                    Reset Requests
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 5: Salary Slips -->
                    <div x-show="sandboxTab === 'slips'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Digital Salary Slips</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Select a team member to generate, inspect, and sign digital salary slips.</p>
                        </div>

                        <!-- Selector & Preview Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <!-- Left panel: Employee selection list -->
                            <div class="md:col-span-5 flex flex-col gap-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Select Employee</span>
                                <div class="flex flex-col gap-2">
                                    <template x-for="emp in sandboxEmployees">
                                        <button @click="sandboxSelectedEmpForSlip = emp.name; sandboxSlipSuccess = false" 
                                                type="button" 
                                                class="p-3 text-left border rounded-2xl flex items-center justify-between transition-all duration-200 cursor-pointer"
                                                :class="sandboxSelectedEmpForSlip === emp.name ? 'border-brand-500 bg-brand-50/30' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                            <div class="flex items-center gap-2.5">
                                                <img :src="emp.avatar" class="w-8 h-8 rounded-full border border-slate-200 object-cover">
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-bold text-slate-850" x-text="emp.name"></span>
                                                    <span class="text-[10px] text-slate-450 mt-0.5" x-text="emp.role"></span>
                                                </div>
                                            </div>
                                            <svg x-show="sandboxSelectedEmpForSlip === emp.name" class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <!-- Right panel: Interactive glass payslip preview -->
                            <div class="md:col-span-7 flex flex-col gap-3">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Active Slip Preview</span>
                                <div class="border border-slate-200 rounded-2xl bg-slate-50/50 p-5 flex flex-col justify-between min-h-64 relative overflow-hidden">
                                    
                                    <!-- Payslip Branding & Header -->
                                    <div class="flex items-start justify-between border-b border-slate-200/80 pb-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-black text-slate-800 tracking-tight">WORKNEST CORP.</span>
                                            <span class="text-[9px] text-slate-450 font-mono mt-0.5">PAY PERIOD: MAY 2026</span>
                                        </div>
                                        <span class="px-2.5 py-1 text-[8.5px] font-bold rounded-lg uppercase tracking-wider"
                                              :class="sandboxSlipSuccess ? 'bg-emerald-50 text-emerald-700 border border-emerald-250 animate-bounce' : 'bg-slate-100 text-slate-600 border border-slate-200/60'">
                                            <span x-text="sandboxSlipSuccess ? 'Signed & Disbursed' : 'Draft / Unsigned'"></span>
                                        </span>
                                    </div>

                                    <!-- Employee details & breakdown -->
                                    <div class="py-4 flex flex-col gap-3.5">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500">Employee Name:</span>
                                            <span class="font-bold text-slate-850" x-text="sandboxSelectedEmpForSlip"></span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-slate-500">Hourly logs:</span>
                                            <span class="font-bold text-slate-850 font-mono" x-text="sandboxSelectedEmpForSlip === 'Sarah Jenkins' ? '160 hours' : sandboxSelectedEmpForSlip === 'Marcus Chen' ? '168 hours' : '152 hours'"></span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs border-t border-dashed border-slate-200 pt-3">
                                            <span class="font-bold text-slate-700">Gross Payout:</span>
                                            <span class="font-extrabold text-slate-900 font-mono" x-text="sandboxSelectedEmpForSlip === 'Sarah Jenkins' ? '$9,400.00' : sandboxSelectedEmpForSlip === 'Marcus Chen' ? '$8,960.00' : '$6,840.00'"></span>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="border-t border-slate-200/80 pt-4 flex items-center justify-end">
                                        <button @click="generateSandboxSlip()" 
                                                type="button" 
                                                class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl cursor-pointer transition-all duration-300 inline-flex items-center gap-2"
                                                :disabled="sandboxSlipGenerating">
                                            <span class="w-3.5 h-3.5 rounded-full border-2 border-white/20 border-t-white animate-spin" x-show="sandboxSlipGenerating"></span>
                                            <svg x-show="!sandboxSlipGenerating && !sandboxSlipSuccess" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span x-text="sandboxSlipGenerating ? 'Signing & compiling...' : sandboxSlipSuccess ? 'Disbursed Successfully' : 'Generate & Sign Payslip'"></span>
                                        </button>
                                    </div>
                                    
                                    <!-- Toast overlay inside panel -->
                                    <div x-show="sandboxSlipSuccess" 
                                         style="display: none;"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-2"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="absolute bottom-4 left-4 right-4 bg-emerald-950 text-emerald-300 text-[10.5px] font-bold py-2.5 px-4 rounded-xl shadow-lg border border-emerald-800 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span>PDF Payslip compiled and signed. Sent to employee workspace.</span>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tab 6: Role Permissions -->
                    <div x-show="sandboxTab === 'permissions'"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display: none;"
                         class="flex flex-col gap-6">
                        
                        <div>
                            <h4 class="text-base font-extrabold text-slate-850">Role Permissions & Governance</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Toggle access rights for different system profiles in this mock organization.</p>
                        </div>

                        <!-- Main Governance Center -->
                        <div class="flex flex-col gap-6">
                            
                            <!-- Role Switcher pills -->
                            <div class="flex border-b border-slate-200 pb-1 gap-4 select-none">
                                <button @click="sandboxSelectedRole = 'admin'" 
                                        type="button" 
                                        class="pb-3 text-xs font-bold relative transition-colors cursor-pointer"
                                        :class="sandboxSelectedRole === 'admin' ? 'text-brand-600' : 'text-slate-500 hover:text-slate-800'">
                                    <span>Administrator</span>
                                    <span x-show="sandboxSelectedRole === 'admin'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-600 rounded-full"></span>
                                </button>
                                <button @click="sandboxSelectedRole = 'manager'" 
                                        type="button" 
                                        class="pb-3 text-xs font-bold relative transition-colors cursor-pointer"
                                        :class="sandboxSelectedRole === 'manager' ? 'text-brand-600' : 'text-slate-500 hover:text-slate-800'">
                                    <span>Manager</span>
                                    <span x-show="sandboxSelectedRole === 'manager'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-600 rounded-full"></span>
                                </button>
                                <button @click="sandboxSelectedRole = 'employee'" 
                                        type="button" 
                                        class="pb-3 text-xs font-bold relative transition-colors cursor-pointer"
                                        :class="sandboxSelectedRole === 'employee' ? 'text-brand-600' : 'text-slate-500 hover:text-slate-800'">
                                    <span>General Employee</span>
                                    <span x-show="sandboxSelectedRole === 'employee'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-600 rounded-full"></span>
                                </button>
                            </div>

                            <!-- Permissions List with Switch Toggles -->
                            <div class="divide-y divide-slate-100 bg-slate-50/30 rounded-2xl border border-slate-200 overflow-hidden">
                                
                                <!-- Permission 1: Payroll calculations -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Access Payroll Calculation Modules</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Allows running payout cycles, auditing tax sheets, and downloading salary register.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'payroll')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].payroll ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].payroll ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                                <!-- Permission 2: Shift log overrides -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Override & Edit Attendance Logs</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Enables overriding employee check-in times, location warnings, and manually writing shift records.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'shifts')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].shifts ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].shifts ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                                <!-- Permission 3: Approve/Reject Leaves -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Approve/Reject Time-off Requests</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Authorizes deciding PTO allocations, medical leave status, and general off-duty sheets.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'leaves')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].leaves ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].leaves ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                                <!-- Permission 4: Configure system settings -->
                                <div class="p-4 flex items-center justify-between gap-4 bg-white">
                                    <div class="flex flex-col max-w-md">
                                        <span class="text-xs font-bold text-slate-850">Modify System Configurations</span>
                                        <span class="text-[10px] text-slate-450 mt-0.5">Enables modifying integration settings, workspace database isolation rules, and metadata structures.</span>
                                    </div>
                                    <button @click="toggleSandboxPermission(sandboxSelectedRole, 'system')"
                                            type="button"
                                            class="w-9 h-5 rounded-full relative transition-colors duration-200 cursor-pointer flex items-center shrink-0"
                                            :class="sandboxPermissions[sandboxSelectedRole].system ? 'bg-brand-600' : 'bg-slate-200'">
                                        <span class="w-4 h-4 rounded-full bg-white shadow-xs transition-transform duration-200 absolute"
                                              :class="sandboxPermissions[sandboxSelectedRole].system ? 'translate-x-4.5' : 'translate-x-0.5'"></span>
                                    </button>
                                </div>

                            </div>

                            <!-- Save indicator alert -->
                            <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-[11px] text-slate-650 flex items-center gap-2.5 font-medium">
                                <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Access rules update instantly in the sandbox playground. Changes are not persisted to database.</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>


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

    <!-- Global Toast Notification UI -->
    <div class="fixed bottom-5 right-5 z-9999 flex flex-col gap-3 pointer-events-none">
        <div x-show="toast.show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="pointer-events-auto flex items-start gap-3 px-4 py-3 bg-white/95 backdrop-blur-md rounded-xl shadow-xl border overflow-hidden max-w-sm"
             :class="{
                'border-emerald-200': toast.type === 'success',
                'border-rose-200': toast.type === 'error',
                'border-amber-200': toast.type === 'warning',
                'border-blue-200': toast.type === 'info'
             }"
             style="display: none;">
             
             <!-- Icon -->
             <div class="shrink-0 mt-0.5">
                 <svg x-show="toast.type === 'success'" class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                 <svg x-show="toast.type === 'error'" style="display: none;" class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                 <svg x-show="toast.type === 'warning'" style="display: none;" class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                 <svg x-show="toast.type === 'info'" style="display: none;" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
             </div>
             
             <!-- Content -->
             <div class="flex-1">
                 <h4 class="text-sm font-bold text-slate-800" x-text="toast.message"></h4>
                 <p x-show="toast.description" x-text="toast.description" class="text-xs text-slate-500 mt-0.5 leading-relaxed"></p>
             </div>
             
             <!-- Close -->
             <button @click="toast.show = false" class="shrink-0 p-1 text-slate-400 hover:text-slate-600 rounded-md hover:bg-slate-100 transition-colors">
                 <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
             </button>
        </div>
    </div>

    <!-- Smart Scroll Button (Professional SaaS Style) -->
    <button 
        x-show="showScrollTop" 
        x-transition:enter="transition ease-[cubic-bezier(0.34,1.56,0.64,1)] duration-500"
        x-transition:enter-start="opacity-0 translate-y-12 scale-50"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-12 scale-50"
        @click="scrollDirection === 'down' ? window.scrollTo({top: document.body.scrollHeight, behavior: 'smooth'}) : window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-8 right-8 z-50 p-3.5 bg-slate-900 text-white rounded-full shadow-lg hover:bg-brand-600 hover:shadow-brand-500/30 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 flex items-center justify-center group cursor-pointer border border-white/10 backdrop-blur-sm"
        aria-label="Smart Scroll"
        style="display: none;"
    >
        <svg :class="scrollDirection === 'down' ? 'rotate-180' : 'rotate-0'" class="w-5 h-5 text-white transition-transform duration-500 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
        </svg>
    </button>
</div>
@endsection