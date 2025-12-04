<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Equipos - CodeQuest</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#2998FF",
              "background-light": "#F8FAFC",
              "background-dark": "#18181B",
            },
            fontFamily: {
              display: ["Inter", "sans-serif"],
            },
            borderRadius: {
              DEFAULT: "0.75rem",
            },
          },
        },
      };
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
<div class="flex h-screen flex-col">
<div class="flex flex-1 overflow-hidden">
<aside class="w-64 flex-shrink-0 p-6 flex flex-col justify-between">
<div>
<h1 class="text-2xl font-bold text-gray-900 dark:text-white">CodeQuest</h1>
<nav class="mt-8 space-y-2">
<a class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined text-xl">home</span>
<span class="font-medium">Panel De Control</span>
</a>
<a class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" href="{{ route('admin.eventos') }}">
<span class="material-symbols-outlined text-xl">calendar_month</span>
<span class="font-medium">Eventos</span>
</a>
<a class="flex items-center gap-3 rounded-lg bg-gray-200 dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white" href="{{ route('admin.equipos') }}">
<span class="material-symbols-outlined text-xl">groups</span>
<span class="font-medium">Equipos</span>
</a>
<a class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" href="{{ route('admin.perfil') }}">
<span class="material-symbols-outlined text-xl">person</span>
<span class="font-medium">Perfil</span>
</a>
<a class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" href="{{ route('admin.configuracion') }}">
<span class="material-symbols-outlined text-xl">settings</span>
<span class="font-medium">Configuración</span>
</a>
</nav>
</div>
<button class="w-full rounded-lg bg-primary py-3 text-center font-semibold text-white hover:opacity-90 transition-opacity">Nuevo equipo</button>
</aside>
<main class="flex-1 overflow-y-auto bg-white dark:bg-zinc-900 p-8">
<header class="mb-8">
<h2 class="text-4xl font-bold text-gray-900 dark:text-white">Equipos</h2>
<p class="mt-2 text-gray-500 dark:text-gray-400">Gestiona los equipos y sus proyectos</p>
</header>
<div class="mb-6 flex items-center justify-between">
<div class="relative w-1/3">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">search</span>
<input class="w-full rounded-lg border-none bg-gray-100 dark:bg-zinc-800 py-3 pl-12 pr-4 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary" placeholder="Buscar equipos" type="text"/>
</div>
</div>
<div class="mb-6 flex items-center gap-2 border-b border-gray-200 dark:border-zinc-700">
<button class="px-4 py-2 text-sm font-medium border-b-2 border-primary text-primary">Todos los eventos</button>
<button class="px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 border-b-2 border-transparent">Mis eventos</button>
<button class="px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 border-b-2 border-transparent">Eventos pasados</button>
</div>
<div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-zinc-800">
<table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
<thead class="bg-gray-50 dark:bg-zinc-800/50">
<tr>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Nombre del equipo</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Nombre del proyecto</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Evento</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Estado</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Fecha de creación</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Acciones</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
<tr>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Equipo Alfa</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Proyecto 1</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Evento de Programación 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm">
<span class="inline-flex items-center rounded-md bg-yellow-100 px-2.5 py-0.5 text-sm font-medium text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">En revisión</span>
</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">15 de mayo de 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-primary hover:underline cursor-pointer">Ver</td>
</tr>
<tr>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Equipo Beta</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Proyecto 2</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Hackathon de Verano</td>
<td class="whitespace-nowrap px-6 py-4 text-sm">
<span class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800 dark:bg-green-900/50 dark:text-green-300">Aprobado</span>
</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">20 de mayo de 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-primary hover:underline cursor-pointer">Ver</td>
</tr>
<tr>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Equipo Gamma</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Proyecto 3</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Evento de Programación 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm">
<span class="inline-flex items-center rounded-md bg-red-100 px-2.5 py-0.5 text-sm font-medium text-red-800 dark:bg-red-900/50 dark:text-red-300">Rechazado</span>
</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">25 de mayo de 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-primary hover:underline cursor-pointer">Ver</td>
</tr>
<tr>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Equipo Delta</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Proyecto 4</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Hackathon de Verano</td>
<td class="whitespace-nowrap px-6 py-4 text-sm">
<span class="inline-flex items-center rounded-md bg-yellow-100 px-2.5 py-0.5 text-sm font-medium text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">En revisión</span>
</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">30 de mayo de 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-primary hover:underline cursor-pointer">Ver</td>
</tr>
<tr>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">Equipo Epsilon</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Proyecto 5</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">Evento de Programación 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm">
<span class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800 dark:bg-green-900/50 dark:text-green-300">Aprobado</span>
</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">5 de junio de 2024</td>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-primary hover:underline cursor-pointer">Ver</td>
</tr>
</tbody>
</table>
</div>
</main>
</div>
</div>
</body></html>