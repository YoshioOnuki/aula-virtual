<div>
    <div class="page-header d-print-none animate__animated animate__fadeIn animate__faster">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                            @if (session('tipo_vista') === 'alumno')
                                <li class="breadcrumb-item"><a href="{{ route('cursos') }}">Mis Cursos</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('carga-academica') }}">Carga Académica</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item"><a
                                    href="{{ route('cursos.detalle', $id_gestion_aula_usuario) }}">Detalle</a></li>
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
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row g-3">
                <div class="col-lg-7">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div class="card-body">

                            @if($gestion_aula_usuario->silabus)
                                <embed src="{{ asset('files/B9_2023_UNU_SISTEMAS_2022_T_DANY-RIOS_DAVID-TUESTA_V1.pdf') }}"
                                    class="rounded" type="application/pdf" width="100%" height="750px" />
                            @else
                                
                                <form class="dropzone border-info" id="dropzone-custom" action="./" 
                                    autocomplete="off" novalidate style="height: 750px; cursor: pointer;">
                                    <div class="fallback">
                                        <input class="form-control @error('silabus') is-invalid @enderror" 
                                        wire:model.live="silabus" accept="pdf" id="silabus" name="silabus" type="file" />
                                    </div>
                                    <div class="dz-message text-center d-flex align-items-center justify-content-center" style="height: 100%;">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="dropzone-msg-title">Subir Sílabus del Curso</h3>
                                            </div>
                                            <div class="col-12 p-10">
                                                <span class="dropzone-msg-desc">Arrastra y suelta el archivo del sílabus aquí o haz clic para seleccionar el archivo.</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @error('silabus')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card card-stacked animate__animated animate__fadeIn animate__faster">
                        <div
                            class="card-header {{ session('tipo_vista') === 'alumno' ? 'bg-teal-lt' : 'bg-yellow-lt' }}">
                            <h3 class="card-title fw-semibold">
                                Información del Curso
                            </h3>
                        </div>
                        <div class="card-body row g-3 mb-0" x-data="{ mostrar: false }">
                            <div class="d-flex flex-column gap-2">
                                <div>
                                    <strong>Programa de {{ $curso->programa->tipoPrograma->nombre_tipo_programa }}:</strong> {{ $curso->programa->nombre_programa }}
                                </div>
                                @if($curso->programa->mencion_programa)
                                    <div>
                                        <strong>Mención:</strong> {{ $curso->programa->mencion->nombre_mencion }}
                                    </div>
                                @endif
                                <div>
                                    <strong>Código del Curso:</strong> {{ $curso->codigo_curso }}
                                </div>
                                <div>
                                    <strong>Nombre del Curso:</strong> {{ $curso->nombre_curso }}
                                </div>
                                <div>
                                    <strong>Ciclo:</strong> {{ numero_a_romano($curso->ciclo->numero_ciclo) }}
                                </div>
                                <div>
                                    <strong>Plan de Estudio:</strong> {{ $curso->planEstudio->nombre_plan_estudio }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
