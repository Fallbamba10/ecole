<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Boite de reception</h2>
            <div class="flex gap-2">
                <a href="{{ route('messages.sent') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Messages envoyes
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
                @php
                    $recipientEntry = $message->recipients->first();
                    $isUnread = $recipientEntry && !$recipientEntry->read_at;
                @endphp
                <a href="{{ route('messages.show', $message) }}" class="block bg-white rounded-lg shadow mb-3 p-4 hover:shadow-md transition {{ $isUnread ? 'border-l-4 border-blue-500' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                @if($isUnread)
                                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                @endif
                                <h3 class="text-base font-semibold text-gray-800 {{ $isUnread ? 'font-bold' : '' }}">
                                    {{ $message->subject }}
                                </h3>
                                @if($message->is_broadcast)
                                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-xs">Diffusion</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                De : <span class="font-medium">{{ $message->sender->name }}</span>
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
                    Aucun message dans votre boite de reception.
                </div>
            @endforelse

            <div class="mt-4">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
