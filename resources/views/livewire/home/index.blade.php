<div>

    @livewire('components.navegacion.page-header', [
    'titulo_pasos' => 'Inicio',
    'titulo' => 'Aula Virtual',
    'links_array' => [],
    'regresar' => []
    ])

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                    <div class="card card-stacked animate__animated animate__fadeIn  mb-3">
                        <div class="card-header d-flex justify-content-center align-items-center"
                        style=" background:rgb(12, 166, 120);">
                            <h3 class="card-title text-white fw-bold fs-2">
                                @if ($usuario->esRol('ALUMNO') && $usuario->esRol('DOCENTE'))
                                    Mis Cursos / Carga Académica
                                @else
                                    @if($usuario->esRol('DOCENTE'))
                                        Carga Académica
                                    @elseif($usuario->esRol('ALUMNO'))
                                        Mis Cursos
                                    @else
                                        N/A
                                    @endif
                                @endif
                            </h3>
                        </div>
                        <div class="card-body overflow-auto">
                            <div class="row row-cards d-flex justify-content-start">

                                @if (!$usuario->esRol('ADMINISTRADOR'))
                                    @forelse ($cursos as $item)
                                        <livewire:components.curso.card-curso :tipo_vista=$tipo_vista_curso
                                            :usuario=$usuario :gestion_aula=$item
                                            wire:key="cursos-{{ $item->id_gestion_aula }}" lazy />
                                    @empty
                                        @if ($usuario->esRol('ALUMNO') && $usuario->esRol('DOCENTE') && $carga_academica->isEmpty())
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="text-muted mt-3">
                                                        No tiene cursos ni carga académica asignada.
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($usuario->esRol('ALUMNO')  && !$usuario->esRol('DOCENTE'))
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="text-muted mt-3">
                                                        No tiene cursos asignados.
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforelse

                                    @forelse ($carga_academica as $item)
                                        <livewire:components.curso.card-curso :tipo_vista=$tipo_vista_carga
                                            :usuario=$usuario :gestion_aula=$item
                                            wire:key="cargas-{{ $item->id_gestion_aula }}" lazy />
                                    @empty
                                        @if ($usuario->esRol('DOCENTE') && !$usuario->esRol('ALUMNO'))
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <div class="text-muted mt-3">
                                                        No tiene carga académica asignada.
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforelse

                                    @foreach ($cursos_finalizados ?? [] as $item)
                                        <livewire:components.curso.card-curso :tipo_vista=$tipo_vista_curso
                                            :usuario=$usuario :gestion_aula=$item
                                            wire:key="curso-finalizado-{{ $item->id_gestion_aula }}" lazy />
                                    @endforeach
                                    @foreach ($carga_academica_finalizada ?? [] as $item)
                                        <livewire:components.curso.card-curso :tipo_vista=$tipo_vista_carga
                                            :usuario=$usuario :gestion_aula=$item
                                            wire:key="carga-finalizada-{{ $item->id_gestion_aula }}" lazy />
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card card-stacked mb-3 animate__animated animate__fadeIn">
                        <div class="card-header d-flex justify-content-center align-items-center"
                            style="background: rgb(12, 166, 120);">
                            <h3 class="card-title text-white fw-bold fs-2">Autoridades</h3>
                        </div>
                        <div class="card-body overflow-auto" style="height: 610px;">
                            <div
                                class="d-flex flex-column align-items-cent justify-content-center gap-5 animate__animated animate__fadeInUpBig animate__faster">
                                @forelse($autoridades_model as $item)
                                <div class="form-selectgroup-label-content d-flex align-items-start">
                                    <img src="{{ asset($item->mostrar_foto ?? '/media/avatar-none.webp') }}"
                                        alt="avatar" class="avatar me-3 rounded avatar-static">
                                    <div>
                                        <div class="fs-3">{{ $item->nombre_autoridad }}</div>
                                        <div class="text-muted fs-4">
                                            {{ $item->cargo->nombre_cargo }}
                                            {{ $item->facultad ? 'de la ' . $item->facultad->nombre_facultad : '' }}
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="form-selectgroup-label-content d-flex align-items-start">
                                    <div class="fs-3 text-center">
                                        No se encontraron Autoridades.
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



