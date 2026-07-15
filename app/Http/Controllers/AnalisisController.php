<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;
use Illuminate\Http\Request;
use App\Exports\SensorLogsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AnalisisController extends Controller
{
    public function index()
    {
        // Kunci tanggal hari ini berdasarkan zona waktu Asia/Jakarta
        $today = Carbon::today('Asia/Jakarta');

        // PERBAIKAN UTAMA: Ambil log yang tercipta HANYA pada hari ini saja (Reset otomatis jam 12 malam)
        $allLogs = SensorLog::whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();

        // Hitung Rata-rata Harian Dinamis khusus hari ini
        $avgSuhu = $allLogs->count() > 0 ? round($allLogs->avg('suhu'), 1) : 0;
        $avgLembabUdara = $allLogs->count() > 0 ? round($allLogs->avg('kelembaban_udara'), 1) : 0;
        $avgSoilA = $allLogs->count() > 0 ? $allLogs->avg('kelembaban_tanah_a') : 0;
        $avgSoilB = $allLogs->count() > 0 ? $allLogs->avg('kelembaban_tanah_b') : 0;
        $avgLembabTanah = round(($avgSoilA + $avgSoilB) / 2);
        $avgTeganganAki = $allLogs->count() > 0 ? round($allLogs->avg('tegangan_aki'), 1) : 0;

        // Cari Nilai Maksimum dan Minimum Terkalibrasi murni HARI INI dari Database
        $stats = [
            'max_suhu'   => SensorLog::whereDate('created_at', $today)->max('suhu') ?? ($allLogs->first()->suhu ?? 0),
            'min_suhu'   => SensorLog::whereDate('created_at', $today)->min('suhu') ?? ($allLogs->first()->suhu ?? 0),
            'max_lembab' => SensorLog::whereDate('created_at', $today)->max('kelembaban_udara') ?? ($allLogs->first()->kelembaban_udara ?? 0),
            'min_lembab' => SensorLog::whereDate('created_at', $today)->min('kelembaban_udara') ?? ($allLogs->first()->kelembaban_udara ?? 0),
            'max_soil_a' => SensorLog::whereDate('created_at', $today)->max('kelembaban_tanah_a') ?? ($allLogs->first()->kelembaban_tanah_a ?? 0),
            'min_soil_a' => SensorLog::whereDate('created_at', $today)->min('kelembaban_tanah_a') ?? ($allLogs->first()->kelembaban_tanah_a ?? 0),
            'max_soil_b' => SensorLog::whereDate('created_at', $today)->max('kelembaban_tanah_b') ?? ($allLogs->first()->kelembaban_tanah_b ?? 0),
            'min_soil_b' => SensorLog::whereDate('created_at', $today)->min('kelembaban_tanah_b') ?? ($allLogs->first()->kelembaban_tanah_b ?? 0),
            'max_aki'    => SensorLog::whereDate('created_at', $today)->max('tegangan_aki') ?? ($allLogs->first()->tegangan_aki ?? 0),
            'min_aki'    => SensorLog::whereDate('created_at', $today)->min('tegangan_aki') ?? ($allLogs->first()->tegangan_aki ?? 0),
        ];

        // Hitung Proporsi Data Hari ini untuk Donut Chart Kelistrikan
        $countSolar   = SensorLog::whereDate('created_at', $today)->where('status_daya', 'Solar Panel')->count();
        $countBattery = SensorLog::whereDate('created_at', $today)->where('status_daya', 'Baterai')->count();
        $countPln     = SensorLog::whereDate('created_at', $today)->where('status_daya', 'PLN')->count();

        $totalLogs      = $allLogs->count();
        $logsStabil     = $allLogs->where('suhu', '<=', 39.0)->where('kelembaban_udara', '<=', 85.0)->count();
        $skorStabilitas = $totalLogs > 0 ? round(($logsStabil / $totalLogs) * 100) : 100;
        $statusTanaman  = $avgLembabTanah < 45 ? "Perlu Penyiraman" : ($avgSuhu > 39.0 ? "Stres Suhu Tinggi" : "Optimal");

        return view('analisis', compact(
            'avgSuhu', 'avgLembabUdara', 'avgLembabTanah', 'avgTeganganAki', 'skorStabilitas',
            'stats', 'countSolar', 'countBattery', 'countPln', 'statusTanaman'
        ));
    }

    /**
     * API Endpoint untuk mengambil data grafik secara dinamis (AJAX) - FIXED TIMEZONE WITH NEW HARDWARE SKEMA
     */
    public function getFilteredData(Request $request)
    {
        $range = $request->query('range', '1-jam');
        
        // Pastikan pencarian waktu dasar server dikunci di Zona Jakarta (WIB)
        $now = Carbon::now('Asia/Jakarta');
        $query = SensorLog::orderBy('created_at', 'asc');

        switch ($range) {
            case '10-menit':
                $query->where('created_at', '>=', (clone $now)->subMinutes(10));
                break;
            case '1-jam':
                $query->where('created_at', '>=', (clone $now)->subHours(1));
                break;
            case '12-jam':
                $query->where('created_at', '>=', (clone $now)->subHours(12));
                break;
            case '24-jam':
                $query->where('created_at', '>=', (clone $now)->subHours(24));
                break;
            case '1-minggu':
                $query->where('created_at', '>=', (clone $now)->subWeeks(1));
                break;
            case '1-bulan':
                $query->where('created_at', '>=', (clone $now)->subMonths(1));
                break;
        }

        $logs = $query->get();

        $timestamps = []; $suhu = []; $lembab = []; $vpd = [];
        $soilA = []; $soilB = []; $aki = []; $kipas = []; $pompa = [];

        foreach ($logs as $log) {
            $carbonLog = Carbon::parse($log->created_at)->setTimezone('Asia/Jakarta');
            
            $format = in_array($range, ['1-minggu', '1-bulan']) ? 'd M H:i' : 'H:i';
            $timestamps[] = $carbonLog->format($format);
            
            $suhu[]  = $log->suhu;
            $lembab[] = $log->kelembaban_udara;
            $vpd[]   = $log->vpd;
            $soilA[] = $log->kelembaban_tanah_a;
            $soilB[] = $log->kelembaban_tanah_b;
            $aki[]   = $log->tegangan_aki;
            
            $kipas[] = $log->kipas_status ? 1 : 0;
            $pompa[] = $log->pompa_status ? 1 : 0;
        }

        return response()->json([
            'timestamps' => $timestamps,
            'suhu'       => $suhu,
            'lembab'     => $lembab,
            'vpd'        => $vpd,
            'soilA'      => $soilA,
            'soilB'      => $soilB,
            'aki'        => $aki,
            'kipas'      => $kipas,
            'pompa'      => $pompa,
        ]);
    }

    public function downloadExcel()
    {
        return Excel::download(new SensorLogsExport, 'GreenFlow_TimeSeries_Report.xlsx');
    }
}