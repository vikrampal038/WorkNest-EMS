<x-app-layout>
    <!-- Background Accents -->
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/40 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6 max-w-4xl mx-auto">
        
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Attendance & Time</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Manage your daily shifts and log your work hours.</p>
            </div>
        </div>

        <!-- Interactive Stopwatch Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -top-16 -right-16 w-36 h-36 bg-brand-50 rounded-full blur-xl -z-10 group-hover:scale-110 transition-transform duration-500"></div>
            
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">My Time Card</h2>
                        <p class="text-xs text-slate-500 mt-0.5 font-medium">Shift: 09:00 AM - 06:00 PM</p>
                    </div>
                    <span id="shiftIndicator" class="px-2.5 py-1 text-[10px] font-extrabold tracking-wider bg-slate-100 text-slate-600 rounded-full uppercase">Day Shift</span>
                </div>

                <!-- Status Display -->
                <div class="flex flex-col items-center justify-center my-8 text-center">
                    <div id="stopwatch" class="text-6xl font-black text-slate-900 tracking-tight font-mono mb-3">00:00:00</div>
                    <div class="flex items-center gap-2">
                        <span id="statusIndicatorDot" class="w-3 h-3 bg-rose-500 rounded-full shadow-[0_0_8px_rgba(244,63,94,0.6)] animate-pulse"></span>
                        <span id="statusIndicatorText" class="text-sm font-bold text-slate-500 uppercase tracking-wider">Not Clocked In</span>
                    </div>
                </div>

                <!-- Work Mode Selector -->
                <div class="mb-6 max-w-md mx-auto">
                    <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 text-center">Work Mode</span>
                    <div class="bg-slate-100 p-1.5 rounded-xl flex gap-1 border border-slate-200/40" id="workModeSelector">
                        <button onclick="setWorkMode('Office')" id="modeBtnOffice" class="flex-1 py-2.5 text-xs font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer bg-white text-slate-900 shadow-xs border border-slate-200/50">Office</button>
                        <button onclick="setWorkMode('WFH')" id="modeBtnWFH" class="flex-1 py-2.5 text-xs font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer text-slate-500 hover:text-slate-800">WFH</button>
                        <button onclick="setWorkMode('Field')" id="modeBtnField" class="flex-1 py-2.5 text-xs font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer text-slate-500 hover:text-slate-800">Field Duty</button>
                    </div>
                </div>

                <!-- Field Duty Details Panel -->
                <div id="fieldDutyPanel" class="hidden mb-6 max-w-md mx-auto bg-slate-50 border border-slate-200/60 p-4 rounded-xl transition-all duration-300">
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-2">Client / Site Name</label>
                    <input type="text" id="fieldSiteInput" oninput="updateFieldSiteName(this.value)" placeholder="Enter Visited Site/Client..." class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500" />
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-200/50 text-xs font-bold text-slate-400">
                        <span>GPS Tag:</span>
                        <span class="text-brand-600 flex items-center gap-1 font-mono uppercase font-black">
                            <svg class="w-4 h-4 animate-bounce text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span id="gpsCoordinatesText">19.0760° N, 72.8777° E</span>
                        </span>
                    </div>
                </div>

                <!-- WFH Details Panel -->
                <div id="wfhPanel" class="hidden mb-6 max-w-md mx-auto bg-slate-50 border border-slate-200/60 p-4 rounded-xl transition-all duration-300 flex items-center gap-3">
                    <svg class="w-5 h-5 text-purple-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-xs font-bold text-slate-500 leading-relaxed">Remote clock-in active. Verification tied to registered home IP.</span>
                </div>

                <!-- Punch Actions -->
                <div class="flex flex-col gap-3 max-w-md mx-auto mt-4">
                    <button id="clockBtn" onclick="toggleClock()" class="w-full py-4 rounded-xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-extrabold text-base tracking-wide shadow-md transition-all active:scale-[0.98] cursor-pointer flex items-center justify-center gap-2">
                        <svg id="clockBtnIcon" class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span id="clockBtnText">Clock In</span>
                    </button>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4 mt-8 space-y-3">
                <div class="flex justify-between text-xs font-medium text-slate-400">
                    <span>Work Location:</span>
                    <span id="metaLocationText" class="text-slate-600 font-bold">Unregistered</span>
                </div>
                <div class="flex justify-between text-xs font-medium text-slate-400">
                    <span>Check In Time:</span>
                    <span id="metaCheckInText" class="text-slate-600 font-bold">--:--</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Toast Notification System -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

    @push('scripts')
    <script>
        // --- Caching and Global State ---
        let clockState = 'out'; // 'in' or 'out'
        let elapsedSeconds = 0;
        let stopwatchTimer = null;
        let selectedWorkMode = 'Office';
        let fieldSiteName = '';

        document.addEventListener('DOMContentLoaded', () => {
            initStopwatchState();
        });

        // --- Active Stopwatch Mechanism ---
        function initStopwatchState() {
            const savedState = localStorage.getItem('wn_clock_state');
            const savedStartTime = localStorage.getItem('wn_clock_start_time');
            const savedMode = localStorage.getItem('wn_clock_work_mode') || 'Office';
            const savedSiteName = localStorage.getItem('wn_clock_site_name') || '';

            selectedWorkMode = savedMode;
            fieldSiteName = savedSiteName;

            // Update Work Mode Selector State
            setWorkMode(selectedWorkMode);
            const siteInput = document.getElementById('fieldSiteInput');
            if (siteInput) {
                siteInput.value = fieldSiteName;
            }

            if (savedState === 'in' && savedStartTime) {
                clockState = 'in';
                const startTimeMs = parseInt(savedStartTime, 10);
                elapsedSeconds = Math.floor((Date.now() - startTimeMs) / 1000);
                setClockInUI();
                startStopwatch();
            } else {
                clockState = 'out';
                setClockOutUI();
            }
        }

        function setWorkMode(mode) {
            if (clockState === 'in') return; // Disable changes during clock-in session

            selectedWorkMode = mode;

            const modeBtnOffice = document.getElementById('modeBtnOffice');
            const modeBtnWFH = document.getElementById('modeBtnWFH');
            const modeBtnField = document.getElementById('modeBtnField');
            
            const fieldPanel = document.getElementById('fieldDutyPanel');
            const wfhPanel = document.getElementById('wfhPanel');

            // Reset buttons style
            [modeBtnOffice, modeBtnWFH, modeBtnField].forEach(btn => {
                if (btn) {
                    btn.classList.remove('bg-white', 'text-slate-900', 'shadow-xs', 'border', 'border-slate-200/50');
                    btn.classList.add('text-slate-500', 'hover:text-slate-800');
                }
            });

            // Highlight selected button
            const activeBtn = document.getElementById(`modeBtn${mode === 'Field' ? 'Field' : mode}`);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-500', 'hover:text-slate-800');
                activeBtn.classList.add('bg-white', 'text-slate-900', 'shadow-xs', 'border', 'border-slate-200/50');
            }

            // Slide Panels transitions
            if (mode === 'Field') {
                fieldPanel?.classList.remove('hidden');
                wfhPanel?.classList.add('hidden');
            } else if (mode === 'WFH') {
                fieldPanel?.classList.add('hidden');
                wfhPanel?.classList.remove('hidden');
            } else {
                fieldPanel?.classList.add('hidden');
                wfhPanel?.classList.add('hidden');
            }
        }

        function updateFieldSiteName(val) {
            fieldSiteName = val.trim();
        }

        function setClockInUI() {
            const clockBtn = document.getElementById('clockBtn');
            const clockBtnText = document.getElementById('clockBtnText');
            const clockBtnIcon = document.getElementById('clockBtnIcon');
            const workModeSelector = document.getElementById('workModeSelector');
            const fieldSiteInput = document.getElementById('fieldSiteInput');

            const statusDot = document.getElementById('statusIndicatorDot');
            const statusText = document.getElementById('statusIndicatorText');

            if (clockBtn) {
                clockBtn.classList.remove('from-brand-600', 'to-indigo-600', 'hover:from-brand-700', 'hover:to-indigo-700');
                clockBtn.classList.add('from-rose-600', 'to-pink-600', 'hover:from-rose-700', 'hover:to-pink-700');
                if (clockBtnText) clockBtnText.innerText = "Clock Out";
                if (clockBtnIcon) {
                    clockBtnIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>`;
                }
            }

            // Lock Work Mode buttons during session
            if (workModeSelector) {
                workModeSelector.classList.add('opacity-50', 'pointer-events-none');
            }
            if (fieldSiteInput) {
                fieldSiteInput.disabled = true;
            }

            if (statusDot) {
                statusDot.classList.remove('bg-rose-500');
                statusDot.classList.add('bg-emerald-500', 'shadow-[0_0_8px_rgba(16,185,129,0.6)]');
            }
            if (statusText) {
                statusText.innerText = "Active Work Session";
                statusText.classList.remove('text-slate-500');
                statusText.classList.add('text-emerald-600', 'font-black');
            }

            // Update Meta details on Time Card bottom
            const savedInTime = localStorage.getItem('wn_clock_in_time_str') || new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('metaCheckInText').innerText = savedInTime;
            document.getElementById('metaLocationText').innerText = selectedWorkMode === 'Office' ? 'Office HQ' : (selectedWorkMode === 'WFH' ? 'Home Office' : (fieldSiteName || 'Field Location'));
        }

        function setClockOutUI() {
            const clockBtn = document.getElementById('clockBtn');
            const clockBtnText = document.getElementById('clockBtnText');
            const clockBtnIcon = document.getElementById('clockBtnIcon');
            const workModeSelector = document.getElementById('workModeSelector');
            const fieldSiteInput = document.getElementById('fieldSiteInput');

            const statusDot = document.getElementById('statusIndicatorDot');
            const statusText = document.getElementById('statusIndicatorText');

            if (clockBtn) {
                clockBtn.classList.remove('from-rose-600', 'to-pink-600', 'hover:from-rose-700', 'hover:to-pink-700');
                clockBtn.classList.add('from-brand-600', 'to-indigo-600', 'hover:from-brand-700', 'hover:to-indigo-700');
                if (clockBtnText) clockBtnText.innerText = "Clock In";
                if (clockBtnIcon) {
                    clockBtnIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>`;
                }
            }

            // Unlock Work Mode buttons
            if (workModeSelector) {
                workModeSelector.classList.remove('opacity-50', 'pointer-events-none');
            }
            if (fieldSiteInput) {
                fieldSiteInput.disabled = false;
            }

            if (statusDot) {
                statusDot.classList.remove('bg-emerald-500', 'shadow-[0_0_8px_rgba(16,185,129,0.6)]');
                statusDot.classList.add('bg-rose-500', 'shadow-[0_0_8px_rgba(244,63,94,0.6)]');
            }
            if (statusText) {
                statusText.innerText = "Not Clocked In";
                statusText.classList.remove('text-emerald-600', 'font-black');
                statusText.classList.add('text-slate-500');
            }

            document.getElementById('metaCheckInText').innerText = "--:--";
            document.getElementById('metaLocationText').innerText = "Unregistered";
            document.getElementById('stopwatch').innerText = "00:00:00";
        }

        function toggleClock() {
            if (clockState === 'out') {
                // Clocking In
                clockState = 'in';
                elapsedSeconds = 0;
                const startTime = Date.now();
                localStorage.setItem('wn_clock_state', 'in');
                localStorage.setItem('wn_clock_start_time', startTime.toString());
                localStorage.setItem('wn_clock_work_mode', selectedWorkMode);
                localStorage.setItem('wn_clock_site_name', fieldSiteName);

                const timeString = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                localStorage.setItem('wn_clock_in_time_str', timeString);

                setClockInUI();
                startStopwatch();

                showToast("Success", `Clocked in successfully at ${timeString}!`, "success");
            } else {
                // Clocking Out
                clockState = 'out';
                clearInterval(stopwatchTimer);
                
                const timeString = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                const workHoursStr = formatElapsedHours(elapsedSeconds);

                localStorage.removeItem('wn_clock_state');
                localStorage.removeItem('wn_clock_start_time');
                localStorage.removeItem('wn_clock_work_mode');
                localStorage.removeItem('wn_clock_site_name');
                localStorage.removeItem('wn_clock_in_time_str');

                setClockOutUI();
                showToast("Success", `Clocked out successfully at ${timeString}! (Work Hours: ${workHoursStr})`, "success");
            }
        }

        function startStopwatch() {
            if (stopwatchTimer) clearInterval(stopwatchTimer);
            
            stopwatchTimer = setInterval(() => {
                elapsedSeconds++;
                document.getElementById('stopwatch').innerText = formatStopwatchTime(elapsedSeconds);
            }, 1000);
        }

        function formatStopwatchTime(totalSeconds) {
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;
            return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
        }

        function formatElapsedHours(totalSeconds) {
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            return `${h}h ${m}m`;
        }

        // --- Toast System ---
        function showToast(title, message, type = "success") {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = "flex items-start gap-3 w-80 p-4 bg-white border border-slate-200 rounded-xl shadow-lg pointer-events-auto transform translate-y-4 opacity-0 transition-all duration-300";

            let iconHtml = "";
            if (type === "success") {
                iconHtml = `<div class="w-5 h-5 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>`;
            } else if (type === "info") {
                iconHtml = `<div class="w-5 h-5 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>`;
            }

            toast.innerHTML = `
                ${iconHtml}
                <div class="flex-1">
                    <h5 class="text-xs font-black text-slate-800">${title}</h5>
                    <p class="text-[11px] text-slate-500 mt-0.5 leading-normal">${message}</p>
                </div>
            `;

            container.appendChild(toast);

            // Animate In
            setTimeout(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Animate Out & Remove
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
    </script>
    @endpush
</x-app-layout>
