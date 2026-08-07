<x-app-layout>
    <x-slot name="title">{{ $transaction->exists ? 'Edit' : 'Tambah' }} Uang Keluar - Dapur Uti Finance</x-slot>
    <div class="mb-6"><a href="{{ route('expense.index') }}" class="text-sm font-medium text-emerald-700">← Kembali</a><h1 class="page-title mt-3">{{ $transaction->exists ? 'Edit Uang Keluar' : 'Tambah Uang Keluar' }}</h1></div>
    <form method="POST" enctype="multipart/form-data" action="{{ $transaction->exists ? route('expense.update', $transaction) : route('expense.store') }}" class="panel panel-body max-w-4xl">
        @csrf @if($transaction->exists) @method('PUT') @endif
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label class="form-label">Tanggal <span class="text-red-500">*</span></label><input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="form-control mt-1" required></div>
            <div><label class="form-label">Orang yang belanja/mengeluarkan uang <span class="text-red-500">*</span></label><select name="people_id" class="form-control mt-1" required><option value="">Pilih orang</option>@foreach($people as $person)<option value="{{ $person->id }}" @selected((string) old('people_id', $transaction->people_id) === (string) $person->id)>{{ $person->name }}</option>@endforeach</select></div>
            <div><label class="form-label">Kategori <span class="text-red-500">*</span></label><select name="category" class="form-control mt-1" required><option value="">Pilih kategori</option>@foreach(\App\Models\ExpenseTransaction::CATEGORIES as $value => $label)<option value="{{ $value }}" @selected(old('category', $transaction->category) === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Nominal <span class="text-red-500">*</span></label><div class="relative mt-1"><span class="absolute left-3 top-2.5 text-sm text-stone-500">Rp</span><input type="number" min="0" step="1" name="amount" value="{{ old('amount', $transaction->amount) }}" class="form-control pl-10" required></div></div>
            <div><label class="form-label">Metode pembayaran <span class="text-red-500">*</span></label><select name="payment_method" class="form-control mt-1" required>@foreach(\App\Models\ExpenseTransaction::PAYMENT_METHODS as $value => $label)<option value="{{ $value }}" @selected(old('payment_method', $transaction->payment_method ?? 'tunai') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Nama toko/tempat belanja</label><input name="store_name" value="{{ old('store_name', $transaction->store_name) }}" class="form-control mt-1"></div>
            <div><label class="form-label">Foto nota belanja</label><input type="file" name="receipt" accept=".jpg,.jpeg,.png,.webp" class="form-control mt-1"><p class="mt-1 text-xs text-stone-500">JPG, PNG, WEBP. Maksimal 2MB.</p></div>
            <div class="sm:col-span-2"><label class="form-label">Keterangan</label><textarea name="description" rows="4" class="form-control mt-1">{{ old('description', $transaction->description) }}</textarea></div>
            @if($transaction->receipt_path)<div class="sm:col-span-2"><div class="text-xs text-stone-500">Nota saat ini</div><img src="{{ Storage::url($transaction->receipt_path) }}" class="mt-2 max-h-52 rounded-xl border object-contain" alt="Nota"></div>@endif
        </div>
        <div class="mt-6 flex gap-3"><button class="btn-primary">Simpan</button><a href="{{ route('expense.index') }}" class="btn-secondary">Batal</a></div>
    </form>
</x-app-layout>
