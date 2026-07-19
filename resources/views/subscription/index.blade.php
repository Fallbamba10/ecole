<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Abonnement</h2>
            <a href="{{ route('subscription.billing') }}" class="text-sm text-blue-600 hover:text-blue-800">
                Historique de facturation &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Info plan actuel -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Plan actuel</h3>
                        <p class="text-gray-600 mt-1">
                            Votre école est sur le plan
                            <span class="font-bold text-blue-600">{{ config("plans.{$currentPlan}.name", 'Gratuit') }}</span>
                        </p>
                        @if($currentSubscription && $currentSubscription->ends_at)
                            <p class="text-sm text-gray-500 mt-1">
                                Expire le {{ $currentSubscription->ends_at->format('d/m/Y') }}
                            </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-800">
                            {{ number_format(config("plans.{$currentPlan}.price", 0), 0, ',', ' ') }}
                            <span class="text-sm font-normal text-gray-500">FCFA/mois</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grille des plans -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($plans as $planKey => $plan)
                    <div class="relative bg-white rounded-xl shadow-sm border-2 transition-all hover:shadow-md
                        {{ $currentPlan === $planKey ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-200' }}
                        {{ isset($plan['popular']) && $plan['popular'] ? 'border-blue-500' : '' }}">

                        @if(isset($plan['popular']) && $plan['popular'])
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                <span class="bg-blue-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                    Populaire
                                </span>
                            </div>
                        @endif

                        @if($currentPlan === $planKey)
                            <div class="absolute -top-3 right-4">
                                <span class="bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                    Plan actuel
                                </span>
                            </div>
                        @endif

                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800">{{ $plan['name'] }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $plan['description'] }}</p>

                            <div class="mt-4 mb-6">
                                <span class="text-3xl font-bold text-gray-900">
                                    {{ number_format($plan['price'], 0, ',', ' ') }}
                                </span>
                                <span class="text-sm text-gray-500">FCFA/{{ $plan['billing_period'] }}</span>
                            </div>

                            <ul class="space-y-3 mb-6">
                                @foreach($plan['features'] as $feature)
                                    <li class="flex items-start text-sm">
                                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-gray-600">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            @if($currentPlan === $planKey)
                                <button disabled class="w-full py-2 px-4 bg-gray-100 text-gray-500 rounded-lg font-medium cursor-not-allowed">
                                    Plan actuel
                                </button>
                            @elseif(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))
                                <form action="{{ route('subscription.changePlan') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan" value="{{ $planKey }}">
                                    <button type="submit" class="w-full py-2 px-4 rounded-lg font-medium transition-colors
                                        {{ isset($plan['popular']) && $plan['popular']
                                            ? 'bg-blue-600 text-white hover:bg-blue-700'
                                            : 'bg-gray-800 text-white hover:bg-gray-900' }}">
                                        @if(array_search($planKey, array_keys($plans)) > array_search($currentPlan, array_keys($plans)))
                                            Passer au plan {{ $plan['name'] }}
                                        @else
                                            Changer vers {{ $plan['name'] }}
                                        @endif
                                    </button>
                                </form>
                            @else
                                <p class="text-center text-sm text-gray-500 italic">
                                    Contactez votre administrateur pour changer de plan.
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Limites actuelles -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Utilisation actuelle</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $limits = config("plans.{$currentPlan}.limits", []);
                        $studentCount = $school->students()->count();
                        $classroomCount = $school->classrooms()->count();
                        $studentLimit = $limits['students'] ?? 0;
                        $classroomLimit = $limits['classrooms'] ?? 0;
                    @endphp

                    <!-- Eleves -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Eleves</span>
                            <span class="font-medium">
                                {{ $studentCount }} / {{ $studentLimit ? $studentLimit : 'Illimite' }}
                            </span>
                        </div>
                        @if($studentLimit)
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ ($studentCount / $studentLimit) > 0.9 ? 'bg-red-500' : 'bg-blue-500' }}"
                                     style="width: {{ min(100, ($studentCount / $studentLimit) * 100) }}%"></div>
                            </div>
                        @else
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 5%"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Classes -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Classes</span>
                            <span class="font-medium">
                                {{ $classroomCount }} / {{ $classroomLimit ? $classroomLimit : 'Illimite' }}
                            </span>
                        </div>
                        @if($classroomLimit)
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full {{ ($classroomCount / $classroomLimit) > 0.9 ? 'bg-red-500' : 'bg-blue-500' }}"
                                     style="width: {{ min(100, ($classroomCount / $classroomLimit) * 100) }}%"></div>
                            </div>
                        @else
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 5%"></div>
                            </div>
                        @endif
                    </div>

                    <!-- SMS -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">SMS / mois</span>
                            <span class="font-medium">
                                @if($limits['sms_per_month'] ?? 0)
                                    0 / {{ $limits['sms_per_month'] }}
                                @elseif(is_null($limits['sms_per_month'] ?? 0))
                                    Illimite
                                @else
                                    Non disponible
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
