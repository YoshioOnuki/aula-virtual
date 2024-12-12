<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            <div class="row row-cards d-flex justify-content-between">
                <div class="col-lg-12">
                    <div class="card card-stacked animate__animated animate__fadeIn">
                        <div class="card-stamp card-stamp-lg">
                            <div class="card-stamp-icon bg-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-library">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                    <path
                                        d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                    <path d="M11 7h5" />
                                    <path d="M11 10h6" />
                                    <path d="M11 13h3" />
                                </svg>
                            </div>
                        </div>

                        <div class="card-body  py-3">
                            <div class="d-flex align-items-center justify-content-between">

                                <div class="d-flex align-items-center justify-content-start">

                                    <button
                                        class="btn btn-outline-azure d-flex justify-content-between align-items-center border-azure me-3  d-none d-lg-inline-block"
                                        x-on:click="$wire.filtro_activo = !$wire.filtro_activo"
                                        :class="$wire.filtro_activo ? 'filter-button-active' : ''"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                            class="icon icon-tabler icons-tabler-filled icon-tabler-filter">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M20 3h-16a1 1 0 0 0 -1 1v2.227l.008 .223a3 3 0 0 0 .772 1.795l4.22 4.641v8.114a1 1 0 0 0 1.316 .949l6 -2l.108 -.043a1 1 0 0 0 .576 -.906v-6.586l4.121 -4.12a3 3 0 0 0 .879 -2.123v-2.171a1 1 0 0 0 -1 -1z" />
                                        </svg>
                                        Filtro
                                    </button>
                                    <button
                                        class="btn btn-outline-azure d-flex justify-content-between align-items-center border-azure me-3 pe-1 d-lg-none"
                                        x-on:click="$wire.filtro_activo = !$wire.filtro_activo"
                                        :class="$wire.filtro_activo ? 'filter-button-active' : ''"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                            class="icon icon-tabler icons-tabler-filled icon-tabler-filter">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M20 3h-16a1 1 0 0 0 -1 1v2.227l.008 .223a3 3 0 0 0 .772 1.795l4.22 4.641v8.114a1 1 0 0 0 1.316 .949l6 -2l.108 -.043a1 1 0 0 0 .576 -.906v-6.586l4.121 -4.12a3 3 0 0 0 .879 -2.123v-2.171a1 1 0 0 0 -1 -1z" />
                                        </svg>
                                    </button>

                                    <div class="text-secondary">
                                        Mostrar
                                        <div class="mx-2 d-inline-block">
                                            <select wire:model.live="mostrar_paginate" class="form-select">
                                                <option value="4">4</option>
                                                <option value="8">8</option>
                                                <option value="12">12</option>
                                                <option value="16">16</option>
                                            </select>
                                        </div>
                                        entradas
                                    </div>
                                </div>

                                <div class="text-secondary row">
                                    <div class="col-lg-7 col-9 col-md-9">
                                        <div class="d-inline-block w-100">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search"
                                                aria-label="Search invoice" placeholder="Buscar">
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-3 d-flex justify-content-end">
                                        <a
                                            class="btn btn-primary d-none d-lg-inline-block cursor-pointer"
                                            wire:click="abrir_modal_carga_academica"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-carga-academica"
                                        >
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
                                        <a
                                            class="btn btn-primary d-lg-none btn-icon cursor-pointer"
                                            wire:click="abrir_modal_carga_academica"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-carga-academica"
                                        >
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
                                </div>

                            </div>
                        </div>

                        <div
                            class="card-body  py-3"
                            x-show="$wire.filtro_activo"
                            x-cloak
                            x-collapse
                        >
                            <div class="row row-cards d-flex justify-content-start">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                    <label for="filtro_tipo_programa" class="form-label">Tipo Programa</label>
                                    <select
                                        x-model="$wire.filtro_tipo_programa"
                                        :class="$wire.filtro_tipo_programa === '' ? 'text-secondary' : ''"
                                        class="form-select"
                                        id="filtro_tipo_programa"
                                        wire:model.lazy="filtro_tipo_programa"
                                    >
                                        <option value="">Seleccione el tipo de programa</option>
                                        @foreach ($tipo_programas as $item)
                                            <option value="{{ $item->id_tipo_programa }}" wire:key="{{ $item->id_tipo_programa }}">
                                                {{ $item->nombre_tipo_programa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                    <label for="filtro_facultad" class="form-label">Facultad</label>
                                    <select
                                        x-model="$wire.filtro_facultad"
                                        :class="$wire.filtro_facultad === '' ? 'text-secondary' : ''"
                                        class="form-select "
                                        id="filtro_facultad"
                                        wire:model.lazy="filtro_facultad"
                                    >
                                        <option value="">Seleccione la facultad</option>
                                        @foreach ($facultades as $item)
                                            <option value="{{ $item->id_facultad }}" wire:key="{{ $item->id_facultad }}">
                                                {{ $item->nombre_facultad }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                    <label for="filtro_programa" class="form-label">
                                        <template x-if="$wire.filtro_facultad === '' || $wire.filtro_tipo_programa === ''">
                                            <span class="text-secondary">
                                                Programa
                                            </span>
                                        </template>
                                        <template x-if="$wire.filtro_facultad !== '' && $wire.filtro_tipo_programa !== ''">
                                            <span class="">
                                                Programa
                                            </span>
                                        </template>
                                    </label>
                                    <select
                                        x-model="$wire.filtro_programa"
                                        :class="$wire.filtro_programa === '' ? 'text-secondary' : ''"
                                        :disabled="$wire.filtro_facultad === '' || $wire.filtro_tipo_programa === ''"
                                        class="form-select"
                                        id="filtro_programa"
                                        wire:model.lazy="filtro_programa"
                                    >
                                        <option value="">Seleccione el programa</option>
                                        @foreach ($programas as $item)
                                            <option value="{{ $item->id_programa }}" wire:key="{{ $item->id_programa }}">
                                                {{ $item->mencion_programa == null ? $item->nombre_programa : $item->nombre_programa . ' - ' . $item->mencion_programa }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                    <label for="filtro_ciclo" class="form-label">Ciclo</label>
                                    <select
                                        x-model="$wire.filtro_ciclo"
                                        :class="$wire.filtro_ciclo === '' ? 'text-secondary' : ''"
                                        class="form-select"
                                        id="filtro_ciclo"
                                        wire:model.lazy="filtro_ciclo"
                                    >
                                        <option value="">Seleccione el ciclo</option>
                                        @foreach ($ciclos as $item)
                                            <option value="{{ $item->id_ciclo }}" wire:key="{{ $item->id_ciclo }}">
                                                {{ $item->nombre_ciclo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                    <label for="filtro_plan_estudio" class="form-label">Plan de Estudios</label>
                                    <select
                                        x-model="$wire.filtro_plan_estudio"
                                        :class="$wire.filtro_plan_estudio === '' ? 'text-secondary' : ''"
                                        class="form-select"
                                        id="filtro_plan_estudio"
                                        wire:model.lazy="filtro_plan_estudio"
                                    >
                                        <option value="">Seleccione el plan de estudios</option>
                                        @foreach ($planes_estudio as $item)
                                            <option value="{{ $item->id_plan_estudio }}" wire:key="{{ $item->id_plan_estudio }}">
                                                {{ $item->nombre_plan_estudio }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                    <label for="filtro_proceso" class="form-label">Proceso</label>
                                    <select
                                        x-model="$wire.filtro_proceso"
                                        :class="$wire.filtro_proceso === '' ? 'text-secondary' : ''"
                                        class="form-select"
                                        id="filtro_proceso"
                                        wire:model.lazy="filtro_proceso"
                                    >
                                        <option value="">Seleccione el proceso</option>
                                        @foreach ($procesos as $item)
                                            <option value="{{ $item->id_proceso }}" wire:key="{{ $item->id_proceso }}">
                                                {{ $item->nombre_proceso }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                    <label for="filtro_en_curso" class="form-label">Estado del Curso</label>
                                    <select
                                        x-model="$wire.filtro_en_curso"
                                        :class="$wire.filtro_en_curso === '' ? 'text-secondary' : ''"
                                        class="form-select"
                                        id="filtro_en_curso"
                                        wire:model.lazy="filtro_en_curso"
                                    >
                                        <option value="">Seleccione el estado del curso</option>
                                        <option value="1" wire:key="1">
                                            En Curso
                                        </option>
                                        <option value="0" wire:key="0">
                                            Finalizado
                                        </option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start">

                                @forelse ($cursos as $item)
                                    <livewire:components.curso.card-curso :tipo_vista=$tipo_vista_curso
                                        :usuario=null :gestion_aula=$item :modo_config=true
                                        wire:key="cursos-{{ $item->id_gestion_aula }}" lazy />
                                @empty

                                    @if ($cursos->count() == 0 && $search != '')
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center align-items-center py-5">
                                                <div class="text-secondary">
                                                    No se encontraron resultados para
                                                    "<strong>{{ $search }}</strong>"
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center align-items-center py-5">
                                                <div class="text-muted">
                                                    No hay cursos aperturados
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer {{ $cursos->hasPages() ? 'py-0' : '' }}">
                            @if ($cursos->hasPages())
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $cursos->firstItem() }} - {{ $cursos->lastItem() }} de
                                        {{ $cursos->total() }} registros
                                    </div>
                                    <div class="mt-3">
                                        {{ $cursos->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center text-secondary">
                                        Mostrando {{ $cursos->firstItem() }} - {{ $cursos->lastItem() }} de
                                        {{ $cursos->total() }} registros
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- Modal de carga academica --}}
    <div wire:ignore.self class="modal fade" id="modal-carga-academica" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content {{ $estado_carga_modal ? 'cursor-progress' : '' }}">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ !$estado_carga_modal ? $titulo_modal : '***' }}
                    </h5>
                    <button type="button" class="btn-close icon-rotate-custom" data-bs-dismiss="modal"
                        aria-label="Close" wire:click="limpiar_modal"></button>
                </div>
                <form autocomplete="off" wire:submit="guardar_carga_academica">
                    <div
                        class="modal-body"
                        x-show="!$wire.estado_carga_modal"
                        x-cloak
                        x-collapse
                    >
                        <div class="row g-3">

                            <div class="col-lg-12">
                                <label for="id_curso" class="form-label required">
                                    Curso
                                </label>
                                <div wire:ignore>
                                    <select
                                        id="id_curso"
                                        class="form-select"
                                        :class="$wire.id_curso ? 'is-valid' : ''"
                                        wire:model.live="id_curso"
                                        x-init="tom_id_curso = new TomSelect($el, {
                                            create: false,
                                            placeholder: 'Seleccione el curso',
                                            sortField: { field: 'text', direction: 'asc' }
                                        })"
                                        @set-reset.window="tom_id_curso.clear()"
                                    >
                                        <option value="">Seleccione el curso</option>
                                        @foreach ($cursos_carga_academica as $item)
                                            <option value="{{ $item->id_curso }}" wire:key="cursos-{{ $item->id_curso }}">
                                                {{ $item->planEstudio->nombre_plan_estudio }} -
                                                {{ $item->ciclo->nombre_ciclo }} -
                                                {{ $item->nombre_curso }} -
                                                {{-- todo el tipo de progtrama en mayusculas --}}
                                                {{ strtoupper($item->programa->tipoPrograma->nombre_tipo_programa) }} -
                                                {{ $item->programa->nombre_programa }} {{ $item->programa->mencion_programa == null ? '' : ' - ' . $item->programa->mencion_programa }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                @error('id_curso')
                                    <span class="error text-danger fs-5">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="grupo_gestion_aula" class="form-label required">
                                    Grupo
                                </label>
                                <input type="text" name="grupo_gestion_aula"
                                    class="form-control text-uppercase @error('grupo_gestion_aula') is-invalid @elseif(strlen($grupo_gestion_aula) > 0) is-valid @enderror"
                                    id="grupo_gestion_aula" wire:model.live="grupo_gestion_aula"
                                    placeholder="Ingrese el grupo 'A' - 'B'... " />
                                @error('grupo_gestion_aula')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="id_proceso" class="form-label required">
                                    Proceso
                                </label>
                                <select
                                    class="form-control @error('id_proceso') is-invalid @elseif(strlen($id_proceso) > 0) is-valid @enderror"
                                    id="id_proceso"
                                    :class="$wire.id_proceso === '' ? 'text-secondary' : ''"
                                    wire:model.live="id_proceso"
                                >
                                    <option value="">Seleccione el proceso</option>
                                    @foreach ($procesos as $item)
                                        <option value="{{ $item->id_proceso }}" wire:key="{{ $item->id_proceso }}">
                                            {{ $item->nombre_proceso }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_proceso')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div
                                class="hr-text hr-text-center mt-6"
                                x-show="$wire.id_curso"
                                x-cloak
                                x-collapse
                            >
                                <span>
                                    Asignación de Docente y Alumnos
                                </span>
                            </div>

                            <div
                                class="col-lg-12"
                                x-show="$wire.id_curso"
                                x-cloak
                                x-collapse
                            >
                                <label for="id_docente" class="form-label">
                                    Docente
                                </label>
                                <div wire:ignore>
                                    <select
                                        id="id_docente"
                                        class="form-select @if ($errors->has('id_docente')) is-invalid @elseif($id_docente) is-valid @endif"
                                        wire:model.live="id_docente"
                                        x-init="
                                            tom_id_docente = new TomSelect($el, {
                                                create: false,
                                                placeholder: 'Seleccione el docente',
                                                sortField: { field: 'text', direction: 'asc' }
                                            })
                                        "
                                        @set-reset.window="tom_id_docente.clear()"
                                    >
                                        <option value="">Seleccione el docente</option>
                                        @foreach ($docentes as $item)
                                            <option value="{{ $item->id_usuario }}" wire:key="docentes-{{ $item->id_usuario }}">
                                                {{ $item->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                @error('id_docente')
                                    <div class="form-label text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div
                                class="col-lg-12"
                                x-show="$wire.id_curso"
                                x-cloak
                                x-collapse
                            >
                                <label for="alumnos_seleccionados" class="form-label">
                                    Alumnos
                                </label>
                                <div wire:ignore>
                                    <select
                                        id="alumnos_seleccionados"
                                        class="form-select @error('alumnos_seleccionados') is-invalid @elseif(is_array($alumnos_seleccionados) && count($alumnos_seleccionados) > 0) is-valid @enderror"
                                        wire:model.live="alumnos_seleccionados"
                                        multiple
                                        x-init="
                                            tom_alumnos_seleccionados = new TomSelect($el, {
                                                create: false,
                                                placeholder: 'Seleccione los alumnos',
                                                plugins: ['remove_button'],
                                                sortField: { field: 'text', direction: 'asc' }
                                            })
                                        "
                                        @set-reset.window="tom_alumnos_seleccionados.clear()"
                                    >
                                        <option value="">Seleccione los alumnos</option>
                                        @foreach ($alumnos ?? [] as $item)
                                            <option value="{{ $item->id_usuario }}" wire:key="alumno-{{ $item->id_usuario }}">
                                                {{ $item->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('alumnos_seleccionados')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>




                        </div>
                    </div>

                    <!-- Spinner de carga para que aparezca mientras se están cargando los datos -->
                    <template x-if="$wire.estado_carga_modal">
                        <div class="my-5 d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </template>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="limpiar_modal">
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
                            <button
                                type="submit" class="btn btn-primary w-100"
                                wire:loading.attr="disabled"
                                wire:target="guardar_carga_academica"
                                {{ $estado_carga_modal ? 'disabled cursor-progress' : '' }}
                            >
                                <span wire:loading.remove wire:target="guardar_carga_academica">
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
                                <span wire:loading wire:target="guardar_carga_academica">
                                    <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                    Guardando
                                </span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
