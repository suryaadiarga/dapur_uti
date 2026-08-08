<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->select('users.*')
            ->selectSub(
                DB::table('people')->selectRaw('COUNT(*)')->whereColumn('people.user_id', 'users.id'),
                'people_count',
            )
            ->selectSub(
                DB::table('inventories')->selectRaw('COUNT(*)')->whereColumn('inventories.user_id', 'users.id'),
                'inventories_count',
            )
            ->selectSub(
                DB::table('income_transactions')
                    ->selectRaw('COUNT(*)')
                    ->where(fn ($query) => $query
                        ->whereColumn('income_transactions.user_id', 'users.id')
                        ->orWhereColumn('income_transactions.created_by', 'users.id')),
                'income_transactions_count',
            )
            ->selectSub(
                DB::table('expense_transactions')
                    ->selectRaw('COUNT(*)')
                    ->where(fn ($query) => $query
                        ->whereColumn('expense_transactions.user_id', 'users.id')
                        ->orWhereColumn('expense_transactions.created_by', 'users.id')),
                'expense_transactions_count',
            )
            ->when($request->search, function ($query, string $search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->role, fn ($query, string $role) => $query->where('role', $role))
            ->when($request->status === 'active', fn ($query) => $query->whereNull('disabled_at'))
            ->when($request->status === 'disabled', fn ($query) => $query->whereNotNull('disabled_at'))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.form', ['user' => new User]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request);
        $validated['password'] = Hash::make($validated['password']);
        unset($validated['password_confirmation']);

        $user = User::create($validated);
        ActivityLogger::log('create_user', $user, null, $user->only(['name', 'username', 'email', 'role']));

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user): View
    {
        return view('users.form', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $this->validateUser($request, $user);

        if (
            $user->isAdmin()
            && $user->isActive()
            && $validated['role'] !== 'admin'
            && User::where('role', 'admin')->whereNull('disabled_at')->count() <= 1
        ) {
            return back()->withInput()->with('error', 'Minimal satu akun admin harus tetap aktif.');
        }

        $oldValues = $user->only(['name', 'username', 'email', 'role']);
        $roleChanged = $oldValues['role'] !== $validated['role'];
        unset($validated['password'], $validated['password_confirmation']);
        $user->update($validated);

        ActivityLogger::log('update_user', $user, $oldValues, $user->fresh()->only(array_keys($oldValues)));

        if ($roleChanged) {
            ActivityLogger::log('change_role', $user, ['role' => $oldValues['role']], ['role' => $user->role]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(12)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        $user->update(['password' => Hash::make($validated['password'])]);
        ActivityLogger::log('reset_password', $user, description: 'Password user was reset by an administrator.');

        return back()->with('success', 'Password user berhasil direset.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dinonaktifkan.');
        }

        if (
            $user->isAdmin()
            && $user->isActive()
            && User::where('role', 'admin')->whereNull('disabled_at')->count() <= 1
        ) {
            return back()->with('error', 'Minimal satu akun admin harus tetap aktif.');
        }

        if ($user->isDisabled()) {
            return back()->with('error', 'Akun sudah dinonaktifkan.');
        }

        $user->update(['disabled_at' => now()]);
        ActivityLogger::log(
            'disable_user',
            $user,
            ['disabled_at' => null],
            ['disabled_at' => $user->disabled_at?->toISOString()],
        );

        return redirect()->route('users.index')->with('success', 'User berhasil dinonaktifkan.');
    }

    public function enable(User $user): RedirectResponse
    {
        if ($user->isActive()) {
            return back()->with('error', 'Akun sudah aktif.');
        }

        $oldDisabledAt = $user->disabled_at?->toISOString();
        $user->update(['disabled_at' => null]);
        ActivityLogger::log(
            'enable_user',
            $user,
            ['disabled_at' => $oldDisabledAt],
            ['disabled_at' => null],
        );

        return redirect()->route('users.index')->with('success', 'User berhasil diaktifkan.');
    }

    public function permanentDestroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        if ($user->isActive()) {
            return back()->with('error', 'Nonaktifkan akun sebelum menghapusnya secara permanen.');
        }

        if (
            $user->isAdmin()
            && User::where('role', 'admin')->whereNull('disabled_at')->count() <= 1
        ) {
            return back()->with('error', 'Minimal satu akun admin harus tetap aktif.');
        }

        $relatedData = $this->relatedDataCounts($user);

        if (array_sum($relatedData) > 0) {
            return back()->with('error', sprintf(
                'Akun tidak dapat dihapus karena masih memiliki data: people %d, inventaris %d, pemasukan %d, pengeluaran %d.',
                $relatedData['people'],
                $relatedData['inventories'],
                $relatedData['income'],
                $relatedData['expense'],
            ));
        }

        $oldValues = $user->only(['id', 'name', 'username', 'email', 'role', 'disabled_at']);

        DB::transaction(function () use ($user, $oldValues): void {
            DB::table('sessions')->where('user_id', $user->id)->delete();
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            ActivityLogger::log('delete_user', $user, $oldValues, description: 'User account permanently deleted.');
            $user->delete();
        });

        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus permanen.');
    }

    private function relatedDataCounts(User $user): array
    {
        return [
            'people' => DB::table('people')->where('user_id', $user->id)->count(),
            'inventories' => DB::table('inventories')->where('user_id', $user->id)->count(),
            'income' => DB::table('income_transactions')
                ->where(fn ($query) => $query
                    ->where('user_id', $user->id)
                    ->orWhere('created_by', $user->id))
                ->count(),
            'expense' => DB::table('expense_transactions')
                ->where(fn ($query) => $query
                    ->where('user_id', $user->id)
                    ->orWhere('created_by', $user->id))
                ->count(),
        ];
    }

    private function validateUser(Request $request, ?User $user = null): array
    {
        $request->merge([
            'username' => Str::lower((string) $request->input('username')),
            'email' => Str::lower((string) $request->input('email')),
        ]);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user?->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'role' => ['required', Rule::in(['admin', 'staff'])],
            'password' => [
                $user ? 'nullable' : 'required',
                'confirmed',
                Password::min(12)->letters()->mixedCase()->numbers()->symbols(),
            ],
        ]);
    }
}
