<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item active" aria-current="page"><a href="#">Inicio</a></li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Bienvenido
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col col-md-8 col-lg-8 col-xl-8 col-sm-12 col-12">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster mb-3">
                        <div class="card-header d-flex justify-content-center align-items-center"
                        " style="background: rgb(12, 166, 120);">
                            <h3 class="card-title text-white fw-bold fs-2">
                                @if ($usuario->esRol('ALUMNO') && ($usuario->esRol('DOCENTE') || $usuario->esRol('DOCENTE INVITADO')))
                                    Mis Cursos / Carga Académica
                                @else
                                    @if($usuario->esRol('DOCENTE') || $usuario->esRol('DOCENTE INVITADO'))
                                        Carga Académica
                                    @elseif($usuario->esRol('ALUMNO'))
                                        Mis Cursos
                                    @else
                                        N/A
                                    @endif
                                @endif
                            </h3>
                        </div>
                        <div class="card-body overflow-auto" style="height: 610px;">
                            <div class="row row-cards d-flex justify-content-start" wire:init="load_cursos">

                                @if ($cargando)
                                    @for($i = 0; $i < $cantidad_cursos; $i++)
                                        <div class="col-sm-6 col-lg-6 col-xl-4 p-xl-2 p-lg-1 p-2">
                                            <div class="card placeholder-glow">
                                                <div class="ratio ratio-16x9 card-img-top placeholder"></div>
                                                <div class="card-avatar avatar avatar-smm rounded-circle ">
                                                    <div class="avatar avatar-rounded placeholder"></div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="placeholder placeholder-sm col-4 mt-4"></div>
                                                    <div class="placeholder col-12 mt-1"></div>
                                                    <div class="placeholder placeholder-xs col-12 mt-6"></div>
                                                    <div class="mt-3 d-flex justify-content-end">
                                                        <a href="#" tabindex="-1" class="btn btn-secondary disabled placeholder col-3" aria-hidden="true"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @else

                                    @forelse ($cursos as $item)
                                        <div class="col-sm-6 col-lg-6 col-xl-4 p-xl-2 p-lg-1 p-2">
                                            <div class="card card-sm hover-shadow custom-card cursor-pointer animate__animated animate__fadeIn animate__faster"
                                                wire:click="curso_detalle({{ $item->gestionAula->id_gestion_aula }})">
                                                <div class="img-responsive img-responsive-16x9 card-img-top"
                                                    style="background-image: url('{{ $item->gestionAula->fondo_gestion_aula ?? '/media/fondo-cursos/fondo-infor.webp' }}');">
                                                </div>

                                                <div class="card-avatar avatar avatar-smm rounded-circle">
                                                    <img src="{{ $foto_docente[$item->gestionAula->id_gestion_aula] }}"
                                                        alt="avatar">
                                                </div>

                                                <div class="card-body cursor-pointer">
                                                    <div>
                                                        <div class="d-flex align-items-center" style="height: 75px;">
                                                            <div>
                                                                <div class="text-muted">
                                                                    {{ $item->gestionAula->curso->codigo_curso }}</div>
                                                                <div class="text-uppercase">
                                                                    {{ $item->gestionAula->curso->nombre_curso }}</div>
                                                            </div>
                                                        </div>

                                                        @if (!empty($numero_progreso[$item->id_gestion_aula_usuario]))
                                                            <div class="d-flex mb-1 mt-2">
                                                                <div class="text-muted fs-5">
                                                                    Progreso:
                                                                    {{ $numero_progreso_realizados[$item->id_gestion_aula_usuario] ?? '0' }}/{{ $numero_progreso[$item->id_gestion_aula_usuario] ?? '0' }}
                                                                </div>
                                                                <div class="ms-auto fs-5">
                                                                    <span class="text-muted d-inline-flex align-items-center lh-1">
                                                                        {{ $progreso[$item->id_gestion_aula_usuario] ?? '0' }}%
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-{{ color_porcentaje($progreso[$item->id_gestion_aula_usuario] ?? 0) }}"
                                                                    style="width: {{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}%"
                                                                    role="progressbar"
                                                                    aria-valuenow="{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    aria-label="{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}% Complete">
                                                                    <span
                                                                        class="visually-hidden">{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}%
                                                                        Complete</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="d-flex mb-1 mt-2">
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
                                                    </div>

                                                    <div class="d-flex align-items-center mt-3">
                                                        <div class="w-full">
                                                            <span class="badge bg-teal-lt px-3 py-2 w-100">
                                                                CURSO
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        @if($usuario->esRol('ALUMNO'))
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-muted mt-3">
                                                    No tiene cursos asignados.
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforelse

                                    @forelse ($carga_academica as $item)
                                        <div class="col-sm-6 col-lg-6 col-xl-4 p-xl-2 p-lg-1 p-2">
                                            <div class="card card-sm hover-shadow custom-card cursor-pointer animate__animated animate__fadeIn animate__faster"
                                                wire:click="carga_academica_detalle({{ $item->gestionAula->id_gestion_aula }})">
                                                <div class="img-responsive img-responsive-16x9 card-img-top"
                                                    style="background-image: url('{{ $item->gestionAula->fondo_gestion_aula ?? '/media/fondo-cursos/fondo-infor.webp' }}');">
                                                </div>

                                                <div class="card-avatar avatar avatar-smm rounded-circle">
                                                    <img src="{{ $usuario->mostrarFoto('docente') ?? asset('/media/avatar_none.webp') }}"
                                                        alt="avatar">
                                                </div>

                                                <div class="card-body cursor-pointer">
                                                    <div>
                                                        <div class="d-flex align-items-center" style="height: 75px;">
                                                            <div>
                                                                <div class="text-muted">
                                                                    {{ $item->gestionAula->curso->codigo_curso }}</div>
                                                                <div class="text-uppercase">
                                                                    {{ $item->gestionAula->curso->nombre_curso }}</div>
                                                            </div>
                                                        </div>

                                                        @if (!empty($numero_progreso[$item->id_gestion_aula_usuario]))
                                                            <div class="d-flex mb-1 mt-2">
                                                                <div class="text-muted fs-5">
                                                                    Progreso:
                                                                    {{ $numero_progreso_realizados[$item->id_gestion_aula_usuario] ?? '0' }}/{{ $numero_progreso[$item->id_gestion_aula_usuario] ?? '0' }}
                                                                </div>
                                                                <div class="ms-auto fs-5">
                                                                    <span class="text-muted d-inline-flex align-items-center lh-1">
                                                                        {{ $progreso[$item->id_gestion_aula_usuario] ?? '0' }}%
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-{{ color_porcentaje($progreso[$item->id_gestion_aula_usuario] ?? 0) }}"
                                                                    style="width: {{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}%"
                                                                    role="progressbar"
                                                                    aria-valuenow="{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}"
                                                                    aria-valuemin="0" aria-valuemax="100"
                                                                    aria-label="{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}% Complete">
                                                                    <span
                                                                        class="visually-hidden">{{ $progreso[$item->id_gestion_aula_usuario] ?? 0 }}%
                                                                        Complete</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="d-flex mb-1 mt-2">
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
                                                    </div>

                                                    <div class="d-flex align-items-center mt-3">
                                                        <div class="w-full">
                                                            <span class="badge bg-orange-lt px-3 py-2 w-100">
                                                                CARGA ACADÉMICA
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        @if($usuario->esRol('DOCENTE') || $usuario->esRol('DOCENTE INVITADO'))
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-muted mt-3">
                                                    No tiene carga académica asignada.
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforelse

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-4 col-lg-4 col-xl-4 col-sm-12 col-12">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster mb-3">
                        <div class="card-header d-flex justify-content-center align-items-center" style="background: rgb(12, 166, 120);">
                            <h3 class="card-title text-white fw-bold fs-2">Autoridades</h3>
                        </div>
                        <div class="card-body overflow-auto" style="height: 610px;">
                            <div class="d-flex flex-column align-items-cent justify-content-center gap-5 ">
                                @forelse($autoridades_model as $item)
                                <div class="form-selectgroup-label-content d-flex align-items-start">
                                    <img src="{{ asset($item->mostrar_foto ?? '/media/avatar-none.webp') }}" alt="avatar" class="avatar me-3 rounded-circle">
                                    <div>
                                        <div class="fs-3">{{ $item->nombre_autoridad }}</div>
                                        <div class="text-muted fs-4">
                                            {{ $item->cargo->nombre_cargo }}
                                            {{ $item->facultad ? 'de la ' . $item->facultad->nombre_facultad : '' }}
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="form-selectgroup-label-content d-flex align-items-start">
                                    <div class="fs-3 text-center">
                                        No se encontraron Autoridades.
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
