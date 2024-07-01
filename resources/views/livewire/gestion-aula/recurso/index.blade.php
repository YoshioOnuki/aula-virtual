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
                                    @if($this->modo_admin)
                                        <a href="{{ route('alumnos.cursos', encriptar($id_gestion_aula_usuario)) }}">Mis Cursos</a>
                                    @else
                                        <a href="{{ route('cursos') }}">Mis Cursos</a>
                                    @endif
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    @if($this->modo_admin)
                                        <a href="{{ route('docentes.carga-academica', encriptar($id_gestion_aula_usuario)) }}">Carga Académica</a>
                                    @else
                                        <a href="{{ route('carga-academica') }}">Carga Académica</a>
                                    @endif
                                </li>
                            @endif

                            @if (session('tipo_vista') === 'alumno')
                                <li class="breadcrumb-item">
                                    @if($this->modo_admin)
                                        <a href="{{ route('alumnos.cursos.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                    @else
                                        <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                    @endif
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    @if($this->modo_admin)
                                        <a href="{{ route('docentes.carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                    @else
                                        <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                    @endif
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
                            @if($this->modo_admin)
                                <a href="{{ route('alumnos.cursos.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-none d-md-inline-block">
                            @else
                                <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-none d-md-inline-block">
                            @endif
                        @else
                            @if($this->modo_admin)
                                <a href="{{ route('docentes.carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-none d-md-inline-block">
                            @else
                                <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                    class="btn btn-secondary d-none d-md-inline-block">
                            @endif
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                        Regresar
                        </a>

                        @if (session('tipo_vista') === 'alumno')
                            @if($this->modo_admin)
                                <a href="{{ route('alumnos.cursos.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-md-none btn-icon">
                            @else
                                <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-md-none btn-icon">
                            @endif
                        @else
                            @if($this->modo_admin)
                                <a href="{{ route('docentes.carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-md-none btn-icon">
                            @else
                                <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-md-none btn-icon">
                            @endif
                        @endif
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
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

            @if($modo_admin)
                @livewire('components.info-alumnos-docentes', ['usuario' => $usuario])
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-stamp card-stamp-lg">
                            @if (session('tipo_vista') === 'alumno')
                                <div class="card-stamp-icon bg-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-library">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                        <path
                                            d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                        <path d="M11 7h5" />
                                        <path d="M11 10h6" />
                                        <path d="M11 13h3" />
                                    </svg>
                                </div>
                            @elseif(session('tipo_vista') === 'docente')
                                <div class="card-stamp-icon bg-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-library">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                        <path
                                            d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                        <path d="M11 7h5" />
                                        <path d="M11 10h6" />
                                        <path d="M11 13h3" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start" wire:init="load_recursos_llamar">
                                @if ($cargando_recursos)
                                    @for ($i = 0; $i < $cantidad_recursos; $i++)
                                        <div class="col-12">
                                            <div class="card placeholder-glow">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between mb-5">
                                                        <div class="placeholder col-6" style="height: 1.5rem;"></div>
                                                        <div class="placeholder"></div>
                                                    </div>
                                                    <div>
                                                        <div class="col-12"></div>
                                                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                                                        </div>
                                                        <div class="col-12"></div>
                                                        <div class="placeholder placeholder-xs col-4 bg-secondary">
                                                        </div>
                                                    </div>
                                                    <div class=" d-flex justify-content-end">
                                                        <a href="#" tabindex="-1"
                                                            class="btn btn-primary disabled placeholder col-sm-3 col-lg-4 col-xl-2 d-none d-md-inline-block"
                                                            aria-hidden="true"></a>
                                                        <a href="#" tabindex="-1"
                                                            class="btn btn-primary disabled placeholder col-1 d-md-none btn-icon"
                                                            aria-hidden="true"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                @else
                                    @forelse ($recursos as $item)
                                        <div class="col-12">
                                            @if (file_exists($item->archivo_recurso))
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">

                                                            <div>
                                                                <h5 class="card-title d-flex align-items-center">
                                                                    <img src="{{ obtener_icono_archivo($item->archivo_recurso) }}"
                                                                        alt="Info" class="w-6 h-6 me-2">
                                                                    <span class="fw-bold">
                                                                        {{ $item->nombre_recurso }}
                                                                    </span>
                                                                </h5>
                                                                <p class="card-text">
                                                                    <small class="text-muted">
                                                                        Publicado el {{ $item->created_at->format('d/m/Y') }}
                                                                    </small><br>
                                                                    <small class="text-muted">
                                                                        Tamaño del archivo: {{ formato_tamano_archivo(filesize($item->archivo_recurso)) }}
                                                                    </small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-end">
                                                            <div>
                                                                @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit cursor-pointer svg-small"
                                                                        wire:click="abrir_modal_recurso_editar({{ $item->id_recurso }})">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                        <path
                                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                        <path d="M16 5l3 3" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <button class="btn btn-primary d-none d-md-inline-block" wire:click="descargar_recurso({{ $item->id_recurso }})">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                        <path d="M7 11l5 5l5 -5" />
                                                                        <path d="M12 4l0 12" />
                                                                    </svg>
                                                                    Descargar
                                                                </button>
                                                                <button class="btn btn-primary d-md-none btn-icon" wire:click="descargar_recurso({{ $item->id_recurso }})">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                        <path d="M7 11l5 5l5 -5" />
                                                                        <path d="M12 4l0 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">

                                                            <div>
                                                                <h5 class="card-title d-flex align-items-center">
                                                                    <img src="/media/icons/icon-archivo-generico2.webp"
                                                                        alt="Info" class="w-6 h-6 me-2">
                                                                    <span class="fw-bold">
                                                                        {{ $item->nombre_recurso }}
                                                                        <span class="text-danger ms-2">
                                                                            (Archivo no disponible)
                                                                        </span>
                                                                    </span>
                                                                </h5>
                                                                <p class="card-text">
                                                                    <small class="text-muted">
                                                                        Publicado el {{ $item->created_at->format('d/m/Y') }}
                                                                    </small><br>
                                                                    <small class="text-muted">
                                                                        Tamaño del archivo:
                                                                        <b>
                                                                            No disponible
                                                                        </b>
                                                                    </small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-end">
                                                            <div>
                                                                @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit cursor-pointer svg-small mt-3"
                                                                        wire:click="abrir_modal_recurso_editar({{ $item->id_recurso }})">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                        <path
                                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                        <path d="M16 5l3 3" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                                                            <div class="alert alert-yellow bg-yellow-lt hover-shadow-sm animate__animated animate__fadeIn animate__faster mt-3" role="alert">
                                                                <div class="d-flex">
                                                                    <div>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                            <path d="M12 9v4"></path>
                                                                            <path
                                                                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                                            </path>
                                                                            <path d="M12 16h.01"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <h4 class="alert-title">
                                                                            Archivo no disponible, por favor suba el archivo nuevamente
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    @empty
                                        @if (session('tipo_vista') === 'alumno')
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="text-muted">
                                                        No hay recursos disponibles
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforelse
                                @endif

                                @if (session('tipo_vista') === 'docente' && $usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                                    <div class="col-lg-12">
                                        <div class="card hover-shadow-sm cursor-pointer"
                                            wire:click="abrir_modal_recurso_agregar()">
                                            <div class="card-body text-secondary">
                                                <div class="row g-2">
                                                    <div
                                                        class="col-12 d-flex justify-content-center align-items-center mt-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-library-plus svg-medium">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                            <path
                                                                d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                                            <path d="M11 10h6" />
                                                            <path d="M14 7v6" />
                                                        </svg>
                                                    </div>
                                                    <div
                                                        class="col-12 d-flex justify-content-center align-items-center">
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

                <div class="col-lg-4">
                    @livewire('components.datos-curso', ['id_gestion_aula_usuario' => $id_gestion_aula_usuario])
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
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="cerrar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_recurso">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="nombre_recurso" class="form-label required">
                                    Nombre del Recurso
                                </label>
                                <input type="text" name="nombre_recurso"
                                    class="form-control @error('nombre_recurso') is-invalid @elseif(strlen($nombre_recurso) > 0) is-valid @enderror"
                                    id="nombre_recurso" wire:model.live="nombre_recurso"
                                    placeholder="Ingrese su correo electrónico" />
                                @error('nombre_recurso')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="archivo_recurso" class="form-label required">
                                    Archivo
                                </label>
                                <input type="file" class="form-control @error('archivo_recurso') is-invalid @enderror"
                                    id="archivo_recurso" wire:model.live="archivo_recurso" accept=".pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.txt"/>
                                @error('archivo_recurso')
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
                            @if ($modo === 1)
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
            }, 500);
        });
    });
</script>
