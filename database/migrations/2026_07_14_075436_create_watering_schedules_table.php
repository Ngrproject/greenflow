<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watering_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('hst_mulai');   // Contoh: 3
            $table->integer('hst_selesai'); // Contoh: 5
            $table->integer('target_ml');   // Contoh: 1250 (Target volume per waktu siram)
            
            // Kolom JSON ini memungkinkan kita menyimpan BANYAK jam dalam 1 baris
            // Contoh isi nanti: ["00:15", "07:00", "10:00", "13:00", "17:00"]
            $table->json('waktu_siram');    
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watering_schedules');
    }
};