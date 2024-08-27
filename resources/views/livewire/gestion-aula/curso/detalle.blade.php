<div>

    @livewire('components.page-header', [
        'titulo_pasos' => $titulo_pasos_header,
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
                    <div class="row g-3">
                        @if($tipo_vista ==='cursos')
                            <div class="col-12" wire:init="load_orientaciones">
                                @if($cargando_orientaciones)
                                    <div class="card card-stacked placeholder-glow animate__animated animate__fadeIn animate__faster">
                                        <div class="card-header bg-teal-lt">
                                            <div class="placeholder col-5 bg-teal" style="height: 1.5rem; width: 217.16px;"></div>
                                        </div>
                                        <div class="card-body px-5">
                                            <div class="placeholder col-12"></div>
                                            <div class="placeholder col-10"></div>
                                            <div class="placeholder col-12"></div>
                                            <div class="placeholder col-11"></div>
                                            <div class="placeholder col-7"></div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card card-stacked">
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
                                                    Por favor, revisa más tarde o consulta con el <strong>docente</strong>  del curso para más información.
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                                <div class="card-stamp card-stamp-lg">
                                    @if ($tipo_vista ==='carga-academica')
                                        <div class="card-stamp-icon bg-orange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-align-box-left-middle">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                <path d="M9 15h-2" />
                                                <path d="M13 12h-6" />
                                                <path d="M11 9h-4" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="card-stamp-icon bg-teal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-vocabulary">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10 19h-6a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h6a2 2 0 0 1 2 2a2 2 0 0 1 2 -2h6a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-6a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2z" />
                                                <path d="M12 5v16" />
                                                <path d="M7 7h1" />
                                                <path d="M7 11h1" />
                                                <path d="M16 7h1" />
                                                <path d="M16 11h1" />
                                                <path d="M16 15h1" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex justify-content-center">
                                    <div class="row g-3">
                                        {{-- Silabus --}}
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <a class="text-decoration-none text-dark" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.silabus', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.silabus', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro-info.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Silabus
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                            <span class="hide-theme-light">
                                                <a class="dark-mode text-decoration-none text-white" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.silabus', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.silabus', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-libro-info.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Silabus
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                        </div>

                                        {{-- Recursos --}}
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <a class="text-decoration-none text-dark" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.recursos', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.recursos', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-carpeta.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Recursos
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                            <span class="hide-theme-light">
                                                <a class="dark-mode text-decoration-none text-white" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.recursos', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.recursos', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-carpeta.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Recursos
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                        </div>

                                        {{-- Foro --}}
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <a class="text-decoration-none text-dark" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.foro', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.foro', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-foro-discusion.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Foro
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                            <span class="hide-theme-light">
                                                <a class="dark-mode text-decoration-none text-white" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.foro', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.foro', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-foro-discusion.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Foro
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                        </div>

                                        {{-- Asistencia --}}
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <a class="text-decoration-none text-dark" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.asistencia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.asistencia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-matricula.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Asistencia
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                            <span class="hide-theme-light">
                                                <a class="dark-mode text-decoration-none text-white" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.asistencia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.asistencia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-matricula.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Asistencia
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                        </div>

                                        {{-- Trabajos Academicos --}}
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <a class="text-decoration-none text-dark" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.trabajo-academico', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.trabajo-academico', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-curso-por-internet.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Trabajos Académicos
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                            <span class="hide-theme-light">
                                                <a class="dark-mode text-decoration-none text-white" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.asistencia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.asistencia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-curso-por-internet.webp"
                                                            alt="Info" style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Trabajos Académicos
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                        </div>

                                        {{-- Webgrafia --}}
                                        <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                            <span class="hide-theme-dark">
                                                <a class="text-decoration-none text-dark" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.webgrafia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.webgrafia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-ubicacion-ip.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Webgrafía
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                            <span class="hide-theme-light">
                                                <a class="dark-mode text-decoration-none text-white" href="{{ $tipo_vista === 'cursos' ? 
                                                    route('cursos.detalle.webgrafia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) : 
                                                    route('carga-academica.detalle.webgrafia', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                    <div class="image-button {{ $tipo_vista ==='cursos' ? 'image-button-alumno' : 'image-button-docente'}}">
                                                        <img src="/media/icons/icon-ubicacion-ip.webp" alt="Info"
                                                            style="width: 80px; height: 80px;">
                                                        <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                            Webgrafía
                                                        </div>
                                                    </div>
                                                </a>
                                            </span>
                                        </div>

                                        @if($tipo_vista ==='carga-academica')
                                            {{-- Link de Clases --}}
                                            <div class="col-6 col-md-2 col-lg-4 col-xl-3" wire:init="obtener_link_clase">
                                                <span class="hide-theme-dark">
                                                    <div class="" wire:click="abrir_modal_link_clase">
                                                        <div class="image-button image-button-docente position-relative">
                                                            <img src="/media/icons/icon-link-hipervinculo.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Subir Link de Clases
                                                            </div>
                                                            @if(!$link_clase_bool)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="hide-theme-light">
                                                    <div class="dark-mode" wire:click="abrir_modal_link_clase">
                                                        <div class="image-button image-button-docente position-relative">
                                                            <img src="/media/icons/icon-link-hipervinculo.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Subir Link de Clases
                                                            </div>
                                                            @if(!$link_clase_bool)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>

                                            {{-- Orientaciones --}}
                                            <div class="col-6 col-md-2 col-lg-4 col-xl-3" wire:init="load_orientaciones">
                                                <span class="hide-theme-dark">
                                                    <div class="" wire:click="abrir_modal_orientaciones">
                                                        <div class="image-button image-button-docente position-relative" style="z-index: 1;">
                                                            <img src="/media/icons/icon-orien-presentacion2.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Orientaciones Generales
                                                            </div>
                                                            @if(!$orientaciones_generales_bool)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                                <span class="hide-theme-light">
                                                    <div class="dark-mode" wire:click="abrir_modal_orientaciones">
                                                        <div class="image-button image-button-docente position-relative">
                                                            <img src="/media/icons/icon-orien-presentacion2.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Orientaciones Generales
                                                            </div>
                                                            @if(!$orientaciones_generales_bool)
                                                                <span class="badge bg-yellow badge-notification badge-blink badge-pill">!</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>

                                            {{-- Alumnos --}}
                                            <div class="col-6 col-md-2 col-lg-4 col-xl-3">
                                                <span class="hide-theme-dark">
                                                    <a class="text-decoration-none text-dark"
                                                        href="{{ route('carga-academica.detalle.alumnos', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                        <div class="image-button image-button-docente" style="z-index: 1;">
                                                            <img src="/media/icons/icon-registro.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Alumnos
                                                            </div>
                                                        </div>
                                                    </a>
                                                </span>
                                                <span class="hide-theme-light">
                                                    <a class="dark-mode text-decoration-none text-white"
                                                        href="{{ route('carga-academica.detalle.alumnos', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => Hashids::encode($id_gestion_aula_usuario)]) }}">
                                                        <div class="image-button image-button-docente">
                                                            <img src="/media/icons/icon-registro.webp" alt="Info"
                                                                style="width: 80px; height: 80px;">
                                                            <div class="text-content text-center mt-3 fw-semibold fs-3">
                                                                Alumnos
                                                            </div>
                                                        </div>
                                                    </a>
                                                </span>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">

                    @livewire('components.info-docente', [
                        'id_gestion_aula_usuario' => $id_gestion_aula_usuario,
                        'tipo_vista' => $tipo_vista
                    ])

                    @livewire('components.datos-curso', [
                        'id_gestion_aula_usuario' => $id_gestion_aula_usuario,
                        'tipo_vista' => $tipo_vista
                    ])

                </div>

            </div>
        </div>
    </div>


    {{-- Modal Link de Clase --}}
    <div wire:ignore.self class="modal fade" id="modal-link-clase" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_link_clase }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="cerrar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_link_clase">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="nombre_link_clase" class="form-label required">
                                    Link de Clase
                                </label>
                                <input type="text" name="nombre_link_clase"
                                    class="form-control @error('nombre_link_clase') is-invalid @elseif(strlen($nombre_link_clase) > 0) is-valid @enderror"
                                    id="nombre_link_clase" wire:model.live="nombre_link_clase"
                                    placeholder="Ingrese el link" />
                                @error('nombre_link_clase')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="cerrar_modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M5.7 5.7l12.6 12.6" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            @if ($modo_link_clase === 1)
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            @endif
                            {{ $accion_estado_link_clase }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Orientaciones --}}
    <div wire:ignore.self class="modal fade" id="modal-orientaciones" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_orientaciones }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="cerrar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_orientaciones">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="descripcion_orientaciones" class="form-label required">
                                    Orientaciones Generales
                                </label>
                                <div wire:ignore>
                                    <textarea class="form-control"
                                    wire:model="descripcion_orientaciones" id="descripcion_orientaciones">
                                        {{ $descripcion_orientaciones }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="cerrar_modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M5.7 5.7l12.6 12.6" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            @if ($modo_orientaciones === 1)
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            @endif
                            {{ $accion_estado_orientaciones }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            $('#descripcion_orientaciones').summernote({
                placeholder: 'Ingrese la descripcion de las orientaciones',
                height: 300,
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        var maxSize = 2 * 1024 * 1024; // 2MB
                        if (files[0].size > maxSize) {
                            // Mostrar toast de error
                            window.dispatchEvent(new CustomEvent('toast-basico', {
                                detail: {
                                    type: 'error',
                                    mensaje: 'El archivo supera el tamaño máximo permitido de 2MB.'
                                }
                            }));
                            console.log('El archivo supera el tamaño máximo permitido de 2MB.');
                            return;
                        }else{
                            let editor = $(this);
                            let reader = new FileReader();
                            reader.onloadend = function () {
                                editor.summernote('insertImage', reader.result);
                            };
                            reader.readAsDataURL(files[0]);
                        }
                    },
                    onChange: function(contents, $editable) {
                        @this.set('descripcion_orientaciones', contents);
                    }
                },
            });
        })
    </script>
@endpush
