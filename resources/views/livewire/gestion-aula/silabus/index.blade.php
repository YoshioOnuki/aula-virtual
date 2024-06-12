<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>

                            @if (session('tipo_vista') === 'alumno')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('cursos') }}">Mis Cursos</a>
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ route('carga-academica') }}">Carga Académica</a>
                                </li>
                            @endif

                            @if (session('tipo_vista') === 'alumno')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}">Detalle</a>
                                </li>
                            @endif

                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">
                                    Silabus
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title text-uppercase">
                        Silabus
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if (session('tipo_vista') === 'alumno')
                        <a href="{{ route('cursos.detalle', encriptar($id_gestion_aula_usuario)) }}" class="btn btn-secondary d-none d-md-inline-block">
                        @else
                        <a href="{{ route('carga-academica.detalle', encriptar($id_gestion_aula_usuario)) }}" class="btn btn-secondary d-none d-md-inline-block">
                        @endif
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                            Regresar
                        </a>
                        <a href="" class="btn btn-secondary d-md-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">

                <div class="col-lg-8">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body" style="{{ $gestion_aula_usuario->silabu ? '' : 'height: 750px' }}">
                            @if ($gestion_aula_usuario->silabus)
                                <embed src="{{ asset('files/silabus.pdf') }}" class="rounded" type="application/pdf"
                                    width="100%" height="750px" />
                            @else
                                <div class="alert alert-yellow bg-white-lt hover-shadow-sm" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 9v4"></path>
                                                <path
                                                    d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                                </path>
                                                <path d="M12 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">El sílabus no está disponible en este momento.</h4>
                                            <div class="text-secondary">
                                                @if (session('tipo_vista') === 'alumno')
                                                    Por favor, verifica más tarde o contacta con el docente para más
                                                    información.
                                                @else
                                                    Por favor, sube el sílabus del curso para que los alumnos puedan
                                                    acceder a él.
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div
                            class="card-header {{ session('tipo_vista') === 'alumno' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                            <h3 class="card-title fw-semibold">
                                Información del Curso
                            </h3>
                        </div>
                        <div class="card-body row g-3 mb-0">
                            <div class="d-flex flex-column gap-2">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <strong>Programa de
                                                    {{ $curso->programa->tipoPrograma->nombre_tipo_programa }}
                                                </strong>
                                            </div>
                                            <div class="col-12">
                                                {{ $curso->programa->nombre_programa }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($curso->programa->mencion_programa)
                                        <div class="col-12">
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <strong>Mención:</strong>
                                                </div>
                                                <div class="col-12">
                                                    {{ $curso->programa->mencion->nombre_mencion }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <strong>Código del Curso</strong>
                                            </div>
                                            <div class="col-12">
                                                {{ $curso->codigo_curso }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <strong>Nombre del Curso</strong>
                                            </div>
                                            <div class="col-12">
                                                {{ $curso->nombre_curso }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 d-flex justify-content-start">
                                        <div class="row g-2">
                                            <div class="col-12 d-flex justify-content-center">
                                                <strong>Ciclo</strong>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center">
                                                {{ numero_a_romano($curso->ciclo->numero_ciclo) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 d-flex justify-content-center">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <strong>Créditos</strong>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center">
                                                {{ $curso->creditos_curso }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 d-flex justify-content-end">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <strong>Horas</strong>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center">
                                                {{ $curso->horas_lectivas_curso }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <strong>Plan de Estudio</strong>
                                            </div>
                                            <div class="col-12">
                                                {{ $curso->planEstudio->nombre_plan_estudio }}
                                            </div>
                                        </div>
                                    </div>

                                    @if (session('tipo_vista') === 'docente')
                                        <hr class="mt-5 mb-2 hide-theme-dark">
                                        <hr class="mt-5 mb-2 hide-theme-light text-white">

                                        <div class="col-12">
                                            <label for="silabus" class="form-label required">
                                                Subir Sílabus
                                            </label>
                                            <input type="file" class="form-control @error('silabus') is-invalid @enderror"
                                                id="silabus" wire:model.live="silabus" accept="pdf" />
                                            @error('silabus')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <a class="btn btn-primary w-100 mt-3" style="cursor: pointer;"
                                                wire:click="guardar_silabus">
                                                Guardar Sílabus
                                            </a>
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
