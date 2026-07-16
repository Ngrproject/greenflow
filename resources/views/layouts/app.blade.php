<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ tema: localStorage.getItem('greenflow_theme') || 'dark' }"
      x-init="$watch('tema', val => localStorage.setItem('greenflow_theme', val))"
      :class="tema">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GreenFlow - Smart Greenhouse Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans antialiased min-h-screen transition-colors duration-300"
      :class="tema === 'dark' ? 'bg-gradient-to-br from-slate-950 via-emerald-950 to-slate-950 text-slate-100' : 'bg-slate-100 text-slate-900'"
      x-data="{ sidebarOpen: window.innerWidth > 768 }">

    <div class="flex min-h-screen overflow-hidden">
        
        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0 md:w-20'" 
               :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
               class="fixed inset-y-0 left-0 z-50 dark:bg-slate-900/95 md:dark:bg-slate-900/60 dark:backdrop-blur-xl border-r transition-all duration-300 flex flex-col justify-between transform md:transform-none shadow-sm dark:shadow-none">
            
            <div>
                <div class="p-5 flex items-center justify-between border-b"
                     :style="tema === 'light' ? 'border-color: #f1f5f9 !important;' : 'border-color: rgba(255,255,255,0.05) !important;'">
                    <div class="flex items-center gap-2 overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain shrink-0">
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition ml-2">
                        <i class="fa-solid" :class="sidebarOpen ? 'fa-angle-left' : 'fa-bars'"></i>
                    </button>
                </div>

                <nav class="p-4 space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       :style="request()->routeIs('dashboard') && tema === 'light' ? 'background: #f1f5f9 !important; border-color: #cbd5e1 !important; color: #059669 !important;' : ''"
                       class="{{ request()->routeIs('dashboard') ? 'dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 dark:border-emerald-500/40' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-gauge text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Dashboard</span>
                    </a>

                    <a href="{{ route('analisis') }}" 
                       :style="request()->routeIs('analisis') && tema === 'light' ? 'background: #f1f5f9 !important; border-color: #cbd5e1 !important; color: #059669 !important;' : ''"
                       class="{{ request()->routeIs('analisis') ? 'dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 dark:border-emerald-500/40' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-chart-line text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Analisis Data</span>
                    </a>

                    <a href="/jadwal" 
                       :style="request()->is('jadwal*') && tema === 'light' ? 'background: #f1f5f9 !important; border-color: #cbd5e1 !important; color: #059669 !important;' : ''"
                       class="{{ request()->is('jadwal*') ? 'dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 dark:border-emerald-500/40' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-calendar-days text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Jadwal & SOP</span>
                    </a>

                    <a href="{{ route('device.setting') }}" 
                       :style="request()->routeIs('device.setting') && tema === 'light' ? 'background: #f1f5f9 !important; border-color: #cbd5e1 !important; color: #059669 !important;' : ''"
                       class="{{ request()->routeIs('device.setting') ? 'dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 dark:border-emerald-500/40' : 'border-transparent text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-sliders text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Pengaturan Alat</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t" :style="tema === 'light' ? 'border-color: #f1f5f9 !important;' : 'border-color: rgba(255,255,255,0.05) !important;'">
                <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important;' : ''"
                     class="flex items-center gap-3 p-2 rounded-xl dark:bg-slate-950/40 border border-white/5 overflow-hidden">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20 border border-emerald-500/20 dark:border-emerald-500/30 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user-gear text-xs text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <div x-show="sidebarOpen" class="text-left">
                        <p class="text-[11px] font-black uppercase tracking-wider"
                           :style="tema === 'light' ? 'color: #0f172a !important;' : 'color: #e2e8f0 !important;'">
                            {{ auth()->check() ? auth()->user()->name : 'Dimsky' }}
                        </p>
                        <p class="text-[9px] text-slate-400 dark:text-slate-500">Greenflow Admin</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col transition-all duration-300 min-h-screen"
             :class="sidebarOpen ? 'md:pl-64' : 'md:pl-20'">
            
            <header :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important;' : ''"
                    class="sticky top-0 z-40 dark:bg-slate-950/40 border-b border-slate-200 dark:border-white/5 px-6 py-4 flex items-center justify-between transition-colors duration-300">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition md:hidden">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div class="text-xs font-semibold tracking-wide hidden sm:block"
                         :style="tema === 'light' ? 'color: #475569 !important;' : 'color: #94a3b8 !important;'">
                        <span class="text-emerald-600 dark:text-emerald-400">Greenhouse Location:</span> Kabupaten Kebumen, Central Java
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div :style="tema === 'light' ? 'background: #f8fafc !important; border-color: #e2e8f0 !important; color: #1e293b !important;' : ''"
                         class="text-xs font-mono font-bold text-slate-800 dark:text-slate-300 bg-slate-100 dark:bg-slate-900/80 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-white/5 shadow-sm">
                        <i class="fa-regular fa-clock text-emerald-600 dark:text-emerald-400 mr-1"></i>
                        {{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }} WIB
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                {{ $slot }}
            </main>

            <footer :style="tema === 'light' ? 'background: #ffffff !important; border-color: #e2e8f0 !important; color: #64748b !important;' : ''"
                    class="dark:bg-slate-950/20 border-t border-slate-200 dark:border-white/5 py-4 px-8 flex flex-col sm:flex-row justify-between items-center gap-2 text-[11px] text-slate-500 transition-colors duration-300">
                <div>
                    &copy; {{ date('Y') }} <span :style="tema === 'light' ? 'color: #1e293b !important;' : ''" class="dark:text-slate-400 font-bold tracking-wide">GreenFlow Project</span>. All Rights Reserved.
                </div>
                <div class="flex items-center gap-1">
                    <span>Designed for Capstone System</span>
                    <span class="text-emerald-500 font-bold">•</span>
                    <span>Build With Love By : NGR Media</span>
                </div>
            </footer>

        </div>
    </div>
</body>
</html>