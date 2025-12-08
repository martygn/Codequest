<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Eventos - CodeQuest</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#3b82f6",
              "background-light": "#f8fafc",
              "background-dark": "#0f172a",
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
        .material-symbols-outlined.filled {
            font-variation-settings:
            'FILL' 1,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
<div class="flex h-screen">
<aside class="w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-6 flex flex-col justify-between">
<div>
<h1 class="text-2xl font-bold text-slate-900 dark:text-white">CodeQuest</h1>
<nav class="mt-8 space-y-2">
<a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">home</span>
<span>Panel de control</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800 rounded font-semibold" href="{{ route('admin.eventos') }}">
<span class="material-symbols-outlined">calendar_today</span>
<span>Eventos</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('admin.equipos') }}">
<span class="material-symbols-outlined">groups</span>
<span>Equipos</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('admin.jueces') }}">
<span class="material-symbols-outlined">gavel</span>
<span>Jueces</span>
</a>

  <a class="flex items-center gap-3 px-4 py-2 text-slate-600 dark:text-slate-400 rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" href="{{ route('admin.configuracion') }}">
    <span class="material-symbols-outlined">settings</span>
    <span>Configuración</span>
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
<main class="flex-1 p-8 overflow-y-auto">
<div class="max-w-7xl mx-auto">
<header class="mb-8 flex items-center justify-between">
<div>
<h2 class="text-4xl font-bold text-slate-900 dark:text-white">Eventos</h2>
<p class="text-slate-500 dark:text-slate-400 mt-1">Gestiona los eventos</p>
</div>
<a href="{{ route('admin.eventos.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition font-semibold">Nuevo evento</a>
</header>
<div class="relative mb-6">
<form method="GET" action="{{ route('admin.eventos') }}" class="flex items-center">
  <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
  <input name="search" value="{{ $search ?? request('search') }}" class="w-full max-w-sm pl-10 pr-4 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" placeholder="Buscar eventos" type="text"/>
  <input type="hidden" name="status" value="{{ $status ?? 'pendientes' }}" />
  <button type="submit" class="ml-3 px-3 py-2 bg-primary text-white rounded-md">Buscar</button>
</form>
</div>
<div class="border-b border-slate-200 dark:border-slate-700 mb-6">
<nav class="flex space-x-6 -mb-px">
<a class="py-3 px-1 {{ ($status ?? 'pendientes') === 'todos' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary' }}" href="{{ route('admin.eventos', ['status' => 'todos']) }}">Todos</a>
<a class="py-3 px-1 {{ ($status ?? 'pendientes') === 'pendientes' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary' }}" href="{{ route('admin.eventos', ['status' => 'pendientes']) }}">Pendientes</a>
<a class="py-3 px-1 {{ ($status ?? 'pendientes') === 'publicados' ? 'text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-white font-semibold' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary' }}" href="{{ route('admin.eventos', ['status' => 'publicados']) }}">Publicados</a>
</nav>
</div>
<div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
<table class="w-full text-left">
<thead class="border-b border-slate-200 dark:border-slate-800">
<tr>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Nombre del Evento</th>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Fecha</th>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Estado</th>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Acciones</th>
</tr>
</thead>
<tbody>
@foreach($eventos ?? [] as $evento)
<tr class="border-b border-slate-200 dark:border-slate-800">
<td class="p-4 text-slate-800 dark:text-slate-200">{{ $evento->nombre }}</td>
<td class="p-4 text-slate-500 dark:text-slate-400">{{ $evento->fecha_inicio }}</td>
<td class="p-4">
  <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">{{ $evento->estado ?? 'pendiente' }}</span>
</td>
<td class="p-4">
  <a href="{{ route('admin.eventos.show', $evento->id_evento) }}" class="font-medium text-primary hover:underline mr-4">Revisar</a>

  @if(auth()->user() && auth()->user()->esAdmin())
  <form method="POST" action="{{ route('admin.eventos.update-status', $evento->id_evento) }}" class="inline-block">
    @csrf
    @method('PATCH')
    <select name="estado" class="border px-3 py-1 rounded-full text-sm mr-2">
      <option value="pendiente" {{ ($evento->estado ?? 'pendiente') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
      <option value="publicado" {{ ($evento->estado ?? 'pendiente') === 'publicado' ? 'selected' : '' }}>Publicado</option>
    </select>
    <button type="submit" class="px-3 py-1 bg-primary text-white rounded-full text-sm">Actualizar</button>
  </form>
  @endif

</td>
</tr>
@endforeach
</tbody>
</table>
</div>

          @if(method_exists($eventos, 'links') && $eventos->hasPages())
          <div class="px-4 py-3 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900">
            {{ $eventos->links() }}
          </div>
          @endif
</div>
</div>
</main>
</div>

</body></html>