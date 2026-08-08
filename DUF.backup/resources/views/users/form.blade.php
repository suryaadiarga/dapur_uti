<x-app-layout>
    <x-slot name="title">{{ $user->exists ? 'Edit' : 'Tambah' }} User - Dapur Uti Finance</x-slot>
    <div class="mb-6">
        <a href="{{ route('users.index') }}" class="text-sm font-medium text-emerald-700">&larr; Kembali</a>
        <h1 class="page-title mt-3">{{ $user->exists ? 'Edit User' : 'Tambah User' }}</h1>
        @if($user->exists && $user->isDisabled())
            <p class="mt-2 text-sm font-medium text-red-700">Akun ini sedang nonaktif.</p>
        @endif
    </div>

    <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" class="panel panel-body max-w-3xl">
        @csrf
        @if($user->exists) @method('PUT') @endif
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="form-label">Nama <span class="text-red-500">*</span></label>
                <input name="name" value="{{ old('name', $user->name) }}" class="form-control mt-1" required>
            </div>
            <div>
                <label class="form-label">Username <span class="text-red-500">*</span></label>
                <input name="username" value="{{ old('username', $user->username) }}" class="form-control mt-1" required autocomplete="off">
            </div>
            <div>
                <label class="form-label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control mt-1" required>
            </div>
            <div>
                <label class="form-label">Role <span class="text-red-500">*</span></label>
                <select name="role" class="form-control mt-1" required>
                    <option value="staff" @selected(old('role', $user->role ?? 'staff') === 'staff')>Staff</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
            </div>
            @unless($user->exists)
                <div></div>
                <div>
                    <label class="form-label">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" class="form-control mt-1" required autocomplete="new-password">
                </div>
                <div>
                    <label class="form-label">Konfirmasi password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control mt-1" required autocomplete="new-password">
                </div>
            @endunless
        </div>
        <div class="mt-6 flex gap-3">
            <button class="btn-primary">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>

    @if($user->exists)
        <form method="POST" action="{{ route('users.password', $user) }}" class="panel panel-body mt-6 max-w-3xl">
            @csrf @method('PUT')
            <h2 class="text-lg font-semibold text-stone-900">Reset Password</h2>
            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="form-label">Password baru</label>
                    <input type="password" name="password" class="form-control mt-1" required autocomplete="new-password">
                </div>
                <div>
                    <label class="form-label">Konfirmasi password</label>
                    <input type="password" name="password_confirmation" class="form-control mt-1" required autocomplete="new-password">
                </div>
            </div>
            <button class="btn-primary mt-5">Reset Password</button>
        </form>
    @endif
</x-app-layout>
