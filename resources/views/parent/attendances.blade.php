<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Présences — {{ $student->full_name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats résumé -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['rate'] }}%</p>
                    <p class="text-xs text-gray-500">Taux de présence</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['present'] }}</p>
                    <p class="text-xs text-gray-500">Jours présent</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $stats['absent'] }}</p>
                    <p class="text-xs text-gray-500">Absences</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['late'] }}</p>
                    <p class="text-xs text-gray-500">Retards</p>
                </div>
            </div>

            <!-- Historique -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Historique (60 derniers jours)</h3>

                @forelse($attendances as $attendance)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l d/m/Y') }}</span>
                        <span class="px-2 py-1 rounded text-xs font-medium
                            @if($attendance->status === 'present') bg-green-100 text-green-800
                            @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                            @elseif($attendance->status === 'retard') bg-yellow-100 text-yellow-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">Aucune donnée de présence.</p>
                @endforelse
            </div>

            <div class="mt-4">
                <a href="{{ route('parent.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Retour au portail</a>
            </div>
        </div>
    </div>
</x-app-layout>
