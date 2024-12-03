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

                                    <div class="custom-dropdown position-relative me-3">
                                        <button
                                            id="dropdownButton"
                                            class="btn btn-outline-azure d-flex justify-content-between align-items-center custom-dropdown-toggle border-azure"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-filter">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M20 3h-16a1 1 0 0 0 -1 1v2.227l.008 .223a3 3 0 0 0 .772 1.795l4.22 4.641v8.114a1 1 0 0 0 1.316 .949l6 -2l.108 -.043a1 1 0 0 0 .576 -.906v-6.586l4.121 -4.12a3 3 0 0 0 .879 -2.123v-2.171a1 1 0 0 0 -1 -1z" />
                                            </svg>
                                            Filtro
                                        </button>

                                        <div
                                            id="dropdownMenu"
                                            class="dropdown-menu p-3 shadow"
                                            style="width: 300px;"
                                        >

                                            <div>
                                                <label for="cbo_tipo_programa" class="form-label">Tipo Programa</label>
                                                <select
                                                    x-model="$wire.cbo_tipo_programa"
                                                    :class="$wire.cbo_tipo_programa === '' ? 'text-secondary' : ''"
                                                    class="form-select"
                                                    id="cbo_tipo_programa"
                                                    wire:model="cbo_tipo_programa"
                                                >
                                                    <option value="">Seleccione el tipo de programa</option>
                                                    @foreach ($tipo_programas as $item)
                                                        <option value="{{ $item->id_tipo_programa }}" wire:key="{{ $item->id_tipo_programa }}">
                                                            {{ $item->nombre_tipo_programa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mt-3" wire:ignore>
                                                <label for="cbo_facultad" class="form-label">
                                                    <template x-if="$wire.cbo_programa !== ''">
                                                        <span class="text-secondary">
                                                            Facultad
                                                        </span>
                                                    </template>
                                                    <template x-if="$wire.cbo_programa === ''">
                                                        <span class="">
                                                            Facultad
                                                        </span>
                                                    </template>

                                                </label>
                                                <select
                                                    x-model="$wire.cbo_facultad"
                                                    :class="$wire.cbo_facultad === '' ? 'text-secondary' : ''"
                                                    :disabled="$wire.cbo_programa !== ''"
                                                    class="form-select "
                                                    id="cbo_facultad"
                                                    wire:model="cbo_facultad"
                                                >
                                                    <option value="">Seleccione la facultad</option>
                                                    @foreach ($facultades as $item)
                                                        <option value="{{ $item->id_facultad }}" wire:key="{{ $item->id_facultad }}">
                                                            {{ $item->nombre_facultad }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="cbo_programa" class="form-label">
                                                    <template x-if="$wire.cbo_facultad !== ''">
                                                        <span class="text-secondary">
                                                            Programa
                                                        </span>
                                                    </template>
                                                    <template x-if="$wire.cbo_facultad === ''">
                                                        <span class="">
                                                            Programa
                                                        </span>
                                                    </template>
                                                </label>
                                                <select
                                                    x-model="$wire.cbo_programa"
                                                    :class="$wire.cbo_programa === '' ? 'text-secondary' : ''"
                                                    :disabled="$wire.cbo_facultad !== ''"
                                                    class="form-select"
                                                    id="cbo_programa"
                                                    wire:model="cbo_programa"
                                                >
                                                    <option value="">Seleccione el programa</option>
                                                    @foreach ($programas as $item)
                                                        <option value="{{ $item->id_programa }}" wire:key="{{ $item->id_programa }}">
                                                            {{ $item->mencion_programa == null ? $item->nombre_programa : $item->nombre_programa . ' - ' . $item->mencion_programa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="cbo_ciclo" class="form-label">Ciclo</label>
                                                <select
                                                    x-model="$wire.cbo_ciclo"
                                                    :class="$wire.cbo_ciclo === '' ? 'text-secondary' : ''"
                                                    class="form-select"
                                                    id="cbo_ciclo"
                                                    wire:model="cbo_ciclo"
                                                >
                                                    <option value="">Seleccione el ciclo</option>
                                                    @foreach ($ciclos as $item)
                                                        <option value="{{ $item->id_ciclo }}" wire:key="{{ $item->id_ciclo }}">
                                                            {{ $item->nombre_ciclo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="cbo_plan_estudio" class="form-label">Plan de Estudios</label>
                                                <select
                                                    x-model="$wire.cbo_plan_estudio"
                                                    :class="$wire.cbo_plan_estudio === '' ? 'text-secondary' : ''"
                                                    class="form-select"
                                                    id="cbo_plan_estudio"
                                                    wire:model="cbo_plan_estudio"
                                                >
                                                    <option value="">Seleccione el plan de estudios</option>
                                                    @foreach ($planes_estudio as $item)
                                                        <option value="{{ $item->id_plan_estudio }}" wire:key="{{ $item->id_plan_estudio }}">
                                                            {{ $item->nombre_plan_estudio }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="cbo_proceso" class="form-label">Proceso</label>
                                                <select
                                                    x-model="$wire.cbo_proceso"
                                                    :class="$wire.cbo_proceso === '' ? 'text-secondary' : ''"
                                                    class="form-select"
                                                    id="cbo_proceso"
                                                    wire:model="cbo_proceso"
                                                >
                                                    <option value="">Seleccione el proceso</option>
                                                    @foreach ($procesos as $item)
                                                        <option value="{{ $item->id_proceso }}" wire:key="{{ $item->id_proceso }}">
                                                            {{ $item->nombre_proceso }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="cbo_en_curso" class="form-label">Estado del Curso</label>
                                                <select
                                                    x-model="$wire.cbo_en_curso"
                                                    :class="$wire.cbo_en_curso === '' ? 'text-secondary' : ''"
                                                    class="form-select"
                                                    id="cbo_en_curso"
                                                    wire:model="cbo_en_curso"
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

                                            {{-- Botones --}}
                                            <div class="mt-3">
                                                <div class="d-flex justify-content-between">

                                                    <button
                                                        type="submit" class="btn btn-outline-secondary"
                                                        wire:loading.attr="disabled"
                                                        wire:target="limpiar_filtros"
                                                        wire:click="limpiar_filtros"
                                                    >
                                                        <span wire:loading.remove
                                                            wire:target="limpiar_filtros">
                                                            Limpiar
                                                        </span>
                                                        <span wire:loading wire:target="limpiar_filtros">
                                                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                                            Limpiando
                                                        </span>
                                                    </button>

                                                    <button
                                                        type="submit" class="btn btn-azure"
                                                        wire:loading.attr="disabled"
                                                        wire:target="filtrar"
                                                        wire:click="filtrar"
                                                    >
                                                        <span wire:loading.remove
                                                            wire:target="filtrar">
                                                            Filtrar
                                                        </span>
                                                        <span wire:loading wire:target="filtrar">
                                                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                                            Cargando
                                                        </span>
                                                    </button>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="text-secondary">
                                        Mostrar
                                        <div class="mx-2 d-inline-block">
                                            <select wire:model.live="mostrar_paginate" class="form-select">
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
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
                                        <a class="btn btn-primary d-none d-lg-inline-block"
                                            href="">
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
                                        <a class="btn btn-primary d-lg-none btn-icon"
                                            href="">
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

                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start">

                                @forelse ($cursos as $item)
                                    <livewire:components.curso.card-curso :tipo_vista=$tipo_vista_curso
                                        :usuario=null :gestion_aula=$item
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

</div>

@script

<script>
document.getElementById('dropdownButton').addEventListener('click', function (event) {
    event.stopPropagation(); // Evita cerrar al hacer clic en el botón
    document.getElementById('dropdownMenu').classList.toggle('show');

    // Cambia la clase 'active' al botón
    this.classList.toggle('active');
});

// Evita que el dropdown se cierre al interactuar con elementos internos
document.getElementById('dropdownMenu').addEventListener('click', function (event) {
    event.stopPropagation(); // No cierra el dropdown si se hace clic dentro de él
});

// Cierra el dropdown si se hace clic fuera y elimina la clase activa
document.addEventListener('click', function () {
    document.getElementById('dropdownMenu').classList.remove('show');
    document.getElementById('dropdownButton').classList.remove('active');
});
</script>

@endscript
