<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dapur Uti Finance</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream-50 text-stone-800 antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="hidden bg-emerald-950 p-12 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="text-lg font-semibold">Dapur Uti Finance</div>
            <div>
                <div class="max-w-lg text-4xl font-semibold leading-tight">Pencatatan keuangan katering yang ringkas dan mudah dipantau.</div>
                <p class="mt-5 max-w-md text-emerald-100">Kelola uang masuk, uang keluar, nota belanja, inventaris, kas, dan laporan dalam satu tempat.</p>
            </div>
            <div class="text-sm text-emerald-200">Dapur Uti</div>
        </div>
        <div class="flex items-center justify-center p-5 sm:p-10">
            <div class="w-full max-w-md">
                <div class="mb-8 lg:hidden">
                    <div class="text-2xl font-semibold text-emerald-950">Dapur Uti Finance</div>
                    <div class="mt-1 text-sm text-stone-500">Pencatatan keuangan usaha katering</div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
