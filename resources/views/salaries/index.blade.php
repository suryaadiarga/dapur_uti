<x-app-layout>
    <x-slot name="title">Gaji Karyawan - Dapur Uti Finance</x-slot>

    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight">Gaji Karyawan & Payroll</h1>
                <p class="mt-1 text-slate-400 text-sm">Kelola pembayaran gaji harian/borongan berdasarkan data absensi kehadiran.</p>
            </div>
        </div>

        <!-- 1. BAGIAN: Absensi Hadir yang Belum Dibayar Gajinya -->
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 p-6 space-y-4">
            <h2 class="text-base font-bold text-white flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                Absensi Hadir Menunggu Pembayaran Gaji
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-950/80 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-4 py-3">Tanggal Absen</th>
                            <th class="px-4 py-3">Nama Karyawan</th>
                            <th class="px-4 py-3">Shift / Catatan</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($pendingAttendances as $att)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-4 py-3 text-slate-300">
                                    {{ $att->attendance_date ? $att->attendance_date->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-white">{{ $att->person->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-400">{{ $att->notes ?? 'Hadir' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2.5 py-1 rounded-full font-bold text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        HADIR
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('salaries.create', ['attendance_id' => $att->id]) }}" class="inline-flex flex-col sm:flex-row items-center justify-center gap-1 px-3 py-2 sm:py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-md shadow-indigo-600/30 transition text-center">
                                        <span class="text-white !text-white">Bayar Gaji</span>
                                        <span class="text-sm sm:text-xs text-white !text-white">➔</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-500">Semua karyawan yang hadir pada absensi sudah dibayarkan gajinya.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($pendingAttendances->hasPages())
                    <div class="pt-4">
                         {{ $pendingAttendances->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- 2. BAGIAN: Riwayat Pembayaran Gaji -->
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 p-6 space-y-4">
            <h2 class="text-base font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-16 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M0 112C0 70.5 31.6 36.4 72 32.4l0-.4 280 0c53 0 96 43 96 96l0 176-176 0c-39.8 0-72 32.2-72 72l0 60c0 24.3-19.7 44-44 44s-44-19.7-44-44l0-228-64 0c-26.5 0-48-21.5-48-48l0-48zM236.8 480c7.1-13.1 11.2-28.1 11.2-44l0-60c0-13.3 10.7-24 24-24l248 0c13.3 0 24 10.7 24 24l0 24c0 44.2-35.8 80-80 80l-227.2 0zM80 80c-17.7 0-32 14.3-32 32l0 48 64 0 0-48c0-17.7-14.3-32-32-32z"/></svg>
                Riwayat Pembayaran Gaji Karyawan
            </h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-950/80 text-slate-400 uppercase tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-4 py-3">Tanggal Gaji</th>
                            <th class="px-4 py-3">Nama Karyawan</th>
                            <th class="px-4 py-3 text-right">Nominal</th>
                            <th class="px-4 py-3 text-center">Bukti Foto</th>
                            <th class="px-4 py-3 text-center">Tanda Tangan</th>
                            <th class="px-4 py-3">Admin</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($salaries as $sal)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-4 py-3 text-slate-300">
                                    {{ $sal->salary_date ? $sal->salary_date->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 font-bold text-white">{{ $sal->person->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-right font-mono font-semibold text-emerald-400">Rp {{ number_format($sal->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($sal->proof_photo)
                                        <a href="{{ asset('storage/' . $sal->proof_photo) }}" target="_blank" class="text-indigo-400 hover:underline">Lihat Foto</a>
                                    @else
                                        <span class="text-slate-600">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($sal->signature)
                                        <div class="inline-block bg-slate-950 p-1 rounded-lg border border-slate-700 shadow-sm">
                                            <img src="{{ $sal->signature }}" alt="Tanda Tangan" class="h-10 w-auto object-contain max-w-[100px]">
                                        </div>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-400">{{ $sal->creator->name ?? 'System' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('salaries.destroy', $sal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data gaji ini? (Data pengeluaran terkait juga akan terpengaruh)')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition border border-rose-500/20" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-slate-500">Belum ada riwayat gaji yang dibayarkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($salaries->hasPages())
                <div class="pt-4">
                    {{ $salaries->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>