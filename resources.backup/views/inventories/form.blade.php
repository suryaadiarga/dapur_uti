<x-app-layout>
    <x-slot name="title">{{ $inventory->exists ? 'Edit' : 'Tambah' }} Inventaris - Dapur Uti Finance</x-slot>
    <div class="mb-6"><a href="{{ route('inventories.index') }}" class="text-sm font-medium text-blue-700">← Kembali</a><h1 class="page-title mt-3">{{ $inventory->exists ? 'Edit Inventaris' : 'Tambah Inventaris' }}</h1></div>
    <form method="POST" enctype="multipart/form-data" action="{{ $inventory->exists ? route('inventories.update', $inventory) : route('inventories.store') }}" class="panel panel-body max-w-4xl">
        @csrf @if($inventory->exists) @method('PUT') @endif
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2"><label class="form-label">Nama barang <span class="text-red-500">*</span></label><input name="name" value="{{ old('name', $inventory->name) }}" class="form-control mt-1" required></div>
            <div><label class="form-label">Kategori <span class="text-red-500">*</span></label><select name="category" class="form-control mt-1" required><option value="">Pilih kategori</option>@foreach(\App\Models\Inventory::CATEGORIES as $value => $label)<option value="{{ $value }}" @selected(old('category', $inventory->category) === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Tanggal pembelian <span class="text-red-500">*</span></label><input type="date" name="purchase_date" value="{{ old('purchase_date', $inventory->purchase_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="form-control mt-1" required></div>
            <div><label class="form-label">Harga pembelian/satuan <span class="text-red-500">*</span></label><div class="relative mt-1"><span class="absolute left-3 top-2.5 text-sm text-stone-500">Rp</span><input type="number" min="0" step="1" name="purchase_price" value="{{ old('purchase_price', $inventory->purchase_price) }}" class="form-control pl-10" required></div></div>
            <div><label class="form-label">Jumlah <span class="text-red-500">*</span></label><input type="number" min="1" name="quantity" value="{{ old('quantity', $inventory->quantity ?? 1) }}" class="form-control mt-1" required></div>
            <div><label class="form-label">Kondisi <span class="text-red-500">*</span></label><select name="condition" class="form-control mt-1" required>@foreach(\App\Models\Inventory::CONDITIONS as $value => $label)<option value="{{ $value }}" @selected(old('condition', $inventory->condition ?? 'baik') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Lokasi barang</label><input name="location" value="{{ old('location', $inventory->location) }}" class="form-control mt-1" placeholder="Dapur, gudang, dll."></div>
            <div><label class="form-label">Penanggung jawab <span class="text-red-500">*</span></label><select name="people_id" class="form-control mt-1" required><option value="">Pilih orang</option>@foreach($people as $person)<option value="{{ $person->id }}" @selected((string) old('people_id', $inventory->people_id) === (string) $person->id)>{{ $person->name }}</option>@endforeach</select></div>
            <div><label class="form-label">Foto barang</label><input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" class="form-control mt-1"><p class="mt-1 text-xs text-stone-500">JPG, PNG, WEBP. Maksimal 2MB.</p></div>
            <div class="sm:col-span-2"><label class="form-label">Keterangan</label><textarea name="description" rows="4" class="form-control mt-1">{{ old('description', $inventory->description) }}</textarea></div>
            @if($inventory->photo_path)<div class="sm:col-span-2"><div class="text-xs text-stone-500">Foto saat ini</div><img src="{{ Storage::url($inventory->photo_path) }}" class="mt-2 max-h-52 rounded-xl border object-contain" alt="Barang"></div>@endif
        </div>
        <div class="mt-6 flex gap-3"><button class="btn-primary">Simpan</button><a href="{{ route('inventories.index') }}" class="btn-secondary">Batal</a></div>
    </form>
</x-app-layout>
