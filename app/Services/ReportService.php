<?php

namespace App\Services;

use App\Models\ExpenseTransaction;
use App\Models\IncomeTransaction;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportService
{
    public const TYPES = [
        'income' => 'Laporan Uang Masuk',
        'expense' => 'Laporan Uang Keluar',
        'cash' => 'Laporan Kas',
        'receipts' => 'Laporan Nota Belanja',
        'inventory' => 'Laporan Inventaris',
    ];

    public function __construct(private readonly CashService $cashService) {}

    public function build(array $filters): array
    {
        $type = array_key_exists($filters['type'] ?? '', self::TYPES) ? $filters['type'] : 'income';
        [$dateFrom, $dateTo, $periodLabel] = $this->dateRange($filters);

        return match ($type) {
            'expense' => $this->expense($dateFrom, $dateTo, $periodLabel),
            'cash' => $this->cash($dateFrom, $dateTo, $periodLabel),
            'receipts' => $this->receipts($dateFrom, $dateTo, $periodLabel),
            'inventory' => $this->inventory($dateFrom, $dateTo, $periodLabel),
            default => $this->income($dateFrom, $dateTo, $periodLabel),
        };
    }

    private function dateRange(array $filters): array
    {
        $now = now();
        $period = $filters['period'] ?? 'month';

        [$from, $to] = match ($period) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            'custom' => [
                Carbon::parse($filters['date_from'] ?? $now->toDateString())->startOfDay(),
                Carbon::parse($filters['date_to'] ?? $now->toDateString())->endOfDay(),
            ],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };

        return [$from->toDateString(), $to->toDateString(), $from->translatedFormat('d M Y').' - '.$to->translatedFormat('d M Y')];
    }

    private function base(string $type, string $period, array $headings, Collection $rows, array $summary): array
    {
        return [
            'type' => $type,
            'title' => self::TYPES[$type],
            'period' => $period,
            'headings' => $headings,
            'rows' => $rows->values()->all(),
            'summary' => $summary,
        ];
    }

    private function income(string $from, string $to, string $period): array
    {
        $items = IncomeTransaction::with(['person', 'creator'])
            ->whereBetween('transaction_date', [$from, $to])
            ->orderBy('transaction_date')->get();

        return $this->base('income', $period,
            ['Tanggal', 'Orang', 'Kategori', 'Metode', 'Keterangan', 'Nominal'],
            $items->map(fn ($item) => [
                $item->transaction_date->format('d/m/Y'),
                $item->person->name,
                IncomeTransaction::CATEGORIES[$item->category] ?? $item->category,
                IncomeTransaction::PAYMENT_METHODS[$item->payment_method] ?? $item->payment_method,
                $item->description ?: '-',
                (float) $item->amount,
            ]),
            ['Total uang masuk' => (float) $items->sum('amount'), 'Jumlah transaksi' => $items->count()]
        );
    }

    private function expense(string $from, string $to, string $period): array
    {
        $items = ExpenseTransaction::with(['person', 'creator'])
            ->whereBetween('transaction_date', [$from, $to])
            ->orderBy('transaction_date')->get();

        return $this->base('expense', $period,
            ['Tanggal', 'Orang', 'Toko', 'Kategori', 'Metode', 'Keterangan', 'Nominal'],
            $items->map(fn ($item) => [
                $item->transaction_date->format('d/m/Y'),
                $item->person->name,
                $item->store_name ?: '-',
                ExpenseTransaction::CATEGORIES[$item->category] ?? $item->category,
                ExpenseTransaction::PAYMENT_METHODS[$item->payment_method] ?? $item->payment_method,
                $item->description ?: '-',
                (float) $item->amount,
            ]),
            ['Total uang keluar' => (float) $items->sum('amount'), 'Jumlah transaksi' => $items->count()]
        );
    }

    private function cash(string $from, string $to, string $period): array
    {
        $items = $this->cashService->mutations($from, $to);
        $debit = (float) $items->sum('debit');
        $credit = (float) $items->sum('credit');

        return $this->base('cash', $period,
            ['Tanggal', 'Jenis', 'Kategori', 'Keterangan', 'Orang', 'Debit', 'Kredit', 'Saldo'],
            $items->map(fn ($item) => [
                $item['date']->format('d/m/Y'),
                ucfirst($item['type']),
                $item['category'],
                $item['description'],
                $item['person'],
                $item['debit'],
                $item['credit'],
                $item['balance'],
            ]),
            ['Total masuk' => $debit, 'Total keluar' => $credit, 'Saldo akhir' => $debit - $credit]
        );
    }

    private function receipts(string $from, string $to, string $period): array
    {
        $items = ExpenseTransaction::with('person')
            ->whereNotNull('receipt_path')
            ->whereBetween('transaction_date', [$from, $to])
            ->orderBy('transaction_date')->get();

        return $this->base('receipts', $period,
            ['Tanggal', 'Orang', 'Toko', 'Kategori', 'Keterangan', 'Nominal'],
            $items->map(fn ($item) => [
                $item->transaction_date->format('d/m/Y'),
                $item->person->name,
                $item->store_name ?: '-',
                ExpenseTransaction::CATEGORIES[$item->category] ?? $item->category,
                $item->description ?: '-',
                (float) $item->amount,
            ]),
            ['Total nota' => (float) $items->sum('amount'), 'Jumlah nota' => $items->count()]
        );
    }

    private function inventory(string $from, string $to, string $period): array
    {
        $items = Inventory::with('person')
            ->whereBetween('purchase_date', [$from, $to])
            ->orderBy('purchase_date')->get();

        return $this->base('inventory', $period,
            ['Tanggal Beli', 'Nama Barang', 'Kategori', 'Jumlah', 'Harga Satuan', 'Nilai', 'Kondisi', 'Penanggung Jawab'],
            $items->map(fn ($item) => [
                $item->purchase_date->format('d/m/Y'),
                $item->name,
                Inventory::CATEGORIES[$item->category] ?? $item->category,
                $item->quantity,
                (float) $item->purchase_price,
                $item->total_value,
                Inventory::CONDITIONS[$item->condition] ?? $item->condition,
                $item->person->name,
            ]),
            ['Total nilai inventaris' => (float) $items->sum(fn ($item) => $item->total_value), 'Jumlah jenis barang' => $items->count()]
        );
    }
}
