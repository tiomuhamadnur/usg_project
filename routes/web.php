<?php

use App\Http\Controllers\admin\AgamaController;
use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\admin\GolonganDarahController;
use App\Http\Controllers\admin\HubunganPasienController;
use App\Http\Controllers\admin\PasienController;
use App\Http\Controllers\admin\PekerjaanController;
use App\Http\Controllers\admin\PendidikanController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\RoomController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\user\KasirController;
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
    return redirect()->route('dashboard.index');
});


Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('/dashboard', DashboardController::class);

    Route::resource('/user', UserController::class);

    Route::resource('/gender', GenderController::class);

    Route::resource('/role', RoleController::class);

    Route::resource('/room', RoomController::class);

    Route::resource('/agama', AgamaController::class);

    Route::resource('/pendidikan', PendidikanController::class);

    Route::resource('/pekerjaan', PekerjaanController::class);

    Route::resource('/golongan-darah', GolonganDarahController::class);

    Route::resource('/hubungan-pasien', HubunganPasienController::class);

    Route::resource('/pasien', PasienController::class);

    Route::resource('/registrasi', RegistrasiController::class);

    Route::resource('/pemeriksaan-awal', PemeriksaanAwalController::class);

    Route::resource('/pemeriksaan-dokter', PemeriksaanController::class);

    Route::resource('/kasir', KasirController::class);
});
