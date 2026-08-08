<x-app-layout>
    <x-slot name="title">Detail Inventaris - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex items-start justify-between gap-4"><div><a href="{{ route('inventories.index') }}" class="text-sm font-medium text-emerald-700">← Kembali</a><h1 class="page-title mt-3">{{ $inventory->name }}</h1></div><a href="{{ route('inventories.edit', $inventory) }}" class="btn-secondary">Edit</a></div>
    <div class="grid max-w-5xl gap-5 lg:grid-cols-3">
        <div class="panel panel-body lg:col-span-2">
            <div class="mb-6 rounded-xl bg-amber-50 p-4"><div class="text-xs text-amber-700">Total nilai</div><div class="mt-1 text-3xl font-semibold text-amber-800">Rp {{ number_format($inventory->total_value, 0, ',', '.') }}</div></div>
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs uppercase text-stone-500">Kategori</dt><dd class="mt-1 font-medium">{{ \App\Models\Inventory::CATEGORIES[$inventory->category] }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Tanggal pembelian</dt><dd class="mt-1">{{ $inventory->purchase_date->format('d/m/Y') }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Harga satuan</dt><dd class="mt-1">Rp {{ number_format($inventory->purchase_price, 0, ',', '.') }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Jumlah</dt><dd class="mt-1">{{ $inventory->quantity }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Kondisi</dt><dd class="mt-1">{{ \App\Models\Inventory::CONDITIONS[$inventory->condition] }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Lokasi</dt><dd class="mt-1">{{ $inventory->location ?: '-' }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Penanggung jawab</dt><dd class="mt-1">{{ $inventory->person->name }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs uppercase text-stone-500">Keterangan</dt><dd class="mt-1 whitespace-pre-line">{{ $inventory->description ?: '-' }}</dd></div>
            </dl>
        </div>
        <div class="panel panel-body">
            <h2 class="font-semibold">Foto barang</h2>
            @if($inventory->photo_path)
                <a href="{{ Storage::url($inventory->photo_path) }}" target="_blank"><img src="{{ Storage::url($inventory->photo_path) }}" class="mt-4 w-full rounded-xl border object-contain" alt="{{ $inventory->name }}"></a>
            @else
                <div class="mt-4 rounded-xl bg-stone-50 p-6 text-center text-sm text-stone-500">Tidak ada foto barang.</div>
            @endif
        </div>
    </div>
</x-app-layout>
