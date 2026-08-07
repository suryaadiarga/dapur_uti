<x-app-layout>
    <x-slot name="title">Data Orang - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="page-title">Data Orang</h1>
            <p class="page-subtitle">Orang yang terlibat dalam transaksi dan inventaris.</p>
        </div>
        <a href="{{ route('people.create') }}" class="btn-primary">+ Tambah Orang</a>
    </div>

    <div class="panel mb-5 panel-body">
        <form method="GET" class="filter-grid">
            <div class="lg:col-span-2">
                <label class="form-label">Pencarian</label>
                <input name="search" value="{{ request('search') }}" class="form-control mt-1" placeholder="Nama atau nomor HP">
            </div>
            <div>
                <label class="form-label">Peran</label>
                <select name="role" class="form-control mt-1">
                    <option value="">Semua peran</option>
                    @foreach(\App\Models\Person::ROLES as $value => $label)
                        <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button class="btn-primary">Filter</button>
                <a href="{{ route('people.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nama</th><th>Nomor HP</th><th>Peran</th><th>Catatan</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse($people as $person)
                    <tr>
                        <td class="font-medium text-stone-900">{{ $person->name }}</td>
                        <td>{{ $person->phone ?: '-' }}</td>
                        <td><span class="badge-brown">{{ \App\Models\Person::ROLES[$person->role] ?? $person->role }}</span></td>
                        <td class="max-w-xs truncate">{{ $person->notes ?: '-' }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('people.show', $person) }}" class="btn-secondary !px-3 !py-2">Detail</a>
                                <a href="{{ route('people.edit', $person) }}" class="btn-secondary !px-3 !py-2">Edit</a>
                                <form method="POST" action="{{ route('people.destroy', $person) }}" onsubmit="return confirm('Hapus data orang ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-10 text-center text-stone-500">Belum ada data orang.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($people->hasPages())<div class="border-t border-stone-200 p-4">{{ $people->links() }}</div>@endif
    </div>
</x-app-layout>
