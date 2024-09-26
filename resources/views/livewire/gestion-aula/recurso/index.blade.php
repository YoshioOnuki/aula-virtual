<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            <div class="row row-cards d-flex justify-content-between">
                <div class="col-lg-2 d-none d-lg-block">
                    <livewire:components.navegacion.navegacion-curso :tipo_vista=$tipo_vista
                        :id_usuario=$id_usuario_hash :id_gestion_aula_usuario=$id_gestion_aula_usuario />
                </div>

                <div class="col-lg-10 col-md-12 col-sm-12">
                    @if($modo_admin)
                    <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
                    @endif

                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card card-md card-stacked ">
                                <div class="card-stamp card-stamp-lg">
                                    {{-- Icono de la tarjeta (Lado derecho de la esquina superior) --}}
                                    @if ($tipo_vista === 'cursos')
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
                                    @elseif($tipo_vista === 'carga-academica')
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
                                    <div class="row row-cards d-flex justify-content-start">

                                        @if ($tipo_vista === 'carga-academica' && $es_docente)
                                        {{-- Agregar recurso --}}
                                        <div class="col-lg-12">
                                            <a class="card cursor-pointer" wire:click="abrir_modal_recurso_agregar()"
                                                data-bs-toggle="modal" data-bs-target="#modal-recursos">
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
                                            </a>
                                        </div>
                                        @endif

                                        {{-- @if ($cargando_recursos)
                                        <div class="col-12">
                                            <div class="card placeholder-glow">
                                                <div class="card-body p-4">
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
                                                            class="btn btn-secondary disabled placeholder col-sm-2 col-lg-3 col-xl-2 d-none d-md-inline-block me-2"
                                                            aria-hidden="true"></a>
                                                        <a href="#" tabindex="-1"
                                                            class="btn btn-secondary disabled placeholder col-1 d-md-none btn-icon me-2"
                                                            aria-hidden="true"></a>

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
                                        @else --}}
                                        @forelse ($recursos as $item)
                                        <div class="col-12">
                                            @if (file_exists($item->archivo_recurso))
                                            <div class="card animate__animated animate__zoomIn animate__faster">
                                                <div
                                                    class="modal-status bg-{{ config('settings.color-border-card-recurso') }}">
                                                </div>
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between">

                                                        <div>
                                                            <h5 class="card-title d-flex align-items-center">
                                                                <img src="{{ obtener_icono_archivo($item->archivo_recurso) }}"
                                                                    alt="icono-recurso" class="w-6 h-6 me-2">
                                                                <span class="fw-bold">
                                                                    {{ $item->nombre_recurso }}
                                                                </span>
                                                            </h5>
                                                            <p class="card-text">
                                                                <small class="text-muted">
                                                                    Publicado el {{ $item->created_at->format('d/m/Y')
                                                                    }}
                                                                </small><br>
                                                                <small class="text-muted">
                                                                    Tamaño del archivo: {{
                                                                    formato_tamano_archivo(filesize($item->archivo_recurso))
                                                                    }}
                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end align-items-end mt-2">
                                                        <div>
                                                            @if ($es_docente)
                                                            <button
                                                                class="btn btn-secondary d-none d-md-inline-block me-2"
                                                                wire:click="abrir_modal_recurso_editar({{ $item->id_recurso }})"
                                                                data-bs-toggle="modal" data-bs-target="#modal-recursos">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                    <path d="M16 5l3 3" />
                                                                </svg>
                                                                Editar
                                                            </button>
                                                            <button class="btn btn-secondary d-md-none btn-icon me-2"
                                                                wire:click="abrir_modal_recurso_editar({{ $item->id_recurso }})"
                                                                data-bs-toggle="modal" data-bs-target="#modal-recursos">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                    <path d="M16 5l3 3" />
                                                                </svg>
                                                            </button>
                                                            @endif

                                                            <button class="btn btn-primary d-none d-md-inline-block"
                                                                wire:click="descargar_recurso({{ $item->id_recurso }})">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                                    <path d="M7 11l5 5l5 -5" />
                                                                    <path d="M12 4l0 12" />
                                                                </svg>
                                                                Descargar
                                                            </button>
                                                            <button class="btn btn-primary d-md-none btn-icon"
                                                                wire:click="descargar_recurso({{ $item->id_recurso }})">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
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
                                            <div class="card animate__animated animate__zoomIn animate__faster">
                                                <div class="card-body p-4">
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
                                                                    Publicado el {{ $item->created_at->format('d/m/Y')
                                                                    }}
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
                                                    <div class="d-flex justify-content-end align-items-end mt-2">
                                                        <div>
                                                            @if ($es_docente)
                                                            <button
                                                                class="btn btn-secondary d-none d-md-inline-block me-2"
                                                                wire:click="abrir_modal_recurso_editar({{ $item->id_recurso }})"
                                                                data-bs-toggle="modal" data-bs-target="#modal-recursos">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                    <path d="M16 5l3 3" />
                                                                </svg>
                                                                Editar
                                                            </button>
                                                            <button class="btn btn-secondary d-md-none btn-icon me-2"
                                                                wire:click="abrir_modal_recurso_editar({{ $item->id_recurso }})"
                                                                data-bs-toggle="modal" data-bs-target="#modal-recursos">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                    <path d="M16 5l3 3" />
                                                                </svg>
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if ($es_docente)

                                                    <div x-data="{ mostrarAlerta: true, salir: false }"
                                                        x-show="mostrarAlerta"
                                                        x-bind:class="salir ? 'animate__hinge' : 'animate__pulse animate__repeat-2 animate__delay-1s'"
                                                        class="alert alert-yellow bg-yellow-lt animate__animated hover-shadow-sm alert-dismissible mt-3"
                                                        role="alert" style="display: none;">
                                                        <div class="d-flex">
                                                            <div>
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon alert-icon" width="24" height="24"
                                                                    viewBox="0 0 24 24" stroke-width="2"
                                                                    stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                    </path>
                                                                    <path d="M12 9v4"></path>
                                                                    <path
                                                                        d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                                    </path>
                                                                    <path d="M12 16h.01"></path>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h4 class="alert-title">
                                                                    Archivo no disponible, por favor suba el archivo
                                                                    nuevamente
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <!-- Botón de cerrar -->
                                                        <a class="btn-close icon-rotate-custom"
                                                            @click="salir = true; setTimeout(() => mostrarAlerta = false, 2000);"></a>
                                                    </div>

                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                        @empty
                                        @if ($tipo_vista === 'cursos')
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-muted">
                                                    No hay recursos disponibles
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforelse
                                        {{-- @endif --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="modal-recursos" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
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
                                    id="archivo_recurso" wire:model.live="archivo_recurso"
                                    accept=".pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.txt" />
                                @error('archivo_recurso')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="cerrar_modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M5.7 5.7l12.6 12.6" />
                            </svg>
                            Cancelar
                        </a>

                        <div class="ms-auto">
                            <div wire:loading.remove>
                                <button type="submit" class="btn btn-primary">
                                    @if ($modo === 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path
                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                    @endif
                                    {{ $accion_estado }}
                                </button>
                            </div>
                            <div wire:loading>
                                <button type="submit" class="btn btn-primary" disabled>
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
