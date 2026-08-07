<x-app-layout>
    <x-slot name="title">Invoice {{ $invoice->invoice_number }} - Dapur Uti Finance</x-slot>

    <div class="space-y-6 max-w-4xl mx-auto">
        <!-- Tombol Aksi (Hidden saat diprint) -->
        <div class="flex items-center justify-between print:hidden">
            <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1">← Kembali ke Daftar Invoice</a>
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition shadow-md">
                🖨️ Cetak / Simpan PDF
            </button>
        </div>

        <!-- Lembar Invoice -->
        <div class="glass-card rounded-2xl p-8 border border-slate-800 bg-slate-900 text-slate-300 space-y-8">
            <!-- Header Invoice -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-800 pb-6">
                <div>
                    <h2 class="text-2xl font-black text-white tracking-tight">DAPUR UTI FINANCE</h2>
                    <p class="text-xs text-slate-400 mt-1">Laporan Rekapitulasi & Tagihan Jadwal Makanan</p>
                </div>
                <div class="text-left sm:text-right">
                    <div class="text-lg font-bold text-indigo-400 font-mono">{{ $invoice->invoice_number }}</div>
                    <div class="text-xs text-slate-400 mt-1">Tanggal Buat: {{ $invoice->created_at->format('d/m/Y') }}</div>
                </div>
            </div>

            <!-- Informasi Periode -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs bg-slate-950/60 p-4 rounded-xl border border-slate-800">
                <div>
                    <span class="text-slate-500 block mb-0.5">PERIODE MULAI</span>
                    <strong class="text-white text-sm">{{ $invoice->start_date->format('d M Y') }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block mb-0.5">PERIODE SELESAI</span>
                    <strong class="text-white text-sm">{{ $invoice->end_date->format('d M Y') }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block mb-0.5">TOTAL PORSI</span>
                    <strong class="text-emerald-400 text-sm">{{ number_format($invoice->total_portions) }} Porsi</strong>
                </div>
                <div>
                    <span class="text-slate-500 block mb-0.5">STATUS</span>
                    <span class="px-2 py-0.5 rounded font-bold text-[10px] {{ $invoice->status == 'paid' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-amber-500/20 text-amber-400' }}">
                        {{ strtoupper($invoice->status) }}
                    </span>
                </div>
            </div>

            <!-- Tabel Rincian Item dari Meal Schedules -->
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-3">Rincian Menu & Jadwal</h3>
                <div class="overflow-x-auto rounded-xl border border-slate-800">
                    <table class="w-full text-left text-xs text-slate-300">
                        <thead class="bg-slate-950 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Shift</th>
                                <th class="px-4 py-3">Menu Makanan</th>
                                <th class="px-4 py-3 text-center">Porsi</th>
                                <th class="px-4 py-3 text-right">Biaya (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($schedules as $sched)
                                <tr>
                                    <td class="px-4 py-3 font-mono text-white">{{ $sched->schedule_date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">Shift {{ $sched->shift }}</td>
                                    <td class="px-4 py-3 text-white font-medium">{{ $sched->menu_items }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-emerald-400">{{ number_format($sched->portion_count) }}</td>
                                    <td class="px-4 py-3 text-right font-mono">{{ number_format($sched->estimated_cost ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-950 font-bold border-t border-slate-800 text-white">
                            <tr>
                                <td colspan="3" class="px-4 py-3.5 text-right">TOTAL KESELURUHAN:</td>
                                <td class="px-4 py-3.5 text-center text-emerald-400">{{ number_format($invoice->total_portions) }}</td>
                                <td class="px-4 py-3.5 text-right font-mono text-indigo-400 text-sm">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($invoice->notes)
                <div class="text-xs bg-slate-950/40 p-4 rounded-xl border border-slate-800">
                    <span class="text-slate-500 font-semibold block mb-1">CATATAN:</span>
                    <p class="text-slate-300">{{ $invoice->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>