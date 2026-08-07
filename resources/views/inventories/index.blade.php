<x-app-layout>
    <x-slot name="title">Inventaris - Dapur Uti Finance</x-slot>

    <div class="space-y-6">
        <!-- Header Page & Tambah Inventaris -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Inventaris</h1>
                <p class="mt-1 text-slate-400 text-sm">Daftar aset dan perlengkapan Dapur Uti.</p>
            </div>
            <a href="{{ route('inventories.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-semibold text-sm shadow-lg shadow-amber-600/30 transition self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Inventaris
            </a>
        </div>

        <!-- Total Valuasi Aset -->
        <div class="glass-card rounded-2xl p-6 border border-amber-500/20 bg-amber-500/5 flex items-center justify-between">
            <div>
                <div class="text-xs font-semibold uppercase tracking-wider text-amber-400/80">Total Nilai Aset / Inventaris</div>
                <div class="mt-1 text-3xl font-extrabold text-amber-400 truncate">
                    Rp {{ number_format($totalValue, 0, ',', '.') }}
                </div>
            </div>
            <div class="hidden sm:block p-3 rounded-full bg-amber-500/10 text-amber-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
            <form method="GET" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Kategori</label>
                    <select name="category" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition">
                        <option value="">Semua</option>
                        @foreach(\App\Models\Inventory::CATEGORIES ?? [] as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Kondisi</label>
                    <select name="condition" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition">
                        <option value="">Semua</option>
                        @foreach(\App\Models\Inventory::CONDITIONS ?? [] as $value => $label)
                            <option value="{{ $value }}" @selected(request('condition') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Penanggung Jawab</label>
                    <select name="person_id" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition">
                        <option value="">Semua</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Pencarian</label>
                    <input name="search" value="{{ request('search') }}" placeholder="Nama Barang..." class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white placeholder-slate-600 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs border border-slate-700 transition text-center">
                        Filter
                    </button>
                    <a href="{{ route('inventories.index') }}" class="py-2 px-3 rounded-xl bg-slate-950 hover:bg-slate-800 text-slate-400 hover:text-white font-semibold text-xs border border-slate-800 transition text-center">
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
                            <th class="px-5 py-3.5">Nama Barang</th>
                            <th class="px-5 py-3.5">Tgl Beli</th>
                            <th class="px-5 py-3.5">Kondisi</th>
                            <th class="px-5 py-3.5">PIC</th>
                            <th class="px-5 py-3.5 text-center">Qty</th>
                            <th class="px-5 py-3.5 text-right">Nilai Satuan</th>
                            <th class="px-5 py-3.5 text-right">Total Nilai</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 bg-slate-900/20">
                        @forelse($inventories as $item)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-5 py-4 font-semibold text-white whitespace-nowrap flex items-center gap-3">
                                    @if($item->photo_path)
                                        <div class="w-8 h-8 rounded-md bg-slate-800 border border-slate-700 overflow-hidden flex-shrink-0">
                                            <img src="{{ Storage::url($item->photo_path) }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-md bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-500 flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    {{ $item->name }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-slate-400">
                                    {{ $item->purchase_date?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @php
                                        // Contoh Pewarnaan Kondisi
                                        $conditionColor = match(strtolower($item->condition)) {
                                            'baik' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'rusak' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            'perbaikan' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            default => 'bg-slate-800 text-slate-300 border-slate-700'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $conditionColor }}">
                                        {{ \App\Models\Inventory::CONDITIONS[$item->condition] ?? $item->condition }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-300 whitespace-nowrap">
                                    {{ $item->person->name ?? '-' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-center font-medium">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-right text-slate-400">
                                    Rp {{ number_format($item->purchase_price, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-right font-bold text-amber-400">
                                    Rp {{ number_format($item->purchase_price * $item->quantity, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('inventories.show', $item) }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium border border-slate-700 transition">
                                            Detail
                                        </a>
                                        <a href="{{ route('inventories.edit', $item) }}" class="px-3 py-1.5 rounded-lg bg-blue-950/60 hover:bg-blue-900/80 text-blue-400 text-xs font-medium border border-blue-800/60 transition">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('inventories.destroy', $item) }}" onsubmit="return confirm('Hapus aset ini?')" class="inline">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-950/60 hover:bg-rose-900/80 text-rose-400 text-xs font-medium border border-rose-800/60 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-500">
                                    Belum ada data inventaris.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($inventories->hasPages())
                <div class="border-t border-slate-800 p-4 bg-slate-950/40">
                    {{ $inventories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>