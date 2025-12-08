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
<span class="material-symbols-outlined text-xl">calendar_today</span>
<span class="font-medium">Eventos</span>
</a>
<a class="flex items-center gap-3 rounded-lg bg-gray-200 dark:bg-gray-800 px-4 py-2.5 text-gray-900 dark:text-white" href="{{ route('admin.equipos') }}">
<span class="material-symbols-outlined text-xl">groups</span>
<span class="font-medium">Equipos</span>
</a>
<a class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" href="{{ route('admin.jueces') }}">
<span class="material-symbols-outlined text-xl">gavel</span>
<span class="font-medium">Jueces</span>
</a>
<a class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-800" href="{{ route('admin.configuracion') }}">
<span class="material-symbols-outlined text-xl">settings</span>
<span class="font-medium">Configuración</span>
</a>
</nav>
</div>

<div class="p-4 border-t border-border-light dark:border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>

</aside>
<main class="flex-1 overflow-y-auto bg-white dark:bg-zinc-900 p-8">
<header class="mb-8 flex items-center justify-between">
<div>
<h2 class="text-4xl font-bold text-gray-900 dark:text-white">Equipos</h2>
<p class="mt-2 text-gray-500 dark:text-gray-400">Gestiona los equipos y sus proyectos</p>
</div>
<!-- <a href="{{ route('admin.equipos.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:opacity-90 transition font-semibold">Nuevo equipo</a> -->
</header>
<div class="mb-6 flex items-center justify-between">
  <form method="GET" action="{{ route('admin.equipos') }}" class="w-1/3 relative">
    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">search</span>
    <input name="search" value="{{ $search ?? request('search') }}" class="w-full rounded-lg border-none bg-gray-100 dark:bg-zinc-800 py-3 pl-12 pr-4 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary" placeholder="Buscar equipos" type="text"/>
  </form>
</div>
<div class="mb-6 flex items-center gap-2 border-b border-gray-200 dark:border-zinc-700">
<button class="px-4 py-2 text-sm font-medium border-b-2 border-primary text-primary">Todos los eventos</button>
</div>
<div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-zinc-800">
<table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
<thead class="bg-gray-50 dark:bg-zinc-800/50">
<tr>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Nombre del equipo</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Nombre del proyecto</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Miembros</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Estado</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Fecha de creación</th>
<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400" scope="col">Acciones</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
@forelse($equipos ?? [] as $equipo)
<tr>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $equipo->nombre }}</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $equipo->nombre_proyecto }}</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $equipo->participantes()->count() }} miembro(s)</td>
<td class="whitespace-nowrap px-6 py-4 text-sm">
<span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-sm font-medium
{{ $equipo->estado === 'aprobado' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 
   ($equipo->estado === 'rechazado' ? 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' : 
   'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300') }}">
{{ ucfirst($equipo->estado) }}</span>
</td>
<td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $equipo->created_at->translatedFormat('d \d\e M \d\e Y') }}</td>
<td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
<a href="{{ route('admin.equipos.show', $equipo->id_equipo) }}" class="text-primary hover:underline">Ver</a>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="text-center px-6 py-8 text-gray-500 dark:text-gray-400">No hay equipos disponibles</td>
</tr>
@endforelse
</tbody>
</table>
</div>
@if(method_exists($equipos, 'links') && $equipos->hasPages())
  <div class="px-4 py-3 border-t border-gray-100 bg-white">
    <div class="flex items-center justify-between">
      <div class="text-sm text-gray-600">Mostrando {{ $equipos->firstItem() }} - {{ $equipos->lastItem() }} de {{ $equipos->total() }} equipos</div>
      <div>
        {{ $equipos->links() }}
      </div>
    </div>
  </div>
@endif
</main>
</div>
</div>
</body></html>