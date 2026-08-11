<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dapur Uti Finance</title>
    <!-- Tailwind CDN & Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 font-sans antialiased selection:bg-indigo-500 selection:text-white">
    <div class="grid min-h-screen lg:grid-cols-2">
        <!-- Sidebar Kiri (Desktop) -->
        <div class="hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 p-12 text-white lg:flex lg:flex-col lg:justify-between border-r border-slate-800">
            <div class="text-lg font-bold tracking-tight">Dapur Uti Finance</div>
            <div>
                <div class="max-w-lg text-4xl font-extrabold leading-tight tracking-tight text-white">
                    Aplikasi ini dikhususkan untuk admin dan staff DAPUR UTI
                </div>
                <p class="mt-5 max-w-md text-slate-300">
                    Aplikasi production dalam tahap pengawasan dan pengembangan developer "Ncuy"
                </p>
            </div>
            <div class="text-sm text-slate-400 font-medium">Dapur Uti</div>
        </div>

        <!-- Konten Kanan (Form) -->
        <div class="flex items-center justify-center p-5 sm:p-10 bg-slate-950">
            <div class="w-full max-w-md">
                <!-- Header untuk Mobile -->
                <div class="mb-8 lg:hidden">
                    <div class="text-2xl font-bold text-white">Dapur Uti Finance</div>
                    <div class="mt-1 text-sm text-slate-300">Pencatatan keuangan usaha katering</div>
                </div>
                
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>