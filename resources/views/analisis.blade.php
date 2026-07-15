<x-app-layout>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" x-data="{ currentRange: '1-jam' }" x-init="$watch('currentRange', value => updateCharts(value))">
            
            <div class="backdrop-blur-md bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Icon" class="h-8 w-auto object-contain" onerror="this.style.display='none'">
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-wide flex items-center gap-2">
                            Analisis Data Terintegrasi Real-Time
                        </h2>
                        <p class="text-sm text-slate-400 mt-0.5">MULTI RANGE TIME SERIES MONITORING SYSTEM</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('analisis.export') }}" class="inline-flex items-center px-4 py-2.5 text-xs font-bold text-slate-950 uppercase tracking-wider bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition-all duration-300 rounded-xl shadow-xl hover:shadow-emerald-500/10 active:scale-95">
                        📥 Unduh Laporan Excel (.xlsx)
                    </a>
                </div>
            </div>

            <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-4 shadow-2xl flex flex-col sm:flex-row gap-4 items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <span>⏱️</span> Rentang Waktu Grafik Kontrol:
                </span>
                <div class="inline-flex rounded-2xl bg-slate-950/40 p-1 border border-white/5 flex-wrap gap-1">
                    <button @click="currentRange = '10-menit'" :class="currentRange === '10-menit' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">10 Menit</button>
                    <button @click="currentRange = '1-jam'" :class="currentRange === '1-jam' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">1 Jam</button>
                    <button @click="currentRange = '12-jam'" :class="currentRange === '12-jam' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">12 Jam</button>
                    <button @click="currentRange = '24-jam'" :class="currentRange === '24-jam' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">24 Jam</button>
                    <button @click="currentRange = '1-minggu'" :class="currentRange === '1-minggu' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">1 Minggu</button>
                    <button @click="currentRange = '1-bulan'" :class="currentRange === '1-bulan' ? 'bg-emerald-500 text-slate-950 font-bold shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5'" class="px-3 py-1.5 text-xs rounded-xl transition duration-300">1 Bulan</button>
                </div>
            </div>

            <!-- ================= BARIS RATA-RATA HARIAN (RESET JAM 12 MALAM) ================= -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Suhu Udara -->
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between hover:border-orange-500/20 transition-all">
                    <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-orange-500">🔥</span></div>
                    <div class="my-4 flex justify-center">
                        <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                            <!-- Background abu-abu sebagai dasar lingkaran -->
                            <div class="w-28 h-28 border-[6px] border-slate-800 rounded-full absolute top-0 left-0"></div>
                            <!-- Isi warna indikator yang mengikuti nilai skala -->
                            <div class="w-28 h-28 border-[6px] border-orange-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ min(($avgSuhu / 50) * 180, 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                        </div>
                    </div>
                    <div><span class="text-3xl font-black text-white tracking-tight">{{ $avgSuhu }}°C</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Suhu Udara</span></div>
                </div>

                <!-- Kelembaban Udara -->
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between hover:border-blue-500/20 transition-all">
                    <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-blue-500">💧</span></div>
                    <div class="my-4 flex justify-center">
                        <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                            <div class="w-28 h-28 border-[6px] border-slate-800 rounded-full absolute top-0 left-0"></div>
                            <div class="w-28 h-28 border-[6px] border-blue-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ (($avgLembabUdara / 100) * 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                        </div>
                    </div>
                    <div><span class="text-3xl font-black text-white tracking-tight">{{ $avgLembabUdara }}%</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Lembab Udara</span></div>
                </div>

                <!-- Kelembaban Tanah -->
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between hover:border-emerald-500/20 transition-all">
                    <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-emerald-500">🌱</span></div>
                    <div class="my-4 flex justify-center">
                        <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                            <div class="w-28 h-28 border-[6px] border-slate-800 rounded-full absolute top-0 left-0"></div>
                            <div class="w-28 h-28 border-[6px] border-emerald-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ (($avgLembabTanah / 100) * 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                        </div>
                    </div>
                    <div><span class="text-3xl font-black text-white tracking-tight">{{ $avgLembabTanah }}%</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Lembab Tanah</span></div>
                </div>

                <!-- Tegangan Aki (Skala Kustom 11V - 15V) -->
                @php
                    $minAki = 11;
                    $maxAki = 15;
                    $fillAkiPersen = $avgTeganganAki > $minAki ? min((($avgTeganganAki - $minAki) / ($maxAki - $minAki)) * 100, 100) : 0;
                @endphp
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl text-center flex flex-col justify-between hover:border-amber-500/20 transition-all">
                    <div class="flex justify-between items-center text-slate-400 text-[10px] font-bold uppercase tracking-wider"><span>Rata-Rata</span><span class="text-amber-500">⚡</span></div>
                    <div class="my-4 flex justify-center">
                        <div class="relative w-28 h-14 overflow-hidden flex items-end justify-center">
                            <div class="w-28 h-28 border-[6px] border-slate-800 rounded-full absolute top-0 left-0"></div>
                            <div class="w-28 h-28 border-[6px] border-amber-500 rounded-full absolute top-0 left-0 origin-center" style="transform: rotate({{ (($fillAkiPersen / 100) * 180) - 180 }}deg); clip-path: inset(0px 0px 56px 0px);"></div>
                        </div>
                    </div>
                    <div><span class="text-3xl font-black text-white tracking-tight">{{ $avgTeganganAki }}V</span><span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-1">Tegangan Aki</span></div>
                </div>
            </div>

            <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl">
                <h4 class="text-sm font-bold text-white mb-4 uppercase tracking-wider flex items-center gap-2">
                    <span>🔍</span> Ringkasan Batas Ekstrem Parameter (Hari Ini)
                </h4>
                <div class="overflow-x-auto rounded-2xl border border-white/5 bg-slate-950/20">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-950/50 border-b border-white/10 text-slate-400 font-bold uppercase">
                                <th class="p-4">Nama Parameter Sensor</th>
                                <th class="p-4 text-rose-400">Nilai Maksimum (Max)</th>
                                <th class="p-4 text-sky-400">Nilai Minimum (Min)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 font-medium text-slate-300">
                            <tr class="hover:bg-white/5 transition"><td class="p-4 font-semibold">🌡️ Suhu Udara Lingkungan</td><td class="p-4 text-rose-400 font-bold">{{ number_format($stats['max_suhu'], 1) }} °C</td><td class="p-4 text-sky-400 font-bold">{{ number_format($stats['min_suhu'], 1) }} °C</td></tr>
                            <tr class="hover:bg-white/5 transition"><td class="p-4 font-semibold">💧 Kelembaban Udara Makro</td><td class="p-4 text-rose-400 font-bold">{{ number_format($stats['max_lembab'], 1) }} %</td><td class="p-4 text-sky-400 font-bold">{{ number_format($stats['min_lembab'], 1) }} %</td></tr>
                            <tr class="hover:bg-white/5 transition"><td class="p-4 font-semibold">🌱 Kelembaban Media Tanah (A)</td><td class="p-4 text-rose-400 font-bold">{{ $stats['max_soil_a'] }} %</td><td class="p-4 text-sky-400 font-bold">{{ $stats['min_soil_a'] }} %</td></tr>
                            <tr class="hover:bg-white/5 transition"><td class="p-4 font-semibold">🌱 Kelembaban Media Tanah (B)</td><td class="p-4 text-rose-400 font-bold">{{ $stats['max_soil_b'] }} %</td><td class="p-4 text-sky-400 font-bold">{{ $stats['min_soil_b'] }} %</td></tr>
                            <tr class="hover:bg-white/5 transition"><td class="p-4 font-semibold">⚡ Tegangan Energi Sistem Aki</td><td class="p-4 text-rose-400 font-bold">{{ number_format($stats['max_aki'], 1) }} V</td><td class="p-4 text-sky-400 font-bold">{{ number_format($stats['min_aki'], 1) }} V</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl">
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-wider">📊 Tren Iklim Udara & Nilai VPD</h4>
                    <div class="relative h-72"><canvas id="chartIklimHariIni"></canvas></div>
                </div>
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl">
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-wider">📊 Tren Kelembaban Tanah Media Tanam (Soil A & B)</h4>
                    <div class="relative h-72"><canvas id="chartTanahHariIni"></canvas></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl md:col-span-2">
                    <h4 class="text-xs font-bold text-sky-400 uppercase mb-4 tracking-wider">⏱️ Grafik Histori Log Kerja Alat (Pompa & Kipas Exhaust)</h4>
                    <div class="relative h-56"><canvas id="logAktuatorChart"></canvas></div>
                </div>
                <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl">
                    <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-wider">⚡ Tren Tegangan Suplai Aki (Voltase)</h4>
                    <div class="relative h-56"><canvas id="chartAkiHariIni"></canvas></div>
                </div>
            </div>

            <div class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl">
                <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-wider text-center">📊 Proporsi Distribusi Status Sumber Daya Listrik (Hari Ini)</h4>
                <div class="relative h-64 flex justify-center"><canvas id="sumberDayaChart"></canvas></div>
            </div>

        </div>
    </div>

    <script>
        let chartIklim, chartTanah, chartLogAlat, chartAki;

        // Modifikasi global default font Chart.js agar serasi dengan tema gelap premium
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)';

        // Inisialisasi Donut Chart
        new Chart(document.getElementById('sumberDayaChart'), {
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
                plugins: { legend: { labels: { color: '#f8fafc' } } },
                animation: { animateScale: true, animateRotate: true, duration: 1500, easing: 'easeOutElastic' }
            }
        });

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
                        y: { position: 'left', grid: { color: 'rgba(255,255,255,0.05)' } }, 
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
                        y: { min: 0, max: 1, ticks: { stepSize: 1, callback: v => v === 1 ? 'ON' : 'OFF', color: '#f8fafc' } } 
                    } 
                }
            });

            // 4. Chart Aki (Skala Terkalibrasi 10V - 15V)
            chartAki = new Chart(document.getElementById('chartAkiHariIni'), {
                type: 'line',
                data: { labels: [], datasets: [{ label: 'Tegangan Aki (V)', data: [], borderColor: '#eab308', backgroundColor: 'transparent', tension: 0.2 }]},
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    animation: animationOptions, 
                    scales: { 
                        y: { min: 10, max: 15, ticks: { stepSize: 0.5 } } 
                    } 
                }
            });

            // Muat data default range 1 Jam awal
            updateCharts('1-jam');
        });
    </script>
</x-app-layout>