{ 
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
                } else {
                    this.authLoading = false;
                    this.authSubmitted = true;
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 2000);
                }
            })
            .catch(err => {
                this.authLoading = false;
                this.authSubmitted = true;
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);
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
                } else {
                    this.authLoading = false;
                    this.authSubmitted = true;
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 2000);
                }
            })
            .catch(err => {
                this.authLoading = false;
                this.authSubmitted = true;
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);
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
        }, 2400);
    }
}