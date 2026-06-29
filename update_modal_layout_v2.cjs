const fs = require('fs');
const file = 'resources/views/admin/directory.blade.php';
let content = fs.readFileSync(file, 'utf8');

const dynamicModalStart = '<div id="dynamicModal"';
const deleteModalStart = '<!-- Delete Confirmation Modal -->';

const startIndex = content.indexOf(dynamicModalStart);
const endIndex = content.indexOf(deleteModalStart);

if (startIndex === -1 || endIndex === -1) {
    console.error('Could not find modal section');
    process.exit(1);
}

const newModalHTML = `<div id="dynamicModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Premium Glass Backdrop -->
            <div id="modalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity opacity-0" onclick="closeModal()"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 sm:p-6 lg:p-8 text-center">
                    
                    <!-- Modal panel -->
                    <div id="modalPanel" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl ring-1 ring-slate-900/5 transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 w-full max-w-4xl flex flex-col max-h-[85vh]">
                        
                        <!-- Header Section -->
                        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center shrink-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center text-brand-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 tracking-tight" id="modalTitle">Employee Details</h3>
                                    <p class="text-xs text-slate-500 font-medium">Manage employee information, roles, and settings.</p>
                                </div>
                            </div>
                            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 hover:bg-rose-50 p-2 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Body Section -->
                        <div class="flex-1 overflow-y-auto bg-slate-50/30 flex flex-col md:flex-row">
                            
                            <!-- Left Sidebar (Profile & IDs) -->
                            <div class="w-full md:w-[320px] shrink-0 bg-slate-50 border-r border-slate-100 p-6 flex flex-col gap-6">
                                
                                <!-- Profile Photo Area -->
                                <div class="flex flex-col items-center">
                                    <div class="relative group cursor-pointer">
                                        <div class="w-32 h-32 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center overflow-hidden group-hover:border-brand-400 group-hover:ring-4 ring-brand-50 transition-all">
                                            <svg class="w-10 h-10 text-slate-300 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="absolute -bottom-3 -right-3 w-10 h-10 bg-white rounded-xl shadow-md border border-slate-100 flex items-center justify-center text-slate-600 hover:text-brand-600 hover:scale-110 transition-all cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="text-center mt-5">
                                        <h4 class="text-sm font-bold text-slate-900">Upload Photo</h4>
                                        <p class="text-xs text-slate-500 mt-1">Recommended 800x800px</p>
                                    </div>
                                </div>

                                <div class="w-full h-px bg-slate-200/60"></div>

                                <!-- System IDs -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">Employee ID</label>
                                        <div class="flex items-center gap-2 px-3 py-2 bg-slate-100/80 border border-slate-200/60 rounded-lg">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                            <input type="text" readonly value="11" class="w-full bg-transparent text-sm text-slate-600 font-bold focus:outline-none cursor-default">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1.5">System Reference</label>
                                        <div class="flex items-center gap-2 px-3 py-2 bg-slate-100/80 border border-slate-200/60 rounded-lg">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <input type="text" readonly value="EMP-2026-0011" class="w-full bg-transparent text-sm text-slate-600 font-bold focus:outline-none cursor-default">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Content Area (Form Fields) -->
                            <div class="flex-1 p-6 sm:p-8">
                                <form id="employeeForm" class="space-y-8">
                                    
                                    <!-- Personal Details -->
                                    <div>
                                        <div class="flex items-center gap-2 mb-5">
                                            <div class="w-1.5 h-4 bg-brand-500 rounded-full"></div>
                                            <h4 class="text-sm font-bold text-slate-900">Personal Details</h4>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">First Name <span class="text-rose-500">*</span></label>
                                                <input type="text" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. John">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Last Name <span class="text-rose-500">*</span></label>
                                                <input type="text" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. Doe">
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                                                <input type="email" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="john.doe@worknest.com">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Date of Birth</label>
                                                <input type="date" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all text-slate-600">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Gender</label>
                                                <select class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                                    <option value="" disabled selected>Select Gender</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Work Information -->
                                    <div>
                                        <div class="flex items-center gap-2 mb-5">
                                            <div class="w-1.5 h-4 bg-indigo-500 rounded-full"></div>
                                            <h4 class="text-sm font-bold text-slate-900">Work Information</h4>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Department <span class="text-rose-500">*</span></label>
                                                <select class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                                    <option value="" disabled selected>Select Department</option>
                                                    <option>Engineering</option>
                                                    <option>Design</option>
                                                    <option>Human Resources</option>
                                                    <option>Sales</option>
                                                    <option>Marketing</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Role / Position <span class="text-rose-500">*</span></label>
                                                <input type="text" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="e.g. Senior Developer">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Employment Type <span class="text-rose-500">*</span></label>
                                                <select class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 font-medium focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                                                    <option>Full-Time</option>
                                                    <option>Part-Time</option>
                                                    <option>Contract</option>
                                                    <option>Internship</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Joining Date</label>
                                                <input type="date" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all text-slate-600">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div>
                                        <div class="flex items-center gap-2 mb-5">
                                            <div class="w-1.5 h-4 bg-emerald-500 rounded-full"></div>
                                            <h4 class="text-sm font-bold text-slate-900">Contact Information</h4>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Phone Number</label>
                                                <input type="tel" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="+1 (555) 000-0000">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Emergency Contact</label>
                                                <input type="tel" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400" placeholder="Name - Phone Number">
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Current Address</label>
                                                <textarea rows="2" class="w-full px-4 py-2 bg-white border border-slate-200 shadow-sm rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all placeholder:text-slate-400 resize-none" placeholder="Enter full residential address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-white px-6 py-4 border-t border-slate-100 shrink-0 flex items-center justify-between">
                            <p class="text-xs text-slate-500 font-medium hidden sm:block"><span class="text-rose-500">*</span> Indicates required fields</p>
                            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                                <button type="button" onclick="closeModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all">
                                    Cancel
                                </button>
                                <button type="button" onclick="closeModal()" class="w-full sm:w-auto px-6 py-2.5 bg-brand-600 border border-transparent text-sm font-bold text-white rounded-xl shadow-sm hover:bg-brand-700 hover:shadow-md transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Save Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
`;

content = content.substring(0, startIndex) + newModalHTML + content.substring(endIndex);

fs.writeFileSync(file, content);
console.log('Successfully updated the dynamic modal layout');
