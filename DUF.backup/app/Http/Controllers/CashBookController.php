<?php

namespace App\Http\Controllers;

use App\Services\CashService;

class CashBookController extends Controller
{
    public function __invoke(CashService $cashService)
    {
        $mutations = $cashService->mutations(user: request()->user());
        $totalIncome = (float) $mutations->sum('debit');
        $totalExpense = (float) $mutations->sum('credit');

        return view('cash.index', [
            'mutations' => $mutations->reverse()->values(),
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
        ]);
    }
}
