<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            @if ($modo_admin)
                <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
            @endif

            <div class="card card-md card-stacked animate__animated animate__fadeIn">
                <div class="card-stamp card-stamp-lg">
                    @if ($tipo_vista === 'cursos')
                    <div class="card-stamp-icon bg-teal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                    </div>
                    @elseif($tipo_vista === 'carga-academica')
                    <div class="card-stamp-icon bg-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-chalkboard">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 19h-3a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v11a1 1 0 0 1 -1 1" />
                            <path d="M11 16m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row row-cards d-flex justify-content-start">

                        @forelse ($gestion_aulas as $item)
                            <livewire:components.curso.card-curso :tipo_vista=$tipo_vista
                                :usuario=$usuario :gestion_aula=$item :ruta_vista=$ruta_vista
                                wire:key="curso-{{ $item->id_gestion_aula_usuario }}" lazy />
                        @empty
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="text-muted">
                                        @if ($tipo_vista === 'cursos')
                                            No tiene cursos asignados.
                                        @elseif($tipo_vista === 'carga-academica')
                                            No tiene carga académica.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
