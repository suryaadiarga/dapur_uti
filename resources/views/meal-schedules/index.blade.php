<x-app-layout>
    <x-slot name="title">Jadwal Makanan & Order - Dapur Uti Finance</x-slot>
    
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Jadwal Makanan & Order</h1>
                <p class="mt-1 text-slate-400 text-sm">Perencanaan menu, shift, dan jumlah porsi.</p>
            </div>
            <a href="{{ route('meal-schedules.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/35 transition">
                + Tambah Jadwal Makanan
            </a>
        </div>

        <!-- Filter -->
        <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
            <form method="GET" class="grid gap-4 sm:grid-cols-3 lg:grid-cols-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Cari Menu</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama menu..." class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-indigo-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Bulan</label>
                    <select name="month" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-indigo-500 focus:outline-none transition">
                        <option value="">Semua Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" @selected(request('month', date('n')) == $m)>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Shift</label>
                    <select name="shift" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-indigo-500 focus:outline-none transition">
                        <option value="">Semua Shift</option>
                        @foreach(\App\Models\MealSchedule::SHIFTS as $sNum => $sLbl)
                            <option value="{{ $sNum }}" @selected(request('shift') == $sNum)>{{ $sLbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2 lg:col-span-2">
                    <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs border border-slate-700 transition text-center">Filter</button>
                    <a href="{{ route('meal-schedules.index') }}" class="py-2 px-3 rounded-xl bg-slate-950 hover:bg-slate-800 text-slate-400 text-xs border border-slate-800 transition text-center">Reset</a>
                </div>
            </form>
        </div>

        <!-- Tabel Jadwal -->
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/80 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Shift</th>
                            <th class="px-5 py-3.5">Daftar Menu</th>
                            <th class="px-5 py-3.5">Jml Porsi</th>
                            <th class="px-5 py-3.5 text-right">Est. Biaya (Ops)</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($schedules as $sched)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4 font-mono text-xs text-white whitespace-nowrap">{{ $sched->schedule_date->format('d/m/Y') }}</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-500/10 text-indigo-400 text-xs font-medium border border-indigo-500/20 whitespace-nowrap">
                                        Shift {{ $sched->shift }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-white font-medium">{{ ucwords($sched->menu_items) }}</td>
                                <td class="px-5 py-4 font-bold text-emerald-400 whitespace-nowrap">{{ number_format($sched->portion_count) }} Porsi</td>
                                <td class="px-5 py-4 font-mono text-xs text-slate-300 text-right whitespace-nowrap">Rp {{ number_format($sched->estimated_cost ?? 0, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('meal-schedules.edit', $sched) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition border border-slate-700 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('meal-schedules.destroy', $sched) }}" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition border border-rose-500/20" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Belum ada jadwal makanan bulan ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($schedules->hasPages())
                <div class="p-4 border-t border-slate-800 bg-slate-950/40">{{ $schedules->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>