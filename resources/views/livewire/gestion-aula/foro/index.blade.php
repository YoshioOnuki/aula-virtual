<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards d-flex justify-content-between">
                <div class="col-lg-2 d-none d-lg-block">
                    <livewire:components.navegacion.navegacion-curso :tipo_vista=$tipo_vista
                        :id_usuario=$id_usuario_hash :id_curso=$id_gestion_aula_hash />
                </div>

                <div class="col-lg-10 col-md-12 col-sm-12">
                    @if($modo_admin)
                        <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
                    @endif

                    <div class="card animate__animated animate__fadeIn  ">
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="text-secondary">
                                    <div class="">
                                        <div class="d-inline-block">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search"
                                                aria-label="Search invoice" placeholder="Buscar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>Título del foro</th>
                                        <th class="col-2">Última respuesta</th>
                                        <th class="col-1 text-center">Respuestas</th>
                                        @if($usuario->esDocente($id_gestion_aula) || $usuario->esDocenteInvitado($id_gestion_aula))
                                            <th class="w-1 text-center"></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($foros as $item)
                                        <tr>
                                            <td>
                                                <a href="" class="text-reset">
                                                    {{ $item->titulo_foro }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <img src="{{ asset($item->foroRespuesta->gestionAulaAlumno->usuario->mostrarFoto('alumno')) }}" alt="avatar"
                                                        class="avatar me-2 rounded avatar-static">
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">
                                                            {{ Str::limit($item->foroRespuesta->gestionAulaAlumno->usuario->nombre_completo, 18) }}
                                                        </div>
                                                        <div class="text-secondary">
                                                            <a href="#" class="text-reset">
                                                                {{-- Validar si la fecha es hoy --}}
                                                                @if($item->foroRespuesta->created_at->isToday())
                                                                Hoy {{ $item->foroRespuesta->created_at->diffForHumans() }}
                                                                @else
                                                                    {{ format_fecha_string($item->foroRespuesta->created_at) }}
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                {{ $item->foro_respuesta_count }}
                                            </td>
                                            @if($usuario->esDocente($id_gestion_aula) || $usuario->esDocenteInvitado($id_gestion_aula))
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a href="#" class=" text-dark" data-bs-toggle="dropdown">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                            </svg>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#">Editar</a>
                                                            <a class="dropdown-item" href="#">Duplicar</a>
                                                            <a class="dropdown-item" href="#">Eliminar</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        @if ($foros->count() == 0 && $search != '')
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center"
                                                        style="padding-bottom: 2rem; padding-top: 2rem;">
                                                        <span class="text-secondary">
                                                            No se encontraron resultados para
                                                            "<strong>{{ $search }}</strong>"
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center"
                                                        style="padding-bottom: 2rem; padding-top: 2rem;">
                                                        <span class="text-secondary">
                                                            No hay foros disponibles
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer {{ $foros->hasPages() ? 'py-0' : '' }}">
                            @if ($foros->hasPages())
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $foros->firstItem() }} - {{
                                        $foros->lastItem() }} de
                                        {{ $foros->total() }} registros
                                    </div>
                                    <div class="mt-3">
                                        {{ $foros->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $foros->firstItem() }} - {{
                                        $foros->lastItem() }} de
                                        {{ $foros->total() }} registros
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>



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
                        aria-label="Close" wire:click="limpiar_modal"></button>
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
                                    id="fecha_inicio_foro" wire:model.live="fecha_inicio_foro" />
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
                                    id="hora_inicio_foro" wire:model.live="hora_inicio_foro" />
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
                            <button class="btn btn-primary w-100" type="submit" wire:loading.attr="disabled"
                                wire:target="guardar_foro">
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
