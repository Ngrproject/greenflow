<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="{ currentRange: '1-jam' }" x-init="$watch('currentRange', value => updateCharts(value))">
        
        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-all duration-300">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Icon" class="h-8 w-auto object-contain" onerror="this.style.display='none'">
                <div>
                    <h2 class="text-2xl font-bold tracking-wide flex items-center gap-2"
                        :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                        Analisis Data Terintegrasi Real-Time
                    </h2>
                    <p class="text-sm mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">
                        MULTI RANGE TIME SERIES MONITORING SYSTEM
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('analisis.export') }}" class="inline-flex items-center px-4 py-2.5 text-xs font-bold text-slate-950 uppercase tracking-wider bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition-all duration-300 rounded-xl shadow-xl hover:shadow-emerald-500/10 active:scale-95">
                    📥 Unduh Laporan Excel (.xlsx)
                </a>
            </div>
        </div>

        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-4 shadow-2xl flex flex-col sm:flex-row gap-4 items-center justify-between transition-all duration-300">
            <span class="text-xs font-bold uppercase tracking-wider flex items-center gap-2" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #94a3b8 !important;'">
                <span>⏱️</span> Rentang Waktu Grafik Kontrol:
            </span>
            <div :style="tema === 'light' ? 'background: #f1f5f9 !important; border-color: #cbd5e1 !important;' : ''"
                 class="inline-flex rounded-2xl bg-slate-950/40 p-1 border border-white/5 flex-wrap gap-1">
                <button @click="currentRange = '10-menit'" :class="currentRange === '10-menit' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">10 Menit</button>
                <button @click="currentRange = '1-jam'" :class="currentRange === '1-jam' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">1 Jam</button>
                <button @click="currentRange = '12-jam'" :class="currentRange === '12-jam' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">12 Jam</button>
                <button @click="currentRange = '24-jam'" :class="currentRange === '24-jam' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">24 Jam</button>
                <button @click="currentRange = '1-minggu'" :class="currentRange === '1-minggu' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">1 Minggu</button>
                <button @click="currentRange = '1-bulan'" :class="currentRange === '1-bulan' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">1 Bulan</button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between transition-all duration-300">
                <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-orange-500">🔥</span></div>
                <div class="my-4 flex justify-center">
                    <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                        <div class="w-28 h-28 border-[6px] rounded-full absolute top-0 left-0" :style="tema === 'light' ? 'border-color: #e2e8f0 !important;' : 'border-color: #1e293b !important;'"></div>
                        <div class="w-28 h-28 border-[6px] border-orange-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ min(($avgSuhu / 50) * 180, 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                    </div>
                </div>
                <div><span class="text-3xl font-black font-mono tracking-tighter transition-colors duration-300" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">{{ $avgSuhu }}°C</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Suhu Udara</span></div>
            </div>

            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between transition-all duration-300">
                <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-blue-500">💧</span></div>
                <div class="my-4 flex justify-center">
                    <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                        <div class="w-28 h-28 border-[6px] rounded-full absolute top-0 left-0" :style="tema === 'light' ? 'border-color: #e2e8f0 !important;' : 'border-color: #1e293b !important;'"></div>
                        <div class="w-28 h-28 border-[6px] border-blue-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ (($avgLembabUdara / 100) * 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                    </div>
                </div>
                <div><span class="text-3xl font-black font-mono tracking-tighter transition-colors duration-300" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">{{ $avgLembabUdara }}%</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Lembab Udara</span></div>
            </div>

            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between transition-all duration-300">
                    <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-emerald-500">🌱</span></div>
                <div class="my-4 flex justify-center">
                    <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                        <div class="w-28 h-28 border-[6px] rounded-full absolute top-0 left-0" :style="tema === 'light' ? 'border-color: #e2e8f0 !important;' : 'border-color: #1e293b !important;'"></div>
                        <div class="w-28 h-28 border-[6px] border-emerald-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ (($avgLembabTanah / 100) * 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                    </div>
                </div>
                <div><span class="text-3xl font-black font-mono tracking-tighter transition-colors duration-300" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">{{ $avgLembabTanah }}%</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Lembab Tanah</span></div>
            </div>

            @php
                $minAki = 11; $maxAki = 15; $fillAkiPersen = $avgTeganganAki > $minAki ? min((($avgTeganganAki - $minAki) / ($maxAki - $minAki)) * 100, 100) : 0;
            @endphp
            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between transition-all duration-300">
                <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-amber-500">⚡</span></div>
                <div class="my-4 flex justify-center">
                    <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                        <div class="w-28 h-28 border-[6px] rounded-full absolute top-0 left-0" :style="tema === 'light' ? 'border-color: #e2e8f0 !important;' : 'border-color: #1e293b !important;'"></div>
                        <div class="w-28 h-28 border-[6px] border-amber-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ (($fillAkiPersen / 100) * 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                    </div>
                </div>
                <div><span class="text-3xl font-black font-mono tracking-tighter transition-colors duration-300" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">{{ $avgTeganganAki }}V</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Tegangan Aki</span></div>
            </div>
        </div>

        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl transition-all duration-300">
                <h4 class="text-sm font-bold mb-4 uppercase tracking-wider flex items-center gap-2" :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                    <span>🔍</span> Ringkasan Batas Ekstrem Parameter (Hari Ini)
                </h4>
                <div class="overflow-x-auto rounded-2xl border bg-slate-50 dark:bg-slate-950/20" :style="tema === 'light' ? 'border-color: #e2e8f0 !important;' : 'border-color: rgba(255,255,255,0.05) !important;'">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="dark:bg-slate-950/50 border-b font-bold uppercase text-[10px]" :style="tema === 'light' ? 'background: #f1f5f9 !important; border-color: #e2e8f0 !important; color: #475569 !important;' : ''">
                                <th class="p-4">Nama Parameter Sensor</th>
                                <th class="p-4 text-rose-600 dark:text-rose-400">Nilai Maksimum (Max)</th>
                                <th class="p-4 text-sky-600 dark:text-sky-400">Nilai Minimum (Min)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y font-semibold" 
                               :style="tema === 'light' ? 'divide-color: #e2e8f0 !important; color: #0f172a !important;' : 'divide-color: rgba(255,255,255,0.05) !important; color: #cbd5e1 !important;'">
                            <tr :style="tema === 'light' ? 'background: #ffffff !important;' : ''" class="hover:bg-white/5 transition">
                                <td class="p-4">Suhu Udara Lingkungan</td>
                                <td class="p-4 text-rose-600 dark:text-rose-400 font-bold font-mono">{{ number_format($stats['max_suhu'], 1) }} °C</td>
                                <td class="p-4 text-sky-600 dark:text-sky-400 font-bold font-mono">{{ number_format($stats['min_suhu'], 1) }} °C</td>
                            </tr>
                            <tr :style="tema === 'light' ? 'background: #ffffff !important;' : ''" class="hover:bg-white/5 transition">
                                <td class="p-4">Kelembaban Udara Makro</td>
                                <td class="p-4 text-rose-600 dark:text-rose-400 font-bold font-mono">{{ number_format($stats['max_lembab'], 1) }} %</td>
                                <td class="p-4 text-sky-600 dark:text-sky-400 font-bold font-mono">{{ number_format($stats['min_lembab'], 1) }} %</td>
                            </tr>
                            <tr :style="tema === 'light' ? 'background: #ffffff !important;' : ''" class="hover:bg-white/5 transition">
                                <td class="p-4">Kelembaban Media Tanah (A)</td>
                                <td class="p-4 text-rose-600 dark:text-rose-400 font-bold font-mono">{{ $stats['max_soil_a'] }} %</td>
                                <td class="p-4 text-sky-600 dark:text-sky-400 font-bold font-mono">{{ $stats['min_soil_a'] }} %</td>
                            </tr>
                            <tr :style="tema === 'light' ? 'background: #ffffff !important;' : ''" class="hover:bg-white/5 transition">
                                <td class="p-4">Kelembaban Media Tanah (B)</td>
                                <td class="p-4 text-rose-600 dark:text-rose-400 font-bold font-mono">{{ $stats['max_soil_b'] }} %</td>
                                <td class="p-4 text-sky-600 dark:text-sky-400 font-bold font-mono">{{ $stats['min_soil_b'] }} %</td>
                            </tr>
                            <tr :style="tema === 'light' ? 'background: #ffffff !important;' : ''" class="hover:bg-white/5 transition">
                                <td class="p-4">Tegangan Energi Sistem Aki</td>
                                <td class="p-4 text-rose-600 dark:text-rose-400 font-bold font-mono">{{ number_format($stats['max_aki'], 1) }} V</td>
                                <td class="p-4 text-sky-600 dark:text-sky-400 font-bold font-mono">{{ number_format($stats['min_aki'], 1) }} V</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl transition-all duration-300">
                <h4 class="text-xs font-bold uppercase mb-4 tracking-wider" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #94a3b8 !important;'">📊 Tren Iklim Udara & Nilai VPD</h4>
                <div class="relative h-72"><canvas id="chartIklimHariIni"></canvas></div>
            </div>
            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl transition-all duration-300">
                <h4 class="text-xs font-bold uppercase mb-4 tracking-wider" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #94a3b8 !important;'">📊 Tren Kelembaban Tanah Media Tanam (Soil A & B)</h4>
                <div class="relative h-72"><canvas id="chartTanahHariIni"></canvas></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl md:col-span-2 transition-all duration-300">
                <h4 class="text-xs font-bold uppercase mb-4 tracking-wider" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #3b82f6 !important;'">⏱️ Grafik Histori Log Kerja Alat (Pompa & Kipas Exhaust)</h4>
                <div class="relative h-56"><canvas id="logAktuatorChart"></canvas></div>
            </div>
            <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                 class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl transition-all duration-300">
                <h4 class="text-xs font-bold uppercase mb-4 tracking-wider" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #94a3b8 !important;'">⚡ Tren Tegangan Suplai Aki (Voltase)</h4>
                <div class="relative h-56"><canvas id="chartAkiHariIni"></canvas></div>
            </div>
        </div>

        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl transition-all duration-300">
            <h4 class="text-xs font-bold uppercase mb-4 tracking-wider text-center" :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #94a3b8 !important;'">📊 Proporsi Distribusi Status Sumber Daya Listrik (Hari Ini)</h4>
            <div class="relative h-64 flex justify-center"><canvas id="sumberDayaChart"></canvas></div>
        </div>

    </div>

    <script>
        let chartIklim, chartTanah, chartLogAlat, chartAki, donutChart;
        const isLight = localStorage.getItem('greenflow_theme') === 'light';

        // Konfigurasi Chart.js adaptif
        Chart.defaults.color = isLight ? '#475569' : '#94a3b8';
        Chart.defaults.borderColor = isLight ? '#f1f5f9' : 'rgba(255, 255, 255, 0.05)';

        function updateCharts(rangeType) {
            fetch(`/analisis/data?range=${rangeType}`)
                .then(response => response.json())
                .then(data => {
                    chartIklim.data.labels = data.timestamps;
                    chartIklim.data.datasets[0].data = data.suhu;
                    chartIklim.data.datasets[1].data = data.lembab;
                    chartIklim.data.datasets[2].data = data.vpd;
                    chartIklim.update('active');

                    chartTanah.data.labels = data.timestamps;
                    chartTanah.data.datasets[0].data = data.soilA;
                    chartTanah.data.datasets[1].data = data.soilB;
                    chartTanah.update('active');

                    chartLogAlat.data.labels = data.timestamps;
                    chartLogAlat.data.datasets[0].data = data.pompa;
                    chartLogAlat.data.datasets[1].data = data.kipas;
                    chartLogAlat.update('active');

                    chartAki.data.labels = data.timestamps;
                    chartAki.data.datasets[0].data = data.aki;
                    chartAki.update('active');
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const animationOptions = { duration: 1200, easing: 'easeOutQuart' };

            // Inisialisasi Donut Chart
            donutChart = new Chart(document.getElementById('sumberDayaChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Solar Panel', 'Baterai', 'PLN'],
                    datasets: [{ 
                        data: [{{ $countSolar }}, {{ $countBattery }}, {{ $countPln }}], 
                        backgroundColor: ['#10b981', '#3b82f6', '#eab308'],
                        borderWidth: 0
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { legend: { labels: { color: isLight ? '#1e293b' : '#f8fafc' } } },
                    animation: { animateScale: true, animateRotate: true, duration: 1500, easing: 'easeOutElastic' }
                }
            });

            // 1. Chart Iklim
            chartIklim = new Chart(document.getElementById('chartIklimHariIni'), {
                type: 'line',
                data: { labels: [], datasets: [
                    { label: 'Suhu (°C)', data: [], borderColor: '#f97316', backgroundColor: 'transparent', tension: 0.2, yAxisID: 'y' },
                    { label: 'Lembab Udara (%)', data: [], borderColor: '#3b82f6', backgroundColor: 'transparent', tension: 0.2, yAxisID: 'y' },
                    { label: 'VPD (kPa)', data: [], borderColor: '#a855f7', backgroundColor: 'transparent', tension: 0.2, yAxisID: 'y1' }
                ]},
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    animation: animationOptions, 
                    scales: { 
                        y: { position: 'left' }, 
                        y1: { position: 'right', grid: { drawOnChartArea: false } } 
                    } 
                }
            });

            // 2. Chart Tanah
            chartTanah = new Chart(document.getElementById('chartTanahHariIni'), {
                type: 'line',
                data: { labels: [], datasets: [
                    { label: 'Soil A (%)', data: [], borderColor: '#10b981', backgroundColor: 'transparent', tension: 0.2 },
                    { label: 'Soil B (%)', data: [], borderColor: '#047857', backgroundColor: 'transparent', tension: 0.2 }
                ]},
                options: { responsive: true, maintainAspectRatio: false, animation: animationOptions }
            });

            // 3. Chart Log Kerja Alat
            chartLogAlat = new Chart(document.getElementById('logAktuatorChart'), {
                type: 'bar',
                data: { labels: [], datasets: [
                    { label: '💦 Pompa', data: [], backgroundColor: '#3b82f6' },
                    { label: '💨 Kipas', data: [], backgroundColor: '#f97316' }
                ]},
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    animation: animationOptions, 
                    scales: { 
                        y: { min: 0, max: 1, ticks: { stepSize: 1, callback: v => v === 1 ? 'ON' : 'OFF', color: isLight ? '#0f172a' : '#f8fafc' } } 
                    } 
                }
            });

            // 4. Chart Aki
            chartAki = new Chart(document.getElementById('chartAkiHariIni'), {
                type: 'line',
                data: { labels: [], datasets: [{ label: 'Tegangan Aki (V)', data: [], borderColor: '#eab308', backgroundColor: 'transparent', tension: 0.2 }]},
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    animation: animationOptions, 
                    scales: { y: { min: 10, max: 15, ticks: { stepSize: 0.5 } } } 
                }
            });

            updateCharts('1-jam');
        });
    </script>
</div>
</x-app-layout>