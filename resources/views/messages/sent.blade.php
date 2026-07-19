<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Messages envoyes</h2>
            <div class="flex gap-2">
                <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Boite de reception
                </a>
                <a href="{{ route('messages.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Nouveau message
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($messages as $message)
                <a href="{{ route('messages.show', $message) }}" class="block bg-white rounded-lg shadow mb-3 p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-semibold text-gray-800">
                                    {{ $message->subject }}
                                </h3>
                                @if($message->is_broadcast)
                                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs">Diffusion</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                A :
                                @if($message->is_broadcast)
                                    <span class="font-medium">Groupe ({{ $message->recipients->count() }} destinataires)</span>
                                @else
                                    <span class="font-medium">
                                        {{ $message->recipients->take(3)->map(fn($r) => $r->recipient->name)->join(', ') }}
                                        @if($message->recipients->count() > 3)
                                            et {{ $message->recipients->count() - 3 }} autre(s)
                                        @endif
                                    </span>
                                @endif
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 whitespace-nowrap ml-4">
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-2 line-clamp-1">{{ Str::limit($message->body, 100) }}</p>
                </a>
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Aucun message envoye.
                </div>
            @endforelse

            <div class="mt-4">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
