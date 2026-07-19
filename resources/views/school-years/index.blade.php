<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Années scolaires</h2>
            <a href="{{ route('school-years.promote-form') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Passage de classe
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire nouvelle année -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">Créer une nouvelle année scolaire</h3>
                <form method="POST" action="{{ route('school-years.store') }}" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom *</label>
                        <input type="text" name="name" id="name" placeholder="2025-2026" required
                            class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Début *</label>
                        <input type="date" name="start_date" id="start_date" required
                            class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Fin *</label>
                        <input type="date" name="end_date" id="end_date" required
                            class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Créer</button>
                </form>
            </div>

            <!-- Liste des années -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Année</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($schoolYears as $year)
                            <tr class="{{ $year->is_current ? 'bg-blue-50' : '' }}">
                                <td class="px-6 py-4 font-medium">{{ $year->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $year->start_date->format('d/m/Y') }} — {{ $year->end_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($year->is_current)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Archivée</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if(!$year->is_current)
                                        <form action="{{ route('school-years.activate', $year) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-600 hover:text-blue-900 text-sm">Activer</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Aucune année scolaire créée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
