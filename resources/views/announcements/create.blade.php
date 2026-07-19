<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Publier une annonce</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('announcements.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Contenu *</label>
                        <textarea name="content" id="content" rows="5" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content') }}</textarea>
                        @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="target" class="block text-sm font-medium text-gray-700">Destinataires *</label>
                        <select name="target" id="target" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            onchange="document.getElementById('classroom_field').style.display = this.value === 'classroom' ? 'block' : 'none'">
                            <option value="all" {{ old('target') === 'all' ? 'selected' : '' }}>Toute l'école</option>
                            <option value="classroom" {{ old('target') === 'classroom' ? 'selected' : '' }}>Une classe spécifique</option>
                        </select>
                    </div>

                    <div class="mb-4" id="classroom_field" style="{{ old('target') === 'classroom' ? '' : 'display:none' }}">
                        <label for="classroom_id" class="block text-sm font-medium text-gray-700">Classe</label>
                        <select name="classroom_id" id="classroom_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Choisir --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                    {{ $classroom->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('announcements.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Annuler</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Publier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
