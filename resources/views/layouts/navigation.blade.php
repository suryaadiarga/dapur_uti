<!-- Responsive Sidebar Navigation (Mobile & Desktop) -->
<aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 transition-all duration-300 lg:static lg:z-30"
       :class="{
           '-translate-x-full lg:translate-x-0': !mobileOpen,
           'translate-x-0': mobileOpen,
           'w-64': sidebarOpen,
           'w-20': !sidebarOpen
       }">

    <!-- Mobile Backdrop Overlay -->
    <div x-show="mobileOpen" 
         @click="mobileOpen = false" 
         class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm -z-10 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
    </div>

    <!-- Logo & Brand Header -->
    <div class="h-16 flex items-center px-5 border-b border-slate-200 dark:border-slate-800 justify-between shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            @php
                $sidebarSetting = \App\Models\Setting::first();
            @endphp

            @if($sidebarSetting && $sidebarSetting->logo_path)
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                    <img src="{{ Storage::url($sidebarSetting->logo_path) }}" class="w-full h-full object-cover" alt="Logo Usaha">
                </div>
            @else
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shrink-0 shadow-lg shadow-indigo-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            @endif

            <span x-show="sidebarOpen" class="font-extrabold text-lg tracking-wide text-slate-900 dark:text-white whitespace-nowrap">
                {{ $sidebarSetting->app_name ?? 'DAPUR UTI' }}
            </span>
        </a>

        <!-- Tombol Close khusus Mobile -->
        <button @click="mobileOpen = false" class="lg:hidden text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Nav Items Container -->
    <div class="flex-1 overflow-y-auto py-5 px-3 space-y-6 custom-scrollbar">

        @php
            $menuSections = [
                'Main Menu' => [
                    ['route' => 'dashboard', 'pattern' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'color' => 'text-blue-500'],
                    ['route' => 'income.index', 'pattern' => 'income.*', 'label' => 'Income / Pemasukan', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-emerald-500'],
                    ['route' => 'expense.index', 'pattern' => 'expense.*', 'label' => 'Expense / Pengeluaran', 'icon' => 'M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'text-rose-500'],
                    ['route' => 'receipts.index', 'pattern' => 'receipts.*', 'label' => 'Kwitansi / Receipts', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'text-indigo-500'],
                    ['route' => 'inventories.index', 'pattern' => 'inventories.*', 'label' => 'Inventories', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => 'text-cyan-500'],
                    ['route' => 'cash.index', 'pattern' => 'cash.*', 'label' => 'Buku Kas (Cash)', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'text-amber-500'],
                ],
                'Management' => [
                    ['route' => 'people.index', 'pattern' => 'people.*', 'label' => 'People / Kontak', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'text-violet-500'],
                    ['route' => 'attendances.index', 'pattern' => 'attendances.*', 'label' => 'Absensi Person', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2m-6 9l2 2 4-4', 'color' => 'text-teal-500'],
                    ['route' => 'salaries.index', 'pattern' => 'salaries.*', 'label' => 'Gaji Karyawan', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'text-emerald-500'],
                    ['route' => 'meal-schedules.index', 'pattern' => 'meal-schedules.*', 'label' => 'Jadwal Makanan', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'text-orange-500'],
                    ['route' => 'invoices.index', 'pattern' => 'invoices.*', 'label' => 'Invoice / Tagihan', 'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z', 'color' => 'text-yellow-500'],
                    ['route' => 'reports.index', 'pattern' => 'reports.*', 'label' => 'Laporan / Reports', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'text-purple-500'],
                    ['route' => 'settings.edit', 'pattern' => 'settings.*', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'text-slate-500'],
                ]
            ];
        @endphp

        @foreach($menuSections as $sectionTitle => $items)
            <div class="space-y-1">
                <div x-show="sidebarOpen" class="px-3 pb-2 text-[10px] font-bold tracking-wider text-slate-400 dark:text-slate-500 uppercase">
                    {{ $sectionTitle }}
                </div>
                @foreach($items as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition font-medium text-sm {{ request()->routeIs($item['pattern']) ? 'bg-indigo-50 dark:bg-indigo-600/20 text-indigo-700 dark:text-indigo-300 font-semibold border border-indigo-200 dark:border-indigo-500/30' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/60' }}"
                       title="{{ $item['label'] }}">
                        <svg class="w-5 h-5 shrink-0 {{ $item['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span x-show="sidebarOpen" class="truncate">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</aside>