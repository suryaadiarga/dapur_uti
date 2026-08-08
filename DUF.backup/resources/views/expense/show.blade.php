<x-app-layout>
    <x-slot name="title">Detail Uang Keluar - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex items-start justify-between gap-4"><div><a href="{{ route('expense.index') }}" class="text-sm font-medium text-emerald-700">← Kembali</a><h1 class="page-title mt-3">Detail Uang Keluar</h1></div><a href="{{ route('expense.edit', $transaction) }}" class="btn-secondary">Edit</a></div>
    <div class="grid max-w-5xl gap-5 lg:grid-cols-3">
        <div class="panel panel-body lg:col-span-2">
            <div class="mb-6 rounded-xl bg-red-50 p-4"><div class="text-xs text-red-700">Nominal</div><div class="mt-1 text-3xl font-semibold text-red-700">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div></div>
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs uppercase text-stone-500">Tanggal</dt><dd class="mt-1 font-medium">{{ $transaction->transaction_date->format('d/m/Y') }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Orang yang belanja</dt><dd class="mt-1 font-medium">{{ $transaction->person->name }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Kategori</dt><dd class="mt-1">{{ \App\Models\ExpenseTransaction::CATEGORIES[$transaction->category] }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Metode</dt><dd class="mt-1">{{ \App\Models\ExpenseTransaction::PAYMENT_METHODS[$transaction->payment_method] }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Toko/tempat</dt><dd class="mt-1">{{ $transaction->store_name ?: '-' }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Dicatat oleh</dt><dd class="mt-1">{{ $transaction->creator->name }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs uppercase text-stone-500">Keterangan</dt><dd class="mt-1 whitespace-pre-line">{{ $transaction->description ?: '-' }}</dd></div>
            </dl>
        </div>
        <div class="panel panel-body">
            <h2 class="font-semibold">Nota belanja</h2>
            @if($transaction->receipt_path)
                <a href="{{ Storage::url($transaction->receipt_path) }}" target="_blank"><img src="{{ Storage::url($transaction->receipt_path) }}" class="mt-4 w-full rounded-xl border object-contain" alt="Nota"></a>
                <a href="{{ route('expense.download', $transaction) }}" class="btn-secondary mt-3 w-full justify-center">Download Nota</a>
            @else
                <div class="mt-4 rounded-xl bg-stone-50 p-6 text-center text-sm text-stone-500">Tidak ada foto nota.</div>
            @endif
        </div>
    </div>
</x-app-layout>
