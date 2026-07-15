<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Icon" class="h-8 w-auto object-contain onerror='this.style.display=\"none\"'">
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-wide">Dashboard</h2>
                        <p class="text-sm text-slate-400 mt-0.5">Sistem Otomatisasi Greenhouse Melon Hybrid</p>
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

                    <div class="px-3 py-2 rounded-xl border border-white/5 bg-slate-900/40 text-slate-300 space-y-0.5">
                        <div>Jaringan: <span class="text-white font-semibold">{{ $latestLog->wifi_ssid ?? 'Mencari...' }}</span></div>
                        <div class="flex items-center gap-1.5">
                            <span>Sinyal:</span>
                            <span class="text-emerald-400 font-bold">{{ $latestLog->wifi_rssi ?? 0 }} dBm</span>
                        </div>
                    </div>

                    <div class="px-3 py-2 rounded-xl border border-white/5 bg-slate-900/40 text-slate-300">
                        IP Node: <span class="text-sky-400 font-mono font-semibold">{{ $latestLog->wifi_ip ?? '0.0.0.0' }}</span>
                    </div>
                </div>
            </div>

            <div x-data="{ modeSistem: '{{ $latestLog->mode_sistem ?? 2 }}', kipas: {{ ($latestLog->kipas_status ?? 0) ? 'true' : 'false' }}, pompa: {{ ($latestLog->pompa_status ?? 0) ? 'true' : 'false' }} }" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <span>🤖</span> 1. Mode Operasi Sistem Utama
                    </h3>
                    <div class="grid grid-cols-3 gap-2 bg-slate-950/40 p-1.5 rounded-2xl border border-white/5">
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

                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <span>🔌</span> 2. Kendali Aktuator <span x-show="modeSistem != '0'" class="text-[10px] text-rose-400 font-bold normal-case bg-rose-500/10 border border-rose-500/20 px-2 py-0.5 rounded-md" style="display: none;">(Terkunci - Aktif di Mode Manual)</span>
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button @click="if(modeSistem == '0') kipas = !kipas" :disabled="modeSistem != '0'" :class="kipas && modeSistem == '0' ? 'border-orange-500/40 bg-orange-500/10 text-orange-400' : 'border-white/5 bg-slate-950/20 text-slate-400'" class="flex items-center justify-between p-3 rounded-2xl border transition-all duration-300">
                            <span class="text-xs font-semibold flex items-center gap-2">
                                <span :class="kipas && modeSistem == '0' ? 'animate-spin' : ''">💨</span> Kipas Exhaust
                            </span>
                            <span :class="kipas && modeSistem == '0' ? 'bg-orange-500 text-slate-950' : 'bg-slate-800 text-slate-500'" class="text-[10px] font-black px-2.5 py-1 rounded-lg uppercase" x-text="kipas && modeSistem == '0' ? 'ON' : 'MATI'"></span>
                        </button>

                        <button @click="if(modeSistem == '0') pompa = !pompa" :disabled="modeSistem != '0'" :class="pompa && modeSistem == '0' ? 'border-sky-500/40 bg-sky-500/10 text-sky-400' : 'border-white/5 bg-slate-950/20 text-slate-400'" class="flex items-center justify-between p-3 rounded-2xl border transition-all duration-300">
                            <span class="text-xs font-semibold flex items-center gap-2">💧 Pompa Air</span>
                            <span :class="pompa && modeSistem == '0' ? 'bg-sky-500 text-slate-950' : 'bg-slate-800 text-slate-500'" class="text-[10px] font-black px-2.5 py-1 rounded-lg uppercase" x-text="pompa && modeSistem == '0' ? 'ON' : 'MATI'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between hover:border-emerald-500/20 transition-all">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider"> Anomali & Suhu Udara</span>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold uppercase">Optimal</span>
                    </div>
                    <div class="my-4 relative h-28 flex items-center justify-center">
                        <canvas id="gaugeSuhu"></canvas>
                        <div class="absolute text-center mt-6">
                            <span class="text-3xl font-black text-white tracking-tight">{{ $latestLog->suhu ?? 28.6 }}°C</span>
                            <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-wide mt-0.5">Suhu Aktual</span>
                        </div>
                    </div>
                    <div class="space-y-2 pt-3 border-t border-white/5 text-xs text-slate-400 font-medium">
                        <div class="flex justify-between"><span>Lembab Udara:</span><span class="text-blue-400 font-bold">{{ $latestLog->kelembaban_udara ?? 78.7 }} %</span></div>
                        <div class="flex justify-between"><span>Tekanan Defisit (VPD):</span><span class="text-purple-400 font-bold">{{ $latestLog->vpd ?? 0.83 }} kPa</span></div>
                    </div>
                </div>

                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between hover:border-sky-500/20 transition-all">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">🌱 KADAR AIR TANAH MEDIA</span>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-sky-500/10 border border-sky-500/20 text-sky-400 font-bold uppercase">Kecukupan</span>
                    </div>
                    @php 
                        $avgSoil = round((($latestLog->kelembaban_tanah_a ?? 80) + ($latestLog->kelembaban_tanah_b ?? 82)) / 2); 
                    @endphp
                    <div class="my-4 relative h-28 flex items-center justify-center">
                        <canvas id="gaugeTanah"></canvas>
                        <div class="absolute text-center mt-6">
                            <span class="text-3xl font-black text-white tracking-tight">{{ $avgSoil }}%</span>
                            <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-wide mt-0.5">Rata-rata</span>
                        </div>
                    </div>
                    <div class="space-y-2 pt-3 border-t border-white/5 text-xs text-slate-400 font-medium">
                        <div class="flex justify-between"><span>Sensor Zona A:</span><span class="text-slate-200 font-bold">{{ $latestLog->kelembaban_tanah_a ?? 80 }} %</span></div>
                        <div class="flex justify-between"><span>Sensor Zona B:</span><span class="text-slate-200 font-bold">{{ $latestLog->kelembaban_tanah_b ?? 82 }} %</span></div>
                    </div>
                </div>

                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between hover:border-amber-500/20 transition-all">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">⚡ MONITORING DAYA UTAMA</span>
                        <span class="text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wide bg-blue-500/10 border border-blue-500/20 text-blue-400">
                            {{ $latestLog->status_daya ?? 'Baterai' }}
                        </span>
                    </div>
                    <div class="my-4 relative h-28 flex items-center justify-center">
                        <canvas id="gaugeAki"></canvas>
                        <div class="absolute text-center mt-6">
                            <span class="text-3xl font-black text-white tracking-tight">{{ $latestLog->tegangan_aki ?? 12.6 }}V</span>
                            <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-wide mt-0.5">Tegangan Aki</span>
                        </div>
                    </div>
                    <div class="space-y-2 pt-3 border-t border-white/5 text-xs text-slate-400 font-medium">
                        <div class="flex justify-between">
                            <span>Tegangan Tertinggi (Max):</span>
                            <span class="text-red-400 font-bold">{{ isset($stats['max_aki']) ? number_format($stats['max_aki'], 1) : '0.0' }} V</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tegangan Terendah (Min):</span>
                            <span class="text-sky-400 font-bold">{{ isset($stats['min_aki']) ? number_format($stats['min_aki'], 1) : '0.0' }} V</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-3.5">
                    <h3 class="text-sm font-bold text-white tracking-wide uppercase flex items-center gap-2">
                        <span>📋</span> Ringkasan Konfigurasi Fase Budidaya
                    </h3>
                    <div class="grid grid-cols-2 gap-3 text-xs text-slate-400">
                        <div class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                                <span>Usia tanaman (HST):</span>
                                <strong class="text-emerald-400">{{ isset($hstSekarang) ? floor($hstSekarang) : 1 }} HST</strong>
                            </div>
                        <div class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Target Kebutuhan Air:</span><strong class="text-blue-400">{{ $targetSiram ?? 0 }} ml/pohon</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Jadwal Siram Berikutnya:</span><strong class="text-teal-400">{{ $jadwalSelanjutnya ?? '--:--' }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex justify-between items-center">
                            <span>Penyiraman Terakhir:</span><strong class="text-orange-400">{{ $penyiramanTerakhir ?? '--:--' }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-950/30 border border-white/5 flex flex-col justify-center items-start col-span-2">
                            <span class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Status Progres Hari Ini</span>
                            <div class="text-slate-200 mt-1">
                                Sistem telah melakukan penyiraman ke-<strong class="text-emerald-400 text-sm">{{ $penyiramanKe ?? 0 }}</strong> pada hari ini.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-white tracking-wide uppercase flex items-center gap-2">
                            <span>📊</span> Log Histori & Analisis Grafik
                        </h3>
                        <p class="text-xs text-slate-400 mt-2 leading-relaxed">Untuk memetakan pola pergerakan data time series per menit, 10 menit, hingga bulanan secara interaktif dengan visualisasi diagram penuh animasi, klik tautan di bawah ini.</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('analisis') }}" class="w-full inline-flex justify-center items-center px-5 py-3 text-xs font-bold uppercase text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition-all duration-300 rounded-xl shadow-xl hover:shadow-emerald-500/10 active:scale-95">
                            Buka Halaman Analisis & Grafik Runtun Waktu →
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

            const gaugeOptions = {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '83%',
                circumference: 180,
                rotation: 270,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                animation: { duration: 1500, easing: 'easeOutQuart' }
            };

            // 1. GAUGE SUHU
            new Chart(document.getElementById('gaugeSuhu'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [valSuhu, Math.max(0, 50 - valSuhu)],
                        backgroundColor: ['#f97316', '#1e293b'],
                        borderWidth: 0
                    }]
                },
                options: gaugeOptions
            });

            // 2. GAUGE TANAH
            new Chart(document.getElementById('gaugeTanah'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [valTanah, Math.max(0, 100 - valTanah)],
                        backgroundColor: ['#10b981', '#1e293b'],
                        borderWidth: 0
                    }]
                },
                options: gaugeOptions
            });

            // 3. GAUGE AKI (11V - 15V)
            const minAki = 11;
            const maxAki = 15;
            const rentangAki = maxAki - minAki;
            const fillAki = Math.max(0, Math.min(valAki - minAki, rentangAki));
            const sisaAki = rentangAki - fillAki;

            new Chart(document.getElementById('gaugeAki'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [fillAki, sisaAki],
                        backgroundColor: ['#eab308', '#1e293b'],
                        borderWidth: 0
                    }]
                },
                options: gaugeOptions
            });
        });
    </script>
</x-app-layout>