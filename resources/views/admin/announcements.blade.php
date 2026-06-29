<x-app-layout>
    <div class="fixed top-0 right-0 -z-10 w-[800px] h-[800px] bg-brand-50/50 rounded-full blur-[120px] mix-blend-multiply pointer-events-none translate-x-1/3 -translate-y-1/4"></div>
    <div class="fixed bottom-0 left-0 -z-10 w-[600px] h-[600px] bg-emerald-50/50 rounded-full blur-[100px] mix-blend-multiply pointer-events-none -translate-x-1/4 translate-y-1/4"></div>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <div class="flex flex-col gap-5 pb-6">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Company Bulletin</h1>
                <p class="text-sm text-slate-500 mt-1 font-medium">Manage announcements and push urgent alerts to employees.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Form to Post -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 h-full">
                    <h3 class="text-lg font-bold text-slate-900 mb-3">New Announcement</h3>
                    <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Title</label>
                            <input type="text" name="title" required class="w-full px-3 py-1.5 text-sm rounded-xl border border-slate-300 focus:ring-brand-500 focus:border-brand-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Content</label>
                            <textarea name="content" required rows="3" class="w-full px-3 py-1.5 text-sm rounded-xl border border-slate-300 focus:ring-brand-500 focus:border-brand-500 bg-white"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1">Type</label>
                            <select name="type" class="w-full px-3 py-1.5 text-sm rounded-xl border border-slate-300 focus:ring-brand-500 focus:border-brand-500 bg-white">
                                <option value="update">General Update</option>
                                <option value="event">Upcoming Event</option>
                                <option value="urgent">Urgent Alert</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Date (Optional)</label>
                                <input type="date" name="date" id="announcement_date" min="{{ date('Y-m-d') }}" onchange="validateTime()" class="w-full px-3 py-1.5 text-sm rounded-xl border border-slate-300 focus:ring-brand-500 focus:border-brand-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 mb-1">Time (Optional)</label>
                                <input type="time" name="time" id="announcement_time" onchange="validateTime()" class="w-full px-3 py-1.5 text-sm rounded-xl border border-slate-300 focus:ring-brand-500 focus:border-brand-500 bg-white">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700 transition-colors mt-2">
                            Publish Announcement
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-full flex flex-col">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 shrink-0">
                        <h3 class="text-lg font-bold text-slate-900">Recent Posts</h3>
                    </div>
                    <div class="p-3 overflow-y-auto custom-scrollbar" style="max-height: 340px;">
                        @if($announcements->isEmpty())
                            <p class="text-sm text-slate-500 text-center py-8">No announcements posted yet.</p>
                        @else
                            <div class="space-y-2.5">
                                @foreach($announcements as $announcement)
                                    <div class="p-3 rounded-xl border border-slate-100 bg-slate-50 flex gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 
                                            @if($announcement->type == 'urgent') bg-rose-100 text-rose-600 
                                            @elseif($announcement->type == 'event') bg-brand-100 text-brand-600 
                                            @else bg-emerald-100 text-emerald-600 @endif">
                                            @if($announcement->type == 'urgent')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            @elseif($announcement->type == 'event')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2">
                                                <div class="truncate">
                                                    <h4 class="text-[13px] font-bold text-slate-900 truncate">{{ $announcement->title }}</h4>
                                                    <p class="text-[11px] text-slate-500">{{ $announcement->created_at->diffForHumans() }}</p>
                                                </div>
                                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            <p class="text-xs text-slate-600 mt-1 whitespace-pre-wrap line-clamp-1">{{ $announcement->content }}</p>
                                            @if($announcement->date)
                                                <div class="mt-1 flex items-center gap-1.5 text-[11px] font-bold text-slate-500">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    {{ \Carbon\Carbon::parse($announcement->date)->format('M d, Y') }} 
                                                    @if($announcement->time) at {{ \Carbon\Carbon::parse($announcement->time)->format('g:i A') }} @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function validateTime() {
            const dateInput = document.getElementById('announcement_date');
            const timeInput = document.getElementById('announcement_time');
            
            if (!dateInput.value) {
                timeInput.min = '';
                return;
            }
            
            const selectedDate = new Date(dateInput.value);
            const today = new Date();
            
            // Because Date input returns YYYY-MM-DD in UTC time, let's normalize today
            const todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
            
            if (dateInput.value === todayStr) {
                const hours = String(today.getHours()).padStart(2, '0');
                const minutes = String(today.getMinutes()).padStart(2, '0');
                const currentTime = `${hours}:${minutes}`;
                timeInput.min = currentTime;
                
                if (timeInput.value && timeInput.value < currentTime) {
                    timeInput.value = currentTime;
                    // Provide visual feedback for validation
                    timeInput.classList.add('border-rose-500', 'ring-rose-500');
                    setTimeout(() => {
                        timeInput.classList.remove('border-rose-500', 'ring-rose-500');
                    }, 1500);
                }
            } else {
                timeInput.min = '';
            }
        }
    </script>
    @endpush
</x-app-layout>
