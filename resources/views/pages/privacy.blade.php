<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Politique de Confidentialité — SchoolManager</title>
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
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Politique de Confidentialité</h1>
        <p class="text-sm text-gray-400 mb-10">Dernière mise à jour : Juillet 2026</p>

        <div class="prose prose-gray max-w-none space-y-8">
            <section>
                <h2 class="text-xl font-semibold text-gray-900">1. Introduction</h2>
                <p>SchoolManager accorde une grande importance à la protection des données personnelles de ses utilisateurs. La présente politique de confidentialité décrit les données que nous collectons, comment nous les utilisons et les mesures que nous prenons pour les protéger.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">2. Données Collectées</h2>
                <p>Nous collectons les catégories de données suivantes :</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li><strong>Données de l'établissement</strong> : nom, adresse, téléphone, email.</li>
                    <li><strong>Données des utilisateurs</strong> : nom, prénom, email, mot de passe (hashé).</li>
                    <li><strong>Données des élèves</strong> : identité, date de naissance, classe, informations des parents.</li>
                    <li><strong>Données scolaires</strong> : notes, présences, paiements.</li>
                    <li><strong>Données techniques</strong> : adresse IP, navigateur, pages consultées (à des fins de sécurité).</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">3. Finalités du Traitement</h2>
                <p>Les données sont traitées pour :</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Fournir et améliorer le service de gestion scolaire.</li>
                    <li>Gérer les comptes utilisateurs et l'authentification.</li>
                    <li>Envoyer des notifications liées au service (alertes, rappels de paiement).</li>
                    <li>Assurer la sécurité et prévenir les fraudes.</li>
                    <li>Respecter nos obligations légales.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">4. Partage des Données</h2>
                <p>Nous ne vendons ni ne louons les données personnelles à des tiers. Les données peuvent être partagées uniquement avec :</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Nos prestataires techniques (hébergement, envoi d'emails) qui sont soumis à des obligations de confidentialité.</li>
                    <li>Les autorités compétentes en cas d'obligation légale.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">5. Sécurité</h2>
                <p>Nous mettons en œuvre des mesures techniques et organisationnelles appropriées pour protéger les données :</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Chiffrement des communications (HTTPS/TLS).</li>
                    <li>Mots de passe hashés avec des algorithmes robustes.</li>
                    <li>Accès restreint aux données selon les rôles.</li>
                    <li>Sauvegardes régulières et chiffrées.</li>
                    <li>Isolation des données entre établissements (multi-tenant).</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">6. Conservation</h2>
                <p>Les données sont conservées pendant la durée de l'abonnement de l'établissement. Après résiliation, les données sont conservées 30 jours avant suppression définitive. Les données de facturation sont conservées conformément aux obligations légales (10 ans).</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">7. Droits des Utilisateurs</h2>
                <p>Conformément à la réglementation applicable, vous disposez des droits suivants :</p>
                <ul class="list-disc pl-6 space-y-1">
                    <li><strong>Accès</strong> : obtenir une copie de vos données personnelles.</li>
                    <li><strong>Rectification</strong> : corriger des données inexactes.</li>
                    <li><strong>Suppression</strong> : demander l'effacement de vos données.</li>
                    <li><strong>Portabilité</strong> : recevoir vos données dans un format structuré.</li>
                    <li><strong>Opposition</strong> : vous opposer au traitement de vos données.</li>
                </ul>
                <p>Pour exercer ces droits, contactez-nous à <a href="mailto:privacy@schoolmanager.sn" class="text-blue-600 hover:underline">privacy@schoolmanager.sn</a>.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">8. Cookies</h2>
                <p>Nous utilisons des cookies strictement nécessaires au fonctionnement du service (session, authentification). Aucun cookie publicitaire ou de tracking n'est utilisé.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">9. Modifications</h2>
                <p>Nous nous réservons le droit de modifier cette politique. En cas de modification substantielle, les utilisateurs seront informés par email ou notification dans l'application.</p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900">10. Contact</h2>
                <p>Pour toute question relative à la protection de vos données : <a href="mailto:privacy@schoolmanager.sn" class="text-blue-600 hover:underline">privacy@schoolmanager.sn</a></p>
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
