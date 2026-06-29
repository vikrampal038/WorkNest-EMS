<x-app-layout>
<div x-data="documentsManager()" class="w-full h-full">

    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Company Documents</h1>
            <p class="text-sm font-medium text-slate-500 mt-1">Manage policies, forms, and general compliance documents.</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="openUploadModal()" class="flex items-center gap-2 px-4 py-2.5 bg-brand-600 text-white rounded-xl font-bold text-sm hover:bg-brand-700 hover:shadow-md hover:shadow-brand-500/20 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Upload Document
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Files -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group">
            <div class="absolute inset-0 bg-linear-to-br from-brand-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black tracking-wider text-slate-400 uppercase mb-1">Total Files</p>
                    <h3 class="text-2xl font-black text-slate-900">{{ $totalFiles }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Storage Used -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black tracking-wider text-slate-400 uppercase mb-1">Storage Used</p>
                    <h3 class="text-2xl font-black text-slate-900">{{ $totalStorage }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                </div>
            </div>
        </div>

        <!-- Pending Signatures -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black tracking-wider text-slate-400 uppercase mb-1">Pending Signatures</p>
                    <h3 class="text-2xl font-black text-slate-900">{{ $pendingSigns }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Expiring Soon -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black tracking-wider text-slate-400 uppercase mb-1">Expiring Soon</p>
                    <h3 class="text-2xl font-black text-slate-900">{{ $expiringSoon }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
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
            
            <div class="flex flex-wrap items-center gap-2">
                <!-- Filters -->
                <select x-model="categoryFilter" class="min-w-56 py-2 px-4 bg-slate-50 border border-slate-200/60 rounded-xl text-sm font-bold text-slate-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none appearance-none cursor-pointer">
                    <option value="All">All Categories</option>
                    <option value="Policies">Policies</option>
                    <option value="Templates">Templates</option>
                    <option value="Contracts">Contracts</option>
                    <option value="Forms">Forms</option>
                    <option value="Invoices">Invoices</option>
                    <option value="Marketing Assets">Marketing Assets</option>
                </select>
            </div>
        </div>

        <!-- Files Data Grid -->
        <div class="overflow-x-auto overflow-y-auto custom-scrollbar" style="max-height: 235px;">
            <table class="w-full text-left border-collapse relative">
                <thead class="sticky top-0 z-10 bg-slate-50 shadow-sm">
                    <tr class="border-b border-slate-200">
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Document Name</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Category</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Size</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase">Status</th>
                        <th class="py-3 px-5 text-[10px] font-black tracking-wider text-slate-400 uppercase text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="doc in filteredDocuments" :key="doc.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-3 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 group-hover:text-brand-600 transition-colors cursor-pointer" @click="previewDoc(doc)" x-text="doc.name"></p>
                                        <p class="text-[11px] font-medium text-slate-400 mt-0.5" x-text="'Uploaded ' + new Date(doc.created_at).toLocaleDateString()"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-5">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-[11px] font-bold tracking-wide" x-text="doc.category"></span>
                            </td>
                            <td class="py-3 px-5 text-sm font-medium text-slate-500" x-text="doc.size"></td>
                            <td class="py-3 px-5">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold"
                                     :class="{
                                         'bg-emerald-50 text-emerald-700': doc.status === 'Active',
                                         'bg-rose-50 text-rose-700': doc.status === 'Expiring Soon' || doc.status === 'Archived',
                                         'bg-amber-50 text-amber-700': doc.status === 'Pending Signature'
                                     }">
                                    <div class="w-1.5 h-1.5 rounded-full"
                                         :class="{
                                            'bg-emerald-500': doc.status === 'Active',
                                            'bg-rose-500': doc.status === 'Expiring Soon' || doc.status === 'Archived',
                                            'bg-amber-500': doc.status === 'Pending Signature'
                                         }"></div>
                                    <span x-text="doc.status"></span>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-center">
                                <div class="flex items-center justify-center gap-2 transition-all">
                                    <a :href="`/admin/documents/${doc.id}/preview`" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors" title="Download/Preview File">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                    <button @click.prevent="previewDoc(doc)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-100 hover:text-indigo-700 transition-colors" title="View Document">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
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
                    <h3 class="text-lg font-black text-slate-900">Upload Company Document</h3>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">Add a new policy, form, or general document.</p>
                </div>
                <button @click="closeUploadModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-200/50 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col min-h-0" @submit="validateForm($event)">
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
                    
                        <input type="file" id="fileUpload" name="document_file" class="hidden" @change="handleFileSelect($event)" x-ref="fileInput">
                    
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
                            <label class="block text-[10px] font-black text-slate-400 tracking-wider uppercase mb-2">Category</label>
                            <select name="category" x-model="formData.category" class="w-full py-3 px-4 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none appearance-none">
                                <option value="Policies">Policies</option>
                                <option value="Templates">Templates</option>
                                <option value="Contracts">Contracts</option>
                                <option value="Forms">Forms</option>
                                <option value="Invoices">Invoices</option>
                                <option value="Marketing Assets">Marketing Assets</option>
                                <option value="Other">Other</option>
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

    <!-- Preview Modal -->
    <div x-show="isPreviewOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closePreview()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[95vh] overflow-hidden flex flex-col h-[85vh]">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900" x-text="selectedDoc?.name"></h3>
                        <p class="text-xs font-medium text-slate-500 mt-0.5" x-text="'Version 1.0 • ' + selectedDoc?.size"></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a :href="selectedDoc ? `/admin/documents/${selectedDoc.id}/preview` : '#'" target="_blank" class="px-4 py-2 bg-brand-50 text-brand-600 rounded-lg text-sm font-bold hover:bg-brand-100 transition-colors">
                        Download File
                    </a>
                    <button @click="closePreview()" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-200/50 text-slate-500 hover:bg-slate-200 hover:text-slate-900 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            
            <div class="flex-1 overflow-hidden bg-slate-100/50">
                <template x-if="selectedDoc">
                    <iframe :src="`/admin/documents/${selectedDoc.id}/preview`" class="w-full h-full border-0"></iframe>
                </template>
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
            <p class="text-sm font-medium text-slate-500 mb-6">Are you sure you want to delete <span class="font-bold text-slate-700" x-text="docToDelete?.name"></span>? This action cannot be undone.</p>
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
        Alpine.data('documentsManager', () => ({
            searchQuery: '',
            categoryFilter: 'All',
            isUploadModalOpen: {{ $errors->any() ? 'true' : 'false' }},
            isPreviewOpen: false,
            isDeleteModalOpen: false,
            selectedDoc: null,
            docToDelete: null,
            dragOver: false,
            
            documents: @json($documents),
            
            formData: {
                file: null,
                fileName: '',
                category: 'Policies',
            },

            get filteredDocuments() {
                return this.documents.filter(doc => {
                    const matchesSearch = doc.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const matchesCategory = this.categoryFilter === 'All' || doc.category === this.categoryFilter;
                    return matchesSearch && matchesCategory;
                });
            },
            
            openUploadModal() {
                this.isUploadModalOpen = true;
                this.formData = { file: null, fileName: '', category: 'Policies' };
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
                    alert('Please select a file first before uploading.');
                    return;
                }
            },
            
            previewDoc(doc) {
                this.selectedDoc = doc;
                this.isPreviewOpen = true;
            },

            closePreview() {
                this.isPreviewOpen = false;
                setTimeout(() => { this.selectedDoc = null; }, 300);
            },

            confirmDelete(doc) {
                this.docToDelete = doc;
                this.isDeleteModalOpen = true;
            },
            
            executeDelete() {
                if(!this.docToDelete) return;
                fetch(`/admin/documents/${this.docToDelete.id}`, {
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
