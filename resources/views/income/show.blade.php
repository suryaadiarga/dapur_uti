<x-app-layout>
    <x-slot name="title">Detail Uang Masuk - Dapur Uti Finance</x-slot>

    <div class="space-y-6 max-w-5xl">
        <!-- Header Navigasi -->
        <div class="flex items-start justify-between gap-4">
            <div>
                <a href="{{ route('income.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
                <h1 class="text-2xl font-bold text-white tracking-tight mt-2">Detail Uang Masuk</h1>
            </div>
            <a href="{{ route('income.edit', $transaction) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm border border-slate-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Details Panel -->
            <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60 lg:col-span-2 space-y-6">
                <!-- Highlight Nominal -->
                <div class="p-5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex flex-col justify-center">
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Nominal Pemasukan</span>
                    <div class="mt-1 text-3xl font-extrabold text-emerald-400">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Grid Informasi Detail -->
                <dl class="grid gap-5 sm:grid-cols-2 pt-2 border-t border-slate-800/80">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal</dt>
                        <dd class="mt-1 text-sm font-semibold text-white">{{ $transaction->transaction_date->format('d/m/Y') }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pemberi Dana</dt>
                        <dd class="mt-1 text-sm font-semibold text-white">{{ $transaction->person->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-200">{{ \App\Models\IncomeTransaction::CATEGORIES[$transaction->category] }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Metode Pemasukan</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-200">{{ \App\Models\IncomeTransaction::PAYMENT_METHODS[$transaction->payment_method] }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Dicatat Oleh</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-200">{{ $transaction->creator->name }}</dd>
                    </div>

                    <div class="sm:col-span-2 pt-2 border-t border-slate-800/60">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Keterangan</dt>
                        <dd class="mt-1 text-sm text-slate-300 whitespace-pre-line leading-relaxed">{{ $transaction->description ?: '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Proof Panel -->
            <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60 flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Bukti Transaksi
                    </h2>

                    @if($transaction->proof_path)
                        <a href="{{ Storage::url($transaction->proof_path) }}" target="_blank" class="block group relative rounded-xl overflow-hidden border border-slate-800 bg-slate-950/80 hover:border-slate-700 transition">
                            <img src="{{ Storage::url($transaction->proof_path) }}" class="w-full max-h-72 object-contain rounded-xl p-2 transition duration-300 group-hover:scale-105" alt="Bukti">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                                <span class="text-xs font-semibold text-white bg-slate-900/90 px-3 py-1.5 rounded-lg border border-slate-700">Lihat Ukuran Penuh</span>
                            </div>
                        </a>
                    @else
                        <div class="p-8 text-center rounded-xl bg-slate-950/60 border border-slate-800 text-xs text-slate-500">
                            Tidak ada foto bukti yang diunggah.
                        </div>
                    @endif
                </div>

                @if($transaction->proof_path)
                    <div class="mt-4 pt-4 border-t border-slate-800">
                        <a href="{{ route('income.download', $transaction) }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs border border-slate-700 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Bukti
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>