<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeTransactionRequest;
use App\Models\IncomeTransaction;
use App\Models\Person;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomeTransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = IncomeTransaction::with(['person', 'creator'])
            ->visibleTo($request->user())
            ->filter($request->only('date_from', 'date_to', 'category', 'person_id', 'search'))
            ->latest('transaction_date')->latest('id')->paginate(15)->withQueryString();

        return view('income.index', ['transactions' => $transactions, 'people' => $this->people($request)]);
    }

    public function create()
    {
        return view('income.form', ['transaction' => new IncomeTransaction, 'people' => $this->people(request())]);
    }

    public function store(IncomeTransactionRequest $request)
    {
        $data = $request->safe()->except('proof');
        $data['created_by'] = $request->user()->id;
        $data['user_id'] = $request->user()->id;
        if ($request->hasFile('proof')) {
            $data['proof_path'] = $request->file('proof')->store('income-proofs', 'public');
        }
        $income = IncomeTransaction::create($data);
        ActivityLogger::log('create', $income, null, $income->only([
            'transaction_date', 'people_id', 'category', 'amount', 'payment_method',
            'description', 'created_by', 'user_id',
        ]));

        return redirect()->route('income.index')->with('success', 'Uang masuk berhasil dicatat.');
    }

    public function show(IncomeTransaction $income)
    {
        abort_unless($income->isVisibleTo(request()->user()), 403);
        $income->load(['person', 'creator']);

        return view('income.show', ['transaction' => $income]);
    }

    public function edit(IncomeTransaction $income)
    {
        abort_unless($income->isVisibleTo(request()->user()), 403);

        return view('income.form', ['transaction' => $income, 'people' => $this->people(request())]);
    }

    public function update(IncomeTransactionRequest $request, IncomeTransaction $income)
    {
        abort_unless($income->isVisibleTo($request->user()), 403);
        $oldValues = $income->only([
            'transaction_date', 'people_id', 'category', 'amount', 'payment_method',
            'description', 'created_by', 'user_id',
        ]);
        $data = $request->safe()->except('proof');
        if ($request->hasFile('proof')) {
            if ($income->proof_path) {
                Storage::disk('public')->delete($income->proof_path);
            }
            $data['proof_path'] = $request->file('proof')->store('income-proofs', 'public');
        }
        $income->update($data);
        ActivityLogger::log('update', $income, $oldValues, $income->fresh()->only(array_keys($oldValues)));

        return redirect()->route('income.index')->with('success', 'Uang masuk berhasil diperbarui.');
    }

    public function destroy(IncomeTransaction $income)
    {
        abort_unless($income->isVisibleTo(request()->user()), 403);
        $oldValues = $income->only([
            'transaction_date', 'people_id', 'category', 'amount', 'payment_method',
            'description', 'created_by', 'user_id',
        ]);
        $income->delete();
        ActivityLogger::log('delete', $income, $oldValues);

        return redirect()->route('income.index')->with('success', 'Uang masuk berhasil dihapus.');
    }

    public function download(IncomeTransaction $income)
    {
        abort_unless($income->isVisibleTo(request()->user()), 403);
        abort_unless($income->proof_path && Storage::disk('public')->exists($income->proof_path), 404);

        return Storage::disk('public')->download($income->proof_path);
    }

    private function people(Request $request)
    {
        return Person::query()->visibleTo($request->user())->orderBy('name')->get();
    }
}
