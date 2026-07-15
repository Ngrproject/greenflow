<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GreenFlow - Smart Greenhouse Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-950 via-emerald-950 to-slate-950 min-h-screen text-slate-100" 
      x-data="{ sidebarOpen: window.innerWidth > 768 }">

    <div class="flex min-h-screen overflow-hidden">
        
        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0 md:w-20'" 
               class="fixed inset-y-0 left-0 z-50 backdrop-blur-xl bg-slate-900/95 md:bg-slate-900/60 border-r border-white/10 transition-all duration-300 flex flex-col justify-between transform md:transform-none">
            
            <div>
                <div class="p-5 flex items-center justify-between border-b border-white/5">
                    <div class="flex items-center gap-2 overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain shrink-0">
                        <span x-show="sidebarOpen" x-transition class="font-bold text-base text-white tracking-wider font-sans ml-1"></span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white transition ml-2">
                        <i class="fa-solid" :class="sidebarOpen ? 'fa-angle-left' : 'fa-bars'"></i>
                    </button>
                </div>

                <nav class="p-4 space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       class="{{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-500/20 to-teal-500/10 border-emerald-500/40 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-gauge text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Dashboard</span>
                    </a>

                    <a href="{{ route('analisis') }}" 
                       class="{{ request()->routeIs('analisis') ? 'bg-gradient-to-r from-emerald-500/20 to-teal-500/10 border-emerald-500/40 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-chart-line text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Analisis Data</span>
                    </a>

                    <a href="/jadwal" 
                       class="{{ request()->is('jadwal*') ? 'bg-gradient-to-r from-emerald-500/20 to-teal-500/10 border-emerald-500/40 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-calendar-days text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Jadwal & SOP</span>
                    </a>

                    <a href="{{ route('device.setting') }}" 
                    class="{{ request()->routeIs('device.setting') ? 'bg-gradient-to-r from-emerald-500/20 to-teal-500/10 border-emerald-500/40 text-emerald-400' : 'border-transparent text-slate-400 hover:bg-white/5 hover:text-slate-200' }} flex items-center gap-4 px-4 py-3 rounded-xl border transition duration-200 group">
                        <i class="fa-solid fa-sliders text-sm shrink-0 group-hover:scale-110 transition"></i>
                        <span x-show="sidebarOpen" class="text-xs font-bold uppercase tracking-wider">Pengaturan Alat</span>
                    </a>

                </nav>
            </div>

            <div class="p-4 border-t border-white/5">
                <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-950/40 border border-white/5 overflow-hidden">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user-gear text-xs text-emerald-400"></i>
                    </div>
                    <div x-show="sidebarOpen" class="text-left">
                        <p class="text-[11px] font-black uppercase text-slate-200 tracking-wider">
                            {{ auth()->check() ? auth()->user()->name : 'Dimsky' }}
                        </p>
                        <p class="text-[9px] text-slate-500"></p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col transition-all duration-300 min-h-screen"
             :class="sidebarOpen ? 'md:pl-64' : 'md:pl-20'">
            
                        <!-- ================= 2. TOP HEADER BAR ================= -->
            <header class="sticky top-0 z-40 backdrop-blur-md bg-slate-950/40 border-b border-white/5 px-6 py-4 flex items-center justify-between">
                <!-- Hamburger Trigger for Mobile/Tablet Toggle -->
                <div class="flex items-center gap-4">
                    <!-- PERBAIKAN UTAMA: Ditambahkan kelas md:hidden agar tersembunyi di desktop -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white transition md:hidden">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div class="text-xs font-semibold text-slate-400 tracking-wide hidden sm:block">
                        <span class="text-emerald-400">Greenhouse Location:</span> Kabupaten Kebumen, Central Java
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-xs font-mono font-bold text-slate-300 bg-slate-900/80 px-3 py-1.5 rounded-xl border border-white/5 shadow-inner">
                        <i class="fa-regular fa-clock text-emerald-400 mr-1"></i>
                        {{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }} WIB
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8">
                {{ $slot }}
            </main>

            <footer class="backdrop-blur-md bg-slate-950/20 border-t border-white/5 py-4 px-8 flex flex-col sm:flex-row justify-between items-center gap-2 text-[11px] text-slate-500 font-medium font-sans">
                <div>
                    &copy; {{ date('Y') }} <span class="text-slate-400 font-bold tracking-wide">GreenFlow Project</span>. All Rights Reserved.
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