<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header lazy />

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
                <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn">
                        <div class="card-stamp card-stamp-lg">
                            {{-- Icono --}}
                            @if ($tipo_vista === 'cursos')
                                <div class="card-stamp-icon bg-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-bubble-text">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 10h10" />
                                        <path d="M9 14h5" />
                                        <path
                                            d="M12.4 3a5.34 5.34 0 0 1 4.906 3.239a5.333 5.333 0 0 1 -1.195 10.6a4.26 4.26 0 0 1 -5.28 1.863l-3.831 2.298v-3.134a2.668 2.668 0 0 1 -1.795 -3.773a4.8 4.8 0 0 1 2.908 -8.933a5.33 5.33 0 0 1 4.287 -2.16" />
                                    </svg>
                                </div>
                            @elseif($tipo_vista === 'carga-academica')
                                <div class="card-stamp-icon bg-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-bubble-text">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 10h10" />
                                        <path d="M9 14h5" />
                                        <path
                                            d="M12.4 3a5.34 5.34 0 0 1 4.906 3.239a5.333 5.333 0 0 1 -1.195 10.6a4.26 4.26 0 0 1 -5.28 1.863l-3.831 2.298v-3.134a2.668 2.668 0 0 1 -1.795 -3.773a4.8 4.8 0 0 1 2.908 -8.933a5.33 5.33 0 0 1 4.287 -2.16" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start">

                                {{-- Bnoton de agregar --}}
                                @if ($tipo_vista === 'carga-academica' && $usuario->esRolGestionAula('DOCENTE',
                                $id_gestion_aula_usuario))
                                    <div class="col-lg-12">
                                        <a class="card card-link cursor-pointer" wire:click="abrir_modal_agregar_foro()">
                                            <div class="card-body text-secondary">
                                                <div class="row g-2">
                                                    <div
                                                        class="col-12 d-flex justify-content-center align-items-center mt-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                                        <span class="text-muted fs-5">
                                                            Agregar Foro
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                            @forelse($foros as $item)
                                <livewire:components.foro.card-foro :tipo_vista=$tipo_vista :usuario=$usuario
                                    :id_gestion_aula_usuario=$id_gestion_aula_usuario :foro=$item
                                    wire:key="{{ $item->id_foro }}" lazy />
                            @empty
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="text-muted">
                                            No hay foros registrados
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <livewire:components.curso.datos-curso :id_gestion_aula_usuario=$id_gestion_aula_usuario :ruta_pagina=$ruta_pagina
                        :tipo_vista=$tipo_vista lazy />
                </div>

            </div>
        </div>
    </div>


    {{-- Modal para agregar y editar foro --}}
    <div wire:ignore.self class="modal fade" id="modal-foro" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_modal }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="cerrar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_foro">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="titulo_foro" class="form-label required">
                                    Título del Foro
                                </label>
                                <input type="text" name="titulo_foro"
                                    class="form-control @error('titulo_foro') is-invalid @elseif(strlen($titulo_foro) > 0) is-valid @enderror"
                                    id="titulo_foro" wire:model.live="titulo_foro"
                                    placeholder="Ingrese su correo electrónico" />
                                @error('titulo_foro')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-12">
                                <label for="descripcion_foro" class="form-label">
                                    Descripción del Foro
                                </label>
                                <textarea name="descripcion_foro"
                                    class="form-control @error('descripcion_foro') is-invalid @elseif(strlen($descripcion_foro) > 0) is-valid @enderror"
                                    id="descripcion_foro" wire:model.live="descripcion_foro"
                                    placeholder="Ingrese la descripción del trabajo académico" rows="4"></textarea>
                                @error('descripcion_foro')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="fecha_inicio_foro" class="form-label required">
                                    Fecha de inicio
                                </label>
                                <input type="date" name="fecha_inicio_foro"
                                    class="form-control @error('fecha_inicio_foro') is-invalid @elseif(strlen($fecha_inicio_foro) > 0) is-valid @enderror"
                                    id="fecha_inicio_foro"
                                    wire:model.live="fecha_inicio_foro" />
                                @error('fecha_inicio_foro')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="hora_inicio_foro" class="form-label required">
                                    Hora de inicio
                                </label>
                                <input type="time" name="hora_inicio_foro"
                                    class="form-control @error('hora_inicio_foro') is-invalid @elseif(strlen($hora_inicio_foro) > 0) is-valid @enderror"
                                    id="hora_inicio_foro"
                                    wire:model.live="hora_inicio_foro" />
                                @error('hora_inicio_foro')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="fecha_fin_foro" class="form-label required">
                                    Fecha de fin
                                </label>
                                <input type="date" name="fecha_fin_foro"
                                    class="form-control @error('fecha_fin_foro') is-invalid @elseif(strlen($fecha_fin_foro) > 0) is-valid @enderror"
                                    id="fecha_fin_foro" wire:model.live="fecha_fin_foro" />
                                @error('fecha_fin_foro')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="hora_fin_foro" class="form-label required">
                                    Hora de fin
                                </label>
                                <input type="time" name="hora_fin_foro"
                                    class="form-control @error('hora_fin_foro') is-invalid @elseif(strlen($hora_fin_foro) > 0) is-valid @enderror"
                                    id="hora_fin_foro" wire:model.live="hora_fin_foro" />
                                @error('hora_fin_foro')
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
                            <button class="btn btn-primary w-100" type="submit"
                                wire:loading.attr="disabled" wire:target="guardar_foro">
                                <span wire:loading.remove wire:target="guardar_foro">
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
                                    {{ $accion_modal }}
                                </span>
                                <span wire:loading wire:target="guardar_foro">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Cargando
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
