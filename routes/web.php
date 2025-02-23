<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\admin\DokumenController as AdminDokumenController;
use App\Http\Controllers\superadmin\UserController as SuperadminUserController;
use App\Http\Controllers\superadmin\DokumenController as SuperadminDokumenController;
use App\Http\Controllers\superadmin\ProgramStudiController as SuperadminProdiController;

Route::middleware(['guest', 'no-cache', 'security-header'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

Route::middleware(['auth', 'security-header'])->group(function () {
    Route::get('/logout', [LoginController::class, 'deauthenticate']);
    Route::get('/', [LandingController::class, 'index'])->name('dashboard')->middleware('no-cache');
    Route::get('/daftar-dokumen', [DokumenController::class, 'getDokumen']);
});

Route::prefix('admin')->middleware(['auth', 'is-admin', 'security-header'])->group(function () {
    Route::view('/', 'admin.index');
    Route::resource('/dokumen', AdminDokumenController::class)->parameters(['dokumen' => 'dokumen']);
    Route::resource('/user', AdminUserController::class)->only(['edit', 'update', 'show']);
});

Route::prefix('superadmin')->middleware(['auth', 'is-superadmin', 'security-header'])->group(function () {
    Route::view('/', 'superadmin.index');
    Route::resource('/dokumen', SuperadminDokumenController::class)->parameters(['dokumen' => 'dokumen']);
    Route::resource('/prodi', SuperadminProdiController::class)->parameters(['prodi' => 'prodi'])->except(['show']);
    Route::resource('/user', SuperadminUserController::class)->parameters(['user' => 'user'])->except(['show']);
});