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

                            @if (session('tipo_vista') === 'alumno')
                            <li class="breadcrumb-item">
                                <a href="{{ route('cursos') }}">Mis Cursos</a>
                            </li>
                            @else
                            <li class="breadcrumb-item">
                                <a href="{{ route('carga-academica') }}">Carga Académica</a>
                            </li>
                            @endif

                            @if (session('tipo_vista') === 'alumno')
                            <li class="breadcrumb-item">
                                <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                            </li>
                            @else
                            <li class="breadcrumb-item">
                                <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                            </li>
                            @endif

                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Recursos
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Recursos
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if (session('tipo_vista') === 'alumno')
                        <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}" class="btn btn-secondary d-none d-md-inline-block">
                            @else
                            <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}" class="btn btn-secondary d-none d-md-inline-block">
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 6l-6 6l6 6" />
                                </svg>
                                Regresar
                            </a>
                            <a href="" class="btn btn-secondary d-md-none btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 6l-6 6l6 6" />
                                </svg>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-stamp card-stamp-lg">
                            @if (session('tipo_vista') === 'alumno')
                            <div class="card-stamp-icon bg-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-library">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                    <path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                    <path d="M11 7h5" />
                                    <path d="M11 10h6" />
                                    <path d="M11 13h3" />
                                </svg>
                            </div>
                            @elseif(session('tipo_vista') === 'docente')
                            <div class="card-stamp-icon bg-orange">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-library">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                    <path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                    <path d="M11 7h5" />
                                    <path d="M11 10h6" />
                                    <path d="M11 13h3" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start" wire:init="load_recursos_llamar">
                                @if($cargando_recursos)
                                @for($i = 0; $i < $cantidad_recursos; $i++) <div class="col-12">
                                    <div class="card placeholder-glow">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-5">
                                                <div class="placeholder col-6"></div>
                                                <div class="placeholder bg-primary" style="height: 1.5rem; width: 1.5rem;"></div>
                                            </div>
                                            <div>
                                                <div class="col-12"></div>
                                                <div class="placeholder placeholder-xs col-4 bg-secondary"></div>
                                                <div class="col-12"></div>
                                                <div class="placeholder placeholder-xs col-4 bg-secondary"></div>
                                            </div>
                                            <div class=" d-flex justify-content-end">
                                                <a href="#" tabindex="-1" class="btn btn-cyan disabled placeholder col-sm-3 col-lg-4 col-xl-2 d-none d-md-inline-block me-2" aria-hidden="true"></a>
                                                <a href="#" tabindex="-1" class="btn btn-cyan disabled placeholder col-1 d-md-none me-2 btn-icon" aria-hidden="true"></a>
                                                <a href="#" tabindex="-1" class="btn btn-success disabled placeholder col-sm-3 col-lg-4 col-xl-2 d-none d-md-inline-block" aria-hidden="true"></a>
                                                <a href="#" tabindex="-1" class="btn btn-success disabled placeholder col-1 d-md-none btn-icon" aria-hidden="true"></a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            @endfor
                            @else
                            {{-- @forelse ($recursos as $item) --}}
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">

                                            <div>
                                                <h5 class="card-title d-flex align-items-center">
                                                    <img src="/media/icons/icon-archivo-pdf.webp" alt="Info" class="w-6 h-6 me-2">
                                                    <span class="fw-bold">
                                                        Nombre de recursos
                                                    </span>
                                                </h5>
                                                <p class="card-text">
                                                    <small class="text-muted">
                                                        Publicado el 20/12/2021
                                                    </small><br>
                                                    <small class="text-muted">
                                                        Tamaño del archivo: 1.2 MB
                                                    </small>
                                                </p>
                                            </div>
                                            <div class="mt-0 mb-auto">
                                                @if($estado_recurso === 0)
                                                    <span class="text-primary cursor-pointer" wire:click="cambiar_estado_recurso()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check svg-small">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                            <path d="M9 12l2 2l4 -4" />
                                                        </svg>
                                                    </span>
                                                @elseif($estado_recurso === 1)
                                                    <span class=" text-primary cursor-pointer" wire:click="cambiar_estado_recurso()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-circle-check svg-small">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.32 -.083l-.094 .083l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.403 1.403l.083 .094l2 2l.094 .083a1 1 0 0 0 1.226 0l.094 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" />
                                                        </svg>
                                                    </span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-end">
                                            <div>
                                                @if($usuario->esRol('DOCENTE'))
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit cursor-pointer svg-small" wire:click="abrir_modal_recurso_editar(1)">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <button class="btn btn-cyan d-none d-md-inline-block me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="2" />
                                                        <path d="M22 12c0 1.66 -5.33 5 -10 5s-10 -3.34 -10 -5s5.33 -5 10 -5s10 3.34 10 5" />
                                                    </svg>
                                                    Vista Previa
                                                </button>
                                                <button class="btn btn-cyan d-md-none btn-icon me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="2" />
                                                        <path d="M22 12c0 1.66 -5.33 5 -10 5s-10 -3.34 -10 -5s5.33 -5 10 -5s10 3.34 10 5" />
                                                    </svg>
                                                </button>

                                                <button class="btn btn-success d-none d-md-inline-block">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                        <path d="M7 11l5 5l5 -5" />
                                                        <path d="M12 4l0 12" />
                                                    </svg>
                                                    Descargar
                                                </button>
                                                <button class="btn btn-success d-md-none btn-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                        <path d="M7 11l5 5l5 -5" />
                                                        <path d="M12 4l0 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @empty --}}
                            {{-- @if(session('tipo_vista') === 'alumno')
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="text-muted">
                                                        No hay recursos disponibles
                                                    </div>
                                                </div>
                                            </div>
                                        @endif --}}
                            {{-- @endforelse --}}
                            @endif

                            @if(session('tipo_vista') === 'docente' && $usuario->esRol('DOCENTE'))
                                <div class="col-lg-12">
                                    <div class="card hover-shadow-sm cursor-pointer" wire:click="abrir_modal_recurso_agregar()">
                                        <div class="card-body text-secondary">
                                            <div class="row g-2">
                                                <div class="col-12 d-flex justify-content-center align-items-center mt-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-library-plus svg-medium">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                        <path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                                        <path d="M11 10h6" />
                                                        <path d="M14 7v6" />
                                                    </svg>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center align-items-center">
                                                    <span class="text-muted fs-5">
                                                        Agregar recursos
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" wire:init="load_datos_curso_llamar">
                @if($cargando_datos_curso)
                <div class="card card-stacked placeholder-glow animate__animated animate__fadeIn animate__faster">
                    <div class="card-header {{ session('tipo_vista') === 'alumno' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                        <div class="placeholder col-5 {{ session('tipo_vista') === 'alumno' ? 'bg-teal' : 'bg-orange' }}" style="height: 1.5rem; width: 170.56px;"></div>
                    </div>
                    <div class="card-body row g-3 mb-0">
                        <div class="d-flex flex-column gap-2">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="placeholder" style="height: 17px; width: 148.94px;"></div>
                                            <div class="col-12"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="placeholder bg-secondary" style="height: 17px; width: 148.94px;"></div>
                                            <div class="col-12"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="placeholder" style="height: 17px; width: 117.06px;"></div>
                                            <div class="col-12"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="placeholder bg-secondary" style="height: 17px; width: 43.3px;"></div>
                                            <div class="col-12"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="placeholder" style="height: 17px; width: 122.21px;"></div>
                                            <div class="col-12"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="placeholder col-12 bg-secondary" style="height: 17px;"></div>
                                            <div class="col-12"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 d-flex justify-content-start">
                                    <div class="row g-2">
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="placeholder" style="height: 17px; width: 34.20px;"></div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="placeholder" style="height: 17px; width: 57.86px;"></div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 d-flex justify-content-end">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="placeholder" style="height: 17px; width: 40.07px;"></div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="placeholder" style="height: 17px; width: 104.33px;"></div>
                                            <div class="col-12"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="placeholder bg-secondary" style="height: 17px; width: 64.44px;"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                    <div class="card-header {{ session('tipo_vista') === 'alumno' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                        <h3 class="card-title fw-semibold">
                            Información del Curso
                        </h3>
                    </div>
                    <div class="card-body row g-3 mb-0">
                        <div class="d-flex flex-column gap-2">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <strong>Programa de
                                                {{ $curso->programa->tipoPrograma->nombre_tipo_programa }}
                                            </strong>
                                        </div>
                                        <div class="col-12">
                                            <span>
                                                {{ $curso->programa->nombre_programa }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if ($curso->programa->mencion_programa)
                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <strong>Mención:</strong>
                                        </div>
                                        <div class="col-12">
                                            <span>
                                                {{ $curso->programa->mencion->nombre_mencion }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <strong>Código del Curso</strong>
                                        </div>
                                        <div class="col-12">
                                            <span>
                                                {{ $curso->codigo_curso }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <strong>Nombre del Curso</strong>
                                        </div>
                                        <div class="col-12">
                                            {{ $curso->nombre_curso }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 d-flex justify-content-start">
                                    <div class="row g-2">
                                        <div class="col-12 d-flex justify-content-center">
                                            <strong>Ciclo</strong>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            <span>
                                                {{ numero_a_romano($curso->ciclo->numero_ciclo) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <strong>Créditos</strong>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            {{ $curso->creditos_curso }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 d-flex justify-content-end">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <strong>Horas</strong>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center">
                                            {{ $curso->horas_lectivas_curso }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <strong>Plan de Estudio</strong>
                                        </div>
                                        <div class="col-12">
                                            <span>
                                                {{ $curso->planEstudio->nombre_plan_estudio }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal" id="modal-recursos" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $titulo_modal }}
                </h5>
                <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar_modal"></button>
            </div>
            <form autocomplete="off" wire:submit="guardar_recurso">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="correo_electronico" class="form-label required">
                                Nombre del Recurso
                            </label>
                            <input type="text" name="nombre_recurso" class="form-control @error('nombre_recurso') is-invalid @enderror" id="nombre_recurso" wire:model.live="nombre_recurso" placeholder="Ingrese su correo electrónico" />
                            @error('nombre_recurso')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="archivo" class="form-label required">
                                Archivo
                            </label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror" id="archivo" wire:model.live="archivo" />
                            @error('archivo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="cerrar_modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M5.7 5.7l12.6 12.6" />
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        {{ $accion_estado }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

{{-- /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */ --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('load_recursos_evento', () => {
            setTimeout(() => {
                @this.call('load_recursos')
            }, 1000);
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('load_datos_curso_evento', () => {
            setTimeout(() => {
                @this.call('load_datos_curso')
            }, 500);
        });
    });

</script>
