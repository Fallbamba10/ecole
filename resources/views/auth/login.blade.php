<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Bienvenue</h2>
        <p class="mt-2 text-sm text-gray-500">Connectez-vous à votre espace de gestion</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                placeholder="votre@email.sn">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm shadow-sm hover:shadow-md transition-all">
            Se connecter
        </button>
    </form>
</x-guest-layout>
