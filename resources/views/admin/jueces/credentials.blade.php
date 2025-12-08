<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Credenciales de Juez - CodeQuest</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
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
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200">
<div class="flex h-screen items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Tarjeta principal -->
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-slate-200 dark:border-slate-800 p-8">
            <!-- Encabezado con icono -->
            <div class="flex items-center justify-center mb-6">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-4xl">check_circle</span>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-center text-slate-900 dark:text-white mb-2">¡Juez Creado!</h1>
            <p class="text-center text-slate-500 dark:text-slate-400 mb-6">Las credenciales se han generado correctamente</p>

            @if(!$emailEnviado)
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-6">
                <p class="text-sm text-amber-700 dark:text-amber-300">
                    <span class="font-semibold">⚠️ Nota:</span> No se pudo enviar el correo. Copia las credenciales a continuación.
                </p>
            </div>
            @else
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                <p class="text-sm text-green-700 dark:text-green-300">
                    <span class="font-semibold">✓</span> Las credenciales también fueron enviadas al correo del juez.
                </p>
            </div>
            @endif

            <!-- Datos del juez -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4 mb-6 space-y-4">
                <div>
                    <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Nombre Completo</label>
                    <p class="text-slate-900 dark:text-white font-medium">{{ $juez->nombre_completo }}</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Correo (Usuario)</label>
                    <div class="flex items-center gap-2 mt-1">
                        <input type="text" id="emailInput" value="{{ $juez->correo }}" readonly class="flex-1 px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded text-slate-900 dark:text-white text-sm"/>
                        <button onclick="copiarAlPortapapeles('emailInput')" class="p-2 bg-primary text-white rounded hover:bg-blue-600 transition">
                            <span class="material-symbols-outlined text-lg">content_copy</span>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-600 dark:text-slate-400">Contraseña (Temporal)</label>
                    <div class="flex items-center gap-2 mt-1">
                        <input type="password" id="passwordInput" value="{{ $password }}" readonly class="flex-1 px-3 py-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded text-slate-900 dark:text-white text-sm"/>
                        <button onclick="alternarMostrarContraseña()" class="p-2 bg-slate-300 dark:bg-slate-700 text-slate-900 dark:text-white rounded hover:bg-slate-400 dark:hover:bg-slate-600 transition">
                            <span class="material-symbols-outlined text-lg" id="eyeIcon">visibility</span>
                        </button>
                        <button onclick="copiarAlPortapapeles('passwordInput')" class="p-2 bg-primary text-white rounded hover:bg-blue-600 transition">
                            <span class="material-symbols-outlined text-lg">content_copy</span>
                        </button>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded p-3 text-sm text-blue-700 dark:text-blue-300">
                    <span class="font-semibold">💡 Importante:</span> El juez debe cambiar su contraseña la primera vez que inicie sesión.
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('admin.jueces') }}" class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                    Volver al Listado de Jueces
                </a>
                <a href="{{ route('admin.jueces.create') }}" class="w-full px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-white rounded-lg hover:bg-slate-300 dark:hover:bg-slate-700 transition font-semibold text-center">
                    Crear Otro Juez
                </a>
            </div>

            <!-- Enlace de acceso -->
            <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800 text-center">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">El juez puede acceder aquí:</p>
                <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">
                    {{ url('login') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function copiarAlPortapapeles(elementId) {
        const elemento = document.getElementById(elementId);
        const texto = elemento.value;
        
        navigator.clipboard.writeText(texto).then(() => {
            // Mostrar retroalimentación visual
            const boton = event.target.closest('button');
            const textoOriginal = boton.innerHTML;
            boton.innerHTML = '<span class="material-symbols-outlined text-lg">check</span>';
            setTimeout(() => {
                boton.innerHTML = textoOriginal;
            }, 2000);
        }).catch(() => {
            alert('No se pudo copiar el texto');
        });
    }

    function alternarMostrarContraseña() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('eyeIcon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
</body>
</html>
