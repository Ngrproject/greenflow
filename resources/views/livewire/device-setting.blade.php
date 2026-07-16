<div class="space-y-6">
    
    <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
         class="bg-white dark:bg-white/5 dark:backdrop-blur-md border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-all duration-300">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i class="fa-solid fa-sliders text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-wide transition-colors duration-300"
                    :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                    Pusat Kendali & Parameter Alat
                </h2>
                <p class="text-xs mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">
                    GREENFLOW — ADVANCED SYSTEM OPERATIONAL PROCEDURE (SOP)
                </p>
            </div>
        </div>
        
        <div class="px-5 py-2.5 rounded-2xl border border-teal-500/20 bg-teal-500/10 text-teal-600 dark:text-teal-400 font-bold tracking-wide shadow-sm text-center text-xs">
            📡 Alokasi Jaringan: <span class="text-teal-700 dark:text-white bg-teal-500/20 dark:bg-teal-500 px-2 py-0.5 rounded-lg font-mono text-[11px] ml-1">PORTAL DHCP ENABLED</span>
        </div>
    </div>

    @if (session()->has('pesan_setting'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-600 dark:text-emerald-400 font-bold text-xs flex items-center gap-2 shadow-md">
            <i class="fa-solid fa-circle-check text-sm"></i> {{ session('pesan_setting') }}
        </div>
    @endif

    <form wire:submit.prevent="simpanSistemSetting" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="dark:bg-slate-900/40 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl space-y-4 transition-all duration-300">
            <h3 class="text-xs font-bold tracking-wider uppercase flex items-center gap-2 border-b pb-2"
                :style="tema === 'light' ? 'color: #1e293b !important; border-color: #f1f5f9 !important;' : 'color: #ffffff !important; border-color: rgba(255,255,255,0.05) !important;'">
                <i class="fa-solid fa-fan text-emerald-500 dark:text-emerald-400"></i> Ambang Batas Kipas Exhaust
            </h3>
            
            <div class="space-y-3">
                <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="p-3 dark:bg-slate-950/40 rounded-xl border border-slate-200 dark:border-white/5 space-y-2">
                    <span class="text-[10px] font-black tracking-wider text-orange-600 dark:text-orange-400 uppercase block">🌡️ Berdasarkan Suhu Lingkungan</span>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Kipas ON (°C)</label>
                            <input type="number" step="0.1" wire:model="suhu_kipas_on" 
                                   :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                                   class="w-full rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-emerald-500 font-mono transition-colors">
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Kipas OFF (°C)</label>
                            <input type="number" step="0.1" wire:model="suhu_kipas_off" 
                                   :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                                   class="w-full rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-emerald-500 font-mono transition-colors">
                        </div>
                    </div>
                </div>

                <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="p-3 dark:bg-slate-950/40 rounded-xl border border-slate-200 dark:border-white/5 space-y-2">
                    <span class="text-[10px] font-black tracking-wider text-blue-600 dark:text-blue-400 uppercase block">💧 Berdasarkan Kelembaban Udara</span>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Kipas ON (%)</label>
                            <input type="number" wire:model="lembab_kipas_on" 
                                   :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                                   class="w-full rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-emerald-500 font-mono transition-colors">
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Kipas OFF (%)</label>
                            <input type="number" wire:model="lembab_kipas_off" 
                                   :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                                   class="w-full rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-emerald-500 font-mono transition-colors">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="dark:bg-slate-900/40 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl space-y-4 transition-all duration-300">
            <h3 class="text-xs font-bold tracking-wider uppercase flex items-center gap-2 border-b pb-2"
                :style="tema === 'light' ? 'color: #1e293b !important; border-color: #f1f5f9 !important;' : 'color: #ffffff !important; border-color: rgba(255,255,255,0.05) !important;'">
                <i class="fa-solid fa-droplet text-teal-500 dark:text-teal-400"></i> Kontrol & Kalibrasi Pompa
            </h3>
            
            <div class="space-y-3">
                <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="p-3 dark:bg-slate-950/40 rounded-xl border border-slate-200 dark:border-white/5 space-y-2">
                    <span class="text-[10px] font-black tracking-wider text-emerald-600 dark:text-emerald-400 uppercase block">🌱 Batas Kelembaban Tanah</span>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Pompa ON (%)</label>
                            <input type="number" wire:model="tanah_pompa_on" 
                                   :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                                   class="w-full rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-teal-500 font-mono transition-colors">
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Pompa OFF (%)</label>
                            <input type="number" wire:model="tanah_pompa_off" 
                                   :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                                   class="w-full rounded-xl px-3 py-1.5 text-xs focus:outline-none focus:border-teal-500 font-mono transition-colors">
                        </div>
                    </div>
                </div>

                <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="p-3 dark:bg-slate-950/40 rounded-xl border border-slate-200 dark:border-white/5 space-y-1.5">
                    <label class="block text-[10px] font-black text-slate-700 dark:text-slate-400 uppercase tracking-wider mb-1.5">⏱️ Waktu Kalibrasi Pompa (Detik / 100ml)</label>
                    <input type="number" step="0.1" wire:model="detik_kalibrasi_pompa" 
                           :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                           class="w-full rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-teal-500 font-mono text-center transition-colors">
                    <span class="text-[9px]" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #64748b !important;'">Masukkan perkiraan waktu (detik) untuk meluapkan air pas 100ml guna mensinkronkan perhitungan IoT.</span>
                </div>
            </div>
        </div>

        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="dark:bg-slate-900/40 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl space-y-4 transition-all duration-300">
            <h3 class="text-xs font-bold tracking-wider uppercase flex items-center gap-2 border-b pb-2"
                :style="tema === 'light' ? 'color: #1e293b !important; border-color: #f1f5f9 !important;' : 'color: #ffffff !important; border-color: rgba(255,255,255,0.05) !important;'">
                <i class="fa-solid fa-arrow-rotate-left text-sky-500 dark:text-sky-400"></i> Pemeliharaan Auto Restart
            </h3>
            
            <div class="space-y-4">
                <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="flex items-center justify-between p-3 rounded-xl dark:bg-slate-950/40 border border-slate-200 dark:border-white/5">
                    <span class="text-[10px] font-bold text-slate-700 dark:text-slate-400 uppercase tracking-wider">Status Auto-Restart</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="auto_restart_status" class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-200 dark:bg-slate-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white dark:after:bg-slate-400 peer-checked:after:bg-emerald-500 after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500/20 border border-slate-200 dark:border-white/5"></div>
                    </label>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-700 dark:text-slate-400 uppercase tracking-wider mb-1.5">Jadwal Jam Restart Rutin</label>
                    <input type="time" wire:model="auto_restart_time" 
                           :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                           class="w-full rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:border-sky-500 font-mono text-center transition-colors">
                </div>

                <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="p-3 rounded-xl dark:bg-slate-950/40 border border-slate-200 dark:border-white/5 flex items-center justify-between pt-3">
                    <div class="space-y-0.5">
                        <span class="text-[10px] font-bold text-slate-700 dark:text-slate-400 uppercase tracking-wider block">🎨 Tema Dashboard</span>
                        <span class="text-[9px] text-slate-500 block leading-tight" x-text="tema === 'dark' ? 'Premium Dark' : 'Windows Light'"></span>
                    </div>
                    
                    <button type="button" 
                            @click="tema = (tema === 'dark' ? 'light' : 'dark')" 
                            class="px-3 py-1.5 rounded-xl border font-bold text-[10px] uppercase tracking-wide transition-all duration-200 shadow-sm"
                            :class="tema === 'dark' ? 'bg-amber-500/10 border-amber-500/30 text-amber-400 hover:bg-amber-500/20' : 'bg-white border-slate-300 text-slate-800 hover:bg-slate-100'">
                        <span x-show="tema === 'dark'"><i class="fa-solid fa-sun mr-1 text-amber-500"></i> Light Mode</span>
                        <span x-show="tema === 'light'"><i class="fa-solid fa-moon mr-1 text-indigo-600"></i> Dark Mode</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 text-xs font-bold uppercase text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition-all duration-300 rounded-xl shadow-md active:scale-[0.99]">
                <i class="fa-solid fa-cloud-arrow-up"></i> Sinkronisasikan Seluruh Konfigurasi Sistem Utama
            </button>
        </div>
    </form>
</div>