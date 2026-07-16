<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SystemLog;

class HalamanNotifikasi extends Component
{
    public function bersihkanSemuaLog()
    {
        SystemLog::truncate();
        session()->flash('pesan', 'Seluruh riwayat log berhasil dibersihkan!');
    }

    public function render()
    {
        return view('livewire.halaman-notifikasi', [
            'logs' => SystemLog::latest()->get()
        ])->layout('layouts.app');
    }
}