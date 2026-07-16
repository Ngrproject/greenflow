<?php

use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/send-log', function (Request $request) {
    // Validasi data kiriman dari ESP32
    $validated = $request->validate([
        'type' => 'required|string',
        'message' => 'required|string',
    ]);

    // Simpan langsung ke database web
    SystemLog::create([
        'type' => $validated['type'],
        'message' => $validated['message']
    ]);

    return response()->json(['status' => 'success', 'message' => 'Log berhasil disimpan di web!'], 200);
});