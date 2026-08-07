<x-app-layout>
    <x-slot name="title">Pengaturan - Dapur Uti Finance</x-slot>

    <div class="space-y-6 max-w-4xl">
        <!-- Header Page -->
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Pengaturan</h1>
            <p class="mt-1 text-slate-400 text-sm">Informasi dasar usaha yang ditampilkan di aplikasi dan laporan.</p>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form Card -->
        <div class="glass-card rounded-2xl p-6 lg:p-8 border border-slate-800 bg-slate-900/60">
            <form method="POST" enctype="multipart/form-data" action="{{ route('settings.update') }}" class="space-y-6">
                @csrf 
                @method('PUT')

                <div class="grid gap-5 sm:grid-cols-2">
                    <!-- Nama Usaha -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Nama Usaha <span class="text-indigo-400">*</span>
                        </label>
                        <input type="text" name="business_name" value="{{ old('business_name', $setting->business_name) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition" required placeholder="Contoh: Dapur Uti">
                    </div>

                    <!-- Alamat Usaha -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Alamat Usaha
                        </label>
                        <textarea name="business_address" rows="3" placeholder="Alamat lengkap lokasi usaha..." class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition">{{ old('business_address', $setting->business_address) }}</textarea>
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Nomor WhatsApp
                        </label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition" placeholder="08...">
                    </div>

                    <!-- Mata Uang -->
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Mata Uang
                        </label>
                        <select name="currency" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition">
                            <option value="IDR" selected>Rupiah (IDR)</option>
                        </select>
                    </div>

                    <!-- Logo Usaha -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            Logo Usaha
                        </label>
                        <input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2 text-sm text-slate-300 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-800 file:text-slate-200 hover:file:bg-slate-700 cursor-pointer focus:outline-none">
                        <p class="mt-1.5 text-xs text-slate-400">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                    </div>

                    <!-- Logo Saat Ini -->
                    @if($setting->logo_path)
                        <div class="sm:col-span-2 pt-2 border-t border-slate-800">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Logo Saat Ini</div>
                            <div class="p-2 bg-slate-950/60 rounded-xl border border-slate-800 inline-block">
                                <img src="{{ Storage::url($setting->logo_path) }}" class="h-28 w-28 rounded-lg object-cover" alt="Logo Usaha">
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Button -->
                <div class="pt-4 border-t border-slate-800/80 flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>