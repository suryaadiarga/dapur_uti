<x-app-layout>
    <x-slot name="title">Uang Keluar - Dapur Uti Finance</x-slot>

    <div class="space-y-6">
        <!-- Header Page & Tambah Uang Keluar -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Uang Keluar</h1>
                <p class="mt-1 text-slate-600 dark:text-slate-400 text-sm">Catat seluruh pengeluaran Dapur Uti secara terorganisir.</p>
            </div>
            <a href="{{ route('expense.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-semibold text-sm shadow-lg shadow-rose-600/30 transition self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Uang Keluar
            </a>
        </div>

        <!-- Filter Card -->
        <div class="rounded-2xl p-5 border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 shadow-sm">
            <form method="GET" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6">
                @php 
                    $inputClass = "w-full rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 px-3 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition [&::-webkit-calendar-picker-indicator]:dark:invert [&::-webkit-calendar-picker-indicator]:dark:brightness-200";
                    $labelClass = "block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1";
                @endphp

                <div>
                    <label class="{{ $labelClass }}">Dari tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label class="{{ $labelClass }}">Sampai tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="{{ $inputClass }}">
                </div>
                <div>
                    <label class="{{ $labelClass }}">Kategori</label>
                    <select name="category" class="{{ $inputClass }}">
                        <option value="">Semua</option>
                        @foreach(\App\Models\ExpenseTransaction::CATEGORIES as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="{{ $labelClass }}">Orang</label>
                    <select name="person_id" class="{{ $inputClass }}">
                        <option value="">Semua</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="{{ $labelClass }}">Toko</label>
                    <input name="store_name" value="{{ request('store_name') }}" placeholder="Nama toko" class="{{ $inputClass }}">
                </div>
                <div>
                    <label class="{{ $labelClass }}">Pencarian</label>
                    <input name="search" value="{{ request('search') }}" placeholder="Keterangan" class="{{ $inputClass }}">
                </div>
                <div class="flex items-end gap-2 xl:col-span-6">
                    <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 dark:hover:bg-slate-600 text-white font-semibold text-xs border border-slate-700 transition text-center">
                        Filter
                    </button>
                    <a href="{{ route('expense.index') }}" class="py-2 px-3 rounded-xl bg-slate-100 dark:bg-slate-950 hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-semibold text-xs border border-slate-200 dark:border-slate-800 transition text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-950/80 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Orang</th>
                            <th class="px-5 py-3.5">Toko</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Metode</th>
                            <th class="px-5 py-3.5">Nominal</th>
                            <th class="px-5 py-3.5">Nota</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 bg-white dark:bg-slate-900/20">
                        @forelse($transactions as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-slate-500 dark:text-slate-400 text-xs">
                                    {{ $item->transaction_date->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4 font-semibold text-slate-900 dark:text-white whitespace-nowrap text-xs">
                                    {{ $item->person->name }}
                                </td>
                                <td class="px-5 py-4 text-slate-600 dark:text-slate-300 text-xs">
                                    {{ $item->store_name ?: '-' }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-600 dark:text-slate-300 text-xs">
                                    {{ \App\Models\ExpenseTransaction::CATEGORIES[$item->category] }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                        {{ \App\Models\ExpenseTransaction::PAYMENT_METHODS[$item->payment_method] }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap font-bold text-rose-600 dark:text-rose-400 text-xs">
                                    - Rp {{ number_format($item->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    {!! $item->receipt_path 
                                        ? '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>Ada</span>' 
                                        : '<span class="text-slate-400 dark:text-slate-500 text-xs">-</span>' !!}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('expense.show', $item) }}" class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition border border-slate-200 dark:border-slate-700 shrink-0" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('expense.edit', $item) }}" class="p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition border border-slate-200 dark:border-slate-700 shrink-0" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('expense.destroy', $item) }}" onsubmit="return confirm('Hapus transaksi ini?')" class="inline">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 transition border border-rose-500/20" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada transaksi uang keluar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="border-t border-slate-200 dark:border-slate-800 p-4 bg-slate-50 dark:bg-slate-950/40">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>