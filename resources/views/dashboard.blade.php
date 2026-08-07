<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="space-y-6">
        <!-- Banner / Header Ringkasan -->
        <div class="glass-card rounded-2xl p-6 lg:p-8 relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800/90 to-blue-950 border border-slate-700/50">
            <div class="relative z-10 max-w-2xl">
                <h1 class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">
                    Ringkasan Keuangan & Stok 📊
                </h1>
                <p class="mt-2 text-slate-400 text-sm lg:text-base leading-relaxed">
                    Performa transaksi bulan ini, saldo kas, serta estimasi nilai total inventaris Anda secara real-time.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('income.create') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm shadow-lg shadow-emerald-600/30 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Catat Pemasukan
                    </a>
                    <a href="{{ route('expense.create') }}" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-semibold text-sm shadow-lg shadow-rose-600/30 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        Catat Pengeluaran
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Pemasukan Bulan Ini -->
            <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pemasukan (Bulan Ini)</span>
                    <div class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-bold text-white">
                        Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Total {{ $incomeCount }} transaksi bulan ini
                    </p>
                </div>
            </div>

            <!-- Pengeluaran Bulan Ini -->
            <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pengeluaran (Bulan Ini)</span>
                    <div class="p-2 rounded-xl bg-rose-500/10 text-rose-400 border border-rose-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-bold text-white">
                        Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Total {{ $expenseCount }} transaksi bulan ini
                    </p>
                </div>
            </div>

            <!-- Saldo Kas & Bank -->
            <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Saldo Kas & Bank</span>
                    <div class="p-2 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-bold {{ $cashBalance >= 0 ? 'text-white' : 'text-rose-400' }}">
                        Rp {{ number_format($cashBalance, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Akumulasi total kas saat ini
                    </p>
                </div>
            </div>

            <!-- Total Nilai Inventaris -->
            <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nilai Inventaris</span>
                    <div class="p-2 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="text-2xl font-bold text-white">
                        Rp {{ number_format($inventoryValue, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-slate-400 mt-1">
                        Estimasi nilai total aset barang
                    </p>
                </div>
            </div>
        </div>

        <!-- Chart Grafik Pemasukan vs Pengeluaran (7 Bulan Terakhir) -->
        <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-white">Tren Keuangan (7 Bulan Terakhir)</h3>
                    <p class="text-xs text-slate-400">Perbandingan total pemasukan dan pengeluaran per bulan</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-medium">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-slate-300">Pemasukan</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="text-slate-300">Pengeluaran</span>
                    </div>
                </div>
            </div>

            <!-- Visualisasi Bar Chart -->
            <div class="h-64 flex items-end justify-between gap-2 lg:gap-6 pt-8 pb-2 px-2 border-b border-slate-800">
                @foreach($chart as $item)
                    @php
                        $incPercent = $chartMax > 0 ? ($item['income'] / $chartMax) * 100 : 0;
                        $expPercent = $chartMax > 0 ? ($item['expense'] / $chartMax) * 100 : 0;
                    @endphp
                    <div class="flex-1 flex flex-col items-center h-full justify-end group relative">
                        <!-- Tooltip Hover -->
                        <div class="absolute -top-12 hidden group-hover:flex flex-col items-center bg-slate-950 text-white text-[10px] py-1.5 px-3 rounded-lg border border-slate-700 shadow-xl z-20 whitespace-nowrap pointer-events-none">
                            <span class="text-emerald-400 font-semibold">Masuk: Rp {{ number_format($item['income'], 0, ',', '.') }}</span>
                            <span class="text-rose-400 font-semibold">Keluar: Rp {{ number_format($item['expense'], 0, ',', '.') }}</span>
                        </div>

                        <!-- Bar Columns -->
                        <div class="w-full flex items-end justify-center gap-1 h-full">
                            <!-- Bar Income -->
                            <div class="w-1/2 max-w-[18px] bg-emerald-500/80 hover:bg-emerald-400 rounded-t transition-all duration-300" 
                                 @style(['height: ' . max(4, $incPercent) . '%'])></div>
                            <!-- Bar Expense -->
                            <div class="w-1/2 max-w-[18px] bg-rose-500/80 hover:bg-rose-400 rounded-t transition-all duration-300" 
                                 @style(['height: ' . max(4, $expPercent) . '%'])></div>
                        </div>

                        <!-- Label Bulan -->
                        <span class="mt-3 text-[11px] font-medium text-slate-400 group-hover:text-white transition">
                            {{ $item['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Transaksi Terakhir (Combined Income & Expense) -->
        <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-white">Transaksi Terakhir</h3>
                    <p class="text-xs text-slate-400">Aktivitas keuangan dan mutasi kas terbaru</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('income.index') }}" class="text-xs font-medium text-emerald-400 hover:underline">Pemasukan &rarr;</a>
                    <span class="text-slate-600">|</span>
                    <a href="{{ route('expense.index') }}" class="text-xs font-medium text-rose-400 hover:underline">Pengeluaran &rarr;</a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-800/80">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-900 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Tipe</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Orang / Kontak</th>
                            <th class="px-5 py-3.5 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 bg-slate-900/20">
                        @forelse($latestTransactions as $tx)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4 text-slate-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($tx['date'])->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($tx['type'] === 'masuk')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 font-medium text-white">
                                    {{ $tx['category'] }}
                                </td>
                                <td class="px-5 py-4 text-slate-300">
                                    {{ $tx['person'] ?? '-' }}
                                </td>
                                <td class="px-5 py-4 text-right font-bold whitespace-nowrap {{ $tx['type'] === 'masuk' ? 'text-emerald-400' : 'text-rose-400' }}">
                                    {{ $tx['type'] === 'masuk' ? '+' : '-' }} Rp {{ number_format($tx['amount'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                                    Belum ada data transaksi ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>