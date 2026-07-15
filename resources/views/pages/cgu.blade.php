<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conditions Générales d'Utilisation — SchoolManager</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 text-gray-700">
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/"><img src="/images/logo.png" alt="SchoolManager" class="h-8"></a>
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline font-medium">Se connecter</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Conditions Générales d'Utilisation</h1>
        <p class="text-sm text-gray-400 mb-10">Dernière mise à jour : Juillet 2026</p>

        <div class="prose prose-gray max-w-none space-y-8">
            <section>
                <h2 class="text-xl font-semibold text-gray-900">1. Objet</h2>
                <p>Les présentes Conditions Générales d'Utilisation (CGU) définissent les modalités d'accès et d'utilisation de la plateforme SchoolManager, un service de gestion scolaire en ligne (SaaS) destiné aux établissements d'enseignement.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">2. Définitions</h2>
                <ul class="list-disc pl-6 space-y-1">
                    <li><strong>Plateforme</strong> : l'application web SchoolManager accessible en ligne.</li>
                    <li><strong>Utilisateur</strong> : toute personne physique ou morale utilisant la Plateforme.</li>
                    <li><strong>Établissement</strong> : l'école ou institution inscrite sur la Plateforme.</li>
                    <li><strong>Abonnement</strong> : le plan tarifaire souscrit par l'Établissement.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">3. Inscription et Compte</h2>
                <p>L'inscription nécessite la fourniture d'informations exactes et à jour. L'Utilisateur est responsable de la confidentialité de ses identifiants de connexion. Toute utilisation frauduleuse doit être signalée immédiatement.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">4. Essai Gratuit et Abonnement</h2>
                <p>Chaque nouvel Établissement bénéficie d'un essai gratuit de 14 jours donnant accès à toutes les fonctionnalités. À l'issue de cette période, l'Établissement doit souscrire un abonnement payant pour continuer à utiliser le service. Les tarifs sont exprimés en FCFA et peuvent être modifiés avec un préavis de 30 jours.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">5. Utilisation de la Plateforme</h2>
                <p>L'Utilisateur s'engage à :</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Utiliser la Plateforme conformément à sa destination (gestion scolaire).</li>
                    <li>Ne pas tenter de compromettre la sécurité ou le fonctionnement du service.</li>
                    <li>Respecter les droits des tiers, notamment en matière de données personnelles.</li>
                    <li>Ne pas utiliser la Plateforme à des fins illicites.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">6. Données et Propriété</h2>
                <p>Les données saisies par l'Établissement lui appartiennent. SchoolManager s'engage à ne pas utiliser ces données à des fins commerciales autres que la fourniture du service. L'Établissement peut exporter ses données à tout moment.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">7. Disponibilité</h2>
                <p>SchoolManager s'efforce d'assurer une disponibilité maximale du service. Toutefois, des interruptions pour maintenance ou mises à jour sont possibles. En cas de maintenance planifiée, les Utilisateurs seront informés 48 heures à l'avance.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">8. Résiliation</h2>
                <p>L'Établissement peut résilier son abonnement à tout moment. Les données seront conservées pendant 30 jours après la résiliation, après quoi elles seront définitivement supprimées. SchoolManager se réserve le droit de suspendre un compte en cas de violation des présentes CGU.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">9. Limitation de Responsabilité</h2>
                <p>SchoolManager ne saurait être tenu responsable des dommages indirects résultant de l'utilisation ou de l'impossibilité d'utilisation de la Plateforme. La responsabilité totale est limitée au montant des sommes versées par l'Établissement au cours des 12 derniers mois.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">10. Droit Applicable</h2>
                <p>Les présentes CGU sont régies par le droit sénégalais. En cas de litige, les tribunaux de Dakar seront seuls compétents.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">11. Contact</h2>
                <p>Pour toute question relative aux présentes CGU, contactez-nous à : <a href="mailto:contact@schoolmanager.sn" class="text-blue-600 hover:underline">contact@schoolmanager.sn</a></p>
            </section>
        </div>
    </main>

    <footer class="border-t border-gray-200 mt-16 py-8 text-center text-sm text-gray-400">
        <p>&copy; {{ date('Y') }} SchoolManager. Tous droits réservés.</p>
        <div class="mt-2 space-x-4">
            <a href="{{ route('pages.cgu') }}" class="hover:text-gray-600">CGU</a>
            <a href="{{ route('pages.privacy') }}" class="hover:text-gray-600">Confidentialité</a>
        </div>
    </footer>
</body>
</html>
