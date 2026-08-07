<x-app-layout>
    <x-slot name="title">Detail {{ $person->name }} - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <a href="{{ route('people.index') }}" class="text-sm font-medium text-emerald-700">← Kembali</a>
            <h1 class="page-title mt-3">{{ $person->name }}</h1>
            <p class="page-subtitle">{{ \App\Models\Person::ROLES[$person->role] ?? $person->role }}</p>
        </div>
        <a href="{{ route('people.edit', $person) }}" class="btn-secondary">Edit</a>
    </div>
    <div class="grid max-w-4xl gap-5 md:grid-cols-3">
        <div class="panel panel-body md:col-span-2">
            <dl class="grid gap-5 sm:grid-cols-2">
                <div><dt class="text-xs uppercase text-stone-500">Nomor HP</dt><dd class="mt-1 font-medium">{{ $person->phone ?: '-' }}</dd></div>
                <div><dt class="text-xs uppercase text-stone-500">Peran</dt><dd class="mt-1 font-medium">{{ \App\Models\Person::ROLES[$person->role] ?? $person->role }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-xs uppercase text-stone-500">Catatan</dt><dd class="mt-1 whitespace-pre-line">{{ $person->notes ?: '-' }}</dd></div>
            </dl>
        </div>
        <div class="space-y-3">
            <div class="panel p-4"><div class="text-xs text-stone-500">Transaksi masuk</div><div class="mt-1 text-2xl font-semibold">{{ $person->income_transactions_count }}</div></div>
            <div class="panel p-4"><div class="text-xs text-stone-500">Transaksi keluar</div><div class="mt-1 text-2xl font-semibold">{{ $person->expense_transactions_count }}</div></div>
            <div class="panel p-4"><div class="text-xs text-stone-500">Inventaris</div><div class="mt-1 text-2xl font-semibold">{{ $person->inventories_count }}</div></div>
        </div>
    </div>
</x-app-layout>
