<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            <div wire:init="mostrar_toast"></div>

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

                    <div class="card animate__animated animate__fadeIn">

                        <div class="card-stamp">
                            {{-- Icono de la tarjeta (Lado derecho de la esquina superior) --}}
                            @if ($tipo_vista === 'cursos')
                                <div class="card-stamp-icon bg-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-messages">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                        <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                    </svg>
                                </div>
                            @elseif($tipo_vista === 'carga-academica')
                                <div class="card-stamp-icon bg-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-messages">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                        <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="text-secondary row">
                                    @if ($es_docente && $tipo_vista === 'carga-academica')
                                        <div class="col-lg-7 col-9">
                                            <div class="d-inline-block w-100">
                                                <input type="text" class="form-control"
                                                    wire:model.live.debounce.500ms="search"
                                                    aria-label="Search invoice" placeholder="Buscar">
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12">
                                            <div class="d-inline-block w-100">
                                                <input type="text" class="form-control"
                                                    wire:model.live.debounce.500ms="search"
                                                    aria-label="Search invoice" placeholder="Buscar">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($es_docente && $tipo_vista === 'carga-academica')
                                        <div class="col-lg-5 col-3 d-flex justify-content-end">
                                            <a class="btn btn-primary d-none d-md-inline-block"
                                                href="{{ route('carga-academica.detalle.foro.registrar', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 5l0 14" />
                                                    <path d="M5 12l14 0" />
                                                </svg>
                                                Registrar
                                            </a>
                                            {{-- <a class="btn btn-primary d-none d-md-inline-block"
                                                wire:click="abrir_modal_agregar_foro()" data-bs-toggle="modal"
                                                data-bs-target="#modal-foro">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 5l0 14" />
                                                    <path d="M5 12l14 0" />
                                                </svg>
                                                Registrar
                                            </a> --}}
                                            <a class="btn btn-primary d-md-none btn-icon"
                                                href="{{ route('carga-academica.detalle.foro.registrar', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 5l0 14" />
                                                    <path d="M5 12l14 0" />
                                                </svg>
                                            </a>
                                            {{-- <a class="btn btn-primary d-md-none btn-icon"
                                                wire:click="abrir_modal_agregar_foro()" data-bs-toggle="modal"
                                                data-bs-target="#modal-foro">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 5l0 14" />
                                                    <path d="M5 12l14 0" />
                                                </svg>
                                            </a> --}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>Título del foro</th>
                                        <th class="col-2">Creado por</th>
                                        <th class="col-2">Última respuesta</th>
                                        <th class="col-1 text-center">Respuestas</th>
                                        @if($usuario->esDocente($id_gestion_aula))
                                            <th class="w-1 text-center"></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($foros as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ $tipo_vista === 'carga-academica' ? 
                                                    route('carga-academica.detalle.foro.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($item->id_foro)]) :
                                                    route('cursos.detalle.foro.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($item->id_foro)]) }}"
                                                    class="text-reset">
                                                    {{ $item->titulo_foro }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <img src="{{ asset($item->gestionAulaDocente->usuario->mostrarFoto('docente')) }}" alt="avatar"
                                                        class="avatar me-2 rounded avatar-static">
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">
                                                            {{ Str::limit($item->gestionAulaDocente->usuario->nombre_completo, 20) }}
                                                        </div>
                                                        <div class="text-secondary">
                                                            <a href="{{ $tipo_vista === 'carga-academica' ? 
                                                                route('carga-academica.detalle.foro.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($item->id_foro)]) :
                                                                route('cursos.detalle.foro.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($item->id_foro)]) }}"
                                                                class="text-reset">
                                                                {{-- Validar si la fecha es hoy --}}
                                                                @if($item->created_at->isToday())
                                                                    Hoy {{ $item->created_at->diffForHumans() }}
                                                                @else
                                                                    {{ format_fecha_string($item->created_at) }}
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($item->foroRespuesta->count() > 0)
                                                    <div class="d-flex py-1 align-items-center">
                                                        <img src="{{ asset($item->foroRespuesta->last()->gestionAulaAlumno->usuario->mostrarFoto('alumno')) }}" alt="avatar"
                                                            class="avatar me-2 rounded avatar-static">
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                {{ Str::limit($item->foroRespuesta->last()->gestionAulaAlumno->usuario->nombre_completo, 20) }}
                                                            </div>
                                                            <div class="text-secondary">
                                                                <a href="{{ $tipo_vista === 'carga-academica' ? 
                                                                    route('carga-academica.detalle.foro.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($item->id_foro)]) :
                                                                    route('cursos.detalle.foro.detalle', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($item->id_foro)]) }}"
                                                                    class="text-reset">
                                                                    {{-- Validar si la fecha es hoy --}}
                                                                    @if($item->foroRespuesta->last()->created_at->isToday())
                                                                        Hoy {{ $item->foroRespuesta->last()->created_at->diffForHumans() }}
                                                                    @else
                                                                        {{ format_fecha_string($item->foroRespuesta->last()->created_at) }}
                                                                    @endif
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-secondary">
                                                        Sin respuestas
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $item->foro_respuesta_count }}
                                            </td>
                                            @if($usuario->esDocente($id_gestion_aula))
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
                                                            <a class="dropdown-item cursor-pointer"
                                                                href="{{ route('carga-academica.detalle.foro.editar', ['id_usuario' => $id_usuario_hash, 'tipo_vista' =>  $tipo_vista, 'id_curso' => $id_gestion_aula_hash, 'id_foro' => Hashids::encode($item->id_foro)]) }}">
                                                                Editar
                                                            </a>
                                                            {{-- <a class="dropdown-item cursor-pointer" wire:click="abrir_modal_editar_foro({{ $item->id_foro }})"
                                                                data-bs-toggle="modal" data-bs-target="#modal-foro">
                                                                Editar
                                                            </a> --}}
                                                            {{-- <a class="dropdown-item cursor-pointer" wire:click="abrir_modal_duplicar_foro({{ $item->id_foro }})"
                                                                data-bs-toggle="modal" data-bs-target="#modal-duplicar">
                                                                Duplicar
                                                            </a> --}}
                                                            <a class="dropdown-item cursor-pointer" wire:click="abrir_modal_eliminar_foro({{ $item->id_foro }})"
                                                                data-bs-toggle="modal" data-bs-target="#modal-eliminar">
                                                                Eliminar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        @if ($foros->count() == 0 && $search != '')
                                            <tr>
                                                <td colspan="{{ $usuario->esDocente($id_gestion_aula) ? '5' : '4' }}">
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
                                                <td colspan="{{ $usuario->esDocente($id_gestion_aula) ? '5' : '4' }}">
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


    {{-- Modal para agregar y editar foro <==> DE BAJA --}}
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
                                <label for="descripcion_foro" class="form-label required">
                                    Descripción del Foro
                                </label>
                                <div wire:ignore>
                                    <textarea class="form-control" wire:model.lazy="descripcion_foro"
                                        id="descripcion_foro">
                                        {{ $descripcion_foro }}
                                    </textarea>
                                </div>
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

    {{-- Modal para eliminar foro --}}
    <div wire:ignore.self class="modal fade" id="modal-eliminar" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Eliminar Foro
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal_eliminar"></button>
                </div>
                <form autocomplete="off" wire:submit="eliminar_foro({{ $id_foro_a_eliminar }})" novalidate>
                    <div class="modal-status bg-red"></div>
                    <div class="modal-body px-6">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-2 text-center text-red">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash svg-extra-large my-6">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </div>
                            <div class="col-lg-12 mt-2 text-center">
                                <h4 class="text-center fs-3">
                                    ¿Estas seguro?
                                </h4>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-yellow bg-yellow-lt hover-shadow-sm" role="alert">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="#f59f00"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-bell-ringing">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M17.451 2.344a1 1 0 0 1 1.41 -.099a12.05 12.05 0 0 1 3.048 4.064a1 1 0 1 1 -1.818 .836a10.05 10.05 0 0 0 -2.54 -3.39a1 1 0 0 1 -.1 -1.41z" />
                                                <path
                                                    d="M5.136 2.245a1 1 0 0 1 1.312 1.51a10.05 10.05 0 0 0 -2.54 3.39a1 1 0 1 1 -1.817 -.835a12.05 12.05 0 0 1 3.045 -4.065z" />
                                                <path
                                                    d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" />
                                                <path
                                                    d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title text-dark">¡Alerta!</h4>
                                            <div class="text-dark">
                                                Estás a punto de <strong>Eliminar</strong> el foro seleccionado y
                                                todas las respuestas asociadas.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <ul style="list-style-type: none;">
                                    <li class="mb-2">
                                        <strong>
                                            Título del foro:
                                        </strong>
                                        <span class="text-secondary">
                                            {{ $titulo_foro_a_eliminar }}
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Fecha de inicio:</strong>
                                        <span class="text-secondary">
                                            {{ $fecha_inicio_foro_a_eliminar }}
                                        </span>
                                    </li>
                                    <li class="">
                                        <strong>Fecha de fin:</strong>
                                        <span class="text-secondary">
                                            {{ $fecha_fin_foro_a_eliminar }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal_eliminar">
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
                                <button type="submit" class="btn btn-red">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash text-white">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                    Eliminar
                                </button>
                            </div>
                            <div wire:loading>
                                <button type="submit" class="btn btn-red" disabled>
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

    {{-- Modal para duplicar foro --}}
    <div wire:ignore.self class="modal fade" id="modal-duplicar" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Duplicar Foro
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal_duplicar"></button>
                </div>
                <form autocomplete="off" wire:submit="duplicar_foro({{ $id_foro_a_duplicar }})" novalidate>
                    <div class="modal-status bg-blue"></div>
                    <div class="modal-body px-6">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-2 text-center text-blue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-copy svg-extra-large my-6">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                    <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                </svg>
                            </div>
                            <div class="col-lg-12 mt-2 text-center">
                                <h4 class="text-center fs-3">
                                    ¿Estas seguro?
                                </h4>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-yellow bg-yellow-lt hover-shadow-sm" role="alert">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="#f59f00"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-bell-ringing">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M17.451 2.344a1 1 0 0 1 1.41 -.099a12.05 12.05 0 0 1 3.048 4.064a1 1 0 1 1 -1.818 .836a10.05 10.05 0 0 0 -2.54 -3.39a1 1 0 0 1 -.1 -1.41z" />
                                                <path
                                                    d="M5.136 2.245a1 1 0 0 1 1.312 1.51a10.05 10.05 0 0 0 -2.54 3.39a1 1 0 1 1 -1.817 -.835a12.05 12.05 0 0 1 3.045 -4.065z" />
                                                <path
                                                    d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" />
                                                <path
                                                    d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title text-dark">¡Alerta!</h4>
                                            <div class="text-dark">
                                                Estás a punto de <strong>Duplicar</strong> el foro seleccionado.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <ul style="list-style-type: none;">
                                    <li class="mb-2">
                                        <strong>
                                            Título del foro:
                                        </strong>
                                        <span class="text-secondary">
                                            {{ $titulo_foro_a_duplicar }}
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Fecha de inicio:</strong>
                                        <span class="text-secondary">
                                            {{ $fecha_inicio_foro_a_duplicar }}
                                        </span>
                                    </li>
                                    <li class="">
                                        <strong>Fecha de fin:</strong>
                                        <span class="text-secondary">
                                            {{ $fecha_fin_foro_a_duplicar }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal_duplicar">
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
                                <button type="submit" class="btn btn-blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                        <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                    </svg>
                                    Duplicar
                                </button>
                            </div>
                            <div wire:loading>
                                <button type="submit" class="btn btn-blue" disabled>
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

