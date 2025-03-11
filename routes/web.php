<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\admin\DokumenController as AdminDokumenController;
use App\Http\Controllers\admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\superadmin\UserController as SuperadminUserController;
use App\Http\Controllers\superadmin\DokumenController as SuperadminDokumenController;
use App\Http\Controllers\superadmin\SettingController as SuperadminSettingController;
use App\Http\Controllers\superadmin\KategoriController as SuperAdminKategoriController;
use App\Http\Controllers\superadmin\StatistikController as SuperadminStatistikController;
use App\Http\Controllers\superadmin\DepartmentController as SuperadminDepartmentController;

Route::middleware(['guest', 'no-cache', 'security-header'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

Route::middleware(['auth', 'security-header'])->group(function () {
    Route::get('/logout', [LoginController::class, 'deauthenticate']);
    Route::get('/', [LandingController::class, 'index'])->name('dashboard')->middleware('no-cache');
    Route::get('/daftar-dokumen', [DokumenController::class, 'getDokumen']);
    Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show');
    // Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download']);
});

Route::prefix('admin')->middleware(['auth', 'is-admin', 'security-header'])->group(function () {
    Route::view('/', 'admin.index');
    Route::resource('/dokumen', AdminDokumenController::class)->parameters(['dokumen' => 'dokumen'])->names('admin.dokumen');
    Route::resource('/kategori', AdminKategoriController::class)->parameters(['kategori' => 'kategori'])->names('admin.kategori');
    Route::resource('/user', AdminUserController::class)->only(['edit', 'update', 'show']);
});

Route::prefix('superadmin')->middleware(['auth', 'is-superadmin', 'security-header'])->group(function () {
    Route::view('/', 'superadmin.index');
    Route::get('/statistik', [SuperadminStatistikController::class, 'index'])->name('superadmin.statistik');
    Route::resource('/dokumen', SuperadminDokumenController::class)->parameters(['dokumen' => 'dokumen'])->names('superadmin.dokumen');
    Route::resource('/department', SuperadminDepartmentController::class)->parameters(['department' => 'department'])->except(['show'])->names('superadmin.department');
    Route::resource('/kategori', SuperAdminKategoriController::class)->parameters(['kategori' => 'kategori'])->names('superadmin.kategori');
    Route::resource('/user', SuperadminUserController::class)->parameters(['user' => 'user'])->except(['show'])->names('superadmin.user');

    Route::get('/setting', [SuperadminSettingController::class, 'index'])->name('superadmin.setting.index');
    Route::put('/setting', [SuperadminSettingController::class, 'update'])->name('superadmin.setting.update');
});