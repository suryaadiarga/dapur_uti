<!-- Responsive Sidebar Navigation (Mobile & Desktop) -->
<aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-slate-900/95 border-r border-slate-800/80 transition-all duration-300 lg:static lg:z-30"
       :class="{
            '-translate-x-full lg:translate-x-0': !mobileOpen,
            'translate-x-0': mobileOpen,
            'w-64': sidebarOpen,
            'w-20': !sidebarOpen
       }">

    <!-- Mobile Backdrop Overlay -->
    <div x-show="mobileOpen" 
         @click="mobileOpen = false" 
         class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm -z-10 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
    </div>

    <!-- Logo & Brand -->
    <div class="h-16 flex items-center px-6 border-b border-slate-800/80 justify-between shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-cyan-400 flex items-center justify-center shrink-0 shadow-lg shadow-blue-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span x-show="sidebarOpen" class="font-extrabold text-lg tracking-wide bg-gradient-to-r from-white via-slate-200 to-blue-400 bg-clip-text text-transparent whitespace-nowrap">
                DAPUR UTI<span class="text-blue-500">APP</span>
            </span>
        </a>
        <!-- Tombol Close khusus Mobile -->
        <button @click="mobileOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1.5 rounded-lg bg-slate-800/50 hover:bg-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Nav Items -->
    <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1">

        <div x-show="sidebarOpen" class="px-3 pb-2 text-[10px] font-bold tracking-wider text-slate-500 uppercase">
            Main Menu
        </div>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('dashboard') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span x-show="sidebarOpen" class="truncate">Dashboard</span>
        </a>

        <!-- Income -->
        <a href="{{ route('income.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('income.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Income / Pemasukan</span>
        </a>

        <!-- Expense -->
        <a href="{{ route('expense.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('expense.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Expense / Pengeluaran</span>
        </a>

        <!-- Receipts -->
        <a href="{{ route('receipts.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('receipts.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Kwitansi / Receipts</span>
        </a>

        <!-- Inventories -->
        <a href="{{ route('inventories.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('inventories.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span x-show="sidebarOpen" class="truncate">Inventories</span>
        </a>

        <!-- Cash Book -->
        <a href="{{ route('cash.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('cash.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Buku Kas (Cash)</span>
        </a>

        <div x-show="sidebarOpen" class="px-3 pt-6 pb-2 text-[10px] font-bold tracking-wider text-slate-500 uppercase">
            Management
        </div>

        <!-- People -->
        <a href="{{ route('people.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('people.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span x-show="sidebarOpen" class="truncate">People / Kontak</span>
        </a>

        <!-- Absensi Person -->
        <a href="{{ route('attendances.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('attendances.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4"/></svg>
            <span x-show="sidebarOpen" class="truncate">Absensi Person</span>
        </a>

        <!-- Gaji Karyawan (Baru) -->
        <a href="{{ route('salaries.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('salaries.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Gaji Karyawan</span>
        </a>

        <!-- Jadwal Makanan & Order -->
        <a href="{{ route('meal-schedules.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('meal-schedules.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span x-show="sidebarOpen" class="truncate">Jadwal Makanan</span>
        </a>

        <!-- Invoice / Tagihan (Baru) -->
        <a href="{{ route('invoices.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('invoices.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Invoice / Tagihan</span>
        </a>

        <!-- Reports -->
        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('reports.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Laporan / Reports</span>
        </a>

        <!-- Settings -->
        <a href="{{ route('settings.edit') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/70 transition font-medium text-sm {{ request()->routeIs('settings.*') ? 'nav-active text-blue-400 font-semibold' : '' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
            <span x-show="sidebarOpen" class="truncate">Settings</span>
        </a>
    </div>
</aside>