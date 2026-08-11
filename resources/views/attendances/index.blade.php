<x-app-layout>
    <x-slot name="title">Absensi Person - Dapur Uti Finance</x-slot>
    
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Absensi Person</h1>
                <p class="mt-1 text-slate-400 text-sm">Kelola catatan kehadiran staff, kurir, dan keluarga.</p>
            </div>
            <a href="{{ route('attendances.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/35 transition">
                + Catat Absensi
            </a>
        </div>

        <!-- Filter -->
        <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
            <form method="GET" class="grid gap-4 sm:grid-cols-3 lg:grid-cols-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-indigo-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Person</label>
                    <select name="person_id" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-indigo-500 focus:outline-none transition">
                        <option value="">Semua Person</option>
                        @foreach($people as $p)
                            <option value="{{ $p->id }}" @selected(request('person_id') == $p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Status</label>
                    <select name="status" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-indigo-500 focus:outline-none transition">
                        <option value="">Semua Status</option>
                        @foreach(\App\Models\Attendance::STATUSES as $val => $lbl)
                            <option value="{{ $val }}" @selected(request('status') === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs border border-slate-700 transition text-center">Filter</button>
                    <a href="{{ route('attendances.index') }}" class="py-2 px-3 rounded-xl bg-slate-950 hover:bg-slate-800 text-slate-400 text-xs border border-slate-800 transition text-center">Reset</a>
                </div>
            </form>
        </div>

        <!-- Tabel -->
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/80 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-5 py-3.5">Tanggal</th>
                            <th class="px-5 py-3.5">Nama Person</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Catatan</th>
                            <th class="px-5 py-3.5">Pencatat</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($attendances as $item)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4 font-mono text-xs text-white">{{ $item->attendance_date->format('d/m/Y') }}</td>
                                <td class="px-5 py-4 font-semibold text-white">{{ $item->person->name ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    @php
                                        $badgeColor = match($item->status) {
                                            'hadir' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'izin' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'sakit' => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                            default => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium border {{ $badgeColor }}">
                                        {{ \App\Models\Attendance::STATUSES[$item->status] ?? $item->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-400 truncate max-w-xs">{{ $item->notes ?: '-' }}</td>
                                <td class="px-5 py-4 text-xs text-slate-400">{{ $item->creator->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('attendances.edit', $item) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition border border-slate-700 shrink-0" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('attendances.destroy', $item) }}" onsubmit="return confirm('Hapus data absensi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition border border-rose-500/20" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Belum ada data absensi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendances->hasPages())
                <div class="p-4 border-t border-slate-800 bg-slate-950/40">{{ $attendances->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>