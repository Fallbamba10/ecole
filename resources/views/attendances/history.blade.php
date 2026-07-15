<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Historique — {{ $student->full_name }}</h2>
            <a href="{{ route('attendances.index', ['classroom_id' => $student->classroom_id]) }}" class="text-blue-600 hover:underline">&larr; Retour à l'appel</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats de l'élève -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold">{{ $total }}</p>
                    <p class="text-xs text-gray-500">Total séances</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $presents }}</p>
                    <p class="text-xs text-gray-500">Présent</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $absents }}</p>
                    <p class="text-xs text-gray-500">Absent</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ $retards }}</p>
                    <p class="text-xs text-gray-500">Retards</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold {{ $taux >= 80 ? 'text-green-600' : 'text-red-600' }}">{{ $taux }}%</p>
                    <p class="text-xs text-gray-500">Taux présence</p>
                </div>
            </div>

            <!-- Historique détaillé -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($attendances->isEmpty())
                        <p class="text-gray-500 text-center">Aucun enregistrement de présence.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commentaire</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td class="px-6 py-3">{{ $attendance->date->format('d/m/Y') }}</td>
                                        <td class="px-6 py-3 text-center">
                                            @switch($attendance->status)
                                                @case('present')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Présent</span>
                                                    @break
                                                @case('absent')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Absent</span>
                                                    @break
                                                @case('retard')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Retard</span>
                                                    @break
                                                @case('justifie')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Justifié</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-3 text-sm text-gray-500">{{ $attendance->comment ?? '-' }}</td>
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
