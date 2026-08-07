<?php

namespace App\Services;

use App\Models\ExpenseTransaction;
use App\Models\IncomeTransaction;
use Illuminate\Support\Collection;

class CashService
{
    public function mutations(?string $dateFrom = null, ?string $dateTo = null): Collection
    {
        $income = IncomeTransaction::query()
            ->with('person')
            ->when($dateFrom, fn ($query) => $query->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->whereDate('transaction_date', '<=', $dateTo))
            ->get()
            ->map(fn (IncomeTransaction $item) => [
                'id' => $item->id,
                'date' => $item->transaction_date,
                'type' => 'masuk',
                'category' => IncomeTransaction::CATEGORIES[$item->category] ?? $item->category,
                'description' => $item->description ?: '-',
                'person' => $item->person->name,
                'debit' => (float) $item->amount,
                'credit' => 0.0,
                'created_at' => $item->created_at,
            ]);

        $expense = ExpenseTransaction::query()
            ->with('person')
            ->when($dateFrom, fn ($query) => $query->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->whereDate('transaction_date', '<=', $dateTo))
            ->get()
            ->map(fn (ExpenseTransaction $item) => [
                'id' => $item->id,
                'date' => $item->transaction_date,
                'type' => 'keluar',
                'category' => ExpenseTransaction::CATEGORIES[$item->category] ?? $item->category,
                'description' => $item->description ?: ($item->store_name ?: '-'),
                'person' => $item->person->name,
                'debit' => 0.0,
                'credit' => (float) $item->amount,
                'created_at' => $item->created_at,
            ]);

        $balance = 0.0;

        return $income->concat($expense)
            ->sortBy(fn (array $item) => $item['date']->format('Y-m-d').' '.$item['created_at']->format('H:i:s').' '.str_pad((string) $item['id'], 10, '0', STR_PAD_LEFT))
            ->values()
            ->map(function (array $item) use (&$balance) {
                $balance += $item['debit'] - $item['credit'];
                $item['balance'] = $balance;

                return $item;
            });
    }
}
