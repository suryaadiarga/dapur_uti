<x-guest-layout>
    <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
        <h1 class="text-2xl font-semibold text-stone-900">Login Dapur Uti</h1>
        <p class="mt-2 text-sm text-stone-500">Masuk untuk mengelola keuangan Dapur Uti.</p>

        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
            @csrf
            <div>
                <label for="login" class="form-label">Username atau email</label>
                <input id="login" class="form-control mt-1" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('login')" class="mt-2" />
            </div>
            <div>
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control mt-1" type="password" name="password" required autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <label class="flex items-center gap-2 text-sm text-stone-600">
                <input type="checkbox" name="remember" class="rounded border-stone-300 text-emerald-700 focus:ring-emerald-600">
                Ingat saya
            </label>
            <button type="submit" class="btn-primary w-full justify-center">Masuk</button>
        </form>

    </div>
</x-guest-layout>
