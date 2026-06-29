<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\EmployeeDocumentController as AdminEmployeeDocumentController;
use App\Http\Controllers\Employee\DocumentController as EmployeeDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/dashboard', function () {
    $announcements = \App\Models\Announcement::latest()->take(5)->get();
    return view('dashboard', compact('announcements'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Temporary direct route for testing Admin Dashboard UI without Auth
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Temporary direct route for testing Admin Directory UI without Auth
Route::get('/admin/directory', function () {
    return view('admin.directory');
})->name('admin.directory');

// Temporary direct route for testing Admin Attendance UI without Auth
Route::get('/admin/attendance', function () {
    return view('admin.attendance');
})->name('admin.attendance');

// Temporary direct route for testing Admin Payroll UI without Auth
Route::get('/admin/payroll', function () {
    return view('admin.payroll');
})->name('admin.payroll');

// Temporary direct route for testing Admin Loans UI without Auth
Route::get('/admin/loans', [AdminLoanController::class, 'index'])->name('admin.loans');
Route::post('/admin/loans', [AdminLoanController::class, 'store'])->name('admin.loans.store');

// Temporary direct route for testing Admin Documents UI without Auth
Route::get('/admin/documents', [AdminDocumentController::class, 'index'])->name('admin.documents');
Route::post('/admin/documents', [AdminDocumentController::class, 'store'])->name('admin.documents.store');
Route::patch('/admin/documents/{id}/sign', [AdminDocumentController::class, 'sign'])->name('admin.documents.sign');
Route::patch('/admin/documents/{id}/renew', [AdminDocumentController::class, 'renew'])->name('admin.documents.renew');
Route::delete('/admin/documents/{id}', [AdminDocumentController::class, 'destroy'])->name('admin.documents.destroy');
Route::get('/admin/documents/{id}/preview', [AdminDocumentController::class, 'preview'])->name('admin.documents.preview');
Route::post('/admin/documents/bulk-delete', [AdminDocumentController::class, 'bulkDelete'])->name('admin.documents.bulkDelete');
Route::post('/admin/documents/bulk-download', [AdminDocumentController::class, 'bulkDownload'])->name('admin.documents.bulkDownload');

// Employee KYC Documents
Route::get('/admin/employee-documents', [AdminEmployeeDocumentController::class, 'index'])->name('admin.employee_documents');
Route::post('/admin/employee-documents', [AdminEmployeeDocumentController::class, 'store'])->name('admin.employee_documents.store');
Route::patch('/admin/employee-documents/{id}/verify', [AdminEmployeeDocumentController::class, 'verify'])->name('admin.employee_documents.verify');
Route::patch('/admin/employee-documents/{id}/reject', [AdminEmployeeDocumentController::class, 'reject'])->name('admin.employee_documents.reject');
Route::delete('/admin/employee-documents/{id}', [AdminEmployeeDocumentController::class, 'destroy'])->name('admin.employee_documents.destroy');
Route::get('/admin/employee-documents/{id}/preview', [AdminEmployeeDocumentController::class, 'preview'])->name('admin.employee_documents.preview');

// Temporary direct route for testing Admin Announcements UI without Auth
Route::get('/admin/announcements', [AdminAnnouncementController::class, 'index'])->name('admin.announcements');
Route::post('/admin/announcements', [AdminAnnouncementController::class, 'store'])->name('admin.announcements.store');
Route::delete('/admin/announcements/{id}', [AdminAnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

// Employee Portal Routes
Route::get('/employee/dashboard', function () {
    $announcements = \App\Models\Announcement::latest()->take(5)->get();
    return view('dashboard', compact('announcements'));
})->name('employee.portal');

Route::get('/employee/attendance', function () {
    return view('employee.attendance');
})->name('employee.attendance');

Route::get('/employee/leaves', function () {
    return view('employee.leaves');
})->name('employee.leaves');

Route::get('/employee/tasks', function () {
    return view('employee.tasks');
})->name('employee.tasks');

Route::get('/employee/documents', [EmployeeDocumentController::class, 'index'])->name('employee.documents');
Route::get('/employee/document/{id}/sign', [EmployeeDocumentController::class, 'showSign'])->name('employee.document.sign');
Route::post('/employee/document/{id}/sign', [EmployeeDocumentController::class, 'submitSign'])->name('employee.document.submit_sign');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
