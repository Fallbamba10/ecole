<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Paiements — {{ $student->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Résumé -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total payé</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($totalPaid, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Reste à payer</p>
                    <p class="text-2xl font-bold {{ $totalPending > 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($totalPending, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>

            <!-- Historique -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Historique des paiements</h3>

                    @if($payments->isEmpty())
                        <p class="text-gray-500 text-center py-4">Aucun paiement enregistré.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Montant</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-600">
                                                {{ $payment->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-800">
                                                {{ $payment->description ?? 'Frais de scolarité' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-right font-medium">
                                                {{ number_format($payment->amount, 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                @if($payment->status === 'paye')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Payé</span>
                                                @elseif($payment->status === 'en_attente')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">En attente</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">En retard</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('parent.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Retour au portail</a>
            </div>
        </div>
    </div>
</x-app-layout>
