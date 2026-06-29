@extends('layouts.landing')

@section('content')
<div class="min-h-screen bg-slate-50 py-12" x-data="signaturePadComponent()">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('employee.portal') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Portal
                </a>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Sign Document</h1>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Document Info -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm p-6 sticky top-8">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $document->name }}</h3>
                    <p class="text-sm text-slate-500 font-medium mb-6">Please review and provide your signature to acknowledge.</p>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Category</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $document->category }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700">
                                Action Required
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Signature Pad -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200/60 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="text-xl font-bold text-slate-800">Your Signature</h2>
                        <p class="text-sm text-slate-500 mt-1">Draw your signature in the box below</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50 relative">
                            <!-- Canvas for drawing -->
                            <canvas x-ref="signatureCanvas" class="w-full h-64 cursor-crosshair rounded-xl touch-none" @mousedown="startDrawing" @mousemove="draw" @mouseup="stopDrawing" @mouseleave="stopDrawing" @touchstart.prevent="startDrawingTouch" @touchmove.prevent="drawTouch" @touchend.prevent="stopDrawing"></canvas>
                            
                            <div class="absolute bottom-4 right-4">
                                <button @click.prevent="clearPad" type="button" class="px-3 py-1.5 bg-white border border-slate-200 shadow-sm text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-50 transition-colors">
                                    Clear
                                </button>
                            </div>
                        </div>

                        <form id="signForm" action="{{ route('employee.document.submit_sign', $document->id) }}" method="POST" class="mt-8">
                            @csrf
                            <input type="hidden" name="signature" x-ref="signatureInput">
                            
                            <div class="flex items-start gap-3 mb-6">
                                <input type="checkbox" id="agree" required class="mt-1 border-slate-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="agree" class="text-sm text-slate-600 leading-snug">
                                    I agree that this digital signature is the legally binding equivalent of my handwritten signature and I have read the contents of this document.
                                </label>
                            </div>

                            <button @click.prevent="submitSignature" type="submit" class="w-full py-3 px-4 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 shadow-sm transition-colors flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Submit Signature
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('signaturePadComponent', () => ({
            isDrawing: false,
            ctx: null,
            canvas: null,
            lastX: 0,
            lastY: 0,
            isErrorModalOpen: false,
            errorMessage: '',
            
            init() {
                this.canvas = this.$refs.signatureCanvas;
                this.ctx = this.canvas.getContext('2d');
                
                // Set actual internal canvas resolution to match display size for sharp lines
                const rect = this.canvas.getBoundingClientRect();
                this.canvas.width = rect.width;
                this.canvas.height = rect.height;
                
                this.ctx.lineWidth = 3;
                this.ctx.lineCap = 'round';
                this.ctx.lineJoin = 'round';
                this.ctx.strokeStyle = '#0f172a'; // slate-900
                
                // Fill background with white so JPEG conversion works properly
                this.ctx.fillStyle = '#ffffff';
                this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
            },
            
            startDrawing(e) {
                this.isDrawing = true;
                [this.lastX, this.lastY] = [e.offsetX, e.offsetY];
            },
            
            draw(e) {
                if (!this.isDrawing) return;
                this.ctx.beginPath();
                this.ctx.moveTo(this.lastX, this.lastY);
                this.ctx.lineTo(e.offsetX, e.offsetY);
                this.ctx.stroke();
                [this.lastX, this.lastY] = [e.offsetX, e.offsetY];
            },
            
            stopDrawing() {
                this.isDrawing = false;
            },
            
            startDrawingTouch(e) {
                e.preventDefault();
                const touch = e.touches[0];
                const rect = this.canvas.getBoundingClientRect();
                this.isDrawing = true;
                [this.lastX, this.lastY] = [touch.clientX - rect.left, touch.clientY - rect.top];
            },
            
            drawTouch(e) {
                if (!this.isDrawing) return;
                e.preventDefault();
                const touch = e.touches[0];
                const rect = this.canvas.getBoundingClientRect();
                const x = touch.clientX - rect.left;
                const y = touch.clientY - rect.top;
                
                this.ctx.beginPath();
                this.ctx.moveTo(this.lastX, this.lastY);
                this.ctx.lineTo(x, y);
                this.ctx.stroke();
                [this.lastX, this.lastY] = [x, y];
            },
            
            clearPad() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.ctx.fillStyle = '#ffffff';
                this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
            },
            
            showError(msg) {
                this.errorMessage = msg;
                this.isErrorModalOpen = true;
            },
            
            submitSignature() {
                const checkbox = document.getElementById('agree');
                if(!checkbox.checked) {
                    this.showError('Please agree to the terms before submitting.');
                    return;
                }
                
                // Check if canvas is empty (simplified check)
                const blank = document.createElement('canvas');
                blank.width = this.canvas.width;
                blank.height = this.canvas.height;
                const blankCtx = blank.getContext('2d');
                blankCtx.fillStyle = '#ffffff';
                blankCtx.fillRect(0, 0, blank.width, blank.height);
                
                if(this.canvas.toDataURL() === blank.toDataURL()) {
                    this.showError('Please provide your signature.');
                    return;
                }

                // Compress using JPEG to reduce base64 size drastically to prevent PHP temp file buffer errors
                const dataUrl = this.canvas.toDataURL('image/jpeg', 0.5);
                this.$refs.signatureInput.value = dataUrl;
                
                // Submit form
                document.getElementById('signForm').submit();
            }
        }))
    })
</script>
@endsection
