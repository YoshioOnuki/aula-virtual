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
                            <div class="d-flex align-items-center justify-content-between w-100">
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
