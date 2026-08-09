<x-app-layout>
    <x-slot name="title">Detail Inventaris - Dapur Uti Finance</x-slot>

    <div class="space-y-6 max-w-5xl">
        <!-- Header Navigasi -->
        <div class="flex items-start justify-between gap-4">
            <div>
                <a href="{{ route('inventories.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-white tracking-tight mt-2">{{ $inventory->name }}</h1>
            </div>
            <a href="{{ route('inventories.edit', $inventory) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm border border-slate-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>

        <!-- Alert Sukses -->
        @if (session('success'))
            <div class="rounded-2xl p-4 border border-emerald-500/20 bg-emerald-500/10 text-emerald-400 text-sm font-medium flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Details Panel -->
            <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60 lg:col-span-2 space-y-6">
                <!-- Highlight Valuasi Total -->
                <div class="p-5 rounded-xl bg-amber-500/10 border border-amber-500/20 flex flex-col justify-center">
                    <span class="text-xs font-semibold uppercase tracking-wider text-amber-400">Total Nilai Aset Ini</span>
                    <div class="mt-1 text-3xl font-extrabold text-amber-400 flex items-end gap-2">
                        Rp {{ number_format($inventory->purchase_price * $inventory->quantity, 0, ',', '.') }}
                        <span class="text-sm font-medium text-amber-500/70 mb-1">({{ $inventory->quantity }} unit)</span>
                    </div>
                </div>

                <!-- Grid Informasi Detail -->
                <dl class="grid gap-5 sm:grid-cols-2 pt-2 border-t border-slate-800/80">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Barang</dt>
                        <dd class="mt-1 text-sm font-semibold text-white">{{ $inventory->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal Pembelian</dt>
                        <dd class="mt-1 text-sm font-semibold text-white">{{ $inventory->purchase_date?->format('d/m/Y') ?? '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-200">{{ \App\Models\Inventory::CATEGORIES[$inventory->category] ?? $inventory->category }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kondisi</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-200">
                            @php
                                $conditionColor = match(strtolower($inventory->condition)) {
                                    'baik' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'rusak_ringan' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    'rusak_berat', 'hilang' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    default => 'bg-slate-800 text-slate-300 border-slate-700'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $conditionColor }}">
                                {{ \App\Models\Inventory::CONDITIONS[$inventory->condition] ?? $inventory->condition }}
                            </span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Penanggung Jawab</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-200">{{ $inventory->person->name ?? '-' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Harga Satuan</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-200">Rp {{ number_format($inventory->purchase_price, 0, ',', '.') }}</dd>
                    </div>

                    <div class="sm:col-span-2 pt-2 border-t border-slate-800/60">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Spesifikasi / Keterangan</dt>
                        <dd class="mt-1 text-sm text-slate-300 whitespace-pre-line leading-relaxed">{{ $inventory->description ?: 'Tidak ada keterangan spesifikasi tambahan.' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Photo Panel -->
            <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60 flex flex-col justify-start">
                <div>
                    <h2 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Foto Barang
                    </h2>

                    @if($inventory->photo_path)
                        <a href="{{ Storage::url($inventory->photo_path) }}" target="_blank" class="block group relative rounded-xl overflow-hidden border border-slate-800 bg-slate-950/80 hover:border-slate-700 transition">
                            <img src="{{ Storage::url($inventory->photo_path) }}" class="w-full max-h-72 object-contain rounded-xl p-2 transition duration-300 group-hover:scale-105" alt="Foto Inventaris">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                                <span class="text-xs font-semibold text-white bg-slate-900/90 px-3 py-1.5 rounded-lg border border-slate-700">Lihat Resolusi Penuh</span>
                            </div>
                        </a>
                    @else
                        <div class="p-8 text-center rounded-xl bg-slate-950/60 border border-slate-800 text-xs text-slate-500">
                            Tidak ada foto barang yang diunggah.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>