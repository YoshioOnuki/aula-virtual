<div>

    @livewire('components.page-header', [
        'titulo_pasos' => $titulo_page_header,
        'titulo' => $titulo_page_header,
        'links_array' => $links_page_header,
        'regresar' => $regresar_page_header
    ])

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
                @livewire('components.info-alumnos-docentes', [
                    'usuario' => $usuario,
                    'tipo_vista' => $tipo_vista
                ])
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-stamp card-stamp-lg">
                            @if ($tipo_vista === 'cursos')
                                <div class="card-stamp-icon bg-teal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 5h8" />
                                        <path d="M13 9h5" />
                                        <path d="M13 15h8" />
                                        <path d="M13 19h5" />
                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    </svg>
                                </div>
                            @elseif($tipo_vista === 'carga-academica')
                                <div class="card-stamp-icon bg-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 5h8" />
                                        <path d="M13 9h5" />
                                        <path d="M13 15h8" />
                                        <path d="M13 19h5" />
                                        <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                        <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start" wire:init="load_trabajos_llamar">

                                @if ($tipo_vista === 'carga-academica' && $usuario->esRolGestionAula('DOCENTE', $id_gestion_aula_usuario))
                                    <div class="col-lg-12">
                                        <div class="card hover-shadow-sm cursor-pointer">
                                            <div class="card-body text-secondary">
                                                <div class="row g-2">
                                                    <div
                                                        class="col-12 d-flex justify-content-center align-items-center mt-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-library-plus svg-medium">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                            <path
                                                                d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                                            <path d="M11 10h6" />
                                                            <path d="M14 7v6" />
                                                        </svg>
                                                    </div>
                                                    <div
                                                        class="col-12 d-flex justify-content-center align-items-center">
                                                        <span class="text-muted fs-5">
                                                            Agregar trabajo académico
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($cargando_trabajos)
                                    <div class="col-12">
                                        <div class="card placeholder-glow">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <div class="placeholder col-6" style="height: 1.5rem;"></div>
                                                    <div class="placeholder"></div>
                                                </div>
                                                <div>
                                                    <div class="col-12"></div>
                                                    <div class="placeholder placeholder-xs col-4 bg-secondary">
                                                    </div>
                                                    <div class="col-12"></div>
                                                    <div class="placeholder placeholder-xs col-4 bg-secondary">
                                                    </div>
                                                </div>
                                                <div class=" d-flex justify-content-end">
                                                    <a href="#" tabindex="-1"
                                                        class="btn btn-secondary disabled placeholder col-sm-2 col-lg-3 col-xl-2 d-none d-md-inline-block me-2"
                                                        aria-hidden="true"></a>
                                                    <a href="#" tabindex="-1"
                                                        class="btn btn-secondary disabled placeholder col-1 d-md-none btn-icon me-2"
                                                        aria-hidden="true"></a>

                                                    <a href="#" tabindex="-1"
                                                        class="btn btn-primary disabled placeholder col-sm-3 col-lg-4 col-xl-2 d-none d-md-inline-block"
                                                        aria-hidden="true"></a>
                                                    <a href="#" tabindex="-1"
                                                        class="btn btn-primary disabled placeholder col-1 d-md-none btn-icon"
                                                        aria-hidden="true"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @forelse ($trabajos_academicos as $item)
                                        <div class="col-12">

                                            {{-- Card trabajo --}}

                                            {{ $item->titulo_trabajo_academico }}

                                            @livewire('components.card-trabajo-academico', [
                                                // 'trabajo_academico' => $item,
                                                // 'tipo_vista' => $tipo_vista
                                            ])

                                        </div>
                                    @empty
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="text-muted">
                                                    No hay trabajos académicos registrados
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    @livewire('components.datos-curso', [
                        'id_gestion_aula_usuario' => $id_gestion_aula_usuario,
                        'tipo_vista' => $tipo_vista
                    ])
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
    {{-- /* =============== FUNCIONES PARA PRUEBAS DE CARGAS - SIMULACION DE CARGAS =============== */ --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
        // document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('load_trabajos_evento', () => {
                setTimeout(() => {
                    @this.call('load_trabajos')
                }, 500);
            });
        });
    </script>
@endpush
