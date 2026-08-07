<x-app-layout>
    <x-slot name="title">{{ $person->exists ? 'Edit' : 'Tambah' }} Orang - Dapur Uti Finance</x-slot>
    
    <div class="space-y-6 max-w-3xl mx-auto">
        <!-- Header Page -->
        <div>
            <a href="{{ route('people.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Orang
            </a>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">{{ $person->exists ? 'Edit Data Orang' : 'Tambah Data Orang' }}</h1>
            <p class="mt-1 text-slate-400 text-sm">Kelola informasi penanggung jawab atau pihak yang terlibat.</p>
        </div>

        <!-- Form Card -->
        <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60">
            <form method="POST" action="{{ $person->exists ? route('people.update', $person) : route('people.store') }}" class="space-y-5">
                @csrf
                @if($person->exists) @method('PUT') @endif
                
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Nama <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $person->name) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition" placeholder="Nama lengkap..." required>
                        @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $person->phone) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition" placeholder="Contoh: 08123456789">
                        @error('phone') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Peran <span class="text-rose-500">*</span></label>
                        <select name="role" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition" required>
                            <option value="">Pilih peran...</option>
                            @foreach(\App\Models\Person::ROLES as $value => $label)
                                <option value="{{ $value }}" @selected(old('role', $person->role) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Catatan</label>
                        <textarea name="notes" rows="4" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition" placeholder="Keterangan tambahan...">{{ old('notes', $person->notes) }}</textarea>
                        @error('notes') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition">
                        Simpan Data
                    </button>
                    <a href="{{ route('people.index') }}" class="px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm border border-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>