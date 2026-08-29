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

// =====================================================
// HOME
// =====================================================

Route::get('/', function () {
    return redirect()->route('login');
});


// =====================================================
// AUTHENTICATION
// =====================================================

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);


// =====================================================
// DASHBOARDS
// =====================================================

// RT Dashboard
Route::middleware(['auth', 'checkStatus', 'role:rt'])
    ->get('/rt/dashboard', [DashboardController::class, 'index'])
    ->name('rt.dashboard');

// Warga Dashboard
Route::middleware(['auth', 'checkStatus', 'role:warga', 'has.resident'])
    ->get('/warga/dashboard', [DashboardController::class, 'index'])
    ->name('warga.dashboard');


// =====================================================
// ADMIN ROUTES
// =====================================================

Route::middleware(['auth', 'checkStatus', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // User Management
    Route::get('/akun-pending', [UserController::class, 'pending'])
        ->name('users.pending');

    Route::patch('/akun-setujui/{id}', [UserController::class, 'approve'])
        ->name('users.approve');

    Route::patch('/akun-tolak/{id}', [UserController::class, 'reject'])
        ->name('users.reject');

    Route::get('/users/active', [UserController::class, 'active'])
        ->name('users.active');

    Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])
        ->name('users.export.pdf');

    Route::get('/users/export/excel', [UserController::class, 'exportExcel'])
        ->name('users.export.excel');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');
});


// =====================================================
// RT ROUTES
// =====================================================

Route::middleware(['auth', 'checkStatus', 'role:rt'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | RT - Letter, Complaint, Announcement & Payment
    |--------------------------------------------------------------------------
    */

    Route::prefix('rt')->group(function () {

        // -------------------------------------------------
        // Letters
        // -------------------------------------------------

        Route::get('/letters', [LetterController::class, 'index'])
            ->name('letters.index');

        Route::get('/letters/create', [LetterController::class, 'create'])
            ->name('letters.create');

        Route::post('/letters', [LetterController::class, 'store'])
            ->name('letters.store');

        Route::get('/letters/export/excel', [LetterController::class, 'exportExcel'])
            ->name('letters.export.excel');

        Route::get('/letters/{id}', [LetterController::class, 'show'])
            ->name('letters.show');

        Route::get('/letters/{id}/edit', [LetterController::class, 'edit'])
            ->name('letters.edit');

        Route::put('/letters/{id}', [LetterController::class, 'update'])
            ->name('letters.update');

        Route::delete('/letters/{id}', [LetterController::class, 'destroy'])
            ->name('letters.destroy');

        Route::get('/letters/{id}/print', [LetterController::class, 'print'])
            ->name('letters.print');

        Route::get('/letters/{id}/download', [LetterController::class, 'download'])
            ->name('letters.download');

        Route::post('/letters/{id}/approve', [LetterController::class, 'approve'])
            ->name('letters.approve');

        Route::post('/letters/{id}/reject', [LetterController::class, 'reject'])
            ->name('letters.reject');


        // -------------------------------------------------
        // Complaints
        // -------------------------------------------------

        Route::get('/complaints', [ComplaintController::class, 'index'])
            ->name('complaints.index');

        /*
         * IMPORTANT:
         * /complaints/create must be declared BEFORE
         * /complaints/{complaint}.
         */
        Route::get('/complaints/create', [ComplaintController::class, 'create'])
            ->name('complaints.create');

        Route::post('/complaints', [ComplaintController::class, 'store'])
            ->name('complaints.store');

        Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])
            ->name('complaints.show');

        Route::get('/complaints/{id}/edit', [ComplaintController::class, 'edit'])
            ->name('complaints.edit');

        Route::put('/complaints/{id}', [ComplaintController::class, 'update'])
            ->name('complaints.update');


        // -------------------------------------------------
        // Announcements
        // -------------------------------------------------

        Route::get('/announcements', [AnnouncementController::class, 'index'])
            ->name('announcements.index');

        Route::get('/announcements/create', [AnnouncementController::class, 'create'])
            ->name('announcements.create');

        Route::post('/announcements', [AnnouncementController::class, 'store'])
            ->name('announcements.store');

        Route::get(
            '/announcements/{announcement}/edit',
            [AnnouncementController::class, 'edit']
        )->name('announcements.edit');

        Route::put(
            '/announcements/{announcement}',
            [AnnouncementController::class, 'update']
        )->name('announcements.update');

        Route::delete(
            '/announcements/{announcement}',
            [AnnouncementController::class, 'destroy']
        )->name('announcements.destroy');


        // -------------------------------------------------
        // Payments
        // -------------------------------------------------

        Route::resource('payments', PaymentController::class)
            ->except(['show']);

        Route::post(
            'payments/{payment}/verify',
            [PaymentController::class, 'verify']
        )->name('admin.payments.verify');

        Route::get(
            'payments/laporan',
            [PaymentController::class, 'report']
        )->name('admin.payments.report');

        Route::get(
            'payments/laporan/cetak',
            [PaymentController::class, 'exportPdf']
        )->name('admin.payments.exportPdf');

        Route::get(
            'payments/laporan-jenis',
            [PaymentController::class, 'paymentReport']
        )->name('admin.payments.paymentReport');

        Route::get(
            'payments/laporan-jenis/{type}/pdf',
            [PaymentController::class, 'exportPdfByType']
        )->name('admin.payments.exportPdfByType');

        Route::get(
            'payments/laporan-total/pdf',
            [PaymentController::class, 'exportPdfTotal']
        )->name('admin.payments.exportPdfTotal');
    });


    /*
    |--------------------------------------------------------------------------
    | Resident Management
    |--------------------------------------------------------------------------
    */

    Route::resource('residents', ResidentController::class);

    Route::get(
        'residents/export/pdf',
        [ResidentController::class, 'exportPdf']
    )->name('residents.export.pdf');

    Route::get(
        'residents/export/excel',
        [ResidentController::class, 'exportExcel']
    )->name('residents.export.excel');

    Route::post(
        'residents/import',
        [ResidentController::class, 'importExcel']
    )->name('residents.import.excel');


    /*
    |--------------------------------------------------------------------------
    | Family Approval
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/family-approvals',
        [FamilyApprovalController::class, 'index']
    )->name('family-approvals.index');

    Route::get(
        '/family-approvals/{familyApproval}',
        [FamilyApprovalController::class, 'show']
    )->name('family-approvals.show');

    Route::post(
        '/family-approvals/{familyApproval}/approve',
        [FamilyApprovalController::class, 'approve']
    )->name('family-approvals.approve');

    Route::post(
        '/family-approvals/{familyApproval}/reject',
        [FamilyApprovalController::class, 'reject']
    )->name('family-approvals.reject');
});


// =====================================================
// MIDTRANS CALLBACK
// =====================================================

Route::post(
    '/midtrans/callback',
    [MidtransController::class, 'callback']
);


// =====================================================
// WARGA ROUTES
// =====================================================

Route::middleware(['auth', 'checkStatus', 'role:warga'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Letters
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/letters/create',
        [LetterController::class, 'create']
    )->name('warga.letters.create');

    Route::post(
        '/letters',
        [LetterController::class, 'store']
    )->name('warga.letters.store');

    Route::get(
        '/letters',
        [LetterController::class, 'wargaIndex']
    )->name('warga.letters.index');


    /*
    |--------------------------------------------------------------------------
    | Resident Profile Completion
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/lengkapi-data',
        [ResidentController::class, 'create']
    )->name('warga.residents.create');

    Route::post(
        '/lengkapi-data',
        [ResidentController::class, 'store']
    )->name('warga.residents.store');


    /*
    |--------------------------------------------------------------------------
    | Family Management
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/keluarga',
        [WargaFamilyController::class, 'index']
    )->name('warga.family.index');

    Route::get(
        '/keluarga/tambah',
        [WargaFamilyController::class, 'create']
    )->name('warga.family.create');

    Route::post(
        '/keluarga',
        [WargaFamilyController::class, 'store']
    )->name('warga.family.store');

    Route::get(
        '/keluarga/{resident}/edit',
        [WargaFamilyController::class, 'edit']
    )->name('warga.family.edit');

    Route::put(
        '/keluarga/{resident}',
        [WargaFamilyController::class, 'update']
    )->name('warga.family.update');

    Route::delete(
        '/keluarga/{resident}',
        [WargaFamilyController::class, 'destroy']
    )->name('warga.family.destroy');


    /*
    |--------------------------------------------------------------------------
    | Family Approval Requests
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pengajuan-keluarga',
        [FamilyApprovalController::class, 'myApprovals']
    )->name('family-approvals.my-approvals');

    Route::delete(
        '/family-approvals/{familyApproval}',
        [FamilyApprovalController::class, 'destroy']
    )->name('family-approvals.destroy');


    /*
    |--------------------------------------------------------------------------
    | Warga Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profil',
        [WargaProfileController::class, 'index']
    )->name('warga.profile.index');

    Route::get(
        '/profil/edit',
        [WargaProfileController::class, 'edit']
    )->name('warga.profile.edit');

    Route::put(
        '/profil',
        [WargaProfileController::class, 'update']
    )->name('warga.profile.update');

    Route::get(
        '/profil/ganti-password',
        [WargaProfileController::class, 'changePassword']
    )->name('warga.profile.change-password');

    Route::post(
        '/profil/ganti-password',
        [WargaProfileController::class, 'updatePassword']
    )->name('warga.profile.update-password');


    /*
    |--------------------------------------------------------------------------
    | Complaints
    |--------------------------------------------------------------------------
    |
    | Prefix "warga." pada route name digunakan agar tidak bentrok
    | dengan route complaint milik RT.
    |
    */

    Route::get(
        '/complaints',
        [ComplaintController::class, 'index']
    )->name('warga.complaints.index');

    Route::get(
        '/complaints/create',
        [ComplaintController::class, 'create']
    )->name('warga.complaints.create');

    Route::post(
        '/complaints',
        [ComplaintController::class, 'store']
    )->name('warga.complaints.store');

    Route::get(
        '/complaints/{complaint}',
        [ComplaintController::class, 'show']
    )->name('warga.complaints.show');


    /*
    |--------------------------------------------------------------------------
    | Public Announcements
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pengumuman',
        [AnnouncementController::class, 'indexPublic']
    )->name('announcements.public');


    /*
    |--------------------------------------------------------------------------
    | Payments
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pembayaran-saya',
        [PaymentController::class, 'userIndex']
    )->name('user.payments.index');

    Route::post(
        '/pembayaran/{payment}/upload',
        [PaymentController::class, 'uploadProof']
    )->name('user.payments.upload');

    Route::get(
        '/riwayat-pembayaran',
        [PaymentController::class, 'history']
    )->name('user.payments.history');


    /*
    |--------------------------------------------------------------------------
    | Midtrans Payment
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/midtrans/{payment}/pay',
        [MidtransController::class, 'pay']
    )->name('payments.midtrans');

    Route::get(
        '/midtrans/success',
        [MidtransController::class, 'finish']
    )->name('midtrans.success');

    Route::get(
        '/midtrans/failed',
        [MidtransController::class, 'error']
    )->name('midtrans.failed');

    Route::get(
        '/midtrans/unfinish',
        [MidtransController::class, 'unfinish']
    )->name('midtrans.unfinish');
});