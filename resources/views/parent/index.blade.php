<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Portail Parents</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats rapides -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Mes enfants</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $students->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 {{ $todayAbsences > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-full">
                            <svg class="w-6 h-6 {{ $todayAbsences > 0 ? 'text-red-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Absences aujourd'hui</p>
                            <p class="text-2xl font-bold {{ $todayAbsences > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $todayAbsences }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 {{ $unpaidPayments > 0 ? 'bg-orange-100' : 'bg-green-100' }} rounded-full">
                            <svg class="w-6 h-6 {{ $unpaidPayments > 0 ? 'text-orange-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Solde impayé</p>
                            <p class="text-2xl font-bold {{ $unpaidPayments > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                {{ number_format($unpaidPayments, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mes enfants -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold mb-4">Mes enfants</h3>

                @forelse($students as $student)
                    <div class="border rounded-lg p-4 mb-4 hover:bg-gray-50">
                        <div class="flex justify-between items-center flex-wrap gap-3">
                            <div>
                                <div class="font-medium text-lg">{{ $student->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $student->classroom->name ?? 'Non assigné' }}</div>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('parent.grades', $student) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200">
                                    Notes
                                </a>
                                <a href="{{ route('parent.attendances', $student) }}" class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm hover:bg-green-200">
                                    Présences
                                </a>
                                <a href="{{ route('parent.payments', $student) }}" class="bg-orange-100 text-orange-700 px-3 py-1 rounded text-sm hover:bg-orange-200">
                                    Paiements
                                </a>
                                <a href="{{ route('parent.bulletin', ['student' => $student, 'period' => 'Trimestre 1']) }}" class="bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm hover:bg-purple-200">
                                    Bulletin
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">
                        Aucun enfant associé à votre compte. Contactez l'administration de l'école.
                    </p>
                @endforelse
            </div>

            <!-- Dernières notes -->
            @if($recentGrades->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Dernières notes</h3>
                <div class="space-y-3">
                    @foreach($recentGrades as $grade)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <span class="font-medium">{{ $grade->student->full_name }}</span>
                                <span class="text-gray-500 text-sm ml-2">{{ $grade->subject->name }}</span>
                            </div>
                            <span class="font-bold {{ $grade->value >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $grade->value }}/{{ $grade->max_value }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
