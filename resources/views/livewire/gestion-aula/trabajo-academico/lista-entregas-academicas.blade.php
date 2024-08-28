<div>

    <livewire:components.page-header :titulo_pasos="$titulo_page_header" :titulo="$titulo_page_header"
        :links_array="$links_page_header" :regresar="$regresar_page_header" lazy />

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
                <livewire:components.info-alumnos-docentes :usuario="$usuario" :tipo_vista="$tipo_vista" lazy />
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    {{-- <div class="card animate__animated animate__fadeIn animate__faster">
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
                                        <th class="w-1">No.</th>
                                        <th class="col-1">Código</th>
                                        <th>Alumno</th>
                                        <th>Usuario</th>
                                        <th>Última conexión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = $alumnos->count() ?? 0;
                                    @endphp
                                    @forelse ($alumnos as $item)
                                        <tr class="{{ $item->estado_gestion_aula_usuario === 0 ? 'bg-red text-white fw-bold' : '' }}">
                                            <td>
                                                <span class="{{ $item->estado_gestion_aula_usuario === 0 ? 'text-white' : 'text-secondary' }}">
                                                    {{ $i-- }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $item->usuario->persona->codigo_alumno_persona }}
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <img src="{{ asset($item->usuario->mostrarFoto('azure')) }}" alt="avatar" class="avatar rounded avatar-static me-2">
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
                                        </tr>
                                    @empty
                                        @if ($alumnos->count() == 0 && $search != '')
                                            <tr>
                                                <td colspan="5">
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
                                                <td colspan="5">
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
                    </div> --}}
                </div>

                <div class="col-lg-4">
                    @livewire('components.card-estado-trabajo', [
                        'id_usuario_hash' => $id_usuario_hash,
                        'tipo_vista' => $tipo_vista,
                        'id_gestion_aula_usuario' => $id_gestion_aula_usuario,
                        'trabajo_academico' => $trabajo_academico,
                        'id_gestion_aula' => $id_gestion_aula,
                    ])
                </div>
            </div>
        </div>
    </div>

</div>
