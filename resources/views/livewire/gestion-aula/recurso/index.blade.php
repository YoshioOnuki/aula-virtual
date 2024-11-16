<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            @if ($es_docente_invitado)
                <livewire:components.navegacion.alert-docente-invitado />
            @endif

            <div class="row row-cards d-flex justify-content-between">
                <div class="col-lg-2 d-none d-lg-block">
                    <livewire:components.navegacion.navegacion-curso :tipo_vista=$tipo_vista
                        :id_usuario=$id_usuario_hash :id_curso=$id_gestion_aula_hash />
                </div>

                <div class="col-lg-10 col-md-12 col-sm-12">
                    @if($modo_admin)
                        <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
                    @endif

                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card card-stacked animate__animated animate__fadeIn">
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

                                <div class="card-body  py-3">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <div class="text-secondary">
                                            Mostrar
                                            <div class="mx-2 d-inline-block">
                                                <select wire:model.live="mostrar_paginate" class="form-select">
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            entradas
                                        </div>

                                        <div class="text-secondary">
                                            <div class="d-inline-block">
                                                <input type="text" class="form-control bg-white"
                                                wire:model.live.debounce.500ms="search"
                                                aria-label="Buscar recurso" placeholder="Buscar">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row row-cards d-flex justify-content-start">

                                        @if ($tipo_vista === 'carga-academica' && $es_docente)
                                            {{-- Registrar recurso --}}
                                            <div class="col-lg-12">
                                                <a class="card cursor-pointer card-link card-link-pop" wire:click="abrir_modal_recurso_registrar"
                                                    data-bs-toggle="modal" data-bs-target="#modal-recursos">
                                                    <div class="card-body text-secondary">
                                                        <div class="row g-2">
                                                            <div class="col-12 d-flex justify-content-center align-items-center mt-3">
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
                                                                    Registrar recursos
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                        @forelse ($recursos as $item)
                                            <livewire:components.recurso.card-recurso :tipo_vista=$tipo_vista :usuario=$usuario
                                                :id_curso=$id_gestion_aula :recurso=$item wire:key="recurso-{{ $item->id_recurso }}" lazy />
                                        @empty

                                            @if ($recursos->count() == 0 && $search != '')
                                                <div class="col-lg-12">
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <div class="text-secondary">
                                                            No se encontraron resultados para
                                                            "<strong>{{ $search }}</strong>"
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                @if ($tipo_vista === 'cursos' || $es_docente_invitado)
                                                    <div class="col-lg-12">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <div class="text-muted">
                                                                No hay recursos disponibles
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif


                                        @endforelse
                                    </div>
                                </div>

                                <div class="card-footer {{ $recursos->hasPages() ? 'py-0' : '' }}">
                                    @if ($recursos->hasPages())
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center text-secondary">
                                                Mostrando {{ $recursos->firstItem() }} - {{ $recursos->lastItem() }} de
                                                {{ $recursos->total() }} registros
                                            </div>
                                            <div class="mt-3">
                                                {{ $recursos->links() }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex align-items-center text-secondary">
                                                Mostrando {{ $recursos->firstItem() }} - {{ $recursos->lastItem() }} de
                                                {{ $recursos->total() }} registros
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="modal-recursos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg"
            role="document">
            <div class="modal-content {{ $estado_carga_modal ? 'cursor-progress' : '' }}">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ !$estado_carga_modal ? $titulo_modal : '***' }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_recurso">
                    @if (!$estado_carga_modal)
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
                                    <input type="file" class="form-control @error('archivo_recurso') is-invalid @elseif(strlen($archivo_recurso) > 0) is-valid @enderror"
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
                    @else
                        <!-- Spinner de carga para que aparezca mientras se están cargando los datos -->
                        <div class="my-5 d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    @endif

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="limpiar_modal">
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
                            <button
                                type="submit" class="btn btn-primary w-100"
                                wire:loading.attr="disabled"
                                wire:target="guardar_recurso, archivo_recurso"
                                {{ $estado_carga_modal ? 'disabled cursor-progress' : '' }}
                            >
                                <span wire:loading.remove wire:target="guardar_recurso, archivo_recurso">
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
                                </span>
                                <span wire:loading wire:target="archivo_recurso">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando Archivo
                                </span>
                                <span wire:loading wire:target="guardar_recurso">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Guardando Recurso
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
