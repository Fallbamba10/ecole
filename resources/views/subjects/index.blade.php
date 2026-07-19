<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Matières</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Formulaire d'ajout rapide -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="font-semibold mb-3">Ajouter une matière</h3>
                <form method="POST" action="{{ route('subjects.store') }}" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-sm text-gray-600">Nom *</label>
                        <input type="text" name="name" required placeholder="Ex: Mathématiques"
                            class="rounded-md border-gray-300 text-sm">
                        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Coefficient *</label>
                        <input type="number" name="coefficient" value="1" min="1" max="10" required
                            class="rounded-md border-gray-300 text-sm w-20">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Classe *</label>
                        <select name="classroom_id" required class="rounded-md border-gray-300 text-sm">
                            <option value="">-- Choisir --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">Ajouter</button>
                </form>
            </div>

            <!-- Liste -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matière</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Classe</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Coefficient</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($subjects as $subject)
                            <tr>
                                <td class="px-6 py-4 font-medium">{{ $subject->name }}</td>
                                <td class="px-6 py-4">{{ $subject->classroom->name }}</td>
                                <td class="px-6 py-4 text-center">{{ $subject->coefficient }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune matière.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
