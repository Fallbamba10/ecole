<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SchoolManager - Gestion scolaire simplifiée</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #1e40af, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-gradient { background: linear-gradient(135deg, #eff6ff 0%, #ede9fe 50%, #fdf2f8 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .float-animation { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .fade-in { animation: fadeIn 0.8s ease-out forwards; opacity: 0; }
        @keyframes fadeIn { to { opacity: 1; transform: translateY(0); } }
        .fade-in { transform: translateY(20px); }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .blob { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased overflow-x-hidden">

    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-lg shadow-sm fixed w-full z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="/images/logo.png" alt="SchoolManager" class="h-10 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm text-gray-600 hover:text-blue-600 transition font-medium">Fonctionnalités</a>
                    <a href="#pricing" class="text-sm text-gray-600 hover:text-blue-600 transition font-medium">Tarifs</a>
                    <a href="#testimonials" class="text-sm text-gray-600 hover:text-blue-600 transition font-medium">Témoignages</a>
                </div>
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2 rounded-full text-sm font-medium hover:shadow-lg transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-600 transition font-medium">Connexion</a>
                        @if(Route::has('register.school'))
                            <a href="{{ route('register.school') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2 rounded-full text-sm font-medium hover:shadow-lg hover:scale-105 transition-all">
                                Essai gratuit
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient pt-32 pb-20 relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute top-20 right-0 w-72 h-72 bg-blue-200 opacity-30 blob blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200 opacity-20 blob blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="fade-in">
                    <div class="inline-flex items-center bg-blue-50 border border-blue-100 rounded-full px-4 py-1.5 mb-6">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sm text-blue-700 font-medium">+500 écoles nous font confiance</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                        Gérez votre école<br>
                        <span class="gradient-text">en toute simplicité</span>
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-lg">
                        La plateforme tout-en-un pour les établissements scolaires au Sénégal.
                        Inscriptions, paiements, notes, présences — tout est centralisé et accessible en un clic.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        @if(Route::has('register.school'))
                            <a href="{{ route('register.school') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-full text-lg font-semibold hover:shadow-xl hover:scale-105 transition-all text-center">
                                Commencer gratuitement
                            </a>
                        @endif
                        <a href="#features" class="border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-full text-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition text-center">
                            En savoir plus
                        </a>
                    </div>
                    <div class="mt-6 flex items-center gap-6 text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            1 mois gratuit
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Sans engagement
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Support inclus
                        </div>
                    </div>
                </div>

                <!-- Dashboard preview -->
                <div class="hidden lg:block fade-in delay-2 float-animation">
                    <div class="bg-white rounded-3xl shadow-2xl p-1 border border-gray-200">
                        <div class="bg-gray-50 rounded-2xl p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                <span class="ml-4 text-xs text-gray-400">SchoolManager — Institut Excellence</span>
                            </div>
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                                    <div class="text-2xl font-bold text-blue-600">248</div>
                                    <div class="text-xs text-gray-500 mt-1">Élèves</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                                    <div class="text-2xl font-bold text-green-600">94%</div>
                                    <div class="text-xs text-gray-500 mt-1">Présence</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                                    <div class="text-2xl font-bold text-purple-600">1.2M</div>
                                    <div class="text-xs text-gray-500 mt-1">FCFA</div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-xs font-bold text-blue-600">AB</div>
                                        <span class="text-sm font-medium">Amadou Ba</span>
                                    </div>
                                    <span class="text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-medium">Présent</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center text-xs font-bold text-pink-600">FD</div>
                                        <span class="text-sm font-medium">Fatou Diop</span>
                                    </div>
                                    <span class="text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-medium">Présent</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center text-xs font-bold text-orange-600">MN</div>
                                        <span class="text-sm font-medium">Moussa Ndiaye</span>
                                    </div>
                                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-full font-medium">Retard</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Fonctionnalités</span>
                <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-gray-900">Tout ce dont votre école a besoin</h2>
                <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Une plateforme complète et intuitive pour gérer tous les aspects de votre établissement</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="p-8 bg-white border border-gray-100 rounded-2xl card-hover group">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-blue-100 transition">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Gestion des élèves</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Inscriptions, fiches complètes, photos, répartition par classe. Import CSV en masse.</p>
                </div>

                <div class="p-8 bg-white border border-gray-100 rounded-2xl card-hover group">
                    <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-green-100 transition">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Paiements & Finances</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Suivi des paiements, rappels auto, reçus PDF. Orange Money, Wave, espèces.</p>
                </div>

                <div class="p-8 bg-white border border-gray-100 rounded-2xl card-hover group">
                    <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-purple-100 transition">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Notes & Bulletins</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Saisie des notes, moyennes automatiques, classement, bulletins PDF professionnels.</p>
                </div>

                <div class="p-8 bg-white border border-gray-100 rounded-2xl card-hover group">
                    <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-yellow-100 transition">
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Présences & Absences</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Appel quotidien, historique complet, SMS automatiques aux parents en cas d'absence.</p>
                </div>

                <div class="p-8 bg-white border border-gray-100 rounded-2xl card-hover group">
                    <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-red-100 transition">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Emploi du temps</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Planning visuel par classe, détection des conflits, salles et enseignants.</p>
                </div>

                <div class="p-8 bg-white border border-gray-100 rounded-2xl card-hover group">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-5 group-hover:bg-indigo-100 transition">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">SMS & Communication</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Envoi de SMS aux parents, annonces, notifications en temps réel.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Band -->
    <section class="py-16 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl md:text-5xl font-extrabold text-white">500+</div>
                    <div class="mt-2 text-blue-100 font-medium">Écoles inscrites</div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-extrabold text-white">50K+</div>
                    <div class="mt-2 text-blue-100 font-medium">Élèves gérés</div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-extrabold text-white">99.9%</div>
                    <div class="mt-2 text-blue-100 font-medium">Disponibilité</div>
                </div>
                <div>
                    <div class="text-4xl md:text-5xl font-extrabold text-white">24/7</div>
                    <div class="mt-2 text-blue-100 font-medium">Support client</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Tarifs</span>
                <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-gray-900">Des tarifs adaptés à chaque école</h2>
                <p class="mt-4 text-lg text-gray-500">Commencez gratuitement, évoluez selon vos besoins</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Plan Basic -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 card-hover">
                    <div class="text-sm font-semibold text-blue-600 uppercase">Basic</div>
                    <p class="mt-1 text-sm text-gray-500">Pour les petites écoles</p>
                    <div class="mt-6 flex items-baseline">
                        <span class="text-5xl font-extrabold text-gray-900">15K</span>
                        <span class="ml-2 text-gray-500 text-sm">FCFA/mois</span>
                    </div>
                    <ul class="mt-8 space-y-4">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Jusqu'à 150 élèves
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            5 comptes enseignants
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Notes & Bulletins PDF
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Paiements & Présences
                        </li>
                    </ul>
                    @if(Route::has('register.school'))
                        <a href="{{ route('register.school') }}" class="mt-8 block text-center border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold hover:border-blue-600 hover:text-blue-600 transition">
                            Commencer
                        </a>
                    @endif
                </div>

                <!-- Plan Standard -->
                <div class="bg-white rounded-3xl shadow-xl border-2 border-blue-600 p-8 relative scale-105 card-hover">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                        Populaire
                    </div>
                    <div class="text-sm font-semibold text-blue-600 uppercase">Standard</div>
                    <p class="mt-1 text-sm text-gray-500">Pour les écoles en croissance</p>
                    <div class="mt-6 flex items-baseline">
                        <span class="text-5xl font-extrabold text-gray-900">30K</span>
                        <span class="ml-2 text-gray-500 text-sm">FCFA/mois</span>
                    </div>
                    <ul class="mt-8 space-y-4">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Jusqu'à 500 élèves
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Enseignants illimités
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            SMS aux parents
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Emploi du temps + Exports
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Portail parents
                        </li>
                    </ul>
                    @if(Route::has('register.school'))
                        <a href="{{ route('register.school') }}" class="mt-8 block text-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg hover:scale-105 transition-all">
                            Commencer
                        </a>
                    @endif
                </div>

                <!-- Plan Premium -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 card-hover">
                    <div class="text-sm font-semibold text-blue-600 uppercase">Premium</div>
                    <p class="mt-1 text-sm text-gray-500">Grands établissements</p>
                    <div class="mt-6 flex items-baseline">
                        <span class="text-4xl font-extrabold text-gray-900">Sur devis</span>
                    </div>
                    <ul class="mt-8 space-y-4">
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Élèves illimités
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Multi-sites
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Support prioritaire dédié
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Formation sur site
                        </li>
                    </ul>
                    <a href="mailto:contact@schoolmanager.sn" class="mt-8 block text-center border-2 border-gray-200 text-gray-700 px-6 py-3 rounded-full font-semibold hover:border-blue-600 hover:text-blue-600 transition">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Témoignages</span>
                <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-gray-900">Ils nous font confiance</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="flex mb-3">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">"Avant SchoolManager, on gérait tout sur papier. Maintenant, je sais en temps réel combien de parents ont payé. C'est un gain de temps énorme."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-sm">AD</div>
                        <div class="ml-3">
                            <div class="font-semibold text-sm text-gray-900">Abdoulaye Diallo</div>
                            <div class="text-xs text-gray-500">Directeur, Institut Excellence</div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="flex mb-3">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">"Les bulletins se génèrent en un clic. Les parents reçoivent un SMS dès qu'une note est saisie. Mes enseignants adorent la simplicité."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center text-white font-bold text-sm">MS</div>
                        <div class="ml-3">
                            <div class="font-semibold text-sm text-gray-900">Mariama Sy</div>
                            <div class="text-xs text-gray-500">Directrice, École Avenir</div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-8 card-hover border border-gray-100">
                    <div class="flex mb-3">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">"Le suivi des paiements par Orange Money et Wave a tout changé. Plus besoin de courir après les reçus papier."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-full flex items-center justify-center text-white font-bold text-sm">ON</div>
                        <div class="ml-3">
                            <div class="font-semibold text-sm text-gray-900">Ousmane Ndiaye</div>
                            <div class="text-xs text-gray-500">Comptable, Groupe Scolaire Teranga</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-purple-500 rounded-full opacity-10 blur-3xl"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 text-center relative">
            <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">Prêt à moderniser<br>votre école ?</h2>
            <p class="mt-6 text-lg text-gray-300">Rejoignez les centaines d'établissements qui utilisent SchoolManager au quotidien.</p>
            @if(Route::has('register.school'))
                <a href="{{ route('register.school') }}" class="mt-8 inline-block bg-white text-gray-900 px-8 py-4 rounded-full text-lg font-bold hover:bg-gray-100 hover:scale-105 transition-all shadow-xl">
                    Démarrer mon essai gratuit
                </a>
            @endif
            <p class="mt-4 text-sm text-gray-400">1 mois gratuit - Aucune carte requise - Configuration en 2 minutes</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-16 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <img src="/images/logo.png" alt="SchoolManager" class="h-10 w-auto brightness-0 invert">
                    </div>
                    <p class="text-sm leading-relaxed">La plateforme de gestion scolaire #1 en Afrique de l'Ouest.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Produit</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#features" class="hover:text-white transition">Fonctionnalités</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Tarifs</a></li>
                        <li><a href="#testimonials" class="hover:text-white transition">Témoignages</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Support</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="mailto:contact@schoolmanager.sn" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4 text-sm uppercase tracking-wider">Coordonnées</h4>
                    <ul class="space-y-3 text-sm">
                        <li>contact@schoolmanager.sn</li>
                        <li>+221 77 123 45 67</li>
                        <li>Dakar, Sénégal</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-sm">
                <p>&copy; 2026 SchoolManager. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

</body>
</html>
