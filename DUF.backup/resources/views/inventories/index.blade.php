<x-app-layout>
    <x-slot name="title">Inventaris - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div><h1 class="page-title">Inventaris</h1><p class="page-subtitle">Data peralatan dan aset usaha Dapur Uti.</p></div>
        <a href="{{ route('inventories.create') }}" class="btn-primary">+ Tambah Inventaris</a>
    </div>
    <div class="mb-5 rounded-2xl bg-amber-100 p-5 text-amber-950">
        <div class="text-sm">Total nilai inventaris sesuai filter</div>
        <div class="mt-1 text-2xl font-semibold">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
    </div>
    <div class="panel mb-5 panel-body">
        <form method="GET" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            <div><label class="form-label">Pencarian</label><input name="search" value="{{ request('search') }}" class="form-control mt-1" placeholder="Nama barang"></div>
            <div><label class="form-label">Kategori</label><select name="category" class="form-control mt-1"><option value="">Semua</option>@foreach(\App\Models\Inventory::CATEGORIES as $value => $label)<option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Kondisi</label><select name="condition" class="form-control mt-1"><option value="">Semua</option>@foreach(\App\Models\Inventory::CONDITIONS as $value => $label)<option value="{{ $value }}" @selected(request('condition') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Penanggung jawab</label><select name="person_id" class="form-control mt-1"><option value="">Semua</option>@foreach($people as $person)<option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>@endforeach</select></div>
            <div class="flex items-end gap-2"><button class="btn-primary">Filter</button><a href="{{ route('inventories.index') }}" class="btn-secondary">Reset</a></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Barang</th><th>Kategori</th><th>Tgl. beli</th><th>Jumlah</th><th>Harga</th><th>Nilai</th><th>Kondisi</th><th>Penanggung jawab</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse($inventories as $item)
                    <tr>
                        <td class="font-medium text-stone-900">{{ $item->name }}</td>
                        <td>{{ \App\Models\Inventory::CATEGORIES[$item->category] }}</td>
                        <td class="whitespace-nowrap">{{ $item->purchase_date->format('d/m/Y') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="whitespace-nowrap">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap font-semibold">Rp {{ number_format($item->total_value, 0, ',', '.') }}</td>
                        <td><span class="{{ $item->condition === 'baik' ? 'badge-green' : ($item->condition === 'hilang' || $item->condition === 'rusak_berat' ? 'badge-red' : 'badge-brown') }}">{{ \App\Models\Inventory::CONDITIONS[$item->condition] }}</span></td>
                        <td>{{ $item->person->name }}</td>
                        <td><div class="flex justify-end gap-2"><a href="{{ route('inventories.show', $item) }}" class="btn-secondary !px-3 !py-2">Detail</a><a href="{{ route('inventories.edit', $item) }}" class="btn-secondary !px-3 !py-2">Edit</a><form method="POST" action="{{ route('inventories.destroy', $item) }}" onsubmit="return confirm('Hapus inventaris ini?')">@csrf @method('DELETE')<button class="btn-danger">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="py-10 text-center text-stone-500">Belum ada data inventaris.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($inventories->hasPages())<div class="border-t border-stone-200 p-4">{{ $inventories->links() }}</div>@endif
    </div>
</x-app-layout>
