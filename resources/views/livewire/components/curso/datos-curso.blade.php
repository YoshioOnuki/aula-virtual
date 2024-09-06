<div>
    <div class="card card-link card-stacked animate__animated animate__fadeIn">
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

                    @if($datos)
                    <div class="col-12">
                        <div x-data="{
                            linkClase: '{{ $gestion_aula_usuario->gestionAula->linkClase ? $gestion_aula_usuario->gestionAula->linkClase->nombre_link_clase : '' }}',
                            handleClick() {
                                if (!this.linkClase) {
                                    this.$dispatch('toast-basico', {
                                        mensaje: 'El link de la clase no está disponible',
                                        type: 'error'
                                    });
                                } else {
                                    window.open(this.linkClase, '_blank');
                                }
                            }
                        }">
                            <a class="btn btn-primary w-100 mt-1" :class="{ 'disabled': !linkClase }"
                                @click="handleClick">
                                Link de Clase
                            </a>
                        </div>

                        @if(!$gestion_aula_usuario->gestionAula->linkClase)
                            <div x-data="{ mostrarAlerta: true, salir: false }"
                                x-show="mostrarAlerta"
                                x-bind:class="salir ? 'animate__hinge' : 'animate__pulse animate__repeat-2 animate__delay-1s'"
                                class="alert alert-azure bg-azure-lt mt-2 animate__animated alert-dismissible"
                                role="alert" style="display: none;">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                            <path d="M12 9h.01"></path>
                                            <path d="M11 12h1v4h1"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="alert-title">
                                            @if($tipo_vista === 'carga-academica')
                                                Por favor, cargue el link de la clase para que esté disponible para los estudiantes.
                                            @else
                                                Link de la clase pendiente. Consulte con el docente.
                                            @endif
                                        </h4>

                                    </div>
                                </div>
                                <!-- Botón de cerrar -->
                                <a class="btn-close icon-rotate-custom" @click="salir = true; setTimeout(() => mostrarAlerta = false, 2000);"></a>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
