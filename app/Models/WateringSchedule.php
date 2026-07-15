<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WateringSchedule extends Model
{
    protected $guarded = [];

    // Ini yang akan otomatis mengubah JSON dari database menjadi Array di PHP
    protected $casts = [
        'waktu_siram' => 'array',
    ];
}