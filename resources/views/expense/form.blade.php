<x-app-layout>
    <x-slot name="title">{{ $transaction->exists ? 'Edit' : 'Tambah' }} Uang Keluar - Dapur Uti Finance</x-slot>

    <div class="space-y-6 max-w-4xl">
        <!-- Header & Navigasi Kembali -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('expense.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-white tracking-tight mt-2">
                    {{ $transaction->exists ? 'Edit Uang Keluar' : 'Tambah Uang Keluar' }}
                </h1>
            </div>
        </div>

        <!-- Form Container -->
        <div class="glass-card rounded-2xl p-6 lg:p-8 border border-slate-800 bg-slate-900/60">
            <form method="POST" enctype="multipart/form-data" action="{{ $transaction->exists ? route('expense.update', $transaction) : route('expense.store') }}" class="space-y-6">
                @csrf 
                @if($transaction->exists) 
                    @method('PUT') 
                @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Tanggal <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition" required>
                    </div>

                    <!-- Orang yang belanja -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Orang yang belanja/mengeluarkan uang <span class="text-rose-500">*</span>
                        </label>
                        <select name="people_id" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition" required>
                            <option value="">Pilih orang</option>
                            @foreach($people as $person)
                                <option value="{{ $person->id }}" @selected((string) old('people_id', $transaction->people_id) === (string) $person->id)>{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select name="category" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition" required>
                            <option value="">Pilih kategori</option>
                            @foreach(\App\Models\ExpenseTransaction::CATEGORIES as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $transaction->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nominal -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Nominal <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-sm font-semibold text-rose-400">Rp</span>
                            <input type="number" min="0" step="1" name="amount" value="{{ old('amount', $transaction->amount) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 pl-10 pr-4 py-2.5 text-sm font-bold text-white placeholder-slate-500 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition" required>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Metode pembayaran <span class="text-rose-500">*</span>
                        </label>
                        <select name="payment_method" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition" required>
                            @foreach(\App\Models\ExpenseTransaction::PAYMENT_METHODS as $value => $label)
                                <option value="{{ $value }}" @selected(old('payment_method', $transaction->payment_method ?? 'tunai') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama Toko -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Nama toko/tempat belanja
                        </label>
                        <input name="store_name" value="{{ old('store_name', $transaction->store_name) }}" placeholder="Contoh: Pasar Anyar, Indomaret, dll." class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition">
                    </div>

                    <!-- Foto Nota -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Foto nota belanja
                        </label>
                        <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2 text-sm text-slate-300 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 cursor-pointer focus:outline-none">
                        <p class="mt-1.5 text-xs text-slate-400">Format yang didukung: JPG, PNG, WEBP. Maksimal 2MB.</p>
                    </div>

                    <!-- Keterangan -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Keterangan
                        </label>
                        <textarea name="description" rows="4" placeholder="Detail belanjaan atau catatan tambahan..." class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition">{{ old('description', $transaction->description) }}</textarea>
                    </div>

                    <!-- Preview Nota Saat Ini -->
                    @if($transaction->receipt_path)
                        <div class="sm:col-span-2 pt-2 border-t border-slate-800">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Nota saat ini</div>
                            <div class="p-2 bg-slate-950/60 rounded-xl border border-slate-800 inline-block">
                                <img src="{{ Storage::url($transaction->receipt_path) }}" class="max-h-52 rounded-lg object-contain" alt="Nota">
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-slate-800/80 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-semibold text-sm shadow-lg shadow-rose-600/30 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan
                    </button>
                    <a href="{{ route('expense.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm border border-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>