<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SensorLog;
use Carbon\Carbon;

class SensorLog1000DataSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan zona waktu Asia/Jakarta agar pas dengan jam lokal laptop
        $baseTime = Carbon::now('Asia/Jakarta');

        // Bersihkan data lama terlebih dahulu agar id mulai dari 1
        SensorLog::truncate();

        echo "Menyuntikkan 1000 data dummy terintegrasi penuh hardware GreenFlow...\n";

        // Nilai acuan awal parameter
        $suhuAwal = 28.5;
        $lembabUdaraAwal = 75.0;
        $soilAAwal = 80;
        $soilBAwal = 82;
        $teganganAkiAwal = 13.5;

        // Lakukan perulangan mundur sebanyak 1000 data (interval per 10 menit)
        for ($i = 999; $i >= 0; $i--) {
            $dataBerjalan = 999 - $i;
            
            // Waktu record mundur 10 menit setiap datanya
            $waktuRecord = (clone $baseTime)->subMinutes($i * 10);
            $jam = $waktuRecord->hour;

            // 1. Simulasi Mikroklimat Makro (Suhu naik di siang hari, turun di malam hari)
            if ($jam >= 6 && $jam <= 14) {
                // Siang hari: suhu merangkak naik, kelembaban udara turun
                $suhu = round($suhuAwal + (($jam - 6) * 1.2) + (rand(-10, 10) * 0.1), 1);
                $lembabUdara = round($lembabUdaraAwal - (($jam - 6) * 2.5) + (rand(-20, 20) * 0.1), 1);
            } else {
                // Sore/Malam hari: suhu turun, kelembaban udara naik
                $suhu = round($suhuAwal + (rand(-10, 10) * 0.1), 1);
                $lembabUdara = round($lembabUdaraAwal + (rand(-20, 20) * 0.1), 1);
            }
            
            // Batasi nilai agar tetap logis
            $suhu = max(24.0, min(42.0, $suhu));
            $lembabUdara = max(40.0, min(95.0, $lembabUdara));

            // 2. Perhitungan Tekanan Defisit (VPD) yang valid secara ilmiah
            $svp = 0.61078 * exp((17.27 * $suhu) / ($suhu + 237.3));
            $avp = $svp * ($lembabUdara / 100.0);
            $vpd = round($svp - $avp, 2);

            // 3. Simulasi Kelembaban Tanah Media (Perlahan mengering, basah kembali saat disiram)
            $soilA = $soilAAwal - ($dataBerjalan % 40) * 0.5 + rand(-1, 1);
            $soilB = $soilBAwal - ($dataBerjalan % 40) * 0.4 + rand(-1, 1);
            
            // Batasi nilai kelembaban tanah (0-100%)
            $soilA = (int)max(40, min(90, $soilA));
            $soilB = (int)max(40, min(90, $soilB));

            // 4. Status Kerja Aktuator Tergantung Kondisi Lingkungan
            $kipasStatus = ($suhu >= 38.0 || $lembabUdara >= 82.0) ? 1 : 0;
            $pompaStatus = ($soilA < 45 || $soilB < 45) ? 1 : 0;

            // 5. Riwayat Progress Kerja SOP Budidaya (Simulasi)
            $penyiramanKe = ($jam >= 7) ? floor($jam / 3) : 0;
            $jamTerakhirSiram = ($penyiramanKe > 0) ? sprintf("%02d:15", ($penyiramanKe * 3)) : "--:--";

            // 6. Simulasi Manajemen Kelistrikan Aki (11.0V - 14.5V)
            if ($jam >= 7 && $jam <= 16) {
                // Jam terik matahari: Pengisian solar panel aktif
                $teganganAki = round(13.2 + (rand(0, 10) * 0.1), 1);
                $statusDaya = 'Solar Panel';
            } else {
                // Malam/Subuh: Menggunakan daya baterai / PLN jika kritis
                $teganganAki = round(12.6 - (($dataBerjalan % 20) * 0.05) + (rand(-1, 1) * 0.05), 1);
                $statusDaya = ($teganganAki < 11.6) ? 'PLN' : 'Baterai';
            }
            $teganganAki = max(11.2, min(14.2, $teganganAki));
            
            // Konversi nilai voltase ke persentase (11.6V = 0%, 12.8V = 100%)
            $teganganInt = round($teganganAki * 100);
            $persentaseAki = (int)max(0, min(100, (($teganganInt - 1160) / (1280 - 1160)) * 100));

            // 7. Informasi Jaringan Wi-Fi Aktual dari ESP32
            $wifiSsid = 'UPB UKM';
            $wifiRssi = rand(-65, -50); // rentang sinyal kuat
            $wifiIp = '192.168.1.150';

            // Simpan Record Log Lengkap ke Database
            SensorLog::create([
                'suhu'               => $suhu,
                'kelembaban_udara'   => $lembabUdara,
                'vpd'                => $vpd,
                'kelembaban_tanah_a' => $soilA,
                'kelembaban_tanah_b' => $soilB,
                'tegangan_aki'       => $teganganAki,
                'persentase_aki'     => $persentaseAki,
                'status_daya'        => $statusDaya,
                'mode_sistem'        => 2, // Mode Terjadwal (SOP) sesuai setting default bawaan
                'kipas_status'       => $kipasStatus,
                'pompa_status'       => $pompaStatus,
                'penyiraman_ke'      => $penyiramanKe,
                'jam_terakhir_siram' => $jamTerakhirSiram,
                'wifi_ssid'          => $wifiSsid,
                'wifi_rssi'          => $wifiRssi,
                'wifi_ip'            => $wifiIp,
                'created_at'         => $waktuRecord,
                'updated_at'         => $waktuRecord,
            ]);
        }

        echo "Berhasil! 1000 data dummy terintegrasi hardware berhasil disimpan ke database.\n";
    }
}