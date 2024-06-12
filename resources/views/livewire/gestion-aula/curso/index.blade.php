<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows
                        " aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="{{ route('inicio') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    @if (session('tipo_vista') === 'alumno')
                                        Mis Cursos
                                    @elseif(session('tipo_vista') === 'docente')
                                        Carga Académica
                                    @endif
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        @if (session('tipo_vista') === 'alumno')
                            Mis Cursos
                        @elseif(session('tipo_vista') === 'docente')
                            Carga Académica
                        @endif
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                <div class="card-stamp card-stamp-lg">
                    @if (session('tipo_vista') === 'alumno')
                        <div class="card-stamp-icon bg-teal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-books">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                <path
                                    d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                <path d="M5 8h4" />
                                <path d="M9 16h4" />
                                <path
                                    d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" />
                                <path d="M14 9l4 -1" />
                                <path d="M16 16l3.923 -.98" />
                            </svg>
                        </div>
                    @elseif(session('tipo_vista') === 'docente')
                        <div class="card-stamp-icon bg-orange">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chalkboard">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1" />
                                <path
                                    d="M11 16m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row row-cards d-flex justify-content-start" wire:init="load_cursos">

                        @if ($cargando)
                            @for($i = 0; $i < $cantidad_cursos; $i++)
                                <div class="col-sm-4 col-lg-4 col-xl-3 p-xl-2 p-lg-1 p-2">
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

                                <div class="col-sm-4 col-lg-4 col-xl-3 p-xl-2 p-lg-1 p-2">
                                    <div class="card card-sm hover-shadow custom-card animate__animated animate__fadeIn animate__faster">
                                        <div class="img-responsive img-responsive-16x9 card-img-top"
                                            style="background-image: url('{{ $item->gestionAula->fondo_gestion_aula ?? '/media/fondo-cursos/fondo-infor.webp' }}'); cursor: pointer;"
                                            wire:click="curso_detalle({{ $item->gestionAula->id_gestion_aula }})">
                                        </div>

                                        <div class="card-avatar avatar avatar-smm rounded-circle">
                                            @if (session('tipo_vista') === 'alumno')
                                                <img src="{{ $foto_docente[$item->gestionAula->id_gestion_aula] }}"
                                                    alt="avatar">
                                            @elseif(session('tipo_vista') === 'docente')
                                                <img src="{{ $usuario->mostrarFoto('docente') ?? asset('/media/avatar_none.webp') }}"
                                                    alt="avatar">
                                            @endif
                                        </div>

                                        <div class="card-body">
                                            <div style="cursor: pointer;"
                                                wire:click="curso_detalle({{ $item->gestionAula->id_gestion_aula }})">
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
                                                <div class="ms-auto">
                                                    <a class="text-muted text-decoration-none" data-bs-toggle="tooltip"
                                                        data-bs-placement="left" title="informacion del cursooo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                            <path d="M12 9h.01" />
                                                            <path d="M11 12h1v4h1" />
                                                        </svg>
                                                    </a>
                                                    @if ($item->favorito_gestion_aula_usuario == 0)
                                                        <button class="switch-icon switch-icon-scale"
                                                            data-bs-toggle="switch-icon" wire:click="curso_favorito({{ $item->id_gestion_aula_usuario }})">
                                                            <span class="switch-icon-a text-secondary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-star">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                                </svg>
                                                            </span>
                                                            {{-- <span class="switch-icon-b text-yellow">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="#f59f00"
                                                                    class="icon icon-tabler icons-tabler-filled icon-tabler-star">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" />
                                                                </svg>
                                                            </span> --}}
                                                        </button>
                                                    @elseif($item->favorito_gestion_aula_usuario == 1)
                                                        <button class="switch-icon"
                                                            data-bs-toggle="switch-icon" wire:click="curso_favorito({{ $item->id_gestion_aula_usuario }})">
                                                            <span class="switch-icon-b text-secondary">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-star">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                                </svg>
                                                            </span>
                                                            <span class="switch-icon-a text-yellow">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="#f59f00"
                                                                    class="icon icon-tabler icons-tabler-filled icon-tabler-star">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" />
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="text-muted">
                                            @if (session('tipo_vista') === 'alumno')
                                                No tiene cursos asignados.
                                            @elseif(session('tipo_vista') === 'docente')
                                                No tiene carga académica.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

