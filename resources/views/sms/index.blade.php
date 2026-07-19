<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">SMS aux parents</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6">
                <form method="POST" action="{{ route('sms.send') }}" x-data="{ target: 'all' }">
                    @csrf

                    <!-- Destinataires -->
                    <div class="mb-6">
                        <label class="block font-medium text-gray-700 mb-2">Destinataires</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="target" value="all" x-model="target" class="text-blue-600">
                                <span>Tous les parents</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="target" value="classroom" x-model="target" class="text-blue-600">
                                <span>Une classe</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="target" value="individual" x-model="target" class="text-blue-600">
                                <span>Un élève</span>
                            </label>
                        </div>
                    </div>

                    <!-- Sélection classe -->
                    <div class="mb-6" x-show="target === 'classroom'" x-cloak>
                        <label class="block font-medium text-gray-700 mb-2">Classe</label>
                        <select name="classroom_id" class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Choisir une classe --</option>
                            @foreach($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->name }} ({{ $classroom->students_count }} élèves)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sélection élève -->
                    <div class="mb-6" x-show="target === 'individual'" x-cloak>
                        <label class="block font-medium text-gray-700 mb-2">Élève (ID)</label>
                        <input type="number" name="student_id" placeholder="ID de l'élève"
                            class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label class="block font-medium text-gray-700 mb-2">Message (160 caractères max)</label>
                        <textarea name="message" rows="4" maxlength="160" required
                            class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Ex: Cher {parent}, votre enfant {eleve} en {classe} a un paiement en retard. Merci de régulariser."></textarea>
                        <p class="text-xs text-gray-500 mt-1">
                            Variables disponibles : <code>{eleve}</code>, <code>{classe}</code>, <code>{parent}</code>
                        </p>
                    </div>

                    @error('message')
                        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                    @enderror

                    <!-- Info provider -->
                    <div class="mb-6 p-3 bg-blue-50 border border-blue-200 rounded text-sm text-blue-700">
                        @if(config('services.sms.provider') === 'log')
                            <strong>Mode test :</strong> Les SMS sont enregistrés dans les logs (pas d'envoi réel).
                            Configurez <code>SERVICES_SMS_PROVIDER</code> dans <code>.env</code> pour activer l'envoi réel (orange, twilio).
                        @else
                            Provider actif : <strong>{{ config('services.sms.provider') }}</strong>
                        @endif
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded"
                        onclick="return confirm('Confirmer l\'envoi des SMS ?')">
                        Envoyer les SMS
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
