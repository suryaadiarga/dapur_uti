<x-guest-layout>
    <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/80 p-6 sm:p-8 shadow-xl backdrop-blur-md">
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Login Admin</h1>
        <p class="mt-1.5 text-sm text-slate-400">Masuk untuk mengelola keuangan Dapur Uti.</p>

        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
            @csrf
            
            <!-- Input Email -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Email</label>
                <input id="email" class="w-full rounded-xl bg-white border border-slate-300 px-4 py-2.5 text-sm text-black placeholder-slate-400 focus:border-indigo-500 focus:outline-none transition shadow-sm" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-400" />
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Password</label>
                <div class="relative">
                    <input id="password" class="w-full rounded-xl bg-white border border-slate-300 pl-4 pr-10 py-2.5 text-sm text-black placeholder-slate-400 focus:border-indigo-500 focus:outline-none transition shadow-sm" type="password" name="password" required autocomplete="current-password">
                    
                    <!-- Tombol / Icon Show-Hide Password -->
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-800 transition focus:outline-none">
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-rose-400" />
            </div>

            <div class="flex items-center">
                <label class="flex items-center gap-2 text-sm text-slate-300 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-indigo-500/50">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 transition flex items-center justify-center">
                Masuk
            </button>
        </form>
    </div>

    <!-- Skrip JavaScript Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            }
        }
    </script>
</x-guest-layout>