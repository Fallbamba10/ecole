<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page non trouvée - SchoolManager</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center p-8">
        <div class="text-6xl font-bold text-blue-600 mb-4">404</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Page non trouvée</h1>
        <p class="text-gray-600 mb-6">La page que vous recherchez n'existe pas ou a été déplacée.</p>
        <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            Retour au Dashboard
        </a>
    </div>
</body>
</html>
