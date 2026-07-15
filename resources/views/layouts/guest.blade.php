<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SchoolManager') }} - Connexion</title>
        <link rel="icon" type="image/png" href="/favicon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 via-white to-purple-50 px-4">

            <!-- Logo -->
            <div class="mb-8">
                <a href="/">
                    <img src="/images/logo.png" alt="SchoolManager" class="h-14 w-auto">
                </a>
            </div>

            <!-- Card formulaire -->
            <div class="w-full max-w-md bg-white shadow-xl border border-gray-100 rounded-2xl px-8 py-10">
                {{ $slot }}
            </div>

            <!-- Lien inscription -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Pas encore de compte ?
                    @if(Route::has('register.school'))
                        <a href="{{ route('register.school') }}" class="text-blue-600 font-semibold hover:text-blue-800 ml-1">Créer mon école</a>
                    @endif
                </p>
            </div>

            <!-- Footer discret -->
            <div class="mt-10 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} SchoolManager — Gestion scolaire simplifiée
            </div>
        </div>
    </body>
</html>
