<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            @if ($es_docente_invitado)
                <livewire:components.navegacion.alert-docente-invitado />
            @endif

            <div class="row row-cards d-flex justify-content-between">
                <div class="col-lg-2 d-none d-lg-block">
                    <livewire:components.navegacion.navegacion-curso :tipo_vista=$tipo_vista
                        :id_usuario=$id_usuario_hash :id_curso=$id_gestion_aula_hash />
                </div>

                <div class="col-lg-10 col-md-12 col-sm-12">
                    @if ($modo_admin)
                        <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
                    @endif

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card animate__animated animate__fadeIn  ">

                                <div class="card-stamp card-stamp-lg">
                                    {{-- Icono de la tarjeta (Lado derecho de la esquina superior) --}}
                                    <div class="card-stamp-icon bg-orange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                            <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="card-body border-bottom py-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-secondary">
                                            Mostrar
                                            <div class="mx-2 d-inline-block">
                                                <select wire:model.live="mostrar_paginate" class="form-select">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="50">50</option>
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
                                                <th class="w-1">No.</th>
                                                <th class="col-1">Código</th>
                                                <th>Alumno</th>
                                                <th>Usuario</th>
                                                <th>Última conexión</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @forelse ($alumnos as $item)
                                                <tr
                                                    class="{{ !$item->usuario->gestionAulaAlumno->first()->estado_gestion_aula_alumno ? 'bg-red text-white fw-bold' : '' }}"
                                                    wire:key="alumno-{{ $item->usuario->gestionAulaAlumno->first()->id_gestion_aula_alumno }}"
                                                >
                                                    <td>
                                                        <span
                                                            class="{{ !$item->usuario->gestionAulaAlumno->first()->estado_gestion_aula_alumno ? 'text-white' : 'text-secondary' }}">
                                                            {{ $i++ }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $item->codigo_alumno_persona }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex py-1 align-items-center">
                                                            <img src="{{ asset($item->usuario->mostrarFoto('azure')) }}"
                                                                alt="avatar"
                                                                class="avatar rounded avatar-static me-2">
                                                            <div class="flex-fill">
                                                                <div class="font-weight-medium">
                                                                    {{ $item->nombre_completo }}
                                                                </div>

                                                                <div x-data="{ isCopied: false }"
                                                                    class="col-auto {{ !$item->usuario->gestionAulaAlumno->first()->estado_gestion_aula_alumno ? 'text-white' : 'text-secondary' }}">
                                                                    <a class="text-reset cursor-pointer copy-to-clipboard"
                                                                        @click="navigator.clipboard.writeText('{{ $item->usuario->persona->documento_persona }}')
                                                                        .then(() => {
                                                                            isCopied = true;
                                                                            setTimeout(() => isCopied = false, 1000);
                                                                        }).catch(err => console.error('Error al copiar al portapapeles: ', err))"
                                                                        x-show="!isCopied">
                                                                        {{ $item->documento_persona }}
                                                                    </a>

                                                                    <span x-show="isCopied" class="text-primary">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-copy-check">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none" />
                                                                            <path stroke="none" d="M0 0h24v24H0z" />
                                                                            <path
                                                                                d="M7 9.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                                            <path
                                                                                d="M4.012 16.737a2 2 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                                            <path d="M11 14l2 2l4 -4" />
                                                                        </svg>
                                                                        Copiado
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $item->usuario->correo_usuario }}
                                                    </td>
                                                    <td
                                                        class="{{ !$item->usuario->auditoria->last() ? 'text-red' : '' }}">
                                                        {{ $item->usuario->auditoria->last() === null ? 'Sin conexión' : ultima_conexion($item->usuario->auditoria->last()->fecha_auditoria) }}
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
