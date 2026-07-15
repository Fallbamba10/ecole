<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-900">Élèves</h2>
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nouvel élève
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtres -->
            <div class="bg-white rounded-xl border border-gray-100 p-4 mb-4">
                <form method="GET" action="{{ route('students.index') }}" class="flex flex-wrap items-center gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un élève..."
                        class="flex-1 min-w-[200px] px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <select name="classroom_id" class="px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="">Toutes les classes</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">Filtrer</button>
                    @if(request('search') || request('classroom_id'))
                        <a href="{{ route('students.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Réinitialiser</a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                @if($students->isEmpty())
                    <p class="text-gray-400 text-center py-12 text-sm">Aucun élève trouvé.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Élève</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Classe</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Parent</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($students as $student)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center shrink-0">
                                                    <span class="text-xs font-bold text-blue-700">{{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $student->last_name }} {{ $student->first_name }}</p>
                                                    <p class="text-xs text-gray-400">{{ $student->gender === 'M' ? 'Garçon' : 'Fille' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">{{ $student->classroom->name ?? '—' }}</td>
                                        <td class="px-5 py-3">
                                            <p class="text-sm text-gray-600">{{ $student->parent_name ?? '—' }}</p>
                                            @if($student->parent_phone)
                                                <p class="text-xs text-gray-400">{{ $student->parent_phone }}</p>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3">
                                            @php
                                                $statusColors = [
                                                    'actif' => 'bg-green-50 text-green-700',
                                                    'suspendu' => 'bg-yellow-50 text-yellow-700',
                                                    'transfere' => 'bg-gray-100 text-gray-600',
                                                    'diplome' => 'bg-blue-50 text-blue-700',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $statusColors[$student->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                {{ ucfirst($student->status ?? 'actif') }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('students.show', $student) }}" class="text-gray-400 hover:text-blue-600 transition" title="Voir">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                                <a href="{{ route('students.edit', $student) }}" class="text-gray-400 hover:text-yellow-600 transition" title="Modifier">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet élève ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Supprimer">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($students->hasPages())
                        <div class="px-5 py-3 border-t border-gray-100">
                            {{ $students->links() }}
                        </div>
                    @endif
                @endif
            </div>

            <!-- Compteur -->
            <p class="mt-3 text-xs text-gray-400">{{ $students->total() }} élève(s) au total</p>
        </div>
    </div>
</x-app-layout>
