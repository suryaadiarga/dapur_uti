<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Models\Person;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $people = Person::query()
            ->with('user')
            ->visibleTo($request->user())
            ->when($request->role, fn ($q, $role) => $q->where('role', $role))
            ->when(
                $request->user()->isAdmin() && $request->filled('user_id'),
                fn ($q) => $request->user_id === 'unassigned'
                    ? $q->whereNull('user_id')
                    : $q->where('user_id', $request->user_id),
            )
            ->when($request->search, fn ($q, $search) => $q->where(function ($nested) use ($search): void {
                $nested->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($userQuery) => $userQuery
                        ->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"));
            }))
            ->orderBy('name')->paginate(15)->withQueryString();

        return view('people.index', compact('people') + ['users' => $this->usersForAdmin($request)]);
    }

    public function create()
    {
        return view('people.form', [
            'person' => new Person,
            'users' => $this->usersForAdmin(request()),
        ]);
    }

    public function store(PersonRequest $request)
    {
        $data = $request->safe()->except('user_id');
        $data['user_id'] = $request->user()->isAdmin()
            ? $request->validated('user_id')
            : $request->user()->id;

        $person = Person::create($data);
        ActivityLogger::log('create', $person, null, $person->only(['name', 'phone', 'role', 'notes', 'user_id']));

        if ($request->user()->isAdmin() && $person->user_id) {
            ActivityLogger::log(
                'assign_people_to_user',
                $person,
                ['user_id' => null],
                ['user_id' => $person->user_id],
            );
        }

        return redirect()->route('people.index')->with('success', 'Data orang berhasil ditambahkan.');
    }

    public function show(Person $person)
    {
        abort_unless($person->isVisibleTo(request()->user()), 403);
        $person->load('user')->loadCount(['incomeTransactions', 'expenseTransactions', 'inventories']);

        return view('people.show', compact('person'));
    }

    public function edit(Person $person)
    {
        abort_unless($person->isVisibleTo(request()->user()), 403);

        return view('people.form', compact('person') + ['users' => $this->usersForAdmin(request())]);
    }

    public function update(PersonRequest $request, Person $person)
    {
        abort_unless($person->isVisibleTo($request->user()), 403);
        $oldValues = $person->only(['name', 'phone', 'role', 'notes', 'user_id']);
        $data = $request->safe()->except('user_id');

        if ($request->user()->isAdmin()) {
            $data['user_id'] = $request->validated('user_id');
        }

        $person->update($data);
        ActivityLogger::log('update', $person, $oldValues, $person->fresh()->only(['name', 'phone', 'role', 'notes', 'user_id']));

        if ((int) $oldValues['user_id'] !== (int) $person->user_id) {
            ActivityLogger::log(
                $oldValues['user_id'] === null && $person->user_id !== null
                    ? 'assign_people_to_user'
                    : 'change_people_user',
                $person,
                ['user_id' => $oldValues['user_id']],
                ['user_id' => $person->user_id],
            );
        }

        return redirect()->route('people.index')->with('success', 'Data orang berhasil diperbarui.');
    }

    public function destroy(Person $person)
    {
        abort_unless($person->isVisibleTo(request()->user()), 403);

        if ($person->incomeTransactions()->exists() || $person->expenseTransactions()->exists() || $person->inventories()->exists()) {
            return back()->with('error', 'Data orang tidak dapat dihapus karena masih digunakan.');
        }

        $oldValues = $person->only(['name', 'phone', 'role', 'notes', 'user_id']);
        $person->delete();
        ActivityLogger::log('delete', $person, $oldValues);

        return redirect()->route('people.index')->with('success', 'Data orang berhasil dihapus.');
    }

    private function usersForAdmin(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return collect();
        }

        return User::query()
            ->orderByRaw('disabled_at IS NOT NULL')
            ->orderBy('username')
            ->get(['id', 'username', 'name', 'email', 'disabled_at']);
    }
}
