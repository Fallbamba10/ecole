<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Mot de passe oublié</h2>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        Indiquez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Envoyer le lien
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
