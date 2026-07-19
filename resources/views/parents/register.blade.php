<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription Parent - SchoolManager</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <img src="/images/logo.png" alt="SchoolManager" class="h-10 mx-auto mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Créer votre compte parent</h1>
                <p class="text-gray-500 mt-2">Vous avez été invité par l'école de <strong>{{ $invitation->student->full_name }}</strong></p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('parent.register.store', $invitation->token) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Votre nom complet</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Ex: Mme Diallo Aminata">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                        <input type="text" disabled value="{{ $invitation->phone ?? $invitation->email }}"
                            class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500">
                        <p class="text-xs text-gray-400 mt-1">Ce sera votre identifiant de connexion.</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input type="password" name="password" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Minimum 6 caractères">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                        Créer mon compte
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-gray-400 mt-6">
                Vous avez déjà un compte ? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Se connecter</a>
            </p>
        </div>
    </div>
</body>
</html>
