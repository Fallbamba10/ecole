<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 focus:outline-none transition">
        <span class="mr-1">
            @if(app()->getLocale() === 'fr')
                🇫🇷 FR
            @else
                🇬🇧 EN
            @endif
        </span>
        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 z-50 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
         style="display: none;"
         @click="open = false">
        <div class="py-1">
            <a href="{{ route('language.switch', 'fr') }}"
               class="flex items-center px-4 py-2 text-sm {{ app()->getLocale() === 'fr' ? 'text-indigo-600 bg-indigo-50 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                <span class="mr-2">🇫🇷</span> {{ __('app.french') }}
            </a>
            <a href="{{ route('language.switch', 'en') }}"
               class="flex items-center px-4 py-2 text-sm {{ app()->getLocale() === 'en' ? 'text-indigo-600 bg-indigo-50 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                <span class="mr-2">🇬🇧</span> {{ __('app.english') }}
            </a>
        </div>
    </div>
</div>
