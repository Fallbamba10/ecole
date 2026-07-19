<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bulletin — {{ $student->full_name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('bulletins.pdf', ['student' => $student, 'period' => $period]) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Télécharger PDF
                </a>
                <a href="{{ route('grades.index', ['classroom_id' => $student->classroom_id, 'period' => $period]) }}" class="text-blue-600 hover:underline">&larr; Retour</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8">
                <!-- En-tête -->
                <div class="text-center border-b pb-4 mb-6">
                    <h1 class="text-2xl font-bold">BULLETIN DE NOTES</h1>
                    <p class="text-gray-600 mt-1">{{ $period }}</p>
                </div>

                <!-- Infos élève -->
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div>
                        <p><span class="text-gray-500">Élève :</span> <strong>{{ $student->full_name }}</strong></p>
                        <p><span class="text-gray-500">Classe :</span> {{ $student->classroom->name ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p><span class="text-gray-500">Année scolaire :</span> 2025-2026</p>
                    </div>
                </div>

                <!-- Tableau des notes -->
                <table class="min-w-full divide-y divide-gray-200 mb-6">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matière</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Coef</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Notes</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Moyenne</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($results as $result)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $result['subject']->name }}</td>
                                <td class="px-4 py-3 text-center">{{ $result['subject']->coefficient }}</td>
                                <td class="px-4 py-3 text-center text-sm text-gray-600">
                                    @foreach($result['grades'] as $grade)
                                        {{ $grade->value }}/{{ $grade->max_value }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                    @if($result['grades']->isEmpty())
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-bold">
                                    @if($result['average'] !== null)
                                        <span class="{{ $result['average'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $result['average'] }}/20
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Moyenne générale -->
                <div class="border-t pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold">Moyenne Générale</span>
                        @if($generalAverage !== null)
                            <span class="text-2xl font-bold {{ $generalAverage >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $generalAverage }}/20
                            </span>
                        @else
                            <span class="text-gray-400">Pas de notes</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
