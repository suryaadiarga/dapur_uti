<x-app-layout>
    <x-slot name="title">Pengaturan - Dapur Uti Finance</x-slot>
    <div class="mb-6"><h1 class="page-title">Pengaturan</h1><p class="page-subtitle">Informasi dasar usaha yang ditampilkan di aplikasi dan laporan.</p></div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('settings.update') }}" class="panel panel-body max-w-4xl">
        @csrf @method('PUT')
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2"><label class="form-label">Nama usaha <span class="text-red-500">*</span></label><input name="business_name" value="{{ old('business_name', $setting->business_name) }}" class="form-control mt-1" required></div>
            <div class="sm:col-span-2"><label class="form-label">Alamat usaha</label><textarea name="business_address" rows="3" class="form-control mt-1">{{ old('business_address', $setting->business_address) }}</textarea></div>
            <div><label class="form-label">Nomor WhatsApp</label><input name="whatsapp_number" value="{{ old('whatsapp_number', $setting->whatsapp_number) }}" class="form-control mt-1" placeholder="08..."></div>
            <div><label class="form-label">Mata uang</label><select name="currency" class="form-control mt-1"><option value="IDR" selected>Rupiah (IDR)</option></select></div>
            <div><label class="form-label">Logo usaha</label><input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp" class="form-control mt-1"><p class="mt-1 text-xs text-stone-500">JPG, PNG, WEBP. Maksimal 2MB.</p></div>
            @if($setting->logo_path)<div><label class="form-label">Logo saat ini</label><img src="{{ Storage::url($setting->logo_path) }}" class="mt-2 h-28 w-28 rounded-xl border object-cover" alt="Logo"></div>@endif
        </div>
        <div class="mt-6"><button class="btn-primary">Simpan Pengaturan</button></div>
    </form>
</x-app-layout>
