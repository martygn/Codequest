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
