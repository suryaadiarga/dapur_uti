<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && true) }" 
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dapur Uti Finance') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN (Garansi Tampilan Langsung Jalan Tanpa NPM Build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- AlpineJS for Dropdowns & Sidebar -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Dinamis Background & Text berdasarkan class .dark di html */
        html:not(.dark) body {
            background-color: #f8fafc !important;
            color: #1e293b;
        }
        html.dark body {
            background-color: #0b0f19 !important;
            color: #f1f5f9;
        }

        /* --- KELAS KHUSUS EXPENSE & INCOME --- */
        .text-expense {
            color: #ef4444 !important; /* Merah */
        }
        .text-income {
            color: #22c55e !important; /* Hijau */
        }
        /* ------------------------------------ */

        /* --- OTOMATIS WARNA TEKS KONTEN DI LIGHT MODE --- */
        html:not(.dark) h1, 
        html:not(.dark) h2, 
        html:not(.dark) h3, 
        html:not(.dark) h4, 
        html:not(.dark) h5, 
        html:not(.dark) h6, 
        html:not(.dark) strong {
            color: #0f172a !important;
        }
        html:not(.dark) p, 
        html:not(.dark) span:not([class*="text-"]) {
            color: #475569;
        }
        /* ------------------------------------------------ */

        /* ============================================================
           DATA-TABLE STYLING (DIJAMIN NGEFEK & KONTRAS)
           ============================================================ */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.875rem;
        }

        /* Table Head (Sangat Kontras & Menonjol) */
        .data-table thead th {
            background: #cbd5e1 !important; /* Light mode: Abu-abu jelas & kontras */
            color: #0f172a !important;      /* Teks gelap tebal */
            font-size: 0.75rem !important;
            font-weight: 800 !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            padding: 0.9rem 1rem !important;
            border-bottom: 2px solid #94a3b8 !important;
            text-align: left;
            white-space: nowrap;
        }

        .dark .data-table thead th {
            background: #1e293b !important; /* Dark mode: Slate solid */
            color: #f8fafc !important;      /* Teks putih terang */
            border-bottom: 2px solid #334155 !important;
        }

        .data-table thead th:first-child {
            border-radius: 0.75rem 0 0 0;
        }

        .data-table thead th:last-child {
            border-radius: 0 0.75rem 0 0;
        }

        /* Table Body (Isi Tabel) */
        html:not(.dark) .data-table {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
        }

        html.dark .data-table {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid #1e293b;
            border-radius: 0.75rem;
        }

        .data-table tbody td {
            padding: 0.875rem 1rem !important;
            font-weight: 400 !important;
            text-transform: none !important;
            letter-spacing: normal !important;
            vertical-align: middle;
            transition: background 0.15s ease;
        }

        html:not(.dark) .data-table tbody td {
            color: #334155 !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        html.dark .data-table tbody td {
            color: #cbd5e1 !important;
            border-bottom: 1px solid rgba(30, 41, 59, 0.6) !important;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none !important;
        }

        .data-table tbody tr:hover td {
            background-color: rgba(241, 245, 249, 0.8) !important;
        }
        .dark .data-table tbody tr:hover td {
            background-color: rgba(30, 41, 59, 0.4) !important;
        }
        /* --------------------------------------------------- */

        /* Pembatas Ukuran Maksimal SVG agar tidak membesar */
        svg {
            max-width: 100%;
            display: inline-block;
        }
        /* Glass Panel Styling Dinamis */
        html:not(.dark) .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }
        html.dark .glass-panel {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        /* Glass Card Styling Dinamis */
        html:not(.dark) .glass-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        }
        html.dark .glass-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7) 0%, rgba(15, 23, 42, 0.9) 100%);
            border: 1px solid rgba(51, 65, 85, 0.5);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }
        .nav-active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.25) 0%, rgba(37, 99, 235, 0.05) 100%);
            border-left: 3px solid #3b82f6;
            color: #60a5fa !important;
        }
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(51, 65, 85, 0.5);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(71, 85, 105, 0.8);
        }
    </style>
</head>
<body class="antialiased min-h-screen selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: true, mobileOpen: false }">

    <!-- Glow Background Effects -->
    <div class="fixed top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
    <div class="fixed bottom-0 right-10 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation -->
        @include('layouts.navigation')

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 w-0 overflow-hidden">

            <!-- Top Header Navbar -->
            <header class="glass-panel sticky top-0 z-20 flex items-center justify-between px-6 h-16 border-b">
                <div class="flex items-center gap-4">
                    <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-slate-400 hover:text-slate-600 dark:hover:text-white p-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-slate-400 hover:text-slate-600 dark:hover:text-white p-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h12M4 18h16"/></svg>
                    </button>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white tracking-wide">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>

                <!-- Right Tools: Theme Toggle & Profile -->
                <div class="flex items-center gap-3">
                    
                    <!-- Tombol Toggle Theme Dark / Light -->
                    <button @click="darkMode = !darkMode" 
                            class="p-2.5 rounded-xl bg-slate-200/70 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700 transition border border-slate-300/60 dark:border-slate-700"
                            :title="darkMode ? 'Ubah ke Light Mode' : 'Ubah ke Dark Mode'">
                        <!-- Icon Matahari -->
                        <svg x-show="darkMode" class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <!-- Icon Bulan -->
                        <svg x-show="!darkMode" class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-200/70 dark:hover:bg-slate-800 transition border border-transparent hover:border-slate-300 dark:hover:border-slate-700">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center font-bold text-white shadow-md">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-sm font-medium text-slate-700 dark:text-slate-200">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-2xl py-2 z-50">
                            <a href="{{ route('settings.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-600/20 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2.5 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Body -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8 space-y-6 custom-scrollbar">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>