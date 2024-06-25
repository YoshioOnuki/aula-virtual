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
                                    <th class="col-1">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alumnos as $item)
                                    <tr>
                                        <td>
                                            {{ $item->usuario->persona->codigo_alumno_persona }}
                                        </td>
                                        <td>
                                            {{ $item->usuario->nombre_completo }}
                                        </td>
                                        <td>
                                            {{ $item->usuario->correo_usuario }}
                                        </td>
                                        <td>
                                            {{ ultima_conexion('2024-06-23 12:18:17') }}
                                        </td>
                                        <td>
                                            @if ($item->estado_gestion_aula_usuario === 1)
                                                <a wire:click="abrir_modal_estado({{ $item->id_usuario }}, 0)" class="text-decoration-none cursor-pointer">
                                                    <span class="badge bg-teal-lt status-teal px-3 py-2 fs-4">
                                                        <span class="status-dot status-dot-animated me-2"></span>
                                                        Matriculado
                                                    </span>
                                                </a>
                                            @else
                                                <a wire:click="abrir_modal_estado({{ $item->id_usuario }}, 1)" class="text-decoration-none cursor-pointer">
                                                    <span class="badge bg-red-lt status-red px-3 py-2 fs-4">
                                                        <span class="status-dot status-dot-animated me-2"></span>
                                                        Retirado
                                                    </span>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Acciones
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" style="cursor: pointer;">
                                                            Ver
                                                        </a>
                                                        <a class="dropdown-item" style="cursor: pointer;">
                                                            Editar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
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




</div>
