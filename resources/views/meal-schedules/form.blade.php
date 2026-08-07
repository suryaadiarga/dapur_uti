<x-app-layout>
    <x-slot name="title">{{ $mealSchedule->exists ? 'Edit' : 'Tambah' }} Jadwal Makanan - Dapur Uti Finance</x-slot>
    
    <div class="space-y-6 max-w-2xl mx-auto">
        <div>
            <a href="{{ route('meal-schedules.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1 mb-2">← Kembali</a>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">{{ $mealSchedule->exists ? 'Edit Jadwal Makanan' : 'Tambah Jadwal Makanan' }}</h1>
        </div>

        <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60">
            <form method="POST" action="{{ $mealSchedule->exists ? route('meal-schedules.update', $mealSchedule) : route('meal-schedules.store') }}" class="space-y-5">
                @csrf
                @if($mealSchedule->exists) @method('PUT') @endif
                
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Tanggal <span class="text-rose-500">*</span></label>
                        <input type="date" name="schedule_date" value="{{ old('schedule_date', $mealSchedule->schedule_date?->format('Y-m-d') ?? date('Y-m-d')) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Pilihan Shift <span class="text-rose-500">*</span></label>
                        <select name="shift" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                            @foreach(\App\Models\MealSchedule::SHIFTS as $sNum => $sLbl)
                                <option value="{{ $sNum }}" @selected(old('shift', $mealSchedule->shift) == $sNum)>{{ $sLbl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Modifikasi Bagian Menu Makanan Dinamis (Alpine.js) -->
                <div x-data="{ 
                    menus: @js(old('menus', $mealSchedule->exists && $mealSchedule->menu_items ? explode(', ', $mealSchedule->menu_items) : [''])) 
                }" class="space-y-3">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Menu Makanan <span class="text-rose-500">*</span></label>
                    
                    <template x-for="(menu, index) in menus" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" 
                                   x-model="menus[index]" 
                                   name="menus[]" 
                                   class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition" 
                                   placeholder="Contoh: Ayam goreng, tempe goreng, dll" 
                                   required>
                            
                            <!-- Tombol Hapus Baris (-) -->
                            <button type="button" 
                                    @click="menus.splice(index, 1)" 
                                    x-show="menus.length > 1"
                                    class="bg-rose-500/20 text-rose-400 hover:bg-rose-500/30 p-2.5 rounded-xl transition shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                            </button>
                        </div>
                    </template>

                    @error('menus') 
                        <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> 
                    @enderror

                    <!-- Tombol Tambah Menu (+) -->
                    <button type="button" 
                            @click="menus.push('')" 
                            class="inline-flex items-center gap-2 text-xs font-semibold bg-indigo-600/20 text-indigo-400 hover:bg-indigo-600/30 px-3.5 py-2 rounded-xl transition border border-indigo-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Menu Lain
                    </button>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Jumlah Porsi (1 - 500+) <span class="text-rose-500">*</span></label>
                        <input type="number" min="1" max="5000" name="portion_count" value="{{ old('portion_count', $mealSchedule->portion_count ?? 50) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Estimasi Biaya Operasional (Rp)</label>
                        <input type="number" step="0.01" min="0" name="estimated_cost" value="{{ old('estimated_cost', $mealSchedule->estimated_cost) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition" placeholder="0">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition" placeholder="Catatan khusus catering...">{{ old('notes', $mealSchedule->notes) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition">Simpan Jadwal</button>
                    <a href="{{ route('meal-schedules.index') }}" class="px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm border border-slate-700 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>