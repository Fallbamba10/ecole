<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mon espace enseignant</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                            <p class="text-sm text-gray-500">Mes élèves</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalStudents }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Mes classes</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $classrooms->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Absents aujourd'hui</p>
                            <p class="text-2xl font-bold text-red-600">{{ $absentToday }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h3 class="font-semibold text-lg text-gray-700 mb-4">Actions rapides</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <a href="{{ route('grades.batch') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                        <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span class="text-sm font-medium text-purple-700">Saisie en masse</span>
                    </a>
                    <a href="{{ route('attendances.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-green-700">Faire l'appel</span>
                    </a>
                    <a href="{{ route('announcements.create') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                        <svg class="w-8 h-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <span class="text-sm font-medium text-orange-700">Annonce</span>
                    </a>
                    <a href="{{ route('timetable.index') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium text-blue-700">Emploi du temps</span>
                    </a>
                </div>
            </div>

            <!-- Mes classes -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-lg text-gray-700 mb-4">Mes classes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($classrooms as $classroom)
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-bold text-lg text-gray-800">{{ $classroom->name }}</h4>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ $classroom->students_count }} élèves</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('attendances.index', ['classroom_id' => $classroom->id]) }}" class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded hover:bg-green-100">
                                    Faire l'appel
                                </a>
                                <a href="{{ route('grades.batch', ['classroom_id' => $classroom->id]) }}" class="text-xs bg-purple-50 text-purple-700 px-3 py-1 rounded hover:bg-purple-100">
                                    Saisie en masse
                                </a>
                                <a href="{{ route('grades.index', ['classroom_id' => $classroom->id]) }}" class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1 rounded hover:bg-indigo-100">
                                    Voir les notes
                                </a>
                                <a href="{{ route('students.index', ['classroom_id' => $classroom->id]) }}" class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded hover:bg-blue-100">
                                    Voir les élèves
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
