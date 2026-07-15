<?php

namespace App\Exports;

use App\Models\SensorLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SensorLogsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return SensorLog::latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID Log',
            'Waktu Perekaman',
            'Suhu Udara (°C)',
            'Kelembaban Udara (%)',
            'VPD (kPa)',
            'Soil Moisture A (%)',
            'Soil Moisture B (%)',
            'Tegangan Aki (V)',
            'Kapasitas Baterai (%)',
            'Status Kelistrikan Daya'
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->created_at->format('Y-m-d H:i:s'),
            $log->suhu,
            $log->kelembaban_udara,
            $log->vpd,
            $log->kelembaban_tanah_a,
            $log->kelembaban_tanah_b,
            $log->tegangan_aki,
            $log->persentase_aki,
            $log->status_daya
        ];
    }
}