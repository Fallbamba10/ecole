<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Emploi du temps</h2>
            <a href="{{ route('timetable.create', ['classroom_id' => $selectedClassroom?->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter un créneau
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Sélection de classe -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <form method="GET" action="{{ route('timetable.index') }}" class="flex items-center gap-4">
                    <label class="font-medium text-gray-700">Classe :</label>
                    <select name="classroom_id" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ $selectedClassroom && $selectedClassroom->id == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Emploi du temps -->
            @if($selectedClassroom)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                                @foreach($days as $day)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ ucfirst($day) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $timeSlots = ['08:00', '09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];
                            @endphp
                            @foreach($timeSlots as $time)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-700 whitespace-nowrap">{{ $time }}</td>
                                    @foreach($days as $day)
                                        <td class="px-4 py-3 text-sm">
                                            @if(isset($slots[$day]))
                                                @foreach($slots[$day] as $slot)
                                                    @if($slot->start_time <= $time.':00' && $slot->end_time > $time.':00')
                                                        <div class="bg-blue-100 border-l-4 border-blue-500 p-2 rounded text-xs mb-1">
                                                            <div class="font-semibold text-blue-800">{{ $slot->subject->name }}</div>
                                                            @if($slot->teacher_name)
                                                                <div class="text-gray-600">{{ $slot->teacher_name }}</div>
                                                            @endif
                                                            @if($slot->room)
                                                                <div class="text-gray-500">Salle: {{ $slot->room }}</div>
                                                            @endif
                                                            <div class="text-gray-400">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</div>
                                                            <form action="{{ route('timetable.destroy', $slot) }}" method="POST" class="mt-1" onsubmit="return confirm('Supprimer ce créneau ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Supprimer</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white p-8 rounded-lg shadow-sm text-center text-gray-500">
                    Aucune classe trouvée. Créez d'abord des classes.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
