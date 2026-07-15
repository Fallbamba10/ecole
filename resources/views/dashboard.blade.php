<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900">Tableau de bord</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">Élèves</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalStudents }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $totalClassrooms }} classes</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">Encaissé</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($totalPaye, 0, ',', ' ') }}</p>
                    <p class="text-xs text-gray-400 mt-1">FCFA</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">Taux de présence</p>
                    <p class="text-2xl font-bold {{ $tauxPresence >= 80 ? 'text-green-600' : 'text-red-600' }} mt-1">{{ $tauxPresence }}%</p>
                    <p class="text-xs text-gray-400 mt-1">30 derniers jours</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <p class="text-xs font-medium text-gray-500 uppercase">En retard</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($totalEnRetard, 0, ',', ' ') }}</p>
                    <p class="text-xs text-gray-400 mt-1">FCFA — {{ $absentToday }} absent(s) auj.</p>
                </div>
            </div>

            <!-- Graphique + Retards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900 text-sm">Encaissements (6 mois)</h3>
                    </div>
                    <canvas id="paymentsChart" height="160"></canvas>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900 text-sm">Paiements en retard</h3>
                        <a href="{{ route('payments.index', ['status' => 'en_retard']) }}" class="text-xs text-blue-600 hover:underline">Voir tout</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($paymentsEnRetard as $payment)
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $payment->student->full_name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $payment->student->classroom->name ?? '' }}</p>
                                </div>
                                <span class="text-sm font-semibold text-red-600">{{ number_format($payment->amount, 0, ',', ' ') }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 text-center py-4">Aucun retard</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Derniers inscrits -->
            <div class="bg-white rounded-xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 text-sm">Derniers inscrits</h3>
                    <a href="{{ route('students.index') }}" class="text-xs text-blue-600 hover:underline">Voir tout</a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                    @foreach($recentStudents as $student)
                        <a href="{{ route('students.show', $student) }}" class="text-center p-3 rounded-lg hover:bg-gray-50 transition">
                            <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-xs font-bold text-blue-700">{{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}</span>
                            </div>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $student->first_name }}</p>
                            <p class="text-xs text-gray-400">{{ $student->classroom->name ?? '-' }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('paymentsChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.12)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($paymentsPerMonth, 'month')) !!},
                datasets: [{
                    label: 'FCFA',
                    data: {!! json_encode(array_column($paymentsPerMonth, 'amount')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.03)' },
                        ticks: {
                            font: { size: 11 },
                            callback: v => (v/1000) + 'K'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
