<x-app-layout>
    <x-slot name="title">{{ $attendance->exists ? 'Edit' : 'Tambah' }} Absensi - Dapur Uti Finance</x-slot>
    
    <div class="space-y-6 max-w-2xl mx-auto">
        <div>
            <a href="{{ route('attendances.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition flex items-center gap-1 mb-2">← Kembali</a>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">{{ $attendance->exists ? 'Edit Absensi' : 'Catat Absensi Baru' }}</h1>
        </div>

        <div class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60">
            <form method="POST" action="{{ $attendance->exists ? route('attendances.update', $attendance) : route('attendances.store') }}" class="space-y-5">
                @csrf
                @if($attendance->exists) @method('PUT') @endif
                
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Tanggal Absen <span class="text-rose-500">*</span></label>
                    <input type="date" name="attendance_date" value="{{ old('attendance_date', $attendance->attendance_date?->format('Y-m-d') ?? date('Y-m-d')) }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Nama Person <span class="text-rose-500">*</span></label>
                    <select name="people_id" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                        <option value="">Pilih Person...</option>
                        @foreach($people as $p)
                            <option value="{{ $p->id }}" @selected(old('people_id', $attendance->people_id) == $p->id)>{{ $p->name }} ({{ $p->role }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Status Kehadiran <span class="text-rose-500">*</span></label>
                    <select name="status" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none transition" required>
                        @foreach(\App\Models\Attendance::STATUSES as $val => $lbl)
                            <option value="{{ $val }}" @selected(old('status', $attendance->status) === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Catatan</label>
                    <textarea name="notes" rows="3" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition" placeholder="Keterangan tambahan...">{{ old('notes', $attendance->notes) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-slate-800">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition">Simpan Absensi</button>
                    <a href="{{ route('attendances.index') }}" class="px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm border border-slate-700 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>