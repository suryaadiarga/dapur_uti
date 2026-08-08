<x-app-layout>
    <x-slot name="title">Manajemen User - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="page-title">Manajemen User</h1>
            <p class="page-subtitle">Kelola akun admin dan staff.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary">+ Tambah User</a>
    </div>

    <div class="panel mb-5 panel-body">
        <form method="GET" class="grid gap-3 sm:grid-cols-4">
            <div>
                <label class="form-label">Pencarian</label>
                <input name="search" value="{{ request('search') }}" class="form-control mt-1" placeholder="Nama, username, atau email">
            </div>
            <div>
                <label class="form-label">Role</label>
                <select name="role" class="form-control mt-1">
                    <option value="">Semua role</option>
                    <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                    <option value="staff" @selected(request('role') === 'staff')>Staff</option>
                </select>
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-control mt-1">
                    <option value="">Semua status</option>
                    <option value="active" @selected(request('status') === 'active')>Aktif</option>
                    <option value="disabled" @selected(request('status') === 'disabled')>Nonaktif</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button class="btn-primary">Filter</button>
                <a href="{{ route('users.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>People</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="font-medium text-stone-900">{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="{{ $user->isAdmin() ? 'badge-green' : 'badge-brown' }}">{{ ucfirst($user->role) }}</span></td>
                        <td><span class="{{ $user->isActive() ? 'badge-green' : 'badge-red' }}">{{ $user->isActive() ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>{{ $user->people_count }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('users.edit', $user) }}" class="btn-secondary !px-3 !py-2">Edit</a>
                                @if($user->isDisabled())
                                    <form method="POST" action="{{ route('users.enable', $user) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn-secondary !px-3 !py-2">Aktifkan</button>
                                    </form>
                                    @if(($user->people_count + $user->inventories_count + $user->income_transactions_count + $user->expense_transactions_count) === 0)
                                        <form method="POST" action="{{ route('users.permanent-destroy', $user) }}" onsubmit="return confirm('Hapus akun ini secara permanen? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf @method('DELETE')
                                            <button class="btn-danger">Hapus Permanen</button>
                                        </form>
                                    @endif
                                @elseif(! auth()->user()->is($user))
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Nonaktifkan akun ini? Data milik akun tidak akan dihapus.')">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger">Nonaktifkan</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-center text-stone-500">Belum ada user.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())<div class="border-t border-stone-200 p-4">{{ $users->links() }}</div>@endif
    </div>
</x-app-layout>
