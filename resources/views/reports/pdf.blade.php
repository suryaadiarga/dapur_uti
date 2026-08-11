<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $report['title'] }}</title>
    <style>
        @page { margin: 25px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b; font-size: 10px; line-height: 1.5; }
        
        /* Header Styling */
        .header-container { margin-bottom: 20px; border-bottom: 2px solid #0f172a; padding-bottom: 10px; }
        h1 { margin: 0 0 3px; font-size: 18px; font-weight: bold; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; }
        .meta { color: #475569; font-size: 9px; margin: 0; }

        /* Summary Cards / Table */
        .summary { width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 8px 0; margin-left: -8px; margin-right: -8px; }
        .summary td { background: #f8fafc; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; width: 33%; vertical-align: top; }
        .summary .label { font-size: 8px; font-weight: bold; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; }
        .summary strong { display: block; font-size: 13px; font-weight: bold; color: #0f172a; margin-top: 4px; }

        /* Main Data Table */
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th { background: #0f172a; padding: 8px 10px; border: 1px solid #0f172a; text-align: left; font-size: 9px; font-weight: bold; color: #ffffff; text-transform: uppercase; letter-spacing: 0.3px; }
        table.data td { border: 1px solid #cbd5e1; padding: 7px 10px; vertical-align: middle; font-size: 9px; color: #334155; }
        table.data tr:nth-child(even) { background-color: #f8fafc; }

        /* Footer */
        .footer { margin-top: 30px; color: #64748b; font-size: 8px; border-top: 1px solid #cbd5e1; padding-top: 8px; text-align: center; }
    </style>
</head>
<body>
    <div class="header-container">
        <h1>{{ $setting->business_name ?? 'Dapur Uti Finance' }}</h1>
        <p class="meta"><strong>{{ $report['title'] }}</strong> &nbsp;|&nbsp; Periode: {{ $report['period'] }} &nbsp;|&nbsp; Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    
    <table class="summary">
        <tr>
            @foreach($report['summary'] as $label => $value)
                <td>
                    <div class="label">{{ $label }}</div>
                    <strong>{{ str_contains(strtolower($label), 'jumlah') ? number_format($value, 0, ',', '.') : 'Rp '.number_format($value, 0, ',', '.') }}</strong>
                </td>
            @endforeach
        </tr>
    </table>
    
    @php $moneyColumns = ['Nominal', 'Debit', 'Kredit', 'Saldo', 'Harga Satuan', 'Nilai']; @endphp
    
    <table class="data">
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
                        <td>{{ in_array($report['headings'][$index], $moneyColumns) ? 'Rp '.number_format((float) $value, 0, ',', '.') : $value }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($report['headings']) }}" style="text-align: center; padding: 15px; color: #64748b;">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        {{ $setting->business_address ?? '' }} {{ $setting->whatsapp_number ? '| WhatsApp: '.$setting->whatsapp_number : '' }}
    </div>
</body>
</html>