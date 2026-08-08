<x-app-layout>
    <x-slot name="title">Dashboard - Dapur Uti Finance</x-slot>
    <div class="mb-6">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Ringkasan kondisi keuangan Dapur Uti.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="panel panel-body">
            <div class="text-sm text-stone-500">Uang masuk bulan ini</div>
            <div class="mt-2 text-2xl font-semibold text-emerald-800">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</div>
            <div class="mt-2 text-xs text-stone-500">{{ $incomeCount }} transaksi</div>
        </div>
        <div class="panel panel-body">
            <div class="text-sm text-stone-500">Uang keluar bulan ini</div>
            <div class="mt-2 text-2xl font-semibold text-red-700">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</div>
            <div class="mt-2 text-xs text-stone-500">{{ $expenseCount }} transaksi</div>
        </div>
        <div class="panel panel-body">
            <div class="text-sm text-stone-500">Saldo kas saat ini</div>
            <div class="mt-2 text-2xl font-semibold {{ $cashBalance < 0 ? 'text-red-700' : 'text-emerald-900' }}">Rp {{ number_format($cashBalance, 0, ',', '.') }}</div>
            <a href="{{ route('cash.index') }}" class="mt-2 inline-block text-xs font-medium text-emerald-700">Lihat buku kas →</a>
        </div>
        <div class="panel panel-body sm:col-span-2 xl:col-span-1">
            <div class="text-sm text-stone-500">Total nilai inventaris</div>
            <div class="mt-2 text-2xl font-semibold text-amber-800">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</div>
            <a href="{{ route('inventories.index') }}" class="mt-2 inline-block text-xs font-medium text-emerald-700">Lihat inventaris →</a>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-5">
        <section class="panel panel-body xl:col-span-3">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-stone-900">Arus kas 6 bulan</h2>
                    <p class="mt-1 text-xs text-stone-500">Perbandingan uang masuk dan keluar.</p>
                </div>
                <div class="flex gap-3 text-xs">
                    <span class="flex items-center gap-1"><i class="h-2.5 w-2.5 rounded-full bg-emerald-700"></i>Masuk</span>
                    <span class="flex items-center gap-1"><i class="h-2.5 w-2.5 rounded-full bg-amber-500"></i>Keluar</span>
                </div>
            </div>
            <div class="mt-7 grid h-64 grid-cols-6 gap-3 border-b border-stone-200">
                @foreach($chart as $item)
                    <div class="flex min-w-0 flex-col justify-end">
                        <div class="flex h-52 items-end justify-center gap-1">
                            <div class="w-4 rounded-t bg-emerald-700 sm:w-6" style="height: {{ max(2, ($item['income'] / $chartMax) * 100) }}%" title="Masuk Rp {{ number_format($item['income'], 0, ',', '.') }}"></div>
                            <div class="w-4 rounded-t bg-amber-500 sm:w-6" style="height: {{ max(2, ($item['expense'] / $chartMax) * 100) }}%" title="Keluar Rp {{ number_format($item['expense'], 0, ',', '.') }}"></div>
                        </div>
                        <div class="truncate py-2 text-center text-[10px] text-stone-500 sm:text-xs">{{ $item['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="panel xl:col-span-2">
            <div class="border-b border-stone-200 p-5">
                <h2 class="font-semibold text-stone-900">5 transaksi terbaru</h2>
            </div>
            <div class="divide-y divide-stone-100">
                @forelse($latestTransactions as $item)
                    <a href="{{ $item['type'] === 'masuk' ? route('income.show', $item['id']) : route('expense.show', $item['id']) }}" class="flex items-center gap-3 p-4 hover:bg-stone-50">
                        <div class="grid h-9 w-9 shrink-0 place-items-center rounded-full {{ $item['type'] === 'masuk' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $item['type'] === 'masuk' ? '↓' : '↑' }}</div>
                        <div class="min-w-0 flex-1">
                            <div class="truncate text-sm font-medium">{{ $item['category'] }}</div>
                            <div class="truncate text-xs text-stone-500">{{ $item['date']->format('d/m/Y') }} · {{ $item['person'] }}</div>
                        </div>
                        <div class="whitespace-nowrap text-sm font-semibold {{ $item['type'] === 'masuk' ? 'text-emerald-700' : 'text-red-700' }}">
                            {{ $item['type'] === 'masuk' ? '+' : '-' }} Rp {{ number_format($item['amount'], 0, ',', '.') }}
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-stone-500">Belum ada transaksi.</div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
