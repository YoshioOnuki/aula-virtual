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
                                    <a
                                        href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    <a
                                        href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                </li>
                            @endif

                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Alumnos
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Alumnos
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if (session('tipo_vista') === 'alumno')
                            <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                class="btn btn-secondary d-none d-md-inline-block">
                            @else
                                <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}"
                                    class="btn btn-secondary d-none d-md-inline-block">
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
                        <a href="" class="btn btn-secondary d-md-none btn-icon">
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
                                    @if ($usuario->esRol('DOCENTE') && session('tipo_vista') === 'docente')
                                        <div class="col-lg-7 col-9">
                                        @else
                                            <div class="col-lg-12 col-9">
                                    @endif
                                    <div class="d-inline-block">
                                        <input type="text" class="form-control"
                                            wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                            placeholder="Buscar">
                                    </div>
                                </div>
                                @if ($usuario->esRol('DOCENTE') && session('tipo_vista') === 'docente')
                                    <div class="col-lg-5 col-3 d-flex justify-content-end">
                                        <a href="" class="btn btn-primary d-none d-md-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                            Agregar Alumno
                                        </a>
                                        <a href="" class="btn btn-primary d-md-none btn-icon">
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
                                    <th class="col-1">Código</th>
                                    <th>Alumno</th>
                                    <th>Usuario</th>
                                    <th>Última conexión</th>
                                    <th class="col-2">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alumnos as $item)
                                    <tr class="{{ $item->estado_gestion_aula_usuario === 0 ? 'bg-red text-white fw-bold' : '' }}">
                                        <td>
                                            {{ $item->usuario->persona->codigo_alumno_persona }}
                                        </td>
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <img src="{{ asset($item->usuario->mostrarFoto('azure')) }}" alt="avatar" class="avatar me-2">
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium">{{ $item->usuario->nombre_completo }}
                                                    </div>
                                                    <div class=" 
                                                    {{ $item->estado_gestion_aula_usuario === 0 ? 'text-white' : 'text-secondary' }}"><a href="#" class="text-reset">{{ $item->usuario->persona->documento_persona }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->usuario->correo_usuario }}
                                        </td>
                                        <td>
                                            {{ ultima_conexion('2024-06-23 12:18:17') }}
                                        </td>
                                        <td>
                                            @if ($item->estado_gestion_aula_usuario === 1)
                                                <a wire:click="abrir_modal_estado({{ $item->id_gestion_aula_usuario }}, 0)" class="text-decoration-none cursor-pointer">
                                                    <span class="badge bg-teal-lt status-teal px-3 py-2 fs-4">
                                                        <span class="status-dot status-dot-animated me-2"></span>
                                                        Matriculado
                                                    </span>
                                                </a>
                                            @elseif ($item->estado_gestion_aula_usuario === 0)
                                                <a wire:click="abrir_modal_estado({{ $item->id_gestion_aula_usuario }}, 1)" class="text-decoration-none cursor-pointer">
                                                    <span class="badge bg-red-lt status-red px-3 py-2 fs-4">
                                                        <span class="status-dot status-dot-animated me-2"></span>
                                                        Retirado
                                                    </span>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    @if ($alumnos->count() == 0 && $search != '')
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
                                                        No hay alumnos matriculados
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforelse
                                {{-- @forelse($asistencias as $item)
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
                                            {{ $item->nombre_asistencia }}
                                        </td>
                                        @if (session('tipo_vista') === 'alumno')
                                            <td class="text-center">
                                                @if (!$item->asistenciaAlumno->isEmpty())
                                                    <span class="status status-teal px-3 py-2">
                                                        Presente
                                                    </span>
                                                @else
                                                    ?
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($item->asistenciaAlumno->isEmpty())
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm
                                                            {{ verificar_hora_actual($item->hora_inicio_asistencia, $item->hora_fin_asistencia, $item->fecha_asistencia) ? '' : 'disabled' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-checks">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 12l5 5l10 -10" />
                                                            <path d="M2 12l5 5m5 -5l5 -5" />
                                                        </svg>
                                                        Enviar Asistencia
                                                    </button>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-checks text-success">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 12l5 5l10 -10" />
                                                        <path d="M2 12l5 5m5 -5l5 -5" />
                                                    </svg>
                                                @endif
                                            </td>
                                        @elseif (session('tipo_vista') === 'docente' && ($usuario->esRol('DOCENTE') || $usuario->esRol('DOCENTE INVITADO')))
                                            <td>
                                                @if (verificar_hora_actual($item->hora_inicio_asistencia, $item->hora_fin_asistencia, $item->fecha_asistencia))
                                                    <button type="button" class="btn btn-outline-primary btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-1">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M7 12l5 5l10 -10" />
                                                            <path d="M2 12l5 5m5 -5l5 -5" />
                                                        </svg>
                                                        Marcar Asistencias
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-outline-teal btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye me-1">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                            <path
                                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                        </svg>
                                                        Ver Asistencias
                                                    </button>
                                                @endif
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
                                @endforelse --}}
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer {{ $alumnos->hasPages() ? 'py-0' : '' }}">
                        @if ($alumnos->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $alumnos->firstItem() }} - {{ $alumnos->lastItem() }} de
                                    {{ $alumnos->total() }} registros
                                </div>
                                <div class="mt-3">
                                    {{ $alumnos->links() }}
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $alumnos->firstItem() }} - {{ $alumnos->lastItem() }} de
                                    {{ $alumnos->total() }} registros
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal" id="modal-estado-alumnos" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $titulo_modal }}
                </h5>
                <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal" aria-label="Close" wire:click="limpiar_modal"></button>
            </div>
            <form autocomplete="off" wire:submit="cambiar_estado">
                <div class="modal-status bg-{{ $modo === 1 ? 'teal' : 'red' }}"></div>
                <div class="modal-body px-6">
                    <div class="row g-3">
                        <div class="col-lg-12 mt-2 text-center">
                            @if($modo === 1)
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0ca678" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open svg-extra-large my-6">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path d="M8 11v-5a4 4 0 0 1 8 0" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#d63939" class="icon icon-tabler icons-tabler-filled icon-tabler-lock svg-extra-large my-6">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 2a5 5 0 0 1 5 5v3a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3v-6a3 3 0 0 1 3 -3v-3a5 5 0 0 1 5 -5m0 12a2 2 0 0 0 -1.995 1.85l-.005 .15a2 2 0 1 0 2 -2m0 -10a3 3 0 0 0 -3 3v3h6v-3a3 3 0 0 0 -3 -3" />
                            </svg>
                            @endif
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
                                            Estás a punto de <strong>{{ $accion_estado }}</strong> del curso a este alumno.
                                            Esto {{ $modo === 1 ? 'permitirá' : 'restringirá' }} su acceso al curso.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <ul style="list-style-type: none;">
                                <li class="mb-2">
                                    <strong>Código:</strong>
                                    <span class="text-secondary">{{ $codigo_alumno }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Persona:</strong>
                                    <span class="text-secondary">{{ $nombres_alumno }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Usuario:</strong>
                                    <span class="text-secondary">{{ $correo_usuario }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="limpiar_modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M5.7 5.7l12.6 12.6" />
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-{{ $modo === 1 ? 'teal' : 'red' }} ms-auto">
                        @if($modo === 1)
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock-open">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                            <path d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                            <path d="M8 11v-5a4 4 0 0 1 8 0" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" class="icon icon-tabler icons-tabler-filled icon-tabler-lock">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 2a5 5 0 0 1 5 5v3a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-10a3 3 0 0 1 -3 -3v-6a3 3 0 0 1 3 -3v-3a5 5 0 0 1 5 -5m0 12a2 2 0 0 0 -1.995 1.85l-.005 .15a2 2 0 1 0 2 -2m0 -10a3 3 0 0 0 -3 3v3h6v-3a3 3 0 0 0 -3 -3" />
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
