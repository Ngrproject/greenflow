<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            // Data Sensor Lingkungan & Tanah
            $table->float('suhu');
            $table->float('kelembaban_udara');
            $table->float('vpd');
            $table->integer('kelembaban_tanah_a');
            $table->integer('kelembaban_tanah_b');
            
            // Data Kelistrikan Aki Hybrid
            $table->float('tegangan_aki');
            $table->integer('persentase_aki');
            $table->string('status_daya'); // Charging, Discharge, PLN

            // Data Status Kerja Hardware Aktuator
            $table->integer('mode_sistem'); // 0: Manual, 1: Otomatis, 2: Terjadwal
            $table->boolean('kipas_status')->default(0); // 0: Mati, 1: Nyala
            $table->boolean('pompa_status')->default(0); // 0: Mati, 1: Nyala

            // Data Riwayat Kerja SOP Budidaya
            $table->integer('penyiraman_ke')->default(0);
            $table->string('jam_terakhir_siram')->default('--:--');

            // Data Informasi Jaringan Aktual
            $table->string('wifi_ssid')->nullable();
            $table->integer('wifi_rssi')->nullable();
            $table->string('wifi_ip')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};