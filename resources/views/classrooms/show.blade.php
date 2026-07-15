<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Classe : {{ $classroom->name }}</h2>
            <a href="{{ route('classrooms.index') }}" class="text-blue-600 hover:underline">&larr; Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Niveau</p>
                        <p class="font-medium">{{ $classroom->level ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Section</p>
                        <p class="font-medium">{{ $classroom->section ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Capacité</p>
                        <p class="font-medium">{{ $classroom->capacity ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Élèves inscrits</p>
                        <p class="font-medium">{{ $classroom->students->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Élèves de cette classe</h3>
                @if($classroom->students->isEmpty())
                    <p class="text-gray-500">Aucun élève dans cette classe.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prénom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($classroom->students as $student)
                                <tr>
                                    <td class="px-6 py-4">{{ $student->last_name }}</td>
                                    <td class="px-6 py-4">{{ $student->first_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $student->status === 'actif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
