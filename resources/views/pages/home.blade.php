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

    <!-- Component: mobile-drawer -->
    <x-landing.mobile-drawer />


    <!-- Component: hero-section -->
    <x-landing.hero-section />


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



    <!-- Component: features-section -->
    <x-landing.features-section />


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


    <!-- Component: dashboard-preview-section -->
    <x-landing.dashboard-preview-section />


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
                    <div class="relative w-80 h-160 bg-slate-900 rounded-[48px] border-10 border-slate-800 shadow-2xl overflow-hidden group">
                        <!-- Top Notch -->
                        <div class="absolute top-0 inset-x-0 h-6 bg-slate-800 rounded-b-2xl w-120 mx-auto z-20"></div>
                        
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
                            <div class="mx-auto bg-white border border-slate-200 rounded-md h-6 w-1/2 max-w-50 flex items-center justify-center text-[10px] text-slate-400 font-mono">worknest.app/my-portal</div>
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

    <!-- Component: integrations-section -->
    <x-landing.integrations-section />

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

    <!-- Component: pricing-section -->
    <x-landing.pricing-section />


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
                    <div class="flex flex-row lg:flex-col gap-3 overflow-x-auto lg:overflow-x-hidden lg:overflow-y-auto pb-3 lg:pb-0 scrollbar-none lg:scrollbar-premium lg:pr-1 shrink-0 lg:shrink-0 lg:h-66">
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


    <!-- Component: faq-section -->
    <x-landing.faq-section />


    <!-- Component: cta-banner -->
    <x-landing.cta-banner />


    <!-- Component: footer -->
    <x-landing.footer />

    <!-- Component: company-hub-modal -->
    <x-landing.company-hub-modal />

    <!-- Component: resources-drawer -->
    <x-landing.resources-drawer />


    <!-- Component: auth-modal -->
    <x-landing.auth-modal />


    <!-- Component: legal-policies-drawer -->
    <x-landing.legal-policies-drawer />


    <!-- Component: sandbox-modal -->
    <x-landing.sandbox-modal />


    <!-- Component: support-drawer -->
    <x-landing.support-drawer />

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