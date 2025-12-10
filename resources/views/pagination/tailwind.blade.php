@if ($paginator->hasPages())
    <nav class="flex items-center justify-between gap-4 mt-8">
        {{-- Información de páginas --}}
        <div class="text-sm text-text-secondary-dark">
            Mostrando <span class="font-semibold">{{ $paginator->firstItem() }}</span> a 
            <span class="font-semibold">{{ $paginator->lastItem() }}</span> de 
            <span class="font-semibold">{{ $paginator->total() }}</span> resultados
        </div>

        {{-- Enlaces de paginación --}}
        <div class="flex items-center gap-2">
            {{-- Botón anterior --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 rounded-lg bg-border-dark/30 text-text-secondary-dark opacity-50 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_left</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 rounded-lg bg-card-dark border border-border-dark text-text-secondary-dark hover:text-primary hover:border-primary transition">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            @endif

            {{-- Números de página --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-text-secondary-dark">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 rounded-lg bg-primary text-background-dark font-bold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 rounded-lg bg-card-dark border border-border-dark text-text-secondary-dark hover:text-primary hover:border-primary transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 rounded-lg bg-card-dark border border-border-dark text-text-secondary-dark hover:text-primary hover:border-primary transition">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            @else
                <span class="px-3 py-2 rounded-lg bg-border-dark/30 text-text-secondary-dark opacity-50 cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_right</span>
                </span>
            @endif
        </div>
    </nav>
@endif
