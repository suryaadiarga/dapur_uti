<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $people = Person::query()
            ->when($request->role, fn ($q, $role) => $q->where('role', $role))
            ->when($request->search, fn ($q, $search) => $q->where(fn ($nested) => $nested->where('name', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%")))
            ->orderBy('name')->paginate(15)->withQueryString();

        return view('people.index', compact('people'));
    }

    public function create()
    {
        return view('people.form', ['person' => new Person]);
    }

    public function store(PersonRequest $request)
    {
        Person::create($request->validated());

        return redirect()->route('people.index')->with('success', 'Data orang berhasil ditambahkan.');
    }

    public function show(Person $person)
    {
        $person->loadCount(['incomeTransactions', 'expenseTransactions', 'inventories']);

        return view('people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        return view('people.form', compact('person'));
    }

    public function update(PersonRequest $request, Person $person)
    {
        $person->update($request->validated());

        return redirect()->route('people.index')->with('success', 'Data orang berhasil diperbarui.');
    }

    public function destroy(Person $person)
    {
        if ($person->incomeTransactions()->exists() || $person->expenseTransactions()->exists() || $person->inventories()->exists()) {
            return back()->with('error', 'Data orang tidak dapat dihapus karena masih digunakan.');
        }

        $person->delete();

        return redirect()->route('people.index')->with('success', 'Data orang berhasil dihapus.');
    }
}
