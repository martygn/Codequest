<!DOCTYPE html>
<html lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Jueces - CodeQuest</title>
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
@include('admin._sidebar')
<main class="flex-1 p-8 overflow-y-auto">
<div class="max-w-7xl mx-auto">
<header class="mb-8 flex items-center justify-between">
<div>
<h2 class="text-4xl font-bold text-slate-900 dark:text-white">Jueces</h2>
<p class="text-slate-500 dark:text-slate-400 mt-1">Gestiona los jueces del sistema</p>
</div>
<a href="{{ route('admin.jueces.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition font-semibold">Nuevo juez</a>
</header>

@if(session('success'))
<div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
    {{ session('success') }}
</div>
@endif

<div class="bg-white dark:bg-slate-900 rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
<table class="w-full text-left">
<thead class="border-b border-slate-200 dark:border-slate-800">
<tr>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Nombre</th>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Correo</th>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Asignaciones</th>
<th class="p-4 font-semibold text-slate-600 dark:text-slate-400">Acciones</th>
</tr>
</thead>
<tbody>
@forelse($jueces as $j)
<tr class="border-b border-slate-200 dark:border-slate-800">
<td class="p-4 text-slate-800 dark:text-slate-200">{{ $j->nombre }} {{ $j->apellido_paterno }}</td>
<td class="p-4 text-slate-500 dark:text-slate-400">{{ $j->correo }}</td>
<td class="p-4">
    <?php
        $asigs = \DB::table('juez_evento')->where('usuario_id', $j->id)->join('eventos', 'juez_evento.evento_id', '=', 'eventos.id_evento')->pluck('eventos.nombre');
    ?>
    <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
        {{ $asigs->count() > 0 ? $asigs->count() . ' evento(s)' : 'Sin asignaciones' }}
    </span>
</td>
<td class="p-4">
    <a href="{{ route('admin.jueces.asignar-eventos', $j->id) }}" class="font-medium text-primary hover:underline mr-4">Asignar</a>
</td>
</tr>
@empty
<tr>
    <td colspan="4" class="p-4 text-center text-slate-500 dark:text-slate-400">No hay jueces creados.</td>
</tr>
@endforelse
</tbody>
</table>
</div>

@if(method_exists($jueces, 'links') && $jueces->hasPages())
<div class="px-4 py-3 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 rounded-b-lg">
    {{ $jueces->links() }}
</div>
@endif
</div>
</main>
</div>

</body></html>