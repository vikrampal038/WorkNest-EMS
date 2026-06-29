<x-app-layout>
    <!-- Background Accents -->
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/40 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>
    <div class="fixed bottom-0 left-0 -z-10 w-[600px] h-[600px] bg-indigo-50/40 rounded-full blur-[100px] mix-blend-multiply pointer-events-none -translate-x-1/4 translate-y-1/4"></div>

    <div class="flex flex-col gap-6 pb-6 max-w-5xl mx-auto">
        
        <!-- Welcome / Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Employee Self-Service Hub</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium" id="currentDateHeader">Welcome back! Here's an overview of your portal.</p>
            </div>
            <div class="flex gap-2.5">
                <a href="{{ route('employee.leaves') }}" class="px-4 py-2 bg-brand-600 rounded-lg text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Apply for Leave
                </a>
            </div>
        </div>

        <!-- Quick Access Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Attendance -->
            <a href="{{ route('employee.attendance') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-brand-300 hover:shadow-md transition-all flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-sm font-black text-slate-900 group-hover:text-brand-600">Attendance</h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1">Clock In / Out</p>
            </a>
            
            <!-- Leaves -->
            <a href="{{ route('employee.leaves') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-brand-300 hover:shadow-md transition-all flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-sm font-black text-slate-900 group-hover:text-brand-600">Leave Balance</h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1">31 Days Available</p>
            </a>

            <!-- Tasks -->
            <a href="{{ route('employee.tasks') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-brand-300 hover:shadow-md transition-all flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h3 class="text-sm font-black text-slate-900 group-hover:text-brand-600">My Tasks</h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1">4 Pending Tasks</p>
            </a>

            <!-- Documents -->
            <a href="{{ route('employee.documents') }}" class="group bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:border-brand-300 hover:shadow-md transition-all flex flex-col items-center text-center">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-sm font-black text-slate-900 group-hover:text-brand-600">Documents Vault</h3>
                <p class="text-[11px] font-medium text-slate-500 mt-1">Payslips & Policies</p>
            </a>
        </div>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-2">
            
            <!-- Company Bulletin -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                        <div>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Company Bulletin</h2>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Important updates from HR</p>
                        </div>
                        <span class="w-2 h-2 bg-brand-500 rounded-full animate-ping"></span>
                    </div>

                    <!-- Announcements list -->
                    <div class="space-y-4 my-2">
                        @if(isset($announcements) && $announcements->isNotEmpty())
                            @foreach($announcements as $announcement)
                                <div class="p-4 rounded-xl {{ $announcement->type == 'urgent' ? 'bg-rose-50/50 border border-rose-100' : ($announcement->type == 'event' ? 'bg-brand-50/50 border border-brand-100' : 'bg-slate-50 border border-slate-200/60') }}">
                                    <span class="text-[10px] font-black uppercase tracking-wider {{ $announcement->type == 'urgent' ? 'text-rose-600' : ($announcement->type == 'event' ? 'text-brand-600' : 'text-slate-500') }}">
                                        {{ $announcement->type == 'urgent' ? 'Urgent Alert' : ($announcement->type == 'event' ? 'Upcoming Event' : 'General Update') }}
                                    </span>
                                    <h4 class="text-sm font-black text-slate-800 mt-1">{{ $announcement->title }}</h4>
                                    <p class="text-[12px] text-slate-600 mt-1 leading-relaxed">{{ Str::limit($announcement->content, 100) }}</p>
                                    @if($announcement->date)
                                        <p class="text-[11px] font-bold text-slate-500 mt-2">
                                            {{ \Carbon\Carbon::parse($announcement->date)->format('M d, Y') }}
                                            @if($announcement->time) at {{ \Carbon\Carbon::parse($announcement->time)->format('g:i A') }} @endif
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="p-4 bg-slate-50 border border-slate-200/60 rounded-xl text-center">
                                <p class="text-[12px] text-slate-500">No new announcements.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Summary / Upcoming Events -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                        <div>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Upcoming Holidays</h2>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Plan your time off accordingly</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center gap-4 p-3 border border-slate-100 rounded-xl bg-slate-50">
                            <div class="w-12 h-12 bg-white rounded-lg shadow-sm border border-slate-200 flex flex-col items-center justify-center shrink-0">
                                <span class="text-[9px] font-black uppercase text-rose-500 tracking-wider">Aug</span>
                                <span class="text-lg font-black text-slate-900">15</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Independence Day</h4>
                                <p class="text-[11px] font-medium text-slate-500 mt-0.5">National Holiday</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 p-3 border border-slate-100 rounded-xl bg-slate-50">
                            <div class="w-12 h-12 bg-white rounded-lg shadow-sm border border-slate-200 flex flex-col items-center justify-center shrink-0">
                                <span class="text-[9px] font-black uppercase text-amber-500 tracking-wider">Oct</span>
                                <span class="text-lg font-black text-slate-900">02</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Gandhi Jayanti</h4>
                                <p class="text-[11px] font-medium text-slate-500 mt-0.5">National Holiday</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 p-3 border border-slate-100 rounded-xl bg-slate-50">
                            <div class="w-12 h-12 bg-white rounded-lg shadow-sm border border-slate-200 flex flex-col items-center justify-center shrink-0">
                                <span class="text-[9px] font-black uppercase text-indigo-500 tracking-wider">Oct</span>
                                <span class="text-lg font-black text-slate-900">31</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Diwali</h4>
                                <p class="text-[11px] font-medium text-slate-500 mt-0.5">Festival Holiday</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            updateCurrentDate();
        });

        function updateCurrentDate() {
            const dateStr = new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            const dateHeader = document.getElementById('currentDateHeader');
            if (dateHeader) {
                dateHeader.innerText = `${dateStr} • Welcome back! Here's an overview of your portal.`;
            }
        }
    </script>
    @endpush
</x-app-layout>
