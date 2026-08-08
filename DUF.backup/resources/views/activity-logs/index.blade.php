<x-app-layout>
    <x-slot name="title">Activity Log - Dapur Uti Finance</x-slot>
    <div class="mb-6">
        <h1 class="page-title">Activity Log</h1>
        <p class="page-subtitle">Jejak aktivitas akun dan perubahan data.</p>
    </div>

    <div class="panel mb-5 panel-body">
        <form method="GET" class="grid gap-3 sm:grid-cols-3">
            <div>
                <label class="form-label">Action</label>
                <select name="action" class="form-control mt-1">
                    <option value="">Semua action</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" @selected(request('action') === $action)>{{ $action }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">User ID</label>
                <input type="number" min="1" name="user_id" value="{{ request('user_id') }}" class="form-control mt-1">
            </div>
            <div class="flex items-end gap-2">
                <button class="btn-primary">Filter</button>
                <a href="{{ route('activity-logs.index') }}" class="btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Waktu</th><th>Pelaku</th><th>Action</th><th>Target</th><th>IP</th><th>Perubahan</th></tr></thead>
                <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="whitespace-nowrap">{{ $log->created_at?->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $log->user?->username ?? 'System' }}<div class="text-xs text-stone-500">{{ $log->role ?: '-' }}</div></td>
                        <td><span class="badge-brown">{{ $log->action }}</span></td>
                        <td>{{ $log->model_type ?: '-' }}{{ $log->model_id ? ' #'.$log->model_id : '' }}</td>
                        <td>{{ $log->ip_address ?: '-' }}</td>
                        <td>
                            @if($log->old_values || $log->new_values)
                                <details class="max-w-md">
                                    <summary class="cursor-pointer text-emerald-700">Lihat</summary>
                                    <pre class="mt-2 whitespace-pre-wrap text-xs">{{ json_encode(['old' => $log->old_values, 'new' => $log->new_values], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </details>
                            @else
                                {{ $log->description ?: '-' }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-10 text-center text-stone-500">Belum ada activity log.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())<div class="border-t border-stone-200 p-4">{{ $logs->links() }}</div>@endif
    </div>
</x-app-layout>
