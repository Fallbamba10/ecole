<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notes</h2>
            <a href="{{ route('grades.create', ['classroom_id' => request('classroom_id')]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Saisir une note
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtres -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <form method="GET" action="{{ route('grades.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm text-gray-600">Classe</label>
                        <select name="classroom_id" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                            <option value="">-- Choisir une classe --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                    {{ $classroom->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Période</label>
                        <select name="period" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                            @foreach(['Trimestre 1', 'Trimestre 2', 'Trimestre 3'] as $p)
                                <option value="{{ $p }}" {{ $period === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            @if($selectedClassroom && $students->isNotEmpty())
                @php
                    // Calcul des moyennes pour le classement
                    $rankings = $students->map(function($student) use ($grades, $subjects) {
                        $totalW = 0;
                        $totalC = 0;
                        foreach ($subjects as $subject) {
                            $studentGrades = $grades[$student->id][$subject->id] ?? collect();
                            $avg = $studentGrades->count() > 0 ? $studentGrades->avg('value') : null;
                            if ($avg !== null) {
                                $totalW += $avg * $subject->coefficient;
                                $totalC += $subject->coefficient;
                            }
                        }
                        return [
                            'student_id' => $student->id,
                            'moyenne' => $totalC > 0 ? round($totalW / $totalC, 2) : null,
                        ];
                    })->filter(fn($r) => $r['moyenne'] !== null)->sortByDesc('moyenne')->values();

                    $classAvg = $rankings->count() > 0 ? round($rankings->avg('moyenne'), 2) : null;
                    $rankMap = [];
                    $rank = 0;
                    $lastMoy = null;
                    foreach ($rankings as $i => $r) {
                        if ($r['moyenne'] !== $lastMoy) {
                            $rank = $i + 1;
                            $lastMoy = $r['moyenne'];
                        }
                        $rankMap[$r['student_id']] = $rank;
                    }
                @endphp

                <!-- Résumé classe -->
                <div class="bg-white rounded-lg shadow p-4 mb-4 flex flex-wrap gap-6 items-center">
                    <div>
                        <span class="text-sm text-gray-500">Moyenne de classe :</span>
                        @if($classAvg)
                            <span class="font-bold text-lg {{ $classAvg >= 10 ? 'text-green-600' : 'text-red-600' }}">{{ $classAvg }}/20</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Élèves classés :</span>
                        <span class="font-bold">{{ $rankings->count() }}/{{ $students->count() }}</span>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Taux de réussite :</span>
                        @php $reussis = $rankings->filter(fn($r) => $r['moyenne'] >= 10)->count(); @endphp
                        <span class="font-bold {{ $rankings->count() > 0 && ($reussis / $rankings->count()) >= 0.5 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $rankings->count() > 0 ? round(($reussis / $rankings->count()) * 100) : 0 }}%
                        </span>
                    </div>
                </div>

                <!-- Tableau des notes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase bg-yellow-50">Rang</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiant</th>
                                    @foreach($subjects as $subject)
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                            {{ $subject->name }}<br>
                                            <span class="text-gray-400">(coef {{ $subject->coefficient }})</span>
                                        </th>
                                    @endforeach
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase bg-blue-50">Moyenne</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bulletin</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students->sortBy(fn($s) => $rankMap[$s->id] ?? 999) as $student)
                                    @php
                                        $totalW = 0;
                                        $totalC = 0;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 text-center bg-yellow-50 font-bold">
                                            @if(isset($rankMap[$student->id]))
                                                {{ $rankMap[$student->id] }}<sup>{{ $rankMap[$student->id] == 1 ? 'er' : 'e' }}</sup>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-medium whitespace-nowrap">{{ $student->full_name }}</td>
                                        @foreach($subjects as $subject)
                                            @php
                                                $studentGrades = $grades[$student->id][$subject->id] ?? collect();
                                                $avg = $studentGrades->count() > 0 ? round($studentGrades->avg('value'), 2) : null;
                                                if ($avg !== null) {
                                                    $totalW += $avg * $subject->coefficient;
                                                    $totalC += $subject->coefficient;
                                                }
                                            @endphp
                                            <td class="px-4 py-3 text-center">
                                                @if($avg !== null)
                                                    <span class="{{ $avg >= 10 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                        {{ $avg }}/20
                                                    </span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="px-4 py-3 text-center bg-blue-50 font-bold">
                                            @if($totalC > 0)
                                                @php $moy = round($totalW / $totalC, 2); @endphp
                                                <span class="{{ $moy >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $moy }}/20
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('bulletins.show', ['student' => $student, 'period' => $period]) }}" class="text-blue-600 hover:underline text-sm">Voir</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif($selectedClassroom && $subjects->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Aucune matière définie pour cette classe. Ajoutez des matières d'abord.
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Sélectionnez une classe pour voir les notes.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
