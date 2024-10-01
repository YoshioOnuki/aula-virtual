<div class="card card-stacked animate__animated animate__fadeIn">
    <div class="card-header bg-teal-lt">
        <span class="text-teal me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                    d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                <path d="M9 7l4 0" />
                <path d="M9 11l4 0" />
            </svg>
        </span>
        <h3 class="card-title fw-semibold">Orientaciones Generales</h3>
    </div>
    <div class="card-body px-5">
        @if($orientaciones_generales)
        <span>
            {!! $orientaciones_generales->descripcion_presentacion !!}
        </span>
        @else
        <span class="text-muted" style="text-align: justify;">
            Actualmente no hay orientaciones generales disponibles para este curso.
            Por favor, revisa más tarde o consulta con el <strong>docente</strong> del curso
            para más información.
        </span>
        @endif
    </div>
</div>
