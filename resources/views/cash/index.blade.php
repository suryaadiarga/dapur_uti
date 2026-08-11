<x-app-layout>
    <x-slot name="title">Buku Kas - Dapur Uti Finance</x-slot>

    <div class="space-y-6">
        <!-- Header Page -->
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Buku Kas</h1>
            <p class="mt-1 text-slate-400 text-sm">Mutasi kas gabungan dari seluruh uang masuk dan keluar.</p>
        </div>

        <!-- Summary Cards Grid -->
        <div class="grid gap-5 sm:grid-cols-3">
            <!-- Total Uang Masuk -->
            <div class="glass-card rounded-2xl p-6 border border-emerald-500/20 bg-emerald-500/5 flex flex-col justify-center transition hover:bg-emerald-500/10">
                <div class="text-xs font-semibold uppercase tracking-wider text-emerald-400/80">Total Uang Masuk</div>
                <div class="mt-2 text-2xl lg:text-3xl font-extrabold text-emerald-400 truncate">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </div>
            </div>

            <!-- Total Uang Keluar -->
            <div class="glass-card rounded-2xl p-6 border border-rose-500/20 bg-rose-500/5 flex flex-col justify-center transition hover:bg-rose-500/10">
                <div class="text-xs font-semibold uppercase tracking-wider text-rose-400/80">Total Uang Keluar</div>
                <div class="mt-2 text-2xl lg:text-3xl font-extrabold text-rose-400 truncate">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </div>
            </div>

            <!-- Saldo Akhir -->
            <div class="glass-card rounded-2xl p-6 border border-blue-500/20 bg-blue-500/5 flex flex-col justify-center transition hover:bg-blue-500/10">
                <div class="text-xs font-semibold uppercase tracking-wider text-blue-400/80">Saldo Akhir</div>
                <div class="mt-2 text-2xl lg:text-3xl font-extrabold truncate {{ $balance < 0 ? 'text-rose-500' : 'text-blue-400' }}">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 overflow-hidden">
            <!-- Table Header Section -->
            <div class="p-5 border-b border-slate-800/80 bg-slate-950/40">
                <h2 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Mutasi Kas
                </h2>
                <p class="mt-1 text-xs text-slate-400">Urutan transaksi terbaru. Saldo berjalan dihitung secara kronologis.</p>
            </div>
            
            <div class="overflow-x-auto p-4">
                <!-- Tabel Menggunakan Kelas .data-table Sesuai Tema Utama -->
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Orang</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Kredit</th>
                            <th class="text-right">Saldo Berjalan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutations as $item)
                            <tr>
                                <!-- Tanggal -->
                                <td class="whitespace-nowrap">
                                    {{ $item['date']->format('d/m/Y') }}
                                </td>
                                
                                <!-- Jenis -->
                                <td class="whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $item['type'] === 'masuk' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20' }}">
                                        {{ ucfirst($item['type']) }}
                                    </span>
                                </td>

                                <!-- Kategori -->
                                <td class="font-medium whitespace-nowrap">
                                    {{ $item['category'] }}
                                </td>

                                <!-- Keterangan -->
                                <td class="min-w-[200px]">
                                    {{ $item['description'] ?: '-' }}
                                </td>

                                <!-- Orang -->
                                <td class="font-semibold whitespace-nowrap">
                                    {{ $item['person'] }}
                                </td>

                                <!-- Debit (Uang Masuk) -->
                                <td class="whitespace-nowrap text-right font-medium text-emerald-400">
                                    {{ $item['debit'] ? 'Rp ' . number_format($item['debit'], 0, ',', '.') : '-' }}
                                </td>

                                <!-- Kredit (Uang Keluar) -->
                                <td class="whitespace-nowrap text-right font-medium text-rose-400">
                                    {{ $item['credit'] ? 'Rp ' . number_format($item['credit'], 0, ',', '.') : '-' }}
                                </td>

                                <!-- Saldo Berjalan -->
                                <td class="whitespace-nowrap text-right font-bold {{ $item['balance'] < 0 ? 'text-rose-500' : 'text-blue-400' }}">
                                    Rp {{ number_format($item['balance'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <!-- State Kosong -->
                            <tr>
                                <td colspan="8" class="text-center py-10 text-slate-500">
                                    Belum ada mutasi kas tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>