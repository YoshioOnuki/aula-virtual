<div>

    @livewire('components.navegacion.page-header', [
    'titulo_pasos' => 'Dashboard',
    'titulo' => 'Aula Virtual',
    'links_array' => [],
    'regresar' => []
    ])

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-books">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                            <path d="M9 4m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                            <path d="M5 8h4" />
                                            <path d="M9 16h4" />
                                            <path
                                                d="M13.803 4.56l2.184 -.53c.562 -.135 1.133 .19 1.282 .732l3.695 13.418a1.02 1.02 0 0 1 -.634 1.219l-.133 .041l-2.184 .53c-.562 .135 -1.133 -.19 -1.282 -.732l-3.695 -13.418a1.02 1.02 0 0 1 .634 -1.219l.133 -.041z" />
                                            <path d="M14 9l4 -1" />
                                            <path d="M16 16l3.923 -.98" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $cantidad_cursos }} Aulas
                                    </div>
                                    <div class="text-muted">
                                        {{ $cantidad_cursos_en_curso }} en curso
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-azure text-white avatar d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $cantidad_usuarios }} Usuarios
                                    </div>
                                    <div class="text-muted">
                                        {{ $cantidad_usuarios_nuevos }} nuevos este año
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-teal text-white avatar d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                            <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $cantidad_alumnos }} Alumnos
                                    </div>
                                    <div class="text-muted">
                                        {{ $cantidad_alumnos_nuevos }} nuevos este año
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-orange text-white avatar d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-chalkboard">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1" />
                                            <path d="M11 16m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">
                                        {{ $cantidad_docentes }} Docentes
                                    </div>
                                    <div class="text-muted">
                                        {{ $cantidad_docentes_nuevos }} nuevos este año
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-3">
                                Almacenamiento utilizado: <strong>{{ $almacenamiento_total }}</strong>
                            </p>
                            <div class="progress progress-separated mb-3" style="height: 15px;">
                                <div class="progress-bar bg-blue" role="progressbar" style="width: {{ $porcentaje_trabajos_academicos }}%"
                                    aria-label="Trabajos académicos">
                                    <span class="fs-6 fw-bold">
                                        {{ $almacenamiento_trabajos_academicos }}
                                    </span>
                                </div>
                                <div class="progress-bar bg-teal" role="progressbar" style="width: {{ $porcentaje_silabus }}%"
                                    aria-label="Silabus">
                                    <span class="fs-6 fw-bold">
                                        {{ $almacenamiento_silabus }}
                                    </span>
                                </div>
                                <div class="progress-bar bg-pink" role="progressbar" style="width: {{ $porcentaje_recursos }}%"
                                    aria-label="Recursos">
                                    <span class="fs-6 fw-bold">
                                        {{ $almacenamiento_recursos }}
                                    </span>
                                </div>
                                <div class="progress-bar bg-purple" role="progressbar" style="width: {{ $porcentaje_foros }}%"
                                    aria-label="Foros">
                                    <span class="fs-6 fw-bold">
                                        {{ $almacenamiento_foros }}
                                    </span>
                                </div>
                                <div class="progress-bar bg-azure" role="progressbar" style="width: {{ $porcentaje_orientaciones }}%"
                                    aria-label="Orientaciones">
                                    <span class="fs-6 fw-bold">
                                        {{ $almacenamiento_orientaciones }}
                                    </span>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-auto px-2">
                                    <span class="legend me-1 bg-blue"></span>
                                    <span>Trabajos académicos</span>
                                    <span class="d-none d-md-inline d-lg-inline d-xxl-inline ms-1 text-muted fs-5 ">
                                        {{ $porcentaje_trabajos_academicos }}%
                                    </span>
                                </div>
                                <div class="col-auto px-2">
                                    <span class="legend me-1 bg-teal"></span>
                                    <span>Silabus</span>
                                    <span class="d-none d-md-inline d-lg-inline d-xxl-inline ms-1 text-muted fs-5 ">
                                        {{ $porcentaje_silabus }}%
                                    </span>
                                </div>
                                <div class="col-auto px-2">
                                    <span class="legend me-1 bg-pink"></span>
                                    <span>Recursos</span>
                                    <span class="d-none d-md-inline d-lg-inline d-xxl-inline ms-1 text-muted fs-5">
                                        {{ $porcentaje_recursos }}%
                                    </span>
                                </div>
                                <div class="col-auto px-2">
                                    <span class="legend me-1 bg-purple"></span>
                                    <span>Foros</span>
                                    <span class="d-none d-md-inline d-lg-inline d-xxl-inline ms-1 text-muted fs-5">
                                        {{ $porcentaje_foros }}%
                                    </span>
                                </div>
                                <div class="col-auto ps-2">
                                    <span class="legend me-1 bg-azure"></span>
                                    <span>Orientaciones</span>
                                    <span class="d-none d-md-inline d-lg-inline d-xxl-inline ms-1 text-muted fs-5">
                                        {{ $porcentaje_orientaciones }}%
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card card-stacked animate__animated animate__fadeIn">
                        <div class="card-stamp card-stamp-lg">
                            {{-- Icono de la tarjeta (Lado derecho de la esquina superior) --}}
                            <div class="card-stamp-icon bg-tabler">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-link">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 15l6 -6" />
                                    <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                    <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                                </svg>
                            </div>
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-center w-100">
                                <h3 class="card-title mb-0">
                                    Páginas más visitadas
                                </h3>
                                <div class="ms-auto">
                                    <a wire:click="estado_acceso_auditoria()"
                                        class="text-decoration-none cursor-pointer hover-shadow-sm">
                                        <span class="badge bg-{{ config('settings.acceso_auditoria') ? 'teal' : 'red' }}-lt status-{{ config('settings.acceso_auditoria') ? 'teal' : 'red' }} px-3 py-2 fs-4">
                                            <span class="status-dot status-dot-animated me-2"></span>
                                            {{ config('settings.acceso_auditoria') ? 'Desactivar' : 'Activar' }}
                                            auditoría de accesos
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate_visitas" class="form-select">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="text-secondary row">
                                    <div class="col-lg-12">
                                        <div class="d-inline-block w-100">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search_visitas"
                                                aria-label="Buscar actividades" placeholder="Buscar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-table table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Nombre de la página</th>
                                        <th class="col-1">Visitas</th>
                                        <th class="col-1">Acciones</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>
                                        https://aula-virtual.test/inicio
                                    </td>
                                    <td class="text-muted">
                                        4,896
                                    </td>
                                    <td>
                                        <div x-data="{ link: '/' }">
                                            <div x-data="{
                                                link: '/',
                                                handleClick() {
                                                    if (!this.link) {
                                                        this.$dispatch('toast-basico', {
                                                            mensaje: 'El link no está disponible',
                                                            type: 'error'
                                                        });
                                                    } else {
                                                        window.open(this.link, '_blank');
                                                    }
                                                }
                                            }">
                                            <button type="button" class="btn btn-outline-primary"
                                                @click="handleClick">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-link">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M9 15l6 -6" />
                                                    <path
                                                        d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                                    <path
                                                        d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                                                </svg>
                                                Ir a la página
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-stacked animate__animated animate__fadeIn">

                        <div class="card-stamp card-stamp-lg">
                            {{-- Icono de la tarjeta (Lado derecho de la esquina superior) --}}
                            <div class="card-stamp-icon bg-twitter">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-activity-heartbeat">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12h4.5l1.5 -6l4 12l2 -9l1.5 3h4.5" />
                                </svg>
                            </div>
                        </div>

                        <div class="card-body border-bottom py-3">
                            <h3 class="card-title">
                                Últimas actividades
                            </h3>
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="text-secondary">
                                    Mostrar
                                    <div class="mx-2 d-inline-block">
                                        <select wire:model.live="mostrar_paginate_actividades" class="form-select">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    entradas
                                </div>
                                <div class="text-secondary row">
                                    <div class="col-lg-12">
                                        <div class="d-inline-block w-100">
                                            <input type="text" class="form-control"
                                                wire:model.live.debounce.500ms="search_actividades"
                                                aria-label="Buscar actividades" placeholder="Buscar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th class="col-1">Acción</th>
                                        <th class="col-1">Tabla</th>
                                        <th class="col-1">SO</th>
                                        <th class="col-2">URL</th>
                                        <th class="col-1">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td>
                                            Aurelio Yoshio Onuki Navas
                                        </td>
                                        <td>
                                            Actualizar
                                        </td>
                                        <td>
                                            Webgrafia
                                        </td>
                                        <td>
                                            Windows
                                        </td>
                                        <td>
                                            {{ Str::limit('https://aula-virtual.test/gestion-aula/docente/Zew7KwPM/carga-academica/lMylOwk6/webgrafia', 40) }}
                                        </td>
                                        <td>
                                            {{ format_fecha_horas(now()) }}
                                        </td>
                                    </tr>
                                    @endfor

                                    {{-- @forelse ($webgrafias as $item)
                                        <tr>
                                            <td>
                                                <span class="text-secondary">{{ $i++ }}</span>
                                            </td>
                                            <td>
                                                {{ $item->descripcion_webgrafia }}
                                            </td>
                                            <td>
                                                {{ $item->link_webgrafia }}
                                            </td>
                                            <td>
                                                @if ($es_docente && $tipo_vista === 'carga-academica')
                                                    <div class="btn-list flex-nowrap">
                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle align-text-top"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Acciones
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" style="cursor: pointer;"
                                                                    wire:click="redirect_link({{ $item->id_webgrafia }})">
                                                                    Ir al link
                                                                </a>
                                                                <a class="dropdown-item" style="cursor: pointer;"
                                                                    wire:click="abrir_modal_webgrafia_editar({{ $item->id_webgrafia }})"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal-webgrafia">
                                                                    Editar
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div x-data="{ link: '{{ $item->link_webgrafia }}' }">
                                                        <div x-data="{
                                                            link: '{{ $item->link_webgrafia ? $item->link_webgrafia : '' }}',
                                                            handleClick() {
                                                                if (!this.link) {
                                                                    this.$dispatch('toast-basico', {
                                                                        mensaje: 'El link de la webgrafía no está disponible',
                                                                        type: 'error'
                                                                    });
                                                                } else {
                                                                    window.open(this.link, '_blank');
                                                                }
                                                            }
                                                        }">
                                                        <button type="button" class="btn btn-outline-primary"
                                                            @click="handleClick">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-link">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M9 15l6 -6" />
                                                                <path
                                                                    d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                                                <path
                                                                    d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                                                            </svg>
                                                            Ir al link
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        @if ($webgrafias->count() == 0 && $search != '')
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
                                                            No hay webgrafias registradas
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="card-footer {{ $webgrafias->hasPages() ? 'py-0' : '' }}">
                            @if ($webgrafias->hasPages())
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $webgrafias->firstItem() }} - {{ $webgrafias->lastItem() }} de
                                    {{ $webgrafias->total() }} registros
                                </div>
                                <div class="mt-3">
                                    {{ $webgrafias->links() }}
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center text-secondary">
                                    Mostrando {{ $webgrafias->firstItem() }} - {{ $webgrafias->lastItem() }} de
                                    {{ $webgrafias->total() }} registros
                                </div>
                            </div>
                            @endif
                        </div> --}}

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:navigated', () => {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-tasks-overview'), {
            chart: {
                type: "bar",
                fontFamily: 'inherit',
                height: 320,
                parentHeightOffset: 0,
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                }
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: "A",
                data: [44, 32, 48, 72, 60, 16, 44, 32, 78, 50, 68, 34, 26, 48, 72, 60, 84, 64, 74, 52, 62, 50, 32, 22]
            }],
            tooltip: {
                theme: 'dark'
            },
            grid: {
                padding: {
                    top: -20,
                    right: 0,
                    left: -4,
                    bottom: -4
                },
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false,
                },
                categories: ['Sprint 1', 'Sprint 2', 'Sprint 3', 'Sprint 4', 'Sprint 5', 'Sprint 6', 'Sprint 7', 'Sprint 8', 'Sprint 9', 'Sprint 10', 'Sprint 11', 'Sprint 12', 'Sprint 13', 'Sprint 14', 'Sprint 15', 'Sprint 16', 'Sprint 17', 'Sprint 18', 'Sprint 19', 'Sprint 20', 'Sprint 21', 'Sprint 22', 'Sprint 23', 'Sprint 24'],
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            colors: [tabler.getColor("primary")],
            legend: {
                show: false,
            },
        })).render();
    });
</script>
@endscript
