<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

use App\Http\Controllers\DashboardController;

// Ganti Route::view('dashboard', 'dashboard') bawaan dengan ini:
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

use App\Livewire\JadwalPenyiraman;

// Route ini diamankan, hanya bisa dibuka jika pengguna sudah login
Route::get('/jadwal', JadwalPenyiraman::class)->middleware(['auth', 'verified'])->name('jadwal');

use App\Http\Controllers\AnalisisController;

Route::get('/analisis', [AnalisisController::class, 'index'])->middleware(['auth', 'verified'])->name('analisis');
Route::get('/analisis/export', [AnalisisController::class, 'downloadExcel'])->middleware(['auth', 'verified'])->name('analisis.export');
Route::get('/analisis/data', [AnalisisController::class, 'getFilteredData'])->middleware(['auth', 'verified'])->name('analisis.data');

use App\Livewire\HalamanNotifikasi;
Route::get('/notifikasi', HalamanNotifikasi::class)->name('notifikasi')->middleware('auth');

use App\Livewire\DeviceSetting;

// Tambahkan di dalam grup routing aplikasi kamu
Route::get('/pengaturan-alat', DeviceSetting::class)->name('device.setting');

require __DIR__.'/auth.php';
