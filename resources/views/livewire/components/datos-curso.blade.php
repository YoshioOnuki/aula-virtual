<div class="mt-3" wire:init="load_datos_curso">
    @if($cargando_datos_curso)
        <div class="card card-stacked placeholder-glow animate__animated animate__fadeIn animate__faster">
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
                                    <div class="placeholder" style="height: 17px; width: 148.94px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 148.94px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 117.06px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 43.3px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 122.21px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder col-12 bg-secondary" style="height: 17px;"></div>
                                    <div class="col-12"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-start">
                            <div class="row g-2">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 34.20px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-center">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 57.86px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 d-flex justify-content-end">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder" style="height: 17px; width: 40.07px;"></div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 15px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="placeholder" style="height: 17px; width: 104.33px;"></div>
                                    <div class="col-12"></div>
                                </div>
                                <div class="col-12">
                                    <div class="placeholder bg-secondary" style="height: 17px; width: 64.44px;"></div>
                                </div>
                            </div>
                        </div>

                        @if($datos)
                            <div class="col-12">
                                <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-12 mt-1 mb-2" aria-hidden="true" style="height: 36px;"></a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card card-link card-stacked">
            <div
                class="card-header {{ $tipo_vista === 'cursos' ? 'bg-teal-lt' : 'bg-orange-lt' }}">
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
                                <a class="btn btn-primary w-100 mt-1
                                    {{ !$gestion_aula_usuario->gestionAula->linkClase ? 'disabled' : '' }}"
                                    style="cursor: pointer;" wire:click="mostrar_link_clase">
                                    Link de Clase
                                </a>
                                @if(!$gestion_aula_usuario->gestionAula->linkClase)
                                    <div class="alert alert-azure bg-azure-lt mt-2 fw-bold animate__animated animate__fadeIn animate__faster">
                                        @if($tipo_vista === 'carga-academica')
                                            Por favor, cargue el link de la clase para que esté disponible para los estudiantes.
                                        @else
                                            Link de la clase pendiente. Consulte con el docente.
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
        Livewire.on('redirectLink', link => {
            window.open(link, '_blank');
        });
    });
</script>
@endpush
