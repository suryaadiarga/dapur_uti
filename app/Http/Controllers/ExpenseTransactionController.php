<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseTransactionRequest;
use App\Models\ExpenseTransaction;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseTransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = ExpenseTransaction::with(['person', 'creator'])
            ->filter($request->only('date_from', 'date_to', 'category', 'person_id', 'store_name', 'search'))
            ->latest('transaction_date')->latest('id')->paginate(15)->withQueryString();

        return view('expense.index', ['transactions' => $transactions, 'people' => Person::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('expense.form', ['transaction' => new ExpenseTransaction, 'people' => Person::orderBy('name')->get()]);
    }

    public function store(ExpenseTransactionRequest $request)
    {
        $data = $request->safe()->except('receipt');
        $data['created_by'] = $request->user()->id;
        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')->store('expense-receipts', 'public');
        }
        ExpenseTransaction::create($data);

        return redirect()->route('expense.index')->with('success', 'Uang keluar berhasil dicatat.');
    }

    public function show(ExpenseTransaction $expense)
    {
        $expense->load(['person', 'creator']);

        return view('expense.show', ['transaction' => $expense]);
    }

    public function edit(ExpenseTransaction $expense)
    {
        return view('expense.form', ['transaction' => $expense, 'people' => Person::orderBy('name')->get()]);
    }

    public function update(ExpenseTransactionRequest $request, ExpenseTransaction $expense)
    {
        $data = $request->safe()->except('receipt');
        if ($request->hasFile('receipt')) {
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }
            $data['receipt_path'] = $request->file('receipt')->store('expense-receipts', 'public');
        }
        $expense->update($data);

        return redirect()->route('expense.index')->with('success', 'Uang keluar berhasil diperbarui.');
    }

    public function destroy(ExpenseTransaction $expense)
    {
        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Uang keluar berhasil dihapus.');
    }

    public function download(ExpenseTransaction $expense)
    {
        abort_unless($expense->receipt_path && Storage::disk('public')->exists($expense->receipt_path), 404);

        return Storage::disk('public')->download($expense->receipt_path);
    }
}
