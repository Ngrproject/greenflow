<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SensorLog;
use Carbon\Carbon;

class SensorLog100MinutSeeder extends Seeder
{
    public function run(): void
    {
        // PENTING: Menggunakan Carbon::now() agar patokan waktu SELALU jam saat ini di komputermu
        $baseTime = Carbon::now();

        echo "Menyuntikkan 100 data dinamis mengikuti jam aktual sekarang (" . $baseTime->format('H:i') . ")...\n";

        // Nilai acuan awal untuk sore hari
        $suhuAwal = 30.5;         
        $lembabUdaraAwal = 75.0;  
        $soilAAwal = 76;          
        $soilBAwal = 79;
        $teganganAkiAwal = 13.4;  

        for ($i = 99; $i >= 0; $i--) {
            $menitBerjalan = 99 - $i;
            
            // Waktu dikurangi secara dinamis dari menit sekarang ke belakang
            $waktuRecord = (clone $baseTime)->subMinutes($i);

            // Fluktuasi iklim mikro natural
            $suhu = round($suhuAwal - ($menitBerjalan * 0.03) + (rand(-1, 1) * 0.05), 1);
            $lembabUdara = round($lembabUdaraAwal + ($menitBerjalan * 0.05) + (rand(-2, 2) * 0.1), 1);

            // Perhitungan VPD
            $svp = 0.61078 * exp((17.27 * $suhu) / ($suhu + 237.3));
            $avp = $svp * ($lembabUdara / 100.0);
            $vpd = round($svp - $avp, 2);

            // Penurunan kelembaban tanah bertahap
            $soilA = round($soilAAwal - ($menitBerjalan * 0.02) + (rand(-1, 1) * 0.1));
            $soilB = round($soilBAwal - ($menitBerjalan * 0.02) + (rand(-1, 1) * 0.1));

            // Simulasi penyiraman di pertengahan data (menit ke-60)
            if ($menitBerjalan > 60) {
                $soilA += 5;
                $soilB += 4;
            }
            
            $soilA = constrain($soilA, 0, 100);
            $soilB = constrain($soilB, 0, 100);

            // Penurunan tegangan aki sore hari
            if ($menitBerjalan <= 40) {
                $teganganAki = round($teganganAkiAwal - ($menitBerjalan * 0.003) + (rand(-1, 1) * 0.02), 1);
            } else {
                $menitPascaSurya = $menitBerjalan - 40;
                $teganganAki = round(13.1 - ($menitPascaSurya * 0.01) + (rand(-1, 1) * 0.02), 1);
            }

            $teganganAki = max(11.2, $teganganAki);
            $persentaseAki = constrain(map(round($teganganAki * 100), 1160, 1280, 0, 100), 0, 100);

            // Hibrida Kelistrikan
            if ($teganganAki > 13.2) {
                $statusDaya = 'Solar Panel';
            } elseif ($teganganAki < 11.6) {
                $statusDaya = 'PLN';
            } else {
                $statusDaya = 'Baterai';
            }

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

        echo "Berhasil! Data baru sudah sinkron dengan jam " . $baseTime->format('H:i') . ".\n";
    }
}

function map($x, $in_min, $in_max, $out_min, $out_max) {
    if (($in_max - $in_min) == 0) return $out_min;
    return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
}
function constrain($value, $min, $max) {
    return max($min, min($max, $value));
}