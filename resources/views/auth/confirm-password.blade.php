<x-guest-layout>
    <div class="rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
        <h1 class="text-2xl font-semibold text-blue-900">Konfirmasi Password</h1>
        <p class="mt-2 text-sm text-blue-400">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="mt-7 space-y-5">
            @csrf

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
