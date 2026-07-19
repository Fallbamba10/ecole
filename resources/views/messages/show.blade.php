<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Message</h2>
            <a href="{{ route('messages.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                &larr; Retour a la boite de reception
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                {{-- En-tete du message --}}
                <div class="border-b border-gray-200 pb-4 mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $message->subject }}</h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">De :</span> {{ $message->sender->name }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">A :</span>
                            @if($message->is_broadcast)
                                Groupe ({{ $message->recipients->count() }} destinataires)
                            @else
                                {{ $message->recipients->map(fn($r) => $r->recipient->name)->join(', ') }}
                            @endif
                        </p>
                        <p class="text-sm text-gray-400">
                            {{ $message->created_at->format('d/m/Y H:i') }}
                            ({{ $message->created_at->diffForHumans() }})
                        </p>
                    </div>
                    @if($message->is_broadcast)
                        <span class="inline-block mt-2 px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs">Diffusion</span>
                    @endif
                </div>

                {{-- Corps du message --}}
                <div class="prose max-w-none text-gray-700 whitespace-pre-line">{{ $message->body }}</div>

                {{-- Actions --}}
                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <div class="flex gap-2">
                        @unless($isSender)
                            <a href="{{ route('messages.create') }}?reply_to={{ $message->sender_id }}&subject=Re: {{ urlencode($message->subject) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Repondre
                            </a>
                        @endunless
                    </div>
                    <form action="{{ route('messages.destroy', $message) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Supprimer ce message ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
