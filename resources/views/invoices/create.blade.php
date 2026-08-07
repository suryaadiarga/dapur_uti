<x-app-layout>
    <x-slot name="title">Generate Invoice Otomatis - Dapur Uti Finance</x-slot>
    
    <div class="space-y-6 max-w-xl mx-auto">
        <div>
            <a href="{{ route('invoices.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1 mb-2">← Kembali</a>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Generate Invoice Otomatis</h1>
            <p class="mt-1 text-slate-400 text-sm">Pilih rentang tanggal untuk merangkum jadwal makan & total biaya.</p>
        </div>

        <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60">
            <form method="POST" action="{{ route('invoices.store') }}" class="space-y-5">
                @csrf
                
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Dari Tanggal <span class="text-rose-500">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                        @error('start_date') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Sampai Tanggal <span class="text-rose-500">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Catatan Invoice (Opsional)</label>
                    <textarea name="notes" rows="3" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition" placeholder="Contoh: Pembayaran termin pertama catering bulanan...">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition">Generate Invoice</button>
                    <a href="{{ route('invoices.index') }}" class="px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm border border-slate-700 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>