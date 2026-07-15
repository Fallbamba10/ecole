<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reçu de paiement</h2>
            <a href="{{ route('payments.index') }}" class="text-blue-600 hover:underline">&larr; Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8" id="receipt">
                <!-- En-tête du reçu -->
                <div class="text-center border-b pb-4 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">REÇU DE PAIEMENT</h1>
                    <p class="text-gray-500 text-sm mt-1">N° {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-gray-500 text-sm">Date : {{ $payment->created_at->format('d/m/Y à H:i') }}</p>
                </div>

                <!-- Infos étudiant -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase mb-2">Étudiant</h3>
                    <p class="font-semibold text-lg">{{ $payment->student->full_name }}</p>
                    <p class="text-gray-600">Classe : {{ $payment->student->classroom->name ?? 'N/A' }}</p>
                </div>

                <!-- Détails du paiement -->
                <div class="border rounded-lg p-4 mb-6">
                    <table class="w-full">
                        <tr class="border-b">
                            <td class="py-2 text-gray-500">Type</td>
                            <td class="py-2 text-right font-medium">{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 text-gray-500">Mode de paiement</td>
                            <td class="py-2 text-right font-medium">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 text-gray-500">Statut</td>
                            <td class="py-2 text-right">
                                @if($payment->status === 'paye')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Payé</span>
                                @elseif($payment->status === 'en_attente')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">En retard</span>
                                @endif
                            </td>
                        </tr>
                        @if($payment->paid_at)
                        <tr class="border-b">
                            <td class="py-2 text-gray-500">Payé le</td>
                            <td class="py-2 text-right font-medium">{{ $payment->paid_at->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        @if($payment->due_date)
                        <tr class="border-b">
                            <td class="py-2 text-gray-500">Échéance</td>
                            <td class="py-2 text-right font-medium">{{ $payment->due_date->format('d/m/Y') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="py-3 text-gray-700 font-semibold text-lg">Montant</td>
                            <td class="py-3 text-right font-bold text-xl text-blue-600">{{ $payment->formatted_amount }}</td>
                        </tr>
                    </table>
                </div>

                @if($payment->note)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500">Note : {{ $payment->note }}</p>
                    </div>
                @endif
            </div>

            <!-- Bouton imprimer -->
            <div class="mt-4 text-center">
                <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    Imprimer le reçu
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
