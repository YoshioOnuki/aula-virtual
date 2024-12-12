<div class="col-sm-4 col-lg-4 col-xl-3 p-xl-2 p-lg-1 p-2 cursor-pointer animate__animated animate__zoomIn animate__faster">
    <div class="card card-sm hover-shadow custom-card position-relative"
        wire:click="redirigir_curso_detalle({{ $gestion_aula->id_gestion_aula }})"
        wire:target="redirigir_curso_detalle"
        wire:loading.class="opacity-50 cursor-progress"
        wire:loading.class.remove="hover-shadow custom-card">

        @if ($modo_config)
            <div
                class="position-absolute top-0 end-0 m-2 dropdown"
                onclick="event.stopPropagation()"
            >
                <a href="#" class="btn btn-light pe-1" data-bs-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-settings">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M14.647 4.081a.724 .724 0 0 0 1.08 .448c2.439 -1.485 5.23 1.305 3.745 3.744a.724 .724 0 0 0 .447 1.08c2.775 .673 2.775 4.62 0 5.294a.724 .724 0 0 0 -.448 1.08c1.485 2.439 -1.305 5.23 -3.744 3.745a.724 .724 0 0 0 -1.08 .447c-.673 2.775 -4.62 2.775 -5.294 0a.724 .724 0 0 0 -1.08 -.448c-2.439 1.485 -5.23 -1.305 -3.745 -3.744a.724 .724 0 0 0 -.447 -1.08c-2.775 -.673 -2.775 -4.62 0 -5.294a.724 .724 0 0 0 .448 -1.08c-1.485 -2.439 1.305 -5.23 3.744 -3.745a.722 .722 0 0 0 1.08 -.447c.673 -2.775 4.62 -2.775 5.294 0zm-2.647 4.919a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" />
                    </svg>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a
                        class="dropdown-item cursor-pointer"
                        wire:click="editar_carga_academica({{ $gestion_aula->id_gestion_aula }})"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-carga-academica"
                    >
                        Editar
                    </a>
                    <a class="dropdown-item cursor-pointer" wire:click="eliminar_carga_academica({{ $gestion_aula->id_gestion_aula }})">
                        Eliminar
                    </a>
                </div>
            </div>
        @endif

        <div class="img-responsive img-responsive-16x9 card-img-top"
            @if ($tipo_vista === 'cursos')
                style="background-image: {{ $gestion_aula->fondo_gestion_aula ? 'url('. $gestion_aula->fondo_gestion_aula .')' : 'url(' . config('settings.fondo_curso_alumno_default') . ')' }}">
            @elseif ($tipo_vista === 'carga-academica')
                style="background-image: {{ $gestion_aula->fondo_gestion_aula ? 'url('. $gestion_aula->fondo_gestion_aula .')' : 'url(' . config('settings.fondo_curso_docente_default') . ')' }}">
            @endif
        </div>

        <div class="card-avatar avatar avatar-smm rounded-circle">
            <img src="{{ $foto_docente[$gestion_aula->id_gestion_aula] }}" alt="avatar">
        </div>

        <div class="card-body {{ $tipo_vista === 'cursos' && $gestion_aula->en_curso_gestion_aula ? 'mb-2' : '' }}">

                <div>
                    <div class="d-flex align-items-center cursor-pointer" style="height: 75px;">
                        <div>
                            <div class="text-muted">
                                {{ $gestion_aula->curso->codigo_curso }}
                            </div>
                            <div class="text-uppercase">
                                {{ $gestion_aula->curso->nombre_curso }} - GRUPO
                                "{{ $gestion_aula->grupo_gestion_aula }}"
                            </div>
                        </div>
                    </div>

                    @if (!$gestion_aula->en_curso_gestion_aula && $tipo_vista === 'cursos')
                        <div class="d-flex align-items-center mt-4">
                            <div class="w-full">
                                <span class="badge bg-teal py-2 w-100 text-white">
                                    FINALIZADO
                                </span>
                            </div>
                        </div>
                    @elseif ($tipo_vista === 'cursos' && !empty($numero_progreso[$gestion_aula_alumno->id_gestion_aula_alumno]))
                        <div class="d-flex mb-2 mt-3">
                            <div class="text-muted fs-5">
                                Progreso:
                                {{ $numero_progreso_realizados[$gestion_aula_alumno->id_gestion_aula_alumno] ?? '0'
                                }}/{{
                                $numero_progreso[$gestion_aula_alumno->id_gestion_aula_alumno] ?? '0' }}
                            </div>
                            <div class="ms-auto fs-5">
                                <span class="text-muted d-inline-flex align-items-center lh-1">
                                    {{ $progreso[$gestion_aula_alumno->id_gestion_aula_alumno] ?? '0' }}%
                                </span>
                            </div>
                        </div>

                        <div class="progress progress-sm">
                            <div class="progress-bar bg-{{ color_porcentaje($progreso[$gestion_aula_alumno->id_gestion_aula_alumno] ?? 0) }}"
                                style="width: {{ $progreso[$gestion_aula_alumno->id_gestion_aula_alumno] ?? 0 }}%"
                                role="progressbar"
                                aria-valuenow="{{ $progreso[$gestion_aula_alumno->id_gestion_aula_alumno] ?? 0 }}"
                                aria-valuemin="0" aria-valuemax="100"
                                aria-label="{{ $progreso[$gestion_aula_alumno->id_gestion_aula_alumno] ?? 0 }}% Complete">
                                <span class="visually-hidden">{{
                                    $progreso[$gestion_aula_alumno->id_gestion_aula_alumno]
                                    ?? 0 }}%
                                    Complete</span>
                            </div>
                        </div>
                    @elseif ($tipo_vista === 'cursos')
                        <div class="d-flex mb-2 mt-3">
                            <div class="text-muted fs-5">
                            </div>
                            <div class="ms-auto fs-5">
                                <span class="text-muted d-inline-flex align-items-center lh-1">
                                </span>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                        </div>
                    @endif

                    @if (!$gestion_aula->en_curso_gestion_aula && $tipo_vista === 'carga-academica')
                        <div class="d-flex align-items-center mt-4">
                            <div class="w-full">
                                <span class="badge bg-orange py-2 w-100 text-white">
                                    {{ $gestion_aula_docente->es_invitado ? 'INVITADO - FINALIZADO' : 'FINALIZADO' }}
                                </span>
                            </div>
                        </div>
                    @elseif ($tipo_vista === 'carga-academica' && !$todos_cursos)
                        <div class="d-flex align-items-center mt-4">
                            <div class="w-full">
                                <span class="badge bg-{{ $tipo_vista === 'cursos' ? 'teal' : 'orange' }}-lt py-2 w-100">
                                    @if ($tipo_vista === 'carga-academica' && $gestion_aula_docente->es_invitado)
                                        DOCENTE INVITADO
                                    @elseif ($tipo_vista === 'carga-academica' && !$gestion_aula_docente->es_invitado)
                                        DOCENTE
                                    @endif
                                </span>
                            </div>
                        </div>
                    @elseif($todos_cursos)
                        <div class="d-flex align-items-center mt-4">
                            <div class="w-full">
                                <span class="badge bg-orange-lt py-2 w-100">
                                    EN CURSO
                                </span>
                            </div>
                        </div>
                    @endif

                </div>

        </div>

    </div>
    <!-- Spinner de carga que aparece inmediatamente antes de redirigir -->
    <div class="position-absolute top-50 start-50 translate-middle"
        wire:loading wire:target="redirigir_curso_detalle">
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
</div>

