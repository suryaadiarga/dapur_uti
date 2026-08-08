<x-app-layout>
    <x-slot name="title">Buku Kas - Dapur Uti Finance</x-slot>
    <div class="mb-6"><h1 class="page-title">Buku Kas</h1><p class="page-subtitle">Mutasi kas gabungan dari seluruh uang masuk dan keluar.</p></div>
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="panel panel-body"><div class="text-sm text-stone-500">Total uang masuk</div><div class="mt-2 text-2xl font-semibold text-emerald-700">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div></div>
        <div class="panel panel-body"><div class="text-sm text-stone-500">Total uang keluar</div><div class="mt-2 text-2xl font-semibold text-red-700">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div></div>
        <div class="panel panel-body"><div class="text-sm text-stone-500">Saldo akhir</div><div class="mt-2 text-2xl font-semibold {{ $balance < 0 ? 'text-red-700' : 'text-emerald-900' }}">Rp {{ number_format($balance, 0, ',', '.') }}</div></div>
    </div>
    <div class="panel">
        <div class="border-b border-stone-200 p-5"><h2 class="font-semibold">Mutasi Kas</h2><p class="mt-1 text-xs text-stone-500">Urutan transaksi terbaru. Saldo berjalan dihitung secara kronologis.</p></div>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Tanggal</th><th>Jenis</th><th>Kategori</th><th>Keterangan</th><th>Orang</th><th>Debit</th><th>Kredit</th><th>Saldo berjalan</th></tr></thead>
                <tbody>
                @forelse($mutations as $item)
                    <tr>
                        <td class="whitespace-nowrap">{{ $item['date']->format('d/m/Y') }}</td>
                        <td><span class="{{ $item['type'] === 'masuk' ? 'badge-green' : 'badge-red' }}">{{ ucfirst($item['type']) }}</span></td>
                        <td>{{ $item['category'] }}</td>
                        <td class="max-w-xs">{{ $item['description'] }}</td>
                        <td>{{ $item['person'] }}</td>
                        <td class="whitespace-nowrap text-emerald-700">{{ $item['debit'] ? 'Rp '.number_format($item['debit'], 0, ',', '.') : '-' }}</td>
                        <td class="whitespace-nowrap text-red-700">{{ $item['credit'] ? 'Rp '.number_format($item['credit'], 0, ',', '.') : '-' }}</td>
                        <td class="whitespace-nowrap font-semibold">Rp {{ number_format($item['balance'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="py-10 text-center text-stone-500">Belum ada mutasi kas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
