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

                            <li class="breadcrumb-item">
                                @if($this->modo_admin)
                                    <a href="{{ route('docentes.carga-academica', $id_gestion_aula_usuario_hash) }}">Carga Académica</a>
                                @else
                                    <a href="{{ route('carga-academica') }}">Carga Académica</a>
                                @endif
                            </li>

                            <li class="breadcrumb-item">
                                @if($this->modo_admin)
                                    <a href="{{ route('docentes.carga-academica.detalle', $id_gestion_aula_usuario_hash) }}">Detalle</a>
                                @else
                                    <a href="{{ route('carga-academica.detalle', $id_gestion_aula_usuario_hash) }}">Detalle</a>
                                @endif
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Lista de Alumnos
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Lista de Alumnos
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if($this->modo_admin)
                            <a href="{{ route('docentes.carga-academica.detalle', $id_gestion_aula_usuario_hash) }}"
                            class="btn btn-secondary d-none d-md-inline-block">
                        @else
                            <a href="{{ route('carga-academica.detalle', $id_gestion_aula_usuario_hash) }}"
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

                        @if($this->modo_admin)
                            <a href="{{ route('docentes.carga-academica.detalle', $id_gestion_aula_usuario_hash) }}"
                            class="btn btn-secondary d-md-none btn-icon">
                        @else
                            <a href="{{ route('carga-academica.detalle', $id_gestion_aula_usuario_hash) }}"
                            class="btn btn-secondary d-md-none btn-icon">
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
                                <div class="text-secondary">
                                    <div class="">
                                        <div class="d-inline-block">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search" aria-label="Search invoice"
                                                placeholder="Buscar">
                                        </div>
                                    </div>
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
                                                        <div class="{{ $item->estado_gestion_aula_usuario === 0 ? 'text-white' : 'text-secondary' }}">
                                                            <a href="#" class="text-reset">
                                                                {{ $item->usuario->persona->documento_persona }}
                                                            </a>
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
