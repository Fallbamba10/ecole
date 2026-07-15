<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-900">Paiements</h2>
            <a href="{{ route('payments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouveau paiement
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">Encaissé</p>
                    <p class="text-xl font-bold text-green-600 mt-1">{{ number_format($totalPaye, 0, ',', ' ') }}</p>
                    <p class="text-xs text-gray-400">FCFA</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">En attente</p>
                    <p class="text-xl font-bold text-yellow-600 mt-1">{{ number_format($totalEnAttente, 0, ',', ' ') }}</p>
                    <p class="text-xs text-gray-400">FCFA</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">En retard</p>
                    <p class="text-xl font-bold text-red-600 mt-1">{{ number_format($totalEnRetard, 0, ',', ' ') }}</p>
                    <p class="text-xs text-gray-400">FCFA</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtres -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 mb-4">
                <form method="GET" action="{{ route('payments.index') }}" class="flex flex-wrap items-center gap-3">
                    <select name="status" class="px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="paye" {{ request('status') === 'paye' ? 'selected' : '' }}>Payé</option>
                        <option value="en_attente" {{ request('status') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_retard" {{ request('status') === 'en_retard' ? 'selected' : '' }}>En retard</option>
                    </select>
                    <select name="classroom_id" class="px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Toutes les classes</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">Filtrer</button>
                    @if(request('status') || request('classroom_id') || request('student_id'))
                        <a href="{{ route('payments.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Réinitialiser</a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($payments->isEmpty())
                    <p class="text-gray-400 text-center py-12 text-sm">Aucun paiement enregistré.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Élève</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Classe</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Montant</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mode</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($payments as $payment)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $payment->student->full_name ?? '-' }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-600">{{ $payment->student->classroom->name ?? '—' }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
                                        <td class="px-5 py-3 text-sm font-semibold text-gray-900">{{ number_format($payment->amount, 0, ',', ' ') }} F</td>
                                        <td class="px-5 py-3">
                                            <span class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                        </td>
                                        <td class="px-5 py-3">
                                            @php
                                                $statusStyles = [
                                                    'paye' => 'bg-green-50 text-green-700',
                                                    'en_attente' => 'bg-yellow-50 text-yellow-700',
                                                    'en_retard' => 'bg-red-50 text-red-700',
                                                ];
                                                $statusLabels = ['paye' => 'Payé', 'en_attente' => 'En attente', 'en_retard' => 'En retard'];
                                            @endphp
                                            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $statusStyles[$payment->status] ?? '' }}">
                                                {{ $statusLabels[$payment->status] ?? $payment->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-xs text-gray-400">{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y') : ($payment->due_date ? \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') : $payment->created_at->format('d/m/Y')) }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('payments.show', $payment) }}" class="text-gray-400 hover:text-blue-600 transition" title="Reçu">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </a>
                                                <a href="{{ route('payments.edit', $payment) }}" class="text-gray-400 hover:text-yellow-600 transition" title="Modifier">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($payments->hasPages())
                        <div class="px-5 py-3 border-t border-gray-100">
                            {{ $payments->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
