<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;
use App\Models\DeviceSetting;
use App\Models\WateringSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data sensor paling terakhir (Menangkap semua log live dari ESP32)
        $latestLog = SensorLog::latest()->first();

        // 2. Ambil pengaturan alat aktif (Untuk backup penentuan tanggal tanam)
        $setting = DeviceSetting::latest()->first();

        // 3. Ambil 7 data terakhir untuk grafik analisis tren time-series
        $graphData = SensorLog::latest()->take(7)->get()->reverse();

        $chartTimestamps = []; $chartSuhu = []; $chartLembab = [];
        $chartSoilA = []; $chartSoilB = []; $chartAki = [];

        foreach ($graphData as $data) {
            $chartTimestamps[] = Carbon::parse($data->created_at)->format('H:i');
            $chartSuhu[] = $data->suhu;
            $chartLembab[] = $data->kelembaban_udara;
            $chartSoilA[] = $data->kelembaban_tanah_a;
            $chartSoilB[] = $data->kelembaban_tanah_b;
            $chartAki[] = $data->tegangan_aki;
        }

        // 4. Hitung Usia Tanaman (HST) secara Real-Time berdasarkan tanggal tanam di DB
        $hstSekarang = 1;
        if ($setting && $setting->tanggal_tanam) {
            $tglTanam = Carbon::parse($setting->tanggal_tanam);
            $hstSekarang = max(1, $tglTanam->diffInDays(Carbon::now()) + 1);
        }

        // 5. MENCARI JADWAL YANG DIINPUT USER BERDASARKAN HST SEKARANG
        $jadwalHariIni = WateringSchedule::where('hst_mulai', '<=', $hstSekarang)
            ->where('hst_selesai', '>=', $hstSekarang)
            ->first();

        $targetSiram = $jadwalHariIni ? $jadwalHariIni->target_ml : 250;
        
        // 6. Penentuan Jadwal Selanjutnya Dinamis
        $jadwalSelanjutnya = '--:--';
        if ($jadwalHariIni && is_array($jadwalHariIni->waktu_siram)) {
            $now = Carbon::now();
            $waktuSekarangMenit = ($now->hour * 60) + $now->minute;
            $ditemukan = false;
            $daftarWaktu = $jadwalHariIni->waktu_siram;
            sort($daftarWaktu);

            foreach ($daftarWaktu as $waktu) {
                $parts = explode(':', $waktu);
                $menitJadwal = ($parts[0] * 60) + $parts[1];
                if ($menitJadwal > $waktuSekarangMenit) {
                    $jadwalSelanjutnya = $waktu;
                    $ditemukan = true;
                    break;
                }
            }
            if (!$ditemukan && count($daftarWaktu) > 0) {
                $jadwalSelanjutnya = $daftarWaktu[0] . ' (Besok)';
            }
        }

        // 7. Hitung Min & Max Tegangan Aki Khusus Hari Ini untuk Kebutuhan Dashboard
        $stats = [
            'max_aki' => SensorLog::whereDate('created_at', Carbon::today())->max('tegangan_aki') ?? ($latestLog->tegangan_aki ?? 0),
            'min_aki' => SensorLog::whereDate('created_at', Carbon::today())->min('tegangan_aki') ?? ($latestLog->tegangan_aki ?? 0),
        ];

        // 8. DATA DARI ESP32: Ambil status aktual penyiraman langsung dari rekor database alat
        $penyiramanTerakhir = $latestLog ? $latestLog->jam_terakhir_siram : '--:--';
        $penyiramanKe = $latestLog ? $latestLog->penyiraman_ke : 0;

        return view('dashboard', compact(
            'latestLog', 'setting', 'hstSekarang', 'targetSiram', 'jadwalSelanjutnya', 'stats',
            'penyiramanTerakhir', 'penyiramanKe',
            'chartTimestamps', 'chartSuhu', 'chartLembab', 'chartSoilA', 'chartSoilB', 'chartAki'
        ));
    }
}