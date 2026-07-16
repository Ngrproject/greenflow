<div class="space-y-6">
    <!-- ================= BANNER NOTIFIKASI ================= -->
    <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
         class="dark:bg-white/5 dark:backdrop-blur-md border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm dark:shadow-2xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-all duration-300">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-600 dark:text-sky-400">
                <i class="fa-regular fa-bell text-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-wide transition-colors"
                    :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #ffffff !important;'">
                    Pusat Notifikasi & Log Sistem
                </h2>
                <p class="text-xs mt-0.5" :style="tema === 'light' ? 'color: #64748b !important;' : 'color: #94a3b8 !important;'">
                    GREENFLOW — NATIVE WEB TELEMETRY LOG SYSTEM
                </p>
            </div>
        </div>
        <button wire:click="bersihkanSemuaLog" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-rose-600 hover:text-white bg-rose-500/10 hover:bg-rose-600 border border-rose-500/20 rounded-xl transition-all active:scale-95">
            🗑️ Bersihkan Semua Log
        </button>
    </div>

    <!-- ================= DAFTAR GELEMBUNG LOG SYSTEM ================= -->
    <div :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
         class="backdrop-blur-xl bg-slate-900/40 border border-white/10 rounded-3xl p-6 shadow-2xl space-y-4 transition-all duration-300">
        
        <div class="space-y-3">
            @forelse($logs ?? [] as $log)
                <div :style="tema === 'light' ? 'background: #f8fafc !important;' : ''"
                     class="p-4 rounded-2xl border flex items-start gap-3 transition-all
                     @if($log->type == 'critical') bg-rose-500/5 border-rose-500/15 dark:border-rose-500/20
                     @elseif($log->type == 'warning') bg-orange-500/5 border-orange-500/15 dark:border-orange-500/20
                     @elseif($log->type == 'success') bg-emerald-500/5 border-emerald-500/15 dark:border-emerald-500/20
                     @else bg-slate-950/20 border-slate-200 dark:border-white/5 @endif">
                    
                    <!-- Icon Indicator -->
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0
                         @if($log->type == 'critical') bg-rose-500/20 text-rose-500
                         @elseif($log->type == 'warning') bg-orange-500/20 text-orange-500
                         @elseif($log->type == 'success') bg-emerald-500/20 text-emerald-500
                         @else bg-sky-500/20 text-sky-500 @endif">
                        <i class="fa-solid @if($log->type == 'critical') fa-triangle-exclamation animate-pulse @elseif($log->type == 'warning') fa-ban @elseif($log->type == 'success') fa-circle-check @else fa-circle-info @endif text-xs"></i>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 space-y-0.5">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-black uppercase tracking-wider 
                                  @if($log->type == 'critical') text-rose-500
                                  @elseif($log->type == 'warning') text-orange-500
                                  @elseif($log->type == 'success') text-emerald-500
                                  @else text-sky-500 @endif">
                                @if($log->type == 'critical') ⚠️ Kritis / Alarm @elseif($log->type == 'warning') 🛑 Peringatan Alat @elseif($log->type == 'success') ✅ Berhasil @else ℹ️ Info Sistem @endif
                            </span>
                            <span class="text-[9px] text-slate-400 font-mono">{{ $log->created_at->format('d M Y - H:i') }} WIB</span>
                        </div>
                        <p class="text-xs font-medium" :style="tema === 'light' ? 'color: #1e293b !important;' : 'color: #e2e8f0 !important;'">
                            {{ $log->message }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider text-xs">
                    📭 Belum ada riwayat notifikasi baru yang terekam di web.
                </div>
            @endforelse
        </div>
    </div>
</div>