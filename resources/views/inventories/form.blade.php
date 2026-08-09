<x-app-layout>
    <x-slot name="title">{{ $inventory->exists ? 'Edit' : 'Tambah' }} Inventaris - Dapur Uti Finance</x-slot>

    <div class="space-y-6 max-w-4xl">
        <!-- Header & Navigasi Kembali -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('inventories.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-white tracking-tight mt-2">
                    {{ $inventory->exists ? 'Edit Inventaris' : 'Tambah Inventaris' }}
                </h1>
            </div>
        </div>

        <!-- Form Container -->
        <div class="glass-card rounded-2xl p-6 lg:p-8 border border-slate-800 bg-slate-900/60">
            <form method="POST" enctype="multipart/form-data" action="{{ $inventory->exists ? route('inventories.update', $inventory) : route('inventories.store') }}" class="space-y-6">
                @csrf 
                @if($inventory->exists) 
                    @method('PUT') 
                @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    <!-- Nama Barang -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Nama Barang <span class="text-amber-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $inventory->name) }}" class="w-full rounded-xl bg-slate-950/80 border @error('name') border-red-500 @else border-slate-700/60 @enderror px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition" required placeholder="Contoh: Kulkas Showcase Sharp">
                        @error('name')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pembelian -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Tanggal Pembelian <span class="text-amber-500">*</span>
                        </label>
                        <input type="date" name="purchase_date" value="{{ old('purchase_date', optional($inventory->purchase_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="w-full rounded-xl bg-slate-950/80 border @error('purchase_date') border-red-500 @else border-slate-700/60 @enderror px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition" required>
                        @error('purchase_date')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Penanggung Jawab / Pemilik -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Penanggung Jawab <span class="text-amber-500">*</span>
                        </label>
                        <select name="people_id" class="w-full rounded-xl bg-slate-950/80 border @error('people_id') border-red-500 @else border-slate-700/60 @enderror px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition" required>
                            <option value="">Pilih orang</option>
                            @foreach($people as $person)
                                <option value="{{ $person->id }}" @selected((string) old('people_id', $inventory->people_id) === (string) $person->id)>{{ $person->name }}</option>
                            @endforeach
                        </select>
                        @error('people_id')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Kategori <span class="text-amber-500">*</span>
                        </label>
                        <select name="category" class="w-full rounded-xl bg-slate-950/80 border @error('category') border-red-500 @else border-slate-700/60 @enderror px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition" required>
                            <option value="">Pilih kategori</option>
                            @foreach(\App\Models\Inventory::CATEGORIES ?? [] as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $inventory->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kondisi -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Kondisi <span class="text-amber-500">*</span>
                        </label>
                        <select name="condition" class="w-full rounded-xl bg-slate-950/80 border @error('condition') border-red-500 @else border-slate-700/60 @enderror px-4 py-2.5 text-sm text-white focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition" required>
                            <option value="">Pilih kondisi</option>
                            @foreach(\App\Models\Inventory::CONDITIONS ?? [] as $value => $label)
                                <option value="{{ $value }}" @selected(old('condition', $inventory->condition) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('condition')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kuantitas -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Kuantitas <span class="text-amber-500">*</span>
                        </label>
                        <input type="number" min="1" step="1" name="quantity" value="{{ old('quantity', $inventory->quantity ?? 1) }}" class="w-full rounded-xl bg-slate-950/80 border @error('quantity') border-red-500 @else border-slate-700/60 @enderror px-4 py-2.5 text-sm font-bold text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition" required>
                        @error('quantity')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Beli Satuan -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Harga Beli (Satuan) <span class="text-amber-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-sm font-semibold text-amber-400">Rp</span>
                            <input type="number" min="0" step="1" name="purchase_price" value="{{ old('purchase_price', $inventory->purchase_price) }}" class="w-full rounded-xl bg-slate-950/80 border @error('purchase_price') border-red-500 @else border-slate-700/60 @enderror pl-10 pr-4 py-2.5 text-sm font-bold text-white placeholder-slate-500 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition" required>
                        </div>
                        @error('purchase_price')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Barang -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Foto Barang
                        </label>
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-xl bg-slate-950/80 border @error('photo') border-red-500 @else border-slate-700/60 @enderror px-4 py-2 text-sm text-slate-300 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 cursor-pointer focus:outline-none">
                        <p class="mt-1.5 text-xs text-slate-400">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                        @error('photo')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keterangan Spesifikasi -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Spesifikasi / Keterangan
                        </label>
                        <textarea name="description" rows="3" placeholder="Catatan spesifikasi, merk, atau informasi lain..." class="w-full rounded-xl bg-slate-950/80 border @error('description') border-red-500 @else border-slate-700/60 @enderror px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 transition">{{ old('description', $inventory->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preview Bukti Saat Ini -->
                    @if($inventory->photo_path)
                        <div class="sm:col-span-2 pt-2 border-t border-slate-800">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Foto saat ini</div>
                            <div class="p-2 bg-slate-950/60 rounded-xl border border-slate-800 inline-block">
                                <img src="{{ Storage::url($inventory->photo_path) }}" class="max-h-52 rounded-lg object-contain" alt="Foto Barang">
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-slate-800/80 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-semibold text-sm shadow-lg shadow-amber-600/30 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan
                    </button>
                    <a href="{{ route('inventories.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm border border-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>