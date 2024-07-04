<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="{{ route('inicio') }}">Inicio</a>
                            </li>

                            @if (session('tipo_vista') === 'alumno')
                                <li class="breadcrumb-item">
                                    @if($this->modo_admin)
                                        <a href="{{ route('alumnos.cursos', $id_gestion_aula_usuario_hash) }}">Mis Cursos</a>
                                    @else
                                        <a href="{{ route('cursos', $id_gestion_aula_usuario_hash) }}">Mis Cursos</a>
                                    @endif
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    @if($this->modo_admin)
                                        <a href="{{ route('docentes.carga-academica', $id_gestion_aula_usuario_hash) }}">Carga Académica</a>
                                    @else
                                        <a href="{{ route('carga-academica', $id_gestion_aula_usuario_hash) }}">Carga Académica</a>
                                    @endif
                                </li>
                            @endif

                            @if (session('tipo_vista') === 'alumno')
                                <li class="breadcrumb-item">
                                    @if($this->modo_admin)
                                        <a href="{{ route('alumnos.cursos.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}">
                                            Detalle
                                        </a>
                                    @else
                                        <a href="{{ route('cursos.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}">
                                            Detalle
                                        </a>
                                    @endif
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    @if($this->modo_admin)
                                        <a href="{{ route('docentes.carga-academica.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}">
                                            Detalle
                                        </a>
                                    @else
                                        <a href="{{ route('carga-academica.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}">
                                            Detalle
                                        </a>
                                    @endif
                                </li>
                            @endif

                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Asistencia
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Asistencia
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if (session('tipo_vista') === 'alumno')
                            @if($this->modo_admin)
                                <a href="{{ route('alumnos.cursos.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
                                class="btn btn-secondary d-none d-md-inline-block">
                            @else
                                <a href="{{ route('cursos.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
                                class="btn btn-secondary d-none d-md-inline-block">
                            @endif
                        @else
                            @if($this->modo_admin)
                                <a href="{{ route('docentes.carga-academica.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
                                class="btn btn-secondary d-none d-md-inline-block">
                            @else
                                <a href="{{ route('carga-academica.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
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
                                <a href="{{ route('alumnos.cursos.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
                                class="btn btn-secondary d-md-none btn-icon">
                            @else
                                <a href="{{ route('cursos.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
                                class="btn btn-secondary d-md-none btn-icon">
                            @endif
                        @else
                            @if($this->modo_admin)
                                <a href="{{ route('docentes.carga-academica.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
                                class="btn btn-secondary d-md-none btn-icon">
                            @else
                                <a href="{{ route('carga-academica.detalle', ['id_usuario' => $id_usuario_hash, 'id_curso' => $id_gestion_aula_usuario_hash]) }}"
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
                                    @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) && session('tipo_vista') === 'docente')
                                        <div class="col-lg-7 col-9">
                                            <div class="d-inline-block">
                                                <input type="text" class="form-control"
                                                    wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                    placeholder="Buscar">
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12 col-9">
                                            <div class="d-inline-block">
                                                <input type="text" class="form-control"
                                                    wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                    placeholder="Buscar">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) && session('tipo_vista') === 'docente')
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
                                                Crear Asistencia
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
                                        <th class="col-2">Fecha</th>
                                        <th class="col-2">Hora</th>
                                        <th>Descripción</th>
                                        @if (session('tipo_vista') === 'alumno')
                                            <th class="col-2 text-center">Estado</th>
                                        @endif
                                        <th class="col-2 text-center">Acciones</th>
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
                                            @elseif (session('tipo_vista') === 'docente' && ($usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario) || $usuario->esRolGestionAula('DOCENTE INVITADO', $id_gestion_aula_usuario)))
                                                <td>
                                                    @if (verificar_hora_actual($item->hora_inicio_asistencia, $item->hora_fin_asistencia, $item->fecha_asistencia))
                                                        <button type="button" class="btn btn-outline-primary btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit me-1">
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                    fill="none" />
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
                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                    fill="none" />
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
