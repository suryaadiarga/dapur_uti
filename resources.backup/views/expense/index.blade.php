<x-app-layout>
    <x-slot name="title">Uang Keluar - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div><h1 class="page-title">Uang Keluar</h1><p class="page-subtitle">Catat seluruh pengeluaran Dapur Uti.</p></div>
        <a href="{{ route('expense.create') }}" class="btn-primary">+ Tambah Uang Keluar</a>
    </div>
    <div class="panel mb-5 panel-body">
        <form method="GET" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7">
            <div><label class="form-label">Dari tanggal</label><input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control mt-1"></div>
            <div><label class="form-label">Sampai tanggal</label><input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control mt-1"></div>
            <div><label class="form-label">Kategori</label><select name="category" class="form-control mt-1"><option value="">Semua</option>@foreach(\App\Models\ExpenseTransaction::CATEGORIES as $value => $label)<option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Orang</label><select name="person_id" class="form-control mt-1"><option value="">Semua</option>@foreach($people as $person)<option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>@endforeach</select></div>
            <div><label class="form-label">Toko</label><input name="store_name" value="{{ request('store_name') }}" class="form-control mt-1" placeholder="Nama toko"></div>
            <div><label class="form-label">Pencarian</label><input name="search" value="{{ request('search') }}" class="form-control mt-1" placeholder="Keterangan"></div>
            <div class="flex items-end gap-2"><button class="btn-primary">Filter</button><a href="{{ route('expense.index') }}" class="btn-secondary">Reset</a></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Tanggal</th><th>Orang</th><th>Toko</th><th>Kategori</th><th>Metode</th><th>Nominal</th><th>Nota</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse($transactions as $item)
                    <tr>
                        <td class="whitespace-nowrap">{{ $item->transaction_date->format('d/m/Y') }}</td>
                        <td class="font-medium">{{ $item->person->name }}</td>
                        <td>{{ $item->store_name ?: '-' }}</td>
                        <td>{{ \App\Models\ExpenseTransaction::CATEGORIES[$item->category] }}</td>
                        <td><span class="badge-brown">{{ \App\Models\ExpenseTransaction::PAYMENT_METHODS[$item->payment_method] }}</span></td>
                        <td class="whitespace-nowrap font-semibold text-red-700">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        <td>{!! $item->receipt_path ? '<span class="badge-green">Ada</span>' : '<span class="text-stone-400">-</span>' !!}</td>
                        <td><div class="flex justify-end gap-2"><a href="{{ route('expense.show', $item) }}" class="btn-secondary !px-3 !py-2">Detail</a><a href="{{ route('expense.edit', $item) }}" class="btn-secondary !px-3 !py-2">Edit</a><form method="POST" action="{{ route('expense.destroy', $item) }}" onsubmit="return confirm('Hapus transaksi ini?')">@csrf @method('DELETE')<button class="btn-danger">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="py-10 text-center text-stone-500">Belum ada transaksi uang keluar.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())<div class="border-t border-stone-200 p-4">{{ $transactions->links() }}</div>@endif
    </div>
</x-app-layout>
