<div>

    <div class="container-tight py-4 mobile-message mt-6 animate__animated animate__fadeIn animate__faster">
        <div class="empty">
            <div class="empty-img"><img src="/assets/static/illustrations/undraw_posting_photo_v65l.svg" height="128" alt="">
            </div>
            <p class="empty-title">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">
                        Acceso Restringido
                    </font>
                </font>
            </p>
            <p class="empty-subtitle text-secondary">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">
                        Esta vista no está disponible en dispositivos móviles. Por favor, accede desde una laptop o PC.
                    </font>
                </font>
            </p>
            <div class="empty-action">
                <a href="./." class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l14 0"></path>
                        <path d="M5 12l6 6"></path>
                        <path d="M5 12l6 -6"></path>
                    </svg>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">
                            Regresar
                        </font>
                    </font>
                </a>
            </div>
        </div>
    </div>

    <div class="asistencias">

        @livewire('components.page-header', [
            'titulo_pasos' => $titulo_page_header,
            'titulo' => $titulo_page_header,
            'links_array' => $links_page_header,
            'regresar' => $regresar_page_header
        ])

        <div class="page-body">
            <div class="container-xl">

                @if($modo_admin)
                    @livewire('components.info-alumnos-docentes', [
                        'usuario' => $usuario,
                        'tipo_vista' => $tipo_vista
                    ])
                @endif

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card animate__animated animate__fadeIn animate__faster">
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
                                    <div class="text-secondary row">
                                        @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) && $tipo_vista === 'carga-academica')
                                            <div class="col-lg-7 col-9">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control"
                                                        wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                        placeholder="Buscar">
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-12">
                                                <div class="d-inline-block">
                                                    <input type="text" class="form-control"
                                                        wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                        placeholder="Buscar">
                                                </div>
                                            </div>
                                        @endif

                                        @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) && $tipo_vista === 'carga-academica')
                                            <div class="col-lg-5 col-3 d-flex justify-content-end">
                                                <a class="btn btn-primary d-none d-md-inline-block" wire:click="abrir_modal_asistencias_agregar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                    Crear Asistencia
                                                </a>
                                                <a class="btn btn-primary d-md-none btn-icon" wire:click="abrir_modal_asistencias_agregar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-2">Fecha</th>
                                            <th class="col-2">Hora</th>
                                            <th>Descripción</th>
                                            @if ($tipo_vista === 'cursos')
                                                <th class="col-2 text-center">Estado</th>
                                            @endif
                                            <th class="col-2">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($asistencias as $item)
                                            <tr>
                                                <td>
                                                    {{ format_fecha($item->fecha_asistencia) }}
                                                    ({{ format_dia_semana($item->fecha_asistencia) }})
                                                </td>
                                                <td>
                                                    {{ format_hora($item->hora_inicio_asistencia) }} -
                                                    {{ format_hora($item->hora_fin_asistencia) }}
                                                </td>
                                                <td>
                                                    Sesión de {{ $item->tipoAsistencia->nombre_tipo_asistencia }}
                                                </td>
                                                @if ($tipo_vista === 'cursos')
                                                    <td class="text-center">
                                                        @if (!$item->asistenciaAlumno->isEmpty())
                                                            <span class="status status-teal px-3 py-2">
                                                                Presente
                                                            </span>
                                                        @else
                                                            ?
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->asistenciaAlumno->isEmpty())
                                                            <button type="button" class="btn btn-outline-primary
                                                                {{ verificar_hora_actual($item->hora_inicio_asistencia, $item->hora_fin_asistencia, $item->fecha_asistencia) ? '' : 'disabled' }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-checks">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M7 12l5 5l10 -10" />
                                                                    <path d="M2 12l5 5m5 -5l5 -5" />
                                                                </svg>
                                                                Enviar Asistencia
                                                            </button>
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-checks text-success">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M7 12l5 5l10 -10" />
                                                                <path d="M2 12l5 5m5 -5l5 -5" />
                                                            </svg>
                                                        @endif
                                                    </td>
                                                @elseif ($tipo_vista === 'carga-academica' && ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) || $usuario->esRolGestionAula('DOCENTE INVITADO', $id_gestion_aula_usuario)))
                                                    <td>
                                                        <div class="btn-list flex-nowrap">
                                                            <div class="dropdown">
                                                                <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Acciones
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    @if (verificar_hora_actual($item->hora_inicio_asistencia, $item->hora_fin_asistencia, $item->fecha_asistencia))
                                                                        <a class="dropdown-item" style="cursor: pointer;">
                                                                            Marcar Asistencias
                                                                        </a>
                                                                    @else
                                                                        <a class="dropdown-item" style="cursor: pointer;">
                                                                            Ver Asistencias
                                                                        </a>
                                                                    @endif
                                                                    <a class="dropdown-item" style="cursor: pointer;" wire:click="abrir_modal_asistencias_editar({{ $item->id_asistencia }})">
                                                                        Editar
                                                                    </a>
                                                                    <a class="dropdown-item" style="cursor: pointer;" wire:click="abrir_modal_eliminar({{ $item->id_asistencia }})">
                                                                        Eliminar
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            @if ($asistencias->count() == 0 && $search != '')
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
                                                                No hay asistencias registradas
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer {{ $asistencias->hasPages() ? 'py-0' : '' }}">
                                @if ($asistencias->hasPages())
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center text-secondary">
                                            Mostrando {{ $asistencias->firstItem() }} - {{ $asistencias->lastItem() }} de
                                            {{ $asistencias->total() }} registros
                                        </div>
                                        <div class="mt-3">
                                            {{ $asistencias->links() }}
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center text-secondary">
                                            Mostrando {{ $asistencias->firstItem() }} - {{ $asistencias->lastItem() }} de
                                            {{ $asistencias->total() }} registros
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


    <div wire:ignore.self class="modal fade" id="modal-asistencias" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $titulo_asistencias }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="cerrar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_asistencias" novalidate>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <label for="tipo_asistencia" class="form-label required">Tipo de Asistencia</label>
                                <select type="password" class="form-select @if ($errors->has('tipo_asistencia')) is-invalid @elseif($tipo_asistencia) is-valid @endif"
                                id="tipo_asistencia" wire:model.live="tipo_asistencia">
                                    <option value="">Seleccione el tipo de asistencia</option>
                                    @foreach ($tipo_asistencias as $item)
                                        <option value="{{ $item->id_tipo_asistencia }}">{{ $item->nombre_tipo_asistencia }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_asistencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-hint">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">
                                            <strong>Asistencia Autónoma:</strong> El alumno registra su asistencia de
                                            manera autónoma. <br>
                                            <strong>Asistencia Supervisada:</strong> El docente registra la asistencia del
                                            alumno.
                                        </font>
                                    </font>
                                </small>
                            </div>
                            <div class="col-lg-12">
                                <label for="fecha_asistencia" class="form-label required">Fecha de Asistencia</label>
                                <input type="date" class="form-control 
                                @if ($errors->has('fecha_asistencia')) is-invalid 
                                @elseif($fecha_asistencia) is-valid @endif"
                                wire:model.live="fecha_asistencia" min="{{ date('Y-m-d') }}">
                                @error('fecha_asistencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="hora_inicio_asistencia" class="form-label required">Hora de inicio</label>
                                <input type="time" class="form-control 
                                @if ($errors->has('hora_inicio_asistencia')) is-invalid 
                                @elseif($hora_inicio_asistencia) is-valid @endif"
                                wire:model.live="hora_inicio_asistencia"
                                {{ ($modo_asistencias === 0 && $this->validate_hora_inicio() && $fecha_asistencia_temporal === $fecha_asistencia) || ($modo_asistencias === 0 && $this->validate_fecha()) ? 'disabled' : '' }}>
                                @error('hora_inicio_asistencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="hora_fin_asistencia" class="form-label required">Hora de fin</label>
                                <input type="time" class="form-control 
                                @if ($errors->has('hora_fin_asistencia')) is-invalid 
                                @elseif($hora_fin_asistencia) is-valid @endif"
                                wire:model.live="hora_fin_asistencia"
                                {{ $modo_asistencias === 0 &&  $this->validate_fecha() ? 'disabled' : '' }}>
                                @error('hora_fin_asistencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-outline-secondary" data-bs-dismiss="modal"
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
                            @if ($modo_asistencias === 1)
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
                            {{ $accion_asistencias }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal-eliminar" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Eliminar Asistencia
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar_modal_eliminar"></button>
                </div>
                <form autocomplete="off" wire:submit="eliminar_asistencia({{ $id_asistencia_a_eliminar }})" novalidate>
                    <div class="modal-status bg-red"></div>
                    <div class="modal-body px-6">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-2 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash svg-extra-large my-6 text-red">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#f59f00" class="icon icon-tabler icons-tabler-filled icon-tabler-bell-ringing">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M17.451 2.344a1 1 0 0 1 1.41 -.099a12.05 12.05 0 0 1 3.048 4.064a1 1 0 1 1 -1.818 .836a10.05 10.05 0 0 0 -2.54 -3.39a1 1 0 0 1 -.1 -1.41z" />
                                                <path d="M5.136 2.245a1 1 0 0 1 1.312 1.51a10.05 10.05 0 0 0 -2.54 3.39a1 1 0 1 1 -1.817 -.835a12.05 12.05 0 0 1 3.045 -4.065z" />
                                                <path d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" />
                                                <path d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title text-dark">¡Alerta!</h4>
                                            <div class="text-dark">
                                                Estás a punto de <strong>Eliminar</strong> la asistencia seleccionada y todos los registros asociados.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <ul style="list-style-type: none;">
                                    <li class="mb-2">
                                        <strong>
                                            Tipo de Asistencia:
                                        </strong>
                                        <span class="text-secondary">
                                            {{ $tipo_asistencia_a_eliminar }}
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Fecha:</strong>
                                        <span class="text-secondary">
                                            {{ $fecha_asistencia_a_eliminar }}
                                        </span>
                                    </li>
                                    <li class="">
                                        <strong>Horario:</strong>
                                        <span class="text-secondary">
                                            {{ $hora_inicio_asistencia_a_eliminar }} -
                                            {{ $hora_fin_asistencia_a_eliminar }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="cerrar_modal_eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M5.7 5.7l12.6 12.6" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-red ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
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
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')

    <script src="{{ asset('js/mobile-detect/mobile-detect.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            const asistencias = document.querySelector('.asistencias');
            const mobileMessage = document.querySelector('.mobile-message');
            const md = new MobileDetect(window.navigator.userAgent);

            function isMobileDevice() {
                return md.mobile() !== null;
            }

            function toggleContent() {
                const isMobile = isMobileDevice();
                const isNarrowScreen = window.innerWidth < 768;
                asistencias.style.display = (isMobile || isNarrowScreen) ? 'none' : 'block';
                mobileMessage.style.display = (isMobile || isNarrowScreen) ? 'block' : 'none';
            }

            toggleContent();
            window.addEventListener("resize", toggleContent);
        });
    </script>
@endpush
