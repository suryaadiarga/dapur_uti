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
                                <!-- PERBAIKAN: Menggunakan attendance_date dan pengaman format -->
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
                                    <a href="{{ route('salaries.create', ['attendance_id' => $att->id]) }}" class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-md shadow-indigo-600/30 transition">
                                        Bayar Gaji ➔
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
            </div>
        </div>

        <!-- 2. BAGIAN: Riwayat Pembayaran Gaji -->
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 p-6 space-y-4">
            <h2 class="text-base font-bold text-white flex items-center gap-2">
                📜 Riwayat Pembayaran Gaji Karyawan
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
                                <!-- PENGAMAN: Cek salary_date -->
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
                                        <span class="text-emerald-400 font-semibold">Tersimpan</span>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-400">{{ $sal->creator->name ?? 'System' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('salaries.destroy', $sal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data gaji ini? (Data pengeluaran terkait juga akan terpengaruh)')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 transition" title="Hapus">
                                            🗑️
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