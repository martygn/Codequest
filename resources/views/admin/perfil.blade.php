<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Perfil</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#4299E1",
              "background-light": "#F9FAFB",
              "background-dark": "#111827",
            },
            fontFamily: {
              display: ["Inter", "sans-serif"],
            },
            borderRadius: {
              DEFAULT: "0.5rem",
            },
          },
        },
      };
    </script>
<style>
      .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
      }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
<div class="flex h-screen">
<aside class="w-64 bg-white dark:bg-gray-800 p-6 flex flex-col justify-between border-r border-gray-200 dark:border-gray-700">
<div>
<h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-10">CodeQuest</h1>
<nav class="space-y-2">
<a class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">home</span>
<span>Panel de control</span>
</a>
<a class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.eventos') }}">
<span class="material-symbols-outlined">calendar_today</span>
<span>Eventos</span>
</a>
<a class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.equipos') }}">
<span class="material-symbols-outlined">groups</span>
<span>Equipos</span>
</a>
<a class="flex items-center space-x-3 p-3 rounded-lg text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 font-semibold" href="{{ route('admin.perfil') }}">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">account_circle</span>
<span>Perfil</span>
</a>
<a class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.configuracion') }}">
<span class="material-symbols-outlined">settings</span>
<span>Configuración</span>
</a>
</nav>
</div>
</aside>
<main class="flex-1 overflow-y-auto">
<div class="px-10 py-8">
<div class="mb-8 text-sm text-gray-500 dark:text-gray-400">
<a class="text-primary hover:underline" href="#">Perfil</a>
<span> / </span>
<span>Usuario1792</span>
</div>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
<div class="relative">
<img alt="Banner" class="w-full h-48 object-cover rounded-t-lg" src="https://via.placeholder.com/1200x300.png?text=Banner"/>
<div class="absolute -bottom-16 left-8">
<img alt="Avatar" class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 object-cover" src="https://via.placeholder.com/150"/>
</div>
</div>
<div class="pt-24 px-8 pb-8">
<h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Nombre del Usuario</h2>
<div class="border-t border-gray-200 dark:border-gray-700 pt-6">
<h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Datos generales:</h3>
<div class="space-y-6">
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
<label class="text-gray-500 dark:text-gray-400">Nombre:</label>
<p class="md:col-span-2 text-gray-800 dark:text-gray-200">Nombre Apellido</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
<label class="text-gray-500 dark:text-gray-400">Correo:</label>
<p class="md:col-span-2 text-gray-800 dark:text-gray-200">usuario@ejemplo.com</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
<label class="text-gray-500 dark:text-gray-400">Contraseña:</label>
<p class="md:col-span-2 text-gray-800 dark:text-gray-200 tracking-widest">********</p>
</div>
</div>
<div class="mt-8">
<button class="bg-primary text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">Cambiar Contraseña</button>
</div>
</div>
</div>
</div>
<div class="flex justify-end mt-8 px-10">
<button class="bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">Eliminar Cuenta</button>
</div>
</main>
</div>

</body></html>