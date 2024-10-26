<div class="card card-md card-stacked animate__animated animate__fadeIn">
    <div class="card-stamp card-stamp-lg">
        {{-- Icono --}}
        @if ($tipo_vista === 'cursos')
            <div class="card-stamp-icon bg-teal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-messages">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                    <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                </svg>
            </div>
        @elseif($tipo_vista === 'carga-academica')
            <div class="card-stamp-icon bg-orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-messages">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                    <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                </svg>
            </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row row-cards d-flex justify-content-start">
            <div class="d-flex align-items-start">
                <img src="{{ asset($foro->gestionAulaDocente->usuario->mostrarFoto('docente')) }}" alt="avatar"
                    class="avatar me-2 rounded avatar-static">
                <div class="flex-fill">
                    <div class="fw-bold fs-3">
                        {{ $foro->titulo_foro }}
                    </div>

                    <div class="text-secondary">
                            De
                            <a class="cursor-pointer">
                                {{ $foro->gestionAulaDocente->usuario->nombre_completo }}
                            </a> - {{ format_fecha_completa($foro->created_at) }}
                    </div>

                    <p class="mt-4">
                        {!! $foro->descripcion_foro !!}
                    </p>

                    {{-- Boton de responder --}}
                    <div class="mt-4">
                        <button class="btn btn-primary"
                            wire:click="responder_foro">
                            Responder
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
