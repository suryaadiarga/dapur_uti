<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseTransactionRequest;
use App\Models\ExpenseTransaction;
use App\Models\Person;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseTransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = ExpenseTransaction::with(['person', 'creator'])
            ->visibleTo($request->user())
            ->filter($request->only('date_from', 'date_to', 'category', 'person_id', 'store_name', 'search'))
            ->latest('transaction_date')->latest('id')->paginate(15)->withQueryString();

        return view('expense.index', ['transactions' => $transactions, 'people' => $this->people($request)]);
    }

    public function create()
    {
        return view('expense.form', ['transaction' => new ExpenseTransaction, 'people' => $this->people(request())]);
    }

    public function store(ExpenseTransactionRequest $request)
    {
        $data = $request->safe()->except('receipt');
        $data['created_by'] = $request->user()->id;
        $data['user_id'] = $request->user()->id;
        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')->store('expense-receipts', 'public');
        }
        $expense = ExpenseTransaction::create($data);
        ActivityLogger::log('create', $expense, null, $expense->only([
            'transaction_date', 'people_id', 'category', 'amount', 'payment_method',
            'store_name', 'description', 'created_by', 'user_id',
        ]));

        return redirect()->route('expense.index')->with('success', 'Uang keluar berhasil dicatat.');
    }

    public function show(ExpenseTransaction $expense)
    {
        abort_unless($expense->isVisibleTo(request()->user()), 403);
        $expense->load(['person', 'creator']);

        return view('expense.show', ['transaction' => $expense]);
    }

    public function edit(ExpenseTransaction $expense)
    {
        abort_unless($expense->isVisibleTo(request()->user()), 403);

        return view('expense.form', ['transaction' => $expense, 'people' => $this->people(request())]);
    }

    public function update(ExpenseTransactionRequest $request, ExpenseTransaction $expense)
    {
        abort_unless($expense->isVisibleTo($request->user()), 403);
        $oldValues = $expense->only([
            'transaction_date', 'people_id', 'category', 'amount', 'payment_method',
            'store_name', 'description', 'created_by', 'user_id',
        ]);
        $data = $request->safe()->except('receipt');
        if ($request->hasFile('receipt')) {
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }
            $data['receipt_path'] = $request->file('receipt')->store('expense-receipts', 'public');
        }
        $expense->update($data);
        ActivityLogger::log('update', $expense, $oldValues, $expense->fresh()->only(array_keys($oldValues)));

        return redirect()->route('expense.index')->with('success', 'Uang keluar berhasil diperbarui.');
    }

    public function destroy(ExpenseTransaction $expense)
    {
        abort_unless($expense->isVisibleTo(request()->user()), 403);
        $oldValues = $expense->only([
            'transaction_date', 'people_id', 'category', 'amount', 'payment_method',
            'store_name', 'description', 'created_by', 'user_id',
        ]);
        $expense->delete();
        ActivityLogger::log('delete', $expense, $oldValues);

        return redirect()->route('expense.index')->with('success', 'Uang keluar berhasil dihapus.');
    }

    public function download(ExpenseTransaction $expense)
    {
        abort_unless($expense->isVisibleTo(request()->user()), 403);
        abort_unless($expense->receipt_path && Storage::disk('public')->exists($expense->receipt_path), 404);

        return Storage::disk('public')->download($expense->receipt_path);
    }

    private function people(Request $request)
    {
        return Person::query()->visibleTo($request->user())->orderBy('name')->get();
    }
}
