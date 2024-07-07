<div>

    <div class="container-tight py-4 mobile-message mt-6 animate__animated animate__fadeIn animate__faster">
        <div class="empty">
            <div class="empty-img"><img src="/assets/static/illustrations/undraw_posting_photo_v65l.svg" height="128" alt="">
            </div>
            <p class="empty-title">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">
                        Acceso Restringido
                    </font>
                </font>
            </p>
            <p class="empty-subtitle text-secondary">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">
                        Esta vista no está disponible en dispositivos móviles. Por favor, accede desde una laptop o PC.
                    </font>
                </font>
            </p>
            <div class="empty-action">
                <a href="./." class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l14 0"></path>
                        <path d="M5 12l6 6"></path>
                        <path d="M5 12l6 -6"></path>
                    </svg>
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;">
                            Regresar
                        </font>
                    </font>
                </a>
            </div>
        </div>
    </div>

    <div class="asistencias">

        @livewire('components.page-header', [
            'titulo_pasos' => $titulo_page_header,
            'titulo' => $titulo_page_header,
            'links_array' => $links_page_header,
            'regresar' => $regresar_page_header
        ])

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
</div>

@push('scripts')
    <script src="{{ asset('js/mobile-detect/mobile-detect.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const asistencias = document.querySelector('.asistencias');
            const mobileMessage = document.querySelector('.mobile-message');
            const md = new MobileDetect(window.navigator.userAgent);

            function isMobileDevice() {
                return md.mobile() !== null;
            }

            function toggleContent() {
                const isMobile = isMobileDevice();
                const isNarrowScreen = window.innerWidth < 768;
                asistencias.style.display = (isMobile || isNarrowScreen) ? 'none' : 'block';
                mobileMessage.style.display = (isMobile || isNarrowScreen) ? 'block' : 'none';
            }

            toggleContent();
            window.addEventListener("resize", toggleContent);
        });
    </script>
@endpush
