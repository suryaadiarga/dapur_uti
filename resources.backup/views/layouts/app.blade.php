<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dapur Uti Finance' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-sky-800 antialiased">
@php
    $appSetting = \App\Models\Setting::query()->first();
@endphp
<div x-data="{ sidebarOpen: false }" class="min-h-screen">
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-stone-950/40 lg:hidden" @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-40 flex w-72 flex-col bg-gradient-to-b from-sky-800 to-blue-900 text-white transition-transform duration-200 lg:translate-x-0">
        <div class="flex h-20 items-center gap-3 border-b border-white/10 px-6">
            @if($appSetting?->logo_path)
                <img src="{{ Storage::url($appSetting->logo_path) }}" class="h-11 w-11 rounded-xl bg-white object-cover" alt="Logo">
            @else
                <div class="grid h-11 w-11 place-items-center rounded-xl bg-cream-100 font-bold text-emerald-900">DU</div>
            @endif
            <div>
                <div class="font-semibold leading-tight">{{ $appSetting?->business_name ?? 'Dapur Uti' }}</div>
                <div class="text-xs text-sky-200">Finance</div>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto p-4 text-sm">
            @php
                $menus = [
                    ['dashboard', 'dashboard', 'Dashboard', 'D'],
                    ['income.*', 'income.index', 'Uang Masuk', 'M'],
                    ['expense.*', 'expense.index', 'Uang Keluar', 'K'],
                    ['receipts.*', 'receipts.index', 'Nota Belanja', 'N'],
                    ['inventories.*', 'inventories.index', 'Inventaris', 'I'],
                    ['people.*', 'people.index', 'Data Orang', 'O'],
                    ['cash.*', 'cash.index', 'Kas', 'KS'],
                    ['reports.*', 'reports.index', 'Laporan', 'L'],
                    ['settings.*', 'settings.edit', 'Pengaturan', 'P'],
                ];
            @endphp
            @foreach($menus as [$pattern, $route, $label, $icon])
                <a href="{{ route($route) }}" @click="sidebarOpen = false"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ request()->routeIs($pattern) ? 'bg-white text-sky-900 shadow-sm' : 'text-sky-50 hover:bg-white/10' }}">
                    <span class="grid h-7 w-7 place-items-center text-base">{{ $icon }}</span>
                    <span class="font-medium">{{ $label }}</span>
                </a>
            @endforeach
        </nav>

        <div class="border-t border-white/10 p-4">
            <div class="mb-3 px-4 text-xs text-sky-200">Login sebagai</div>
            <div class="flex items-center justify-between gap-3 px-4">
                <div class="min-w-0">
                    <div class="truncate text-sm font-medium">{{ auth()->user()->name }}</div>
                    <div class="truncate text-xs text-sky-200">{{ auth()->user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-lg bg-white/10 px-3 py-2 text-xs hover:bg-white/20" title="Logout">Keluar</button>
                </form>
            </div>
        </div>
    </aside>

    <div class="lg:pl-72">
        <header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-stone-200 bg-white/90 px-4 backdrop-blur sm:px-6 lg:px-8">
            <button @click="sidebarOpen = true" class="rounded-lg border border-stone-200 px-3 py-2 lg:hidden" aria-label="Buka menu">Menu</button>
            <div class="ml-auto text-sm text-sky-500">{{ now()->translatedFormat('l, d F Y') }}</div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            @if(session('success'))
                <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <div class="font-semibold">Periksa kembali data berikut:</div>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
