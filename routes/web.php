<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;


Route::get('/', function () {
	return redirect('/dashboard');
});
// Route::get('/register', [RegisterController::class, 'create'])->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
Route::get('/login', [PageController::class, 'signin'])->name('login');
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
