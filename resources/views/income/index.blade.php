<x-app-layout>
    <x-slot name="title">Uang Masuk - Dapur Uti Finance</x-slot>

    <div class="space-y-6">
        <!-- Header Page & Tambah Uang Masuk -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Uang Masuk</h1>
                <p class="mt-1 text-slate-400 text-sm">Catat seluruh pemasukan dan pendapatan Dapur Uti.</p>
            </div>
            <a href="{{ route('income.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm shadow-lg shadow-emerald-600/30 transition self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Uang Masuk
            </a>
        </div>

        <!-- Filter Card -->
        <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
            <form method="GET" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Dari tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition [&::-webkit-calendar-picker-indicator]:invert [&::-webkit-calendar-picker-indicator]:brightness-200">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Sampai tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition [&::-webkit-calendar-picker-indicator]:invert [&::-webkit-calendar-picker-indicator]:brightness-200">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Kategori</label>
                    <select name="category" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition">
                        <option value="">Semua</option>
                        @foreach(\App\Models\IncomeTransaction::CATEGORIES as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Orang</label>
                    <select name="person_id" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition">
                        <option value="">Semua</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Pencarian</label>
                    <input name="search" value="{{ request('search') }}" placeholder="Keterangan" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white placeholder-slate-600 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs border border-slate-700 transition text-center">
                        Filter
                    </button>
                    <a href="{{ route('income.index') }}" class="py-2 px-3 rounded-xl bg-slate-950 hover:bg-slate-800 text-slate-400 hover:text-white font-semibold text-xs border border-slate-800 transition text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/80 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Orang</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Metode</th>
                            <th class="px-5 py-3.5">Nominal</th>
                            <th class="px-5 py-3.5">Bukti</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 bg-slate-900/20">
                        @forelse($transactions as $item)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-slate-400">
                                    {{ $item->transaction_date->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4 font-semibold text-white whitespace-nowrap">
                                    {{ $item->person->name }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-300">
                                    {{ \App\Models\IncomeTransaction::CATEGORIES[$item->category] }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-800 text-slate-300 border border-slate-700">
                                        {{ \App\Models\IncomeTransaction::PAYMENT_METHODS[$item->payment_method] }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap font-bold text-emerald-400">
                                    + Rp {{ number_format($item->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    {!! $item->proof_path 
                                        ? '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Ada</span>' 
                                        : '<span class="text-slate-500 text-xs">-</span>' !!}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('income.show', $person) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition border border-slate-700 shrink-0" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('income.edit', $person) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition border border-slate-700 shrink-0" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('income.destroy', $item) }}" onsubmit="return confirm('Hapus transaksi ini?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition border border-rose-500/20" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada transaksi uang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="border-t border-slate-800 p-4 bg-slate-950/40">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>