<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Comptes Parents</h2>
            <a href="{{ route('parents.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition text-center">
                + Nouveau compte parent
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Invitations en attente -->
            @if($invitations->isNotEmpty())
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="font-semibold text-gray-800 mb-4">Invitations en attente</h3>
                <div class="space-y-3">
                    @foreach($invitations as $invitation)
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 border rounded-lg p-3 bg-yellow-50 border-yellow-200">
                            <div>
                                <span class="font-medium">{{ $invitation->student->full_name }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ $invitation->phone ?? $invitation->email }}</span>
                                <br class="sm:hidden">
                                <span class="text-xs text-yellow-600 sm:ml-2">Expire {{ $invitation->expires_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-xs text-gray-500">
                                <button onclick="navigator.clipboard.writeText('{{ route('parent.register', $invitation->token) }}')" class="bg-gray-100 hover:bg-gray-200 px-2 py-1 rounded transition">
                                    Copier le lien
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Liste des parents -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Parents inscrits ({{ $parents->count() }})</h3>

                @forelse($parents as $parent)
                    <div class="flex justify-between items-center border-b py-3 last:border-0">
                        <div>
                            <div class="font-medium text-gray-800">{{ $parent->name }}</div>
                            <div class="text-sm text-gray-500">{{ $parent->email }} {{ $parent->phone ? '· ' . $parent->phone : '' }}</div>
                        </div>
                        <form method="POST" action="{{ route('parents.destroy', $parent) }}" onsubmit="return confirm('Supprimer ce compte parent ?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-sm">Supprimer</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-6">Aucun compte parent créé pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
