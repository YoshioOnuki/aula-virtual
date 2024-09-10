<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header lazy />

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
                <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn  ">
                        <div class="card-stamp card-stamp-lg">
                            @if ($tipo_vista === 'cursos')
                            <div class="card-stamp-icon bg-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 5h8" />
                                    <path d="M13 9h5" />
                                    <path d="M13 15h8" />
                                    <path d="M13 19h5" />
                                    <path
                                        d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    <path
                                        d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                </svg>
                            </div>
                            @elseif($tipo_vista === 'carga-academica')
                            <div class="card-stamp-icon bg-orange">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 5h8" />
                                    <path d="M13 9h5" />
                                    <path d="M13 15h8" />
                                    <path d="M13 19h5" />
                                    <path
                                        d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    <path
                                        d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            {{-- Titulo de la tarea --}}
                            <h3 class="card-title fw-semibold">
                                Entrega Académica
                            </h3>

                            {{-- Descripcion de la tarea --}}
                            <p class="card-text">
                                <small class="text-muted d-none d-sm-block">
                                    {!! $trabajo_academico_alumno->descripcion_trabajo_academico_alumno !!}
                                </small>
                            </p>

                            @if($trabajo_academico->archivoDocente->count() > 0)
                                {{-- Archivos adjuntos --}}
                                <div class="">
                                    <div class="hr-text hr-text-center ">
                                        <span>
                                            Archivos adjuntos
                                        </span>
                                    </div>

                                    <div class="row g-2">
                                        @foreach ($trabajo_academico_alumno->archivoAlumno as $archivo)
                                            @if (file_exists($archivo->archivo_alumno))
                                            <div class="col-6 col-md-3 col-lg-4 col-xl-4">
                                                <a class="card p-3 mb-3 text-decoration-none cursor-pointer"
                                                    wire:click="descargar_archivo({{ $archivo->id_archivo_alumno }})">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ obtener_icono_archivo($archivo->archivo_alumno) }}"
                                                            alt="icono-recurso" class="me-2" width="40">
                                                        <div>
                                                            <h5 class="mb-0">
                                                                {{ Str::limit($archivo->nombre_archivo_alumno, 20) }}
                                                            </h5>
                                                            <small class="text-muted d-block mt-1 fw-light">
                                                                {{ formato_tamano_archivo(filesize($archivo->archivo_alumno))
                                                                }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-6 col-md-3 col-lg-4 col-xl-4">
                                                <div class="card p-3 mb-3 background-gray">
                                                    <div class="d-flex align-items-center">
                                                        <img src="/media/icons/icon-archivo-generico2.webp" alt="icono-recurso"
                                                            class="me-2" width="40">
                                                        <div>
                                                            <h5 class="mb-0 text-danger">
                                                                {{ Str::limit("Archivo no disponible", 20) }}
                                                            </h5>
                                                            <small class="text-muted d-block mt-1 fw-light">
                                                                No disponible
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <livewire:components.trabajo-academico.card-revisar-trabajo :tipo_vista=$tipo_vista
                        :usuario=$usuario :id_gestion_aula_usuario=$id_gestion_aula_usuario
                        lazy />
                </div>
            </div>
        </div>
    </div>

</div>
