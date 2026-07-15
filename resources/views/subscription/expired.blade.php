<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Abonnement expiré</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <div class="mb-6">
                    <svg class="w-16 h-16 text-yellow-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.072 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-2">Votre période d'essai est terminée</h3>
                <p class="text-gray-600 mb-6">
                    Pour continuer à utiliser la plateforme, veuillez souscrire à un abonnement.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <!-- Plan Basic -->
                    <div class="border rounded-lg p-4">
                        <h4 class="font-bold text-lg">Basic</h4>
                        <p class="text-2xl font-bold text-blue-600 my-2">15 000 <span class="text-sm">FCFA/mois</span></p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>150 étudiants max</li>
                            <li>5 comptes enseignants</li>
                            <li>Modules de base</li>
                        </ul>
                    </div>

                    <!-- Plan Standard -->
                    <div class="border-2 border-blue-500 rounded-lg p-4 relative">
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Populaire</span>
                        <h4 class="font-bold text-lg">Standard</h4>
                        <p class="text-2xl font-bold text-blue-600 my-2">30 000 <span class="text-sm">FCFA/mois</span></p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>500 étudiants max</li>
                            <li>Enseignants illimités</li>
                            <li>Toutes les fonctionnalités</li>
                        </ul>
                    </div>

                    <!-- Plan Premium -->
                    <div class="border rounded-lg p-4">
                        <h4 class="font-bold text-lg">Premium</h4>
                        <p class="text-2xl font-bold text-blue-600 my-2">Sur devis</p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>Illimité</li>
                            <li>Multi-sites</li>
                            <li>Support dédié</li>
                        </ul>
                    </div>
                </div>

                <p class="text-sm text-gray-500">
                    Contactez-nous pour souscrire : <strong>contact@schoolmanager.com</strong>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
