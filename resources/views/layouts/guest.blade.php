<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dapur Uti Finance</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-200 antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        <!-- Sidebar Kiri (Desktop) -->
        <div class="hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 p-12 text-white lg:flex lg:flex-col lg:justify-between border-r border-slate-800">
            <div class="text-lg font-bold tracking-tight">Dapur Uti Finance</div>
            <div>
                <div class="max-w-lg text-4xl font-extrabold leading-tight tracking-tight">
                    Aplikasi ini dikhususkan untuk admin dan staff DAPUR UTI
                </div>
                <p class="mt-5 max-w-md text-slate-400">
                    aplikasi production dalam tahap pengawasan dan pengembangan developer "Ncuy"
                </p>
            </div>
            <div class="text-sm text-slate-500 font-medium">Dapur Uti</div>
        </div>

        <!-- Konten Kanan (Form) -->
        <div class="flex items-center justify-center p-5 sm:p-10">
            <div class="w-full max-w-md">
                <!-- Header untuk Mobile -->
                <div class="mb-8 lg:hidden">
                    <div class="text-2xl font-bold text-white">Dapur Uti Finance</div>
                    <div class="mt-1 text-sm text-slate-400">Pencatatan keuangan usaha katering</div>
                </div>
                
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>