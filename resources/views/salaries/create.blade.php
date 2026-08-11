<x-app-layout>
    <x-slot name="title">Form Pembayaran Gaji - Dapur Uti Finance</x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Input Gaji Karyawan</h1>
            <!-- PENGAMAN: Mencegah error jika tanggal kosong, menggunakan attendance_date -->
            <p class="mt-1 text-slate-500 dark:text-slate-400 text-sm">
                Pembayaran untuk: <span class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $attendance->person->name ?? '-' }}</span> 
                (Absen Tgl: {{ optional($attendance->attendance_date)->format('d/m/Y') ?? '-' }})
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-6 sm:p-8 shadow-sm">
            <form action="{{ route('salaries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="salaryForm">
                @csrf
                <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">

                <!-- Tanggal Gaji -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Tanggal Pembayaran Gaji</label>
                    <input type="date" name="salary_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-xl bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                </div>

                <!-- Nominal Gaji -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Nominal Gaji (Rp)</label>
                    <input type="number" name="amount" placeholder="Contoh: 70000" required class="w-full rounded-xl bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition">
                    <p class="mt-1 text-[11px] text-slate-500">*Nominal ini akan otomatis dicatat sebagai pengeluaran baru.</p>
                </div>

                <!-- Upload Foto Bukti -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Foto Bukti Penyerahan (Opsional)</label>
                    
                    <div class="space-y-3">
                        <!-- Input Utama dengan Tombol Kamera Langsung -->
                        <div class="flex items-center gap-3">
                            <label class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-50 dark:bg-indigo-600/20 border border-indigo-200 dark:border-indigo-500/30 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-600/30 cursor-pointer text-sm font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Buka Kamera Langsung</span>
                                <!-- Atribut capture="environment" memaksa membuka kamera belakang HP -->
                                <input type="file" name="proof_photo" accept="image/*" capture="environment" class="hidden" id="cameraInput">
                            </label>
                        </div>

                        <!-- Atau Pilih dari Galeri/File -->
                        <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 px-1">
                            <span>Atau unggah file dari galeri/perangkat:</span>
                            <input type="file" name="proof_photo_alt" accept="image/*" class="text-slate-600 dark:text-slate-300 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:file:bg-slate-800 file:text-slate-700 dark:file:text-slate-300 hover:file:bg-slate-200 dark:hover:file:bg-slate-700 transition">
                        </div>
                    </div>
                </div>

                <!-- Tanda Tangan Digital -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Tanda Tangan Penerima</label>
                    <div class="border border-slate-300 dark:border-slate-700/60 rounded-xl bg-slate-50 dark:bg-slate-950/80 p-2 text-center">
                        <canvas id="sig-canvas" width="400" height="150" class="w-full bg-white dark:bg-slate-900 rounded-lg cursor-crosshair border border-slate-200 dark:border-slate-800"></canvas>
                        <div class="mt-2 flex justify-between items-center px-2">
                            <button type="button" id="sig-clearBtn" class="text-xs text-rose-600 dark:text-rose-400 hover:underline">Hapus / Ulangi Tanda Tangan</button>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500">Tanda tangani di atas kotak</span>
                        </div>
                    </div>
                    <input type="hidden" name="signature" id="signatureInput">
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" placeholder="Catatan opsional..." class="w-full rounded-xl bg-slate-50 dark:bg-slate-950/80 border border-slate-300 dark:border-slate-700/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition"></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <a href="{{ route('salaries.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-sm border border-slate-300 dark:border-slate-700 transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition">Simpan & Catat Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Skrip Tanda Tangan dengan Koreksi Skala Koordinat Canvas yang Akurat -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const canvas = document.getElementById("sig-canvas");
            const ctx = canvas.getContext("2d");
            let drawing = false;

            // Sesuaikan warna goresan tanda tangan agar terlihat jelas di light maupun dark mode
            function updatePenColor() {
                const isDark = document.documentElement.classList.contains('dark');
                ctx.strokeStyle = isDark ? "#ffffff" : "#0f172a";
            }
            
            updatePenColor();
            ctx.lineWidth = 2;
            ctx.lineJoin = "round";
            ctx.lineCap = "round";

            function getPos(e) {
                const rect = canvas.getBoundingClientRect();
                const clientX = e.clientX || (e.touches && e.touches[0].clientX);
                const clientY = e.clientY || (e.touches && e.touches[0].clientY);

                // Hitung skala rasio agar titik sentuh/kursor pas dengan garis canvas
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;

                return {
                    x: (clientX - rect.left) * scaleX,
                    y: (clientY - rect.top) * scaleY
                };
            }

            canvas.addEventListener("mousedown", (e) => { 
                updatePenColor();
                drawing = true; 
                ctx.beginPath(); 
                const pos = getPos(e);
                ctx.moveTo(pos.x, pos.y); 
            });

            canvas.addEventListener("mousemove", (e) => { 
                if (!drawing) return; 
                const pos = getPos(e);
                ctx.lineTo(pos.x, pos.y); 
                ctx.stroke(); 
            });

            window.addEventListener("mouseup", () => { drawing = false; });

            // Touch support untuk HP/Tablet
            canvas.addEventListener("touchstart", (e) => { 
                updatePenColor();
                drawing = true; 
                ctx.beginPath(); 
                const pos = getPos(e);
                ctx.moveTo(pos.x, pos.y); 
                e.preventDefault(); 
            });

            canvas.addEventListener("touchmove", (e) => { 
                if (!drawing) return; 
                const pos = getPos(e);
                ctx.lineTo(pos.x, pos.y); 
                ctx.stroke(); 
                e.preventDefault(); 
            });

            window.addEventListener("touchend", () => { drawing = false; });

            document.getElementById("sig-clearBtn").addEventListener("click", () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById("signatureInput").value = "";
            });

            document.getElementById("salaryForm").addEventListener("submit", function(e) {
                const dataURL = canvas.toDataURL("image/png");
                document.getElementById("signatureInput").value = dataURL;
            });
        });
    </script>
</x-app-layout>