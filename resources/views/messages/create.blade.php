<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau message</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('messages.store') }}" method="POST" x-data="{ recipientType: 'individual' }">
                    @csrf

                    {{-- Type de destinataire --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type d'envoi</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="recipient_type" value="individual" x-model="recipientType" class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Individuel</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="recipient_type" value="role" x-model="recipientType" class="rounded-full border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Par groupe (role)</span>
                            </label>
                        </div>
                        @error('recipient_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Destinataires individuels --}}
                    <div x-show="recipientType === 'individual'" class="mb-4">
                        <label for="recipients" class="block text-sm font-medium text-gray-700 mb-2">Destinataire(s)</label>
                        <select name="recipients[]" id="recipients" multiple class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" size="8">
                            @foreach($users as $group => $groupUsers)
                                <optgroup label="{{ $group }}">
                                    @foreach($groupUsers as $user)
                                        <option value="{{ $user->id }}" {{ in_array($user->id, old('recipients', [])) ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Maintenez Ctrl (ou Cmd) pour selectionner plusieurs destinataires.</p>
                        @error('recipients')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Destinataires par role --}}
                    <div x-show="recipientType === 'role'" class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Envoyer a tous les</label>
                        <select name="role" id="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Choisir un groupe --</option>
                            <option value="admin_ecole" {{ old('role') === 'admin_ecole' ? 'selected' : '' }}>Administrateurs</option>
                            <option value="enseignant" {{ old('role') === 'enseignant' ? 'selected' : '' }}>Tous les enseignants</option>
                            <option value="secretaire" {{ old('role') === 'secretaire' ? 'selected' : '' }}>Toutes les secretaires</option>
                            <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Tous les parents</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sujet --}}
                    <div class="mb-4">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Objet du message">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Corps du message --}}
                    <div class="mb-6">
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="body" id="body" rows="8" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Ecrivez votre message ici...">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Boutons --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('messages.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                            Annuler
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 transition">
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
