<div class="space-y-6">
    
    <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
         class="dark:bg-white/5 dark:backdrop-blur-md border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-all duration-300">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <i class="fa-solid fa-calendar-days text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-wide transition-colors"
                    :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                    Pengaturan SOP & Jadwal Siram
                </h2>
                <p class="text-xs mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">
                    GREENFLOW - GREENHOUSE MELON MANAGEMENT SYSTEM
                </p>
            </div>
        </div>
        
        <div class="px-5 py-2.5 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold tracking-wide shadow-sm text-center text-xs">
            🌱 Usia Tanaman Saat Ini: <span class="text-emerald-700 dark:text-white bg-emerald-500 px-2 py-0.5 rounded-lg ml-1 font-mono">{{ $hst_berjalan }} HST</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="dark:bg-slate-900/40 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl transition-all duration-300">
            <h3 class="text-xs font-bold tracking-wider uppercase flex items-center gap-2 border-b pb-2 mb-4"
                :style="tema === 'light' ? 'color: #1e293b !important; border-color: #f1f5f9 !important;' : 'color: #ffffff !important; border-color: rgba(255,255,255,0.05) !important;'">
                <i class="fa-solid fa-calendar-plus text-emerald-500 dark:text-emerald-400"></i> Atur Siklus Awal Tanam
            </h3>

            @if (session()->has('pesan_tanam'))
                <div class="p-3 mb-3 text-[10px] bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-600 dark:text-emerald-400 font-bold">
                    {{ session('pesan_tanam') }}
                </div>
            @endif

            <form wire:submit.prevent="simpanTanggalTanam" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tanggal Mulai Menanam</label>
                    <input type="date" wire:model="tanggal_tanam" 
                           :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                           class="w-full rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:border-emerald-500 transition font-mono">
                </div>
                
                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 text-xs font-bold uppercase text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition rounded-xl shadow-md">
                    💾 Simpan & Sinkron Alat
                </button>
            </form>
        </div>

        <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
             class="dark:bg-slate-900/40 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl lg:col-span-2 transition-all duration-300">
            <h3 class="text-xs font-bold tracking-wider uppercase flex items-center gap-2 border-b pb-2 mb-4"
                :style="tema === 'light' ? 'color: #1e293b !important; border-color: #f1f5f9 !important;' : 'color: #ffffff !important; border-color: rgba(255,255,255,0.05) !important;'">
                <i class="fa-solid fa-plus text-teal-500 dark:text-teal-400"></i> Tambah Rentang Jadwal SOP
            </h3>

            @if (session()->has('pesan'))
                <div class="p-3 mb-3 text-[10px] bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-600 dark:text-emerald-400 font-bold">
                    {{ session('pesan') }}
                </div>
            @endif

            <form wire:submit.prevent="simpanJadwal" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1.5">HST Mulai</label>
                        <input type="number" wire:model="hst_mulai" placeholder="Contoh: 1" 
                               :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                               class="w-full rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-teal-500 transition">
                        @error('hst_mulai') <span class="text-[9px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1.5">HST Selesai</label>
                        <input type="number" wire:model="hst_selesai" placeholder="Contoh: 10" 
                               :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                               class="w-full rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-teal-500 transition">
                        @error('hst_selesai') <span class="text-[9px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1.5">Target Nutrisi (ml / Pohon)</label>
                        <input type="number" wire:model="target_ml" placeholder="Contoh: 250" 
                               :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                               class="w-full rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-teal-500 transition">
                        @error('target_ml') <span class="text-[9px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-1.5">Alokasi Waktu Siram (Pisahkan Koma)</label>
                        <input type="text" wire:model="waktu_siram" placeholder="Contoh: 07:00, 13:00, 17:00" 
                               :style="tema === 'light' ? 'background: #ffffff !important; color: #0f172a !important; border-color: #cbd5e1 !important; color: #0f172a !important;' : 'background: #020617 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.1) !important;'"
                               class="w-full rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-teal-500 transition font-mono">
                        @error('waktu_siram') <span class="text-[9px] text-rose-500 font-bold block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="w-full py-3 text-xs font-bold uppercase text-slate-950 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 transition rounded-xl shadow-md active:scale-[0.99]">
                    Simpan Jadwal
                </button>
            </form>
        </div>
    </div>

    <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
         class="dark:bg-slate-900/40 dark:backdrop-blur-xl border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl transition-all duration-300">
        <h4 class="text-xs font-bold mb-4 uppercase tracking-wider flex items-center gap-2"
            :style="tema === 'light' ? 'color: #1e293b !important;' : 'color: #ffffff !important;'">
            <i class="fa-solid fa-rectangle-list text-emerald-500 dark:text-emerald-400"></i> Matriks Rencana Distribusi Nutrisi Otomatis
        </h4>
        <div class="overflow-x-auto rounded-2xl border bg-slate-50 dark:bg-slate-950/20"
             :style="tema === 'light' ? 'border-color: #e2e8f0 !important;' : 'border-color: rgba(255,255,255,0.05) !important;'">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr :style="tema === 'light' ? 'background: #f1f5f9 !important; border-color: #e2e8f0 !important; color: #475569 !important;' : ''"
                        class="dark:bg-slate-950/50 border-b dark:border-white/10 dark:text-slate-400 font-bold uppercase text-[10px]">
                        <th class="p-4 text-center">Fase Mulai</th>
                        <th class="p-4 text-center">Fase Akhir</th>
                        <th class="p-4">Dosis Target</th>
                        <th class="p-4">Plot Waktu Siram</th>
                        <th class="p-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y font-medium text-slate-700 dark:text-slate-300"
                       :style="tema === 'light' ? 'divide-color: #e2e8f0 !important;' : 'divide-color: rgba(255,255,255,0.05) !important;'">
                    @forelse($jadwals as $jadwal)
                        <tr class="transition" :style="tema === 'light' ? 'hover:background: #f8fafc !important;' : 'hover:bg-white/5'">
                            <td class="p-4 text-center font-bold text-emerald-600 dark:text-emerald-400">{{ $jadwal->hst_mulai }} HST</td>
                            <td class="p-4 text-center font-bold text-teal-600 dark:text-teal-400">{{ $jadwal->hst_selesai }} HST</td>
                            <td class="p-4 font-bold text-sky-600 dark:text-sky-400">{{ $jadwal->target_ml }} ml / pohon</td>
                            <td class="p-4">
                                @if(is_array($jadwal->waktu_siram))
                                    @foreach($jadwal->waktu_siram as $jam)
                                        <span :style="tema === 'light' ? 'background: #e2e8f0 !important; color: #1e293b !important; border-color: #cbd5e1 !important;' : ''"
                                              class="dark:bg-slate-950/60 border dark:border-white/5 px-2 py-0.5 rounded dark:text-slate-200 font-mono text-[10px] inline-block mr-1 mt-1 shadow-sm dark:shadow-none">{{ $jam }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <button wire:click="hapusJadwal({{ $jadwal->id }})" class="px-2.5 py-1 bg-rose-500/10 hover:bg-rose-500 text-rose-600 hover:text-white rounded-lg border border-rose-500/20 text-[10px] font-bold transition">
                                    🗑️ Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Belum ada matriks jadwal SOP yang diinput ke sistem.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>