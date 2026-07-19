<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Présences — Appel</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtres -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <form method="GET" action="{{ route('attendances.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm text-gray-600">Classe</label>
                        <select name="classroom_id" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                            <option value="">-- Choisir une classe --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                    {{ $classroom->name }} ({{ $classroom->students_count }} élèves)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Date</label>
                        <input type="date" name="date" value="{{ $date }}" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                    </div>
                </form>
            </div>

            <!-- Stats globales -->
            @if($stats)
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="flex gap-6 text-sm">
                        <div>
                            <span class="text-gray-500">Taux de présence global :</span>
                            <span class="font-bold {{ $stats['taux'] >= 80 ? 'text-green-600' : 'text-red-600' }}">{{ $stats['taux'] }}%</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Total appels :</span>
                            <span class="font-medium">{{ $stats['total'] }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulaire d'appel -->
            @if($selectedClassroom && $students->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form method="POST" action="{{ route('attendances.store') }}">
                            @csrf
                            <input type="hidden" name="classroom_id" value="{{ $selectedClassroom->id }}">
                            <input type="hidden" name="date" value="{{ $date }}">

                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Élève</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Présent</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Absent</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Retard</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Justifié</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaire</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($students as $student)
                                        @php
                                            $existing = $attendances[$student->id] ?? null;
                                            $currentStatus = $existing ? $existing->status : 'present';
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-3 font-medium">
                                                {{ $student->full_name }}
                                                <a href="{{ route('attendances.history', $student) }}" class="text-blue-500 text-xs hover:underline ml-2">historique</a>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" name="statuses[{{ $student->id }}]" value="present"
                                                    {{ $currentStatus === 'present' ? 'checked' : '' }}
                                                    class="text-green-600 focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" name="statuses[{{ $student->id }}]" value="absent"
                                                    {{ $currentStatus === 'absent' ? 'checked' : '' }}
                                                    class="text-red-600 focus:ring-red-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" name="statuses[{{ $student->id }}]" value="retard"
                                                    {{ $currentStatus === 'retard' ? 'checked' : '' }}
                                                    class="text-yellow-600 focus:ring-yellow-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" name="statuses[{{ $student->id }}]" value="justifie"
                                                    {{ $currentStatus === 'justifie' ? 'checked' : '' }}
                                                    class="text-blue-600 focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="comments[{{ $student->id }}]"
                                                    value="{{ $existing->comment ?? '' }}"
                                                    placeholder="Optionnel..."
                                                    class="w-full text-sm rounded-md border-gray-300">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                    Enregistrer l'appel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($selectedClassroom)
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Aucun élève dans cette classe.
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Sélectionnez une classe pour faire l'appel.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
