<x-app-layout>
    <x-slot name="title">Dashboard - Dapur Uti Finance</x-slot>
    <!-- Header Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-full bg-blue-600 animate-pulse"></span>
            <h1 class="text-2xl font-bold text-sky-900 tracking-tight">Dashboard Keuangan</h1>
        </div>
        <p class="text-sm text-sky-500 mt-1">Ringkasan kondisi dan arus kas Dapur Uti bulan ini.</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Card: Uang Masuk -->
    <div class="bg-white rounded-2xl p-5 border border-sky-100/60 shadow-md hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Uang Masuk</span>
            <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-2xl font-extrabold text-sky-900 tracking-tight">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</div>
            <div class="mt-1 flex items-center text-xs text-sky-500">
                <span class="font-bold text-blue-800 bg-blue-50/70 px-2 py-0.5 rounded-full mr-1.5">{{ $incomeCount }}</span> transaksi bulan ini
            </div>
        </div>
    </div>

    <!-- Card: Uang Keluar -->
    <div class="bg-white rounded-2xl p-5 border border-sky-100/60 shadow-md hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Uang Keluar</span>
            <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-2xl font-extrabold text-sky-900 tracking-tight">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</div>
            <div class="mt-1 flex items-center text-xs text-sky-500">
                <span class="font-bold text-blue-800 bg-blue-50/70 px-2 py-0.5 rounded-full mr-1.5">{{ $expenseCount }}</span> transaksi bulan ini
            </div>
        </div>
    </div>

    <!-- Card: Saldo Kas -->
    <div class="bg-gradient-to-br from-sky-700 to-blue-800 rounded-2xl p-5 shadow-md text-white group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-blue-100">Saldo Kas</span>
            <div class="p-2.5 bg-white/10 backdrop-blur rounded-xl text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-2xl font-extrabold tracking-tight">Rp {{ number_format($cashBalance, 0, ',', '.') }}</div>
            <a href="{{ route('cash.index') }}" class="mt-2 inline-flex items-center gap-1 text-xs font-medium text-sky-100 hover:text-white transition group/link">
                Lihat buku kas <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- Card: Nilai Inventaris -->
    <div class="bg-white rounded-2xl p-5 border border-sky-100/60 shadow-md hover:shadow-lg transition group">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Nilai Inventaris</span>
            <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <div class="mt-3">
            <div class="text-2xl font-extrabold text-sky-900 tracking-tight">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</div>
            <a href="{{ route('inventories.index') }}" class="mt-2 inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-700 transition group/link">
                Lihat inventaris <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- Chart & Recent Transactions Section -->
<div class="mt-8 grid gap-6 xl:grid-cols-3">
    <!-- Chart Section -->
    <section class="bg-white rounded-2xl border border-sky-100/60 shadow-md xl:col-span-2 p-6 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-base font-bold text-sky-900">Arus Kas 6 Bulan</h2>
                <p class="text-xs text-sky-500 mt-0.5">Perbandingan uang masuk dan keluar.</p>
            </div>
            <div class="flex gap-4 text-xs font-medium text-slate-600">
                <span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-full bg-blue-600"></i>Masuk</span>
                <span class="flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-full bg-blue-300"></i>Keluar</span>
            </div>
        </div>
        
        <div class="flex-1 flex items-end gap-2 sm:gap-6 relative pt-6 border-b border-slate-100">
            <div class="absolute w-full h-px bg-sky-50 bottom-1/3 left-0 -z-10"></div>
            <div class="absolute w-full h-px bg-sky-50 bottom-2/3 left-0 -z-10"></div>
            
            @foreach ($chart as $item)
                <div class="flex-1 flex flex-col justify-end group">
                    <div class="flex h-52 items-end justify-center gap-1.5 sm:gap-2">
                        <div class="w-full max-w-[24px] rounded-t-lg bg-blue-600 group-hover:bg-blue-700 transition" data-height="{{ max(2, ($item['income'] / $chartMax) * 100) }}" title="Masuk Rp {{ number_format($item['income'], 0, ',', '.') }}"></div>
                        <div class="w-full max-w-[24px] rounded-t-lg bg-blue-200 group-hover:bg-blue-300 transition" data-height="{{ max(2, ($item['expense'] / $chartMax) * 100) }}" title="Keluar Rp {{ number_format($item['expense'], 0, ',', '.') }}"></div>
                    </div>
                    <div class="truncate py-2.5 text-center text-xs font-medium text-sky-500 group-hover:text-sky-600 transition">{{ $item['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Recent Transactions -->
    <section class="bg-white rounded-2xl border border-slate-200/80 shadow-sm flex flex-col">
        <div class="border-b border-sky-50 p-5 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-sky-900">Transaksi Terbaru</h2>
                <p class="text-xs text-sky-500 mt-0.5">5 aktivitas terakhir.</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-sky-50 text-sky-600 rounded-lg">Realtime</span>
        </div>
        <div class="flex-1 flex flex-col p-2 divide-y divide-sky-50">
            @forelse ($latestTransactions as $item)
                <a href="{{ $item['type'] === 'masuk' ? route('income.show', $item['id']) : route('expense.show',$item['id']) }}" class="group flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition">
                    <div class="flex-shrink-0 grid h-9 w-9 place-items-center rounded-xl {{ $item['type'] === 'masuk' ? 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white' : 'bg-sky-50 text-sky-600 group-hover:bg-sky-700 group-hover:text-white' }} transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['type'] === 'masuk' ? 'M19 14l-7 7m0 0l-7-7m7 7V3' : 'M5 10l7-7m0 0l7 7m-7-7v18' }}"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm font-semibold text-sky-800 group-hover:text-sky-600 transition">{{ $item['category'] }}</div>
                        <div class="truncate text-xs text-sky-400 mt-0.5">{{ $item['date']->format('d/m/Y') }} &bull; {{ $item['person'] }}</div>
                    </div>
                    <div class="whitespace-nowrap text-sm font-bold {{ $item['type'] === 'masuk' ? 'text-blue-600' : 'text-sky-700' }}">
                        {{ $item['type'] === 'masuk' ? '+' : '-' }} Rp {{ number_format($item['amount'], 0, ',', '.') }}
                    </div>
                </a>
            @empty
                <div class="flex flex-col items-center justify-center flex-1 p-6 text-center text-slate-400">
                    <p class="text-sm font-semibold text-sky-700">Belum Ada Transaksi</p>
                    <p class="text-xs mt-1 text-sky-400">Transaksi terbaru akan tercatat otomatis di sini.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>

<script>
    // Set chart bar heights from data-height attribute to avoid embedding Blade expressions directly inside inline CSS
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-height]').forEach(function(el){
            var v = el.getAttribute('data-height');
            if(v !== null && v !== '') { el.style.height = v + '%'; }
        });
    });
</script>

</x-app-layout>