<nav x-data="{ open: false, moreMenu: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="/images/logo.png" alt="SchoolManager" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Navigation Links (principaux) -->
                <div class="hidden lg:flex items-center ml-8 space-x-1">
                    @if(auth()->user()->hasRole('parent'))
                        <x-nav-link :href="route('parent.index')" :active="request()->routeIs('parent.*')">
                            Mes enfants
                        </x-nav-link>
                        <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                            Messagerie
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Tableau de bord
                        </x-nav-link>
                        <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                            Élèves
                        </x-nav-link>
                        <x-nav-link :href="route('classrooms.index')" :active="request()->routeIs('classrooms.*')">
                            Classes
                        </x-nav-link>
                        @unless(auth()->user()->hasRole('enseignant'))
                        <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')">
                            Paiements
                        </x-nav-link>
                        @endunless
                        <x-nav-link :href="route('grades.index')" :active="request()->routeIs('grades.*')">
                            Notes
                        </x-nav-link>
                        <x-nav-link :href="route('attendances.index')" :active="request()->routeIs('attendances.*')">
                            Présences
                        </x-nav-link>

                        <!-- Menu "Plus" -->
                        <div class="relative" @click.away="moreMenu = false">
                            <button @click="moreMenu = !moreMenu" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 transition">
                                Plus
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="moreMenu" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                                <a href="{{ route('subjects.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Matières</a>
                                <a href="{{ route('timetable.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Emploi du temps</a>
                                <a href="{{ route('announcements.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Annonces</a>
                                @unless(auth()->user()->hasRole('enseignant'))
                                    <a href="{{ route('fees.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Frais scolaires</a>
                                @endunless
                                @if(auth()->user()->hasRole('admin_ecole') || auth()->user()->hasRole('super_admin'))
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="{{ route('statistics.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Statistiques</a>
                                    <a href="{{ route('teachers.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Enseignants</a>
                                    <a href="{{ route('parents.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Comptes Parents</a>
                                    <a href="{{ route('school-years.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Années scolaires</a>
                                    <a href="{{ route('sms.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">SMS Parents</a>
                                @endif
                                @if(auth()->user()->hasRole('super_admin'))
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="{{ route('super-admin.dashboard') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Admin SaaS</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right side -->
            <div class="hidden lg:flex items-center space-x-3">
                <!-- Search -->
                <div x-data="searchBar()" @click.away="results = []" class="relative">
                    <input type="text" placeholder="Rechercher..." x-model="query" @input.debounce.300ms="search()"
                        class="w-44 rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pl-8 py-2">
                    <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <div x-show="results.length > 0" class="absolute top-full mt-1 w-72 bg-white border rounded-lg shadow-lg z-50 max-h-64 overflow-y-auto">
                        <template x-for="result in results" :key="result.url">
                            <a :href="result.url" class="block px-4 py-2 hover:bg-gray-50 border-b last:border-0">
                                <div class="text-sm font-medium text-gray-800" x-text="result.label"></div>
                                <div class="text-xs text-gray-500" x-text="result.detail"></div>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Messages -->
                @php
                    $unreadMessagesCount = \App\Models\MessageRecipient::where('recipient_id', auth()->id())->whereNull('read_at')->count();
                @endphp
                <a href="{{ route('messages.index') }}" class="relative p-2 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    @if($unreadMessagesCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">
                            {{ $unreadMessagesCount }}
                        </span>
                    @endif
                </a>

                <!-- Notifications -->
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition">
                            <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-blue-700">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="hidden xl:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Mon profil</x-dropdown-link>
                        @unless(auth()->user()->hasRole('parent'))
                            <x-dropdown-link :href="route('school.settings')">Paramètres école</x-dropdown-link>
                            <x-dropdown-link :href="route('subscription.index')">Abonnement</x-dropdown-link>
                            <x-dropdown-link :href="route('export.students')">Exportations</x-dropdown-link>
                        @endunless
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger mobile -->
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden border-t border-gray-100">
        <div class="py-3 space-y-1 px-4">
            @if(auth()->user()->hasRole('parent'))
                <x-responsive-nav-link :href="route('parent.index')" :active="request()->routeIs('parent.*')">Mes enfants</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    Messagerie
                    @if($unreadMessagesCount > 0)
                        <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $unreadMessagesCount }}</span>
                    @endif
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">Notifications</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Tableau de bord</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">Élèves</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('classrooms.index')" :active="request()->routeIs('classrooms.*')">Classes</x-responsive-nav-link>
                @unless(auth()->user()->hasRole('enseignant'))
                    <x-responsive-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')">Paiements</x-responsive-nav-link>
                @endunless
                <x-responsive-nav-link :href="route('grades.index')" :active="request()->routeIs('grades.*')">Notes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('attendances.index')" :active="request()->routeIs('attendances.*')">Présences</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('subjects.index')" :active="request()->routeIs('subjects.*')">Matières</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('timetable.index')" :active="request()->routeIs('timetable.*')">Emploi du temps</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('announcements.index')" :active="request()->routeIs('announcements.*')">Annonces</x-responsive-nav-link>
                @unless(auth()->user()->hasRole('enseignant'))
                    <x-responsive-nav-link :href="route('fees.index')" :active="request()->routeIs('fees.*')">Frais scolaires</x-responsive-nav-link>
                @endunless
                <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.*')">
                    Messagerie
                    @if($unreadMessagesCount > 0)
                        <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $unreadMessagesCount }}</span>
                    @endif
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">Notifications</x-responsive-nav-link>
                @if(auth()->user()->hasRole('admin_ecole') || auth()->user()->hasRole('super_admin'))
                    <div class="border-t border-gray-100 my-2"></div>
                    <x-responsive-nav-link :href="route('statistics.index')" :active="request()->routeIs('statistics.*')">Statistiques</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.*')">Enseignants</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('school-years.index')" :active="request()->routeIs('school-years.*')">Années scolaires</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('sms.index')" :active="request()->routeIs('sms.*')">SMS Parents</x-responsive-nav-link>
                @endif
            @endif
        </div>

        <div class="py-3 border-t border-gray-100 px-4">
            <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Mon profil</x-responsive-nav-link>
                @unless(auth()->user()->hasRole('parent'))
                    <x-responsive-nav-link :href="route('school.settings')">Paramètres école</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('subscription.index')">Abonnement</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('export.students')">Exportations</x-responsive-nav-link>
                @endunless
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Déconnexion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
