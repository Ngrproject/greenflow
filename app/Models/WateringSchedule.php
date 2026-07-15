<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WateringSchedule extends Model
{
    use HasFactory;

    // Nama tabel di database kamu
    protected $table = 'watering_schedules';

    // PERBAIKAN UTAMA: Daftarkan semua kolom agar diizinkan menyimpan data (Mass Assignment)
    protected $fillable = [
        'hst_mulai',
        'hst_selesai',
        'target_ml',
        'waktu_siram'
    ];

    // PERBAIKAN KEDUA: Paksa kolom waktu_siram yang berbentuk array di php menjadi format text JSON di DB
    protected $casts = [
        'waktu_siram' => 'array',
    ];
}