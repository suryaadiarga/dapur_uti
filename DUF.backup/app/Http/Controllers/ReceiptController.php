<?php

namespace App\Http\Controllers;

use App\Models\ExpenseTransaction;
use App\Models\Person;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $receipts = ExpenseTransaction::with('person')
            ->visibleTo($request->user())
            ->whereNotNull('receipt_path')
            ->when($request->month, function ($query, $month) {
                [$year, $number] = array_pad(explode('-', $month), 2, null);
                $query->when($year && $number, fn ($q) => $q->whereYear('transaction_date', $year)->whereMonth('transaction_date', $number));
            })
            ->filter($request->only('person_id', 'store_name', 'category'))
            ->latest('transaction_date')->latest('id')->paginate(15)->withQueryString();

        $people = Person::query()->visibleTo($request->user())->orderBy('name')->get();

        return view('receipts.index', compact('receipts', 'people'));
    }
}
