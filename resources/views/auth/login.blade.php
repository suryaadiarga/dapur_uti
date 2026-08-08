<x-guest-layout>
    <div class="glass-card rounded-2xl border border-slate-800 bg-slate-900/80 p-6 sm:p-8 shadow-xl backdrop-blur-md">
        <h1 class="text-2xl font-extrabold text-white tracking-tight">Login Admin</h1>
        <p class="mt-1.5 text-sm text-slate-400">Masuk untuk mengelola keuangan Dapur Uti.</p>

        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Email</label>
                <input id="email" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-black placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-rose-400" />
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Password</label>
                <input id="password" class="w-full rounded-xl bg-slate-950/80 border border-slate-700/60 px-4 py-2.5 text-sm text-black placeholder-slate-600 focus:border-indigo-500 focus:outline-none transition" type="password" name="password" required autocomplete="current-password">
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
</x-guest-layout>