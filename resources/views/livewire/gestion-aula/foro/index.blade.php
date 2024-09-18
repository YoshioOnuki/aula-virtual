<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header lazy />

    <div class="page-body">
        <div class="container-xl">

            @if($modo_admin)
                <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
            @endif

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card card-md card-stacked animate__animated animate__fadeIn">
                        <div class="card-stamp card-stamp-lg">
                            @if ($tipo_vista === 'cursos')
                            <div class="card-stamp-icon bg-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 5h8" />
                                    <path d="M13 9h5" />
                                    <path d="M13 15h8" />
                                    <path d="M13 19h5" />
                                    <path
                                        d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    <path
                                        d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                </svg>
                            </div>
                            @elseif($tipo_vista === 'carga-academica')
                            <div class="card-stamp-icon bg-orange">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-list-details">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 5h8" />
                                    <path d="M13 9h5" />
                                    <path d="M13 15h8" />
                                    <path d="M13 19h5" />
                                    <path
                                        d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                    <path
                                        d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row row-cards d-flex justify-content-start">

                                @if ($tipo_vista === 'carga-academica' && $usuario->esRolGestionAula('DOCENTE',
                                $id_gestion_aula_usuario))
                                <div class="col-lg-12">
                                    <a class="card card-link cursor-pointer" wire:click="abrir_modal_agregar_foro()">
                                        <div class="card-body text-secondary">
                                            <div class="row g-2">
                                                <div
                                                    class="col-12 d-flex justify-content-center align-items-center mt-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                                <div class="col-12 d-flex justify-content-center align-items-center">
                                                    <span class="text-muted fs-5">
                                                        Agregar Foro
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endif

                            @forelse($foros as $item)
                                <livewire:components.foro.card-foro :tipo_vista=$tipo_vista :usuario=$usuario
                                    :id_gestion_aula_usuario=$id_gestion_aula_usuario :foro=$item
                                    wire:key="{{ $item->id_trabajo_foro }}" lazy />
                            @empty
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="text-muted">
                                            No hay Foros registrados
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <livewire:components.curso.datos-curso :id_gestion_aula_usuario=$id_gestion_aula_usuario :ruta_pagina=$ruta_pagina
                        :tipo_vista=$tipo_vista lazy />
                </div>

            </div>
        </div>
    </div>

</div>
