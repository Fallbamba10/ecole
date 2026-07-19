<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Classes</h2>
            <a href="{{ route('classrooms.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nouvelle classe
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($classrooms->isEmpty())
                        <p class="text-gray-500 text-center py-4">Aucune classe pour le moment.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Niveau</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Section</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Élèves</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($classrooms as $classroom)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $classroom->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $classroom->level ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $classroom->section ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $classroom->students_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                            <a href="{{ route('classrooms.show', $classroom) }}" class="text-blue-600 hover:underline">Voir</a>
                                            <a href="{{ route('classrooms.edit', $classroom) }}" class="text-yellow-600 hover:underline">Modifier</a>
                                            <form action="{{ route('classrooms.destroy', $classroom) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Supprimer cette classe ?')">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
