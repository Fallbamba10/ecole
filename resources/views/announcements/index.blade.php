<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Annonces</h2>
            <a href="{{ route('announcements.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nouvelle annonce
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($announcements as $announcement)
                <div class="bg-white rounded-lg shadow mb-4 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $announcement->title }}</h3>
                            <div class="flex gap-2 mt-1 text-sm text-gray-500">
                                <span>Par {{ $announcement->author->name }}</span>
                                <span>&middot;</span>
                                <span>{{ $announcement->created_at->diffForHumans() }}</span>
                                <span>&middot;</span>
                                @if($announcement->target === 'all')
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">Toute l'école</span>
                                @else
                                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs">{{ $announcement->classroom->name ?? '' }}</span>
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('announcements.destroy', $announcement) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline text-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </div>
                    <p class="mt-3 text-gray-700 whitespace-pre-line">{{ $announcement->content }}</p>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Aucune annonce pour le moment.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
