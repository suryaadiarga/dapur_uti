<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeTransactionRequest;
use App\Models\IncomeTransaction;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomeTransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = IncomeTransaction::with(['person', 'creator'])
            ->filter($request->only('date_from', 'date_to', 'category', 'person_id', 'search'))
            ->latest('transaction_date')->latest('id')->paginate(15)->withQueryString();

        return view('income.index', ['transactions' => $transactions, 'people' => Person::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('income.form', ['transaction' => new IncomeTransaction, 'people' => Person::orderBy('name')->get()]);
    }

    public function store(IncomeTransactionRequest $request)
    {
        $data = $request->safe()->except('proof');
        $data['created_by'] = $request->user()->id;
        if ($request->hasFile('proof')) {
            $data['proof_path'] = $request->file('proof')->store('income-proofs', 'public');
        }
        IncomeTransaction::create($data);

        return redirect()->route('income.index')->with('success', 'Uang masuk berhasil dicatat.');
    }

    public function show(IncomeTransaction $income)
    {
        $income->load(['person', 'creator']);

        return view('income.show', ['transaction' => $income]);
    }

    public function edit(IncomeTransaction $income)
    {
        return view('income.form', ['transaction' => $income, 'people' => Person::orderBy('name')->get()]);
    }

    public function update(IncomeTransactionRequest $request, IncomeTransaction $income)
    {
        $data = $request->safe()->except('proof');
        if ($request->hasFile('proof')) {
            if ($income->proof_path) {
                Storage::disk('public')->delete($income->proof_path);
            }
            $data['proof_path'] = $request->file('proof')->store('income-proofs', 'public');
        }
        $income->update($data);

        return redirect()->route('income.index')->with('success', 'Uang masuk berhasil diperbarui.');
    }

    public function destroy(IncomeTransaction $income)
    {
        if ($income->proof_path) {
            Storage::disk('public')->delete($income->proof_path);
        }
        $income->delete();

        return redirect()->route('income.index')->with('success', 'Uang masuk berhasil dihapus.');
    }

    public function download(IncomeTransaction $income)
    {
        abort_unless($income->proof_path && Storage::disk('public')->exists($income->proof_path), 404);

        return Storage::disk('public')->download($income->proof_path);
    }
}
