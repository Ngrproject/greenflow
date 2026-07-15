<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WateringSchedule;
use App\Models\DeviceSetting;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class GreenhouseController extends Controller
{
    /**
     * Menerima data sensor dan status perangkat lengkap dari ESP32 (POST)
     * Sinkron 100% dengan main.cpp hardware dan skema tabel sensor_logs baru
     */
    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            // Parameter Fisik Lingkungan & Tanah
            'suhu'               => 'required|numeric',
            'kelembaban_udara'   => 'required|numeric',
            'vpd'                => 'required|numeric',
            'kelembaban_tanah_a' => 'required|integer',
            'kelembaban_tanah_b' => 'required|integer',
            
            // Parameter Manajemen Daya Aki Hybrid
            'tegangan_aki'       => 'required|numeric',
            'persentase_aki'     => 'required|integer',
            'status_daya'        => 'required|string',
            
            // Parameter Status Operasi & Kerja Aktuator Hardware
            'mode_sistem'        => 'required|integer',
            'kipas_status'       => 'required|boolean',
            'pompa_status'       => 'required|boolean',
            
            // Parameter Riwayat Progress Kerja Alat & SOP
            'penyiraman_ke'      => 'required|integer',
            'jam_terakhir_siram' => 'required|string',
            
            // Metrik Informasi Jaringan Wi-Fi Aktual
            'wifi_ssid'          => 'required|string',
            'wifi_rssi'          => 'required|integer',
            'wifi_ip'            => 'required|string',
        ]);

        // Simpan seluruh data log terstruktur ke MySQL database
        $log = SensorLog::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Log data dari hardware ESP32 berhasil disimpan di database GreenFlow!',
            'data_id' => $log->id
        ], 201);
    }

    /**
     * Mengirimkan konfigurasi dan jadwal penyiraman ke ESP32 (GET)
     * Sinkron 100% dengan skema device_settings terbaru kamu
     */
    public function getConfig()
    {
        // Mengambil data pengaturan alat terbaru
        $settings = DeviceSetting::latest()->first();
        
        // Mengambil seluruh daftar jadwal penyiraman
        $schedules = WateringSchedule::orderBy('hst_mulai', 'asc')->get();

        return response()->json([
            'status'    => 'success',
            'timestamp' => now()->toIso8601String(),
            'settings'  => $settings ?? [
                'tanggal_tanam'       => null,
                'debit_pompa'         => 3.0,
                'mode_sistem'         => 2,
                'suhu_kipas_on'       => 39.0,
                'suhu_kipas_off'      => 37.0,
                'lembab_kipas_on'     => 85.0,
                'lembab_kipas_off'    => 80.0,
                'tanah_pompa_on'      => 45,
                'tanah_pompa_off'     => 75,
                'auto_restart_status' => true,
                'auto_restart_time'   => '05:00:00'
            ],
            'schedules' => $schedules
        ], 200);
    }
}