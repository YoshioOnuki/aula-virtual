<div class="col-12">
    @if (file_exists($recurso->archivo_recurso))
        <div class="card animate__animated animate__zoomIn animate__faster">
            <div
                class="modal-status bg-{{ config('settings.color-border-card-recurso') }}">
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">

                    <div>
                        <h5 class="card-title d-flex align-items-center">
                            <img src="{{ obtener_icono_archivo($recurso->archivo_recurso) }}"
                                alt="icono-recurso" class="w-6 h-6 me-2">
                            <span class="fw-bold">
                                {{ $recurso->nombre_recurso }}
                            </span>
                        </h5>
                        <p class="card-text">
                            <small class="text-muted">
                                Publicado el {{ $recurso->created_at->format('d/m/Y')
                                }}
                            </small><br>
                            <small class="text-muted">
                                Tamaño del archivo: {{
                                formato_tamano_archivo(filesize($recurso->archivo_recurso))
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
                            wire:click="abrir_modal_recurso_editar({{ $recurso->id_recurso }})"
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
                            wire:click="abrir_modal_recurso_editar({{ $recurso->id_recurso }})"
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
                            wire:click="descargar_recurso({{ $recurso->id_recurso }})">
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
                            wire:click="descargar_recurso({{ $recurso->id_recurso }})">
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
                                {{ $recurso->nombre_recurso }}
                                <span class="text-danger ms-2">
                                    (Archivo no disponible)
                                </span>
                            </span>
                        </h5>
                        <p class="card-text">
                            <small class="text-muted">
                                Publicado el {{ $recurso->created_at->format('d/m/Y')
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
                                wire:click="abrir_modal_recurso_editar({{ $recurso->id_recurso }})"
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
                                wire:click="abrir_modal_recurso_editar({{ $recurso->id_recurso }})"
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
