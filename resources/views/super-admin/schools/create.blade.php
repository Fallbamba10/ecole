<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter une école</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('super-admin.schools.store') }}">
                    @csrf

                    <h3 class="font-semibold text-gray-700 mb-4 border-b pb-2">Informations de l'école</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'école *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="subscription_plan" class="block text-sm font-medium text-gray-700">Plan *</label>
                            <select name="subscription_plan" id="subscription_plan" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="trial" {{ old('subscription_plan') === 'trial' ? 'selected' : '' }}>Essai gratuit (14 jours)</option>
                                <option value="basic" {{ old('subscription_plan') === 'basic' ? 'selected' : '' }}>Basic</option>
                                <option value="standard" {{ old('subscription_plan') === 'standard' ? 'selected' : '' }}>Standard</option>
                                <option value="premium" {{ old('subscription_plan') === 'premium' ? 'selected' : '' }}>Premium</option>
                            </select>
                        </div>
                    </div>

                    <h3 class="font-semibold text-gray-700 mb-4 border-b pb-2">Compte administrateur</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="admin_name" class="block text-sm font-medium text-gray-700">Nom de l'admin *</label>
                            <input type="text" name="admin_name" id="admin_name" value="{{ old('admin_name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('admin_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700">Email de l'admin *</label>
                            <input type="email" name="admin_email" id="admin_email" value="{{ old('admin_email') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('admin_email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Le mot de passe par défaut sera : <strong>password</strong></p>

                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('super-admin.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Annuler</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer l'école</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
