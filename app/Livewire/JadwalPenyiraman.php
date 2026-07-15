<?php

namespace App\App\Livewire;

namespace App\Livewire;

use Livewire\Component;
use App\Models\WateringSchedule;
use App\Models\DeviceSetting;
use Carbon\Carbon;

class JadwalPenyiraman extends Component
{
    public $hst_mulai, $hst_selesai, $target_ml, $waktu_siram;
    public $jadwals;
    public $tanggal_tanam;
    public $hst_berjalan = 0; // Variabel baru untuk menampung HST Berjalan

    public function mount()
    {
        $this->loadData();
    }

public function loadData()
    {
        // 1. Ambil seluruh daftar jadwal penyiraman diurutkan dari HST terkecil
        $this->jadwals = WateringSchedule::orderBy('hst_mulai')->get();

        // 2. Ambil data pengaturan alat untuk tanggal tanam terbaru
        $setting = DeviceSetting::latest()->first();
        
        if ($setting) {
            $this->tanggal_tanam = $setting->tanggal_tanam;
            
            // 3. Hitung Hari Setelah Tanam (HST) Berjalan secara otomatis
            if ($setting->tanggal_tanam) {
                $tglTanam = Carbon::parse($setting->tanggal_tanam);
                $hariIni = Carbon::now('Asia/Jakarta'); // Kunci di zona waktu lokal
                
                // PERBAIKAN: Gunakan floor() untuk membuang angka desimal di belakang koma
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
            'waktu_siram' => 'required|string', // Contoh input: 07:00, 10:00, 13:00
        ]);

        // Mengubah inputan teks (koma) menjadi format Array untuk disimpan ke JSON
        $jamArray = array_map('trim', explode(',', $this->waktu_siram));

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
        // Menggunakan updateOrCreate agar selalu mengunci rekor pengaturan terbaru alat
        $setting = DeviceSetting::firstOrCreate(['id' => 1]);
        $setting->tanggal_tanam = $this->tanggal_tanam;
        $setting->save();
        
        $this->loadData(); // Reload data untuk langsung menghitung ulang HST Berjalan
        
        session()->flash('pesan_tanam', 'Tanggal tanam berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.jadwal-penyiraman')->layout('layouts.app');
    }
}