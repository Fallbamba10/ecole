<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saisir une note</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Sélection de classe pour charger étudiants/matières -->
                <form method="GET" action="{{ route('grades.create') }}" class="mb-6 pb-4 border-b">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                    <select name="classroom_id" onchange="this.form.submit()"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Choisir une classe --</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                @if(request('classroom_id') && $students->isNotEmpty() && $subjects->isNotEmpty())
                    <form method="POST" action="{{ route('grades.store', ['classroom_id' => request('classroom_id')]) }}">
                        @csrf
                        <input type="hidden" name="classroom_id" value="{{ request('classroom_id') }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700">Étudiant *</label>
                                <select name="student_id" id="student_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Choisir --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="subject_id" class="block text-sm font-medium text-gray-700">Matière *</label>
                                <select name="subject_id" id="subject_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Choisir --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }} (coef {{ $subject->coefficient }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="period" class="block text-sm font-medium text-gray-700">Période *</label>
                                <select name="period" id="period" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="Trimestre 1" {{ old('period') === 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                                    <option value="Trimestre 2" {{ old('period') === 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                                    <option value="Trimestre 3" {{ old('period') === 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                                </select>
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                                <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="devoir" {{ old('type') === 'devoir' ? 'selected' : '' }}>Devoir</option>
                                    <option value="composition" {{ old('type') === 'composition' ? 'selected' : '' }}>Composition</option>
                                    <option value="examen" {{ old('type') === 'examen' ? 'selected' : '' }}>Examen</option>
                                </select>
                            </div>

                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700">Note *</label>
                                <input type="number" name="value" id="value" value="{{ old('value') }}" required min="0" max="20" step="0.25"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('value') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="max_value" class="block text-sm font-medium text-gray-700">Sur</label>
                                <input type="number" name="max_value" id="max_value" value="{{ old('max_value', 20) }}" min="1" max="20"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700">Commentaire</label>
                            <input type="text" name="comment" id="comment" value="{{ old('comment') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <a href="{{ route('grades.index', ['classroom_id' => request('classroom_id')]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Annuler</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enregistrer</button>
                        </div>
                    </form>
                @elseif(request('classroom_id'))
                    <p class="text-gray-500 text-center">Aucune matière ou étudiant dans cette classe.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
