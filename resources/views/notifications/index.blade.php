<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notifications
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="ml-2 px-2 py-1 text-xs bg-red-500 text-white rounded-full">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </h2>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:underline">Tout marquer comme lu</button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($notifications as $notification)
                <div class="bg-white rounded-lg shadow mb-3 p-4 flex justify-between items-center {{ $notification->read_at ? 'opacity-60' : 'border-l-4 border-blue-500' }}">
                    <div>
                        <p class="font-medium {{ $notification->read_at ? 'text-gray-500' : 'text-gray-800' }}">
                            @if($notification->data['type'] === 'absence')
                                🔴
                            @elseif($notification->data['type'] === 'payment_overdue')
                                💰
                            @elseif($notification->data['type'] === 'new_grade')
                                📝
                            @endif
                            {{ $notification->data['message'] }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    @unless($notification->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs text-blue-600 hover:underline">Marquer lu</button>
                        </form>
                    @endunless
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                    Aucune notification.
                </div>
            @endforelse

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
