<div class="col-sm-4 col-lg-4 col-xl-3 p-xl-2 p-lg-1 p-2 cursor-pointer animate__animated animate__zoomIn animate__faster">
    <div class="card card-sm hover-shadow custom-card"
        wire:click="redirigir_curso_detalle({{ $gestion_aula_usuario->gestionAula->id_gestion_aula }})"
        wire:target="redirigir_curso_detalle"
        wire:loading.class="opacity-50 cursor-progress"
        wire:loading.class.remove="hover-shadow custom-card">

        <div class="img-responsive img-responsive-16x9 card-img-top"
            style="background-image: url('{{ $gestion_aula_usuario->gestionAula->fondo_gestion_aula ?? '/media/fondo-cursos/fondo-infor.webp' }}');">

        </div>

        <div class="card-avatar avatar avatar-smm rounded-circle">
            @if ($tipo_vista === 'cursos')
                <img src="{{ $foto_docente[$gestion_aula_usuario->gestionAula->id_gestion_aula] }}" alt="avatar">
            @elseif($tipo_vista === 'carga-academica')
                <img src="{{ $usuario->mostrarFoto('docente') ?? asset('/media/avatar_none.webp') }}" alt="avatar">
            @endif
        </div>

        <div class="card-body {{ $tipo_vista === 'cursos' ? 'mb-2' : '' }} {{ $ruta_vista === 'carga-academica' ? 'mb-2' : '' }}">

                <div>
                    <div class="d-flex align-items-center cursor-pointer" style="height: 75px;">
                        <div>
                            <div class="text-muted">
                                {{ $gestion_aula_usuario->gestionAula->curso->codigo_curso }}</div>
                            <div class="text-uppercase">
                                {{ $gestion_aula_usuario->gestionAula->curso->nombre_curso }} - GRUPO
                                "{{ $gestion_aula_usuario->gestionAula->grupo_gestion_aula }}"
                            </div>
                        </div>
                    </div>

                    @if (!empty($numero_progreso[$gestion_aula_usuario->id_gestion_aula_usuario]) && $tipo_vista === 'cursos')
                        <div class="d-flex mb-2 mt-3">
                            <div class="text-muted fs-5">
                                Progreso:
                                {{ $numero_progreso_realizados[$gestion_aula_usuario->id_gestion_aula_usuario] ?? '0'
                                }}/{{
                                $numero_progreso[$gestion_aula_usuario->id_gestion_aula_usuario] ?? '0' }}
                            </div>
                            <div class="ms-auto fs-5">
                                <span class="text-muted d-inline-flex align-items-center lh-1">
                                    {{ $progreso[$gestion_aula_usuario->id_gestion_aula_usuario] ?? '0' }}%
                                </span>
                            </div>
                        </div>

                        <div class="progress progress-sm">
                            <div class="progress-bar bg-{{ color_porcentaje($progreso[$gestion_aula_usuario->id_gestion_aula_usuario] ?? 0) }}"
                                style="width: {{ $progreso[$gestion_aula_usuario->id_gestion_aula_usuario] ?? 0 }}%"
                                role="progressbar"
                                aria-valuenow="{{ $progreso[$gestion_aula_usuario->id_gestion_aula_usuario] ?? 0 }}"
                                aria-valuemin="0" aria-valuemax="100"
                                aria-label="{{ $progreso[$gestion_aula_usuario->id_gestion_aula_usuario] ?? 0 }}% Complete">
                                <span class="visually-hidden">{{
                                    $progreso[$gestion_aula_usuario->id_gestion_aula_usuario]
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

                    @if ($tipo_vista === 'carga-academica')
                        <div class="d-flex align-items-center mt-4">
                            <div class="w-full">
                                <span class="badge bg-{{ $tipo_vista === 'cursos' ? 'teal' : 'orange' }}-lt py-2 w-100">
                                    {{ $tipo_vista === 'cursos' ? 'CURSO' : 'CARGA ACADÉMICA' }}
                                </span>
                            </div>
                        </div>
                    @endif

                </div>

        </div>

    </div>
    <div class="position-absolute top-50 start-50 translate-middle"
        wire:loading wire:target="redirigir_curso_detalle">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

