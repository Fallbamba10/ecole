<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Paramètres de l'école</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('school.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Logo actuel -->
                    @if($school->logo)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo actuel</label>
                            <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="w-24 h-24 object-contain rounded border">
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="logo" class="block text-sm font-medium text-gray-700">Logo de l'école</label>
                        <input type="file" name="logo" id="logo" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'école *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $school->name) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $school->email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $school->phone) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $school->address) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Infos abonnement (lecture seule) -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
                        <h3 class="font-semibold text-gray-700 mb-2">Abonnement</h3>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div class="text-gray-500">Plan :</div>
                            <div class="font-medium">{{ ucfirst($school->subscription_plan) }}</div>
                            @if($school->trial_ends_at)
                                <div class="text-gray-500">Fin de l'essai :</div>
                                <div class="font-medium {{ $school->trial_ends_at->isPast() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $school->trial_ends_at->format('d/m/Y') }}
                                    ({{ $school->trial_ends_at->diffForHumans() }})
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
