<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saisie en masse des notes</h2>
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
                <form method="GET" action="{{ route('grades.batch') }}" class="flex flex-wrap gap-4 items-end">
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
                    @if($subjects->isNotEmpty())
                    <div>
                        <label class="block text-sm text-gray-600">Matière</label>
                        <select name="subject_id" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                            <option value="">-- Choisir --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} (coef {{ $subject->coefficient }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm text-gray-600">Période</label>
                        <select name="period" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                            @foreach(['Trimestre 1', 'Trimestre 2', 'Trimestre 3'] as $p)
                                <option value="{{ $p }}" {{ $period === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Type</label>
                        <select name="type" class="rounded-md border-gray-300 text-sm" onchange="this.form.submit()">
                            @foreach(['devoir' => 'Devoir', 'composition' => 'Composition', 'examen' => 'Examen'] as $key => $label)
                                <option value="{{ $key }}" {{ request('type', 'devoir') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            @if($students->isNotEmpty() && request('subject_id'))
                <form method="POST" action="{{ route('grades.batch.store') }}">
                    @csrf
                    <input type="hidden" name="classroom_id" value="{{ request('classroom_id') }}">
                    <input type="hidden" name="subject_id" value="{{ request('subject_id') }}">
                    <input type="hidden" name="period" value="{{ $period }}">
                    <input type="hidden" name="type" value="{{ request('type', 'devoir') }}">

                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Élève</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Note /20</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Commentaire</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students as $index => $student)
                                    @php
                                        $existingGrade = $existingGrades[$student->id] ?? null;
                                    @endphp
                                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-6 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-3 text-sm font-medium text-gray-900">
                                            {{ $student->full_name }}
                                            <input type="hidden" name="grades[{{ $index }}][student_id]" value="{{ $student->id }}">
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <input type="number" name="grades[{{ $index }}][value]"
                                                value="{{ old("grades.{$index}.value", $existingGrade?->value) }}"
                                                min="0" max="20" step="0.25"
                                                class="w-20 rounded-md border-gray-300 text-sm text-center focus:border-blue-500 focus:ring-blue-500"
                                                placeholder="-">
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <input type="text" name="grades[{{ $index }}][comment]"
                                                value="{{ old("grades.{$index}.comment", $existingGrade?->comment) }}"
                                                class="w-full rounded-md border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                                                placeholder="Optionnel">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <p class="text-sm text-gray-500">
                            {{ $students->count() }} élèves · Les champs vides seront ignorés
                        </p>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                            Enregistrer les notes
                        </button>
                    </div>
                </form>
            @elseif(request('classroom_id') && !request('subject_id'))
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Sélectionnez une matière pour commencer la saisie.
                </div>
            @elseif(!request('classroom_id'))
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Sélectionnez une classe pour commencer.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
