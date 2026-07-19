<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Créer un compte parent</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ route('parents.store') }}">
                    @csrf

                    <!-- Choix de l'élève -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Élève concerné</label>
                        <select name="student_id" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Sélectionner un élève --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }} ({{ $student->classroom->name ?? '?' }}){{ $student->parent_phone ? ' — ' . $student->parent_phone : '' }}{{ $student->parent_email ? ' — ' . $student->parent_email : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Téléphone du parent -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone du parent</label>
                        <input type="text" name="parent_phone" value="{{ old('parent_phone') }}" placeholder="Ex: 77 123 45 67" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <p class="text-xs text-gray-400 mt-1">Remplir si le téléphone n'est pas déjà dans la fiche élève. Servira d'identifiant de connexion.</p>
                    </div>

                    <!-- Méthode -->
                    <div class="mb-6" x-data="{ method: '{{ old('method', 'create_direct') }}' }">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Méthode</label>

                        <div class="space-y-3">
                            <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer" :class="method === 'create_direct' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                                <input type="radio" name="method" value="create_direct" x-model="method" class="mt-0.5">
                                <div>
                                    <div class="font-medium text-gray-800">Créer le compte directement</div>
                                    <p class="text-sm text-gray-500">Vous définissez le mot de passe et donnez les identifiants au parent en main propre.</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer" :class="method === 'send_invitation' ? 'border-blue-500 bg-blue-50' : 'border-gray-200'">
                                <input type="radio" name="method" value="send_invitation" x-model="method" class="mt-0.5">
                                <div>
                                    <div class="font-medium text-gray-800">Envoyer un lien d'inscription</div>
                                    <p class="text-sm text-gray-500">Un lien unique est généré (valable 7 jours). Le parent choisit lui-même son mot de passe.</p>
                                </div>
                            </label>
                        </div>

                        <!-- Mot de passe (si création directe) -->
                        <div x-show="method === 'create_direct'" class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                            <input type="text" name="password" value="{{ old('password') }}" placeholder="Ex: parent123" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-400 mt-1">Le parent pourra le changer plus tard depuis son profil.</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Confirmer
                        </button>
                        <a href="{{ route('parents.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
