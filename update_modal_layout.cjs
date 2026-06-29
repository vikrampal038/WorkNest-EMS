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
            <!-- Background backdrop -->
            <div id="modalBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" onclick="closeModal()"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    <!-- Modal panel -->
                    <div id="modalPanel" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 sm:my-8 sm:w-full sm:max-w-4xl mx-auto flex flex-col max-h-[90vh]">
                        
                        <!-- Modal Header -->
                        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center shrink-0">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight" id="modalTitle">Employee Details</h3>
                            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-2 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <!-- Modal Body (Form) -->
                        <div class="bg-white overflow-y-auto p-6 flex-1">
                            <form id="employeeForm" class="flex flex-col md:flex-row gap-8">
                                
                                <!-- Left Sidebar: Profile & IDs -->
                                <div class="w-full md:w-1/3 space-y-6">
                                    <div class="flex flex-col items-center p-6 bg-slate-50 border border-slate-100 rounded-xl text-center">
                                        <div class="relative group cursor-pointer mb-4">
                                            <div class="w-24 h-24 rounded-full bg-white border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden group-hover:border-brand-500 transition-colors shadow-sm">
                                                <svg class="w-8 h-8 text-slate-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div class="absolute bottom-0 right-2 w-7 h-7 bg-white rounded-full shadow border border-slate-200 flex items-center justify-center text-slate-600 hover:text-brand-600 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </div>
                                        </div>
                                        <h4 class="text-sm font-bold text-slate-900">Profile Photo</h4>
                                        <p class="text-xs text-slate-500 mt-1">PNG, JPG up to 5MB</p>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Employee ID</label>
                                            <input type="text" readonly value="11" class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-sm text-slate-500 font-bold cursor-not-allowed">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Reference Number</label>
                                            <input type="text" readonly value="EMP-2026-0011" class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-sm text-slate-500 font-bold cursor-not-allowed">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Content: Form Fields -->
                                <div class="w-full md:w-2/3 space-y-6">
                                    
                                    <!-- Section: Basic Info -->
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Basic Information</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">First Name</label>
                                                <input type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="e.g. John">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Last Name</label>
                                                <input type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="e.g. Doe">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                                                <input type="email" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="john.doe@worknest.com">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                                                <input type="tel" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="+91 98765 43210">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Date of Birth</label>
                                                <input type="date" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gender</label>
                                                <select class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white appearance-none">
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section: Employment Info -->
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Employment Details</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Joining Date</label>
                                                <input type="date" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Department</label>
                                                <select class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white appearance-none">
                                                    <option>Engineering</option>
                                                    <option>Design</option>
                                                    <option>Human Resources</option>
                                                    <option>Sales</option>
                                                    <option>Marketing</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Role/Position</label>
                                                <input type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="e.g. Senior Developer">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Employment Type</label>
                                                <select class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white appearance-none">
                                                    <option>Full-Time</option>
                                                    <option>Part-Time</option>
                                                    <option>Contract</option>
                                                    <option>Internship</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section: Additional Info -->
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2 mb-4">Additional Information</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Emergency Contact</label>
                                                <input type="tel" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="Name & Number">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Current Address</label>
                                                <input type="text" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all focus:bg-white" placeholder="Full Address">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 border-t border-slate-100 shrink-0">
                            <button type="button" onclick="closeModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-lg shadow-sm hover:bg-slate-50 transition-colors">
                                Cancel
                            </button>
                            <button type="button" onclick="closeModal()" class="w-full sm:w-auto px-5 py-2.5 bg-brand-600 border border-transparent text-sm font-bold text-white rounded-lg shadow-sm hover:bg-brand-700 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        `;

content = content.substring(0, startIndex) + newModalHTML + content.substring(endIndex);

fs.writeFileSync(file, content);
console.log('Successfully updated the dynamic modal layout');
