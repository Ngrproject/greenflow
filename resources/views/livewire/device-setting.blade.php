<div class="space-y-6">
    
    <div class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                <i class="fa-solid fa-sliders text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white tracking-wide">Pusat Kendali & Parameter Alat</h2>
                <p class="text-xs text-slate-400 mt-0.5">GREENFLOW — ADVANCED SYSTEM OPERATIONAL PROCEDURE (SOP)</p>
            </div>
        </div>
        
        <div class="px-5 py-2.5 rounded-2xl border border-teal-500/20 bg-teal-500/10 text-teal-400 font-bold tracking-wide shadow-sm text-center text-xs">
            📡 Alokasi Jaringan: <span class="text-white bg-teal-500 px-2 py-0.5 rounded-lg font-mono text-[11px] ml-1">PORTAL DHCP ENABLED</span>
        </div>
    </div>

    @if (session()->has('pesan_setting'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 font-bold text-xs flex items-center gap-2 shadow-lg">
            <i class="fa-solid fa-circle-check text-sm"></i> {{ session('pesan_setting') }}
        </div>
    @endif

    <form wire:submit.prevent="simpanSistemSetting" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4">
            <h3 class="text-xs font-bold text-white tracking-wider uppercase flex items-center gap-2 border-b border-white/5 pb-2">
                <i class="fa-solid fa-fan text-emerald-400"></i> Ambang Batas Kipas Exhaust
            </h3>
            
            <div class="space-y-3">
                <div class="p-3 bg-slate-950/40 rounded-xl border border-white/5 space-y-2">
                    <span class="text-[10px] font-black tracking-wider text-orange-400 uppercase block">🌡️ Berdasarkan Suhu Lingkungan</span>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kipas ON (°C)</label>
                            <input type="number" step="0.1" wire:model="suhu_kipas_on" class="w-full bg-slate-950/40 border border-white/10 rounded-xl px-3 py-1.5 text-slate-200 text-xs focus:outline-none focus:border-emerald-500 font-mono">
                            @error('suhu_kipas_on') <span class="text-[9px] text-rose-400 font-bold block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kipas OFF (°C)</label>
                            <input type="number" step="0.1" wire:model="suhu_kipas_off" class="w-full bg-slate-950/40 border border-white/10 rounded-xl px-3 py-1.5 text-slate-200 text-xs focus:outline-none focus:border-emerald-500 font-mono">
                            @error('suhu_kipas_off') <span class="text-[9px] text-rose-400 font-bold block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-slate-950/40 rounded-xl border border-white/5 space-y-2">
                    <span class="text-[10px] font-black tracking-wider text-blue-400 uppercase block">💧 Berdasarkan Kelembaban Udara</span>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kipas ON (%)</label>
                            <input type="number" wire:model="lembab_kipas_on" class="w-full bg-slate-950/40 border border-white/10 rounded-xl px-3 py-1.5 text-slate-200 text-xs focus:outline-none focus:border-emerald-500 font-mono">
                            @error('lembab_kipas_on') <span class="text-[9px] text-rose-400 font-bold block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kipas OFF (%)</label>
                            <input type="number" wire:model="lembab_kipas_off" class="w-full bg-slate-950/40 border border-white/10 rounded-xl px-3 py-1.5 text-slate-200 text-xs focus:outline-none focus:border-emerald-500 font-mono">
                            @error('lembab_kipas_off') <span class="text-[9px] text-rose-400 font-bold block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4">
            <h3 class="text-xs font-bold text-white tracking-wider uppercase flex items-center gap-2 border-b border-white/5 pb-2">
                <i class="fa-solid fa-droplet text-teal-400"></i> Kontrol & Kalibrasi Pompa
            </h3>
            
            <div class="space-y-3">
                <div class="p-3 bg-slate-950/40 rounded-xl border border-white/5 space-y-2">
                    <span class="text-[10px] font-black tracking-wider text-emerald-400 uppercase block">🌱 Batas Kelembaban Tanah</span>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pompa ON (%)</label>
                            <input type="number" wire:model="tanah_pompa_on" class="w-full bg-slate-950/40 border border-white/10 rounded-xl px-3 py-1.5 text-slate-200 text-xs focus:outline-none focus:border-teal-500 font-mono">
                            @error('tanah_pompa_on') <span class="text-[9px] text-rose-400 font-bold block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pompa OFF (%)</label>
                            <input type="number" wire:model="tanah_pompa_off" class="w-full bg-slate-950/40 border border-white/10 rounded-xl px-3 py-1.5 text-slate-200 text-xs focus:outline-none focus:border-teal-500 font-mono">
                            @error('tanah_pompa_off') <span class="text-[9px] text-rose-400 font-bold block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-slate-950/40 rounded-xl border border-white/5">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">⏱️ Waktu Kalibrasi Pompa (Detik / 100ml)</label>
                    <input type="number" step="0.1" wire:model="detik_kalibrasi_pompa" class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-2 text-slate-200 text-xs focus:outline-none focus:border-teal-500 font-mono text-center">
                    @error('detik_kalibrasi_pompa') <span class="text-[9px] text-rose-400 font-bold block mt-1">{{ $message }}</span> @enderror
                    <span class="text-[9px] text-slate-500 block mt-1.5 leading-relaxed">Masukkan perkiraan waktu (detik) untuk meluapkan air pas 100ml guna mensinkronkan perhitungan IoT.</span>
                </div>
            </div>
        </div>

        <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4">
            <h3 class="text-xs font-bold text-white tracking-wider uppercase flex items-center gap-2 border-b border-white/5 pb-2">
                <i class="fa-solid fa-arrow-rotate-left text-sky-400"></i> Pemeliharaan Auto Restart
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-950/40 border border-white/5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Auto-Restart</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="auto_restart_status" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-400 peer-checked:after:bg-emerald-400 after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500/20 border border-white/5"></div>
                    </label>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Jadwal Jam Restart Rutin</label>
                    <input type="time" wire:model="auto_restart_time" class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-2.5 text-slate-200 text-xs focus:outline-none focus:border-sky-500 font-mono text-center">
                    @error('auto_restart_time') <span class="text-[9px] text-rose-400 font-bold block mt-0.5">{{ $message }}</span> @enderror
                    <span class="text-[9px] text-slate-500 block mt-1.5 leading-relaxed">Penyegaran otomatis memori RAM mikro ESP32 harian agar terhindar dari hang/freeze.</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 text-xs font-bold uppercase text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition-all duration-300 rounded-xl shadow-xl hover:shadow-emerald-500/10 active:scale-[0.99]">
                <i class="fa-solid fa-cloud-arrow-up"></i> Sinkronisasikan Seluruh Konfigurasi Sistem Utama
            </button>
        </div>
    </form>
</div>