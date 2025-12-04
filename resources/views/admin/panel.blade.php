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

        <!-- Equipos: gráfico grande a la izquierda, tarjetas a la derecha, tabla debajo del gráfico -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Columna principal: gráfico + tabla -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Distribución de estados</h3>
                            <p class="text-sm text-text-secondary-light dark:text-text-secondary-dark">Visión rápida del estado actual de los equipos</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="relative w-full h-56">
                            <canvas id="teamsChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-card-light dark:bg-card-dark p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold mb-4">Equipos recientes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-border-light dark:divide-border-dark">
                            <thead>
                                <tr class="text-left text-sm text-text-secondary-light dark:text-text-secondary-dark">
                                    <th class="px-4 py-3">Proyecto</th>
                                    <th class="px-4 py-3">Miembros</th>
                                    <th class="px-4 py-3">Estado</th>
                                    <th class="px-4 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-card-dark divide-y divide-border-light dark:divide-border-dark">
                                @foreach($equipos ?? [] as $equipo)
                                <tr class="text-sm text-text-light dark:text-text-dark">
                                    <td class="px-4 py-4">{{ $equipo->nombre_proyecto ?: $equipo->nombre }}</td>
                                    <td class="px-4 py-4">{{ $equipo->participantes_count }}</td>
                                    <td class="px-4 py-4">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium "
                                              style="background: {{ $equipo->estado === 'aprobado' ? '#ECFDF5' : ($equipo->estado === 'rechazado' ? '#FEF2F2' : '#FFFBEB') }}; color: {{ $equipo->estado === 'aprobado' ? '#065F46' : ($equipo->estado === 'rechazado' ? '#991B1B' : '#92400E') }};">
                                            {{ $equipo->estado }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <a href="{{ route('equipos.show', $equipo->id_equipo) }}" class="text-primary mr-4">Ver</a>
                                        @if(auth()->user() && auth()->user()->esAdmin())
                                        <form method="POST" action="{{ route('equipos.update-status', $equipo->id_equipo) }}" class="inline-block ajax-status">
                                            @csrf
                                            @method('PATCH')
                                            <select name="estado" class="border px-3 py-1 rounded-full text-sm mr-2">
                                                <option value="en revisión" {{ $equipo->estado === 'en revisión' ? 'selected' : '' }}>En revisión</option>
                                                <option value="aprobado" {{ $equipo->estado === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                                <option value="rechazado" {{ $equipo->estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
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
                </div>
            </div>

            <!-- Columna derecha: tarjetas de estado eliminadas (conteos removidos de la vista) -->
        </div>
    </main>
</div>

                <!-- Chart.js CDN + panel script -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    (function(){
                        const statsUrl = "{{ route('admin.equipos.stats') }}";
                        const initial = { en_revision: 0, aprobado: 0, rechazado: 0 };

                        const ctx = document.getElementById('teamsChart');
                        let teamsChart = null;

                        function buildChart(data) {
                            try {
                                const values = [data.en_revision || 0, data.aprobado || 0, data.rechazado || 0];
                                if (!teamsChart) {
                                    const ctx2d = ctx && ctx.getContext ? ctx.getContext('2d') : null;
                                    if (!ctx2d) return;
                                    teamsChart = new Chart(ctx2d, {
                                        type: 'doughnut',
                                        data: {
                                            labels: ['En revisión','Aprobados','Rechazados'],
                                            datasets: [{
                                                data: values,
                                                backgroundColor: ['#F59E0B','#10B981','#EF4444']
                                            }]
                                        },
                                        options: { responsive: true, maintainAspectRatio: false }
                                    });
                                } else {
                                    teamsChart.data.datasets[0].data = values;
                                    teamsChart.update();
                                }
                            } catch (err) {
                                console.error('Error construyendo la gráfica:', err);
                            }
                        }

                        // Eliminada: la actualización de conteos numéricos en la vista (las tarjetas fueron removidas)

                        async function fetchStats() {
                            try {
                                const res = await fetch(statsUrl, { headers: { 'Accept': 'application/json' } });
                                if (!res.ok) return;
                                const json = await res.json();
                                const data = json.estadisticas || {};
                                buildChart(data);
                            } catch (e) {
                                console.error('Error fetching stats', e);
                            }
                        }

                        // Inicializar
                        if (ctx) {
                            buildChart(initial);
                        }

                        // Polling cada 4 segundos
                        setInterval(fetchStats, 4000);

                        // Interceptar formularios AJAX de cambio de estado
                        document.addEventListener('submit', async function(e){
                            const form = e.target;
                            if (!form.classList || !form.classList.contains('ajax-status')) return;
                            e.preventDefault();
                            const action = form.action;
                            const tokenInput = form.querySelector('input[name="_token"]');
                            const token = tokenInput ? tokenInput.value : '';
                            const estado = form.querySelector('select[name="estado"]').value;

                            try {
                                const res = await fetch(action, {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': token
                                    },
                                    body: JSON.stringify({ estado })
                                });
                                if (!res.ok) {
                                    const txt = await res.text();
                                    alert('Error actualizando estado');
                                    return;
                                }
                                const json = await res.json();
                                if (json.estadisticas) {
                                    buildChart(json.estadisticas);
                                }

                                // Actualizar la celda de estado en la fila donde se envió el formulario
                                try {
                                    const nuevoEstado = json.estado || (json.estadisticas && json.estadisticas.estado) || null;
                                    if (nuevoEstado) {
                                        const row = form.closest('tr');
                                        if (row) {
                                            const tds = row.querySelectorAll('td');
                                            if (tds && tds.length >= 3) {
                                                const estadoCell = tds[2];
                                                const estadoNorm = (nuevoEstado || '').toString().toLowerCase().trim();
                                                let bg = '#FFFBEB';
                                                let color = '#92400E';
                                                if (estadoNorm === 'aprobado') { bg = '#ECFDF5'; color = '#065F46'; }
                                                if (estadoNorm === 'rechazado') { bg = '#FEF2F2'; color = '#991B1B'; }
                                                estadoCell.innerHTML = `<span class="inline-block px-3 py-1 rounded-full text-xs font-medium" style="background: ${bg}; color: ${color};">${nuevoEstado}</span>`;
                                            }
                                        }
                                    }
                                } catch (err) {
                                    console.warn('No fue posible actualizar la celda de estado en la fila:', err);
                                }
                            } catch (err) {
                                console.error(err);
                                alert('Error al actualizar el estado.');
                            }
                        });
                    })();
                </script>

            </body>
            </html>
