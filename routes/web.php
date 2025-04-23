<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JenisPegawaiController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\Admin\ProfilPegawaiController as AdminProfilPegawaiController;
use App\Http\Controllers\Pegawai\ProfilPegawaiController as PegawaiProfilPegawaiController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
	return redirect('/dashboard');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/login', [AuthController::class, 'login'])->name('login');

route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// Route::get('/register', [RegisterController::class, 'create'])->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
// Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
// Route::get('/reset-password', [ResetPassword::class, 'show'])->name('reset-password');
// Route::post('/reset-password', [ResetPassword::class, 'send'])->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
Route::get('/{page}', [PageController::class, 'index'])->name('page');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// RUTE FITUR ASLI 
Route::prefix("/dashboard")->group(function () {
	Route::get('profil_pegawai', [AdminProfilPegawaiController::class, 'index'])->name('profil_pegawai.index');
	Route::get('profil_pegawai/create', [AdminProfilPegawaiController::class, 'create'])->name('profil_pegawai.create');
	Route::post('profil_pegawai', [AdminProfilPegawaiController::class, 'store'])->name('profil_pegawai.store');
	Route::get('profil_pegawai/{id}', [AdminProfilPegawaiController::class, 'show'])->name('profil_pegawai.show');
	Route::get('profil_pegawai/{id}/edit', [AdminProfilPegawaiController::class, 'edit'])->name('profil_pegawai.edit');
	Route::put('profil_pegawai/{id}', [AdminProfilPegawaiController::class, 'update'])->name('profil_pegawai.update');
	Route::delete('profil_pegawai/{id}', [AdminProfilPegawaiController::class, 'destroy'])->name('profil_pegawai.destroy');


	Route::get('golongan', [GolonganController::class, 'index'])->name('golongan.index');
	Route::get('golongan/create', [GolonganController::class, 'create'])->name('golongan.create');
	Route::post('golongan', [GolonganController::class, 'store'])->name('golongan.store');
	Route::get('golongan/{id}', [GolonganController::class, 'show'])->name('golongan.show');
	Route::get('golongan/{id}/edit', [GolonganController::class, 'edit'])->name('golongan.edit');
	Route::put('golongan/{id}', [GolonganController::class, 'update'])->name('golongan.update');
	Route::delete('golongan/{id}', [GolonganController::class, 'destroy'])->name('golongan.destroy');


	Route::get('jenis_pegawai', [JenisPegawaiController::class, 'index'])->name('jenis_pegawai.index');
	Route::get('jenis_pegawai/create', [JenisPegawaiController::class, 'create'])->name('jenis_pegawai.create');
	Route::post('jenis_pegawai', [JenisPegawaiController::class, 'store'])->name('jenis_pegawai.store');
	Route::get('jenis_pegawai/{id}', [JenisPegawaiController::class, 'show'])->name('jenis_pegawai.show');
	Route::get('jenis_pegawai/{id}/edit', [JenisPegawaiController::class, 'edit'])->name('jenis_pegawai.edit');
	Route::put('jenis_pegawai/{id}', [JenisPegawaiController::class, 'update'])->name('jenis_pegawai.update');
	Route::delete('jenis_pegawai/{id}', [JenisPegawaiController::class, 'destroy'])->name('jenis_pegawai.destroy');


	Route::get('presensi', [PresensiController::class, 'index'])->name('presensi.index');
	Route::get('presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
	Route::post('presensi', [PresensiController::class, 'store'])->name('presensi.store');
	Route::get('presensi/{id}', [PresensiController::class, 'show'])->name('presensi.show');
	Route::get('presensi/{id}/edit', [PresensiController::class, 'edit'])->name('presensi.edit');
	Route::put('presensi/{id}', [PresensiController::class, 'update'])->name('presensi.update');
	Route::delete('presensi/{id}', [PresensiController::class, 'destroy'])->name('presensi.destroy');


	Route::get('izin', [IzinController::class, 'index'])->name('izin.index');
	Route::get('izin/create', [IzinController::class, 'create'])->name('izin.create');
	Route::post('izin', [IzinController::class, 'store'])->name('izin.store');
	Route::get('izin/{id}', [IzinController::class, 'show'])->name('izin.show');
	Route::get('izin/{id}/edit', [IzinController::class, 'edit'])->name('izin.edit');
	Route::put('izin/{id}', [IzinController::class, 'update'])->name('izin.update');
	Route::delete('izin/{id}', [IzinController::class, 'destroy'])->name('izin.destroy');
});


Route::middleware(['auth'])->prefix('pegawai')->name('pegawai.')->group(function () {
	// Tampilkan profil pegawai milik user login
	Route::get('profil', [PegawaiProfilPegawaiController::class, 'index'])->name('profil.index');

	// Form tambah profil
	Route::get('profil/create', [PegawaiProfilPegawaiController::class, 'create'])->name('profil.create');

	// Simpan data profil baru
	Route::post('profil', [PegawaiProfilPegawaiController::class, 'store'])->name('profil.store');
});
