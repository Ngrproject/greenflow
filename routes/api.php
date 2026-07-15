<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GreenhouseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Endpoint untuk ESP32 mengambil konfigurasi alat & jadwal penyiraman
Route::get('/greenhouse/config', [GreenhouseController::class, 'getConfig']);

// Endpoint untuk ESP32 mengirim log data sensor lengkap
Route::post('/greenhouse/log', [GreenhouseController::class, 'storeLog']);