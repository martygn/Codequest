<!DOCTYPE html>
<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Configuración de Cuenta</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<style>
    .material-symbols-outlined {
      font-variation-settings:
      'FILL' 0,
      'wght' 400,
      'GRAD' 0,
      'opsz' 24
    }
  </style>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#E53965",
            "background-light": "#FFFFFF",
            "background-dark": "#111827",
            "surface-light": "#F3F4F6",
            "surface-dark": "#1F2937",
            "text-light-primary": "#1F2937",
            "text-dark-primary": "#F9FAFB",
            "text-light-secondary": "#6B7280",
            "text-dark-secondary": "#9CA3AF",
            "border-light": "#E5E7EB",
            "border-dark": "#374151"
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
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary">
<div class="flex min-h-screen">
<aside class="w-64 p-6 shrink-0">
<h1 class="text-2xl font-bold mb-12">CodeQuest</h1>
<nav>
<ul class="space-y-2">
<li>
<a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">home</span>
<span>Panel de control</span>
</a>
</li>
<li>
<a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.eventos') }}">
<span class="material-symbols-outlined">calendar_today</span>
<span>Eventos</span>
</a>
</li>
<li>
<a class="flex items-center gap-3 px-4 py-2 rounded text-text-light-secondary dark:text-text-dark-secondary hover:bg-surface-light dark:hover:bg-surface-dark transition-colors" href="{{ route('admin.equipos') }}">
<span class="material-symbols-outlined">groups</span>
<span>Equipos</span>
</a>
</li>

<li>
<a class="flex items-center gap-3 px-4 py-2 rounded bg-surface-light dark:bg-surface-dark font-semibold text-text-light-primary dark:text-text-dark-primary transition-colors" href="{{ route('admin.configuracion') }}">
<span class="material-symbols-outlined">settings</span>
<span>Configuración</span>
</a>
</li>
</ul>
</nav>


</aside>
<main class="flex-1 p-10">
<div class="max-w-3xl">
<h2 class="text-4xl font-bold mb-10 text-text-light-primary dark:text-text-dark-primary">Configuración</h2>
<section class="mb-12">
<h3 class="text-2xl font-bold mb-6 text-text-light-primary dark:text-text-dark-primary">Información Personal</h3>
<form class="space-y-6">
<div>
<label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="nombre">Nombre</label>
<input class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-light-secondary placeholder:dark:text-text-dark-secondary focus:ring-primary focus:border-primary" id="nombre" placeholder="Ingrese su nombre" type="text"/>
</div>
<div>
<label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="email">Correo electrónico</label>
<input class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark placeholder:text-text-light-secondary placeholder:dark:text-text-dark-secondary focus:ring-primary focus:border-primary" id="email" placeholder="Ingrese su correo electrónico" type="email"/>
</div>
<div>
<button class="bg-primary text-white font-semibold py-2 px-6 rounded hover:opacity-90 transition-opacity" type="submit">Guardar Cambios</button>
</div>
</form>
</section>
<section>
<h3 class="text-2xl font-bold mb-6 text-text-light-primary dark:text-text-dark-primary">Seguridad de la Cuenta</h3>
<form class="space-y-6">
<div>
<label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="current_password">Contraseña Actual</label>
<input class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-primary focus:ring-primary focus:border-primary" id="current_password" type="password" value="********" readonly/>
</div>
<div>
<label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="new_password">Nueva Contraseña</label>
<input class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-primary focus:ring-primary focus:border-primary" id="new_password" type="password" placeholder="Ingrese la nueva contraseña"/>
</div>
<div>
<label class="block text-sm font-medium mb-2 text-text-light-secondary dark:text-text-dark-secondary" for="confirm_password">Confirmar Nueva Contraseña</label>
<input class="w-full max-w-md rounded border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark text-primary focus:ring-primary focus:border-primary" id="confirm_password" type="password" placeholder="Ingrese la nueva contraseña"/>
</div>
<div>
<button class="bg-primary text-white font-semibold py-2 px-6 rounded hover:opacity-90 transition-opacity" type="submit">Cambiar Contraseña</button>
</div>
</form>
</section>
</div>
</main>
</div>

</body></html>