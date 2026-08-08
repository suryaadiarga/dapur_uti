<x-app-layout>
    <x-slot name="title">Kelola Nota & Struk - Dapur Uti Finance</x-slot>

    <div class="space-y-6">
        <!-- Header Page -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Galeri Nota & Struk</h1>
                <p class="mt-1 text-slate-400 text-sm">Arsip bukti transaksi dari pengeluaran yang telah dicatat.</p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
            <form method="GET" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Bulan</label>
                    <input type="month" name="month" value="{{ request('month') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Penanggung Jawab</label>
                    <select name="person_id" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition">
                        <option value="">Semua PIC</option>
                        @foreach($people as $person)
                            <option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Kategori</label>
                    <select name="category" class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\ExpenseTransaction::CATEGORIES ?? [] as $value => $label)
                            <option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Nama Toko / Info</label>
                    <input type="text" name="store_name" value="{{ request('store_name') }}" placeholder="Cari nama toko..." class="w-full rounded-xl bg-slate-950/80 border border-slate-800 px-3 py-2 text-xs text-white placeholder-slate-600 focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500 transition">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs border border-slate-700 transition text-center">
                        Filter
                    </button>
                    <a href="{{ route('receipts.index') }}" class="py-2 px-3 rounded-xl bg-slate-950 hover:bg-slate-800 text-slate-400 hover:text-white font-semibold text-xs border border-slate-800 transition text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Receipt Grid Gallery -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @forelse($receipts as $receipt)
                <div class="glass-card rounded-2xl overflow-hidden border border-slate-800 bg-slate-900/60 group relative flex flex-col h-full hover:border-slate-700 transition duration-300">
                    <!-- Image Section -->
                    <a href="{{ Storage::url($receipt->receipt_path) }}" target="_blank" class="block relative aspect-[3/4] w-full overflow-hidden bg-slate-950/80">
                        <img src="{{ Storage::url($receipt->receipt_path) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105" alt="Nota/Struk">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="px-3 py-1.5 rounded-lg bg-slate-900/90 text-white text-xs font-medium border border-slate-700 backdrop-blur-sm">
                                Lihat Penuh
                            </span>
                        </div>
                        
                        <!-- Category Badge Over Image -->
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 rounded-md bg-slate-900/80 text-[10px] font-bold uppercase tracking-wider text-rose-400 border border-slate-700 backdrop-blur-sm shadow-lg">
                                {{ \App\Models\ExpenseTransaction::CATEGORIES[$receipt->category] ?? $receipt->category }}
                            </span>
                        </div>
                    </a>

                    <!-- Detail Section -->
                    <div class="p-3 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-[10px] font-semibold text-slate-500 mb-1">
                                {{ $receipt->transaction_date?->format('d M Y') ?? '-' }}
                            </div>
                            <h3 class="text-sm font-bold text-white leading-tight line-clamp-2 mb-1 group-hover:text-rose-400 transition">
                                {{ $receipt->store_name ?: 'Tanpa Nama Toko' }}
                            </h3>
                            <p class="text-xs text-slate-400 line-clamp-1 mb-2">
                                PIC: {{ $receipt->person->name ?? '-' }}
                            </p>
                        </div>
                        
                        <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between">
                            <span class="text-xs font-bold text-rose-400 truncate">
                                Rp {{ number_format($receipt->amount, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('expense.show', $receipt) }}" class="text-[10px] font-medium text-slate-400 hover:text-white transition bg-slate-800 px-2 py-1 rounded border border-slate-700">
                                Transaksi
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center rounded-2xl border border-slate-800 border-dashed bg-slate-900/30">
                    <div class="p-4 rounded-full bg-slate-800/50 text-slate-500 mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-slate-400 text-sm font-medium">Belum ada nota/struk yang diunggah.</p>
                    <p class="text-slate-500 text-xs mt-1">Nota akan muncul di sini saat Anda menambahkannya pada transaksi pengeluaran.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($receipts->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $receipts->links() }}
            </div>
        @endif
    </div>
</x-app-layout>