<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Super Admin — Vue globale</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats globales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $totalSchools }}</p>
                    <p class="text-sm text-gray-500 mt-1">Écoles</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $activeSchools }}</p>
                    <p class="text-sm text-gray-500 mt-1">Actives</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</p>
                    <p class="text-sm text-gray-500 mt-1">Utilisateurs</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600">{{ $totalStudents }}</p>
                    <p class="text-sm text-gray-500 mt-1">Étudiants (total)</p>
                </div>
            </div>

            <!-- Répartition par plan -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h3 class="font-semibold text-gray-700 mb-4">Répartition par plan</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(['trial' => 'Essai', 'basic' => 'Basic', 'standard' => 'Standard', 'premium' => 'Premium'] as $key => $label)
                        <div class="text-center p-4 border rounded-lg">
                            <p class="text-2xl font-bold">{{ $plans[$key]->count ?? 0 }}</p>
                            <p class="text-sm text-gray-500">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Liste des écoles -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 flex justify-between items-center border-b">
                    <h3 class="font-semibold text-gray-700">Écoles enregistrées</h3>
                    <a href="{{ route('super-admin.schools.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                        + Ajouter une école
                    </a>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">École</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Plan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Élèves</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Classes</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($schools as $school)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-medium">{{ $school->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $school->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $school->subscription_plan === 'trial' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $school->subscription_plan === 'basic' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $school->subscription_plan === 'standard' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $school->subscription_plan === 'premium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    ">
                                        {{ ucfirst($school->subscription_plan) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">{{ $school->students_count }}</td>
                                <td class="px-6 py-4 text-center">{{ $school->classrooms_count }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($school->is_active)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Actif</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Suspendu</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('super-admin.schools.edit', $school) }}" class="text-blue-600 hover:underline text-sm">Modifier</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
