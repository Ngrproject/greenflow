<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_settings', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_tanam')->nullable();
            $table->float('debit_pompa')->default(3.0); 
            $table->integer('mode_sistem')->default(2); 
            
            // --- BATAS OTOMATISASI KIPAS (SUHU & KELEMBABAN) ---
            $table->float('suhu_kipas_on')->default(39.0);    // Kipas menyala jika suhu naik melewati ini
            $table->float('suhu_kipas_off')->default(37.0);   // Kipas mati jika suhu turun ke angka ini
            
            $table->float('lembab_kipas_on')->default(85.0);  // Kipas menyala jika terlalu lembab
            $table->float('lembab_kipas_off')->default(80.0); // Kipas mati jika kelembaban sudah aman
            
            // --- BATAS OTOMATISASI POMPA (TANAH) ---
            $table->integer('tanah_pompa_on')->default(45);   // Pompa menyala saat tanah kering (< 45%)
            $table->integer('tanah_pompa_off')->default(75);  // Pompa mati saat tanah basah (> 75%)
            
            // --- FITUR AUTO RESTART ---
            $table->boolean('auto_restart_status')->default(true); // true = ON, false = OFF
            $table->time('auto_restart_time')->default('05:00:00'); // Waktu default jam 5 pagi
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_settings');
    }
};