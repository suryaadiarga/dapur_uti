<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTransaction;
use App\Models\IncomeTransaction;
use App\Models\Inventory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $start = now()->startOfMonth()->toDateString();
        $end = now()->endOfMonth()->toDateString();

        $incomeMonth = IncomeTransaction::whereBetween('transaction_date', [$start, $end]);
        $expenseMonth = ExpenseTransaction::whereBetween('transaction_date', [$start, $end]);
        $totalIncome = (float) IncomeTransaction::sum('amount');
        $totalExpense = (float) ExpenseTransaction::sum('amount');

        $latestIncome = IncomeTransaction::with('person')->latest('transaction_date')->latest('id')->limit(5)->get()
            ->map(fn ($item) => ['date' => $item->transaction_date, 'type' => 'masuk', 'category' => IncomeTransaction::CATEGORIES[$item->category], 'person' => $item->person->name, 'amount' => (float) $item->amount, 'id' => $item->id]);
        $latestExpense = ExpenseTransaction::with('person')->latest('transaction_date')->latest('id')->limit(5)->get()
            ->map(fn ($item) => ['date' => $item->transaction_date, 'type' => 'keluar', 'category' => ExpenseTransaction::CATEGORIES[$item->category], 'person' => $item->person->name, 'amount' => (float) $item->amount, 'id' => $item->id]);

        $months = collect(range(5, 0))->map(fn ($offset) => now()->copy()->subMonths($offset)->startOfMonth())->push(now()->startOfMonth());
        $chart = $months->map(function (Carbon $month) {
            $from = $month->copy()->startOfMonth()->toDateString();
            $to = $month->copy()->endOfMonth()->toDateString();

            return [
                'label' => $month->translatedFormat('M Y'),
                'income' => (float) IncomeTransaction::whereBetween('transaction_date', [$from, $to])->sum('amount'),
                'expense' => (float) ExpenseTransaction::whereBetween('transaction_date', [$from, $to])->sum('amount'),
            ];
        });

        return view('dashboard', [
            'incomeThisMonth' => (float) (clone $incomeMonth)->sum('amount'),
            'expenseThisMonth' => (float) (clone $expenseMonth)->sum('amount'),
            'incomeCount' => (clone $incomeMonth)->count(),
            'expenseCount' => (clone $expenseMonth)->count(),
            'cashBalance' => $totalIncome - $totalExpense,
            'inventoryValue' => (float) Inventory::selectRaw('COALESCE(SUM(purchase_price * quantity), 0) as total')->value('total'),
            'latestTransactions' => $latestIncome->concat($latestExpense)->sortByDesc(fn ($item) => $item['date']->format('Y-m-d').str_pad($item['id'], 10, '0', STR_PAD_LEFT))->take(5),
            'chart' => $chart,
            'chartMax' => max(1, (float) $chart->max(fn ($item) => max($item['income'], $item['expense']))),
        ]);
    }
}
