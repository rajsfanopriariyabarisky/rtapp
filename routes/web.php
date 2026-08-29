<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LetterController,
    ComplaintController,
    DashboardController,
    Auth\RegisterController,
    Auth\LoginController,
    ResidentController,
    UserController,
    MidtransController,
    AnnouncementController,
    PaymentController,
    WargaFamilyController,
    WargaProfileController,
    FamilyApprovalController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama (Redirect ke login)
Route::get('/', function() {
    return redirect()->route('login');
});

// === AUTH ===
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// === DASHBOARD ===
Route::middleware(['auth', 'checkStatus'])->group(function () {
    Route::get('/rt/dashboard', [DashboardController::class, 'index'])->name('rt.dashboard');
});

// === WARGA ROUTES ===
Route::middleware(['auth', 'checkStatus', 'has.resident'])->get('/warga/dashboard', [DashboardController::class, 'index'])->name('warga.dashboard');

// === ADMIN ROUTES ===
Route::middleware(['auth', 'checkStatus', 'role:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen User
    Route::get('/akun-pending', [UserController::class, 'pending'])->name('users.pending');
    Route::patch('/akun-setujui/{id}', [UserController::class, 'approve'])->name('users.approve');
    Route::patch('/akun-tolak/{id}', [UserController::class, 'reject'])->name('users.reject');
    Route::get('/users/active', [UserController::class, 'active'])->name('users.active');
    Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
    Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// === RT ROUTES ===
Route::middleware(['auth', 'checkStatus', 'role:rt'])->group(function () {
    // Surat Pengantar
    Route::prefix('rt')->middleware(['auth', 'role:rt'])->group(function () {
    Route::get('/letters', [LetterController::class, 'index'])->name('letters.index');
    Route::get('/letters/create', [LetterController::class, 'create'])->name('letters.create');
    Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
    Route::get('/letters/{id}', [LetterController::class, 'show'])->name('letters.show');
    Route::delete('/letters/{id}', [LetterController::class, 'destroy'])->name('letters.destroy');
    Route::get('/letters/{id}/edit', [LetterController::class, 'edit'])->name('letters.edit');
    Route::put('/letters/{id}', [LetterController::class, 'update'])->name('letters.update');
    Route::get('/letters/{id}/print', [LetterController::class, 'print'])->name('letters.print');
    Route::get('/letters/{id}/download', [LetterController::class, 'download'])->name('letters.download');
    Route::post('/letters/{id}/approve', [LetterController::class, 'approve'])->name('letters.approve');
    Route::post('/letters/{id}/reject', [LetterController::class, 'reject'])->name('letters.reject');
    Route::get('/letters/export/excel', [LetterController::class, 'exportExcel'])->name('letters.export.excel');
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{id}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');
    Route::put('/complaints/{id}', [ComplaintController::class, 'update'])->name('complaints.update');
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    Route::resource('payments', PaymentController::class)->except(['show']);
    Route::post('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');
    Route::get('payments/laporan', [PaymentController::class, 'report'])->name('admin.payments.report');
    Route::get('payments/laporan/cetak', [PaymentController::class, 'exportPdf'])->name('admin.payments.exportPdf');
    Route::get('payments/laporan-jenis', [PaymentController::class, 'paymentReport'])->name('admin.payments.paymentReport');
    Route::get('payments/laporan-jenis/{type}/pdf', [PaymentController::class, 'exportPdfByType'])->name('admin.payments.exportPdfByType');
    Route::get('payments/laporan-total/pdf', [PaymentController::class, 'exportPdfTotal'])->name('admin.payments.exportPdfTotal');
});

    // Manajemen Warga (Residents)
    Route::resource('residents', ResidentController::class);
    Route::get('residents/export/pdf', [ResidentController::class, 'exportPdf'])->name('residents.export.pdf');
    Route::get('residents/export/excel', [ResidentController::class, 'exportExcel'])->name('residents.export.excel');
    Route::post('residents/import', [ResidentController::class, 'importExcel'])->name('residents.import.excel');

    // Persetujuan Anggota Keluarga
    Route::get('/family-approvals', [FamilyApprovalController::class, 'index'])->name('family-approvals.index');
    Route::get('/family-approvals/{familyApproval}', [FamilyApprovalController::class, 'show'])->name('family-approvals.show');
    Route::post('/family-approvals/{familyApproval}/approve', [FamilyApprovalController::class, 'approve'])->name('family-approvals.approve');
    Route::post('/family-approvals/{familyApproval}/reject', [FamilyApprovalController::class, 'reject'])->name('family-approvals.reject');
});
Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

// === WARGA ROUTES ===
Route::middleware(['auth', 'checkStatus', 'role:warga'])->group(function () {
    // Ajukan Surat Pengantar
    Route::get('/letters/create', [LetterController::class, 'create'])->name('letters.create');
    Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
    Route::get('/letters', [LetterController::class, 'wargaIndex'])->name('warga.letters.index');

    // Lengkapi data warga
    Route::get('/lengkapi-data', [ResidentController::class, 'create'])->name('residents.create');
    Route::post('/lengkapi-data', [ResidentController::class, 'store'])->name('residents.store');
    Route::get('/edit-data-diri', [ResidentController::class, 'editWarga'])->name('residents.edit-warga');
    Route::put('/edit-data-diri', [ResidentController::class, 'updateWarga'])->name('residents.update-warga');
    
    // Kelola Data Keluarga
    Route::get('/keluarga', [WargaFamilyController::class, 'index'])->name('warga.family.index');
    Route::get('/keluarga/tambah', [WargaFamilyController::class, 'create'])->name('warga.family.create');
    Route::post('/keluarga', [WargaFamilyController::class, 'store'])->name('warga.family.store');
    Route::get('/keluarga/{resident}/edit', [WargaFamilyController::class, 'edit'])->name('warga.family.edit');
    Route::put('/keluarga/{resident}', [WargaFamilyController::class, 'update'])->name('warga.family.update');
    Route::delete('/keluarga/{resident}', [WargaFamilyController::class, 'destroy'])->name('warga.family.destroy');
    
    // Pengajuan Persetujuan Anggota Keluarga
    Route::get('/pengajuan-keluarga', [FamilyApprovalController::class, 'myApprovals'])->name('family-approvals.my-approvals');
    Route::delete('/family-approvals/{familyApproval}', [FamilyApprovalController::class, 'destroy'])->name('family-approvals.destroy');
    
    // Profil Warga
    Route::get('/profil', [WargaProfileController::class, 'index'])->name('warga.profile.index');
    Route::get('/profil/edit', [WargaProfileController::class, 'edit'])->name('warga.profile.edit');
    Route::put('/profil', [WargaProfileController::class, 'update'])->name('warga.profile.update');
    Route::get('/profil/ganti-password', [WargaProfileController::class, 'changePassword'])->name('warga.profile.change-password');
    Route::post('/profil/ganti-password', [WargaProfileController::class, 'updatePassword'])->name('warga.profile.update-password');
    
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');

    Route::get('/pengumuman', [AnnouncementController::class, 'indexPublic'])->name('announcements.public');

    Route::get('/pembayaran-saya', [PaymentController::class, 'userIndex'])->name('user.payments.index');
    Route::post('/pembayaran/{payment}/upload', [PaymentController::class, 'uploadProof'])->name('user.payments.upload');
    Route::get('/riwayat-pembayaran', [PaymentController::class, 'history'])->name('user.payments.history');

    // 💳 Midtrans Payment
    Route::get('/midtrans/{payment}/pay', [MidtransController::class, 'pay'])->name('payments.midtrans');
    Route::get('/midtrans/success', [MidtransController::class, 'finish'])->name('midtrans.success');
    Route::get('/midtrans/failed', [MidtransController::class, 'error'])->name('midtrans.failed');
    Route::get('/midtrans/unfinish', [MidtransController::class, 'unfinish'])->name('midtrans.unfinish');

});
