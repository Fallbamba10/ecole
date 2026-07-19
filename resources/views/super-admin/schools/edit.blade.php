<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier : {{ $school->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('super-admin.schools.update', $school) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'école *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $school->name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $school->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $school->phone) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $school->address) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="subscription_plan" class="block text-sm font-medium text-gray-700">Plan</label>
                            <select name="subscription_plan" id="subscription_plan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="trial" {{ old('subscription_plan', $school->subscription_plan) === 'trial' ? 'selected' : '' }}>Essai</option>
                                <option value="basic" {{ old('subscription_plan', $school->subscription_plan) === 'basic' ? 'selected' : '' }}>Basic</option>
                                <option value="standard" {{ old('subscription_plan', $school->subscription_plan) === 'standard' ? 'selected' : '' }}>Standard</option>
                                <option value="premium" {{ old('subscription_plan', $school->subscription_plan) === 'premium' ? 'selected' : '' }}>Premium</option>
                            </select>
                        </div>

                        <div class="flex items-center mt-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $school->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">École active</span>
                            </label>
                        </div>
                    </div>

                    @if($school->trial_ends_at)
                        <div class="mt-4 p-3 bg-gray-50 rounded text-sm text-gray-600">
                            Fin d'essai : <strong>{{ $school->trial_ends_at->format('d/m/Y') }}</strong>
                            @if($school->trial_ends_at->isPast())
                                <span class="text-red-600">(expiré)</span>
                            @else
                                <span class="text-green-600">({{ $school->trial_ends_at->diffForHumans() }})</span>
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-between mt-6">
                        <form action="{{ route('super-admin.schools.destroy', $school) }}" method="POST"
                            onsubmit="return confirm('Supprimer cette école et toutes ses données ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button>
                        </form>
                        <div class="space-x-2">
                            <a href="{{ route('super-admin.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Annuler</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
