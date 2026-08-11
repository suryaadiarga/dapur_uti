<x-app-layout>
    <x-slot name="title">Laporan - Dapur Uti Finance</x-slot>

    <div class="space-y-6">
        <!-- Header Page -->
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Laporan</h1>
            <p class="mt-1 text-slate-400 text-sm">Tampilkan ringkasan data dan export laporan ke PDF atau Excel.</p>
        </div>

        <!-- Filter Card -->
        <div x-data="{ period: '{{ request('period', 'month') }}' }" class="glass-card rounded-2xl p-6 border border-slate-800 bg-slate-900/60">
            <form method="GET" action="{{ route('reports.index') }}" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <!-- Jenis Laporan -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Jenis Laporan</label>
                    <select name="type" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none transition">
                        @foreach(\App\Services\ReportService::TYPES as $value => $label)
                            <option value="{{ $value }}" @selected(request('type', 'income') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Periode -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Periode</label>
                    <select name="period" x-model="period" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none transition">
                        <option value="today">Hari ini</option>
                        <option value="week">Minggu ini</option>
                        <option value="month">Bulan ini</option>
                        <option value="year">Tahun ini</option>
                        <option value="custom">Rentang custom</option>
                    </select>
                </div>
                
                <!-- Date Custom -->
                <div x-show="period === 'custom'" x-cloak>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Dari</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none transition">
                </div>
                <div x-show="period === 'custom'" x-cloak>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Sampai</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none transition">
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Export Actions -->
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-white">{{ $report['title'] }}</h2>
                <p class="text-sm text-slate-400">{{ $report['period'] }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('reports.pdf', request()->query()) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-sm border border-slate-700 transition">PDF</a>
                <a href="{{ route('reports.excel', request()->query()) }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition">Excel</a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($report['summary'] as $label => $value)
                <div class="glass-card rounded-2xl p-5 border border-slate-800 bg-slate-900/60">
                    <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $label }}</div>
                    <div class="mt-2 text-2xl font-extrabold text-white">
                        {{ str_contains(strtolower($label), 'jumlah') ? number_format($value, 0, ',', '.') : 'Rp '.number_format($value, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Table Data Menggunakan .data-table -->
        @php $moneyColumns = ['Nominal', 'Debit', 'Kredit', 'Saldo', 'Harga Satuan', 'Nilai']; @endphp
        <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/60 overflow-hidden">
            <div class="overflow-x-auto p-4">
                <table class="data-table">
                    <thead>
                        <tr>
                            @foreach($report['headings'] as $heading)
                                <th>{{ $heading }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($report['rows'] as $row)
                            <tr>
                                @foreach($row as $index => $value)
                                    <td class="whitespace-nowrap {{ in_array($report['headings'][$index], $moneyColumns) ? 'font-mono text-indigo-400 font-semibold' : '' }}">
                                        {{ in_array($report['headings'][$index], $moneyColumns) ? 'Rp '.number_format((float) $value, 0, ',', '.') : $value }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($report['headings']) }}" class="text-center py-10 text-slate-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>