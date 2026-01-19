<?php

use App\Http\Controllers\admin\AgamaController;
use App\Http\Controllers\admin\AturanPakaiController;
use App\Http\Controllers\admin\CampaignController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\DeviceController;
use App\Http\Controllers\admin\DiskonController;
use App\Http\Controllers\admin\DosisController;
use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\admin\GolonganDarahController;
use App\Http\Controllers\admin\HubunganPasienController;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\LayananController;
use App\Http\Controllers\admin\LogDiskonController;
use App\Http\Controllers\admin\ObatController;
use App\Http\Controllers\admin\PasienController;
use App\Http\Controllers\admin\PekerjaanController;
use App\Http\Controllers\admin\PendidikanController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\RoomController;
use App\Http\Controllers\admin\SediaanController;
use App\Http\Controllers\admin\UnitController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\WhatsappController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\user\HasilController;
use App\Http\Controllers\user\KasirController;
use App\Http\Controllers\user\LaporanController;
use App\Http\Controllers\user\LogObatController;
use App\Http\Controllers\user\PemeriksaanAwalController;
use App\Http\Controllers\user\PemeriksaanController;
use App\Http\Controllers\user\RegistrasiController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
})->middleware('guest');

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $r) {
    $r->user()->sendEmailVerificationNotification();
    return back()->with('resent', 'Verification link sent ');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $r) {
    $r->fulfill();
    return redirect()->route('dashboard.index')->withNotify('Alamat email anda berhasil diverifikasi.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Auth::routes();

Route::get('/home', function () {
    if(Auth::user()->can('dashboard.read')) {
        return redirect()->route('dashboard-admin.index');
    }

    return redirect()->route('dashboard.index');
});

Route::get('/unassigned-user', function () {
    if(Auth::user()->role_id != null) {
        return redirect()->route('dashboard.index');
    };
    return view('pages.blank');
})->middleware('auth')->name('unassigned.user');

Route::group(['middleware' => ['auth', 'isAssigned']], function () {
    Route::resource('/dashboard', DashboardController::class);

    Route::resource('/pasien', PasienController::class);

    Route::resource('/registrasi', RegistrasiController::class);

    Route::resource('/pemeriksaan-awal', PemeriksaanAwalController::class);

    Route::resource('/pemeriksaan-dokter', PemeriksaanController::class);

    Route::resource('/kasir', KasirController::class);

    Route::resource('/hasil', HasilController::class);

    Route::resource('/laporan', LaporanController::class);
    Route::get('/laporan/invoice/{uuid}', [LaporanController::class, 'invoice'])->name('laporan.invoice');

    Route::group(['prefix' => 'master-data'], function () {
        Route::resource('/user', UserController::class);
        Route::resource('/gender', GenderController::class);
        Route::resource('/role', RoleController::class);
        Route::resource('/room', RoomController::class);
        Route::resource('/agama', AgamaController::class);
        Route::resource('/pendidikan', PendidikanController::class);
        Route::resource('/pekerjaan', PekerjaanController::class);
        Route::resource('/golongan-darah', GolonganDarahController::class);
        Route::resource('/hubungan-pasien', HubunganPasienController::class);
        Route::resource('/device', DeviceController::class);
        Route::resource('/unit', UnitController::class);
        Route::resource('/campaign', CampaignController::class);
        Route::resource('/sediaan', SediaanController::class);
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/dosis', DosisController::class);
        Route::resource('/aturan-pakai', AturanPakaiController::class);
        Route::resource('/permission', PermissionController::class);
    });

    Route::group(['prefix' => 'analisis',], function () {
        Route::resource('/whatsapp', WhatsappController::class);
        Route::resource('/layanan', LayananController::class);
        Route::resource('/obat', ObatController::class);
        Route::resource('/log-obat', LogObatController::class);
        Route::resource('/diskon', DiskonController::class);
        Route::resource('/log-diskon', LogDiskonController::class);
        Route::resource('/dashboard-admin', AdminDashboardController::class);
    });
});
