<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès refusé - SchoolManager</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center p-8">
        <div class="text-6xl font-bold text-red-600 mb-4">403</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Accès refusé</h1>
        <p class="text-gray-600 mb-6">Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
        <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            Retour au Dashboard
        </a>
    </div>
</body>
</html>
