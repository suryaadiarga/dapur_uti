<x-app-layout>
    <x-slot name="title">{{ $person->exists ? 'Edit' : 'Tambah' }} Orang - Dapur Uti Finance</x-slot>
    <div class="mb-6">
        <a href="{{ route('people.index') }}" class="text-sm font-medium text-emerald-700">← Kembali</a>
        <h1 class="page-title mt-3">{{ $person->exists ? 'Edit Data Orang' : 'Tambah Data Orang' }}</h1>
    </div>

    <form method="POST" action="{{ $person->exists ? route('people.update', $person) : route('people.store') }}" class="panel panel-body max-w-3xl">
        @csrf
        @if($person->exists) @method('PUT') @endif
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="form-label">Nama <span class="text-red-500">*</span></label>
                <input name="name" value="{{ old('name', $person->name) }}" class="form-control mt-1" required>
            </div>
            <div>
                <label class="form-label">Nomor HP</label>
                <input name="phone" value="{{ old('phone', $person->phone) }}" class="form-control mt-1" placeholder="08...">
            </div>
            <div>
                <label class="form-label">Peran <span class="text-red-500">*</span></label>
                <select name="role" class="form-control mt-1" required>
                    <option value="">Pilih peran</option>
                    @foreach(\App\Models\Person::ROLES as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', $person->role) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @if(auth()->user()->isAdmin())
                <div class="sm:col-span-2">
                    <label class="form-label">Account User</label>
                    <select name="user_id" class="form-control mt-1">
                        <option value="">Tanpa account</option>
                        @foreach($users as $account)
                            <option value="{{ $account->id }}" @selected((string) old('user_id', $person->user_id) === (string) $account->id)>
                                {{ $account->username }} - {{ $account->name }} - {{ $account->email }}{{ $account->isDisabled() ? ' (nonaktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="sm:col-span-2">
                <label class="form-label">Catatan</label>
                <textarea name="notes" rows="4" class="form-control mt-1">{{ old('notes', $person->notes) }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button class="btn-primary">Simpan</button>
            <a href="{{ route('people.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</x-app-layout>
