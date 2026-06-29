<x-app-layout>
<div x-data="employeeDocumentsManager()" class="w-full h-full">

    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Employee KYC Documents</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">Manage employee identity and compliance documents.</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="openUploadModal()" class="flex items-center gap-2 px-4 py-2.5 bg-brand-600 text-white rounded-xl font-bold text-sm hover:bg-brand-700 hover:shadow-md hover:shadow-brand-500/20 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Upload KYC Document
            </button>
        </div>
    </div>

    <!-- Main Content Area: Folders & Files -->
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col">
        <!-- Top Toolbar -->
        <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Search -->
            <div class="relative w-full md:w-64 shrink-0">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input x-model="searchQuery" type="text" placeholder="Search files..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200/60 rounded-xl text-sm font-medium focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all placeholder:text-slate-400">
            </div>
        </div>

        <!-- Files Data Grid -->
        <div class="overflow-x-auto overflow-y-auto custom-scrollbar" style="max-height: 235px;">
            <table class="w-full text-left border-collapse relative">
                <thead class="sticky top-0 z-10 bg-slate-50 shadow-sm">
                    <tr class="border-b border-slate-200">
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Employee</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Document Type</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Upload Date</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Verification Status</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="doc in filteredDocuments" :key="doc.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs" x-text="doc.user ? doc.user.name.substring(0, 2).toUpperCase() : 'NA'"></div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-brand-600 transition-colors" x-text="doc.user ? doc.user.name : 'Unknown Employee'"></p>
                                </div>
                            </td>
                            <td class="py-3 px-5">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-[11px] font-bold tracking-wide" x-text="doc.document_type"></span>
                            </td>
                            <td class="py-3 px-5 text-sm font-medium text-slate-500" x-text="new Date(doc.created_at).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'})"></td>
                            <td class="py-3 px-5">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                                     :class="{
                                         'bg-emerald-50 text-emerald-700': doc.verified_status === 'Verified',
                                         'bg-rose-50 text-rose-700': doc.verified_status === 'Rejected',
                                         'bg-amber-50 text-amber-700': doc.verified_status === 'Pending'
                                     }">
                                    <div class="w-1.5 h-1.5 rounded-full"
                                         :class="{
                                            'bg-emerald-500': doc.verified_status === 'Verified',
                                            'bg-rose-500': doc.verified_status === 'Rejected',
                                            'bg-amber-500': doc.verified_status === 'Pending'
                                         }"></div>
                                    <span x-text="doc.verified_status"></span>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-center">
                                <div class="flex items-center justify-center gap-2 transition-all">
                                    <button x-show="doc.verified_status === 'Pending'" @click.prevent="verifyDoc(doc)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors" title="Verify Document">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    <button x-show="doc.verified_status === 'Pending'" @click.prevent="rejectDoc(doc)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Reject Document">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    <a :href="`/admin/employee-documents/${doc.id}/preview`" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors" title="Download/Preview File">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                    <button @click.prevent="confirmDelete(doc)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 hover:text-rose-700 transition-colors" title="Delete Document">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredDocuments.length === 0">
                        <td colspan="5" class="py-12 text-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-600">No documents found</p>
                            <p class="text-xs font-medium text-slate-400 mt-1">Try adjusting your search or filters.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div x-show="isUploadModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="closeUploadModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Upload KYC Document</h3>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">Add a new KYC file for an employee.</p>
                </div>
                <button @click="closeUploadModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200/50 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('admin.employee_documents.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col min-h-0" @submit="validateForm($event)">
                @csrf
                <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-100 text-red-600 p-4 rounded-xl text-sm font-medium">
                            <p class="font-bold mb-1">Upload failed:</p>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <!-- Drag and Drop Zone -->
                    <div class="mb-6 relative border-2 border-dashed rounded-2xl p-8 flex flex-col items-center justify-center text-center transition-all"
                         :class="dragOver ? 'border-brand-500 bg-brand-50' : 'border-slate-200 bg-slate-50 hover:bg-slate-100'"
                         @dragover.prevent="dragOver = true"
                         @dragleave.prevent="dragOver = false"
                         @drop.prevent="handleDrop($event)">
                    
                        <input type="file" id="fileUpload" name="employee_document_file" class="hidden" @change="handleFileSelect($event)" x-ref="fileInput">
                    
                        <div class="w-14 h-14 bg-white shadow-sm border border-slate-100 rounded-2xl flex items-center justify-center text-brand-600 mb-4 transition-transform" :class="dragOver ? 'scale-110' : ''">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                    
                        <h4 class="text-sm font-bold text-slate-900 mb-1" x-text="formData.fileName || 'Drag & Drop your file here'"></h4>
                        <p class="text-xs font-medium text-slate-500 mb-4" x-show="!formData.fileName">PDF, DOCX, XLSX up to 50MB</p>
                        <p class="text-xs font-bold text-emerald-600 mb-4" x-show="formData.fileName">File Ready to Upload</p>
                    
                        <label for="fileUpload" class="cursor-pointer px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg text-xs font-bold shadow-sm hover:bg-slate-50 transition-colors">
                            Browse Files
                        </label>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-5">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 tracking-wider uppercase mb-2">Document Type</label>
                            <select name="document_type" x-model="formData.document_type" class="w-full py-3 px-4 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none appearance-none">
                                <option value="Aadhar Card">Aadhar Card</option>
                                <option value="PAN Card">PAN Card</option>
                                <option value="Passport">Passport</option>
                                <option value="Education Certificate">Education Certificate</option>
                                <option value="Experience Letter">Experience Letter</option>
                                <option value="Relieving Letter">Relieving Letter</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 tracking-wider uppercase mb-2">Assign to Employee</label>
                            <select name="user_id" x-model="formData.employee" class="w-full py-3 px-4 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none appearance-none">
                                <option value="">-- Select Employee --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3 shrink-0">
                    <button type="button" @click="closeUploadModal()" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-xl font-bold text-sm hover:bg-brand-700 shadow-sm transition-colors">
                        Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Error Modal -->
    <div x-show="isErrorModalOpen" 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="isErrorModalOpen = false"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden flex flex-col p-6 text-center"
             x-transition:enter="transition ease-out duration-300 delay-100"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95">
            
            <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            
            <h3 class="text-xl font-black text-slate-900 mb-2">Action Required</h3>
            <p class="text-sm font-medium text-slate-500 mb-6" x-text="errorMessage"></p>
            
            <div class="flex items-center gap-3 w-full">
                <button @click="isErrorModalOpen = false" class="flex-1 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 shadow-sm transition-colors">
                    Okay, got it
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="isDeleteModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="isDeleteModalOpen = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden flex flex-col p-6 text-center">
            <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-900 mb-2">Delete Document?</h3>
            <p class="text-sm font-medium text-slate-500 mb-6">Are you sure you want to delete this document? This action cannot be undone.</p>
            <div class="flex items-center gap-3 w-full">
                <button @click="isDeleteModalOpen = false" class="flex-1 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">Cancel</button>
                <button @click="executeDelete()" class="flex-1 py-2.5 bg-rose-500 text-white rounded-xl font-bold text-sm hover:bg-rose-600 shadow-sm shadow-rose-500/20 transition-all">Yes, Delete</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('employeeDocumentsManager', () => ({
            searchQuery: '',
            isUploadModalOpen: {{ $errors->any() ? 'true' : 'false' }},
            isErrorModalOpen: false,
            isDeleteModalOpen: false,
            docToDelete: null,
            errorMessage: '',
            dragOver: false,
            
            documents: @json($employeeDocuments),
            
            formData: {
                file: null,
                fileName: '',
                document_type: 'Aadhar Card',
                employee: ''
            },

            get filteredDocuments() {
                return this.documents.filter(doc => {
                    const matchesSearch = doc.user && doc.user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || doc.document_type.toLowerCase().includes(this.searchQuery.toLowerCase());
                    return matchesSearch;
                });
            },
            
            openUploadModal() {
                this.isUploadModalOpen = true;
                this.formData = { file: null, fileName: '', document_type: 'Aadhar Card', employee: '' };
                this.dragOver = false;
            },
            
            closeUploadModal() {
                this.isUploadModalOpen = false;
            },
            
            handleDrop(e) {
                this.dragOver = false;
                if (e.dataTransfer.files.length > 0) {
                    this.$refs.fileInput.files = e.dataTransfer.files;
                    this.formData.file = e.dataTransfer.files[0];
                    this.formData.fileName = this.formData.file.name;
                }
            },
            
            handleFileSelect(e) {
                if (e.target.files.length > 0) {
                    this.formData.file = e.target.files[0];
                    this.formData.fileName = this.formData.file.name;
                }
            },

            validateForm(e) {
                if(!this.formData.fileName) {
                    e.preventDefault();
                    this.errorMessage = 'Please select a file first before uploading.';
                    this.isErrorModalOpen = true;
                    return;
                }
                if(!this.formData.employee) {
                    e.preventDefault();
                    this.errorMessage = 'Please select an employee.';
                    this.isErrorModalOpen = true;
                    return;
                }
            },
            
            verifyDoc(doc) {
                if(confirm('Are you sure you want to mark this document as Verified?')) {
                    fetch(`/admin/employee-documents/${doc.id}/verify`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => window.location.reload());
                }
            },

            rejectDoc(doc) {
                if(confirm('Are you sure you want to mark this document as Rejected?')) {
                    fetch(`/admin/employee-documents/${doc.id}/reject`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => window.location.reload());
                }
            },

            confirmDelete(doc) {
                this.docToDelete = doc;
                this.isDeleteModalOpen = true;
            },
            
            executeDelete() {
                if(!this.docToDelete) return;
                fetch(`/admin/employee-documents/${this.docToDelete.id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => window.location.reload());
            }
        }));
    });
</script>
@endpush
</x-app-layout>
