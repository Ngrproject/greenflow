<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Icon" class="h-8 w-auto object-contain" onerror="this.style.display='none'">
                    <div>
                        <h2 class="text-2xl font-bold tracking-wide transition-colors duration-300"
                            :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                            Dashboard
                        </h2>
                        <p class="text-sm mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">
                            Sistem Otomatisasi Greenhouse Melon Hybrid
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-wrap items-center gap-4 text-xs">
                    @if($latestLog && \Carbon\Carbon::parse($latestLog->created_at)->diffInMinutes(\Carbon\Carbon::now('Asia/Jakarta')) < 5)
                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 font-bold tracking-wide shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            ESP32: ONLINE
                        </div>
                    @else
                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl border border-rose-500/20 bg-rose-500/10 text-rose-400 font-bold tracking-wide shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                            ESP32: OFFLINE
                        </div>
                    @endif

                    <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important; color: #334155 !important;' : ''"
                         class="px-3 py-2 rounded-xl border border-white/5 bg-slate-900/40 text-slate-300 space-y-0.5">
                        <div>Jaringan: <span :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'" class="font-semibold">{{ $latestLog->wifi_ssid ?? 'Mencari...' }}</span></div>
                        <div class="flex items-center gap-1.5">
                            <span>Sinyal:</span>
                            <span class="text-emerald-500 dark:text-emerald-400 font-bold">{{ $latestLog->wifi_rssi ?? 0 }} dBm</span>
                        </div>
                    </div>

                    <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important; color: #334155 !important;' : ''"
                         class="px-3 py-2 rounded-xl border border-white/5 bg-slate-900/40 text-slate-300">
                        IP Node: <span class="text-sky-600 dark:text-sky-400 font-mono font-semibold">{{ $latestLog->wifi_ip ?? '0.0.0.0' }}</span>
                    </div>
                </div>
            </div>

            <!-- ================= ALERT HEADLINE NOTIFIKASI WEB TERBARU ================= -->
            @php
                $latestNotification = \App\Models\SystemLog::latest()->first();
            @endphp
            
            @if($latestNotification)
                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #cbd5e1 !important;' : ''"
                     class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-4 shadow-xl flex items-center justify-between gap-4 transition-all duration-300">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="flex h-2.5 w-2.5 relative shrink-0">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 @if($latestNotification->type == 'critical') bg-rose-400 @else bg-sky-400 @endif"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 @if($latestNotification->type == 'critical') bg-rose-500 @else bg-sky-500 @endif"></span>
                        </span>
                        <p class="text-xs truncate font-medium" :style="tema === 'light' ? 'color: #1e293b !important;' : 'color: #cbd5e1 !important;'">
                            <strong class="@if($latestNotification->type == 'critical') text-rose-500 @else text-sky-500 @endif uppercase text-[10px] tracking-wider mr-1">[Notifikasi Terbaru]:</strong>
                            {{ $latestNotification->message }}
                        </p>
                    </div>
                    <a href="/notifikasi" class="text-[11px] font-bold text-sky-500 dark:text-sky-400 hover:underline shrink-0 whitespace-nowrap flex items-center gap-1">
                        Lihat Semua Log <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </a>
                </div>
            @endif

            <div x-data="{ modeSistem: '{{ $latestLog->mode_sistem ?? 2 }}', kipas: {{ ($latestLog->kipas_status ?? 0) ? 'true' : 'false' }}, pompa: {{ ($latestLog->pompa_status ?? 0) ? 'true' : 'false' }} }" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                     class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4 transition-all duration-300">
                    <h3 class="text-xs font-bold uppercase tracking-wider flex items-center gap-2"
                        :style="tema === 'light' ? 'color: #1e293b !important;' : 'color: #94a3b8 !important;'">
                        <span>🤖</span> 1. Mode Operasi Sistem Utama
                    </h3>
                    <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                         class="grid grid-cols-3 gap-2 bg-slate-950/40 p-1.5 rounded-2xl border border-white/5">
                        <button @click="modeSistem = '1'" :class="modeSistem == '1' ? 'bg-emerald-500 text-slate-950 font-bold shadow-lg shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="py-2.5 rounded-xl text-xs tracking-wide transition-all duration-300">
                            🌿 Otomatis
                        </button>
                        <button @click="modeSistem = '2'" :class="modeSistem == '2' ? 'bg-blue-600 text-white font-bold shadow-lg shadow-blue-600/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="py-2.5 rounded-xl text-xs tracking-wide transition-all duration-300">
                            ⏱️ Terjadwal
                        </button>
                        <button @click="modeSistem = '0'" :class="modeSistem == '0' ? 'bg-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="py-2.5 rounded-xl text-xs tracking-wide transition-all duration-300">
                            ⚙️ Manual
                        </button>
                    </div>
                </div>

                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                     class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4 transition-all duration-300">
                    <h3 class="text-xs font-bold uppercase tracking-wider flex items-center gap-2"
                        :style="tema === 'light' ? 'color: #1e293b !important;' : 'color: #94a3b8 !important;'">
                        <span>🔌</span> 2. Kendali Aktuator <span x-show="modeSistem != '0'" class="text-[10px] text-rose-400 font-bold normal-case bg-rose-500/10 border border-rose-500/20 px-2 py-0.5 rounded-md" style="display: none;">(Terkunci - Aktif di Mode Manual)</span>
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button @click="if(modeSistem == '0') kipas = !kipas" :disabled="modeSistem != '0'" 
                                :style="tema === 'light' && (!kipas || modeSistem != '0') ? 'background: #f8fafc !important; border-color: #e2e8f0 !important; color: #64748b !important;' : ''"
                                :class="kipas && modeSistem == '0' ? 'border-orange-500/40 bg-orange-500/10 text-orange-400' : 'border-white/5 bg-slate-950/20 text-slate-400'" class="flex items-center justify-between p-3 rounded-2xl border transition-all duration-300">
                            <span class="text-xs font-semibold flex items-center gap-2" :style="tema === 'light' && (!kipas || modeSistem != '0') ? 'color: #334155 !important;' : ''">
                                <span :class="kipas && modeSistem == '0' ? 'animate-spin' : ''">💨</span> Kipas Exhaust
                            </span>
                            <span :class="kipas && modeSistem == '0' ? 'bg-orange-500 text-slate-950' : 'bg-slate-800 text-slate-500'" class="text-[10px] font-black px-2.5 py-1 rounded-lg uppercase" x-text="kipas && modeSistem == '0' ? 'ON' : 'MATI'"></span>
                        </button>

                        <button @click="if(modeSistem == '0') pompa = !pompa" :disabled="modeSistem != '0'" 
                                :style="tema === 'light' && (!pompa || modeSistem != '0') ? 'background: #f8fafc !important; border-color: #e2e8f0 !important; color: #64748b !important;' : ''"
                                :class="pompa && modeSistem == '0' ? 'border-sky-500/40 bg-sky-500/10 text-sky-400' : 'border-white/5 bg-slate-950/20 text-slate-400'" class="flex items-center justify-between p-3 rounded-2xl border transition-all duration-300">
                            <span class="text-xs font-semibold flex items-center gap-2" :style="tema === 'light' && (!pompa || modeSistem != '0') ? 'color: #334155 !important;' : ''">💧 Pompa Air</span>
                            <span :class="pompa && modeSistem == '0' ? 'bg-sky-500 text-slate-950' : 'bg-slate-800 text-slate-500'" class="text-[10px] font-black px-2.5 py-1 rounded-lg uppercase" x-text="pompa && modeSistem == '0' ? 'ON' : 'MATI'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                     class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between hover:border-emerald-500/20 transition-all">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #cbd5e1 !important;'"> Parameter Lingkungan</span>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-bold uppercase">Optimal</span>
                    </div>
                    <div class="my-4 relative h-28 flex items-center justify-center">
                        <canvas id="gaugeSuhu"></canvas>
                        <div class="absolute text-center mt-6">
                            <span class="text-3xl font-black font-mono tracking-tighter" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">{{ $latestLog->suhu ?? 28.6 }}°C</span>
                            <span class="block text-[9px] font-bold uppercase tracking-wide mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">Suhu Aktual</span>
                        </div>
                    </div>
                    <div class="space-y-2 pt-3 border-t text-xs font-medium transition-all"
                         :style="tema === 'light' ? 'border-color: #f1f5f9 !important; color: #475569 !important;' : 'border-color: rgba(255,255,255,0.05) !important; color: #94a3b8 !important;'">
                        <div class="flex justify-between"><span>Lembab Udara:</span><span class="text-blue-600 dark:text-blue-400 font-bold">{{ $latestLog->kelembaban_udara ?? 78.7 }} %</span></div>
                        <div class="flex justify-between"><span>Tekanan Defisit (VPD):</span><span class="text-purple-600 dark:text-purple-400 font-bold">{{ $latestLog->vpd ?? 0.83 }} kPa</span></div>
                    </div>
                </div>

                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                     class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between hover:border-sky-500/20 transition-all">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #cbd5e1 !important;'">🌱 KADAR AIR TANAH MEDIA</span>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-sky-500/10 border border-sky-500/20 text-sky-600 dark:text-sky-400 font-bold uppercase">Kecukupan</span>
                    </div>
                    @php 
                        $avgSoil = round((($latestLog->kelembaban_tanah_a ?? 80) + ($latestLog->kelembaban_tanah_b ?? 82)) / 2); 
                    @endphp
                    <div class="my-4 relative h-28 flex items-center justify-center">
                        <canvas id="gaugeTanah"></canvas>
                        <div class="absolute text-center mt-6">
                            <span class="text-3xl font-black font-mono tracking-tighter" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">{{ $avgSoil }}%</span>
                            <span class="block text-[9px] font-bold uppercase tracking-wide mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">Rata-rata</span>
                        </div>
                    </div>
                    <div class="space-y-2 pt-3 border-t text-xs font-medium transition-all"
                         :style="tema === 'light' ? 'border-color: #f1f5f9 !important; color: #475569 !important;' : 'border-color: rgba(255,255,255,0.05) !important; color: #94a3b8 !important;'">
                        <div class="flex justify-between"><span>Sensor Zona A:</span><span class="text-slate-800 dark:text-slate-200 font-bold">{{ $latestLog->kelembaban_tanah_a ?? 80 }} %</span></div>
                        <div class="flex justify-between"><span>Sensor Zona B:</span><span class="text-slate-800 dark:text-slate-200 font-bold">{{ $latestLog->kelembaban_tanah_b ?? 82 }} %</span></div>
                    </div>
                </div>

                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                     class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between hover:border-amber-500/20 transition-all">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #cbd5e1 !important;'">⚡ MONITORING DAYA UTAMA</span>
                        <span class="text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wide bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400">
                            {{ $latestLog->status_daya ?? 'Baterai' }}
                        </span>
                    </div>
                    <div class="my-4 relative h-28 flex items-center justify-center">
                        <canvas id="gaugeAki"></canvas>
                        <div class="absolute text-center mt-6">
                            <span class="text-3xl font-black font-mono tracking-tighter" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">{{ $latestLog->tegangan_aki ?? 12.6 }}V</span>
                            <span class="block text-[9px] font-bold uppercase tracking-wide mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">Tegangan Aki</span>
                        </div>
                    </div>
                    <div class="space-y-2 pt-3 border-t text-xs font-medium transition-all"
                         :style="tema === 'light' ? 'border-color: #f1f5f9 !important; color: #475569 !important;' : 'border-color: rgba(255,255,255,0.05) !important; color: #94a3b8 !important;'">
                        <div class="flex justify-between"><span>Tegangan Tertinggi (Max):</span><span class="text-red-600 dark:text-red-400 font-bold">{{ isset($stats['max_aki']) ? number_format($stats['max_aki'], 1) : '0.0' }} V</span></div>
                        <div class="flex justify-between"><span>Tegangan Terendah (Min):</span><span class="text-sky-600 dark:text-sky-400 font-bold">{{ isset($stats['min_aki']) ? number_format($stats['min_aki'], 1) : '0.0' }} V</span></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                     class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-3.5 transition-all duration-300">
                    <h3 class="text-sm font-bold tracking-wide uppercase flex items-center gap-2"
                        :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                        <span>📋</span> Ringkasan Konfigurasi Fase Budidaya
                    </h3>
                    <div class="grid grid-cols-2 gap-3 text-xs text-slate-500">
                        <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''" class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Usia Tanaman:</span>
                            <strong class="text-emerald-600 dark:text-emerald-400 font-mono">{{ isset($hstSekarang) ? floor($hstSekarang) : 1 }} HST</strong>
                        </div>
                        <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''" class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Target Air:</span>
                            <strong class="text-blue-600 dark:text-blue-400 font-mono">{{ $targetSiram ?? 0 }} ml/pohon</strong>
                        </div>
                        <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''" class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Jadwal Berikutnya:</span>
                            <strong class="text-teal-600 dark:text-teal-400 font-mono">{{ $jadwalSelanjutnya ?? '--:--' }}</strong>
                        </div>
                        <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''" class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Siram Terakhir:</span>
                            <strong class="text-orange-600 dark:text-orange-400 font-mono">{{ $penyiramanTerakhir ?? '--:--' }}</strong>
                        </div>
                        
                        <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''" class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Tanggal Tanam:</span>
                            <strong class="text-indigo-600 dark:text-indigo-400 font-mono">
                                {{ \App\Models\DeviceSetting::first()?->tanggal_tanam ? \Carbon\Carbon::parse(\App\Models\DeviceSetting::first()->tanggal_tanam)->format('d/m/Y') : '--/--/--' }}
                            </strong>
                        </div>
                        <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''" class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Debit Pompa:</span>
                            <strong class="text-pink-600 dark:text-pink-400 font-mono">
                                {{ number_format(\App\Models\DeviceSetting::first()?->debit_pompa ?? 3.0, 1) }} ml/s
                            </strong>
                        </div>

                        <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''" class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex flex-col justify-center items-start col-span-2">
                            <span class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Status Progres Hari Ini</span>
                            <div class="mt-1" :style="tema === 'light' ? 'color: #334155 !important;' : 'color: #cbd5e1 !important;'">
                                Sistem telah melakukan penyiraman ke-<strong class="text-emerald-600 dark:text-emerald-400 text-sm font-mono">{{ $penyiramanKe ?? 0 }}</strong> pada hari ini.
                            </div>
                        </div>
                    </div>
                </div>

                <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                     class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between h-full transition-all duration-300">
                    <div class="flex justify-between items-center border-b pb-3 mb-6"
                         :style="tema === 'light' ? 'border-color: #f1f5f9 !important;' : 'border-color: rgba(255,255,255,0.05) !important;'">
                        <h4 class="text-sm font-bold uppercase tracking-wider flex items-center gap-2"
                            :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                            <span>⚡</span> Aliran Distribusi Daya Utama (Real-Time)
                        </h4>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                            @if(($sumberDayaAktif ?? 'plts') == 'plts') bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20
                            @elseif(($sumberDayaAktif ?? 'plts') == 'baterai') bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20
                            @else bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 @endif">
                            Sumber: {{ strtoupper($sumberDayaAktif ?? 'PLTS') }}
                        </span>
                    </div>

                    <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="flex items-center justify-around py-6 bg-slate-950/40 rounded-2xl border border-white/5 relative overflow-hidden my-auto">
                    
                    <div class="flex flex-col items-center gap-2 z-10 w-24 text-center">
                        @if(($sumberDayaAktif ?? 'plts') == 'plts')
                            <div class="w-14 h-14 rounded-full bg-emerald-500/20 border-2 border-emerald-400 flex items-center justify-center text-emerald-400 shadow-lg shadow-emerald-500/20 animate-bounce">
                                <i class="fa-solid fa-solar-panel text-2xl"></i>
                            </div>
                            <span class="text-[11px] font-bold tracking-wide" :style="tema === 'light' ? 'color: #334155 !important;' : 'color: #e2e8f0 !important;'">Panel Surya</span>
                        @elseif(($sumberDayaAktif ?? 'plts') == 'baterai')
                            <div class="w-14 h-14 rounded-full bg-blue-500/20 border-2 border-blue-400 flex items-center justify-center text-blue-400 shadow-lg shadow-blue-500/20 animate-pulse">
                                <i class="fa-solid fa-battery-three-quarters text-2xl"></i>
                            </div>
                            <span class="text-[11px] font-bold tracking-wide" :style="tema === 'light' ? 'color: #334155 !important;' : 'color: #e2e8f0 !important;'">Energi Baterai</span>
                        @else
                            <div class="w-14 h-14 rounded-full bg-amber-500/20 border-2 border-amber-400 flex items-center justify-center text-amber-400 shadow-lg shadow-amber-500/20 animate-pulse">
                                <i class="fa-solid fa-plug text-2xl"></i>
                            </div>
                            <span class="text-[11px] font-bold tracking-wide" :style="tema === 'light' ? 'color: #334155 !important;' : 'color: #e2e8f0 !important;'">Jaringan PLN</span>
                        @endif
                    </div>

                    <div class="flex-1 flex justify-center items-center relative px-2">
                        <div class="w-full h-1 bg-slate-200 dark:bg-slate-800 rounded-full relative overflow-hidden">
                            <div class="absolute inset-0 w-1/2 animate-[ping_2s_infinite] rounded-full
                                @if(($sumberDayaAktif ?? 'plts') == 'plts') bg-gradient-to-r from-transparent via-emerald-400 to-transparent
                                @elseif(($sumberDayaAktif ?? 'plts') == 'baterai') bg-gradient-to-r from-transparent via-blue-400 to-transparent
                                @else bg-gradient-to-r from-transparent via-amber-400 to-transparent @endif">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2 z-10 w-24 text-center">
                        <div class="w-14 h-14 rounded-full bg-white dark:bg-slate-900 border-2 border-slate-200 dark:border-white/10 flex items-center justify-center text-teal-500 dark:text-teal-400 shadow-sm">
                            <i class="fa-solid fa-microchip text-2xl"></i>
                        </div>
                        <span class="text-[11px] font-bold tracking-wide" :style="tema === 'light' ? 'color: #334155 !important;' : 'color: #cbd5e1 !important;'">Sistem ESP32</span>
                    </div>

                    <div class="flex-1 flex justify-center items-center relative px-2">
                        <div class="w-full h-1 bg-slate-200 dark:bg-slate-800 rounded-full relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-emerald-400 to-transparent w-1/2 animate-[ping_2s_infinite] rounded-full"></div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2 z-10 w-24 text-center">
                        <div class="w-14 h-14 rounded-full bg-emerald-500/10 dark:bg-emerald-950/40 border-2 border-emerald-500/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-inner">
                            <i class="fa-solid fa-house-chimney-window text-2xl animate-pulse"></i>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 tracking-wide">Greenhouse</span>
                    </div>
                </div>

                    <div class="mt-6">
                        <a href="{{ route('analisis') }}" class="w-full inline-flex justify-center items-center px-4 py-3 text-xs font-bold uppercase text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition-all duration-300 rounded-xl shadow-lg hover:shadow-emerald-500/10 active:scale-95">
                            Buka Analisis Grafik Runtun Waktu &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const valSuhu = {{ $latestLog->suhu ?? 28.6 }};
            const valTanah = {{ $avgSoil ?? 81 }};
            const valAki = {{ $latestLog->tegangan_aki ?? 12.6 }};

            // Deteksi warna dinamis untuk busur ring donut gauge agar serasi di light mode
            const isLight = localStorage.getItem('greenflow_theme') === 'light';
            const gaugeBgColor = isLight ? '#e2e8f0' : '#1e293b';

            const gaugeOptions = {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '83%',
                circumference: 180,
                rotation: 270,
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                animation: { duration: 1500, easing: 'easeOutQuart' }
            };

            new Chart(document.getElementById('gaugeSuhu'), {
                type: 'doughnut',
                data: { datasets: [{ data: [valSuhu, Math.max(0, 50 - valSuhu)], backgroundColor: ['#f97316', gaugeBgColor], borderWidth: 0 }] },
                options: gaugeOptions
            });

            new Chart(document.getElementById('gaugeTanah'), {
                type: 'doughnut',
                data: { datasets: [{ data: [valTanah, Math.max(0, 100 - valTanah)], backgroundColor: ['#10b981', gaugeBgColor], borderWidth: 0 }] },
                options: gaugeOptions
            });

            const minAki = 11; const maxAki = 15; const rentangAki = maxAki - minAki;
            const fillAki = Math.max(0, Math.min(valAki - minAki, rentangAki)); const sisaAki = rentangAki - fillAki;

            new Chart(document.getElementById('gaugeAki'), {
                type: 'doughnut',
                data: { datasets: [{ data: [fillAki, sisaAki], backgroundColor: ['#eab308', gaugeBgColor], borderWidth: 0 }] },
                options: gaugeOptions
            });
        });
    </script>
</x-app-layout>