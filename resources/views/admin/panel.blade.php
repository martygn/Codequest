<!DOCTYPE html>
<html lang="es" class="dark"> <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de control - Administrador</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class", // Habilitar modo oscuro manual
            theme: {
                extend: {
                    colors: {
                        // PALETA "DARK TECH" INTEGRADA
                        primary: "#64FFDA", // Turquesa (Botones, Acentos)
                        
                        // Fondos
                        "background-light": "#F7F8FC", // (No se usará, pero se deja por compatibilidad)
                        "background-dark": "#0A192F",  // Azul Muy Oscuro (Fondo Principal)
                        
                        // Tarjetas y Sidebar
                        "card-light": "#FFFFFF",
                        "card-dark": "#112240",        // Azul Profundo (Tarjetas)
                        
                        // Textos
                        "text-light": "#111827",
                        "text-dark": "#CCD6F6",        // Azul Claro (Títulos)
                        "text-secondary-light": "#6B7280",
                        "text-secondary-dark": "#8892B0", // Gris Azulado (Texto secundario)
                        
                        // Bordes
                        "border-light": "#E5E7EB",
                        "border-dark": "#233554",      // Azul Marino (Bordes sutiles)
                        
                        // Estados
                        "active-light": "#E9F2FF",
                        "active-dark": "rgba(100, 255, 218, 0.1)", // Turquesa transparente para items activos
                    },
                    fontFamily: {
                        display: ["Roboto", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        /* Scrollbar personalizada para el tema oscuro */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0A192F; 
        }
        ::-webkit-scrollbar-thumb {
            background: #233554; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #64FFDA; 
        }
    </style>
</head>
<body class="font-display bg-background-dark text-text-dark antialiased">

<div class="flex h-screen overflow-hidden">
    
    <aside class="w-64 bg-card-dark border-r border-border-dark flex flex-col shadow-xl z-20">
        <div class="p-6 flex items-center gap-3">
            <img src="{{ asset('log.png') }}" alt="CodeQuest Logo" class="h-20 w-auto">
            
            <h1 class="text-2xl font-bold text-text-dark tracking-tight">CodeQuest</h1>
        </div>
        
        <nav class="flex-grow px-4 py-4 overflow-y-auto">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary bg-active-dark font-medium border-l-2 border-primary" href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Panel de control</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.eventos') }}">
                        <span class="material-symbols-outlined">calendar_today</span>
                        <span>Eventos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.equipos') }}">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Equipos</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.jueces') }}">
                        <span class="material-symbols-outlined">gavel</span>
                        <span>Jueces</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.resultados-panel') }}">
                        <span class="material-symbols-outlined">bar_chart</span>
                        <span>Resultados</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-primary hover:bg-white/5 transition-all duration-200" href="{{ route('admin.configuracion') }}">
                        <span class="material-symbols-outlined">settings</span>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="p-4 border-t border-border-dark">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-text-secondary-dark hover:text-red-400 hover:bg-red-500/10 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto bg-background-dark relative">
        
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

        <header class="mb-8 relative z-10">
            <h2 class="text-3xl font-bold text-text-dark">Panel de Control</h2>
            <p class="text-text-secondary-dark text-sm mt-1">Bienvenido al sistema de administración.</p>
        </header>

        <div class="border-b border-border-dark mb-8 relative z-10">
            <nav class="flex space-x-8 -mb-px">
                <a class="py-4 px-2 text-primary border-b-2 border-primary font-medium whitespace-nowrap cursor-pointer">
                    Resumen de Equipos
                </a>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-6 relative z-10">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-card-dark p-6 rounded-xl shadow-lg border border-border-dark">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-text-dark">Distribución de Estados</h3>
                            <p class="text-sm text-text-secondary-dark">Panorama general de inscripciones</p>
                        </div>
                        <div class="p-2 bg-white/5 rounded-lg">
                            <span class="material-symbols-outlined text-primary">pie_chart</span>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-center">
                        <div class="relative w-full h-64 max-w-sm">
                            <canvas id="teamsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="bg-card-dark p-6 rounded-xl shadow-lg border border-border-dark">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-text-dark">Equipos Recientes</h3>
                        <a href="{{ route('admin.equipos') }}" class="text-xs text-primary hover:underline">Ver todos</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-border-dark">
                            <thead>
                                <tr class="text-left text-xs font-mono text-primary uppercase tracking-wider">
                                    <th class="px-4 py-3">Nombre</th>
                                    <th class="px-4 py-3">Proyecto</th>
                                    <th class="px-4 py-3 text-center">Miembros</th>
                                    <th class="px-4 py-3 text-center">Estado</th>
                                    <th class="px-4 py-3 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-dark">
                                @foreach($equipos ?? [] as $equipo)
                                <tr class="text-sm text-text-secondary-dark hover:bg-white/5 transition-colors">
                                    <td class="px-4 py-4 font-medium text-text-dark">{{ $equipo->nombre }}</td>
                                    <td class="px-4 py-4">{{ $equipo->nombre_proyecto ?: 'Sin proyecto' }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="bg-white/5 px-2 py-1 rounded text-xs">{{ $equipo->participantes_count }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $badgeClass = match($equipo->estado) {
                                                'aprobado' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                                'rechazado' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                                default => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20'
                                            };
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border {{ $badgeClass }}">
                                            {{ ucfirst($equipo->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.equipos.show', $equipo->id_equipo) }}" class="text-text-secondary-dark hover:text-primary transition-colors">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </a>
                                            
                                            @if(auth()->user() && auth()->user()->esAdmin())
                                            <form method="POST" action="{{ route('equipos.update-status', $equipo->id_equipo) }}" class="inline-block ajax-status">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center gap-2">
                                                    <select name="estado" class="bg-[#0A192F] border border-border-dark text-xs rounded text-text-secondary-dark focus:border-primary focus:ring-1 focus:ring-primary outline-none py-1">
                                                        <option value="en revisión" {{ $equipo->estado === 'en revisión' ? 'selected' : '' }}>Revisión</option>
                                                        <option value="aprobado" {{ $equipo->estado === 'aprobado' ? 'selected' : '' }}>Aprobar</option>
                                                        <option value="rechazado" {{ $equipo->estado === 'rechazado' ? 'selected' : '' }}>Rechazar</option>
                                                    </select>
                                                    <button type="submit" class="text-primary hover:text-white transition-colors">
                                                        <span class="material-symbols-outlined text-lg">save</span>
                                                    </button>
                                                </div>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gradient-to-br from-card-dark to-[#1d2d50] p-6 rounded-xl shadow-lg border border-border-dark">
                    <h4 class="text-primary font-bold mb-2">Estado del Sistema</h4>
                    <div class="flex items-center gap-2 text-green-400 text-sm mb-4">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        Operativo
                    </div>
                    <p class="text-text-secondary-dark text-sm">
                        El panel de administración está conectado y recibiendo datos en tiempo real.
                    </p>
                </div>
            </div>

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuración global de Chart.js para el tema oscuro
    Chart.defaults.color = '#8892B0';
    Chart.defaults.borderColor = '#233554';

    document.addEventListener('DOMContentLoaded', function () {
        let teamsChart = null;
        const ctx = document.getElementById('teamsChart');

        if (!ctx) {
            console.error('Canvas no encontrado');
            return;
        }

        async function loadStats() {
            try {
                const res = await fetch("{{ route('admin.equipos.stats') }}", {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                const stats = data.estadisticas || { en_revision: 0, aprobado: 0, rechazado: 0 };

                const valores = [stats.en_revision, stats.aprobado, stats.rechazado];

                if (!teamsChart) {
                    teamsChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['En revisión', 'Aprobados', 'Rechazados'],
                            datasets: [{
                                data: valores,
                                // Colores adaptados al tema: Amarillo, Turquesa (Primary), Rojo
                                backgroundColor: ['#F59E0B', '#64FFDA', '#EF4444'], 
                                borderColor: '#112240', // Color del fondo de la tarjeta para separar segmentos
                                borderWidth: 4,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { 
                                    position: 'bottom', 
                                    labels: { 
                                        padding: 20,
                                        usePointStyle: true,
                                        color: '#CCD6F6' // Texto claro
                                    } 
                                }
                            },
                            cutout: '70%' // Dona más delgada y elegante
                        }
                    });
                } else {
                    teamsChart.data.datasets[0].data = valores;
                    teamsChart.update();
                }
            } catch (e) {
                console.error('Error cargando stats:', e);
            }
        }

        loadStats();
        setInterval(loadStats, 6000);

        // CAMBIO DE ESTADO CON AJAX (Tu lógica intacta, solo estilos en el DOM manipulation)
        document.addEventListener('submit', async function(e) {
            const form = e.target;
            if (!form.classList.contains('ajax-status')) return;

            e.preventDefault();

            const estado = form.querySelector('select[name="estado"]').value;
            const row = form.closest('tr');
            const nombreEquipo = row.cells[0].textContent.trim();

            try {
                const res = await fetch(form.action, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ estado })
                });

                if (!res.ok) throw new Error('Error HTTP ' + res.status);

                const json = await res.json();

                // Actualizar celda de estado con los nuevos estilos de badges
                const cell = row.cells[3];
                let cssClass = 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20';
                
                if (estado === 'aprobado') { cssClass = 'bg-green-500/10 text-green-400 border-green-500/20'; }
                if (estado === 'rechazado') { cssClass = 'bg-red-500/10 text-red-400 border-red-500/20'; }

                cell.innerHTML = `
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium border ${cssClass}">
                        ${estado.charAt(0).toUpperCase() + estado.slice(1)}
                    </span>
                `;

                if (json.estadisticas) {
                    const valores = [
                        json.estadisticas.en_revision || 0,
                        json.estadisticas.aprobado || 0,
                        json.estadisticas.rechazado || 0
                    ];
                    teamsChart.data.datasets[0].data = valores;
                    teamsChart.update();
                }

                // Toast Notification estilo Dark
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-6 right-6 bg-[#112240] border border-primary text-primary px-6 py-4 rounded-lg shadow-2xl z-50 flex items-center gap-3 animate-bounce';
                toast.innerHTML = `<span class="material-symbols-outlined">check_circle</span> <span><strong>${nombreEquipo}</strong> actualizado a ${estado}</span>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);

            } catch (err) {
                console.error(err);
                alert('Error al actualizar el estado del equipo');
            }
        });
    });
</script>

</body>
</html>