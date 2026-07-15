<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DeviceSetting as SettingModel;

class DeviceSetting extends Component
{
    // PROPERTI BARU: Disamakan persis dengan nama kolom di database kamu
    public $debit_pompa; 
    public $suhu_kipas_on, $suhu_kipas_off;
    public $lembab_kipas_on, $lembab_kipas_off;
    public $tanah_pompa_on, $tanah_pompa_off;
    public $auto_restart_status = false;
    public $auto_restart_time;

    // Variabel bantu untuk konversi input kalibrasi di tampilan web
    public $detik_kalibrasi_pompa; 

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $setting = SettingModel::first();
        if ($setting) {
            // Memetakan data sesuai nama kolom database asli kamu
            $this->debit_pompa = $setting->debit_pompa ?? 3.0;
            $this->suhu_kipas_on = $setting->suhu_kipas_on ?? 39.0;
            $this->suhu_kipas_off = $setting->suhu_kipas_off ?? 37.0;
            $this->lembab_kipas_on = $setting->lembab_kipas_on ?? 85;
            $this->lembab_kipas_off = $setting->lembab_kipas_off ?? 80;
            $this->tanah_pompa_on = $setting->tanah_pompa_on ?? 45;
            $this->tanah_pompa_off = $setting->tanah_pompa_off ?? 75;
            $this->auto_restart_status = (bool)($setting->auto_restart_status ?? false);
            $this->auto_restart_time = $setting->auto_restart_time ?? '05:00:00';

            // Menghitung input detik kalibrasi berdasarkan kolom debit_pompa (100ml / debit = detik)
            $this->detik_kalibrasi_pompa = $this->debit_pompa > 0 ? round(100.0 / $this->debit_pompa, 1) : 33.3;
        }
    }

    public function simpanSistemSetting()
    {
        $this->validate([
            'suhu_kipas_on' => 'required|numeric',
            'suhu_kipas_off' => 'required|numeric',
            'lembab_kipas_on' => 'required|numeric',
            'lembab_kipas_off' => 'required|numeric',
            'tanah_pompa_on' => 'required|numeric',
            'tanah_pompa_off' => 'required|numeric',
            'auto_restart_time' => 'required',
            'detik_kalibrasi_pompa' => 'required|numeric|min:0.1',
        ]);

        // Mengonversi kembali detik inputan dari web menjadi nilai ml/detik untuk kolom debit_pompa
        $debitHitung = round(100.0 / $this->detik_kalibrasi_pompa, 2);

        $setting = SettingModel::firstOrCreate(['id' => 1]);
        $setting->update([
            'debit_pompa' => $debitHitung,
            'suhu_kipas_on' => $this->suhu_kipas_on,
            'suhu_kipas_off' => $this->suhu_kipas_off,
            'lembab_kipas_on' => $this->lembab_kipas_on,
            'lembab_kipas_off' => $this->lembab_kipas_off,
            'tanah_pompa_on' => $this->tanah_pompa_on,
            'tanah_pompa_off' => $this->tanah_pompa_off,
            'auto_restart_status' => $this->auto_restart_status,
            'auto_restart_time' => $this->auto_restart_time,
        ]);

        $this->loadData();
        session()->flash('pesan_setting', 'Parameter instrumen greenhouse berhasil disinkronkan ke database!');
    }

    public function render()
    {
        return view('livewire.device-setting')->layout('layouts.app');
    }
}