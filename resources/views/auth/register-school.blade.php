<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Inscrivez votre école</h2>
        <p class="mt-2 text-sm text-gray-500">1 mois d'essai gratuit — Aucune carte requise</p>
    </div>

    <form method="POST" action="{{ route('register.school.store') }}">
        @csrf

        <!-- Section École -->
        <div class="mb-6 pb-6 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Votre école</h3>

            <div class="mb-4">
                <label for="school_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nom de l'école</label>
                <input id="school_name" type="text" name="school_name" value="{{ old('school_name') }}" required autofocus
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                    placeholder="Ex: Institut Excellence">
                <x-input-error :messages="$errors->get('school_name')" class="mt-1.5" />
            </div>

            <div class="mb-4">
                <label for="school_email" class="block text-sm font-medium text-gray-700 mb-1.5">Email de l'école</label>
                <input id="school_email" type="email" name="school_email" value="{{ old('school_email') }}" required
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                    placeholder="contact@votre-ecole.sn">
                <x-input-error :messages="$errors->get('school_email')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="school_phone" class="block text-sm font-medium text-gray-700 mb-1.5">Téléphone</label>
                    <input id="school_phone" type="text" name="school_phone" value="{{ old('school_phone') }}" required
                        class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                        placeholder="77 123 45 67">
                    <x-input-error :messages="$errors->get('school_phone')" class="mt-1.5" />
                </div>
                <div>
                    <label for="school_address" class="block text-sm font-medium text-gray-700 mb-1.5">Ville</label>
                    <input id="school_address" type="text" name="school_address" value="{{ old('school_address') }}" required
                        class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                        placeholder="Dakar">
                    <x-input-error :messages="$errors->get('school_address')" class="mt-1.5" />
                </div>
            </div>
        </div>

        <!-- Section Admin -->
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Votre compte</h3>

            <div class="mb-4">
                <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nom complet</label>
                <input id="admin_name" type="text" name="admin_name" value="{{ old('admin_name') }}" required
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                    placeholder="Prénom Nom">
                <x-input-error :messages="$errors->get('admin_name')" class="mt-1.5" />
            </div>

            <div class="mb-4">
                <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1.5">Email de connexion</label>
                <input id="admin_email" type="email" name="admin_email" value="{{ old('admin_email') }}" required
                    class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                    placeholder="vous@email.com">
                <x-input-error :messages="$errors->get('admin_email')" class="mt-1.5" />
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
                    <input id="password" type="password" name="password" required
                        class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition"
                        placeholder="••••••••">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm shadow-sm hover:shadow-md transition-all">
            Créer mon école — Essai gratuit 1 mois
        </button>

        <p class="mt-5 text-center text-sm text-gray-500">
            Déjà inscrit ? <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Se connecter</a>
        </p>
    </form>
</x-guest-layout>
