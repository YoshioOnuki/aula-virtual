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
                            <div class="d-flex">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate" class="form-select form-select-sm">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="ms-auto text-secondary">
                                    Buscar:
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.live.debounce.500ms="search" aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped  datatable">
                                <thead>
                                    <tr>
                                        <th class="col-2">Fecha</th>
                                        <th class="col-2">Hora</th>
                                        <th>Descripción</th>
                                        <th class="col-2">Estado</th>
                                        <th class="col-2">Asistencia</th>
                                    </tr>
                                </thead>
                                <tbody wire:init="load_asistencias_llamar">
                                    @if($cargando)
                                        <tr>
                                            <td colspan="5">
                                                <div class="text-center py-2">
                                                    <span class="text-secondary">
                                                        {{-- Cargando datos... --}}
                                                        <div class="spinner-border text-primary ms-3"></div>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @forelse ($asistencias as $item)
                                            <tr>
                                                <td>
                                                    {{ format_fecha($item->fecha_asistencia) }} ({{ format_dia_semana($item->fecha_asistencia) }})
                                                </td>
                                                <td>
                                                    {{ format_hora($item->hora_inicio_asistencia) }} - {{ format_hora($item->hora_fin_asistencia) }}
                                                </td>
                                                <td>
                                                    {{ $item->nombre_asistencia }}
                                                </td>
                                                <td>
                                                    {{-- @if ($item->asistencia_estado == 1) --}}
                                                        <span class="status status-primary px-3 py-2">
                                                            Presente
                                                        </span>
                                                    {{-- @else
                                                        <span class="status status-red px-3 py-2">
                                                            <span class="status-dot status-dot-animated"></span>
                                                            Inactivo
                                                        </span>
                                                    @endif --}}
                                                </td>
                                                <td>
                                                    Hecho
                                                </td>
                                            </tr>
                                        @empty
                                            @if ($asistencias->count() == 0 && $search != '')
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="text-center"
                                                            style="padding-bottom: 5rem; padding-top: 5rem;">
                                                            <span class="text-secondary">
                                                                No se encontraron resultados para
                                                                "<strong>{{ $search }}</strong>"
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="7">
                                                        <div class="text-center"
                                                            style="padding-bottom: 5rem; padding-top: 5rem;">
                                                            <span class="text-secondary">
                                                                No hay personas registrados
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="card-footer {{ $personas->hasPages() ? 'py-0' : '' }}">
                            @if ($personas->hasPages())
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $personas->firstItem() }} - {{ $personas->lastItem() }} de
                                        {{ $personas->total() }} registros
                                    </div>
                                    <div class="mt-3">
                                        {{ $personas->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $personas->firstItem() }} - {{ $personas->lastItem() }} de
                                        {{ $personas->total() }} registros
                                    </div>
                                </div>
                            @endif
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div wire:ignore.self class="modal" id="modal-recursos" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $titulo_modal }}
                </h5>
                <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal" aria-label="Close" wire:click="cerrar_modal"></button>
            </div>
            <form autocomplete="off" wire:submit="guardar_recurso">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <label for="correo_electronico" class="form-label required">
                                Nombre del Recurso
                            </label>
                            <input type="text" name="nombre_recurso" class="form-control @error('nombre_recurso') is-invalid @enderror" id="nombre_recurso" wire:model.live="nombre_recurso" placeholder="Ingrese su correo electrónico" />
                            @error('nombre_recurso')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="archivo" class="form-label required">
                                Archivo
                            </label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror" id="archivo" wire:model.live="archivo" />
                            @error('archivo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="cerrar_modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-ban">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M5.7 5.7l12.6 12.6" />
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        @if ($modo === 1)
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                <path d="M16 5l3 3" />
                            </svg>
                        @endif
                        {{ $accion_estado }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

</div>

{{-- /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */ --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('load_asistencias_evento', () => {
            setTimeout(() => {
                @this.call('load_asistencias')
            }, 1000);
        });
    });
</script>
