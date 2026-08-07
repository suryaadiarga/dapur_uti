<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $report['title'] }}</title>
    <style>
        @page { margin: 30px; }
        body { font-family: sans-serif; color: #1e293b; font-size: 10px; line-height: 1.4; }
        h1 { margin: 0 0 5px; font-size: 16px; color: #0f172a; }
        .meta { color: #64748b; margin-bottom: 20px; font-size: 9px; }
        .summary { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .summary td { background: #f8fafc; padding: 10px; border: 1px solid #e2e8f0; width: 33%; }
        .summary strong { display: block; font-size: 14px; color: #0f172a; margin-top: 2px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #f1f5f9; padding: 8px; border: 1px solid #cbd5e1; text-align: left; font-size: 9px; color: #334155; }
        table.data td { border: 1px solid #e2e8f0; padding: 6px; vertical-align: top; font-size: 9px; }
        .footer { margin-top: 20px; color: #94a3b8; font-size: 8px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <h1>{{ $setting->business_name ?? 'Laporan Usaha' }}</h1>
    <p class="meta"><strong>{{ $report['title'] }}</strong> | Periode: {{ $report['period'] }} | Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    
    <table class="summary">
        <tr>
            @foreach($report['summary'] as $label => $value)
                <td>
                    {{ $label }}
                    <strong>{{ str_contains(strtolower($label), 'jumlah') ? number_format($value, 0, ',', '.') : 'Rp '.number_format($value, 0, ',', '.') }}</strong>
                </td>
            @endforeach
        </tr>
    </table>
    
    @php $moneyColumns = ['Nominal', 'Debit', 'Kredit', 'Saldo', 'Harga Satuan', 'Nilai']; @endphp
    
    <table class="data">
        <thead>
            <tr>
                @foreach($report['headings'] as $heading)<th>{{ $heading }}</th>@endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($report['rows'] as $row)
                <tr>
                    @foreach($row as $index => $value)
                        <td>{{ in_array($report['headings'][$index], $moneyColumns) ? 'Rp '.number_format((float) $value, 0, ',', '.') : $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        {{ $setting->business_address ?? '' }} {{ $setting->whatsapp_number ? '| WA: '.$setting->whatsapp_number : '' }}
    </div>
</body>
</html>