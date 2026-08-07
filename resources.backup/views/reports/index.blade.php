<x-app-layout>
    <x-slot name="title">Laporan - Dapur Uti Finance</x-slot>
    <div class="mb-6"><h1 class="page-title">Laporan</h1><p class="page-subtitle">Tampilkan dan export laporan ke PDF atau Excel.</p></div>

    <div x-data="{ period: '{{ request('period', 'month') }}' }" class="panel mb-5 panel-body">
        <form method="GET" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <div>
                <label class="form-label">Jenis laporan</label>
                <select name="type" class="form-control mt-1">
                    @foreach(\App\Services\ReportService::TYPES as $value => $label)<option value="{{ $value }}" @selected(request('type', 'income') === $value)>{{ $label }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Periode</label>
                <select name="period" x-model="period" class="form-control mt-1">
                    <option value="today">Hari ini</option>
                    <option value="week">Minggu ini</option>
                    <option value="month">Bulan ini</option>
                    <option value="year">Tahun ini</option>
                    <option value="custom">Rentang custom</option>
                </select>
            </div>
            <div x-show="period === 'custom'"><label class="form-label">Dari tanggal</label><input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control mt-1" :required="period === 'custom'"></div>
            <div x-show="period === 'custom'"><label class="form-label">Sampai tanggal</label><input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control mt-1" :required="period === 'custom'"></div>
            <div class="flex items-end"><button class="btn-primary">Tampilkan</button></div>
        </form>
    </div>

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div><h2 class="text-lg font-semibold">{{ $report['title'] }}</h2><p class="text-sm text-stone-500">{{ $report['period'] }}</p></div>
        <div class="flex gap-2">
            <a href="{{ route('reports.pdf', request()->query()) }}" class="btn-secondary">Export PDF</a>
            <a href="{{ route('reports.excel', request()->query()) }}" class="btn-primary">Export Excel</a>
        </div>
    </div>

    <div class="mb-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($report['summary'] as $label => $value)
            <div class="panel p-4">
                <div class="text-xs text-stone-500">{{ $label }}</div>
                <div class="mt-1 text-xl font-semibold">{{ str_contains(strtolower($label), 'jumlah') ? number_format($value, 0, ',', '.') : 'Rp '.number_format($value, 0, ',', '.') }}</div>
            </div>
        @endforeach
    </div>

    @php
        $moneyColumns = ['Nominal', 'Debit', 'Kredit', 'Saldo', 'Harga Satuan', 'Nilai'];
    @endphp
    <div class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr>@foreach($report['headings'] as $heading)<th>{{ $heading }}</th>@endforeach</tr></thead>
                <tbody>
                @forelse($report['rows'] as $row)
                    <tr>
                        @foreach($row as $index => $value)
                            <td class="{{ in_array($report['headings'][$index], $moneyColumns) ? 'whitespace-nowrap' : '' }}">
                                {{ in_array($report['headings'][$index], $moneyColumns) ? 'Rp '.number_format((float) $value, 0, ',', '.') : $value }}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr><td colspan="{{ count($report['headings']) }}" class="py-10 text-center text-stone-500">Tidak ada data pada periode ini.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
