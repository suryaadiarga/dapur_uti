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
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal Absen</th>
                            <th>Nama Karyawan</th>
                            <th>Shift / Catatan</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingAttendances as $att)
                            <tr>
                                <td class="whitespace-nowrap">
                                    {{ $att->attendance_date ? $att->attendance_date->format('d/m/Y') : '-' }}
                                </td>
                                <td class="font-semibold whitespace-nowrap text-white">{{ $att->person->name ?? '-' }}</td>
                                <td>{{ $att->notes ?? 'Hadir' }}</td>
                                <td class="text-center whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full font-bold text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        HADIR
                                    </span>
                                </td>
                                <td class="text-right whitespace-nowrap">
                                    <a href="{{ route('salaries.create', ['attendance_id' => $att->id]) }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-md shadow-indigo-600/30 transition">
                                        <span class="text-white">Bayar Gaji</span>
                                        <span class="text-white">➔</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-500">Semua karyawan yang hadir pada absensi sudah dibayarkan gajinya.</td>
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
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat Pembayaran Gaji Karyawan
            </h2>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal Gaji</th>
                            <th>Nama Karyawan</th>
                            <th class="text-right">Nominal</th>
                            <th class="text-center">Bukti Foto</th>
                            <th class="text-center">Tanda Tangan</th>
                            <th>Admin</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salaries as $sal)
                            <tr>
                                <td class="whitespace-nowrap">
                                    {{ $sal->salary_date ? $sal->salary_date->format('d/m/Y') : '-' }}
                                </td>
                                <td class="font-bold whitespace-nowrap text-white">{{ $sal->person->name ?? '-' }}</td>
                                <td class="text-right font-mono font-semibold text-emerald-400 whitespace-nowrap">Rp {{ number_format($sal->amount, 0, ',', '.') }}</td>
                                <td class="text-center whitespace-nowrap">
                                    @if($sal->proof_photo)
                                        <a href="{{ asset('storage/' . $sal->proof_photo) }}" target="_blank" class="text-indigo-400 hover:underline">Lihat Foto</a>
                                    @else
                                        <span class="text-slate-600">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center whitespace-nowrap">
                                    @if($sal->signature)
                                        <div class="inline-block bg-slate-950 p-1 rounded-lg border border-slate-700 shadow-sm">
                                            <img src="{{ $sal->signature }}" alt="Tanda Tangan" class="h-8 w-auto object-contain max-w-[100px]">
                                        </div>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap text-slate-400">{{ $sal->creator->name ?? 'System' }}</td>
                                <td class="text-center whitespace-nowrap">
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
                                <td colspan="7" class="text-center py-10 text-slate-500">Belum ada riwayat gaji yang dibayarkan.</td>
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