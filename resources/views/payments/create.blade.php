<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Enregistrer un paiement</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="student_id" class="block text-sm font-medium text-gray-700">Étudiant *</label>
                            <select name="student_id" id="student_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Sélectionner --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->full_name }} ({{ $student->classroom->name ?? 'Sans classe' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Montant (FCFA) *</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type *</label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="mensualite" {{ old('type') === 'mensualite' ? 'selected' : '' }}>Mensualité</option>
                                <option value="inscription" {{ old('type') === 'inscription' ? 'selected' : '' }}>Inscription</option>
                                <option value="frais_examen" {{ old('type') === 'frais_examen' ? 'selected' : '' }}>Frais d'examen</option>
                                <option value="autre" {{ old('type') === 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Mode de paiement *</label>
                            <select name="payment_method" id="payment_method" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="especes" {{ old('payment_method') === 'especes' ? 'selected' : '' }}>Espèces</option>
                                <option value="orange_money" {{ old('payment_method') === 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                                <option value="wave" {{ old('payment_method') === 'wave' ? 'selected' : '' }}>Wave</option>
                                <option value="virement" {{ old('payment_method') === 'virement' ? 'selected' : '' }}>Virement</option>
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut *</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="paye" {{ old('status') === 'paye' ? 'selected' : '' }}>Payé</option>
                                <option value="en_attente" {{ old('status') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="en_retard" {{ old('status') === 'en_retard' ? 'selected' : '' }}>En retard</option>
                            </select>
                        </div>

                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Date d'échéance</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="paid_at" class="block text-sm font-medium text-gray-700">Date de paiement</label>
                            <input type="date" name="paid_at" id="paid_at" value="{{ old('paid_at', date('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                        <textarea name="note" id="note" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('payments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Annuler</a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
