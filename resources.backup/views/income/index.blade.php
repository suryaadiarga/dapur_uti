<x-app-layout>
    <x-slot name="title">Uang Masuk - Dapur Uti Finance</x-slot>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div><h1 class="page-title">Uang Masuk</h1><p class="page-subtitle">Catat seluruh penerimaan kas Dapur Uti.</p></div>
        <a href="{{ route('income.create') }}" class="btn-primary">+ Tambah Uang Masuk</a>
    </div>
    <div class="panel mb-5 panel-body">
        <form method="GET" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-6">
            <div><label class="form-label">Dari tanggal</label><input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control mt-1"></div>
            <div><label class="form-label">Sampai tanggal</label><input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control mt-1"></div>
            <div><label class="form-label">Kategori</label><select name="category" class="form-control mt-1"><option value="">Semua</option>@foreach(\App\Models\IncomeTransaction::CATEGORIES as $value => $label)<option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div><label class="form-label">Orang</label><select name="person_id" class="form-control mt-1"><option value="">Semua</option>@foreach($people as $person)<option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>@endforeach</select></div>
            <div><label class="form-label">Pencarian</label><input name="search" value="{{ request('search') }}" class="form-control mt-1" placeholder="Keterangan/orang"></div>
            <div class="flex items-end gap-2"><button class="btn-primary">Filter</button><a href="{{ route('income.index') }}" class="btn-secondary">Reset</a></div>
        </form>
    </div>
    <div class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Tanggal</th><th>Orang</th><th>Kategori</th><th>Metode</th><th>Nominal</th><th>Dicatat oleh</th><th class="text-right">Aksi</th></tr></thead>
                <tbody>
                @forelse($transactions as $item)
                    <tr>
                        <td class="whitespace-nowrap">{{ $item->transaction_date->format('d/m/Y') }}</td>
                        <td class="font-medium">{{ $item->person->name }}</td>
                        <td>{{ \App\Models\IncomeTransaction::CATEGORIES[$item->category] }}</td>
                        <td><span class="badge-brown">{{ \App\Models\IncomeTransaction::PAYMENT_METHODS[$item->payment_method] }}</span></td>
                        <td class="whitespace-nowrap font-semibold text-emerald-700">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        <td>{{ $item->creator->name }}</td>
                        <td><div class="flex justify-end gap-2"><a href="{{ route('income.show', $item) }}" class="btn-secondary !px-3 !py-2">Detail</a><a href="{{ route('income.edit', $item) }}" class="btn-secondary !px-3 !py-2">Edit</a><form method="POST" action="{{ route('income.destroy', $item) }}" onsubmit="return confirm('Hapus transaksi ini?')">@csrf @method('DELETE')<button class="btn-danger">Hapus</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-center text-stone-500">Belum ada transaksi uang masuk.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())<div class="border-t border-stone-200 p-4">{{ $transactions->links() }}</div>@endif
    </div>
</x-app-layout>
