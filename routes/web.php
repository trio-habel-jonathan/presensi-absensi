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
use App\Http\Controllers\Admin\GolonganController;
use App\Http\Controllers\Admin\IzinController;
use App\Http\Controllers\Admin\JenisPegawaiController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PresensiController as AdminPresensiController;
use App\Http\Controllers\Pegawai\PresensiController as PegawaiPresensiController;

use App\Http\Controllers\Admin\ProfilPegawaiController as AdminProfilPegawaiController;
use App\Http\Controllers\Pegawai\ProfilPegawaiController as PegawaiProfilPegawaiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

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
Route::prefix("/dashboard")->group(function() {
	Route::resource('profil_pegawai', AdminProfilPegawaiController::class)->names('profil_pegawai');;
	Route::resource('golongan', GolonganController::class)->names('golongan');
	Route::resource('jenis_pegawai', JenisPegawaiController::class)->names('jenis_pegawai');
	Route::resource('presensi', PresensiController::class)->names('presensi');
	Route::resource('izin', IzinController::class)->names('izin');
});


Route::middleware(['auth'])->prefix('pegawai')->name('pegawai.')->group(function () {
	// Tampilkan profil pegawai milik user login
	Route::get('profil', [PegawaiProfilPegawaiController::class, 'index'])->name('profil.index');

	// Form tambah profil
	Route::get('profil/create', [PegawaiProfilPegawaiController::class, 'create'])->name('profil.create');

    // Simpan data profil baru
    Route::post('profil', [PegawaiProfilPegawaiController::class, 'store'])->name('profil.store');
});
