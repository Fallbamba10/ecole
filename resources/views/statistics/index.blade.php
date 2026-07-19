<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Statistiques</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-sm text-gray-500">Taux de recouvrement</p>
                    <p class="text-3xl font-bold {{ $recoveryRate >= 70 ? 'text-green-600' : ($recoveryRate >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $recoveryRate }}%
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-sm text-gray-500">Paiements payés</p>
                    <p class="text-3xl font-bold text-green-600">{{ $paymentStats['paye'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-sm text-gray-500">Paiements en retard</p>
                    <p class="text-3xl font-bold text-red-600">{{ $paymentStats['en_retard'] }}</p>
                </div>
            </div>

            <!-- Graphiques ligne 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Revenus mensuels -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Revenus mensuels (12 mois)</h3>
                    <canvas id="revenueChart" height="200"></canvas>
                </div>

                <!-- Présences -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Présences (30 derniers jours)</h3>
                    <canvas id="attendanceChart" height="200"></canvas>
                </div>
            </div>

            <!-- Graphiques ligne 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Moyennes par classe -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Moyenne par classe</h3>
                    <canvas id="classAverageChart" height="200"></canvas>
                </div>

                <!-- Répartition élèves -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Répartition des élèves</h3>
                    <canvas id="studentsChart" height="200"></canvas>
                </div>
            </div>

            <!-- Statuts paiements -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Statut des paiements</h3>
                    <canvas id="paymentStatusChart" height="200"></canvas>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const colors = {
            blue: 'rgb(59, 130, 246)',
            green: 'rgb(34, 197, 94)',
            red: 'rgb(239, 68, 68)',
            yellow: 'rgb(234, 179, 8)',
            purple: 'rgb(168, 85, 247)',
            orange: 'rgb(249, 115, 22)',
            indigo: 'rgb(99, 102, 241)',
            pink: 'rgb(236, 72, 153)',
        };

        // Revenus mensuels
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($paymentsPerMonth)->pluck('month')) !!},
                datasets: [{
                    label: 'Revenus (FCFA)',
                    data: {!! json_encode(collect($paymentsPerMonth)->pluck('amount')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: colors.blue,
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: v => v.toLocaleString('fr-FR') + ' F' }
                    }
                }
            }
        });

        // Présences
        new Chart(document.getElementById('attendanceChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode(collect($attendancePerDay)->pluck('date')) !!},
                datasets: [{
                    label: 'Présents',
                    data: {!! json_encode(collect($attendancePerDay)->pluck('present')) !!},
                    borderColor: colors.green,
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    fill: true,
                    tension: 0.3,
                }, {
                    label: 'Absents',
                    data: {!! json_encode(collect($attendancePerDay)->pluck('absent')) !!},
                    borderColor: colors.red,
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Moyennes par classe
        new Chart(document.getElementById('classAverageChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($classAverages)->pluck('name')) !!},
                datasets: [{
                    label: 'Moyenne /20',
                    data: {!! json_encode(collect($classAverages)->pluck('average')) !!},
                    backgroundColor: {!! json_encode(collect($classAverages)->map(fn($c) => $c['average'] >= 10 ? 'rgba(34, 197, 94, 0.7)' : 'rgba(239, 68, 68, 0.7)')) !!},
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, max: 20 }
                }
            }
        });

        // Répartition élèves (doughnut)
        new Chart(document.getElementById('studentsChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(collect($studentsPerClass)->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode(collect($studentsPerClass)->pluck('count')) !!},
                    backgroundColor: [colors.blue, colors.green, colors.purple, colors.orange, colors.pink, colors.indigo, colors.yellow, colors.red],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Statuts paiements (pie)
        new Chart(document.getElementById('paymentStatusChart'), {
            type: 'pie',
            data: {
                labels: ['Payé', 'En attente', 'En retard'],
                datasets: [{
                    data: [{{ $paymentStats['paye'] }}, {{ $paymentStats['en_attente'] }}, {{ $paymentStats['en_retard'] }}],
                    backgroundColor: [colors.green, colors.yellow, colors.red],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
