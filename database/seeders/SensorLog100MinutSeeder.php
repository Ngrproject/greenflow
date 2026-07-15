<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SensorLog;
use Carbon\Carbon;

class SensorLog100MinutSeeder extends Seeder
{
    public function run(): void
    {
        // Paksa basis waktu seeder menggunakan zona Asia/Jakarta agar pas dengan jam laptop
        $baseTime = Carbon::now('Asia/Jakarta');

        // Bersihkan data lama agar pengujian grafik multi-range terhitung akurat dari nol
        SensorLog::truncate();

        echo "Menyuntikkan 100 data dummy tersinkronisasi Jam WIB Laptop (" . $baseTime->format('H:i:s') . ")...\n";

        $suhuAwal = 31.5;         
        $lembabUdaraAwal = 73.0;  
        $soilAAwal = 76;          
        $soilBAwal = 79;
        $teganganAkiAwal = 13.5;  

        for ($i = 99; $i >= 0; $i--) {
            $menitBerjalan = 99 - $i;
            
            // Waktu record mundur per menit menggunakan objek klon waktu Jakarta
            $waktuRecord = (clone $baseTime)->subMinutes($i);

            // Pergerakan fluktuasi iklim makro lambat (sore hari)
            $suhu = round($suhuAwal - ($menitBerjalan * 0.03) + (rand(-1, 1) * 0.05), 1);
            $lembabUdara = round($lembabUdaraAwal + ($menitBerjalan * 0.06) + (rand(-2, 2) * 0.1), 1);

            // Perhitungan nilai VPD presisi
            $svp = 0.61078 * exp((17.27 * $suhu) / ($suhu + 237.3));
            $avp = $svp * ($lembabUdara / 100.0);
            $vpd = round($svp - $avp, 2);

            // Evaporasi air media tanah
            $soilA = round($soilAAwal - ($menitBerjalan * 0.02) + (rand(-1, 1) * 0.1));
            $soilB = round($soilBAwal - ($menitBerjalan * 0.02) + (rand(-1, 1) * 0.1));

            // Simulasi kelembaban melonjak naik setelah durasi siram lewat menit ke-60
            if ($menitBerjalan > 60) {
                $soilA += 6;
                $soilB += 5;
            }
            
            $soilA = constrain($soilA, 0, 100);
            $soilB = constrain($soilB, 0, 100);

            // Simulasi drop tegangan aki mengikuti aturan manajemen hibrida kelistrikan baru
            if ($menitBerjalan <= 45) {
                $teganganAki = round($teganganAkiAwal - ($menitBerjalan * 0.003) + (rand(-1, 1) * 0.02), 1);
            } else {
                $menitPascaSurya = $menitBerjalan - 45;
                $teganganAki = round(13.1 - ($menitPascaSurya * 0.01) + (rand(-1, 1) * 0.02), 1);
            }

            $teganganAki = max(11.2, $teganganAki);
            $persentaseAki = constrain(map(round($teganganAki * 100), 1160, 1280, 0, 100), 0, 100);

            // Kategori daya sinkron aturan voltase baru kamu
            if ($teganganAki > 13.2) {
                $statusDaya = 'Solar Panel';
            } elseif ($teganganAki < 11.6) {
                $statusDaya = 'PLN';
            } else {
                $statusDaya = 'Baterai';
            }

            // SIMPAN DATA (Hanya kolom bawaan migrasi awal kamu agar tidak memicu error)
            SensorLog::create([
                'suhu'               => $suhu,
                'kelembaban_udara'   => $lembabUdara,
                'vpd'                => $vpd,
                'kelembaban_tanah_a' => (int)$soilA,
                'kelembaban_tanah_b' => (int)$soilB,
                'tegangan_aki'       => $teganganAki,
                'persentase_aki'     => (int)$persentaseAki,
                'status_daya'        => $statusDaya,
                'created_at'         => $waktuRecord,
                'updated_at'         => $waktuRecord,
            ]);
        }

        echo "Berhasil! 100 data dummy tersinkronisasi WIB laptop berhasil disimpan.\n";
    }
}

function map($x, $in_min, $in_max, $out_min, $out_max) {
    if (($in_max - $in_min) == 0) return $out_min;
    return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
}
function constrain($value, $min, $max) {
    return max($min, min($max, $value));
}