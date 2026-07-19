<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $student->full_name }}</h2>
            <a href="{{ route('students.index') }}" class="text-blue-600 hover:underline">&larr; Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Informations personnelles</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm text-gray-500">Nom complet</dt>
                                <dd class="font-medium">{{ $student->full_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Date de naissance</dt>
                                <dd>{{ $student->birth_date?->format('d/m/Y') ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Genre</dt>
                                <dd>{{ $student->gender === 'M' ? 'Masculin' : ($student->gender === 'F' ? 'Féminin' : '-') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Téléphone</dt>
                                <dd>{{ $student->phone ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Adresse</dt>
                                <dd>{{ $student->address ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-3">Scolarité</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm text-gray-500">Classe</dt>
                                <dd class="font-medium">{{ $student->classroom->name ?? 'Non affecté' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Statut</dt>
                                <dd>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $student->status === 'actif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        <h3 class="text-lg font-semibold mb-3 mt-6">Contact parent</h3>
                        <dl class="space-y-2">
                            <div>
                                <dt class="text-sm text-gray-500">Nom du parent</dt>
                                <dd>{{ $student->parent_name ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm text-gray-500">Téléphone du parent</dt>
                                <dd>{{ $student->parent_phone ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    <a href="{{ route('students.edit', $student) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Modifier</a>
                    <a href="{{ route('documents.attestation', $student) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Attestation d'inscription</a>
                    <a href="{{ route('documents.scolarite', $student) }}" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Certificat de scolarité</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
