<x-app-layout>
    <x-slot name="title">Daftar Invoice - Dapur Uti Finance</x-slot>

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Invoice & Tagihan</h1>
                <p class="mt-1 text-slate-400 text-sm">Rekapitulasi tagihan katering berdasarkan jadwal makanan otomatis.</p>
            </div>
            <a href="{{ route('invoices.create') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
                <span>✨ Generate Invoice Baru</span>
            </a>
        </div>

        <!-- Tabel Data Invoice -->
        <div class="glass-card rounded-2xl border border-slate-800 overflow-hidden bg-slate-900/60">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-950/80 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-5 py-4">No. Invoice</th>
                            <th class="px-5 py-4">Periode</th>
                            <th class="px-5 py-4 text-center">Total Porsi</th>
                            <th class="px-5 py-4 text-right">Total Tagihan</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4">Dibuat Oleh</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($invoices as $inv)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4 font-mono font-bold text-indigo-400">{{ $inv->invoice_number }}</td>
                                <td class="px-5 py-4 text-slate-300">{{ $inv->start_date->format('d/m/Y') }} - {{ $inv->end_date->format('d/m/Y') }}</td>
                                <td class="px-5 py-4 text-center font-bold text-emerald-400">{{ number_format($inv->total_portions) }}</td>
                                <td class="px-5 py-4 text-right font-mono font-semibold text-white">Rp {{ number_format($inv->total_amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full font-bold text-[10px] {{ $inv->status == 'paid' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30' }}">
                                        {{ strtoupper($inv->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-400">{{ $inv->creator->name ?? 'System' }}</td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('invoices.show', $inv->id) }}" class="p-1.5 rounded-lg bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 transition" title="Lihat / Cetak">
                                            👁️
                                        </a>
                                        <form action="{{ route('invoices.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 transition" title="Hapus">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-500">Belum ada data invoice yang digenerate.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($invoices->hasPages())
                <div class="p-4 border-t border-slate-800">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>