<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Structure des frais</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Sélection de classe -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <form method="GET" action="{{ route('fees.index') }}" class="flex items-center gap-4">
                    <label class="font-medium text-gray-700">Classe :</label>
                    <select name="classroom_id" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ $selectedClassroom && $selectedClassroom->id == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($selectedClassroom)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Définition des frais -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="font-semibold text-lg mb-4">Frais pour {{ $selectedClassroom->name }}</h3>

                        @if($fees->count())
                            <table class="w-full text-sm mb-4">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-2">Désignation</th>
                                        <th class="text-right py-2">Montant</th>
                                        <th class="text-right py-2">× Fois</th>
                                        <th class="text-right py-2">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fees as $fee)
                                        <tr class="border-b">
                                            <td class="py-2">{{ $fee->label }}</td>
                                            <td class="text-right">{{ number_format($fee->amount, 0, ',', ' ') }}</td>
                                            <td class="text-right">{{ $fee->occurrences }}</td>
                                            <td class="text-right font-medium">{{ number_format($fee->total, 0, ',', ' ') }}</td>
                                            <td class="text-right">
                                                <form action="{{ route('fees.destroy', $fee) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs">×</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold">
                                        <td class="pt-3" colspan="3">Total annuel dû par élève</td>
                                        <td class="pt-3 text-right text-blue-600">{{ number_format($fees->sum(fn($f) => $f->total), 0, ',', ' ') }} FCFA</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <p class="text-gray-500 text-sm mb-4">Aucun frais défini pour cette classe.</p>
                        @endif

                        <!-- Formulaire ajout -->
                        <form method="POST" action="{{ route('fees.store') }}" class="border-t pt-4 mt-4">
                            @csrf
                            <input type="hidden" name="classroom_id" value="{{ $selectedClassroom->id }}">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <input type="text" name="label" placeholder="Ex: Mensualité" required
                                        class="w-full text-sm rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <select name="type" required class="w-full text-sm rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="inscription">Inscription</option>
                                        <option value="mensualite">Mensualité</option>
                                        <option value="frais_examen">Frais d'examen</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                                <div>
                                    <input type="number" name="amount" placeholder="Montant" required min="1"
                                        class="w-full text-sm rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <input type="number" name="occurrences" value="1" min="1" max="12" required
                                        class="w-full text-sm rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Nb occurrences">
                                </div>
                            </div>
                            <button type="submit" class="mt-3 bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Ajouter
                            </button>
                        </form>
                    </div>

                    <!-- Situation par élève -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="font-semibold text-lg mb-4">Situation des élèves</h3>

                        @if($students->count())
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($students as $student)
                                    <div class="flex items-center justify-between p-3 rounded border {{ $student->balance <= 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                        <div>
                                            <div class="font-medium text-sm">{{ $student->full_name }}</div>
                                            <div class="text-xs text-gray-500">
                                                Payé: {{ number_format($student->total_paid_amount, 0, ',', ' ') }} / {{ number_format($student->total_due, 0, ',', ' ') }} FCFA
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($student->balance <= 0)
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded font-medium">À jour</span>
                                            @else
                                                <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded font-medium">
                                                    Reste: {{ number_format($student->balance, 0, ',', ' ') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Aucun élève dans cette classe.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
