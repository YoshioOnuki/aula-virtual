<div>

    <livewire:components.navegacion.page-header :titulo_pasos=$titulo_page_header :titulo=$titulo_page_header
        :links_array=$links_page_header :regresar=$regresar_page_header />

    <div class="page-body">
        <div class="container-xl">

            <div class="row row-cards d-flex justify-content-between">
                <div class="col-lg-2 d-none d-lg-block">
                    <livewire:components.navegacion.navegacion-curso :tipo_vista=$tipo_vista
                        :id_usuario=$id_usuario_hash :id_curso=$id_gestion_aula_hash />
                </div>

                <div class="col-lg-10 col-md-12 col-sm-12">
                    @if($modo_admin)
                    <livewire:components.curso.admin-info-usuario :usuario=$usuario :tipo_vista=$tipo_vista lazy />
                    @endif

                    <div class="row g-3">
                        <div class="col-lg-{{ $tipo_vista === 'carga-academica' && $es_docente ? '8' : '12' }}">
                            <div class="card card-stacked animate__animated animate__fadeIn">
                                <div class="card-body p-0"
                                    style="{{ $silabus_pdf && file_exists($silabus_pdf->archivo_silabus) ? '' : 'height: 625px' }}">
                                    @if($cargando_silabus)
                                        <div class="d-flex justify-content-center align-items-center w-100 h-100">
                                            <div class="spinner-border text-primary"></div>
                                        </div>
                                    @else
                                        @if ($silabus_pdf && file_exists($silabus_pdf->archivo_silabus))
                                            <embed src="{{ asset($silabus_pdf->archivo_silabus) }}"
                                                class="rounded animate__animated animate__fadeIn  " type="application/pdf"
                                                width="100%" height="625px" />
                                        @else
                                            <div x-data="{ mostrarAlerta: true, salir: false }" x-show="mostrarAlerta"
                                                x-bind:class="salir ? 'animate__hinge' : 'animate__pulse animate__repeat-2 animate__delay-1s'"
                                                class="alert alert-yellow alert-dismissible animate__animated m-3 bg-yellow-lt"
                                                role="alert" style="display: none;">
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
                                                        <h4 class="alert-title">El sílabus no está disponible en este momento.
                                                        </h4>
                                                        <div class="text-yellow">
                                                            @if ($es_docente)
                                                            Por favor, sube el sílabus del curso para que los alumnos puedan
                                                            acceder a él.
                                                            @else
                                                            Por favor, verifica más tarde o contacta con el docente asignado
                                                            para más información.
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Botón de cerrar -->
                                                <a class="btn-close icon-rotate-custom"
                                                    @click="salir = true; setTimeout(() => mostrarAlerta = false, 2000);"></a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($tipo_vista === 'carga-academica' && $es_docente)
                        <div class="col-lg-4">
                            @if($cargando_datos_curso)
                            <div class="card card-stacked placeholder-glow">
                                <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
                                    <div class="placeholder col-5 {{ $tipo_vista === 'cursos' ? 'bg-teal' : 'bg-orange' }}"
                                        style="height: 1.5rem; width: 170.56px;"></div>
                                </div>
                                <div class="card-body row g-3 mb-0">
                                    <div class="d-flex flex-column gap-2">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 148.94px;">
                                                        </div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder bg-secondary"
                                                            style="height: 17px; width: 148.94px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 117.06px;">
                                                        </div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder bg-secondary"
                                                            style="height: 17px; width: 43.3px;"></div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 122.21px;">
                                                        </div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder col-12 bg-secondary"
                                                            style="height: 17px;">
                                                        </div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-start">
                                                <div class="row g-2">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder" style="height: 17px; width: 34.20px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder bg-secondary"
                                                            style="height: 17px; width: 15px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-center">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder" style="height: 17px; width: 57.86px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder bg-secondary"
                                                            style="height: 17px; width: 15px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 d-flex justify-content-end">
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder" style="height: 17px; width: 40.07px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <div class="placeholder bg-secondary"
                                                            style="height: 17px; width: 15px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="placeholder" style="height: 17px; width: 104.33px;">
                                                        </div>
                                                        <div class="col-12"></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="placeholder bg-secondary"
                                                            style="height: 17px; width: 64.44px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="card card-stacked animate__animated animate__fadeIn  ">
                                <div class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
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

                                            <hr class="mt-5 mb-2 hide-theme-dark">
                                            <hr class="mt-5 mb-2 hide-theme-light text-white">

                                            <div class="col-12">
                                                <label for="silabus" class="form-label required">
                                                    Subir Sílabus
                                                </label>
                                                <input type="file"
                                                    class="form-control @error('silabus') is-invalid @enderror"
                                                    id="silabus" wire:model.live="silabus" accept=".pdf" />
                                                @error('silabus')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                <small class="form-hint">
                                                    Solo se permiten archivos en formato PDF.
                                                </small>
                                                <small class="form-hint">
                                                    Máximo 4MB.
                                                </small>
                                            </div>
                                            <div class="col-12">
                                                <a class="btn btn-primary w-100 mt-3" style="cursor: pointer;"
                                                    wire:click="guardar_silabus">
                                                    <div wire:loading.remove>
                                                        <span>Guardar Sílabus</span>
                                                    </div>
                                                    <div wire:loading>
                                                        <div class="spinner-border spinner-border-sm" role="status">
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
