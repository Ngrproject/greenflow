<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WateringSchedule;
use App\Models\DeviceSetting;
use Carbon\Carbon;

class JadwalPenyiraman extends Component
{
    // Properti Form Jadwal
    public $hst_mulai, $hst_selesai, $target_ml, $waktu_siram;
    public $jadwals;

    // Properti Form Tanggal Tanam (Membaca ke tabel device_settings)
    public $tanggal_tanam;
    public $hst_berjalan = 0; 

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // 1. Ambil data matriks dari tabel watering_schedules
        $this->jadwals = WateringSchedule::orderBy('hst_mulai')->get();

        // 2. Ambil data tanggal tanam dari rekor pertama tabel device_settings
        $setting = DeviceSetting::first();
        
        if ($setting) {
            $this->tanggal_tanam = $setting->tanggal_tanam;
            
            // 3. Hitung Hari Setelah Tanam (HST) Berjalan jika ada datanya
            if ($setting->tanggal_tanam) {
                $tglTanam = Carbon::parse($setting->tanggal_tanam);
                $hariIni = Carbon::now('Asia/Jakarta'); 
                $this->hst_berjalan = (int) max(1, floor($tglTanam->diffInDays($hariIni)) + 1);
            }
        }
    }

    public function simpanJadwal()
    {
        $this->validate([
            'hst_mulai'   => 'required|numeric',
            'hst_selesai' => 'required|numeric',
            'target_ml'   => 'required|numeric',
            'waktu_siram' => 'required|string', 
        ]);

        // Mengonversi string pisahan koma menjadi array JSON untuk tabel watering_schedules
        $jamArray = array_map('trim', explode(',', $this->waktu_siram));

        // MURNI MENEMBAK KE TABEL watering_schedules (Bebas dari kolom tanggal_tanam)
        WateringSchedule::create([
            'hst_mulai'   => $this->hst_mulai,
            'hst_selesai' => $this->hst_selesai,
            'target_ml'   => $this->target_ml,
            'waktu_siram' => $jamArray,
        ]);

        $this->reset(['hst_mulai', 'hst_selesai', 'target_ml', 'waktu_siram']);
        $this->loadData();
        
        session()->flash('pesan', 'Jadwal berhasil ditambahkan!');
    }

    public function hapusJadwal($id)
    {
        WateringSchedule::find($id)->delete();
        $this->loadData();
    }

    public function simpanTanggalTanam()
    {
        // MURNI MENEMBAK KE TABEL device_settings mengunci ID = 1 sesuai phpMyAdmin
        $setting = DeviceSetting::firstOrCreate(['id' => 1]);
        $setting->update([
            'tanggal_tanam' => $this->tanggal_tanam
        ]);
        
        $this->loadData(); 
        session()->flash('pesan_tanam', 'Tanggal tanam berhasil disinkronkan!');
    }

    public function render()
    {
        return view('livewire.jadwal-penyiraman')->layout('layouts.app');
    }
}