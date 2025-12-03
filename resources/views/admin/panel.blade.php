<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Panel de control - Administrador</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#007BFF",
                        "background-light": "#F7F8FC",
                        "background-dark": "#121212",
                        "card-light": "#FFFFFF",
                        "card-dark": "#1E1E1E",
                        "text-light": "#111827",
                        "text-dark": "#E5E7EB",
                        "text-secondary-light": "#6B7280",
                        "text-secondary-dark": "#9CA3AF",
                        "border-light": "#E5E7EB",
                        "border-dark": "#374151",
                        "active-light": "#E9F2FF",
                        "active-dark": "#253448",
                        normal: "#3B82F6",
                        moderately: "#DC2626",
                        severely: "#84CC16"
                    },
                    fontFamily: {
                        display: ["Roboto", "sans-serif"],
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
            font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark">
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-card-light dark:bg-card-dark border-r border-border-light dark:border-border-dark flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">CodeQuest</h1>
        </div>
        <nav class="flex-grow px-4">
            <ul class="space-y-2">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-light dark:bg-active-dark font-semibold" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">home</span>
                        <span>Panel de control</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_month</span>
                        <span>Eventos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.perfil') }}">
                        <span class="material-symbols-outlined">person</span>
                        <span>Perfil</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-light dark:text-text-secondary-dark hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Logout Link -->
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

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        <header class="mb-8">
            <h2 class="text-4xl font-bold text-text-light dark:text-text-dark">Panel de control</h2>
        </header>

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-text-secondary-light dark:text-text-secondary-dark">search</span>
                <input class="w-full pl-12 pr-4 py-3 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent placeholder-text-secondary-light dark:placeholder-text-secondary-dark" placeholder="Buscar eventos" type="text"/>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-border-light dark:border-border-dark mb-6">
            <nav class="flex space-x-8 -mb-px">
                <a class="py-4 px-1 text-primary border-b-2 border-primary font-semibold whitespace-nowrap">Equipos</a>
            </nav>
        </div>

        <!-- Statistics Chart -->
        <div class="bg-card-light dark:bg-card-dark p-6 rounded-lg shadow-sm">
            <div class="flex flex-col md:flex-row items-center justify-around gap-8">
                <!-- Chart -->
                <div class="relative w-64 h-64 md:w-80 md:h-80">
                    <svg class="transform -rotate-90" viewBox="0 0 100 100">
                        <circle class="stroke-normal" cx="50" cy="50" fill="transparent" r="45" stroke-width="10"></circle>
                        <circle class="stroke-moderately" cx="50" cy="50" fill="transparent" r="45" stroke-dasharray="282.74" stroke-dashoffset="152.68" stroke-width="10"></circle> 
                        <circle class="stroke-severely" cx="50" cy="50" fill="transparent" r="45" stroke-dasharray="282.74" stroke-dashoffset="87.65" stroke-width="10"></circle> 
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-sm font-medium text-white" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">46%</span>
                        <span class="text-sm font-medium text-white absolute" style="transform: translate(60px, -70px); text-shadow: 0 1px 2px rgba(0,0,0,0.4);">31%</span>
                        <span class="text-sm font-medium text-white absolute" style="transform: translate(-30px, 75px); text-shadow: 0 1px 2px rgba(0,0,0,0.4);">23%</span>
                    </div>
                </div>

                <!-- Legend -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="w-4 h-4 rounded-sm bg-normal mr-3"></span>
                        <span class="text-lg">Aprobados</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 rounded-sm bg-moderately mr-3"></span>
                        <span class="text-lg">Rechazados</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 rounded-sm bg-severely mr-3"></span>
                        <span class="text-lg">Pendientes</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>
                // Ajustar tamaño del canvas al contenedor
                ctx.width = ctx.parentElement.clientWidth;
                ctx.height = ctx.parentElement.clientHeight;

                new Chart(ctx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Aprobados', 'Rechazados', 'Pendientes'],
                        datasets: [{
                            data: data,
                            backgroundColor: [getComputedStyle(document.documentElement).getPropertyValue('--tw-color-normal') || '#3B82F6', '#DC2626', '#84CC16'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
                // Hacer clic en el canvas redirige a la vista de Eventos
                try {
                    const redirectUrl = "{{ route('admin.eventos') }}";
                    ctx.addEventListener('click', function() {
                        window.location.href = redirectUrl;
                    });
                } catch (e) {
                    // no hacer nada si falla la redirección
                }
            }
        })();
    </script>

</body>
</html>
