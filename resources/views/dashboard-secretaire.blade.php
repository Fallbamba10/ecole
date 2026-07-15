<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Espace Secrétariat</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats paiements -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Total élèves</p>
                    <p class="text-2xl font-bold">{{ $totalStudents }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">Encaissé</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($totalPaye, 0, ',', ' ') }} F</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">En attente</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($totalEnAttente, 0, ',', ' ') }} F</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-sm text-gray-500">En retard</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($totalEnRetard, 0, ',', ' ') }} F</p>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h3 class="font-semibold text-lg mb-4">Actions rapides</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('payments.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                        + Enregistrer un paiement
                    </a>
                    <a href="{{ route('fees.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Structure des frais
                    </a>
                    <a href="{{ route('students.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">
                        Liste des élèves
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Paiements en retard -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-lg mb-4 text-red-600">Paiements en retard</h3>
                    @if($paymentsEnRetard->count())
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @foreach($paymentsEnRetard as $payment)
                                <div class="flex justify-between items-center p-3 bg-red-50 border border-red-100 rounded">
                                    <div>
                                        <div class="font-medium text-sm">{{ $payment->student->full_name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->student->classroom->name ?? '' }} — {{ $payment->description ?? 'Paiement' }}</div>
                                    </div>
                                    <span class="font-bold text-red-600 text-sm">{{ number_format($payment->amount, 0, ',', ' ') }} F</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Aucun paiement en retard.</p>
                    @endif
                </div>

                <!-- Derniers paiements reçus -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-lg mb-4 text-green-600">Derniers paiements reçus</h3>
                    @if($recentPayments->count())
                        <div class="space-y-3 max-h-80 overflow-y-auto">
                            @foreach($recentPayments as $payment)
                                <div class="flex justify-between items-center p-3 bg-green-50 border border-green-100 rounded">
                                    <div>
                                        <div class="font-medium text-sm">{{ $payment->student->full_name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->student->classroom->name ?? '' }} — {{ $payment->paid_at?->format('d/m/Y') }}</div>
                                    </div>
                                    <span class="font-bold text-green-600 text-sm">{{ number_format($payment->amount, 0, ',', ' ') }} F</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Aucun paiement récent.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
