<x-app-layout>
    <x-slot name="title">Detail {{ $person->name }} - Dapur Uti Finance</x-slot>
    
    <div class="space-y-6 max-w-5xl">
        <!-- Header Page -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <a href="{{ route('people.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar Orang
                </a>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">{{ $person->name }}</h1>
                <div class="mt-1 flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-lg bg-indigo-500/10 text-indigo-400 text-xs font-medium border border-indigo-500/20">
                        {{ \App\Models\Person::ROLES[$person->role] ?? $person->role }}
                    </span>
                </div>
            </div>
            <a href="{{ route('people.edit', $person) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm border border-slate-700 transition">
                Edit Data
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <!-- Informasi Detail -->
            <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60 md:col-span-2 space-y-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 border-b border-slate-800 pb-3">Informasi Kontak & Catatan</h3>
                
                <dl class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Nomor HP</dt>
                        <dd class="mt-1 font-mono text-sm text-white">{{ $person->phone ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Peran</dt>
                        <dd class="mt-1 text-sm text-white">{{ \App\Models\Person::ROLES[$person->role] ?? $person->role }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Catatan</dt>
                        <dd class="mt-1 text-sm text-slate-300 whitespace-pre-line">{{ $person->notes ?: '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Statistik Relasi -->
            <div class="space-y-4">
                <div class="glass-card rounded-2xl p-4 border border-slate-800 bg-slate-900/60">
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Transaksi Masuk</div>
                    <div class="mt-2 text-2xl font-extrabold text-emerald-400">{{ $person->income_transactions_count ?? 0 }}</div>
                </div>
                <div class="glass-card rounded-2xl p-4 border border-slate-800 bg-slate-900/60">
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Transaksi Keluar</div>
                    <div class="mt-2 text-2xl font-extrabold text-rose-400">{{ $person->expense_transactions_count ?? 0 }}</div>
                </div>
                <div class="glass-card rounded-2xl p-4 border border-slate-800 bg-slate-900/60">
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Inventaris Terkait</div>
                    <div class="mt-2 text-2xl font-extrabold text-indigo-400">{{ $person->inventories_count ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>