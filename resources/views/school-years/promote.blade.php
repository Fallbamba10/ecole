<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Passage de classe</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <strong>Attention :</strong> Cette action déplacera tous les élèves actifs d'une classe vers une autre.
                        Cette opération est irréversible.
                    </p>
                </div>

                <form method="POST" action="{{ route('school-years.promote') }}" onsubmit="return confirm('Confirmer le passage de classe ? Cette action est irréversible.')">
                    @csrf

                    @foreach($classrooms as $index => $classroom)
                        <div class="flex items-center gap-4 mb-4 p-3 bg-gray-50 rounded">
                            <input type="hidden" name="promotions[{{ $index }}][from_classroom]" value="{{ $classroom->id }}">
                            <div class="flex-1">
                                <span class="font-medium">{{ $classroom->name }}</span>
                                <span class="text-sm text-gray-500">({{ $classroom->students_count }} élèves)</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                            <div class="flex-1">
                                <select name="promotions[{{ $index }}][to_classroom]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                    <option value="{{ $classroom->id }}">— Ne pas déplacer —</option>
                                    @foreach($classrooms as $target)
                                        @if($target->id !== $classroom->id)
                                            <option value="{{ $target->id }}">{{ $target->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('school-years.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Annuler</a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Valider le passage</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
