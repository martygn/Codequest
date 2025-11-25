<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CodeQuest') }}</title>

    <!-- Funtes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900">
    <!-- Header con navegación -->
    <header class="border-b border-gray-200 dark:border-gray-800">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-8">
                <a href="/" class="text-xl font-semibold text-gray-900 dark:text-white">
                    CodeQuest
                </a>
                <a href="/" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    Inicio
                </a>
                <a href="/eventos" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    Eventos
                </a>
                <a href="/comunidad" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    Comunidad
                </a>
                <a href="/ayuda" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    Ayuda
                </a>
            </div>
            <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                Iniciar sesión
            </a>
        </nav>
    </header>

    <!-- Contenido principal -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
</body>
</html>