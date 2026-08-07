<x-app-layout>
    <x-slot name="title">Nota Belanja - Dapur Uti Finance</x-slot>
    <div class="mb-6"><h1 class="page-title">Nota Belanja</h1><p class="page-subtitle">Kumpulan foto nota dari transaksi uang keluar.</p></div>
    <div class="panel mb-5 panel-body">
        <form method="GET" class="filter-grid xl:grid-cols-5">
            <div><label class="form-label">Bulan</label><input type="month" name="month" value="{{ request('month') }}" class="form-control mt-1"></div>
            <div><label class="form-label">Orang</label><select name="person_id" class="form-control mt-1"><option value="">Semua</option>@foreach($people as $person)<option value="{{ $person->id }}" @selected((string) request('person_id') === (string) $person->id)>{{ $person->name }}</option>@endforeach</select></div>
            <div><label class="form-label">Toko</label><input name="store_name" value="{{ request('store_name') }}" class="form-control mt-1" placeholder="Nama toko"></div>
            <div><label class="form-label">Kategori</label><select name="category" class="form-control mt-1"><option value="">Semua</option>@foreach(\App\Models\ExpenseTransaction::CATEGORIES as $value => $label)<option value="{{ $value }}" @selected(request('category') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div class="flex items-end gap-2"><button class="btn-primary">Filter</button><a href="{{ route('receipts.index') }}" class="btn-secondary">Reset</a></div>
        </form>
    </div>
    <div x-data="{ preview: null }" class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Tanggal</th><th>Orang</th><th>Toko</th><th>Kategori</th><th>Nominal</th><th>Foto nota</th><th>Keterangan</th></tr></thead>
                <tbody>
                @forelse($receipts as $item)
                    <tr>
                        <td class="whitespace-nowrap">{{ $item->transaction_date->format('d/m/Y') }}</td>
                        <td class="font-medium">{{ $item->person->name }}</td>
                        <td>{{ $item->store_name ?: '-' }}</td>
                        <td>{{ \App\Models\ExpenseTransaction::CATEGORIES[$item->category] }}</td>
                        <td class="whitespace-nowrap font-semibold">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                        <td>
                            <div class="flex gap-2">
                                <button type="button" @click="preview = '{{ Storage::url($item->receipt_path) }}'" class="btn-secondary !px-3 !py-2">Preview</button>
                                <a href="{{ route('expense.download', $item) }}" class="btn-secondary !px-3 !py-2">Download</a>
                            </div>
                        </td>
                        <td class="max-w-xs">{{ $item->description ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-10 text-center text-stone-500">Belum ada nota yang sesuai filter.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($receipts->hasPages())<div class="border-t border-stone-200 p-4">{{ $receipts->links() }}</div>@endif

        <div x-show="preview" x-cloak @keydown.escape.window="preview = null" class="fixed inset-0 z-50 flex items-center justify-center bg-stone-950/80 p-4" @click.self="preview = null">
            <div class="relative max-h-full max-w-4xl">
                <button @click="preview = null" class="absolute -right-2 -top-10 rounded-lg bg-white px-3 py-2 text-sm">Tutup</button>
                <img :src="preview" class="max-h-[85vh] max-w-full rounded-xl bg-white object-contain" alt="Preview nota">
            </div>
        </div>
    </div>
</x-app-layout>
