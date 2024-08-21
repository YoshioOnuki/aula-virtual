<div>

    @livewire('components.page-header', [
        'titulo_pasos' => $titulo_page_header,
        'titulo' => $titulo_page_header,
        'links_array' => $links_page_header,
        'regresar' => $regresar_page_header
    ])

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
                @livewire('components.info-alumnos-docentes', [
                    'usuario' => $usuario,
                    'tipo_vista' => $tipo_vista
                ])
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-stamp card-stamp-lg">
                            @if ($tipo_vista === 'cursos')
                                <div class="card-stamp-icon bg-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 5h8" />
                                        <path d="M13 9h5" />
                                        <path d="M13 15h8" />
                                        <path d="M13 19h5" />
                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    </svg>
                                </div>
                            @elseif($tipo_vista === 'carga-academica')
                                <div class="card-stamp-icon bg-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 5h8" />
                                        <path d="M13 9h5" />
                                        <path d="M13 15h8" />
                                        <path d="M13 19h5" />
                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            {{-- Titulo de la tarea --}}
                            <h4 class="card-title">
                                {{ $trabajo_academico->titulo_trabajo_academico }}
                            </h4>

                            {{-- Fecha de inicio y fin --}}
                            <p class="card-text">
                                <small class="text-muted
                                    d-none d-sm-block">
                                    Fecha de inicio: {{ format_fecha($trabajo_academico->fecha_inicio_trabajo_academico) }}
                                    - {{ format_hora($trabajo_academico->fecha_inicio_trabajo_academico) }}
                                </small>
                                <small class="text-muted
                                    d-none d-sm-block mt-2">
                                    Fecha de fin: {{ format_fecha($trabajo_academico->fecha_fin_trabajo_academico) }} - {{
                                    format_hora($trabajo_academico->fecha_fin_trabajo_academico) }}
                                </small>
                            </p>

                            {{-- Descripcion de la tarea --}}
                            <div>

                                <div class="hr-text hr-text-center ">
                                    <span>
                                        Descripción
                                    </span>
                                </div>

                                <p class="card-text">
                                    {{ $trabajo_academico->descripcion_trabajo_academico }}
                                </p>
                            </div>

                            @if($trabajo_academico->archivoDocente->count() > 0)
                                {{-- Archivos adjuntos --}}
                                <div class="">

                                    <div class="hr-text hr-text-center ">
                                        <span>
                                            Archivos adjuntos
                                        </span>
                                    </div>

                                    <div class="row g-2">
                                        @foreach ($trabajo_academico->archivoDocente as $archivo)
                                            <div class="col-6 col-md-3 col-lg-4 col-xl-4">
                                                <a class="card p-3 mb-3 text-decoration-none cursor-pointer" wire:click="descargar_archivo({{ $archivo->id_archivo_docente }})">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ obtener_icono_archivo($archivo->archivo_docente) }}"
                                                                alt="icono-recurso" class="me-2" width="40">
                                                        <div>
                                                            <h5 class="mb-0 text-dark">
                                                                {{ $archivo->nombre_archivo_docente }}
                                                            </h5>
                                                            <small class="text-muted d-block mt-1 fw-light">
                                                                {{ formato_tamano_archivo(filesize($archivo->archivo_docente)) }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($tipo_vista === 'cursos')
                                <div class="card-footer d-flex justify-content-end align-items-center mt-4">
                                    <a
                                        class="btn btn-primary">
                                        Entregar
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    @livewire('components.card-estado-trabajo', [
                        'trabajo_academico' => $trabajo_academico,
                        'tipo_vista' => $tipo_vista,
                        'id_gestion_aula' => $id_gestion_aula
                    ])
                </div>

            </div>
        </div>
    </div>

</div>

