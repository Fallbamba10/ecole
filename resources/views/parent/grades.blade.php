<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notes — {{ $student->full_name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Moyennes par trimestre -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                @foreach($averages as $period => $avg)
                    <div class="bg-white rounded-lg shadow p-4 text-center">
                        <p class="text-sm text-gray-500">{{ $period }}</p>
                        @if($avg !== null)
                            <p class="text-2xl font-bold {{ $avg >= 10 ? 'text-green-600' : 'text-red-600' }}">{{ $avg }}/20</p>
                        @else
                            <p class="text-2xl font-bold text-gray-300">-</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Détail des notes par matière -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Détail par matière</h3>

                @forelse($grades as $subjectName => $subjectGrades)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 border-b pb-2 mb-3">{{ $subjectName }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach($subjectGrades as $grade)
                                <div class="bg-gray-50 rounded p-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">{{ ucfirst($grade->type) }}</span>
                                        <span class="font-bold text-lg {{ $grade->value >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $grade->value }}/{{ $grade->max_value }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $grade->period }}</div>
                                    @if($grade->comment)
                                        <div class="text-xs text-gray-500 mt-1 italic">{{ $grade->comment }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">Aucune note enregistrée.</p>
                @endforelse
            </div>

            <div class="mt-4">
                <a href="{{ route('parent.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Retour au portail</a>
            </div>
        </div>
    </div>
</x-app-layout>
