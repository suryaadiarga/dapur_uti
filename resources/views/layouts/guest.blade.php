<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dapur Uti Finance</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-blue-50 text-blue-900 antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="hidden bg-gradient-to-b from-blue-800 to-blue-950 p-12 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="text-lg font-semibold tracking-tight">Dapur Uti Finance</div>
            <div>
                <div class="max-w-lg text-4xl font-semibold leading-tight">Pencatatan keuangan katering yang ringkas dan mudah dipantau.</div>
                <p class="mt-5 max-w-md text-blue-200">Kelola uang masuk, uang keluar, nota belanja, inventaris, kas, dan laporan dalam satu tempat.</p>
            </div>
            <div class="text-sm text-blue-300">Dapur Uti</div>
        </div>
        <div class="flex items-center justify-center p-5 sm:p-10">
            <div class="w-full max-w-md">
                <div class="mb-8 lg:hidden">
                    <div class="text-2xl font-semibold text-blue-900">Dapur Uti Finance</div>
                    <div class="mt-1 text-sm text-blue-400">Pencatatan keuangan usaha katering</div>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
