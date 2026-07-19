<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Importer des élèves (CSV)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('import_errors'))
                <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    <strong>Erreurs d'import :</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Format attendu -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-semibold text-blue-800 mb-2">Format du fichier CSV</h3>
                    <p class="text-sm text-blue-700 mb-2">Le fichier doit contenir une ligne d'en-tête et utiliser le <strong>point-virgule (;)</strong> comme séparateur.</p>
                    <div class="bg-white p-3 rounded border text-xs font-mono text-gray-700">
                        prenom;nom;genre<br>
                        Amadou;Ba;M<br>
                        Fatou;Diop;F<br>
                        Moussa;Ndiaye;M
                    </div>
                </div>

                <form method="POST" action="{{ route('students.import.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="classroom_id" class="block text-sm font-medium text-gray-700">Classe de destination *</label>
                        <select name="classroom_id" id="classroom_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                            @endforeach
                        </select>
                        @error('classroom_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="csv_file" class="block text-sm font-medium text-gray-700">Fichier CSV *</label>
                        <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('csv_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('students.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Annuler</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Importer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
