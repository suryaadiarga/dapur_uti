<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $report['title'] }}</title>
    <style>
        @page { margin: 24px; }
        body { font-family: DejaVu Sans, sans-serif; color: #292524; font-size: 9px; }
        h1 { margin: 0 0 4px; font-size: 18px; color: #064e3b; }
        p { margin: 0; }
        .meta { color: #78716c; margin-bottom: 14px; }
        .summary { width: 100%; margin-bottom: 14px; border-collapse: separate; border-spacing: 6px 0; }
        .summary td { background: #f5f5f4; padding: 8px; border: 1px solid #e7e5e4; }
        .summary strong { display: block; margin-top: 3px; font-size: 12px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th { background: #064e3b; color: white; padding: 6px; text-align: left; font-size: 8px; }
        table.data td { border: 1px solid #e7e5e4; padding: 5px; vertical-align: top; }
        table.data tr:nth-child(even) td { background: #fafaf9; }
        .footer { margin-top: 12px; color: #78716c; font-size: 8px; }
    </style>
</head>
<body>
    <h1>{{ $setting->business_name }} — {{ $report['title'] }}</h1>
    <p class="meta">Periode {{ $report['period'] }} · Dicetak {{ now()->translatedFormat('d F Y H:i') }}</p>
    <table class="summary"><tr>
        @foreach($report['summary'] as $label => $value)
            <td>{{ $label }}<strong>{{ str_contains(strtolower($label), 'jumlah') ? number_format($value, 0, ',', '.') : 'Rp '.number_format($value, 0, ',', '.') }}</strong></td>
        @endforeach
    </tr></table>
    @php
        $moneyColumns = ['Nominal', 'Debit', 'Kredit', 'Saldo', 'Harga Satuan', 'Nilai'];
    @endphp
    <table class="data">
        <thead><tr>@foreach($report['headings'] as $heading)<th>{{ $heading }}</th>@endforeach</tr></thead>
        <tbody>
        @forelse($report['rows'] as $row)
            <tr>@foreach($row as $index => $value)<td>{{ in_array($report['headings'][$index], $moneyColumns) ? 'Rp '.number_format((float) $value, 0, ',', '.') : $value }}</td>@endforeach</tr>
        @empty
            <tr><td colspan="{{ count($report['headings']) }}">Tidak ada data.</td></tr>
        @endforelse
        </tbody>
    </table>
    <p class="footer">{{ $setting->business_address }} {{ $setting->whatsapp_number ? '· WhatsApp '.$setting->whatsapp_number : '' }}</p>
</body>
</html>
